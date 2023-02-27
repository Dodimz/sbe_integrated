<?php
/**
 * Author     : Alfikri, M.Kom
 * Created By : Alfikri, M.Kom
 * E-Mail     : alfikri.name@gmail.com
 * No HP      : 081277337405
 * Class      : Instansi_model.php
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Kab_kota_model extends CI_Model
{
	public function __construct()
	{
		// parent::__construct();
		// $this->load->library('my_form_validation');
	}
	public function saveedit_ckk($id_ckk)
	{
		$post = $this->input->post();
		$data = [
			'token_integrasi_replikasi'				=> $post['token_integrasi'],
			'replikasi'				=> $post['replikasi'],
			'url_replikasi'				=> $post['link'],
			'sumber_data_sumbar_siap'				=> $post['sdss'],
			'integrasi_replikasi '				=> $post['integrasi'],
		
		];
		$where = ['id_config_kab_kota'=>$id_ckk];
		$this->db->update('config_kab_kota', $data, $where);
	}
	public function saveedit_instansi_kab_kota($id_instansi)
	{
		$post = $this->input->post();
		$data = [
			'kode_opd'				=> $post['kode'],
			'nama_instansi'				=> $post['nama'],
			'alamat_instansi'				=> $post['alamat'],
			'email_instansi'				=> $post['email'],
			'kategori'				=> 'OPD',
			'telpon'				=> $post['telp'],
			'website'				=> $post['web'],
			'is_parent'				=> 'T',
			'position'				=> 'h',
			'is_active'				=> $post['status'],
			'bulan_mulai_realisasi'				=> $post['bulan_mulai'],
			'bulan_akhir_realisasi'				=> $post['bulan_selesai'],

			'updated_on'				=> timestamp(),
			'updated_by'				=> id_user(),
		];
		$where = ['id_instansi'=>$id_instansi];
		$this->db->update('master_instansi_kab_kota', $data, $where);
	}
	public function get_config_kab_kota($id_config)
	{
		return $this->db->query("SELECT * from config_kab_kota ckk 
			left join kota k on ckk.id_kota =k.id_kota where ckk.id_config_kab_kota='$id_config'");
	}


}