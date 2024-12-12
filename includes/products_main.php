<?php

if ($_SESSION['user_type'] !== 'merchant') {
    echo "Access denied. This page is only for merchants.";
    exit();
}

$message = "";
include './includes/conn.php';

// Handle Add Product form submission
// Handle Add Product form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action']) && $_POST['action'] === 'add') {
    $name = trim($_POST['name']);
    $description = trim($_POST['description']);
    $price = floatval($_POST['price']);
    $stock = intval($_POST['stock']);
    $merchant_id = $_SESSION['user_id']; // Use logged-in merchant's ID

    // Check if a file is uploaded and available
    if (isset($_FILES['file']) && $_FILES['file']['error'] == 0) {
        $file = $_FILES['file']['tmp_name'];
        $fileData = file_get_contents($file); // Read file data
    } else {
        $fileData = null; // No file uploaded
    }

    try {
        // Prepare the SQL statement
        $sql = "INSERT INTO products (merchant_id, name, description, price, stock, image_data) 
                VALUES (:merchant_id, :name, :description, :price, :stock, :fileData)";
        
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':merchant_id', $merchant_id, PDO::PARAM_INT);
        $stmt->bindParam(':name', $name, PDO::PARAM_STR);
        $stmt->bindParam(':description', $description, PDO::PARAM_STR);
        $stmt->bindParam(':price', $price);
        $stmt->bindParam(':stock', $stock, PDO::PARAM_INT);
        $stmt->bindParam(':fileData', $fileData, PDO::PARAM_LOB); // Bind file data as LOB

        $stmt->execute();
        
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

    // Check if a file is uploaded and available
    if (isset($_FILES['file']) && $_FILES['file']['error'] == 0) {
        $file = $_FILES['file']['tmp_name'];
        $fileData = file_get_contents($file); // Read file data
        $sql = "UPDATE products SET name = :name, description = :description, price = :price, stock = :stock, image_data = :fileData 
                WHERE id = :product_id AND merchant_id = :merchant_id";
        $params = [
            ':name' => $name,
            ':description' => $description,
            ':price' => $price,
            ':stock' => $stock,
            ':fileData' => $fileData,
            ':product_id' => $product_id,
            ':merchant_id' => $_SESSION['user_id']
        ];
    } else {
        $sql = "UPDATE products SET name = :name, description = :description, price = :price, stock = :stock 
                WHERE id = :product_id AND merchant_id = :merchant_id";
        $params = [
            ':name' => $name,
            ':description' => $description,
            ':price' => $price,
            ':stock' => $stock,
            ':product_id' => $product_id,
            ':merchant_id' => $_SESSION['user_id']
        ];
    }

    try {
        $stmt = $conn->prepare($sql);
        $stmt->execute($params);
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

    <form method="POST" enctype="multipart/form-data" class="mb-5">
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
        <div class="mb-3">
            <label for="file" class="form-label" style="font-weight: bold;">Upload Product Image</label>
            <input type="file" class="form-control" id="file" name="file" accept=".jpg,.jpeg,.png,.pdf" required>
            <div class="invalid-feedback">Please upload a valid file (jpg, jpeg, png, pdf).</div>
        </div>

        <button type="submit" class="btn btn-primary">Add Product</button>
    </form>

    <h3>Product List</h3>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Image</th>
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
                        <td>
                            <?php if (!empty($product['image_data'])): ?>
                                <img src="data:image/jpeg;base64,<?php echo base64_encode($product['image_data']); ?>" style="width: 60px; height: 60px; object-fit: cover;">
                            <?php else: ?>
                                <img src="path/to/default-image.jpg" style="width: 60px; height: 60px; object-fit: cover;">
                            <?php endif; ?>
                        </td>
                        <td><?php echo htmlspecialchars($product['name']); ?></td>
                        <td><?php echo htmlspecialchars($product['description']); ?></td>
                        <td><?php echo htmlspecialchars($product['price']); ?></td>
                        <td><?php echo htmlspecialchars($product['stock']); ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr><td colspan="7">No products found.</td></tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>
