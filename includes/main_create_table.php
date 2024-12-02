<div class="container mt-3">
    <h2>Create a Table</h2>
    <div class="card">
        <div class="card-body">
            <?php
            // Check if $conn is defined and available
            if (isset($conn)) {
                try {
                    // Check if the table exists
                    $result = $conn->query("SHOW TABLES LIKE 'products'");
                    if ($result->rowCount() > 0) {
                        echo "Table 'products' already exists.";
                    } else {
                        // Table doesn't exist, so create it
                        $sql = "CREATE TABLE IF NOT EXISTS `products` (
                            `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
                            `merchant_id` INT(11) UNSIGNED NOT NULL,
                            `name` VARCHAR(255) NOT NULL,
                            `description` TEXT,
                            `price` DECIMAL(10, 2) NOT NULL,
                            `stock` INT(11) NOT NULL DEFAULT 0,
                            `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
                            `updated_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                            PRIMARY KEY (`id`),
                            FOREIGN KEY (`merchant_id`) REFERENCES `users`(`id`) ON DELETE CASCADE
                        )";
                        $conn->exec($sql);
                        echo "<p>Table 'products' created successfully.</p>";
                    }
                } catch (PDOException $e) {
                    echo "<p>Error creating table: " . $e->getMessage() . '</p>';
                }
            } else {
                echo "<p>Database connection not established.</p>";
            }
            ?>
        </div>
    </div>
</div>
