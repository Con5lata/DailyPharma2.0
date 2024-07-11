<?php
session_start();
require_once "../connect.php";

// Check if the user is logged in
if (!isset($_SESSION["userid"])) {
    header("Location: loginPharmacy.html");
    exit;
}

// Check if the item_id is set in the POST request
if (isset($_POST['item_id'])) {
    $item_id = $_POST['item_id'];

    // Prepare and execute the SQL query to delete the item
    if ($query = $conn->prepare("DELETE FROM products WHERE item_id = ?")) {
        $query->bind_param('i', $item_id);
        $query->execute();

        // Check if the deletion was successful
        if ($query->affected_rows > 0) {
            // Redirect or show success message
            header("Location: your_redirect_page.php");
            exit;
        } else {
            echo "Error: Could not delete the item.";
        }

        // Close the query
        $query->close();
    } else {
        echo "Error: Could not prepare the SQL statement.";
    }
}

// Close the database connection
$conn->close();
?>
