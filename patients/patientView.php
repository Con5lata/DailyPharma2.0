<?php include "../inc/view_header.php";?>


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
    <div class="item"></div>

    <div class="title-text">
            <p>Drugs</p>
            <h1>What are you looking for?</h1>
    </div>

    <div class="drug_section">
        <div class="sidebar">
            <ul class="category-list">
              <li class="category-item active" data-category="Order-Drugs">ORDER DRUGS</li>
              <li class="category-item" data-category="View-Presciptions">VIEW PRESCRIPTIONS</li>
            </ul>
          </div>
    
          <div class="main_content">
            <div class="category-content" id="Order-Drugs">

            <?php 
            
            // Fetch drug information along with the prices from the drug_prices and pharmacies tables
$query = $conn->query("
SELECT d.Drug_ID, d.Drug_Name, d.Drug_Description, d.Drug_Manufacturing_Date, d.Drug_Expiration_Date, p.Pharmacy_Name, dp.Drug_Price
FROM drugs d
INNER JOIN drug_prices dp ON d.Drug_ID = dp.Drug_ID
INNER JOIN pharmacy p ON dp.Pharmacy_ID = p.Pharmacy_ID
");

$drugInformation = array();
while ($row = $query->fetch_assoc()) {
$drugInformation[] = $row;
}

            ?>

            <div class="select-container">
                <label for="availableDrugs">Available Drugs</label>
                <select name="availableDrugs" id="availableDrugs">
                    <option value="">Select a drug</option>
                    <?php foreach ($drugInformation as $drug) : ?>
                        <option value="<?php echo htmlspecialchars($drug['Drug_ID']); ?>" name="<?php echo htmlspecialchars($drug['Drug_Name']);?>"><?php echo htmlspecialchars($drug['Drug_Name'] . ' - ' . $drug['Pharmacy_Name'] . ' - Price: ' . $drug['Drug_Price']); ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div id="drugInfo" style="display: none;">
                <h2>Drug Information</h2>
                <p id="drugName"></p>
                <p id="drugPrice"></p>
                <p id="drugDescription"></p>
                <p id="drugManufacturingDate"></p>
                <p id="drugExpirationDate"></p>
                <p>
                    <a id="placeOrderBtn" class="btn btn-primary" href="order.php">Place Order</a>
                </p>
            </div>
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
                                    <th>Drug ID</th>
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
                                        echo "<td>" . $row["Drug_ID"] . "</td>";
                                        echo "<td>" . $row["Prescription_Amount"] . "</td>";
                                        echo "<td>" . $row["Prescription_Dosage"] . "</td>";
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
                        <textarea class="form-control" name="" id="" cols="30" rows="10" required>
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
                        <a class="btn btn-outline-primary" href="#" role="button">Cancel</a>
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
    
    <script>
        const selectElement = document.getElementById("availableDrugs");
        const drugInfoDiv = document.getElementById("drugInfo");
        const drugNameParagraph = document.getElementById("drugName");
        const drugPriceParagraph = document.getElementById("drugPrice");
        const drugDescriptionParagraph = document.getElementById("drugDescription");
        const drugManufacturingDateParagraph = document.getElementById("drugManufacturingDate");
        const drugExpirationDateParagraph = document.getElementById("drugExpirationDate");

        selectElement.addEventListener("change", (event) => {
            const selectedDrug = event.target.value;
            if (selectedDrug) {
                //convert from php array to js array
                const drug = <?php echo json_encode($drugInformation); ?>;
                const selectedDrugID = drug.find((item) => item.Drug_ID === selectedDrug);
                
                fetch("store_selected_drug.php", {
                    method: "POST",
                    body: JSON.stringify({ selectedDrug }),
                })
                .then(response => response.json())
                .then(data => {
                    console.log(data.message);
                });
                if (selectedDrugID) {
                    drugNameParagraph.textContent = "Drug Name: " + selectedDrugID.Drug_Name;
                    drugPriceParagraph.textContent = "Price: " + selectedDrugID.Drug_Price;
                    drugDescriptionParagraph.textContent = "Description: " + selectedDrugID.Drug_Description;
                    drugManufacturingDateParagraph.textContent = "Manufacturing Date: " + selectedDrugID.Drug_Manufacturing_Date;
                    drugExpirationDateParagraph.textContent = "Expiration Date: " + selectedDrugID.Drug_Expiration_Date;
                    drugInfoDiv.style.display = "block";
                } else {
                    drugInfoDiv.style.display = "none";
                }
            } else {
                drugInfoDiv.style.display = "none";
            }
        });
    </script>
    
</body>
</html>