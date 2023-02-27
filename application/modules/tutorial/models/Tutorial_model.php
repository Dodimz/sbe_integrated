<?php
/**
 * Author     : Alfikri, M.Kom
 * Created By : Alfikri, M.Kom
 * E-Mail     : alfikri.name@gmail.com
 * No HP      : 081277337405
 * Class      : Instansi_model.php
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Tutorial_model extends CI_Model
{
	public function __construct()
	{
		// parent::__construct();
		// $this->load->library('my_form_validation');
	}
	public function save_tutorial()
	{
		$post = $this->input->post();
		$data = [
			'id_group'				=> $post['akses'],
			'urutan'				=> $post['urutan'],
			'judul'				=> $post['judul'],
			'keterangan'				=> $post['keterangan'],
			'tipe'				=> $post['tipe'],
			'status'				=> $post['status'],
			'link '				=> $post['link'],

			'created_on'				=> timestamp(),
			'created_by'				=> id_user(),
		];
		$this->db->insert('tutorial', $data);
	}
	public function saveedit_tutorial()
	{
		$post = $this->input->post();
		$data = [
			'id_group'				=> $post['akses'],
			'urutan'				=> $post['urutan'],
			'judul'				=> $post['judul'],
			'keterangan'				=> $post['keterangan'],
			'tipe'				=> $post['tipe'],
			'status'				=> $post['status'],
			'link '				=> $post['link'],

			'updated_on'				=> timestamp(),
			'updated_by'				=> id_user(),
		];
		$where = [
			'id_tutorial'				=> sbe_crypt($this->input->post('id_tutorial'), 'D'),
			
		];
		$this->db->update('tutorial', $data, $where);
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
	public function get_instansi_kab_kota($id_instansi)
	{
		return $this->db->get_where('master_instansi_kab_kota', ['id_instansi'=>$id_instansi]);
	}




	public function saveedit_anggaran_sub_kegiatan($where)
	{
		$post = $this->input->post();
		$r_bo = $post['bo_bp'] + $post['bo_bbj'] + $post['bo_bs'] + $post['bo_bh'] + $post['bo_bbs'];
		$r_bm = $post['bm_bmt'] + $post['bm_bmpm'] + $post['bm_bmgb'] + $post['bm_bmjji'] + $post['bm_bmatl'] + $post['bm_bmatb'];
		$r_btt = $post['btt'];
		$r_bt = $post['bt_bbh'] + $post['bt_bbk'];
		;
		$data = [
			
			'id_provinsi'				=> $this->session->userdata('id_provinsi'),
			'id_kota'				=> $this->session->userdata('id_kota'),
			'id_instansi'				=> sbe_crypt($this->input->post('id_instansi'), 'D'),
			'kode_tahap'				=> $post['tahap'],
			'bo_bp'				=> $post['bo_bp'],
			'bo_bbj'				=> $post['bo_bbj'],
			'bo_bs'				=> $post['bo_bs'],
			'bo_bh'				=> $post['bo_bh'],
			'bo_bbs'				=> $post['bo_bbs'],
			'bm_bmt'				=> $post['bm_bmt'],
			'bm_bmpm'				=> $post['bm_bmpm'],
			'bm_bmgb'				=> $post['bm_bmgb'],
			'bm_bmjji'				=> $post['bm_bmjji'],
			'bm_bmatl'				=> $post['bm_bmatl'],
			'bm_bmatb'				=> $post['bm_bmatb'],
			'btt'				=> $post['btt'],
			'bt_bbh'				=> $post['bt_bbh'],
			'bt_bbk'				=> $post['bt_bbk'],

			'realisasikan_bo'				=> $r_bo > 0  ? 1:0,
			'realisasikan_bm'				=> $r_bm > 0  ? 1:0,
			'realisasikan_btt'				=> $r_btt > 0  ? 1:0,
			'realisasikan_bt'				=> $r_bt > 0  ? 1:0,
			
			'tahun'				=> tahun_anggaran(),
			'created_on'				=> timestamp(),
			'created_by'				=> id_user(),
		];
		$this->db->update('anggaran_instansi_kab_kota', $data, $where);
	}



	public function save_anggaran_sub_kegiatan()
	{
		$post = $this->input->post();

		$r_bo = $post['bo_bp'] + $post['bo_bbj'] + $post['bo_bs'] + $post['bo_bh'] + $post['bo_bbs'];
		$r_bm = $post['bm_bmt'] + $post['bm_bmpm'] + $post['bm_bmgb'] + $post['bm_bmjji'] + $post['bm_bmatl'] + $post['bm_bmatb'];
		$r_btt = $post['btt'];
		$r_bt = $post['bt_bbh'] + $post['bt_bbk'];
		;
		$data = [
			
			'id_provinsi'				=> $this->session->userdata('id_provinsi'),
			'id_kota'				=> $this->session->userdata('id_kota'),
			'id_instansi'				=> sbe_crypt($this->input->post('id_instansi'), 'D'),
			'kode_tahap'				=> $post['tahap'],
			'bo_bp'				=> $post['bo_bp'],
			'bo_bbj'				=> $post['bo_bbj'],
			'bo_bs'				=> $post['bo_bs'],
			'bo_bh'				=> $post['bo_bh'],
			'bo_bbs'				=> $post['bo_bbs'],
			'bm_bmt'				=> $post['bm_bmt'],
			'bm_bmpm'				=> $post['bm_bmpm'],
			'bm_bmgb'				=> $post['bm_bmgb'],
			'bm_bmjji'				=> $post['bm_bmjji'],
			'bm_bmatl'				=> $post['bm_bmatl'],
			'bm_bmatb'				=> $post['bm_bmatb'],
			'btt'				=> $post['btt'],
			'bt_bbh'				=> $post['bt_bbh'],
			'bt_bbk'				=> $post['bt_bbk'],

			'realisasikan_bo'				=> $r_bo > 0  ? 1:0,
			'realisasikan_bm'				=> $r_bm > 0  ? 1:0,
			'realisasikan_btt'				=> $r_btt > 0  ? 1:0,
			'realisasikan_bt'				=> $r_bt > 0  ? 1:0,
		
			'tahun'				=> tahun_anggaran(),
			'created_on'				=> timestamp(),
			'created_by'				=> id_user(),
		];
		$this->db->insert('anggaran_instansi_kab_kota', $data);
	}
}