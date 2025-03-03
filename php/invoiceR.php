<?php
$servername = "localhost";
$port = "3306";
$username = "company1";
$password = "shanely31";
$dbname = "invoicedb";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die('Connection failed: ' . $conn->connect_error);
}

$searchQuery = '';
if (isset($_GET['search'])) {
    $searchQuery = $_GET['search'];
    $sql = "SELECT * FROM invoices WHERE clientName LIKE '%$searchQuery%' OR id LIKE '%$searchQuery%";
} else {
    $sql = 'SELECT * FROM invoices';
}

$result = $conn->query($sql);

if (isset($_POST['delete'])) {
    $id = $_POST['id'];
    $deleteSql = "DELETE FROM invoices WHERE id = $id";
    if ($conn->query($deleteSql) === TRUE) {
        echo 'Invoice deleted successfully.';
    } else {
        echo 'Error deleting invoice: ' . $conn->error;
    }
}
?>
<!DOCTYPE html>
<html lang='en'>

<head>
    <meta charset='UTF-8'>
    <title>All Invoices</title>
    <link rel='stylesheet' href='https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css'>
    <style>
        .invoice-list {
            margin-top: 20px;
        }

        .btn {
            margin-right: 5px;
            margin-bottom: 5px;
        }

        .go-back-btn {
            padding: 10px 20px;
        }
    </style>
</head>

<body>
    <div class='container'>
        <h1>All Invoices</h1>
        <form action='' method='get'>
            <input type='text' name='search' placeholder='Search by name or ID' value='<?php echo $searchQuery; ?>'>
            <input type='submit' value='Search'>
        </form>
        <div class='invoice-list'>
            <?php
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<div class='card'>";
                    echo "<div class='card-body'>";
                    echo "<h5 class='card-title'>" . $row['clientName'] . "</h5>";
                    echo "<p class='card-text'>Invoice ID: " . $row['id'] . "</p>";
                    echo "<a href='invoiceEdit.php?id=" . $row['id'] . "' class='btn btn-secondary'>Edit</a>";
                    echo "<a href='invoice.R.P.php?id=" . $row['id'] . "' class='btn btn-secondary'>Generate</a>";
                    echo "<form action='' method='post' style='display:inline;'>";
                    echo "<input type='hidden' name='id' value='" . $row['id'] . "'>";
                    echo "<input type='submit' name='delete' value='Delete' class='btn btn-danger'>";
                    echo "</form>";
                    echo "</div>";
                    echo "</div>";
                }
            } else {
                echo 'No invoices found.';
            }
            ?>
        </div>
        <br>
        <a href='../landing.html' class='btn btn-primary go-back-btn'>Go Back</a>
    </div>
    <script src='https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js'></script>
</body>

</html>