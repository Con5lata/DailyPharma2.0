<?php 

session_start();
require_once("connect.php");

// Check if the necessary session variables are set
if (!isset($_SESSION["Doctor_SSN"])) {
    header("location: doctorView.php");
    exit;
}

// Retrieve the doctor's ID from the session
$ID = $_SESSION["Doctor_SSN"];

// Prepare and execute SQL query to fetch doctor data
$sql = $conn->prepare("SELECT * FROM doctors WHERE `Doctor_SSN` = ?");
$sql->bind_param("s", $ID); // Use "i" if Doctor_SSN is an integer, otherwise use "s" for string
$sql->execute();
$row = $sql->get_result()->fetch_assoc();

if (!$row) {
    header("location: doctorView.php");
    exit;
}

// Extract data from the fetched row
$ID = $row["Doctor_SSN"];
$name = $row["Doctor_Name"];
$phone = $row["Doctor_Phone"];
$speciality = $row["Doctor_Speciality"];
$exp = $row["Doctor_Experience"];

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-COMPATIBLE" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Information</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../style.css">
</head>
<body>

<header>
    <div class="logo">
        <a href="../index.html">DailyPharma</a>
    </div>

    <div class="navbar">
        <nav class="navbar" id="navbar">
            <a href="../index.html">Home</a>
            <a href="#about">Features</a>
            <a href="#footer">Contact Us</a>
            <a href="../logout.php" class="btn-login-popup">Logout</a>                
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

<div class="container my-5">
    <h2>User Information</h2>
    <form method="post">
        <div class="row mb-3">
            <label class="col-sm-3 col-form-label">SSN</label>
            <div class="col-sm-6">
                <input type="text" class="form-control" name="Doctor_SSN" value="<?php echo htmlspecialchars($ID); ?>" readonly>
            </div>
        </div>
        <div class="row mb-3">
            <label class="col-sm-3 col-form-label">Name</label>
            <div class="col-sm-6">
                <input type="text" class="form-control" name="Doctor_Name" value="<?php echo htmlspecialchars($name); ?>" readonly>
            </div>
        </div>
        <div class="row mb-3">
            <label class="col-sm-3 col-form-label">Speciality</label>
            <div class="col-sm-6">
                <input type="text" class="form-control" name="Doctor_Speciality" value="<?php echo htmlspecialchars($speciality); ?>" readonly>
            </div>
        </div>
        <div class="row mb-3">
            <label class="col-sm-3 col-form-label">Experience</label>
            <div class="col-sm-6">
                <input type="text" class="form-control" name="Doctor_Experience" value="<?php echo htmlspecialchars($exp); ?>" readonly>
            </div>
        </div>
        <div class="row mb-3">
            <label class="col-sm-3 col-form-label">Phone</label>
            <div class="col-sm-6">
                <input type="text" class="form-control" name="Doctor_Phone" value="<?php echo htmlspecialchars($phone); ?>" readonly>
            </div>
        </div>
    </form>
</div>

<script src="../script.js"></script>
</body>
</html>
