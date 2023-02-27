<?php

/**
 * Author     : Alfikri, M.Kom
 * Created By : Alfikri, M.Kom
 * E-Mail     : alfikri.name@gmail.com
 * No HP      : 081277337405
 * Class      : Realisasi_fisik_model.php
 */
defined('BASEPATH') or exit('No direct script access allowed');

class Realisasi_fisik_model extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
	}

	// public function pptk($id_user_top_parent)
	// {
	// 	$q 	= $this->db->query("SELECT u.id_user AS id_user,
	// 														u.id_parent AS id_parent,
	// 														u.id_instansi AS id_instansi,
	// 														u.id_sub_instansi AS id_sub_instansi,
	// 														u.id_kedudukan AS id_kedudukan,
	// 														mi.nama_instansi AS nama_instansi,
	// 														(	SELECT 
	// 																master_users.id_user 
	// 															FROM 
	// 																master_users
	// 															WHERE
	// 																master_users.id_sub_instansi = si.id_kpa) AS id_user_top_parent,
	// 															si.id_top_parent AS id_top_parent,
	// 															si.nama_sub_instansi AS nama_sub_instansi,
	// 															u.full_name AS full_name,
	// 															u.foto AS foto,
	// 														(	SELECT
	// 																count(0) 
	// 															FROM 
	// 																users_kegiatan
	// 															WHERE 
	// 																users_kegiatan.id_user = u.id_user) AS jml_kegiatan,
	// 															(	SELECT 
	// 																	count(0) 
	// 																FROM 
	// 																	paket_pekerjaan
	// 																WHERE 
	// 																	paket_pekerjaan.id_pptk = u.id_user) AS jml_paket,
	// 																(	SELECT 
	// 																		count(0) 
	// 																	FROM 
	// 																		paket_pekerjaan
	// 																	WHERE
	// 																		paket_pekerjaan.id_pptk = u.id_user 
	// 																		AND 
	// 																		paket_pekerjaan.kategori = 'KONTRUKSI') AS jml_paket_kontruksi
	// 																	FROM 
	// 																		master_users u 
	// 																		LEFT JOIN master_instansi mi 
	// 																		ON u.id_instansi = mi.id_instansi
	// 																		LEFT JOIN sub_instansi si 
	// 																		ON u.id_sub_instansi = si.id_sub_instansi
	// 																		LEFT JOIN master_kedudukan mk 
	// 																		ON u.id_kedudukan = mk.id_kedudukan
	// 																		WHERE u.id_kedudukan = 3 
	// 																		HAVING id_user_top_parent = {$id_user_top_parent}");
	// 	return $q;
	// }

	public function pptk($id_user_top_parent)
	{
		$tahun = tahun_anggaran();
		$q = $this->db->query("SELECT u.id_user AS id_user,
    								  u.id_parent AS id_parent,
    								  u.id_instansi AS id_instansi,
    								  u.id_sub_instansi AS id_sub_instansi,
    								  u.id_kedudukan AS id_kedudukan,
    								  mi.nama_instansi AS nama_instansi,
    								  (SELECT master_users.id_user
    								   FROM master_users
    								   WHERE master_users.id_sub_instansi = si.id_kpa limit 1) AS id_user_top_parent,
    								  si.id_top_parent AS id_top_parent,
    								  si.nama_sub_instansi AS nama_sub_instansi,
    								  u.full_name AS full_name,
    								  u.foto AS foto,
    								  (SELECT count(0)
    								   FROM users_kegiatan
    								   WHERE users_kegiatan.id_user = u.id_user) AS jml_kegiatan,
    								  (SELECT count(0)
    								   FROM paket_pekerjaan
    								   WHERE paket_pekerjaan.id_pptk = u.id_user) AS jml_paket,
    								  (SELECT count(0)
    								   FROM paket_pekerjaan
    								   WHERE paket_pekerjaan.id_pptk = u.id_user
    								         AND
    								         paket_pekerjaan.kategori = 'KONTRUKSI') AS jml_paket_kontruksi
    						   FROM master_users u
    						   		LEFT JOIN master_instansi mi
    						   		  	   ON u.id_instansi = mi.id_instansi
    						   		LEFT JOIN sub_instansi si
    						   		  	   ON u.id_sub_instansi = si.id_sub_instansi
    						   		LEFT JOIN master_kedudukan mk
    						   		  	   ON u.id_kedudukan = mk.id_kedudukan
    						   WHERE u.id_kedudukan = 3
    						   HAVING id_user_top_parent = {$id_user_top_parent}");
		return $q;
	}

	public function kegiatan_pptk($id_user, $id_instansi, $kode_tahap)
	{
		$q = $this->db->query("SELECT uk.id_user_kegiatan AS id_user_kegiatan,
									uk.id_instansi AS id_instansi,
									uk.id_user AS id_user,
									uk.kode_rekening_kegiatan AS kode_rekening_kegiatan,
									keg.kode_tahap AS kode_tahap,
									keg.nama_kegiatan AS nama_kegiatan,
									count(pkt.id_paket_pekerjaan) AS jml_paket,
									count(IF((pkt.kategori = 'KONTRUKSI'), 1, NULL ) ) AS jml_paket_kontruksi
								FROM 
									users_kegiatan uk
									LEFT JOIN kegiatan_apbd keg 
									ON uk.kode_rekening_kegiatan = keg.kode_rekening
									LEFT JOIN paket_pekerjaan pkt 
									ON uk.id_user = pkt.id_pptk
										AND uk.kode_rekening_kegiatan = pkt.kode_rekening_kegiatan
								WHERE
									uk.id_user = {$id_user}
									AND uk.id_instansi = {$id_instansi}
									AND keg.kode_tahap = {$kode_tahap} 
								GROUP BY 
									uk.id_user_kegiatan");
		return $q;
	}

	public function sub_kegiatan_pptk($id_user, $id_instansi)
	{
		$tahun = tahun_anggaran();
		$q = $this->db->query("
SELECT 
			usk.id_user_sub_kegiatan AS id_user_sub_kegiatan,
			usk.id_instansi AS id_instansi,
			usk.id_user AS id_user,
			usk.kode_rekening_sub_kegiatan AS kode_rekening_sub_kegiatan,
			usk.kode_rekening_kegiatan AS kode_rekening_kegiatan,
			usk.kode_rekening_program AS kode_rekening_program,
			usk.kode_bidang_urusan AS kode_bidang_urusan,
			msk.nama_sub_kegiatan AS nama_sub_kegiatan,
			ski.kode_tahap as kode_tahap,
			usk.tahun_anggaran as tahun,
			ski.kategori as kategori,
			ski.jenis_sub_kegiatan as jenis_sub_kegiatan,
			ski.keterangan as keterangan,
			ski.status,
			  count(pkt.id_paket_pekerjaan) AS jml_paket

			  FROM
    					  		 	  users_sub_kegiatan usk
    					  		 	 LEFT JOIN sub_kegiatan_instansi ski ON usk.kode_rekening_sub_kegiatan = ski.kode_sub_kegiatan and usk.id_instansi=ski.id_instansi and usk.tahun_anggaran = ski.tahun and usk.kode_tahap = ski.kode_tahap
    					  		 	  LEFT JOIN paket_pekerjaan pkt ON usk.id_user = pkt.id_pptk
    					  				   		AND usk.kode_rekening_sub_kegiatan = pkt.kode_rekening_sub_kegiatan
    					  			  LEFT JOIN master_sub_kegiatan msk on substr(usk.kode_rekening_sub_kegiatan,1,15) = msk.kode_sub_kegiatan
    					  	   WHERE  usk.id_user = '{$id_user}' AND usk.id_instansi = '{$id_instansi}' and usk.tahun_anggaran = '$tahun'
    					  	   GROUP BY usk.id_user_sub_kegiatan





		");
		return $q;
	}
	public function dokumen_realisasi($id_paket_pekerjaan)
	{
		$id_instansi = id_instansi();
		$q  = $this->db->query("SELECT
                                    rea_fisik.dokumen AS dokumen,
                                    rea_fisik.file_dokumen AS file,
                                    rea_fisik.nilai AS nilai,
                                    rea_fisik.status AS status,
                                    rea_fisik.id_realisasi_fisik as id_realisasi_fisik,
                                    rea_fisik.id_vol_pelaksanaan_pekerjaan,
                                    rea_fisik.auto_evidence,
                                    rea_fisik.integrasi_sipedal_id_rup,

                                    vol.nama_pelaksanaan
                                FROM
                                    realisasi_fisik rea_fisik 
                                    left join vol_pelaksanaan_pekerjaan vol on rea_fisik.id_vol_pelaksanaan_pekerjaan = vol.id_vol_pelaksanaan_pekerjaan 
                                WHERE
                                    rea_fisik.id_instansi = {$id_instansi}
                                    AND
                                    rea_fisik.id_paket_pekerjaan = '{$id_paket_pekerjaan}'");
		return $q;
	}
	public function total_nilai_realisasi($id_paket_pekerjaan)
	{
		$id_instansi = id_instansi();
		$q  = $this->db->query("SELECT
                                    id_pptk, kode_rekening_kegiatan, nama_paket, total_nilai_evidence(id_paket_pekerjaan) as total_nilai
                                FROM
                                     paket_pekerjaan pp
                                WHERE
                                    pp.id_paket_pekerjaan = '{$id_paket_pekerjaan}'");
		return $q->row();
	}
	public function helpdesk()
	{
		$id_instansi = id_instansi();
		$q  = $this->db->query("SELECT hi.id_instansi, mu.full_name as helpdesk from helpdesk_instansi hi 
			left join master_users mu on hi.id_user = mu.id_user 
			where hi.id_instansi = '$id_instansi'
                                    ");
		return $q;
	}
}
