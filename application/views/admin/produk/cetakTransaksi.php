<!DOCTYPE html>

<html lang="en" class="light-style layout-menu-fixed" dir="ltr" data-theme="theme-default" data-assets-path="<?= base_url('vendor/admin/') ?>/assets/" data-template="vertical-menu-template-free">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

    <title><?= $title; ?></title>

    <meta name="description" content="" />

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="<?= base_url('assets/img/') ?>/putih.png" />

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap" rel="stylesheet" />

    <!-- Icons. Uncomment required icon fonts -->
    <link rel="stylesheet" href="<?= base_url('vendor/admin/') ?>/assets/vendor/fonts/boxicons.css" />

    <!-- Core CSS -->
    <link rel="stylesheet" href="<?= base_url('vendor/admin/') ?>/assets/vendor/css/core.css" class="template-customizer-core-css" />
    <link rel="stylesheet" href="<?= base_url('vendor/admin/') ?>/assets/vendor/css/theme-default.css" class="template-customizer-theme-css" />
    <link rel="stylesheet" href="<?= base_url('vendor/admin/') ?>/assets/css/demo.css" />

    <!-- Vendors CSS -->
    <link rel="stylesheet" href="<?= base_url('vendor/admin/') ?>/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css" />

    <!-- Page CSS -->

    <!-- Helpers -->
    <script src="<?= base_url('vendor/admin/') ?>/assets/vendor/js/helpers.js"></script>

    <!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->
    <!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->
    <script src="<?= base_url('vendor/admin/') ?>/assets/js/config.js"></script>
    <style>
        @media print {
            body * {
                visibility: hidden;
                font-size: 10px;
                margin: 0;
            }

            #tabel-cetak,
            #tabel-cetak * {
                visibility: visible;
            }

            #judul * {
                visibility: visible;
            }

            #tabel-cetak {
                position: absolute;
                left: 0;
                top: 0;
            }

            h3 {
                font-size: 20px;
            }
        }
    </style>
</head>

<body>
    <!-- Layout wrapper -->
    <div class="layout-wrapper layout-content-navbar layout-without-menu">
        <div class="layout-container">
            <!-- Layout container -->
            <div class="layout-page">
                <!-- Navbar -->

                <nav class="layout-navbar container-xxl navbar navbar-expand-xl navbar-detached align-items-center bg-navbar-theme" id="layout-navbar">
                    <div class="navbar-nav-right d-flex align-items-center" id="navbar-collapse">
                        <div class="navbar-nav  align-items-center m-3">
                            <a href="<?= base_url('Admin/transaksi') ?>">
                                <i class="bx bx-home-circle"></i>
                            </a>
                        </div>
                        <div class="navbar-nav  align-items-center m-3">
                            <?= tanggal_jam(tanggal()); ?>
                        </div>
                        <ul class="navbar-nav flex-row align-items-center ms-auto">
                            <li class="nav-item navbar-dropdown dropdown-user dropdown">
                                <a href="<?= base_url('Admin/excelTransaksi/' . $status . "/" . $tglDari . "/" . $tglSampai . "/" . $role) ?>" class="btn btn-primary m-1">Excel</a>
                                <button onclick="window.print()" class="btn btn-primary m-1">Cetak</button>
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
                    <div class="container-xxl flex-grow-1 container-p-y">
                        <?= $this->session->flashdata('message'); ?>
                        <div class="row">
                            <div class="col-lg-12 mb-4 order-0">
                                <div class="card">
                                    <div class="d-flex align-items-end row">
                                        <div class="card-body">
                                            <div class="text-wrap" id="tabel-cetak">
                                                <!-- table produc  -->
                                                <table class="table table-bordered">
                                                    <div style="text-align:center; margin-bottom:80px">

                                                        <h2><img src="<?= base_url('assets/') ?>img/dapur.png" alt="" style="margin-right:40px"> CV. DAPUR BERKAH</h2>
                                                        <p>
                                                            Alamat : Dusun kemutug RT 2 RW 1 desa tirip, kec Wadaslintang kab Wonosobo<br>
                                                            Telpone / Whatsapp : +62 821-3507-6353<br>
                                                            Email: admin@dapurberkah.my.id<br>
                                                        </p>
                                                    </div>
                                                    <div class="judul" style="margin: bottom 30px;">
                                                        <p>Data Transaksi tanggal &nbsp;: <?php if ($tglDari == $tglSampai) {
                                                                                                echo tgl($tglDari);
                                                                                            } else {
                                                                                                echo  tgl($tglDari) . ' - ' . tgl($tglSampai);
                                                                                            } ?> | Status &nbsp;: <?php if ($status == 0) {
                                                                                                                        echo 'Semua ';
                                                                                                                    } else if ($status == 200) {
                                                                                                                        echo "Dikemas";
                                                                                                                    } else if ($status == 201) {
                                                                                                                        echo "Belum Bayar";
                                                                                                                    } else if ($status == 202) {
                                                                                                                        echo "Dikirim";
                                                                                                                    } else if ($status == 204) {
                                                                                                                        echo "Selesai";
                                                                                                                    } else if ($status == 203) {
                                                                                                                        echo "DiBatalkan";
                                                                                                                    } else if ($status == 407) {
                                                                                                                        echo "Kadaluwarsa";
                                                                                                                    } ?> </p>
                                                    </div>
                                                    <thead>
                                                        <div id="hasil"></div>
                                                        <tr>
                                                            <th width="2%">No</th>
                                                            <th width="5%">Tanggal</th>
                                                            <th>Kode</th>
                                                            <th>Produk</th>
                                                            <th>qty</th>
                                                            <?php if ($role == 1) { ?>
                                                                <th>Kurir</th>
                                                                <th>Resi</th>
                                                            <?php } ?>
                                                            <th>Pembayaran</th>
                                                            <th>Total(Rp)</th>
                                                            <th>Status</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="tabelInput">
                                                        <?php $no = 1;
                                                        foreach ($dataTransaksi as $d) : ?>
                                                            <tr id="dataTable">
                                                                <?php
                                                                $idProduk = explode(",", $d['id_produk']);
                                                                $qty = explode(",", $d['jumlah']);
                                                                ?>
                                                                <td><?= $no++; ?></td>
                                                                <td><?= tanggal_jam($d['tanggal_transaksi']); ?></td>
                                                                <td><?= $d['kode_transaksi']; ?></td>
                                                                <td>
                                                                    <?php
                                                                    for ($i = 0; $i < count($idProduk); $i++) {
                                                                        $this->db->where('id_produk', $idProduk[$i]);
                                                                        $produk = $this->db->get('produk')->result_array();
                                                                        foreach ($produk as $p) : ?>
                                                                            <table>
                                                                                <tr>
                                                                                    <td><?= $p['nama_produk']; ?></>
                                                                                        <!-- <td><?= $qty[$i]; ?></td> -->
                                                                                </tr>
                                                                            </table>
                                                                    <?php endforeach;
                                                                    } ?>
                                                                </td>
                                                                <td>
                                                                    <?php
                                                                    for ($u = 0; $u < count($qty); $u++) { ?>
                                                                        <table>
                                                                            <tr>
                                                                                <td><?= $qty[$u]; ?></td>
                                                                            </tr>
                                                                        </table>
                                                                    <?php } ?>
                                                                </td>
                                                                <?php if ($role == 1) { ?>
                                                                    <td>
                                                                        <?= $d['kurir'] . "-" . $d['paket']; ?>
                                                                    </td>
                                                                    <td><?= $d['resi']; ?></td>
                                                                <?php } ?>
                                                                <td><?= $d['tipe_pembayaran'] . "<br>" . $d['bank'] . " " . $d['va_number']; ?></td>
                                                                <td><?= Rupiah($d['total_pembayaran']); ?></td>
                                                                <td><?php if ($d['status'] == 200) {
                                                                        echo "Dikemas";
                                                                    } else if ($d['status'] == 201) {
                                                                        echo "Belum Bayar";
                                                                    } else if ($d['status'] == 202) {
                                                                        echo "Dikirim";
                                                                    } else if ($d['status'] == 204) {
                                                                        echo "Selesai";
                                                                    } else if ($d['status'] == 203) {
                                                                        echo "DiBatalkan";
                                                                    } else if ($d['status'] == 407) {
                                                                        echo "Kadaluwarsa";
                                                                    } ?></td>
                                                            </tr>

                                                        <?php endforeach; ?>
                                                    </tbody>
                                                </table>

                                            </div>
                                        </div>
                                        <!-- table discount  -->
                                    </div>
                                </div>
                            </div>
                            <!-- row  -->
                        </div>
                        <!-- </form> -->
                        <!-- </div>s -->
                        <!--/ Layout Demo -->
                    </div>
                    <!-- / Content -->

                    <!-- Footer -->
                    <footer class="content-footer footer bg-footer-theme">
                        <div class="container-xxl d-flex flex-wrap justify-content-between py-2 flex-md-row flex-column">
                            <div class="mb-2 mb-md-0">
                                ©
                                <?= date('Y') ?>
                                CV Dapur Berkah
                            </div>
                        </div>
                    </footer>
                    <!-- / Footer -->

                    <div class="content-backdrop fade"></div>
                </div>
                <!-- Content wrapper -->
            </div>
            <!-- / Layout page -->
        </div>
    </div>
    <!-- / Layout wrapper -->

    <!-- <div class="buy-now">
    <a href="<?= base_url('Admin') ?>" class="btn btn-danger btn-buy-now">Menu Admin</a>
</div> -->

    <!-- Core JS -->
    <!-- build:js assets/vendor/js/core.js -->
    <script src="<?= base_url('vendor/admin/') ?>/assets/vendor/libs/jquery/jquery.js"></script>
    <script src="<?= base_url('vendor/admin/') ?>/assets/vendor/libs/popper/popper.js"></script>
    <script src="<?= base_url('vendor/admin/') ?>/assets/vendor/js/bootstrap.js"></script>
    <script src="<?= base_url('vendor/admin/') ?>/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js"></script>

    <script src="<?= base_url('vendor/admin/') ?>/assets/vendor/js/menu.js"></script>
    <!-- endbuild -->

    <!-- Vendors JS -->

    <!-- Main JS -->
    <script src="<?= base_url('vendor/admin/') ?>/assets/js/main.js"></script>

    <!-- Page JS -->

    <!-- Place this tag in your head or just before your close body tag. -->
    <script async defer src="https://buttons.github.io/buttons.js"></script>
    <script>
        function addRp(input) {
            let inputValue = input.value;

            // Hapus karakter non-digit
            inputValue = inputValue.replace(/[^\d]/g, '');

            // Format nilai ke format Rupiah
            inputValue = parseInt(inputValue, ).toLocaleString('id-ID', {
                minimumFractionDigits: 0,
                maximumFractionDigits: 0
            });

            // Setel nilai input kembali
            input.value = inputValue;
        }
    </script>
    <script>
        // Fungsi untuk mengubah format Rupiah
        function formatRupiah(input) {
            let inputValue = input.value;

            // Hapus karakter non-digit
            inputValue = inputValue.replace(/[^\d]/g, '');

            // Format nilai ke format Rupiah
            inputValue = parseInt(inputValue, 10).toLocaleString('id-ID', {
                style: 'currency',
                currency: 'IDR',
                minimumFractionDigits: 0,
                maximumFractionDigits: 0
            });

            // Setel nilai input kembali
            input.value = inputValue;
        }

        // Dapatkan semua elemen dengan kelas "rupiah-input"
        let rupiahInputs = document.querySelectorAll('.rupiah-input');

        // Tambahkan event listener untuk setiap elemen
        rupiahInputs.forEach(function(input) {
            input.addEventListener('input', function() {
                formatRupiah(input);
            });
        });

        // Panggil fungsi saat halaman dimuat (opsional)
        window.onload = function() {
            // Format nilai Rupiah untuk setiap elemen saat halaman dimuat
            rupiahInputs.forEach(function(input) {
                formatRupiah(input);
            });
        };
    </script>

    <script>
        function formatDesimal(angka) {
            // Menghilangkan digit desimal
            var formattedNumber = angka.toFixed(0);

            // Menambahkan tanda ribuan dan simbol mata uang
            formattedNumber = Number(formattedNumber).toLocaleString('id-ID', {
                minimumFractionDigits: 0,
                maximumFractionDigits: 0
            });

            return formattedNumber;
        }
    </script>
</body>

</html>