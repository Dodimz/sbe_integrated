<?php

/**
 * Author     : Alfikri, M.Kom
 * Created By : Alfikri, M.Kom
 * E-Mail     : alfikri.name@gmail.com
 * No HP      : 081277337405
 * Class      : Target_realisasi_model.php
 */
defined('BASEPATH') or exit('No direct script access allowed');

class Target_realisasi_model extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
	}

	public function get_kode_rekening_kegiatan($id_instansi)
	{
		$query  = $this->db->query("SELECT
										rf.kode_rekening_kegiatan
									FROM
										realisasi_fisik rf
									WHERE
										rf.id_instansi = {$id_instansi}
									GROUP BY
										rf.kode_rekening_kegiatan");
		return $query->result();
	}
	public function all_kegiatan($id_instansi)
	{
		$query  = $this->db->query("SELECT
										kode_rekening
									FROM
										kegiatan_apbd ka
									WHERE
										ka.id_instansi = {$id_instansi}
										and ka.pagu >0
									GROUP BY
										ka.kode_rekening");
		return $query->result();
	}

	public function total_paket($kode_rekening_kegiatan)
	{
		$query  = $this->db->query("SELECT
										pp.id_paket_pekerjaan 
									FROM
										paket_pekerjaan pp 
									WHERE
										pp.kode_rekening_kegiatan = '{$kode_rekening_kegiatan}'
									GROUP BY
										pp.kode_rekening_kegiatan");
		return $query;
	}

	public function get_target_fisik($id_instansi)
	{
		$tahap  = tahapan_apbd();
		$query  = $this->db->query("SELECT
										ta.id_instansi,
										mi.nama_instansi,
										ROUND(SUM(IF(ta.bulan = 1,ta.target_fisik, 0))/total_kegiatan(ta.id_instansi,ta.kode_tahap),2) AS jan,
										ROUND(SUM(IF(ta.bulan = 2,ta.target_fisik, 0))/total_kegiatan(ta.id_instansi,ta.kode_tahap),2) AS feb,
										ROUND(SUM(IF(ta.bulan = 3,ta.target_fisik, 0))/total_kegiatan(ta.id_instansi,ta.kode_tahap),2) AS mar,
										ROUND(SUM(IF(ta.bulan = 4,ta.target_fisik, 0))/total_kegiatan(ta.id_instansi,ta.kode_tahap),2) AS apr,
										ROUND(SUM(IF(ta.bulan = 5,ta.target_fisik, 0))/total_kegiatan(ta.id_instansi,ta.kode_tahap),2) AS mei,
										ROUND(SUM(IF(ta.bulan = 6,ta.target_fisik, 0))/total_kegiatan(ta.id_instansi,ta.kode_tahap),2) AS jun,
										ROUND(SUM(IF(ta.bulan = 7,ta.target_fisik, 0))/total_kegiatan(ta.id_instansi,ta.kode_tahap),2) AS jul,
										ROUND(SUM(IF(ta.bulan = 8,ta.target_fisik, 0))/total_kegiatan(ta.id_instansi,ta.kode_tahap),2) AS agu,
										ROUND(SUM(IF(ta.bulan = 9,ta.target_fisik, 0))/total_kegiatan(ta.id_instansi,ta.kode_tahap),2) AS sep,
										ROUND(SUM(IF(ta.bulan = 10,ta.target_fisik, 0))/total_kegiatan(ta.id_instansi,ta.kode_tahap),2) AS okt,
										ROUND(SUM(IF(ta.bulan = 11,ta.target_fisik, 0))/total_kegiatan(ta.id_instansi,ta.kode_tahap),2) AS nov,
										ROUND(SUM(IF(ta.bulan = 12,ta.target_fisik, 0))/total_kegiatan(ta.id_instansi,ta.kode_tahap),2) AS des
									FROM
										target_apbd ta
									LEFT JOIN master_instansi mi ON ta.id_instansi = mi.id_instansi
									WHERE ta.id_instansi = '{$id_instansi}'
										
									GROUP BY
										ta.id_instansi");
		return $query;
	}

	public function get_anggaran($id_instansi)
	{
		$tahap  = tahapan_apbd();
		return $this->db->query("SELECT SUM(pagu) AS pagu FROM v_program_apbd WHERE id_instansi = '{$id_instansi}' and kode_tahap='$tahap'")->row()->pagu;
	}

	public function get_target_keuangan($id_instansi)
	{
		$tahap  = tahapan_apbd();
		$query  = $this->db->query("SELECT
										ta.id_instansi,
										mi.nama_instansi,
										ka.kode_rekening_program,
										SUM(IF(ta.bulan = 1,ta.target_keuangan, 0)) AS jan,
										SUM(IF(ta.bulan = 2,ta.target_keuangan, 0)) AS feb,
										SUM(IF(ta.bulan = 3,ta.target_keuangan, 0)) AS mar,
										SUM(IF(ta.bulan = 4,ta.target_keuangan, 0)) AS apr,
										SUM(IF(ta.bulan = 5,ta.target_keuangan, 0)) AS mei,
										SUM(IF(ta.bulan = 6,ta.target_keuangan, 0)) AS jun,
										SUM(IF(ta.bulan = 7,ta.target_keuangan, 0)) AS jul,
										SUM(IF(ta.bulan = 8,ta.target_keuangan, 0)) AS agu,
										SUM(IF(ta.bulan = 9,ta.target_keuangan, 0)) AS sep,
										SUM(IF(ta.bulan = 10,ta.target_keuangan, 0)) AS okt,
										SUM(IF(ta.bulan = 11,ta.target_keuangan, 0)) AS nov,
										SUM(IF(ta.bulan = 12,ta.target_keuangan, 0)) AS des
									FROM
										target_apbd ta
										LEFT JOIN master_instansi mi ON ta.id_instansi = mi.id_instansi
										LEFT JOIN kegiatan_apbd ka ON ta.kode_rekening = ka.kode_rekening and ta.kode_tahap = ka.kode_tahap
										WHERE 
											ta.id_instansi = '{$id_instansi}'
											and ta.kode_tahap = '$tahap'
											
									GROUP BY
										ta.id_instansi");
		return $query;
	}

	public function get_realisasi_keuangan($id_instansi)
	{
		$tahap  = tahapan_apbd();
		$query  = $this->db->query("SELECT
																	SUM(IF(rk.bulan = 1,rk.belanja_pegawai + rk.belanja_barang_jasa + rk.belanja_modal, 0 )) AS jan,
																	SUM(IF(rk.bulan = 2,rk.belanja_pegawai + rk.belanja_barang_jasa + rk.belanja_modal, 0 )) AS feb,
																	SUM(IF(rk.bulan = 3,rk.belanja_pegawai + rk.belanja_barang_jasa + rk.belanja_modal, 0 )) AS mar,
																	SUM(IF(rk.bulan = 4,rk.belanja_pegawai + rk.belanja_barang_jasa + rk.belanja_modal, 0 )) AS apr,
																	SUM(IF(rk.bulan = 5,rk.belanja_pegawai + rk.belanja_barang_jasa + rk.belanja_modal, 0 )) AS mei,
																	SUM(IF(rk.bulan = 6,rk.belanja_pegawai + rk.belanja_barang_jasa + rk.belanja_modal, 0 )) AS jun,
																	SUM(IF(rk.bulan = 7,rk.belanja_pegawai + rk.belanja_barang_jasa + rk.belanja_modal, 0 )) AS jul,
																	SUM(IF(rk.bulan = 8,rk.belanja_pegawai + rk.belanja_barang_jasa + rk.belanja_modal, 0 )) AS agu,
																	SUM(IF(rk.bulan = 9,rk.belanja_pegawai + rk.belanja_barang_jasa + rk.belanja_modal, 0 )) AS sep,
																	SUM(IF(rk.bulan = 10,rk.belanja_pegawai + rk.belanja_barang_jasa + rk.belanja_modal, 0 )) AS okt,
																	SUM(IF(rk.bulan = 11,rk.belanja_pegawai + rk.belanja_barang_jasa + rk.belanja_modal, 0 )) AS nov,
																	SUM(IF(rk.bulan = 12,rk.belanja_pegawai + rk.belanja_barang_jasa + rk.belanja_modal, 0 )) AS des
																FROM
																	realisasi_keuangan rk 
																WHERE rk.id_instansi = '{$id_instansi}'
																GROUP BY
																	rk.id_instansi");
		return $query;
	}

	public function persentase($kode_rekening_kegiatan, $jenis_paket, $bulan)
	{
		$query  = $this->db->query("SELECT
										SUM( rf.nilai ) AS total 
									FROM
										realisasi_fisik rf
										LEFT JOIN paket_pekerjaan pp ON rf.id_paket_pekerjaan = pp.id_paket_pekerjaan 
									WHERE
										rf.kode_rekening_kegiatan = '{$kode_rekening_kegiatan}' 
										AND pp.jenis_paket = '{$jenis_paket}' 
									GROUP BY
										rf.bulan");
		return $query;
	}
}
