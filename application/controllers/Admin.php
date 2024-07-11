<?php

defined('BASEPATH') or exit('No direct script access allowed');

use Mike42\Escpos\PrintConnectors\FilePrintConnector;
use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;
use Mike42\Escpos\Printer;
use PhpOffice\PhpSpreadsheet\Reader\Xml\Style\Fill;
use PhpOffice\PhpSpreadsheet\Reader\Xml\Style\Font as StyleFont;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Font;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Wrap;

class Admin extends CI_Controller
{
    public function __construct()
    {
        parent::__construct(); //ini untuk memanggil method construct yang ada di CI_Controller
        is_logged_in();
        $this->load->library('form_validation');
        $this->load->model('User_m');
        $this->load->model('Admin_m', 'admin');
        $this->load->model('Transaksi_m', 'transaksi');
        $this->load->model('Notifikasi_m', 'notif');
        $this->load->library('pagination');
    }

    // Fungsi untuk menampilkan toast
    public function index()
    {
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata['email']])->row_array();
        $data['title'] = "Dashboard";
        $data['pesanan'] = $this->admin->pesananMasuk();
        $data['stok'] = $this->admin->stokTipis();

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
        // $this->form_validation->set_rules('password', 'Password', 'required');
        // $this->form_validation->set_rules('no_tlp', 'No tlp', 'required');
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
        $this->form_validation->set_rules('kode[]', 'Kode', 'required|trim|is_unique[kategori.kode]', [
            'is_unique' => 'kode sudah ada!'
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
        $this->form_validation->set_rules('kode', 'Kode', 'required');
        if ($this->form_validation->run() == false) {
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
        Perubahan data gagal!!!</div>');
            redirect('Admin/kategori');
        } else {
            $id = htmlspecialchars($this->input->post('id'));

            $data = [
                'nama_kategori' => htmlspecialchars($this->input->post('nama')),
                'kode' => htmlspecialchars($this->input->post('kode')),
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
    public function get_data()
    {
        // Mendapatkan data dari sumber data (misalnya, dari model atau database)
        $dataFromServer = "Data dari server";

        // Mengirim data ke klien sebagai respons
        echo $dataFromServer;
    }
    public function process_data()
    {
        // Mendapatkan data dari parameter URL
        $inputText = $this->input->get('inputText');

        // Lakukan sesuatu dengan data (misalnya, tampilkan)
        echo "Input Text: " . $inputText;
    }
    public function transaksi()
    {
        $this->session->unset_userdata('keyword');
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata['email']])->row_array();
        $data['title'] = "Data Transaksi";
        if ($this->input->post('tombolCari')) {
            $data['keyword'] = $this->input->post('cari');
            $this->session->set_userdata('keyword', $data['keyword']);
            redirect('Admin/transaksi');
        } else {
            $data['keyword'] = $this->session->userdata('keyword');
        }
        //akhir search
        //pagination
        $config['base_url'] = 'http://localhost/sistem_penjualan/Admin/transaksi/';
        if ($data['keyword'] == '') {
            $this->db->where('tipe_pembayaran !=', 'tunai');
            $this->db->from('transaksi');
            $config['total_rows'] = $this->db->count_all_results();
        } else {
            $this->db->where('tipe_pembayaran !=', 'tunai');
            $this->db->like('kurir', $data['keyword']);
            $this->db->or_like('kode_transaksi', $data['keyword']);
            $this->db->or_like('tanggal_transaksi', $data['keyword']);
            $this->db->from('transaksi');
            $config['total_rows'] = $this->db->count_all_results(); // ini untuk menghitung semua pencarian terakhir
        }

        $config['per_page'] = 10;
        $this->pagination->initialize($config);
        //akhir pagination

        // $data['total_rows'] = $config['total_rows'];
        $data['total_rows'] = $config['total_rows'];
        $data['start'] = $this->uri->segment(3);
        $data['dataWebsite'] = $this->transaksi->getTransaksiWeb('transaksi', $config['per_page'], $data['start'], $data['keyword']);
        $this->form_validation->set_rules('resi', 'Nomor Resi', 'required');
        if ($this->form_validation->run() == false) {
            $this->load->view('admin/template/header', $data);
            $this->load->view('admin/template/topbar', $data);
            $this->load->view('admin/template/sidebar', $data);
            $this->load->view('page/transaksi', $data);
            $this->load->view('admin/template/footer', $data);
        } else {
            $id = $this->input->post('idTransaksi', true);
            $kode = $this->input->post('kodeTransaksi', true);
            $resi = $this->input->post('resi');
            $tanggal =  tanggal();
            $data = [
                'resi' => $resi,
                'status' => 202
            ];
            $this->db->where('id_transaksi', $id);
            $result = $this->db->update('transaksi', $data);
            if ($result) {
                $this->transaksi->histori($kode, $tanggal, 202);
                $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
                Data berhasil <b>diubah</b> !!</div>');
                redirect('Admin/transaksi');
            } else {
                $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
                Data gagal <b>dihapus</b> !!</div>');
                redirect('Admin/transaksi');
            }
        }
    }

    public function transaksiToko()
    {
        $this->session->unset_userdata('keyword');
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata['email']])->row_array();
        $data['title'] = "Data Transaksi";
        if ($this->input->post('tombolCari')) {
            $data['keyword'] = $this->input->post('cari');
            $this->session->set_userdata('keyword', $data['keyword']);
            redirect('Admin/transaksiToko');
        } else {
            $data['keyword'] = $this->session->userdata('keyword');
        }

        //pagination
        $config['base_url'] = 'http://localhost/sistem_penjualan/Admin/transaksiToko/index';
        if ($data['keyword'] == '') {
            $this->db->where('tipe_pembayaran', 'tunai');
            $this->db->from('transaksi');
            $config['total_rows'] = $this->db->count_all_results();
        } else {
            $this->db->where('tipe_pembayaran', 'tunai');
            $this->db->like('kurir', $data['keyword']);
            $this->db->or_like('kode_transaksi', $data['keyword']);
            $this->db->or_like('tanggal_transaksi', $data['keyword']);
            $this->db->from('transaksi');
            $config['total_rows'] = $this->db->count_all_results(); // ini untuk menghitung semua pencarian terakhir
        }


        $config['per_page'] = 10;
        $this->pagination->initialize($config);
        //akhir pagination

        // $data['total_rows'] = $config['total_rows'];
        $data['total_rows'] = $config['total_rows'];
        $data['start'] = $this->uri->segment(3);
        $data['dataToko'] = $this->transaksi->getTransaksiToko('transaksi', $config['per_page'], $data['start'], $data['keyword']);
        $this->form_validation->set_rules('kategori[]', 'Nama Kategori', 'required|trim|is_unique[kategori.nama_kategori]', [
            'is_unique' => 'Nama kategori sudah ada!'
        ]);
        if ($this->form_validation->run() == false) {
            $this->load->view('admin/template/header', $data);
            $this->load->view('admin/template/topbar', $data);
            $this->load->view('admin/template/sidebar', $data);
            $this->load->view('page/transaksiToko', $data);
            $this->load->view('admin/template/footer', $data);
        }
    }
    public function cetakData()
    {
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata['email']])->row_array();
        $data['title'] = "Data Transaksi";
        $data['stok'] = $this->input->post('stok', true);
        $data['kategori'] = $this->input->post('kategori', true);

        $data['dataProduk'] = $this->admin->getDataCetak($data['stok'], $data['kategori']);

        $this->load->view('admin/produk/cetak', $data);
    }
    public function cetakDataTransaksi()
    {
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata['email']])->row_array();
        $data['title'] = "Data Transaksi";
        $data['role'] = $this->input->post('role');
        $data['status'] = $this->input->post('status');
        $data['tglDari'] = $this->input->post('tglDari');
        $data['tglSampai'] = $this->input->post('tglSampai');
        $data['dataTransaksi'] = $this->transaksi->getDataTransaksi($data['status'], $data['tglDari'], $data['tglSampai'], $data['role']);
        $this->load->view('admin/produk/cetakTransaksi', $data);
    }
    public function excelTransaksi($status, $tglDari, $tglSampai, $role)
    {
        if ($role == 1) {
            $tipe = "tipe_pembayaran != 'tunai'";
        } else {
            $tipe = "tipe_pembayaran = 'tunai'";
        }
        if ($status == 0) {
            $st = '';
        } else {
            $st = " AND status = $status";
        }
        if ($tglDari == $tglSampai) {
            $tgl = "tanggal_transaksi LIKE '$tglDari%'";
        } else {
            $tgl = "tanggal_transaksi BETWEEN '$tglDari%' AND '$tglSampai%'";
        }
        $sql = "SELECT * FROM transaksi WHERE $tipe AND $tgl $st ORDER BY tanggal_transaksi ASC";
        $result = $this->db->query($sql)->result_array();

        // $data['user'] =  $data['user'] = $this->db->get_where('karyawan', ['id' => $this->session->userdata('id')])->row_array();
        $data['judul'] = "Data Transaksi";
        // if ($awal === $akhir) {
        //     $data['tanggal'] =  tgl($awal);
        // } elseif (date('Y-m', strtotime($awal)) == date('Y-m', strtotime($akhir))) {
        //     $data['tanggal'] = date('d', strtotime($awal)) . ' - ' . tgl($akhir);
        // } elseif (date('Y', strtotime($awal)) == date('Y', strtotime($akhir))) {
        //     $data['tanggal'] = date('d ', strtotime($awal)) . bulan($bln) . ' - ' . tgl($akhir);
        // } else {
        //     $data['tanggal'] =   tgl($awal) . ' - ' . tgl($akhir);
        // }

        //logo
        $drawing = new Drawing();
        $drawing->setName('Logo');
        $drawing->setDescription('CV Dapur Berkah');
        $drawing->setPath('assets/img/dapur.png'); // Ganti dengan path gambar Anda
        $drawing->setCoordinates('B1'); // Koordinat sel tempat gambar akan disisipkan
        $drawing->setWidthAndHeight(163, 67); // Atur lebar dan tinggi gambar

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();


        $sheet->mergeCells('A3:J3');
        $sheet->mergeCells('A4:J4');
        //style 
        $styleArray = [
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER,
            ]
        ];
        $borderStyle = [
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['rgb' => '000000'],
                ],
            ],
            'alignment' => [
                'wrapText' => true,
            ]
        ];
        $numberFormat = [
            'numberFormat' => array(
                'formatCode' => '#,##', // Format mata uang Rupiah
            ),
        ];
        $headerStyle = [
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['rgb' => '000000'],
                ],
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER,
            ],
            'font' => [
                'bold' => true,
                'color' => ['rgb' => '080808'],
                'size' => 12,
            ],
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'startColor' => [
                    'rgb' => 'd3e0e5',
                ],
            ],
        ];
        $judulStyle = [
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER,
            ],
            'font' => [
                'bold' => true,
                'color' => ['rgb' => '080808'],
                'size' => 14,
            ],
        ];


        $sheet->getStyle('A3')->applyFromArray($judulStyle);
        $sheet->getStyle('A4')->applyFromArray($styleArray);
        $sheet->setCellValue('A3', 'DATA TRANSAKSI ' . tgl(tanggal()));
        $sheet->setCellValue('A4', 'CV Dapur Berkah');

        $sheet->setCellValue('A6', 'NO');
        $sheet->setCellValue('B6', 'KODE TRANSAKSI');
        $sheet->setCellValue('C6', 'TANGGAL');
        $sheet->setCellValue('D6', 'PRODUK');
        if ($role == 1) {
            $sheet->setCellValue('E6', 'PEMESAN');
            $sheet->setCellValue('F6', 'PEMBAYARAN');
            $sheet->setCellValue('G6', 'BANK');
            $sheet->setCellValue('H6', 'TOTAL PEMBAYARAN');
            $sheet->setCellValue('I6', 'DISKON');
            $sheet->setCellValue('J6', 'KURIR');
            $sheet->setCellValue('K6', 'STATUS');
            $sheet->getStyle('A6:K6')->applyFromArray($headerStyle);
        } else {
            $sheet->setCellValue('E6', 'KASIR');
            $sheet->setCellValue('F6', 'PEMBAYARAN');
            $sheet->setCellValue('G6', 'TOTAL PEMBAYARAN');
            $sheet->setCellValue('H6', 'DISKON');
            $sheet->setCellValue('I6', 'STATUS');
            $sheet->getStyle('A6:I6')->applyFromArray($headerStyle);
        }




        $no = 1;
        $x = 7;
        foreach ($result as $row) {
            $idProduk = explode(',', $row['id_produk']);
            $qty = explode(',', $row['jumlah']);
            $produkString = '';
            for ($u = 0; $u < count($idProduk); $u++) {
                $this->db->where('id_produk', $idProduk[$u]);
                $hasil = $this->db->get('produk')->result_array();
                foreach ($hasil as $h) {
                    $produkString = rtrim($produkString, ', '); // Menghapus koma ekstra di akhir
                    $produkString .= $h['nama_produk'] . ' - x' . $qty[$u];
                }
                if ($u < (count($idProduk) - 1)) {
                    $produkString .=  "\r\n";
                } else {
                }
            }
            if ($row['status'] == 0) {
                $sts = 'Semua, ';
            } else if ($row['status'] == 200) {
                $sts = "Dikemas";
            } else if ($row['status'] == 201) {
                $sts = "Belum Bayar";
            } else if ($row['status'] == 202) {
                $sts = "Dikirim";
            } else if ($row['status'] == 204) {
                $sts = "Selesai";
            } else if ($row['status'] == 203) {
                $sts = "DiBatalkan";
            } else if ($row['status'] == 407) {
                $sts = "Kadaluwarsa";
            }

            $sheet->setCellValue('A' . $x, $no++);
            $sheet->setCellValue('B' . $x, $row['kode_transaksi']);
            $sheet->setCellValue('C' . $x, tanggal($row['tanggal_transaksi']));
            // $sheet->setCellValue('D' . $x, $produkString);
            $sheet->setCellValue('D' . $x, $produkString);
            $sheet->setCellValue('E' . $x, nama($row['id_user']));
            if ($role == 1) {
                $sheet->setCellValue('F' . $x, $row['tipe_pembayaran']);
                $sheet->setCellValue('G' . $x, $row['bank'] . ' ' . $row['va_number']);
                $sheet->setCellValue('H' . $x, $row['total_pembayaran']);
                $sheet->setCellValue('I' . $x, $row['total_diskon']);
                $sheet->setCellValue('J' . $x, $row['kurir'] . ' ' . $row['paket']);
                $sheet->setCellValue('K' . $x, $sts);
                $sheet->getStyle('A' . $x)->applyFromArray($borderStyle);
                $sheet->getStyle('B' . $x)->applyFromArray($borderStyle);
                $sheet->getStyle('C' . $x)->applyFromArray($borderStyle);
                $sheet->getStyle('D' . $x)->applyFromArray($borderStyle);
                $sheet->getStyle('E' . $x)->applyFromArray($borderStyle);
                $sheet->getStyle('F' . $x)->applyFromArray($borderStyle);
                $sheet->getStyle('G' . $x)->applyFromArray($borderStyle);
                $styleArray = array_merge($borderStyle, $numberFormat);
                $sheet->getStyle('H' . $x)->applyFromArray($styleArray);
                $sheet->getStyle('I' . $x)->applyFromArray($styleArray);
                $sheet->getStyle('J' . $x)->applyFromArray($borderStyle);
                $sheet->getStyle('K' . $x)->applyFromArray($borderStyle);
            } else {
                $sheet->setCellValue('F' . $x, $row['tipe_pembayaran']);
                $sheet->setCellValue('G' . $x, $row['total_pembayaran']);
                $sheet->setCellValue('H' . $x, $row['total_diskon']);
                $sheet->setCellValue('I' . $x, $sts);
                $sheet->getStyle('A' . $x)->applyFromArray($borderStyle);
                $sheet->getStyle('B' . $x)->applyFromArray($borderStyle);
                $sheet->getStyle('C' . $x)->applyFromArray($borderStyle);
                $sheet->getStyle('D' . $x)->applyFromArray($borderStyle);
                $sheet->getStyle('E' . $x)->applyFromArray($borderStyle);
                $sheet->getStyle('F' . $x)->applyFromArray($borderStyle);
                $styleArray = array_merge($borderStyle, $numberFormat);
                $sheet->getStyle('G' . $x)->applyFromArray($styleArray);
                $sheet->getStyle('H' . $x)->applyFromArray($styleArray);
                $sheet->getStyle('I' . $x)->applyFromArray($borderStyle);
            }
            $x++;
        }

        $sheet->getColumnDimension('A')->setAutoSize(true);
        $sheet->getColumnDimension('B')->setAutoSize(true);
        $sheet->getColumnDimension('C')->setAutoSize(true);
        $sheet->getColumnDimension('D')->setAutoSize(true);
        $sheet->getColumnDimension('E')->setAutoSize(true);
        $sheet->getColumnDimension('F')->setAutoSize(true);
        $sheet->getColumnDimension('G')->setAutoSize(true);
        $sheet->getColumnDimension('H')->setAutoSize(true);
        $sheet->getColumnDimension('I')->setAutoSize(true);
        $sheet->getColumnDimension('J')->setAutoSize(true);
        $sheet->getColumnDimension('K')->setAutoSize(true);

        // Menambahkan gambar ke lembar kerja
        $drawing->setWorksheet($sheet);
        $writer = new Xlsx($spreadsheet);
        $filename = 'Data Transaksi ' . tgl(tanggal());

        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
    }
    public function excel($stok, $kategori)
    {
        // $stok = $this->uri->segment(2);
        // $kategori = $this->uri->segment(3);
        // $status = $this->uri->segment(5);
        // $awal = $this->encrypt->decode($awal1);
        // $akhir = $this->encrypt->decode($akhir1);
        // $bln = date('m', strtotime($awal));

        if ($stok == 0 && $kategori == 0) {
        } else if ($kategori == 0) {
            if ($stok == 1) {
                $this->db->where('stok BETWEEN 1 AND 10');
            } else if ($stok == 2) {
                $this->db->where('stok BETWEEN 10 AND 100');
            } else if ($stok == 3) {
                $this->db->where('stok >=', 100);
            }
        } else if ($stok == 0) {
            if ($kategori != 0) {
                $this->db->where('kategori', $kategori);
            }
        } else if ($stok != 0 && $kategori != 0) {
            if ($stok == 1) {
                $this->db->where('stok BETWEEN 1 AND 10');
                $this->db->where('kategori', $kategori);
            } else if ($stok == 2) {
                $this->db->where('stok BETWEEN 10 AND 100');
                $this->db->where('kategori', $kategori);
            } else if ($stok == 3) {
                $this->db->where('stok >=', 100);
                $this->db->where('kategori', $kategori);
            }
        }
        $sql = $this->db->order_by('stok', 'ASC')->get('produk')->result();

        // $data['user'] =  $data['user'] = $this->db->get_where('karyawan', ['id' => $this->session->userdata('id')])->row_array();
        $data['judul'] = "Data Produk";
        // if ($awal === $akhir) {
        //     $data['tanggal'] =  tgl($awal);
        // } elseif (date('Y-m', strtotime($awal)) == date('Y-m', strtotime($akhir))) {
        //     $data['tanggal'] = date('d', strtotime($awal)) . ' - ' . tgl($akhir);
        // } elseif (date('Y', strtotime($awal)) == date('Y', strtotime($akhir))) {
        //     $data['tanggal'] = date('d ', strtotime($awal)) . bulan($bln) . ' - ' . tgl($akhir);
        // } else {
        //     $data['tanggal'] =   tgl($awal) . ' - ' . tgl($akhir);
        // }

        //logo
        $drawing = new Drawing();
        $drawing->setName('Logo');
        $drawing->setDescription('CV Dapur Berkah');
        $drawing->setPath('assets/img/dapur.png'); // Ganti dengan path gambar Anda
        $drawing->setCoordinates('B1'); // Koordinat sel tempat gambar akan disisipkan
        $drawing->setWidthAndHeight(163, 67); // Atur lebar dan tinggi gambar

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();


        $sheet->mergeCells('A3:J3');
        $sheet->mergeCells('A4:J4');
        //style 
        $styleArray = [
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER,
            ]
        ];
        $borderStyle = [
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['rgb' => '000000'],
                ],
            ],
            'alignment' => [
                'wrapText' => true,
            ]
        ];
        $numberFormat = [
            'numberFormat' => array(
                'formatCode' => '#,##', // Format mata uang Rupiah
            ),
        ];
        $headerStyle = [
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['rgb' => '000000'],
                ],
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER,
            ],
            'font' => [
                'bold' => true,
                'color' => ['rgb' => '080808'],
                'size' => 12,
            ],
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'startColor' => [
                    'rgb' => 'd3e0e5',
                ],
            ],
        ];
        $judulStyle = [
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER,
            ],
            'font' => [
                'bold' => true,
                'color' => ['rgb' => '080808'],
                'size' => 14,
            ],
        ];


        $sheet->getStyle('A3')->applyFromArray($judulStyle);
        $sheet->getStyle('A4')->applyFromArray($styleArray);
        $sheet->setCellValue('A3', 'DATA PRODUK ' . tgl(tanggal()));
        $sheet->setCellValue('A4', 'CV Dapur Berkah');

        $sheet->setCellValue('A6', 'NO');
        $sheet->setCellValue('B6', 'KODE PRODUK');
        $sheet->setCellValue('C6', 'TANGGAL MASUK');
        $sheet->setCellValue('D6', 'NAMA PRODUK');
        $sheet->setCellValue('E6', 'KATEGORI');
        $sheet->setCellValue('F6', 'HARGA');
        $sheet->setCellValue('G6', 'BERAT(gram)');
        $sheet->setCellValue('H6', 'STOK');
        $sheet->getStyle('A6:H6')->applyFromArray($headerStyle);



        $no = 1;
        $x = 7;
        foreach ($sql as $row) {
            $sheet->setCellValue('A' . $x, $no++);
            $sheet->setCellValue('B' . $x, $row->kode_produk);
            $sheet->setCellValue('C' . $x, tanggal($row->tgl_input));
            $sheet->setCellValue('D' . $x, $row->nama_produk);
            $sheet->setCellValue('E' . $x, kategori($row->kategori));
            $sheet->setCellValue('F' . $x, $row->harga);
            $sheet->setCellValue('G' . $x, $row->berat);
            $sheet->setCellValue('H' . $x, $row->stok);
            $sheet->getStyle('A' . $x)->applyFromArray($borderStyle);
            $sheet->getStyle('B' . $x)->applyFromArray($borderStyle);
            $sheet->getStyle('C' . $x)->applyFromArray($borderStyle);
            $sheet->getStyle('D' . $x)->applyFromArray($borderStyle);
            $sheet->getStyle('E' . $x)->applyFromArray($borderStyle);
            $sheet->getStyle('F' . $x)->applyFromArray($borderStyle);
            $sheet->getStyle('G' . $x)->applyFromArray($borderStyle);
            $sheet->getStyle('H' . $x)->applyFromArray($borderStyle);
            $sheet->getStyle('F' . $x)->applyFromArray($numberFormat);
            $sheet->getStyle('G' . $x)->applyFromArray($numberFormat);
            $sheet->getStyle('H' . $x)->applyFromArray($numberFormat);
            $x++;
        }

        $sheet->getColumnDimension('A')->setAutoSize(true);
        $sheet->getColumnDimension('B')->setAutoSize(true);
        $sheet->getColumnDimension('C')->setAutoSize(true);
        $sheet->getColumnDimension('D')->setAutoSize(true);
        $sheet->getColumnDimension('E')->setAutoSize(true);
        $sheet->getColumnDimension('F')->setAutoSize(true);
        $sheet->getColumnDimension('G')->setAutoSize(true);
        $sheet->getColumnDimension('H')->setAutoSize(true);

        // Menambahkan gambar ke lembar kerja
        $drawing->setWorksheet($sheet);
        $writer = new Xlsx($spreadsheet);
        $filename = 'Data Produk ' . tgl(tanggal());

        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
    }
    public function print($kode)
    {
        $data['dataTransaksi'] = $this->db->get_where('transaksi', ['kode_transaksi' => $kode])->result_array();
        $data['kode'] = $kode;
        $this->load->view('admin/produk/print', $data);
    }
    public function printOnline($kode)
    {
        $data['dataTransaksi'] = $this->db->get_where('transaksi', ['kode_transaksi' => $kode])->result_array();
        $data['kode'] = $kode;
        $this->load->view('admin/produk/printOnline', $data);
    }
    public function dataProduk()
    {
        $dataProduk = $this->db->get_where('produk', ['is_active' => 1])->num_rows();
        echo json_encode($dataProduk);
    }
    public function dataUser()
    {
        $dataProduk = $this->db->get_where('user', ['is_active' => 1])->num_rows();
        echo json_encode($dataProduk);
    }
    public function totalTransaksi()
    {
        $dataProduk = $this->db->get('transaksi')->num_rows();
        echo json_encode($dataProduk);
    }
    public function pesananMasuk()
    {
        $this->db->where('tipe_pembayaran !=', 'tunai');
        $this->db->where('status', 200);
        $dataProduk = $this->db->get('transaksi')->num_rows();
        echo json_encode($dataProduk);
    }
}
