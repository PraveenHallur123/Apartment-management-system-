<?php
session_start();
include 'db.php';

if (!isset($_SESSION['admin_id'])) {
    header("Location: adminLogin.php");
    exit();
}

// Fetch Apartments
$sql_apartments = "SELECT * FROM Apartment";
$apartments = $conn->query($sql_apartments);

// Handle form submission to add a new apartment
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_apartment'])) {
    $apartment_no = $_POST['apartment_no'];
    $floor_no = $_POST['floor_no'];
    $rent_amount = $_POST['rent_amount'];
    $availability_status = $_POST['availability_status'];

    // Insert the new apartment into the database
    $sql_insert = "INSERT INTO Apartment (Apartment_No, Floor_No, Rent_Amount, Availability_Status) 
                   VALUES ('$apartment_no', '$floor_no', '$rent_amount', '$availability_status')";
    if ($conn->query($sql_insert) === TRUE) {
        $message = "Apartment added successfully!";
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
    <title>Manage Apartments - Admin</title>
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

        /* New Apartment Form */
        .new-apartment-form {
            margin-top: 20px;
            background-color: #ffffff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .new-apartment-form input,
        .new-apartment-form select {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .new-apartment-form button {
            background-color: #007BFF;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .new-apartment-form button:hover {
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
    <h2>Admin Dashboard</h2>
    <a href="adminDashboard.php">Dashboard</a>
    <a href="apartments.php">Manage Apartments</a>
    <a href="tenants.php">Manage Tenants</a>
    <a href="payments.php">Manage Payments</a>
    <a href="maintenance.php">Manage Maintenance Requests</a>
    <a href="logout.php" class="btn">Logout</a>
</div>

<!-- Main Content -->
<div class="content">
    <h2>Manage Apartments</h2>
    
    
    <!-- Display success or error message -->
    <?php if (isset($message)) { echo "<p style='color:green;'>$message</p>"; } ?>

    <!-- Button to show the form for adding a new apartment -->
    <button class="btn" onclick="document.getElementById('newApartmentForm').style.display='block'">Add New Apartment</button>

    <!-- New Apartment Form -->
    <div id="newApartmentForm" class="new-apartment-form" style="display:none;">
        <h3>Add New Apartment</h3>
        <form method="POST" action="">
            <label for="apartment_no">Apartment Number:</label>
            <input type="text" id="apartment_no" name="apartment_no" required>

            <label for="floor_no">Floor Number:</label>
            <input type="text" id="floor_no" name="floor_no" required>

            <label for="rent_amount">Rent Amount:</label>
            <input type="text" id="rent_amount" name="rent_amount" required>

            <label for="availability_status">Availability Status:</label>
            <select id="availability_status" name="availability_status" required>
                <option value="Available">Available</option>
                <option value="Occupied">Occupied</option>
            </select>

            <button type="submit" name="add_apartment">Add Apartment</button>
        </form>
    </div>

    <!-- Apartments Table -->
    <table>
        <thead>
            <tr>
                <th>Apartment No</th>
                <th>Floor No</th>
                <th>Rent Amount</th>
                <th>Availability</th>
                <th>Details</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($apartment = $apartments->fetch_assoc()): ?>
            <tr>
                <td><?php echo $apartment['Apartment_No']; ?></td>
                <td><?php echo $apartment['Floor_No']; ?></td>
                <td><?php echo $apartment['Rent_Amount']; ?></td>
                <td><?php echo $apartment['Availability_Status']; ?></td>
                <td><a href="viewApartment.php?apartment_no=<?php echo $apartment['Apartment_No']; ?>" class="details-link">View Details</a></td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>

</body>
</html>
