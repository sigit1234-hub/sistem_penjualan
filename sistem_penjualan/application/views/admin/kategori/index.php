<!-- Content wrapper -->
<div class="content-wrapper">
    <!-- Content -->
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-lg-12 mb-4 order-0">
                <?= $this->session->flashdata('message'); ?>

                <div class="card">
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
                                    <input class="btn btn-outline-primary me-2" type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#largeModal" value="Tambah Data">
                                </form>
                            </div>
                        </div>
                    </nav>
                    <div id="container">
                        <div class="" style="margin:20px; margin-bottom:30px">
                            <h4>Total Data :
                                <?= $total_rows; ?>
                            </h4>
                            <div class="table-responsive text-nowrap">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Kategori</th>
                                            <th>Status</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php

                                        foreach ($data_user as $d) :
                                        ?>
                                            <tr>
                                                <td>
                                                    <?= ++$start; ?>
                                                </td>
                                                <td>
                                                    <?= $d['nama_kategori']; ?>
                                                </td>
                                                <td>
                                                    <?php if ($d['is_active'] == 1) { ?>
                                                        <span class="badge bg-label-primary me-1">Aktif</span>
                                                    <?php } else { ?>
                                                        <span class="badge bg-label-warning me-1">Tidak</span>
                                                    <?php } ?>
                                                </td>
                                                <td><button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                                                        <i class="bx bx-dots-vertical-rounded"></i>
                                                    </button>
                                                    <div class="dropdown-menu">
                                                        <a class="dropdown-item" data-bs-toggle="modal" data-bs-target="#largeModal<?= $d['id_kategori'] ?>"><i class="bx bx-edit-alt me-1"></i> Edit</a>
                                                        <a class="dropdown-item" href="<?= base_url('Admin/hapusKategori/' . $d['id_kategori']) ?>" onclick="return confirm('yakin?')"><i class="bx bx-trash me-1"></i>
                                                            Delete</a>
                                                    </div>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
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
                    <h5 class="modal-title" id="exampleModalLabel3">Tambah Kategori Baru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="<?= base_url('Admin/inputKategori') ?>" method="POST">
                        <div class="table-responsive">
                            <table class="table table-borderless" id="LoopTable">
                                <thead>
                                    <tr>
                                        <th class="text-center" width="5%">#</th>
                                        <th width="80%">Nama Kategori</th>
                                        <th><button class="btn btn-sm btn-primary" id="TambahAnggota"><i class="bx bx-plus"></i></button></th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                            <div class="modal-footer m-10">
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
    </div>

    <!-- Modal edit -->
    <?php foreach ($data_user as $ed) : ?>
        <div class="modal fade" id="largeModal<?= $ed['id_kategori'] ?>" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel3">Ubah data user</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="<?= base_url('Admin/editKategori') ?>" method="POST">
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="nameLarge" class="form-label">Nama Kategori</label>
                                    <input type="text" id="nama" name="nama" class="form-control" value="<?= $ed['nama_kategori']; ?>" />
                                    <input type="hidden" id="id" name="id" class="form-control" value="<?= $ed['id_kategori']; ?>" />
                                    <?= form_error('nama', '<small class="text-danger pl-3">', '</small>') ?>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="emailLarge" class="form-label">Email</label>
                                    <select type="text" id="is_active" name="is_active" class="form-control">
                                        <option selected value="<?= $ed['is_active']; ?>">
                                            <?php if ($ed['is_active'] == 1) {
                                                echo 'Aktif';
                                            } else {
                                                echo 'Tidak';
                                            } ?>
                                        </option>
                                        <?php if ($ed['is_active'] != 0) { ?>
                                            <option value="0">Tidak</option>\
                                        <?php } else { ?>
                                            <option value="1">Aktif</option>\
                                        <?php } ?>
                                    </select>
                                    <?= form_error('is_active', '<small class="text-danger pl-3">', '</small>') ?>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                                    Keluar
                                </button>
                                <button type="submit" class="btn btn-primary">Ubah</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    <?php endforeach; ?>