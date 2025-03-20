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
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg custom-navbar" style="padding-top: 20px; padding-bottom: 20px; background-color: #141414;">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center" href="#">
                <i class="fas text-white fa-tshirt brand-icon"></i>
                <span class="ms-2 text-white" style>Garment Inventory</span>
            </a>
            <button class="navbar-toggler custom-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <i class="fas text-white fa-bars"></i>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto me-4">
                    <?php if ($_SESSION['role'] == 'admin') { ?>
                        <li class="nav-item">
                            <a class="nav-link" href="../../pages/admin/dashboard.php">
                                <i class="fas text-white fa-tachometer-alt"></i>
                                <span class="text-white">Dashboard</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="../../pages/admin/inventory.php">
                                <i class="fas text-white fa-boxes"></i>
                                <span class="text-white">Inventory</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="../../pages/admin/orders.php">
                                <i class="fas text-white fa-shopping-cart"></i>
                                <span class="text-white">Orders</span>
                            </a>
                        </li>
                    <?php } elseif ($_SESSION['role'] == 'sales') { ?>
                        <li class="nav-item">
                            <a class="nav-link" href="../../pages/sales/dashboard.php">
                                <i class="fas text-white fa-tachometer-alt"></i>
                                <span class="text-white">Dashboard</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/garment-inventory-management/pages/sales/inventory.php">
                                <i class="fas text-white fa-boxes"></i>
                                <span class="text-white">Inventory</span>
                            </a>
                        </li>
                    <?php } elseif ($_SESSION['role'] == 'staff') { ?>
                        <li class="nav-item">
                            <a class="nav-link" href="/garment-inventory-management/pages/staff/manageinventory.php">
                                <i class="fas text-white fa-boxes"></i>
                                <span class="text-white">Inventory</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/garment-inventory-management/pages/staff/processorders.php">
                                <i class="fas text-white fa-tasks"></i>
                                <span class="text-white">Orders</span>
                            </a>
                        </li>
                    <?php } ?>
                </ul>
                <div class="nav-user-section">
                    <div class="dropdown">
                        <a class="nav-link dropdown-toggle user-menu" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fas fa-user-circle"></i>
                            <span class="ms-2"><?php echo $_SESSION['full_name']; ?></span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item text-danger" href="../../includes/auth/logout.php">
                                <i class="fas fa-sign-out-alt me-2"></i>Logout
                            </a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="main-content">
        <!-- Content goes below this line --> 