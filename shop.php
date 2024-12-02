<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shop</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        #cart {
            display: none;
            position: fixed;
            top: 0;
            right: 0;
            width: 300px;
            height: 100%;
            background-color: #f8f9fa;
            border-left: 1px solid #ddd;
            padding: 15px;
            overflow-y: auto;
            z-index: 1050;
        }
    </style>
</head>

<body>
    <?php include './includes/conn.php'; ?>
    <?php include './includes/header.php'; ?>
    <div class="container-fluid content-wrapper d-flex flex-column flex-grow-1">
        <div class="row flex-grow-1">
            <?php include './includes/nav.php'; ?>
            <div class="col-lg-9">
                <?php include './includes/shop_main.php'; ?>
            </div>
            <div id="cart" class="col-lg-3"></div>
        </div>
    </div>
    <?php include './includes/footer.php'; ?>
</body>

</html>
