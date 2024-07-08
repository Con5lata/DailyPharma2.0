<?php

require_once("../connect.php");

// Establish a PHP session
session_start();

require_once "../connect.php";

// Check if the user is logged in
if (!isset($_SESSION["userid"]) || !isset($_SESSION["user"])) {
    // Redirect to the login page if the user is not logged in
    header("Location: doctorlogin.html");
    exit;
}

// Get the user information from the session variables
$user = $_SESSION["user"];
$ID = $_SESSION["userid"];
$username = $_SESSION["username"];

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve and sanitize form data
    $doctor_ssn = isset($_POST['Doctor_SSN']) ? trim($_POST['Doctor_SSN']) : '';
    $patient_ssn = isset($_POST['Patient_SSN']) ? trim($_POST['Patient_SSN']) : '';
    $patient_name = isset($_POST['Patient_Name']) ? trim($_POST['Patient_Name']) : '';
    $patient_email = isset($_POST['Patient_Email']) ? trim($_POST['Patient_Email']) : '';
    $patient_phone = isset($_POST['Patient_Phone']) ? trim($_POST['Patient_Phone']) : '';
    $patient_age = isset($_POST['Patient_Age']) ? trim($_POST['Patient_Age']) : '';

    // Validate form data (ensure all fields are filled)
    if ($patient_ssn && $patient_name && $patient_email && $patient_phone && $patient_age) {
        // Prepare the SQL statement
        $sql = "INSERT INTO patients (Patient_SSN, Patient_Name, Patient_Email, Patient_Phone, Patient_Age) 
                VALUES ('$patient_ssn', '$patient_name', '$patient_email', '$patient_phone', '$patient_age')";

        // Execute the SQL statement for patients table
        if ($conn->query($sql) === TRUE) {
            // Prepare the SQL statement for inserting into doctor_patient table
            $sql_doctor_patient = "INSERT INTO doctor_patient (Doctor_SSN, Patient_SSN) 
                                   VALUES ('$doctor_ssn', '$patient_ssn')";

            // Execute the SQL statement for doctor_patient table
            if ($conn->query($sql_doctor_patient) === TRUE) {
                echo "<script>
                        alert('Patient Successfully Added');
                        window.location.href = 'doctorView.php'; // Redirect to manage patients page
                      </script>";
            } else {
                echo "Error: " . $sql_doctor_patient . "<br>" . $conn->error;
            }
        } else {
            echo "Error: " . $sql_patient . "<br>" . $conn->error;
        }
    } else {
        echo "All fields are required.";
    }


    // Close the database connection
    $conn->close();
} else {
    echo "Invalid request method.";
}

?>
