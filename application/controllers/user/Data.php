<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Data extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		if (empty($this->session->userdata('log_user'))) {
			$this->session->set_flashdata('toastr-eror', 'Anda Belum Login');
			redirect('auth', 'refresh');
		}

		$this->db->where('id', $this->session->userdata('id'));
		$this->dt_user = $this->db->get('user')->row();

		$this->load->model('M_User', 'user');
	}

	public function index()
	{
		$th_ini  = $this->uri->segment(3);
		$bln_ini = $this->uri->segment(4);
		$ket     = $this->uri->segment(5);

		if (!$th_ini) {
			$th_ini = $this->user->getTahunIni();
		}
		if (!$bln_ini) {
			$bln_ini = $this->user->getBulanIni($th_ini);
		}
		if (!$ket) {
			$ket = 'yes';
		}

		$setting = $this->db->get('setting')->row();

		$this->session->set_userdata('url', $th_ini . '/' . $bln_ini . '/' . $ket);

		if ($ket == 'yes') {
			$today = strtotime(date('Y-m-d'));
			$minDay = date('Y-m-d', strtotime("-" . $setting->expired . " days", $today));

			$where = [
				'idUser'         => $this->dt_user->id,
				'YEAR(tanggal)'  => $th_ini,
				'MONTH(tanggal)' => $bln_ini,
				'tanggal >='     => $minDay
			];
		} else {
			$where = [
				'idUser'         => $this->dt_user->id,
				'YEAR(tanggal)'  => $th_ini,
				'MONTH(tanggal)' => $bln_ini
			];
		}

		$data = [
			'title'           => 'Data Parkir',
			'sidebar'         => 'user/sidebar',
			'navbar'          => 'user/navbar',
			'page'            => 'user/dataParkir',
			'dataParkirHariIni' => $this->user->getDataParkirHariIni([
				'idUser' => $this->dt_user->id,
				'tanggal'   => date('Y-m-d')
			]),
			'dataParkir' => $this->user->getDataParkir($where),
			'tahun'   => $this->user->getTahun(),
			'th_ini'  => $th_ini,
			'bln_ini' => $bln_ini,
			'ket'     => $ket
		];

		$this->load->view('index', $data);
	}

	public function detail($id)
	{
		$url = $this->session->userdata('url');

		$data = [
			'title'    => 'Detail Data Parkir',
			'sidebar'  => 'user/sidebar',
			'navbar'   => 'user/navbar',
			'page'     => 'user/detail_data_parkir',
			'dataParkir' => $this->user->getDataParkir([
				'id' => $id
			]),
			'url' => $url
		];

		$this->load->view('index', $data);
	}
}

/* End of file Data.php */
