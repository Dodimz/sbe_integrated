<?php

/**
 * androidor     : Alfikri, M.Kom
 * Created By : Alfikri, M.Kom
 * E-Mail     : alfikri.name@gmail.com
 * No HP      : 081277337405
 * Class      : android.php
 */
defined('BASEPATH') or exit('No direct script access allowed');

class Android extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        if (identitas() != true) {
            redirect('setup', 'refresh');
        }
        $this->load->model('android/android_model', 'android_model');

        $this->load->model([
            'model_versi' => 'mversi',
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

    public function index()
    {
        if (empty($this->session->userdata('email'))) {
            $data['title']        = "Login";
            $page                 = 'android/android';
            $data['extra_css']    = $this->load->view('android/css', $data, true);
            $data['extra_js']    = $this->load->view('android/js', $data, true);
            $this->template->load('android_template', $page, $data);
        } else {
            redirect('dashboard');
        }
    }

    public function login()
    {
            $output     = ['status' => false, 'message' => ''];
            $android       = $this->android_model;
            $validation = $this->form_validation;
            $validation->set_rules($android->rules());

                $login = $android->login();
                if ($login['status']==true) {
                    $output['status'] = true;
                    $output['response'] = 200;
                    $output['data'] = $login['data'];
                    $output['message']  = $login['message'];
                }else{
                    $output['status'] = false;
                    $output['response'] = 404;
                    $output['message']  = $login['message'];
                    $output['cek']  = $login['cek'];

                }
                

            header('Content-Type: application/json');
            echo json_encode($output);
        // }
    }
    public function edit_password()
    {
            $output     = ['status' => false, 'message' => ''];
            $android       = $this->android_model;
            $validation = $this->form_validation;
            $validation->set_rules($android->rules());

                $login = $android->cek_password();
                if ($login['status']==true) {
                    $output['status'] = true;
                    $output['response'] = 200;
                    $output['message']  = $login['message'];
                }else{
                    $output['status'] = false;
                    $output['response'] = 404;
                    $output['message']  = $login['message'];

                }
                
                // var_dump($login);
            header('Content-Type: application/json');
            echo json_encode($output);
        // }
    }
    public function identitas_user()
    {
       
            $output     = ['status' => false, 'response'=>'', 'message' => '', 'data'=>[]];
            $android       = $this->android_model;
           
            $post           = $this->input->post();
            $id_user =  $post['id_user'];
            $login = $android->identitas_user($id_user);
            $user = $login->row();
            if ($login->num_rows()>0) {
               $output['response'] = 200;
               $output['status'] = true;
               $output['message'] = 'Data ditemukan';
               $output['data'] = [
                'id_user' => $user->id_user,
                'full_name' => $user->full_name,
                'nohp' => $user->nohp,
                'pekerjaan' => $user->pekerjaan,
                'alasan_register' => $user->alasan_register,
             
                
                'is_active' => $user->is_active,
               ];

            }else{
               $output['message'] = 'Data tidak ditemukan';
               $output['response'] = 404;
               $output['status'] = false;
            }

          
            header('Content-Type: application/json');
            echo json_encode($output);
    }
    public function register_user()
    {
       
            $output     = ['status' => false, 'response'=>'', 'message' => ''];
            $android       = $this->android_model;
           
            $post           = $this->input->post();
            $nama =  $post['nama'];
            $pekerjaan =  $post['pekerjaan'];
            $nohp =  $post['nohp'];
            $email =  $post['email'];
            $password =  $post['password'];
            $alasan =  $post['alasan'];
            $cek = $android->cek_register_user($email);
           
            if ($cek->num_rows()>0) {
               $output['response'] = 404;
               $output['status'] = false;
               $output['message'] = "Email Sudah digunakan\nSilahkan gunakan email lain";
               

            }else{
                $jams = date('H:i');
                $tgls = date('Y-m-d');
                $expired = date('Y-m-d',strtotime("+7 days", strtotime($tgls)) );

            	$data = [
            		'full_name' => $nama,
            		'pekerjaan' => $pekerjaan,
            		'email' => $email,
                    'nohp' => $nohp,
            		'password' =>password_hash( $password, PASSWORD_DEFAULT),
            		'alasan_register' => $alasan,
                    'is_active' => 0,
                    'created_on' => $tgls.' '.$jams,
                    'expired_confirmation' => $expired.' '.$jams,
            	];
            	$this->db->insert('register_user', $data);
               $output['message'] = 'Register Berhasil.!';
               $output['response'] = 200;
               $output['status'] = true;
            }

          
            header('Content-Type: application/json');
            echo json_encode($output);
    }
    public function edit_user()
    {
       
            $output     = ['status' => false, 'response'=>'', 'message' => ''];
            $android       = $this->android_model;
           
            $post           = $this->input->post();
            $nama =  $post['nama'];
            $pekerjaan =  $post['pekerjaan'];
            $nohp =  $post['nohp'];
            // $email =  $post['email'];
            $id_user =  $post['id_user'];
            $alasan =  $post['alasan'];

            $pass_lama =  $post['pass_lama'];
            $pass_baru =  $post['pass_baru'];

            if ($pass_lama!='' || $pass_baru !='') {
                if ($pass_lama=='' && $pass_baru !='') {
                     $output['message'] = 'Harap input pasword lama jika ingin mengubah password';
                        $output['response'] = 200;
                        $output['status'] = false;
                }else{

                    $cek_password = $this->db->query("SELECT password from register_user where id_user='$id_user'")->row_array();
                    if (password_verify($pass_lama, $cek_password['password'])) {
                        $data = [
                            'full_name' => $nama,
                            'pekerjaan' => $pekerjaan,
                            'nohp' => $nohp,
                            'alasan_register' => $alasan,
                            'password'=>password_hash($pass_baru, PASSWORD_DEFAULT),
                            'updated_on' => date('Y-m-d H:i:s')
                        ];
                        $where = ['id_user'=>$id_user];
                        $this->db->update('register_user', $data, $where);
                        $output['status'] = true;
                        $output['response'] = 200;
                        $output['message'] = 'Update data user berhasil.!';
                    }else{
                        $output['message'] = 'Passwod lama salah';
                        $output['response'] = 200;
                        $output['status'] = false;
                    }

                }
            }else{
                $data = [
                    'full_name' => $nama,
                    'pekerjaan' => $pekerjaan,
                    'nohp' => $nohp,
                    'alasan_register' => $alasan,
                    'updated_on' => date('Y-m-d H:i:s')
                ];
            	$where = ['id_user'=>$id_user];
            	$this->db->update('register_user', $data, $where);
               $output['message'] = 'Update data user berhasil.!';
               $output['response'] = 200;
               $output['status'] = true;
            }

           

            
          
          
            header('Content-Type: application/json');
            echo json_encode($output);
    }
    public function edit_login_user()
    {
       
            $output     = ['status' => false, 'response'=>'', 'message' => ''];
            $android       = $this->android_model;
           
            $post           = $this->input->post();
            $nama =  $post['nama'];
            $pekerjaan =  $post['pekerjaan'];
            $nohp =  $post['nohp'];
            $email =  $post['email'];
            $id_user =  $post['id_user'];
            $alasan =  $post['alasan'];
            $cek = $android->cek_register_user($email, $id_user);
           
            if ($cek->num_rows()>0) {
               $output['response'] = 404;
               $output['status'] = false;
               $output['message'] = "No HP Sudah digunakan\nSilahkan gunakan no HP lain";
               

            }else{
                $data = [
                    'full_name' => $nama,
                    'pekerjaan' => $pekerjaan,
                    'nohp' => $nohp,
                    'alasan_register' => $alasan,
                    'updated_on' => date('Y-m-d H:i:s')
                ];
                $where = ['id_user'=>$id_user];
                $this->db->update('register_user', $data, $where);
               $output['message'] = 'Register Berhasil.!';
               $output['response'] = 200;
               $output['status'] = true;
            }

          
            header('Content-Type: application/json');
            echo json_encode($output);
    }
    public function daftar_skpd()
    {
            $output     = [
                'status' => false, 
                'message' => '', 
                'data'=>[]
            ];
            $android       = $this->android_model;
           
            $skpd = $android->daftar_skpd();
            $daftar_skpd = $skpd->result();

            $found =  count($daftar_skpd);
            if ($found > 0 ) {
                # code...
                foreach ($daftar_skpd as $key => $value) {
                    $output['data'][$key]['id_instansi']      = $value->id_instansi;
                    $output['data'][$key]['nama_instansi']      = $value->nama_instansi;
                }
                $output['status']   = true;
                $output['message']  = 'Data ditemukan';
            }else{
                $output['status']   = false;
                $output['message']  = 'Data tidak ditemukan';

            }
            header('Content-Type: application/json');
            echo json_encode($output);
        
    }
    public function pagu_total()
    {
            $output     = [
                'status' => false, 
                'message' => '', 
                'data'=>[]
            ];
            $android       = $this->android_model;
           
            $tahap = tahapan_apbd();
        
	            $pagu = $android->pagu_total($tahap)->row();

            $bo = $pagu->pagu_bo;
            $bm = $pagu->pagu_bm;
            $btt = $pagu->pagu_btt;
            $bt = $pagu->pagu_bt;
            $pagu_total = $pagu->total == '' ? 0 : $pagu->total;
            
           

            // $found =  count($daftar_skpd);
            if ($pagu_total > 0 ) {
            



	             $output['data']['bo']      = $bo;
	            $output['data']['bm']      = $bm;
	            $output['data']['btt']      = $btt;
	            $output['data']['bt']      = $bt;
	            $output['data']['total']      = $pagu_total;

				@$output['data']['persen_bo']       = round(($bo / $pagu_total) * 100, 2);
				@$output['data']['persen_bm']       = round(($bm / $pagu_total) * 100, 2);
				@$output['data']['persen_btt']       = round(($btt / $pagu_total) * 100, 2);
				@$output['data']['persen_bt']       = round(($bt / $pagu_total) * 100, 2);
	            $output['data']['tahap']      = nama_tahapan();


                $output['status']   = true;
                $output['message']  = 'Data ditemukan';
            }else{

				$output['data']['bo']      = 0;
				$output['data']['bm']      = 0;
				$output['data']['btt']      = 0;
				$output['data']['bt']      = 0;
				$output['data']['total']      = 0;

				@$output['data']['persen_bo']       = 0;
				@$output['data']['persen_bm']       = 0;
				@$output['data']['persen_btt']       = 0;
				@$output['data']['persen_bt']       = 0;
				$output['data']['tahap']      = nama_tahapan();
                $output['status']   = false;
                $output['message']  = 'Pagu tidak ada';
            }
            header('Content-Type: application/json');
            echo json_encode($output);
        
    }
    public function pagu_skpd()
    {
            $id_instansi = $this->input->post('id_instansi');
            $nama_instansi = $this->db->query("SELECT nama_instansi from master_instansi where id_instansi='$id_instansi'")->row()->nama_instansi;
            $output     = [
                'status' => false, 
                'nama_instansi' =>  $nama_instansi, 
                'message' => '', 
                'data'=>[]
            ];
            $android       = $this->android_model;
           
            $tahap = tahapan_apbd();
        
                $pagu = $android->pagu($id_instansi, $tahap)->row();

            $bo = $pagu->pagu_bo;
            $bm = $pagu->pagu_bm;
            $btt = $pagu->pagu_btt;
            $bt = $pagu->pagu_bt;
            $pagu_total = $pagu->total == '' ? 0 : $pagu->total;
            
           

            if ($pagu_total > 0 ) {
            



                 $output['data']['bo']      = $bo;
                $output['data']['bm']      = $bm;
                $output['data']['btt']      = $btt;
                $output['data']['bt']      = $bt;
                $output['data']['total']      = $pagu_total;

                @$output['data']['persen_bo']       = round(($bo / $pagu_total) * 100, 2);
                @$output['data']['persen_bm']       = round(($bm / $pagu_total) * 100, 2);
                @$output['data']['persen_btt']       = round(($btt / $pagu_total) * 100, 2);
                @$output['data']['persen_bt']       = round(($bt / $pagu_total) * 100, 2);
                $output['data']['tahap']      = nama_tahapan();


                $output['status']   = true;
                $output['message']  = 'Data ditemukan';
            }else{

                $output['data']['bo']      = 0;
                $output['data']['bm']      = 0;
                $output['data']['btt']      = 0;
                $output['data']['bt']      = 0;
                $output['data']['total']      = 0;

                @$output['data']['persen_bo']       = 0;
                @$output['data']['persen_bm']       = 0;
                @$output['data']['persen_btt']       = 0;
                @$output['data']['persen_bt']       = 0;
                $output['data']['tahap']      = nama_tahapan();
                $output['status']   = false;
                $output['message']  = 'Pagu tidak ada';
            }
            header('Content-Type: application/json');
            echo json_encode($output);
        
    }
    public function data_kontrak_pekerjaan()
    {

            $output     = [
                'status' => false, 
                'message' => '', 
                'data'=>[]
            ];

           // $output['data'] = array();
            $android       = $this->android_model;
            $id_instansi = $this->input->post('id_instansi');
            $id_group = $this->input->post('id_group');
            $tahap = tahapan_apbd();

            if ($id_group ==5) {
                $instansi = $android->instansi($id_instansi, $id_group)->row();

                 $kontrak = $android->data_kontrak_pekerjaan($id_instansi);
                $output['data'][0]['id_instansi'] = $instansi->id_instansi;
                $output['data'][0]['nama_instansi'] = $instansi->nama_instansi;
                    $found =  count($kontrak->result());
                    if ($found > 0 ) {
                        foreach ($kontrak->result() as $key => $value) {
                            $output['data'][0]['kontrak'][$key]['id_paket_pekerjaan']      = $value->id_paket_pekerjaan;
                            $output['data'][0]['kontrak'][$key]['latitude']      = $value->latitude;
                            $output['data'][0]['kontrak'][$key]['longitude']      = $value->longitude;
                            $output['data'][0]['kontrak'][$key]['nama_sub_kegiatan']      = $value->nama_sub_kegiatan;
                            $output['data'][0]['kontrak'][$key]['nama_paket']      = $value->nama_paket;
                            $output['data'][0]['kontrak'][$key]['pptk']      = $value->pptk;
                            $output['data'][0]['kontrak'][$key]['nilai_kontrak']      = $value->nilai_kontrak;
                            $output['data'][0]['kontrak'][$key]['pagu_paket']      = $value->pagu;
                            $output['data'][0]['kontrak'][$key]['pelaksana']      = $value->pelaksana;
                        }
                    }else{
                        $output['data'][0]['kontrak']=[];
                    }

                $output['status'] = true;
            }else{
                $instansi = $android->instansi($id_instansi, $id_group)->result();
                foreach ($instansi as $k => $v_i) {
                    $output['data'][$k]['id_instansi'] = $v_i->id_instansi;
                    $output['data'][$k]['nama_instansi'] = $v_i->nama_instansi;
                    $data_id_instansi =  $v_i->id_instansi;

                    $kontrak = $android->data_kontrak_pekerjaan($data_id_instansi);
                    $found =  count($kontrak->result());
                    if ($found > 0 ) {
                        foreach ($kontrak->result() as $key => $value) {
                            $output['data'][$k]['kontrak'][$key]['id_paket_pekerjaan']      = $value->id_paket_pekerjaan;
                            $output['data'][$k]['kontrak'][$key]['latitude']      = $value->latitude;
                            $output['data'][$k]['kontrak'][$key]['longitude']      = $value->longitude;
                            $output['data'][$k]['kontrak'][$key]['nama_sub_kegiatan']      = $value->nama_sub_kegiatan;
                            $output['data'][$k]['kontrak'][$key]['nama_paket']      = $value->nama_paket;
                            $output['data'][$k]['kontrak'][$key]['pptk']      = $value->pptk;
                            $output['data'][$k]['kontrak'][$key]['nilai_kontrak']      = $value->nilai_kontrak;
                            $output['data'][$k]['kontrak'][$key]['pagu_paket']      = $value->pagu;
                            $output['data'][$k]['kontrak'][$key]['pelaksana']      = $value->pelaksana;
                        }
                    }else{
                        $output['data'][$k]['kontrak'] = [];
                    }




                }
                $output['status'] = true;
            }
           
            header('Content-Type: application/json');
            echo json_encode($output);
        
    }
    public function gis_all()
    {

            $output     = [
                'status' => false, 
                'message' => '', 
                'filter' => '', 
                'keterangan' => '', 
                'legend' => [],
                'data'=>[],
            ];

           // $output['data'] = array();
            $android       = $this->android_model;
            $id_instansi = $this->input->post('id_instansi', true);
            $id_kab_kota = $this->input->post('id_kab_kota', true);
            $keyword = $this->input->post('keyword', true);
            $tahap = tahapan_apbd();


            if ($id_instansi) {
                $filter = 'skpd';
                $params = $id_instansi;
                $message = "Filter berdasarkan SKPD";
                $keterangan = $this->db->query("SELECT nama_instansi from master_instansi where id_instansi='$id_instansi'")->row()->nama_instansi;
                
            }
            elseif ($id_kab_kota) {
                $filter = 'kab_kota';
                $params = $id_kab_kota;
                $message = "Filter berdasarkan Kabupaten / Kota";
                $q = $this->db->query("SELECT k.nama_kota, p.nama_provinsi from kota k left join provinsi p on k.id_provinsi = p.id_provinsi where k.id_kota='$id_kab_kota'")->row();
                $keterangan = $q->nama_kota;
                
            }
            elseif ($keyword) {
                $filter = 'keyword';
                $params = $keyword;
                $message = "Filter berdasarkan Keyword";
                
                $keterangan = $keyword;
                
            }else{
                $filter = '';
                $params = "";
                $keterangan = "";
                $message = "Semua data titik lokasi";

            }

            $legend = [
                ['key'=>"Deviasi diatas 10 %", 'warna' => "red"],
                ['key'=>"Deviasi antara 5% sampai 10 %", 'warna' => "yellow"],
                ['key'=>"Deviasi dibawah 5%", 'warna' => "green"],
            ];
            $output['legend'] = $legend;
            $output['filter'] = $filter;
            $output['message'] = $message;
            $output['keterangan'] = $keterangan;

                $gis_all = $android->gis_all($filter, $params)->result();
                foreach ($gis_all as $key => $value) {
                	$keterangan = $value->kategori == "Unit Pelaksana" ? "\n".$value->jenis_sub_kegiatan." - ".$value->keterangan : "";
                    $output['data'][$key]['lat'] = $value->latitude;
                    $output['data'][$key]['long'] = $value->longitude;
                    $output['data'][$key]['nama_instansi'] = $value->nama_instansi;
                    $output['data'][$key]['id_instansi'] = $value->id_instansi;
                    $output['data'][$key]['nama_paket'] = $value->nama_paket;
                    $output['data'][$key]['id_paket_pekerjaan'] = $value->id_paket_pekerjaan;
                    $output['data'][$key]['kategori'] = $value->kategori;
                    $output['data'][$key]['pptk'] = $value->pptk;
                    $output['data'][$key]['nama_sub_kegiatan'] = $value->nama_sub_kegiatan.$keterangan;
                    $output['data'][$key]['nilai_kontrak'] = $value->nilai_kontrak;
                    $output['data'][$key]['pelaksana'] = $value->pelaksana;

                    $output['data'][$key]['kode'] = $value->kode_sub_kegiatan;
                    $output['data'][$key]['pagu'] = $value->pagu;

















                    $ope = '<=';
                    $bulan = date('n');

                    $target = $this->realisasi_akumulasi_model->get_target($value->id_instansi, $value->kode_sub_kegiatan, $bulan)->row_array();
                    $realisasi_keuangan = $this->realisasi_akumulasi_model->get_realisasi_keuangan($value->id_instansi, $value->kode_sub_kegiatan, $bulan, $ope)->row_array();


                    $total_paket = $this->realisasi_akumulasi_model->get_total_paket($value->id_instansi, $value->kode_sub_kegiatan)->num_rows();
					$jenis_rutin = $this->realisasi_akumulasi_model->get_total_paket_perjenis($value->id_instansi, $value->kode_sub_kegiatan, "RUTIN")->num_rows();
					$swa = $this->realisasi_akumulasi_model->get_realisasi_fisik($value->id_instansi, $value->kode_sub_kegiatan, $bulan, 'SWAKELOLA', $ope)->row_array();
					$pen = $this->realisasi_akumulasi_model->get_realisasi_fisik($value->id_instansi, $value->kode_sub_kegiatan, $bulan, 'PENYEDIA', $ope)->row_array();
					$rut = $jenis_rutin > 0 ? ($jenis_rutin * round($bulan / 12 * 100, 2)) : 0;
					

					$swa_tot	= !empty($swa['total']) ? $swa['total'] : 0;
					$pen_tot  = !empty($pen['total']) ? $pen['total'] : 0;
					$rut_tot  = !empty($rut) ? $rut : 0;
					$pagu_opd = $this->realisasi_akumulasi_model->get_pagu_opd($value->id_instansi)->row_array();
					$tot_pagu = !empty($pagu_opd['pagu']) ? $pagu_opd['pagu'] : 0;

					if ($total_paket != 0) {
						$total_fisik = ROUND(($swa_tot + $pen_tot + $rut_tot) / $total_paket,2);
					} else {
						$total_fisik = 0;
					}

					$total_fisik  	= ROUND($total_fisik, 2) > 100 ? 100 : ROUND($total_fisik, 2);
					$uang_fisik   	= ($total_fisik / 100) * $value->pagu;
					@$persen_fisik 	= ($uang_fisik / $tot_pagu) * 100;

					$persen_target_keuangan     = round(($target['target_keuangan'] / $value->pagu) * 100, 2);
						$persen_realisasi_keuangan 	= round(($realisasi_keuangan['total_realisasi'] / $value->pagu) * 100, 2);
					
					$dev_fisik = $total_fisik - $target['target_fisik'];
					$dev_keu = $persen_realisasi_keuangan - $persen_target_keuangan;


		            if ($dev_fisik < -10) {
		              $warna_peringatan_dev_fisik = 'red'; 
		            }
		            elseif ($dev_fisik <-5  && $dev_fisik >-10) {
		              $warna_peringatan_dev_fisik = 'yellow';
		            }else{
		              $warna_peringatan_dev_fisik = 'green';
		            }






                    // jika deviasi <5%  warna hijau
                    // jika deviasi >5% dan <10%  warna kuning
                    // jika deviasi >10%  warna merah







                    $output['data'][$key]['warna'] = $warna_peringatan_dev_fisik	;
                    
                }
                
                $output['status'] = true;
            
           
            header('Content-Type: application/json');
            echo json_encode($output);
        
    }
    public function gis_skpd()
    {

            $output     = [
                'status' => false, 
                'message' => '', 
                'skpd' => '', 
                'data'=>[]
            ];

           // $output['data'] = array();
            $android       = $this->android_model;
            $id_instansi = $this->input->post('id_instansi');
            $tahap = tahapan_apbd();

            $instansi = $this->db->query("SELECT nama_instansi from master_instansi where id_instansi='$id_instansi'")->row()->nama_instansi;
            $output['skpd']= $instansi;
                $gis_all = $android->gis_skpd($id_instansi)->result();
                foreach ($gis_all as $key => $value) {
                	$keterangan = $value->kategori == "Unit Pelaksana" ? "\n".$value->jenis_sub_kegiatan." - ".$value->keterangan : "";
                    $output['data'][$key]['lat'] = $value->latitude;
                    $output['data'][$key]['long'] = $value->longitude;
                    $output['data'][$key]['nama_paket'] = $value->nama_paket;
                    $output['data'][$key]['id_paket_pekerjaan'] = $value->id_paket_pekerjaan;
                    $output['data'][$key]['kategori'] = $value->kategori;
                    $output['data'][$key]['pptk'] = $value->pptk;
                    $output['data'][$key]['nama_sub_kegiatan'] = $value->nama_sub_kegiatan.$keterangan;

                    // jika deviasi <5%  warna hijau
                    // jika deviasi >5% dan <10%  warna kuning
                    // jika deviasi >10%  warna merah
                    $output['data'][$key]['warna'] = "#f500ed";
                    
                }
                
                $output['status'] = true;
            
           
            header('Content-Type: application/json');
            echo json_encode($output);
        
    }
    public function gis_domisili()
    {

            $output     = [
                'status' => false, 
                'message' => '', 
                'kab_kota' => '', 
                'data'=>[]
            ];

           // $output['data'] = array();
            $android       = $this->android_model;

            $id_kab_kota = $this->input->post('id_kab_kota');
            $id_provinsi = 13;
           
            $tahap = tahapan_apbd();

            $kab_kota = $this->db->query("SELECT nama_kota from kota where id_kota='$id_kab_kota'")->row()->nama_kota;
            $output['kab_kota']= $kab_kota;
                $gis = $android->gis_domisili($id_kab_kota)->result();
                foreach ($gis as $key => $value) {
                	$keterangan = $value->kategori == "Unit Pelaksana" ? "\n".$value->jenis_sub_kegiatan." - ".$value->keterangan : "";
                    $output['data'][$key]['lat'] = $value->latitude;
                    $output['data'][$key]['long'] = $value->longitude;
                    $output['data'][$key]['nama_paket'] = $value->nama_paket;
                    $output['data'][$key]['id_paket_pekerjaan'] = $value->id_paket_pekerjaan;
                    $output['data'][$key]['kategori'] = $value->kategori;
                    $output['data'][$key]['pptk'] = $value->pptk;
                    $output['data'][$key]['nama_sub_kegiatan'] = $value->nama_sub_kegiatan.$keterangan;

                    // jika deviasi <5%  warna hijau
                    // jika deviasi >5% dan <10%  warna kuning
                    // jika deviasi >10%  warna merah
                    $output['data'][$key]['warna'] = "#f500ed";
                    
                }
                
                $output['status'] = true;
            
           
            header('Content-Type: application/json');
            echo json_encode($output);
        
    }
    public function gis_filter_kab_kota()
    {

            $output     = [
                'status' => false, 
                'message' => '', 
                'kab_kota' => '', 
                'data'=>[]
            ];

           // $output['data'] = array();
            $android       = $this->android_model;

            $id_kab_kota = $this->input->post('id_kab_kota');
            $id_provinsi = 13;
           
            $tahap = tahapan_apbd();

            $kab_kota = $this->db->query("SELECT nama_kota from kota where id_kota='$id_kab_kota'")->row()->nama_kota;
            $output['kab_kota']= $kab_kota;
                $gis = $android->gis_domisili($id_kab_kota)->result();
                foreach ($gis as $key => $value) {
                    $keterangan = $value->kategori == "Unit Pelaksana" ? "\n".$value->jenis_sub_kegiatan." - ".$value->keterangan : "";
                    $output['data'][$key]['lat'] = $value->latitude;
                    $output['data'][$key]['long'] = $value->longitude;
                    $output['data'][$key]['nama_paket'] = $value->nama_paket;
                    $output['data'][$key]['id_paket_pekerjaan'] = $value->id_paket_pekerjaan;
                    $output['data'][$key]['kategori'] = $value->kategori;
                    $output['data'][$key]['pptk'] = $value->pptk;
                    $output['data'][$key]['nama_sub_kegiatan'] = $value->nama_sub_kegiatan.$keterangan;

                    // jika deviasi <5%  warna hijau
                    // jika deviasi >5% dan <10%  warna kuning
                    // jika deviasi >10%  warna merah
                    $output['data'][$key]['warna'] = "#f500ed";
                    
                }
                
                $output['status'] = true;
            
           
            header('Content-Type: application/json');
            echo json_encode($output);
        
    }
    public function gis_filter_keyword()
    {

            $output     = [
                'status' => false, 
                'message' => '', 
                'keyword' => '', 
                'data'=>[]
            ];

           // $output['data'] = array();
            $android       = $this->android_model;

            $keyword = $this->input->post('keyword');
            $id_provinsi = 13;
           
            $tahap = tahapan_apbd();

            $output['keyword']= $keyword;

                $gis = $android->gis_keyword($keyword)->result();
                foreach ($gis as $key => $value) {
                    $keterangan = $value->kategori == "Unit Pelaksana" ? "\n".$value->jenis_sub_kegiatan." - ".$value->keterangan : "";
                    $output['data'][$key]['lat'] = $value->latitude;
                    $output['data'][$key]['long'] = $value->longitude;
                    $output['data'][$key]['nama_paket'] = $value->nama_paket;
                    $output['data'][$key]['id_paket_pekerjaan'] = $value->id_paket_pekerjaan;
                    $output['data'][$key]['kategori'] = $value->kategori;
                    $output['data'][$key]['pptk'] = $value->pptk;
                    $output['data'][$key]['nama_sub_kegiatan'] = $value->nama_sub_kegiatan.$keterangan;
                    $output['data'][$key]['nama_instansi'] = $value->nama_instansi;

                    // jika deviasi <5%  warna hijau
                    // jika deviasi >5% dan <10%  warna kuning
                    // jika deviasi >10%  warna merah
                    $output['data'][$key]['warna'] = "#f500ed";
                    
                }
                
                $output['status'] = true;
            
           
            header('Content-Type: application/json');
            echo json_encode($output);
        
    }
    public function gis_filter_skpd()
    {

            $output     = [
                'status' => false, 
                'message' => '', 
                'skpd' => '', 
                'data'=>[]
            ];

           // $output['data'] = array();
            $android       = $this->android_model;

            $id_instansi = $this->input->post('id_instansi');
            $id_provinsi = 13;
           
            $tahap = tahapan_apbd();
            $nama_instansi = $this->db->query("SELECT nama_instansi from master_instansi where id_instansi='$id_instansi'")->row()->nama_instansi;
            $output['skpd']= $nama_instansi;

                $gis = $android->gis_skpd($id_instansi)->result();
                foreach ($gis as $key => $value) {
                    $keterangan = $value->kategori == "Unit Pelaksana" ? "\n".$value->jenis_sub_kegiatan." - ".$value->keterangan : "";
                    $output['data'][$key]['lat'] = $value->latitude;
                    $output['data'][$key]['long'] = $value->longitude;
                    $output['data'][$key]['nama_paket'] = $value->nama_paket;
                    $output['data'][$key]['id_paket_pekerjaan'] = $value->id_paket_pekerjaan;
                    $output['data'][$key]['kategori'] = $value->kategori;
                    $output['data'][$key]['pptk'] = $value->pptk;
                    $output['data'][$key]['nama_sub_kegiatan'] = $value->nama_sub_kegiatan.$keterangan;
                    $output['data'][$key]['nama_instansi'] = $value->nama_instansi;

                    // jika deviasi <5%  warna hijau
                    // jika deviasi >5% dan <10%  warna kuning
                    // jika deviasi >10%  warna merah
                    $output['data'][$key]['warna'] = "#f500ed";
                    
                }
                
                $output['status'] = true;
            
           
            header('Content-Type: application/json');
            echo json_encode($output);
        
    }
    public function gis_filter_skpd_keyword()
    {

            $output     = [
                'status' => false, 
                'message' => '', 
                'skpd' => '', 
                'keyword' => '', 
                'data'=>[]
            ];

           // $output['data'] = array();
            $android       = $this->android_model;

            $id_instansi = $this->input->post('id_instansi');
            $keyword = $this->input->post('keyword');
            $id_provinsi = 13;
           
            $tahap = tahapan_apbd();
            $nama_instansi = $this->db->query("SELECT nama_instansi from master_instansi where id_instansi='$id_instansi'")->row()->nama_instansi;
            $output['skpd']= $nama_instansi;
            $output['keyword']= $keyword;

                $gis = $android->gis_skpd_keyword($id_instansi, $keyword)->result();
                foreach ($gis as $key => $value) {
                    $keterangan = $value->kategori == "Unit Pelaksana" ? "\n".$value->jenis_sub_kegiatan." - ".$value->keterangan : "";
                    $output['data'][$key]['lat'] = $value->latitude;
                    $output['data'][$key]['long'] = $value->longitude;
                    $output['data'][$key]['nama_paket'] = $value->nama_paket;
                    $output['data'][$key]['id_paket_pekerjaan'] = $value->id_paket_pekerjaan;
                    $output['data'][$key]['kategori'] = $value->kategori;
                    $output['data'][$key]['pptk'] = $value->pptk;
                    $output['data'][$key]['nama_sub_kegiatan'] = $value->nama_sub_kegiatan.$keterangan;
                    $output['data'][$key]['nama_instansi'] = $value->nama_instansi;

                    // jika deviasi <5%  warna hijau
                    // jika deviasi >5% dan <10%  warna kuning
                    // jika deviasi >10%  warna merah
                    $output['data'][$key]['warna'] = "#f500ed";
                    
                }
                
                $output['status'] = true;
            
           
            header('Content-Type: application/json');
            echo json_encode($output);
        
    }
    public function gis_filter_skpd_kab_kota()
    {

            $output     = [
                'status' => false, 
                'message' => '', 
                'skpd' => '', 
                'kab_kota' => '', 
                'data'=>[]
            ];

           // $output['data'] = array();
            $android       = $this->android_model;

            $id_instansi = $this->input->post('id_instansi');
            $id_kab_kota = $this->input->post('id_kab_kota');
            $id_provinsi = 13;
           
            $tahap = tahapan_apbd();
            $nama_instansi = $this->db->query("SELECT nama_instansi from master_instansi where id_instansi='$id_instansi'")->row()->nama_instansi;
            $output['skpd']= $nama_instansi;
            $nama_kab_kota = $this->db->query("SELECT nama_kota from kota where id_kota='$id_kab_kota'")->row()->nama_kota;
            $output['kab_kota']= $nama_kab_kota;

                $gis = $android->gis_skpd_kab_kota($id_instansi, $id_kab_kota)->result();
                foreach ($gis as $key => $value) {
                    $keterangan = $value->kategori == "Unit Pelaksana" ? "\n".$value->jenis_sub_kegiatan." - ".$value->keterangan : "";
                    $output['data'][$key]['lat'] = $value->latitude;
                    $output['data'][$key]['long'] = $value->longitude;
                    $output['data'][$key]['nama_paket'] = $value->nama_paket;
                    $output['data'][$key]['id_paket_pekerjaan'] = $value->id_paket_pekerjaan;
                    $output['data'][$key]['kategori'] = $value->kategori;
                    $output['data'][$key]['pptk'] = $value->pptk;
                    $output['data'][$key]['nama_sub_kegiatan'] = $value->nama_sub_kegiatan.$keterangan;
                    $output['data'][$key]['nama_instansi'] = $value->nama_instansi;

                    // jika deviasi <5%  warna hijau
                    // jika deviasi >5% dan <10%  warna kuning
                    // jika deviasi >10%  warna merah
                    $output['data'][$key]['warna'] = "#f500ed";
                    
                }
                
                $output['status'] = true;
            
           
            header('Content-Type: application/json');
            echo json_encode($output);
        
    }
    public function kab_kota()
    {

            $output     = [
                'status' => false, 
                'message' => '', 
                'provinsi' => '', 
                'data'=>[]
            ];

           // $output['data'] = array();
            $android       = $this->android_model;
            $id_provinsi = 13; //$this->input->post('id_provinsi');
            $tahap = tahapan_apbd();

            $instansi = $this->db->query("SELECT nama_provinsi from provinsi where id_provinsi='$id_provinsi'")->row()->nama_provinsi;
            $output['provinsi']= $instansi;
                $kab_kota = $android->kab_kota($id_provinsi)->result();
                foreach ($kab_kota as $key => $value) {
                
                    $output['data'][$key]['id_kab_kota'] = $value->id_kota;
                    $output['data'][$key]['nama_kab_kota'] = $value->nama_kota;
                    
                }
                
                $output['status'] = true;
            
           
            header('Content-Type: application/json');
            echo json_encode($output);
        
    }
    public function detail_gis()
    {
            $output     = [
                'status' => false, 
                'message' => '', 
                'data'=>[]
            ];
            $android       = $this->android_model;
            $id_paket_pekerjaan = $this->input->post('id_paket_pekerjaan');
            $tahap = tahapan_apbd();

               
 $kontrak = $android->detail_kontrak_pekerjaan($id_paket_pekerjaan);
 $progress = $android->progress_pekerjaan($id_paket_pekerjaan);
                    $found =  $kontrak->num_rows();
                    $data_kontrak = $kontrak->row();
                    if ($found > 0 ) {
                            $output['data']['kontrak']['skpd']      = $data_kontrak->nama_instansi;
                            $output['data']['kontrak']['provinsi']      = $data_kontrak->nama_provinsi;
                            $output['data']['kontrak']['kota']      = $data_kontrak->nama_kota;
                            $output['data']['kontrak']['id_paket_pekerjaan']      = $data_kontrak->id_paket_pekerjaan;
                            $output['data']['kontrak']['latitude']      = $data_kontrak->latitude;
                            $output['data']['kontrak']['longitude']      = $data_kontrak->longitude;
                            $output['data']['kontrak']['nama_sub_kegiatan']      = $data_kontrak->nama_sub_kegiatan;
                            $output['data']['kontrak']['nama_paket']      = $data_kontrak->nama_paket;
                            $output['data']['kontrak']['pptk']      = $data_kontrak->pptk;
                            $output['data']['kontrak']['nilai_kontrak']      = $data_kontrak->nilai_kontrak;
                            $output['data']['kontrak']['pagu_paket']      = $data_kontrak->pagu; 
                            $output['data']['kontrak']['pelaksana']      = $data_kontrak->pelaksana;

                            $id_instansi = $data_kontrak->id_instansi;
                            if ($progress->num_rows()==0) {
                                $output['data']['progress'] = [];
                            }else{
                                foreach ($progress->result() as $key => $v_progress) {


                                    $primary_folder     = 'sbe_files_data/';
                                    $directory          = [
                                        $this->sbe_tahun_anggaran(),
                                        $id_instansi,
                                        'PROGRESS-PEKERJAAN',
                                        $id_paket_pekerjaan,
                                    ];
                                    $list_directory     = $this->sbe_directory($primary_folder, $directory);
                                    $output['data']['progress'][$key]['file']      = base_url().$list_directory.$v_progress->foto;
                                    $output['data']['progress'][$key]['persentasi']      = $v_progress->persentasi;
                                    $output['data']['progress'][$key]['keterangan']      = $v_progress->keterangan;
                                    $output['data']['progress'][$key]['tgl_pengambilan']      = $v_progress->tgl_pengambilan;
                                }
                            }

                        $output['status']   = true;
                    }else{
                        $output['status']   = false;
                        $output['data']['kontrak']   = 'Tidak ada data kontrak';
                    }
            header('Content-Type: application/json');
            echo json_encode($output);
        
    }


    public function show_laporan_realisasi()
    {
            $output     = [
                'status' => false, 
                'message' => '', 
                'data'=>[]
            ];
            $android       = $this->android_model;
            $id_instansi = $this->input->get('id_instansi');
            $bulan = $this->input->get('bulan');
            $jenis = $this->input->get('jenis');
            
            $tgls ='tanggal';

             $primary_folder     = 'sbe_files_support/';
                                $directory          = [
                                	'pdf_laporan_realisasi',
                                    $tgls,
                                    $id_instansi,
                                    
                                ];
                                $list_directory     = $this->sbe_directory($primary_folder, $directory);
           
           $filenya = $jenis.'-'.$bulan.'.pdf';
           $lokasi_file = base_url().$list_directory.$filenya;
            $output['status'] = true;
            $output['data']['file']   = $lokasi_file;

            $cek = file_exists($lokasi_file);
            $output['data']['cek']   = $cek;
            header('Content-Type: application/json');
            echo json_encode($output);
        
    }

    public function show_laporan_rekap_asisten()
    {
            $output     = [
                'status' => false, 
                'message' => '', 
                'data'=>[]
            ];
            $android       = $this->android_model;
            $id_instansi = $this->input->get('id_instansi');
            $bulan = $this->input->get('bulan');
            $jenis = $this->input->get('jenis');
            
            $tgls ='tanggal';

             $primary_folder     = 'sbe_files_support/';
                                $directory          = [
                                	'pdf_laporan_realisasi',
                                    $tgls,
                                    $id_instansi,
                                    
                                ];
                                $list_directory     = $this->sbe_directory($primary_folder, $directory);
           
           $filenya = $jenis.'-'.$bulan.'.pdf';
           $lokasi_file = base_url().$list_directory.$filenya;
            $output['status'] = true;
            $output['data']['file']   = $lokasi_file;

            $cek = file_exists($lokasi_file);
            $output['data']['cek']   = $cek;
            header('Content-Type: application/json');
            echo json_encode($output);
        
    }



    public function bulan_global($ke){
        $bulan = [
            1=>'Januari',
            'Februari',
            'Maret',
            'April',
            'Mei',
            'Juni',
            'Juli',
            'Agustus',
            'September',
            'Oktober',
            'November',
            'Desember',
        ];
        return $bulan[$ke];
    }


    public function realisasi_akumulasi()
    {
       







       global $id_instansi;
        global $kategori;
        global $bulan;

        // $id_instansi    = sbe_crypt($this->input->get('id_opd'), 'D');
        $id_instansi     = $this->input->get('id_instansi');
        
        $kategori       = 'akumulasi';//$this->input->get('kategori');
        $bulan              = $this->input->get('bulan');
        switch ($kategori) {
            case 'akumulasi':
                $ope = '<=';
                break;
            case 'per_bulan':
                $ope = '=';
                break;
        }
        $judul_file     = slug($this->sbe_nama_instansi($id_instansi)) . '- Realisasi ' . $kategori . ' ' . $this->bulan_global($bulan) . '.pdf';

        // New
        $this->load->library('format_realisasi');
        $pdf = new Format_realisasi('L', 'mm', 'legal');
        $pdf->SetTopMargin(4);
        $pdf->SetLeftMargin(4);
        $pdf->AddPage();
        $pdf->SetTitle('Laporan Realisasi Tahun Anggaran ' . date('Y'));
        $pdf->SetAuthor("nama_user()");
        $pdf->SetCompression(true);

        $no_program     = 0;
        $pagu_program   = 0;
        $total_pad      = 0;
        $total_dau      = 0;
        $total_dak      = 0;
        $total_dbh      = 0;
        $total_lainnya  = 0;
        $total_target_fisik = 0;


        $total_angka_target_keuangan = 0 ; //05012021
        $total_angka_realisasi_keuangan = 0; //06012021
        $total_target_keuangan = 0;
        $total_realisasi_keuangan = 0;
        $total_persen_realisasi_keuangan = 0;
        $total_persen_realisasi_fisik = 0;
        $total_realisasi_ft = 0;
        $total_persen_deviasi_f = 0;
        $total_persen_deviasi_k = 0;
        $hitungdata = 0;

        $nol = 0;
        $program = $this->realisasi_akumulasi_model->get_program($id_instansi)->result();
        foreach ($program as $key => $value) {
            $no_program++;
            $pagu_program += $value->pagu;
            // Font
            $pdf->SetFont('Arial', 'B', 'L');
            $pdf->SetFontSize(6.5);

            $pdf->Cell(10, 6, $no_program, 1, 0);
            $pdf->Cell(337, 6, $value->nama_program, 1, 1, '', false);

            $no_kegiatan = 0;
            
            $kegiatan = $this->realisasi_akumulasi_model->get_kegiatan($id_instansi, $value->kode_rekening_program, $value->kode_bidang_urusan)->result();


            foreach ($kegiatan as $key => $value_kegiatan) {
                
                $no_kegiatan++;
                $pdf->SetFont('Arial', 'B', 'L');
                $pdf->SetFontSize(6);
                $pdf->Cell(10, 6, $no_program . '.' . $no_kegiatan, 1, 0);
                $pdf->Cell(337, 6,  '    ' . $value_kegiatan->nama_kegiatan, 1, 1, '', false);

                
                $no_sub_kegiatan = 0;
                $sub_kegiatan = $this->realisasi_akumulasi_model->get_sub_kegiatan($id_instansi, $value_kegiatan->kode_rekening_kegiatan, $value_kegiatan->kode_rekening_program, $value_kegiatan->kode_bidang_urusan)->result();

            
                foreach ($sub_kegiatan as $key => $value_sk) {
                
                    $no_sub_kegiatan++;
                    $pdf->SetFont('Arial', '', 'L');
                    $pdf->SetFontSize(6);
                    $pdf->Cell(10, 6, $no_program . '.' . $no_kegiatan. '.' . $no_sub_kegiatan, 1, 0);
                    $pdf->Cell(163, 6, '        ' . $value_sk->nama_sub_kegiatan, 1, 0);
                    $pdf->Cell(18, 6, number_format($value_sk->pagu), 1, 0, 'R');

                    $sumber_dana = $this->realisasi_akumulasi_model->get_sumber_dana($id_instansi, $value_sk->kode_rekening_sub_kegiatan, $value_sk->kode_rekening_kegiatan, $value_sk->kode_rekening_program, $value_sk->kode_bidang_urusan)->row_array();

                    $pdf->Cell(18, 6, number_format(isset($sumber_dana['pad']) ? $sumber_dana['pad'] : 0), 1, 0, 'R');
                    $pdf->Cell(18, 6, number_format(isset($sumber_dana['dau']) ? $sumber_dana['dau'] : 0), 1, 0, 'R');
                    $pdf->Cell(18, 6, number_format(isset($sumber_dana['dak']) ? $sumber_dana['dak'] : 0), 1, 0, 'R');
                    $pdf->Cell(18, 6, number_format(isset($sumber_dana['dbh']) ? $sumber_dana['dbh'] : 0), 1, 0, 'R');
                    $pdf->Cell(18, 6, number_format(isset($sumber_dana['lainnya']) ? $sumber_dana['lainnya'] : 0), 1, 0, 'R');

                    $target = $this->realisasi_akumulasi_model->get_target($id_instansi, $value_sk->kode_rekening_sub_kegiatan, $bulan)->row_array();
                    $realisasi_keuangan = $this->realisasi_akumulasi_model->get_realisasi_keuangan($id_instansi, $value_sk->kode_rekening_sub_kegiatan, $bulan, $ope)->row_array();

                    if ($value_sk->pagu == 0) {
                        $persen_target_keuangan     = 0;
                        $persen_realisasi_keuangan  = 0;
                    } else {
                        $persen_target_keuangan     = round(($target['target_keuangan'] / $value_sk->pagu) * 100, 2);
                        $persen_realisasi_keuangan  = round(($realisasi_keuangan['total_realisasi'] / $value_sk->pagu) * 100, 2);
                    }                   
                    $pdf->Cell(8, 6, $target['target_fisik'] =='' ? 0: $target['target_fisik']  , 1, 0, 'R');
                    $pdf->Cell(8, 6, $persen_target_keuangan, 1, 0, 'R');


                    $pdf->Cell(18, 6, number_format($realisasi_keuangan['total_realisasi']), 1, 0, 'R');

                    $pdf->Cell(8, 6, round($persen_realisasi_keuangan,2), 1, 0, 'R');


                    $total_paket = $this->realisasi_akumulasi_model->get_total_paket($id_instansi, $value_sk->kode_rekening_sub_kegiatan)->num_rows();
                    $jenis_rutin = $this->realisasi_akumulasi_model->get_total_paket_perjenis($id_instansi, $value_sk->kode_rekening_sub_kegiatan, "RUTIN")->num_rows();
                    $swa = $this->realisasi_akumulasi_model->get_realisasi_fisik($id_instansi, $value_sk->kode_rekening_sub_kegiatan, $bulan, 'SWAKELOLA', $ope)->row_array();
                    $pen = $this->realisasi_akumulasi_model->get_realisasi_fisik($id_instansi, $value_sk->kode_rekening_sub_kegiatan, $bulan, 'PENYEDIA', $ope)->row_array();
                    $rut = $jenis_rutin > 0 ? ($jenis_rutin * round($bulan / 12 * 100, 2)) : 0;
                    $total_angka_target_keuangan += $target['target_keuangan'];

                    $swa_tot    = !empty($swa['total']) ? $swa['total'] : 0;
                    $pen_tot  = !empty($pen['total']) ? $pen['total'] : 0;
                    $rut_tot  = !empty($rut) ? $rut : 0;
                    $pagu_opd = $this->realisasi_akumulasi_model->get_pagu_opd($id_instansi)->row_array();
                    $tot_pagu = !empty($pagu_opd['pagu']) ? $pagu_opd['pagu'] : 0;

                    if ($total_paket != 0) {
                        $total_fisik = ROUND(($swa_tot + $pen_tot + $rut_tot) / $total_paket,2);
                    } else {
                        $total_fisik = 0;
                    }

                    $total_fisik    = ROUND($total_fisik, 2) > 100 ? 100 : ROUND($total_fisik, 2);
                    $uang_fisik     = ($total_fisik / 100) * $value_sk->pagu;
                    @$persen_fisik  = ($uang_fisik / $tot_pagu) * 100;

                    $pdf->Cell(8, 6, $total_fisik, 1, 0, 'R');
                    
                    $dev_fisik = $total_fisik - $target['target_fisik'];
                    $dev_keu = $persen_realisasi_keuangan - $persen_target_keuangan;

                    $pdf->Cell(8, 6, ROUND($dev_fisik, 2), 1, 0, 'R');
                    $pdf->Cell(8, 6, ROUND($dev_keu, 2), 1, 1, 'R');

                    $total_pad      += isset($sumber_dana['pad']) ? $sumber_dana['pad'] : 0;
                    $total_dau      += isset($sumber_dana['dau']) ? $sumber_dana['dau'] : 0;
                    $total_dak      += isset($sumber_dana['dak']) ? $sumber_dana['dak'] : 0;
                    $total_dbh      += isset($sumber_dana['dbh']) ? $sumber_dana['dbh'] : 0;
                    $total_lainnya  += isset($sumber_dana['lainnya']) ? $sumber_dana['lainnya'] : 0;
                    $total_target_fisik     += isset($target['target_fisik']) ? $target['target_fisik'] : 0;
                    // last update 09102020
                    $total_target_keuangan += isset($persen_target_keuangan) ? $persen_target_keuangan : 0;
                    $total_realisasi_keuangan += isset($realisasi_keuangan['total_realisasi']) ? $realisasi_keuangan['total_realisasi'] : 0;
                    $total_persen_realisasi_keuangan += isset($persen_realisasi_keuangan) ? $persen_realisasi_keuangan : 0;
                    $total_persen_realisasi_fisik += isset($total_fisik) ? $total_fisik : 0;
                    $total_realisasi_ft += isset($persen_fisik) ? ROUND($persen_fisik, 2) : 0;
                    $total_persen_deviasi_f += isset($dev_fisik) ? ROUND($dev_fisik, 2) : 0;
                    $total_persen_deviasi_k += isset($dev_keu) ? ROUND($dev_keu, 2) : 0;

                }
            }
        
        }

        $pdf->Cell(173, 6, 'Total', 1, 0, 'R');
        
        $pdf->Cell(18, 6, number_format($pagu_program), 1, 0, 'R');
        $pdf->Cell(18, 6, number_format($total_pad), 1, 0, 'R');
        $pdf->Cell(18, 6, number_format($total_dau), 1, 0, 'R');
        $pdf->Cell(18, 6, number_format($total_dak), 1, 0, 'R');
        $pdf->Cell(18, 6, number_format($total_dbh), 1, 0, 'R');
        $pdf->Cell(18, 6, number_format($total_lainnya), 1, 0, 'R');





        $totaldata = $this->realisasi_akumulasi_model->jumlah_kegiatan($id_instansi);
        // dijadikan untuk rata rata pada target fisik, target keuangan, realisasi keuangan % , realisasi fisik, realisasi fisik tertimbang (FT), deviasi fisik, deviasi keuangan, 
        @$ratarata_target_fisik = $total_target_fisik / $totaldata;
        // $ratarata_target_keuangan = $total_target_keuangan / $totaldata;
        @$ratarata_target_keuangan = ($total_angka_target_keuangan / $pagu_program) * 100; // $totaldata;



        @$ratarata_persen_realisasi_keuangan = ($total_realisasi_keuangan / $pagu_program) * 100;
        // $ratarata_persen_realisasi_keuangan = $total_persen_realisasi_keuangan/$totaldata;
        
        @$ratarata_persen_realisasi_fisik = $total_persen_realisasi_fisik / $totaldata;
        @$ratarata_persen_realisasi_ft = $total_realisasi_ft / $totaldata;

         

        $total_persen_deviasi_f = $ratarata_persen_realisasi_fisik - $ratarata_target_fisik ;
        $total_persen_deviasi_k = $ratarata_persen_realisasi_keuangan- $ratarata_target_keuangan ;

        $pdf->Cell(8, 6, number_format($ratarata_target_fisik, 2, '.', ''), 1, 0, 'R');
        $pdf->Cell(8, 6, number_format($ratarata_target_keuangan, 2, '.', ''), 1, 0, 'R');
        $pdf->Cell(18, 6, number_format($total_realisasi_keuangan), 1, 0, 'R');
        $pdf->Cell(8, 6, number_format($ratarata_persen_realisasi_keuangan, 2, '.', ''), 1, 0, 'R');
        $pdf->Cell(8, 6, number_format($ratarata_persen_realisasi_fisik, 2, '.', ''), 1, 0, 'R');
        $pdf->Cell(8, 6, number_format($total_persen_deviasi_f, 2, '.', ''), 1, 0, 'R');
        $pdf->Cell(8, 6, number_format($total_persen_deviasi_k, 2, '.', ''), 1, 0, 'R');
        
        // last update 09102020

        $pdf->Output($judul_file, 'I');
    }







    public function realisasi_per_asisten()
    {
        global $bulan;

        $bulan          = $this->input->get('bulan');
        $judul_file = 'Rekapitulasi Per Asisten' . '.pdf';

        // New
        $this->load->library('format_realisasi');
        $pdf = new Laporan_asisten('L', 'mm', [215, 330]);
        $pdf->SetTopMargin(4);
        $pdf->SetLeftMargin(10);
        $pdf->AddPage();
        $pdf->SetTitle('Rekapitulasi Per Asisten ' . date('Y'));
        $pdf->SetAuthor("nama_user()");
        $pdf->SetCompression(true);

        $pagu_total = $this->rekap_asisten_model->get_pagu_total();
        $asisten_1 = $this->rekap_asisten_model->get_opd_asisten(204, $bulan)->result();
        $asisten_2 = $this->rekap_asisten_model->get_opd_asisten(205, $bulan)->result();
        $asisten_3 = $this->rekap_asisten_model->get_opd_asisten(206, $bulan)->result();

        // Font
        $pdf->SetFont('Arial', 'B', 'L');
        $pdf->SetFontSize(5);

        $pdf->cell(93, 2, '', 'T,L,R', 0, 'C'); // Table 1, Columns 1, Row 1
        $pdf->cell(12, 2, '', 'T', 0, 'C'); // Table 1, Columns 2, Row 1
        $pdf->cell(12, 2, '', 'T,L', 1, 'C'); // Table 1, Columns 3, Row 1, New Line

        $pdf->cell(93, 2, 'Asisten Pemerintahan', 'L,R', 0, 'C'); // Table 1, Columns 1, Row 2
        $pdf->cell(12, 0.1, 'Target', 0, 0, 'C'); // Table 1, Columns 2, Row 2
        $pdf->cell(12, 0.1, 'Realisasi', 'L,R', 1, 'C'); // Table 1, Columns 3, Row 2, New Line
        $pdf->cell(105, 1.9, '', 'R', 1, 'C'); // Table 1, Columns 3, Row 2

        // Asisten Pemerintahan
        $pdf->cell(93, 6, '', 'L', 0, 'C');
        $pdf->cell(6, 6, 'F', 1, 0, 'C');
        $pdf->cell(6, 6, 'K', 1, 0, 'C');
        $pdf->cell(6, 6, 'F', 1, 0, 'C');
        $pdf->cell(6, 6, 'K', 1, 1, 'C');
        // Content Asisten Pemerintahan
        $tertimbang_satu       = 0;
        $total_t_fisik_satu    = 0;
        $total_t_keu_satu      = 0;
        $total_r_fisik_satu    = 0;
        $total_r_keu_satu      = 0;
        $total_tertimbang_satu = 0;
        $jml_skpd_satu         = 0;

        foreach ($asisten_1 as $satu) {
            $pdf->SetFont('Arial', 'B', 'L');
            $pdf->SetFontSize(5);
            $pdf->Cell(93, 6, $satu->nama_instansi, 1, 0, '', false);
            $pdf->Cell(6, 6, $satu->target_fisik, 1, 0, '', false);
            $pdf->Cell(6, 6, $satu->target_keuangan, 1, 0, '', false);
            $pdf->Cell(6, 6, $satu->realisasi_fisik, 1, 0, '', false);
            $pdf->Cell(6, 6, $satu->realisasi_keuangan, 1, 1, '', false);
            $total_t_fisik_satu    += $satu->target_fisik;
            $total_t_keu_satu      += $satu->target_keuangan;
            $total_r_fisik_satu    += $satu->realisasi_fisik;
            $total_r_keu_satu      += $satu->realisasi_keuangan;
            $jml_skpd_satu++;
        }


        $total_t_fisik_satu     =  $total_t_fisik_satu / $jml_skpd_satu; 
        $total_t_keu_satu       =  $total_t_keu_satu / $jml_skpd_satu; 
        $total_r_fisik_satu     =  $total_r_fisik_satu / $jml_skpd_satu; 
        $total_r_keu_satu       =  $total_r_keu_satu / $jml_skpd_satu; 
        $pdf->Cell(93, 6, 'Rata-Rata', 1, 0, 'R');
        $pdf->Cell(6, 6, ROUND($total_t_fisik_satu, 2), 1, 0, '', false);
        $pdf->Cell(6, 6, ROUND($total_t_keu_satu, 2), 1, 0, '', false);
        $pdf->Cell(6, 6, ROUND($total_r_fisik_satu, 2), 1, 0, '', false);
        $pdf->Cell(6, 6, ROUND($total_r_keu_satu, 2), 1, 0, '', false);

        // ================================================================================ //

        $pdf->SetFont('Arial', 'B', 'L');
        $pdf->SetFontSize(5);
        // Asisten Perekonomian dan Pembangunan
        $pdf->SetY(30);
        $pdf->SetX(127);

        $pdf->cell(71, 2, '', 'T,L,R', 0, 'C'); // Table 2, Columns 1, Row 1
        $pdf->cell(12, 2, '', 'T', 0, 'C'); // Table 2, Columns 2, Row 1
        $pdf->cell(12, 2, '', 'T,L', 1, 'C'); // Table 2, Columns 3, Row 1, New Line

        $pdf->SetX(127);
        $pdf->cell(71, 2, 'Asisten Perekonomian dan Pembangunan', 'L,R', 0, 'C'); // Table 2, Columns 1, Row 2
        $pdf->cell(12, 0.1, 'Target', 0, 0, 'C'); // Table 2, Columns 2, Row 2
        $pdf->cell(12, 0.1, 'Realisasi', 'L,R', 1, 'C'); // Table 2, Columns 3, Row 2, New Line
        $pdf->SetX(127);
        $pdf->cell(83, 1.9, '', 0, 0, 'C'); // Table 2, Columns 3, Row 2
        $pdf->cell(12, 1.9, '', 'L', 1, 'C'); // Table 2, Columns 3, Row 2

        $pdf->SetX(127);
        $pdf->cell(71, 6, '', 'L', 0, 'C');
        $pdf->cell(6, 6, 'F', 1, 0, 'C');
        $pdf->cell(6, 6, 'K', 1, 0, 'C');
        $pdf->cell(6, 6, 'F', 1, 0, 'C');
        $pdf->cell(6, 6, 'K', 1, 1, 'C');

        $xxx = 42;
        $yyy = 6;
        $tertimbang_dua = 0;
        $total_t_fisik_dua    = 0;
        $total_t_keu_dua      = 0;
        $total_r_fisik_dua    = 0;
        $total_r_keu_dua      = 0;
        $total_tertimbang_dua = 0;
        $jml_skpd_dua         = 0;

        foreach ($asisten_2 as $dua) {
            // Font
            $pdf->SetFont('Arial', 'B', 'L');
            $pdf->SetFontSize(5);
            $pdf->SetX(127);
            $pdf->Cell(71, 6, $dua->nama_instansi, 1, 0, '', false);
            $pdf->Cell(6, 6, $dua->target_fisik, 1, 0, '', false);
            $pdf->Cell(6, 6, $dua->target_keuangan, 1, 0, '', false);
            $pdf->Cell(6, 6, $dua->realisasi_fisik, 1, 0, '', false);
            $pdf->Cell(6, 6, $dua->realisasi_keuangan, 1, 1, '', false);

            $total_t_fisik_dua    += $dua->target_fisik;
            $total_t_keu_dua      += $dua->target_keuangan;
            $total_r_fisik_dua    += $dua->realisasi_fisik;
            $total_r_keu_dua      += $dua->realisasi_keuangan;
            $jml_skpd_dua++;
        }
        $pdf->SetX(127);


        $total_t_fisik_dua      =  $total_t_fisik_dua / $jml_skpd_dua; 
        $total_t_keu_dua        =  $total_t_keu_dua / $jml_skpd_dua; 
        $total_r_fisik_dua      =  $total_r_fisik_dua / $jml_skpd_dua; 
        $total_r_keu_dua        =  $total_r_keu_dua / $jml_skpd_dua; 
        $pdf->Cell(71, 6, 'Rata-Rata', 1, 0, 'R');
        $pdf->Cell(6, 6, ROUND($total_t_fisik_dua, 2), 1, 0, '', false);
        $pdf->Cell(6, 6, ROUND($total_t_keu_dua, 2), 1, 0, '', false);
        $pdf->Cell(6, 6, ROUND($total_r_fisik_dua, 2), 1, 0, '', false);
        $pdf->Cell(6, 6, ROUND($total_r_keu_dua, 2), 1, 0, '', false);

        // ============================================================================ //

        $pdf->SetFont('Arial', 'B', 'L');
        $pdf->SetFontSize(5);
        // Asisten Perekonomian dan Pembangunan
        $pdf->SetY(30);
        $pdf->SetX(222); //204

        $pdf->cell(71, 2, '', 'T,L,R', 0, 'C'); // Table 3, Columns 1, Row 1
        $pdf->cell(12, 2, '', 'T', 0, 'C'); // Table 3, Columns 2, Row 1
        $pdf->cell(12, 2, '', 'T,L,R', 1, 'C'); // Table 3, Columns 3, Row 1, New Line

        $pdf->SetX(222);
        $pdf->cell(71, 2, 'Asisten Administrasi Umum dan Kesra', 'L,R', 0, 'C'); // Table 3, Columns 1, Row 2
        $pdf->cell(12, 0.1, 'Target', 0, 0, 'C'); // Table 3, Columns 2, Row 2
        $pdf->cell(12, 0.1, 'Realisasi', 'L,R', 1, 'C'); // Table 3, Columns 3, Row 2, New Line
        $pdf->SetX(222);
        $pdf->cell(83, 1.9, '', 0, 0, 'C'); // Table 3, Columns 3, Row 2
        $pdf->cell(12, 1.9, '', 'L,R', 1, 'C'); // Table 3, Columns 3, Row 2

        $pdf->SetX(222);
        $pdf->cell(71, 6, '', 'L', 0, 'C');
        $pdf->cell(6, 6, 'F', 1, 0, 'C');
        $pdf->cell(6, 6, 'K', 1, 0, 'C');
        $pdf->cell(6, 6, 'F', 1, 0, 'C');
        $pdf->cell(6, 6, 'K', 1, 1, 'C');

        $xxx = 42;
        $yyy = 6;
        $tertimbang_tiga = 0;
        $total_t_fisik_tiga    = 0;
        $total_t_keu_tiga      = 0;
        $total_r_fisik_tiga    = 0;
        $total_r_keu_tiga      = 0;
        $total_tertimbang_tiga = 0;
        $jml_skpd_tiga         = 0;
        foreach ($asisten_3 as $tiga) {
            // Font
            $pdf->SetFont('Arial', 'B', 'L');
            $pdf->SetFontSize(5);
            $pdf->SetX(222);
            $pdf->Cell(71, 6, $tiga->nama_instansi, 1, 0, '', false);
            $pdf->Cell(6, 6, $tiga->target_fisik, 1, 0, '', false);
            $pdf->Cell(6, 6, $tiga->target_keuangan, 1, 0, '', false);
            $pdf->Cell(6, 6, $tiga->realisasi_fisik, 1, 0, '', false);
            $pdf->Cell(6, 6, $tiga->realisasi_keuangan, 1, 1, '', false);

            $total_t_fisik_tiga    += $tiga->target_fisik;
            $total_t_keu_tiga      += $tiga->target_keuangan;
            $total_r_fisik_tiga    += $tiga->realisasi_fisik;
            $total_r_keu_tiga      += $tiga->realisasi_keuangan;

            $jml_skpd_tiga++;
        }
        $pdf->SetX(222);
        
        $total_t_fisik_tiga     =  $total_t_fisik_tiga / $jml_skpd_tiga; 
        $total_t_keu_tiga       =  $total_t_keu_tiga / $jml_skpd_tiga; 
        $total_r_fisik_tiga     =  $total_r_fisik_tiga / $jml_skpd_tiga; 
        $total_r_keu_tiga       =  $total_r_keu_tiga / $jml_skpd_tiga; 
        $pdf->Cell(71, 6, 'Rata-Rata', 1, 0, 'R');
        $pdf->Cell(6, 6, ROUND($total_t_fisik_tiga, 2), 1, 0, '', false);
        $pdf->Cell(6, 6, ROUND($total_t_keu_tiga, 2), 1, 0, '', false);
        $pdf->Cell(6, 6, ROUND($total_r_fisik_tiga, 2), 1, 0, '', false);
        $pdf->Cell(6, 6, ROUND($total_r_keu_tiga, 2), 1, 0, '', false);

        $pdf->Output('Laporan Rekapitulasi Per Asisten Bulan '.bulan_global($bulan).'.pdf', 'I');
    }

























    
  public function check_version_get(){
    header('Content-Type: application/json');

    $data = $this->mversi->init_check_version();

    if ($data != null)
    {
      $result = [
        'response' => 1,
        'message' => "Success",
        'result'=>$data
      ];
    }
    else
    {
      $result = [
        'response' => 0,
        'message'=> 'Parameter tidak diketahui/data tidak tersedia'
      ];
    }
    
    echo json_encode($result); 

  }

  public function insert_version_post(){
    header('Content-Type: application/json');
    $version_code           = $this->input->post('version_code');
    $version_name           = $this->input->post('version_name');

    $permit = $this->mversi->init_permit_version($version_code, $version_name);
    if ($permit >= 1) {
      $result = [
        'response' => 2,
        'message' => 'Data Sudah Ada'
      ];
    }
    else
    {
      $data = $this->mversi->init_insert_version();

      if ($data == true)
      {
        $result = [
          'response' => 1,
          'message' => 'Data Berhasil Disimpan'
        ];
      }
      else
      {
        $result = [
          'response' => 0,
          'message' => 'Parameter tidak diketahui/data tidak tersedia'
        ];
      }
    }
    
    echo json_encode($result); 

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




    public function config()
    {
            $output     = [
                'status' => false, 
                'message' => '', 
                'data'=>[]
            ];
            $android       = $this->android_model;
            $where = ['id_config'=>'SBE2018'];
            $q = $this->db->get_where('config', $where)->row_array();
            $output['status'] = true;
            $nama_tahap = [
            	2=>'APBD AWAL',
            	3=>'APBD PERGESERAN',
            	4=>'APBD PERUBAHAN',
            ];
            $output['data']['tahun_anggaran'] = $q['tahun_anggaran'];
            $output['data']['tahapan_apbd'] = $nama_tahap[$q['tahapan_apbd']];
           
            header('Content-Type: application/json');
            echo json_encode($output);
        
    }
}
