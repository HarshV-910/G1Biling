<?php 
include "db_con.php"; 
session_start();

$user_login = $_SESSION['user_name'] ?? null;
if (!$user_login) {
    echo "<script> document.location.href='validation/login.php'; </script>";
    exit;
}

// Fetch active owner details
$active_owner_id = $_SESSION['active_owner_id'] ?? 1;
$active_owner_q = mysqli_query($conn, "SELECT * FROM users WHERE owner_id = $active_owner_id");
$active_owner = mysqli_fetch_assoc($active_owner_q);
?>   
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <title>Dashboard | G1 Fashion</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="G1_fashion" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <link rel="shortcut icon" href="assets/img/favicons.ico">
    <link href="assets/vendor/gridjs/theme/mermaid.min.css" rel="stylesheet" type="text/css" />
    <link rel="preconnect" href="https://fonts.googleapis.com/">
    <link rel="preconnect" href="https://fonts.gstatic.com/" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Play:wght@400;700&amp;display=swap" rel="stylesheet">
    <link href="assets/css/vendor.min.css" rel="stylesheet" type="text/css" />
    <link href="assets/css/icons.min.css" rel="stylesheet" type="text/css" />
    <link href="assets/css/style.min.css" rel="stylesheet" type="text/css" />
    <script src="assets/js/config.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <style>
        /* When sidebar is condensed, hide workspace text elements */
        html[data-sidebar-size=condensed] .app-sidebar .form-label {
            display: none !important;
        }
        html[data-sidebar-size=condensed] .app-sidebar .dropdown-toggle span span {
            display: none !important;
        }
        html[data-sidebar-size=condensed] .app-sidebar .dropdown-toggle::after {
            display: none !important;
        }
        html[data-sidebar-size=condensed] .app-sidebar .dropdown-toggle {
            padding: 8px !important;
            justify-content: center !important;
            border: none !important;
            background: transparent !important;
        }
        html[data-sidebar-size=condensed] .app-sidebar .dropdown-menu {
            position: absolute !important;
            left: 70px !important;
            top: 0 !important;
            width: 220px !important;
        }
    </style>
</head>
<body>
    <div class="app-wrapper">
        <!-- Topbar Start -->
        <header class="app-topbar">
            <div class="container-fluid">
                <div class="navbar-header">
                    <div class="d-flex align-items-center gap-2">
                        <!-- Menu Toggle Button -->
                        <div class="topbar-item">
                            <button type="button" class="button-toggle-menu topbar-button">
                                <iconify-icon icon="solar:hamburger-menu-outline" class="fs-24 align-middle"></iconify-icon>
                            </button>
                        </div>

                        <!-- Top Nav Modules (Desktop only) -->
                        <div class="d-none d-md-flex align-items-center gap-2 ms-4">
                            <?php $current_page = basename($_SERVER['PHP_SELF']); ?>
                            <a href="index.php" class="nav-link px-3 py-2 fs-15 fw-semibold <?php echo $current_page == 'index.php' ? 'text-primary border-bottom border-2 border-primary' : 'text-muted'; ?>">Dashboard</a>
                            <a href="party.php" class="nav-link px-3 py-2 fs-15 fw-semibold <?php echo $current_page == 'party.php' || $current_page == 'party_form.php' ? 'text-primary border-bottom border-2 border-primary' : 'text-muted'; ?>">Party Details</a>
                            <a href="order.php" class="nav-link px-3 py-2 fs-15 fw-semibold <?php echo $current_page == 'order.php' || $current_page == 'order_form.php' ? 'text-primary border-bottom border-2 border-primary' : 'text-muted'; ?>">Orders</a>
                            <a href="chalan.php" class="nav-link px-3 py-2 fs-15 fw-semibold <?php echo $current_page == 'chalan.php' || $current_page == 'chalan_form.php' ? 'text-primary border-bottom border-2 border-primary' : 'text-muted'; ?>">Chalan</a>
                            <a href="bill.php" class="nav-link px-3 py-2 fs-15 fw-semibold <?php echo $current_page == 'bill.php' || $current_page == 'bill_form.php' ? 'text-primary border-bottom border-2 border-primary' : 'text-muted'; ?>">GST Bill</a>
                        </div>
                    </div>

                    <div class="d-flex align-items-center gap-2">
                        <!-- Theme Color (Light/Dark) -->
                        <div class="topbar-item">
                            <button type="button" class="topbar-button" id="light-dark-mode">
                                <iconify-icon icon="solar:moon-outline" class="fs-22 align-middle light-mode"></iconify-icon>
                                <iconify-icon icon="solar:sun-2-outline" class="fs-22 align-middle dark-mode"></iconify-icon>
                            </button>
                        </div>
                        <div class="topbar-item">
                            <a href="validation/logout.php">
                                <button type="button" class="topbar-button">
                                    <iconify-icon icon="mingcute:power-line" class="fs-24 align-middle"></iconify-icon>
                                </button>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </header>
        <!-- Topbar End -->

        <!-- App Menu Start -->
        <div class="app-sidebar">
            <!-- Sidebar Logo -->
            <div class="logo-box">
                <a href="index.php" class="logo-dark">
                    <img src="assets/img/logo-sm.png" class="logo-sm" alt="logo sm">
                    <img src="assets/img/logo-dark.png" class="logo-lg" alt="logo dark">
                </a>
                <a href="index.php" class="logo-light">
                    <img src="assets/img/logo-sm.png" class="logo-sm" alt="logo sm">
                    <img src="assets/img/logo-light.png" class="logo-lg" alt="logo light">
                </a>
            </div>

            <!-- Active Workspace / Searchable Owner Selector -->
            <div class="px-3 py-3 border-bottom border-light border-opacity-10">
                <label class="form-label text-muted fs-11 text-uppercase fw-bold mb-2">Active Workspace</label>
                <div class="dropdown">
                    <button class="btn btn-light w-100 text-start d-flex align-items-center justify-content-between dropdown-toggle" type="button" id="workspaceDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                        <span class="d-flex align-items-center gap-2" style="min-width: 0; flex: 1;">
                            <?php if (!empty($active_owner['img'])) { ?>
                                <img src="assets/img/<?php echo htmlspecialchars($active_owner['img']); ?>" style="width: 20px; height: 20px; object-fit: cover; border-radius: 50%; flex-shrink: 0;">
                            <?php } else { ?>
                                <iconify-icon icon="mingcute:user-3-line" style="flex-shrink: 0;"></iconify-icon>
                            <?php } ?>
                            <span class="fw-semibold text-truncate d-inline-block" style="max-width: 120px;">
                                <?php echo htmlspecialchars($active_owner['name'] ?? 'Select Owner'); ?>
                            </span>
                        </span>
                    </button>
                    <ul class="dropdown-menu p-2 shadow-lg" aria-labelledby="workspaceDropdown" style="max-height: 250px; overflow-y: auto; overflow-x: hidden !important; min-width: 220px;">
                        <li>
                            <input type="text" class="form-control form-control-sm mb-2" id="workspaceSearch" placeholder="Search owner..." onclick="event.stopPropagation();">
                        </li>
                        <?php
                        $all_owners_q = mysqli_query($conn, "SELECT * FROM users");
                        if ($all_owners_q) {
                            while ($owner_item = mysqli_fetch_assoc($all_owners_q)) {
                                $is_active = ($owner_item['owner_id'] == $active_owner_id);
                        ?>
                        <li class="workspace-item" data-name="<?php echo htmlspecialchars(strtolower($owner_item['name'])); ?>">
                            <a class="dropdown-item d-flex align-items-center justify-content-between rounded py-2 <?php echo $is_active ? 'active bg-primary text-white' : ''; ?>" href="change_workspace.php?owner_id=<?php echo $owner_item['owner_id']; ?>" style="min-width: 0;">
                                <span class="d-flex align-items-center gap-2" style="min-width: 0; flex: 1; margin-right: 8px;">
                                    <?php if (!empty($owner_item['img'])) { ?>
                                        <img src="assets/img/<?php echo htmlspecialchars($owner_item['img']); ?>" style="width: 18px; height: 18px; object-fit: cover; border-radius: 50%; flex-shrink: 0;">
                                    <?php } else { ?>
                                        <iconify-icon icon="mingcute:user-3-line" style="flex-shrink: 0;"></iconify-icon>
                                    <?php } ?>
                                    <span class="text-truncate d-inline-block" style="max-width: 130px;"><?php echo htmlspecialchars($owner_item['name']); ?></span>
                                </span>
                                <?php if ($is_active) { ?>
                                    <iconify-icon icon="mingcute:check-line" style="flex-shrink: 0;"></iconify-icon>
                                <?php } ?>
                            </a>
                        </li>
                        <?php
                            }
                        }
                        ?>
                    </ul>
                </div>
            </div>

            <div class="scrollbar" data-simplebar>
                <ul class="navbar-nav" id="navbar-nav">
                    <!-- Mobile view only links -->
                    <li class="nav-item d-md-none">
                        <a class="nav-link <?php echo $current_page == 'index.php' ? 'active' : ''; ?>" href="index.php">
                            <span class="nav-icon"><iconify-icon icon="mingcute:home-3-line"></iconify-icon></span>
                            <span class="nav-text"> Dashboard </span>
                        </a>
                    </li>
                    <li class="nav-item d-md-none">
                        <a class="nav-link <?php echo $current_page == 'party.php' || $current_page == 'party_form.php' ? 'active' : ''; ?>" href="party.php">
                            <span class="nav-icon"><iconify-icon icon="mingcute:box-line"></iconify-icon></span>
                            <span class="nav-text"> Party Details </span>
                        </a>
                    </li>
                    <li class="nav-item d-md-none">
                        <a class="nav-link <?php echo $current_page == 'order.php' || $current_page == 'order_form.php' ? 'active' : ''; ?>" href="order.php">
                            <span class="nav-icon"><iconify-icon icon="mingcute:task-line"></iconify-icon></span>
                            <span class="nav-text"> Orders </span>
                        </a>
                    </li>
                    <li class="nav-item d-md-none">
                        <a class="nav-link <?php echo $current_page == 'chalan.php' || $current_page == 'chalan_form.php' ? 'active' : ''; ?>" href="chalan.php">
                            <span class="nav-icon"><iconify-icon icon="mingcute:notebook-line"></iconify-icon></span>
                            <span class="nav-text"> Chalan </span>
                        </a>
                    </li>
                    <li class="nav-item d-md-none">
                        <a class="nav-link <?php echo $current_page == 'bill.php' || $current_page == 'bill_form.php' ? 'active' : ''; ?>" href="bill.php">
                            <span class="nav-icon"><iconify-icon icon="mingcute:bill-line"></iconify-icon></span>
                            <span class="nav-text"> GST Bill (%) </span>
                        </a>
                    </li>

                    <!-- Settings visible everywhere -->
                    <li class="nav-item">
                        <a class="nav-link <?php echo $current_page == 'settings.php' || $current_page == 'owner_form.php' ? 'active' : ''; ?>" href="settings.php">
                            <span class="nav-icon"><iconify-icon icon="mingcute:settings-3-line"></iconify-icon></span>
                            <span class="nav-text"> Settings </span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
        <!-- App Menu End -->
        
        <script>
        document.getElementById('workspaceSearch')?.addEventListener('keyup', function(e) {
            const term = this.value.toLowerCase();
            document.querySelectorAll('.workspace-item').forEach(function(item) {
                const name = item.getAttribute('data-name');
                if (name.includes(term)) {
                    item.style.display = 'block';
                } else {
                    item.style.display = 'none';
                }
            });
        });
        </script>
