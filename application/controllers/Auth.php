<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Auth extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        if (!empty($this->session->userdata('log_admin'))) {
            if ($this->uri->segment(2) != 'logout') {
                $this->session->set_flashdata('notif-error', 'Anda sudah login !');
                redirect('admin');
            }
        } else if (!empty($this->session->userdata('log_user'))) {
            if ($this->uri->segment(2) != 'logout') {
                $this->session->set_flashdata('notif-error', 'Anda sudah login !');
                redirect('user');
            }
        }
        $this->load->model('M_Login', 'login');
    }

    public function index()
    {
        $data = [
            'title'     => 'Login',
        ];

        $this->load->view('auth/index', $data);
    }

    public function proses()
    {
        $this->form_validation->set_rules('username', 'Username', 'trim|required');
        $this->form_validation->set_rules('password', 'Password', 'trim|required');


        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('toastr-error', validation_errors());
            redirect('auth');
        } else {
            $username   = $this->input->post('username');
            $password   = $this->input->post('password');

            $cek = $this->login->cek($username, $password);

            if ($cek == 'admin') {
                $this->session->set_flashdata('toastr-success', 'Login berhasil');
                redirect('admin');
            } else if ($cek == 'user') {
                $this->session->set_flashdata('toastr-success', 'Login berhasil');
                redirect('user');
            } else {
                $this->session->set_flashdata('toastr-error', $cek);
                redirect('auth');
            }
        }
    }

    public function logout()
    {
        $this->session->sess_destroy();
        redirect('auth', 'refresh');
    }
}

/* End of file Auth.php */