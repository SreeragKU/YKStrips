<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ensure that the necessary fields are set
    if (isset($_POST["nm"]) && isset($_POST["ph"]) && isset($_POST["sub"]) && isset($_POST["mes"])) {
        $nm = $_POST["nm"];
        $ph = $_POST["ph"];
        $sub = $_POST["sub"];
        $mes = $_POST["mes"];

        // Your WhatsApp number to receive the message
        $yourNumber = "+919207041904"; // Change this to your actual WhatsApp number

        // WhatsApp API URL
        $apiUrl = "https://api.whatsapp.com/send/?phone=$yourNumber";

        // Validate and clean the phone number
        $ph = preg_replace("/[^0-9]/", "", $ph);

        // Check if the phone number starts with a valid country code
        if (preg_match("/^[1-9][0-9]{9,}$/", $ph)) {
            // Build the message with better formatting
            $message = "Name: $nm\nPhone Number: $ph\nSubject: $sub\nMessage: $mes";

            // Encode the message for the URL
            $encodedMessage = urlencode($message);

            // Append the message to the API URL
            $apiUrl .= "&text=$encodedMessage";

            // Redirect to the WhatsApp API URL
            header("Location: $apiUrl");
            exit;
        } else {
            // Invalid phone number, handle accordingly (e.g., display an error message)
            echo "Invalid phone number";
        }
    }
}
?>
