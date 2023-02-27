<?php

/**
 * Author     : Alfikri, M.Kom
 * Created By : Alfikri, M.Kom
 * E-Mail     : alfikri.name@gmail.com
 * No HP      : 081277337405
 * Class      : Management_users.php
 */
defined('BASEPATH') or exit('No direct script access allowed');

class Management_users extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model([
            'management_users/master_user_model' => 'master_user_model',
            'management_users/helpdesk_model'    => 'helpdesk_model',
            'datatables_model'                   => 'datatables_model'
        ]);
    }

    public function master_user()
    {
        $breadcrumbs    = $this->breadcrumbs;
        $master_user     = $this->master_user_model;

        $breadcrumbs->add('Home', base_url());
        $breadcrumbs->add('Management Users', base_url($this->router->fetch_class()));
        $breadcrumbs->add('Master User', base_url());
        $breadcrumbs->render();

        $data['title']          = "Master User";
        $data['icon']           = "metismenu-icon pe-7s-user";
        $data['description']    = "Menampilkan Master User";
        $data['breadcrumbs']    = $breadcrumbs->render();
        $data['master_instansi'] = $master_user->get_master_instansi();
        $data['master_user']    = $master_user->get_master_user();
        $data['master_group']   = $master_user->get_master_group();
        $page                   = 'management_users/master_user/index';
        $data['id_instansi']           = id_instansi();
        $data['id_group']           = $this->session->userdata('id_group');
        $data['link']           = $this->router->fetch_method();
        $data['menu']           = $this->load->view('layout/menu', $data, true);
        $data['extra_css']      = $this->load->view('management_users/master_user/css', $data, true);
        $data['extra_js']       = $this->load->view('management_users/master_user/js', $data, true);
        $data['modal']          = $this->load->view('management_users/master_user/modal', $data, true);
        $this->template->load('backend_template', $page, $data);
    }
    public function admin_kab_kota()
    {
        if ($this->session->userdata('id_group')==5) {
            redirect('management_users/master_user');
        }
        $breadcrumbs    = $this->breadcrumbs;
        $master_user     = $this->master_user_model;

        $breadcrumbs->add('Home', base_url());
        $breadcrumbs->add('Management Users', base_url($this->router->fetch_class()));
        $breadcrumbs->add('Admin Kab / Kota', base_url());
        $breadcrumbs->render();

        $data['title']          = "Admin Kab / Kota";
        $data['icon']           = "metismenu-icon pe-7s-user";
        $data['description']    = "Menampilkan Data Master User khusus Admin kabupaten Kota";
        $data['breadcrumbs']    = $breadcrumbs->render();
        $data['daftar_kota']    = $this->db->query("SELECT id_kota, nama_kota FROM kota where id_provinsi = '13'");
        $data['master_group']   = $master_user->get_master_group();
        $page                   = 'management_users/admin_kab_kota/index';
        $data['link']           = $this->router->fetch_method();
        $data['menu']           = $this->load->view('layout/menu', $data, true);
        $data['extra_css']      = $this->load->view('management_users/admin_kab_kota/css', $data, true);
        $data['extra_js']       = $this->load->view('management_users/admin_kab_kota/js', $data, true);
        $data['modal']          = $this->load->view('management_users/admin_kab_kota/modal', $data, true);
        $this->template->load('backend_template', $page, $data);
    }

    public function dt_master_user()
    {
        if (!$this->input->is_ajax_request()) {
            show_404();
        } else {
            $id_group = $this->session->userdata('id_group');
            $id_instansi = id_instansi();
            if ($id_group == 5) {
                $where             = array('id_user !=' => 0, 'id_kota'=>'', 'id_kedudukan'=> null, 'id_group'=> $id_group, 'id_instansi'=> $id_instansi);
                # code...
            }else{
                $where             = array('id_user !=' => 0, 'id_kota'=>'', 'id_kedudukan'=> null);

            }
            $column_order   = array('', 'nama_instansi', 'parent_name', 'group_name', 'full_name', 'email', 'is_active', 'updated_on');
            $column_search  = array('nama_instansi', 'group_name', 'full_name');
            $order = array('id_instansi' => 'ASC');
            $list = $this->datatables_model->get_datatables('v_users', $column_order, $column_search, $order, $where);
            $data = array();
            $no = $_POST['start'];
            foreach ($list as $lists) {

                $iduser         = sbe_crypt($lists->id_user, 'E');
                $no++;
                $row            = array();
                $row[]          = $no;
                $row[]          = $lists->nama_instansi;

                $row[]          = $lists->group_name;
                $row[]          = $lists->username;
                $row[]          = $lists->full_name;
                $row[]          = $lists->email;
                $row[]          = $lists->is_active;

                if ($lists->id_user==id_user()) {
                $row[]          = '<button class="btn btn-warning btn-xs" onclick="edit_master_user(' . "'" . $iduser. "'" . ')">
                                   <i class="far fa-edit"></i>
                                   </button>';
                    # code...
                }else{
                $row[]          = '<button class="btn btn-warning btn-xs" onclick="edit_master_user(' . "'" . $iduser. "'" . ')">
                                   <i class="far fa-edit"></i>
                                   </button>
                                   <button class="btn btn-danger btn-xs" onclick="deleteUser(' . "'" . $iduser . "'" . ')">
                                   <i class="fas fa-trash"></i>
                                   </button>';
                               }

                $data[] = $row;
            }

            $output = array(
                "draw" => $_POST['draw'],
                "recordsTotal" => $this->datatables_model->count_all('v_users', $where),
                "recordsFiltered" => $this->datatables_model->count_filtered('v_users', $column_order, $column_search, $order, $where),
                "data" => $data,
            );

            echo json_encode($output);
        }
    }
    public function dt_helpdesk()
    {
        if (!$this->input->is_ajax_request()) {
            show_404();
        } else {
            $id_group = $this->input->post('id_group');
            $where             = array('id_group' => $id_group, 'id_kota'=>'', 'id_kedudukan'=> null);
            $column_order   = array('', 'nama_instansi', 'parent_name', 'group_name', 'full_name', 'email', 'is_active', 'updated_on');
            $column_search  = array('nama_instansi', 'group_name', 'full_name');
            $order = array('id_instansi' => 'ASC');
            $list = $this->datatables_model->get_datatables('v_users', $column_order, $column_search, $order, $where);
            $data = array();
            $no = $_POST['start'];
            foreach ($list as $lists) {

                $iduser         = sbe_crypt($lists->id_user, 'E');
                $id_user = $lists->id_user;
                $q_instansi = $this->db->query("SELECT id_instansi from helpdesk_instansi where id_user='$id_user'")->num_rows();
                $no++;
                $row            = array();
                $row[]          = $no;
                $row[]          = $lists->nama_instansi;

                $row[]          = $lists->group_name;
                $row[]          = $lists->username;
                $row[]          = $lists->full_name;
                $row[]          = $q_instansi;       
                // $row[]          = $lists->is_active;
                $row[]          = '<button type="button" class="btn-shadow btn btn-primary btn-xs" onclick="show_opd('. "'". $lists->id_user ."'" .')">View</button>';

                // if ($lists->group_name=='ADMIN') {
                // $row[]          = "";
                //     # code...
                // }else{
                // $row[]          = '<button class="btn btn-warning btn-xs" onclick="edit_master_user(' . "'" . $iduser. "'" . ')">
                //                    <i class="far fa-edit"></i>
                //                    </button>
                //                    <button class="btn btn-danger btn-xs" onclick="deleteUser(' . "'" . $iduser . "'" . ')">
                //                    <i class="fas fa-trash"></i>
                //                    </button>';
                //                }

                $data[] = $row;
            }

            $output = array(
                "draw" => $_POST['draw'],
                "recordsTotal" => $this->datatables_model->count_all('v_users', $where),
                "recordsFiltered" => $this->datatables_model->count_filtered('v_users', $column_order, $column_search, $order, $where),
                "data" => $data,
            );

            echo json_encode($output);
        }
    }
    public function dt_helpdesk_progul()
    {
        if (!$this->input->is_ajax_request()) {
            show_404();
        } else {
            $id_group = $this->input->post('id_group');
            $where             = array('id_group' => $id_group, 'id_kota'=>'', 'id_kedudukan'=> null);
            $column_order   = array('', 'nama_instansi', 'parent_name', 'group_name', 'full_name', 'email', 'is_active', 'updated_on');
            $column_search  = array('nama_instansi', 'group_name', 'full_name');
            $order = array('id_instansi' => 'ASC');
            $list = $this->datatables_model->get_datatables('v_users', $column_order, $column_search, $order, $where);
            $data = array();
            $no = $_POST['start'];
            foreach ($list as $lists) {

                $iduser         = sbe_crypt($lists->id_user, 'E');
                $id_user = $lists->id_user;
                $q_instansi = $this->db->query("SELECT id_instansi from helpdesk_instansi where id_user='$id_user'")->num_rows();
                $no++;
                $row            = array();
                $row[]          = $no;
                $row[]          = $lists->nama_instansi;

                $row[]          = $lists->group_name;
                $row[]          = $lists->username;
                $row[]          = $lists->full_name;
                // $row[]          = $q_instansi;       
                // $row[]          = '<button type="button" class="btn-shadow btn btn-primary btn-xs" onclick="show_opd('. "'". $lists->id_user ."'" .')">View</button>';

             
                $data[] = $row;
            }

            $output = array(
                "draw" => $_POST['draw'],
                "recordsTotal" => $this->datatables_model->count_all('v_users', $where),
                "recordsFiltered" => $this->datatables_model->count_filtered('v_users', $column_order, $column_search, $order, $where),
                "data" => $data,
            );

            echo json_encode($output);
        }
    }

    public function dt_master_user_kab_kota()
    {
        if (!$this->input->is_ajax_request()) {
            show_404();
        } else {
            $where             = array('id_kota !=' =>'');
            $column_order   = array('', 'nama_instansi', 'parent_name', 'group_name', 'full_name', 'email', 'is_active', 'updated_on');
            $column_search  = array('nama_instansi', 'group_name', 'full_name');
            $order = array('id_instansi' => 'ASC');
            $list = $this->datatables_model->get_datatables('v_users', $column_order, $column_search, $order, $where);
            $data = array();
            $no = $_POST['start'];
            foreach ($list as $lists) {
                $id_kota = $lists->id_kota;
                $q_kota = $this->db->query("SELECT k.nama_kota, p.nama_provinsi from kota k left join provinsi p on k.id_provinsi=p.id_provinsi where k.id_kota='$id_kota'")->row_array();
                $iduser         = sbe_crypt($lists->id_user, 'E');
                $no++;
                $row            = array();
                $row[]          = $no;
                $row[]          = $q_kota['nama_kota'];

                $row[]          = $lists->group_name;
                $row[]          = $lists->username;
                $row[]          = $lists->full_name;
                $row[]          = $lists->email;
                $row[]          = $lists->is_active;

                if ($lists->group_name=='ADMIN') {
                $row[]          = "";
                    # code...
                }else{
                $row[]          = '<button class="btn btn-warning btn-xs" onclick="edit_master_user(' . "'" . $iduser. "'" . ')">
                                   <i class="far fa-edit"></i>
                                   </button>
                                   <button class="btn btn-danger btn-xs" onclick="deleteUser(' . "'" . $iduser . "'" . ')">
                                   <i class="fas fa-trash"></i>
                                   </button>';
                               }

                $data[] = $row;
            }

            $output = array(
                "draw" => $_POST['draw'],
                "recordsTotal" => $this->datatables_model->count_all('v_users', $where),
                "recordsFiltered" => $this->datatables_model->count_filtered('v_users', $column_order, $column_search, $order, $where),
                "data" => $data,
            );

            echo json_encode($output);
        }
    }

    public function get_master_user()
    {
        if (!$this->input->is_ajax_request()) {
            show_404();
        } else {
            $master_user    = $this->master_user_model;
            $output         = [
                'success'    => false,
                'data'       => [],
                'messages'   => ''
            ];
            $id_instansi    = decrypt($this->input->get('idInstansi'));
            $full_result    = [];
            $default_result = [];
            $result         = $master_user->get_by_id('master_users', ['id_instansi' => $id_instansi], ['id_user', 'full_name']);
            foreach ($result->result() as $key => $values) {
                $full_result[$key]['id_user'] = encrypt($values->id_user);
                $full_result[$key]['full_name'] = $values->full_name;
            }
            $result_default = $master_user->get_by_id('master_users', ['id_instansi' => 0], ['id_user', 'full_name']);
            foreach ($result_default->result() as $key => $values) {
                $default_result[$key]['id_user']   = encrypt($values->id_user);
                $default_result[$key]['full_name'] = $values->full_name;
            }

            if ($result->num_rows() > 0) {
                $output['success'] = true;
                $output['data']    = $full_result;
                $output['messages'] = "Success";
            } else {
                $output['success'] = false;
                $output['data']    = $default_result;
                $output['messages'] = "Default";
            }
            echo json_encode($output);
        }
    }

    public function get_user_group()
    {
        if (!$this->input->is_ajax_request()) {
            show_404();
        } else {
            $master_user    = $this->master_user_model;
            $output         = [
                'success'    => false,
                'data'       => [],
                'messages'   => ''
            ];
            $id_user        = decrypt($this->input->get('idUser'));

            if (get_group_name($id_user) == "SUPER ADMIN") {
                $result = $master_user->get_master_group();
            } else {
                $result = $master_user->get_user_group(['id_group'], ['id_user' => $id_user]);
            }

            $output['data'] = $result->result();

            echo json_encode($output);
        }
    }

    public function save_master_user()
    {
        if (!$this->input->is_ajax_request()) {
            show_404();
        } else {
            $output    = [
                'success' => false,
                'messages' => []
            ];
            $master_user    = $this->master_user_model;
            $validation     = $this->form_validation;
            $validation->set_rules($master_user->rules_save());
            $validation->set_error_delimiters('<p class="text-danger">', '</p>');

            if ($validation->run()) {
                
                $group      = $this->input->post('group');
                $id_user    = $master_user->save_master_user();
                
                
                        $data_group = [
                            'id_instansi'  => decrypt($this->input->post('idInstansi')),
                            'id_group'     => $group,
                            'id_user'      => $id_user
                        ];
                   
               
                $master_user->delete_master_user_groups(['id_user' => $id_user]);
                $master_user->save_master_user_groups($data_group);

                $output['success']     = true;
                $output['messages'] = "User berhasil di simpan";
            } else {
                $output['success'] = false;
                foreach ($_POST as $key => $value) {
                    $output['messages'][$key] = form_error($key);
                }
            }

            echo json_encode($output);
        }
    }

    public function save_master_user_kab_kota()
    {
        if (!$this->input->is_ajax_request()) {
            show_404();
        } else {
            $output    = [
                'success' => false,
                'messages' => []
            ];
            $master_user    = $this->master_user_model;
            $validation     = $this->form_validation;
            $validation->set_rules($master_user->rules_save_user_kab_kota());
            $validation->set_error_delimiters('<p class="text-danger">', '</p>');

            if ($validation->run()) {
                
                $group      = $this->input->post('group');
                $id_user    = $master_user->save_master_user_kab_kota();
                
                
                        $data_group = [
                            'id_instansi'  => decrypt($this->input->post('id_kota')),
                            'id_group'     => $group,
                            'id_user'      => $id_user
                        ];
                   
               
                $master_user->delete_master_user_groups(['id_user' => $id_user]);
                $master_user->save_master_user_groups($data_group);


                $post                       = $this->input->post();
                $id_provinsi = 13;
                $id_kota = decrypt($post['id_kota']);
                $q_config = $this->db->query("SELECT * from config_kab_kota where id_provinsi='$id_provinsi' and id_kota = '$id_kota' ");
                if ($q_config->num_rows()==0) {
                    $data_config = [
                            'id_provinsi'  => $id_provinsi,
                            'id_kota'  => $id_kota,
                            'tahun_anggaran'     => tahun_anggaran(),
                            'tahapan_apbd'      => tahapan_apbd(),
                            'realisasi_fisik_mulai'      => mulai_upload_realisasi_fisik(),
                            'realisasi_fisik_selesai'      => deadline_upload(),
                            'bulan_aktif'      => bulan_aktif()
                        ];
                        $this->db->insert('config_kab_kota', $data_config);
                }

                $output['success']     = true;
                $output['messages'] = "User berhasil di simpan";
            } else {
                $output['success'] = false;
                foreach ($_POST as $key => $value) {
                    $output['messages'][$key] = form_error($key);
                }
            }

            echo json_encode($output);
        }
    }

    public function saveedit_master_user()
    {
        if (!$this->input->is_ajax_request()) {
            show_404();
        } else {
            $output    = [
                'success' => false,
                'messages' => []
            ];
            $post 						= $this->input->post();
            $master_user    = $this->master_user_model;
            $validation     = $this->form_validation;
            $validation->set_rules($master_user->rules_saveedit());
            $validation->set_error_delimiters('<p class="text-danger">', '</p>');

            if ($validation->run()) {
                
                $group      = $this->input->post('group');
                $id_user    = $this->input->post('idUser');
                $username    = $this->input->post('username');
                $password    = $this->input->post('password');
                $passwordConfirm    = $this->input->post('passwordConfirm');
                
                
                        $data_group = [
                            'id_instansi'  => decrypt($this->input->post('idInstansi')),
                            'id_group'     => $group,
                            'id_user'      => $id_user
                        ];
                   
               $cek_username = $this->db->query("SELECT username from master_users where username='$username' and id_user!='$id_user'")->num_rows();
               if ($cek_username>0) {
                    $output['success']     = false;
                    $output['messages']['username'] = '<p class="text-danger">Username sudah dipakai</p>';
                   # code...
               }else{

               		if ($password=='') {

		                $master_user->saveedit_master_user_no_password();
	                    $master_user->delete_master_user_groups(['id_user' => $id_user]);
	                    $master_user->save_master_user_groups($data_group);
	                    $output['success']     = true;
	                    $output['messages'] = "User berhasil di simpan";
	                    $output['cek'] = $post;

               			
               		}else{
               			if ($password!=$passwordConfirm) {
               				$output['success']     = false;
		                    $output['messages']['passwordConfirm'] = '<p class="text-danger">Password tidak sama</p>';
               			}else{
							$id_user    = $master_user->saveedit_master_user();
							$master_user->delete_master_user_groups(['id_user' => $id_user]);
							$master_user->save_master_user_groups($data_group);
							$output['success']     = true;
							$output['messages'] = "User berhasil di simpan";
               			}
               		}


               }
            } else {
                $output['success'] = false;
                foreach ($_POST as $key => $value) {
                    $output['messages'][$key] = form_error($key);
                }
            }

            echo json_encode($output);
        }
    }



    public function get_user()
    {
        if (!$this->input->is_ajax_request()) {
            show_404();
        } else {
            $output = [
                'status'    => false,
                'data'      => []
            ];

            $id_user = sbe_crypt($this->input->post('id_user'), 'D');
            $user    = $this->db->get_where('master_users', ['id_user' => $id_user]);
            if ($user->num_rows() > 0) {
                $value= $user->row();
                $group = $this->db->query("SELECT id_group from users_groups where id_user='$id_user'")->row()->id_group;    
                    $output['data']['id_user']                  = $value->id_user;
                    $output['data']['id_instansi']                  = encrypt($value->id_instansi);
                    $output['data']['full_name']                  = $value->full_name;
                    $output['data']['username']                  = $value->username;
                    $output['data']['nohp']                  = $value->nohp;
                    $output['data']['email']                  = $value->email;
                    $output['data']['group']                  = $group;
                    $output['data']['is_active']                  = $value->is_active;
                 

                $output['status'] = true;
            }

                $output['cek'] = $id_user;
            echo json_encode($output);
        }
    }
    public function helpdesk()
    {
        if ($this->session->userdata('id_group')==5) {
            redirect('management_users/master_user');
        }

        $fetch_method = $this->router->fetch_method();
        $breadcrumbs    = $this->breadcrumbs;
        $helpdesk       = $this->helpdesk_model;

        $breadcrumbs->add('Home', base_url());
        $breadcrumbs->add('Management Users', base_url($this->router->fetch_class()));
        $breadcrumbs->add('Helpdesk', base_url());
        $breadcrumbs->render();

        $data['title']          = "Helpdesk";
        $data['icon']           = "metismenu-icon pe-7s-user";
        $data['description']    = "Menampilkan Helpdesk";
        $data['breadcrumbs']    = $breadcrumbs->render();
        $page                   = 'management_users/helpdesk/index';
        $data['link']           = $this->router->fetch_method();
        $data['menu']           = $this->load->view('layout/menu', $data, true);
        $data['extra_css']      = $this->load->view('management_users/helpdesk/css', $data, true);
        $data['extra_js']       = $this->load->view('management_users/helpdesk/js', $data, true);
        $data['modal']          = $this->load->view('management_users/helpdesk/modal', $data, true);
        $this->template->load('backend_template', $page, $data);
    }

    public function get_helpdesk()
    {
        if (!$this->input->is_ajax_request()) {
            show_404();
        } else {
            $output = [
                'status'    => false,
                'data'      => [],
                'message'   => ''
            ];

            $helpdesk = $this->helpdesk_model->get_helpdesk();
            if ($helpdesk->num_rows() > 0) {
                foreach ($helpdesk->result() as $key => $value) {
                    $output['data'][$key]['id_user']        = sbe_crypt($value->id_user, 'E');
                    $output['data'][$key]['full_name']      = $value->full_name;
                    $output['data'][$key]['username']       = $value->username;
                    $output['data'][$key]['jml_instansi']   = $value->jml_instansi;
                }

                $output['status'] = true;
            } else {
                $output['status'] = false;
            }

            echo json_encode($output);
        }
    }
    public function statistika_helpdesk()
    {
        if (!$this->input->is_ajax_request()) {
            show_404();
        } else {
            $output = [
                'status'    => false,
                'data'      => [],
                'message'   => ''
            ];

            $q = $this->db->query("SELECT id_group, count(*) as jml_data FROM users_groups group by id_group");
            if ($q->num_rows() > 0) {
                foreach ($q->result() as $key => $value) {
                    $output['data'][$key]['id_group']        = $value->id_group;
                    $output['data'][$key]['jml_data']   = $value->jml_data;
                }

                $output['status'] = true;
            } else {
                $output['status'] = false;
            }

            echo json_encode($output);
        }
    }
    public function identitas_user()
    {
        if (!$this->input->is_ajax_request()) {
            show_404();
        } else {
            $output = [
                'status'    => false,
                'data'      => [],
                'message'   => ''
            ];
                $id_user = $this->input->post('id_user');
                $q = $this->db->query("SELECT * from master_users where id_user = '$id_user'")->row_array();
            $helpdesk = $this->helpdesk_model->get_helpdesk();
            $output['data']['full_name']      = $q['full_name'];
            $output['data']['username']      = $q['username'];

            echo json_encode($output);
        }
    }

    public function dt_opd()
    {
        if (!$this->input->is_ajax_request()) {
            show_404();
        } else {
            $id_user        = $this->input->post('id_user');
            $where          = array('id_user' => $id_user);
            $column_order   = array('', 'nama_instansi');
            $column_search  = array('nama_instansi');
            $order = array('nama_instansi' => 'ASC');
            $list = $this->datatables_model->get_datatables('v_helpdesk_instansi', $column_order, $column_search, $order, $where);
            $data = array();
            $no = $_POST['start'];
            foreach ($list as $lists) {
                $no++;
                $row    = array();
                $row[]  = $no;
                $row[]  = $lists->nama_instansi;
                $row[]  = '<button type="button" class="btn btn-danger btn-sm" onclick="hapus_opd(' . "'" . $lists->id_helpdesk_instansi . "','" . sbe_crypt($lists->id_user, 'E') . "'" . ')">
                                   <i class="fas fa-trash"></i>
                                   </button>';

                $data[] = $row;
            }

            $output = array(
                "draw" => $_POST['draw'],
                "recordsTotal" => $this->datatables_model->count_all('v_helpdesk_instansi', $where),
                "recordsFiltered" => $this->datatables_model->count_filtered('v_helpdesk_instansi', $column_order, $column_search, $order, $where),
                "data" => $data,
            );

            echo json_encode($output);
        }
    }

    public function get_opd()
    {
        if (!$this->input->is_ajax_request()) {
            show_404();
        } else {
            $output = [
                'status'    => false,
                'data'      => [],
                'message'   => ''
            ];

            $data_opd = $this->helpdesk_model->get_opd();
            if ($data_opd->num_rows() > 0) {
                foreach ($data_opd->result() as $key => $value) {
                    $output['data'][$key]['id_instansi']    = sbe_crypt($value->id_instansi, 'E');
                    $output['data'][$key]['kode_opd']       = $value->kode_opd;
                    $output['data'][$key]['nama_instansi']  = $value->nama_instansi;
                }

                $output['status'] = true;
            }

            echo json_encode($output);
        }
    }

    public function save()
    {
        if (!$this->input->is_ajax_request()) {
            show_404();
        } else {
            $output = [
                'status'    => false,
                'data'      => [],
                'message'   => ''
            ];

            $id_user        = $this->input->post('id_user');
            $id_instansi    = sbe_crypt($this->input->post('id_instansi'), 'D');
            $tahun = tahun_anggaran();

            $data = [
                'id_user'       => $id_user,
                'id_instansi'   => $id_instansi,
                'tahun'   => $tahun
            ];

            $save = $this->helpdesk_model->save($data);

            if ($save) {
                $output['status'] = true;
            }

            echo json_encode($output);
        }
    }

    public function delete_helpdesk_instansi()
    {
        if (!$this->input->is_ajax_request()) {
            show_404();
        } else {
            $output = [
                'status'    => false,
                'data'      => [],
                'message'   => ''
            ];

            $id_helpdesk_instansi = $this->input->post('id_helpdesk_instansi');

            $delete = $this->helpdesk_model->delete($id_helpdesk_instansi);

            if ($delete) {
                $output['status'] = true;
            }

            echo json_encode($output);
        }
    }
    public function delete_user()
    {
        if (!$this->input->is_ajax_request()) {
            show_404();
        } else {
            $output = [
                'status'    => false,
                'data'      => [],
                'message'   => ''
            ];

            $id_user = sbe_crypt($this->input->post('id_user'), 'D');

            $delete_master = $this->db->delete('master_users',['id_user'=>$id_user]);
            $delete_group = $this->db->delete('users_groups',['id_user'=>$id_user]);

            // if ($delete) {
                $output['status'] = true;
            // }

            echo json_encode($output);
        }
    }
}
