<?php

/**
 * Author     : Alfikri, M.Kom
 * Created By : Alfikri, M.Kom
 * E-Mail     : alfikri.name@gmail.com
 * No HP      : 081277337405
 * Class      : Master_paket_model.php
 */
defined('BASEPATH') or exit('No direct script access allowed');

class Data_apbd_model extends CI_Model
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

	public function total()
	{
		
		$program 	= $this->db->get('master_program')->num_rows();
		$kegiatan 	=$this->db->get('master_kegiatan')->num_rows();
		$subkeg 	= $this->db->get('master_sub_kegiatan')->num_rows();
		$bu 		=$this->db->get('master_bidang_urusan')->num_rows();
		$data = [
			'program'=>$program,
			'kegiatan'=>$kegiatan,
			'subkeg'=>$subkeg,
			'bu'=>$bu
		];
		return $data;
	}
	public function total_data_per_instansi($id_instansi)
	{
		$tahap 		= tahapan_apbd();
		$tahun = tahun_anggaran();

		if ($tahap == 4 ) {
			
			$where 		=['id_instansi'=>$id_instansi, 'tahun'=>$tahun];
			$program 	= $this->db->get_where('v_program_apbd_perubahan' , $where)->num_rows();
			$kegiatan 	=$this->db->get_where('v_kegiatan_apbd_perubahan' , $where)->num_rows();
		}else{
			$where 		=['id_instansi'=>$id_instansi, 'tahun'=>$tahun, 'kode_tahap'=>$tahap];
			$program 	= $this->db->get_where('v_program_apbd_awal' , $where)->num_rows();
			$kegiatan 	=$this->db->get_where('v_kegiatan_apbd_awal' , $where)->num_rows();
		}
	
		$where_ski 		=['id_instansi'=>$id_instansi, 'status'=>1, 'tahun'=>$tahun];	

		$subkeg 	=$this->db->get_where('v_sub_kegiatan_apbd' , $where_ski)->num_rows();
		$data = [
			'program'=>$program,
			'kegiatan'=>$kegiatan,
			'subkeg'=>$subkeg
		
		];
		return $data;
	}
	public function statistika($id_instansi, $tahun, $tahap)
	{
		
		$where 		=['id_instansi'=>$id_instansi, 'kode_tahap'=>$tahap, 'tahun'=>$tahun];	
		$program 	= $this->db->get_where('v_program_apbd' , $where)->num_rows();
		$kegiatan 	=$this->db->get_where('v_kegiatan_apbd' , $where)->num_rows();
		$subkeg 	=$this->db->get_where('v_sub_kegiatan_apbd' , $where)->num_rows();
		$data = [
			'program'=>$program,
			'kegiatan'=>$kegiatan,
			'subkeg'=>$subkeg
		
		];
		return $data;
	}
	public function cek_sub_kegiatan_instansi( $kode_sub_kegiatan, $kode_kegiatan, $kode_program,  $id_instansi)
	{
		$tahun_anggaran	= tahun_anggaran();
		 $where      = [
		 	'kode_sub_kegiatan' => $kode_sub_kegiatan, 
		 	'id_instansi'=>$id_instansi, 
		 	'kode_kegiatan'=>$kode_kegiatan, 
		 	'kode_program'=>$kode_program, 
		 	'status'=>1, 
		 	'tahun'=>$tahun_anggaran
		 ];
         $sub_kegiatan    = $this->db->get_where('sub_kegiatan_instansi', $where);
		return $sub_kegiatan;
	}
	public function cek_kode_ski($id_instansi, $kode_ski, $tahap)
	{
		$q = $this->db->query("SELECT * from sub_kegiatan_instansi where kode_sub_kegiatan like '%$kode_ski%' and id_instansi = '$id_instansi' and kode_tahap='$tahap'");
		return $q;
	}
	public function cek_urutan_ski_teknis($kode_ski, $id_instansi, $tahap)
	{
		$q = $this->db->query("SELECT max(CONVERT(tambahan_kode_sub_kegiatan, SIGNED)) as max_kode from sub_kegiatan_instansi where kode_sub_kegiatan like '%$kode_ski%' and id_instansi = '$id_instansi' and kode_tahap='$tahap' and input_by_tambahan_kode_sub_kegiatan='Automatic Input'");
		return $q;
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

	public function save_anggaran_sub_kegiatan()
	{
		$post = $this->input->post();

		$r_bo = $post['bo_bp'] + $post['bo_bbj'] + $post['bo_bs'] + $post['bo_bh'];
		$r_bm = $post['bm_bmt'] + $post['bm_bmpm'] + $post['bm_bmgb'] + $post['bm_bmjji'] + $post['bm_bmatl'];
		$r_btt = $post['btt'];
		$r_bt = $post['bt_bbh'] + $post['bt_bbk'];
		$data = [
			'kode_sub_kegiatan'				=> $post['kode_sub_kegiatan'],
			'kode_kegiatan'				=> $post['kode_kegiatan'],
			'kode_program'				=> $post['kode_program'],
			'kode_bidang_urusan'				=> $post['kode_bidang_urusan'],
			'id_instansi'				=> id_instansi(),
			'kode_tahap'				=> $post['tahap'],
			'bo_bp'				=> $post['bo_bp'],
			'bo_bbj'				=> $post['bo_bbj'],
			'bo_bs'				=> $post['bo_bs'],
			'bo_bh'				=> $post['bo_bh'],
			'bm_bmt'				=> $post['bm_bmt'],
			'bm_bmpm'				=> $post['bm_bmpm'],
			'bm_bmgb'				=> $post['bm_bmgb'],
			'bm_bmjji'				=> $post['bm_bmjji'],
			'bm_bmatl'				=> $post['bm_bmatl'],
			'btt'				=> $post['btt'],
			'bt_bbh'				=> $post['bt_bbh'],
			'bt_bbk'				=> $post['bt_bbk'],

			'realisasikan_bo'				=> $r_bo > 0  ? 1:0,
			'realisasikan_bm'				=> $r_bm > 0  ? 1:0,
			'realisasikan_btt'				=> $r_btt > 0  ? 1:0,
			'realisasikan_bt'				=> $r_bt > 0  ? 1:0,
		
			'tahun'				=> tahun_anggaran(),
			'created_on'				=> timestamp(),
			'created_by'				=> id_user(),
			'input_by '				=> 'Manual Input',
		];
		$this->db->insert('anggaran_sub_kegiatan', $data);
	}
	public function save_permasalahan_sub_kegiatan()
	{
		$post = $this->input->post();
		$data = [
			'kode_sub_kegiatan'				=> $post['kode_sub_kegiatan'],
			'kode_kegiatan'				=> $post['kode_kegiatan'],
			'kode_program'				=> $post['kode_program'],
			'kode_bidang_urusan'				=> $post['kode_bidang_urusan'],
			'id_instansi'				=> id_instansi(),
			'kode_tahap'				=> $post['tahap'],
			'tahun'				=> $post['tahun'],

			'permasalahan'				=> nl2br($post['permasalahan']),

			'created_on'				=> timestamp(),
			'created_by'				=> id_user(),
		];
		$this->db->insert('permasalahan_sub_kegiatan', $data);
	}
	public function saveedit_permasalahan_sub_kegiatan()
	{
		$post = $this->input->post();
		$data = [
			'permasalahan'				=> nl2br($post['permasalahan']),

			'updated_on'				=> timestamp(),
			'updated_by'				=> id_user(),
		];
		$where = ['id_permasalahan_sub_kegiatan'=>$post['id_permasalahan']];
		$this->db->update('permasalahan_sub_kegiatan', $data, $where);
	}
	public function save_solusi_permasalahan_sub_kegiatan()
	{
		$post = $this->input->post();
		$data = [
			'kode_sub_kegiatan'				=> $post['kode_sub_kegiatan'],
			'kode_kegiatan'				=> $post['kode_kegiatan'],
			'kode_program'				=> $post['kode_program'],
			'kode_bidang_urusan'				=> $post['kode_bidang_urusan'],
			'id_instansi'				=>  sbe_crypt($this->input->post('id_instansi'), 'D'),
			'kode_tahap'				=> $post['tahap'],
			'tahun'				=> $post['tahun'],

			'solusi'				=> nl2br($post['solusi']),
			'solusi_by'				=> $this->session->userdata('group_name'),

			'created_on'				=> timestamp(),
			'created_by'				=> id_user(),
		];
		$this->db->insert('solusi_permasalahan_sub_kegiatan', $data);
	}
	public function saveedit_solusi_permasalahan_sub_kegiatan()
	{
		$post = $this->input->post();
		$data = [
			'solusi'				=> nl2br($post['solusi']),
			'updated_on'				=> timestamp(),
			'updated_by'				=> id_user(),
		];
		$where = [
			'id_solusi_permasalahan_sub_kegiatan'				=> $post['id_solusi']
		];
		$this->db->update('solusi_permasalahan_sub_kegiatan', $data, $where);
	}
	public function saveedit_anggaran_sub_kegiatan($where)
	{
		$post = $this->input->post();
		$r_bo = $post['bo_bp'] + $post['bo_bbj'] + $post['bo_bs'] + $post['bo_bh'];
		$r_bm = $post['bm_bmt'] + $post['bm_bmpm'] + $post['bm_bmgb'] + $post['bm_bmjji'] + $post['bm_bmatl'];
		$r_btt = $post['btt'];
		$r_bt = $post['bt_bbh'] + $post['bt_bbk'];
		$data = [
			'kode_sub_kegiatan'				=> $post['kode_sub_kegiatan'],
			'kode_kegiatan'				=> $post['kode_kegiatan'],
			'kode_program'				=> $post['kode_program'],
			'kode_bidang_urusan'				=> $post['kode_bidang_urusan'],
			'id_instansi'				=> id_instansi(),
			'kode_tahap'				=> $post['tahap'],
			'bo_bp'				=> $post['bo_bp'],
			'bo_bbj'				=> $post['bo_bbj'],
			'bo_bs'				=> $post['bo_bs'],
			'bo_bh'				=> $post['bo_bh'],
			'bm_bmt'				=> $post['bm_bmt'],
			'bm_bmpm'				=> $post['bm_bmpm'],
			'bm_bmgb'				=> $post['bm_bmgb'],
			'bm_bmjji'				=> $post['bm_bmjji'],
			'bm_bmatl'				=> $post['bm_bmatl'],
			'btt'				=> $post['btt'],
			'bt_bbh'				=> $post['bt_bbh'],
			'bt_bbk'				=> $post['bt_bbk'],

			'realisasikan_bo'				=> $r_bo > 0  ? 1:0,
			'realisasikan_bm'				=> $r_bm > 0  ? 1:0,
			'realisasikan_btt'				=> $r_btt > 0  ? 1:0,
			'realisasikan_bt'				=> $r_bt > 0  ? 1:0,
			
			'tahun'				=> tahun_anggaran(),
			'created_on'				=> timestamp(),
			'created_by'				=> id_user(),
			'input_by '				=> 'Manual Input',
		];
		$this->db->update('anggaran_sub_kegiatan', $data, $where);
	}

	public function update_master_paket($id_paket_pekerjaan)
	{
		$post = $this->input->post();
		$data = [
			'id_instansi'				=> id_instansi(),
			'id_pptk' 					=> $post['id_pptk'],
			'kode_rekening_kegiatan'	=> $post['kode_rekening_kegiatan'],
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
	public function anggaran_kegiatan_terpakai($kode_rekening_kegiatan)
	{
		$tahap = tahapan_apbd();
		$q = $this->db->query("SELECT if(anggaran_terpakai('$kode_rekening_kegiatan')>0 , anggaran_terpakai('$kode_rekening_kegiatan'), 0) as anggaran_terpakai, pagu from kegiatan_apbd where kode_rekening='$kode_rekening_kegiatan' and kode_tahap='$tahap'");
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
