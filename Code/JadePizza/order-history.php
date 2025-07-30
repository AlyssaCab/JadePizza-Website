<?php
/*-------------------------------------------------------------
/* File: order-history.php
/* Description: Displays all orders for user
/*              Accessible only to users
/*-------------------------------------------------------------
/* Author: Alyssa Cabana
/*-------------------------------------------------------------*/

session_start();

/*------------------------------
/* Include shared page elements
/*------------------------------*/
include 'includes/database.php'; // Connects to the database
include 'includes/headers.php';  // Outputs the page header/nav

/*------------------------------
/* Allow access soley to users
/*------------------------------*/
if (!isset($_SESSION['user_id'])) {
    echo "<main class='text-center'><h2>You must be logged in to view order history.</h2></main>";
    include 'includes/footers.php';
    exit;
}

$user_id = $_SESSION['user_id'];

/*-----------------------------------------------------
/* Query orders for user, showing newest first
/*-----------------------------------------------------*/
$stmt = $conn->prepare("SELECT * FROM orders WHERE user_id = ? ORDER BY created_at DESC");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$orders_result = $stmt->get_result();

/*----------------------
/* Display order history
/*----------------------*/
echo "<main class='checkout'>";
echo "<h1 class='text-center'>Your Order History</h1>";

if ($orders_result->num_rows === 0) {
    /*------------------------
    /* Display no orders found
    /*------------------------*/
    echo "<p class='text-center'>You haven't placed any orders yet.</p>";
} else {
    /*------------------------
    /* Loop through each order
    /*------------------------*/
    while ($order = $orders_result->fetch_assoc()) {
        $order_id = $order['id'];
        $created = $order['created_at'];
        $total = number_format($order['total'], 2);

        echo "<div class='cart-table-container'>";
        echo "<h2>Order Placed On <span class='small'>($created)</span></h2>";

        /*----------------
        /* Create table
        /*----------------*/
        echo "<table class='cart-table'>
                <thead>
                    <tr>
                        <th>Item</th>
                        <th>Size</th>
                        <th>Price</th>
                        <th>Qty</th>
                        <th>Subtotal</th>
                    </tr>
                </thead>
                <tbody>";

        /*-----------------------------------------
        /* Get all items from specific order
        /*-----------------------------------------*/
        $item_stmt = $conn->prepare("SELECT * FROM order_items WHERE order_id = ?");
        $item_stmt->bind_param("i", $order_id);
        $item_stmt->execute();
        $items_result = $item_stmt->get_result();

        /*-----------------------------------------
        /* Loop through each item in the order
        /*-----------------------------------------*/
        while ($item = $items_result->fetch_assoc()) {
            $name = htmlspecialchars($item['name']);
            $size = htmlspecialchars($item['size']);
            $price = number_format($item['price'], 2);
            $qty = (int)$item['quantity'];
            $lineTotal = number_format($item['price'] * $qty, 2);

            echo "<tr>
                    <td>$name</td>
                    <td>$size</td>
                    <td>\$$price</td>
                    <td>$qty</td>
                    <td>\$$lineTotal</td>
                </tr>";
        }

        /*--------------------
        /* Diaplat total row
        /*--------------------*/
        echo "<tr>
                <td colspan='4'><strong>Total</strong></td>
                <td><strong>\$$total</strong></td>
              </tr>";

        echo "</tbody></table></div>";
    }
}

echo "</main>";

/*-------------------------
/* Include shared footer
/*------------------------*/
include 'includes/footers.php'; // Outputs the page footer and contact/support request
?>