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
	public function all_kegiatan($id_instansi, $tahun, $tahap)
	{
		if ($tahap==4) {
			$where = "WHERE id_instansi = '{$id_instansi}' and tahun='$tahun'
			and status=1
			";
		}else{
			$where = "WHERE id_instansi = '{$id_instansi}' and kode_tahap='$tahap' and tahun='$tahun'";

		}
		
		$query  = $this->db->query("SELECT
										kode_rekening_sub_kegiatan, nama_sub_kegiatan, pagu
									FROM
										v_sub_kegiatan_apbd 
									$where
									");
		return $query->result();
	}
	public function total_paket($id_instansi, $kode_rekening_sub_kegiatan)
	{
		$tahun = tahun_anggaran();
		$query  = $this->db->query("SELECT
										pp.id_paket_pekerjaan
									FROM
										paket_pekerjaan pp 
									WHERE
										pp.kode_rekening_sub_kegiatan = '{$kode_rekening_sub_kegiatan}' and id_instansi = '{$id_instansi}' and pp.tahun='$tahun'
									");
		return $query;
	}
	public function total_paket_perjenis($id_instansi, $kode_rekening_sub_kegiatan, $jenis)
	{
		$tahun = tahun_anggaran();
		$query  = $this->db->query("SELECT
										pp.id_paket_pekerjaan
									FROM
										paket_pekerjaan pp 
									WHERE
										pp.kode_rekening_sub_kegiatan = '{$kode_rekening_sub_kegiatan}'
										and pp.id_instansi='{$id_instansi}'
										and 
										pp.jenis_paket	 = '{$jenis}'
										and pp.tahun='$tahun'
									");
		return $query;
	}

	public function get_target_fisik($id_instansi, $tahun, $tahap)
	{
	
		if ($tahap==4) {
			$where = "WHERE ski.id_instansi = '{$id_instansi}'
									and ski.status = '1' and ski.tahun='$tahun'";
			$banyak_kegiatan = "total_kegiatan_perubahan(ski.id_instansi,$tahap, ski.tahun)";
		}else{
			$where = "WHERE ski.id_instansi = '{$id_instansi}'
									and ski.kode_tahap = '{$tahap}' and ski.tahun='$tahun'";
			$banyak_kegiatan = "total_kegiatan(ski.id_instansi,ski.kode_tahap, ski.tahun)";

		}
		$query  = $this->db->query("SELECT
										ta.id_instansi,
										ROUND(SUM(IF(ta.bulan = 1,ta.target_fisik, 0))/$banyak_kegiatan ,2) AS jan,
										ROUND(SUM(IF(ta.bulan = 2,ta.target_fisik, 0))/$banyak_kegiatan ,2) AS feb,
										ROUND(SUM(IF(ta.bulan = 3,ta.target_fisik, 0))/$banyak_kegiatan ,2) AS mar,
										ROUND(SUM(IF(ta.bulan = 4,ta.target_fisik, 0))/$banyak_kegiatan ,2) AS apr,
										ROUND(SUM(IF(ta.bulan = 5,ta.target_fisik, 0))/$banyak_kegiatan ,2) AS mei,
										ROUND(SUM(IF(ta.bulan = 6,ta.target_fisik, 0))/$banyak_kegiatan ,2) AS jun,
										ROUND(SUM(IF(ta.bulan = 7,ta.target_fisik, 0))/$banyak_kegiatan ,2) AS jul,
										ROUND(SUM(IF(ta.bulan = 8,ta.target_fisik, 0))/$banyak_kegiatan ,2) AS agu,
										ROUND(SUM(IF(ta.bulan = 9,ta.target_fisik, 0))/$banyak_kegiatan ,2) AS sep,
										ROUND(SUM(IF(ta.bulan = 10,ta.target_fisik, 0))/$banyak_kegiatan ,2) AS okt,
										ROUND(SUM(IF(ta.bulan = 11,ta.target_fisik, 0))/$banyak_kegiatan ,2) AS nov,
										ROUND(SUM(IF(ta.bulan = 12,ta.target_fisik, 0))/$banyak_kegiatan ,2) AS des, 
										ROUND(SUM(IF(ta.bulan = 1,ta.target_fisik_bulanan, 0))/$banyak_kegiatan ,2) AS jan_bulanan,
										ROUND(SUM(IF(ta.bulan = 2,ta.target_fisik_bulanan, 0))/$banyak_kegiatan ,2) AS feb_bulanan,
										ROUND(SUM(IF(ta.bulan = 3,ta.target_fisik_bulanan, 0))/$banyak_kegiatan ,2) AS mar_bulanan,
										ROUND(SUM(IF(ta.bulan = 4,ta.target_fisik_bulanan, 0))/$banyak_kegiatan ,2) AS apr_bulanan,
										ROUND(SUM(IF(ta.bulan = 5,ta.target_fisik_bulanan, 0))/$banyak_kegiatan ,2) AS mei_bulanan,
										ROUND(SUM(IF(ta.bulan = 6,ta.target_fisik_bulanan, 0))/$banyak_kegiatan ,2) AS jun_bulanan,
										ROUND(SUM(IF(ta.bulan = 7,ta.target_fisik_bulanan, 0))/$banyak_kegiatan ,2) AS jul_bulanan,
										ROUND(SUM(IF(ta.bulan = 8,ta.target_fisik_bulanan, 0))/$banyak_kegiatan ,2) AS agu_bulanan,
										ROUND(SUM(IF(ta.bulan = 9,ta.target_fisik_bulanan, 0))/$banyak_kegiatan ,2) AS sep_bulanan,
										ROUND(SUM(IF(ta.bulan = 10,ta.target_fisik_bulanan, 0))/$banyak_kegiatan ,2) AS okt_bulanan,
										ROUND(SUM(IF(ta.bulan = 11,ta.target_fisik_bulanan, 0))/$banyak_kegiatan ,2) AS nov_bulanan,
										ROUND(SUM(IF(ta.bulan = 12,ta.target_fisik_bulanan, 0))/$banyak_kegiatan ,2) AS des_bulanan
									FROM
										target_apbd ta
									left join sub_kegiatan_instansi ski on 
ta.kode_rekening_sub_kegiatan=ski.kode_sub_kegiatan and ta.id_instansi=ski.id_instansi and ta.kode_tahap = ski.kode_tahap and ta.tahun = ski.tahun
									$where
									GROUP BY
										ta.id_instansi");
		return $query;
	}


	public function get_target_keuangan_ratarata($id_instansi)
	{
		$tahap  = tahapan_apbd();
		$tahun  = tahun_anggaran();
		$query  = $this->db->query("SELECT
										ta.id_instansi,
										mi.nama_instansi,
										ROUND(SUM(IF(ta.bulan = 1,ta.persen_target_keuangan, 0))/total_kegiatan(ta.id_instansi,ta.kode_tahap, ta.tahun),2) AS jan,
										ROUND(SUM(IF(ta.bulan = 2,ta.persen_target_keuangan, 0))/total_kegiatan(ta.id_instansi,ta.kode_tahap, ta.tahun),2) AS feb,
										ROUND(SUM(IF(ta.bulan = 3,ta.persen_target_keuangan, 0))/total_kegiatan(ta.id_instansi,ta.kode_tahap, ta.tahun),2) AS mar,
										ROUND(SUM(IF(ta.bulan = 4,ta.persen_target_keuangan, 0))/total_kegiatan(ta.id_instansi,ta.kode_tahap, ta.tahun),2) AS apr,
										ROUND(SUM(IF(ta.bulan = 5,ta.persen_target_keuangan, 0))/total_kegiatan(ta.id_instansi,ta.kode_tahap, ta.tahun),2) AS mei,
										ROUND(SUM(IF(ta.bulan = 6,ta.persen_target_keuangan, 0))/total_kegiatan(ta.id_instansi,ta.kode_tahap, ta.tahun),2) AS jun,
										ROUND(SUM(IF(ta.bulan = 7,ta.persen_target_keuangan, 0))/total_kegiatan(ta.id_instansi,ta.kode_tahap, ta.tahun),2) AS jul,
										ROUND(SUM(IF(ta.bulan = 8,ta.persen_target_keuangan, 0))/total_kegiatan(ta.id_instansi,ta.kode_tahap, ta.tahun),2) AS agu,
										ROUND(SUM(IF(ta.bulan = 9,ta.persen_target_keuangan, 0))/total_kegiatan(ta.id_instansi,ta.kode_tahap, ta.tahun),2) AS sep,
										ROUND(SUM(IF(ta.bulan = 10,ta.persen_target_keuangan, 0))/total_kegiatan(ta.id_instansi,ta.kode_tahap, ta.tahun),2) AS okt,
										ROUND(SUM(IF(ta.bulan = 11,ta.persen_target_keuangan, 0))/total_kegiatan(ta.id_instansi,ta.kode_tahap, ta.tahun),2) AS nov,
										ROUND(SUM(IF(ta.bulan = 12,ta.persen_target_keuangan, 0))/total_kegiatan(ta.id_instansi,ta.kode_tahap, ta.tahun),2) AS des, 
										ROUND(SUM(IF(ta.bulan = 1,ta.persen_target_keuangan_bulanan, 0))/total_kegiatan(ta.id_instansi,ta.kode_tahap, ta.tahun),2) AS jan_bulanan,
										ROUND(SUM(IF(ta.bulan = 2,ta.persen_target_keuangan_bulanan, 0))/total_kegiatan(ta.id_instansi,ta.kode_tahap, ta.tahun),2) AS feb_bulanan,
										ROUND(SUM(IF(ta.bulan = 3,ta.persen_target_keuangan_bulanan, 0))/total_kegiatan(ta.id_instansi,ta.kode_tahap, ta.tahun),2) AS mar_bulanan,
										ROUND(SUM(IF(ta.bulan = 4,ta.persen_target_keuangan_bulanan, 0))/total_kegiatan(ta.id_instansi,ta.kode_tahap, ta.tahun),2) AS apr_bulanan,
										ROUND(SUM(IF(ta.bulan = 5,ta.persen_target_keuangan_bulanan, 0))/total_kegiatan(ta.id_instansi,ta.kode_tahap, ta.tahun),2) AS mei_bulanan,
										ROUND(SUM(IF(ta.bulan = 6,ta.persen_target_keuangan_bulanan, 0))/total_kegiatan(ta.id_instansi,ta.kode_tahap, ta.tahun),2) AS jun_bulanan,
										ROUND(SUM(IF(ta.bulan = 7,ta.persen_target_keuangan_bulanan, 0))/total_kegiatan(ta.id_instansi,ta.kode_tahap, ta.tahun),2) AS jul_bulanan,
										ROUND(SUM(IF(ta.bulan = 8,ta.persen_target_keuangan_bulanan, 0))/total_kegiatan(ta.id_instansi,ta.kode_tahap, ta.tahun),2) AS agu_bulanan,
										ROUND(SUM(IF(ta.bulan = 9,ta.persen_target_keuangan_bulanan, 0))/total_kegiatan(ta.id_instansi,ta.kode_tahap, ta.tahun),2) AS sep_bulanan,
										ROUND(SUM(IF(ta.bulan = 10,ta.persen_target_keuangan_bulanan, 0))/total_kegiatan(ta.id_instansi,ta.kode_tahap, ta.tahun),2) AS okt_bulanan,
										ROUND(SUM(IF(ta.bulan = 11,ta.persen_target_keuangan_bulanan, 0))/total_kegiatan(ta.id_instansi,ta.kode_tahap, ta.tahun),2) AS nov_bulanan,
										ROUND(SUM(IF(ta.bulan = 12,ta.persen_target_keuangan_bulanan, 0))/total_kegiatan(ta.id_instansi,ta.kode_tahap, ta.tahun),2) AS des_bulanan
									FROM
										target_apbd ta
									LEFT JOIN master_instansi mi ON ta.id_instansi = mi.id_instansi
									WHERE ta.id_instansi = '{$id_instansi}'
									and ta.kode_tahap = '{$tahap}' and ta.tahun='$tahun'
									GROUP BY
										ta.id_instansi");
		return $query;
	}




	public function get_persen_target_keuangan($id_instansi)
	{
		$tahap  = tahapan_apbd();
		$tahun  = tahun_anggaran();
		$query  = $this->db->query("SELECT
										ta.id_instansi,
										mi.nama_instansi,
										ROUND(SUM(IF(ta.bulan = 1,ta.persen_target_keuangan, 0))/total_kegiatan(ta.id_instansi,ta.kode_tahap, ta.tahun),2) AS jan,
										ROUND(SUM(IF(ta.bulan = 2,ta.persen_target_keuangan, 0))/total_kegiatan(ta.id_instansi,ta.kode_tahap, ta.tahun),2) AS feb,
										ROUND(SUM(IF(ta.bulan = 3,ta.persen_target_keuangan, 0))/total_kegiatan(ta.id_instansi,ta.kode_tahap, ta.tahun),2) AS mar,
										ROUND(SUM(IF(ta.bulan = 4,ta.persen_target_keuangan, 0))/total_kegiatan(ta.id_instansi,ta.kode_tahap, ta.tahun),2) AS apr,
										ROUND(SUM(IF(ta.bulan = 5,ta.persen_target_keuangan, 0))/total_kegiatan(ta.id_instansi,ta.kode_tahap, ta.tahun),2) AS mei,
										ROUND(SUM(IF(ta.bulan = 6,ta.persen_target_keuangan, 0))/total_kegiatan(ta.id_instansi,ta.kode_tahap, ta.tahun),2) AS jun,
										ROUND(SUM(IF(ta.bulan = 7,ta.persen_target_keuangan, 0))/total_kegiatan(ta.id_instansi,ta.kode_tahap, ta.tahun),2) AS jul,
										ROUND(SUM(IF(ta.bulan = 8,ta.persen_target_keuangan, 0))/total_kegiatan(ta.id_instansi,ta.kode_tahap, ta.tahun),2) AS agu,
										ROUND(SUM(IF(ta.bulan = 9,ta.persen_target_keuangan, 0))/total_kegiatan(ta.id_instansi,ta.kode_tahap, ta.tahun),2) AS sep,
										ROUND(SUM(IF(ta.bulan = 10,ta.persen_target_keuangan, 0))/total_kegiatan(ta.id_instansi,ta.kode_tahap, ta.tahun),2) AS okt,
										ROUND(SUM(IF(ta.bulan = 11,ta.persen_target_keuangan, 0))/total_kegiatan(ta.id_instansi,ta.kode_tahap, ta.tahun),2) AS nov,
										ROUND(SUM(IF(ta.bulan = 12,ta.persen_target_keuangan, 0))/total_kegiatan(ta.id_instansi,ta.kode_tahap, ta.tahun),2) AS des, 
										ROUND(SUM(IF(ta.bulan = 1,ta.persen_target_keuangan_bulanan, 0))/total_kegiatan(ta.id_instansi,ta.kode_tahap, ta.tahun),2) AS jan_bulanan,
										ROUND(SUM(IF(ta.bulan = 2,ta.persen_target_keuangan_bulanan, 0))/total_kegiatan(ta.id_instansi,ta.kode_tahap, ta.tahun),2) AS feb_bulanan,
										ROUND(SUM(IF(ta.bulan = 3,ta.persen_target_keuangan_bulanan, 0))/total_kegiatan(ta.id_instansi,ta.kode_tahap, ta.tahun),2) AS mar_bulanan,
										ROUND(SUM(IF(ta.bulan = 4,ta.persen_target_keuangan_bulanan, 0))/total_kegiatan(ta.id_instansi,ta.kode_tahap, ta.tahun),2) AS apr_bulanan,
										ROUND(SUM(IF(ta.bulan = 5,ta.persen_target_keuangan_bulanan, 0))/total_kegiatan(ta.id_instansi,ta.kode_tahap, ta.tahun),2) AS mei_bulanan,
										ROUND(SUM(IF(ta.bulan = 6,ta.persen_target_keuangan_bulanan, 0))/total_kegiatan(ta.id_instansi,ta.kode_tahap, ta.tahun),2) AS jun_bulanan,
										ROUND(SUM(IF(ta.bulan = 7,ta.persen_target_keuangan_bulanan, 0))/total_kegiatan(ta.id_instansi,ta.kode_tahap, ta.tahun),2) AS jul_bulanan,
										ROUND(SUM(IF(ta.bulan = 8,ta.persen_target_keuangan_bulanan, 0))/total_kegiatan(ta.id_instansi,ta.kode_tahap, ta.tahun),2) AS agu_bulanan,
										ROUND(SUM(IF(ta.bulan = 9,ta.persen_target_keuangan_bulanan, 0))/total_kegiatan(ta.id_instansi,ta.kode_tahap, ta.tahun),2) AS sep_bulanan,
										ROUND(SUM(IF(ta.bulan = 10,ta.persen_target_keuangan_bulanan, 0))/total_kegiatan(ta.id_instansi,ta.kode_tahap, ta.tahun),2) AS okt_bulanan,
										ROUND(SUM(IF(ta.bulan = 11,ta.persen_target_keuangan_bulanan, 0))/total_kegiatan(ta.id_instansi,ta.kode_tahap, ta.tahun),2) AS nov_bulanan,
										ROUND(SUM(IF(ta.bulan = 12,ta.persen_target_keuangan_bulanan, 0))/total_kegiatan(ta.id_instansi,ta.kode_tahap, ta.tahun),2) AS des_bulanan
									FROM
										target_apbd ta
									LEFT JOIN master_instansi mi ON ta.id_instansi = mi.id_instansi
									WHERE ta.id_instansi = '{$id_instansi}'
									and ta.kode_tahap = '{$tahap}' and ta.tahun='$tahun'
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
	public function realisasi_keuangan($id_instansi, $bulan, $ope, $tahun, $tahap)
	{	
		

		if ($tahap==4) {
			$where = "WHERE ski.id_instansi = '{$id_instansi}'
									and ski.status = '1' and ski.tahun='$tahun'";
		}else{
			$where = "WHERE ski.id_instansi = '{$id_instansi}'
									and ski.kode_tahap = '{$tahap}' and ski.tahun='$tahun'";
			
		}



		$query  = $this->db->query("SELECT


			SUM(rk.bo_bp + rk.bo_bbj+ rk.bo_bs+rk.bo_bh + rk.bm_bmt + rk.bm_bmpm + rk.bm_bmgb + rk.bm_bmjji + rk.bm_bmatl + rk.btt + rk.bt_bbh + rk.bt_bbk) as realisasi_keuangan,
			sum(rk.bo_bp) as realisasi_keuangan_bo_bp, 
			sum(rk.bo_bbj) as realisasi_keuangan_bo_bbj, 
			sum(rk.bo_bs) as realisasi_keuangan_bo_bs, 
			sum(rk.bo_bh) as realisasi_keuangan_bo_bh, 
			sum(rk.bm_bmt) as realisasi_keuangan_bm_bmt, 
			sum(rk.bm_bmpm) as realisasi_keuangan_bm_bmpm, 
			sum(rk.bm_bmgb) as realisasi_keuangan_bm_bmgb, 
			sum(rk.bm_bmjji) as realisasi_keuangan_bm_bmjji, 
			sum(rk.bm_bmatl) as realisasi_keuangan_bm_bmatl, 
			sum(rk.btt) as realisasi_keuangan_btt, 
			sum(rk.bt_bbh) as realisasi_keuangan_bt_bbh, 
			sum(rk.bt_bbk) as realisasi_keuangan_bt_bbk
									from realisasi_keuangan rk 

left join sub_kegiatan_instansi ski on 
rk.kode_sub_kegiatan=ski.kode_sub_kegiatan and rk.id_instansi=ski.id_instansi and rk.kode_tahap = ski.kode_tahap and rk.tahun = ski.tahun

									$where
									and bulan $ope '$bulan'
									");
		return $query->row();
	}
	public function get_anggaran($id_instansi, $tahap, $tahun)
	{
		if ($tahap==4) {
			$where = "WHERE ski.id_instansi = '{$id_instansi}' and ski.tahun='$tahun'
			and ski.status=1
			";
		}else{
			$where = "WHERE ski.id_instansi = '{$id_instansi}' and ski.kode_tahap='$tahap' and ski.tahun='$tahun'";

		}
		return $this->db->query("SELECT 
			SUM(ask.bo_bp + ask.bo_bbj + ask.bo_bs + ask.bo_bh + ask.bm_bmt + ask.bm_bmpm + ask.bm_bmgb + ask.bm_bmjji + ask.bm_bmatl + ask.btt + ask.bt_bbh + ask.bt_bbk)  AS pagu,
			sum(ask.bo_bp) as pagu_bo_bp , 
			sum(ask.bo_bbj) as pagu_bo_bbj , 
			sum(ask.bo_bs) as pagu_bo_bs , 
			sum(ask.bo_bh) as pagu_bo_bh , 
			sum(ask.bm_bmt) as pagu_bm_bmt , 
			sum(ask.bm_bmpm) as pagu_bm_bmpm , 
			sum(ask.bm_bmgb) as pagu_bm_bmgb , 
			sum(ask.bm_bmjji) as pagu_bm_bmjji , 
			sum(ask.bm_bmatl) as pagu_bm_bmatl , 
			sum(ask.btt) as pagu_btt , 
			sum(ask.bt_bbh) as pagu_bt_bbh , 
			sum(ask.bt_bbk) as pagu_bt_bbk
			  FROM anggaran_sub_kegiatan ask left join sub_kegiatan_instansi ski on 
ask.kode_sub_kegiatan=ski.kode_sub_kegiatan and ask.id_instansi=ski.id_instansi and ask.kode_tahap = ski.kode_tahap and ask.tahun = ski.tahun
			  $where")->row();
	}
	public function jumlah_kegiatan($id_instansi)
	{
		$tahap  = tahapan_apbd();
		return $this->db->query("SELECT total_kegiatan($id_instansi, $tahap) as total_kegiatan")->row()->total_kegiatan;
	}

	public function get_target_keuangan($id_instansi, $tahun, $tahap)
	{
		if ($tahap==4) {
			$where = "WHERE ski.id_instansi = '{$id_instansi}'
									and ski.status = '1' and ski.tahun='$tahun'";
			$banyak_kegiatan = "total_kegiatan_perubahan(ski.id_instansi,$tahap, ski.tahun)";
		}else{
			$where = "WHERE ski.id_instansi = '{$id_instansi}'
									and ski.kode_tahap = '{$tahap}' and ski.tahun='$tahun'";
			$banyak_kegiatan = "total_kegiatan(ski.id_instansi,ski.kode_tahap, ski.tahun)";

		}

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
										SUM(IF(ta.bulan = 12,ta.target_keuangan, 0)) AS des, 

										SUM(IF(ta.bulan = 1,ta.target_keuangan_bulanan, 0)) AS jan_bulanan,
										SUM(IF(ta.bulan = 2,ta.target_keuangan_bulanan, 0)) AS feb_bulanan,
										SUM(IF(ta.bulan = 3,ta.target_keuangan_bulanan, 0)) AS mar_bulanan,
										SUM(IF(ta.bulan = 4,ta.target_keuangan_bulanan, 0)) AS apr_bulanan,
										SUM(IF(ta.bulan = 5,ta.target_keuangan_bulanan, 0)) AS mei_bulanan,
										SUM(IF(ta.bulan = 6,ta.target_keuangan_bulanan, 0)) AS jun_bulanan,
										SUM(IF(ta.bulan = 7,ta.target_keuangan_bulanan, 0)) AS jul_bulanan,
										SUM(IF(ta.bulan = 8,ta.target_keuangan_bulanan, 0)) AS agu_bulanan,
										SUM(IF(ta.bulan = 9,ta.target_keuangan_bulanan, 0)) AS sep_bulanan,
										SUM(IF(ta.bulan = 10,ta.target_keuangan_bulanan, 0)) AS okt_bulanan,
										SUM(IF(ta.bulan = 11,ta.target_keuangan_bulanan, 0)) AS nov_bulanan,
										SUM(IF(ta.bulan = 12,ta.target_keuangan_bulanan, 0)) AS des_bulanan
									FROM
										target_apbd ta
									left join sub_kegiatan_instansi ski on 
ta.kode_rekening_sub_kegiatan=ski.kode_sub_kegiatan and ta.id_instansi=ski.id_instansi and ta.kode_tahap = ski.kode_tahap and ta.tahun = ski.tahun
									$where
									
									GROUP BY
										ta.id_instansi");
		return $query;
	}

	public function get_realisasi_keuangan($id_instansi, $tahap, $tahun)
	{
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
									and rk.kode_tahap = '$tahap' and rk.tahun='$tahun'
									GROUP BY
										rk.id_instansi");
		return $query;
	}

	public function persentase($kode_rekening_sub_kegiatan, $jenis_paket, $bulan)
	{
		$tahun=tahun_anggaran();
		$query  = $this->db->query("SELECT
										SUM( rf.nilai ) AS total 
									FROM
										realisasi_fisik rf
										LEFT JOIN paket_pekerjaan pp ON rf.id_paket_pekerjaan = pp.id_paket_pekerjaan 
									WHERE
										rf.kode_rekening_sub_kegiatan = '{$kode_rekening_sub_kegiatan}' 
										AND pp.jenis_paket = '{$jenis_paket}' 
										AND rf.bulan <= '{$bulan}' and rf.tahun='$tahun'
									");
		return $query;
	}
}
