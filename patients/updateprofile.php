<?php
session_start();
require_once "../connect.php";

// Check if the user is logged in
if (!isset($_SESSION["userid"]) || !isset($_SESSION["username"])) {
    header("Location: patientlogin.html");
    exit;
}

// Get the user information from the session variables
$ID = $_SESSION["userid"];

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["update"])) {
    // Get data from POST
    $name = $_POST["Patient_Name"];
    $email = $_POST["Patient_Email"];
    $phone = $_POST["Patient_Phone"];
    $gender = $_POST["Patient_Gender"];
    $dob = $_POST["Patient_DOB"];
    $age = $_POST["Patient_Age"];

    // Prepare the SQL statement
    $update_sql = $conn->prepare("UPDATE patients SET Patient_Name=?, Patient_Email=?, Patient_Phone=?, Patient_Gender=?, Patient_DOB=?, Patient_Age=? WHERE Patient_SSN=?");
    
    // Check if the prepare was successful
    if ($update_sql === false) {
        // Output error details
        die("MySQL prepare statement failed: " . $conn->error);
    }

    // Bind parameters
    $update_sql->bind_param("ssssssi", $name, $email, $phone, $gender, $dob, $age, $ID);
    
    // Execute the statement
    if ($update_sql->execute()) {
        // Set success message in session
        $_SESSION['update_message'] = 'Profile successfully updated.';
    } else {
        // Optionally handle errors
        $_SESSION['update_message'] = 'Profile update failed. Please try again.';
    }
    
    // Redirect to the profile view page after successful update
    header("Location: patientView.php");
    exit;
} elseif ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["cancel"])) {
    header("Location: patientView.php");
    exit;
} else {
    header("Location: profile.php");
    exit;
}
