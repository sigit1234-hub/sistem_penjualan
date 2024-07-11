<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Registrasi</title>

    <!-- Font Icon -->
    <link rel="stylesheet" href="<?= base_url('vendor/login/') ?>fonts/material-icon/css/material-design-iconic-font.min.css">

    <!-- Main css -->
    <link rel="stylesheet" href="<?= base_url('vendor/login/') ?>css/style.css">
</head>

<body>
    <div class="container">
        <div class="humberger__menu__logo" style="padding-top:30px; padding-left:40px;">
            <a href="<?= base_url('Home') ?>"><img src="<?= base_url('assets/') ?>img/dapur.png" alt=""></a>
        </div>
        <div class="signup-content">
            <div class="signup-form">
                <h2 class="form-title">Daftar Akun</h2>
                <form method="POST" class="register-form" action="<?= base_url('Auth/registrasi') ?>" id="register-form">
                    <div class="form-group">
                        <label for="name"><i class="zmdi zmdi-account material-icons-name"></i></label>
                        <input type="text" name="name" id="name" placeholder="Nama lengkap" />
                        <?= form_error('name', '<small class="text-danger pl-3">', '</small>') ?>
                    </div>
                    <div class="form-group">
                        <label for="email"><i class="zmdi zmdi-email"></i></label>
                        <input type="email" name="email" id="email" placeholder="Email" />
                        <?= form_error('email', '<small class="text-danger pl-3">', '</small>') ?>
                    </div>
                    <div class="form-group">
                        <label for="pass"><i class="zmdi zmdi-lock"></i></label>
                        <input type="password" name="password1" id="password1" placeholder="Kata sandi" />
                        <?= form_error('password1', '<small class="text-danger pl-3">', '</small>') ?>
                    </div>
                    <div class="form-group">
                        <label for="re-pass"><i class="zmdi zmdi-lock-outline"></i></label>
                        <input type="password" name="password2" id="password2" placeholder="Ulangi kata sandi" />
                        <?= form_error('password2', '<small class="text-danger pl-3">', '</small>') ?>
                    </div>
                    <div class="form-group form-button">
                        <input type="submit" name="signup" id="signup" class="form-submit" value="Daftar" />
                    </div>
                </form>
            </div>
            <div class="signup-image">
                <figure><img src="<?= base_url('vendor/login/') ?>images/signup-image.jpg" alt="sing up image">
                </figure>
                <a href="<?= base_url('Auth') ?>" class="signup-image-link">Saya sudah punya akun</a>
            </div>
        </div>
    </div>
    <!-- JS -->
    <script src="<?= base_url('vendor/login/') ?>vendor/jquery/jquery.min.js"></script>
    <script src="<?= base_url('vendor/login/') ?>js/main.js"></script>
</body><!-- This templates was made by Colorlib (https://colorlib.com) -->

</html>