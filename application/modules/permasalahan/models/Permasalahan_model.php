<?php

/**
 * Author     : Alfikri, M.Kom
 * Created By : Alfikri, M.Kom
 * E-Mail     : alfikri.name@gmail.com
 * No HP      : 081277337405
 * Class      : Master_paket_model.php
 */
defined('BASEPATH') or exit('No direct script access allowed');

class Permasalahan_model extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
		$this->load->library('my_form_validation');
	}


	public function save_permasalahan_skpd_kab_kota()
	{
		$post = $this->input->post();
		$data = [
			'id_instansi'				=> $post['id_instansi'],
			'id_provinsi'				=>  $this->session->userdata('id_provinsi'),
			'id_kota'				=> $this->session->userdata('id_kota'),
			'tahun'				=> $post['tahun'],
			'kode_tahap'				=> $post['tahap'],
			'permasalahan'				=> $post['permasalahan'],
			'created_on'				=> timestamp(),
			'created_by'				=> id_user(),
		];
		$this->db->insert('permasalahan_skpd_kab_kota', $data);
	}
	public function saveedit_permasalahan_skpd_kab_kota()
	{
		$post = $this->input->post();
		$data = [
			'permasalahan'				=> nl2br($post['permasalahan']),

			'updated_on'				=> timestamp(),
			'updated_by'				=> id_user(),
		];
		$where = ['id_permasalahan_skpd_kab_kota'=>$post['id_permasalahan']];
		$this->db->update('permasalahan_skpd_kab_kota', $data, $where);
	}
	public function save_solusi_permasalahan_skpd_kab_kota()
	{
		$post = $this->input->post();
		$data = [
			'id_instansi'				=> $post['id_instansi'],
			'id_provinsi'				=>  $this->session->userdata('id_provinsi'),
			'id_kota'				=> $this->session->userdata('id_kota'),
			'tahun'				=> $post['tahun'],
			'kode_tahap'				=> $post['tahap'],
			'solusi'				=> $post['solusi'],
			'solusi_by'				=> $this->session->userdata('id_group'),
			'created_on'				=> timestamp(),
			'created_by'				=> id_user(),
		];
		$this->db->insert('solusi_permasalahan_skpd_kab_kota', $data);
	}
	public function saveedit_solusi_permasalahan_skpd_kab_kota()
	{
		$post = $this->input->post();
		$data = [
			'solusi'				=> nl2br($post['solusi']),
			'updated_on'				=> timestamp(),
			'updated_by'				=> id_user(),
		];
		$where = [
			'id_solusi_permasalahan_skpd_kab_kota'				=> $post['id_solusi']
		];
		$this->db->update('solusi_permasalahan_skpd_kab_kota', $data, $where);
	}



}
