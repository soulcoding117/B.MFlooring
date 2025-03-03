<?php
// Database Connection
$servername = "localhost";
$port = "3306";
$username = "company1";
$password = "shanely31";
$dbname = "invoicedb";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die('Connection failed: ' . $conn->connect_error);
}

// Fetch the invoice data from the form
$invoiceId = $_POST['id'];
$invoiceDate = $_POST['invoiceDate'];
$clientName = $_POST['clientName'];
$description = json_encode(explode(',', $_POST['description']));
$quantity = json_encode(explode(',', $_POST['quantity']));
$unitPrice = json_encode(explode(',', $_POST['unitPrice']));
$deposit = $_POST['deposit'];

// Update the invoice data in the database
$sql = 'UPDATE invoices SET invoiceDate = ?, clientName = ?, description = ?, quantity = ?, unitPrice = ?, deposit = ? WHERE id = ?';
$stmt = $conn->prepare($sql);
$stmt->bind_param('ssssssi', $invoiceDate, $clientName, $description, $quantity, $unitPrice, $deposit, $invoiceId);

if ($stmt->execute()) {
    echo 'success';
    exit();
} else {
    echo 'Failed to update invoice. Error: ' . $stmt->error;
    exit();
}

// Close the statement and connection
$stmt->close();
$conn->close();
