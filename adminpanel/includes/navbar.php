<?php
    // Active Page
  if (!isset($_GET['page'])) {
    $activePage = 'home';
    //$page = 'null';
  } else {
    $activePage = $_GET['page'];
    /*switch ($activePage) {
      case 'employee-manage':
        $page = 'employee';
        break;
      case 'timekeep-record':
        $page = 'timekeep';
        break;
      case 'timekeep-report':
        $page = 'timekeep';
        break;
      case 'fields-department':
        $page = 'fields';
        break;
      case 'fields-position':
        $page = 'fields';
        break;
      case 'fields-payroll':
        $page = 'fields';
        break;
      case 'fields-location':
        $page = 'fields';
        break;
        case 'fields-location-add':
          $page = 'fields';
          break;
      case 'fields-schedule':
        $page = 'fields';
        break;
      case 'fields-holiday':
        $page = 'fields';
        break;
      case 'adminMng-user':
        $page = 'adminMng';
        break;
      default:
          // None
          break;
    }*/
  }
  //class="mm-active"
?>

<!-- #START# navbar.php -->
        <!-- NAVBAR MAIN -->
        <div class="app-header header-shadow">
            <div class="app-header__logo">
                <div class="logo-src"></div>
                <div class="header__pane ml-auto">
                    <div>
                        <button type="button" class="hamburger close-sidebar-btn hamburger--elastic" data-class="closed-sidebar">
                            <span class="hamburger-box">
                                <span class="hamburger-inner"></span>
                            </span>
                        </button>
                    </div>
                </div>
            </div>
            <div class="app-header__mobile-menu">
                <div>
                    <button type="button" class="hamburger hamburger--elastic mobile-toggle-nav">
                        <span class="hamburger-box">
                            <span class="hamburger-inner"></span>
                        </span>
                    </button>
                </div>
            </div>
            <div class="app-header__menu">
                <span>
                    <button type="button" class="btn-icon btn-icon-only btn btn-primary btn-sm mobile-toggle-header-nav">
                        <span class="btn-icon-wrapper">
                            <i class="fa fa-ellipsis-v fa-w-6"></i>
                        </span>
                    </button>
                </span>
            </div>    
            <div class="app-header__content">
                <div class="app-header-left">
                    <div>
                        <span class="font-weight-bold text-lbpgreen">Billing Management System</span>
                    </div>
                    <!--<div class="search-wrapper">
                        <div class="input-holder">
                            <input type="text" class="search-input" placeholder="Type to search">
                            <button class="search-icon"><span></span></button>
                        </div>
                        <button class="close"></button>
                    </div>
                    <ul class="header-menu nav">
                        <li class="nav-item">
                            <a href="javascript:void(0);" class="nav-link">
                                <i class="nav-link-icon fa fa-database"> </i>
                                Statistics
                            </a>
                        </li>
                        <li class="btn-group nav-item">
                            <a href="javascript:void(0);" class="nav-link">
                                <i class="nav-link-icon fa fa-edit"></i>
                                Projects
                            </a>
                        </li>
                        <li class="dropdown nav-item">
                            <a href="javascript:void(0);" class="nav-link">
                                <i class="nav-link-icon fa fa-cog"></i>
                                Settings
                            </a>
                        </li>
                    </ul>-->
                </div>
                <div class="app-header-right">
                    <div class="header-btn-lg pr-0">
                        <div class="widget-content p-0">
                            <div class="widget-content-wrapper">
                                <div class="widget-content-left  ml-3 mr-2 header-user-info">
                                    <div class="widget-heading">
                                        <?php if (isset($_SESSION['user']['admin_fname']) && isset($_SESSION['user']['admin_lname'])) {echo $_SESSION['user']['admin_fname']; echo ' '; echo $_SESSION['user']['admin_lname'];} else {echo 'LBRDC';} ?>
                                    </div>
                                    <div class="widget-subheading">
                                        <?php if (isset($_SESSION['user']['admin_pos'])) {echo $_SESSION['user']['admin_pos'];} else {echo 'Administrator';} ?>
                                    </div>
                                </div>
                                <div class="widget-content-left">
                                    <div class="btn-group">
                                        <a data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="p-0 btn">
                                            <img width="42" class="rounded-circle" src="../../asset/img/avatars/default_admin.webp" alt="">
                                            <i class="fa fa-angle-down ml-2 opacity-8"></i>
                                        </a>
                                        <div tabindex="-1" role="menu" aria-hidden="true" class="dropdown-menu dropdown-menu-right">
                                            <button type="button" tabindex="0" class="dropdown-item">User Account</button>
                                            <div tabindex="-1" class="dropdown-divider"></div>
                                            <button type="button" tabindex="0" class="dropdown-item" data-toggle="modal" data-target="#mdlLogout">Logout</button>
                                        </div>
                                    </div>
                                </div>
                                <!--<div class="widget-content-right header-user-info ml-3">
                                    <button type="button" class="btn-shadow p-1 btn btn-primary btn-sm show-toastr-example">
                                        <i class="fa text-white fa-calendar pr-1 pl-1"></i>
                                    </button>
                                </div>-->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div> <!-- #END# NAVBAR MAIN -->  

        <!-- ########## UI-THEME HERE ########## -->
        <?php include("ui-theme.php") ?>

        <div class="app-main">
            <!-- MAIN SIDEBAR -->
            <div class="app-sidebar sidebar-shadow">
                <div class="app-header__logo">
                    <div class="logo-src"></div>
                    <div class="header__pane ml-auto">
                        <div>
                            <button type="button" class="hamburger close-sidebar-btn hamburger--elastic" data-class="closed-sidebar">
                                <span class="hamburger-box">
                                    <span class="hamburger-inner"></span>
                                </span>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="app-header__mobile-menu">
                    <div>
                        <button type="button" class="hamburger hamburger--elastic mobile-toggle-nav">
                            <span class="hamburger-box">
                                <span class="hamburger-inner"></span>
                            </span>
                        </button>
                    </div>
                </div>
                <div class="app-header__menu">
                    <span>
                        <button type="button" class="btn-icon btn-icon-only btn btn-primary btn-sm mobile-toggle-header-nav">
                            <span class="btn-icon-wrapper">
                                <i class="fa fa-ellipsis-v fa-w-6"></i>
                            </span>
                        </button>
                    </span>
                </div>
                <div class="scrollbar-sidebar">
                    <div class="app-sidebar__inner">
                        <ul class="vertical-nav-menu">
                            <li class="app-sidebar__heading"></li>
                            <li>
                                <a href="home.php" class="<?php if($activePage=="home"){echo"mm-active";} ?>">
                                    <i class="metismenu-icon pe-7s-home"></i>
                                    Dashboard
                                </a>
                            </li>
                            <li class="app-sidebar__heading">Project Management</li>
                            <li>
                                <a href="?page=manage-project" class="<?php if($activePage=="manage-project"){echo"mm-active";} ?>">
                                    <i class="metismenu-icon pe-7s-culture"></i>
                                    Project List
                                </a>
                            </li>
                            <li>
                                <a href="?page=manage-employee" class="<?php if($activePage=="manage-employee"){echo"mm-active";} ?>">
                                    <i class="metismenu-icon pe-7s-users"></i>
                                    Employee List
                                </a>
                            </li>
                            <li class="app-sidebar__heading">Billing Management</li>
                            <li>
                                <a href="?page=manage-billing" class="<?php if($activePage=="manage-billing"){echo"mm-active";} ?>">
                                    <i class="metismenu-icon pe-7s-news-paper"></i>
                                    Billing List
                                </a>
                            </li>
                            <!--<li class="app-sidebar__heading">Examinee Management</li>
                            <li>
                                <a href="?page=manage-examinee" class="<?php //if($activePage=="manage-examinee"){echo"mm-active";} ?>">
                                    <i class="metismenu-icon pe-7s-users">
                                    </i>Examinee List
                                </a>
                            </li>-->
                            <li class="app-sidebar__heading">Report</li>
                            <!--<li>
                                <a href="?page=report-ranking" class="<?php //if($activePage=="report-ranking"){echo"mm-active";} ?>">
                                    <i class="metismenu-icon pe-7s-medal">
                                    </i>Ranking by Exam
                                </a>
                            </li>-->
                            <li>
                                <a href="?page=report-billing" class="<?php if($activePage=="report-billing"){echo"mm-active";} ?>">
                                    <i class="metismenu-icon pe-7s-note2">
                                    </i>Billing Report
                                </a>
                            </li>
                            <!--<li class="app-sidebar__heading">Feedback</li>
                            <li>
                                <a href="?page=feedback" class="<?php //if($activePage=="feedback"){echo"mm-active";} ?>">
                                    <i class="metismenu-icon pe-7s-comment">
                                    </i>Feedbacks
                                </a>
                            </li>-->
                            <!--<li class="app-sidebar__heading">Page Management</li>
                            <li>
                                <a href="?page=page-message" class="<?php //if($activePage=="page-message"){echo"mm-active";} ?>">
                                    <i class="metismenu-icon pe-7s-speaker">
                                    </i>Messsages
                                </a>
                            </li>-->
                            <?php if(!isset($_SESSION['user']['admin_super']) || $_SESSION['user']['admin_super'] == 1) { ?>
                            <li class="app-sidebar__heading">Admin Management</li>
                            <li>
                                <a href="?page=manage-admin" class="<?php if($activePage=="manage-admin"){echo"mm-active";} ?>">
                                    <i class="metismenu-icon pe-7s-key">
                                    </i>User Accounts
                                </a>
                            </li>
                            <li>
                                <a href="?page=manage-admin-log" class="<?php if($activePage=="manage-admin-log"){echo"mm-active";} ?>">
                                    <i class="metismenu-icon pe-7s-note">
                                    </i>Edit Logs
                                </a>
                            </li>
                            <?php } ?>
                            <li class="app-sidebar__heading"><hr class="sidebar-divider"></li>
                            <li style="padding-right: 139px;">
                                <a href="javascript:void(0);" class="m-0 p-0 text-monospace text-primary" data-toggle="modal" data-target="#mdlSystemInfo">
                                    <u>v0.1.0-alpha</u>
                                </a>
                            </li>
                        </ul>
                        <!--<hr class="sidebar-divider">
                        <div class="text-muted text-monospace"><a href="javascript:void(0);" data-toggle="modal" data-target="#mdlSystemInfo">v0.3.0-alpha</a></div>-->
                    </div>
                </div>
            </div><!-- #END# SIDEBAR -->
<!-- #END# navbar.php -->
