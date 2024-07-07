<?php

require_once("../connect.php");

// Retrieve form data
$patient_ssn = $_POST['Patient_SSN'];
$doctor_ssn = $_POST['Doctor_SSN'];
$drug_name = $_POST['Drug_Name'];
$prescription_amt = $_POST['Prescription_Amt'];
$prescription_inst = $_POST['Prescription_Instructions'];

// Prepare the SQL statement
$sql = "INSERT INTO prescriptions (Patient_SSN, Doctor_SSN, Drug_Name, Prescription_Amt, Prescription_Instructions) VALUES ('$patient_ssn', '$doctor_ssn', '$drug_name', '$prescription_amt', '$prescription_inst')";

if ($conn->query($sql) === TRUE) {
    $conn->close();
    
    echo "<script>
    alert('Prescription succesfully made. Pharmacy will deal with dispensing.')
    window.location.href = 'doctorView.php';
    exit;
    </script>";

} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

// Close the database connection
$conn->close();

?>
