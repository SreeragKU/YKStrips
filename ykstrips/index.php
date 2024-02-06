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
    <title>YKS TRIP</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">
    <!-- Font Awesome Stylesheet -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>


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
    </style>
    <!-- <style>
        /* body {
            background-image: url('img/background.png');
            background-repeat: repeat;
            background-size: cover;
            background-position: center center;
        } */
    </style> -->

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


        <div id="heroCarousel" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-inner">
                <div class="carousel-item active" style="background-image: url('img/hero1.jpg');">
                    <div class="container-fluid bg-primary py-5 mb-5 hero-header">
                        <div class="container py-5">
                            <div class="row justify-content-center py-5">
                                <div class="col-lg-10 pt-lg-5 mt-lg-5 text-center">
                                    <h1 class="display-3 text-white mb-3 animated slideInDown">GET UPTO</h1>
                                    <p class="fs-4 text-white mb-4 animated slideInDown">50% OFF ON ALL OUR TRIPS</p>
                                    <a href="package.php" class="btn btn-primary rounded-pill py-2 px-4 transparent-background" style="color: #ffffff; background-color: #357bae; font-size: 1.4em;">
                                        View All Our Trips
                                    </a>

                                    <a href="https://api.whatsapp.com/send/?phone=%2B919074460902&text=<?php echo rawurlencode('Your message goes here'); ?>&app_absent=0" target="_blank" class="btn btn-primary rounded-pill py-2 px-4 transparent-background" style="color: #ffffff; background-color: #357bae; font-size: 1.4em;">
                                        <img src="img/whatsapp-logo.png" alt="WhatsApp Logo" style="width: 20px; height: 20px; margin-right: 5px;"> Chat on Whatsapp
                                    </a>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Navbar & Hero End -->


    <!-- Add Bootstrap JS at the end of your HTML body -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Navbar & Hero End -->

    <?php
    // Fetch trending packages from the database
    $trendingSql = "SELECT * FROM PackageDetails WHERE trending = 1";
    $trendingResult = $conn->query($trendingSql);

    $trendingPackages = [];
    while ($row = $trendingResult->fetch_assoc()) {
        // Calculate discount percentage

        $packageID = $row['id'];

        $packagePrice = $row['package_price'];
        $discountPrice = $row['discount_price'];
        $discountPercentage = ($packagePrice - $discountPrice) / $packagePrice * 100;

        // Add the package details along with discount percentage to the array
        $trendingPackages[] = [
            'id' => $packageID,
            'image' => $row['package_image'],
            'discountPercentage' => $discountPercentage,
            'packageName' => $row['package_name'],
            'discount_price' => $discountPrice,
            'package_price' => $packagePrice,
        ];
    }

    ?>

    <!-- Trending Start -->
    <div class="container-xxl py-5 destination">
        <div class="container">
            <div class="text-center wow fadeInUp" data-wow-delay="0.1s">
                <h6 class="section-title bg-white text-center text-primary px-3">TRENDING</h6>
                <h1 class="mb-5">Expert Curated Trips</h1>
            </div>
            <div class="slider-container">
                <div class="slider-wrapper">
                    <?php
                    // Loop through the trending packages array twice to create duplicates
                    foreach (array_merge($trendingPackages, $trendingPackages) as $package) {
                    ?>
                        <div class="col-lg-4 col-md-12 wow zoomIn slider-item" data-wow-delay="0.1s">
                            <div class="destination-card">
                                <a class="position-relative d-block overflow-hidden" href="package_details.php?id=<?php echo $package['id']; ?>">
                                    <img class="img-fluid" src="<?php echo $package['image']; ?>" alt="">
                                </a>
                                <div class="destination-info">
                                    <div class="bg-white text-danger fw-bold py-1 px-2"><?php echo number_format($package['discountPercentage'], 0); ?>% OFF</div>
                                    <div class="bg-white text-primary fw-bold py-1 px-2"><?php echo $package['packageName']; ?></div>
                                    <h3 class="mb-0">₹<?php echo number_format($package['discount_price'], 2); ?></h3>
                                    <h6 class="mb-0"><s>₹<?php echo number_format($package['package_price'], 2); ?></s></h6>
                                </div>
                                <div class="d-flex justify-content-center mb-2">
                                    <a href="contact.php" class="btn btn-sm btn-primary px-3 border-end" style="border-radius: 30px 0 0 30px; font-size: 1.2em;">Contact Us</a>
                                    <a href="https://api.whatsapp.com/send/?phone=%2B919074460902&text&type=phone_number&app_absent=0" target="_blank" class="btn btn-sm btn-primary px-3" style="border-radius: 0 30px 30px 0; font-size: 1.2em;">
                                        <img src="img/whatsapp-logo.png" alt="WhatsApp Logo" style="width: 1.0em; height: 1.0em; margin-right: 5px;">
                                        Chat on Whatsapp
                                    </a>
                                </div>
                            </div>
                        </div>
                    <?php
                    }
                    ?>
                </div>
                <!-- Update the Trending slider-controls section -->
                <div class="slider-controls">
                    <div class="slider-control" onclick="prevTrendingSlide()"><i class="fas fa-chevron-left"></i></div>
                    <div class="slider-control" onclick="nextTrendingSlide()"><i class="fas fa-chevron-right"></i></div>
                </div>
            </div>
        </div>
    </div>
    <!-- Trending End -->



    <!-- Package Start -->
    <div class="container-xxl py-5">
        <div class="container">
            <?php foreach ($categoriesPackages as $category) : ?>
                <div class="text-center wow fadeInUp" data-wow-delay="0.1s">
                    <h6 class="section-title bg-white text-center text-primary px-3"><?php echo $category['category_name']; ?></h6>
                    <h1 class="mb-5">Awesome <?php echo $category['category_name']; ?> Packages</h1>
                </div>
                <div class="row g-4 justify-content-center">
                    <?php
                    // Loop through the query result for each category
                    while ($row = $resultPackages->fetch_assoc()) {
                        // Check if the package belongs to the current category
                        if ($row['category_id'] == $category['id']) {
                            $discountPercentage = ($row['package_price'] - $row['discount_price']) / $row['package_price'] * 100;
                            $packageID = $row['id'];
                    ?>
                            <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.1s">
                                <div class="package-item">
                                    <div class="overflow-hidden">
                                        <a class="position-relative d-block overflow-hidden" href="package_details.php?id=<?php echo $packageID; ?>">
                                            <img class="img-fluid" src="<?php echo $row['package_image']; ?>" alt="" style="width: 400px; height: 300px; object-fit: cover;">
                                        </a>
                                    </div>
                                    <div class="d-flex border-bottom">
                                        <small class="flex-fill text-center border-end py-2"><i class="fa fa-calendar-alt text-primary me-2"></i><?php echo $row['no_of_days']; ?> days</small>
                                        <small class="flex-fill text-center py-2"><i class="fa fa-map-marker-alt text-primary me-2"></i><?php echo $row['locations']; ?></small>
                                    </div>
                                    <div class="text-center p-4">
                                        <div class="bg-white text-success fw-bold py-1 px-2" style="font-size: 20px;"><?php echo $row['package_name']; ?></div>
                                        <div class="bg-white text-danger fw-bold py-1 px-2"><?php echo number_format($discountPercentage, 0) . '% OFF'; ?></div>
                                        <h3 class="mb-0">₹<?php echo number_format($row['discount_price'], 2); ?></h3>
                                        <h6 class="mb-0"><s>₹<?php echo number_format($row['package_price'], 2); ?></s></h6>
                                        <div class="mb-3">
                                            <!-- Star rating can be dynamically added based on a database field -->
                                            <!-- Example: <small class="fa fa-star text-primary"></small> for each star -->
                                        </div>
                                        <div class="d-flex justify-content-center mb-2">
                                            <a href="contact.php" class="btn btn-sm btn-primary px-3 border-end" style="border-radius: 30px 0 0 30px; font-size: 1.2em;">Contact Us</a>
                                            <a href="https://api.whatsapp.com/send/?phone=%2B919074460902&text&type=phone_number&app_absent=0" target="_blank" class="btn btn-sm btn-primary px-3" style="border-radius: 0 30px 30px 0; font-size: 1.2em;">
                                                <img src="img/whatsapp-logo.png" alt="WhatsApp Logo" style="width: 1.0em; height: 1.0em; margin-right: 5px;">
                                                Chat on Whatsapp
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                    <?php
                        }
                    }
                    // Reset the result pointer after each category
                    $resultPackages->data_seek(0);
                    ?>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
    <!-- Package End -->



    <!-- Footer Start -->
    <div class="container-fluid bg-dark text-light footer pt-5 mt-5 wow fadeIn" data-wow-delay="0.1s">
        <div class="container py-5">
            <div class="row g-5">
                <div class="col-lg-3 col-md-6 d-flex justify-content-between align-items-center">
                    <div>
                        <a class="btn btn-link" href="index.php">Home</a>
                        <a class="btn btn-link" href="about.php">About Us</a>
                        <a class="btn btn-link" href="contact.php">Contact Us</a>
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
    <!-- Add this script for the Trending slider -->
    <script>
        let currentIndexTrending = 0;
        const totalItemsTrending = document.querySelectorAll('.destination .slider-item').length / 2; // Divide by 2 to account for duplicates
        const intervalTimeTrending = 3000;
        let trendingInterval;

        function startTrendingSlider() {
            trendingInterval = setInterval(nextTrendingSlide, intervalTimeTrending);
        }

        function stopTrendingSlider() {
            clearInterval(trendingInterval);
        }

        function nextTrendingSlide() {
            currentIndexTrending = (currentIndexTrending + 1) % totalItemsTrending;
            updateTrendingSlider();
        }

        function prevTrendingSlide() {
            currentIndexTrending = (currentIndexTrending - 1 + totalItemsTrending) % totalItemsTrending;
            updateTrendingSlider();
        }

        function updateTrendingSlider() {
            const wrapperTrending = document.querySelector('.destination .slider-wrapper');
            const slideWidthTrending = document.querySelector('.destination .slider-item').offsetWidth;
            const newTransformValueTrending = -currentIndexTrending * slideWidthTrending;
            wrapperTrending.style.transition = 'transform 0.5s ease-in-out'; // Add transition effect
            wrapperTrending.style.transform = `translateX(${newTransformValueTrending}px)`;
        }

        // Automatic sliding for trending slider
        startTrendingSlider();

        // Stop automatic sliding when the user clicks next or previous
        document.querySelector('.destination .slider-controls .slider-control').addEventListener('click', stopTrendingSlider);
    </script>

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

    <!-- Template Javascript -->
    <script src="js/main.js"></script>
</body>

</html>