<?php
// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$pageTitle = "Admin Dashboard";
include '../../layouts/header.php';
?>

<div class="stats-grid">
    <div class="stat-card">
        <h3>Total Products</h3>
        <div class="value">145</div>
        <div class="trend up">+5% <i class="fas fa-arrow-up"></i></div>
    </div>
    
    <div class="stat-card">
        <h3>Total Orders</h3>
        <div class="value">248</div>
        <div class="trend up">+18% <i class="fas fa-arrow-up"></i></div>
    </div>
    
    <div class="stat-card">
        <h3>Active Users</h3>
        <div class="value">12</div>
    </div>
    
    <div class="stat-card">
        <h3>Revenue (Monthly)</h3>
        <div class="value">$24,850</div>
        <div class="trend up">+22% <i class="fas fa-arrow-up"></i></div>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="card">
            <h2>Recent Orders</h2>
            <div class="table-container">
                <table>
                    <thead>
                        <tr>
                            <th>Order ID</th>
                            <th>Date</th>
                            <th>Status</th>
                            <th>Amount</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>#ORD-007</td>
                            <td>Mar 18, 2024</td>
                            <td><span class="badge badge-warning">Pending</span></td>
                            <td>$249.99</td>
                            <td><a href="orders.php?id=ORD-007" class="btn btn-sm">View</a></td>
                        </tr>
                        <tr>
                            <td>#ORD-006</td>
                            <td>Mar 17, 2024</td>
                            <td><span class="badge badge-success">Delivered</span></td>
                            <td>$124.50</td>
                            <td><a href="orders.php?id=ORD-006" class="btn btn-sm">View</a></td>
                        </tr>
                        <tr>
                            <td>#ORD-005</td>
                            <td>Mar 17, 2024</td>
                            <td><span class="badge badge-info">In Transit</span></td>
                            <td>$387.25</td>
                            <td><a href="orders.php?id=ORD-005" class="btn btn-sm">View</a></td>
                        </tr>
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
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Denim Jeans (XL)</td>
                            <td>Bottoms</td>
                            <td><span class="badge badge-danger">5</span></td>
                            <td><a href="inventory.php?action=restock&id=15" class="btn btn-sm">Restock</a></td>
                        </tr>
                        <tr>
                            <td>Cotton Dress Shirt</td>
                            <td>Tops</td>
                            <td><span class="badge badge-warning">12</span></td>
                            <td><a href="inventory.php?action=restock&id=23" class="btn btn-sm">Restock</a></td>
                        </tr>
                        <tr>
                            <td>Winter Jacket</td>
                            <td>Outerwear</td>
                            <td><span class="badge badge-warning">8</span></td>
                            <td><a href="inventory.php?action=restock&id=47" class="btn btn-sm">Restock</a></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="card mt-4">
    <h2>Recent User Activity</h2>
    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>User</th>
                    <th>Role</th>
                    <th>Action</th>
                    <th>Time</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Emma Johnson</td>
                    <td>Sales</td>
                    <td>Created Order #ORD-007</td>
                    <td>Today, 09:45 AM</td>
                </tr>
                <tr>
                    <td>Michael Chen</td>
                    <td>Staff</td>
                    <td>Updated Inventory</td>
                    <td>Today, 08:30 AM</td>
                </tr>
                <tr>
                    <td>Admin</td>
                    <td>Admin</td>
                    <td>Added New User</td>
                    <td>Yesterday, 04:15 PM</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

<?php include '../../layouts/footer.php'; ?> 