<?php

/**
 * Author     : Alfikri, M.Kom
 * Created By : Alfikri, M.Kom
 * E-Mail     : alfikri.name@gmail.com
 * No HP      : 081277337405
 * Class      : Rekap_asisten_model.php
 */
defined('BASEPATH') or exit('No direct script access allowed');

class Rekap_asisten_model extends CI_Model
{
  public function __construct()
  {
    parent::__construct();
  }

  public function get_pagu_total()
  {
    $query = $this->db->query("SELECT
                                SUM( ka.pagu ) AS pagu 
                              FROM
                                kegiatan_apbd ka");
    return $query->row()->pagu;
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
 
  public function get_opd_asisten($id_asisten, $bulan, $cara_hitung)
  {
    $kategori = 'Akumulasi';
    $tahap        = $this->input->get('tahap');
    $tahun        = $this->input->get('tahun');

    // if ($cara_hitung=='Akuntansi') {
      if ($kategori=='Akumulasi') {
         $query_sql = 'g.target_fisik_akumulasi as target_fisik,
                   g.realisasi_fisik_akumulasi as realisasi_fisik,
                   g.target_keuangan_akumulasi as target_keuangan,
                   g.realisasi_keuangan_akumulasi as realisasi_keuangan,
                   g.pagu_total,
                   g.rp_target_keuangan_akumulasi as rp_target_keuangan,
                   g.rp_realisasi_keuangan_akumulasi as rp_realisasi_keuangan
                   ';
      }else{
         $query_sql = 'g.target_fisik_bulanan as target_fisik,
                   g.realisasi_fisik_bulanan as realisasi_fisik,
                   g.target_keuangan_bulanan as target_keuangan,
                   g.realisasi_keuangan_bulanan as realisasi_keuangan,
                   
                   g.pagu_total,
                   g.rp_target_keuangan_bulanan as rp_target_keuangan,
                   g.rp_realisasi_keuangan_bulanan as rp_realisasi_keuangan
                   ';
        

      }
    // }else{ 
    //   if ($kategori=='Akumulasi') {
    //      $query_sql = 'g.target_fisik_akumulasi_ratarata as target_fisik,
    //                g.realisasi_fisik_akumulasi_ratarata as realisasi_fisik,
    //                g.target_keuangan_akumulasi_ratarata as target_keuangan,
    //                g.realisasi_keuangan_akumulasi_ratarata as realisasi_keuangan
    //                ';
       
    //   }else{
    //      $query_sql = 'g.target_fisik_bulanan_ratarata as target_fisik,
    //                g.realisasi_fisik_bulanan_ratarata as realisasi_fisik,
    //                g.target_keuangan_bulanan_ratarata as target_keuangan,
    //                g.realisasi_keuangan_bulanan_ratarata as realisasi_keuangan
    //                ';

    //   }  
    // }

    $query  = $this->db->query("SELECT
                                  mi.id_instansi,
                                  mi.kode_opd,
                                  mi.nama_instansi,
                                  mi.singkatan_nama_instansi,
                                  $query_sql,
                                   g.id_grafik,
                                    g.id_instansi,
                                    g.kode_opd,
                                    g.bulan,
                                    g.pagu_bo_bp,
                                    g.pagu_bo_bbj,
                                    g.pagu_bo_bs,
                                    g.pagu_bo_bh,
                                    g.pagu_bo_bbs,
                                    g.pagu_bm_bmt,
                                    g.pagu_bm_bmpm,
                                    g.pagu_bm_bmgb,
                                    g.pagu_bm_bmjji,
                                    g.pagu_bm_bmatl,
                                    g.pagu_bm_bmatb,
                                    g.pagu_btt,
                                    g.pagu_bt_bbh,
                                    g.pagu_bt_bbk,
                                    g.pagu_total,
                                    g.rp_target_keuangan_akumulasi,
                                    g.rp_target_keuangan_bulanan,
                                    g.rp_realisasi_keuangan_akumulasi,
                                    g.rp_realisasi_keuangan_akumulasi_bo_bp,
                                    g.rp_realisasi_keuangan_akumulasi_bo_bbj,
                                    g.rp_realisasi_keuangan_akumulasi_bo_bs,
                                    g.rp_realisasi_keuangan_akumulasi_bo_bh,
                                    g.rp_realisasi_keuangan_akumulasi_bo_bbs,
                                    g.rp_realisasi_keuangan_akumulasi_bm_bmt,
                                    g.rp_realisasi_keuangan_akumulasi_bm_bmpm,
                                    g.rp_realisasi_keuangan_akumulasi_bm_bmgb,
                                    g.rp_realisasi_keuangan_akumulasi_bm_bmjji,
                                    g.rp_realisasi_keuangan_akumulasi_bm_bmatl,
                                    g.rp_realisasi_keuangan_akumulasi_bm_bmatb,
                                    g.rp_realisasi_keuangan_akumulasi_btt,
                                    g.rp_realisasi_keuangan_akumulasi_bt_bbh,
                                    g.rp_realisasi_keuangan_akumulasi_bt_bbk,
                                    g.rp_realisasi_keuangan_bulanan,
                                    g.rp_realisasi_keuangan_bulanan_bo_bp,
                                    g.rp_realisasi_keuangan_bulanan_bo_bbj,
                                    g.rp_realisasi_keuangan_bulanan_bo_bs,
                                    g.rp_realisasi_keuangan_bulanan_bo_bh,
                                    g.rp_realisasi_keuangan_bulanan_bo_bbs,
                                    g.rp_realisasi_keuangan_bulanan_bm_bmt,
                                    g.rp_realisasi_keuangan_bulanan_bm_bmpm,
                                    g.rp_realisasi_keuangan_bulanan_bm_bmgb,
                                    g.rp_realisasi_keuangan_bulanan_bm_bmjji,
                                    g.rp_realisasi_keuangan_bulanan_bm_bmatl,
                                    g.rp_realisasi_keuangan_bulanan_bm_bmatb,
                                    g.rp_realisasi_keuangan_bulanan_btt,
                                    g.rp_realisasi_keuangan_bulanan_bt_bbh,
                                    g.rp_realisasi_keuangan_bulanan_bt_bbk,
                                    g.last_update

                                FROM
                                  master_instansi mi
                                  LEFT JOIN grafik g ON mi.id_instansi = g.id_instansi 
                                WHERE
                                  mi.id_parent = {$id_asisten}
                                  AND mi.is_active='1'
                                  AND g.kode_tahap = '$tahap'
                                  and g.tahun = '$tahun'
                                  AND g.bulan = {$bulan}
                                GROUP BY
                                  mi.id_instansi 
                                ORDER BY
                                  mi.nama_instansi");
    return $query;
      
  }







  public function realisasi_semua_opd($realisasi, $bulan)
  {
    
    $tahap        = $this->input->get('tahap');
    $tahun        = $this->input->get('tahun');
    $kategori = 'Akumulasi';
    // if ($cara_hitung=='Akuntansi') {
      if ($kategori=='Akumulasi') {
         $query_sql = 'g.target_fisik_akumulasi as target_fisik,
                   g.realisasi_fisik_akumulasi as realisasi_fisik,
                   g.target_keuangan_akumulasi as target_keuangan,
                   g.realisasi_keuangan_akumulasi as realisasi_keuangan,
                   g.pagu_total,
                   g.rp_target_keuangan_akumulasi as rp_target_keuangan,
                   g.rp_realisasi_keuangan_akumulasi as rp_realisasi_keuangan
                   ';

                     if ($realisasi=='fisik') {
                        $order_by = "ORDER by g.realisasi_fisik_akumulasi desc";
                      }
                      else{
                        $order_by = "ORDER by g.realisasi_keuangan_akumulasi desc";

                      }
      }else{
         $query_sql = 'g.target_fisik_bulanan as target_fisik,
                   g.realisasi_fisik_bulanan as realisasi_fisik,
                   g.target_keuangan_bulanan as target_keuangan,
                   43 as realisasi_keuangan,
                   
                   g.pagu_total,
                   g.rp_target_keuangan_bulanan as rp_target_keuangan,
                   g.rp_realisasi_keuangan_bulanan as rp_realisasi_keuangan
                   ';

                    if ($realisasi=='fisik') {
                        $order_by = "ORDER by g.realisasi_keuangan_bulanan desc";
                      }
                      else{
                        $order_by = "ORDER by g.realisasi_fisik_bulanan desc";

                      }
        

      }
    // }else{ 
    //   if ($kategori=='Akumulasi') {
    //      $query_sql = 'g.target_fisik_akumulasi_ratarata as target_fisik,
    //                g.realisasi_fisik_akumulasi_ratarata as realisasi_fisik,
    //                g.target_keuangan_akumulasi_ratarata as target_keuangan,
    //                g.realisasi_keuangan_akumulasi_ratarata as realisasi_keuangan
    //                ';
       
    //   }else{
    //      $query_sql = 'g.target_fisik_bulanan_ratarata as target_fisik,
    //                g.realisasi_fisik_bulanan_ratarata as realisasi_fisik,
    //                g.target_keuangan_bulanan_ratarata as target_keuangan,
    //                g.realisasi_keuangan_bulanan_ratarata as realisasi_keuangan
    //                ';

    //   }  
    // }

    $query  = $this->db->query("SELECT
                                  mi.id_instansi,
                                  mi.nama_instansi,
                                  mi.singkatan_nama_instansi,
                                  $query_sql
                                FROM
                                  master_instansi mi
                                  LEFT JOIN grafik g ON mi.id_instansi = g.id_instansi 
                                WHERE
                                  mi.is_active='1'
                                  AND g.kode_tahap = '$tahap'
                                  and g.tahun = '$tahun'
                                  AND g.bulan = {$bulan}
                                GROUP BY
                                  mi.id_instansi 
                                $order_by");
    return $query;
      
  }
  public function perengkingan_realisasi_opd($realisasi, $bulan, $urutan)
  {
    
    $tahap        = $this->input->get('tahap');
    $tahun        = $this->input->get('tahun');
    $kategori = 'Akumulasi';
    // if ($cara_hitung=='Akuntansi') {
      if ($kategori=='Akumulasi') {
         $query_sql = 'g.target_fisik_akumulasi as target_fisik,
                   g.realisasi_fisik_akumulasi as realisasi_fisik,
                   g.target_keuangan_akumulasi as target_keuangan,
                   g.realisasi_keuangan_akumulasi as realisasi_keuangan,
                   g.pagu_total,
                   g.rp_target_keuangan_akumulasi as rp_target_keuangan,
                   g.rp_realisasi_keuangan_akumulasi as rp_realisasi_keuangan
                   ';

                       if ($realisasi=='fisik') {
                        $order_by = "ORDER by g.realisasi_fisik_akumulasi ".$urutan." limit 15";
                      }
                      else{
                        $order_by = "ORDER by g.realisasi_keuangan_akumulasi ".$urutan." limit 15";

                      }
      }else{
         $query_sql = 'g.target_fisik_bulanan as target_fisik,
                   g.realisasi_fisik_bulanan as realisasi_fisik,
                   g.target_keuangan_bulanan as target_keuangan,
                   43 as realisasi_keuangan,
                   
                   g.pagu_total,
                   g.rp_target_keuangan_bulanan as rp_target_keuangan,
                   g.rp_realisasi_keuangan_bulanan as rp_realisasi_keuangan
                   ';

                    if ($realisasi=='fisik') {
                        $order_by = "ORDER by g.realisasi_keuangan_bulanan ".$urutan." limit 10";
                      }
                      else{
                        $order_by = "ORDER by g.realisasi_fisik_bulanan ".$urutan." limit 10";

                      }
        

      }
    // }else{ 
    //   if ($kategori=='Akumulasi') {
    //      $query_sql = 'g.target_fisik_akumulasi_ratarata as target_fisik,
    //                g.realisasi_fisik_akumulasi_ratarata as realisasi_fisik,
    //                g.target_keuangan_akumulasi_ratarata as target_keuangan,
    //                g.realisasi_keuangan_akumulasi_ratarata as realisasi_keuangan
    //                ';
       
    //   }else{
    //      $query_sql = 'g.target_fisik_bulanan_ratarata as target_fisik,
    //                g.realisasi_fisik_bulanan_ratarata as realisasi_fisik,
    //                g.target_keuangan_bulanan_ratarata as target_keuangan,
    //                g.realisasi_keuangan_bulanan_ratarata as realisasi_keuangan
    //                ';

    //   }  
    // }

    $query  = $this->db->query("SELECT
                                  mi.id_instansi,
                                  mi.nama_instansi,
                                  mi.singkatan_nama_instansi,
                                  $query_sql
                                FROM
                                  master_instansi mi
                                  LEFT JOIN grafik g ON mi.id_instansi = g.id_instansi 
                                WHERE
                                  mi.is_active='1'
                                  AND g.kode_tahap = '$tahap'
                                  and g.tahun = '$tahun'
                                  AND g.bulan = {$bulan}
                                GROUP BY
                                  mi.id_instansi 
                                $order_by
                               ");
    return $query;
      
  }
  public function get_opd_asisten_belum_terekap($id_asisten, $bulan)
  {

    $tahap        = $this->input->get('tahap');
    $tahun        = $this->input->get('tahun');
    $cek_instansi_yang_sudah = $this->db->query("SELECT id_instansi, kode_opd from grafik g
      where  g.kode_tahap = '$tahap'
                                  and g.tahun = '$tahun'
                                  AND g.bulan = {$bulan}
                                  ");
    $kumpul_instansi_sudah = [];
    foreach ($cek_instansi_yang_sudah->result_array() as $k => $v) {
      array_push($kumpul_instansi_sudah, $v['id_instansi']);
    }
    $id_instansi_yang_sudah = join(",",$kumpul_instansi_sudah);


    if (count($kumpul_instansi_sudah)>0) {
          $instansi_yang_belum = $this->db->query("SELECT nama_instansi, kode_opd from master_instansi where 
      is_active=1 and id_parent='$id_asisten'
      and id_instansi not in ($id_instansi_yang_sudah) ");
    }else{
    $instansi_yang_belum = $this->db->query("SELECT nama_instansi, kode_opd from master_instansi where 
      is_active=1 and id_parent='$id_asisten'");

    }
   

    // $query  = $this->db->query("SELECT
    //                               mi.id_instansi,
    //                               mi.nama_instansi,
    //                               $query_sql
    //                             FROM
    //                               master_instansi mi
    //                               LEFT JOIN grafik g ON mi.id_instansi = g.id_instansi 
    //                             WHERE
    //                               mi.id_parent = {$id_asisten}
                               
    //                             GROUP BY
    //                               mi.id_instansi 
    //                             ORDER BY
    //                               mi.nama_instansi");
    return $instansi_yang_belum;
      
  }
}
