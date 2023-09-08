<?php

$botResponses = [
    "standart response" => "I didn't quite get that.",
    "what is your name?" => "My name is chatbot.",
    "hello there" => "General Kenobi",
 ];

if(isset($_GET["userInput"])){
    $userInput = $_GET["userInput"];

    if(array_key_exists($userInput, $botResponses)){
        $response = $botResponses[$userInput];
        header('location: index.php?botResponse=' . $response . '&' . 'userInput=' . $userInput);
    }else {
        $response = $botResponses["standart response"];
        header('location: index.php?botResponse=' . $response . '&' . 'userInput=' . $userInput);
    } 
}
?>