<?php
/*--------------------------------------------------------------------
/* File: index.php
/* Description: Homepage for Jade Pizza website. Displays hero section,
/*              featured specials, current deals, and embedded videos.
/*--------------------------------------------------------------------
/* Author: Alyssa Cabana
/*--------------------------------------------------------------------*/

/*-------------------------
/* Include shared database
/*------------------------*/
include 'includes/database.php';    // Connects to the database

/*-------------------------------
/* Fetch specials and deals
/*-------------------------------*/
$specials_query = "SELECT * FROM menu_items WHERE is_special = 1";
$specials_result = mysqli_query($conn, $specials_query);

$deal_query = "SELECT * FROM menu_items WHERE category = 'Deal'";
$deal_result = mysqli_query($conn, $deal_query);
?>

<!------------------------------
/* Include shared page header
/*------------------------------>
<?php include 'includes/headers.php'; ?>    <!-- Outputs the page header/nav -->

<main>
    <!-------------
    /* Hero Banner
    /*------------->
    <section class="hero">
        <div class="hero-text">
            <img src="images/logo.png" alt="Jade Pizza Logo.">
            <h1>Welcome to Jade Pizza! 🍕</h1>
            <p>The home of fresh handmade, oven-baked, delicious pizzas!</p>
        </div>
    </section>

    <!-------------
    /* Pizza video
    /*------------->
    <section class="highlights">
        <h2>Where the magic happens!</h2>
        <video controls width="100%">
            <source src="video&audio/pizzabeg.mp4" type="video/mp4">
            Your browser does not support the video tag.
        </video>
    </section>

    <!-----------------------------------------------------
    /* Featured Specials (Auto fills based off menu)
    /*----------------------------------------------------->
    <section class="featured">
        <h2>Specials 🍕</h2>
        <div class="pizza-grid">
            <?php if (mysqli_num_rows($specials_result) > 0): ?>
                <?php while ($special = mysqli_fetch_assoc($specials_result)): ?>
                    <div class="pizza-card">
                        <img src="<?= htmlspecialchars($special['image']) ?>" alt="<?= htmlspecialchars($special['description']) ?>">
                        <h3><?= htmlspecialchars($special['name']) ?></h3>
                        <p><?= htmlspecialchars($special['description']) ?></p>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <p class="text-center">No specials available right now.</p>
            <?php endif; ?>
        </div>
    </section>

    <!-----------------------------------------------------
    /* Current Deals (Auto fills based off menu)
    /*----------------------------------------------------->
    <section class="deals">
        <h2>Check Out Our Current Deals!</h2>
        <div class="deal-grid">
            <?php while ($deal = mysqli_fetch_assoc($deal_result)): ?>
                <div class="deal-card">
                    <img src="<?= htmlspecialchars($deal['image']) ?>" alt="<?= htmlspecialchars($deal['description']) ?>">
                    <h3><?= htmlspecialchars($deal['name']) ?></h3>
                    <p><?= htmlspecialchars($deal['description']) ?></p>
                </div>
            <?php endwhile; ?>
        </div>
    </section>

    <!-----------------
    /* Call to action
    /*----------------->
    <section class="call-to-action">
        <h2>Craving pizza? Let's make it happen 🍕</h2>
    </section>

    <!-------------
    /* Oven video
    /*------------->
    <section class="highlights">
        <video controls width="100%">
            <source src="video&audio/oven.mp4" type="video/mp4">
            Your browser does not support the video tag.
        </video>
    </section>
</main>

<!------------------------
/* Include shared footer
/*------------------------>
<?php include 'includes/footers.php'; ?>    <!-- Outputs the page footer and contact/support request -->