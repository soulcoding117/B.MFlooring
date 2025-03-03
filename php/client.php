<?php
// Database Connection
$servername = "localhost";
$port = "3306";
$username = "company1";
$password = "shanely31";
$dbname = "invoicedb";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection to the database failed: " . $conn->connect_error);
}

// Insert data into the database
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $invoiceDate = $_POST['invoiceDate'];
    $clientName = $_POST['clientName'];
    $clientAddress = $_POST['clientAddress'];
    $clientCompany = $_POST['clientCompany'];
    $description = $_POST['description'];
    $quantity = $_POST['quantity'];
    $unitPrice = $_POST['unitPrice'];
    $deposit = $_POST['deposit'];

    $sql = "INSERT INTO invoices (invoiceDate, clientName, clientAddress, clientCompany, description, quantity, unitPrice, deposit) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssssss", $invoiceDate, $clientName, $clientAddress, $clientCompany, json_encode($description), json_encode($quantity), json_encode($unitPrice), $deposit);

    if ($stmt->execute()) {
        echo "Invoice successfully generated.";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}
$conn->close();
?>

<html>

<head>
    <title>B&M</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.0.2/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.0.2/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" type="text/css" href="../css/invoice.css">

    <style>
        body {
            background-color: #007bff;
            background: linear-gradient(to right bottom, #FFE44D, #806C00);
        }

        .invoiceDetails {
            border: 1px solid #ccc;
            padding: 15px;
            margin-bottom: 20px;
            transition: all 0.3s ease;
        }

        .invoiceDetails:hover {
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .removeInvoiceDetails {
            margin-top: 10px;
        }
    </style>
</head>

<body>
    <div class="container">
        <h2>Enter Client Information</h2>
        <form action="invoice.php" method="POST">
            <div class="mb-3">
                <label for="invoiceDate" class="form-label">Invoice Date:</label>
                <input type="date" class="form-control" id="invoiceDate" name="invoiceDate">
            </div>
            <?php
            $clientFields = array(
                array('name' => 'clientName', 'label' => 'Client Name'),
                array('name' => 'clientAddress', 'label' => 'Client Address'),
                array('name' => 'clientCompany', 'label' => 'Client Company')
            );

            foreach ($clientFields as $field) {
                echo '<div class="mb-3">';
                echo '<label for="' . $field['name'] . '" class="form-label">' . $field['label'] . ':</label>';
                echo '<input type="text" class="form-control" id="' . $field['name'] . '" name="' . $field['name'] . '">';
                echo '</div>';
            }
            ?>

            <h2>Enter Invoice Details</h2>
            <div id="invoiceDetailsContainer">
                <div class="invoiceDetails">
                    <?php
                    $invoiceFields = array(
                        array('name' => 'description', 'label' => 'Description'),
                        array('name' => 'quantity', 'label' => 'Quantity'),
                        array('name' => 'unitPrice', 'label' => 'Unit Price')
                    );

                    foreach ($invoiceFields as $field) {
                        echo '<div class="mb-3">';
                        echo '<label for="' . $field['name'] . '" class="form-label">' . $field['label'] . ':</label>';
                        echo '<input type="text" class="form-control" name="' . $field['name'] . '[]">';
                        echo '</div>';
                    }
                    ?>
                    <div class="mb-3"><label class="form-label">Total:</label><input type="text" class="form-control total" readonly></div>
                </div>
            </div>

            <button type="button" id="addInvoiceDetails" class="btn btn-secondary">Add More Invoice Details</button>
            <button type="button" id="addDeposit" class="btn btn-secondary">Add Deposit</button>
            <div id="depositContainer"></div>
            <br><br>
            <input type="submit" class="btn btn-secondary" value="Generate Invoice" id="complete">
            <a href="../landing.html" class="btn btn-secondary" style="margin-top: 20px;">Back</a>
        </form>
    </div>

    <script>
        $(document).ready(function() {
            var invoiceFields = <?php echo json_encode($invoiceFields); ?>;

            // Add invoice details section when "Add More Invoice Details" button is clicked
            $("#addInvoiceDetails").click(function() {
                var invoiceDetailsHtml = '<div class="invoiceDetails">';

                invoiceFields.forEach(function(field) {
                    invoiceDetailsHtml += '<div class="mb-3">';
                    invoiceDetailsHtml += '<label for="' + field['name'] + '" class="form-label">' + field['label'] + ':</label>';
                    invoiceDetailsHtml += '<input type="text" class="form-control" name="' + field['name'] + '[]">';
                    invoiceDetailsHtml += '</div>';
                });

                invoiceDetailsHtml += '<div class="mb-3"><label class="form-label">Total:</label><input type="text" class="form-control total" readonly></div>';
                invoiceDetailsHtml += '<button type="button" class="btn btn-secondary removeInvoiceDetails">Remove</button>';
                invoiceDetailsHtml += '</div>';

                $("#invoiceDetailsContainer").append(invoiceDetailsHtml);
            });

            // Remove invoice details section
            $(document).on('click', '.removeInvoiceDetails', function() {
                $(this).closest('.invoiceDetails').remove();
            });

            // Calculate total
            $(document).on('input', '.invoiceDetails input', function() {
                var container = $(this).closest('.invoiceDetails');
                var quantity = parseFloat(container.find('input[name="quantity[]"]').val()) || 0;
                var unitPrice = parseFloat(container.find('input[name="unitPrice[]"]').val()) || 0;
                container.find('.total').val((quantity * unitPrice).toFixed(2));
            });

            // Add deposit field when "Add Deposit" button is clicked
            $("#addDeposit").click(function() {
                var depositHtml = '<div class="mb-3" id="depositField">';
                depositHtml += '<label for="deposit" class="form-label">Deposit:</label>';
                depositHtml += '<input type="text" class="form-control" name="deposit" id="deposit">';
                depositHtml += '<button type="button" class="btn btn-danger removeDeposit">Remove</button>';
                depositHtml += '</div>';

                $("#depositContainer").append(depositHtml);
                $(this).prop('disabled', true); // Disable the button to prevent multiple deposit fields
            });

            // Remove deposit field
            $(document).on('click', '.removeDeposit', function() {
                $("#depositField").remove();
                $("#addDeposit").prop('disabled', false); // Enable the "Add Deposit" button again
            });
        });
    </script>
</body>

</html>