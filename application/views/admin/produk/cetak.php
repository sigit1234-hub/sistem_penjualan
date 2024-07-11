<!DOCTYPE html>

<html lang="en" class="light-style layout-menu-fixed" dir="ltr" data-theme="theme-default" data-assets-path="<?= base_url('vendor/admin/') ?>/assets/" data-template="vertical-menu-template-free">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

    <title><?= $title; ?></title>

    <meta name="description" content="" />

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="<?= base_url('assets/img/') ?>/putih.png" />

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap" rel="stylesheet" />

    <!-- Icons. Uncomment required icon fonts -->
    <link rel="stylesheet" href="<?= base_url('vendor/admin/') ?>/assets/vendor/fonts/boxicons.css" />

    <!-- Core CSS -->
    <link rel="stylesheet" href="<?= base_url('vendor/admin/') ?>/assets/vendor/css/core.css" class="template-customizer-core-css" />
    <link rel="stylesheet" href="<?= base_url('vendor/admin/') ?>/assets/vendor/css/theme-default.css" class="template-customizer-theme-css" />
    <link rel="stylesheet" href="<?= base_url('vendor/admin/') ?>/assets/css/demo.css" />

    <!-- Vendors CSS -->
    <link rel="stylesheet" href="<?= base_url('vendor/admin/') ?>/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css" />

    <!-- Page CSS -->

    <!-- Helpers -->
    <script src="<?= base_url('vendor/admin/') ?>/assets/vendor/js/helpers.js"></script>

    <!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->
    <!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->
    <script src="<?= base_url('vendor/admin/') ?>/assets/js/config.js"></script>
    <style>
        @media print {
            body * {
                visibility: hidden;
            }

            #tabel-cetak,
            #tabel-cetak * {
                visibility: visible;
            }

            #judul * {
                visibility: visible;
            }

            #tabel-cetak {
                position: absolute;
                left: 0;
                top: 0;
            }
        }
    </style>
</head>

<body>
    <!-- Layout wrapper -->
    <div class="layout-wrapper layout-content-navbar layout-without-menu">
        <div class="layout-container">
            <!-- Layout container -->
            <div class="layout-page">
                <!-- Navbar -->

                <nav class="layout-navbar container-xxl navbar navbar-expand-xl navbar-detached align-items-center bg-navbar-theme" id="layout-navbar">
                    <div class="navbar-nav-right d-flex align-items-center" id="navbar-collapse">
                        <div class="navbar-nav  align-items-center m-3">
                            <a href="<?= base_url('Admin/produk') ?>">
                                <i class="bx bx-home-circle"></i>
                            </a>
                        </div>
                        <div class="navbar-nav  align-items-center m-3">
                            <?= tanggal_jam(tanggal()); ?>
                        </div>
                        <ul class="navbar-nav flex-row align-items-center ms-auto">
                            <li class="nav-item navbar-dropdown dropdown-user dropdown">
                                <a href="<?= base_url('Admin/excel') . "/" . $stok . "/" . $kategori ?>" class="btn btn-primary m-1">Excel</a>
                                <button onclick="window.print()" class="btn btn-primary m-1">Cetak</button>
                            </li>

                        </ul>
                        </li>
                        <!--/ User -->
                        </ul>
                    </div>
                </nav>

                <!-- / Navbar -->
                <!-- Content wrapper -->
                <div class="content-wrapper">
                    <!-- Content -->
                    <div class="container-xxl flex-grow-1 container-p-y">
                        <?= $this->session->flashdata('message'); ?>
                        <!-- Layout Demo -->
                        <!-- <div class="layout-demo-wrapper"> -->
                        <!-- <form id="payment-form" method="POST" action="<?= base_url('Kasir/checkout') ?>"> -->
                        <div class="row">
                            <div class="col-lg-12 mb-4 order-0">
                                <div class="card">
                                    <div class="d-flex align-items-end row">
                                        <div class="card-body">
                                            <div class="table-responsive text-nowrap" id="tabel-cetak">
                                                <!-- table produc  -->
                                                <table class="table table-bordered">
                                                    <div style="text-align:center; margin-bottom:80px">

                                                        <h2><img src="<?= base_url('assets/') ?>img/dapur.png" alt="" style="margin-right:40px">DATA PRODUK CV. DAPUR BERKAH</h2>
                                                        <p>
                                                            Alamat : Dusun kemutug RT 2 RW 1 desa tirip, kec Wadaslintang kab Wonosobo<br>
                                                            Telpone / Whatsapp : +62 821-3507-6353<br>
                                                            Email: admin@dapurberkah.my.id<br>
                                                        </p>
                                                    </div>
                                                    <div class="judul" style="margin: bottom 30px;">
                                                        <p>Kategori &nbsp;: <?php if ($kategori == 0) {
                                                                                echo 'Semua, ';
                                                                            } else {
                                                                                echo kategori($kategori) . ", ";
                                                                            } ?> Stok &nbsp;: <?php if ($stok == 0) {
                                                                                                    echo 'Semua';
                                                                                                } else if ($stok == 1) {
                                                                                                    echo '1 sampai dengan 10';
                                                                                                } else if ($stok == 2) {
                                                                                                    echo "11 sampai dengan 100";
                                                                                                } else {
                                                                                                    echo "> 101";
                                                                                                } ?></p>
                                                    </div>
                                                    <thead>
                                                        <div id="hasil"></div>
                                                        <tr>
                                                            <th>No</th>
                                                            <th>Kode</th>
                                                            <th>Nama</th>
                                                            <th>Tanggal</th>
                                                            <th>Harga</th>
                                                            <th>Stok</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="tabelInput">
                                                        <?php $i = 1;
                                                        foreach ($dataProduk as $d) : ?>
                                                            <tr id="dataTable">
                                                                <td width="5%"><?= $i++; ?></td>
                                                                <td width="15%"><?= $d['kode_produk']; ?></td>
                                                                <td width="40%"><?= $d['nama_produk']; ?></td>
                                                                <td width="15%"><?= tanggal_jam($d['tgl_input']); ?></td>
                                                                <td width="15%"><?= Rupiah($d['harga']); ?></td>
                                                                <td width="15%"><?= Rupiah($d['stok']); ?></td>
                                                            </tr>
                                                        <?php endforeach; ?>
                                                    </tbody>
                                                </table>

                                            </div>
                                        </div>
                                        <!-- table discount  -->
                                    </div>
                                </div>
                            </div>
                            <!-- row  -->
                        </div>
                        <!-- </form> -->
                        <!-- </div>s -->
                        <!--/ Layout Demo -->
                    </div>
                    <!-- / Content -->

                    <!-- Footer -->
                    <footer class="content-footer footer bg-footer-theme">
                        <div class="container-xxl d-flex flex-wrap justify-content-between py-2 flex-md-row flex-column">
                            <div class="mb-2 mb-md-0">
                                ©
                                <?= date('Y') ?>
                                CV Dapur Berkah
                            </div>
                        </div>
                    </footer>
                    <!-- / Footer -->

                    <div class="content-backdrop fade"></div>
                </div>
                <!-- Content wrapper -->
            </div>
            <!-- / Layout page -->
        </div>
    </div>
    <!-- / Layout wrapper -->

    <!-- <div class="buy-now">
    <a href="<?= base_url('Admin') ?>" class="btn btn-danger btn-buy-now">Menu Admin</a>
</div> -->

    <!-- Core JS -->
    <!-- build:js assets/vendor/js/core.js -->
    <script src="<?= base_url('vendor/admin/') ?>/assets/vendor/libs/jquery/jquery.js"></script>
    <script src="<?= base_url('vendor/admin/') ?>/assets/vendor/libs/popper/popper.js"></script>
    <script src="<?= base_url('vendor/admin/') ?>/assets/vendor/js/bootstrap.js"></script>
    <script src="<?= base_url('vendor/admin/') ?>/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js"></script>

    <script src="<?= base_url('vendor/admin/') ?>/assets/vendor/js/menu.js"></script>
    <!-- endbuild -->

    <!-- Vendors JS -->

    <!-- Main JS -->
    <script src="<?= base_url('vendor/admin/') ?>/assets/js/main.js"></script>

    <!-- Page JS -->

    <!-- Place this tag in your head or just before your close body tag. -->
    <script async defer src="https://buttons.github.io/buttons.js"></script>
    <script>
        function addRp(input) {
            let inputValue = input.value;

            // Hapus karakter non-digit
            inputValue = inputValue.replace(/[^\d]/g, '');

            // Format nilai ke format Rupiah
            inputValue = parseInt(inputValue, ).toLocaleString('id-ID', {
                minimumFractionDigits: 0,
                maximumFractionDigits: 0
            });

            // Setel nilai input kembali
            input.value = inputValue;
        }
    </script>
    <script>
        // Fungsi untuk mengubah format Rupiah
        function formatRupiah(input) {
            let inputValue = input.value;

            // Hapus karakter non-digit
            inputValue = inputValue.replace(/[^\d]/g, '');

            // Format nilai ke format Rupiah
            inputValue = parseInt(inputValue, 10).toLocaleString('id-ID', {
                style: 'currency',
                currency: 'IDR',
                minimumFractionDigits: 0,
                maximumFractionDigits: 0
            });

            // Setel nilai input kembali
            input.value = inputValue;
        }

        // Dapatkan semua elemen dengan kelas "rupiah-input"
        let rupiahInputs = document.querySelectorAll('.rupiah-input');

        // Tambahkan event listener untuk setiap elemen
        rupiahInputs.forEach(function(input) {
            input.addEventListener('input', function() {
                formatRupiah(input);
            });
        });

        // Panggil fungsi saat halaman dimuat (opsional)
        window.onload = function() {
            // Format nilai Rupiah untuk setiap elemen saat halaman dimuat
            rupiahInputs.forEach(function(input) {
                formatRupiah(input);
            });
        };
    </script>
    <script>
        function fillTable() {
            // Dapatkan nilai dari input kode barang
            let kodeBarang = document.getElementById('kodeBarang').value;

            // Simulasi data dari kode barang (gantilah dengan data sesuai kebutuhan)
            let data = getDataByKodeBarang(kodeBarang);

            // Dapatkan tabel dan tbody
            let tr = document.getElementById('trTable');
            let td = document.getElementById('tdTable');
            let tbody = document.getElementById('tableBody');

            // Bersihkan isi tbody
            tbody.innerHTML = "";
            tr.innerHTML = "";

            // Tambahkan baris baru ke tbody
            let newRow = tr.insertRow();

            // Tambahkan sel-sel ke baris baru
            let cell1 = newRow.insertCell(0);
            cell1.innerHTML = data.kodeBarang;

            let cell2 = newRow.insertCell(1);
            cell2.innerHTML = data.namaBarang;

            let cell3 = newRow.insertCell(2);
            cell3.innerHTML = data.harga;
        }

        // Fungsi simulasi untuk mendapatkan data berdasarkan kode barang
        function getDataByKodeBarang(kodeBarang) {
            // Gantilah ini dengan logika yang sesuai pada aplikasi atau backend Anda
            // Ini hanya contoh simulasi data
            return {
                kodeBarang: kodeBarang,
                namaBarang: 'Nama Barang',
                harga: 'Rp 100.000'
            };
        }
    </script>


    <script>
        document.getElementById("submitBtn").disabled = true;
        var disabledInput = document.getElementById("kodeBarang1").disabled = false;
        var tampungKodeBarang = [];
        var tampungNoUrut = [];
        var tampungTotalHarga = [];
        var tampungDiskon = [];
        var tampungHarga = [];
        var tampungQty = [];
        var tampungId = [];
        // getAllPrice();
        console.log(tampungId);
        console.log(tampungNoUrut);
        console.log(tampungTotalHarga);
        console.log(tampungDiskon);

        function handleEnterKey(event, no) {
            // Mendapatkan kode tombol dari objek event
            var keyCode = event.keyCode || event.which;
            // 13 adalah kode tombol Enter
            if (keyCode === 13) {
                // Panggil fungsi yang ingin dijalankan
                tambahAtauPerbaruiTabel(no);
            }
        }

        function tambahAtauPerbaruiTabel(no) {

            var kodeProdukInput = $('#kodeBarang' + no).val().toUpperCase();
            var totalProduk = document.getElementById("totalProduk" + no).innerHTML;
            var totalDiskon = document.getElementById("diskonInput" + no).innerHTML;
            if (kodeProdukInput == '' && totalProduk !== '') {
                var index = tampungNoUrut.indexOf(no);
                document.getElementById("kodeBarang" + no).value = '';
                document.getElementById("diskonInput" + no).value = '';
                document.getElementById("hargaInput" + no).value = '';
                document.getElementById("hargaProduk" + no).innerHTML = '';
                document.getElementById("namaProduk" + no).innerHTML = '';
                document.getElementById("qtyProduk" + no).value = '';
                document.getElementById("totalProduk" + no).innerHTML = '';

                var cekTabelDiskon = document.getElementById("tabelTampilDiskon" + no);
                if (cekTabelDiskon) {
                    document.getElementById("tabelTampilDiskon" + no).remove();
                }
                tampungKodeBarang[index] = undefined;
                tampungTotalHarga[index] = 0;
                tampungDiskon[index] = 0;
                tampungQty[index] = undefined;
                tampungHarga[index] = undefined;
                tampungId[index] = undefined;
                document.getElementById("tampungQty").value = tampungQty;
                document.getElementById("tampungHarga").value = tampungHarga;
                document.getElementById('tampungKode').value = tampungId;
                // tampungNoUrut[index] = '';
                hitungGrand();
                console.log(tampungQty);
                console.log(tampungHarga);
                console.log(tampungTotalHarga);
                console.log(tampungId);

            } else {
                // kode barang sudah ada 
                if (tampungKodeBarang.indexOf(kodeProdukInput) !== -1) {
                    var index = tampungKodeBarang.indexOf(kodeProdukInput);
                    var noUrut = tampungNoUrut[index];
                    var qtyLama = document.getElementById("qtyProduk" + noUrut).value;
                    var updateQty = parseInt(qtyLama) * 1 + 1 * 1;

                    document.getElementById("qtyProduk" + noUrut).value = updateQty;
                    hitungTotal(noUrut);

                    document.getElementById('kodeBarang' + no).value = '';
                    document.getElementById('kodeBarang' + no).focus();
                    return;

                } else {

                    $.ajax({
                        type: 'POST',
                        url: '<?= base_url('Kasir/getProduks') ?>', // Sesuaikan dengan URL yang benar
                        data: {
                            code: kodeProdukInput
                        },
                        dataType: 'json',
                        success: function(response) {
                            if (response) {
                                var undefinedIndex = tampungKodeBarang.indexOf(undefined);
                                console.log("undefined :" + undefinedIndex);

                                if (undefinedIndex !== -1) {

                                    var noBaru = tampungNoUrut[undefinedIndex];
                                    var hargaValue = parseInt(response.harga);
                                    var nilaiBaruQty = document.getElementById("qtyProduk" + noBaru).value = 1;
                                    document.getElementById("namaProduk" + noBaru).innerHTML = response.nama_produk;
                                    if (response.diskon == 0) {
                                        var hargaDiskon = response.harga * 1;
                                    } else {
                                        var hargaDiskon = response.harga * 1 - response.diskon;
                                        tampilDiskon(response, noBaru);
                                    }
                                    document.getElementById("hargaProduk" + noBaru).innerHTML = formatDesimal(hargaDiskon);
                                    tampungTotalHarga.push(hargaDiskon);
                                    tampungKodeBarang[undefinedIndex] = kodeProdukInput;
                                    tampungId[undefinedIndex] = response.id_produk;
                                    tampungQty[undefinedIndex] = nilaiBaruQty;
                                    tampungHarga[undefinedIndex] = hargaDiskon;
                                    tampungDiskon[undefinedIndex] = parseInt(response.diskon);
                                    document.getElementById("tampungQty").value = tampungQty;
                                    document.getElementById("tampungHarga").value = tampungHarga;
                                    document.getElementById('tampungKode').value = tampungId;
                                    document.getElementById("kodeBarang" + noBaru).value = kodeProdukInput;
                                    document.getElementById("hargaInput" + noBaru).value = hargaDiskon;
                                    document.getElementById("hargaInput" + noBaru).value = hargaDiskon;
                                    document.getElementById("diskonInput" + noBaru).value = parseInt(response.diskon);

                                    var nilaiHarga = document.getElementById("hargaInput" + noBaru).value;
                                    var nilaiQty = document.getElementById("qtyProduk" + noBaru).value;

                                    var totalHarga = parseInt(nilaiHarga) * nilaiQty;
                                    document.getElementById("totalProduk" + noBaru).innerHTML = formatDesimal(parseInt(totalHarga));
                                    var inputTotalHarga = document.getElementById("totalProduk" + noBaru).innerHTML = parseInt(totalHarga);
                                    tampungTotalHarga[undefinedIndex] = inputTotalHarga;
                                    hitungGrand();
                                    var next = noBaru * 1 + 1;
                                    document.getElementById('kodeBarang' + no).value = '';
                                    document.getElementById('kodeBarang' + no).disabled = false;
                                    document.getElementById('kodeBarang' + no).focus();
                                } else {
                                    tampungKodeBarang.push(kodeProdukInput);
                                    tampungId.push(response.id_produk);
                                    tampungNoUrut.push(no);
                                    var hargaValue = parseInt(response.harga);
                                    document.getElementById("qtyProduk" + no).value = 1;
                                    document.getElementById("namaProduk" + no).innerHTML = response.nama_produk;
                                    if (response.diskon == 0) {
                                        var hargaDiskon = response.harga * 1;
                                    } else {
                                        var hargaDiskon = response.harga * 1 - response.diskon;
                                        tampilDiskon(response, no);
                                    }
                                    document.getElementById("hargaProduk" + no).innerHTML = formatDesimal(hargaDiskon);
                                    tampungTotalHarga.push(hargaDiskon);
                                    tampungDiskon.push(parseInt(response.diskon));
                                    document.getElementById("hargaInput" + no).value = hargaDiskon;
                                    document.getElementById("hargaInput" + no).value = hargaDiskon;
                                    document.getElementById("diskonInput" + no).value = parseInt(response.diskon);

                                    var nilaiHarga = document.getElementById("hargaInput" + no).value;
                                    var nilaiQty = document.getElementById("qtyProduk" + no).value;
                                    tampungQty.push(nilaiQty);
                                    tampungHarga.push(nilaiHarga);
                                    document.getElementById('tampungHarga').value = tampungHarga;
                                    document.getElementById('tampungKode').value = tampungId;
                                    document.getElementById('tampungQty').value = tampungQty;
                                    var totalHarga = parseInt(nilaiHarga) * nilaiQty;
                                    document.getElementById("totalProduk" + no).innerHTML = formatDesimal(parseInt(totalHarga));
                                    hitungGrand();
                                    var next = no * 1 + 1;
                                    document.getElementById('kodeBarang' + next).disabled = false;
                                    document.getElementById('kodeBarang' + next).focus();

                                }
                            }

                        }
                    });
                }
            }

        }

        function hitungTotal(no) {
            var nilaiHarga = document.getElementById("hargaInput" + no).value;
            var nilaiDiskon = document.getElementById("diskonInput" + no).value;
            var nilaiQty = document.getElementById("qtyProduk" + no).value;
            var totalHarga = parseInt(nilaiHarga) * nilaiQty;
            var totalDiskon = parseInt(nilaiDiskon) * nilaiQty;
            document.getElementById("totalProduk" + no).innerHTML = formatDesimal(parseInt(totalHarga));

            var index = tampungNoUrut.indexOf(no);
            tampungTotalHarga[index] = totalHarga;

            var index = tampungNoUrut.indexOf(no);
            tampungDiskon[index] = totalDiskon;
            tampungQty[index] = nilaiQty;
            document.getElementById("tampungQty").value = tampungQty;

            hitungGrand();
        }

        var noUrutCell = 1;

        function tampilDiskon(response, no) {
            // Buat baris baru untuk tabel
            var newRow = document.createElement('tr');
            newRow.setAttribute('id', 'tabelTampilDiskon' + no);


            // Buat sel untuk kolom Nama
            var noCell = document.createElement('td');
            noCell.textContent = noUrutCell++;
            newRow.appendChild(noCell);

            var kodeCell = document.createElement('td');
            kodeCell.textContent = response.kode_produk;
            newRow.appendChild(kodeCell);

            var namaCell = document.createElement('td');
            namaCell.innerHTML = response.nama_produk;
            newRow.appendChild(namaCell);

            // Buat sel untuk kolom Usia
            var cellHarga = document.createElement('td');
            cellHarga.innerHTML = formatDesimal(parseInt(response.harga));
            newRow.appendChild(cellHarga);

            var cellDiskon = document.createElement('td');

            var besarDiskon = (parseInt(response.diskon) / parseInt(response.harga)) * 100;
            cellDiskon.innerHTML = formatDesimal(parseInt(response.diskon)) + " (-" + Math.round(besarDiskon) + "%)";
            newRow.appendChild(cellDiskon);

            // Tambahkan baris ke dalam tabel
            document.getElementById('tabelBody').appendChild(newRow);
        }

        function hitungGrand() {
            var data = tampungTotalHarga;
            var hitung = data.reduce(function(total, bilangan) {
                return total + bilangan;
            }, 0);
            var diskon = tampungDiskon;
            var hitungDiskon = diskon.reduce(function(total, bilangan) {
                return total + bilangan;
            }, 0);
            console.log("dari total harga " + hitung);
            console.log("dari diskon " + hitungDiskon);
            document.getElementById("grandTotalHarga").value = formatDesimal(hitung);
            document.getElementById("grandDiskon").value = formatDesimal(hitungDiskon);
            hitungKembalian();
        }

        function hitungKembalian() {
            var nilaiTotal = document.getElementById("grandTotalHarga").value;
            var nilaiTunai = document.getElementById("inputTunai").value;

            var konvert = nilaiTotal.replace(/[^0-9]/g, '');
            var konKembalian = nilaiTunai.replace(/[^0-9]/g, '');
            var result = parseInt(konKembalian) - parseInt(konvert);
            console.log("nilai total " + konvert);
            document.getElementById("nilaiKembalian").innerHTML = formatDesimal(result);
            document.getElementById("kembalian").value = result;
            if (result >= 0) {
                document.getElementById("submitBtn").disabled = false;
            } else {
                document.getElementById("submitBtn").disabled = true;

            }
        }


        function kirimData() {
            var grandTotal = document.getElementById("grandTotalHarga").value;
            var totalPembayaran = parseFloat(grandTotal.replace(/[^0-9]/g, ''));
            var grandDiskon = document.getElementById("grandDiskon").value;
            var totalDiskon = parseFloat(grandDiskon.replace(/[^0-9]/g, ''));
            var kembalian = document.getElementById("kembalian").value;
            var dataField = {
                kode: tampungKodeBarang,
                harga: tampungHarga,
                totalHarga: totalPembayaran,
                qty: tampungQty,
                diskon: totalDiskon,
                kembali: kembalian
            };
            // Menggunakan AJAX untuk mengirim data ke controller
            var xhr = new XMLHttpRequest();
            var url = '<?= base_url('Kasir/checkout') ?>';

            xhr.open('POST', url, true);
            xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');

            xhr.onreadystatechange = function() {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    // Handle respon dari server (jika diperlukan)
                    $("#result-type").val(type);
                    $("#result-data").val(JSON.stringify(data));
                }
            };

            xhr.send(JSON.stringify(dataField));
        }
    </script>
    <script>
        function formatDesimal(angka) {
            // Menghilangkan digit desimal
            var formattedNumber = angka.toFixed(0);

            // Menambahkan tanda ribuan dan simbol mata uang
            formattedNumber = Number(formattedNumber).toLocaleString('id-ID', {
                minimumFractionDigits: 0,
                maximumFractionDigits: 0
            });

            return formattedNumber;
        }
    </script>
</body>

</html>