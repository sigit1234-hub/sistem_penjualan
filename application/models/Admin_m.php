<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Admin_m extends CI_Model
{
    public function data_user()
    {
        $sql = $this->db->order_by('id', 'ASC')->get('user')->result_array();
        return $sql;
    }

    public function getUsers($table, $limit, $start, $keyword = null)
    {
        if ($keyword) {
            $this->db->like('nama', $keyword);
            $this->db->or_like('email', $keyword);
            $this->db->or_like('alamat', $keyword);
            $this->db->or_like('role_id', $keyword);
            $this->db->or_like('tlp', $keyword);
        }
        return $this->db->get($table, $limit, $start)->result_array();
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
        if ($this->input->post('password') == '') {
            $data = [
                'nama' => htmlspecialchars($this->input->post('nama', true)),
                'email' => htmlspecialchars($this->input->post('email', true)),
                'tlp' => htmlspecialchars($this->input->post('no_tlp', true)),
                // 'alamat' => htmlspecialchars($this->input->post('alamat', true)),
                'role_id' => htmlspecialchars($this->input->post('role_id', true)),
                'is_active' => htmlspecialchars($this->input->post('is_active', true)),
                'date_created' => date('Y-m-d H:i:s'),
            ];
        } else {
            $data = [
                'nama' => htmlspecialchars($this->input->post('nama', true)),
                'email' => htmlspecialchars($this->input->post('email', true)),
                'password' => password_hash(htmlspecialchars($this->input->post('password', true)), PASSWORD_DEFAULT),
                'tlp' => htmlspecialchars($this->input->post('no_tlp', true)),
                // 'alamat' => htmlspecialchars($this->input->post('alamat', true)),
                'role_id' => htmlspecialchars($this->input->post('role_id', true)),
                'is_active' => htmlspecialchars($this->input->post('is_active', true)),
                'date_created' => date('Y-m-d H:i:s'),
            ];
        }

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
    public function getMax($table = null, $field = null)
    {
        $this->db->select_max($field);
        return $this->db->get($table)->row_array()[$field];
    }
    public function getKodeKategori($id)
    {
        $this->db->where('id_kategori', $id);
        return $this->db->get('kategori')->row_array();
    }
    public function inputProduk()
    {
        $this->db->select('kode_produk');
        $this->db->limit(1);
        $query = $this->db->order_by('id_produk', 'DESC')->get('produk')->row();
        $lastcode = $query->kode_produk;

        $kode = $this->getKodeKategori($this->input->post('kategori'));
        $noUrut = (int)substr($lastcode, -4, 4);
        $noUrut++;
        $code = $kode['kode'] . sprintf('%04s', $noUrut);
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
            'is_active' => 1
        ];

        $this->db->insert('produk', $data);

        $config['upload_path'] = './assets/img/produk/';
        $config['allowed_types'] = 'gif|jpg|png';
        $config['max_size'] = 3000;

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
        if ($this->input->post('gambar_old')) {
            $old = $_POST['gambar_old'];
            $jumlahOld = count($old);
            $gID = $_POST['gambar_id'];
            $ubah = $_POST['gambarUbah'];
        } else {
            $old = 'ksong gambarnya';
            $jumlahOld = 0;
            $gID = 0;
            $ubah = 0;
        }
        // $old = $_POST['gambar_old'];

        for ($i = 0; $i < $jumlahOld; $i++) {


            if ($ubah[$i] == 1 && $gID[$i] != 1) {
                $config['upload_path'] = './assets/img/produk/';
                $config['allowed_types'] = 'gif|jpg|png';
                $config['max_size'] = 1500;

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
    public function hapusProduk($kode, $id)
    {
        $this->db->where('kode_produk', $kode);
        $sql = $this->db->get('gambar_produk')->result_array();

        $gambar = count($sql);
        // echo $gambar;

        foreach ($sql as $d) {
            unlink(FCPATH . 'assets/img/produk/' . $d['nama_gambar']);

            $this->db->where('id_gambar', $d['id_gambar']);
            $this->db->delete('gambar_produk');
        }

        $this->db->where('id_produk', $id);
        $this->db->delete('produk');

        // $this->db->delete('produk', array('id_produk' => $id));
        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
                 Data produk ' . $kode . ' berhasil <b>dihapus</b> !!</div>');
        redirect('Admin/produk');
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
                'kode' => $_POST['kode'][$i],
                'is_active' => 1
            ];
            $this->db->insert('kategori', $data);
        }
        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
        Data Berhasil ditambahkan</div>');
        redirect('Admin/kategori');
    }
    public function getDataCetak($stok, $kategori)
    {
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
        $sql = $this->db->order_by('stok', 'ASC')->get('produk')->result_array();
        return $sql;
    }
    public function pesananMasuk()
    {
        $this->db->where('tipe_pembayaran !=', 'tunai');
        $this->db->where('status', 200);
        $dataTransaksi = $this->db->get('transaksi')->result_array();
        return $dataTransaksi;
    }
    public function Kasir()
    {
        $this->db->where('tipe_pembayaran', 'tunai');
        $dataTransaksi = $this->db->get('transaksi')->result_array();
        return $dataTransaksi;
    }
    public function stokTipis()
    {
        $this->db->where('stok <=', 100);
        return $this->db->get('produk')->result_array();
    }
}
