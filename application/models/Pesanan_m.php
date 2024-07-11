<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Pesanan_m extends CI_Model
{
    public function getPesanan($table, $limit, $start, $keyword = null)
    {
        $id = $this->session->userdata('id');
        $this->db->select('*, transaksi.id_produk AS t_idProduk');
        $this->db->from($table);
        $this->db->join('produk', 'produk.id_produk = transaksi.id_produk');
        $this->db->join('user', 'user.id = transaksi.id_user');
        if ($keyword) {
            $this->db->like('produk.nama_produk', $keyword);
            $this->db->or_like('produk.kode_produk', $keyword);
            $this->db->or_like('produk.harga', $keyword);
            $this->db->or_like('produk.stok', $keyword);
            $this->db->or_like('produk.kategori', $keyword);
        }
        $this->db->where('transaksi.id_user', $id);
        $this->db->where('transaksi.tipe_pembayaran !=', 'tunai');
        $this->db->order_by('transaksi.id_transaksi', 'DESC');
        $this->db->limit($limit, $start);
        // $this->db->group_start($start);
        return $this->db->get()->result_array();
    }
}
