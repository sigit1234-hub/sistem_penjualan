<!-- Footer Section Begin -->
<footer class="footer spad">
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
<!-- Js Plugins -->
<script src="<?= base_url('assets/') ?>js/jquery-3.3.1.min.js"></script>
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
    fetch(`https://kanglerian.github.io/api-wilayah-indonesia/api/provinces.json`)
        .then((response) => response.json())
        .then((provinces) => {
            var dataPro = provinces;
            $.ajax({
                url: "<?= base_url('Belanja/dataAlamatUser') ?>",
                type: "GET",
                dataType: "json",
                success: function(data) {
                    fetch(
                            `https://kanglerian.github.io/api-wilayah-indonesia/api/province/` +
                            data["provinsi"] +
                            `.json`
                        )
                        .then((response) => response.json())
                        .then((proKu) => {
                            var tampungPro =
                                `<option data-pro="` +
                                proKu.id +
                                `" value="` +
                                proKu.id +
                                `">` +
                                proKu.name +
                                `</option>`;
                            dataPro.forEach((element) => {
                                tampungPro += `<option data-pro="${element.id}" value="${element.id}">${element.name}</option>`;
                            });
                            document.getElementById("lengkap").value = data["lengkap"];
                            document.getElementById("patokan").value = data["patokan"];
                            document.getElementById("provinsi").innerHTML = tampungPro;
                        });
                    fetch(
                            `https://kanglerian.github.io/api-wilayah-indonesia/api/regency/` +
                            data["kota"] +
                            `.json`
                        )
                        .then((response) => response.json())
                        .then((proKu) => {
                            var tampungPro =
                                `<option data-reg="` +
                                proKu.id +
                                `" value="` +
                                proKu.id +
                                `">` +
                                proKu.name +
                                `</option>`;

                            document.getElementById("kota").innerHTML = tampungPro;
                        });
                    fetch(
                            `https://kanglerian.github.io/api-wilayah-indonesia/api/district/` +
                            data["kecamatan"] +
                            `.json`
                        )
                        .then((response) => response.json())
                        .then((proKu) => {
                            var tampungPro =
                                `<option data-dist="` +
                                proKu.id +
                                `" value="` +
                                proKu.id +
                                `">` +
                                proKu.name +
                                `</option>`;

                            document.getElementById("kecamatan").innerHTML = tampungPro;
                        });
                    fetch(
                            `https://kanglerian.github.io/api-wilayah-indonesia/api/village/` +
                            data["desa"] +
                            `.json`
                        )
                        .then((response) => response.json())
                        .then((proKu) => {
                            var tampungPro =
                                `<option data-vill="` +
                                proKu.id +
                                `" value="` +
                                proKu.id +
                                `">` +
                                proKu.name +
                                `</option>`;

                            document.getElementById("desa").innerHTML = tampungPro;
                        });
                },
            });
        });
</script>
<script>
    // provinsi

    fetch(`https://kanglerian.github.io/api-wilayah-indonesia/api/provinces.json`)
        .then((response) => response.json())
        .then((provinces) => {
            var dataPro = provinces;
            var tampungPro = "<option >-Pilih-</option>";
            dataPro.forEach((element) => {
                tampungPro += `<option data-pro="${element.id}" value="${element.id}">${element.name}</option>`;
            });
            document.getElementById("provinsi").innerHTML = tampungPro;
        });

    // kabupaten
    const selectPro = document.getElementById("provinsi");

    selectPro.addEventListener("change", (e) => {
        var pro = e.target.options[e.target.selectedIndex].dataset.pro;
        fetch(
                `https://kanglerian.github.io/api-wilayah-indonesia/api/regencies/${pro}.json`
            )
            .then((response) => response.json())
            .then((regencies) => {
                var dataPro = regencies;

                var tampungPro = "<option>-Pilih-</option>";
                dataPro.forEach((element) => {
                    tampungPro += `<option data-reg="${element.id}" value="${element.id}">${element.name}</option>`;
                });
                document.getElementById("kota").innerHTML = tampungPro;
            });
    });
</script>
<script>
    //kecamatan
    const selectKota = document.getElementById("kota");

    selectKota.addEventListener("change", (e) => {
        var kota = e.target.options[e.target.selectedIndex].dataset.reg;
        fetch(
                `https://kanglerian.github.io/api-wilayah-indonesia/api/districts/${kota}.json`
            )
            .then((response) => response.json())
            .then((districts) => {
                var dataPro = districts;

                var tampungPro = "<option>-Pilih-</option>";
                dataPro.forEach((element) => {
                    tampungPro += `<option data-dist="${element.id}" value="${element.id}">${element.name}</option>`;
                });
                document.getElementById("kecamatan").innerHTML = tampungPro;
            });
    });
</script>
<script>
    //kelurahan
    const selectKelu = document.getElementById("kecamatan");

    selectKelu.addEventListener("change", (e) => {
        var kec = e.target.options[e.target.selectedIndex].dataset.dist;
        fetch(
                `https://kanglerian.github.io/api-wilayah-indonesia/api/villages/${kec}.json`
            )
            .then((response) => response.json())
            .then((villages) => {
                var dataPro = villages;

                var tampungPro = "<option>-Pilih-</option>";
                dataPro.forEach((element) => {
                    tampungPro += `<option value="${element.id}">${element.name}</option>`;
                });
                document.getElementById("desa").innerHTML = tampungPro;
            });
    });
</script>
<script>
    function cekOngkir() {
        var xmlhttp = new XMLHttpRequest();

        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("hasil").innerHTML = this.responseText;
            }
        };
        xmlhttp.open(
            "GET",
            "http://localhost/sistem_penjualan/Belanja/reqOngkos?kotaAsal=37&kotaTujuan=275&berat=1000&kurir=jne"
        );
        xmlhttp.send();
    }
</script>


</body>

</html>