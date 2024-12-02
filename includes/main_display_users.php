<div class="container mt-3">
    <h2>My Products</h2>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Description</th>
                <th>Price</th>
                <th>Stock</th>
                <th>Created At</th>
                <th>Updated At</th>
            </tr>
        </thead>
        <tbody>
            <?php
            try {
                $merchantId = $_SESSION['user_id'];
                $sql = "SELECT * FROM `products` WHERE `merchant_id` = :merchant_id";
                $stmt = $conn->prepare($sql);
                $stmt->bindParam(':merchant_id', $merchantId, PDO::PARAM_INT);
                $stmt->execute();
                $products = $stmt->fetchAll(PDO::FETCH_ASSOC);

                foreach ($products as $product) {
                    echo "<tr>
                        <td>{$product['id']}</td>
                        <td>{$product['name']}</td>
                        <td>{$product['description']}</td>
                        <td>{$product['price']}</td>
                        <td>{$product['stock']}</td>
                        <td>{$product['created_at']}</td>
                        <td>{$product['updated_at']}</td>
                    </tr>";
                }
            } catch (PDOException $e) {
                echo "<p>Error fetching products: " . $e->getMessage() . "</p>";
            }
            ?>
        </tbody>
    </table>
</div>
