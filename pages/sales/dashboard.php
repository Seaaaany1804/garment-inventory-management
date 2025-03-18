<?php
// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$pageTitle = "Sales Dashboard";
include '../../layouts/header.php';
?>

<div class="stats-grid">
    <div class="stat-card">
        <h3>Total Orders</h3>
        <div class="value">87</div>
        <div class="trend up">+12% <i class="fas fa-arrow-up"></i></div>
    </div>
    
    <div class="stat-card">
        <h3>Pending Orders</h3>
        <div class="value">14</div>
    </div>
    
    <div class="stat-card">
        <h3>Delivered Orders</h3>
        <div class="value">73</div>
    </div>
    
    <div class="stat-card">
        <h3>Available Items</h3>
        <div class="value">1,205</div>
    </div>
</div>

<div class="action-buttons" style="margin-bottom: 20px;">
    <a href="orders.php?action=new" class="btn btn-primary" style="width: auto; margin-right: 10px;">
        <i class="fas fa-plus"></i> New Order
    </a>
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
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>#ORD-001</td>
                    <td>Mar 18, 2024</td>
                    <td>John Smith</td>
                    <td>3</td>
                    <td><span class="badge badge-warning">Pending</span></td>
                    <td><a href="orders.php?id=ORD-001" class="btn btn-sm">View</a></td>
                </tr>
                <tr>
                    <td>#ORD-002</td>
                    <td>Mar 17, 2024</td>
                    <td>Emma Johnson</td>
                    <td>5</td>
                    <td><span class="badge badge-success">Delivered</span></td>
                    <td><a href="orders.php?id=ORD-002" class="btn btn-sm">View</a></td>
                </tr>
                <tr>
                    <td>#ORD-003</td>
                    <td>Mar 16, 2024</td>
                    <td>Michael Brown</td>
                    <td>2</td>
                    <td><span class="badge badge-info">In Transit</span></td>
                    <td><a href="orders.php?id=ORD-003" class="btn btn-sm">View</a></td>
                </tr>
            </tbody>
        </table>
    </div>
</div>


<?php include '../../layouts/footer.php'; ?> 