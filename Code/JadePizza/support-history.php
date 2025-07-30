<?php
/*-------------------------------------------------------------
/* File: support-history.php
/* Description: Displays all support requests submitted by the
/*              currently logged-in user, along with any admin
/*              responses. Redirects unauthorized users.
/*-------------------------------------------------------------
/* Author: Alyssa Cabana
/*-------------------------------------------------------------*/

session_start();

/*-------------------------------------------------------------
/* Redirect if user is not logged in or not a user (if admin)
/*------------------------------------------------------------*/
if (!isset($_SESSION['logged_in']) || $_SESSION['role'] !== 'user') {
    header("Location: login.php");
    exit();
}

/*------------------------------
/* Include shared page elements
/*------------------------------*/
include 'includes/database.php';   // Connects to the database
include 'includes/headers.php';    // Outputs the page header/nav

/*-----------------------------------------
/* Get support requests for current user
/*----------------------------------------*/
$user_id = $_SESSION['user_id'];

$query = "SELECT * FROM support_requests WHERE user_id = ? ORDER BY created_at DESC";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<main>
    <div class="login-card">
        <h2>Your Support Request History</h2>
        <!--------------------------------------------
        /* If no support requests exist for this user
        /*-------------------------------------------->
        <?php if ($result->num_rows === 0): ?>
            <p>You haven't submitted any support requests yet.</p>
        <?php else: ?>
            <!-------------------------------------------------
            /* Loop through each support request submitted     
            /* by the user and display relevant information    
            /*------------------------------------------------->
            <?php while ($row = $result->fetch_assoc()): ?>
                <div class="cart-table-container" style="margin-bottom: 1.5rem;">

                    <!---------------------------------
                    /* Submitted date and subject line
                    /*--------------------------------->
                    <p><strong>Submitted:</strong> <?= htmlspecialchars($row['created_at']) ?></p>
                    <p><strong>Subject:</strong> <?= htmlspecialchars($row['subject']) ?></p>

                    <!-------------------------------
                    /* Display user's original message
                    /*------------------------------->
                    <p><strong>Your Request:</strong></p>
                    <div class="cart-table-container" style="margin-bottom: 1rem;">
                        <p><?= nl2br(htmlspecialchars($row['message'])) ?></p>
                    </div>

                    <?php if ($row['response']): ?>
                        <!----------------------------------------------
                        /* Show the admin's response if it has been sent
                        /*---------------------------------------------->
                        <p><strong>Admin Response:</strong></p>
                        <div class="cart-table-container" style="background: #f9f9f9; border-left: 4px solid #4caf50;">
                            <p><?= nl2br(htmlspecialchars($row['response'])) ?></p>
                        </div>
                    <!---------------------------------------------
                    /* Display if response hasn't been provided
                    /*---------------------------------------------> 
                    <?php else: ?>
                        <p><em>No response yet.</em></p>
                    <?php endif; ?>

                </div>
            <?php endwhile; ?>
        <?php endif; ?>
    </div>
</main>

<?php
/*-------------------------
/* Include shared footer
/*------------------------*/
include 'includes/footers.php';  // Outputs the page footer and contact/support request
?>
