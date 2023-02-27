<?php

/**
 * Author     : Alfikri, M.Kom
 * Created By : Alfikri, M.Kom
 * E-Mail     : alfikri.name@gmail.com
 * No HP      : 081277337405
 * Class      : Realisasi_akumulasi_model.php
 */
defined('BASEPATH') or exit('No direct script access allowed');

class Realisasi_gabungan_per_kab_kota extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
	}

	public function pagu_kota($id_kota, $tahap)
	{
		
		$query = "SELECT 
		sum(pagu_bo) as total_pagu_bo, 
		sum(pagu_bm) as total_pagu_bm, 
		sum(pagu_btt) as total_pagu_btt, 
		sum(pagu_bt) as total_pagu_bt 
		from v_instansi_kab_kota where id_kota='$id_kota' and kode_tahap='$tahap'";

		
		
		return $this->db->query($query)->row();
	}

	public function nama_kota($id_kota)
	{
		$data=['id_kota'=>$id_kota];
		return $this->db->get_where('kota', $data);
	}
	


    public function cek_realisasi_dipilih($tahap, $id_kota)
    {
        $bulan  = date('n');
        $query  = $this->db->query("SELECT
                                         sum(realisasikan_bo) as realisasikan_bo, 
                                         sum(realisasikan_bm) as realisasikan_bm,
                                         sum(realisasikan_btt) as realisasikan_btt,
                                         sum(realisasikan_bt) as realisasikan_bt
                                    FROM
                                        anggaran_instansi_kab_kota 
                                    WHERE
                                    id_kota = '$id_kota' and kode_tahap='$tahap'
                                        ");
        return $query;
    }

     public function total_realisasi_perjenis($bulan_aktif, $tahap, $id_kota, $jenis)
    {
        if ($jenis=='realisasikan_bo') {
             $query  = $this->db->query("SELECT
                                         sum(bo_bp + bo_bbj+ bo_bs+bo_bh + bo_bbs) as realisasi_bo, sum(bo_rf) as realisasi_bo_rf
                                    FROM
                                        realisasi_fisik_keuangan_kab_kota 
                                    WHERE
                                    id_kota = '$id_kota' and kode_tahap='$tahap' and bulan <= $bulan_aktif
                                        ");
        }
        else if ($jenis=='realisasikan_bm') {
            $query  = $this->db->query("SELECT
                                         sum( bm_bmt + bm_bmpm + bm_bmgb + bm_bmjji + bm_bmatl + bm_bmatb ) as realisasi_bm, sum(bm_rf) as realisasi_bm_rf
                                    FROM
                                        realisasi_fisik_keuangan_kab_kota 
                                    WHERE
                                    id_kota = '$id_kota' and kode_tahap='$tahap' and bulan <= $bulan_aktif
                                        ");
        }
        else if ($jenis=='realisasikan_btt') {
            $query  = $this->db->query("SELECT
                                         sum(btt) as realisasi_btt, sum(btt_rf) as realisasi_btt_rf
                                    FROM
                                        realisasi_fisik_keuangan_kab_kota 
                                    WHERE
                                    id_kota = '$id_kota' and kode_tahap='$tahap' and bulan <= $bulan_aktif
                                        ");
        }
        else if ($jenis=='realisasikan_bt') {
            $query  = $this->db->query("SELECT
                                         sum( bt_bbh+bt_bbk ) as realisasi_bt, sum(bt_rf) as realisasi_bt_rf
                                    FROM
                                        realisasi_fisik_keuangan_kab_kota 
                                    WHERE
                                    id_kota = '$id_kota' and kode_tahap='$tahap' and bulan <= $bulan_aktif
                                        ");
        }
     
        return $query;
    }
    public function banyak_realisasikan($tahap, $id_kota, $jenis)
    {
        if ($jenis=='realisasikan_bo') {
             $query  = $this->db->query("SELECT sum(realisasikan_bo) as banyak_realisasikan_bo FROM anggaran_instansi_kab_kota
                                    WHERE
                                    id_kota = '$id_kota' and kode_tahap='$tahap'
                                        ");
        }
        else if ($jenis=='realisasikan_bm') {
            $query  = $this->db->query("SELECT sum(realisasikan_bm) as banyak_realisasikan_bm FROM anggaran_instansi_kab_kota
                                    WHERE
                                    id_kota = '$id_kota' and kode_tahap='$tahap'
                                        ");
        }
        else if ($jenis=='realisasikan_btt') {
            $query  = $this->db->query("SELECT sum(realisasikan_btt) as banyak_realisasikan_btt FROM anggaran_instansi_kab_kota
                                    WHERE
                                    id_kota = '$id_kota' and kode_tahap='$tahap'
                                        ");
        }
        else if ($jenis=='realisasikan_bt') {
            $query  = $this->db->query("SELECT sum(realisasikan_bt) as banyak_realisasikan_bt FROM anggaran_instansi_kab_kota
                                    WHERE
                                    id_kota = '$id_kota' and kode_tahap='$tahap'
                                        ");
        }
     
        return $query;
    }


}
