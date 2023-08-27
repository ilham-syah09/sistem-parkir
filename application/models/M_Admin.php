<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_Admin extends CI_Model
{
	public function getAllUser()
	{
		return $this->db->get('admin')->result();
	}

	public function getCountUser()
	{
		return $this->db->get('user')->num_rows();
	}

	public function getUser($where = null)
	{
		if ($where) {
			$this->db->where($where);
		}

		$this->db->order_by('user.nama', 'asc');

		return $this->db->get('user')->result();
	}

	public function getTahunIni()
	{
		$this->db->select('YEAR(tanggal) as tahun');
		$this->db->order_by('tahun', 'desc');
		$this->db->limit(1);

		$data = $this->db->get('data')->row();
		if ($data) {
			return $data->tahun;
		} else {
			return date('Y');
		}
	}

	public function getBulanIni($tahun)
	{
		$this->db->select('MONTH(tanggal) as bulan');
		$this->db->where('YEAR(tanggal)', $tahun);

		$this->db->order_by('bulan', 'desc');
		$this->db->limit(1);

		$data = $this->db->get('data')->row();
		if ($data) {
			return $data->bulan;
		} else {
			return date('m');
		}
	}

	public function getTahun()
	{
		$this->db->select('YEAR(tanggal) as tahun');
		$this->db->group_by('tahun');
		$this->db->order_by('tahun', 'desc');

		$data = $this->db->get('data')->result();

		if ($data) {
			return $data;
		} else {
			return json_decode(json_encode([
				0 =>
				['tahun' => date('Y')]
			]), FALSE);
		}
	}

	public function getDataParkir($tahun = null, $bulan = null, $hari = null, $smt = null, $expired = null)
	{
		$this->db->select('tanggal, COUNT(parkirMasuk) as jumlahMasuk, COUNT(parkirKeluar) as jumlahKeluar, COUNT(idUser) as total');

		$this->db->group_start();
		if ($tahun != null) {
			$this->db->where('YEAR(tanggal)', $tahun);
		}

		if ($bulan != null) {
			$this->db->where('MONTH(tanggal)', $bulan);
		}

		if ($hari != null) {
			$this->db->where('DAY(tanggal)', $hari);
		} else {
			// if ($ket != null) {
			// 	if ($ket == 'yes') {
			// 		$today = strtotime(date('Y-m-d'));

			// 		$minDay = date('Y-m-d', strtotime("-" . $expired . " days", $today));

			// 		$this->db->where('tanggal >=', $minDay);
			// 	}
			// }

			$this->db->where('tanggal >=', $smt->awal);
			$this->db->where('tanggal <=', $smt->akhir);
		}
		$this->db->group_end();

		$this->db->group_by('tanggal');
		$this->db->order_by('tanggal', 'asc');

		return $this->db->get('data')->result();
	}

	public function getListDataParkir($tanggal)
	{
		$this->db->select('data.*, user.nama');
		$this->db->join('user', 'user.id = data.iduser', 'inner');

		$this->db->where('data.tanggal', $tanggal);
		$this->db->order_by('user.nama', 'asc');

		return $this->db->get('data')->result();
	}

	public function getDetailDataParkir($id)
	{
		$this->db->select('data.*, user.nama');
		$this->db->join('user', 'user.id = data.iduser', 'inner');

		$this->db->where('data.id', $id);

		return $this->db->get('data')->row();
	}

	public function getPegawaiPresensi($where)
	{
		$this->db->select('presensi.idPegawai, pegawai.nama');
		$this->db->join('pegawai', 'pegawai.id = presensi.idPegawai', 'inner');

		$this->db->where($where);
		$this->db->group_by('presensi.idPegawai');
		$this->db->order_by('pegawai.nama', 'asc');

		return $this->db->get('presensi')->result();
	}

	public function getListPegawaiPresensi($where)
	{
		$this->db->select('presensi.*, pegawai.nama, jadwal.idShift');
		$this->db->join('pegawai', 'pegawai.id = presensi.idPegawai', 'inner');
		$this->db->join('jadwal', 'jadwal.id = presensi.idJadwal', 'inner');

		$this->db->where($where);
		$this->db->order_by('pegawai.nama', 'asc');

		return $this->db->get('presensi')->result();
	}

	public function getStatus()
	{
		return $this->db->get('setting')->row();
	}

	public function countUser($params)
	{
		$this->db->where('level', $params);
		return $this->db->get('user')->num_rows();
	}
}

/* End of file M_Admin.php */
