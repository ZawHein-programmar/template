<nav class="navbar navbar-expand bg-info">
    <div class="container-fluid navbar-content">
        <div class="d-flex align-items-center">
            <a class="navbar-brand" href="#">
                <i class="fas fa-bars toggle-icon ms-2 text-dark" id="toggleIcon"></i>
            </a>
            <h3 class="navbar-brand ms-lg-3 p-0 m-0"><b>My Shop</b></h3>
        </div>


        <div class="desktop-search">
            <form class="d-flex w-100">
                <input class="form-control me-2" type="search" placeholder="Search">
                <button class="btn btn-outline-dark" type="submit">Search</button>
            </form>
        </div>

        <div class="desktop-nav-items d-flex align-items-center">
            <ul class="navbar-nav align-items-center">
                <li class=" nav-item ms-3 me-3">
                    <a href="#" class="nav-link text-dark cart-icon-container">
                        <i class="fas fa-shopping-cart me-1"></i> Cart
                        <span class="cart-badge">3</span>
                    </a>
                </li>

                <?php if (!$status) { ?>
                    <li class="nav-item d-inline-block">
                        <div class="d-flex align-items-center">
                            <div class="bg-info rounded-circle d-flex justify-content-center align-items-center" style="width: 30px; height: 40px;">
                                <i class="fas fa-user fs-3"></i>
                            </div>
                            <div class="ms-2">
                                <a href="login.php" class="nav-link text-dark text-info">Sign in</a>
                                <a href="register.php" class="nav-link text-dark text-info" style="margin-top: -20px !important;padding-top: -20px !important;">Sign up</a>
                            </div>
                        </div>
                    </li>
                <?php } ?>

                <?php if ($status) { ?>
                    <li class="nav-item">
                        <form method="post">
                            <div class="dropdown">
                                <a class="navbar-brand dropdown-toggle" href="#" id="profileDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <img src="./assets/userProfile/profile.jpg" style="width: 60px; height: 60px; border-radius: 50%;" id="profileImage" alt="Image" class="ms-2">
                                </a>

                                <ul class="dropdown-menu dropdown-menu-end mt-2" aria-labelledby="profileDropdown">
                                    <li><a class="dropdown-item" href="../user/profile.php">Profile</a></li>
                                    <li>
                                        <button class="dropdown-item btn" type="submit" name="logout">Logout</button>
                                    </li>
                                </ul>
                            </div>
                        </form>
                    </li>
                <?php } ?>
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