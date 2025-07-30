<!------------------------------------------------------------------
/* File: help-admin-deals.php
/* Description: Help page describing to admins how to manage deals.
/*------------------------------------------------------------------
/* Author: Alyssa Cabana
/*------------------------------------------------------------------>

<!------------------------------
/* Include shared page header
/*------------------------------>
<?php include("../includes/headers.php"); ?>    <!-- Outputs the page header/nav -->
<main class="about">
    <div class="about-card">
        <h2>Manage Deals Help</h2>
        <p>
            The Manage Deals page allows admins to create and remove promotional deals.
        </p>
        <p>
            To create a deal, fill out the bottom form with the deal name, description, image path, and flat price. You must also define one or more deal requirements using the dropdowns below.
        </p>
        <p>
            Each requirement must include a category, and quantity required. Size and specific Item Name are optional. The system will automatically check the cart for these requirements before applying the deal.
        </p>
        <p>
            Once submitted, the deal will appear on the menu and can be applied by users during checkout. To remove a deal, click the delete button next to it.
        </p>
        <p>
            Note: Please make sure that you have the image file path in the images folder of the code, and follow the images/example.png format. (.png can be replaced by whatever file type you add)
        </p>
    </div>
</main>

<!------------------------
/* Include shared footer
/*------------------------>
<?php include("../includes/footers.php"); ?>    <!-- Outputs the page footer and contact/support request -->