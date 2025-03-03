<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha1/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f4f4f4;
        }

        .invoice-container {
            background-color: #fff;
            border: 2px solid #ccc;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .logo {
            text-align: right;
        }

        .logo img {
            max-width: 100px;
        }

        .header-info {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
        }

        .client-info, .invoice-info {
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .item-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
            padding: 10px;
            border-bottom: 1px solid #ccc;
        }

        .item-header {
            font-weight: bold;
        }

        .total {
            text-align: right;
            font-weight: bold;
            font-size: 20px;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="logo">
            <img src="path/to/your/logo.png" alt="Your Logo">
        </div>
        <h1 class="text-center mt-4 mb-4">Invoice</h1>
        <div class="invoice-container">
            <div class="header-info">
                <div class="client-info">
                    <h3>Client Information</h3>
                    <p>Name: <?php echo $clientName; ?></p>
                    <!-- Add more client information here -->
                </div>
                <div class="invoice-info">
                    <h3>Invoice Details</h3>
                    <p>Date: <?php echo $invoiceDate; ?></p>
                    <!-- Add more invoice details here -->
                </div>
            </div>
            <div class="item-header item-row">
                <span>Description</span>
                <span>Quantity</span>
                <span>Price</span>
                <span>Total</span>
            </div>
            <?php foreach ($items as $item): ?>
                <div class="item-row">
                    <span><?php echo $item['description']; ?></span>
                    <span><?php echo $item['quantity']; ?></span>
                    <span><?php echo $item['price']; ?></span>
                    <span><?php echo $item['total']; ?></span>
                </div>
            <?php endforeach; ?>
            <div class="total">
                Total: <?php echo $total; ?>
            </div>
        </div>
        <div class="text-center mt-3">
            <button onclick="window.history.back()" class="btn btn-warning">Go Back</button>
            <button onclick="window.print()" class="btn btn-success">Print</button>
        </div>
    </div>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha1/js/bootstrap.min.js"></script>
</body>

</html>
