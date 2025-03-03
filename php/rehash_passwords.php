<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
// Include your database connection script
include 'php/db.php';

// Connect to the database
$conn = connectDB();

// Fetch all users from the database
$sql = "SELECT id, password FROM users";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Loop through each user and re-hash their password
    while($row = $result->fetch_assoc()) {
        $id = $row['id'];
        $md5Password = $row['password'];
        
        // Here, you would typically verify the MD5 hash; 
        // but since we're transitioning away from MD5, 
        // we'll directly re-hash it using password_hash()
        $newPassword = password_hash($md5Password, PASSWORD_DEFAULT);
        
        // Update the user's password in the database
        $stmt = $conn->prepare("UPDATE users SET password = ? WHERE id = ?");
        $stmt->bind_param("si", $newPassword, $id);
        $stmt->execute();
    }
    echo "Passwords re-hashed successfully.";
} else {
    echo "No users found.";
}

// Close the database connection
$conn->close();
?>