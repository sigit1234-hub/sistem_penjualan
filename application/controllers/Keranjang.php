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
        $this->load->model('Api_m');
        $this->load->model('Transaksi_m');
    }
    public function index()
    {
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['judul'] = $this->uri->segment(1);
        $data['alamat'] = $this->db->get_where('alamat', ['id_user' => $this->session->userdata('id')]);
        $data['kotaTujuan'] = $data['alamat']->row_array();
        $data['halaman'] = "Keranjang";

        if (!$this->session->userdata('id')) {
            is_logged_in();
        } else if ($data['user']['tlp'] == '' || $data['alamat']->num_rows() < 1) {
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
            Mohon lengkapi data anda!</div>');
            $this->session->set_userdata('link', current_url());
            redirect('Akun/login');
        }

        //search...
        if ($this->input->post('tombolCari')) {
            $data['keyword'] = $this->input->post('cari');
            $this->session->set_userdata('keyword', $data['keyword']);
            redirect('keranjang');
        } else {
            $data['keyword'] = $this->session->unset_userdata('keyword');
        }
        //akhir search

        //pagination
        $config['base_url'] = 'http://localhost/sistem_penjualan/Keranjang/';
        // $config['total_rows'] = $this->admin->hitung_users();
        //ini pencarian terakhirnya
        $this->db->like('id_produk', $data['keyword']);
        $this->db->from('keranjang');
        $config['total_rows'] = $this->db->count_all_results(); // ini untuk menghitung semua pencarian terakhir


        $config['per_page'] = 12;
        $this->pagination->initialize($config);
        //akhir pagination

        $data['total_rows'] = $config['total_rows'];
        $data['start'] = $this->uri->segment(3);
        $data['data_keranjang'] = $this->Keranjang_m->getKeranjang('keranjang', $config['per_page'], $data['start'], $data['keyword']);
        $data['alamat'] = $this->db->get_where('alamat', ['id_user' => $this->session->userdata('id')]);
        $data['kotaTujuan'] = $data['alamat']->row_array();

        $this->load->view('shop/header', $data);
        $this->load->view('shop/topbar', $data);
        $this->load->view('shop/navbar', $data);
        // $this->load->view('shop/searchbar', $data);
        $this->load->view('keranjang/index', $data);
        $this->load->view('shop/footer2', $data);
    }
    public function cekOngkir()
    {
        $this->Api_m->cekOngkir();
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
                'tanggal_keranjang' => date('Y-m-d H:i:s'),
            ];
            $this->db->insert('keranjang', $dataUpload);
            // $redirect_to = $_SERVER['HTTP_REFERER'];
            // redirect($redirect_to);
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
            Berhasil menambahkan ke keranjang</div>');
            redirect('Keranjang');
        } else {
            $stok = $result->row_array();
            $stokBaru = intval($stok['jumlah']) + intval($jumlah);
            $dataUpload = [
                'jumlah' => $stokBaru,
                'tanggal_keranjang' => date('Y-m-d H:i:s'),
            ];
            $this->db->where('id_keranjang', $stok['id_keranjang']);
            $this->db->update('keranjang', $dataUpload);
            // $redirect_to = $_SERVER['HTTP_REFERER'];
            // redirect($redirect_to);
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
            Berhasil menambahkan ke keranjang</div>');
            redirect('Keranjang');
        }
    }
    public function checkout()
    {
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['judul'] = $this->uri->segment(1);
        $data['alamat'] = $this->db->get_where('alamat', ['id_user' => $this->session->userdata('id')]);
        $data['kotaTujuan'] = $data['alamat']->row_array();
        $data['halaman'] = "Keranjang";

        $produk = $this->input->post('tampungProdukId', true);
        $qty = $this->input->post('tampungQty', true);
        $hargaOk = $this->input->post('tampungHarga', true);
        $idProduk = $this->input->post('tampungProduk', true);

        $data['produk'] = explode(",", $produk);
        $data['okehlah'] = explode(",", $idProduk);
        $data['qty'] = explode(",", $qty);
        $data['hargaOk'] = explode(",", $hargaOk);

        $data['inputProduk'] = $produk;
        $data['idProd'] = $idProduk;
        $data['hargaOk'] = $hargaOk;
        $data['inputQty'] = $qty;

        $data['berat'] = $this->input->post('total_berat', true);
        $data['totalHarga'] = $this->input->post('total_harga', true);

        $this->load->view('shop/header', $data);
        $this->load->view('shop/topbar', $data);
        $this->load->view('shop/navbar', $data);
        $this->load->view('shop/searchbar', $data);
        $this->load->view('keranjang/checkout', $data);
        $this->load->view('shop/footer2', $data);
    }
    public function finish()
    {
        $idProduk = $this->input->post('idKeranjang', true);
        $idProd = $this->input->post('id_produk', true);
        $jumlah =  $this->input->post('qty', true);
        $result = json_decode($this->input->post('result_data'), true);
        // echo 'RESULT <br><pre>';
        // var_dump($result);
        // echo '</pre>';
        $kode = $result['order_id'];
        $tanggal = $result['transaction_time'];
        $status = $result['status_code'];
        $caraBayar = $result['biller_code'];
        if ($caraBayar == 70012) {
            $bank = 'mandiri';
            $va = $result['bill_key'];
        } else {
            $va = $result['va_numbers'][0]['va_number'];
            $bank = $result['va_numbers'][0]['bank'];
        }
        $data = [
            'id_produk' => $this->input->post('id_produk'),
            'harga_produk' => $this->input->post('hargaOk'),
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
            $this->Keranjang_m->hapusProduk($idProduk);
            $this->Keranjang_m->stokKurang($idProd, $jumlah);
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
    public function tokenKeranjang()
    {
        $this->Transaksi_m->tokenKeranjang();
    }
}
