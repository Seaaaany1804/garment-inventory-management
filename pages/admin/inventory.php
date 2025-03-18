<?php
require_once '../../includes/auth/auth_check.php';
checkAuth('admin');

$page_title = "Inventory Management";

// Search functionality
$search_query = isset($_GET['search']) ? $_GET['search'] : '';
$category_filter = isset($_GET['category']) ? $_GET['category'] : '';
$status_filter = isset($_GET['status']) ? $_GET['status'] : '';

include '../../layouts/header.php';
?>

<div style="display: flex; flex-direction: column; min-height: calc(100vh - 80px);">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
        <h1><?php echo $page_title; ?></h1>
        <button class="btn btn-primary" style="width: auto;" onclick="openAddModal()">
            <i class="fas fa-plus"></i> Add New Item
        </button>
    </div>

    <!-- Inventory List -->
    <div class="card" style="flex: 1; display: flex; flex-direction: column;">
        <h2>Inventory Items</h2>
        
        <form method="GET" action="inventory.php">
            <div style="margin-bottom: 20px; display: flex; justify-content: space-between; gap: 1rem; flex-wrap: nowrap; padding: 10px; border-radius: 6px;">
                <div style="flex: 1;">
                    <input type="text" name="search" placeholder="Search inventory..." class="form-control" style="background-color: white; color: black;" value="<?php echo htmlspecialchars($search_query); ?>">
                </div>
                <select name="category" class="select-control" style="width: 150px; background-color: white; color: black;">
                    <option value="">All Categories</option>
                    <option value="Shirts" <?php echo $category_filter === 'Shirts' ? 'selected' : ''; ?>>Shirts</option>
                    <option value="Pants" <?php echo $category_filter === 'Pants' ? 'selected' : ''; ?>>Pants</option>
                    <option value="Outerwear" <?php echo $category_filter === 'Outerwear' ? 'selected' : ''; ?>>Outerwear</option>
                    <option value="Accessories" <?php echo $category_filter === 'Accessories' ? 'selected' : ''; ?>>Accessories</option>
                </select>
                <select name="status" class="select-control" style="width: 150px; background-color: white; color: black;">
                    <option value="">All Status</option>
                    <option value="in_stock" <?php echo $status_filter === 'in_stock' ? 'selected' : ''; ?>>In Stock</option>
                    <option value="low_stock" <?php echo $status_filter === 'low_stock' ? 'selected' : ''; ?>>Low Stock</option>
                    <option value="out_of_stock" <?php echo $status_filter === 'out_of_stock' ? 'selected' : ''; ?>>Out of Stock</option>
                </select>
                <button type="submit" class="btn btn-sm" style="width: auto;">
                    <i class="fas fa-search"></i> Search
                </button>
            </div>
        </form>
        
        <div class="table-container" style="flex: 1; overflow: auto;">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Category</th>
                        <th>Price</th>
                        <th>Stock</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Mock inventory data
                    $inventory = [
                        ['id' => '#001', 'name' => 'T-Shirt Basic', 'category' => 'Shirts', 'price' => '$19.99', 'stock' => 250, 'status' => 'in_stock'],
                        ['id' => '#002', 'name' => 'Denim Jeans', 'category' => 'Pants', 'price' => '$49.99', 'stock' => 15, 'status' => 'low_stock'],
                        ['id' => '#003', 'name' => 'Cotton Hoodie', 'category' => 'Outerwear', 'price' => '$39.99', 'stock' => 78, 'status' => 'in_stock'],
                        ['id' => '#004', 'name' => 'Polo Shirt', 'category' => 'Shirts', 'price' => '$24.99', 'stock' => 120, 'status' => 'in_stock'],
                        ['id' => '#005', 'name' => 'Casual Shorts', 'category' => 'Pants', 'price' => '$29.99', 'stock' => 85, 'status' => 'in_stock'],
                        ['id' => '#006', 'name' => 'Winter Jacket', 'category' => 'Outerwear', 'price' => '$89.99', 'stock' => 0, 'status' => 'out_of_stock']
                    ];
                    
                    // Filter inventory based on search parameters
                    $filtered_inventory = array_filter($inventory, function($item) use ($search_query, $category_filter, $status_filter) {
                        $search_match = empty($search_query) || stripos($item['name'], $search_query) !== false;
                        $category_match = empty($category_filter) || $item['category'] === $category_filter;
                        $status_match = empty($status_filter) || $item['status'] === $status_filter;
                        return $search_match && $category_match && $status_match;
                    });
                    
                    foreach ($filtered_inventory as $item):
                        $item_id = substr($item['id'], 1); // Remove the # from ID
                        $status_class = 'success';
                        $status_text = 'In Stock';
                        
                        if ($item['status'] === 'low_stock') {
                            $status_class = 'warning';
                            $status_text = 'Low Stock';
                        } elseif ($item['status'] === 'out_of_stock') {
                            $status_class = 'danger';
                            $status_text = 'Out of Stock';
                        }
                    ?>
                    <tr>
                        <td><?php echo $item['id']; ?></td>
                        <td><?php echo $item['name']; ?></td>
                        <td><?php echo $item['category']; ?></td>
                        <td><?php echo $item['price']; ?></td>
                        <td><?php echo $item['stock']; ?></td>
                        <td><span class="badge badge-<?php echo $status_class; ?>"><?php echo $status_text; ?></span></td>
                        <td>
                            <button class="btn btn-sm" onclick="openEditModal('<?php echo $item_id; ?>', '<?php echo $item['name']; ?>', '<?php echo $item['category']; ?>', '<?php echo substr($item['price'], 1); ?>', '<?php echo $item['stock']; ?>')">
                                <i class="fas fa-edit"></i> Edit
                            </button>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        
        <div style="margin-top: 1.5rem; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 1rem;">
            <div>
                <span style="color: var(--text-secondary);">Showing <?php echo count($filtered_inventory); ?> of <?php echo count($inventory); ?> items</span>
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
</div>

<!-- Add Item Modal -->
<div id="addItemModal" class="modal" style="display: none; position: fixed; z-index: 1000; left: 0; top: 0; width: 100%; height: 100%; overflow: auto; background-color: rgba(0,0,0,0.5);">
    <div class="modal-content" style="background-color: var(--background-light); margin: 10% auto; padding: 20px; border-radius: 8px; width: 80%; max-width: 700px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem;">
            <h2>Add New Item</h2>
            <button class="btn btn-sm" onclick="closeModal('addItemModal')" style="background: none; color: var(--text-secondary);">
                <i class="fas fa-times"></i>
            </button>
        </div>
        
        <form id="addItemForm" method="POST" action="inventory.php" class="item-form" style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem;">
            <div class="form-row">
                <label for="add_item_name">Item Name</label>
                <input type="text" id="add_item_name" name="item_name" class="form-control" required>
            </div>
            
            <div class="form-row">
                <label for="add_category">Category</label>
                <select id="add_category" name="category" class="select-control" required>
                    <option value="">Select Category</option>
                    <option value="Shirts">Shirts</option>
                    <option value="Pants">Pants</option>
                    <option value="Outerwear">Outerwear</option>
                    <option value="Accessories">Accessories</option>
                </select>
            </div>
            
            <div class="form-row">
                <label for="add_price">Price ($)</label>
                <input type="number" id="add_price" name="price" class="form-control" step="0.01" min="0" required>
            </div>
            
            <div class="form-row">
                <label for="add_stock">Stocks</label>
                <input type="number" id="add_stock" name="stock" class="form-control" min="0" required>
            </div>
            
            <div style="grid-column: 1 / -1; margin-top: 1rem; text-align: right;">
                <button type="button" class="btn btn-sm" onclick="closeModal('addItemModal')" style="margin-right: 0.5rem;">
                    Cancel
                </button>
                <button type="submit" class="btn btn-primary" style="width: auto;">
                    <i class="fas fa-save"></i> Add Item
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Edit Item Modal -->
<div id="editItemModal" class="modal" style="display: none; position: fixed; z-index: 1000; left: 0; top: 0; width: 100%; height: 100%; overflow: auto; background-color: rgba(0,0,0,0.5);">
    <div class="modal-content" style="background-color: var(--background-light); margin: 10% auto; padding: 20px; border-radius: 8px; width: 80%; max-width: 700px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem;">
            <h2>Edit Item <span id="edit_item_id_display"></span></h2>
            <button class="btn btn-sm" onclick="closeModal('editItemModal')" style="background: none; color: var(--text-secondary);">
                <i class="fas fa-times"></i>
            </button>
        </div>
        
        <form id="editItemForm" method="POST" action="inventory.php" class="item-form" style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem;">
            <input type="hidden" id="edit_item_id" name="item_id">
            
            <div class="form-row">
                <label for="edit_item_name">Item Name</label>
                <input type="text" id="edit_item_name" name="item_name" class="form-control" required>
            </div>
            
            <div class="form-row">
                <label for="edit_category">Category</label>
                <select id="edit_category" name="category" class="select-control" required>
                    <option value="">Select Category</option>
                    <option value="Shirts">Shirts</option>
                    <option value="Pants">Pants</option>
                    <option value="Outerwear">Outerwear</option>
                    <option value="Accessories">Accessories</option>
                </select>
            </div>
            
            <div class="form-row">
                <label for="edit_price">Price ($)</label>
                <input type="number" id="edit_price" name="price" class="form-control" step="0.01" min="0" required>
            </div>
            
            <div class="form-row">
                <label for="edit_stock">Stocks</label>
                <input type="number" id="edit_stock" name="stock" class="form-control" min="0" required>
            </div>
            
            <div style="grid-column: 1 / -1; margin-top: 1rem; display: flex; justify-content: space-between;">
                <button type="button" class="btn btn-sm" style="background-color: rgba(255, 82, 82, 0.1); color: var(--danger-color);">
                    <i class="fas fa-trash"></i> Delete Item
                </button>
                
                <div>
                    <button type="button" class="btn btn-sm" onclick="closeModal('editItemModal')">
                        Cancel
                    </button>
                    <button type="submit" class="btn btn-primary" style="width: auto; margin-left: 0.5rem;">
                        <i class="fas fa-save"></i> Save Changes
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
    function openAddModal() {
        document.getElementById('addItemModal').style.display = 'block';
    }
    
    function openEditModal(id, name, category, price, stock) {
        document.getElementById('edit_item_id').value = id;
        document.getElementById('edit_item_id_display').textContent = '#' + id;
        document.getElementById('edit_item_name').value = name;
        document.getElementById('edit_category').value = category;
        document.getElementById('edit_price').value = price;
        document.getElementById('edit_stock').value = stock;
        document.getElementById('editItemModal').style.display = 'block';
    }
    
    function closeModal(modalId) {
        document.getElementById(modalId).style.display = 'none';
    }
    
    // Close modal when clicking outside the modal content
    window.onclick = function(event) {
        if (event.target.classList.contains('modal')) {
            event.target.style.display = 'none';
        }
    }
</script>

<?php include '../../layouts/footer.php'; ?> 