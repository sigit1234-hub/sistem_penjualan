<!-- Content wrapper -->
<div class="content-wrapper">
    <!-- Content -->
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-lg-12 mb-4 order-0">
                <?= $this->session->flashdata('message'); ?>

                <div class="card">
                    <!-- Mobile  -->
                    <div class="navbar-nav align-items-xl-center me-3 me-xl-0 d-xl-none">
                        <form class="d-flex m-2" action="" method="POST">
                            <div class="navbar-nav align-items-center">
                                <div class="nav-item d-flex align-items-center">
                                    <input class="form-control me-2" type="text" placeholder="Cari..." aria-label="Search" name="cari" id="cari" autofocus />
                                    <input class="btn btn-outline-primary me-2" name="tombolCari" id="tombolCari" type="submit" value="cari">
                                    <button class="btn btn-primary" type="button" data-bs-toggle="modal" data-bs-target="#largeModal">
                                        <i class="bx bx-plus fs-4 lh-0"></i></button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <nav class="navbar navbar-expand-lg navbar-light bg-light mb-1">
                        <div class="container-fluid">
                            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                                <ul class="navbar-nav me-auto">

                                </ul>
                                <form class="d-flex" action="" method="POST">
                                    <input class="form-control me-2" type="text" placeholder="Cari..." aria-label="Search" name="cari" id="cari" autofocus />
                                    <input class="btn btn-outline-primary me-2" name="tombolCari" id="tombolCari" type="submit" value="cari">
                                    <input class="btn btn-outline-primary me-2" type="button" data-bs-toggle="modal" data-bs-target="#smallModal" value="Cetak Data Transaksi">
                                </form>
                            </div>
                        </div>
                    </nav>
                    <div id="container" id="horizontal-example">
                        <div class="card">
                            <div class="nav-align-top mb-4">
                                <ul class="nav nav-tabs nav-fill" role="tablist">
                                    <li class="nav-item">
                                        <a href="<?= base_url('Admin/transaksi/') ?>" type="button" class="nav-link role=">
                                            <i class="tf-icons bx bx-home"></i> Transaksi Website
                                            <span class="badge rounded-pill badge-center h-px-20 w-px-20 bg-label-danger">3</span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <button type="button" class="nav-link active" role="tab" data-bs-toggle="tab" data-bs-target="#navs-justified-profile" aria-controls="navs-justified-profile" aria-selected="true">
                                            <i class="tf-icons bx bx-user"></i> Transaksi Toko
                                        </button>
                                    </li>
                                </ul>
                                <di class="tab-content">
                                    <div class="tab-pane fade " id="navs-justified-home" role="tabpanel">

                                    </div>
                                    <div class="tab-pane fade show  active" id="navs-justified-profile" role="tabpanel">
                                        <div class="table-responsive text-nowrap">
                                            <?= "Total Data: " . $total_rows; ?>
                                            <table class="table mb-5">
                                                <thead>
                                                    <tr>
                                                        <th>No</th>
                                                        <th>Tanggal</th>
                                                        <th>Kode Transaksi</th>
                                                        <th>Kasir</th>
                                                        <th>Produk</th>
                                                        <th>Total</th>
                                                        <th>Status</th>
                                                        <th>Aksi</th>
                                                    </tr>
                                                </thead>
                                                <tbody class="table-border-bottom-0">
                                                    <?php
                                                    foreach ($dataToko as $w) : ?>
                                                        <tr>
                                                            <td><?= ++$start; ?></td>
                                                            <td><?= tgl($w['tanggal_transaksi']); ?></td>
                                                            <td><?= $w['kode_transaksi']; ?></td>
                                                            <td><?= nama($w['id_user']); ?></td>
                                                            <td>
                                                                <ul class="list-unstyled users-list m-0 avatar-group d-flex align-items-center">
                                                                    <?php
                                                                    $idProduk = explode(",", $w['id_produk']);
                                                                    $qtyProduk = explode(",", $w['jumlah']);
                                                                    for ($i = 0; $i < count($idProduk); $i++) { ?>
                                                                        <li data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="top" class="avatar avatar-xs pull-up" title="<?= namaProduk($idProduk[$i]) . " x" . $qtyProduk[$i]; ?>">
                                                                            <img src="<?= base_url('assets/img/produk/') . gambar(kodeProduk($idProduk[$i])) ?>" alt="Avatar" class="rounded-circle" />
                                                                        </li>
                                                                    <?php } ?>

                                                                </ul>
                                                            </td>
                                                            <td><?= Rupiah($w['total_pembayaran']); ?></td>
                                                            <td><span class="badge bg-label-primary me-1"><?php if ($w['status'] == 200) {
                                                                                                                echo "Dikemas";
                                                                                                            } else if ($w['status'] == 201) {
                                                                                                                echo "Belum Bayar";
                                                                                                            } else if ($w['status'] == 202) {
                                                                                                                echo "Dikirim";
                                                                                                            } else if ($w['status'] == 204) {
                                                                                                                echo "Selesai";
                                                                                                            } else if ($w['status'] == 203) {
                                                                                                                echo "DiBatalkan";
                                                                                                            } else if ($w['status'] == 407) {
                                                                                                                echo "Kadaluwarsa";
                                                                                                            }  ?></span></td>
                                                            <td>
                                                                <a href="<?= base_url('Admin/print/') . $w['kode_transaksi'] ?>" target="_blank" type="button" class="btn p-0 dropdown-toggle hide-arrow">
                                                                    <i class="bx bx-printer"></i>
                                                                </a>
                                                            </td>
                                                        </tr>
                                                    <?php endforeach; ?>
                                                </tbody>
                                            </table>
                                            <?= $this->pagination->create_links(); ?>
                                        </div>
                                    </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal fade" id="smallModal" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-sm" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel2">Cetak Data Transaksi</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form action="<?= base_url('Admin/cetakDataTransaksi') ?>" method="POST">
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-md-12 mb-2">
                                        <label for="emailLarge" class="form-label">Status</label>
                                        <select type="text" id="status" name="status" class="form-control" style="text-align:right">
                                            <option value="0">Semua</option>
                                            <option value="201">Belum Bayar</option>
                                            <option value="200">Dikemas</option>
                                            <option value="202">Dikirim</option>
                                            <option value="204">Selesai</option>
                                            <option value="203">Dibatalkan</option>
                                            <option value="407">Kadaluwarsa</option>

                                        </select>
                                        <?= form_error('kategori', '<small class="text-danger pl-3">', '</small>') ?>
                                    </div>
                                    <div class="col-md-12 mb-2">
                                        <label for="html5-date-input" class="col-md-12 col-form-label">Date</label>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <input class="form-control" type="date" name="tglDari" id="html5-date-input" />
                                                <input class="form-control" type="tex" name="role" value="2" />
                                            </div>
                                            <div class="col-md-6">
                                                <input class="form-control" type="date" name="tglSampai" id="html5-date-input" />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                                    Tutup
                                </button>
                                <button type="submit" class="btn btn-primary">Cetak Data</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>