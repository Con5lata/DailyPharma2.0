<?php include "../inc/view_header.php";?>

    <!-- Above fold -->
    <div class="image-container" id="about">
        <div class="Overlay-image">
        </div>
        <div class="content">
            <div class="image-slide">
                <div class="image-desc active">
                    <h2>Prescribe Medication To Your Patients</h2>
                    <p> Prescribe and manage the drugs for your patients.</p>
                </div>
                <div class="image-desc">
                    <h2>Monitor Patient Wellbeing</h2>
                    <p>Conveniently observe your patients health.</p>
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
                    <a class="btn btn-primary" href="patientList.php" role="button">Add New Patient</a>
                    <br>
                    <table class="table">
                        <thead>
                            <tr>
                                <th>SSN</th>       
                                <th>Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Gender</th>
                                <th>Age</th>
                                <th>Action</th>
                            </tr>
                        </thead>

                        <tbody>

                            <?php
                            require_once("../connect.php");                     

                            $result = $conn->query("
                            SELECT p.Patient_SSN, p.Patient_Name, p.Patient_Email, p.Patient_Phone, p.Patient_Gender, p.Patient_Age
                            FROM patients p
                            INNER JOIN doctor_patient dp ON p.Patient_SSN = dp.Patient_SSN
                            WHERE dp.Doctor_SSN = '$ID' AND p.status = 'active'");

                            if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                                    echo "<tr>";
                                    echo "<td>" . $row["Patient_SSN"] . "</td>";
                                    echo "<td>" . $row["Patient_Name"] . "</td>";
                                    echo "<td>" . $row["Patient_Email"] . "</td>";
                                    echo "<td>" . $row["Patient_Phone"] . "</td>";
                                    echo "<td>" . $row["Patient_Gender"] . "</td>";
                                    echo "<td>" . $row["Patient_Age"] . "</td>";
                                    echo "<td>";
                                    echo "<a class='btn btn-danger btn-sm' href='confirmDeletePatient.php?id=" . $row["Patient_SSN"] . "'>Delete</a>";
                                    echo "</td>";
                                    echo "</tr>";
                                }
                            }
                            ?>

                        </tbody>
                    </table>
                </div>
            </div>

            <div class="category-content" id="Prescribe-Drugs">
                <div class="form">
                    <form action="submit_prescription.php" method="post">
                             
                        <div class="row mb-3">
                            <label class="col-sm-3 col-form-label" for="patient_ssn">Patient SSN</label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" id="patient_ssn" name="patient_ssn" required>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label class="col-sm-3 col-form-label" for="doctor_ssn">Doctor SSN</label>
                            <div class="col-sm-6">
                                <input type="text" id="doctor_ssn" name="doctor_ssn" class="form-control" required>
                            </div>
                        </div>
        
                        <div class="row mb-3">
                            <label class="col-sm-3 col-form-label" for="drug_name">Drug Name</label>
                            <div class="col-sm-6">
                                <select name="Drug_ID" id="Drug_ID" style="width: 200px;" required>
                                    <?php
                                    // Fetch drugs from the drugs table
                                    $sql = "SELECT `Drug_ID`, `Drug_Name` FROM drugs";
                                    $result = $conn->query($sql);

                                    if ($result->num_rows > 0) {
                                        while ($row = $result->fetch_assoc()) {
                                            echo '<option value=" '. $row["Drug_ID"] .' "> '. $row["Drug_Name"] .' </option>';
                                        }
                                    } else {
                                        echo '<option value="">No drugs found</option>';
                                    }

                                    $result->close();
                                    ?>
                                </select>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label class="col-sm-3 col-form-label" for="prescription_amt">Prescription Amount</label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" id="prescription_amt" name="prescription_amt" required>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label class="col-sm-3 col-form-label" for="prescription_dosage">Prescription Dosage</label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" id="prescription_dosage" name="prescription_dosage" required>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label class="col-sm-3 col-form-label" for="prescription_inst">Prescription Instructions</label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" id="prescription_inst" name="prescription_inst" >
                            </div>
                        </div>
        
        
                        <div class="row mb-3">
                            <div class="offset-sm-3 col-sm-3 d-grid">
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>


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
                      <li><a href="../index.html">Home</a></li>
                      <li><a href="../index.html#service">About Us</a></li>
                      <li><a href="../index.html#feature">Features</a></li>
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

<?php
$conn->close();
?>