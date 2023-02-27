<?php
/**
	* Author     : Alfikri, M.Kom
	* Created By : Alfikri, M.Kom
	* E-Mail     : alfikri.name@gmail.com
	* No HP      : 081277337405
	* Class      : Lokasi_kontrak_model.php
*/
defined('BASEPATH') OR exit('No direct script access allowed');

class Lokasi_kontrak_model extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
	}

	// public function koordinat_lokasi_kontrak()
	// {
	// 	$id_instansi = id_instansi();
	// 	$query  = $this->db->query("SELECT
	// 									lok.id_lokasi_paket_pekerjaan AS id_lokasi_paket_pekerjaan,
	// 									(SELECT full_name FROM master_users WHERE id_sub_instansi = sub_i.id_kpa) AS nama_kpa,
	// 									users.full_name AS nama_pptk,
	// 									paket.nama_paket AS nama_paket,
	// 									wil.nama AS kab_kota,
	// 									lok.latitude AS latitude,
	// 									lok.longitude AS longitude
	// 								FROM
	// 									lokasi_paket_pekerjaan lok
	// 									LEFT JOIN paket_pekerjaan paket ON lok.id_paket_pekerjaan = paket.id_paket_pekerjaan
	// 									LEFT JOIN master_users users ON paket.id_pptk = users.id_user
	// 									LEFT JOIN sub_instansi sub_i ON users.id_sub_instansi = sub_i.id_sub_instansi
	// 									LEFT JOIN master_wilayah wil ON lok.id_kab_kota = wil.kode
	// 								WHERE
	// 									lok.latitude IS NOT NULL
	// 									AND lok.id_instansi = {$id_instansi}");
	// 	return $query;
	// }
	public function koordinat_lokasi_kontrak()
	{
		$id_instansi = id_instansi();
		$tahun = tahun_anggaran();
		$query  = $this->db->query("SELECT 
			pp.id_paket_pekerjaan, kp.latitude, kp.longitude, kp.pelaksana, kp.nilai_kontrak, 
			pp.nama_paket, pp.pagu,
			mu.full_name as nama_pptk,
			msk.nama_sub_kegiatan,
			p.nama_provinsi, k.nama_kota
			from kontrak_pekerjaan kp 
			left join paket_pekerjaan pp on kp.id_paket_pekerjaan = pp.id_paket_pekerjaan
			left join provinsi p on kp.id_provinsi = p.id_provinsi
			left join kota k on kp.id_kota = k.id_kota
			left join master_users mu on pp.id_pptk = mu.id_user
			left join master_sub_kegiatan msk on pp.kode_rekening_sub_kegiatan = msk.kode_sub_kegiatan
			where 
			kp.id_instansi='$id_instansi' and kp.tahun='$tahun' and kp.latitude!=''");
		return $query;
	}
}