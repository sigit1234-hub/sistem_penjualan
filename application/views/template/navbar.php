<div class="container">
    <div class="row">
        <div class="col-lg-2">
            <div class="header__logo">
                <a href="<?= base_url('Home') ?>"><img src="<?= base_url('assets/') ?>img/dapur.png" alt=""></a>
            </div>
        </div>
        <div class="col-lg-10">
            <nav class="header__menu">
                <ul>
                    <?php
                    if ($this->session->userdata('role_id') == 1) {
                        $queryMenu = "SELECT * FROM user_menu";
                    } else if ($this->session->userdata('role_id') == 3) {
                        $queryMenu = "SELECT * FROM user_menu
                                      WHERE id = 1 OR id = 2 OR id = 3 OR id = 4 OR id = 5 OR id = 7";
                    } else {
                        $queryMenu = "SELECT * FROM user_menu
                                      WHERE id = 1 OR id = 2 OR id = 3 OR id = 4 OR id = 5";
                    }
                    $menu = $this->db->query($queryMenu)->result_array();
                    ?>
                    <?php foreach ($menu as $m) : ?>
                        <?php if ($m['nama_menu'] == $halaman) : ?>
                            <li class='active'><a href="<?= base_url() . $m['link'] ?>">
                                    <?= $m['nama_menu']; ?>
                                    <?php if ($m['nama_menu'] == 'Keranjang') {
                                        $this->db->select_sum('jumlah');
                                        $this->db->where('id_user', $this->session->userdata('id'));
                                        $jumlah = $this->db->get('keranjang');
                                        if ($jumlah->row()->jumlah >= 1) { ?>
                                            <span><?= $jumlah->row()->jumlah; ?></span>
                                        <?php } else { ?>
                                        <?php } ?>
                                    <?php } ?>
                                </a>
                            </li>
                        <?php else : ?>
                            <li><a href="<?= base_url() . $m['link'] ?>">
                                    <?= $m['nama_menu']; ?>
                                    <?php if ($m['nama_menu'] == 'Keranjang') {
                                        $this->db->select_sum('jumlah');
                                        $this->db->where('id_user', $this->session->userdata('id'));
                                        $jumlah = $this->db->get('keranjang');
                                        if ($jumlah->row()->jumlah >= 1) { ?>
                                            <span><?= $jumlah->row()->jumlah; ?></span>
                                        <?php } else { ?>
                                        <?php } ?>
                                    <?php } ?>
                                </a>
                            </li>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </ul>
            </nav>
        </div>
    </div>
    <div class="humberger__open">
        <i class="fa fa-bars"></i>
    </div>
</div>
</header>
<!-- Header Section End -->