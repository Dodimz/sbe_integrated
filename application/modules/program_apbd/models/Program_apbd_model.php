<?php

/**
 * Author     : Alfikri, M.Kom
 * Created By : Alfikri, M.Kom
 * E-Mail     : alfikri.name@gmail.com
 * No HP      : 081277337405
 * Class      : Program_apbd_model.php
 */
defined('BASEPATH') or exit('No direct script access allowed');

class Program_apbd_model extends CI_Model
{
	protected $table_paket_pekerjaan = 'paket_pekerjaan';
	protected $view_program_apbd  	 = 'v_program_apbd';

	public function __construct()
	{
		parent::__construct();
	}

	public function anggaran_apbd()
	{
		$where = [
			'id_instansi' 	=> id_instansi(),
			'kode_tahap' 	=> tahapan_apbd()
		];
		$this->db->select('SUM(pagu) AS pagu');
		return (float) $this->db->get_where($this->view_program_apbd, $where)->row()->pagu;
	}

	// Program APBD

	public function total_program_apbd()
	{
		$where = [
			'id_instansi' 	=> id_instansi(),
			'kode_tahap' 	=> tahapan_apbd()
		];
		return (int) $this->db->get_where($this->view_program_apbd, $where)->num_rows();
	}

	public function belanja_pegawai_prog()
	{
		$where = [
			'id_instansi' 	=> id_instansi(),
			'kode_tahap' 	=> tahapan_apbd()
		];
		$this->db->select('SUM(belanja_pegawai) AS belanja_pegawai');
		return (float) $this->db->get_where($this->view_program_apbd, $where)->row()->belanja_pegawai;
	}

	public function belanja_barang_jasa_prog()
	{
		$where = [
			'id_instansi' 	=> id_instansi(),
			'kode_tahap' 	=> tahapan_apbd()
		];
		$this->db->select('SUM(belanja_barang_jasa) AS belanja_barang_jasa');
		return (float) $this->db->get_where($this->view_program_apbd, $where)->row()->belanja_barang_jasa;
	}

	public function belanja_modal_prog()
	{
		$where = [
			'id_instansi' 	=> id_instansi(),
			'kode_tahap' 	=> tahapan_apbd()
		];
		$this->db->select('SUM(belanja_modal) AS belanja_modal');
		return (float) $this->db->get_where($this->view_program_apbd, $where)->row()->belanja_modal;
	}
}
