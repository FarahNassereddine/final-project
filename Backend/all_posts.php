<?php
require_once '../config/connection.php';
// Ensure PDO throws exceptions
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
// Always send JSON header first
header('Content-Type: application/json');
// Fetch all posts with their comment counts


try {
    // Build the query to fetch posts and their comment counts
    $sql = "
        SELECT
            posts.*,
            COUNT(comments.id) AS comment_count
        FROM posts
        LEFT JOIN comments
            ON posts.id = comments.post_id
        GROUP BY posts.id
        ORDER BY posts.id DESC
    ";

    // Prepare and execute the statement
    $stmt = $pdo->prepare($sql);
    $stmt->execute();

    // Fetch all results as an associative array
    $posts = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Return JSON response
    header('Content-Type: application/json');
    echo json_encode($posts);

} 
catch (PDOException $e) {
    // Handle any database errors
    http_response_code(500);
    header('Content-Type: application/json');
    echo json_encode([
        'error'   => 'Database query failed',
        'message' => $e->getMessage()
    ]);
    exit;
}