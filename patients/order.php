<?php
include "../inc/session_header.php";

$patientAddress = $_SESSION["userdata"]["Patient_Address"];
$selectedDrug = $_SESSION['selected_drug'];



$result = $conn->query(
    "INSERT INTO `orders` (Drug_ID, Patient_SSN) VALUES ('$selectedDrug','$ID')"
);

if ($result === true) {
    echo "<script>alert('$username - Order for $selectedDrug has been placed. Address - $patientAddress');</script>";
    echo "<script>window.location.href = '../patients/patientView.php';</script>";

} else {
    echo "<script>alert('Error in order plaement. Try Again')
    window.location.href = 'patientView.php';
    </script>";
}

?>