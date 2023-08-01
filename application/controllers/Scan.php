<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Scan extends CI_Controller
{
	public function masuk()
	{
		$data = [
			'title'     => 'Scan QR Code Sistem Parkir',
		];

		$this->load->view('scanMasuk', $data);
	}

	public function keluar()
	{
		$data = [
			'title'     => 'Scan QR Code Sistem Parkir',
		];

		$this->load->view('scanKeluar', $data);
	}

	public function generateQRCode($ket)
	{
		// $waktuSekarang      = date('H:i:s');
		// $batasWaktu         = date('H:i:s', strtotime("$waktuSekarang + 3 minute"));
		// $namaFile           = "qrcode-" . date('YmdHis') . ".png";
		$namaFile           = "qrcode-" . $ket . ".png";
		// $url                = "user/scan/$ket/$waktuSekarang/$batasWaktu";
		$url                = "user/scan/$ket";
		$params['data']     = base_url($url);
		$params['level']    = 'H';
		$params['size']     = 10;
		$params['savename'] = "file/$namaFile";

		$this->load->library('Ciqrcode');
		$this->ciqrcode->generate($params);

		$this->db->where('ket', $ket);
		$fileDb = $this->db->get('file')->row();

		if ($fileDb->nama != null) {
			$this->db->where('id', $fileDb->id);
			$update = $this->db->update('file', ['nama' => $namaFile]);

			// if ($update) {
			// 	unlink(FCPATH . 'file/' . $fileDb->nama);
			// }
		} else {
			$this->db->where('id', $fileDb->id);
			$update = $this->db->update('file', ['nama' => $namaFile]);
		}

		// echo json_encode(base_url("file/$namaFile?$waktuSekarang"));
		echo json_encode(base_url("file/$namaFile"));
	}
}

/* End of file Scan.php */
