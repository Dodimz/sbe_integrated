<?php

/**
 * Author     : Alfikri, M.Kom
 * Created By : Alfikri, M.Kom
 * E-Mail     : alfikri.name@gmail.com
 * No HP      : 081277337405
 * Class      : Realisasi_keuangan_model.php
 */
defined('BASEPATH') or exit('No direct script access allowed');

class Realisasi_fisik_keuangan_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function anggaran_apbd($id_instansi)
    {
        $where = [
            'id_instansi'   => $id_instansi,
            'kode_tahap'    => tahapan_apbd()
        ];
        $this->db->select('SUM(pagu) AS pagu');
        return (float) $this->db->get_where('v_program_apbd', $where)->row()->pagu;
    }

    public function get_realisasi($id_kota, $tahun, $tahap)
    {
        $bulan  = date('n');
        $query  = $this->db->query("SELECT
sum(bo_bp + bo_bbj+ bo_bs+bo_bh) as realisasi_bo,
sum( bm_bmt + bm_bmpm + bm_bmgb + bm_bmjji + bm_bmatl ) as realisasi_bm,
sum(btt) as realisasi_btt,
 sum( bt_bbh+bt_bbk ) as realisasi_bt,


 sum(bo_bp + bo_bbj+ bo_bs+bo_bh + bm_bmt + bm_bmpm + bm_bmgb + bm_bmjji + bm_bmatl +btt +  bt_bbh+bt_bbk ) as total
                                      
                                    FROM
                                        realisasi_fisik_keuangan_kab_kota
                                    WHERE
                                        id_kota = $id_kota  
                                        AND tahun = '$tahun' 
                                        AND kode_tahap = '$tahap' 
                                        AND bulan <= {$bulan}");
        return $query;
    }

    public function get_realisasi_kegiatan($id_instansi, $kode_rekening)
    {
        $bulan  = date('n');
        $query  = $this->db->query("SELECT
                                        rk.nama_kegiatan,
                                        SUM( rk.belanja_pegawai ) AS belanja_pegawai,
                                        SUM( rk.belanja_barang_jasa ) AS belanja_barang_jasa,
                                        SUM( rk.belanja_modal ) AS belanja_modal,
                                        SUM( rk.belanja_pegawai + rk.belanja_barang_jasa + rk.belanja_modal ) AS total 
                                    FROM
                                        realisasi_keuangan rk 
                                    WHERE
                                        rk.id_instansi = {$id_instansi}
                                        AND rk.kode_rekening = '{$kode_rekening}'
                                        AND rk.bulan <= $bulan
                                    GROUP BY rk.kode_rekening");
        return $query;
    }




























    public function cek_realisasi_dipilih($tahap, $id_instansi)
    {
        $bulan  = date('n');
        $tahun_anggaran = tahun_anggaran();
        $query  = $this->db->query("SELECT
                                         realisasikan_bo, realisasikan_bm,realisasikan_btt,realisasikan_bt
                                    FROM
                                        anggaran_instansi_kab_kota 
                                    WHERE
                                    id_instansi = '$id_instansi' and kode_tahap='$tahap' and tahun ='$tahun_anggaran'
                                        ");
        return $query;
    }
    
    public function total_realisasi_perjenis($bulan_aktif, $tahap, $id_instansi, $jenis)
    {
        $tahun_anggaran = tahun_anggaran();
        if ($jenis=='realisasikan_bo') {
             $query  = $this->db->query("SELECT
                                         sum(bo_bp + bo_bbj+ bo_bs+bo_bh+bo_bbs) as realisasi_bo, sum(bo_rf) as realisasi_bo_rf
                                    FROM
                                        realisasi_fisik_keuangan_kab_kota 
                                    WHERE
                                    id_instansi = '$id_instansi' and kode_tahap='$tahap' and bulan <= $bulan_aktif
                                    and tahun='$tahun_anggaran'
                                        ");
        }
        else if ($jenis=='realisasikan_bm') {
            $query  = $this->db->query("SELECT
                                         sum( bm_bmt + bm_bmpm + bm_bmgb + bm_bmjji + bm_bmatl + bm_bmatb ) as realisasi_bm, sum(bm_rf) as realisasi_bm_rf
                                    FROM
                                        realisasi_fisik_keuangan_kab_kota 
                                    WHERE
                                    id_instansi = '$id_instansi' and kode_tahap='$tahap' and bulan <= $bulan_aktif
                                     and tahun='$tahun_anggaran'
                                        ");
        }
        else if ($jenis=='realisasikan_btt') {
            $query  = $this->db->query("SELECT
                                         sum(btt) as realisasi_btt, sum(btt_rf) as realisasi_btt_rf
                                    FROM
                                        realisasi_fisik_keuangan_kab_kota 
                                    WHERE
                                    id_instansi = '$id_instansi' and kode_tahap='$tahap' and bulan <= $bulan_aktif
                                     and tahun='$tahun_anggaran'
                                        ");
        }
        else if ($jenis=='realisasikan_bt') {
            $query  = $this->db->query("SELECT
                                         sum( bt_bbh+bt_bbk ) as realisasi_bt, sum(bt_rf) as realisasi_bt_rf
                                    FROM
                                        realisasi_fisik_keuangan_kab_kota 
                                    WHERE
                                    id_instansi = '$id_instansi' and kode_tahap='$tahap' and bulan <= $bulan_aktif
                                     and tahun='$tahun_anggaran'
                                        ");
        }
        else  {
            $query  = $this->db->query("SELECT
                                         sum( rf_total ) as realisasi_fisik_total
                                    FROM
                                        realisasi_fisik_keuangan_kab_kota 
                                    WHERE
                                    id_instansi = '$id_instansi' and kode_tahap='$tahap' and bulan <= $bulan_aktif
                                     and tahun='$tahun_anggaran'
                                        ");
        }
     
        return $query;
    }




    public function total_lra($bulan_aktif, $tahap, $id_instansi)
    {
        $tahun_anggaran = tahun_anggaran();
        
            $query  = $this->db->query("SELECT
                                         sum( lra ) as total_lra
                                    FROM
                                        lra_kab_kota 
                                    WHERE
                                    id_instansi = '$id_instansi' and kode_tahap='$tahap' and bulan <= $bulan_aktif
                                     and tahun='$tahun_anggaran'
                                        ");
        
     
        return $query;
    }


    public function anggaran_kab_kota($id_kota)
    {
        $tahun = tahun_anggaran();
        $where = [
            'id_kota'   => $id_kota,
            'kode_tahap'    => tahapan_apbd(),
            'tahun'         =>$tahun
        ];
        $this->db->select('SUM(pagu_total) AS pagu');
        return (float) $this->db->get_where('v_instansi_kab_kota', $where)->row()->pagu;
    }

    public function total_realisasi_keuangan($tahap, $id_instansi)
    {
            $bulan_aktif = bulan_aktif();
             $query  = $this->db->query("SELECT
                                         sum(bo_bp + bo_bbj+ bo_bs+bo_bh + bm_bmt + bm_bmpm + bm_bmgb + bm_bmjji + bm_bmatl + btt + bt_bbh + bt_bbk ) as total_realisasi
                                    FROM
                                        realisasi_keuangan 
                                    WHERE
                                    id_instansi = '$id_instansi' and kode_tahap='$tahap' and bulan <= $bulan_aktif
                                        ");
     
     
        return $query;
    }



    public function realisasi($where, $jenis)
    {
        $bulan  = date('n');

        if ($jenis=='bo') {
            $select = 'id_realisasi_fisik_keuangan_kab_kota, bo_bp,bo_bbj,bo_bs,bo_bh, bo_bbs, bo_rf, rf_total';
        }
        else if ($jenis=='bm') {
            $select = 'id_realisasi_fisik_keuangan_kab_kota, bm_bmt,bm_bmpm,bm_bmgb,bm_bmjji,bm_bmatl, bm_bmatb, bm_rf, rf_total';
        }
        else if ($jenis=='btt') {
            $select = 'id_realisasi_fisik_keuangan_kab_kota, btt, btt_rf, rf_total';
        }
        else if ($jenis=='bt') {
            $select = 'id_realisasi_fisik_keuangan_kab_kota, bt_bbh,bt_bbk, bt_rf, rf_total';
        }
        else{
            $select = '*';
        }
             $query  = $this->db->query("SELECT
                                        
                                       $select
                                    FROM
                                        realisasi_fisik_keuangan_kab_kota 
                                    WHERE
                                   $where
                                        ");
        
        return $query;
    }

    public function realisasi_lra($where)
    {
        $bulan  = date('n');

            $select = '*';
             $query  = $this->db->query("SELECT
                                        
                                       $select
                                    FROM
                                        lra_kab_kota 
                                    WHERE
                                   $where
                                        ");
        
        return $query;
    }

}
