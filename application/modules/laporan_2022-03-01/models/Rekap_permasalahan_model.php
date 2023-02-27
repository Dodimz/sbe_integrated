<?php

/**
 * Author     : Alfikri, M.Kom
 * Created By : Alfikri, M.Kom
 * E-Mail     : alfikri.name@gmail.com
 * No HP      : 081277337405
 * Class      : Realisasi_akumulasi_model.php
 */
defined('BASEPATH') or exit('No direct script access allowed');

class Rekap_permasalahan_model extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
	}

	public function instansi_yang_menyampaikan()
	{
		$q = $this->db->query("SELECT distinct psk.id_instansi, mi.nama_instansi, mi.is_active from permasalahan_sub_kegiatan psk left join master_instansi mi on psk.id_instansi =mi.id_instansi order by mi.nama_instansi asc");
		return $q;
	}


}
