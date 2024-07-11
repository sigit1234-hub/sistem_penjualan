<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Belanja extends CI_Controller
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
        $data['halaman'] = "Belanja";
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['judul'] = $this->uri->segment(1);
        $data['kategori'] = $this->Produk_m->dataKategori();

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


        if ($data['user']['alamat'] == '' || $data['user']['tlp'] == '' || $data['alamat']->num_rows() < 1) {
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
            Mohon lengkapi data anda!</div>');
            redirect('Akun/updateAkun');
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
    public function reqOngkos()
    {
        $asal = $_GET['kotaAsal'];
        $tujuan = $_GET['kotaTujuan'];
        $berat = $_GET['berat'];
        $kurir = $_GET['kurir'];

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://api.rajaongkir.com/starter/cost",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => "origin=" . $asal . "&destination=" . $tujuan . "&weight=" . $berat . "&courier=" . $kurir . "",
            CURLOPT_HTTPHEADER => array(
                "content-type: application/x-www-form-urlencoded",
                "key: ef3822684b8b2e026efca014ef1e0422"
            ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            echo "cURL Error #:" . $err;
        } else {
            $data =  json_decode($response);
            // echo $response;
        }
    }
}
