<?php

/**
 * Author     : Alfikri, M.Kom
 * Created By : Alfikri, M.Kom
 * E-Mail     : alfikri.name@gmail.com
 * No HP      : 081277337405
 * Class      : Daftar_kontrak_model.php
 */
defined('BASEPATH') or exit('No direct script access allowed');

class Daftar_kontrak_model extends CI_Model
{
	protected $id_instansi;

	public function __construct()
	{
		parent::__construct();
		$this->id_instansi = id_instansi();
	}

	public function total_kontrak()
	{
		$tahun = tahun_anggaran();
		$q  = $this->db->query("SELECT
									COUNT(kontrak.id_kontrak_pekerjaan) AS total
								FROM
									kontrak_pekerjaan kontrak
								WHERE
									kontrak.id_instansi = '{$this->id_instansi}' and kontrak.tahun='$tahun'")->row()->total;
		return $q;
	}

	public function total_nilai_kontrak()
	{
		$tahun = tahun_anggaran();
		$q  = $this->db->query("SELECT
									SUM(kontrak.nilai_kontrak) AS total_nilai_kontrak
								FROM
									kontrak_pekerjaan kontrak
								WHERE
									kontrak.id_instansi = '{$this->id_instansi}' and kontrak.tahun='$tahun'")->row()->total_nilai_kontrak;
		return $q;
	}

	public function total_pagu_paket()
	{
		$tahun = tahun_anggaran();
		$q  = $this->db->query("SELECT
									SUM( paket.pagu ) AS total_pagu_paket
								FROM
									paket_pekerjaan paket 
								WHERE
									paket.id_instansi = '{$this->id_instansi}' 
									AND paket.kategori = 'KONTRUKSI' and 
									paket.tahun='$tahun'
								GROUP BY
									paket.id_instansi")->row_array();
		return $q;
	}

	public function get_kontrak($id_kontrak_pekerjaan)
	{
		
		$query  = $this->db->query("SELECT
								kp.id_kontrak_pekerjaan	,
								kp.id_paket_pekerjaan,
								kp.no_kontrak,
								kp.nilai_kontrak,
								kp.pelaksana,
								kp.tgl_awal_pelaksanaan,
								kp.tgl_akhir_pelaksanaan ,
								kp.latitude ,
								kp.longitude ,
								kp.id_kota ,
								kp.jenis_kontrak ,
								kp.id_kecamatan ,
								mi.nama_instansi,
								mu.full_name as nama_pptk, 

								msk.nama_sub_kegiatan,
								ski.kategori, ski.jenis_sub_kegiatan, ski.keterangan,
								pp.nama_paket, 
								pp.jenis_paket, 
								pp.kode_rekening_sub_kegiatan, 
								pp.kode_rekening_kegiatan, 
								pp.kode_rekening_program,
								pp.pagu as pagu_paket,
								m.metode, 
								pp.tahun,
								k.nama_kota, kec.nama_kecamatan, prov.nama_provinsi
								FROM
								kontrak_pekerjaan kp
								LEFT JOIN paket_pekerjaan pp ON kp.id_paket_pekerjaan = pp.id_paket_pekerjaan
								left join metode m on pp.id_metode = m.id_metode
								LEFT JOIN master_instansi mi ON kp.id_instansi = mi.id_instansi
								LEFT JOIN sub_kegiatan_instansi ski ON pp.kode_rekening_sub_kegiatan = ski.kode_sub_kegiatan 
								left join master_sub_kegiatan msk on pp.kode_rekening_sub_kegiatan = msk.kode_sub_kegiatan	
								left join users_sub_kegiatan usk on pp.kode_rekening_sub_kegiatan =usk.kode_rekening_sub_kegiatan and pp.id_instansi=usk.id_instansi and pp.tahun = usk.tahun_anggaran
								left join master_users mu on usk.id_user = mu.id_user
								left join kota k on kp.id_kota = k.id_kota 
								left join kecamatan kec on kp.id_kecamatan = kec.id_kecamatan
								left join provinsi prov on kp.id_provinsi = prov.id_provinsi
								WHERE
								kp.id_kontrak_pekerjaan = '$id_kontrak_pekerjaan'");
		return $query;
	}

	public function list_kontrak_per_skpd($id_instansi, $tahap, $tahun)
	{
		
		$query  = $this->db->query("SELECT
								
								kp.no_kontrak,
								kp.nilai_kontrak,
								kp.pelaksana,
								kp.tgl_awal_pelaksanaan,
								kp.tgl_akhir_pelaksanaan ,
								kp.latitude ,
								kp.longitude ,
								kp.id_kota ,
								kp.jenis_kontrak ,
								kp.id_kecamatan ,
								

								pp.nama_paket, 
								pp.jenis_paket, 
								pp.kode_rekening_sub_kegiatan, 
								pp.kode_rekening_kegiatan, 
								pp.kode_rekening_program,
								pp.pagu as pagu_paket,
								m.metode, 
								pp.tahun,
								k.nama_kota, kec.nama_kecamatan, prov.nama_provinsi
								FROM
								kontrak_pekerjaan kp
								LEFT JOIN paket_pekerjaan pp ON kp.id_paket_pekerjaan = pp.id_paket_pekerjaan
								left join metode m on pp.id_metode = m.id_metode
								
								left join kota k on kp.id_kota = k.id_kota 
								left join kecamatan kec on kp.id_kecamatan = kec.id_kecamatan
								left join provinsi prov on kp.id_provinsi = prov.id_provinsi
								WHERE
								kp.id_instansi = '$id_instansi' and kp.tahun='$tahun' ");
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
	public function saveedit_register_kontrak()
	{
		$post = $this->input->post();
		$data = [
			'id_instansi' 					=> $this->id_instansi,
			'no_kontrak' 						=> $this->no_kontrak() . '/BKPDR/' . $post['no_register_kontrak'],
			'tgl_register_kontrak'	=> time(),
			'pelaksana'							=> $post['pelaksana'],
			'tgl_awal_pelaksanaan'	=> $post['tgl_awal_pelaksanaan'],
			'tgl_akhir_pelaksanaan'	=> $post['tgl_akhir_pelaksanaan'],
			'nilai_kontrak' 				=> $post['nilai_kontrak'],

			'jenis_kontrak'	=> $post['jenis_kontrak'],
			'latitude' 				=> $post['latitude_ok'],
			'longitude' 				=> $post['longitude_ok'],
				'id_provinsi' 				=> 13,
			'id_kota' 				=> sbe_crypt($post['kab_kota'], 'D'),
			'id_kecamatan' 				=> sbe_crypt($post['kecamatan'], 'D'),
			'updated_on' 						=> time(),
			'updated_by' 						=> id_user()
		];
		$where = [
			'id_kontrak_pekerjaan' => sbe_crypt($post['id_kontrak'],'D')
		];
		return $this->db->update('kontrak_pekerjaan', $data, $where);
	}
}
