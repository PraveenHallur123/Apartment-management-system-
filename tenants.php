<?php
session_start();
include 'db.php';

if (!isset($_SESSION['admin_id'])) {
    header("Location: adminLogin.php");
    exit();
}

// Fetch Tenants
$sql_tenants = "SELECT * FROM Tenant";
$tenants = $conn->query($sql_tenants);

// Handle form submission for adding a new tenant
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_tenant'])) {
    $name = $_POST['name'];
    $contact_info = $_POST['contact_info'];
    $lease_start = $_POST['lease_start'];
    $lease_end = $_POST['lease_end'];

    // Insert new tenant into the database
    $sql_insert = "INSERT INTO Tenant (Name, Contact_Info, Lease_Start_Date, Lease_End_Date) 
                   VALUES ('$name', '$contact_info', '$lease_start', '$lease_end')";
    if ($conn->query($sql_insert) === TRUE) {
        $message = "Tenant added successfully!";
    } else {
        $message = "Error: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Tenants - Admin</title>
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

        /* New Tenant Form */
        .new-tenant-form {
            margin-top: 20px;
            background-color: #ffffff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .new-tenant-form input {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .new-tenant-form button {
            background-color: #007BFF;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .new-tenant-form button:hover {
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

<!-- Sidebar and Header are already defined in adminDashboard.php -->
 <!-- Sidebar -->
<div class="sidebar">
    <h2>Admin Dashboard</h2>
    <a href="adminDashboard.php">Dashboard</a>
    <a href="apartments.php">Manage Apartments</a>
    <a href="tenants.php">Manage Tenants</a>
    <a href="payments.php">Manage Payments</a>
    <a href="maintenance.php">Manage Maintenance Requests</
    <a href="logout.php" class="btn">Logout</a>
</div>

<div class="content">
    <h2>Manage Tenants</h2>

    <!-- Display success or error message -->
    <?php if (isset($message)) { echo "<p style='color:green;'>$message</p>"; } ?>

    <!-- Button to show the form for adding a new tenant -->
    <button class="btn" onclick="document.getElementById('newTenantForm').style.display='block'">Add New Tenant</button>

    <!-- New Tenant Form -->
    <div id="newTenantForm" class="new-tenant-form" style="display:none;">
        <h3>Add New Tenant</h3>
        <form method="POST" action="">
            <label for="name">Tenant Name:</label>
            <input type="text" id="name" name="name" required>

            <label for="contact_info">Contact Info:</label>
            <input type="text" id="contact_info" name="contact_info" required>

            <label for="lease_start">Lease Start Date:</label>
            <input type="date" id="lease_start" name="lease_start" required>

            <label for="lease_end">Lease End Date:</label>
            <input type="date" id="lease_end" name="lease_end" required>

            <button type="submit" name="add_tenant">Add Tenant</button>
        </form>
    </div>

    <!-- Tenants Table -->
    <table>
        <thead>
            <tr>
                <th>Tenant Name</th>
                <th>Contact Info</th>
                <th>Lease Start</th>
                <th>Lease End</th>
                <th>Details</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($tenant = $tenants->fetch_assoc()): ?>
            <tr>
                <td><?php echo $tenant['Name']; ?></td>
                <td><?php echo $tenant['Contact_Info']; ?></td>
                <td><?php echo $tenant['Lease_Start_Date']; ?></td>
                <td><?php echo $tenant['Lease_End_Date']; ?></td>
                <td><a href="viewTenant.php?tenant_id=<?php echo $tenant['Tenant_ID']; ?>" class="details-link">View Details</a></td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>

</body>
</html>
