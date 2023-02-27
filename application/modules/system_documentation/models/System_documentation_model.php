<?php

/**
 * Author     : Alfikri, M.Kom
 * Created By : Alfikri, M.Kom
 * E-Mail     : alfikri.name@gmail.com
 * No HP      : 081277337405
 * Class      : Dokumen_evidence_model.php
 */
defined('BASEPATH') or exit('No direct script access allowed');

class System_documentation_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function detail_docs($id_docs)
    {
        $id_docs    = sbe_crypt($id_docs, 'D');
        $result = $this->db->query("SELECT * FROM v_docs_system where id_docs = '$id_docs' ");
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
