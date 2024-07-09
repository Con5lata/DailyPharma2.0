<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Patient Search</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="../style.css">
    <style>
        body{
            padding-top: 100px;
            background: url(images/bg3.jpg) no-repeat;
            background-position: center;
            background-size: cover;
        }
        h2{
            font-weight: 700px;
            justify-content: center;
        }
    </style>
</head>

    <!--Header-->
    <header>
        <div class="logo">
            <a href="index.html">DailyPharma</a>
        </div>

        <div class="navbar">
            <nav class="navbar" id="navbar">
                <a href="doctorView.php">Home</a>
                <a href="#about">Features</a>
                <a href="#footer">Contact Us</a>
                
                <a href="profile.php">
                    <i class="uil uil-user"></i>Profile
                </a>
        
                <a href="doctorlogin.html" class="btn-login-popup">Logout</a>                
            </nav>
        </div>

    </header>
        
<body>
    <div class="container mt-5">
        <h2 class="mb-4">SEARCH RESULT</h2>
        
        <table class="table table-bordered mt-4">
            <thead>
                <tr>
                    <th>SSN</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Age</th>
                    
                </tr>
            </thead>
            <tbody>
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
                        echo "<td>" . htmlspecialchars($row['Patient_Age']) . "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='6'>No patients found</td></tr>";
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
