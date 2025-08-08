<?php
// delete_post.php
require_once '../config/connection.php';

// Always return JSON
header('Content-Type: application/json; charset= utf8mb4');

// Bootstrap your DB connection
require_once '../config/connection.php';

// Throw exceptions on DB errors
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

try {
    // Parse incoming JSON into associative array
    $input   = json_decode(file_get_contents('php://input'), true) ?? [];
    $post_id = $input['post_id'] ?? null;

    // Validate post_id
    if ($post_id === null) {
        http_response_code(400);
        echo json_encode(['error' => 'post_id is required']);
        exit;
    }
    if (filter_var($post_id, FILTER_VALIDATE_INT) === false || (int)$post_id <= 0) {
        http_response_code(400);
        echo json_encode(['error' => 'Invalid post_id']);
        exit;
    }
    $post_id = (int)$post_id;

    // Begin transaction to ensure both deletes succeed or roll back
    $pdo->beginTransaction();

    // 1) Delete all comments for this post
    $stmt = $pdo->prepare("DELETE FROM comments WHERE post_id = :post_id");
    $stmt->execute([':post_id' => $post_id]);

    // 2) Delete the post itself
    $stmt = $pdo->prepare("DELETE FROM posts WHERE id = :post_id");
    $stmt->execute([':post_id' => $post_id]);

    // If no post was deleted, it didn’t exist
    if ($stmt->rowCount() === 0) {
        $pdo->rollBack();
        http_response_code(404);
        echo json_encode(['error' => 'Post not found']);
        exit;
    }

    // Commit the deletes
    $pdo->commit();

    // Success response
    http_response_code(200);
    echo json_encode(['message' => 'Post deleted successfully']);

} catch (PDOException $e) {
    // Roll back if something went wrong in the transaction
    if ($pdo->inTransaction()) {
        $pdo->rollBack();
    }

    http_response_code(500);
    echo json_encode([
        'error'   => 'Database error',
        'message' => $e->getMessage()
    ]);
    exit;
}