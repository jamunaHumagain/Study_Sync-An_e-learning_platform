<?php
require 'vendor/autoload.php'; // Include Google Client Library for PHP

$client = new Google_Client(['client_id' => 115330650967116531057]);  // Specify the CLIENT_ID of the app that accesses the backend
$id_token = $_POST['credential'];

$payload = $client->verifyIdToken($id_token);
if ($payload) {
    $googleId = $payload['sub'];
    $name = $payload['name'];
    $email = $payload['email'];
    $picture = $payload['picture'];

    // Check if user exists in your database, if not, create a new user
    // Assuming you have a PDO connection to your database
    $stmt = $pdo->prepare('SELECT * FROM users WHERE google_id = ?');
    $stmt->execute([$googleId]);
    $user = $stmt->fetch();

    if ($user) {
        // User exists, update user info if necessary
        $stmt = $pdo->prepare('UPDATE users SET name = ?, email = ?, profile_picture = ? WHERE google_id = ?');
        $stmt->execute([$name, $email, $picture, $googleId]);
    } else {
        // User does not exist, create new user
        $stmt = $pdo->prepare('INSERT INTO users (google_id, name, email, profile_picture) VALUES (?, ?, ?, ?)');
        $stmt->execute([$googleId, $name, $email, $picture]);
    }

    // Set session or cookie for user login state
    session_start();
    $_SESSION['user_signed_in'] = true;
    $_SESSION['user_id'] = $googleId;

    echo $googleId; // Return user ID or some identifier to the frontend
} else {
    // Invalid ID token
    echo 'Invalid ID token';
}
