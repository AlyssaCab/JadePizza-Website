<!------------------------------------------------------------------
/* File: help-admin-menu.php
/* Description: Help page describing to admins how to manage menu.
/*------------------------------------------------------------------
/* Author: Alyssa Cabana
/*------------------------------------------------------------------>

<!------------------------------
/* Include shared page header
/*------------------------------>
<?php include("../includes/headers.php"); ?>    <!-- Outputs the page header/nav -->
<main class="about">
    <div class="about-card">
        <h2>Manage Menu Help</h2>
        <p>
            The Manage Menu page allows admins to add, view, and delete items on the main menu.
        </p>
        <p>
            To add a new item, fill out the form at the bottom of the page. You’ll need to provide a name, description, category (Pizza, Drink, or Side), an image path, and select size options.
        </p>
        <p>
            Each size selected will require a corresponding price. Only valid sizes can be used for each category (e.g., Pizzas use Small, Medium, Large; Drinks use Can).
        </p>
        <p>
            You can also check the box at the very bottom, labeled "Mark as Special," if you would like the item to be highligted as a special item on the home page.
        </p>
        <p>
            Once submitted, the item will appear on the menu immediately. You can remove any existing item by clicking the delete button next to it.
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