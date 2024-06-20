<?php
//establish a php session
session_start();

require_once "../connect.php";

// Check if the user is logged in
if (!isset($_SESSION["userid"]) || !isset($_SESSION["user"])) {
    // Redirect to the login page if the user is not logged in
    header("Location: ../login.html");
    exit;
}

// Get the user information from the session variables
$user = $_SESSION["user"];
$ID = $_SESSION["userid"];
$username = $_SESSION["username"];

?>