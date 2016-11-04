<?php

/**
 * Created by PhpStorm.
 * User: Nick
 * Date: 2-11-2016
 * Time: 09:10
 */
class Notifications
{
    private $db;
    private $admin;

    public function __construct()
    {
        $this->db = Database::getInstance();
        $this->admin = new Admin();
    }

    public function addNotification($for_section_id, $user_id, $notification_text){
        $for_users_ar = $this->admin->getUserToUserRights($for_section_id);
        $current_date = date('Y-m-d');

        foreach($for_users_ar as $for_user_id){
            if($for_user_id == $user_id){
                continue;
            }
            $sql = 'INSERT INTO `tbl_notifications` (notification_from_user_id, notification_for_user_id, notification_text, notification_date) 
                    VALUES (:notification_from, :notification_for, :notification_text, :notification_date)';
            $stmt = $this->db->pdo->prepare($sql);
            $stmt->bindParam(':notification_from', $user_id);
            $stmt->bindParam(':notification_for', $for_user_id);
            $stmt->bindParam(':notification_text', $notification_text);
            $stmt->bindParam(':notification_date', $current_date);
            $stmt->execute();
        }
        return true;
    }

    private function getNotificationsForUser($user_id, $only_unseen = false, $limit = 0){
        $sql = 'SELECT u.username as from_user ,n.* 
                FROM `tbl_notifications` n
                INNER JOIN `tbl_users` u
                ON n.notification_from_user_id = u.user_id
                WHERE n.notification_for_user_id = :user_id';
        if($only_unseen){
            $sql .= ' AND n.notification_seen = 0';
        }
        $sql .= ' ORDER BY n.notification_seen, n.notification_id DESC';
        if($limit){
            $sql .= ' LIMIT '.$limit;
        }

        $stmt = $this->db->pdo->prepare($sql);
        $stmt->bindParam(':user_id', $user_id);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_OBJ);

        return $result;
    }

    private function getNotificationByID($id){
        $sql = 'SELECT u.username as from_user, n.* 
                FROM `tbl_notifications` n
                INNER JOIN `tbl_users` u
                ON n.notification_from_user_id = u.user_id
                WHERE n.notification_id = :id';
        $stmt = $this->db->pdo->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_OBJ);

        return $result;
    }

    public function getNotificationsList($user_id){
        $notifications_ar = $this->getNotificationsForUser($user_id, true, 10);
        $return_ar = array();
        foreach($notifications_ar as $notification){
            $return_ar[] = '<li><a href="notifications.php?nid='.$notification->notification_id.'">'.$notification->notification_text.'</a></li>';
        }
        if(!$return_ar){
            return '<li><a href="#">No new notifications</a></li>';
        }
        return implode('', $return_ar);
    }

    public function getNotificationsCount($user_id, $only_unseen = false){
        $sql = 'SELECT COUNT(*) as count FROM `tbl_notifications` WHERE notification_for_user_id = :user_id';
        if($only_unseen){
            $sql .= ' AND notification_seen = 0';
        }
        $stmt = $this->db->pdo->prepare($sql);
        $stmt->bindParam(':user_id', $user_id);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_OBJ);

        return $result->count;
    }

    public function getNotificationsTable($user_id){
        $notifications_ar = $this->getNotificationsForUser($user_id);

        if(!$notifications_ar){
            return '<h3 class="text-center">No Notifications found</h3>';
        }

        foreach($notifications_ar as $note){
            $options_ar = $td_ar = array();

            $options_ar[] = '<a href="notifications.php?nid='.$note->notification_id.'" class="btn btn-small btn-primary btn-options" title="View notification: '.$note->notification_id.'"><span class="glyphicon glyphicon-eye-open"></span></a>';

            $td_ar[] = '<td>'.$note->notification_id.'</td>';
            $td_ar[] = '<td>'.$note->from_user.'</td>';
            $td_ar[] = '<td>'.$note->notification_text.'</td>';
            $td_ar[] = '<td>'.($note->notification_seen ? 'Yes' : 'No').'</td>';
            $td_ar[] = '<td>'.implode('', $options_ar).'</td>';

            $tr_ar[] = '<tr>'.implode($td_ar).'</tr>';
        }

        $th_ar[] = '<th>ID</th>';
        $th_ar[] = '<th>From</th>';
        $th_ar[] = '<th>Notification</th>';
        $th_ar[] = '<th>Seen?</th>';
        $th_ar[] = '<th>Options</th>';

        $return_ar[] = '<table class="table table-responsive table-hover table-striped">';
        $return_ar[] = '<thead>'.implode('', $th_ar).'</thead>';
        $return_ar[] = implode('', $tr_ar);
        $return_ar[] = '</table>';

        return implode('', $return_ar);
    }

    public function getSingleNotificationsTable($note_id){
        $notification = $this->getNotificationByID($note_id);
        if(!$notification){
            return '<h3 class="text-center">No notification found!</h3>';
        }

        if(!$notification->notification_seen){
            $this->setNotificationSeen($note_id);
        }

        $return_ar[] = '<h3>Notification</h3>';
        $return_ar[] = '<table class="table table-responsive table-striped table-hover">';
        $return_ar[] = '<tr><td>ID</td><td>'.$note_id.'</td></tr>';
        $return_ar[] = '<tr><td>From</td><td>'.$notification->from_user.'</td></tr>';
        $return_ar[] = '<tr><td>Notification</td><td>'.$notification->notification_text.'</td></tr>';
        $return_ar[] = '</table>';

        return implode('', $return_ar);
    }

    private function setNotificationSeen($note_id){
        $sql = 'UPDATE `tbl_notifications` SET notification_seen = 1 WHERE notification_id = :note_id';
        $stmt = $this->db->pdo->prepare($sql);
        $stmt->bindParam(':note_id', $note_id);
        return $stmt->execute();
    }

}