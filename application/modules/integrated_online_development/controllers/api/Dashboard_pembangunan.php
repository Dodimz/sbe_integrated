<?php

/**
 * androidor     : Alfikri, M.Kom
 * Created By : Alfikri, M.Kom
 * E-Mail     : alfikri.name@gmail.com
 * No HP      : 081277337405
 * Class      : android.php
 */
defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard_pembangunan extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->sumber_data = "Sumber Data : ???";
        $this->sumber_data_kab_kota = "???";
        $this->load->model('android/android_model', 'android_model');


            header("Access-Control-Allow-Origin: *");
            header("Access-Control-Allow-Headers: *");

        $this->load->model([

            'Laporan/realisasi_akumulasi_model'     => 'realisasi_akumulasi_model',
            'integrated/Integrasi_dashboard_pembangunan_model'       => 'dashboard_pembangunan_model',
        ]);
    }

    public function index()
    {
        
        $dashboard_pembangunan    = $this->dashboard_pembangunan_model;
        $tahun = tahun_anggaran();
        $tahap = tahapan_apbd();
        $bulan = bulan_aktif();
         $q_total = $dashboard_pembangunan->total_dashboard($tahun, $tahap, $bulan)->row_array();

        $pagu_total = $q_total['total_pagu'];

        if ($pagu_total==0) {
          
            $persen_target_keuangan_total =0;
            $persen_target_keuangan_bulanan_total =0;

            $persen_realisasi_keuangan =0;
            $total_target_keuangan =0;
            $total_target_keuangan_bulanan =0;
            $total_realisasi_keuangan =0;
            $total_realisasi_keuangan_bulanan =0;

            $target_fisik_akumulasi =0;
            $target_fisik_bulanan =0;
            $realisasi_fisik_akumulasi =0;
            $realisasi_fisik_bulanan =0;


        }else{
          $persen_target_keuangan_total = ($q_total['total_target_keuangan'] / $q_total['total_pagu']) * 100; 
          $persen_target_keuangan_bulanan_total = ($q_total['total_target_keuangan_bulanan'] / $q_total['total_pagu']) * 100; 

          $persen_realisasi_keuangan = ($q_total['total_realisasi_keuangan'] / $q_total['total_pagu']) * 100; 
          $total_target_keuangan =  $q_total['total_target_keuangan'];
          $total_target_keuangan_bulanan =  $q_total['total_target_keuangan_bulanan'];
          $total_realisasi_keuangan =  $q_total['total_realisasi_keuangan'];
          $total_realisasi_keuangan_bulanan =  $q_total['total_realisasi_keuangan_bulanan'];

          $target_fisik_akumulasi = $q_total['target_fisik'] / $q_total['banyak_opd'];
          $target_fisik_bulanan = $q_total['target_fisik_bulanan'] / $q_total['banyak_opd'];
          $realisasi_fisik_akumulasi = $q_total['realisasi_fisik'] / $q_total['banyak_opd'];
          $realisasi_fisik_bulanan = $q_total['realisasi_fisik_bulanan'] / $q_total['banyak_opd'];

        }



        // $pencapaian_opd = [
        //     'pagu'=>$pagu_total,
        //     'rp_target_keuangan'=>$total_target_keuangan,
        //     'persen_target_keuangan'=>round($persen_target_keuangan_total,2),
        //     'rp_realisasi_keuangan'=>$total_realisasi_keuangan,
        //     'persen_realisasi_keuangan'=>round($persen_realisasi_keuangan_total,2),

        //     'target_fisik_akumulasi'=>round($target_fisik_akumulasi,2),
        //     'realisasi_fisik_akumulasi'=>round($realisasi_fisik_akumulasi,2),
        //     // 'deviasi_fisik_akumulasi'=>0,

        //     'target_fisik_bulanan'=>$target_fisik_bulanan,
        //     'target_keuangan_bulanan'=>$total_target_keuangan_bulanan,
        //     'persen_target_keuangan_bulanan'=>$total_realisasi_keuangan_bulanan,
        //     // 'target_fisik_bulanan'=>$v['target_fisik_bulanan'],
        //     // 'realisasi_fisik_bulanan '=>$v['realisasi_fisik_bulanan'],
        //     // 'deviasi_fisik_bulanan'=>round($deviasi_fisik_akumulasi,2),

        //     // 'url'=> base_url().'integrated/api/dashboard_pembangunan/detail_data_opd_pengelompokan/'.$v['id_instansi'].'/'.$v['tahun'].'/'.$v['kode_tahap'].'/'.$v['bulan'].'/',
        // ];

        $output = [
             'status'=>'success',
            'message'=>'',
            'data'=> [
                // 'pagu_total'=>$q_total['total_pagu'],
                'rp_target_keuangan_total'=>$total_target_keuangan,
                'rp_realisasi_keuangan_total'=>$total_realisasi_keuangan,
                // 'persen_target_keuangan_total'=>round($persen_target_keuangan_total,2),
                // 'persen_realisasi_keuangan_total'=>round($persen_realisasi_keuangan_total,2),
                'persen_realisasi'=>round($persen_realisasi_keuangan,2),
            
            ]
        ];

            header('Content-Type: application/json');
        echo json_encode($output);

    }
    public function data_opd()
    {
        
        $dashboard_pembangunan    = $this->dashboard_pembangunan_model;
        $tahun = tahun_anggaran();
        $tahap = tahapan_apbd();
        $bulan = bulan_aktif();
        $q = $dashboard_pembangunan->laporan_opd($tahun, $tahap, $bulan);

        $data_opd = [];
        foreach ($q->result_array() as $k => $v) {
            $persen_target_keuangan = ($v['rp_target_keuangan_akumulasi'] / $v['pagu_total']) * 100; 
            $persen_realisasi_keuangan = ($v['rp_realisasi_keuangan_akumulasi'] / $v['pagu_total']) * 100; 


            $deviasi_fisik_akumulasi = $v['realisasi_fisik_akumulasi'] - $v['target_fisik_akumulasi'] ;
            $deviasi_fisik_bulanan = $v['realisasi_fisik_bulanan'] - $v['target_fisik_bulanan'] ;
            $data_push = [
                'skpd'=>$v['nama_instansi'],
                'pagu'=>$v['pagu_total'],
                'rp_target_keuangan'=>$v['rp_target_keuangan_akumulasi'],
                'persen_target_keuangan'=>round($persen_target_keuangan,2),
                'rp_realisasi_keuangan'=>$v['rp_realisasi_keuangan_akumulasi'],
                'persen_realisasi_keuangan'=>round($persen_realisasi_keuangan,2),

                'target_fisik_akumulasi'=>$v['target_fisik_akumulasi'],
                'realisasi_fisik_akumulasi'=>$v['realisasi_fisik_akumulasi'],
                'deviasi_fisik_akumulasi'=>round($deviasi_fisik_akumulasi,2),

                // 'target_fisik_bulanan'=>$v['target_fisik_bulanan'],
                // 'realisasi_fisik_bulanan '=>$v['realisasi_fisik_bulanan'],
                // 'deviasi_fisik_bulanan'=>round($deviasi_fisik_akumulasi,2),

                'detail'=> [
                	'url' =>base_url().'integrated/api/dashboard_pembangunan/detail_data_opd_pengelompokan/',
                	'id_instansi'=> $v['id_instansi'] , 
                	'id_satker'=> $v['integrasi_sipedal_id_instansi'] , 
                	'tahun'=> $v['tahun'] , 
                	'kode_tahap'=> $v['kode_tahap'] , 
                	'bulan'=> $v['bulan'] , 
                ]
            ];
            array_push($data_opd,$data_push);
        }





     

        $q_total = $dashboard_pembangunan->total_dashboard($tahun, $tahap, $bulan)->row_array();

        $pagu_total = $q_total['total_pagu'];

        if ($pagu_total==0) {
          
            $persen_target_keuangan_total =0;
            $persen_target_keuangan_bulanan_total =0;

            $persen_realisasi_keuangan_total =0;
            $persen_realisasi =0;
            $total_target_keuangan =0;
            $total_target_keuangan_bulanan =0;
            $total_realisasi_keuangan =0;
            $total_realisasi_keuangan_bulanan =0;

            $target_fisik_akumulasi =0;
            $target_fisik_bulanan =0;
            $realisasi_fisik_akumulasi =0;
            $realisasi_fisik_bulanan =0;


        }else{
          $persen_target_keuangan_total = ($q_total['total_target_keuangan'] / $q_total['total_pagu']) * 100; 
          $persen_target_keuangan_bulanan_total = ($q_total['total_target_keuangan_bulanan'] / $q_total['total_pagu']) * 100; 

          $persen_realisasi_keuangan_total = ($q_total['total_realisasi_keuangan'] / $q_total['total_pagu']) * 100; 
          $persen_realisasi = ($q_total['total_realisasi_keuangan'] / $q_total['total_pagu']) * 100; 
          $total_target_keuangan =  $q_total['total_target_keuangan'];
          $total_target_keuangan_bulanan =  $q_total['total_target_keuangan_bulanan'];
          $total_realisasi_keuangan =  $q_total['total_realisasi_keuangan'];
          $total_realisasi_keuangan_bulanan =  $q_total['total_realisasi_keuangan_bulanan'];

          $target_fisik_akumulasi = $q_total['target_fisik'] / $q_total['banyak_opd'];
          $target_fisik_bulanan = $q_total['target_fisik_bulanan'] / $q_total['banyak_opd'];
          $realisasi_fisik_akumulasi = $q_total['realisasi_fisik'] / $q_total['banyak_opd'];
          $realisasi_fisik_bulanan = $q_total['realisasi_fisik_bulanan'] / $q_total['banyak_opd'];

        }



        $pencapaian_opd = [
            'pagu'=>$pagu_total,
            'rp_target_keuangan'=>$total_target_keuangan,
            'persen_target_keuangan'=>round($persen_target_keuangan_total,2),
            'rp_realisasi_keuangan'=>$total_realisasi_keuangan,
            'persen_realisasi_keuangan'=>round($persen_realisasi_keuangan_total,2),

            'target_fisik_akumulasi'=>round($target_fisik_akumulasi,2),
            'realisasi_fisik_akumulasi'=>round($realisasi_fisik_akumulasi,2),
            // 'deviasi_fisik_akumulasi'=>0,

            'target_fisik_bulanan'=>round($target_fisik_bulanan,2),
            'target_keuangan_bulanan'=>$total_target_keuangan_bulanan,
            'persen_target_keuangan_bulanan'=>round($persen_target_keuangan_bulanan_total,2),
            // 'target_fisik_bulanan'=>$v['target_fisik_bulanan'],
            // 'realisasi_fisik_bulanan '=>$v['realisasi_fisik_bulanan'],
            // 'deviasi_fisik_bulanan'=>round($deviasi_fisik_akumulasi,2),

            // 'url'=> base_url().'integrated/api/dashboard_pembangunan/detail_data_opd_pengelompokan/'.$v['id_instansi'].'/'.$v['tahun'].'/'.$v['kode_tahap'].'/'.$v['bulan'].'/',
        ];


        $output = [
            'status'=>'',
            'message'=>'',
            'bulan'=> $bulan,
            'pencapaian_opd'=> $pencapaian_opd,
            'data'=> $data_opd
        ];

            header('Content-Type: application/json');
        echo json_encode($output);

    }
    public function detail_data_opd($id_instansi, $tahun, $tahap, $bulan)
    {
        
        $dashboard_pembangunan    = $this->dashboard_pembangunan_model;
        $q = $dashboard_pembangunan->laporan_sub_kegiatan_opd_gabungan($id_instansi, $tahun, $tahap, $bulan);
        $q_pencapaian_opd = $dashboard_pembangunan->laporan_opd($tahun, $tahap, $bulan, $id_instansi)->row_array();


		$persen_target_keuangan = ($q_pencapaian_opd['rp_target_keuangan_akumulasi'] / $q_pencapaian_opd['pagu_total']) * 100; 
		$persen_target_keuangan_bulanan = ($q_pencapaian_opd['rp_target_keuangan_bulanan'] / $q_pencapaian_opd['pagu_total']) * 100; 
		$persen_realisasi_keuangan = ($q_pencapaian_opd['rp_realisasi_keuangan_akumulasi'] / $q_pencapaian_opd['pagu_total']) * 100; 


		$deviasi_fisik_akumulasi = $q_pencapaian_opd['realisasi_fisik_akumulasi'] - $q_pencapaian_opd['target_fisik_akumulasi'] ;
		$deviasi_fisik_bulanan = $q_pencapaian_opd['realisasi_fisik_bulanan'] - $q_pencapaian_opd['target_fisik_bulanan'] ;
		$pencapaian_opd = [
			'skpd'=>$q_pencapaian_opd['nama_instansi'],
			'pagu'=>$q_pencapaian_opd['pagu_total'],
			'rp_target_keuangan'=>$q_pencapaian_opd['rp_target_keuangan_akumulasi'],
			'persen_target_keuangan'=>round($persen_target_keuangan,2),
			'rp_realisasi_keuangan'=>$q_pencapaian_opd['rp_realisasi_keuangan_akumulasi'],
			'persen_realisasi_keuangan'=>round($persen_realisasi_keuangan,2),

			'target_fisik_akumulasi'=>$q_pencapaian_opd['target_fisik_akumulasi'],
			'realisasi_fisik_akumulasi'=>$q_pencapaian_opd['realisasi_fisik_akumulasi'],
			'deviasi_fisik_akumulasi'=>round($deviasi_fisik_akumulasi,2),

			'target_fisik_bulanan'=>$q_pencapaian_opd['target_fisik_bulanan'],
			'target_keuangan_bulanan'=>$q_pencapaian_opd['rp_target_keuangan_bulanan'],
			'persen_target_keuangan_bulanan'=>$persen_target_keuangan_bulanan,
			// 'target_fisik_bulanan'=>$v['target_fisik_bulanan'],
			// 'realisasi_fisik_bulanan '=>$v['realisasi_fisik_bulanan'],
			// 'deviasi_fisik_bulanan'=>round($deviasi_fisik_akumulasi,2),

			// 'url'=> base_url().'integrated/api/dashboard_pembangunan/detail_data_opd_pengelompokan/'.$v['id_instansi'].'/'.$v['tahun'].'/'.$v['kode_tahap'].'/'.$v['bulan'].'/',
		];





        $data_opd = [];
        foreach ($q->result_array() as $k => $v) {
            // $deviasi_fisik_bulanan = $v['realisasi_fisik_bulanan'] - $v['target_fisik_bulanan'];


            $fisik_persen_target = $v['target_fisik_akumulasi'] =='' ? 0 : $v['target_fisik_akumulasi'];
            $fisik_persen_realisasi = $v['realisasi_fisik_akumulasi'] =='' ? 0 : $v['realisasi_fisik_akumulasi'];
            $deviasi_fisik_akumulasi = $v['realisasi_fisik_akumulasi'] - $v['target_fisik_akumulasi'];

            $rp_target_keuangan_akumulasi = $v['rp_target_keuangan_akumulasi'] =='' ? 0 : $v['rp_target_keuangan_akumulasi'];
            $persen_target_keuangan_akumulasi = $v['target_keuangan_akumulasi'] =='' ? 0 : $v['target_keuangan_akumulasi'];
            $rp_realisasi_keuangan_akumulasi = $v['rp_realisasi_keuangan_akumulasi'] =='' ? 0 : $v['rp_realisasi_keuangan_akumulasi'];
            $persen_realisasi_keuangan_akumulasi = $v['realisasi_keuangan_akumulasi'] =='' ? 0 : $v['realisasi_keuangan_akumulasi'];
            $deviasi_keuangan_akumulasi = $v['realisasi_keuangan_akumulasi'] - $v['target_keuangan_akumulasi'];


            $data_push = [
                   'nama_sub_kegiatan'=>$v['nama_sub_kegiatan'],
                        'pptk'=>$v['nama_sub_kegiatan'],
                        'pagu'=>$v['pagu_total'],
                        'persen_target_fisik'=>round($fisik_persen_target,2),
                        'persen_realisasi_fisik'=>round($fisik_persen_realisasi,2),
                        'deviasi_fisik'=>round($deviasi_fisik_akumulasi,2),

                        'rp_target_keuangan'=>$rp_target_keuangan_akumulasi,
                        'rp_realisasi_keuangan'=>$rp_realisasi_keuangan_akumulasi,
                        'persen_target_keuangan'=>round($persen_target_keuangan_akumulasi,2),
                        'persen_realisasi_keuangan'=>round($persen_realisasi_keuangan_akumulasi,2),
                        'deviasi_keuangan'=>round($deviasi_keuangan_akumulasi,2),
                // 'url'=> base_url().'integrated/api/dashboard_pembangunan/detail_data_opd/'.$v['id_instansi'].'/'.$v['tahun'].'/'.$v['kode_tahap'].'/'.$v['bulan'].'/',
            ];
            array_push($data_opd,$data_push);
        }





        $output = [
            'status'=>'',
            'message'=>'',
            'bulan'=>$bulan,
            'pencapaian_opd'=>$pencapaian_opd,
            'data'=> $data_opd,
        ];

            header('Content-Type: application/json');
        echo json_encode($output);

    }



    // public function detail_data_opd_pengelompokan($id_instansi, $tahun, $tahap, $bulan)
    public function detail_data_opd_pengelompokan()
    {
		$id_instansi = $this->input->get('id_instansi');
		$tahun = $this->input->get('tahun');
		$tahap = $this->input->get('tahap');
		$bulan = $this->input->get('bulan');
        $dashboard_pembangunan    = $this->dashboard_pembangunan_model;



        $q_pencapaian_opd = $dashboard_pembangunan->laporan_opd($tahun, $tahap, $bulan, $id_instansi)->row_array();


		$persen_target_keuangan = ($q_pencapaian_opd['rp_target_keuangan_akumulasi'] / $q_pencapaian_opd['pagu_total']) * 100; 
		$persen_target_keuangan_bulanan = ($q_pencapaian_opd['rp_target_keuangan_bulanan'] / $q_pencapaian_opd['pagu_total']) * 100; 
		$persen_realisasi_keuangan = ($q_pencapaian_opd['rp_realisasi_keuangan_akumulasi'] / $q_pencapaian_opd['pagu_total']) * 100; 


		$deviasi_fisik_akumulasi = $q_pencapaian_opd['realisasi_fisik_akumulasi'] - $q_pencapaian_opd['target_fisik_akumulasi'] ;
		$deviasi_fisik_bulanan = $q_pencapaian_opd['realisasi_fisik_bulanan'] - $q_pencapaian_opd['target_fisik_bulanan'] ;
		$pencapaian_opd = [
			'skpd'=>$q_pencapaian_opd['nama_instansi'],
			'pagu'=>$q_pencapaian_opd['pagu_total'],
			'rp_target_keuangan'=>$q_pencapaian_opd['rp_target_keuangan_akumulasi'],
			'persen_target_keuangan'=>round($persen_target_keuangan,2),
			'rp_realisasi_keuangan'=>$q_pencapaian_opd['rp_realisasi_keuangan_akumulasi'],
			'persen_realisasi_keuangan'=>round($persen_realisasi_keuangan,2),

			'target_fisik_akumulasi'=>$q_pencapaian_opd['target_fisik_akumulasi'],
			'realisasi_fisik_akumulasi'=>$q_pencapaian_opd['realisasi_fisik_akumulasi'],
			'deviasi_fisik_akumulasi'=>round($deviasi_fisik_akumulasi,2),

			'target_fisik_bulanan'=>$q_pencapaian_opd['target_fisik_bulanan'],
			'target_keuangan_bulanan'=>$q_pencapaian_opd['rp_target_keuangan_bulanan'],
			'persen_target_keuangan_bulanan'=>$persen_target_keuangan_bulanan,
			// 'target_fisik_bulanan'=>$v['target_fisik_bulanan'],
			// 'realisasi_fisik_bulanan '=>$v['realisasi_fisik_bulanan'],
			// 'deviasi_fisik_bulanan'=>round($deviasi_fisik_akumulasi,2),

			// 'url'=> base_url().'integrated/api/dashboard_pembangunan/detail_data_opd_pengelompokan/'.$v['id_instansi'].'/'.$v['tahun'].'/'.$v['kode_tahap'].'/'.$v['bulan'].'/',
		];





        $q_program = $dashboard_pembangunan->laporan_program_opd($id_instansi, $tahun, $tahap, $bulan);
      


        $data_opd = [];


        $kumpul_program = [];
        foreach ($q_program->result_array() as $k_program => $v_program) {

            $kode_program = $v_program['kode_program'];
            $q_kegiatan = $dashboard_pembangunan->laporan_kegiatan_opd($id_instansi, $tahun, $tahap, $bulan, $kode_program)->result_array();
            $kumpul_kegiatan = [];


            $total_pagu_program = 0;
            $persen_target_fisik_program = 0;
            $persen_realisasi_fisik_program = 0;
            $totalkegiatan_rp_target_keuangan_akumulasi = 0;
            $totalkegiatan_rp_realisasi_keuangan_akumulasi = 0;


            foreach ($q_kegiatan as $k_kegiatan => $v_kegiatan) {
                $kode_kegiatan = $v_kegiatan['kode_kegiatan'];
                $q_sub_kegiatan = $dashboard_pembangunan->laporan_sub_kegiatan_opd($id_instansi, $tahun, $tahap, $bulan, $kode_kegiatan)->result_array();
                $kumpul_sub_kegiatan = [];



                $total_sub_kegiatan_persen_target_fisik_akumulasi = 0;
                $total_sub_kegiatan_persen_realisasi_fisik_akumulasi = 0;
                $total_sub_kegiatan_rp_target_keuangan_akumulasi = 0;
                $total_sub_kegiatan_rp_realisasi_keuangan_akumulasi = 0;
                $total_pagu_kegiatan= 0;

                foreach ($q_sub_kegiatan as $k_sk => $value_sk) {

                    $deviasi_fisik = $value_sk['realisasi_fisik_akumulasi'] - $value_sk['target_fisik_akumulasi'] ; 
                    $deviasi_keuangan = $value_sk['realisasi_keuangan_akumulasi'] - $value_sk['target_keuangan_akumulasi'] ; 



                    $persen_target_fisik_akumulasi = $value_sk['target_fisik_akumulasi'] == '' ? 0 : $value_sk['target_fisik_akumulasi'];
                    $persen_realisasi_fisik_akumulasi = $value_sk['realisasi_fisik_akumulasi'] == '' ? 0 : $value_sk['realisasi_fisik_akumulasi'];
                    $rp_target_keuangan_akumulasi = $value_sk['rp_target_keuangan_akumulasi'] == '' ? 0 : $value_sk['rp_target_keuangan_akumulasi'];
                    $rp_realisasi_keuangan_akumulasi = $value_sk['rp_realisasi_keuangan_akumulasi'] == '' ? 0 : $value_sk['rp_realisasi_keuangan_akumulasi'];
                    $persen_target_keuangan_akumulasi = $value_sk['target_keuangan_akumulasi'] == '' ? 0 : $value_sk['target_keuangan_akumulasi'];
                    $persen_realisasi_keuangan_akumulasi = $value_sk['realisasi_keuangan_akumulasi'] == '' ? 0 : $value_sk['realisasi_keuangan_akumulasi'];

                    $pagu_total = $value_sk['pagu_total']=='' ? 0 : $value_sk['pagu_total'];




                    $total_pagu_kegiatan+= $pagu_total;
                     $total_sub_kegiatan_persen_target_fisik_akumulasi += $persen_target_fisik_akumulasi ; 
                     $total_sub_kegiatan_persen_realisasi_fisik_akumulasi += $persen_realisasi_fisik_akumulasi ; 
                     $total_sub_kegiatan_rp_target_keuangan_akumulasi += $rp_target_keuangan_akumulasi ; 
                     $total_sub_kegiatan_rp_realisasi_keuangan_akumulasi += $rp_realisasi_keuangan_akumulasi ; 
                     // $total_sub_kegiatan_persen_target_keuangan_akumulasi += $persen_target_keuangan_akumulasi ; 
                     // $total_sub_kegiatan_persen_realisasi_keuangan_akumulasi += $persen_realisasi_keuangan_akumulasi ; 



                    $data_sub_kegiatan = [
                        'nama_sub_kegiatan'=>$value_sk['nama_sub_kegiatan'],
                        'pptk'=>$value_sk['pptk'],
                        'pagu'=>$pagu_total,
                        'persen_target_fisik'=>round($persen_target_fisik_akumulasi,2),
                        'persen_realisasi_fisik'=>round($persen_realisasi_fisik_akumulasi,2),
                        'deviasi_fisik'=>round($deviasi_fisik,2),

                        'rp_target_keuangan'=>$rp_target_keuangan_akumulasi,
                        'rp_realisasi_keuangan'=>$rp_realisasi_keuangan_akumulasi,
                        'persen_target_keuangan'=>round($persen_target_keuangan_akumulasi,2),
                        'persen_realisasi_keuangan'=>round($persen_realisasi_keuangan_akumulasi,2),
                        'deviasi_keuangan'=>round($deviasi_keuangan,2),
                    ];
                    array_push($kumpul_sub_kegiatan, $data_sub_kegiatan);
                }


                $banyak_sub_kegiatan = count($kumpul_sub_kegiatan);
                $persen_target_fisik_kegiatan = $total_sub_kegiatan_persen_target_fisik_akumulasi / $banyak_sub_kegiatan;
                $persen_realisasi_fisik_kegiatan = $total_sub_kegiatan_persen_realisasi_fisik_akumulasi / $banyak_sub_kegiatan;
                $deviasi_fisik_kegiatan = $persen_realisasi_fisik_kegiatan - $persen_target_fisik_kegiatan ; 
                $persen_target_keuangan_kegiatan = ($total_sub_kegiatan_rp_target_keuangan_akumulasi / $total_pagu_kegiatan) * 100 ;
                $persen_realisasi_keuangan_kegiatan = ($total_sub_kegiatan_rp_realisasi_keuangan_akumulasi / $total_pagu_kegiatan) * 100 ;
                $deviasi_keuangan_kegiatan = $persen_realisasi_keuangan_kegiatan - $persen_target_keuangan_kegiatan;



                $total_pagu_program +=$total_pagu_kegiatan;
                $persen_target_fisik_program +=$persen_target_fisik_kegiatan;
                $persen_realisasi_fisik_program +=$persen_realisasi_fisik_kegiatan;
                $totalkegiatan_rp_target_keuangan_akumulasi +=$total_sub_kegiatan_rp_target_keuangan_akumulasi;
                $totalkegiatan_rp_realisasi_keuangan_akumulasi +=$total_sub_kegiatan_rp_realisasi_keuangan_akumulasi;


                $data_kegiatan = [
                    'nama_kegiatan'=>$v_kegiatan['nama_kegiatan'],


                        'pptk'=>'-',
                        'pagu'=>$total_pagu_kegiatan,
                        'persen_target_fisik'=>round($persen_target_fisik_kegiatan,2),
                        'persen_realisasi_fisik'=>round($persen_realisasi_fisik_kegiatan,2),
                        'deviasi_fisik'=>round($deviasi_fisik_kegiatan,2),

                        'rp_target_keuangan'=>$total_sub_kegiatan_rp_target_keuangan_akumulasi,
                        'rp_realisasi_keuangan'=>$total_sub_kegiatan_rp_realisasi_keuangan_akumulasi,
                        'persen_target_keuangan'=> round($persen_target_keuangan_kegiatan,2), //$total_sub_kegiatan_persen_target_keuangan_akumulasi,
                        'persen_realisasi_keuangan'=> round($persen_realisasi_keuangan_kegiatan,2),//$total_sub_kegiatan_persen_realisasi_keuangan_akumulasi,
                        'deviasi_keuangan'=> round($deviasi_keuangan_kegiatan,2),



                    'data_sub_kegiatan'=>$kumpul_sub_kegiatan,
                ];
                array_push($kumpul_kegiatan, $data_kegiatan);
            }


            $banyak_kegiatan = count($kumpul_kegiatan);
            $persen_target_fisik_program = $persen_target_fisik_program / $banyak_kegiatan;
            $persen_realisasi_fisik_program = $persen_realisasi_fisik_program / $banyak_kegiatan;
            $deviasi_fisik_program = $persen_realisasi_fisik_program - $persen_target_fisik_program;
            $persen_target_keuangan_program = ($totalkegiatan_rp_target_keuangan_akumulasi / $total_pagu_program) * 100 ;
            $persen_realisasi_keuangan_program = ($totalkegiatan_rp_realisasi_keuangan_akumulasi / $total_pagu_program) * 100 ;
            $deviasi_keuangan_program = $persen_realisasi_keuangan_program - $persen_target_keuangan_program;


            $data_program = [
                'nama_program'=>$v_program['nama_program'],

                'pptk'=>'-',
                'pagu'=>$total_pagu_program,
                'persen_target_fisik'=>round($persen_target_fisik_program,2),
                'persen_realisasi_fisik'=>round($persen_realisasi_fisik_program,2),
                'deviasi_fisik'=>round($deviasi_fisik_program,2),

                'rp_target_keuangan'=>$totalkegiatan_rp_target_keuangan_akumulasi,
                'rp_realisasi_keuangan'=>$totalkegiatan_rp_realisasi_keuangan_akumulasi,
                'persen_target_keuangan'=> round($persen_target_keuangan_program,2), //$total_sub_kegiatan_persen_target_keuangan_akumulasi,
                'persen_realisasi_keuangan'=> round($persen_realisasi_keuangan_program,2),//$total_sub_kegiatan_persen_realisasi_keuangan_akumulasi,
                'deviasi_keuangan'=> round($deviasi_keuangan_program,2),

                'data_kegiatan'=>$kumpul_kegiatan,
            ];
            array_push($kumpul_program, $data_program);
           
        }


        


        $output = [
            'status'=>'',
            'message'=>'',
            'bulan'=>$bulan,
            'pencapaian_opd'=>$pencapaian_opd,
            'data'=> $kumpul_program,
        ];

            header('Content-Type: application/json');
        echo json_encode($output);

    }



}
