<!-- Product Details Section Begin -->
<section class="product-details spad">
    <div class="container">
        <div class="row">
            <?php foreach ($detail as $d) : ?>
                <div class="col-lg-6 col-md-6">
                    <div class="product__details__pic">
                        <div class="product__details__pic__item">
                            <img class="product__details__pic__item--large" src="<?= base_url('assets/img/produk/') . gambar($d['kode_produk']) ?>" alt="" />
                        </div>
                        <div class="product__details__pic__slider owl-carousel">
                            <?php foreach (allImg($d['kode_produk']) as $g) : ?>
                                <img data-imgbigurl="<?= base_url('assets/img/produk/') . $g['nama_gambar'] ?>" src="<?= base_url('assets/img/produk/') . $g['nama_gambar'] ?>" alt="" />
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6">
                    <div class="product__details__text">
                        <h3><?= $d['nama_produk']; ?></h3>
                        <div class="product__details__rating">

                            <span>stok : <?= $d['stok']; ?></span>
                        </div>
                        <div class="product__details__price">
                            <?php
                            if ($d['diskon'] != 0) {
                                $nilai = ($d['diskon'] / $d['harga']) * 100;
                                $jumlah = $d['harga'] / 100 * $nilai;
                                // echo $jumlah;
                                $hasil = $d['harga'] - $jumlah;
                            ?>
                                <strike style="font-size:20px; color:gray;"><?= "Rp " . number_format($d['harga'], 0, ',', '.'); ?></strike>
                                <?= "Rp " . number_format($hasil, 0, ',', '.'); ?>
                            <?php  } else { ?>
                                <?= "Rp " . number_format($d['harga'], 0, ',', '.'); ?>

                            <?php } ?>
                        </div>

                        <p>
                            <?= $d['deskripsi']; ?>
                        </p>
                        <a href="<?= base_url('Belanja/beli/') . $d['id_produk'] ?>" class="primary-btn">Beli Sekarang</a>
                        <a data-toggle="modal" data-target="#staticBackdrop<?= $d['id_produk'] ?>" onclick="klikKeranjang()" class="heart-icon " id="Keranjang"><span class="fa fa-cart-plus"></span> Masukkan Keranjang</a>
                    </div>
                </div>
                <!-- <div class="col-lg-12">
                    <div class="product__details__tab">
                        <ul class="nav nav-tabs" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" data-toggle="tab" href="#tabs-1" role="tab" aria-selected="true">Description</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-toggle="tab" href="#tabs-2" role="tab" aria-selected="false">Information</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-toggle="tab" href="#tabs-3" role="tab" aria-selected="false">Reviews <span>(1)</span></a>
                            </li>
                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane active" id="tabs-1" role="tabpanel">
                                <div class="product__details__tab__desc">
                                    <h6>Products Infomation</h6>
                                    <p>
                                        Vestibulum ac diam sit amet quam vehicula elementum sed
                                        sit amet dui. Pellentesque in ipsum id orci porta dapibus.
                                        Proin eget tortor risus. Vivamus suscipit tortor eget
                                        felis porttitor volutpat. Vestibulum ac diam sit amet quam
                                        vehicula elementum sed sit amet dui. Donec rutrum congue
                                        leo eget malesuada. Vivamus suscipit tortor eget felis
                                        porttitor volutpat. Curabitur arcu erat, accumsan id
                                        imperdiet et, porttitor at sem. Praesent sapien massa,
                                        convallis a pellentesque nec, egestas non nisi. Vestibulum
                                        ac diam sit amet quam vehicula elementum sed sit amet dui.
                                        Vestibulum ante ipsum primis in faucibus orci luctus et
                                        ultrices posuere cubilia Curae; Donec velit neque, auctor
                                        sit amet aliquam vel, ullamcorper sit amet ligula. Proin
                                        eget tortor risus.
                                    </p>
                                    <p>
                                        Praesent sapien massa, convallis a pellentesque nec,
                                        egestas non nisi. Lorem ipsum dolor sit amet, consectetur
                                        adipiscing elit. Mauris blandit aliquet elit, eget
                                        tincidunt nibh pulvinar a. Cras ultricies ligula sed magna
                                        dictum porta. Cras ultricies ligula sed magna dictum
                                        porta. Sed porttitor lectus nibh. Mauris blandit aliquet
                                        elit, eget tincidunt nibh pulvinar a. Vestibulum ac diam
                                        sit amet quam vehicula elementum sed sit amet dui. Sed
                                        porttitor lectus nibh. Vestibulum ac diam sit amet quam
                                        vehicula elementum sed sit amet dui. Proin eget tortor
                                        risus.
                                    </p>
                                </div>
                            </div>
                            <div class="tab-pane" id="tabs-2" role="tabpanel">
                                <div class="product__details__tab__desc">
                                    <h6>Products Infomation</h6>
                                    <p>
                                        Vestibulum ac diam sit amet quam vehicula elementum sed
                                        sit amet dui. Pellentesque in ipsum id orci porta dapibus.
                                        Proin eget tortor risus. Vivamus suscipit tortor eget
                                        felis porttitor volutpat. Vestibulum ac diam sit amet quam
                                        vehicula elementum sed sit amet dui. Donec rutrum congue
                                        leo eget malesuada. Vivamus suscipit tortor eget felis
                                        porttitor volutpat. Curabitur arcu erat, accumsan id
                                        imperdiet et, porttitor at sem. Praesent sapien massa,
                                        convallis a pellentesque nec, egestas non nisi. Vestibulum
                                        ac diam sit amet quam vehicula elementum sed sit amet dui.
                                        Vestibulum ante ipsum primis in faucibus orci luctus et
                                        ultrices posuere cubilia Curae; Donec velit neque, auctor
                                        sit amet aliquam vel, ullamcorper sit amet ligula. Proin
                                        eget tortor risus.
                                    </p>
                                    <p>
                                        Praesent sapien massa, convallis a pellentesque nec,
                                        egestas non nisi. Lorem ipsum dolor sit amet, consectetur
                                        adipiscing elit. Mauris blandit aliquet elit, eget
                                        tincidunt nibh pulvinar a. Cras ultricies ligula sed magna
                                        dictum porta. Cras ultricies ligula sed magna dictum
                                        porta. Sed porttitor lectus nibh. Mauris blandit aliquet
                                        elit, eget tincidunt nibh pulvinar a.
                                    </p>
                                </div>
                            </div>
                            <div class="tab-pane" id="tabs-3" role="tabpanel">
                                <div class="product__details__tab__desc">
                                    <h6>Products Infomation</h6>
                                    <p>
                                        Vestibulum ac diam sit amet quam vehicula elementum sed
                                        sit amet dui. Pellentesque in ipsum id orci porta dapibus.
                                        Proin eget tortor risus. Vivamus suscipit tortor eget
                                        felis porttitor volutpat. Vestibulum ac diam sit amet quam
                                        vehicula elementum sed sit amet dui. Donec rutrum congue
                                        leo eget malesuada. Vivamus suscipit tortor eget felis
                                        porttitor volutpat. Curabitur arcu erat, accumsan id
                                        imperdiet et, porttitor at sem. Praesent sapien massa,
                                        convallis a pellentesque nec, egestas non nisi. Vestibulum
                                        ac diam sit amet quam vehicula elementum sed sit amet dui.
                                        Vestibulum ante ipsum primis in faucibus orci luctus et
                                        ultrices posuere cubilia Curae; Donec velit neque, auctor
                                        sit amet aliquam vel, ullamcorper sit amet ligula. Proin
                                        eget tortor risus.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div> -->
            <?php endforeach; ?>
        </div>
    </div>
</section>
<!-- Product Details Section End -->

<!-- Related Product Section Begin -->
<section class="related-product">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="section-title related__product__title">
                    <h2>Produk Serupa</h2>
                </div>
            </div>
        </div>

        <section class="categories">
            <div class="container">
                <div class="row">
                    <div class="categories__slider owl-carousel">
                        <?php foreach ($serupa as $s) : ?>
                            <div class="col-lg-3 col-md-3 col-sm-4">
                                <div class="product__item">
                                    <div class="product__item__pic set-bg" data-setbg="<?= base_url('assets/img/produk/') . gambar($s['kode_produk']) ?>">
                                        <ul class="product__item__pic__hover">
                                            <li>
                                                <a href="<?= base_url('Belanja/detailProduk/') . $s['id_produk'] ?>"><i class="fa fa-eye"></i></a>
                                            </li>
                                            <li>
                                                <a href="<?= base_url('Belanja/beli/') . $s['id_produk'] ?>"><i class="fa fa-money"></i></a>
                                            </li>
                                            <li>
                                                <a data-toggle="modal" data-target="#staticBackdrop<?= $s['id_produk'] ?>"><i class="fa fa-shopping-cart"></i></a>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="product__item__text">
                                        <h6><a href="#"><?= $s['nama_produk']; ?></a></h6>
                                        <h5> <?php
                                                if ($s['diskon'] != 0) {
                                                    $nilai = ($s['diskon'] / $s['harga']) * 100;
                                                    $jumlah = $s['harga'] / 100 * $nilai;
                                                    // echo $jumlah;
                                                    $hasil = $s['harga'] - $jumlah;
                                                ?>
                                                <strike style="font-size:15px; color:gray;"><?= "Rp " . number_format($s['harga'], 0, ',', '.'); ?></strike>
                                                <?= "Rp " . number_format($hasil, 0, ',', '.'); ?>
                                            <?php  } else { ?>
                                                <?= "Rp " . number_format($s['harga'], 0, ',', '.'); ?>

                                            <?php } ?>
                                        </h5>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>

                    </div>
                </div>
            </div>
        </section>

    </div>
</section>
<!-- Related Product Section End -->


<?php $no = 0;
foreach ($serupa as $dis) : $no++ ?>
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
                                                                <input type="text" id="myStok" name="jumlah<?= $dis['id_produk'] ?>" value="1" step="1" min="1" max="<?= $dis['stok'] ?>">
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