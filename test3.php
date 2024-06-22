<?php
require 'vendor/autoload.php'; // Load Composer's autoloader

use Noweh\TwitterApi\Client;

function getRecentTweets($bearerToken, $username, $count = 5) {
    // Initialize the Twitter API client with the Bearer Token
    $twitterClient = new Client($bearerToken);

    try {
        // Fetch the user ID for the given username
        $userResponse = $twitterClient->userLookup()->findByIdOrUsername($username)->performRequest();
        $userData = json_decode($userResponse->getBody(), true);

        if (isset($userData['errors'])) {
            return "Error fetching user: " . json_encode($userData['errors']);
        }

        // Extract user ID
        $userId = $userData['data']['id'];

        // Fetch the recent tweets from the user's timeline
        $tweetsResponse = $twitterClient->timeline()->getRecentTweets($userId)->performRequest();
        
        $tweetsData = json_decode($tweetsResponse->getBody(), true);

        if (isset($tweetsData['errors'])) {
            return "Error fetching tweets: " . json_encode($tweetsData['errors']);
        }

        // Print the recent tweets
        echo "Recent Tweets from @$username:" . PHP_EOL;
        foreach ($tweetsData['data'] as $tweet) {
            echo "[" . $tweet['created_at'] . "] " . $tweet['text'] . PHP_EOL;
        }

    } catch (Exception $e) {
        return "An error occurred: " . $e->getMessage();
    }
}

// Example usage
$bearerToken = 'AAAAAAAAAAAAAAAAAAAAALizuQEAAAAAqVFFkqwlOvkatfo1ubrKmskHNwM%3Dy68JulrzjLrP51UACFZy4R4xGOirPH7WOomBusewffpipDuflR'; // Replace with your actual Bearer Token
$username = 'syedanasbukhari'; // Twitter username of the profile
$count = 5; // Number of recent tweets to fetch

echo getRecentTweets($bearerToken, $username, $count);
?>
