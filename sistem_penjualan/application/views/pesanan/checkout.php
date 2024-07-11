<section class="checkout spad">
    <div class="container">
        <div class="checkout__form">
            <h4>Pengiriman</h4>
            <form action="#">
                <div class="row">
                    <div class="col-lg-8 col-md-6">
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
                                                    <p><?= $d['nama_produk']; ?><br>
                                                        <span style="font-size:12px">stok : <?= $d['stok']; ?></span> | <span style="font-size:12px">Berat : <?= $d['berat']; ?> gr</span>
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

                                                        <?php } ?>
                                                    </p>
                                                    <div class="row" style="margin-left:30px">
                                                        <div class="col-lg-6">
                                                            <input type="text" class="form-control" placeholder="Tulis catatan...">
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <div class="quantity">
                                                                <div class="pro-qty" style="background-color:white; border-radius: 10px; border-style: solid; color:#7FAD39">
                                                                    <input style="background-color:white;" type="text" value="1" min="1" max="<?= $d['stok'] ?>">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                            <div class="col-lg-12 mb-3">
                                <div class="checkout__order" style="border-radius: 15px;">
                                    <h4>Alamat</h4>
                                    <div class="checkout__order__products"><?= $user['nama']; ?></div>
                                    <ul style="font-family:system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;">
                                        <?php foreach ($alamat->result_array() as $a) : ?>
                                            <p>
                                                <?=
                                                ucwords(strtolower(
                                                    $a['lengkap'] . ", " .
                                                        desa($a['desa']) . " " .
                                                        kecamatan($a['kecamatan']) . " " .
                                                        kota($a['kota']) . " " .
                                                        provinsi($a['provinsi']) . " <br>" .
                                                        $a['patokan'] . ","
                                                ));
                                                ?>
                                                <?= "Telpone " . $user['tlp']; ?>
                                            </p>
                                        <?php endforeach; ?>
                                    </ul>
                                    <hr>
                                    <div class="row m-5">
                                        <div class="col-lg-6 mb-3">
                                            <label for="provinsi">Pilih Kurir</label>
                                            <select name="kurir" id="kurir" class="form-control" required>
                                                <option value="jne">Pengiriman Toko</option>
                                                <option value="jne">JNE</option>
                                                <option value="tiki">TIKI</option>
                                                <option value="pos">POS Indonesia</option>
                                            </select>
                                        </div>
                                        <div class="col-lg-6 mb-3">
                                            <label for="provinsi">Harga</label>
                                            <select name="paket" id="paket" class="form-control" required>
                                                <option value="jne">Rp15.000</option>
                                            </select>
                                        </div>
                                        <div class="col-lg-12">
                                            <input type="submit" class="site-btn btn-block" value="CEK ONGKIR" onclick="cekOngkir()">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- <div class="col-lg-4 col-md-6">
                        <div class="checkout__order">
                            <h4>Your Order</h4>
                            <div class="checkout__order__products">Products <span>Total</span></div>
                            <ul>

                                <li>Fresh Vegetable <span>$151.99</span></li>
                                <li>Organic Bananas <span>$53.99</span></li>
                            </ul>
                            <div class="checkout__order__subtotal">Subtotal <span>$750.99</span></div>
                            <div class="checkout__order__total">Total <span>$750.99</span></div>
                            <div class="checkout__input__checkbox">
                                <label for="acc-or">
                                    Create an account?
                                    <input type="checkbox" id="acc-or">
                                    <span class="checkmark"></span>
                                </label>
                            </div>
                            <p>Lorem ipsum dolor sit amet, consectetur adip elit, sed do eiusmod tempor incididunt
                                ut labore et dolore magna aliqua.</p>
                            <div class="checkout__input__checkbox">
                                <label for="payment">
                                    Check Payment
                                    <input type="checkbox" id="payment">
                                    <span class="checkmark"></span>
                                </label>
                            </div>
                            <div class="checkout__input__checkbox">
                                <label for="paypal">
                                    Paypal
                                    <input type="checkbox" id="paypal">
                                    <span class="checkmark"></span>
                                </label>
                            </div>
                            <button type="submit" class="site-btn">PLACE ORDER</button>
                        </div>
                    </div> -->
                    <div class="col-lg-4 col-md-6">
                        <div class="checkout__order">
                            <h4>Pesanan</h4>
                            <div class="checkout__order__products">Produk <span>Total</span></div>
                            <ul>
                                <li>Kripik Pisang Pedas <span>Rp62.000</span></li>
                                <li>Ongkos Kirim <span>Rp.15.000</span></li>
                            </ul>
                            <div class="checkout__order__total">Total <span>Rp77.000</span></div>

                            <button type="submit" class="site-btn">PESAN SEKARANG</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</section>