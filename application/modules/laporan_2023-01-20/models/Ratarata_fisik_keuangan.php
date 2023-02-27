<?php

/**
 * Author     : Alfikri, M.Kom
 * Created By : Alfikri, M.Kom
 * E-Mail     : alfikri.name@gmail.com
 * No HP      : 081277337405
 * Class      : Rekap_asisten_model.php
 */
defined('BASEPATH') or exit('No direct script access allowed');

class Ratarata_fisik_keuangan extends CI_Model
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

  public function skpd($filter,$bulan, $realisasi, $nomenklatur, $cara_hitung, $kategori)
  {
      $tahap        = $this->input->get('tahap');
    $tahun        = $this->input->get('tahun');
    $kategori_penampilan_laporan  = $this->input->get('kategori_penampilan_data');


    if ($kategori_penampilan_laporan=='pagu_dan_realisasi_skpd_per_jenis_belanja_bulanan') {
         $q_realisasi = "(g.rp_realisasi_keuangan_bo_bp + g.rp_realisasi_keuangan_bo_bbj + g.rp_realisasi_keuangan_bo_bs + g.rp_realisasi_keuangan_bo_bh + g.rp_realisasi_keuangan_bo_bbs ) as rp_realisasi_keuangan_bo ,
                                  (g.rp_realisasi_keuangan_bm_bmt + g.rp_realisasi_keuangan_bm_bmpm + g.rp_realisasi_keuangan_bm_bmgb + g.rp_realisasi_keuangan_bm_bmjji + g.rp_realisasi_keuangan_bm_bmatl + g.rp_realisasi_keuangan_bm_bmatb) as rp_realisasi_keuangan_bm ,
                                  g.rp_realisasi_keuangan_btt as rp_realisasi_keuangan_btt ,
                                  (g.rp_realisasi_keuangan_bt_bbh + g.rp_realisasi_keuangan_bt_bbk) as rp_realisasi_keuangan_bt ,";
        }
        else{
         $q_realisasi = "
         (SELECT sum(rp_realisasi_keuangan_bo_bp + rp_realisasi_keuangan_bo_bbj + rp_realisasi_keuangan_bo_bs + rp_realisasi_keuangan_bo_bh + rp_realisasi_keuangan_bo_bbs) from grafik where id_instansi=g.id_instansi and kode_tahap=g.kode_tahap and tahun=g.tahun and bulan <='$bulan') as rp_realisasi_keuangan_bo,
(SELECT sum(rp_realisasi_keuangan_bm_bmt + rp_realisasi_keuangan_bm_bmpm + rp_realisasi_keuangan_bm_bmgb + rp_realisasi_keuangan_bm_bmjji + rp_realisasi_keuangan_bm_bmatl + rp_realisasi_keuangan_bm_bmatb) from grafik where id_instansi=g.id_instansi and kode_tahap=g.kode_tahap and tahun=g.tahun and bulan <='$bulan') as rp_realisasi_keuangan_bm,
(SELECT sum(rp_realisasi_keuangan_btt) from grafik where id_instansi=g.id_instansi and kode_tahap=g.kode_tahap and tahun=g.tahun and bulan <='$bulan') as rp_realisasi_keuangan_btt,
(SELECT sum(rp_realisasi_keuangan_bt_bbh + rp_realisasi_keuangan_bt_bbk) from grafik where id_instansi=g.id_instansi and kode_tahap=g.kode_tahap and tahun=g.tahun and bulan <='$bulan') as rp_realisasi_keuangan_bt,";
       
        }


    if ($filter=='semua') {
      $where = "";
    }else{
      $where = "and mi.id_parent='$filter'";

    }

    if ($realisasi=='fisik') {
          if ($kategori=='Akumulasi') {
             $order = 'ORDER BY g.realisasi_fisik_akumulasi desc';
          }else{
             $order = 'ORDER BY g.realisasi_fisik_bulanan desc';
         
          }
    }
    elseif ($realisasi=='keu') {

      if ($cara_hitung=='Akuntansi') {
        if ($kategori=='Akumulasi') {
           $order = 'order by g.realisasi_keuangan_akumulasi desc
                     ';
        }else{
           $order = 'ORDER BY g.realisasi_keuangan_bulanan desc
                     ';
        }
      }else{
        if ($kategori=='Akumulasi') {
           $order = 'ORDER BY g.realisasi_keuangan_akumulasi_ratarata DESC
           ';
         
        }else{
           $order = 'ORDER BY g.realisasi_keuangan_bulanan_ratarata DESC
                     ';
        }  
      }



    }else{
      $order = "";

    }

    // if ($nomenklatur=='lama') {
    //   $where_nomenklatur = "and mi.id_instansi <163 ";
    // }else{
    // }



    if ($cara_hitung=='Akuntansi') {
      if ($kategori=='Akumulasi') {
         $query_grafik = 'g.target_fisik_akumulasi as target_fisik,
                   g.realisasi_fisik_akumulasi as realisasi_fisik,
                   g.target_keuangan_akumulasi as target_keuangan,
                   g.realisasi_keuangan_akumulasi as realisasi_keuangan
                   ';
         $query_deviasi = '(g.realisasi_fisik_akumulasi - g.target_fisik_akumulasi) as deviasi_fisik,
         (g.realisasi_keuangan_akumulasi - g.target_keuangan_akumulasi) as deviasi_keuangan 
         ';
      }else{
         $query_grafik = 'g.target_fisik_bulanan as target_fisik,
                   g.realisasi_fisik_bulanan as realisasi_fisik,
                   g.target_keuangan_bulanan as target_keuangan,
                   g.realisasi_keuangan_bulanan as realisasi_keuangan
                   ';
          $query_deviasi = '(g.realisasi_fisik_bulanan - g.target_fisik_bulanan) as deviasi_fisik,
         (g.realisasi_keuangan_bulanan - g.target_keuangan_bulanan) as deviasi_keuangan 
         ';
        

      }
    }else{
      if ($kategori=='Akumulasi') {
         $query_grafik = 'g.target_fisik_akumulasi_ratarata as target_fisik,
                   g.realisasi_fisik_akumulasi_ratarata as realisasi_fisik,
                   g.target_keuangan_akumulasi_ratarata as target_keuangan,
                   g.realisasi_keuangan_akumulasi_ratarata as realisasi_keuangan
                   ';
          $query_deviasi = '(g.realisasi_fisik_akumulasi - g.target_fisik_akumulasi) as deviasi_fisik,
         (g.realisasi_keuangan_akumulasi - g.target_keuangan_akumulasi) as deviasi_keuangan 
         ';
       
      }else{
         $query_grafik = 'g.target_fisik_bulanan_ratarata as target_fisik,
                   g.realisasi_fisik_bulanan_ratarata as realisasi_fisik,
                   g.target_keuangan_bulanan_ratarata as target_keuangan,
                   g.realisasi_keuangan_bulanan_ratarata as realisasi_keuangan
                   ';
          $query_deviasi = '(g.realisasi_fisik_akumulasi - g.target_fisik_akumulasi) as deviasi_fisik,
         (g.realisasi_keuangan_akumulasi - g.target_keuangan_akumulasi) as deviasi_keuangan 
         ';

      }  
    }
      $where_nomenklatur = "and mi.is_active='1'";

$query_rp_keu = '';

    $query  = $this->db->query("SELECT
                                  mi.id_instansi,
                                  mi.nama_instansi,
                                  g.pagu_total,
                                  $query_grafik,
                                  $query_deviasi,
                                  g.rp_target_keuangan_akumulasi,
                                  g.rp_target_keuangan_bulanan,
                                  
                                  (g.pagu_bo_bp + g.pagu_bo_bbj + g.pagu_bo_bs + g.pagu_bo_bh + g.pagu_bo_bbs ) as pagu_bo ,
                                  (g.pagu_bm_bmt + g.pagu_bm_bmpm + g.pagu_bm_bmgb + g.pagu_bm_bmjji + g.pagu_bm_bmatl + g.pagu_bm_bmatb) as pagu_bm ,
                                  g.pagu_btt as pagu_btt ,
                                  (g.pagu_bt_bbh + g.pagu_bt_bbk) as pagu_bt,
                                  g.rp_realisasi_keuangan_akumulasi,
                                  g.rp_realisasi_keuangan_bulanan

                                FROM
                                  master_instansi mi
                                  LEFT JOIN grafik g ON mi.id_instansi = g.id_instansi 
                                WHERE
                                 mi.id_instansi not in (164,165,200,201,202,203,204,205,206)
                                   
                                    AND g.bulan = {$bulan}
                                    AND g.kode_tahap='$tahap'
                                    AND tahun = '$tahun'
                                   $where $where_nomenklatur
                                   $order

                                 ");
    return $query;
  }





    public function skpd_belum_terekap($id_asisten, $bulan)
  {

    $tahap        = $this->input->get('tahap');
    $tahun        = $this->input->get('tahun');
    $cek_instansi_yang_sudah = $this->db->query("SELECT id_instansi from grafik g
      where  g.kode_tahap = '$tahap'
                                  and g.tahun = '$tahun'
                                  AND g.bulan = {$bulan}
                                  ");
    $kumpul_instansi_sudah = [];
    foreach ($cek_instansi_yang_sudah->result_array() as $k => $v) {
      array_push($kumpul_instansi_sudah, $v['id_instansi']);
    }
    $id_instansi_yang_sudah = join(",",$kumpul_instansi_sudah);


    if ($id_asisten=='semua') {
      



       if (count($kumpul_instansi_sudah)>0) {
            $instansi_yang_belum = $this->db->query("SELECT id_instansi, nama_instansi from master_instansi where 
        is_active=1
        and id_instansi not in ($id_instansi_yang_sudah) and kategori='OPD' ");

            $tes = 1;
      }else{
      $instansi_yang_belum = $this->db->query("SELECT id_instansi, nama_instansi from master_instansi where 
        is_active=1 and kategori='OPD'");
            $tes = 0;

      }
    }else{
      if (count($kumpul_instansi_sudah)>0) {
            $instansi_yang_belum = $this->db->query("SELECT id_instansi, nama_instansi from master_instansi where 
        is_active=1 and id_parent='$id_asisten' and kategori='OPD'
        and id_instansi not in ($id_instansi_yang_sudah) ");

            $tes = 1;
      }else{
      $instansi_yang_belum = $this->db->query("SELECT id_instansi, nama_instansi from master_instansi where 
        is_active=1 and id_parent='$id_asisten' and kategori='OPD'");
            $tes = 0;

      }
    }

    return $instansi_yang_belum;
      
  }
}
