<?php

if ($_SESSION['user_type'] !== 'merchant') {
    echo "Access denied. This page is only for merchants.";
    exit();
}

$message = "";
include './includes/conn.php';

// Handle Add Product form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action']) && $_POST['action'] === 'add') {
    $name = trim($_POST['name']);
    $description = trim($_POST['description']);
    $price = floatval($_POST['price']);
    $stock = intval($_POST['stock']);
    $merchant_id = $_SESSION['user_id']; // Use logged-in merchant's ID

    try {
        $sql = "INSERT INTO products (merchant_id, name, description, price, stock) VALUES (:merchant_id, :name, :description, :price, :stock)";
        $stmt = $conn->prepare($sql);
        $stmt->execute([
            ':merchant_id' => $merchant_id,
            ':name' => $name,
            ':description' => $description,
            ':price' => $price,
            ':stock' => $stock
        ]);
        $message = "Product added successfully.";
    } catch (PDOException $e) {
        $message = "Error adding product: " . $e->getMessage();
    }
}

// Handle Delete Product action
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action']) && $_POST['action'] === 'delete') {
    $product_id = intval($_POST['product_id']);
    try {
        $sql = "DELETE FROM products WHERE id = :product_id AND merchant_id = :merchant_id";
        $stmt = $conn->prepare($sql);
        $stmt->execute([
            ':product_id' => $product_id,
            ':merchant_id' => $_SESSION['user_id']
        ]);
        $message = "Product deleted successfully.";
    } catch (PDOException $e) {
        $message = "Error deleting product: " . $e->getMessage();
    }
}

// Handle Update Product action
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action']) && $_POST['action'] === 'update') {
    $product_id = intval($_POST['product_id']);
    $name = trim($_POST['name']);
    $description = trim($_POST['description']);
    $price = floatval($_POST['price']);
    $stock = intval($_POST['stock']);

    try {
        $sql = "UPDATE products SET name = :name, description = :description, price = :price, stock = :stock WHERE id = :product_id AND merchant_id = :merchant_id";
        $stmt = $conn->prepare($sql);
        $stmt->execute([
            ':name' => $name,
            ':description' => $description,
            ':price' => $price,
            ':stock' => $stock,
            ':product_id' => $product_id,
            ':merchant_id' => $_SESSION['user_id']
        ]);
        $message = "Product updated successfully.";
    } catch (PDOException $e) {
        $message = "Error updating product: " . $e->getMessage();
    }
}

// Fetch all products for the logged-in merchant
$products = [];
try {
    $sql = "SELECT * FROM products WHERE merchant_id = :merchant_id";
    $stmt = $conn->prepare($sql);
    $stmt->execute([':merchant_id' => $_SESSION['user_id']]);
    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    $message = "Error fetching products: " . $e->getMessage();
}
?>

<div class="container mt-5">
    <h2 class="text-center">Manage Products</h2>

    <?php if (!empty($message)): ?>
        <div class="alert alert-info"><?php echo htmlspecialchars($message); ?></div>
    <?php endif; ?>

    <form method="POST" class="mb-5">
        <input type="hidden" name="action" value="add">
        <h3>Add Product</h3>
        <div class="mb-3">
            <label for="name" class="form-label">Product Name</label>
            <input type="text" class="form-control" id="name" name="name" required>
        </div>
        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea class="form-control" id="description" name="description" rows="3" required></textarea>
        </div>
        <div class="mb-3">
            <label for="price" class="form-label">Price</label>
            <input type="number" class="form-control" id="price" name="price" step="0.01" required>
        </div>
        <div class="mb-3">
            <label for="stock" class="form-label">Stock</label>
            <input type="number" class="form-control" id="stock" name="stock" required>
        </div>
        <button type="submit" class="btn btn-primary">Add Product</button>
    </form>

    <h3>Product List</h3>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Description</th>
                <th>Price</th>
                <th>Stock</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($products)): ?>
                <?php foreach ($products as $product): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($product['id']); ?></td>
                        <td><?php echo htmlspecialchars($product['name']); ?></td>
                        <td><?php echo htmlspecialchars($product['description']); ?></td>
                        <td><?php echo htmlspecialchars($product['price']); ?></td>
                        <td><?php echo htmlspecialchars($product['stock']); ?></td>
                        <td>
                            <form method="POST" class="d-inline">
                                <input type="hidden" name="action" value="update">
                                <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">
                                <input type="text" name="name" value="<?php echo htmlspecialchars($product['name']); ?>" required>
                                <input type="text" name="description" value="<?php echo htmlspecialchars($product['description']); ?>" required>
                                <input type="number" name="price" value="<?php echo $product['price']; ?>" step="0.01" required>
                                <input type="number" name="stock" value="<?php echo $product['stock']; ?>" required>
                                <button type="submit" class="btn btn-warning btn-sm">Update</button>
                            </form>
                            <form method="POST" class="d-inline">
                                <input type="hidden" name="action" value="delete">
                                <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">
                                <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="6">No products found.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>
