<?php

/**
 * Author     : Alfikri, M.Kom
 * Created By : Alfikri, M.Kom
 * E-Mail     : alfikri.name@gmail.com
 * No HP      : 081277337405
 * Class      : Buat_kontrak_model.php
 */
defined('BASEPATH') or exit('No direct script access allowed');

class Buat_kontrak_model extends CI_Model
{
	private $id_instansi;
	public function __construct()
	{
		parent::__construct();
		$this->id_instansi = id_instansi();
	}

	public function paket_pekerjaan()
	{
		$tahun = tahun_anggaran();
		$query  = $this->db->query("SELECT
																	id_paket_pekerjaan,
																	nama_paket 
																FROM
																	paket_pekerjaan 
																WHERE
																	id_instansi = {$this->id_instansi}
																	AND jenis_paket != 'RUTIN'
																	AND tahun = '$tahun' 
																	AND id_paket_pekerjaan NOT IN (
																	SELECT
																		id_paket_pekerjaan 
																	FROM
																		kontrak_pekerjaan)")->result();
		return $query;
	}
	public function kab_kota($id_provinsi)
	{
		$query  = $this->db->query("SELECT * from kota where id_provinsi='$id_provinsi'")->result();
		return $query;
	}
	public function kecamatan($id_kota)
	{
		$query  = $this->db->query("SELECT * from kecamatan where id_kota='$id_kota'")->result();
		return $query;
	}

	public function detail_paket($id_paket_pekerjaan)
	{
		$query  = $this->db->query("SELECT
							paket.id_paket_pekerjaan AS id_paket_pekerjaan,
							paket.nama_paket,
							paket.id_pptk AS id_pptk,
							user.full_name AS nama_pptk,
							keg.nama_sub_kegiatan AS nama_kegiatan,
							keg.pagu AS pagu_kegiatan,
							paket.pagu AS pagu_paket
						FROM
							paket_pekerjaan paket 
							LEFT JOIN v_sub_kegiatan_apbd keg ON paket.kode_rekening_sub_kegiatan = keg.kode_rekening_sub_kegiatan
							left join users_sub_kegiatan usk on keg.kode_rekening_sub_kegiatan = usk.kode_rekening_sub_kegiatan and keg.tahun=usk.tahun_anggaran and keg.kode_tahap=usk.kode_tahap 
							LEFT JOIN master_users user ON usk.id_user = user.id_user
						WHERE
							paket.id_instansi = {$this->id_instansi}
							AND
							paket.id_paket_pekerjaan = {$id_paket_pekerjaan}");
		return $query;
	}

	public function max_data($table, $field)
	{
		$this->db->select_max($field);
		return $this->db->get($table);
	}

	public function no_kontrak()
	{
		$max_data = $this->max_data('kontrak_pekerjaan', 'no_kontrak');
		if ($max_data->num_rows() > 0) {
			$x 		= $max_data->row_array();
			$urut	= intval(substr($x['no_kontrak'], 4, 5)) + 1;
			$urut 	= "REG-" . substr("00000", 1, (5 - strlen($urut))) . $urut;
		} else {
			$urut 	= "REG-00001";
		}

		return $urut;
	}

	public function save_register_kontrak()
	{
		$post = $this->input->post();
		$data = [
			'id_instansi' 					=> $this->id_instansi,
			'id_pptk' 							=> sbe_crypt($post['id_pptk'], 'D'),
			'id_paket_pekerjaan'		=> sbe_crypt($post['id_paket'], 'D'),
			'no_kontrak' 						=> $this->no_kontrak() . '/BKPDR/' . $post['no_register_kontrak'],
			'tgl_register_kontrak'	=> time(),
			'pelaksana'							=> $post['pelaksana'],
			'tgl_awal_pelaksanaan'	=> $post['tgl_awal_pelaksanaan'],
			'jenis_kontrak'	=> $post['jenis_kontrak'],
			'tgl_akhir_pelaksanaan'	=> $post['tgl_akhir_pelaksanaan'],
			'nilai_kontrak' 				=> $post['nilai_kontrak'],
			'id_provinsi' 				=> 13,
			'id_kota' 				=> sbe_crypt($post['kab_kota'], 'D'),
			'id_kecamatan' 				=> sbe_crypt($post['kecamatan'], 'D'),
			'latitude' 				=> $post['latitude_ok'],
			'longitude' 				=> $post['longitude_ok'],
			'tahun' 				=> tahun_anggaran(),
			'updated_on' 						=> time(),
			'updated_by' 						=> id_user()
		];
		return $this->db->insert('kontrak_pekerjaan', $data);
	}

	public function lokasi_kontrak($id_paket_pekerjaan)
	{
		$query  = $this->db->query("SELECT
																	lok.id_lokasi_paket_pekerjaan AS id_lokasi,
																	wil.nama AS kab_kota,
																	lok.latitude AS latitude,
																	lok.longitude AS longitude 
																FROM
																	lokasi_paket_pekerjaan lok
																	LEFT JOIN master_wilayah wil ON lok.id_kab_kota = wil.kode 
																WHERE
																	LENGTH( wil.kode ) = 5 
																	AND lok.id_instansi = {$this->id_instansi} 
																	AND lok.id_paket_pekerjaan = {$id_paket_pekerjaan}");
		return $query;
	}

	public function status_lokasi($id_paket_pekerjaan)
	{
		$query  = $this->db->query("SELECT
										COUNT( IF ( latitude IS NULL, 1, NULL ) ) AS kosong 
									FROM
										lokasi_paket_pekerjaan lok 
									WHERE
										lok.id_paket_pekerjaan = {$id_paket_pekerjaan}")->row()->kosong;
		return $query;
	}
}
