<?php
/**
 * Created by PhpStorm.
 * User: Ronald Klaus
 * Date: 10-10-2016
 * Time: 12:19
 */

?>

<div class="container-fluid">

    <header>

    <nav class="navbar navbar-default">
        <div class="container-fluid">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="#">Barroc IT.</a>
            </div>

            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav">
                    <li><a href="#">Add customer <span class="sr-only">(current)</span></a></li>
                    <li><a href="#">Add Project</a></li>
                    <li><a href="#">Add Invoice</a></li>
                    <li><a href="#">Helpdesk</a></li>


                </ul>
                <ul class="nav navbar-nav navbar-right">
                    <li class="dropdown notification-btn">
                        <a href="#" class="dropdown-toggle a-main btn btn-primary" data-toggle="dropdown" role="button" aria-expanded="false">
    Notifications <span class="badge">4</span>
                            </a>
                        <ul class="dropdown-menu" role="menu">
                            <li><a href="#">Action</a></li>
                            <li><a href="#">Another action</a></li>
                            <li><a href="#">Something else here</a></li>
                            <li class="divider"></li>
                            <li><a href="#">Separated link</a></li>
                            <li class="divider"></li>
                            <li><a href="#">One more separated link</a></li>
                        </ul>
                    </li>
                    <li><span class="logged-in-as">Logged in as admin</span></li>
                    <li><a class="btn btn-danger logout" href="#">Log Out!</a></li>
                </ul>
            </div>
        </div>
    </nav>


</header>

<div class="row">
    <div class="col-sm-2">
        <div class="sidebar-nav">
            <div class="navbar navbar-default" role="navigation">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".sidebar-navbar-collapse">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <span class="visible-xs navbar-brand">Sidebar menu</span>
                </div>
                <div class="navbar-collapse collapse sidebar-navbar-collapse">
                    <ul class="nav navbar-nav">
                        <li class="active"><a href="#">Home</a></li>
                        <li>
                            <a href="#" data-toggle="collapse" data-target="#toggleProjects" data-parent="#sidenav01" class="collapsed">
                                </span> Projects <span class="caret pull-right"></span>
                            </a>
                            <div class="collapse" id="toggleProjects" style="height: 0px;">
                                <ul class="nav nav-list">
                                    <li><a href="#">Project list</a></li>
                                    <li><a href="#">Add project</a></li>
                                </ul>
                            </div>
                        </li>
                        <li>
                            <a href="#" data-toggle="collapse" data-target="#toggleCustomers" data-parent="#sidenav01" class="collapsed">
                               </span> Customers <span class="caret pull-right"></span>
                            </a>
                            <div class="collapse" id="toggleCustomers" style="height: 0px;">
                                <ul class="nav nav-list">
                                    <li><a href="#">Customers list</a></li>
                                    <li><a href="#">Add customer</a></li>
                                </ul>
                            </div>
                        </li>
                        <li>
                            <a href="#" data-toggle="collapse" data-target="#toggleFinance" data-parent="#sidenav01" class="collapsed">
Finance <span class="caret pull-right"></span>
                            </a>
                            <div class="collapse" id="toggleFinance" style="height: 0px;">
                                <ul class="nav nav-list">
                                    <li><a href="#">Invoice list</a></li>
                                    <li><a href="#">Add invoice</a></li>
                                </ul>
                            </div>
                        </li>
                        <li>
                            <a href="#" data-toggle="collapse" data-target="#toggleAdmin" data-parent="#sidenav01" class="collapsed">
                                </span> Admin <span class="caret pull-right"></span>
                            </a>
                            <div class="collapse" id="toggleAdmin" style="height: 0px;">
                                <ul class="nav nav-list">
                                    <li><a href="#">Users</a></li>
                                    <li><a href="admin.php?page=add_user">Add User</a></li>
                                </ul>
                            </div>
                        </li>
                    </ul>
                </div><!--/.nav-collapse -->
            </div>
        </div>
    </div>
    <div class="col-sm-10">