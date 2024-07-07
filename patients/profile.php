<?php
session_start();
require_once "../connect.php";

// Check if the user is logged in
if (!isset($_SESSION["userid"]) || !isset($_SESSION["username"])) {
    header("Location: patientlogin.html");
    exit;
}

// Get the user information from the session variables
$ID = $_SESSION["userid"];

$query = $conn->prepare("SELECT * FROM patients WHERE Patient_SSN = ?");
$query->bind_param("i", $ID);
$query->execute();
$row = $query->get_result()->fetch_assoc();

if (!$row) {
    echo "User not found.";
    exit;
}

// Use $row to access the user's data
$name = $row["Patient_Name"];
$email = $row["Patient_Email"];
$phone = $row["Patient_Phone"];
$gender = $row["gender"];
$dob = $row["Patient_DOB"];
$age = $row["Patient_Age"];
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-COMPATIBLE" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial scale=1.0">
    <title>DailyPharma - Edit Profile</title>
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
                <a href="patientView.php">Home</a>
                <a href="#about">Features</a>
                <a href="#footer">Contact Us</a>
                <a href="../logout.php" class="btn-login-popup">Logout</a>
            </nav>
        </div>
        <i class="uil uil-bars navbar-toggle" onclick="toggleOverlay()"></i>
        <div id="menu" onclick="toggleOverlay()">
            <div id="menu-content">
                <a href="patientView.php">Home</a>
                <a href="#about">Features</a>
                <a href="#footer">Contact Us</a>
                <a href="../logout.php">Logout</a>
            </div>
        </div>
    </header>
    <section id="profile-form">
        <div class="container my-5 transparent-container">
            <h2>Personal Profile</h2>
            <form method="post" action="updateProfile.php">
                <div class="row mb-3">
                    <label class="col-sm-3 col-form-label mb-2">SSN</label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" name="Patient_SSN" value="<?php echo htmlspecialchars($ID); ?>" readonly>
                    </div>
                </div>
                <div class="row mb-3">
                    <label class="col-sm-3 col-form-label mb-2">Name</label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" name="Patient_Name" value="<?php echo htmlspecialchars($name); ?>" required>
                    </div>
                </div>
                <div class="row mb-3">
                    <label class="col-sm-3 col-form-label mb-2">Phone</label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" name="Patient_Phone" value="<?php echo htmlspecialchars($phone); ?>" required>
                    </div>
                </div>
                <div class="row mb-3">
                    <label class="col-sm-3 col-form-label mb-2">Email</label>
                    <div class="col-sm-6">
                        <input type="email" class="form-control" name="Patient_Email" value="<?php echo htmlspecialchars($email); ?>" required>
                    </div>
                </div>
                <div class="row mb-3">
                    <label class="col-sm-3 col-form-label mb-2">Gender</label>
                    <div class="col-sm-6">
                        <select class="form-control" name="gender" required>
                            <option value="Male" <?php if ($gender == 'Male') echo 'selected'; ?>>Male</option>
                            <option value="Female" <?php if ($gender == 'Female') echo 'selected'; ?>>Female</option>
                        </select>
                    </div>
                </div>
                <div class="row mb-3">
                    <label class="col-sm-3 col-form-label mb-2">DOB</label>
                    <div class="col-sm-6">
                        <input type="date" class="form-control" name="Patient_DOB" value="<?php echo htmlspecialchars($dob); ?>" required>
                    </div>
                </div>
                <div class="row mb-3">
                    <label class="col-sm-3 col-form-label mb-2">Age</label>
                    <div class="col-sm-6">
                        <input type="number" class="form-control" name="Patient_Age" value="<?php echo htmlspecialchars($age); ?>" required>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-sm-6 offset-sm-3">
                        <button type="submit" name="update" class="btn btn-primary width">Update</button>
                        <button type="submit" name="cancel" class="btn btn-primary">Cancel</button>
                    </div>
                </div>
            </form>
        </div>
    </section>

    <?php if (isset($_SESSION['update_message'])): ?>
    <script>
        alert("<?php echo $_SESSION['update_message']; ?>");
        <?php unset($_SESSION['update_message']); ?>
    </script>
    <?php endif; ?>

    <script src="../script.js"></script>
    <script src="../script4.js"></script>
</body>
</html>
