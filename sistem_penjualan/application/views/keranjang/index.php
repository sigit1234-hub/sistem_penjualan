<section class="shoping-cart spad">
    <div class="container">
        <form action="">
            <div class="row">
                <div class="col-lg-12">
                    <div class="shoping__cart__table">
                        <table>
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Produk</th>
                                    <th>Harga</th>
                                    <th>Jumlah</th>
                                    <th><input type="checkbox" id="ceklisAll"></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $no = 1;
                                foreach ($data_keranjang as $d) : ?>
                                    <tr>
                                        <td><?= $no; ?></td>
                                        <td class="shoping__cart__item">
                                            <?php
                                            $kode = $this->db->get_where('produk', ['id_produk' => $d['id_produk']])->result_array();
                                            foreach ($kode as $p) :
                                            ?>
                                                <img style="width: 70px; height: 70px;" src="<?= base_url('assets/img/produk/') . gambar($p['kode_produk']) ?>" alt="">
                                                <h5><?= $p['nama_produk']; ?></h5>
                                        </td>
                                        <td class="shoping__cart__quantity">
                                            <div class="checkout__order__subtotal"><?= "Rp " . number_format($p['harga'], 0, ',', '.'); ?></div>
                                        </td>

                                        <td class="shoping__cart__quantity">
                                            <div class="product__details__quantity">
                                                <div class="">
                                                    <div class="pro-qty">
                                                        <!-- <span class="qtybtn" id="decrement" onclick="stepper(this)">-</span> -->
                                                        <input type="text" class="jumlah" id="myStok" value="<?= $d['jumlah'] ?>" step="1" min="1" max="<?= $p['stok'] ?>" data-user="<?php if ($user == null) {
                                                                                                                                                                                            echo "";
                                                                                                                                                                                        } else {
                                                                                                                                                                                            echo $user['id'];
                                                                                                                                                                                        }  ?>" data-produk="<?= $d['id_produk'] ?>">
                                                        <!-- <span class="qtybtn" onclick="stepper(this)" id="increment">+</span> -->
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="shoping__cart__item__close">
                                            <input type="checkbox" class="checkbox" onclick="updateTotal()" value="<?= $d['id_keranjang'] ?>">
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php $no++;
                                endforeach; ?>
                            <?= $this->pagination->create_links(); ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-6">

                </div>
                <div class="col-lg-6">
                    <div class="shoping__checkout">
                        <h5>Total Pesanan</h5>
                        <ul>
                            <li>Produk <span>1</span></li>
                            <?php  ?>

                            <li>Total <span>Rp. 45.000</span></li>
                        </ul>
                        <a href="#" class="primary-btn">Pesan Sekarang</a>
                    </div>
                </div>
            </div>
        </form>
    </div>
</section>