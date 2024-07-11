<?php
defined('BASEPATH') or exit('No direct script access allowed');
class User_m extends CI_Model
{
    public function dataUser()
    {
        return $this->db->get_where('user', ['id' => $this->session->userdata('id')])->result_array();
    }
    public function dataAlamat()
    {
        return $this->db->get_where('alamat', ['id_user' => $this->session->userdata('id')])->result_array();
    }

    public function add_karyawan($post)
    {
        $data = [
            'nama' => htmlspecialchars($this->input->post('nama', true)),
            'password' => htmlspecialchars($this->input->post('password', true)),
            'username' => htmlspecialchars($this->input->post('username', true)),
            'departemen' => htmlspecialchars($this->input->post('departemen', true)),
            'email' => htmlspecialchars($this->input->post('email', true)),
            'is_active' => 1,
            'role_id' => htmlspecialchars($this->input->post('role', true)),
        ];
        $upload_image = $_FILES['foto'];
        if ($upload_image) {
            $config['upload_path']          = './assets/img/profile/';
            $config['allowed_types']        = 'gif|jpg|png|jpeg|PNG';
            $config['max_size']             = 2048;
            $this->load->library('upload', $config);
            if ($this->upload->do_upload('foto')) {
                $new_image = $this->upload->data('file_name');
                $this->db->set('foto', $new_image);
            } else {
                echo $this->upload->display_errors();
                $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
                           Input data karyawan gagal!</div>');
                redirect('menu/data_karyawan');
            }
        }
        $this->db->insert('karyawan', $data);
    }
    public function updateUser($post)
    {
        $id = htmlspecialchars($this->input->post('id'));
        $kode = $this->input->post('kode');
        if ($kode == 1) {
            $data = [
                'nama' => htmlspecialchars($this->input->post('nama', true)),
                'email' => htmlspecialchars($this->input->post('email', true)),
                'tlp' => htmlspecialchars($this->input->post('no_tlp', true)),
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
                    $gambar_lama = $this->input->post('fotolama', true);
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
            redirect('Akun/updateAkun');
        } else if ($kode == 2) {
            $result = $this->db->get_where('alamat', ['id_user' => $id]);
            $leng = htmlspecialchars($this->input->post('lengkap', true));
            $pr = $this->input->post('provinsi', true);
            $ko =  $this->input->post('kota', true);
            $ke = $this->input->post('kecamatan', true);
            $de = htmlspecialchars($this->input->post('desa', true));
            $patokan = htmlspecialchars($this->input->post('patokan', true));

            if ($result->num_rows() < 1) {
                $data = [
                    'lengkap' => $leng,
                    'id_user' => $id,
                    'provinsi' => $pr,
                    'kota' => $ko,
                    'kecamatan' => $ke,
                    'desa' => $de,
                    'patokan' => $patokan,
                ];
                $this->db->insert('alamat', $data);
            } else {
                $data = [
                    'lengkap' => $leng,
                    'provinsi' => $pr,
                    'kota' => $ko,
                    'kecamatan' => $ke,
                    'desa' => $de,
                    'patokan' => $patokan,
                ];
                $this->db->where('id_user', $id);
                $this->db->update('alamat', $data);
            }

            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
        Pengguna baru berhasil diubah 2!!!</div>');
            redirect('Akun/updateAkun');
        } else {
            $return = $this->db->get_where('user', ['id' => $id])->row_array();
            $pass =  htmlspecialchars($this->input->post('password', true));
            $new =  htmlspecialchars($this->input->post('new', true));
            $re =  htmlspecialchars($this->input->post('re', true));

            if (password_verify($pass, $return['password'])) {
                if ($new == $re) {
                    $this->db->where('id', $id);
                    $this->db->update('user', ['password' => password_hash($new, PASSWORD_DEFAULT)]);
                } else {
                    $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
            Password tidak sama</div>');
                    redirect('Akun/updateAkun');
                }
            } else {
                $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
        Password salah</div>');
                redirect('Akun/updateAkun');
            }
        }
    }
}
