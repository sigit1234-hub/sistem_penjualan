<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Produk_m extends CI_Model
{
    public function tampil_data($id = null)
    {
        if ($id != null) {
            $sql = $this->db->order_by('id', 'Desc')->get_where('produk', ['id' => $id])->row_array();
            return $sql;
        } else {
            $sql = $this->db->order_by('id', 'Desc')->get_where('karyawan', ['username' => $this->session->userdata('username')])->row_array();
            return $sql;
        }
    }
    public function getProduks($table, $limit, $start, $keyword = null)
    {
        if ($keyword) {
            $this->db->like('nama_produk', $keyword);
            $this->db->or_like('kode_produk', $keyword);
            $this->db->or_like('harga', $keyword);
            $this->db->or_like('stok', $keyword);
            $this->db->or_like('kategori', $keyword);
        }
        return $this->db->get($table, $limit, $start)->result_array();
    }
    public function dataDiskon()
    {
        $this->db->where('diskon !=', 0);
        $query = $this->db->order_by('tgl_update', 'DESC')->get('produk')->result_array();
        return $query;
    }
    public function tampilDiskon()
    {
        $this->db->select('kategori');
        $this->db->distinct();
        $this->db->where('diskon !=', 0);
        return $this->db->order_by('id_produk', 'ASC')->get('produk')->result_array();
    }
    public function newProduk()
    {
        $this->db->limit(10);
        return $this->db->order_by('id_produk', 'ASC')->get('produk')->result_array();
    }
    public function details($id)
    {
        $this->db->where('id_produk', $id);
        return  $this->db->get('produk')->result_array();
    }
    public function produkSerupa($id)
    {
        $this->db->select('kategori');
        $this->db->where('id_produk', $id);
        $sql = $this->db->get('produk')->row_array();
        $kategori =  $sql['kategori'];

        $this->db->where('kategori', $kategori);
        return $this->db->get('produk')->result_array();
    }
    public function dataKategori()
    {
        return $this->db->order_by('nama_kategori', 'ASC')->get('kategori')->result_array();
    }
}
