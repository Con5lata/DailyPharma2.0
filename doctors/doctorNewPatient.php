<?php
session_start();


if (isset($_GET["id"])) {
    $doctorID = $_SESSION["user"]["Doctor_SSN"];
    $patientID = $_GET["id"];

    require_once("connect.php");

    $result = $conn->query("
    SELECT * FROM doctor_patient WHERE Doctor_SSN = '$doctorID' AND Patient_SSN = '$patientID'
    ");

    if ($result->num_rows === 0) {
        $insertQuery = "INSERT INTO doctor_patient (Doctor_SSN, Patient_SSN) VALUES ('$doctorID', '$patientID')";

        if ($conn->query($insertQuery) === TRUE) {
            echo "<script>alert('Successful addition of new patient')
            window.location.href = 'doctorView.php';
            </script>";

        } else {
            echo "<script>alert('Error in addition of new patient. Try Again')
            window.location.href = 'doctorView.php';
            </script>";
        }
    } else {
        echo "<script>alert('Patient is already enrolled with you. Try Again')
        window.location.href = 'doctorView.php';
        </script>";
    }
} else {
    echo "<script>alert('No Patient selected')</script>";
    header("Location: doctorView.php");
    exit;
}
?>
