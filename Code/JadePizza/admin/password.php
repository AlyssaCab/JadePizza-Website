<?php
/*-----------------------------------------------------------------------------------------
/* File: password.php
/* Description: Generates a hashed version of the word "password" for admins password
/*-----------------------------------------------------------------------------------------
/* Author: Alyssa Cabana
/*-----------------------------------------------------------------------------------------*/
echo password_hash("password", PASSWORD_DEFAULT);
?>