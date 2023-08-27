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
		// $th_ini  = $this->uri->segment(3);
		// $bln_ini = $this->uri->segment(4);
		$smt_ini = $this->uri->segment(3);

		$today = date('Y-m-d');

		if (!$smt_ini) {
			$this->db->where('awal <=', $today);
			$this->db->where('akhir >=', $today);

			$this->db->order_by('awal', 'desc');

			$cek = $this->db->get('semester')->row();

			$smt_ini = $cek->id;
		} else {
			$this->db->where('id', $smt_ini);
			$cek = $this->db->get('semester')->row();
		}

		// echo $smt_ini;
		// die;

		$this->db->order_by('awal', 'desc');
		$semester = $this->db->get('semester')->result();

		$this->session->set_userdata('url', $smt_ini . '/filter');

		// echo json_encode($semester);
		// die;

		$where = [
			'idUser'     => $this->dt_user->id,
			'tanggal >=' => $cek->awal,
			'tanggal <=' => $cek->akhir
		];

		$data = [
			'title'             => 'Data Parkir',
			'sidebar'           => 'user/sidebar',
			'navbar'            => 'user/navbar',
			'page'              => 'user/dataParkir',
			'dataParkirHariIni' => $this->user->getDataParkirHariIni([
				'idUser'  => $this->dt_user->id,
				'tanggal' => date('Y-m-d')
			]),
			'dataParkir' => ($today >= $cek->awal && $today <= $cek->akhir) ? $this->user->getDataParkir($where) : [],
			'tahun'      => $this->user->getTahun(),
			'semester'   => $semester,
			'smt_ini'    => $smt_ini
			// 'th_ini'  => $th_ini,
			// 'bln_ini' => $bln_ini,
			// 'ket'     => $ket
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

	// if ($ket == 'yes') {
	// 	$today = strtotime(date('Y-m-d'));
	// 	$minDay = date('Y-m-d', strtotime("-" . $setting->expired . " days", $today));

	// 	$where = [
	// 		'idUser'         => $this->dt_user->id,
	// 		'YEAR(tanggal)'  => $th_ini,
	// 		'MONTH(tanggal)' => $bln_ini,
	// 		'tanggal >='     => $minDay
	// 	];
	// } else {
	// 	$where = [
	// 		'idUser'         => $this->dt_user->id,
	// 		'YEAR(tanggal)'  => $th_ini,
	// 		'MONTH(tanggal)' => $bln_ini
	// 	];
	// }

}

/* End of file Data.php */
