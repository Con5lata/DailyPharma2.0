<?php

// Establish a PHP session (if needed)
session_start();

// Establish a connection to the database
require_once("../connect.php");

// Function to calculate age from date of birth
function calculateAge($dob) {
    $currentYear = date("Y");
    $birthYear = date("Y", strtotime($dob));
    return $currentYear - $birthYear;
}

// Initialize the error message
$error = '';

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Sanitize and retrieve form data
    $patientSSN = trim($_POST['Patient_SSN']);
    $patientName = trim($_POST['Patient_Name']);
    $patientAddress = trim($_POST['Patient_Address']);
    $patientEmail = trim($_POST['Patient_Email']);
    $patientPhone = trim($_POST['Patient_Phone']);
    $patientGender = trim($_POST['Patient_Gender']);
    $patientDOB = trim($_POST['Patient_DOB']);
    $password = trim($_POST['Password']);
    $confirmPassword = trim($_POST['Confirm_Password']);

    // Validate the form data (you can add more validation if needed)
    if (empty($patientSSN) || empty($patientName) || empty($patientAddress) || empty($patientEmail) || empty($patientPhone) || empty($patientGender) || empty($patientDOB) || empty($password) || empty($confirmPassword)) {
        $error = 'Please fill in all the required fields.';
    } elseif ($password !== $confirmPassword) {
        $error = 'Password and Confirm Password do not match.';
    }

    if (empty($error)) {
        // Calculate the patient's age
        $patientAge = calculateAge($patientDOB);

        // Prepare and execute the database insert statement
        $query = $conn->prepare("INSERT INTO `patients`(`Patient_SSN`, `Patient_Name`, `Patient_Address`, `Patient_Email`, `Patient_Phone`, `Patient_Gender`, `Patient_DOB`, `Patient_Age`, `Password`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $query->bind_param('isssissss', $patientSSN, $patientName, $patientAddress, $patientEmail, $patientPhone, $patientGender, $patientDOB, $patientAge, $password);
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