<!-------------------------------------------------------------------------------
/* File: help-admin-dashboard.php
/* Description: Help page describing to admins how to navigate the dashboard.
/*-------------------------------------------------------------------------------
/* Author: Alyssa Cabana
/*------------------------------------------------------------------------------->

<!------------------------------
/* Include shared page header
/*------------------------------>
<?php include("../includes/headers.php"); ?>    <!-- Outputs the page header/nav -->
<main class="about">
    <div class="about-card">
        <h2>Admin Dashboard Help</h2>
        <p>
            The admin dashboard is available only to administrators and allows full control over the site’s management features.
        </p>
        <p>
            From the dashboard, you can access tools to manage menu items, add or remove deals, view and remove users, and monitor support requests from users.
        </p>
        <p>
            You can view and delete user accounts from the "Manage Users" section. This includes seeing each user's information such as their User ID, Username, and email.
        </p>
        <p>
            The "Manage Menu" section lets you add new items to the menu, including name, description, image, category, and size options with their pricing. You can also delete existing menu items.
        </p>
        <p>
            The "Manage Deals" section lets you create new deals, define deal requirements, and remove deals when needed.
        </p>
        <p>
            The "Manage Support Requests" section shows all messages submitted by users through the contact page. You can review and delete support messages as needed.
        </p>
        <p>
            Admins can also access the "System Monitors" page to check the status of services like the database and email functionality.
        </p>
    </div>
</main>

<!------------------------
/* Include shared footer
/*------------------------>
<?php include("../includes/footers.php"); ?>    <!-- Outputs the page footer and contact/support request -->