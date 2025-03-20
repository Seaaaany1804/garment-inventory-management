<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION['role'])) {
    header("Location: ../../index.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($pageTitle) ? $pageTitle : 'Garment Inventory Management'; ?></title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="../../assets/css/style.css">
</head>
<body>
    <div class="container-fluid">
        <div class="row vh-100">
            <!-- Sidebar -->
            <nav id="sidebar" class="col-md-3 col-lg-2 d-md-block bg-dark sidebar">
                <div class="position-sticky pt-3 h-100">
                    <div class="text-center p-3 mb-3">
                        <h4 class="text-white">Garment Inventory</h4>
                        <p class="text-white-50">Welcome, <?php echo $_SESSION['full_name']; ?></p>
                    </div>
                    <ul class="nav flex-column">
                        <?php if ($_SESSION['role'] == 'admin') { ?>
                            <li class="nav-item">
                                <a class="nav-link text-white" href="../../pages/admin/dashboard.php">
                                    <i class="fas fa-tachometer-alt me-2"></i> Dashboard
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link text-white" href="../../pages/admin/inventory.php">
                                    <i class="fas fa-boxes me-2"></i> Inventory
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link text-white" href="../../pages/admin/orders.php">
                                    <i class="fas fa-shopping-cart me-2"></i> View Orders
                                </a>
                            </li>
                        <?php } elseif ($_SESSION['role'] == 'sales') { ?>
                            <li class="nav-item">
                                <a class="nav-link text-white" href="../../pages/sales/dashboard.php">
                                    <i class="fas fa-tachometer-alt me-2"></i> Dashboard
                                </a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link text-white" href="/garment-inventory-management/pages/sales/inventory.php">
                                    <i class="fas fa-tshirt me-2"></i> View Products
                                </a>
                            </li>
                        <?php } elseif ($_SESSION['role'] == 'staff') { ?>
                            <li class="nav-item">
                                <a class="nav-link text-white" href="../../pages/staff/dashboard.php">
                                    <i class="fas fa-tachometer-alt me-2"></i> Dashboard
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link text-white" href="/garment-inventory-management/pages/staff/manageinventory.php">
                                    <i class="fas fa-boxes me-2"></i> Manage Inventory
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link text-white" href="/garment-inventory-management/pages/staff/processorders.php">
                                    <i class="fas fa-tasks me-2"></i> Process Orders
                                </a>
                            </li>
                        <?php } ?>
                        <li class="nav-item mt-3">
                            <a class="nav-link text-white" href="../../includes/auth/logout.php">
                                <i class="fas fa-sign-out-alt me-2"></i> Logout
                            </a>
                        </li>
                    </ul>
                </div>
            </nav>

            <!-- Main Content -->
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 d-flex flex-column min-vh-100">
                <!-- Content goes below this line --> 