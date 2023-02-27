<?php

/**
 * Author     : Alfikri, M.Kom
 * Created By : Alfikri, M.Kom
 * E-Mail     : alfikri.name@gmail.com
 * No HP      : 081277337405
 * Class      : Realisasi_akumulasi_model.php
 */
defined('BASEPATH') or exit('No direct script access allowed');

class Synchronize_model extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
	}


	public function total_dashboard($tahun, $kode_tahap, $bulan)
	{	
		
		$q = $this->db->query("SELECT sum(pagu_total) as total_pagu, sum(rp_target_keuangan_akumulasi) as total_target, sum(rp_realisasi_keuangan_akumulasi) as total_realisasi
			from grafik where tahun = '$tahun' and kode_tahap='$kode_tahap' and bulan='$bulan'");
		return $q;
	}
	public function laporan_opd($tahun, $kode_tahap, $bulan)
	{	
		
		$q = $this->db->query("SELECT mi.nama_instansi, g.pagu_total, g.rp_target_keuangan_akumulasi, g.rp_realisasi_keuangan_akumulasi,
			 g.target_fisik_akumulasi, g.target_fisik_bulanan, g.realisasi_fisik_akumulasi, g.realisasi_fisik_bulanan , 
			 g.id_instansi, g.tahun, g.kode_tahap, g.bulan
			from grafik g  
			left join master_instansi mi on g.id_instansi = mi.id_instansi
			where
			g.tahun = '$tahun' and g.kode_tahap='$kode_tahap' and g.bulan='$bulan'");
		return $q;
	}
	public function laporan_sub_kegiatan_opd_gabungan($id_instansi, $tahun, $kode_tahap, $bulan)
	{	
		
		$q = $this->db->query("SELECT *
			from laporan_sub_kegiatan_opd  where tahun = '$tahun' and kode_tahap='$kode_tahap' and bulan='$bulan' and id_instansi='$id_instansi'
			order by kode_sub_kegiatan asc
			");
		return $q;
	}
	public function laporan_program_opd($id_instansi, $tahun, $kode_tahap, $bulan)
	{	
		
		$q = $this->db->query("SELECT kode_program, nama_program
			from laporan_sub_kegiatan_opd  where tahun = '$tahun' and kode_tahap='$kode_tahap' and bulan='$bulan' and id_instansi='$id_instansi'
			group by kode_program
			order by kode_program asc
			");
		return $q;
	}
	public function laporan_kegiatan_opd($id_instansi, $tahun, $kode_tahap, $bulan, $kode_program)
	{	
		
		$q = $this->db->query("SELECT kode_kegiatan, nama_kegiatan
			from laporan_sub_kegiatan_opd  where tahun = '$tahun' and kode_tahap='$kode_tahap' and bulan='$bulan' and id_instansi='$id_instansi' and kode_program='$kode_program'
			group by kode_kegiatan
			order by kode_kegiatan asc
			");
		return $q;
	}
	public function laporan_sub_kegiatan_opd($id_instansi, $tahun, $kode_tahap, $bulan, $kode_kegiatan)
	{	
		
		$q = $this->db->query("SELECT 
			kode_sub_kegiatan, nama_sub_kegiatan, 
			pagu_total, pptk,
			target_fisik_akumulasi, realisasi_fisik_akumulasi, rp_target_keuangan_akumulasi, rp_realisasi_keuangan_akumulasi, target_keuangan_akumulasi, realisasi_keuangan_akumulasi

			from laporan_sub_kegiatan_opd  where tahun = '$tahun' and kode_tahap='$kode_tahap' and bulan='$bulan' and id_instansi='$id_instansi' and kode_kegiatan='$kode_kegiatan'
			order by kode_sub_kegiatan asc
			");
		return $q;
	}

	


	public function get_sub_kegiatan($id_instansi, $tahun, $tahap)
	{	
		
		if ($tahap == 4 ) {
			
			$where 		=['id_instansi'=>$id_instansi, 'tahun'=>$tahun,'status'=>1];
			$sub_kegiatan 	=$this->db->get_where('v_sub_kegiatan_apbd' , $where);
		}else{
			$where 		=['id_instansi'=>$id_instansi, 'tahun'=>$tahun, 'kode_tahap'=>$tahap];
			$sub_kegiatan 	=$this->db->get_where('v_sub_kegiatan_apbd' , $where);
		}


		return $sub_kegiatan;
	}




	public function get_target($id_instansi, $kode_rekening_sub_kegiatan,$tahap, $tahun)
	{
		// $tahun 				= $this->input->get('tahun');
		// $tahap 				= $this->input->get('tahap');

		$where =  [
			'id_instansi' => $id_instansi,
			'kode_tahap' => $tahap,
			'tahun' => $tahun,
			'kode_rekening_sub_kegiatan' => $kode_rekening_sub_kegiatan
		];


			$this->db->select('kode_rekening_sub_kegiatan,target_fisik,target_keuangan,target_fisik_bulanan,target_keuangan_bulanan ');
			$this->db->order_by('bulan', 'asc');
		return $this->db->get_where('target_apbd', $where);
	}




	public function get_realisasi_keuangan($id_instansi, $kode_rekening_sub_kegiatan, $tahun, $tahap)
	{
		// $tahun 				= $this->input->get('tahun');
		// $tahap 				= $this->input->get('tahap');
		$query  = $this->db->query("SELECT
										bulan,
										(bo_bp + bo_bbj+ bo_bs+bo_bh + bm_bmt + bm_bmpm + bm_bmgb + bm_bmjji + bm_bmatl +btt +  bt_bbh+bt_bbk ) as total_realisasi,
										bo_bp as realisasi_bo_bp,
										bo_bbj as realisasi_bo_bbj,
										bo_bs as realisasi_bo_bs,
										bo_bh as realisasi_bo_bh,
										bm_bmt as realisasi_bm_bmt,
										bm_bmpm as realisasi_bm_bmpm,
										bm_bmgb as realisasi_bm_bmgb,
										bm_bmjji as realisasi_bm_bmjji,
										bm_bmatl as realisasi_bm_bmatl,
										btt as realisasi_btt,
										bt_bbh as realisasi_bt_bbh,
										bt_bbk as realisasi_bt_bbk
									FROM
										realisasi_keuangan 
									WHERE
										id_instansi = {$id_instansi} 
										AND kode_sub_kegiatan = '{$kode_rekening_sub_kegiatan}' 
										AND kode_tahap = '$tahap'
										AND tahun='$tahun'");
		return $query;
	}

	public function get_pagu($id_instansi, $kode_rekening_sub_kegiatan, $tahun, $tahap)
	{
		// $tahun 				= $this->input->get('tahun');
		// $tahap 				= $this->input->get('tahap');
		$query  = $this->db->query("SELECT

										(bo_bp + bo_bbj+ bo_bs+bo_bh + bm_bmt + bm_bmpm + bm_bmgb + bm_bmjji + bm_bmatl +btt +  bt_bbh+bt_bbk ) as total_pagu,
										bo_bp as pagu_bo_bp,
										bo_bbj as pagu_bo_bbj,
										bo_bs as pagu_bo_bs,
										bo_bh as pagu_bo_bh,
										bm_bmt as pagu_bm_bmt,
										bm_bmpm as pagu_bm_bmpm,
										bm_bmgb as pagu_bm_bmgb,
										bm_bmjji as pagu_bm_bmjji,
										bm_bmatl as pagu_bm_bmatl,
										btt as pagu_btt,
										bt_bbh as pagu_bt_bbh,
										bt_bbk as pagu_bt_bbk
									FROM
										anggaran_sub_kegiatan 
									WHERE
										id_instansi = {$id_instansi} 
										AND kode_sub_kegiatan = '{$kode_rekening_sub_kegiatan}' 
										AND kode_tahap = '$tahap'
										AND tahun='$tahun'");
		return $query;
	}




	public function get_total_paket($id_instansi, $kode_rekening_sub_kegiatan, $tahun, $tahap)
	{
		
		if ($tahap ==4) {
			$where = "AND status=1";
		}else{
			$where = "AND kode_tahap='$tahap'";

		}

		$query  = $this->db->query("SELECT
										id_paket_pekerjaan
									FROM
										paket_pekerjaan pp 
									WHERE
										pp.kode_rekening_sub_kegiatan = '{$kode_rekening_sub_kegiatan}'
										AND pp.id_instansi = {$id_instansi} and pp.tahun='$tahun'
										$where 
								");
		return $query;
	}


	public function get_total_paket_perjenis($id_instansi, $kode_rekening_sub_kegiatan, $jenis, $tahun, $tahap)
	{
		if ($tahap ==4) {
			$where = "AND pp.status=1";
		}else{
			$where = "AND pp.kode_tahap='$tahap'";

		}

		$query  = $this->db->query("SELECT
										id_paket_pekerjaan
									FROM
										paket_pekerjaan pp 
									WHERE
										pp.kode_rekening_sub_kegiatan = '{$kode_rekening_sub_kegiatan}'
										AND pp.id_instansi = {$id_instansi}
										AND pp.jenis_paket = '{$jenis}'
										AND pp.tahun='$tahun' 
										$where
								");
		return $query;
	}


	public function get_realisasi_fisik($id_instansi, $kode_rekening_sub_kegiatan, $jenis_paket, $tahun, $tahap, $bulan)
	{

				$query_akumulasi  = $this->db->query("SELECT
										rk.kode_rekening_sub_kegiatan,
										rk.bulan,
										SUM( rk.nilai ) AS total 
									FROM
										realisasi_fisik rk
										LEFT JOIN paket_pekerjaan pp ON rk.id_paket_pekerjaan = pp.id_paket_pekerjaan 
									WHERE
										rk.id_instansi = {$id_instansi} 
										AND rk.kode_rekening_sub_kegiatan = '$kode_rekening_sub_kegiatan' 
										AND pp.jenis_paket = '{$jenis_paket}' 
										AND rk.bulan <= {$bulan}
										AND rk.tahun='$tahun'")->row_array();
										
				$query_bulanan  = $this->db->query("SELECT
						rk.kode_rekening_sub_kegiatan,
						rk.bulan,
						SUM( rk.nilai ) AS total 
					FROM
						realisasi_fisik rk
						LEFT JOIN paket_pekerjaan pp ON rk.id_paket_pekerjaan = pp.id_paket_pekerjaan 
					WHERE
						rk.id_instansi = {$id_instansi} 
						AND rk.kode_rekening_sub_kegiatan = '$kode_rekening_sub_kegiatan' 
						AND pp.jenis_paket = '{$jenis_paket}' 
						AND rk.bulan = {$bulan}
						AND rk.tahun='$tahun'")->row_array();


		$realisasi = [
			'bulan'=> $bulan,
			'akumulasi'=> $query_akumulasi['total'] == '' ? 0 : $query_akumulasi['total'],
			'bulanan'=> $query_bulanan['total'] == '' ? 0 :  $query_bulanan['total'],

		];
		return $realisasi;
	}

	
}
