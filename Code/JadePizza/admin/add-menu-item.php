<?php
/*-------------------------------------------------------------------
/* File: add-menu-item.php
/* Description:  Admin handler to insert new menu item into database
/*-------------------------------------------------------------------
/* Author: Alyssa Cabana
/*-------------------------------------------------------------------*/

session_start();
/*-------------------------
/* Include shared database
/*------------------------*/
require_once '../includes/database.php'; // Connects to the database

/*-------------------------
/* Gather form data
/*------------------------*/
$name = $_POST['name'];
$category = $_POST['category'];
$description = $_POST['description'];
$image = 'images/' . basename($_POST['image']);
$is_special = isset($_POST['is_special']) ? 1 : 0; // Mark as special if checked

/*----------------------------------------
/* Insert item into menu_items table
/*---------------------------------------*/
$stmt = $conn->prepare("INSERT INTO menu_items (name, description, image, category, is_special) VALUES (?, ?, ?, ?, ?)");
$stmt->bind_param("ssssi", $name, $description, $image, $category, $is_special);
$stmt->execute();
$menu_item_id = $stmt->insert_id; // Get inserted ID for size mapping
$stmt->close();

/*----------------------------------------
/* Insert available sizes
/*---------------------------------------*/
$sizes = $_POST['sizes'] ?? [];           
$prices = $_POST['prices'] ?? [];         

if (!empty($sizes)) {
    $stmt2 = $conn->prepare("INSERT INTO menu_item_sizes (menu_item_id, size, price) VALUES (?, ?, ?)");

    foreach ($sizes as $size) {
        if (isset($prices[$size]) && is_numeric($prices[$size])) {
            $price = floatval($prices[$size]);
            $stmt2->bind_param("isd", $menu_item_id, $size, $price);
            $stmt2->execute();
        }
    }

    $stmt2->close();
}

/*----------------------------------------
/* Redirect back to menu manager
/*---------------------------------------*/
header("Location: manage-menu.php");
exit();
?>