<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Keranjang_m extends CI_Model
{
    public function data_user()
    {
        $sql = $this->db->order_by('id', 'ASC')->get('user')->result_array();
        return $sql;
    }
    public function getMax($table = null, $field = null)
    {
        $this->db->select_max($field);
        return $this->db->get($table)->row_array()[$field];
    }

    public function getKeranjang($table, $limit, $start, $keyword = null)
    {
        $this->db->select('*');
        $this->db->from($table);
        $this->db->join('produk', 'produk.id_produk = keranjang.id_produk');
        $this->db->join('user', 'user.id = keranjang.id_user');
        if ($keyword) {
            $this->db->like('keranjang.id_produk', $keyword);
            $this->db->or_like('keranjang.id_user', $keyword);
            $this->db->or_like('keranjang.jumlah', $keyword);
        }
        $this->db->where('keranjang.id_user', $this->session->userdata('id'));
        $this->db->order_by('keranjang.id_keranjang', 'DESC');
        $this->db->limit($limit, $start);
        // $this->db->group_start($start);
        return $this->db->get()->result_array();
    }
    public function hitung_users()
    {
        return $this->db->get('user')->num_rows();
    }
    //pagination

    //add new user
    public function addUser($post)
    {
        $data = [
            'nama' => htmlspecialchars($this->input->post('nama', true)),
            'email' => htmlspecialchars($this->input->post('email', true)),
            'password' => password_hash(htmlspecialchars($this->input->post('password', true)), PASSWORD_DEFAULT),
            'tlp' => htmlspecialchars($this->input->post('no_tlp', true)),
            'alamat' => htmlspecialchars($this->input->post('alamat', true)),
            'role_id' => htmlspecialchars($this->input->post('role_id', true)),
            'is_active' => 1,
            'date_created' => date('Y-m-d H:i:s')
        ];

        $foto = $_FILES['foto'];
        if ($foto) {
            $config['upload_path'] = './assets/img/user/';
            $config['allowed_types'] = 'jpg|png|jpeg';
            $config['max_size'] = '1000';
            $this->load->library('upload', $config);

            if ($this->upload->do_upload('foto')) {
                $new_file = $this->upload->data('file_name');
                $this->db->set('foto', $new_file);
            } else {
                echo $this->upload->display_errors();
                $this->session->set_flashdata('flash', 'Ditambahkan');
                redirect('Admin/user');
            }
        } else {
            $this->db->set('foto', 'default.jpg');
        }
        $this->db->insert('user', $data);
        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
            Pengguna baru berhasil ditambah!!!</div>');
        redirect('Admin/user');
    }
    public function editUser($post)
    {
        $id = htmlspecialchars($this->input->post('id'));
        $data = [
            'nama' => htmlspecialchars($this->input->post('nama', true)),
            'email' => htmlspecialchars($this->input->post('email', true)),
            'password' => password_hash(htmlspecialchars($this->input->post('password', true)), PASSWORD_DEFAULT),
            'tlp' => htmlspecialchars($this->input->post('no_tlp', true)),
            'alamat' => htmlspecialchars($this->input->post('alamat', true)),
            'role_id' => htmlspecialchars($this->input->post('role_id', true)),
            'is_active' => htmlspecialchars($this->input->post('is_active', true)),
            'date_created' => date('Y-m-d H:i:s'),
        ];
        $foto = $_FILES['foto'];
        if ($foto) {
            $config['upload_path'] = './assets/img/user/';
            $config['allowed_types'] = 'jpg|png|jpeg';
            $config['max_size'] = '1000';

            $this->load->library('upload', $config);
            if ($this->upload->do_upload('foto')) {
                $new_file = $this->upload->data('file_name');
                $this->db->set('foto', $new_file);
                $gambar_lama = $this->input->post('foto_lama', true);
                if ($gambar_lama != 'default.png') {
                    unlink(FCPATH . 'assets/img/user/' . $gambar_lama);
                } else if ($gambar_lama == $foto) {
                    unlink(FCPATH . 'assets/img/user/' . $gambar_lama);
                }
            } else {
                echo $this->upload->display_errors();
            }
        } else {
            $this->db->set('foto', 'default.jpg');
        }
        $this->db->where('id', $id);
        $this->db->update('user', $data);
        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
        Pengguna baru berhasil diubah!!!</div>');
        redirect('Admin/user');
    }

    // Produk

    public function getProduk($limit, $start, $keyword = null)
    {
        if ($keyword) {
            $this->db->like('nama_produk', $keyword);
            $this->db->or_like('kode_produk', $keyword);
            $this->db->or_like('kategori', $keyword);
            $this->db->or_like('harga', $keyword);
            $this->db->or_like('stok', $keyword);
        }
        return $this->db->order_by('id_produk', 'DESC')->get('produk', $limit, $start)->result_array();
    }
    public function inputProduk()
    {
        $lcode = $this->getMax('produk', 'kode_produk');
        $noUrut = (int)substr($lcode, -4, 4);
        $noUrut++;
        $code = 'P' . sprintf('%04s', $noUrut);

        $data = [
            'kode_produk' => $code,
            'nama_produk' => htmlspecialchars($this->input->post('nama', true)),
            'kategori' => htmlspecialchars($this->input->post('kategori', true)),
            'harga' => htmlspecialchars($this->input->post('harga', true)),
            'stok' => htmlspecialchars($this->input->post('stok', true)),
            'berat' => htmlspecialchars($this->input->post('berat', true)),
            'deskripsi' => htmlspecialchars($this->input->post('deskripsi', true)),
            'id_petugas' => htmlspecialchars($this->input->post('id_petugas', true)),
            'tgl_input' => date('Y-m-d H:i:s'),
        ];

        $this->db->insert('produk', $data);

        $config['upload_path'] = './assets/img/produk/';
        $config['allowed_types'] = 'gif|jpg|png';
        $config['max_size'] = 1000;

        $this->load->library('upload', $config);

        $files = $_FILES;
        $file_count = count($files['gambar']['name']);

        for ($i = 0; $i < $file_count; $i++) {
            $_FILES['userfile']['name']     = $files['gambar']['name'][$i];
            $_FILES['userfile']['type']     = $files['gambar']['type'][$i];
            $_FILES['userfile']['tmp_name'] = $files['gambar']['tmp_name'][$i];
            $_FILES['userfile']['error']    = $files['gambar']['error'][$i];
            $_FILES['userfile']['size']     = $files['gambar']['size'][$i];

            if (!$this->upload->do_upload('userfile')) {
                $error = array('error' => $this->upload->display_errors());
                redirect('Admin/produk', $error);
                return; // Exit the loop if any file fails to upload
            }
            $foto = $this->upload->data('file_name');
            $data = [
                'kode_produk' => $code,
                'nama_gambar' => $foto,
                'is_active' => 1
            ];
            $this->db->insert('gambar_produk', $data);
        }

        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
        Data Berhasil ditambahkan</div>');
        redirect('Admin/produk');
    }

    public function editProduk($post)
    {
        $id = htmlspecialchars($this->input->post('id', true));
        $kode = htmlspecialchars($this->input->post('kode', true));

        $dataUpdate = [
            'nama_produk' => htmlspecialchars($this->input->post('nama', true)),
            'kategori' => htmlspecialchars($this->input->post('kategori', true)),
            'harga' => htmlspecialchars($this->input->post('harga', true)),
            'berat' => htmlspecialchars($this->input->post('berat', true)),
            'stok' => htmlspecialchars($this->input->post('stok', true)),
            'diskon' => htmlspecialchars($this->input->post('diskon', true)),
            'deskripsi' => htmlspecialchars($this->input->post('deskripsi', true)),
            'tgl_update' => date('Y-m-d H:i:s'),
            'id_updatePetugas' => $this->session->userdata['id']
        ];

        $this->db->where('id_produk', $id);
        $this->db->update('produk', $dataUpdate);
        // Ini buat handle gambar lama 
        $files = $_FILES;
        $old = $_POST['gambar_old'];
        $jumlahOld = count($old);
        $gID = $_POST['gambar_id'];
        $ubah = $_POST['gambarUbah'];

        for ($i = 0; $i < $jumlahOld; $i++) {


            if ($ubah[$i] == 1 && $gID[$i] != 1) {
                $config['upload_path'] = './assets/img/produk/';
                $config['allowed_types'] = 'gif|jpg|png';
                $config['max_size'] = 1000;

                $this->load->library('upload', $config);

                $files = $_FILES;

                $_FILES['userfile']['name']     = $files['gambar']['name'][$i];
                $_FILES['userfile']['type']     = $files['gambar']['type'][$i];
                $_FILES['userfile']['tmp_name'] = $files['gambar']['tmp_name'][$i];
                $_FILES['userfile']['error']    = $files['gambar']['error'][$i];
                $_FILES['userfile']['size']     = $files['gambar']['size'][$i];

                if (!$this->upload->do_upload('userfile')) {
                    $error = array('error' => $this->upload->display_errors());
                    redirect('Admin/produk', $error);
                    return; // Exit the loop if any file fails to upload
                }
                // $fotoLama = $old[$i];
                if ($old[$i] != 'default.png') {
                    unlink(FCPATH . 'assets/img/produk/' . $old[$i]);
                }
                $foto = $this->upload->data('file_name');
                $data = [
                    'nama_gambar' => $files['gambar']['name'][$i]
                ];
                $this->db->where('id_gambar', $gID[$i]);
                $this->db->update('gambar_produk', $data);

                echo $gID[$i];
                echo $files['gambar']['name'][$i];
            } else if ($ubah[$i] == 0 && $gID[$i] != 1) {
                if ($old[$i] != 'default.png') {
                    unlink(FCPATH . 'assets/img/produk/' . $old[$i]);
                }
                $data = [
                    'nama_gambar' => $old[$i]
                ];
                $this->db->where('id_gambar', $gID[$i]);
                $this->db->delete('gambar_produk', $data);
            } else if ($ubah[$i] == '' && $gID[$i] == 1) {
            }
        }

        $f_gambar = count($_POST['newGambar2']);
        if ($f_gambar > 1) {
            $this->gambarBaru($kode);
        } else {
        }
        // $this->gambarBaru($kode);

        // Handle Gambar Baru 


    }
    public function gambarBaru($kode)
    {

        $f_gambar = $_FILES;
        $file_count = count($f_gambar['newGambar']['name']);


        for ($i = 0; $i < $file_count; $i++) {
            $config['upload_path'] = './assets/img/produk/';
            $config['allowed_types'] = 'gif|jpg|png';
            $config['max_size'] = 1000;

            $this->load->library('upload', $config);
            $_FILES['userfile']['name']     = $f_gambar['newGambar']['name'][$i];
            $_FILES['userfile']['type']     = $f_gambar['newGambar']['type'][$i];
            $_FILES['userfile']['tmp_name'] = $f_gambar['newGambar']['tmp_name'][$i];
            $_FILES['userfile']['error']    = $f_gambar['newGambar']['error'][$i];
            $_FILES['userfile']['size']     = $f_gambar['newGambar']['size'][$i];

            if (!$this->upload->do_upload('userfile')) {
                $error = array('error' => $this->upload->display_errors());
                redirect('Admin/produk', $error);
                return; // Exit the loop if any file fails to upload
            }
            $foto = $this->upload->data('file_name');
            $data = [
                'kode_produk' => $kode,
                'nama_gambar' => $foto,
                'is_active' => 1
            ];
            $this->db->insert('gambar_produk', $data);
        }
    }


    // Kategori
    public function getKategori($limit, $start, $keyword = null)
    {
        if ($keyword) {
            $this->db->like('nama_kategori', $keyword);
        }
        return $this->db->get('kategori', $limit, $start)->result_array();
    }
    public function tambahKategori($post)
    {
        $kategori = $_POST['kategori'];
        $jumlah = count($kategori);

        for ($i = 0; $i < $jumlah; $i++) {
            $data = [
                'nama_kategori' => $_POST['kategori'][$i],
                'is_active' => 1
            ];
            $this->db->insert('kategori', $data);
        }
        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
        Data Berhasil ditambahkan</div>');
        redirect('Admin/kategori');
    }
    public function histori($kode, $tanggal, $status, $idProduk, $jumlah)
    {
        $data = [
            'kode_transaksi' => $kode,
            'tanggal' => $tanggal,
            'status' => $status
        ];
        $this->db->insert('histori', $data);
    }
    public function hapusProduk($idProduk)
    {
        $id = explode(",", $idProduk);

        for ($i = 0; $i < count($id); $i++) {
            $this->db->where('id_keranjang', $id[$i]);
            $this->db->delete('keranjang');
        }
    }
    public function stokKurang($idProd, $jumlah)
    {
        $id = explode(",", $idProd);
        $qty = explode(",", $jumlah);

        for ($i = 0; $i < count($id); $i++) {
            // $this->db->select('stok');
            $this->db->where('id_produk', $id[$i]);
            $getStok = $this->db->get('produk')->row_array();
            $nilai = intval($qty[$i]);
            $hasil = intval($getStok['stok']) - $nilai;
            $data = ['stok' => $hasil];
            $this->db->where('id_produk', $id[$i]);
            $this->db->update('produk', $data);
        }
    }
}
