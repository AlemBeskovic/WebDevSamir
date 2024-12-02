<?php
include './includes/conn.php';

$orders = [];
$message = "";

// Fetch all orders from the reports table
try {
    $stmt = $conn->query("SELECT 
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
                          ORDER BY r.customer_address, r.created_at DESC");
    $orders = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    $message = "Error fetching orders: " . $e->getMessage();
}

// Group orders by address
$groupedOrders = [];
foreach ($orders as $order) {
    $addressKey = $order['customer_address'] . ', ' . $order['customer_city'] . ', ' . $order['customer_state'] . ' ' . $order['customer_zip_code'];
    $groupedOrders[$addressKey][] = $order; // Group by full address
}
?>

<div class="container mt-5">
    <h2 class="text-center">Orders</h2>

    <?php if (!empty($message)): ?>
        <div class="alert alert-danger"><?php echo htmlspecialchars($message); ?></div>
    <?php endif; ?>

    <?php if (!empty($groupedOrders)): ?>
        <?php foreach ($groupedOrders as $address => $orders): ?>
            <div class="mb-4">
                <h4 class="text-center bg-light p-2 border">Orders for Address: <?php echo htmlspecialchars($address); ?></h4>
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Product Name</th>
                            <th>Quantity</th>
                            <th>Total Price</th>
                            <th>Customer Name</th>
                            <th>Order Time</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($orders as $order): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($order['product_name']); ?></td>
                                <td><?php echo htmlspecialchars($order['quantity_sold']); ?></td>
                                <td>$<?php echo number_format($order['total_price'], 2); ?></td>
                                <td><?php echo htmlspecialchars($order['customer_name']); ?></td>
                                <td><?php echo htmlspecialchars(date('Y-m-d H:i:s', strtotime($order['created_at']))); ?></td>
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
