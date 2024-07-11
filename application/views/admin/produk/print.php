<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Print <?= $kode; ?></title>
    <script>
        function autoPrintAndRedirect() {
            // Fungsi untuk mencetak halaman secara otomatis saat halaman dimuat
            window.print();

            // Menetapkan fungsi yang akan dipanggil setelah proses pencetakan selesai
            // window.onafterprint = function() {
            //     // Redirect ke halaman lain setelah pencetakan selesai
            //     window.location.href = '<?= base_url('Admin/transaksiToko') ?>';
            // };
        }

        // Panggil fungsi autoPrintAndRedirect() saat halaman selesai dimuat
        window.onload = autoPrintAndRedirect;
    </script>
    <style>
        body {
            width: 300px;
            font-size: 12px;
            font-family: 'Courier New', Courier, monospace;
            text-align: center;
        }

        .alamat {
            margin-top: 30px;
        }

        .header {
            font-size: 20px;
        }

        .kasir {
            margin-bottom: 10px;
        }
    </style>

</head>

<body class="struk">
    <section class="sheet">
        <div class="header">
            <h3>CV DAPUR BERKAH</h3>
        </div>
        <?= str_repeat("=", 40) . "<br/>"; ?>
        <div class="kasir">
            <table>
                <tr>
                    <td align="left" class="txt-left">kode&nbsp;</td>
                    <td align="left" class="txt-left">:</td>
                    <td align="left" class="txt-left">&nbsp; <?= $kode; ?></td>
                </tr>
                <tr>
                    <td align="left" class="txt-left">Kasir&nbsp;</td>
                    <td align="left" class="txt-left">:</td>
                    <?php foreach ($dataTransaksi as $d) : ?>
                        <td align="left" class="txt-left">&nbsp; <?= nama($d['id_user']) ?></td>
                    <?php endforeach; ?>
                </tr>
                <tr>
                    <td align="left" class="txt-left">Catatan&nbsp;</td>
                    <td align="left" class="txt-left">:</td>
                    <?php foreach ($dataTransaksi as $d) : ?>
                        <td align="left" class="txt-left">&nbsp; <?= $d['catatan'] ?></td>
                    <?php endforeach; ?>
                </tr>
                <tr>
                    <td align="left" class="txt-left">Tanggal&nbsp;</td>
                    <td align="left" class="txt-left">:</td>
                    <td align="left" class="txt-left">&nbsp; <?php foreach ($dataTransaksi as $d) {
                                                                    echo $d['tanggal_transaksi'];
                                                                } ?></td>
                </tr>
            </table>
        </div>
        <?= str_repeat("=", 40) . "<br/>"; ?>

        <table class="table table-light">
            <thead>
                <tr>
                    <td width="50%">Produk</td>
                    <td width="5%">Qty</td>
                    <td width="20%">Harga</td>
                    <td width="25%">Total</td>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($dataTransaksi as $d)  ?>
                <?php
                $id_produk = explode(",", $d['id_produk']);
                $qty = explode(",", $d['jumlah']);
                $hargaProduk = explode(",", $d['harga_produk']);
                for ($i = 0; $i < count($id_produk); $i++) {
                    $this->db->where('id_produk', $id_produk[$i]);
                    $data =  $this->db->get('produk')->result_array();
                    foreach ($data as $dt) { ?>
                        <tr>
                            <td align="left" class="txt-left"><?= $dt['nama_produk']; ?>&nbsp;</td>
                            <td align="center" class="txt-left"><?= $qty[$i]; ?></td>
                            <td align="right" class="txt-left"> <?= Rupiah($hargaProduk[$i]); ?></td>
                            <td align="right" class="txt-left"> <?= Rupiah(intval($qty[$i]) * intval($hargaProduk[$i])) ?></td>
                        </tr>
                <?php }
                } ?>
            </tbody>
        </table>
        <?= str_repeat("-", 40) . "<br/>"; ?>
        <div class="total">
            <table>
                <tr>
                    <td align="left" width="90%" class="txt-left">Sub Total&nbsp;</td>
                    <td align="right" width="50%" class="txt-left"> <?= Rupiah($d['total_pembayaran']); ?></td>
                </tr>
                <tr>
                    <td align="left" width="90%" class="txt-left">Diskon&nbsp;</td>
                    <td align="right" width="50%" class="txt-left"> <?= Rupiah($d['total_diskon']); ?></td>
                </tr>
                <tr>
                    <td align="left" width="90%" class="txt-left">Bayar&nbsp;</td>
                    <td align="right" width="50%" class="txt-left"> <?= Rupiah($d['total_pembayaran'] + $d['kembalian']); ?></td>
                </tr>
                <tr>
                    <td align="left" width="90%" class="txt-left">Kembali&nbsp;</td>
                    <td align="right" width="50%" class="txt-left"> <?= Rupiah($d['kembalian']) ?></td>
                </tr>
            </table>
        </div>
        <div class="alamat">
            <p>Dusun kemutug RT 2 RW 1 desa tirip, kec Wadaslintang kab Wonosobo<br>
                Telpone / Whatsapp : +62 821-3507-6353<br>
                Email: admin@dapurberkah.my.id<br>
            </p>
        </div>
    </section>

</body>

</html>