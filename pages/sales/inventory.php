<?php
require_once '../../includes/auth/auth_check.php';
checkAuth('sales');

$page_title = "Inventory";
include '../../layouts/header.php';
?>

<div class="card">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem; flex-wrap: wrap; gap: 1rem;">
        <h2>Available Items</h2>
        
        <div style="display: flex; gap: 1rem; flex-wrap: wrap;">
            <div style="min-width: 250px;">
                <input type="text" placeholder="Search items..." class="form-control">
            </div>
            <div style="min-width: 150px;">
                <select class="select-control">
                    <option value="">All Categories</option>
                    <option value="shirts">Shirts</option>
                    <option value="pants">Pants</option>
                    <option value="outerwear">Outerwear</option>
                    <option value="accessories">Accessories</option>
                </select>
            </div>
        </div>
    </div>
    
    <div class="item-grid-view" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 1.5rem;">
        <!-- Item Card 1 -->
        <div class="item-card">
            <div class="item-image placeholder"></div>
            <div class="item-details">
                <div style="display: flex; justify-content: space-between; align-items: start;">
                    <h3>T-Shirt Basic</h3>
                    <span class="badge badge-success">In Stock</span>
                </div>
                <p>Category: Shirts</p>
                <p>Stock: 250 units</p>
                <div style="display: flex; justify-content: space-between; align-items: center; margin-top: 0.5rem;">
                    <div class="item-price">$19.99</div>
                    <button onclick="createOrder(1, 'T-Shirt Basic', 250, 19.99)" class="btn btn-sm">
                        <i class="fas fa-shopping-cart"></i> Order
                    </button>
                </div>
            </div>
        </div>
        
        <!-- Item Card 2 -->
        <div class="item-card">
            <div class="item-image placeholder"></div>
            <div class="item-details">
                <div style="display: flex; justify-content: space-between; align-items: start;">
                    <h3>Denim Jeans</h3>
                    <span class="badge badge-warning">Low Stock</span>
                </div>
                <p>Category: Pants</p>
                <p>Stock: 15 units</p>
                <div style="display: flex; justify-content: space-between; align-items: center; margin-top: 0.5rem;">
                    <div class="item-price">$49.99</div>
                    <a href="orders.php?action=new&item=2" class="btn btn-sm">
                        <i class="fas fa-shopping-cart"></i> Order
                    </a>
                </div>
            </div>
        </div>
        
        <!-- Item Card 3 -->
        <div class="item-card">
            <div class="item-image placeholder"></div>
            <div class="item-details">
                <div style="display: flex; justify-content: space-between; align-items: start;">
                    <h3>Cotton Hoodie</h3>
                    <span class="badge badge-success">In Stock</span>
                </div>
                <p>Category: Outerwear</p>
                <p>Stock: 78 units</p>
                <div style="display: flex; justify-content: space-between; align-items: center; margin-top: 0.5rem;">
                    <div class="item-price">$39.99</div>
                    <a href="orders.php?action=new&item=3" class="btn btn-sm">
                        <i class="fas fa-shopping-cart"></i> Order
                    </a>
                </div>
            </div>
        </div>
        
        <!-- Item Card 4 -->
        <div class="item-card">
            <div class="item-image placeholder"></div>
            <div class="item-details">
                <div style="display: flex; justify-content: space-between; align-items: start;">
                    <h3>Polo Shirt</h3>
                    <span class="badge badge-success">In Stock</span>
                </div>
                <p>Category: Shirts</p>
                <p>Stock: 120 units</p>
                <div style="display: flex; justify-content: space-between; align-items: center; margin-top: 0.5rem;">
                    <div class="item-price">$24.99</div>
                    <a href="orders.php?action=new&item=4" class="btn btn-sm">
                        <i class="fas fa-shopping-cart"></i> Order
                    </a>
                </div>
            </div>
        </div>
        
        <!-- Item Card 5 -->
        <div class="item-card">
            <div class="item-image placeholder"></div>
            <div class="item-details">
                <div style="display: flex; justify-content: space-between; align-items: start;">
                    <h3>Casual Shorts</h3>
                    <span class="badge badge-success">In Stock</span>
                </div>
                <p>Category: Pants</p>
                <p>Stock: 85 units</p>
                <div style="display: flex; justify-content: space-between; align-items: center; margin-top: 0.5rem;">
                    <div class="item-price">$29.99</div>
                    <a href="orders.php?action=new&item=5" class="btn btn-sm">
                        <i class="fas fa-shopping-cart"></i> Order
                    </a>
                </div>
            </div>
        </div>
        
        <!-- Item Card 6 -->
        <div class="item-card">
            <div class="item-image placeholder"></div>
            <div class="item-details">
                <div style="display: flex; justify-content: space-between; align-items: start;">
                    <h3>Winter Jacket</h3>
                    <span class="badge badge-danger">Out of Stock</span>
                </div>
                <p>Category: Outerwear</p>
                <p>Stock: 0 units</p>
                <div style="display: flex; justify-content: space-between; align-items: center; margin-top: 0.5rem;">
                    <div class="item-price">$89.99</div>
                    <a href="#" class="btn btn-sm" style="opacity: 0.5; cursor: not-allowed;">
                        <i class="fas fa-shopping-cart"></i> Order
                    </a>
                </div>
            </div>
        </div>
    </div>
    
    <div style="margin-top: 1.5rem; display: flex; justify-content: center;">
        <div class="pagination" style="display: flex; gap: 0.5rem;">
            <a href="#" class="btn btn-sm">Previous</a>
            <a href="#" class="btn btn-sm" style="background-color: rgba(108, 99, 255, 0.2);">1</a>
            <a href="#" class="btn btn-sm">2</a>
            <a href="#" class="btn btn-sm">3</a>
            <a href="#" class="btn btn-sm">Next</a>
        </div>
    </div>
</div>

<!-- Create Order Modal -->
<div class="modal fade" id="createOrderModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-dark">Create Order</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="createOrderForm">
                    <!-- Product Information -->
                    <div class="mb-3">
                        <label class="form-label text-dark">Product: <span id="modalProductName" class="text-dark fw-bold"></span></label>
                    </div>
                    <div class="mb-3">
                        <label class="form-label text-dark">Available Stock: <span id="modalAvailableStock" class="text-dark"></span></label>
                    </div>
                    <div class="mb-3">
                        <label class="form-label text-dark">Price per unit: <span id="modalPrice" class="text-dark"></span></label>
                    </div>
                    
                    <!-- Order Details -->
                    <div class="mb-3">
                        <label for="orderQuantity" class="form-label text-dark">Quantity</label>
                        <input type="number" class="form-control" id="orderQuantity" required min="1">
                        <small class="text-muted">Maximum order: <span id="maxOrder">0</span> units</small>
                    </div>
                    
                    <div class="mb-3">
                        <label for="customerName" class="form-label text-dark">Customer Name</label>
                        <input type="text" class="form-control" id="customerName" required>
                    </div>
                    
                    <div class="mb-3">
                        <label for="customerContact" class="form-label text-dark">Contact Number</label>
                        <input type="tel" class="form-control" id="customerContact" required>
                    </div>
                    
                    <div class="mb-3">
                        <label for="deliveryAddress" class="form-label text-dark">Delivery Address</label>
                        <textarea class="form-control" id="deliveryAddress" rows="3" required></textarea>
                    </div>
                    
                    <!-- Order Summary -->
                    <div class="card bg-light mb-3">
                        <div class="card-body">
                            <h6 class="card-title text-dark">Order Summary</h6>
                            <div class="d-flex justify-content-between">
                                <span class="text-dark">Subtotal:</span>
                                <span class="text-dark" id="subtotal">$0.00</span>
                            </div>
                            <div class="d-flex justify-content-between">
                                <span class="text-dark">Delivery Fee:</span>
                                <span class="text-dark">$5.00</span>
                            </div>
                            <hr>
                            <div class="d-flex justify-content-between fw-bold">
                                <span class="text-dark">Total:</span>
                                <span class="text-dark" id="totalAmount">$0.00</span>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" id="confirmOrder">Place Order</button>
            </div>
        </div>
    </div>
</div>

<script>
    function createOrder(productId, productName, stock, price) {
        // Populate modal with product details
        document.getElementById('modalProductName').textContent = productName;
        document.getElementById('modalAvailableStock').textContent = stock + ' units';
        document.getElementById('modalPrice').textContent = '$' + price;
        document.getElementById('maxOrder').textContent = stock;
        
        // Set maximum order quantity
        document.getElementById('orderQuantity').max = stock;
        
        // Calculate total on quantity change
        document.getElementById('orderQuantity').addEventListener('input', function() {
            const quantity = this.value;
            const subtotal = quantity * price;
            document.getElementById('subtotal').textContent = '$' + subtotal.toFixed(2);
            document.getElementById('totalAmount').textContent = '$' + (subtotal + 5).toFixed(2);
        });
        
        // Show modal
        const modal = new bootstrap.Modal(document.getElementById('createOrderModal'));
        modal.show();
    }

    // Handle order confirmation
    document.getElementById('confirmOrder').addEventListener('click', function() {
        const orderData = {
            product: document.getElementById('modalProductName').textContent,
            quantity: document.getElementById('orderQuantity').value,
            customerName: document.getElementById('customerName').value,
            contact: document.getElementById('customerContact').value,
            address: document.getElementById('deliveryAddress').value,
            total: document.getElementById('totalAmount').textContent
        };

        // Validate form
        if (!document.getElementById('createOrderForm').checkValidity()) {
            alert('Please fill in all required fields');
            return;
        }

        // Here you would typically make an AJAX call to process the order
        console.log('Order details:', orderData);
        
        // Close modal
        bootstrap.Modal.getInstance(document.getElementById('createOrderModal')).hide();
        
        // Show success message
        alert('Order placed successfully!');
    });
</script>

<style>
    /* Add these styles to your existing styles */
    .modal-content {
        background-color: white;
    }
    
    .modal input, 
    .modal select,
    .modal textarea {
        color: #333 !important;
        background-color: #fff;
    }
    
    .card.bg-light {
        background-color: #f8f9fa !important;
    }
    
    .text-muted {
        color: #6c757d !important;
    }
    
    /* Make sure form controls are properly visible */
    .form-control:focus {
        color: #333;
        background-color: #fff;
        border-color: #6c63ff;
        box-shadow: 0 0 0 0.2rem rgba(108, 99, 255, 0.25);
    }
</style>

<?php include '../../layouts/footer.php'; ?> 