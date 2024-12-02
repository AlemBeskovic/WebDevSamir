<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "myDBPDO";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch carousel data from the MySQL table
$sql = "SELECT * FROM images";
$result = $conn->query($sql);

// Initialize variables for carousel indicators and items
$carouselIndicators = '';
$carouselItems = '';

if ($result->num_rows > 0) {
    $i = 0;
    while ($row = $result->fetch_assoc()) {
        // Create indicators
        $activeClass = $i === 0 ? 'active' : '';
        $carouselIndicators .= "<li data-bs-target='#carouselExampleIndicators' data-bs-slide-to='$i' class='$activeClass'></li>";

        // Create carousel items
        $carouselItems .= "
        <div class='carousel-item $activeClass'>
            <img src='{$row['image_path']}' class='d-block w-100' alt='...'>
            <div class='carousel-caption d-none d-md-block'>
                <h5>{$row['title']}</h5>
            </div>
        </div>";
        $i++;
    }
} else {
    echo "No records found.";
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>PHP Carousel</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css">
</head>

<body>

    <div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="carousel">
        <ol class="carousel-indicators">
            <?php echo $carouselIndicators; ?>
        </ol>
        <div class="carousel-inner">
            <?php echo $carouselItems; ?>
        </div>
        <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </a>
        <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </a>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>