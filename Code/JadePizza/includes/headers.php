<?php
/*-------------------------------------------------------------
/* File: headers.php
/* Description: Outputs the main HTML header including
/*              metadata, theme styling, nav bar, and
/*              support popup modal.
/*-------------------------------------------------------------
/* Author: Alyssa Cabana
/*-------------------------------------------------------------*/

/*----------------------------------------
/* Start session if not already active
/*----------------------------------------*/
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

/*---------------------
/* Include theme logic
/*---------------------*/
include("theme.php");
?>

<!------------------------------
/* Apply active theme stylesheet
/*------------------------------>
<link rel="stylesheet" href="css/<?php echo htmlspecialchars($theme); ?>.css">

<!DOCTYPE html>
<html lang="en">
<head>
    <!------------------------------
    /* Page Meta Info
    /*------------------------------>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Order fresh, handmade pizzas from Jade Pizza.">
    <meta name="keywords" content="pizza, Windsor, Jade Pizza">
    <meta name="author" content="Alyssa Cabana">
    <title>Welcome to Jade Pizza</title>

    <!------------------------------
    /* Core Styles
    /*------------------------------>
    <link rel="stylesheet" href="/JadePizza/css/style.css">

    <!------------------------------
    /* Active Theme Styles
    /*------------------------------>
    <link rel="stylesheet" href="/JadePizza/css/themes/<?= htmlspecialchars($theme) ?>.css">
</head>

<body>
<div class="page-container">
    <!------------------------------
    /* Site Navigation
    /*------------------------------>
    <header>
        <nav>
            <a href="/JadePizza/index.php">Home</a>
            <a href="/JadePizza/about.php">About</a>
            <a href="/JadePizza/menu.php">Menu</a>

            <?php if (isset($_SESSION['logged_in']) && $_SESSION['role'] === 'admin'): ?>
                <a href="/JadePizza/admin/admin-dashboard.php">Admin Panel</a>
                <a href="/JadePizza/profile.php">Profile</a>
                <a href="/JadePizza/logout.php">Logout</a>
            <?php elseif (isset($_SESSION['logged_in']) && $_SESSION['role'] === 'user'): ?>
                <a href="/JadePizza/profile.php">Profile</a>
                <a href="/JadePizza/logout.php">Logout</a>
            <?php else: ?>
                <a href="/JadePizza/login.php">Login</a>
                <a href="/JadePizza/register.php">Register</a>
            <?php endif; ?>

            <a href="/JadePizza/cart.php">Cart</a>
        </nav>
    </header>

    <!------------------------------
    /* Support Email Popup Modal
    /*------------------------------>
    <div id="emailPopup" class="popup">
        <div class="popup-content">
            <span class="close" onclick="closePopup()">&times;</span>
            <h2>Support Message</h2>
            <p>Or call us at: <strong>(519) 555-FAKE</strong></p>
            <form method="post" action="/JadePizza/submit-support.php">
                <input type="text" name="subject" placeholder="Subject" required>
                <textarea name="message" placeholder="Your Message" rows="5" required></textarea>
                <button type="submit">Send</button>
            </form>
        </div>
    </div>
