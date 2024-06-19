<?php
if (isset($_GET["id"]) && isset($_GET["patientID"])) {
    $doctorID = $_GET["id"];
    $patientID = $_GET["patientID"];

    require_once("connect.php");
    $sql = "SELECT * FROM doctor_patient WHERE Doctor_SSN = '$doctorID' AND Patient_SSN = '$patientID'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $deleteQuery = "DELETE FROM doctor_patient WHERE Doctor_SSN = '$doctorID' AND Patient_SSN = '$patientID'";

        if ($conn->query($deleteQuery) === TRUE) {
            echo "<script>alert('Successful deletion of patient')
            window.location.href = 'doctorView.php';
            </script>";
        } else {
            echo "<script>alert('Error in deletion of new patient. Try Again')
            window.location.href = 'doctorView.php';
            </script>";
        }
    } else {
        echo "<script>
            alert('Error occured during deletion. Please contact administrator.')
            window.location.href = 'doctorView.php';
            exit;
            </script>";
    }
} else {
    header("Location: doctorView.php");
    exit;
}
?>
