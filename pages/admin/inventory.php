<?php
require_once '../../includes/auth/auth_check.php';
checkAuth('admin');

$page_title = "Inventory Management";

// Check if we're editing/adding an item
$edit_mode = isset($_GET['action']) && ($_GET['action'] === 'edit' || $_GET['action'] === 'add');
$item_id = isset($_GET['item']) ? $_GET['item'] : null;
$adding_new = isset($_GET['action']) && $_GET['action'] === 'add';

include '../../layouts/header.php';
?>

<?php if ($edit_mode): ?>
    <!-- Edit/Add Item Form -->
    <div class="card">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem;">
            <h2><?php echo $adding_new ? 'Add New Item' : 'Edit Item #' . htmlspecialchars($item_id); ?></h2>
            <a href="inventory.php" class="btn btn-sm">
                <i class="fas fa-arrow-left"></i> Back to Inventory
            </a>
        </div>
        
        <?php
        // Mock item data for editing (in a real app, this would come from a database)
        $item_data = [
            '1' => [
                'name' => 'T-Shirt Basic',
                'category' => 'Shirts',
                'description' => 'Basic cotton T-shirt in various colors',
                'price' => 19.99,
                'cost' => 8.50,
                'stock' => 250,
                'sku' => 'TSB001',
                'location' => 'Aisle A, Shelf 3',
                'min_stock' => 50
            ]
        ];
        
        // For new items or if item not found, use default values
        $item = $adding_new ? [
            'name' => '',
            'category' => '',
            'description' => '',
            'price' => '',
            'cost' => '',
            'stock' => 0,
            'sku' => '',
            'location' => '',
            'min_stock' => 10
        ] : ($item_data[$item_id] ?? [
            'name' => '',
            'category' => '',
            'description' => '',
            'price' => '',
            'cost' => '',
            'stock' => 0,
            'sku' => '',
            'location' => '',
            'min_stock' => 10
        ]);
        ?>
        
        <form action="" method="POST" class="item-form" style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem;">
            <div class="form-row">
                <label for="item_name">Item Name</label>
                <input type="text" id="item_name" name="item_name" class="form-control" value="<?php echo htmlspecialchars($item['name']); ?>" required>
            </div>
            
            <div class="form-row">
                <label for="category">Category</label>
                <select id="category" name="category" class="select-control" required>
                    <option value="">Select Category</option>
                    <option value="Shirts" <?php echo $item['category'] === 'Shirts' ? 'selected' : ''; ?>>Shirts</option>
                    <option value="Pants" <?php echo $item['category'] === 'Pants' ? 'selected' : ''; ?>>Pants</option>
                    <option value="Outerwear" <?php echo $item['category'] === 'Outerwear' ? 'selected' : ''; ?>>Outerwear</option>
                    <option value="Accessories" <?php echo $item['category'] === 'Accessories' ? 'selected' : ''; ?>>Accessories</option>
                </select>
            </div>
            
            <div class="form-row" style="grid-column: 1 / -1;">
                <label for="description">Description</label>
                <textarea id="description" name="description" class="form-control" rows="3"><?php echo htmlspecialchars($item['description']); ?></textarea>
            </div>
            
            <div class="form-row">
                <label for="price">Retail Price ($)</label>
                <input type="number" id="price" name="price" class="form-control" value="<?php echo htmlspecialchars($item['price']); ?>" step="0.01" min="0" required>
            </div>
            
            <div class="form-row">
                <label for="cost">Cost Price ($)</label>
                <input type="number" id="cost" name="cost" class="form-control" value="<?php echo htmlspecialchars($item['cost']); ?>" step="0.01" min="0" required>
            </div>
            
            <div class="form-row">
                <label for="stock">Current Stock</label>
                <input type="number" id="stock" name="stock" class="form-control" value="<?php echo htmlspecialchars($item['stock']); ?>" min="0" required>
            </div>
            
            <div class="form-row">
                <label for="min_stock">Minimum Stock Level</label>
                <input type="number" id="min_stock" name="min_stock" class="form-control" value="<?php echo htmlspecialchars($item['min_stock']); ?>" min="0" required>
            </div>
            
            <div class="form-row">
                <label for="sku">SKU</label>
                <input type="text" id="sku" name="sku" class="form-control" value="<?php echo htmlspecialchars($item['sku']); ?>" required>
            </div>
            
            <div class="form-row">
                <label for="location">Storage Location</label>
                <input type="text" id="location" name="location" class="form-control" value="<?php echo htmlspecialchars($item['location']); ?>">
            </div>
            
            <div class="form-row" style="grid-column: 1 / -1;">
                <label>Images</label>
                <div style="background: var(--background-dark); padding: 2rem; text-align: center; border-radius: 8px; border: 2px dashed var(--border-color);">
                    <i class="fas fa-cloud-upload-alt" style="font-size: 2rem; margin-bottom: 1rem; color: var(--text-secondary);"></i>
                    <p>Drag & drop images here or click to upload</p>
                    <input type="file" id="item_images" name="item_images[]" multiple style="display: none;">
                    <button type="button" class="btn btn-sm" style="margin-top: 1rem;" onclick="document.getElementById('item_images').click()">
                        Select Files
                    </button>
                </div>
            </div>
            
            <div style="grid-column: 1 / -1; margin-top: 1rem;">
                <button type="submit" class="btn btn-primary" style="width: auto;">
                    <i class="fas fa-save"></i> <?php echo $adding_new ? 'Add Item' : 'Save Changes'; ?>
                </button>
                
                <?php if (!$adding_new): ?>
                    <button type="button" class="btn btn-sm" style="background-color: rgba(255, 82, 82, 0.1); color: var(--danger-color); margin-left: 1rem;">
                        <i class="fas fa-trash"></i> Delete Item
                    </button>
                <?php endif; ?>
            </div>
        </form>
    </div>

<?php else: ?>
    <!-- Inventory List -->
    <div style="margin-bottom: 20px; display: flex; justify-content: space-between; flex-wrap: wrap; gap: 1rem;">
        <div style="display: flex; gap: 1rem; flex-wrap: wrap; flex: 1;">
            <div style="min-width: 200px; flex: 1;">
                <input type="text" placeholder="Search inventory..." class="form-control">
            </div>
            <select class="select-control" style="min-width: 150px;">
                <option value="">All Categories</option>
                <option value="Shirts">Shirts</option>
                <option value="Pants">Pants</option>
                <option value="Outerwear">Outerwear</option>
                <option value="Accessories">Accessories</option>
            </select>
            <select class="select-control" style="min-width: 150px;">
                <option value="">All Status</option>
                <option value="in_stock">In Stock</option>
                <option value="low_stock">Low Stock</option>
                <option value="out_of_stock">Out of Stock</option>
            </select>
        </div>
        <div>
            <a href="inventory.php?action=add" class="btn btn-primary" style="width: auto;">
                <i class="fas fa-plus"></i> Add New Item
            </a>
        </div>
    </div>

    <div class="card">
        <h2>Inventory Items</h2>
        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Image</th>
                        <th>Name</th>
                        <th>Category</th>
                        <th>Price</th>
                        <th>Stock</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>#001</td>
                        <td>
                            <div style="width: 40px; height: 40px; background: #444; border-radius: 4px;"></div>
                        </td>
                        <td>T-Shirt Basic</td>
                        <td>Shirts</td>
                        <td>$19.99</td>
                        <td>250</td>
                        <td><span class="badge badge-success">In Stock</span></td>
                        <td>
                            <a href="inventory.php?action=edit&item=1" class="btn btn-sm">
                                <i class="fas fa-edit"></i> Edit
                            </a>
                        </td>
                    </tr>
                    <tr>
                        <td>#002</td>
                        <td>
                            <div style="width: 40px; height: 40px; background: #444; border-radius: 4px;"></div>
                        </td>
                        <td>Denim Jeans</td>
                        <td>Pants</td>
                        <td>$49.99</td>
                        <td>15</td>
                        <td><span class="badge badge-warning">Low Stock</span></td>
                        <td>
                            <a href="inventory.php?action=edit&item=2" class="btn btn-sm">
                                <i class="fas fa-edit"></i> Edit
                            </a>
                        </td>
                    </tr>
                    <tr>
                        <td>#003</td>
                        <td>
                            <div style="width: 40px; height: 40px; background: #444; border-radius: 4px;"></div>
                        </td>
                        <td>Cotton Hoodie</td>
                        <td>Outerwear</td>
                        <td>$39.99</td>
                        <td>78</td>
                        <td><span class="badge badge-success">In Stock</span></td>
                        <td>
                            <a href="inventory.php?action=edit&item=3" class="btn btn-sm">
                                <i class="fas fa-edit"></i> Edit
                            </a>
                        </td>
                    </tr>
                    <tr>
                        <td>#004</td>
                        <td>
                            <div style="width: 40px; height: 40px; background: #444; border-radius: 4px;"></div>
                        </td>
                        <td>Polo Shirt</td>
                        <td>Shirts</td>
                        <td>$24.99</td>
                        <td>120</td>
                        <td><span class="badge badge-success">In Stock</span></td>
                        <td>
                            <a href="inventory.php?action=edit&item=4" class="btn btn-sm">
                                <i class="fas fa-edit"></i> Edit
                            </a>
                        </td>
                    </tr>
                    <tr>
                        <td>#005</td>
                        <td>
                            <div style="width: 40px; height: 40px; background: #444; border-radius: 4px;"></div>
                        </td>
                        <td>Casual Shorts</td>
                        <td>Pants</td>
                        <td>$29.99</td>
                        <td>85</td>
                        <td><span class="badge badge-success">In Stock</span></td>
                        <td>
                            <a href="inventory.php?action=edit&item=5" class="btn btn-sm">
                                <i class="fas fa-edit"></i> Edit
                            </a>
                        </td>
                    </tr>
                    <tr>
                        <td>#006</td>
                        <td>
                            <div style="width: 40px; height: 40px; background: #444; border-radius: 4px;"></div>
                        </td>
                        <td>Winter Jacket</td>
                        <td>Outerwear</td>
                        <td>$89.99</td>
                        <td>0</td>
                        <td><span class="badge badge-danger">Out of Stock</span></td>
                        <td>
                            <a href="inventory.php?action=edit&item=6" class="btn btn-sm">
                                <i class="fas fa-edit"></i> Edit
                            </a>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        
        <div style="margin-top: 1.5rem; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 1rem;">
            <div>
                <span style="color: var(--text-secondary);">Showing 1-6 of 24 items</span>
            </div>
            <div class="pagination" style="display: flex; gap: 0.5rem;">
                <a href="#" class="btn btn-sm">Previous</a>
                <a href="#" class="btn btn-sm" style="background-color: rgba(108, 99, 255, 0.2);">1</a>
                <a href="#" class="btn btn-sm">2</a>
                <a href="#" class="btn btn-sm">3</a>
                <a href="#" class="btn btn-sm">4</a>
                <a href="#" class="btn btn-sm">Next</a>
            </div>
        </div>
    </div>
    
    <div class="card">
        <h2>Inventory Summary</h2>
        <div class="stats-grid">
            <div class="stat-card">
                <h3>Total Items</h3>
                <div class="value">24</div>
            </div>
            
            <div class="stat-card">
                <h3>In Stock</h3>
                <div class="value">20</div>
            </div>
            
            <div class="stat-card">
                <h3>Low Stock</h3>
                <div class="value">3</div>
            </div>
            
            <div class="stat-card">
                <h3>Out of Stock</h3>
                <div class="value">1</div>
            </div>
        </div>
        
        <div style="margin-top: 1.5rem;">
            <h3>Quick Actions</h3>
            <div style="display: flex; gap: 1rem; margin-top: 1rem; flex-wrap: wrap;">
                <a href="#" class="btn btn-sm">
                    <i class="fas fa-file-export"></i> Export Inventory
                </a>
                <a href="#" class="btn btn-sm">
                    <i class="fas fa-print"></i> Print Report
                </a>
                <a href="#" class="btn btn-sm">
                    <i class="fas fa-file-import"></i> Import Items
                </a>
                <a href="#" class="btn btn-sm" style="background-color: rgba(255, 193, 7, 0.1); color: var(--warning-color);">
                    <i class="fas fa-bell"></i> Stock Alerts
                </a>
            </div>
        </div>
    </div>
<?php endif; ?>

<?php include '../../layouts/footer.php'; ?> 