<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title><?= $judul; ?></title>
    <link rel="icon" type="image/png" href="<?= base_url('assets/img/dapur.png') ?>">
    <style>
        .clearfix:after {
            content: "";
            display: table;
            clear: both;
        }



        a {
            color: #5D6975;
            text-decoration: underline;
        }

        body {
            position: relative;
            width: 21cm;
            height: 29.7cm;
            margin: 0 auto;
            color: #001028;
            background: #FFFFFF;
            font-family: Arial, sans-serif;
            font-size: 12px;
            font-family: Arial;
        }

        header {
            padding: 10px 0;
            margin-bottom: 30px;
        }

        #logo {
            text-align: center;
            margin-bottom: 10px;
        }

        #logo img {
            width: 90px;
        }

        h1 {
            border-top: 1px solid #5D6975;
            border-bottom: 1px solid #5D6975;
            color: #5D6975;
            font-size: 2.4em;
            line-height: 1.4em;
            font-weight: normal;
            text-align: center;
            margin: 0 0 20px 0;
            background: url(dimension.png);
        }

        #project {
            float: left;
        }

        #project span {
            color: #5D6975;
            text-align: right;
            width: 52px;
            margin-right: 10px;
            display: inline-block;
            font-size: 0.8em;
        }

        #company {
            float: right;
            text-align: right;
        }

        #project div,
        #company div {
            white-space: nowrap;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            border-spacing: 0;
            margin-bottom: 20px;
        }

        table tr:nth-child(2n-1) td {
            background: #F5F5F5;
        }

        table th,
        table td {
            text-align: center;
        }

        table th {
            padding: 5px 20px;
            color: #5D6975;
            border-bottom: 1px solid #C1CED9;
            white-space: nowrap;
            font-weight: normal;
        }

        table .service,
        table .desc {
            text-align: left;
        }

        table td {
            padding: 20px;
            text-align: right;
        }

        table td.service,
        table td.desc {
            vertical-align: top;
        }

        table td.unit,
        table td.qty,
        table td.total {
            font-size: 1.2em;
        }

        table td.grand {
            border-top: 1px solid #5D6975;
            ;
        }

        #notices .notice {
            color: #5D6975;
            font-size: 1.2em;
        }

        footer {
            color: #5D6975;
            width: 100%;
            height: 30px;
            position: absolute;
            bottom: 0;
            border-top: 1px solid #C1CED9;
            padding: 8px 0;
            text-align: center;
        }
    </style>
    <script>
        window.print();
    </script>
</head>

<body>
    <header class="clearfix">
        <div id="logo">
            <img src="<?= base_url('assets/') ?>img/dapur.png">
        </div>
        <h1><?= $judul; ?></h1>
        <div id="company" class="clearfix">
            <div>CV Dapur Berkah</div>
            <div>Dusun kemutug RT 2 RW 1 desa tirip,<br /> kec Wadaslintang kab Wonosobo</div>
            <div>Telpone / Whatsapp : +62 821-3507-6353</div>
            <div><a href="mailto:company@example.com">Email: admin@dapurberkah.my.id</a></div>
        </div>
        <div id="project">
            <?php foreach ($invoice as $in) : ?>
                <div><span>NAMA</span> <?= nama($in['id_user']); ?></div>
                <?php $user = $this->db->get_where('alamat', ['id_user' => $in['id_user']])->result_array();
                foreach ($user as $u) :
                ?>
                    <div class="alamat"><span>ALAMAT</span> <?= $u['lengkap'] . $u['desa'] . ' ' . $u['patokan']; ?></div>
                    <div><span></span> <?= 'kec,' . kecamatan($u['kecamatan']) . ',kota ' . kota($u['kota']); ?></div>
                    <div><span></span> <?= 'Provinsi,' . $u['provinsi']; ?></div>
                <?php endforeach; ?>
                <div><span>TANGGAL</span> <?= tgl_jam($in['tanggal_transaksi']) ?></div>
            <?php endforeach; ?>
        </div>
    </header>
    <main>
        <table>
            <h3>Detail Barang</h3>
            <thead>
                <tr>
                    <th class="service">NOMOR</th>
                    <th class="desc">NAMA BARANG</th>
                    <th>HARGA</th>
                    <th>JUMLAH</th>
                    <th>TOTAL</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $idProduk = explode(',', $in['id_produk']);
                $qty = explode(',', $in['jumlah']);
                $harga = explode(',', $in['harga_produk']);
                for ($i = 0; $i < count($idProduk); $i++) { ?>
                    <tr>
                        <td class="service"><?= $i + 1; ?></td>
                        <td class="desc"><?= namaProduk($idProduk[$i]); ?></td>
                        <td class="unit"><?= Rupiah($harga[$i]); ?></td>
                        <td class="qty"><?= $qty[$i]; ?></td>
                        <td class="total">
                            <?php echo Rupiah($qty[$i] * $harga[$i]); ?>
                        </td>
                    </tr>
                <?php } ?>

                <tr>
                    <td colspan="4" class="grand total">Total Diskon</td>
                    <td class="grand total"><?= Rupiah(intval($in['total_diskon'])); ?></td>
                </tr>
                <tr>
                    <td colspan="4" class="total">Total Ongkir</td>
                    <td><?= Rupiah(preg_replace("/[^0-9]/", "", $in['paket'])); ?></td>
                </tr>
                <tr>
                    <td colspan="4" class="total">Total Pesanan</td>
                    <td><?= Rupiah($in['total_pembayaran']); ?></td>
                </tr>
                <tr>

                </tr>
                <tr>
                    <td colspan="4" class="total">Pengiriman</td>
                    <td><?= $in['kurir'] . " " . $in['paket']; ?></td>
                </tr>
                <tr>
                    <td colspan="4" class="total">Pembayaran</td>
                    <td><?= $in['bank'] . " " . $in['va_number']; ?></td>
                </tr>
            </tbody>
        </table>
    </main>
    <footer>
        <?= $judul; ?> CV Dapur Berkah
    </footer>
</body>

</html>