<div class="container mt-3">
    <h2>Delete Product</h2>
    <div class="card">
        <div class="card-body">
            <form method="POST" action="">
                <label for="product_id">Product ID:</label>
                <input type="number" id="product_id" name="product_id" required>
                <button type="submit" class="btn btn-danger mt-2">Delete</button>
            </form>
            <?php
            if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['product_id'])) {
                $productId = intval($_POST['product_id']);
                try {
                    $sql = "DELETE FROM `products` WHERE `id` = :id";
                    $stmt = $conn->prepare($sql);
                    $stmt->bindParam(':id', $productId, PDO::PARAM_INT);
                    $stmt->execute();
                    echo "<p>Product ID $productId deleted successfully.</p>";
                } catch (PDOException $e) {
                    echo "<p>Error deleting product: " . $e->getMessage() . '</p>';
                }
            }
            ?>
        </div>
    </div>
</div>
