<?php

/**
 * Author     : Alfikri, M.Kom
 * Created By : Alfikri, M.Kom
 * E-Mail     : alfikri.name@gmail.com
 * No HP      : 081277337405
 * Class      : Instansi.php
 */
defined('BASEPATH') or exit('No direct script access allowed');

class Instansi extends MY_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model([
			'instansi/instansi_model' => 'instansi_model',
            'datatables_model'                         => 'datatables_model'
		]);
	}

	public function index()
	{
        if ($this->session->userdata('id_group')==7) {
            $this->instansi_kab_kota();
        }
        else if ($this->session->userdata('id_group')==5) {
            $this->instansi_pembantu();
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
    public function instansi_pembantu()
    {
            $breadcrumbs    = $this->breadcrumbs;
            $instansi       = $this->instansi_model;

            $breadcrumbs->add('Home', base_url());
            $breadcrumbs->add('Instansi', base_url($this->router->fetch_class()));
            $breadcrumbs->render();

        //     $data['dropdown_option']                      = [
            
        //     ['tipe'=>'button', 'caption'=>'Tambah Instansi', 'fa'=>'fa fa-plus', 'onclick'=>'tambah_instansi()', 'elemen_tambahan'=>'data-toggle="tooltip" title="Tambah Data Instansi"'],
        //      // ['tipe'=>'link', 'caption'=>'Kembali', 'fa'=>'fa fa-arrow-left', 'onclick'=>'data_apbd/', 'elemen_tambahan'=>'data-toggle="tooltip" title="Kembali"'],
        // ];
            $data['kota']           = $this->db->get_where('kota',['id_provinsi'=>13])->result_array();
            $data['title']          = "Instansi Pembantu Teknis";
            $data['icon']           = "metismenu-icon pe-7s-culture";
            $data['description']    = "Menampilkan Daftar Instansi Teknis SKPD";
            $data['breadcrumbs']    = $breadcrumbs->render();
            $page                   = 'instansi/instansi_pembantu_teknis/index';
            $data['link']           = $this->router->fetch_method();
            $data['menu']           = $this->load->view('layout/menu', $data, true);
            $data['extra_css']      = $this->load->view('instansi/instansi_pembantu_teknis/css', $data, true);
            $data['extra_js']       = $this->load->view('instansi/instansi_pembantu_teknis/js', $data, true);
            $data['modal']      = $this->load->view('instansi/instansi_pembantu_teknis/modal', $data, true);
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


    public function get_instansi_teknis()
    {
        if (!$this->input->is_ajax_request()) {
            show_404();
        } else {
             $output = [
                'status'    => false,
                'data'      => []
            ];
            $id_instansi = sbe_crypt($this->input->post('id_instansi'), 'D');
            $instansi = $this->instansi_model->get_instansi_teknis($id_instansi)->row();


            $output['data']['id_instansi_pembantu_teknis']                  = sbe_crypt($instansi->id_instansi_pembantu_teknis , 'E');
         
            $output['data']['kode']                  = $instansi->kode_instansi_teknis ;
            $output['data']['nama_instansi_teknis']                  = $instansi->nama_instansi_teknis ;
            $output['data']['id_provinsi']                  = $instansi->id_provinsi ;
            $output['data']['jenis_teknis']                  = $instansi->jenis_teknis ;
            $output['data']['id_kota']                  = $instansi->id_kota ;
            $output['data']['is_active']                  = $instansi->is_active  ;
            // $output['data']['nama_instansi']                  = $instansi->nama_instansi;
            // $output['data']['id_parent']                  = $instansi->id_parent;
            // $output['data']['alamat_instansi']                  = $instansi->alamat_instansi;
            // $output['data']['email_instansi']                  = $instansi->email_instansi;
            // $output['data']['telepon']                  = $instansi->telpon;
            // $output['data']['website']                  = $instansi->website;
            // $output['data']['bulan_mulai_realisasi']                  = $instansi->bulan_mulai_realisasi;
            // $output['data']['bulan_akhir_realisasi']                  = $instansi->bulan_akhir_realisasi;
            // $output['data']['is_active']                  = $instansi->is_active;

            

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



    public function data_instansi()
    {
        if (!$this->input->is_ajax_request()) {
            show_404();
        } else {            
                $where          = ['kategori'=>'OPD'];
            
            $column_order   = ['', 'nama_instansi'];
            $column_search  = ['nama_instansi','kode_opd', 'asisten'];
            $order          = ['nama_instansi' => 'ASC'];
            $list           = $this->datatables_model->get_datatables('v_instansi', $column_order, $column_search, $order, $where);
            $data           = [];
            $no             = $_POST['start'];
            $status = ['Tidak Aktif','Aktif'];
            foreach ($list as $lists) {
                $no++;
               
                $row    = [];
                $row[]     = $no;
                $row[]  = $lists->kode_opd;
                $row[]  = $lists->nama_instansi;
                $row[]  = $lists->kategori;
                $row[]  = $lists->asisten;
                $row[]  = bulan_global($lists->bulan_mulai_realisasi);
                $row[]  = bulan_global($lists->bulan_akhir_realisasi);
                $row[]  = $status[$lists->is_active];
                $tombol_edit = '<button class="btn btn-outline-info btn-xs"  title="Edit Instansi'.$lists->nama_instansi.'"  onclick="edit_instansi('."'".sbe_crypt($lists->id_instansi, 'E')."'".')"><i class="fas fa-edit"></i></button>';
                $tombol_hapus = '<button class="btn btn-outline-danger btn-xs"  title="Edit Instansi'.$lists->nama_instansi.'"  onclick="hapus_instansi('."'".sbe_crypt($lists->id_instansi, 'E')."'".' , '."'".$lists->nama_instansi."'".')"><i class="fas fa-trash"></i></button>';
                $row[]  = $tombol_edit.' '.$tombol_hapus;


                $data[] = $row;
            }

            $output = [
                "draw"              => $_POST['draw'],
                "recordsTotal"      => $this->datatables_model->count_all('v_instansi', $where),
                "recordsFiltered"   => $this->datatables_model->count_filtered('v_instansi', $column_order, $column_search, $order, $where),
                "data"              => $data,
            ];

            echo json_encode($output);
        }
    }


    public function data_instansi_pembantu_teknis()
    {
        if (!$this->input->is_ajax_request()) {
            show_404();
        } else {            
                $where          = ['id_instansi'=>id_instansi()];
            
            $column_order   = ['', 'nama_instansi_teknis'];
            $column_search  = ['nama_instansi_teknis','jenis_teknis'];
            $order          = ['nama_instansi_teknis' => 'ASC'];
            $list           = $this->datatables_model->get_datatables('instansi_pembantu_teknis', $column_order, $column_search, $order, $where);
            $data           = [];
            $no             = $_POST['start'];
            $status = ['Tidak Aktif','Aktif'];
            foreach ($list as $lists) {
                $id_kota = $lists->id_kota;
                $kota = $this->db->query("SELECT nama_kota from kota where id_kota = '$id_kota'")->row_array();
                $no++;
               
                $row    = [];
                $row[]     = $no;
                $row[]  = $lists->kode_instansi_teknis;
                $row[]  = $lists->nama_instansi_teknis;
                $row[]  = $lists->jenis_teknis;
                $row[]  = $kota['nama_kota'];
                $row[]  = $status[$lists->is_active];
                $tombol_edit = '<button class="btn btn-outline-info btn-xs"  title="Edit Instansi'.$lists->nama_instansi_teknis.'"  onclick="edit_instansi_teknis('."'".sbe_crypt($lists->id_instansi_pembantu_teknis , 'E')."'".')"><i class="fas fa-edit"></i></button>';
                $tombol_hapus = '<button class="btn btn-outline-danger btn-xs"  title="Edit Instansi'.$lists->nama_instansi_teknis.'"  onclick="hapus_instansi_teknis('."'".sbe_crypt($lists->id_instansi_pembantu_teknis , 'E')."'".' , '."'".$lists->nama_instansi_teknis."'".')"><i class="fas fa-trash"></i></button>';
                $row[]  = $tombol_edit.' '.$tombol_hapus;


                $data[] = $row;
            }

            $output = [
                "draw"              => $_POST['draw'],
                "recordsTotal"      => $this->datatables_model->count_all('v_instansi', $where),
                "recordsFiltered"   => $this->datatables_model->count_filtered('v_instansi', $column_order, $column_search, $order, $where),
                "data"              => $data,
            ];

            echo json_encode($output);
        }
    }


    public function data_instansi_kab_kota()
    {
        if (!$this->input->is_ajax_request()) {
            show_404();
        } else {       
                $id_kota = $this->session->userdata('id_kota') ;    
                $where          = ['kategori'=>'OPD', 'id_kota'=>$id_kota];
            
            $column_order   = ['', 'nama_instansi'];
            $column_search  = ['nama_instansi','kode_opd'];
            $order          = ['nama_instansi' => 'ASC'];
            $list           = $this->datatables_model->get_datatables('master_instansi_kab_kota', $column_order, $column_search, $order, $where);
            $data           = [];
            $no             = $_POST['start'];
            $status = ['Tidak Aktif','Aktif'];
            foreach ($list as $lists) {
                $no++;
               
                $row    = [];
                $row[]     = $no;
                $row[]  = $lists->kode_opd;
                $row[]  = $lists->nama_instansi;
                $row[]  = $lists->kategori;
                $row[]  = bulan_global($lists->bulan_mulai_realisasi);
                $row[]  = bulan_global($lists->bulan_akhir_realisasi);
                $row[]  = $status[$lists->is_active];
                $tombol_edit = '<button class="btn btn-outline-info btn-xs"  title="Edit Instansi'.$lists->nama_instansi.'"  onclick="edit_instansi_kab_kota('."'".sbe_crypt($lists->id_instansi, 'E')."'".')"><i class="fas fa-edit"></i></button>';
                $tombol_hapus = '<button class="btn btn-outline-danger btn-xs"  title="Edit Instansi'.$lists->nama_instansi.'"  onclick="hapus_instansi_kab_kota('."'".sbe_crypt($lists->id_instansi, 'E')."'".' , '."'".$lists->nama_instansi."'".')"><i class="fas fa-trash"></i></button>';
                $row[]  = $tombol_edit.' '.$tombol_hapus;


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

    public function data_anggaran_instansi_kab_kota()
    {
        if (!$this->input->is_ajax_request()) {
            show_404();
        } else {       

            $tahap = tahapan_apbd();
            $tahun_anggaran = tahun_anggaran();
                $id_kota = $this->session->userdata('id_kota') ;    
                $where          = ['kategori'=>'OPD', 'id_kota'=>$id_kota];
            
            $column_order   = ['', 'nama_instansi'];
            $column_search  = ['nama_instansi','kode_opd'];
            $order          = ['nama_instansi' => 'ASC'];
            $list           = $this->datatables_model->get_datatables('master_instansi_kab_kota', $column_order, $column_search, $order, $where);
            $data           = [];
            $no             = $_POST['start'];
            $status = ['Tidak Aktif','Aktif'];
            foreach ($list as $lists) {
                $no++;
                $id_instansi  = $lists->id_instansi;
                $q_pagu = $this->db->query("SELECT pagu_bo,pagu_bm,pagu_btt,pagu_bt from v_instansi_kab_kota where id_instansi='$id_instansi' and kode_tahap='$tahap' and tahun='$tahun_anggaran'");
                $d_pagu = $q_pagu->row();
                $j_pagu = $q_pagu->num_rows();
                $pagu_bo = $j_pagu == 0 ? 0 : $d_pagu->pagu_bo ;
                $pagu_bm = $j_pagu == 0 ? 0 : $d_pagu->pagu_bm ;
                $pagu_btt = $j_pagu == 0 ? 0 : $d_pagu->pagu_btt ;
                $pagu_bt = $j_pagu == 0 ? 0 : $d_pagu->pagu_bt ;
                $pagu_total = $pagu_bo + $pagu_bm + $pagu_btt + $pagu_bt;

                $row    = [];
                $row[]     = $no;
                $row[]  = $lists->nama_instansi;
               
                $row[]  = number_format($pagu_bo);
                $row[]  = number_format($pagu_bm);
                $row[]  = number_format($pagu_btt);
                $row[]  = number_format($pagu_bt);
                $row[]  = number_format($pagu_total);
               
                $tombol_edit = '<button class="btn btn-outline-info btn-xs"  title="Input / Edit Pagu Instansi '.$lists->nama_instansi.'"  onclick="input_pagu_instansi('."'".sbe_crypt($lists->id_instansi, 'E')."'".','.$tahap.')"><i class="fas fa-money-bill"></i></button>';

                $tombol_copy = ' <button class="btn btn-outline-info btn-xs"  title="Copu Pagu  APBD AWAL Instansi '.$lists->nama_instansi.'"  onclick="copy_pagu_instansi('."'".sbe_crypt($lists->id_instansi, 'E')."'".','.$tahap.', '."'".$lists->nama_instansi."'".')"><i class="fas fa-copy"></i></button>';
                
                if ($tahap==4 && $j_pagu==0) {
                    $row[]  = $tombol_edit.$tombol_copy;
                    # code...
                }else{
                    $row[]  = $tombol_edit;

                }


                $data[] = $row;
            }

            $output = [
                "draw"              => $_POST['draw'],
                "recordsTotal"      => $this->datatables_model->count_all('master_instansi_kab_kota', $where),
                "recordsFiltered"   => $this->datatables_model->count_filtered('master_instansi_kab_kota', $column_order, $column_search, $order, $where),
                "data"              => $data,
            ];

            echo json_encode($output);
        }
    }


    public function get_anggaran_instansi_kab_kota()
    {
        if (!$this->input->is_ajax_request()) {
            show_404();
        } else {
            $output = [
                'status'    => false,
                'data'      => [],
                'volume'    => [],
                'lokasi'    => []
            ];

           
            $id_instansi = sbe_crypt($this->input->post('id_instansi'),'D');
            $tahap = $this->input->post('tahap');
            $where = [ 'kode_tahap'=>$tahap,   'id_instansi' =>$id_instansi];

            $pagu    = $this->db->get_where('anggaran_instansi_kab_kota', $where);
            $identitas_instansi        = $this->db->query("SELECT * from v_instansi_kab_kota where id_instansi='$id_instansi'")->row();
                $output['data']['nama_instansi']                  =  $identitas_instansi->nama_instansi ;
    



            if ($pagu->num_rows() > 0) {
                foreach ($pagu->result() as $key => $value) {
                    $output['data']['bo_bp']                  = $value->bo_bp;
                    $output['data']['bo_bbj']                  = $value->bo_bbj;
                    $output['data']['bo_bs']                  = $value->bo_bs;
                    $output['data']['bo_bh']                  = $value->bo_bh;
                    $output['data']['bo_bbs']                  = $value->bo_bbs;
                    $output['data']['bm_bmt']                  = $value->bm_bmt;
                    $output['data']['bm_bmpm']                  = $value->bm_bmpm;
                    $output['data']['bm_bmgb']                  = $value->bm_bmgb;
                    $output['data']['bm_bmjji']                  = $value->bm_bmjji;
                    $output['data']['bm_bmatl']                  = $value->bm_bmatl;
                    $output['data']['bm_bmatb']                  = $value->bm_bmatb;
                    $output['data']['btt']                  = $value->btt;
                    $output['data']['bt_bbh']                  = $value->bt_bbh;
                    $output['data']['bt_bbk']                  = $value->bt_bbk ;
                    $output['data']['rea_bo']                  = $value->realisasikan_bo ;
                    $output['data']['rea_bm']                  = $value->realisasikan_bm ;
                    $output['data']['rea_btt']                  = $value->realisasikan_btt ;
                    $output['data']['rea_bt']                  = $value->realisasikan_bt ;
                }

                $output['status'] = true;
            }else{
                  
                    $output['data']['rea_bo']                  = 0;
                    $output['data']['rea_bm']                  = 0;
                    $output['data']['rea_btt']                  = 0;
                    $output['data']['rea_bt']                  = 0;
            }

            echo json_encode($output);
        }
    }

    public function copy_anggaran_instansi_kab_kota()
    {
        if (!$this->input->is_ajax_request()) {
            show_404();
        } else {
            $output = [
                'status'    => false,
                'data'      => [],
                'messages'    => '',
            ];

           
            $id_instansi = sbe_crypt($this->input->post('id_instansi'),'D');
            $tahap = $this->input->post('tahap');
            $tahun_anggaran = tahun_anggaran();
            $skpd = $this->input->post('skpd');
            $where = [ 'kode_tahap'=>2,   'id_instansi' =>$id_instansi, 'tahun' =>$tahun_anggaran];

            $pagu    = $this->db->get_where('anggaran_instansi_kab_kota', $where);
            

            if ($pagu->num_rows() > 0) {
                $value = $pagu->row();
                // foreach ($pagu->result() as $key => $value) {
                    $data_insert = [
                        'id_instansi'                  => $value->id_instansi,
                        'id_provinsi'                  => $value->id_provinsi,
                        'id_kota'                  => $value->id_kota,
                        'bo_bp'                  => $value->bo_bp,
                        'bo_bbj'                  => $value->bo_bbj,
                        'bo_bs'                  => $value->bo_bs,
                        'bo_bh'                  => $value->bo_bh,
                        'bo_bbs'                  => $value->bo_bbs,
                        'bm_bmt'                  => $value->bm_bmt,
                        'bm_bmpm'                  => $value->bm_bmpm,
                        'bm_bmgb'                  => $value->bm_bmgb,
                        'bm_bmjji'                  => $value->bm_bmjji,
                        'bm_bmatl'                  => $value->bm_bmatl,
                        'bm_bmatb'                  => $value->bm_bmatb,
                        'btt'                  => $value->btt,
                        'bt_bbh'                  => $value->bt_bbh,
                        'bt_bbk'                  => $value->bt_bbk ,
                        'realisasikan_bo'                  => $value->realisasikan_bo ,
                        'realisasikan_bm'                  => $value->realisasikan_bm ,
                        'realisasikan_btt'                  => $value->realisasikan_btt ,
                        'realisasikan_bt'                  => $value->realisasikan_bt ,
                        'kode_tahap'            =>$tahap,
                        'tahun'                 =>$value->tahun,
                    ];
                // }
                $this->db->insert('anggaran_instansi_kab_kota', $data_insert);
                // $output['cek'] = $data_insert;
                $output['status'] = true;
                $output['messages']   = "Data Pagu APBD AWAL ".$tahun_anggaran." SKPD ".$skpd." berhasil di copy";
            }else{
                $output['status']   = false;
                $output['messages']   = "Data Pagu APBD AWAL ".$tahun_anggaran." SKPD ".$skpd." tidak ada";
                  
                   
            }

            echo json_encode($output);
        }
    }


    public function save_anggaran_instansi_kab_kota()
    {
        if (!$this->input->is_ajax_request()) {
            show_404();
        } else {
            $output    = [
                'success' => false,
                'messages' => []
            ];
            $data_group     = [];
            $instansi     = $this->instansi_model;
            $validation     = $this->form_validation;
            $validation->set_rules($this->rule_pagu_instansi_kab_kota());
            $validation->set_error_delimiters('<p class="text-danger">', '</p>');


                $tahap = $this->input->post('tahap');
                $id_instansi = sbe_crypt($this->input->post('id_instansi'), 'D');
                $where = ['kode_tahap'=>$tahap,   'id_instansi' => $id_instansi];

            if ($validation->run($this)) {
                

                $pagu_instansi_kab_kota    = $this->db->get_where('anggaran_instansi_kab_kota', $where);
                if ($pagu_instansi_kab_kota->num_rows()>0) {
                    $id_paket_pekerjaan = $instansi->saveedit_anggaran_sub_kegiatan($where);
                    
                }else{
                    $id_paket_pekerjaan = $instansi->save_anggaran_sub_kegiatan();
                }


                    $output['success']     = true;
                    $output['messages'] = "Pagu berhasil di simpan";
                    $output['cek'] = $where;
                
            } else {
                $output['success'] = false;
                foreach ($_POST as $key => $value) {
                    $output['messages'][$key] = form_error($key);
                }
            }
            echo json_encode($output);
        }
    }


 public function rule_input_instansi()
    {
        
        return [
            
            [
                'field' => 'asisten',
                'label' => 'Kelompok Asisten',
                'rules' => 'required'
            ],
            [
                'field' => 'nama',
                'label' => 'Nama SKPD',
                'rules' => 'required'
            ],
            [
                'field' => 'status',
                'label' => 'Status',
                'rules' => 'required'
            ]
            
        ];
    }

 public function rule_input_instansi_teknis()
    {
        
        return [
            
            [
                'field' => 'jenis',
                'label' => 'Jenis Teknis',
                'rules' => 'required'
            ],
            [
                'field' => 'kota',
                'label' => 'Kota domisili instansi teknis',
                'rules' => 'required'
            ],
            [
                'field' => 'nama',
                'label' => 'Nama Instansi Teknis',
                'rules' => 'required'
            ],
            [
                'field' => 'status',
                'label' => 'Status',
                'rules' => 'required'
            ]
            
        ];
    }
 public function rule_input_instansi_kab_kota()
    {
        
        return [          
            [
                'field' => 'nama',
                'label' => 'Nama SKPD',
                'rules' => 'required'
            ],
            [
                'field' => 'status',
                'label' => 'Status',
                'rules' => 'required'
            ]
            
        ];
    }

 public function rule_pagu_instansi_kab_kota()
    {
        
        return [
            [
                'field' => 'bo_bp',
                'label' => 'Belanja Pegawai',
                'rules' => 'required'
            ],
            [
                'field' => 'bm_bmt',
                'label' => 'Belanja Modal Tanah',
                'rules' => 'required'
            ],
            [
                'field' => 'btt',
                'label' => 'Belanja Tidak Terduga',
                'rules' => 'required'
            ],
            [
                'field' => 'bt_bbh',
                'label' => 'Belanja Bagi Hasil',
                'rules' => 'required'
            ],
            [
                'field' => 'bo_bbj',
                'label' => 'Belanja Barang Jasa',
                'rules' => 'required'
            ],
            [
                'field' => 'bm_bmpm',
                'label' => 'Belanja Modal Peralatan Dan Mesin',
                'rules' => 'required'
            ],
            [
                'field' => 'bt_bbk',
                'label' => 'Belanja Bantuan Keuangan',
                'rules' => 'required'
            ],
            [
                'field' => 'bo_bs',
                'label' => 'Belanja Subsidi',
                'rules' => 'required'
            ],
            [
                'field' => 'bm_bmgb',
                'label' => 'Belanja Modal Gedung dan Bangunan',
                'rules' => 'required'
            ],
            [
                'field' => 'bo_bh',
                'label' => 'Belanja Hibah',
                'rules' => 'required'
            ],
            [
                'field' => 'bm_bmjji',
                'label' => 'Belanja Modal Jalan, Jaringan, dan Irigasi',
                'rules' => 'required'
            ],
            [
                'field' => 'bm_bmatl',
                'label' => 'Belanja Modal dan Aset Tetap Lainnya',
                'rules' => 'required'
            ],
            
        ];
    }



    public function simpan_instansi()
    {
        if (!$this->input->is_ajax_request()) {
            show_404();
        } else {
            $output    = [
                'success' => false,
                'messages' => []
            ];
            $data_group     = [];
            $instansi     = $this->instansi_model;
            $validation     = $this->form_validation;
           
            $validation->set_rules($this->rule_input_instansi());
            $validation->set_error_delimiters('<p class="text-danger">', '</p>');
        

            $post               = $this->input->post();
            $kode = $this->input->post('kode');
            $asisten = $this->input->post('asisten');
            $nama = $this->input->post('nama');
            $status = $this->input->post('status');




            if ($validation->run($this)) {
                $simpan = $instansi->save_instansi();
                    $output['success']     = true;
                    $output['messages'] = "SKPD berhasil di simpan";
                
            } else {
                $output['success'] = false;
                foreach ($_POST as $key => $value) {
                    $output['messages'][$key] = form_error($key);
                }
            }
            echo json_encode($output);
        }
    }


    public function simpan_instansi_teknis()
    {
        if (!$this->input->is_ajax_request()) {
            show_404();
        } else {
            $output    = [
                'success' => false,
                'messages' => []
            ];
            $data_group     = [];
            $instansi     = $this->instansi_model;
            $validation     = $this->form_validation;
           
            $validation->set_rules($this->rule_input_instansi_teknis());
            $validation->set_error_delimiters('<p class="text-danger">', '</p>');
        

            $post               = $this->input->post();
            $kode = $this->input->post('kode');
            $jenis = $this->input->post('jenis');
            $nama = $this->input->post('nama');
            $status = $this->input->post('status');
            $id_kota = $this->input->post('kota');




            if ($validation->run($this)) {


























                 if ($kode !='') {
                    $cek_kode = $instansi->cek_kode_instansi(id_instansi(), $kode);
                    $ditemukan = $cek_kode->num_rows();
                    if ($ditemukan > 0) {
                        $output['success']     = false;
                        $output['messages']['kode'] = 'Gagal menyimpan Instansi Teknis. Kode Instansi Teknis '.$kode.' Sudah Digunakan';
                    }else{
                        $simpan = $instansi->save_instansi_teknis($kode);
                    $output['success']     = true;
                    $output['messages'] = "Instansi Teknis berhasil di simpan";


                    }
                }else{
                    $cek_kode_ski = $instansi->cek_urutan_instansi_teknis(id_instansi());
                    $max_kode = intval($cek_kode_ski->row()->max_kode);
                    $next_kode = $max_kode + 1; 
                    if ($next_kode>0 && $next_kode <10) {
                        $savekode = '000'.$next_kode ;
                    }
                    elseif ($next_kode>=10 && $next_kode <100) {
                        $savekode = '00'.$next_kode ;
                    }
                    elseif ($next_kode>=100 && $next_kode <1000) {
                        $savekode = '0'.$next_kode ;
                    }else{
                        $savekode = $next_kode ;
                    }



                          $simpan = $instansi->save_instansi_teknis($savekode);
                    $output['success']     = true;
                    $output['messages'] = "Instansi Teknis berhasil di simpan";



                }












                
                
            } else {
                $output['success'] = 'false';
                foreach ($_POST as $key => $value) {
                    $output['messages'][$key] = form_error($key);
                }
            }
            echo json_encode($output);
        }
    }

    public function simpanedit_instansi_teknis()
    {
        if (!$this->input->is_ajax_request()) {
            show_404();
        } else {
            $output    = [
                'success' => false,
                'messages' => []
            ];
            $data_group     = [];
            $instansi     = $this->instansi_model;
            $validation     = $this->form_validation;
           
            $validation->set_rules($this->rule_input_instansi_teknis());
            $validation->set_error_delimiters('<p class="text-danger">', '</p>');
        

            $post               = $this->input->post();
            $kode = $this->input->post('kode');
            $jenis = $this->input->post('jenis');
            $nama = $this->input->post('nama');
            $status = $this->input->post('status');

            $id_instansi_pembantu_teknis = $this->input->post('id_instansi_pembantu_teknis');
            $id_instansi_pembantu_teknis = sbe_crypt($id_instansi_pembantu_teknis, 'D');
            $id_kota = $this->input->post('kota');

            if ($validation->run($this)) {
                 if ($kode !='') {
                    $cek_kode = $instansi->cek_kode_instansi_edit(id_instansi(), $kode, $id_instansi_pembantu_teknis );
                    $ditemukan = $cek_kode->num_rows();
                    if ($ditemukan > 0) {
                        $output['success']     = false;
                        $output['messages']['kode'] = 'Gagal menyimpan Instansi Teknis. Kode Instansi Teknis '.$kode.' Sudah Digunakan';
                    }else{
                        $simpan = $instansi->saveedit_instansi_teknis($kode, $id_instansi_pembantu_teknis );
                    $output['success']     = true;
                    $output['messages'] = "Instansi Teknis berhasil di simpan";
                    }
                }else{
                    $cek_kode_ski = $instansi->cek_urutan_instansi_teknis(id_instansi());
                    $max_kode = intval($cek_kode_ski->row()->max_kode);
                    $next_kode = $max_kode + 1; 
                    if ($next_kode>0 && $next_kode <10) {
                        $savekode = '000'.$next_kode ;
                    }
                    elseif ($next_kode>=10 && $next_kode <100) {
                        $savekode = '00'.$next_kode ;
                    }
                    elseif ($next_kode>=100 && $next_kode <1000) {
                        $savekode = '0'.$next_kode ;
                    }else{
                        $savekode = $next_kode ;
                    }



                    $simpan = $instansi->saveedit_instansi_teknis($savekode, $id_instansi_pembantu_teknis );
                    $output['success']     = true;
                    $output['messages'] = "Instansi Teknis berhasil di simpan";



                }












                
                
            } else {
                $output['success'] = 'false';
                foreach ($_POST as $key => $value) {
                    $output['messages'][$key] = form_error($key);
                }
            }
            echo json_encode($output);
        }
    }

    public function simpan_instansi_kab_kota()
    {
        if (!$this->input->is_ajax_request()) {
            show_404();
        } else {
            $output    = [
                'success' => false,
                'messages' => []
            ];
            $instansi     = $this->instansi_model;
            $validation     = $this->form_validation;
           
            $validation->set_rules($this->rule_input_instansi_kab_kota());
            $validation->set_error_delimiters('<p class="text-danger">', '</p>');
        

            $post               = $this->input->post();
          

            if ($validation->run($this)) {
                $simpan = $instansi->save_instansi_kab_kota();
                    $output['success']     = true;
                    $output['messages'] = "SKPD berhasil di simpan";
                
            } else {
                $output['success'] = false;
                foreach ($_POST as $key => $value) {
                    $output['messages'][$key] = form_error($key);
                }
            }
            echo json_encode($output);
        }
    }


    public function simpanedit_instansi()
    {
        if (!$this->input->is_ajax_request()) {
            show_404();
        } else {
            $output    = [
                'success' => false,
                'messages' => []
            ];
            $data_group     = [];
            $instansi     = $this->instansi_model;
            $validation     = $this->form_validation;
           
            $validation->set_rules($this->rule_input_instansi());
            $validation->set_error_delimiters('<p class="text-danger">', '</p>');
        

            $post               = $this->input->post();
            $id_instansi = sbe_crypt($this->input->post('id_instansi'), 'D');



            if ($validation->run($this)) {
                $simpan = $instansi->saveedit_instansi($id_instansi);
                    $output['success']     = true;
                    $output['messages'] = "SKPD berhasil di Perbaharui";
                
            } else {
                $output['success'] = false;
                foreach ($_POST as $key => $value) {
                    $output['messages'][$key] = form_error($key);
                }
            }
            echo json_encode($output);
        }
    }



    public function simpanedit_instansi_kab_kota()
    {
        if (!$this->input->is_ajax_request()) {
            show_404();
        } else {
            $output    = [
                'success' => false,
                'messages' => []
            ];
            $data_group     = [];
            $instansi     = $this->instansi_model;
            $validation     = $this->form_validation;
           
            $validation->set_rules($this->rule_input_instansi_kab_kota());
            $validation->set_error_delimiters('<p class="text-danger">', '</p>');
        

            $post               = $this->input->post();
            $id_instansi = sbe_crypt($this->input->post('id_instansi'), 'D');



            if ($validation->run($this)) {
                $simpan = $instansi->saveedit_instansi_kab_kota($id_instansi);
                    $output['success']     = true;
                    $output['messages'] = "SKPD berhasil di Perbaharui";
                
            } else {
                $output['success'] = false;
                foreach ($_POST as $key => $value) {
                    $output['messages'][$key] = form_error($key);
                }
            }
            echo json_encode($output);
        }
    }



	public function hapus_instansi_kab_kota()
	{
		if (!$this->input->is_ajax_request()) {
            show_404();
        } else {
             $output = [
                'status'    => false,
                'message'      =>''
            ];
            $id_kota = $this->session->userdata('id_kota');
            $id_instansi = sbe_crypt($this->input->post('id_instansi'), 'D');
            $this->db->delete('master_instansi_kab_kota',  ['id_instansi'=>$id_instansi, 'id_kota'=>$id_kota]);
            $this->db->delete('anggaran_instansi_kab_kota',  ['id_instansi'=>$id_instansi, 'id_kota'=>$id_kota]);
            $this->db->delete('realisasi_fisik_keuangan_kab_kota',  ['id_instansi'=>$id_instansi, 'id_kota'=>$id_kota]);
            $output['status'] = true;

            echo json_encode($output);
        }
	}



    public function hapus_instansi()
    {
        if (!$this->input->is_ajax_request()) {
            show_404();
        } else {
             $output = [
                'status'    => false,
                'message'      =>''
            ];
            $id_instansi = sbe_crypt($this->input->post('id_instansi'), 'D');
            $this->db->delete('master_instansi',  ['id_instansi'=>$id_instansi]);
            $output['status'] = true;

            echo json_encode($output);
        }
    }



    public function hapus_instansi_teknis()
    {
        if (!$this->input->is_ajax_request()) {
            show_404();
        } else {
             $output = [
                'status'    => false,
                'message'      =>''
            ];
            $id_instansi = sbe_crypt($this->input->post('id_instansi'), 'D');
            $this->db->delete('instansi_pembantu_teknis',  ['id_instansi_pembantu_teknis'=>$id_instansi]);
            $output['status'] = true;

            echo json_encode($output);
        }
    }



}
