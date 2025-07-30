<?php
/*-----------------------------------------------------------------------------
/* File: manage-support-request.php
/* Description: Admin page to view and respond to support message
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
    /* Help button linking to support help
    /*---------------------------------------->
    <div class="help-link-container">
        <a href="../help/help-admin-support.php" class="help-button" title="Need help with support requests?">?</a>
    </div>

    <h1>Contact Messages</h1>

    <div class="cart-table-container">
        <?php
        $result = mysqli_query($conn, "SELECT * FROM support_requests ORDER BY created_at DESC");
        if (mysqli_num_rows($result) === 0): ?>
            <p class="text-center pad-2rem">No contact messages found.</p>
        <?php else: ?>
            <table class="cart-table">
                <thead>
                    <tr>
                        <th>User ID</th>
                        <th>Subject</th>
                        <th>Message</th>
                        <th>Submitted At</th>
                        <th>Admin Response</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = mysqli_fetch_assoc($result)): ?>
                        <tr>
                            <td><?= nl2br(htmlspecialchars($row['user_id'])) ?></td>
                            <td><?= nl2br(htmlspecialchars($row['subject'])) ?></td>
                            <td><?= nl2br(htmlspecialchars($row['message'])) ?></td>
                            <td><?= htmlspecialchars($row['created_at']) ?></td>

                            <!----------------------------------------
                            /* Admin response section
                            /*---------------------------------------->
                            <td>
                                <?php if (!empty($row['response'])): ?>
                                    <strong>Sent:</strong><br>
                                    <?= nl2br(htmlspecialchars($row['response'])) ?>
                                <?php else: ?>
                                    <form method="post" action="respond-support.php">
                                        <input type="hidden" name="request_id" value="<?= $row['id'] ?>">
                                        <textarea name="response" rows="3" class="form-input" required placeholder="Type your reply here..."></textarea>
                                        <br>
                                        <button type="submit" class="theme-submit">Send Response</button>
                                    </form>
                                <?php endif; ?>
                            </td>

                            <!----------------------------------------
                            /* Delete message section
                            /*---------------------------------------->
                            <td>
                                <form method="post" action="delete-request.php"
                                      onsubmit="return confirm('Delete this message?');">
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
</main>
<!------------------------
/* Include shared footer
/*------------------------>
<?php include '../includes/footers.php'; ?> <!-- Outputs the page footer and contact/support request -->