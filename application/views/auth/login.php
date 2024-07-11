<!doctype html>
<html class="no-js" lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Login Sistem</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" type="image/png" href="<?= base_url('vendor/template/srtdash/') ?>assets/images/icon/favicon.ico">
    <link rel="stylesheet" href="<?= base_url('vendor/template/srtdash/') ?>assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?= base_url('vendor/template/srtdash/') ?>assets/css/font-awesome.min.css">
    <link rel="stylesheet" href="<?= base_url('vendor/template/srtdash/') ?>assets/css/themify-icons.css">
    <link rel="stylesheet" href="<?= base_url('vendor/template/srtdash/') ?>assets/css/metisMenu.css">
    <link rel="stylesheet" href="<?= base_url('vendor/template/srtdash/') ?>assets/css/owl.carousel.min.css">
    <link rel="stylesheet" href="<?= base_url('vendor/template/srtdash/') ?>assets/css/slicknav.min.css">
    <!-- amchart css -->
    <link rel="stylesheet" href="https://www.amcharts.com/lib/3/plugins/export/export.css" type="text/css" media="all" />
    <!-- others css -->
    <link rel="stylesheet" href="<?= base_url('vendor/template/srtdash/') ?>assets/css/typography.css">
    <link rel="stylesheet" href="<?= base_url('vendor/template/srtdash/') ?>assets/css/default-css.css">
    <link rel="stylesheet" href="<?= base_url('vendor/template/srtdash/') ?>assets/css/styles.css">
    <link rel="stylesheet" href="<?= base_url('vendor/template/srtdash/') ?>assets/css/responsive.css">
    <!-- modernizr css -->
    <script src="<?= base_url('vendor/template/srtdash/') ?>assets/js/vendor/modernizr-2.8.3.min.js"></script>
</head>

<body>
    <!--[if lt IE 8]>
            <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
        <![endif]-->
    <!-- preloader area start -->
    <!-- <div id="preloader">
        <div class="loader"></div>
    </div> -->
    <!-- preloader area end -->
    <!-- login area start -->
    <div class="login-area login-s2">
        <div class="container">
            <div class="login-box ptb--100">
                <form <?= base_url('Auth'); ?> method="POST">
                    <div class="login-form-head">
                        <h4>Sign In</h4>
                        <p>Hello there, Sign in and start managing your Admin Template</p>
                    </div>
                    <?= $this->session->flashdata('message'); ?>
                    <div class="login-form-body">
                        <div class="form-gp">
                            <label for="exampleInputEmail1">Email address</label>
                            <input type="text" id="email" name="email" required>
                            <i class="ti-email"></i>
                            <div class="text-danger"></div>
                        </div>
                        <div class="form-gp">
                            <label for="exampleInputPassword1">Password</label>
                            <input type="password" id="password" name="password" required>
                            <i class="ti-lock"></i>
                            <div class="text-danger"></div>
                        </div>
                        <div class="submit-btn-area" style="color: darkgray;">
                            <button id="form_submit" type="submit">login <i class="ti-arrow-right"></i></button>
                        </div>
                        <!-- <div class="form-footer text-center mt-5">
                            <p class="text-muted">Don't have an account? <a href="register.html">Sign up</a></p>
                        </div> -->
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- login area end -->

    <!-- jquery latest version -->
    <script src="<?= base_url('vendor/template/srtdash/') ?>assets/js/vendor/jquery-2.2.4.min.js"></script>
    <!-- bootstrap 4 js -->
    <script src="<?= base_url('vendor/template/srtdash/') ?>assets/js/popper.min.js"></script>
    <script src="<?= base_url('vendor/template/srtdash/') ?>assets/js/bootstrap.min.js"></script>
    <script src="<?= base_url('vendor/template/srtdash/') ?>assets/js/owl.carousel.min.js"></script>
    <script src="<?= base_url('vendor/template/srtdash/') ?>assets/js/metisMenu.min.js"></script>
    <script src="<?= base_url('vendor/template/srtdash/') ?>assets/js/jquery.slimscroll.min.js"></script>
    <script src="<?= base_url('vendor/template/srtdash/') ?>assets/js/jquery.slicknav.min.js"></script>

    <!-- others plugins -->
    <script src="<?= base_url('vendor/template/srtdash/') ?>assets/js/plugins.js"></script>
    <script src="<?= base_url('vendor/template/srtdash/') ?>assets/js/scripts.js"></script>
</body>

</html>