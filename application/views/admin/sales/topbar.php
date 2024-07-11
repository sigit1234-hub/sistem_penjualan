<div class="layout-container">
    <!-- Layout container -->
    <div class="layout-page">
        <!-- Navbar -->

        <nav class="layout-navbar container-xxl navbar navbar-expand-xl navbar-detached align-items-center bg-navbar-theme" id="layout-navbar">
            <div class="navbar-nav-right d-flex align-items-center" id="navbar-collapse">
                <div class="navbar-nav  align-items-center m-3">
                    <a href="<?= base_url('Penjualan') ?>">
                        <i class="bx bx-home-circle"></i>
                    </a>
                </div>
                <div class="navbar-nav  align-items-center m-3">
                    <?= tanggal_jam(tanggal()); ?>
                </div>
                <ul class="navbar-nav flex-row align-items-center ms-auto">
                    <li>Kasir: <?= $user['nama']; ?></li>
                    <li class="nav-item navbar-dropdown dropdown-user dropdown">
                        <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);" data-bs-toggle="dropdown">
                            <div class="avatar">
                                <img src="<?= base_url('assets/img/user/') . $user['foto'] ?>" alt />
                            </div>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li>
                                <a class="dropdown-item" href="#">
                                    <div class="d-flex">
                                        <div class="flex-shrink-0 me-3">
                                            <div class="avatar">
                                                <img src="<?= base_url('assets/img/user/') . $user['foto'] ?>" alt />
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </li>
                            <li>
                                <div class="dropdown-divider"></div>
                            </li>
                            <li>
                                <a class="dropdown-item" href="<?= base_url('Akun') ?>">
                                    <i class="bx bx-user me-2"></i>
                                    <span class="align-middle">Akun</span>
                                </a>
                            </li>
                    </li>
                    <li>
                        <div class="dropdown-divider"></div>
                    </li>
                    <li>
                        <a class="dropdown-item" href="<?= base_url('Auth/logout') ?>">
                            <i class="bx bx-power-off me-2"></i>
                            <span class="align-middle">Keluar</span>
                        </a>
                    </li>
                </ul>
                </li>
                <!--/ User -->
                </ul>
            </div>
        </nav>

        <!-- / Navbar -->
        <!-- Content wrapper -->
        <div class="content-wrapper">
            <!-- Content -->