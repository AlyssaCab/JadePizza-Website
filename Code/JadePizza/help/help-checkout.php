<!-------------------------------------------------------------
/* File: help-checkout.php
/* Description: Help page describing how to fill out the checkout.
/*-------------------------------------------------------------
/* Author: Alyssa Cabana
/*------------------------------------------------------------->

<!------------------------------
/* Include shared page header
/*------------------------------>
<?php include("../includes/headers.php"); ?>    <!-- Outputs the page header/nav -->
<main class="about">
    <div class="about-card">
        <h2>Checkout Help</h2>
        <p>
            The checkout page is where you complete your order after you've finished building your cart.
        </p>
        <p>
            At the top, you'll see an order summary, similar to the cart, that shows you the final total. If you'd like to make changes, you can click the "Back to Cart" button.
        </p>
        <p>
            Next, you’ll be asked to enter your customer information and choose whether you’d like pickup or delivery. If you choose delivery, additional fields will appear for your address, postal code, province, and country.
        </p>
        <p>
            Once your personal and delivery information is filled out, scroll down to enter your payment information. You’ll need to provide your card number, expiry date, and CVV code. <strong>Please note: this is a fake site and please don't input your real information.</strong>
        </p>
        <p>
            After reviewing your details, click the "Place Order" button at the bottom of the page. If all required fields are filled out correctly, your order will be submitted and a receipt page will appear.
        </p>
        <p>
            If any required information is missing or invalid, you’ll be asked to correct it before continuing.
        </p>
    </div>
</main>

<!------------------------
/* Include shared footer
/*------------------------>
<?php include("../includes/footers.php"); ?>    <!-- Outputs the page footer and contact/support request -->
