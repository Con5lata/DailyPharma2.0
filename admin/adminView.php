<?php
// Establish a PHP session
session_start();

require_once "../connect.php";

// Check if the user is logged in
if (!isset($_SESSION["userid"]) || !isset($_SESSION["user"])) {
    // Redirect to the login page if the user is not logged in
    header("Location: loginadmin.html");
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
    <title>DailyPharma - Admin Home</title>
    <style>
        
        .h2{align-content: center;

        }
        .category-content {
            display: none;
        }
        .category-content.show {
            display: block;
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
            <a href="profile.php">
                <i class="uil uil-user"></i>Profile
            </a>
            <a href="loginadmin.html" class="btn-login-popup">Logout</a>
        </nav>
    </div>

    <i class="uil uil-bars navbar-toggle" onclick="toggleOverlay()"></i>

    <div id="menu" onclick="toggleOverlay()">
        <div id="menu-content">
        <a href="adminView.php">Home</a>
            <a href="#about">Features</a>
            <a href="#footer">Contact Us</a>
            <a href="profile.php">
                <i class="uil uil-user"></i>Profile
            </a>
            <a href="loginadmin.html">Logout</a>
        </div>
    </div>
</header>

<div class="image-container" id="about">
    <div class="Overlay-image"></div>
    <div class="content">
        <div class="image-slide">
            <div class="image-desc active">
                <h2>Manage Our Users</h2>
                <p>Manage the users in our system.</p>
            </div>
            <div class="image-desc ">
                <h2>Manage Our Users</h2>
                <p>Suspend and create accounts </p>
            </div>
            <div class="arrow-buttons">
                <div class="arrow-left"><i class="uil uil-angle-left-b"></i></div>
                <div class="arrow-right"><i class="uil uil-angle-right-b"></i></div>
            </div>
        </div>
    </div>
</div>

<div class="item"></div>
<div class="title-text">
    <p>Users</p>
    <h1>Who uses our system?</h1>
</div>

<div class="drug_section">
    <div class="sidebar">
        <ul class="category-list">
            <li class="category-item active" data-category="Patients-List">LIST OF PATIENTS</li>
            <li class="category-item" data-category="Doctors-List">LIST OF DOCTORS</li>
            <li class="category-item" data-category="Pharmacists-List">LIST OF PHARMACISTS</li>
        </ul>
    </div>


<div class="main_content">
    <div class="category-content show" id="Patients-List" data-category="Patients-List">
        <h2>List of Patients</h2>
        <br>
        <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#createPatientModal">Create Account</button>
        <br>
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
                    <th>DOB</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                require_once("../connect.php");

                $resultsPerPage = 5;
                $currentPage = isset($_GET['page']) ? $_GET['page'] : 1;
                $offset = ($currentPage - 1) * $resultsPerPage;

                $countQuery = "SELECT COUNT(*) AS total FROM patients";
                $countResult = $conn->query($countQuery);
                $countRow = $countResult->fetch_assoc();
                $totalResults = $countRow['total'];
                $totalPages = ceil($totalResults / $resultsPerPage);

                $sql = "SELECT * FROM patients LIMIT $offset, $resultsPerPage";
                $result = $conn->query($sql);

                if (!$result) {
                    die("Invalid query: " . $conn->error);
                }

                while ($row = $result->fetch_assoc()) {
                    echo "
                    <tr>
                        <td>{$row['Patient_SSN']}</td>
                        <td>{$row['Patient_Name']}</td>
                        <td>{$row['Patient_Email']}</td>
                        <td>{$row['Patient_Phone']}</td>
                        <td>{$row['Patient_DOB']}</td>
                        <td>{$row['Status']}</td>
                        <td>
                            <a class='btn btn-danger btn-sm' href='patientedit.php?SSN={$row['Patient_SSN']}'>Edit</a>
                        </td>
                    </tr>";
                }
                ?>
            </tbody>
        </table>

    </div>

    <div class="category-content" id="Doctors-List" data-category="Doctors-List">
        <h2>List of Doctors</h2>
        <br>
        <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#createDoctorModal">Create Account</button>
        <br>
        <!-- Search Container -->
        <form method="GET" action="search_doctor.php">
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
                    <th>Phone</th>
                    <th>Speciality</th>
                    <th>Experience</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                
                <?php
                $resultsPerPage = 5;
                $currentPage = isset($_GET['page']) ? $_GET['page'] : 1;
                $offset = ($currentPage - 1) * $resultsPerPage;

                $countQuery = "SELECT COUNT(*) AS total FROM doctors";
                $countResult = $conn->query($countQuery);
                $countRow = $countResult->fetch_assoc();
                $totalResults = $countRow['total'];
                $totalPages = ceil($totalResults / $resultsPerPage);

                $sql = "SELECT * FROM doctors LIMIT $offset, $resultsPerPage";
                $result = $conn->query($sql);

                if (!$result) {
                    die("Invalid query: " . $conn->error);
                }

                while ($row = $result->fetch_assoc()) {
                    echo "
                    <tr>
                        <td>{$row['Doctor_SSN']}</td>
                        <td>{$row['Doctor_Name']}</td>
                        <td>{$row['Doctor_Phone']}</td>
                        <td>{$row['Doctor_Speciality']}</td>
                        <td>{$row['Doctor_Experience']}</td>
                        <td>{$row['Status']}</td>
                        <td>
                            <a class='btn btn-danger btn-sm' href='doctoredit.php?SSN={$row['Doctor_SSN']}'>Edit</a>
                        </td>
                    </tr>";
                }
                ?>
            </tbody>
        </table>
    </div>

    <div class="category-content" id="Pharmacists-List" data-category="Pharmacists-List">
        <h2>List of Pharmacists</h2>
        <br>
        <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#createPharmacistModal">Create Account</button>
        <br>
        <!-- Search Container -->
        <form method="GET" action="search_pharmacist.php">
            <div class="search-container">
                <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search" name="search">
                <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
            </div>
        </form>
        
        <br>
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $resultsPerPage = 5;
                $currentPage = isset($_GET['page']) ? $_GET['page'] : 1;
                $offset = ($currentPage - 1) * $resultsPerPage;

                $countQuery = "SELECT COUNT(*) AS total FROM pharmacists";
                $countResult = $conn->query($countQuery);
                $countRow = $countResult->fetch_assoc();
                $totalResults = $countRow['total'];
                $totalPages = ceil($totalResults / $resultsPerPage);

                $sql = "SELECT * FROM pharmacists LIMIT $offset, $resultsPerPage";
                $result = $conn->query($sql);

                if (!$result) {
                    die("Invalid query: " . $conn->error);
                }

                while ($row = $result->fetch_assoc()) {
                    echo "
                    <tr>
                        <td>{$row['Pharmacist_ID']}</td>
                        <td>{$row['Pharmacist_Name']}</td>
                        <td>{$row['Pharmacist_Email']}</td>
                        <td>{$row['Pharmacist_Phone']}</td>
                        <td>{$row['Status']}</td>
                        <td>
                            <a class='btn btn-danger btn-sm' href='pharmacistedit.php?ID={$row['Pharmacist_ID']}'>Edit</a>
                        </td>
                    </tr>";
                }
                ?>
            </tbody>
        </table>

    
 </div>
</div>
</div>
<!-- Modals for Create Account -->
<!-- Patient Modal -->
<div class="modal fade" id="createPatientModal" tabindex="-1" aria-labelledby="createPatientModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="createpatient.php" method="POST">
                <div class="modal-header">
                    <h5 class="modal-title" id="createPatientModalLabel">Create Patient Account</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="patient_ssn" class="form-label">SSN</label>
                        <input type="text" class="form-control" id="patient_ssn" name="Patient_SSN" required>
                    </div>
                    <div class="mb-3">
                        <label for="patient_name" class="form-label">Name</label>
                        <input type="text" class="form-control" id="patient_name" name="Patient_Name" required>
                    </div>
                    <div class="mb-3">
                        <label for="patient_email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="patient_email" name="Patient_Email" required>
                    </div>
                    <div class="mb-3">
                        <label for="patient_phone" class="form-label">Phone</label>
                        <input type="text" class="form-control" id="patient_phone" name="Patient_Phone" required>
                    </div>
                    <div class="mb-3">
                        <label for="patient_dob" class="form-label">Date of Birth</label>
                        <input type="date" class="form-control" id="patient_dob" name="Patient_DOB" required>
                    </div>
                    <div class="mb-3">
                        <label for="patient_status" class="form-label">Status</label>
                        <select class="form-control" id="patient_status" name="Status" required>
                            <option value="Active">Active</option>
                            <option value="Inactive">Inactive</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Create Account</button>
                </div>
            </form>
        </div>
    </div>
</div>


<!-- Doctor Modal -->
<div class="modal fade" id="createDoctorModal" tabindex="-1" aria-labelledby="createDoctorModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="createdoctor.php" method="POST">
                <div class="modal-header">
                    <h5 class="modal-title" id="createDoctorModalLabel">Create Doctor Account</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="doctor_ssn" class="form-label">SSN</label>
                        <input type="text" class="form-control" id="doctor_ssn" name="Doctor_SSN" required>
                    </div>
                    <div class="mb-3">
                        <label for="doctor_name" class="form-label">Name</label>
                        <input type="text" class="form-control" id="doctor_name" name="Doctor_Name" required>
                    </div>
                    <div class="mb-3">
                        <label for="doctor_phone" class="form-label">Phone</label>
                        <input type="text" class="form-control" id="doctor_phone" name="Doctor_Phone" required>
                    </div>
                    <div class="mb-3">
                        <label for="doctor_speciality" class="form-label">Speciality</label>
                        <input type="text" class="form-control" id="doctor_speciality" name="Doctor_Speciality" required>
                    </div>
                    <div class="mb-3">
                        <label for="doctor_experience" class="form-label">Experience</label>
                        <input type="number" class="form-control" id="doctor_experience" name="Doctor_Experience" required>
                    </div>
                    <div class="mb-3">
                        <label for="doctor_status" class="form-label">Status</label>
                        <select class="form-control" id="doctor_status" name="Status" required>
                            <option value="Active">Active</option>
                            <option value="Inactive">Inactive</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Create Account</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Pharmacist Modal -->
<div class="modal fade" id="createPharmacistModal" tabindex="-1" aria-labelledby="createPharmacistModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="createpharmacist.php" method="POST">
                <div class="modal-header">
                    <h5 class="modal-title" id="createPharmacistModalLabel">Create Pharmacist Account</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="pharmacist_id" class="form-label">ID</label>
                        <input type="text" class="form-control" id="pharmacist_id" name="Pharmacist_ID" required>
                    </div>
                    <div class="mb-3">
                        <label for="pharmacist_name" class="form-label">Name</label>
                        <input type="text" class="form-control" id="pharmacist_name" name="Pharmacist_Name" required>
                    </div>
                    <div class="mb-3">
                        <label for="pharmacist_email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="pharmacist_email" name="Pharmacist_Email" required>
                    </div>
                    <div class="mb-3">
                        <label for="pharmacist_phone" class="form-label">Phone</label>
                        <input type="text" class="form-control" id="pharmacist_phone" name="Pharmacist_Phone" required>
                    </div>
                    <div class="mb-3">
                        <label for="Pharmacist_status" class="form-label">Status</label>
                        <select class="form-control" id="pharamacist_status" name="Status" required>
                            <option value="Active">Active</option>
                            <option value="Inactive">Inactive</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Create Account</button>
                </div>
            </form>
        </div>
    </div>
</div


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
    
    <script>
        document.addEventListener('DOMContentLoaded', (event) => {
            const categoryItems = document.querySelectorAll('.category-item');
            const categoryContents = document.querySelectorAll('.category-content');

            // Function to show content based on selected category
            function showCategoryContent(selectedCategory) {
                categoryContents.forEach((content) => {
                    if (content.dataset.category === selectedCategory) {
                        content.classList.add('show');
                    } else {
                        content.classList.remove('show');
                    }
                });
            }

            // Function to handle category item click
            function handleCategoryClick(event) {
                const selectedCategory = event.target.dataset.category;
                categoryItems.forEach((item) => {
                    item.classList.remove('active');
                });
                event.target.classList.add('active');
                showCategoryContent(selectedCategory);
            }

            // Add event listeners to category items
            categoryItems.forEach((item) => {
                item.addEventListener('click', handleCategoryClick);
            });

            // Initialize the first category as active
            if (categoryItems.length > 0) {
                categoryItems[0].classList.add('active');
                showCategoryContent(categoryItems[0].dataset.category);
            }
        });
    </script>
    
</body>
</html>
