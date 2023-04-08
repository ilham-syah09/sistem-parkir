<?php
defined('BASEPATH') or exit('No direct script access allowed');

class User extends CI_Controller
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
			'title'   => 'User',
			'page'      => 'admin/user',
			'sidebar'   => 'admin/sidebar',
			'navbar'    => 'admin/navbar',
			'user' => $this->admin->getUser()
		];

		$this->load->view('index', $data);
	}

	public function add()
	{
		$data = [
			'email'    => $this->input->post('email'),
			'password' => password_hash('user123', PASSWORD_BCRYPT, ['const' => 14]),
			'nama'     => $this->input->post('nama'),
			'nip'      => $this->input->post('nip'),
			'jk'       => $this->input->post('jk'),
			'level'    => $this->input->post('level'),
			'noKartu'  => $this->input->post('noKartu')
		];

		$insert = $this->db->insert('user', $data);

		if ($insert) {
			$this->session->set_flashdata('toastr-success', 'Data berhasil ditambahkan');
		} else {
			$this->session->set_flashdata('toastr-error', 'Data gagal ditambahkam');
		}

		redirect('admin/user', 'refresh');
	}

	public function edit()
	{
		$data = [
			'email'     => $this->input->post('email'),
			'nama'      => $this->input->post('nama'),
			'nip'       => $this->input->post('nip'),
			'jk'        => $this->input->post('jk'),
			'level'    => $this->input->post('level'),
			'noKartu'  => $this->input->post('noKartu')
		];

		$this->db->where('id', $this->input->post('id_user'));
		$update = $this->db->update('user', $data);

		if ($update) {
			$this->session->set_flashdata('toastr-success', 'Data berhasil diedit');
		} else {
			$this->session->set_flashdata('toastr-error', 'Data gagal diedit');
		}

		redirect('admin/user', 'refresh');
	}

	public function delete($id)
	{
		$this->db->where('id', $id);
		$data = $this->db->get('user')->row();

		$this->db->where('id', $id);
		$delete = $this->db->delete('user');

		if ($delete) {
			if ($data->image != 'default.png') {
				unlink(FCPATH . 'upload/profile/' . $data->image);
			}

			$this->session->set_flashdata('toastr-success', 'Data berhasil dihapus');
		} else {
			$this->session->set_flashdata('toastr-error', 'Data gagal dihapus!!');
		}

		redirect('admin/user', 'refresh');
	}
}

/* End of file User.php */
