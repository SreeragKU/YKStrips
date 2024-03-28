<?php
include "conn.php";

// Fetch categories for navigation
$categorySql = "SELECT * FROM categories";
$categoryResult = $conn->query($categorySql);

$categoriesNav = [];
while ($row = $categoryResult->fetch_assoc()) {
    $categoriesNav[] = $row;
}

if (isset($_GET['id'])) {
    $packageId = isset($_GET['id']) ? base64_decode($_GET['id']) : null;

    // Fetch package details for the selected package
    $packageSql = "SELECT pd.*, c.category_name FROM packagedetails pd
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

        // Fetch images from the "gallery" table for the carousel
        $gallerySql = "SELECT * FROM gallery WHERE package_id = $packageId";
        $galleryResult = $conn->query($gallerySql);

        // Fetch gallery images into an array
        $galleryImages = [];
        while ($row = $galleryResult->fetch_assoc()) {
            $galleryImages[] = $row['image_name'];
        }

        // Add the selected package image to the gallery images array
        array_unshift($galleryImages);
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick.css" integrity="sha512-wR4oNhLBHf7smjy0K4oqzdWumd+r5/+6QO/vDda76MW5iug4PT7v86FoEkySIJft3XA0Ae6axhIvHrqwm793Nw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick-theme.css" integrity="sha512-6lLUdeQ5uheMFbWm3CP271l14RsX1xtx+J5x2yeIDkkiBpeVTNhTqijME7GgRKKi6hCqovwCoBTlRBEC20M8Mg==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <style>
        .slider-container {
            width: 100%;
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
            margin-right: 5px;
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
        }

        body {
            font-family: 'Heebo', sans-serif;
            color: #333;
        }

        .container-xxl {
            border-radius: 8px;
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

        .img-bod-fluid {
            border-radius: 8px;
            margin-top: 20px;
            max-width: 700px;
            max-height: 650px
        }

        .img-container {
            max-width: 100%;
            overflow: hidden;
        }

        .img-container img {
            width: 50%;
            height: auto;
        }

        .tab-pane {
            padding: 20px 0;
            background-color: #ffffff;
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

        .btn-primary {
            color: #ffffff;
            background-color: #007bff;
            font-size: 1.8em;
        }

        .nav-tabs,
        .tab-content {
            background-color: #ffffff;
            border-radius: 8px;
            padding: 20px;
        }

        .nav-tabs {
            margin-bottom: 0;
        }

        .img-container,
        .map-container {
            border-radius: 8px;
            overflow: hidden;
        }

        .map {
            width: 100%;
            height: 100%;
            border: 0;
        }
    </style>
    <style>
        @media only screen and (max-width: 767px) {
            .social-icons {
                display: none;
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

            .slider-container {
                width: 100%;
                overflow: hidden;
                position: relative;
                margin-left: auto;
                margin-right: auto;
            }

            .slider-item {
                flex: 0 0 auto;
                margin-right: 10px;
                /* Adjust the margin as needed */
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

        .nav-tabs {
            background-color: #ffffff;
            border-radius: 8px;
        }
    </style>

</head>

<body>
    <!-- Navbar & Hero Start -->
    <div style="background-color: white; width: 100%"><?php include "header.php"; ?></div>

    <!-- Package Detail Start -->
    <div class="container-xxl py-5">
        <?php if (isset($selectedPackage)) : ?>
            <div class="text-center wow fadeInUp" data-wow-delay="0.1s" style="margin-top: 20px">
                <h3 class="section-title text-center text-primary px-3" style="background-color: rgba(255, 255, 255, 0.3);"><?php echo $selectedPackage['category_name']; ?></h6>
                    <h1 class="mb-5"><?php echo $selectedPackage['package_name']; ?></h1>
            </div>
            <!-- Slick Slider -->
            <div class="responsive">
                <?php
                // Check if $galleryImages is not empty
                if (!empty($galleryImages)) {
                    foreach ($galleryImages as $index => $image) {
                ?>
                        <div class="slick-slide">
                            <img src="pack_img/<?php echo $image; ?>" alt="Gallery Image <?php echo $index + 1; ?>" style="object-fit: cover; max-height: 600px; margin: 8px; border-radius: 15px;">
                        </div>
                    <?php
                    }
                } else {
                    // Use the first image from $selectedPackage as a placeholder
                    ?>
                    <div class="slick-slide" style="width: 100vw; height: 100vh; display: flex; justify-content: center; align-items: center;">
                        <img src="<?php echo $selectedPackage['package_image']; ?>" alt="Placeholder Image" style="object-fit: contain; max-width: 100%; max-height: 100%; margin: 0 auto;">
                    </div>
                <?php
                }
                ?>
            </div>
            <div class="text-center mt-4">
                <a href="https://api.whatsapp.com/send/?phone=%2B919207041904&text=<?php echo rawurlencode('Your message goes here'); ?>&app_absent=0" target="_blank" class="btn btn-primary rounded-3 py-2 px-4 text-center" style="color: #ffffff; background-color: #007bff; font-size: 1.4em;">
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
                    <div class="tab-content">
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
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>
    </div>
    <!-- Package Detail End -->

    <?php include "footer.php"; ?>

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

    <!-- jQuery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick.js" integrity="sha512-eP8DK17a+MOcKHXC5Yrqzd8WI5WKh6F1TIk5QZ/8Lbv+8ssblcz7oGC8ZmQ/ZSAPa7ZmsCU4e/hcovqR8jfJqA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <script>
        $('.responsive').slick({
            centerMode: true,
            centerPadding: '60px',
            slidesToShow: 3,
            adaptiveHeight: true,
            variableWidth: true,
            autoplay: true,
            autoplaySpeed: 2000,
            responsive: [{
                    breakpoint: 768,
                    settings: {
                        arrows: false,
                        centerMode: true,
                        centerPadding: '40px',
                        slidesToShow: 3
                    }
                },
                {
                    breakpoint: 480,
                    settings: {
                        arrows: false,
                        centerMode: true,
                        centerPadding: '40px',
                        slidesToShow: 1
                    }
                }
            ]
        });
    </script>

</body>

</html>


</body>

</html>