<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Transaksi_m extends CI_Model
{
    public function getMax($table = null, $field = null)
    {
        $this->db->select_max($field);
        return $this->db->get($table)->row_array()[$field];
    }
    public function get_products($searchTerm)
    {
        $this->db->select('nama_produk, kode_produk, stok');
        $this->db->like('nama_produk', $searchTerm);
        $query = $this->db->get('produk'); // Sesuaikan dengan nama tabel Anda
        return $query->result_array();
    }
    public function checkout($post)
    {
        $harga  = $this->input->post('tampungHarga');
        $qty  = $this->input->post('tampungQty');
        $grandTotal  = $this->input->post('grandTotalHarga');
        $grandDiskon  = $this->input->post('grandDiskon');
        $kembalian = $this->input->post('kembalian');
        $idProd = $this->input->post('tampungKode');
        $user = $this->input->post('user');
        $catatan = $this->input->post('catatan');

        $table = "transaksi";
        $field = "kode_transaksi";
        $lastcode = $this->getMax($table, $field);
        //mengambil 4 nomor urut dari belakang
        $noUrut = (int)substr($lastcode, -4, 4); //substr =sub string mengambil string yang ada dalam db (int) agar berubah jadi int,-4 mengambil nomor urut dari belakang sebanyak 4
        $noUrut++;
        $today = date('ymds');
        //ubah kembali jadi string
        $str = "DB";
        $kodeBaru = $str . $today . sprintf('%04s', $noUrut);

        $data = [
            'id_produk' => $idProd,
            'harga_produk' => $harga,
            'id_user' => $this->session->userdata('id'),
            'jumlah' => $qty,
            'user' => $user,
            'kurir' => '',
            'paket' => '',
            'kode_transaksi' => $kodeBaru,
            'total_pembayaran' => str_replace(".", "", $grandTotal),
            'tipe_pembayaran' => 'tunai',
            'tanggal_transaksi' => tanggal(),
            'bank' => '',
            'va_number' => '',
            'total_diskon' => str_replace(".", "", $grandDiskon),
            'kembalian' => $kembalian,
            'catatan' => $catatan,
            'status' => 204,
        ];

        $simpan = $this->db->insert('transaksi', $data);
        // $simpan = '';
        if ($simpan) {
            $this->Keranjang_m->stokKurang($idProd, $qty);
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
            Pesanan Berhasil dibuat</div>');
            // redirect('Kasir/Penjualan');
            $this->print($kodeBaru, $user);
        } else {
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
            Transaksi Gagal</div>');
            $link = $this->session->userdata('link');
            $url = explode("/", $link);
            redirect($url[4] . "/" . $url[5] . "/" . $url[6]);
            $this->session->unset_userdata('link');
        }
    }
    public function print($kode, $user)
    {
        $data['dataTransaksi'] = $this->db->get_where('transaksi', ['kode_transaksi' => $kode]);
        $data['tgl'] = $data['dataTransaksi']->row_array()['tanggal_transaksi'];
        $data['kode'] = $kode;
        $data['user'] = $user;
        $data['catatan'] = $data['dataTransaksi']->row_array()['catatan'];
        $this->load->view('admin/penjualan/print', $data);
    }

    public function token()
    {
        $table = "transaksi";
        $field = "kode_transaksi";
        $lastcode = $this->getMax($table, $field);
        //mengambil 4 nomor urut dari belakang
        $noUrut = (int)substr($lastcode, -4, 4); //substr =sub string mengambil string yang ada dalam db (int) agar berubah jadi int,-4 mengambil nomor urut dari belakang sebanyak 4
        $noUrut++;
        $today = date('ymds');
        //ubah kembali jadi string
        $str = "DB";
        $newCode = $str . $today . sprintf('%04s', $noUrut); //%04s = merubah dari 1 digit jadi 4 ext 1 = 0001

        $ongkir = $this->input->post('ongkir');
        $nama = $this->input->post('namaProduk');
        $quantity = $this->input->post('qty');
        $harga = $this->input->post('harga');
        $kurir = $this->input->post('kurir');
        $jumlah = $this->input->post('jumlahJS');
        $user = $this->db->get_where('user', ['id' => $this->session->userdata('id')])->row_array();
        // Required
        $transaction_details = array(
            'order_id' => $newCode, //random
            'gross_amount' => $jumlah, // no decimal allowed for creditcard
        );

        // Optional
        $item1_details = array(

            'id' => 1,
            'price' => $harga,
            'quantity' => $quantity,
            'name' => $nama,
        );

        // Optional
        $item2_details = array(
            'id' => '2',
            'price' => $ongkir,
            'quantity' => 1,
            'name' => $kurir
        );

        // Optional
        $item_details = array($item1_details, $item2_details);
        // $item_details = array($item1_details);

        // Optional
        $billing_address = array(
            'first_name'    => $nama,
            'last_name'     => "",


        );

        // Optional
        $shipping_address = array(
            'first_name'    => $nama,
            'last_name'     => "",

        );

        // Optional
        $customer_details = array(
            'first_name'    => $user['nama'],
            'email' => $user['email'],
            'phone'     =>  $user['tlp'],

        );

        // Data yang akan dikirim untuk request redirect_url.
        $credit_card['secure'] = true;
        //ser save_card true to enable oneclick or 2click
        //$credit_card['save_card'] = true;

        $time = time();
        $custom_expiry = array(
            'start_time' => date("Y-m-d H:i:s O", $time),
            'unit' => 'minute',
            'duration'  => 10
        );

        $transaction_data = array(
            'transaction_details' => $transaction_details,
            'item_details'       => $item_details,
            'customer_details'   => $customer_details,
            'credit_card'        => $credit_card,
            'expiry'             => $custom_expiry
        );

        error_log(json_encode($transaction_data));
        $snapToken = $this->midtrans->getSnapToken($transaction_data);
        error_log($snapToken);
        echo $snapToken;
    }
    public function tokenKeranjang()
    {
        $this->db->select('kode_transaksi');
        $this->db->limit(1);
        $query = $this->db->order_by('id_transaksi', 'DESC')->get('transaksi')->row();
        $lastcode = $query->kode_transaksi;
        //mengambil 4 nomor urut dari belakang
        $noUrut =  (int)substr($lastcode, -4, 4);; //substr =sub string mengambil string yang ada dalam db (int) agar berubah jadi int,-4 mengambil nomor urut dari belakang sebanyak 4
        $noUrut++;
        $today = date('ymds');
        //ubah kembali jadi string
        $str = "DB";
        $newCode = $str . $today . sprintf('%04s', $noUrut); //%04s = merubah dari 1 digit jadi 4 ext 1 = 0001

        $ongkir = $this->input->post('ongkir');
        $nama = $this->input->post('namaProduk');
        $quantity = $this->input->post('qty');
        $harga = $this->input->post('harga');
        $kurir = $this->input->post('kurir');
        $jumlah = $this->input->post('jumlahJS');
        $user = $this->db->get_where('user', ['id' => $this->session->userdata('id')])->row_array();
        // Required
        $transaction_details = array(
            'order_id' => $newCode, //random
            'gross_amount' => $jumlah, // no decimal allowed for creditcard
        );

        // Optional
        $item1_details = array(

            'id' => 1,
            'price' => $harga,
            'quantity' => $quantity,
            'name' => $nama,
        );

        // Optional
        $item2_details = array(
            'id' => '2',
            'price' => $ongkir,
            'quantity' => 1,
            'name' => $kurir
        );

        // Optional
        $item_details = array($item1_details, $item2_details);
        // $item_details = array($item1_details);

        // Optional
        $billing_address = array(
            'first_name'    => $nama,
            'last_name'     => "",


        );

        // Optional
        $shipping_address = array(
            'first_name'    => $nama,
            'last_name'     => "",

        );

        // Optional
        $customer_details = array(
            'first_name'    => $user['nama'],
            'email' => $user['email'],
            'phone'     =>  $user['tlp'],

        );

        // Data yang akan dikirim untuk request redirect_url.
        $credit_card['secure'] = true;
        //ser save_card true to enable oneclick or 2click
        //$credit_card['save_card'] = true;

        $time = time();
        $custom_expiry = array(
            'start_time' => date("Y-m-d H:i:s O", $time),
            'unit' => 'minute',
            'duration'  => 10
        );

        $transaction_data = array(
            'transaction_details' => $transaction_details,
            'item_details'       => $item_details,
            'customer_details'   => $customer_details,
            'credit_card'        => $credit_card,
            'expiry'             => $custom_expiry
        );

        error_log(json_encode($transaction_data));
        $snapToken = $this->midtrans->getSnapToken($transaction_data);
        error_log($snapToken);
        echo $snapToken;
    }
    public function histori($kode, $tanggal, $status)
    {
        $data = [
            'kode_transaksi' => $kode,
            'tanggal' => $tanggal,
            'status' => $status
        ];
        $this->db->insert('histori', $data);
    }
    public function getDataProduk()
    {
        return $this->db->order_by('id_produk', 'Desc')->get_where('produk', ['id_produk' => 26])->row_array();
    }
    public function getTransaksiToko($table, $limit, $start, $keyword = null)
    {
        $this->db->where('tipe_pembayaran', 'tunai');
        if ($keyword) {
            $this->db->like('kode_transaksi', $keyword);
            $this->db->or_like('tanggal_transaksi', $keyword);
        }
        $this->db->order_by('tanggal_transaksi', 'DESC');
        return $this->db->get($table, $limit, $start)->result_array();
    }
    public function getTransaksiWeb($table, $limit, $start, $keyword = null)
    {
        $this->db->where('tipe_pembayaran !=', 'tunai');
        if ($keyword) {
            $this->db->like('tanggal_transaksi', $keyword);
            $this->db->or_like('kode_transaksi', $keyword);
            $this->db->or_like('kurir', $keyword);
            $this->db->or_like('paket', $keyword);
        }
        $this->db->order_by('tanggal_transaksi', 'DESC');
        return $this->db->get($table, $limit, $start)->result_array();
    }
    public function getDataTransaksi($status, $tglDari, $tglSampai, $role)
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
            $tgl =  "tanggal_transaksi LIKE '$tglDari%'";
        } else {
            $tgl = "tanggal_transaksi BETWEEN '$tglDari%' AND '$tglSampai%'";
        }
        $sql = "SELECT * FROM transaksi WHERE $tipe AND $tgl $st ORDER BY tanggal_transaksi ASC";
        return $this->db->query($sql)->result_array();

        // return $this->db->order_by('tanggal_transaksi', 'DESC')->get('transaksi')->result_array();
    }
}
