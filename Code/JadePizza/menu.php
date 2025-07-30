<?php
/*--------------------------------------------------------------------------------
/* File: menu.php
/* Description: Displays all menu items by category (Pizza, Side, Drink, Deal)
/*              Creates grid layout for menu with add-to-cart and apply-deal form
/*--------------------------------------------------------------------------------
/* Author: Alyssa Cabana
/*--------------------------------------------------------------------------------*/

/*-------------------------
/* Include shared database
/*------------------------*/
include 'includes/database.php';    // Connects to the database

/*-----------------------------
/* Query all menu items by type
/*-----------------------------*/
$pizza_result = mysqli_query($conn, "SELECT * FROM menu_items WHERE category = 'Pizza'");
$side_result = mysqli_query($conn, "SELECT * FROM menu_items WHERE category = 'Side'");
$drink_result = mysqli_query($conn, "SELECT * FROM menu_items WHERE category = 'Drink'");
$deal_result = mysqli_query($conn, "SELECT * FROM menu_items WHERE category = 'Deal'");

/*-----------------------------
/* Query all size options
/*-----------------------------*/
$size_result = mysqli_query($conn, "SELECT * FROM menu_item_sizes");

/*----------------------------
/* Group sizes by menu_item_id
/*---------------------------*/
$sizes = [];
while ($row = mysqli_fetch_assoc($size_result)) {
    $sizes[$row['menu_item_id']][] = $row;
}
?>

<!------------------------------
/* Include shared page header
/*------------------------------>
<?php include 'includes/headers.php'; ?>    <!-- Outputs the page header/nav -->

<main>
    <!-------------------------------
    /* Display menu-related messages
    /*-------------------------------->
    <?php if (isset($_SESSION['menu_message']) || isset($_SESSION['deal_message'])): ?>
        <div class="menu-notification">
            <?= isset($_SESSION['deal_message']) ? htmlspecialchars($_SESSION['deal_message']) : '' ?>
            <?= isset($_SESSION['menu_message']) ? htmlspecialchars($_SESSION['menu_message']) : '' ?>
        </div>
        <?php unset($_SESSION['deal_message'], $_SESSION['menu_message']); ?>
    <?php endif; ?>

    <!-------------------------------
    /* Help button for ordering
    /*-------------------------------->
    <div class="help-link-container">
        <a href="help/help-ordering.php" class="help-button" title="Need help with ordering?">?</a>
    </div>

    <!-----------------
    /* Display video
    /*----------------->
    <section class="highlights">
        <h2>What Do You Crave?!</h2>
        <video controls width="100%">
            <source src="video&audio/pizza-slice.mp4" type="video/mp4">
            Your browser does not support the video tag.
        </video>
    </section>

    <!-------------------------------
    /* Help button for deal
    /*-------------------------------->
    <div class="help-link-container">
        <a href="help/help-deals.php" class="help-button" title="Need help with your cart?">?</a>
    </div>

    <!-------------------
    /* Deals section
    /*------------------->
    <section class="menu">
        <h1>Special Deals</h1>
        <div class="deal-menu-grid">
            <?php while ($deal = mysqli_fetch_assoc($deal_result)): ?>
                <div class="menu-item">
                    <div class="menu-card" onclick="toggleDetails(<?= $deal['id'] ?>)">
                        <img src="<?= htmlspecialchars($deal['image']) ?>" alt="<?= htmlspecialchars($deal['name']) ?>">
                        <h2><?= htmlspecialchars($deal['name']) ?></h2>
                        <p><?= htmlspecialchars($deal['description']) ?></p>
                    </div>
                    <!-------------------
                    /* Apply Deal Form
                    /*------------------->
                    <div class="deal-details" id="details-<?= $deal['id'] ?>" onclick="event.stopPropagation();">
                        <form method="post" action="apply-deal.php">
                            <input type="hidden" name="deal_id" value="<?= $deal['id'] ?>">
                            <button type="submit">Apply Deal</button>
                        </form>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>
    </section>

    <!-------------------
    /* Pizzas section
    /*------------------->
    <section class="menu">
        <h1>Our Pizzas</h1>
        <div class="pizza-menu-grid">
            <?php while ($pizza = mysqli_fetch_assoc($pizza_result)): ?>
                <div class="menu-item">
                    <div class="menu-card" onclick="toggleDetails(<?= $pizza['id'] ?>)">
                        <img src="<?= htmlspecialchars($pizza['image']) ?>" alt="<?= htmlspecialchars($pizza['name']) ?>">
                        <h2><?= htmlspecialchars($pizza['name']) ?></h2>
                        <p><?= htmlspecialchars($pizza['description']) ?></p>
                    </div>
                    <!--------------------------
                    /* Pizza Add-to-Cart Form
                    /*-------------------------->
                    <div class="pizza-details" id="details-<?= $pizza['id'] ?>" onclick="event.stopPropagation();">
                        <?php if (isset($sizes[$pizza['id']])): ?>
                            <form method="post" action="add-cart.php">
                                <ul>
                                    <?php foreach ($sizes[$pizza['id']] as $size): ?>
                                        <li>
                                            <label>
                                                <input type="radio" name="size" value="<?= $size['id'] ?>" required>
                                                <?= htmlspecialchars($size['size']) ?> - $<?= number_format($size['price'], 2) ?>
                                            </label>
                                        </li>
                                    <?php endforeach; ?>
                                </ul>
                                <input type="hidden" name="menu_item_id" value="<?= $pizza['id'] ?>">
                                <button type="submit">Add to Cart</button>
                            </form>
                        <?php else: ?>
                            <p>No sizes available.</p>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>
    </section>

    <!-------------------
    /* Sides section
    /*------------------->
    <section class="menu">
        <h1>Our Sides</h1>
        <div class="side-menu-grid">
            <?php while ($side = mysqli_fetch_assoc($side_result)): ?>
                <div class="menu-item">
                    <div class="menu-card" onclick="toggleDetails(<?= $side['id'] ?>)">
                        <img src="<?= htmlspecialchars($side['image']) ?>" alt="<?= htmlspecialchars($side['name']) ?>">
                        <h2><?= htmlspecialchars($side['name']) ?></h2>
                        <p><?= htmlspecialchars($side['description']) ?></p>
                    </div>
                    <!--------------------------
                    /* Side Add-to-Cart Form
                    /*-------------------------->
                    <div class="side-details" id="details-<?= $side['id'] ?>" onclick="event.stopPropagation();">
                        <?php if (isset($sizes[$side['id']])): ?>
                            <form method="post" action="add-cart.php">
                                <ul>
                                    <?php foreach ($sizes[$side['id']] as $size): ?>
                                        <li>
                                            <label>
                                                <input type="radio" name="size" value="<?= $size['id'] ?>" required>
                                                <?= htmlspecialchars($size['size']) ?> - $<?= number_format($size['price'], 2) ?>
                                            </label>
                                        </li>
                                    <?php endforeach; ?>
                                </ul>
                                <input type="hidden" name="menu_item_id" value="<?= $side['id'] ?>">
                                <button type="submit">Add to Cart</button>
                            </form>
                        <?php else: ?>
                            <p>No sizes available.</p>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>
    </section>

    <!-------------------
    /* Drinks section
    /*------------------->
    <section class="menu">
        <h1>Drinks</h1>
        <div class="drink-menu-grid">
            <?php while ($drink = mysqli_fetch_assoc($drink_result)): ?>
                <div class="menu-item">
                    <div class="menu-card" onclick="toggleDetails(<?= $drink['id'] ?>)">
                        <img src="<?= htmlspecialchars($drink['image']) ?>" alt="<?= htmlspecialchars($drink['name']) ?>">
                        <h2><?= htmlspecialchars($drink['name']) ?></h2>
                        <p><?= htmlspecialchars($drink['description']) ?></p>
                    </div>
                    <!--------------------------
                    /* Drinks Add-to-Cart Form
                    /*-------------------------->
                    <div class="drink-details" id="details-<?= $drink['id'] ?>" onclick="event.stopPropagation();">
                        <?php if (isset($sizes[$drink['id']])): ?>
                            <form method="post" action="add-cart.php">
                                <ul>
                                    <?php foreach ($sizes[$drink['id']] as $size): ?>
                                        <li>
                                            <label>
                                                <input type="radio" name="size" value="<?= $size['id'] ?>" required>
                                                <?= htmlspecialchars($size['size']) ?> - $<?= number_format($size['price'], 2) ?>
                                            </label>
                                        </li>
                                    <?php endforeach; ?>
                                </ul>
                                <input type="hidden" name="menu_item_id" value="<?= $drink['id'] ?>">
                                <button type="submit">Add to Cart</button>
                            </form>
                        <?php else: ?>
                            <p>No sizes available.</p>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>
    </section>
</main>

<!------------------------
/* Include shared footer
/*------------------------>
<?php include 'includes/footers.php'; ?>    <!-- Outputs the page footer and contact/support request -->