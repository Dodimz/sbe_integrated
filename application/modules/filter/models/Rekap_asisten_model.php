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

  public function get_opd_asisten($id_asisten, $bulan)
  {
    $query  = $this->db->query("SELECT
                                  mi.id_instansi,
                                  mi.nama_instansi,
                                  g.target_fisik,
                                  g.target_keuangan,
                                  g.realisasi_fisik,
                                  g.realisasi_keuangan 
                                FROM
                                  master_instansi mi
                                  LEFT JOIN grafik g ON mi.id_instansi = g.id_instansi 
                                WHERE
                                  mi.id_parent = {$id_asisten}
                                  AND g.bulan = {$bulan}
                                GROUP BY
                                  mi.id_instansi 
                                ORDER BY
                                  mi.nama_instansi");
    return $query;
  }
}
