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

  public function skpd($filter,$bulan, $realisasi, $nomenklatur)
  {
      $tahap        = $this->input->get('tahap');
    $tahun        = $this->input->get('tahun');
    if ($filter=='semua') {
      $where = "";
    }else{
      $where = "and mi.id_parent='$filter'";

    }

    if ($realisasi=='fisik') {
      $order = "ORDER BY g.realisasi_fisik desc";
    }
    elseif ($realisasi=='keu') {
      $order = "ORDER BY g.realisasi_keuangan DESC";
    }else{
      $order = "";

    }

    if ($nomenklatur=='lama') {
      $where_nomenklatur = "and mi.id_instansi <163 ";
    }else{
      $where_nomenklatur = "and mi.is_active='1'";
    }
    $query  = $this->db->query("SELECT
                                  mi.id_instansi,
                                  mi.nama_instansi,
                                  g.target_fisik,
                                  g.realisasi_fisik,
                                  (g.realisasi_fisik - g.target_fisik) as deviasi_fisik ,
                                  (g.realisasi_keuangan - g.target_keuangan) as deviasi_keuangan ,
                                  g.target_keuangan,
                                  g.realisasi_keuangan 
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
}
