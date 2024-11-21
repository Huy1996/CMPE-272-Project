<?php
session_start();

// Check if JWT is stored in the cookie
$jwt = $_COOKIE['auth_token'] ?? null;
$first_name = null;

// Validate the JWT and extract user details
if ($jwt) {
    function validate_jwt($token, $secret_key) {
        list($header, $payload, $signature) = explode('.', $token);
        $decodedPayload = json_decode(base64_decode(str_replace(['-', '_'], ['+', '/'], $payload)), true);

        if ($decodedPayload['exp'] < time()) {
            return false; // Token has expired
        }

        $validSignature = hash_hmac('sha256', "$header.$payload", $secret_key, true);
        $base64ValidSignature = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($validSignature));

        if ($signature !== $base64ValidSignature) {
            return false; // Invalid signature
        }

        return $decodedPayload; // Return the payload if valid
    }

    $secret_key = 'your_secret_key';
    $user = validate_jwt($jwt, $secret_key);

    if ($user) {
        $first_name = $user['first_name']; // Use email or other name field from the payload
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Online Marketplace</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <!-- Header -->
    <header>
        <h1>Online Marketplace</h1>
        <nav>
            <ul>
                <li><a href="index.php">Home</a></li>
                <?php if ($first_name): ?>
                    <li>Welcome, <?php echo htmlspecialchars($first_name); ?></li>
                    <li><a href="logout.php">Logout</a></li>
                <?php else: ?>
                    <li><a href="login.php">Login</a></li>
                <?php endif; ?>
            </ul>
        </nav>
    </header>

    <!-- Main Content -->
    <main>