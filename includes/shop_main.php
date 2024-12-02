<?php
if ($_SESSION['user_type'] !== 'customer') {
    echo "Access denied. This page is only for customers.";
    exit();
}

include './includes/conn.php';

$merchant_id = isset($_GET['merchant_id']) ? intval($_GET['merchant_id']) : null;
$products = [];
$message = "";

// Fetch products based on the merchant ID if provided, otherwise fetch all products
try {
    $query = "SELECT products.*, users.full_name AS merchant_name 
              FROM products 
              JOIN users ON products.merchant_id = users.id";

    if ($merchant_id) {
        $query .= " WHERE products.merchant_id = :merchant_id";
        $stmt = $conn->prepare($query);
        $stmt->execute([':merchant_id' => $merchant_id]);
    } else {
        $stmt = $conn->query($query);
    }

    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    $message = "Error fetching products: " . $e->getMessage();
}
?>

<div class="container mt-5">
    <h2 class="text-center">Shop</h2>

    <?php if ($message): ?>
        <div class="alert alert-danger"><?php echo htmlspecialchars($message); ?></div>
    <?php endif; ?>

    <div class="row">
        <?php if (!empty($products)): ?>
            <?php foreach ($products as $product): ?>
                <div class="col-md-4 mb-4">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo htmlspecialchars($product['name']); ?></h5>
                            <p class="card-text"><?php echo htmlspecialchars($product['description']); ?></p>
                            <p class="card-text"><strong>Price:</strong> $<?php echo number_format($product['price'], 2); ?></p>
                            <p class="card-text"><strong>Stock:</strong> <?php echo htmlspecialchars($product['stock']); ?></p>
                            <form onsubmit="addToCart(event, <?php echo htmlspecialchars(json_encode($product)); ?>)">
                                <div class="mb-2">
                                    <label for="quantity-<?php echo $product['id']; ?>">Quantity:</label>
                                    <input type="number" id="quantity-<?php echo $product['id']; ?>" class="form-control" min="1" max="<?php echo htmlspecialchars($product['stock']); ?>" required>
                                </div>
                                <button type="submit" class="btn btn-primary w-100">Add to Cart</button>
                            </form>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>No products found.</p>
        <?php endif; ?>
    </div>
</div>
<script>
  let cart = [];

// Add to cart function
function addToCart(event, product) {
    event.preventDefault();

    const quantityInput = document.getElementById(`quantity-${product.id}`);
    const quantity = parseInt(quantityInput.value);

    if (quantity <= 0 || isNaN(quantity)) {
        alert("Invalid quantity.");
        return;
    }

    const existingItem = cart.find(item => item.id === product.id);
    if (existingItem) {
        existingItem.quantity += quantity;
    } else {
        cart.push({ ...product, quantity });
    }

    renderCart();
}

// Render cart function
function renderCart() {
    const cartContainer = document.getElementById('cart');
    const cartItemsContainer = document.createElement('ul');
    cartItemsContainer.className = 'list-group mb-3';

    if (cart.length === 0) {
        cartContainer.style.display = 'none';
        return;
    }

    cartContainer.innerHTML = `
        <h5>Cart</h5>
        <ul class="list-group mb-3"></ul>
        <button id="checkout" class="btn btn-success w-100">Buy Now</button>
    `;

    cartContainer.style.display = 'block';

    cart.forEach(item => {
        const cartItem = document.createElement('li');
        cartItem.className = 'list-group-item d-flex justify-content-between align-items-center';
        cartItem.innerHTML = `
            ${item.name} (x${item.quantity})
            <span>$${(item.price * item.quantity).toFixed(2)}</span>
        `;
        cartItemsContainer.appendChild(cartItem);
    });

    document.getElementById('checkout').addEventListener('click', checkout);
    cartContainer.querySelector('ul').replaceWith(cartItemsContainer);
}

// Checkout function
async function checkout() {
    if (cart.length === 0) {
        alert("Your cart is empty!");
        return;
    }

    try {
        const response = await fetch('./includes/process_cart.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(cart),
        });

        const result = await response.json();
        if (result.success) {
            alert("Purchase successful!");
            cart = [];
            renderCart();
        } else {
            alert(result.message || "Error during checkout.");
        }
    } catch (error) {
        console.error("Checkout error:", error);
    }
}

</script>