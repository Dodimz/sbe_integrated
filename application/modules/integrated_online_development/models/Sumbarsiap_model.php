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
	public function skpd($skpd_tak_bergrafik, $keyword)
	{	
		$where_nama_skpd = $keyword=="" ? "" : "and nama_instansi like '%$keyword%'";
		$where = $skpd_tak_bergrafik=='' ? "" : "and id_instansi not in ($skpd_tak_bergrafik)";
		$q = $this->db->query("
			SELECT * from master_instansi where 
			is_active=1 and kategori= 'OPD'
			$where
			$where_nama_skpd
			");
		return $q;
	}
	public function kab_kota()
	{	
		$q = $this->db->query("SELECT ckk.*, k.nama_kota from config_kab_kota ckk left join kota k on ckk.id_kota = k.id_kota");
		return $q;
	}
	public function detail_kab_kota($id_kota)
	{	
		$q = $this->db->query("SELECT ckk.*, k.nama_kota from config_kab_kota ckk left join kota k on ckk.id_kota = k.id_kota where ckk.id_kota='$id_kota'");
		return $q;
	}
	public function detail_skpd_kab_kota($id_instansi)
	{	
		$q = $this->db->query("SELECT mi.*, ckk.logo, k.nama_kota from 
			master_instansi_kab_kota mi 
			left join config_kab_kota ckk on mi.id_kota = ckk.id_kota
			left join kota k on ckk.id_kota = k.id_kota where mi.id_instansi='$id_instansi'");
		return $q;
	}
	public function skpd_kab_kota($id_kota)
	{	
		$q = $this->db->query("SELECT * from master_instansi_kab_kota where id_kota='$id_kota'");
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
	public function pagu_skpd_kab_kota($id_instansi, $tahun, $tahap)
	{	
		$q = $this->db->query("SELECT 
			sum(bo_bp + bo_bbj+ bo_bs+bo_bh + bm_bmt + bm_bmpm + bm_bmgb + bm_bmjji + bm_bmatl + bm_bmatb +btt +  bt_bbh+bt_bbk ) as total_pagu from anggaran_instansi_kab_kota where id_instansi='$id_instansi' and kode_tahap='$tahap' and tahun='$tahun'
			");
		return $q;
	}
	public function realisasi_skpd_kab_kota($id_instansi, $tahun, $tahap, $bulan)
	{	
		$q = $this->db->query("SELECT 
			sum(bo_bp + bo_bbj+ bo_bs+bo_bh + bo_bbs + bm_bmt + bm_bmpm + bm_bmgb + bm_bmjji + bm_bmatl + bm_bmatb +btt +  bt_bbh+bt_bbk ) as total_realisasi, sum(rf_total) as realisasi_fisik from realisasi_fisik_keuangan_kab_kota where id_instansi='$id_instansi' and kode_tahap='$tahap' and tahun='$tahun' and bulan <=$bulan
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

	public function realisasi_kab_kota_replikasi($tahap, $tahun, $bulan)
	{	
		$q = $this->db->query("SELECT 
			sum(bo_bp + bo_bbj+ bo_bs+bo_bh + bm_bmt + bm_bmpm + bm_bmgb + bm_bmjji + bm_bmatl +btt +  bt_bbh+bt_bbk ) as total_realisasi from realisasi_keuangan where kode_tahap='$tahap' and tahun='$tahun' and bulan <=$bulan
			");
		return $q;
	}




public function gis_gabungan($id_kota, $keyword, $tahun )
	{	
		if ($id_kota=='') {
			if ($keyword=='') {
				$where = "";
			}else{
				$where = "and pp.nama_paket like '%$keyword%' or msk.nama_sub_kegiatan like '%$keyword%'";
			}
		}else{
			if ($keyword=='') {
				$where = "and kp.id_kota='$id_kota'";
			}else{
				$where = "and (pp.nama_paket like '%$keyword%' or msk.nama_sub_kegiatan like '%$keyword%') and kp.id_kota='$id_kota'";
			}
		}
		
		$q = $this->db->query("SELECT DISTINCT kp.id_paket_pekerjaan,
			kp.latitude, kp.longitude, kp.id_paket_pekerjaan, 
			pp.nama_paket,
			ski.kategori, ski.jenis_sub_kegiatan, ski.keterangan, ski.kode_sub_kegiatan,
			
			 msk.nama_sub_kegiatan, 
			 mu.full_name as pptk,
			  mi.nama_instansi, mi.id_instansi
			from kontrak_pekerjaan kp
			left join paket_pekerjaan pp on kp.id_paket_pekerjaan = pp.id_paket_pekerjaan
			left join sub_kegiatan_instansi ski on pp.kode_rekening_sub_kegiatan = ski.kode_sub_kegiatan and pp.id_instansi = ski.id_instansi
			left join master_sub_kegiatan msk on substr(pp.kode_rekening_sub_kegiatan,1,15) = msk.kode_sub_kegiatan
			left join master_users mu on pp.id_pptk = mu.id_user
			left join master_instansi mi on kp.id_instansi = mi.id_instansi
			where kp.tahun='$tahun'
			$where

			");
		return $q;
	}

public function gis_skpd_provinsi($id_instansi, $id_kota, $keyword, $tahun )
	{	
		if ($id_kota=='') {
			if ($keyword=='') {
				$where = "";
			}else{
				$where = "and pp.nama_paket like '%$keyword%' or msk.nama_sub_kegiatan like '%$keyword%'";
			}
		}else{
			if ($keyword=='') {
				$where = "and kp.id_kota='$id_kota'";
			}else{
				$where = "and (pp.nama_paket like '%$keyword%' or msk.nama_sub_kegiatan like '%$keyword%') and kp.id_kota='$id_kota'";
			}
		}
		
		$q = $this->db->query("SELECT DISTINCT kp.id_paket_pekerjaan,
			kp.latitude, kp.longitude, kp.id_paket_pekerjaan, 
			pp.nama_paket,
			ski.kategori, ski.jenis_sub_kegiatan, ski.keterangan, ski.kode_sub_kegiatan,
			
			 msk.nama_sub_kegiatan, 
			 mu.full_name as pptk,
			  mi.nama_instansi, mi.id_instansi
			from kontrak_pekerjaan kp
			left join paket_pekerjaan pp on kp.id_paket_pekerjaan = pp.id_paket_pekerjaan
			left join sub_kegiatan_instansi ski on pp.kode_rekening_sub_kegiatan = ski.kode_sub_kegiatan and pp.id_instansi = ski.id_instansi
			left join master_sub_kegiatan msk on substr(pp.kode_rekening_sub_kegiatan,1,15) = msk.kode_sub_kegiatan
			left join master_users mu on pp.id_pptk = mu.id_user
			left join master_instansi mi on kp.id_instansi = mi.id_instansi
			where kp.tahun='$tahun' and kp.id_instansi='$id_instansi'
			$where

			");
		return $q;
	}
public function paket_pekerjaan_sub_kegiatan($id_instansi, $tahun, $kode_sub_kegiatan)	{	
		$q = $this->db->query("SELECT 
			 id_paket_pekerjaan, id_instansi, nama_paket, jenis_paket, metode, volume, pagu, nilai,  latitude, longitude 
		 from v_paket pp where pp.kode_rekening_sub_kegiatan='$kode_sub_kegiatan' and pp.tahun='$tahun' and pp.id_instansi='$id_instansi'
			");
		return $q;
	}


    public function realisasi_keuangan_sub_kegiatan($id_instansi, $tahun, $tahap, $kode_sub_kegiatan, $bulan)
    {
 
        $query  = $this->db->query("SELECT
sum(bo_bp + bo_bbj+ bo_bs+bo_bh) as realisasi_bo,
sum( bm_bmt + bm_bmpm + bm_bmgb + bm_bmjji + bm_bmatl ) as realisasi_bm,
sum(btt) as realisasi_btt,
 sum( bt_bbh+bt_bbk ) as realisasi_bt,


 sum(bo_bp + bo_bbj+ bo_bs+bo_bh + bm_bmt + bm_bmpm + bm_bmgb + bm_bmjji + bm_bmatl +btt +  bt_bbh+bt_bbk ) as total
                                      
                                    FROM
                                        realisasi_keuangan 
                                    WHERE
                                        id_instansi = $id_instansi 
                                        and kode_tahap = '$tahap'
                                        AND bulan <= {$bulan} and tahun = '$tahun' and kode_sub_kegiatan='$kode_sub_kegiatan'");
        return $query;
    }


public function detail_paket_pekerjaan($id_paket_pekerjaan)
	{	
		
		$q = $this->db->query("SELECT 
			kp.latitude, kp.longitude, kp.id_paket_pekerjaan, kp.nilai_kontrak, kp.pelaksana, k.nama_kota,
			pp.nama_paket,  pp.id_instansi, pp.jenis_paket, pp.pagu,
			(select count(id_paket_pekerjaan) from vol_pelaksanaan_pekerjaan where id_paket_pekerjaan = pp.id_paket_pekerjaan) as banyak_pelaksanaan,
			m.metode,
			ski.kategori, ski.jenis_sub_kegiatan, ski.keterangan, ski.kode_sub_kegiatan,
			
			 msk.nama_sub_kegiatan, 
			 mu.full_name as pptk,
			  mi.nama_instansi
			from kontrak_pekerjaan kp
			left join paket_pekerjaan pp on kp.id_paket_pekerjaan = pp.id_paket_pekerjaan
			left join metode m on pp.id_metode = m.id_metode
			left join kota k on kp.id_kota = k.id_kota
			left join sub_kegiatan_instansi ski on pp.kode_rekening_sub_kegiatan = ski.kode_sub_kegiatan and pp.id_instansi = ski.id_instansi
			left join master_sub_kegiatan msk on substr(pp.kode_rekening_sub_kegiatan,1,15) = msk.kode_sub_kegiatan
			left join master_users mu on pp.id_pptk = mu.id_user
			left join master_instansi mi on kp.id_instansi = mi.id_instansi
			where kp.id_paket_pekerjaan='$id_paket_pekerjaan'
			

			");
		return $q;
	}
public function progress_pekerjaan($id_paket_pekerjaan)
	{	
		
		$q = $this->db->query("SELECT * from progress_pekerjaan 
			where id_paket_pekerjaan='$id_paket_pekerjaan'
			

			");
		return $q;
	}
}
