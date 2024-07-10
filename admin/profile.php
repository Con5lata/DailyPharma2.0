<?php
session_start();
require_once "../connect.php";

// Check if the user is logged in
if (!isset($_SESSION["userid"]) || !isset($_SESSION["username"])) {
    header("Location: loginAdmin.html");
    exit;
}

// Get the user information from the session variables
$ID = $_SESSION["userid"];

$query = $conn->prepare("SELECT * FROM admin WHERE Admin_ID = ?");
$query->bind_param("i", $ID);
$query->execute();
$row = $query->get_result()->fetch_assoc();

if (!$row) {
    echo "User not found.";
    exit;
}

// Extract data from the fetched row
$ID = $row["Admin_ID"];
$name = $row["Admin_Name"];
$password = $row["Password"];
$status = $row["Status"];
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-COMPATIBLE" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Profile</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../style.css">
    <style> 
        body {
            background: url('images/bg3.jpg');
            background-size: cover;
        }
        h2 {
            padding-top: 100px;
            padding-bottom: 50px;
            font-weight: 700;
            text-align: center;
        } 
        .bold-text {
            font-weight: 700;
            text-align: center;
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
            <a href="adminView.php">Home</a>
            <a href="#about">Features</a>
            <a href="#footer">Contact Us</a>
            <a href="logout.php" class="btn-login-popup">Logout</a>                
        </nav>
    </div>

    <i class="uil uil-bars navbar-toggle" onclick="toggleOverlay()"></i>

    <div id="menu" onclick="toggleOverlay()">
        <div id="menu-content">
            <a href="adminView.php">Home</a>
            <a href="#about">Features</a>
            <a href="#footer">Contact Us</a>
            <a href="logout.php" class="btn-login-popup">Logout</a> 
        </div>
    </div>
</header>

<div class="container my-5">
    <h2>Admin Profile</h2>
    <form>
        <div class="row mb-3">
            <label class="col-sm-3 col-form-label">Admin ID</label>
            <div class="col-sm-6">
                <input type="text" class="form-control" value="<?php echo htmlspecialchars($ID); ?>" readonly>
            </div>
        </div>
        <div class="row mb-3">
            <label class="col-sm-3 col-form-label">Name</label>
            <div class="col-sm-6">
                <input type="text" class="form-control" value="<?php echo htmlspecialchars($name); ?>" readonly>
            </div>
        </div>
        <div class="row mb-3">
            <label class="col-sm-3 col-form-label">Password</label>
            <div class="col-sm-6">
                <input type="text" class="form-control" value="<?php echo htmlspecialchars($password); ?>" readonly>
            </div>
        </div>
        <div class="row mb-3">
            <label class="col-sm-3 col-form-label">Status</label>
            <div class="col-sm-6">
                <input type="text" class="form-control" value="<?php echo htmlspecialchars($status); ?>" readonly>
            </div>
        </div>

       
    </form>
</div>

<script src="../script.js"></script>
</body>
</html>
