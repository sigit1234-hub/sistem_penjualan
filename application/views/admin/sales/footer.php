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
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

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
    // document.getElementById('submitBtn').addEventListener('click', function(event) {
    //     document.getElementById('myForm').submit();
    // });
    document.getElementById("submitBtn").disabled = true;
    // var disabledInput = document.getElementById("product-name").disabled = false;
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

    getName(event, 1);

    function getName(event, no) {
        $(document).ready(function() {
            $('#product-name' + no).select2({
                placeholder: 'Pilih Produk',
                minimumInputLength: 1,
                ajax: {
                    url: '<?= site_url('Kasir/get_products') ?>',
                    dataType: 'json',
                    delay: 250,
                    data: function(params) {
                        return {
                            q: params.term // kata kunci pencarian
                        };
                    },
                    processResults: function(data) {
                        return {
                            results: data
                        };
                    },
                    cache: true
                }
            });

            // Event listener untuk perubahan pada dropdown
            $('#product-name' + no).on('select2:select', function(e) {
                const selectedProduct = e.params.data;
                $('#product-code' + no).val(selectedProduct.id);
                $('#kodeBarang' + no).val(selectedProduct.id);
                tambahAtauPerbaruiTabel(no);
            });
        });
    }

    function cegahInput(no) {

        var numberInput = document.getElementById('qtyProduk' + no);

        numberInput.addEventListener('keydown', function(e) {
            // Allow: backspace, delete, tab, escape, enter, and arrows
            if ([46, 8, 9, 27, 13, 38, 40].indexOf(e.keyCode) !== -1 ||
                // Allow: Ctrl+A, Ctrl+C, Ctrl+V, Ctrl+X
                (e.keyCode === 65 && (e.ctrlKey || e.metaKey)) ||
                (e.keyCode === 67 && (e.ctrlKey || e.metaKey)) ||
                (e.keyCode === 86 && (e.ctrlKey || e.metaKey)) ||
                (e.keyCode === 88 && (e.ctrlKey || e.metaKey)) ||
                // Allow: home, end, left, right
                (e.keyCode >= 35 && e.keyCode <= 39)) {
                // Let it happen, don't do anything
                return;
            }
            // Ensure that it is a number and stop the keypress
            if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) &&
                (e.keyCode < 96 || e.keyCode > 105)) {
                e.preventDefault();
            }
        });

        // Prevent pasting non-numeric content
        numberInput.addEventListener('input', function(e) {
            numberInput.value = numberInput.value.replace(/[^0-9]/g, '');
            // Check if the value exceeds the max attribute
            var max = numberInput.getAttribute('max');
            if (numberInput.value !== '' && Number(numberInput.value) > Number(max)) {
                numberInput.value = max;
            }
        });

    }

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
            // document.getElementById("namaProduk" + no).innerHTML = '';
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

                $.ajax({
                    type: 'POST',
                    url: '<?= base_url('Kasir/getProduks') ?>', // Sesuaikan dengan URL yang benar
                    data: {
                        code: kodeProdukInput
                    },
                    dataType: 'json',
                    success: function(response) {
                        if (response) {

                            if (qtyLama == (response.stok - 10)) {
                                alert("stok sudah terpenuhi");
                            } else {
                                var updateQty = parseInt(qtyLama) * 1 + 1 * 1;

                                document.getElementById("qtyProduk" + noUrut).value = updateQty;
                                hitungTotal(noUrut);

                            }
                        }
                    }
                });


                document.getElementById('product-name' + no).innerHTML = '';
                document.getElementById('kodeBarang' + no).value = '';
                document.getElementById('product-name' + no).click();
                document.getElementById('product-name' + no).value = '';
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
                                // document.getElementById("namaProduk" + noBaru).innerHTML = response.nama_produk;
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

                                document.getElementById("qtyProduk" + no).setAttribute('max', (response.stok - 10));
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
                                document.getElementById('product-name' + no).disabled = false;
                                document.getElementById('product-name' + no).focus();
                                getName(event, next);
                            } else {
                                tampungKodeBarang.push(kodeProdukInput);
                                tampungId.push(response.id_produk);
                                tampungNoUrut.push(no);
                                var hargaValue = parseInt(response.harga);
                                document.getElementById("qtyProduk" + no).value = 1;
                                // document.getElementById("namaProduk" + no).innerHTML = response.nama_produk;
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
                                document.getElementById("qtyProduk" + no).setAttribute('max', (response.stok - 10));
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
                                document.getElementById('product-name' + next).disabled = false;
                                document.getElementById('product-name' + next).focus();
                                getName(event, next);
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
            document.getElementById("submitBtn").addEventListener('click', function() {
                document.getElementById("submitBtn").setAttribute('type', 'submit');
                // alert("oke");
            });
        } else {
            document.getElementById("submitBtn").disabled = true;
            document.getElementById("submitBtn").setAttribute('type', 'button');

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