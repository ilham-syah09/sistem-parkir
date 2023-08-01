<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Data extends CI_Controller
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
		$th_ini  = $this->uri->segment(3);
		$bln_ini = $this->uri->segment(4);
		$ket     = $this->uri->segment(5);

		if (!$th_ini) {
			$th_ini = $this->admin->getTahunIni();
		}

		if (!$bln_ini) {
			$bln_ini = $this->admin->getBulanIni($th_ini);
		}
		if (!$ket) {
			$ket = 'yes';
		}

		$setting = $this->db->get('setting')->row();

		$this->session->set_userdata('url', $th_ini . '/' . $bln_ini . '/' . $ket);

		$data = [
			'title'             => 'Rekap Parkir',
			'sidebar'           => 'admin/sidebar',
			'navbar'            => 'admin/navbar',
			'page'              => 'admin/data_parkir',
			'tahun'             => $this->admin->getTahun(),
			'dataParkirHariIni' => $this->admin->getDataParkir(date('Y'), date('m'), date('d')),
			'riwayatParkir'     => $this->admin->getDataParkir($th_ini, $bln_ini, null, $ket, $setting->expired),
			'th_ini'            => $th_ini,
			'bln_ini'           => $bln_ini,
			'ket'               => $ket
		];

		$this->load->view('index', $data);
	}

	public function list($tanggal)
	{
		$url = $this->session->userdata('url');

		$data = [
			'title'       => 'List Data Parkir',
			'sidebar'     => 'admin/sidebar',
			'navbar'      => 'admin/navbar',
			'page'        => 'admin/list_data_parkir',
			'data_parkir' => $this->admin->getListDataParkir($tanggal),
			'tanggal'     => $tanggal,
			'url'         => $url
		];

		$this->load->view('index', $data);
	}

	public function detail($id)
	{
		$data = [
			'title'       => 'Detail Data Parkir',
			'sidebar'     => 'admin/sidebar',
			'navbar'      => 'admin/navbar',
			'page'        => 'admin/detail_data_parkir',
			'data_parkir' => $this->admin->getDetailDataParkir($id),
		];

		$this->load->view('index', $data);
	}

	public function izin($status, $id)
	{
		$data = [
			'statusIzin' => $status
		];

		$this->db->where('id', $id);
		$update = $this->db->update('presensi', $data);

		if ($update) {
			$this->session->set_flashdata('toastr-success', 'Izin berhasil ' . $status);
		} else {
			$this->session->set_flashdata('toastr-error', 'Izin berhasil ' . $status);
		}

		redirect($_SERVER['HTTP_REFERER'], 'refresh');
	}
}

/* End of file Data.php */
