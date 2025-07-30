<?php
/*-------------------------------------------------------------
/* File: login.php
/* Description: Authenticates users or admins based on provided username
/*              and password. Sets appropriate session variables and redirects
/*              to user homepage upon success.
/*-------------------------------------------------------------
/* Author: Alyssa Cabana
/*-------------------------------------------------------------*/

session_start();

/*-------------------------
/* Include shared database
/*------------------------*/
require_once 'includes/database.php';   // Connects to the database

/*-------------------------------------------
/* Initialize error message variable
/*-------------------------------------------*/
$error = "";

/*------------------------------------------------------
/* Handle login form submission through POST request
/*------------------------------------------------------*/
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];

    /*-------------------------------------
    /* Attempt to log in as an admin first
    /*-------------------------------------*/
    $stmt = $conn->prepare("SELECT * FROM admins WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($row = $result->fetch_assoc()) {
        if (password_verify($password, $row['password'])) {
            /*----------------
            /* Admin success
            /*----------------*/
            $_SESSION['logged_in'] = true;
            $_SESSION['username'] = $row['username'];
            $_SESSION['role'] = 'admin';
            $_SESSION['admin_id'] = $row['id'];
            header("Location: /JadePizza/admin/admin-dashboard.php");
            exit();
        } else {
            $error = "Incorrect password.";
        }
    } else {
        /*------------------------------------
        /* If not admin, check users table
        /*------------------------------------*/
        $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($row = $result->fetch_assoc()) {
            if (password_verify($password, $row['password'])) {
                /*----------------
                /* User success
                /*----------------*/
                $_SESSION['logged_in'] = true;
                $_SESSION['username'] = $row['username'];
                $_SESSION['role'] = 'user';
                $_SESSION['user_id'] = $row['id'];
                header("Location: index.php");
                exit();
            } else {
                $error = "Incorrect password.";
            }
        } else {
            $error = "Account not found.";
        }
    }
}
?>

<!------------------------------
/* Include shared page header
/*------------------------------>
<?php include("includes/headers.php"); ?>   <!-- Outputs the page header/nav -->
<main>
    <!----------------------------------------
    /* Help button linking to login help
    /*---------------------------------------->
    <div class="help-link-container">
        <a href="help/help-login.php" class="help-button" title="Need help with your cart?">?</a>
    </div>

    <div class="login-card">
        <h2>Login</h2>

        <?php if (!empty($error)): ?>
            <p style="color:red;"><?= htmlspecialchars($error) ?></p>
        <?php endif; ?>

        <!--------------
        /* Login form
        /*-------------->
        <form method="post" action="">
            <label>Username:</label><br>
            <input type="text" name="username" required><br><br>

            <label>Password:</label><br>
            <div class="password-wrapper">
                <input type="password" name="password" id="password" required>
                <button type="button" class="toggle-password" onclick="togglePassword()">👁</button>
            </div>
            <br><br>

            <button type="submit">Login</button>
        </form>
    </div>
</main>

<!------------------------
/* Include shared footer
/*------------------------>
<?php include("includes/footers.php"); ?>   <!-- Outputs the page footer and contact/support request -->
