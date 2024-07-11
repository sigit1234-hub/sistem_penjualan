<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Notifikasi_m extends CI_Model
{
    public function totalProduk()
    {
        $this->db->get_where('produk', ['active' => 1])->result_array();
    }
}
