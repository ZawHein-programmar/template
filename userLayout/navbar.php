<nav class="navbar navbar-expand bg-info">
    <div class="container-fluid navbar-content">
        <div class="d-flex align-items-center">
            <h3 class="navbar-brand ms-lg-3 p-0 m-0"><b>My Shop</b></h3>
        </div>

        <div class="desktop-search">
            <form class="d-flex w-100">
                <input class="form-control me-2" type="search" placeholder="Search">
                <button class="btn btn-outline-dark" type="submit">Search</button>
            </form>
        </div>

        <div class="desktop-nav-items-one d-flex align-items-center">
            <ul class="navbar-nav align-items-center">
                <li class="nav-item dropdown  mx-3">
                    <a class="nav-link" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Products
                    </a>
                    <ul class="dropdown-menu mt-3" aria-labelledby="navbarDropdown">
                        <li><a class="dropdown-item" href="../admin/add_branch_product.php">Add Product in Branch</a></li>
                        <li><a class="dropdown-item" href="../admin/branch_product_list.php">Product in Branch List</a></li>
                    </ul>
                </li>
                <li class="nav-item dropdown  mx-3">
                    <a class="nav-link" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Products
                    </a>
                    <ul class="dropdown-menu mt-3" aria-labelledby="navbarDropdown">
                        <li><a class="dropdown-item" href="../admin/add_branch_product.php">Add Product in Branch</a></li>
                        <li><a class="dropdown-item" href="../admin/branch_product_list.php">Product in Branch List</a></li>
                    </ul>
                </li>
                <li class="nav-item dropdown  mx-3">
                    <a class="nav-link" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Products
                    </a>
                    <ul class="dropdown-menu mt-3" aria-labelledby="navbarDropdown">
                        <li><a class="dropdown-item" href="../admin/add_branch_product.php">Add Product in Branch</a></li>
                        <li><a class="dropdown-item" href="../admin/branch_product_list.php">Product in Branch List</a></li>
                    </ul>
                </li>
            </ul>
        </div>

        <div class="desktop-nav-items d-flex align-items-center">
            <ul class="navbar-nav align-items-center">

                <li class=" nav-item ms-3 me-3">
                    <a href="#" class="nav-link text-dark cart-icon-container">
                        <i class="fas fa-shopping-cart me-1"></i> Cart
                        <span class="cart-badge">3</span>
                    </a>
                </li>

                <li class="nav-item">
                    <form method="post">
                        <div class="dropdown">
                            <a class="navbar-brand dropdown-toggle" href="#" id="profileDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <img src="../assets/userProfile/profile.jpg" style="width: 60px; height: 60px; border-radius: 50%;" id="profileImage" alt="Image" class="ms-2">
                            </a>

                            <ul class="dropdown-menu dropdown-menu-end mt-2" aria-labelledby="profileDropdown">
                                <li><a class="dropdown-item" href="./user/profile.php">Profile</a></li>
                                <li>
                                    <button class="dropdown-item btn" type="submit" name="logout">Logout</button>
                                </li>
                            </ul>
                        </div>
                    </form>
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