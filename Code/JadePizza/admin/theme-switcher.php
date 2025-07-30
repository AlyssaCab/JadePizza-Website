<?php
/*-------------------------------------------------------------
/* File: theme-switcher.php
/* Description: Admin-only page for selecting active site theme
/*              Updates the 'site_themes' table to reflect choice
/*-------------------------------------------------------------
/* Author: Alyssa Cabana
/*-------------------------------------------------------------*/

session_start();
require '../includes/database.php';


/*------------------------------------------------
/* Redirect if not logged in or not an admin
/*------------------------------------------------*/
if (!isset($_SESSION['logged_in']) || $_SESSION['role'] !== 'admin') {
    header("Location: /JadePizza/login.php");
    exit();
}

/*------------------------------------------------
/* Get currently active theme from database
/*------------------------------------------------*/
$current_theme = 'spring'; // fallback/default
$result = $conn->query("SELECT theme FROM site_themes WHERE is_active = 1 LIMIT 1");
if ($result && $row = $result->fetch_assoc()) {
    $current_theme = $row['theme'];
}

/*------------------------------------------------
/* Handle theme update form submission
/*------------------------------------------------*/
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['theme'])) {
    $new_theme = $_POST['theme'];

    /*------------------------------------------------
    /* Set all themes to inactive
    /*------------------------------------------------*/
    $conn->query("UPDATE site_themes SET is_active = 0");

    /*------------------------------------------------
    /* Activate selected theme
    /*------------------------------------------------*/
    $stmt = $conn->prepare("UPDATE site_themes SET is_active = 1 WHERE theme = ?");
    $stmt->bind_param("s", $new_theme);
    $stmt->execute();

    /*------------------------------------------------
    /* Redirect with success message
    /*------------------------------------------------*/
    header("Location: theme-switcher.php?success=1");
    exit();
}
?>

<!------------------------------
/* Include shared page header
/*------------------------------>
<?php include("../includes/headers.php"); ?>    <!-- Outputs the page header/nav -->
<main>
    <!----------------------------------------
    /* Help button linking to themes help
    /*---------------------------------------->
    <div class="help-link-container">
        <a href="../help/help-admin-themes.php" class="help-button" title="Need help with setting themes?">?</a>
    </div>

    <div class="theme">
        <h2>Choose Site Theme</h2>

        <!----------------------------------------
        /* Success message after update
        /*---------------------------------------->
        <?php if (isset($_GET['success'])): ?>
            <p style="color: green;">Theme updated successfully!</p>
        <?php endif; ?>

        <!----------------------------------------
        /* Theme selection form
        /*---------------------------------------->
        <form method="post" class="theme-card-form">
            <!----------
            /* Spring
            /*---------->
            <label class="theme-card">
                <img src="/JadePizza/images/spring.png" alt="Spring">
                <p>Spring</p>
                <input type="radio" name="theme" value="spring" <?php if ($current_theme == 'spring') echo 'checked'; ?>>
            </label>
            <!----------
            /* Summer
            /*---------->
            <label class="theme-card">
                <img src="/JadePizza/images/summer.png" alt="Summer">
                <p>Summer</p>
                <input type="radio" name="theme" value="summer" <?php if ($current_theme == 'summer') echo 'checked'; ?>>
            </label>
            <!----------
            /* Fall
            /*---------->
            <label class="theme-card">
                <img src="/JadePizza/images/fall.png" alt="Fall">
                <p>Fall</p>
                <input type="radio" name="theme" value="fall" <?php if ($current_theme == 'fall') echo 'checked'; ?>>
            </label>
            <!----------
            /* Winter
            /*---------->
            <label class="theme-card">
                <img src="/JadePizza/images/winter.png" alt="Winter">
                <p>Winter</p>
                <input type="radio" name="theme" value="winter" <?php if ($current_theme == 'winter') echo 'checked'; ?>>
            </label>

            <br><br>
            <button type="submit" class="theme-submit">Save Theme</button>
        </form>
    </div>
</main>

<!------------------------
/* Include shared footer
/*------------------------>
<?php include("../includes/footers.php"); ?>    <!-- Outputs the page footer and contact/support request -->
