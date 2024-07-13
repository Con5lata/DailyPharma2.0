<?php
require_once("../connect.php");

if (isset($_GET["ID"])){
    $ID = $_GET["ID"];

    $result = $conn->query(
        "UPDATE prescriptions SET Prescribed = 'Y' WHERE Prescription_ID = '$ID'"
    );

    if ($result === TRUE) {
        echo "<script>
            alert('Drug Dispensed.')
            window.location.href = 'pharmacyView.php';
            exit;
            </script>";
    } else {
        // Handle the case when the update fails (you can add appropriate error handling)
        echo "Error dispensing.";
    }
}
?>
