<?php
/**
 * Author     : Alfikri, M.Kom
 * Created By : Alfikri, M.Kom
 * E-Mail     : alfikri.name@gmail.com
 * No HP      : 081277337405
 * Class      : Management_modules.php
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Management_modules extends MY_Controller
{
	public function __construct()
	{
		parent::__construct();
        $this->load->model(['management_modules/master_module_model' => 'master_module_model',
                            'datatables_model'                       => 'datatables_model']);
	}

	public function master_module()
	{
		$breadcrumbs    = $this->breadcrumbs;
        $master_module 	= $this->master_module_model;

        $breadcrumbs->add('Home', base_url());
        $breadcrumbs->add('Management Modules', base_url($this->router->fetch_class()));
        $breadcrumbs->add('Master Module', base_url());
        $breadcrumbs->render();

        $data['title']          = "Master Module";
        $data['icon']           = "metismenu-icon pe-7s-folder";
        $data['description']    = "Menampilkan Master Module";
        $data['breadcrumbs']    = $breadcrumbs->render();
        $data['master_group']   = $master_module->get_master_group();
        $page                   = 'management_modules/master_module/index';
        $data['link']           = $this->router->fetch_method();
        $data['menu']           = $this->load->view('layout/menu', $data, true);
        $data['extra_css']      = $this->load->view('management_modules/master_module/css',$data,true);
        $data['extra_js']       = $this->load->view('management_modules/master_module/js',$data,true);
        $data['modal']          = $this->load->view('management_modules/master_module/modal', $data, true);
        $this->template->load('backend_template',$page,$data);
    }

    public function dt_master_module()
	{
		if(!$this->input->is_ajax_request())
        {
            show_404();
        }else{
        	$where 			= array('id_module !='=>0);
        	$column_order   = array('module_name','module_description','created_on','update_on','is_active');
            $column_search  = array('category_name','category_description');
            $order = array('module_name' => 'asc');
            $list = $this->datatables_model->get_datatables('master_modules',$column_order,$column_search,$order,$where);
            $data = array();
            $no = $_POST['start'];
            foreach ($list as $lists)
            {
                $no++;
                $row            = array();
                $row[]          = $no;
                $row[]          = $lists->module_name;
                $row[]          = $lists->module_description;
                $row[]          = date('d-m-Y H:i:s',$lists->created_on);
                $row[]          = date('d-m-Y H:i:s',$lists->updated_on);
                $row[]          = full_name($lists->created_by);
                $row[]          = $lists->is_active;
                $row[]          = '<button class="btn btn-info btn-sm" onclick="editMasterModule('."'".encrypt($lists->id_module)."'".')"><i class="far fa-edit"></i></button> <button class="btn btn-danger btn-sm" onclick="deleteMasterModule('."'".encrypt($lists->id_module)."'".')"><i class="fas fa-trash"></i></button>';

                $data[] = $row;
            }

            $output = array(
                            "draw" => $_POST['draw'],
                            "recordsTotal" => $this->datatables_model->count_all('master_modules',$where),
                            "recordsFiltered" => $this->datatables_model->count_filtered('master_modules',$column_order,$column_search,$order,$where),
                            "data" => $data,
                    );

            echo json_encode($output);
        }
    }

    public function get_master_module()
    {
        if(!$this->input->is_ajax_request())
        {
            show_404();
        }else{
            $master_module  = $this->master_module_model;
            $output         = ['success'    => false,
                                'data'      => [],
                                'messages'  => ''
                              ];
            $id_module      = decrypt($this->input->get('idModule'));
            $result         = $master_module->get_by_id('master_modules',['id_module'=>$id_module])->row();
            $result_group   = $master_module->get_by_id('modules_groups',['id_module'=>$id_module]);
            if($result)
            {
                $output['success'] = true;
                $output['data']    = $result;
                $output['group']   = $result_group->result();
                $output['messages']= "Success";
            }else{
                $output['success'] = false;
                $output['messages']= "Failed";
            }
            echo json_encode($output);
        }
    }

    public function save_master_module()
	{
		if(!$this->input->is_ajax_request())
        {
            show_404();
        }else{
        	$output	= ['success'=>false,
                       'messages'=>[]
                      ];
            $master_module  = $this->master_module_model;
            $validation     = $this->form_validation;
            $validation->set_rules($master_module->rules_save());
        	$validation->set_error_delimiters('<p class="text-danger">','</p>');

        	if($validation->run())
        	{
                $data_group = [];
                $group      = $this->input->post('group');
                $id_module  = $master_module->save_master_module();
                if(!empty($group)):
                    foreach($group as $key):
                        $data_group[] = ['id_group'     => $group[$key],
                                         'id_module'    => $id_module
                                        ];
                    endforeach;
                endif;
                $master_module->delete_master_modules_groups(['id_module'=>$id_module]);
                $master_module->save_master_modules_groups($data_group);
                create_folder_file_modules($this->input->post('moduleName'));

        		$output['success'] 	= true;
                $output['messages'] = "Master Module berhasil di simpan";
        	}else{
                $output['success'] = false;
        		foreach ($_POST as $key => $value)
        		{
        			$output['messages'][$key] = form_error($key);
                }
        	}

        	echo json_encode($output);
        }
    }

    public function update_master_module()
    {
        if(!$this->input->is_ajax_request())
        {
            show_404();
        }else{
            $output = ['success'=>false,
                       'messages'=>[]
                      ];
            $master_module  = $this->master_module_model;
            $validation     = $this->form_validation;
            $validation->set_rules($master_module->rules_update());
            $validation->set_error_delimiters('<p class="text-danger">','</p>');

            if($validation->run())
            {
                $data_group = [];
                $group      = $this->input->post('group');
                $id_module  = $master_module->update_master_module();
                if(!empty($group)):
                    foreach($group as $key):
                        $data_group[] = ['id_group'     => $group[$key],
                                         'id_module'    => $id_module
                                        ];
                    endforeach;
                endif;
                $master_module->delete_master_modules_groups(['id_module'=>$id_module]);
                $master_module->save_master_modules_groups($data_group);
                $output['success']  = true;
                $output['messages'] = "Master Module berhasil di update";
            }else{
                $output['success'] = false;
                foreach ($_POST as $key => $value)
                {
                    $output['messages'][$key] = form_error($key);
                }
            }

            echo json_encode($output);
        }
    }

    public function delete_master_module()
    {
        if(!$this->input->is_ajax_request())
        {
            show_404();
        }else{
            $master_module  = $this->master_module_model;
            $result         = $master_module->delete_master_module();
            if($result):
                $output['success']      = true;
                $output['messages']     = "Master Module berhasil dihapus";
            else:
                $output['success']      = false;
                $output['messages']     = "Master Module gagal dihapus";
            endif;

            echo json_encode($output);
        }
    }
}