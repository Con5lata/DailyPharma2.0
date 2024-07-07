<?php

// Start session
session_start();

// Establish a connection
require_once("../connect.php");

// Variable to hold error messages
$error = '';

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $patientSSN = trim($_POST['Patient_SSN']);
    $password = trim($_POST['Password']);

    // Retrieve user details from the database
    if (empty($error)) {
        if ($query = $conn->prepare("SELECT * FROM patients WHERE `Patient_SSN` = ? AND `Status` = 'active'")) {
            $query->bind_param('s', $patientSSN);
            $query->execute();
            $result = $query->get_result();
            $row = $result->fetch_assoc();

            if ($row) {
                // Check if the entered password matches the hashed password in the database
                if (password_verify($password, $row['Password'])) {
                    $_SESSION["user"] = "Patient";
                    $_SESSION["userid"] = $row['Patient_SSN'];
                    $_SESSION["username"] = $row['Patient_Name'];
                    $_SESSION["userdata"] = $row;

                    // Close connections
                    $query->close();
                    $conn->close();

                    // Redirect to the patient view page
                    header("Location: patientView.php");
                    exit;
                } else {
                    $error .= 'The password is not valid.';
                }
            } else {
                $error .= 'No user exists with that Patient SSN or account has been deactivated. Please try again or contact us via DailyPharma@gmail.com';
            }
        } else {
            $error .= 'Database query error.';
        }
    }
}

// Display error messages if any
if (!empty($error)) {
    echo "<script>alert('$error');</script>";
    echo "<script>window.location.href = '../patientlogin.html';</script>";
    exit;
}

?>
