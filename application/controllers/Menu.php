<?php

defined('BASEPATH') or exit('No direct script access allowed');



class Menu extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        // is_logged_in();
        $this->load->model('User_m');
        $this->load->model('Menu_model');
        $this->load->model('User_m');
    }
    public function index()
    {
        $data['title'] = "Menu";
        $data['user'] = $this->User_m->tampil_data();
        $data['menu'] = $this->Menu_model->tampil_data()->result_array();
        $this->form_validation->set_rules('nama', 'Menu', 'required'); //set kondisi
        if ($this->form_validation->run() == false) {
            $this->load->view('new_template/header', $data);
            $this->load->view('new_template/topbar', $data);
            $this->load->view('new_template/sidebar', $data);
            $this->load->view('menu/index', $data);
            $this->load->view('new_template/footer');
        } else {
            $data = [
                'menu' => $this->input->post('nama'),
                'nama_menu' => $this->input->post('nama_menu'),
                'icon' => $this->input->post('icon'),
            ];
            $this->db->insert('user_menu', $data);
            $this->session->set_flashdata('message', '<div class="alert alert-success text-center" role="alert">
                New Menu Added</div>');
            redirect('menu');
        }
    }
    public function submenu()
    {
        $data['title'] = "Menu";
        $data['user'] = $this->User_m->tampil_data();
        //$data['subMenu'] = $this->db->get('user_sub_menu')->result_array(); //mengirim data ke submenu |diganti ke model
        $this->load->model('menu_model', 'menu'); //nama modelnya, ganti namanya jadi menu agar tdk kepajangan
        $data['subMenu'] = $this->menu->getSubmenu();
        $data['menu'] = $this->db->get('user_menu')->result_array(); //mengirim data ke modal
        //menu = nama yang akan di panggil di form tujuan yang untuk di looping
        //user_menu = nama pada table database
        $this->form_validation->set_rules('nama', 'Title', 'required');
        if ($this->form_validation->run() == false) {
            $this->load->view('new_template/header', $data);
            $this->load->view('new_template/topbar', $data);
            $this->load->view('new_template/sidebar', $data);
            $this->load->view('menu/submenu', $data);
            $this->load->view('new_template/footer');;
        } else {
            $data = [
                'title' => $this->input->post('nama'),
                'menu_id' => $this->input->post('menu_id'),
                'url' => $this->input->post('url'),
                'icon' => $this->input->post('icon'),
                'is_active' => $this->input->post('is_active'),
                'label' => $this->input->post('label'),
                'isi' => $this->input->post('isi')
            ];
            $this->db->insert('user_sub_menu', $data);
            $this->session->set_flashdata('message', '<div class="alert alert-success text-center" role="alert">
                New Menu Added</div>');
            redirect('menu/submenu');
        }
    }
    public function delete($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('user_sub_menu');
        $this->session->set_flashdata('message', '<div class="alert alert-success text-center" role="alert">
        Delete Success!
      </div>');
        redirect('menu/submenu');
    }
    public function changeActive()
    {
        $menu_id = $this->input->post('menuactiveID');
        $data = [
            'is_actived' => $menu_id
        ];
        $result = $this->db->get_where('user_sub_menu', $data);
        if ($result->num_rows() < 0) {
            $this->db->insert('user_sub_menu', $data);
        } else {
            $this->db->delete('user_sub_menu', $data);
        }
        $this->session->set_flashdata('message', '<div class="alert alert-success text-center" role="alert">
                Actived change!</div>');
    }
    public function MenuAccess($menu_id) //menerima role id
    {
        $data['title'] = 'Role Access Menu';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        //ambil data user dari database yang emailnya samadengan email yang ada pada data session->row array=ambil satu baris saja
        $data['subMenu'] = $this->db->get_where('user_sub_menu', ['id' => $menu_id])->row_array();
        //selanjutnya query semua data menu yang ada di db untuk bisa diakses role id
        $this->load->view('template/header', $data);
        $this->load->view('template/sidebar', $data); //memanggil index yang ada di folder user | $data agar isi yang ada di $data dikirim ke halaman user/index
        $this->load->view('menu/submenu', $data);
        $this->load->view('template/footer');
    }
    public function divisi()
    {
        $data['user'] = $this->User_m->tampil_data();
        $data['title'] = "Divisi";
        $data['divisi'] = $this->Menu_model->tampil_divisi();
        $data['jabatan'] = $this->Menu_model->getJabatan();
        $this->form_validation->set_rules('divisi', 'Divisi', 'required|is_unique[devisi.nama_divisi]', [
            'is_unique' => 'Username is already!'
        ]);
        if ($this->form_validation->run() == false) {
            $this->load->view('new_template/header', $data);
            $this->load->view('new_template/topbar', $data);
            $this->load->view('new_template/sidebar', $data);
            $this->load->view('menu/menu_divisi', $data);
            $this->load->view('new_template/footer');
        } else {
            $data = [
                'nama_divisi' => htmlspecialchars($this->input->post('divisi', true)),
                'email_head' => htmlspecialchars($this->input->post('email', true)),
            ];
            $this->db->insert('devisi', $data);
            $this->session->set_flashdata('message', '<div class="alert alert-success text-center" role="alert">
            Divisi baru berhasil ditambah!</div>');
            redirect('Menu/divisi');
        }
    }
    public function tambahjabatan()
    {
        $data['user'] = $this->User_m->tampil_data();
        $data['divisi'] = $this->Menu_model->tampil_divisi();
        $data['jabatan'] = $this->Menu_model->getJabatan();
        $this->form_validation->set_rules('divisi', 'Divisi', 'required|is_unique[devisi.nama_divisi]', [
            'is_unique' => 'Username is already!'
        ]);
        if ($this->form_validation->run() == false) {
            $this->load->view('new_template/header', $data);
            $this->load->view('new_template/topbar', $data);
            $this->load->view('new_template/sidebar', $data);
            $this->load->view('menu/menu_divisi', $data);
            $this->load->view('new_template/footer');
        } else {
            $data = [
                'id_jabatan' => htmlspecialchars($this->input->post('divisi', true)),
                'nama' => htmlspecialchars($this->input->post('jabatan', true)),
                'is_active' => $this->input->post('is_active')
            ];
            $this->db->insert('jabatan', $data);
            $this->session->set_flashdata('message', '<div class="alert alert-success text-center" role="alert">
            Jabatan baru berhasil ditambah!</div>');
            redirect('Menu/divisi');
        }
    }
    public function editdivisi()
    {
        $post = $this->input->post(null, TRUE);
        $this->Menu_model->editDivisi($post);
        $this->session->set_flashdata('message', '<div class="alert alert-success text-center" role="alert">
            Divisi berhasil diUpdate!</div>');
        redirect('Menu/divisi');
    }
    public function editjabatan()
    {
        $post = $this->input->post(null, TRUE);
        $this->Menu_model->editjabatan($post);
        $this->session->set_flashdata('message', '<div class="alert alert-success text-center" role="alert">
            Jabatan berhasil diUpdate!</div>');
        redirect('Menu/divisi');
    }
    public function deletdivisi($id)
    {
        $this->Menu_model->hapus_divisi($id);
        if ($this->db->affected_rows() > 0) {
            $this->session->set_flashdata('message', '<div class="alert alert-success text-center" role="alert">
            Divisi Berhasil dihapus!</div>');
            redirect('Menu/divisi');
        } else {
            $this->session->set_flashdata('message', '<div class="alert alert-danger text-center" role="alert">
            Divisi Gagal dihapus!</div>');
            redirect('Menu/divisi');
        }
    }
    public function deletjabatan($id)
    {
        $this->Menu_model->hapus_jabatan($id);
        if ($this->db->affected_rows() > 0) {
            $this->session->set_flashdata('message', '<div class="alert alert-success text-center" role="alert">
            jabatan Berhasil dihapus!</div>');
            redirect('Menu/divisi');
        } else {
            $this->session->set_flashdata('message', '<div class="alert alert-danger text-center" role="alert">
            jabatan Gagal dihapus!</div>');
            redirect('Menu/divisi');
        }
    }
    public function edit_role_menu()
    {
        $id = $this->input->post('id', true);
        $data = [
            'menu' => htmlspecialchars($this->input->post('nama', true)),
            'nama_menu' => htmlspecialchars($this->input->post('nama_menu', true)),
            'icon' => htmlspecialchars($this->input->post('icon', true)),
        ];
        $this->db->update('user_menu', $data, ['id' => $id]);
        $this->session->set_flashdata('message', '<div class="alert alert-success text-center" role="alert">
            Data berhasil diUpdate!</div>');
        redirect('Menu');
    }
    public function delete_role_menu($id)
    {
        $this->db->delete('user_menu', ['id' => $id]);
        $this->session->set_flashdata('message', '<div class="alert alert-danger text-center" role="alert">
            Data berhasil dihapus!</div>');
        redirect('Menu');
    }
    public function edit_submenu()
    {
        $id = $this->input->post('id', true);
        $data = [
            'title' => $this->input->post('nama'),
            'menu_id' => $this->input->post('menu_id'),
            'url' => $this->input->post('url'),
            'icon' => $this->input->post('icon'),
            'is_active' => $this->input->post('is_active'),
            'label' => $this->input->post('label'),
            'isi' => $this->input->post('isi')
        ];
        $this->db->where('id', $id);
        $this->db->update('user_sub_menu', $data);
        $this->session->set_flashdata('message', '<div class="alert alert-success text-center" role="alert">
           Data berhasil Diupdate</div>');
        redirect('menu/submenu');
    }
    public function delete_submenu($id)
    {
        $this->db->delete('user_sub_menu', ['id' => $id]);
        $this->session->set_flashdata('message', '<div class="alert alert-danger text-center" role="alert">
            Data berhasil dihapus!</div>');
        redirect('Menu/submenu');
    }
    public function role()
    {
        $data['title'] = 'Role';
        $data['user'] = $this->User_m->tampil_data();
        //ambil data user dari database yang emailnya samadengan email yang ada pada data session->row array=ambil satu baris saja
        $data['role'] = $this->db->get('user_role')->result_array();
        $this->form_validation->set_rules('role', 'Role', 'required');
        if ($this->form_validation->run() == false) {
            $this->load->view('new_template/header', $data);
            $this->load->view('new_template/topbar', $data);
            $this->load->view('new_template/sidebar', $data);
            $this->load->view('menu/role', $data);
            $this->load->view('new_template/footer');
        } else {
            $this->db->insert('user_role', ['role' => $this->input->post('role')]);
            $this->session->set_flashdata('message', '<div class="alert alert-success text-center" role="alert">
            New role Added</div>');
            redirect('Menu/role');
        }
    }
    public function edit()
    {
        $data['title'] = 'Role';
        $data['user'] = $this->User_m->tampil_data();
        //ambil data user dari database yang emailnya samadengan email yang ada pada data session->row array=ambil satu baris saja
        $data['role'] = $this->db->get('user_role')->result_array();
        $this->form_validation->set_rules('role', 'Role', 'required');
        if ($this->form_validation->run() == false) {
            $this->load->view('new_template/header', $data);
            $this->load->view('new_template/topbar', $data);
            $this->load->view('new_template/sidebar', $data);
            $this->load->view('menu/role', $data);
            $this->load->view('new_template/footer');
        } else {
            $id = $this->input->post('id', true);
            $data = ['role' => $this->input->post('role', true)];
            $this->db->where('id', $id);
            $this->db->update('user_role', $data);
            $this->session->set_flashdata('message', '<div class="alert alert-success text-center" role="alert">
            New role Added</div>');
            redirect('Menu/role');
        }
    }
    public function roleAccess($role_id) //menerima role id
    {
        $data['title'] = 'Role Access';
        $data['user'] = $this->User_m->tampil_data();
        //ambil data user dari database yang emailnya samadengan email yang ada pada data session->row array=ambil satu baris saja
        $data['role'] = $this->db->get_where('user_role', ['id' => $role_id])->row_array();
        //selanjutnya query semua data menu yang ada di db untuk bisa diakses role id
        // $this->db->where('id !=', 8); //agar admin tidak muncul untuk diatur access permisitionya
        $data['menu'] = $this->db->get('user_menu')->result_array();
        $this->load->view('new_template/header', $data);
        $this->load->view('new_template/header', $data);
        $this->load->view('new_template/topbar', $data);
        $this->load->view('new_template/sidebar', $data);
        $this->load->view('menu/role-access', $data);
        $this->load->view('new_template/footer');
    }
    public function changeAccess()
    {
        //ambil data dari js
        $menu_id = $this->input->post('menuId');
        $role_id = $this->input->post('roleId');
        //menyiapkan data
        $data = [
            'role_id' => $role_id,
            'menu_id' => $menu_id
        ];
        $result = $this->db->get_where('user_access_menu', $data);
        if ($result->num_rows() < 1) {
            $this->db->insert('user_access_menu', $data);
        } else {
            $this->db->delete('user_access_menu', $data);
        }
        $this->session->set_flashdata('message', '<div class="alert alert-success text-center" role="alert">
        Access change!
      </div>');
    }
    public function delete_role($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('user_role');
        $this->session->set_flashdata('message', '<div class="alert alert-danger text-center" role="alert">
            Data Telah dihapus!
          </div>');
        redirect('Menu/role');
    }
    public function detail($id)
    {
        $data['user'] = $this->User_m->tampil_data();
        $data['cuti'] = $this->User_m->data_cuti($id);
        $data['lihat'] = $this->User_m->tampil_data($id);
        $data['title'] = "Data Karyawan";
        $this->load->view('unpin/header', $data);
        $this->load->view('unpin/topbar', $data);
        $this->load->view('unpin/navbar', $data);
        $this->load->view('user/detail', $data);
        $this->load->view('unpin/footer');
    }
    // public function edit_karyawan($id)
    // {
    //     $data['lihat'] = $this->User_m->lihat_karyawan($id);
    //     $data['user'] = $this->User_m->tampil_data();
    //     $data['divisi'] = $this->Menu_model->tampil_divisi();
    //     $data['jabatan'] = $this->Menu_model->tampil_jabatan();
    //     $data['role'] = $this->User_m->tampil_role();

    //     $data['title'] = "Edit Data Karyawan";
    //     $this->form_validation->set_rules('password', 'password', 'required');
    //     $this->form_validation->set_rules('username', 'Username', 'required');
    //     $this->form_validation->set_rules('email', 'email', 'required');
    //     $this->form_validation->set_rules('departmen', 'departmen', 'required');
    //     $this->form_validation->set_rules('role', 'Role id', 'required');

    //     if ($this->form_validation->run() == false) {
    //         $this->load->view('unpin/header', $data);
    //         $this->load->view('unpin/topbar', $data);
    //         $this->load->view('unpin/navbar', $data);
    //         $this->load->view('user/edit_karyawan', $data);
    //         $this->load->view('unpin/footer');
    //     } else {
    //         $post = $this->input->post(null, true);
    //         $this->user_m->edit_karyawan($post);
    //         $this->session->set_flashdata('message', '<div class="alert alert-success text-center" role="alert">
    //         Update data karyawan berhasil!</div>');
    //         redirect('Hrd/data_karyawan');
    //     }
    // }
    public function tambah_karyawan($id = null)
    {
        $data['user'] = $this->User_m->tampil_data();
        $data['divisi'] = $this->Menu_model->tampil_divisi();
        $data['jabatan'] = $this->Menu_model->tampil_jabatan();
        $data['title'] = "Tambah Karyawan";

        $this->form_validation->set_rules('nama', 'nama', 'required');
        $this->form_validation->set_rules('username', 'username', 'required|is_unique[karyawan.username]', [
            'is_unique' => 'Email is already!'
        ]);
        $this->form_validation->set_rules('password', 'password', 'required');
        $this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email|is_unique[karyawan.email]', [
            'is_unique' => 'Username is already!'
        ]);
        if ($this->form_validation->run() == false) {
            $this->load->view('unpin/header', $data);
            $this->load->view('unpin/topbar', $data);
            $this->load->view('unpin/navbar', $data);
            $this->load->view('user/tambah_karyawan', $data);
            $this->load->view('unpin/footer', $data);
        } else {
            $post = $this->input->post(null, TRUE);
            $this->User_m->add_karyawan($post);
            $this->session->set_flashdata('message', '<div class="alert alert-success text-center" role="alert">
            Tambah data karyawan berhasil!</div>');
            redirect('Hrd/data_karyawan');
        }
    }
    public function data_karyawan()
    {
        $data['user'] = $this->User_m->tampil_data();
        $data['data'] = $this->User_m->data_karyawan();
        $data['title'] = "Data Karyawan";
        $data['segmen'] =  $this->uri->segment(1);
        $this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email|is_unique[karyawan.email]', [
            'is_unique' => 'Username is already!'
        ]);
        if ($this->form_validation->run() == false) {
            $this->load->view('template/header', $data);
            $this->load->view('template/topbar', $data);
            $this->load->view('template/sidebar', $data);
            $this->load->view('user/data_karyawan', $data);
            $this->load->view('template/footer', $data);
        } else {
            $post = $this->input->post(null, TRUE);
            $this->User_m->add_karyawan($post);
            $this->session->set_flashdata('message', '<div class="alert alert-success text-center" role="alert">
            Tambah data karyawan berhasil!</div>');
            redirect('Menu/data_karyawan');
        }
    }
    public function edit_karyawan()
    {
        $post = $this->input->post(null, true);
        $this->User_m->edit_karyawan($post);
        $this->session->set_flashdata('message', '<div class="alert alert-success text-center" role="alert">
                    Update data karyawan berhasil!</div>');
    }
}
