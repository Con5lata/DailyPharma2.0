<?php

//establish a php session
session_start();

//establish a connection
require_once("../connect.php");

//creating a variable to hold errors that may occur uppon login
$error = '';


//first if to prevent injection of data into the search bar, security
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $doctorSSN = trim($_POST['Doctor_SSN']);
    $password = trim($_POST['Password']);

    //if no error has occured, retrieve user form the databse
    if (empty($error)) {

        //retrieve user details from the database
        if ($query = $conn->prepare("SELECT * FROM doctors WHERE `Doctor_SSN`= ? AND `Status` = 'active'")) {
            $query->bind_param('i', $doctorSSN);
            $query->execute();
            $row = $query->get_result()->fetch_assoc();

            if ($row) {

                //tests if the entered password matches that in the database
                if (hash_equals($password, $row['Password'])) {
                    $_SESSION["user"] = "Doctor";
                    $_SESSION["userid"] = $row['Doctor_SSN'];
                    $_SESSION["username"] = $row['Doctor_Name'];
                    $_SESSION["userdata"] = $row;
            
                    //close them to prevent further action upon them
                    $query->close();
                    $conn->close();
            
                    // Redirect to the welcome page if all conditions have been satisfied
                    header("Location: ../doctors/doctorView.php");
                    exit;
                } else {
                    $error .= 'The password is not valid.';
                }
            } else {
                $error .= 'No user exists with that Doctor SSN or Account has been deactivated. Please try again or contact us via DailyPharma.gmail.com';
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

?>