<?php
/*-------------------------------------------------------------
/* File: respond-support.php
/* Description: Handles admin response to support request
/*              Updates support_requests table with reply
/*-------------------------------------------------------------
/* Author: Alyssa Cabana
/*-------------------------------------------------------------*/

/*-------------------------
/* Include shared database
/*------------------------*/
include '../includes/database.php'; // Connects to the database

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $request_id = $_POST['request_id'];
    $response = $_POST['response'];
    /*---------------------------------------
    /* Update the response in the database
    /*--------------------------------------*/
    $stmt = $conn->prepare("UPDATE support_requests SET response = ? WHERE id = ?");
    $stmt->bind_param("si", $response, $request_id);
    $stmt->execute();
    /*----------------------------------------------
    /* Redirect back to support management page
    /*---------------------------------------------*/
    header("Location: manage-support-request.php");
    exit;
}
?>