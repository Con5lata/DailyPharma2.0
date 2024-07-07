<?php
//establish a php session
session_start();

require_once "../connect.php";

// Check if the user is logged in
if (!isset($_SESSION["userid"]) || !isset($_SESSION["user"])) {
    // Redirect to the login page if the user is not logged in
    header("Location: patientlogin.html");
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
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" />
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="../style.css">
    <title> DailyPharma - Patient Home</title>
    <style>
        #inquiries {

    padding: 50px 0; /* Padding to create space around the section */
    text-align: center; /* Center-align text */
    justify-content: center;
}
#inquiries .form {
    display: flex;
    justify-content: center; /* Center the form horizontally */
    align-items: center; /* Center the form vertically */
    padding-left: 100px;
}
    </style>
</head>
<body class="PatientView">

    <!--Header-->
    <header>
        <div class="logo">
            <a href="../index.html">DailyPharma</a>
        </div>

        <div class="navbar">
            <nav class= navbar id="navbar">
                <a href="../patients/patientView.php">Home</a>
                <a href="#inquiries">Medical Inquiries</a>
                <a href="#footer">Contact Us</a>
                <a href="../patients/profile.php"><i class="fa fa-user" aria-hidden="true"> Profile</i></a>
                <a href="patientlogin.html" class="btn-login-popup" >Logout</a>                
                
                 
            </nav>
        </div>

        <i class="uil uil-bars navbar-toggle" onclick="toggleOverlay()"></i>

        <div id="menu" onclick="toggleOverlay()">
            <div id="menu-content">
                <a href="../patients/patientView.php">Home</a>
                <a href="#inquiries">Medical Inquiries</a>
                <a href="#footer">Contact Us</a>
                <a href="../patients/profile.php"><i class="fa fa-user" aria-hidden="true"> Profile</i></a>
                <a href="patientlogin.html">Logout</a> 
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
                    <p>Please Pick Up Your Presciptions</p>
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
                                // Establish a connection to the database
                                require_once("../connect.php");

                                // Retrieve prescription data from the database
                                $sql = "SELECT * FROM prescriptions WHERE Prescribed = 'N' AND `Patient_SSN` = '$ID';";
                                $result = $conn->query($sql);

                                if ($result->num_rows > 0) {
                                    while ($row = $result->fetch_assoc()) {
                                        echo "</tr>";
                                        echo "<tr>";                                         
                                        echo "<td>" . $row["Prescription_ID"]. "</td>";
                                        echo "<td>" . $row["Patient_SSN"] . "</td>";
                                        echo "<td>" . $row["Doctor_SSN"]. "</td>";
                                        echo "<td>" . $row["Drug_Name"] . "</td>";
                                        echo "<td>" . $row["Prescription_Amt"] . "</td>";
                                        echo "<td>" . $row["Prescription_Instructions"] . "</td>";
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
    </div>
      
    <div class="item"></div>

    <!-- Inquiries Section -->
    <section id="inquiries" class="med">

        <div class="title-text">
            <p>Inquries</p>
            <h1>Do you have a medical question?</h1>
        </div>

        <div class="form">
            <form method="post">
                <div class="row mb-3">
                    <label class="col-sm-3 col-form-label">Patient SSN</label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" name="" value="" required>
                    </div>
                </div>
                <div class="row mb-3">
                    <label class="col-sm-3 col-form-label">Inquiry</label>
                    <div class="col-sm-6">
                        <textarea class="form-control" name="" id="" width=100% required>
                        </textarea>
                    </div>
                </div>
                <div class="row mb-3">
                    <label class="col-sm-3 col-form-label">Email</label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" name="" value="" required>
                    </div>
                </div>

                <!-- To be chaged into a selection list -->
                <div class="row mb-3">
                    <label class="col-sm-3 col-form-label">Doctor</label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" name="" value="" on>
                    </div>
                </div>
                <div class="row mb-3">
                    <label class="col-sm-3 col-form-label">Pharmacy</label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" name="" value="" on>
                    </div>
                </div>


                <div class="row mb-3">
                    <div class="offset-sm-3 col-sm-3 d-grid">
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                    <div class="col-sm-3 d-grid">
                        <a class="btn btn-outline-primary" href="../patients/patientView.html" role="button">Cancel</a>
                    </div>
                </div>
            </form>
        </div>

    </section>

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

    
    <script src="../script.js"></script>
    <script src="../script1.js"></script>
    <script src="../script4.js"></script>
    
</body>
</html>