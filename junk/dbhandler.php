<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "InvoiceDB";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$client_name = $_POST["clientName"];
$client_address = $_POST["clientAddress"];

$sql = "INSERT INTO Clients (client_name, client_address) VALUES (?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $client_name, $client_address);
$stmt->execute();
$client_id = $conn->insert_id;

$date = date("Y-m-d");
$deposit = $_POST["deposit"];

$sql = "INSERT INTO Invoices (client_id, date, deposit) VALUES (?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("isd", $client_id, $date, $deposit);
$stmt->execute();

echo "Invoice created successfully!";

$stmt->close();
$conn->close();
?>
