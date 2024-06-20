<?php

require_once("../connect.php");

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve and sanitize form data
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

        // Execute the SQL statement
        if ($conn->query($sql) === TRUE) {
            echo "<script>
                    alert('Patient Successfully Added');
                    window.location.href = 'doctorView.html'; // Redirect to manage patients page
                    </script>";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
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
