<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Scan extends CI_Controller
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
		$ket = $this->uri->segment(3);
		$waktuSekarang = $this->uri->segment(4);
		$batasWaktu = $this->uri->segment(5);

		if (date('H:i:s') >= $waktuSekarang && date('H:i:s') <= $batasWaktu) {
			$cekDataParkir = $this->user->getDataParkirHariIni([
				'idUser' => $this->dt_user->id,
				'tanggal'   => date('Y-m-d')
			]);

			if ($cekDataParkir) {
				if ($cekDataParkir->parkirMasuk != null && $cekDataParkir->parkirKeluar != null) {
					$data = [
						'metode' => 'scan',
						'idUser' => $this->dt_user->id,
						'tanggal' => date('Y-m-d'),
						'parkirMasuk' => date('H:i:s')
					];

					$this->db->insert('data', $data);
					$insert_id = $this->db->insert_id();

					if ($insert_id) {
						$queue = [
							'idData' => $insert_id,
							'act'        => 'masuk'
						];

						$this->db->insert('queue', $queue);

						$this->session->set_flashdata('toastr-success', 'Scan berhasil');
					} else {
						$this->session->set_flashdata('toastr-error', 'Serve error!');
					}
				} else {
					$data = [
						'parkirKeluar' => date('H:i:s')
					];

					$this->db->where('id', $cekDataParkir->id);
					$update = $this->db->update('data', $data);

					if ($update) {
						$queue = [
							'idData' => $cekDataParkir->id,
							'act' => 'keluar'
						];

						$this->db->insert('queue', $queue);
						$this->session->set_flashdata('toastr-success', 'Scan berhasil');
					} else {
						$this->session->set_flashdata('toastr-error', 'Serve error!');
					}
				}
			} else {
				$data = [
					'metode' => 'scan',
					'idUser' => $this->dt_user->id,
					'tanggal' => date('Y-m-d'),
					'parkirMasuk' => date('H:i:s')
				];

				$this->db->insert('data', $data);
				$insert_id = $this->db->insert_id();

				if ($insert_id) {
					$queue = [
						'idData' => $insert_id,
						'act'        => 'masuk'
					];

					$this->db->insert('queue', $queue);

					$this->session->set_flashdata('toastr-success', 'Scan berhasil');
				} else {
					$this->session->set_flashdata('toastr-error', 'Serve error!');
				}
			}

			redirect('user/data', 'refresh');
		} else {
			$this->session->set_flashdata('toastr-error', 'QR Code tidak ditemukan, silakan scan QR code terbaru');
			redirect('user/data', 'refresh');
		}
	}
}
