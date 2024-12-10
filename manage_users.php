<?php
session_start();

// Access control for admins
if (!isset($_SESSION['user_type']) || $_SESSION['user_type'] !== 'admin') {
    die("Access denied.");
}

// Include database connection
include './includes/conn.php';

// Handle delete operation
// Handle delete operation
if (isset($_GET['delete_id'])) {
  $deleteId = $_GET['delete_id'];
  try {
      // Step 1: Delete related reports for products owned by this user
      $stmt = $conn->prepare("DELETE FROM reports WHERE product_id IN (SELECT id FROM products WHERE merchant_id = :id)");
      $stmt->bindParam(':id', $deleteId);
      $stmt->execute();

      // Step 2: Delete the user's products
      $stmt = $conn->prepare("DELETE FROM products WHERE merchant_id = :id");
      $stmt->bindParam(':id', $deleteId);
      $stmt->execute();

      // Step 3: Delete the user
      $stmt = $conn->prepare("DELETE FROM users WHERE id = :id");
      $stmt->bindParam(':id', $deleteId);
      $stmt->execute();

      $message = "User and all associated records deleted successfully!";
  } catch (PDOException $e) {
      $message = "Error deleting user: " . $e->getMessage();
  }
}


// Handle update operation (AJAX request)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_user'])) {
    $userId = $_POST['user_id'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $full_name = $_POST['full_name'];
    $address = $_POST['address'];
    $city = $_POST['city'];
    $state = $_POST['state'];
    $zip_code = $_POST['zip_code'];

    try {
        $stmt = $conn->prepare("UPDATE users SET username = :username, email = :email, full_name = :full_name, address = :address, city = :city, state = :state, zip_code = :zip_code WHERE id = :id");
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':full_name', $full_name);
        $stmt->bindParam(':address', $address);
        $stmt->bindParam(':city', $city);
        $stmt->bindParam(':state', $state);
        $stmt->bindParam(':zip_code', $zip_code);
        $stmt->bindParam(':id', $userId);
        $stmt->execute();
        $message = "User updated successfully!";
    } catch (PDOException $e) {
        $message = "Error updating user: " . $e->getMessage();
    }
}

// Fetch users from the database
try {
    $stmt = $conn->prepare("SELECT * FROM users WHERE userType = 'merchant'");
    $stmt->execute();
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Error fetching users: " . $e->getMessage());
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Users</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body style="font-family: Arial, sans-serif; margin: 0; padding: 0; background-color: #f9f9f9;">

    <!-- Include Navbar -->
    <?php include './includes/nav.php'; ?>

    <div class="container mt-4">
        <h1 class="text-center mb-4">Manage Users</h1>

        <?php if (!empty($message)): ?>
            <div class="alert alert-info text-center"><?php echo $message; ?></div>
        <?php endif; ?>

        <!-- User Table -->
        <table class="table table-striped table-bordered">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Username</th>
                    <th>Email</th>
                    <th>Full Name</th>
                    <th>Address</th>
                    <th>City</th>
                    <th>State</th>
                    <th>Zip Code</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($users as $user): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($user['id']); ?></td>
                        <td><?php echo htmlspecialchars($user['username']); ?></td>
                        <td><?php echo htmlspecialchars($user['email']); ?></td>
                        <td><?php echo htmlspecialchars($user['full_name']); ?></td>
                        <td><?php echo htmlspecialchars($user['address']); ?></td>
                        <td><?php echo htmlspecialchars($user['city']); ?></td>
                        <td><?php echo htmlspecialchars($user['state']); ?></td>
                        <td><?php echo htmlspecialchars($user['zip_code']); ?></td>
                        <td>
                            <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#editUserModal" 
                                data-id="<?php echo $user['id']; ?>"
                                data-username="<?php echo $user['username']; ?>"
                                data-email="<?php echo $user['email']; ?>"
                                data-fullname="<?php echo $user['full_name']; ?>"
                                data-address="<?php echo $user['address']; ?>"
                                data-city="<?php echo $user['city']; ?>"
                                data-state="<?php echo $user['state']; ?>"
                                data-zipcode="<?php echo $user['zip_code']; ?>">
                                Edit
                            </button>
                            <a href="manage_users.php?delete_id=<?php echo $user['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this user?');">Delete</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <!-- Edit User Modal -->
    <div class="modal fade" id="editUserModal" tabindex="-1" aria-labelledby="editUserModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form method="POST">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editUserModalLabel">Edit User</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="user_id" id="modalUserId">
                        <div class="mb-3">
                            <label for="modalUsername" class="form-label">Username</label>
                            <input type="text" class="form-control" name="username" id="modalUsername" required>
                        </div>
                        <div class="mb-3">
                            <label for="modalEmail" class="form-label">Email</label>
                            <input type="email" class="form-control" name="email" id="modalEmail" required>
                        </div>
                        <div class="mb-3">
                            <label for="modalFullName" class="form-label">Full Name</label>
                            <input type="text" class="form-control" name="full_name" id="modalFullName" required>
                        </div>
                        <div class="mb-3">
                            <label for="modalAddress" class="form-label">Address</label>
                            <input type="text" class="form-control" name="address" id="modalAddress" required>
                        </div>
                        <div class="mb-3">
                            <label for="modalCity" class="form-label">City</label>
                            <input type="text" class="form-control" name="city" id="modalCity" required>
                        </div>
                        <div class="mb-3">
                            <label for="modalState" class="form-label">State</label>
                            <input type="text" class="form-control" name="state" id="modalState" required>
                        </div>
                        <div class="mb-3">
                            <label for="modalZipCode" class="form-label">Zip Code</label>
                            <input type="text" class="form-control" name="zip_code" id="modalZipCode" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" name="update_user" class="btn btn-success">Save Changes</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Populate modal fields with user data
        var editUserModal = document.getElementById('editUserModal');
        editUserModal.addEventListener('show.bs.modal', function (event) {
            var button = event.relatedTarget;
            var userId = button.getAttribute('data-id');
            var username = button.getAttribute('data-username');
            var email = button.getAttribute('data-email');
            var fullName = button.getAttribute('data-fullname');
            var address = button.getAttribute('data-address');
            var city = button.getAttribute('data-city');
            var state = button.getAttribute('data-state');
            var zipCode = button.getAttribute('data-zipcode');

            document.getElementById('modalUserId').value = userId;
            document.getElementById('modalUsername').value = username;
            document.getElementById('modalEmail').value = email;
            document.getElementById('modalFullName').value = fullName;
            document.getElementById('modalAddress').value = address;
            document.getElementById('modalCity').value = city;
            document.getElementById('modalState').value = state;
            document.getElementById('modalZipCode').value = zipCode;
        });
    </script>
</body>
</html>