<?php
require("connection.php");
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $patient_nat_id = $_POST["patient_nat_id"];
    $patient_password = $_POST["patient_password"];

    $stmt = $conn->prepare("SELECT patient_name FROM tblpatient WHERE patient_nat_ID = ? AND patient_password = ?");
    $stmt->bind_param("is", $patient_nat_id, $patient_password);

    $stmt->execute();

    // Bind the result
    $stmt->bind_result($name);

    // Check if a matching record is found
    if ($stmt->fetch()) {
        // Successful login, grant access
        echo "Welcome " . $name;
    } else {
        // Invalid credentials, deny access
        echo "Invalid credentials. Please try again.";
    }

    // Close the statement
    $stmt->close();
}

$conn->close();
?>