<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Keranjang extends CI_Controller
{
    public function __construct()
    {
        parent::__construct(); //ini untuk memanggil method construct yang ada di CI_Controller
        is_logged_in();
        $this->load->library('form_validation');
        $this->load->model('User_m');
        $this->load->model('Keranjang_m');
    }
    public function index()
    {
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['judul'] = $this->uri->segment(1);
        $data['halaman'] = "Keranjang";

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
        $data['data_keranjang'] = $this->Keranjang_m->getKeranjang('keranjang', $config['per_page'], $data['start'], $data['keyword']);

        $this->load->view('shop/header', $data);
        $this->load->view('shop/topbar', $data);
        $this->load->view('shop/navbar', $data);
        $this->load->view('shop/searchbar', $data);
        $this->load->view('keranjang/index', $data);
        $this->load->view('shop/footer', $data);
    }
    public function inputCart()
    {
        $user = htmlspecialchars($this->input->post('idUser'));
        $produk = htmlspecialchars($this->input->post('idProduk'));
        $jumlah =  $this->input->post('jumlah');
        $data = [
            'id_produk' => $produk,
            'id_user' => $user
        ];
        $result = $this->db->get_where('keranjang', $data);
        // $stok = $this->db->get_where('keranjang', $data)->row_array();
        if ($result->num_rows() < 1) {
            $dataUpload = [
                'id_produk' => $produk,
                'id_user' => $user,
                'jumlah' => intval($jumlah),
                'date_created' => tanggal()
            ];
            $this->db->insert('keranjang', $dataUpload);
            $redirect_to = $_SERVER['HTTP_REFERER'];
            redirect($redirect_to);
        } else {
            $stok = $result->row_array();
            $stokBaru = intval($stok['jumlah']) + intval($jumlah);
            $dataUpload = [
                'jumlah' => $stokBaru,
                'date_created' => tanggal()
            ];
            $this->db->where('id_keranjang', $stok['id_keranjang']);
            $this->db->update('keranjang', $dataUpload);
            $redirect_to = $_SERVER['HTTP_REFERER'];
            redirect($redirect_to);
        }
    }
}
