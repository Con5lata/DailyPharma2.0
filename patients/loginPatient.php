<?php

//establish a php session
session_start();

//establish a connection
require_once("../connect.php");

//creating a variable to hold errors that may occur uppon login
$error = '';


//first if to prevent injection of data into the search bar, security
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $patientSSN = trim($_POST['Patient_SSN']);
    $password = trim($_POST['Password']);

    //if no error has occured, retrieve user form the databse
    if (empty($error)) {

        //retrieve user details from the database
        if ($query = $conn->prepare("SELECT * FROM patients WHERE `Patient_SSN`=? AND `Status` = 'active'")) {
            $query->bind_param('s', $patientSSN);
            $query->execute();
            $row = $query->get_result()->fetch_assoc();

            if ($row) {

                //tests if the entered password matches that in the database
                if (hash_equals($password, $row['Password'])) {
                    $_SESSION["user"] = "Patient";
                    $_SESSION["userid"] = $row['Patient_SSN'];
                    $_SESSION["username"] = $row['Patient_Name'];
                    $_SESSION["userdata"] = $row;
            
                    //close them to prevent further action upon them
                    $query->close();
                    $conn->close();
            
                    // Redirect to the welcome page if all conditions have been satisfied
                    header("Location: ../patients/patientView.php");
                    exit;
                } else {
                    $error .= 'The password is not valid.';
                }
            } else {
                $error .= 'No user exists with that Patient SSN or Account has been deactivated. Please try again or contact us via DailyPharma.gmail.com';
            }
        }
    }
}

// Check if there is an error, and if so, display an alert
if (!empty($error)) {
    echo "<script>alert('$error');</script>";
    echo "<script>window.location.href = '../login.html';</script>";
    exit;
}


/*
if (!empty($error)) {
    // Adding encryption to the error message so that it does not show up on the search bar when appended
    $key = 'my_key';
    $encryptedError = encryptError($error, $key);

    // Redirect to the index page with encrypted error message
    header("Location: login.html?error=" . urlencode($encryptedError));
    exit;
}

// Encryption function
function encryptError($error, $key) {
    $encryptedError = '';
    $keyLength = strlen($key);
    $errorLength = strlen($error);

    for ($i = 0; $i < $errorLength; $i++) {
        $encryptedError .= $error[$i] ^ $key[$i % $keyLength];
    }

    return base64_encode($encryptedError);
}*/

?>