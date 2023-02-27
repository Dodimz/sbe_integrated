<?php

/**
 * Author     : Alfikri, M.Kom
 * Created By : Alfikri, M.Kom
 * E-Mail     : alfikri.name@gmail.com
 * No HP      : 081277337405
 * Class      : Rekap_asisten_model.php
 */
defined('BASEPATH') or exit('No direct script access allowed');

class Jumlah_aktivitas_model extends CI_Model
{
  public function __construct()
  {
    parent::__construct();
  }

  public function program($id_instansi)
  {
    $tahap = tahapan_apbd();
    $query  = $this->db->query("SELECT kode_rekening_program from v_program_apbd where id_instansi = '$id_instansi' and kode_tahap='$tahap'");
    return $query->num_rows();
  }
  public function kegiatan($id_instansi)
  {
    $tahap = tahapan_apbd();
    $query  = $this->db->query("SELECT kode_rekening_kegiatan from v_kegiatan_apbd where id_instansi = '$id_instansi' and kode_tahap='$tahap'");
    return $query->num_rows();
  }
  public function paket($id_instansi, $jenis)
  {
    $tahap = tahapan_apbd();
    $query  = $this->db->query("SELECT id_paket_pekerjaan from paket_pekerjaan where id_instansi = '$id_instansi' and jenis_paket ='$jenis' ")->num_rows();
    return $query;
  }

  public function pagu_anggaran($id_instansi)
  {
    $tahap = tahapan_apbd();
    return $this->db->query("SELECT SUM(pagu) AS pagu FROM v_program_apbd WHERE id_instansi = '{$id_instansi}' and kode_tahap = '$tahap'")->row()->pagu;
  }



  public function get_pagu_total()
  {
    $query = $this->db->query("SELECT
                                SUM( ka.pagu ) AS pagu 
                              FROM
                                kegiatan_apbd ka");
    return $query->row()->pagu;
  }


}
