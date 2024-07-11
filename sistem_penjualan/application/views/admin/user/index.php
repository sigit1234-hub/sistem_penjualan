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
                    <div class="card mb-4">
                        <h5 class="card-header">Bootstrap Toasts Example With Placement</h5>
                        <div class="card-body">
                            <div class="row gx-3 gy-2 align-items-center">
                                <div class="col-md-3">
                                    <label class="form-label" for="selectTypeOpt">Type</label>
                                    <select id="selectTypeOpt" class="form-select color-dropdown">
                                        <option value="bg-primary" selected>Primary</option>
                                        <option value="bg-secondary">Secondary</option>
                                        <option value="bg-success">Success</option>
                                        <option value="bg-danger">Danger</option>
                                        <option value="bg-warning">Warning</option>
                                        <option value="bg-info">Info</option>
                                        <option value="bg-dark">Dark</option>
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label" for="selectPlacement">Placement</label>
                                    <select class="form-select placement-dropdown" id="selectPlacement">
                                        <option value="top-0 start-0">Top left</option>
                                        <option value="top-0 start-50 translate-middle-x">Top center</option>
                                        <option value="top-0 end-0">Top right</option>
                                        <option value="top-50 start-0 translate-middle-y">Middle left</option>
                                        <option value="top-50 start-50 translate-middle">Middle center</option>
                                        <option value="top-50 end-0 translate-middle-y">Middle right</option>
                                        <option value="bottom-0 start-0">Bottom left</option>
                                        <option value="bottom-0 start-50 translate-middle-x">Bottom center</option>
                                        <option value="bottom-0 end-0">Bottom right</option>
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label" for="showToastPlacement">&nbsp;</label>
                                    <button id="showToastPlacement" class="btn btn-primary d-block">Show Toast</button>
                                    <button onclick="return toast()" class="btn btn-primary d-block"> Toast</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="container">
                        <div class="" style="margin:20px; margin-bottom:30px">
                            <h4>Total Pencarian :
                                <?= $total_rows; ?>
                            </h4>
                            <div class="row">
                                <?php
                                foreach ($data_user as $d) : ?>

                                    <div class="col-md-4">
                                        <div class="card p-3 m-2">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <p>no.
                                                        <?= ++$start; ?>
                                                    </p>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="nav justify-content-end">
                                                        <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                                                            <i class="bx bx-dots-vertical-rounded"></i>
                                                        </button>
                                                        <div class="dropdown-menu">
                                                            <a class="dropdown-item" data-bs-toggle="modal" data-bs-target="#largeModal<?= $d['id'] ?>"><i class="bx bx-edit-alt me-1"></i> Edit</a>
                                                            <a class="dropdown-item" href="<?= base_url('Admin/hapusUser/' . $d['id']) ?>" onclick="return confirm('yakin?')"><i class="bx bx-trash me-1"></i>
                                                                Delete</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <figure class="p-3 mb-0">
                                                <div class="row">
                                                </div>
                                                <div class="row mb-4">
                                                    <div class="col-md-2">
                                                        <div class="avatar">
                                                            <img src="<?= base_url('assets/img/user/') ?><?= $d['foto'] ?>" />
                                                        </div>
                                                    </div>
                                                    <div class="col-md-10">
                                                        <blockquote class="blockquote">
                                                            <p>
                                                                <?= $d['nama']; ?>
                                                            </p>
                                                        </blockquote>
                                                    </div>
                                                </div>
                                                <p class="mb-0 text-muted">
                                                    <?= $d['email'] ?>
                                                </p>
                                                <?= $d['nama']; ?>
                                            </figure>
                                        </div>
                                    </div>
                                <?php
                                endforeach; ?>
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
                    <h5 class="modal-title" id="exampleModalLabel3">Tambah User Baru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <?= form_open_multipart('Admin/user'); ?>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="nameLarge" class="form-label">Nama Lengkap</label>
                            <input type="text" id="nama" name="nama" class="form-control" placeholder="Enter Name" />
                            <?= form_error('nama', '<small class="text-danger pl-3">', '</small>') ?>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="emailLarge" class="form-label">Email</label>
                            <input type="email" id="email" name="email" class="form-control" placeholder="contoh@gmai.com" />
                            <?= form_error('email', '<small class="text-danger pl-3">', '</small>') ?>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="emailLarge" class="form-label">Password</label>
                            <input type="password" id="password" name="password" class="form-control" placeholder="masukkan password..." />
                            <?= form_error('password', '<small class="text-danger pl-3">', '</small>') ?>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="emailLarge" class="form-label">No Telpon</label>
                            <input type="text" id="no_tlp" name="no_tlp" class="form-control" placeholder="0812....." />
                            <?= form_error('no_tlp', '<small class="text-danger pl-3">', '</small>') ?>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="emailLarge" class="form-label">Role</label>
                            <select type="text" id="role_id" name="role_id" class="form-control">
                                <option value="1">Admin</option>
                                <option value="2">User</option>
                            </select>
                            <?= form_error('role', '<small class="text-danger pl-3">', '</small>') ?>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="dobLarge" class="form-label">Alamat</label>
                            <textarea type="text" id="alamat" name="alamat" class="form-control" placeholder="Jl. Raya ....."></textarea>
                            <?= form_error('alamat', '<small class="text-danger pl-3">', '</small>') ?>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="dobLarge" class="form-label">Foto</label>
                            <input type="file" id="foto" name="foto" class="form-control" placeholder="Pilih Foto">
                            <?= form_error('foto', '<small class="text-danger pl-3">', '</small>') ?>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                            Keluar
                        </button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal edit  -->
    <?php foreach ($data_user as $ed) : ?>
        <div class="modal fade" id="largeModal<?= $ed['id'] ?>" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel3">Ubah data user</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <?= form_open_multipart('Admin/editUser') ?>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="nameLarge" class="form-label">Nama Lengkap</label>
                                <input type="text" id="nama" name="nama" class="form-control" value="<?= $ed['nama']; ?>" />
                                <input type="hidden" id="id" name="id" class="form-control" value="<?= $ed['id']; ?>" />
                                <?= form_error('nama', '<small class="text-danger pl-3">', '</small>') ?>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="emailLarge" class="form-label">Email</label>
                                <input type="email" id="email" name="email" class="form-control" value="<?= $ed['email']; ?>" />
                                <?= form_error('email', '<small class="text-danger pl-3">', '</small>') ?>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="emailLarge" class="form-label">Password</label>
                                <input type="password" id="password" name="password" class="form-control" value="<?= $ed['password']; ?>" />
                                <?= form_error('password', '<small class="text-danger pl-3">', '</small>') ?>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="emailLarge" class="form-label">No Telpon</label>
                                <input type="text" id="no_tlp" name="no_tlp" class="form-control" value="<?= $ed['tlp']; ?>" />
                                <?= form_error('no_tlp', '<small class="text-danger pl-3">', '</small>') ?>
                            </div>
                            <div class="col-md-3 mb-3">
                                <label for="emailLarge" class="form-label">Role</label>
                                <select type="text" id="role_id" name="role_id" class="form-control">
                                    <option selected value="<?= $ed['role_id']; ?>">
                                        <?php if ($ed['role_id'] == 1) {
                                            echo 'Admin';
                                        } else {
                                            echo 'User';
                                        } ?>
                                    </option>
                                    <?php if ($ed['role_id'] != 1) { ?>
                                        <option value="1">Admin</option>
                                    <?php } else { ?>
                                        <option value="2">User</option>
                                    <?php } ?>
                                </select>
                                <?= form_error('role', '<small class="text-danger pl-3">', '</small>') ?>
                            </div>
                            <div class="col-md-3 mb-3">
                                <label for="emailLarge" class="form-label">Status</label>
                                <select type="text" id="is_active" name="is_active" class="form-control">
                                    <option selected value="<?= $ed['is_active']; ?>">
                                        <?php if ($ed['is_active'] == 1) {
                                            echo 'Aktif';
                                        } else {
                                            echo 'Tidak';
                                        } ?>
                                    </option>
                                    <?php if ($ed['is_active'] != 1) { ?>
                                        <option value="1">Aktif</option>
                                    <?php } else { ?>
                                        <option value="0">Tidak</option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="dobLarge" class="form-label">Alamat</label>
                                <textarea type="text" id="alamat" name="alamat" class="form-control"><?= $ed['alamat']; ?></textarea>
                                <?= form_error('alamat', '<small class="text-danger pl-3">', '</small>') ?>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="dobLarge" class="form-label">Foto</label>
                                <input type="file" id="foto" name="foto" class="dropify" data-default-file="<?= base_url('assets/img/user/' . $ed['foto']) ?>">
                                <input type="hidden" id="foto_lama" name="foto_lama" class="form-control" value="<?= $ed['foto']; ?>" readonly>
                                <?= form_error('foto', '<small class="text-danger pl-3">', '</small>') ?>
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