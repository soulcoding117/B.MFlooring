<?php
// Database Connection
$servername = "localhost";
$port = "3306";
$username = "company1";
$password = "shanely31";
$dbname = "invoicedb";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die('Connection to the database failed: ' . $conn->connect_error);
}

// Insert data into the database
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $invoiceDate = $_POST['invoiceDate'];
    $clientName = $_POST['clientName'];
    $clientAddress = $_POST['clientAddress'];
    $clientCompany = $_POST['clientCompany'];
    $description = $_POST['description'];
    $quantity = $_POST['quantity'];
    $unitPrice = $_POST['unitPrice'];
    $deposit = $_POST['deposit'];

    $jsonDescription = json_encode($description);
    $jsonQuantity = json_encode($quantity);
    $jsonUnitPrice = json_encode($unitPrice);

    $sql = 'INSERT INTO invoices (invoiceDate, clientName, clientAddress, clientCompany, description, quantity, unitPrice, deposit) VALUES (?, ?, ?, ?, ?, ?, ?, ?)';
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('ssssssss', $invoiceDate, $clientName, $clientAddress, $clientCompany, $jsonDescription, $jsonQuantity, $jsonUnitPrice, $deposit);

    if ($stmt->execute()) {
        echo 'Invoice successfully generated.';
    } else {
        echo 'Error: ' . $stmt->error;
    }

    $stmt->close();
}

// Fetch the latest invoice data from the database
$sql = 'SELECT * FROM invoices ORDER BY id DESC LIMIT 1';
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $description = json_decode($row['description']);
    $quantity = json_decode($row['quantity']);
    $unitPrice = json_decode($row['unitPrice']);
    $deposit = $row['deposit'];
} else {
    echo 'No invoice data found.';
    exit();
}

$conn->close();
?>

<html>

<head>
    <title>B&M</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="../css/invoice.css">
    <style>
        .invoice {
            font-family: "Times New Roman", Times, serif;
            background-color: #f9f9f9;
            padding: 20px;
            border: 1px solid #ddd;
            margin: 20px;
        }

        .logo img {
            max-width: 150px;
        }

        .invoice-details {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
        }

        .invoice-details div {
            color: #333;
        }

        .invoice-items {
            margin-bottom: 20px;
        }

        .total {
            font-weight: bold;
            font-size: 18px;
        }

        .no-print {
            display: block;
        }

        @media print {
            .no-print {
                display: none;
            }
        }

        .text {
            text-align: center;
        }

        .signature {
            text-align: right;
            font-size: 18px;
        }

        .signature {
            text-align: right;
            font-size: 18px;
        }

        .spacer {
            height: 600px;
            /* Adjust the height as needed */
        }

        body {
            background: linear-gradient(top right, #306C00, #FFE44D);
        }
    </style>
</head>

<body>
    <div class="invoice">
        <div class="text">Invoice</div>
        <div class="logo">
            <img src="Belize_Mexico.png">
        </div>
        <div class="invoice-details">
            <div>
                <span style="font-weight: bold; color: gold;">B&M Flooring Installation</span><br>
                208 Stanhope Circle<br>
                Naples, FL 34104<br>
                Phone: +1(239)784-2973<br>
                Email: BMfloors525@gmail.com
            </div>
            <div>
                Date: <?php echo date("m/d/Y"); ?><br>
                Client: <?php echo htmlspecialchars($_POST["clientName"]); ?><br>
                Address: <?php echo htmlspecialchars($_POST["clientAddress"]); ?>
            </div>
        </div>
        <div class="invoice-items">
            <table class="table">
                <thead class="thead-dark">
                    <tr>
                        <th>Description</th>
                        <th>Quantity</th>
                        <th>Unit Price</th>
                        <th>Amount</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $description = $_POST["description"];
                    $quantity = $_POST["quantity"];
                    $unitPrice = $_POST["unitPrice"];
                    $deposit = isset($_POST["deposit"]) ? floatval($_POST["deposit"]) : 0;

                    $amount = 0;

                    for ($i = 0; $i < count($description); $i++) {
                        $subtotal = floatval($quantity[$i]) * floatval($unitPrice[$i]);
                        $amount += $subtotal;

                        echo '<tr>';
                        echo '<td>' . htmlspecialchars($description[$i]) . '</td>';
                        echo '<td>' . htmlspecialchars($quantity[$i]) . '</td>';
                        echo '<td>' . '$' . number_format(floatval($unitPrice[$i]), 2) . '</td>';
                        echo '<td>' . '$' . number_format($subtotal, 2) . '</td>';
                        echo '</tr>';
                    }
                    ?>
                </tbody>
            </table>
        </div>
        <div class="total">
            Total: <?php echo '$' . number_format($amount, 2); ?><br>
            Deposit: <?php echo '$' . number_format($deposit, 2); ?><br>
            Total Due: <?php echo '$' . number_format($amount - $deposit, 2); ?>
        </div>
        <div class="spacer"></div>
        <div class="signature">Signature:________________________________.</div>
    </div>

    <div class="no-print">
        <button class="btn btn-primary" onclick="window.print()">Print</button>
        <button class="btn btn-secondary" onclick="window.history.back()">Go Back</button>
    </div>

    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>