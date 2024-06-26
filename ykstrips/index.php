<?php
include "conn.php";

// Fetch all categories for navigation
$categorySqlNav = "SELECT * FROM categories";
$categoryResultNav = $conn->query($categorySqlNav);

// Fetch categories with at least one package
$categorySqlPackages = "SELECT DISTINCT c.* FROM categories c
                        JOIN packagedetails pd ON c.id = pd.category_id";
$categoryResultPackages = $conn->query($categorySqlPackages);

// Fetch packages with category information
$sqlPackages = "SELECT pd.*, c.category_name FROM packagedetails pd
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

// Fetch images from the database
$sql = "SELECT image_path FROM background_images";
$result = $conn->query($sql);
$images = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $images[] = $row['image_path'];
    }
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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Font Awesome Stylesheet -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>


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
        }

        .logo-img {
            max-width: 100%;
            border-radius: 50%;
            padding: 5px;
            transition: max-width 0.5s ease-in-out;
        }

        .btn-primary {
            color: #ffffff;
            background-color: #007bff;
            font-size: 1.8em;
        }
    </style>
    <style>
        @media only screen and (max-width: 767px) {
            .slider-cat-container {
                width: 100%;
                overflow: hidden;
                position: relative;
                margin-left: auto;
                margin-right: auto;
            }

            .slider-item {
                margin-right: 0;
            }

            .social-icons {
                display: none;
            }

            .container-xxl {
                display: flex;
                flex-direction: row;
                justify-content: space-between;
                align-items: center;
                width: 100%;
            }

            .container {
                width: 100%;
            }

            .logo-img {
                max-width: 100%;
                border-radius: 50%;
                padding: 5px;
                transition: max-width 0.5s ease-in-out;
            }

            .btn-primary {
                font-size: 0.4em;
            }

            .btn-smaller-font {
                font-size: 0.4em;
            }

            .btn {
                width: 100%;
                height: auto;
            }
        }

        @media only screen and (max-width: 767px) {
            .footer .social-icons {
                display: flex;
                justify-content: center;
            }
        }
    </style>
    <style>
        body {
            background-image: url('img/background-2.png');
            background-repeat: repeat;
            background-size: 300px 300px;
            background-position: center center;
        }

        .owl-prev,
        .owl-next {
            display: none !important;
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
    <div style="background-color: white; width: 100%"><?php include "header.php"; ?></div>
    <div id="heroCarousel" class="carousel slide" data-ride="carousel" data-interval="5000">
        <div class="carousel-inner">
            <?php foreach ($images as $key => $image) : ?>
                <div class="carousel-item <?php echo ($key === 0) ? 'active' : ''; ?>">
                    <div class="hero-header" style="background-image: url('<?php echo $image; ?>'); background-size: cover !important;">
                        <div class="container-fluid" style="background-color: transparent !important;">
                            <div class="container py-5">
                                <div class="row justify-content-center py-5">
                                    <div class="col-lg-10 pt-lg-5 mt-lg-5 text-center text-white">
                                        <h1 class="display-3 mb-3 animated slideInDown">GET UPTO</h1>
                                        <p class="fs-4 mb-4 animated slideInDown">50% OFF ON ALL OUR TRIPS</p>
                                        <a href="package.php" class="btn btn-primary rounded-5 py-2 px-4 btn-smaller-font" style="margin-top: 10px;">
                                            View All Our Trips
                                        </a>
                                        <a href="https://api.whatsapp.com/send/?phone=%2B919074460902&text=<?php echo rawurlencode('Your message goes here'); ?>&app_absent=0" target="_blank" class="btn btn-primary rounded-5 py-2 px-4 btn-smaller-font" style="margin-top: 10px;">
                                            <img src="img/whatsapp-logo.png" alt="WhatsApp Logo" style="width: 20px; height: 20px; margin-right: 5px;"> Chat on Whatsapp
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
        <a class="carousel-control-prev" href="#heroCarousel" role="button" data-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
        </a>
        <a class="carousel-control-next" href="#heroCarousel" role="button" data-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
        </a>
    </div>
    <!-- Navbar & Hero End -->


    <?php
    // Fetch trending packages from the database
    $trendingSql = "SELECT * FROM packagedetails WHERE trending = 1";
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
                <h2 class="section-title text-center text-primary px-3" style="margin-top: 30px; margin-bottom: 30px;">TRENDING</h2>
                <h1 class="mb-5">Expert Curated Trips</h1>
            </div>
            <div class="slider-container">
                <div class="slider-wrapper">
                    <?php
                    // Loop through the trending packages array twice to create duplicates
                    foreach (array_merge($trendingPackages, $trendingPackages) as $package) {
                    ?>
                        <div class="col-lg-4 col-md-12 wow zoomIn slider-item" data-wow-delay="0.1s" style="background-color: white; border-radius: 15px; overflow: hidden;">
                            <div class="destination-card">
                                <a style="width: 100%; height: 300px; object-fit: cover; border-radius: 15px 15px 0 0;" class="position-relative d-block overflow-hidden" href="package_details.php?id=<?php echo base64_encode($package['id']); ?>">
                                    <img class="img-fluid" src="<?php echo $package['image']; ?>" alt="">
                                </a>
                                <div class="destination-info">
                                    <div class="bg-white text-success fw-bold py-1 px-2" style="font-size: 25px;"><?php echo $package['packageName']; ?></div>
                                    <div class="bg-white text-danger fw-bold py-1 px-2"><?php echo number_format($package['discountPercentage'], 0); ?>% OFF</div>
                                    <h3 class="mb-0">₹<?php echo number_format($package['discount_price'], 2); ?></h3>
                                    <h6 class="mb-4"><s>₹<?php echo number_format($package['package_price'], 2); ?></s></h6>
                                </div>
                                <!-- ... -->
                                <div class="d-flex justify-content-center mb-2">
                                    <!-- &nbspCall Us button with icon for larger screens -->
                                    <a href="tel:+919074460902" class="btn btn-sm btn-primary px-2 border-end d-none d-md-flex" style="border-radius: 10px; font-size: 1em; background-color: #007bff; margin-right: 10px; margin-left: 10px;">
                                        <i class="fas fa-phone me-1" style="font-size: 0.8em; transform: rotate(90deg); margin-right: 30px;"></i>&nbsp;&nbsp;Call Us
                                    </a>

                                    <!-- WhatsApp button with icon for larger screens -->
                                    <a href="https://api.whatsapp.com/send/?phone=%2B919074460902&text&type=phone_number&app_absent=0" target="_blank" class="btn btn-sm btn-primary px-2 d-none d-md-flex" style="border-radius: 10px; font-size: 1em; background-color: #ffffff; color: #000; margin-right: 10px; transition: background-color 0.3s;" onmouseover="changeBackgroundColor(this, '#d1ffe2')" onmouseout="changeBackgroundColor(this, '#ffffff')">
                                        <img src="img/whatsapp-logo.png" alt="WhatsApp Logo" style="width: 1.2em; height: 1.2em; margin-right: 3px;">Chat on Whatsapp
                                    </a>

                                    <!-- &nbspCall Us icon-only button for smaller screens -->
                                    <a href="tel:+919074460902" class="btn btn-sm btn-primary px-2 border-end d-md-none flex-fill" style="border-radius: 10px; font-size: 1em; background-color: #007bff; margin-right: 10px; margin-left: 10px;">
                                        <i class="fas fa-phone" style="font-size: 0.8em; transform: rotate(90deg);"></i>
                                    </a>

                                    <!-- WhatsApp icon-only button for smaller screens -->
                                    <a href="https://api.whatsapp.com/send/?phone=%2B919074460902&text&type=phone_number&app_absent=0" target="_blank" class="btn btn-sm btn-primary px-2 d-md-none flex-fill" style="border-radius: 10px; font-size: 1em; background-color: #ffffff; color: #000; margin-right: 10px; transition: background-color 0.3s;" onmouseover="changeBackgroundColor(this, '#d1ffe2')" onmouseout="changeBackgroundColor(this, '#ffffff')">
                                        <img src="img/whatsapp-logo.png" alt="WhatsApp Logo" style="width: 1.2em; height: 1.2em;">
                                    </a>
                                </div>

                                <script>
                                    function changeBackgroundColor(element, color) {
                                        element.style.backgroundColor = color;
                                    }
                                </script>
                                <!-- ... -->

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
                    <div>
                        <h1 class="text-left text-primary px-3" style="margin-top: 30px; margin-bottom: 25px;"><?php echo $category['category_name']; ?>
                            <a href="category_page.php?category_id=<?php echo base64_encode($category['id']); ?>" class="btn btn-primary">View All</a>
                        </h1>
                    </div>
                </div>

                <!-- Create carousel for each category -->
                <div id="carousel-<?php echo $category['id']; ?>" class="carousel slide" data-bs-ride="carousel">
                    <div class="carousel-inner">
                        <?php
                        // Counter for packages in each category
                        $packageCounter = 0;

                        // Loop through the query result for each category
                        while ($row = $resultPackages->fetch_assoc()) {
                            // Check if the package belongs to the current category
                            if ($row['category_id'] == $category['id']) {
                                $discountPercentage = ($row['package_price'] - $row['discount_price']) / $row['package_price'] * 100;
                                $packageID = $row['id'];
                                $packageCounter++;

                                // Determine if this package is the first one to be displayed
                                $activeClass = ($packageCounter == 1) ? 'active' : '';
                        ?>
                                <!-- Display package as carousel item -->
                                <div class="carousel-item <?php echo $activeClass; ?>">
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="overflow-hidden">
                                                <a class="position-relative d-block overflow-hidden" href="package_details.php?id=<?php echo base64_encode($packageID); ?>">
                                                    <img class="img-fluid" src="<?php echo $row['package_image']; ?>" alt="" style="width: 100%; height: 300px; object-fit: cover; border-radius: 15px;">
                                                </a>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="text-center" style="background-color: #ffffff; border-radius: 15px; height: 300px;">
                                                <div class="bg-white text-success fw-bold py-1 px-2 py-2" style="font-size: 30px;"><?php echo $row['package_name']; ?></div>
                                                <div class="text-danger fw-bold py-2 mb-2"><?php echo number_format($discountPercentage, 0) . '% OFF'; ?></div>
                                                <div class="price-container">
                                                    <h3 class="mb-2">₹<?php echo number_format($row['discount_price'], 2); ?></h3>
                                                    <h6 class="mb-"><s>₹<?php echo number_format($row['package_price'], 2); ?></s></h6>
                                                </div>
                                                <!-- ... -->
                                                <div class="d-flex justify-content-center mb-2">
                                                    <!-- &nbspCall Us button with icon for larger screens -->
                                                    <a href="tel:+919207041904" class="btn btn-sm btn-primary px-2 border-end d-none d-md-flex" style="border-radius: 10px; font-size: 1em; background-color: #007bff; margin-right: 10px; margin-left: 10px;">
                                                        <i class="fas fa-phone me-1" style="font-size: 0.8em; transform: rotate(90deg); margin-right: 30px;"></i>&nbsp;&nbsp;Call Us
                                                    </a>

                                                    <!-- WhatsApp button with icon for larger screens -->
                                                    <a href="https://api.whatsapp.com/send/?phone=%2B919207041904&text&type=phone_number&app_absent=0" target="_blank" class="btn btn-sm btn-primary px-2 d-none d-md-flex" style="border-radius: 10px; font-size: 1em; background-color: #ffffff; color: #000; margin-right: 10px; transition: background-color 0.3s;" onmouseover="changeBackgroundColor(this, '#d1ffe2')" onmouseout="changeBackgroundColor(this, '#ffffff')">
                                                        <img src="img/whatsapp-logo.png" alt="WhatsApp Logo" style="width: 1.2em; height: 1.2em; margin-right: 3px;">Chat on Whatsapp
                                                    </a>

                                                    <!-- &nbspCall Us icon-only button for smaller screens -->
                                                    <a href="tel:+919207041904" class="btn btn-sm btn-primary px-2 border-end d-md-none flex-fill" style="border-radius: 10px; font-size: 1em; background-color: #007bff; margin-right: 10px; margin-left: 10px;">
                                                        <i class="fas fa-phone" style="font-size: 0.8em; transform: rotate(90deg);"></i>
                                                    </a>

                                                    <!-- WhatsApp icon-only button for smaller screens -->
                                                    <a href="https://api.whatsapp.com/send/?phone=%2B919207041904&text&type=phone_number&app_absent=0" target="_blank" class="btn btn-sm btn-primary px-2 d-md-none flex-fill" style="border-radius: 10px; font-size: 1em; background-color: #ffffff; color: #000; margin-right: 10px; transition: background-color 0.3s;" onmouseover="changeBackgroundColor(this, '#d1ffe2')" onmouseout="changeBackgroundColor(this, '#ffffff')">
                                                        <img src="img/whatsapp-logo.png" alt="WhatsApp Logo" style="width: 1.2em; height: 1.2em;">
                                                    </a>
                                                </div>

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

                    <!-- Carousel controls -->
                    <button class="carousel-control-prev" type="button" data-bs-target="#carousel-<?php echo $category['id']; ?>" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Previous</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#carousel-<?php echo $category['id']; ?>" data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Next</span>
                    </button>
                </div>

            <?php endforeach; ?>
        </div>
    </div>
    <!-- Package End -->





    <?php include "footer.php"; ?>


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

    <!-- Template Javascript -->
    <script src="js/main.js"></script>
</body>

</html>