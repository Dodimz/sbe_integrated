<?php

/**
 * Author     : Alfikri, M.Kom
 * Created By : Alfikri, M.Kom
 * E-Mail     : alfikri.name@gmail.com
 * No HP      : 081277337405
 * Class      : Dashboard_model.php
 */
defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard_model extends CI_Model
{
	private $table_master_users 	= 'master_users';
	private $table_master_modules 	= 'master_modules';

	public function total_users()
	{
		return $this->db->count_all($this->table_master_users);
	}

	public function total_modules()
	{
		return $this->db->count_all($this->table_master_modules);
	}



	public function i_frame_gmaps()
	{
		$id_instansi = id_instansi();
		return $this->db->query("SELECT i_frame_maps from master_instansi where id_instansi = '$id_instansi'")->row();
	}
	public function detail_user($id_user)
	{
		$id_instansi = id_instansi();
		return $this->db->query("SELECT mu.full_name, mu.email, mu.nohp, mu.is_active, mi.nama_instansi from master_users mu
			left join master_instansi mi on mu.id_instansi = mi.id_instansi
			where mu.id_instansi = '$id_instansi' and mu.id_user='$id_user'");
	}
	public function get_grafik_total_akumulasi($tahun_anggaran, $tahap)
	{
		
		$instansi_aktiv = $this->db->query("SELECT id_instansi from master_instansi where is_active=1 and kategori='OPD'")->num_rows();
		$query = $this->db->query("SELECT
																g.bulan AS bulan,
																round(( sum( g.target_fisik_akumulasi ) / $instansi_aktiv ), 2 ) AS target_fisik,
																round(( sum( g.realisasi_fisik_akumulasi ) / $instansi_aktiv ), 2 ) AS realisasi_fisik,
																(sum(g.rp_target_keuangan_akumulasi) / sum(g.pagu_total)  * 100)  AS target_keuangan,
																(sum(g.rp_realisasi_keuangan_akumulasi) / sum(g.pagu_total)  * 100)  AS realisasi_keuangan 
															FROM
																grafik g 
                                                                left join master_instansi mi 
                                                                on g.id_instansi=mi.id_instansi
                                                                where mi.is_active=1 and g.tahun='$tahun_anggaran'and g.kode_tahap='$tahap'
															GROUP BY
																g.bulan");
		return $query;
	}
	public function get_grafik_total_bulanan($tahun_anggaran, $tahap)
	{
		
		$instansi_aktiv = $this->db->query("SELECT id_instansi from master_instansi where is_active=1 and kategori='OPD'")->num_rows();
		$query = $this->db->query("SELECT
																g.bulan AS bulan,
																( sum( g.target_fisik_akumulasi ) / $instansi_aktiv ) AS target_fisik,
																( sum( g.realisasi_fisik_akumulasi ) / $instansi_aktiv ) AS realisasi_fisik,
																(sum(g.rp_target_keuangan_bulanan) / sum(g.pagu_total)  * 100)  AS target_keuangan,
																(sum(g.rp_realisasi_keuangan_bulanan) / sum(g.pagu_total)  * 100)  AS realisasi_keuangan 
															FROM
																grafik g 
                                                                left join master_instansi mi 
                                                                on g.id_instansi=mi.id_instansi
                                                                where mi.is_active=1 and g.tahun='$tahun_anggaran'and g.kode_tahap='$tahap'
															GROUP BY
																g.bulan");
		return $query;
	}

	public function get_grafik_akumulasi($id_instansi, $tahun, $tahap)
	{
		$query  = $this->db->query("SELECT
											g.bulan AS bulan,
																g.target_fisik_akumulasi  AS target_fisik,
																g.realisasi_fisik_akumulasi  AS realisasi_fisik,
																g.target_keuangan_akumulasi AS target_keuangan,
																g.realisasi_keuangan_akumulasi AS realisasi_keuangan 
									FROM
										grafik g 
									WHERE 
										g.id_instansi = '{$id_instansi}' and tahun = '$tahun' and kode_tahap='$tahap'
									GROUP BY
										g.bulan");
		return $query;
	}



	public function get_grafik_bulanan($id_instansi, $tahun, $tahap)
	{
		$query  = $this->db->query("SELECT
		g.bulan AS bulan,
							g.target_fisik_bulanan  AS target_fisik,
							g.realisasi_fisik_bulanan  AS realisasi_fisik,
							g.target_keuangan_bulanan AS target_keuangan,
							g.realisasi_keuangan_bulanan AS realisasi_keuangan 
		FROM
			grafik g 
		WHERE 
			g.id_instansi = '{$id_instansi}' and tahun = '$tahun' and kode_tahap='$tahap'
		GROUP BY
			g.bulan");
		return $query;
	}






    public function pagu($id_instansi, $tahap, $tahun)
    {
        $bulan  = date('n');

        if ($tahap==2) {
        	
	        $query  = $this->db->query("SELECT
			sum(bo_bp) as pagu_bo_bp,
			sum(bo_bbj) as pagu_bo_bbj,
			sum(bo_bs) as pagu_bo_bs,
			sum(bo_bh) as pagu_bo_bh,
			sum(bo_bp + bo_bbj+ bo_bs+bo_bh) as pagu_bo,

			sum(bm_bmt) as pagu_bm_bmt,
			sum(bm_bmpm) as pagu_bm_bmpm,
			sum(bm_bmgb) as pagu_bm_bmgb,
			sum(bm_bmjji) as pagu_bm_bmjji,
			sum(bm_bmatl) as pagu_bm_bmatl,
			sum( bm_bmt + bm_bmpm + bm_bmgb + bm_bmjji + bm_bmatl ) as pagu_bm,

			sum(btt) as pagu_btt,


			sum(bt_bbh) as pagu_bt_bbh,
			sum(bt_bbk) as pagu_bt_bbk,
			sum( bt_bbh+bt_bbk ) as pagu_bt,


			sum(bo_bp + bo_bbj+ bo_bs+bo_bh + bm_bmt + bm_bmpm + bm_bmgb + bm_bmjji + bm_bmatl +btt +  bt_bbh+bt_bbk ) as total

			FROM
			anggaran_sub_kegiatan 
			WHERE
			id_instansi = '$id_instansi'
			and kode_tahap = '$tahap' and tahun='$tahun' and kode_sub_kegiatan in 
			(SELECT kode_sub_kegiatan from sub_kegiatan_instansi where id_instansi='$id_instansi' and kode_tahap='$tahap' and tahun='$tahun')
	          ");
	    }
	    else{
	        $query  = $this->db->query("SELECT
			sum(bo_bp) as pagu_bo_bp,
			sum(bo_bbj) as pagu_bo_bbj,
			sum(bo_bs) as pagu_bo_bs,
			sum(bo_bh) as pagu_bo_bh,
			sum(bo_bp + bo_bbj+ bo_bs+bo_bh) as pagu_bo,

			sum(bm_bmt) as pagu_bm_bmt,
			sum(bm_bmpm) as pagu_bm_bmpm,
			sum(bm_bmgb) as pagu_bm_bmgb,
			sum(bm_bmjji) as pagu_bm_bmjji,
			sum(bm_bmatl) as pagu_bm_bmatl,
			sum( bm_bmt + bm_bmpm + bm_bmgb + bm_bmjji + bm_bmatl ) as pagu_bm,

			sum(btt) as pagu_btt,


			sum(bt_bbh) as pagu_bt_bbh,
			sum(bt_bbk) as pagu_bt_bbk,
			sum( bt_bbh+bt_bbk ) as pagu_bt,


			sum(bo_bp + bo_bbj+ bo_bs+bo_bh + bm_bmt + bm_bmpm + bm_bmgb + bm_bmjji + bm_bmatl +btt +  bt_bbh+bt_bbk ) as total

			FROM
			anggaran_sub_kegiatan 
			WHERE
			id_instansi = '$id_instansi'
			and tahun='$tahun' and status =1 
	          ");

	    }
        return $query;
    }



    public function rk($id_instansi, $tahap)
    {
        $bulan  = bulan_aktif();
        $tahun = tahun_anggaran();

        if ($tahap==4) {
			$where = "WHERE ski.id_instansi = '{$id_instansi}'
									and ski.status = '1' and ski.tahun='$tahun'";
		}else{
			$where = "WHERE ski.id_instansi = '{$id_instansi}'
									and ski.kode_tahap = '{$tahap}' and ski.tahun='$tahun'";
			
		}
        $query  = $this->db->query("SELECT
sum(rk.bo_bp) as rk_bo_bp,
sum(rk.bo_bbj) as rk_bo_bbj,
sum(rk.bo_bs) as rk_bo_bs,
sum(rk.bo_bh) as rk_bo_bh,
sum(rk.bo_bp + rk.bo_bbj+ rk.bo_bs+rk.bo_bh) as rk_bo,

sum(rk.bm_bmt) as rk_bm_bmt,
sum(rk.bm_bmpm) as rk_bm_bmpm,
sum(rk.bm_bmgb) as rk_bm_bmgb,
sum(rk.bm_bmjji) as rk_bm_bmjji,
sum(rk.bm_bmatl) as rk_bm_bmatl,
sum( rk.bm_bmt + rk.bm_bmpm + rk.bm_bmgb + rk.bm_bmjji + rk.bm_bmatl ) as rk_bm,

sum(rk.btt) as rk_btt,


sum(rk.bt_bbh) as rk_bt_bbh,
sum(rk.bt_bbk) as rk_bt_bbk,
 sum( rk.bt_bbh+rk.bt_bbk ) as rk_bt,


 sum(rk.bo_bp + rk.bo_bbj+ rk.bo_bs+rk.bo_bh + rk.bm_bmt + rk.bm_bmpm + rk.bm_bmgb + rk.bm_bmjji + rk.bm_bmatl +rk.btt +  rk.bt_bbh+rk.bt_bbk ) as total
                                      
                                   from realisasi_keuangan rk 

left join sub_kegiatan_instansi ski on 
rk.kode_sub_kegiatan=ski.kode_sub_kegiatan and rk.id_instansi=ski.id_instansi and rk.kode_tahap = ski.kode_tahap and rk.tahun = ski.tahun

									$where
                                        ");
        return $query;
    }



    public function pagu_kab_kota($id_kota, $tahap)
    {
        $bulan  = date('n');
        $query  = $this->db->query("SELECT
sum(bo_bp + bo_bbj+ bo_bs+bo_bh + bo_bbs) as pagu_bo,
sum( bm_bmt + bm_bmpm + bm_bmgb + bm_bmjji + bm_bmatl + bm_bmatb ) as pagu_bm,
sum(btt) as pagu_btt,
 sum( bt_bbh+bt_bbk ) as pagu_bt,


 sum(bo_bp + bo_bbj+ bo_bs+bo_bh +bo_bbs + bm_bmt + bm_bmpm + bm_bmgb + bm_bmjji + bm_bmatl + bm_bmatb +btt +  bt_bbh+bt_bbk ) as total
                                      
                                    FROM
                                        anggaran_instansi_kab_kota 
                                    WHERE
                                        id_kota = '$id_kota'
                                        and kode_tahap = '$tahap'
                                        ");
        return $query;
    }


    public function pagu_total($tahap)
    {
    	$tahun = tahun_anggaran();
        $bulan  = date('n');
        $query  = $this->db->query("SELECT
sum(bo_bp) as pagu_bo_bp,
sum(bo_bbj) as pagu_bo_bbj,
sum(bo_bs) as pagu_bo_bs,
sum(bo_bh) as pagu_bo_bh,
sum(bo_bp + bo_bbj+ bo_bs+bo_bh) as pagu_bo,

sum(bm_bmt) as pagu_bm_bmt,
sum(bm_bmpm) as pagu_bm_bmpm,
sum(bm_bmgb) as pagu_bm_bmgb,
sum(bm_bmjji) as pagu_bm_bmjji,
sum(bm_bmatl) as pagu_bm_bmatl,
sum( bm_bmt + bm_bmpm + bm_bmgb + bm_bmjji + bm_bmatl ) as pagu_bm,

sum(btt) as pagu_btt,


sum(bt_bbh) as pagu_bt_bbh,
sum(bt_bbk) as pagu_bt_bbk,
 sum( bt_bbh+bt_bbk ) as pagu_bt,


 sum(bo_bp + bo_bbj+ bo_bs+bo_bh + bm_bmt + bm_bmpm + bm_bmgb + bm_bmjji + bm_bmatl +btt +  bt_bbh+bt_bbk ) as total
                                                          
                                    FROM
                                        anggaran_sub_kegiatan 
                                    WHERE
                                     kode_tahap = '$tahap' and tahun='$tahun'
                                        ");
        return $query;
    }




    public function rk_total($tahap)
    {
    	$tahun = tahun_anggaran();
        $bulan  = bulan_aktif();
        $query  = $this->db->query("SELECT
sum(bo_bp) as rk_bo_bp,
sum(bo_bbj) as rk_bo_bbj,
sum(bo_bs) as rk_bo_bs,
sum(bo_bh) as rk_bo_bh,
sum(bo_bp + bo_bbj+ bo_bs+bo_bh) as rk_bo,

sum(bm_bmt) as rk_bm_bmt,
sum(bm_bmpm) as rk_bm_bmpm,
sum(bm_bmgb) as rk_bm_bmgb,
sum(bm_bmjji) as rk_bm_bmjji,
sum(bm_bmatl) as rk_bm_bmatl,
sum( bm_bmt + bm_bmpm + bm_bmgb + bm_bmjji + bm_bmatl ) as rk_bm,

sum(btt) as rk_btt,


sum(bt_bbh) as rk_bt_bbh,
sum(bt_bbk) as rk_bt_bbk,
 sum( bt_bbh+bt_bbk ) as rk_bt,


 sum(bo_bp + bo_bbj+ bo_bs+bo_bh + bm_bmt + bm_bmpm + bm_bmgb + bm_bmjji + bm_bmatl +btt +  bt_bbh+bt_bbk ) as total
                                      
                                    FROM
                                        realisasi_keuangan 
                                    WHERE kode_tahap = '$tahap'
                                        and bulan <= '$bulan' and tahun='$tahun'
                                        ");
        return $query;
    }


}
