<?php
/*-------------------------------------------------------------
  File: admin-dashboard.php
  Description: Main admin panel for Jade Pizza
               Displays all admin tools in a card layout
---------------------------------------------------------------
  Author: Alyssa Cabana
-------------------------------------------------------------*/

session_start();

/*-------------------------------------------------------------
/* Redirect if user is not logged in
/*------------------------------------------------------------*/
if (!isset($_SESSION['logged_in']) || $_SESSION['role'] !== 'admin') {
    header("Location: /JadePizza/login.php");
    exit();
}
/*-------------------------
/* Include shared header
/*------------------------*/
include("../includes/headers.php"); // Outputs the page header/nav
?>

<main>
    <!----------------------------------------
    /* Help button linking to admin dashboard help
    /*---------------------------------------->
    <div class="help-link-container">
        <a href="../help/help-admin-dashboard.php" class="help-button" title="Need help with navigating the admin panel?">?</a>
    </div>

    <!-------------------------------
    /* Create admin dashboard cards
    /*------------------------------->
    <div class="dashboard">
        <h2>Welcome, <?= htmlspecialchars($_SESSION['username']); ?>!</h2>

        <!------------------------
        /* Manage Menu
        /*------------------------>
        <a href="manage-menu.php" class="dashboard-card">
            <img src="/JadePizza/images/menu.png" alt="Manage Menu">
            <p>Manage Menu</p>
        </a>

        <!------------------------
        /* Manage Deals
        /*------------------------>
        <a href="manage-deals.php" class="dashboard-card">
            <img src="/JadePizza/images/deals.png" alt="Manage Deals">
            <p>Manage Deals</p>
        </a>

        <!------------------------
        /* Switch Theme
        /*------------------------>
        <a href="theme-switcher.php" class="dashboard-card">
            <img src="/JadePizza/images/theme.png" alt="Switch themes">
            <p>Switch Themes</p>
        </a>

        <!------------------------
        /* Manage Users
        /*------------------------>
        <a href="manage-users.php" class="dashboard-card">
            <img src="/JadePizza/images/users.png" alt="Manage Users">
            <p>Manage Users</p>
        </a>

        <!------------------------
        /* Manage Support Requests
        /*------------------------>
        <a href="manage-support-request.php" class="dashboard-card">
            <img src="/JadePizza/images/support.png" alt="Manage Support Request">
            <p>Manage Support Request</p>
        </a>

        <!------------------------
        /* System Monitor
        /*------------------------>
        <a href="monitor.php" class="dashboard-card">
            <img src="/JadePizza/images/monitor.png" alt="System Monitor">
            <p>System Monitors</p>
        </a>

        <!------------------------
        /* Logout
        /*------------------------>
        <a href="/JadePizza/logout.php" class="dashboard-card">
            <img src="/JadePizza/images/logout.png" alt="Logout">
            <p>Logout</p>
        </a>
    </div>
</main>
<!------------------------
/* Include shared footer
/*------------------------>
<?php include("../includes/footers.php"); ?> <!-- Outputs the page footer and contact/support request -->