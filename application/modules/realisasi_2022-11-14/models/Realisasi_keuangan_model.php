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
        $tahun = tahun_anggaran();
        $tahap = tahapan_apbd();

        if ($tahap==4) {
            $where = [
                'id_instansi'   => $id_instansi,
                'status'    => '1',
                'tahun'         =>$tahun
            ];
        }else{
            $where = [
                'id_instansi'   => $id_instansi,
                'kode_tahap'    => $tahap,
                'tahun'         =>$tahun
            ];
        }
        $this->db->select('SUM(pagu) AS pagu');
        return (float) $this->db->get_where('v_sub_kegiatan_apbd', $where)->row()->pagu;
    }

    public function get_realisasi($id_instansi)
    {
        $tahun = tahun_anggaran();
        $bulan  = date('n');
        $tahap = tahapan_apbd();

        if ($tahap==4) {
            $where = "WHERE ski.id_instansi = '{$id_instansi}'
                                    and ski.status = '1' and ski.tahun='$tahun'";
        }else{
            $where = "WHERE ski.id_instansi = '{$id_instansi}'
                                    and ski.kode_tahap = '{$tahap}' and ski.tahun='$tahun'";
            
        }


        $query  = $this->db->query("SELECT


            SUM(rk.bo_bp + rk.bo_bbj+ rk.bo_bs+rk.bo_bh + rk.bm_bmt + rk.bm_bmpm + rk.bm_bmgb + rk.bm_bmjji + rk.bm_bmatl + rk.btt + rk.bt_bbh + rk.bt_bbk) as total,

            sum(rk.bo_bp + rk.bo_bbj+ rk.bo_bs+rk.bo_bh) as realisasi_bo,
sum( rk.bm_bmt + rk.bm_bmpm + rk.bm_bmgb + rk.bm_bmjji + rk.bm_bmatl ) as realisasi_bm,
sum(rk.btt) as realisasi_btt,
 sum( rk.bt_bbh+rk.bt_bbk ) as realisasi_bt,


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
                                    and bulan <= '$bulan'
                                    ");
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
        $tahun = tahun_anggaran();
        if ($tahap==4) {
            $where = "WHERE ski.id_instansi = '{$id_instansi}' and ski.tahun='$tahun'
            and ski.status=1 and ski.kode_sub_kegiatan='$kode_sub_kegiatan'
            ";
        }else{
            $where = "WHERE ski.id_instansi = '{$id_instansi}' and ski.kode_tahap='$tahap' and ski.tahun='$tahun' and ski.kode_sub_kegiatan='$kode_sub_kegiatan'";

        }

        $query  = $this->db->query("SELECT
                                         realisasikan_bo, realisasikan_bm,realisasikan_btt,realisasikan_bt
                                    FROM anggaran_sub_kegiatan ask left join sub_kegiatan_instansi ski on 
ask.kode_sub_kegiatan=ski.kode_sub_kegiatan and ask.id_instansi=ski.id_instansi and ask.kode_tahap = ski.kode_tahap and ask.tahun = ski.tahun
              $where
                                        ");
        return $query;
    }
    
    public function total_realisasi_perjenis($kode_sub_kegiatan, $tahap, $id_instansi, $jenis)
    {
        $bulan_aktif  = bulan_aktif();
        $tahun = tahun_anggaran();
        if ($jenis=='realisasikan_bo') {
             $query  = $this->db->query("SELECT
                                         sum(bo_bp + bo_bbj+ bo_bs+bo_bh) as realisasi_bo
                                    FROM
                                        realisasi_keuangan 
                                    WHERE
                                    id_instansi = '$id_instansi' and kode_tahap='$tahap' and kode_sub_kegiatan='$kode_sub_kegiatan' and bulan <= $bulan_aktif and tahun = '$tahun'
                                        ");
        }
        else if ($jenis=='realisasikan_bm') {
            $query  = $this->db->query("SELECT
                                         sum( bm_bmt + bm_bmpm + bm_bmgb + bm_bmjji + bm_bmatl ) as realisasi_bm
                                    FROM
                                        realisasi_keuangan 
                                    WHERE
                                    id_instansi = '$id_instansi' and kode_tahap='$tahap' and kode_sub_kegiatan='$kode_sub_kegiatan' and bulan <= $bulan_aktif and tahun = '$tahun'
                                        ");
        }
        else if ($jenis=='realisasikan_btt') {
            $query  = $this->db->query("SELECT
                                         sum(btt) as realisasi_btt
                                    FROM
                                        realisasi_keuangan 
                                    WHERE
                                    id_instansi = '$id_instansi' and kode_tahap='$tahap' and kode_sub_kegiatan='$kode_sub_kegiatan' and bulan <= $bulan_aktif and tahun = '$tahun'
                                        ");
        }
        else if ($jenis=='realisasikan_bt') {
            $query  = $this->db->query("SELECT
                                         sum( bt_bbh+bt_bbk ) as realisasi_bt
                                    FROM
                                        realisasi_keuangan 
                                    WHERE
                                    id_instansi = '$id_instansi' and kode_tahap='$tahap' and kode_sub_kegiatan='$kode_sub_kegiatan' and bulan <= $bulan_aktif and tahun = '$tahun'
                                        ");
        }
     
        return $query;
    }


    public function total_realisasi($kode_sub_kegiatan, $tahap, $id_instansi)
    {
            $bulan_aktif = bulan_aktif();
            $tahun  = tahun_anggaran();
             $query  = $this->db->query("SELECT
                                         sum(bo_bp + bo_bbj+ bo_bs+bo_bh + bm_bmt + bm_bmpm + bm_bmgb + bm_bmjji + bm_bmatl + btt + bt_bbh + bt_bbk ) as total_realisasi
                                    FROM
                                        realisasi_keuangan 
                                    WHERE
                                    id_instansi = '$id_instansi' and kode_tahap='$tahap' and tahun='$tahun' and kode_sub_kegiatan='$kode_sub_kegiatan'  and bulan <= $bulan_aktif
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
