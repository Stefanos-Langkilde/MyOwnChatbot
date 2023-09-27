<?php
    session_start();

    function fetchBotResponse(){
        // Replace this URL with your own JSON API endpoint
        $api_url = 'messages.json';

        // Fetch the bot's response from the API
        $response = file_get_contents($api_url);

        return json_decode($response, true);
    }

    function getBotresponseFromJson($jsonData, $user_input){
        $jsonResponse = $jsonData['responses'];
        foreach ($jsonResponse as $key => $value) {
            if (strtolower($key) == strtolower($user_input)) {
                return $value;
            }
        }
        return "Could not find a response for that input.";
    }

    // Handle user input
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $data = json_decode(trim(file_get_contents("php://input")));
        if (isset($data->user_input)) {
            $user_input = $data->user_input;
            $bot_response = fetchBotResponse();
            $response = getBotresponseFromJson($bot_response, $user_input);
            $_SESSION['chat_history'][] = ['user' => $user_input, 'bot' => $response];

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

