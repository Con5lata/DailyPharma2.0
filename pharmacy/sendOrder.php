<?php
session_start();


if (isset($_GET["id"])) {
    $orderID = $_GET["id"];

    require_once("../connect.php");

    $result = $conn->query("
    SELECT * FROM orders WHERE Order_ID = '$orderID'
    ");
    if ($result->num_rows > 0) {
        $deleteQuery = "DELETE FROM orders WHERE Order_ID = '$orderID'";

        if ($conn->query($deleteQuery) === TRUE) {
            echo "<script>alert('Successful Order Sent')
            window.location.href = 'pharmacyView.php';
            </script>";

        } else {
            echo "<script>alert('Error in Order details')
            window.location.href = 'pharmacyView.php';
            </script>";
        }
    } else {
        echo "<script>alert('Order No longer exists')
        window.location.href = 'pharmacyView.php';
        </script>";
    }
} else {
    echo "<script>alert('No Patient selected')</script>";
    header("Location: doctorView.php");
    exit;
}
?>
