<?php
/*-------------------------------------------------------------
/* File: theme.php
/* Description: Fetches the currently active site theme
/*              from the site_themes table. If none is
/*              active, defaults to "spring".
/*-------------------------------------------------------------
/* Author: Alyssa Cabana
/*-------------------------------------------------------------*/

/*-------------------------
/* Include shared database
/*------------------------*/
require_once 'database.php'; // Connects to the database

/*-------------------------
/* Default fallback theme
/*------------------------*/
$theme = 'spring';


/*--------------------------------
/* Get active theme from database
/*--------------------------------*/
$sql = "SELECT theme FROM site_themes WHERE is_active = 1 LIMIT 1";
$result = $conn->query($sql);

/*------------------------------
/* If a theme is found, use it
/*-----------------------------*/
if ($result && $row = $result->fetch_assoc()) {
    $theme = $row['theme'];
}
?>
