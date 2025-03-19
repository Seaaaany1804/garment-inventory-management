<?php
// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once '../../includes/config/database.php';

$pageTitle = "Sales Dashboard";

// Fetch statistics
$stats = [
    'total_orders' => $conn->query("SELECT COUNT(*) FROM orders")->fetchColumn(),
    'pending_orders' => $conn->query("SELECT COUNT(*) FROM orders WHERE status = 'pending'")->fetchColumn(),
    'delivered_orders' => $conn->query("SELECT COUNT(*) FROM orders WHERE status = 'delivered'")->fetchColumn(),
    'available_items' => $conn->query("SELECT COUNT(*) FROM products WHERE stock > 0")->fetchColumn()
];

// Fetch recent orders with customer details and item count
$recent_orders = $conn->query("
    SELECT 
        o.id,
        o.created_at,
        o.status,
        o.total_amount,
        c.name as customer_name,
        SUM(oi.quantity) as total_quantity,
        GROUP_CONCAT(p.name SEPARATOR ', ') as product_names
    FROM orders o
    LEFT JOIN customers c ON o.customer_id = c.id
    LEFT JOIN order_items oi ON o.id = oi.order_id
    LEFT JOIN products p ON oi.product_id = p.id
    GROUP BY o.id
    ORDER BY o.created_at DESC
    LIMIT 10
")->fetchAll();

include '../../layouts/header.php';
?>

<div class="stats-grid">
    <div class="stat-card">
        <h3>Total Orders</h3>
        <div class="value"><?php echo $stats['total_orders']; ?></div>
    </div>
    
    <div class="stat-card">
        <h3>Pending Orders</h3>
        <div class="value"><?php echo $stats['pending_orders']; ?></div>
    </div>
    
    <div class="stat-card">
        <h3>Delivered Orders</h3>
        <div class="value"><?php echo $stats['delivered_orders']; ?></div>
    </div>
    
    <div class="stat-card">
        <h3>Available Items</h3>
        <div class="value"><?php echo $stats['available_items']; ?></div>
    </div>
</div>

<div class="card">
    <h2>Recent Orders</h2>
    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>Order ID</th>
                    <th>Date</th>
                    <th>Customer</th>
                    <th>Items</th>
                    <th>Products</th>
                    <th>Total Amount</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($recent_orders as $order): 
                    $status_class = match($order['status']) {
                        'pending' => 'warning',
                        'shipped' => 'info',
                        'delivered' => 'success',
                        default => 'secondary'
                    };
                ?>
                <tr>
                    <td>#<?php echo str_pad($order['id'], 3, '0', STR_PAD_LEFT); ?></td>
                    <td><?php echo date('M d, Y', strtotime($order['created_at'])); ?></td>
                    <td><?php echo htmlspecialchars($order['customer_name']); ?></td>
                    <td><?php echo $order['total_quantity'] ?? 0; ?></td>
                    <td><?php echo htmlspecialchars($order['product_names']); ?></td>
                    <td>₱<?php echo number_format($order['total_amount'], 2); ?></td>
                    <td><span class="badge badge-<?php echo $status_class; ?>"><?php echo ucfirst($order['status']); ?></span></td>
                    <td><a href="orders.php?id=<?php echo $order['id']; ?>" class="btn btn-sm">View</a></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<?php include '../../layouts/footer.php'; ?> 