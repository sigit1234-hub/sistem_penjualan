<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Auth extends CI_Controller
{
    public function __construct()
    {
        parent::__construct(); //ini untuk memanggil method construct yang ada di CI_Controller
        $this->load->library('form_validation');
        $this->load->model('User_m');
        // is_logged_in();
    }
    public function index()
    {
        $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email|valid_emails');
        $this->form_validation->set_rules('password', 'Password', 'required|trim');
        if ($this->form_validation->run() == false) {
            $data['title'] = 'Login Page';
            $this->load->view('akun/login', $data);
        } else {
            $this->_login();
        }
    }
    public function email()
    {
        $this->load->view('email');
    }
    private function _login()
    {
        //mengambil data yang diinput user
        $email = htmlspecialchars($this->input->post('email'));
        $password = htmlspecialchars($this->input->post('password'));
        $user = $this->db->get_where('user', ['email' => $email])->row_array();
        //jika usernya ada
        if ($user) {
            //jika usernya aktif
            if ($user['is_active'] == 1) {
                //cek password
                if (password_verify($password, $user['password'])) {
                    $data = [
                        'id' => $user['id'],
                        'email' => $user['email'],
                        'tlp' => $user['tlp'],
                        'role_id' => $user['role_id']
                    ];
                    $this->session->set_userdata($data);
                    if ($this->session->userdata('link')) {
                        $link = $this->session->userdata('link');
                        $url = explode("/", $link);
                        $juml = count($url);
                        $direct = '';
                        for ($a = 4; $a < $juml; $a++) {
                            $direct .= $url[$a] . "/";
                        }
                        // $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
                        // ' . $direct . '</div>');
                        $this->session->unset_userdata('link');
                        redirect($direct);
                    } else {

                        if ($user['role_id'] == 1) {
                            redirect('Admin');
                        } else if ($user['role_id'] == 3) {
                            redirect('Kasir');
                        } else {
                            redirect('Home');
                        }
                    }
                } else {
                    $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
                    Password Salah!!</div>');
                    redirect('Auth');
                }
            } else {
                $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
               Email Belum Terverifikasi</div>');
                redirect('Auth');
            }
        } else {
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
            Email Belum Terdaftar</div>');
            redirect('Auth');
        }
    }
    public function registrasi()
    {
        if ($this->session->userdata('id')) {
            $this->blocked();
        } else {
            $data['halaman'] = "Akun Saya";
            $data['judul'] = $this->uri->segment(1);
            $data['title'] = 'User Registration';
            //set aturan untuk fieldnya
            $this->form_validation->set_rules('name', 'Name', 'required|trim'); // name= nama di file registrasi | Name nama alis nya | required= syntak agar di field tidak boleh kosong | trim =syntak agar di field tidak ada sepasi
            $this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email|is_unique[user.email]', [
                'is_unique' => 'Email sudah ada!'
            ]); //valid email adalah agar format seperti email seharusnya
            //is_unique = untuk mengecek apakah sudah ada data yang sama di db [name-table.name-field]
            $this->form_validation->set_rules('password1', 'Password', 'required|trim|min_length[8]|matches[password2]', [
                'matches' => 'Password tidak sama!',
                'min_length' => 'Password min 8 karakter'
                //setting pesan errornya
                //min_lenght = batas min password|matches untuk menyamakan dengan pass2
            ]);
            $this->form_validation->set_rules('password2', 'Password', 'required|trim|matches[password1]');
            if ($this->form_validation->run() == false) {
                $this->load->view('akun/registrasi', $data);
            } else {
                $email = htmlspecialchars($this->input->post('email', true));
                $password = htmlspecialchars($this->input->post('password1', true));
                $data = [
                    'nama' => htmlspecialchars($this->input->post('name', true)),
                    //name = nama di db selanjutnya ngambil di inputan berupa nama method=post trus nama fieldnya name
                    'email' => $email,
                    'foto' => 'default.png',
                    'password' => password_hash($password, PASSWORD_DEFAULT),
                    'role_id' => 2,
                    // 2 untuk member
                    'is_active' => 0,
                    // karna biar posisi aktif 0 untuk non aktif
                    'date_created' => time()
                ];
                //token untuk verifikasi
                // $token = base64_encode(random_bytes(32)); //32 =parameter(dari fungsi php)| base_encode = code utk menterjemahkan si tandom_bytes tsb
                $token = mt_rand(100000, 999999);
                $user_token = [
                    'email' => $email,
                    'token' => $token,
                    'date_created' => time() //kapan token dibuat
                ];
                // //memasukan data ke db
                $this->db->insert('user', $data);
                $this->db->insert('user_token', $user_token);
                // insert(nama table, datanya yang akan dimasukkan mana)
                //kirim email
                $this->_sendEmail($token, 'verify', $email);
                $this->session->set_flashdata('message', '<div class="alert alert-success text-center" role="alert">
           Selamat, akun anda berhasil di buat, Silahkan masukkan kode Aktivasi
          </div>');
                redirect('Auth/verify?email=' . $email);
            }
        }
    }
    public function _sendEmail($token, $type, $email)
    {
        $config = array();
        $config['protocol'] = 'smtp';
        $config['smtp_host'] = 'ssl://mail.penjualan.my.id';
        $config['smtp_user'] = 'dapurberkah@penjualan.my.id';
        $config['smtp_pass'] = '1234Ganteng#';
        $config['smtp_port'] = 465;
        $config['mailtype'] = 'html';
        $config['charset'] = 'utf-8';
        $this->email->set_newline("\r\n");
        $this->email->initialize($config);
        $this->load->library('email', $config);
        // $this->email->attach('assets/img/logo/gmi logo.png');
        //mengatur email dikirim dari siapa
        $this->email->from('dapurberkah@penjualan.my.id');

        //kirim kemana
        $this->email->to($email);
        // $this->email->to('ssprasetyo08@gmail.com');

        $this->email->subject('verifikasi Email');
        $this->email->message('
        
        <body>
            <table style="width:100%;border-collapse:collapse;border:0;border-spacing:0;background:#fff; ">
                <tr>
                    <td align="center" style="padding:0;">
                        <table style="width:602px;border-collapse:collapse;border:1px solid #cccccc;border-spacing:0;text-align:left;" align="center">
                            <tr style="margin: 40px;">
                                <td>
                                    <img src="https://penjualan.my.id/assets/img/dapur.png" alt="" width="100" style="height:auto;display:block; margin:40px" />
                                </td>
                            </tr>
                            <tr>
                                <td style="padding:36px 30px 42px 30px;">
                                    <table style="width:100%;border-collapse:collapse;border:0;border-spacing:0;">
                                        <tr>
                                            <td style="padding:0 0 36px 0;color:#153643;">
                                                <h1 style="font-size:24px;margin:0 0 20px 0;font-family:Arial,sans-serif;">Aktivasi Akun</h1>
                                                <p style="margin:0 0 12px 0;font-size:16px;line-height:24px;font-family:Arial,sans-serif;">Halo</b></p>
                                                <p>Berikut ini adalah kota aktivasi untuk email ' . $email . '</p>
                                                                                                <h3 align="center">' . $token . '</h3>
                                            </td>
                                        </tr>
                                        </table>
                                </td>
                            </tr>
                            <tr align="right" style="padding:40px 0 30px 0;background:#7FAD39; ">
                                <td>
                                    <P style="margin:10px">Hak Cipta @ CV Dapur Berkah</P>
                                </td>
                            </tr>
        
                        </table>
                    </td>
                </tr>
            </table>
    ');

        if ($this->email->send()) {
            return true;
        } else {
            echo $this->email->print_debugger();
            die;
        }
    }
    public function resetpassword() //untuk mengecek apakah ada email untuk direset
    {
        $email = $this->input->get('email');
        $token = $this->input->get('token'); //cek email dan token di db
        $user = $this->db->get_where('user', ['email' => $email])->row_array();
        if ($user) {
            $user_token = $this->db->get_where('user_token', ['token' => $token])->row_array();
            if ($user_token) {
                // if (time() - $user_token['date_created'] < (60 * 60 * 24)) { //sehari
                //     $this->db->set('is_active', 1); //bisa di baca set tabel is_active dan diisi dengan 1
                //     $this->db->where('email', $email);
                //     $this->db->update('user');
                //     //hapus token yang ada di tabel user_token
                //     $this->db->delete('user_token', ['email' => $email]); //hapus pada table user_token yang isinya email yang sama dengan $email
                //     //session untuk halaman forgot email
                $this->session->set_userdata('reset_email', $email);
                $this->changePassword(); //karena kepanjangan di lanjut ke publik function changePassword
            } else {
                $this->session->set_flashdata('message', '<div class="alert alert-danger text-center" role="alert">Reset password failed! Wrong token!</div>');
                redirect('auth');
            }
        } else {
            $this->session->set_flashdata('message', '<div class="alert alert-danger text-center" role="alert">Reset Password failed!</div>');
            redirect('auth');
        }
    }
    public function changePassword()
    {
        //set agar tidak bisa diakses tanpa melalui email
        if (!$this->session->userdata('reset_email')) {
            redirect('auth');
        }
        $this->form_validation->set_rules('password1', 'Password', 'required|trim|min_length[6]|matches[password2]');
        $this->form_validation->set_rules('password2', 'Repeat Password', 'required|trim|min_length[6]|matches[password1]');
        if ($this->form_validation->run() == false) {
            $data['title'] = 'Change Password';
            $this->load->view('template/auth_header', $data);
            $this->load->view('auth/change-password');
            $this->load->view('template/auth_footer');
        } else {
            $password = password_hash($this->input->post('password1'), PASSWORD_DEFAULT);
            $email = $this->session->userdata('reset_email');
            $this->db->set('password', $password);
            $this->db->where('email', $email);
            $this->db->update('user');
            $this->session->unset_userdata('reset_email');
            $this->session->set_flashdata('message', '<div class="alert alert-success text-center" role="alert">Password has been changed, Please login!</div>');
            redirect('auth');
        }
    }
    //tambahan

    public function verify()
    {
        $this->form_validation->set_rules('token', 'Token', 'required|trim');
        if ($this->form_validation->run() == false) {
            $data['title'] = 'Login Page';
            $this->load->view('akun/verifikasi', $data);
        } else {
            $email = $this->input->post('email');
            $token = $this->input->post('token');
            //ambil email dan token di url
            //cek email valid
            $user = $this->db->get_where('user', ['email' => $email])->row_array();
            if ($user) {
                $user_token = $this->db->get_where('user_token', ['token' => $token])->row_array();
                if ($user_token) {
                    //set waktu aktifasi
                    if (time() - $user_token['date_created'] < (60 * 60 * 24)) { //sehari
                        $this->db->set('is_active', 1); //bisa di baca set tabel is_active dan diisi dengan 1
                        $this->db->where('email', $email);
                        $this->db->update('user');
                        //hapus token yang ada di tabel user_token
                        $this->db->delete('user_token', ['email' => $email]); //hapus pada table user_token yang isinya email yang sama dengan $email
                        $this->session->set_flashdata('message', '<div class="alert alert-success text-center" role="alert">
                    ' . $email . ' Email anda berhasil diverifikasi, silahkan login!
                  </div>');
                        redirect('Auth');
                    } else {
                        //hapus user jika token expired / berhasil di aktifasi
                        $this->db->delete('user', ['email' => $email]);
                        $this->db->delete('user_token', ['email' => $email]);
                        $this->session->set_flashdata('message', '<div class="alert alert-danger text-center" role="alert">
        token expires!
      </div>');
                        redirect('Auth/verify?email=' . $email . '');
                    }
                } else {
                    $this->session->set_flashdata('message', '<div class="alert alert-danger text-center" role="alert">
        Verifikasi email gagal!, token anda salah!
      </div>');
                    redirect('Auth/verify?email=' . $email . '');
                }
            } else {
                $this->session->set_flashdata('message', '<div class="alert alert-danger text-center" role="alert">
            Verifikasi email gagal!, email anda salah!
      </div>');
                redirect('Auth');
            }
        }
    }
    public function logout()
    {
        $this->session->unset_userdata('email');
        $this->session->unset_userdata('role_id');
        $this->session->unset_userdata('id');
        $this->session->unset_userdata('tlp');
        $this->session->unset_userdata('link');
        $this->session->set_flashdata('message', '<div class="text-center text-center" role="alert">
            Anda berhasil keluar!
          </div>');
        redirect('Home');
    }
    public function forgotPassword()
    {
        $this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email');
        if ($this->form_validation->run() == false) {
            $data['title'] = 'Forgot Password';
            $this->load->view('template/auth_header', $data);
            $this->load->view('auth/forgot-password');
            $this->load->view('template/auth_footer');
        } else {
            $email = $this->input->post('email');
            $user = $this->db->get_where('user', ['email' => $email, 'is_active' => 1])->row_array(); //atau is-active = 1 jadi ada dua kondisi
            if ($user) { //buat token lagi untuk link registrasi
                $token = base64_encode(random_bytes(32));
                $user_token = [
                    'email' => $email,
                    'token' => $token,
                    'date_created' => time()
                ];
                $this->db->insert('user_token', $user_token);
                $this->_sendEmail($token, 'forgot'); //parameter dan token
                $this->session->set_flashdata('message', '<div class="alert alert-success text-center" role="alert">Please check your email to reset password!</div>');
                redirect('auth/forgotpassword');
            } else {
                $this->session->set_flashdata('message', '<div class="alert alert-danger text-center" role="alert">Email is not registered or active!</div>');
                redirect('auth/forgotpassword');
            }
        }
    }
    public function blocked()
    {
        $this->load->view('akun/block');
    }
}
