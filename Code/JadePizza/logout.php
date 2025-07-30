<?php
/*-------------------------------------------------------------
/* File: logout.php
/* Description: Ends the session and redirects to login
/*-------------------------------------------------------------
/* Author: Alyssa Cabana
/*-------------------------------------------------------------*/

session_start();            // Start session handling
session_unset();            // Unset all session variables
session_destroy();          // Destroy the session completely

/*-------------------------------
/* Redirect to login page
/*-------------------------------*/
header("Location: /JadePizza/login.php");
exit();