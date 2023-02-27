<?php
/**
    * Author     : Alfikri, M.Kom
    * Created By : Alfikri, M.Kom
    * E-Mail     : alfikri.name@gmail.com
    * No HP      : 081277337405
    * Class      : Management_menu.php
*/
defined('BASEPATH') OR exit('No direct script access allowed');

class Management_menu extends MY_Controller
{
	public function __construct()
	{
		parent::__construct();
        $this->load->model(['management_menu/category_menu_model' => 'category_menu_model',
                            'management_menu/master_menu_model'   => 'master_menu_model',
                            'management_menu/sub_menu_model'      => 'sub_menu_model',
    						'datatables_model'                    => 'datatables_model']);
	}

	public function index()
	{
		$this->category_menu();
	}

    /*----------  Category Menu  ----------*/

	public function category_menu()
	{
        $breadcrumbs    = $this->breadcrumbs;
        $category_menu  = $this->category_menu_model;

		$breadcrumbs->add('Home', base_url());
		$breadcrumbs->add('Management Menu', base_url($this->router->fetch_class()));
		$breadcrumbs->add('Category Menu', base_url());
		$breadcrumbs->render();

		$data['title']			= "Category Menu";
        $data['icon']           = "metismenu-icon pe-7s-menu";
		$data['description']	= "Menampilkan Category Menu";
		$data['breadcrumbs']	= $breadcrumbs->render();
        $data['order_number']   = $category_menu->auto_order_number();
        $data['master_group']   = $category_menu->get_all('master_group','id_group','ASC');
		$page 					= 'management_menu/category_menu/index';
        $data['link']           = $this->router->fetch_method();
        $data['menu']           = $this->load->view('layout/menu', $data, true);
		$data['extra_css']		= $this->load->view('management_menu/category_menu/css',$data,true);
		$data['extra_js']		= $this->load->view('management_menu/category_menu/js',$data,true);
        $data['modal']          = '';
		$this->template->load('backend_template',$page,$data);
	}

	public function dt_category_menu()
	{
		if(!$this->input->is_ajax_request())
        {
            show_404();
        }else{
        	$where 			= array('id_category_menu !='=>0);
        	$column_order   = array('order_number','category_name','category_description','is_active');
            $column_search  = array('category_name','category_description');
            $order = array('order_number' => 'asc');
            $list = $this->datatables_model->get_datatables('master_category_menu',$column_order,$column_search,$order,$where);
            $data = array();
            $no = $_POST['start'];
            foreach ($list as $lists)
            {
                $row            = array();
                $row[]          = $lists->order_number;
                $row[]          = $lists->category_name;
                $row[]          = $lists->category_description;
                $row[]          = $lists->is_active;
                $row[]          = '<button class="btn btn-info btn-sm" onclick="editCategoryMenu('."'".$lists->id_category_menu."'".')"><i class="far fa-edit"></i></button> <button class="btn btn-danger btn-sm" onclick="deleteCategoryMenu('."'".$lists->id_category_menu."'".')"><i class="fas fa-trash"></i></button>';

                $data[] = $row;
            }

            $output = array(
                            "draw" => $_POST['draw'],
                            "recordsTotal" => $this->datatables_model->count_all('master_category_menu',$where),
                            "recordsFiltered" => $this->datatables_model->count_filtered('master_category_menu',$column_order,$column_search,$order,$where),
                            "data" => $data,
                    );

            echo json_encode($output);
        }
	}

    public function get_category_menu()
    {
        if(!$this->input->is_ajax_request())
        {
            show_404();
        }else{
            $category_menu  = $this->category_menu_model;
            $output = ['success'=>false,
                       'data'=>[],
                       'messages'=>''
                      ];
            $id_category_menu = $this->input->get('idCategoryMenu');
            $result           = $category_menu->get_by_id('master_category_menu',['id_category_menu'=>$id_category_menu])->row();
            $result_group     = $category_menu->get_by_id('category_menu_groups',['id_category_menu'=>$id_category_menu]);
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

	public function save_category_menu()
	{
		if(!$this->input->is_ajax_request())
        {
            show_404();
        }else{
        	$output	= ['success'=>false,
                       'messages'=>[]
                      ];
            $category_menu  = $this->category_menu_model;
            $validation     = $this->form_validation;
            $validation->set_rules($category_menu->rules_save());
        	$validation->set_error_delimiters('<p class="text-danger">','</p>');

        	if($validation->run())
        	{
                $data_group = [];
                $group      = $this->input->post('group');
                $id_category_menu = $category_menu->save_category_menu();
                foreach($group as $key):
                    $data_group[] = ['id_group'         => $group[$key],
                                     'id_category_menu' => $id_category_menu
                                    ];
                endforeach;
                $category_menu->delete_category_menu_groups(['id_category_menu'=>$id_category_menu]);
                $category_menu->save_category_menu_groups($data_group);

                $output['order_number'] = $category_menu->auto_order_number();
        		$output['success'] 	    = true;
                $output['messages']     = "Category Menu berhasil di simpan";
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

    public function update_category_menu()
    {
        if(!$this->input->is_ajax_request())
        {
            show_404();
        }else{
            $output = ['success'=>false,
                       'messages'=>[]
                      ];
            $category_menu  = $this->category_menu_model;
            $validation     = $this->form_validation;
            $validation->set_rules($category_menu->rules_update());
            $validation->set_error_delimiters('<p class="text-danger">','</p>');

            if($validation->run())
            {
                $data_group = [];
                $group      = $this->input->post('group');
                $id_category_menu = $category_menu->update_category_menu();
                foreach($group as $key):
                    $data_group[] = ['id_group'         => $group[$key],
                                     'id_category_menu' => $id_category_menu
                                    ];
                endforeach;
                $category_menu->delete_category_menu_groups(['id_category_menu'=>$id_category_menu]);
                $category_menu->save_category_menu_groups($data_group);
                $output['success']  = true;
                $output['messages'] = "Category Menu berhasil di update";
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

    public function delete_category_menu()
    {
        if(!$this->input->is_ajax_request())
        {
            show_404();
        }else{
            $category_menu    = $this->category_menu_model;
            $result           = $category_menu->delete_category_menu();
            if($result):
                $output['order_number'] = $category_menu->auto_order_number();
                $output['success']      = true;
                $output['messages']     = "Category Menu berhasil dihapus";
            else:
                $output['success']      = false;
                $output['messages']     = "Category Menu gagal dihapus";
            endif;

            echo json_encode($output);
        }
    }

    /*----------  End Category Menu  ----------*/

    /*----------  Master Menu  ----------*/

    public function master_menu()
    {
        $breadcrumbs    = $this->breadcrumbs;
        $master_menu    = $this->master_menu_model;

        $breadcrumbs->add('Home', base_url());
        $breadcrumbs->add('Management Menu', base_url($this->router->fetch_class()));
        $breadcrumbs->add('Master Menu', base_url());
        $breadcrumbs->render();

        $data['title']          = "Master Menu";
        $data['icon']           = "metismenu-icon pe-7s-menu";
        $data['description']    = "Menampilkan Master Menu";
        $data['breadcrumbs']    = $breadcrumbs->render();
        $data['category_menu']  = $master_menu->get_master_category_menu();
        $data['master_group']   = $master_menu->get_master_group();
        $page                   = 'management_menu/master_menu/index';
        $data['link']           = $this->router->fetch_method();
        $data['menu']           = $this->load->view('layout/menu', $data, true);
        $data['extra_css']      = $this->load->view('management_menu/master_menu/css',$data,true);
        $data['extra_js']       = $this->load->view('management_menu/master_menu/js',$data,true);
        $data['modal']          = $this->load->view('management_menu/master_menu/modal', $data, true);
        $this->template->load('backend_template',$page,$data);
    }

    public function get_master_menu_order_number()
    {
        if(!$this->input->is_ajax_request())
        {
            show_404();
        }else{
            $master_menu = $this->master_menu_model;
            $result      = $master_menu->get_order_number();
            echo json_encode($result);
        }
    }

    public function get_master_menu()
    {
        if(!$this->input->is_ajax_request())
        {
            show_404();
        }else{
            $master_menu    = $this->master_menu_model;
            $output         = ['success'    => false,
                               'data'       => [],
                               'messages'   => ''
                              ];
            $id_menu        = $this->input->get('idMenu');
            $result         = $master_menu->get_by_id('menu',['id_menu'=>$id_menu])->row();
            $result_group   = $master_menu->get_by_id('menu_groups',['id_menu'=>$id_menu]);
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

    public function save_master_menu()
    {
        if(!$this->input->is_ajax_request())
        {
            show_404();
        }else{
            $output = ['success'=>false,
                       'messages'=>[]
                      ];
            $master_menu  = $this->master_menu_model;
            $validation   = $this->form_validation;
            $validation->set_rules($master_menu->rules_save());
            $validation->set_error_delimiters('<p class="text-danger">','</p>');

            if($validation->run())
            {
                $data_group = [];
                $group      = $this->input->post('group');
                $id_menu    = $master_menu->save_master_menu();
                foreach($group as $key):
                    $data_group[] = ['id_group' => $group[$key],
                                     'id_menu'  => $id_menu
                                    ];
                endforeach;
                $master_menu->delete_menu_groups(['id_menu'=>$id_menu]);
                $master_menu->save_menu_groups($data_group);

                $output['success']      = true;
                $output['messages']     = "Master Menu berhasil di simpan";
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

    public function update_master_menu()
    {
        if(!$this->input->is_ajax_request())
        {
            show_404();
        }else{
            $output = ['success'=>false,
                       'messages'=>[]
                      ];
            $master_menu    = $this->master_menu_model;
            $validation     = $this->form_validation;
            $validation->set_rules($master_menu->rules_update());
            $this->form_validation->set_error_delimiters('<p class="text-danger">','</p>');

            if($validation->run())
            {
                $data_group = [];
                $group      = $this->input->post('group');
                $id_menu    = $master_menu->update_master_menu();
                foreach($group as $key):
                    $data_group[] = ['id_group' => $group[$key],
                                     'id_menu'  => $id_menu
                                    ];
                endforeach;
                $master_menu->delete_menu_groups(['id_menu'=>$id_menu]);
                $master_menu->save_menu_groups($data_group);

                $output['success']  = true;
                $output['messages'] = "Master Menu berhasil di update";
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

    public function delete_master_menu()
    {
        if(!$this->input->is_ajax_request())
        {
            show_404();
        }else{
            $master_menu    = $this->master_menu_model;
            $result         = $master_menu->delete_master_menu();
            if($result):
                $output['success']      = true;
                $output['messages']     = "Master Menu berhasil dihapus";
            else:
                $output['success']      = false;
                $output['messages']     = "Master Menu gagal dihapus";
            endif;

            echo json_encode($output);
        }
    }

    public function dt_master_menu()
    {
        if(!$this->input->is_ajax_request())
        {
            show_404();
        }else{
            $where          = array('id_menu !='=>0);
            $column_order   = array('','order_number','category_name','menu_name','link','is_parent','is_active');
            $column_search  = array('category_name','menu_name');
            $order = array('order_number' => 'ASC');
            $list = $this->datatables_model->get_datatables('v_menu',$column_order,$column_search,$order,$where);
            $data = array();
            $no = $_POST['start'];
            foreach ($list as $lists) {
                $no++;
                $row            = array();
                $row[]          = $no;
                $row[]          = $lists->category_name;
                $row[]          = $lists->menu_name;
                $row[]          = "<i class='{$lists->icon}'></i>";
                $row[]          = $lists->link;
                $row[]          = $lists->is_parent;
                $row[]          = $lists->is_active;
                $row[]          = '<button class="btn btn-info btn-sm" onclick="editMasterMenu('."'".$lists->id_menu."'".')"><i class="far fa-edit"></i></button> <button class="btn btn-danger btn-sm" onclick="deleteMasterMenu('."'".$lists->id_menu."'".')"><i class="fas fa-trash"></i></button>';

                $data[] = $row;
            }

            $output = array(
                            "draw" => $_POST['draw'],
                            "recordsTotal" => $this->datatables_model->count_all('v_menu',$where),
                            "recordsFiltered" => $this->datatables_model->count_filtered('v_menu',$column_order,$column_search,$order,$where),
                            "data" => $data,
                    );

            echo json_encode($output);
        }
    }

    /*----------  Sub Menu  ----------*/
    public function sub_menu()
    {
        $breadcrumbs    = $this->breadcrumbs;
        $sub_menu       = $this->sub_menu_model;

        $breadcrumbs->add('Home', base_url());
        $breadcrumbs->add('Management Menu', base_url($this->router->fetch_class()));
        $breadcrumbs->add('Master Menu', base_url('management_menu/master_menu'));
        $breadcrumbs->add('Sub Menu', base_url());
        $breadcrumbs->render();

        $data['title']          = "Sub Menu";
        $data['icon']           = "metismenu-icon pe-7s-menu";
        $data['description']    = "Menampilkan Sub Menu";
        $data['breadcrumbs']    = $breadcrumbs->render();
        $data['master_menu']    = $sub_menu->get_master_menu();
        $data['master_group']   = $sub_menu->get_master_group();
        $page                   = 'management_menu/sub_menu/index';
        $data['link']           = $this->router->fetch_method();
        $data['menu']           = $this->load->view('layout/menu', $data, true);
        $data['extra_css']      = $this->load->view('management_menu/sub_menu/css',$data,true);
        $data['extra_js']       = $this->load->view('management_menu/sub_menu/js',$data,true);
        $data['modal']          = $this->load->view('management_menu/sub_menu/modal', $data, true);
        $this->template->load('backend_template',$page,$data);
    }

    public function get_sub_menu_order_number()
    {
        if(!$this->input->is_ajax_request())
        {
            show_404();
        }else{
            $sub_menu   = $this->sub_menu_model;
            $result     = $sub_menu->get_order_number();
            echo json_encode($result);
        }
    }

    public function get_sub_menu()
    {
        if(!$this->input->is_ajax_request())
        {
            show_404();
        }else{
            $sub_menu   = $this->sub_menu_model;
            $output     = ['success'    => false,
                           'data'       => [],
                           'messages'   => ''
                          ];
            $id_sub_menu    = $this->input->get('idSubMenu');
            $result         = $sub_menu->get_by_id('sub_menu',['id_sub_menu'=>$id_sub_menu])->row();
            $result_group   = $sub_menu->get_by_id('sub_menu_groups',['id_sub_menu'=>$id_sub_menu]);
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

    public function save_sub_menu()
    {
        if(!$this->input->is_ajax_request())
        {
            show_404();
        }else{
            $output = ['success'=>false,
                       'messages'=>[]
                      ];
            $sub_menu   = $this->sub_menu_model;
            $validation = $this->form_validation;
            $validation->set_rules($sub_menu->rules_save());
            $validation->set_error_delimiters('<p class="text-danger">','</p>');

            if($validation->run())
            {
                $data_group     = [];
                $group          = $this->input->post('group');
                $id_sub_menu    = $sub_menu->save_sub_menu();
                if(!empty($group)):
                    foreach($group as $key):
                        $data_group[] = ['id_group'    => $group[$key],
                                         'id_sub_menu' => $id_sub_menu
                                        ];
                    endforeach;
                    $sub_menu->delete_sub_menu_groups(['id_sub_menu'=>$id_sub_menu]);
                    $sub_menu->save_sub_menu_groups($data_group);
                endif;

                $output['success']      = true;
                $output['messages']     = "Sub Menu berhasil di simpan";
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

    public function update_sub_menu()
    {
        if(!$this->input->is_ajax_request())
        {
            show_404();
        }else{
            $output = ['success'=>false,
                       'messages'=>[]
                      ];
            $sub_menu   = $this->sub_menu_model;
            $validation = $this->form_validation;
            $validation->set_rules($sub_menu->rules_update());
            $this->form_validation->set_error_delimiters('<p class="text-danger">','</p>');

            if($validation->run())
            {
                $data_group = [];
                $group      = $this->input->post('group');
                $id_sub_menu= $sub_menu->update_sub_menu();
                if(!empty($group)):
                    foreach($group as $key):
                        $data_group[] = ['id_group' => $group[$key],
                                         'id_sub_menu'  => $id_sub_menu
                                        ];
                    endforeach;
                    $sub_menu->delete_sub_menu_groups(['id_sub_menu'=>$id_sub_menu]);
                    $sub_menu->save_sub_menu_groups($data_group);
                endif;

                $output['success']  = true;
                $output['messages'] = "Sub Menu berhasil di update";
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

    public function delete_sub_menu()
    {
        if(!$this->input->is_ajax_request())
        {
            show_404();
        }else{
            $sub_menu   = $this->sub_menu_model;
            $result     = $sub_menu->delete_sub_menu();
            if($result):
                $output['success']      = true;
                $output['messages']     = "Sub Menu berhasil dihapus";
            else:
                $output['success']      = false;
                $output['messages']     = "Sub Menu gagal dihapus";
            endif;

            echo json_encode($output);
        }
    }

    public function dt_sub_menu()
    {
        if(!$this->input->is_ajax_request())
        {
            show_404();
        }else{
            $where          = array('id_menu !='=>0);
            $column_order   = array('','order_number','category_name','menu_name','link','is_parent','is_active');
            $column_search  = array('category_name','menu_name');
            $order = array('order_number' => 'ASC');
            $list = $this->datatables_model->get_datatables('v_sub_menu',$column_order,$column_search,$order,$where);
            $data = array();
            $no = $_POST['start'];
            foreach ($list as $lists) {
                $no++;
                $row            = array();
                $row[]          = $no;
                $row[]          = $lists->menu_name;
                $row[]          = $lists->order_number;
                $row[]          = $lists->sub_menu_name;
                $row[]          = $lists->link_parent;
                $row[]          = $lists->link;
                $row[]          = $lists->is_active;
                $row[]          = '<button class="btn btn-info btn-sm" onclick="editSubMenu('."'".$lists->id_sub_menu."'".')"><i class="far fa-edit"></i></button> <button class="btn btn-danger btn-sm" onclick="deleteSubMenu('."'".$lists->id_sub_menu."'".')"><i class="fas fa-trash"></i></button>';

                $data[] = $row;
            }

            $output = array(
                            "draw" => $_POST['draw'],
                            "recordsTotal" => $this->datatables_model->count_all('v_sub_menu',$where),
                            "recordsFiltered" => $this->datatables_model->count_filtered('v_sub_menu',$column_order,$column_search,$order,$where),
                            "data" => $data,
                    );

            echo json_encode($output);
        }
    }
    /*----------  End Sub Menu  ----------*/
}