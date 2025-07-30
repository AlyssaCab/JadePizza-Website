<?php
/*-------------------------------------------------------------
/* File: delete-menu-item.php
/* Description:  Processes admin request to delete menu items
/*-------------------------------------------------------------
/* Author: Alyssa Cabana
/*-------------------------------------------------------------*/

session_start();
/*-------------------------
/* Include shared database
/*------------------------*/ 
require_once '../includes/database.php'; // Connects to the database

/*----------------------------------------------------
/* Restrict access to logged-in admins only
/*---------------------------------------------------*/
if (!isset($_SESSION['logged_in']) || $_SESSION['role'] !== 'admin') {
    header("Location: /JadePizza/login.php");
    exit();
}
$id = (int) $_POST['id'];

/*----------------------------------------------------
/* First, delete all associated size entries
/*---------------------------------------------------*/
$conn->query("DELETE FROM menu_item_sizes WHERE menu_item_id = $id");

/*----------------------------------------------------
/* Then, delete the menu item itself
/*---------------------------------------------------*/
$conn->query("DELETE FROM menu_items WHERE id = $id");

/*----------------------------------------------------
/* Redirect back to admin menu management
/*---------------------------------------------------*/
header("Location: manage-menu.php");
exit();
?>