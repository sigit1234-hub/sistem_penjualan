<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Akun extends CI_Controller
{
    public function __construct()
    {
        parent::__construct(); //ini untuk memanggil method construct yang ada di CI_Controller
        $this->load->library('form_validation');
        $this->load->library('encrypt');
        $this->load->model('User_m');
    }
    public function index()
    {
        if ($this->session->userdata('email')) {
            $this->blocked();
        }
        $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email|valid_emails');
        $this->form_validation->set_rules('password', 'Password', 'required|trim');
        if ($this->form_validation->run() == false) {
            $data['title'] = 'Login Page';
            $this->load->view('akun/login', $data);
        } else {
            $this->_login();
        }
    }
    public function profil()
    {
        $data['halaman'] = "Akun Saya";
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata['email']])->row_array();
        $data['judul'] = $this->uri->segment(1);
        $this->load->view('shop/header', $data);
        $this->load->view('shop/topbar', $data);
        $this->load->view('shop/navbar', $data);
        // $this->load->view('shop/searchbar', $data);
        $this->load->view('akun/index', $data);
        $this->load->view('shop/footer', $data);
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
                    if ($user['role_id'] == 1) {
                        redirect('Admin');
                    } else {
                        redirect('Home');
                    }
                } else {
                    $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
                    Wrong password</div>');
                    redirect('Akun/');
                }
            } else {
                $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
               This email has not ben activited!</div>');
                redirect('Akun');
            }
        } else {
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
            Email is not registred!</div>');
            redirect('Akun');
        }
    }
    public function registrasi()
    {
        if ($this->session->userdata('email')) {
            $this->blocked();
        } else {
            $data['halaman'] = "Akun Saya";
            $data['judul'] = $this->uri->segment(1);
            $data['title'] = 'User Registration';
            //set aturan untuk fieldnya
            $this->form_validation->set_rules('name', 'Name', 'required|trim'); // name= nama di file registrasi | Name nama alis nya | required= syntak agar di field tidak boleh kosong | trim =syntak agar di field tidak ada sepasi
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
                $token = base64_encode(random_bytes(32)); //32 =parameter(dari fungsi php)| base_encode = code utk menterjemahkan si tandom_bytes tsb
                //siapkan tbl sementara untuk simpan token
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
                $this->_sendEmail($token, 'verify');
                $this->session->set_flashdata('message', '<div class="alert alert-danger text-center" role="alert">
            Congratulation, your account has ben created, Please Active your Account!
          </div>');
                redirect('Akun/verify');
            }
        }
    }
    public function _sendEmail($token, $type)
    {
        $config = array();
        $config['protocol'] = 'smtp';
        $config['smtp_host'] = 'ssl://mail.cha-man.com';
        $config['smtp_user'] = 'info@cha-man.com';
        $config['smtp_pass'] = '1234Ganteng#';
        $config['smtp_port'] = 465;
        $config['mailtype'] = 'html';
        $config['charset'] = 'utf-8';
        $this->email->set_newline("\r\n");
        $this->email->initialize($config);
        $this->load->library('email', $config);
        // $this->email->attach('assets/img/logo/gmi logo.png');
        //mengatur email dikirim dari siapa
        $this->email->from('info@cha-man.com', 'Cha-man | Cuti');

        //kirim kemana
        // $this->email->to($n['email']);
        $this->email->to('ssprasetyo08@gmail.com');


        $this->email->subject('verifikasi Email');
        $this->email->message('Click this link to verify your account : <a href="' . base_url() . 'Akun/verify?email=' . $this->input->post('email') . '&token=' . urlencode($token) . '">Klik disin untuk verifikasi email</a>');

        if ($this->email->send()) {
            return true;
        } else {
            echo $this->email->print_debugger();
            die;
        }
    }
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
                    redirect('Akun');
                } else {
                    //hapus user jika token expired / berhasil di aktifasi
                    $this->db->delete('user', ['email' => $email]);
                    $this->db->delete('user_token', ['email' => $email]);
                    $this->session->set_flashdata('message', '<div class="alert alert-danger text-center" role="alert">
        token expires!
      </div>');
                    redirect('Akun');
                }
            } else {
                $this->session->set_flashdata('message', '<div class="alert alert-danger text-center" role="alert">
        Account activation failed: wrong token!
      </div>');
                redirect('Akun');
            }
        } else {
            $this->session->set_flashdata('message', '<div class="alert alert-danger text-center" role="alert">
        Account activation failed: wrong email!
      </div>');
            redirect('Akun');
        }
    }
    public function login()
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
    public function send_email()
    {
        $config = array();
        $config['protocol'] = 'smtp';
        $config['smtp_host'] = 'ssl://mail.cha-man.com';
        $config['smtp_user'] = 'info@cha-man.com';
        $config['smtp_pass'] = '1234Ganteng#';
        $config['smtp_port'] = 465;
        $config['mailtype'] = 'html';
        $config['charset'] = 'utf-8';
        $this->email->set_newline("\r\n");
        $this->email->initialize($config);

        //librari email di ci
        $this->email->initialize($config);
        $this->load->library('email', $config);
        // $this->email->attach('assets/img/logo/gmi logo.png');
        //mengatur email dikirim dari siapa
        $this->email->from('info@cha-man.com', 'Cha-man | Cuti');

        //kirim kemana
        // $this->email->to($n['email']);
        $this->email->to('ssprasetyo08@gmail.com');
        // $this->email->cc('ssprasetyo08@gmail.com');
        $this->email->subject('tes');
        $this->email->message('tes');
        if ($this->email->send()) {
            return true;
            echo 'berhasil';
        } else {
            echo $this->email->print_debugger();
            die;
        }
    }
    public function logout()
    {
        $this->session->unset_userdata('email');
        $this->session->unset_userdata('role_id');
        $this->session->unset_userdata('id');
        $this->session->unset_userdata('username');
        $this->session->set_flashdata('message', '<div class="text-center text-center" role="alert">
            Anda berhasil keluar!
          </div>');
        redirect('Home');
    }
    public function blocked()
    {
        $this->load->view('akun/block');
    }
    public function updateAkun()
    {
        $data['halaman'] = "Akun Saya";
        $data['user'] = $this->db->get_where('user', ['id' => $this->session->userdata['id']])->row_array();
        $data['dataUser'] = $this->User_m->dataUser();
        $data['dataAlamat'] = $this->User_m->dataAlamat();
        $data['judul'] = $this->uri->segment(1);

        $this->load->view('shop/header', $data);
        $this->load->view('shop/topbar', $data);
        $this->load->view('shop/navbar', $data);
        // $this->load->view('shop/searchbar', $data);
        $this->load->view('akun/update', $data);
        $this->load->view('shop/footer', $data);
    }
    public function update()
    {
        $post = $this->input->post('null', true);
        // $kode = $this->input->post('kode', true);
        $this->User_m->updateUser($post);
        // echo $kode;
    }
}
