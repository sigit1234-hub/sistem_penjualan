<!-- Content wrapper -->
<div class="content-wrapper">
    <!-- Content -->
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-lg-12 mb-4 order-0">
                <?= $this->session->flashdata('message'); ?>

                <div class="card">
                    <?= form_open_multipart('Admin/editProd')  ?>

                    <?php foreach ($data_produk as $ed) : ?>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-12 mb-3">
                                    <label for="nameLarge" class="form-label">Nama Produk</label>
                                    <input type="text" id="nama" name="nama" class="form-control" value="<?= $ed['nama_produk']; ?>" />
                                    <input type="hidden" id="id" name="id" class="form-control" value="<?= $ed['id_produk']; ?>" />
                                    <input type="hidden" id="kode" name="kode" class="form-control" value="<?= $ed['kode_produk']; ?>" />
                                    <?= form_error('nama', '<small class="text-danger pl-3">', '</small>') ?>
                                </div>

                                <div class="col-md-4">
                                    <label for="emailLarge" class="form-label">Kategori Produk</label>
                                    <select type="text" id="kategori" name="kategori" class="form-control">
                                        <option selected value="<?= $ed['kategori']; ?>"><?= kategori($ed['kategori']) ?></option>
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
                                    <textarea style="height: 300px;" type="text" id="deskripsi" name="deskripsi" class="form-control" aria-describedby="basic-addon" /><?= $ed['deskripsi']; ?></textarea>

                                    <?= form_error('deskripsi', '<small class="text-danger pl-3">', '</small>') ?>
                                </div>
                            </div>
                            <div class="col-sm-12 mb-3">
                                <div class="form-group">
                                    <div widht="50px" height="50px">
                                        <label for="emailLarge" class="form-label">Gambar Produk</label>
                                        <div class="row" id="rowInput">
                                            <?php
                                            $this->db->where('kode_produk', $ed['kode_produk']);
                                            $gambar = $this->db->get('gambar_produk')->result_array();
                                            foreach ($gambar as $g) : ?>
                                                <input type="hidden" class="gambar_old<?= $g['id_gambar'] ?>" name="gambar_old[]" value="<?= $g['nama_gambar'] ?>" />
                                                <input type="hidden" class="gambarUbah<?= $g['id_gambar'] ?>" name="gambarUbah[]" />
                                                <input type="hidden" class="gambarLama<?= $g['id_gambar'] ?>" name="gambar_id[]" value="1" />
                                                <div class="col-sm-3 mb-3 dataInput<?= $g['id_gambar'] ?>">
                                                    <input type="file" class="dropify" data-show-remove="false" onchange="rubahIsi(<?= $g['id_gambar'] ?>)" id="gambar<?= $g['id_gambar'] ?>" name="gambar[]" data-default-file="<?= base_url('assets/img/produk/' . $g['nama_gambar']) ?>" multiple />
                                                    <button style="border:none" type="button" class="btn btn-primary btn-block mt-2 pull-right" onclick="hapusImg(<?= $g['id_gambar'] ?>)"><i class="bx bx-trash m-1"></i></button>
                                                </div>
                                            <?php endforeach; ?>
                                            <div class=" col-sm-3 mb-3 col_tambah" id="formContainer">
                                                <button type="button" onclick="addInput()" class="btn btn-dark btn-block btnTambah" style="opacity: 1; margin-top: 50%;"><i class="bx bx-plus"></i></button>
                                            </div>
                                            <input type="hidden" name="newGambar2[]" value="inibuattes">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="close" class="btn btn-outline-secondary" data-bs-dismiss="modal">Batal</button>
                                <button type="submit" class="btn btn-primary">Ubah</button>
                            </div>
                        </div>

                    <?php endforeach; ?>
                    </form>

                </div>
            </div>
        </div>