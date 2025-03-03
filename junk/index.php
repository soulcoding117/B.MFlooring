<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Proposal Form</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha1/css/bootstrap.min.css">
    <style>
        .form-container {
            border: 2px solid #ccc;
            padding: 20px;
            border-radius: 10px;
        }

        .logo {
            text-align: right;
        }

        .logo img {
            max-width: 100px;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="logo">
            <img src="path/to/your/logo.png" alt="Your Logo">
        </div>
        <h1 class="text-center mt-4 mb-4">Create Proposal</h1>
        <div class="form-container">
            <form action="proposal.php" method="post">
                <div class="mb-3">
                    <label for="clientName" class="form-label">Client Name</label>
                    <input type="text" class="form-control" name="clientName" required>
                </div>
                <div class="mb-3">
                    <label for="introParagraph" class="form-label">Introduction Paragraph</label>
                    <textarea class="form-control" name="introParagraph" required></textarea>
                </div>
                <div class="mb-3">
                    <label for="scopeOfWork" class="form-label">Scope of Work</label>
                    <textarea class="form-control" name="scopeOfWork" required></textarea>
                </div>
                <div class="mb-3">
                    <label for="timeline" class="form-label">Timeline</label>
                    <input type="text" class="form-control" name="timeline" required>
                </div>
                <div class="mb-3">
                    <label for="downPayment" class="form-label">Down Payment</label>
                    <input type="number" class="form-control" name="downPayment" required>
                </div>
                <div id="items">
                    <div class="mb-3">
                        <label for="item[]" class="form-label">Item</label>
                        <input type="text" class="form-control" name="item[]" required>
                        <label for="cost[]" class="form-label">Cost</label>
                        <input type="number" class="form-control" name="cost[]" required>
                    </div>
                </div>
                <button type="button" onclick="addItem()" class="btn btn-secondary">Add Item</button>
                <button type="submit" class="btn btn-primary">Generate Proposal</button>
            </form>
        </div>
        <div class="text-center mt-3">
            <button onclick="window.history.back()" class="btn btn-warning">Go Back</button>
            <button onclick="window.print()" class="btn btn-success">Print</button>
        </div>
        <script>
            function addItem() {
                var itemDiv = document.createElement('div');
                itemDiv.className = 'mb-3';
                itemDiv.innerHTML = '<label for="item[]" class="form-label">Item</label><input type="text" class="form-control" name="item[]" required><label for="cost[]" class="form-label">Cost</label><input type="number" class="form-control" name="cost[]" required>';
                document.getElementById('items').appendChild(itemDiv);
            }
        </script>
    </div>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha1/js/bootstrap.min.js"></script>
</body>

</html>
