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
<!-- Footer Section End -->

<!-- Js Plugins -->
<script src="<?= base_url('assets/') ?>js/jquery-3.3.1.min.js"></script>
<script src="<?= base_url('assets/') ?>js/bootstrap.min.js"></script>
<script src="<?= base_url('assets/') ?>js/jquery.nice-select.min.js"></script>
<script src="<?= base_url('assets/') ?>js/jquery-ui.min.js"></script>
<script src="<?= base_url('assets/') ?>js/jquery.slicknav.js"></script>
<script src="<?= base_url('assets/') ?>js/mixitup.min.js"></script>
<script src="<?= base_url('assets/') ?>js/owl.carousel.min.js"></script>
<script src="<?= base_url('assets/') ?>js/main.js"></script>
<script src="<?= base_url('assets/fileuploads/') ?>js/dropify.min.js"></script>
<!-- <script>
    $(".inputKeranjang").on("click", function() {
        <?php if ($this->session->userdata('id') == null) { ?>
            document.location.href = "<?= base_url('Akun') ?>";
        <?php } else { ?>
            const userId = $(this).data("user");
            const produkId = $(this).data("produk");
            $.ajax({
                url: "<?= base_url('Home/inputCart'); ?>",
                type: "post",
                data: {
                    userId: userId,
                    produkId: produkId,
                },
                success: function() {
                    document.location.href = "<?= base_url('Home') ?>";
                },
            });
        <?php } ?>


    });
</script> -->

<script>
    const myStok = document.getElementById("myStok<?= $dis['id_produk'] ?>");

    function stepper(btn) {
        const id = btn.getAttribute("id");
        const min = myStok.getAttribute("min");
        const max = myStok.getAttribute("max");
        const step = myStok.getAttribute("step");
        const val = myStok.getAttribute("value");
        const calcstep = (id == "increment") ? (step * 1) : (step * -1);
        const newValue = parseInt(val) + calcstep;

        if (newValue >= min && newValue <= max) {
            myStok.setAttribute("value", newValue);
        }
        console.log(id, calcstep)
    }
</script>


</body>

</html>