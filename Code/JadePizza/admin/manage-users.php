<?php
/*-----------------------------------------------------------------------------
/* File: manage-users.php
/* Description: Admin page to manage and delete users, as well as view admins
/*-----------------------------------------------------------------------------
/* Author: Alyssa Cabana
/*-----------------------------------------------------------------------------*/

session_start();
/*------------------------------
/* Include shared page elements
/*------------------------------*/
include '../includes/database.php'; // Connects to the database
include '../includes/headers.php'; // Outputs the page header/nav

/*------------------------------
/* Redirect if not admin
/*------------------------------*/
if (!isset($_SESSION['logged_in']) || $_SESSION['role'] !== 'admin') {
    header("Location: /JadePizza/login.php");
    exit();
}


?>

<main class="admin-panel">
    <!----------------------------------------
    /* Help button linking to users help
    /*---------------------------------------->
    <div class="help-link-container">
        <a href="../help/help-admin-users.php" class="help-button" title="Need help with managing users?">?</a>
    </div>

    <h1>Manage Users</h1>

    <!----------------------------------------
    /* Registered Users
    /*---------------------------------------->
    <h2>Registered Users</h2>
    <div class="cart-table-container">
        <?php
        $user_result = mysqli_query($conn, "SELECT * FROM users ORDER BY id ASC");
        if (mysqli_num_rows($user_result) === 0): ?>
            <p class="text-center pad-2rem">No users found.</p>
        <?php else: ?>
            <table class="cart-table">
                <thead>
                    <tr>
                        <th>User ID</th>
                        <th>Username</th>
                        <th>Email</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = mysqli_fetch_assoc($user_result)): ?>
                        <tr>
                            <td><?= htmlspecialchars($row['id']) ?></td>
                            <td><?= htmlspecialchars($row['username']) ?></td>
                            <td><?= htmlspecialchars($row['email']) ?></td>
                            <td>
                                <form method="post" action="delete-user.php"
                                      onsubmit="return confirm('Are you sure you want to delete this user?');">
                                    <input type="hidden" name="user_id" value="<?= $row['id'] ?>">
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
    /* Admin Accounts
    /*---------------------------------------->
    <h2>Admin Accounts</h2>
    <div class="cart-table-container">
        <?php
        $admin_result = mysqli_query($conn, "SELECT * FROM admins ORDER BY id ASC");
        if (mysqli_num_rows($admin_result) === 0): ?>
            <p class="text-center pad-2rem">No admin accounts found.</p>
        <?php else: ?>
            <table class="cart-table">
                <thead>
                    <tr>
                        <th>Admin ID</th>
                        <th>Username</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($admin = mysqli_fetch_assoc($admin_result)): ?>
                        <tr>
                            <td><?= htmlspecialchars($admin['id']) ?></td>
                            <td><?= htmlspecialchars($admin['username']) ?></td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>
</main>
<!------------------------
/* Include shared footer
/*------------------------>
<?php include '../includes/footers.php'; ?> <!-- Outputs the page footer and contact/support request -->