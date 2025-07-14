<div class="sidebar-backdrop" id="sidebarBackdrop"></div>

<div class="sidebar" id="sidebar">
    <div class="mt-4">
        <div class="text-center mb-4">
            <div class="profile-avatar mb-3">
                <img src="../assets/userProfile/profile.jpg" alt="Profile" style="width: 80px; height: 80px; border-radius: 50%; border: 3px solid rgba(255,255,255,0.2);">
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
        <div class="accordion accordion-flush mt-4" style="width:100% !important; padding: 0px !important;" id="sidebarAccordion">


            <div class="accordion-item">
                <h2 class="accordion-header py-2" id="headingOne">
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
                        <a href="trainer_add.php" class="nav-link">
                            <i class="fas fa-plus me-2"></i>New Trainer Add
                        </a>
                    </div>
                    <div class="py-3 text-center my-1">
                        <a href="trainer_list.php" class="nav-link">
                            <i class="fas fa-list me-2"></i>Trainer List
                        </a>
                    </div>
                </div>
            </div>

            <div class="accordion-item">
                <h2 class="accordion-header py-2" id="headingTwo">
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
                        <a href="member_add.php" class="nav-link">
                            <i class="fas fa-user-plus me-2"></i>New Member Add
                        </a>
                    </div>
                    <div class="py-3 text-center my-1">
                        <a href="member_list.php" class="nav-link">
                            <i class="fas fa-list me-2"></i>Member List
                        </a>
                    </div>
                </div>
            </div>

            <div class="accordion-item">
                <h2 class="accordion-header py-2" id="headingThree">
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
                        <a href="class_create.php" class="nav-link">
                            <i class="fas fa-plus me-2"></i>Class Create
                        </a>
                    </div>
                    <div class="py-3 text-center my-1">
                        <a href="class_list.php" class="nav-link">
                            <i class="fas fa-list me-2"></i>Class List
                        </a>
                    </div>
                </div>
            </div>

            <div class="accordion-item">
                <h2 class="accordion-header py-2" id="headingFour">
                    <button
                        class="accordion-button collapsed"
                        type="button"
                        data-bs-toggle="collapse"
                        data-bs-target="#collapseFour"
                        aria-expanded="false"
                        aria-controls="collapseFour">
                        <i class="fas fa-percentage me-2"></i>Discount information
                    </button>
                </h2>
                <div
                    id="collapseFour"
                    class="accordion-collapse collapse"
                    aria-labelledby="headingFour"
                    data-bs-parent="#sidebarAccordion">
                    <div class="py-3 text-center my-1">
                        <a href="discount_create.php" class="nav-link">
                            <i class="fas fa-plus me-2"></i>Discount Create
                        </a>
                    </div>
                    <div class="py-3 text-center my-1">
                        <a href="discount_list.php" class="nav-link">
                            <i class="fas fa-list me-2"></i>Discount Package List
                        </a>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>