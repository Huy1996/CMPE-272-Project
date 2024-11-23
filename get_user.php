<?php
header('Content-Type: application/json');

try {
    // Database connection
    $conn = new PDO("mysql:host=localhost:3306;dbname=tech_masters", "root", "");
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Check if user_id is provided
    if (!isset($_GET['user_id'])) {
        echo json_encode(['error' => 'User ID is required']);
        http_response_code(400);
        exit();
    }

    $user_id = $_GET['user_id'];

    // Fetch user details
    $stmt = $conn->prepare("SELECT user_id, email, first_name, last_name FROM users WHERE user_id = ?");
    $stmt->execute([$user_id]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        echo json_encode($user);
    } else {
        echo json_encode(['error' => 'User not found']);
        http_response_code(404);
    }
} catch (PDOException $e) {
    echo json_encode(['error' => 'Internal Server Error']);
    http_response_code(500);
}
