<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Admin extends CI_Controller
{
    public function __construct()
    {
        parent::__construct(); //ini untuk memanggil method construct yang ada di CI_Controller
        is_logged_in();
        $this->load->library('form_validation');
        $this->load->model('User_m');
        $this->load->model('Admin_m', 'admin');
        $this->load->library('pagination');
    }
    public function toast()
    {
        // Lakukan operasi tertentu

        // Contoh penggunaan toast
        $this->showToast('Data berhasil disimpan!', 'success');
    }

    // Fungsi untuk menampilkan toast
    private function showToast($message, $type)
    {
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata['email']])->row_array();
        $data['title'] = "Dashboard";
        $this->load->view('admin/template/header', $data);
        $this->load->view('admin/template/topbar', $data);
        $this->load->view('admin/template/sidebar', $data);
        $this->load->view('admin/template/index', $data);
        $this->load->view('admin/template/footer', $data);
        echo "<script>showToast('$message', '$type');</script>"; // Panggil fungsi showToast
    }
    public function index()
    {
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata['email']])->row_array();
        $data['title'] = "Dashboard";
        $this->load->view('admin/template/header', $data);
        $this->load->view('admin/template/topbar', $data);
        $this->load->view('admin/template/sidebar', $data);
        $this->load->view('admin/template/index', $data);
        $this->load->view('admin/template/footer', $data);
    }
    public function user()
    {
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata['email']])->row_array();
        $data['title'] = "Data User";

        //search...
        if ($this->input->post('tombolCari')) {
            $data['keyword'] = $this->input->post('cari');
            $this->session->set_userdata('keyword', $data['keyword']);
            redirect('Admin/user');
        } else {
            $data['keyword'] = $this->session->userdata('keyword');
        }
        //akhir search

        //pagination
        $config['base_url'] = 'http://localhost/sistem_penjualan/Admin/user/';
        // $config['total_rows'] = $this->admin->hitung_users();
        //ini pencarian terakhirnya
        $this->db->like('nama', $data['keyword']);
        $this->db->or_like('email', $data['keyword']);
        $this->db->or_like('alamat', $data['keyword']);
        $this->db->or_like('role_id', $data['keyword']);
        $this->db->or_like('tlp', $data['keyword']);
        $this->db->from('user');
        $config['total_rows'] = $this->db->count_all_results(); // ini untuk menghitung semua pencarian terakhir


        $config['per_page'] = 12;
        $this->pagination->initialize($config);
        //akhir pagination

        $data['total_rows'] = $config['total_rows'];
        $data['start'] = $this->uri->segment(3);
        $data['data_user'] = $this->admin->getUsers('user', $config['per_page'], $data['start'], $data['keyword']);

        //rules
        $this->form_validation->set_rules('nama', 'Nama', 'required');
        $this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email|is_unique[user.email]', [
            'is_unique' => 'Email sudah ada!'
        ]);
        $this->form_validation->set_rules('no_tlp', 'No Telpon', 'required');
        $this->form_validation->set_rules('alamat', 'Alamat', 'required');
        if ($this->form_validation->run() == false) {
            $this->load->view('admin/template/header', $data);
            $this->load->view('admin/template/topbar', $data);
            $this->load->view('admin/template/sidebar', $data);
            $this->load->view('admin/user/index', $data);
            $this->load->view('admin/template/footer', $data);
        } else {
            $post = $this->input->post(null);
            $this->admin->addUser($post);
        }
    }
    public function editUser()
    {
        $this->form_validation->set_rules('nama', 'Nama', 'required');
        $this->form_validation->set_rules('email', 'Email', 'required');
        $this->form_validation->set_rules('password', 'Password', 'required');
        $this->form_validation->set_rules('no_tlp', 'No tlp', 'required');
        if ($this->form_validation->run() == false) {
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
            Mohon untuk melengkapi data dengan benar</div>');
        } else {
            $post = $this->input->post(null, true);
            $this->admin->editUser($post);
        }
    }
    public function hapusUser($id)
    {
        $user = $this->db->get_where('user', ['id' => $id])->row_array();
        if ($user['foto'] != 'default.png') {
            unlink(FCPATH . 'assets/img/user/' . $user['foto']);
        }

        $this->db->delete('user', ['id' => $id]);
        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
        Data berhasil <b>dihapus</b> !!</div>');
        redirect('Admin/user');
    }

    // Page Produk
    public function produk()
    {
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata['email']])->row_array();
        $data['title'] = "Data Produk";

        //search...
        if ($this->input->post('tombolCari')) {
            $data['keyword'] = $this->input->post('cari');
            $this->session->set_userdata('keyword', $data['keyword']);
            redirect('Admin/produk');
        } else {
            $data['keyword'] = $this->session->userdata('keyword');
        }
        //akhir search

        //pagination
        $config['base_url'] = 'http://localhost/sistem_penjualan/Admin/produk/';
        // $config['total_rows'] = $this->admin->hitung_users();
        //ini pencarian terakhirnya
        $this->db->like('nama_produk', $data['keyword']);
        $this->db->or_like('kode_produk', $data['keyword']);
        $this->db->or_like('kategori', $data['keyword']);
        $this->db->or_like('harga', $data['keyword']);
        $this->db->or_like('stok', $data['keyword']);
        $this->db->from('produk');
        $config['total_rows'] = $this->db->count_all_results(); // ini untuk menghitung semua pencarian terakhir


        $config['per_page'] = 12;
        $this->pagination->initialize($config);
        //akhir pagination

        $data['total_rows'] = $config['total_rows'];
        $data['start'] = $this->uri->segment(3);
        $data['data_produk'] = $this->admin->getProduk($config['per_page'], $data['start'], $data['keyword']);
        // $this->form_validation->set_rules('nama', 'Nama Produk', 'required');
        // $this->form_validation->set_rules('kategori', 'Kategori', 'required');
        $this->form_validation->set_rules('stok', 'Stok', 'required');
        if ($this->form_validation->run() == false) {
            $this->load->view('admin/template/header', $data);
            $this->load->view('admin/template/topbar', $data);
            $this->load->view('admin/template/sidebar', $data);
            $this->load->view('admin/produk/index', $data);
            $this->load->view('admin/template/footer', $data);
        } else {
            $post = $this->input->post(null, true);
            $this->admin->inputProduk($post);
        }
    }
    public function editProduk($id)
    {
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata['email']])->row_array();
        $data['title'] = "Data Produk";
        $data['data_produk'] = $this->db->get_where('produk', ['id_produk' => $id])->result_array();

        $this->form_validation->set_rules("nama", "Nama", "required");
        // $this->form_validation->set_rules("kategori", "Kategori", "required");
        // $this->form_validation->set_rules("harga", "Harga", "required");
        // $this->form_validation->set_rules("berat", "Berat", "required");
        // $this->form_validation->set_rules("stok", "Stok", "required");
        // $this->form_validation->set_rules("diskon", "Diskon", "required");
        // $this->form_validation->set_rules("deskripsi", "Deskripsi", "required");
        if ($this->form_validation->run() == false) {
            $this->load->view('admin/template/header', $data);
            $this->load->view('admin/template/topbar', $data);
            $this->load->view('admin/template/sidebar', $data);
            $this->load->view('admin/produk/edithalaman', $data);
            $this->load->view('admin/template/footer', $data);
        } else {
        }
    }
    public function editProd()
    {
        $id = $this->input->post("id", true);
        $this->form_validation->set_rules("nama", "Nama", "required");
        $this->form_validation->set_rules("kategori", "Kategori", "required");
        $this->form_validation->set_rules("harga", "Harga", "required");
        $this->form_validation->set_rules("berat", "Berat", "required");
        $this->form_validation->set_rules("stok", "Stok", "required");
        $this->form_validation->set_rules("diskon", "Diskon", "required");
        $this->form_validation->set_rules("deskripsi", "Deskripsi", "required");
        if ($this->form_validation->run() == false) {
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
       Semua kolom harap <b>diisi</b> !!</div>');
            redirect('Admin/editProduk/' . $id);
        } else {
            $post = $this->input->post('null', true);
            $kode = htmlspecialchars($this->input->post('kode'));
            $this->admin->editProduk($post);

            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
        Data ' . $kode . ' Berhasil diupdate</div>');
            redirect('Admin/produk');
        }
    }
    public function hapusProduk($id)
    {
        $this->db->where('id_produk', $id);
        $getKode = $this->db->get('produk')->row_array();

        $this->admin->hapusProduk($getKode['kode_produk'], $id);
    }

    public function changeStatus()
    {
        $dataId = $this->input->post('idData'); //ngambil dari js yang sebelah kiri idData: dataId
        $statusId = $this->input->post('idStatus'); //ngambil dari js yang sebelah kiri idData: dataId
        if ($statusId == 1) {
            $this->db->where('id_produk', $dataId);
            $this->db->update('produk', ['is_active' => 0]);
        } else {
            $this->db->where('id_produk', $dataId);
            $this->db->update('produk', ['is_active' => 1]);
        }

        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
        Data Berhasil Ubah!!</div>');
    }
    public function editDatatable()
    {
        $id =  $this->input->post('dataID');
        $value = $this->input->post('value');
        $field = $this->input->post('field');
        $data = [
            $field => $value
        ];
        $this->db->where('id_produk', $id);
        $this->db->update('produk', $data);

        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
        Data Berhasil Ubah!!</div>');
    }

    // Page Kategori
    public function kategori()
    {
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata['email']])->row_array();
        $data['title'] = "Kategori Produk";

        //search...
        if ($this->input->post('tombolCari')) {
            $data['keyword'] = $this->input->post('cari');
            $this->session->set_userdata('keyword', $data['keyword']);
            redirect('Admin/kategori');
        } else {
            $data['keyword'] = $this->session->userdata('keyword');
        }
        //akhir search

        //pagination
        $config['base_url'] = 'http://localhost/sistem_penjualan/Admin/kategori/';
        // $config['total_rows'] = $this->admin->hitung_users();
        //ini pencarian terakhirnya
        $this->db->like('nama_kategori', $data['keyword']);
        $this->db->from('kategori');
        $config['total_rows'] = $this->db->count_all_results(); // ini untuk menghitung semua pencarian terakhir


        $config['per_page'] = 12;
        $this->pagination->initialize($config);
        //akhir pagination

        $data['total_rows'] = $config['total_rows'];
        $data['start'] = $this->uri->segment(3);
        $data['data_user'] = $this->admin->getKategori($config['per_page'], $data['start'], $data['keyword']);
        $this->form_validation->set_rules('kategori[]', 'Nama Kategori', 'required|trim|is_unique[kategori.nama_kategori]', [
            'is_unique' => 'Nama kategori sudah ada!'
        ]);
        if ($this->form_validation->run() == false) {
            $this->load->view('admin/template/header', $data);
            $this->load->view('admin/template/topbar', $data);
            $this->load->view('admin/template/sidebar', $data);
            $this->load->view('admin/kategori/index', $data);
            $this->load->view('admin/template/footer', $data);
        } else {
            $post = $this->input->post(null, true);
            $this->admin->tambahKategori($post);
        }
    }
    public function inputKategori()
    {
        $this->form_validation->set_rules('kategori[]', 'Nama Kategori', 'required|trim|is_unique[kategori.nama_kategori]', [
            'is_unique' => 'Nama kategori sudah ada!'
        ]);
        if ($this->form_validation->run() == false) {
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
                    Kategori sudah ada !!</div>');
            redirect('Admin/kategori');
        } else {
            $post = $this->input->post(null, true);
            $this->admin->tambahKategori($post);
        }
    }
    public function editkategori()
    {
        $this->form_validation->set_rules('nama', 'Nama', 'required');
        $this->form_validation->set_rules('is_active', 'Status', 'required');
        if ($this->form_validation->run() == false) {
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
        Perubahan data gagal!!!</div>');
            redirect('Admin/kategori');
        } else {
            $id = htmlspecialchars($this->input->post('id'));

            $data = [
                'nama_kategori' => htmlspecialchars($this->input->post('nama')),
                'is_active' => htmlspecialchars($this->input->post('is_active'))
            ];

            $this->db->where('id_kategori', $id);
            $this->db->update('kategori', $data);
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
                 Data berhasil diubah!!</div>');
            redirect('Admin/kategori');
        }
    }
    public function hapusKategori($id)
    {
        $this->db->delete('kategori', array('id_kategori' => $id));
        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
                 Data berhasil <b>dihapus</b> !!</div>');
        redirect('Admin/kategori');
    }
    public function transaksi()
    {
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata['email']])->row_array();
        $data['title'] = "Data Transaksi";

        //search...
        if ($this->input->post('tombolCari')) {
            $data['keyword'] = $this->input->post('cari');
            $this->session->set_userdata('keyword', $data['keyword']);
            redirect('Admin/kategori');
        } else {
            $data['keyword'] = $this->session->userdata('keyword');
        }
        //akhir search

        //pagination
        $config['base_url'] = 'http://localhost/sistem_penjualan/Admin/kategori/';
        // $config['total_rows'] = $this->admin->hitung_users();
        //ini pencarian terakhirnya
        $this->db->like('nama_kategori', $data['keyword']);
        $this->db->from('kategori');
        $config['total_rows'] = $this->db->count_all_results(); // ini untuk menghitung semua pencarian terakhir


        $config['per_page'] = 12;
        $this->pagination->initialize($config);
        //akhir pagination

        $data['total_rows'] = $config['total_rows'];
        $data['start'] = $this->uri->segment(3);
        $data['data_user'] = $this->admin->getKategori($config['per_page'], $data['start'], $data['keyword']);
        $this->form_validation->set_rules('kategori[]', 'Nama Kategori', 'required|trim|is_unique[kategori.nama_kategori]', [
            'is_unique' => 'Nama kategori sudah ada!'
        ]);
        if ($this->form_validation->run() == false) {
            $this->load->view('admin/template/header', $data);
            $this->load->view('admin/template/topbar', $data);
            $this->load->view('admin/template/sidebar', $data);
            $this->load->view('page/transaksi', $data);
            $this->load->view('admin/template/footer', $data);
        } else {
            $post = $this->input->post(null, true);
            $this->admin->tambahKategori($post);
        }
    }
}
