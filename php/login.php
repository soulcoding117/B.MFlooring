<?php
include 'db.php'; // Ensure this file contains proper database connection setup

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    echo json_encode(['success' => false, 'error' => 'Invalid request method']);
    exit();
}

if (!isset($_POST['username']) || !isset($_POST['password'])) {
    echo json_encode(['success' => false, 'error' => 'Missing credentials']);
    exit();
}

$username = $_POST['username'];
$password = $_POST['password'];

// Use the connectDB function to get a database connection
$conn = connectDB();

$stmt = $conn->prepare("SELECT password FROM users WHERE username = ?");
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();

if ($row = $result->fetch_assoc()) {
    // Compare the MD5 hash of the entered password with the hash stored in the database
    if (md5($password) === $row['password']) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'error' => 'Invalid credentials']);
    }
} else {
    echo json_encode(['success' => false, 'error' => 'User not found']);
}

$stmt->close();
$conn->close(); // Close the database connection
?>
