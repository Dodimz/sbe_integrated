<?php
/**
 * Author     : Alfikri, M.Kom
 * Created By : Alfikri, M.Kom
 * E-Mail     : alfikri.name@gmail.com
 * No HP      : 081277337405
 * Class      : Setup.php
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Setup extends MY_Controller
{
    
	public function __construct()
	{
		parent::__construct();
		if(identitas()==true)
		{
			redirect('auth','refresh');
		}
        $this->load->model('setup/setup_model','setup_model');
	}

	public function index()
	{
		$data['title']		= "Setup Installation";
		$page 				= 'setup/setup';
		$data['extra_css']	= $this->load->view('setup/css',$data,true);
		$data['extra_js']	= $this->load->view('js',$data,true);
		$this->template->load('auth_template',$page,$data);
	}

	public function save_identitas()
	{
		if(!$this->input->is_ajax_request())
        {
            exit('No direct script access allowed');
        }else{
        	$output	= ['success'=>false,
                       'messages'=>[]
                      ];

        	$this->form_validation->set_rules('kab_kota', 'Kabupaten/Kota', 'required|trim');
        	$this->form_validation->set_rules('email', 'E-Mail', 'required|trim');
        	$this->form_validation->set_error_delimiters('<p class="text-danger">','</p>');

        	if ($this->form_validation->run())
        	{
        		$kab_kota			= $this->input->post('kab_kota');
        		$email 				= $this->input->post('email');
        		$data 				= ['provinsi'=>'SUMATERA BARAT',
        							   'kab_kota'=>$kab_kota,
        				   	   		   'email'=>$email,
        				   	   		   'waktu_registrasi'=>date('Y-m-d H:i:s'),
        				   	   		   'aktif'=>'Y'
        				      		  ];
        		$simpan 			= $this->setup_model->save('master_identitas',$data);
        		$output['success'] 	= true;
        	}else{
        		foreach ($_POST as $key => $value)
        		{
        			$output['messages'][$key] = form_error($key);
                }
                $output['success'] = false;
        	}
        	
        	echo json_encode($output);
        }
	}
}