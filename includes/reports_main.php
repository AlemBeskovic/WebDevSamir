<?php
include './includes/conn.php';

$total_revenue = 0;
$reports = [];
$message = "";

// Fetch reports and calculate total revenue
try {
    // Fetch total revenue per product
    $stmt = $conn->query("SELECT p.name AS product_name, 
                                 SUM(r.quantity_sold) AS total_quantity_sold, 
                                 SUM(r.total_price) AS product_total_revenue
                          FROM reports r 
                          JOIN products p ON r.product_id = p.id
                          GROUP BY r.product_id");
    $reports = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Fetch total revenue across all products
    $stmt = $conn->query("SELECT SUM(total_price) AS total_revenue FROM reports");
    $total_revenue = $stmt->fetchColumn();
} catch (PDOException $e) {
    $message = "Error fetching reports: " . $e->getMessage();
}
?>

<div class="container mt-5">
    <h2 class="text-center">Reports</h2>

    <?php if (!empty($message)): ?>
        <div class="alert alert-danger"><?php echo htmlspecialchars($message); ?></div>
    <?php endif; ?>

    <div class="mb-3">
        <h4>Total Revenue: $<?php echo number_format($total_revenue, 2); ?></h4>
    </div>

    <table class="table table-striped">
        <thead>
            <tr>
                <th>Product Name</th>
                <th>Total Quantity Sold</th>
                <th>Total Revenue</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($reports)): ?>
                <?php foreach ($reports as $report): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($report['product_name']); ?></td>
                        <td><?php echo htmlspecialchars($report['total_quantity_sold']); ?></td>
                        <td>$<?php echo number_format($report['product_total_revenue'], 2); ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="3">No sales records found.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>
