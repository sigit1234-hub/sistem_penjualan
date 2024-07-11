
<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Cronjob extends CI_Controller
{
    public function __construct()
    {
        parent::__construct(); //ini untuk memanggil method construct yang ada di CI_Controller
        // $this->load->library('form_validation');
        // $this->load->model('User_m');
        // $this->load->library('encrypt');
    }
    public function cron_job()
    {
        // ambil data 5tahun
        $sql = "SELECT * FROM produk WHERE stok <= 1000";
        $data['dataStok'] = $this->db->query($sql)->result_array();

        $this->load->view('cron/test', $data);
    }
    public function cekStok()
    {
        // ambil data 5tahun
        // $qty = $_GET['quantity'];
        $sql = "SELECT * FROM produk WHERE stok <= 10";
        $data = $this->db->query($sql);

        if ($data->num_rows() > 0) {
            $this->send_mail($data);
            echo "ada data nih " . $data->num_rows();
        } else {
        }
    }
    public function backup_history()
    {
        $sql = "SELECT * FROM dok_in WHERE date_created <= DATE_SUB(NOW(), INTERVAL 5 YEAR)";
        $data = $this->db->query($sql)->result_array();

        foreach ($data as $d) {
            $isi = ['is_expired' => 1];
            $this->db->where('kode_id', $d['kode_id']);
            $this->db->update('history_dokumen', $isi);
        }
    }
    public function send_mail($data)
    {
        // $sql = "SELECT * FROM produk WHERE stok <= 1000";
        // $data = $this->db->query($sql);

        $config = array(
            'protocol'  => 'smtp',
            'smtp_host' => 'ssl://mail.penjualan.my.id', // Ganti dengan SMTP server Anda
            'smtp_port' => 465, // Port untuk SSL
            'smtp_user' => 'dapurberkah@penjualan.my.id', // Ganti dengan email Anda
            'smtp_pass' => '1234Ganteng#', // Ganti dengan password Anda
            'mailtype'  => 'html',
            'charset'   => 'utf-8',
            'wordwrap'  => TRUE,
            'smtp_timeout' => 30, // Optional: set a timeout for the SMTP connection
            'newline'   => "\r\n",
            'crlf'      => "\r\n",

        );
        $this->email->set_newline("\r\n");
        $this->email->initialize($config);
        $this->load->library('email', $config);
        // $this->email->attach('assets/img/logo/gmi logo.png');
        //mengatur email dikirim dari siapa
        $this->email->from('dapurberkah@penjualan.my.id');

        //kirim kemana
        // $this->email->to('nurohmanoman0511@gmail.com');
        $this->email->cc('ssprasetyo08@gmail.com');

        $this->email->subject('Stok Produk');
        $emailMessage = '<!DOCTYPE html>
        <html lang="en" xmlns="http://www.w3.org/1999/xhtml" xmlns:v="urn:schemas-microsoft-com:vml" xmlns:o="urn:schemas-microsoft-com:office:office">
        
        <head>
            <meta charset="utf-8"> <!-- utf-8 works for most cases -->
            <meta name="viewport" content="width=device-width"> <!-- Forcing initial-scale shouldnt be necessary -->
            <meta http-equiv="X-UA-Compatible" content="IE=edge"> <!-- Use the latest (edge) version of IE rendering engine -->
            <meta name="x-apple-disable-message-reformatting"> <!-- Disable auto-scale in iOS 10 Mail entirely -->
            <title></title> <!-- The title tag shows in email notifications, like Android 4.4. -->
        
            <link href="https://fonts.googleapis.com/css?family=Work+Sans:200,300,400,500,600,700" rel="stylesheet">
        
            <!-- CSS Reset : BEGIN -->
            <style>
                /* What it does: Remove spaces around the email design added by some email clients. */
                /* Beware: It can remove the padding / margin and add a background color to the compose a reply window. */
                html,
                body {
                    margin: 0 auto !important;
                    padding: 0 !important;
                    height: 100% !important;
                    width: 100% !important;
                    background: #f1f1f1;
                }
        
                /* What it does: Stops email clients resizing small text. */
                * {
                    -ms-text-size-adjust: 100%;
                    -webkit-text-size-adjust: 100%;
                }
        
                /* What it does: Centers email on Android 4.4 */
                div[style*="margin: 16px 0"] {
                    margin: 0 !important;
                }
        
                /* What it does: Stops Outlook from adding extra spacing to tables. */
                table,
                td {
                    mso-table-lspace: 0pt !important;
                    mso-table-rspace: 0pt !important;
                }
        
                /* What it does: Fixes webkit padding issue. */
                table {
                    border-spacing: 0 !important;
                    border-collapse: collapse !important;
                    table-layout: fixed !important;
                    margin: 0 auto !important;
                }
        
                /* What it does: Uses a better rendering method when resizing images in IE. */
                img {
                    -ms-interpolation-mode: bicubic;
                }
        
                /* What it does: Prevents Windows 10 Mail from underlining links despite inline CSS. Styles for underlined links should be inline. */
                a {
                    text-decoration: none;
                }
        
                /* What it does: A work-around for email clients meddling in triggered links. */
                *[x-apple-data-detectors],
                /* iOS */
                .unstyle-auto-detected-links *,
                .aBn {
                    border-bottom: 0 !important;
                    cursor: default !important;
                    color: inherit !important;
                    text-decoration: none !important;
                    font-size: inherit !important;
                    font-family: inherit !important;
                    font-weight: inherit !important;
                    line-height: inherit !important;
                }
        
                /* What it does: Prevents Gmail from displaying a download button on large, non-linked images. */
                .a6S {
                    display: none !important;
                    opacity: 0.01 !important;
                }
        
              
                .im {
                    color: inherit !important;
                }
        
                
                img.g-img+div {
                    display: none !important;
                }
        
               
                @media only screen and (min-device-width: 320px) and (max-device-width: 374px) {
                    u~div .email-container {
                        min-width: 320px !important;
                    }
                }
        
                /* iPhone 6, 6S, 7, 8, and X */
                @media only screen and (min-device-width: 375px) and (max-device-width: 413px) {
                    u~div .email-container {
                        min-width: 375px !important;
                    }
                }
        
                /* iPhone 6+, 7+, and 8+ */
                @media only screen and (min-device-width: 414px) {
                    u~div .email-container {
                        min-width: 414px !important;
                    }
                }
            </style>
        
            <!-- CSS Reset : END -->
        
            <!-- Progressive Enhancements : BEGIN -->
            <style>
                .primary {
                    background: #17bebb;
                }
        
                .bg_white {
                    background: #ffffff;
                }
        
                .bg_light {
                    background: #f7fafa;
                }
        
                .bg_black {
                    background: #000000;
                }
        
                .bg_dark {
                    background: rgba(0, 0, 0, .8);
                }
        
                .email-section {
                    padding: 2.5em;
                }
        
                /*BUTTON*/
                .btn {
                    padding: 10px 15px;
                    display: inline-block;
                }
        
                .btn.btn-primary {
                    border-radius: 5px;
                    background: #17bebb;
                    color: #ffffff;
                }
        
                .btn.btn-white {
                    border-radius: 5px;
                    background: #ffffff;
                    color: #000000;
                }
        
                .btn.btn-white-outline {
                    border-radius: 5px;
                    background: transparent;
                    border: 1px solid #fff;
                    color: #fff;
                }
        
                .btn.btn-black-outline {
                    border-radius: 0px;
                    background: transparent;
                    border: 2px solid #000;
                    color: #000;
                    font-weight: 700;
                }
        
                .btn-custom {
                    color: rgba(0, 0, 0, .3);
                    text-decoration: underline;
                }
        
                h1,
                h2,
                h3,
                h4,
                h5,
                h6 {
                    font-family: "Work Sans", sans-serif;
                    color: #000000;
                    margin-top: 0;
                    font-weight: 400;
                }
        
                body {
                    font-family: "Work Sans", sans-serif;
                    font-weight: 400;
                    font-size: 15px;
                    line-height: 1.8;
                    color: rgba(0, 0, 0, .4);
                }
        
                a {
                    color: #17bebb;
                }
        
                table {}
        
                /*LOGO*/
        
                .logo h1 {
                    margin: 0;
                }
        
                .logo h1 a {
                    color: #17bebb;
                    font-size: 24px;
                    font-weight: 700;
                    font-family: "Work Sans", sans-serif;
                }
        
                /*HERO*/
                .hero {
                    position: relative;
                    z-index: 0;
                }
        
                .hero .text {
                    color: rgba(0, 0, 0, .3);
                }
        
                .hero .text h2 {
                    color: #000;
                    font-size: 34px;
                    margin-bottom: 15px;
                    font-weight: 300;
                    line-height: 1.2;
                }
        
                .hero .text h3 {
                    font-size: 24px;
                    font-weight: 200;
                }
        
                .hero .text h2 span {
                    font-weight: 600;
                    color: #000;
                }
        
        
                /*PRODUCT*/
                .product-entry {
                    display: block;
                    position: relative;
                    float: left;
                    padding-top: 20px;
                }
        
                .product-entry .text {
                    width: calc(100% - 125px);
                    padding-left: 20px;
                }
        
                .product-entry .text h3 {
                    margin-bottom: 0;
                    padding-bottom: 0;
                }
        
                .product-entry .text p {
                    margin-top: 0;
                }
        
                .product-entry img,
                .product-entry .text {
                    float: left;
                }
        
                ul.social {
                    padding: 0;
                }
        
                ul.social li {
                    display: inline-block;
                    margin-right: 10px;
                }
        
                /*FOOTER*/
        
                .footer {
                    border-top: 1px solid rgba(0, 0, 0, .05);
                    color: rgba(0, 0, 0, .5);
                }
        
                .footer .heading {
                    color: #000;
                    font-size: 20px;
                }
        
                .footer ul {
                    margin: 0;
                    padding: 0;
                }
        
                .footer ul li {
                    list-style: none;
                    margin-bottom: 10px;
                }
        
                .footer ul li a {
                    color: rgba(0, 0, 0, 1);
                }
        
        
                @media screen and (max-width: 500px) {}
            </style>
        
        
        </head>
        
        <body width="100%" style="margin: 0; padding: 0 !important; mso-line-height-rule: exactly; background-color: #f1f1f1;">
            <center style="width: 100%; background-color: #f1f1f1;">
                <div style="display: none; font-size: 1px;max-height: 0px; max-width: 0px; opacity: 0; overflow: hidden; mso-hide: all; font-family: sans-serif;">
                    &zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;
                </div>
                <div style="max-width: 600px; margin: 0 auto;" class="email-container">
                    <!-- BEGIN BODY -->
                    <table align="center" role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%" style="margin: auto;">
                        <tr>
                            <td valign="top" class="bg_white" style="padding: 1em 2.5em 0 2.5em;">
                                <table role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%">
                                    <tr>
                                        <td class="logo" style="text-align: left;">
                                            <img src="https://penjualan.my.id/assets/img/dapur.png" alt="" width="100" style="height:auto;display:block; margin:40px" />
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr><!-- end tr -->
                        <tr>
                            <td valign="middle" class="hero bg_white" style="padding: 2em 0 2em 0;">
                                <table role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%">
                                    <tr>
                                        <td style="padding: 0 2.5em; text-align: left;">
                                            <div class="text">
                                                <h2>Halo admin CV Dapur Berkah</h2>
                                                <p>Berikut daftar produk-produk dengan stok dibawah 10 per tanggal : ' . tanggal() . '</p>
                                            </div>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr><!-- end tr -->
                        <tr>
                            <table class="bg_white" role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%">
                                <tr style="border-bottom: 1px solid rgba(0,0,0,.05);">
                                    <th width="80%" style="text-align:left; padding: 0 2.5em; color: #000; padding-bottom: 20px">Produk</th>
                                    <th width="20%" style="text-align:right; padding: 0 2.5em; color: #000; padding-bottom: 20px">Stok</th>
                                </tr>';
        foreach ($data->result_array()  as $dt) :
            $emailMessage .= '
                                <tr style="border-bottom: 1px solid rgba(0,0,0,.05);">
                                    <td valign="middle" width="80%" style="text-align:left; padding: 0 2.5em;">
                                        <div class="product-entry">
                                            <img src="https://penjualan.my.id/assets/img/produk/' . gambar($dt['kode_produk']) . '" alt="" style="width: 100px; max-width: 600px; height: auto; margin-bottom: 20px; display: block;">
                                            <div class="text">
                                                <h3>' . $dt["nama_produk"] . '</h3>
                                                <span>' . $dt["kode_produk"] . '</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td valign="middle" width="20%" style="text-align:left; padding: 0 2.5em;">
                                        <span class="price" style="color: #000; font-size: 20px;">' . $dt['stok'] . '</span>
                                    </td>
                                    </tr>';
        endforeach;
        $emailMessage .= '
                                <tr>
                                    <td valign="middle" style="text-align:left; padding: 1em 2.5em;">
                                        <p><a href="https://penjualan.my.id/Admin/produk" class="btn btn-primary">Buka Halaman Admin</a></p>
                                    </td>
                                </tr>
                            </table>
                        </tr><!-- end tr -->
                        <!-- 1 Column Text + Button : END -->
                    </table>
                    <table align="center" role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%" style="margin: auto;">
                        <tr>
                            <td valign="middle" class="bg_light footer email-section">
                                <table>
                                    <tr>
                                        <td valign="top" width="50%" style="padding-top: 20px;">
                                            <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%">
                                                <tr>
                                                    <td style="text-align: left; padding-right: 10px;">
                                                        <h3 class="heading">Alamat</h3>
                                                        <p>
                                                            Alamat : Dusun kemutug RT 2 RW 1 desa tirip, kec Wadaslintang kab Wonosobo</br>
                                                            Telpone / Whatsapp : +62 821-3507-6353</br>
                                                            Email: admin@dapurberkah.my.id</br>
                                                        </p>
                                                    </td>
                                                </tr>
                                            </table>
                                        </td>
                                        <td valign="top" width="50%" style="padding-top: 20px;">
                                            <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%">
                                                <tr>
                                                    <td style="text-align: left; padding-left: 10px;">
                                                        <h3 class="heading">Useful Links</h3>
                                                        <ul>
                                                            <li><a href="https://penjualan.my.id/">Home</a></li>
                                                            <li><a href="https://penjualan.my.id/Akun">Akun</a></li>
                                                            <li><a href="https://penjualan.my.id/Belanja">Belanja</a></li>
                                                            <li><a href="https://penjualan.my.id/Admin">Admin</a></li>
                                                        </ul>
                                                    </td>
                                                </tr>
                                            </table>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr><!-- end: tr -->
                        <tr>
                            <td class="bg_white" style="text-align: center;">
                                <p>No longer want to receive these email? You can <a href="#" style="color: rgba(0,0,0,.8);">Unsubscribe here</a></p>
                            </td>
                        </tr>
                    </table>
        
                </div>
            </center>
        </body>
        
        </html>';
        $this->email->message($emailMessage);

        if ($this->email->send()) {
            return true;
        } else {
            echo $this->email->print_debugger();
            die;
        }
    }
}
?>