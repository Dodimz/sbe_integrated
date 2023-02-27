<?php
/**
 * Author     : Alfikri, M.Kom
 * Created By : Alfikri, M.Kom
 * E-Mail     : alfikri.name@gmail.com
 * No HP      : 081277337405
 * Class      : Instansi_model.php
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Instansi_model extends CI_Model
{
	public function __construct()
	{
		// parent::__construct();
		// $this->load->library('my_form_validation');
	}
	public function save_instansi()
	{
		$post = $this->input->post();
		$id_config=id_config();
		$data = [
			'kode_opd'				=> $post['kode'],
			'id_parent'				=> $post['asisten'],
			'nama_instansi'				=> $post['nama'],
			'alamat_instansi'				=> $post['alamat'],
			'email_instansi'				=> $post['email'],
			'kategori'				=> 'OPD',
			'telpon'				=> $post['telp'],
			'website'				=> $post['web'],
			'is_parent'				=> 'T',
			'position'				=> 'h',
			'is_active'				=> $post['status'],
			'id_config'				=> $id_config,
			'bulan_mulai_realisasi'				=> $post['bulan_mulai'],
			'bulan_akhir_realisasi'				=> $post['bulan_selesai'],

			'created_on'				=> timestamp(),
			'created_by'				=> id_user(),
		];
		$this->db->insert('master_instansi', $data);
	}
	public function save_instansi_teknis($kode)
	{
		$post = $this->input->post();
		$id_config=id_config();
		$data = [
			'kode_instansi_teknis'				=> $kode,
			'id_instansi'				=> id_instansi(),
			'nama_instansi_teknis'				=> $post['nama'],
			'id_provinsi'				=> 13,
			'id_kota'				=> $post['kota'],
			'jenis_teknis'				=> $post['jenis'],
			'is_active'				=> $post['status'],
			'created_on'				=> timestamp(),
			'created_by'				=> id_user(),
		];
		$this->db->insert('instansi_pembantu_teknis', $data);
	}
	public function saveedit_instansi_teknis($kode, $id_instansi_pembantu_teknis)
	{
		$post = $this->input->post();
		$id_config=id_config();
		$data = [
			'kode_instansi_teknis'				=> $kode,
			'id_instansi'				=> id_instansi(),
			'nama_instansi_teknis'				=> $post['nama'],
			'id_provinsi'				=> 13,
			'id_kota'				=> $post['kota'],
			'jenis_teknis'				=> $post['jenis'],
			'is_active'				=> $post['status'],
			'created_on'				=> timestamp(),
			'created_by'				=> id_user(),
		];
		$where = ['id_instansi_pembantu_teknis'=>$id_instansi_pembantu_teknis];
		$this->db->update('instansi_pembantu_teknis', $data, $where);
	}
	public function save_instansi_kab_kota()
	{
		$post = $this->input->post();
		$id_kota = $this->session->userdata('id_kota');
		$id_provinsi = $this->session->userdata('id_provinsi');
		$data = [
			'kode_opd'				=> $post['kode'],
			'id_provinsi'				=> $id_provinsi,
			'id_kota'				=> $id_kota,
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

			'created_on'				=> timestamp(),
			'created_by'				=> id_user(),
		];
		$this->db->insert('master_instansi_kab_kota', $data);
	}
	public function saveedit_instansi($id_instansi)
	{
		$post = $this->input->post();
		$data = [
			'kode_opd'				=> $post['kode'],
			'id_parent'				=> $post['asisten'],
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
		$this->db->update('master_instansi', $data, $where);
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
	public function get_instansi($id_instansi)
	{
		return $this->db->get_where('master_instansi', ['id_instansi'=>$id_instansi]);
	}
	public function get_instansi_teknis($id_instansi)
	{
		return $this->db->get_where('instansi_pembantu_teknis', ['id_instansi_pembantu_teknis'=>$id_instansi]);
	}
	public function get_instansi_kab_kota($id_instansi)
	{
		return $this->db->get_where('master_instansi_kab_kota', ['id_instansi'=>$id_instansi]);
	}






	public function cek_kode_instansi($id_instansi, $kode)
	{
		$q = $this->db->query("SELECT * from instansi_pembantu_teknis where kode_instansi_teknis like '%$kode%' and id_instansi = '$id_instansi'");
		return $q;
	}
	public function cek_kode_instansi_edit($id_instansi, $kode, $id_instansi_pembantu_teknis)
	{
		$q = $this->db->query("SELECT * from instansi_pembantu_teknis where kode_instansi_teknis like '%$kode%' and id_instansi = '$id_instansi' and id_instansi_pembantu_teknis!='$id_instansi_pembantu_teknis'");
		return $q;
	}
	public function cek_urutan_instansi_teknis($id_instansi)
	{
		$q = $this->db->query("SELECT max(CONVERT(kode_instansi_teknis, SIGNED)) as max_kode from instansi_pembantu_teknis where id_instansi = '$id_instansi'");
		return $q;
	}




}