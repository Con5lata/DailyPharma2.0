<?php
session_start();
require_once "../connect.php";

// Check if the user is logged in
if (!isset($_SESSION["userid"]) || !isset($_SESSION["username"])) {
    header("Location: loginpharmacy.html");
    exit;
}

// Get the user information from the session variables
$ID = $_SESSION["userid"];

$query = $conn->prepare("SELECT * FROM pharmacists WHERE Pharmacist_ID = ?");
$query->bind_param("s", $ID);
$query->execute();
$row = $query->get_result()->fetch_assoc();

if (!$row) {
    echo "User not found.";
    exit;
}

// Extract data from the fetched row
$ID = $row["Pharmacist_ID"];
$name = $row["Pharmacist_Name"];
$phone = $row["Pharmacist_Phone"];
$email = $row["Pharmacist_Email"];
$password = $row["Password"];


?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-COMPATIBLE" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pharmacist Profile</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../style.css">
    <style>
    body {
        background: url('images/bg3.jpg') no-repeat center center fixed;
        background-size: cover;
    }
    h2 {
        padding-top: 100px;
        padding-bottom: 50px;
        font-weight: 700;
        padding-left: 20%;
    }
    .bold-text {
        font-weight: 700;
    }
    </style>
</head>
<body>

<header>
    <div class="logo">
        <a href="../index.html">DailyPharma</a>
    </div>

    <div class="navbar">
        <nav class="navbar" id="navbar">
            <a href="pharmacyView.php">Home</a>
            <a href="#about">Features</a>
            <a href="#footer">Contact Us</a>
            <a href="loginpharmacy.html" class="btn-login-popup">Logout</a>                
        </nav>
    </div>

    <i class="uil uil-bars navbar-toggle" onclick="toggleOverlay()"></i>

    <div id="menu" onclick="toggleOverlay()">
        <div id="menu-content">
            <a href="pharmacyView.php">Home</a>
            <a href="#about">Features</a>
            <a href="#footer">Contact Us</a>
            <a href="loginPharmacy.html" class="btn-login-popup">Logout</a>
        </div>
    </div>
</header>

<div class="container my-5">
    <h2>Personal Profile</h2>
    <form method="post">
        <div class="row mb-3">
            <label class="col-sm-3 col-form-label">Pharmacist ID</label>
            <div class="col-sm-6">
                <input type="text" class="form-control" name="Pharmacist_ID" value="<?php echo htmlspecialchars($ID); ?>" readonly>
            </div>
        </div>
        <div class="row mb-3">
            <label class="col-sm-3 col-form-label">Name</label>
            <div class="col-sm-6">
                <input type="text" class="form-control" name="Pharmacist_Name" value="<?php echo htmlspecialchars($name); ?>" readonly>
            </div>
        </div>
        <div class="row mb-3">
            <label class="col-sm-3 col-form-label">Email</label>
            <div class="col-sm-6">
                <input type="email" class="form-control" name="Pharmacist_Email" value="<?php echo htmlspecialchars($email); ?>" readonly>
            </div>
        </div>
        <div class="row mb-3">
            <label class="col-sm-3 col-form-label">Phone</label>
            <div class="col-sm-6">
                <input type="text" class="form-control" name="Pharmacist_Phone" value="<?php echo htmlspecialchars($phone); ?>" readonly>
            </div>
        </div>
        <div class="row mb-3">
            <label class="col-sm-3 col-form-label">Password</label>
            <div class="col-sm-6">
                <input type="text" class="form-control" name="Password" value="<?php echo htmlspecialchars($password); ?>" readonly>
            </div>
        </div>
        

        <div class="bold-text">
            <br>
            If you would like to edit your details, please contact the Administrator via <a href="mailto:DailyPharma@gmail.com">DailyPharma@gmail.com</a>
        </div>
    </form>
</div>

<script src="../script.js"></script>
</body>
</html>
