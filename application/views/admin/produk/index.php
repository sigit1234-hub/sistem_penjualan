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
                                    <li class="nav-item">

                                    </li>
                                </ul>
                                <form class="d-flex" action="" method="POST">
                                    <input class="form-control me-2" type="text" placeholder="Cari..." aria-label="Search" name="cari" id="cari" autofocus />
                                    <input class="btn btn-outline-primary me-2" name="tombolCari" id="tombolCari" type="submit" value="cari">
                                    <input class="btn btn-outline-primary me-2" type="button" data-bs-toggle="modal" data-bs-target="#largeModal" value="Tambah Data">
                                    <input class="btn btn-outline-primary me-2" type="button" data-bs-toggle="modal" data-bs-target="#smallModal" value="Cetak Data Produk">
                                </form>
                            </div>
                        </div>
                    </nav>
                    <div id="container">
                        <div class="" style="margin:20px; margin-bottom:30px">
                            <h4>Total Data :
                                <?= $total_rows; ?>
                            </h4>
                            <!-- <div class="row"> -->
                            <div class="table-responsive text-nowrap">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>Info Produk</th>
                                            <th>Harga</th>
                                            <th>Stok</th>
                                            <th>Status</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        <?php
                                        foreach ($data_produk as $d) : ?>
                                            <tr>
                                                <td>
                                                    <div class="col-md">
                                                        <div class="card mb-3">
                                                            <div class="row g-0">
                                                                <div class="col-md-2">
                                                                    <img class="card-img" src="<?= base_url('assets/img/produk/') . gambar($d['kode_produk']) ?>" alt="Card image" />
                                                                </div>
                                                                <div class="col-md-10">
                                                                    <div class="card-body">
                                                                        <h5 class="card-title" contenteditable="true" data-id="<?= $d['id_produk'] ?>" id="input<?= $d['id_produk'] . 'nama_produk' ?>" data-field="nama_produk">
                                                                            <?= $d['nama_produk']; ?>
                                                                        </h5>
                                                                        <div class="row">
                                                                            <div class="col-sm-6">
                                                                                <p class="card-text"><small class="text-muted">Kode :
                                                                                        <?= $d['kode_produk']; ?>
                                                                                    </small></p>
                                                                            </div>
                                                                            <div class="col-sm-6">
                                                                                <p class="card-text"><small class="text-muted">berat :
                                                                                        <?= $d['berat']; ?> gram
                                                                                    </small></p>
                                                                            </div>
                                                                            <div class="col-sm-6">
                                                                                <p class="card-text"><small class="text-muted">kategori :
                                                                                        <?= kategori($d['kategori']) ?>
                                                                                    </small></p>
                                                                            </div>
                                                                            <div class="col-sm-12">
                                                                                <p class="card-text"><small class="text-muted"><?= $d['deskripsi']; ?>
                                                                                    </small></p>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td contenteditable="true" data-id="<?= $d['id_produk'] ?>" id="input<?= $d['id_produk'] . 'harga' ?>" data-field="harga" onkeydown="handleKeyPress(event)">
                                                    <?= $d['harga']; ?>
                                                </td>
                                                <td contenteditable="true" data-id="<?= $d['id_produk'] ?>" id="input<?= $d['id_produk'] . 'stok' ?>" data-field="stok" onkeydown="handleKeyPress(event)">
                                                    <?= $d['stok']; ?>
                                                </td>
                                                <!-- checkbox status  -->
                                                <td class="text-center">
                                                    <div class="form-check form-switch mb-2">
                                                        <input class="form-check-input" type="checkbox" id="flexSwitchCheckChecked" <?php if ($d['is_active'] == 1) {
                                                                                                                                        echo 'checked';
                                                                                                                                    } ?> data-id="<?= $d['id_produk'] ?>" data-status="<?= $d['is_active'] ?>" />
                                                    </div>
                                                </td>
                                                <td>
                                                    <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                                                        <i class="bx bx-dots-vertical-rounded"></i>
                                                    </button>
                                                    <div class="dropdown-menu">
                                                        <a class="dropdown-item" href="<?= base_url('Admin/editProduk/' . $d['id_produk']) ?>"><i class="bx bx-edit-alt me-1"></i> Ubah</a>
                                                        <!-- <a class="dropdown-item" data-bs-toggle="modal" data-bs-target="#largeModal<?= $d['id_produk'] ?>"><i class="bx bx-edit-alt me-1"></i> Ubah</a> -->
                                                        <!-- <a class="dropdown-item" data-bs-toggle="modal" data-bs-target="#largeModal<?= $d['id_produk'] ?>"><i class="bx bx-purchase-tag me-1"></i> Set Diskon</a> -->
                                                        <a class="dropdown-item" href="<?= base_url('Admin/hapusProduk/' . $d['id_produk']) ?>" onclick="return confirm('yakin?')"><i class="bx bx-trash me-1"></i>
                                                            Hapus</a>
                                                    </div>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                            <!-- </div> -->
                        </div>
                    </div>
                    <?= $this->pagination->create_links(); ?>

                </div>
            </div>



        </div>

    </div>
    <!-- / Content -->

    <!-- Modal  tambah-->
    <div class="modal fade" id="largeModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel3">Tambah Produ Baru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <?= form_open_multipart('Admin/produk'); ?>
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label for="nameLarge" class="form-label">Nama Produk</label>
                            <input type="text" id="nama" name="nama" class="form-control" placeholder="Enter Name" />
                            <input type="hidden" id="id_petugas" name="id_petugas" class="form-control" value="<?= $user['id']; ?>" />
                            <?= form_error('nama', '<small class="text-danger pl-3">', '</small>') ?>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="emailLarge" class="form-label">Kategori Produk</label>
                            <select type="text" id="kategori" name="kategori" class="form-control">
                                <option>-pilih kategori-</option>
                                <?php
                                $data_kategori = kategoriProduk();
                                foreach ($data_kategori as $k) : ?>
                                    <option value="<?= $k['id_kategori']; ?>">
                                        <?= $k['nama_kategori']; ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                            <?= form_error('role', '<small class="text-danger pl-3">', '</small>') ?>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="emailLarge" class="form-label">Harga</label>
                                    <div class="input-group">
                                        <input type="number" id="harga" name="harga" class="form-control" placeholder="masukkan harga" aria-describedby="basic-addon13" />
                                        <span class="input-group-text" id="basic-addon13">Rp</span>
                                    </div>
                                    <?= form_error('harga', '<small class="text-danger pl-3">', '</small>') ?>
                                </div>
                                <div class="col-md-6">
                                    <label for="emailLarge" class="form-label">Stok</label>
                                    <input type="number" id="stok" name="stok" class="form-control" placeholder="masukkan stok" />
                                    <?= form_error('stok', '<small class="text-danger pl-3">', '</small>') ?>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="emailLarge" class="form-label">Berat</label>
                            <div class="input-group">
                                <input type="number" id="berat" name="berat" class="form-control" placeholder="masukkan berat" aria-describedby="labelBerat" />
                                <span class="input-group-text" id="labelBerat">gram</span>
                            </div>
                            <?= form_error('berat', '<small class="text-danger pl-3">', '</small>') ?>
                        </div>
                        <div class="col-sm-12 mb-3">
                            <div class="form-group">
                                <div widht="50px" height="50px">
                                    <label for="emailLarge" class="form-label">Pilih gambar</label>
                                    <div class="row">
                                        <div class="col-sm-3">
                                            <input type="file" class="dropify" data-max-file-size="3M" name="gambar[]" />
                                        </div>
                                        <div class="col-sm-3">
                                            <input type="file" class="dropify" data-max-file-size="3M" name="gambar[]" />
                                        </div>
                                        <div class="col-sm-3">
                                            <input type="file" class="dropify" data-max-file-size="3M" name="gambar[]" />
                                        </div>
                                        <div class="col-sm-3">
                                            <input type="file" class="dropify" data-max-file-size="3M" name="gambar[]" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <label for="emailLarge" class="form-label">Deskripsi Produk</label>
                            <div class="input-group">
                                <textarea type="number" id="deskripsi" name="deskripsi" class="form-control" placeholder="masukkan berat" aria-describedby="labelBerat"></textarea>
                            </div>
                            <?= form_error('deskripsi', '<small class="text-danger pl-3">', '</small>') ?>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <a href="<?= base_url('Admin/produk') ?>" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                            Keluar
                        </a>
                        <button type="submit" class="btn btn-primary">Simpan Data</button>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <!-- Modal edit  -->
    <?php foreach ($data_produk as $ed) :
    ?>
        <div class="modal fade" id="largeModal<?= $ed['id_produk'] ?>" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel3">Ubah produk <?= $d['kode_produk'] ?></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <?= form_open_multipart('Admin/editProduk') ?>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label for="nameLarge" class="form-label">Nama Produk</label>
                                <input type="text" id="nama" name="nama" class="form-control" value="<?= $ed['nama_produk']; ?>" />
                                <input type="hidden" id="id" name="id" class="form-control" value="<?= $ed['id_produk']; ?>" />
                                <?= form_error('nama', '<small class="text-danger pl-3">', '</small>') ?>
                            </div>

                            <div class="col-md-4">
                                <label for="emailLarge" class="form-label">Kategori Produk</label>
                                <select type="text" id="kategori" name="kategori" class="form-control">
                                    <option selected value="<?= $ed['kategori'] ?>"><?= kategori($ed['kategori']) ?></option>
                                    <?php
                                    $id_kat = $ed['kategori'];
                                    $data_kategori = kategoriProduk($id_kat);
                                    foreach ($data_kategori as $k) : ?>
                                        <option value="<?= $k['id_kategori']; ?>">
                                            <?= $k['nama_kategori']; ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                                <?= form_error('role', '<small class="text-danger pl-3">', '</small>') ?>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="emailLarge" class="form-label">Harga</label>
                                <div class="input-group">
                                    <input type="number" id="harga" name="harga" class="form-control" placeholder="masukkan harga" aria-describedby="basic-addon13" value="<?= $ed['harga']; ?>" />
                                    <span class="input-group-text" id="basic-addon13">Rp</span>
                                </div>
                                <?= form_error('harga', '<small class="text-danger pl-3">', '</small>') ?>
                            </div>

                            <div class="col-md-4 mb-3">
                                <label for="emailLarge" class="form-label">berat</label>
                                <div class="input-group">
                                    <input type="number" id="berat" name="berat" class="form-control" placeholder="masukkan berat" aria-describedby="labelBerat" value="<?= $ed['berat']; ?>" />
                                    <span class="input-group-text" id="labelBerat">gram</span>
                                </div>
                                <?= form_error('berat', '<small class="text-danger pl-3">', '</small>') ?>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="emailLarge" class="form-label">stok</label>
                                <div class="input-group">
                                    <input type="number" id="stok" name="stok" class="form-control" placeholder="masukkan stok" aria-describedby="labelBerat" value="<?= $ed['stok']; ?>" />
                                </div>
                                <?= form_error('stok', '<small class="text-danger pl-3">', '</small>') ?>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="emailLarge" class="form-label">Diskon</label>
                                <div class="input-group">
                                    <input type="number" id="diskon" name="diskon" class="form-control" placeholder="masukkan diskon" aria-describedby="labelBerat" value="<?= $ed['diskon']; ?>" />
                                </div>
                                <?= form_error('diskon', '<small class="text-danger pl-3">', '</small>') ?>
                            </div>

                            <div class="col-md-12 mb-3">
                                <label for="emailLarge" class="form-label">Deskripsi Produk</label>
                                <textarea style="height: 300px;" type="number" id="deskripsi" name="deskripsi" class="form-control" aria-describedby="basic-addon" /><?= $ed['deskripsi']; ?></textarea>

                                <?= form_error('deskripsi', '<small class="text-danger pl-3">', '</small>') ?>
                            </div>
                        </div>
                        <div class="col-sm-12 mb-3">
                            <div class="form-group">
                                <div widht="50px" height="50px">
                                    <label for="emailLarge" class="form-label">Pilih gambar</label>
                                    <div class="row">
                                        <?php
                                        $this->db->where('kode_produk', $ed['kode_produk']);
                                        $gambar = $this->db->get('gambar_produk')->result_array();
                                        foreach ($gambar as $g) : ?>
                                            <div class="col-sm-3 mb-3">
                                                <div class="overlay-container">
                                                    <div class="row foto">
                                                        <img id="viewGambar<?= $g['id_gambar'] ?>" class="overlay-button" style="width: 200px;height:180px" src="<?= base_url('assets/img/produk/') . $g['nama_gambar'] ?>">
                                                        <div class="overlay">
                                                            <button class="btn btn-gray"><i class="bx bx-pencil"></i></button>
                                                            <button class="btn btn-gray"><i class="bx bx-trash"></i></button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php endforeach; ?>
                                        <div class="col-sm-3 mb-3 tmb-input">
                                            <button type="button" class="btn btn-dark btn-block btnTambah" style="opacity: 1; margin-top: 50%;"><i class="bx bx-plus"></i></button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Keluar</button>
                            <button type="submit" class="btn btn-primary">Ubah</button>
                        </div>
                    </div>
                </div>
                </form>
            </div>
        </div>
        <!-- </div> -->
        <!-- </div> -->
    <?php endforeach; ?>
    <div class="modal fade" id="smallModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel2">Cetak Data Produk</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="<?= base_url('Admin/cetakData') ?>" method="POST">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12 mb-2">
                                <label for="emailLarge" class="form-label">Kategori Produk</label>
                                <select type="text" id="kategori" name="kategori" class="form-control" style="text-align:right">
                                    <option value="0">Semua</option>
                                    <?php

                                    $data_kategori = $this->db->get('kategori')->result_array();
                                    foreach ($data_kategori as $k) : ?>
                                        <option value="<?= $k['id_kategori']; ?>">
                                            <?= $k['nama_kategori']; ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                                <?= form_error('kategori', '<small class="text-danger pl-3">', '</small>') ?>
                            </div>
                            <div class="col-md-12 mb-2">
                                <label for="emailLarge" class="form-label">Stok</label>
                                <select type="text" id="stok" name="stok" class="form-control" style="text-align:right">
                                    <option value="0">Semua</option>
                                    <option value="1">1-10</option>
                                    <option value="2">11-100</option>
                                    <option value="3">>100</option>
                                </select>
                                <?= form_error('stok', '<small class="text-danger pl-3">', '</small>') ?>
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