<?php

/**
 * Author     : Alfikri, M.Kom
 * Created By : Alfikri, M.Kom
 * E-Mail     : alfikri.name@gmail.com
 * No HP      : 081277337405
 * Class      : Realisasi_keuangan_model.php
 */
defined('BASEPATH') or exit('No direct script access allowed');

class Realisasi_keuangan_model extends CI_Model
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

    public function get_realisasi($id_instansi)
    {
        $bulan  = date('n');
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




























    public function cek_realisasi_dipilih($kode_sub_kegiatan, $tahap, $id_instansi)
    {
        $bulan  = date('n');
        $query  = $this->db->query("SELECT
                                         realisasikan_bo, realisasikan_bm,realisasikan_btt,realisasikan_bt
                                    FROM
                                        anggaran_sub_kegiatan 
                                    WHERE
                                    id_instansi = '$id_instansi' and kode_tahap='$tahap' and kode_sub_kegiatan='$kode_sub_kegiatan'
                                        ");
        return $query;
    }
    
    public function total_realisasi_perjenis($kode_sub_kegiatan, $tahap, $id_instansi, $jenis)
    {
        $bulan_aktif  = bulan_aktif();
        if ($jenis=='realisasikan_bo') {
             $query  = $this->db->query("SELECT
                                         sum(bo_bp + bo_bbj+ bo_bs+bo_bh) as realisasi_bo
                                    FROM
                                        realisasi_keuangan 
                                    WHERE
                                    id_instansi = '$id_instansi' and kode_tahap='$tahap' and kode_sub_kegiatan='$kode_sub_kegiatan' and bulan <= $bulan_aktif
                                        ");
        }
        else if ($jenis=='realisasikan_bm') {
            $query  = $this->db->query("SELECT
                                         sum( bm_bmt + bm_bmpm + bm_bmgb + bm_bmjji + bm_bmatl ) as realisasi_bm
                                    FROM
                                        realisasi_keuangan 
                                    WHERE
                                    id_instansi = '$id_instansi' and kode_tahap='$tahap' and kode_sub_kegiatan='$kode_sub_kegiatan' and bulan <= $bulan_aktif
                                        ");
        }
        else if ($jenis=='realisasikan_btt') {
            $query  = $this->db->query("SELECT
                                         sum(btt) as realisasi_btt
                                    FROM
                                        realisasi_keuangan 
                                    WHERE
                                    id_instansi = '$id_instansi' and kode_tahap='$tahap' and kode_sub_kegiatan='$kode_sub_kegiatan' and bulan <= $bulan_aktif
                                        ");
        }
        else if ($jenis=='realisasikan_bt') {
            $query  = $this->db->query("SELECT
                                         sum( bt_bbh+bt_bbk ) as realisasi_bt
                                    FROM
                                        realisasi_keuangan 
                                    WHERE
                                    id_instansi = '$id_instansi' and kode_tahap='$tahap' and kode_sub_kegiatan='$kode_sub_kegiatan' and bulan <= $bulan_aktif
                                        ");
        }
     
        return $query;
    }


    public function total_realisasi($kode_sub_kegiatan, $tahap, $id_instansi)
    {
            $bulan_aktif = bulan_aktif();
             $query  = $this->db->query("SELECT
                                         sum(bo_bp + bo_bbj+ bo_bs+bo_bh + bm_bmt + bm_bmpm + bm_bmgb + bm_bmjji + bm_bmatl + btt + bt_bbh + bt_bbk ) as total_realisasi
                                    FROM
                                        realisasi_keuangan 
                                    WHERE
                                    id_instansi = '$id_instansi' and kode_tahap='$tahap' and kode_sub_kegiatan='$kode_sub_kegiatan'                                      and bulan <= $bulan_aktif
                                        ");
     
     
        return $query;
    }



    public function realisasi($where, $jenis)
    {
        $bulan  = date('n');

        if ($jenis=='bo') {
            $select = 'bo_bp,bo_bbj,bo_bs,bo_bh';
        }
        else if ($jenis=='bm') {
            $select = 'bm_bmt,bm_bmpm,bm_bmgb,bm_bmjji,bm_bmatl';
        }
        else if ($jenis=='btt') {
            $select = 'btt';
        }
        else if ($jenis=='bt') {
            $select = 'bt_bbh,bt_bbk';
        }
             $query  = $this->db->query("SELECT
                                        id_realisasi_keuangan, 
                                       $select
                                    FROM
                                        realisasi_keuangan 
                                    WHERE
                                   $where
                                        ");
        
        return $query;
    }

}
