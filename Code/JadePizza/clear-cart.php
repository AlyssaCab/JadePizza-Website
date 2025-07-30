<?php
/*-------------------------------------------------------
/* File: clear-cart.php
/* Description: Clears the shopping cart and applied deal,
/*              sets a confirmation message, and redirects.
/*-------------------------------------------------------*/
/*-------------------------------------------------------------
/* File: clear-cart.php
/* Description: Clears the shopping cart and applied deal,
/*              sets a confirmation message, and redirects
/*-------------------------------------------------------------
/* Author: Alyssa Cabana
/*-------------------------------------------------------------*/

session_start();

/*-------------------------------
/* Clear cart and deal session
/*-------------------------------*/
unset($_SESSION['cart']);
unset($_SESSION['applied_deal_id']);

/*-------------------------------
/* Set success message
/*-------------------------------*/
$_SESSION['cart_message'] = "Cart cleared successfully.";

/*-------------------------------
/* Redirect to cart page
/*-------------------------------*/
header("Location: cart.php");
exit;
