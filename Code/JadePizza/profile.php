<?php
/*-----------------------------------------------------------------------
/* File: profile.php
/* Description: Displays logged-in user's profile info
/*              Shows username, role, and links to user-specific pages.
/*-----------------------------------------------------------------------
/* Author: Alyssa Cabana
/*-----------------------------------------------------------------------*/

session_start();

/*------------------------------
/* Block access if not logged in
/*------------------------------*/
if (!isset($_SESSION['logged_in'])) {
    header("Location: login.php");
    exit();
}
?>

<!------------------------------
/* Include shared page header
/*------------------------------>
<?php include("includes/headers.php"); ?> <!-- Outputs the page header/nav -->

<main>
    <!------------------------------
    /* Help link for profile page
    /*------------------------------>
    <div class="help-link-container">
        <a href="help/help-profile.php" class="help-button" title="Need help with your profile?">?</a>
    </div>

    <div class="login-card">
        <!----------------------------------------
        /* Display welcome message and user role
        /*---------------------------------------->
        <h2>Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?>!</h2>
        <p>This is your <?php echo $_SESSION['role'] === 'admin' ? 'admin' : 'user'; ?> profile page.</p>

        <?php if ($_SESSION['role'] === 'user'): ?>
            <!---------------------------
            /* Order History button
            /*--------------------------->
            <form action="order-history.php" method="get" style="margin-top: 1rem;">
                <button type="submit" class="button full-width">View Order History</button>
            </form>

            <!----------------------------
            /* Support History button
            /*---------------------------->
            <form action="support-history.php" method="get" style="margin-top: 1rem;">
                <button type="submit" class="button full-width">View Support Request History</button>
            </form>
        <?php endif; ?>
    </div>
</main>

<!------------------------
/* Include shared footer
/*------------------------>
<?php include("includes/footers.php"); ?>   <!-- Outputs the page footer and contact/support request -->
