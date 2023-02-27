<?php

/**
 * Author     : Alfikri, M.Kom
 * Created By : Alfikri, M.Kom
 * E-Mail     : alfikri.name@gmail.com
 * No HP      : 081277337405
 * Class      : Validasi_fisik_model.php
 */
defined('BASEPATH') or exit('No direct script access allowed');

class Statistika_model extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
	}

	

	public function statistika($id_instansi, $tahun, $tahap)
	{
		
		if ($tahap ==2) {
			$query_pagu_total = "total_anggaran_skpd_awal(mi.id_instansi, $tahun) as total_pagu";
			$query_ski = "and kode_tahap='$tahap'";
			$query_paket = "and kode_tahap='$tahap'";
		}else{
			$query_pagu_total = "total_anggaran_skpd_perubahan(mi.id_instansi, $tahun) as total_pagu";
			$query_ski = "and status=1";
			$query_paket = "and status=1";

		}
		// $query_pagu_total = "total_anggaran_skpd_awal(mi.id_instansi, $tahun) as total_pagu";
			// $query_ski = "and kode_tahap='$tahap'";
		$q  = $this->db->query("SELECT mi.id_instansi, mi.nama_instansi, mu.full_name as helpdesk, mu.nohp, hi.tahun,
			(SELECT count(id_paket_pekerjaan) from paket_pekerjaan where id_instansi = mi.id_instansi and tahun='$tahun' $query_paket) as total_paket, 
			(SELECT count(id_paket_pekerjaan) from paket_pekerjaan where id_instansi = mi.id_instansi and jenis_paket='SWAKELOLA' and tahun='$tahun' $query_paket) as total_paket_swakelola, 
			(SELECT count(id_paket_pekerjaan) from paket_pekerjaan where id_instansi = mi.id_instansi and jenis_paket='PENYEDIA' and tahun='$tahun' $query_paket) as total_paket_penyedia,
			(SELECT count(id_paket_pekerjaan) from paket_pekerjaan where id_instansi = mi.id_instansi and jenis_paket='RUTIN' and tahun='$tahun' $query_paket) as total_paket_rutin,
		
			(SELECT count(DISTINCT kode_program) from sub_kegiatan_instansi where id_instansi = mi.id_instansi and tahun='$tahun' $query_ski) as total_program,
			(SELECT count(DISTINCT kode_kegiatan) from sub_kegiatan_instansi where id_instansi = mi.id_instansi and tahun='$tahun' $query_ski) as total_kegiatan,
			(SELECT count(DISTINCT kode_sub_kegiatan) from sub_kegiatan_instansi where id_instansi = mi.id_instansi and tahun='$tahun' $query_ski) as total_sub_kegiatan,

			
			(SELECT count(id_paket_pekerjaan) from kontrak_pekerjaan where id_instansi = mi.id_instansi and  tahun='$tahun') as total_kontrak,


			$query_pagu_total
			


		
		 from master_instansi mi 
		 left join helpdesk_instansi hi on mi.id_instansi=hi.id_instansi
		 left join master_users mu on hi.id_user=mu.id_user
		 where mi.id_instansi='$id_instansi'");
		return $q;
	}

	public function get_instansi_by_id()
	{
		$id_instansi = id_instansi();
		$q  = $this->db->query("SELECT
									hi.id_instansi,
									mi.nama_instansi,
									mi.is_active,
									COUNT( pp.id_paket_pekerjaan ) AS jml_paket,
									( SELECT COUNT( IF ( nilai = 0, 1, NULL )) FROM realisasi_fisik WHERE id_instansi = hi.id_instansi ) AS belum_validasi,
									(
									SELECT
										COUNT( IF ( rf.nilai = 0 AND pp.jenis_paket = 'SWAKELOLA', 1, NULL ) ) 
									FROM
										realisasi_fisik rf
										LEFT JOIN paket_pekerjaan pp ON rf.id_paket_pekerjaan = pp.id_paket_pekerjaan 
									WHERE
										rf.id_instansi = hi.id_instansi 
									) AS belum_validasi_swakelola,
									(
									SELECT
										COUNT( IF ( rf.nilai = 0 AND pp.jenis_paket = 'PENYEDIA', 1, NULL ) ) 
									FROM
										realisasi_fisik rf
										LEFT JOIN paket_pekerjaan pp ON rf.id_paket_pekerjaan = pp.id_paket_pekerjaan 
									WHERE
										rf.id_instansi = hi.id_instansi 
									) AS belum_validasi_penyedia 
								FROM
									master_instansi mi
									LEFT JOIN helpdesk_instansi hi ON mi.id_instansi = hi.id_instansi
									LEFT JOIN paket_pekerjaan pp ON hi.id_instansi = pp.id_instansi 
								WHERE
									mi.id_instansi = '{$id_instansi}' 
								GROUP BY
									hi.id_instansi");
		return $q;
	}

	public function get_kpa($id_sub_instansi)
	{
		$q  = $this->db->query("SELECT
									mu.full_name,
									si.nama_sub_instansi
								FROM
									sub_instansi si
									LEFT JOIN master_users mu ON si.id_kpa = mu.id_sub_instansi 
								WHERE
									si.id_sub_instansi = '{$id_sub_instansi}'");
		return $q->row_array();
	}

	public function get_program_kegiatan($kode_rekening_kegiatan)
	{
		$q  = $this->db->query("SELECT
									mp.nama_program,
									mk.nama_kegiatan 
								FROM
									kegiatan_apbd ka
									LEFT JOIN master_program mp ON ka.id_program = mp.id_program
									LEFT JOIN master_kegiatan mk ON ka.id_kegiatan = mk.id_kegiatan 
								WHERE
									ka.kode_rekening = '{$kode_rekening_kegiatan}'");
		return $q->row_array();
	}

	public function jml_dok_realisasi($id_paket_pekerjaan)
	{
		$q  = $this->db->query("SELECT
									count( rf.dokumen ) AS jml
								FROM
									realisasi_fisik rf 
								WHERE
									id_paket_pekerjaan = '{$id_paket_pekerjaan}'");
		return $q->row()->jml;
	}

	public function get_dok_realisasi($id_paket_pekerjaan)
	{
		$q  = $this->db->query("SELECT
									rf.id_realisasi_fisik,
									rf.id_paket_pekerjaan,
									rf.id_vol_pelaksanaan_pekerjaan,
									pp.jenis_paket,
									pp.id_metode,
									rf.dokumen,
									rf.file_dokumen,
									rf.nilai,
									rf.status,
									rf.created_on,
									rf.updated_on,
									vol.pelaksanaan_ke,
									vol.nama_pelaksanaan
								FROM
									realisasi_fisik rf
									LEFT JOIN paket_pekerjaan pp ON rf.id_paket_pekerjaan = pp.id_paket_pekerjaan 
									left join vol_pelaksanaan_pekerjaan vol on rf.id_vol_pelaksanaan_pekerjaan =  vol.id_vol_pelaksanaan_pekerjaan
								WHERE
									rf.id_paket_pekerjaan = '$id_paket_pekerjaan'");
		return $q;
	}

	public function update_nilai($mode_penilaian)
	{
		$id_user = id_user();
		$post = $this->input->post();
		$data = [
			'nilai' 	=> $post['dokumen'] != 'PELAKSANAAN' && $post['status'] != 'Ditolak' ? $this->bobot($post['jenis_paket'], $post['id_metode'], $post['dokumen']) : (empty($post['nilai']) ? 0 : $post['nilai']),
			'status' 	=> $post['status'],
			'masalah' 	=> $post['status'] == 'Ditolak' ? $post['masalah'] : 'Approve',
			'solusi' 	=> $post['status'] == 'Ditolak' ? $post['solusi'] : '',
			'validate_by' =>$id_user,
			'mode_penilaian' =>$mode_penilaian
		];
		return $this->db->update('realisasi_fisik', $data, ['id_realisasi_fisik' => $post['id_realisasi_fisik']]);
	}

	public function get_id_instansi($id_realisasi_fisik)
	{
		return $this->db->get_where('realisasi_fisik', [
			'id_realisasi_fisik' => $id_realisasi_fisik
		])->row_array()['id_instansi'];
	}

	public function bobot($jenis_paket, $id_metode, $nama_dokumen)
	{
		$where = [
			'jenis_paket' 	=> $jenis_paket,
			'id_metode' 	=> $id_metode,
			'nama_dokumen'	=> $nama_dokumen
		];
		$bobot = $this->db->get_where('master_bobot', $where);

		return $bobot->row()->bobot;
	}
	public function nilai_paket($id_paket)
	{
		$q = $this->db->query("SELECT sum(nilai) as totalnilai from realisasi_fisik where id_paket_pekerjaan = '{$id_paket}' ")->row();
	

		return $q;
	}
	public function total_volume($id_paket)
	{
		$q = $this->db->query("SELECT count(id_vol_pelaksanaan_pekerjaan) as total_volume from vol_pelaksanaan_pekerjaan where id_paket_pekerjaan = '$id_paket' ")->row();
	

		return $q;
	}

	public function get_status_validasi_paket($id_instansi, $id_paket_pekerjaan, $dok)
	{
		$query  = $this->db->query("SELECT
																	COUNT( dokumen ) AS tot_dok,
																	SUM(nilai)AS nilai,
																	COUNT(IF(STATUS = 'Belum Validasi', 1, NULL )) AS biru,
																	COUNT(IF(STATUS = 'Sudah Validasi', 1, NULL )) AS hijau,
																	COUNT(IF(STATUS = 'Ditolak', 1, NULL )) AS merah
																FROM
																	realisasi_fisik 
																WHERE
																	id_instansi = {$id_instansi} 
																	AND id_paket_pekerjaan = {$id_paket_pekerjaan} 
																	GROUP BY id_paket_pekerjaan")->row_array();
		$status = '';
		if ($query['nilai'] > 0) {
			if ($query['biru'] == $query['tot_dok']) {
				$status = 'btn-primary';
			} elseif ($query['hijau'] == $query['tot_dok']) {
				if ($query['nilai']==100) {
					$status = 'btn-success';
				}else{
					$status = 'btn-outline-success';
				}
			} elseif ($query['merah'] == $query['tot_dok']) {
				$status = 'btn-danger';
			} elseif ($query['biru'] + $query['hijau'] == $query['tot_dok']) {
				if ($query['biru']>0) {
					$status = 'btn-outline-warning';
				}else{
					$status = 'btn-warning';
				}
			} 
			elseif ($query['biru'] + $query['merah'] == $query['tot_dok']) {
				if ($query['biru']>0) {
					$status = 'btn-outline-danger';
				}else{
					$status = 'btn-danger';
				}
			} elseif ($query['hijau'] + $query['merah'] == $query['tot_dok']) {
					$status = 'btn-danger';
			} elseif ($query['biru'] + $query['hijau'] + $query['merah'] == $query['tot_dok']) {
				if ($query['biru']>0) {
					$status = 'btn-outline-warning';
				}else{
					$status = 'btn-warning';
				}
			}
		} elseif ($query['nilai'] <= 0 && $query['hijau'] == $query['tot_dok']) {
			$status = 'btn-outline-success';
			//error
		} elseif ($query['nilai'] <= 0 && $query['biru'] == $query['tot_dok']) {
			$status = 'btn-primary';
		} elseif ($query['nilai'] <= 0 && $query['merah'] == $query['tot_dok']) {
			$status = 'btn-danger';
		} elseif ($query['nilai'] <= 0 && $query['biru'] + $query['hijau'] == $query['tot_dok']) {
			if ($query['biru']>0) {
					$status = 'btn-outline-warning';
				}else{
					$status = 'btn-warning';
				}
		} elseif ($query['nilai'] <= 0 && $query['biru'] + $query['merah'] == $query['tot_dok']) {
			if ($query['biru']>0) {
				$status = 'btn-outline-danger';
			}else{
				$status = 'btn-danger';
			}
		} elseif ($query['nilai'] <= 0 && $query['hijau'] + $query['merah'] == $query['tot_dok']) {
			$status = 'btn-danger';
		} elseif ($query['nilai'] <= 0 && $query['biru'] + $query['hijau'] + $query['merah'] == $query['tot_dok']) {
			if ($query['biru']>0) {
				$status = 'btn-outline-danger';
			}else{
				$status = 'btn-danger';
			}
		} else {
			$status = 'btn-primary';
		}

		return $status;
	}
}
