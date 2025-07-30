<?php
/*-------------------------------------------------------------
/* File: submit-support.php
/* Description: Handles support request form submission. Validates
/*              user access, saves message to the database, and
/*              displays success or error message.
/*-------------------------------------------------------------
/* Author: Alyssa Cabana
/*-------------------------------------------------------------*/

session_start();

/*------------------------------
/* Include shared page elements
/*------------------------------*/
require_once 'includes/database.php';  // Connects to the database
require_once 'includes/headers.php';   // Outputs the page header/nav

echo "<main class='text-center pad-2rem'>";

/*---------------------------------------------------------------------------
/* Prevent non-users from submitting support request (including admins)
/*---------------------------------------------------------------------------*/
if (!isset($_SESSION['logged_in']) || $_SESSION['role'] !== 'user') {
    echo "<h2>Only regular users can submit support requests.</h2>";
    echo "</main>";
    require_once 'includes/footers.php';
    exit();
}

/*------------------------------------------------------------------------------------------
/* Get form input and trim (cut excess whitespaces at the beginning and end of the string)
/*------------------------------------------------------------------------------------------*/
$user_id = $_SESSION['user_id'];
$subject = trim($_POST['subject']);    // Subject of the support message
$message = trim($_POST['message']);    // Full message text

/*------------------------------------------------------
/* Submit support request to database
/*-----------------------------------------------------*/
$stmt = $conn->prepare(
    "INSERT INTO support_requests (user_id, subject, message) VALUES (?, ?, ?)"
);
$stmt->bind_param("iss", $user_id, $subject, $message);

/*-----------------------------------------------------------
/* Show status message to the user after submit
/* ✅ Include check and ❌ icons for clarity to the user
/*----------------------------------------------------------*/
if ($stmt->execute()) {
    echo "<h2>✅ Your request has been submitted successfully!</h2>";
    echo "<p>Thank you for reaching out. We’ll get back to you soon.</p>";
} else {
    echo "<h2>❌ Error submitting request.</h2>";
    echo "<p>Please try again later or contact us directly.</p>";
}

$stmt->close();

echo "</main>";

/*-------------------------
/* Include shared footer
/*------------------------*/
require_once 'includes/footers.php';  // Outputs the page footer and contact/support request
?>