<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');

function hari($hari)
{
	if ($hari == 1) {
		$hari = "Senin";
	} else if ($hari == 2) {
		$hari = "Selasa";
	} else if ($hari == 3) {
		$hari = "Rabu";
	} else if ($hari == 4) {
		$hari = "Kamis";
	} else if ($hari == 5) {
		$hari = "Jum'at";
	} else if ($hari == 6) {
		$hari = "Sabtu";
	} else if ($hari == 7) {
		$hari = "Ahad";
	}
	return $hari;
}

function bulan($bulan)
{
	switch ($bulan) {
		case 1:
			$bulan = "Januari";
			break;
		case 2:
			$bulan = "Februari";
			break;
		case 3:
			$bulan = "Maret";
			break;
		case 4:
			$bulan = "April";
			break;
		case 5:
			$bulan = "Mei";
			break;
		case 6:
			$bulan = "Juni";
			break;
		case 7:
			$bulan = "Juli";
			break;
		case 8:
			$bulan = "Agustus";
			break;
		case 9:
			$bulan = "September";
			break;
		case 10:
			$bulan = "Oktober";
			break;
		case 11:
			$bulan = "November";
			break;
		case 12:
			$bulan = "Desember";
			break;

		default:
			$bulan = Date('F');
			break;
	}
	return $bulan;
}
