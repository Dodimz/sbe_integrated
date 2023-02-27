<?php

/**
 * Author     : Alfikri, M.Kom
 * Created By : Alfikri, M.Kom
 * E-Mail     : alfikri.name@gmail.com
 * No HP      : 081277337405
 * Class      : Realisasi_akumulasi_model.php
 */
defined('BASEPATH') or exit('No direct script access allowed');

class Integrasi_sipedal_model extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
	}


	public function get_skpd($id_group)
	{	
		$id_instansi = id_instansi();
		
		if ($id_group==2) {
			$where 		=['kategori'=>'OPD','is_active'=>1, 'integrasi_sipedal_id_instansi!='=>''];
			
		}else{
			$where 		=['id_instansi'=>$id_instansi];

		}
			$q_instansi 	=$this->db->get_where('master_instansi' , $where);
		


		return $q_instansi;
	}

	public function cek_paket_sipedal($id_rup)
	{	
		$id_instansi = id_instansi();
		$q = $this->db->query("SELECT * from paket_pekerjaan where integrasi_sipedal_id_rup='$id_rup'");
		


		return $q;
	}
	public function list_paket_sbe($id_instansi, $tahun, $jenis)
	{	
		$q = $this->db->query("SELECT * from paket_pekerjaan where id_instansi='$id_instansi' and tahun = '$tahun' and jenis_paket='$jenis'");
		return $q;
	}
	public function list_paket_sbe_import_sipedal($id_instansi, $tahun, $jenis)
	{	
		$q = $this->db->query("SELECT * from paket_pekerjaan where id_instansi='$id_instansi' and tahun = '$tahun' and jenis_paket='$jenis' and integrasi_sipedal_id_rup!=''");
		return $q;
	}
	public function cek_paket_sbe_import_sipedal($id_instansi, $tahun)
	{	
		$q = $this->db->query("SELECT * from v_paket where id_instansi='$id_instansi' and tahun = '$tahun' and  integrasi_sipedal_id_rup=''");
		return $q;
	}

	public function list_paket_sbe_semua($tahun, $jenis)
	{	
		$q = $this->db->query("SELECT * from paket_pekerjaan where tahun = '$tahun' and jenis_paket='$jenis'");
		return $q;
	}

	public function konversi_sipedal_sbe($id_instansi)
	{	
		$q = $this->db->query("SELECT id_instansi from master_instansi where integrasi_sipedal_id_instansi='$id_instansi'");
		


		return $q->row_array();
	}

}
