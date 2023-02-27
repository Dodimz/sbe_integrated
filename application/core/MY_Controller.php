<?php
defined('BASEPATH') or exit('No direct script access allowed');

class My_Controller extends MX_Controller
{
	public function __construct()
	{
		parent::__construct();
		$class = $this->router->fetch_class();
		if (!$this->session->userdata('session_name') && $class != 'auth' && $class != 'public_dashboard' && $class != 'tutorial' && $class != 'android' && $class != 'sumbarsiap' && $class != 'beranda' && $class != 'replikasi' && $class != 'integrasi_replikasi' && $class != 'integrasi_sakatoplan' && $class != 'dashboard_pembangunan' && $class != 'synchronize' && $class != 'web_services') {
			redirect('auth');
		}

		$this->load->database('2020', true);
	}
	// Session
	public function sbe_group_name()
	{
		return $this->session->userdata('group_name');
	}
	// Global Function
	public function sbe_remove_end_of_string($data)
	{
		return substr($data, 0, strlen($data) - 1);
	}

	public function sbe_array_insert(&$array, $position, $insert) // Insert array into new position, remove old value based on position
	{
		if (is_int($position)) {
			unset($array[$position]);
			array_splice($array, $position, 0, $insert);
		} else {
			$pos   = array_search($position, array_keys($array));
			$array = array_merge(
				array_slice($array, 0, $pos),
				$insert,
				array_slice($array, $pos)
			);
		}
	}

	public function sbe_flatten(array $array)
	{
		$return = array();
		array_walk_recursive($array, function ($a) use (&$return) {
			$return[] = $a;
		});
		return $return;
	}

	public function sbe_encrypt_url_file($url)
	{
		$data = file_get_contents($url);
		if ($data !== false) {
			return 'data:application/pdf;base64,' . base64_encode($data);
		}
	}

	public function sbe_search_index($value, $array) // Search index of array with values
	{
		return (array_search($value, $array));
	}

	public function sbe_delete_files($target)
	{
		if (is_dir($target)) {
			$files = glob($target . '*', GLOB_MARK); //GLOB_MARK adds a slash to directories returned

			foreach ($files as $file) {
				$this->sbe_delete_files($file);
			}

			rmdir($target);
		} elseif (is_file($target)) {
			unlink($target);
		}
	}

	// Instansi
	public function sbe_nama_instansi($id_instansi = '')
	{
		if ($id_instansi) {
			$id = $id_instansi;
		} else {
			$id = id_instansi();
		}
		return $this->db->get_where('master_instansi', ['id_instansi' => $id])->row()->nama_instansi;
	}

	// User
	public function sbe_id_sub_instansi()
	{
		$id_kedudukan = $this->session->userdata('id_kedudukan');
		return $this->db->query('SELECT id_sub_instansi FROM sub_instansi WHERE id_sub_instansi = (SELECT min(id_parent) FROM sub_instansi WHERE id_kedudukan = ' . $id_kedudukan . ' AND id_instansi = ' . id_instansi() . ') AND id_kedudukan = 2')->row()->id_sub_instansi;
	}

	public function sbe_id_user()
	{
		return $this->session->userdata('id_user');
	}
	public function sbe_nama_user($id_user)
	{
		return $this->db->get_where('master_users', ['id_user' => $id_user])->row()->full_name;
	}

	public function sbe_instansi_helpdesk($id_user)
	{
		$instansi = $this->db->query('SELECT id_instansi FROM helpdesk_instansi WHERE id_user =' . $id_user);
		return $this->sbe_flatten($instansi->result_array());
	}

	// Realisasi Fisik
	public function sbe_nama_paket($id_paket_pekerjaan)
	{
		return $this->db->get_where('paket_pekerjaan', ['id_paket_pekerjaan' => $id_paket_pekerjaan])->row()->nama_paket;
	}

	public function cek_realisasi_fisik($id_paket_pekerjaan, $jenis_paket, $id_metode)
	{
		$realisasi_fisik = $this->db->get_where('realisasi_fisik', [
			'id_paket_pekerjaan' 	=> $id_paket_pekerjaan
		]);
		$dokumen 		 = $this->db->get_where('master_bobot', ['jenis_paket' => $jenis_paket, 'id_metode' => $id_metode]);

		$rea        = [];
		$dok        = [];
		$list_pelaksanaan = [];
		if ($realisasi_fisik->num_rows() > 0) {
			foreach ($realisasi_fisik->result() as $key => $value) {
				$rea[]      = $value->dokumen;
			}
		}

		if ($dokumen->num_rows() > 0) :
			$output['status'] 	= true;
			$output['message'] 	= 'Sukses';
			foreach ($dokumen->result() as $key => $value) {
				$dok[]          = $value->nama_dokumen;
			}

			$result_pelaksanaan = $this->db->get_where('vol_pelaksanaan_pekerjaan', ['id_paket_pekerjaan' => $id_paket_pekerjaan]);

			foreach ($result_pelaksanaan->result() as $key => $value) {
				// $list_pelaksanaan[] = 'PELAKSANAAN-' . $value->pelaksanaan_ke . '_' . $value->nama_pelaksanaan;
				 $list_pelaksanaan[] = 'PELAKSANAAN-' . $value->pelaksanaan_ke . '_' . $value->nama_pelaksanaan. '___' . $value->id_vol_pelaksanaan_pekerjaan;
			}

			$this->sbe_array_insert($dok, $this->sbe_search_index("PELAKSANAAN", $dok), $list_pelaksanaan);
		endif;

		$result = array_values(array_diff_assoc($dok, $rea));
		if (count($result) > 0) {
			return false;
		} else {
			return true;
		}
	}

	// Realisasi Keuangan
	public function sbe_tahun_anggaran()
	{
		return $this->db->get('config')->row()->tahun_anggaran;
	}

	public function sbe_bulan_aktif()
	{
		return $this->db->get('config')->row()->bulan_aktif;
	}

	public function sbe_tahapan_apbd()
	{
		return $this->db->get('config')->row()->tahapan_apbd;
	}

	public function sbe_nama_kegiatan($kode_rekening_kegiatan)
	{
		return $this->db->get_where('v_kegiatan_apbd', ['kode_rekening_kegiatan' => $kode_rekening_kegiatan, 'kode_tahap' => $this->sbe_tahapan_apbd()])->row()->nama_kegiatan;
	}

	// File System

	public function sbe_directory($primary_folder, $folder = [])
	{
		$output  = '';
		foreach ($folder as $value) {
			$output .= $value . '/';
		}

		return $primary_folder . $output;
	}
}
