<?php

/**
 * androidor     : Alfikri, M.Kom
 * Created By : Alfikri, M.Kom
 * E-Mail     : alfikri.name@gmail.com
 * No HP      : 081277337405
 * Class      : android.php
 */
defined('BASEPATH') or exit('No direct script access allowed');

class Sumbarsiap extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->sumber_data = "Sumber Data : ???";
        $this->sumber_data_kab_kota = "???";
        $this->load->model('android/android_model', 'android_model');

        $this->load->model([
   //          'model_versi' => 'mversi',
   //          'dashboard/dashboard_model'       => 'dashboard_model',
           
			// 'realisasi/realisasi_fisik_keuangan_model'    => 'realisasi_fisik_keuangan_model',
			'Laporan/realisasi_akumulasi_model'		=> 'realisasi_akumulasi_model',
			// 'Laporan/rekap_asisten_model'					=> 'rekap_asisten_model',
			// 'Laporan/ratarata_fisik_keuangan'					=> 'ratarata_fisik_keuangan',
			// 'Laporan/rekap_realisasi_total_model'	=> 'rekap_realisasi_total_model',
			// 'Laporan/jumlah_aktivitas_model'	=> 'jumlah_aktivitas_model',
			// 'Laporan/rekap_kegiatan_kab_kota'	=> 'rekap_kegiatan_kab_kota',
			// 'Laporan/lap_realisasi_fisik_keu'	=> 'lap_realisasi_fisik_keu',
			// 'Laporan/realisasi_per_kab_kota'	=> 'realisasi_per_kab_kota',
			// 'Laporan/realisasi_gabungan_per_kab_kota'	=> 'realisasi_gabungan_per_kab_kota',
			// 'Laporan/target_realisasi_model'	=> 'target_realisasi_model',
			// 'Laporan/rekap_permasalahan_model'	=> 'rekap_permasalahan_model',
			// 'config/config_model' => 'config_model',

            'sumbarsiap/target_realisasi_model'     => 'target_realisasi_model',
			'sumbarsiap/sumbarsiap_model'      => 'sumbarsiap_model',
            
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

// public function pilih_tahun()
//     {
//             $output     = [
//                 'status' => false, 
//                 'message' => '', 
//                 'data'=>[]
//             ];
//             $sumbarsiap       = $this->sumbarsiap_model;
//             $q = $sumbarsiap->config();
//             foreach ($q->result_array() as $k => $v) {
//                 $output['data'][$k]['key'] = $v['tahun_anggaran'];
//                 $output['data'][$k]['value'] = $v['tahun_anggaran'];
//             }
//             header('Content-Type: application/json');
//             echo json_encode($output);
//     }
// public function pilih_tahap()
//     {
//             $output     = [
//                 'status' => false, 
//                 'message' => '', 
//                 'data'=>[]
//             ];
//             $sumbarsiap       = $this->sumbarsiap_model;
//             $q = [2=>'APBD Awal',4=>'APBD Perubahan'];
//             foreach ($q as $k => $v) {
//                 $output['data'][$k]['key'] = $k;
//                 $output['data'][$k]['value'] = $v;
//             }
//             header('Content-Type: application/json');
//             echo json_encode($output);
//     }
// public function pilih_jenis_belanja()
//     {
//             $output     = [
//                 'status' => false, 
//                 'message' => '', 
//                 'data'=>[]
//             ];
//             $sumbarsiap       = $this->sumbarsiap_model;
//                $q = [
//                     'bo'=>'Belanja Operasi',
//                     'bm'=>'Belanja Modal',
//                     'btt'=>'Belanja Tidak Terduga',
//                     'bt'=>'Belanja Transfer',
//                     'semua'=>'Semua Jenis Belanja',
//                 ];
//             foreach ($q as $k => $v) {
//                 $output['data'][$k]['key'] = $k;
//                 $output['data'][$k]['value'] = $v;
//             }
//             header('Content-Type: application/json');
//             echo json_encode($output);
//     }
// public function pilih_kategori()
//     {
//             $output     = [
//                 'status' => false, 
//                 'message' => '', 
//                 'data'=>[]
//             ];
//             $sumbarsiap       = $this->sumbarsiap_model;
//                $q = [
//                     'akumulasi'=>'Akumulasi',
//                     'per_bulan'=>'Perbulan',
                   
//                 ];
//             foreach ($q as $k => $v) {
//                 $output['data'][$k]['key'] = $k;
//                 $output['data'][$k]['value'] = $v;
//             }
//             header('Content-Type: application/json');
//             echo json_encode($output);
//     }
// public function pilih_bulan()
//     {
//             $output     = [
//                 'status' => false, 
//                 'message' => '', 
//                 'data'=>[]
//             ];
//             $sumbarsiap       = $this->sumbarsiap_model;
//             $q = [2=>'APBD Awal',4=>'APBD Perubahan'];
//             for ($i=1; $i <=12 ; $i++) { 
//                  $output['data'][$i]['key'] = $i;
//                 $output['data'][$i]['value'] = bulan_global($i);
//             }
            
//             header('Content-Type: application/json');
//             echo json_encode($output);
//     }
    public function menu()
    {
    	$id_menu = 0;
    	$fetch_method = $this->router->fetch_method();
            $output     = [
                'status' => "success", 
                'statusCode' => 200, 
                'message' => 'menampilkan data tentang ringkasan dana yang beredar di Provinsi Sumatera Barat', 
                'caption_title' => 'Sumbar SIAP', 
                'informasi_umum'=>[],
                'menu'=>[],
                'dataFilter'=>[],
            ];

            // ----------------------------------------------Untuk filter
            $q_filter_box = $this->db->query("SELECT * from sumbarsiap_filter_box where id_menu='$id_menu' and fetch_method='$fetch_method'")->result_array();
            foreach ($q_filter_box as $k_filter_box => $v_filter_box) {
            	$id_filter_box =$v_filter_box['id_filter_box'];
            	$output['dataFilter'][$k_filter_box]['id_filter_box'] = $id_filter_box;
            	$output['dataFilter'][$k_filter_box]['nama_filter_box'] = $v_filter_box['nama_filter_box'];
           		$filter = $this->db->query("SELECT * from sumbarsiap_kelompok_filter_menu skfm  
            	left join sumbarsiap_filter_parameter sfp on skfm.id_parameter = sfp.id_parameter
            	where skfm.id_filter_box='$id_filter_box'")->result_array();
                foreach ($filter as $k_kelompok => $v_kelompok) {
                	$output['dataFilter'][$k_filter_box]['pilihan'][$k_kelompok]['nama_filter'] = $v_kelompok['nama_parameter'];
                	$input_filter = $this->value_parameter_laporan($v_kelompok['id_parameter'], $v_kelompok['melibatkan_tabel'], $v_kelompok['kolom_ditampilkan'], $v_kelompok['kondisi_tabel']);
	            	$value_parameter = $input_filter;
                    $output['dataFilter'][$k_filter_box]['pilihan'][$k_kelompok]['kode_get'] =$v_kelompok['kode_parameter'];
                    $output['dataFilter'][$k_filter_box]['pilihan'][$k_kelompok]['type_filter'] =$v_kelompok['tipe'];
                    if ($v_kelompok['tipe']=='inputan') {
	                    $output['dataFilter'][$k_filter_box]['pilihan'][$k_kelompok]['value'] = ''	;
                    }else{
	                    $output['dataFilter'][$k_filter_box]['pilihan'][$k_kelompok]['parameter'] = $value_parameter	;

                    }
                }
            }
            // // ----------------------------------------------Untuk filter


                $tahun = !$this->input->get('tahun') ? tahun_anggaran() : $this->input->get('tahun'); 
                $tahap = !$this->input->get('kode_tahap') ? tahapan_apbd() : $this->input->get('kode_tahap'); 
                $bulan = !$this->input->get('bulan') ? bulan_aktif() : $this->input->get('bulan'); 
            $sumbarsiap       = $this->sumbarsiap_model;
            $menu = $sumbarsiap->menu()->result_array();
            $total_pagu = 0;
            $total_realisasi = 0;
            foreach ($menu as $k => $v) {
                $id_menu = $v['id_menu'];
                $output['menu'][$k]['id_menu'] =$id_menu ;
                $output['menu'][$k]['nama'] = $v['nama_menu'];
                // $output['menu'][$k]['keterangan'] = $v['keterangan'];
                $output['menu'][$k]['gambar'] = $v['gambar_menu'];
                $pagu_menu = $this->pagu_menu($id_menu, $tahap, $tahun);
                $realisasi_menu = $this->realisasi_menu($id_menu, $tahap, $tahun, $bulan);
                $total_pagu += $pagu_menu;
                $total_realisasi += $realisasi_menu;
                 $persen_realisasi =  $pagu_menu ==0 ? 0 : ($realisasi_menu/ $pagu_menu) * 100;
                $output['menu'][$k]['pagu'] = number_format($pagu_menu);
                $output['menu'][$k]['direalisasikan'] = number_format($realisasi_menu);
                $output['menu'][$k]['persen_realisasi'] = round($persen_realisasi,2 );
                // $output['menu'][$k]['module'] = base_url('sumbarsiap/').$v['module'];
            }
                // $output['informasi_umum']['tahun'] = $tahun;
                $output['informasi_umum']['sumber_data'] = $this->sumber_data;
                $output['informasi_umum']['deskripsi'] = "Total Dana Pembangunan di Provinsi Sumatera Barat Tahun ".$tahun." \nData sampai bulan ".bulan_global($bulan)." ".$tahun;
                $output['informasi_umum']['pagu'] = number_format($total_pagu)	;
                $persen_realisasi = $total_pagu == 0 ? 0 : ($total_realisasi / $total_pagu) * 100;
                $output['informasi_umum']['direalisasikan'] = number_format($total_realisasi)	;
                $output['informasi_umum']['persen_realisasi'] = round($persen_realisasi,2)	;
                $config = $this->db->get('config')->result_array();
              


            header('Content-Type: application/json');
            echo json_encode($output);
  
    }
    public function pagu_menu($id_menu, $tahap, $tahun){
    	if ($id_menu==1) {
    		$sql_pagu = $this->db->query("SELECT sum(bo_bp + bo_bbj+ bo_bs+bo_bh + bm_bmt + bm_bmpm + bm_bmgb + bm_bmjji + bm_bmatl +btt + bt_bbh+bt_bbk ) as pagu from anggaran_sub_kegiatan  where kode_tahap='$tahap' and tahun='$tahun'")->row_array();
    		$pagu_total = $sql_pagu['pagu'];
    	}
    	elseif ($id_menu==2) {
    		$q_ckk = $this->db->query("SELECT * from config_kab_kota")->result_array();
    		$total_pagu = 0;
    		foreach ($q_ckk as $k => $v) { 
    			$id_kota = $v['id_kota'];
    			if ($v['replikasi']=='Online') {
    				$link = $v['url_replikasi'];
    				$link_pagu_kab_kota_replikasi = $v['url_replikasi'].'/sumbarsiap/pagu_kab_kota_replikasi/'.$tahap.'/'.$tahun;
                    $pagu_kab_kota_replikasi = file_get_contents($link_pagu_kab_kota_replikasi, true);
                    $pagu_kab_kota_replikasi = $pagu_kab_kota_replikasi == "" ? 0 : $pagu_kab_kota_replikasi;
                    $pagu_kab_kota = $pagu_kab_kota_replikasi;
    			}else{
    				$q_pagu = $this->db->query("SELECT 
					sum(bo_bp + bo_bbj+ bo_bs+bo_bh + bm_bmt + bm_bmpm + bm_bmgb + bm_bmjji + bm_bmatl +btt +  bt_bbh+bt_bbk ) as total_pagu from anggaran_instansi_kab_kota where id_kota='$id_kota' and kode_tahap='$tahap' and tahun='$tahun'")->row_array();
					$pagu_kab_kota = $q_pagu['total_pagu'];
    			}
    			$total_pagu += $pagu_kab_kota;
    		}
    		$pagu_total = $total_pagu;
    	}else{
    		$pagu_total = 0;
    	}
    	return $pagu_total;
    }
    public function realisasi_menu($id_menu, $tahap, $tahun, $bulan){
    	if ($id_menu==1) {
    		$sql_realisasi = $this->db->query("SELECT sum(bo_bp + bo_bbj+ bo_bs+bo_bh + bm_bmt + bm_bmpm + bm_bmgb + bm_bmjji + bm_bmatl +btt + bt_bbh+bt_bbk ) as realisasi from realisasi_keuangan where kode_tahap='$tahap' and tahun='$tahun' and bulan <=$bulan ")->row_array();
    		$realisasi_total = $sql_realisasi['realisasi'];
    	}
    	elseif ($id_menu==2) {
    		$q_ckk = $this->db->query("SELECT * from config_kab_kota")->result_array();
    		$total_realisasi = 0;
    		foreach ($q_ckk as $k => $v) { 
    			$id_kota = $v['id_kota'];
    			if ($v['replikasi']=='Online') {
    				$link = $v['url_replikasi'];
    				$link_realisasi_kab_kota_replikasi = $v['url_replikasi'].'/sumbarsiap/realisasi_kab_kota_replikasi/'.$tahap.'/'.$tahun.'/'.$bulan;
                    $realisasi_kab_kota_replikasi = file_get_contents($link_realisasi_kab_kota_replikasi, true);
                    $realisasi_kab_kota_replikasi = $realisasi_kab_kota_replikasi == "" ? 0 : $realisasi_kab_kota_replikasi;
                    $realisasi_kab_kota = $realisasi_kab_kota_replikasi;
    			}else{
    				$q_realisasi = $this->db->query("SELECT 
					sum(bo_bp + bo_bbj+ bo_bs+bo_bh + bm_bmt + bm_bmpm + bm_bmgb + bm_bmjji + bm_bmatl +btt +  bt_bbh+bt_bbk ) as total_realisasi from realisasi_fisik_keuangan_kab_kota where id_kota='$id_kota' and kode_tahap='$tahap' and tahun='$tahun' and bulan <=$bulan")->row_array();
					$realisasi_kab_kota = $q_realisasi['total_realisasi'];
    			}
    			$total_realisasi += $realisasi_kab_kota;
    		}
    		$realisasi_total = $total_realisasi;
    	}else{
    		$realisasi_total = 0;
    	}
    	return $realisasi_total;
    }
    public function apbd_provinsi()
    {	
    	$fetch_method = $this->router->fetch_method();
    	$id_menu =1;
            $keyword = !$this->input->get('keyword') ? '' : $this->input->get('keyword'); 

            $output     = [
                'status' => "success", 
                'statusCode' => 200, 
                'message' => 'menampilkan data tentang ringkasan dana yang beredar di SKPD Provinsi Sumatera Barat', 
                'caption_title' => 'SKPD Provinsi', 
                'informasi_umum'=>[],
                'dataFilter'=>[],

                'data_instansi'=>[],
            ];

            $identitas = $this->db->get('identitas')->row_array();
                $tahun = !$this->input->get('tahun') ? tahun_anggaran() : $this->input->get('tahun'); 
                $tahap = !$this->input->get('kode_tahap') ? tahapan_apbd() : $this->input->get('kode_tahap'); 
                $bulan = !$this->input->get('bulan') ? bulan_aktif() : $this->input->get('bulan'); 
                $kategori = !$this->input->get('kategori') ? 'akumulasi' : $this->input->get('kategori'); 
                $ranking = !$this->input->get('rank') ? 'fisik_tertinggi' : $this->input->get('rank'); 

            
                $output['informasi_umum']['sumber_data'] = $this->sumber_data;
            
            // ----------------------------------------------Untuk filter
            $q_filter_box = $this->db->query("SELECT * from sumbarsiap_filter_box where id_menu='$id_menu' and fetch_method='$fetch_method' and is_active='1'")->result_array();
            foreach ($q_filter_box as $k_filter_box => $v_filter_box) {
            	$id_filter_box =$v_filter_box['id_filter_box'];
            	$output['dataFilter'][$k_filter_box]['id_filter_box'] = $id_filter_box;
            	$output['dataFilter'][$k_filter_box]['nama_filter_box'] = $v_filter_box['nama_filter_box'];
            	$output['dataFilter'][$k_filter_box]['pindah_halaman'] = $v_filter_box['pindah_halaman'];
            	$output['dataFilter'][$k_filter_box]['halaman_baru'] = $v_filter_box['halaman_baru'] =='' ? '' : base_url().'sumbarsiap/'.$v_filter_box['halaman_baru'];
           		$filter = $this->db->query("SELECT * from sumbarsiap_kelompok_filter_menu skfm  
            	left join sumbarsiap_filter_parameter sfp on skfm.id_parameter = sfp.id_parameter
            	where skfm.id_filter_box='$id_filter_box'")->result_array();
                foreach ($filter as $k_kelompok => $v_kelompok) {
                	$output['dataFilter'][$k_filter_box]['pilihan'][$k_kelompok]['nama_filter'] = $v_kelompok['nama_parameter'];
                	$input_filter = $this->value_parameter_laporan($v_kelompok['id_parameter'], $v_kelompok['melibatkan_tabel'], $v_kelompok['kolom_ditampilkan'], $v_kelompok['kondisi_tabel']);
	            	$value_parameter = $input_filter;
                    $output['dataFilter'][$k_filter_box]['pilihan'][$k_kelompok]['kode_get'] =$v_kelompok['kode_parameter'];
                    $output['dataFilter'][$k_filter_box]['pilihan'][$k_kelompok]['type_filter'] =$v_kelompok['tipe'];
                    if ($v_kelompok['tipe']=='inputan') {
	                    $output['dataFilter'][$k_filter_box]['pilihan'][$k_kelompok]['value'] = ''	;
                    }else{
	                    $output['dataFilter'][$k_filter_box]['pilihan'][$k_kelompok]['parameter'] = $value_parameter	;

                    }
                }
            }
            // // ----------------------------------------------Untuk filter
                $nama_perengkingan = [
                	'fisik_tertinggi'=>'Realisasi Fisik Tertinggi',
                	'fisik_terendah'=>'Realisasi Fisik Terendah',
                	'keuangan_tertinggi'=>'Realisasi Keuangan Tertinggi',
                	'keuangan_terendah'=>'Realisasi Keuangan Terendah',
                ];
                $nama_tahapan = [
                	'2'=>'APBD Awal',
                	'4'=>'APBD Perubahan',
                ];
                $perhitungan = [
                	'akumulasi'=>'Sampai Bulan',
                	'per_bulan'=>'Bulan',
                ];

            $sumbarsiap       = $this->sumbarsiap_model;

                
                $nama_caption_filter = [
                    'bo'=>'Belanja Operasi',
                    'bm'=>'Belanja Modal',
                    'btt'=>'Belanja Tidak Terduga',
                    'bt'=>'Belanja Transfer',
                    'semua'=>'Semua Jenis Belanja',
                ];

                 $output['caption_title'] = $identitas['caption_sumbar_siap'];
                 $output['informasi_umum']['deskripsi'] = "Urutan SKPD berdasarkan ".$nama_perengkingan[$ranking]." ".$nama_tahapan[$tahap]." ".$perhitungan[$kategori]." ". bulan_global($bulan)." ".$tahun;
                 $output['informasi_umum']['keyword'] = $keyword;
                 $output['informasi_umum']['logo'] = base_url().'assets/sbe/image/logo.png';
                 // $output['info']['ranking'] = $nama_perengkingan[$ranking];
                 // $output['info']['tahun'] =$tahun;
                 // $output['info']['tahapan'] = $nama_tahapan[$tahap];
                 // $output['info']['bulan'] = bulan_global($bulan);
                 // $output['info']['perhitungan'] = $perhitungan[$kategori];


            if ($ranking=='fisik_tertinggi') {
                	$order_by = "order by g.realisasi_fisik desc";
            }
            elseif ($ranking=='fisik_terendah') {
            	$order_by = "order by g.realisasi_fisik asc";
            }
            elseif ($ranking=='keuangan_tertinggi') {
            	$order_by = "order by g.realisasi_keuangan desc";
            }
            elseif ($ranking=='keuangan_terendah') {
            	$order_by = "order by g.realisasi_keuangan asc";
            }

            if ($keyword=='') {
            	$where_nama_instansi = "";
            }else{
            	$where_nama_instansi = "and mi.nama_instansi like '%$keyword%'";

            }
            $grafik = $this->db->query("SELECT g.*, mi.nama_instansi from grafik g
            	left join master_instansi mi on g.id_instansi = mi.id_instansi
            	where g.kode_tahap='$tahap' and g.tahun ='$tahun' and g.bulan='$bulan'
            	$where_nama_instansi
            	$order_by
            	");

            if ($ranking=='fisik_tertinggi' || $ranking=='keuangan_tertinggi') {

	            $kumpul_instansi_belum_bergrafik = [];
	            	

	            $jumlah_skpd_bergrafik = $grafik->num_rows();
	            foreach ($grafik->result_array() as $k => $v) {
	                $id_instansi =$v['id_instansi'] ;
	                array_push($kumpul_instansi_belum_bergrafik, $id_instansi);
	               $output['data_instansi'][$k]['id_instansi'] = $v['id_instansi'];
	                $output['data_instansi'][$k]['nama_instansi'] = $v['nama_instansi'];
	                $output['data_instansi'][$k]['fisik'] = $v['realisasi_fisik'];
	                $output['data_instansi'][$k]['keuangan'] = $v['realisasi_keuangan'];
	                $output['data_instansi'][$k]['link'] = base_url().'sumbarsiap/detail_skpd/'.$v['id_instansi'].'/'.$tahun.'/'.$tahap;
	            }
	               $skpd_tak_bergrafik =  join(",",$kumpul_instansi_belum_bergrafik);
	               $skpd = $sumbarsiap->skpd($skpd_tak_bergrafik, $keyword);
	              $jumlah_skpd_tak_bergrafik = $skpd->num_rows();
	            foreach ($skpd->result_array() as $k => $v) {
	            	$key_selanjutnya = $k+$jumlah_skpd_bergrafik;
	                $id_instansi =$v['id_instansi'] ;
	                $output['data_instansi'][$key_selanjutnya]['id_instansi'] = $v['id_instansi'];
	                $output['data_instansi'][$key_selanjutnya]['nama_instansi'] = $v['nama_instansi'];
	                $output['data_instansi'][$key_selanjutnya]['fisik'] = '0.00';
	                $output['data_instansi'][$key_selanjutnya]['keuangan'] = '0.00';
	                $output['data_instansi'][$key_selanjutnya]['link'] = base_url().'sumbarsiap/detail_skpd/'.$v['id_instansi'].'/'.$tahun.'/'.$tahap;
	            }
	        }else{

	            $kumpul_instansi_belum_bergrafik = [];




	            foreach ($grafik->result_array() as $k => $v) {
	                $id_instansi =$v['id_instansi'] ;
	                array_push($kumpul_instansi_belum_bergrafik, $id_instansi);
	              
	            }
	               $skpd_tak_bergrafik =  join(",",$kumpul_instansi_belum_bergrafik);
	               $skpd = $sumbarsiap->skpd($skpd_tak_bergrafik, $keyword);
	              $jumlah_skpd_tak_bergrafik = $skpd->num_rows();
	            foreach ($skpd->result_array() as $k => $v) {
	            	$key_selanjutnya = $k;
	                $id_instansi =$v['id_instansi'] ;
	                $output['data_instansi'][$key_selanjutnya]['id_instansi'] = $v['id_instansi'];
	                $output['data_instansi'][$key_selanjutnya]['nama_instansi'] = $v['nama_instansi'];
	                $output['data_instansi'][$key_selanjutnya]['fisik'] = '0.00';
	               $output['data_instansi'][$key_selanjutnya]['link'] = base_url().'sumbarsiap/detail_skpd/'.$v['id_instansi'].'/'.$tahun.'/'.$tahap;
	            }


	            foreach ($grafik->result_array() as $k => $v) {
	            	$key_selanjutnya = $k + $jumlah_skpd_tak_bergrafik;
	               $output['data_instansi'][$key_selanjutnya]['id_instansi'] = $v['id_instansi'];
	                $output['data_instansi'][$key_selanjutnya]['nama_instansi'] = $v['nama_instansi'];
	                $output['data_instansi'][$key_selanjutnya]['fisik'] = $v['realisasi_fisik'];
	                $output['data_instansi'][$key_selanjutnya]['link'] = base_url().'sumbarsiap/detail_skpd/'.$v['id_instansi'].'/'.$tahun.'/'.$tahap;
	            }



	        }

            header('Content-Type: application/json');
            echo json_encode($output);
        // }
    }


    public function gis_gabungan_provinsi()
    {
    	$fetch_method = $this->router->fetch_method();
    	$id_menu =1;
		$identitas = $this->db->get('identitas')->row_array();
		$tahun = !$this->input->get('tahun') ? tahun_anggaran() : $this->input->get('tahun'); 
		$keyword = !$this->input->get('keyword') ? '' : $this->input->get('keyword'); 
		$id_kota = !$this->input->get('id_kota') ? '' : $this->input->get('id_kota'); 
        if ($id_kota=='') {
           $nama_kota = 'Semua Kabupaten / Kota';
        }else{
           $nama_kota = nama_kota($id_kota);

        }
            $output     = [


                'status' => "success", 
                'statusCode' => 200, 
                'message' => 'menampilkan data tentang ringkasan dana yang beredar di Provinsi Sumatera Barat', 
                'caption_title' => 'Lokasi Pekerjaan', 
                'informasi_umum'=>[
                    'deskripsi'=>'Lokasi pekerjaan yang ada di '.$nama_kota,
                    'logo'=> base_url().'assets/sbe/image/logo.png',
                    'keyword'=>$keyword,
                ],
                'menu'=>[],
                'dataFilter'=>[],


                'data'=>[],
            ];

    
            $output['informasi_umum']['sumber_data'] = $this->sumber_data;
            // ----------------------------------------------Untuk filter
            $q_filter_box = $this->db->query("SELECT * from sumbarsiap_filter_box where id_menu='$id_menu' and fetch_method='$fetch_method' and is_active='1'")->result_array();
            foreach ($q_filter_box as $k_filter_box => $v_filter_box) {
                $id_filter_box =$v_filter_box['id_filter_box'];
                $output['dataFilter'][$k_filter_box]['id_filter_box'] = $id_filter_box;
                $output['dataFilter'][$k_filter_box]['nama_filter_box'] = $v_filter_box['nama_filter_box'];
                $filter = $this->db->query("SELECT * from sumbarsiap_kelompok_filter_menu skfm  
                left join sumbarsiap_filter_parameter sfp on skfm.id_parameter = sfp.id_parameter
                where skfm.id_filter_box='$id_filter_box'")->result_array();
                foreach ($filter as $k_kelompok => $v_kelompok) {
                    $output['dataFilter'][$k_filter_box]['pilihan'][$k_kelompok]['nama_filter'] = $v_kelompok['nama_parameter'];
                    $input_filter = $this->value_parameter_laporan($v_kelompok['id_parameter'], $v_kelompok['melibatkan_tabel'], $v_kelompok['kolom_ditampilkan'], $v_kelompok['kondisi_tabel']);
                    $value_parameter = $input_filter;
                    $output['dataFilter'][$k_filter_box]['pilihan'][$k_kelompok]['kode_get'] =$v_kelompok['kode_parameter'];
                    $output['dataFilter'][$k_filter_box]['pilihan'][$k_kelompok]['type_filter'] =$v_kelompok['tipe'];
                    if ($v_kelompok['tipe']=='inputan') {
                        $output['dataFilter'][$k_filter_box]['pilihan'][$k_kelompok]['value'] = ''  ;
                    }else{
                        $output['dataFilter'][$k_filter_box]['pilihan'][$k_kelompok]['parameter'] = $value_parameter    ;

                    }
                }
            }
            // // ----------------------------------------------Untuk filter


            $sumbarsiap       = $this->sumbarsiap_model;
            $gis = $sumbarsiap->gis_gabungan($id_kota, $keyword, $tahun);
            foreach ($gis->result_array() as $k => $v) {
            	$output['data'][$k]['id_paket_pekerjaan'] = $v['id_paket_pekerjaan'];
            	$output['data'][$k]['skpd'] = $v['nama_instansi'];
            	$output['data'][$k]['nama_paket'] = $v['nama_paket'];
            	$output['data'][$k]['nama_sub_kegiatan'] = $v['kategori']=='Sub Kegiatan SKPD' ? $v['nama_sub_kegiatan'] : $v['nama_sub_kegiatan']." \n ".$v['jenis_sub_kegiatan'].' - '.$v['keterangan'] ;
            	$output['data'][$k]['latitude'] = $v['latitude'];
            	$output['data'][$k]['longitude'] = $v['longitude'];
            }
			header('Content-Type: application/json');
            echo json_encode($output);
    }

    public function gis_skpd_provinsi($id_instansi)
    {
        $fetch_method = $this->router->fetch_method();
        $id_menu =1;
        $identitas = $this->db->get('identitas')->row_array();
        $tahun = !$this->input->get('tahun') ? tahun_anggaran() : $this->input->get('tahun'); 
        $keyword = !$this->input->get('keyword') ? '' : $this->input->get('keyword'); 
        $id_kota = !$this->input->get('id_kota') ? '' : $this->input->get('id_kota'); 
        if ($id_kota=='') {
           $nama_kota = 'Semua Kabupaten / Kota';
        }else{
           $nama_kota = nama_kota($id_kota);

        }
            $output     = [


                'status' => "success", 
                'statusCode' => 200, 
                'message' => 'menampilkan data tentang ringkasan dana yang beredar di Provinsi Sumatera Barat', 
                'caption_title' => 'Lokasi Pekerjaan', 
                'informasi_umum'=>[
                    'deskripsi'=>'Lokasi pekerjaan yang ada di '.$nama_kota,
                    'logo'=> base_url().'assets/sbe/image/logo.png',
                    'keyword'=>$keyword,
                ],
                'menu'=>[],
                'dataFilter'=>[],


                'data'=>[],
            ];


                $output['informasi_umum']['sumber_data'] = $this->sumber_data;
            
            // ----------------------------------------------Untuk filter
            $q_filter_box = $this->db->query("SELECT * from sumbarsiap_filter_box where id_menu='$id_menu' and fetch_method='$fetch_method' and is_active='1'")->result_array();
            foreach ($q_filter_box as $k_filter_box => $v_filter_box) {
                $id_filter_box =$v_filter_box['id_filter_box'];
                $output['dataFilter'][$k_filter_box]['id_filter_box'] = $id_filter_box;
                $output['dataFilter'][$k_filter_box]['nama_filter_box'] = $v_filter_box['nama_filter_box'];
                $filter = $this->db->query("SELECT * from sumbarsiap_kelompok_filter_menu skfm  
                left join sumbarsiap_filter_parameter sfp on skfm.id_parameter = sfp.id_parameter
                where skfm.id_filter_box='$id_filter_box'")->result_array();
                foreach ($filter as $k_kelompok => $v_kelompok) {
                    $output['dataFilter'][$k_filter_box]['pilihan'][$k_kelompok]['nama_filter'] = $v_kelompok['nama_parameter'];
                    $input_filter = $this->value_parameter_laporan($v_kelompok['id_parameter'], $v_kelompok['melibatkan_tabel'], $v_kelompok['kolom_ditampilkan'], $v_kelompok['kondisi_tabel']);
                    $value_parameter = $input_filter;
                    $output['dataFilter'][$k_filter_box]['pilihan'][$k_kelompok]['kode_get'] =$v_kelompok['kode_parameter'];
                    $output['dataFilter'][$k_filter_box]['pilihan'][$k_kelompok]['type_filter'] =$v_kelompok['tipe'];
                    if ($v_kelompok['tipe']=='inputan') {
                        $output['dataFilter'][$k_filter_box]['pilihan'][$k_kelompok]['value'] = ''  ;
                    }else{
                        $output['dataFilter'][$k_filter_box]['pilihan'][$k_kelompok]['parameter'] = $value_parameter    ;

                    }
                }
            }
            // // ----------------------------------------------Untuk filter


            $sumbarsiap       = $this->sumbarsiap_model;
            $gis = $sumbarsiap->gis_skpd_provinsi($id_instansi, $id_kota, $keyword, $tahun);
            foreach ($gis->result_array() as $k => $v) {
                $output['data'][$k]['id_paket_pekerjaan'] = $v['id_paket_pekerjaan'];
                $output['data'][$k]['skpd'] = $v['nama_instansi'];
                $output['data'][$k]['nama_paket'] = $v['nama_paket'];
                $output['data'][$k]['nama_sub_kegiatan'] = $v['kategori']=='Sub Kegiatan SKPD' ? $v['nama_sub_kegiatan'] : $v['nama_sub_kegiatan']." \n ".$v['jenis_sub_kegiatan'].' - '.$v['keterangan'] ;
                $output['data'][$k]['latitude'] = $v['latitude'];
                $output['data'][$k]['longitude'] = $v['longitude'];
            }
            header('Content-Type: application/json');
            echo json_encode($output);
    }

    public function detail_paket_pekerjaan($id_paket_pekerjaan)
    {

        $output['informasi_umum']['sumber_data'] = $this->sumber_data;
    	$fetch_method = $this->router->fetch_method();
    	$id_menu =1;
		$identitas = $this->db->get('identitas')->row_array();
		$tahun = !$this->input->get('tahun') ? tahun_anggaran() : $this->input->get('tahun'); 
		$keyword = !$this->input->get('keyword') ? '' : $this->input->get('keyword'); 
		$id_kota = !$this->input->get('id_kota') ? '' : $this->input->get('id_kota'); 
            $output     = [
                'status' => "success", 
                'statusCode' => 200, 
                'message' => '', 
                'caption_title' => 'Detail Paket Pekerjaan', 
                'informasi_umum'=>[],
                'dataFilter'=>[],
                'galeri'=>[],

            ];



            $sumbarsiap       = $this->sumbarsiap_model;
            $gis = $sumbarsiap->detail_paket_pekerjaan($id_paket_pekerjaan);
            $v = $gis->row_array();
            	$output['informasi_umum']['logo'] = base_url().'assets/sbe/image/logo.png';
            	$output['informasi_umum']['tahun'] = $tahun;
                $output['informasi_umum']['id_paket_pekerjaan'] = $v['id_paket_pekerjaan'];
            	$output['informasi_umum']['skpd'] = $v['nama_instansi'];
            	$output['informasi_umum']['nama_sub_kegiatan'] = $v['kategori']=='Sub Kegiatan SKPD' ? $v['nama_sub_kegiatan'] : $v['nama_sub_kegiatan']." \n ".$v['jenis_sub_kegiatan'].' - '.$v['keterangan'] ;

            	$output['informasi_umum']['pptk'] = $v['pptk'];
            	$output['informasi_umum']['lokasi'] = $v['nama_kota'];

            	$output['informasi_umum']['nama_paket'] = $v['nama_paket'];
            	$output['informasi_umum']['pagu_paket'] = number_format($v['pagu']);
            	$output['informasi_umum']['jenis_paket'] = $v['jenis_paket'];
            	$output['informasi_umum']['metode_paket'] = $v['metode'];
            	$output['informasi_umum']['banyak_pelaksanaan'] = $v['banyak_pelaksanaan'];
            	$output['informasi_umum']['nilai_kontrak'] = number_format($v['nilai_kontrak']=='' ? 0 : $v['nilai_kontrak']);
            	$output['informasi_umum']['penyedia'] = $v['pelaksana'];

            	$output['informasi_umum']['latitude'] = $v['latitude'] ==''? '' : $v['latitude'];
            	$output['informasi_umum']['longitude'] = $v['longitude'] ==''? '' : $v['longitude'];


            $progress = $sumbarsiap->progress_pekerjaan($id_paket_pekerjaan);
             $primary_folder     = base_url().'sbe_files_data/';
                $directory          = [
                    $tahun,
                    $v['id_instansi'],
                    'PROGRESS-PEKERJAAN',
                    $id_paket_pekerjaan,
                ];
                $list_directory = $this->sbe_directory($primary_folder, $directory);


            if ($progress->num_rows()>0) {
	            foreach ($progress->result_array() as $k => $v) {

            	$output['galeri'][$k]['keterangan'] = $v['keterangan'];
            	$output['galeri'][$k]['tgl_pengambilan'] = $v['tgl_pengambilan'];
            	$output['galeri'][$k]['foto'] = $list_directory.$v['foto'];
            	$output['galeri'][$k]['persentasi'] = $v['persentasi'];
	            }
            }else{

            }
            
			header('Content-Type: application/json');
            echo json_encode($output);
    }

    public function detail_skpd($id_instansi, $tahun, $tahap)
    {

        $output['informasi_umum']['sumber_data'] = $this->sumber_data;
    	$fetch_method = $this->router->fetch_method();
        $id_menu = 1;
    	$keyword = !$this->input->get('keyword') ? '' : $this->input->get('keyword'); 
        $bulan = !$this->input->get('bulan') ? bulan_aktif() : $this->input->get('bulan'); 

        $identitas = $this->db->get('identitas')->row_array();
        $nama_tahapan = [
                	'2'=>'APBD Awal',
                	'4'=>'APBD Perubahan',
                ];

            $output     = [

                'status' => "success", 
                'statusCode' => 200, 
                'message' => '', 
                'caption_title' => 'Detail SKPD', 
                'informasi_umum'=>[],
                'dataFilter'=>[],
                'program'=>[],
            ];
            


            // ----------------------------------------------Untuk filter
            $q_filter_box = $this->db->query("SELECT * from sumbarsiap_filter_box where id_menu='$id_menu' and fetch_method='$fetch_method' and is_active='1'")->result_array();
            foreach ($q_filter_box as $k_filter_box => $v_filter_box) {
                $id_filter_box =$v_filter_box['id_filter_box'];
                $output['dataFilter'][$k_filter_box]['id_filter_box'] = $id_filter_box;
                $output['dataFilter'][$k_filter_box]['nama_filter_box'] = $v_filter_box['nama_filter_box'];
                $output['dataFilter'][$k_filter_box]['pindah_halaman'] = $v_filter_box['pindah_halaman'];
                $output['dataFilter'][$k_filter_box]['halaman_baru'] = $v_filter_box['halaman_baru'] =='' ? '' : base_url().'sumbarsiap/'.$v_filter_box['halaman_baru'];
                $filter = $this->db->query("SELECT * from sumbarsiap_kelompok_filter_menu skfm  
                left join sumbarsiap_filter_parameter sfp on skfm.id_parameter = sfp.id_parameter
                where skfm.id_filter_box='$id_filter_box'")->result_array();
                foreach ($filter as $k_kelompok => $v_kelompok) {
                    $output['dataFilter'][$k_filter_box]['pilihan'][$k_kelompok]['nama_filter'] = $v_kelompok['nama_parameter'];
                    $input_filter = $this->value_parameter_laporan($v_kelompok['id_parameter'], $v_kelompok['melibatkan_tabel'], $v_kelompok['kolom_ditampilkan'], $v_kelompok['kondisi_tabel']);
                    $value_parameter = $input_filter;
                    $output['dataFilter'][$k_filter_box]['pilihan'][$k_kelompok]['kode_get'] =$v_kelompok['kode_parameter'];
                    $output['dataFilter'][$k_filter_box]['pilihan'][$k_kelompok]['type_filter'] =$v_kelompok['tipe'];
                    if ($v_kelompok['tipe']=='inputan') {
                        $output['dataFilter'][$k_filter_box]['pilihan'][$k_kelompok]['value'] = ''  ;
                    }else{
                        $output['dataFilter'][$k_filter_box]['pilihan'][$k_kelompok]['parameter'] = $value_parameter    ;

                    }
                }
            }
            // // ----------------------------------------------Untuk filter


               $grafik = $this->db->query("SELECT g.*, mi.nama_instansi from grafik g
            	left join master_instansi mi on g.id_instansi = mi.id_instansi
            	where g.kode_tahap='$tahap' and g.tahun ='$tahun' and g.bulan='$bulan'
            	")->row_array();
               $pagu_skpd = $grafik['pagu_total']=='' ? 0 : $grafik['pagu_total'];
               $realisasi_skpd = $grafik['rp_realisasi_keuangan']=='' ? 0 : $grafik['rp_realisasi_keuangan'];

               $output['informasi_umum']['skpd'] = nama_instansi($id_instansi);
               $output['informasi_umum']['keyword'] = $keyword;
               $output['informasi_umum']['logo'] = base_url().'assets/sbe/image/logo.png';
               $output['informasi_umum']['deskripsi'] = 'Laporan data '.$nama_tahapan[$tahap].' tahun '.$tahun.' '.ucwords(nama_instansi($id_instansi)).' ';
               $output['informasi_umum']['pagu'] = number_format($pagu_skpd);
               $output['informasi_umum']['realisasi'] = number_format($realisasi_skpd);
               $output['informasi_umum']['persen_realisasi_keuangan'] = $grafik['realisasi_keuangan']=='' ? 0 : $grafik['realisasi_keuangan'];
               $output['informasi_umum']['persen_realisasi_fisik'] = $grafik['realisasi_fisik']=='' ? 0 : $grafik['realisasi_fisik'];



            $program = $this->db->query("SELECT * from v_program_apbd where id_instansi='$id_instansi' and kode_tahap='$tahap' and tahun='$tahun'");
            foreach ($program->result_array() as $k_program => $v_program) {
            	$kode_program = $v_program['kode_rekening_program'];
            	$output['program'][$k_program]['kode_program'] = $kode_program;
            	$output['program'][$k_program]['nama_program'] = $v_program['nama_program'];
            	$output['program'][$k_program]['kegiatan'] = [];

	            $kegiatan = $this->db->query("SELECT * from v_kegiatan_apbd where id_instansi='$id_instansi' and kode_tahap='$tahap' and tahun='$tahun' and kode_rekening_program='$kode_program'");
	            foreach ($kegiatan->result_array() as $k_kegiatan => $v_kegiatan) {
	            	$kode_kegiatan = $v_kegiatan['kode_rekening_kegiatan'];
	            	$output['program'][$k_program]['kegiatan'][$k_kegiatan]['kode_kegiatan'] = $kode_kegiatan;
	            	$output['program'][$k_program]['kegiatan'][$k_kegiatan]['nama_kegiatan'] = $v_kegiatan['nama_kegiatan'];
	            	$output['program'][$k_program]['kegiatan'][$k_kegiatan]['sub_kegiatan'] = [];

	            $sub_kegiatan = $this->db->query("SELECT * from v_sub_kegiatan_apbd where id_instansi='$id_instansi' and kode_tahap='$tahap' and tahun='$tahun' and kode_rekening_kegiatan='$kode_kegiatan'");
		            foreach ($sub_kegiatan->result_array() as $k_sub_kegiatan => $v_sub_kegiatan) {
		            	$output['program'][$k_program]['kegiatan'][$k_kegiatan]['sub_kegiatan'][$k_sub_kegiatan]['kode_sub_kegiatan'] = $v_sub_kegiatan['kode_rekening_sub_kegiatan'];
		            	$output['program'][$k_program]['kegiatan'][$k_kegiatan]['sub_kegiatan'][$k_sub_kegiatan]['nama_sub_kegiatan'] = $v_sub_kegiatan['kategori'] =="Sub Kegiatan SKPD" ? $v_sub_kegiatan['nama_sub_kegiatan'] : $v_sub_kegiatan['nama_sub_kegiatan']." \n ".$v_sub_kegiatan['jenis_sub_kegiatan'].' - '.$v_sub_kegiatan['keterangan'];
                        $output['program'][$k_program]['kegiatan'][$k_kegiatan]['sub_kegiatan'][$k_sub_kegiatan]['link'] =  base_url().'sumbarsiap/detail_sub_kegiatan/'.$id_instansi.'/'.$tahun.'/'.$tahap.'/'.$v_sub_kegiatan['kode_rekening_sub_kegiatan'];
		            }
	            }

            }

			header('Content-Type: application/json');
			echo json_encode($output);
    }

    public function detail_sub_kegiatan($id_instansi, $tahun, $tahap, $kode_sub_kegiatan)
    {

        $fetch_method = $this->router->fetch_method();
        $id_menu = 1;
        $keyword = !$this->input->get('keyword') ? '' : $this->input->get('keyword'); 
        $bulan = !$this->input->get('bulan') ? bulan_aktif() : $this->input->get('bulan'); 

        $identitas = $this->db->get('identitas')->row_array();
        $nama_tahapan = [
                    '2'=>'APBD Awal',
                    '4'=>'APBD Perubahan',
                ];

            $output     = [

                'status' => "success", 
                'statusCode' => 200, 
                'message' => '', 
                'caption_title' => 'Detail Sub Kegiatan', 
                'informasi_umum'=>[],
                'dataFilter'=>[],
                'data_paket'=>[],
                'data_gis'=>[],
            ];
            


            $sumbarsiap       = $this->sumbarsiap_model;
            // ----------------------------------------------Untuk filter
            $q_filter_box = $this->db->query("SELECT * from sumbarsiap_filter_box where id_menu='$id_menu' and fetch_method='$fetch_method' and is_active='1'")->result_array();
            foreach ($q_filter_box as $k_filter_box => $v_filter_box) {
                $id_filter_box =$v_filter_box['id_filter_box'];
                $output['dataFilter'][$k_filter_box]['id_filter_box'] = $id_filter_box;
                $output['dataFilter'][$k_filter_box]['nama_filter_box'] = $v_filter_box['nama_filter_box'];
                $output['dataFilter'][$k_filter_box]['pindah_halaman'] = $v_filter_box['pindah_halaman'];
                $output['dataFilter'][$k_filter_box]['halaman_baru'] = $v_filter_box['halaman_baru'] =='' ? '' : base_url().'sumbarsiap/'.$v_filter_box['halaman_baru'];
                $filter = $this->db->query("SELECT * from sumbarsiap_kelompok_filter_menu skfm  
                left join sumbarsiap_filter_parameter sfp on skfm.id_parameter = sfp.id_parameter
                where skfm.id_filter_box='$id_filter_box'")->result_array();
                foreach ($filter as $k_kelompok => $v_kelompok) {
                    $output['dataFilter'][$k_filter_box]['pilihan'][$k_kelompok]['nama_filter'] = $v_kelompok['nama_parameter'];
                    $input_filter = $this->value_parameter_laporan($v_kelompok['id_parameter'], $v_kelompok['melibatkan_tabel'], $v_kelompok['kolom_ditampilkan'], $v_kelompok['kondisi_tabel']);
                    $value_parameter = $input_filter;
                    $output['dataFilter'][$k_filter_box]['pilihan'][$k_kelompok]['kode_get'] =$v_kelompok['kode_parameter'];
                    $output['dataFilter'][$k_filter_box]['pilihan'][$k_kelompok]['type_filter'] =$v_kelompok['tipe'];
                    if ($v_kelompok['tipe']=='inputan') {
                        $output['dataFilter'][$k_filter_box]['pilihan'][$k_kelompok]['value'] = ''  ;
                    }else{
                        $output['dataFilter'][$k_filter_box]['pilihan'][$k_kelompok]['parameter'] = $value_parameter    ;

                    }
                }
            }
            // // ----------------------------------------------Untuk filter

             $q_sub_kegiatan = $this->db->query("SELECT * from v_sub_kegiatan_apbd where kode_rekening_sub_kegiatan='$kode_sub_kegiatan' and kode_tahap='$tahap' and tahun='$tahun' and id_instansi='$id_instansi'")->row_array();
             $nama_sub_kegiatan = $q_sub_kegiatan['kategori']=='Unit Pelaksana' ? $q_sub_kegiatan['nama_sub_kegiatan']." \n".$q_sub_kegiatan['jenis_sub_kegiatan'].' - '.$q_sub_kegiatan['keterangan'] : $q_sub_kegiatan['nama_sub_kegiatan'] ; 



             
               $pagu_sub_kegiatan = $q_sub_kegiatan['pagu']=='' ? 0 : $q_sub_kegiatan['pagu'];
               $q_r_keu_ski = $sumbarsiap->realisasi_keuangan_sub_kegiatan($id_instansi, $tahun, $tahap, $kode_sub_kegiatan, $bulan)->row_array();
               $realisasi_sub_kegiatan = $q_r_keu_ski['total'];
               $persen_realisasi_keuangan = $pagu_sub_kegiatan ==0 ? 0 : ($realisasi_sub_kegiatan / $pagu_sub_kegiatan) * 100;//$grafik['rp_realisasi_keuangan']=='' ? 0 : $grafik['rp_realisasi_keuangan'];

               $output['informasi_umum']['logo'] = base_url().'assets/sbe/image/logo.png';
               $output['informasi_umum']['skpd'] = nama_instansi($id_instansi);
               $output['informasi_umum']['kode_rekening'] = $q_sub_kegiatan['kode_rekening_sub_kegiatan'];
               $output['informasi_umum']['nama_sub_kegiatan'] = $nama_sub_kegiatan;
               $output['informasi_umum']['pptk'] = $q_sub_kegiatan['pptk'];
               // $output['informasi_umum']['keyword'] = $keyword;
               $output['informasi_umum']['pagu'] = number_format($pagu_sub_kegiatan);
               $output['informasi_umum']['deskripsi'] = 'Laporan data realisasi sampai bulan '.bulan_global($bulan).' '.$tahun;//kegiatan '.$nama_sub_kegiatan.' '.$nama_tahapan[$tahap].' tahun '.$tahun.' '.ucwords(nama_instansi($id_instansi)).' ';
               $output['informasi_umum']['realisasi_fisik'] = $this->realisasi_fisik_sub_kegiatan($id_instansi, $tahun,  $tahap, $kode_sub_kegiatan, $bulan);
               $output['informasi_umum']['realisasi_keuangan'] = number_format($realisasi_sub_kegiatan);
               $output['informasi_umum']['persen_realisasi_keuangan'] = round($persen_realisasi_keuangan , 2);
              
               $q_paket = $sumbarsiap->paket_pekerjaan_sub_kegiatan($id_instansi, $tahun, $kode_sub_kegiatan);

               $kumpul_gis = [];
               foreach ($q_paket->result_array() as $k => $v) { 
                   $output['data_paket'][$k]['id_paket_pekerjaan'] = $v['id_paket_pekerjaan'];
                   $output['data_paket'][$k]['nama_paket'] = $v['nama_paket'];
                   $output['data_paket'][$k]['jenis_paket'] = $v['jenis_paket'];
                   $output['data_paket'][$k]['metode'] = $v['metode']=='' ? '-' : $v['metode'];
                   $output['data_paket'][$k]['pagu'] = number_format($v['pagu']);
                   $output['data_paket'][$k]['banyak_pelaksanaan'] = $v['volume'];
                   $output['data_paket'][$k]['galeri'] = $this->galeri_paket_pekerjaan($v['id_paket_pekerjaan'],$v['id_instansi'], $tahun);
                   $data_gis = [
                    'nama_paket'=>$v['nama_paket'],
                    'latitude'=>$v['latitude'],
                    'longitude'=>$v['longitude'],
                   ];
                   if ($v['latitude']!='') {
                       array_push($kumpul_gis, $data_gis);
                   }
               }
                   $output['data_gis'] = $kumpul_gis;



            header('Content-Type: application/json');
            echo json_encode($output);
    }


    
    public function realisasi_fisik_sub_kegiatan($id_instansi, $tahun,  $tahap, $kode_sub_kegiatan, $bulan){
            $ope = '<=';
           $total_paket = $this->realisasi_akumulasi_model->get_total_paket($id_instansi, $kode_sub_kegiatan, $tahun, $tahap)->num_rows();
          $jenis_rutin = $this->realisasi_akumulasi_model->get_total_paket_perjenis($id_instansi, $kode_sub_kegiatan, "RUTIN", $tahun, $tahap)->num_rows();
          $swa = $this->realisasi_akumulasi_model->get_realisasi_fisik($id_instansi, $kode_sub_kegiatan, $bulan, 'SWAKELOLA', $ope, $tahun, $tahap)->row_array();
          $pen = $this->realisasi_akumulasi_model->get_realisasi_fisik($id_instansi, $kode_sub_kegiatan, $bulan, 'PENYEDIA', $ope, $tahun, $tahap)->row_array();





          $bulan_mulai = mulai_realisasi_instansi($id_instansi);
          $bulan_akhir = akhir_realisasi_instansi($id_instansi);
          $lama_realisasi = $bulan_akhir - $bulan_mulai +1;

          $realisasi_rutin_bulan = [];
          $ke = 0;
          for ($i=$bulan_mulai; $i <= $bulan_akhir ; $i++) { 
            $ke++;
            $bulan_realisasi = $bulan_mulai + $i;



            $push = [
              $i=> round($ke / $lama_realisasi * 100, 2)
            ];
            array_push($realisasi_rutin_bulan, $push);
            
          }
          
              $selisih_bulan = $bulan - $bulan_mulai;
            if ($bulan<$bulan_mulai) {
                $realisasi_rutin = 0;
            }
            elseif ($bulan>$bulan_akhir) {
                $realisasi_rutin = 100;
            }else{
              $realisasi_rutin = $realisasi_rutin_bulan[$selisih_bulan][$bulan];
            }


          $rut = $jenis_rutin > 0 ? ($jenis_rutin * $realisasi_rutin) : 0;
      
          $swa_tot  = !empty($swa['total']) ? $swa['total'] : 0;
          $pen_tot  = !empty($pen['total']) ? $pen['total'] : 0;
          $rut_tot  = !empty($rut) ? $rut : 0;
         

          if ($total_paket != 0) {
            $total_fisik = ROUND(($swa_tot + $pen_tot + $rut_tot) / $total_paket,2);
          } else {
            $total_fisik = 0;
          }

          return $total_fisik ; 
    }
   

    public function galeri_paket_pekerjaan($id_paket_pekerjaan, $id_instansi, $tahun)
    {
           $primary_folder     = base_url().'sbe_files_data/';
                $directory          = [
                    $tahun,
                    $id_instansi,
                    'PROGRESS-PEKERJAAN',
                    $id_paket_pekerjaan,
                ];
                $list_directory = $this->sbe_directory($primary_folder, $directory);

            $kumpul_galeri = [];
            $q = $this->db->query("SELECT  keterangan, tgl_pengambilan, foto, persentasi 
             from progress_pekerjaan where 
             id_paket_pekerjaan='$id_paket_pekerjaan'")->result_array();
            foreach ($q as $k => $v) {
                $data =  [
                    'keterangan' =>$v['keterangan'],
                    'tgl_pengambilan' =>$v['tgl_pengambilan'],
                    'foto' =>$list_directory.$v['foto'],
                    'persentasi' =>$v['persentasi'],
                ];
                array_push($kumpul_galeri, $data);
            }
            return $kumpul_galeri;
        
    }
    public function cek_parameter_menu($id_menu, $id_parameter)
    {

            $q = $this->db->query("SELECT * from sumbarsiap_kelompok_filter_menu where 
             id_menu='$id_menu' and id_parameter='$id_parameter'")->num_rows();
            return $q;;
        
    }
    public function value_parameter_laporan($id_parameter, $tabel, $select, $where)
    {
    		if ($tabel=='') {
    			$data = $this->db->query("SELECT value, caption as label from sumbarsiap_value_filter_parameter where id_parameter='$id_parameter'")->result_array();
    			
    			// $this->db->query();
    		}
    		else if ($tabel=='bulan') {
    			$data = [];
    			$banyak = $select == '' ? 0 : $select;	
    			for ($i=1; $i <= $banyak ; $i++) { 
    				$tampung = [
    					'value'=>$i,
    					'label'=>bulan_global($i)
    				];
    				array_push($data, $tampung);
    			}
    			
    			// $this->db->query();
    		}else{
    			$data = [];
    			$q_kosong = $this->db->query("SELECT value, caption from sumbarsiap_value_filter_parameter where id_parameter='$id_parameter'")->result_array();
    			foreach ($q_kosong as $k => $v) {
    				$tampung = [
    					'value'=>$v['value'],
    					'label'=>$v['caption']
    				];

    				array_push($data, $tampung);
    			}
    			$select_data = $select =='' ? '*' : $select;
    			$q = $this->db->query("SELECT $select_data from $tabel $where")->result_array();
    			foreach ($q as $k => $v) {
    				$tampung = [
    					'value'=>$v['value'],
    					'label'=>$v['caption']
    				];

    				array_push($data, $tampung);
    			}
    		}

            return $data;
        
    }

    public function apbd_kab_kota()
    {

        $id_menu = 2;
        $fetch_method = $this->router->fetch_method();
            $output     = [

                'status' => "success", 
                'statusCode' => 200, 
                'message' => 'menampilkan data tentang ringkasan dana yang beredar di Kabupaten / Kota Provinsi Sumatera Barat', 
                'caption_title' => 'List Kab / Kota', 
                'informasi_umum'=>[],
                'dataFilter'=>[],

                'data_kab_kota'=>[],
            ];
                $output['informasi_umum']['catatan'] = 'untuk filter berdasarkan rangking belum diketahui. usahakan menggunakan sort pada array dan cari caranya';

                $tahun = !$this->input->get('tahun') ? tahun_anggaran() : $this->input->get('tahun'); 
                $tahap = !$this->input->get('kode_tahap') ? tahapan_apbd() : $this->input->get('kode_tahap'); 
                $bulan = !$this->input->get('bulan') ? bulan_aktif() : $this->input->get('bulan'); 
                  $ranking = !$this->input->get('rank') ? 'fisik_tertinggi' : $this->input->get('rank'); 
                  $kategori = !$this->input->get('kategori') ? 'akumulasi' : $this->input->get('kategori'); 

            
            
            $output['informasi_umum']['sumber_data'] = "????";
            // ----------------------------------------------Untuk filter
            $q_filter_box = $this->db->query("SELECT * from sumbarsiap_filter_box where id_menu='$id_menu' and fetch_method='$fetch_method' and is_active='1'")->result_array();
            foreach ($q_filter_box as $k_filter_box => $v_filter_box) {
                $id_filter_box =$v_filter_box['id_filter_box'];
                $output['dataFilter'][$k_filter_box]['id_filter_box'] = $id_filter_box;
                $output['dataFilter'][$k_filter_box]['nama_filter_box'] = $v_filter_box['nama_filter_box'];
                $output['dataFilter'][$k_filter_box]['pindah_halaman'] = $v_filter_box['pindah_halaman'];
                $output['dataFilter'][$k_filter_box]['halaman_baru'] = $v_filter_box['halaman_baru'] =='' ? '' : base_url().'sumbarsiap/'.$v_filter_box['halaman_baru'];
                $filter = $this->db->query("SELECT * from sumbarsiap_kelompok_filter_menu skfm  
                left join sumbarsiap_filter_parameter sfp on skfm.id_parameter = sfp.id_parameter
                where skfm.id_filter_box='$id_filter_box'")->result_array();
                foreach ($filter as $k_kelompok => $v_kelompok) {
                    $output['dataFilter'][$k_filter_box]['pilihan'][$k_kelompok]['nama_filter'] = $v_kelompok['nama_parameter'];
                    $input_filter = $this->value_parameter_laporan($v_kelompok['id_parameter'], $v_kelompok['melibatkan_tabel'], $v_kelompok['kolom_ditampilkan'], $v_kelompok['kondisi_tabel']);
                    $value_parameter = $input_filter;
                    $output['dataFilter'][$k_filter_box]['pilihan'][$k_kelompok]['kode_get'] =$v_kelompok['kode_parameter'];
                    $output['dataFilter'][$k_filter_box]['pilihan'][$k_kelompok]['type_filter'] =$v_kelompok['tipe'];
                    if ($v_kelompok['tipe']=='inputan') {
                        $output['dataFilter'][$k_filter_box]['pilihan'][$k_kelompok]['value'] = ''  ;
                    }else{
                        $output['dataFilter'][$k_filter_box]['pilihan'][$k_kelompok]['parameter'] = $value_parameter    ;

                    }
                }
            }
            // // ----------------------------------------------Untuk filter
                $nama_perengkingan = [
                    'fisik_tertinggi'=>'Realisasi Fisik Tertinggi',
                    'fisik_terendah'=>'Realisasi Fisik Terendah',
                    'keuangan_tertinggi'=>'Realisasi Keuangan Tertinggi',
                    'keuangan_terendah'=>'Realisasi Keuangan Terendah',
                ];
                $nama_tahapan = [
                    '2'=>'APBD Awal',
                    '4'=>'APBD Perubahan',
                ];
                $perhitungan = [
                    'akumulasi'=>'Sampai Bulan',
                    'per_bulan'=>'Bulan',
                ];


            $sumbarsiap       = $this->sumbarsiap_model;
            $kota = $sumbarsiap->kab_kota();
            foreach ($kota->result_array() as $k => $v) {
                $id_kota =$v['id_kota'] ;
                $pagu = $this->pagu_kab_kota($id_kota, $tahap, $tahun);
                $realisasi = $this->realisasi_kab_kota($id_kota, $tahap, $tahun);
                // @$realisasi_fisik = $this->grafik($id_kota, $tahap,  $tahun);
                $output['informasi_umum']['deskripsi'] = "Urutan SKPD berdasarkan ".$nama_perengkingan[$ranking]." ".$nama_tahapan[$tahap]." ".$perhitungan[$kategori]." ". bulan_global($bulan)." ".$tahun;
                $persen_realisasi = $pagu > 0 ? (($realisasi / $pagu) * 100) : 0 ;
                $output['data_kab_kota'][$k]['id_kota'] = $v['id_kota'];
                $output['data_kab_kota'][$k]['nama_kota'] = $v['nama_kota'];
                // $output['data_kab_kota'][$k]['wilayah'] = $v['wilayah'];
                $output['data_kab_kota'][$k]['logo'] = base_url().'assets/logo_kab_kota/'.$v['logo'];
                
                
                // $output['data_kab_kota'][$k]['data_replikasi'] = $v['url_replikasi'].'/sumbarsiap/apbd_provinsi?kode_tahap='.$tahap.'&tahun='.$tahun;
                $output['data_kab_kota'][$k]['sumber_data_sumbar_siap'] = $v['sumber_data_sumbar_siap'];

                if ($v['replikasi']=='Online') {
                    $link_pagu_kab_kota_replikasi = $v['url_replikasi'].'/sumbarsiap/pagu_kab_kota_replikasi/'.$tahap.'/'.$tahun;
                    $link_realisasi_kab_kota_replikasi = $v['url_replikasi'].'/sumbarsiap/realisasi_kab_kota_replikasi/'.$tahap.'/'.$tahun.'/'.$bulan;

                    $pagu_kab_kota_replikasi = file_get_contents($link_pagu_kab_kota_replikasi, true);
                    $pagu_kab_kota_replikasi = $pagu_kab_kota_replikasi == "" ? 0 : $pagu_kab_kota_replikasi;
                    $realisasi_kab_kota_replikasi = file_get_contents($link_realisasi_kab_kota_replikasi, true);
                    $realisasi_kab_kota_replikasi = $realisasi_kab_kota_replikasi == "" ? 0 : $realisasi_kab_kota_replikasi;
                    $persen_rk = $pagu_kab_kota_replikasi > 0 ? ($realisasi_kab_kota_replikasi / $pagu_kab_kota_replikasi) * 100 : 0;
                    if ($v['sumber_data_sumbar_siap']=="Replikasi") {
                        $output['data_kab_kota'][$k]['tanda_replikasi'] = base_url().'/assets/sbe/image/sudah_replikasi_dan_inplementasi.png';
                        $output['data_kab_kota'][$k]['url_replikasi'] = $v['url_replikasi'];
                        $output['data_kab_kota'][$k]['pagu'] = number_format($pagu_kab_kota_replikasi);
                        $output['data_kab_kota'][$k]['realisasi_keuangan'] = number_format($realisasi_kab_kota_replikasi);
                        $output['data_kab_kota'][$k]['persen_realisasi_keuangan'] = round($persen_rk,2);
                        $output['data_kab_kota'][$k]['persen_realisasi_fisik'] = '??';
                        # code...
                    }else{
                        $output['data_kab_kota'][$k]['tanda_replikasi'] = base_url().'/assets/sbe/image/sudah_replikasi.png';
                        $output['data_kab_kota'][$k]['url_replikasi'] = '';
                         $output['data_kab_kota'][$k]['pagu'] = number_format($pagu) ;
                        $output['data_kab_kota'][$k]['realisasi_keuangan'] = number_format($realisasi) ;
                        $output['data_kab_kota'][$k]['persen_realisasi_keuangan'] = round($persen_realisasi,2) ;
                        $output['data_kab_kota'][$k]['persen_realisasi_fisik'] = '??';
                    }
                }else{
                        $output['data_kab_kota'][$k]['tanda_replikasi'] = '';
                        $output['data_kab_kota'][$k]['url_replikasi'] = '';
                    $output['data_kab_kota'][$k]['pagu'] = number_format($pagu) ;
                    $output['data_kab_kota'][$k]['realisasi_keuangan'] = number_format($realisasi) ;
                    $output['data_kab_kota'][$k]['persen_realisasi_keuangan'] = round($persen_realisasi,2) ;
                    $output['data_kab_kota'][$k]['persen_realisasi_fisik'] = '??';

                }
              
              
            }

            header('Content-Type: application/json');
            echo json_encode($output);
        // }
    }

    public function detail_kab_kota($id_kota)
    {
        $output['informasi_umum']['sumber_data'] = "????";
        $tahun = !$this->input->get('tahun') ? tahun_anggaran() : $this->input->get('tahun'); 
        $tahap = !$this->input->get('kode_tahap') ? tahapan_apbd() : $this->input->get('kode_tahap'); 
        $bulan = !$this->input->get('bulan') ? bulan_aktif() : $this->input->get('bulan'); 

        $ranking = !$this->input->get('rank') ? 'fisik_tertinggi' : $this->input->get('rank'); 
        $nama_perengkingan = [
            'fisik_tertinggi'=>'Realisasi Fisik Tertinggi',
            'fisik_terendah'=>'Realisasi Fisik Terendah',
            'keuangan_tertinggi'=>'Realisasi Keuangan Tertinggi',
            'keuangan_terendah'=>'Realisasi Keuangan Terendah',
        ];
        $sumbarsiap       = $this->sumbarsiap_model;
        $id_menu = 2;
        $fetch_method = $this->router->fetch_method();
            $output     = [

                'status' => "success", 
                'statusCode' => 200, 
                'message' => 'menampilkan data tentang ringkasan dana yang beredar di Kabupaten / Kota Provinsi Sumatera Barat', 
                'caption_title' => 'List Kab / Kota', 
                'informasi_umum'=>[],
                'dataFilter'=>[],

                'data_skpd_kab_kota'=>[],
            ];

                $q_kota = $sumbarsiap->detail_kab_kota($id_kota)->row_array();
                $output['informasi_umum']['logo'] = base_url().'assets/logo_kab_kota/'.$q_kota['logo'];
                $output['informasi_umum']['nama_kab_kota'] = nama_kota($id_kota);
                $output['informasi_umum']['deskripsi'] = 'urutan SKPD berdasarkan '.$nama_perengkingan[$ranking]."\n".''.' '.pilihan_nama_tahapan($tahap).' Tahun '.$tahun;
                $output['informasi_umum']['sumber_data'] = 'SBE';
                $output['informasi_umum']['catatan'] = 'untuk filter berdasarkan rangking belum diketahui. usahakan menggunakan sort pada array dan cari caranya';

            
            // ----------------------------------------------Untuk filter
            $q_filter_box = $this->db->query("SELECT * from sumbarsiap_filter_box where id_menu='$id_menu' and fetch_method='$fetch_method' and is_active='1'")->result_array();
            foreach ($q_filter_box as $k_filter_box => $v_filter_box) {
                $id_filter_box =$v_filter_box['id_filter_box'];
                $output['dataFilter'][$k_filter_box]['id_filter_box'] = $id_filter_box;
                $output['dataFilter'][$k_filter_box]['nama_filter_box'] = $v_filter_box['nama_filter_box'];
                $output['dataFilter'][$k_filter_box]['pindah_halaman'] = $v_filter_box['pindah_halaman'];
                $output['dataFilter'][$k_filter_box]['halaman_baru'] = $v_filter_box['halaman_baru'] =='' ? '' : base_url().'sumbarsiap/'.$v_filter_box['halaman_baru'];
                $filter = $this->db->query("SELECT * from sumbarsiap_kelompok_filter_menu skfm  
                left join sumbarsiap_filter_parameter sfp on skfm.id_parameter = sfp.id_parameter
                where skfm.id_filter_box='$id_filter_box'")->result_array();
                foreach ($filter as $k_kelompok => $v_kelompok) {
                    $output['dataFilter'][$k_filter_box]['pilihan'][$k_kelompok]['nama_filter'] = $v_kelompok['nama_parameter'];
                    $input_filter = $this->value_parameter_laporan($v_kelompok['id_parameter'], $v_kelompok['melibatkan_tabel'], $v_kelompok['kolom_ditampilkan'], $v_kelompok['kondisi_tabel']);
                    $value_parameter = $input_filter;
                    $output['dataFilter'][$k_filter_box]['pilihan'][$k_kelompok]['kode_get'] =$v_kelompok['kode_parameter'];
                    $output['dataFilter'][$k_filter_box]['pilihan'][$k_kelompok]['type_filter'] =$v_kelompok['tipe'];
                    if ($v_kelompok['tipe']=='inputan') {
                        $output['dataFilter'][$k_filter_box]['pilihan'][$k_kelompok]['value'] = ''  ;
                    }else{
                        $output['dataFilter'][$k_filter_box]['pilihan'][$k_kelompok]['parameter'] = $value_parameter    ;

                    }
                }
            }
            // // ----------------------------------------------Untuk filter
             

            $skpd = $sumbarsiap->skpd_kab_kota($id_kota);
            foreach ($skpd->result_array() as $k => $v) {
                $id_instansi =$v['id_instansi'] ;
    
                $output['data_skpd_kab_kota'][$k]['id_instansi'] = $v['id_instansi'];
                $output['data_skpd_kab_kota'][$k]['nama_instansi'] = $v['nama_instansi'];
              
                    $pagu = $sumbarsiap->pagu_skpd_kab_kota($id_instansi, $tahun, $tahap)->row_array()['total_pagu'];
                    $realisasi = $sumbarsiap->realisasi_skpd_kab_kota($id_instansi, $tahun, $tahap, $bulan)->row_array();
                    $persen_realisasi = $pagu > 0 ? (($realisasi['total_realisasi'] / $pagu) * 100) : 0 ;

                    $output['data_skpd_kab_kota'][$k]['pagu'] = number_format($pagu) ;
                    $output['data_skpd_kab_kota'][$k]['realisasi_keuangan'] = number_format($realisasi['total_realisasi']) ;
                    $output['data_skpd_kab_kota'][$k]['realisasi_keuangan'] = round($persen_realisasi,2) ;
                    $output['data_skpd_kab_kota'][$k]['persen_realisasi_fisik'] = $realisasi['realisasi_fisik'];

                
              
              
            }

            header('Content-Type: application/json');
            echo json_encode($output);
        // }
    }


    public function detail_skpd_kab_kota($id_instansi)
    {
        $output['informasi_umum']['sumber_data'] = $this->sumber_data_kab_kota;
        $tahun = !$this->input->get('tahun') ? tahun_anggaran() : $this->input->get('tahun'); 
        $tahap = !$this->input->get('kode_tahap') ? tahapan_apbd() : $this->input->get('kode_tahap'); 
        $bulan = !$this->input->get('bulan') ? bulan_aktif() : $this->input->get('bulan'); 

        $ranking = !$this->input->get('rank') ? 'fisik_tertinggi' : $this->input->get('rank'); 
        $nama_perengkingan = [
            'fisik_tertinggi'=>'Realisasi Fisik Tertinggi',
            'fisik_terendah'=>'Realisasi Fisik Terendah',
            'keuangan_tertinggi'=>'Realisasi Keuangan Tertinggi',
            'keuangan_terendah'=>'Realisasi Keuangan Terendah',
        ];
        $sumbarsiap       = $this->sumbarsiap_model;
        $id_menu = 2;
        $fetch_method = $this->router->fetch_method();
            $output     = [

                'status' => "success", 
                'statusCode' => 200, 
                'message' => 'menampilkan data tentang ringkasan dana yang beredar di Kabupaten / Kota Provinsi Sumatera Barat', 
                'caption_title' => 'List Kab / Kota', 
                'informasi_umum'=>[],
                'dataFilter'=>[],

                'galeri_skpd_kab_kota'=>[],
            ];

                $q_kota = $sumbarsiap->detail_skpd_kab_kota($id_instansi)->row_array();
                $id_kota = $q_kota['id_kota'];
                $output['informasi_umum']['logo'] = base_url().'assets/logo_kab_kota/'.$q_kota['logo'];
                $output['informasi_umum']['nama_kab_kota'] = nama_kota($id_kota);
                $output['informasi_umum']['deskripsi'] = 'Data Laporan '.pilihan_nama_tahapan($tahap).' Tahun '.$tahun."\n".$q_kota['nama_instansi'];

                $pagu = $sumbarsiap->pagu_skpd_kab_kota($id_instansi, $tahun, $tahap)->row_array()['total_pagu'];
                    $realisasi = $sumbarsiap->realisasi_skpd_kab_kota($id_instansi, $tahun, $tahap, $bulan)->row_array();
                    $persen_realisasi = $pagu > 0 ? (($realisasi['total_realisasi'] / $pagu) * 100) : 0 ;
                    $output['informasi_umum']['pagu'] = number_format($pagu) ;
                    $output['informasi_umum']['realisasi_keuangan'] = number_format($realisasi['total_realisasi']) ;
                    $output['informasi_umum']['realisasi_keuangan'] = round($persen_realisasi,2) ;
                    $output['informasi_umum']['persen_realisasi_fisik'] = $realisasi['realisasi_fisik'];




                $output['informasi_umum']['sumber_data'] = 'SBE';

            
            // ----------------------------------------------Untuk filter
            $q_filter_box = $this->db->query("SELECT * from sumbarsiap_filter_box where id_menu='$id_menu' and fetch_method='$fetch_method' and is_active='1'")->result_array();
            foreach ($q_filter_box as $k_filter_box => $v_filter_box) {
                $id_filter_box =$v_filter_box['id_filter_box'];
                $output['dataFilter'][$k_filter_box]['id_filter_box'] = $id_filter_box;
                $output['dataFilter'][$k_filter_box]['nama_filter_box'] = $v_filter_box['nama_filter_box'];
                $output['dataFilter'][$k_filter_box]['pindah_halaman'] = $v_filter_box['pindah_halaman'];
                $output['dataFilter'][$k_filter_box]['halaman_baru'] = $v_filter_box['halaman_baru'] =='' ? '' : base_url().'sumbarsiap/'.$v_filter_box['halaman_baru'];
                $filter = $this->db->query("SELECT * from sumbarsiap_kelompok_filter_menu skfm  
                left join sumbarsiap_filter_parameter sfp on skfm.id_parameter = sfp.id_parameter
                where skfm.id_filter_box='$id_filter_box'")->result_array();
                foreach ($filter as $k_kelompok => $v_kelompok) {
                    $output['dataFilter'][$k_filter_box]['pilihan'][$k_kelompok]['nama_filter'] = $v_kelompok['nama_parameter'];
                    $input_filter = $this->value_parameter_laporan($v_kelompok['id_parameter'], $v_kelompok['melibatkan_tabel'], $v_kelompok['kolom_ditampilkan'], $v_kelompok['kondisi_tabel']);
                    $value_parameter = $input_filter;
                    $output['dataFilter'][$k_filter_box]['pilihan'][$k_kelompok]['kode_get'] =$v_kelompok['kode_parameter'];
                    $output['dataFilter'][$k_filter_box]['pilihan'][$k_kelompok]['type_filter'] =$v_kelompok['tipe'];
                    if ($v_kelompok['tipe']=='inputan') {
                        $output['dataFilter'][$k_filter_box]['pilihan'][$k_kelompok]['value'] = ''  ;
                    }else{
                        $output['dataFilter'][$k_filter_box]['pilihan'][$k_kelompok]['parameter'] = $value_parameter    ;

                    }
                }
            }
            // // ----------------------------------------------Untuk filter
             

            // $skpd = $sumbarsiap->skpd_kab_kota($id_kota);
            // foreach ($skpd->result_array() as $k => $v) {
            //     $id_instansi =$v['id_instansi'] ;
    
            //     $output['data_skpd_kab_kota'][$k]['id_instansi'] = $v['id_instansi'];
            //     $output['data_skpd_kab_kota'][$k]['nama_instansi'] = $v['nama_instansi'];
              
            //         $pagu = $sumbarsiap->pagu_skpd_kab_kota($id_instansi, $tahun, $tahap)->row_array()['total_pagu'];
            //         $realisasi = $sumbarsiap->realisasi_skpd_kab_kota($id_instansi, $tahun, $tahap, $bulan)->row_array();
            //         $persen_realisasi = $pagu > 0 ? (($realisasi['total_realisasi'] / $pagu) * 100) : 0 ;

            //         $output['data_skpd_kab_kota'][$k]['pagu'] = number_format($pagu) ;
            //         $output['data_skpd_kab_kota'][$k]['realisasi_keuangan'] = number_format($realisasi['total_realisasi']) ;
            //         $output['data_skpd_kab_kota'][$k]['realisasi_keuangan'] = round($persen_realisasi,2) ;
            //         $output['data_skpd_kab_kota'][$k]['persen_realisasi_fisik'] = $realisasi['realisasi_fisik'];

                
              
              
            // }

            header('Content-Type: application/json');
            echo json_encode($output);
        // }
    }




    public function pagu_skpd($id_instansi, $tahap, $tahun)
    {
            $output     = [
                'status' => false, 
                'message' => '', 
                'data'=>[]
            ];

           
            $sumbarsiap       = $this->sumbarsiap_model;
            $q = $sumbarsiap->pagu_skpd($id_instansi, $tahap, $tahun)->row_array();
            return $q;
            
        // }
    }
    public function pagu_kab_kota_replikasi($tahap, $tahun)
    {
            $output     = [
                'status' => false, 
                'message' => '', 
                'data'=>[]
            ];

           
            $sumbarsiap       = $this->sumbarsiap_model;
            $q = $sumbarsiap->pagu_kab_kota_replikasi($tahap, $tahun)->row_array();
            echo $q['total_pagu'];
            
        // }
    }

    public function pagu_kab_kota($id_kota, $tahap, $tahun)
    {
            $output     = [
                'status' => false, 
                'message' => '', 
                'data'=>[]
            ];

           
            $sumbarsiap       = $this->sumbarsiap_model;
            $q = $sumbarsiap->pagu_kab_kota($id_kota, $tahap, $tahun)->row_array();
            return $q['total_pagu'];
            
        // }
    }
    public function realisasi_skpd($id_instansi, $tahap, $tahun, $bulan, $kategori)
    {
            $output     = [
                'status' => false, 
                'message' => '', 
                'data'=>[]
            ];

           
            $sumbarsiap       = $this->sumbarsiap_model;
            $q = $sumbarsiap->realisasi_skpd($id_instansi, $tahap, $tahun, $bulan, $kategori)->row_array();
            return $q;
            
    }
    public function realisasi_kab_kota($id_kota, $tahap, $tahun)
    {
            $output     = [
                'status' => false, 
                'message' => '', 
                'data'=>[]
            ];

           
            $sumbarsiap       = $this->sumbarsiap_model;
            $q = $sumbarsiap->realisasi_kab_kota($id_kota, $tahap, $tahun)->row_array();
            return $q['total_realisasi'];
            
    }


    public function realisasi_kab_kota_replikasi($tahap, $tahun, $bulan)
    {
            $output     = [
                'status' => false, 
                'message' => '', 
                'data'=>[]
            ];

           
            $sumbarsiap       = $this->sumbarsiap_model;
            $q = $sumbarsiap->realisasi_kab_kota_replikasi($tahap, $tahun, $bulan)->row_array();
            echo $q['total_realisasi'];
            
    }

    public function grafik($id_instansi, $tahap, $tahun)
    {
            $output     = [
                'status' => false, 
                'message' => '', 
                'data'=>[]
            ];

           
            $sumbarsiap       = $this->sumbarsiap_model;
            $target_realisasi_model       = $this->target_realisasi_model;
            $q = $target_realisasi_model->grafik($id_instansi, $tahap, $tahun)->result_array();
            $grafik_bulan = [];
            foreach ($q as $k => $v) {
                $grafik_bulan[$v['bulan']] = $v['realisasi_fisik'];
            }

            $bulan = $tahun==date('Y') ? date('n') : 12;
            return $grafik_bulan;
    }

    public function gis($id_instansi, $tahap, $tahun)
    {
            $output     = [
                'status' => false, 
                'message' => '', 
                'data'=>[]
            ];

           
            $sumbarsiap       = $this->sumbarsiap_model;
            $target_realisasi_model       = $this->target_realisasi_model;
            $q = $sumbarsiap->gis($id_instansi, $tahap, $tahun);
            $data = [
                'count'=>  $q->num_rows(),
                'data' => $q->result_array()
            ];
           
            // header('Content-Type: application/json');
            // echo json_encode($data);
            return $data;
    }
    public function api_data_gis($id_instansi, $tahap, $tahun)
    {       $output     = [
                'status' => false, 
                'message' => '', 
                'data'=>[
                    'skpd'=>nama_instansi($id_instansi),
                    'filter'=>'',
                    'gis' =>[]
                ]
            ];

           
            $sumbarsiap       = $this->sumbarsiap_model;
            $target_realisasi_model       = $this->target_realisasi_model;
            $q = $sumbarsiap->gis($id_instansi, $tahap, $tahun);
            foreach ($q->result_array() as $k => $v) {
                $output['data']['gis'][$k]['nama_paket'] = $v['nama_paket'] ;
                $output['data']['gis'][$k]['ìd_paket'] = $v['id_paket_pekerjaan'] ;
                $output['data']['gis'][$k]['latitude'] = $v['latitude'] ;
                $output['data']['gis'][$k]['longitude'] = $v['longitude'] ;
                $output['data']['gis'][$k]['sub_kegiatan'] = '???' ;
                $output['data']['gis'][$k]['pptk'] = $v['nama_paket'] ;
                $output['data']['gis'][$k]['nilai_kontrak'] = $v['nilai_kontrak'] ;
                $output['data']['gis'][$k]['pelaksana'] = $v['pelaksana'] ;
            }
           
            header('Content-Type: application/json');
            echo json_encode($output);
            // return $data;
    }


    public function realisasi_fisik($id_instansi, $tahap,  $tahun)
    {
        $realisasi_fisik = [];
        $total_fisik_bulan = [];

        // $kegiatan = $this->target_realisasi_model->get_kode_rekening_kegiatan($id_instansi);
        $kegiatan = $this->target_realisasi_model->all_kegiatan($id_instansi, $tahap, $tahun);
      
        $no = 1;
        $tampung_kegiatan_berpagu = [];
        foreach ($kegiatan as $key => $value) {
                if ($value->pagu >0) {
                    $satu = 1;
                }else{
                    $satu = 0;
                }

                array_push($tampung_kegiatan_berpagu, $satu);


            $total_paket    = $this->target_realisasi_model->total_paket($id_instansi, $value->kode_rekening_sub_kegiatan, $tahun)->num_rows();
            $jenis_swakelola    = $this->target_realisasi_model->total_paket_perjenis($id_instansi, $value->kode_rekening_sub_kegiatan, 'SWAKELOLA' , $tahun)->num_rows();
            $jenis_penyedia    = $this->target_realisasi_model->total_paket_perjenis($id_instansi, $value->kode_rekening_sub_kegiatan, 'PENYEDIA' , $tahun)->num_rows();
            $jenis_rutin    = $this->target_realisasi_model->total_paket_perjenis($id_instansi, $value->kode_rekening_sub_kegiatan, 'RUTIN' , $tahun)->num_rows();
     
           
 
                // echo "<pre>".print_r($swakelola)."</pre>";
            for ($i = 1; $i <= 12; $i++) {

                $swakelola      = $this->target_realisasi_model->persentase($value->kode_rekening_sub_kegiatan, 'SWAKELOLA', $i, $tahun)->num_rows() == '' ? 0 : $this->target_realisasi_model->persentase($value->kode_rekening_sub_kegiatan, 'SWAKELOLA', $i, $tahun)->row()->total;
                $penyedia       = $this->target_realisasi_model->persentase($value->kode_rekening_sub_kegiatan, 'PENYEDIA', $i, $tahun)->num_rows() == '' ? 0 : $this->target_realisasi_model->persentase($value->kode_rekening_sub_kegiatan, 'PENYEDIA', $i, $tahun)->row()->total;


                //  if ($value->pagu > 0 ) {
                //     $rutin          = $jenis_rutin == '' ? 0 : ($jenis_rutin   * $this->rutin($i, $id_instansi)) ;
                // }else{
                //     $rutin          = 0;//$jenis_rutin == '' ? 0 : ($jenis_rutin   * $this->rutin($i, $id_instansi)) ;
                // }
                    $rutin          = $jenis_rutin == '' ? 0 : ($jenis_rutin   * $this->rutin($i, $id_instansi)) ;
                    

             

                $total_fisik_perkegiatan = ($swakelola + $penyedia + $rutin); 
                @$ratarata_fisik = $total_fisik_perkegiatan / $total_paket;
                




                if ($swakelola + $penyedia + $rutin == 0) {
                    $total_fisik = 0;
                } else {
                    if ($total_paket==0) {
                        $total_fisik = 0;
                    }else{
                       $total_fisik = ROUND(($swakelola + $penyedia + $rutin) / $total_paket, 2);
                    }
                }
                $total_fisik  = ROUND($total_fisik, 2) > 100 ? 100 : ROUND($total_fisik, 2);

                $total_fisik_bulan[$i][] = $total_fisik;
            }
        }



        if (empty($total_fisik_bulan)) :
            $fisik_array[] = 0;
        else :
            for ($i = 1; $i <= 12; $i++) {
                $fisik_array[] = ROUND(array_sum($total_fisik_bulan[$i]) / count($tampung_kegiatan_berpagu), 2);
            }
        endif;


        $realisasi_fisik[] = (!empty($fisik_array[0]) and $fisik_array[0] > 0) ? $fisik_array[0] : 0;
        $realisasi_fisik[] = (!empty($fisik_array[1]) and $fisik_array[1] > 0) ? $fisik_array[1] : 0;
        $realisasi_fisik[] = (!empty($fisik_array[2]) and $fisik_array[2] > 0) ? $fisik_array[2] : 0;
        $realisasi_fisik[] = (!empty($fisik_array[3]) and $fisik_array[3] > 0) ? $fisik_array[3] : 0;
        $realisasi_fisik[] = (!empty($fisik_array[4]) and $fisik_array[4] > 0) ? $fisik_array[4] : 0;
        $realisasi_fisik[] = (!empty($fisik_array[5]) and $fisik_array[5] > 0) ? $fisik_array[5] : 0;
        $realisasi_fisik[] = (!empty($fisik_array[6]) and $fisik_array[6] > 0) ? $fisik_array[6] : 0;
        $realisasi_fisik[] = (!empty($fisik_array[7]) and $fisik_array[7] > 0) ? $fisik_array[7] : 0;
        $realisasi_fisik[] = (!empty($fisik_array[8]) and $fisik_array[8] > 0) ? $fisik_array[8] : 0;
        $realisasi_fisik[] = (!empty($fisik_array[9]) and $fisik_array[9] > 0) ? $fisik_array[9] : 0;
        $realisasi_fisik[] = (!empty($fisik_array[10]) and $fisik_array[10] > 0) ? $fisik_array[10] : 0;
        $realisasi_fisik[] = (!empty($fisik_array[11]) and $fisik_array[11] > 0) ? $fisik_array[11] : 0;
         return $realisasi_fisik;
         // echo $realisasi_fisik[6];

    }


    public function rutin($bulan, $id_instansi)
    {
          $bulan_mulai = mulai_realisasi_instansi($id_instansi);
          $bulan_akhir = akhir_realisasi_instansi($id_instansi);
          $lama_realisasi = $bulan_akhir - $bulan_mulai +1;

          $realisasi_rutin_bulan = [];
          $ke = 0;
          for ($i=$bulan_mulai; $i <= $bulan_akhir ; $i++) { 
            $ke++;
            $bulan_realisasi = $bulan_mulai + $i;



            $push = [
              $i=> round($ke / $lama_realisasi * 100, 2)
            ];
            array_push($realisasi_rutin_bulan, $push);
            
          }
          
              $selisih_bulan = $bulan - $bulan_mulai;
            if ($bulan<$bulan_mulai) {
                $realisasi_rutin = 0;
            }
            elseif ($bulan>$bulan_akhir) {
                $realisasi_rutin = 100;
            }else{
              $realisasi_rutin = $realisasi_rutin_bulan[$selisih_bulan][$bulan];
            }




        return $realisasi_rutin;
    }
}
