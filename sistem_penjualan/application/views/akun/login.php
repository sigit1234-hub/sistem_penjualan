<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login</title>

    <!-- Font Icon -->
    <link rel="stylesheet" href="<?= base_url('vendor/login/') ?>fonts/material-icon/css/material-design-iconic-font.min.css">

    <!-- Main css -->
    <link rel="stylesheet" href="<?= base_url('vendor/login/') ?>css/style.css">
</head>

<body>
    <!-- <div class="main"> -->
    <div class="container">
        <div class="humberger__menu__logo" style="padding-top:30px; padding-left:40px;">
            <a href="<?= base_url('Home') ?>"><img src="<?= base_url('assets/') ?>img/dapur.png" alt=""></a>
        </div>
        <div class="signup-content">
            <div class="signin-image">
                <figure><img src="<?= base_url('vendor/login/') ?>images/signin-image.jpg" alt="sing up image">
                </figure>
                <a href="<?= base_url('Akun/registrasi') ?>" class="signup-image-link">Saya belum terdaftar</a>
            </div>
            <div class="signin-form">
                <h2 class="form-title">Masuk</h2>
                <?= $this->session->flashdata('message'); ?>
                <form method="POST" class="register-form" id="login-form" action="<?= base_url('Akun') ?>">
                    <div class="form-group">
                        <label for="your_name"><i class="zmdi zmdi-account material-icons-name"></i></label>
                        <input type="text" name="email" id="email" placeholder="Email" />
                        <?= form_error('email', '<small class="text-danger pl-3">', '</small>') ?>
                    </div>
                    <div class="form-group">
                        <label for="your_pass"><i class="zmdi zmdi-lock"></i></label>
                        <input type="password" name="password" id="password" placeholder="Kata sandi" />
                        <?= form_error('password', '<small class="text-danger pl-3">', '</small>') ?>
                    </div>
                    <div class="form-group form-button">
                        <input type="submit" name="signin" id="signin" class="form-submit" value="Masuk" />
                    </div>
                </form>
            </div>
        </div>
    </div>

    </div>
    <!-- </div> -->


    <!-- JS -->
    <script src="<?= base_url('vendor/login/') ?>vendor/jquery/jquery.min.js"></script>
    <script src="<?= base_url('vendor/login/') ?>js/main.js"></script>
</body><!-- This templates was made by Colorlib (https://colorlib.com) -->

</html>