<?php
// Start the session
session_start();

// Include database connection
include('../connect.php');

// Check if the user is logged in
if (!isset($_SESSION['userid']) || !isset($_SESSION['username'])) {
    // Redirect to login page if user is not logged in
    header("Location: patientlogin.html");
    exit;
}

// Retrieve user ID from session
$ID = $_SESSION['userid'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.8/css/line.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" />
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <link rel="stylesheet" href="../style.css">
    <title>DailyPharma - Patient Home</title>
</head>
<body class="PatientView">

    <!-- Header -->
    <header>
        <div class="logo">
            <a href="../index.html">DailyPharma</a>
        </div>

        <div class="navbar">
            <nav class="navbar" id="navbar">
                <a href="../patients/patientView.php">Home</a>
                <a class="nav-link" href="#" data-bs-toggle="modal" data-bs-target="#inquiryModal">Inquiry?</a>
                <a class="nav-link" href="#" data-bs-toggle="modal" data-bs-target="#uploadPrescriptionModal">Upload Prescription</a>
                <a href="#footer">Contact Us</a>
                <a href="../patients/profile.php"><i class="fa fa-user" aria-hidden="true"> Profile</i></a>
                <a href="../patients/patientlogin.html" id="logoutButton" class="btn-login-popup">Logout</a>

            </nav>
        </div>

        <i class="uil uil-bars navbar-toggle" onclick="toggleOverlay()"></i>

        <div id="menu" onclick="toggleOverlay()">
            <div id="menu-content">
                <a href="../patients/patientView.php">Home</a>
                <a class="nav-link" href="#" data-bs-toggle="modal" data-bs-target="#inquiryModal">Inquiry?</a>
                <a class="nav-link" href="#" data-bs-toggle="modal" data-bs-target="#uploadPrescriptionModal">Upload Prescription</a>
                <a href="#footer">Contact Us</a>
                <a href="../patients/profile.php"><i class="fa fa-user" aria-hidden="true"> Profile</i></a>
                <a href="../patients/patientlogin.html">Logout</a>
            </div>
        </div>
    </header>

    <!-- Content -->
    <div class="image-container" id="about">
        <div class="Overlay-image"></div>
        <div class="content">
            <div class="image-slide">
                <div class="image-desc active">
                    <h2>View Doctor-Prescribed Medication</h2>
                    <p>Manage and track your prescribed medications from your doctor.</p>
                </div>
                <div class="image-desc">
                    <h2>Order Medications Online</h2>
                    <p>Conveniently order your medications online from our partnered pharmacies.</p>
                </div>
                <div class="image-desc">
                    <h2>Make Inquiries</h2>
                    <p>Get professional advice and make inquiries to doctors and pharmacies.</p>
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
            <p>Drugs</p>
            <h1>What are you looking for?</h1>
        </div>
    </div>

    <div class="drug_section">
        <div class="sidebar">
            <ul class="category-list">
                <li class="category-item active" data-category="Order-Drugs"><a href="ordersite.html">ORDER DRUGS</a></li>
                <li class="category-item" data-category="View-Presciptions">VIEW MEDICATION</li>
            </ul>
        </div>
    
        <div class="category-content" id="View-Presciptions">
            <div class="container my-5">
                <h2>Pending Prescription</h2>
                <p>Please Pick Up Your Prescriptions</p>
                <br>
                <table class="table">
                    <thead>
                        <tr>
                            <th>Prescription ID</th>
                            <th>Patient SSN</th>
                            <th>Doctor SSN</th>
                            <th>Medication</th>
                            <th>Prescription Amount</th>
                            <th>Prescription Dosage</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        // Retrieve prescription data from the database
                        $sql = "SELECT * FROM prescriptions WHERE Prescribed = 'N' AND Patient_SSN = ?";
                        $stmt = $conn->prepare($sql);
                        $stmt->bind_param("i", $ID);
                        $stmt->execute();
                        $result = $stmt->get_result();

                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                echo "<tr>";
                                echo "<td>" . htmlspecialchars($row["Prescription_ID"]) . "</td>";
                                echo "<td>" . htmlspecialchars($row["Patient_SSN"]) . "</td>";
                                echo "<td>" . htmlspecialchars($row["Doctor_SSN"]) . "</td>";
                                echo "<td>" . htmlspecialchars($row["Drug_Name"]) . "</td>";
                                echo "<td>" . htmlspecialchars($row["Prescription_Amt"]) . "</td>";
                                echo "<td>" . htmlspecialchars($row["Prescription_Instructions"]) . "</td>";
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='6'>No prescriptions found.</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Modal Structure for the Inquiry-->
<div class="modal fade" id="inquiryModal" tabindex="-1" aria-labelledby="inquiryModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="inquiryModalLabel">Do you have a Medical Question?</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="inquiryForm" method="post" action="submit_inquiry.php">
                    <div class="mb-3">
                        <label for="patient_ssn" class="form-label">Patient SSN</label>
                        <input type="text" class="form-control" id="patient_ssn" name="Patient_SSN" required>
                    </div>
                    <div class="mb-3">
                        <label for="patient_name" class="form-label">Patient Name</label>
                        <input type="text" class="form-control" id="patient_name" name="Patient_Name" required>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="Email" required>
                    </div>
                    <div class="mb-3">
                        <label for="inquiry" class="form-label">Inquiry</label>
                        <textarea class="form-control" id="inquiry" name="Inquiry" rows="4" required></textarea>
                    </div>
                    <div class="d-flex justify-content-between">
                        <button type="submit" class="btn btn-primary">Submit</button>
                        <button type="button" class="btn btn-outline-primary" data-bs-dismiss="modal">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal Structure for Uploading Prescription -->
<div class="modal fade" id="uploadPrescriptionModal" tabindex="-1" aria-labelledby="uploadPrescriptionModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="uploadPrescriptionModalLabel">Upload Prescription</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="uploadPrescriptionForm" method="post" action="upload_prescription.php" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label for="patient_name" class="form-label">Patient Name</label>
                        <input type="text" class="form-control" id="patient_name" name="Patient_Name" required>
                    </div>
                    <div class="mb-3">
                        <label for="patient_ssn" class="form-label">Patient SSN</label>
                        <input type="text" class="form-control" id="patient_ssn" name="Patient_SSN" required>
                    </div>
                    <div class="mb-3">
                        <label for="prescription_file" class="form-label">Prescription Document</label>
                        <input type="file" class="form-control" id="prescription_file" name="Prescription_File" accept=".pdf,.jpg,.jpeg,.png" required>
                    </div>
                    <div class="d-flex justify-content-between">
                        <button type="submit" class="btn btn-primary">Upload</button>
                        <button type="button" class="btn btn-outline-primary" data-bs-dismiss="modal">Cancel</button>
                    </div>
                </form>
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
                <h1>Contact Information</h1>
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
                        <li><a href="index.html#service">About Us</a></li>
                        <li><a href="index.html#feature">Features</a></li>
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

    <script src="../logout.js"></script>    
    <script src="../script.js"></script>
    <script src="../script1.js"></script>
    <script src="../script4.js"></script>
    
</body>
</html>
