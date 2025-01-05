<?php
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $contact_info = $_POST['contact_info'];
    $lease_start = $_POST['lease_start'];
    $lease_end = $_POST['lease_end'];
    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql = "INSERT INTO Tenant (Name, Contact_Info, Lease_Start_Date, Lease_End_Date, Login_Username, Login_Password)
            VALUES ('$name', '$contact_info', '$lease_start', '$lease_end', '$username', '$password')";
    
    if ($conn->query($sql) === TRUE) {
        echo "<div class='success-message'>Registration successful!</div>";
    } else {
        echo "<div class='error-message'>Error: " . $conn->error . "</div>";
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tenant Registration</title>
    <style>
        /* Global Reset */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        /* Body and Global Styles */
        body {
            font-family: 'Arial', sans-serif;
            background: linear-gradient(135deg, #56CCF2, #2F80ED); /* Blue gradient */
            color: #fff;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            text-align: center;
            overflow: hidden;
        }

        /* Form Container */
        .form-container {
            background-color: #fff;
            padding: 30px; /* Reduced padding */
            border-radius: 12px;
            box-shadow: 0 4px 30px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 450px; /* Reduced max width */
            transition: all 0.3s ease;
            position: relative;
        }

        /* Form Heading */
        .form-container h2 {
            font-size: 24px; /* Reduced font size */
            margin-bottom: 20px; /* Reduced margin */
            color: #2F80ED; /* Blue color */
            font-weight: bold;
        }

        /* Form Labels */
        label {
            font-size: 14px; /* Reduced font size */
            font-weight: bold;
            display: block;
            margin: 10px 0 6px; /* Reduced margins */
            text-align: left;
            color: #333;
        }

        /* Form Inputs */
        input[type="text"], input[type="date"], input[type="password"] {
            width: 100%;
            padding: 10px; /* Reduced padding */
            margin-bottom: 16px; /* Reduced margin */
            border: 1px solid #ddd;
            border-radius: 8px;
            font-size: 14px; /* Reduced font size */
            outline: none;
            background-color: #333; /* Dark background for input fields */
            color: #fff; /* White text in input */
            transition: border-color 0.3s ease;
        }

        /* Input Focus Effect */
        input[type="text"]:focus, input[type="date"]:focus, input[type="password"]:focus {
            border-color: #2F80ED; /* Blue border on focus */
        }

        /* Submit Button */
        button[type="submit"] {
            background-color: #2F80ED; /* Blue button */
            color: #fff;
            padding: 12px 20px; /* Reduced padding */
            border: none;
            border-radius: 8px;
            font-size: 14px; /* Reduced font size */
            cursor: pointer;
            transition: background-color 0.3s ease;
            width: 100%;
        }

        /* Button Hover Effect */
        button[type="submit"]:hover {
            background-color: #1e69c3; /* Darker blue when hovered */
        }

        /* Success/Error Messages */
        .success-message {
            color: #4CAF50; /* Green for success */
            font-size: 16px; /* Reduced font size */
            margin-top: 20px;
        }

        .error-message {
            color: #F44336; /* Red for error */
            font-size: 16px; /* Reduced font size */
            margin-top: 20px;
        }

        /* Home Button */
        .home-button {
            background-color: #2F80ED; /* Blue color */
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 8px;
            font-size: 14px;
            text-decoration: none;
            cursor: pointer;
            transition: background-color 0.3s ease;
            display: inline-block;
            margin-bottom: 20px;
        }

        .home-button:hover {
            background-color: #1e69c3; /* Darker blue on hover */
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .form-container {
                padding: 20px; /* Reduced padding on smaller screens */
            }

            .form-container h2 {
                font-size: 22px; /* Adjust heading font size */
            }
        }
    </style>
</head>
<body>

    <!-- Home Button -->
    <a href="index.php" class="home-button">Home</a>

    <!-- Registration Form Container -->
    <div class="form-container">
        <h2>Tenant Registration</h2>
        <form method="POST" action="register.php">
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" required><br>
            
            <label for="contact_info">Contact Info:</label>
            <input type="text" id="contact_info" name="contact_info" required><br>
            
            <label for="lease_start">Lease Start Date:</label>
            <input type="date" id="lease_start" name="lease_start" required><br>
            
            <label for="lease_end">Lease End Date:</label>
            <input type="date" id="lease_end" name="lease_end" required><br>
            
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required><br>
            
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required><br>
            
            <button type="submit">Register</button>
        </form>
    </div>

</body>
</html>
