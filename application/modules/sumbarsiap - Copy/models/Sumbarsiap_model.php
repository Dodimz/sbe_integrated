<?php

/**
 * Author     : Alfikri, M.Kom
 * Created By : Alfikri, M.Kom
 * E-Mail     : alfikri.name@gmail.com
 * No HP      : 081277337405
 * Class      : Auth_model.php
 */
defined('BASEPATH') or exit('No direct script access allowed');

class Sumbarsiap_model extends CI_Model
{
	
	public function menu()
	{	
		$q = $this->db->get("sumbarsiap_menu");
		return $q;
	}
	public function config()
	{	
		$q = $this->db->get("config");
		return $q;
	}
	public function skpd()
	{	
		$q = $this->db->get_where("master_instansi", ['is_active'=>1, 'kategori'=>'OPD']);
		return $q;
	}
	public function kab_kota()
	{	
		$q = $this->db->query("SELECT ckk.*, k.nama_kota from config_kab_kota ckk left join kota k on ckk.id_kota = k.id_kota");
		return $q;
	}
	public function pagu_skpd($id_instansi, $tahap, $tahun)
	{	
		$q = $this->db->query("SELECT 
			sum(bo_bp + bo_bbj+ bo_bs+bo_bh) as total_pagu_bo,
			sum(bm_bmt + bm_bmpm + bm_bmgb + bm_bmjji + bm_bmatl) as total_pagu_bm,
			sum(btt) as total_pagu_btt,
			sum(bt_bbh+bt_bbk ) as total_pagu_bt,
			sum(bo_bp + bo_bbj+ bo_bs+bo_bh + bm_bmt + bm_bmpm + bm_bmgb + bm_bmjji + bm_bmatl +btt +  bt_bbh+bt_bbk ) as total_pagu
			 from anggaran_sub_kegiatan where id_instansi='$id_instansi' and kode_tahap='$tahap' and tahun='$tahun'
			");
		return $q;
	}
	public function pagu_kab_kota($id_kota, $tahap, $tahun)
	{	
		$q = $this->db->query("SELECT 
			sum(bo_bp + bo_bbj+ bo_bs+bo_bh + bm_bmt + bm_bmpm + bm_bmgb + bm_bmjji + bm_bmatl +btt +  bt_bbh+bt_bbk ) as total_pagu from anggaran_instansi_kab_kota where id_kota='$id_kota' and kode_tahap='$tahap' and tahun='$tahun'
			");
		return $q;
	}
	public function realisasi_skpd($id_instansi, $tahap, $tahun, $bulan, $kategori)
	{	
		if ($kategori=='akumulasi') {
			$operator = '<=';
		}else{
			$operator = '=';

		}
		$q = $this->db->query("SELECT 
			sum(bo_bp + bo_bbj+ bo_bs+bo_bh) as total_realisasi_bo,
			sum(bm_bmt + bm_bmpm + bm_bmgb + bm_bmjji + bm_bmatl) as total_realisasi_bm,
			sum(btt) as total_realisasi_btt,
			sum(bt_bbh+bt_bbk ) as total_realisasi_bt,
			sum(bo_bp + bo_bbj+ bo_bs+bo_bh + bm_bmt + bm_bmpm + bm_bmgb + bm_bmjji + bm_bmatl +btt +  bt_bbh+bt_bbk ) as total_realisasi
			from  realisasi_keuangan where id_instansi='$id_instansi' and kode_tahap='$tahap' and tahun='$tahun'
			and bulan $operator $bulan
			");
		return $q;
	}
	public function realisasi_kab_kota($id_kota, $tahap, $tahun)
	{	
		$q = $this->db->query("SELECT 
			sum(bo_bp + bo_bbj+ bo_bs+bo_bh + bm_bmt + bm_bmpm + bm_bmgb + bm_bmjji + bm_bmatl +btt +  bt_bbh+bt_bbk ) as total_realisasi from realisasi_fisik_keuangan_kab_kota where id_kota='$id_kota' and kode_tahap='$tahap' and tahun='$tahun'
			");
		return $q;
	}
	public function gis($id_instansi, $tahap, $tahun)
	{	
		$q = $this->db->query("SELECT kp.*, pp.nama_paket from kontrak_pekerjaan kp
			left join paket_pekerjaan pp on kp.id_paket_pekerjaan = pp.id_paket_pekerjaan
			where kp.id_instansi='$id_instansi' and kp.tahun='$tahun'
			");
		return $q;
	}



	public function pagu_kab_kota_replikasi($tahap, $tahun)
	{	
		$q = $this->db->query("SELECT 
			sum(bo_bp + bo_bbj+ bo_bs+bo_bh + bm_bmt + bm_bmpm + bm_bmgb + bm_bmjji + bm_bmatl +btt +  bt_bbh+bt_bbk ) as total_pagu from anggaran_sub_kegiatan where kode_tahap='$tahap' and tahun='$tahun'
			");
		return $q;
	}

	public function realisasi_kab_kota_replikasi($tahap, $tahun)
	{	
		$q = $this->db->query("SELECT 
			sum(bo_bp + bo_bbj+ bo_bs+bo_bh + bm_bmt + bm_bmpm + bm_bmgb + bm_bmjji + bm_bmatl +btt +  bt_bbh+bt_bbk ) as total_realisasi from realisasi_keuangan where kode_tahap='$tahap' and tahun='$tahun'
			");
		return $q;
	}

}
