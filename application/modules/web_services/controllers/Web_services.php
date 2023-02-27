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
		$this->load->model([
			'web_services/sipkd_model' => 'sipkd_model',
            'dashboard/dashboard_model'       => 'dashboard_model',
           
			'realisasi/realisasi_fisik_keuangan_model'    => 'realisasi_fisik_keuangan_model',
			'Laporan/realisasi_akumulasi_model'		=> 'realisasi_akumulasi_model',
			'Laporan/rekap_asisten_model'					=> 'rekap_asisten_model',
			'Laporan/ratarata_fisik_keuangan'					=> 'ratarata_fisik_keuangan',
			'Laporan/rekap_realisasi_total_model'	=> 'rekap_realisasi_total_model',
			'Laporan/jumlah_aktivitas_model'	=> 'jumlah_aktivitas_model',
			'Laporan/rekap_kegiatan_kab_kota'	=> 'rekap_kegiatan_kab_kota',
			'Laporan/lap_realisasi_fisik_keu'	=> 'lap_realisasi_fisik_keu',
			'Laporan/realisasi_per_kab_kota'	=> 'realisasi_per_kab_kota',
			'Laporan/realisasi_gabungan_per_kab_kota'	=> 'realisasi_gabungan_per_kab_kota',
			'Laporan/target_realisasi_model'	=> 'target_realisasi_model',
			'Laporan/rekap_permasalahan_model'	=> 'rekap_permasalahan_model',
			'config/config_model' => 'config_model',
			'data_apbd/data_apbd_model'      => 'data_apbd_model',
		]);
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

			$opd 	= $this->db->query("SELECT id_instansi, kode_opd, nama_instansi, bulan_mulai_realisasi, bulan_akhir_realisasi, is_active FROM master_instansi WHERE kategori = 'OPD' AND is_active =1 ORDER BY nama_instansi ASC")->result();
			$status = ['Tidak Aktif','Aktif'];
			foreach ($opd as $key => $value) {
				$output['data'][$key]['id_instansi'] 	= $value->id_instansi;
				$output['data'][$key]['kode_opd'] 		= $value->kode_opd;
				$output['data'][$key]['nama_instansi'] 	= $value->nama_instansi;
				$output['data'][$key]['bulan_mulai_realisasi'] 	= bulan_global($value->bulan_mulai_realisasi);
				$output['data'][$key]['bulan_akhir_realisasi'] 	= bulan_global($value->bulan_akhir_realisasi);
				$output['data'][$key]['status'] 	= $status[$value->is_active];
				$output['status'] = true;
			}

			echo json_encode($output);
		}
	}

	public function aliran_kas()
	{
		if ($this->input->is_ajax_request()) {
			show_404();
		} else {
			$output 	= [
				'status' 	=> false,
				'messages' 	=> ''
			];

			$tahap  	= 2;//$this->input->post('tahap');
			$kode_opd  	= '';//$this->input->post('kode_opd');

			$data 		= [];

			$link 		= "http://182.253.192.82:8087/bangda/?tahun=" . tahun_anggaran() . "&req=angkas&key=CKFUP-DXRY-FKMH&tahap=" . $tahap . "&opd=" . $kode_opd;
			echo $link;
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
					// $this->db->update($table, $update, $primary);
					$output['status'] 	= true;
					$output['messages'] = '{$cek} Data berhasil update';
				} else {
					// $this->db->insert($table, $insert);
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

	
    public function backup_db(){
        $this->load->helper('url');
        $this->load->helper('file');
        $this->load->helper('download');
        $this->load->library('zip');





			$primary_folder         = './sbe_files_support/';
            $directory              = [
                'backup_db',
                date('Y-m-d')
            ];
            $list_directory         = $this->sbe_directory($primary_folder, $directory);

            if (!file_exists($list_directory)) {
                mkdir($list_directory, 0777, TRUE);
            }
        $this->load->dbutil();
        $db_format = array('format'=>'zip', 'filename'=>'sbe_2021.sql');
        $backup = $this->dbutil->backup($db_format);
        $dbname = date('Y-m-d h.i.s').'.zip';
        $save = $list_directory.'/'.$dbname;
        write_file($save, $backup);
        // force_download($dbname, $backup);
    }






    public function grafik_skpd($result = '')
    {
        $id_instansi = $this->input->post('id_instansi');
        $q = $this->db->query("SELECT nama_instansi from master_instansi where id_instansi = '$id_instansi'");
        $nama_instansi = $q->row()->nama_instansi;
        
        $fisik   = [];
        $keu     = [];
        $rea     = [];
        $r_fisik = [];
        $d_fisik = [];
        $d_keu = [];
            $sync    = $this->dashboard_model->get_grafik($id_instansi)->row();

            $fisik[]['jan'] = (float) $sync->tf_jan;
            $fisik[]['feb'] = (float) $sync->tf_feb;
            $fisik[]['mar'] = (float) $sync->tf_mar;
            $fisik[]['april'] = (float) $sync->tf_apr;
            $fisik[]['mei'] = (float) $sync->tf_mei;
            $fisik[]['juni'] = (float) $sync->tf_jun;
            $fisik[]['juli'] = (float) $sync->tf_jul;
            $fisik[]['agus'] = (float) $sync->tf_agu;
            $fisik[]['sep'] = (float) $sync->tf_sep;
            $fisik[]['okt'] = (float) $sync->tf_okt;
            $fisik[]['nov'] = (float) $sync->tf_nov;
            $fisik[]['des'] = (float) $sync->tf_des;

            $keu[]['jan'] = (float) $sync->tk_jan;
            $keu[]['feb'] = (float) $sync->tk_feb;
            $keu[]['mar'] = (float) $sync->tk_mar;
            $keu[]['april'] = (float) $sync->tk_apr;
            $keu[]['mei'] = (float) $sync->tk_mei;
            $keu[]['juni'] = (float) $sync->tk_jun;
            $keu[]['juli'] = (float) $sync->tk_jul;
            $keu[]['agus'] = (float) $sync->tk_agu;
            $keu[]['sep'] = (float) $sync->tk_sep;
            $keu[]['okt'] = (float) $sync->tk_okt;
            $keu[]['nov'] = (float) $sync->tk_nov;
            $keu[]['des'] = (float) $sync->tk_des;

            $r_fisik[]['jan'] = (float) $sync->rf_jan > 0 ? (float) $sync->rf_jan : 0;
            $r_fisik[]['feb'] = (float) $sync->rf_feb > 0 ? (float) $sync->rf_feb : 0;
            $r_fisik[]['mar'] = (float) $sync->rf_mar > 0 ? (float) $sync->rf_mar : 0;
            $r_fisik[]['april'] = (float) $sync->rf_apr > 0 ? (float) $sync->rf_apr : 0;
            $r_fisik[]['mei'] = (float) $sync->rf_mei > 0 ? (float) $sync->rf_mei : 0;
            $r_fisik[]['juni'] = (float) $sync->rf_jun > 0 ? (float) $sync->rf_jun : 0;
            $r_fisik[]['juli'] = (float) $sync->rf_jul > 0 ? (float) $sync->rf_jul : 0;
            $r_fisik[]['agus'] = (float) $sync->rf_agu > 0 ? (float) $sync->rf_agu : 0;
            $r_fisik[]['sep'] = (float) $sync->rf_sep > 0 ? (float) $sync->rf_sep : 0;
            $r_fisik[]['okt'] = (float) $sync->rf_okt > 0 ? (float) $sync->rf_okt : 0;
            $r_fisik[]['nov'] = (float) $sync->rf_nov > 0 ? (float) $sync->rf_nov : 0;
            $r_fisik[]['des'] = (float) $sync->rf_des > 0 ? ((float) $sync->rf_des > 100 ? 100 : (float) $sync->rf_des) : 0;

            $rea[]['jan'] = (float) $sync->rk_jan > 0 ? (float) $sync->rk_jan : 0;
            $rea[]['feb'] = (float) $sync->rk_feb > 0 ? (float) $sync->rk_feb : $rea[0]['jan'];
            $rea[]['mar'] = (float) $sync->rk_mar > 0 ? (float) $sync->rk_mar : $rea[1]['feb'];
            $rea[]['april'] = (float) $sync->rk_apr > 0 ? (float) $sync->rk_apr : $rea[2]['mar'];
            $rea[]['mei'] = (float) $sync->rk_mei > 0 ? (float) $sync->rk_mei : $rea[3]['april'];
            $rea[]['juni'] = (float) $sync->rk_jun > 0 ? (float) $sync->rk_jun : $rea[4]['mei'];
            $rea[]['juli'] = (float) $sync->rk_jul > 0 ? (float) $sync->rk_jul : $rea[5]['juni'];
            $rea[]['agus'] = (float) $sync->rk_agu > 0 ? (float) $sync->rk_agu : $rea[6]['juli'];
            $rea[]['sep'] = (float) $sync->rk_sep > 0 ? (float) $sync->rk_sep : $rea[7]['agus'];
            $rea[]['okt'] = (float) $sync->rk_okt > 0 ? (float) $sync->rk_okt : $rea[8]['sep'];
            $rea[]['nov'] = (float) $sync->rk_nov > 0 ? (float) $sync->rk_nov : $rea[9]['okt'];
            $rea[]['des'] = (float) $sync->rk_des > 0 ? (float) $sync->rk_des : $rea[10]['nov'];

            $d_fisik[]['jan'] = round((float) $r_fisik[0]['jan'] - (float) $fisik[0]['jan'], 2) ;
            $d_fisik[]['feb'] = round((float) $r_fisik[1]['feb'] - (float) $fisik[1]['feb'], 2) ;
            $d_fisik[]['mar'] = round((float) $r_fisik[2]['mar'] - (float) $fisik[2]['mar'], 2) ;
            $d_fisik[]['april'] = round((float) $r_fisik[3]['april'] - (float) $fisik[3]['april'], 2) ;
            $d_fisik[]['mei'] = round((float) $r_fisik[4]['mei'] - (float) $fisik[4]['mei'], 2) ;
            $d_fisik[]['juni'] = round((float) $r_fisik[5]['juni'] - (float) $fisik[5]['juni'], 2) ;
            $d_fisik[]['juli'] = round((float) $r_fisik[6]['juli'] - (float) $fisik[6]['juli'], 2) ;
            $d_fisik[]['agus'] = round((float) $r_fisik[7]['agus'] - (float) $fisik[7]['agus'], 2) ;
            $d_fisik[]['sep'] = round((float) $r_fisik[8]['sep'] - (float) $fisik[8]['sep'], 2) ;
            $d_fisik[]['okt'] = round((float) $r_fisik[9]['okt'] - (float) $fisik[9]['okt'], 2) ;
            $d_fisik[]['nov'] = round((float) $r_fisik[10]['nov'] - (float) $fisik[10]['nov'], 2) ;
            $d_fisik[]['des'] = round((float) $r_fisik[11]['des'] - (float) $fisik[11]['des'], 2) ;

            $d_keu[]['jan'] = round((float) $rea[0]['jan'] - (float) $keu[0]['jan'], 2) ;
            $d_keu[]['feb'] = round((float) $rea[1]['feb'] - (float) $keu[1]['feb'], 2) ;
            $d_keu[]['mar'] = round((float) $rea[2]['mar'] - (float) $keu[2]['mar'], 2) ;
            $d_keu[]['april'] = round((float) $rea[3]['april'] - (float) $keu[3]['april'], 2) ;
            $d_keu[]['mei'] = round((float) $rea[4]['mei'] - (float) $keu[4]['mei'], 2) ;
            $d_keu[]['juni'] = round((float) $rea[5]['juni'] - (float) $keu[5]['juni'], 2) ;
            $d_keu[]['juli'] = round((float) $rea[6]['juli'] - (float) $keu[6]['juli'], 2) ;
            $d_keu[]['agus'] = round((float) $rea[7]['agus'] - (float) $keu[7]['agus'], 2) ;
            $d_keu[]['sep'] = round((float) $rea[8]['sep'] - (float) $keu[8]['sep'], 2) ;
            $d_keu[]['okt'] = round((float) $rea[9]['okt'] - (float) $keu[9]['okt'], 2) ;
            $d_keu[]['nov'] = round((float) $rea[10]['nov'] - (float) $keu[10]['nov'], 2) ;
            $d_keu[]['des'] = round((float) $rea[11]['des'] - (float) $keu[11]['des'], 2) ;
        

        $output = [];
        $output['status'] = true;
        $output['nama_instansi'] = $nama_instansi;
        $output['target_fisik'] = $fisik;
        $output['target_keuangan']   = $keu;
        $output['realisasi_fisik'] = $r_fisik;
        $output['realisasi_keuangan'] = $rea;
        $output['deviasi_fisik'] = $d_fisik;
        $output['deviasi_keuangan'] = $d_keu;

        if ($result == '') :
            header('Content-Type: application/json');
            echo json_encode($output);
        else :
            return $output;
        endif;
    }



    public function grafik_total($result = '')
    {
        $fisik   = [];
        $keu     = [];
        $rea     = [];
        $r_fisik = [];
        $d_fisik = [];
        $d_keu = [];

             $sync    = $this->dashboard_model->get_grafik_total()->result();
             $bulan = ['jan','feb','mar','april','mei','juni','juli','agus','sep','okt','nov','des']; 
            foreach ($sync as $key => $value) {
                $fisik[$key][$bulan[$key]]   = (float) $value->target_fisik;
                $keu[$key][$bulan[$key]]     = (float) $value->target_keuangan;
                $rea[$key][$bulan[$key]]     = (float) $value->realisasi_keuangan;
                $r_fisik[$key][$bulan[$key]] = (float) $value->realisasi_fisik;
                $d_fisik[$key][$bulan[$key]] = round((float) $value->realisasi_fisik - (float) $value->target_fisik,2) ;
                $d_keu[$key][$bulan[$key]] = round((float) $value->realisasi_keuangan - (float) $value->target_keuangan, 2);
            }



        $output = [];
        $output['status'] = true;
        $output['target_fisik'] = $fisik;
        $output['target_keuangan']   = $keu;
        $output['realisasi_fisik'] = $r_fisik;
        $output['realisasi_keuangan'] = $rea;
        $output['deviasi_fisik'] = $d_fisik;
        $output['deviasi_keuangan'] = $d_keu;
        // $output['bulan_laporan'] = date('n');

        if ($result == '') :
            header('Content-Type: application/json');
            echo json_encode($output);
        else :
            return $output;
        endif;
    }



    public function jenis_laporan()
    {

            $output     = [
                'status' => false, 
                'message' => '', 
               
                'data'=>[]
            ];

           // $output['data'] = array();
            $android       = $this->android_model;
            $id_provinsi = 13; //$this->input->post('id_provinsi');
            $tahap = tahapan_apbd();

            $jenis_laporan = $this->db->query("SELECT * from api_jenis_laporan ")->result();
            $parameter_jenis_laporan = $this->db->query("SELECT * from  parameter_jenis_laporan")->result();
         	$link = base_url().'android/';
                foreach ($jenis_laporan as $key => $value) {
		            $kumpul_parameter = [];
		            foreach ($parameter_jenis_laporan as $k => $v) {
		            	$cek_kelompok_laporan = $this->cek_parameter_jenis_laporan($value->id_jenis_laporan, $v->id_parameter);
		            	$value_parameter = $this->value_parameter_laporan($v->id_parameter, $v->melibatkan_tabel, $v->kolom_ditampilkan, $v->kondisi_tabel);
		            	$data = [
		            		'nama_parameter'=>$v->nama_parameter,
		            		'kode'=>$v->kode_parameter,
		            		'status'=> $cek_kelompok_laporan > 0 ? true : false,
		            		'value'=> $cek_kelompok_laporan > 0 ? $value_parameter : []
		            	];
		            	array_push($kumpul_parameter, $data);	
		            }
                
                    $output['data'][$key]['id_jenis_laporan'] = $value->id_jenis_laporan;
                    $output['data'][$key]['nama_jenis_laporan'] = $value->nama_jenis_laporan;
                    $output['data'][$key]['keterangan_laporan'] = $value->keterangan_laporan;
                    $output['data'][$key]['url_laporan'] = $link.$value->url_laporan;
                    $output['data'][$key]['parameter'] = $kumpul_parameter	;
                    $output['data'][$key]['status'] = $value->status;
                    
                }
                
                $output['status'] = true;
            
           
            header('Content-Type: application/json');
            echo json_encode($output);
        
    }
    public function cek_parameter_jenis_laporan($id_jenis_laporan, $id_parameter)
    {

            $jenis_laporan = $this->db->query("SELECT * from kelompok_parameter_jenis_laporan where 
             id_jenis_laporan='$id_jenis_laporan' and id_parameter='$id_parameter'")->num_rows();
            return $jenis_laporan;;
        
    }
    public function value_parameter_laporan($id_parameter, $tabel, $select, $where)
    {
    		if ($tabel=='') {
    			$data = $this->db->query("SELECT value, caption from value_parameter_jenis_laporan where id_parameter='$id_parameter'")->result_array();
    			
    			// $this->db->query();
    		}
    		else if ($tabel=='bulan') {
    			$data = [];
    			$banyak = $select == '' ? 0 : $select;	
    			for ($i=1; $i <= $banyak ; $i++) { 
    				$tampung = [
    					'value'=>$i,
    					'caption'=>bulan_global($i)
    				];
    				array_push($data, $tampung);
    			}
    			
    			// $this->db->query();
    		}else{
    			$select_data = $select =='' ? '*' : $select;
    			$data = $this->db->query("SELECT $select_data from $tabel $where")->result_array();
    		}


            $jenis_laporan = $this->db->query("SELECT * from kelompok_parameter_jenis_laporan where 
             id_parameter='$id_parameter'")->num_rows();
            return $data;
        
    }






    // ---------------------------------------------------------------------------------------------------------------------
    // Untuk cetak pdf laporan



	public function pdf_laporan_realisasi_akumulasi()
	{
		$mpdf = new \Mpdf\Mpdf([
		    'mode' => 'utf-8',
		    'format' => 'Legal',
		    'orientation' => 'L',
		    'tempDir' => '/tmp'
		]);


		// $mpdf->setFooter('Page {PAGENO}');
		global $id_instansi;
		global $kategori;
		global $bulan;

		// $id_instansi 	= sbe_crypt($this->input->get('id_opd'), 'D');
    $id_instansi = $this->input->get('id_instansi');
		// $id_instansi 	= $this->input->get('id_opd');
		$kategori 		= $this->input->get('kategori');
		$bulan 				= $this->input->get('bulan');
		switch ($kategori) {
			case 'akumulasi':
				$ope = '<=';
				$judul_laporan = "Laporan realisasi sampai dengan bulan ".bulan_global($bulan);
				break;
			default:
				$ope = '=';
				$judul_laporan = "Laporan realisasi bulan ".bulan_global($bulan);
				break;
		}

	    $program = $this->realisasi_akumulasi_model->get_program($id_instansi)->result();
	    $data['program']=$program;
	    $data['ope']=$ope;
	    $data['bulan']=$bulan;
	    $data['id_instansi']=$id_instansi;
	    $nama_instansi = $this->sbe_nama_instansi($id_instansi);
	    $data['judul_laporan']=$judul_laporan;
	    $data['title']=$judul_laporan.' '.$nama_instansi;
	    $data['nama_instansi']=$nama_instansi;
	    $data['grafik'] = $this->db->get_where('grafik',['id_instansi'=>$id_instansi, 'bulan'=>$bulan])->row();
	    $html =  $this->load->view('laporan/pdf/realisasi_akumulasi/content', $data, true);

	    $header =  $this->load->view('laporan/pdf/realisasi_akumulasi/header', $data, true);
	    $footer =  $this->load->view('laporan/pdf/realisasi_akumulasi/footer', $data, true);

	    $mpdf->SetMargins(0, 0, 42);

		$mpdf->SetHTMLHeader($header);
		$mpdf->SetHTMLFooter($footer);
		$mpdf->WriteHTML($html);
		$mpdf->Output($judul_laporan.' - '.$nama_instansi.'.pdf', 'I');
	}


//

	public function pdf_laporan_realisasi_per_kab_kota()
	{
		error_reporting(0);
		$mpdf = new \Mpdf\Mpdf([
		    'mode' => 'utf-8',
		    'format' => [210,330],
		    'orientation' => 'L',
		    'tempDir' => '/tmp'
		]);


		// $mpdf->setFooter('Page {PAGENO}');
		global $id_instansi;
		global $kategori;
		global $bulan;
		$fisik_keuangan       = $this->realisasi_fisik_keuangan_model;
        $config_model       = $this->config_model;

		$id_kota 	= $this->input->get('id_kota');
		$id_provinsi 	= $this->input->get('id_provinsi');


		$kategori 		= $this->input->get('kategori');
		$bulan 				= $this->input->get('bulan');

		$config =  $this->config_model->config_kab_kota($id_provinsi, $id_kota)->row();
		// $tahap = $tahap = config_kab_kota()->tahapan_apbd;
		$nama_tahap = [2=>'APBD AWAL',4=>'APBD PERUBAHAN'];
		$nama_kota = $this->realisasi_per_kab_kota->nama_kota($id_kota)->row()->nama_kota;
		switch ($kategori) {
			case 'akumulasi':
				$ope = '<=';
				$judul_laporan = "Laporan realisasi Fisik dan Keuangan (RFK) ".$nama_tahap[$config->tahapan_apbd]."<br>".$nama_kota."<br>sampai dengan bulan ".bulan_global($bulan).' '.tahun_anggaran();
				break;
			default:
				$ope = '=';
				$judul_laporan = "Laporan realisasi Fisik dan Keuangan (RFK) <br>".$nama_kota."<br>bulan ".bulan_global($bulan).' '.tahun_anggaran();
				break;
		}

	    $skpd = $this->realisasi_per_kab_kota->instansi_kab_kota($id_provinsi,$id_kota)->result();
	    $data['bulan_aktif']=$bulan;	
	    $data['tahap']=$config->tahapan_apbd;	
	    $data['nama_tahap']=$nama_tahap[$config->tahapan_apbd];	
	    $data['fisik_keuangan']=$fisik_keuangan;	
	    $data['skpd']=$skpd;	
	    $data['judul_laporan']=strtoupper($judul_laporan);	
	    $data['title']=$judul_laporan;	
	    $data['config']=$config;	
	    $data['nama_kota']=$nama_kota;	
	  
	    $html =  $this->load->view('laporan/pdf/realisasi_per_kab_kota/content', $data, true);

	    $header =  $this->load->view('laporan/pdf/realisasi_per_kab_kota/header', $data, true);
	    $footer =  $this->load->view('laporan/pdf/realisasi_per_kab_kota/footer', $data, true);

	    $mpdf->SetMargins(0, 0, 48);

		$mpdf->SetHTMLHeader($header);
		$mpdf->SetHTMLFooter($footer);
		$mpdf->WriteHTML($html);
		$mpdf->Output($judul_laporan.' - '.$nama_instansi.'.pdf', 'I');
	}


	public function pdf_laporan_gabungan_realisasi_per_kab_kota()
	{
		$mpdf = new \Mpdf\Mpdf([
		    'mode' => 'utf-8',
		    'format' => [210,330],
		    'orientation' => 'L',
		    'tempDir' => '/tmp'
		]);


		// $mpdf->setFooter('Page {PAGENO}');
		global $id_instansi;
		global $kategori;
		global $bulan;

		
		$id_provinsi 	= $this->input->get('id_provinsi');

		$kategori 		= $this->input->get('kategori');
		$bulan 				= $this->input->get('bulan');
		$fisik_keuangan       = $this->realisasi_fisik_keuangan_model;
		$model_realisasi_gabungan	       = $this->realisasi_gabungan_per_kab_kota;
		// $tahap = $tahap = config_kab_kota()->tahapan_apbd;
		$nama_tahap = [2=>'APBD AWAL',4=>'APBD PERUBAHAN'];
		$show_nama_tahap=$nama_tahap[tahapan_apbd()];	
		switch ($kategori) {
			case 'akumulasi':
				$ope = '<=';
				$judul_laporan = "Rekapitulasi <br>Laporan realisasi Fisik dan Keuangan (RFK) ".$show_nama_tahap." <br>sampai dengan bulan ".bulan_global($bulan).' '.tahun_anggaran();
				break;
			default:
				$ope = '=';
				$judul_laporan = "Rekapitulasi <br>Laporan realisasi Fisik dan Keuangan (RFK) ".$show_nama_tahap."<br>bulan ".bulan_global($bulan).' '.tahun_anggaran();
				break;
		}

	    $list_kota = $this->db->get_where('kota',['id_provinsi'=>$id_provinsi])->result();
	    $data['list_kota']=$list_kota;	
	    $data['tahap']=tahapan_apbd();	
	    $data['nama_tahap']=$nama_tahap[tahapan_apbd()];	
	    $data['model_realisasi_gabungan']=$model_realisasi_gabungan;	
	    $data['bulan']=$bulan;	
	    $data['judul_laporan']=strtoupper($judul_laporan);	
	    $data['title']=str_replace('<br>', ' ', $judul_laporan);	
	  
	    $html =  $this->load->view('laporan/pdf/realisasi_gabungan_per_kab_kota/content', $data, true);

	    $header =  $this->load->view('laporan/pdf/realisasi_gabungan_per_kab_kota/header', $data, true);
	    $footer =  $this->load->view('laporan/pdf/realisasi_gabungan_per_kab_kota/footer', $data, true);

	    $mpdf->SetMargins(0, 0, 48);

		$mpdf->SetHTMLHeader($header);
		$mpdf->SetHTMLFooter($footer);
		$mpdf->WriteHTML($html);
		$mpdf->Output($judul_laporan.' - '.$nama_instansi.'.pdf', 'I');
	}



	public function pdf_rekap_laporan_permasalahan_sub_kegiatan()
	{
		$mpdf = new \Mpdf\Mpdf([
		    'mode' => 'utf-8',
		    'format' => 'Legal',
		    'orientation' => 'L',
		    'tempDir' => '/tmp'
		]);


		// $mpdf->setFooter('Page {PAGENO}');
		global $id_instansi;
		global $kategori;
		global $bulan;



	    $instansi = $this->rekap_permasalahan_model->instansi_yang_menyampaikan()->result();
	    $judul_laporan = 'Rekap laporan permasalahan sub Kegiatan yang disampaikan oleh SKPD';
	    $data['judul_laporan']=$judul_laporan;
	    $data['kode_tahap']=tahapan_apbd();
	    $data['title']=$judul_laporan;
	    $data['instansi_yang_menyampaikan']=$instansi;
	    $html =  $this->load->view('laporan/pdf/rekap_semua_permasalahan_sub_kegiatan/content', $data, true);

	    $header =  $this->load->view('laporan/pdf/rekap_semua_permasalahan_sub_kegiatan/header', $data, true);
	    $footer =  $this->load->view('laporan/pdf/rekap_semua_permasalahan_sub_kegiatan/footer', $data, true);

	    $mpdf->SetMargins(0, 0, 42);

		$mpdf->SetHTMLHeader($header);
		// $mpdf->SetHTMLFooter($footer);
		$mpdf->WriteHTML($html);
		$mpdf->Output($judul_laporan.'.pdf', 'I');
	}


	public function pdf_laporan_rekap_asisten()
	{
		$mpdf = new \Mpdf\Mpdf([
		    'mode' => 'utf-8',
		    'format' => 'legal',
		    'orientation' => 'L',
		    'tempDir' => '/tmp'
		]);


		
		global $bulan;
		$bulan 				= $this->input->get('bulan');
	
	    $program = $this->realisasi_akumulasi_model->get_program($id_instansi)->result();
       $deskripsi_bulan = 'Per ' . jml_hari_dalam_bulan($bulan, tahun_anggaran()) . ' ' . bulan_global($bulan) . ' ' . tahun_anggaran();
	    $data['desc_bulan']=$deskripsi_bulan;

	    $asisten_1 = $this->rekap_asisten_model->get_opd_asisten(204, $bulan)->result();
		$asisten_2 = $this->rekap_asisten_model->get_opd_asisten(205, $bulan)->result();
		$asisten_3 = $this->rekap_asisten_model->get_opd_asisten(206, $bulan)->result();




	    $judul_laporan="Rekapitulasi SIMBANGDA Based Evidence Per SKPD ". $deskripsi_bulan;
	    $data['asisten_1']=$asisten_1;
	    $data['asisten_2']=$asisten_2;
	    $data['asisten_3']=$asisten_3;

	    $html =  $this->load->view('laporan/pdf/realisasi_asisten/content', $data, true);

	    $header =  $this->load->view('laporan/pdf/realisasi_asisten/header', $data, true);
	    $footer =  $this->load->view('laporan/pdf/realisasi_asisten/footer', $data, true);

	    $mpdf->SetMargins(0, 0, 35);

		$mpdf->SetHTMLHeader($header);
		$mpdf->SetHTMLFooter($footer);
		$mpdf->WriteHTML($html);
		$mpdf->Output($judul_laporan.'.pdf', 'I');
	}



	public function pdf_laporan_ratarata_realisasi()
	{
		$mpdf = new \Mpdf\Mpdf([
		    'mode' => 'utf-8',
		    'format' => 'legal',
		    'orientation' => 'L',
		    'tempDir' => '/tmp'
		]);


		$bulan 				= $this->input->get('bulan');
		$filter 				= $this->input->get('asisten');
		$realisasi 				= $this->input->get('realisasi');
		$nomenklatur 				= $this->input->get('nomenklatur');
	
       $deskripsi_bulan = 'Per ' . jml_hari_dalam_bulan($bulan, tahun_anggaran()) . ' ' . bulan_global($bulan) . ' ' . tahun_anggaran();
	    

	    $asisten = [
	    	'semua'=>'Semua Data',
	    	'204'=>'Asisten Pemerintahan Dan Kesra',
	    	'205'=>'Asisten Perekonomian Dan Pembangunan',
	    	'206'=>'Asisten Administrasi Umum',
	    ];

	    $skpd = $this->ratarata_fisik_keuangan->skpd($filter, $bulan, $realisasi, $nomenklatur)->result();
	    $kelompok = $asisten[$filter];
	
	    $skpd_terurut = [];
	    foreach ($skpd as $k => $v) {
	    	$dev_fisik = $v->deviasi_fisik;
	    	$dev_keuangan = $v->deviasi_keuangan;

	    	if ($dev_fisik <-10) {
              $warna_peringatan_dev_fisik = 'background: #f8b2b2'; 
            }
            elseif ($dev_fisik <-5  && $dev_fisik >-10) {
              $warna_peringatan_dev_fisik = 'background: #fcf3cf';
            }else{
              $warna_peringatan_dev_fisik = 'background: #d5f5e3';
            }

            if ($dev_keuangan <-10) {
              $warna_peringatan_dev_keu = 'background: #f8b2b2'; 
            }
            elseif ($dev_keuangan <-5  && $dev_keuangan >-10) {
              $warna_peringatan_dev_keu = 'background: #fcf3cf';
            }else{
              $warna_peringatan_dev_keu = 'background: #d5f5e3';
            }
	    	$data = [
	    		'nama_instansi' => $v->nama_instansi,
	    		'tf' => $v->target_fisik == '' ? 0 : $v->target_fisik,
	    		'rf' => $v->realisasi_fisik == '' ? 0 : $v->realisasi_fisik,
	    		'df' => $dev_fisik == '' ? 0 : $dev_fisik,
	    		'wf' => $warna_peringatan_dev_fisik,
	    		'tk' => $v->target_keuangan == '' ? 0 : $v->target_keuangan,
	    		'rk' => $v->realisasi_keuangan == '' ? 0 : $v->realisasi_keuangan,
	    		'dk' => $dev_keuangan == '' ? 0 : $dev_keuangan,
	    		'wk' => $warna_peringatan_dev_keu,
	    	];
	    	array_push($skpd_terurut, $data);

	    	// echo $dev_fisik." - ".$warna_peringatan_dev_fisik.'<br>';
	    }



	    if ($realisasi=='fisik') {
	      $caption_realisasi = "Berdasarkan Realisasi Fisik Tertinggi";
	    }
	    elseif ($realisasi=='keu') {
	      $caption_realisasi = "Berdasarkan Realisasi Keuangan Tertinggi";
	    }else{
	      $caption_realisasi = "";

	    }
	    $judul_laporan="Rekapitulasi SIMBANGDA Based Evidence Per SKPD ". $deskripsi_bulan.' '.$kelompok.' '.$caption_realisasi ;
	    $data['skpd']=$skpd_terurut;
	    $data['kelompok']=$kelompok;
	    $data['caption_realisasi']=$caption_realisasi;
	    $data['realisasi']=$realisasi;
	  	$data['desc_bulan']= $deskripsi_bulan;
	  

	    $html =  $this->load->view('laporan/pdf/ratarata_fisik_keuangan/content', $data, true);
	    $header =  $this->load->view('laporan/pdf/ratarata_fisik_keuangan/header', $data, true);
	    $footer =  $this->load->view('laporan/pdf/ratarata_fisik_keuangan/footer', $data, true);

	    $mpdf->SetMargins(0, 0, 35);

		$mpdf->SetHTMLHeader($header);
		$mpdf->SetHTMLFooter($footer);
		$mpdf->WriteHTML($html);
		$mpdf->Output($judul_laporan.'.pdf', 'I');
	}




	public function pdf_laporan_kegiatan_kab_kota()
	{
		$mpdf = new \Mpdf\Mpdf([
		    'mode' => 'utf-8',
		    'format' => 'Legal',
		    'orientation' => 'L',
		]);

		$id_instansi 	= sbe_crypt($this->input->get('id_opd'), 'D');
		$id_kota 	= $this->input->get('id_kota');
    // $id_instansi = 12;
	

	  
	    
	    $data['judul_laporan']="Laporan pelaksanaan kegiatan di Kabupaten / Kota";
	    $domisili =$this->rekap_kegiatan_kab_kota->kab_kota($id_kota);

	    $data['provinsi']=$domisili->nama_provinsi;
	    $data['kab_kota']=$domisili->nama_kota;
	    $data['lokasi_per_skpd']=$this->rekap_kegiatan_kab_kota->lokasi_per_skpd($id_kota);
	    $data['title']=$data['judul_laporan'].' | '.$data['provinsi'].' '.$data['kab_kota'];
	    $html =  $this->load->view('laporan/pdf/rekap_kegiatan_kab_kota/content', $data, true);

	    $header =  $this->load->view('laporan/pdf/rekap_kegiatan_kab_kota/header', $data, true);
	    $footer =  $this->load->view('laporan/pdf/rekap_kegiatan_kab_kota/footer', $data, true);

	    $mpdf->SetMargins(0, 0, 30);
	    $mpdf->SetDisplayMode('fullpage');
		 $mpdf->SetHTMLHeader($header);
		// $mpdf->SetHTMLFooter($footer);
		$mpdf->WriteHTML($html);
		$mpdf->Output($data['title'].'.pdf', 'I');
	}



 	// Laporan Paket Pekerjaan SKPD
	public function data_jumlah_aktivitas_pdf()
	{
		
		global $id_instansi;
		global $kategori;
		global $bulan;

		$id_instansi 	= 43;
		$kategori 		= 'akumulasi';
		$bulan 				= 8;
		switch ($kategori) {
			case 'akumulasi':
				$ope = '<=';
				break;
			case 'per_bulan':
				$ope = '=';
				break;
		}
		$judul_file 	= "Laporan Aktivitas SKPD Tahun ". tahun_anggaran().".pdf";

		// New
		$this->load->library('pdf_jumlah_aktivitas');
		$pdf = new Pdf_jumlah_aktivitas('P', 'mm', 'a4');
		$pdf->SetTopMargin(4);
		$pdf->SetLeftMargin(4);
		$pdf->AddPage();
		$pdf->SetTitle($judul_file);
		// $pdf->SetAuthor("nama_user()");
		$pdf->SetCompression(true);
		$pdf->SetFont('Arial');
		 $pdf->SetFontSize(6);


			$opd 	= $this->db->query("SELECT id_instansi, kode_opd, nama_instansi FROM master_instansi WHERE kategori = 'OPD' AND id_instansi not in (203,164,165) ORDER BY nama_instansi ASC")->result();
			$total_anggaran = 0;
			$total_paket_rutin = 0;
			$total_paket_swakelola = 0;
			$total_paket_penyedia = 0;
			$jumlah_program = 0;
			$jumlah_kegiatan = 0;
			$jumlah_sub_kegiatan = 0;

			$no = 1;
			foreach ($opd as $key => $value) {
				$program = $this->jumlah_aktivitas_model->program($value->id_instansi);
				$kegiatan=$this->jumlah_aktivitas_model->kegiatan($value->id_instansi);
				$sub_kegiatan=$this->jumlah_aktivitas_model->sub_kegiatan($value->id_instansi);
				$pagu_anggaran = $this->jumlah_aktivitas_model->pagu_anggaran($value->id_instansi);
				$p_swakelola = $this->jumlah_aktivitas_model->paket($value->id_instansi, "SWAKELOLA");
				$p_penyedia = $this->jumlah_aktivitas_model->paket($value->id_instansi, "PENYEDIA");
				$p_rutin = $this->jumlah_aktivitas_model->paket($value->id_instansi, "RUTIN");

				





				$total_anggaran += $pagu_anggaran ;



				$total_paket_rutin += $p_rutin ; 
				$total_paket_penyedia += $p_penyedia ; 
				$total_paket_swakelola += $p_swakelola ; 


				$id_instansi	= $value->id_instansi;
	
				$nama_instansi	= $value->nama_instansi;
				$pagu_anggaran	= number_format($pagu_anggaran);
				$banyak_program	= number_format($program);
				$banyak_kegiatan	= number_format($kegiatan);
				$banyak_sub_kegiatan	= number_format($sub_kegiatan);
				$paket_rutin	= $p_rutin;
				$paket_swakelola	= $p_swakelola;
				$paket_penyedia	= $p_penyedia;

				$total_program =$jumlah_program += $program ;
				$total_kegiatan =$jumlah_kegiatan += $kegiatan ;
				$total_sub_kegiatan =$jumlah_sub_kegiatan += $sub_kegiatan ;


				$pdf->cell(10, 5, $no++, 1, 0,'C');
		$pdf->cell(88, 5, ucwords($nama_instansi), 1, 0 );
		$pdf->cell(20, 5, ($pagu_anggaran), 1, 0, 'R');
		$pdf->cell(15, 5, ($banyak_program), 1, 0, 'C');
		$pdf->cell(15, 5, ($banyak_kegiatan), 1, 0, 'C');
		$pdf->cell(15, 5, ($banyak_sub_kegiatan), 1, 0, 'C');
		$pdf->cell(13, 5, ($paket_rutin), 1, 0, 'C');
		$pdf->cell(13, 5, ($paket_swakelola), 1, 0, 'C');
		$pdf->cell(13, 5, ($paket_penyedia), 1, 0, 'C');
		$pdf->Ln(5);
			
			}
			
			$total_anggaran = number_format($total_anggaran);
			$total_paket_swakelola = number_format($total_paket_swakelola);
			$total_paket_penyedia = number_format($total_paket_penyedia);
			$total_paket_rutin = number_format($total_paket_rutin);
	

			$pdf->cell(98, 5, "Total ", 1, 0);
			$pdf->cell(20, 5, $total_anggaran, 1, 0, 'R');
			$pdf->cell(15, 5, ($total_program), 1, 0, 'C');
			$pdf->cell(15, 5, ($total_kegiatan), 1, 0, 'C');
			$pdf->cell(15, 5, ($total_sub_kegiatan), 1, 0, 'C');
			$pdf->cell(13, 5, ($total_paket_rutin), 1, 0, 'C');
			$pdf->cell(13, 5, ($total_paket_swakelola), 1, 0, 'C');
			$pdf->cell(13, 5, ($total_paket_penyedia), 1, 0, 'C');






	
		

		
		// last update 09102020

		$pdf->Output($judul_file, 'I');
		

	}



// ------------------------------------------------------------------------------------------------------------
	// Untuk uji coba

	public function testing()
	{
		$mpdf = new \Mpdf\Mpdf([
		    'mode' => 'utf-8',
		    'format' => 'Legal',
		    'orientation' => 'L',
		    'tempDir' => '/tmp'
		]);

		$data['test'] = "Test";
	    $html =  $this->load->view('android/tes', $data, true);

	    // $mpdf->SetMargins(0, 0, 30);
	    // $mpdf->SetDisplayMode('fullpage');
		 // $mpdf->SetHTMLHeader($header);
		// $mpdf->SetHTMLFooter($footer);
		$mpdf->WriteHTML($html);
		$mpdf->Output('Tes.pdf', 'I');
	}
}
