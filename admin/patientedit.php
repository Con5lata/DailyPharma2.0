<?php
session_start();
require_once("../connect.php");

$SSN = "";
$Name = "";
$Email = "";
$Phone = "";
$Address = "";
$DOB = "";
$Status = "";

$errorMessage = "";
$successMessage = "";

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    // Get method shows the data of the client

    if (!isset($_GET["SSN"])) {
        header("location: adminView.php");
        exit;
    }

    $SSN = $_GET["SSN"];

    // read the row of the selected patient from the database 
    $sql = "SELECT * FROM patients WHERE Patient_SSN = '$SSN'";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();

    if (!$row) {
        header("location: /adminView.php");
        exit();
    }

    $SSN = $row["Patient_SSN"];
    $Name = $row["Patient_Name"];
    // $Email = $row["Patient_Email"];
    // $Phone = $row["Patient_Phone"];
    // $Address = $row["Patient_Address"];
    // $DOB = $row["Patient_Age"];
    $Status = $row["Status"];
} else {
    // POST method: Update the data of the patient
    $SSN = $_POST["SSN"];
    $Name = $_POST["Name"];
    // $Email = $_POST["Email"];
    // $Phone = $_POST["Phone"];
    // $Address = $_POST["Address"];
    // $DOB = $_POST["DOB"];
    $Status = $_POST["Status"];

    do {
        if (empty($SSN) || /*empty($Name) || empty($Email) || empty($Phone) || empty($Address) || empty($DOB) ||*/ empty($Status)) {
            $errorMessage = "All fields are required";
            break;
        }

        $sql = "UPDATE patients SET 
            Status = '$Status'
        WHERE Patient_SSN = '$SSN'";

        $result = $conn->query($sql);

        if (!$result) {
            $errorMessage = "Invalid query: " . $conn->error;
            break;
        }

        $successMessage = "Patient updated correctly";

        header("location: patientedit.php");
        exit;
    } while (false);
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-COMPLATIBLE" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial scale=1.0">
    <title>PATIENTS</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
    <div class="container my-5">
        <h2>Edit Patient</h2>

        <?php
        if (!empty($errorMessage)) {
            echo "
            <div class='alert alert-warning alert-dismissible fade show' role='alert'>
                <strong>$errorMessage</strong>
                <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
            </div>
            ";
        }
        ?>
        <form method="post" action="patientedit.php">
            <input type="hidden" name="SSN" value="<?php echo $SSN; ?>">
            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Name</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="Name" value="<?php echo $Name; ?>" readonly>
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Status</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="Status" value="<?php echo $Status; ?>">
                </div>
            </div>

            <?php
            if (!empty($successMessage)) {
                echo "
                <div class='row mb-3'>
                    <div class='offset-sm-3 col-sm-6'>
                        <div class='alert alert-success alert-dismissible fade show' role='alert'>
                            <strong>$successMessage</strong>
                            <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                        </div>
                    </div>
                </div>
                ";
            }
            ?>
            <div class="row mb-3">
                <div class="offset-sm-3 col-sm-3 d-grid">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
                <div class="col-sm-3 d-grid">
                    <a class="btn btn-outline-primary" href="adminView.php" role="button">Cancel</a>
                </div>
            </div>
        </form>
    </div>
</body>
</html>
