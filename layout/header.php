<?php

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bootstrap Sidebar Toggle</title>
    <link rel="stylesheet" href="./assets/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
</head>

<body>
    <div class="sidebar-backdrop" id="sidebarBackdrop"></div>


    <div class="sidebar" id="sidebar">
        <h4 class="text-center p-3">Sidebar</h4>
        <ul class="nav flex-column p-2 sidebarNavBar mt-3">
            <li class="nav-item"><a href="#" class="nav-link text-light fs-5 py-3">Home</a></li>
            <li class="nav-item"><a href="#" class="nav-link text-light fs-5 py-3">About</a></li>
            <li class="nav-item"><a href="#" class="nav-link text-light fs-5 py-3">Services</a></li>
            <li class="nav-item"><a href="#" class="nav-link text-light fs-5 py-3">Contact</a></li>
            <li class="nav-item dropdown">
                <a href="#" class="nav-link text-light fs-5 py-3 dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">Services</a>
                <ul class="dropdown-menu">
                    <li><a href="#" class="dropdown-item">Web Development</a></li>
                    <li><a href="#" class="dropdown-item">Graphic Design</a></li>
                    <li><a href="#" class="dropdown-item">SEO Optimization</a></li>
                </ul>
            </li>
        </ul>
    </div>

    <div class="content" id="content">

        <nav class="navbar navbar-expand-md bg-info">
            <div class="container-fluid">
                <a class="navbar-brand" href="#">
                    <i class="fas fa-bars toggle-icon ms-2 text-dark" id="toggleIcon"></i>
                </a>
                <h3 class="navbar-brand ms-lg-3 p-0 m-0"><b>My Shop</b></h3>
                <button class="navbar-toggler text-dark" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse text-dark linkNavBar" id="navbarNav">
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item px-2">
                            <a class="nav-link active" aria-current="page" href="#">Home</a>
                        </li>
                        <li class="nav-item px-2">
                            <a class="nav-link" href="#">Features</a>
                        </li>
                        <li class="nav-item px-2">
                            <a class="nav-link" href="#">Pricing</a>
                        </li>
                        <li class="nav-item px-2">
                            <a class="nav-link" aria-disabled="true">Disabled</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
        <div class="container-fluid mt-4">
            <h1>Product List</h1>
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
                // Mobile behavior
                sidebar.classList.toggle('show-mobile');
                sidebarBackdrop.classList.toggle('active');
            } else {
                // Desktop behavior
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

        // Handle window resize
        window.addEventListener('resize', () => {
            if (window.innerWidth > 768) {
                // Reset to desktop view
                sidebar.classList.remove('show-mobile');
                sidebarBackdrop.classList.remove('active');
                sidebar.classList.remove('hide');
                content.classList.remove('full');
            }
        });
    </script>
</body>

</html>