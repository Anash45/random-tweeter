<?php
require 'vendor/autoload.php'; // Load Composer's autoloader

use Noweh\TwitterApi\Client;

function getTweetDetailsAndRandomRetweeter($bearerToken, $tweetId) {
    // Initialize the Twitter API client with the Bearer Token
    $twitterClient = new Client($bearerToken);

    try {
        // Fetch the tweet's content
        $tweetResponse = $twitterClient->tweet()->show($tweetId)->performRequest();
        $tweetData = json_decode($tweetResponse->getBody(), true);

        if (isset($tweetData['errors'])) {
            return "Error fetching tweet: " . json_encode($tweetData['errors']);
        }

        // Print the tweet's content
        $tweetContent = $tweetData['data']['text'] ?? "No content available";
        echo "Tweet Content: " . $tweetContent . PHP_EOL;

        // Fetch the list of users who retweeted the given tweet
        $retweetersResponse = $twitterClient->tweet()->retweetedBy($tweetId)->performRequest();
        $retweetersData = json_decode($retweetersResponse->getBody(), true);

        if (isset($retweetersData['errors'])) {
            return "Error fetching retweeters: " . json_encode($retweetersData['errors']);
        }

        // Check if there are any retweeters
        if (empty($retweetersData['data'])) {
            return "No retweeters found for the given tweet.";
        }

        // Extract user details
        $users = [];
        foreach ($retweetersData['data'] as $user) {
            $users[] = $user['username'];
        }

        // Print all retweeters
        echo "List of Retweeters: " . PHP_EOL;
        foreach ($users as $username) {
            echo "@$username" . PHP_EOL;
        }

        // Pick a random user from the list
        if (!empty($users)) {
            $randomUser = $users[array_rand($users)];
            echo "The randomly picked retweeter is: @" . $randomUser . PHP_EOL;
        } else {
            return "No valid retweeters found.";
        }

    } catch (Exception $e) {
        return "An error occurred: " . $e->getMessage();
    }
}

// Example usage
$bearerToken = 'AAAAAAAAAAAAAAAAAAAAALizuQEAAAAAqVFFkqwlOvkatfo1ubrKmskHNwM%3Dy68JulrzjLrP51UACFZy4R4xGOirPH7WOomBusewffpipDuflR';
$tweetId = '1350526503755288577'; // Replace with the tweet ID you are interested in

echo getTweetDetailsAndRandomRetweeter($bearerToken, $tweetId);
?>
