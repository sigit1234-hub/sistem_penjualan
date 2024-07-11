<?php

defined('BASEPATH') or exit('No direct script access allowed');
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Method: GET, OPTIONS");
class Belanja extends CI_Controller
{
    public function __construct()
    {
        parent::__construct(); //ini untuk memanggil method construct yang ada di CI_Controller
        $this->load->library('form_validation');
        $this->load->model('User_m');
        $this->load->model('Produk_m');
        $this->load->model('Transaksi_m');
        $this->load->model('Keranjang_m');
        $this->load->model('Api_m');
        $params = array('server_key' => 'SB-Mid-server-4Am3SmlWNl-quLR0Wleo40dM', 'production' => false);
        $this->load->library('midtrans');
        $this->midtrans->config($params);
    }
    public function index()
    {
        $data['halaman'] = "Belanja";
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['judul'] = $this->uri->segment(1);
        $data['kategori'] = $this->Produk_m->dataKategori();

        //search...
        if ($this->input->post('tombolCari')) {
            $data['keyword'] = $this->input->post('cari');
            $this->session->set_userdata('keyword', $data['keyword']);
            redirect('Belanja');
        } else {
            $data['keyword'] = $this->session->userdata('keyword');
        }

        if (isset($_GET['kategori'])) {
            $data['keyword'] = $_GET['kategori'];
            $this->session->set_userdata('keyword', $data['keyword']);
            redirect('Belanja');
        } else {
            $data['keyword'] = $this->session->userdata('keyword');
        }
        //akhir search

        //pagination
        $config['base_url'] = 'http://localhost/sistem_penjualan/Belanja/index/';
        // $config['total_rows'] = $this->admin->hitung_users();
        //ini pencarian terakhirnya

        $this->db->like('nama_produk', $data['keyword']);
        $this->db->or_like('kode_produk', $data['keyword']);
        $this->db->or_like('harga', $data['keyword']);
        $this->db->or_like('stok', $data['keyword']);
        $this->db->or_like('kategori', $data['keyword']);
        $this->db->from('produk');
        $config['total_rows'] = $this->db->count_all_results(); // ini untuk menghitung semua pencarian terakhir


        $config['per_page'] = 12;
        $this->pagination->initialize($config);
        //akhir pagination

        $data['total_rows'] = $config['total_rows'];
        $data['start'] = $this->uri->segment(3);
        $data['data_produk'] = $this->Produk_m->getProduks('produk', $config['per_page'], $data['start'], $data['keyword']);
        $data['totalRows'] = $config['total_rows'];

        $data['dataDiskon'] = $this->Produk_m->dataDiskon();
        $this->load->view('shop/header', $data);
        $this->load->view('shop/topbar', $data);
        $this->load->view('shop/navbar', $data);
        $this->load->view('shop/searchbar', $data);
        $this->load->view('shop/sidebar', $data);
        $this->load->view('shop/index', $data);
        $this->load->view('shop/footer', $data);
    }

    public function finish()
    {
        $idProd = $this->input->post('idProd');
        $jumlah = $this->input->post('qty');
        $result = json_decode($this->input->post('result_data'), true);
        echo 'RESULT <br><pre>';
        echo $idProd;
        echo $jumlah;
        var_dump($result);
        echo '</pre>';
        $kode = $result['order_id'];
        $tanggal = $result['transaction_time'];
        $status = $result['status_code'];
        $caraBayar = $result['payment_type'];
        if ($caraBayar == 'echannel') {
            $bank = 'mandiri';
            $va = $result['bill_key'];
        } else {
            $va = $result['va_numbers'][0]['va_number'];
            $bank = $result['va_numbers'][0]['bank'];
        }
        $data = [
            'id_produk' => $this->input->post('id_produk'),
            'harga_produk' => $this->input->post('harga'),
            'id_user' => $this->session->userdata('id'),
            'jumlah' => htmlspecialchars($this->input->post('qty', true)),
            'kurir' => htmlspecialchars($this->input->post('kurir', true)),
            'paket' => htmlspecialchars($this->input->post('nama_paket') . " (" . $this->input->post('hargaPaket', true) . ")"),
            'kode_transaksi' => $result['order_id'],
            'total_pembayaran' => $result['gross_amount'],
            'tipe_pembayaran' => $result['payment_type'],
            'tanggal_transaksi' => $tanggal,
            'bank' => $bank,
            'va_number' => $va,
            'status' => $result['status_code'],
        ];

        $simpan = $this->db->insert('transaksi', $data);
        if ($simpan) {
            $this->Transaksi_m->histori($kode, $tanggal, $status);
            $this->Keranjang_m->stokKurang($idProd, $jumlah);
            $this->Keranjang_m->hapusProduk($idProd);
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
            Pesanan Berhasil dibuat, mohon lengkapi pembayaran</div>');
            redirect('Pesanan');
        } else {
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
            mohon lengkapi kembali detail pesanan</div>');
            $link = $this->session->userdata('link');
            $url = explode("/", $link);
            redirect($url[4] . "/" . $url[5] . "/" . $url[6]);
            $this->session->unset_userdata('link');
        }
        // echo "<pre>" . print_r($data) . "</pre>";
    }

    public function detailProduk($id)
    {

        $data['halaman'] = "Belanja";
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['judul'] = $this->uri->segment(1);
        $data['detail'] = $this->Produk_m->details($id);
        $data['serupa'] = $this->Produk_m->produkSerupa($id);

        $this->load->view('shop/header', $data);
        $this->load->view('shop/topbar', $data);
        $this->load->view('shop/navbar', $data);
        $this->load->view('shop/searchbar', $data);
        $this->load->view('pesanan/detail', $data);
        $this->load->view('shop/footer', $data);
    }
    public function beli($id)
    {
        $data['halaman'] = "Belanja";
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['alamat'] = $this->db->get_where('alamat', ['id_user' => $this->session->userdata('id')]);
        $data['judul'] = $this->uri->segment(1);
        $data['detail'] = $this->Produk_m->details($id);
        $data['serupa'] = $this->Produk_m->produkSerupa($id);

        $data['kotaTujuan'] = $data['alamat']->row_array();

        if (!$this->session->userdata('id')) {
            is_logged_in();
        } else if ($data['user']['tlp'] == '' || $data['alamat']->num_rows() < 1) {
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
            Mohon lengkapi data anda!</div>');
            $this->session->set_userdata('link', current_url());
            redirect('Akun/login');
        }

        $this->load->view('shop/header', $data);
        $this->load->view('shop/topbar', $data);
        $this->load->view('shop/navbar', $data);
        // $this->load->view('shop/searchbar', $data);
        $this->load->view('pesanan/checkout', $data);
        $this->load->view('shop/footer', $data);
    }
    public function dataAlamatUser()
    {
        $result = $this->db->get_where('alamat', ['id_user' => $this->session->userdata('id')])->row_array();

        echo json_encode($result);
    }
    public function cekOngkir()
    {
        $this->Api_m->cekOngkir();
    }
    public function token()
    {
        $this->Transaksi_m->token();
    }
    public function tokenKeranjang()
    {
        $this->Transaksi_m->tokenKeranjang();
    }
}
