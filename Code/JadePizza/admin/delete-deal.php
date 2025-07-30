<?php
/*-------------------------------------------------------------
/* File: delete-user.php
/* Description:  Processes admin request to delete deals
/*-------------------------------------------------------------
/* Author: Alyssa Cabana
/*-------------------------------------------------------------*/

session_start();
/*-------------------------
/* Include shared database
/*------------------------*/
require_once '../includes/database.php'; // Connects to the database

/*----------------------------------------------------
/* Ensure only admins can access this page
/*---------------------------------------------------*/
if (!isset($_SESSION['logged_in']) || $_SESSION['role'] !== 'admin') {
    header("Location: /JadePizza/login.php");
    exit();
}

/*----------------------------------------------------
/* Get menu item ID associated with the deal
/*---------------------------------------------------*/
$id = (int) $_POST['id'];

/*----------------------------------------------------
/* Find matching deal ID from menu_items
/*---------------------------------------------------*/
$deal_result = $conn->query("SELECT id FROM deals WHERE menu_item_id = $id");
$deal = $deal_result->fetch_assoc();
$deal_id = $deal['id'] ?? null;

if ($deal_id !== null) { 
    /*----------------------------------------------------
    /* Remove all deal requirement conditions
    /*---------------------------------------------------*/
    $conn->query("DELETE FROM deal_requirements WHERE deal_id = $deal_id");

    /*----------------------------------------------------
    /* Remove the deal entry itself
    /*---------------------------------------------------*/
    $conn->query("DELETE FROM deals WHERE id = $deal_id");
}

/*----------------------------------------------------
/* Remove the menu item that represents the deal
/*---------------------------------------------------*/
$conn->query("DELETE FROM menu_items WHERE id = $id");

/*----------------------------------------------------
/* Redirect back to deal management page
/*---------------------------------------------------*/
header("Location: manage-deals.php");
exit();
?>
