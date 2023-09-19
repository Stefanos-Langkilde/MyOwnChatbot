<?php
    session_start();

    function fetchBotResponse($user_input){
        // Replace this URL with your own JSON API endpoint
        $api_url = 'testMessages.json?responses=' . urlencode($user_input);

        // Fetch the bot's response from the API
        $response = file_get_contents($api_url);
        return json_decode($response, true);
    }

    // Handle user input
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        if (isset($_POST['user_input'])) {
            $user_input = $_POST['user_input'];
            $bot_response = fetchBotResponse($user_input);

            $_SESSION['chat_history'][] = ['user' => $user_input, 'bot' => $bot_response['response']];

            // Return the bot's response to the client in JSON format
            echo json_encode(['response' => $response]);
            exit();
        }
    }

    if (isset($_SESSION['chat_history']) && is_array($_SESSION['chat_history'])){
        echo json_encode(['chatHistory' => $_SESSION['chat_history']]);
    } else {
        echo json_encode(['chatHistory' => []]);
    }
?>

