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
	public function get_grafik_total()
	{
		$tahun_anggaran = tahun_anggaran();
		$tahap = tahapan_apbd();
		$instansi_aktiv = $this->db->query("SELECT id_instansi from master_instansi where is_active=1 and kategori='OPD'")->num_rows();
		$query = $this->db->query("SELECT
																g.bulan AS bulan,
																round(( sum( g.target_fisik_akumulasi ) / $instansi_aktiv ), 2 ) AS target_fisik,
																round(( sum( g.target_keuangan_akumulasi ) / $instansi_aktiv ), 2 ) AS target_keuangan,
																round(( sum( g.realisasi_fisik_akumulasi ) / $instansi_aktiv ), 2 ) AS realisasi_fisik,
																round(( sum( g.realisasi_keuangan_akumulasi ) / $instansi_aktiv ), 2 ) AS realisasi_keuangan 
															FROM
																grafik g 
                                                                left join master_instansi mi 
                                                                on g.id_instansi=mi.id_instansi
                                                                where mi.is_active=1 and g.tahun='$tahun_anggaran'and g.kode_tahap='$tahap'
															GROUP BY
																g.bulan");
		return $query;
	}

	public function get_grafik_akumulasi($id_instansi)
	{
		$tahun = tahun_anggaran();
		$query  = $this->db->query("SELECT
										sum(IF(( g.bulan = 1 ), g.target_fisik_akumulasi, 0 )) AS tf_jan,
										sum(IF(( g.bulan = 1 ), g.target_keuangan_akumulasi, 0 )) AS tk_jan,
										sum(IF(( g.bulan = 1 ), g.realisasi_fisik_akumulasi, 0 )) AS rf_jan,
										sum(IF(( g.bulan = 1 ), g.realisasi_keuangan_akumulasi, 0 )) AS rk_jan,
										sum(IF(( g.bulan = 2 ), g.target_fisik_akumulasi, 0 )) AS tf_feb,
										sum(IF(( g.bulan = 2 ), g.target_keuangan_akumulasi, 0 )) AS tk_feb,
										sum(IF(( g.bulan = 2 ), g.realisasi_fisik_akumulasi, 0 )) AS rf_feb,
										sum(IF(( g.bulan = 2 ), g.realisasi_keuangan_akumulasi, 0 )) AS rk_feb,
										sum(IF(( g.bulan = 3 ), g.target_fisik_akumulasi, 0 )) AS tf_mar,
										sum(IF(( g.bulan = 3 ), g.target_keuangan_akumulasi, 0 )) AS tk_mar,
										sum(IF(( g.bulan = 3 ), g.realisasi_fisik_akumulasi, 0 )) AS rf_mar,
										sum(IF(( g.bulan = 3 ), g.realisasi_keuangan_akumulasi, 0 )) AS rk_mar,
										sum(IF(( g.bulan = 4 ), g.target_fisik_akumulasi, 0 )) AS tf_apr,
										sum(IF(( g.bulan = 4 ), g.target_keuangan_akumulasi, 0 )) AS tk_apr,
										sum(IF(( g.bulan = 4 ), g.realisasi_fisik_akumulasi, 0 )) AS rf_apr,
										sum(IF(( g.bulan = 4 ), g.realisasi_keuangan_akumulasi, 0 )) AS rk_apr,
										sum(IF(( g.bulan = 5 ), g.target_fisik_akumulasi, 0 )) AS tf_mei,
										sum(IF(( g.bulan = 5 ), g.target_keuangan_akumulasi, 0 )) AS tk_mei,
										sum(IF(( g.bulan = 5 ), g.realisasi_fisik_akumulasi, 0 )) AS rf_mei,
										sum(IF(( g.bulan = 5 ), g.realisasi_keuangan_akumulasi, 0 )) AS rk_mei,
										sum(IF(( g.bulan = 6 ), g.target_fisik_akumulasi, 0 )) AS tf_jun,
										sum(IF(( g.bulan = 6 ), g.target_keuangan_akumulasi, 0 )) AS tk_jun,
										sum(IF(( g.bulan = 6 ), g.realisasi_fisik_akumulasi, 0 )) AS rf_jun,
										sum(IF(( g.bulan = 6 ), g.realisasi_keuangan_akumulasi, 0 )) AS rk_jun,
										sum(IF(( g.bulan = 7 ), g.target_fisik_akumulasi, 0 )) AS tf_jul,
										sum(IF(( g.bulan = 7 ), g.target_keuangan_akumulasi, 0 )) AS tk_jul,
										sum(IF(( g.bulan = 7 ), g.realisasi_fisik_akumulasi, 0 )) AS rf_jul,
										sum(IF(( g.bulan = 7 ), g.realisasi_keuangan_akumulasi, 0 )) AS rk_jul,
										sum(IF(( g.bulan = 8 ), g.target_fisik_akumulasi, 0 )) AS tf_agu,
										sum(IF(( g.bulan = 8 ), g.target_keuangan_akumulasi, 0 )) AS tk_agu,
										sum(IF(( g.bulan = 8 ), g.realisasi_fisik_akumulasi, 0 )) AS rf_agu,
										sum(IF(( g.bulan = 8 ), g.realisasi_keuangan_akumulasi, 0 )) AS rk_agu,
										sum(IF(( g.bulan = 9 ), g.target_fisik_akumulasi, 0 )) AS tf_sep,
										sum(IF(( g.bulan = 9 ), g.target_keuangan_akumulasi, 0 )) AS tk_sep,
										sum(IF(( g.bulan = 9 ), g.realisasi_fisik_akumulasi, 0 )) AS rf_sep,
										sum(IF(( g.bulan = 9 ), g.realisasi_keuangan_akumulasi, 0 )) AS rk_sep,
										sum(IF(( g.bulan = 10 ), g.target_fisik_akumulasi, 0 )) AS tf_okt,
										sum(IF(( g.bulan = 10 ), g.target_keuangan_akumulasi, 0 )) AS tk_okt,
										sum(IF(( g.bulan = 10 ), g.realisasi_fisik_akumulasi, 0 )) AS rf_okt,
										sum(IF(( g.bulan = 10 ), g.realisasi_keuangan_akumulasi, 0 )) AS rk_okt,
										sum(IF(( g.bulan = 11 ), g.target_fisik_akumulasi, 0 )) AS tf_nov,
										sum(IF(( g.bulan = 11 ), g.target_keuangan_akumulasi, 0 )) AS tk_nov,
										sum(IF(( g.bulan = 11 ), g.realisasi_fisik_akumulasi, 0 )) AS rf_nov,
										sum(IF(( g.bulan = 11 ), g.realisasi_keuangan_akumulasi, 0 )) AS rk_nov,
										sum(IF(( g.bulan = 12 ), g.target_fisik_akumulasi, 0 )) AS tf_des,
										sum(IF(( g.bulan = 12 ), g.target_keuangan_akumulasi, 0 )) AS tk_des,
										sum(IF(( g.bulan = 12 ), g.realisasi_fisik_akumulasi, 0 )) AS rf_des,
										sum(IF(( g.bulan = 12 ), g.realisasi_keuangan_akumulasi, 0 )) AS rk_des 
									FROM
										grafik g
									WHERE 
										g.id_instansi = '{$id_instansi}' and tahun = '$tahun'
									GROUP BY
										g.id_instansi");
		return $query;
	}



	public function get_grafik_bulanan($id_instansi)
	{
		$tahun = tahun_anggaran();
		$query  = $this->db->query("SELECT
										sum(IF(( g.bulan = 1 ), g.target_fisik_bulanan, 0 )) AS tf_jan,
										sum(IF(( g.bulan = 1 ), g.target_keuangan_bulanan, 0 )) AS tk_jan,
										sum(IF(( g.bulan = 1 ), g.realisasi_fisik_bulanan, 0 )) AS rf_jan,
										sum(IF(( g.bulan = 1 ), g.realisasi_keuangan_bulanan, 0 )) AS rk_jan,

										sum(IF(( g.bulan = 2 ), g.target_fisik_bulanan, 0 )) AS tf_feb,
										sum(IF(( g.bulan = 2 ), g.target_keuangan_bulanan, 0 )) AS tk_feb,
										sum(IF(( g.bulan = 2 ), g.realisasi_fisik_bulanan, 0 )) AS rf_feb,
										sum(IF(( g.bulan = 2 ), g.realisasi_keuangan_bulanan, 0 )) AS rk_feb,

										sum(IF(( g.bulan = 3 ), g.target_fisik_bulanan, 0 )) AS tf_mar,
										sum(IF(( g.bulan = 3 ), g.target_keuangan_bulanan, 0 )) AS tk_mar,
										sum(IF(( g.bulan = 3 ), g.realisasi_fisik_bulanan, 0 )) AS rf_mar,
										sum(IF(( g.bulan = 3 ), g.realisasi_keuangan_bulanan, 0 )) AS rk_mar,

										sum(IF(( g.bulan = 4 ), g.target_fisik_bulanan, 0 )) AS tf_apr,
										sum(IF(( g.bulan = 4 ), g.target_keuangan_bulanan, 0 )) AS tk_apr,
										sum(IF(( g.bulan = 4 ), g.realisasi_fisik_bulanan, 0 )) AS rf_apr,
										sum(IF(( g.bulan = 4 ), g.realisasi_keuangan_bulanan, 0 )) AS rk_apr,
										
										sum(IF(( g.bulan = 5 ), g.target_fisik_bulanan, 0 )) AS tf_mei,
										sum(IF(( g.bulan = 5 ), g.target_keuangan_bulanan, 0 )) AS tk_mei,
										sum(IF(( g.bulan = 5 ), g.realisasi_fisik_bulanan, 0 )) AS rf_mei,
										sum(IF(( g.bulan = 5 ), g.realisasi_keuangan_bulanan, 0 )) AS rk_mei,
										
										sum(IF(( g.bulan = 6 ), g.target_fisik_bulanan, 0 )) AS tf_jun,
										sum(IF(( g.bulan = 6 ), g.target_keuangan_bulanan, 0 )) AS tk_jun,
										sum(IF(( g.bulan = 6 ), g.realisasi_fisik_bulanan, 0 )) AS rf_jun,
										sum(IF(( g.bulan = 6 ), g.realisasi_keuangan_bulanan, 0 )) AS rk_jun,
										
										sum(IF(( g.bulan = 7 ), g.target_fisik_bulanan, 0 )) AS tf_jul,
										sum(IF(( g.bulan = 7 ), g.target_keuangan_bulanan, 0 )) AS tk_jul,
										sum(IF(( g.bulan = 7 ), g.realisasi_fisik_bulanan, 0 )) AS rf_jul,
										sum(IF(( g.bulan = 7 ), g.realisasi_keuangan_bulanan, 0 )) AS rk_jul,
										
										sum(IF(( g.bulan = 8 ), g.target_fisik_bulanan, 0 )) AS tf_agu,
										sum(IF(( g.bulan = 8 ), g.target_keuangan_bulanan, 0 )) AS tk_agu,
										sum(IF(( g.bulan = 8 ), g.realisasi_fisik_bulanan, 0 )) AS rf_agu,
										sum(IF(( g.bulan = 8 ), g.realisasi_keuangan_bulanan, 0 )) AS rk_agu,
										
										sum(IF(( g.bulan = 9 ), g.target_fisik_bulanan, 0 )) AS tf_sep,
										sum(IF(( g.bulan = 9 ), g.target_keuangan_bulanan, 0 )) AS tk_sep,
										sum(IF(( g.bulan = 9 ), g.realisasi_fisik_bulanan, 0 )) AS rf_sep,
										sum(IF(( g.bulan = 9 ), g.realisasi_keuangan_bulanan, 0 )) AS rk_sep,
										
										sum(IF(( g.bulan = 10 ), g.target_fisik_bulanan, 0 )) AS tf_okt,
										sum(IF(( g.bulan = 10 ), g.target_keuangan_bulanan, 0 )) AS tk_okt,
										sum(IF(( g.bulan = 10 ), g.realisasi_fisik_bulanan, 0 )) AS rf_okt,
										sum(IF(( g.bulan = 10 ), g.realisasi_keuangan_bulanan, 0 )) AS rk_okt,
										
										sum(IF(( g.bulan = 11 ), g.target_fisik_bulanan, 0 )) AS tf_nov,
										sum(IF(( g.bulan = 11 ), g.target_keuangan_bulanan, 0 )) AS tk_nov,
										sum(IF(( g.bulan = 11 ), g.realisasi_fisik_bulanan, 0 )) AS rf_nov,
										sum(IF(( g.bulan = 11 ), g.realisasi_keuangan_bulanan, 0 )) AS rk_nov,
										
										sum(IF(( g.bulan = 12 ), g.target_fisik_bulanan, 0 )) AS tf_des,
										sum(IF(( g.bulan = 12 ), g.target_keuangan_bulanan, 0 )) AS tk_des,
										sum(IF(( g.bulan = 12 ), g.realisasi_fisik_bulanan, 0 )) AS rf_des,
										sum(IF(( g.bulan = 12 ), g.realisasi_keuangan_bulanan, 0 )) AS rk_des 
									FROM
										grafik g
									WHERE 
										g.id_instansi = '{$id_instansi}' and tahun = '$tahun'
									GROUP BY
										g.id_instansi");
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
			and tahun='$tahun' and kode_sub_kegiatan in 
			(SELECT kode_sub_kegiatan from sub_kegiatan_instansi where id_instansi='$id_instansi' and tahun='$tahun' and status='1')
	          ");

	    }
        return $query;
    }



    public function rk($id_instansi, $tahap)
    {
        $bulan  = bulan_aktif();
        $tahun = tahun_anggaran();
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
                                    WHERE
                                        id_instansi = '$id_instansi'
                                        and kode_tahap = '$tahap'
                                        and bulan <= '$bulan' and tahun='$tahun'
                                         and kode_sub_kegiatan in 
                                        (SELECT kode_sub_kegiatan from sub_kegiatan_instansi where id_instansi='$id_instansi' and kode_tahap='$tahap' and tahun='$tahun')
                                        
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
