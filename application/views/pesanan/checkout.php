<section class="checkout spad">
    <div class="container">
        <?= $this->session->flashdata('message'); ?>
        <if class="checkout__form">
            <?php foreach ($detail as $s) : ?>
                <?php if ($s['stok'] <= 10) { ?>
                    <div class="alert alert-danger" role="alert">Mohon maaf stok sedang tidak tersedia!!</div>
                    <div class="row">
                        <?php foreach ($detail as $dd) : ?>
                            <div class="col-lg-6 col-md-6">
                                <div class="product__details__pic">
                                    <div class="product__details__pic__item">
                                        <img class="product__details__pic__item--large" src="<?= base_url('assets/img/produk/') . gambar($dd['kode_produk']) ?>" alt="" />
                                    </div>
                                    <div class="product__details__pic__slider owl-carousel">
                                        <?php foreach (allImg($dd['kode_produk']) as $g) : ?>
                                            <img data-imgbigurl="<?= base_url('assets/img/produk/') . $g['nama_gambar'] ?>" src="<?= base_url('assets/img/produk/') . $g['nama_gambar'] ?>" alt="" />
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6">
                                <div class="product__details__text">
                                    <h3><?= $dd['nama_produk']; ?></h3>
                                    <div class="product__details__rating">
                                    </div>
                                    <div class="product__details__price">
                                        <?php
                                        if ($dd['diskon'] != 0) {
                                            $nilai = ($dd['diskon'] / $dd['harga']) * 100;
                                            $jumlah = $dd['harga'] / 100 * $nilai;
                                            // echo $jumlah;
                                            $hasil = $dd['harga'] - $jumlah;
                                        ?>
                                            <strike style="font-size:20px; color:gray;"><?= "Rp " . number_format($dd['harga'], 0, ',', '.'); ?></strike>
                                            <?= "Rp " . number_format($hasil, 0, ',', '.'); ?>
                                        <?php  } else { ?>
                                            <?= "Rp " . number_format($dd['harga'], 0, ',', '.'); ?>

                                        <?php } ?>
                                    </div>

                                    <p>
                                        <?= $dd['deskripsi']; ?>
                                    </p>
                                    <a data-toggle="modal" data-target="#staticBackdrop<?= $dd['id_produk'] ?>" onclick="klikKeranjang()" class="btn site-btn" id="Keranjang"><span class="fa fa-cart-plus"></span> Masukkan Keranjang</a>
                                </div>
                            </div>

                        <?php endforeach; ?>
                    </div>
                <?php } else if ($s['kategori'] == 25 || $s['kategori'] == 23 || $s['kategori'] == 26 || $s['kategori'] == 27) { ?>
                    <div class="alert alert-danger" role="alert">Mohon maaf, Produk hanya dijual pada toko Offline!!</div>
                    <div class="row">
                        <?php foreach ($detail as $dd) : ?>
                            <div class="col-lg-6 col-md-6">
                                <div class="product__details__pic">
                                    <div class="product__details__pic__item">
                                        <img class="product__details__pic__item--large" src="<?= base_url('assets/img/produk/') . gambar($dd['kode_produk']) ?>" alt="" />
                                    </div>
                                    <div class="product__details__pic__slider owl-carousel">
                                        <?php foreach (allImg($dd['kode_produk']) as $g) : ?>
                                            <img data-imgbigurl="<?= base_url('assets/img/produk/') . $g['nama_gambar'] ?>" src="<?= base_url('assets/img/produk/') . $g['nama_gambar'] ?>" alt="" />
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6">
                                <div class="product__details__text">
                                    <h3><?= $dd['nama_produk']; ?></h3>
                                    <div class="product__details__rating">
                                    </div>
                                    <div class="product__details__price">
                                        <?php
                                        if ($dd['diskon'] != 0) {
                                            $nilai = ($dd['diskon'] / $dd['harga']) * 100;
                                            $jumlah = $dd['harga'] / 100 * $nilai;
                                            // echo $jumlah;
                                            $hasil = $dd['harga'] - $jumlah;
                                        ?>
                                            <strike style="font-size:20px; color:gray;"><?= "Rp " . number_format($dd['harga'], 0, ',', '.'); ?></strike>
                                            <?= "Rp " . number_format($hasil, 0, ',', '.'); ?>
                                        <?php  } else { ?>
                                            <?= "Rp " . number_format($dd['harga'], 0, ',', '.'); ?>

                                        <?php } ?>
                                    </div>

                                    <p>
                                        <?= $dd['deskripsi']; ?>
                                    </p>
                                    <a data-toggle="modal" data-target="#staticBackdrop<?= $dd['id_produk'] ?>" onclick="klikKeranjang()" class="btn site-btn" id="Keranjang"><span class="fa fa-cart-plus"></span> Masukkan Keranjang</a>
                                </div>
                            </div>

                        <?php endforeach; ?>
                    </div>
                <?php } else { ?>
                    <h4>Pengiriman</h4>
                    <form id="payment-form" method="post" action="<?= base_url('Belanja/finish') ?>">
                        <div class="row">
                            <div class="col-lg-7 col-md-6">
                                <div class="row">
                                    <?php foreach ($detail as $d) : ?>
                                        <div class="col-lg-12 mb-3">
                                            <div class="checkout__order" style="border-radius: 15px;">
                                                <div class="row">
                                                    <div class="col-lg-2 col-md-6">
                                                        <div class="product__details__pic">
                                                            <img src="<?= base_url('assets/img/produk/') . gambar($d['kode_produk']) ?>" alt="<?= gambar($d['kode_produk']) ?>" />
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-10 col-md-6">
                                                        <div class="product__details__text">
                                                            <p><span id="produk"><?= $d['nama_produk']; ?></span><br>
                                                                <span style="font-size:12px">stok : <?= $d['stok']; ?></span> |<span style="font-size:12px">Berat : </span> <span style="font-size:12px" id="beratItem"><?= $d['berat']; ?> </span><span style="font-size:12px" id="beratItem">gr</span>
                                                                <br>
                                                                <?php
                                                                if ($d['diskon'] != 0) {
                                                                    $nilai = ($d['diskon'] / $d['harga']) * 100;
                                                                    $jumlah = $d['harga'] / 100 * $nilai;
                                                                    // echo $jumlah;
                                                                    $hasil = $d['harga'] - $jumlah;
                                                                ?>
                                                                    <strike style="font-size:12px; color:gray;"><?= "Rp " . number_format($d['harga'], 0, ',', '.'); ?></strike>
                                                                    <b style="font-size:25px"><?= "Rp " . number_format($hasil, 0, ',', '.'); ?></b>
                                                                <?php  } else { ?>
                                                                    <b style="font-size:25px"><?= "Rp " . number_format($d['harga'], 0, ',', '.'); ?></b>

                                                                <?php $hasil = $d['harga'];
                                                                } ?>
                                                            </p>
                                                            <div class="row" style="margin-left:30px">
                                                                <div class="col-lg-6">
                                                                    <input type="text" class="form-control" placeholder="Tulis catatan...">
                                                                    <input type="hidden" name="id_produk" value="<?= $d['id_produk']; ?>" class="form-control">
                                                                    <input type="text" name="nama_paket" id="namaPaket" class="form-control" hidden>
                                                                </div>
                                                                <div class="col-lg-6">
                                                                    <div class="d-flex">
                                                                        <input name="qty" style="width: 100px;" type="number" value="1" min="1" max="<?= $d['stok']; ?>" id="qty" class="form-control" oninput="hitHarga()">
                                                                        <p style="text-align:left; margin-left:10px; margin:10px"> Stok: <?= $d['stok']; ?></p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-lg-12 mb-3">
                                            <div class="checkout__order" style="border-radius: 15px;">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <h4>Alamat</h4>
                                                        <div class="checkout__order__products"><?= $user['nama']; ?></div>
                                                        <ul style="font-family:system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;">
                                                            <?php foreach ($alamat->result_array() as $a) : ?>
                                                                <p>
                                                                    <?=
                                                                    $user['alamat']
                                                                    ?>
                                                                    <?= "Telpone " . $user['tlp']; ?>
                                                                </p>
                                                            <?php endforeach; ?>
                                                        </ul>
                                                        <hr>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <div class="row m-2">
                                                            <div class="col-lg-6 mb-3">
                                                                <label for="provinsi">Pilih Pengiriman</label>
                                                                <select name="kurir" id="kurir" class="form-control" required>
                                                                    <?php if ($a['kecamatan'] == 6922) { ?>
                                                                        <option value="toko">Pengiriman Toko</option>
                                                                    <?php } ?>
                                                                    <option value="jne">JNE</option>
                                                                    <option value="jnt">JNT</option>
                                                                    <option value="tiki">TIKI</option>
                                                                    <option value="pos">POS Indonesia</option>
                                                                    <option value="wahana">Wahana</option>
                                                                    <option value="sicepat">Sicepat</option>
                                                                    <option value="anteraja">Anteraja</option>
                                                                </select>
                                                            </div>
                                                            <div class="col-lg-6 mb-3">
                                                                <label for="provinsi">Paket</label>
                                                                <select name="hargaPaket" id="hargaPaket" class="form-control" required>
                                                                </select>
                                                                <label id="estimasiSampe">Estimasi</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                </div>
                            </div>
                            <div class="col-lg-5 col-md-6">
                                <div class="checkout__order">
                                    <h4>Ringkasan pesanan</h4>
                                    <div class="checkout__order__products">Produk <span>Total</span></div>
                                    <div class="row">
                                        <input type="hidden" name="result_type" id="result-type" value="">
                                        <input type="hidden" name="result_data" id="result-data" value="">
                                        <input type="hidden" name="harga" id="totalHarga" value="<?= $hasil ?>">
                                        <div class="col-md-8"><?= $d['nama_produk']; ?></div>
                                        <div class="col-md-4 pull-right">
                                            <p class="pull-right" id="tampilTotal"></p>
                                        </div>
                                        <div class="col-md-8">Ongkos kirim</div>
                                        <div class="col-md-4 pull-right">
                                            <p class="pull-right" id="ongkosPaket"></p>
                                        </div>
                                    </div>
                                    <div class="checkout__order__total">Total <p class="pull-right" id="grandTotal"></p>
                                    </div>
                                    <button type="submit" class="btn site-btn" id="pay-button">Pesan Sekarang</button>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </form>
                <?php } ?>
            <?php endforeach; ?>
    </div>
    </div>
</section>

<?php $no = 0;
foreach ($detail as $dis) : $no++ ?>
    <div class="modal fade" id="staticBackdrop<?= $dis['id_produk'] ?>" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Keranjang</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <?php if (!$this->session->userdata('id')) { ?>
                        <p>Anda Belum login!!</p>
                        <a href="<?= base_url('Akun') ?>" style="border:none" type="submit" class="primary-btn btn-block text-center inputKeranjang">Login</a>
                    <?php } else { ?>
                        <form action="<?= base_url("Keranjang/inputCart") ?>" method="POST">
                            <input type="hidden" name="idUser" id="idUser" value="<?= $user['id'] ?>">
                            <input type="hidden" name="idProduk" id="idProduk" value="<?= $dis['id_produk'] ?>">
                            <section class="shoping-cart spad">
                                <div class="container">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="row">
                                                <?php
                                                $this->db->limit(1);
                                                $this->db->where('kode_produk', $dis['kode_produk']);
                                                $gProduk = $this->db->order_by('id_gambar', 'ASC')->get('gambar_produk')->result_array();
                                                foreach ($gProduk as $gD) : ?>
                                                    <div class="col-lg-4"> <img src="<?= base_url('assets/img/produk/') . $gD['nama_gambar'] ?>" alt=""></div>
                                                <?php endforeach; ?>
                                                <div class="col-lg-8">
                                                    <h5><?= $dis['nama_produk']; ?></h5>
                                                    <?php
                                                    $nilai = ($dis['diskon'] / $dis['harga']) * 100;
                                                    $jumlah = $dis['harga'] / 100 * $nilai;
                                                    // echo $jumlah;
                                                    $hasil = $dis['harga'] - $jumlah;
                                                    ?>
                                                    <p><?= "Rp " . number_format($hasil, 0, ',', '.'); ?><br></p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-12 align-content-center mt-5">
                                            <div class="row">
                                                <div class="col-lg-2" style="text-align: center;"> Jumlah</div>
                                                <div class="col-lg-10 pull-right" style="text-align: right;">

                                                    <div class="product__details__quantity">
                                                        <div class="">
                                                            <div class="pro-qty">
                                                                <!-- <span class="qtybtn" id="decrement" onclick="stepper(this)">-</span> -->
                                                                <input type="number" id="myStok" name="jumlah" value="1" step="1" min="1" max="<?= $dis['stok'] ?>">
                                                                <!-- <span class="qtybtn" onclick="stepper(this)" id="increment">+</span> -->
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button style="border:none" type="submit" class="primary-btn btn-block text-center inputKeranjang" data-user="<?php if ($user == null) {
                                                                                                                                                        echo "";
                                                                                                                                                    } else {
                                                                                                                                                        echo $user['id'];
                                                                                                                                                    }  ?>" data-produk="<?= $dis['id_produk'] ?>">Masukkan Keranjang</button>
                                </div>
                            </section>
                        </form>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
<?php endforeach; ?>