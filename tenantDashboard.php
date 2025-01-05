<?php 
session_start(); 
include 'db.php';  

// Check if user is logged in
if (!isset($_SESSION['tenant_id'])) { 
    header("Location: login.php"); 
    exit(); 
} 

$tenant_id = $_SESSION['tenant_id']; 
$tenant_name = $_SESSION['tenant_name']; 

$sql_apartments = "SELECT * FROM Apartment WHERE Availability_Status = 'Available'"; 
$apartments = $conn->query($sql_apartments); 
?> 

<!DOCTYPE html> 
<html lang="en"> 
<head>     
    <meta charset="UTF-8">     
    <meta name="viewport" content="width=device-width, initial-scale=1.0">     
    <title>Tenant Dashboard - Apartment Management</title>     
    <style>         
        /* General Page Styles */         
        body {             
            font-family: Arial, sans-serif;             
            background-color: #f4f4f9;             
            margin: 0;             
            padding: 0;             
            display: flex;             
            justify-content: flex-start;             
            align-items: flex-start;             
            min-height: 100vh;         
        }          
        /* Side Navigation Styles */         
        .sidenav {             
            width: 200px;             
            height: 100%;             
            background-color: #333;             
            position: fixed;             
            top: 0;             
            left: 0;             
            padding-top: 20px;             
            color: white;             
            text-align: center;             
            box-shadow: 2px 0 5px rgba(0, 0, 0, 0.1);         
        }         
        .sidenav a {             
            display: block;             
            padding: 16px;             
            text-decoration: none;             
            color: white;             
            margin: 10px 0;             
            background-color: #444;             
            border-radius: 4px;             
            transition: background-color 0.3s;         
        }         
        .sidenav a:hover {             
            background-color: #007BFF;         
        }         
        /* Main Content Area */         
        .main-content {             
            margin-left: 220px;             
            padding: 20px;             
            flex-grow: 1;         
        }         
        /* Header styles */         
        h1 {             
            text-align: center;             
            color: #007BFF;             
            margin-bottom: 20px;         
        }         
        h2 {             
            color: #333;             
            margin-bottom: 20px;         
        }         
        /* Table Styles */         
        table {             
            width: 100%;             
            border-collapse: collapse;             
            margin-top: 20px;         
        }         
        table, th, td {             
            border: 1px solid #ddd;         
        }         
        th, td {             
            padding: 12px;             
            text-align: center;         
        }         
        th {             
            background-color: #f4f4f4;             
            color: #333;         
        }         
        td {             
            background-color: #fff;         
        }         
        /* Button Styles for "Book Now" */         
        a {             
            display: inline-block;             
            padding: 8px 16px;             
            text-decoration: none;             
            color: white;             
            background-color: #007BFF;             
            border-radius: 4px;             
            transition: background-color 0.3s;         
        }         
        a:hover {             
            background-color: #0056b3;         
        }         
        /* Logout Button */         
        .logout-btn {             
            text-align: right;             
            margin-bottom: 20px;         
        }         
        .logout-btn a {             
            background-color: #FF5733;             
            color: white;             
            padding: 8px 16px;             
            text-decoration: none;             
            border-radius: 4px;             
            transition: background-color 0.3s;         
        }         
        .logout-btn a:hover {             
            background-color: #FF3B00;         
        }         
        /* Responsive Design */         
        @media (max-width: 768px) {             
            .sidenav {                 
                width: 100%;                 
                height: auto;                 
                position: relative;             
            }             
            .main-content {                 
                margin-left: 0;             
            }             
            table {                 
                font-size: 14px;             
            }             
        }     
    </style> 
</head> 
<body>     
    <!-- Side Navigation Bar -->     
    <div class="sidenav">         
        <h2><?php echo $tenant_name; ?></h2>         
        <a href="index.php">Home</a>         
        <a href="tenant_dashboard.php">Apartments</a>         
        <a href="maintenance.php">Maintenance</a>         
        <a href="payment.php">Payment</a>         
        <div class="logout-btn">             
            <a href="logout.php">Logout</a>         
        </div>     
    </div>     
    <!-- Main Content -->     
    <div class="main-content">         
        <h1>Welcome, <?php echo $tenant_name; ?></h1>         
        <h2>Available Apartments</h2>         
        <table>             
            <thead>                 
                <tr>                     
                    <th>Apartment Number</th>                     
                    <th>Floor Number</th>                     
                    <th>Rent Amount</th>                     
                    <th>Action</th>                 
                </tr>             
            </thead>             
            <tbody>                 
                <?php while ($apartment = $apartments->fetch_assoc()): ?>                 
                <tr>                     
                    <td><?php echo $apartment['Apartment_No']; ?></td>                     
                    <td><?php echo $apartment['Floor_No']; ?></td>                     
                    <td><?php echo $apartment['Rent_Amount']; ?></td>                     
                    <td>                         
                        <a href="bookApartment.php?apartment_no=<?php echo $apartment['Apartment_No']; ?>">Book Now</a>                     
                    </td>                 
                </tr>                 
                <?php endwhile; ?>             
            </tbody>         
        </table>     
    </div> 
</body> 
</html>
