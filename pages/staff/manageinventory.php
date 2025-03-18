<?php
// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$pageTitle = "Manage Inventory";
include '../../layouts/header.php';
?>

<div class="stats-grid">
    <div class="stat-card">
        <h3>Total Products</h3>
        <div class="value">156</div>
    </div>
    
    <div class="stat-card">
        <h3>Low Stock Items</h3>
        <div class="value">8</div>
    </div>
    
    <div class="stat-card">
        <h3>Out of Stock</h3>
        <div class="value">3</div>
    </div>
    
    <div class="stat-card">
        <h3>Categories</h3>
        <div class="value">12</div>
    </div>
</div>

<div class="card">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Inventory Items</h2>
        <div class="search-filter">
            <input type="text" class="form-control" placeholder="Search items...">
        </div>
    </div>
    <div class="table-container">
        <table class="table">
            <thead>
                <tr>
                    <th class="text-white text-center">Product ID</th>
                    <th class="text-white text-center">Product Name</th>
                    <th class="text-white text-center">Category</th>
                    <th class="text-white text-center">Current Stock</th>
                    <th class="text-white text-center">Quantity Ordered</th>
                    <th class="text-white text-center">Status</th>
                    <th class="text-white text-center">Actions</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="text-white text-center">#PRD-001</td>
                    <td class="text-white text-center">Cotton T-Shirt</td>
                    <td class="text-white text-center">T-Shirts</td>
                    <td class="text-white text-center">45</td>
                    <td class="text-white text-center">5</td>
                    <td class="text-center"><span class="badge bg-success">In Stock</span></td>
                    <td class="text-center">
                        <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#updateStockModal">
                            <i class="fas fa-edit"></i> Update Stock
                        </button>
                    </td>
                </tr>
                <tr>
                    <td class="text-white text-center">#PRD-002</td>
                    <td class="text-white text-center">Denim Jeans</td>
                    <td class="text-white text-center">Pants</td>
                    <td class="text-white text-center">15</td>
                    <td class="text-white text-center">2</td>
                    <td class="text-center"><span class="badge bg-warning">Low Stock</span></td>
                    <td class="text-center">
                        <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#updateStockModal">
                            <i class="fas fa-edit"></i> Update Stock
                        </button>
                    </td>
                </tr>
                <tr>
                    <td class="text-white text-center">#PRD-003</td>
                    <td class="text-white text-center">Winter Jacket</td>
                    <td class="text-white text-center">Outerwear</td>
                    <td class="text-white text-center">0</td>
                    <td class="text-white text-center">1</td>
                    <td class="text-center"><span class="badge bg-danger">Out of Stock</span></td>
                    <td class="text-center">
                        <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#updateStockModal">
                            <i class="fas fa-edit"></i> Update Stock
                        </button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

<!-- Update Stock Modal -->
<div class="modal fade" id="updateStockModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-dark">Update Stock</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="updateStockForm">
                    <div class="mb-3">
                        <label for="currentStock" class="form-label text-dark">Current Stock</label>
                        <input type="number" class="form-control" id="currentStock" readonly>
                    </div>
                    <div class="mb-3">
                        <label for="adjustStock" class="form-label text-dark">Adjust Stock</label>
                        <input type="number" class="form-control" id="adjustStock" required>
                    </div>
                    <div class="mb-3">
                        <label for="reason" class="form-label text-dark">Reason</label>
                        <select class="form-select" id="reason" required>
                            <option value="" class="text-dark">Select reason</option>
                            <option value="restock" class="text-dark">Restock</option>
                            <option value="damage" class="text-dark">Damaged Items</option>
                            <option value="correction" class="text-dark">Stock Correction</option>
                        </select>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary">Update Stock</button>
            </div>
        </div>
    </div>
</div>

<style>
    /* Add these styles to ensure proper text colors in the modal */
    .modal-content {
        background-color: white;
    }
    
    .modal input, 
    .modal select {
        color: #333 !important;
    }
    
    /* Ensure table hover state maintains white text */
    .table tbody tr:hover td {
        color: white !important;
    }

    /* Add these styles for better table layout */
    .table {
        width: 100%;
        white-space: nowrap;
    }

    .table-container {
        overflow-x: auto;
        margin-bottom: 1rem;
    }

    /* Make address cell wrap if needed */
    .table td:nth-child(7) {
        white-space: normal;
        max-width: 200px;
    }

    /* Center align all table content */
    .table th,
    .table td {
        vertical-align: middle;
    }

    /* Add hover effect */
    .table tbody tr:hover {
        background-color: rgba(255, 255, 255, 0.1);
    }
</style>

<?php include '../../layouts/footer.php'; ?>