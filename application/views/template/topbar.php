<div class="humberger__menu__overlay"></div>
<div class="humberger__menu__wrapper">
    <div class="humberger__menu__logo">
        <a href="#"><img src="<?= base_url('assets/') ?>img/logo.png" alt=""></a>
    </div>
    <div class="humberger__menu__cart">
        <ul>
            <?php
            if ($this->session->userdata('email') != null) { ?>
                <div class="col-lg-6 col-md-6">
                    <div class="header__top__right">
                        <div class="header__top__right__language">
                            <img src="img/language.png" alt="">
                            <div><i class="fa fa-user"></i>
                                <?= $user['nama'] ?>
                            </div>
                            <span class="arrow_carrot-down"></span>
                            <ul>
                                <li><a href="<?= base_url('Akun') ?>">Profile</a></li>
                                <li><a href="<?= base_url('Auth/logout') ?>">Keluar</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            <?php } else { ?>
                <div class="col-lg-6 col-md-6">
                    <div class="header__top__right">
                        <div class="header__top__right__language">
                            <div class="header__top__right__auth">
                                <a href="<?= base_url('Auth') ?>"><i class="fa fa-user"></i> Masuk</a>
                            </div>
                        </div>
                        <div class="header__top__right__auth">
                            <a href="<?= base_url('Auth/registrasi') ?>"><i class="fa fa-user"></i> Daftar</a>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </ul>
    </div>
    <nav class="humberger__menu__nav mobile-menu">
        <ul>
            <?php
            if ($this->session->userdata('role_id') == 1) {
                $queryMenu = "SELECT * FROM user_menu";
            } else {
                $queryMenu = "SELECT * FROM user_menu
                                      WHERE id = 1 OR id = 2  OR id = 4 OR id = 5";
            }
            $menu = $this->db->query($queryMenu)->result_array();
            ?>
            <?php foreach ($menu as $m) : ?>
                <?php if ($m['nama_menu'] == $halaman) : ?>
                    <li class='active'><a href="<?= base_url() . $m['link'] ?>">
                            <?= $m['nama_menu']; ?>
                        </a>
                    </li>
                <?php else : ?>
                    <li><a href="<?= base_url() . $m['link'] ?>">
                            <?= $m['nama_menu']; ?>
                        </a>
                    </li>
                <?php endif; ?>
            <?php endforeach; ?>
        </ul>
    </nav>
    <div id="mobile-menu-wrap"></div>

    <div class="humberger__menu__contact">
        <ul>
            <li><i class="fa fa-envelope"></i> admin@dapurberkah.my.id</li>
        </ul>
    </div>
</div>
<!-- Humberger End -->
<!-- Header Section Begin -->
<header class="header">
    <div class="header__top">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-md-6">
                    <div class="header__top__left">
                        <ul>
                            <li><i class="fa fa-envelope"></i> admin@dapurberkah.my.id</li>
                            <!-- <li>Free Shipping for all Order of $99</li> -->
                        </ul>
                    </div>
                </div>
                <?php
                if ($this->session->userdata('email') != null) { ?>
                    <div class="col-lg-6 col-md-6">
                        <div class="header__top__right">
                            <div class="header__top__right__language">
                                <img src="img/language.png" alt="">
                                <div><i class="fa fa-user"></i>
                                    <?= $user['nama'] ?>
                                </div>
                                <span class="arrow_carrot-down"></span>
                                <ul>
                                    <li><a href="<?= base_url('Akun') ?>">Profile</a></li>
                                    <li><a href="<?= base_url('Auth/logout') ?>">Keluar</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                <?php } else { ?>
                    <div class="col-lg-6 col-md-6">
                        <div class="header__top__right">
                            <div class="header__top__right__language">
                                <div class="header__top__right__auth">
                                    <a href="<?= base_url('Auth') ?>"><i class="fa fa-user"></i> Masuk</a>
                                </div>
                            </div>
                            <div class="header__top__right__auth">
                                <a href="<?= base_url('Auth/registrasi') ?>"><i class="fa fa-user"></i> Daftar</a>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>