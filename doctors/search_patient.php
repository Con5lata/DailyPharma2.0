<?php
                require_once("../connect.php");

                // Retrieve search query
                $search = isset($_GET['search']) ? trim($_GET['search']) : '';

                // Prepare the SQL statement
                if ($search) {
                    $sql = "SELECT * FROM patients WHERE Patient_SSN LIKE ? OR Patient_Name LIKE ?";
                    $param = "%" . $search . "%";
                    $stmt = $conn->prepare($sql);
                    $stmt->bind_param("ss", $param, $param);
                } else {
                    $sql = "SELECT * FROM patients";
                    $stmt = $conn->prepare($sql);
                }

                // Execute the statement
                $stmt->execute();
                $result = $stmt->get_result();

                // Fetch and display results
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . htmlspecialchars($row['Patient_SSN']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['Patient_Name']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['Patient_Email']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['Patient_Phone']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['Patient_Ages']) . "</td>";
                        echo "<td><a class='btn btn-danger btn-sm' href='patientdelete.php?id=" . htmlspecialchars($row['Patient_SSN']) . "'>Delete</a></td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='6'>No patients found</td></tr>";
                }

                // Close the statement and connection
                $stmt->close();
                $conn->close();
                ?>