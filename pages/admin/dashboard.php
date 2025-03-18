<?php
// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$pageTitle = "Overall Reports";
include '../../layouts/header.php';

// Default to current month
$timeRange = isset($_GET['time_range']) ? $_GET['time_range'] : 'this_month';
?>

<div style="margin-bottom: 20px; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 1rem;">
    <h1 style="font-size: 1.8rem; font-weight: 600; margin: 0;"><?php echo $pageTitle; ?></h1>
    
    <div style="display: flex; gap: 1rem; align-items: center;">
        <select id="time-range-selector" class="select-control" style="min-width: 150px; padding: 8px 12px; border-radius: 8px; border: 1px solid #ccc; background-color: #fff;">
            <option value="this_month" <?php echo $timeRange == 'this_month' ? 'selected' : ''; ?>>This Month</option>
            <option value="last_month" <?php echo $timeRange == 'last_month' ? 'selected' : ''; ?>>Last Month</option>
            <option value="last_3_months" <?php echo $timeRange == 'last_3_months' ? 'selected' : ''; ?>>Last 3 Months</option>
            <option value="this_year" <?php echo $timeRange == 'this_year' ? 'selected' : ''; ?>>This Year</option>
        </select>
    </div>
</div>

<div class="stats-grid" style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 20px; margin-bottom: 24px;">
    <div class="stat-card" style="display: flex; flex-direction: column; background: linear-gradient(135deg, #1E293B 0%, #0F172A 100%); border-radius: 16px; padding: 18px; box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05); position: relative; overflow: hidden;">
        <div style="position: absolute; top: 0; right: 0; width: 100px; height: 100px; background: radial-gradient(circle, rgba(99, 102, 241, 0.15) 0%, rgba(99, 102, 241, 0) 70%); border-radius: 50%;"></div>
        
        <div style="display: flex; align-items: center; margin-bottom: 16px;">
            <div style="display: flex; justify-content: center; align-items: center; width: 48px; height: 48px; background: linear-gradient(135deg, #6366F1 0%, #8B5CF6 100%); border-radius: 12px; margin-right: 16px;">
                <i class="fas fa-box" style="font-size: 20px; color: white;"></i>
            </div>
            <h3 style="font-size: 1.2rem; font-weight: 500; color: #E2E8F0; margin: 0;">Total Stock Items</h3>
        </div>
        
        <div style="display: flex; align-items: baseline; margin-bottom: 8px;">
            <div id="total-stock" class="value" style="font-size: 2.5rem; font-weight: 700; color: white; margin-right: 12px;">1,245</div>
            <div id="total-stock-trend" class="trend up" style="display: flex; align-items: center; background-color: rgba(16, 185, 129, 0.15); padding: 4px 8px; border-radius: 20px; font-size: 0.875rem; color: #10B981;">
                +8% <i class="fas fa-arrow-up" style="margin-left: 4px;"></i>
            </div>
        </div>
        
        <div style="font-size: 0.875rem; color: #94A3B8;">Compared to last period</div>
    </div>
    
    <div class="stat-card" style="display: flex; flex-direction: column; background: linear-gradient(135deg, #1E293B 0%, #0F172A 100%); border-radius: 16px; padding: 18px; box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05); position: relative; overflow: hidden;">
        <div style="position: absolute; top: 0; right: 0; width: 100px; height: 100px; background: radial-gradient(circle, rgba(236, 72, 153, 0.15) 0%, rgba(236, 72, 153, 0) 70%); border-radius: 50%;"></div>
        
        <div style="display: flex; align-items: center; margin-bottom: 16px;">
            <div style="display: flex; justify-content: center; align-items: center; width: 48px; height: 48px; background: linear-gradient(135deg, #EC4899 0%, #F472B6 100%); border-radius: 12px; margin-right: 16px;">
                <i class="fas fa-truck" style="font-size: 20px; color: white;"></i>
            </div>
            <h3 style="font-size: 1.2rem; font-weight: 500; color: #E2E8F0; margin: 0;">Warehouse Outflow</h3>
        </div>
        
        <div style="display: flex; align-items: baseline; margin-bottom: 8px;">
            <div id="warehouse-outflow" class="value" style="font-size: 2.5rem; font-weight: 700; color: white; margin-right: 12px;">78</div>
            <div id="warehouse-outflow-trend" class="trend up" style="display: flex; align-items: center; background-color: rgba(16, 185, 129, 0.15); padding: 4px 8px; border-radius: 20px; font-size: 0.875rem; color: #10B981;">
                +12% <i class="fas fa-arrow-up" style="margin-left: 4px;"></i>
            </div>
        </div>
        
        <div style="font-size: 0.875rem; color: #94A3B8;">Compared to last period</div>
    </div>
    
    <div class="stat-card" style="display: flex; flex-direction: column; background: linear-gradient(135deg, #1E293B 0%, #0F172A 100%); border-radius: 16px; padding: 18px; box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05); position: relative; overflow: hidden;">
        <div style="position: absolute; top: 0; right: 0; width: 100px; height: 100px; background: radial-gradient(circle, rgba(16, 185, 129, 0.15) 0%, rgba(16, 185, 129, 0) 70%); border-radius: 50%;"></div>
        
        <div style="display: flex; align-items: center; margin-bottom: 16px;">
            <div style="display: flex; justify-content: center; align-items: center; width: 48px; height: 48px; background: linear-gradient(135deg, #10B981 0%, #34D399 100%); border-radius: 12px; margin-right: 16px;">
                <i class="fas fa-check-circle" style="font-size: 20px; color: white;"></i>
            </div>
            <h3 style="font-size: 1.2rem; font-weight: 500; color: #E2E8F0; margin: 0;">Delivered Items</h3>
        </div>
        
        <div style="display: flex; align-items: baseline; margin-bottom: 8px;">
            <div id="delivered-items" class="value" style="font-size: 2.5rem; font-weight: 700; color: white; margin-right: 12px;">42</div>
            <div id="delivered-items-trend" class="trend up" style="display: flex; align-items: center; background-color: rgba(16, 185, 129, 0.15); padding: 4px 8px; border-radius: 20px; font-size: 0.875rem; color: #10B981;">
                +5% <i class="fas fa-arrow-up" style="margin-left: 4px;"></i>
            </div>
        </div>
        
        <div style="font-size: 0.875rem; color: #94A3B8;">Compared to last period</div>
    </div>
    
    <div class="stat-card" style="display: flex; flex-direction: column; background: linear-gradient(135deg, #1E293B 0%, #0F172A 100%); border-radius: 16px; padding: 18px; box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05); position: relative; overflow: hidden;">
        <div style="position: absolute; top: 0; right: 0; width: 100px; height: 100px; background: radial-gradient(circle, rgba(14, 165, 233, 0.15) 0%, rgba(14, 165, 233, 0) 70%); border-radius: 50%;"></div>
        
        <div style="display: flex; align-items: center; margin-bottom: 16px;">
            <div style="display: flex; justify-content: center; align-items: center; width: 48px; height: 48px; background: linear-gradient(135deg, #0EA5E9 0%, #38BDF8 100%); border-radius: 12px; margin-right: 16px;">
                <i class="fas fa-dollar-sign" style="font-size: 20px; color: white;"></i>
            </div>
            <h3 style="font-size: 1.2rem; font-weight: 500; color: #E2E8F0; margin: 0;">Revenue</h3>
        </div>
        
        <div style="display: flex; align-items: baseline; margin-bottom: 8px;">
            <div id="total-revenue" class="value" style="font-size: 2.5rem; font-weight: 700; color: white; margin-right: 12px;">$12,486</div>
            <div id="total-revenue-trend" class="trend up" style="display: flex; align-items: center; background-color: rgba(16, 185, 129, 0.15); padding: 4px 8px; border-radius: 20px; font-size: 0.875rem; color: #10B981;">
                +15% <i class="fas fa-arrow-up" style="margin-left: 4px;"></i>
            </div>
        </div>
        
        <div style="font-size: 0.875rem; color: #94A3B8;">Compared to last period</div>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="card">
            <h2>Recently Added Stock</h2>
            <div class="table-container">
                <table>
                    <thead>
                        <tr>
                            <th>Product</th>
                            <th>Category</th>
                            <th>Quantity</th>
                            <th>Date Added</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Women's Blouse</td>
                            <td>Tops</td>
                            <td>50</td>
                            <td>Mar 18, 2024</td>
                        </tr>
                        <tr>
                            <td>Men's Chino Pants</td>
                            <td>Bottoms</td>
                            <td>35</td>
                            <td>Mar 17, 2024</td>
                        </tr>
                        <tr>
                            <td>Summer Dresses</td>
                            <td>Dresses</td>
                            <td>25</td>
                            <td>Mar 16, 2024</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    
    <div class="col-md-6">
        <div class="card">
            <h2>Recently Added New Items</h2>
            <div class="table-container">
                <table>
                    <thead>
                        <tr>
                            <th>Product</th>
                            <th>Category</th>
                            <th>Initial Stock</th>
                            <th>Date Added</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Premium Wool Coat</td>
                            <td>Outerwear</td>
                            <td>20</td>
                            <td>Mar 18, 2024</td>
                        </tr>
                        <tr>
                            <td>Organic Cotton Tees</td>
                            <td>Tops</td>
                            <td>45</td>
                            <td>Mar 16, 2024</td>
                        </tr>
                        <tr>
                            <td>Designer Scarves</td>
                            <td>Accessories</td>
                            <td>30</td>
                            <td>Mar 15, 2024</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="row mt-4">
    <div class="col-md-12">
        <div class="card">
            <h2>Low Stock Items</h2>
            <div class="table-container">
                <table>
                    <thead>
                        <tr>
                            <th>Product</th>
                            <th>Category</th>
                            <th>Stock</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Denim Jeans (XL)</td>
                            <td>Bottoms</td>
                            <td><span class="badge badge-danger">5</span></td>
                        </tr>
                        <tr>
                            <td>Cotton Dress Shirt</td>
                            <td>Tops</td>
                            <td><span class="badge badge-warning">12</span></td>
                        </tr>
                        <tr>
                            <td>Winter Jacket</td>
                            <td>Outerwear</td>
                            <td><span class="badge badge-warning">8</span></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const timeRangeSelector = document.getElementById('time-range-selector');
    
    // Data for different time periods
    const timeRangeData = {
        'this_month': {
            totalStock: 1245,
            totalStockTrend: 8,
            warehouseOutflow: 78,
            warehouseOutflowTrend: 12,
            deliveredItems: 42,
            deliveredItemsTrend: 5,
            totalRevenue: 12486,
            totalRevenueTrend: 15
        },
        'last_month': {
            totalStock: 1125,
            totalStockTrend: 5,
            warehouseOutflow: 65,
            warehouseOutflowTrend: 8,
            deliveredItems: 38,
            deliveredItemsTrend: 3,
            totalRevenue: 10250,
            totalRevenueTrend: 10
        },
        'last_3_months': {
            totalStock: 3250,
            totalStockTrend: 15,
            warehouseOutflow: 230,
            warehouseOutflowTrend: 18,
            deliveredItems: 142,
            deliveredItemsTrend: 12,
            totalRevenue: 42750,
            totalRevenueTrend: 20
        },
        'this_year': {
            totalStock: 12540,
            totalStockTrend: 25,
            warehouseOutflow: 875,
            warehouseOutflowTrend: 22,
            deliveredItems: 560,
            deliveredItemsTrend: 18,
            totalRevenue: 185250,
            totalRevenueTrend: 30
        }
    };
    
    // Handle time range change
    timeRangeSelector.addEventListener('change', function() {
        updateDashboardStats(this.value);
    });
    
    // Function to update dashboard stats based on selected time range
    function updateDashboardStats(timeRange) {
        // Show loading state
        document.querySelectorAll('.stat-card .value').forEach(el => {
            el.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';
        });
        
        // Simulate network delay
        setTimeout(() => {
            const data = timeRangeData[timeRange];
            
            // Update total stock
            document.getElementById('total-stock').textContent = numberWithCommas(data.totalStock);
            updateTrend('total-stock-trend', data.totalStockTrend);
            
            // Update warehouse outflow
            document.getElementById('warehouse-outflow').textContent = numberWithCommas(data.warehouseOutflow);
            updateTrend('warehouse-outflow-trend', data.warehouseOutflowTrend);
            
            // Update delivered items
            document.getElementById('delivered-items').textContent = numberWithCommas(data.deliveredItems);
            updateTrend('delivered-items-trend', data.deliveredItemsTrend);
            
            // Update revenue
            document.getElementById('total-revenue').textContent = '$' + numberWithCommas(data.totalRevenue);
            updateTrend('total-revenue-trend', data.totalRevenueTrend);
            
        }, 500);
    }
    
    // Helper function to update trend indicators
    function updateTrend(elementId, trendValue) {
        const element = document.getElementById(elementId);
        const prefix = trendValue >= 0 ? '+' : '';
        const iconClass = trendValue >= 0 ? 'fa-arrow-up' : 'fa-arrow-down';
        const bgColorClass = trendValue >= 0 
            ? 'background-color: rgba(16, 185, 129, 0.15); color: #10B981;'
            : 'background-color: rgba(239, 68, 68, 0.15); color: #EF4444;';
        
        element.innerHTML = `${prefix}${trendValue}% <i class="fas ${iconClass}" style="margin-left: 4px;"></i>`;
        element.setAttribute('style', `display: flex; align-items: center; ${bgColorClass} padding: 4px 8px; border-radius: 20px; font-size: 0.875rem;`);
    }
    
    // Helper function to format numbers with commas
    function numberWithCommas(x) {
        return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    }
    
    // Initialize with the selected time range
    updateDashboardStats(timeRangeSelector.value);
});
</script>

<?php include '../../layouts/footer.php'; ?> 