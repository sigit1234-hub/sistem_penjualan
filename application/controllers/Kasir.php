<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Kasir extends CI_Controller
{
    public function __construct()
    {
        parent::__construct(); //ini untuk memanggil method construct yang ada di CI_Controller
        is_logged_in();
        $this->load->library('form_validation');
        $this->load->model('User_m');
        $this->load->model('Keranjang_m');
        $this->load->model('Transaksi_m');
        $this->load->model('Admin_m', 'admin');
    }
    public function index()
    {
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['judul'] = $this->uri->segment(1);
        $data['title'] = "Kasir";
        $data['pesanan'] = $this->admin->Kasir();
        $data['stok'] = $this->admin->stokTipis();
        $this->load->view('admin/template/header', $data);
        $this->load->view('admin/template/topbar', $data);
        $this->load->view('admin/template/sidebar', $data);
        $this->load->view('admin/template/kasir', $data);
        $this->load->view('admin/template/footer', $data);
    }
    public function Penjualan()
    {
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['judul'] = $this->uri->segment(1);
        $data['title'] = "Kasir";

        $this->load->view('admin/sales/header', $data);
        $this->load->view('admin/sales/topbar', $data);
        $this->load->view('admin/penjualan/index', $data);
        $this->load->view('admin/sales/footer', $data);
    }
    public function getProduks()
    {
        // $kode_barang = $_GET['kode_barang'];
        $kode_barang = $this->input->post('code');
        $this->db->where('kode_produk', $kode_barang);
        $sql = $this->db->get('produk')->row_array();

        echo json_encode($sql);
    }
    public function get_products()
    {
        $searchTerm = $this->input->get('q');
        $products = $this->Transaksi_m->get_products($searchTerm);
        $data = [];
        foreach ($products as $product) {
            $item = [
                'id' => $product['kode_produk'],
            ];
            if ($product['stok'] <= 10) {
                $item['text'] =  "(Stok Kosong) - " . $product['nama_produk'];
                $item['disabled'] = true;
            } else {
                $item['text'] = $product['nama_produk'];
            }
            $data[] = $item;
        }

        echo json_encode($data);
    }

    public function checkout()
    {
        $post = $this->input->post('null', true);
        $this->Transaksi_m->checkout($post);
    }
    public function print($kode, $user)
    {
        $data['dataTransaksi'] = $this->db->get_where('transaksi', ['kode_transaksi' => $kode]);
        $data['tgl'] = $data['dataTransaksi']->row_array()['tanggal_transaksi'];
        $data['kode'] = $kode;
        $data['user'] = $user;
        $this->load->view('admin/penjualan/print', $data);
    }
    public function totalTransaksiToko()
    {
        $this->db->where('tipe_pembayaran', 'tunai');
        $dataProduk = $this->db->get('transaksi')->num_rows();
        echo json_encode($dataProduk);
    }
}
