<!-- <section class="checkout spad"> -->
<div class="container">
    <?= $this->session->flashdata('message'); ?>
    <div class="checkout__form">
        <h4>Keranjang</h4>
        <?php
        if (count($data_keranjang) == 0) { ?>
            <div class="row">
                <div class="col-lg-12">
                    <p class="text-center">Keranjang belum ada!!</p>
                </div>
            </div>
        <?php } else { ?>
            <form method="POST" action="<?= base_url('Keranjang/checkout') ?>">
                <div class="row">
                    <div class="col-lg-7 col-md-6">
                        <div class="row">
                            <?php foreach ($data_keranjang as $d) :
                                $nilai = ($d['diskon'] / $d['harga']) * 100;
                                $jumlah = $d['harga'] / 100 * $nilai;
                                // echo $jumlah;
                                if ($d['diskon'] != 0) {
                                    $hasil = $d['harga'] - $jumlah;
                                } else {
                                    $hasil = $d['harga'];
                                }
                            ?>
                                <div class="col-lg-12 mb-3">
                                    <div class="checkout__order" style="border-radius: 15px;">
                                        <?php $hargaAwal = ($d['harga'] - $d['diskon']) * $d['jumlah'] ?>
                                        <?php $beratAwal = ($d['berat'] * $d['jumlah']) ?>
                                        <input type="text" name="" id="jumlahHarga<?= $d['id_keranjang']; ?>" value="<?= $hargaAwal; ?>" hidden />
                                        <input type="text" name="" id="hargaOK<?= $d['id_keranjang']; ?>" value="<?= $hasil; ?>" hidden />
                                        <input type="text" name="" id="jumlahBerat<?= $d['id_keranjang']; ?>" value="<?= $beratAwal; ?>" hidden />
                                        <input type="hidden" name="" id="idProduk<?= $d['id_keranjang']; ?>" value="<?= $d['id_produk']; ?>" />
                                        <div class="row">
                                            <div class="col-lg-1 col-md-6">
                                                <button class="btn btn-default" type="button" onclick="add_fav(<?= $d['id_keranjang'] ?>)" <?php if ($d['stok'] <= 10 || $d['kategori'] == 25 || $d['kategori'] == 23 || $d['kategori'] == 26 || $d['kategori'] == 27) {
                                                                                                                                                echo "disabled";
                                                                                                                                            } ?>>
                                                    <input type="text" name="" id="ic<?= $d['id_keranjang'] ?>" value="fa fa-square-o fa-lg" hidden />
                                                    <input type="text" name="" id="harga<?= $d['id_keranjang']; ?>" value="<?= $hasil; ?>" hidden />
                                                    <input type="text" name="" id="berat<?= $d['id_keranjang']; ?>" value="<?= $d['berat']; ?>" hidden />
                                                    <a id="icon<?= $d['id_keranjang'] ?>" class="fa fa-square-o fa-lg" style="color:#7fad39"></a>
                                                </button>
                                            </div>
                                            <div class="col-lg-2 col-md-6">
                                                <div class="product__details__pic">
                                                    <img src="<?= base_url('assets/img/produk/') . gambar($d['kode_produk']) ?>" alt="<?= gambar($d['kode_produk']) ?>" />
                                                </div>
                                            </div>
                                            <div class="col-lg-9 col-md-6">
                                                <div class="product__details__text">
                                                    <div class="row">
                                                        <div class="col-lg-8">
                                                            <p><span id="produk"><?= $d['nama_produk']; ?></span><br>
                                                                <span style="font-size:12px">stok : <?php if ($d['stok'] <= 100) {
                                                                                                        echo "Stok kosong";
                                                                                                    } else {
                                                                                                        echo $d['stok'];
                                                                                                    }; ?></span> |<span style="font-size:12px">Berat : </span> <span style="font-size:12px" id="beratItem<?= $d['id_keranjang'] ?>"><?= $d['berat']; ?> </span><span style="font-size:12px" id="beratItem">gr</span>
                                                                <br>
                                                                <?php if ($d['stok'] <= 10) { ?>
                                                                    <span style="font-size:12px; font-style:italic;color: red">Mohon maaf produk ini sedanga kosong!!</span>
                                                                <?php } else if ($d['kategori'] == 25 || $d['kategori'] == 23 || $d['kategori'] == 26 || $d['kategori'] == 27) { ?>
                                                                    <span style="font-size:12px; font-style:italic;color: red">Mohon maaf produk hanya dijual di toko Offline!!</span>
                                                                <?php } ?>
                                                            </p>
                                                        </div>
                                                        <div class="col-lg-4">
                                                            <input type="hidden" name="id_produk" value="<?= $d['id_produk']; ?>" class="form-control">
                                                            <input type="hidden" name="nama_paket" id="namaPaket" class="form-control">
                                                            <?php
                                                            if ($d['diskon'] != 0) { ?>
                                                                <strike style="font-size:12px; color:gray;"><?= "Rp " . number_format($d['harga'], 0, ',', '.'); ?></strike><br>
                                                                <b style="font-size:15px"><?= "Rp " . number_format($hasil, 0, ',', '.'); ?></b>
                                                            <?php  } else { ?>
                                                                <b style="font-size:15px"><?= "Rp " . number_format($d['harga'], 0, ',', '.'); ?></b>

                                                            <?php $hasil = $d['harga'];
                                                            } ?>
                                                            <input name="qty" id="qty<?= $d['id_keranjang'] ?>" onchange="hitQty(<?= $d['id_keranjang'] ?>)" style="width: 100px;" type="number" value="<?= $d['jumlah'] ?>" min="1" max="<?= $d['stok']; ?>" class="form-control">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                    <div class="col-lg-5 col-md-6">
                        <div class="checkout__order">
                            <h4>Ringkasan pesanan</h4>


                            <div class="row">
                                <input type="hidden" name="result_type" id="result-type" value="">
                                <input type="hidden" name="result_data" id="result-data" value="">
                                <input type="text" name="total_harga" id="total_harga" value="" hidden>
                                <input type="text" name="total_berat" id="total_berat" value="" hidden>
                                <input type="text" name="tampungProdukId" id="tampungProdukId" value="" hidden>
                                <input type="text" name="tampungQty" id="tampungQty" value="" hidden>
                                <input type="text" name="tampungHarga" id="tampungHarga" value="" hidden>
                                <input type="text" name="tampungProduk" id="tampungProduk" value="" hidden>
                            </div>


                            <div class="checkout__order__total">Total
                                <div class="col-md-4 pull-right">
                                    <p class="pull-right rupiah" id="jumlah_sum"></p>
                                </div>
                            </div>

                            <button type="submit" class="btn site-btn" id="btnPesan" disabled>Pesan Sekarang</button>
                        </div>
                    </div>
                </div>
            </form>
        <?php } ?>
    </div>
</div>
<!-- </section> -->