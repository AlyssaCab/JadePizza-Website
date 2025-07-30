<?php
/*-------------------------------------------------------------
/* File: submit-order.php
/* Description: Processes the user's cart and saves the order
/*              to the database. Applies deals and tax, stores
/*              order and item details, then displays receipt.
/*-------------------------------------------------------------
/* Author: Alyssa Cabana
/*-------------------------------------------------------------*/

session_start();

/*------------------------------
/* Include shared page elements
/*------------------------------*/
include 'includes/database.php';     // Connects to the database
include 'includes/functions.php';    // Utility functions (e.g., formatPrice)

/*-------------------------------
/* Load session cart and user info
/*-------------------------------*/
$cart = $_SESSION['cart'] ?? [];
$applied_deal_id = $_SESSION['applied_deal_id'] ?? null;
$user_id = $_SESSION['user_id'] ?? null;
$admin_id = $_SESSION['admin_id'] ?? null;

/*----------------------------------------
/* Format price as $X.XX for user display
/*----------------------------------------*/
function formatPrice($price) {
    return '$' . number_format($price, 2);
}

/*------------------------------
/* Calculate cart subtotal
/*------------------------------*/
$subtotal = 0;
foreach ($cart as $item) {
    $subtotal += $item['price'] * $item['quantity'];
}

/*-----------------------------
/* Apply deal if one was used
/*-----------------------------*/
$deal_discount = 0;
$deal_description = '';
$tax_rate = 0.13;

if ($applied_deal_id) {
    $deal_query = "SELECT * FROM deals WHERE menu_item_id = $applied_deal_id";
    $deal_result = mysqli_query($conn, $deal_query);
    $deal = mysqli_fetch_assoc($deal_result);

    if ($deal) {
        $deal_price = floatval($deal['flat_price']);

        /*-----------------------------
        /* Get deal requirements
        /*-----------------------------*/
        $req_query = "SELECT * FROM deal_requirements WHERE deal_id = " . $deal['id'];
        $req_result = mysqli_query($conn, $req_query);

        $requirements = [];
        while ($row = mysqli_fetch_assoc($req_result)) {
            $requirements[] = $row;
        }

        /*--------------------------------------------------------
        /* Check if cart satisfies deal requirements and calculate
        /* total value of qualifying items toward the deal
        /*--------------------------------------------------------*/
        $qualifying_value = 0;
        foreach ($requirements as $req) {
            $needed = $req['quantity'];

            foreach ($cart as $item) {
                if (
                    $item['category'] === $req['required_category'] &&
                    strtolower($item['size']) === strtolower($req['required_size'])
                ) {
                    $use = min($item['quantity'], $needed);
                    $qualifying_value += $use * $item['price'];
                    $needed -= $use;
                    if ($needed <= 0) break;
                }
            }
        }
        /*-----------------------------
        /* Calculate total discount
        /*-----------------------------*/
        $deal_discount = max(0, $qualifying_value - $deal_price);
        $deal_description = $deal['description'];
    }
}

/*---------------------------
/* Calculate tax and total
/*---------------------------*/
$tax = ($subtotal - $deal_discount) * $tax_rate;
$total = $subtotal - $deal_discount + $tax;

/*-------------------------------------------------------
/* Save the order to the database based user id
/*-------------------------------------------------------*/
if ($user_id) {
    $order_stmt = $conn->prepare("
        INSERT INTO orders (user_id, subtotal, deal_discount, tax, total)
        VALUES (?, ?, ?, ?, ?)
    ");
    $order_stmt->bind_param("idddd", $user_id, $subtotal, $deal_discount, $tax, $total);
} elseif ($admin_id) {
    $order_stmt = $conn->prepare("
        INSERT INTO orders (admin_id, subtotal, deal_discount, tax, total)
        VALUES (?, ?, ?, ?, ?)
    ");
    $order_stmt->bind_param("idddd", $admin_id, $subtotal, $deal_discount, $tax, $total);
} else {
    die('Error: You must be logged in to place an order.');
}

$order_stmt->execute();
$order_id = $order_stmt->insert_id;

/*-----------------------------------
/* Save each item to the database
/*-----------------------------------*/
$item_stmt = $conn->prepare("
    INSERT INTO order_items (order_id, name, size, quantity, price)
    VALUES (?, ?, ?, ?, ?)
");

foreach ($cart as $item) {
    $item_stmt->bind_param(
        "issid",
        $order_id,
        $item['name'],
        $item['size'],
        $item['quantity'],
        $item['price']
    );
    $item_stmt->execute();
}

/*-------------------
/* Clear cart data
/*-------------------*/
$_SESSION['cart'] = [];
unset($_SESSION['applied_deal_id']);
?>

<!-------------------------
/* Include shared header
/*------------------------->
<?php include 'includes/headers.php'; ?>    <!-- Outputs the page header/nav -->

<main class="checkout">
    <!----------------------------------
    /* Order success message & receipt
    ------------------------------------>
    <h1>Order Placed Successfully!</h1>
    <p class="text-center">Thank you for your order! Here's your receipt:</p>

    <div class="cart-table-container">
        <h2>Order Receipt</h2>

        <!--------------
        /* Cart Table
        /*-------------->
        <table class="cart-table">
            <thead>
                <tr>
                    <th>Item</th>
                    <th>Size</th>
                    <th>Price</th>
                    <th>Qty</th>
                    <th>Subtotal</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($cart as $item): ?>
                    <tr>
                        <td><?= htmlspecialchars($item['name']) ?></td>
                        <td><?= htmlspecialchars($item['size']) ?></td>
                        <td><?= formatPrice($item['price']) ?></td>
                        <td><?= (int)$item['quantity'] ?></td>
                        <td><?= formatPrice($item['price'] * $item['quantity']) ?></td>
                    </tr>
                <?php endforeach; ?>

                <!---------------------------------
                /* Deal row (if applicable)
                /*--------------------------------->
                <?php if ($deal_description): ?>
                    <tr>
                        <td colspan="4"><strong>Deal Applied:</strong> <?= htmlspecialchars($deal_description) ?></td>
                        <td>-<?= formatPrice($deal_discount) ?></td>
                    </tr>
                <?php endif; ?>

                <!-------------------------------------
                /* Order summary: subtotal, tax, total
                /*------------------------------------->
                <tr>
                    <td colspan="4"><strong>Subtotal</strong></td>
                    <td><?= formatPrice($subtotal - $deal_discount) ?></td>
                </tr>
                <tr>
                    <td colspan="4"><strong>Tax (13%)</strong></td>
                    <td><?= formatPrice($tax) ?></td>
                </tr>
                <tr>
                    <td colspan="4"><strong>Total</strong></td>
                    <td><strong><?= formatPrice($total) ?></strong></td>
                </tr>
            </tbody>
        </table>

        <!---------------------------------
        /* Return to homepage button
        /*--------------------------------->
        <button onclick="window.location.href='index.php'" class="button full-width">
            Return to Home
        </button>
    </div>
</main>

<!-------------------------
/* Include shared footer
/*------------------------->
<?php include 'includes/footers.php'; ?>    <!-- Outputs the page footer and contact/support request -->