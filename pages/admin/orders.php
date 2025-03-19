<?php
// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once '../../includes/auth/auth_check.php';
require_once '../../includes/config/database.php';
checkAuth('admin');

$pageTitle = "Order Management";

// Handle individual order view if ID is provided
if (isset($_GET['id'])) {
    $orderId = $_GET['id'];
    
    // Fetch order details
    $stmt = $conn->prepare("
        SELECT 
            o.id,
            o.created_at,
            o.status,
            o.total_amount,
            c.name as customer_name,
            c.phone as customer_phone,
            c.address as customer_address
        FROM orders o
        LEFT JOIN customers c ON o.customer_id = c.id
        WHERE o.id = ?
    ");
    $stmt->execute([$orderId]);
    $order = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if (!$order) {
        // Order not found, redirect back to orders page
        header('Location: orders.php');
        exit;
    }
    
    // Fetch order items with product details
    $stmt = $conn->prepare("
        SELECT 
            oi.id,
            oi.quantity,
            oi.unit_price,
            oi.total_price,
            p.name as product_name
        FROM order_items oi
        JOIN products p ON oi.product_id = p.id
        WHERE oi.order_id = ?
    ");
    $stmt->execute([$orderId]);
    $orderItems = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    include '../../layouts/header.php';
    ?>
    
    <div style="margin-bottom: 20px; display: flex; justify-content: space-between; align-items: center;">
        <h1 style="font-size: 1.8rem; font-weight: 600; margin: 0; color: #e2e8f0;"><?php echo $pageTitle; ?> - Order #<?php echo str_pad($order['id'], 3, '0', STR_PAD_LEFT); ?></h1>
        <a href="orders.php" class="btn" style="padding: 8px 16px; background-color: #374151; color: #e2e8f0; border-radius: 6px; text-decoration: none; display: inline-flex; align-items: center; gap: 6px;">
            <i class="fas fa-arrow-left"></i> Back to Orders
        </a>
    </div>
    
    <div class="card" style="border-radius: 12px; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06); overflow: hidden; margin-bottom: 20px; padding: 20px;">
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 20px;">
            <div>
                <h3 style="font-size: 1.25rem; margin-bottom: 15px; color: #e2e8f0;">Order Information</h3>
                <div style="margin-bottom: 10px;">
                    <span style="color: #9ca3af; display: block; margin-bottom: 5px;">Order ID:</span>
                    <span style="color: #e2e8f0; font-weight: 500;">#<?php echo str_pad($order['id'], 3, '0', STR_PAD_LEFT); ?></span>
                </div>
                <div style="margin-bottom: 10px;">
                    <span style="color: #9ca3af; display: block; margin-bottom: 5px;">Date:</span>
                    <span style="color: #e2e8f0;"><?php echo date('F d, Y', strtotime($order['created_at'])); ?></span>
                </div>
                <div style="margin-bottom: 10px;">
                    <span style="color: #9ca3af; display: block; margin-bottom: 5px;">Status:</span>
                    <?php
                    $statusColor = '';
                    $statusBg = '';
                    switch ($order['status']) {
                        case 'pending':
                            $statusColor = '#F97316';
                            $statusBg = 'rgba(249, 115, 22, 0.1)';
                            break;
                        case 'shipped':
                            $statusColor = '#0EA5E9';
                            $statusBg = 'rgba(14, 165, 233, 0.1)';
                            break;
                        case 'delivered':
                            $statusColor = '#10B981';
                            $statusBg = 'rgba(16, 185, 129, 0.1)';
                            break;
                    }
                    ?>
                    <span style="display: inline-block; padding: 4px 12px; border-radius: 20px; font-size: 0.875rem; background-color: <?php echo $statusBg; ?>; color: <?php echo $statusColor; ?>; font-weight: 500; text-transform: capitalize;">
                        <?php echo $order['status']; ?>
                    </span>
                </div>
                <div style="margin-bottom: 10px;">
                    <span style="color: #9ca3af; display: block; margin-bottom: 5px;">Total Amount:</span>
                    <span style="color: #e2e8f0; font-weight: 600; font-size: 1.25rem;">₱<?php echo number_format($order['total_amount'], 2); ?></span>
                </div>
            </div>
            
            <div>
                <h3 style="font-size: 1.25rem; margin-bottom: 15px; color: #e2e8f0;">Customer Information</h3>
                <div style="margin-bottom: 10px;">
                    <span style="color: #9ca3af; display: block; margin-bottom: 5px;">Name:</span>
                    <span style="color: #e2e8f0;"><?php echo htmlspecialchars($order['customer_name']); ?></span>
                </div>
                <div style="margin-bottom: 10px;">
                    <span style="color: #9ca3af; display: block; margin-bottom: 5px;">Phone:</span>
                    <span style="color: #e2e8f0;"><?php echo htmlspecialchars($order['customer_phone'] ?? 'N/A'); ?></span>
                </div>
                <div style="margin-bottom: 10px;">
                    <span style="color: #9ca3af; display: block; margin-bottom: 5px;">Address:</span>
                    <span style="color: #e2e8f0;"><?php echo htmlspecialchars($order['customer_address'] ?? 'N/A'); ?></span>
                </div>
            </div>
        </div>
    </div>
    
    <div class="card" style="border-radius: 12px; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06); overflow: hidden; margin-bottom: 20px;">
        <h3 style="font-size: 1.25rem; padding: 15px 20px; margin: 0; border-bottom: 1px solid #374151; color: #e2e8f0;">Order Items</h3>
        <div class="table-container" style="overflow-x: auto;">
            <table style="width: 100%; border-collapse: collapse;">
                <thead>
                    <tr style="background-color: #111827; text-align: left;">
                        <th style="padding: 12px 16px; color: #9ca3af; font-weight: 500; border-bottom: 1px solid #374151;">Product</th>
                        <th style="padding: 12px 16px; color: #9ca3af; font-weight: 500; border-bottom: 1px solid #374151;">Quantity</th>
                        <th style="padding: 12px 16px; color: #9ca3af; font-weight: 500; border-bottom: 1px solid #374151;">Unit Price</th>
                        <th style="padding: 12px 16px; color: #9ca3af; font-weight: 500; border-bottom: 1px solid #374151;">Total</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($orderItems as $item): ?>
                    <tr style="border-bottom: 1px solid #374151;">
                        <td style="padding: 12px 16px; color: #e2e8f0;"><?php echo htmlspecialchars($item['product_name']); ?></td>
                        <td style="padding: 12px 16px; color: #e2e8f0;"><?php echo $item['quantity']; ?></td>
                        <td style="padding: 12px 16px; color: #e2e8f0;">₱<?php echo number_format($item['unit_price'], 2); ?></td>
                        <td style="padding: 12px 16px; color: #e2e8f0;">₱<?php echo number_format($item['total_price'], 2); ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
                <tfoot>
                    <tr style="background-color: rgba(17, 24, 39, 0.5);">
                        <td colspan="3" style="padding: 12px 16px; text-align: right; font-weight: 600; color: #e2e8f0;">Total</td>
                        <td style="padding: 12px 16px; color: #e2e8f0; font-weight: 600;">₱<?php echo number_format($order['total_amount'], 2); ?></td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
    
    <?php
    // Action buttons for updating order status
    if ($order['status'] !== 'delivered') {
        ?>
        <div class="card" style="border-radius: 12px; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06); overflow: hidden; margin-bottom: 20px; padding: 20px;">
            <h3 style="font-size: 1.25rem; margin-bottom: 15px; color: #e2e8f0;">Update Order Status</h3>
            <div style="display: flex; gap: 10px;">
                <?php if ($order['status'] === 'pending'): ?>
                <form method="post" action="update_order_status.php">
                    <input type="hidden" name="order_id" value="<?php echo $order['id']; ?>">
                    <input type="hidden" name="status" value="shipped">
                    <button type="submit" style="padding: 8px 16px; background-color: #0EA5E9; color: white; border: none; border-radius: 6px; cursor: pointer;">
                        Mark as Shipped
                    </button>
                </form>
                <?php endif; ?>
                
                <?php if ($order['status'] === 'shipped'): ?>
                <form method="post" action="update_order_status.php">
                    <input type="hidden" name="order_id" value="<?php echo $order['id']; ?>">
                    <input type="hidden" name="status" value="delivered">
                    <button type="submit" style="padding: 8px 16px; background-color: #10B981; color: white; border: none; border-radius: 6px; cursor: pointer;">
                        Mark as Delivered
                    </button>
                </form>
                <?php endif; ?>
            </div>
        </div>
        <?php
    }
    
    include '../../layouts/footer.php';
    exit; // End processing here for individual order view
}

// Filter settings
$statusFilter = isset($_GET['status']) ? $_GET['status'] : 'all';

// Fetch orders with customer details and item count
if ($statusFilter === 'all') {
    $stmt = $conn->query("
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
    ");
} else {
    $stmt = $conn->prepare("
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
        WHERE o.status = ?
        GROUP BY o.id
        ORDER BY o.created_at DESC
    ");
    $stmt->execute([$statusFilter]);
}

$orders = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Get counts for each status
$counts = [
    'all' => $conn->query("SELECT COUNT(*) FROM orders")->fetchColumn(),
    'pending' => $conn->query("SELECT COUNT(*) FROM orders WHERE status = 'pending'")->fetchColumn(),
    'shipped' => $conn->query("SELECT COUNT(*) FROM orders WHERE status = 'shipped'")->fetchColumn(),
    'delivered' => $conn->query("SELECT COUNT(*) FROM orders WHERE status = 'delivered'")->fetchColumn()
];

include '../../layouts/header.php';
?>

<div style="margin-bottom: 20px; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 1rem;">
    <h1 style="font-size: 1.8rem; font-weight: 600; margin: 0; color: #e2e8f0;"><?php echo $pageTitle; ?></h1>
    
    <div style="display: flex; gap: 1rem; align-items: center;">
        <div class="search-container" style="position: relative;">
            <input type="text" placeholder="Search orders..." style="padding: 8px 12px 8px 36px; border-radius: 8px; border: 1px solid #4b5563; background-color: #1f2937; color: #e2e8f0; min-width: 250px;">
            <i class="fas fa-search" style="position: absolute; left: 12px; top: 50%; transform: translateY(-50%); color: #9ca3af;"></i>
        </div>
    </div>
</div>

<!-- Main Content Container with Full Height -->
<div style="display: flex; flex-direction: column; min-height: calc(100vh - 100px);">
    <!-- Filters and Tabs -->
    <div style="margin-bottom: 20px;">
        <div class="status-tabs" style="display: flex; gap: 1rem; border-bottom: 1px solid #374151; padding-bottom: 0.5rem;">
            <a href="?status=all" class="status-tab <?php echo $statusFilter === 'all' ? 'active' : ''; ?>" style="padding: 0.5rem 1rem; text-decoration: none; color: <?php echo $statusFilter === 'all' ? '#6366F1' : '#9ca3af'; ?>; font-weight: <?php echo $statusFilter === 'all' ? '600' : '400'; ?>; border-bottom: 2px solid <?php echo $statusFilter === 'all' ? '#6366F1' : 'transparent'; ?>;">
                All Orders <span class="count" style="background-color: #374151; padding: 2px 8px; border-radius: 20px; font-size: 0.75rem; margin-left: 5px;"><?php echo $counts['all']; ?></span>
            </a>
            <a href="?status=pending" class="status-tab <?php echo $statusFilter === 'pending' ? 'active' : ''; ?>" style="padding: 0.5rem 1rem; text-decoration: none; color: <?php echo $statusFilter === 'pending' ? '#F97316' : '#9ca3af'; ?>; font-weight: <?php echo $statusFilter === 'pending' ? '600' : '400'; ?>; border-bottom: 2px solid <?php echo $statusFilter === 'pending' ? '#F97316' : 'transparent'; ?>;">
                Pending <span class="count" style="background-color: #374151; padding: 2px 8px; border-radius: 20px; font-size: 0.75rem; margin-left: 5px;"><?php echo $counts['pending']; ?></span>
            </a>
            <a href="?status=shipped" class="status-tab <?php echo $statusFilter === 'shipped' ? 'active' : ''; ?>" style="padding: 0.5rem 1rem; text-decoration: none; color: <?php echo $statusFilter === 'shipped' ? '#0EA5E9' : '#9ca3af'; ?>; font-weight: <?php echo $statusFilter === 'shipped' ? '600' : '400'; ?>; border-bottom: 2px solid <?php echo $statusFilter === 'shipped' ? '#0EA5E9' : 'transparent'; ?>;">
                Shipped <span class="count" style="background-color: #374151; padding: 2px 8px; border-radius: 20px; font-size: 0.75rem; margin-left: 5px;"><?php echo $counts['shipped']; ?></span>
            </a>
            <a href="?status=delivered" class="status-tab <?php echo $statusFilter === 'delivered' ? 'active' : ''; ?>" style="padding: 0.5rem 1rem; text-decoration: none; color: <?php echo $statusFilter === 'delivered' ? '#10B981' : '#9ca3af'; ?>; font-weight: <?php echo $statusFilter === 'delivered' ? '600' : '400'; ?>; border-bottom: 2px solid <?php echo $statusFilter === 'delivered' ? '#10B981' : 'transparent'; ?>;">
                Delivered <span class="count" style="background-color: #374151; padding: 2px 8px; border-radius: 20px; font-size: 0.75rem; margin-left: 5px;"><?php echo $counts['delivered']; ?></span>
            </a>
        </div>
    </div>

    <!-- Orders Table -->
    <div class="card" style="flex: 1; border-radius: 12px; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06); overflow: hidden; margin-bottom: 20px;">
        <div class="table-container" style="overflow-x: auto;">
            <table style="width: 100%; border-collapse: collapse;">
                <thead>
                    <tr style="background-color: #111827; text-align: left;">
                        <th style="padding: 12px 16px; color: #9ca3af; font-weight: 500; border-bottom: 1px solid #374151;">Order ID</th>
                        <th style="padding: 12px 16px; color: #9ca3af; font-weight: 500; border-bottom: 1px solid #374151;">Customer</th>
                        <th style="padding: 12px 16px; color: #9ca3af; font-weight: 500; border-bottom: 1px solid #374151;">Date</th>
                        <th style="padding: 12px 16px; color: #9ca3af; font-weight: 500; border-bottom: 1px solid #374151;">Total</th>
                        <th style="padding: 12px 16px; color: #9ca3af; font-weight: 500; border-bottom: 1px solid #374151;">Items</th>
                        <th style="padding: 12px 16px; color: #9ca3af; font-weight: 500; border-bottom: 1px solid #374151;">Products</th>
                        <th style="padding: 12px 16px; color: #9ca3af; font-weight: 500; border-bottom: 1px solid #374151;">Status</th>
                        <th style="padding: 12px 16px; color: #9ca3af; font-weight: 500; border-bottom: 1px solid #374151;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (count($orders) > 0): ?>
                        <?php foreach ($orders as $order): 
                            $status_class = match($order['status']) {
                                'pending' => 'warning',
                                'shipped' => 'info',
                                'delivered' => 'success',
                                default => 'secondary'
                            };
                        ?>
                        <tr style="border-bottom: 1px solid #374151;">
                            <td style="padding: 12px 16px; color: #e2e8f0;">
                                <span style="font-weight: 500;">#<?php echo str_pad($order['id'], 3, '0', STR_PAD_LEFT); ?></span>
                            </td>
                            <td style="padding: 12px 16px; color: #e2e8f0;"><?php echo htmlspecialchars($order['customer_name']); ?></td>
                            <td style="padding: 12px 16px; color: #e2e8f0;"><?php echo date('M d, Y', strtotime($order['created_at'])); ?></td>
                            <td style="padding: 12px 16px; color: #e2e8f0;">₱<?php echo number_format($order['total_amount'], 2); ?></td>
                            <td style="padding: 12px 16px; color: #e2e8f0;"><?php echo $order['total_quantity'] ?? 0; ?></td>
                            <td style="padding: 12px 16px; color: #e2e8f0;"><?php echo htmlspecialchars($order['product_names'] ?? 'N/A'); ?></td>
                            <td style="padding: 12px 16px;">
                                <?php
                                $statusColor = '';
                                $statusBg = '';
                                switch ($order['status']) {
                                    case 'pending':
                                        $statusColor = '#F97316';
                                        $statusBg = 'rgba(249, 115, 22, 0.1)';
                                        break;
                                    case 'shipped':
                                        $statusColor = '#0EA5E9';
                                        $statusBg = 'rgba(14, 165, 233, 0.1)';
                                        break;
                                    case 'delivered':
                                        $statusColor = '#10B981';
                                        $statusBg = 'rgba(16, 185, 129, 0.1)';
                                        break;
                                }
                                ?>
                                <span style="display: inline-block; padding: 4px 12px; border-radius: 20px; font-size: 0.75rem; background-color: <?php echo $statusBg; ?>; color: <?php echo $statusColor; ?>; font-weight: 500; text-transform: capitalize;">
                                    <?php echo $order['status']; ?>
                                </span>
                            </td>
                            <td style="padding: 12px 16px;">
                                <a href="?id=<?php echo $order['id']; ?>" style="background: none; border: none; color: #6366F1; cursor: pointer; padding: 8px 12px; border-radius: 6px; background-color: rgba(99, 102, 241, 0.1); font-size: 0.875rem; display: inline-flex; align-items: center; gap: 6px; text-decoration: none;">
                                    <i class="fas fa-eye"></i> View Details
                                </a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="7" style="padding: 20px; text-align: center; color: #9ca3af;">No orders found</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php include '../../layouts/footer.php'; ?>