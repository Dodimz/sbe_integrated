<?php

/**
 * Author     : Alfikri, M.Kom
 * Created By : Alfikri, M.Kom
 * E-Mail     : alfikri.name@gmail.com
 * No HP      : 081277337405
 * Class      : Rekap_asisten_model.php
 */
defined('BASEPATH') or exit('No direct script access allowed');

class Lap_realisasi_fisik_keu extends CI_Model
{
  public function __construct()
  {
    parent::__construct();
  }

  // public function program($id_instansi)
  // {
  //   $tahap = tahapan_apbd();
  //   $query  = $this->db->query("SELECT kode_rekening_program from v_program_apbd where id_instansi = '$id_instansi' and kode_tahap='$tahap'");
  //   return $query->num_rows();
  // }
  public function realisasi_fisik($id_instansi)
  {
    $bulan = '12';
    $query  = $this->db->query("SELECT realisasi_fisik from grafik where id_instansi = '$id_instansi' and bulan='$bulan'");
    return $query->row();
  }
  public function realisasi_keuangan($id_instansi)
  {
    $query  = $this->db->query("SELECT sum(belanja_pegawai + belanja_barang_jasa + belanja_modal) as realisasi_keuangan  from realisasi_keuangan where id_instansi = '$id_instansi'");
    return $query->row();
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
