<h2>Guzzle Lib</h2>
<?php
require 'vendor/autoload.php'; // Load Composer's autoloader

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

function getTweetDetailsAndRandomRetweeter($bearerToken, $tweetId) {
    $client = new Client([
        'base_uri' => 'https://api.twitter.com/2/',
        'headers' => [
            'Authorization' => "Bearer $bearerToken",
            'Accept'        => 'application/json',
        ],
    ]);

    try {
        // Fetch the tweet's content
        $tweetResponse = $client->get("tweets/$tweetId");
        $tweet = json_decode($tweetResponse->getBody(), true);

        // Check if tweet data is available
        if (!isset($tweet['data']['text'])) {
            return "No content available for the given tweet ID.";
        }

        // Print the tweet's content
        $tweetContent = $tweet['data']['text'];
        echo "Tweet Content: " . $tweetContent . PHP_EOL;

        // Fetch the list of user IDs who retweeted the given tweet
        $retweetersResponse = $client->get("tweets/$tweetId/retweeted_by");
        $retweeters = json_decode($retweetersResponse->getBody(), true);

        // Check if there are any retweeters
        if (!isset($retweeters['data']) || count($retweeters['data']) === 0) {
            return "No retweeters found for the given tweet.";
        }

        // Collect retweeters' usernames
        $users = [];
        foreach ($retweeters['data'] as $user) {
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

    } catch (RequestException $e) {
        return "An error occurred: " . $e->getMessage();
    }
}

// Example usage
$bearerToken = 'AAAAAAAAAAAAAAAAAAAAALizuQEAAAAAqVFFkqwlOvkatfo1ubrKmskHNwM%3Dy68JulrzjLrP51UACFZy4R4xGOirPH7WOomBusewffpipDuflR';
$tweetId = '1350526503755288577'; // Replace with the tweet ID as a string

echo getTweetDetailsAndRandomRetweeter($bearerToken, $tweetId);
?>
