<?php

/**
 * Author     : Alfikri, M.Kom
 * Created By : Alfikri, M.Kom
 * E-Mail     : alfikri.name@gmail.com
 * No HP      : 081277337405
 * Class      : Auth_model.php
 */
defined('BASEPATH') or exit('No direct script access allowed');

class Integrasi_replikasi_model extends CI_Model
{
	
	
	public function skpd_kab_kota($id_kota)
	{	
		$q = $this->db->get_where("master_instansi_kab_kota", ['id_kota'=>$id_kota]);
		return $q;
	}
	
	public function master_instansi()
	{	
		$q = $this->db->get_where("master_instansi", ['kategori'=>'OPD', 'is_active'=>1]);
		return $q;
	}
	public function id_master_instansi($kode)
	{	
		$q = $this->db->get_where("master_instansi", ['kode_opd'=>$kode]);
		return $q;
	}
	
}
