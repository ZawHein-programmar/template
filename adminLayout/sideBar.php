<div class="sidebar-backdrop" id="sidebarBackdrop"></div>

<div class="sidebar liquid-glass-sidebar" id="sidebar">
    <div class="mt-4">
        <div class="text-center mb-4">
            <div class="profile-avatar mb-3">
                <img src="../assets/userProfile/profile.jpg" alt="Profile" style="width: 80px; height: 80px; border-radius: 50%;">
            </div>
            <h5 class="mb-1"> <?php if (isset($_COOKIE['user'])) {
                                    $user = json_decode($_COOKIE['user'], true);
                                    echo  ucwords($user['user_name']);
                                } ?></h5>
            <span class="badge badge-success"><?php if (isset($_COOKIE['user'])) {
                                                    $user = json_decode($_COOKIE['user'], true);
                                                    echo  ucwords($user['role']);
                                                } ?></span>
        </div>
        <div class="accordion accordion-flush mt-4" id="sidebarAccordion">

            <div class="accordion-item">
                <h2 class="accordion-header " id="headingDashboard">
                    <button
                        class="accordion-button collapsed"
                        type="button"
                        data-bs-toggle="collapse"
                        data-bs-target="#collapseDashboard"
                        aria-expanded="false"
                        aria-controls="collapseDashboard">
                        <i class="fas fa-tachometer-alt me-2"></i>Dashboard
                    </button>
                </h2>
                <div
                    id="collapseDashboard"
                    class="accordion-collapse collapse"
                    aria-labelledby="headingDashboard"
                    data-bs-parent="#sidebarAccordion">
                    <div class="py-3 text-center my-1">
                        <a href="../admin/index.php" class="nav-link" title="Dashboard">
                            <i class="fas fa-home"></i>
                        </a>
                    </div>
                </div>
            </div>

            <div class="accordion-item">
                <h2 class="accordion-header " id="headingOne">
                    <button
                        class="accordion-button collapsed"
                        type="button"
                        data-bs-toggle="collapse"
                        data-bs-target="#collapseOne"
                        aria-expanded="false"
                        aria-controls="collapseOne">
                        <i class="fas fa-user-tie me-2"></i>Trainer
                    </button>
                </h2>
                <div
                    id="collapseOne"
                    class="accordion-collapse collapse"
                    aria-labelledby="headingOne"
                    data-bs-parent="#sidebarAccordion">
                    <div class="py-3 text-center my-1">
                        <a href="trainer_add.php" class="nav-link ajax-link" title="Add New Trainer">
                            <i class="fas fa-user-plus"></i>
                        </a>
                        <a href="trainer_list.php" class="nav-link" title="View Trainer List">
                            <i class="fas fa-list"></i>
                        </a>
                    </div>
                </div>
            </div>

            <div class="accordion-item">
                <h2 class="accordion-header " id="headingTwo">
                    <button
                        class="accordion-button collapsed"
                        type="button"
                        data-bs-toggle="collapse"
                        data-bs-target="#collapseTwo"
                        aria-expanded="false"
                        aria-controls="collapseTwo">
                        <i class="fas fa-users me-2"></i>Member
                    </button>
                </h2>
                <div
                    id="collapseTwo"
                    class="accordion-collapse collapse"
                    aria-labelledby="headingTwo"
                    data-bs-parent="#sidebarAccordion">
                    <div class="py-3 text-center my-1">
                        <a href="member_add.php" class="nav-link" title="Add New Member">
                            <i class="fas fa-user-plus"></i>
                        </a>
                        <a href="member_list.php" class="nav-link" title="View Member List">
                            <i class="fas fa-list"></i>
                        </a>
                    </div>
                </div>
            </div>

            <div class="accordion-item">
                <h2 class="accordion-header " id="headingThree">
                    <button
                        class="accordion-button collapsed"
                        type="button"
                        data-bs-toggle="collapse"
                        data-bs-target="#collapseThree"
                        aria-expanded="false"
                        aria-controls="collapseThree">
                        <i class="fas fa-chalkboard-teacher me-2"></i>Class
                    </button>
                </h2>
                <div
                    id="collapseThree"
                    class="accordion-collapse collapse"
                    aria-labelledby="headingThree"
                    data-bs-parent="#sidebarAccordion">
                    <div class="py-3 text-center my-1">
                        <a href="class_create.php" class="nav-link" title="Create New Class">
                            <i class="fas fa-plus"></i>
                        </a>
                        <a href="class_list.php" class="nav-link" title="View Class List">
                            <i class="fas fa-list"></i>
                        </a>
                    </div>
                </div>
            </div>

            <div class="accordion-item">
                <h2 class="accordion-header " id="headingFour">
                    <button
                        class="accordion-button collapsed"
                        type="button"
                        data-bs-toggle="collapse"
                        data-bs-target="#collapseFour"
                        aria-expanded="false"
                        aria-controls="collapseFour">
                        <i class="fas fa-percentage me-2"></i>Discount
                    </button>
                </h2>
                <div
                    id="collapseFour"
                    class="accordion-collapse collapse"
                    aria-labelledby="headingFour"
                    data-bs-parent="#sidebarAccordion">
                    <div class="py-3 text-center my-1">
                        <a href="discount_create.php" class="nav-link" title="Create Discount Package">
                            <i class="fas fa-plus"></i>
                        </a>
                        <a href="discount_list.php" class="nav-link" title="View Discount List">
                            <i class="fas fa-list"></i>
                        </a>
                    </div>

                </div>
            </div>

            <div class="accordion-item">
                <h2 class="accordion-header " id="headingdetail">
                    <button
                        class="accordion-button collapsed"
                        type="button"
                        data-bs-toggle="collapse"
                        data-bs-target="#collapsedetail"
                        aria-expanded="false"
                        aria-controls="collapsedetail">
                        <i class="fas fa-tag me-2"></i>Discount Detail
                    </button>
                </h2>
                <div
                    id="collapsedetail"
                    class="accordion-collapse collapse"
                    aria-labelledby="headingdetail"
                    data-bs-parent="#sidebarAccordion">
                    <div class="py-3 text-center my-1">
                        <a href="discount_detail_create.php" class="nav-link" title="Create Discount Package">
                            <i class="fas fa-plus ms-1"></i>
                        </a>
                        <a href="discount_detail_list.php" class="nav-link" title="View Discount List">
                            <i class="fas fa-list ms-1"></i>
                        </a>
                    </div>
                </div>
            </div>

            <div class="accordion-item">
                <h2 class="accordion-header " id="headingFive">
                    <button
                        class="accordion-button collapsed"
                        type="button"
                        data-bs-toggle="collapse"
                        data-bs-target="#collapseFive"
                        aria-expanded="false"
                        aria-controls="collapseFive">
                        <i class="fas fa-chalkboard-teacher me-2"></i>Trainer Class
                    </button>
                </h2>
                <div
                    id="collapseFive"
                    class="accordion-collapse collapse"
                    aria-labelledby="headingFive"
                    data-bs-parent="#sidebarAccordion">
                    <div class="py-3 text-center my-1">
                        <a href="class_trainer_create.php" class="nav-link" title="Create Discount Package">
                            <i class="fas fa-plus"></i>
                        </a>
                        <a href="class_trainer_list.php" class="nav-link" title="View Discount List">
                            <i class="fas fa-list"></i>
                        </a>
                    </div>
                </div>
            </div>

            <div class="accordion-item">
                <h2 class="accordion-header " id="headingmc">
                    <button
                        class="accordion-button collapsed"
                        type="button"
                        data-bs-toggle="collapse"
                        data-bs-target="#collapsemc"
                        aria-expanded="false"
                        aria-controls="collapsemc">
                        <i class="fa-solid fa-book"></i>Member Class
                    </button>
                </h2>
                <div
                    id="collapsemc"
                    class="accordion-collapse collapse"
                    aria-labelledby="headingmc"
                    data-bs-parent="#sidebarAccordion">
                    <div class="py-3 text-center my-1">
                        <a href="member_class_create.php" class="nav-link" title="Create Discount Package">
                            <i class="fas fa-plus"></i>
                        </a>
                        <a href="member_class_list.php" class="nav-link" title="View Discount List">
                            <i class="fas fa-list"></i>
                        </a>
                    </div>
                </div>
            </div>
            <div class="accordion-item">
                <h2 class="accordion-header " id="headingSix">
                    <button
                        class="accordion-button collapsed"
                        type="button"
                        data-bs-toggle="collapse"
                        data-bs-target="#collapseSix"
                        aria-expanded="false"
                        aria-controls="collapseSix">
                        <i class="fas fa-credit-card me-2"></i>Payment
                    </button>
                </h2>
                <div
                    id="collapseSix"
                    class="accordion-collapse collapse"
                    aria-labelledby="headingSix"
                    data-bs-parent="#sidebarAccordion">
                    <div class="py-3 text-center my-1">
                        <a href="payment.php" class="nav-link" title="Create Payment">
                            <i class="fas fa-cart-shopping"></i>
                        </a>
                        <a href="payment_list.php" class="nav-link" title="View Payment List">
                            <i class="fas fa-list"></i>
                        </a>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>