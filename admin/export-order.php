<?php
require_once('./inc/config.php'); // Ensure DB connection

header('Content-Type: text/csv; charset=utf-8');
header('Content-Disposition: attachment; filename=orders_' . date('Y-m-d_H-i-s') . '.csv');

$output = fopen('php://output', 'w');

// CSV Headers
fputcsv($output, [
    'S.No',
    'Order ID',
    'Payment ID',
    'Customer Name',
    'Customer Email',
    'Customer Phone',
    'Product Name',
    'Quantity',
    'Unit Price',
    'Total Price',
    'Sub Total',
    'GST',
    'Grand Total',
    'Payment Status',
    'Order Status',
    'Order Date'
]);

$i = 0;

// Get all orders
$order_stmt = $pdo->prepare("SELECT * FROM tbl_order ORDER BY id DESC");
$order_stmt->execute();
$orders = $order_stmt->fetchAll(PDO::FETCH_ASSOC);

foreach ($orders as $order) {
    // Get items for this order
    $item_stmt = $pdo->prepare("SELECT * FROM tbl_order_items WHERE order_id = ?");
    $item_stmt->execute([$order['id']]);
    $items = $item_stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($items as $item) {
        $i++;
        fputcsv($output, [
            $i,
            $order['order_id'],
            $order['payment_id'],
            $order['customer_name'],
            $order['customer_email'],
            $order['customer_phone'],
            $item['product_name'],
            $item['quantity'],
            $item['product_price'],
            $item['total_price'],
            $order['sub_total'],
            $order['gst'],
            $order['grand_total'],
            $order['payment_status'],
            $order['order_status'] ?? 'Pending',
            date('Y-m-d H:i:s', strtotime($order['created_at']))
        ]);
    }
}

fclose($output);
exit;
