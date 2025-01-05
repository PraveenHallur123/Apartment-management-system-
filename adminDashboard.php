<?php
session_start();
include 'db.php';

if (!isset($_SESSION['admin_id'])) {
    header("Location: adminLogin.php");
    exit();
}

$admin_id = $_SESSION['admin_id'];
$admin_name = "Admin User"; // Ideally, you fetch the admin name from the DB

// Count apartments
$sql_apartments = "SELECT COUNT(*) AS total_apartments FROM Apartment";
$result_apartments = $conn->query($sql_apartments);
$apartments_count = $result_apartments->fetch_assoc()['total_apartments'];

// Count tenants
$sql_tenants = "SELECT COUNT(*) AS total_tenants FROM Tenant";
$result_tenants = $conn->query($sql_tenants);
$tenants_count = $result_tenants->fetch_assoc()['total_tenants'];

// Count payments
$sql_payments = "SELECT COUNT(*) AS total_payments FROM Payment";
$result_payments = $conn->query($sql_payments);
$payments_count = $result_payments->fetch_assoc()['total_payments'];

// Count maintenance requests
$sql_maintenance = "SELECT COUNT(*) AS total_requests FROM Maintenance";
$result_maintenance = $conn->query($sql_maintenance);
$maintenance_count = $result_maintenance->fetch_assoc()['total_requests'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Apartment Management</title>
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

        /* Header Styling */
        header {
            background-color: #007BFF;
            color: white;
            padding: 20px;
            text-align: center;
        }

        header h1 {
            margin: 0;
        }

        /* Sidebar */
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

        .sidebar h3 {
            color: white;
            font-size: 20px;
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

        /* Dashboard Box Styling */
        .dashboard-boxes {
            display: flex;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 20px;
            margin-top: 30px;
        }

        .dashboard-box {
            width: 22%;
            background-color: #ffffff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            text-align: center;
            font-size: 24px;
            color: #007BFF;
        }

        .dashboard-box h3 {
            font-size: 18px;
            color: #333;
            margin-bottom: 15px;
        }

        .dashboard-box p {
            font-size: 36px;
            margin: 0;
        }

        .dashboard-box a {
            display: inline-block;
            margin-top: 15px;
            padding: 8px 15px;
            background-color: #007BFF;
            color: white;
            text-decoration: none;
            border-radius: 5px;
        }

        .dashboard-box a:hover {
            background-color: #0056b3;
        }

        /* Responsive Layout */
        @media (max-width: 768px) {
            .dashboard-box {
                width: 48%;
            }
        }

        @media (max-width: 480px) {
            .dashboard-box {
                width: 100%;
            }
        }
    </style>
</head>
<body>

<header>
    <h1>Welcome, Admin</h1>
</header>

<div class="sidebar">
    <h3>Admin Dashboard</h3>
    <a href="apartments.php">Manage Apartments</a>
    <a href="tenants.php">Manage Tenants</a>
    <a href="payments.php">Manage Payments</a>
    <a href="maintenance.php">Manage Maintenance Requests</a>
    <a href="logout.php" class="btn">Logout</a>
</div>

<div class="content">
    <h2>Admin Dashboard</h2>
    <p>Welcome to the Admin Dashboard. Here you can see a quick overview of the management sections.</p>

    <!-- Dashboard Overview Boxes -->
    <div class="dashboard-boxes">
        <div class="dashboard-box">
            <h3>Total Apartments</h3>
            <p><?php echo $apartments_count; ?></p>
            <a href="apartments.php">Manage Apartments</a>
        </div>

        <div class="dashboard-box">
            <h3>Total Tenants</h3>
            <p><?php echo $tenants_count; ?></p>
            <a href="tenants.php">Manage Tenants</a>
        </div>

        <div class="dashboard-box">
            <h3>Total Payments</h3>
            <p><?php echo $payments_count; ?></p>
            <a href="payments.php">Manage Payments</a>
        </div>

        <div class="dashboard-box">
            <h3>Total Maintenance Requests</h3>
            <p><?php echo $maintenance_count; ?></p>
            <a href="maintenance.php">Manage Maintenance</a>
        </div>
    </div>
</div>

</body>
</html>
