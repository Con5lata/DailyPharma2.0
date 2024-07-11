<?php 

session_start();
require_once("../connect.php");


$id = $_GET['SSN']; // Get the user ID from the query parameter

$name="";
$phone="";
$specialty="";
$experience="";

$errorMessage = "";
$successMessage="";

if( $_SERVER['REQUEST_METHOD'] == 'GET'){
    //GET method: Show the data of the client 

    if (!isset( $_GET['SSN']) ){
        header("location: adminView.php");
        exit;
    }

    //read the row of the selected client from the database table 
    $sql = $conn->prepare("SELECT * FROM doctors WHERE Doctor_SSN = ? ");
    $sql->bind_param("i", $id);
    $sql->execute();
    $row = $sql->get_result()->fetch_assoc();

    if (!$row) {
        header("location: doctorsedit.php");
        exit;
    }

    $name = $row["Doctor_Name"];
    $status = $row["Status"];
}


else{
    //POST method: Update the data of the doctor

    $SSN = $_POST["SSN"];
    $status = $_POST["status"];

    do{
        if ( empty($id) || empty($status)){
            $errorMessage ="All the fieds are required";
            break;
        }
        //add new user to database 
        $sql = "UPDATE  doctors 
        SET Status = '$status'
        WHERE Doctor_SSN = '$id' ";

        $result = $conn->query($sql);

        if (!$result) {
            $errorMessage = "Invalid Query: " . $conn->error;
            break;
        }

        $successMessage = "User updated Correctly";

        header("location: doctoredit.php");

        exit;

    }while (false);
}
?>


<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-COMPLATIBLE" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial scale=1.0">
    <title>Doctors</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
    <div class= "container my-5">
        <h2>Edit Doctor</h2>

        <?php
        if( !empty($errorMessage)){
            echo "
            <div class='alert alert-warning alert-dismisible fade show' role='alert'>
                 <strong>$errorMessage <?strong>
                 <button type='button' class='btn-close' data-bs-dismiss='alert' aria -label='Close'></label>
                 </div>
                 ";
        }
        ?>
        <form method ="post">
            <input type="hidden" name="SSN" value="<?php echo $id; ?>">
            <?php echo $id; ?>
            <div class="row mb-3">
                <label class="col-sm-3 col-form label">Name</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="SSN" value="<?php echo $name?>">
                </div>
            </div>

            <div class="row mb-3">
                <label class="col-sm-3 col-form label">Status</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="status" value="<?php echo $status?>">
                </div>
            </div>


            <?php
            if (!empty($successMessage) ){
                echo "
                <div class='row mb-3'>
                    <div class='offset-sm-3 col-sm-6'>
                        <div class='alert alert-success alert-dismisible fade show' role='alert'>
                            <strong>$successMessage <?strong>
                            <button type='button' class='btn-close' data-bs-dismiss='alert' aria -label='Close'></label>
                            </div>
                    </div>
                 </div>
                 ";
            }
            ?>
            <div class= "row mb-3">
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