<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Auth extends CI_Controller
{
    public function __construct()
    {
        parent::__construct(); //ini untuk memanggil method construct yang ada di CI_Controller
        $this->load->library('form_validation');
        $this->load->model('User_m');
    }
    public function index()
    {
        $data['user'] = $this->db->get_where('karyawan', ['username' => $this->session->userdata('username')])->row_array();
        // if ($this->session->userdata('email')) {
        //     redirect('auth');
        // }
        $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email|valid_emails');
        $this->form_validation->set_rules('password', 'Password', 'required|trim');
        if ($this->form_validation->run() == false) {
            $data['title'] = 'Login Page';
            $this->load->view('template/login', $data);
        } else {
            $this->_login();
        }
    }
    private function _login()
    {
        //mengambil data yang diinput user
        $username = $this->input->post('email');
        $password = $this->input->post('password');
        $user = $this->db->get_where('karyawan', ['email' => $username])->row_array();

        if ($user) {
            if ($user['is_active'] == 1) {
                //cek password
                if ($password == $user['password']) {
                    $data = [
                        'id' => $user['id'],
                        'email' => $user['email'],
                        'username' => $user['username'],
                        'role_id' => $user['role_id']
                    ];
                    $this->session->set_userdata($data);
                    $this->session_active($user['id']);
                    if ($user['role_id'] == 4) {
                        redirect('Loket/dashboard');
                    }
                    if ($user['role_id'] == 12) {
                        $this->session->set_flashdata('sweet', '<div  id="sa-basic">
                    Password salah!</div>');
                        redirect('Spb');
                    }
                    if ($user['role_id'] == 15) {
                        $this->session->set_flashdata('sweet', '<div  id="sa-basic">
                    Password salah!</div>');
                        redirect('Csr');
                    }
                    if ($user['role_id'] == 16) {
                        $this->session->set_flashdata('sweet', '<div  id="sa-basic">
                    Password salah!</div>');
                        redirect('Itr');
                    }
                    if ($user['role_id'] == 18) {
                        $this->session->set_flashdata('sweet', '<div  id="sa-basic">
                    Password salah!</div>');
                        redirect('Ccm');
                    } else {
                        $this->session->set_flashdata('sweet', '<div  id="sa-basic">
                    Password salah!</div>');
                        redirect('Loket/dashboard');
                    }
                } else {
                    $this->session->set_flashdata('message', '<div class="alert alert-danger text-center" role="alert">
                    Password salah!!</div>');
                    redirect('Auth');
                }
            } else {
                $this->session->set_flashdata('sweet', '<div class="alert alert-danger text-center" role="alert">
              Akun belum diregister!</div>');
                redirect('Auth');
            }
        } else {
            $this->session->set_flashdata('message', '<div class="alert alert-danger text-center" role="alert">
            Email Salah!!</div>');
            redirect('Auth');
        }
    }
    public function registrasi()
    {
        $data['title'] = 'User Registration';
        //set aturan untuk fieldnya
        $this->form_validation->set_rules('name', 'Name', 'required|trim'); // name= nama di file registrasi | Name nama alis nya | required= syntak agar di field tidak boleh kosong | trim =syntak agar di field tidak ada sepasi
        $this->form_validation->set_rules('devisi', 'Devisi', 'required|trim'); // name= nama di file registrasi | Name nama alis nya | required= syntak agar di field tidak boleh kosong | trim =syntak agar di field tidak ada sepasi
        $this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email|is_unique[user.email]', [
            'is_unique' => 'Username is already!'
        ]); //valid email adalah agar format seperti email seharusnya
        //is_unique = untuk mengecek apakah sudah ada data yang sama di db [name-table.name-field]
        $this->form_validation->set_rules('password1', 'Password', 'required|trim|min_length[3]|matches[password2]', [
            'matches' => 'Password dont match!',
            'min_length' => 'Password too short'
            //setting pesan errornya
            //min_lenght = batas min password|matches untuk menyamakan dengan pass2
        ]);
        $this->form_validation->set_rules('password2', 'Password', 'required|trim|matches[password1]');
        if ($this->form_validation->run() == false) {
            //jadi ini untuk judul di tab atas halaman
            $this->load->view('template/auth_header', $data); //dan $data dikirimkan ke header
            $this->load->view('auth/registrasi', $data);
            $this->load->view('template/auth_footer');
        } else {
            //menyiapkan data yang akan diisikan ke db
            $email = $this->input->post('email', true);
            $data = [
                'name' => htmlspecialchars($this->input->post('name', true)),
                //name = nama di db selanjutnya ngambil di inputan berupa nama method=post trus nama fieldnya name
                'email' => htmlspecialchars($email),
                'devisi' => htmlspecialchars($this->input->post('devisi')),
                'image' => 'default.jpg',
                'password' => password_hash($this->input->post('password1'), PASSWORD_DEFAULT),
                'role_id' => 2,
                // 2 untuk member
                'is_active' => 0,
                // karna biar posisi aktif 0 untuk non aktif
                'date_created' => time()
            ];
            //token untuk verifikasi
            $token = base64_encode(random_bytes(32)); //32 =parameter(dari fungsi php)| base_encode = code utk menterjemahkan si tandom_bytes tsb
            //siapkan tbl sementara untuk simpan token
            $user_token = [
                'email' => $email,
                'token' => $token,
                'date_created' => time() //kapan token dibuat
            ];
            //memasukan data ke db
            $this->db->insert('user', $data);
            $this->db->insert('user_token', $user_token);
            // insert(nama table, datanya yang akan dimasukkan mana)
            //kirim email
            $this->_sendEmail($token, 'verify');
            $this->session->set_flashdata('message', '<div class="alert alert-danger text-center" role="alert">
            Congratulation, your account has ben created, Please Active your Account!
          </div>');
            redirect('auth');
            //setelah berhasil masuk ke login lagi
        }
    }
    public function _sendEmail($token, $type)
    {
        //konfigurasi librari
        $config = array();
        $config['protocol'] = 'smtp';
        $config['smtp_host'] = 'ssl://smtp.googlemail.com';
        $config['smtp_user'] = 'peminjamanGMI@gmail.com';
        $config['smtp_pass'] = '1234ganteng';
        $config['smtp_port'] = 465;
        $config['mailtype'] = 'html';
        $config['charset'] = 'utf-8';
        $this->email->set_newline("\r\n");
        $this->email->initialize($config);
        $this->load->library('email', $config);
        $this->email->from('  ', 'Garuda Mart Indonesia');
        $this->email->to($this->input->post('email'));
        if ($type == 'verify') {
            $this->email->subject('Account Verification');
            $this->email->message('Click this link to verify your account : <a href="' . base_url() . 'auth/verify?email=' . $this->input->post('email') . '&token=' . urlencode($token) . '">Verification Your Email</a>');
        } else if ($type == 'forgot') { //untuk lupa data
            $this->email->message('Click this link to verify your account : <a href="' . base_url() . 'auth/resetpassword?email=' . $this->input->post('email') . '&token=' . urlencode($token) . '">Reset Password</a>');
            $this->email->subject('Reset'); //untuk
            if ($this->email->send()) {
                return true;
            } else {
                echo $this->email->print_debugger();
                die;
            }
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
        //ambil email dan token di url
        $email = $this->input->get('email');
        $token = $this->input->get('token');
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
                    ' . $email . ' has ben activated, please login!
                  </div>');
                    redirect('auth');
                } else {
                    //hapus user jika token expired / berhasil di aktifasi
                    $this->db->delete('user', ['email' => $email]);
                    $this->db->delete('user_token', ['email' => $email]);
                    $this->session->set_flashdata('message', '<div class="alert alert-danger text-center" role="alert">
        token expires!
      </div>');
                    redirect('auth');
                }
            } else {
                $this->session->set_flashdata('message', '<div class="alert alert-danger text-center" role="alert">
        Account activation failed: wrong token!
      </div>');
                redirect('auth');
            }
        } else {
            $this->session->set_flashdata('message', '<div class="alert alert-danger text-center" role="alert">
        Account activation failed: wrong email!
      </div>');
            redirect('auth');
        }
    }
    public function logout()
    {
        $user = $this->session->userdata('id');
        $data = ['session' => 0];
        $this->db->where('id', $user);
        $this->db->update('karyawan', $data);

        $this->session->unset_userdata('id');
        $this->session->unset_userdata('role-id');
        $this->session->unset_userdata('email');
        $this->session->unset_userdata('username');
        $this->session->set_flashdata('message', '<div class="text-center text-center" role="alert">
            Anda berhasil keluar!
          </div>');
        redirect('Auth');
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
        $this->load->model('User_m');
        $data['title'] = "Bloked";
        $data['user'] = $this->User_m->tampil_data();

        $this->load->view('Auth/block', $data);
    }
    public function session_active($user_id)
    {
        $data = ['session' => 1];
        $this->db->where('id', $user_id);
        $this->db->update('karyawan', $data);
    }
}
