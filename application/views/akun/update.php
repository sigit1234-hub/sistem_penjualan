<section class="shoping-cart snap">
    <div class="container">

        <?= $this->session->flashdata('message'); ?>
        <div class="row">
            <div class="col-lg-3 col-md-5">
                <div class="blog__sidebar">
                    <div class="blog__sidebar__item">
                        <h4>Profile Saya</h4>
                        <ul class="nav nav-tabs flex-column mt-5" role="tablist">
                            <li class="nav-item">
                                <button type="button" class="nav-link  btn-block text-left <?php if ($user['nama'] == '' || $user['email'] == '' || $user['tlp'] == '') {
                                                                                                echo 'btn-danger active';
                                                                                            } ?>" role="tab" data-bs-toggle="tab" data-bs-target="#navs-home" aria-controls="navs-home" aria-selected="true">
                                    <i class="tf-icons bx bx-home"></i> Profile
                                </button>
                            </li>
                            <li class="nav-item">
                                <button type="button" class="nav-link btn-block text-left <?php if ($alamat->num_rows() < 1) {
                                                                                                echo 'btn-danger';
                                                                                            } ?>" role="tab" data-bs-toggle="tab" data-bs-target="#navs-profile" aria-controls="navs-profile" aria-selected="false">
                                    <i class="tf-icons bx bx-user"></i> Alamat
                                </button>
                            </li>
                            <li class="nav-item">
                                <button type="button" class="nav-link btn-block text-left" role="tab" data-bs-toggle="tab" data-bs-target="#navs-messages" aria-controls="navs-messages" aria-selected="false">
                                    <i class="tf-icons bx bx-message-square"></i> Password
                                </button>
                            </li>
                            <li class="nav-item">
                                <button type="button" class="nav-link btn-block text-left" role="tab" data-bs-toggle="tab" aria-selected="false">
                                    <a href="<?= base_url('Akun/delete/') . $user['id'] ?>"><i class="tf-icons bx bx-message-square"></i> Hapus Akun</a>
                                </button>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-lg-9">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="blog__details__author">
                            <div class="blog__details__author__pic">
                                <img src="<?= base_url('assets/img/user/') . $user['foto'] ?>" alt="">
                            </div>
                            <div class="blog__details__author__text">
                                <h6><?= $user['nama']; ?></h6>
                                <span><?= $user['tlp']; ?></span>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="tab-content mt-4">
                            <?php foreach ($dataUser as $d) : ?>
                                <div class="tab-pane fade show  active" id="navs-home" role="tabpanel">
                                    <?= form_open_multipart('Akun/update'); ?>

                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="nameLarge" class="form-label">Nama Lengkap</label>
                                            <input type="text" id="nama" name="nama" class="form-control" value="<?= $d['nama'] ?>" required />
                                            <input type="hidden" id="id" name="id" class="form-control" value="<?= $d['id'] ?>" />
                                            <input type="hidden" id="kode" name="kode" class="form-control" value="1" />
                                            <?= form_error('nama', '<small class="text-danger pl-3">', '</small>') ?>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="emailLarge" class="form-label">Email</label>
                                            <input type="email" id="email" name="email" class="form-control" value="<?= $d['email']; ?>" required />
                                            <?= form_error('email', '<small class="text-danger pl-3">', '</small>') ?>
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label for="emailLarge" class="form-label">No Telpon</label>
                                            <input type="number" id="no_tlp" name="no_tlp" class="form-control" value="<?= $d['tlp']; ?>" required />
                                            <?= form_error('no_tlp', '<small class="text-danger pl-3">', '</small>') ?>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="dobLarge" class="form-label">Foto</label>
                                            <input type="file" class="form-control" name="foto" value="<?= $d['foto']; ?>" />
                                            <input type="hidden" class="form-control" name="fotolama" value="<?= $d['foto']; ?>" required />
                                            <?= form_error('foto', '<small class="text-danger pl-3">', '</small>') ?>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="submit" class="btn btn-primary pull-right">Simpan</button>
                                        </div>
                                    </div>
                                    </form>
                                </div>
                                <div class="tab-pane fade  active" id="navs-profile" role="tabpanel">


                                    <div class="row">
                                        <div class="col-xl-12">
                                            <div class="nav-align-top mb-4">
                                                <ul class="nav nav-pills mb-3" role="tablist">
                                                    <li class="nav-item">
                                                        <button type="button" class="nav-link active btn" role="tab" data-bs-toggle="tab" data-bs-target="#navs-pills-top-home" aria-controls="navs-pills-top-home" aria-selected="true">
                                                            Alamat
                                                        </button>
                                                    </li>
                                                    <li class="nav-item">
                                                        <button type="button" class="nav-link btn" role="tab" data-bs-toggle="tab" data-bs-target="#navs-pills-top-profile" aria-controls="navs-pills-top-profile" aria-selected="false">
                                                            Ubah
                                                        </button>
                                                    </li>
                                                </ul>
                                                <div class="tab-content">
                                                    <div class="tab-pane fade show active" id="navs-pills-top-home" role="tabpanel">
                                                        <?php foreach ($alamat->result_array() as $a) :
                                                            if ($a['lengkap'] == "") {
                                                                echo "<p>Alamat belum tersedia, silahkan klik tombol ubah</p>";
                                                            } else { ?>

                                                                <p>
                                                                    <?=
                                                                    ucwords(strtolower(
                                                                        $a['lengkap'] . ", " .
                                                                            $a['desa'] . " " .
                                                                            kecamatan($a['kecamatan']) . " " .
                                                                            kota($a['kota']) . " " .
                                                                            provinsi($a['provinsi']) . " <br>" .
                                                                            $a['patokan'] . ","
                                                                    ));
                                                                    ?>
                                                                    <?= "Telpone " . $user['tlp']; ?>
                                                                </p>
                                                        <?php }
                                                        endforeach; ?>
                                                    </div>
                                                    <div class="tab-pane fade" id="navs-pills-top-profile" role="tabpanel">
                                                        <?= form_open_multipart('Akun/update'); ?>
                                                        <div class="row">
                                                            <div class="col-lg-6 mb-3">
                                                                <label for="provinsi">Provinsi</label>
                                                                <select name="provinsi" id="provinsi" class="form-control" required>
                                                                    <option>Pilih Provinsi</option>
                                                                </select>
                                                            </div>
                                                            <div class="col-lg-6 mb-3">
                                                                <label for="provinsi">Kota</label>
                                                                <select name="kota" id="kota" class="form-control" required>
                                                                    <option>Pilih Kota/Kabupaten</option>
                                                                </select>
                                                            </div>
                                                            <div class="col-lg-6 mb-3">
                                                                <label for="provinsi">Kecamatan</label>
                                                                <select name="kecamatan" id="kecamatan" class="form-control" required>
                                                                    <option value="">Pilih</option>
                                                                </select>
                                                            </div>
                                                            <div class="col-lg-6 mb-3">
                                                                <label for="provinsi">Desa</label>
                                                                <input name="desa" id="desa" class="form-control" required />
                                                            </div>

                                                            <div class="col-lg-12 mb-3">
                                                                <label for="lengkap">Jalan</label>
                                                                <input type="hidden" id="id" name="id" class="form-control" value="<?= $d['id'] ?>" />
                                                                <input type="hidden" id="kode" name="kode" class="form-control" value="2" />
                                                                <input type="text" class="form-control" name="lengkap" id="lengkap" placeholder="Jl / RT/RW /No .rumah" required>
                                                            </div>
                                                            <div class="col-lg-12 mb-3">
                                                                <label for="lengkap">Patokan</label>
                                                                <input type="text" class="form-control" name="patokan" id="patokan" placeholder="Depan toko, pagar hitam" required>
                                                            </div>
                                                            <div class="col-lg-12  mt-5">
                                                                <div class="modal-footer">
                                                                    <button type="submit" class="btn btn-primary pull-right">Simpan</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                                <div class="tab-pane fade" id="navs-messages" role="tabpanel">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <?= form_open_multipart('Akun/update'); ?>
                                            <div class="col-lg-12 mb-3">
                                                <label for="provinsi">Password Sekarang</label>
                                                <input type="hidden" id="id" name="id" class="form-control" value="<?= $d['id'] ?>" />
                                                <input type="hidden" id="kode" name="kode" class="form-control" value="3" />
                                                <input type="password" class="form-control" name="password" id="password">
                                            </div>
                                            <div class="col-lg-12 mb-3">
                                                <label for="provinsi">Pasword Baru</label>
                                                <input type="password" class="form-control" name="new" id="new">
                                            </div>
                                            <div class="col-lg-12 mb-3">
                                                <label for="provinsi">Ulangi Password</label>
                                                <input type="password" class="form-control" name="re" id="re">
                                            </div>
                                            <div class="col-lg-12  mt-5">
                                                <div class="modal-footer">
                                                    <button type="submit" class="btn btn-primary pull-right">Simpan</button>
                                                </div>
                                            </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>