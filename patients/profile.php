<?php 
include "../inc/session_header.php";

//read the row of the selected client from the database table 
$sql = $conn->prepare("SELECT * FROM patients WHERE `Patient_SSN` = ?");
$sql->bind_param("i", $ID);
$sql->execute();
$row = $sql->get_result()->fetch_assoc();

if (!$row) {
    header("location: patientView.php");
    exit;
}


$ID = $row["Patient_SSN"];
$name = $row["Patient_Name"];
$email = $row["Patient_Email"];
$phone = $row["Patient_Phone"];
$gender = $row["Patient_Gender"];
$dob = $row["Patient_DOB"];
$age = $row["Patient_Age"];

?>


<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-COMPLATIBLE" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial scale=1.0">
    <title>USERS</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../style.css">
</head>
<body>

<header>
        <div class="logo">
            <a href="../index.html">DailyPharma</a>
        </div>

        <div class="navbar">
            <nav class= navbar id="navbar">
                <a href="../index.html">Home</a>
                <a href="#about">Features</a>
                <a href="#footer">Contact Us</a>
                <a href="../logout.php" class="btn-login-popup" >Logout</a>                
            </nav>
        </div>

        <i class="uil uil-bars navbar-toggle" onclick="toggleOverlay()"></i>

        <div id="menu" onclick="toggleOverlay()">
            <div id="menu-content">
                <a href="../index.html">Home</a>
                <a href="#about">Features</a>
                <a href="#footer">Contact Us</a>
                <a href="../logout.php">Logout</a>
            </div>
        </div>
    </header>

    <div class= "container my-5">
        <h2>User Information</h2>
        <div class="item"></div>
        <form method ="post">
        <div class="row mb-3">
                <label class="col-sm-3 col-form label">SSN</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="Patient_SSN" value="<?php echo $ID?>" readonly>
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-sm-3 col-form label">Name</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="Patient_Name" value="<?php echo $name?>" readonly>
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-sm-3 col-form label">Phone</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="Patient_Phone" value="<?php echo $phone?>" readonly>
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-sm-3 col-form label">Email</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="Patient_Email" value="<?php echo $email?>" readonly>
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-sm-3 col-form label">Gender</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="Patient_Gender" value="<?php echo $gender?>" readonly >
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-sm-3 col-form label">DOB</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="Patient_DOB" value="<?php echo $dob?>"readonly>
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-sm-3 col-form label">Age</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="Patient_Age" value="<?php echo $age?>"readonly>
                </div>
            </div>

        </form>
    </div>
</body>