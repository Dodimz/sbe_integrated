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
		$id_instansi = sbe_crypt($this->input->get('id_opd'),'D');
		if ($id_instansi=='semua_opd') {
			$where = '';
		}else{
			$where = "and id_parent = '$id_instansi'";

		}
		$tahun 				= $this->input->get('tahun');
		$tahap 				=  $this->input->get('tahap');
		$q = $this->db->query("SELECT psk.id_instansi, mi.nama_instansi, mi.is_active from permasalahan_sub_kegiatan psk left join master_instansi mi on psk.id_instansi =mi.id_instansi where psk.id_instansi in (SELECT id_instansi from master_instansi where is_active = 1 $where) and psk.tahun='$tahun' and psk.permasalahan!='Tidak ada permasalahan' group by psk.id_instansi order by mi.nama_instansi asc");
		return $q;
	}


}
