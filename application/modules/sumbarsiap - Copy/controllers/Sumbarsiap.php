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
        if (identitas() != true) {
            redirect('setup', 'refresh');
        }
        $this->load->model('android/android_model', 'android_model');

        $this->load->model([
   //          'model_versi' => 'mversi',
   //          'dashboard/dashboard_model'       => 'dashboard_model',
           
			// 'realisasi/realisasi_fisik_keuangan_model'    => 'realisasi_fisik_keuangan_model',
			// 'Laporan/realisasi_akumulasi_model'		=> 'realisasi_akumulasi_model',
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

public function pilih_tahun()
    {
            $output     = [
                'status' => false, 
                'message' => '', 
                'data'=>[]
            ];
            $sumbarsiap       = $this->sumbarsiap_model;
            $q = $sumbarsiap->config();
            foreach ($q->result_array() as $k => $v) {
                $output['data'][$k]['key'] = $v['tahun_anggaran'];
                $output['data'][$k]['value'] = $v['tahun_anggaran'];
            }
            header('Content-Type: application/json');
            echo json_encode($output);
    }
public function pilih_tahap()
    {
            $output     = [
                'status' => false, 
                'message' => '', 
                'data'=>[]
            ];
            $sumbarsiap       = $this->sumbarsiap_model;
            $q = [2=>'APBD Awal',4=>'APBD Perubahan'];
            foreach ($q as $k => $v) {
                $output['data'][$k]['key'] = $k;
                $output['data'][$k]['value'] = $v;
            }
            header('Content-Type: application/json');
            echo json_encode($output);
    }
public function pilih_jenis_belanja()
    {
            $output     = [
                'status' => false, 
                'message' => '', 
                'data'=>[]
            ];
            $sumbarsiap       = $this->sumbarsiap_model;
               $q = [
                    'bo'=>'Belanja Operasi',
                    'bm'=>'Belanja Modal',
                    'btt'=>'Belanja Tidak Terduga',
                    'bt'=>'Belanja Transfer',
                    'semua'=>'Semua Jenis Belanja',
                ];
            foreach ($q as $k => $v) {
                $output['data'][$k]['key'] = $k;
                $output['data'][$k]['value'] = $v;
            }
            header('Content-Type: application/json');
            echo json_encode($output);
    }
public function pilih_kategori()
    {
            $output     = [
                'status' => false, 
                'message' => '', 
                'data'=>[]
            ];
            $sumbarsiap       = $this->sumbarsiap_model;
               $q = [
                    'akumulasi'=>'Akumulasi',
                    'per_bulan'=>'Perbulan',
                   
                ];
            foreach ($q as $k => $v) {
                $output['data'][$k]['key'] = $k;
                $output['data'][$k]['value'] = $v;
            }
            header('Content-Type: application/json');
            echo json_encode($output);
    }
public function pilih_bulan()
    {
            $output     = [
                'status' => false, 
                'message' => '', 
                'data'=>[]
            ];
            $sumbarsiap       = $this->sumbarsiap_model;
            $q = [2=>'APBD Awal',4=>'APBD Perubahan'];
            for ($i=1; $i <=12 ; $i++) { 
                 $output['data'][$i]['key'] = $i;
                $output['data'][$i]['value'] = bulan_global($i);
            }
            
            header('Content-Type: application/json');
            echo json_encode($output);
    }
    public function menu()
    {
            $output     = [
                'status' => false, 
                'message' => '', 
                'data'=>[]
            ];

            if (!$this->input->get('tahun') && !$this->input->get('tahap')) {
                $tahun = tahun_anggaran(); 
                $tahap = tahapan_apbd();
            }else{

                $tahun = $this->input->get('tahun'); 
                $tahap = $this->input->get('kode_tahap');
            }
            $sumbarsiap       = $this->sumbarsiap_model;
            $menu = $sumbarsiap->menu()->result_array();
            foreach ($menu as $k => $v) {
                $query_pagu = $v['query_pagu'];
                $query_realisasi = $v['query_realisasi'];
                $sql_pagu = $this->db->query($query_pagu." where kode_tahap='$tahap' and tahun='$tahun'")->row_array();
                $sql_realisasi = $this->db->query($query_realisasi." where kode_tahap='$tahap' and tahun='$tahun'")->row_array();
                $pagu_total = $sql_pagu['pagu'];
                $realisasi_total = $sql_realisasi['realisasi'];
                if ($pagu_total==0) {
                    # code...
                    $persen_realisasi = 0;
                }else{
                    $persen_realisasi = ($realisasi_total/ $pagu_total) * 100;

                }
                $output['data'][$k]['id_menu'] = $v['id_menu'];
                $output['data'][$k]['nama_menu'] = $v['nama_menu'];
                $output['data'][$k]['keterangan'] = $v['keterangan'];
                $output['data'][$k]['gambar'] = $v['gambar_menu'];
                $output['data'][$k]['pagu_total'] = number_format($pagu_total);
                $output['data'][$k]['realisasi_total'] = number_format($realisasi_total);
                $output['data'][$k]['persen_realisasi'] = round($persen_realisasi,2 ).'%';
                $output['data'][$k]['module'] = $v['module'];
            }

            header('Content-Type: application/json');
            echo json_encode($output);
        // }
    }
    public function apbd_provinsi()
    {
            $output     = [
                'status' => false, 
                'message' => '', 
                'data'=>[]
            ];

            if (!$this->input->get('tahun') && !$this->input->get('tahap') && !$this->input->get('bulan') && !$this->input->get('kategori')) {
                $tahun = tahun_anggaran(); 
                $tahap = tahapan_apbd();
                $bulan = date('n');
                $kategori = 'akumulasi';
            }else{

                $tahun = $this->input->get('tahun'); 
                $bulan = $this->input->get('bulan'); 
                $tahap = $this->input->get('kode_tahap');
                $kategori = $this->input->get('kategori');
            }

            $sumbarsiap       = $this->sumbarsiap_model;

                $menu = $sumbarsiap->skpd();
                $nama_caption_filter = [
                    'bo'=>'Belanja Operasi',
                    'bm'=>'Belanja Modal',
                    'btt'=>'Belanja Tidak Terduga',
                    'bt'=>'Belanja Transfer',
                    'semua'=>'Semua Jenis Belanja',
                ];
            foreach ($menu->result_array() as $k => $v) {

                $id_instansi =$v['id_instansi'] ;
                $pagu = $this->pagu_skpd($id_instansi, $tahap, $tahun);
                $realisasi = $this->realisasi_skpd($id_instansi, $tahap, $tahun, $bulan, $kategori);
                if (!$this->input->get('filter')) {
                  $pagu_jenis_belanja = $pagu['total_pagu'];
                  $realisasi_jenis_belanja = $realisasi['total_realisasi'];
                  $caption_filter = "";
                  $cek = "0";
                    $filter = "";
                }else{
                    $filter = $this->input->get('filter');
                  $pagu_jenis_belanja = $filter=='semua' ? $pagu['total_pagu'] : $pagu['total_pagu_'.$filter];
                  $realisasi_jenis_belanja = $filter=='semua' ? $realisasi['total_realisasi'] : $realisasi['total_realisasi_'.$filter];
                  $caption_filter = $nama_caption_filter[$filter];
                  $cek = "1";

                }
                $gis = $this->gis($id_instansi, $tahap, $tahun);
                // $realisasi_fisik = $this->realisasi_fisik($id_instansi, $tahap,  $tahun);
                @$realisasi_fisik = $this->grafik($id_instansi, $tahap,  $tahun);

                $persen_realisasi_total = $pagu_jenis_belanja > 0 ? (($realisasi['total_realisasi'] / $pagu['total_pagu']) * 100) : 0 ;
                $persen_realisasi_jenis_belanja = $pagu_jenis_belanja > 0 ? (($realisasi_jenis_belanja / $pagu_jenis_belanja) * 100) : 0 ;
                $output['data'][$k]['id_instansi'] = $v['id_instansi'];
                $output['data'][$k]['nama_instansi'] = $v['nama_instansi'];
                $output['data'][$k]['pagu_total'] = number_format($pagu['total_pagu']) ;
                $output['data'][$k]['realisasi_keuangan_total'] = number_format($realisasi['total_realisasi']) ;
                $output['data'][$k]['persen_realisasi_keuangan'] = round($persen_realisasi_total,2) ;
                $output['data'][$k]['realisasi_keuangan_jenis_belanja'] = number_format($realisasi_jenis_belanja) ;
                $output['data'][$k]['filter'] = $filter;
                $output['data'][$k]['nama_jenis_belanja'] = $caption_filter;
                $output['data'][$k]['pagu_jenis_belanja'] = number_format($pagu_jenis_belanja) ;
                $output['data'][$k]['persen_realisasi_keuangan_jenis_belanja'] = round($persen_realisasi_jenis_belanja,2) ;
                $output['data'][$k]['realisasi_fisik'] = count($realisasi_fisik) > 0 ? $realisasi_fisik[$bulan] : '0.00' ;
                $output['data'][$k]['gis'] = $gis['count'];
                $output['data'][$k]['api_data_gis'] = $gis['count'] > 0 ? base_url().'sumbarsiap/api_data_gis/'.$id_instansi.'/'.$tahap.'/'.$tahun : '';
              
            }

            header('Content-Type: application/json');
            echo json_encode($output);
        // }
    }

    public function apbd_kab_kota()
    {
            $output     = [
                'status' => false, 
                'message' => '', 
                'data'=>[]
            ];

            if (!$this->input->get('tahun') && !$this->input->get('tahap')) {
                $tahun = tahun_anggaran(); 
                $tahap = tahapan_apbd();
            }else{

                $tahun = $this->input->get('tahun'); 
                $tahap = $this->input->get('kode_tahap');
            }
            $sumbarsiap       = $this->sumbarsiap_model;
            $menu = $sumbarsiap->kab_kota();
            foreach ($menu->result_array() as $k => $v) {
                $id_kota =$v['id_kota'] ;
                $pagu = $this->pagu_kab_kota($id_kota, $tahap, $tahun);
                $realisasi = $this->realisasi_kab_kota($id_kota, $tahap, $tahun);
                // @$realisasi_fisik = $this->grafik($id_kota, $tahap,  $tahun);

                $persen_realisasi = $pagu > 0 ? (($realisasi / $pagu) * 100) : 0 ;
                $output['data'][$k]['id_kota'] = $v['id_kota'];
                $output['data'][$k]['nama_kota'] = $v['nama_kota'];
                $output['data'][$k]['wilayah'] = $v['wilayah'];
                $output['data'][$k]['logo'] = base_url().'assets/logo_kab_kota/'.$v['logo'];
                $output['data'][$k]['replikasi'] = $v['replikasi'];
                $output['data'][$k]['url_replikasi'] = $v['url_replikasi'];
                $output['data'][$k]['data_replikasi'] = $v['url_replikasi'].'/sumbarsiap/apbd_provinsi?kode_tahap='.$tahap.'&tahun='.$tahun;
                $output['data'][$k]['sumber_data_sumbar_siap'] = $v['sumber_data_sumbar_siap'];

                if ($v['replikasi']=='Online') {
                    $link_pagu_kab_kota_replikasi = $v['url_replikasi'].'/sumbarsiap/pagu_kab_kota_replikasi/'.$tahap.'/'.$tahun;
                    $link_realisasi_kab_kota_replikasi = $v['url_replikasi'].'/sumbarsiap/realisasi_kab_kota_replikasi/'.$tahap.'/'.$tahun;

                    $pagu_kab_kota_replikasi = file_get_contents($link_pagu_kab_kota_replikasi, true);
                    $pagu_kab_kota_replikasi = $pagu_kab_kota_replikasi == "" ? 0 : $pagu_kab_kota_replikasi;
                    $realisasi_kab_kota_replikasi = file_get_contents($link_realisasi_kab_kota_replikasi, true);
                    $realisasi_kab_kota_replikasi = $realisasi_kab_kota_replikasi == "" ? 0 : $realisasi_kab_kota_replikasi;
                    $persen_rk = $pagu_kab_kota_replikasi > 0 ? ($realisasi_kab_kota_replikasi / $pagu_kab_kota_replikasi) * 100 : 0;
                    if ($v['sumber_data_sumbar_siap']=="Replikasi") {
                        $output['data'][$k]['pagu'] = number_format($pagu_kab_kota_replikasi);
                        $output['data'][$k]['realisasi_keuangan'] = number_format($realisasi_kab_kota_replikasi);
                        $output['data'][$k]['persen_realisasi'] = round($persen_rk,2);
                        # code...
                    }else{
                         $output['data'][$k]['pagu'] = number_format($pagu) ;
                        $output['data'][$k]['realisasi_keuangan'] = number_format($realisasi) ;
                        $output['data'][$k]['persen_realisasi'] = round($persen_realisasi,2) ;
                    }
                }else{
                    $output['data'][$k]['pagu'] = number_format($pagu) ;
                    $output['data'][$k]['realisasi_keuangan'] = number_format($realisasi) ;
                    $output['data'][$k]['persen_realisasi'] = round($persen_realisasi,2) ;

                }
              
              
            }

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


    public function realisasi_kab_kota_replikasi($tahap, $tahun)
    {
            $output     = [
                'status' => false, 
                'message' => '', 
                'data'=>[]
            ];

           
            $sumbarsiap       = $this->sumbarsiap_model;
            $q = $sumbarsiap->realisasi_kab_kota_replikasi($tahap, $tahun)->row_array();
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
