<?php
session_start();


// Access control for admins
if (!isset($_SESSION['user_type']) || $_SESSION['user_type'] !== 'admin') {
    die("Access denied.");
}

// Include database connection
include './includes/conn.php';

$message = "";
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Hash password
    $full_name = $_POST['full_name'];
    $userType = 'merchant'; 
    $address = $_POST['address'];
  $city = $_POST['city'];
  $state = $_POST['state'];
  $zip_code = $_POST['zip_code'];
    try {
      $stmt = $conn->prepare("INSERT INTO users (username, email, password, full_name, userType, address, city, state, zip_code) 
      VALUES (:username, :email, :password, :full_name, :userType, :address, :city, :state, :zip_code)");
      $stmt->bindParam(':username', $username);
      $stmt->bindParam(':email', $email);
      $stmt->bindParam(':password', $password);
      $stmt->bindParam(':full_name', $full_name);
      $stmt->bindParam(':userType', $userType);
      $stmt->bindParam(':address', $address);
      $stmt->bindParam(':city', $city);
      $stmt->bindParam(':state', $state);
      $stmt->bindParam(':zip_code', $zip_code);
        $stmt->execute();

        $message = "Merchant account created successfully!";
    } catch (PDOException $e) {
        $message = "Error creating merchant account: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Merchant</title>
</head>

<body style="font-family: Arial, sans-serif; margin: 0; padding: 0; background-color: #f9f9f9;">
<?php include './includes/nav.php'; ?>
    <div style="max-width: 600px; margin: 20px auto; background: white; border-radius: 8px; box-shadow: 0px 4px 6px rgba(0,0,0,0.1); padding: 20px;">
        <h1 style="text-align: center; color: #333;">Create Merchant</h1>
        <form method="POST" style="display: flex; flex-direction: column; gap: 15px;">
            <label for="username" style="font-weight: bold; color: #555;">Username:</label>
            <input type="text" name="username" required style="padding: 10px; border: 1px solid #ccc; border-radius: 5px;">

            <label for="email" style="font-weight: bold; color: #555;">Email:</label>
            <input type="email" name="email" required style="padding: 10px; border: 1px solid #ccc; border-radius: 5px;">

            <label for="password" style="font-weight: bold; color: #555;">Password:</label>
            <input type="password" name="password" required style="padding: 10px; border: 1px solid #ccc; border-radius: 5px;">

            <label for="full_name" style="font-weight: bold; color: #555;">Full Name:</label>
            <input type="text" name="full_name" required style="padding: 10px; border: 1px solid #ccc; border-radius: 5px;">

            <label for="address" style="font-weight: bold; color: #555;">Address:</label>
            <input type="text" name="address" required style="padding: 10px; border: 1px solid #ccc; border-radius: 5px;">

            <label for="city" style="font-weight: bold; color: #555;">City:</label>
            <input type="text" name="city" required style="padding: 10px; border: 1px solid #ccc; border-radius: 5px;">

            <label for="state" style="font-weight: bold; color: #555;">State:</label>
            <input type="text" name="state" required style="padding: 10px; border: 1px solid #ccc; border-radius: 5px;">

            <label for="zip_code" style="font-weight: bold; color: #555;">Zip Code:</label>
            <input type="text" name="zip_code" required style="padding: 10px; border: 1px solid #ccc; border-radius: 5px;">

            <button type="submit" style="background-color: #4CAF50; color: white; padding: 10px 15px; border: none; border-radius: 5px; cursor: pointer; font-size: 16px;">Create Merchant</button>
        </form>
        <p style="text-align: center; margin-top: 15px; color: <?php echo $message === 'Merchant account created successfully!' ? '#4CAF50' : '#ff0000'; ?>;">
            <?php echo $message; ?>
        </p>
    </div>

</body>
</html>
