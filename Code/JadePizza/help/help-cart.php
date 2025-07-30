<!-------------------------------------------------------------
/* File: help-cart.php
/* Description: Help page describing how to use the cart.
/*-------------------------------------------------------------
/* Author: Alyssa Cabana
/*------------------------------------------------------------->

<!------------------------------
/* Include shared page header
/*------------------------------>
<?php include("../includes/headers.php"); ?>    <!-- Outputs the page header/nav -->
<main class="about">
    <div class="about-card">
        <h2>Cart Help</h2>
        <p>
            In your cart you can see the items you've selected from the menu, including the price per item, quantity, and subtotal.
        </p>
        <p>
            You can also see any deal you've selected and whether it's currently reducing the total cost.
        </p>
        <p>
            To remove an item, check the remove box beside it and click the "Save Changes" button.
        </p>
        <p>
            To increase or decrease the quantity of an item, either type in the quantity box or use the arrow controls. Once updated, click the "Save Changes" button again to apply the changes.
        </p>
        <p>
            If you'd like to start over, click the "Clear Cart" button to remove all items.
        </p>
        <p>
            Once you're satisfied with your cart, click the "Proceed to Checkout" button to continue to the checkout page.
        </p>
    </div>
</main>

<!------------------------
/* Include shared footer
/*------------------------>
<?php include("../includes/footers.php"); ?>    <!-- Outputs the page footer and contact/support request -->
