<?php
include 'conn.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    session_start(); // Start session to retrieve user ID
    $cart = json_decode(file_get_contents('php://input'), true);
    $response = ['success' => false, 'message' => ''];

    try {
        // Get the logged-in user's ID
        $customer_id = $_SESSION['user_id']; // Ensure 'user_id' is set in the session during login

        // Fetch customer details
        $stmt = $conn->prepare("SELECT address, city, state, zip_code FROM users WHERE id = :id");
        $stmt->execute([':id' => $customer_id]);
        $customer = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$customer) {
            throw new Exception("Customer not found.");
        }

        // Iterate through the cart items
        foreach ($cart as $item) {
            $product_id = intval($item['id']);
            $quantity = intval($item['quantity']);

            // Fetch product details
            $stmt = $conn->prepare("SELECT stock, price FROM products WHERE id = :product_id");
            $stmt->execute([':product_id' => $product_id]);
            $product = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($product && $product['stock'] >= $quantity) {
                // Update stock
                $stmt = $conn->prepare("UPDATE products SET stock = stock - :quantity WHERE id = :product_id");
                $stmt->execute([':quantity' => $quantity, ':product_id' => $product_id]);

               
$total_price = $quantity * $product['price'];
$stmt = $conn->prepare("INSERT INTO reports 
    (customer_id, product_id, quantity_sold, total_price, customer_name, customer_address, customer_city, customer_state, customer_zip_code) 
    VALUES 
    (:customer_id, :product_id, :quantity, :total_price, :customer_name, :customer_address, :customer_city, :customer_state, :customer_zip_code)");
$stmt->execute([
    ':customer_id' => $customer_id,
    ':product_id' => $product_id,
    ':quantity' => $quantity,
    ':total_price' => $total_price,
    ':customer_name' => $_SESSION['full_name'], 
    ':customer_address' => $customer['address'],
    ':customer_city' => $customer['city'],
    ':customer_state' => $customer['state'],
    ':customer_zip_code' => $customer['zip_code']
]);

            } else {
                $response['message'] = "Not enough stock for product ID {$product_id}.";
                echo json_encode($response);
                exit();
            }
        }

        $response['success'] = true;
        echo json_encode($response);
    } catch (Exception $e) {
        $response['message'] = "Error processing cart: " . $e->getMessage();
        echo json_encode($response);
    }
}

?>
