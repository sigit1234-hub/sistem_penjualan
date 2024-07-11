<?php

defined('BASEPATH') or exit('No direct script access allowed');



class Menu_model extends CI_Model
{
    public function getSubMenu()
    {
        //join tbl user_sub_menu dan tbl Menu
        $query = "SELECT user_sub_menu.*,user_menu.menu
                    FROM user_sub_menu JOIN user_menu
                      ON user_sub_menu.menu_id = user_menu.id/**id agar dapat nama menunya */
        ";
        return $this->db->query($query)->result_array();
    }
    public function getJabatan()
    {
        $query = "SELECT jabatan.*,devisi.nama_divisi 
                  FROM jabatan JOIN devisi
                  ON jabatan.id_jabatan = devisi.id
        ";
        return $this->db->query($query)->result_array();
    }
    public function hapus_member($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('user_sub_menu');
    }
    public function hapus_divisi($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('devisi');
    }
    public function hapus_jabatan($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('jabatan');
    }
    public function edit_data($where, $table)
    {
        return $this->db->get_where($table, $where);
    }
    public function update_data($where, $data, $table)
    {
        $this->db->where($where);
        $this->db->update($table, $data);
    }
    //join table for SPL
    public function getEmail()
    {
        $querydevisi = " SELECT 'spl.*,'devisi'.'email'
                           FROM 'spl' JOIN 'devisi'
                             ON 'spl'.'devisi' = 'devisi'.'id'           
        ";
        return $this->db->query($querydevisi)->result_array();
    }
    public function getkaryawan()
    {
        //join tbl user_sub_menu dan tbl Menu
        $query = $this->db->get('data_user');
        return $this->db->query($query)->result_array();
    }
    // set divisi
    public function tampil_divisi($id = null)
    {
        $this->db->from('devisi');
        if ($id !== null) {
            $this->db->where('id', $id);
        }
        $query = $this->db->order_by('id', 'DESC')->get()->result_array();
        return $query;
    }
    public function tampil_jabatan($id = null)
    {
        $this->db->from('jabatan');
        if ($id !== null) {
            $this->db->where('id', $id);
        }
        $query = $this->db->order_by('id', 'DESC')->get()->result_array();
        return $query;
    }
    public function editDivisi($post)
    {
        $id = $this->input->post('id', true);
        $data = [
            'nama_divisi' => htmlspecialchars($this->input->post('divisi', true)),
            'email_head' => htmlspecialchars($this->input->post('email', true))
        ];
        $this->db->where('id', $id);
        $this->db->update('devisi', $data);
    }
    public function editjabatan($post)
    {
        $id = $this->input->post('id', true);
        $data = [
            'id_jabatan' => htmlspecialchars($this->input->post('idjabatan', true)),
            'nama' => htmlspecialchars($this->input->post('nama', true)),
            'is_active' => htmlspecialchars($this->input->post('is_active', true)),
        ];
        $this->db->where('id', $id);
        $this->db->update('jabatan', $data);
    }
    public function data_jabatan($id_div)
    {
        $jab =  $this->db->get_where('jabatan', array('id_jabatan' => $id_div));
        echo "<option>Pilih Jabatan</option>";
        foreach ($jab->result_array() as $row) {
            // echo  "<option value='" . $row['id'] . "'>" . $row['nama'] . "</option>";
            echo  "<option >" . $row['nama'] . "</option>";
        }
    }
    public function tampil_data($id = null)
    {
        $this->db->from('user_menu');
        if ($id != null) {
            $this->db->where('id', $id);
        }
        return $this->db->order_by('id', 'DESC')->get();
    }
}
