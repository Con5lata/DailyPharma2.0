<?php
require_once("../connect.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $ssn = $_POST['Patient_SSN'];
    $name = $_POST['Patient_Name'];
    $email = $_POST['Patient_Email'];
    $phone = $_POST['Patient_Phone'];
    $DOB = $_POST['Patient_DOB'];
    $status = $_POST['Status'];

    // Validate the input data if needed

    $sql = "INSERT INTO patients (Patient_SSN, Patient_Name, Patient_Email, Patient_Phone, Patient_Age, Status) VALUES ('$ssn', '$name', '$email', '$phone', '$DOB', '$status')";

    if ($conn->query($sql) === TRUE) {
        echo "New patient created successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
    header("Location: adminView.php");
    exit();
}
?>
