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
                                        <button type="button" class="nav-link active" role="tab" data-bs-toggle="tab" data-bs-target="#navs-justified-home" aria-controls="navs-justified-home" aria-selected="true">
                                            <i class="tf-icons bx bx-home"></i> Transaksi Website
                                            <span class="badge rounded-pill badge-center h-px-20 w-px-20 bg-label-danger">3</span>
                                        </button>
                                    </li>
                                    <li class="nav-item">
                                        <a href="<?= base_url('Admin/transaksiToko/') ?>" type="button" class="nav-link role=">

                                            <i class="tf-icons bx bx-user"></i> Transaksi Toko
                                        </a>
                                    </li>
                                </ul>
                                <di class="tab-content">
                                    <div class="tab-pane fade show active" id="navs-justified-home" role="tabpanel">
                                        <div class="table-responsive text-nowrap">
                                            <?= "Total Data: " . $total_rows; ?>
                                            <table class="table mb-5">
                                                <thead>
                                                    <tr>
                                                        <th>No</th>
                                                        <th>Tanggal</th>
                                                        <th>Kode Transaksi</th>
                                                        <th>Produk</th>
                                                        <th>Pengiriman</th>
                                                        <th>Total</th>
                                                        <th>Status</th>
                                                        <th>Aksi</th>
                                                    </tr>
                                                </thead>
                                                <tbody class="table-border-bottom-0">
                                                    <?php
                                                    foreach ($dataWebsite as $w) : ?>
                                                        <tr>
                                                            <td><?= ++$start; ?></td>
                                                            <td><?= tgl($w['tanggal_transaksi']); ?></td>
                                                            <td><?= $w['kode_transaksi']; ?></td>
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
                                                            <td><?= strtoupper($w['kurir']) . '-' . preg_replace("/[^a-zA-Z]/", "", $w['paket']) ?></td>
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
                                                                                                            } ?></span></td>
                                                            <td>
                                                                <button type="button" data-bs-toggle="modal" data-bs-target="#largeModal<?= $w['kode_transaksi'] ?>" onclick="klikFokus(<?= $w['id_transaksi'] ?>)" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown" <?php if ($w['status'] == 201 || $w['status'] == 203 || $w['status'] == 407) {
                                                                                                                                                                                                                                                                                                echo 'disabled';
                                                                                                                                                                                                                                                                                            }  ?>>
                                                                    <i class="bx bx-pencil"></i>
                                                                </button>
                                                                <a href="<?= base_url('Admin/printonline/') . $w['kode_transaksi'] ?>" target="_blank" type="button" class="btn p-0 dropdown-toggle hide-arrow">
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
                                    <div class="tab-pane fade" id="navs-justified-profile" role="tabpanel">

                                    </div>
                            </div>



                        </div>


                    </div>



                    <!-- </div> -->


                    <!-- / Content -->

                    <!-- Modal  tambah-->

                    <?php $i = 0;
                    foreach ($dataWebsite as $d) : $i++; ?>
                        <div class="modal fade" id="largeModal<?= $d['kode_transaksi'] ?>" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-lg" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <form action="<?= base_url('Admin/transaksi') ?>" method="POST">
                                        <div class="modal-body">
                                            <div class="row mb-3">
                                                <div class="col-sm-12">
                                                    <div class="card mb-4">
                                                        <div class="card-header d-flex align-items-center justify-content-between">
                                                            <h5 class="mb-0">Kode Transaksi &nbsp;: <?= $d['kode_transaksi'] ?></h5>
                                                            <small class="text-muted float-end"><?= tanggal_jam($d['tanggal_transaksi']); ?></small>
                                                        </div>
                                                        <div class="card-body">
                                                            <div class="row">
                                                                <div class="col-lg-12">
                                                                    <div class="row">
                                                                        <?php
                                                                        $idProduk = explode(",", $d['id_produk']);
                                                                        $qtyProduk = explode(",", $d['jumlah']);
                                                                        for ($i = 0; $i < count($idProduk); $i++) { ?>
                                                                            <div class="col-lg-6">
                                                                                <?php $this->db->where('id_produk', $idProduk[$i]);
                                                                                $produk = $this->db->get('produk')->result_array();
                                                                                foreach ($produk as $p) : ?>
                                                                                    <div class="row">
                                                                                        <div class="col-md-4">
                                                                                            <img class="card-img" src="<?= base_url('assets/img/produk/') . gambar($p['kode_produk']) ?>" alt="Card image" />
                                                                                        </div>
                                                                                        <div class="col-md-8">
                                                                                            <div class="card-body">
                                                                                                <h5 class="card-title" contenteditable="true" data-id="<?= $p['id_produk'] ?>" id="input<?= $p['id_produk'] . 'nama_produk' ?>" data-field="nama_produk">
                                                                                                    <?= $p['nama_produk'] ?> x
                                                                                                </h5>
                                                                                                <div class="row">
                                                                                                    <div class="col-sm-12">
                                                                                                        <p class="card-text"><small class="text-muted">Kode Produk &nbsp;:
                                                                                                                <?= kodeProduk($idProduk[$i]); ?>
                                                                                                            </small></p>
                                                                                                    </div>
                                                                                                    <div class="col-sm-12">
                                                                                                        <p class="card-text"><small class="text-muted">Jumlah &nbsp;:
                                                                                                                <?= $qtyProduk[$i]; ?>
                                                                                                            </small></p>
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                <?php endforeach; ?>
                                                                            </div>
                                                                        <?php  } ?>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-12">


                                                                <form>
                                                                    <div class="row mb-3">
                                                                        <label class="col-sm-4" for="basic-default-name">Nama</label>
                                                                        <label class="col-sm-8" for="basic-default-name">: <?= nama($d['id_user']); ?></label>
                                                                        <input type="text" hidden name="idTransaksi" id="idTransaksi" value="<?= $d['id_transaksi'] ?>">
                                                                        <input type="text" hidden name="kodeTransaksi" id="kodeTransaksi" value="<?= $d['kode_transaksi'] ?>">
                                                                    </div>
                                                                    <div class="row mb-3">
                                                                        <label class="col-sm-4" for="basic-default-name">Tipe Pembayaran</label>
                                                                        <label class="col-sm-8" for="basic-default-name">: <?= $d['tipe_pembayaran']; ?></label>
                                                                    </div>
                                                                    <div class="row mb-3">
                                                                        <label class="col-sm-4" for="basic-default-name">Bank</label>
                                                                        <label class="col-sm-8" for="basic-default-name">: <?= strtoupper($d['bank']); ?></label>
                                                                    </div>
                                                                    <div class="row mb-3">
                                                                        <label class="col-sm-4" for="basic-default-name">Virtual Number</label>
                                                                        <label class="col-sm-8" for="basic-default-name">: <?= strtoupper($d['va_number']); ?></label>
                                                                    </div>
                                                                    <div class="row mb-3">
                                                                        <label class="col-sm-4" for="basic-default-name">Pengiriman</label>
                                                                        <label class="col-sm-8" for="basic-default-name">: <?= strtoupper($d['kurir']) . '-' . preg_replace("/[^a-zA-Z]/", "", $d['paket']) ?></label>
                                                                    </div>
                                                                    <div class="row mb-3">
                                                                        <label class="col-sm-4" for="basic-default-name">Total Harga</label>
                                                                        <label class="col-sm-8" for="basic-default-name">: <?= Rupiah($d['total_pembayaran'] - intval(preg_replace("/[^0-9]/", "", $d['paket']))) ?></label>
                                                                    </div>
                                                                    <div class="row mb-3">
                                                                        <label class="col-sm-4" for="basic-default-name">Diskon</label>
                                                                        <label class="col-sm-8" for="basic-default-name">: <?= Rupiah(intval($d['total_diskon'])); ?></label>
                                                                    </div>
                                                                    <div class="row mb-3">
                                                                        <label class="col-sm-4" for="basic-default-name">Ongkos Kirim</label>
                                                                        <label class="col-sm-8" for="basic-default-name">: <?= Rupiah(preg_replace("/[^0-9]/", "", $d['paket'])); ?></label>
                                                                    </div>
                                                                    <div class="row mb-3">
                                                                        <label class="col-sm-4" for="basic-default-name">Total Pembayaran</label>
                                                                        <label class="col-sm-8" for="basic-default-name">: <?= Rupiah($d['total_pembayaran']); ?></label>
                                                                    </div>
                                                                    <div class="row mb-3">
                                                                        <div class="col-sm-4">Nomor Resi</div>
                                                                        <div class="col-sm-8">
                                                                            <input class="form-control" type="text" id="resi<?= $d['id_transaksi'] ?>" name="resi" placeholder="Masukkan Nomorr Resi...." value="<?= strtoupper($d['resi']) ?>" autofocus required />
                                                                        </div>
                                                                    </div>
                                                                    <script>
                                                                        $(document).ready(function() {
                                                                            $('#largeModal<?= $d['id_transaksi'] ?>"').on('shown.bs.modal', function() {
                                                                                $('#resi').focus();
                                                                            });
                                                                        });
                                                                    </script>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="modal-footer mt-5">
                                                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                                                    Keluar
                                                </button>
                                                <button type="submit" class="btn btn-primary">Simpan</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
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
                                            <div class="col-md-12 mb-3">
                                                <label for="html5-date-input" class="col-md-12 col-form-label">Date</label>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <input class="form-control" type="date" name="tglDari" id="html5-date-input" />
                                                        <input class="form-control" type="tex" name="role" value="1" hidden />
                                                    </div>
                                                    <div class="col-md-6">
                                                        <input class="form-control" type="date" name="tglSampai" id="html5-date-input" />
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-12 mb-4">
                                                <div class="row">
                                                    <label class="col-sm-6 col-form-label" for="basic-default-name">Cetak Semua Data</label>
                                                    <div class="col-sm-4">
                                                        <button type="button" style="width:30px;height:30px" class="btn btn-icon btn-outline-primary">
                                                            <input type="text" name="" id="ic" value="fa fa-square-o fa-lg" hidden />
                                                            <input type="text" name="" id="harga" value="" hidden />
                                                            <span class="tf-icons bx bx-checkbox-checked"></span>
                                                        </button>
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