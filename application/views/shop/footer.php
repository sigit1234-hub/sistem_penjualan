<!-- Footer Section Begin -->
<footer class="footer spad mt-5">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-6">
                <div class="footer__about">
                    <div class="footer__about__logo">
                        <a href="./index.html"><img src="<?= base_url('assets/') ?>img/dapur.png" alt=""></a>
                    </div>
                    <ul>
                        <li>Alamat : Dusun kemutug RT 2 RW 1 desa tirip, kec Wadaslintang kab Wonosobo</li>
                        <li>Telpone / Whatsapp : +62 821-3507-6353</li>
                        <li>Email: admin@dapurberkah.my.id</li>
                    </ul>
                </div>
            </div>
            <div class="col-lg-5 col-md-6 col-sm-6 offset-lg-1">
                <div class="footer__widget">
                    <h6>CV Dapur Berkah</h6>
                    <ul>
                        <?php
                        if ($this->session->userdata('role_id') == 1) {
                            $queryMenu = "SELECT * FROM user_menu";
                        } else {
                            $queryMenu = "SELECT * FROM user_menu
                                      WHERE id = 1 OR id = 2  OR id = 4 OR id = 5";
                        }
                        $menu = $this->db->query($queryMenu)->result_array();
                        ?>
                        <?php foreach ($menu as $m) : ?>
                            <li><a href="<?= base_url() . $m['link'] ?>"><?= $m['nama_menu']; ?></a></li>
                        <?php endforeach; ?>

                    </ul>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="footer__copyright">
                    <div class="footer__copyright__text">
                        <p><!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
                            Copyright &copy;
                            <script>
                                document.write(new Date().getFullYear());
                            </script>
                            <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>
<!-- Footer Section End -->

<!-- Js Plugins -->
<script src="<?= base_url('assets/') ?>js/jquery-3.3.1.min.js"></script>
<!-- <script src="<?= base_url('assets/') ?>js/jquery.nice-number.js"></script> -->
<script src="<?= base_url('assets/') ?>js/bootstrap.min.js"></script>
<script src="<?= base_url('assets/') ?>js/jquery-ui.min.js"></script>
<!-- tab  -->

<script src="<?= base_url('assets/') ?>js/jquery.slicknav.js"></script>
<!-- <script src="<?= base_url('assets/') ?>js/jquery.nice-select.min.js"></script> -->
<script src="<?= base_url('assets/') ?>js/mixitup.min.js"></script>
<script src="<?= base_url('assets/') ?>js/owl.carousel.min.js"></script>
<script src="<?= base_url('assets/') ?>js/main.js"></script>
<!-- <script src="<?= base_url('assets/') ?>js/app.js"></script> -->

<script src="<?= base_url('assets/fileuploads/') ?>js/dropify.min.js"></script>

<script src="<?= base_url('vendor/admin/assets/vendor/') ?>js/bootstrap.js"></script>

<script type="text/javascript" src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="SB-Mid-client-OQY1tUpmeAYdk5Oe"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
<script>
    let timer;

    function resetTimer() {
        clearTimeout(timer);
        timer = setTimeout(logout, 2 * 60 * 60 * 1000); // 2 jam
    }

    function logout() {
        // Arahkan pengguna ke halaman logout atau kirim permintaan ke server untuk logout
        // alert("berhasil");
        // window.location.href = '<?= base_url('Auth/logout') ?>'; // Sesuaikan URL logout Anda
    }

    // Daftar event untuk memantau aktivitas pengguna
    window.onload = resetTimer;
    document.onmousemove = resetTimer;
    document.onkeypress = resetTimer;
    document.ontouchstart = resetTimer;
    document.onclick = resetTimer;
    document.onscroll = resetTimer;
</script>

<script>
    function hitQty(id) {
        var ic = $("#icon" + id).prop('class');
        var qty = $("#qty" + id).val();

        if (ic == "fa fa-check-square fa-lg") {
            var totalSementara = $("#jumlahHarga" + id).val();
            var jmlTotal = $("#total_harga").val();
            var kurang = jmlTotal - totalSementara;
            $("#total_harga").val(kurang);
            var harga = $("#harga" + id).val();
            var jumlah = harga * qty;
            var sum = kurang * 1 + jumlah * 1;
            document.getElementById("jumlah_sum").innerHTML = formatRupiah(sum);
            $("#total_harga").val(sum);
            document.getElementById("jumlahHarga" + id).value = jumlah;

            var beratSementara = $("#jumlahBerat" + id).val();
            var jmlBerat = $("#total_berat").val();
            var bKurang = jmlBerat - beratSementara;
            $("#total_berat").val(bKurang);

            var beratAsli = $("#berat" + id).val();
            var hitungBerat = beratAsli * qty;

            var sumBerat = bKurang * 1 + hitungBerat * 1;
            document.getElementById("jumlahBerat" + id).value = hitungBerat;
            $("#total_berat").val(sumBerat);
            document.getElementById("jumlah_berat").innerHTML = formatDesimal(sumBerat);
            // alert(bKurang);

        }
    }

    function add_fav(idKeranjang) {
        var ic = $("#ic" + idKeranjang).val();
        var harga = $("#harga" + idKeranjang).val();
        var qty = $("#qty" + idKeranjang).val();
        var bItem = document.getElementById("beratItem" + idKeranjang).innerHTML;
        var jumlah = harga * qty;
        var berat = bItem * qty;
        var totalHarga = $("#total_harga").val();
        var totalBerat = $("#total_berat").val();
        // alert(berat);
        if (ic == "fa fa-square-o fa-lg") {
            $("#icon" + idKeranjang).prop("class", "fa fa-check-square fa-lg");
            $("#ic" + idKeranjang).val("fa fa-check-square fa-lg");
            var sum = totalHarga * 1 + jumlah * 1;

            var sumBerat = totalBerat * 1 + berat * 1;



            document.getElementById("jumlah_sum").innerHTML = formatRupiah(sum);
            document.getElementById("jumlah_berat").innerHTML = formatDesimal(sumBerat);
            document.getElementById("jumlahHarga" + idKeranjang).value = jumlah;
            document.getElementById("jumlahBerat" + idKeranjang).value = berat;
            $("#total_harga").val(sum);
            $("#total_berat").val(sumBerat);
        } else {
            $("#icon" + idKeranjang).prop("class", "fa fa-square-o fa-lg");
            $("#ic" + idKeranjang).val("fa fa-square-o fa-lg");
            var sum = totalHarga * 1 - jumlah * 1;
            var sumBerat = totalBerat * 1 - berat * 1;
            document.getElementById("jumlah_sum").innerHTML = formatRupiah(sum);
            document.getElementById("jumlah_berat").innerHTML = sumBerat;
            $("#total_harga").val(sum);
            $("#total_berat").val(sumBerat);
        }
    }
</script>


<!-- api wilayah  -->
<script>
    $(document).ready(function() {
        $.ajax({
            url: "<?= base_url('Home/provinsi') ?>",
            type: "GET",
            // dataType: "json",
            success: function(data) {
                $("select[name='provinsi']").html(data);
            },
        });
        $("select[name='provinsi']").on("change", function() {

            var id_provinsi = document.getElementById("provinsi").value;
            $.ajax({
                url: "<?= base_url('Home/kota') ?>",
                type: "POST",
                data: {
                    idProvinsi: id_provinsi,
                },
                success: function(dataKota) {
                    $("select[name='kota']").html(dataKota);
                },
            });
        });
        $("select[name='kota']").on("change", function() {

            var id_kota = document.getElementById("kota").value;
            // alert(id_kota);
            $.ajax({
                url: "<?= base_url('Home/kecamatan') ?>",
                type: "POST",
                data: {
                    idKota: id_kota,
                },
                success: function(kecamatan) {
                    $("select[name='kecamatan']").html(kecamatan);
                },
            });
        });

    });
</script>

<!--akhir api wilayah-->


<!-- cek ongkir-->
<script>
    $(document).ready(function() {

        cekOngkit();
        // hitungTotal();
        $("select[name='kurir']").on("change", function() {
            cekOngkit();
            // hitungTotal();
        });
        $("input[name='qty']").on("change", function() {
            cekOngkit();
            // hitungTotal();
        });
        $("select[name='hargaPaket']").on("change", function() {
            // cekOngkit();
            hitungTotal();
        });

        function cekOngkit() {
            var tujuan = <?= $kotaTujuan['kecamatan']; ?>;
            var beratItem = document.getElementById("beratItem").innerHTML;
            var jumlahItem = document.getElementById("qty").value;
            var beratTotal = beratItem * jumlahItem;
            var kurir = document.getElementById("kurir").value;

            var xmlhttp = new XMLHttpRequest();


            xmlhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    var nilaiOngkir = document.getElementById("hargaPaket").innerHTML = this.responseText;

                    var hargaPaket = document.getElementById("hargaPaket").value;

                    var harga = document.getElementById("totalHarga").value;
                    var tampilHarga = harga * jumlahItem;
                    var hasil = tampilHarga + parseInt(hargaPaket);
                    document.getElementById("ongkosPaket").innerHTML = formatRupiah(parseInt(hargaPaket));
                    document.getElementById("grandTotal").innerHTML = formatRupiah(parseInt(hasil));
                    document.getElementById("tampilTotal").innerHTML = formatRupiah(parseInt(tampilHarga));

                    var selectElemen = document.getElementById("hargaPaket");
                    var selectElemen2 = document.getElementById("hargaPaket");


                    // Mendapatkan indeks opsi yang dipilih
                    var indeksOpsiDipilih = selectElemen.selectedIndex;
                    var indeksOpsiDipilih2 = selectElemen2.selectedIndex;

                    // Mendapatkan elemen <option> yang dipilih
                    var opsiDipilih = selectElemen.options[indeksOpsiDipilih];
                    var opsiDipilih2 = selectElemen2.options[indeksOpsiDipilih2];

                    // Mendapatkan nilai dari atribut data-nama
                    var namaPaket = opsiDipilih.getAttribute("data-paket");
                    var etd = opsiDipilih2.getAttribute("data-estimasi");
                    // console.log(etd);
                    // console.log(namaPaket);
                    document.getElementById("namaPaket").setAttribute("value", namaPaket);
                    document.getElementById("estimasiSampe").innerHTML = etd;
                }
            };
            xmlhttp.open("GET", "http://localhost/sistem_penjualan/Belanja/cekOngkir?idKotaAsal=6922&idKotaTujuan=" + tujuan + "&berat=" + beratTotal + "&kurir=" + kurir + "", true);

            xmlhttp.send();
        }


        $('#pay-button').click(function(event) {
            event.preventDefault();
            $(this).attr("disabled", "disabled");
            var totalPesanan = document.getElementById("grandTotal").innerText;
            var hasilnya = totalPesanan.replace("Rp", "").replace(".", "");

            console.log(hasilnya);
            var jumlah = parseInt(hasilnya);
            var namaProduk = document.getElementById("produk").innerText;
            var ongkir = document.getElementById('hargaPaket').value;
            var qty = document.getElementById('qty').value;
            var namaPaket = document.getElementById('namaPaket').value;
            var kurir = document.getElementById('kurir').value;
            var harga = document.getElementById('totalHarga').value;

            // console.log(typeof jumlah);
            // console.log(jumlah);
            $.ajax({
                type: 'POST',
                data: {
                    ongkir: parseInt(ongkir),
                    qty: parseInt(qty),
                    harga: parseInt(harga),
                    namaProduk: namaProduk,
                    kurir: kurir + "(" + namaPaket + ")",
                    jumlahJS: jumlah
                },
                url: '<?= site_url() ?>Belanja/token',
                cache: false,

                success: function(data) {
                    //location = data;

                    console.log('token = ' + data);

                    var resultType = document.getElementById('result-type');
                    var resultData = document.getElementById('result-data');

                    function changeResult(type, data) {
                        $("#result-type").val(type);
                        $("#result-data").val(JSON.stringify(data));
                        //resultType.innerHTML = type;
                        //resultData.innerHTML = JSON.stringify(data);
                    }

                    snap.pay(data, {

                        onSuccess: function(result) {
                            changeResult('success', result);
                            console.log(result.status_message);
                            console.log(result);
                            $("#payment-form").submit();
                        },
                        onPending: function(result) {
                            changeResult('pending', result);
                            console.log(result.status_message);
                            $("#payment-form").submit();
                        },
                        onError: function(result) {
                            changeResult('error', result);
                            console.log(result.status_message);
                            $("#payment-form").submit();
                        }
                    });
                }
            });
        });
    });
</script>
<script>
    function hitungTotal() {
        var jumlah = document.getElementById("qty").value;
        var harga = document.getElementById("totalHarga").value;
        var hargaPaket = document.getElementById("hargaPaket").value;

        var tampilHarga = harga * jumlah;
        var hasil = tampilHarga + parseInt(hargaPaket);
        document.getElementById("ongkosPaket").innerHTML = formatRupiah(parseInt(hargaPaket));
        document.getElementById("grandTotal").innerHTML = formatRupiah(hasil);
        document.getElementById("tampilTotal").innerHTML = formatRupiah(parseInt(tampilHarga));
        var selectElemen = document.getElementById("hargaPaket");
        var selectElemen2 = document.getElementById("hargaPaket");


        // Mendapatkan indeks opsi yang dipilih
        var indeksOpsiDipilih = selectElemen.selectedIndex;
        var indeksOpsiDipilih2 = selectElemen2.selectedIndex;

        // Mendapatkan elemen <option> yang dipilih
        var opsiDipilih = selectElemen.options[indeksOpsiDipilih];
        var opsiDipilih2 = selectElemen2.options[indeksOpsiDipilih2];

        // Mendapatkan nilai dari atribut data-nama
        var namaPaket = opsiDipilih.getAttribute("data-paket");
        var etd = opsiDipilih2.getAttribute("data-estimasi");
        console.log(namaPaket);
        document.getElementById("namaPaket").setAttribute("value", namaPaket);
        document.getElementById("estimasiSampe").innerHTML = etd;
    }
</script>

<!--akhir cek ongkir -->



<script>
    /*-------------------
        Quantity change
        --------------------- */
    var proQty = $(".pro-qty");
    proQty.prepend('<span class="dec qtybtn">-</span>');
    proQty.append('<span class="inc qtybtn">+</span>');
    proQty.on("click", ".qtybtn", function() {
        var $button = $(this);
        var oldValue = $button.parent().find("input").val();
        if ($button.hasClass("inc")) {
            var newVal = parseFloat(oldValue) + 1;
        } else {
            // Don't allow decrementing below zero
            if (oldValue > 0) {
                var newVal = parseFloat(oldValue) - 1;
            } else {
                newVal = 0;
            }
        }
        $button.parent().find("input").val(newVal);
    });
</script>
<script>
    $(function() {

        $('input[type="number"]').niceNumber();

    });
</script>

<script>
    function formatRupiah(angka) {
        // Menghilangkan digit desimal
        var formattedNumber = angka.toFixed(2);

        // Menambahkan tanda ribuan dan simbol mata uang
        formattedNumber = Number(formattedNumber).toLocaleString('id-ID', {
            style: 'currency',
            currency: 'IDR',
            minimumFractionDigits: 0,
            maximumFractionDigits: 0
        });

        return formattedNumber;
    }
</script>
<script>
    function formatDesimal(angka) {
        // Menghilangkan digit desimal
        var formattedNumber = angka.toFixed(2);

        // Menambahkan tanda ribuan dan simbol mata uang
        formattedNumber = Number(formattedNumber).toLocaleString('id-ID', {
            // style: 'currency',
            // currency: 'IDR',
            minimumFractionDigits: 0,
            maximumFractionDigits: 0
        });

        return formattedNumber % 1000 + "Kg";
    }
</script>

</body>

</html>