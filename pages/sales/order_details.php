<?php
// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once '../../includes/config/database.php';

$pageTitle = "Order Details";

// Get order ID from URL
$order_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

// Fetch order details
$order_query = $conn->prepare("
    SELECT 
        o.*,
        c.name as customer_name,
        c.phone as customer_phone,
        c.address as customer_address
    FROM orders o
    LEFT JOIN customers c ON o.customer_id = c.id
    WHERE o.id = ?
");
$order_query->execute([$order_id]);
$order = $order_query->fetch();

if (!$order) {
    $_SESSION['error'] = "Order not found.";
    header("Location: dashboard.php");
    exit();
}

// Fetch order items
$items_query = $conn->prepare("
    SELECT 
        oi.*,
        p.name as product_name,
        p.price as product_price
    FROM order_items oi
    LEFT JOIN products p ON oi.product_id = p.id
    WHERE oi.order_id = ?
");
$items_query->execute([$order_id]);
$order_items = $items_query->fetchAll();

include '../../layouts/header.php';
?>

<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Order Details</h1>
        <div style="display: flex; gap: 10px;">
            <button id="viewReceiptBtn" class="btn" style="padding: 8px 16px; background-color: #4F46E5; color: #e2e8f0; border: none; border-radius: 6px; cursor: pointer; display: inline-flex; align-items: center; gap: 6px;">
                <i class="fas fa-receipt"></i> View Receipt
            </button>
            <a href="dashboard.php" class="btn" style="padding: 8px 16px; background-color: #374151; color: #e2e8f0; border-radius: 6px; text-decoration: none; display: inline-flex; align-items: center; gap: 6px;">
                <i class="fas fa-arrow-left"></i> Back to Dashboard
            </a>
        </div>
    </div>

    <?php if (isset($_SESSION['success'])): ?>
        <div class="alert alert-success">
            <?php 
            echo $_SESSION['success'];
            unset($_SESSION['success']);
            ?>
        </div>
    <?php endif; ?>

    <?php if (isset($_SESSION['error'])): ?>
        <div class="alert alert-danger">
            <?php 
            echo $_SESSION['error'];
            unset($_SESSION['error']);
            ?>
        </div>
    <?php endif; ?>

    <div class="card">
        <div class="card-header">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">Order #<?php echo str_pad($order['id'], 3, '0', STR_PAD_LEFT); ?></h5>
                <span class="badge badge-<?php 
                    echo match($order['status']) {
                        'pending' => 'warning',
                        'shipped' => 'info',
                        'delivered' => 'success',
                        default => 'secondary'
                    };
                ?>">
                    <?php echo ucfirst($order['status']); ?>
                </span>
            </div>
        </div>
        <div class="card-body">
            <!-- Order and Customer Information -->
            <div class="mb-4">
                <h4 class="text-white mb-3">Order Information</h4>
                <p><strong>Date:</strong> <?php echo date('M d, Y', strtotime($order['created_at'])); ?></p>
                <p><strong>Total Amount:</strong> ₱<?php echo number_format($order['total_amount'], 2); ?></p>
                <h4 class="text-white mb-3 mt-4">Customer Information</h4>
                <p><strong>Name:</strong> <?php echo htmlspecialchars($order['customer_name']); ?></p>
                <p><strong>Phone:</strong> <?php echo htmlspecialchars($order['customer_phone'] ?? 'N/A'); ?></p>
                <p><strong>Address:</strong> <?php echo htmlspecialchars($order['customer_address'] ?? 'N/A'); ?></p>
            </div>

            <!-- Order Items -->
            <div class="table-responsive">
                <h6 class="mb-3">Order Items</h6>
                <table class="table">
                    <thead>
                        <tr>
                            <th>Product</th>
                            <th>Price</th>
                            <th>Quantity</th>
                            <th>Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($order_items as $item): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($item['product_name']); ?></td>
                            <td>₱<?php echo number_format($item['product_price'], 2); ?></td>
                            <td><?php echo $item['quantity']; ?></td>
                            <td>₱<?php echo number_format($item['product_price'] * $item['quantity'], 2); ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="3" class="text-end"><strong>Total Amount:</strong></td>
                            <td><strong>₱<?php echo number_format($order['total_amount'], 2); ?></strong></td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Receipt Modal -->
<div id="receiptModal" class="modal" style="display: none; position: fixed; z-index: 1000; left: 0; top: 0; width: 100%; height: 100%; overflow: auto; background-color: rgba(0, 0, 0, 0.5);">
    <div class="modal-content" style="background-color: #1E293B; margin: 5% auto; padding: 0; border-radius: 8px; width: 90%; max-width: 400px; box-shadow: 0 4px 20px rgba(0, 0, 0, 0.3);">
        <div style="display: flex; justify-content: space-between; align-items: center; padding: 15px 20px; border-bottom: 1px solid #374151;">
            <h3 style="margin: 0; font-size: 1.25rem; color: #e2e8f0;">Order Receipt</h3>
            <div>
                <button onclick="closeReceiptModal()" style="background: none; border: none; color: #9ca3af; cursor: pointer; font-size: 1.25rem;">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        </div>
        <div id="receiptContent" style="padding: 20px; color: #e2e8f0; font-family: 'Courier New', monospace; background-color: white;">
            <div style="text-align: center; padding-bottom: 15px; border-bottom: 1px dashed #ccc;">
                <h2 style="margin: 0; font-size: 1.2rem; font-weight: bold; color: #000;">Triple S Garments</h2>
                <p style="margin: 5px 0; font-size: 0.9rem; color: #333;">123 Fashion Street, Style City</p>
                <p style="margin: 5px 0; font-size: 0.9rem; color: #333;">Tel: (123) 456-7890</p>
            </div>
            
            <div style="margin: 15px 0; text-align: center;">
                <p style="margin: 5px 0; font-size: 1rem; font-weight: bold; color: #000;">SALES RECEIPT</p>
                <p style="margin: 5px 0; font-size: 0.9rem; color: #333;">Order #: <?php echo str_pad($order['id'], 3, '0', STR_PAD_LEFT); ?></p>
                <p style="margin: 5px 0; font-size: 0.9rem; color: #333;">Date: <?php echo date('m/d/Y h:i A', strtotime($order['created_at'])); ?></p>
            </div>
            
            <div style="margin: 15px 0;">
                <p style="margin: 5px 0; font-size: 0.9rem; font-weight: bold; color: #000;">Customer: <?php echo htmlspecialchars($order['customer_name']); ?></p>
                <?php if(!empty($order['customer_phone'])): ?>
                <p style="margin: 5px 0; font-size: 0.9rem; color: #333;">Phone: <?php echo htmlspecialchars($order['customer_phone']); ?></p>
                <?php endif; ?>
                <?php if(!empty($order['customer_address'])): ?>
                <p style="margin: 5px 0; font-size: 0.9rem; color: #333;">Address: <?php echo htmlspecialchars($order['customer_address']); ?></p>
                <?php endif; ?>
            </div>
            
            <div style="border-top: 1px dashed #ccc; border-bottom: 1px dashed #ccc; padding: 10px 0;">
                <table style="width: 100%; font-size: 0.9rem; color: #333;">
                    <thead>
                        <tr style="text-align: left;">
                            <th style="padding: 5px 0;">Item</th>
                            <th style="padding: 5px 0; text-align: center;">Qty</th>
                            <th style="padding: 5px 0; text-align: right;">Price</th>
                            <th style="padding: 5px 0; text-align: right;">Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($order_items as $item): ?>
                        <tr>
                            <td style="padding: 5px 0;"><?php echo htmlspecialchars($item['product_name']); ?></td>
                            <td style="padding: 5px 0; text-align: center;"><?php echo $item['quantity']; ?></td>
                            <td style="padding: 5px 0; text-align: right;">₱<?php echo number_format($item['product_price'], 2); ?></td>
                            <td style="padding: 5px 0; text-align: right;">₱<?php echo number_format($item['product_price'] * $item['quantity'], 2); ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            
            <div style="margin: 15px 0;">
                <table style="width: 100%; font-size: 0.9rem; color: #333;">
                    <tr>
                        <td style="text-align: right; padding: 5px 0; font-weight: bold;">Subtotal:</td>
                        <td style="text-align: right; padding: 5px 0;">₱<?php echo number_format($order['total_amount'], 2); ?></td>
                    </tr>
                    <tr style="font-weight: bold; font-size: 1rem;">
                        <td style="text-align: right; padding: 5px 0; border-top: 1px dashed #ccc;">TOTAL:</td>
                        <td style="text-align: right; padding: 5px 0; border-top: 1px dashed #ccc;">₱<?php echo number_format($order['total_amount'], 2); ?></td>
                    </tr>
                </table>
            </div>
            
            <div style="margin: 20px 0; text-align: center; padding-top: 15px; border-top: 1px dashed #ccc;">
                <p style="margin: 5px 0; font-size: 0.9rem; font-weight: bold; text-transform: uppercase; color: #000;"><?php echo $order['status']; ?></p>
                <p style="margin: 15px 0; font-size: 0.9rem; color: #333;">Thank you for your purchase!</p>
                <p style="margin: 5px 0; font-size: 0.8rem; color: #666;">Keep this receipt for your records</p>
            </div>
        </div>
    </div>
</div>

<script>
// Open the receipt modal when the button is clicked
document.getElementById('viewReceiptBtn').addEventListener('click', function() {
    document.getElementById('receiptModal').style.display = 'block';
});

// Close the receipt modal
function closeReceiptModal() {
    document.getElementById('receiptModal').style.display = 'none';
}

// Close modal when clicking outside the modal content
window.onclick = function(event) {
    const modal = document.getElementById('receiptModal');
    if (event.target == modal) {
        modal.style.display = 'none';
    }
}
</script>

<style>
    .card {
        border-radius: 12px;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        margin-bottom: 1rem;
    }
    
    .card-header {
        background-color: var(--background-dark);
        border-bottom: 1px solid var(--border-color);
        padding: 0.75rem 1rem;
    }
    
    .card-body {
        padding: 1rem;
    }
    
    .table {
        margin-bottom: 0;
    }
    
    .table th, .table td {
        color: #fff;
    }
    
    .table th {
        border-top: none;
        background-color: var(--background-dark);
        color: var(--text-secondary);
        padding: 0.5rem;
    }
    
    .table td {
        vertical-align: middle;
        padding: 0.5rem;
    }
    
    .badge {
        padding: 0.3rem 0.6rem;
        font-weight: 500;
    }
</style>

<?php include '../../layouts/footer.php'; ?> 