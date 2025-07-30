<?php
/*-------------------------------------------------------------
/* File: register.php
/* Description: Handles user registration by validating and
/*              storing new user information. Prevents duplicate
/*              usernames or emails, and hashes passwords securely.
/*---------------------------------------------------------------
/* Author: Alyssa Cabana
/*-------------------------------------------------------------*/

session_start();

/*-------------------------
/* Include shared database
/*------------------------*/
require_once 'includes/database.php';  // Connects to the database

/*-------------------------------
/* Initialize status messages
/*-------------------------------*/
$error = "";
$success = "";

/*---------------------------------------
/* Process form data on POST submission
/*---------------------------------------*/
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST["username"]);
    $email = filter_var(trim($_POST["email"]), FILTER_SANITIZE_EMAIL);
    $password = password_hash($_POST["password"], PASSWORD_DEFAULT);

    /*------------------------
    /* Validate email format 
    /*------------------------*/
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Please enter a valid email address.";

    } else {
        /*----------------------------------
        /* Check if username already exists
        /*----------------------------------*/
        $stmt = $conn->prepare("SELECT id FROM users WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $error = "Username already taken.";

        } else {
            /*-------------------------------
            /* Check if email already exists
            /*-------------------------------*/
            $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $stmt->store_result();

            if ($stmt->num_rows > 0) {
                $error = "Email already registered.";

            } else {
                /*------------------------------------------------------
                /* Insert new user record with hashed password
                /*------------------------------------------------------*/
                $stmt = $conn->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
                $stmt->bind_param("sss", $username, $email, $password);

                if ($stmt->execute()) {
                    $success = "Account created! You can now log in.";
                } else {
                    $error = "Something went wrong. Please try again.";
                }
            }
        }
    }
}
?>

<!------------------------------
/* Include shared page header
/*------------------------------>
<?php include("includes/headers.php"); ?> <!-- Outputs the page header/nav -->

<main>
    <!----------------------------------------
    /* Help button linking to register help
    /*---------------------------------------->
    <div class="help-link-container">
        <a href="help/help-register.php" class="help-button" title="Need help with your cart?">?</a>
    </div>

    <!--------------------------------
    /* Registration form card
    /*------------------------------->
    <div class="login-card">
        <h2>Create Account</h2>

        <!-------------------------------
        /* Display error/success messages
        /*-------------------------------->
        <?php if ($error) echo "<p style='color:red;'>$error</p>"; ?>
        <?php if ($success) echo "<p style='color:green;'>$success</p>"; ?>

        <!-------------------------------
        /* User registration form
        /*-------------------------------->
        <form method="post">
            <label>Username:</label><br>
            <input type="text" name="username" required><br><br>

            <label>Email:</label><br>
            <input type="email" name="email" required><br><br>

            <label>Password:</label><br>
            <input type="password" name="password" required><br><br>

            <button type="submit">Register</button>
        </form>
    </div>
</main>

<!------------------------
/* Include shared footer
/*------------------------>
<?php include("includes/footers.php"); ?> <!-- Outputs the page footer and contact/support request -->