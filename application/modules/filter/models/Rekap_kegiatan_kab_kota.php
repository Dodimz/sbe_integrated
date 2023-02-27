<?php

/**
 * Author     : Alfikri, M.Kom
 * Created By : Alfikri, M.Kom
 * E-Mail     : alfikri.name@gmail.com
 * No HP      : 081277337405
 * Class      : Realisasi_akumulasi_model.php
 */
defined('BASEPATH') or exit('No direct script access allowed');

class Rekap_kegiatan_kab_kota extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
	}

	public function provinsi($id_provinsi)
	{
		$data = ['id_provinsi'=>$id_provinsi];
		return $this->db->get_where('provinsi', $data)->row();
	}

	public function kab_kota($id_kota)
	{
		$q = $this->db->query("SELECT k.nama_kota, p.nama_provinsi
		 from kota k  
		 left join provinsi p  on k.id_provinsi = p.id_provinsi
			where k.id_kota = '$id_kota'
			");
		
		return $q->row();
	}
	public function lokasi_per_skpd($id_kota)
	{
		$q = $this->db->query("SELECT lpp.id_kab_kota, mi.nama_instansi, lpp.id_instansi
		 from lokasi_paket_pekerjaan lpp
			left join master_instansi mi on lpp.id_instansi = mi.id_instansi
			where lpp.id_kab_kota = '$id_kota'
			group by lpp.id_instansi
			order by mi.nama_instansi
			");
		
		return $q->result();
	}

	public function get_pagu_opd($id_instansi)
	{
		$tahap = tahapan_apbd();
		$query  = $this->db->query("SELECT
																	ka.id_instansi,
																	SUM( ka.pagu ) AS pagu
																FROM
																	kegiatan_apbd ka 
																WHERE
																	ka.id_instansi = '{$id_instansi}'
																	AND ka.kode_tahap = '{$tahap}'
																GROUP BY
																	ka.id_instansi");
		return $query;
	}

	public function get_program($id_instansi)
	{
		return $this->db->get_where('v_program_apbd', [
			'id_instansi' => $id_instansi,
			'kode_tahap' => tahapan_apbd()
		]);
	}

	public function get_kegiatan($id_instansi, $kode_rekening_program, $kode_bidang_urusan)
	{	$tahap = tahapan_apbd();
		// return $this->db->query("SELECT * from v_kegiatan_apbd where  id_instansi ='$id_instansi'
		// 	and kode_tahap = '$tahap' 
		// 	and kode_rekening_program = '$kode_rekening_program'
		// 	and kode_urusan = '$kode_urusan'
		// 	and pagu >0");
		return $this->db->get_where('v_kegiatan_apbd', [
			'id_instansi' => $id_instansi,
			'kode_tahap' => tahapan_apbd(),
			'kode_rekening_program' => $kode_rekening_program,
			'kode_bidang_urusan' => $kode_bidang_urusan
		]);
	}
	public function get_sub_kegiatan($id_instansi, $kode_rekening_kegiatan, $kode_rekening_program, $kode_bidang_urusan)
	{	$tahap = tahapan_apbd();
		// return $this->db->query("SELECT * from v_kegiatan_apbd where  id_instansi ='$id_instansi'
		// 	and kode_tahap = '$tahap' 
		// 	and kode_rekening_program = '$kode_rekening_program'
		// 	and kode_urusan = '$kode_urusan'
		// 	and pagu >0");
		return $this->db->get_where('v_sub_kegiatan_apbd', [
			'id_instansi' => $id_instansi,
			'kode_tahap' => tahapan_apbd(),
			'kode_rekening_kegiatan' => $kode_rekening_kegiatan,
			'kode_rekening_program' => $kode_rekening_program,
			'kode_bidang_urusan' => $kode_bidang_urusan
		]);
	}

	public function get_sumber_dana($id_instansi, $kode_rekening_sub_kegiatan, $kode_rekening_kegiatan, $kode_rekening_program, $kode_bidang_urusan)
	{
		return $this->db->get_where('sumber_dana', [
			'id_instansi' => $id_instansi,
			'kode_tahap' => tahapan_apbd(),
			'kode_rekening_sub_kegiatan' => $kode_rekening_sub_kegiatan,
			'kode_rekening_kegiatan' => $kode_rekening_kegiatan,
			'kode_rekening_program' => $kode_rekening_program,
			'kode_bidang_urusan' => $kode_bidang_urusan
		]);
	}

	public function get_target($id_instansi, $kode_rekening_sub_kegiatan, $bulan)
	{
		return $this->db->get_where('target_apbd', [
			'id_instansi' => $id_instansi,
			'kode_tahap' => tahapan_apbd(),
			'kode_rekening_sub_kegiatan' => $kode_rekening_sub_kegiatan,
			'bulan' => $bulan
		]);
	}

	public function get_realisasi_keuangan($id_instansi, $kode_rekening_sub_kegiatan, $bulan, $ope)
	{
		$query  = $this->db->query("SELECT
										sum(bo_bp + bo_bbj+ bo_bs+bo_bh + bm_bmt + bm_bmpm + bm_bmgb + bm_bmjji + bm_bmatl +btt +  bt_bbh+bt_bbk ) as total_realisasi
									FROM
										realisasi_keuangan 
									WHERE
										id_instansi = {$id_instansi} 
										AND kode_sub_kegiatan = '{$kode_rekening_sub_kegiatan}' 
										AND bulan {$ope} {$bulan}");
		return $query;
	}

	public function get_realisasi_fisik($id_instansi, $kode_rekening_sub_kegiatan, $bulan, $jenis_paket, $ope)
	{
		$query  = $this->db->query("SELECT
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
										AND rk.bulan {$ope} {$bulan}");
		return $query;
	}

	public function get_total_paket($id_instansi, $kode_rekening_sub_kegiatan)
	{
		$query  = $this->db->query("SELECT
										id_paket_pekerjaan
									FROM
										paket_pekerjaan pp 
									WHERE
										pp.kode_rekening_sub_kegiatan = '{$kode_rekening_sub_kegiatan}'
										AND pp.id_instansi = {$id_instansi}
								");
		return $query;
	}
	public function get_total_paket_perjenis($id_instansi, $kode_rekening_sub_kegiatan, $jenis)
	{
		$query  = $this->db->query("SELECT
										id_paket_pekerjaan
									FROM
										paket_pekerjaan pp 
									WHERE
										pp.kode_rekening_sub_kegiatan = '{$kode_rekening_sub_kegiatan}'
										AND pp.id_instansi = {$id_instansi}
										AND pp.jenis_paket = '{$jenis}'
								");
		return $query;
	}


	public function jumlah_kegiatan($id_instansi)
	{
		$tahap  = tahapan_apbd();
		return $this->db->query("SELECT total_kegiatan($id_instansi, $tahap) as total_kegiatan")->row()->total_kegiatan;
	}


}
