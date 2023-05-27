<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Alat extends CI_Controller
{
	public function registrasi()
	{
		$noKartu = $this->input->get('noKartu');

		$this->db->where('noKartu', $noKartu);
		$pegawai = $this->db->get('user')->row();

		if (!$pegawai) {
			$data = [
				"password" => password_hash('user123', PASSWORD_BCRYPT),
				"noKartu"  => $noKartu,
				"nama"     => "User Default",
				"level"    => "Tamu"
			];

			$this->db->insert('user', $data);

			echo "SUKSES";
		} else {
			echo "GAGAL";
		}
	}

	public function status()
	{
		$setting = $this->db->get('setting')->row();

		echo $setting->status;
	}

	public function scan()
	{
		$noKartu = $this->input->get('noKartu');
		$act = $this->input->get('act');

		$this->db->where('noKartu', $noKartu);
		$user = $this->db->get('user')->row();

		$respon = '';

		if ($user) {
			$tanggal = date('Y-m-d');
			$jam     = date('H:i:s');

			$this->db->where('idUser', $user->id);
			$this->db->where('tanggal', $tanggal);

			$this->db->order_by('createdAt', 'desc');

			$cek = $this->db->get('data')->row();

			if (!$cek) {
				if ($act == 'masuk') {
					$data = [
						'metode'      => 'rfid',
						'idUser'      => $user->id,
						'tanggal'     => $tanggal,
						'parkirMasuk' => $jam
					];

					$this->db->insert('data', $data);
					$insert_id = $this->db->insert_id();

					if ($insert_id) {
						$queue = [
							'idData' => $insert_id,
							'act'    => $act
						];

						$this->db->insert('queue', $queue);
						$queue_id = $this->db->insert_id();

						$respon = 'SUKSES#' . $user->nama . '#SCAN SUKSES#' . $queue_id . '#OK';
					} else {
						$respon = 'GAGAL#SERVER ERROR#OK';
					}
				} else {
					$respon = 'GAGAL#ANDA BELUM MASUK#OK';
				}
			} else {
				if ($act == 'masuk') {
					if ($cek->parkirKeluar != null) {
						$data = [
							'metode'      => 'rfid',
							'idUser'      => $user->id,
							'tanggal'     => $tanggal,
							'parkirMasuk' => $jam
						];

						$this->db->insert('data', $data);
						$insert_id = $this->db->insert_id();

						if ($insert_id) {
							$queue = [
								'idData' => $insert_id,
								'act'    => 'masuk'
							];

							$this->db->insert('queue', $queue);
							$queue_id = $this->db->insert_id();

							$respon = 'SUKSES#' . $user->nama . '#SCAN SUKSES#' . $queue_id . '#OK';
						} else {
							$respon = 'GAGAL#SERVER ERROR#OK';
						}
					} else {
						$respon = 'GAGAL#ANDA SUDAH MASUK#OK';
					}
				} else if ($act == 'keluar') {
					if ($cek->parkirMasuk != null && $cek->parkirKeluar != null) {
						$respon = 'GAGAL#ANDA BELUM MASUK#OK';
					} else {
						$data = [
							'parkirKeluar' => $jam
						];

						$this->db->where('id', $cek->id);
						$update = $this->db->update('data', $data);

						if ($update) {
							$queue = [
								'idData' => $cek->id,
								'act'    => 'keluar'
							];

							$this->db->insert('queue', $queue);
							$queue_id = $this->db->insert_id();

							$respon = 'SUKSES#' . $user->nama . '#SCAN SUKSES#' . $queue_id . '#OK';
						} else {
							$respon = 'GAGAL#SERVER ERROR#OK';
						}
					}
				}
			}
		} else {
			$respon = 'GAGAL#TIDAK TERDAFTAR#OK';
		}

		echo $respon;
	}

	public function getQueue()
	{
		$id = $this->input->get('queue_id');

		if ($id != "0" || $id != 0) {
			$this->db->where('id', $id);
			$queue = $this->db->get('queue')->row();

			if ($queue) {
				if ($queue->status == 0) {
					echo 'Menunggu';
				} else {
					$this->db->where('id', $id);
					$this->db->delete('queue');

					echo 'Selesai';
				}
			} else {
				echo 'Tidak Ditemukan';
			}
		} else {
			$act = $this->input->get('act');

			$this->db->where('status', 1);
			$this->db->where('act', $act);

			$this->db->order_by('id', 'desc');
			$queue = $this->db->get('queue', 1)->row();

			if ($queue) {
				if ($queue->status == 0) {
					echo 'Menunggu';
				} else {
					$this->db->where('id', $queue->id);
					$this->db->delete('queue');

					echo 'Selesai';
				}
			} else {
				echo 'Tidak ada scan ' . $act;
			}
		}
	}

	public function kirimGambarMasuk()
	{
		$this->db->where([
			'act'    => 'masuk',
			'status' => 0
		]);

		$queue = $this->db->get('queue')->row();

		if ($queue) {
			$upload_foto = $_FILES['imageFile']['name'];
			if ($upload_foto) {
				$this->load->library('upload');
				$config['upload_path']   = './upload/parkir';
				$config['allowed_types'] = 'jpg|jpeg|png';
				$config['max_size']      = '10240';
				$config['remove_spaces'] = TRUE;
				$config['detect_mime']   = TRUE;
				$config['encrypt_name']  = TRUE;

				$this->load->library('upload', $config);
				$this->upload->initialize($config);

				if (!$this->upload->do_upload('imageFile')) {
					echo $this->upload->display_errors();
				} else {
					$upload_data = $this->upload->data();

					$data = [
						'pictureMasuk' => $upload_data['file_name'],
					];

					$this->db->where('id', $queue->idData);
					$update = $this->db->update('data', $data);

					if ($update) {
						$this->db->where('id', $queue->id);
						$this->db->update('queue', [
							'status' => 1
						]);

						echo 'Sukses upload gambar';
					} else {
						echo 'Maaf, upload gambar gagal!';
					}
				}
			}
		} else {
			echo 'Tidak ada data!';
		}
	}

	public function getQueueGambar()
	{
		$act = $this->input->get('act');

		$this->db->where('status', 0);
		$this->db->where('act', $act);

		$this->db->order_by('id', 'desc');
		$queue = $this->db->get('queue', 1)->row();

		if ($queue) {
			echo 'Ada queue';
		} else {
			echo 'Tidak ada queue';
		}
	}

	public function kirimGambarKeluar()
	{
		$this->db->where([
			'act'    => 'keluar',
			'status' => 0
		]);

		$queue = $this->db->get('queue')->row();

		if ($queue) {
			$upload_foto = $_FILES['imageFile']['name'];
			if ($upload_foto) {
				$this->load->library('upload');
				$config['upload_path']   = './upload/parkir';
				$config['allowed_types'] = 'jpg|jpeg|png';
				$config['max_size']      = '10240';
				$config['remove_spaces'] = TRUE;
				$config['detect_mime']   = TRUE;
				$config['encrypt_name']  = TRUE;

				$this->load->library('upload', $config);
				$this->upload->initialize($config);

				if (!$this->upload->do_upload('imageFile')) {
					echo 'Maaf, gambar tidak memenuhi persyaratan!';
				} else {
					$upload_data = $this->upload->data();

					$data = [
						'pictureKeluar' => $upload_data['file_name'],
					];

					$this->db->where('id', $queue->idData);
					$update = $this->db->update('data', $data);

					if ($update) {
						$this->db->where('id', $queue->id);
						$this->db->update('queue', [
							'status' => 1
						]);

						echo 'Sukses upload gambar';
					} else {
						echo 'Maaf, upload gambar gagal!';
					}
				}
			}
		} else {
			echo 'Tidak ada data!';
		}
	}
}

  /* End of file Alat.php */
