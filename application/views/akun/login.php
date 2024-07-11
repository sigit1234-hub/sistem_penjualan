<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login</title>
    <link rel="icon" type="image/png" href="<?= base_url('assets/img/dapur.png') ?>">
    <!-- Font Icon -->
    <link rel="stylesheet" href="<?= base_url('vendor/login/') ?>fonts/material-icon/css/material-design-iconic-font.min.css">
    <link rel="stylesheet" href="<?= base_url('assets/') ?>css/bootstrap.min.css" type="text/css">
    <!-- Main css -->
    <link rel="stylesheet" href="<?= base_url('vendor/login/') ?>css/style.css">
</head>

<body>
    <div class="main">
        <div class="container">
            <div class="humberger__menu__logo" style="margin-top:30px; padding-left:40px;">
                <a href="<?= base_url('Home') ?>"><img src="<?= base_url('assets/') ?>img/dapur.png" alt=""></a>
            </div>
            <div class="signup-content" style="padding-left:30%">
                <div class="signin-image">
                    <figure><img src="<?= base_url('vendor/login/') ?>images/signin-image.jpg" alt="sing up image">
                    </figure>
                    <a href="<?= base_url('Auth/registrasi') ?>" class="signup-image-link">Saya belum terdaftar</a>
                </div>

                <div class="signin-form">
                    <h2 class="form-title">Masuk </h2>
                    <p><?php $link = $this->session->userdata('link');
                        $url = explode("/", $link);
                        $juml = count($url);
                        $direct = '';
                        for ($a = 4; $a < $juml; $a++) {
                            $direct .= $url[$a] . "/";
                        }
                        echo "<br>" . $direct;
                        ?></p>
                    <?= $this->session->flashdata('message'); ?>
                    <form method="POST" class="register-form" id="login-form" action="<?= base_url('Auth') ?>">
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
                            <input type="submit" name="signin" id="signin" class="form-submit btn btn-block" value="Masuk" />
                            <a href="" class="orm-submit btn btn-block btn-gray">Lupa Password</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>
    </div>


    <!-- JS -->
    <script src="<?= base_url('vendor/login/') ?>vendor/jquery/jquery.min.js"></script>
    <script src="<?= base_url('vendor/login/') ?>js/main.js"></script>
</body><!-- This templates was made by Colorlib (https://colorlib.com) -->

</html>