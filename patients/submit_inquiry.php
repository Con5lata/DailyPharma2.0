<?php
// Start a PHP session
session_start();

// Include database connection
require_once("../connect.php");

// Initialize variables
$successMessage = '';
$errorMessage = '';

// Check if form data is received via POST
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Retrieve and sanitize input data
    $patientSSN = isset($_POST['Patient_SSN']) ? trim($_POST['Patient_SSN']) : '';
    $patientName = isset($_POST['Patient_Name']) ? trim($_POST['Patient_Name']) : '';
    $email = isset($_POST['Email']) ? trim($_POST['Email']) : '';
    $inquiry = isset($_POST['Inquiry']) ? trim($_POST['Inquiry']) : '';

    // Check if mandatory fields are provided
    if (empty($patientSSN) || empty($patientName) || empty($email) || empty($inquiry)) {
        $errorMessage = 'Please fill in all required fields.';
    } else {
        // Prepare SQL query to insert the inquiry
        $sql = "INSERT INTO inquiry (Patient_SSN, patient_Name, Email, Inquiry) VALUES (?, ?, ?, ?)";

        if ($stmt = $conn->prepare($sql)) {
            // Bind parameters and execute the query
            $stmt->bind_param('ssss', $patientSSN, $patientName, $email, $inquiry);

            if ($stmt->execute()) {
                $successMessage = 'Your inquiry has been submitted successfully!';
            } else {
                $errorMessage = 'There was a problem submitting your inquiry. Please try again.';
            }

            // Close the statement
            $stmt->close();
        } else {
            $errorMessage = 'Failed to prepare the SQL statement.';
        }
    }

    // Close the database connection
    $conn->close();

    // Redirect with a message
    if ($errorMessage) {
        echo "<script>alert('$errorMessage'); window.location.href = 'patientView.php';</script>";
    } else {
        echo "<script>alert('$successMessage'); window.location.href = 'patientView.php';</script>";
    }
} else {
    echo 'Invalid request method.';
}
?>
