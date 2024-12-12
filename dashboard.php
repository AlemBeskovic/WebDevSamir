<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to MyStore</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            background-color: #f9f9f9;
        }

        .hero-section {
            background-color: #007BFF;
            color: white;
            padding: 100px 20px;
            text-align: center;
        }

        .hero-section h1 {
            font-size: 3rem;
            font-weight: bold;
            margin-bottom: 20px;
        }

        .hero-section p {
            font-size: 1.2rem;
            margin-bottom: 40px;
        }

        .features-section {
            padding: 60px 20px;
            text-align: center;
        }

        .features-section .feature {
            margin-bottom: 40px;
        }

        .features-section .feature img {
            max-width: 100%;
            height: auto;
            border-radius: 8px;
        }

        .features-section h2 {
            font-size: 2rem;
            margin-bottom: 20px;
        }

        .features-section p {
            font-size: 1rem;
        }

        .call-to-action {
            background-color: #f8f9fa;
            padding: 50px 20px;
            text-align: center;
        }

        .call-to-action h2 {
            font-size: 2.5rem;
            margin-bottom: 20px;
        }

        .call-to-action p {
            font-size: 1.2rem;
            margin-bottom: 30px;
        }

        .call-to-action .btn {
            font-size: 1.2rem;
            padding: 10px 30px;
        }

        .footer {
            background-color: #007BFF;
            color: white;
            text-align: center;
            padding: 15px;
        }
    </style>
</head>

<body>
    <!-- Include Navbar -->
    <?php include './includes/nav.php'; ?>

    <!-- Hero Section -->
    <div class="hero-section">
        <h1>Welcome to MyStore</h1>
        <p>The ultimate platform for discovering, shopping, and managing your needs.</p>
        <a href="#features" class="btn btn-light btn-lg">Explore Features</a>
    </div>

    <!-- Features Section -->
    <div id="features" class="features-section">
        <div class="container">
            <div class="row">
                <div class="col-md-6 feature">
                    <img src="shop.png" alt="Feature 1">
                    <h2>Shop with Ease</h2>
                    <p>Browse our wide range of products and find everything you need in one place.</p>
                </div>
                <div class="col-md-6 feature">
                    <img src="manage.png" alt="Feature 2">
                    <h2>Manage Effortlessly</h2>
                    <p>Keep track of your orders, wishlist, and more with our user-friendly interface.</p>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 feature">
                    <img src="secure_transactions.jpg" alt="Feature 3">
                    <h2>Secure Transactions</h2>
                    <p>Enjoy safe and reliable shopping experiences with cutting-edge security features.</p>
                </div>
                <div class="col-md-6 feature">
                    <img src="stay_connected.jpg" alt="Feature 4">
                    <h2>Stay Connected</h2>
                    <p>Receive updates on deals, promotions, and new arrivals directly on your dashboard.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Call to Action Section -->
    <div class="call-to-action">
        <h2>Join the Revolution</h2>
        <p>Experience the future of shopping and management with MyStore.</p>
        <a href="shop.php" class="btn btn-primary">Start Shopping</a>
    </div>

    <!-- Footer -->
    <div class="footer">
        <p>&copy; 2024 MyStore. All rights reserved.</p>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
