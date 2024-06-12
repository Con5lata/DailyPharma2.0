<?php
include "../inc/session_header.php";

// Get the selected drug name from the request body
$data = json_decode(file_get_contents("php://input"), true);
$selectedDrug = $data['selectedDrug'];

// Store the selected drug name in a session variable
$_SESSION['selected_drug'] = $selectedDrug;

// Respond with a success message
$response = array("message" => "Selected drug '{$selectedDrug}' has been saved in the session.");
echo json_encode($response);
?>
