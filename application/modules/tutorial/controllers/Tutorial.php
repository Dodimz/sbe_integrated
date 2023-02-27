<?php

/**
 * Author     : Alfikri, M.Kom
 * Created By : Alfikri, M.Kom
 * E-Mail     : alfikri.name@gmail.com
 * No HP      : 081277337405
 * Class      : Instansi.php
 */
defined('BASEPATH') or exit('No direct script access allowed');

class Tutorial extends MY_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model([
			'instansi/instansi_model' => 'instansi_model',
            'tutorial/tutorial_model' => 'tutorial_model',
            'datatables_model'                         => 'datatables_model'
		]);
	}

	public function index()
	{
        $id_group = $this->session->userdata('id_group');


        $group = $this->db->query("SELECT * from master_group")->result_array();
            $kumpul_group = [];
            foreach ($group as $k => $v) {
                $data_tutorial =$v['group_name'];
                array_push($kumpul_group, $data_tutorial);
                
            }

            // echo($kumpul_group[$id_group]);


    		$breadcrumbs 	= $this->breadcrumbs;
    		$instansi  		= $this->instansi_model;
            if ($id_group==0) {
            $breadcrumbs->add('<button class="btn btn-info btn-sm" onclick="tambah_tutorial()" data-toggle="tooltip" title="Tambah SKPD">Tambah Tutorial</button>', base_url($this->router->fetch_class()));
    		$breadcrumbs->render();
            }

    		$data['group']			= $group;
            $data['title']          = "Tutorial";
    		$data['icon']           = "metismenu-icon pe-7s-culture";
    		$data['description']	= "Menampilkan Tutorial Aplikasi SBE";
    		$data['breadcrumbs']	= $breadcrumbs->render();
    		$page 					= 'tutorial/index';
    		$data['link']           = $this->router->fetch_method();
    		$data['menu']           = $this->load->view('layout/menu', $data, true);
    		$data['extra_css']		= $this->load->view('tutorial/css', $data, true);
    		$data['extra_js']		= $this->load->view('tutorial/js', $data, true);
    		$data['modal']		= $this->load->view('tutorial/modal', $data, true);
    		$this->template->load('backend_template', $page, $data);
	}
    public function instansi_kab_kota()
    {
        
            $breadcrumbs    = $this->breadcrumbs;
            $instansi       = $this->instansi_model;

            $breadcrumbs->add('Home', base_url());
            $breadcrumbs->add('Instansi', base_url($this->router->fetch_class()));
            $breadcrumbs->render();

            $data['title']          = "Master Instansi";
            $data['icon']           = "metismenu-icon pe-7s-culture";
            $data['description']    = "Menampilkan Struktur Organisasi";
            $data['breadcrumbs']    = $breadcrumbs->render();
            $page                   = 'instansi/instansi_kab_kota/index';
            $data['link']           = $this->router->fetch_method();
            $data['menu']           = $this->load->view('layout/menu', $data, true);
            $data['extra_css']      = $this->load->view('instansi/instansi_kab_kota/css', $data, true);
            $data['extra_js']       = $this->load->view('instansi/instansi_kab_kota/js', $data, true);
            $data['modal']      = $this->load->view('instansi/instansi_kab_kota/modal', $data, true);
            $this->template->load('backend_template', $page, $data);
        
    }
    public function anggaran_instansi_kab_kota()
    {
        
            $breadcrumbs    = $this->breadcrumbs;
            $instansi       = $this->instansi_model;

            $breadcrumbs->add('Home', base_url());
            $breadcrumbs->add('Instansi', base_url($this->router->fetch_class()));
            $breadcrumbs->render();
            $tahap = tahapan_apbd();
            $namatahap =pilihan_nama_tahapan($tahap);
            $data['tahap']          = $namatahap;
            $data['title']          = "Master Instansi ";
            $data['icon']           = "metismenu-icon pe-7s-culture";
            $data['description']    = "Menampilkan Struktur Organisasi";
            $data['breadcrumbs']    = $breadcrumbs->render();
            $page                   = 'instansi/anggaran_instansi_kab_kota/index';
            $data['link']           = $this->router->fetch_method();
            $data['menu']           = $this->load->view('layout/menu', $data, true);
            $data['extra_css']      = $this->load->view('instansi/anggaran_instansi_kab_kota/css', $data, true);
            $data['extra_js']       = $this->load->view('instansi/anggaran_instansi_kab_kota/js', $data, true);
            $data['modal']      = $this->load->view('instansi/anggaran_instansi_kab_kota/modal', $data, true);
            $this->template->load('backend_template', $page, $data);
        
    }

	public function get_instansi()
	{
		if (!$this->input->is_ajax_request()) {
            show_404();
        } else {
             $output = [
                'status'    => false,
                'data'      => []
            ];
            $id_instansi = sbe_crypt($this->input->post('id_instansi'), 'D');
            $instansi = $this->instansi_model->get_instansi($id_instansi)->row();


            $output['data']['id_instansi']                  = sbe_crypt($instansi->id_instansi, 'E');
            $output['data']['kode_opd']                  = $instansi->kode_opd;
            $output['data']['nama_instansi']                  = $instansi->nama_instansi;
            $output['data']['id_parent']                  = $instansi->id_parent;
            $output['data']['alamat_instansi']                  = $instansi->alamat_instansi;
            $output['data']['email_instansi']                  = $instansi->email_instansi;
            $output['data']['telepon']                  = $instansi->telpon;
            $output['data']['website']                  = $instansi->website;
            $output['data']['bulan_mulai_realisasi']                  = $instansi->bulan_mulai_realisasi;
            $output['data']['bulan_akhir_realisasi']                  = $instansi->bulan_akhir_realisasi;
            $output['data']['is_active']                  = $instansi->is_active;

            

            echo json_encode($output);
        }
	}


    public function get_instansi_kab_kota()
    {
        if (!$this->input->is_ajax_request()) {
            show_404();
        } else {
             $output = [
                'status'    => false,
                'data'      => []
            ];
            $id_instansi = sbe_crypt($this->input->post('id_instansi'), 'D');
            $instansi = $this->instansi_model->get_instansi_kab_kota($id_instansi)->row();


            $output['data']['id_instansi']                  = sbe_crypt($instansi->id_instansi, 'E');
            $output['data']['kode_opd']                  = $instansi->kode_opd;
            $output['data']['nama_instansi']   = $instansi->nama_instansi;
            $output['data']['id_parent']                  = $instansi->id_parent;
            $output['data']['alamat_instansi']                  = $instansi->alamat_instansi;
            $output['data']['email_instansi']                  = $instansi->email_instansi;
            $output['data']['telepon']                  = $instansi->telpon;
            $output['data']['website']                  = $instansi->website;
            $output['data']['bulan_mulai_realisasi']                  = $instansi->bulan_mulai_realisasi;
            $output['data']['bulan_akhir_realisasi']                  = $instansi->bulan_akhir_realisasi;
            $output['data']['is_active']                  = $instansi->is_active;

            

            echo json_encode($output);
        }
    }



    public function data_tutorial()
    {
        if (!$this->input->is_ajax_request()) {
            show_404();
        } else {      
            $id_group = $this->session->userdata('id_group');      
            if ($id_group==0) {
                $where          = [];
            }else{
                $where          = ['id_group'=>$id_group];
            }
            
            $column_order   = ['', 'judul'];
            $column_search  = ['judul'];
            $order          = ['judul' => 'ASC'];
            $list           = $this->datatables_model->get_datatables('v_tutorial', $column_order, $column_search, $order, $where);
            $data           = [];
            $no             = $_POST['start'];
            $group = $this->db->query("SELECT * from master_group")->result_array();
            $kumpul_group = [];
            foreach ($group as $k => $v) {
                $data_tutorial =$v['group_name'];
                array_push($kumpul_group, $data_tutorial);
                
            }
            foreach ($list as $lists) {
                $no++;
               
                $row    = [];
                $row[]     = $no;
                $row[]  = $kumpul_group[$lists->id_group];
                $row[]  = $lists->tipe;
                $row[]  = $lists->urutan;
                $row[]  = $lists->judul;
                $row[]  = $lists->keterangan;
                $row[]  = '<a href="'.$lists->link.'" target="_blank">'.$lists->link.'</a>';
               
              
                $tombol_lihat_video = '<button class="btn btn-outline-info btn-xs"  title="Lihat Tutorial '.$lists->judul.'"  onclick="lihat_tutorial('."'".sbe_crypt($lists->id_tutorial, 'E')."'".')"><i class="fas fa-folder-open"></i></button>';
                $tombol_lihat_link = '<a href="'.$lists->link.'" target="_blank" class="btn btn-outline-info btn-xs"  title="Lihat Tutorial '.$lists->judul.'" ><i class="fas fa-arrow-right"></i></a>';
                $tombol_hapus = ' <button class="btn btn-danger btn-xs"  title="Lihat Tutorial '.$lists->judul.'"  onclick="hapus_tutorial('."'".sbe_crypt($lists->id_tutorial, 'E')."','".$lists->judul."'".')"><i class="fas fa-trash"></i></button>';
                $tombol_edit = ' <button class="btn btn-outline-info btn-xs"  title="Lihat Tutorial '.$lists->judul.'"  onclick="edit_tutorial('."'".sbe_crypt($lists->id_tutorial, 'E')."'".')"><i class="fas fa-edit"></i></button>';

                if ($lists->tipe=='Video') {
                    if ($id_group==0) {
                        $row[]  = $tombol_lihat_video.$tombol_edit.$tombol_hapus;
                        $row[]  = $tombol_lihat_video.$tombol_edit.$tombol_hapus;
                    }else{
                        $row[]  = $tombol_lihat_video;
                    }
                }else{
                    if ($id_group==0) {
                        $row[]  = $tombol_lihat_link.$tombol_edit.$tombol_hapus;
                    }else{
                        $row[]  = $tombol_lihat_link;
                    }
                }

                $data[] = $row;
            }

            $output = [
                "draw"              => $_POST['draw'],
                "recordsTotal"      => $this->datatables_model->count_all('tutorial', $where),
                "recordsFiltered"   => $this->datatables_model->count_filtered('tutorial', $column_order, $column_search, $order, $where),
                "data"              => $data,
            ];

            echo json_encode($output);
        }
    }


 public function rule_input_tutorial()
    {
        
        return [
            
            [
                'field' => 'akses',
                'label' => 'Login Akses',
                'rules' => 'required'
            ],
            [
                'field' => 'judul',
                'label' => 'Judul Tutorial',
                'rules' => 'required'
            ],
            [
                'field' => 'link',
                'label' => 'Link',
                'rules' => 'required'
            ],
            [
                'field' => 'urutan',
                'label' => 'Urutan',
                'rules' => 'required'
            ],
            [
                'field' => 'status',
                'label' => 'Status',
                'rules' => 'required'
            ]
            
        ];
    }




    public function simpan_tutorial()
    {
        if (!$this->input->is_ajax_request()) {
            show_404();
        } else {
            $output    = [
                'success' => false,
                'messages' => []
            ];
            $data_group     = [];
            $tutorial     = $this->tutorial_model;
            $validation     = $this->form_validation;
           
            $validation->set_rules($this->rule_input_tutorial());
            $validation->set_error_delimiters('<p class="text-danger">', '</p>');
        

            if ($validation->run($this)) {
                $simpan = $tutorial->save_tutorial();
                    $output['success']     = true;
                    $output['messages'] = "Tutorial berhasil di simpan";
                
            } else {
                $output['success'] = false;
                foreach ($_POST as $key => $value) {
                    $output['messages'][$key] = form_error($key);
                }
            }
            echo json_encode($output);
        }
    }

    public function simpanedit_tutorial()
    {
        if (!$this->input->is_ajax_request()) {
            show_404();
        } else {
            $output    = [
                'success' => false,
                'messages' => []
            ];
            $data_group     = [];
            $tutorial     = $this->tutorial_model;
            $validation     = $this->form_validation;
           
            $validation->set_rules($this->rule_input_tutorial());
            $validation->set_error_delimiters('<p class="text-danger">', '</p>');
        

            if ($validation->run($this)) {
                $simpan = $tutorial->saveedit_tutorial();
                    $output['success']     = true;
                    $output['messages'] = "Tutorial berhasil di perbaharui";
                
            } else {
                $output['success'] = false;
                foreach ($_POST as $key => $value) {
                    $output['messages'][$key] = form_error($key);
                }
            }
            echo json_encode($output);
        }
    }




    public function hapus_tutorial()
    {
        if (!$this->input->is_ajax_request()) {
            show_404();
        } else {
             $output = [
                'status'    => false,
                'message'      =>''
            ];
            $id_tutorial = sbe_crypt($this->input->post('id_tutorial'), 'D');
            $this->db->delete('tutorial',  ['id_tutorial'=>$id_tutorial]);
            $output['status'] = true;

            echo json_encode($output);
        }
    }
    public function lihat_video_yt()
    {
        if (!$this->input->is_ajax_request()) {
            show_404();
        } else {
             $output = [
                'status'    => false,
                'message'      =>'',
                'data'      =>[]
            ];
            $id_tutorial = sbe_crypt($this->input->post('id_tutorial'), 'D');
            $q = $this->db->get_where('tutorial',  ['id_tutorial'=>$id_tutorial])->row_array();;
            $link = $q['link'];
            $pecah = explode('=', $link);
            $embed = end($pecah);

            $output['status'] = true;
            $output['data']['embed'] = $embed;
            $output['data']['judul'] = $q['judul'];


            echo json_encode($output);
        }
    }

    public function get_tutorial()
    {
        if (!$this->input->is_ajax_request()) {
            show_404();
        } else {
             $output = [
                'status'    => false,
                'message'      =>'',
                'data'      =>[]
            ];
            $id_tutorial = sbe_crypt($this->input->post('id_tutorial'), 'D');
            $q = $this->db->get_where('tutorial',  ['id_tutorial'=>$id_tutorial])->row_array();;


            $output['data']['id_tutorial'] = sbe_crypt($q['id_tutorial'], 'E');
            $output['data']['akses'] = $q['id_group'];
            $output['data']['urutan'] = $q['urutan'];
            $output['data']['judul'] = $q['judul'];
            $output['data']['keterangan'] = $q['keterangan'];
            $output['data']['tipe'] = $q['tipe'];
            $output['data']['link'] = $q['link'];
            $output['data']['status'] = $q['status'];
            $output['status'] = true;


            echo json_encode($output);
        }
    }



}
