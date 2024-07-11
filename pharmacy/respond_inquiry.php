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

// Get the Inquiry ID from the URL
$inquiryID = $_GET['ID'];

// Fetch the inquiry details from the database
$sql = "SELECT * FROM inquiry WHERE Inquiry_No = ?";
$stmt = $conn->prepare($sql);

// Check if the prepare statement was successful
if (!$stmt) {
    die("Prepare failed: (" . $conn->errno . ") " . $conn->error);
}

$stmt->bind_param("i", $inquiryID);
$stmt->execute();
$result = $stmt->get_result();
$inquiry = $result->fetch_assoc();

// Check if the inquiry exists
if (!$inquiry) {
    echo "Inquiry not found.";
    exit;
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <title>Respond to Inquiry</title>
</head>
<body>
<div class="container">
    <h1>Respond to Inquiry</h1>
    <p><strong>Inquiry ID:</strong> <?php echo htmlspecialchars($inquiry['Inquiry_No']); ?></p>
    <p><strong>Patient SSN:</strong> <?php echo htmlspecialchars($inquiry['Patient_SSN']); ?></p>
    <p><strong>Email:</strong> <?php echo htmlspecialchars($inquiry['Email']); ?></p>
    <p><strong>Inquiry:</strong> <?php echo htmlspecialchars($inquiry['Inquiry']); ?></p>
    

    <?php
    // Construct the mailto link
    $to = htmlspecialchars($inquiry['Email']);
    $subject = "Response to your inquiry (Inquiry ID: " . htmlspecialchars($inquiry['Inquiry_No']) . ")";
    $body = "Dear " . htmlspecialchars($inquiry['Patient_SSN']) . ",\n\nRegarding your inquiry: " . htmlspecialchars($inquiry['Inquiry']) . "\n\n";
    $mailtoLink = "https://mail.google.com/mail/?view=cm&fs=1&to=" . urlencode($to) . "&su=" . urlencode($subject) . "&body=" . urlencode($body);
    ?>

    <p>
        <a class="btn btn-info" href="<?php echo $mailtoLink; ?>" target="_blank">Respond via Gmail</a>
    </p>
</div>
</body>
</html>

