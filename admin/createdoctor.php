<?php
require_once("../connect.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $ssn = $_POST['Doctor_SSN'];
    $name = $_POST['Doctor_Name'];
    $phone = $_POST['Doctor_Phone'];
    $speciality = $_POST['Doctor_Speciality'];
    $experience = $_POST['Doctor_Experience'];
    $status = $_POST['Status'];

    // Validate the input data if needed

    $sql = "INSERT INTO doctors (Doctor_SSN, Doctor_Name, Doctor_Phone, Doctor_Speciality, Doctor_Experience, Status) VALUES ('$ssn', '$name', '$phone', '$speciality', '$experience', '$status')";

    if ($conn->query($sql) === TRUE) {
        echo "New Account octor created successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
    header("Location: adminView.php");
    exit();
}
?>
