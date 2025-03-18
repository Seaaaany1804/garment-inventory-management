<?php
require_once '../../includes/auth/auth_check.php';
checkAuth('admin');

$page_title = "Reports & Analytics";
include '../../layouts/header.php';

// Default to current month
$timeRange = isset($_GET['time_range']) ? $_GET['time_range'] : 'this_month';
?>

<div style="display: flex; flex-direction: column; min-height: calc(100vh - 80px);">
    <div style="margin-bottom: 20px; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 1rem;">
        <h1 style="font-size: 1.8rem; font-weight: 600; margin: 0;"><?php echo $page_title; ?></h1>
        
        <div style="display: flex; gap: 1rem; align-items: center;">
            <select id="time-range-selector" class="select-control" style="min-width: 150px; border-radius: 8px; border: none; background-color: rgba(255,255,255,0.1);">
                <option value="this_month" <?php echo $timeRange == 'this_month' ? 'selected' : ''; ?>>This Month</option>
                <option value="last_month" <?php echo $timeRange == 'last_month' ? 'selected' : ''; ?>>Last Month</option>
                <option value="last_3_months" <?php echo $timeRange == 'last_3_months' ? 'selected' : ''; ?>>Last 3 Months</option>
                <option value="this_year" <?php echo $timeRange == 'this_year' ? 'selected' : ''; ?>>This Year</option>
                <option value="custom" <?php echo $timeRange == 'custom' ? 'selected' : ''; ?>>Custom Range</option>
            </select>
            <div id="custom-date-range" style="display: <?php echo $timeRange == 'custom' ? 'flex' : 'none'; ?>; gap: 0.5rem; align-items: center;">
                <input type="date" id="date-from" class="form-control" style="min-width: 150px; border-radius: 8px; border: none; background-color: rgba(255,255,255,0.1);">
                <span style="margin: 0 0.5rem; align-self: center;">to</span>
                <input type="date" id="date-to" class="form-control" style="min-width: 150px; border-radius: 8px; border: none; background-color: rgba(255,255,255,0.1);">
                <button id="apply-date-range" class="btn" style="border-radius: 8px; background: linear-gradient(135deg, #6366F1 0%, #8B5CF6 100%); color: white; border: none; font-weight: 500; padding: 8px 12px;">
                    Apply
                </button>
            </div>
            <a href="#" id="export-reports" class="btn" style="display: flex; align-items: center; gap: 8px; border-radius: 8px; background: linear-gradient(135deg, #6366F1 0%, #8B5CF6 100%); color: white; border: none; font-weight: 500; padding: 10px 16px;">
                <i class="fas fa-file-export"></i> Export Reports
            </a>
        </div>
    </div>

    <div class="stats-grid" style="flex: 1; display: grid; grid-template-columns: repeat(4, 1fr); gap: 20px; margin: 1.5rem 0;">
        <!-- Total Orders Card -->
        <div class="stat-card" style="display: flex; flex-direction: column; background: linear-gradient(135deg, #1E293B 0%, #0F172A 100%); border-radius: 16px; padding: 18px; box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05); position: relative; overflow: hidden;">
            <div style="position: absolute; top: 0; right: 0; width: 100px; height: 100px; background: radial-gradient(circle, rgba(99, 102, 241, 0.15) 0%, rgba(99, 102, 241, 0) 70%); border-radius: 50%;"></div>
            
            <div style="display: flex; align-items: center; margin-bottom: 16px;">
                <div style="display: flex; justify-content: center; align-items: center; width: 48px; height: 48px; background: linear-gradient(135deg, #6366F1 0%, #8B5CF6 100%); border-radius: 12px; margin-right: 16px;">
                    <i class="fas fa-shopping-cart" style="font-size: 20px; color: white;"></i>
                </div>
                <h3 style="font-size: 1.2rem; font-weight: 500; color: #E2E8F0; margin: 0;">Total Orders</h3>
            </div>
            
            <div style="display: flex; align-items: baseline; margin-bottom: 8px;">
                <div id="total-orders" class="value" style="font-size: 3rem; font-weight: 700; color: white; margin-right: 12px;">248</div>
                <div id="total-orders-trend" class="trend up" style="display: flex; align-items: center; background-color: rgba(16, 185, 129, 0.15); padding: 4px 8px; border-radius: 20px; font-size: 0.875rem; color: #10B981;">
                    +12% <i class="fas fa-arrow-up" style="margin-left: 4px;"></i>
                </div>
            </div>
            
            <div style="font-size: 0.875rem; color: #94A3B8;">Compared to last period</div>
        </div>
        
        <!-- Revenue Card -->
        <div class="stat-card" style="display: flex; flex-direction: column; background: linear-gradient(135deg, #1E293B 0%, #0F172A 100%); border-radius: 16px; padding: 18px; box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05); position: relative; overflow: hidden;">
            <div style="position: absolute; top: 0; right: 0; width: 100px; height: 100px; background: radial-gradient(circle, rgba(14, 165, 233, 0.15) 0%, rgba(14, 165, 233, 0) 70%); border-radius: 50%;"></div>
            
            <div style="display: flex; align-items: center; margin-bottom: 16px;">
                <div style="display: flex; justify-content: center; align-items: center; width: 48px; height: 48px; background: linear-gradient(135deg, #0EA5E9 0%, #38BDF8 100%); border-radius: 12px; margin-right: 16px;">
                    <i class="fas fa-dollar-sign" style="font-size: 20px; color: white;"></i>
                </div>
                <h3 style="font-size: 1.2rem; font-weight: 500; color: #E2E8F0; margin: 0;">Revenue</h3>
            </div>
            
            <div style="display: flex; align-items: baseline; margin-bottom: 8px;">
                <div id="total-revenue" class="value" style="font-size: 3rem; font-weight: 700; color: white; margin-right: 12px;">$12,486</div>
                <div id="total-revenue-trend" class="trend up" style="display: flex; align-items: center; background-color: rgba(16, 185, 129, 0.15); padding: 4px 8px; border-radius: 20px; font-size: 0.875rem; color: #10B981;">
                    +8% <i class="fas fa-arrow-up" style="margin-left: 4px;"></i>
                </div>
            </div>
            
            <div style="font-size: 0.875rem; color: #94A3B8;">Compared to last period</div>
        </div>
        
        <!-- Items Sold Card -->
        <div class="stat-card" style="display: flex; flex-direction: column; background: linear-gradient(135deg, #1E293B 0%, #0F172A 100%); border-radius: 16px; padding: 18px; box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05); position: relative; overflow: hidden;">
            <div style="position: absolute; top: 0; right: 0; width: 100px; height: 100px; background: radial-gradient(circle, rgba(236, 72, 153, 0.15) 0%, rgba(236, 72, 153, 0) 70%); border-radius: 50%;"></div>
            
            <div style="display: flex; align-items: center; margin-bottom: 16px;">
                <div style="display: flex; justify-content: center; align-items: center; width: 48px; height: 48px; background: linear-gradient(135deg, #EC4899 0%, #F472B6 100%); border-radius: 12px; margin-right: 16px;">
                    <i class="fas fa-box" style="font-size: 20px; color: white;"></i>
                </div>
                <h3 style="font-size: 1.2rem; font-weight: 500; color: #E2E8F0; margin: 0;">Items Sold</h3>
            </div>
            
            <div style="display: flex; align-items: baseline; margin-bottom: 8px;">
                <div id="items-sold" class="value" style="font-size: 3rem; font-weight: 700; color: white; margin-right: 12px;">1,342</div>
                <div id="items-sold-trend" class="trend up" style="display: flex; align-items: center; background-color: rgba(16, 185, 129, 0.15); padding: 4px 8px; border-radius: 20px; font-size: 0.875rem; color: #10B981;">
                    +15% <i class="fas fa-arrow-up" style="margin-left: 4px;"></i>
                </div>
            </div>
            
            <div style="font-size: 0.875rem; color: #94A3B8;">Compared to last period</div>
        </div>
        
        <!-- Profit Margin Card -->
        <div class="stat-card" style="display: flex; flex-direction: column; background: linear-gradient(135deg, #1E293B 0%, #0F172A 100%); border-radius: 16px; padding: 18px; box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05); position: relative; overflow: hidden;">
            <div style="position: absolute; top: 0; right: 0; width: 100px; height: 100px; background: radial-gradient(circle, rgba(16, 185, 129, 0.15) 0%, rgba(16, 185, 129, 0) 70%); border-radius: 50%;"></div>
            
            <div style="display: flex; align-items: center; margin-bottom: 16px;">
                <div style="display: flex; justify-content: center; align-items: center; width: 48px; height: 48px; background: linear-gradient(135deg, #10B981 0%, #34D399 100%); border-radius: 12px; margin-right: 16px;">
                    <i class="fas fa-chart-line" style="font-size: 20px; color: white;"></i>
                </div>
                <h3 style="font-size: 1.2rem; font-weight: 500; color: #E2E8F0; margin: 0;">Profit Margin</h3>
            </div>
            
            <div style="display: flex; align-items: baseline; margin-bottom: 8px;">
                <div id="profit-margin" class="value" style="font-size: 3rem; font-weight: 700; color: white; margin-right: 12px;">32.8%</div>
                <div id="profit-margin-trend" class="trend up" style="display: flex; align-items: center; background-color: rgba(16, 185, 129, 0.15); padding: 4px 8px; border-radius: 20px; font-size: 0.875rem; color: #10B981;">
                    +3.4% <i class="fas fa-arrow-up" style="margin-left: 4px;"></i>
                </div>
            </div>
            
            <div style="font-size: 0.875rem; color: #94A3B8;">Compared to last period</div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const timeRangeSelector = document.getElementById('time-range-selector');
    const customDateRange = document.getElementById('custom-date-range');
    const dateFrom = document.getElementById('date-from');
    const dateTo = document.getElementById('date-to');
    const applyDateRange = document.getElementById('apply-date-range');
    
    // Set default date values if custom is selected
    if (timeRangeSelector.value === 'custom') {
        const today = new Date();
        const lastMonth = new Date();
        lastMonth.setMonth(today.getMonth() - 1);
        
        dateFrom.value = formatDate(lastMonth);
        dateTo.value = formatDate(today);
    }
    
    // Handle time range change
    timeRangeSelector.addEventListener('change', function() {
        if (this.value === 'custom') {
            customDateRange.style.display = 'flex';
        } else {
            customDateRange.style.display = 'none';
            // Fetch new data based on time range
            fetchStatsData(this.value);
        }
    });
    
    // Handle custom date range apply button
    applyDateRange.addEventListener('click', function() {
        if (dateFrom.value && dateTo.value) {
            fetchStatsData('custom', dateFrom.value, dateTo.value);
        } else {
            alert('Please select both start and end dates');
        }
    });
    
    // Function to fetch data based on time range
    function fetchStatsData(timeRange, fromDate = null, toDate = null) {
        // Show loading state
        document.querySelectorAll('.stat-card .value').forEach(el => {
            el.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';
        });
        
        // In a real app, you would make an AJAX call to your backend
        // For this demo, we'll simulate with different data for different time ranges
        setTimeout(() => {
            let data;
            
            switch(timeRange) {
                case 'this_month':
                    data = {
                        totalOrders: 248,
                        totalOrdersTrend: 12,
                        totalRevenue: 12486,
                        totalRevenueTrend: 8,
                        avgOrderValue: 50.35,
                        avgOrderValueTrend: -2,
                        itemsSold: 1342,
                        itemsSoldTrend: 15,
                        profitMargin: 32.8,
                        profitMarginTrend: 3.4
                    };
                    break;
                case 'last_month':
                    data = {
                        totalOrders: 203,
                        totalOrdersTrend: 5,
                        totalRevenue: 10152,
                        totalRevenueTrend: 3,
                        avgOrderValue: 50.01,
                        avgOrderValueTrend: -3.5,
                        itemsSold: 1105,
                        itemsSoldTrend: 8,
                        profitMargin: 30.1,
                        profitMarginTrend: 1.2
                    };
                    break;
                case 'last_3_months':
                    data = {
                        totalOrders: 625,
                        totalOrdersTrend: 18,
                        totalRevenue: 31450,
                        totalRevenueTrend: 15,
                        avgOrderValue: 50.32,
                        avgOrderValueTrend: 1.2,
                        itemsSold: 3421,
                        itemsSoldTrend: 22,
                        profitMargin: 33.5,
                        profitMarginTrend: 4.8
                    };
                    break;
                case 'this_year':
                    data = {
                        totalOrders: 2150,
                        totalOrdersTrend: 25,
                        totalRevenue: 108324,
                        totalRevenueTrend: 22,
                        avgOrderValue: 50.38,
                        avgOrderValueTrend: 4.2,
                        itemsSold: 11843,
                        itemsSoldTrend: 28,
                        profitMargin: 34.2,
                        profitMarginTrend: 5.3
                    };
                    break;
                case 'custom':
                    // Here you would use the fromDate and toDate parameters for your API call
                    data = {
                        totalOrders: 352,
                        totalOrdersTrend: 10,
                        totalRevenue: 17645,
                        totalRevenueTrend: 7,
                        avgOrderValue: 50.13,
                        avgOrderValueTrend: 0.5,
                        itemsSold: 1879,
                        itemsSoldTrend: 12,
                        profitMargin: 31.5,
                        profitMarginTrend: 2.1
                    };
                    break;
                default:
                    data = {
                        totalOrders: 248,
                        totalOrdersTrend: 12,
                        totalRevenue: 12486,
                        totalRevenueTrend: 8,
                        avgOrderValue: 50.35,
                        avgOrderValueTrend: -2,
                        itemsSold: 1342,
                        itemsSoldTrend: 15,
                        profitMargin: 32.8,
                        profitMarginTrend: 3.4
                    };
            }
            
            // Update the UI with the new data
            updateStatsUI(data);
        }, 500); // Simulate network delay
    }
    
    // Function to update the UI with new data
    function updateStatsUI(data) {
        // Update total orders
        document.getElementById('total-orders').textContent = data.totalOrders;
        updateTrend('total-orders-trend', data.totalOrdersTrend);
        
        // Update revenue
        document.getElementById('total-revenue').textContent = '$' + numberWithCommas(data.totalRevenue);
        updateTrend('total-revenue-trend', data.totalRevenueTrend);
        
        // Update average order value
        document.getElementById('avg-order-value').textContent = '$' + data.avgOrderValue.toFixed(2);
        updateTrend('avg-order-value-trend', data.avgOrderValueTrend);
        
        // Update items sold
        document.getElementById('items-sold').textContent = numberWithCommas(data.itemsSold);
        updateTrend('items-sold-trend', data.itemsSoldTrend);
        
        // Update profit margin
        document.getElementById('profit-margin').textContent = data.profitMargin.toFixed(1) + '%';
        updateTrend('profit-margin-trend', data.profitMarginTrend);
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
    
    // Helper function to format dates
    function formatDate(date) {
        const year = date.getFullYear();
        const month = String(date.getMonth() + 1).padStart(2, '0');
        const day = String(date.getDate()).padStart(2, '0');
        return `${year}-${month}-${day}`;
    }
    
    // Helper function to format numbers with commas
    function numberWithCommas(x) {
        return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    }
    
    // Initially load data based on selected time range
    fetchStatsData(timeRangeSelector.value);
});
</script>

<?php include '../../layouts/footer.php'; ?> 