<?php
// Establish a PHP session
session_start();

require_once "../connect.php";

// Check if the user is logged in
if (!isset($_SESSION["userid"]) || !isset($_SESSION["user"])) {
    // Redirect to the login page if the user is not logged in
    header("Location: doctorlogin.html");
    exit;
}

// Get the user information from the session variables
$user = $_SESSION["user"];
$ID = $_SESSION["userid"];
$username = $_SESSION["username"];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.8/css/line.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="../style.css">
    <style>
        .card {
            padding-left: 100px;
            margin-top: 20px;
            padding: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 700px;
  
        }
        .card-header {
            font-size: 1.5rem;
            font-weight: bold;
            justify-content: center;
        }
        .form-label {
            font-weight: 500;
            justify-content: center;
        }
        
    </style>
    <title>DailyPharma - Doctor Home</title>
</head>
<body class="DoctorView">

    <!--Header-->
    <header>
        <div class="logo">
            <a href="../index.html">DailyPharma</a>
        </div>

        <div class="navbar">
            <nav class="navbar" id="navbar">
                <a href="doctorView.php">Home</a>
                <a href="#about">Features</a>
                <a href="#footer">Contact Us</a>
                
                <a href="profile.php">
                    <i class="uil uil-user"></i>Profile
                </a>
        
                <a href="doctorlogin.html" id="logoutButton" class="btn-login-popup">Logout</a>                
            </nav>
        </div>

        <i class="uil uil-bars navbar-toggle" onclick="toggleOverlay()"></i>

        <div id="menu" onclick="toggleOverlay()">
            <div id="menu-content">
                <a href="doctorView.php">Home</a>
                <a href="#about">Features</a>
                <a href="#footer">Contact Us</a>
                <a href="profile.php">Profile</a>
                <a href="doctorlogin.html" id="logoutButton">Logout</a>
            </div>
        </div>
    </header>

    <!-- Above fold -->
    <div class="image-container" id="about">
        <div class="Overlay-image"></div>
        <div class="content">
            <div class="image-slide">
                <div class="image-desc active">
                    <h2>Prescribe Medication To Your Patients</h2>
                    <p>Prescribe and manage the drugs for your patients.</p>
                </div>
                <div class="image-desc">
                    <h2>Monitor Patient Wellbeing</h2>
                    <p>Conveniently observe your patients' health.</p>
                </div>
            </div>
            <div class="arrow-buttons">
                <div class="arrow-left"><i class="uil uil-angle-left-b"></i></div>
                <div class="arrow-right"><i class="uil uil-angle-right-b"></i></div>
            </div>
        </div>
    </div>

    <!-- Drugs -->
    <div class="item">
        <div class="title-text">
            <p>Features</p>
            <h1>What do you need?</h1>
        </div>
    </div>

    <div class="drug_section">
        <div class="sidebar">
            <ul class="category-list">
                <li class="category-item active" data-category="Manage-Patients">MANAGE PATIENTS</li>
                <li class="category-item" data-category="Prescribe-Drugs">PRESCRIBE DRUGS</li>
            </ul>
        </div>

        <div class="main_content">
            <div class="category-content" id="Manage-Patients">
                <div class="container my-5">
                    <h2>List of Patients</h2>
                    <br>
                    <a class="btn btn-primary" href="addpatient.html" role="button">Add New Patient</a>
                    <br><br>
                    <!-- Search Container -->
                    <form action="search_patient.php" method="get">
                        <div class="search-container">
                            <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search" name="search">
                            <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
                        </div>
                    </form>
                    <br>
                    <table class="table">
                        <thead>
                            <tr>
                                <th>SSN</th>       
                                <th>Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Gender</th>
                                <th>AGE</th>
                                
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            require_once("../connect.php");

                            // Prepare the SQL query
                            $stmt = $conn->prepare("
                                SELECT p.Patient_SSN, p.Patient_Name, p.Patient_Email, p.Patient_Phone, p.Patient_Gender, p.Patient_Age
                                FROM patients p
                                INNER JOIN doctor_patient dp ON p.Patient_SSN = dp.Patient_SSN
                                WHERE dp.Doctor_SSN = ? AND p.status = 'active'
                            ");

                            if ($stmt) {
                                // Bind the parameter and execute the statement
                                $stmt->bind_param("s", $ID);
                                $stmt->execute();
                                $result = $stmt->get_result();

                                // Check if the query returned any rows
                                if ($result->num_rows > 0) {
                                    while ($row = $result->fetch_assoc()) {
                                        
                                    echo "<tr>";
                                    echo "<td>" . $row["Patient_SSN"] . "</td>";
                                    echo "<td>" . $row["Patient_Name"] . "</td>";
                                    echo "<td>" . $row["Patient_Email"] . "</td>";
                                    echo "<td>" . $row["Patient_Phone"] . "</td>";
                                    echo "<td>" . $row["Patient_Gender"] . "</td>";
                                    echo "<td>" . $row["Patient_Age"] . "</td>";

                                    echo "</tr>";
                                    }
                                } else {
                                    echo "<tr><td colspan='7'>No patients found.</td></tr>";
                                }

                                // Close the statement
                                $stmt->close();
                            } else {
                                echo "Error preparing statement: " . $conn->error;
                            }

                            // Close the connection
                            $conn->close();
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
            

            <div class="category-content" id="Prescribe-Drugs">
                    <form action="search_prescription.php" method="get">
                        <div class="search-container">
                            <input class="form-control mr-sm-2" type="search" placeholder="Search by patient name" aria-label="Search" name="search">
                            <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
                        </div>
                    </form>
            <div class="card">
            <div class="card-header">
                Prescription Form
            </div>
            
            <div class="card-body">
                <form action="submit_prescription.php" method="post">
                    <div class="row mb-3">
                        <label class="col-sm-3 col-form-label" for="patient_ssn">Patient SSN</label>
                        <div class="col-sm-9">
                            <input type="text" id="patient_ssn" class="form-control" name="Patient_SSN" required>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label class="col-sm-3 col-form-label" for="doctor_ssn">Doctor SSN</label>
                        <div class="col-sm-9">
                            <input type="text" id="doctor_ssn" class="form-control" name="Doctor_SSN" value="<?php echo htmlspecialchars($ID); ?>" required>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label class="col-sm-3 col-form-label" for="drug_name">Drug Name</label>
                        <div class="col-sm-9">
                            <input type="text" id="drug_name" class="form-control" name="Drug_Name" required>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label class="col-sm-3 col-form-label" for="prescription_amt">Prescription Amount</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="prescription_amt" name="Prescription_Amt" required>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label class="col-sm-3 col-form-label" for="prescription_dosage">Prescription Instructions</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="prescription_dosage" name="Prescription_Instructions" required>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="offset-sm-3 col-sm-9 d-grid">
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>  
            </div>
        </div>
    </div>

    <!-- Footer -->
    <section id="footer">
        <div class="title-text">
            <p>CONTACT US</p>
            <h1>Any Queries?</h1>
        </div>

        <div class="footer-row">
            <div class="footer-left">
                <h1>Contact information</h1>
                <div class="contact-link">
                    <div class="contact-info">
                        <i class="uil uil-twitter"></i>
                        <span>@DailyPharma</span>
                    </div>
                    <div class="contact-info">
                        <i class="uil uil-instagram"></i>
                        <span>@TheDailyPharma</span>
                    </div>
                    <div class="contact-info">
                        <i class="uil uil-facebook"></i>
                        <span>@DailyPharma</span>
                    </div>
                    <div class="contact-info">
                        <i class="uil uil-linkedin"></i>
                        <span>@DailyPharma - Medical Website</span>
                    </div>
                    <div class="contact-info">
                        <i class="uil uil-at"></i>
                        <span>DailyPharma@gmail.com</span>
                    </div>
                    <div class="contact-info">
                        <i class="uil uil-calling"></i>
                        <span>0769690000</span>
                    </div>
                </div>
            </div>

            <div class="footer-right">
                <div class="quick-links">
                    <h1>Quick Links</h1>
                    <ul>
                        <li><a href="index.html">Home</a></li>
                        <li><a href="#service">About Us</a></li>
                        <li><a href="#feature">Features</a></li>
                        <li><a href="#">FAQ</a></li>
                        <li><a href="#">Privacy Policy</a></li>
                        <li><a href="#">Terms and Conditions</a></li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="additional-info">
            <p>&copy; 2023 DailyPharma. All rights reserved.</p>
        </div>
    </section>

    <script src="../script.js"></script>
    <script src="../script1.js"></script>
    <script src="../script4.js"></script>
    <script src="../logout.js"></script>
</body>
</html>
