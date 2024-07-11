<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Pesanan extends CI_Controller
{
    public function __construct()
    {
        parent::__construct(); //ini untuk memanggil method construct yang ada di CI_Controller
        is_logged_in();
        $this->load->library('form_validation');
        $this->load->model('User_m');
        $this->load->model('Pesanan_m', 'pesanan');
        $this->load->model('Transaksi_m');
    }
    public function index()
    {
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['judul'] = $this->uri->segment(1);
        $data['halaman'] = "Pesanan";
        $data['alamat'] = $this->db->get_where('alamat', ['id_user' => $this->session->userdata('id')]);

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
        $config['base_url'] = 'http://localhost/sistem_penjualan/Pesanan/index/';
        // $config['total_rows'] = $this->admin->hitung_users();
        //ini pencarian terakhirnya
        $this->db->where('id_user', $this->session->userdata('id'));
        $this->db->where('tipe_pembayaran !=', 'tunai');
        $this->db->from('transaksi');
        $config['total_rows'] = $this->db->count_all_results(); // ini untuk menghitung semua pencarian terakhir


        $config['per_page'] = 10;
        $this->pagination->initialize($config);
        //akhir pagination

        $data['total_rows'] = $config['total_rows'];
        $data['start'] = $this->uri->segment(3);
        $data['data_pesanan'] = $this->pesanan->getPesanan('transaksi', $config['per_page'], $data['start'], $data['keyword']);
        // $data['data'] = $this->pesanan->getPesanan();

        $this->load->view('shop/header', $data);
        $this->load->view('shop/topbar', $data);
        $this->load->view('shop/navbar', $data);
        // $this->load->view('shop/searchbar', $data);
        $this->load->view('pesanan/index', $data);
        $this->load->view('shop/footer', $data);
    }
    public function inv($kode)
    {
        $data['invoice'] = $this->db->get_where('transaksi', ['kode_transaksi' => $kode])->result_array();
        $data['judul'] = 'INVOICE ' . $kode;
        $this->load->view('page/invoice', $data);
    }
    public function konfirmasi($id)
    {
        $data = [
            'status' => 204
        ];
        $this->db->where('kode_transaksi', $id);
        $this->db->update('transaksi', $data);

        $tanggal = tanggal();
        $status = 204;
        $this->Transaksi_m->histori($id, $tanggal, $status);

        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
            Pesanan ' . $id . ' telah selesai!!</div>');
        redirect('Pesanan');
    }
}
