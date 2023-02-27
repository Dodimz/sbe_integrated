<?php

/**
 * Author     : Alfikri, M.Kom
 * Created By : Alfikri, M.Kom
 * E-Mail     : alfikri.name@gmail.com
 * No HP      : 081277337405
 * Class      : Master_paket_model.php
 */
defined('BASEPATH') or exit('No direct script access allowed');

class Master_paket_model extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
		$this->load->library('my_form_validation');
	}

	public function rules_update()
	{
		return [
			[
				'field' => 'nama_paket',
				'label' => 'Nama Paket',
				'rules' => 'required|trim'
			],
			[
				'field' => 'jenis_paket',
				'label' => 'Jenis Paket',
				'rules' => 'required'
			],
			[
				'field' => 'pagu',
				'label' => 'Pagu Paket',
				'rules' => 'required|trim'
			]
		];
	}

	public function total_paket_pekerjaan()
	{
		return $this->db->get_where('paket_pekerjaan', ['id_instansi' => id_instansi()])->num_rows();
	}

	public function total_jenis_paket_pekerjaan($jenis_paket)
	{
		return $this->db->get_where('paket_pekerjaan', ['id_instansi' => id_instansi(), 'jenis_paket' => $jenis_paket])->num_rows();
	}

	public function total_paket_kontruksi()
	{
		return $this->db->get_where('paket_pekerjaan', ['id_instansi' => id_instansi(), 'jenis_paket' => 'PENYEDIA', 'kategori' => 'KONTRUKSI'])->num_rows();
	}

	public function lokasi_paket($id_paket_pekerjaan, $id_pptk, $kode_rekening_kegiatan)
	{
		$hasil 	= !empty($this->input->post('id_kab_kota')) ? count($this->input->post('id_kab_kota')) : 0;
		$output = [];
		for ($i = 0; $i < $hasil; $i++) {
			$output[] = [
				'id_paket_pekerjaan' 	=> $id_paket_pekerjaan,
				'id_instansi'			=> id_instansi(),
				'id_pptk'				=> $id_pptk,
				'kode_rekening_kegiatan' => $kode_rekening_kegiatan,
				'id_kab_kota'			=> $_POST['id_kab_kota'][$i]
			];
		}
		$this->db->insert_batch('lokasi_paket_pekerjaan', $output);
	}

	public function save_master_paket()
	{
		$post = $this->input->post();
		$data = [
			'id_instansi'				=> id_instansi(),
			'id_pptk' 					=> $post['id_pptk'],
			'kode_bidang_urusan' 					=> $post['kode_bidang_urusan'],
			'kode_rekening_program' 					=> $post['kode_program'],
			'kode_rekening_kegiatan' 					=> $post['kode_rekening_kegiatan'],
			'kode_rekening_sub_kegiatan ' 					=> $post['kode_rekening_sub_kegiatan'],
		
			'tahun'					=> tahun_anggaran(),
			'nama_paket'				=> $post['nama_paket'],
			'jenis_paket'				=> $post['jenis_paket'],
			'kategori'					=> $post['jenis_paket'] == 'PENYEDIA' ? $post['kategori'] : '-',
			'id_metode'				=> !empty($post['id_metode']) ? $post['id_metode'] : 0,
			'pagu'						=> $post['pagu'],
			'created_on'				=> timestamp(),
			'updated_on'				=> timestamp(),
			'created_by' 				=> id_user(),
			'updated_by' 				=> id_user(),
			'input_by' 				=> "Manual Input"
		];
		$this->db->insert('paket_pekerjaan', $data);
	}

	public function update_master_paket($id_paket_pekerjaan)
	{
		$post = $this->input->post();
		$data = [
			'id_instansi'				=> id_instansi(),
			'id_pptk' 					=> $post['id_pptk'],
			'kode_bidang_urusan' 					=> $post['kode_bidang_urusan'],
			'kode_rekening_program' 					=> $post['kode_program'],
			'kode_rekening_kegiatan' 					=> $post['kode_rekening_kegiatan'],
			'kode_rekening_sub_kegiatan ' 					=> $post['kode_rekening_sub_kegiatan'],
			'tahun'					=> tahun_anggaran(),
			'nama_paket'				=> $post['nama_paket'],
			'jenis_paket'				=> $post['jenis_paket'],
			'kategori'					=> $post['jenis_paket'] == 'PENYEDIA' ? $post['kategori'] : '-',
			'id_metode'				=> !empty($post['id_metode']) ? $post['id_metode'] : 0,
			'pagu'						=> $post['pagu'],
			'created_on'				=> timestamp(),
			'updated_on'				=> timestamp(),
			'created_by' 				=> id_user(),
			'updated_by' 				=> id_user()
		];
		$this->db->update('paket_pekerjaan', $data, ['id_paket_pekerjaan' => $id_paket_pekerjaan]);
	}

	public function save_pelaksanaan($data)
	{
		$this->db->insert_batch('vol_pelaksanaan_pekerjaan', $data);
	}
	public function total_volume($id_paket_pekerjaan)
	{
		$q = $this->db->query("SELECT id_vol_pelaksanaan_pekerjaan from vol_pelaksanaan_pekerjaan where id_paket_pekerjaan = '$id_paket_pekerjaan'")->num_rows();
		return $q;
	}

	public function update_pelaksanaan($data)
	{
		$this->db->update_batch('vol_pelaksanaan_pekerjaan', $data, 'id_paket_pekerjaan');
	}
	public function volume_paket($id_paket)
	{
		$q = $this->db->query("SELECT * from vol_pelaksanaan_pekerjaan where id_paket_pekerjaan='$id_paket' order by id_vol_pelaksanaan_pekerjaan asc");
		return $q;
	}

	public function pptk($id_user_top_parent)
	{
		$q = $this->db->query("SELECT u.id_user AS id_user,
    								  u.id_parent AS id_parent,
    								  u.id_instansi AS id_instansi,
    								  u.id_sub_instansi AS id_sub_instansi,
    								  u.id_kedudukan AS id_kedudukan,
    								  mi.nama_instansi AS nama_instansi,
    								  (SELECT master_users.id_user
    								   FROM master_users
    								   WHERE master_users.id_sub_instansi = si.id_kpa) AS id_user_top_parent,
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
    							 	  uk.kode_urusan AS kode_urusan,
    							 	  keg.kode_tahap AS kode_tahap,
    							 	  keg.pagu AS pagu,
    							 	  keg.nama_kegiatan AS nama_kegiatan,
    							 	  count(pkt.id_paket_pekerjaan) AS jml_paket,
    							 	  anggaran_terpakai(pkt.id_paket_pekerjaan) as anggaran_terpakai,
    							 	  count(IF((pkt.kategori = 'KONTRUKSI'), 1, NULL ) ) AS jml_paket_kontruksi
    					  	   FROM
    					  		 	  users_kegiatan uk
    					  		 	  LEFT JOIN kegiatan_apbd keg ON uk.kode_rekening_kegiatan = keg.kode_rekening
    					  		 	  AND uk.kode_urusan = keg.kode_urusan
    					  		 	  LEFT JOIN paket_pekerjaan pkt ON uk.id_user = pkt.id_pptk
    					  				   		AND uk.kode_rekening_kegiatan = pkt.kode_rekening_kegiatan
    					  	   WHERE  uk.id_user = {$id_user} AND uk.id_instansi = {$id_instansi} AND keg.kode_tahap = {$kode_tahap}
    					  	   GROUP BY uk.id_user_kegiatan");
		return $q;
	}

	public function sub_kegiatan_pptk($id_user, $id_instansi, $kode_tahap)
	{
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
			ski.kategori as kategori,
			ski.jenis_sub_kegiatan as jenis_sub_kegiatan,
			ski.keterangan as keterangan,
			  count(pkt.id_paket_pekerjaan) AS jml_paket

			  FROM
    					  		 	  users_sub_kegiatan usk
    					  		 	  LEFT JOIN sub_kegiatan_instansi ski ON usk.kode_rekening_sub_kegiatan = ski.kode_sub_kegiatan
    					  		 	  LEFT JOIN paket_pekerjaan pkt ON usk.id_user = pkt.id_pptk
    					  				   		AND usk.kode_rekening_sub_kegiatan = pkt.kode_rekening_sub_kegiatan
    					  			  LEFT JOIN master_sub_kegiatan msk on substr(usk.kode_rekening_sub_kegiatan,1,15) = msk.kode_sub_kegiatan
    					  	   WHERE  usk.id_user = '{$id_user}' AND usk.id_instansi = '{$id_instansi}' AND ski.kode_tahap = '{$kode_tahap}'
    					  	   GROUP BY usk.id_user_sub_kegiatan





		");
		return $q;
	}
	public function anggaran_kegiatan_terpakai($kode_sub_kegiatan,$kode_kegiatan,$kode_program,$kode_bidang_urusan)
	{
		$tahap = tahapan_apbd();
		$id_instansi = id_instansi();
		$q = $this->db->query("SELECT anggaran_terpakai('$kode_sub_kegiatan','$id_instansi') as anggaran_terpakai, pagu from  v_sub_kegiatan_apbd 
						where 	id_instansi='$id_instansi' and
								kode_rekening_sub_kegiatan='$kode_sub_kegiatan' and
								kode_rekening_kegiatan='$kode_kegiatan' and
								kode_rekening_program='$kode_program' and
								kode_bidang_urusan='$kode_bidang_urusan' and
								kode_tahap ='$tahap'
");
		return $q->row();
	}

	public function get_id_realisasi_fisik($id_paket_pekerjaan, $id_volume){
		$q = $this->db->query("SELECT id_realisasi_fisik from realisasi_fisik where id_paket_pekerjaan = '$id_paket_pekerjaan' and id_vol_pelaksanaan_pekerjaan ='$id_volume'");
		return $q;
	}
	public function get_file_evidence($id_paket_pekerjaan, $id_realisasi_fisik){
		$q = $this->db->query("SELECT id_realisasi_fisik, file_dokumen from realisasi_fisik where id_paket_pekerjaan = '$id_paket_pekerjaan' and id_realisasi_fisik = '$id_realisasi_fisik'");
		return $q;
	}
	public function get_file_evidence_laporan($id_paket_pekerjaan){
		$q = $this->db->query("SELECT id_realisasi_fisik, file_dokumen from realisasi_fisik where id_paket_pekerjaan = '$id_paket_pekerjaan' and dokumen_key = 'LAPORAN'");
		return $q;
	}

	 public function kode_opd_instansi($id_instansi)
    {
       $q = $this->db->query("SELECT kode_opd from master_instansi where id_instansi = '$id_instansi'")->row();
       return $q;
    }
	 public function get_pptk($kode_rekening)
    {
       $q = $this->db->query("SELECT id_user from users_kegiatan where kode_rekening_kegiatan = '$kode_rekening'")->row();
       return $q;
    }

     public function cek_metode($jenis, $id_metode)
    {
       $q = $this->db->query("SELECT metode from metode where id_metode = '$id_metode' and jenis_paket='$jenis'")->num_rows();
       return $q;
    }


}
