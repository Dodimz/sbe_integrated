<?php

/**
 * Author     : Alfikri, M.Kom
 * Created By : Alfikri, M.Kom
 * E-Mail     : alfikri.name@gmail.com
 * No HP      : 081277337405
 * Class      : Realisasi_akumulasi_model.php
 */
defined('BASEPATH') or exit('No direct script access allowed');

class Realisasi_akumulasi_model extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
	}

	public function get_opd()
	{
		if ($this->session->userdata('group_name') == 'OPERATOR') :
			if (id_instansi()) :
				$data = [
					'id_instansi' => id_instansi()
				];
			endif;
		else /*if ($this->session->userdata('group_name') == 'ADMIN' || $this->session->userdata('group_name') == 'SUPER ADMIN' || $this->session->userdata('group_name') == 'HELPDESK') */ :
			$data = [
				'kategori' => 'OPD',
				'id_instansi !=' => 3,
				'is_active =' => 1
			];
		endif;
		return $this->db->get_where('master_instansi', $data);
	}



	public function get_program($id_instansi, $tahap, $tahun)
	{

		if ($tahap == 4 ) {
			
			$where 		=['id_instansi'=>$id_instansi, 'tahun'=>$tahun];
			$program 	= $this->db->get_where('v_program_apbd_perubahan' , $where);
		}else{
			$where 		=['id_instansi'=>$id_instansi, 'tahun'=>$tahun, 'kode_tahap'=>$tahap];
			$program 	= $this->db->get_where('v_program_apbd_awal' , $where);
		}
		return $program;
	}

	public function get_kegiatan($id_instansi, $kode_rekening_program, $kode_bidang_urusan)
	{	
		$tahun 				= $this->input->get('tahun');
		$tahap 				= $this->input->get('tahap');
		// return $this->db->query("SELECT * from v_kegiatan_apbd where  id_instansi ='$id_instansi'
		// 	and kode_tahap = '$tahap' 
		// 	and kode_rekening_program = '$kode_rekening_program'
		// 	and kode_urusan = '$kode_urusan'
		// 	and pagu >0");



		if ($tahap == 4 ) {
			
			$where 		=['id_instansi'=>$id_instansi, 'tahun'=>$tahun,'kode_rekening_program' => $kode_rekening_program,];
			$kegiatan 	=$this->db->get_where('v_kegiatan_apbd_perubahan' , $where);
		}else{
			$where 		=['id_instansi'=>$id_instansi, 'tahun'=>$tahun, 'kode_tahap'=>$tahap, 'kode_rekening_program' => $kode_rekening_program,];
			$kegiatan 	=$this->db->get_where('v_kegiatan_apbd_awal' , $where);
		}




		return $kegiatan;
	}
	public function get_sub_kegiatan($id_instansi, $kode_rekening_kegiatan, $kode_rekening_program, $kode_bidang_urusan)
	{	
		$tahun 				= $this->input->get('tahun');
		$tahap 				= $this->input->get('tahap');
		// return $this->db->query("SELECT * from v_kegiatan_apbd where  id_instansi ='$id_instansi'
		// 	and kode_tahap = '$tahap' 
		// 	and kode_rekening_program = '$kode_rekening_program'
		// 	and kode_urusan = '$kode_urusan'
		// 	and pagu >0");

		if ($tahap == 4 ) {
			
			$where 		=['id_instansi'=>$id_instansi, 'tahun'=>$tahun,'status'=>1,'kode_rekening_program' => $kode_rekening_program,'kode_rekening_kegiatan' => $kode_rekening_kegiatan];
			$sub_kegiatan 	=$this->db->get_where('v_sub_kegiatan_apbd' , $where);
		}else{
			$where 		=['id_instansi'=>$id_instansi, 'tahun'=>$tahun, 'kode_tahap'=>$tahap, 'kode_rekening_program' => $kode_rekening_program,'kode_rekening_kegiatan' => $kode_rekening_kegiatan];
			$sub_kegiatan 	=$this->db->get_where('v_sub_kegiatan_apbd' , $where);
		}


		return $sub_kegiatan;
	}

	public function get_sub_kegiatan_perbandingan_tahapan($id_instansi, $kode_rekening_kegiatan, $kode_rekening_program, $kode_bidang_urusan)
	{	
		$tahun 				= $this->input->get('tahun');
		
			$where 		=['id_instansi'=>$id_instansi, 'tahun'=>$tahun,'kode_rekening_program' => $kode_rekening_program,'kode_rekening_kegiatan' => $kode_rekening_kegiatan];
			$sub_kegiatan 	=$this->db->group_by("kode_rekening_sub_kegiatan")->get_where('v_sub_kegiatan_apbd' , $where);
		


		return $sub_kegiatan;
	}
	public function get_paket_per_sub_kegiatan($id_instansi, $kode_rekening_sub_kegiatan, $kode_rekening_program, $kode_bidang_urusan)
	{	
		$tahun 				= $this->input->get('tahun');
		$tahap 				= $this->input->get('tahap');
		$jenis_paket 				= $this->input->get('jenis_paket');
		$kategori 				= $this->input->get('kategori');
		$metode 				= $this->input->get('metode');
		// return $this->db->query("SELECT * from v_kegiatan_apbd where  id_instansi ='$id_instansi'
		// 	and kode_tahap = '$tahap' 
		// 	and kode_rekening_program = '$kode_rekening_program'
		// 	and kode_urusan = '$kode_urusan'
		// 	and pagu >0");
		if ($jenis_paket=='Semua Paket') {
			$where = [
				'id_instansi' => $id_instansi,
				'tahun' => $tahun,
				'kode_rekening_sub_kegiatan' => $kode_rekening_sub_kegiatan,
			];
		}
		else if ($jenis_paket=='RUTIN') {
			$where = [
				'id_instansi' => $id_instansi,
				'tahun' => $tahun,
				'kode_rekening_sub_kegiatan' => $kode_rekening_sub_kegiatan,
				'jenis_paket' => $jenis_paket,
			];
		}
		else if ($jenis_paket=='SWAKELOLA') {
			if ($metode=='semua') {
				$where = [
					'id_instansi' => $id_instansi,
					'tahun' => $tahun,
					'kode_rekening_sub_kegiatan' => $kode_rekening_sub_kegiatan,
					'jenis_paket' => $jenis_paket,
				];		# code...
			}else{
				$where = [
					'id_instansi' => $id_instansi,
					'tahun' => $tahun,
					'kode_rekening_sub_kegiatan' => $kode_rekening_sub_kegiatan,
					'jenis_paket' => $jenis_paket,
					'id_metode' => $metode,
				];
			}	
			
		}else{


			if ($metode=='semua') {
				$where = [
					'id_instansi' => $id_instansi,
					'tahun' => $tahun,
					'kode_rekening_sub_kegiatan' => $kode_rekening_sub_kegiatan,
					'jenis_paket' => $jenis_paket,
				];		# code...
			}else{

				if ($kategori=='semua') {
				 	$where = [
						'id_instansi' => $id_instansi,
						'tahun' => $tahun,
						'kode_rekening_sub_kegiatan' => $kode_rekening_sub_kegiatan,
						'jenis_paket'=>$jenis_paket,
						'id_metode' => $metode,

					];
				}else{
					$where = [
						'id_instansi' => $id_instansi,
						'tahun' => $tahun,
						'kode_rekening_sub_kegiatan' => $kode_rekening_sub_kegiatan,
						'jenis_paket'=>$jenis_paket,
						'id_metode' => $metode,
						'kategori'=>$kategori
					];
				}

				
			}	



			
		}

		return $this->db->get_where('v_paket', $where);
	}


	public function get_paket_per_opd($id_instansi)
	{	
		$tahun 				= $this->input->get('tahun');
		$tahap 				= $this->input->get('tahap');
		$jenis_paket 				= $this->input->get('jenis_paket');
		$kategori 				= $this->input->get('kategori');
		$metode 				= $this->input->get('metode');
		// return $this->db->query("SELECT * from v_kegiatan_apbd where  id_instansi ='$id_instansi'
		// 	and kode_tahap = '$tahap' 
		// 	and kode_rekening_program = '$kode_rekening_program'
		// 	and kode_urusan = '$kode_urusan'
		// 	and pagu >0");
		if ($jenis_paket=='Semua Paket') {
			$where = [
				'id_instansi' => $id_instansi,
				'tahun' => $tahun,
				//'kode_rekening_sub_kegiatan' => $kode_rekening_sub_kegiatan,
			];
		}
		else if ($jenis_paket=='RUTIN') {
			$where = [
				'id_instansi' => $id_instansi,
				'tahun' => $tahun,
				//'kode_rekening_sub_kegiatan' => $kode_rekening_sub_kegiatan,
				'jenis_paket' => $jenis_paket,
			];
		}
		else if ($jenis_paket=='SWAKELOLA') {
			if ($metode=='semua') {
				$where = [
					'id_instansi' => $id_instansi,
					'tahun' => $tahun,
					//'kode_rekening_sub_kegiatan' => $kode_rekening_sub_kegiatan,
					'jenis_paket' => $jenis_paket,
				];		# code...
			}else{
				$where = [
					'id_instansi' => $id_instansi,
					'tahun' => $tahun,
					//'kode_rekening_sub_kegiatan' => $kode_rekening_sub_kegiatan,
					'jenis_paket' => $jenis_paket,
					'id_metode' => $metode,
				];
			}	
			
		}else{

			if ($kategori=='semua') {
				if ($metode=='semua') {
					$where = [
						'id_instansi' => $id_instansi,
						'tahun' => $tahun,
						//'kode_rekening_sub_kegiatan' => $kode_rekening_sub_kegiatan,
						'jenis_paket' => $jenis_paket,
					];		# code...
				}else{
				 	$where = [
						'id_instansi' => $id_instansi,
						'tahun' => $tahun,
						//'kode_rekening_sub_kegiatan' => $kode_rekening_sub_kegiatan,
						'jenis_paket'=>$jenis_paket,
						'id_metode' => $metode,
					];
				}	


			}else{
				if ($metode=='semua') {
					$where = [
						'id_instansi' => $id_instansi,
						'tahun' => $tahun,
						//'kode_rekening_sub_kegiatan' => $kode_rekening_sub_kegiatan,
						'jenis_paket'=>$jenis_paket,
						'kategori'=>$kategori
					];	
				}else{
				 	$where = [
						'id_instansi' => $id_instansi,
						'tahun' => $tahun,
						//'kode_rekening_sub_kegiatan' => $kode_rekening_sub_kegiatan,
						'jenis_paket'=>$jenis_paket,
						'id_metode' => $metode,
						'kategori'=>$kategori
					];
				}	

				
			}



			


			
		}

		// return $this->db->order_by('kode_rekening_sub_kegiatan', 'ACS')->get_where('v_paket', $where);
		return $this->db->order_by('kode_rekening_sub_kegiatan', 'ACS')->get_where('v_paket_terkontrak', $where);
	}

	public function get_paket_per_opd_group_sub_kegiatan($id_instansi)
	{	
		$tahun 				= $this->input->get('tahun');
		$tahap 				= $this->input->get('tahap');
		$jenis_paket 				= $this->input->get('jenis_paket');
		$kategori 				= $this->input->get('kategori');
		$metode 				= $this->input->get('metode');
		// return $this->db->query("SELECT * from v_kegiatan_apbd where  id_instansi ='$id_instansi'
		// 	and kode_tahap = '$tahap' 
		// 	and kode_rekening_program = '$kode_rekening_program'
		// 	and kode_urusan = '$kode_urusan'
		// 	and pagu >0");
		if ($jenis_paket=='Semua Paket') {
			$where = [
				'id_instansi' => $id_instansi,
				'tahun' => $tahun,
				//'kode_rekening_sub_kegiatan' => $kode_rekening_sub_kegiatan,
			];
		}
		else if ($jenis_paket=='RUTIN') {
			$where = [
				'id_instansi' => $id_instansi,
				'tahun' => $tahun,
				//'kode_rekening_sub_kegiatan' => $kode_rekening_sub_kegiatan,
				'jenis_paket' => $jenis_paket,
			];
		}
		else if ($jenis_paket=='SWAKELOLA') {
			if ($metode=='semua') {
				$where = [
					'id_instansi' => $id_instansi,
					'tahun' => $tahun,
					//'kode_rekening_sub_kegiatan' => $kode_rekening_sub_kegiatan,
					'jenis_paket' => $jenis_paket,
				];		# code...
			}else{
				$where = [
					'id_instansi' => $id_instansi,
					'tahun' => $tahun,
					//'kode_rekening_sub_kegiatan' => $kode_rekening_sub_kegiatan,
					'jenis_paket' => $jenis_paket,
					'id_metode' => $metode,
				];
			}	
			
		}else{

			if ($kategori=='semua') {
				if ($metode=='semua') {
					$where = [
						'id_instansi' => $id_instansi,
						'tahun' => $tahun,
						//'kode_rekening_sub_kegiatan' => $kode_rekening_sub_kegiatan,
						'jenis_paket' => $jenis_paket,
					];		# code...
				}else{
				 	$where = [
						'id_instansi' => $id_instansi,
						'tahun' => $tahun,
						//'kode_rekening_sub_kegiatan' => $kode_rekening_sub_kegiatan,
						'jenis_paket'=>$jenis_paket,
						'id_metode' => $metode,
					];
				}	


			}else{
				if ($metode=='semua') {
					$where = [
						'id_instansi' => $id_instansi,
						'tahun' => $tahun,
						//'kode_rekening_sub_kegiatan' => $kode_rekening_sub_kegiatan,
						'jenis_paket'=>$jenis_paket,
						'kategori'=>$kategori
					];	
				}else{
				 	$where = [
						'id_instansi' => $id_instansi,
						'tahun' => $tahun,
						//'kode_rekening_sub_kegiatan' => $kode_rekening_sub_kegiatan,
						'jenis_paket'=>$jenis_paket,
						'id_metode' => $metode,
						'kategori'=>$kategori
					];
				}	

				
			}



			


			
		}

		// return $this->db->order_by('kode_rekening_sub_kegiatan', 'ACS')->get_where('v_paket', $where);
		return $this->db->select("kode_rekening_sub_kegiatan")->order_by('kode_rekening_sub_kegiatan', 'ACS')->group_by('kode_rekening_sub_kegiatan')->get_where('paket_pekerjaan', $where);
	}



	public function get_paket_opd_per_sub_kegiatan($id_instansi, $kode_rekening_sub_kegiatan)
	{	
		$tahun 				= $this->input->get('tahun');
		$tahap 				= $this->input->get('tahap');
		$jenis_paket 				= $this->input->get('jenis_paket');
		$kategori 				= $this->input->get('kategori');
		$metode 				= $this->input->get('metode');
		// return $this->db->query("SELECT * from v_kegiatan_apbd where  id_instansi ='$id_instansi'
		// 	and kode_tahap = '$tahap' 
		// 	and kode_rekening_program = '$kode_rekening_program'
		// 	and kode_urusan = '$kode_urusan'
		// 	and pagu >0");
		if ($jenis_paket=='Semua Paket') {
			$where = [
				'id_instansi' => $id_instansi,
				'tahun' => $tahun,
				'kode_rekening_sub_kegiatan' => $kode_rekening_sub_kegiatan,
			];
		}
		else if ($jenis_paket=='RUTIN') {
			$where = [
				'id_instansi' => $id_instansi,
				'tahun' => $tahun,
				'kode_rekening_sub_kegiatan' => $kode_rekening_sub_kegiatan,
				'jenis_paket' => $jenis_paket,
			];
		}
		else if ($jenis_paket=='SWAKELOLA') {
			if ($metode=='semua') {
				$where = [
					'id_instansi' => $id_instansi,
					'tahun' => $tahun,
					'kode_rekening_sub_kegiatan' => $kode_rekening_sub_kegiatan,
					'jenis_paket' => $jenis_paket,
				];		# code...
			}else{
				$where = [
					'id_instansi' => $id_instansi,
					'tahun' => $tahun,
					'kode_rekening_sub_kegiatan' => $kode_rekening_sub_kegiatan,
					'jenis_paket' => $jenis_paket,
					'id_metode' => $metode,
				];
			}	
			
		}else{

			if ($kategori=='semua') {
				if ($metode=='semua') {
					$where = [
						'id_instansi' => $id_instansi,
						'tahun' => $tahun,
						'kode_rekening_sub_kegiatan' => $kode_rekening_sub_kegiatan,
						'jenis_paket' => $jenis_paket,
					];		# code...
				}else{
				 	$where = [
						'id_instansi' => $id_instansi,
						'tahun' => $tahun,
						'kode_rekening_sub_kegiatan' => $kode_rekening_sub_kegiatan,
						'jenis_paket'=>$jenis_paket,
						'id_metode' => $metode,
					];
				}	


			}else{
				if ($metode=='semua') {
					$where = [
						'id_instansi' => $id_instansi,
						'tahun' => $tahun,
						'kode_rekening_sub_kegiatan' => $kode_rekening_sub_kegiatan,
						'jenis_paket'=>$jenis_paket,
						'kategori'=>$kategori
					];	
				}else{
				 	$where = [
						'id_instansi' => $id_instansi,
						'tahun' => $tahun,
						'kode_rekening_sub_kegiatan' => $kode_rekening_sub_kegiatan,
						'jenis_paket'=>$jenis_paket,
						'id_metode' => $metode,
						'kategori'=>$kategori
					];
				}	

				
			}



			


			
		}

		// return $this->db->order_by('kode_rekening_sub_kegiatan', 'ACS')->get_where('v_paket', $where);
		return $this->db->order_by('kode_rekening_sub_kegiatan', 'ACS')->get_where('v_paket_terkontrak', $where);
	}

	public function get_sumber_dana($id_instansi, $kode_rekening_sub_kegiatan, $kode_rekening_kegiatan, $kode_rekening_program, $kode_bidang_urusan)
	{
		$tahun 				= $this->input->get('tahun');
		$tahap 				= $this->input->get('tahap');
		return $this->db->get_where('sumber_dana', [
			'id_instansi' => $id_instansi,
			'kode_tahap' => $tahap,
			'tahun' => $tahun,
			'kode_rekening_sub_kegiatan' => $kode_rekening_sub_kegiatan,
			'kode_rekening_kegiatan' => $kode_rekening_kegiatan,
			'kode_rekening_program' => $kode_rekening_program,
			'kode_bidang_urusan' => $kode_bidang_urusan
		]);
	}

	public function get_target($id_instansi, $kode_rekening_sub_kegiatan, $bulan, $tahap, $tahun)
	{
		// $tahun 				= $this->input->get('tahun');
		// $tahap 				= $this->input->get('tahap');

		$where =  [
			'id_instansi' => $id_instansi,
			'kode_tahap' => $tahap,
			'tahun' => $tahun,
			'kode_rekening_sub_kegiatan' => $kode_rekening_sub_kegiatan,
			'bulan' => $bulan
		];


			$this->db->select('kode_rekening_sub_kegiatan,target_fisik,target_keuangan,target_fisik_bulanan,target_keuangan_bulanan ');
		return $this->db->get_where('target_apbd', $where);
	}

	public function get_realisasi_keuangan($id_instansi, $kode_rekening_sub_kegiatan, $bulan, $ope, $tahun, $tahap)
	{
		// $tahun 				= $this->input->get('tahun');
		// $tahap 				= $this->input->get('tahap');
		$query  = $this->db->query("SELECT
										sum(bo_bp + bo_bbj+ bo_bs+bo_bh + bm_bmt + bm_bmpm + bm_bmgb + bm_bmjji + bm_bmatl +btt +  bt_bbh+bt_bbk ) as total_realisasi,
										sum(bo_bp) as realisasi_bo_bp,
										sum(bo_bbj) as realisasi_bo_bbj,
										sum(bo_bs) as realisasi_bo_bs,
										sum(bo_bh) as realisasi_bo_bh,
										sum(bm_bmt) as realisasi_bm_bmt,
										sum(bm_bmpm) as realisasi_bm_bmpm,
										sum(bm_bmgb) as realisasi_bm_bmgb,
										sum(bm_bmjji) as realisasi_bm_bmjji,
										sum(bm_bmatl) as realisasi_bm_bmatl,
										sum(btt) as realisasi_btt,
										sum(bt_bbh) as realisasi_bt_bbh,
										sum(bt_bbk) as realisasi_bt_bbk
									FROM
										realisasi_keuangan 
									WHERE
										id_instansi = {$id_instansi} 
										AND kode_sub_kegiatan = '{$kode_rekening_sub_kegiatan}' 
										AND bulan {$ope} {$bulan}
										AND kode_tahap = '$tahap'
										AND tahun='$tahun'");
		return $query;
	}

	public function get_realisasi_fisik($id_instansi, $kode_rekening_sub_kegiatan, $bulan, $jenis_paket, $ope, $tahun, $tahap)
	{
		

		$query  = $this->db->query("SELECT
										rk.kode_rekening_sub_kegiatan,
										rk.bulan,
										SUM( rk.nilai ) AS total 
									FROM
										realisasi_fisik rk
										LEFT JOIN paket_pekerjaan pp ON rk.id_paket_pekerjaan = pp.id_paket_pekerjaan 
									WHERE
										rk.id_instansi = {$id_instansi} 
										AND rk.kode_rekening_sub_kegiatan = '$kode_rekening_sub_kegiatan' 
										AND pp.jenis_paket = '{$jenis_paket}' 
										AND rk.bulan {$ope} {$bulan}
										AND rk.tahun='$tahun'");
		return $query;
	}

	public function get_total_paket($id_instansi, $kode_rekening_sub_kegiatan, $tahun, $tahap)
	{
		
		if ($tahap ==4) {
			$where = "AND status=1";
		}else{
			$where = "AND kode_tahap='$tahap'";

		}

		$query  = $this->db->query("SELECT
										id_paket_pekerjaan
									FROM
										paket_pekerjaan pp 
									WHERE
										pp.kode_rekening_sub_kegiatan = '{$kode_rekening_sub_kegiatan}'
										AND pp.id_instansi = {$id_instansi} and pp.tahun='$tahun'
										$where 
								");
		return $query;
	}
	public function get_total_paket_perjenis($id_instansi, $kode_rekening_sub_kegiatan, $jenis, $tahun, $tahap)
	{
		if ($tahap ==4) {
			$where = "AND pp.status=1";
		}else{
			$where = "AND pp.kode_tahap='$tahap'";

		}

		$query  = $this->db->query("SELECT
										id_paket_pekerjaan
									FROM
										paket_pekerjaan pp 
									WHERE
										pp.kode_rekening_sub_kegiatan = '{$kode_rekening_sub_kegiatan}'
										AND pp.id_instansi = {$id_instansi}
										AND pp.jenis_paket = '{$jenis}'
										AND pp.tahun='$tahun' 
										$where
								");
		return $query;
	}


	public function jumlah_kegiatan($id_instansi)
	{
		$tahap  = tahapan_apbd();
		return $this->db->query("SELECT total_kegiatan($id_instansi, $tahap) as total_kegiatan")->row()->total_kegiatan;
	}



 public function total_pagu_sub_kegiatan($kode_sub_kegiatan, $tahap, $id_instansi, $jenis)
    {


		$tahun 				= $this->input->get('tahun');
		// $tahap 				= $this->input->get('tahap');
        // $tahun = tahun_anggaran();
  //       if ($tahap ==4) {
		// 	$where = "  WHERE
		// 	id_instansi = '$id_instansi' and kode_sub_kegiatan='$kode_sub_kegiatan'  and status = '1' and tahun = '$tahun'";
		// 	}
		// else{
			$where = "  WHERE
			id_instansi = '$id_instansi' and kode_tahap='$tahap' and kode_sub_kegiatan='$kode_sub_kegiatan'  and tahun = '$tahun'";
        // }

        if ($jenis=='pagu_bo') {
             $query  = $this->db->query("SELECT
                                         sum(bo_bp + bo_bbj+ bo_bs+bo_bh) as pagu_bo
                                    FROM
                                        anggaran_sub_kegiatan 
                                    $where
                                        ");
        }
        else if ($jenis=='pagu_bm') {
            $query  = $this->db->query("SELECT
                                         sum( bm_bmt + bm_bmpm + bm_bmgb + bm_bmjji + bm_bmatl ) as pagu_bm
                                    FROM
                                        anggaran_sub_kegiatan 
                                    $where
                                        ");
        }
        else if ($jenis=='pagu_btt') {
            $query  = $this->db->query("SELECT
                                         sum(btt) as pagu_btt
                                    FROM
                                        anggaran_sub_kegiatan 
                                    $where
                                        ");
        }
        else if ($jenis=='pagu_bt') {
            $query  = $this->db->query("SELECT
                                         sum( bt_bbh+bt_bbk ) as pagu_bt
                                    FROM
                                        anggaran_sub_kegiatan 
                                    $where
                                        ");
        }else{
        	 $query  = $this->db->query("SELECT
                                         sum(bo_bp + bo_bbj+ bo_bs+bo_bh + bm_bmt + bm_bmpm + bm_bmgb + bm_bmjji + bm_bmatl + btt + bt_bbh+bt_bbk) as pagu_total
                                    FROM
                                        anggaran_sub_kegiatan 
                                    $where
                                        ");
        }
     
        return $query;
    }

}
