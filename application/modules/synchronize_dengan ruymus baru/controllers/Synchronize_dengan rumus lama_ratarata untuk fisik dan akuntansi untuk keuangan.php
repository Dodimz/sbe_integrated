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

        $data['title']                        = "Synchronize Target dan Realisasi";
        $data['icon']                       = "metismenu-icon fa fa-crosshairs";
        $data['description']                = "Synchronize Target dan Realisasi";
        $data['breadcrumbs']                = $breadcrumbs->render();
        $page                                 = 'synchronize/target_realisasi/index';
        $data['link']                       = $this->router->fetch_method();
        $data['menu']                       = $this->load->view('layout/menu', $data, true);
        $data['extra_css']                    = $this->load->view('synchronize/target_realisasi/css', $data, true);
        $data['extra_js']                    = $this->load->view('synchronize/target_realisasi/js', $data, true);
        $data['extra_js2']                    = $this->load->view('dashboard/js', $data, true);
        $data['modal']                      = $this->load->view('synchronize/target_realisasi/modal', $data, true);
        $this->template->load('backend_template', $page, $data);
    }

    public function cek_data($id_instansi){

        $t_fisik = $this->target_realisasi_model->get_target_fisik($id_instansi, $tahun, $tahap)->row_array();
        echo  json_encode($t_fisik);

    }

    public function sync()
    {
        $id_instansi        = $this->input->post('id_instansi');
        $kode_tahap        = tahapan_apbd();
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

        $realisasi_fisik[] = $this->realisasi_fisik($id_instansi);
        $realisasi_fisik_bulanan[] = $this->realisasi_fisik_bulanan($id_instansi);
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


    public function realisasi_fisik($id_instansi)
    {
        $realisasi_fisik = [];
        $total_fisik_bulan = [];
        // $kegiatan = $this->target_realisasi_model->get_kode_rekening_kegiatan($id_instansi);
        $no = 1;
        $tampung_kegiatan_berpagu = [];
        $tahun = tahun_anggaran();
        $tahap = tahapan_apbd();
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
                $bulan = $a;
                $realisasi_keuangan = $this->realisasi_akumulasi_model->get_realisasi_keuangan($id_instansi, $value_sk->kode_rekening_sub_kegiatan, $bulan, $ope, $tahun, $tahap)->row_array();
                $persen_realisasi_keuangan  = round(($realisasi_keuangan['total_realisasi'] / $value_sk->pagu) * 100, 2);



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
          // $rut = $jenis_rutin > 0 ? ($jenis_rutin * $realisasi_rutin) : 0;
          $rut = $jenis_rutin > 0 ? $persen_realisasi_keuangan : 0;
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

  
    public function realisasi_fisik_bulanan($id_instansi)
    {
        $realisasi_fisik = [];
        $total_fisik_bulan = [];
        // $kegiatan = $this->target_realisasi_model->get_kode_rekening_kegiatan($id_instansi);
        $no = 1;
        $tampung_kegiatan_berpagu = [];
        $tahun = tahun_anggaran();
        $tahap = tahapan_apbd();
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
}
