<?php
/*-----------------------------------------------------------------------------
/* File: manage-deals.php
/* Description: Admin interface to manage promotional deals
/*               - Displays existing deals stored as menu items
/*               - Allows creation of new deals with flat price
/*               - Lets admin define deal requirements by category, size, and name
/*               - Supports deal deletion
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
    /* Help button linking to deals help
    /*---------------------------------------->
    <div class="help-link-container">
        <a href="../help/help-admin-deals.php" class="help-button" title="Need help with deal management?">?</a>
    </div>

    <h1>Manage Deals</h1>

    <!----------------------------------------
    /* View Existing Deals
    /*---------------------------------------->
    <h2>Current Deals</h2>
    <div class="cart-table-container">
        <?php
        $result = mysqli_query($conn, "SELECT * FROM menu_items WHERE category = 'Deal'");
        if (mysqli_num_rows($result) === 0): ?>
            <p class="text-center pad-2rem">No deals available.</p>
        <?php else: ?>
            <table class="cart-table">
                <thead>
                    <tr>
                        <th>Image</th>
                        <th>Name</th>
                        <th>Description</th>
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
                            <td><?= htmlspecialchars($row['description']) ?></td>
                            <td>
                                <form method="post" action="delete-deal.php"
                                      onsubmit="return confirm('Are you sure you want to delete this deal?');">
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

    <!---------------
    /* Add New Deal
    /*--------------->
    <h2>Add New Deal</h2>
    <div class="checkout-table-container">
        <form method="post" action="add-deal.php" enctype="multipart/form-data">
            <!---------------
            /* Basic Deal Info
            /*--------------->
            <div class="form-row">
                <label for="name"><strong>Deal Name:</strong></label><br>
                <input type="text" id="name" name="name" class="form-input" required><br><br>
            </div>

            <div class="form-row">
                <label for="description"><strong>Deal Description:</strong></label><br>
                <textarea id="description" name="description" class="form-input" rows="3" required></textarea><br><br>
            </div>

            <div class="form-row">
                <label for="image"><strong>Image Filename (in images/):</strong></label><br>
                <input type="text" id="image" name="image" class="form-input"
                       placeholder="e.g. 2medium.png" required><br><br>
            </div>

            <div class="form-row">
                <label for="flat_price"><strong>Flat Price:</strong></label><br>
                <input type="number" step="0.01" id="flat_price" name="flat_price" class="form-input" required><br><br>
            </div>

            <hr><br>

            <!--------------------
            /* Deal Requirements
            /*-------------------->
            <h3>Deal Requirements</h3>
            <div id="requirements-container">
                <div class="requirement-block">
                    <!--------------------
                    /* Required Category
                    /*-------------------->
                    <div class="form-row">
                        <label><strong>Required Category:</strong></label><br>
                        <select name="required_category[]" class="form-input" required>
                            <option value="Pizza">Pizza</option>
                            <option value="Side">Side</option>
                            <option value="Drink">Drink</option>
                        </select><br><br>
                    </div>

                    <!--------------------
                    /* Quantity Required
                    /*-------------------->
                    <div class="form-row">
                        <label><strong>Quantity Required:</strong></label><br>
                        <input type="number" name="quantity[]" min="1" class="form-input" required><br><br>
                    </div>

                    <!---------------------------------
                    /* Required Size (optional)
                    /*--------------------------------->
                    <div class="form-row">
                        <label><strong>Required Size (optional):</strong></label><br>
                        <select name="required_size[]" class="form-input">
                            <option value="">Any Size</option>
                            <option value="Small">Small</option>
                            <option value="Medium">Medium</option>
                            <option value="Large">Large</option>
                            <option value="Regular">Regular</option>
                            <option value="Can">Can</option>
                        </select><br><br>
                    </div>

                    <!---------------------------------
                    /* Required Name (optional)
                    /*--------------------------------->
                    <div class="form-row">
                        <label><strong>Required Name (optional):</strong></label><br>
                        <input type="text" name="required_name[]" class="form-input"
                               placeholder="e.g. Garlic Bread"><br><br>
                    </div>

                    <hr>
                </div>
            </div>

            <!---------------------------------
            /* Add More Requirements
            /*--------------------------------->
            <div class="form-row">
                <button type="button" onclick="addRequirement()" class="theme-submit">Add Another Requirement</button><br><br>
            </div>

            <!----------
            /* Submit
            /*---------->
            <div class="submit">
                <button type="submit" class="theme-submit">Add Deal</button>
            </div>
        </form>
    </div>
</main>
<!------------------------
/* Include shared footer
/*------------------------>
<?php include '../includes/footers.php'; ?> <!-- Outputs the page footer and contact/support request -->