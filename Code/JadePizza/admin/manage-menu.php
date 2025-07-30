<?php
/*-----------------------------------------------------------------------------
/* File: manage-menu.php
/* Description: Admin interface to manage menu items
/*               - Displays all current menu items (excluding deals)
/*               - Allows adding new items with image, sizes, and prices
/*               - Supports deletion of items
/*-----------------------------------------------------------------------------
/* Author: Alyssa Cabana
/*-----------------------------------------------------------------------------*/

session_start();
/*------------------------------
/* Include shared page elements
/*------------------------------*/
include '../includes/database.php'; // Connects to the database
include '../includes/headers.php'; // Outputs the page header/nav
?> 

<main class="admin-panel">
    <!----------------------------------------
    /* Help button linking to menu help
    /*---------------------------------------->
    <div class="help-link-container">
        <a href="../help/help-admin-menu.php" class="help-button" title="Need help with menu management?">?</a>
    </div>

    <h1>Manage Menu Items</h1>

    <!----------------------------------------
    /* View All Menu Items
    /*---------------------------------------->
    <h2>Current Menu Items</h2>
    <div class="cart-table-container">
        <?php
        $result = mysqli_query($conn, "SELECT * FROM menu_items WHERE category != 'Deal'");
        if (mysqli_num_rows($result) === 0): ?>
            <p class="text-center pad-2rem">No menu items found.</p>
        <?php else: ?>
            <table class="cart-table">
                <thead>
                    <tr>
                        <th>Image</th>
                        <th>Name</th>
                        <th>Category</th>
                        <th>Description</th>
                        <th>Special</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = mysqli_fetch_assoc($result)): ?>
                        <tr>
                            <td>
                                <img src="../<?= htmlspecialchars($row['image']) ?>"
                                     alt="<?= htmlspecialchars($row['name']) ?>"
                                     style="width:80px; height:80px; object-fit:cover; border-radius:6px;">
                            </td>
                            <td><?= htmlspecialchars($row['name']) ?></td>
                            <td><?= htmlspecialchars($row['category']) ?></td>
                            <td><?= htmlspecialchars($row['description']) ?></td>
                            <td><?= $row['is_special'] ? '✅' : '❌' ?></td>
                            <td>
                                <form method="post" action="delete-menu-item.php"
                                      onsubmit="return confirm('Are you sure you want to delete this item?');">
                                    <input type="hidden" name="id" value="<?= $row['id'] ?>">
                                    <button type="submit" class="theme-submit">Delete</button>
                                </form>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>

    <!----------------------------------------
    /* Add New Menu Item
    /*---------------------------------------->
    <h2>Add New Menu Item</h2>
    <div class="checkout-table-container">
        <form method="post" action="add-menu-item.php" enctype="multipart/form-data">
            <!-------------
            /* Basic Info
            /*------------->
            <div class="form-row">
                <label for="name"><strong>Name:</strong></label><br>
                <input type="text" id="name" name="name" class="form-input" required><br><br>
            </div>

            <div class="form-row">
                <label for="category"><strong>Category:</strong></label><br>
                <select id="category" name="category" class="form-input" required>
                    <option value="Pizza">Pizza</option>
                    <option value="Side">Side</option>
                    <option value="Drink">Drink</option>
                </select><br><br>
            </div>

            <div class="form-row">
                <label for="description"><strong>Description:</strong></label><br>
                <textarea id="description" name="description" class="form-input" rows="3" required></textarea><br><br>
            </div>

            <div class="form-row">
                <label for="image"><strong>Image Filename (in images/):</strong></label><br>
                <input type="text" id="image" name="image" class="form-input"
                       placeholder="e.g. cheese.png" required><br><br>
            </div>

            <!--------------------
            /* Sizes and Prices
            /*-------------------->
            <h3>Sizes & Prices</h3>
            <div class="form-row">
                <label><input type="checkbox" name="sizes[]" value="Small"> Small</label>
                <input type="number" step="0.01" name="prices[Small]" placeholder="Price for Small" class="form-input"><br><br>

                <label><input type="checkbox" name="sizes[]" value="Medium"> Medium</label>
                <input type="number" step="0.01" name="prices[Medium]" placeholder="Price for Medium" class="form-input"><br><br>

                <label><input type="checkbox" name="sizes[]" value="Large"> Large</label>
                <input type="number" step="0.01" name="prices[Large]" placeholder="Price for Large" class="form-input"><br><br>

                <label><input type="checkbox" name="sizes[]" value="Regular"> Regular</label>
                <input type="number" step="0.01" name="prices[Regular]" placeholder="Price for Regular" class="form-input"><br><br>

                <label><input type="checkbox" name="sizes[]" value="Can"> Can</label>
                <input type="number" step="0.01" name="prices[Can]" placeholder="Price for Can" class="form-input"><br><br>
            </div>

            <!--------------------
            /* Special Tag
            /*-------------------->
            <div class="form-row">
                <label><input type="checkbox" name="is_special" value="1"> Mark as Special</label><br><br>
            </div>

            <!--------------------
            /* Submit Button
            /*-------------------->
            <div class="submit">
                <button type="submit" class="theme-submit">Add Item</button>
            </div>
        </form>
    </div>
</main>
<!------------------------
/* Include shared footer
/*------------------------>
<?php include '../includes/footers.php'; ?> <!-- Outputs the page footer and contact/support request -->