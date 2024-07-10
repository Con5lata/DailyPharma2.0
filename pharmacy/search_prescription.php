<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Prescription Search</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="../style.css">
    <style>
        body {
            padding-top: 100px;
            background: url(images/bg3.jpg) no-repeat;
            background-position: center;
            background-size: cover;
        }
        h2 {
            font-weight: 700;
            justify-content: center;
        }
    </style>
</head>
<body>
    <!--Header-->
    <header>
        <div class="logo">
            <a href="index.html">DailyPharma</a>
        </div>
        <div class="navbar">
            <nav class="navbar" id="navbar">
                <a href="pharmacyView.php">Home</a>
                <a href="#about">Features</a>
                <a href="#footer">Contact Us</a>
                <a href="profile.php">
                    <i class="uil uil-user"></i>Profile
                </a>
                <a href="loginpharmacy.html" class="btn-login-popup">Logout</a>
            </nav>
        </div>
    </header>
    
    <div class="container mt-5">
        <h2 class="mb-4">Search Prescriptions</h2>
        
        <!-- Search Form -->
        <form method="GET" action="">
            <div class="form-group">
                <label for="search">Search by Patient SSN or Name:</label>
                <input type="text" name="search" class="form-control" id="search" placeholder="Enter Patient SSN or Name">
            </div>
            <button type="submit" class="btn btn-primary">Search</button>
        </form>
        
        <table class="table table-bordered mt-4">
            <thead>
                <tr>
                    <th>Prescription ID</th>
                    <th>Patient Name</th>
                    <th>Doctor Name</th>
                    <th>Medication</th>
                    <th>Dosage</th>
                    <th>Instructions</th>
                    <th>Prescribed</th>
                </tr>
            </thead>
            <tbody>
                <?php
                require_once("../connect.php");

                // Retrieve search query
                $search = isset($_GET['search']) ? trim($_GET['search']) : '';

                // Prepare the SQL statement
                if ($search) {
                    $sql = "
                        SELECT 
                            prescriptions.*,
                            patients.Patient_Name AS Patient_Name,
                            doctors.Doctor_Name AS Doctor_Name
                        FROM 
                            prescriptions
                        JOIN 
                            patients ON prescriptions.Patient_SSN = patients.Patient_SSN
                        JOIN 
                            doctors ON prescriptions.Doctor_SSN = doctors.Doctor_SSN
                        WHERE 
                            patients.Patient_SSN LIKE ? OR patients.Patient_Name LIKE ?
                    ";
                    $param = "%" . $search . "%";
                    $stmt = $conn->prepare($sql);
                    $stmt->bind_param("ss", $param, $param);
                } else {
                    $sql = "
                        SELECT 
                            prescriptions.*,
                            patients.Patient_Name AS Patient_Name,
                            doctors.Doctor_Name AS Doctor_Name
                        FROM 
                            prescriptions
                        JOIN 
                            patients ON prescriptions.Patient_SSN = patients.Patient_SSN
                        JOIN 
                            doctors ON prescriptions.Doctor_SSN = doctors.Doctor_SSN
                    ";
                    $stmt = $conn->prepare($sql);
                }

                // Execute the statement
                $stmt->execute();
                $result = $stmt->get_result();

                // Fetch and display results
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . htmlspecialchars($row['Prescription_ID']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['Patient_Name']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['Doctor_Name']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['Drug_Name']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['Prescription_Amt']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['Prescription_Instructions']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['Prescribed']) . "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='8'>No prescriptions found</td></tr>";
                }

                // Close the statement and connection
                $stmt->close();
                $conn->close();
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>
