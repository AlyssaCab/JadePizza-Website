<?php
/*-------------------------------------------------------------------
/* File: add-deal.php
/* Description:  Admin handler to insert new deals into database
/*-------------------------------------------------------------------
/* Author: Alyssa Cabana
/*-------------------------------------------------------------------*/

session_start();
/*-------------------------
/* Include shared database
/*------------------------*/
include '../includes/database.php'; // Connects to the database
 
/*----------------------------------------------------
/* Get POST form data
/*---------------------------------------------------*/
$name = $_POST['name'];
$description = $_POST['description'];
$image = 'images/' . basename($_POST['image']);
$flat_price = floatval($_POST['flat_price']);
$category = 'Deal'; // All deals are marked with this category

/*----------------------------------------------------
/* Insert into menu_items table
/*---------------------------------------------------*/
$stmt1 = $conn->prepare("INSERT INTO menu_items (name, description, image, category) VALUES (?, ?, ?, ?)");
$stmt1->bind_param("ssss", $name, $description, $image, $category);
$stmt1->execute();
$menu_item_id = $stmt1->insert_id;
$stmt1->close();

/*----------------------------------------------------
/* Insert into deals table
/*---------------------------------------------------*/
$stmt2 = $conn->prepare("INSERT INTO deals (menu_item_id, flat_price, description) VALUES (?, ?, ?)");
$stmt2->bind_param("ids", $menu_item_id, $flat_price, $description);
$stmt2->execute();
$deal_id = $stmt2->insert_id;
$stmt2->close();
 
/*----------------------------------------------------
/* Insert into deal_requirements table
/*---------------------------------------------------*/
$required_categories = $_POST['required_category'];
$quantities = $_POST['quantity'];
$required_sizes = $_POST['required_size'];
$required_names = $_POST['required_name']; // Optional

$stmt3 = $conn->prepare("INSERT INTO deal_requirements (deal_id, required_category, quantity, required_size, required_name) VALUES (?, ?, ?, ?, ?)");

for ($i = 0; $i < count($required_categories); $i++) {
    $cat = $required_categories[$i];
    $qty = (int)$quantities[$i];
    $size = trim((string)$required_sizes[$i]);
    $name = trim((string)$required_names[$i]);

    /*----------------------------------------------------
    /* Normalize empty fields as NULL
    /*---------------------------------------------------*/
    $size = $size === "" ? null : $size;
    $name = $name === "" ? null : $name;

    $stmt3->bind_param("isiss", $deal_id, $cat, $qty, $size, $name);
    $stmt3->execute();
}

$stmt3->close();

/*----------------------------------------------------
/* Redirect back to deal manager
/*---------------------------------------------------*/
header("Location: manage-deals.php");
exit;
?>
