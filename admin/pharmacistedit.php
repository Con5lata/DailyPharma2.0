<?php 

session_start();
require_once("../connect.php");

$name = "";
$drug_name = "";
$drug_price = "";
$address = "";
$phone = "";

$errorMessage = "";
$successMessage = "";

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    // GET method: Show the data of the client 
    if (!isset($_GET['id'])) {
        header("Location: adminView.php");
        exit;
    } else {
        $id = $_GET['id']; 
    }

    // Read the row of the selected client from the database table 
    $sql = $conn->prepare("SELECT * FROM pharmacist WHERE Pharmacist_ID = ?");
    $sql->bind_param("i", $id);
    $sql->execute();
    $row = $sql->get_result()->fetch_assoc();

    if (!$row) {
        header("Location: adminView.php");
        exit;
    }

    $name = $row["Pharmacist_Name"];
    $status = $row["Status"];
} else {
    // POST method: Update the data of the client 
    $id = $_POST["ID"];
    $name = $_POST["name"];
    $status = $_POST["status"];

    do {
        if (empty($name) || empty($status)) {
            $errorMessage = "All the fields are required";
            break;
        }

        // Update user in the database 
        $sql = "UPDATE pharmacist SET Status = ? WHERE Pharmacist_ID = ?";
        $stmt = $conn->prepare($sql);
        if ($stmt === false) {
            $errorMessage = "Prepare failed: " . $conn->error;
            break;
        }
        $stmt->bind_param("si", $status, $id);

        if (!$stmt->execute()) {
            $errorMessage = "Execute failed: " . $stmt->error;
            break;
        }

        $successMessage = "User updated correctly";

        header("Location: pharmacistedit.php");
        exit;

    } while (false);
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHARMACY</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container my-5">
        <h2>Edit Pharmacist</h2>

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
        <form method="post" action="pharmacistedit.php">
            <input type="hidden" name="ID" value="<?php echo htmlspecialchars($id); ?>">
            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Name</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="name" value="<?php echo htmlspecialchars($name); ?>" readonly>
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Status</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="status" value="<?php echo htmlspecialchars($status); ?>">
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
