<?php
// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$pageTitle = "Warehouse Dashboard";
include '../../layouts/header.php';
?>

<div class="stats-grid">
    <div class="stat-card">
        <h3>Pending Orders</h3>
        <div class="value">14</div>
    </div>
    
    <div class="stat-card">
        <h3>Shipped Orders</h3>
        <div class="value">8</div>
    </div>
    
    <div class="stat-card">
        <h3>Delivered Orders</h3>
        <div class="value">6</div>
    </div>
    
    <div class="stat-card">
        <h3>Total Orders Today</h3>
        <div class="value">12</div>
    </div>
</div>

<div class="card">
    <h2>Orders To Process</h2>
    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>Order ID</th>
                    <th>Date</th>
                    <th>Items</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>#ORD-001</td>
                    <td>Mar 18, 2024</td>
                    <td>3</td>
                    <td><span class="badge badge-warning">Pending</span></td>
                    <td>
                        <a href="warehouse.php?id=ORD-001" class="btn btn-sm">
                            <i class="fas fa-box"></i> Process
                        </a>
                    </td>
                </tr>
                <tr>
                    <td>#ORD-006</td>
                    <td>Mar 18, 2024</td>
                    <td>2</td>
                    <td><span class="badge badge-warning">Pending</span></td>
                    <td>
                        <a href="warehouse.php?id=ORD-006" class="btn btn-sm">
                            <i class="fas fa-box"></i> Process
                        </a>
                    </td>
                </tr>
                <tr>
                    <td>#ORD-008</td>
                    <td>Mar 17, 2024</td>
                    <td>5</td>
                    <td><span class="badge badge-warning">Pending</span></td>
                    <td>
                        <a href="warehouse.php?id=ORD-008" class="btn btn-sm">
                            <i class="fas fa-box"></i> Process
                        </a>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

<div class="card">
    <h2>Orders In Transit</h2>
    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>Order ID</th>
                    <th>Ship Date</th>
                    <th>Customer</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>#ORD-003</td>
                    <td>Mar 16, 2024</td>
                    <td>Michael Brown</td>
                    <td><span class="badge badge-info">In Transit</span></td>
                    <td>
                        <a href="deliveries.php?id=ORD-003" class="btn btn-sm">
                            <i class="fas fa-truck"></i> Update
                        </a>
                    </td>
                </tr>
                <tr>
                    <td>#ORD-004</td>
                    <td>Mar 15, 2024</td>
                    <td>Jennifer Davis</td>
                    <td><span class="badge badge-info">In Transit</span></td>
                    <td>
                        <a href="deliveries.php?id=ORD-004" class="btn btn-sm">
                            <i class="fas fa-truck"></i> Update
                        </a>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

<div class="card">
    <h2>Low Stock Alert</h2>
    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>Item</th>
                    <th>Category</th>
                    <th>Current Stock</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Denim Jeans</td>
                    <td>Pants</td>
                    <td><span style="color: var(--warning-color)">15 units</span></td>
                    <td>
                        <a href="warehouse.php?action=restock&item=2" class="btn btn-sm">
                            <i class="fas fa-plus"></i> Restock
                        </a>
                    </td>
                </tr>
                <tr>
                    <td>Winter Jacket</td>
                    <td>Outerwear</td>
                    <td><span style="color: var(--danger-color)">0 units</span></td>
                    <td>
                        <a href="warehouse.php?action=restock&item=6" class="btn btn-sm">
                            <i class="fas fa-plus"></i> Restock
                        </a>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

<?php include '../../layouts/footer.php'; ?> 