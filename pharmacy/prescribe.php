<?php
require_once("../connect.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $patient_ssn = $_POST['Patient_SSN'];
    $doctor_ssn = $_POST['Doctor_SSN'];
    $medication = $_POST['Medication'];
    $dosage = $_POST['Dosage'];
    $prescribed_date = $_POST['Prescribed_Date'];
    $notes = $_POST['Notes'];
    $status = $_POST['Prescribed'];  // Assuming 'Prescribed' is the status of the prescription (Y/N)

    // Validate the input data if needed

    $sql = "INSERT INTO prescriptions (Patient_SSN, Doctor_SSN, Medication, Dosage, Prescribed_Date, Notes, Prescribed) VALUES (?, ?, ?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssssss", $patient_ssn, $doctor_ssn, $medication, $dosage, $prescribed_date, $notes, $status);

    if ($stmt->execute() === TRUE) {
        echo "New prescription created successfully";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
    header("Location: doctorView.php");
    exit();
}
?>