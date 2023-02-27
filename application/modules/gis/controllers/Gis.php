<?php
/**
 * Author     : Alfikri, M.Kom
 * Created By : Alfikri, M.Kom
 * E-Mail     : alfikri.name@gmail.com
 * No HP      : 081277337405
 * Class      : Gis.php
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Gis extends MY_Controller
{
	public function __construct()
	{
		parent::__construct();
        $this->load->model(['gis/gis_model' => 'gis_model']);
        $this->load->library('user_agent');
	}

	public function index()
	{
		if($this->agent->is_mobile())
		{

		}else{
			$breadcrumbs 	= $this->breadcrumbs;
	        $gis 	  		= $this->gis_model;

			$breadcrumbs->add('Home', base_url());
			$breadcrumbs->add('GIS', base_url($this->router->fetch_class()));
			$breadcrumbs->render();

			$data['title']			= "Geographic Information System";
	        $data['icon']           = "metismenu-icon pe-7s-global";
			$data['description']	= "Menampilkan Sistem Informasi Geografis";
			$data['breadcrumbs']	= $breadcrumbs->render();
			$page 					= 'gis/index';
	        $data['link']           = 'gis';
	        $data['menu']           = $this->load->view('layout/menu', $data, true);
			$data['extra_css']		= $this->load->view('gis/css',$data,true);
			$data['extra_js']		= $this->load->view('gis/js',$data,true);
	        $data['modal']          = '';
			$this->template->load('backend_template',$page,$data);
		}
	}

	public function get_project()
	{
		if(!$this->input->is_ajax_request())
        {
            show_404();
        }else{
        	$result = $this->db->get('projects')->result();
        	echo json_encode($result);
        }
	}

}