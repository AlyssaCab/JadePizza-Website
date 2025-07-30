<?php
/*---------------------------------------------------------------------
/* File: checkout.php
/* Description: Displays checkout page, validates and shows
/*              cart contents, deal discount (if any), and customer form.
/*---------------------------------------------------------------------
/* Author: Alyssa Cabana
/*---------------------------------------------------------------------*/

/*------------------------------------
/* Start session and access cart data
/*------------------------------------*/
session_start(); 
$cart = $_SESSION['cart'] ?? [];
$applied_deal_id = $_SESSION['applied_deal_id'] ?? null;

/*------------------------------
/* Include shared page elements
/*------------------------------*/
include 'includes/database.php';    // Connects to the database
include 'includes/functions.php';   // Utility functions (e.g., formatPrice)

/*-------------------------------
/* Function to format prices
/*-------------------------------*/
function formatPrice($price) {
    return '$' . number_format($price, 2);
}

/*------------------------------------------
/* Calculate basic subtotal from cart items
/*------------------------------------------*/
$subtotal = 0;
foreach ($cart as $item) {
    $subtotal += $item['price'] * $item['quantity'];
}

/*------------------------------------------
/* Set initial values for discount and tax
/*------------------------------------------*/
$deal_discount = 0;
$deal_description = '';
$tax_rate = 0.13;


/*------------------------------------------
/* Check if a deal is applied and validate it
/*------------------------------------------*/
if ($applied_deal_id) {
    $deal_query = "SELECT * FROM deals WHERE menu_item_id = $applied_deal_id";
    $deal_result = mysqli_query($conn, $deal_query);
    $deal = mysqli_fetch_assoc($deal_result);

    if ($deal) {
        $deal_price = floatval($deal['flat_price']);

        /*------------------------------------------
        /* Get required items for the deal
        /*------------------------------------------*/
        $req_query = "SELECT * FROM deal_requirements WHERE deal_id = " . $deal['id'];
        $req_result = mysqli_query($conn, $req_query);

        $requirements = [];
        while ($row = mysqli_fetch_assoc($req_result)) {
            $requirements[] = $row;
        }

        $qualifying_value = 0;
        $missing_items = [];

        /*--------------------------------------------------
        /* Loop through requirements and match against cart
        /*--------------------------------------------------*/
        foreach ($requirements as $req) {
            $needed = $req['quantity'];
            $fulfilled = 0;

            /*------------------------------------------
            /* Count how many matching items are in cart
            /*------------------------------------------*/
            foreach ($cart as $item) {
                if (
                    $item['category'] === $req['required_category'] &&
                    strtolower($item['size']) === strtolower($req['required_size'])
                ) {
                    $fulfilled += $item['quantity'];
                }
            }

            // Add 
            /*-----------------------------------------------
            /* Display missing requirement message if short
            /*-----------------------------------------------*/
            $short = max(0, $needed - $fulfilled);
            if ($short > 0) {
                $missing_items[] = "{$short} more of a {$req['required_size']} {$req['required_category']}";
            }
 
            /*----------------------------------------------------
            /* Sum the price of items used to qualify for discount
            /*----------------------------------------------------*/
            $used = min($needed, $fulfilled);
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

        /*-----------------------------------------------
        /* If all requirements are met, calculate discount
        /*-----------------------------------------------*/
        if (empty($missing_items)) {
            $deal_discount = max(0, $qualifying_value - $deal_price);
            $deal_description = $deal['description'];
        }
    }
}

/*-----------------------------------------------
/* Calculate tax and final total
/*-----------------------------------------------*/
$tax = ($subtotal - $deal_discount) * $tax_rate;
$total = $subtotal - $deal_discount + $tax;
?>

<!------------------------------
/* Include shared page header
/*------------------------------>
<?php include 'includes/headers.php'; ?>    <!-- Outputs the page header/nav -->

<main class="checkout">

    <!----------------------------------------
    /* Help button linking to checkout help
    /*---------------------------------------->
    <div class="help-link-container">
        <a href="help/help-checkout.php" class="help-button" title="Need help with your cart?">?</a>
    </div>

    <h1>Checkout</h1>

    <!----------------------------------------
    /* Order summary table
    /*---------------------------------------->
    <div class="cart-table-container">
        <h2>Order Summary</h2>
        <?php if (!empty($cart)): ?>
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

                <!------------------------
                /* Deal applies row
                /*------------------------>
                <?php if ($deal_description): ?>
                <tr>
                    <td colspan="4"><strong>Deal Applied:</strong> <?= htmlspecialchars($deal_description) ?></td>
                    <td>-<?= formatPrice($deal_discount) ?></td>
                </tr>
                <?php endif; ?>

                <!------------------------
                /* Final Calculations
                /*------------------------>
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

        <button type="button" onclick="window.location.href='cart.php'" class="button full-width">Back to Cart</button>
        <?php else: ?>
            <p>Your cart is empty.</p>
        <?php endif; ?>
    </div>

    <!---------------------------------------
    /* Prevent admins from placing orders
    /*--------------------------------------->
    <?php if (isset($_SESSION['admin_id'])): ?>
        <p class="text-center" style="color: red; font-weight: bold; margin-top: 2rem;">
            Admin accounts cannot place orders. Please log in as a customer.
        </p>
    <?php else: ?>

    <!------------------
    /* Checkout Form
    /*------------------>
    <form action="submit-order.php" method="post" onsubmit="return validateForm()">
        <!------------------
        /* Customer Info
        /*------------------>
        <div class="checkout-table-container">
            <h2>Customer Information</h2>

            <label for="name">Full Name:</label><br>
            <input type="text" name="name" id="name" required minlength="2" maxlength="100"><br><br>

            <label for="phone">Phone Number:</label><br>
            <input type="tel" name="phone" id="phone" required minlength="7" maxlength="15"
                   pattern="[0-9\s\-\(\)]*" placeholder="123-456-7890"><br><br>

            <label for="email">Email (optional):</label><br>
            <input type="email" name="email" id="email" minlength="5" maxlength="254"><br><br>

            <!------------------
            /* Order Type
            /*------------------>
            <label>Order Type:</label><br>
            <input type="radio" id="pickup" name="order_type" value="Pickup" checked onchange="toggleAddressFields()">
            <label for="pickup">Pickup</label><br>
            <input type="radio" id="delivery" name="order_type" value="Delivery" onchange="toggleAddressFields()">
            <label for="delivery">Delivery</label><br><br>

            <!------------------------------------------
            /* Delivery address (hidden by default)
            /*------------------------------------------>
            <div id="address-fields" class="delivery">
                <label for="address">Address:</label><br>
                <input type="text" name="address" id="address" minlength="5" maxlength="100"><br><br>

                <label for="postal_code">Postal Code:</label><br>
                <input type="text" name="postal_code" id="postal_code" minlength="3" maxlength="10"><br><br>

                <label for="province">Province:</label><br>
                <input type="text" name="province" id="province" minlength="2" maxlength="40"><br><br>

                <label for="country">Country:</label><br>
                <input type="text" name="country" id="country" minlength="2" maxlength="56"><br><br>
            </div>
        </div>

        <!------------------
        /* Payment details
        /*------------------>
        <div class="checkout-table-container">
            <h2>Payment Details</h2>

            <label for="card_number">Card Number:</label><br>
            <input type="text" id="card_number" name="card_number"
                   placeholder="**** **** **** 1234"
                   minlength="13" maxlength="19"
                   pattern="\d{13,19}"
                   inputmode="numeric"
                   required class="form-input"><br><br>

            <label for="expiry">Expiry Date (MM/YY):</label><br>
            <input type="text" id="expiry" name="expiry"
                   placeholder="MM/YY"
                   pattern="\d{2}/\d{2}"
                   inputmode="numeric"
                   minlength="5" maxlength="5"
                   required class="form-input"><br><br>

            <label for="cvv">CVV:</label><br>
            <input type="text" id="cvv" name="cvv"
                   placeholder="123"
                   pattern="\d{3}"
                   inputmode="numeric"
                   minlength="3" maxlength="3"
                   required class="form-input"><br><br>

            <button type="submit" class="button full-width">Place Order</button>
        </div>
    </form>
    <?php endif; ?>
</main>

<!------------------------
/* Include shared footer
/*------------------------>
<?php include 'includes/footers.php'; ?>    <!-- Outputs the page footer and contact/support request -->