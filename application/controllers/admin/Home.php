<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Home extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        if (empty($this->session->userdata('log_admin'))) {
            $this->session->set_flashdata('toastr-eror', 'Anda Belum Login');
            redirect('auth', 'refresh');
        }

        $this->db->where('id', $this->session->userdata('id'));
        $this->dt_user = $this->db->get('admin')->row();

        $this->load->model('M_Admin', 'admin');
    }

    public function index()
    {
        $setting = $this->db->get('setting')->row();

        $data = [
            'title'   => 'Dashboard',
            'page'    => 'admin/dashboard',
            'sidebar' => 'admin/sidebar',
            'navbar'  => 'admin/navbar',
            'user'    => $this->admin->getCountUser(),
            'setting'  => $setting
        ];

        $this->load->view('index', $data);
    }

    public function updateSetting()
    {
        $data = [
            'status'    => $this->input->post('status')
        ];

        $this->db->where('id', $this->input->post('id'));
        $update = $this->db->update('setting', $data);
        if ($update) {
            $this->session->set_flashdata('toastr-success', 'Status berhasil diupdate');
            redirect('admin/home', 'refresh');
        } else {
            $this->session->set_flashdata('toastr-error', 'Status gagal diupdate');
            redirect('admin/home', 'refresh');
        }
    }
}

/* End of file Home.php */
