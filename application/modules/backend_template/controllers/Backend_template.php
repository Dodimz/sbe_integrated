<?php

/**
 * Author     : Alfikri, M.Kom
 * Created By : Alfikri, M.Kom
 * E-Mail     : alfikri.name@gmail.com
 * No HP      : 081277337405
 * Class      : Backend_template.php
 */
defined('BASEPATH') or exit('No direct script access allowed');

class Backend_template extends MY_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model([
			'backend_template/backend_template_model' 	=> 'backend_template_model',
			'datatables_model'                  		=> 'datatables_model'
		]);
	}

	public function set_theme()
	{
		if (!$this->input->is_ajax_request()) {
			show_404();
		} else {
			$check 	= $this->db->get_where('users_theme', ['id_user' => id_user()]);
			if ($this->input->post('kategori') == 'header') {
				$insert = [
					'header_class' 	=> $this->input->post('header_class'),
					'sidebar_class' => '',
					'id_user' 		=> id_user()
				];
				$update = [
					'header_class' 	=> $this->input->post('header_class')
				];
				if ($check->num_rows() > 0) {
					$result = $this->db->update('users_theme', $update, ['id_user' => id_user()]);
				} else {
					$result = $this->db->insert('users_theme', $insert);
				}
			} else {
				$insert = [
					'header_class' 	=> '',
					'sidebar_class' => $this->input->post('sidebar_class'),
					'id_user' 		=> id_user()
				];
				$update = [
					'sidebar_class' => $this->input->post('sidebar_class')
				];
				if ($check->num_rows() > 0) {
					$result = $this->db->update('users_theme', $update, ['id_user' => id_user()]);
				} else {
					$result = $this->db->insert('users_theme', $insert);
				}
			}
		}

		echo json_encode($result);
	}

	public function get_paket_ditolak()
	{
		if (!$this->input->is_ajax_request()) {
			show_404();
		} else {
			$output = [
				'status' 	=> false,
				'data' 		=> [],
				'total' 	=> 0
			];

			$result = $this->backend_template_model->get_paket_ditolak();
			if ($result->num_rows() > 0) {
				$output['total'] = $result->num_rows();
				foreach ($result->result() as $key => $value) {
					$output['data'][$key]['id'] 			= sbe_crypt($value->id_realisasi_fisik);
					$output['data'][$key]['nama_pptk'] 		= $value->full_name;
					$output['data'][$key]['nama_kegiatan'] 	= $value->nama_sub_kegiatan;
					$output['data'][$key]['nama_paket'] 	= $value->nama_paket;
					$vol = $value->id_vol_pelaksanaan_pekerjaan;
					if ($vol!='') {
						$dokumen = $value->dokumen;
						$pecah = explode('___', $dokumen);
						$dok = $pecah[0];
					}else{
						$dok = $value->dokumen;
					}
					$output['data'][$key]['dokumen'] 		= $dok;
					$output['data'][$key]['masalah'] 		= $value->masalah;
					$output['data'][$key]['solusi'] 		= $value->solusi;
				}

				$output['status'] = true;
			}

			echo json_encode($output);
		}
	}
}
