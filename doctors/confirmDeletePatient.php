 <?php 
session_start();

if (isset($_GET["id"])) {

    $patientID = $_GET["id"];

    require_once("connect.php");
    $sql = "SELECT * FROM patients WHERE Patient_SSN = '$patientID' AND status = 'active'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Prompt the user for confirmation before deleting the patient
        echo "<script>
            if (confirm('Are you sure you want to delete this patient?')) {
                let doctorID = " . $_SESSION["user"]["Doctor_SSN"] . ";
                window.location.href = 'delete_patient.php?id=' + doctorID + '&patientID=' + " . $patientID . ";
            } else {
                // If the user cancels, redirect back to the doctor's view page without performing the deletion
                window.location.href = 'doctorView.php';
            }
        </script>";
    } 
    else{
        echo "<script>
            alert('Patient does not exist any more or there is an issue with their deletion. Please contact administrator.')
            window.location.href = 'doctorView.php';
            exit;
            </script>";
    }
}
?>
