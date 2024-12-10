<?php
include '../includes/conn.php'; // Ensure conn.php is included to establish a connection and ensure tables exist
session_start();

$message = "";

// Check if the request method is POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize and validate input data
    $username = !empty($_POST['username']) ? trim($_POST['username']) : null;
    $email = !empty($_POST['email']) ? trim($_POST['email']) : null;
    $password = !empty($_POST['password']) ? password_hash($_POST['password'], PASSWORD_DEFAULT) : null; // Hash the password
    $full_name = !empty($_POST['full_name']) ? trim($_POST['full_name']) : null;
    $userType = 'customer';
    $address = !empty($_POST['address']) ? trim($_POST['address']) : null;
    $city = !empty($_POST['city']) ? trim($_POST['city']) : null;
    $state = !empty($_POST['state']) ? trim($_POST['state']) : null;
    $zip_code = !empty($_POST['zip_code']) ? trim($_POST['zip_code']) : null;

    // Check if a file is uploaded and available
    if (isset($_FILES['file']) && $_FILES['file']['error'] == 0) {
        $file = $_FILES['file']['tmp_name'];

        // Read file data into a variable
        $fileData = file_get_contents($file);

        try {
            // Prepare SQL and bind parameters
            $stmt = $conn->prepare("INSERT INTO users (username, email, password, full_name, userType, address, city, state, zip_code, FileData) 
                                    VALUES (:username, :email, :password, :full_name, :userType, :address, :city, :state, :zip_code, :fileData)");
            $stmt->bindParam(':username', $username);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':password', $password);
            $stmt->bindParam(':full_name', $full_name);
            $stmt->bindParam(':userType', $userType);
            $stmt->bindParam(':address', $address);
            $stmt->bindParam(':city', $city);
            $stmt->bindParam(':state', $state);
            $stmt->bindParam(':zip_code', $zip_code);
            $stmt->bindParam(':fileData', $fileData, PDO::PARAM_LOB); // Store as LOB (large object)
            $stmt->execute();
            $user_id = $conn->lastInsertId();

            // Set session variables for the new user
            $_SESSION['user_id'] = $user_id;
            $_SESSION['username'] = $username;
            $_SESSION['full_name'] = $full_name;
            $_SESSION['user_type'] = $userType;
            $_SESSION['user_image'] = $fileData ? 'data:image/jpeg;base64,' . base64_encode($fileData) : '';

            // Redirect to dashboard
            header('Location: ../dashboard.php');
            exit();
        } catch (PDOException $e) {
            $message = "Error inserting data: " . $e->getMessage();
        }
    } else {
        $message = "Error: Please upload a valid file.";
    }
} else {
    $message = "Invalid request method.";
}

// Redirect with a message if registration fails
header('Location: ../show_message.php?type=Registration&message=' . urlencode($message));
exit();
?>