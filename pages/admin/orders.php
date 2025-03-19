<?php
// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once '../../includes/auth/auth_check.php';
checkAuth('admin');

$pageTitle = "Order Management";
include '../../layouts/header.php';

// Sample filter state - in a real app, this would come from a database query
$statusFilter = isset($_GET['status']) ? $_GET['status'] : 'all';

// Sample orders data - in a real app, this would come from a database
$orders = [
    [
        'id' => 'ORD-2024-001',
        'customer' => 'John Smith',
        'date' => '2024-03-18',
        'total' => 245.50,
        'items' => 3,
        'status' => 'pending',
        'payment' => 'Credit Card'
    ],
    [
        'id' => 'ORD-2024-002',
        'customer' => 'Jane Doe',
        'date' => '2024-03-17',
        'total' => 120.75,
        'items' => 2,
        'status' => 'shipped',
        'payment' => 'PayPal'
    ],
    [
        'id' => 'ORD-2024-003',
        'customer' => 'Robert Johnson',
        'date' => '2024-03-15',
        'total' => 540.00,
        'items' => 5,
        'status' => 'delivered',
        'payment' => 'Credit Card'
    ],
    [
        'id' => 'ORD-2024-005',
        'customer' => 'Michael Brown',
        'date' => '2024-03-12',
        'total' => 315.80,
        'items' => 4,
        'status' => 'pending',
        'payment' => 'Credit Card'
    ],
    [
        'id' => 'ORD-2024-006',
        'customer' => 'Emily Davis',
        'date' => '2024-03-10',
        'total' => 180.00,
        'items' => 2,
        'status' => 'shipped',
        'payment' => 'PayPal'
    ],
    [
        'id' => 'ORD-2024-007',
        'customer' => 'David Miller',
        'date' => '2024-03-08',
        'total' => 420.50,
        'items' => 3,
        'status' => 'delivered',
        'payment' => 'Credit Card'
    ]
];

// Filter orders based on status if a filter is set
if ($statusFilter !== 'all') {
    $orders = array_filter($orders, function($order) use ($statusFilter) {
        return $order['status'] === $statusFilter;
    });
}

// Get counts for each status
$counts = [
    'all' => count($orders),
    'pending' => count(array_filter($orders, function($order) { return $order['status'] === 'pending'; })),
    'shipped' => count(array_filter($orders, function($order) { return $order['status'] === 'shipped'; })),
    'delivered' => count(array_filter($orders, function($order) { return $order['status'] === 'delivered'; }))
];
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
                        <th style="padding: 12px 16px; color: #9ca3af; font-weight: 500; border-bottom: 1px solid #374151;">Status</th>
                        <th style="padding: 12px 16px; color: #9ca3af; font-weight: 500; border-bottom: 1px solid #374151;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($orders as $order): ?>
                    <tr style="border-bottom: 1px solid #374151;">
                        <td style="padding: 12px 16px; color: #e2e8f0;">
                            <span style="font-weight: 500;"><?php echo $order['id']; ?></span>
                        </td>
                        <td style="padding: 12px 16px; color: #e2e8f0;"><?php echo $order['customer']; ?></td>
                        <td style="padding: 12px 16px; color: #e2e8f0;"><?php echo date('M d, Y', strtotime($order['date'])); ?></td>
                        <td style="padding: 12px 16px; color: #e2e8f0;">₱<?php echo number_format($order['total'], 2); ?></td>
                        <td style="padding: 12px 16px; color: #e2e8f0;"><?php echo $order['items']; ?></td>
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
                            <button class="view-receipt-btn" data-order-id="<?php echo $order['id']; ?>" style="background: none; border: none; color: #6366F1; cursor: pointer; padding: 8px 12px; border-radius: 6px; background-color: rgba(99, 102, 241, 0.1); font-size: 0.875rem; display: flex; align-items: center; gap: 6px;">
                                <i class="fas fa-receipt"></i> View Receipt
                            </button>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Order Receipt Modal -->
<div id="receipt-modal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0, 0, 0, 0.5); z-index: 1000; justify-content: center; align-items: center;">
    <div class="modal-content" style="background-color: #1e293b; border-radius: 12px; box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25); max-width: 600px; width: 90%; max-height: 90vh; overflow-y: auto; padding: 0;">
        <div class="modal-header" style="padding: 16px 24px; border-bottom: 1px solid #374151; display: flex; justify-content: space-between; align-items: center;">
            <h3 style="margin: 0; color: #e2e8f0; font-size: 1.25rem; font-weight: 600;">Order Receipt</h3>
            <button id="close-modal" style="background: none; border: none; color: #9ca3af; cursor: pointer; font-size: 1.25rem; padding: 4px;">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <div class="modal-body" style="padding: 24px;">
            <div id="receipt-content">
                <!-- Receipt content will be loaded here -->
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Sample receipt data - in a real app, this would come from an AJAX call
    const receiptData = {
        'ORD-2024-001': {
            orderId: 'ORD-2024-001',
            date: 'Mar 18, 2024',
            customer: {
                name: 'John Smith',
                email: 'john.smith@example.com',
                address: '123 Main St, Anytown, USA 12345'
            },
            items: [
                { name: 'Premium T-Shirt', quantity: 1, price: 29.99 },
                { name: 'Designer Jeans', quantity: 1, price: 89.99 },
                { name: 'Cotton Hoodie', quantity: 1, price: 59.99 }
            ],
            subtotal: 179.97,
            shipping: 15.53,
            tax: 50.00,
            total: 245.50,
            payment: 'Credit Card',
            status: 'pending'
        },
        'ORD-2024-002': {
            orderId: 'ORD-2024-002',
            date: 'Mar 17, 2024',
            customer: {
                name: 'Jane Doe',
                email: 'jane.doe@example.com',
                address: '456 Oak Ave, Somewhere, USA 67890'
            },
            items: [
                { name: 'Summer Dress', quantity: 1, price: 79.99 },
                { name: 'Leather Belt', quantity: 1, price: 24.99 }
            ],
            subtotal: 104.98,
            shipping: 7.77,
            tax: 8.00,
            total: 120.75,
            payment: 'PayPal',
            status: 'shipped'
        },
        'ORD-2024-003': {
            orderId: 'ORD-2024-003',
            date: 'Mar 15, 2024',
            customer: {
                name: 'Robert Johnson',
                email: 'robert.johnson@example.com',
                address: '789 Pine Rd, Elsewhere, USA 54321'
            },
            items: [
                { name: 'Winter Jacket', quantity: 1, price: 199.99 },
                { name: 'Wool Scarf', quantity: 2, price: 45.00 },
                { name: 'Thermal Gloves', quantity: 1, price: 35.00 },
                { name: 'Beanie Hat', quantity: 1, price: 25.00 }
            ],
            subtotal: 349.99,
            shipping: 135.01,
            tax: 55.00,
            total: 540.00,
            payment: 'Credit Card',
            status: 'delivered'
        },
        'ORD-2024-005': {
            orderId: 'ORD-2024-005',
            date: 'Mar 12, 2024',
            customer: {
                name: 'Michael Brown',
                email: 'michael.brown@example.com',
                address: '234 Elm St, Nowhere, USA 98765'
            },
            items: [
                { name: 'Running Shoes', quantity: 1, price: 129.99 },
                { name: 'Athletic Shorts', quantity: 2, price: 34.99 },
                { name: 'Sports T-Shirt', quantity: 1, price: 29.99 }
            ],
            subtotal: 229.96,
            shipping: 35.84,
            tax: 50.00,
            total: 315.80,
            payment: 'Credit Card',
            status: 'pending'
        },
        'ORD-2024-006': {
            orderId: 'ORD-2024-006',
            date: 'Mar 10, 2024',
            customer: {
                name: 'Emily Davis',
                email: 'emily.davis@example.com',
                address: '567 Maple Ave, Anyplace, USA 13579'
            },
            items: [
                { name: 'Formal Blouse', quantity: 1, price: 89.99 },
                { name: 'Pencil Skirt', quantity: 1, price: 69.99 }
            ],
            subtotal: 159.98,
            shipping: 10.02,
            tax: 10.00,
            total: 180.00,
            payment: 'PayPal',
            status: 'shipped'
        },
        'ORD-2024-007': {
            orderId: 'ORD-2024-007',
            date: 'Mar 08, 2024',
            customer: {
                name: 'David Miller',
                email: 'david.miller@example.com',
                address: '890 Cedar Ln, Somewhere Else, USA 24680'
            },
            items: [
                { name: 'Casual Shoes', quantity: 1, price: 89.99 },
                { name: 'Denim Jacket', quantity: 1, price: 129.99 },
                { name: 'Graphic T-Shirt', quantity: 2, price: 24.99 }
            ],
            subtotal: 269.96,
            shipping: 90.54,
            tax: 60.00,
            total: 420.50,
            payment: 'Credit Card',
            status: 'delivered'
        }
    };
    
    // Receipt Modal Functionality
    const modal = document.getElementById('receipt-modal');
    const closeModalBtn = document.getElementById('close-modal');
    const receiptContent = document.getElementById('receipt-content');
    
    // Show modal and load receipt when "View Receipt" button is clicked
    const viewReceiptBtns = document.querySelectorAll('.view-receipt-btn');
    viewReceiptBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            const orderId = this.getAttribute('data-order-id');
            const receipt = receiptData[orderId];
            
            if (receipt) {
                // Generate receipt HTML
                let itemsHtml = '';
                let itemTotal = 0;
                
                receipt.items.forEach(item => {
                    const itemSubtotal = item.quantity * item.price;
                    itemTotal += itemSubtotal;
                    
                    itemsHtml += `
                    <tr style="border-bottom: 1px solid #374151;">
                        <td style="padding: 12px 8px; color: #e2e8f0;">${item.name}</td>
                        <td style="padding: 12px 8px; color: #e2e8f0; text-align: center;">${item.quantity}</td>
                        <td style="padding: 12px 8px; color: #e2e8f0; text-align: right;">₱${item.price.toFixed(2)}</td>
                        <td style="padding: 12px 8px; color: #e2e8f0; text-align: right;">₱${itemSubtotal.toFixed(2)}</td>
                    </tr>
                    `;
                });
                
                // Status badge styles
                let statusColor = '';
                let statusBg = '';
                switch (receipt.status) {
                    case 'pending':
                        statusColor = '#F97316';
                        statusBg = 'rgba(249, 115, 22, 0.1)';
                        break;
                    case 'shipped':
                        statusColor = '#0EA5E9';
                        statusBg = 'rgba(14, 165, 233, 0.1)';
                        break;
                    case 'delivered':
                        statusColor = '#10B981';
                        statusBg = 'rgba(16, 185, 129, 0.1)';
                        break;
                }
                
                const receiptHtml = `
                    <div style="background-color: #111827; padding: 20px; border-radius: 8px; margin-bottom: 24px;">
                        <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 16px; flex-wrap: wrap; gap: 12px;">
                            <div>
                                <h4 style="margin: 0 0 8px 0; color: #e2e8f0; font-size: 1rem;">Order ID:</h4>
                                <p style="margin: 0; color: #e2e8f0; font-weight: 600;">${receipt.orderId}</p>
                            </div>
                            <div>
                                <h4 style="margin: 0 0 8px 0; color: #e2e8f0; font-size: 1rem;">Date:</h4>
                                <p style="margin: 0; color: #e2e8f0;">${receipt.date}</p>
                            </div>
                            <div>
                                <h4 style="margin: 0 0 8px 0; color: #e2e8f0; font-size: 1rem;">Status:</h4>
                                <span style="display: inline-block; padding: 4px 12px; border-radius: 20px; font-size: 0.75rem; background-color: ${statusBg}; color: ${statusColor}; font-weight: 500; text-transform: capitalize;">
                                    ${receipt.status}
                                </span>
                            </div>
                        </div>
                    </div>
                    
                    <div style="margin-bottom: 24px;">
                        <h4 style="margin: 0 0 12px 0; color: #e2e8f0; font-size: 1rem;">Customer Information</h4>
                        <p style="margin: 0 0 8px 0; color: #e2e8f0; font-weight: 600;">${receipt.customer.name}</p>
                        <p style="margin: 0 0 8px 0; color: #9ca3af;">${receipt.customer.email}</p>
                        <p style="margin: 0; color: #9ca3af; white-space: pre-line;">${receipt.customer.address}</p>
                    </div>
                    
                    <h4 style="margin: 0 0 12px 0; color: #e2e8f0; font-size: 1rem; padding-bottom: 8px; border-bottom: 1px solid #374151;">Order Items</h4>
                    <div style="margin-bottom: 24px;">
                        <table style="width: 100%; border-collapse: collapse;">
                            <thead>
                                <tr style="border-bottom: 1px solid #374151;">
                                    <th style="padding: 12px 8px; text-align: left; color: #9ca3af; font-weight: 500;">Item</th>
                                    <th style="padding: 12px 8px; text-align: center; color: #9ca3af; font-weight: 500;">Qty</th>
                                    <th style="padding: 12px 8px; text-align: right; color: #9ca3af; font-weight: 500;">Price</th>
                                    <th style="padding: 12px 8px; text-align: right; color: #9ca3af; font-weight: 500;">Subtotal</th>
                                </tr>
                            </thead>
                            <tbody>
                                ${itemsHtml}
                            </tbody>
                        </table>
                    </div>
                    
                    <div style="background-color: #111827; padding: 20px; border-radius: 8px;">
                        <div style="display: flex; justify-content: space-between; font-weight: 600; font-size: 1.125rem;">
                            <span style="color: #e2e8f0;">Total:</span>
                            <span style="color: #e2e8f0;">₱${receipt.total.toFixed(2)}</span>
                        </div>
                    </div>
                `;
                
                receiptContent.innerHTML = receiptHtml;
                modal.style.display = 'flex';
            }
        });
    });
    
    // Close modal when "Close" button is clicked
    closeModalBtn.addEventListener('click', function() {
        modal.style.display = 'none';
    });
    
    // Close modal when clicking outside
    modal.addEventListener('click', function(e) {
        if (e.target === modal) {
            modal.style.display = 'none';
        }
    });
    
    // Close modal with ESC key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape' && modal.style.display === 'flex') {
            modal.style.display = 'none';
        }
    });
});
</script>

<?php include '../../layouts/footer.php'; ?>