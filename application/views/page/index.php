<div class="hero__item set-bg mb-3" data-setbg="<?= base_url('assets/') ?>img/hero/kue.png">
    <div class="hero__text">
        <span>katering</span>
        <h2>CVDapur <br />Berkah</h2>
        <p>Kenikmatan Makanan Rumahan</p>
        <a href="#" class="primary-btn">PESAN SEKARANG</a>
    </div>
</div>



<!-- dari sini  -->
</div>
</div>
</div>
</section>
<!-- Hero Section End -->

<!-- Categories Section Begin -->
<section class="categories">
    <div class="container">
        <div class="row">
            <div class="categories__slider owl-carousel">
                <?php foreach ($produkBaru as $n) : ?>
                    <div class="col-lg-3">
                        <div class="categories__item set-bg" data-setbg="<?= base_url('assets/img/produk/') . gambar($n['kode_produk'])  ?>">
                            <h5><a href="<?= base_url('Belanja/detailProduk/') . $n['id_produk'] ?>"><?= $n['nama_produk']; ?></a></h5>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</section>
<!-- Categories Section End -->

<!-- Featured Section Begin -->
<section class="featured spad">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="section-title">
                    <h2>Diskon terbaru guys</h2>
                </div>
                <div class="featured__controls">
                    <ul>
                        <li class="active" data-filter="*">All</li>
                        <?php foreach ($tampilDiskon as $d) : ?>
                            <li data-filter=".<?= str_replace(' ', '', kategori($d['kategori'])); ?>"><?= kategori($d['kategori']); ?></li>
                            <!-- <li data-filter=".fresh-meat">Fresh Meat</li>
                            <li data-filter=".ok">Vegetables</li>
                            <li data-filter=".fastfood">Fastfood</li> -->
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>
        </div>

        <div class="row featured__filter">
            <?php foreach ($dataDiskon as $dD) : ?>
                <div class="col-lg-3 col-md-4 col-sm-6 mix <?= str_replace(' ', '', kategori($dD['kategori'])); ?> ?>">


                    <div class="product__discount__item">
                        <div class="product__discount__item__pic set-bg" data-setbg="<?= base_url('assets/img/produk/') . gambar($dD['kode_produk']) ?>">
                            <div class="product__discount__percent">-<?php echo floor($nilai = ($dD['diskon'] / $dD['harga']) * 100); ?>%</div>
                            <ul class="product__item__pic__hover">
                                <li><a href="<?= base_url('Belanja/detailProduk/') . $dD['id_produk'] ?>"><i class="fa fa-eye"></i></a></li>
                                <li>
                                    <a href="<?= base_url('Belanja/beli/') . $dD['id_produk'] ?>"><i class="fa fa-money"></i></a>
                                </li>
                                <li><a href="#"><i class="fa fa-shopping-cart" data-toggle="modal" data-target="#staticBackdrop<?= $dD['id_produk'] ?>"></i></a></li>
                            </ul>
                        </div>
                        <div class="product__discount__item__text">
                            <span><?= kategori($dD['kategori']); ?></span>
                            <h5><a href="#"><?= $dD['nama_produk']; ?></a></h5>
                            <?php
                            $nilai = ($dD['diskon'] / $dD['harga']) * 100;
                            $jumlah = $dD['harga'] / 100 * $nilai;
                            // echo $jumlah;
                            $hasil = $dD['harga'] - $jumlah;
                            ?>
                            <div class="product__item__price"><?= "Rp " . number_format($hasil, 0, ',', '.'); ?> <span><?= "Rp " . number_format($dD['harga'], 0, ',', '.'); ?></span></div>
                        </div>
                    </div>
                </div>
            <?php endforeach ?>
        </div>
    </div>
</section>
<!-- Featured Section End -->

<!-- Banner Begin -->
<!-- <div class="banner mb-5">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-6">
                <div class="banner__pic">
                    <img src="<?= base_url('assets/') ?>img/banner/banner-1.jpg" alt="">
                </div>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-6">
                <div class="banner__pic">
                    <img src="<?= base_url('assets/') ?>img/banner/banner-2.jpg" alt="">
                </div>
            </div>
        </div>
    </div>
</div> -->
<!-- Banner End -->


<?php $no = 0;
foreach ($dataDiskon as $dis) : $no++ ?>

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
                                                    <p><?= "Rp " . number_format($hasil, 0, ',', '.'); ?><br>Stok: <?= $dis['stok']; ?></p>
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