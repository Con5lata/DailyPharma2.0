<?php
// Start a PHP session
session_start();

// Include database connection
require_once("../connect.php");

// Initialize variables
$successMessage = '';
$errorMessage = '';

// Define the upload directory
$uploadDir = 'uploads/';

// Create the destination directory if it does not exist
if (!is_dir($uploadDir)) {
    if (!mkdir($uploadDir, 0755, true)) {
        die("Failed to create directory: $uploadDir. Please check permissions.");
    }
}

// Check if form data is received via POST
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Retrieve and sanitize input data
    $patientName = isset($_POST['Patient_Name']) ? trim($_POST['Patient_Name']) : '';
    $patientSSN = isset($_POST['Patient_SSN']) ? trim($_POST['Patient_SSN']) : '';

    // Handle file upload
    if (isset($_FILES['Prescription_File']) && $_FILES['Prescription_File']['error'] === UPLOAD_ERR_OK) {
        $fileTmpPath = $_FILES['Prescription_File']['tmp_name'];
        $fileName = $_FILES['Prescription_File']['name'];
        $fileSize = $_FILES['Prescription_File']['size'];
        $fileType = $_FILES['Prescription_File']['type'];
        $fileNameCmps = explode(".", $fileName);
        $fileExtension = strtolower(end($fileNameCmps));

        // Define allowed file extensions and size limit
        $allowedExtensions = ['pdf', 'jpg', 'jpeg', 'png'];
        $maxFileSize = 20 * 1024 * 1024; // 20 MB

        if (in_array($fileExtension, $allowedExtensions) && $fileSize <= $maxFileSize) {
            // Create a unique file name and set the upload path
            $newFileName = md5(time() . $fileName) . '.' . $fileExtension;
            $uploadPath = $uploadDir . $newFileName;

            // Move the file to the upload directory
            if (move_uploaded_file($fileTmpPath, $uploadPath)) {
                // Prepare SQL query to insert the data
                $sql = "INSERT INTO prescription_documents (patient_name, patient_ssn, file_path) VALUES (?, ?, ?)";

                if ($stmt = $conn->prepare($sql)) {
                    // Bind parameters and execute the query
                    $stmt->bind_param('sss', $patientName, $patientSSN, $newFileName);

                    if ($stmt->execute()) {
                        $successMessage = 'Your prescription has been uploaded successfully we will contact you through the email you have provided';
                    } else {
                        $errorMessage = 'There was a problem uploading your prescription. Please try again.';
                    }

                    // Close the statement
                    $stmt->close();
                } else {
                    $errorMessage = 'Failed to prepare the SQL statement.';
                }
            } else {
                $errorMessage = 'Error moving the uploaded file. Please try again.';
            }
        } else {
            $errorMessage = 'Invalid file type or size exceeds limit.';
        }
    } else {
        $errorMessage = 'No file uploaded or file upload error.';
    }

    // Close the database connection
    $conn->close();

    // Redirect with a message
    if ($errorMessage) {
        echo "<script>alert('$errorMessage'); window.location.href = 'patientView.php';</script>";
    } else {
        echo "<script>alert('$successMessage'); window.location.href = 'patientView.php';</script>";
    }
} else {
    echo 'Invalid request method.';
}
?>
