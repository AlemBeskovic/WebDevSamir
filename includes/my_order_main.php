

<?php
include './includes/conn.php';

// Ensure the user is logged in and is a customer
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'customer') {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id']; // Retrieve the logged-in user's ID
$orders = [];
$message = "";

// Fetch all orders placed by the current user
try {
    $stmt = $conn->prepare("SELECT 
                                r.product_id, 
                                r.quantity_sold, 
                                r.total_price, 
                                r.customer_name, 
                                r.customer_address, 
                                r.customer_city, 
                                r.customer_state, 
                                r.customer_zip_code, 
                                r.created_at, 
                                p.name AS product_name
                            FROM reports r
                            JOIN products p ON r.product_id = p.id
                            WHERE r.customer_id = :user_id
                            ORDER BY r.created_at DESC");
    $stmt->execute([':user_id' => $user_id]);
    $orders = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    $message = "Error fetching orders: " . $e->getMessage();
}

// Group orders by order time for display
$groupedOrders = [];
foreach ($orders as $order) {
    $groupedOrders[$order['created_at']][] = $order;
}
?>

<div class="container mt-5">
    <h2 class="text-center">My Orders</h2>

    <?php if (!empty($message)): ?>
        <div class="alert alert-danger"><?php echo htmlspecialchars($message); ?></div>
    <?php endif; ?>

    <?php if (!empty($groupedOrders)): ?>
        <?php foreach ($groupedOrders as $created_at => $orders): ?>
            <div class="mb-4">
                <h4 class="text-center bg-light p-2 border">Order Date: <?php echo htmlspecialchars(date('Y-m-d H:i:s', strtotime($created_at))); ?></h4>
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Product Name</th>
                            <th>Quantity</th>
                            <th>Total Price</th>
                            <th>Delivery Address</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($orders as $order): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($order['product_name']); ?></td>
                                <td><?php echo htmlspecialchars($order['quantity_sold']); ?></td>
                                <td>$<?php echo number_format($order['total_price'], 2); ?></td>
                                <td>
                                    <?php echo htmlspecialchars($order['customer_address'] . ', ' . $order['customer_city'] . ', ' . $order['customer_state'] . ' ' . $order['customer_zip_code']); ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <p>No orders found.</p>
    <?php endif; ?>
</div>
