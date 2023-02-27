<?php

/**
 * Author     : Alfikri, M.Kom
 * Created By : Alfikri, M.Kom
 * E-Mail     : alfikri.name@gmail.com
 * No HP      : 081277337405
 * Class      : Dokumen_evidence_model.php
 */
defined('BASEPATH') or exit('No direct script access allowed');

class Dokumen_evidence_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function cek_realisasi_fisik($id_realisasi_fisik)
    {
        $id_realisasi_fisik = sbe_crypt($id_realisasi_fisik, 'D');
        $result = $this->db->query("SELECT
                                        rf.id_realisasi_fisik,
                                        rf.id_paket_pekerjaan,
                                        mu.full_name,
                                        msk.nama_sub_kegiatan,
                                        pp.nama_paket,
                                        rf.dokumen,
                                        rf.file_dokumen,
                                        rf.masalah,
                                        rf.solusi,
                                        rf.status 
                                    FROM
                                        realisasi_fisik rf
                                        LEFT JOIN paket_pekerjaan pp ON rf.id_paket_pekerjaan = pp.id_paket_pekerjaan
                                        LEFT JOIN master_users mu ON rf.id_pptk = mu.id_user 
                                        LEFT JOIN master_sub_kegiatan msk ON pp.kode_rekening_sub_kegiatan = msk.kode_sub_kegiatan
                                    WHERE
                                        rf.id_realisasi_fisik = '{$id_realisasi_fisik}'
                                        AND 
                                        rf.status  in ('Ditolak','Belum Validasi')");
        return $result;
    }

    public function update_realisasi_fisik($namabaru = '')
    {
        $id_realisasi_fisik = sbe_crypt($this->input->post('id_realisasi_fisik'), 'D');
        $data = [
            'nilai'     => 0,
            'file_dokumen' =>$namabaru, 
            'status'    => 'Belum Validasi',
            'masalah'   => '',
            'solusi'    => '',
            'updated_on' => timestamp()
        ];

        return $this->db->update('realisasi_fisik', $data, ['id_realisasi_fisik' => $id_realisasi_fisik]);
    }
}
