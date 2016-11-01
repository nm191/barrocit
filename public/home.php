<?php
/**
 * Created by PhpStorm.
 * User: Ronald Klaus
 * Date: 7-10-2016
 * Time: 11:58
 */

require_once ('includes/header.php');

require_once ('includes/menus.php');

$dashboard = new Dashboard();

?>
<div class="col-sm-10 col-sm-offset-1">
<?php
    echo $dashboard->getDashboardTable($user);
?>
        Main content goes here
</div>
<?php
require_once ('includes/footer.php');
?>
