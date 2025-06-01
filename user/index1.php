<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Shop</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <style>
        /* Sidebar styles */
        .sidebar {
            width: 250px;
            height: 100vh;
            position: fixed;
            left: 0;
            top: 0;
            background-color: #343a40;
            color: white;
            transition: all 0.3s;
            z-index: 1000;
            padding-top: 56px;
            /* Height of navbar */
        }

        .sidebar.hide {
            left: -250px;
        }

        .sidebar-backdrop {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 999;
            display: none;
        }

        .sidebar-backdrop.active {
            display: block;
        }

        .sidebar.show-mobile {
            left: 0;
        }

        .content {
            min-height: 100vh;
            transition: all 0.3s;
            background-color: #f8f9fa;
            /* Default background color */
        }

        .content.full {
            margin-left: 0;
        }

        /* Navbar styles */
        .navbar {
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .search-container {
            background-color: #f8f9fa;
            padding: 10px 0;
        }

        .desktop-search {
            max-width: 500px;
            margin: 0 auto;
        }

        /* Cart badge styles */
        .cart-icon-container {
            position: relative;
            display: inline-block;
        }

        .cart-badge {
            position: absolute;
            top: -5px;
            right: -5px;
            font-size: 10px;
            background-color: #dc3545;
            color: white;
            border-radius: 50%;
            width: 16px;
            height: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        #profileDropdown::after,
        #productDropdown::after {
            display: none;
        }

        /* Responsive adjustments */
        @media (max-width: 767.98px) {
            .sidebar {
                left: -250px;
            }

            .desktop-nav-items,
            .desktop-nav-items-one,
            .desktop-search {
                display: none;
            }

            .content {
                margin-left: 0;
            }
        }

        @media (min-width: 768px) {

            .mobile-nav-items,
            .mobile-search {
                display: none;
            }

            .content {
                margin-left: 250px;
            }
        }

        /* Fix for bg-info typo and make it responsive */
        .bg-custom {
            background-color: #0dcaf0 !important;
            /* Bootstrap's info color */
        }

        @media (max-width: 588px) {
            .bg-custom {
                background-color: #0dcaf0 !important;
                /* Keep same color but ensure it works */
            }

            .navbar-brand {
                font-size: 1.2rem !important;
            }

            .profile-image {
                width: 40px !important;
                height: 40px !important;
            }
        }

        /* Sidebar navigation styles */
        .sidebarNavBar .dropdown-menu {
            background-color: #495057;
        }

        .sidebarNavBar .dropdown-item {
            color: rgba(255, 255, 255, 0.8);
        }

        .sidebarNavBar .dropdown-item:hover {
            background-color: #6c757d;
            color: white;
        }
    </style>
</head>

<body>
    <!-- Sidebar Backdrop -->
    <div class="sidebar-backdrop" id="sidebarBackdrop"></div>

    <!-- Sidebar -->
    <div class="sidebar" id="sidebar">
        <div class="sidebarNavBar">
            <ul class="nav flex-column px-2">
                <li class="nav-item">
                    <a class="nav-link active" href="#">
                        <i class="fas fa-home me-2"></i> Dashboard
                    </a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="sidebarProductsDropdown" role="button" data-bs-toggle="dropdown">
                        <i class="fas fa-boxes me-2"></i> Products
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="sidebarProductsDropdown">
                        <li><a class="dropdown-item" href="../admin/add_branch_product.php">Add Product in Branch</a></li>
                        <li><a class="dropdown-item" href="../admin/branch_product_list.php">Product in Branch List</a></li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">
                        <i class="fas fa-shopping-cart me-2"></i> Orders
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">
                        <i class="fas fa-users me-2"></i> Customers
                    </a>
                </li>
            </ul>
        </div>
    </div>

    <!-- Main Content -->
    <div class="content" id="content">
        <nav class="navbar navbar-expand-lg bg-custom navbar-dark">
            <div class="container-fluid">
                <div class="d-flex align-items-center">
                    <button class="btn btn-link text-white me-2 d-lg-none" id="toggleIcon">
                        <i class="fas fa-bars"></i>
                    </button>
                    <h3 class="navbar-brand m-0"><b>My Shop</b></h3>
                </div>

                <div class="desktop-search">
                    <form class="d-flex w-100">
                        <input class="form-control me-2" type="search" placeholder="Search">
                        <button class="btn btn-outline-light" type="submit">Search</button>
                    </form>
                </div>

                <div class="desktop-nav-items-one d-flex align-items-center">
                    <ul class="navbar-nav align-items-center">
                        <li class="nav-item dropdown mx-2">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown">
                                Products
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end mt-2" aria-labelledby="navbarDropdown">
                                <li><a class="dropdown-item" href="../admin/add_branch_product.php">Add Product in Branch</a></li>
                                <li><a class="dropdown-item" href="../admin/branch_product_list.php">Product in Branch List</a></li>
                            </ul>
                        </li>
                    </ul>
                </div>

                <div class="desktop-nav-items d-flex align-items-center">
                    <ul class="navbar-nav align-items-center">
                        <li class="nav-item mx-2">
                            <a href="#" class="nav-link text-white cart-icon-container">
                                <i class="fas fa-shopping-cart me-1"></i> Cart
                                <span class="cart-badge">3</span>
                            </a>
                        </li>

                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="profileDropdown" role="button" data-bs-toggle="dropdown">
                                <img src="../assets/userProfile/profile.jpg" class="rounded-circle profile-image" style="width: 40px; height: 40px;" alt="Profile">
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end mt-2" aria-labelledby="profileDropdown">
                                <li><a class="dropdown-item" href="./user/profile.php">Profile</a></li>
                                <li>
                                    <button class="dropdown-item" type="submit" name="logout">Logout</button>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>

        <div class="search-container mobile-search">
            <div class="container-fluid">
                <form class="d-flex w-100">
                    <input class="form-control me-2" type="search" placeholder="Search">
                    <button class="btn btn-outline-dark" type="submit">Search</button>
                </form>
            </div>
        </div>

        <!-- Page Content -->
        <div class="container-fluid p-4">
            <h2>Welcome to My Shop</h2>
            <p>This is the main content area of your application.</p>

            <!-- Example cards -->
            <div class="row mt-4">
                <div class="col-md-4 mb-4">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Total Products</h5>
                            <h2 class="card-text">124</h2>
                            <a href="#" class="btn btn-primary">View Products</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Total Orders</h5>
                            <h2 class="card-text">56</h2>
                            <a href="#" class="btn btn-primary">View Orders</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Total Customers</h5>
                            <h2 class="card-text">42</h2>
                            <a href="#" class="btn btn-primary">View Customers</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        const toggleIcon = document.getElementById('toggleIcon');
        const sidebar = document.getElementById('sidebar');
        const content = document.getElementById('content');
        const sidebarBackdrop = document.getElementById('sidebarBackdrop');

        function toggleSidebar() {
            if (window.innerWidth <= 768) {
                sidebar.classList.toggle('show-mobile');
                sidebarBackdrop.classList.toggle('active');
            } else {
                sidebar.classList.toggle('hide');
                content.classList.toggle('full');
            }
        }

        toggleIcon.addEventListener('click', toggleSidebar);

        sidebarBackdrop.addEventListener('click', () => {
            if (window.innerWidth <= 768) {
                sidebar.classList.remove('show-mobile');
                sidebarBackdrop.classList.remove('active');
            }
        });

        window.addEventListener('resize', () => {
            if (window.innerWidth > 768) {
                sidebar.classList.remove('show-mobile');
                sidebarBackdrop.classList.remove('active');
                sidebar.classList.remove('hide');
                content.classList.remove('full');
            }
        });
    </script>
</body>

</html>