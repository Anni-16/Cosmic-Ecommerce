<?php
require_once './admin/inc/config.php';

// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

header('Content-Type: application/json');

try {
    // Get session ID for guest users
    $session_id = session_id();
    if (empty($session_id)) {
        throw new Exception('Session not started.');
    }

    // Collect and sanitize input
    $product_id    = (int)($_POST['product_id'] ?? 0);
    $product_name  = trim($_POST['product_name'] ?? '');
    $product_model = trim($_POST['product_model'] ?? '');
    $product_image = trim($_POST['product_image'] ?? '');
    $product_price = (float)($_POST['product_price'] ?? 0);
    $quantity      = max(1, (int)($_POST['quantity'] ?? 1));

    // Validate inputs
    if ($product_id <= 0 || empty($product_name) || $product_price < 0) {
        throw new Exception('Invalid product data.');
    }

    // Check if the same item (same options) exists in the cart for this session
    $checkStmt = $pdo->prepare("
        SELECT id, quantity 
        FROM tbl_cart 
        WHERE session_id = ? AND product_id = ? 
    ");
    $checkStmt->execute([$session_id, $product_id]);
    $existing = $checkStmt->fetch(PDO::FETCH_ASSOC);

    if ($existing) {
        // Update existing cart item
        $newQty = (int)$existing['quantity'] + $quantity;
        $updateStmt = $pdo->prepare("UPDATE tbl_cart SET quantity = ? WHERE id = ?");
        $updateStmt->execute([$newQty, $existing['id']]);
    } else {
        // Insert new cart item
        $insertStmt = $pdo->prepare("
            INSERT INTO tbl_cart 
            (session_id, product_id, product_name, product_model, product_image, product_price, quantity, added_on)
            VALUES (?, ?, ?, ?, ?, ?, ?,  NOW())
        ");
        $insertStmt->execute([
            $session_id, $product_id, $product_name, $product_model, $product_image,
            $product_price,  $quantity
        ]);
    }

    // Calculate updated cart count for this session
    $stmt = $pdo->prepare("SELECT COALESCE(SUM(quantity), 0) FROM tbl_cart WHERE session_id = ?");
    $stmt->execute([$session_id]);
    $total_items = (int)$stmt->fetchColumn();

    // Return success response
    echo json_encode([
        'status'     => 'success',
        'message'    => 'Product added to cart successfully.',
        'cart_count' => $total_items
    ]);
} catch (Throwable $e) {
    // Return error response
    http_response_code(400);
    echo json_encode([
        'status'  => 'error',
        'message' => $e->getMessage()
    ]);
}
exit;