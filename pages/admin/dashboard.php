<?php
// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once '../../includes/auth/auth_check.php';
require_once '../../includes/config/database.php';
checkAuth('admin');

$pageTitle = "Overall Reports";

// Default to current month
$timeRange = isset($_GET['time_range']) ? $_GET['time_range'] : 'this_month';

// Calculate date ranges based on selected time range
$endDate = date('Y-m-d');
switch ($timeRange) {
    case 'this_month':
        $startDate = date('Y-m-01');
        break;
    case 'last_month':
        $startDate = date('Y-m-01', strtotime('-1 month'));
        $endDate = date('Y-m-t', strtotime('-1 month'));
        break;
    case 'last_3_months':
        $startDate = date('Y-m-01', strtotime('-3 months'));
        break;
    case 'this_year':
        $startDate = date('Y-01-01');
        break;
    default:
        $startDate = date('Y-m-01');
}

try {
    // Get total stock items and value
    $stmt = $conn->query("SELECT 
        COUNT(*) as total_items,
        SUM(stock) as total_stock,
        SUM(stock * price) as total_value
        FROM products");
    $stockStats = $stmt->fetch();

    // Get warehouse outflow (items shipped)
    $stmt = $conn->prepare("SELECT 
        COUNT(DISTINCT o.id) as total_orders,
        COALESCE(SUM(oi.quantity), 0) as total_items_shipped
        FROM orders o
        JOIN order_items oi ON o.id = oi.order_id
        WHERE o.status = 'shipped'
        AND o.created_at BETWEEN ? AND ?");
    $stmt->execute([$startDate, $endDate]);
    $outflowStats = $stmt->fetch();

    // Get delivered items
    $stmt = $conn->prepare("SELECT 
        COUNT(DISTINCT o.id) as total_orders,
        COALESCE(SUM(oi.quantity), 0) as total_items_delivered
        FROM orders o
        JOIN order_items oi ON o.id = oi.order_id
        WHERE o.status = 'delivered'
        AND o.created_at BETWEEN ? AND ?");
    $stmt->execute([$startDate, $endDate]);
    $deliveredStats = $stmt->fetch();

    // Get total revenue
    $stmt = $conn->prepare("SELECT 
        COALESCE(SUM(total_amount), 0) as total_revenue
        FROM orders
        WHERE status IN ('shipped', 'delivered')
        AND created_at BETWEEN ? AND ?");
    $stmt->execute([$startDate, $endDate]);
    $revenueStats = $stmt->fetch();

    // Get recently added stock
    $stmt = $conn->query("SELECT 
        p.name as product_name,
        c.name as category_name,
        p.stock,
        p.created_at
        FROM products p
        JOIN categories c ON p.category_id = c.id
        ORDER BY p.created_at DESC
        LIMIT 3");
    $recentStock = $stmt->fetchAll();

    // Get low stock items
    $stmt = $conn->query("SELECT 
        p.name as product_name,
        c.name as category_name,
        p.stock
        FROM products p
        JOIN categories c ON p.category_id = c.id
        WHERE p.stock <= 10
        ORDER BY p.stock ASC
        LIMIT 3");
    $lowStock = $stmt->fetchAll();

} catch (PDOException $e) {
    error_log("Database error: " . $e->getMessage());
    $error_message = "Error fetching dashboard data";
}

include '../../layouts/header.php';
?>

<div style="margin-bottom: 20px; margin-top: 40px; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 1rem;">
    <h1 style="font-size: 1.8rem; font-weight: 600; margin: 0;"><?php echo $pageTitle; ?></h1>
    
    <div style="display: flex; gap: 1rem; align-items: center;">
        <select id="time-range-selector" class="select-control" style="min-width: 150px; padding: 8px 12px; border-radius: 8px; border: 1px solid #ccc;">
            <option value="this_month" <?php echo $timeRange == 'this_month' ? 'selected' : ''; ?>>This Month</option>
            <option value="last_month" <?php echo $timeRange == 'last_month' ? 'selected' : ''; ?>>Last Month</option>
            <option value="last_3_months" <?php echo $timeRange == 'last_3_months' ? 'selected' : ''; ?>>Last 3 Months</option>
            <option value="this_year" <?php echo $timeRange == 'this_year' ? 'selected' : ''; ?>>This Year</option>
        </select>
    </div>
</div>

<div class="stats-grid" style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 20px; margin-bottom: 24px;">
    <!-- Total Stock Card -->
    <div class="stat-card" style="display: flex; flex-direction: column; background: linear-gradient(135deg, #1E293B 0%, #0F172A 100%); border-radius: 16px; padding: 18px; box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05); position: relative; overflow: hidden;">
        <div style="position: absolute; top: 0; right: 0; width: 100px; height: 100px; background: radial-gradient(circle, rgba(99, 102, 241, 0.15) 0%, rgba(99, 102, 241, 0) 70%); border-radius: 50%;"></div>
        
        <div style="display: flex; align-items: center; margin-bottom: 16px;">
            <div style="display: flex; justify-content: center; align-items: center; width: 48px; height: 48px; background: linear-gradient(135deg, #6366F1 0%, #8B5CF6 100%); border-radius: 12px; margin-right: 16px;">
                <i class="fas fa-box" style="font-size: 20px; color: white;"></i>
            </div>
            <h3 style="font-size: 1.2rem; font-weight: 500; color: #E2E8F0; margin: 0;">Total Stock Items</h3>
        </div>
        
        <div style="display: flex; align-items: baseline; margin-bottom: 8px;">
            <div class="value" style="font-size: 2.5rem; font-weight: 700; color: white; margin-right: 12px;">
                <?php echo number_format($stockStats['total_stock']); ?>
            </div>
            <div style="font-size: 1rem; color: #94A3B8;">
                (<?php echo number_format($stockStats['total_items']); ?> items)
            </div>
        </div>
        
        <div style="font-size: 0.875rem; color: #94A3B8;">
            Total Value: ₱<?php echo number_format($stockStats['total_value'], 2); ?>
        </div>
    </div>
    
    <!-- Warehouse Outflow Card -->
    <div class="stat-card" style="display: flex; flex-direction: column; background: linear-gradient(135deg, #1E293B 0%, #0F172A 100%); border-radius: 16px; padding: 18px; box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05); position: relative; overflow: hidden;">
        <div style="position: absolute; top: 0; right: 0; width: 100px; height: 100px; background: radial-gradient(circle, rgba(236, 72, 153, 0.15) 0%, rgba(236, 72, 153, 0) 70%); border-radius: 50%;"></div>
        
        <div style="display: flex; align-items: center; margin-bottom: 16px;">
            <div style="display: flex; justify-content: center; align-items: center; width: 48px; height: 48px; background: linear-gradient(135deg, #EC4899 0%, #F472B6 100%); border-radius: 12px; margin-right: 16px;">
                <i class="fas fa-truck" style="font-size: 20px; color: white;"></i>
            </div>
            <h3 style="font-size: 1.2rem; font-weight: 500; color: #E2E8F0; margin: 0;">Warehouse Outflow</h3>
        </div>
        
        <div style="display: flex; align-items: baseline; margin-bottom: 8px;">
            <div class="value" style="font-size: 2.5rem; font-weight: 700; color: white; margin-right: 12px;">
                <?php echo number_format($outflowStats['total_items_shipped']); ?>
            </div>
        </div>
        
        <div style="font-size: 0.875rem; color: #94A3B8;">
            From <?php echo number_format($outflowStats['total_orders']); ?> orders
        </div>
    </div>
    
    <!-- Delivered Items Card -->
    <div class="stat-card" style="display: flex; flex-direction: column; background: linear-gradient(135deg, #1E293B 0%, #0F172A 100%); border-radius: 16px; padding: 18px; box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05); position: relative; overflow: hidden;">
        <div style="position: absolute; top: 0; right: 0; width: 100px; height: 100px; background: radial-gradient(circle, rgba(16, 185, 129, 0.15) 0%, rgba(16, 185, 129, 0) 70%); border-radius: 50%;"></div>
        
        <div style="display: flex; align-items: center; margin-bottom: 16px;">
            <div style="display: flex; justify-content: center; align-items: center; width: 48px; height: 48px; background: linear-gradient(135deg, #10B981 0%, #34D399 100%); border-radius: 12px; margin-right: 16px;">
                <i class="fas fa-check-circle" style="font-size: 20px; color: white;"></i>
            </div>
            <h3 style="font-size: 1.2rem; font-weight: 500; color: #E2E8F0; margin: 0;">Delivered Items</h3>
        </div>
        
        <div style="display: flex; align-items: baseline; margin-bottom: 8px;">
            <div class="value" style="font-size: 2.5rem; font-weight: 700; color: white; margin-right: 12px;">
                <?php echo number_format($deliveredStats['total_items_delivered']); ?>
            </div>
        </div>
        
        <div style="font-size: 0.875rem; color: #94A3B8;">
            From <?php echo number_format($deliveredStats['total_orders']); ?> orders
        </div>
    </div>
    
    <!-- Revenue Card -->
    <div class="stat-card" style="display: flex; flex-direction: column; background: linear-gradient(135deg, #1E293B 0%, #0F172A 100%); border-radius: 16px; padding: 18px; box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05); position: relative; overflow: hidden;">
        <div style="position: absolute; top: 0; right: 0; width: 100px; height: 100px; background: radial-gradient(circle, rgba(14, 165, 233, 0.15) 0%, rgba(14, 165, 233, 0) 70%); border-radius: 50%;"></div>
        
        <div style="display: flex; align-items: center; margin-bottom: 16px;">
            <div style="display: flex; justify-content: center; align-items: center; width: 48px; height: 48px; background: linear-gradient(135deg, #0EA5E9 0%, #38BDF8 100%); border-radius: 12px; margin-right: 16px;">
                <i class="fas fa-dollar-sign" style="font-size: 20px; color: white;"></i>
            </div>
            <h3 style="font-size: 1.2rem; font-weight: 500; color: #E2E8F0; margin: 0;">Revenue</h3>
        </div>
        
        <div style="display: flex; align-items: baseline; margin-bottom: 8px;">
            <div class="value" style="font-size: 2.5rem; font-weight: 700; color: white; margin-right: 12px;">
                ₱<?php echo number_format($revenueStats['total_revenue'], 2); ?>
            </div>
        </div>
        
        <div style="font-size: 0.875rem; color: #94A3B8;">
            From shipped & delivered orders
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="card">
            <h2>Recently Added Stock</h2>
            <div class="table-container">
                <table>
                    <thead>
                        <tr>
                            <th>Product</th>
                            <th>Category</th>
                            <th>Quantity</th>
                            <th>Date Added</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($recentStock)): ?>
                        <tr>
                            <td colspan="4" class="text-center">No recently added stock items</td>
                        </tr>
                        <?php else: ?>
                        <?php foreach ($recentStock as $item): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($item['product_name']); ?></td>
                            <td><?php echo htmlspecialchars($item['category_name']); ?></td>
                            <td><?php echo number_format($item['stock']); ?></td>
                            <td><?php echo date('M d, Y', strtotime($item['created_at'])); ?></td>
                        </tr>
                        <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    
    <div class="col-md-6">
        <div class="card">
            <h2>Low Stock Items</h2>
            <div class="table-container">
                <table>
                    <thead>
                        <tr>
                            <th>Product</th>
                            <th>Category</th>
                            <th>Stock</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($lowStock)): ?>
                        <tr>
                            <td colspan="3" class="text-center">No low stock items</td>
                        </tr>
                        <?php else: ?>
                        <?php foreach ($lowStock as $item): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($item['product_name']); ?></td>
                            <td><?php echo htmlspecialchars($item['category_name']); ?></td>
                            <td>
                                <span class="badge badge-<?php echo $item['stock'] <= 5 ? 'danger' : 'warning'; ?>">
                                    <?php echo number_format($item['stock']); ?>
                                </span>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const timeRangeSelector = document.getElementById('time-range-selector');
    
    // Handle time range change
    timeRangeSelector.addEventListener('change', function() {
        window.location.href = 'dashboard.php?time_range=' + this.value;
    });
});
</script>

<?php include '../../layouts/footer.php'; ?> 