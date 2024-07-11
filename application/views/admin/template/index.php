<!-- Content wrapper -->
<div class="content-wrapper">
    <!-- Content -->

    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-lg-6 mb-4 order-0">
                <div class="card">
                    <div class="d-flex align-items-end row">
                        <div class="col-sm-7">
                            <div class="card-body">
                                <h5 class="card-title text-primary">Selamat datang <?= nama($this->session->userdata['id']); ?> 🎉</h5>
                            </div>
                        </div>
                        <div class="col-sm-5 text-center text-sm-left">
                            <div class="card-body pb-0 px-0 px-md-4">
                                <img src="<?= base_url('vendor/admin/') ?>assets/img/illustrations/man-with-laptop-light.png" height="140" alt="View Badge User" data-app-dark-img="illustrations/man-with-laptop-dark.png" data-app-light-img="illustrations/man-with-laptop-light.png" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-md-4 order-1">
                <div class="row">
                    <div class="col-6 mb-4">
                        <div class="card">
                            <div class="card-body">
                                <div class="card-title d-flex align-items-start justify-content-between">
                                    <div class="avatar flex-shrink-0">
                                        <img src="<?= base_url('vendor/admin/') ?>assets/img/icons/unicons/paypal.png" alt="Credit Card" class="rounded" />
                                    </div>
                                    <div class="dropdown">
                                        <button class="btn p-0" type="button" id="cardOpt4" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i class="bx bx-dots-vertical-rounded"></i>
                                        </button>
                                        <div class="dropdown-menu dropdown-menu-end" aria-labelledby="cardOpt4">
                                            <a class="dropdown-item" href="javascript:void(0);">View More</a>
                                            <a class="dropdown-item" href="javascript:void(0);">Delete</a>
                                        </div>
                                    </div>
                                </div>
                                <span class="d-block mb-1">Total Produk</span>
                                <h3 class="card-title text-nowrap mb-2" id="dataProduk">0</h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 mb-4">
                        <div class="card">
                            <div class="card-body">
                                <div class="card-title d-flex align-items-start justify-content-between">
                                    <div class="avatar flex-shrink-0">
                                        <img src="<?= base_url('vendor/admin/') ?>assets/img/icons/unicons/cc-primary.png" alt="Credit Card" class="rounded" />
                                    </div>
                                    <div class="dropdown">
                                        <button class="btn p-0" type="button" id="cardOpt1" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i class="bx bx-dots-vertical-rounded"></i>
                                        </button>
                                        <div class="dropdown-menu" aria-labelledby="cardOpt1">
                                            <a class="dropdown-item" href="javascript:void(0);">View More</a>
                                            <a class="dropdown-item" href="javascript:void(0);">Delete</a>
                                        </div>
                                    </div>
                                </div>
                                <span class="fw-semibold d-block mb-1">User</span>
                                <h3 class="card-title mb-2" id="dataUser">0</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-md-4 order-1">
                <div class=" card h-100">
                    <div class="card-header d-flex align-items-center justify-content-between pb-0">
                        <div class="card-title mb-0">
                            <h5 class="m-0 me-2">Transaksi</h5>
                            <small class="text-muted" id="totalTransaksi"></small>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <div class="d-flex flex-column align-items-center gap-1">
                                <h2 class="mb-2" id="pesananMasuk">0</h2>
                                <span>Pesanan Masuk</span>
                            </div>
                            <div id="orderStatisticsChart"></div>
                        </div>
                        <ul class="p-0 m-0">
                            <div class="card overflow-hidden mb-4" style="height: 300px">
                                <div class="card-body" id="vertical-example">
                                    <?php
                                    foreach ($pesanan as $p) : ?>
                                        <li class="d-flex mb-4 pb-1">
                                            <div class="avatar flex-shrink-0 me-3">
                                                <span class="avatar-initial rounded bg-label-primary"><i class="bx bx-bell"></i></span>
                                            </div>
                                            <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                                                <div class="me-2">
                                                    <h6 class="mb-0"><?= $p['kode_transaksi']; ?></h6>
                                                    <?php
                                                    $idProduk = explode(",", $p['id_produk']);
                                                    $qtyProduk = explode(",", $p['jumlah']);
                                                    for ($i = 0; $i < count($idProduk); $i++) { ?>
                                                        <small class="text-muted"><?= namaProduk($idProduk[$i]) . ' x' . $qtyProduk[$i] . '<br> ' ?></small>
                                                    <?php } ?>
                                                </div>
                                                <div class="user-progress">
                                                    <small class="fw-semibold"><a href="<?= base_url('Admin/transaksi?id=') . $p['kode_transaksi'] ?>">Lihat</a></small>
                                                </div>
                                            </div>
                                        </li>
                                    <?php endforeach; ?>
                                </div>
                            </div>

                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-lg-4 order-1 mb-4">
                <div class="card h-100">
                    <div class="card-header d-flex align-items-center justify-content-between">
                        <h5 class="card-title m-0 me-2">Stok Produk (< 10)</h5>
                    </div>
                    <div class="card-body">
                        <ul class="p-0 m-0">
                            <div class="card overflow-hidden mb-4" style="height: 300px">

                                <div class="card-body" id="example-stok">
                                    <?php foreach ($stok as $s) : ?>
                                        <li class="d-flex mb-4 pb-1">
                                            <div class="avatar flex-shrink-0 me-3">
                                                <span class="avatar-initial rounded bg-label-primary"><i class="bx bx-cart"></i></span>
                                            </div>
                                            <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                                                <div class="me-2">
                                                    <h6 class="mb-0"><?= $s['nama_produk'] ?></h6>
                                                    <small class="text-muted">Sisa Stok: <?= $s['stok'] ?></small>
                                                </div>
                                                <div class="user-progress">
                                                    <small class="fw-semibold"><a href="<?= base_url('Admin/editProduk/') . $s['id_produk'] ?>">Lihat</a></small>
                                                </div>
                                            </div>
                                        </li>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        </ul>
                    </div>
                </div>
            </div>



        </div>

    </div>
    <!-- / Content -->