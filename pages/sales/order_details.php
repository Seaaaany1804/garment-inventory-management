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
        <a href="dashboard.php" class="btn btn-secondary">Back to Dashboard</a>
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