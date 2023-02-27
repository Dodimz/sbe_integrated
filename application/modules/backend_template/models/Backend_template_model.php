<?php

/**
 * Author     : Alfikri, M.Kom
 * Created By : Alfikri, M.Kom
 * E-Mail     : alfikri.name@gmail.com
 * No HP      : 081277337405
 * Class      : Backend_template_model.php
 */
defined('BASEPATH') or exit('No direct script access allowed');

class Backend_template_model extends CI_Model
{
	protected $id_instansi;
	public function __construct()
	{
		parent::__construct();
		$this->id_instansi = id_instansi();
	}

	public function get_paket_ditolak()
	{
		$query  = $this->db->query("SELECT
										rf.id_realisasi_fisik,
										mu.full_name,
										msk.nama_sub_kegiatan,
										pp.nama_paket,
										rf.id_vol_pelaksanaan_pekerjaan,
										rf.dokumen,
										rf.masalah,
										rf.solusi 
									FROM
										realisasi_fisik rf
										LEFT JOIN paket_pekerjaan pp ON rf.id_paket_pekerjaan = pp.id_paket_pekerjaan
										LEFT JOIN master_users mu ON rf.id_pptk = mu.id_user 
										LEFT JOIN master_sub_kegiatan msk ON pp.kode_rekening_sub_kegiatan = msk.kode_sub_kegiatan
									WHERE
										rf.id_instansi = '{$this->id_instansi}'
										AND 
										rf.STATUS = 'Ditolak'
										group by id_realisasi_fisik");
		return $query;
	}
}
