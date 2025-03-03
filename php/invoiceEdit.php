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

// Fetch the invoice data by its ID
$invoiceId = $_GET['id']; // Assuming the ID is passed as a URL parameter
$sql = 'SELECT * FROM invoices WHERE id = ?';
$stmt = $conn->prepare($sql);
$stmt->bind_param('i', $invoiceId);
$stmt->execute();
$result = $stmt->get_result();
$invoice = $result->fetch_assoc();

// Decode JSON strings
$invoice['description'] = json_decode($invoice['description'], true);
$invoice['quantity'] = json_decode($invoice['quantity'], true);
$invoice['unitPrice'] = json_decode($invoice['unitPrice'], true);

// Close the statement and connection
$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html>

<head>
    <title>Edit and Print Invoice</title>
    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.0.2/css/bootstrap.min.css'>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>

<body>
    <div class='container'>
        <h2>Edit and Print Invoice</h2>
        <form id='invoiceForm'>
            <input type='hidden' name='id' value='<?php echo $invoice['id']; ?>'>
            <div class='mb-3'>
                <label for='invoiceDate' class='form-label'>Invoice Date:</label>
                <input type='date' class='form-control' id='invoiceDate' name='invoiceDate' value='<?php echo $invoice['invoiceDate']; ?>'>
            </div>
            <div class='mb-3'>
                <label for='clientName' class='form-label'>Client Name:</label>
                <input type='text' class='form-control' id='clientName' name='clientName' value='<?php echo stripslashes($invoice['clientName']); ?>'>
            </div>
            <div class='mb-3'>
                <label for='description' class='form-label'>Description:</label>
                <input type='text' class='form-control' id='description' name='description' value='<?php echo stripslashes(implode(',', $invoice['description'])); ?>'>
            </div>
            <div class='mb-3'>
                <label for='quantity' class='form-label'>Quantity:</label>
                <input type='text' class='form-control' id='quantity' name='quantity' value='<?php echo stripslashes(implode(',', $invoice['quantity'])); ?>'>
            </div>
            <div class='mb-3'>
                <label for='unitPrice' class='form-label'>Unit Price:</label>
                <input type='text' class='form-control' id='unitPrice' name='unitPrice' value='<?php echo stripslashes(implode(',', $invoice['unitPrice'])); ?>'>
            </div>
            <div class='mb-3'>
                <label for='deposit' class='form-label'>Deposit:</label>
                <input type='number' class='form-control' id='deposit' name='deposit' value='<?php echo $invoice['deposit']; ?>'>
            </div>
            <button type='button' class='btn btn-secondary' onclick='updateInvoice()'>Update</button>
            <button type='button' class='btn btn-secondary' onclick='generateInvoice()'>Generate</button>
            <button type='button' class='btn btn-secondary' onclick='goBack()'>Back</button>
        </form>
    </div>
    <script>
        function updateInvoice() {
            var formData = $('#invoiceForm').serialize();
            $.ajax({
                type: 'POST',
                url: 'update_invoice.php',
                data: formData,
                success: function(response) {
                    if (response === 'success') {
                        alert('Invoice updated successfully.');
                    } else {
                        alert('Failed to update invoice.');
                    }
                }
            });
        }

        function generateInvoice() {
            window.location.href = 'invoice.E.P.php?id=' + <?php echo $invoice['id']; ?>;
        }

        function goBack() {
            window.location.href = 'invoiceR.php';
        }
    </script>
</body>

</html>