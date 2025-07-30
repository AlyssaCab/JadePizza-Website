<?php
/*-------------------------------------------------------------
/* File: monitor.php
/* Description: Admin system status page. Displays checks for:
/*               - Database connection
/*               - Email function
/*               - Disk space usage
/*               - PHP version
/*-------------------------------------------------------------
/* Author: Alyssa Cabana
/*-------------------------------------------------------------*/

session_start();
/*------------------------------
/* Include shared page elements
/*------------------------------*/
include("../includes/headers.php"); // Outputs the page header/nav
require_once("../includes/database.php"); // Connects to the database

/*-------------------------------
  Check if database is connected
-------------------------------*/
function checkDatabase($conn) {
    return $conn->connect_error ? false : true;
}

/*------------------------------
  Check if email is enabled
--------------------------------*/
function checkEmail() {
    // NOTE: This does NOT actually send an email
    return function_exists('mail');
}

/*--------------------------------------
  Check server disk space and usage %
--------------------------------------*/
function checkDiskSpace() {
    $free = disk_free_space("/");
    $total = disk_total_space("/");
    if ($total === 0) return false;
    $usedPercent = 100 - (($free / $total) * 100);
    return round($usedPercent, 2);
}

/*-----------------------------------------------------------
  Gather system stats and display with user freindly icons
-----------------------------------------------------------*/
$dbStatus = checkDatabase($conn) ? "✅ Connected" : "❌ Connection Failed";
$emailStatus = checkEmail() ? "✅ Available" : "❌ Disabled";
$diskStatus = checkDiskSpace();
$phpVersion = phpversion();
?>

<main class="admin-panel">
    <h1>System Monitoring</h1>
    <div class="cart-table-container">
        <table class="cart-table">
            <thead>
                <tr><th>Service</th><th>Status</th></tr>
            </thead>
            <tbody>
                <tr><td>Database</td><td><?= $dbStatus ?></td></tr>
                <tr><td>Email</td><td><?= $emailStatus ?></td></tr>
                <tr><td>Disk Usage</td><td><?= is_numeric($diskStatus) ? (100 - $diskStatus) . "% free" : "❌ Error" ?></td></tr>
                <tr><td>PHP Version</td><td><?= $phpVersion ?></td></tr>
            </tbody>
        </table>
    </div>
</main>
<!------------------------
/* Include shared footer
/*------------------------>
<?php include '../includes/footers.php'; ?> <!-- Outputs the page footer and contact/support request -->
