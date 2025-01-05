<?php
session_start();
include 'db.php';

if (!isset($_SESSION['admin_id'])) {
    header("Location: adminLogin.php");
    exit();
}

// Fetch Payments
$sql_payments = "SELECT * FROM Payment";
$payments = $conn->query($sql_payments);

// Handle form submission for adding a new payment
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_payment'])) {
    // Collect form data and sanitize it
    $tenant_id = mysqli_real_escape_string($conn, $_POST['tenant_id']);
    $payment_amount = mysqli_real_escape_string($conn, $_POST['payment_amount']);
    $payment_date = mysqli_real_escape_string($conn, $_POST['payment_date']);
    $payment_status = mysqli_real_escape_string($conn, $_POST['payment_status']);

    // Check for required fields
    if (empty($tenant_id) || empty($payment_amount) || empty($payment_date) || empty($payment_status)) {
        $message = "All fields are required!";
    } else {
        // Insert new payment into the database
        $sql_insert = "INSERT INTO Payment (Tenant_ID, Payment_Amount, Payment_Date, Payment_Status) 
                       VALUES ('$tenant_id', '$payment_amount', '$payment_date', '$payment_status')";

        if ($conn->query($sql_insert) === TRUE) {
            $message = "Payment added successfully!";
        } else {
            $message = "Error: " . $conn->error;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Payments - Admin</title>
    <style>
        /* General Styles */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f9;
            color: #333;
        }

        h1, h2 {
            color: #333;
        }

        h1 {
            font-size: 30px;
            margin-bottom: 20px;
        }

        /* Sidebar and Navigation */
        .sidebar {
            width: 250px;
            background-color: #007BFF;
            color: white;
            padding: 20px;
            position: fixed;
            top: 0;
            left: 0;
            height: 100%;
        }

        .sidebar a {
            display: block;
            color: white;
            text-decoration: none;
            margin: 15px 0;
            font-size: 16px;
        }

        .sidebar a:hover {
            background-color: #0056b3;
            padding-left: 10px;
        }

        /* Content Area */
        .content {
            margin-left: 270px; /* Offset for sidebar */
            padding: 20px;
        }

        .content h2 {
            font-size: 28px;
            margin-bottom: 15px;
        }

        /* Table Styling */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }

        th, td {
            padding: 12px;
            text-align: left;
            border: 1px solid #ddd;
        }

        th {
            background-color: #f8f8f8;
            color: #007BFF;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        tr:hover {
            background-color: #d9e9ff;
        }

        /* Links and Buttons */
        .details-link {
            color: #007BFF;
            text-decoration: none;
            font-size: 14px;
        }

        .details-link:hover {
            text-decoration: underline;
        }

        .btn {
            background-color: #28a745;
            color: white;
            padding: 8px 15px;
            text-decoration: none;
            border-radius: 5px;
            margin: 5px;
            font-size: 16px;
        }

        .btn:hover {
            background-color: #218838;
        }

        /* New Payment Form */
        .new-payment-form {
            margin-top: 20px;
            background-color: #ffffff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .new-payment-form input, .new-payment-form select {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .new-payment-form button {
            background-color: #007BFF;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .new-payment-form button:hover {
            background-color: #0056b3;
        }

        /* Responsive Table for Smaller Screens */
        @media (max-width: 768px) {
            .content {
                margin-left: 0; /* Full-width for smaller screens */
            }

            table {
                width: 100%;
                overflow-x: auto;
                display: block;
            }
        }
    </style>
</head>
<body>

<!-- Sidebar -->
<div class="sidebar">
    <h3>Admin Dashboard</h3>
    <a href="adminDashboard.php">Dashboard</a>
    <a href="apartments.php">Manage Apartments</a>
    <a href="tenants.php">Manage Tenants</a>
    <a href="paymentManagement.php">Manage Payments</a>
    <a href="logout.php">Logout</a>
</div>

<div class="content">
    <h2>Manage Payments</h2>

    <!-- Display success or error message -->
    <?php if (isset($message)) { echo "<p style='color:red;'>$message</p>"; } ?>

    <!-- Button to show the form for adding a new payment -->
    <button class="btn" onclick="document.getElementById('newPaymentForm').style.display='block'">Add New Payment</button>

    <!-- New Payment Form -->
    <div id="newPaymentForm" class="new-payment-form" style="display:none;">
        <h3>Add New Payment</h3>
        <form method="POST" action="">
            <label for="tenant_id">Tenant ID:</label>
            <input type="number" id="tenant_id" name="tenant_id" required>

            <label for="payment_amount">Payment Amount:</label>
            <input type="number" id="payment_amount" name="payment_amount" required>

            <label for="payment_date">Payment Date:</label>
            <input type="date" id="payment_date" name="payment_date" required>

            <label for="payment_status">Payment Status:</label>
            <select id="payment_status" name="payment_status" required>
                <option value="Paid">Paid</option>
                <option value="Pending">Pending</option>
                <option value="Overdue">Overdue</option>
            </select>

            <button type="submit" name="add_payment">Add Payment</button>
        </form>
    </div>

    <!-- Payments Table -->
    <table>
        <thead>
            <tr>
                <th>Payment ID</th>
                <th>Tenant ID</th>
                <th>Payment Amount</th>
                <th>Payment Date</th>
                <th>Status</th>
                <th>Details</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($payment = $payments->fetch_assoc()): ?>
            <tr>
                <td><?php echo $payment['Payment_ID']; ?></td>
                <td><?php echo $payment['Tenant_ID']; ?></td>
                <td><?php echo $payment['Payment_Amount']; ?></td>
                <td><?php echo $payment['Payment_Date']; ?></td>
                <td><?php echo $payment['Payment_Status']; ?></td>
                <td><a href="viewPayment.php?payment_id=<?php echo $payment['Payment_ID']; ?>" class="details-link">View Details</a></td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>

</body>
</html>
