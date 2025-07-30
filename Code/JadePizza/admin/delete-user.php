<?php
/*-------------------------------------------------------------
/* File: delete-user.php
/* Description:  Processes admin request to delete a user account
/*-------------------------------------------------------------
/* Author: Alyssa Cabana
/*-------------------------------------------------------------*/

session_start();
/*-------------------------
/* Include shared database
/*------------------------*/
require_once '../includes/database.php'; // Connects to the database


/*----------------------------------------------------
/* Ensure only admins can access this page
/*---------------------------------------------------*/
if (!isset($_SESSION['logged_in']) || $_SESSION['role'] !== 'admin') {
    header("Location: /JadePizza/login.php");
    exit();
}

/*----------------------------------------------------
/* Handle valid POST request with a user id
/*---------------------------------------------------*/
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['user_id'])) {
    $user_id = (int)$_POST['user_id'];

    /*----------------------------------------------------
    /* Prevent an admin from deleting their own account
    /*---------------------------------------------------*/
    if (isset($_SESSION['user_id']) && $_SESSION['user_id'] == $user_id) {
        die("⚠️ You cannot delete your own account.");
    }

    /*----------------------------------------------------
    /* Prepare deletion query
    /*---------------------------------------------------*/
    $stmt = $conn->prepare("DELETE FROM users WHERE id = ?");
    $stmt->bind_param("i", $user_id);

    /*----------------------------------------------------
    /* Execute and handle result
    /*---------------------------------------------------*/
    if ($stmt->execute()) {
        header("Location: manage-users.php?success=1");
        exit();
    } else {
        echo "❌ Error deleting user.";
    }

    $stmt->close();
} else {
    echo "❌ Invalid request.";
}
?>
