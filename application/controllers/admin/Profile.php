<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Profile extends CI_Controller
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
        $data = [
            'title'           => 'Admin Profile',
            'sidebar'         => 'admin/sidebar',
            'page'            => 'admin/profile',
            'navbar'          => 'admin/navbar',
        ];

        $this->load->view('index', $data);
    }

    public function changeNewPwd()
    {
        $this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[6]');


        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('toastr-error', 'Gagal ganti password!');
            redirect('admin/profile');
        } else {
            $password = $this->input->post('password');

            $data = [
                'password'  => password_hash($password, PASSWORD_BCRYPT)
            ];

            $this->db->where('id', $this->input->post('id'));
            $this->db->update('user', $data);
            $this->session->set_flashdata('toastr-success', 'berhasil update password');
            redirect('admin/profile', 'refresh');
        }
    }

    public function changePwd()
    {
        $this->db->where('id', $this->dt_user->id);
        $cek = $this->db->get('admin')->row();
        $old = $this->input->post('current_password');

        if (password_verify($old, $cek->password)) {

            $this->form_validation->set_rules('current_password', 'Current Password', 'trim|required');
            $this->form_validation->set_rules('password', 'Password', 'trim|required');
            $this->form_validation->set_rules('retype_password', 'Retype Password', 'trim|required|matches[password]');

            if ($this->form_validation->run() == FALSE) {
                $this->session->set_flashdata('toastr-error', 'isi semua form');
                redirect('admin/profile', 'refresh');
            } else {

                $data = [
                    'password'  => password_hash($this->input->post('password'), PASSWORD_BCRYPT)
                ];

                $this->db->where('id', $this->dt_user->id);
                $update = $this->db->update('admin', $data);

                if ($update) {
                    $this->session->set_flashdata('toastr-success', 'BERHASIL! update password');
                    redirect('admin/profile', 'refresh');
                } else {
                    $this->session->set_flashdata('toastr-error', 'GAGAL! update password');
                    redirect('admin/profile', 'refresh');
                }
            }
        } else {
            $this->session->set_flashdata('toastr-error', 'GAGAL! Current Password salah!');
            redirect('admin/profile', 'refresh');
        }
    }

    public function changeImage()
    {
        $img = $_FILES['image']['name'];

        if ($img) {
            $config['upload_path']      = 'upload/profile';
            $config['allowed_types']    = 'jpg|jpeg|png';
            $config['max_size']         = 2000;
            $config['remove_spaces']    = TRUE;
            $config['encrypt_name']     = TRUE;

            $this->load->library('upload', $config);
            $this->upload->initialize($config);

            if (!$this->upload->do_upload('image')) {
                $this->session->set_flashdata('toastr-error', $this->upload->display_errors());
                redirect('admin/profile');
            } else {
                $upload_data = $this->upload->data();
                $previmage = $this->input->post('previmage');

                $data = [
                    'image'     => $upload_data['file_name']
                ];

                $this->db->where('id', $this->dt_user->id);
                $insert = $this->db->update('admin', $data);

                if ($insert) {
                    if ($previmage != 'default.png') {
                        unlink(FCPATH . 'upload/profile/' . $previmage);
                    }
                    $this->session->set_flashdata('toastr-success', 'SUCCESS! Berhasil update profile');
                    redirect('admin/profile');
                } else {
                    $this->session->set_flashdata('toastr-error', 'FAILED! Gagal update profile!');
                    redirect('admin/profile');
                }
            }
        }
    }
}

/* End of file Home.php */