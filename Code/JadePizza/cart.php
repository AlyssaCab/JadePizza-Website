<?php
/*-------------------------------------------------------------
/* File: cart.php
/* Description: Displays the user's cart with all items,
/*              applied deals, and total price.
/*              Allows updating/removing items and
/*              proceeding to checkout.
/*-------------------------------------------------------------
/* Author: Alyssa Cabana
/*-------------------------------------------------------------*/

session_start();

/*------------------------------
/* Check if user is logged in
/*------------------------------*/
$loggedIn = isset($_SESSION['logged_in']) && $_SESSION['logged_in'];

/*------------------------------
/* Handle POST form submissions
/*------------------------------*/
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Update quantities
    if (isset($_POST['quantities']) && is_array($_POST['quantities'])) {
        foreach ($_POST['quantities'] as $index => $qty) {
            $qty = max(1, (int)$qty); // Prevent zero or negative
            if (isset($_SESSION['cart'][$index])) {
                $_SESSION['cart'][$index]['quantity'] = $qty;
            }
        }
    }

    /*------------------------------
    /* Remove items or deal
    /*------------------------------*/
    if (isset($_POST['remove']) && is_array($_POST['remove'])) {
        foreach ($_POST['remove'] as $removeIndex) {
            if ($removeIndex === 'deal') {
                unset($_SESSION['applied_deal_id']);
            } else {
                unset($_SESSION['cart'][(int)$removeIndex]);
            }
        }
        $_SESSION['cart'] = array_values($_SESSION['cart']); // Reindex
    }

    $_SESSION['cart_message'] = "Cart updated successfully.";
    header("Location: cart.php"); // Prevent form resubmission
    exit;
}

/*------------------------------
/* Load current cart and deal info
/*------------------------------*/
$cart = $_SESSION['cart'] ?? [];
$total = 0;
$applied_deal_id = $_SESSION['applied_deal_id'] ?? null;
$cart_message = $_SESSION['cart_message'] ?? null;
unset($_SESSION['cart_message']); // Only show once
?>

<!------------------------------
/* Include shared page header
/*------------------------------>
<?php include 'includes/headers.php'; ?>    <!-- Outputs the page header/nav -->

<main class="cart">
<section class="menu">

    <!------------------------------
    /* Show message after update
    /*------------------------------>
    <?php if ($cart_message): ?>
        <div class="menu-notification">
            <?= htmlspecialchars($cart_message) ?>
        </div>
    <?php endif; ?>

    <!----------------------------------------
    /* Help button linking to cart help
    /*---------------------------------------->
    <div class="help-link-container">
        <a href="help/help-cart.php" class="help-button" title="Need help with your cart?">?</a>
    </div>

    <h1>Your Cart</h1>

    <!----------------------------------------
    /* Warn if not logged in
    /*---------------------------------------->
    <?php if (!$loggedIn): ?>
        <div class="menu-notification" style="color: red; text-align: center;">
            You must be logged in to proceed to checkout.
        </div>
    <?php endif; ?>

    <!----------------------------------------
    /* If cart is empty, show message and link
    /*---------------------------------------->
    <?php if (empty($cart) && !$applied_deal_id): ?>
        <form method="post">
            <div class="cart-table-container">
                <table class="cart-table">
                    <thead>
                        <tr>
                            <th>Item</th>
                            <th>Size</th>
                            <th>Price</th>
                            <th>Qty</th>
                            <th>Subtotal</th>
                            <th>Remove</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td colspan="6" class="text-center pad-2rem">Your cart is currently empty.</td>
                        </tr>
                        <tr>
                            <td colspan="6" class="text-center">
                                <button type="button" class="button full-width" onclick="window.location.href='menu.php'">Browse Menu</button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </form>
    <?php else: ?>
        <!----------------
        /* Cart grid
        /*---------------->
        <form method="post">
            <div class="cart-table-container">
                <table class="cart-table">
                    <thead>
                        <tr>
                            <th>Item</th>
                            <th>Size</th>
                            <th>Price</th>
                            <th>Qty</th>
                            <th>Subtotal</th>
                            <th>Remove</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($cart as $index => $item):
                            $subtotal = $item['price'] * $item['quantity'];
                            $total += $subtotal;
                        ?>
                        <tr>
                            <td><?= htmlspecialchars($item['name']) ?></td>
                            <td><?= htmlspecialchars($item['size']) ?></td>
                            <td>$<?= number_format($item['price'], 2) ?></td>
                            <td><input type="number" name="quantities[<?= $index ?>]" value="<?= $item['quantity'] ?>" min="1"></td>
                            <td>$<?= number_format($subtotal, 2) ?></td>
                            <td><input type="checkbox" name="remove[]" value="<?= $index ?>"></td>
                        </tr>
                        <?php endforeach; ?>

                        <?php
                        /*---------------------------------------
                        /* Deal display and qualification logic
                        /*---------------------------------------*/
                        if ($applied_deal_id):
                            include 'includes/database.php';
                            include 'includes/functions.php';

                            $deal_query = "SELECT * FROM deals WHERE menu_item_id = $applied_deal_id";
                            $deal_result = mysqli_query($conn, $deal_query);
                            $deal = mysqli_fetch_assoc($deal_result);

                            if ($deal):
                                $deal_price = floatval($deal['flat_price']);

                                /*------------------------------
                                /* Get deal requirements
                                /*------------------------------*/
                                $req_query = "SELECT * FROM deal_requirements WHERE deal_id = " . $deal['id'];
                                $req_result = mysqli_query($conn, $req_query);
                                $requirements = [];
                                while ($row = mysqli_fetch_assoc($req_result)) {
                                    $requirements[] = $row;
                                }

                                $qualifying_value = 0;
                                $missing_items = [];

                                foreach ($requirements as $req) {
                                    $needed = $req['quantity'];
                                    $fulfilled = 0;

                                    /*------------------------------
                                    /* Count matching items in cart
                                    /*------------------------------*/
                                    foreach ($cart as $item) {
                                        if (
                                            $item['category'] !== $req['required_category'] ||
                                            (!empty($req['required_size']) && strtolower($item['size']) !== strtolower($req['required_size'])) ||
                                            (!empty($req['required_name']) && strtolower($item['name']) !== strtolower($req['required_name']))
                                        ) {
                                            continue;
                                        }
                                        $fulfilled += $item['quantity'];
                                    }

                                    /*------------------------------
                                    /* Determine missing requirements
                                    /*------------------------------*/
                                    $short = max(0, $needed - $fulfilled);
                                    if ($short > 0) {
                                        $desc = "{$req['required_size']} {$req['required_category']}";
                                        if (!empty($req['required_name'])) {
                                            $desc = "{$req['required_name']} ({$req['required_size']} {$req['required_category']})";
                                        }
                                        $missing_items[] = "{$short} more of {$desc}";
                                    }

                                    /*------------------------------
                                    /* Count qualifying value
                                    /*------------------------------*/
                                    $used = min($needed, $fulfilled);
                                    foreach ($cart as $item) {
                                        if (
                                            $item['category'] === $req['required_category'] &&
                                            (empty($req['required_size']) || strtolower($item['size']) === strtolower($req['required_size'])) &&
                                            (empty($req['required_name']) || strtolower($item['name']) === strtolower($req['required_name']))
                                        ) {
                                            $used_qty = min($used, $item['quantity']);
                                            $qualifying_value += $used_qty * $item['price'];
                                            $used -= $used_qty;
                                            if ($used <= 0) break;
                                        }
                                    }
                                }

                                /*-------------------
                                /* Show deal row
                                /*-------------------*/
                                echo "<tr class='deal-description-row'>";
                                echo "<td colspan='5'><strong>💰 Deal:</strong> <em>" . htmlspecialchars($deal['description']) . "</em></td>";
                                echo "<td class='text-center'><input type='checkbox' name='remove[]' value='deal'></td>";
                                echo "</tr>";

                                /*------------------------------
                                /* Apply discount if all requirements met
                                /*------------------------------*/
                                if (empty($missing_items)) {
                                    $discount = max(0, $qualifying_value - $deal_price);
                                    $total -= $discount;
                                    echo "<tr class='deal-applied-row'><td colspan='4' class='text-right'><strong>Deal Applied:</strong></td><td colspan='2'>-$" . number_format($discount, 2) . "</td></tr>";
                                }
                            endif;
                        endif;
                        ?>

                        <!------------------------
                        /* Final total
                        /*------------------------>
                        <tr class="cart-total-row">
                            <td colspan="4" class="text-right"><strong>Total:</strong></td>
                            <td colspan="2"><strong>$<?= number_format($total, 2) ?></strong></td>
                        </tr>

                        <!------------------------
                        /* Action buttons
                        /*------------------------>
                        <tr class="cart-buttons-row">
                            <td colspan="6">
                                <div class="flex-row">
                                    <button type="submit" class="button full-width flex-child">Save Changes</button>
                                    <button type="submit" formaction="clear-cart.php" formmethod="post" class="button warning full-width flex-child">Clear Cart</button>
                                </div>
                            </td>
                        </tr>

                        <!------------------------
                        /* Checkout button
                        /*------------------------>
                        <tr>
                            <td colspan="6" class="text-center">
                                <button type="button"
                                        class="button primary full-width"
                                        onclick="window.location.href='checkout.php'"
                                        <?= !$loggedIn ? 'disabled style="opacity: 0.5; cursor: not-allowed;"' : '' ?>>
                                    Proceed to Checkout
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </form>
    <?php endif; ?>
</section>
</main>

<!------------------------
/* Include shared footer
/*------------------------>
<?php include 'includes/footers.php'; ?>    <!-- Outputs the page footer and contact/support request -->