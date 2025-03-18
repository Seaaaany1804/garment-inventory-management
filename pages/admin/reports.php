<?php
require_once '../../includes/auth/auth_check.php';
checkAuth('admin');

$page_title = "Reports & Analytics";
include '../../layouts/header.php';
?>

<div style="margin-bottom: 20px; display: flex; justify-content: space-between; flex-wrap: wrap; gap: 1rem;">
    <div style="display: flex; gap: 1rem; flex-wrap: wrap;">
        <select class="select-control" style="min-width: 150px;">
            <option value="this_month">This Month</option>
            <option value="last_month">Last Month</option>
            <option value="last_3_months">Last 3 Months</option>
            <option value="this_year">This Year</option>
            <option value="custom">Custom Range</option>
        </select>
        <div style="display: none;" id="custom-date-range">
            <input type="date" class="form-control" style="min-width: 150px;">
            <span style="margin: 0 0.5rem; align-self: center;">to</span>
            <input type="date" class="form-control" style="min-width: 150px;">
        </div>
    </div>
    <div>
        <a href="#" class="btn btn-sm">
            <i class="fas fa-file-export"></i> Export Reports
        </a>
    </div>
</div>

<div class="stats-grid">
    <div class="stat-card">
        <h3>Total Orders</h3>
        <div class="value">248</div>
        <div class="trend up">+12% <i class="fas fa-arrow-up"></i></div>
    </div>
    
    <div class="stat-card">
        <h3>Revenue</h3>
        <div class="value">$12,486</div>
        <div class="trend up">+8% <i class="fas fa-arrow-up"></i></div>
    </div>
    
    <div class="stat-card">
        <h3>Average Order Value</h3>
        <div class="value">$50.35</div>
        <div class="trend down">-2% <i class="fas fa-arrow-down"></i></div>
    </div>
    
    <div class="stat-card">
        <h3>Items Sold</h3>
        <div class="value">1,342</div>
        <div class="trend up">+15% <i class="fas fa-arrow-up"></i></div>
    </div>
</div>

<div class="card">
    <h2>Sales Performance</h2>
    <div class="chart-container" style="height: 300px; background: var(--background-dark); position: relative; margin: 1.5rem 0; border-radius: 8px; overflow: hidden; padding: 1rem;">
        <!-- This would be a real chart in a production environment -->
        <div style="height: 100%; width: 100%; display: flex; align-items: flex-end;">
            <div style="flex: 1; height: 60%; background: linear-gradient(180deg, var(--primary-color) 0%, rgba(108, 99, 255, 0.3) 100%); margin: 0 0.25rem; border-radius: 4px 4px 0 0;"></div>
            <div style="flex: 1; height: 75%; background: linear-gradient(180deg, var(--primary-color) 0%, rgba(108, 99, 255, 0.3) 100%); margin: 0 0.25rem; border-radius: 4px 4px 0 0;"></div>
            <div style="flex: 1; height: 45%; background: linear-gradient(180deg, var(--primary-color) 0%, rgba(108, 99, 255, 0.3) 100%); margin: 0 0.25rem; border-radius: 4px 4px 0 0;"></div>
            <div style="flex: 1; height: 80%; background: linear-gradient(180deg, var(--primary-color) 0%, rgba(108, 99, 255, 0.3) 100%); margin: 0 0.25rem; border-radius: 4px 4px 0 0;"></div>
            <div style="flex: 1; height: 65%; background: linear-gradient(180deg, var(--primary-color) 0%, rgba(108, 99, 255, 0.3) 100%); margin: 0 0.25rem; border-radius: 4px 4px 0 0;"></div>
            <div style="flex: 1; height: 90%; background: linear-gradient(180deg, var(--primary-color) 0%, rgba(108, 99, 255, 0.3) 100%); margin: 0 0.25rem; border-radius: 4px 4px 0 0;"></div>
            <div style="flex: 1; height: 70%; background: linear-gradient(180deg, var(--primary-color) 0%, rgba(108, 99, 255, 0.3) 100%); margin: 0 0.25rem; border-radius: 4px 4px 0 0;"></div>
            <div style="flex: 1; height: 50%; background: linear-gradient(180deg, var(--primary-color) 0%, rgba(108, 99, 255, 0.3) 100%); margin: 0 0.25rem; border-radius: 4px 4px 0 0;"></div>
            <div style="flex: 1; height: 85%; background: linear-gradient(180deg, var(--primary-color) 0%, rgba(108, 99, 255, 0.3) 100%); margin: 0 0.25rem; border-radius: 4px 4px 0 0;"></div>
            <div style="flex: 1; height: 78%; background: linear-gradient(180deg, var(--primary-color) 0%, rgba(108, 99, 255, 0.3) 100%); margin: 0 0.25rem; border-radius: 4px 4px 0 0;"></div>
            <div style="flex: 1; height: 60%; background: linear-gradient(180deg, var(--primary-color) 0%, rgba(108, 99, 255, 0.3) 100%); margin: 0 0.25rem; border-radius: 4px 4px 0 0;"></div>
            <div style="flex: 1; height: 95%; background: linear-gradient(180deg, var(--primary-color) 0%, rgba(108, 99, 255, 0.3) 100%); margin: 0 0.25rem; border-radius: 4px 4px 0 0;"></div>
        </div>
        <div style="position: absolute; bottom: 0; left: 0; right: 0; height: 1px; background: var(--border-color);"></div>
    </div>
    <div style="display: flex; justify-content: center; gap: 2rem;">
        <div>
            <span style="color: var(--text-secondary);">Month-to-date: </span>
            <span style="font-weight: 600;">$4,128</span>
        </div>
        <div>
            <span style="color: var(--text-secondary);">Year-to-date: </span>
            <span style="font-weight: 600;">$48,756</span>
        </div>
    </div>
</div>

<div class="row" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(400px, 1fr)); gap: 1.5rem; margin-top: 1.5rem;">
    <div class="card">
        <h2>Top Selling Items</h2>
        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>Item</th>
                        <th>Category</th>
                        <th>Units Sold</th>
                        <th>Revenue</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>T-Shirt Basic</td>
                        <td>Shirts</td>
                        <td>328</td>
                        <td>$6,560</td>
                    </tr>
                    <tr>
                        <td>Denim Jeans</td>
                        <td>Pants</td>
                        <td>145</td>
                        <td>$7,245</td>
                    </tr>
                    <tr>
                        <td>Cotton Hoodie</td>
                        <td>Outerwear</td>
                        <td>112</td>
                        <td>$4,480</td>
                    </tr>
                    <tr>
                        <td>Polo Shirt</td>
                        <td>Shirts</td>
                        <td>95</td>
                        <td>$2,375</td>
                    </tr>
                    <tr>
                        <td>Casual Shorts</td>
                        <td>Pants</td>
                        <td>87</td>
                        <td>$2,610</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    
    <div class="card">
        <h2>Sales by Category</h2>
        <div class="chart-container" style="height: 250px; position: relative; margin: 1.5rem 0;">
            <!-- This would be a real pie chart in a production environment -->
            <div style="width: 200px; height: 200px; border-radius: 50%; position: relative; margin: 0 auto; overflow: hidden;">
                <div style="position: absolute; width: 100%; height: 100%; clip-path: polygon(50% 50%, 50% 0%, 100% 0%, 100% 100%, 75% 100%, 50% 50%); background-color: var(--primary-color);"></div>
                <div style="position: absolute; width: 100%; height: 100%; clip-path: polygon(50% 50%, 75% 100%, 0% 100%, 0% 30%, 50% 0%, 50% 50%); background-color: var(--success-color);"></div>
                <div style="position: absolute; width: 100%; height: 100%; clip-path: polygon(50% 50%, 0% 30%, 0% 0%, 50% 0%, 50% 50%); background-color: var(--warning-color);"></div>
                <div style="position: absolute; top: 0; left: 0; right: 0; bottom: 0; display: flex; align-items: center; justify-content: center; flex-direction: column;">
                    <span style="font-size: 2rem; font-weight: 600;">100%</span>
                    <span style="color: var(--text-secondary);">Total Sales</span>
                </div>
            </div>
            
            <div style="display: flex; justify-content: center; gap: 1.5rem; margin-top: 1.5rem;">
                <div style="display: flex; align-items: center;">
                    <div style="width: 12px; height: 12px; background-color: var(--primary-color); border-radius: 2px; margin-right: 0.5rem;"></div>
                    <span>Shirts (45%)</span>
                </div>
                <div style="display: flex; align-items: center;">
                    <div style="width: 12px; height: 12px; background-color: var(--success-color); border-radius: 2px; margin-right: 0.5rem;"></div>
                    <span>Pants (35%)</span>
                </div>
                <div style="display: flex; align-items: center;">
                    <div style="width: 12px; height: 12px; background-color: var(--warning-color); border-radius: 2px; margin-right: 0.5rem;"></div>
                    <span>Outerwear (20%)</span>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="card" style="margin-top: 1.5rem;">
    <h2>Order History</h2>
    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>Order ID</th>
                    <th>Date</th>
                    <th>Customer</th>
                    <th>Items</th>
                    <th>Total</th>
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
                    <td>$89.97</td>
                    <td><span class="badge badge-warning">Pending</span></td>
                    <td>
                        <a href="#" class="btn btn-sm">View</a>
                    </td>
                </tr>
                <tr>
                    <td>#ORD-002</td>
                    <td>Mar 17, 2024</td>
                    <td>Emma Johnson</td>
                    <td>5</td>
                    <td>$175.95</td>
                    <td><span class="badge badge-success">Delivered</span></td>
                    <td>
                        <a href="#" class="btn btn-sm">View</a>
                    </td>
                </tr>
                <tr>
                    <td>#ORD-003</td>
                    <td>Mar 16, 2024</td>
                    <td>Michael Brown</td>
                    <td>2</td>
                    <td>$69.98</td>
                    <td><span class="badge badge-info">In Transit</span></td>
                    <td>
                        <a href="#" class="btn btn-sm">View</a>
                    </td>
                </tr>
                <tr>
                    <td>#ORD-004</td>
                    <td>Mar 15, 2024</td>
                    <td>Jennifer Davis</td>
                    <td>1</td>
                    <td>$49.99</td>
                    <td><span class="badge badge-info">In Transit</span></td>
                    <td>
                        <a href="#" class="btn btn-sm">View</a>
                    </td>
                </tr>
                <tr>
                    <td>#ORD-005</td>
                    <td>Mar 14, 2024</td>
                    <td>Robert Wilson</td>
                    <td>4</td>
                    <td>$119.96</td>
                    <td><span class="badge badge-success">Delivered</span></td>
                    <td>
                        <a href="#" class="btn btn-sm">View</a>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
    
    <div style="margin-top: 1rem; display: flex; justify-content: center;">
        <div class="pagination" style="display: flex; gap: 0.5rem;">
            <a href="#" class="btn btn-sm">Previous</a>
            <a href="#" class="btn btn-sm" style="background-color: rgba(108, 99, 255, 0.2);">1</a>
            <a href="#" class="btn btn-sm">2</a>
            <a href="#" class="btn btn-sm">3</a>
            <a href="#" class="btn btn-sm">Next</a>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const dateRangeSelect = document.querySelector('select');
    const customDateRange = document.getElementById('custom-date-range');
    
    dateRangeSelect.addEventListener('change', function() {
        if (this.value === 'custom') {
            customDateRange.style.display = 'flex';
        } else {
            customDateRange.style.display = 'none';
        }
    });
});
</script>

<?php include '../../layouts/footer.php'; ?> 