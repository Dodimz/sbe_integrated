<?php

/**
 * Author     : Alfikri, M.Kom
 * Created By : Alfikri, M.Kom
 * E-Mail     : alfikri.name@gmail.com
 * No HP      : 081277337405
 * Class      : Instansi.php
 */
defined('BASEPATH') or exit('No direct script access allowed');

class Permasalahan extends MY_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model([
			'instansi/instansi_model' => 'instansi_model',
            'permasalahan/permasalahan_model' => 'permasalahan_model',
            'datatables_model'                         => 'datatables_model'
		]);
	}

	public function index()
	{
        if ($this->session->userdata('id_group')==7) {
            $this->permasalahan_kab_kota();
        }else{
    		$breadcrumbs 	= $this->breadcrumbs;
    		$instansi  		= $this->instansi_model;

    		$breadcrumbs->add('Home', base_url());
    		$breadcrumbs->add('Instansi', base_url($this->router->fetch_class()));
    		$breadcrumbs->render();

    		$data['title']			= "Master Instansi";
    		$data['icon']           = "metismenu-icon pe-7s-culture";
    		$data['description']	= "Menampilkan Struktur Organisasi";
    		$data['breadcrumbs']	= $breadcrumbs->render();
    		$page 					= 'instansi/index';
    		$data['link']           = $this->router->fetch_method();
    		$data['menu']           = $this->load->view('layout/menu', $data, true);
    		$data['extra_css']		= $this->load->view('instansi/css', $data, true);
    		$data['extra_js']		= $this->load->view('instansi/js', $data, true);
    		$data['modal']		= $this->load->view('instansi/modal', $data, true);
    		$this->template->load('backend_template', $page, $data);
        }
	}
    public function permasalahan_kab_kota()
    {
        
            $breadcrumbs    = $this->breadcrumbs;
            $instansi       = $this->instansi_model;

            $breadcrumbs->add('Home', base_url());
            $breadcrumbs->add('Permasalahan', base_url($this->router->fetch_class()));
            $breadcrumbs->render();

            $data['title']          = "Permasalahan RFK";
            $data['icon']           = "metismenu-icon pe-7s-culture";
            $data['description']    = "Menampilkan Data Permasalahan Dalam Menyampaikan RFK";
            $data['breadcrumbs']    = $breadcrumbs->render();
            $data['link']           = $this->router->fetch_method();
            $data['menu']           = $this->load->view('layout/menu', $data, true);
            $page                   = 'permasalahan/permasalahan_kab_kota/index';
            $data['extra_css']      = $this->load->view('permasalahan/permasalahan_kab_kota/css', $data, true);
            $data['extra_js']       = $this->load->view('permasalahan/permasalahan_kab_kota/js', $data, true);
            $data['modal']      = $this->load->view('permasalahan/permasalahan_kab_kota/modal', $data, true);
            $this->template->load('backend_template', $page, $data);
        
    }
   



    public function permasalahan_skpd_kab_kota()
    {
        $breadcrumbs            = $this->breadcrumbs;

        $breadcrumbs->add('Home', base_url());
        $breadcrumbs->add('Laporan', base_url($this->router->fetch_class()));
        $breadcrumbs->add('Laporan Permasalahan Sub Kegiatan', base_url());
        $breadcrumbs->render();

        $data['title']          = "Permasalahan RFK";
        $data['icon']           = "metismenu-icon pe-7s-culture";
        $data['description']    = "Menampilkan Data Permasalahan Dalam Menyampaikan RFK";
        $data['breadcrumbs']    = $breadcrumbs->render();
        $data['kab_kota']                    = $this->db->get_where('kota',['id_provinsi'=>13]);
        
        $data['kota']           = $this->db->get_where('kota', ['id_provinsi'=>13]);
        $data['link']           = $this->router->fetch_method();
        $data['menu']           = $this->load->view('layout/menu', $data, true);
        $page                   = 'permasalahan/permasalahan_kab_kota_admin/index';
        $data['extra_css']      = $this->load->view('permasalahan/permasalahan_kab_kota_admin/css', $data, true);
        $data['extra_js']       = $this->load->view('permasalahan/permasalahan_kab_kota_admin/js', $data, true);
        $data['modal']      = $this->load->view('permasalahan/permasalahan_kab_kota_admin/modal', $data, true);
        $this->template->load('backend_template', $page, $data);
    }




    public function show_permasalahan_skpd_kab_kota()
    {
        // error_reporting(0);
        $breadcrumbs     = $this->breadcrumbs;

        $breadcrumbs->add('Home', base_url());
        $breadcrumbs->add('Data APBD', base_url($this->router->fetch_class()));
        
        $breadcrumbs->render();
        $id_kota    = sbe_crypt($this->input->get('id_kota'), 'D');
        $data['input_by']                      = "all";
        $data['title']                      = "Data APBD";
        $data['icon']                       = "metismenu-icon fa fa-list-ul";
        $data['description']                = "Menampilkan Data APBD";
        $data['breadcrumbs']                = $breadcrumbs->render();
        $data['id_kota']                =$id_kota;
        $data['nama_kota']              =$this->db->query("SELECT nama_kota from kota where id_kota='$id_kota'")->row()->nama_kota;
        $data['controller']             =$this->router->fetch_class();
        $page                               = 'permasalahan/permasalahan_kab_kota_admin/permasalahan';
        $data['link']                       = $this->router->fetch_method();
        $data['menu']                       = $this->load->view('layout/menu', $data, true);
        $data['extra_css']                  = $this->load->view('permasalahan/permasalahan_kab_kota_admin/css', $data, true);
        $data['extra_js']                   = $this->load->view('permasalahan/permasalahan_kab_kota_admin/js2', $data, true);
        $data['modal']                      = $this->load->view('permasalahan/permasalahan_kab_kota_admin/modal', $data, true);
        $this->load->view($page, $data);
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




    public function data_instansi_kab_kota()
    {
        if (!$this->input->is_ajax_request()) {
            show_404();
        } else {       
                $tahun_anggaran = tahun_anggaran();
                if ($this->session->userdata('id_group')==7) {
                    $id_kota = $this->session->userdata('id_kota') ;    
                }else{
                    $id_kota = $this->input->post('id_kota') ;    
                }
                $where          = ['kategori'=>'OPD', 'id_kota'=>$id_kota];
            
            $column_order   = ['', 'nama_instansi'];
            $column_search  = ['nama_instansi','kode_opd'];
            $order          = ['nama_instansi' => 'ASC'];
            $list           = $this->datatables_model->get_datatables('master_instansi_kab_kota', $column_order, $column_search, $order, $where);
            $data           = [];
            $no             = $_POST['start'];
            $status = ['Tidak Aktif','Aktif'];
            foreach ($list as $lists) {
                $id_instansi  = $lists->id_instansi;
                 $permasalahan  = $this->db->query("SELECT * from permasalahan_skpd_kab_kota where id_instansi='$id_instansi' and tahun='$tahun_anggaran'");
                  $solusi  = $this->db->query("SELECT id_solusi_permasalahan_skpd_kab_kota, id_instansi, solusi, solusi_by from solusi_permasalahan_skpd_kab_kota where id_instansi='$id_instansi' and tahun='$tahun_anggaran'");
                 $tabel_permasalahan = '
                <ol>
                ';
                    foreach ($permasalahan->result() as $k_masalah => $v_masalah) {
                        $show_masalah = "edit_permasalahan('".$v_masalah->id_permasalahan_skpd_kab_kota."')";
                         if ($this->session->userdata('id_group')==7) {  
                            $tabel_permasalahan .= '<li style="color: #5fb6ff "><a href="#" onclick="'.$show_masalah.'" >'.$v_masalah->permasalahan.'</a></li>';
                        }else{
                            $tabel_permasalahan .= '<li>'.$v_masalah->permasalahan.'</li>';

                        }
                    }
                $tabel_permasalahan .= '
                </ol>
                ';


                $tabel_solusi = '
                <ol>
                ';
                foreach ($solusi->result() as $k_solusi => $v_solusi) {
                    $show_solusi = "edit_solusi_permasalahan('".$v_solusi->id_solusi_permasalahan_skpd_kab_kota."','".$lists->id_instansi."','".tahapan_apbd()."', '".tahun_anggaran()."','".$lists->nama_instansi."')";
                  if ($this->session->userdata('id_group')==$v_solusi->solusi_by) {  
                $tabel_solusi .= '<li style="color: #5fb6ff "><a href="#" onclick="'.$show_solusi.'">'.$v_solusi->solusi.'</a></li>';
                    }else{
                $tabel_solusi .= '<li>'.$v_solusi->solusi.'</li>';

                    }
                }
                $tabel_solusi .= '
                </ol>
                ';

                $onclick = "input_permasalahan('".$lists->id_instansi."','".tahapan_apbd()."', '".tahun_anggaran()."','".$lists->nama_instansi."')";
                $tombol_tambah_masalah = '<button class="btn btn-outline-info btn-xs"  title="Input permasalahan pad sub  SKPD '.$lists->nama_instansi.'"  onclick="'.$onclick.'"><i class="fas fa-plus"></i></button>';

                $onclick2 = "input_solusi_permasalahan('".$lists->id_instansi."','".tahapan_apbd()."', '".tahun_anggaran()."','".$lists->nama_instansi."')";
                $tombol_tambah_solusi = ' <button class="btn btn-outline-info btn-xs"  title="Input Solusi pad sub  kegiatan '.$lists->nama_instansi.'"  onclick="'.$onclick2.'"><i class="fas fa-check-circle"></i></button>';


                $no++;
               
                $row    = [];
                $row[]     = $no;
                $row[]  = $lists->nama_instansi;
            
                  if ($permasalahan->num_rows()>0) {
                    $row[]  =$tabel_permasalahan;
                    if ($solusi->num_rows()>0) {
                        $row[]  =$tabel_solusi;
                    }else{
                        $row[]  ='';
                    }
                }else{
                    $row[]  ='';
                    $row[]  ='';
                }

                if ($this->session->userdata('id_group')==7) {
                    if ($permasalahan->num_rows()>0) {
                        $tombol_action =  $tombol_tambah_masalah.$tombol_tambah_solusi;
                    }else{
                        $tombol_action =  $tombol_tambah_masalah;
                    }
                }
                else{
                    if ($permasalahan->num_rows()>0) {
                        $tombol_action = $tombol_tambah_solusi;
                    }else{
                        $tombol_action = '';

                    }
                }
                $row[]  = $tombol_action;
                $row[]  = $tombol_tambah_masalah;





                $data[] = $row;
            }

            $output = [
                "draw"              => $_POST['draw'],
                "recordsTotal"      => $this->datatables_model->count_all('v_instansi_kab_kota', $where),
                "recordsFiltered"   => $this->datatables_model->count_filtered('v_instansi_kab_kota', $column_order, $column_search, $order, $where),
                "data"              => $data,
            ];

            echo json_encode($output);
        }
    }




    public function get_permasalahan_skpd_kab_kota()
    {
        if (!$this->input->is_ajax_request()) {
            show_404();
        } else {
            $output = [
                'status'    => false,
                'permasalahan'      => [],
                'sub_kegiatan'    => []
            ];

            $tahun = $this->input->post('tahun');
            $tahap = $this->input->post('tahap');
            $id_instansi = $this->input->post('id_instansi');
            $tahap = $this->input->post('tahap');
            $where = ['tahun'=>$tahun, 'kode_tahap'=>$tahap,   'id_instansi' => $id_instansi];



            $permasalahan_sub_kegiatan    = $this->db->get_where('permasalahan_skpd_kab_kota', $where);
            if ($permasalahan_sub_kegiatan->num_rows() > 0) {
                foreach ($permasalahan_sub_kegiatan->result() as $key => $value) {
                    $output['permasalahan'][$key]['masalah']                  = $value->permasalahan;
                }

                $output['status'] = true;
            }else{
                $output['status'] = false;
            }

            echo json_encode($output);
        }
    }




    public function detail_permasalahan_skpd_kab_kota()
    {
        if (!$this->input->is_ajax_request()) {
            show_404();
        } else {
            $output = [
                'status'    => false,
                'data'      => [],
            ];

            $id_permasalahan = $this->input->post('id_permasalahan');
            $q = $this->db->query("SELECT 
                 pskk.id_permasalahan_skpd_kab_kota,  pskk.permasalahan, pskk.id_instansi, pskk.kode_tahap, pskk.tahun,
                 mikk.nama_instansi
                from permasalahan_skpd_kab_kota pskk
                left join master_instansi_kab_kota mikk on pskk.id_instansi = mikk.id_instansi
                where pskk.id_permasalahan_skpd_kab_kota='$id_permasalahan'");
            $q_permasalahan = $q->row();
            $nama_tahap = [2=>'APBD AWAL','APBD PERGESERAN','APBD PERUBAHAN'];



            if ($q->num_rows() > 0) {
                $output['data']['nama_instansi'] = $q_permasalahan->nama_instansi;
                $output['data']['id_instansi'] = $q_permasalahan->id_instansi;
                $output['data']['kode_tahap'] = $q_permasalahan->kode_tahap;
                $output['data']['nama_tahap'] = $nama_tahap[$q_permasalahan->kode_tahap];
                $output['data']['tahun'] = $q_permasalahan->tahun;
                $output['data']['id_permasalahan'] = $q_permasalahan->id_permasalahan_skpd_kab_kota;
                $output['data']['permasalahan'] = str_replace('<br />', '', $q_permasalahan->permasalahan);

                $output['status'] = true;
            }else{
                $output['status'] = false;
            }



           

            echo json_encode($output);
        }
    }

    public function detail_solusi_skpd_kab_kota()
    {
        if (!$this->input->is_ajax_request()) {
            show_404();
        } else {
            $output = [
                'status'    => false,
                'data'      => [],
            ];

            $id_solusi_permasalahan = $this->input->post('id_solusi');
            $q = $this->db->query("SELECT 
                 pskk.id_solusi_permasalahan_skpd_kab_kota,  pskk.solusi, pskk.id_instansi, pskk.kode_tahap, pskk.tahun,
                 mikk.nama_instansi
                from solusi_permasalahan_skpd_kab_kota pskk
                left join master_instansi_kab_kota mikk on pskk.id_instansi = mikk.id_instansi
                where pskk.id_solusi_permasalahan_skpd_kab_kota='$id_solusi_permasalahan'");
            $q_solusi = $q->row();
            $nama_tahap = [2=>'APBD AWAL','APBD PERGESERAN','APBD PERUBAHAN'];



            if ($q->num_rows() > 0) {
                $output['data']['nama_instansi'] = $q_solusi->nama_instansi;
                $output['data']['id_instansi'] = $q_solusi->id_instansi;
                $output['data']['kode_tahap'] = $q_solusi->kode_tahap;
                $output['data']['nama_tahap'] = $nama_tahap[$q_solusi->kode_tahap];
                $output['data']['tahun'] = $q_solusi->tahun;
                $output['data']['id_solusi'] = $q_solusi->id_solusi_permasalahan_skpd_kab_kota;
                $output['data']['solusi'] = str_replace('<br />', '', $q_solusi->solusi);

                $output['status'] = true;
            }else{
                $output['status'] = false;
            }



           

            echo json_encode($output);
        }
    }





    public function saveedit_solusi_permasalahan_skpd_kab_kota()
    {
        if (!$this->input->is_ajax_request()) {
            show_404();
        } else {
            $output    = [
                'success' => false,
                'messages' => []
            ];
            $data_group     = [];
            $permasalahan     = $this->permasalahan_model;
            $validation     = $this->form_validation;
           
            $validation->set_rules($this->rule_input_solusi_permasalahan());
            $validation->set_error_delimiters('<p class="text-danger">', '</p>');
        

            $post               = $this->input->post();
            $id_solusi = $this->input->post('id_solusi');
            $kode_rekening_sub_kegiatan = $this->input->post('kode_sub_kegiatan');
            $kode_kegiatan = $this->input->post('kode_kegiatan');
            $kode_program = $this->input->post('kode_program');
            $tahap = $this->input->post('tahap');
            $solusi = $this->input->post('solusi');




            if ($validation->run($this)) {
                $simpan = $permasalahan->saveedit_solusi_permasalahan_skpd_kab_kota();
                    $output['success']     = true;
                    $output['messages'] = "Solusi permasalahan berhasil di perbaharui";
                    $output['kode_kegiatan'] = $kode_kegiatan;
                    $output['kode_program'] = $kode_program;
                
            } else {
                $output['success'] = false;
                foreach ($_POST as $key => $value) {
                    $output['messages'][$key] = form_error($key);
                }
            }
            echo json_encode($output);
        }
    }




 public function rule_input_permasalahan()
    {
        
        return [
            [
                'field' => 'permasalahan',
                'label' => 'permasalahan',
                'rules' => 'required'
            ]
            
        ];
    }


 public function rule_input_solusi_permasalahan()
    {
        
        return [
            [
                'field' => 'solusi',
                'label' => 'Solusi Permasalahan',
                'rules' => 'required'
            ]
            
        ];
    }




    public function save_permasalahan_skpd_kab_kota()
    {
        if (!$this->input->is_ajax_request()) {
            show_404();
        } else {
            $output    = [
                'success' => false,
                'messages' => []
            ];
            $data_group     = [];
            $permasalahan_model     = $this->permasalahan_model;
            $validation     = $this->form_validation;
           
            $validation->set_rules($this->rule_input_permasalahan());
            $validation->set_error_delimiters('<p class="text-danger">', '</p>');
        

            $post               = $this->input->post();
            $id_instansi = $this->input->post('id_instansi');
            $tahap = $this->input->post('tahap');
            $tahun = $this->input->post('tahun');
            $permasalahan = $this->input->post('permasalahan');




            if ($validation->run($this)) {
                $simpan = $permasalahan_model->save_permasalahan_skpd_kab_kota();
                    $output['success']     = true;
                    $output['messages'] = "Permasalahan berhasil di simpan";
                   
            } else {
                $output['success'] = false;
                foreach ($_POST as $key => $value) {
                    $output['messages'][$key] = form_error($key);
                }
            }
            echo json_encode($output);
        }
    }


    public function saveedit_permasalahan_skpd_kab_kota()
    {
        if (!$this->input->is_ajax_request()) {
            show_404();
        } else {
            $output    = [
                'success' => false,
                'messages' => []
            ];
            $data_group     = [];
            $permasalahan_model     = $this->permasalahan_model;
            $validation     = $this->form_validation;
           
            $validation->set_rules($this->rule_input_permasalahan());
            $validation->set_error_delimiters('<p class="text-danger">', '</p>');
        

            $post               = $this->input->post();
            $id_instansi = $this->input->post('id_instansi');
            $tahap = $this->input->post('tahap');
            $tahun = $this->input->post('tahun');
            $permasalahan = $this->input->post('permasalahan');




            if ($validation->run($this)) {
                $simpan = $permasalahan_model->saveedit_permasalahan_skpd_kab_kota();
                    $output['success']     = true;
                    $output['messages'] = "Permasalahan berhasil di simpan";
                   
            } else {
                $output['success'] = false;
                foreach ($_POST as $key => $value) {
                    $output['messages'][$key] = form_error($key);
                }
            }
            echo json_encode($output);
        }
    }




    public function save_solusi_permasalahan_skpd_kab_kota()
    {
        if (!$this->input->is_ajax_request()) {
            show_404();
        } else {
            $output    = [
                'success' => false,
                'messages' => []
            ];
            $data_group     = [];
            $permasalahan     = $this->permasalahan_model;
            $validation     = $this->form_validation;
           
            $validation->set_rules($this->rule_input_solusi_permasalahan());
            $validation->set_error_delimiters('<p class="text-danger">', '</p>');
        

            $post               = $this->input->post();
            $kode_rekening_sub_kegiatan = $this->input->post('kode_sub_kegiatan');
            $kode_kegiatan = $this->input->post('kode_kegiatan');
            $kode_program = $this->input->post('kode_program');
            $tahap = $this->input->post('tahap');
            $solusi = $this->input->post('solusi');




            if ($validation->run($this)) {
                $simpan = $permasalahan->save_solusi_permasalahan_skpd_kab_kota();
                    $output['success']     = true;
                    $output['messages'] = "Permasalahan berhasil di simpan";
                    $output['kode_kegiatan'] = $kode_kegiatan;
                    $output['kode_program'] = $kode_program;
                
            } else {
                $output['success'] = false;
                foreach ($_POST as $key => $value) {
                    $output['messages'][$key] = form_error($key);
                }
            }
            echo json_encode($output);
        }
    }




    public function hapus_permasalahan_skpd_kab_kota()
    {
        if (!$this->input->is_ajax_request()) {
            show_404();
        } else {
            $output = [
                'status'    => false,
                'data'      => [],
                'permasalahan'      => [],
                'sub_kegiatan'    => []
            ];

            $id_permasalahan = $this->input->post('id_permasalahan');
            $q = $this->db->query("DELETE from permasalahan_skpd_kab_kota where id_permasalahan_skpd_kab_kota='$id_permasalahan'");

            $output['status'] = true;


            echo json_encode($output);
        }
    }


    public function hapus_solusi_permasalahan_skpd_kab_kota()
    {
        if (!$this->input->is_ajax_request()) {
            show_404();
        } else {
            $output = [
                'status'    => false,
                'data'      => [],
                'permasalahan'      => [],
                'sub_kegiatan'    => []
            ];

            $id_solusi = $this->input->post('id_solusi');
            $q = $this->db->query("DELETE from solusi_permasalahan_skpd_kab_kota where id_solusi_permasalahan_skpd_kab_kota='$id_solusi'");

            $output['status'] = true;


            echo json_encode($output);
        }
    }



}
