<?php
include "conn.php";

// Fetch all categories for navigation
$categorySqlNav = "SELECT * FROM categories";
$categoryResultNav = $conn->query($categorySqlNav);

// Fetch categories with at least one package
$categorySqlPackages = "SELECT DISTINCT c.* FROM categories c
                        JOIN PackageDetails pd ON c.id = pd.category_id";
$categoryResultPackages = $conn->query($categorySqlPackages);

// Fetch packages with category information
$sqlPackages = "SELECT pd.*, c.category_name FROM PackageDetails pd
                JOIN categories c ON pd.category_id = c.id";
$resultPackages = $conn->query($sqlPackages);

// Fetch the categories into an array for navigation
$categoriesNav = [];
while ($row = $categoryResultNav->fetch_assoc()) {
    $categoriesNav[] = $row;
}

// Fetch the categories into an array for packages
$categoriesPackages = [];
while ($row = $categoryResultPackages->fetch_assoc()) {
    $categoriesPackages[] = $row;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>YKSTRIPS ABOUT US</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">

    <style>
        .slider-container {
            width: 100%;
            overflow: hidden;
            position: relative;
            margin-left: auto;
            margin-right: auto;
        }

        .slider-cat-container {
            width: 70%;
            overflow: hidden;
            position: relative;
            margin-left: auto;
            margin-right: auto;
        }

        .slider-wrapper {
            display: flex;
            transition: transform 0.5s ease-in-out;
        }

        .slider-item {
            flex: 0 0 auto;
            margin-right: 2px;
        }


        .destination-card {
            width: 100%;
            margin-right: 2px;
            overflow: hidden;
        }


        .destination-card img {
            width: 100%;
            height: 350px;
            object-fit: cover;
        }

        .destination-info {
            text-align: center;
        }

        .destination-info h3,
        .destination-info h6 {
            margin: 5px 0;
        }

        .destination-info .btn {
            font-size: 1.2em;
            padding: 10px 20px;
            margin-top: 10px;
        }

        .slider-controls {
            position: absolute;
            top: 50%;
            width: 100%;
            display: flex;
            justify-content: space-between;
            transform: translateY(-50%);
        }

        .slider-controls {
            position: absolute;
            top: 50%;
            width: 100%;
            display: flex;
            justify-content: space-between;
            transform: translateY(-50%);
            padding: 0 20px;
            /* Add padding for better spacing */
        }

        .category-slider {
            max-width: 100%;
            overflow: hidden;
        }

        .category-card {
            max-width: 100%;
            text-align: center;
        }

        .category-card img {
            max-width: 50px;
            max-height: 50px;
            object-fit: contain;
        }

        .social-icons {
            display: flex;
            align-items: center;
            margin-left: auto;
            gap: 15px;
        }

        .social-icons a {
            font-size: 30px;
            color: white;
        }
        .slider-val-container {
            overflow: hidden;
            position: relative;
        }

        .slider-val-wrapper {
            display: flex;
            transition: transform 0.5s ease-in-out;
        }

        .slider-val-item {
            flex: 0 0 100%;
        }

        .slider-val-item img {
            width: 100%;
            height: auto;
        }

        .slider-val-controls {
            position: absolute;
            top: 50%;
            width: 100%;
            display: flex;
            justify-content: space-between;
            transform: translateY(-50%);
        }

        .slider-val-control {
            cursor: pointer;
            padding: 10px;
            background-color: #333;
            color: #fff;
        }
    </style>


    <!-- Favicon -->
    <link href="img/favicon.ico" rel="icon">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Heebo:wght@400;500;600&family=Nunito:wght@600;700;800&display=swap" rel="stylesheet">

    <!-- Icon Font Stylesheet -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="lib/animate/animate.min.css" rel="stylesheet">
    <link href="lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">
    <link href="lib/tempusdominus/css/tempusdominus-bootstrap-4.min.css" rel="stylesheet" />

    <!-- Customized Bootstrap Stylesheet -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Template Stylesheet -->
    <link href="css/style.css" rel="stylesheet">
</head>

<body>


    <!-- Navbar & Hero Start -->
    <div class="container-fluid position-relative p-0">
    <nav class="navbar navbar-expand-lg navbar-light px-4 px-lg-5 py-3 py-lg-0" style="background-color:  #316FF6;">
            <a href="index.php" class="navbar-brand p-0">
                <img src="img/logo.png" alt="Logo" style="border-radius: 50%; background-color: white; padding: 5px;">
            </a>
            <!-- Category Slider Start for Navigation -->
            <div class="container-xxl py-2 category-slider">
                <div class="container">
                    <div class="slider-cat-container ">
                        <div class="slider-wrapper">
                            <?php foreach ($categoriesNav as $category) : ?>
                                <div class="col-lg-2 col-md-3 wow zoomIn slider-item" data-wow-delay="0.1s">
                                    <div class="category-card">
                                        <!-- Wrap the category icon with an anchor tag -->
                                        <a href="category_page.php?category_id=<?php echo $category['id']; ?>">
                                            <img class="img-fluid" src="<?php echo $category['icon_path']; ?>" alt="Category Icon">
                                            <div class="category-name" style="color: white;"><?php echo $category['category_name']; ?></div>
                                        </a>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                        <!-- Update the slider-controls section -->
                        <div class="slider-controls">
                            <div class="slider-control" onclick="prevCategorySlide()"><i class="fas fa-chevron-left"></i></div>
                            <div class="slider-control" onclick="nextCategorySlide()"><i class="fas fa-chevron-right"></i></div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Category Slider End for Navigation -->


            <!-- Social Media Icons -->
            <div class="social-icons ml-auto">
                <a href="https://www.instagram.com/yks.yathrakarudesrdhakku?igsh=M2tqbTVnNWx1cHEy&utm_source=qr" target="_blank" class="text-white">
                    <i class="fab fa-instagram"></i>
                </a>
                <a href="https://www.instagram.com/yks_trip?igsh=cWQxbThhNDRsbTZ5&utm_source=qr" target="_blank" class="text-white">
                    <i class="fab fa-instagram"></i>
                </a>
                <a href="https://youtube.com/@ykshere?si=R3n-6trG0xPv0RFX" target="_blank" class="text-white">
                    <i class="fab fa-youtube"></i>
                </a>
            </div>
        </nav>


        <div class="container-fluid bg-primary py-5 mb-5 hero-header">
            <div class="container py-5">
                <div class="row justify-content-center py-5">
                    <div class="col-lg-10 pt-lg-5 mt-lg-5 text-center">
                        <h1 class="display-3 text-white mb-3 animated slideInDown" style="font-size: 2.5em;">OUR MISSION</h1>
                        <p class="display-3  mb-3 animated slideInDown" style="font-size: 3.5em; color: #357bae;  text-shadow: 2px 2px 0px white, -2px -2px 0px white, 2px -2px 0px white, -2px 2px 0px white;">Make your travel</p>
                        <p class="display-3  mb-3 animated slideInDown" style="font-size: 3.5em; color: #357bae;  text-shadow: 2px 2px 0px white, -2px -2px 0px white, 2px -2px 0px white, -2px 2px 0px white;">more seamless.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Navbar & Hero End -->


    <!-- About Start -->
<div class="container-xxl py-5">
    <div class="container text-center mb-4">
        <img class="img-fluid" src="img/about.png" alt="Logo" style="max-width: 200px;">
    </div>
    <div class="container">
        <div class="row g-5 align-items-center">
            <div class="col-lg-3 text-center mb-4">
                <h2 class="display-4 text-primary mb-2">500+</h2>
                <p class="lead mb-0">Happy Customers</p>
            </div>
            <div class="col-lg-3 text-center mb-4">
                <h2 class="display-4 text-primary mb-2">70+</h2>
                <p class="lead mb-0">Destinations</p>
            </div>
            <div class="col-lg-3 text-center mb-4">
                <h2 class="display-4 text-primary mb-2">30+</h2>
                <p class="lead mb-0">Activities</p>
            </div>
            <div class="col-lg-3 text-center mb-4">
                <h2 class="display-4 text-primary mb-2">40,000+</h2>
                <p class="lead mb-0">YKS FAMILY</p>
            </div>
        </div>
    </div>
</div>
<!-- About End -->


<!-- Value Start -->
<div class="container-xxl py-5">
    <div class="container">
        <div class="slider-val-container">
            <div class="slider-val-wrapper">
                <!-- Replace these paths with your image paths -->
                <div class="slider-val-item">
                    <img src="img/value1.png" alt="Value 1">
                </div>
                <div class="slider-val-item">
                    <img src="img/value2.png" alt="Value 2">
                </div>
                <div class="slider-val-item">
                    <img src="img/value3.png" alt="Value 3">
                </div>
                <div class="slider-val-item">
                    <img src="img/value4.png" alt="Value 4">
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Value End -->
<script>
    let currentIndex = 0;

    function nextSlide() {
        currentIndex = (currentIndex + 1) % document.querySelectorAll('.slider-val-item').length;
        updateSlider();
    }

    function updateSlider() {
        const sliderWrapper = document.querySelector('.slider-val-wrapper');
        const itemWidth = document.querySelector('.slider-val-item').offsetWidth;

        sliderWrapper.style.transform = `translateX(${-currentIndex * itemWidth}px)`;
    }

    // Automatically slide every 3 seconds (adjust as needed)
    setInterval(nextSlide, 3000);
</script>


<!-- Our Journey Start -->
<div class="text-center py-5" style="margin-left: 20px; margin-right: 20px;">
    <h1 class="display-3 mb-4" style="font-size: 2.5em; border-bottom: 2px solid #007bff;">Our Journey</h1>
    <p class="lead" style="font-size: 1.5em; color: #555;">
        In the heart of our travel haven, we started by exploring with loved ones and sharing the joy on social media. 
        When we hit 10,000 followers in 2023, we realized our duty was to make travel effortless and magical. 
        So, we built a charming space dedicated to crafting seamless and unforgettable journeys. 
        The best part? Our travelers, enchanted by our first adventure, now choose only us for their next escapade. 
        We carefully pick destinations and assemble a friendly team, ensuring each trip is a simple yet beautiful memory.
    </p>
</div>
<!-- Our Journey End -->
<div style="text-align: center; font-size: 3.5em; border-top: 2px solid #007bff;"><img src="img/employ.png" alt="Join Us"></div>


        

    <!-- Footer Start -->
    <div class="container-fluid bg-dark text-light footer pt-5 mt-5 wow fadeIn" data-wow-delay="0.1s">
        <div class="container py-5">
            <div class="row g-5">
                <div class="col-lg-3 col-md-6 d-flex justify-content-between align-items-center">
                    <div>
                        <a class="btn btn-link" href="index.php">Home</a>
                        <a class="btn btn-link" href="about.html">About Us</a>
                        <a class="btn btn-link" href="contact.html">Contact Us</a>
                    </div>
                    <img src="img/logo.png" alt="Logo">
                </div>
            </div>
        </div>
    </div>
    <!-- Footer End -->


    <!-- Back to Top -->
    <a href="#" class="btn btn-lg btn-primary btn-lg-square back-to-top"><i class="bi bi-arrow-up"></i></a>


    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="lib/wow/wow.min.js"></script>
    <script src="lib/easing/easing.min.js"></script>
    <script src="lib/waypoints/waypoints.min.js"></script>
    <script src="lib/owlcarousel/owl.carousel.min.js"></script>
    <script src="lib/tempusdominus/js/moment.min.js"></script>
    <script src="lib/tempusdominus/js/moment-timezone.min.js"></script>
    <script src="lib/tempusdominus/js/tempusdominus-bootstrap-4.min.js"></script>

    <!-- Template Javascript -->
    <script src="js/main.js"></script>

    <script>
        let currentIndexCategory = 0;
        const totalItemsCategory = document.querySelectorAll('.category-slider .slider-item').length;
        const intervalTimeCategory = 3000;
        let categoryInterval;

        function startCategorySlider() {
            categoryInterval = setInterval(nextCategorySlide, intervalTimeCategory);
        }

        function stopCategorySlider() {
            clearInterval(categoryInterval);
        }

        function nextCategorySlide() {
            currentIndexCategory = (currentIndexCategory + 1) % totalItemsCategory;
            updateCategorySlider();
        }

        function prevCategorySlide() {
            currentIndexCategory = (currentIndexCategory - 1 + totalItemsCategory) % totalItemsCategory;
            updateCategorySlider();
        }

        function updateCategorySlider() {
            const wrapperCategory = document.querySelector('.category-slider .slider-wrapper');
            const slideWidthCategory = document.querySelector('.category-slider .slider-item').offsetWidth;
            const newTransformValueCategory = -currentIndexCategory * slideWidthCategory;
            wrapperCategory.style.transition = 'transform 0.5s ease-in-out'; // Add transition effect
            wrapperCategory.style.transform = `translateX(${newTransformValueCategory}px)`;
        }
    </script>


    <?php
    // Only start category slide if there are more than 3 categories
    if (!empty($categories) && count($categories) > 3) {
    ?>
        <script>
            // Automatic sliding for category slider
            startCategorySlider();

            // Stop automatic sliding when the user clicks next or previous
            document.querySelector('.slider-controls .slider-control').addEventListener('click', stopCategorySlider);
        </script>
    <?php
    }
    ?>


</body>

</html>