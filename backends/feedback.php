<?php
header('Content-Type: application/json; charset=utf-8');
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method']);
    exit;
}

require_once __DIR__ . '/connection-pdo.php';

$name = isset($_POST['name']) ? trim($_POST['name']) : '';
$email = isset($_POST['email']) ? trim($_POST['email']) : '';
$rating = isset($_POST['rating']) && $_POST['rating'] !== '' ? (int)$_POST['rating'] : null;
$message = isset($_POST['message']) ? trim($_POST['message']) : '';

if ($name === '' || $email === '' || $message === '') {
    echo json_encode(['status' => 'error', 'message' => 'Please provide name, email and message']);
    exit;
}

// Basic email validation
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo json_encode(['status' => 'error', 'message' => 'Invalid email address']);
    exit;
}

// Create feedback table if it doesn't exist (safe to run)
try {
    $pdoconn->exec("CREATE TABLE IF NOT EXISTS feedback (
        id INT AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(100) NOT NULL,
        email VARCHAR(150) NOT NULL,
        rating TINYINT NULL,
        message TEXT NOT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    ) ");
} catch (Exception $e) {
    // ignore - table create is best-effort
}

try {
    $stmt = $pdoconn->prepare('INSERT INTO feedback (name, email, rating, message) VALUES (:name, :email, :rating, :message)');
    $stmt->bindParam(':name', $name);
    $stmt->bindParam(':email', $email);
    if ($rating === null) {
        $stmt->bindValue(':rating', null, PDO::PARAM_NULL);
    } else {
        $stmt->bindParam(':rating', $rating, PDO::PARAM_INT);
    }
    $stmt->bindParam(':message', $message);
    $stmt->execute();

    echo json_encode(['status' => 'success', 'message' => 'Thank you for your feedback']);
    exit;
} catch (Exception $e) {
    echo json_encode(['status' => 'error', 'message' => 'Unable to save feedback']);
    exit;
}

?>
