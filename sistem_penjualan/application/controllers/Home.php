<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Home extends CI_Controller
{
    public function __construct()
    {
        parent::__construct(); //ini untuk memanggil method construct yang ada di CI_Controller
        $this->load->library('form_validation');
        $this->load->model('User_m');
        $this->load->model('Produk_m');
    }
    public function index()
    {
        $data['halaman'] = "Beranda";
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['judul'] = $this->uri->segment(1);
        $data['dataDiskon'] = $this->Produk_m->dataDiskon();
        $data['tampilDiskon'] = $this->Produk_m->tampilDiskon();
        $data['produkBaru'] = $this->Produk_m->newProduk();

        $this->load->view('template/header', $data);
        $this->load->view('template/topbar', $data);
        $this->load->view('template/navbar', $data);
        $this->load->view('template/search', $data);
        $this->load->view('page/index', $data);
        $this->load->view('template/footer', $data);
    }
    // public function inputCart()
    // {
    //     $user = $this->input->post('userId');
    //     $produk = $this->input->post('produkId');
    //     $jumlah = 1;
    //     $data = [
    //         'id_produk' => $produk,
    //         'id_user' => $user
    //     ];
    //     $result = $this->db->get_where('keranjang', $data);
    //     // $stok = $this->db->get_where('keranjang', $data)->row_array();
    //     if ($result->num_rows() < 1) {
    //         $dataUpload = [
    //             'id_produk' => $produk,
    //             'id_user' => $user,
    //             'jumlah' => $jumlah,
    //             'date_created' => tanggal()
    //         ];
    //         $this->db->insert('keranjang', $dataUpload);
    //     } else {
    //         $stok = $result->row_array();
    //         $stokBaru = intval($stok['jumlah']) + 1;
    //         $dataUpload = [
    //             'id_produk' => $produk,
    //             'id_user' => $user,
    //             'jumlah' => $stokBaru,
    //             'date_created' => tanggal()
    //         ];
    //         $this->db->where('id_keranjang', $stok['id_keranjang']);
    //         $this->db->update('keranjang', $dataUpload);
    //     }
    // }
}
