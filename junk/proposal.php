<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve the form data
    $clientName = $_POST['clientName'];
    $introParagraph = $_POST['introParagraph'];
    $scopeOfWork = $_POST['scopeOfWork'];
    $timeline = $_POST['timeline'];
    $totalCost = $_POST['totalCost'];
    $downPayment = $_POST['downPayment'];

    // Database configuration
    $db_host = "localhost"; // Replace with your database host
    $db_username = "root"; // Replace with your database username
    $db_password = ""; // Replace with your database password
    $db_name = "proposal_db"; // Replace with your database name

    // Connect to the database
    $conn = new mysqli($db_host, $db_username, $db_password, $db_name);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Insert the proposal data into the database
    $sql = "INSERT INTO proposals (client_name, intro_paragraph, scope_of_work, timeline, total_cost, down_payment)
            VALUES ('$clientName', '$introParagraph', '$scopeOfWork', '$timeline', '$totalCost', '$downPayment')";

    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Proposal Generated Successfully!\\nThe proposal data has been saved in the database.');</script>";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    // Close the database connection
    $conn->close();
} else {
    // If the form is not submitted, redirect to the form page
    header("Location: index.php");
    exit;
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Generated Proposal</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .logo img {
            border-radius: 50%;
            max-width: 100px;
            max-height: 100px;
        }

        .proposal-content h2 {
            margin-top: 20px;
            border-bottom: 1px solid #ccc;
            padding-bottom: 5px;
        }

        .btn-back {
            margin-top: 20px;
            text-align: center;
        }

        @media print {
            .no-print {
                display: none;
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <div class="company-info">
                <h2>B&M Flooring Installation</h2>
                <p>
                    208 Stanhope Circle<br>
                    Naples, FL 34104<br>
                    Phone: +1(239)789-2973<br>
                    Email: BMfloors525@gmail.com
                </p>
            </div>
            <div class="logo">
                <img src="Belize_Mexico.png" alt="B&M Flooring Installation">
            </div>
        </div>
        <div class="proposal-header">
            <h1>Proposal for <?php echo htmlspecialchars($_POST['clientName']); ?></h1>
        </div>
        <div class="proposal-content">
            <h2>Introduction</h2>
            <p>
                <?php echo nl2br(htmlspecialchars($_POST['introParagraph'])); ?>
            </p>
            <h2>Scope of Work</h2>
            <p>
                <?php echo nl2br(htmlspecialchars($_POST['scopeOfWork'])); ?>
            </p>
            <h2>Timeline</h2>
            <p>
                <?php echo htmlspecialchars($_POST['timeline']); ?>
            </p>
            <h2>Cost</h2>
            <p>
                The total cost of the project is $<?php echo htmlspecialchars($_POST['totalCost']); ?>. This includes all services, materials, and any additional
                expenses required to complete the project. Payment terms and methods will be discussed and agreed upon
                during the contract signing.
            </p>
            <h2>Down Payment</h2>
            <p>
                A down payment of $<?php echo htmlspecialchars($_POST['downPayment']); ?> is required upon acceptance of this proposal. This will secure
                our services and initiate the project. The remaining balance will be due upon project completion.
            </p>
        </div>
        <div class="proposal-footer">
            <p>If you have any questions or require further information, please don't hesitate to contact us at
                BMfloors525@gmail.com or +1(239)789-2973. We look forward to the opportunity to work with you on this project.</p>
        </div>
        <div class="btn-back">
            <a href="index.php" class="btn btn-primary no-print">Back to Home</a>
            <button class="btn btn-primary no-print" onclick="window.print()">Print</button>
        </div>
    </div>
</body>

</html>
