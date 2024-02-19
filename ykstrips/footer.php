<!DOCTYPE html>

<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Your Website Title</title>
    <meta name="description" content="Your website description">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <style>
        /* Add your custom styles here */
        body {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Arial', sans-serif;
        }

        .container-fluid.bg-dark {
            background-color: #333;
        }

        .footer {
            color: white !important;
            text-align: center;
            padding: 30px 0;
        }

        .footer a {
            color: white !important;
            text-decoration: none;
            margin: 0 15px;
            display: block;
        }

        .footer a:hover {
            text-decoration: underline;
        }

        .social-foot-icons {
            display: flex;
            justify-content: center;
            align-items: center;
            margin-top: 20px;
            color: white !important;
        }

        .social-foot-icons a {
            text-align: center;
            display: flex;
            flex-direction: column;
            align-items: center;
            margin: 0 15px;
            color: white !important;
            text-decoration: none;
        }

        .social-foot-icons i {
            color: white !important;
            margin-bottom: 2px;
            font-size: 20px;
        }

        .copyright {
            margin-top: 20px;
            font-size: 12px;
        }
    </style>
</head>

<body>
    <!-- Footer Start -->
    <div class="container-fluid bg-dark text-light footer">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6 col-md-6 mb-4 mb-lg-0">
                    <div class="mb-3">
                        <a class="btn btn-link" href="index.php">Home</a>
                        <a class="btn btn-link" href="about.php">About Us</a>
                        <a class="btn btn-link" href="contact.php">Contact Us</a>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 mb-4 mb-lg-0 d-flex justify-content-end">
                    <img src="img/logo.png" alt="Logo" style="max-width: 100px; height: auto;">
                </div>
                <!-- Social Media Icons with Labels -->
                <div class="col-lg-3 col-md-6 mb-4 mb-lg-0 social-foot-icons">
                    <a href="https://www.instagram.com/yks.yathrakarudesrdhakku?igsh=M2tqbTVnNWx1cHEy&utm_source=qr" target="_blank" >
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
            <div class="row">
                <div class="col-12 text-center">
                    <div class="copyright">
                        &copy; 2024 YKS Trips. All Rights Reserved.
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Footer End -->

    <script src="" async defer></script>
</body>

</html>
