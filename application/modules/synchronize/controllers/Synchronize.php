<?php

/**
 * Author     : Alfikri, M.Kom
 * Created By : Alfikri, M.Kom
 * E-Mail     : alfikri.name@gmail.com
 * No HP      : 081277337405
 * Class      : Synchronize.php
 */
defined('BASEPATH') or exit('No direct script access allowed');

class Synchronize extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model([
            'synchronize/target_realisasi_model'     => 'target_realisasi_model',
            'datatables_model'                      => 'datatables_model',

            'Laporan/realisasi_akumulasi_model'     => 'realisasi_akumulasi_model',

            'synchronize/synchronize_model'       => 'synchronize_model',
        ]);
    }

    public function index()
    {
        $this->target_realisasi();
    }

    public function target_realisasi()
    {
        $breadcrumbs         = $this->breadcrumbs;
        $target_realisasi     = $this->target_realisasi_model;

        $breadcrumbs->add('Home', base_url());
        $breadcrumbs->add('Synchronize', base_url($this->router->fetch_class()));
        $breadcrumbs->add('Target dan Realisasi', base_url());
        $breadcrumbs->render();

        $data['fetch_method']                        = 12;//"Synchronize Target dan Realisasi";
        $data['title']                        = "Synchronize Target dan Realisasi";
        $data['icon']                       = "metismenu-icon fa fa-crosshairs";
        $data['description']                = "Synchronize Target dan Realisasi";
        $data['breadcrumbs']                = $breadcrumbs->render();
        $page                                 = 'synchronize/target_realisasi/index';
        $data['link']                       = $this->router->fetch_method();
        $data['config']                       = $this->db->get('config');
        $data['menu']                       = $this->load->view('layout/menu', $data, true);
        $data['extra_css']                    = $this->load->view('synchronize/target_realisasi/css', $data, true);
        $data['extra_js']                    = $this->load->view('synchronize/target_realisasi/js', $data, true);
        $data['extra_js2']                    = $this->load->view('dashboard/js', $data, true);
        $data['modal']                      = $this->load->view('synchronize/target_realisasi/modal', $data, true);
        $this->template->load('backend_template', $page, $data);
    }



    
    public function auto_synch()
    {
        // $id_instansi         = 91;
        $tahun = tahun_anggaran();
        $tahap = tahapan_apbd();
        
        
        $q_skpd = $this->db->query("SELECT id_instansi from master_instansi where kategori='OPD' and is_active='1'")->result_array();
        $kumpul_auto_synch = [];
        $auto_synch_berhasil = 0;
        $auto_synch_gagal = 0;
        $auto_synch_jumlah =0;
        foreach($q_skpd as $k =>$v){
          $id_instansi = $v['id_instansi'];
          $synch = $this->synch_baru($tahun, $tahap, $id_instansi,'auto');
          $responcode = $synch['responcode'];

          // $data_auto_synch = [
          //   'id_instansi'=>$id_instansi,
          //   'tahun'=>$tahun,
          // 'kode_tahap'=>$tahap,
          // 'synchronize'=>'auto',
          //   'responcode'=>$responcode,
          //   'status'=>$synch['status'],
          //   'waktu_synch'=>timestamp(),
          // ];

          
          // $this->db->insert('cronjob_auto_synch_detail' , $data_auto_synch);
          if($responcode==200){
            $auto_synch_berhasil ++ ; 
          }else{
            $auto_synch_gagal ++ ; 
            
          }
          $auto_synch_jumlah ++ ; 

          // array_push($kumpul_auto_synch, $data_auto_synch);
          // var_dump($synch);
        }

        $data_rekap_auto_synch = [
          'tahun'=>$tahun,
          'kode_tahap'=>$tahap,
          'synchronize'=>'auto',
          'synch_berhasil'=>$auto_synch_berhasil,
          'synch_gagal'=>$auto_synch_gagal,
          'synch_jumlah'=>$auto_synch_jumlah,
          'waktu_synch'=>timestamp(),
        ];
        
        $this->db->insert('cronjob_auto_synch' , $data_rekap_auto_synch);
        echo "Berhasil : ".$auto_synch_berhasil.'<br>Gagal : '.$auto_synch_gagal;
        
    }




    public function cek_data($id_instansi){

        $t_fisik = $this->target_realisasi_model->get_target_fisik($id_instansi, $tahun, $tahap)->row_array();
        echo  json_encode($t_fisik);

    }

    public function sync()
    {
        $id_instansi        = $this->input->post('id_instansi');
        $kode_tahap        =  $this->input->post('tahapan_apbd');
        $tahap = $kode_tahap;
        $tahun        = tahun_anggaran();
        $where  =['id_instansi' => $id_instansi,'kode_tahap' => $kode_tahap,'tahun' => $tahun];
        $this->db->delete('grafik', $where);
        $t_anggaran = $this->target_realisasi_model->get_anggaran($id_instansi, $kode_tahap, $tahun);
       
        $target_fisik       = [];
        $target_keu         = [];
        $realisasi_fisik    = [];
        $realisasi_keuangan = [];
        $rp_realisasi_keuangan = [];
        $rp_realisasi_keuangan_bo_bp = [];
        $rp_realisasi_keuangan_bo_bbj = [];
        $rp_realisasi_keuangan_bo_bs = [];
        $rp_realisasi_keuangan_bo_bh = [];
        $rp_realisasi_keuangan_bm_bmt = [];
        $rp_realisasi_keuangan_bm_bmpm = [];
        $rp_realisasi_keuangan_bm_bmgb = [];
        $rp_realisasi_keuangan_bm_bmjji = [];
        $rp_realisasi_keuangan_bm_bmatl = [];
        $rp_realisasi_keuangan_btt = [];
        $rp_realisasi_keuangan_bt_bbh = [];
        $rp_realisasi_keuangan_bt_bbk = [];

        $t_fisik_jan = 0;
        $t_fisik_feb = 0;
        $t_fisik_mar = 0;
        $t_fisik_apr = 0;
        $t_fisik_mei = 0;
        $t_fisik_jun = 0;
        $t_fisik_jul = 0;
        $t_fisik_agu = 0;
        $t_fisik_sep = 0;
        $t_fisik_okt = 0;
        $t_fisik_nov = 0;
        $t_fisik_des = 0;

        $t_fisik_jan_bulanan = 0;
        $t_fisik_feb_bulanan = 0;
        $t_fisik_mar_bulanan = 0;
        $t_fisik_apr_bulanan = 0;
        $t_fisik_mei_bulanan = 0;
        $t_fisik_jun_bulanan = 0;
        $t_fisik_jul_bulanan = 0;
        $t_fisik_agu_bulanan = 0;
        $t_fisik_sep_bulanan = 0;
        $t_fisik_okt_bulanan = 0;
        $t_fisik_nov_bulanan = 0;
        $t_fisik_des_bulanan = 0;


        $t_keuangan_ratarata_jan = 0;
        $t_keuangan_ratarata_feb = 0;
        $t_keuangan_ratarata_mar = 0;
        $t_keuangan_ratarata_apr = 0;
        $t_keuangan_ratarata_mei = 0;
        $t_keuangan_ratarata_jun = 0;
        $t_keuangan_ratarata_jul = 0;
        $t_keuangan_ratarata_agu = 0;
        $t_keuangan_ratarata_sep = 0;
        $t_keuangan_ratarata_okt = 0;
        $t_keuangan_ratarata_nov = 0;
        $t_keuangan_ratarata_des = 0;

        $t_keuangan_ratarata_jan_bulanan = 0;
        $t_keuangan_ratarata_feb_bulanan = 0;
        $t_keuangan_ratarata_mar_bulanan = 0;
        $t_keuangan_ratarata_apr_bulanan = 0;
        $t_keuangan_ratarata_mei_bulanan = 0;
        $t_keuangan_ratarata_jun_bulanan = 0;
        $t_keuangan_ratarata_jul_bulanan = 0;
        $t_keuangan_ratarata_agu_bulanan = 0;
        $t_keuangan_ratarata_sep_bulanan = 0;
        $t_keuangan_ratarata_okt_bulanan = 0;
        $t_keuangan_ratarata_nov_bulanan = 0;
        $t_keuangan_ratarata_des_bulanan = 0;

        $t_keu_jan   = 0;
        $t_keu_feb   = 0;
        $t_keu_mar   = 0;
        $t_keu_apr   = 0;
        $t_keu_mei   = 0;
        $t_keu_jun   = 0;
        $t_keu_jul   = 0;
        $t_keu_agu   = 0;
        $t_keu_sep   = 0;
        $t_keu_okt   = 0;
        $t_keu_nov   = 0;
        $t_keu_des   = 0;

        $t_keu_bulanan_jan   = 0;
        $t_keu_bulanan_feb   = 0;
        $t_keu_bulanan_mar   = 0;
        $t_keu_bulanan_apr   = 0;
        $t_keu_bulanan_mei   = 0;
        $t_keu_bulanan_jun   = 0;
        $t_keu_bulanan_jul   = 0;
        $t_keu_bulanan_agu   = 0;
        $t_keu_bulanan_sep   = 0;
        $t_keu_bulanan_okt   = 0;
        $t_keu_bulanan_nov   = 0;
        $t_keu_bulanan_des   = 0;

        $t_keu_jan_rp   = 0;
        $t_keu_feb_rp   = 0;
        $t_keu_mar_rp   = 0;
        $t_keu_apr_rp   = 0;
        $t_keu_mei_rp   = 0;
        $t_keu_jun_rp   = 0;
        $t_keu_jul_rp   = 0;
        $t_keu_agu_rp   = 0;
        $t_keu_sep_rp   = 0;
        $t_keu_okt_rp   = 0;
        $t_keu_nov_rp   = 0;
        $t_keu_des_rp   = 0;

        $t_keu_jan_rp_bulanan   = 0;
        $t_keu_feb_rp_bulanan   = 0;
        $t_keu_mar_rp_bulanan   = 0;
        $t_keu_apr_rp_bulanan   = 0;
        $t_keu_mei_rp_bulanan   = 0;
        $t_keu_jun_rp_bulanan   = 0;
        $t_keu_jul_rp_bulanan   = 0;
        $t_keu_agu_rp_bulanan   = 0;
        $t_keu_sep_rp_bulanan   = 0;
        $t_keu_okt_rp_bulanan   = 0;
        $t_keu_nov_rp_bulanan   = 0;
        $t_keu_des_rp_bulanan   = 0;

        $r_jan     = 0;
        $r_feb  = 0;
        $r_mar  = 0;
        $r_apr  = 0;
        $r_mei  = 0;
        $r_jun  = 0;
        $r_jul  = 0;
        $r_agu  = 0;
        $r_sep  = 0;
        $r_okt  = 0;
        $r_nov  = 0;
        $r_des  = 0;

        $rk_rp_jan  = 0;
        $rk_rp_feb  = 0;
        $rk_rp_mar  = 0;
        $rk_rp_apr  = 0;
        $rk_rp_mei  = 0;
        $rk_rp_jun  = 0;
        $rk_rp_jul  = 0;
        $rk_rp_agu  = 0;
        $rk_rp_sep  = 0;
        $rk_rp_okt  = 0;
        $rk_rp_nov  = 0;
        $rk_rp_des  = 0;

        $t_fisik = $this->target_realisasi_model->get_target_fisik($id_instansi, $tahun, $tahap);
        foreach ($t_fisik->result() as $key => $value) {
            $t_fisik_jan += $value->jan;
            $t_fisik_feb += $value->feb;
            $t_fisik_mar += $value->mar;
            $t_fisik_apr += $value->apr;
            $t_fisik_mei += $value->mei;
            $t_fisik_jun += $value->jun;
            $t_fisik_jul += $value->jul;
            $t_fisik_agu += $value->agu;
            $t_fisik_sep += $value->sep;
            $t_fisik_okt += $value->okt;
            $t_fisik_nov += $value->nov;
            $t_fisik_des += $value->des;



            $t_fisik_jan_bulanan += $value->jan_bulanan;
            $t_fisik_feb_bulanan += $value->feb_bulanan;
            $t_fisik_mar_bulanan += $value->mar_bulanan;
            $t_fisik_apr_bulanan += $value->apr_bulanan;
            $t_fisik_mei_bulanan += $value->mei_bulanan;
            $t_fisik_jun_bulanan += $value->jun_bulanan;
            $t_fisik_jul_bulanan += $value->jul_bulanan;
            $t_fisik_agu_bulanan += $value->agu_bulanan;
            $t_fisik_sep_bulanan += $value->sep_bulanan;
            $t_fisik_okt_bulanan += $value->okt_bulanan;
            $t_fisik_nov_bulanan += $value->nov_bulanan;
            $t_fisik_des_bulanan += $value->des_bulanan;
        }
        $t_keuangan_ratarata = $this->target_realisasi_model->get_target_keuangan_ratarata($id_instansi);
        foreach ($t_keuangan_ratarata->result() as $key => $value) {
            $t_keuangan_ratarata_jan += $value->jan;
            $t_keuangan_ratarata_feb += $value->feb;
            $t_keuangan_ratarata_mar += $value->mar;
            $t_keuangan_ratarata_apr += $value->apr;
            $t_keuangan_ratarata_mei += $value->mei;
            $t_keuangan_ratarata_jun += $value->jun;
            $t_keuangan_ratarata_jul += $value->jul;
            $t_keuangan_ratarata_agu += $value->agu;
            $t_keuangan_ratarata_sep += $value->sep;
            $t_keuangan_ratarata_okt += $value->okt;
            $t_keuangan_ratarata_nov += $value->nov;
            $t_keuangan_ratarata_des += $value->des;



            $t_keuangan_ratarata_jan_bulanan += $value->jan_bulanan;
            $t_keuangan_ratarata_feb_bulanan += $value->feb_bulanan;
            $t_keuangan_ratarata_mar_bulanan += $value->mar_bulanan;
            $t_keuangan_ratarata_apr_bulanan += $value->apr_bulanan;
            $t_keuangan_ratarata_mei_bulanan += $value->mei_bulanan;
            $t_keuangan_ratarata_jun_bulanan += $value->jun_bulanan;
            $t_keuangan_ratarata_jul_bulanan += $value->jul_bulanan;
            $t_keuangan_ratarata_agu_bulanan += $value->agu_bulanan;
            $t_keuangan_ratarata_sep_bulanan += $value->sep_bulanan;
            $t_keuangan_ratarata_okt_bulanan += $value->okt_bulanan;
            $t_keuangan_ratarata_nov_bulanan += $value->nov_bulanan;
            $t_keuangan_ratarata_des_bulanan += $value->des_bulanan;
        }


        
        // $t_keuangan = $this->target_realisasi_model->get_persen_target_keuangan($id_instansi);
        // foreach ($t_keuangan->result() as $key => $value) {
        //     $t_keu_jan += $value->jan;
        //     $t_keu_feb += $value->feb;
        //     $t_keu_mar += $value->mar;
        //     $t_keu_apr += $value->apr;
        //     $t_keu_mei += $value->mei;
        //     $t_keu_jun += $value->jun;
        //     $t_keu_jul += $value->jul;
        //     $t_keu_agu += $value->agu;
        //     $t_keu_sep += $value->sep;
        //     $t_keu_okt += $value->okt;
        //     $t_keu_nov += $value->nov;
        //     $t_keu_des += $value->des;



        //     // $t_fisik_jan_bulanan += $value->jan_bulanan;
        //     // $t_fisik_feb_bulanan += $value->feb_bulanan;
        //     // $t_fisik_mar_bulanan += $value->mar_bulanan;
        //     // $t_fisik_apr_bulanan += $value->apr_bulanan;
        //     // $t_fisik_mei_bulanan += $value->mei_bulanan;
        //     // $t_fisik_jun_bulanan += $value->jun_bulanan;
        //     // $t_fisik_jul_bulanan += $value->jul_bulanan;
        //     // $t_fisik_agu_bulanan += $value->agu_bulanan;
        //     // $t_fisik_sep_bulanan += $value->sep_bulanan;
        //     // $t_fisik_okt_bulanan += $value->okt_bulanan;
        //     // $t_fisik_nov_bulanan += $value->nov_bulanan;
        //     // $t_fisik_des_bulanan += $value->des_bulanan;
        // }

        $t_keuangan = $this->target_realisasi_model->get_target_keuangan($id_instansi, $tahun, $tahap);

        foreach ($t_keuangan->result() as $key => $value) {
            $t_keu_jan   += ($value->jan / $t_anggaran->pagu) * 100;
            $t_keu_feb   += ($value->feb / $t_anggaran->pagu) * 100;
            $t_keu_mar   += ($value->mar / $t_anggaran->pagu) * 100;
            $t_keu_apr   += ($value->apr / $t_anggaran->pagu) * 100;
            $t_keu_mei   += ($value->mei / $t_anggaran->pagu) * 100;
            $t_keu_jun   += ($value->jun / $t_anggaran->pagu) * 100;
            $t_keu_jul   += ($value->jul / $t_anggaran->pagu) * 100;
            $t_keu_agu   += ($value->agu / $t_anggaran->pagu) * 100;
            $t_keu_sep   += ($value->sep / $t_anggaran->pagu) * 100;
            $t_keu_okt   += ($value->okt / $t_anggaran->pagu) * 100;
            $t_keu_nov   += ($value->nov / $t_anggaran->pagu) * 100;
            $t_keu_des   += ($value->des / $t_anggaran->pagu) * 100;


            $t_keu_bulanan_jan   += ($value->jan_bulanan / $t_anggaran->pagu) * 100 ; 
            $t_keu_bulanan_feb   += ($value->feb_bulanan / $t_anggaran->pagu) * 100 ; 
            $t_keu_bulanan_mar   += ($value->mar_bulanan / $t_anggaran->pagu) * 100 ; 
            $t_keu_bulanan_apr   += ($value->apr_bulanan / $t_anggaran->pagu) * 100 ; 
            $t_keu_bulanan_mei   += ($value->mei_bulanan / $t_anggaran->pagu) * 100 ; 
            $t_keu_bulanan_jun   += ($value->jun_bulanan / $t_anggaran->pagu) * 100 ; 
            $t_keu_bulanan_jul   += ($value->jul_bulanan / $t_anggaran->pagu) * 100 ; 
            $t_keu_bulanan_agu   += ($value->agu_bulanan / $t_anggaran->pagu) * 100 ; 
            $t_keu_bulanan_sep   += ($value->sep_bulanan / $t_anggaran->pagu) * 100 ; 
            $t_keu_bulanan_okt   += ($value->okt_bulanan / $t_anggaran->pagu) * 100 ; 
            $t_keu_bulanan_nov   += ($value->nov_bulanan / $t_anggaran->pagu) * 100 ; 
            $t_keu_bulanan_des   += ($value->des_bulanan / $t_anggaran->pagu) * 100 ; 


            $t_keu_jan_rp   += $value->jan;
            $t_keu_feb_rp   += $value->feb;
            $t_keu_mar_rp   += $value->mar;
            $t_keu_apr_rp   += $value->apr;
            $t_keu_mei_rp   += $value->mei;
            $t_keu_jun_rp   += $value->jun;
            $t_keu_jul_rp   += $value->jul;
            $t_keu_agu_rp   += $value->agu;
            $t_keu_sep_rp   += $value->sep;
            $t_keu_okt_rp   += $value->okt;
            $t_keu_nov_rp   += $value->nov;
            $t_keu_des_rp   += $value->des;

            $t_keu_jan_rp_bulanan   += $value->jan_bulanan;
            $t_keu_feb_rp_bulanan   += $value->feb_bulanan;
            $t_keu_mar_rp_bulanan   += $value->mar_bulanan;
            $t_keu_apr_rp_bulanan   += $value->apr_bulanan;
            $t_keu_mei_rp_bulanan   += $value->mei_bulanan;
            $t_keu_jun_rp_bulanan   += $value->jun_bulanan;
            $t_keu_jul_rp_bulanan   += $value->jul_bulanan;
            $t_keu_agu_rp_bulanan   += $value->agu_bulanan;
            $t_keu_sep_rp_bulanan   += $value->sep_bulanan;
            $t_keu_okt_rp_bulanan   += $value->okt_bulanan;
            $t_keu_nov_rp_bulanan   += $value->nov_bulanan;
            $t_keu_des_rp_bulanan   += $value->des_bulanan;
        }

        $r_keuangan = $this->target_realisasi_model->get_realisasi_keuangan($id_instansi, $kode_tahap, $tahun);
        foreach ($r_keuangan->result() as $key => $value) {
            $r_jan  += (($value->jan / $t_anggaran->pagu) * 100);
            $r_feb  += (($value->feb / $t_anggaran->pagu) * 100);
            $r_mar  += (($value->mar / $t_anggaran->pagu) * 100);
            $r_apr  += (($value->apr / $t_anggaran->pagu) * 100);
            $r_mei  += (($value->mei / $t_anggaran->pagu) * 100);
            $r_jun  += (($value->jun / $t_anggaran->pagu) * 100);
            $r_jul  += (($value->jul / $t_anggaran->pagu) * 100);
            $r_agu  += (($value->agu / $t_anggaran->pagu) * 100);
            $r_sep  += (($value->sep / $t_anggaran->pagu) * 100);
            $r_okt  += (($value->okt / $t_anggaran->pagu) * 100);
            $r_nov  += (($value->nov / $t_anggaran->pagu) * 100);
            $r_des  += (($value->des / $t_anggaran->pagu) * 100);


            $rk_rp_jan  += ($value->jan);
            $rk_rp_feb  += ($value->feb);
            $rk_rp_mar  += ($value->mar);
            $rk_rp_apr  += ($value->apr);
            $rk_rp_mei  += ($value->mei);
            $rk_rp_jun  += ($value->jun);
            $rk_rp_jul  += ($value->jul);
            $rk_rp_agu  += ($value->agu);
            $rk_rp_sep  += ($value->sep);
            $rk_rp_okt  += ($value->okt);
            $rk_rp_nov  += ($value->nov);
            $rk_rp_des  += ($value->des);
        }

        $target_fisik[] = $t_fisik_jan >100 ? 100 : $t_fisik_jan;
        $target_fisik[] = $t_fisik_feb >100 ? 100 : $t_fisik_feb;
        $target_fisik[] = $t_fisik_mar >100 ? 100 : $t_fisik_mar;
        $target_fisik[] = $t_fisik_apr >100 ? 100 : $t_fisik_apr;
        $target_fisik[] = $t_fisik_mei >100 ? 100 : $t_fisik_mei;
        $target_fisik[] = $t_fisik_jun >100 ? 100 : $t_fisik_jun;
        $target_fisik[] = $t_fisik_jul >100 ? 100 : $t_fisik_jul;
        $target_fisik[] = $t_fisik_agu >100 ? 100 : $t_fisik_agu;
        $target_fisik[] = $t_fisik_sep >100 ? 100 : $t_fisik_sep;
        $target_fisik[] = $t_fisik_okt >100 ? 100 : $t_fisik_okt;
        $target_fisik[] = $t_fisik_nov >100 ? 100 : $t_fisik_nov;
        $target_fisik[] = $t_fisik_des >100 ? 100 : $t_fisik_des;

        $target_fisik_bulanan[] = $t_fisik_jan_bulanan >100 ? 100 : $t_fisik_jan_bulanan;
        $target_fisik_bulanan[] = $t_fisik_feb_bulanan >100 ? 100 : $t_fisik_feb_bulanan;
        $target_fisik_bulanan[] = $t_fisik_mar_bulanan >100 ? 100 : $t_fisik_mar_bulanan;
        $target_fisik_bulanan[] = $t_fisik_apr_bulanan >100 ? 100 : $t_fisik_apr_bulanan;
        $target_fisik_bulanan[] = $t_fisik_mei_bulanan >100 ? 100 : $t_fisik_mei_bulanan;
        $target_fisik_bulanan[] = $t_fisik_jun_bulanan >100 ? 100 : $t_fisik_jun_bulanan;
        $target_fisik_bulanan[] = $t_fisik_jul_bulanan >100 ? 100 : $t_fisik_jul_bulanan;
        $target_fisik_bulanan[] = $t_fisik_agu_bulanan >100 ? 100 : $t_fisik_agu_bulanan;
        $target_fisik_bulanan[] = $t_fisik_sep_bulanan >100 ? 100 : $t_fisik_sep_bulanan;
        $target_fisik_bulanan[] = $t_fisik_okt_bulanan >100 ? 100 : $t_fisik_okt_bulanan;
        $target_fisik_bulanan[] = $t_fisik_nov_bulanan >100 ? 100 : $t_fisik_nov_bulanan;
        $target_fisik_bulanan[] = $t_fisik_des_bulanan >100 ? 100 : $t_fisik_des_bulanan;

         $target_keuangan[] = $t_keu_jan>100 ? 100 : $t_keu_jan;
        $target_keuangan[] = $t_keu_feb>100 ? 100 : $t_keu_feb;
        $target_keuangan[] = $t_keu_mar>100 ? 100 : $t_keu_mar;
        $target_keuangan[] = $t_keu_apr>100 ? 100 : $t_keu_apr;
        $target_keuangan[] = $t_keu_mei>100 ? 100 : $t_keu_mei;
        $target_keuangan[] = $t_keu_jun>100 ? 100 : $t_keu_jun;
        $target_keuangan[] = $t_keu_jul>100 ? 100 : $t_keu_jul;
        $target_keuangan[] = $t_keu_agu>100 ? 100 : $t_keu_agu;
        $target_keuangan[] = $t_keu_sep>100 ? 100 : $t_keu_sep;
        $target_keuangan[] = $t_keu_okt>100 ? 100 : $t_keu_okt;
        $target_keuangan[] = $t_keu_nov>100 ? 100 : $t_keu_nov;
        $target_keuangan[] = $t_keu_des >100 ? 100 : $t_keu_des;


        $target_keuangan_ratarata_bulanan[] = $t_keuangan_ratarata_jan_bulanan >100 ? 100 : $t_keuangan_ratarata_jan_bulanan;
        $target_keuangan_ratarata_bulanan[] = $t_keuangan_ratarata_feb_bulanan >100 ? 100 : $t_keuangan_ratarata_feb_bulanan;
        $target_keuangan_ratarata_bulanan[] = $t_keuangan_ratarata_mar_bulanan >100 ? 100 : $t_keuangan_ratarata_mar_bulanan;
        $target_keuangan_ratarata_bulanan[] = $t_keuangan_ratarata_apr_bulanan >100 ? 100 : $t_keuangan_ratarata_apr_bulanan;
        $target_keuangan_ratarata_bulanan[] = $t_keuangan_ratarata_mei_bulanan >100 ? 100 : $t_keuangan_ratarata_mei_bulanan;
        $target_keuangan_ratarata_bulanan[] = $t_keuangan_ratarata_jun_bulanan >100 ? 100 : $t_keuangan_ratarata_jun_bulanan;
        $target_keuangan_ratarata_bulanan[] = $t_keuangan_ratarata_jul_bulanan >100 ? 100 : $t_keuangan_ratarata_jul_bulanan;
        $target_keuangan_ratarata_bulanan[] = $t_keuangan_ratarata_agu_bulanan >100 ? 100 : $t_keuangan_ratarata_agu_bulanan;
        $target_keuangan_ratarata_bulanan[] = $t_keuangan_ratarata_sep_bulanan >100 ? 100 : $t_keuangan_ratarata_sep_bulanan;
        $target_keuangan_ratarata_bulanan[] = $t_keuangan_ratarata_okt_bulanan >100 ? 100 : $t_keuangan_ratarata_okt_bulanan;
        $target_keuangan_ratarata_bulanan[] = $t_keuangan_ratarata_nov_bulanan >100 ? 100 : $t_keuangan_ratarata_nov_bulanan;
        $target_keuangan_ratarata_bulanan[] = $t_keuangan_ratarata_des_bulanan >100 ? 100 : $t_keuangan_ratarata_des_bulanan;


// t_keuangan_ratarata_nov
        $target_keuangan_ratarata[] = $t_keuangan_ratarata_jan >100 ? 100 : $t_keuangan_ratarata_jan;
        $target_keuangan_ratarata[] = $t_keuangan_ratarata_feb >100 ? 100 : $t_keuangan_ratarata_feb;
        $target_keuangan_ratarata[] = $t_keuangan_ratarata_mar >100 ? 100 : $t_keuangan_ratarata_mar;
        $target_keuangan_ratarata[] = $t_keuangan_ratarata_apr >100 ? 100 : $t_keuangan_ratarata_apr;
        $target_keuangan_ratarata[] = $t_keuangan_ratarata_mei >100 ? 100 : $t_keuangan_ratarata_mei;
        $target_keuangan_ratarata[] = $t_keuangan_ratarata_jun >100 ? 100 : $t_keuangan_ratarata_jun;
        $target_keuangan_ratarata[] = $t_keuangan_ratarata_jul >100 ? 100 : $t_keuangan_ratarata_jul;
        $target_keuangan_ratarata[] = $t_keuangan_ratarata_agu >100 ? 100 : $t_keuangan_ratarata_agu;
        $target_keuangan_ratarata[] = $t_keuangan_ratarata_sep >100 ? 100 : $t_keuangan_ratarata_sep;
        $target_keuangan_ratarata[] = $t_keuangan_ratarata_okt >100 ? 100 : $t_keuangan_ratarata_okt;
        $target_keuangan_ratarata[] = $t_keuangan_ratarata_nov >100 ? 100 : $t_keuangan_ratarata_nov;
        $target_keuangan_ratarata[] = $t_keuangan_ratarata_des >100 ? 100 : $t_keuangan_ratarata_des;


         $target_keuangan_bulanan[] = $t_keu_bulanan_jan>100 ? 100 : $t_keu_bulanan_jan;
        $target_keuangan_bulanan[] = $t_keu_bulanan_feb>100 ? 100 : $t_keu_bulanan_feb;
        $target_keuangan_bulanan[] = $t_keu_bulanan_mar>100 ? 100 : $t_keu_bulanan_mar;
        $target_keuangan_bulanan[] = $t_keu_bulanan_apr>100 ? 100 : $t_keu_bulanan_apr;
        $target_keuangan_bulanan[] = $t_keu_bulanan_mei>100 ? 100 : $t_keu_bulanan_mei;
        $target_keuangan_bulanan[] = $t_keu_bulanan_jun>100 ? 100 : $t_keu_bulanan_jun;
        $target_keuangan_bulanan[] = $t_keu_bulanan_jul>100 ? 100 : $t_keu_bulanan_jul;
        $target_keuangan_bulanan[] = $t_keu_bulanan_agu>100 ? 100 : $t_keu_bulanan_agu;
        $target_keuangan_bulanan[] = $t_keu_bulanan_sep>100 ? 100 : $t_keu_bulanan_sep;
        $target_keuangan_bulanan[] = $t_keu_bulanan_okt>100 ? 100 : $t_keu_bulanan_okt;
        $target_keuangan_bulanan[] = $t_keu_bulanan_nov>100 ? 100 : $t_keu_bulanan_nov;
        $target_keuangan_bulanan[] = $t_keu_bulanan_des >100 ? 100 : $t_keu_bulanan_des;

         $target_keuangan_rp[] = $t_keu_jan_rp;
        $target_keuangan_rp[] = $t_keu_feb_rp;
        $target_keuangan_rp[] = $t_keu_mar_rp;
        $target_keuangan_rp[] = $t_keu_apr_rp;
        $target_keuangan_rp[] = $t_keu_mei_rp;
        $target_keuangan_rp[] = $t_keu_jun_rp;
        $target_keuangan_rp[] = $t_keu_jul_rp;
        $target_keuangan_rp[] = $t_keu_agu_rp;
        $target_keuangan_rp[] = $t_keu_sep_rp;
        $target_keuangan_rp[] = $t_keu_okt_rp;
        $target_keuangan_rp[] = $t_keu_nov_rp;
        $target_keuangan_rp[] = $t_keu_des_rp;

         $target_keuangan_rp_bulanan[] = $t_keu_jan_rp_bulanan;
        $target_keuangan_rp_bulanan[] = $t_keu_feb_rp_bulanan;
        $target_keuangan_rp_bulanan[] = $t_keu_mar_rp_bulanan;
        $target_keuangan_rp_bulanan[] = $t_keu_apr_rp_bulanan;
        $target_keuangan_rp_bulanan[] = $t_keu_mei_rp_bulanan;
        $target_keuangan_rp_bulanan[] = $t_keu_jun_rp_bulanan;
        $target_keuangan_rp_bulanan[] = $t_keu_jul_rp_bulanan;
        $target_keuangan_rp_bulanan[] = $t_keu_agu_rp_bulanan;
        $target_keuangan_rp_bulanan[] = $t_keu_sep_rp_bulanan;
        $target_keuangan_rp_bulanan[] = $t_keu_okt_rp_bulanan;
        $target_keuangan_rp_bulanan[] = $t_keu_nov_rp_bulanan;
        $target_keuangan_rp_bulanan[] = $t_keu_des_rp_bulanan;

        $realisasi_fisik[] = $this->realisasi_fisik($id_instansi, $tahap);
        $realisasi_fisik_bulanan[] = $this->realisasi_fisik_bulanan($id_instansi, $tahap);
        // $realisasi_keuangan_ratarata[] = $this->realisasi_keuangan_ratarata($id_instansi);


        for ($i=1; $i <= 12 ; $i++) { 
            $rk = $this->target_realisasi_model->realisasi_keuangan($id_instansi, $i, '<=', $tahun, $tahap);
            @$realisasi_keuangan[]    = ($rk->realisasi_keuangan / $t_anggaran->pagu) * 100;
            @$rp_realisasi_keuangan[]    = ($rk->realisasi_keuangan);

            @$rp_realisasi_keuangan_bo_bp[]    = ($rk->realisasi_keuangan_bo_bp);
            @$rp_realisasi_keuangan_bo_bbj[]    = ($rk->realisasi_keuangan_bo_bbj);
            @$rp_realisasi_keuangan_bo_bs[]    = ($rk->realisasi_keuangan_bo_bs);
            @$rp_realisasi_keuangan_bo_bh[]    = ($rk->realisasi_keuangan_bo_bh);
            @$rp_realisasi_keuangan_bm_bmt[]    = ($rk->realisasi_keuangan_bm_bmt);
            @$rp_realisasi_keuangan_bm_bmpm[]    = ($rk->realisasi_keuangan_bm_bmpm);
            @$rp_realisasi_keuangan_bm_bmgb[]    = ($rk->realisasi_keuangan_bm_bmgb);
            @$rp_realisasi_keuangan_bm_bmjji[]    = ($rk->realisasi_keuangan_bm_bmjji);
            @$rp_realisasi_keuangan_bm_bmatl[]    = ($rk->realisasi_keuangan_bm_bmatl);
            @$rp_realisasi_keuangan_btt[]    = ($rk->realisasi_keuangan_btt);
            @$rp_realisasi_keuangan_bt_bbh[]    = ($rk->realisasi_keuangan_bt_bbh);
            @$rp_realisasi_keuangan_bt_bbk[]    = ($rk->realisasi_keuangan_bt_bbk);


            
            $rk_bulanan = $this->target_realisasi_model->realisasi_keuangan($id_instansi, $i, '=', $tahun, $tahap);
            @$realisasi_keuangan_bulanan[]    = ($rk_bulanan->realisasi_keuangan / $t_anggaran->pagu) * 100;
            @$rp_realisasi_keuangan_bulanan[]    = ($rk_bulanan->realisasi_keuangan);
            @$rp_realisasi_keuangan_bulanan_bo_bp[]    = ($rk_bulanan->realisasi_keuangan_bo_bp);
            @$rp_realisasi_keuangan_bulanan_bo_bbj[]    = ($rk_bulanan->realisasi_keuangan_bo_bbj);
            @$rp_realisasi_keuangan_bulanan_bo_bs[]    = ($rk_bulanan->realisasi_keuangan_bo_bs);
            @$rp_realisasi_keuangan_bulanan_bo_bh[]    = ($rk_bulanan->realisasi_keuangan_bo_bh);
            @$rp_realisasi_keuangan_bulanan_bm_bmt[]    = ($rk_bulanan->realisasi_keuangan_bm_bmt);
            @$rp_realisasi_keuangan_bulanan_bm_bmpm[]    = ($rk_bulanan->realisasi_keuangan_bm_bmpm);
            @$rp_realisasi_keuangan_bulanan_bm_bmgb[]    = ($rk_bulanan->realisasi_keuangan_bm_bmgb);
            @$rp_realisasi_keuangan_bulanan_bm_bmjji[]    = ($rk_bulanan->realisasi_keuangan_bm_bmjji);
            @$rp_realisasi_keuangan_bulanan_bm_bmatl[]    = ($rk_bulanan->realisasi_keuangan_bm_bmatl);
            @$rp_realisasi_keuangan_bulanan_btt[]    = ($rk_bulanan->realisasi_keuangan_btt);
            @$rp_realisasi_keuangan_bulanan_bt_bbh[]    = ($rk_bulanan->realisasi_keuangan_bt_bbh);
            @$rp_realisasi_keuangan_bulanan_bt_bbk[]    = ($rk_bulanan->realisasi_keuangan_bt_bbk);
        }
        // $realisasi_keuangan[]    = $r_jan > 0 ? $r_jan : 0;
        // $realisasi_keuangan[]    = $r_feb > 0 ? ROUND($r_feb + $realisasi_keuangan[0], 2) : $realisasi_keuangan[0];
        // $realisasi_keuangan[]    = $r_mar > 0 ? ROUND($r_mar + $realisasi_keuangan[1], 2) : $realisasi_keuangan[1];
        // $realisasi_keuangan[]    = $r_apr > 0 ? ROUND($r_apr + $realisasi_keuangan[2], 2) : $realisasi_keuangan[2];
        // $realisasi_keuangan[]    = $r_mei > 0 ? ROUND($r_mei + $realisasi_keuangan[3], 2) : $realisasi_keuangan[3];
        // $realisasi_keuangan[]    = $r_jun > 0 ? ROUND($r_jun + $realisasi_keuangan[4], 2) : $realisasi_keuangan[4];
        // $realisasi_keuangan[]    = $r_jul > 0 ? ROUND($r_jul + $realisasi_keuangan[5], 2) : $realisasi_keuangan[5];
        // $realisasi_keuangan[]    = $r_agu > 0 ? ROUND($r_agu + $realisasi_keuangan[6], 2) : $realisasi_keuangan[6];
        // $realisasi_keuangan[]    = $r_sep > 0 ? ROUND($r_sep + $realisasi_keuangan[7], 2) : $realisasi_keuangan[7];
        // $realisasi_keuangan[]    = $r_okt > 0 ? ROUND($r_okt + $realisasi_keuangan[8], 2) : $realisasi_keuangan[8];
        // $realisasi_keuangan[]    = $r_nov > 0 ? ROUND($r_nov + $realisasi_keuangan[9], 2) : $realisasi_keuangan[9];
        // $realisasi_keuangan[]    = $r_des > 0 ? ROUND($r_des + $realisasi_keuangan[10], 2) : $realisasi_keuangan[10];

        $data = [];
        foreach ($target_fisik as $key => $value) {
            $data[] = array(
                'id_instansi' => $id_instansi,
                'bulan' => $key + 1,
                'kode_tahap' => $kode_tahap,
                'tahun' => $tahun,
                
                'target_fisik_akumulasi' => $target_fisik[$key],
                'target_fisik_akumulasi_ratarata' => $target_fisik[$key],
                'target_fisik_bulanan' => $target_fisik_bulanan[$key],
                'target_fisik_bulanan_ratarata' => $target_fisik_bulanan[$key],


                'target_keuangan_akumulasi' => $target_keuangan[$key],
                'target_keuangan_akumulasi_ratarata' => $target_keuangan_ratarata[$key],
                'target_keuangan_bulanan' => $target_keuangan_bulanan[$key],
                'target_keuangan_bulanan_ratarata' => $target_keuangan_ratarata_bulanan[$key],

                'realisasi_keuangan_akumulasi' => $realisasi_keuangan[$key],
                'realisasi_keuangan_bulanan' => $realisasi_keuangan_bulanan[$key],


                //bagian yang nan nan NAN

                'realisasi_fisik_akumulasi' => $realisasi_fisik[0][$key],
                'realisasi_fisik_akumulasi_ratarata' => $realisasi_fisik[0][$key],

                'realisasi_fisik_bulanan' => $realisasi_fisik_bulanan[0][$key],
                'realisasi_fisik_bulanan_ratarata' => $realisasi_fisik_bulanan[0][$key],

                'rp_target_keuangan_akumulasi' => $target_keuangan_rp[$key],
                'rp_target_keuangan_bulanan' => $target_keuangan_rp_bulanan[$key],
                // 'realisasi_keuangan_akumulasi_ratarata' => $realisasi_keuangan_ratarata[0][0][$key],
                // 'realisasi_keuangan_bulanan_ratarata' => $realisasi_keuangan_ratarata[0][1][$key],
                //bagian yang nan nan NAN



                'pagu_total' => $t_anggaran->pagu,
                'pagu_bo_bp' => $t_anggaran->pagu_bo_bp,
                'pagu_bo_bbj' => $t_anggaran->pagu_bo_bbj,
                'pagu_bo_bs' => $t_anggaran->pagu_bo_bs,
                'pagu_bo_bh' => $t_anggaran->pagu_bo_bh,
                'pagu_bm_bmt' => $t_anggaran->pagu_bm_bmt,
                'pagu_bm_bmpm' => $t_anggaran->pagu_bm_bmpm,
                'pagu_bm_bmgb' => $t_anggaran->pagu_bm_bmgb,
                'pagu_bm_bmjji' => $t_anggaran->pagu_bm_bmjji,
                'pagu_bm_bmatl' => $t_anggaran->pagu_bm_bmatl,
                'pagu_btt' => $t_anggaran->pagu_btt,
                'pagu_bt_bbh' => $t_anggaran->pagu_bt_bbh,
                'pagu_bt_bbk' => $t_anggaran->pagu_bt_bbk,


                'rp_realisasi_keuangan_akumulasi' => $rp_realisasi_keuangan[$key],
                'rp_realisasi_keuangan_akumulasi_bo_bp' => $rp_realisasi_keuangan_bo_bp[$key],
                'rp_realisasi_keuangan_akumulasi_bo_bbj' => $rp_realisasi_keuangan_bo_bbj[$key],
                'rp_realisasi_keuangan_akumulasi_bo_bs' => $rp_realisasi_keuangan_bo_bs[$key],
                'rp_realisasi_keuangan_akumulasi_bo_bh' => $rp_realisasi_keuangan_bo_bh[$key],
                'rp_realisasi_keuangan_akumulasi_bm_bmt' => $rp_realisasi_keuangan_bm_bmt[$key],
                'rp_realisasi_keuangan_akumulasi_bm_bmpm' => $rp_realisasi_keuangan_bm_bmpm[$key],
                'rp_realisasi_keuangan_akumulasi_bm_bmgb' => $rp_realisasi_keuangan_bm_bmgb[$key],
                'rp_realisasi_keuangan_akumulasi_bm_bmjji' => $rp_realisasi_keuangan_bm_bmjji[$key],
                'rp_realisasi_keuangan_akumulasi_bm_bmatl' => $rp_realisasi_keuangan_bm_bmatl[$key],
                'rp_realisasi_keuangan_akumulasi_btt' => $rp_realisasi_keuangan_btt[$key],
                'rp_realisasi_keuangan_akumulasi_bt_bbh' => $rp_realisasi_keuangan_bt_bbh[$key],
                'rp_realisasi_keuangan_akumulasi_bt_bbk' => $rp_realisasi_keuangan_bt_bbk[$key],


                'rp_realisasi_keuangan_bulanan' => $rp_realisasi_keuangan_bulanan[$key],
                'rp_realisasi_keuangan_bulanan_bo_bp' => $rp_realisasi_keuangan_bulanan_bo_bp[$key],
                'rp_realisasi_keuangan_bulanan_bo_bbj' => $rp_realisasi_keuangan_bulanan_bo_bbj[$key],
                'rp_realisasi_keuangan_bulanan_bo_bs' => $rp_realisasi_keuangan_bulanan_bo_bs[$key],
                'rp_realisasi_keuangan_bulanan_bo_bh' => $rp_realisasi_keuangan_bulanan_bo_bh[$key],
                'rp_realisasi_keuangan_bulanan_bm_bmt' => $rp_realisasi_keuangan_bulanan_bm_bmt[$key],
                'rp_realisasi_keuangan_bulanan_bm_bmpm' => $rp_realisasi_keuangan_bulanan_bm_bmpm[$key],
                'rp_realisasi_keuangan_bulanan_bm_bmgb' => $rp_realisasi_keuangan_bulanan_bm_bmgb[$key],
                'rp_realisasi_keuangan_bulanan_bm_bmjji' => $rp_realisasi_keuangan_bulanan_bm_bmjji[$key],
                'rp_realisasi_keuangan_bulanan_bm_bmatl' => $rp_realisasi_keuangan_bulanan_bm_bmatl[$key],
                'rp_realisasi_keuangan_bulanan_btt' => $rp_realisasi_keuangan_bulanan_btt[$key],
                'rp_realisasi_keuangan_bulanan_bt_bbh' => $rp_realisasi_keuangan_bulanan_bt_bbh[$key],
                'rp_realisasi_keuangan_bulanan_bt_bbk' => $rp_realisasi_keuangan_bulanan_bt_bbk[$key],

                'last_update' => timestamp()
            );
        }

        $result = $this->db->insert_batch('grafik', $data);

        $output = [];
        $output['status'] = true;

        echo json_encode($output);
    }

  
  
    public function realisasi_fisik($id_instansi, $kode_tahap)
    {
        $realisasi_fisik = [];
        $total_fisik_bulan = [];
        // $kegiatan = $this->target_realisasi_model->get_kode_rekening_kegiatan($id_instansi);
        $no = 1;
        $tampung_kegiatan_berpagu = [];
        $tahun = tahun_anggaran();
        $tahap = $kode_tahap;//tahapan_apbd();
        $kegiatan = $this->target_realisasi_model->all_kegiatan($id_instansi, $tahun, $tahap);
        $ope = '<=';
        for ($a=1; $a <=12 ; $a++) { 
        	$bulan = $a;
            $no_sub_kegiatan = 0;
            $total_sub_kegiatan = 0;
            $total_fisik_semua =0;
			foreach ($kegiatan as $key => $value_sk) {
		    	$total_sub_kegiatan +=1;
				$no_sub_kegiatan++;   
				$nama_sub_kegiatan = $value_sk->nama_sub_kegiatan;
				$total_paket = $this->realisasi_akumulasi_model->get_total_paket($id_instansi, $value_sk->kode_rekening_sub_kegiatan, $tahun, $tahap)->num_rows();
				$jenis_rutin = $this->realisasi_akumulasi_model->get_total_paket_perjenis($id_instansi, $value_sk->kode_rekening_sub_kegiatan, "RUTIN", $tahun, $tahap)->num_rows();
				$swa = $this->realisasi_akumulasi_model->get_realisasi_fisik($id_instansi, $value_sk->kode_rekening_sub_kegiatan, $bulan, 'SWAKELOLA', $ope, $tahun, $tahap)->row_array();
				$pen = $this->realisasi_akumulasi_model->get_realisasi_fisik($id_instansi, $value_sk->kode_rekening_sub_kegiatan, $bulan, 'PENYEDIA', $ope, $tahun, $tahap)->row_array();
				$bulan_mulai = mulai_realisasi_instansi($id_instansi);
				$bulan_akhir = akhir_realisasi_instansi($id_instansi);
				$lama_realisasi = $bulan_akhir - $bulan_mulai +1;
				$realisasi_rutin_bulan = [];
				$ke = 0;
	          for ($i=$bulan_mulai; $i <= $bulan_akhir ; $i++) { 
	            $ke++;
	            $bulan_realisasi = $bulan_mulai + $i;
	            $push = [
	              $i=> ($ke / $lama_realisasi) * 100
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
            $total_fisik = ($swa_tot + $pen_tot + $rut_tot) / $total_paket;
          } else {
            $total_fisik = 0;
          }
          $total_fisik    = $total_fisik > 100 ? 100 : $total_fisik;
      $total_fisik_semua +=$total_fisik;
       
        } //akhir foreach ($sub_kegiatan as $key => $value_sk)



        @$ratarata_realisasi_fisik = $total_fisik_semua / $total_sub_kegiatan;
 
		array_push($realisasi_fisik, round($ratarata_realisasi_fisik,2));
		}

		// echo json_encode($realisasi_fisik);
		return $realisasi_fisik;
                
}

  
    public function realisasi_fisik_bulanan($id_instansi, $kode_tahap)
    {
        $realisasi_fisik = [];
        $total_fisik_bulan = [];
        // $kegiatan = $this->target_realisasi_model->get_kode_rekening_kegiatan($id_instansi);
        $no = 1;
        $tampung_kegiatan_berpagu = [];
        $tahun = tahun_anggaran();
        $tahap = $kode_tahap;//tahapan_apbd();
        $kegiatan = $this->target_realisasi_model->all_kegiatan($id_instansi, $tahun, $tahap);
        $ope = '=';
        for ($a=1; $a <=12 ; $a++) { 
        	$bulan = $a;
            $no_sub_kegiatan = 0;
            $total_sub_kegiatan = 0;
            $total_fisik_semua =0;
			foreach ($kegiatan as $key => $value_sk) {
		    	$total_sub_kegiatan +=1;
				$no_sub_kegiatan++;   
				$nama_sub_kegiatan = $value_sk->nama_sub_kegiatan;
				$total_paket = $this->realisasi_akumulasi_model->get_total_paket($id_instansi, $value_sk->kode_rekening_sub_kegiatan, $tahun, $tahap)->num_rows();
				$jenis_rutin = $this->realisasi_akumulasi_model->get_total_paket_perjenis($id_instansi, $value_sk->kode_rekening_sub_kegiatan, "RUTIN", $tahun, $tahap)->num_rows();
				$swa = $this->realisasi_akumulasi_model->get_realisasi_fisik($id_instansi, $value_sk->kode_rekening_sub_kegiatan, $bulan, 'SWAKELOLA', $ope, $tahun, $tahap)->row_array();
				$pen = $this->realisasi_akumulasi_model->get_realisasi_fisik($id_instansi, $value_sk->kode_rekening_sub_kegiatan, $bulan, 'PENYEDIA', $ope, $tahun, $tahap)->row_array();
				$bulan_mulai = mulai_realisasi_instansi($id_instansi);
				$bulan_akhir = akhir_realisasi_instansi($id_instansi);
				$lama_realisasi = $bulan_akhir - $bulan_mulai +1;
				$realisasi_rutin_bulan = [];
				$ke = 0;
	          for ($i=$bulan_mulai; $i <= $bulan_akhir ; $i++) { 
	            $ke++;
	            $bulan_realisasi = $bulan_mulai + $i;
	            $push = [
	              $i=> ($ke / $lama_realisasi) * 100
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
               $realisasi_rutin = (1/$lama_realisasi) *100; ;//$realisasi_rutin = $realisasi_rutin_bulan[$selisih_bulan][$bulan];
            }
          $rut = $jenis_rutin > 0 ? ($jenis_rutin * $realisasi_rutin) : 0;
          $swa_tot  = !empty($swa['total']) ? $swa['total'] : 0;
          $pen_tot  = !empty($pen['total']) ? $pen['total'] : 0;
          $rut_tot  = !empty($rut) ? $rut : 0;
          if ($total_paket != 0) {
            $total_fisik = ($swa_tot + $pen_tot + $rut_tot) / $total_paket;
          } else {
            $total_fisik = 0;
          }
          $total_fisik    = $total_fisik > 100 ? 100 : $total_fisik;
      $total_fisik_semua +=$total_fisik;
       
        } //akhir foreach ($sub_kegiatan as $key => $value_sk)



        @$ratarata_realisasi_fisik = $total_fisik_semua / $total_sub_kegiatan;
 
		array_push($realisasi_fisik, round($ratarata_realisasi_fisik,2));
		}

// echo json_encode($realisasi_fisik);
return $realisasi_fisik;
                
}


    // public function realisasi_fisik($id_instansi)
    // {
    //     $realisasi_fisik = [];
    //     $total_fisik_bulan = [];

    //     // $kegiatan = $this->target_realisasi_model->get_kode_rekening_kegiatan($id_instansi);
    //     $kegiatan = $this->target_realisasi_model->all_kegiatan($id_instansi);
      
    //     $no = 1;
    //     $tampung_kegiatan_berpagu = [];
    //     foreach ($kegiatan as $key => $value) {
    //             if ($value->pagu >0) {
    //                 $satu = 1;
    //             }else{
    //                 $satu = 0;
    //             }

    //             array_push($tampung_kegiatan_berpagu, $satu);


    //         $total_paket    = $this->target_realisasi_model->total_paket($id_instansi, $value->kode_rekening_sub_kegiatan)->num_rows();
    //         $jenis_swakelola    = $this->target_realisasi_model->total_paket_perjenis($id_instansi, $value->kode_rekening_sub_kegiatan, 'SWAKELOLA')->num_rows();
    //         $jenis_penyedia    = $this->target_realisasi_model->total_paket_perjenis($id_instansi, $value->kode_rekening_sub_kegiatan, 'PENYEDIA')->num_rows();
    //         $jenis_rutin    = $this->target_realisasi_model->total_paket_perjenis($id_instansi, $value->kode_rekening_sub_kegiatan, 'RUTIN')->num_rows();
	 
           
 
		  //       // echo "<pre>".print_r($swakelola)."</pre>";
    //         for ($i = 1; $i <= 12; $i++) {

    //             $swakelola      = $this->target_realisasi_model->persentase($value->kode_rekening_sub_kegiatan, 'SWAKELOLA', $i)->num_rows() == '' ? 0 : $this->target_realisasi_model->persentase($value->kode_rekening_sub_kegiatan, 'SWAKELOLA', $i)->row()->total;
    //             $penyedia       = $this->target_realisasi_model->persentase($value->kode_rekening_sub_kegiatan, 'PENYEDIA', $i)->num_rows() == '' ? 0 : $this->target_realisasi_model->persentase($value->kode_rekening_sub_kegiatan, 'PENYEDIA', $i)->row()->total;


    //             //  if ($value->pagu > 0 ) {
    //             //     $rutin          = $jenis_rutin == '' ? 0 : ($jenis_rutin   * $this->rutin($i, $id_instansi)) ;
    //             // }else{
    //             //     $rutin          = 0;//$jenis_rutin == '' ? 0 : ($jenis_rutin   * $this->rutin($i, $id_instansi)) ;
    //             // }
    //                 $rutin          = $jenis_rutin == '' ? 0 : ($jenis_rutin   * $this->rutin($i, $id_instansi)) ;
                    

             

    //             $total_fisik_perkegiatan = ($swakelola + $penyedia + $rutin); 
    //             @$ratarata_fisik = $total_fisik_perkegiatan / $total_paket;
        		




    //             if ($swakelola + $penyedia + $rutin == 0) {
    //                 $total_fisik = 0;
    //             } else {
    //             	if ($total_paket==0) {
	   //                  $total_fisik = 0;
    //             	}else{
	   //                 $total_fisik = ROUND(($swakelola + $penyedia + $rutin) / $total_paket, 2);
    //             	}
    //             }
    //             $total_fisik  = ROUND($total_fisik, 2) > 100 ? 100 : ROUND($total_fisik, 2);

    //             $total_fisik_bulan[$i][] = $total_fisik;
    //         }
    //     }



    //     if (empty($total_fisik_bulan)) :
    //         $fisik_array[] = 0;
    //     else :
    //         for ($i = 1; $i <= 12; $i++) {
    //             $fisik_array[] = ROUND(array_sum($total_fisik_bulan[$i]) / count($tampung_kegiatan_berpagu), 2);
    //         }
    //     endif;


    //     $realisasi_fisik[] = (!empty($fisik_array[0]) and $fisik_array[0] > 0) ? $fisik_array[0] : 0;
    //     $realisasi_fisik[] = (!empty($fisik_array[1]) and $fisik_array[1] > 0) ? $fisik_array[1] : 0;
    //     $realisasi_fisik[] = (!empty($fisik_array[2]) and $fisik_array[2] > 0) ? $fisik_array[2] : 0;
    //     $realisasi_fisik[] = (!empty($fisik_array[3]) and $fisik_array[3] > 0) ? $fisik_array[3] : 0;
    //     $realisasi_fisik[] = (!empty($fisik_array[4]) and $fisik_array[4] > 0) ? $fisik_array[4] : 0;
    //     $realisasi_fisik[] = (!empty($fisik_array[5]) and $fisik_array[5] > 0) ? $fisik_array[5] : 0;
    //     $realisasi_fisik[] = (!empty($fisik_array[6]) and $fisik_array[6] > 0) ? $fisik_array[6] : 0;
    //     $realisasi_fisik[] = (!empty($fisik_array[7]) and $fisik_array[7] > 0) ? $fisik_array[7] : 0;
    //     $realisasi_fisik[] = (!empty($fisik_array[8]) and $fisik_array[8] > 0) ? $fisik_array[8] : 0;
    //     $realisasi_fisik[] = (!empty($fisik_array[9]) and $fisik_array[9] > 0) ? $fisik_array[9] : 0;
    //     $realisasi_fisik[] = (!empty($fisik_array[10]) and $fisik_array[10] > 0) ? $fisik_array[10] : 0;
    //     $realisasi_fisik[] = (!empty($fisik_array[11]) and $fisik_array[11] > 0) ? $fisik_array[11] : 0;
    //     return $realisasi_fisik;
    // }





    public function realisasi_keuangan_ratarata($id_instansi)
    {
        $data_realisasi_keuangan_ratarata_akumulasi = [];
        $data_realisasi_keuangan_ratarata_bulanan = [];
        $total_fisik_bulan = [];

        // $kegiatan = $this->target_realisasi_model->get_kode_rekening_kegiatan($id_instansi);
      
        $no = 1;
        $tampung_kegiatan_berpagu = [];

         // $bulan = 4;
        $tahun = tahun_anggaran();
        $tahap = tahapan_apbd();
        $kegiatan = $this->target_realisasi_model->all_kegiatan($id_instansi, $tahun, $tahap);



        for ($a=1; $a <=12 ; $a++) { 
        	$bulan = $a;
      
            

            $no_sub_kegiatan = 0;
            $total_sub_kegiatan = 0;
            $total_fisik_semua =0;


            // echo "<table border = 1>
            // <tr>
	           //  <td colspan='5'>".bulan_global($bulan)."</td>
            // </tr>
            // <tr>
	           //  <td>No</td>
	           //  <td>Sub KEgiatan</td>
	           //  <td>Pagu</td>
	           //  <td>Realisasi Akumulasi</td>
	           //  <td>Realisasi Bulanan</td>
	           //  <td>% Akumulasi</td>
	           //  <td>% Bulanan</td>
            // </tr>
            // ";


            $no_sub_kegiatan = 0;
            $total_sub_kegiatan = 0;
            $total_realisasi_keuangan_akumulasi_semua =0;
            $total_realisasi_keuangan_bulanan_semua =0;


             foreach ($kegiatan as $key => $value_sk) {
      $total_sub_kegiatan +=1;
      $no_sub_kegiatan++;   
            $nama_sub_kegiatan = $value_sk->nama_sub_kegiatan;
            $pagu = $value_sk->pagu;

             $realisasi_keuangan = $this->realisasi_akumulasi_model->get_realisasi_keuangan($id_instansi, $value_sk->kode_rekening_sub_kegiatan, $bulan, "<=", $tahun, $tahap)->row_array();
             $realisasi_keuangan_bulanan = $this->realisasi_akumulasi_model->get_realisasi_keuangan($id_instansi, $value_sk->kode_rekening_sub_kegiatan, $bulan, "=", $tahun, $tahap)->row_array();

      		$total_realisasi_akumulasi = $realisasi_keuangan['total_realisasi'] ; 
      		$total_realisasi_bulanan = $realisasi_keuangan_bulanan['total_realisasi'] ; 


      		if ($pagu==0) {
      			
	      		@$persen_akumulasi = 0 ; 
	      		@$persen_bulanan = 0 ; 
      		}else{
	      		@$persen_akumulasi = ($total_realisasi_akumulasi / $pagu) * 100 ; 
	      		@$persen_bulanan = ($total_realisasi_bulanan / $pagu) * 100 ; 
      		}

      		$total_realisasi_keuangan_akumulasi_semua += $persen_akumulasi ; 
      		$total_realisasi_keuangan_bulanan_semua += $persen_bulanan ; 
      			// echo "<tr>
	      		// 	<td>".$no_sub_kegiatan."</td>
	      		// 	<td>".$nama_sub_kegiatan."</td>
	      		// 	<td>".number_format($pagu)."</td>
	      			
	      		// 	<td>".number_format($realisasi_keuangan['total_realisasi'])."</td>
	      		// 	<td>".number_format($realisasi_keuangan_bulanan['total_realisasi'])."</td>
	      		// 	<td>".round($persen_akumulasi,2)."</td>
	      		// 	<td>".round($persen_bulanan,2)."</td>
	      		// 	</tr>
      			// ";
        } //akhir foreach ($sub_kegiatan as $key => $value_sk)

        @$ratarata_akumulasi = $total_realisasi_keuangan_akumulasi_semua / $total_sub_kegiatan;
        @$ratarata_bulanan = $total_realisasi_keuangan_bulanan_semua / $total_sub_kegiatan;

        // echo "<tr>
	      	// 		<td colspan=5>Total</td>
	      			
	      	// 		<td> ".round($total_realisasi_keuangan_akumulasi_semua,2)." </td>
	      	// 		<td> ".round($total_realisasi_keuangan_bulanan_semua,2)." </td>
	      	// 		</tr>
      		// 	";
        // echo "<tr>
	      	// 		<td colspan=5>Ratarata</td>
	      			
	      	// 		<td> ".round($ratarata_akumulasi,2)." </td>
	      	// 		<td> ".round($ratarata_bulanan,2)." </td>
	      	// 		</tr>
      		// 	";

     
?>

<?php
array_push($data_realisasi_keuangan_ratarata_akumulasi, round($ratarata_akumulasi,2));
array_push($data_realisasi_keuangan_ratarata_bulanan, round($ratarata_bulanan,2));
}

// echo "</table>";

$kumpul_realisasi_keuangan_ratarata = [];
array_push($kumpul_realisasi_keuangan_ratarata, $data_realisasi_keuangan_ratarata_akumulasi);
array_push($kumpul_realisasi_keuangan_ratarata, $data_realisasi_keuangan_ratarata_bulanan);
// echo json_encode($kumpul_realisasi_keuangan_ratarata);

// header('Content-Type: application/json');
// echo json_encode($data_realisasi_keuangan_ratarata_bulanan);
return $kumpul_realisasi_keuangan_ratarata;
                
}




    public function update_bulan()
    {
        $output = [
            'data' => []
        ];

        $realisasi = $this->db->get('realisasi_fisik');

        foreach ($realisasi->result() as $key => $value) {
            $this->db->update('realisasi_fisik', ['bulan' => date('n', $value->updated_on)], ['id_realisasi_fisik' => $value->id_realisasi_fisik]);
        }

        echo json_encode($output);
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


















    public function synch_baru($tahun, $tahap, $id_instansi, $input='manual')
    {
        // $tahun = $this->input->get('tahun');
        // $tahap = $this->input->get('tahap');
        // $id_instansi = $this->input->get('id_instansi');
        $q_opd = $this->db->query("SELECT nama_instansi, kode_opd from master_instansi where id_instansi='$id_instansi'")->row_array();
        $kode_opd = $q_opd['kode_opd'];
        $nama_instansi = $q_opd['nama_instansi'];
        $kode_tahap = $tahap;
        // $this->db->trans_begin();
        $synchronize    = $this->synchronize_model;
        $sub_kegiatan = $synchronize->get_sub_kegiatan($id_instansi, $tahun, $tahap);
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

          if($kode_tahap==2){

            $q_pagu = $this->db->query("SELECT kode_sub_kegiatan,
            bo_bp , bo_bbj , bo_bs , bo_bh , bm_bmt , bm_bmpm , bm_bmgb , bm_bmjji , bm_bmatl , btt , bt_bbh , bt_bbk 
            from anggaran_sub_kegiatan
            where tahun='$tahun' and kode_tahap='$tahap' and id_instansi='$id_instansi'
            ");
          }else{
            $q_pagu = $this->db->query("SELECT kode_sub_kegiatan,
            bo_bp , bo_bbj , bo_bs , bo_bh , bm_bmt , bm_bmpm , bm_bmgb , bm_bmjji , bm_bmatl , btt , bt_bbh , bt_bbk 
            from anggaran_sub_kegiatan
            where tahun='$tahun' and status='1' and id_instansi='$id_instansi'
            ");
          }


        $total_pagu_semua = 0;
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
            $total_pagu_semua += $pagu_total;
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

        // $gagu_kegiatan = $synchronize->get_pagu($id_instansi, $value_sk->kode_rekening_sub_kegiatan, $value_sk->kode_tahap, $value_sk->tahun)->result_array();
        $target = $synchronize->get_target($id_instansi, $value_sk->kode_rekening_sub_kegiatan, $value_sk->kode_tahap, $value_sk->tahun)->result_array();
        $realisasi_keuangan = $synchronize->get_realisasi_keuangan($id_instansi, $value_sk->kode_rekening_sub_kegiatan, $tahun, $tahap)->result_array();
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
          $total_paket = $synchronize->get_total_paket($id_instansi, $value_sk->kode_rekening_sub_kegiatan, $tahun, $tahap)->num_rows();
          $jenis_rutin = $synchronize->get_total_paket_perjenis($id_instansi, $value_sk->kode_rekening_sub_kegiatan, "RUTIN", $tahun, $tahap)->num_rows();
          
          $kumpul_rp_realisasi_keuangan_bulanan_bo_bp = [];      
          $kumpul_rp_realisasi_keuangan_bulanan_bo_bbj = [];      
          $kumpul_rp_realisasi_keuangan_bulanan_bo_bs = [];      
          $kumpul_rp_realisasi_keuangan_bulanan_bo_bh = [];      
          $kumpul_rp_realisasi_keuangan_bulanan_bm_bmt = [];      
          $kumpul_rp_realisasi_keuangan_bulanan_bm_bmpm = [];      
          $kumpul_rp_realisasi_keuangan_bulanan_bm_bmgb = [];      
          $kumpul_rp_realisasi_keuangan_bulanan_bm_bmjji = [];      
          $kumpul_rp_realisasi_keuangan_bulanan_bm_bmatl = [];      
          $kumpul_rp_realisasi_keuangan_bulanan_btt = [];      
          $kumpul_rp_realisasi_keuangan_bulanan_bt_bbh = [];      
          $kumpul_rp_realisasi_keuangan_bulanan_bt_bbk = [];      
          $kumpul_rp_realisasi_keuangan_bulanan_total = [];      
          
          for ($i=0; $i <12 ; $i++) { 
            $bulan =$i+1;
            @$bobot_ski = ($kumpul_pagu[$value_sk->kode_rekening_sub_kegiatan]['pagu_total'] / $total_pagu_semua) *100;
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

                 $kumpultarget[$i]['bobot_target_fisik_akumulasi'] = 0;

                $kumpultarget[$i]['bobot_target_fisik_bulanan'] = 0;

             }else{
                $rp_target_keuangan = $target[$i]['target_keuangan']=='' ? 0 : $target[$i]['target_keuangan'] ; 
                $rp_target_keuangan_bulanan = $target[$i]['target_keuangan_bulanan']=='' ? 0 : $target[$i]['target_keuangan_bulanan'] ; 

                $hitung_persen_target_keuangan = $value_sk->pagu > 0 ? ($target[$i]['target_keuangan'] / $value_sk->pagu) * 100 : 0 ;
                $hitung_persen_target_keuangan_bulanan = $value_sk->pagu > 0 ? ($target[$i]['target_keuangan_bulanan'] / $value_sk->pagu) * 100 : 0 ;

                $persen_target_keuangan = $target[$i]['target_keuangan']=='' ? 0 : $hitung_persen_target_keuangan;
                $persen_target_keuangan_bulanan = $target[$i]['target_keuangan_bulanan']=='' ? 0 : $hitung_persen_target_keuangan_bulanan;   
                $kumpultarget[$i]['target_fisik_akumulasi'] = $target[$i]['target_fisik'];
                $kumpultarget[$i]['bobot_target_fisik_akumulasi'] = $target[$i]['target_fisik'] * $bobot_ski / 100;
                $kumpultarget[$i]['target_fisik_bulanan'] = $target[$i]['target_fisik_bulanan'];
                $kumpultarget[$i]['bobot_target_fisik_bulanan'] = $target[$i]['target_fisik_bulanan'] * $bobot_ski / 100;
                $kumpultarget[$i]['rp_target_keuangan_akumulasi'] = $rp_target_keuangan;
                $kumpultarget[$i]['persen_target_keuangan_akumulasi'] = $persen_target_keuangan;
                $kumpultarget[$i]['rp_target_keuangan_bulanan'] = $rp_target_keuangan_bulanan;
                $kumpultarget[$i]['persen_target_keuangan_bulanan'] = $persen_target_keuangan_bulanan;
                $target_fisik =  $kumpultarget[$i]['target_fisik_akumulasi'] ;//= $target[$i]['target_fisik'];
                $target_fisik_bulanan =  $kumpultarget[$i]['target_fisik_bulanan'] ;//= $target[$i]['target_fisik_bulanan'];
             }

             if (empty($realisasi_keuangan)) {
                  $kumpul_realisasi_keuangan[$i]['bulan'] = $bulan;

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
                    $persen_realisasi_keuangan_bulanan_total = 0;

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
             }else{

                if (isset($kumpul_data_realisasi_keuangan[$i])) {
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

                }else{
                    $kumpul_realisasi_keuangan[$i]['bulan'] = $bulan;
                    $rp_realisasi_keuangan_bulanan_bo_bp = 0;
                    $rp_realisasi_keuangan_bulanan_bo_bbj = 0;
                    $rp_realisasi_keuangan_bulanan_bo_bs = 0;
                    $rp_realisasi_keuangan_bulanan_bo_bh = 0;
                    $rp_realisasi_keuangan_bulanan_bm_bmt = 0;
                    $rp_realisasi_keuangan_bulanan_bm_bmpm = 0;
                    $rp_realisasi_keuangan_bulanan_bm_bmgb = 0;
                    $rp_realisasi_keuangan_bulanan_bm_bmjji = 0;
                    $rp_realisasi_keuangan_bulanan_bm_bmatl = 0;
                    $rp_realisasi_keuangan_bulanan_btt = 0;
                    $rp_realisasi_keuangan_bulanan_bt_bbh = 0;
                    $rp_realisasi_keuangan_bulanan_bt_bbk = 0;
                    $rp_realisasi_keuangan_bulanan_total = 0;
                    $persen_realisasi_keuangan_bulanan_total = 0;
                    # code...

                    $rp_realisasi_keuangan_akumulasi_bo_bp = 0;
                    $rp_realisasi_keuangan_akumulasi_bo_bbj = 0;
                    $rp_realisasi_keuangan_akumulasi_bo_bs = 0;
                    $rp_realisasi_keuangan_akumulasi_bo_bh = 0;
                    $rp_realisasi_keuangan_akumulasi_bm_bmt = 0;
                    $rp_realisasi_keuangan_akumulasi_bm_bmpm = 0;
                    $rp_realisasi_keuangan_akumulasi_bm_bmgb = 0;
                    $rp_realisasi_keuangan_akumulasi_bm_bmjji = 0;
                    $rp_realisasi_keuangan_akumulasi_bm_bmatl = 0;
                    $rp_realisasi_keuangan_akumulasi_btt = 0;
                    $rp_realisasi_keuangan_akumulasi_bt_bbh = 0;
                    $rp_realisasi_keuangan_akumulasi_bt_bbk = 0;
                    $rp_realisasi_keuangan_akumulasi_total = 0;
                    $persen_realisasi_keuangan_akumulasi_total = 0;

                }
            }
                    


                    $kumpul_realisasi_keuangan[$i]['rp_realisasi_keuangan_bulanan_bo_bp'] = $rp_realisasi_keuangan_bulanan_bo_bp;
                    $kumpul_realisasi_keuangan[$i]['rp_realisasi_keuangan_bulanan_bo_bbj'] = $rp_realisasi_keuangan_bulanan_bo_bbj;
                    $kumpul_realisasi_keuangan[$i]['rp_realisasi_keuangan_bulanan_bo_bs'] = $rp_realisasi_keuangan_bulanan_bo_bs;
                    $kumpul_realisasi_keuangan[$i]['rp_realisasi_keuangan_bulanan_bo_bh'] = $rp_realisasi_keuangan_bulanan_bo_bh;
                    $kumpul_realisasi_keuangan[$i]['rp_realisasi_keuangan_bulanan_bm_bmt'] = $rp_realisasi_keuangan_bulanan_bm_bmt;
                    $kumpul_realisasi_keuangan[$i]['rp_realisasi_keuangan_bulanan_bm_bmpm'] = $rp_realisasi_keuangan_bulanan_bm_bmpm;
                    $kumpul_realisasi_keuangan[$i]['rp_realisasi_keuangan_bulanan_bm_bmgb'] = $rp_realisasi_keuangan_bulanan_bm_bmgb;
                    $kumpul_realisasi_keuangan[$i]['rp_realisasi_keuangan_bulanan_bm_bmjji'] = $rp_realisasi_keuangan_bulanan_bm_bmjji;
                    $kumpul_realisasi_keuangan[$i]['rp_realisasi_keuangan_bulanan_bm_bmatl'] = $rp_realisasi_keuangan_bulanan_bm_bmatl;
                    $kumpul_realisasi_keuangan[$i]['rp_realisasi_keuangan_bulanan_btt'] = $rp_realisasi_keuangan_bulanan_btt;
                    $kumpul_realisasi_keuangan[$i]['rp_realisasi_keuangan_bulanan_bt_bbh'] = $rp_realisasi_keuangan_bulanan_bt_bbh;
                    $kumpul_realisasi_keuangan[$i]['rp_realisasi_keuangan_bulanan_bt_bbk'] = $rp_realisasi_keuangan_bulanan_bt_bbk;
                    $kumpul_realisasi_keuangan[$i]['rp_realisasi_keuangan_bulanan_total'] = $rp_realisasi_keuangan_bulanan_total;
                    $persen_realisasi_keuangan_bulanan_total = $value_sk->pagu > 0 ? $rp_realisasi_keuangan_bulanan_total / $value_sk->pagu * 100 : 0 ; 
                    $kumpul_realisasi_keuangan[$i]['persen_realisasi_keuangan_bulanan_total'] = $persen_realisasi_keuangan_bulanan_total;

                    array_push($kumpul_rp_realisasi_keuangan_bulanan_bo_bp, $rp_realisasi_keuangan_bulanan_bo_bp);
                    array_push($kumpul_rp_realisasi_keuangan_bulanan_bo_bbj, $rp_realisasi_keuangan_bulanan_bo_bbj);
                    array_push($kumpul_rp_realisasi_keuangan_bulanan_bo_bs, $rp_realisasi_keuangan_bulanan_bo_bs);
                    array_push($kumpul_rp_realisasi_keuangan_bulanan_bo_bh, $rp_realisasi_keuangan_bulanan_bo_bh);
                    array_push($kumpul_rp_realisasi_keuangan_bulanan_bm_bmt, $rp_realisasi_keuangan_bulanan_bm_bmt);
                    array_push($kumpul_rp_realisasi_keuangan_bulanan_bm_bmpm, $rp_realisasi_keuangan_bulanan_bm_bmpm);
                    array_push($kumpul_rp_realisasi_keuangan_bulanan_bm_bmgb, $rp_realisasi_keuangan_bulanan_bm_bmgb);
                    array_push($kumpul_rp_realisasi_keuangan_bulanan_bm_bmjji, $rp_realisasi_keuangan_bulanan_bm_bmjji);
                    array_push($kumpul_rp_realisasi_keuangan_bulanan_bm_bmatl, $rp_realisasi_keuangan_bulanan_bm_bmatl);
                    array_push($kumpul_rp_realisasi_keuangan_bulanan_btt, $rp_realisasi_keuangan_bulanan_btt);
                    array_push($kumpul_rp_realisasi_keuangan_bulanan_bt_bbh, $rp_realisasi_keuangan_bulanan_bt_bbh);
                    array_push($kumpul_rp_realisasi_keuangan_bulanan_bt_bbk, $rp_realisasi_keuangan_bulanan_bt_bbk);
                    array_push($kumpul_rp_realisasi_keuangan_bulanan_total, $rp_realisasi_keuangan_bulanan_total);

                    $rp_realisasi_keuangan_akumulasi_bo_bp = array_sum($kumpul_rp_realisasi_keuangan_bulanan_bo_bp);
                    $rp_realisasi_keuangan_akumulasi_bo_bbj = array_sum($kumpul_rp_realisasi_keuangan_bulanan_bo_bbj);
                    $rp_realisasi_keuangan_akumulasi_bo_bs = array_sum($kumpul_rp_realisasi_keuangan_bulanan_bo_bs);
                    $rp_realisasi_keuangan_akumulasi_bo_bh = array_sum($kumpul_rp_realisasi_keuangan_bulanan_bo_bh);
                    $rp_realisasi_keuangan_akumulasi_bm_bmt = array_sum($kumpul_rp_realisasi_keuangan_bulanan_bm_bmt);
                    $rp_realisasi_keuangan_akumulasi_bm_bmpm = array_sum($kumpul_rp_realisasi_keuangan_bulanan_bm_bmpm);
                    $rp_realisasi_keuangan_akumulasi_bm_bmgb = array_sum($kumpul_rp_realisasi_keuangan_bulanan_bm_bmgb);
                    $rp_realisasi_keuangan_akumulasi_bm_bmjji = array_sum($kumpul_rp_realisasi_keuangan_bulanan_bm_bmjji);
                    $rp_realisasi_keuangan_akumulasi_bm_bmatl = array_sum($kumpul_rp_realisasi_keuangan_bulanan_bm_bmatl);
                    $rp_realisasi_keuangan_akumulasi_btt = array_sum($kumpul_rp_realisasi_keuangan_bulanan_btt);
                    $rp_realisasi_keuangan_akumulasi_bt_bbh = array_sum($kumpul_rp_realisasi_keuangan_bulanan_bt_bbh);
                    $rp_realisasi_keuangan_akumulasi_bt_bbk = array_sum($kumpul_rp_realisasi_keuangan_bulanan_bt_bbk);
                    $rp_realisasi_keuangan_akumulasi_total = array_sum($kumpul_rp_realisasi_keuangan_bulanan_total);

                    $kumpul_realisasi_keuangan[$i]['rp_realisasi_keuangan_akumulasi_bo_bp'] = $rp_realisasi_keuangan_akumulasi_bo_bp;
                    $kumpul_realisasi_keuangan[$i]['rp_realisasi_keuangan_akumulasi_bo_bbj'] = $rp_realisasi_keuangan_akumulasi_bo_bbj;
                    $kumpul_realisasi_keuangan[$i]['rp_realisasi_keuangan_akumulasi_bo_bs'] = $rp_realisasi_keuangan_akumulasi_bo_bs;
                    $kumpul_realisasi_keuangan[$i]['rp_realisasi_keuangan_akumulasi_bo_bh'] = $rp_realisasi_keuangan_akumulasi_bo_bh;
                    $kumpul_realisasi_keuangan[$i]['rp_realisasi_keuangan_akumulasi_bm_bmt'] = $rp_realisasi_keuangan_akumulasi_bm_bmt;
                    $kumpul_realisasi_keuangan[$i]['rp_realisasi_keuangan_akumulasi_bm_bmpm'] = $rp_realisasi_keuangan_akumulasi_bm_bmpm;
                    $kumpul_realisasi_keuangan[$i]['rp_realisasi_keuangan_akumulasi_bm_bmgb'] = $rp_realisasi_keuangan_akumulasi_bm_bmgb;
                    $kumpul_realisasi_keuangan[$i]['rp_realisasi_keuangan_akumulasi_bm_bmjji'] = $rp_realisasi_keuangan_akumulasi_bm_bmjji;
                    $kumpul_realisasi_keuangan[$i]['rp_realisasi_keuangan_akumulasi_bm_bmatl'] = $rp_realisasi_keuangan_akumulasi_bm_bmatl;
                    $kumpul_realisasi_keuangan[$i]['rp_realisasi_keuangan_akumulasi_btt'] = $rp_realisasi_keuangan_akumulasi_btt;
                    $kumpul_realisasi_keuangan[$i]['rp_realisasi_keuangan_akumulasi_bt_bbh'] = $rp_realisasi_keuangan_akumulasi_bt_bbh;
                    $kumpul_realisasi_keuangan[$i]['rp_realisasi_keuangan_akumulasi_bt_bbk'] = $rp_realisasi_keuangan_akumulasi_bt_bbk;
                    $kumpul_realisasi_keuangan[$i]['rp_realisasi_keuangan_akumulasi_total'] = $rp_realisasi_keuangan_akumulasi_total;
                    $persen_realisasi_keuangan_akumulasi_total = $value_sk->pagu > 0 ? $rp_realisasi_keuangan_akumulasi_total / $value_sk->pagu * 100 : 0 ; 
                    $kumpul_realisasi_keuangan[$i]['persen_realisasi_keuangan_akumulasi_total'] = $persen_realisasi_keuangan_akumulasi_total;

                    //  
                    $rp_realisasi_keuangan_akumulasi = $rp_realisasi_keuangan_akumulasi_bo_bp + $rp_realisasi_keuangan_akumulasi_bo_bbj + $rp_realisasi_keuangan_akumulasi_bo_bs + $rp_realisasi_keuangan_akumulasi_bo_bh + $rp_realisasi_keuangan_akumulasi_bm_bmt + $rp_realisasi_keuangan_akumulasi_bm_bmpm + $rp_realisasi_keuangan_akumulasi_bm_bmgb + $rp_realisasi_keuangan_akumulasi_bm_bmjji + $rp_realisasi_keuangan_akumulasi_bm_bmatl + $rp_realisasi_keuangan_akumulasi_btt + $rp_realisasi_keuangan_akumulasi_bt_bbh + $rp_realisasi_keuangan_akumulasi_bt_bbk;

                    $rp_realisasi_keuangan_bulanan = $rp_realisasi_keuangan_bulanan_bo_bp + $rp_realisasi_keuangan_bulanan_bo_bbj + $rp_realisasi_keuangan_bulanan_bo_bs + $rp_realisasi_keuangan_bulanan_bo_bh + $rp_realisasi_keuangan_bulanan_bm_bmt + $rp_realisasi_keuangan_bulanan_bm_bmpm + $rp_realisasi_keuangan_bulanan_bm_bmgb + $rp_realisasi_keuangan_bulanan_bm_bmjji + $rp_realisasi_keuangan_bulanan_bm_bmatl + $rp_realisasi_keuangan_bulanan_btt + $rp_realisasi_keuangan_bulanan_bt_bbh + $rp_realisasi_keuangan_bulanan_bt_bbk;

                    if($value_sk->pagu==0){
                        $persen_realisasi_keuangan_akumulasi = 0; 
                        $persen_realisasi_keuangan_bulanan = 0; 
                    }else{
                        $persen_realisasi_keuangan_akumulasi = $rp_realisasi_keuangan_akumulasi / $value_sk->pagu * 100 ; 
                        $persen_realisasi_keuangan_bulanan = $rp_realisasi_keuangan_bulanan / $value_sk->pagu * 100 ; 
                    }
             
             
                    $swa = $synchronize->get_realisasi_fisik($id_instansi, $value_sk->kode_rekening_sub_kegiatan, 'SWAKELOLA', $tahun, $tahap , $bulan);
                    $pen = $synchronize->get_realisasi_fisik($id_instansi, $value_sk->kode_rekening_sub_kegiatan,'PENYEDIA', $tahun, $tahap , $bulan);

                    $swa_akumulasi = $swa['akumulasi'];
                    $swa_bulanan = $swa['bulanan'];
                    $pen_akumulasi = $pen['akumulasi'];
                    $pen_bulanan = $pen['bulanan'];

                    $nilai_rf_rutin_akumulasi = $persen_realisasi_keuangan_akumulasi > 95 ? 100 : $persen_realisasi_keuangan_akumulasi;
                    $nilai_rf_rutin_bulanan = $persen_realisasi_keuangan_bulanan > 95 ? 100 : $persen_realisasi_keuangan_bulanan;
                    $rutin_akumulasi = $jenis_rutin > 0 ? $nilai_rf_rutin_akumulasi : 0;  
                    $rutin_bulanan = $jenis_rutin > 0 ?  $nilai_rf_rutin_bulanan : 0 ;

                    if($total_paket==0){
                        $fisik_kegiatan_akumulasi = 0;
                        $fisik_kegiatan_bulanan = 0;
                    }else{
                        $fisik_kegiatan_akumulasi = ($swa_akumulasi + $pen_akumulasi + $rutin_akumulasi) / $total_paket;
                        $fisik_kegiatan_bulanan = ($swa_bulanan + $pen_bulanan + $rutin_bulanan) / $total_paket;
                    }


                    $realisasi_fisik = [
                      'akumulasi'=>$fisik_kegiatan_akumulasi,
                      'bobot_akumulasi'=>($fisik_kegiatan_akumulasi * $bobot_ski) / 100,
                      'bulanan'=>$fisik_kegiatan_bulanan,
                      'bobot_bulanan'=>($fisik_kegiatan_bulanan * $bobot_ski) / 100,
                    ];
                     array_push($kumpul_realisasi_fisik, $realisasi_fisik);
        }


         $data_kumpul_sub_kegiatan = [
          'identitas'=> [
            'pt'=> $total_pagu_semua,
            'bobot'=> $bobot_ski,
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
          
          'pagu'=> @$kumpul_pagu[$value_sk->kode_rekening_sub_kegiatan],
          'target'=> $kumpultarget,
          'realisasi_keuangan'=> $kumpul_realisasi_keuangan,
          'realisasi_fisik'=> $kumpul_realisasi_fisik,
         ];
         array_push($kumpul_sub_kegiatan, $data_kumpul_sub_kegiatan);




        } // end foreach ($sub_kegiatan->result() as $key => $value_sk) {

     
        $pecahkan_kembali = [];
        $kumpul_laporan_akhir_opd = [];
        $banyak_sub_kegiatan = count($kumpul_sub_kegiatan);


        for ($i=0; $i < 12; $i++) { 
          $bulan = $i+1;
          $target_fisik_akumulasi = 0 ;
          $target_fisik_bulanan = 0 ;
          $realisasi_fisik_akumulasi = 0 ;
          $realisasi_fisik_bulanan = 0 ;
          $bobot_ski_total = 0;
          $bobot_tf_akumulasi_total = 0;
          $bobot_rf_akumulasi_total = 0;
          $bobot_tf_bulanan_total = 0;
          $bobot_rf_bulanan_total = 0;

          $target_keuangan_akumulasi = 0 ;
          $target_keuangan_bulanan = 0 ;
          $realisasi_keuangan_akumulasi = 0 ;
          $realisasi_keuangan_bulanan = 0 ;

          $pagu_bo_bp = 0 ;
          $pagu_bo_bbj = 0 ;
          $pagu_bo_bs = 0 ;
          $pagu_bo_bh = 0 ;
          $pagu_bo_bbs = 0 ;
          $pagu_bm_bmt = 0 ;
          $pagu_bm_bmpm = 0 ;
          $pagu_bm_bmgb = 0 ;
          $pagu_bm_bmjji = 0 ;
          $pagu_bm_bmatl = 0 ;
          $pagu_bm_bmatb = 0 ;
          $pagu_btt = 0 ;
          $pagu_bt_bbh = 0 ;
          $pagu_bt_bbk = 0 ;
              $pagu_total = 0 ;
              $rp_target_keuangan_akumulasi = 0 ;
          $rp_target_keuangan_bulanan = 0 ;
          $rp_realisasi_keuangan_akumulasi = 0 ;
          $rp_realisasi_keuangan_akumulasi_bo_bp = 0 ;
          $rp_realisasi_keuangan_akumulasi_bo_bbj = 0 ;
          $rp_realisasi_keuangan_akumulasi_bo_bs = 0 ;
          $rp_realisasi_keuangan_akumulasi_bo_bh = 0 ;
          $rp_realisasi_keuangan_akumulasi_bo_bbs = 0 ;
          $rp_realisasi_keuangan_akumulasi_bm_bmt = 0 ;
          $rp_realisasi_keuangan_akumulasi_bm_bmpm = 0 ;
          $rp_realisasi_keuangan_akumulasi_bm_bmgb = 0 ;
          $rp_realisasi_keuangan_akumulasi_bm_bmjji = 0 ;
          $rp_realisasi_keuangan_akumulasi_bm_bmatl = 0 ;
          $rp_realisasi_keuangan_akumulasi_bm_bmatb = 0 ;
          $rp_realisasi_keuangan_akumulasi_btt = 0 ;
          $rp_realisasi_keuangan_akumulasi_bt_bbh = 0 ;
          $rp_realisasi_keuangan_akumulasi_bt_bbk = 0 ;
          $rp_realisasi_keuangan_bulanan = 0 ;
          $rp_realisasi_keuangan_bulanan_bo_bp = 0 ;
          $rp_realisasi_keuangan_bulanan_bo_bbj = 0 ;
          $rp_realisasi_keuangan_bulanan_bo_bs = 0 ;
          $rp_realisasi_keuangan_bulanan_bo_bh = 0 ;
          $rp_realisasi_keuangan_bulanan_bo_bbs = 0 ;
          $rp_realisasi_keuangan_bulanan_bm_bmt = 0 ;
          $rp_realisasi_keuangan_bulanan_bm_bmpm = 0 ;
          $rp_realisasi_keuangan_bulanan_bm_bmgb = 0 ;
          $rp_realisasi_keuangan_bulanan_bm_bmjji = 0 ;
          $rp_realisasi_keuangan_bulanan_bm_bmatl = 0 ;
          $rp_realisasi_keuangan_bulanan_bm_bmatb = 0 ;
          $rp_realisasi_keuangan_bulanan_btt = 0 ;
          $rp_realisasi_keuangan_bulanan_bt_bbh = 0 ;
          $rp_realisasi_keuangan_bulanan_bt_bbk  = 0 ;

          foreach($kumpul_sub_kegiatan as $k => $v){
              $data = [
                'id_instansi' => $id_instansi,
                'bulan' => $bulan,
                'kode_tahap' => $v['identitas']['kode_tahap'],
                'tahun' => $v['identitas']['tahun'],
                'kode_sub_kegiatan' => $v['identitas']['kode_sub_kegiatan'],
                'nama_sub_kegiatan' => $v['identitas']['nama_sub_kegiatan'],
                'kode_kegiatan' => $v['identitas']['kode_kegiatan'],
                'nama_kegiatan' => $v['identitas']['nama_kegiatan'],
                'kode_program' => $v['identitas']['kode_program'],
                'nama_program' => $v['identitas']['nama_program'],
                'kategori' => $v['identitas']['kategori'],
                'tambahan_kode_sub_kegiatan' => $v['identitas']['tambahan_kode_sub_kegiatan'],
                'input_by_tambahan_kode_sub_kegiatan' => $v['identitas']['input_by_tambahan_kode_sub_kegiatan'],
                'jenis_sub_kegiatan' => $v['identitas']['jenis_sub_kegiatan'],
                'id_instansi_pembantu_teknis' => $v['identitas']['id_instansi_pembantu_teknis'],
                'keterangan' => $v['identitas']['keterangan'],
                'status_sub_kegiatan' => $v['identitas']['status_sub_kegiatan'],
                'pptk' => $v['identitas']['pptk'],


                'target_fisik_akumulasi' => $v['target'][$i]['target_fisik_akumulasi'],
                // 'bobot_target_fisik_akumulasi' => $v['target'][$i]['bobot_target_fisik_akumulasi'],
                'target_fisik_akumulasi_ratarata' => '????',
                'target_fisik_bulanan' => $v['target'][$i]['target_fisik_bulanan'],
                // 'bobot_target_fisik_bulanan' => $v['target'][$i]['bobot_target_fisik_bulanan'],
                'target_fisik_bulanan_ratarata' => '????',

                'realisasi_fisik_akumulasi' => $v['realisasi_fisik'][$i]['akumulasi'],
                // 'bobot_realisasi_fisik_akumulasi' => $v['realisasi_fisik'][$i]['akumulasi'],
                'realisasi_fisik_akumulasi_ratarata' => '????',
                'realisasi_fisik_bulanan' => $v['realisasi_fisik'][$i]['bulanan'],
                // 'bobot_realisasi_fisik_bulanan' => $v['realisasi_fisik'][$i]['akumulasi'],
                'realisasi_fisik_bulanan_ratarata' => '????',

                'target_keuangan_akumulasi' => $v['target'][$i]['persen_target_keuangan_akumulasi'],
                'target_keuangan_akumulasi_ratarata' => '????',
                'target_keuangan_bulanan' => $v['target'][$i]['persen_target_keuangan_bulanan'],
                'target_keuangan_bulanan_ratarata' => '????',

                'realisasi_keuangan_akumulasi' => $v['realisasi_keuangan'][$i]['persen_realisasi_keuangan_akumulasi_total'],
                'realisasi_keuangan_akumulasi_ratarata' => '????',
                'realisasi_keuangan_bulanan' => $v['realisasi_keuangan'][$i]['persen_realisasi_keuangan_bulanan_total'],
                'realisasi_keuangan_bulanan_ratarata' => '????',



                'pagu_bo_bp' => $v['pagu']['bo_bp'],
                'pagu_bo_bbj' => $v['pagu']['bo_bbj'],
                'pagu_bo_bs' => $v['pagu']['bo_bs'],
                'pagu_bo_bh' => $v['pagu']['bo_bh'],
                'pagu_bm_bmt' => $v['pagu']['bm_bmt'],
                'pagu_bm_bmpm' => $v['pagu']['bm_bmpm'],
                'pagu_bm_bmgb' => $v['pagu']['bm_bmgb'],
                'pagu_bm_bmjji' => $v['pagu']['bm_bmjji'],
                'pagu_bm_bmatl' => $v['pagu']['bm_bmatl'],
                'pagu_btt' => $v['pagu']['btt'],
                'pagu_bt_bbh' => $v['pagu']['bt_bbh'],
                'pagu_bt_bbk' => $v['pagu']['bt_bbk'],
                'pagu_total' => $v['pagu']['pagu_total'],


                'rp_target_keuangan_akumulasi' =>  $v['target'][$i]['rp_target_keuangan_akumulasi'],
                'rp_target_keuangan_bulanan' => $v['target'][$i]['rp_target_keuangan_bulanan'],

                'rp_realisasi_keuangan_akumulasi' => $v['realisasi_keuangan'][$i]['rp_realisasi_keuangan_akumulasi_total'],
                'rp_realisasi_keuangan_akumulasi_bo_bp' => $v['realisasi_keuangan'][$i]['rp_realisasi_keuangan_akumulasi_bo_bp'],
                'rp_realisasi_keuangan_akumulasi_bo_bbj' => $v['realisasi_keuangan'][$i]['rp_realisasi_keuangan_akumulasi_bo_bbj'],
                'rp_realisasi_keuangan_akumulasi_bo_bs' => $v['realisasi_keuangan'][$i]['rp_realisasi_keuangan_akumulasi_bo_bs'],
                'rp_realisasi_keuangan_akumulasi_bo_bh' => $v['realisasi_keuangan'][$i]['rp_realisasi_keuangan_akumulasi_bo_bh'],
                // 'rp_realisasi_keuangan_akumulasi_bo_bbs' => $v['realisasi_keuangan'][$i]['rp_realisasi_keuangan_akumulasi_bo_bbs'],
                'rp_realisasi_keuangan_akumulasi_bm_bmt' => $v['realisasi_keuangan'][$i]['rp_realisasi_keuangan_akumulasi_bm_bmt'],
                'rp_realisasi_keuangan_akumulasi_bm_bmpm' => $v['realisasi_keuangan'][$i]['rp_realisasi_keuangan_akumulasi_bm_bmpm'],
                'rp_realisasi_keuangan_akumulasi_bm_bmgb' => $v['realisasi_keuangan'][$i]['rp_realisasi_keuangan_akumulasi_bm_bmgb'],
                'rp_realisasi_keuangan_akumulasi_bm_bmjji' => $v['realisasi_keuangan'][$i]['rp_realisasi_keuangan_akumulasi_bm_bmjji'],
                'rp_realisasi_keuangan_akumulasi_bm_bmatl' => $v['realisasi_keuangan'][$i]['rp_realisasi_keuangan_akumulasi_bm_bmatl'],
                // 'rp_realisasi_keuangan_akumulasi_bm_bmatb' => $v['realisasi_keuangan'][$i]['rp_realisasi_keuangan_akumulasi_bm_bmatb'],
                'rp_realisasi_keuangan_akumulasi_btt' => $v['realisasi_keuangan'][$i]['rp_realisasi_keuangan_akumulasi_btt'],
                'rp_realisasi_keuangan_akumulasi_bt_bbh' => $v['realisasi_keuangan'][$i]['rp_realisasi_keuangan_akumulasi_bt_bbh'],
                'rp_realisasi_keuangan_akumulasi_bt_bbk' => $v['realisasi_keuangan'][$i]['rp_realisasi_keuangan_akumulasi_bt_bbk'],

                'rp_realisasi_keuangan_bulanan' => $v['realisasi_keuangan'][$i]['rp_realisasi_keuangan_bulanan_total'],
                'rp_realisasi_keuangan_bulanan_bo_bp' => $v['realisasi_keuangan'][$i]['rp_realisasi_keuangan_bulanan_bo_bp'],
                'rp_realisasi_keuangan_bulanan_bo_bbj' => $v['realisasi_keuangan'][$i]['rp_realisasi_keuangan_bulanan_bo_bbj'],
                'rp_realisasi_keuangan_bulanan_bo_bs' => $v['realisasi_keuangan'][$i]['rp_realisasi_keuangan_bulanan_bo_bs'],
                'rp_realisasi_keuangan_bulanan_bo_bh' => $v['realisasi_keuangan'][$i]['rp_realisasi_keuangan_bulanan_bo_bh'],
                // 'rp_realisasi_keuangan_bulanan_bo_bbs' => $v['realisasi_keuangan'][$i]['rp_realisasi_keuangan_bulanan_bo_bbs'],
                'rp_realisasi_keuangan_bulanan_bm_bmt' => $v['realisasi_keuangan'][$i]['rp_realisasi_keuangan_bulanan_bm_bmt'],
                'rp_realisasi_keuangan_bulanan_bm_bmpm' => $v['realisasi_keuangan'][$i]['rp_realisasi_keuangan_bulanan_bm_bmpm'],
                'rp_realisasi_keuangan_bulanan_bm_bmgb' => $v['realisasi_keuangan'][$i]['rp_realisasi_keuangan_bulanan_bm_bmgb'],
                'rp_realisasi_keuangan_bulanan_bm_bmjji' => $v['realisasi_keuangan'][$i]['rp_realisasi_keuangan_bulanan_bm_bmjji'],
                'rp_realisasi_keuangan_bulanan_bm_bmatl' => $v['realisasi_keuangan'][$i]['rp_realisasi_keuangan_bulanan_bm_bmatl'],
                // 'rp_realisasi_keuangan_bulanan_bm_bmatb' => $v['realisasi_keuangan'][$i]['rp_realisasi_keuangan_bulanan_bm_bmatb'],
                'rp_realisasi_keuangan_bulanan_btt' => $v['realisasi_keuangan'][$i]['rp_realisasi_keuangan_bulanan_btt'],
                'rp_realisasi_keuangan_bulanan_bt_bbh' => $v['realisasi_keuangan'][$i]['rp_realisasi_keuangan_bulanan_bt_bbh'],
                'rp_realisasi_keuangan_bulanan_bt_bbk' => $v['realisasi_keuangan'][$i]['rp_realisasi_keuangan_bulanan_bt_bbk'],
                'last_update' => timestamp(),
                'synchronize' => $input,
                
              ];

              array_push($pecahkan_kembali, $data);
              
                $target_fisik_akumulasi += $v['target'][$i]['target_fisik_akumulasi'] ;
                $target_fisik_bulanan += $v['target'][$i]['target_fisik_bulanan'] ;
                $realisasi_fisik_akumulasi += $v['realisasi_fisik'][$i]['akumulasi'] ;
                $realisasi_fisik_bulanan += $v['realisasi_fisik'][$i]['bulanan'] ;

                $bobot_ski_total += $v['identitas']['bobot'];
                $bobot_tf_akumulasi_total += $v['target'][$i]['bobot_target_fisik_akumulasi'];
                $bobot_tf_bulanan_total += $v['target'][$i]['bobot_target_fisik_bulanan'];
                $bobot_rf_akumulasi_total += $v['realisasi_fisik'][$i]['bobot_akumulasi'];
                $bobot_rf_bulanan_total += $v['realisasi_fisik'][$i]['bobot_bulanan'];

                $target_keuangan_akumulasi += $v['realisasi_keuangan'][$i]['persen_realisasi_keuangan_akumulasi_total'] ;
                $target_keuangan_bulanan += $v['realisasi_keuangan'][$i]['persen_realisasi_keuangan_bulanan_total'] ;
                $realisasi_keuangan_akumulasi += $v['realisasi_keuangan'][$i]['persen_realisasi_keuangan_akumulasi_total'];
                $realisasi_keuangan_bulanan += $v['realisasi_keuangan'][$i]['persen_realisasi_keuangan_bulanan_total'];
                
                $pagu_bo_bp += $v['pagu']['bo_bp'] ;
                $pagu_bo_bbj += $v['pagu']['bo_bbj'] ;
                $pagu_bo_bs += $v['pagu']['bo_bs'] ;
                $pagu_bo_bh += $v['pagu']['bo_bh'] ;
                $pagu_bm_bmt += $v['pagu']['bm_bmt'] ;
                $pagu_bm_bmpm += $v['pagu']['bm_bmpm'] ;
                $pagu_bm_bmgb += $v['pagu']['bm_bmgb'] ;
                $pagu_bm_bmjji += $v['pagu']['bm_bmjji'] ;
                $pagu_bm_bmatl += $v['pagu']['bm_bmatl'] ;
                
                $pagu_btt += $v['pagu']['btt'] ;
                $pagu_bt_bbh += $v['pagu']['bt_bbh'] ;
                $pagu_bt_bbk += $v['pagu']['bt_bbk'] ;
                $pagu_total += $v['pagu']['pagu_total'] ;

                $rp_target_keuangan_akumulasi += $v['target'][$i]['rp_target_keuangan_akumulasi'] ;
                $rp_target_keuangan_bulanan += $v['target'][$i]['rp_target_keuangan_bulanan'] ;
                
                $rp_realisasi_keuangan_akumulasi_bo_bp += $v['realisasi_keuangan'][$i]['rp_realisasi_keuangan_akumulasi_bo_bp'];
                $rp_realisasi_keuangan_akumulasi_bo_bbj += $v['realisasi_keuangan'][$i]['rp_realisasi_keuangan_akumulasi_bo_bbj'];
                $rp_realisasi_keuangan_akumulasi_bo_bs += $v['realisasi_keuangan'][$i]['rp_realisasi_keuangan_akumulasi_bo_bs'];
                $rp_realisasi_keuangan_akumulasi_bo_bh += $v['realisasi_keuangan'][$i]['rp_realisasi_keuangan_akumulasi_bo_bh'];
                $rp_realisasi_keuangan_akumulasi_bm_bmt += $v['realisasi_keuangan'][$i]['rp_realisasi_keuangan_akumulasi_bm_bmt'];
                $rp_realisasi_keuangan_akumulasi_bm_bmpm += $v['realisasi_keuangan'][$i]['rp_realisasi_keuangan_akumulasi_bm_bmpm'];
                $rp_realisasi_keuangan_akumulasi_bm_bmgb += $v['realisasi_keuangan'][$i]['rp_realisasi_keuangan_akumulasi_bm_bmgb'];
                $rp_realisasi_keuangan_akumulasi_bm_bmjji += $v['realisasi_keuangan'][$i]['rp_realisasi_keuangan_akumulasi_bm_bmjji'];
                $rp_realisasi_keuangan_akumulasi_bm_bmatl += $v['realisasi_keuangan'][$i]['rp_realisasi_keuangan_akumulasi_bm_bmatl'];
                $rp_realisasi_keuangan_akumulasi_btt += $v['realisasi_keuangan'][$i]['rp_realisasi_keuangan_akumulasi_btt'];
                $rp_realisasi_keuangan_akumulasi_bt_bbh += $v['realisasi_keuangan'][$i]['rp_realisasi_keuangan_akumulasi_bt_bbh'];
                $rp_realisasi_keuangan_akumulasi_bt_bbk += $v['realisasi_keuangan'][$i]['rp_realisasi_keuangan_akumulasi_bt_bbk'];
                $rp_realisasi_keuangan_akumulasi += $v['realisasi_keuangan'][$i]['rp_realisasi_keuangan_akumulasi_total'];

                $rp_realisasi_keuangan_bulanan += $v['realisasi_keuangan'][$i]['rp_realisasi_keuangan_bulanan_total'];
                $rp_realisasi_keuangan_bulanan_bo_bp += $v['realisasi_keuangan'][$i]['rp_realisasi_keuangan_bulanan_bo_bp'];
                $rp_realisasi_keuangan_bulanan_bo_bbj += $v['realisasi_keuangan'][$i]['rp_realisasi_keuangan_bulanan_bo_bbj'];
                $rp_realisasi_keuangan_bulanan_bo_bs += $v['realisasi_keuangan'][$i]['rp_realisasi_keuangan_bulanan_bo_bs'];
                $rp_realisasi_keuangan_bulanan_bo_bh += $v['realisasi_keuangan'][$i]['rp_realisasi_keuangan_bulanan_bo_bh'];
                $rp_realisasi_keuangan_bulanan_bm_bmt += $v['realisasi_keuangan'][$i]['rp_realisasi_keuangan_bulanan_bm_bmt'];
                $rp_realisasi_keuangan_bulanan_bm_bmpm += $v['realisasi_keuangan'][$i]['rp_realisasi_keuangan_bulanan_bm_bmpm'];
                $rp_realisasi_keuangan_bulanan_bm_bmgb += $v['realisasi_keuangan'][$i]['rp_realisasi_keuangan_bulanan_bm_bmgb'];
                $rp_realisasi_keuangan_bulanan_bm_bmjji += $v['realisasi_keuangan'][$i]['rp_realisasi_keuangan_bulanan_bm_bmjji'];
                $rp_realisasi_keuangan_bulanan_bm_bmatl += $v['realisasi_keuangan'][$i]['rp_realisasi_keuangan_bulanan_bm_bmatl'];
                $rp_realisasi_keuangan_bulanan_btt += $v['realisasi_keuangan'][$i]['rp_realisasi_keuangan_bulanan_btt'];
                $rp_realisasi_keuangan_bulanan_bt_bbh += $v['realisasi_keuangan'][$i]['rp_realisasi_keuangan_bulanan_bt_bbh'];
                $rp_realisasi_keuangan_bulanan_bt_bbk  += $v['realisasi_keuangan'][$i]['rp_realisasi_keuangan_bulanan_bt_bbk'];

            }


            if ($pagu_total>0) {
                $persen_target_fisik_akumulasi = $target_fisik_akumulasi / $banyak_sub_kegiatan ;
                $persen_target_fisik_bulanan = $target_fisik_bulanan / $banyak_sub_kegiatan ;
                $persen_realisasi_fisik_akumulasi = $realisasi_fisik_akumulasi / $banyak_sub_kegiatan ;
                $persen_realisasi_fisik_bulanan = $realisasi_fisik_bulanan / $banyak_sub_kegiatan ;
                $persen_target_keuangan_akumulasi = ( $rp_target_keuangan_akumulasi / $pagu_total) * 100 ;
                $persen_target_keuangan_bulanan = ( $rp_target_keuangan_bulanan / $pagu_total) * 100 ;
                $persen_realisasi_keuangan_akumulasi = ($rp_realisasi_keuangan_akumulasi / $pagu_total ) * 100 ;
                $persen_realisasi_keuangan_bulanan = ($rp_realisasi_keuangan_bulanan / $pagu_total ) * 100 ;




                $laporan_akhir_opd = [
	              'id_instansi'=> $id_instansi , 
	              'kode_opd'=> $kode_opd , 
	              'bulan'=> $bulan , 
	              'kode_tahap'=> $kode_tahap , 
	              'tahun'=> $tahun , 

	              // // Referensi 
	              // // 'bobot_ski_total'=> $bobot_ski_total , 
	              // 'target_fisik_akumulasi'=> $target_fisik_akumulasi , 
	              // // 'bobot_target_fisik_akumulasi'=> $bobot_tf_akumulasi_total , 
	              // 'target_fisik_bulanan'=> $target_fisik_bulanan , 
	              // // 'bobot_target_fisik_bulanan'=> $bobot_tf_bulanan_total , 
	              // 'realisasi_fisik_akumulasi'=> $realisasi_fisik_akumulasi , 
	              // // 'bobot_realisasi_fisik_akumulasi'=> $bobot_rf_akumulasi_total , 
	              // 'realisasi_fisik_bulanan'=> $realisasi_fisik_bulanan , 
	              // // 'bobot_realisasi_fisik_bulanan'=> $bobot_rf_bulanan_total , 

	              
	              // insert db 
	              'target_fisik_akumulasi'=> $bobot_tf_akumulasi_total , 
	              'target_fisik_bulanan'=> $bobot_tf_bulanan_total , 
	              'realisasi_fisik_akumulasi'=> $bobot_rf_akumulasi_total , 
	              'realisasi_fisik_bulanan'=> $bobot_rf_bulanan_total , 
	              
	              'target_keuangan_akumulasi'=> $persen_target_keuangan_akumulasi , 
	              'target_keuangan_bulanan'=> $persen_target_keuangan_bulanan , 
	              'realisasi_keuangan_akumulasi'=> $persen_realisasi_keuangan_akumulasi , 
	              'realisasi_keuangan_bulanan'=> $persen_realisasi_keuangan_bulanan , 


	              'pagu_bo_bp'=> $pagu_bo_bp, 
	              'pagu_bo_bbj'=> $pagu_bo_bbj, 
	              'pagu_bo_bs'=> $pagu_bo_bs, 
	              'pagu_bo_bh'=> $pagu_bo_bh, 
	              'pagu_bo_bbs'=> $pagu_bo_bbs, 
	              'pagu_bm_bmt'=> $pagu_bm_bmt, 
	              'pagu_bm_bmpm'=> $pagu_bm_bmpm, 
	              'pagu_bm_bmgb'=> $pagu_bm_bmgb, 
	              'pagu_bm_bmjji'=> $pagu_bm_bmjji, 
	              'pagu_bm_bmatl'=> $pagu_bm_bmatl, 
	              'pagu_bm_bmatb'=> $pagu_bm_bmatb, 
	              'pagu_btt'=> $pagu_btt, 
	              'pagu_bt_bbh'=> $pagu_bt_bbh, 
	              'pagu_bt_bbk'=> $pagu_bt_bbk, 
	              'pagu_total'=> $pagu_total, 
	              'rp_target_keuangan_akumulasi'=> $rp_target_keuangan_akumulasi , 
	              'rp_target_keuangan_bulanan'=> $rp_target_keuangan_bulanan , 
	              'rp_realisasi_keuangan_akumulasi'=> $rp_realisasi_keuangan_akumulasi , 
	              'rp_realisasi_keuangan_akumulasi_bo_bp'=> $rp_realisasi_keuangan_akumulasi_bo_bp , 
	              'rp_realisasi_keuangan_akumulasi_bo_bbj'=> $rp_realisasi_keuangan_akumulasi_bo_bbj , 
	              'rp_realisasi_keuangan_akumulasi_bo_bs'=> $rp_realisasi_keuangan_akumulasi_bo_bs , 
	              'rp_realisasi_keuangan_akumulasi_bo_bh'=> $rp_realisasi_keuangan_akumulasi_bo_bh , 
	              'rp_realisasi_keuangan_akumulasi_bo_bbs'=> $rp_realisasi_keuangan_akumulasi_bo_bbs , 
	              'rp_realisasi_keuangan_akumulasi_bm_bmt'=> $rp_realisasi_keuangan_akumulasi_bm_bmt , 
	              'rp_realisasi_keuangan_akumulasi_bm_bmpm'=> $rp_realisasi_keuangan_akumulasi_bm_bmpm , 
	              'rp_realisasi_keuangan_akumulasi_bm_bmgb'=> $rp_realisasi_keuangan_akumulasi_bm_bmgb , 
	              'rp_realisasi_keuangan_akumulasi_bm_bmjji'=> $rp_realisasi_keuangan_akumulasi_bm_bmjji , 
	              'rp_realisasi_keuangan_akumulasi_bm_bmatl'=> $rp_realisasi_keuangan_akumulasi_bm_bmatl , 
	              'rp_realisasi_keuangan_akumulasi_bm_bmatb'=> $rp_realisasi_keuangan_akumulasi_bm_bmatb , 
	              'rp_realisasi_keuangan_akumulasi_btt'=> $rp_realisasi_keuangan_akumulasi_btt , 
	              'rp_realisasi_keuangan_akumulasi_bt_bbh'=> $rp_realisasi_keuangan_akumulasi_bt_bbh , 
	              'rp_realisasi_keuangan_akumulasi_bt_bbk'=> $rp_realisasi_keuangan_akumulasi_bt_bbk , 
	              'rp_realisasi_keuangan_bulanan'=> $rp_realisasi_keuangan_bulanan , 
	              'rp_realisasi_keuangan_bulanan_bo_bp'=> $rp_realisasi_keuangan_bulanan_bo_bp , 
	              'rp_realisasi_keuangan_bulanan_bo_bbj'=> $rp_realisasi_keuangan_bulanan_bo_bbj , 
	              'rp_realisasi_keuangan_bulanan_bo_bs'=> $rp_realisasi_keuangan_bulanan_bo_bs , 
	              'rp_realisasi_keuangan_bulanan_bo_bh'=> $rp_realisasi_keuangan_bulanan_bo_bh , 
	              'rp_realisasi_keuangan_bulanan_bo_bbs'=> $rp_realisasi_keuangan_bulanan_bo_bbs , 
	              'rp_realisasi_keuangan_bulanan_bm_bmt'=> $rp_realisasi_keuangan_bulanan_bm_bmt , 
	              'rp_realisasi_keuangan_bulanan_bm_bmpm'=> $rp_realisasi_keuangan_bulanan_bm_bmpm , 
	              'rp_realisasi_keuangan_bulanan_bm_bmgb'=> $rp_realisasi_keuangan_bulanan_bm_bmgb , 
	              'rp_realisasi_keuangan_bulanan_bm_bmjji'=> $rp_realisasi_keuangan_bulanan_bm_bmjji , 
	              'rp_realisasi_keuangan_bulanan_bm_bmatl'=> $rp_realisasi_keuangan_bulanan_bm_bmatl , 
	              'rp_realisasi_keuangan_bulanan_bm_bmatb'=> $rp_realisasi_keuangan_bulanan_bm_bmatb , 
	              'rp_realisasi_keuangan_bulanan_btt'=> $rp_realisasi_keuangan_bulanan_btt , 
	              'rp_realisasi_keuangan_bulanan_bt_bbh'=> $rp_realisasi_keuangan_bulanan_bt_bbh , 
	              'rp_realisasi_keuangan_bulanan_bt_bbk'=> $rp_realisasi_keuangan_bulanan_bt_bbk  , 
	              'last_update '=> timestamp(),
                
                'synchronize' => $input,
	            ];




            }else{

                $persen_target_fisik_akumulasi = 0;//$target_fisik_akumulasi / $banyak_sub_kegiatan ;
                $persen_target_fisik_bulanan = 0;//$target_fisik_bulanan / $banyak_sub_kegiatan ;
                $persen_realisasi_fisik_akumulasi = 0;//$realisasi_fisik_akumulasi / $banyak_sub_kegiatan ;
                $persen_realisasi_fisik_bulanan = 0;//$realisasi_fisik_bulanan / $banyak_sub_kegiatan ;
                $persen_target_keuangan_akumulasi = 0;//( $rp_target_keuangan_akumulasi / $pagu_total) * 100 ;
                $persen_target_keuangan_bulanan = 0;//( $rp_target_keuangan_bulanan / $pagu_total) * 100 ;
                $persen_realisasi_keuangan_akumulasi = 0;//($rp_realisasi_keuangan_akumulasi / $pagu_total ) * 100 ;
                $persen_realisasi_keuangan_bulanan = 0;//($rp_realisasi_keuangan_bulanan / $pagu_total ) * 100 ;

                $laporan_akhir_opd = [
	              'id_instansi'=> $id_instansi , 
	              'kode_opd'=> $kode_opd , 
	              'bulan'=> $bulan , 
	              'kode_tahap'=> $kode_tahap , 
	              'tahun'=> $tahun , 

	              // // Referensi 
	              // // 'bobot_ski_total'=> $bobot_ski_total , 
	              // 'target_fisik_akumulasi'=> $target_fisik_akumulasi , 
	              // // 'bobot_target_fisik_akumulasi'=> $bobot_tf_akumulasi_total , 
	              // 'target_fisik_bulanan'=> $target_fisik_bulanan , 
	              // // 'bobot_target_fisik_bulanan'=> $bobot_tf_bulanan_total , 
	              // 'realisasi_fisik_akumulasi'=> $realisasi_fisik_akumulasi , 
	              // // 'bobot_realisasi_fisik_akumulasi'=> $bobot_rf_akumulasi_total , 
	              // 'realisasi_fisik_bulanan'=> $realisasi_fisik_bulanan , 
	              // // 'bobot_realisasi_fisik_bulanan'=> $bobot_rf_bulanan_total , 

	              
	              // insert db 
	              'target_fisik_akumulasi'=> 0,//$bobot_tf_akumulasi_total , 
	              'target_fisik_bulanan'=> 0,//$bobot_tf_bulanan_total , 
	              'realisasi_fisik_akumulasi'=> 0,//$bobot_rf_akumulasi_total , 
	              'realisasi_fisik_bulanan'=> 0,//$bobot_rf_bulanan_total , 
	              
	              'target_keuangan_akumulasi'=> 0,//$persen_target_keuangan_akumulasi , 
	              'target_keuangan_bulanan'=> 0,//$persen_target_keuangan_bulanan , 
	              'realisasi_keuangan_akumulasi'=> 0,//$persen_realisasi_keuangan_akumulasi , 
	              'realisasi_keuangan_bulanan'=> 0,//$persen_realisasi_keuangan_bulanan , 


	              'pagu_bo_bp'=> $pagu_bo_bp, 
	              'pagu_bo_bbj'=> $pagu_bo_bbj, 
	              'pagu_bo_bs'=> $pagu_bo_bs, 
	              'pagu_bo_bh'=> $pagu_bo_bh, 
	              'pagu_bo_bbs'=> $pagu_bo_bbs, 
	              'pagu_bm_bmt'=> $pagu_bm_bmt, 
	              'pagu_bm_bmpm'=> $pagu_bm_bmpm, 
	              'pagu_bm_bmgb'=> $pagu_bm_bmgb, 
	              'pagu_bm_bmjji'=> $pagu_bm_bmjji, 
	              'pagu_bm_bmatl'=> $pagu_bm_bmatl, 
	              'pagu_bm_bmatb'=> $pagu_bm_bmatb, 
	              'pagu_btt'=> $pagu_btt, 
	              'pagu_bt_bbh'=> $pagu_bt_bbh, 
	              'pagu_bt_bbk'=> $pagu_bt_bbk, 
	              'pagu_total'=> $pagu_total, 
	              'rp_target_keuangan_akumulasi'=> $rp_target_keuangan_akumulasi , 
	              'rp_target_keuangan_bulanan'=> $rp_target_keuangan_bulanan , 
	              'rp_realisasi_keuangan_akumulasi'=> $rp_realisasi_keuangan_akumulasi , 
	              'rp_realisasi_keuangan_akumulasi_bo_bp'=> $rp_realisasi_keuangan_akumulasi_bo_bp , 
	              'rp_realisasi_keuangan_akumulasi_bo_bbj'=> $rp_realisasi_keuangan_akumulasi_bo_bbj , 
	              'rp_realisasi_keuangan_akumulasi_bo_bs'=> $rp_realisasi_keuangan_akumulasi_bo_bs , 
	              'rp_realisasi_keuangan_akumulasi_bo_bh'=> $rp_realisasi_keuangan_akumulasi_bo_bh , 
	              'rp_realisasi_keuangan_akumulasi_bo_bbs'=> $rp_realisasi_keuangan_akumulasi_bo_bbs , 
	              'rp_realisasi_keuangan_akumulasi_bm_bmt'=> $rp_realisasi_keuangan_akumulasi_bm_bmt , 
	              'rp_realisasi_keuangan_akumulasi_bm_bmpm'=> $rp_realisasi_keuangan_akumulasi_bm_bmpm , 
	              'rp_realisasi_keuangan_akumulasi_bm_bmgb'=> $rp_realisasi_keuangan_akumulasi_bm_bmgb , 
	              'rp_realisasi_keuangan_akumulasi_bm_bmjji'=> $rp_realisasi_keuangan_akumulasi_bm_bmjji , 
	              'rp_realisasi_keuangan_akumulasi_bm_bmatl'=> $rp_realisasi_keuangan_akumulasi_bm_bmatl , 
	              'rp_realisasi_keuangan_akumulasi_bm_bmatb'=> $rp_realisasi_keuangan_akumulasi_bm_bmatb , 
	              'rp_realisasi_keuangan_akumulasi_btt'=> $rp_realisasi_keuangan_akumulasi_btt , 
	              'rp_realisasi_keuangan_akumulasi_bt_bbh'=> $rp_realisasi_keuangan_akumulasi_bt_bbh , 
	              'rp_realisasi_keuangan_akumulasi_bt_bbk'=> $rp_realisasi_keuangan_akumulasi_bt_bbk , 
	              'rp_realisasi_keuangan_bulanan'=> $rp_realisasi_keuangan_bulanan , 
	              'rp_realisasi_keuangan_bulanan_bo_bp'=> $rp_realisasi_keuangan_bulanan_bo_bp , 
	              'rp_realisasi_keuangan_bulanan_bo_bbj'=> $rp_realisasi_keuangan_bulanan_bo_bbj , 
	              'rp_realisasi_keuangan_bulanan_bo_bs'=> $rp_realisasi_keuangan_bulanan_bo_bs , 
	              'rp_realisasi_keuangan_bulanan_bo_bh'=> $rp_realisasi_keuangan_bulanan_bo_bh , 
	              'rp_realisasi_keuangan_bulanan_bo_bbs'=> $rp_realisasi_keuangan_bulanan_bo_bbs , 
	              'rp_realisasi_keuangan_bulanan_bm_bmt'=> $rp_realisasi_keuangan_bulanan_bm_bmt , 
	              'rp_realisasi_keuangan_bulanan_bm_bmpm'=> $rp_realisasi_keuangan_bulanan_bm_bmpm , 
	              'rp_realisasi_keuangan_bulanan_bm_bmgb'=> $rp_realisasi_keuangan_bulanan_bm_bmgb , 
	              'rp_realisasi_keuangan_bulanan_bm_bmjji'=> $rp_realisasi_keuangan_bulanan_bm_bmjji , 
	              'rp_realisasi_keuangan_bulanan_bm_bmatl'=> $rp_realisasi_keuangan_bulanan_bm_bmatl , 
	              'rp_realisasi_keuangan_bulanan_bm_bmatb'=> $rp_realisasi_keuangan_bulanan_bm_bmatb , 
	              'rp_realisasi_keuangan_bulanan_btt'=> $rp_realisasi_keuangan_bulanan_btt , 
	              'rp_realisasi_keuangan_bulanan_bt_bbh'=> $rp_realisasi_keuangan_bulanan_bt_bbh , 
	              'rp_realisasi_keuangan_bulanan_bt_bbk'=> $rp_realisasi_keuangan_bulanan_bt_bbk  , 
	              'last_update '=> timestamp(),
                
                'synchronize' => $input,
	            ];
            }

            
            array_push($kumpul_laporan_akhir_opd, $laporan_akhir_opd);
        } 

        if ($this->db->trans_status() === FALSE)
        {
                $this->db->trans_rollback();
                
              $responcode = 500;
              $status_synch = 'error';
              $keterangan_synch = 'Synchronize Gagal. Ditemukan kesalahan pada aplikasi';
                 $output = [
                    'responcode'=>500,
                    'status'=>'error',
                    'message'=>'Synchronize Gagal. Ditemukan kesalahan pada aplikasi',
                ];
        }
        else
        {

            if ($banyak_sub_kegiatan>0) {
            	if ($pagu_total>0) {
            		# code...
		          $where_delete = ['id_instansi'=>$id_instansi, 'tahun'=>$tahun, 'kode_tahap'=>$kode_tahap];
		          $this->db->delete('laporan_sub_kegiatan_opd', $where_delete);
		          $this->db->delete('grafik', $where_delete);

		          $this->db->insert_batch('laporan_sub_kegiatan_opd', $pecahkan_kembali);
		          $this->db->insert_batch('grafik', $kumpul_laporan_akhir_opd);

              
              $responcode = 200;
              $status_synch = 'success';
              $keterangan_synch = 'Synchronize Berhasil';
		          $output = [
		            'responcode'=>200,
		              'status'=>'success',
		              'badge'=>'success',
		              'synchronize'=>'Sukses',
		              'message'=>'Synchronize Berhasil',
		          ];
            	}else{

		          $this->db->insert_batch('grafik', $kumpul_laporan_akhir_opd);
              $responcode = 500;
              $status_synch = 'error';
              
              $keterangan_synch = 'Pagu Kosong';
            		 $output = [
		            'responcode'=>500,
		              'status'=>'warning',
		              'badge'=>'warning',
		              'synchronize'=>'Gagal',
		              'message'=>'Pagu Kosong',
		          ];
            	}
            }
            else{
            	
		          $this->db->insert_batch('grafik', $kumpul_laporan_akhir_opd);
              
              $responcode = 500;
              $status_synch = 'error';
              $keterangan_synch = 'Tidak ada kegiatan skpd '.pilihan_nama_tahapan($tahap).' '.$tahun;

                 $output = [
                      'responcode'=>500,
                      'status'=>'error',
                      'badge'=>'warning',
                      'synchronize'=>'Gagal',
                      'message'=>$keterangan_synch,
                ];
            }
            $this->db->trans_commit();
          }
          
          
                      $data_auto_synch = [
                        'id_instansi'=>$id_instansi,
                        'nama_instansi'=>$nama_instansi,
                        'tahun'=>$tahun,
                        'kode_tahap'=>$tahap,
                        'synchronize'=>$input,
                        'responcode'=>$responcode,
                        'status'=>$status_synch,
                        'keterangan'=>$keterangan_synch,
                        'waktu_synch'=>timestamp(),
                      ];
                      $this->db->insert('synch_detail', $data_auto_synch);
            // header('Content-Type: application/json');
            if($input=='manual'){
              
              echo json_encode($output);
            }else{

              return $output ; 
            }

    }
}
