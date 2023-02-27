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
                                        rk.nama_kegiatan,
                                        SUM( rk.belanja_pegawai ) AS belanja_pegawai,
                                        SUM( rk.belanja_barang_jasa ) AS belanja_barang_jasa,
                                        SUM( rk.belanja_modal ) AS belanja_modal,
                                        SUM( rk.belanja_pegawai + rk.belanja_barang_jasa + rk.belanja_modal ) AS total 
                                    FROM
                                        realisasi_keuangan rk 
                                    WHERE
                                        rk.id_instansi = $id_instansi 
                                        AND rk.bulan <= {$bulan}");
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
}
