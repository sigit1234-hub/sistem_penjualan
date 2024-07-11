<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link href="https://fonts.googleapis.com/css?family=Lato:300,400,700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

    <link rel="stylesheet" href="<?= base_url('assets/login/') ?>css/style.css">
    <link rel="icon" type="image/png" href="<?= base_url('assets/logo/logo2.png') ?>">
    <title>Sistem Arsip</title>
</head>

<body class="img js-fullheight" style="background-image: url(<?= base_url('assets/login/') ?>images/oke.jpg);">
    <section class="ftco-section">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-6 text-center mb-5">
                    <img src="<?= base_url('assets/logo/logo2.png') ?>" alt="">
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-md-6 col-lg-4">
                    <div class="login-wrap p-0">
                        <h3 class="mb-4 text-center">Selamat datang</h3>
                        <?= $this->session->flashdata('message'); ?>
                        <form <?= base_url('Auth'); ?> method="POST">
                            <div class="form-group">
                                <input type="text" class="form-control" placeholder="Username" id="email" name="email">
                                <?= form_error('email', '<small class="text-warning pl-3">', '</small>'); ?>
                            </div>
                            <div class="form-group">
                                <input id="password-field" type="password" class="form-control" placeholder="Password" id="password" name="password">
                                <span toggle="#password-field" class="fa fa-fw fa-eye field-icon toggle-password"></span>
                                <?= form_error('password', '<small class="text-warning pl-3">', '</small>'); ?>
                            </div>
                            <div class="form-group mt-30">
                                <button type="submit" class="form-control btn btn-primary submit px-3">Masuk</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <div>
        <p class="w-100 text-center">&mdash; Sistem Arsip by Mandiri &mdash;</p>
    </div>

    <script src="<?= base_url('assets/login/') ?>js/jquery.min.js"></script>
    <script src="<?= base_url('assets/login/') ?>js/popper.js"></script>
    <script src="<?= base_url('assets/login/') ?>js/bootstrap.min.js"></script>
    <script src="<?= base_url('assets/login/') ?>js/main.js"></script>

</body>

</html>