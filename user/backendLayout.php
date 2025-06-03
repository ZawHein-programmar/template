<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Responsive Navbar</title>
    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" />
    <link
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css"
        rel="stylesheet" />
    <style>
        .navbar-content {
            display: flex;
            align-items: center;
            width: 100%;
            justify-content: space-between;
        }

        #profile-icon::after {
            display: none !important;
        }

        #navbarSupportedContent {
            display: flex;
            justify-content: center;
            flex-grow: 1;
        }

        .navbar-list {
            display: flex;
            flex-direction: row;
            gap: 1rem;
        }

        .cart-icon-container {
            position: relative;
        }

        .cart-badge {
            position: absolute;
            top: -15px;
            right: -10px;
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

        /* Hide toggle by default on desktop */
        .navbar-toggler {
            display: none;
        }

        @media (max-width: 767.98px) {
            .navbar-list {
                display: none;
                flex-direction: column;
                width: 100%;
                background-color: #0dcaf0;
                position: absolute;
                top: 56px;
                left: 0;
                padding: 1rem;
                box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
                border-radius: 0 0 0.5rem 0.5rem;
                z-index: 10;
            }

            .navbar-list.show {
                display: flex;
            }

            .navbar-toggler {
                display: block;
                margin-left: auto;
            }

            .right-items {
                display: flex;
                align-items: center;
                gap: 1rem;
            }
        }

        @media (min-width: 768px) {
            .navbar-toggler {
                display: none;
            }

            .navbar-list {
                display: flex;
                flex-direction: row;
            }

            .right-items {
                display: flex;
                align-items: center;
                gap: 1rem;
            }
        }
    </style>
</head>

<body>
    <nav class="navbar navbar-expand-lg bg-info">
        <div class="container-fluid navbar-content">
            <a class="navbar-brand" href="#"><b>IT and Mobile</b></a>

            <div id="navbarSupportedContent">
                <div class="navbar-list" id="navbarList">
                    <a href="#" class="nav-link text-dark">List 1</a>
                    <a href="#" class="nav-link text-dark">List 2</a>
                    <a href="#" class="nav-link text-dark">List 3</a>
                </div>
            </div>

            <div class="right-items">
                <a href="#" class="nav-link text-dark cart-icon-container">
                    <i class="fas fa-shopping-cart fs-4 me-2"></i>
                    <span class="cart-badge">3</span>
                </a>
                <div class="dropdown">
                    <a
                        class="navbar-brand dropdown-toggle"
                        href="#"
                        id="profile-icon"
                        role="button"
                        data-bs-toggle="dropdown"
                        aria-expanded="false">
                        <img
                            src="../assets/userProfile/profile.jpg"
                            style="width: 50px; height: 50px; border-radius: 50%"
                            alt="Profile" />
                    </a>
                    <ul
                        class="dropdown-menu dropdown-menu-end mt-2"
                        aria-labelledby="profile-icon">
                        <li><a class="dropdown-item" href="./user/profile.php">Profile</a></li>
                        <li>
                            <button class="dropdown-item btn" type="submit" name="logout">
                                Logout
                            </button>
                        </li>
                    </ul>
                </div>
                <button class="navbar-toggler" type="button" id="navbarToggleMobile">
                    <span class="navbar-toggler-icon"></span>
                </button>
            </div>
        </div>
    </nav>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        const navbarToggleMobile = document.getElementById("navbarToggleMobile");
        const navbarList = document.getElementById("navbarList");

        navbarToggleMobile.addEventListener("click", () => {
            navbarList.classList.toggle("show");
        });
    </script>
</body>

</html>