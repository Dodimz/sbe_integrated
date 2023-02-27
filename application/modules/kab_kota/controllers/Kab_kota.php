<?php

/**
 * Author     : Alfikri, M.Kom
 * Created By : Alfikri, M.Kom
 * E-Mail     : alfikri.name@gmail.com
 * No HP      : 081277337405
 * Class      : Instansi.php
 */
defined('BASEPATH') or exit('No direct script access allowed');

class Kab_kota extends MY_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model([
			'instansi/instansi_model' => 'instansi_model',

            'kab_kota/kab_kota_model' => 'kab_kota_model',
            'datatables_model'                         => 'datatables_model'
		]);
	}

	public function index()
	{
       
    		$breadcrumbs 	= $this->breadcrumbs;
    		$instansi  		= $this->instansi_model;

    		$breadcrumbs->add('Home', base_url());
    		$breadcrumbs->add('Instansi', base_url($this->router->fetch_class()));
    		$breadcrumbs->render();

    		$data['title']			= "Manajemen Konfigurasi Kab Kota";
    		$data['icon']           = "metismenu-icon pe-7s-culture";
    		$data['description']	= "Menampilkan aktivitas yang dilakukan oleh kab kota";
    		$data['breadcrumbs']	= $breadcrumbs->render();
    		$page 					= 'kab_kota/index';
    		$data['link']           = $this->router->fetch_method();
    		$data['menu']           = $this->load->view('layout/menu', $data, true);
    		$data['extra_css']		= $this->load->view('kab_kota/css', $data, true);
    		$data['extra_js']		= $this->load->view('kab_kota/js', $data, true);
    		$data['modal']		= $this->load->view('kab_kota/modal', $data, true);
    		$this->template->load('backend_template', $page, $data);
        
	}

    public function get_ckk()
    {
        if (!$this->input->is_ajax_request()) {
            show_404();
        } else {
             $output = [
                'status'    => false,
                'data'      => []
            ];
            $id_config = sbe_crypt($this->input->post('id_config'), 'D');
            $ckk = $this->kab_kota_model->get_config_kab_kota($id_config)->row();


            $output['data']['id_config']                  = sbe_crypt($ckk->id_config_kab_kota, 'E');
            $logo  = $ckk->logo =='' ? '' : '<center><img src="'.base_url().'assets/logo_kab_kota/'.$ckk->logo.'" width="75px"></center>';
            $output['data']['nama_kota']                  = $ckk->nama_kota;
            $output['data']['wilayah']                  = $ckk->wilayah;
            $output['data']['logo']                  = $logo;
        
            $output['data']['replikasi_aplikasi']                  = $ckk->replikasi;
            $output['data']['url_replikasi']                  = $ckk->url_replikasi;
            $output['data']['sumber_data_sumbar_siap']                  = $ckk->sumber_data_sumbar_siap;
            $output['data']['integrasi_replikasi']                  = $ckk->integrasi_replikasi ;
            $output['data']['token_integrasi_replikasi']                  = $ckk->token_integrasi_replikasi ;

            

            echo json_encode($output);
        }
    }



    public function data_kab_kota()
    {
        if (!$this->input->is_ajax_request()) {
            show_404();
        } else {            
                $where          = [];
            
            $column_order   = ['', 'nama_instansi'];
            $column_search  = ['nama_kota'];
            $order          = ['nama_kota' => 'ASC'];
            $list           = $this->datatables_model->get_datatables('v_manajemen_kab_kota', $column_order, $column_search, $order, $where);
            $data           = [];
            $no             = $_POST['start'];
            $status = [2=>'APBD AWAL',4=>'APBD PERUBAHAN'];
            $replikasi = [
                                1=>'Belum Mereplikasikan',
                                'Install Localhost / Penyerahan Source Code',
                                'Instalasi & Testing Server',
                                'Instalasi Online Online',
                                'Testing, Maintenance, Penyesuaian Data',
                                'Implementasi & Maintenance Online',
                                'Terintegrasikan ',
                            ];
            foreach ($list as $lists) {
                $no++;
                $logo  = $lists->logo =='' ? '' : '<img src="'.base_url().'assets/logo_kab_kota/'.$lists->logo.'" width="75px">';
                $row    = [];
                $row[]     = $no;
                $row[]  = $logo;
                $row[]  = $lists->nama_kota;
                $row[]  = $lists->wilayah;
                $row[]  = $lists->tahun;
                $row[]  = $status[$lists->kode_tahap];
                $row[]  = @$replikasi[$lists->replikasi];
                $row[]  = '<a href="'.$lists->url_replikasi.'" target="_blank">'.$lists->url_replikasi.'</a>';
                $row[]  = $lists->integrasi_replikasi ;
                $row[]  = $lists->sumber_data_sumbar_siap ;


                 $tombol_edit = '<button class="btn btn-outline-info btn-xs"  title="Edit Config '.$lists->nama_kota.'"  onclick="edit_config_kab_kota('."'".sbe_crypt($lists->id_config_kab_kota, 'E')."'".')"><i class="fas fa-edit"></i></button>';

                $row[]  =$tombol_edit ;
                // $tombol_edit = '<button class="btn btn-outline-info btn-xs"  title="Edit Instansi'.$lists->nama_instansi.'"  onclick="edit_instansi('."'".sbe_crypt($lists->id_instansi, 'E')."'".')"><i class="fas fa-edit"></i></button>';
                // $tombol_hapus = '<button class="btn btn-outline-danger btn-xs"  title="Edit Instansi'.$lists->nama_instansi.'"  onclick="hapus_instansi('."'".sbe_crypt($lists->id_instansi, 'E')."'".' , '."'".$lists->nama_instansi."'".')"><i class="fas fa-trash"></i></button>';
                // $row[]  = $tombol_edit.' '.$tombol_hapus;


                $data[] = $row;
            }

            $output = [
                "draw"              => $_POST['draw'],
                "recordsTotal"      => $this->datatables_model->count_all('v_manajemen_kab_kota', $where),
                "recordsFiltered"   => $this->datatables_model->count_filtered('v_manajemen_kab_kota', $column_order, $column_search, $order, $where),
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


    public function simpanedit_ckk()
    {
        if (!$this->input->is_ajax_request()) {
            show_404();
        } else {
            $output    = [
                'success' => false,
                'messages' => [],
                'cek' =>$this->input->post()
            ];
            $data_group     = [];
            $ckk     = $this->kab_kota_model;


            $id_ckk = sbe_crypt($this->input->post('id_config'), 'D');
                $simpan = $ckk->saveedit_ckk($id_ckk);

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



}
