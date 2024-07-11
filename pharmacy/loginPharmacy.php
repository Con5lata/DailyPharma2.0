<?php

// Start a PHP session
session_start();

// Establish a connection
require_once("../connect.php");

// Variable to hold errors
$error = '';

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $pharmacistID = trim($_POST['Pharmacist_ID']);
    $password = trim($_POST['Password']);

    // If no error has occurred, retrieve user from the database
    if (empty($error)) {
        
        if ($query = $conn->prepare("SELECT * FROM pharmacists WHERE `Pharmacist_ID` = ? AND `Status` = 'active'")) {
            $query->bind_param('s', $pharmacistID);
            $query->execute();
            $result = $query->get_result();

            if ($row = $result->fetch_assoc()) {
                // Verify the password
                if (password_verify($password, $row['Password'])) {
                    $_SESSION["user"] = "Pharmacist";
                    $_SESSION["userid"] = $row['Pharmacist_ID'];
                    $_SESSION["username"] = $row['Pharmacist_Name'];
                    
                    // Close query and connection
                    $query->close();
                    $conn->close();
                    
                    // Redirect to the welcome page
                    header("Location: pharmaciyView.php");
                    exit;
                } else {
                    $error .= 'The password is not valid.';
                }
                
                
            } else {
                $error .= 'No user exists with that ID or the account has been deactivated. Please try again or contact us via DailyPharma@gmail.com';
            }
        } else {
            $error .= 'Failed to prepare the SQL statement.';
        }
    }
}

// Check if there is an error and display an alert
if (!empty($error)) {
    echo "<script>alert('$error');</script>";
    echo "<script>window.location.href = 'loginpharmacy.html';</script>";
    exit;
}
?>
