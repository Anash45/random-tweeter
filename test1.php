<?php
require "vendor/autoload.php"; // Load Composer's autoloader

use Abraham\TwitterOAuth\TwitterOAuth;

// Your Twitter API credentials
$apiKey = 'vneVnnSDejkyFJNY6t13ZL2zY';
$apiSecretKey = 'KDDKloA4XFIJg90rNL1OA63KUsDJ7WvO0La0d0u0O2gmP4JaSz';
$accessToken = '707955804532559872-WgcY1IlaDeB4Ew7BltLzJVjfUxDTwgY';
$accessTokenSecret = 'EL81OehOAgKIOo7i3qKRGvWrOQYE1kgGimMYUm6j5vVev';

// Authenticate to Twitter
$connection = new TwitterOAuth($apiKey, $apiSecretKey, $accessToken, $accessTokenSecret);

try {
    // Fetch the user's timeline (e.g., the last 5 tweets)
    $tweets = $connection->get("statuses/user_timeline", ["screen_name" => "syedanasbukhari", "count" => 5]);

    if (isset($tweets->errors)) {
        echo "Error fetching tweets: " . $tweets->errors[0]->message;
    } else {
        // Print the Tweet IDs and their texts
        foreach ($tweets as $tweet) {
            echo "Tweet ID: " . $tweet->id_str . " - " . $tweet->text . PHP_EOL;
        }
    }
} catch (Exception $e) {
    echo "An error occurred: " . $e->getMessage();
}
?>
