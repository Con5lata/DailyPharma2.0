<?php

require_once("../connect.php");

// Retrieve form data
$patient_ssn = $_POST['Patient_SSN'];
$doctor_ssn = $_POST['Doctor_SSN'];
$drug_ID = $_POST['Drug_ID'];
$prescription_amt = $_POST['Prescription_Amt'];
$prescription_inst = $_POST['Prescription_Instructions'];

// Prepare the SQL statement
$sql = "INSERT INTO prescriptions (Patient_SSN, Doctor_SSN, Drug_ID, Prescription_Amt, Prescription_Instructions) VALUES ('$patient_ssn', '$doctor_ssn', '$drug_ID', '$prescription_amt', '$prescription_inst')";

if ($conn->query($sql) === TRUE) {
    $conn->close();
    
    echo "<script>
    alert('Prescription succesfully made. Pharmacy will deal with dispensing.')
    window.location.href = 'doctorView.html';
    exit;
    </script>";

} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

// Close the database connection
$conn->close();

?>
