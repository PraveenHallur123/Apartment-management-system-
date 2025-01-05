<?php
session_start();
include 'db.php';

if (!isset($_SESSION['tenant_id'])) {
    header("Location: login.php");
    exit();
}

$tenant_id = $_SESSION['tenant_id'];
$tenant_name = $_SESSION['tenant_name'];

// Get apartment details based on the apartment number passed in the query string
if (isset($_GET['apartment_no'])) {
    $apartment_no = $_GET['apartment_no'];

    // Fetch the apartment details from the database
    $sql = "SELECT * FROM Apartment WHERE Apartment_No = '$apartment_no' AND Availability_Status = 'Available'";
    $result = $conn->query($sql);
    
    if ($result->num_rows > 0) {
        $apartment = $result->fetch_assoc();
    } else {
        // If no apartment is found, redirect to the available apartments page
        header("Location: tenantDashboard.php");
        exit();
    }
} else {
    // Redirect if no apartment number is passed
    header("Location: tenantDashboard.php");
    exit();
}

// Handle the booking process when the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $lease_start_date = $_POST['Lease_Start_Date'];
    $lease_end_date = $_POST['Lease_End_Date'];

    // Update the apartment status to 'Occupied'
    $update_apartment_sql = "UPDATE Apartment SET Availability_Status = 'Occupied' WHERE Apartment_No = '$apartment_no'";
    if ($conn->query($update_apartment_sql) === TRUE) {
        // Insert tenant booking details
        $sql_booking = "INSERT INTO Tenant_Apartment_Booking (Tenant_ID, Apartment_No, Lease_Start_Date, Lease_End_Date) 
                        VALUES ('$tenant_id', '$apartment_no', '$lease_start_date', '$lease_end_date')";
        if ($conn->query($sql_booking) === TRUE) {
            echo "<script>alert('Apartment booked successfully!'); window.location.href='tenantDashboard.php';</script>";
        } else {
            echo "<script>alert('Error booking apartment: " . $conn->error . "');</script>";
        }
    } else {
        echo "<script>alert('Error updating apartment status: " . $conn->error . "');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Apartment - Apartment Management</title>
    <style>
        /* General Page Styles */
        body {
            font-family: Arial, sans-serif;
            background-color: #f9f9f9;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .container {
            width: 80%;
            max-width: 1000px;
            padding: 20px;
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
            color: #007BFF;
            margin-bottom: 20px;
        }

        h2, h3 {
            color: #333;
            margin-bottom: 20px;
        }

        /* Table Styles */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        th, td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #f4f4f4;
            color: #555;
        }

        td {
            background-color: #fff;
        }

        /* Form Styles */
        form {
            display: flex;
            flex-direction: column;
            margin-top: 20px;
        }

        label {
            margin-bottom: 6px;
            font-size: 16px;
            color: #333;
        }

        input[type="date"] {
            padding: 8px;
            font-size: 14px;
            margin-bottom: 20px;
            border: 1px solid #ddd;
            border-radius: 4px;
            outline: none;
        }

        input[type="date"]:focus {
            border-color: #007BFF;
        }

        .btn {
            padding: 10px 20px;
            background-color: #007BFF;
            color: white;
            text-decoration: none;
            text-align: center;
            border-radius: 5px;
            font-size: 16px;
            margin-top: 20px;
            display: inline-block;
            width: 100%;
            max-width: 300px;
        }

        .btn:hover {
            background-color: #0056b3;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .container {
                width: 95%;
                padding: 15px;
            }
            table, input[type="date"] {
                font-size: 14px;
            }
        }

    </style>
</head>
<body>

<div class="container">
    <h1>Book Apartment</h1>
    <p>Welcome, <?php echo $tenant_name; ?>! Below are the details of the apartment you're about to book.</p>

    <h2>Apartment Details</h2>
    <table>
        <tr>
            <th>Apartment Number</th>
            <td><?php echo $apartment['Apartment_No']; ?></td>
        </tr>
        <tr>
            <th>Floor Number</th>
            <td><?php echo $apartment['Floor_No']; ?></td>
        </tr>
        <tr>
            <th>Rent Amount</th>
            <td><?php echo $apartment['Rent_Amount']; ?></td>
        </tr>
    </table>

    <h3>Lease Information</h3>
    <form method="POST">
        <label for="Lease_Start_Date">Lease Start Date:</label>
        <input type="date" name="Lease_Start_Date" required><br>

        <label for="Lease_End_Date">Lease End Date:</label>
        <input type="date" name="Lease_End_Date" required><br><br>

        <button type="submit" class="btn">Confirm Booking</button>
    </form>

    <a href="tenantDashboard.php" class="btn" style="background-color: #FF5733;">Back to Dashboard</a>
</div>

</body>
</html>
