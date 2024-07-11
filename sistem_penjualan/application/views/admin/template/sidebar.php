<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
    <div class="app-brand demo">
        <a href="index.html" class="app-brand-link">

            <a href="<?= base_url('Admin') ?>"><img src="<?= base_url('assets/') ?>img/dapur.png" alt=""></a>
        </a>

        <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
            <i class="bx bx-chevron-left bx-sm align-middle"></i>
        </a>
    </div>

    <div class="menu-inner-shadow"></div>

    <ul class="menu-inner py-1">
        <!-- Dashboard -->
        <?php
        $query = "SELECT * FROM user_role WHERE id !=4";
        $menu = $this->db->query($query)->result_array();
        foreach ($menu as $row) :
        ?>
            <li class="menu-header small text-uppercase">
                <span class="menu-header-text">
                    <?= $row['role'] ?>
                </span>
            </li>
            <?php
            $menu_id = $row['id'];
            $sql = "SELECT * FROM user_sub_menu WHERE menu_id = $menu_id && is_active = 1";
            $sub_menu = $this->db->query($sql)->result_array();
            foreach ($sub_menu as $sub) :
            ?>
                <li class="menu-item <?php if ($sub['title'] == $title) {
                                            echo "active";
                                        } ?> ">
                    <a href="<?= base_url() . $sub['url'] ?>" <?php if ($sub['title'] == 'Lihat Website') {
                                                                    echo "target='blank'";
                                                                } ?> class="menu-link">
                        <i class="menu-icon tf-icons bx <?= $sub['icon'] ?>"></i>
                        <div data-i18n="Basic">
                            <?= $sub['title'] ?>
                        </div>
                    </a>
                </li>
            <?php endforeach; ?>
        <?php endforeach; ?>

        <li class="menu-header small text-uppercase">
        <li class="menu-item">
            <a href="<?= base_url("Akun/logout") ?>" class=" menu-link">
                <i class="menu-icon tf-icons bx bx-log-out"></i>
                <div data-i18n="Basic">
                    Keluar
                </div>
            </a>
        </li>
        </li>
    </ul>
</aside>
<!-- / Menu -->