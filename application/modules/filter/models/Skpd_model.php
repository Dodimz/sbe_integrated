<?php

/**
 * Author     : Alfikri, M.Kom
 * Created By : Alfikri, M.Kom
 * E-Mail     : alfikri.name@gmail.com
 * No HP      : 081277337405
 * Class      : Realisasi_akumulasi_model.php
 */
defined('BASEPATH') or exit('No direct script access allowed');

class Skpd_model	 extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
	}

	public function get_opd()
	{
		if ($this->session->userdata('group_name') == 'OPERATOR') :
			if (id_instansi()) :
				$id_instansi = id_instansi();
				$where = "id_instansi='$id_instansi'";
			endif;
		elseif ($this->session->userdata('group_name') == 'ADMIN' || $this->session->userdata('group_name') == 'SUPER ADMIN' || $this->session->userdata('group_name') == 'HELPDESK') :
				$where = "id_instansi not in (164,165,203) and kategori	='OPD'";
		endif;
		return $this->db->query("SELECT * from master_instansi where $where");
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


}
