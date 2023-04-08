<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_User extends CI_Model
{
	public function getTahunIni()
	{
		$this->db->select('YEAR(tanggal) as tahun');
		$this->db->order_by('tahun', 'desc');
		$this->db->limit(1);

		$data = $this->db->get('data')->row();
		return $data->tahun;
	}

	public function getBulanIni($tahun)
	{
		$this->db->select('MONTH(tanggal) as bulan');
		$this->db->where('YEAR(tanggal)', $tahun);

		$this->db->order_by('bulan', 'desc');
		$this->db->limit(1);

		$data = $this->db->get('data')->row();
		return $data->bulan;
	}

	public function getTahun()
	{
		$this->db->select('YEAR(tanggal) as tahun');
		$this->db->group_by('tahun');
		$this->db->order_by('tahun', 'desc');

		return $this->db->get('data')->result();
	}

	public function getDataParkirHariIni($where)
	{
		$this->db->where($where);
		$this->db->order_by('createdAt', 'desc');

		return $this->db->get('data', 1)->row();
	}

	public function getDataParkir($where)
	{
		$this->db->where($where);
		$this->db->order_by('tanggal, parkirMasuk', 'asc');

		return $this->db->get('data')->result();
	}
}

/* End of file M_User.php */
