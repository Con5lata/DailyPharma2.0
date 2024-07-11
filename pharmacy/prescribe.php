<?php
require_once("../connect.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $patient_ssn = $_POST['Patient_SSN'];
    $prescribed_by = $_POST['Prescribed_By'];
    $drug_name = $_POST['Drug_Name'];
    $amt = $_POST['Prescription_Amt'];
    $prescription_inst = $_POST['Prescription_Instructions'];

    // Validate the input data if needed

    // Prepare the SQL statement for inserting into the prescriptions table
    $sql = "INSERT INTO prescriptions (Patient_SSN, Prescribed_By, Drug_Name, Prescription_Amt, Prescription_Instructions) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    
    if ($stmt === false) {
        die("Prepare failed: " . $conn->error);
    }

    // Bind the parameters
    $stmt->bind_param("sssss", $patient_ssn, $prescribed_by, $drug_name, $amt, $prescription_inst);

    // Execute the statement
    if ($stmt->execute()) {
        echo "New prescription created successfully";
    } else {
        echo "Error: " . $stmt->error;
    }

    // Close the statement and connection
    $stmt->close();
    $conn->close();
    
    // Redirect after a delay to ensure the message is visible
    header("Refresh: 2; URL=pharmacyView.php");
    exit();
}
?>
