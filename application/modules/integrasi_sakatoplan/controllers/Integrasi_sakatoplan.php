<?php

/**
 * androidor     : Alfikri, M.Kom
 * Created By : Alfikri, M.Kom
 * E-Mail     : alfikri.name@gmail.com
 * No HP      : 081277337405
 * Class      : android.php
 */
defined('BASEPATH') or exit('No direct script access allowed');

class Integrasi_sakatoplan extends MY_Controller
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
            'integrasi_sakatoplan/integrasi_sakatoplan_model'      => 'integrasi_sakatoplan_model',
            
        ]);
    }

    public function index()
    {
        // if (empty($this->session->userdata('email'))) {
        //     $data['title']        = "Login";
        //     $page                 = 'android/android';
        //     $data['extra_css']    = $this->load->view('android/css', $data, true);
        //     $data['extra_js']    = $this->load->view('android/js', $data, true);
        //     $this->template->load('android_template', $page, $data);
        // } else {
        //     redirect('dashboard');
        // }
    }


    public function laporan_skpd(){
        error_reporting(0);
        $id_skpd = $this->input->get('id_skpd');
        $tahun = $this->input->get('tahun');
        $tahap = $this->input->get('tahap');
        $kategori = "Perbulan";
        $id_instansi = $id_skpd ; 
        $ope = '=';
        // $bulan = 4;

       $sub_kegiatan = $this->integrasi_sakatoplan_model->get_sub_kegiatan_skpd($id_instansi, $tahun, $tahap, $kategori);

       $kumpul_sub_kegiatan = [];
       foreach ($sub_kegiatan->result_array() as $k_sk => $value_sk) {
         $kategori_sub_kegiatan = $value_sk['kategori'];
          if($kategori_sub_kegiatan =='Unit Pelaksana'){
            $nama_sub_kegiatan = $value_sk['nama_sub_kegiatan']." | [".$value_sk['jenis_sub_kegiatan'].' - '.$value_sk['keterangan']."]";
           
          }else{
            $nama_sub_kegiatan = $value_sk['nama_sub_kegiatan'];
          }


        $kumpul_keuangan = [];
        for ($i=1; $i <=12 ; $i++) { 
            $bulan = $i;
          


          $target = $this->realisasi_akumulasi_model->get_target($id_instansi, $value_sk['kode_rekening_sub_kegiatan'], $bulan, $tahap)->row_array();
          $realisasi_keuangan = $this->realisasi_akumulasi_model->get_realisasi_keuangan($id_instansi, $value_sk['kode_rekening_sub_kegiatan'], $bulan, $ope, $tahun, $tahap)->row_array();

          

          if ($value_sk['pagu'] == 0) {
            $persen_target_keuangan   = 0;
            $persen_realisasi_keuangan  = 0;
            $target_keuangan = 0;
            $rp_realisasi_keuangan =0;
        } else {
                if ($ope=='=') {
                    $target_fisik = $target['target_fisik_bulanan'];
                    $target_keuangan = $target['target_keuangan_bulanan'];
                    $nilai_persen_target_keuangan = ($target['target_keuangan_bulanan'] / $value_sk['pagu']) * 100 ; 
                    
                }else{
                    $target_keuangan = $target['target_keuangan'];
                    $target_fisik = $target['target_fisik'];
                    $nilai_persen_target_keuangan = ($target['target_keuangan'] / $value_sk['pagu']) * 100 ; 
                }
            $persen_target_keuangan = $nilai_persen_target_keuangan; 
            $persen_realisasi_keuangan  = ($realisasi_keuangan['total_realisasi'] / $value_sk['pagu'] ) * 100;
            $rp_realisasi_keuangan =$realisasi_keuangan['total_realisasi'];

          }

        $persen_deviasi = ($persen_realisasi_keuangan  - $persen_target_keuangan);


        $data_keuangan = [
            'bulan'=>$bulan,
            'nama_bulan'=>bulan_global($bulan),
            'target'=>$target_keuangan,
            'persen_target'=>$persen_target_keuangan ,
            'realisasi'=> $rp_realisasi_keuangan,
            'persen_realisasi'=> $persen_realisasi_keuangan,
            'deviasi'=> ($realisasi_keuangan['total_realisasi'] - $value_sk['pagu']) ,
            'persen_deviasi'=> $persen_deviasi ,
        ];
        array_push($kumpul_keuangan, $data_keuangan);
        }






          $data_ski = [
            'kode_sub_kegiatan'=>$value_sk['kode_rekening_sub_kegiatan'],
            'nama_sub_kegiatan'=>$nama_sub_kegiatan ,
            'pagu_sub_kegiatan'=>$value_sk['pagu'],
            'realisasi_keuangan' => $kumpul_keuangan 
          ];
          array_push($kumpul_sub_kegiatan, $data_ski);
       }
        $data = [
            'nama_instansi'=>nama_instansi($id_instansi),
            'tahun'=>$tahun,
            'kode_tahap'=>$tahap,
            'tahapan_apbd'=>pilihan_nama_tahapan($tahap),
            'sub_kegiatan'=>$kumpul_sub_kegiatan,
        ];

        header('Content-Type: application/json');
        echo json_encode($data);
    }
}
