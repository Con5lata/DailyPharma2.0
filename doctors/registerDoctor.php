<?php

// Establish a PHP session (if needed)
session_start();

// Establish a connection to the database
require_once("../connect.php");

function calculateExp($exp) {
    $currentYear = date("Y");
    $startYear = date("Y", strtotime($exp));
    return $currentYear - $startYear;
}

// Initialize the error message
$error = '';

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] === "POST") {
         // Sanitize and retrieve form data
    $doctorSSN = trim($_POST['Doctor_SSN']);
    $doctorName = trim($_POST['Doctor_Name']);
    $doctorPhone = trim($_POST['Doctor_Phone']);
    $doctorSpeciality = trim($_POST['Doctor_Speciality']);
    $doctorExperience = trim($_POST['Doctor_Experience']);
    $password = trim($_POST['Password']);
    $confirmPassword = trim($_POST['Confirm_Password']);

    // Validate the form data (you can add more validation if needed)
    if (empty($doctorSSN) || empty($doctorName) || empty($doctorPhone) || empty($doctorSpeciality) || empty($doctorExperience) || empty($password) || empty($confirmPassword)) {
        $error = 'Please fill in all the required fields.';
    } elseif ($password !== $confirmPassword) {
        $error = 'Password and Confirm Password do not match.';
    }

    if (empty($error)) {
        // Calculate the patient's age
        $doctorExp = calculateExp($doctorExperience);

        // Prepare and execute the database insert statement
        $query = $conn->prepare("INSERT INTO `doctors`(`Doctor_SSN`, `Doctor_Name`, `Doctor_Phone`, `Doctor_Speciality`, `Doctor_Experience`, `Password`) VALUES (?, ?, ?, ?, ?, ?)");
        $query->bind_param('ssssis', $doctorSSN, $doctorName, $doctorPhone, $doctorSpeciality, $doctorExperience, $password);
        if ($query->execute()) {
            // Registration successful, redirect to login page
            header("Location: ../login.html");
            exit;
        } else {
            $error = 'Error registering the user. Please try again later.';
        }
        $query->close();
    }
} 

if(!empty($error)){
    // Display the error message as an alert
    echo "<script>alert('$error');</script>";
    echo "<script>window.location.href = '../register.php';</script>";
    exit;
}

?>