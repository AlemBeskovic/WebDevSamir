<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Database Management System</title>
    <link rel="icon" type="image/x-icon" href="./includes/favicon.ico">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/styles.css">
</head>

<body style="background-color: #f4f9fc; font-family: Arial, sans-serif;">
    <div class="container mt-5" style="max-width: 600px; background: #eafafc; border-radius: 12px; padding: 20px; box-shadow: 0 4px 8px rgba(0,0,0,0.1);">
        <h2 class="text-center" style="color: #288286; font-weight: bold;"><i class="fas fa-user-plus"></i> User Registration</h2>
        <form action="./includes/process_registration.php" method="POST" enctype="multipart/form-data" class="needs-validation" novalidate>

            <!-- Username -->
            <div class="mb-3">
                <label for="username" class="form-label" style="font-weight: bold;"><i class="fas fa-user"></i> Username</label>
                <input type="text" class="form-control" id="username" name="username" pattern="^[a-zA-Z0-9_]{5,50}$" required style="border: 1px solid #cbe5e8; border-radius: 6px;">
                <div class="invalid-feedback">Username must be alphanumeric and 5-50 characters long.</div>
            </div>

            <!-- Email -->
            <div class="mb-3">
                <label for="email" class="form-label" style="font-weight: bold;"><i class="fas fa-envelope"></i> Email address</label>
                <input type="email" class="form-control" id="email" name="email" pattern="^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$" required style="border: 1px solid #cbe5e8; border-radius: 6px;">
                <div class="invalid-feedback">Please provide a valid email address.</div>
            </div>

            <!-- Password -->
            <div class="mb-3">
                <label for="password" class="form-label" style="font-weight: bold;"><i class="fas fa-lock"></i> Password</label>
                <input type="password" class="form-control" id="password" name="password" pattern="^(?=.*[A-Za-z])(?=.*\d)(?=.*[!@#$%^&*])[A-Za-z\d!@#$%^&*]{8,}$" required style="border: 1px solid #cbe5e8; border-radius: 6px;">
                <div class="invalid-feedback">Password must be at least 8 characters long, contain at least one letter, one number, and one special character (!@#$%^&*).</div>
            </div>

            <!-- Full Name -->
            <div class="mb-3">
                <label for="full_name" class="form-label" style="font-weight: bold;"><i class="fas fa-id-card"></i> Full Name</label>
                <input type="text" class="form-control" id="full_name" name="full_name" required style="border: 1px solid #cbe5e8; border-radius: 6px;">
                <div class="invalid-feedback">Please provide your full name.</div>
            </div>

            <!-- Address -->
            <div class="mb-3">
                <label for="address" class="form-label" style="font-weight: bold;">Address</label>
                <input type="text" class="form-control" id="address" name="address" required style="border: 1px solid #cbe5e8; border-radius: 6px;">
                <div class="invalid-feedback">Please provide your address.</div>
            </div>

            <!-- City -->
            <div class="mb-3">
                <label for="city" class="form-label" style="font-weight: bold;">City</label>
                <input type="text" class="form-control" id="city" name="city" required style="border: 1px solid #cbe5e8; border-radius: 6px;">
                <div class="invalid-feedback">Please provide your city.</div>
            </div>

            <!-- State -->
            <div class="mb-3">
                <label for="state" class="form-label" style="font-weight: bold;">State</label>
                <input type="text" class="form-control" id="state" name="state" required style="border: 1px solid #cbe5e8; border-radius: 6px;">
                <div class="invalid-feedback">Please provide your state.</div>
            </div>

            <!-- Zip Code -->
            <div class="mb-3">
                <label for="zip_code" class="form-label" style="font-weight: bold;">Zip Code</label>
                <input type="text" class="form-control" id="zip_code" name="zip_code" pattern="\d{5}" required style="border: 1px solid #cbe5e8; border-radius: 6px;">
                <div class="invalid-feedback">Please provide a valid 5-digit zip code.</div>
            </div>

            <!-- User Type -->
            <div class="mb-3">
                <label for="user_type" class="form-label" style="font-weight: bold;"><i class="fas fa-user-tag"></i> User Type</label>
                <select class="form-control" id="user_type" name="user_type" required style="border: 1px solid #cbe5e8; border-radius: 6px;">
                    <option value="customer">Customer</option>
                    <option value="merchant">Merchant</option>
                </select>
                <div class="invalid-feedback">Please select a user type.</div>
            </div>

            <!-- File Upload -->
            <div class="mb-3">
                <label for="file" class="form-label" style="font-weight: bold;"><i class="fas fa-file-upload"></i> Upload File</label>
                <input type="file" class="form-control" id="file" name="file" accept=".jpg,.jpeg,.png,.pdf" required style="border: 1px solid #cbe5e8; border-radius: 6px;">
                <div class="invalid-feedback">Please upload a valid file (jpg, jpeg, png, pdf).</div>
            </div>

            <button type="submit" class="btn btn-primary w-100" style="background-color: #288286; border: none; font-weight: bold; border-radius: 6px;">
                <i class="fas fa-user-check"></i> Register
            </button>
        </form>
    </div>

    <script>
        // Bootstrap form validation
        (function() {
            'use strict';
            const forms = document.querySelectorAll('.needs-validation');
            Array.prototype.slice.call(forms).forEach(function(form) {
                form.addEventListener('submit', function(event) {
                    if (!form.checkValidity()) {
                        event.preventDefault();
                        event.stopPropagation();
                    }
                    form.classList.add('was-validated');
                }, false);
            });
        })();
    </script>
</body>

</html>