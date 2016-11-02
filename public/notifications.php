<?php
/**
 * Created by PhpStorm.
 * User: Nick
 * Date: 2-11-2016
 * Time: 10:01
 */
require_once ('includes/header.php');

require_once ('includes/menus.php');

$nid = 0;
if(isset($_GET['nid'])){
    $nid = $_GET['nid'];
}

$current_page = 'all_notifications';

if($nid){
    $current_page = 'single_notification';
}
?>
<div class="col-sm-10 col-sm-offset-1">
    <?php
        switch($current_page){
            case 'all_notifications':
                echo '<h2 class="text-center">Notifications</h2>';
                echo $notification->getNotificationsTable($user->getUserID());
                break;
            case 'single_notification':
                echo '<div class="well well-lg">';
                echo $notification->getSingleNotificationsTable($nid);
                echo '</div>';
                break;
        }
    ?>
</div>
<?php
require_once ('includes/footer.php');
?>
