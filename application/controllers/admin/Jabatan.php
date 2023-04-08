<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Jabatan extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		if (empty($this->session->userdata('log_admin'))) {
			$this->session->set_flashdata('toastr-error', 'Anda Belum Login');
			redirect('auth', 'refresh');
		}

		$this->db->where('id', $this->session->userdata('id'));
		$this->dt_user = $this->db->get('admin')->row();

		$this->load->model('M_Admin', 'admin');
	}

	public function index()
	{
		$data = [
			'title'  => 'Jabatan',
			'page'      => 'admin/jabatan',
			'sidebar'   => 'admin/sidebar',
			'navbar'    => 'admin/navbar',
			'jabatan' => $this->admin->getJabatan()
		];

		$this->load->view('index', $data);
	}

	public function add()
	{
		$data = [
			'namaJabatan' => $this->input->post('namaJabatan')
		];

		$insert = $this->db->insert('jabatan', $data);

		if ($insert) {
			$this->session->set_flashdata('toastr-success', 'Data berhasil ditambahkan');
		} else {
			$this->session->set_flashdata('toastr-error', 'Data gagal ditambahkam');
		}

		redirect('admin/jabatan', 'refresh');
	}

	public function edit()
	{
		$data = [
			'namaJabatan' => $this->input->post('namaJabatan')
		];

		$this->db->where('id', $this->input->post('id_jabatan'));
		$update = $this->db->update('jabatan', $data);

		if ($update) {
			$this->session->set_flashdata('toastr-success', 'Data berhasil diedit');
		} else {
			$this->session->set_flashdata('toastr-error', 'Data gagal diedit');
		}

		redirect('admin/jabatan', 'refresh');
	}

	public function delete($id)
	{

		$this->db->where('id', $id);
		$delete = $this->db->delete('jabatan');

		if ($delete) {
			$this->session->set_flashdata('toastr-success', 'Data berhasil dihapus');
		} else {
			$this->session->set_flashdata('toastr-error', 'Data gagal dihapus!!');
		}

		redirect('admin/jabatan', 'refresh');
	}
}

/* End of file Jabatan.php */
