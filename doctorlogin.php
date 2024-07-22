<?php
require("connection.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $doc_hos_id = $_POST["doc_hos_id"];
    $doc_password = $_POST["doc_password"];

    $stmt = $conn->prepare("SELECT doc_name FROM tbldoctor WHERE doc_hos_id = ? AND doc_password = ?");
    $stmt->bind_param("is", $doc_hos_id, $doc_password);

    if ($stmt->execute()) {
        // Bind the result
        $stmt->bind_result($name);

        // Check if a matching record is found
        if ($stmt->fetch()) {
            // Successful login, grant access
            echo "Welcome Doctor " . $name;
        } else {
            // Invalid credentials, deny access
            echo "Invalid credentials. Please try again.";
        }
    } else {
        // Error occurred during query execution
        echo "An error occurred. Please try again later.";
    }

    // Close the statement
    $stmt->close();
}

// Close the connection
$conn->close();
?>