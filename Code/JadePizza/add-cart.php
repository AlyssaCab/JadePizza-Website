<?php
/*-------------------------------------------------------------
/* File: add-cart.php
/* Description: Adds item to cart
/*-------------------------------------------------------------
/* Author: Alyssa Cabana
/*-------------------------------------------------------------*/

session_start();

/*-------------------------
/* Include shared database
/*------------------------*/
include 'includes/database.php';    // Connects to the database

/*------------------------------------------
/* Validate item and size input
/*------------------------------------------*/
if (!isset($_POST['menu_item_id'], $_POST['size'])) {
    header("Location: menu.php");
    exit;
}

$menu_item_id = (int)$_POST['menu_item_id'];
$size_id = (int)$_POST['size'];

/*------------------------------------------
/* Fetch item and size details from database
/*------------------------------------------*/
$query = "
    SELECT 
        mi.id AS item_id,
        mi.name AS item_name,
        mi.category AS category,
        mis.size AS size,
        mis.price AS price
    FROM menu_items mi
    JOIN menu_item_sizes mis ON mi.id = mis.menu_item_id
    WHERE mi.id = $menu_item_id AND mis.id = $size_id
    LIMIT 1
";

$result = mysqli_query($conn, $query);
$item = mysqli_fetch_assoc($result);

if (!$item) {
    /*------------------------------------------
    /* Invalid menu item or size selection
    /*------------------------------------------*/
    header("Location: menu.php?error=invalid_item");
    exit;
}

/*------------------------------------------
/* Add item to cart session
/*------------------------------------------*/
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

$found = false;
foreach ($_SESSION['cart'] as &$cart_item) {
    if ($cart_item['item_id'] === $item['item_id'] && $cart_item['size'] === $item['size']) {
        $cart_item['quantity'] += 1;
        $found = true;
        break;
    }
}
unset($cart_item);

if (!$found) {
    $_SESSION['cart'][] = [
        'item_id'  => $item['item_id'],
        'name'     => $item['item_name'],
        'category' => $item['category'],
        'size'     => $item['size'],
        'price'    => $item['price'],
        'quantity' => 1
    ];
}

/*------------------------------------------
/* Set success message and redirect
/*------------------------------------------*/
$_SESSION['menu_message'] = "Item successfully added to cart.";
header("Location: menu.php");
exit;