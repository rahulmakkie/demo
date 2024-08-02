<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Registration Form</title>
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            background-color: #f0f2f5;
            font-family: Arial, sans-serif;
        }
        .form-container {
            background-color: #fff;
            padding: 20px 40px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
        }
        .form-container h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #333;
        }
        .form-container label {
            display: block;
            margin-bottom: 8px;
            color: #555;
        }
        .form-container input[type="text"],
        .form-container input[type="email"],
        .form-container input[type="password"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }
        .form-container input[type="submit"] {
            width: 100%;
            padding: 10px;
            background-color: #007bff;
            border: none;
            border-radius: 4px;
            color: #fff;
            font-size: 16px;
            cursor: pointer;
        }
        .form-container input[type="submit"]:hover {
            background-color: #0056b3;
        }
        .form-container ul {
            list-style-type: none;
            padding: 0;
            color: red;
        }
        .form-container ul li {
            margin-bottom: 5px;
        }
    </style>
</head>
<body>
    <div class="form-container">
        <h2>Registration Form</h2>

        <?php
// Enable error reporting for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $errors = [];
    $firstName = htmlspecialchars(trim($_POST["first_name"]));
    $lastName = htmlspecialchars(trim($_POST["last_name"]));
    $email = htmlspecialchars(trim($_POST["email"]));
    $phone = htmlspecialchars(trim($_POST["phone"]));
    $password = htmlspecialchars(trim($_POST["password"]));
    $confirmPassword = htmlspecialchars(trim($_POST["confirm_password"]));
    $companyName = htmlspecialchars(trim($_POST["company_name"]));
    $address1 = htmlspecialchars(trim($_POST["address_1"]));
    $address2 = htmlspecialchars(trim($_POST["address_2"]));
    $landmark = htmlspecialchars(trim($_POST["landmark"]));
    $state = htmlspecialchars(trim($_POST["state"]));
    $city = htmlspecialchars(trim($_POST["city"]));
    $country = htmlspecialchars(trim($_POST["country"]));

    // Display received data for debugging
    // echo "<pre>";
    // echo "Received Data:\n";
    // print_r($_POST);
    // echo "</pre>";

    // Validation
    if (empty($firstName) || strlen($firstName) > 255) {
        $errors[] = "First Name is required and must be less than 255 characters.";
    }
    if (empty($lastName) || strlen($lastName) > 255) {
        $errors[] = "Last Name is required and must be less than 255 characters.";
    }
    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL) || strlen($email) > 255) {
        $errors[] = "A valid Email is required and must be less than 255 characters.";
    }
    if (empty($phone) || !preg_match('/^[0-9]{10}$/', $phone)) {
        $errors[] = "Phone is required and must be numeric with 11 digits.";
    }
    if (empty($password) || strlen($password) < 8) {
        $errors[] = "Password is required and must be at least 8 characters long.";
    }
    if ($password !== $confirmPassword) {
        $errors[] = "Password and Confirm Password must match.";
    }
    if (empty($companyName) || strlen($companyName) > 255) {
        $errors[] = "Company Name is required and must be less than 255 characters.";
    }
    if (empty($address1) || strlen($address1) > 255) {
        $errors[] = "Address 1 is required and must be less than 255 characters.";
    }
    if (empty($address2) || strlen($address2) > 255) {
        $errors[] = "Address 2 is required and must be less than 255 characters.";
    }
    if (empty($landmark) || strlen($landmark) > 255) {
        $errors[] = "Landmark is required and must be less than 255 characters.";
    }
    if (empty($state) || strlen($state) > 255) {
        $errors[] = "State is required and must be less than 255 characters.";
    }
    if (empty($city) || strlen($city) > 255) {
        $errors[] = "City is required and must be less than 255 characters.";
    }
    if (empty($country) || strlen($country) > 255) {
        $errors[] = "Country is required and must be less than 255 characters.";
    }

    // Display errors
    if (!empty($errors)) {
        echo "<ul>";
        foreach ($errors as $error) {
            echo "<li>$error</li>";
        }
        echo "</ul>";
    } else {
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

        // Save the data to the database
        $conn = new mysqli('localhost', 'root', '', 'registration_db');
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Check if email or phone already exists
        $emailCheck = $conn->query("SELECT id FROM users WHERE email = '" . $conn->real_escape_string($email) . "'");
        $phoneCheck = $conn->query("SELECT id FROM users WHERE phone = '" . $conn->real_escape_string($phone) . "'");

        if ($emailCheck->num_rows > 0) {
            $errors[] = "Email is already in use.";
        }
        if ($phoneCheck->num_rows > 0) {
            $errors[] = "Phone is already in use.";
        }

        // Display errors if any
        if (!empty($errors)) {
            echo "<ul>";
            foreach ($errors as $error) {
                echo "<li>$error</li>";
            }
            echo "</ul>";
        } else {
            $sql = "INSERT INTO users (first_name, last_name, email, phone, password, company_name, address_1, address_2, landmark, state, city, country) VALUES (
                '" . $conn->real_escape_string($firstName) . "',
                '" . $conn->real_escape_string($lastName) . "',
                '" . $conn->real_escape_string($email) . "',
                '" . $conn->real_escape_string($phone) . "',
                '" . $conn->real_escape_string($hashedPassword) . "',
                '" . $conn->real_escape_string($companyName) . "',
                '" . $conn->real_escape_string($address1) . "',
                '" . $conn->real_escape_string($address2) . "',
                '" . $conn->real_escape_string($landmark) . "',
                '" . $conn->real_escape_string($state) . "',
                '" . $conn->real_escape_string($city) . "',
                '" . $conn->real_escape_string($country) . "'
            )";

            // Debugging SQL Query
            echo "<p>SQL Query: $sql</p>";

            if ($conn->query($sql) === TRUE) {
                echo "New record created successfully";
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }
        }

        $conn->close();
    }
}
?>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <label for="first_name">First Name:</label>
            <input type="text" id="first_name" name="first_name" maxlength="255" placeholder="Enter your first name" required>

            <label for="last_name">Last Name:</label>
            <input type="text" id="last_name" name="last_name" maxlength="255" placeholder="Enter your last name" required>

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" maxlength="255" placeholder="Enter your email" required>

            <label for="phone">Phone:</label>
            <input type="text" id="phone" name="phone" maxlength="11" placeholder="Enter your phone number" required>

            <label for="password">Password:</label>
            <input type="password" id="password" name="password" minlength="8" placeholder="Enter your password" required>

            <label for="confirm_password">Confirm Password:</label>
            <input type="password" id="confirm_password" name="confirm_password" minlength="8" placeholder="Confirm your password" required>

            <label for="company_name">Company Name:</label>
            <input type="text" id="company_name" name="company_name" maxlength="255" placeholder="Enter your company name" required>

            <label for="address_1">Address 1:</label>
            <input type="text" id="address_1" name="address_1" maxlength="255" placeholder="Enter your address" required>

            <label for="address_2">Address 2:</label>
            <input type="text" id="address_2" name="address_2" maxlength="255" placeholder="Enter your address" required>

            <label for="landmark">Landmark:</label>
            <input type="text" id="landmark" name="landmark" maxlength="255" placeholder="Enter landmark" required>

            <label for="state">State:</label>
            <input type="text" id="state" name="state" maxlength="255" placeholder="Enter your state" required>

            <label for="city">City:</label>
            <input type="text" id="city" name="city" maxlength="255" placeholder="Enter your city" required>

            <label for="country">Country:</label>
            <input type="text" id="country" name="country" maxlength="255" placeholder="Enter your country" required>

            <input type="submit" value="Register">
        </form>
    </div>
</body>
</html>