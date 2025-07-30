<?php
/*--------------------------------------------------
/*  File: about.php
/*  Description: Displays the About page of Jade Pizza.
/*               Explains the fictional business and 
/*               project features. Uses shared header/footer.
---------------------------------------------------*/
?>
<!------------------------
/* Include shared header
/*------------------------>
<?php include("includes/headers.php"); ?>   <!-- Outputs the page header/nav -->

<main class="about">

    <!--------------------------------------------------
    /* About Section: Project and business description
    --------------------------------------------------->
    <div class="about-card">
        <h2>About Jade Pizza 🍕</h2>
        <p>
            Jade Pizza is a fictional pizza business made by Alyssa Cabana. 
            This website is the business' online ordering platform developed as a full-featured PHP and MYSQL website project. 
            The site allows users to browse through the business' menu of delicious premade pizzas, sides, drinks, and limited-time deals, 
            add these items to their cart, and place their order. On the backend, administrators can manage the items on the menu, and switch 
            the site between seasonal themes. This project is used to demonstrate the core web development skills that I have developed including, 
            dynamic content rendering, session handling, theme switching, database integration, and responsive design across desktops and mobile platforms.
        </p>
    </div>
</main>

<!------------------------
/* Include shared footer
/*------------------------>
<?php include("includes/footers.php"); ?>   <!-- Outputs the page footer and contact/support request -->
