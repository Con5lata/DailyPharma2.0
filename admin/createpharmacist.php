<?php
require_once("../connect.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['Pharmacist_ID'];
    $name = $_POST['Pharmacist_Name'];
    $email = $_POST['Pharmacist_Email'];
    $phone = $_POST['Pharmacist_Phone'];
    $status = $_POST['Status'];

    // Validate the input data if needed

    $sql = "INSERT INTO pharmacists (Pharmacist_ID, Pharmacist_Name, Pharmacist_Email, Pharmacist_Phone, Status) VALUES ('$id', '$name', '$email', '$phone', '$status')";

    if ($conn->query($sql) === TRUE) {
        echo "New pharmacist created successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
    header("Location: adminView.php");
    exit();
}
?>
