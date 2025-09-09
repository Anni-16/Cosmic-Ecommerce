<?php require_once('header.php');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../PHPMailer/src/Exception.php';
require '../PHPMailer/src/PHPMailer.php';
require '../PHPMailer/src/SMTP.php';

$error_message = '';
$success_message = '';

// Handle Status Update
if (isset($_POST['form_status'])) {
    $valid = 1;
    $order_id = filter_var($_POST['order_id'], FILTER_VALIDATE_INT);
    $new_status = trim($_POST['status']);

    $allowed_statuses = ['Pending', 'Shipped', 'Delivered'];
    if (!in_array($new_status, $allowed_statuses)) {
        $valid = 0;
        $error_message = "Invalid status selected.";
    }

    if (!$order_id) {
        $valid = 0;
        $error_message = "Invalid order ID.";
    }

    if ($valid == 1) {
        try {
            $pdo->beginTransaction();

            // Update order status
            $stmt = $pdo->prepare("UPDATE tbl_order SET order_status = ? WHERE id = ?");
            $stmt->execute([$new_status, $order_id]);

            // Fetch order and customer info
            $stmt = $pdo->prepare("SELECT * FROM tbl_order WHERE id = ?");
            $stmt->execute([$order_id]);
            $order = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($order && in_array($new_status, ['Shipped', 'Delivered'])) {
                $cust_email = $order['customer_email'];
                $cust_name = $order['customer_name'];
                $order_code = $order['order_id'];

                // Fetch products in this order
                $item_stmt = $pdo->prepare("SELECT product_name FROM tbl_order_items WHERE order_id = ?");
                $item_stmt->execute([$order_id]);
                $products = $item_stmt->fetchAll(PDO::FETCH_COLUMN);

                $product_list = implode(', ', $products);

                $admin_email = 'info@cosmicenergies.in';

                $subject = "Order Update: Your Order #$order_code is $new_status";
                $message = "<html><body>
                    <p>Dear $cust_name,</p>
                    <p>Your order <strong>#$order_code</strong> containing the following item(s):</p>
                    <p><strong>$product_list</strong></p>
                    <p>has been <strong>$new_status</strong>.</p>
                    <p>Thank you for shopping with us!</p>
                    </body></html>";

                // Send Email
                $mail = new PHPMailer(true);
                try {
                    $mail->isSMTP();
                    $mail->Host       = 'smtp.gmail.com';
                    $mail->SMTPAuth   = true;
                    $mail->Username   = 'info@cosmicenergies.in'; // your Gmail
                    $mail->Password   = 'lflkcvbhvwbhvrui';   // Gmail App Password
                    $mail->SMTPSecure = 'tls';
                    $mail->Port       = 587;

                    $mail->setFrom($admin_email, 'Cosmic Energies');
                    $mail->addAddress($cust_email, $cust_name);

                    $mail->isHTML(true);
                    $mail->Subject = $subject;
                    $mail->Body    = $message;

                    $mail->send();
                } catch (Exception $e) {
                    $error_message = "Email sending failed: " . $mail->ErrorInfo;
                }
            }

            $pdo->commit();
            $success_message = "Order status updated successfully.";
        } catch (Exception $e) {
            $pdo->rollBack();
            $error_message = "Failed to update status: " . $e->getMessage();
        }
    }
}
?>

<?php if (!empty($error_message)) : ?>
    <script>alert('<?php echo addslashes($error_message); ?>');</script>
<?php endif; ?>

<?php if (!empty($success_message)) : ?>
    <script>alert('<?php echo addslashes($success_message); ?>');</script>
<?php endif; ?>

<!-- HTML View Section -->
<section class="content-header">
    <div class="content-header-left">
        <h1>View Orders</h1>
    </div>
    <div class="content-header-right">
        <a href="export-order.php" class="btn btn-success btn-sm">Export CSV</a>
    </div>
</section>

<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box box-info">
                <div class="box-body table-responsive">
                    <table id="example1" class="table table-bordered table-hover table-striped">
                        <thead>
                            <tr>
                                <th>S.No</th>
                                <th>Order ID</th>
                                <th>Customer</th>
                                <th>Product</th>
                                <th>Qty</th>
                                <th>Unit Price</th>
                                <th>Total</th>
                                <th>Payment Status</th>
                                <th>Date</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $i = 0;
                            $orders = $pdo->query("SELECT * FROM tbl_order ORDER BY id DESC")->fetchAll(PDO::FETCH_ASSOC);
                            foreach ($orders as $order) {
                                $items_stmt = $pdo->prepare("SELECT * FROM tbl_order_items WHERE order_id = ?");
                                $items_stmt->execute([$order['id']]);
                                $items = $items_stmt->fetchAll(PDO::FETCH_ASSOC);

                                foreach ($items as $item) {
                                    $i++;
                                    ?>
                                    <tr class="<?php echo ($order['payment_status'] == 'Success') ? 'bg-g' : 'bg-r'; ?>">
                                        <td><?= $i; ?></td>
                                        <td><?= ($order['order_id']); ?></td>
                                        <td>
                                            <?= ($order['customer_name']) ?><br>
                                            <?= ($order['customer_email']) ?><br>
                                            <?= ($order['customer_phone']) ?>
                                        </td>
                                        <td><?= ($item['product_name']); ?></td>
                                        <td><?= $item['quantity']; ?></td>
                                        <td>₹<?= number_format($item['product_price'], 2); ?></td>
                                        <td>₹<?= number_format($item['total_price'], 2); ?></td>
                                        <td class="<?= ($order['payment_status'] == 'Success') ? 'text-success' : 'text-danger'; ?>">
                                            <?= $order['payment_status']; ?>
                                        </td>
                                        <td><?= date('d M Y', strtotime($order['created_at'])); ?></td>
                                        <td>
                                            <?= isset($order['order_status']) ? ($order['order_status']) : 'Pending'; ?>
                                        </td>
                                        <td>
                                            <form action="" method="post">
                                                <input type="hidden" name="order_id" value="<?= $order['id']; ?>">
                                                <select name="status" onchange="this.form.submit()" class="form-control">
                                                    <option value="Pending" <?= ($order['order_status'] == 'Pending') ? 'selected' : ''; ?>>Pending</option>
                                                    <option value="Shipped" <?= ($order['order_status'] == 'Shipped') ? 'selected' : ''; ?>>Shipped</option>
                                                    <option value="Delivered" <?= ($order['order_status'] == 'Delivered') ? 'selected' : ''; ?>>Delivered</option>
                                                </select>
                                                <input type="hidden" name="form_status" value="1">
                                            </form>
                                        </td>
                                    </tr>
                                <?php }
                            } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>

<?php require_once('footer.php'); ?>
