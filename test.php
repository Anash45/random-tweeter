<?php
require "vendor/autoload.php"; // Load Composer's autoloader

use Abraham\TwitterOAuth\TwitterOAuth;

function pickRandomRetweeter($apiKey, $apiSecretKey, $accessToken, $accessTokenSecret, $tweetId) {
    // Authenticate to Twitter using Access Token and Secret
    $connection = new TwitterOAuth($apiKey, $apiSecretKey, $accessToken, $accessTokenSecret);

    try {
        // Fetch the list of user IDs who retweeted the given tweet
        $retweeters = $connection->get("statuses/retweeters/ids", ["id" => $tweetId, "count" => 100]);

        // Check for errors
        if (isset($retweeters->errors)) {
            return "Error fetching retweeters: " . $retweeters->errors[0]->message;
        }

        // Check if there are any retweeters
        if (!isset($retweeters->ids) || count($retweeters->ids) === 0) {
            return "No retweeters found for the given tweet.";
        }

        // Fetch user details for each retweeter ID
        $users = [];
        foreach ($retweeters->ids as $userId) {
            $user = $connection->get("users/show", ["user_id" => $userId]);
            if (isset($user->screen_name)) {
                $users[] = $user->screen_name;
            }
        }

        // Pick a random user from the list
        if (!empty($users)) {
            $randomUser = $users[array_rand($users)];
            return "The randomly picked retweeter is: @" . $randomUser;
        } else {
            return "No valid retweeters found.";
        }

    } catch (Exception $e) {
        return "An error occurred: " . $e->getMessage();
    }
}

// Example usage
$apiKey = 'vneVnnSDejkyFJNY6t13ZL2zY';
$apiSecretKey = 'KDDKloA4XFIJg90rNL1OA63KUsDJ7WvO0La0d0u0O2gmP4JaSz';
$accessToken = '707955804532559872-WgcY1IlaDeB4Ew7BltLzJVjfUxDTwgY';
$accessTokenSecret = 'EL81OehOAgKIOo7i3qKRGvWrOQYE1kgGimMYUm6j5vVev';
$tweetId = '1788158875142688803'; // Replace with the tweet ID you are interested in

echo pickRandomRetweeter($apiKey, $apiSecretKey, $accessToken, $accessTokenSecret, $tweetId);
?>


<!-- Bearer Token -->
<!-- AAAAAAAAAAAAAAAAAAAAALizuQEAAAAAqVFFkqwlOvkatfo1ubrKmskHNwM%3Dy68JulrzjLrP51UACFZy4R4xGOirPH7WOomBusewffpipDuflR -->

<!-- Access Token
707955804532559872-WgcY1IlaDeB4Ew7BltLzJVjfUxDTwgY

Access Token Secret
EL81OehOAgKIOo7i3qKRGvWrOQYE1kgGimMYUm6j5vVev

Api Key
vneVnnSDejkyFJNY6t13ZL2zY

Api Secret Key
KDDKloA4XFIJg90rNL1OA63KUsDJ7WvO0La0d0u0O2gmP4JaSz
-->