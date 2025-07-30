<!--------------------------------------------------------------------------------------------
/* File: help-admin-support.php
/* Description: Help page describing to admins how to view and respond to support requests.
/*--------------------------------------------------------------------------------------------
/* Author: Alyssa Cabana
/*-------------------------------------------------------------------------------------------->

<!------------------------------
/* Include shared page header
/*------------------------------>
<?php include("../includes/headers.php"); ?>    <!-- Outputs the page header/nav -->
<main class="about">
    <div class="about-card">
        <h2>Manage Support Requests Help</h2>
        <p>
            The Manage Support page allows admins to view and manage messages sent by users through the contact form.
        </p>
        <p>
            Each request shows the user's id, subject, message content, and the date it was submitted. Admins can use this page to respond to users support requests by filling in the response text box and clicking the "Send Response" button.
        </p>
        <p>
            To delete a support request, click the delete button next to the entry. This will permanently remove the message from the system.
        </p>
    </div>
</main>

<!------------------------
/* Include shared footer
/*------------------------>
<?php include("../includes/footers.php"); ?>    <!-- Outputs the page footer and contact/support request -->