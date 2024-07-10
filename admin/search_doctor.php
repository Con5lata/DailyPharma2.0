<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Doctor Search</title>
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
            font-weight: 700;
            justify-content: center;
        }
    </style>
</head>
<body>
    <!-- Header -->
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
                <a href="loginAdmin.html" class="btn-login-popup">Logout</a>                
            </nav>
        </div>
    </header>

    <!-- Main Content -->
    <div class="container mt-5">
        <h2 class="mb-4">SEARCH RESULT</h2>

        <table class="table table-bordered mt-4">
            <thead>
                <tr>
                    <th>Doctor SSN</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Specialty</th>
                    <th>Password</th>
                    <th>Action</th>                   
                </tr>
            </thead>
            <tbody>
                <?php
                require_once("../connect.php");

                // Retrieve search query
                $search = isset($_GET['search']) ? trim($_GET['search']) : '';

                // Prepare the SQL statement
                if ($search) {
                    $sql = "SELECT * FROM doctors WHERE Doctor_SSN LIKE ? OR Doctor_Name LIKE ?";
                    $param = "%" . $search . "%";
                    $stmt = $conn->prepare($sql);
                    $stmt->bind_param("ss", $param, $param);
                } else {
                    $sql = "SELECT * FROM doctors";
                    $stmt = $conn->prepare($sql);
                }

                // Execute the statement
                $stmt->execute();
                $result = $stmt->get_result();

                // Fetch and display results
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . htmlspecialchars($row['Doctor_SSN']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['Doctor_Name']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['Doctor_Email']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['Doctor_Phone']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['Doctor_Speciality']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['Password']) . "</td>";
                        echo "<td><a class='btn btn-danger btn-sm' href='doctoredit.php?SSN={$row['Doctor_SSN']}'>Edit</a></td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='7'>No doctors found</td></tr>"; 
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
