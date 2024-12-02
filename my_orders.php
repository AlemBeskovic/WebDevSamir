<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Orders</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <?php include './includes/conn.php'; ?>
    <?php include './includes/header.php'; ?>
    <div class="container-fluid content-wrapper d-flex flex-column flex-grow-1">
        <div class="row flex-grow-1">
            <?php include './includes/nav.php'; ?>
            <div class="col-lg-12">
                <?php include './includes/my_order_main.php'; ?>
            </div>
        </div>
    </div>
    <?php include './includes/footer.php'; ?>
</body>

</html>
