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

        $this->db->order_by('awal', 'desc');
        $semester = $this->db->get('semester')->result();

        $data = [
            'title'     => 'Dashboard',
            'page'      => 'admin/dashboard',
            'sidebar'   => 'admin/sidebar',
            'navbar'    => 'admin/navbar',
            'mahasiswa' => $this->admin->countUser('Mahasiswa'),
            'tamu'      => $this->admin->countUser('Tamu'),
            'karyawan'  => $this->admin->countUser('Karyawan'),
            'setting'   => $setting,
            'semester'  => $semester
        ];

        $this->load->view('index', $data);
    }

    public function updateSetting()
    {
        $data = [
            'status'  => $this->input->post('status'),
            'expired' => $this->input->post('expired')
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

    public function addSemt()
    {
        $data = [
            'semester' => $this->input->post('nama'),
            'awal'     => $this->input->post('awal'),
            'akhir'    => $this->input->post('akhir')
        ];

        $insert = $this->db->insert('semester', $data);

        if ($insert) {
            $this->session->set_flashdata('toastr-success', 'Data berhasil ditambahkan');
        } else {
            $this->session->set_flashdata('toastr-error', 'Data gagal ditambahkan');
        }

        redirect($_SERVER['HTTP_REFERER'], 'refresh');
    }

    public function editSemt()
    {
        $data = [
            'semester' => $this->input->post('nama'),
            'awal'     => $this->input->post('awal'),
            'akhir'    => $this->input->post('akhir')
        ];

        $this->db->where('id', $this->input->post('id'));
        $update = $this->db->update('semester', $data);

        if ($update) {
            $this->session->set_flashdata('toastr-success', 'Data berhasil ditambahkan');
        } else {
            $this->session->set_flashdata('toastr-error', 'Data gagal ditambahkan');
        }

        redirect($_SERVER['HTTP_REFERER'], 'refresh');
    }

    public function delSmt($id)
    {
        $this->db->where('id', $id);
        $delete = $this->db->delete('semester');

        if ($delete) {
            $this->session->set_flashdata('toastr-success', 'Data berhasil dihapus');
        } else {
            $this->session->set_flashdata('toastr-error', 'Data gagal dihapus!!');
        }

        redirect($_SERVER['HTTP_REFERER'], 'refresh');
    }
}

/* End of file Home.php */
