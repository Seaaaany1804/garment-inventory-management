<?php
// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$pageTitle = "Process Orders";
include '../../layouts/header.php';
?>

<div class="stats-grid">
    <div class="stat-card">
        <h3>Total Orders</h3>
        <div class="value">45</div>
    </div>
    
    <div class="stat-card">
        <h3>Pending</h3>
        <div class="value">12</div>
    </div>
    
    <div class="stat-card">
        <h3>Out for Delivery</h3>
        <div class="value">18</div>
    </div>
    
    <div class="stat-card">
        <h3>Delivered Today</h3>
        <div class="value">15</div>
    </div>
</div>

<div class="card">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Process Orders</h2>
        <div class="search-filter">
            <input type="text" class="form-control" placeholder="Search orders...">
        </div>
    </div>
    <div class="table-container">
        <table class="table">
            <thead>
                <tr>
                    <th class="text-white text-center">Order ID</th>
                    <th class="text-white text-center">Customer Name</th>
                    <th class="text-white text-center">Products</th>
                    <th class="text-white text-center">Quantity</th>
                    <th class="text-white text-center">Contact Number</th>
                    <th class="text-white text-center">Delivery Address</th>
                    <th class="text-white text-center">Order Date</th>
                    <th class="text-white text-center">Status</th>
                    <th class="text-white text-center">Actions</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="text-white text-center">#ORD-001</td>
                    <td class="text-white text-center">John Doe</td>
                    <td class="text-white text-center">Cotton T-Shirt</td>
                    <td class="text-white text-center">2</td>
                    <td class="text-white text-center">+63 912 345 6789</td>
                    <td class="text-white text-center">123 Main St, Manila</td>
                    <td class="text-white text-center">2024-03-20</td>
                    <td class="text-center"><span class="badge bg-warning">Pending</span></td>
                    <td class="text-center">
                        <button class="btn btn-sm btn-info" onclick="updateStatus('ORD-001', 'out_for_delivery')">
                            <i class="fas fa-truck"></i> Out for Delivery
                        </button>
                    </td>
                </tr>
                <tr>
                    <td class="text-white text-center">#ORD-002</td>
                    <td class="text-white text-center">Jane Smith</td>
                    <td class="text-white text-center">Denim Jeans</td>
                    <td class="text-white text-center">1</td>
                    <td class="text-white text-center">+63 923 456 7890</td>
                    <td class="text-white text-center">456 Oak Ave, Quezon City</td>
                    <td class="text-white text-center">2024-03-20</td>
                    <td class="text-center"><span class="badge bg-info">Out for Delivery</span></td>
                    <td class="text-center">
                        <button class="btn btn-sm btn-success" onclick="updateStatus('ORD-002', 'delivered')">
                            <i class="fas fa-check"></i> Mark Delivered
                        </button>
                    </td>
                </tr>
                <tr>
                    <td class="text-white text-center">#ORD-003</td>
                    <td class="text-white text-center">Mike Johnson</td>
                    <td class="text-white text-center">Winter Jacket</td>
                    <td class="text-white text-center">1</td>
                    <td class="text-white text-center">+63 934 567 8901</td>
                    <td class="text-white text-center">789 Pine St, Makati</td>
                    <td class="text-white text-center">2024-03-19</td>
                    <td class="text-center"><span class="badge bg-success">Delivered</span></td>
                    <td class="text-center">
                        <div class="d-flex justify-content-center gap-2">
                            <button class="btn btn-sm btn-primary" onclick="viewReceipt('ORD-003')">
                                <i class="fas fa-file-invoice"></i> View Receipt
                            </button>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

<!-- Update Status Modal -->
<div class="modal fade" id="updateStatusModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-dark">Update Order Status</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="updateStatusForm">
                    <div class="mb-3">
                        <label class="form-label text-dark">Order ID: <span id="modalOrderId" class="text-dark"></span></label>
                    </div>
                    <div class="mb-3">
                        <label for="deliveryNotes" class="form-label text-dark">Delivery Notes</label>
                        <textarea class="form-control" id="deliveryNotes" rows="3"></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" id="confirmStatusUpdate">Update Status</button>
            </div>
        </div>
    </div>
</div>

<!-- Receipt Modal -->
<div class="modal fade" id="receiptModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-dark">Order Receipt</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="receipt-content">
                    <div class="text-center mb-4">
                        <h4 class="text-dark">Garment Inventory Management</h4>
                        <p class="text-dark">Order Receipt</p>
                    </div>
                    <div class="order-details">
                        <p class="text-dark"><strong>Order ID:</strong> <span id="receiptOrderId"></span></p>
                        <p class="text-dark"><strong>Date:</strong> <span id="receiptDate"></span></p>
                        <p class="text-dark"><strong>Customer:</strong> <span id="receiptCustomer"></span></p>
                        <hr>
                        <div id="receiptItems">
                            <!-- Items will be populated dynamically -->
                        </div>
                        <hr>
                        <div class="delivery-info">
                            <p class="text-dark"><strong>Delivery Status:</strong> <span id="receiptStatus"></span></p>
                            <p class="text-dark"><strong>Delivery Date:</strong> <span id="receiptDeliveryDate"></span></p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" onclick="printReceipt()">
                    <i class="fas fa-print"></i> Print Receipt
                </button>
            </div>
        </div>
    </div>
</div>

<style>
    /* Add these styles to ensure proper text colors */
    .modal-content {
        background-color: white;
    }
    
    .modal input, 
    .modal select,
    .modal textarea {
        color: #333 !important;
    }
    
    .table tbody tr:hover td {
        color: white !important;
    }

    /* Button spacing */
    .btn-sm {
        margin: 0 2px;
    }

    /* Status badge styles */
    .badge {
        padding: 8px 12px;
        font-size: 0.85rem;
    }

    /* Receipt styling */
    .btn-group .btn {
        margin: 0 2px;
    }
    
    .receipt-content {
        padding: 20px;
    }
    
    .order-details {
        margin-top: 20px;
    }
    
    .order-details hr {
        margin: 15px 0;
        border-color: #dee2e6;
    }
    
    @media print {
        body * {
            visibility: hidden;
        }
        #receiptModal .modal-content * {
            visibility: visible;
        }
        #receiptModal .modal-content {
            position: absolute;
            left: 0;
            top: 0;
        }
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
    .table td:nth-child(6) {
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

    /* Button spacing */
    .gap-2 {
        gap: 0.75rem !important;
    }
    
    .btn-sm {
        min-width: 120px;
    }
</style>

<script>
    function updateStatus(orderId, status) {
        const modal = new bootstrap.Modal(document.getElementById('updateStatusModal'));
        document.getElementById('modalOrderId').textContent = orderId;
        
        // Store the status for use when confirming
        document.getElementById('confirmStatusUpdate').setAttribute('data-status', status);
        
        modal.show();
    }

    // Add event listener for the confirm button
    document.getElementById('confirmStatusUpdate').addEventListener('click', function() {
        const orderId = document.getElementById('modalOrderId').textContent;
        const status = this.getAttribute('data-status');
        const notes = document.getElementById('deliveryNotes').value;
        
        // Here you would typically make an AJAX call to update the status
        console.log(`Updating order ${orderId} to ${status} with notes: ${notes}`);
        
        // Close the modal
        bootstrap.Modal.getInstance(document.getElementById('updateStatusModal')).hide();
    });

    function viewReceipt(orderId) {
        // Fetch order details from database (mock data for now)
        const orderDetails = {
            orderId: orderId,
            date: '2024-03-19',
            customer: 'Mike Johnson',
            items: [
                { name: 'Winter Jacket', quantity: 1, price: '$89.99' }
            ],
            status: 'Delivered',
            deliveryDate: '2024-03-19 15:30'
        };

        // Populate receipt modal
        document.getElementById('receiptOrderId').textContent = orderDetails.orderId;
        document.getElementById('receiptDate').textContent = orderDetails.date;
        document.getElementById('receiptCustomer').textContent = orderDetails.customer;
        document.getElementById('receiptStatus').textContent = orderDetails.status;
        document.getElementById('receiptDeliveryDate').textContent = orderDetails.deliveryDate;

        // Populate items
        const itemsContainer = document.getElementById('receiptItems');
        itemsContainer.innerHTML = orderDetails.items.map(item => `
            <div class="d-flex justify-content-between text-dark">
                <span>${item.name} x${item.quantity}</span>
                <span>${item.price}</span>
            </div>
        `).join('');

        // Show modal
        const modal = new bootstrap.Modal(document.getElementById('receiptModal'));
        modal.show();
    }

    function printReceipt() {
        window.print();
    }
</script>

<?php include '../../layouts/footer.php'; ?>