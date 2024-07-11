<?php
// Establish a PHP session
session_start();

require_once "../connect.php";

// Check if the user is logged in
if (!isset($_SESSION["userid"]) || !isset($_SESSION["user"])) {
    // Redirect to the login page if the user is not logged in
    header("Location: loginpharmacy.html");
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
    <title> DailyPharma - Pharmacy Home</title>
</head>
<body class="PharmacyView">

    <!--Header-->
    <header>
        <div class="logo">
            <a href="../index.html">DailyPharma</a>
        </div>

        <div class="navbar">
            <nav class= navbar id="navbar">
                <a href="pharmacyView.php">Home</a>
                <a href="#about">Features</a>
                <a href="#footer">Contact Us</a>
                <a href="profile.php">
                    <i class="uil uil-user"></i>Profile
                </a><!--Place username here-->
                <a href="loginpharmacy.html" class="btn-login-popup" >Logout</a>                
                </nav>
                </nav>
    
            </nav>

        </div>

        <i class="uil uil-bars navbar-toggle" onclick="toggleOverlay()"></i>

        <div id="menu" onclick="toggleOverlay()">
            <div id="menu-content">
                <a href="pharmacyView.phpl">Home</a>
                <a href="#about">Features</a>
                <a href="#footer">Contact Us</a>
                <a href="profile.html">Profile</a><!--Place username here-->
                <a href="loginpharmacy.php">Logout</a>
            </div>
        </div>
    </header>

    <!-- Above fold -->
    <div class="image-container" id="about">
        <div class="Overlay-image">
        </div>
        <div class="content">
            <div class="image-slide">
                <div class="image-desc active">
                    <h2>Manage your Drugs</h2>
                    <p> Upload and manage the drugs you sell to patients.</p>
                </div>
                
                <div class="image-desc">
                    <h2>Hand Out Doctor-Prescriptions</h2>
                    <p>Give the drugs prescribed by doctors to patients.</p>
                </div>
                <div class="image-desc">
                    <h2>Online Over-the-Counter Drugs</h2>
                    <p>Supply patients with drugs they ordered online.</p>
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
                <li class="category-item" data-category="Manage-Prescriptions">PENDING PRESCRIPTIONS</li>
                <li class="category-item" data-category="Prescription-History">PRESCRIPTION HISTORY </li>
                <li class="category-item" data-category="Uploaded-Prescriptions">UPLOADED PRESCRIPTIONS</li>
                <li class="category-item" data-category="Inquiries">INQUIRIES</li>
                <li class="category-item" data-category="Online-Orders">ONLINE ORDERS</li>

            </ul>
        </div>

        <div class="main_content">

            <div class="category-content" id="Manage-Prescriptions">
                <div class="container my-5">
                    <h2>Pending Prescriptions</h2> 
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#prescribeMedicationModal"> Prescribe Medication </button>
                    <form action="search_prescription.php" method="get">
                        <div class="search-container">
                            <input class="form-control mr-sm-2" type="search" placeholder="Search by patient name" aria-label="Search" name="search">
                            <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
                        </div>
                    </form>
                        <br>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Prescription ID</th>
                                    <th>Patient Name</th>
                                    <th>Doctor Name</th>
                                    <th>Prescribed By</th>
                                    <th>Drug Name</th>
                                    <th>Presciption Amount</th>
                                    <th>Prescription Dosage</th>
                                    <th>Dispense</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php 
                                // Establish a connection to the database
                                require_once("../connect.php");

                                // Retrieve prescription data from the database
                                $sql = $sql = "
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
                                    prescriptions.Prescribed = 'N';
                            ";
                                $result = $conn->query($sql);

                                if ($result->num_rows > 0) {
                                    while ($row = $result->fetch_assoc()) {
                                        echo "<tr>";                                        
                                        echo "<td>" . $row["Prescription_ID"]. "</td>";
                                        echo "<td>" . $row["Patient_Name"] . "</td>";
                                        echo "<td>" . $row["Doctor_Name"]. "</td>";
                                        echo "<td>" . (!empty($row["Prescribed_By"]) ? $row["Prescribed_By"] : 'N/A') . "</td>";
                                        echo "<td>" . $row["Drug_Name"] . "</td>";
                                        echo "<td>" . $row["Prescription_Amt"] . "</td>";
                                        echo "<td>" . $row["Prescription_Instructions"] . "</td>";echo "<td>";
                                        echo    "<a class='btn btn-danger btn-sm' href='dispenseDrug.php?ID=" . $row["Prescription_ID"] ."'>Dispense</a>";
                                        echo "</td>";
  
                                        echo "</tr>";
                                    }
                                } else {
                                    echo "<tr><td colspan='8'>No prescriptions found.</td></tr>";
                                }
                                ?>
                            </tbody>
                        </table>

                        
                </div>
            </div>

            <div class="category-content" id="Prescription-History">
                <div class="container my-5">
                    <h2>PRESCRIPTION HISTORY</h2> 
                    <form action="search_prescription.php" method="get">
                        <div class="search-container">
                            <input class="form-control mr-sm-2" type="search" placeholder="Search By patient name" aria-label="Search" name="search">
                            <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
                        </div>
                    </form>

                        <br>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Prescription ID</th>
                                    <th>Patient SSN</th>
                                    <th>Doctor SSN</th>
                                    <th>Prescribed By</th>
                                    <th>Drug Name</th>
                                    <th>Prescription Amount</th>
                                    <th>Prescription Dosage</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php 
                                // Establish a connection to the database
                                require_once("../connect.php");

                                // Retrieve prescription data from the database
                                $sql = $sql = "
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
                                    prescriptions.Prescribed = 'Y';
                            ";
                                $result = $conn->query($sql);

                                if ($result->num_rows > 0) {
                                    while ($row = $result->fetch_assoc()) {
                                        echo "<tr>";                                        
                                        echo "<td>" . $row["Prescription_ID"]. "</td>";
                                        echo "<td>" . $row["Patient_Name"] . "</td>";
                                        echo "<td>" . $row["Doctor_Name"]. "</td>";
                                        echo "<td>" . (!empty($row["Prescribed_By"]) ? $row["Prescribed_By"] : 'N/A') . "</td>";
                                        echo "<td>" . $row["Drug_Name"] . "</td>";
                                        echo "<td>" . $row["Prescription_Amt"] . "</td>";
                                        echo "<td>" . $row["Prescription_Instructions"] . "</td>";
                                        echo "</tr>";
                                    }
                                } else {
                                    echo "<tr><td colspan='7'>No prescriptions found.</td></tr>";
                                }
                                
                                ?>
                            </tbody>
                        </table>
                </div>
            </div>
            <!-- Main Content -->
            <div class="category-content" id="Uploaded-Prescriptions">
                <div class="container my-5">
                    <h2>Uploaded Prescriptions</h2>
                 <table class="table">
                        <thead>
                            <tr>
                                <th>Document ID</th>
                                <th>Patient Name</th>
                                <th>Doctor Name</th>
                                <th>Document Type</th>
                                <th>Upload Date</th>
                                 <th>Actions</th>
                            </tr>
                        </th>
                        <tbody>
                            <?php 
                                // Retrieve uploaded files data from the database
                                $sql = "SELECT * FROM prescription_documents";
                                $result = $conn->query($sql);

                                if ($result->num_rows > 0) {
                                    while ($row = $result->fetch_assoc()) {
                                        echo "<tr>";                                        
                                        echo "<td>" . $row["id"]. "</td>";
                                        echo "<td>" . $row["patient_name"] . "</td>";
                                        echo "<td>" . $row["patient_ssn"]. "</td>";
                                        echo "<td>" . $row["file_path"] . "</td>";
                                        echo "<td>" . $row["created_at"] . "</td>";
                                        // Construct the full file path
                                        $fullFilePath = "../patients/uploads/" . $row["file_path"];
                                        echo "<td>";
                                        echo    "<a class='btn btn-info btn-sm' href='" . $fullFilePath . "' target='_blank'>View</a>";
                                        echo "</td>";
                                        echo "</tr>";
                                    }
                                } else {
                                    echo "<tr><td colspan='6'>No documents found.</td></tr>";
                                }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
            
            <!-- Inquiries Section -->
            <div class="category-content" id="Inquiries">
                <div class="container my-5">
                    <h2>Inquiries</h2>
                    
                    <br>
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Inquiry ID</th>
                                <th>Patient Name</th>
                                <th>Email</th>
                                <th>Inquiry Details</th>
                                <th>Respond</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                                // Retrieve inquiry data from the database
                                $sql = "SELECT * FROM inquiry";
                                $result = $conn->query($sql);

                                if ($result->num_rows > 0) {
                                    while ($row = $result->fetch_assoc()) {
                                        echo "<tr>";                                        
                                        echo "<td>" . $row["Inquiry_No"]. "</td>";
                                        echo "<td>" . $row["Patient_Name"] . "</td>";
                                        echo "<td>" . $row["Email"] . "</td>";
                                        echo "<td>" . $row["Inquiry"] . "</td>";
                                        echo "<td>";
                                        echo    "<a class='btn btn-primary btn-sm' href='respond_inquiry.php?ID=" . $row["Inquiry_No"] ."'>Respond</a>";
                                        echo "</td>";
                                        echo "</tr>";
                                    }
                                } else {
                                    echo "<tr><td colspan='4'>No inquiries found.</td></tr>";
                                }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>      

            <div class="category-content" id="Online-Orders">
                <div class="container my-5">
                    <h2>List of Orders</h2> 
                        <br>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Order ID</th>
                                    <th>Patient SSN</th>
                                    <th>Patient Address</th>
                                </tr>
                            </thead>
                            <tbody>
                                    <tr>               
                                        <td>$row["Order_ID"]</td>            
                                        <td>$row["Patient_SSN"]</td>
                                        <td>$row["Patient_Address"]</td>
                                        <td>
                                            <a class="btn btn-primary" href="#" role="button">Send</a>
                                        </td>
                                    </tr>
                            </tbody>
                        </table>
                </div>
            </div>
        </div>
    </div>
    <!-- Prescription Modal -->
    <div class="modal fade" id="prescribeMedicationModal" tabindex="-1" aria-labelledby="prescribeMedicationModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="prescribe.php" method="POST">
                <div class="modal-header">
                    <h5 class="modal-title" id="prescribeMedicationModalLabel">Prescribe Medication</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <div class="mb-3">
                        <label for="patient_ssn" class="form-label">Patient SSN</label>
                        <input type="text" class="form-control" id="patient_ssn" name="Patient_SSN" required>
                    </div>

                    <div class="mb-3">
                        <label for="patient_name" class="form-label">Patient Name</label>
                        <input type="text" class="form-control" id="patient_name" name="Patient_Name" required>
                    </div>

                    <div class="mb-3">
                        <label for="prescribed_by" class="form-label">Prescribed By</label>
                        <input type="text" class="form-control" id="prescribed_by" name="Prescribed_By" required>
                    </div>

                    <div class="mb-3">
                        <label for="drug_name" class="form-label">Drug Name</label>
                        <input type="text" class="form-control" id="drug_name" name="Drug_Name" required>
                    </div>

                    <div class="mb-3">
                        <label for="prescription_amt" class="form-label">Prescription Amount</label>
                        <input type="text" class="form-control" id="prescription_amt" name="Prescription_Amt" required>
                    </div>
                    
                    <div class="mb-3">
                        <label for="prescription_instructions" class="form-label">Prescription Instructions</label>
                        <textarea class="form-control" id="prescription_instructions" name="Prescription_Instructions" rows="3" required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Prescribe</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Bootstrap JS, Popper.js, and jQuery -->
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>




    <!--Footer-->
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
    
</body>
</html>