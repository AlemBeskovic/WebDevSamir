<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reports</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>

<body>
    <?php include './includes/conn.php'; ?>

    <div class="container-fluid content-wrapper d-flex flex-column flex-grow-1">
        <div class="row flex-grow-1">
            <?php include './includes/nav.php'; ?>
            <?php include './includes/reports_main.php'; ?>
        </div>
    </div>
    <?php include './includes/footer.php'; ?>
</body>

</html>
