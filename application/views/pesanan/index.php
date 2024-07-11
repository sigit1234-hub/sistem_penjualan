<!-- <section class="shoping-cart spad"> -->
<div class="container">
    <?= $this->session->flashdata('message'); ?>
    <div class="checkout__form">
        <h4><?= $halaman; ?></h4>
        <?php
        if (count($data_pesanan) == 0) { ?>
            <div class="row">
                <div class="col-lg-12">

                    <p class="text-center">Pesanan belum ada!!</p>
                </div>
            </div>
        <?php } else { ?>
            <div class="row">
                <?php foreach ($data_pesanan as $d) : ?>
                    <div class="col-lg-12">
                        <div class="container-xxl flex-grow-1 container-p-y">
                            <div class="row">
                                <div class="col-lg-12 mb-4 order-0">
                                    <div class="card" style="box-shadow: 1px 3px 3px 3px #898989">
                                        <div class="row" style="height: fit-content;">
                                            <div class="col-lg-5">
                                                <div class="card-body">
                                                    <div class="row">
                                                        <div class="col-lg-3">
                                                            <img class="card-img" src="<?= base_url('assets/img/produk/' . gambar($d['kode_produk'])) ?>" alt="<?= $d['kode_produk'] ?>" />
                                                        </div>
                                                        <div class="col-lg-9">
                                                            <h5 class="card-title text-primary"><?= $d['nama_produk']; ?></h5>
                                                            <?php
                                                            $getObject =  explode(",", $d['harga']);
                                                            $getQty =  explode(",", $d['jumlah']);
                                                            $idP = explode(",", $d['t_idProduk']);
                                                            for ($i = 0; $i < count($getObject); $i++) {
                                                                $harga =  $getObject[0];
                                                                $jml =  $getQty[0];
                                                            }

                                                            ?>
                                                            <p><?= $jml . "x " . "Rp " . number_format($harga, 0, ',', '.'); ?></p>
                                                            <p><?php if (count($idP) > 1) {
                                                                    echo "+" . (count($idP) - 1) . " produk lainnya";
                                                                } ?></p>
                                                            <p>Tanggal pesanan : <?= tanggal_jam($d['tanggal_transaksi']) ?></p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-3">
                                                <div class="card-body">
                                                    <p class="">
                                                        <span class="fw-bold">Nomor Pesanan</span><br><?= $d['kode_transaksi']; ?>
                                                    </p>
                                                    <p><span class="fw-bold">Status</span><br><?php if ($d['status'] == 201) {
                                                                                                    echo "Menunggun Pembayaran";
                                                                                                } else if ($d['status'] == 200) {
                                                                                                    echo "Pembayaran Berhasil";
                                                                                                } else if ($d['status'] == 202) {
                                                                                                    echo "Pesanan dikirim";
                                                                                                } else if ($d['status'] == 204) {
                                                                                                    echo "Pesanan Selesai";
                                                                                                } else if ($d['status'] == 203) {
                                                                                                    echo "Pesanan dibatalkan";
                                                                                                } else {
                                                                                                    "Pesanan Kadaluwarsa";
                                                                                                } ?></p>
                                                </div>
                                            </div>
                                            <div class="col-lg-4 mt-5">
                                                <span>Total Belanja : <?= "Rp " . number_format($d['total_pembayaran'], 0, ',', '.'); ?></span>
                                            </div>
                                        </div>
                                        <div class="container-xxl d-flex  justify-content-between m-2">
                                            <div class="">
                                            </div>
                                            <div>
                                                <a href="<?= base_url('Belanja/beli/') . $d['id_produk'] ?>" style="border-radius: 10px;" class="site-btn">Beli lagi</a>
                                                <button href="" style="border-radius: 10px;" data-bs-toggle="modal" data-bs-target="#largeModal<?= $d['kode_transaksi'] ?>" class="site-btn">Lihat detail transaksi</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
            <?= $this->pagination->create_links(); ?>
        <?php } ?>
    </div>
</div>
<!-- </section> -->


<?php
foreach ($data_pesanan as $ed) : ?>
    <div class="modal fade" id="largeModal<?= $ed['kode_transaksi'] ?>" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel3">Detail Transaksi <?= $ed['kode_transaksi'] ?></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <div class="checkout__form">
                        <div class="row">
                            <div class="col-lg-12 col-md-6">
                                <div class="row">
                                    <div class="col-lg-12 mb-2">
                                        <div class="checkout__order" style="border-radius: 15px;">
                                            <div class="row">
                                                <div class="col-lg-12 col-md-12">
                                                    <div class="accordion" id="accordionExample">
                                                        <div><?php if ($ed['status'] == 201) {
                                                                    echo "Menunggun Pembayaran";
                                                                } else if ($ed['status'] == 200) {
                                                                    echo "Pembayaran Berhasil";
                                                                } else if ($ed['status'] == 202) {
                                                                    echo "Pesanan dikirim";
                                                                } else if ($ed['status'] == 204) {
                                                                    echo "Pesanan Selesai";
                                                                } else if ($ed['status'] == 203) {
                                                                    echo "Pesanan dibatalkan";
                                                                } else {
                                                                    "Pesanan Kadaluwarsa";
                                                                } ?> <p class="pull-right" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">Lihat details <i class="fa fa-arrow-down"></i></p>
                                                            <div id="collapseOne" class="collapse" aria-labelledby="headingOne" data-parent="#accordionExample">
                                                                <div class="card-body m-2" style="border:1px solid #898989; border-radius:20px">
                                                                    <div class="container">
                                                                        <div class="col-lg-12">
                                                                            <?php
                                                                            $this->db->where('kode_transaksi', $ed['kode_transaksi']);
                                                                            $sql = $this->db->order_by('id', 'DESC')->get('histori')->result_array();
                                                                            foreach ($sql as $h) :
                                                                            ?>
                                                                                <div class="col-lg-12">
                                                                                    <table>
                                                                                        <tr>
                                                                                            <td width="60%"><?php if ($h['status'] == 201) {
                                                                                                                echo "Menunggun Pembayaran";
                                                                                                            } else if ($h['status'] == 200) {
                                                                                                                echo "Pembayaran Berhasil";
                                                                                                            } else if ($h['status'] == 202) {
                                                                                                                echo "Pesanan dikirim";
                                                                                                            } else if ($h['status'] == 204) {
                                                                                                                echo "Pesanan Selesai";
                                                                                                            } else if ($h['status'] == 203) {
                                                                                                                echo "Pesanan dibatalkan";
                                                                                                            } else {
                                                                                                                "Pesanan Kadaluwarsa";
                                                                                                            } ?></td>
                                                                                            <td width="5%"><?php
                                                                                                            $this->db->select_max('id');
                                                                                                            $this->db->where('kode_transaksi', $ed['kode_transaksi']);
                                                                                                            $max = $this->db->get('histori')->row_array();
                                                                                                            if ($h['id'] == $max['id']) {
                                                                                                                echo '<i class="fa fa-circle"></i>';
                                                                                                            } else {
                                                                                                                echo '<i class="fa fa-circle-o"></i>';
                                                                                                            }
                                                                                                            ?></td>
                                                                                            <td>

                                                                                                <?php
                                                                                                $inputTime = $h['tanggal'];
                                                                                                $currentTime = tanggal(); // Waktu sekarang
                                                                                                $inputTimestamp = strtotime($inputTime);
                                                                                                $currentTimestamp = strtotime($currentTime);
                                                                                                $timeDifference = $currentTimestamp - $inputTimestamp;

                                                                                                // Menghitung jam, menit, dan detik dari selisih waktu
                                                                                                $hours = floor($timeDifference / 3600);
                                                                                                $minutes = floor(($timeDifference % 3600) / 60);
                                                                                                $seconds = $timeDifference % 60;
                                                                                                if ($hours > 24) {
                                                                                                    $tampil = $h['tanggal'];
                                                                                                } elseif ($hours >= 1) {
                                                                                                    $tampil = $hours . " Jam yang lalu";
                                                                                                } elseif ($minutes < 59 && $minutes > 1) {
                                                                                                    $tampil = $minutes . " menit yang lalu";
                                                                                                } elseif ($minutes == 0) {
                                                                                                    $tampil = $seconds . " detik yang lalu";
                                                                                                } else {
                                                                                                    $tampil = $hours . " jam yang lalu";
                                                                                                }
                                                                                                ?>
                                                                                                <span> <i class="pull-right"></i><?= $tampil;  ?></span>
                                                                                                <!-- <span> <i class="fa fa-clock"></i><?= $hours;  ?></span>
                                                                                                            <span> <i class="fa fa-clock"></i><?= $minutes;  ?></span>
                                                                                                                <span> <i class="fa fa-clock"></i><?= $seconds;  ?></span> -->


                                                                                            </td>
                                                                                        </tr>
                                                                                    </table>

                                                                                </div>
                                                                            <?php endforeach; ?>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <hr>
                                                <div class="col-lg-12">
                                                    <div>No.Invoice <p class="pull-right"><a style="color: #7fad39;" target="_blank" href="<?= base_url('Pesanan/inv/') . $ed['kode_transaksi'] ?>">Inv/<?= $ed['kode_transaksi'] ?></a></p>
                                                    </div>
                                                </div>
                                                <div class="col-lg-12">
                                                    <div>Tanggal Pembelian <p class="pull-right"><?= tanggal_jam($ed['tanggal_transaksi']) ?></p>
                                                    </div>
                                                </div>
                                                <div class="col-lg-12 mt-4">
                                                    <div class="row">
                                                        <div class="col-lg-6 right">
                                                            <?php if ($ed['status'] == 202) {
                                                                echo "Pesanan dikirim";
                                                            } else if ($ed['status'] == 204) {
                                                                echo "Pesanan Sampai";
                                                            } else {
                                                                echo "";
                                                            } ?>
                                                        </div>
                                                        <div class="col-lg-6 ">
                                                            <?php if ($ed['status'] == 202) { ?>
                                                                <a href="<?= base_url('Pesanan/konfirmasi/') . $ed['kode_transaksi'] ?>" style="border-radius: 10px;" class="site-btn btn-outline-primary pull-right">konfirmasi</a>
                                                            <?php } else { ?>
                                                                <a style="border-radius: 10px;" class="site-btn btn-danger pull-right">konfirmasi</a>
                                                            <?php } ?>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-lg-12 mb-2">
                                        <div class="checkout__order" style="border-radius: 15px;">
                                            <div class="row">
                                                <?php
                                                $idProduk = explode(",", $ed['t_idProduk']);
                                                $qtyProduk = explode(",", $ed['jumlah']);
                                                $price = explode(",", $ed['harga_produk']);
                                                for ($i = 0; $i < count($idProduk); $i++) {
                                                    $this->db->where('id_produk', $idProduk[$i]);
                                                    $produk = $this->db->get('produk')->result_array();
                                                    foreach ($produk as $looping) :
                                                ?>
                                                        <div class="col-lg-6">
                                                            <div class="row">
                                                                <div class="col-md-4">
                                                                    <img class="card-img" src="<?= base_url('assets/img/produk/' . gambar($looping['kode_produk'])) ?>" alt="<?= $looping['kode_produk'] ?>" />
                                                                </div>
                                                                <div class="col-md-8">
                                                                    <p><span id="produk"><?= $ed['nama_produk']; ?></span><br>
                                                                        <span style="font-size:12px"><?= $qtyProduk[$i]; ?>X </span><span style="font-size:12px"></span> <span style="font-size:12px"><?= Rupiah($price[$i]); ?></span>
                                                                        <br>
                                                                    </p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                <?php endforeach;
                                                } ?>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-lg-12 mb-3">
                                        <div class="checkout__order" style="border-radius: 15px;">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <p>Info Pengiriman</p>
                                                    <table>
                                                        <tr>
                                                            <td width="30%">Kurir</td>
                                                            <td width="5%"> : </td>
                                                            <td><?= $ed['kurir']; ?></td>
                                                        </tr>
                                                        <tr>
                                                            <td width="30%">Nomor Resi</td>
                                                            <td width="5%"> : </td>
                                                            <td><?= $ed['resi']; ?></td>
                                                        </tr>
                                                        <tr>
                                                            <td width="30%">Alamat</td>
                                                            <td width="5%"> : </td>
                                                            <td>
                                                                <div class="checkout__order__products"><?= $user['nama']; ?></div>
                                                                <ul>
                                                                    <?php foreach ($alamat->result_array() as $a) : ?>
                                                                        <p>
                                                                            <?=
                                                                            $user['alamat']
                                                                            ?>
                                                                            <?= "Telpone " . $user['tlp']; ?>
                                                                        </p>
                                                                    <?php endforeach; ?>
                                                                </ul>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                    <hr>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12 col-md-12">
                                <div class="checkout__order">
                                    <p>Ringkasan Pemabayaran</p>
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div>Metode Pembayaran <p class="pull-right"><?= $ed['tipe_pembayaran']  . "<br>" . $ed['bank']; ?></p>
                                            </div>
                                        </div>
                                        <div class="col-lg-12">
                                            <div>Total Harga
                                                <?php
                                                $qty = explode(",", $ed['jumlah']);
                                                $price = explode(",", $ed['harga_produk']);
                                                $hasil = 0;
                                                for ($i = 0; $i < count($idProduk); $i++) {
                                                    $hasil +=  $qty[$i] * $price[$i];
                                                } ?>
                                                <p class="pull-right"><?= Rupiah($hasil); ?></p>
                                            </div>
                                        </div>
                                        <div class="col-lg-12">
                                            <div>Total ongkir <p class="pull-right"><?= "Rp " . number_format($int = preg_replace("/[^0-9\.]/", "", $ed['paket']), 0, ',', '.'); ?> </p>
                                            </div>
                                        </div>
                                        <div class="col-lg-12">
                                            <div class="checkout__order__products">Total Belanja <p class="pull-right"><?= "Rp " . number_format($ed['total_pembayaran'], 0, ',', '.'); ?> </p>
                                            </div>
                                        </div>
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