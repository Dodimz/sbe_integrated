<?php

/**
 * Author     : Alfikri, M.Kom
 * Created By : Alfikri, M.Kom
 * E-Mail     : alfikri.name@gmail.com
 * No HP      : 081277337405
 * Class      : Master_paket_model.php
 */
defined('BASEPATH') or exit('No direct script access allowed');

class Data_apbd_kab_kota_model extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
		$this->load->library('my_form_validation');
	}

	public function anggaran_total_kab_kota($id_kota, $tahun, $tahap)
	{
		$q = $this->db->query("SELECT 
			sum(bo_bp + bo_bbj + bo_bs + bo_bh + bo_bbs) as bo,
			sum( bm_bmt + bm_bmpm + bm_bmgb + bm_bmjji + bm_bmatl + bm_bmatb) as bm,
			sum(btt) as btt,
			sum(bt_bbh + bt_bbk) as bt,
			sum(bo_bp + bo_bbj + bo_bs + bo_bh + bo_bbs + bm_bmt + bm_bmpm + bm_bmgb + bm_bmjji + bm_bmatl + bm_bmatb + btt + bt_bbh + bt_bbk) as total
			 from anggaran_instansi_kab_kota where kode_tahap='$tahap' and tahun='$tahun' and id_kota='$id_kota'")->row_array();
		return $q;
	}
	



	public function saveedit_anggaran_instansi_kab_kota($where)
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



	public function save_anggaran_instansi_kab_kota()
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
