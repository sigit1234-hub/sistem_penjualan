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
        $this->load->model('Api_m');
    }
    public function index()
    {
        $data['halaman'] = "Beranda";
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['judul'] = $this->uri->segment(1);
        $data['dataDiskon'] = $this->Produk_m->dataDiskon();
        $data['tampilDiskon'] = $this->Produk_m->tampilDiskon();
        $data['produkBaru'] = $this->Produk_m->newProduk();

        //search...
        if ($this->input->post('tombolCari')) {
            $data['keyword'] = $this->input->post('cari');
            $this->session->set_userdata('keyword', $data['keyword']);
            redirect('Belanja');
        } else {
            $data['keyword'] = $this->session->userdata('keyword');
        }

        $this->load->view('template/header', $data);
        $this->load->view('template/topbar', $data);
        $this->load->view('template/navbar', $data);
        $this->load->view('template/search', $data);
        $this->load->view('page/index', $data);
        $this->load->view('template/footer', $data);
    }
    public function provinsi()
    {
        $this->Api_m->provinsi();
    }
    public function kota()
    {
        $this->Api_m->kota();
    }
    public function kecamatan()
    {
        $this->Api_m->kecamatan();
    }
    public function tesEmail()
    {
        $this->load->view('email');
    }
}
