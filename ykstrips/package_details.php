<?php
include "conn.php";

$categorySql = "SELECT * FROM categories";
$categoryResult = $conn->query($categorySql);

$categoriesNav = [];
while ($row = $categoryResult->fetch_assoc()) {
    $categoriesNav[] = $row;
}
// Fetch the categories into an array
$categories = [];
while ($row = $categoryResult->fetch_assoc()) {
    $categories[] = $row;
}

// Check if package ID is provided in the URL
if (isset($_GET['id'])) {
    $packageId = $_GET['id'];

    // Fetch package details for the selected package
    $packageSql = "SELECT pd.*, c.category_name FROM PackageDetails pd
                   JOIN categories c ON pd.category_id = c.id
                   WHERE pd.id = $packageId";
    $packageResult = $conn->query($packageSql);

    // Fetch the selected package into an array
    $selectedPackage = $packageResult->fetch_assoc();

    // Check if $selectedPackage is not empty
    if ($selectedPackage) {
        // Calculate discount percentage
        $discountPercentage = (($selectedPackage['package_price'] - $selectedPackage['discount_price']) / $selectedPackage['package_price']) * 100;

        // Unserialize the itinerary and FAQs
        $itinerary = unserialize($selectedPackage["itinerary"]);
        $faqs = unserialize($selectedPackage["faqs"]);
    }
}

$debugMode = true;
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>YKS TRIP</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">

    <!-- Favicon -->
    <link href="img/favicon.ico" rel="icon">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Heebo:wght@400;500;600&family=Nunito:wght@600;700;800&display=swap" rel="stylesheet">

    <!-- Icon Font Stylesheet -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.14.0/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="lib/animate/animate.min.css" rel="stylesheet">
    <link href="lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">
    <link href="lib/tempusdominus/css/tempusdominus-bootstrap-4.min.css" rel="stylesheet">

    <!-- Customized Bootstrap Stylesheet -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Template Stylesheet -->
    <link href="css/style.css" rel="stylesheet">
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
        .social-icons {
            display: flex;
            align-items: center;
            margin-left: auto;
            gap: 15px;
        }

        .social-icons a {
            font-size: 25px;
            color: white;
        }

        .slider-wrapper {
            display: flex;
            transition: transform 0.5s ease-in-out;
        }

        .slider-item {
            flex: 0 0 auto;
            margin-right: 20px;
        }


        .destination-card {
            width: 100%;
            margin-right: 20px;
            overflow: hidden;
        }


        .destination-card img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .destination-info {
            padding: 10px;
            background: #fff;
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
            padding: 10px;
        }

        .category-card img {
            max-width: 50px;
            /* Adjust icon size */
            max-height: 50px;
            object-fit: contain;
        }

        body {
            font-family: 'Heebo', sans-serif;
            color: #333;
        }

        nav.navbar {
            background-color: #fff;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        nav.navbar img {
            max-height: 40px;
        }

        .container-xxl {
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            padding: 30px;
        }

        .section-title {
            background-color: #007bff;
            color: #fff;
            display: inline-block;
            padding: 5px 15px;
            border-radius: 4px;
        }

        h1 {
            font-size: 36px;
            margin-bottom: 20px;
            color: #333;
        }

        .img-fluid {
            border-radius: 8px;
            margin-top: 20px;
            max-width:700px;
            max-height: 650px;

        }

        .nav-tabs {
            border-bottom: 2px solid #007bff;
            margin-top: 20px;
        }

        .nav-tabs .nav-link {
            border: 1px solid #ddd;
            border-radius: 4px 4px 0 0;
            color: #333;
            background-color: #f9f9f9;
        }

        .nav-tabs .nav-link.active {
            color: #fff;
            background-color: #007bff;
            border-color: #007bff;
        }

        .tab-pane {
            padding: 20px 0;
        }

        .timeline {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .timeline-item {
            margin-bottom: 20px;
        }

        .timeline-marker {
            background-color: #007bff;
            border-radius: 50%;
            width: 16px;
            height: 16px;
            margin-right: 15px;
            position: absolute;
            left: -8px;
            top: 50%;
            transform: translateY(-50%);
        }

        .timeline-content {
            margin-left: 30px;
        }

        .map-container {
            position: relative;
            width: 100%;
            padding-bottom: 75%;
            border-radius: 8px;
            margin-top: 20px;
            overflow: hidden;
        }

        .map {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            border-radius: 8px;
        }

        .footer {
            background-color: #343a40;
            color: #fff;
            padding: 30px 0;
            margin-top: 50px;
        }

        .back-to-top {
            position: fixed;
            bottom: 20px;
            right: 20px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 50%;
            padding: 10px 15px;
            font-size: 20px;
            cursor: pointer;
        }
    </style>
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

        <script>
            let currentIndexCategory = 0;
            let categoryInterval;

            function startCategorySlider() {
                categoryInterval = setInterval(nextCategorySlide, intervalTime);
            }

            function stopCategorySlider() {
                clearInterval(categoryInterval);
            }

            function nextCategorySlide() {
                currentIndexCategory = (currentIndexCategory + 1) % document.querySelectorAll('.category-slider .slider-item').length;
                updateCategorySlider();
            }

            function prevCategorySlide() {
                currentIndexCategory = (currentIndexCategory - 1 + document.querySelectorAll('.category-slider .slider-item').length) % document.querySelectorAll('.category-slider .slider-item').length;
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
        if (count($categories) > 3) {
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

        <!-- Package Detail Start -->
        <div class="container-xxl py-5">
            <?php if (isset($selectedPackage)) : ?>
                <div class="text-center wow fadeInUp" data-wow-delay="0.1s" style="margin-top: 120px">
                    <h6 class="section-title bg-white text-center text-primary px-3"><?php echo $selectedPackage['category_name']; ?></h6>
                    <h1 class="mb-5">Discover the <?php echo $selectedPackage['category_name']; ?> Experience</h1>
                </div>
                <div class="overflow-hidden text-center">
    <div class="img-container">
        <img class="img-fluid" src="<?php echo $selectedPackage['package_image']; ?>" alt="Package Image">
    </div>
</div>


                <div class="text-center mt-4">
                    <a href="package.php" class="btn btn-primary rounded-pill py-2 px-4 text-center" style="color: #ffffff; background-color: #357bae; font-size: 1.4em;">
                        View All Our Trips
                    </a>

                    <a href="https://api.whatsapp.com/send/?phone=%2B919074460902&text=<?php echo rawurlencode('Your message goes here'); ?>&app_absent=0" target="_blank" class="btn btn-primary rounded-pill py-2 px-4 text-center" style="color: #ffffff; background-color: #357bae; font-size: 1.4em;">
                        <img src="img/whatsapp-logo.png" alt="WhatsApp Logo" style="width: 20px; height: 20px; margin-right: 5px;"> Chat on Whatsapp
                    </a>
                </div>
                <!-- Tabs Section -->
                <div class="row mt-5">
                    <div class="col-lg-12">
                        <ul class="nav nav-tabs" id="packageTabs" role="tablist">
                            <li class="nav-item" role="presentation">
                                <a class="nav-link active" id="general-tab" data-bs-toggle="tab" href="#general" role="tab" aria-controls="general" aria-selected="true">General</a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a class="nav-link" id="itinerary-tab" data-bs-toggle="tab" href="#itinerary" role="tab" aria-controls="itinerary" aria-selected="false">Itinerary</a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a class="nav-link" id="cost-tab" data-bs-toggle="tab" href="#cost" role="tab" aria-controls="cost" aria-selected="false">Cost</a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a class="nav-link" id="faq-tab" data-bs-toggle="tab" href="#faq" role="tab" aria-controls="faq" aria-selected="false">FAQ</a>
                            </li>
                        </ul>
                        <div class="tab-content mt-3">
                            <!-- General Tab -->
                            <div class="tab-pane fade show active" id="general" role="tabpanel" aria-labelledby="general-tab">
                                <h2 class="mb-4">Package Overview</h2>
                                <p><strong><i class="fas fa-map-marker-alt"></i> Location:</strong> <?php echo $selectedPackage['locations']; ?></p>
                                <p><strong><i class="far fa-calendar"></i> No of Days:</strong> <?php echo $selectedPackage['no_of_days']; ?> days</p>
                                <p><strong><i class="fas fa-home"></i> Accommodation:</strong> <?php echo $selectedPackage['accommodation']; ?></p>
                                <p><strong><i class="fas fa-utensils"></i> Meals:</strong> <?php echo $selectedPackage['meals']; ?></p>
                                <p><strong><i class="fas fa-car"></i> Transportation:</strong> <?php echo $selectedPackage['transportation']; ?></p>

                                <h2 class="mb-4">Package Highlights</h2>
                                <?php
                                $highlights = explode(',', $selectedPackage['highlight']);
                                foreach ($highlights as $highlight) {
                                    echo "<p><i class='fas fa-star text-warning'></i> $highlight</p>";
                                }
                                ?>
                            </div>


                            <!-- Itinerary Tab -->
                            <div class="tab-pane fade" id="itinerary" role="tabpanel" aria-labelledby="itinerary-tab">
                                <h2 class="mb-4">Itinerary</h2>
                                <?php if (!empty($itinerary)) : ?>
                                    <div class="timeline">
                                        <?php $dayCount = 1; ?>
                                        <?php foreach ($itinerary as $day) : ?>
                                            <div class="timeline-item">
                                                <div class="timeline-marker"></div>
                                                <div class="timeline-content">
                                                    <p>
                                                        <strong>
                                                            <i class="fa fa-clock"></i>
                                                            Day <?php echo $dayCount++; ?>:
                                                        </strong>
                                                        <?php echo $day['title']; ?>
                                                    </p>
                                                    <?php
                                                    $itineraryDescriptions = explode(',', $day['description']);
                                                    foreach ($itineraryDescriptions as $description) {
                                                        echo "<p>$description</p>";
                                                    }
                                                    ?>
                                                </div>
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                <?php else : ?>
                                    <p>No itinerary available.</p>
                                <?php endif; ?>
                            </div>

                            <!-- Cost Tab -->
                            <div class="tab-pane fade" id="cost" role="tabpanel" aria-labelledby="cost-tab">
                                <h2 class="mb-4">Cost Includes</h2>
                                <?php
                                $costIncludes = explode(',', $selectedPackage['cost_includes']);
                                foreach ($costIncludes as $include) {
                                    echo "<p><i class='fas fa-check-circle text-success'></i> $include</p>";
                                }
                                ?>

                                <h2 class="mb-4">Cost Excludes</h2>
                                <?php
                                $costExcludes = explode(',', $selectedPackage['cost_excludes']);
                                foreach ($costExcludes as $exclude) {
                                    echo "<p><i class='fas fa-times-circle text-danger'></i> $exclude</p>";
                                }
                                ?>
                            </div>




                            <!-- FAQ Tab -->
                            <div class="tab-pane fade" id="faq" role="tabpanel" aria-labelledby="faq-tab">
                                <h2 class="mb-4">FAQs</h2>
                                <?php if (!empty($faqs)) : ?>
                                    <ul class="list-group">
                                        <?php foreach ($faqs as $index => $faq) : ?>
                                            <li class="list-group-item">
                                                <div class="faq-question">
                                                    <i class="fas fa-chevron-down"></i> <!-- Arrow icon -->
                                                    <strong><?php echo $faq['question']; ?></strong>
                                                </div>
                                                <div class="faq-answer" style="display: none;">
                                                    <p><?php echo $faq['answer']; ?></p>
                                                </div>
                                            </li>
                                        <?php endforeach; ?>
                                    </ul>
                                <?php else : ?>
                                    <p>No FAQs available.</p>
                                <?php endif; ?>
                            </div>

                            <script>
                                document.addEventListener("DOMContentLoaded", function() {
                                    var faqQuestions = document.querySelectorAll('.faq-question');

                                    faqQuestions.forEach(function(question, index) {
                                        question.addEventListener('click', function() {
                                            var answer = this.nextElementSibling; // Get the next sibling, which is the answer div

                                            if (answer.style.display === 'block') {
                                                answer.style.display = 'none';
                                                question.querySelector('i').classList.remove('fa-chevron-up');
                                                question.querySelector('i').classList.add('fa-chevron-down');
                                            } else {
                                                answer.style.display = 'block';
                                                question.querySelector('i').classList.remove('fa-chevron-down');
                                                question.querySelector('i').classList.add('fa-chevron-up');
                                            }
                                        });
                                    });
                                });
                            </script>
                            <!-- Map Tab -->
                            <div class="container">

                                <?php if (!empty($selectedPackage['map_link'])) : ?>
                                    <?php if ($debugMode) : ?>
                                        <?php ob_start(); // Start output buffering 
                                        ?>
                                        <?php var_dump($selectedPackage['map_link']); ?>
                                        <?php $varDumpOutput = ob_get_clean(); // Capture and clean the output 
                                        ?>
                                        <pre><?php echo str_replace('"', '', preg_replace('/\w+\(\d+\) /', '', $varDumpOutput)); ?></pre>
                                    <?php endif; ?>

                                    <!-- Map Container -->
                                    <div class="map-container">

                                        <iframe class="map" src="<?php echo $selectedPackage['map_link']; ?>" frameborder="0" allowfullscreen></iframe>
                                    </div>

                                <?php else : ?>
                                    <p>No map link available.</p>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
    <!-- Package Detail End -->

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
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
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
</body>

</html>