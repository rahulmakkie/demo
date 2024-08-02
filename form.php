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
            max-width: 500px;
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
        .form-container input[type="password"],
        .form-container input[type="number"] {
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
            $amount = htmlspecialchars(trim($_POST["amount"]));
            $currency = htmlspecialchars(trim($_POST["currency"]));

            // Validation
            if (empty($firstName) || strlen($firstName) > 25) {
                $errors[] = "First Name is required and must be less than 255 characters.";
            }
            if (empty($lastName) || strlen($lastName) > 25) {
                $errors[] = "Last Name is required and must be less than 255 characters.";
            }
            if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL) || strlen($email) > 100) {
                $errors[] = "A valid Email is required and must be less than 255 characters.";
            }
            if (empty($phone) || !preg_match('/^[0-9]{10}$/', $phone)) {
                $errors[] = "Phone is required and must be numeric with 10 digits.";
            }
            if (empty($password) || strlen($password) < 8) {
                $errors[] = "Password is required and must be at least 8 characters long.";
            }
            if ($password !== $confirmPassword) {
                $errors[] = "Password and Confirm Password must match.";
            }
            if (empty($companyName) || strlen($companyName) > 50) {
                $errors[] = "Company Name is required and must be less than 255 characters.";
            }
            if (empty($address1) || strlen($address1) > 50) {
                $errors[] = "Address 1 is required and must be less than 255 characters.";
            }
            if (empty($address2) || strlen($address2) > 50) {
                $errors[] = "Address 2 is required and must be less than 255 characters.";
            }
            if (empty($landmark) || strlen($landmark) > 50) {
                $errors[] = "Landmark is required and must be less than 255 characters.";
            }
            if (empty($state) || strlen($state) > 50) {
                $errors[] = "State is required and must be less than 255 characters.";
            }
            if (empty($city) || strlen($city) > 50) {
                $errors[] = "City is required and must be less than 255 characters.";
            }
            if (empty($country) || strlen($country) > 50) {
                $errors[] = "Country is required and must be less than 255 characters.";
            }
            if (empty($amount) || !is_numeric($amount)) {
                $errors[] = "A valid amount is required.";
            }
            if (empty($currency) || strlen($currency) > 3) {
                $errors[] = "Currency is required and must be 3 characters long.";
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

                    if ($conn->query($sql) === TRUE) {
                        echo "New record created successfully";

                        // Proceed to payment gateway integration
                        $curl = curl_init();
                        $requestParams = array(
                            'api_key' => 'dBTfwjGNfCms',
                            'amount' => $amount, // Use the amount from the form
                            'unique_key' => '1922444158',
                            'domain' => 'payment.matrimonialmarriage.com',
                            'currency' => $currency, // Use the currency from the form
                            'cus_name' => $firstName . ' ' . $lastName,
                            'cus_number' => $phone,
                            'cus_country' => $country,
                            'cus_email' => $email,
                            'cus_city' => $city,
                            'cus_address' => $address1 . ', ' . $address2,
                            'success_url' => 'https://yourdomain.com/success.php',
                            'cancel_url' => 'https://yourdomain.com/cancel.php',
                            'callback_url' => 'https://yourdomain.com/callback.php',
                            'extra' => json_encode(array('key' => 'value'))
                        );

                        curl_setopt_array($curl, array(
                            CURLOPT_URL => 'https://payment.matrimonialmarriage.com/api/payment/create',
                            CURLOPT_RETURNTRANSFER => true,
                            CURLOPT_ENCODING => '',
                            CURLOPT_MAXREDIRS => 10,
                            CURLOPT_TIMEOUT => 0,
                            CURLOPT_FOLLOWLOCATION => true,
                            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                            CURLOPT_CUSTOMREQUEST => 'POST',
                            CURLOPT_POSTFIELDS => http_build_query($requestParams),
                            CURLOPT_HTTPHEADER => array(
                                'Content-Type: application/x-www-form-urlencoded',
                            ),
                        ));

                        $response = curl_exec($curl);
                        if ($response === false) {
                            echo 'cURL error: ' . curl_error($curl);
                        } else {
                            echo 'Payment response: ' . htmlentities($response);
                        }

                        curl_close($curl);
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
            <input type="text" id="first_name" name="first_name" maxlength="25" placeholder="Enter your first name" required>

            <label for="last_name">Last Name:</label>
            <input type="text" id="last_name" name="last_name" maxlength="25" placeholder="Enter your last name" required>

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" maxlength="100" placeholder="Enter your email" required>

            <label for="phone">Phone:</label>
            <input type="text" id="phone" name="phone" maxlength="10" placeholder="Enter your phone number" required>

            <label for="password">Password:</label>
            <input type="password" id="password" name="password" minlength="8" placeholder="Enter your password" required>

            <label for="confirm_password">Confirm Password:</label>
            <input type="password" id="confirm_password" name="confirm_password" minlength="8" placeholder="Confirm your password" required>

            <label for="company_name">Company Name:</label>
            <input type="text" id="company_name" name="company_name" maxlength="50" placeholder="Enter your company name" required>

            <label for="address_1">Address 1:</label>
            <input type="text" id="address_1" name="address_1" maxlength="50" placeholder="Enter your address" required>

            <label for="address_2">Address 2:</label>
            <input type="text" id="address_2" name="address_2" maxlength="50" placeholder="Enter your address" required>

            <label for="landmark">Landmark:</label>
            <input type="text" id="landmark" name="landmark" maxlength="50" placeholder="Enter landmark" required>

            <label for="state">State:</label>
            <input type="text" id="state" name="state" maxlength="50" placeholder="Enter your state" required>

            <label for="city">City:</label>
            <input type="text" id="city" name="city" maxlength="50" placeholder="Enter your city" required>

            <label for="country">Country:</label>
            <input type="text" id="country" name="country" maxlength="50" placeholder="Enter your country" required>

            <label for="amount">Amount:</label>
            <input type="number" id="amount" name="amount" step="0.01" placeholder="Enter the amount" required>

            <label for="currency">Currency:</label>
            <input type="text" id="currency" name="currency" maxlength="3" placeholder="Enter currency code" required>

            <input type="submit" value="Register">
        </form>
    </div>
</body>
</html>
