<!-- <section class="checkout spad"> -->
<div class="container">
    <?= $this->session->flashdata('message'); ?>
    <div class="checkout__form">
        <h4>Pengiriman</h4>
        <form id="payment-form" method="POST" action="<?= base_url('Keranjang/finish') ?>">
            <div class="row">
                <div class="col-lg-7 col-md-6">
                    <div class="row">
                        <div class="col-lg-12 mb-3">
                            <div class="checkout__order" style="border-radius: 15px;">
                                <div class="col-md-12">
                                    <p>Alamat</p>
                                    <b><?= $user['nama']; ?></b>
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
                            </div>
                        </div>


                        <input type="hidden" name="idKeranjang" id="idKeranjang" value="<?= $inputProduk; ?>">
                        <input type="hidden" name="id_produk" id="id_produk" value="<?= $idProd; ?>">
                        <input type="hidden" name="qty" id="qty" value="<?= $inputQty; ?>">
                        <input type="hidden" name="hargaOk" id="hargaOk" value="<?= $hargaOk; ?>">
                        <input type="hidden" name="id" id="id" value="<?= $user['id']; ?>">
                        <input type="hidden" name="nama_paket" id="namaPaket" class="form-control">
                        <?php for ($i = 0; $i < count($produk); $i++) {

                            $this->db->select('*');
                            $this->db->from('keranjang');
                            $this->db->join('produk', 'produk.id_produk=keranjang.id_produk');
                            $this->db->where('keranjang.id_keranjang', $produk[$i]);
                            $data =  $this->db->get()->result_array();
                            foreach ($data as $d) { ?>
                                <div class="col-lg-12 mb-3">

                                    <?php
                                    $nilai = ($d['diskon'] / $d['harga']) * 100;
                                    $jumlah = $d['harga'] / 100 * $nilai;
                                    // echo $jumlah;
                                    if ($d['diskon'] != 0) {
                                        $hasil = $d['harga'] - $jumlah;
                                    } else {
                                        $hasil = $d['harga'];
                                    } ?>
                                    <div class="checkout__order" style="border-radius: 15px;">
                                        <?php $hargaAwal = ($d['harga'] - $d['diskon']) * $d['jumlah'] ?>
                                        <?php $beratAwal = ($d['berat'] * $d['jumlah']) ?>
                                        <input type="text" name="" id="jumlahHarga<?= $d['id_keranjang']; ?>" value="<?= $hargaAwal; ?>" hidden />
                                        <input type="text" name="" id="jumlahBerat<?= $d['id_keranjang']; ?>" value="<?= $beratAwal; ?>" hidden />

                                        <div class="row">
                                            <div class="col-lg-2 col-md-6">
                                                <div class="product__details__pic">
                                                    <img src="<?= base_url('assets/img/produk/') . gambar($d['kode_produk']) ?>" alt="<?= gambar($d['kode_produk']) ?>" />
                                                </div>
                                            </div>
                                            <div class="col-lg-10 col-md-6">
                                                <div class="product__details__text">
                                                    <div class="row">
                                                        <div class="col-lg-8">
                                                            <p><span id="produk[]" style="font-size:20px"><?= $d['nama_produk']; ?></span><br>
                                                                <!-- <span style="font-size:12px">stok : <?= $d['stok']; ?></span> |<span style="font-size:12px">Berat : </span> <span style="font-size:12px" id="beratItem<?= $d['id_keranjang'] ?>"><?= $d['berat']; ?> </span><span style="font-size:12px" id="beratItem">gr</span> -->
                                                            </p>
                                                        </div>
                                                        <div class="col-lg-4">
                                                            <!-- <input type="hidden" name="id_produk" value="<?= $d['id_produk']; ?>" class="form-control">
                                                            <input type="hidden" name="nama_paket" id="namaPaket" class="form-control"> -->
                                                            <b style="font-size:15px"><?= $qty[$i] ?> x <?= "Rp " . number_format($hasil, 0, ',', '.'); ?></b>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                        <?php }
                            for ($u = 0; $u <= $i; $u++) {
                            }
                        }

                        ?>

                    </div>
                </div>
                <div class="col-lg-5 col-md-6">
                    <div class="checkout__order">
                        <h4>Ringkasan pesanan</h4>
                        <div class="row">
                            <div class="col-lg-12 mb-3">
                                <div class="row">
                                    <label for="kurir" class="col-lg-4">Pengiriman</label>
                                    <select name="kurir" id="kurir" class="form-control col-lg-8" required>
                                        <option>Pilih Pengiriman</option>
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
                            </div>
                            <div class="col-lg-12 mb-3">
                                <div class="row">
                                    <label for="provinsi" class="col-lg-4">Paket</label>
                                    <select name="hargaPaket" id="hargaPaket" class="form-control col-lg-8" required>
                                        <option>Pilih Pengiriman</option>
                                    </select>
                                    <label class="col-lg-4"></label>
                                    <label id="estimasiSampe" class="col-lg-8">Estimasi</label>
                                </div>
                            </div>
                            <!-- <input type="text" name="idProduk" id="idProduk">
                            <input type="text" name="jumlahProduk" id="jumlahProduk"> -->
                        </div>
                        <hr>
                        <div class="row">
                            <input type="hidden" name="result_type" id="result-type" value="">
                            <input type="hidden" name="result_data" id="result-data" value="">
                            <input type="text" name="total_harga" id="total_harga" value="<?= $totalHarga ?>" hidden>
                            <input type="text" name="total_berat" id="total_berat" value="<?= $berat; ?>" hidden>

                            <div class="col-md-8 mb-3">Total Harga (<?= count($qty); ?> Barang)</div>
                            <div class="col-md-4 pull-right">
                                <p class="pull-right rupiah" id="jumlah_sum"><?= "Rp " . number_format($totalHarga, 0, ',', '.'); ?></p>
                            </div>
                            <div class="col-md-8 mb-3">Ongkos kirim</div>
                            <div class="col-md-4 pull-right">
                                <p class="pull-right" id="ongkos_total"></p>
                            </div>
                        </div>

                        <div class="checkout__order__total">Total
                            <input type="text" name="total_harga" id="grandTotal" value="0" hidden>
                            <label for="total_harga" class="pull-right rupiah" id="tampilTotal"></label>
                        </div>

                        <button type="submit" class="btn site-btn" id="pay-button">Pesan Sekarang</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
<!-- </section> -->