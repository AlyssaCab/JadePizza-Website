<!------------------------------------------------------------------
/* File: help-admin-users.php
/* Description: Help page describing to admins how to manage users.
/*------------------------------------------------------------------
/* Author: Alyssa Cabana
/*------------------------------------------------------------------>

<!------------------------------
/* Include shared page header
/*------------------------------>
<?php include("../includes/headers.php"); ?>    <!-- Outputs the page header/nav -->
<main class="about">
    <div class="about-card">
        <h2>Manage Users Help</h2>
        <p>
            The Manage Users page displays a list of all registered users and allows admins to monitor or remove accounts.
        </p>
        <p>
            For each user, you can view their user ID, username, and email. This page is for administrative oversight only and is not visible to regular users.
        </p>
        <p>
            If necessary, you can delete a user by clicking the delete button next to their profile. Use this feature responsibly, as deleting an account cannot be undone.
        </p>
    </div>
</main>

<!------------------------
/* Include shared footer
/*------------------------>
<?php include("../includes/footers.php"); ?>    <!-- Outputs the page footer and contact/support request -->