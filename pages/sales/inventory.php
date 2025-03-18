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
                    <a href="orders.php?action=new&item=1" class="btn btn-sm">
                        <i class="fas fa-shopping-cart"></i> Order
                    </a>
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

<div class="card">
    <h2>Item Categories</h2>
    <div class="category-grid" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(200px, 1fr)); gap: 1rem; margin-top: 1rem;">
        <div class="category-card" style="background: var(--background-dark); padding: 1.5rem; border-radius: 10px; text-align: center; border: 1px solid var(--border-color);">
            <i class="fas fa-tshirt" style="font-size: 2rem; color: var(--primary-color); margin-bottom: 1rem;"></i>
            <h3>Shirts</h3>
            <p>42 items</p>
        </div>
        <div class="category-card" style="background: var(--background-dark); padding: 1.5rem; border-radius: 10px; text-align: center; border: 1px solid var(--border-color);">
            <i class="fas fa-socks" style="font-size: 2rem; color: var(--primary-color); margin-bottom: 1rem;"></i>
            <h3>Pants</h3>
            <p>28 items</p>
        </div>
        <div class="category-card" style="background: var(--background-dark); padding: 1.5rem; border-radius: 10px; text-align: center; border: 1px solid var(--border-color);">
            <i class="fas fa-mitten" style="font-size: 2rem; color: var(--primary-color); margin-bottom: 1rem;"></i>
            <h3>Outerwear</h3>
            <p>15 items</p>
        </div>
        <div class="category-card" style="background: var(--background-dark); padding: 1.5rem; border-radius: 10px; text-align: center; border: 1px solid var(--border-color);">
            <i class="fas fa-hat-cowboy" style="font-size: 2rem; color: var(--primary-color); margin-bottom: 1rem;"></i>
            <h3>Accessories</h3>
            <p>35 items</p>
        </div>
    </div>
</div>

<?php include '../../layouts/footer.php'; ?> 