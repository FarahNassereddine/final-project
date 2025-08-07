<?php
header('Content-Type: application/json');

require_once '../config/db.php';

// Ensure PDO throws exceptions
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// Always send JSON header first
header('Content-Type: application/json');

try {
    // Decode incoming JSON
    $input = file_get_contents('php://input');
    $data  = json_decode($input, true);

    // Validate required fields
    if (
        !isset($data['comment_id']) ||
        !isset($data['content'])
    ) {
        http_response_code(400);
        echo json_encode(['error' => 'comment_id and content are required']);
        exit;
    }

    // Sanitize and cast values
    $comment_id = intval($data['comment_id']);
    $content    = trim($data['content']);

    if ($comment_id <= 0 || $content === '') {
        http_response_code(400);
        echo json_encode(['error' => 'Invalid comment_id or empty content']);
        exit;
    }

    // Prepare and execute the update
    $stmt = $pdo->prepare("
        UPDATE comments
        SET content = :content
        WHERE id = :id
    ");
    $stmt->execute([
        ':content' => $content,
        ':id'      => $comment_id,
    ]);

    // No rows affected → nothing to update or wrong ID
    if ($stmt->rowCount() === 0) {
        http_response_code(404);
        echo json_encode(['error' => 'Comment not found or no changes made']);
        exit;
    }

    // Success
    http_response_code(200);
    echo json_encode(['message' => 'Comment updated successfully']);

} catch (PDOException $e) {
    // Database failure
    http_response_code(500);
    echo json_encode([
        'error'   => 'Database error',
        'message' => $e->getMessage()
    ]);
    exit;
}