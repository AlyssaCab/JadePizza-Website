<?php
/*-------------------------------------------------------------
/* File: delete-requests.php
/* Description:  Allows admin to delete a support requests
/*-------------------------------------------------------------
/* Author: Alyssa Cabana
/*-------------------------------------------------------------*/

session_start();
/*-------------------------
/* Include shared database
/*------------------------*/
require_once '../includes/database.php'; // Connects to the database

/*----------------------------------------------------
/* Restrict access to admins only
/*---------------------------------------------------*/
if (!isset($_SESSION['logged_in']) || $_SESSION['role'] !== 'admin') {
    header("Location: /JadePizza/login.php");
    exit();
}

/*----------------------------------------------------
/* Handle POST deletion request
/*---------------------------------------------------*/
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    $id = (int)$_POST['id'];

    /*----------------------------------------------------
    /* Prepare deletion statement
    /*---------------------------------------------------*/
    $stmt = $conn->prepare("DELETE FROM support_requests WHERE id = ?");
    $stmt->bind_param("i", $id);

    /*----------------------------------------------------
    /* Execute and redirect on success
    /*---------------------------------------------------*/
    if ($stmt->execute()) {
        header("Location: manage-support-request.php?deleted=1");
        exit();
    } else {
        echo "❌ Failed to delete support request.";
    }

    $stmt->close();
} else {
    echo "❌ Invalid request.";
}
?>
