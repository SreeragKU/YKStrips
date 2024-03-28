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
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Your Title</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css">

    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f8f9fa;
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        .container-fluid {
            padding: 0;
        }

        .category-name-container {
            text-align: center;
            margin-top: 5px;
        }

        .category-name {
            font-size: 8px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .navbar {
            margin-top: 0;
            margin-bottom: 0;
            background-color: transparent;
            color: #ffffff;
            padding: 5px;
            width: 100%;
        }

        .navbar-brand img {
            max-width: 100px;
            max-height: 60px;
        }

        .social-icons {
            display: flex;
            align-items: center;
        }

        .social-icons a {
            margin-right: 10px;
            text-decoration: none;
            color: #000000 !important;
            text-align: center;
            display: flex;
            flex-direction: column;
            align-items: center;
        }


        .social-icons i {
            margin-bottom: 2px;
            font-size: 1.5rem;
        }

        .social-icons span {
            font-size: 0.8rem;
        }

        .category-slider {
            background-color: #ffffff;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
            overflow: hidden;
            margin-top: 10px;
            padding: 5px;
        }

        .slider-cat-container {
            padding: 0px;
        }

        .item {
            padding: 0 2px;
            margin-top: 7px;
        }

        .category-card {
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease-in-out;
            overflow: hidden;
            width: 50px;
            height: 50px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            background-color: #fff;
        }

        .category-card:hover {
            transform: scale(1.1);
        }

        .category-card a {
            text-decoration: none;
            color: #000000;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }

        .container-xxl {
            margin-top: -10px;
        }

        .category-card img {
            max-width: 100%;
            max-height: 100%;
            border-radius: 50%;
            object-fit: cover;
        }

        .category-name {
            font-size: 8px;
            margin-top: 3px;
        }

        .category-name-container {
            text-align: center;
            margin-top: 5px;
        }

        .owl-prev,
        .owl-next {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            font-size: 1.5rem;
            color: #343a40;
            z-index: 1;
        }

        .owl-prev {
            left: 10px;
        }

        .owl-next {
            right: 10px;
        }

        .owl-carousel {
            height: 80px;
            position: relative;
        }

        .btn-primary.active {
            background-color: #007bff !important;
            color: #fff !important;
        }
    </style>

</head>

<body>

    <!-- Tobbar Start -->
    <div class="container-fluid position-relative p-0" style="background-color: white; height: 80px">
        <!-- Wrap logo and social icons in a flex container -->
        <div class="d-flex justify-content-between align-items-center w-100">
            <a href="index.php" class="navbar-brand p-0">
                <img src="img/logo.png" alt="Logo" style="height: 220px; width: 190px; margin-top: 5px;">
            </a>

            <!-- Social Media Icons with Labels -->
            <div class="social-icons">
                <a href="https://www.instagram.com/yks.yathrakarudesrdhakku?igsh=M2tqbTVnNWx1cHEy&utm_source=qr" target="_blank">
                    <i class="fab fa-instagram"></i>
                    <span>YKS trips</span>
                </a>
                <a href="https://www.instagram.com/yks_trip?igsh=cWQxbThhNDRsbTZ5&utm_source=qr" target="_blank">
                    <i class="fab fa-instagram"></i>
                    <span>YKS</span>
                </a>
                <a href="https://youtube.com/@ykshere?si=R3n-6trG0xPv0RFX" target="_blank">
                    <i class="fab fa-youtube"></i>
                    <span>YKS here</span>
                </a>
            </div>
        </div>
        <hr>
    </div>
    <!-- Topbar End -->

    <!-- Category Slider Start for Navigation -->
    <div class="container-xxl py-2 category-slider">
        <nav class="navbar navbar-expand-lg navbar-light px-4 px-lg-5 py-3 py-lg-0">
            <div class="container">
                <div class="owl-carousel owl-theme slider-cat-container">
                    <?php foreach ($categoriesNav as $category) : ?>
                        <div class="item">
                            <div class="col-12 wow zoomIn slider-item" style="text-align: -webkit-center;" data-wow-delay="0.1s">
                                <div class="category-card">
                                    <a href="category_page.php?category_id=<?php echo base64_encode($category['id']); ?>">
                                        <img class="img-fluid" src="<?php echo $category['icon_path']; ?>" alt="Category Icon">
                                    </a>
                                </div>
                                <div class="category-name-container">
                                    <div class="category-name">
                                        <p class="bg-white text--webkit-center text-dark" style="font-size: 10px"><?php echo $category['category_name']; ?></p>
                                    </div>
                                </div>
                            </div>
                        </div>

                    <?php endforeach; ?>
                </div>
            </div>
        </nav>
    </div>
    <div style="display: flex; justify-content: space-around; margin-top: 15px; margin-bottom: 5px">
        <form id="navigationForm" style="display: flex; width: 100%; max-width: 600px;">
            <button type="submit" class="btn btn-primary" id="tripsBtn" data-page="index.php" style="flex: 1; border: 2px solid #007bff; outline: none; cursor: pointer; background-color: #fff; color: #000000; font-size: 16px; border-top-left-radius: 15px; border-bottom-left-radius: 15px; border-right: none; transition: background-color 0.3s;">
                <i class="fas fa-plane"></i> Trips
            </button>
            <button type="submit" class="btn btn-primary" id="visaBtn" data-page="visa_card.php" style="flex: 1; border: 2px solid #007bff; outline: none; cursor: pointer; background-color: #fff; color: #000000; font-size: 16px; border-top-right-radius: 15px; border-bottom-right-radius: 15px; border-left: none; transition: background-color 0.3s;">
                <i class="fas fa-credit-card"></i> Visa
            </button>
        </form>
    </div>



    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>

    <script>
        $(document).ready(function() {
            $(".owl-carousel").owlCarousel({
                items: 5,
                loop: true,
                margin: 10,
                nav: true,
                autoplay: true,
                autoplayTimeout: 1500,
                responsive: {
                    0: {
                        items: 3
                    },
                    600: {
                        items: 5
                    },
                    1000: {
                        items: 10
                    }
                }
            });

            function highlightActiveButton() {
                var currentPage = window.location.pathname.substring(window.location.pathname.lastIndexOf("/") + 1);
                var tripsPages = ["index.php", "category_page.php", "contact.php", "about.php", "package_details.php", "package.php", "thank_you.php"];
                var visaPages = ["visa_card.php", "visa_details.php"];
                var activeButtonId = tripsPages.includes(currentPage) ? "tripsBtn" : "visaBtn";

                $("button.btn-primary").removeClass("active");
                $("#" + activeButtonId).addClass("active");
            }

            // Handle button clicks
            $("#tripsBtn").on("click", function() {
                window.location.href = "index.php";
            });

            $("#visaBtn").on("click", function() {
                window.location.href = "visa_card.php";
            });

            // Handle form submission
            $("#navigationForm").on("submit", function(e) {
                e.preventDefault();
                highlightActiveButton();
            });

            // Initial highlighting
            highlightActiveButton();
        });
    </script>



</body>

</html>