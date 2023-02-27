<?php
/**
 * Author     : Alfikri, M.Kom
 * Created By : Alfikri, M.Kom
 * E-Mail     : alfikri.name@gmail.com
 * No HP      : 081277337405
 * Class      : Instansi_model.php
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Config_model extends CI_Model
{
	public function __construct()
	{
		// parent::__construct();
		// $this->load->library('my_form_validation');
	}
	
	public function simpanedit_config_kab_kota($id_provinsi, $id_kota)
	{
		$post = $this->input->post();
		$data = [
			'id_config'				=> $post['id_config'],
			'tahapan_apbd'				=> $post['tahap'],
			'id_pj'				=> $post['pj'],
			'ibukota_kab_kota'				=> $post['ibukota'],
			'updated_on'				=> timestamp(),
			'updated_by'				=> id_user(),			
		];
		$where = ['id_kota'=>$id_kota,'id_provinsi'=>$id_provinsi];
		$this->db->update('config_kab_kota', $data, $where);
	}
	public function config_kab_kota($id_provinsi, $id_kota)
	{
		return $this->db->query("SELECT ck.*, k.nama_kota, p.nama_provinsi,
		mikk.nama_instansi, pj.nama, pj.nip, pj.jabatan 
			from config_kab_kota ck left join kota k on ck.id_kota = k.id_kota
			left join provinsi p on ck.id_provinsi=p.id_provinsi
			left join pj_pelaporan_kab_kota pj on ck.id_pj=pj.id_pj
			left join master_instansi_kab_kota mikk on pj.id_instansi = mikk.id_instansi
			where ck.id_provinsi='$id_provinsi' and ck.id_kota='$id_kota'
			");
	}
	public function get_instansi_kab_kota($id_instansi)
	{
		return $this->db->get_where('master_instansi_kab_kota', ['id_instansi'=>$id_instansi]);
	}


}