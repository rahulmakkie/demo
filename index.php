<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Pricing Plans</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f7f9fc;
            margin: 0;
            padding: 0;
        }
        .pricing-container {
            display: flex;
            justify-content: center;
            flex-wrap: wrap;
            gap: 20px;
            padding: 40px;
        }
        .price-card {
            background: linear-gradient(145deg, #ffffff, #f1f1f1);
            border-radius: 12px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 300px;
            text-align: center;
            padding: 20px;
            transition: transform 0.3s, box-shadow 0.3s;
            position: relative;
            overflow: hidden;
        }
        .price-card img {
            width: 100%;
            height: 150px;
            object-fit: cover;
            border-radius: 12px 12px 0 0;
            margin-bottom: 20px;
        }
        .price-card::before {
            content: '';
            position: absolute;
            top: -10%;
            left: -10%;
            width: 120%;
            height: 120%;
            background: radial-gradient(circle at center, rgba(255, 255, 255, 0.3), rgba(255, 255, 255, 0) 70%);
            opacity: 0.5;
            z-index: 0;
        }
        .price-card h3 {
            margin: 20px 0;
            color: #333;
            font-size: 1.5em;
            z-index: 1;
            position: relative;
        }
        .price-card p {
            font-size: 2em;
            color: #007bff;
            margin: 10px 0;
            z-index: 1;
            position: relative;
        }
        .price-card button {
            background-color: #007bff;
            border: none;
            color: #fff;
            padding: 12px 24px;
            border-radius: 30px;
            cursor: pointer;
            font-size: 18px;
            font-weight: bold;
            transition: background-color 0.3s, transform 0.3s;
            position: relative;
            z-index: 1;
        }
        .price-card button:hover {
            background-color: #0056b3;
            transform: scale(1.05);
        }
        .price-card button:focus {
            outline: none;
        }
    </style>
</head>
<body>
    <div class="pricing-container">
        <div class="price-card">
            <img src="path/to/basic-plan-image.jpg" alt="Basic Plan Image">
            <h3>Basic Plan</h3>
            <p>$10.00</p>
            <button onclick="window.location.href='form.php?plan=basic&amount=10.00'">Buy Plan</button>
        </div>
        <div class="price-card">
            <img src="path/to/standard-plan-image.jpg" alt="Standard Plan Image">
            <h3>Standard Plan</h3>
            <p>$20.00</p>
            <button onclick="window.location.href='form.php?plan=standard&amount=20.00'">Buy Plan</button>
        </div>
        <div class="price-card">
            <img src="path/to/premium-plan-image.jpg" alt="Premium Plan Image">
            <h3>Premium Plan</h3>
            <p>$30.00</p>
            <button onclick="window.location.href='form.php?plan=premium&amount=30.00'">Buy Plan</button>
        </div>
    </div>
</body>
</html>
