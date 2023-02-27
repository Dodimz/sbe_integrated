<?php

/**
 * Author     : Alfikri, M.Kom
 * Created By : Alfikri, M.Kom
 * E-Mail     : alfikri.name@gmail.com
 * No HP      : 081277337405
 * Class      : Validasi_fisik_model.php
 */
defined('BASEPATH') or exit('No direct script access allowed');

class Bantuan_model extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
	}

	public function tampilkan_menu_group($id_group)
	{
		$q = $this->db->query("SELECT 
			mg.id_menu,    
			m.menu_name, mcm.category_name
			from menu_groups mg 
			left join menu m on mg.id_menu = m.id_menu
			left join master_category_menu mcm on m.id_category_menu = mcm.id_category_menu
			where mg.id_group = '$id_group' AND m.is_active = '1' order by mcm.order_number, m.order_number");

		return $q;
	}




	public function max_data($table, $field)
	{
		$this->db->select_max($field);
		return $this->db->get($table);
	}

	public function no_ticket()
	{

		$id_group = $this->session->userdata('id_group');
		if ($id_group==5) {
			$max_data = $this->max_data('bantuan', 'kode_ticket');
			if ($max_data->num_rows() > 0) {
				$x 		= $max_data->row_array();
				$urut	= intval(substr($x['kode_ticket'], 4, 5)) + 1;
				$urut 	= "T-" . substr("00000", 1, (5 - strlen($urut))) . $urut;
			} else {
				$urut 	= "T-00001";
			}
		}else{
			$max_data = $this->max_data('bantuan_kab_kota', 'kode_ticket');
			if ($max_data->num_rows() > 0) {
				$x 		= $max_data->row_array();
				$urut	= intval(substr($x['kode_ticket'], 4, 5)) + 1;
				$urut 	= "T-" . substr("00000", 1, (5 - strlen($urut))) . $urut;
			} else {
				$urut 	= "T-00001";
			}
		}

		return $urut;
	}
	public function save_bantuan()
	{
		$post               = $this->input->post();
		$data = [
			'kode_ticket' => $this->no_ticket(), 
			'no_wa' => $post['wa'], 
			'id_menu' => $post['menu'], 
			'masalah' => $post['masalah'], 
			'deskripsi_masalah' => nl2br($post['keterangan']), 
			'id_user' => id_user(), 
			'id_instansi' => id_instansi(), 
			'id_group' => $this->session->userdata('id_group'), 
			'waktu_report' => timestamp(), 
			'status'=>'1'
			
		];
		$this->db->insert('bantuan', $data);
	}
	public function save_bantuan_kab_kota()
	{
		$post               = $this->input->post();
		$data = [
			'kode_ticket' => $this->no_ticket(), 
			'no_wa' => $post['wa'], 
			'id_menu' => $post['menu'], 
			'masalah' => $post['masalah'], 
			'deskripsi_masalah' => nl2br($post['keterangan']), 
			'id_user' => id_user(), 
			'id_provinsi' => 13, 
			'id_kota' => $this->session->userdata('id_kota'), 
			'id_group' => $this->session->userdata('id_group'), 
			'waktu_report' => timestamp(), 
			'status'=>'1'
			
		];
		$this->db->insert('bantuan_kab_kota', $data);
	}
	public function get_bantuan($id_bantuan)
	{
		$query = $this->db->query("SELECT 
			id_bantuan, kode_ticket, nama_instansi, pelapor,no_wa, category_name, menu_name, masalah, deskripsi_masalah,  waktu_report, penyebab, solusi, jenis_penyelesaian, publikasikan,  status from v_bantuan where id_bantuan = '$id_bantuan'
			")->row();
		
		return $query;
	}
	public function get_bantuan_kab_kota($id_bantuan)
	{
		$query = $this->db->query("SELECT 
			id_bantuan_kab_kota, kode_ticket, nama_kota, pelapor,no_wa, category_name, menu_name, masalah, deskripsi_masalah,  waktu_report, penyebab, solusi, jenis_penyelesaian, publikasikan,  status from v_bantuan_kab_kota where id_bantuan_kab_kota = '$id_bantuan'
			")->row();
		
		return $query;
	}

	

}
