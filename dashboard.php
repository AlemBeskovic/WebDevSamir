<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <!-- Use the same Bootstrap version as the shop page -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>

<body style="font-family: Arial, sans-serif; background-color: #f9f9f9; margin: 0;">

    <!-- Include Navbar -->
    <?php include './includes/nav.php'; ?>

    <!-- Main Content -->
    <div style="padding: 20px; min-height: 100vh;">
        <h1 style="margin-bottom: 20px;">Welcome, <?php echo htmlspecialchars($_SESSION['full_name']); ?>!</h1>

        <div style="display: flex; gap: 20px; flex-wrap: wrap;">
            <!-- My Orders Section -->
            <div style="flex: 1; min-width: 300px; background-color: #fff; border-radius: 8px; box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1); padding: 20px;">
                <h5>My Orders</h5>
                <p>View and manage your recent orders.</p>
                <a href="my_orders.php" style="display: inline-block; padding: 10px 15px; background-color: #007BFF; color: #fff; text-decoration: none; border-radius: 5px; text-align: center;">View Orders</a>
            </div>

            <!-- Reports Section -->
            <div style="flex: 1; min-width: 300px; background-color: #fff; border-radius: 8px; box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1); padding: 20px;">
                <h5>Reports</h5>
                <p>View and analyze reports.</p>
                <a href="reports.php" style="display: inline-block; padding: 10px 15px; background-color: #007BFF; color: #fff; text-decoration: none; border-radius: 5px; text-align: center;">View Reports</a>
            </div>

            <!-- Manage Users Section -->
            <div style="flex: 1; min-width: 300px; background-color: #fff; border-radius: 8px; box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1); padding: 20px;">
                <h5>Manage Users</h5>
                <p>View and manage users (Admin only).</p>
                <a href="manage_users.php" style="display: inline-block; padding: 10px 15px; background-color: #007BFF; color: #fff; text-decoration: none; border-radius: 5px; text-align: center;">Manage Users</a>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer style="background-color: #007BFF; color: #fff; text-align: center; padding: 15px;">
        <p>&copy; 2024 Dashboard Management System. All rights reserved.</p>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
