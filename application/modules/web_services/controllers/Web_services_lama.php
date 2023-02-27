<?php

/**
 * Author     : Alfikri, M.Kom
 * Created By : Alfikri, M.Kom
 * E-Mail     : alfikri.name@gmail.com
 * No HP      : 081277337405
 * Class      : Web_services.php
 */
defined('BASEPATH') or exit('No direct script access allowed');

class Web_services extends MY_Controller
{
	public function __construct()
	{
		parent::__construct();
		ini_set('max_execution_time', 0);
		$this->load->model(['web_services/sipkd_model' => 'sipkd_model']);
	}

	public function sipkd($kategori = '')
	{
		$breadcrumbs    = $this->breadcrumbs;
		$sipkd  		= $this->sipkd_model;

		$breadcrumbs->add('Home', base_url());
		$breadcrumbs->add('Web Services', base_url('web_services'));
		$breadcrumbs->add('IN', base_url('web_services/sipkd'));
		$breadcrumbs->add('SIPKD', base_url(''));
		$breadcrumbs->render();

		$data['title']			  	= "SIPKD";
		$data['icon']			  	= "fa fa-bars";
		$data['description']	  	= "Sistem Informasi Pengelola Keuangan Daerah";
		$data['breadcrumbs']	  	= $breadcrumbs->render();
		$data['total_opd']  	  	= $sipkd->total_opd();
		$data['total_m_program']  	= $sipkd->total_m_program();
		$data['total_m_kegiatan'] 	= $sipkd->total_m_kegiatan();
		$data['total_program']    	= $sipkd->total_program();
		$data['total_kegiatan']   	= $sipkd->total_kegiatan();
		$page 						= 'web_services/sipkd/index';
		$data['link']   			= $this->router->fetch_class();
		$data['menu'] 				= $this->load->view('layout/menu', $data, true);
		$data['extra_css']			= $this->load->view('web_services/sipkd/css', $data, true);
		$data['extra_js']			= $this->load->view('web_services/sipkd/js', $data, true);
		$data['modal']          	= "";





		$this->template->load('backend_template', $page, $data);
	}

	public function eplanning()
	{
		$breadcrumbs    = $this->breadcrumbs;
		$sipkd  		= $this->sipkd_model;

		$breadcrumbs->add('Home', base_url());
		$breadcrumbs->add('Web Services', base_url('web_services'));
		$breadcrumbs->add('IN', base_url('web_services/sipkd'));
		$breadcrumbs->add('E Planning', base_url(''));
		$breadcrumbs->render();

		$data['title']			  	= "E-Planning";
		$data['icon']			  	= "fa fa-bars";
		$data['description']	  	= "Electronic Planning";
		$data['breadcrumbs']	  	= $breadcrumbs->render();
		$data['total_opd']  	  	= $sipkd->total_opd();
		$data['total_m_program']  	= $sipkd->total_m_program();
		$data['total_m_kegiatan'] 	= $sipkd->total_m_kegiatan();
		$data['total_program']    	= $sipkd->total_program();
		$data['total_kegiatan']   	= $sipkd->total_kegiatan();
		$page 						= 'web_services/eplanning/index';
		$data['link']   			= $this->router->fetch_class();
		$data['menu'] 				= $this->load->view('layout/menu', $data, true);
		$data['extra_css']			= $this->load->view('web_services/eplanning/css', $data, true);
		$data['extra_js']			= $this->load->view('web_services/eplanning/js', $data, true);
		$data['modal']          	= "";





		$this->template->load('backend_template', $page, $data);
	}

	public function get_token()
	{
		if (!$this->input->is_ajax_request()) {
			show_404();
		} else {
			$output = [
				'status' 	=> false,
				'data' 		=> []
			];
			$link = "http://eplanning.sumbarprov.go.id/sin/sinkron/generate_token/pembangunan/pembangunankoneksi";
			$token       = file_get_contents($link);
			if ($token) {
				$get_instansi_kepmen50 = "http://eplanning.sumbarprov.go.id/sin/sinkron/get_instansi_kepmen50/".$token;
				$content_instansi       = file_get_contents($get_instansi_kepmen50);
				$jumlah_data_instansi  = count(json_decode($content_instansi ));

				$get_bidangurusan_kepmen50 = "http://eplanning.sumbarprov.go.id/sin/sinkron/get_bidangurusan_kepmen50/".$token;
				$content_bu       = file_get_contents($get_bidangurusan_kepmen50);
				$jumlah_data_bu  = count(json_decode($content_bu ));
				
				$get_program_kepmen50 = "http://eplanning.sumbarprov.go.id/sin/sinkron/get_program_kepmen50/".$token;
				$content_program       = file_get_contents($get_program_kepmen50);
				$jumlah_data_program  = count(json_decode($content_program ));
				
				$get_kegiatan_kepmen50 = "http://eplanning.sumbarprov.go.id/sin/sinkron/get_kegiatan_kepmen50/".$token;
				$content_kegiatan       = file_get_contents($get_kegiatan_kepmen50);
				$jumlah_data_kegiatan  = count(json_decode($content_kegiatan ));
				
				$get_subkegiatan_kepmen50 = "http://eplanning.sumbarprov.go.id/sin/sinkron/get_subkegiatan_kepmen50/".$token;
				$content_sub_kegiatan       = file_get_contents($get_subkegiatan_kepmen50);
				$jumlah_data_sub_kegiatan  = count(json_decode($content_sub_kegiatan ));



				$output['status'] = true;
				$output['data']['key']	= $token;
				$output['data']['jumlah_instansi']	= $jumlah_data_instansi;
				$output['data']['jumlah_bu']	= $jumlah_data_bu;
				$output['data']['jumlah_program']	= $jumlah_data_program;
				$output['data']['jumlah_kegiatan']	= $jumlah_data_kegiatan;
				$output['data']['jumlah_sub_kegiatan']	= $jumlah_data_sub_kegiatan;
			}

			echo json_encode($output);
		}
	}

	public function get_opd()
	{
		if (!$this->input->is_ajax_request()) {
			show_404();
		} else {
			$output = [
				'status' 	=> false,
				'data' 		=> []
			];

			$opd 	= $this->db->query("SELECT id_instansi, kode_opd, nama_instansi FROM master_instansi WHERE kategori = 'OPD' AND id_instansi != 3 ORDER BY kode_opd ASC")->result();

			foreach ($opd as $key => $value) {
				$output['data'][$key]['id_instansi'] 	= $value->id_instansi;
				$output['data'][$key]['kode_opd'] 		= $value->kode_opd;
				$output['data'][$key]['nama_instansi'] 	= $value->nama_instansi;
				$output['status'] = true;
			}

			echo json_encode($output);
		}
	}

	public function aliran_kas()
	{
		if (!$this->input->is_ajax_request()) {
			show_404();
		} else {
			$output 	= [
				'status' 	=> false,
				'messages' 	=> ''
			];

			$tahap  	= $this->input->post('tahap');
			$kode_opd  	= $this->input->post('kode_opd');

			$data 		= [];

			$link 		= "http://182.253.192.82:8087/bangda/?tahun=" . tahun_anggaran() . "&req=angkas&key=CKFUP-DXRY-FKMH&tahap=" . $tahap . "&opd=" . $kode_opd;
			$data       = file_get_contents($link);
			$konversi   = json_decode($data, true);
			$where  = ['kode_tahap'=>$tahap, 'id_instansi'=>id_instansi_kode_opd(trim($kode_opd))];
			$this->db->update('target_apbd', ['target_keuangan' => 0], $where);

			foreach ($konversi as $key => $value) {
				$table 		= "target_apbd";
				$primary 	= [
					'kode_rekening'			=> trim($value['KODEOPD']) . trim($value['KODEPROGRAM']) . trim($value['KODEKEGIATAN']),
					'bulan' 				=> $value['BULAN'],
					'kode_tahap'			=> $tahap,
					'tahun' 				=> tahun_anggaran(),
				];
				$insert 	= [
					'kode_rekening'			=> trim($value['KODEOPD']) . trim($value['KODEPROGRAM']) . trim($value['KODEKEGIATAN']),
					'id_instansi'			=> id_instansi_kode_opd(trim($value['KODEOPD'])),
					'kode_urusan' 			=> trim($value['KODEURUS']),
					'bulan'					=> $value['BULAN'],
					'kode_tahap'			=> $tahap,
					'keuangan'				=> $value['NILAI'],
					'tahun' 				=> tahun_anggaran(),
					'created_on'    		=> timestamp(),
					'updated_on'    		=> timestamp(),
					'created_by'    		=> id_user(),
					'updated_by'    		=> id_user()
				];
				$update 	= [
					'id_instansi'			=> id_instansi_kode_opd(trim($value['KODEOPD'])),
					'kode_urusan' 			=> trim($value['KODEURUS']),
					'keuangan'				=> $value['NILAI'],
					'updated_on'    		=> timestamp(),
					'updated_by'    		=> id_user()
				];

				$cek = $this->db->get_where($table, $primary)->num_rows();

				if ($cek > 0) {
					$this->db->update($table, $update, $primary);
					$output['status'] 	= true;
					$output['messages'] = '{$cek} Data berhasil update';
				} else {
					$this->db->insert($table, $insert);
					$output['status'] 	= true;
					$output['messages'] = 'Data berhasil ditambahkan';
				}
			}

			echo json_encode($output);
		}
	}

	public function akumulasi()
	{
		if (!$this->input->is_ajax_request()) {
			show_404();
		} else {
			$output 	= [
				'status' 	=> false,
				'messages' 	=> ''
			];

			$id_instansi = $this->input->post('id_instansi');
			$kegiatan   = $this->db->get_where('v_kegiatan_apbd', ['kode_tahap' => tahapan_apbd(), 'id_instansi' => $id_instansi]);

			$keg        = [];
			$target     = [];

			foreach ($kegiatan->result() as $key => $value) {
				for ($i = 0; $i <= 11; $i++) {
					$target = $this->db->get_where('target_apbd', ['kode_rekening' => $value->kode_rekening_kegiatan, 'kode_tahap' => tahapan_apbd(), 'bulan' => $i + 1])->row_array();

					if ($i == 0) {
						$keg[$key][$i] = $target['keuangan'];
						$this->db->update('target_apbd', ['target_keuangan' => $keg[$key][$i]], ['kode_rekening' => $value->kode_rekening_kegiatan, 'bulan' => $i + 1]);
					} else {
						$keg[$key][$i] = $target['keuangan'] + $keg[$key][$i - 1];
						$this->db->update('target_apbd', ['target_keuangan' => $keg[$key][$i]], ['kode_rekening' => $value->kode_rekening_kegiatan, 'bulan' => $i + 1]);
					}
				}

				$output['status'] = true;
			}

			echo json_encode($output);
		}
	}

	public function sync()
	{
		if (!$this->input->is_ajax_request()) {
			show_404();
		} else {
			$result  	= [
				'success' 	=> false,
				'messages' 	=> ''
			];
			$req = $this->input->post('req');

			if ($req == "master_urusan") {
				$link = "http://182.253.192.82:8087/bangda/?tahun=" . tahun_anggaran() . "&req=urusan&key=CKFUP-DXRY-FKMH";
			} elseif ($req == "master_program") {
				$link = "http://182.253.192.82:8087/bangda/?tahun=" . tahun_anggaran() . "&req=program&key=CKFUP-DXRY-FKMH";
			} elseif ($req == "master_kegiatan") {
				$link = "http://182.253.192.82:8087/bangda/?tahun=" . tahun_anggaran() . "&req=kegiatan&key=CKFUP-DXRY-FKMH";
			} elseif ($req == "kegiatan_apbd_dpa_awal") {
				$link = "http://182.253.192.82:8087/bangda/?tahun=" . tahun_anggaran() . "&req=apbd&key=CKFUP-DXRY-FKMH&tahap=2";
			} elseif ($req == "kegiatan_apbd_dpa_perubahan") {
				$link = "http://182.253.192.82:8087/bangda/?tahun=" . tahun_anggaran() . "&req=apbd&key=CKFUP-DXRY-FKMH&tahap=4";
			}

			$data       = file_get_contents($link);

			$konversi   = json_decode($data, true);

			foreach ($konversi as $key => $value) {
				if ($req == "master_urusan") {
					$table 		= "master_urusan";
					$primary 	= [
						'kode_urusan' 	=> trim($value['KODE'])
					];
					$insert 	= [
						'kode_urusan' 	=> trim($value['KODE']),
						'nama_urusan' 	=> trim($value['URAIAN']),
						'tahun' 		=> tahun_anggaran(),
						'created_on'    => timestamp(),
						'updated_on'    => timestamp(),
						'created_by'    => id_user(),
						'updated_by'    => id_user()
					];
					$update 	= [
						'tahun'			=> tahun_anggaran(),
						'nama_urusan' 	=> trim($value['URAIAN']),
						'updated_on'    => timestamp(),
						'updated_by'    => id_user()
					];
				} elseif ($req == "master_program") {
					$table 		= "master_program";
					$primary 	= [
						'id_program' 	=> trim($value['idprgrm']),
					];
					$insert 	= [
						'id_program' 	=> trim($value['idprgrm']),
						'kode_urusan' 	=> trim($value['KODEURUS']),
						'kode_program' 	=> trim($value['KODEPROGRAM']),
						'nama_program' 	=> trim($value['NAMAPROGRAM']),
						'tahun'			=> tahun_anggaran(),
						'created_on'    => timestamp(),
						'updated_on'    => timestamp(),
						'created_by'    => id_user(),
						'updated_by'    => id_user()
					];
					$update 	= [
						'nama_program' 	=> trim($value['NAMAPROGRAM']),
						'tahun'			=> tahun_anggaran(),
						'updated_on'    => timestamp(),
						'updated_by'    => id_user()
					];
				} elseif ($req == "master_kegiatan") {
					$table 		= "master_kegiatan";
					$primary 	= [
						'id_kegiatan'	=> trim($value['kdkegunit'])
					];
					$insert 	= [
						'id_kegiatan'	=> trim($value['kdkegunit']),
						'id_program'	=> trim($value['idprgrm']),
						'kode_urusan' 	=> trim($value['KODEURUS']),
						'kode_program' 	=> trim($value['KODEPROGRAM']),
						'kode_kegiatan'	=> trim($value['KODEKEGIATAN']),
						'nama_kegiatan'	=> trim($value['URAIAN']),
						'tahun'			=> tahun_anggaran(),
						'created_on'    => timestamp(),
						'updated_on'    => timestamp(),
						'created_by'    => id_user(),
						'updated_by'    => id_user()
					];
					$update 	= [
						'nama_kegiatan' => trim($value['URAIAN']),
						'tahun'			=> tahun_anggaran(),
						'updated_on'    => timestamp(),
						'updated_by'    => id_user()
					];
				} elseif ($req == "kegiatan_apbd_dpa_awal") {
					$table 		= "kegiatan_apbd";
					$primary 	= [
						'kode_rekening'			=> trim($value['KODEOPD']) . trim($value['KODEPROGRAM']) . trim($value['KODEKEGIATAN']),
						'kode_tahap' 			=> 2,
						'kode_urusan'			=> trim($value['KODEURUS']),
					];
					$insert 	= [
						'kode_rekening_program'	=> trim($value['KODEOPD']) . trim($value['KODEPROGRAM']),
						'kode_rekening'			=> trim($value['KODEOPD']) . trim($value['KODEPROGRAM']) . trim($value['KODEKEGIATAN']),
						'kode_tahap'			=> 2,
						'id_instansi'			=> id_instansi_kode_opd(trim($value['KODEOPD'])),
						'kode_opd' 				=> trim($value['KODEOPD']),
						'kode_urusan'			=> trim($value['KODEURUS']),
						'id_program'			=> trim($value['IDPRGRM']),
						'id_kegiatan' 			=> trim($value['KDKEGUNIT']),
						'kode_program'			=> trim($value['KODEPROGRAM']),
						'kode_kegiatan' 		=> trim($value['KODEKEGIATAN']),
						'nama_kegiatan' 		=> trim($value['URAIKEG']),
						'belanja_pegawai' 		=> $value['BP'],
						'belanja_barang_jasa' 	=> $value['BJ'],
						'belanja_modal'			=> $value['BM'],
						'pagu'					=> $value['PAGU'],
						'output'				=> trim($value['Ouput']),
						'akumulasi'				=> 'N',
						'tahun' 				=> tahun_anggaran(),
						'created_on'    		=> timestamp(),
						'updated_on'    		=> timestamp(),
						'created_by'    		=> id_user(),
						'updated_by'    		=> id_user()
					];
					$update 	= [
						'kode_urusan'			=> trim($value['KODEURUS']),
						'nama_kegiatan' 		=> trim($value['URAIKEG']),
						'belanja_pegawai' 		=> $value['BP'],
						'belanja_barang_jasa' 	=> $value['BJ'],
						'belanja_modal'			=> $value['BM'],
						'pagu'					=> $value['PAGU'],
						'output'				=> trim($value['Ouput']),
						'akumulasi'				=> 'N',
						'tahun' 				=> tahun_anggaran(),
						'updated_on'    		=> timestamp(),
						'updated_by'    		=> id_user()
					];
				} elseif ($req == "kegiatan_apbd_dpa_perubahan") {
					$table 		= "kegiatan_apbd";
					$primary 	= [
						'kode_rekening'			=> trim($value['KODEOPD']) . trim($value['KODEPROGRAM']) . trim($value['KODEKEGIATAN']),
						'kode_tahap' 			=> 4
					];
					$insert 	= [
						'kode_rekening_program'	=> trim($value['KODEOPD']) . trim($value['KODEPROGRAM']),
						'kode_rekening'			=> trim($value['KODEOPD']) . trim($value['KODEPROGRAM']) . trim($value['KODEKEGIATAN']),
						'kode_tahap'			=> 4,
						'id_instansi'			=> id_instansi_kode_opd(trim($value['KODEOPD'])),
						'kode_opd' 				=> trim($value['KODEOPD']),
						'kode_urusan'			=> trim($value['KODEURUS']),
						'id_program'			=> trim($value['IDPRGRM']),
						'id_kegiatan' 			=> trim($value['KDKEGUNIT']),
						'kode_program'			=> trim($value['KODEPROGRAM']),
						'kode_kegiatan' 		=> trim($value['KODEKEGIATAN']),
						'nama_kegiatan' 		=> trim($value['URAIKEG']),
						'belanja_pegawai' 		=> $value['BP'],
						'belanja_barang_jasa' 	=> $value['BJ'],
						'belanja_modal'			=> $value['BM'],
						'pagu'					=> $value['PAGU'],
						'output'				=> trim($value['Ouput']),
						'akumulasi'				=> 'N',
						'tahun' 				=> tahun_anggaran(),
						'created_on'    		=> timestamp(),
						'updated_on'    		=> timestamp(),
						'created_by'    		=> id_user(),
						'updated_by'    		=> id_user()
					];
					$update 	= [
						'nama_kegiatan' 		=> trim($value['URAIKEG']),
						'belanja_pegawai' 		=> $value['BP'],
						'belanja_barang_jasa' 	=> $value['BJ'],
						'belanja_modal'			=> $value['BM'],
						'pagu'					=> $value['PAGU'],
						'output'				=> trim($value['Ouput']),
						'akumulasi'				=> 'N',
						'tahun' 				=> tahun_anggaran(),
						'updated_on'    		=> timestamp(),
						'updated_by'    		=> id_user()
					];
				}

				$cek = $this->db->get_where($table, $primary)->num_rows();

				if ($cek > 0) {
					$this->db->update($table, $update, $primary);
				} else {
					$this->db->insert($table, $insert);
				}
			}

			echo json_encode($cek);
		}
	}

public function sync_eplanning()
	{
		if (!$this->input->is_ajax_request()) {
			show_404();
		} else {
			$result  	= [
				'success' 	=> false,
				'messages' 	=> ''
			];
				$req = $this->input->post('req');
			$token = $this->input->post('token');

			if ($req == "master_bidang_urusan") {
				$link = "http://eplanning.sumbarprov.go.id/sin/sinkron/get_bidangurusan_kepmen50/".$token;
			} elseif ($req == "master_instansi") {
				$link = "http://eplanning.sumbarprov.go.id/sin/sinkron/get_instansi_kepmen50/".$token;
			} elseif ($req == "master_program") {
				$link = "http://eplanning.sumbarprov.go.id/sin/sinkron/get_program_kepmen50/".$token;
			} elseif ($req == "master_kegiatan") {
				$link = "http://eplanning.sumbarprov.go.id/sin/sinkron/get_kegiatan_kepmen50/".$token;
			} elseif ($req == "master_sub_kegiatan") {
				$link = "http://eplanning.sumbarprov.go.id/sin/sinkron/get_subkegiatan_kepmen50/".$token;
			} elseif ($req == "kegiatan_apbd_dpa_awal") {
				$link = "http://182.253.192.82:8087/bangda/?tahun=" . tahun_anggaran() . "&req=apbd&key=CKFUP-DXRY-FKMH&tahap=2";
			} elseif ($req == "kegiatan_apbd_dpa_perubahan") {
				$link = "http://182.253.192.82:8087/bangda/?tahun=" . tahun_anggaran() . "&req=apbd&key=CKFUP-DXRY-FKMH&tahap=4";
			}

			$data       = file_get_contents($link);

			$konversi   = json_decode($data, true);

			foreach ($konversi as $key => $value) {
				if ($req == "master_instansi") {
					$table 		= "master_instansi";
					$primary 	= [
						'id_instansi' 	=> trim($value['id'])
					];
					$insert 	= [
						'id_instansi' 	=> trim($value['id']),
						'kode_opd' 	=> trim($value['kode_opd']),
						'nama_instansi' 	=> trim($value['nama_opd']),
						'nama_instansi_sebelumnya' 	=> trim($value['nama_opd']),
						
						'kategori' 	=> "OPD",
						'is_parent' 		=> "T",
						'position' 		=> "h",
						'created_on'    => timestamp(),
						
						'created_by'    => id_user(),
						'input_by' 		=> 'Web Service'
					];
					$update 	= [
						'kode_opd' 	=> trim($value['kode_opd']),
						'nama_instansi' 	=> trim($value['nama_opd']),
						'updated_on'    => timestamp(),
						'updated_by'    => id_user(),
						'input_by' 		=> 'Web Service'
					];
				}
				else if ($req == "master_bidang_urusan") {
					$table 		= "master_bidang_urusan";
					$primary 	= [
						'kode_bidang_urusan' 	=> trim($value['kode'])
					];
					$insert 	= [
						'kode_bidang_urusan' 	=> trim($value['kode']),
						'nama_bidang_urusan' 	=> trim($value['nomenklatur']),
						'tahun' 		=> tahun_anggaran(),
						'created_on'    => timestamp(),
						
						'created_by'    => id_user(),
						'input_by' 		=> 'Web Service'
					];
					$update 	= [
						'tahun'			=> tahun_anggaran(),
						'nama_bidang_urusan' 	=> trim($value['nomenklatur']),
						'updated_on'    => timestamp(),
						'updated_by'    => id_user(),
						'input_by' 		=> 'Web Service'
					];
				} 
				elseif ($req == "master_program") {
					$table 		= "master_program";
					$kode_program = trim($value['kode']);
					$pecah		= explode('.', $kode_program);
					$kode_urusan = $pecah[0].'.'.$pecah[1];
					$kd_program = end($pecah);
					$primary 	= [
						'id_program' 	=> trim($value['id']),
					];
					$insert 	= [
						'id_program' 	=> trim($value['id']),
						'kode_bidang_urusan' 	=> $kode_urusan,
						'kd_program' 	=> $kd_program,
						'kode_program' 	=> $kode_program,
						'nama_program' 	=> trim($value['nomenklatur']),
						'tahun'			=> tahun_anggaran(),
						'created_on'    => timestamp(),
						
						'created_by'    => id_user(),
						'input_by' 		=> 'Web Service'
						
					];
					$update 	= [
						'nama_program' 	=> trim($value['nomenklatur']),
						'tahun'			=> tahun_anggaran(),
						'updated_on'    => timestamp(),
						'updated_by'    => id_user(),
						'input_by' 		=> 'Web Service'
					];
				} elseif ($req == "master_kegiatan") {
					$table 		= "master_kegiatan";
					$kode_kegiatan = trim($value['kode']);
					$pecah		= explode('.', $kode_kegiatan);
					$kode_urusan = $pecah[0].'.'.$pecah[1];
					$kd_program = $pecah[2];
					$kode_program = $pecah[0].'.'.$pecah[1].'.'.$pecah[2];
					$kd_kegiatan = $pecah[3].'.'.$pecah[4];
					
					$primary 	= [
						'id_kegiatan'	=> trim($value['id'])
					];
					$insert 	= [
						'id_kegiatan'	=> trim($value['id']),
						'kd_kegiatan'	=> $kd_kegiatan,
						'kode_kegiatan'	=> $kode_kegiatan,
						'kd_program' 	=> $kd_program,
						'kode_program' 	=> $kode_program,
						'kode_bidang_urusan' 	=> $kode_urusan,
						'kode_kegiatan'	=> $kode_kegiatan,
						'nama_kegiatan'	=> trim($value['nomenklatur']),
						'tahun'			=> tahun_anggaran(),
						'created_on'    => timestamp(),
						'created_by'    => id_user(),
						'input_by' 		=> 'Web Service'
					];
					$update 	= [
						'nama_kegiatan' => trim($value['nomenklatur']),
						'tahun'			=> tahun_anggaran(),
						'updated_on'    => timestamp(),
						'updated_by'    => id_user(),
						'input_by' 		=> 'Web Service'
					];
				} 
				elseif ($req == "master_sub_kegiatan") {
					$table 		= "master_sub_kegiatan";
					$kode_sub_kegiatan = trim($value['kode']);
					$pecah		= explode('.', $kode_sub_kegiatan);
					$kode_urusan = $pecah[0].'.'.$pecah[1];
					$kd_program = $pecah[2];
					$kode_program = $pecah[0].'.'.$pecah[1].'.'.$pecah[2];
					$kode_kegiatan = $pecah[0].'.'.$pecah[1].'.'.$pecah[2].'.'.$pecah[3].'.'.$pecah[4];
					$kd_kegiatan = $pecah[3].'.'.$pecah[4];
					$kd_sub_kegiatan = end($pecah);
					
					$primary 	= [
						'id_sub_kegiatan'	=> trim($value['id'])
					];
					$insert 	= [
						'id_sub_kegiatan'	=> trim($value['id']),
						'kd_kegiatan'	=> $kd_kegiatan,
						'kode_kegiatan'	=> $kode_kegiatan,
						'kode_sub_kegiatan'	=> $kode_sub_kegiatan,
						'kd_sub_kegiatan'	=> $kd_sub_kegiatan,
						'kd_program' 	=> $kd_program,
						'kode_program' 	=> $kode_program,
						'kode_bidang_urusan' 	=> $kode_urusan,
						'kode_kegiatan'	=> $kode_kegiatan,
						'nama_sub_kegiatan'	=> trim($value['nomenklatur']),
						'tahun'			=> tahun_anggaran(),
						'created_on'    => timestamp(),
						'created_by'    => id_user(),
						'input_by' 		=> 'Web Service'
					];
					$update 	= [
						'nama_sub_kegiatan' => trim($value['nomenklatur']),
						'tahun'			=> tahun_anggaran(),
						'updated_on'    => timestamp(),
						'updated_by'    => id_user(),
						'input_by' 		=> 'Web Service'
					];
				} 
				

				$cek = $this->db->get_where($table, $primary)->num_rows();

				if ($cek > 0) {
					$this->db->update($table, $update, $primary);
					$output['status'] 	= true;
					$output['messages'] = '{$cek} Data berhasil update';
				} else {
					$this->db->insert($table, $insert);
					$output['status'] 	= true;
					$output['messages'] = '{$cek} Data berhasil Disimpan';
				}
			}

			echo json_encode($cek);
		}
	}

	public function multi_sync()
	{
		if (!$this->input->is_ajax_request()) {
			show_404();
		} else {
			$result  	= [
				'success' => false,
				'messages' => ''
			];
			$req  		= $this->input->post('req');
			$tahap  	= $this->input->post('tahap');
			$data 		= [];
			if ($req == "aliran_kas") {
				$this->db->select('kode_opd');
				$opd = $this->db->get_where("master_instansi", ['kategori' => "OPD"])->result();

				foreach ($opd as $value) {
					$link 		= "http://182.253.192.82:8087/bangda/?tahun=" . tahun_anggaran() . "&req=angkas&key=CKFUP-DXRY-FKMH&tahap=" . $tahap . "&opd=" . $value->kode_opd;
					$data       = file_get_contents($link);
					$konversi   = json_decode($data, true);

					foreach ($konversi as $key => $value) {
						$table 		= "target_apbd";
						$primary 	= [
							'kode_rekening'			=> trim($value['KODEOPD']) . trim($value['KODEPROGRAM']) . trim($value['KODEKEGIATAN']),
							'bulan' 				=> $value['BULAN'],
							'kode_tahap'			=> $tahap,
							'tahun' 				=> tahun_anggaran(),
						];
						$insert 	= [
							'kode_rekening'			=> trim($value['KODEOPD']) . trim($value['KODEPROGRAM']) . trim($value['KODEKEGIATAN']),
							'bulan'					=> $value['BULAN'],
							'kode_tahap'			=> $tahap,
							'target_keuangan'		=> $value['NILAI'],
							'tahun' 				=> tahun_anggaran(),
							'created_on'    		=> timestamp(),
							'updated_on'    		=> timestamp(),
							'created_by'    		=> id_user(),
							'updated_by'    		=> id_user()
						];
						$update 	= [
							'target_keuangan'		=> $value['NILAI'],
							'updated_on'    		=> timestamp(),
							'updated_by'    		=> id_user()
						];

						$cek = $this->db->get_where($table, $primary)->num_rows();

						if ($cek > 0) {
							$this->db->update($table, $update, $primary);
						} else {
							$this->db->insert($table, $insert);
						}
					}
				}

				echo json_encode($cek);
			}
		}
	}

	public function realisasi_sync()
	{
		if (!$this->input->is_ajax_request()) {
			show_404();
		} else {
			$result  	= [
				'success' 	=> false,
				'messages' 	=> ''
			];
			$req 	= $this->input->post('req');
			$data 	= [];
			if ($req == "realisasi_keuangan") {
				for ($i = 5; $i <= 5; $i++) {
					$link 		= "http://182.253.192.82:8087/bangda/?tahun=" . tahun_anggaran() . "&req=spj&key=CKFUP-DXRY-FKMH&bulan=" . $i;
					$data       = file_get_contents($link);
					$konversi   = json_decode($data, true);

					foreach ($konversi as $key => $value) {
						$table 		= "realisasi_keuangan";
						$primary 	= [
							'kode_rekening'			=> trim($value['KODEOPD']) . trim($value['KODEPROGRAM']) . trim($value['KODEKEGIATAN']),
							'id_instansi'			=> id_instansi_kode_opd(trim($value['KODEOPD'])),
							'bulan' 				=> $i
						];
						$insert 	= [
							'kode_rekening'			=> trim($value['KODEOPD']) . trim($value['KODEPROGRAM']) . trim($value['KODEKEGIATAN']),
							'id_instansi'			=> id_instansi_kode_opd(trim($value['KODEOPD'])),
							'kode_opd' 				=> trim($value['KODEOPD']),
							'kode_urusan'			=> trim($value['KODEURUS']),
							'kode_program'			=> trim($value['KODEPROGRAM']),
							'kode_kegiatan' 		=> trim($value['KODEKEGIATAN']),
							'nama_kegiatan' 		=> trim($value['URAIAN']),
							'bulan'					=> $i,
							'tahun' 				=> tahun_anggaran(),
							'belanja_pegawai' 		=> $value['BP'],
							'belanja_barang_jasa' 	=> $value['BJ'],
							'belanja_modal'			=> $value['BM'],
							'created_on'    		=> timestamp(),
							'updated_on'    		=> timestamp(),
							'created_by'    		=> id_user(),
							'updated_by'    		=> id_user()
						];
						$update 	= [
							'belanja_pegawai' 		=> $value['BP'],
							'belanja_barang_jasa' 	=> $value['BJ'],
							'belanja_modal'			=> $value['BM'],
							'updated_on'    		=> timestamp(),
							'updated_by'    		=> id_user()
						];

						$cek = $this->db->get_where($table, $primary)->num_rows();

						if ($cek > 0) {
							$this->db->update($table, $update, $primary);
						} else {
							$this->db->insert($table, $insert);
						}
					}
				}

				echo json_encode($cek);
			}
		}
	}

	public function realisasi_sync_cron_tes_cronjob()
	{
		$tabel = "tes_cronjob";
		$data = [
			'nama'=> 'Hamid Septian',
			'alamat'=> "Ini adalah untuk mentes cronjob",
			'tgl_insert' => date('Y-m-d h:i:s')
		];
		$this->db->insert($tabel, $data);
	}
	public function monitoring_sipkd()
	{
		$tabel = "monitoring_skpd";
		$tgls = date('d') - 12;

				$urusan = "http://182.253.192.82:8087/bangda/?tahun=" . tahun_anggaran() . "&req=urusan&key=CKFUP-DXRY-FKMH";
				$masterprogram = "http://182.253.192.82:8087/bangda/?tahun=" . tahun_anggaran() . "&req=program&key=CKFUP-DXRY-FKMH";
				$master_kegiatan = "http://182.253.192.82:8087/bangda/?tahun=" . tahun_anggaran() . "&req=kegiatan&key=CKFUP-DXRY-FKMH";
				$kegiatan_apbd_t2 = "http://182.253.192.82:8087/bangda/?tahun=" . tahun_anggaran() . "&req=apbd&key=CKFUP-DXRY-FKMH&tahap=2";
				$kegiatan_apbd_t4 = "http://182.253.192.82:8087/bangda/?tahun=" . tahun_anggaran() . "&req=apbd&key=CKFUP-DXRY-FKMH&tahap=4";
					$realisasikeuangan 		= "http://182.253.192.82:8087/bangda/?tahun=" . tahun_anggaran() . "&req=spj&key=CKFUP-DXRY-FKMH&bulan=" . $tgls;

				$data_urusan       = file_get_contents($urusan);
				$data_masterprogram       = file_get_contents($masterprogram);
				$data_master_kegiatan       = file_get_contents($master_kegiatan);
				$data_kegiatan_apbd_t2       = file_get_contents($kegiatan_apbd_t2);
				$data_kegiatan_apbd_t4       = file_get_contents($kegiatan_apbd_t4);
				$data_realisasikeuangan       = file_get_contents($realisasikeuangan);

				$jumlah_data_urusan  = count(json_decode($data_urusan ));
				$jumlah_data_masterprogram = count(json_decode($data_masterprogram));
				$jumlah_data_master_kegiatan = count(json_decode($data_master_kegiatan));
				$jumlah_data_kegiatan_apbd_t2 = count(json_decode($data_kegiatan_apbd_t2));
				$jumlah_data_kegiatan_apbd_t4 = count(json_decode($data_kegiatan_apbd_t4));
				$jumlah_data_realisasikeuangan = count(json_decode($data_realisasikeuangan));

		$keterangan = "Data master urusan : ".$jumlah_data_urusan ."\n";
		$keterangan .= "Data master program : ".$jumlah_data_masterprogram."\n";
		$keterangan .= "Data master kegiatan : ".$jumlah_data_master_kegiatan."\n";
		$keterangan .= "Data master kegiatan apbd awal : ".$jumlah_data_kegiatan_apbd_t2."\n";
		$keterangan .= "Data master kegiatan apbd perubahan : ".$jumlah_data_kegiatan_apbd_t4."\n";
		$keterangan .= "Data master realisasi keuangan bulan ".$tgls." : ".$jumlah_data_realisasikeuangan."\n";

				


		$data = [
			'judul'=> 'Monitirong Cronjob',
			'keterangan'=> $keterangan,
			'waktu_input' => date('Y-m-d h:i:s')
		];
		$this->db->insert($tabel, $data);
	}
	public function realisasi_sync_cron()
	{
	
			$result  	= [
				'success' 	=> false,
				'messages' 	=> ''
			];
			$req 	= "realisasi_keuangan";
			$data 	= [];
			if ($req == "realisasi_keuangan") {
				for ($i = 1; $i <= 12; $i++) {
					$link 		= "http://182.253.192.82:8087/bangda/?tahun=" . tahun_anggaran() . "&req=spj&key=CKFUP-DXRY-FKMH&bulan=" . $i;
					$data       = file_get_contents($link);
					$konversi   = json_decode($data, true);

					foreach ($konversi as $key => $value) {
						$table 		= "realisasi_keuangan";
						$primary 	= [
							'kode_rekening'			=> trim($value['KODEOPD']) . trim($value['KODEPROGRAM']) . trim($value['KODEKEGIATAN']),
							'id_instansi'			=> id_instansi_kode_opd(trim($value['KODEOPD'])),
							'bulan' 				=> $i
						];
						$insert 	= [
							'kode_rekening'			=> trim($value['KODEOPD']) . trim($value['KODEPROGRAM']) . trim($value['KODEKEGIATAN']),
							'id_instansi'			=> id_instansi_kode_opd(trim($value['KODEOPD'])),
							'kode_opd' 				=> trim($value['KODEOPD']),
							'kode_urusan'			=> trim($value['KODEURUS']),
							'kode_program'			=> trim($value['KODEPROGRAM']),
							'kode_kegiatan' 		=> trim($value['KODEKEGIATAN']),
							'nama_kegiatan' 		=> trim($value['URAIAN']),
							'bulan'					=> $i,
							'tahun' 				=> tahun_anggaran(),
							'belanja_pegawai' 		=> $value['BP'],
							'belanja_barang_jasa' 	=> $value['BJ'],
							'belanja_modal'			=> $value['BM'],
							'created_on'    		=> timestamp(),
							'updated_on'    		=> timestamp(),
							'created_by'    		=> id_user(),
							'updated_by'    		=> id_user()
						];
						$update 	= [
							'belanja_pegawai' 		=> $value['BP'],
							'belanja_barang_jasa' 	=> $value['BJ'],
							'belanja_modal'			=> $value['BM'],
							'updated_on'    		=> timestamp(),
							'updated_by'    		=> id_user()
						];

						$cek = $this->db->get_where($table, $primary)->num_rows();

						if ($cek > 0) {
							$this->db->update($table, $update, $primary);
						} else {
							$this->db->insert($table, $insert);
						}
					}
				}

				echo json_encode($cek);
			}
		
	}
	public function empty_kegiatan_temp()
	{
		$this->db->truncate('kegiatan_apbd_temp');
	}

	public function sync_kegiatan_temp($tahap)
	{
		$link = "http://182.253.192.82:8087/bangda/?tahun=" . tahun_anggaran() . "&req=apbd&key=CKFUP-DXRY-FKMH&tahap=" . $tahap;
		$data       = file_get_contents($link);
		$konversi   = json_decode($data, true);

		foreach ($konversi as $key => $value) {
			if ($tahap == 2) {
				$table 		= "kegiatan_apbd_temp";
				$primary 	= [
					'kode_rekening'			=> trim($value['KODEOPD']) . trim($value['KODEPROGRAM']) . trim($value['KODEKEGIATAN']),
					'kode_tahap' 			=> 2,
					'kode_urusan'			=> trim($value['KODEURUS']),
				];
				$insert 	= [
					'kode_rekening_program'	=> trim($value['KODEOPD']) . trim($value['KODEPROGRAM']),
					'kode_rekening'			=> trim($value['KODEOPD']) . trim($value['KODEPROGRAM']) . trim($value['KODEKEGIATAN']),
					'kode_tahap'			=> 2,
					'id_instansi'			=> id_instansi_kode_opd(trim($value['KODEOPD'])),
					'kode_opd' 				=> trim($value['KODEOPD']),
					'kode_urusan'			=> trim($value['KODEURUS']),
					'id_program'			=> trim($value['IDPRGRM']),
					'id_kegiatan' 			=> trim($value['KDKEGUNIT']),
					'kode_program'			=> trim($value['KODEPROGRAM']),
					'kode_kegiatan' 		=> trim($value['KODEKEGIATAN']),
					'nama_kegiatan' 		=> trim($value['URAIKEG']),
					'belanja_pegawai' 		=> $value['BP'],
					'belanja_barang_jasa' 	=> $value['BJ'],
					'belanja_modal'			=> $value['BM'],
					'pagu'					=> $value['PAGU'],
					'output'				=> trim($value['Ouput']),
					'akumulasi'				=> 'N',
					'tahun' 				=> tahun_anggaran(),
					'created_on'    		=> timestamp(),
					'updated_on'    		=> timestamp(),
					'created_by'    		=> id_user(),
					'updated_by'    		=> id_user()
				];
			} elseif ($tahap == 4) {
				$table 		= "kegiatan_apbd_temp";
				$primary 	= [
					'kode_rekening'			=> trim($value['KODEOPD']) . trim($value['KODEPROGRAM']) . trim($value['KODEKEGIATAN']),
					'kode_tahap' 			=> 4
				];
				$insert 	= [
					'kode_rekening_program'	=> trim($value['KODEOPD']) . trim($value['KODEPROGRAM']),
					'kode_rekening'			=> trim($value['KODEOPD']) . trim($value['KODEPROGRAM']) . trim($value['KODEKEGIATAN']),
					'kode_tahap'			=> 4,
					'id_instansi'			=> id_instansi_kode_opd(trim($value['KODEOPD'])),
					'kode_opd' 				=> trim($value['KODEOPD']),
					'kode_urusan'			=> trim($value['KODEURUS']),
					'id_program'			=> trim($value['IDPRGRM']),
					'id_kegiatan' 			=> trim($value['KDKEGUNIT']),
					'kode_program'			=> trim($value['KODEPROGRAM']),
					'kode_kegiatan' 		=> trim($value['KODEKEGIATAN']),
					'nama_kegiatan' 		=> trim($value['URAIKEG']),
					'belanja_pegawai' 		=> $value['BP'],
					'belanja_barang_jasa' 	=> $value['BJ'],
					'belanja_modal'			=> $value['BM'],
					'pagu'					=> $value['PAGU'],
					'output'				=> trim($value['Ouput']),
					'akumulasi'				=> 'N',
					'tahun' 				=> tahun_anggaran(),
					'created_on'    		=> timestamp(),
					'updated_on'    		=> timestamp(),
					'created_by'    		=> id_user(),
					'updated_by'    		=> id_user()
				];
			}

			$this->db->insert($table, $insert);
		}
		$this->db->delete('kegiatan_apbd', ['kode_tahap' => $tahap]);
		$this->db->query("INSERT INTO kegiatan_apbd SELECT * FROM kegiatan_apbd_temp WHERE kode_tahap = {$tahap}");
	}

	public function do_clear_data($kode_tahap)
	{
		$this->clear_data('realisasi_keuangan', $kode_tahap);
		$this->clear_data('file_realisasi_fisik', $kode_tahap);
		$this->clear_data('volume_pelaksanaan_pekerjaan', $kode_tahap);
		$this->clear_data('user_kegiatan', $kode_tahap);
		$this->clear_data('sumber_dana', $kode_tahap);
		$this->clear_data('target', $kode_tahap);
	}

	public function download_data()
	{
		$this->load->library('zip');
		$path = './sbe_files_data/' . $this->sbe_tahun_anggaran();

		$this->zip->read_dir($path);

		// Download the file to your desktop. Name it "my_backup.zip"
		$this->zip->download('my_backup.zip');
	}

	public function clear_data($kategori, $kode_tahap)
	{
		if ($kategori == 'realisasi_keuangan') {
			$query   = "DELETE
						FROM
							realisasi_keuangan
						WHERE
							kode_rekening NOT IN (SELECT kode_rekening FROM kegiatan_apbd_temp)";
			$this->db->query($query);
		} elseif ($kategori == 'file_realisasi_fisik') {

			$fisik  = $this->db->query("SELECT
																		id_instansi,
																		id_paket_pekerjaan,
																		file_dokumen
																	FROM
																		realisasi_fisik
																	WHERE
																		kode_rekening_kegiatan NOT IN ( SELECT kode_rekening FROM kegiatan_apbd_temp )
																	GROUP BY
																		id_paket_pekerjaan");
			$data = [];
			foreach ($fisik->result() as $key => $value) {
				$primary_folder 	= './sbe_files_data/';
				$directory      	= [
					$this->sbe_tahun_anggaran(),
					slug($this->sbe_nama_instansi($value->id_instansi)),
					'REALISASI-FISIK',
					$value->id_paket_pekerjaan,
					$value->file_dokumen
				];

				$list_directory 	= $this->sbe_directory($primary_folder, $directory);
				$this->sbe_delete_files($list_directory);
				$this->db->delete('realisasi_fisik', ['id_paket_pekerjaan' => $value->id_paket_pekerjaan]);
			}
		} elseif ($kategori == 'volume_pelaksanaan_pekerjaan') {
			$query   = "SELECT
										id_paket_pekerjaan
									FROM
										paket_pekerjaan
									WHERE
										kode_rekening_kegiatan NOT IN (
										SELECT
											kode_rekening
										FROM
											kegiatan_apbd_temp)";
			$result = $this->db->query($query);
			foreach ($result->result() as $key => $value) {
				$this->db->delete('vol_pelaksanaan_pekerjaan', ['id_paket_pekerjaan' => $value->id_paket_pekerjaan]);
				$this->db->delete('kontrak_pekerjaan', ['id_paket_pekerjaan' => $value->id_paket_pekerjaan]);
			}

			$delete = $this->db->query("DELETE
																	FROM
																		paket_pekerjaan
																	WHERE
																		kode_rekening_kegiatan NOT IN (
																		SELECT
																			kode_rekening
																		FROM
																			kegiatan_apbd_temp)");
		} elseif ($kategori == 'user_kegiatan') {
			$delete = $this->db->query("DELETE
																	FROM
																		users_kegiatan
																	WHERE
																		kode_rekening_kegiatan NOT IN (
																		SELECT
																			kode_rekening
																		FROM
																			kegiatan_apbd_temp)");
		} elseif ($kategori == 'sumber_dana') {
			$delete = $this->db->query("DELETE
																	FROM
																		sumber_dana
																	WHERE
																		kode_rekening_kegiatan NOT IN (
																		SELECT
																			kode_rekening
																		FROM
																			kegiatan_apbd_temp)
																		AND
																			kode_tahap = {$kode_tahap}");
		} elseif ($kategori == 'target') {
			$delete = $this->db->query("DELETE
																	FROM
																		target_apbd
																	WHERE
																		kode_rekening NOT IN (
																		SELECT
																			kode_rekening
																		FROM
																			kegiatan_apbd_temp)
																		AND
																			kode_tahap = {$kode_tahap}");
		}
	}

	
	public function cek_data_sipkd()
	{
		$breadcrumbs    = $this->breadcrumbs;
		$sipkd  		= $this->sipkd_model;

		$breadcrumbs->add('Home', base_url());
		$breadcrumbs->add('Web Services', base_url('web_services'));
		$breadcrumbs->add('IN', base_url('web_services/sipkd'));
		$breadcrumbs->add('SIPKD', base_url(''));
		$breadcrumbs->render();

		$data['title']			  	= "SIPKD";
		$data['icon']			  	= "fa fa-bars";
		$data['description']	  	= "Sistem Informasi Pengelola Keuangan Daerah";
		$data['breadcrumbs']	  	= $breadcrumbs->render();
		$data['opd'] 	= $this->db->query("SELECT id_instansi, kode_opd, nama_instansi FROM master_instansi WHERE kategori = 'OPD' AND id_instansi != 3 ORDER BY kode_opd ASC")->result();
		$page 						= 'web_services/cek_data_sipkd/index';
		$data['link']   			= $this->router->fetch_class();
		$data['tahap']   			= tahapan_apbd();
		$data['menu'] 				= $this->load->view('layout/menu', $data, true);
		$data['extra_css']			= $this->load->view('web_services/cek_data_sipkd/css', $data, true);
		$data['extra_js']			= $this->load->view('web_services/cek_data_sipkd/js', $data, true);
		$data['modal']          	= "";
		error_reporting(0);
		// $link_kt4 = "http://182.253.192.82:8087/bangda/?tahun=" . tahun_anggaran() . "&req=apbd&key=CKFUP-DXRY-FKMH&tahap=4";
		// $data_kt4 =  file_get_contents($link_kt4);
		// $konversi_kt4   = json_decode($data_kt4, true);
		// $kegiatan_t4 = count($konversi_kt4);
		// $data['jkegiatant4_sipkd'] 		= $kegiatan_t4;
		// $data['jkegiatant4_sbe'] 		= $this->db->get_where('kegiatan_apbd', ['kode_tahap'=>'4'])->num_rows();




		// $link_kt2 = "http://182.253.192.82:8087/bangda/?tahun=" . tahun_anggaran() . "&req=apbd&key=CKFUP-DXRY-FKMH&tahap=2";
		// $data_kt2 =  file_get_contents($link_kt2);
		// $konversi_kt2   = json_decode($data_kt2, true);
		// $kegiatan_t2 = count($konversi_kt2);
		// $data['jkegiatant2_sipkd'] 		= $kegiatan_t2;
		// $data['jkegiatant2_sbe'] 		= $this->db->get_where('kegiatan_apbd', ['kode_tahap'=>'2'])->num_rows();


		// $link_urusan ="http://182.253.192.82:8087/bangda/?tahun=" . tahun_anggaran() . "&req=urusan&key=CKFUP-DXRY-FKMH";
		// $data_urusan =  file_get_contents($link_urusan);
		// $konversi_urusan   = json_decode($data_urusan, true);
		// $data_urusan = count($konversi_urusan);
		// $data['jurusan_sipkd'] 		= $data_urusan;
		// $data['jurusan_sbe'] 		= $this->db->get('master_urusan')->num_rows();



		// $link_program ="http://182.253.192.82:8087/bangda/?tahun=" . tahun_anggaran() . "&req=program&key=CKFUP-DXRY-FKMH";
		// $data_program =  file_get_contents($link_program);
		// $konversi_program   = json_decode($data_program, true);
		// $data_program = count($konversi_program);
		// $data['jprogram_sipkd'] 		= $data_program;
		// $data['jprogram_sbe'] 		= $this->db->get('master_program')->num_rows();



		// $link_kegiatan ="http://182.253.192.82:8087/bangda/?tahun=" . tahun_anggaran() . "&req=kegiatan&key=CKFUP-DXRY-FKMH";
		// $data_kegiatan =  file_get_contents($link_kegiatan);
		// $konversi_kegiatan   = json_decode($data_kegiatan, true);
		// $data_kegiatan = count($konversi_kegiatan);
		// $data['jkegiatan_sipkd'] 		= $data_kegiatan;
		// $data['jkegiatan_sbe'] 		= $this->db->get('master_kegiatan')->num_rows();


		
		$this->template->load('backend_template', $page, $data);
	}



	public function cek_kecocokan_data_per_skpd()
	{
		if (!$this->input->is_ajax_request()) {
			show_404();
		} else {
			$output = [
				'status' 	=> false,
				'data' 		=> []
			];

			$opd 	= $this->db->query("SELECT id_instansi, kode_opd, nama_instansi FROM master_instansi WHERE kategori = 'OPD' AND id_instansi != 3 ORDER BY kode_opd ASC")->result();

			foreach ($opd as $key => $value) {

				// cek data aliran kas awal (disahkan)
				$link_alirankas_awal       = "http://182.253.192.82:8087/bangda/?tahun=2020&req=angkas&key=CKFUP-DXRY-FKMH&tahap=2&opd=" . $value->kode_opd;
				$data_alirankas_awal       = file_get_contents($link_alirankas_awal);
				$konversi_alirankas_awal   = json_decode($data_alirankas_awal, true);
				$jdata_sipkd_alirankas_awal = count($konversi_alirankas_awal);
				$idinstansi= id_instansi_kode_opd(trim($value->kode_opd));
				$jdata_simbangda_alirankas_awal = $this->db->query("SELECT id_target_apbd from target_apbd where id_instansi = '$idinstansi' and kode_tahap = '2'")->num_rows();
				$selisih_alirankas_awal = $jdata_sipkd_alirankas_awal - $jdata_simbangda_alirankas_awal;


				// cek data aliran kas perubahan
				$link_alirankas_perubahan       = "http://182.253.192.82:8087/bangda/?tahun=2020&req=angkas&key=CKFUP-DXRY-FKMH&tahap=4&opd=" . $value->kode_opd;
				$data_alirankas_perubahan       = file_get_contents($link_alirankas_perubahan);
				$konversi_alirankas_perubahan   = json_decode($data_alirankas_perubahan, true);
				$jdata_sipkd_alirankas_perubahan = count($konversi_alirankas_perubahan);
				$idinstansi= id_instansi_kode_opd(trim($value->kode_opd));
				$jdata_simbangda_alirankas_perubahan = $this->db->query("SELECT id_target_apbd from target_apbd where id_instansi = '$idinstansi' and kode_tahap = '4'")->num_rows();
				$selisih_alirankas_perubahan = $jdata_sipkd_alirankas_perubahan - $jdata_simbangda_alirankas_perubahan;



				$output['data'][$key]['id_instansi'] 	= $value->id_instansi;
				$output['data'][$key]['kode_opd'] 		= $value->kode_opd;
				$output['data'][$key]['nama_instansi'] 	= $value->nama_instansi;

				$output['data'][$key]['jdata_sipkd_alirankas_perubahan'] 	= $jdata_sipkd_alirankas_perubahan;
				$output['data'][$key]['jdata_simbangda_alirankas_perubahan'] 	= $jdata_simbangda_alirankas_perubahan;
				$output['data'][$key]['selisih_alirankas_perubahan'] 	= $selisih_alirankas_perubahan;

				$output['data'][$key]['jdata_sipkd_alirankas_awal'] 	= $jdata_sipkd_alirankas_awal;
				$output['data'][$key]['jdata_simbangda_alirankas_awal'] 	= $jdata_simbangda_alirankas_awal;
				$output['data'][$key]['selisih_alirankas_awal'] 	= $selisih_alirankas_awal;

				$output['status'] = true;
			}

			echo json_encode($output);
		}
	}
}
