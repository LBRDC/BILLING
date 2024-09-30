<?php
session_start();

include("./../conn.php");

ob_start();


// Custom Error Handler
set_error_handler(function ($errno, $errstr, $errfile, $errline) {
    ob_clean();

    echo "<p><b>SYSTEM ERROR</b> [<i>$errno</i>] $errstr in $errfile on line $errline<br /></p>";

    // Flush the output buffer and stop further script execution
    ob_flush();
    flush();
    exit();
});

// Enable error reporting
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

try {
    // Header
    include("includes/header.php");

    // Main Page
    if (!isset($_SESSION['user'])) {
        /* Redirect to login */
        echo '<div class="app-main__outer">';
    } else if (!isset($_GET['page'])) {
        include('includes/navbar.php');
        echo '<div class="app-main__outer">';
        include("pages/dashboard.php");
    } else {
        include('includes/navbar.php');

        echo '<div class="app-main__outer">';

        if (isset($_GET['page'])) {
            @$page = $_GET['page'];
            switch ($page) {
                case 'manage-project':
                    include("pages/manage-project.php");
                    break;
                case 'manage-employee':
                    include("pages/manage-employee.php");
                    break;
                case 'manage-billing':
                    include("pages/manage-billing.php");
                    break;
                case 'report-billing':
                    include("pages/report-billing.php");
                    break;
                case 'manage-admin':
                    if (!isset($_SESSION['user']['admin_super']) || $_SESSION['user']['admin_super'] == 1) {
                        include("pages/manage-admin.php");
                    } else {
                        include("pages/404.php");
                    }
                    break;
                case 'manage-admin-log':
                    if (!isset($_SESSION['user']['admin_super']) || $_SESSION['user']['admin_super'] == 1) {
                        include("pages/manage-admin-log.php");
                    } else {
                        include("pages/404.php");
                    }
                    break;
                default:
                    include("pages/404.php");
                    break;
            }
        }
    }

    // Footer
    include("includes/footer.php");
    include("includes/modals.php");

    // Modals
    if (!isset($_SESSION['user'])) {
        /* Redirect to login */
    } else if (!isset($_GET['page'])) {
        /* Dashboard Modal */
    } else {
        if (isset($_GET['page'])) {
            @$page = $_GET['page'];
            switch ($page) {
                case 'manage-project':
                    include("modals/mdl-manage-project.php");
                    break;
                case 'manage-employee':
                    include("modals/mdl-manage-employee.php");
                    break;
                case 'manage-billing':
                    include("modals/mdl-manage-billing.php");
                    break;
                case 'report-billing':
                    include("modals/mdl-report-billing.php");
                    break;
                case 'manage-admin':
                    if (!isset($_SESSION['user']['admin_super']) || $_SESSION['user']['admin_super'] == 1) {
                        include("modals/mdl-manage-admin.php");
                    }
                    break;
                case 'manage-admin-log':
                    if (!isset($_SESSION['user']['admin_super']) || $_SESSION['user']['admin_super'] == 1) {
                        include("modals/mdl-manage-admin-log.php");
                    }
                    break;
                default:
                    break;
            }
        }
    }
} catch (Exception $e) {
    ob_clean();
    echo "<p><b>SYSTEM ERROR</b> Exception caught: " . $e->getMessage() . "</p>";
    ob_flush();
    flush();
    exit();
}

ob_end_flush();