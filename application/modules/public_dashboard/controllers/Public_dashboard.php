<?php
/**
	* Author     : Alfikri, M.Kom
	* Created By : Alfikri, M.Kom
	* E-Mail     : alfikri.name@gmail.com
	* No HP      : 081277337405
	* Class      : Public_dashboard.php
*/
defined('BASEPATH') OR exit('No direct script access allowed');

class Public_dashboard extends MY_Controller
{
	public function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		$breadcrumbs    = $this->breadcrumbs;
        // $dashboard 		= $this->dashboard_model;

		$breadcrumbs->add('Home', base_url());
		$breadcrumbs->add('Dashboard', base_url());
		$breadcrumbs->render();

		$data['title']			= "Dashboard";
		$data['icon']			= "pe-7s-home";
		$data['description']	= "Menampilkan informasi yang berkaitan dengan Management dan Setting";
		$data['breadcrumbs']	= $breadcrumbs->render();
		// $data['total_users']	= $dashboard->total_users();
		// $data['total_modules']	= $dashboard->total_modules();
		$page 					= 'public_dashboard/index';
		$data['link']   		= $this->router->fetch_class();
		// $data['menu'] 			= $this->load->view('layout/menu', $data, true);
		$data['extra_css']		= $this->load->view('public_dashboard/css',$data,true);
		$data['extra_js']		= $this->load->view('public_dashboard/js',$data,true);
		$data['modal']          = "";
		$this->template->load('public_template',$page,$data);
	}

	public function show_chart()
    {
		$db2 	 = $this->load->database('sbe', TRUE);
        $id_skpd = 83;
        $fisik   = [];
        $keu     = [];
        $rea     = [];
        $r_fisik = [];
        if($id_skpd)
        {
            $sync    = $db2->query("SELECT * FROM v_grafik_realisasi_fisik_keuangan WHERE id_skpd = ".$id_skpd)->row();

            $fisik[] = (float) $sync->tf_jan;
            $fisik[] = (float) $sync->tf_feb;
            $fisik[] = (float) $sync->tf_mar;
            $fisik[] = (float) $sync->tf_apr;
            $fisik[] = (float) $sync->tf_mei;
            $fisik[] = (float) $sync->tf_jun;
            $fisik[] = (float) $sync->tf_jul;
            $fisik[] = (float) $sync->tf_agu;
            $fisik[] = (float) $sync->tf_sep;
            $fisik[] = (float) $sync->tf_okt;
            $fisik[] = (float) $sync->tf_nov;
            $fisik[] = (float) $sync->tf_des;

            $keu[] = (float) $sync->tk_jan;
            $keu[] = (float) $sync->tk_feb;
            $keu[] = (float) $sync->tk_mar;
            $keu[] = (float) $sync->tk_apr;
            $keu[] = (float) $sync->tk_mei;
            $keu[] = (float) $sync->tk_jun;
            $keu[] = (float) $sync->tk_jul;
            $keu[] = (float) $sync->tk_agu;
            $keu[] = (float) $sync->tk_sep;
            $keu[] = (float) $sync->tk_okt;
            $keu[] = (float) $sync->tk_nov;
            $keu[] = (float) $sync->tk_des;

            $r_fisik[] = (float) $sync->rf_jan > 0 ? (float) $sync->rf_jan : '';
            $r_fisik[] = (float) $sync->rf_feb > 0 ? (float) $sync->rf_feb : '';
            $r_fisik[] = (float) $sync->rf_mar > 0 ? (float) $sync->rf_mar : '';
            $r_fisik[] = (float) $sync->rf_apr > 0 ? (float) $sync->rf_apr : '';
            $r_fisik[] = (float) $sync->rf_mei > 0 ? (float) $sync->rf_mei : '';
            $r_fisik[] = (float) $sync->rf_jun > 0 ? (float) $sync->rf_jun : '';
            $r_fisik[] = (float) $sync->rf_jul > 0 ? (float) $sync->rf_jul : '';
            $r_fisik[] = (float) $sync->rf_agu > 0 ? (float) $sync->rf_agu : '';
            $r_fisik[] = (float) $sync->rf_sep > 0 ? (float) $sync->rf_sep : '';
            $r_fisik[] = (float) $sync->rf_okt > 0 ? (float) $sync->rf_okt : '';
            $r_fisik[] = (float) $sync->rf_nov > 0 ? (float) $sync->rf_nov : '';
            $r_fisik[] = (float) $sync->rf_des > 0 ? ((float) $sync->rf_des > 100 ? 100 : (float) $sync->rf_des) : '';

            $rea[] = (float) $sync->rk_jan > 0 ? (float) $sync->rk_jan : 0;
            $rea[] = (float) $sync->rk_feb > 0 ? (float) $sync->rk_feb : $rea[0];
            $rea[] = (float) $sync->rk_mar > 0 ? (float) $sync->rk_mar : $rea[1];
            $rea[] = (float) $sync->rk_apr > 0 ? (float) $sync->rk_apr : $rea[2];
            $rea[] = (float) $sync->rk_mei > 0 ? (float) $sync->rk_mei : $rea[3];
            $rea[] = (float) $sync->rk_jun > 0 ? (float) $sync->rk_jun : $rea[4];
            $rea[] = (float) $sync->rk_jul > 0 ? (float) $sync->rk_jul : $rea[5];
            $rea[] = (float) $sync->rk_agu > 0 ? (float) $sync->rk_agu : $rea[6];
            $rea[] = (float) $sync->rk_sep > 0 ? (float) $sync->rk_sep : $rea[7];
            $rea[] = (float) $sync->rk_okt > 0 ? (float) $sync->rk_okt : $rea[8];
            $rea[] = (float) $sync->rk_nov > 0 ? (float) $sync->rk_nov : $rea[9];
            $rea[] = (float) $sync->rk_des > 0 ? (float) $sync->rk_des : $rea[10];

        }else{
            $sync    = $this->db->query("SELECT * FROM v_grafik_provinsi")->result();

            foreach ($sync as $key => $value) {
                $fisik[$key]   = (float) $value->target_fisik;
                $keu[$key]     = (float) $value->target_keuangan;
                $rea[$key]     = (float) $value->realisasi_keuangan;
                $r_fisik[$key] = (float) $value->realisasi_fisik;
            }
        }

        $output = [];
        $output['fisik'] = $fisik;
        $output['keu']   = $keu;
        $output['r_fis'] = $r_fisik;
        $output['r_keu'] = $rea;
        $output['bulan_laporan'] = 12;

        echo json_encode($output);
    }
}