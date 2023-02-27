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
		$tahap = tahapan_apbd();
		$query  = $this->db->query("SELECT
										kode_rekening_sub_kegiatan, nama_sub_kegiatan, pagu
									FROM
										v_sub_kegiatan_apbd 
									WHERE
										id_instansi = '{$id_instansi}'
										and kode_tahap = '$tahap'
									");
		return $query->result();
	}
	public function total_paket($id_instansi, $kode_rekening_sub_kegiatan)
	{
		$query  = $this->db->query("SELECT
										pp.id_paket_pekerjaan
									FROM
										paket_pekerjaan pp 
									WHERE
										pp.kode_rekening_sub_kegiatan = '{$kode_rekening_sub_kegiatan}' and id_instansi = '{$id_instansi}'
									");
		return $query;
	}
	public function total_paket_perjenis($id_instansi, $kode_rekening_sub_kegiatan, $jenis)
	{
		$query  = $this->db->query("SELECT
										pp.id_paket_pekerjaan
									FROM
										paket_pekerjaan pp 
									WHERE
										pp.kode_rekening_sub_kegiatan = '{$kode_rekening_sub_kegiatan}'
										and pp.id_instansi='{$id_instansi}'
										and 
										pp.jenis_paket	 = '{$jenis}'
									");
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
									and ta.kode_tahap = '{$tahap}'
									GROUP BY
										ta.id_instansi");
		return $query;
	}


	public function target_fisik_perkegiatan($id_instansi, $tahap, $bulan , $kode_rekening)
	{
		
		$query  = $this->db->query("SELECT
									target_fisik 
									from target_apbd 
									where id_instansi = '$id_instansi' and kode_tahap = '$tahap' and bulan = '$bulan'
									and kode_rekening = '$kode_rekening'
									");
		return $query->row();
	}
	public function target_keuangan_perkegiatan($id_instansi, $tahap, $bulan , $kode_rekening)
	{
		
		$query  = $this->db->query("SELECT
									sum(target_keuangan) as target_keuangan 
									from target_apbd 
									where id_instansi = '$id_instansi' and kode_tahap = '$tahap' and bulan = '$bulan'
									and kode_rekening = '$kode_rekening'
									");
		return $query->row();
	}
	public function realisasi_keuangan_perkegiatan($id_instansi, $bulan , $kode_rekening)
	{
		
		$query  = $this->db->query("SELECT


			SUM(belanja_pegawai + belanja_barang_jasa + belanja_modal) as realisasi_keuangan 
									from realisasi_keuangan  
									where id_instansi = '$id_instansi' 
									and bulan <= '$bulan'
									and kode_rekening = '$kode_rekening'
									");
		return $query->row();
	}
	public function realisasi_keuangan($id_instansi, $bulan)
	{
		
		$tahap = tahapan_apbd();
		$query  = $this->db->query("SELECT

			SUM(bo_bp + bo_bbj+ bo_bs+bo_bh + bm_bmt + bm_bmpm + bm_bmgb + bm_bmjji + bm_bmatl + btt + bt_bbh + bt_bbk) as realisasi_keuangan 
									from realisasi_keuangan  
									where id_instansi = '$id_instansi' 
									and kode_tahap = '$tahap' 
									and bulan <= '$bulan'
									");
		return $query->row();
	}
	public function get_anggaran($id_instansi)
	{
		$tahap  = tahapan_apbd();
		return $this->db->query("SELECT SUM(pagu) AS pagu FROM v_program_apbd WHERE id_instansi = '{$id_instansi}' and kode_tahap='$tahap'")->row()->pagu;
	}
	public function jumlah_kegiatan($id_instansi)
	{
		$tahap  = tahapan_apbd();
		return $this->db->query("SELECT total_kegiatan($id_instansi, $tahap) as total_kegiatan")->row()->total_kegiatan;
	}

	public function get_target_keuangan($id_instansi)
	{
		$tahap  = tahapan_apbd();
		$query  = $this->db->query("SELECT
										ta.id_instansi,
										
										ta.kode_rekening_program,
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
		$total_realisasi = 'bo_bp + bo_bbj+ bo_bs+bo_bh + bm_bmt + bm_bmpm + bm_bmgb + bm_bmjji + bm_bmatl + btt + bt_bbh + bt_bbk';
		$query  = $this->db->query("SELECT
										SUM(IF(rk.bulan = 1, $total_realisasi, 0 )) AS jan,
										SUM(IF(rk.bulan = 2, $total_realisasi, 0 )) AS feb,
										SUM(IF(rk.bulan = 3, $total_realisasi, 0 )) AS mar,
										SUM(IF(rk.bulan = 4, $total_realisasi, 0 )) AS apr,
										SUM(IF(rk.bulan = 5, $total_realisasi, 0 )) AS mei,
										SUM(IF(rk.bulan = 6, $total_realisasi, 0 )) AS jun,
										SUM(IF(rk.bulan = 7, $total_realisasi, 0 )) AS jul,
										SUM(IF(rk.bulan = 8, $total_realisasi, 0 )) AS agu,
										SUM(IF(rk.bulan = 9, $total_realisasi, 0 )) AS sep,
										SUM(IF(rk.bulan = 10, $total_realisasi, 0 )) AS okt,
										SUM(IF(rk.bulan = 11, $total_realisasi, 0 )) AS nov,
										SUM(IF(rk.bulan = 12, $total_realisasi, 0 )) AS des
									FROM
										realisasi_keuangan rk 
									WHERE rk.id_instansi = '{$id_instansi}'
									GROUP BY
										rk.id_instansi");
		return $query;
	}

	public function persentase($kode_rekening_sub_kegiatan, $jenis_paket, $bulan)
	{
		$query  = $this->db->query("SELECT
										SUM( rf.nilai ) AS total 
									FROM
										realisasi_fisik rf
										LEFT JOIN paket_pekerjaan pp ON rf.id_paket_pekerjaan = pp.id_paket_pekerjaan 
									WHERE
										rf.kode_rekening_sub_kegiatan = '{$kode_rekening_sub_kegiatan}' 
										AND pp.jenis_paket = '{$jenis_paket}' 
										AND rf.bulan <= '{$bulan}' 
									");
		return $query;
	}
}
