<?php
function connectDB()
{
  $servername = "localhost";
  $port = "3306";
  $username = "company1";
  $password = "shanely31";
  $dbname = "bm_flooring";
  // Create connection
  $conn = new mysqli($servername, $username, $password, $dbname);

  // Check connection
  if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
  }

  return $conn;
}

function getPasswordHash($username) {
  $conn = connectDB();
  $stmt = $conn->prepare('SELECT password FROM users WHERE username = ?');
  $stmt->bind_param('s', $username);
  $stmt->execute();
  $result = $stmt->get_result();
  if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    return $row['password'];
  }
  return null;
}
?>