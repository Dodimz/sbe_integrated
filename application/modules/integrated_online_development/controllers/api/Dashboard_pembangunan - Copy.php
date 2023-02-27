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
          
          $total_target = 0;
          $total_realisasi = 0;

          $persen_target_keuangan_total = 0;
          $persen_realisasi_keuangan_total = 0;
          $persen_realisasi = 0;
        }else{
          $persen_target_keuangan_total = ($q_total['total_target'] / $q_total['total_pagu']) * 100; 
          $persen_realisasi_keuangan_total = ($q_total['total_realisasi'] / $q_total['total_pagu']) * 100; 
          $persen_realisasi = ($q_total['total_realisasi'] / $q_total['total_target']) * 100; 
          $total_target =  $q_total['total_target'];
          $total_realisasi =  $q_total['total_realisasi'];

        }

        $output = [
             'status'=>'success',
            'message'=>'',
            'data'=> [
                // 'pagu_total'=>$q_total['total_pagu'],
                'rp_target_keuangan_total'=>$total_target,
                'rp_realisasi_keuangan_total'=>$total_realisasi,
                // 'persen_target_keuangan_total'=>round($persen_target_keuangan_total,2),
                // 'persen_realisasi_keuangan_total'=>round($persen_realisasi_keuangan_total,2),
                'persen_realisasi'=>round($persen_realisasi,2),
            
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

                'url'=> base_url().'integrated/api/dashboard_pembangunan/detail_data_opd_pengelompokan/'.$v['id_instansi'].'/'.$v['tahun'].'/'.$v['kode_tahap'].'/'.$v['bulan'].'/',
            ];
            array_push($data_opd,$data_push);
        }





        $output = [
            'status'=>'',
            'message'=>'',
            'data'=> $data_opd
        ];

            header('Content-Type: application/json');
        echo json_encode($output);

    }
    public function detail_data_opd($id_instansi, $tahun, $tahap, $bulan)
    {
        
        $dashboard_pembangunan    = $this->dashboard_pembangunan_model;
        $q = $dashboard_pembangunan->laporan_sub_kegiatan_opd_gabungan($id_instansi, $tahun, $tahap, $bulan);
        $data_opd = [];
        foreach ($q->result_array() as $k => $v) {
            // $deviasi_fisik_bulanan = $v['realisasi_fisik_bulanan'] - $v['target_fisik_bulanan'];


            $fisik_persen_target = $v['target_fisik_akumulasi'] =='' ? 0 : $v['target_fisik_akumulasi'];
            $fisik_persen_realisasi = $v['realisasi_fisik_akumulasi'] =='' ? 0 : $v['realisasi_fisik_akumulasi'];
            $deviasi_fisik_akumulasi = $v['realisasi_fisik_akumulasi'] - $v['target_fisik_akumulasi'];

            $rp_target = $v['rp_target_keuangan_akumulasi'] =='' ? 0 : $v['rp_target_keuangan_akumulasi'];
            $persen_target = $v['target_keuangan_akumulasi'] =='' ? 0 : $v['target_keuangan_akumulasi'];
            $rp_realisasi = $v['rp_realisasi_keuangan_akumulasi'] =='' ? 0 : $v['rp_realisasi_keuangan_akumulasi'];
            $persen_realisasi = $v['realisasi_keuangan_akumulasi'] =='' ? 0 : $v['realisasi_keuangan_akumulasi'];
            $deviasi_keuangan_akumulasi = $v['realisasi_keuangan_akumulasi'] - $v['target_keuangan_akumulasi'];


            $data_push = [
                   'nama_sub_kegiatan'=>$value_sk['nama_sub_kegiatan'],
                        'pptk'=>$value_sk['nama_sub_kegiatan'],
                        'pagu'=>$value_sk['pagu_total'],
                        'persen_target_fisik'=>$target_fisik_akumulasi,
                        'persen_realisasi_fisik'=>$realisasi_fisik_akumulasi,
                        'deviasi_fisik'=>$deviasi_fisik,

                        'rp_target_keuangan'=>$rp_target_keuangan_akumulasi,
                        'rp_realisasi_keuangan'=>$rp_realisasi_keuangan_akumulasi,
                        'persen_target_keuangan'=>$target_keuangan_akumulasi,
                        'persen_realisasi_keuangan'=>$realisasi_keuangan_akumulasi,
                        'deviasi_keuangan'=>$deviasi_keuangan,
                // 'url'=> base_url().'integrated/api/dashboard_pembangunan/detail_data_opd/'.$v['id_instansi'].'/'.$v['tahun'].'/'.$v['kode_tahap'].'/'.$v['bulan'].'/',
            ];
            array_push($data_opd,$data_push);
        }





        $output = [
            'status'=>'',
            'message'=>'',
            'data'=> $data_opd,
        ];

            header('Content-Type: application/json');
        echo json_encode($output);

    }



    public function detail_data_opd_pengelompokan($id_instansi, $tahun, $tahap, $bulan)
    {
        
        $dashboard_pembangunan    = $this->dashboard_pembangunan_model;
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
            'data'=> $kumpul_program,
        ];

            header('Content-Type: application/json');
        echo json_encode($output);

    }




    public function synch($id_instansi, $tahun, $tahap)
    {
        
        $dashboard_pembangunan    = $this->dashboard_pembangunan_model;
         $sub_kegiatan = $dashboard_pembangunan->get_sub_kegiatan($id_instansi, $tahun, $tahap);
        



     $bulan = 12;
     $ope = '<=';

  $total_sub_kegiatan = 0;
  $no_sub_kegiatan = 0;
  $total_pagu_sub_kegiatan_instansi=0;
  $kumpul_sub_kegiatan = [];



  $q_program = $this->db->query("SELECT kode_program, nama_program from master_program");
  $kumpul_program = [];
  foreach ($q_program->result_array() as $k_program => $v_program) {
    $kumpul_program[$v_program['kode_program']] = $v_program['nama_program'];
  }


  $kumpul_kegiatan = [];
  $q_kegiatan = $this->db->query("SELECT kode_kegiatan, nama_kegiatan from master_kegiatan");
foreach ($q_kegiatan->result_array() as $k_kegiatan => $v_kegiatan) {
    $kumpul_kegiatan[$v_kegiatan['kode_kegiatan']] = $v_kegiatan['nama_kegiatan'];
  }


  $kumpul_pptk = [];
  $q_pptk = $this->db->query("SELECT mu.full_name, usk.kode_rekening_sub_kegiatan from users_sub_kegiatan usk
    left join master_users mu on usk.id_user = mu.id_user
    where usk.tahun_anggaran='$tahun' and usk.kode_tahap='$tahap' and usk.id_instansi='$id_instansi'
    ");
foreach ($q_pptk->result_array() as $k_pptk => $v_pptk) {
    $kumpul_pptk[$v_pptk['kode_rekening_sub_kegiatan']] = $v_pptk['full_name'];
  }


  $kumpul_pagu = [];
  $q_pagu = $this->db->query("SELECT kode_sub_kegiatan,
    bo_bp , bo_bbj , bo_bs , bo_bh , bm_bmt , bm_bmpm , bm_bmgb , bm_bmjji , bm_bmatl , btt , bt_bbh , bt_bbk 
    from anggaran_sub_kegiatan
    where tahun='$tahun' and kode_tahap='$tahap' and id_instansi='$id_instansi'
    ");
foreach ($q_pagu->result_array() as $k_pagu => $v_pagu) {
    $pagu_total = $v_pagu['bo_bp'] + $v_pagu['bo_bbj'] + $v_pagu['bo_bs'] + $v_pagu['bo_bh'] + $v_pagu['bm_bmt'] + $v_pagu['bm_bmpm'] + $v_pagu['bm_bmgb'] + $v_pagu['bm_bmjji'] + $v_pagu['bm_bmatl'] + $v_pagu['btt'] + $v_pagu['bt_bbh'] + $v_pagu['bt_bbk'];
    $kumpul_pagu[$v_pagu['kode_sub_kegiatan']]['bo_bp'] = $v_pagu['bo_bp'];
    $kumpul_pagu[$v_pagu['kode_sub_kegiatan']]['bo_bbj'] = $v_pagu['bo_bbj'];
    $kumpul_pagu[$v_pagu['kode_sub_kegiatan']]['bo_bs'] = $v_pagu['bo_bs'];
    $kumpul_pagu[$v_pagu['kode_sub_kegiatan']]['bo_bh'] = $v_pagu['bo_bh'];
    $kumpul_pagu[$v_pagu['kode_sub_kegiatan']]['bm_bmt'] = $v_pagu['bm_bmt'];
    $kumpul_pagu[$v_pagu['kode_sub_kegiatan']]['bm_bmpm'] = $v_pagu['bm_bmpm'];
    $kumpul_pagu[$v_pagu['kode_sub_kegiatan']]['bm_bmgb'] = $v_pagu['bm_bmgb'];
    $kumpul_pagu[$v_pagu['kode_sub_kegiatan']]['bm_bmjji'] = $v_pagu['bm_bmjji'];
    $kumpul_pagu[$v_pagu['kode_sub_kegiatan']]['bm_bmatl'] = $v_pagu['bm_bmatl'];
    $kumpul_pagu[$v_pagu['kode_sub_kegiatan']]['btt'] = $v_pagu['btt'];
    $kumpul_pagu[$v_pagu['kode_sub_kegiatan']]['bt_bbh'] = $v_pagu['bt_bbh'];
    $kumpul_pagu[$v_pagu['kode_sub_kegiatan']]['bt_bbk'] = $v_pagu['bt_bbk'];
    $kumpul_pagu[$v_pagu['kode_sub_kegiatan']]['pagu_total'] = $pagu_total;
  }



    foreach ($sub_kegiatan->result() as $key => $value_sk) {
  
      $no_sub_kegiatan++;
      $kategori_sub_kegiatan = $value_sk->kategori;
      $tahap = $value_sk->kode_tahap;
      $total_pagu_sub_kegiatan_instansi +=$value_sk->pagu ;
          if($kategori_sub_kegiatan =='Unit Pelaksana'){
            $nama_sub_kegiatan = $value_sk->nama_sub_kegiatan."<br>[".$value_sk->jenis_sub_kegiatan.' - '.$value_sk->keterangan."]";
           
          }else{
            $nama_sub_kegiatan = $value_sk->nama_sub_kegiatan;
          }












        // $target = $this->realisasi_akumulasi_model->get_target($id_instansi, $value_sk->kode_rekening_sub_kegiatan, $bulan, $value_sk->kode_tahap, $value_sk->tahun)->row_array();
        // $realisasi_keuangan = $this->realisasi_akumulasi_model->get_realisasi_keuangan($id_instansi, $value_sk->kode_rekening_sub_kegiatan, $bulan, $ope, $tahun, $tahap)->row_array();



        $gagu_kegiatan = $dashboard_pembangunan->get_pagu($id_instansi, $value_sk->kode_rekening_sub_kegiatan, $value_sk->kode_tahap, $value_sk->tahun)->result_array();
        $target = $dashboard_pembangunan->get_target($id_instansi, $value_sk->kode_rekening_sub_kegiatan, $value_sk->kode_tahap, $value_sk->tahun)->result_array();
        $realisasi_keuangan = $dashboard_pembangunan->get_realisasi_keuangan($id_instansi, $value_sk->kode_rekening_sub_kegiatan, $tahun, $tahap)->result_array();
        $kumpul_data_realisasi_keuangan = [];


        $kumpul_sum_realisasi_bo_bp = [];
        $kumpul_sum_realisasi_bo_bbj = [];
        $kumpul_sum_realisasi_bo_bs = [];
        $kumpul_sum_realisasi_bo_bh = [];
        $kumpul_sum_realisasi_bm_bmt = [];
        $kumpul_sum_realisasi_bm_bmpm = [];
        $kumpul_sum_realisasi_bm_bmgb = [];
        $kumpul_sum_realisasi_bm_bmjji = [];
        $kumpul_sum_realisasi_bm_bmatl = [];
        $kumpul_sum_realisasi_btt = [];
        $kumpul_sum_realisasi_bt_bbh = [];
        $kumpul_sum_realisasi_bt_bbk = [];
        $kumpul_sum_realisasi_total = [];
        foreach ($realisasi_keuangan as $k_rk => $v_rk) {
            $index_bulan = $v_rk['bulan']-1;
           $kumpul_data_realisasi_keuangan[$index_bulan]['bulan'] = $v_rk['bulan'];
           $kumpul_data_realisasi_keuangan[$index_bulan]['rp_realisasi_keuangan_bulanan_bo_bp'] = $v_rk['realisasi_bo_bp'];
           $kumpul_data_realisasi_keuangan[$index_bulan]['rp_realisasi_keuangan_bulanan_bo_bbj'] = $v_rk['realisasi_bo_bbj'];
           $kumpul_data_realisasi_keuangan[$index_bulan]['rp_realisasi_keuangan_bulanan_bo_bs'] = $v_rk['realisasi_bo_bs'];
           $kumpul_data_realisasi_keuangan[$index_bulan]['rp_realisasi_keuangan_bulanan_bo_bh'] = $v_rk['realisasi_bo_bh'];
           $kumpul_data_realisasi_keuangan[$index_bulan]['rp_realisasi_keuangan_bulanan_bm_bmt'] = $v_rk['realisasi_bm_bmt'];
           $kumpul_data_realisasi_keuangan[$index_bulan]['rp_realisasi_keuangan_bulanan_bm_bmpm'] = $v_rk['realisasi_bm_bmpm'];
           $kumpul_data_realisasi_keuangan[$index_bulan]['rp_realisasi_keuangan_bulanan_bm_bmgb'] = $v_rk['realisasi_bm_bmgb'];
           $kumpul_data_realisasi_keuangan[$index_bulan]['rp_realisasi_keuangan_bulanan_bm_bmjji'] = $v_rk['realisasi_bm_bmjji'];
           $kumpul_data_realisasi_keuangan[$index_bulan]['rp_realisasi_keuangan_bulanan_bm_bmatl'] = $v_rk['realisasi_bm_bmatl'];
           $kumpul_data_realisasi_keuangan[$index_bulan]['rp_realisasi_keuangan_bulanan_btt'] = $v_rk['realisasi_btt'];
           $kumpul_data_realisasi_keuangan[$index_bulan]['rp_realisasi_keuangan_bulanan_bt_bbh'] = $v_rk['realisasi_bt_bbh'];
           $kumpul_data_realisasi_keuangan[$index_bulan]['rp_realisasi_keuangan_bulanan_bt_bbk'] = $v_rk['realisasi_bt_bbk'];
           $kumpul_data_realisasi_keuangan[$index_bulan]['rp_realisasi_keuangan_bulanan_total'] = $v_rk['total_realisasi'];

           array_push($kumpul_sum_realisasi_bo_bp, $v_rk['realisasi_bo_bp']);
           array_push($kumpul_sum_realisasi_bo_bbj, $v_rk['realisasi_bo_bbj']);
           array_push($kumpul_sum_realisasi_bo_bs, $v_rk['realisasi_bo_bs']);
           array_push($kumpul_sum_realisasi_bo_bh, $v_rk['realisasi_bo_bh']);
           array_push($kumpul_sum_realisasi_bm_bmt, $v_rk['realisasi_bm_bmt']);
           array_push($kumpul_sum_realisasi_bm_bmpm, $v_rk['realisasi_bm_bmpm']);
           array_push($kumpul_sum_realisasi_bm_bmgb, $v_rk['realisasi_bm_bmgb']);
           array_push($kumpul_sum_realisasi_bm_bmjji, $v_rk['realisasi_bm_bmjji']);
           array_push($kumpul_sum_realisasi_bm_bmatl, $v_rk['realisasi_bm_bmatl']);
           array_push($kumpul_sum_realisasi_btt, $v_rk['realisasi_btt']);
           array_push($kumpul_sum_realisasi_bt_bbh, $v_rk['realisasi_bt_bbh']);
           array_push($kumpul_sum_realisasi_bt_bbk, $v_rk['realisasi_bt_bbk']);
           array_push($kumpul_sum_realisasi_total, $v_rk['total_realisasi']);
           // $kumpul_data_realisasi_keuangan[$k_rk]['realisasi_keuangan'] = $v_rk['bulan'];
           $realisasi_akumulasi_bo_bp = array_sum($kumpul_sum_realisasi_bo_bp);
           $realisasi_akumulasi_bo_bbj = array_sum($kumpul_sum_realisasi_bo_bbj);
           $realisasi_akumulasi_bo_bs = array_sum($kumpul_sum_realisasi_bo_bs);
           $realisasi_akumulasi_bo_bh = array_sum($kumpul_sum_realisasi_bo_bh);
           $realisasi_akumulasi_bm_bmt = array_sum($kumpul_sum_realisasi_bm_bmt);
           $realisasi_akumulasi_bm_bmpm = array_sum($kumpul_sum_realisasi_bm_bmpm);
           $realisasi_akumulasi_bm_bmgb = array_sum($kumpul_sum_realisasi_bm_bmgb);
           $realisasi_akumulasi_bm_bmjji = array_sum($kumpul_sum_realisasi_bm_bmjji);
           $realisasi_akumulasi_bm_bmatl = array_sum($kumpul_sum_realisasi_bm_bmatl);
           $realisasi_akumulasi_btt = array_sum($kumpul_sum_realisasi_btt);
           $realisasi_akumulasi_bt_bbh = array_sum($kumpul_sum_realisasi_bt_bbh);
           $realisasi_akumulasi_bt_bbk = array_sum($kumpul_sum_realisasi_bt_bbk);
           $realisasi_akumulasi_total = array_sum($kumpul_sum_realisasi_total);
           $kumpul_data_realisasi_keuangan[$index_bulan]['rp_realisasi_keuangan_akumulasi_bo_bp'] = $realisasi_akumulasi_bo_bp;
           $kumpul_data_realisasi_keuangan[$index_bulan]['rp_realisasi_keuangan_akumulasi_bo_bbj'] = $realisasi_akumulasi_bo_bbj;
           $kumpul_data_realisasi_keuangan[$index_bulan]['rp_realisasi_keuangan_akumulasi_bo_bs'] = $realisasi_akumulasi_bo_bs;
           $kumpul_data_realisasi_keuangan[$index_bulan]['rp_realisasi_keuangan_akumulasi_bo_bh'] = $realisasi_akumulasi_bo_bh;
           $kumpul_data_realisasi_keuangan[$index_bulan]['rp_realisasi_keuangan_akumulasi_bm_bmt'] = $realisasi_akumulasi_bm_bmt;
           $kumpul_data_realisasi_keuangan[$index_bulan]['rp_realisasi_keuangan_akumulasi_bm_bmpm'] = $realisasi_akumulasi_bm_bmpm;
           $kumpul_data_realisasi_keuangan[$index_bulan]['rp_realisasi_keuangan_akumulasi_bm_bmgb'] = $realisasi_akumulasi_bm_bmgb;
           $kumpul_data_realisasi_keuangan[$index_bulan]['rp_realisasi_keuangan_akumulasi_bm_bmjji'] = $realisasi_akumulasi_bm_bmjji;
           $kumpul_data_realisasi_keuangan[$index_bulan]['rp_realisasi_keuangan_akumulasi_bm_bmatl'] = $realisasi_akumulasi_bm_bmatl;
           $kumpul_data_realisasi_keuangan[$index_bulan]['rp_realisasi_keuangan_akumulasi_btt'] = $realisasi_akumulasi_btt;
           $kumpul_data_realisasi_keuangan[$index_bulan]['rp_realisasi_keuangan_akumulasi_bt_bbh'] = $realisasi_akumulasi_bt_bbh;
           $kumpul_data_realisasi_keuangan[$index_bulan]['rp_realisasi_keuangan_akumulasi_bt_bbk'] = $realisasi_akumulasi_bt_bbk;
           $kumpul_data_realisasi_keuangan[$index_bulan]['rp_realisasi_keuangan_akumulasi_total'] = $realisasi_akumulasi_total;



        }

          $kumpultarget = [];
          $kumpul_realisasi_keuangan = [];
          $kumpul_realisasi_fisik = [];
          
          
          $total_paket = $dashboard_pembangunan->get_total_paket($id_instansi, $value_sk->kode_rekening_sub_kegiatan, $tahun, $tahap)->num_rows();
          
          $jenis_rutin = $dashboard_pembangunan->get_total_paket_perjenis($id_instansi, $value_sk->kode_rekening_sub_kegiatan, "RUTIN", $tahun, $tahap)->num_rows();
          
          
          
          
          
          
          
          
          
          
          
          
          
          
          
          
          
          
          
          
          
          
          
          
          
          
          for ($i=0; $i <12 ; $i++) { 
            $bulan =$i+1;

            if (empty($target)) {
                 $kumpultarget[$i]['target_fisik_akumulasi'] = 0;
                $rp_target_keuangan = 0 ; 
                $rp_target_keuangan_bulanan = 0 ; 
                $persen_target_keuangan = 0 ; 
                $persen_target_keuangan_bulanan = 0 ; 
                $target_fisik= 0 ;
                 $target_fisik_bulanan= 0 ;


                 
                 $kumpultarget[$i]['target_fisik_akumulasi'] = 0;
                 $kumpultarget[$i]['target_fisik_bulanan'] = 0;
                 $kumpultarget[$i]['rp_target_keuangan_akumulasi'] = 0;
                  $kumpultarget[$i]['persen_target_keuangan_akumulasi'] = 0;
                  $kumpultarget[$i]['rp_target_keuangan_bulanan'] = 0;
                  $kumpultarget[$i]['persen_target_keuangan_bulanan'] = 0;


             }else{
                $rp_target_keuangan = $target[$i]['target_keuangan']=='' ? 0 : $target[$i]['target_keuangan'] ; 
                $rp_target_keuangan_bulanan = $target[$i]['target_keuangan_bulanan']=='' ? 0 : $target[$i]['target_keuangan_bulanan'] ; 
                $persen_target_keuangan = $target[$i]['target_keuangan']=='' ? 0 : ($target[$i]['target_keuangan'] / $value_sk->pagu) * 100;
                $persen_target_keuangan_bulanan = $target[$i]['target_keuangan_bulanan']=='' ? 0 : ($target[$i]['target_keuangan'] / $value_sk->pagu) * 100;

                 $kumpultarget[$i]['target_fisik_akumulasi'] = $target[$i]['target_fisik'];
                 $kumpultarget[$i]['target_fisik_bulanan'] = $target[$i]['target_fisik_bulanan'];
                 $kumpultarget[$i]['rp_target_keuangan_akumulasi'] = $rp_target_keuangan;
                  $kumpultarget[$i]['persen_target_keuangan_akumulasi'] = $persen_target_keuangan;
                  $kumpultarget[$i]['rp_target_keuangan_bulanan'] = $rp_target_keuangan_bulanan;
                  $kumpultarget[$i]['persen_target_keuangan_bulanan'] = $persen_target_keuangan_bulanan;





                $target_fisik =  $kumpultarget[$i]['target_fisik_akumulasi'] ;//= $target[$i]['target_fisik'];
                $target_fisik_bulanan =  $kumpultarget[$i]['target_fisik_bulanan'] ;//= $target[$i]['target_fisik_bulanan'];
             }


             if (empty($realisasi_keuangan)) {
                  $kumpul_realisasi_keuangan[$i]['bulan'] = $bulan;
                      $kumpul_realisasi_keuangan[$i]['rp_realisasi_keuangan_bulanan_bo_bp'] = 0;
                      $kumpul_realisasi_keuangan[$i]['rp_realisasi_keuangan_bulanan_bo_bbj'] = 0;
                      $kumpul_realisasi_keuangan[$i]['rp_realisasi_keuangan_bulanan_bo_bs'] = 0;
                      $kumpul_realisasi_keuangan[$i]['rp_realisasi_keuangan_bulanan_bo_bh'] = 0;
                      $kumpul_realisasi_keuangan[$i]['rp_realisasi_keuangan_bulanan_bm_bmt'] = 0;
                      $kumpul_realisasi_keuangan[$i]['rp_realisasi_keuangan_bulanan_bm_bmpm'] = 0;
                      $kumpul_realisasi_keuangan[$i]['rp_realisasi_keuangan_bulanan_bm_bmgb'] = 0;
                      $kumpul_realisasi_keuangan[$i]['rp_realisasi_keuangan_bulanan_bm_bmjji'] = 0;
                      $kumpul_realisasi_keuangan[$i]['rp_realisasi_keuangan_bulanan_bm_bmatl'] = 0;
                      $kumpul_realisasi_keuangan[$i]['rp_realisasi_keuangan_bulanan_btt'] = 0;
                      $kumpul_realisasi_keuangan[$i]['rp_realisasi_keuangan_bulanan_bt_bbh'] = 0;
                      $kumpul_realisasi_keuangan[$i]['rp_realisasi_keuangan_bulanan_bt_bbk'] = 0;
                      $kumpul_realisasi_keuangan[$i]['rp_realisasi_keuangan_bulanan_total'] = 0;




                      $kumpul_realisasi_keuangan[$i]['rp_realisasi_keuangan_akumulasi_bo_bp'] = 0;//$kumpul_data_realisasi_keuangan[$i]['rp_realisasi_keuangan_akumulasi_bo_bp'];
                      $kumpul_realisasi_keuangan[$i]['rp_realisasi_keuangan_akumulasi_bo_bbj'] = 0;//$kumpul_data_realisasi_keuangan[$i]['rp_realisasi_keuangan_akumulasi_bo_bbj'];
                      $kumpul_realisasi_keuangan[$i]['rp_realisasi_keuangan_akumulasi_bo_bs'] = 0;//$kumpul_data_realisasi_keuangan[$i]['rp_realisasi_keuangan_akumulasi_bo_bs'];
                      $kumpul_realisasi_keuangan[$i]['rp_realisasi_keuangan_akumulasi_bo_bh'] = 0;//$kumpul_data_realisasi_keuangan[$i]['rp_realisasi_keuangan_akumulasi_bo_bh'];
                      $kumpul_realisasi_keuangan[$i]['rp_realisasi_keuangan_akumulasi_bm_bmt'] = 0;//$kumpul_data_realisasi_keuangan[$i]['rp_realisasi_keuangan_akumulasi_bm_bmt'];
                      $kumpul_realisasi_keuangan[$i]['rp_realisasi_keuangan_akumulasi_bm_bmpm'] = 0;//$kumpul_data_realisasi_keuangan[$i]['rp_realisasi_keuangan_akumulasi_bm_bmpm'];
                      $kumpul_realisasi_keuangan[$i]['rp_realisasi_keuangan_akumulasi_bm_bmgb'] = 0;//$kumpul_data_realisasi_keuangan[$i]['rp_realisasi_keuangan_akumulasi_bm_bmgb'];
                      $kumpul_realisasi_keuangan[$i]['rp_realisasi_keuangan_akumulasi_bm_bmjji'] = 0;//$kumpul_data_realisasi_keuangan[$i]['rp_realisasi_keuangan_akumulasi_bm_bmjji'];
                      $kumpul_realisasi_keuangan[$i]['rp_realisasi_keuangan_akumulasi_bm_bmatl'] = 0;//$kumpul_data_realisasi_keuangan[$i]['rp_realisasi_keuangan_akumulasi_bm_bmatl'];
                      $kumpul_realisasi_keuangan[$i]['rp_realisasi_keuangan_akumulasi_btt'] = 0;//$kumpul_data_realisasi_keuangan[$i]['rp_realisasi_keuangan_akumulasi_btt'];
                      $kumpul_realisasi_keuangan[$i]['rp_realisasi_keuangan_akumulasi_bt_bbh'] = 0;//$kumpul_data_realisasi_keuangan[$i]['rp_realisasi_keuangan_akumulasi_bt_bbh'];
                      $kumpul_realisasi_keuangan[$i]['rp_realisasi_keuangan_akumulasi_bt_bbk'] = 0;//$kumpul_data_realisasi_keuangan[$i]['rp_realisasi_keuangan_akumulasi_bt_bbk'];
                      $kumpul_realisasi_keuangan[$i]['rp_realisasi_keuangan_akumulasi_total'] = 0;//$kumpul_data_realisasi_keuangan[$i]['rp_realisasi_keuangan_akumulasi_bt_bbk'];




                      $rp_realisasi_keuangan_bulanan_bo_bp=0;
                      $rp_realisasi_keuangan_bulanan_bo_bbj=0;
                      $rp_realisasi_keuangan_bulanan_bo_bs=0;
                      $rp_realisasi_keuangan_bulanan_bo_bh=0;
                      $rp_realisasi_keuangan_bulanan_bm_bmt=0;
                      $rp_realisasi_keuangan_bulanan_bm_bmpm=0;
                      $rp_realisasi_keuangan_bulanan_bm_bmgb=0;
                      $rp_realisasi_keuangan_bulanan_bm_bmjji=0;
                      $rp_realisasi_keuangan_bulanan_bm_bmatl=0;
                      $rp_realisasi_keuangan_bulanan_btt=0;
                      $rp_realisasi_keuangan_bulanan_bt_bbh=0;
                      $rp_realisasi_keuangan_bulanan_bt_bbk=0;
                      $rp_realisasi_keuangan_bulanan_total=0;




                      $rp_realisasi_keuangan_akumulasi_bo_bp=0;//$kumpul_data_realisasi_keuangan[$i]['rp_realisasi_keuangan_akumulasi_bo_bp'];
                      $rp_realisasi_keuangan_akumulasi_bo_bbj=0;//$kumpul_data_realisasi_keuangan[$i]['rp_realisasi_keuangan_akumulasi_bo_bbj'];
                      $rp_realisasi_keuangan_akumulasi_bo_bs=0;//$kumpul_data_realisasi_keuangan[$i]['rp_realisasi_keuangan_akumulasi_bo_bs'];
                      $rp_realisasi_keuangan_akumulasi_bo_bh=0;//$kumpul_data_realisasi_keuangan[$i]['rp_realisasi_keuangan_akumulasi_bo_bh'];
                      $rp_realisasi_keuangan_akumulasi_bm_bmt=0;//$kumpul_data_realisasi_keuangan[$i]['rp_realisasi_keuangan_akumulasi_bm_bmt'];
                      $rp_realisasi_keuangan_akumulasi_bm_bmpm=0;//$kumpul_data_realisasi_keuangan[$i]['rp_realisasi_keuangan_akumulasi_bm_bmpm'];
                      $rp_realisasi_keuangan_akumulasi_bm_bmgb=0;//$kumpul_data_realisasi_keuangan[$i]['rp_realisasi_keuangan_akumulasi_bm_bmgb'];
                      $rp_realisasi_keuangan_akumulasi_bm_bmjji=0;//$kumpul_data_realisasi_keuangan[$i]['rp_realisasi_keuangan_akumulasi_bm_bmjji'];
                      $rp_realisasi_keuangan_akumulasi_bm_bmatl=0;//$kumpul_data_realisasi_keuangan[$i]['rp_realisasi_keuangan_akumulasi_bm_bmatl'];
                      $rp_realisasi_keuangan_akumulasi_btt=0;//$kumpul_data_realisasi_keuangan[$i]['rp_realisasi_keuangan_akumulasi_btt'];
                      $rp_realisasi_keuangan_akumulasi_bt_bbh=0;//$kumpul_data_realisasi_keuangan[$i]['rp_realisasi_keuangan_akumulasi_bt_bbh'];
                      $rp_realisasi_keuangan_akumulasi_bt_bbk=0;//$kumpul_data_realisasi_keuangan[$i]['rp_realisasi_keuangan_akumulasi_bt_bbh'];
                      $rp_realisasi_keuangan_akumulasi_total=0;//$kumpul_data_realisasi_keuangan[$i]['rp_realisasi_keuangan_akumulasi_bt_bbk'];
                    //kosong

                    $realisasi_rutin = 0 ;
             }else{

                    if (isset($kumpul_data_realisasi_keuangan[$i])) {
                      $kumpul_realisasi_keuangan[$i]['bulan'] = $kumpul_data_realisasi_keuangan[$i]['bulan'];
                      $kumpul_realisasi_keuangan[$i]['rp_realisasi_keuangan_bulanan_bo_bp'] = $kumpul_data_realisasi_keuangan[$i]['rp_realisasi_keuangan_bulanan_bo_bp'];
                      $kumpul_realisasi_keuangan[$i]['rp_realisasi_keuangan_bulanan_bo_bbj'] = $kumpul_data_realisasi_keuangan[$i]['rp_realisasi_keuangan_bulanan_bo_bbj'];
                      $kumpul_realisasi_keuangan[$i]['rp_realisasi_keuangan_bulanan_bo_bs'] = $kumpul_data_realisasi_keuangan[$i]['rp_realisasi_keuangan_bulanan_bo_bs'];
                      $kumpul_realisasi_keuangan[$i]['rp_realisasi_keuangan_bulanan_bo_bh'] = $kumpul_data_realisasi_keuangan[$i]['rp_realisasi_keuangan_bulanan_bo_bh'];
                      $kumpul_realisasi_keuangan[$i]['rp_realisasi_keuangan_bulanan_bm_bmt'] = $kumpul_data_realisasi_keuangan[$i]['rp_realisasi_keuangan_bulanan_bm_bmt'];
                      $kumpul_realisasi_keuangan[$i]['rp_realisasi_keuangan_bulanan_bm_bmpm'] = $kumpul_data_realisasi_keuangan[$i]['rp_realisasi_keuangan_bulanan_bm_bmpm'];
                      $kumpul_realisasi_keuangan[$i]['rp_realisasi_keuangan_bulanan_bm_bmgb'] = $kumpul_data_realisasi_keuangan[$i]['rp_realisasi_keuangan_bulanan_bm_bmgb'];
                      $kumpul_realisasi_keuangan[$i]['rp_realisasi_keuangan_bulanan_bm_bmjji'] = $kumpul_data_realisasi_keuangan[$i]['rp_realisasi_keuangan_bulanan_bm_bmjji'];
                      $kumpul_realisasi_keuangan[$i]['rp_realisasi_keuangan_bulanan_bm_bmatl'] = $kumpul_data_realisasi_keuangan[$i]['rp_realisasi_keuangan_bulanan_bm_bmatl'];
                      $kumpul_realisasi_keuangan[$i]['rp_realisasi_keuangan_bulanan_btt'] = $kumpul_data_realisasi_keuangan[$i]['rp_realisasi_keuangan_bulanan_btt'];
                      $kumpul_realisasi_keuangan[$i]['rp_realisasi_keuangan_bulanan_bt_bbh'] = $kumpul_data_realisasi_keuangan[$i]['rp_realisasi_keuangan_bulanan_bt_bbh'];
                      $kumpul_realisasi_keuangan[$i]['rp_realisasi_keuangan_bulanan_bt_bbk'] = $kumpul_data_realisasi_keuangan[$i]['rp_realisasi_keuangan_bulanan_bt_bbk'];
                      $kumpul_realisasi_keuangan[$i]['rp_realisasi_keuangan_bulanan_total'] = $kumpul_data_realisasi_keuangan[$i]['rp_realisasi_keuangan_bulanan_total'];
                        # code...

                      $kumpul_realisasi_keuangan[$i]['rp_realisasi_keuangan_akumulasi_bo_bp'] = $kumpul_data_realisasi_keuangan[$i]['rp_realisasi_keuangan_akumulasi_bo_bp'];
                      $kumpul_realisasi_keuangan[$i]['rp_realisasi_keuangan_akumulasi_bo_bbj'] = $kumpul_data_realisasi_keuangan[$i]['rp_realisasi_keuangan_akumulasi_bo_bbj'];
                      $kumpul_realisasi_keuangan[$i]['rp_realisasi_keuangan_akumulasi_bo_bs'] = $kumpul_data_realisasi_keuangan[$i]['rp_realisasi_keuangan_akumulasi_bo_bs'];
                      $kumpul_realisasi_keuangan[$i]['rp_realisasi_keuangan_akumulasi_bo_bh'] = $kumpul_data_realisasi_keuangan[$i]['rp_realisasi_keuangan_akumulasi_bo_bh'];
                      $kumpul_realisasi_keuangan[$i]['rp_realisasi_keuangan_akumulasi_bm_bmt'] = $kumpul_data_realisasi_keuangan[$i]['rp_realisasi_keuangan_akumulasi_bm_bmt'];
                      $kumpul_realisasi_keuangan[$i]['rp_realisasi_keuangan_akumulasi_bm_bmpm'] = $kumpul_data_realisasi_keuangan[$i]['rp_realisasi_keuangan_akumulasi_bm_bmpm'];
                      $kumpul_realisasi_keuangan[$i]['rp_realisasi_keuangan_akumulasi_bm_bmgb'] = $kumpul_data_realisasi_keuangan[$i]['rp_realisasi_keuangan_akumulasi_bm_bmgb'];
                      $kumpul_realisasi_keuangan[$i]['rp_realisasi_keuangan_akumulasi_bm_bmjji'] = $kumpul_data_realisasi_keuangan[$i]['rp_realisasi_keuangan_akumulasi_bm_bmjji'];
                      $kumpul_realisasi_keuangan[$i]['rp_realisasi_keuangan_akumulasi_bm_bmatl'] = $kumpul_data_realisasi_keuangan[$i]['rp_realisasi_keuangan_akumulasi_bm_bmatl'];
                      $kumpul_realisasi_keuangan[$i]['rp_realisasi_keuangan_akumulasi_btt'] = $kumpul_data_realisasi_keuangan[$i]['rp_realisasi_keuangan_akumulasi_btt'];
                      $kumpul_realisasi_keuangan[$i]['rp_realisasi_keuangan_akumulasi_bt_bbh'] = $kumpul_data_realisasi_keuangan[$i]['rp_realisasi_keuangan_akumulasi_bt_bbh'];
                      $kumpul_realisasi_keuangan[$i]['rp_realisasi_keuangan_akumulasi_bt_bbk'] = $kumpul_data_realisasi_keuangan[$i]['rp_realisasi_keuangan_akumulasi_bt_bbk'];
                      $kumpul_realisasi_keuangan[$i]['rp_realisasi_keuangan_akumulasi_total'] = $kumpul_data_realisasi_keuangan[$i]['rp_realisasi_keuangan_akumulasi_total'];



                      $kumpul_realisasi_keuangan[$i]['bulan'] = $kumpul_data_realisasi_keuangan[$i]['bulan'];
                      $rp_realisasi_keuangan_bulanan_bo_bp = $kumpul_data_realisasi_keuangan[$i]['rp_realisasi_keuangan_bulanan_bo_bp'];
                      $rp_realisasi_keuangan_bulanan_bo_bbj = $kumpul_data_realisasi_keuangan[$i]['rp_realisasi_keuangan_bulanan_bo_bbj'];
                      $rp_realisasi_keuangan_bulanan_bo_bs = $kumpul_data_realisasi_keuangan[$i]['rp_realisasi_keuangan_bulanan_bo_bs'];
                      $rp_realisasi_keuangan_bulanan_bo_bh = $kumpul_data_realisasi_keuangan[$i]['rp_realisasi_keuangan_bulanan_bo_bh'];
                      $rp_realisasi_keuangan_bulanan_bm_bmt = $kumpul_data_realisasi_keuangan[$i]['rp_realisasi_keuangan_bulanan_bm_bmt'];
                      $rp_realisasi_keuangan_bulanan_bm_bmpm = $kumpul_data_realisasi_keuangan[$i]['rp_realisasi_keuangan_bulanan_bm_bmpm'];
                      $rp_realisasi_keuangan_bulanan_bm_bmgb = $kumpul_data_realisasi_keuangan[$i]['rp_realisasi_keuangan_bulanan_bm_bmgb'];
                      $rp_realisasi_keuangan_bulanan_bm_bmjji = $kumpul_data_realisasi_keuangan[$i]['rp_realisasi_keuangan_bulanan_bm_bmjji'];
                      $rp_realisasi_keuangan_bulanan_bm_bmatl = $kumpul_data_realisasi_keuangan[$i]['rp_realisasi_keuangan_bulanan_bm_bmatl'];
                      $rp_realisasi_keuangan_bulanan_btt = $kumpul_data_realisasi_keuangan[$i]['rp_realisasi_keuangan_bulanan_btt'];
                      $rp_realisasi_keuangan_bulanan_bt_bbh = $kumpul_data_realisasi_keuangan[$i]['rp_realisasi_keuangan_bulanan_bt_bbh'];
                      $rp_realisasi_keuangan_bulanan_bt_bbk = $kumpul_data_realisasi_keuangan[$i]['rp_realisasi_keuangan_bulanan_bt_bbk'];
                      $rp_realisasi_keuangan_bulanan_total = $kumpul_data_realisasi_keuangan[$i]['rp_realisasi_keuangan_bulanan_total'];
                        # code...

                      $rp_realisasi_keuangan_akumulasi_bo_bp = $kumpul_data_realisasi_keuangan[$i]['rp_realisasi_keuangan_akumulasi_bo_bp'];
                      $rp_realisasi_keuangan_akumulasi_bo_bbj = $kumpul_data_realisasi_keuangan[$i]['rp_realisasi_keuangan_akumulasi_bo_bbj'];
                      $rp_realisasi_keuangan_akumulasi_bo_bs = $kumpul_data_realisasi_keuangan[$i]['rp_realisasi_keuangan_akumulasi_bo_bs'];
                      $rp_realisasi_keuangan_akumulasi_bo_bh = $kumpul_data_realisasi_keuangan[$i]['rp_realisasi_keuangan_akumulasi_bo_bh'];
                      $rp_realisasi_keuangan_akumulasi_bm_bmt = $kumpul_data_realisasi_keuangan[$i]['rp_realisasi_keuangan_akumulasi_bm_bmt'];
                      $rp_realisasi_keuangan_akumulasi_bm_bmpm = $kumpul_data_realisasi_keuangan[$i]['rp_realisasi_keuangan_akumulasi_bm_bmpm'];
                      $rp_realisasi_keuangan_akumulasi_bm_bmgb = $kumpul_data_realisasi_keuangan[$i]['rp_realisasi_keuangan_akumulasi_bm_bmgb'];
                      $rp_realisasi_keuangan_akumulasi_bm_bmjji = $kumpul_data_realisasi_keuangan[$i]['rp_realisasi_keuangan_akumulasi_bm_bmjji'];
                      $rp_realisasi_keuangan_akumulasi_bm_bmatl = $kumpul_data_realisasi_keuangan[$i]['rp_realisasi_keuangan_akumulasi_bm_bmatl'];
                      $rp_realisasi_keuangan_akumulasi_btt = $kumpul_data_realisasi_keuangan[$i]['rp_realisasi_keuangan_akumulasi_btt'];
                      $rp_realisasi_keuangan_akumulasi_bt_bbh = $kumpul_data_realisasi_keuangan[$i]['rp_realisasi_keuangan_akumulasi_bt_bbh'];
                      $rp_realisasi_keuangan_akumulasi_bt_bbk = $kumpul_data_realisasi_keuangan[$i]['rp_realisasi_keuangan_akumulasi_bt_bbk'];
                      $rp_realisasi_keuangan_akumulasi_total = $kumpul_data_realisasi_keuangan[$i]['rp_realisasi_keuangan_akumulasi_total'];

                    $realisasi_rutin = 0 ;
                    
                  }else{
                      $kumpul_realisasi_keuangan[$i]['bulan'] = $bulan;
                      $kumpul_realisasi_keuangan[$i]['rp_realisasi_keuangan_bulanan_bo_bp'] = 0;
                      $kumpul_realisasi_keuangan[$i]['rp_realisasi_keuangan_bulanan_bo_bbj'] = 0;
                      $kumpul_realisasi_keuangan[$i]['rp_realisasi_keuangan_bulanan_bo_bs'] = 0;
                      $kumpul_realisasi_keuangan[$i]['rp_realisasi_keuangan_bulanan_bo_bh'] = 0;
                      $kumpul_realisasi_keuangan[$i]['rp_realisasi_keuangan_bulanan_bm_bmt'] = 0;
                      $kumpul_realisasi_keuangan[$i]['rp_realisasi_keuangan_bulanan_bm_bmpm'] = 0;
                      $kumpul_realisasi_keuangan[$i]['rp_realisasi_keuangan_bulanan_bm_bmgb'] = 0;
                      $kumpul_realisasi_keuangan[$i]['rp_realisasi_keuangan_bulanan_bm_bmjji'] = 0;
                      $kumpul_realisasi_keuangan[$i]['rp_realisasi_keuangan_bulanan_bm_bmatl'] = 0;
                      $kumpul_realisasi_keuangan[$i]['rp_realisasi_keuangan_bulanan_btt'] = 0;
                      $kumpul_realisasi_keuangan[$i]['rp_realisasi_keuangan_bulanan_bt_bbh'] = 0;
                      $kumpul_realisasi_keuangan[$i]['rp_realisasi_keuangan_bulanan_bt_bbk'] = 0;
                      $kumpul_realisasi_keuangan[$i]['rp_realisasi_keuangan_bulanan_total'] = 0;
                      
                      
                      $kumpul_realisasi_keuangan[$i]['rp_realisasi_keuangan_akumulasi_bo_bp'] = 0;//$kumpul_data_realisasi_keuangan[$i]['rp_realisasi_keuangan_akumulasi_bo_bp'];
                      $kumpul_realisasi_keuangan[$i]['rp_realisasi_keuangan_akumulasi_bo_bbj'] = 0;//$kumpul_data_realisasi_keuangan[$i]['rp_realisasi_keuangan_akumulasi_bo_bbj'];
                      $kumpul_realisasi_keuangan[$i]['rp_realisasi_keuangan_akumulasi_bo_bs'] = 0;//$kumpul_data_realisasi_keuangan[$i]['rp_realisasi_keuangan_akumulasi_bo_bs'];
                      $kumpul_realisasi_keuangan[$i]['rp_realisasi_keuangan_akumulasi_bo_bh'] = 0;//$kumpul_data_realisasi_keuangan[$i]['rp_realisasi_keuangan_akumulasi_bo_bh'];
                      $kumpul_realisasi_keuangan[$i]['rp_realisasi_keuangan_akumulasi_bm_bmt'] = 0;//$kumpul_data_realisasi_keuangan[$i]['rp_realisasi_keuangan_akumulasi_bm_bmt'];
                      $kumpul_realisasi_keuangan[$i]['rp_realisasi_keuangan_akumulasi_bm_bmpm'] = 0;//$kumpul_data_realisasi_keuangan[$i]['rp_realisasi_keuangan_akumulasi_bm_bmpm'];
                      $kumpul_realisasi_keuangan[$i]['rp_realisasi_keuangan_akumulasi_bm_bmgb'] = 0;//$kumpul_data_realisasi_keuangan[$i]['rp_realisasi_keuangan_akumulasi_bm_bmgb'];
                      $kumpul_realisasi_keuangan[$i]['rp_realisasi_keuangan_akumulasi_bm_bmjji'] = 0;//$kumpul_data_realisasi_keuangan[$i]['rp_realisasi_keuangan_akumulasi_bm_bmjji'];
                      $kumpul_realisasi_keuangan[$i]['rp_realisasi_keuangan_akumulasi_bm_bmatl'] = 0;//$kumpul_data_realisasi_keuangan[$i]['rp_realisasi_keuangan_akumulasi_bm_bmatl'];
                      $kumpul_realisasi_keuangan[$i]['rp_realisasi_keuangan_akumulasi_btt'] = 0;//$kumpul_data_realisasi_keuangan[$i]['rp_realisasi_keuangan_akumulasi_btt'];
                      $kumpul_realisasi_keuangan[$i]['rp_realisasi_keuangan_akumulasi_bt_bbh'] = 0;//$kumpul_data_realisasi_keuangan[$i]['rp_realisasi_keuangan_akumulasi_bt_bbh'];
                      $kumpul_realisasi_keuangan[$i]['rp_realisasi_keuangan_akumulasi_bt_bbk'] = 0;//$kumpul_data_realisasi_keuangan[$i]['rp_realisasi_keuangan_akumulasi_bt_bbk'];
                      $kumpul_realisasi_keuangan[$i]['rp_realisasi_keuangan_akumulasi_total'] = 0;//$kumpul_data_realisasi_keuangan[$i]['rp_realisasi_keuangan_akumulasi_bt_bbk'];
                      
                      
                      
                      
                      

                      $rp_realisasi_keuangan_bulanan_bo_bp = 0;//$kumpul_data_realisasi_keuangan[$i]['rp_realisasi_keuangan_bulanan_bo_bp'];
                      $rp_realisasi_keuangan_bulanan_bo_bbj = 0;//$kumpul_data_realisasi_keuangan[$i]['rp_realisasi_keuangan_bulanan_bo_bbj'];
                      $rp_realisasi_keuangan_bulanan_bo_bs = 0;//$kumpul_data_realisasi_keuangan[$i]['rp_realisasi_keuangan_bulanan_bo_bs'];
                      $rp_realisasi_keuangan_bulanan_bo_bh = 0;//$kumpul_data_realisasi_keuangan[$i]['rp_realisasi_keuangan_bulanan_bo_bh'];
                      $rp_realisasi_keuangan_bulanan_bm_bmt = 0;//$kumpul_data_realisasi_keuangan[$i]['rp_realisasi_keuangan_bulanan_bm_bmt'];
                      $rp_realisasi_keuangan_bulanan_bm_bmpm = 0;//$kumpul_data_realisasi_keuangan[$i]['rp_realisasi_keuangan_bulanan_bm_bmpm'];
                      $rp_realisasi_keuangan_bulanan_bm_bmgb = 0;//$kumpul_data_realisasi_keuangan[$i]['rp_realisasi_keuangan_bulanan_bm_bmgb'];
                      $rp_realisasi_keuangan_bulanan_bm_bmjji = 0;//$kumpul_data_realisasi_keuangan[$i]['rp_realisasi_keuangan_bulanan_bm_bmjji'];
                      $rp_realisasi_keuangan_bulanan_bm_bmatl = 0;//$kumpul_data_realisasi_keuangan[$i]['rp_realisasi_keuangan_bulanan_bm_bmatl'];
                      $rp_realisasi_keuangan_bulanan_btt = 0;//$kumpul_data_realisasi_keuangan[$i]['rp_realisasi_keuangan_bulanan_btt'];
                      $rp_realisasi_keuangan_bulanan_bt_bbh = 0;//$kumpul_data_realisasi_keuangan[$i]['rp_realisasi_keuangan_bulanan_bt_bbh'];
                      $rp_realisasi_keuangan_bulanan_bt_bbk = 0;//$kumpul_data_realisasi_keuangan[$i]['rp_realisasi_keuangan_bulanan_bt_bbk'];
                      $rp_realisasi_keuangan_bulanan_total = 0;//$kumpul_data_realisasi_keuangan[$i]['rp_realisasi_keuangan_bulanan_bt_bbk'];
                      # code...

                      $rp_realisasi_keuangan_akumulasi_bo_bp = 0;//$kumpul_data_realisasi_keuangan[$i]['rp_realisasi_keuangan_akumulasi_bo_bp'];
                      $rp_realisasi_keuangan_akumulasi_bo_bbj = 0;//$kumpul_data_realisasi_keuangan[$i]['rp_realisasi_keuangan_akumulasi_bo_bbj'];
                      $rp_realisasi_keuangan_akumulasi_bo_bs = 0;//$kumpul_data_realisasi_keuangan[$i]['rp_realisasi_keuangan_akumulasi_bo_bs'];
                      $rp_realisasi_keuangan_akumulasi_bo_bh = 0;//$kumpul_data_realisasi_keuangan[$i]['rp_realisasi_keuangan_akumulasi_bo_bh'];
                      $rp_realisasi_keuangan_akumulasi_bm_bmt = 0;//$kumpul_data_realisasi_keuangan[$i]['rp_realisasi_keuangan_akumulasi_bm_bmt'];
                      $rp_realisasi_keuangan_akumulasi_bm_bmpm = 0;//$kumpul_data_realisasi_keuangan[$i]['rp_realisasi_keuangan_akumulasi_bm_bmpm'];
                      $rp_realisasi_keuangan_akumulasi_bm_bmgb = 0;//$kumpul_data_realisasi_keuangan[$i]['rp_realisasi_keuangan_akumulasi_bm_bmgb'];
                      $rp_realisasi_keuangan_akumulasi_bm_bmjji = 0;//$kumpul_data_realisasi_keuangan[$i]['rp_realisasi_keuangan_akumulasi_bm_bmjji'];
                      $rp_realisasi_keuangan_akumulasi_bm_bmatl = 0;//$kumpul_data_realisasi_keuangan[$i]['rp_realisasi_keuangan_akumulasi_bm_bmatl'];
                      $rp_realisasi_keuangan_akumulasi_btt = 0;//$kumpul_data_realisasi_keuangan[$i]['rp_realisasi_keuangan_akumulasi_btt'];
                      $rp_realisasi_keuangan_akumulasi_bt_bbh = 0;//$kumpul_data_realisasi_keuangan[$i]['rp_realisasi_keuangan_akumulasi_bt_bbh'];
                      $rp_realisasi_keuangan_akumulasi_bt_bbk = 0;//$kumpul_data_realisasi_keuangan[$i]['rp_realisasi_keuangan_akumulasi_bt_bbk'];
                      $rp_realisasi_keuangan_akumulasi_total = 0;//$kumpul_data_realisasi_keuangan[$i]['rp_realisasi_keuangan_akumulasi_bt_bbk'];
                      $realisasi_rutin = 0 ;
                      
                    }
                    



                   $testing_bo = $kumpul_realisasi_keuangan[$i]['rp_realisasi_keuangan_akumulasi_bo_bp'] ; 
             }

             
             // $kumpultarget[$i]['target_fisik_bulanan'] = $target['target_fisik_bulanan'];
             
             
             
             $rp_realisasi_keuangan_akumulasi = $rp_realisasi_keuangan_akumulasi_bo_bp + $rp_realisasi_keuangan_akumulasi_bo_bbj + $rp_realisasi_keuangan_akumulasi_bo_bs + $rp_realisasi_keuangan_akumulasi_bo_bh + $rp_realisasi_keuangan_akumulasi_bm_bmt + $rp_realisasi_keuangan_akumulasi_bm_bmpm + $rp_realisasi_keuangan_akumulasi_bm_bmgb + $rp_realisasi_keuangan_akumulasi_bm_bmjji + $rp_realisasi_keuangan_akumulasi_bm_bmatl + $rp_realisasi_keuangan_akumulasi_btt + $rp_realisasi_keuangan_akumulasi_bt_bbh + $rp_realisasi_keuangan_akumulasi_bt_bbk;
             
             $rp_realisasi_keuangan_bulanan = $rp_realisasi_keuangan_bulanan_bo_bp + $rp_realisasi_keuangan_bulanan_bo_bbj + $rp_realisasi_keuangan_bulanan_bo_bs + $rp_realisasi_keuangan_bulanan_bo_bh + $rp_realisasi_keuangan_bulanan_bm_bmt + $rp_realisasi_keuangan_bulanan_bm_bmpm + $rp_realisasi_keuangan_bulanan_bm_bmgb + $rp_realisasi_keuangan_bulanan_bm_bmjji + $rp_realisasi_keuangan_bulanan_bm_bmatl + $rp_realisasi_keuangan_bulanan_btt + $rp_realisasi_keuangan_bulanan_bt_bbh + $rp_realisasi_keuangan_bulanan_bt_bbk;
             if($value_sk->pagu==0){
              $persen_realisasi_keuangan_akumulasi = 0; 
              $persen_realisasi_keuangan_bulanan = 0; 
             }else{
               $persen_realisasi_keuangan_akumulasi = $rp_realisasi_keuangan_akumulasi / $value_sk->pagu * 100 ; 
               $persen_realisasi_keuangan_bulanan = $rp_realisasi_keuangan_bulanan / $value_sk->pagu * 100 ; 
              }
             
             
             $swa = $dashboard_pembangunan->get_realisasi_fisik($id_instansi, $value_sk->kode_rekening_sub_kegiatan, 'SWAKELOLA', $tahun, $tahap , $bulan);
             $pen = $dashboard_pembangunan->get_realisasi_fisik($id_instansi, $value_sk->kode_rekening_sub_kegiatan,'PENYEDIA', $tahun, $tahap , $bulan);
   
             $swa_akumulasi = $swa['akumulasi'];
             $swa_bulanan = $swa['bulanan'];
             $pen_akumulasi = $pen['akumulasi'];
             $pen_bulanan = $pen['bulanan'];
             $rutin_akumulasi =  $persen_realisasi_keuangan_akumulasi;
             $rutin_bulanan =  $persen_realisasi_keuangan_bulanan;

            if($total_paket==0){
              $fisik_kegiatan_akumulasi = 0;
              $fisik_kegiatan_bulanan = 0;
            }else{
              $fisik_kegiatan_akumulasi = ($swa_akumulasi + $pen_akumulasi + $rutin_akumulasi) / $total_paket;
              $fisik_kegiatan_bulanan = ($swa_bulanan + $pen_bulanan + $rutin_bulanan) / $total_paket;

            }

            $realisasi_fisik = [
              'akumulasi'=>$fisik_kegiatan_akumulasi,
              'bulanan'=>$fisik_kegiatan_bulanan,
            ];
             
             
             array_push($kumpul_realisasi_fisik, $fisik_kegiatan_akumulasi);
        //  $data_kumpul_sub_kegiatan = [
        //   'id_instansi'=> $value_sk->id_instansi,
        //   'tahun'=> $value_sk->tahun,
        //   'bulan'=> $bulan,
        //   'kode_tahap'=> $value_sk->kode_tahap,
        //   'kode_kegiatan'=> $value_sk->kode_rekening_kegiatan,
        //   'nama_kegiatan'=> $kumpul_kegiatan[$value_sk->kode_rekening_kegiatan],
        //   'kode_program'=> $value_sk->kode_rekening_program,
        //   'nama_program'=> $kumpul_program[$value_sk->kode_rekening_program],
        //   'kode_sub_kegiatan'=> $value_sk->kode_rekening_sub_kegiatan,
        //   'nama_sub_kegiatan'=> $nama_sub_kegiatan,
        // 'pptk'=> @$kumpul_pptk[$value_sk->kode_rekening_sub_kegiatan],

        //   'kategori'=> $value_sk->kategori,
        //   'tambahan_kode_sub_kegiatan'=> $value_sk->tambahan_kode_sub_kegiatan,
        //   'input_by_tambahan_kode_sub_kegiatan'=> $value_sk->input_by_tambahan_kode_sub_kegiatan,
        //   'jenis_sub_kegiatan'=> $value_sk->jenis_sub_kegiatan,
        //   'id_instansi_pembantu_teknis'=> $value_sk->id_instansi_pembantu_teknis,
        //   'keterangan'=> $value_sk->keterangan,
        //   'status_sub_kegiatan'=> $value_sk->status,





        // 'pagu_bo_bp'=> @$kumpul_pagu[$value_sk->kode_rekening_sub_kegiatan]['bo_bp'],
        // 'pagu_bo_bbj'=> @$kumpul_pagu[$value_sk->kode_rekening_sub_kegiatan]['bo_bbj'],
        // 'pagu_bo_bs'=> @$kumpul_pagu[$value_sk->kode_rekening_sub_kegiatan]['bo_bs'],
        // 'pagu_bo_bh'=> @$kumpul_pagu[$value_sk->kode_rekening_sub_kegiatan]['bo_bh'],
        // 'pagu_bm_bmt'=> @$kumpul_pagu[$value_sk->kode_rekening_sub_kegiatan]['bm_bmt'],
        // 'pagu_bm_bmpm'=> @$kumpul_pagu[$value_sk->kode_rekening_sub_kegiatan]['bm_bmpm'],
        // 'pagu_bm_bmgb'=> @$kumpul_pagu[$value_sk->kode_rekening_sub_kegiatan]['bm_bmgb'],
        // 'pagu_bm_bmjji'=> @$kumpul_pagu[$value_sk->kode_rekening_sub_kegiatan]['bm_bmjji'],
        // 'pagu_bm_bmatl'=> @$kumpul_pagu[$value_sk->kode_rekening_sub_kegiatan]['bm_bmatl'],
        // 'pagu_btt'=> @$kumpul_pagu[$value_sk->kode_rekening_sub_kegiatan]['btt'],
        // 'pagu_bt_bbh'=> @$kumpul_pagu[$value_sk->kode_rekening_sub_kegiatan]['bt_bbh'],
        // 'pagu_bt_bbk'=> @$kumpul_pagu[$value_sk->kode_rekening_sub_kegiatan]['bt_bbk'],
        // 'pagu_total'=> @$kumpul_pagu[$value_sk->kode_rekening_sub_kegiatan]['pagu_total'],




        //   // 'realisasi'=> $kumpul_realisasi_keuangan,

        //     'target_fisik_akumulasi' => $target_fisik,
        //     'target_fisik_bulanan' => $target_fisik_bulanan,
        //     'realisasi_fisik_akumulasi' => '???',
        //     'realisasi_fisik_bulanan' => '???',

        //     'target_keuangan_akumulasi' =>  $persen_target_keuangan,
        //     'target_keuangan_bulanan' =>  $persen_target_keuangan_bulanan,
        //     'rp_target_keuangan_akumulasi' => $rp_target_keuangan,
        //     'rp_target_keuangan_bulanan' =>$rp_target_keuangan_bulanan,

        //     'rp_realisasi_keuangan_akumulasi' => $rp_realisasi_keuangan_bulanan,
        //     'rp_realisasi_keuangan_bulanan' => $rp_realisasi_keuangan_bulanan,


        //     'rp_realisasi_keuangan_bulanan_bo_bp' => $rp_realisasi_keuangan_bulanan_bo_bp,
        //     'rp_realisasi_keuangan_bulanan_bo_bbj' => $rp_realisasi_keuangan_bulanan_bo_bbj,
        //     'rp_realisasi_keuangan_bulanan_bo_bs' => $rp_realisasi_keuangan_bulanan_bo_bs,
        //     'rp_realisasi_keuangan_bulanan_bo_bh' => $rp_realisasi_keuangan_bulanan_bo_bh,
        //     'rp_realisasi_keuangan_bulanan_bm_bmt' => $rp_realisasi_keuangan_bulanan_bm_bmt,
        //     'rp_realisasi_keuangan_bulanan_bm_bmpm' => $rp_realisasi_keuangan_bulanan_bm_bmpm,
        //     'rp_realisasi_keuangan_bulanan_bm_bmgb' => $rp_realisasi_keuangan_bulanan_bm_bmgb,
        //     'rp_realisasi_keuangan_bulanan_bm_bmjji' => $rp_realisasi_keuangan_bulanan_bm_bmjji,
        //     'rp_realisasi_keuangan_bulanan_bm_bmatl' => $rp_realisasi_keuangan_bulanan_bm_bmatl,
        //     'rp_realisasi_keuangan_bulanan_btt' => $rp_realisasi_keuangan_bulanan_btt,
        //     'rp_realisasi_keuangan_bulanan_bt_bbh' => $rp_realisasi_keuangan_bulanan_bt_bbh,
        //     'rp_realisasi_keuangan_bulanan_bt_bbk' => $rp_realisasi_keuangan_bulanan_bt_bbk,
        //     'rp_realisasi_keuangan_akumulasi_bo_bp' => $rp_realisasi_keuangan_akumulasi_bo_bp,
        //     'rp_realisasi_keuangan_akumulasi_bo_bbj' => $rp_realisasi_keuangan_akumulasi_bo_bbj,
        //     'rp_realisasi_keuangan_akumulasi_bo_bs' => $rp_realisasi_keuangan_akumulasi_bo_bs,
        //     'rp_realisasi_keuangan_akumulasi_bo_bh' => $rp_realisasi_keuangan_akumulasi_bo_bh,
        //     'rp_realisasi_keuangan_akumulasi_bm_bmt' => $rp_realisasi_keuangan_akumulasi_bm_bmt,
        //     'rp_realisasi_keuangan_akumulasi_bm_bmpm' => $rp_realisasi_keuangan_akumulasi_bm_bmpm,
        //     'rp_realisasi_keuangan_akumulasi_bm_bmgb' => $rp_realisasi_keuangan_akumulasi_bm_bmgb,
        //     'rp_realisasi_keuangan_akumulasi_bm_bmjji' => $rp_realisasi_keuangan_akumulasi_bm_bmjji,
        //     'rp_realisasi_keuangan_akumulasi_bm_bmatl' => $rp_realisasi_keuangan_akumulasi_bm_bmatl,
        //     'rp_realisasi_keuangan_akumulasi_btt' => $rp_realisasi_keuangan_akumulasi_btt,
        //     'rp_realisasi_keuangan_akumulasi_bt_bbh' => $rp_realisasi_keuangan_akumulasi_bt_bbh,
        //     'rp_realisasi_keuangan_akumulasi_bt_bbk' => $rp_realisasi_keuangan_akumulasi_bt_bbk,

        //   // 'target'=> $kumpultarget,
        //   // 'realisasi'=> $kumpul_realisasi_keuangan,
        //   // 'bobot_ski'=>$bobot_ski,
        //   // 'persen_tf_sub_kegiatan'=> $target_fisik,
        //   // 'tft_ski'=>$tft_ski,
        //   // 'persen_rf_sub_kegiatan'=> $total_realisasi_fisik,
        //   // 'rft_ski'=>$rft_ski,
        //   // 'persen_df_sub_kegiatan'=> $dev_fisik,
        //   // 'nilai_tk_sub_kegiatan'=> $target_keuangan,
        //   // 'persen_tk_sub_kegiatan'=> $persen_target_keuangan,
        //   // 'nilai_rk_sub_kegiatan'=> $realisasi_keuangan['total_realisasi'],
        //   // 'persen_rk_sub_kegiatan'=> $persen_realisasi_keuangan,
        //   // 'persen_dk_sub_kegiatan'=> $dev_keu,
        //   // 'warna_df_sub_kegiatan'=> $warna_peringatan_dev_fisik,
        //   // 'warna_dk_sub_kegiatan'=> $warna_peringatan_dev_keu,
        //   // 'sisa_anggaran_sub_kegiatan'=> $sisa_pagu,
        //  ];
        //  array_push($kumpul_sub_kegiatan, $data_kumpul_sub_kegiatan);







        }










         $data_kumpul_sub_kegiatan = [

          'identitas'=> [
            'id_instansi'=> $value_sk->id_instansi,
            'tahun'=> $value_sk->tahun,
            'bulan'=> $bulan,
            'kode_tahap'=> $value_sk->kode_tahap,
            'kode_kegiatan'=> $value_sk->kode_rekening_kegiatan,
            'nama_kegiatan'=> @$kumpul_kegiatan[$value_sk->kode_rekening_kegiatan],
            'kode_program'=> $value_sk->kode_rekening_program,
            'nama_program'=> @$kumpul_program[$value_sk->kode_rekening_program],
            'kode_sub_kegiatan'=> $value_sk->kode_rekening_sub_kegiatan,
            'nama_sub_kegiatan'=> $nama_sub_kegiatan,

            'kategori'=> $value_sk->kategori,
            'tambahan_kode_sub_kegiatan'=> $value_sk->tambahan_kode_sub_kegiatan,
            'input_by_tambahan_kode_sub_kegiatan'=> $value_sk->input_by_tambahan_kode_sub_kegiatan,
            'jenis_sub_kegiatan'=> $value_sk->jenis_sub_kegiatan,
            'id_instansi_pembantu_teknis'=> $value_sk->id_instansi_pembantu_teknis,
            'keterangan'=> $value_sk->keterangan,
            'status_sub_kegiatan'=> $value_sk->status,
            'pptk'=> @$kumpul_pptk[$value_sk->kode_rekening_sub_kegiatan],
          ],
          
          // 'pagu_bo_bp'=> @$kumpul_pagu[$value_sk->kode_rekening_sub_kegiatan]['bo_bp'],
          // 'pagu_bo_bbj'=> @$kumpul_pagu[$value_sk->kode_rekening_sub_kegiatan]['bo_bbj'],
          // 'pagu_bo_bs'=> @$kumpul_pagu[$value_sk->kode_rekening_sub_kegiatan]['bo_bs'],
          // 'pagu_bo_bh'=> @$kumpul_pagu[$value_sk->kode_rekening_sub_kegiatan]['bo_bh'],
          // 'pagu_bm_bmt'=> @$kumpul_pagu[$value_sk->kode_rekening_sub_kegiatan]['bm_bmt'],
          // 'pagu_bm_bmpm'=> @$kumpul_pagu[$value_sk->kode_rekening_sub_kegiatan]['bm_bmpm'],
          // 'pagu_bm_bmgb'=> @$kumpul_pagu[$value_sk->kode_rekening_sub_kegiatan]['bm_bmgb'],
          // 'pagu_bm_bmjji'=> @$kumpul_pagu[$value_sk->kode_rekening_sub_kegiatan]['bm_bmjji'],
          // 'pagu_bm_bmatl'=> @$kumpul_pagu[$value_sk->kode_rekening_sub_kegiatan]['bm_bmatl'],
          // 'pagu_btt'=> @$kumpul_pagu[$value_sk->kode_rekening_sub_kegiatan]['btt'],
          // 'pagu_bt_bbh'=> @$kumpul_pagu[$value_sk->kode_rekening_sub_kegiatan]['bt_bbh'],
          // 'pagu_bt_bbk'=> @$kumpul_pagu[$value_sk->kode_rekening_sub_kegiatan]['bt_bbk'],
          'pagu'=> @$kumpul_pagu[$value_sk->kode_rekening_sub_kegiatan],

          



          'target'=> $kumpultarget,
          'realisasi_keuangan'=> $kumpul_realisasi_keuangan,
          'realisasi_fisik'=> $kumpul_realisasi_fisik,
          // 'bobot_ski'=>$bobot_ski,
          // 'persen_tf_sub_kegiatan'=> $target_fisik,
          // 'tft_ski'=>$tft_ski,
          // 'persen_rf_sub_kegiatan'=> $total_realisasi_fisik,
          // 'rft_ski'=>$rft_ski,
          // 'persen_df_sub_kegiatan'=> $dev_fisik,
          // 'nilai_tk_sub_kegiatan'=> $target_keuangan,
          // 'persen_tk_sub_kegiatan'=> $persen_target_keuangan,
          // 'nilai_rk_sub_kegiatan'=> $realisasi_keuangan['total_realisasi'],
          // 'persen_rk_sub_kegiatan'=> $persen_realisasi_keuangan,
          // 'persen_dk_sub_kegiatan'=> $dev_keu,
          // 'warna_df_sub_kegiatan'=> $warna_peringatan_dev_fisik,
          // 'warna_dk_sub_kegiatan'=> $warna_peringatan_dev_keu,
          // 'sisa_anggaran_sub_kegiatan'=> $sisa_pagu,
         ];
         array_push($kumpul_sub_kegiatan, $data_kumpul_sub_kegiatan);




        } // end foreach ($sub_kegiatan->result() as $key => $value_sk) {

        // $this->db->


        // $this->db->insert_batch('laporan_sub_kegiatan_opd', $kumpul_sub_kegiatan);

        
        $pecahkan_kembali = [];


        foreach($kumpul_sub_kegiatan as $k => $v){

            
              $data = [];
              for ($i=0; $i <12 ; $i++) { 
                $bulan = $i+1;
                $rf = $v['realisasi_fisik'][$i];
                if($bulan==1){
                  $rf_ok = $rf ; 
                }else{
                  if($v['realisasi_fisik'][$i]==0){
                    $index_sebelumnya = $i-1;
                    $rf_ok =$v['realisasi_fisik'][$index_sebelumnya] ; 
                    
                  }else{
                    $rf_ok = $rf ; 

                  }
                }

                $cek = $rf_ok;//$v['realisasi_fisik'][$i] > 0 ? $v['realisasi_fisik'][$i] : '-';
                array_push($data, $cek);
              }

            

          array_push($pecahkan_kembali, $data);
        }

        $output = [
            'status'=>'',
            'message'=>'',
            'data'=> $pecahkan_kembali
        ];

            header('Content-Type: application/json');
        echo json_encode($output);

    }

}
