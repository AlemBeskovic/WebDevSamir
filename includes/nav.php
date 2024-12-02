

<head>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>

<nav class="p-3" id="nav">
    <ul class="nav flex-column">
        <!-- Common Section for All Users -->
        <li><a href="dashboard.php">Home <i class="fas fa-home"></i></a></li>

        <?php if ($_SESSION['user_type'] === 'customer'): ?>
            <!-- Navigation Items for Customers -->
            <li><a href="shop.php">Shop <i class="fas fa-shopping-cart"></i></a></li>
            <li><a href="my_orders.php">My Orders <i class="fas fa-box"></i></a></li>
            <li><a href="wishlist.php">Wishlist <i class="fas fa-heart"></i></a></li>
        <?php elseif ($_SESSION['user_type'] === 'merchant'): ?>
            <!-- Navigation Items for Merchants -->
            <li><a href="dashboard.php">Dashboard <i class="fas fa-chart-line"></i></a></li>
            <li><a href="products.php">Products <i class="fas fa-boxes"></i></a></li>
            <li><a href="orders.php">Orders <i class="fas fa-truck"></i></a></li>
            <li><a href="inventory.php">Inventory <i class="fas fa-warehouse"></i></a></li>
            <li><a href="reports.php">Reports <i class="fas fa-chart-bar"></i></a></li>
        <?php endif; ?>
    </ul>
</nav>
