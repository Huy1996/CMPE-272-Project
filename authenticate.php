<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $redirect = $_POST['redirect'] ?? 'index.php'; // Default to index.php if no redirect is specified

    try {
        // Database connection
        $conn = new PDO("mysql:host=localhost:3306;dbname=tech_masters", "root", "");
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Check user credentials
        $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['password'])) {
            // Generate JWT
            $header = json_encode(['alg' => 'HS256', 'typ' => 'JWT']);
            $payload = json_encode([
                'first_name' => $user['first_name'],
                'last_name' => $user['last_name'],
                'user_id' => $user['id'],
                'email' => $user['email'],
                'exp' => time() + 3600 // Token expires in 1 hour
            ]);
            $base64Header = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($header));
            $base64Payload = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($payload));
            $signature = hash_hmac('sha256', "$base64Header.$base64Payload", 'your_secret_key', true);
            $base64Signature = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($signature));
            $jwt = "$base64Header.$base64Payload.$base64Signature";

            // Store JWT in a cookie
            setcookie("auth_token", $jwt, time() + 3600, "/", "", true, true); // Secure and HTTP-only

            // Redirect to the child company with the JWT
            $redirectWithToken = $redirect . (strpos($redirect, '?') !== false ? '&' : '?') . "token=" . urlencode($jwt);
            header("Location: $redirectWithToken");
            exit();
        } else {
            echo "Invalid credentials.";
        }
    } catch (PDOException $e) {
        die("Error: " . $e->getMessage());
    }
}
?>
