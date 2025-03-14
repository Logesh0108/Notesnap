<?php
require_once 'vendor/autoload.php'; // Include the Composer autoload file

// Start a session
session_start();

// Create a Google client
$client = new Google_Client();
$client->setClientId('YOUR_CLIENT_ID'); // Replace with your actual client ID
$client->setClientSecret('YOUR_CLIENT_SECRET'); // Replace with your actual client secret
$client->setRedirectUri('http://localhost/google-login/callback.php'); // Replace with your redirect URI
$client->addScope('email');
$client->addScope('profile');

// Generate the URL for the Google OAuth consent screen
$loginUrl = $client->createAuthUrl();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login with Google</title>
</head>
<body>
    <h2>Login with Google</h2>
    <a href="<?php echo $loginUrl; ?>">Continue with Gmail</a>
</body>
</html>
