<?php
// Return JSON for all responses
header('Content-Type: application/json; charset=utf-8');

try {
    // Database connection
    $dsn      = 'mysql:host=localhost;dbname=backend_blog_api;charset=utf8';
    $username = 'farah';
    $password = '707788FndAy';
    $pdo      = new PDO($dsn, $username, $password, [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ]);

    // Parse JSON body or fallback to query string
    $input   = json_decode(file_get_contents('php://input'), true) ?? [];
    $user_id = $input['id'] ?? $_GET['id'] ?? null;

    // Validate user_id
    if ($user_id === null || filter_var($user_id, FILTER_VALIDATE_INT) === false) {
        http_response_code(400);
        echo json_encode(['error' => 'Missing or invalid user ID']);
        exit;
    }
    $user_id = (int) $user_id;

    // Fetch the 10 most recent posts by this user
    $sql  = "
        SELECT 
            *
        FROM 
            posts
        WHERE 
            user_id = ?
        ORDER BY 
            id DESC
        LIMIT 
            10
    ";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$user_id]);
    $posts = $stmt->fetchAll();

    // Return posts
    http_response_code(200);
    echo json_encode($posts);

} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode([
        'error'   => 'Database error',
        'message' => $e->getMessage()
    ]);
    exit;
}