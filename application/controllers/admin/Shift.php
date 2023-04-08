<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Shift extends CI_Controller
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
			'title'  => 'Shift',
			'page'      => 'admin/shift',
			'sidebar'   => 'admin/sidebar',
			'navbar'    => 'admin/navbar',
			'shift' => $this->admin->getShift()
		];

		$this->load->view('index', $data);
	}

	public function add()
	{
		$data = [
			'nama'      => $this->input->post('nama'),
			'jamMasuk'  => $this->input->post('jamMasuk'),
			'jamPulang' => $this->input->post('jamPulang')
		];

		$insert = $this->db->insert('shift', $data);

		if ($insert) {
			$this->session->set_flashdata('toastr-success', 'Data berhasil ditambahkan');
		} else {
			$this->session->set_flashdata('toastr-error', 'Data gagal ditambahkam');
		}

		redirect('admin/shift', 'refresh');
	}

	public function edit()
	{
		$data = [
			'nama'      => $this->input->post('nama'),
			'jamMasuk'  => $this->input->post('jamMasuk'),
			'jamPulang' => $this->input->post('jamPulang')
		];

		$this->db->where('id', $this->input->post('idShift'));
		$update = $this->db->update('shift', $data);

		if ($update) {
			$this->session->set_flashdata('toastr-success', 'Data berhasil diedit');
		} else {
			$this->session->set_flashdata('toastr-error', 'Data gagal diedit');
		}

		redirect('admin/shift', 'refresh');
	}

	public function delete($id)
	{
		$this->db->where('id', $id);
		$delete = $this->db->delete('shift');

		if ($delete) {
			$this->session->set_flashdata('toastr-success', 'Data berhasil dihapus');
		} else {
			$this->session->set_flashdata('toastr-error', 'Data gagal dihapus!!');
		}

		redirect('admin/shift', 'refresh');
	}
}

/* End of file Shift.php */
