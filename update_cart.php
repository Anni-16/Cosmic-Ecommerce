<?php
ob_start();
header('Content-Type: application/json');

// Include configuration file
include 'admin/inc/config.php'; // Ensure this file does not output anything

// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

try {
    // Validate request parameters
    if (!isset($_POST['cart_id']) || !isset($_POST['action'])) {
        throw new Exception('Invalid request: cart_id or action missing');
    }

    $cartId = (int)$_POST['cart_id'];
    $action = $_POST['action'];
    $sessionId = session_id();

    if (!$cartId || !$sessionId) {
        throw new Exception('Invalid cart ID or session ID');
    }

    // Prepare response array
    $response = ['success' => false, 'message' => ''];

    if ($action === 'delete') {
        $stmt = $pdo->prepare("DELETE FROM tbl_cart WHERE id = ? AND session_id = ?");
        $stmt->execute([$cartId, $sessionId]);

        if ($stmt->rowCount() > 0) {
            $response = ['success' => true, 'message' => 'Item deleted successfully'];
        } else {
            $response = ['success' => false, 'message' => 'Item not found or already deleted'];
        }
    } elseif ($action === 'update') {
        $quantity = isset($_POST['quantity']) ? (int)$_POST['quantity'] : 1;
        if ($quantity < 1) {
            $quantity = 1;
        }

        $stmt = $pdo->prepare("UPDATE tbl_cart SET quantity = ? WHERE id = ? AND session_id = ?");
        $stmt->execute([$quantity, $cartId, $sessionId]);

        if ($stmt->rowCount() > 0) {
            $response = ['success' => true, 'message' => 'Quantity updated successfully'];
        } else {
            $response = ['success' => false, 'message' => 'Failed to update quantity'];
        }
    } else {
        throw new Exception('Unknown action');
    }

    echo json_encode($response);
} catch (Throwable $e) {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Server error: ' . $e->getMessage()]);
} finally {
    ob_end_flush();
}