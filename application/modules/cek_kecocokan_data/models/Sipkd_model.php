<?php
/**
	* Author     : Alfikri, M.Kom
	* Created By : Alfikri, M.Kom
	* E-Mail     : alfikri.name@gmail.com
	* No HP      : 081277337405
	* Class      : Web_services.php
*/
defined('BASEPATH') OR exit('No direct script access allowed');

class Sipkd_model extends CI_Model
{
	protected $table_master_instansi    = 'master_instansi';
	protected $table_master_program     = 'master_program';
	protected $view_total_program_apbd  = 'v_total_program_apbd';
	protected $view_total_kegiatan_apbd = 'v_total_kegiatan_apbd';

	public function total_opd()
	{
		$result = $this->db->get_where($this->table_master_instansi,['kategori' => 'OPD'])->num_rows();
		return $result;
	}

	public function total_m_program()
	{
		$result = $this->db->get($this->table_master_program)->num_rows();
		return $result;
	}

	public function total_m_kegiatan()
	{

	}

	public function total_program()
	{
		
	}

	public function total_kegiatan()
	{
		
	}
}