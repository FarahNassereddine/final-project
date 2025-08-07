<?php
require_once '../config/db.php';


try {
    $pdo = new PDO($dsn, $username, $password);

    // Read raw JSON input
    $input = json_decode(file_get_contents('php://input'), true);
    $post_id = $input['id'] ?? $_GET['id'] ?? null;


    if ($post_id === null) {
        echo json_encode(['error' => 'Missing post ID']);
        exit;
    }

    // Query the post
    $stmt = $pdo->prepare('SELECT * FROM posts WHERE id = ?');
    $stmt->execute([$post_id]);
    $post = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$post) {
        echo json_encode(['error' => 'Post not found']);
        exit;
    }

    // Get latest 15 comments for that post
    $stmt = $pdo->prepare('
        SELECT comments.*, users.name AS commenter_name
        FROM comments
        JOIN users ON comments.user_id = users.id
        WHERE post_id = ?
        ORDER BY comments.id DESC
        LIMIT 15
    ');
    $stmt->execute([$post_id]);
    $comments = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Return combined result
    echo json_encode([
        'post' => $post,
        'comments' => $comments
    ]);

} catch (PDOException $e) {
    echo json_encode(['error' => $e->getMessage()]);
}
?>
