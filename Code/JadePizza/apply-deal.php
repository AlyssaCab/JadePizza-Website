<?php
/*-------------------------------------------------------------
/* File: apply-deal.php
/* Description: Applies deals if a deal wasn't already applied
/*-------------------------------------------------------------
/* Author: Alyssa Cabana
/*-------------------------------------------------------------*/
session_start(); 

/*------------------------------
/* Check if a deal was submitted
/*------------------------------*/
if (isset($_POST['deal_id'])) {


    /*----------------------------------------------------------------------
    /* If a deal is already applied, prevent it from applying again
    /*----------------------------------------------------------------------*/
    if (isset($_SESSION['applied_deal_id'])) {
        $_SESSION['deal_message'] = "⚠️ You can only use one deal at a time. Please remove the current deal in your cart to apply a new one.";
        header("Location: menu.php");
        exit;
    } else {
        /*------------------------------
        /* Apply the new deal
        /*------------------------------*/
        $_SESSION['applied_deal_id'] = (int)$_POST['deal_id'];
        $_SESSION['deal_message'] = "Deal applied! Check your cart to see if it qualifies.";
    }
}

/*------------------------------
/* Redirect back to the menu
/*------------------------------*/
header("Location: menu.php?added=1");
exit;