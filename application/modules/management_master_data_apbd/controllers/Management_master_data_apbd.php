<?php

/**
 * Author     : Alfikri, M.Kom
 * Created By : Alfikri, M.Kom
 * E-Mail     : alfikri.name@gmail.com
 * No HP      : 081277337405
 * Class      : Management_users.php
 */
defined('BASEPATH') or exit('No direct script access allowed');

class Management_master_data_apbd extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        error_reporting(0);
        $this->load->model([
            'management_master_data_apbd/master_data_apbd_model' => 'master_data_apbd_model',
            'datatables_model'                   => 'datatables_model'
        ]);
    }

    
   
    public function program()
    {
        $breadcrumbs    = $this->breadcrumbs;
        $model     = $this->master_data_apbd_model;

        $breadcrumbs->add('Home', base_url());
        $breadcrumbs->add('Management APBD', base_url($this->router->fetch_class()));
        $breadcrumbs->add('Master Program', base_url());
        $breadcrumbs->render();

        $data['title']          = "Master Program";
        $data['icon']           = "metismenu-icon pe-7s-user";
        $data['description']    = "Menampilkan Master Program";
        $data['breadcrumbs']    = $breadcrumbs->render();
        $page                   = 'management_master_data_apbd/master_program/index';
        $data['link']           = $this->router->fetch_method();
        $data['menu']           = $this->load->view('layout/menu', $data, true);
        $data['extra_css']      = $this->load->view('management_master_data_apbd/master_program/css', $data, true);
        $data['extra_js']       = $this->load->view('management_master_data_apbd/master_program/js', $data, true);
        $data['modal']          = $this->load->view('management_master_data_apbd/master_program/modal', $data, true);
        $this->template->load('backend_template', $page, $data);
    }


    public function di_usulkan_skpd()
    {
        $breadcrumbs     = $this->breadcrumbs;

        $breadcrumbs->add('Home', base_url());
        $breadcrumbs->add('Data APBD', base_url($this->router->fetch_class()));
        
        $breadcrumbs->render();
        $data['input_by']                      = "";
        $data['title']                      = "Data APBD";
        $data['icon']                       = "metismenu-icon fa fa-list-ul";
        $data['description']                = "Menampilkan Data APBD";
        $data['breadcrumbs']                = $breadcrumbs->render();
        $page                               = 'management_master_data_apbd/di_usulkan_skpd/index';
        $data['link']                       = $this->router->fetch_method();
        $data['menu']                       = $this->load->view('layout/menu', $data, true);
        $data['extra_css']                  = $this->load->view('management_master_data_apbd/di_usulkan_skpd/css', $data, true);
        $data['extra_js']                   = $this->load->view('management_master_data_apbd/di_usulkan_skpd/js', $data, true);
        $data['modal']                      = $this->load->view('management_master_data_apbd/di_usulkan_skpd/modal', $data, true);


       
        $this->template->load('backend_template', $page, $data);
    }

    public function dt_master_program()
    {
        if (!$this->input->is_ajax_request()) {
            show_404();
        } else {
            $where             = array();
            $column_order   = array('', 'nama_program', 'kode_program');
            $column_search  = array('nama_program', 'kode_program');
            $order = array('kode_program' => 'ASC');
            $list = $this->datatables_model->get_datatables('master_program', $column_order, $column_search, $order, $where);
            $data = array();
            $no = $_POST['start'];
            // $group = ['DEVELOPER','SUPER ADMIN','ADMIN','PIMPINAN','HELPDESK','OPERATOR','User Khusus','PEMERINTAH KAB & KOTA'];
            foreach ($list as $lists) {
            	if ($lists->id_group_pengusul=='5') {
            		$diusulkan = "Operator SKPD<br>".nama_instansi(91);
            		# code...
            	}else{
            		$diusulkan = "Admin";
            	}
              	
                $no++;
                $row            = array();
                $row[]          = $no;
                $row[]          = $lists->kode_program;
                $row[]          = $lists->nama_program;
                $row[]          = $diusulkan;
                $row[]  = '<button class="btn btn-info btn-sm" onclick="edit_program(' . "'" . $lists->id_program . "'," . ')"><i class="fas fa-edit"></i></button> <button class="btn btn-danger btn-sm" onclick="delete_program(' . "'" . $lists->id_program . "','" .$lists->nama_program. "')\"" .'><i class="fa fa-times"></i></button>';

               

              

                $data[] = $row;
            }

            $output = array(
                "draw" => $_POST['draw'],
                "recordsTotal" => $this->datatables_model->count_all('master_program', $where),
                "recordsFiltered" => $this->datatables_model->count_filtered('master_program', $column_order, $column_search, $order, $where),
                "data" => $data,
            );

            echo json_encode($output);
        }
    }


    public function delete_program()
    {
        if (!$this->input->is_ajax_request()) {
            show_404();
        } else {
            $output = [
                'status'    => false,
                'id_pptk'   => '',
                'rekening'  => ''
            ];

            $id_program = $this->input->post('id_program');
            
                $this->db->delete('master_program', ['id_program' => $id_program]);
                $output['status']   = true;

            echo json_encode($output);
        }
    }




    public function save_master_program()
    {
        if (!$this->input->is_ajax_request()) {
            show_404();
        } else {
            $output    = [
                'success' => false,
                'messages' => []
            ];
            $model    = $this->master_data_apbd_model;
            $validation     = $this->form_validation;
            $validation->set_rules($model->rules_save());
            $validation->set_error_delimiters('<p class="text-danger">', '</p>');

            if ($validation->run()) {
                





                $post                       = $this->input->post();
                $kode = trim(str_replace(' ', '', $post['kode']));
                $pecah = explode('.', $kode);
                $j_pecah = count($pecah);
                if ($j_pecah==3) {
                    $query_cek_program=$this->db->query("SELECT * from master_program where kode_program='$kode' and status !=1");
                    $j_cek_program = $query_cek_program->num_rows();
                    if ($j_cek_program>0) {
                        $data_program = $query_cek_program->row();
                        $status = $data_program->status;
                        $keterangan_status         = ["Pengusulan","Ditolak Admin","Disetujui Admin"];
                        if ($status=='') {
                            $keterangan = "Program dengan kode ".$kode." sudah ditambahkan Admin";
                        }else{
                           if ($data_program->id_user_pengusul==id_user()) {
                                $keterangan = "Program dengan kode ".$kode." sudah pernah anda tambahkan dengan status ".$keterangan_status[$status];
                                # code...
                            }else{
                                $keterangan = "Program dengan kode ".$kode." sudah ditambahkan oleh Operator lain dengan status ".$keterangan_status[$status];
                            }

                        }
                        $output['success']     = false;
                        $output['messages']['kode'] = '<p class="text-danger">'.$keterangan.'</p>';
                        # code...
                    }else{
                        $id_user    = $model->save_master_program();
                        $output['success']     = true;

                    }
                 
                }else{
                $output['success']     = false;
                $output['messages']['kode'] = '<p class="text-danger">Penulisan kode program salah.<br>Silahkan lihat cara penginputan bagian usulkan program </p>';
                }


            } else {
                $output['success'] = false;
                foreach ($_POST as $key => $value) {
                    $output['messages'][$key] = form_error($key);
                }
            }
                $output['post']     = $this->input->post();

            echo json_encode($output);
        }
    }

    public function saveedit_master_program()
    {
        if (!$this->input->is_ajax_request()) {
            show_404();
        } else {
            $output    = [
                'success' => false,
                'messages' => []
            ];
            $model    = $this->master_data_apbd_model;
            $validation     = $this->form_validation;
            $validation->set_rules($model->rules_save());
            $validation->set_error_delimiters('<p class="text-danger">', '</p>');

            if ($validation->run()) {
                
                $id_user    = $model->saveedit_master_program();


                $output['success']     = true;
                $output['messages'] = "User berhasil di simpan";
            } else {
                $output['success'] = false;
                foreach ($_POST as $key => $value) {
                    $output['messages'][$key] = form_error($key);
                }
            }
                $output['post']     = $this->input->post();

            echo json_encode($output);
        }
    }


    public function get_program()
    {
        if (!$this->input->is_ajax_request()) {
            show_404();
        } else {
            $output = [
                'status'    => false,
                'data'      => []
            ];

            $id_program = $this->input->post('id_program');
            $program    = $this->db->get_where('master_program', ['id_program' => $id_program]);
            if ($program->num_rows() > 0) {
                $value= $program->row();
               
                    $output['data']['id']                  = $value->id_program;
                    $output['data']['kode']                  = $value->kode_program;
                    $output['data']['nama']                  = $value->nama_program;

                $output['status'] = true;
            }

                

            echo json_encode($output);
        }
    }
    
   
    public function kegiatan()
    {
        $breadcrumbs    = $this->breadcrumbs;
        $model     = $this->master_data_apbd_model;

        $breadcrumbs->add('Home', base_url());
        $breadcrumbs->add('Management APBD', base_url($this->router->fetch_class()));
        $breadcrumbs->add('Master Kegiatan', base_url());
        $breadcrumbs->render();

        $data['title']          = "Master kegiatan";
        $data['icon']           = "metismenu-icon pe-7s-user";
        $data['description']    = "Menampilkan Master Kegiatan";
        $data['breadcrumbs']    = $breadcrumbs->render();
        $page                   = 'management_master_data_apbd/master_kegiatan/index';
        $data['link']           = $this->router->fetch_method();
        $data['menu']           = $this->load->view('layout/menu', $data, true);
        $data['extra_css']      = $this->load->view('management_master_data_apbd/master_kegiatan/css', $data, true);
        $data['extra_js']       = $this->load->view('management_master_data_apbd/master_kegiatan/js', $data, true);
        $data['modal']          = $this->load->view('management_master_data_apbd/master_kegiatan/modal', $data, true);
        $this->template->load('backend_template', $page, $data);
    }

    public function dt_master_kegiatan()
    {
        if (!$this->input->is_ajax_request()) {
            show_404();
        } else {
            $where             = array();
            $column_order   = array('', 'nama_kegiatan', 'kode_kegiatan');
            $column_search  = array('nama_kegiatan', 'kode_kegiatan');
            $order = array('kode_kegiatan' => 'ASC');
            $list = $this->datatables_model->get_datatables('master_kegiatan', $column_order, $column_search, $order, $where);
            $data = array();
            $no = $_POST['start'];
            foreach ($list as $lists) {
              	if ($lists->id_group_pengusul=='5') {
            		$diusulkan = "Operator SKPD<br>".nama_instansi(91);
            		# code...
            	}else{
            		$diusulkan = "Admin";
            	}
                $no++;
                $row            = array();
                $row[]          = $no;
                $row[]          = $lists->kode_kegiatan;
                $row[]          = $lists->nama_kegiatan;
                $row[]          = $diusulkan;
                $row[]  = '<button class="btn btn-info btn-sm" onclick="edit_kegiatan(' . "'" . $lists->id_kegiatan . "'," . ')"><i class="fas fa-edit"></i></button> <button class="btn btn-danger btn-sm" onclick="delete_kegiatan(' . "'" . $lists->id_kegiatan . "','" .$lists->nama_kegiatan. "')\"" .'><i class="fa fa-times"></i></button>';
                $data[] = $row;
            }

            $output = array(
                "draw" => $_POST['draw'],
                "recordsTotal" => $this->datatables_model->count_all('master_kegiatan', $where),
                "recordsFiltered" => $this->datatables_model->count_filtered('master_kegiatan', $column_order, $column_search, $order, $where),
                "data" => $data,
            );

            echo json_encode($output);
        }
    }

    public function delete_kegiatan()
    {
        if (!$this->input->is_ajax_request()) {
            show_404();
        } else {
            $output = [
                'status'    => false,
                'id_pptk'   => '',
                'rekening'  => ''
            ];

            $id_kegiatan = $this->input->post('id_kegiatan');
            
                $this->db->delete('master_kegiatan', ['id_kegiatan' => $id_kegiatan]);
                $output['status']   = true;

            echo json_encode($output);
        }
    }

    public function save_master_kegiatan()
    {
        if (!$this->input->is_ajax_request()) {
            show_404();
        } else {
            $output    = [
                'success' => false,
                'messages' => []
            ];
            $model    = $this->master_data_apbd_model;
            $validation     = $this->form_validation;
            $validation->set_rules($model->rules_save());
            $validation->set_error_delimiters('<p class="text-danger">', '</p>');

            if ($validation->run()) {
                
                $post                       = $this->input->post();
                $kode = trim(str_replace(' ', '', $post['kode']));
                $pecah = explode('.', $kode);
                $j_pecah = count($pecah);
                if ($j_pecah==5) {
                    $query_cek_kegiatan=$this->db->query("SELECT * from master_kegiatan where kode_kegiatan='$kode' and status !=1");
                    $j_cek_kegiatan = $query_cek_kegiatan->num_rows();
                    if ($j_cek_kegiatan>0) {
                        $data_kegiatan = $query_cek_kegiatan->row();
                        $status = $data_kegiatan->status;
                        $keterangan_status         = ["Pengusulan","Ditolak Admin","Disetujui Admin"];
                        if ($status=='') {
                            $keterangan = "kegiatan dengan kode ".$kode." sudah ditambahkan Admin";
                        }else{
                            if ($data_kegiatan->id_user_pengusul==id_user()) {
                                $keterangan = "Kegiatan dengan kode ".$kode." sudah pernah anda tambahkan dengan status ".$keterangan_status[$status];
                                # code...
                            }else{
                                $keterangan = "Kegiatan dengan kode ".$kode." sudah ditambahkan oleh Operator lain dengan status ".$keterangan_status[$status];
                            }

                        }
                        $output['success']     = false;
                        $output['messages']['kode'] = '<p class="text-danger">'.$keterangan.'</p>';
                        # code...
                    }else{
                        $id_user    = $model->save_master_kegiatan();
                        $output['success']     = true;

                    }
                 
                }else{
                $output['success']     = false;
                $output['messages']['kode'] = '<p class="text-danger">Penulisan kode kegiatan salah.<br>Kode harus berisi 5 digit</p>';
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

    public function saveedit_master_kegiatan()
    {
        if (!$this->input->is_ajax_request()) {
            show_404();
        } else {
            $output    = [
                'success' => false,
                'messages' => []
            ];
            $model    = $this->master_data_apbd_model;
            $validation     = $this->form_validation;
            $validation->set_rules($model->rules_save());
            $validation->set_error_delimiters('<p class="text-danger">', '</p>');

            if ($validation->run()) {
                
                $id_user    = $model->saveedit_master_kegiatan();


                $output['success']     = true;
                $output['messages'] = "User berhasil di simpan";
            } else {
                $output['success'] = false;
                foreach ($_POST as $key => $value) {
                    $output['messages'][$key] = form_error($key);
                }
            }
                $output['post']     = $this->input->post();

            echo json_encode($output);
        }
    }

    public function get_kegiatan()
    {
        if (!$this->input->is_ajax_request()) {
            show_404();
        } else {
            $output = [
                'status'    => false,
                'data'      => []
            ];

            $id_kegiatan = $this->input->post('id_kegiatan');
            $kegiatan    = $this->db->get_where('master_kegiatan', ['id_kegiatan' => $id_kegiatan]);
            if ($kegiatan->num_rows() > 0) {
                $value= $kegiatan->row();
               
                    $output['data']['id']                  = $value->id_kegiatan;
                    $output['data']['kode']                  = $value->kode_kegiatan;
                    $output['data']['nama']                  = $value->nama_kegiatan;

                $output['status'] = true;
            }
            echo json_encode($output);
        }
    }
































































   
    public function sub_kegiatan()
    {
        $breadcrumbs    = $this->breadcrumbs;
        $model     = $this->master_data_apbd_model;

        $breadcrumbs->add('Home', base_url());
        $breadcrumbs->add('Management APBD', base_url($this->router->fetch_class()));
        $breadcrumbs->add('Master Sub Kegiatan', base_url());
        $breadcrumbs->render();

        $data['title']          = "Master Sub Kegiatan";
        $data['icon']           = "metismenu-icon pe-7s-user";
        $data['description']    = "Menampilkan Master Sub Kegiatan";
        $data['breadcrumbs']    = $breadcrumbs->render();
        $page                   = 'management_master_data_apbd/master_sub_kegiatan/index';
        $data['link']           = $this->router->fetch_method();
        $data['menu']           = $this->load->view('layout/menu', $data, true);
        $data['extra_css']      = $this->load->view('management_master_data_apbd/master_sub_kegiatan/css', $data, true);
        $data['extra_js']       = $this->load->view('management_master_data_apbd/master_sub_kegiatan/js', $data, true);
        $data['modal']          = $this->load->view('management_master_data_apbd/master_sub_kegiatan/modal', $data, true);
        $this->template->load('backend_template', $page, $data);
    }

    public function dt_master_sub_kegiatan()
    {
        if (!$this->input->is_ajax_request()) {
            show_404();
        } else {
            $pemaketan = [''=>'Belum ditentukan','bebas'=>'Bebas (Rutin, Swakelola, Penyedia)', 'wajib_evidence'=>'Wajib Evidence (Swakelola, Penyedia)'];
            $status = ['Tidak Aktif', 'Aktif'];
            $where             = array();
            $column_order   = array('', 'nama_sub_kegiatan', 'kode_sub_kegiatan');
            $column_search  = array('nama_sub_kegiatan', 'kode_sub_kegiatan');
            $order = array('kode_sub_kegiatan' => 'ASC');
            $list = $this->datatables_model->get_datatables('master_sub_kegiatan', $column_order, $column_search, $order, $where);
            $data = array();
            $no = $_POST['start'];
            foreach ($list as $lists) {
            	if ($lists->id_group_pengusul=='5') {
            		$diusulkan = "Operator SKPD<br>".nama_instansi(91);
            		# code...
            	}else{
            		$diusulkan = "Admin";
            	}

              
                $no++;
                $row            = array();
                $row[]          = $no;
                $row[]          = $lists->kode_sub_kegiatan;
                $row[]          = $lists->nama_sub_kegiatan;
                $row[]          = $diusulkan;
                $row[]          = $pemaketan[$lists->pemaketan];
                $row[]          = $status[$lists->status];
                $row[]  = '<button class="btn btn-info btn-sm" onclick="edit_sub_kegiatan(' . "'" . $lists->id_sub_kegiatan . "'," . ')"><i class="fas fa-edit"></i></button> <button class="btn btn-danger btn-sm" onclick="delete_sub_kegiatan(' . "'" . $lists->id_sub_kegiatan . "','" .$lists->nama_sub_kegiatan. "')\"" .'><i class="fa fa-times"></i></button>';

               

              

                $data[] = $row;
            }

            $output = array(
                "draw" => $_POST['draw'],
                "recordsTotal" => $this->datatables_model->count_all('master_sub_kegiatan', $where),
                "recordsFiltered" => $this->datatables_model->count_filtered('master_sub_kegiatan', $column_order, $column_search, $order, $where),
                "data" => $data,
            );

            echo json_encode($output);
        }
    }


    public function delete_sub_kegiatan()
    {
        if (!$this->input->is_ajax_request()) {
            show_404();
        } else {
            $output = [
                'status'    => false,
                'id_pptk'   => '',
                'rekening'  => ''
            ];

            $id_sub_kegiatan = $this->input->post('id_sub_kegiatan');
            
                $this->db->delete('master_sub_kegiatan', ['id_sub_kegiatan' => $id_sub_kegiatan]);
                $output['status']   = true;

            echo json_encode($output);
        }
    }




    public function save_master_sub_kegiatan()
    {
        if (!$this->input->is_ajax_request()) {
            show_404();
        } else {
            $output    = [
                'success' => false,
                'messages' => []
            ];
            $model    = $this->master_data_apbd_model;
            $validation     = $this->form_validation;
            $validation->set_rules($model->rules_save());
            $validation->set_error_delimiters('<p class="text-danger">', '</p>');

            if ($validation->run()) {
                


                $post        = $this->input->post();
                $kode = trim(str_replace(' ', '', $post['kode']));
                $pecah = explode('.', $kode);
                $j_pecah = count($pecah);
                if ($j_pecah==6) {
                    $query_cek_sub_kegiatan=$this->db->query("SELECT * from master_sub_kegiatan where kode_sub_kegiatan='$kode' and status !=1");
                    $j_cek_sub_kegiatan = $query_cek_sub_kegiatan->num_rows();
                    if ($j_cek_sub_kegiatan>0) {
                        $data_sub_kegiatan = $query_cek_sub_kegiatan->row();
                        $status = $data_sub_kegiatan->status;
                        $keterangan_status         = ["Pengusulan","Ditolak Admin","Disetujui Admin"];
                        if ($status=='') {
                            $keterangan = "Sub kegiatan dengan kode ".$kode." sudah ditambahkan Admin";
                        }else{
                            if ($data_sub_kegiatan->id_user_pengusul==id_user()) {
                                $keterangan = "sub_kegiatan dengan kode ".$kode." sudah pernah anda tambahkan dengan status ".$keterangan_status[$status];
                                # code...
                            }else{
                                $keterangan = "sub_kegiatan dengan kode ".$kode." sudah ditambahkan oleh Operator lain dengan status ".$keterangan_status[$status];
                            }

                        }
                        $output['success']     = false;
                        $output['messages']['kode'] = '<p class="text-danger">'.$keterangan.'</p>';
                        # code...
                    }else{
                        $id_user    = $model->save_master_sub_kegiatan();
                        $output['success']     = true;
                        $output['messages'] = "Sub Kegiatan berhasil di simpan";

                    }
                 
                }else{
                $output['success']     = false;
                $output['messages']['kode'] = '<p class="text-danger">Penulisan kode sub_kegiatan salah.<br>Kode harus berisi 5 digit</p>';
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

    public function saveedit_master_sub_kegiatan()
    {
        if (!$this->input->is_ajax_request()) {
            show_404();
        } else {
            $output    = [
                'success' => false,
                'messages' => []
            ];
            $model    = $this->master_data_apbd_model;
            $validation     = $this->form_validation;
            $validation->set_rules($model->rules_save());
            $validation->set_error_delimiters('<p class="text-danger">', '</p>');

            if ($validation->run()) {
                
                $id_user    = $model->saveedit_master_sub_kegiatan();


                $output['success']     = true;
                $output['messages'] = "User berhasil di simpan";
            } else {
                $output['success'] = false;
                foreach ($_POST as $key => $value) {
                    $output['messages'][$key] = form_error($key);
                }
            }
                $output['post']     = $this->input->post();

            echo json_encode($output);
        }
    }


    public function get_sub_kegiatan()
    {
        if (!$this->input->is_ajax_request()) {
            show_404();
        } else {
            $output = [
                'status'    => false,
                'data'      => []
            ];

            $id_sub_kegiatan = $this->input->post('id_sub_kegiatan');
            $sub_kegiatan    = $this->db->get_where('master_sub_kegiatan', ['id_sub_kegiatan' => $id_sub_kegiatan]);
            if ($sub_kegiatan->num_rows() > 0) {
                $value= $sub_kegiatan->row();
               
                    $output['data']['id']                  = $value->id_sub_kegiatan;
                    $output['data']['kode']                  = $value->kode_sub_kegiatan;
                    $output['data']['nama']                  = $value->nama_sub_kegiatan;

                $output['status'] = true;
            }

                

            echo json_encode($output);
        }
    }




    public function export_master_sub_kegiatan()
    {
        if ($this->input->is_ajax_request()) {
            show_404();
        } else {
            set_time_limit(0);
            $output = [
                'status' => false,
                'data'   => []
            ];

            $id                 =id_instansi();
            $primary_folder     = './sbe_files_support/';
            $directory          = [
                'export_master_data',
               id_instansi(),
            ];
            $list_directory = $this->sbe_directory($primary_folder, $directory);

            if (!file_exists($list_directory)) {
                mkdir($list_directory, 0777, TRUE);
            }
            // untuk menghapus file sebelumnya
        
            // untuk menghapus file sebelumnya

            $namafiledisimpan = "MasterSubKegiatan_".date('Ymdhis');
            $config['upload_path']   = $list_directory;
            $config['overwrite']     = true;
            $config['allowed_types'] = 'xlsx';
            $config['encrypt_name']  = false;
            $config['file_name']     = $namafiledisimpan;
            $config['max_size']      = '10000';

            $this->load->library('upload', $config);

            if (!$this->upload->do_upload('upload_file')) {
                $output['status']   = false;
                $output['message']  = $this->upload->display_errors();
            } else {
                include APPPATH.'third_party/PHPExcel/PHPExcel.php';
                $excelreader     = new PHPExcel_Reader_Excel2007();
                $loadexcel         = $excelreader->load($_FILES['upload_file']['tmp_name']); // Load file yang telah diupload ke folder excel
                $apbd             = $loadexcel->setActiveSheetIndex(0)->toArray(true, true, true ,true);
                
                $this->db->trans_start();

                $data_apbd = array();
                $id_instansi = id_instansi();
                $tahap = tahapan_apbd();
                $numrow = 1;
                $error = 0;
                $pesan = "";
                foreach($apbd as $row){
                            if($numrow > 1){
                                $ksk = trim($row['A']);
                                $nama = $row['B'];
                                $pecah = explode('.', $ksk);
                                $count_pecah = count($pecah);
                                if ($count_pecah==6) {
                                 
                                $kode_sub_kegiatan = $pecah[0].'.'.$pecah[1].'.'.$pecah[2].'.'.$pecah[3].'.'.$pecah[4].'.'.$pecah[5];
                                $kode_kegiatan = $pecah[0].'.'.$pecah[1].'.'.$pecah[2].'.'.$pecah[3].'.'.$pecah[4];
                                $kode_program = $pecah[0].'.'.$pecah[1].'.'.$pecah[2];
                                $kd_sub_kegiatan = $pecah[5];
                                $kd_kegiatan = $pecah[3].'.'.$pecah[4];
                                $kd_program = $pecah[2];
                                $kode_bu = $pecah[0].'.'.$pecah[1];

                                // if (!$kd_sub_kegiatan) {
                                //     $error = $error+1;
                                //     $pesan .= 'Baris '.$row."<br>";
                                // }
                            $data = [
                                     'kode_bidang_urusan'           => $kode_bu,
                                     'kd_sub_kegiatan'          => $kd_sub_kegiatan,
                                     'kode_sub_kegiatan'            => str_replace(' ', '', $kode_sub_kegiatan),
                                     'kd_program'           => $kd_program,
                                     'kode_program'         => $kode_program ,
                                     'kd_kegiatan'          => $kd_kegiatan,
                                     'kode_kegiatan'            => $kode_kegiatan ,
                                     'nama_sub_kegiatan'            => $nama,
                                     'tahun'            => tahun_anggaran(),
                                     'created_on'           => timestamp(),
                                     'created_by'           => id_user(),
                                     'input_by'         => "Export Excel",
                                    ];



                                $cek_msk = $this->db->query("SELECT kode_sub_kegiatan from master_sub_kegiatan where kode_sub_kegiatan='$ksk'")->num_rows();
                                if ($cek_msk==0) {
                                    $this->db->insert("master_sub_kegiatan",$data);
                                }else{
                                    
                                }




                              }
                              else{
                                $error +=1;
                                $pesan .= "Baris ".$numrow." error <br>";# code...
                               
                              }   
                            }
                            $numrow++;
                        }
               
            // $this->db->insert_batch('sub_kegiatan_instansi', $data_apbd);
            // $this->db->insert_batch('tes_cronjob', $data2);

             

                  
                $upload = ['upload_data' => $this->upload->data()];
                $file_ext = pathinfo($_FILES["upload_file"]["name"], PATHINFO_EXTENSION);
                $output['status']   = true;


                if ($error>0) {
                    $this->db->trans_rollback();
                    $pesan_flashdata = '<div class="alert alert-info">'.$pesan.'<br>Silahkan perbaiki kode pada baris tersebut.!</div>';
                    # code...
                }else{
                    $this->db->trans_commit();
                    $pesan_flashdata = '<div class="alert alert-info">Data Master Sub Kegiatan berhasil di export</div>';
                    // $pesan_flashdata = '<div class="alert alert-info">Program berhail di export</div>';

                }
            }
            // $output['cek'] = $list_directory;
            // echo json_encode($output);
            $this->session->set_flashdata('pesan', $pesan_flashdata);
            redirect('management_master_data_apbd/sub_kegiatan');
        }
    }



    public function export_master_kegiatan()
    {
        if ($this->input->is_ajax_request()) {
            show_404();
        } else {
            set_time_limit(0);
            $output = [
                'status' => false,
                'data'   => []
            ];

            $id                 =id_instansi();
            $primary_folder     = './sbe_files_support/';
            $directory          = [
                'export_master_data',
               id_instansi(),
            ];
            $list_directory = $this->sbe_directory($primary_folder, $directory);

            if (!file_exists($list_directory)) {
                mkdir($list_directory, 0777, TRUE);
            }
            // untuk menghapus file sebelumnya
        
            // untuk menghapus file sebelumnya

            $namafiledisimpan = "MasterKegiatan_".date('Ymdhis');
            $config['upload_path']   = $list_directory;
            $config['overwrite']     = true;
            $config['allowed_types'] = 'xlsx';
            $config['encrypt_name']  = false;
            $config['file_name']     = $namafiledisimpan;
            $config['max_size']      = '10000';

            $this->load->library('upload', $config);

            if (!$this->upload->do_upload('upload_file')) {
                $output['status']   = false;
                $output['message']  = $this->upload->display_errors();
            } else {
                include APPPATH.'third_party/PHPExcel/PHPExcel.php';
                $excelreader     = new PHPExcel_Reader_Excel2007();
                $loadexcel         = $excelreader->load($_FILES['upload_file']['tmp_name']); // Load file yang telah diupload ke folder excel
                $apbd             = $loadexcel->setActiveSheetIndex(0)->toArray(true, true, true ,true);
                
                $this->db->trans_start();

                $data_apbd = array();
                $id_instansi = id_instansi();
                $tahap = tahapan_apbd();
                $numrow = 1;
                $error = 0;
                $pesan = "";
                foreach($apbd as $row){
                            if($numrow > 1){
                                $kk = trim($row['A']);
                                $nama = $row['B'];
                                $pecah = explode('.', $kk);
                                $count_pecah = count($pecah);
                                if ($count_pecah ==5) {
                                   
                                
                                $kode_kegiatan = $pecah[0].'.'.$pecah[1].'.'.$pecah[2].'.'.$pecah[3].'.'.$pecah[4];
                                $kode_bu = $pecah[0].'.'.$pecah[1];
                                $kd_kegiatan = $pecah[3].'.'.$pecah[4];
                                $kode_program = $pecah[0].'.'.$pecah[1].'.'.$pecah[2];
                                $kd_program = $pecah[2];

                                $data = [
                                         'kode_bidang_urusan'           => $kode_bu,
                                         'kd_kegiatan'          => $kd_kegiatan,
                                         'kode_kegiatan'            => trim($kode_kegiatan),
                                         'kd_program'           => $kd_program,
                                         'kode_program'         => trim($kode_program ),
                                         'nama_kegiatan'            => $nama,
                                         'tahun'            => tahun_anggaran(),
                                         'created_on'           => timestamp(),
                                         'created_by'           => id_user(),
                                         'input_by'         => "Export Excel",
                                        
                                        ];



                                $cek_mk = $this->db->query("SELECT kode_kegiatan from master_kegiatan where kode_kegiatan='$kode_kegiatan'")->num_rows();
                                if ($cek_mk==0) {
                                    $this->db->insert("master_kegiatan",$data);
                                }else{
                                    
                                }


                                }else{
                                    $error +=1;
                                    $pesan .='Baris ke '.$numrow.' Error<br>';
                                    // echo "Baris ke ".$numrow." error ";
                                }

                                 
                            }
                            $numrow++;
                        }
               
            // $this->db->insert_batch('sub_kegiatan_instansi', $data_apbd);
            // $this->db->insert_batch('tes_cronjob', $data2);

             

                  
                $upload = ['upload_data' => $this->upload->data()];
                $file_ext = pathinfo($_FILES["upload_file"]["name"], PATHINFO_EXTENSION);
                $output['status']   = true;


                if ($error>0) {
                    $this->db->trans_rollback();
                    $pesan_flashdata = '<div class="alert alert-info">'.$pesan.'<br>Silahkan perbaiki kesalahan pada baris tersebut.</div>';
                    # code...
                }else{
                    $this->db->trans_commit();
                    $pesan_flashdata = '<div class="alert alert-info">Data Master Sub Kegiatan berhasil di export</div>';
                    // $pesan_flashdata = '<div class="alert alert-info">Program berhail di export</div>';

                }
            }
            // $output['cek'] = $list_directory;
            // echo json_encode($output);
            $this->session->set_flashdata('pesan', $pesan_flashdata);
            redirect('management_master_data_apbd/kegiatan');
        }
    }






















































































    
   
    public function bidang_urusan()
    {
        $breadcrumbs    = $this->breadcrumbs;
        $model     = $this->master_data_apbd_model;

        $breadcrumbs->add('Home', base_url());
        $breadcrumbs->add('Management APBD', base_url($this->router->fetch_class()));
        $breadcrumbs->add('Master Bidang Urusan', base_url());
        $breadcrumbs->render();

        $data['title']          = "Master Bidang Urusan";
        $data['icon']           = "metismenu-icon pe-7s-user";
        $data['description']    = "Menampilkan Master Bidang Urusan";
        $data['breadcrumbs']    = $breadcrumbs->render();
        $page                   = 'management_master_data_apbd/master_bidang_urusan/index';
        $data['link']           = $this->router->fetch_method();
        $data['menu']           = $this->load->view('layout/menu', $data, true);
        $data['extra_css']      = $this->load->view('management_master_data_apbd/master_bidang_urusan/css', $data, true);
        $data['extra_js']       = $this->load->view('management_master_data_apbd/master_bidang_urusan/js', $data, true);
        $data['modal']          = $this->load->view('management_master_data_apbd/master_bidang_urusan/modal', $data, true);
        $this->template->load('backend_template', $page, $data);
    }

    public function dt_master_bidang_urusan()
    {
        if (!$this->input->is_ajax_request()) {
            show_404();
        } else {
            $where             = array();
            $column_order   = array('', 'nama_bidang_urusan', 'kode_bidang_urusan');
            $column_search  = array('nama_bidang_urusan', 'kode_bidang_urusan');
            $order = array('kode_bidang_urusan' => 'ASC');
            $list = $this->datatables_model->get_datatables('master_bidang_urusan', $column_order, $column_search, $order, $where);
            $data = array();
            $no = $_POST['start'];
            foreach ($list as $lists) {

              
                $no++;
                $row            = array();
                $row[]          = $no;
                $row[]          = $lists->kode_bidang_urusan;
                $row[]          = $lists->nama_bidang_urusan;
                $row[]  = '<button class="btn btn-info btn-sm" onclick="edit_bidang_urusan(' . "'" . $lists->id_bidang_urusan . "'," . ')"><i class="fas fa-edit"></i></button> <button class="btn btn-danger btn-sm" onclick="delete_bidang_urusan(' . "'" . $lists->id_bidang_urusan . "','" .$lists->nama_bidang_urusan. "')\"" .'><i class="fa fa-times"></i></button>';

               

              

                $data[] = $row;
            }

            $output = array(
                "draw" => $_POST['draw'],
                "recordsTotal" => $this->datatables_model->count_all('master_bidang_urusan', $where),
                "recordsFiltered" => $this->datatables_model->count_filtered('master_bidang_urusan', $column_order, $column_search, $order, $where),
                "data" => $data,
            );

            echo json_encode($output);
        }
    }


    public function delete_bidang_urusan()
    {
        if (!$this->input->is_ajax_request()) {
            show_404();
        } else {
            $output = [
                'status'    => false,
                'id_pptk'   => '',
                'rekening'  => ''
            ];

            $id_bidang_urusan = $this->input->post('id_bidang_urusan');
            
                $this->db->delete('master_bidang_urusan', ['id_bidang_urusan' => $id_bidang_urusan]);
                $output['status']   = true;

            echo json_encode($output);
        }
    }




    public function save_master_bidang_urusan()
    {
        if (!$this->input->is_ajax_request()) {
            show_404();
        } else {
            $output    = [
                'success' => false,
                'messages' => []
            ];
            $model    = $this->master_data_apbd_model;
            $validation     = $this->form_validation;
            $validation->set_rules($model->rules_save());
            $validation->set_error_delimiters('<p class="text-danger">', '</p>');

            if ($validation->run()) {
                
                $id_user    = $model->save_master_bidang_urusan();


                $output['success']     = true;
                $output['messages'] = "User berhasil di simpan";
            } else {
                $output['success'] = false;
                foreach ($_POST as $key => $value) {
                    $output['messages'][$key] = form_error($key);
                }
            }
                $output['post']     = $this->input->post();

            echo json_encode($output);
        }
    }

    public function saveedit_master_bidang_urusan()
    {
        if (!$this->input->is_ajax_request()) {
            show_404();
        } else {
            $output    = [
                'success' => false,
                'messages' => []
            ];
            $model    = $this->master_data_apbd_model;
            $validation     = $this->form_validation;
            $validation->set_rules($model->rules_save());
            $validation->set_error_delimiters('<p class="text-danger">', '</p>');

            if ($validation->run()) {
                
                $id_user    = $model->saveedit_master_bidang_urusan();


                $output['success']     = true;
                $output['messages'] = "User berhasil di simpan";
            } else {
                $output['success'] = false;
                foreach ($_POST as $key => $value) {
                    $output['messages'][$key] = form_error($key);
                }
            }
                $output['post']     = $this->input->post();

            echo json_encode($output);
        }
    }


    public function get_bidang_urusan()
    {
        if (!$this->input->is_ajax_request()) {
            show_404();
        } else {
            $output = [
                'status'    => false,
                'data'      => []
            ];

            $id_bidang_urusan = $this->input->post('id_bidang_urusan');
            $bidang_urusan    = $this->db->get_where('master_bidang_urusan', ['id_bidang_urusan' => $id_bidang_urusan]);
            if ($bidang_urusan->num_rows() > 0) {
                $value= $bidang_urusan->row();
               
                    $output['data']['id']                  = $value->id_bidang_urusan;
                    $output['data']['kode']                  = $value->kode_bidang_urusan;
                    $output['data']['nama']                  = $value->nama_bidang_urusan;

                $output['status'] = true;
            }
            echo json_encode($output);
        }
    }



    // ===========================================================================================================================================
    // Khusus diusulkan SKPD

    public function dt_usulan_program()
    {
        if (!$this->input->is_ajax_request()) {
            show_404();
        } else {
            $where             = array('id_group_pengusul'=>5, 'id_instansi_pengusul!='=>'');
            $column_order   = array('', 'nama_program', 'kode_program');
            $column_search  = array('nama_program', 'kode_program');
            $order = array('status' => 'ASC');
            $list = $this->datatables_model->get_datatables('master_program', $column_order, $column_search, $order, $where);
            $data = array();
            $no = $_POST['start'];
            $status         = ["Pengusulan","Disetujui Admin","Ditolak Admin"];
            foreach ($list as $lists) {

            $id_instansi =$lists->id_instansi_pengusul;
                $nama_instansi_pengusul = $this->db->query("SELECT nama_instansi from master_instansi where id_instansi='$id_instansi'")->row_array()['nama_instansi'];
              
                $no++;
                $row            = array();
                $row[]          = $no;
                $row[]          = $nama_instansi_pengusul;
                $row[]          = $lists->kode_program;
                $row[]          = $lists->nama_program;

              
                    if ($lists->status=='0') {
                        $row[]          = $status[$lists->status];
                        $row[]  = '<button class="btn btn-success btn-sm" onclick="acc_usulan_program(' . "'" . $lists->id_program . "','" .$lists->nama_program. "','" .$lists->kode_program. "')\"" .'><i class="fa fa-check"></i></button> <button class="btn btn-danger btn-sm" onclick="reject_usulan_program(' . "'" . $lists->id_program . "'," . ')"><i class="fas fa-times"></i></button>';
                    }
                    elseif ($lists->status=='1') {
                        $row[]          = $status[$lists->status];
                        $row[]          ="";
                       
                    }else{
                        $row[]          = $status[$lists->status].'<br>Alasan : '.$lists->keterangan;
                         $row[]  = '<button class="btn btn-success btn-sm" onclick="acc_usulan_program(' . "'" . $lists->id_program . "','" .$lists->nama_program. "','" .$lists->kode_program. "')\"" .'><i class="fa fa-check"></i></button> <button class="btn btn-danger btn-sm" onclick="reject_usulan_program(' . "'" . $lists->id_program . "'," . ')"><i class="fas fa-times"></i></button>';

                    }
                      

               

              

                $data[] = $row;
            }

            $output = array(
                "draw" => $_POST['draw'],
                "recordsTotal" => $this->datatables_model->count_all('master_program', $where),
                "recordsFiltered" => $this->datatables_model->count_filtered('master_program', $column_order, $column_search, $order, $where),
                "data" => $data,
            );

            echo json_encode($output);
        }
    }


    public function dt_usulan_kegiatan()
    {
        if (!$this->input->is_ajax_request()) {
            show_404();
        } else {
            $id_instansi = id_instansi();
            $where             = array('id_group_pengusul'=>5);
            $column_order   = array('', 'nama_kegiatan', 'kode_kegiatan');
            $column_search  = array('nama_kegiatan', 'kode_kegiatan');
            $order = array('kode_kegiatan' => 'ASC');
            $list = $this->datatables_model->get_datatables('master_kegiatan', $column_order, $column_search, $order, $where);

                $status         = ["Pengusulan","Disetujui Admin","Ditolak Admin"];
            $data = array();
            $no = $_POST['start'];
            foreach ($list as $lists) {
                $id_instansi =$lists->id_instansi_pengusul;
                $nama_instansi_pengusul = $this->db->query("SELECT nama_instansi from master_instansi where id_instansi='$id_instansi'")->row_array()['nama_instansi'];
              
                $no++;
                $row            = array();
                $row[]          = $no;
                 $row[]          = $nama_instansi_pengusul;
                $row[]          = $lists->kode_kegiatan;
                $row[]          = $lists->nama_kegiatan;
                if ($lists->status=='0') {
                        $row[]          = $status[$lists->status];
                        $row[]  = '<button class="btn btn-success btn-sm" onclick="acc_usulan_kegiatan(' . "'" . $lists->id_kegiatan . "','" .$lists->nama_kegiatan. "','" .$lists->kode_kegiatan. "')\"" .'><i class="fa fa-check"></i></button> <button class="btn btn-danger btn-sm" onclick="reject_usulan_kegiatan(' . "'" . $lists->id_kegiatan . "'," . ')"><i class="fas fa-times"></i></button>';
                    }elseif ($lists->status=='2'){
                        $row[]          = $status[$lists->status].'<br>Alasan : '.$lists->keterangan;
                        $row[]          ="";

                    
                    }else{
                        $row[]          = $status[$lists->status];
                        $row[]          ="";

                    }

               

              

                $data[] = $row;
            }

            $output = array(
                "draw" => $_POST['draw'],
                "recordsTotal" => $this->datatables_model->count_all('master_kegiatan', $where),
                "recordsFiltered" => $this->datatables_model->count_filtered('master_kegiatan', $column_order, $column_search, $order, $where),
                "data" => $data,
            );

            echo json_encode($output);
        }
    }
    public function dt_usulan_sub_kegiatan()
    {
        if (!$this->input->is_ajax_request()) {
            show_404();
        } else {
            $id_instansi = id_instansi();
            $where             = array('id_group_pengusul'=>5);

                $status         = ["Pengusulan","Disetujui Admin","Ditolak Admin"];
            $column_order   = array('', 'nama_sub_kegiatan', 'kode_sub_kegiatan');
            $column_search  = array('nama_sub_kegiatan', 'kode_sub_kegiatan');
            $order = array('kode_sub_kegiatan' => 'ASC');
            $list = $this->datatables_model->get_datatables('master_sub_kegiatan', $column_order, $column_search, $order, $where);
            $data = array();
            $no = $_POST['start'];
            foreach ($list as $lists) {

              $id_instansi =$lists->id_instansi_pengusul;
                $nama_instansi_pengusul = $this->db->query("SELECT nama_instansi from master_instansi where id_instansi='$id_instansi'")->row_array()['nama_instansi'];
                $no++;
                $row            = array();
                $row[]          = $no;
                 $row[]          = $nama_instansi_pengusul; 
                $row[]          = $lists->kode_sub_kegiatan;
                $row[]          = $lists->nama_sub_kegiatan;
                 if ($lists->status=='0') {
                        $row[]          = $status[$lists->status];
                        $row[]  = '<button class="btn btn-success btn-sm" onclick="acc_usulan_sub_kegiatan(' . "'" . $lists->id_sub_kegiatan . "','" .$lists->nama_sub_kegiatan. "','" .$lists->kode_sub_kegiatan. "')\"" .'><i class="fa fa-check"></i></button> <button class="btn btn-danger btn-sm" onclick="reject_usulan_sub_kegiatan(' . "'" . $lists->id_sub_kegiatan . "'," . ')"><i class="fas fa-times"></i></button>';
                    }elseif ($lists->status=='2'){
                        $row[]          = $status[$lists->status].'<br>Alasan : '.$lists->keterangan;
                        $row[]          ="";

                    
                    }else{
                        $row[]          = $status[$lists->status];
                        $row[]          ="";

                    }

               

              

                $data[] = $row;
            }

            $output = array(
                "draw" => $_POST['draw'],
                "recordsTotal" => $this->datatables_model->count_all('master_sub_kegiatan', $where),
                "recordsFiltered" => $this->datatables_model->count_filtered('master_sub_kegiatan', $column_order, $column_search, $order, $where),
                "data" => $data,
            );

            echo json_encode($output);
        }
    }



    public function acc_usulan_program()
    {
        if (!$this->input->is_ajax_request()) {
            show_404();
        } else {
            $output = [
                'status'    => false,
                'id_pptk'   => '',
                'rekening'  => ''
            ];

            $id_program = $this->input->post('id_program');
            
                $this->db->update('master_program',['status'=>1], ['id_program' => $id_program]);
                $output['status']   = true;

            echo json_encode($output);
        }
    }


    public function reject_usulan_master_program()
    {
        if (!$this->input->is_ajax_request()) {
            show_404();
        } else {
            $output    = [
                'success' => false,
                'messages' => []
            ];
            $model    = $this->master_data_apbd_model;
                $id_program = $this->input->post('id');
                $where = ['id_program'=>$id_program];
                $data = ['status'=>2,'keterangan'=>nl2br($this->input->post('alasan'))];
                $this->db->update('master_program', $data, $where);


                $output['success']     = true;
                $output['messages'] = "User berhasil di simpan";
          
            echo json_encode($output);
        }
    }




    public function acc_usulan_kegiatan()
    {
        if (!$this->input->is_ajax_request()) {
            show_404();
        } else {
            $output = [
                'status'    => false,
                'id_pptk'   => '',
                'rekening'  => ''
            ];

            $id_kegiatan = $this->input->post('id_kegiatan');
            
                $this->db->update('master_kegiatan',['status'=>1], ['id_kegiatan' => $id_kegiatan]);
                $output['status']   = true;

            echo json_encode($output);
        }
    }


    public function reject_usulan_master_kegiatan()
    {
        if (!$this->input->is_ajax_request()) {
            show_404();
        } else {
            $output    = [
                'success' => false,
                'messages' => []
            ];
            $model    = $this->master_data_apbd_model;
                $id_kegiatan = $this->input->post('id');
                $where = ['id_kegiatan'=>$id_kegiatan];
                $data = ['status'=>2,'keterangan'=>nl2br($this->input->post('alasan'))];
                $this->db->update('master_kegiatan', $data, $where);


                $output['success']     = true;
                $output['messages'] = "User berhasil di simpan";
          
            echo json_encode($output);
        }
    }




    public function acc_usulan_sub_kegiatan()
    {
        if (!$this->input->is_ajax_request()) {
            show_404();
        } else {
            $output = [
                'status'    => false,
                'id_pptk'   => '',
                'rekening'  => ''
            ];

            $id_sub_kegiatan = $this->input->post('id_sub_kegiatan');
            
                $this->db->update('master_sub_kegiatan',['status'=>1], ['id_sub_kegiatan' => $id_sub_kegiatan]);
                $output['status']   = true;

            echo json_encode($output);
        }
    }


    public function reject_usulan_master_sub_kegiatan()
    {
        if (!$this->input->is_ajax_request()) {
            show_404();
        } else {
            $output    = [
                'success' => false,
                'messages' => []
            ];
            $model    = $this->master_data_apbd_model;
                $id_sub_kegiatan = $this->input->post('id');
                $where = ['id_sub_kegiatan'=>$id_sub_kegiatan];
                $data = ['status'=>2,'keterangan'=>nl2br($this->input->post('alasan'))];
                $this->db->update('master_sub_kegiatan', $data, $where);


                $output['success']     = true;
                $output['messages'] = "User berhasil di simpan";
          
            echo json_encode($output);
        }
    }




}
