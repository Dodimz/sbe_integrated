<?php

/**
 * Author     : Alfikri, M.Kom
 * Created By : Alfikri, M.Kom
 * E-Mail     : alfikri.name@gmail.com
 * No HP      : 081277337405
 * Class      : config.php
 */
defined('BASEPATH') or exit('No direct script access allowed');

class Config extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model([
            'config/config_model' => 'config_model',
            'datatables_model'                         => 'datatables_model'
        ]);
    }

    public function index()
    {
        if ($this->session->userdata('id_group')==7) {
            $this->config_kab_kota();
        }elseif ($this->session->userdata('id_group')==5) {
            $this->config_instansi();
        }else{
            $breadcrumbs    = $this->breadcrumbs;
            $config         = $this->config_model;

            $breadcrumbs->add('Home', base_url());
            $breadcrumbs->add('config', base_url($this->router->fetch_class()));
            $breadcrumbs->render();

            $data['title']          = "Konfigurasi Aplikasi";
            $data['icon']           = "metismenu-icon pe-7s-culture";
            $data['description']    = "Menampilkan Struktur Organisasi";
            $data['breadcrumbs']    = $breadcrumbs->render();
            $page                   = 'config/index';
            $data['link']           = $this->router->fetch_method();
            $tahun_ini=date('Y');
   
            $data_config = $this->db->query("SELECT tahun_anggaran from config where tahun_anggaran='$tahun_ini'")->num_rows();
            $this->db->order_by('id_config', 'DESC');
            $data['data_config']    = $this->db->get('config')->result_array();
            $data['izin_config']    = $this->db->get('izin_konfigurasi')->row_array();
            $data['j_data_config']           = $data_config;
            $data['menu']           = $this->load->view('layout/menu', $data, true);
            $data['extra_css']      = $this->load->view('config/css', $data, true);
            $data['extra_js']       = $this->load->view('config/js', $data, true);
            $data['modal']      = $this->load->view('config/modal', $data, true);
            $this->template->load('backend_template', $page, $data);
        }
    }


    public function config_kab_kota()
    {
        
            $breadcrumbs    = $this->breadcrumbs;
            $config_model       = $this->config_model;

            $breadcrumbs->add('Home', base_url());
            $breadcrumbs->add('config', base_url($this->router->fetch_class()));
            $breadcrumbs->render();

            $data['title']          = "Master config";
            $data['icon']           = "metismenu-icon pe-7s-culture";
            $data['description']    = "Menampilkan Struktur Organisasi";
            $data['breadcrumbs']    = $breadcrumbs->render();
            $data['data']           = $this->config_model->config_kab_kota(13, $this->session->userdata('id_kota'))->row();
            $data['nama_tahap']    = [2=>'APBD AWAL',4=>'APBD PERUBAHAN'];
            $id_kota = $this->session->userdata('id_kota');
            $data_config = $this->db->query("SELECT * from config")->result_array();

            $pj = $this->db->query("SELECT id_pj, nama from pj_pelaporan_kab_kota where id_kota='$id_kota'")->result_array();
            $instansi = $this->db->query("SELECT id_instansi, nama_instansi from master_instansi_kab_kota where id_kota='$id_kota'")->result_array();
            $data['data_config']           = $data_config;
            $data['pj']           = $pj;
            $data['data_instansi']           = $instansi;


            $page                   = 'config/config_kab_kota/index';
            $data['link']           = $this->router->fetch_method();
            $data['menu']           = $this->load->view('layout/menu', $data, true);
            $data['extra_css']      = $this->load->view('config/config_kab_kota/css', $data, true);
            $data['extra_js']       = $this->load->view('config/config_kab_kota/js', $data, true);
            $data['modal']      = $this->load->view('config/config_kab_kota/modal', $data, true);
            $this->template->load('backend_template', $page, $data);
        
    }

    public function config_instansi()
    {
        
            $breadcrumbs    = $this->breadcrumbs;
            $config_model       = $this->config_model;

            $breadcrumbs->add('Home', base_url());
            $breadcrumbs->add('config', base_url($this->router->fetch_class()));
            $breadcrumbs->render();

            $data['title']          = "Master config";
            $data['icon']           = "metismenu-icon pe-7s-culture";
            $data['description']    = "Menampilkan Struktur Organisasi";
            $data['breadcrumbs']    = $breadcrumbs->render();
            $id_instansi = id_instansi();
            $q_izin_config = $this->db->get("izin_konfigurasi")->row_array();
            $q = $this->db->query("SELECT 
                    mi.nama_instansi,
                    mi.id_config as id_config_instansi,
                    mi.kode_tahap ,
                    c.id_config,
                    c.tahun_anggaran,
                    c.tahapan_apbd,
                    c.bulan_aktif,
                    c.jadwal_input_data_dasar_awal,
                    c.jadwal_input_data_dasar_akhir,
                    c.tgl_input_rfk_mulai,
                    c.tgl_input_rfk_akhir,
                    c.tgl_validasi_rfk_mulai,
                    c.tgl_validasi_rfk_akhir,
                    c.penginputan,
                    c.status
             from master_instansi mi 
                left join config c on mi.id_config = c.id_config
                where mi.id_instansi='$id_instansi'")->row_array();

            $data['nama_tahap']    = [2=>'APBD AWAL',4=>'APBD PERUBAHAN'];
            $page                   = 'config/config_instansi/index';
            $data['config']           = $q;
            $data['izin_config']      = $q_izin_config['izin'];
             $this->db->order_by('tahun_anggaran', 'DESC');
            $data['data_config']           = $this->db->get('config')->result_array();
            $data['data_config_aktif']           = $this->db->get_where('config',['status'=>1])->row_array();
            $data['link']           = $this->router->fetch_method();
            $data['menu']           = $this->load->view('layout/menu', $data, true);
            $data['extra_css']      = $this->load->view('config/config_instansi/css', $data, true);
            $data['extra_js']       = $this->load->view('config/config_instansi/js', $data, true);
            $data['modal']      = $this->load->view('config/config_instansi/modal', $data, true);
            $this->template->load('backend_template', $page, $data);
        
    }
 public function rule_input_config_kab_kota()
    {
        
        return [
            
            [
                'field' => 'tahap',
                'label' => 'Tahapan APBD',
                'rules' => 'required'
            ],
           
            
        ];
    }


 public function rule_input_config()
    {
        
        return [
            
            [
                'field' => 'jadwal_input_data_dasar_awal',
                'label' => 'Jadwal input data dasar awal',
                'rules' => 'required'
            ],
            [
                'field' => 'jadwal_input_data_dasar_akhir',
                'label' => 'Jadwal input data dasar akhir',
                'rules' => 'required'
            ],
            
        ];
    }

 public function rule_input_pj_pelaporan_kab_kota()
    {
        
        return [
            
            [
                'field' => 'id_instansi',
                'label' => 'Instansi',
                'rules' => 'required'
            ],
            [
                'field' => 'nama',
                'label' => 'Nama',
                'rules' => 'required'
            ],
            [
                'field' => 'nip',
                'label' => 'NIP',
                'rules' => 'required'
            ],
            [
                'field' => 'jabatan',
                'label' => 'Jabatan',
                'rules' => 'required'
            ],
            [
                'field' => 'mulai_pj',
                'label' => 'Mulai PJ',
                'rules' => 'required'
            ],
            [
                'field' => 'akhir_pj',
                'label' => 'Akhir PJ',
                'rules' => 'required'
            ],
            
        ];
    }

    public function simpanedit_config_instansi(){
        $id_config  = $this->input->post('id_config');
        $tahap  = $this->input->post('tahap');
        $id_instansi = id_instansi();
        $data = ['id_config' =>$id_config, 'kode_tahap'=>$tahap];
        $where = ['id_instansi'=>$id_instansi];
        $this->db->update('master_instansi', $data, $where);
        redirect('config');

    }

    public function simpanedit_config_kab_kota()
    {
        if (!$this->input->is_ajax_request()) {
            show_404();
        } else {
            $output    = [
                'success' => false,
                'messages' => []
            ];
            $data_group     = [];
            $config     = $this->config_model;
            $validation     = $this->form_validation;
           
            $validation->set_rules($this->rule_input_config_kab_kota());
            $validation->set_error_delimiters('<p class="text-danger">', '</p>');
        

            $post               = $this->input->post();
            $mulai = $this->input->post('mulai');
            $selesai = $this->input->post('selesai');




            if ($validation->run($this)) {
                if ($mulai > $selesai) {
                     $output['success']     = true;
                    $output['messages'] = "Gagal menyimpan. Tanggal mulai tidak boleh diatas tanggal selesai";
                }else{
                    $simpan = $config->simpanedit_config_kab_kota(13, $this->session->userdata('id_kota'));
                        $output['success']     = true;
                        $output['messages'] = "Konfigurasi di simpan";
                        $this->session->set_flashdata('pesan','<div class="alert alert-success">Konfigurasi diperbaharui</div>');
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


    public function data_konfigurasi()
    {
        if (!$this->input->is_ajax_request()) {
            show_404();
        } else {
            $where          = array();
            $column_order   = array('', 'tahun_anggaran');
            $column_search  = array('tahun_anggaran');
            $order = array('tahun_anggaran' => 'DESC');
            $data = array();
            $no = $_POST['start'];
            $tahap = [2=>'APBD Awal','APBD Pergeseran','APBD Perubahan'];
            $penginputan = ['Kunci penginputan','Penginputan sesuai jadwal','Penginputan tanpa batas waktu'];
            $list = $this->datatables_model->get_datatables('config', $column_order, $column_search, $order, $where);
            foreach ($list as $lists) {
                $no++;
                
                 $tabel_apbd = ' <table width="100%">
                                    <tr>
                                        <td>Bulan Aktif</td>
                                        <td>:</td>
                                        <td>'.bulan_global($lists->bulan_aktif).'</td>
                                    </tr>
                                    <tr>
                                        <td>Tahun Anggaran</td>
                                        <td>:</td>
                                        <td>'.$lists->tahun_anggaran.'</td>
                                    </tr>
                                    <tr>
                                        <td>Tahapan APBD</td>
                                        <td>:</td>
                                        <td>'.$tahap[$lists->tahapan_apbd].'</td>
                                    </tr>
                            </table>';
                 $tabel_input_data_dasar = $lists->tgl_input_rfk_mulai.' - '.$lists->tgl_input_rfk_akhir.' '.bulan_global($lists->bulan_aktif).' '.$lists->tahun_anggaran;
                 $tabel_input_data_rfk_prov =$lists->tgl_input_rfk_mulai.' - '.$lists->tgl_input_rfk_akhir.' '.bulan_global($lists->bulan_aktif).' '.$lists->tahun_anggaran;

                 $tabel_jadwal_validasi =$lists->tgl_validasi_rfk_mulai.' - '.$lists->tgl_validasi_rfk_akhir.' '.bulan_global($lists->bulan_aktif).' '.$lists->tahun_anggaran;
                 $tabel_input_data_rfk_kab_kota =$lists->tgl_validasi_rfk_mulai.' - '.$lists->tgl_validasi_rfk_akhir.' '.bulan_global($lists->bulan_aktif).' '.$lists->tahun_anggaran;



                $onclick_edit = 'edit_config('."'".sbe_crypt($lists->id_config, 'E')."'".')';
                $onclick_belum_aktif = "Swal.fire('Error','Belum Aktif','error')";

                $edit   = '<button class="btn btn-info btn-xs"  title="Edit konfigurasi aplikasi '.$lists->tahun_anggaran.'"  onclick="'.$onclick_edit.'"><i class="fas fa-edit"></i></button> <button class="btn btn-danger btn-xs"  title="Aktifkan dan nonaktifkan"  onclick="'.$onclick_belum_aktif.'"><i class="fas fa-power-off"></i></button> ';

                $status_config = $lists->status == 1 ? 'Aktif' : 'Tidak Aktif' ;

                $row    = [];
                $row[] = $no++ ;
                
                $row[] = $tabel_apbd;
                $row[] = $tabel_input_data_dasar;
                $row[] = $tabel_input_data_rfk_prov;
                $row[] = $tabel_jadwal_validasi;
                $row[] = $tabel_input_data_rfk_kab_kota;
                $row[] = $penginputan[$lists->penginputan];
                $row[] = $status_config;
                $row[] = $edit;

                $data[] = $row;
            }

            $output = array(
                "draw" => $_POST['draw'],
                "recordsTotal" => $this->datatables_model->count_all('config', $where),
                "recordsFiltered" => $this->datatables_model->count_filtered('config', $column_order, $column_search, $order, $where),
                "data" => $data,
            );

            echo json_encode($output);
        }
    }



    public function simpan_konfigurasi()
    {
        if (!$this->input->is_ajax_request()) {
            show_404();
        } else {
            $output    = [
                'success' => false,
                'messages' => []
            ];
            $data_group     = [];
            $validation     = $this->form_validation;
           
            $validation->set_rules($this->rule_input_config());
            $validation->set_error_delimiters('<p class="text-danger">', '</p>');
        
     

            if ($validation->run($this)) {
                
                $post               = $this->input->post();
                $tahapan_apbd = $this->input->post('tahapan_apbd');
                $bulan_aktif = $this->input->post('bulan_aktif');
                $jadwal_input_data_dasar_awal = $this->input->post('jadwal_input_data_dasar_awal');
                $jadwal_input_data_dasar_akhir = $this->input->post('jadwal_input_data_dasar_akhir');
                $tgl_input_rfk_mulai = $this->input->post('tgl_input_rfk_mulai');
                $tgl_input_rfk_akhir = $this->input->post('tgl_input_rfk_akhir');
                $tgl_validasi_rfk_mulai = $this->input->post('tgl_validasi_rfk_mulai');
                $tgl_validasi_rfk_akhir = $this->input->post('tgl_validasi_rfk_akhir');
                $tgl_input_rfk_kab_kota_awal = $this->input->post('tgl_input_rfk_kab_kota_awal');
                $tgl_input_rfk_kab_kota_akhir = $this->input->post('tgl_input_rfk_kab_kota_akhir');
                $penginputan_provinsi = $this->input->post('penginputan_provinsi');
                $penginputan_kab_kota = $this->input->post('penginputan_kab_kota');
                $tahun_ini = date('Y');

                $data_input = [
                    'tahun_anggaran'=>$tahun_ini,
                    'tahapan_apbd'=>$tahapan_apbd,
                    'bulan_aktif'=>$bulan_aktif,
                    'jadwal_input_data_dasar_awal'=>$jadwal_input_data_dasar_awal,
                    'jadwal_input_data_dasar_akhir'=>$jadwal_input_data_dasar_akhir,
                    'tgl_input_rfk_mulai'=>$tgl_input_rfk_mulai,
                    'tgl_input_rfk_akhir'=>$tgl_input_rfk_akhir,
                    'tgl_validasi_rfk_mulai'=>$tgl_validasi_rfk_mulai,
                    'tgl_validasi_rfk_akhir'=>$tgl_validasi_rfk_akhir,
                    'tgl_input_rfk_kab_kota_awal'=>$tgl_input_rfk_kab_kota_awal,
                    'tgl_input_rfk_kab_kota_akhir'=>$tgl_input_rfk_kab_kota_akhir,
                    'penginputan'=>$penginputan_provinsi, 
                    'penginputan_kab_kota'=>$penginputan_kab_kota, 
                    'status'=>1, 
                    'created_on'=>timestamp(), 
                    'created_by'=>id_user(), 
                ];

                $cek_sudah_ada = $this->db->query("SELECT tahun_anggaran from config where tahun_anggaran='$tahun_ini'")->num_rows();
                if ($cek_sudah_ada>0) {
                    $output['success']     = false;
                    $output['messages'] = "Konfigurasi gagaL ditambahkan. Tahun anggaran ".$tahun_ini." sudah ada";
                    
                }else{
                    $this->db->update('config' , ['status'=>0],['status'=>1]);
                    $this->db->insert('config' , $data_input);

                $this->session->set_flashdata('pesan','<div class="alert alert-info">Data konfigurasi ditambahkan. <br>Anda tidak bisa lagi menambahkan konfigurasi untuk tahun ini dan bisa ditambahkan kembali di tahun selanjutnya</div>');
                    $output['success']     = true;
                    $output['messages'] = "Konfigurasi aplikasi ditambahkan";
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


    public function simpanedit_konfigurasi()
    {
        if (!$this->input->is_ajax_request()) {
            show_404();
        } else {
            $output    = [
                'success' => false,
                'messages' => []
            ];
            $data_group     = [];
            $validation     = $this->form_validation;
           
            $validation->set_rules($this->rule_input_config());
            $validation->set_error_delimiters('<p class="text-danger">', '</p>');
        
     

            if ($validation->run($this)) {
                
                $post               = $this->input->post();
                $id_config = sbe_crypt($this->input->post('id_config'), 'D');
                $tahapan_apbd = $this->input->post('tahapan_apbd');
                $tahun_anggaran = $this->input->post('tahun_anggaran');
                $bulan_aktif = $this->input->post('bulan_aktif');
                $jadwal_input_data_dasar_awal = $this->input->post('jadwal_input_data_dasar_awal');
                $jadwal_input_data_dasar_akhir = $this->input->post('jadwal_input_data_dasar_akhir');
                $tgl_input_rfk_mulai = $this->input->post('tgl_input_rfk_mulai');
                $tgl_input_rfk_akhir = $this->input->post('tgl_input_rfk_akhir');
                $tgl_validasi_rfk_mulai = $this->input->post('tgl_validasi_rfk_mulai');
                $tgl_validasi_rfk_akhir = $this->input->post('tgl_validasi_rfk_akhir');
                $tgl_input_rfk_kab_kota_awal = $this->input->post('tgl_input_rfk_kab_kota_awal');
                $tgl_input_rfk_kab_kota_akhir = $this->input->post('tgl_input_rfk_kab_kota_akhir');
                $penginputan_provinsi = $this->input->post('penginputan_provinsi');
                $penginputan_kab_kota = $this->input->post('penginputan_kab_kota');
                $waktu_kunci = $this->input->post('waktu_kunci');
                $waktu_awal = $this->input->post('waktu_awal');
                $waktu_kunci_kota = $this->input->post('waktu_kunci_kota');
                $waktu_awal_kota = $this->input->post('waktu_awal_kota');


                $data_input = [
                    'tahapan_apbd'=>$tahapan_apbd,
                    'bulan_aktif'=>$bulan_aktif,
                    'jadwal_input_data_dasar_awal'=>$jadwal_input_data_dasar_awal,
                    'jadwal_input_data_dasar_akhir'=>$jadwal_input_data_dasar_akhir,
                    'tgl_input_rfk_mulai'=>$tgl_input_rfk_mulai,
                    'tgl_input_rfk_akhir'=>$tgl_input_rfk_akhir,
                    'tgl_validasi_rfk_mulai'=>$tgl_validasi_rfk_mulai,
                    'tgl_validasi_rfk_akhir'=>$tgl_validasi_rfk_akhir,
                    'tgl_input_rfk_kab_kota_awal'=>$tgl_input_rfk_kab_kota_awal,
                    'tgl_input_rfk_kab_kota_akhir'=>$tgl_input_rfk_kab_kota_akhir,
                    'penginputan'=>$penginputan_provinsi,
                    'penginputan_kab_kota'=>$penginputan_kab_kota,
                    'jam_mulai_penginputan'=>$waktu_awal,
                    'jam_akhir_penginputan'=>$waktu_kunci,
                    'waktu_mulai_penginputan_kab_kota'=>$waktu_awal_kota,
                    'waktu_akhir_penginputan_kab_kota'=>$waktu_kunci_kota,
                    'updated_on'=>timestamp(), 
                    'updated_by'=>id_user(), 
                ];

                
                    $this->db->update('config' , $data_input, ['id_config'=>$id_config]);

                    $output['success']     = true;
                    $output['tahun']     =  $tahun_anggaran;
                    $output['messages'] = "Konfigurasi aplikasi ditambahkan";
                    $this->session->set_flashdata('pesan','<div class="alert alert-info">Konfigurasi tahun anggaran '.$tahun_anggaran.' diperbaharui</div>');
                


                
            } else {
                $output['success'] = false;
                foreach ($_POST as $key => $value) {
                    $output['messages'][$key] = form_error($key);
                }
            }
            echo json_encode($output);
        }
    }

    public function simpan_izin_konfigurasi()
    {
        if (!$this->input->is_ajax_request()) {
            show_404();
        } else {
                $izin = $this->input->post('izin');
                $izin_kab_kota = $this->input->post('izin_kab_kota');
                $data_input = [
                    'izin'=>$izin,
                    'izin_kab_kota'=>$izin_kab_kota,
                ];

                $config = $this->db->query("SELECT id_config, tahapan_apbd from config where status='1'")->row_array();
                    $tahap = $config['tahapan_apbd'];
                    $id_config = $config['id_config'];
                    $data = [
                        'id_config'=>$id_config,
                        'kode_tahap'=>$tahap,
                        'config_by' =>$this->session->userdata('id_group')
                    ];
                    $data_kota = [
                        'id_config'=>$id_config,
                        'tahapan_apbd'=>$tahap,
                        'config_by' =>$this->session->userdata('id_group')
                    ];
                if ($izin==0) {
                    $this->db->update('master_instansi' , $data);
                }
                if ($izin_kab_kota==0) {
                    $this->db->update('config_kab_kota' , $data_kota);
                }

                $this->db->update('izin_konfigurasi' , $data_input);
        }
    }
    public function get_config()
    {
        if (!$this->input->is_ajax_request()) {
            show_404();
        } else {
             $output = [
                'status'    => false,
                'data'      => []
            ];
            $id_config = sbe_crypt($this->input->post('id_config'), 'D');
            $config = $this->db->get_where('config' , ['id_config'=>$id_config])->row();


            $output['data']['id_config']                  = sbe_crypt($config->id_config, 'E');
            $output['data']['tahun_anggaran']                  =$config->tahun_anggaran;
            $output['data']['tahapan_apbd']                  =$config->tahapan_apbd;
            $output['data']['bulan_aktif']                  =$config->bulan_aktif;
            $output['data']['jadwal_input_data_dasar_awal']                  =$config->jadwal_input_data_dasar_awal;
            $output['data']['jadwal_input_data_dasar_akhir']                  =$config->jadwal_input_data_dasar_akhir;
            $output['data']['tgl_input_rfk_mulai']                  =$config->tgl_input_rfk_mulai;
            $output['data']['tgl_input_rfk_akhir']                  =$config->tgl_input_rfk_akhir;
            $output['data']['tgl_validasi_rfk_mulai']                  =$config->tgl_validasi_rfk_mulai;
            $output['data']['tgl_validasi_rfk_akhir']                  =$config->tgl_validasi_rfk_akhir;
            $output['data']['tgl_input_rfk_kab_kota_awal']                  =$config->tgl_input_rfk_kab_kota_awal;
            $output['data']['tgl_input_rfk_kab_kota_akhir']                  =$config->tgl_input_rfk_kab_kota_akhir;
            $output['data']['penginputan']                  =$config->penginputan;
            $output['data']['penginputan_kab_kota']                  =$config->penginputan_kab_kota;
            $output['data']['jam_mulai_penginputan']                  =$config->jam_mulai_penginputan;
            $output['data']['jam_akhir_penginputan']                  =$config->jam_akhir_penginputan;
            $output['data']['waktu_mulai_penginputan_kab_kota']                  =$config->waktu_mulai_penginputan_kab_kota;
            $output['data']['waktu_akhir_penginputan_kab_kota']                  =$config->waktu_akhir_penginputan_kab_kota;
            $output['data']['status']                  =$config->status;
            

            echo json_encode($output);
        }
    }





    public function data_pj_pelaporan_kab_kota()
    {
        if (!$this->input->is_ajax_request()) {
            show_404();
        } else {            
            $id_kota= $this->session->userdata('id_kota');
                $where          = ['id_kota'=>$id_kota];
            
            $column_order   = ['', 'nama'];
            $column_search  = ['nama','nip'];
            $order          = ['nama' => 'ASC'];
            $list           = $this->datatables_model->get_datatables('v_pj_pelaporan_kab_kota', $column_order, $column_search, $order, $where);
            $data           = [];
            $no             = $_POST['start'];
            $status = ['Tidak Aktif','Aktif'];
            foreach ($list as $lists) {
                $no++;
               
                $row    = [];
                $row[]     = $no;
                $row[]  = $lists->nama_instansi;
                $row[]  =$lists->nama;
                $row[]  =$lists->nip;
                $row[]  =$lists->jabatan;
                $row[]  =$lists->mulai_pj;
                $row[]  =$lists->akhir_pj;
               
                // $row[]  = $status[$lists->is_active];
                $tombol_edit = '<button class="btn btn-outline-info btn-xs"  title="Edit PJ'.$lists->nama.'"  onclick="edit_pj_pelaporan_kab_kota('."'".sbe_crypt($lists->id_pj, 'E')."'".')"><i class="fas fa-edit"></i></button>';
                $tombol_hapus = '<button class="btn btn-outline-danger btn-xs"  title="Edit Instansi'.$lists->nama.'"  onclick="hapus_pj_pelaporan_kab_kota('."'".sbe_crypt($lists->id_pj, 'E')."'".' , '."'".$lists->nama."'".')"><i class="fas fa-trash"></i></button>';
                $row[]  = $tombol_edit.' '.$tombol_hapus;


                $data[] = $row;
            }

            $output = [
                "draw"              => $_POST['draw'],
                "recordsTotal"      => $this->datatables_model->count_all('v_pj_pelaporan_kab_kota', $where),
                "recordsFiltered"   => $this->datatables_model->count_filtered('v_pj_pelaporan_kab_kota', $column_order, $column_search, $order, $where),
                "data"              => $data,
            ];

            echo json_encode($output);
        }
    }

    public function simpan_pj_pelaporan_kab_kota()
    {
        if (!$this->input->is_ajax_request()) {
            show_404();
        } else {
            $output    = [
                'success' => false,
                'messages' => []
            ];
            $data_group     = [];
            $validation     = $this->form_validation;
           
            $validation->set_rules($this->rule_input_pj_pelaporan_kab_kota());
            $validation->set_error_delimiters('<p class="text-danger">', '</p>');
        

            $post               = $this->input->post();
            $id_provinsi = $this->session->userdata('id_provinsi');
            $id_kota = $this->session->userdata('id_kota');
            $id_instansi = $this->input->post('id_instansi');
            $jabatan = $this->input->post('jabatan');
            $nama = $this->input->post('nama');
            $nip = $this->input->post('nip');
            $mulai_pj = $this->input->post('mulai_pj');
            $akhir_pj  = $this->input->post('akhir_pj');
            $data_input = [
                'id_provinsi'=>$id_provinsi,
                'id_kota'=>$id_kota,
                'id_instansi'=>$id_instansi,
                'jabatan'=>$jabatan,
                'nama'=>$nama,
                'nip'=>$nip,
                'mulai_pj'=>$mulai_pj,
                'akhir_pj'=>$akhir_pj
            ];
         




            if ($validation->run($this)) {
                if ($mulai_pj > $akhir_pj) {
                        $output['success']     = false;
                        $output['messages']['mulai_pj'] = '<p class="text-danger">Tanggal mulai tidak boleh lebih besar dari tanggal akhir</p>';
                        $output['messages']['akhir_pj'] = '<p class="text-danger">Tanggal akhir tidak boleh lebih kecil dari tanggal mulai</p>';
                }else{
                   $this->db->insert('pj_pelaporan_kab_kota', $data_input);
                        $output['success']     = true;
                        $output['messages'] = "berhasil di simpan";

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


    public function simpanedit_pj_pelaporan_kab_kota()
    {
        if (!$this->input->is_ajax_request()) {
            show_404();
        } else {
            $output    = [
                'success' => false,
                'messages' => []
            ];
            $data_group     = [];
            $validation     = $this->form_validation;
           
            $validation->set_rules($this->rule_input_pj_pelaporan_kab_kota());
            $validation->set_error_delimiters('<p class="text-danger">', '</p>');
        

            $post               = $this->input->post();
            $id_provinsi = $this->session->userdata('id_provinsi');
            $id_kota = $this->session->userdata('id_kota');
            $id_instansi = $this->input->post('id_instansi');
            $jabatan = $this->input->post('jabatan');
            $nama = $this->input->post('nama');
            $nip = $this->input->post('nip');
            $mulai_pj = $this->input->post('mulai_pj');
            $akhir_pj  = $this->input->post('akhir_pj');
            $id_pj  = sbe_crypt($this->input->post('id_pj'),'D');
            $data_input = [
                'id_provinsi'=>$id_provinsi,
                'id_kota'=>$id_kota,
                'id_instansi'=>$id_instansi,
                'jabatan'=>$jabatan,
                'nama'=>$nama,
                'nip'=>$nip,
                'mulai_pj'=>$mulai_pj,
                'akhir_pj'=>$akhir_pj
            ];
            $where = ['id_pj'=>$id_pj];
         




            if ($validation->run($this)) {
                if ($mulai_pj > $akhir_pj) {
                        $output['success']     = false;
                        $output['messages']['mulai_pj'] = '<p class="text-danger">Tanggal mulai tidak boleh lebih besar dari tanggal akhir</p>';
                        $output['messages']['akhir_pj'] = '<p class="text-danger">Tanggal akhir tidak boleh lebih kecil dari tanggal mulai</p>';
                }else{
                   $this->db->update('pj_pelaporan_kab_kota', $data_input, $where);
                        $output['success']     = true;
                        $output['messages'] = "berhasil di simpan";

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



    public function get_pj_pelaporan_kab_kota()
    {
        if (!$this->input->is_ajax_request()) {
            show_404();
        } else {
             $output = [
                'status'    => false,
                'data'      => []
            ];
            $id_pj = sbe_crypt($this->input->post('id_pj'), 'D');
            $config = $this->db->get_where('pj_pelaporan_kab_kota' , ['id_pj'=>$id_pj])->row();


            $output['data']['id_pj']                  = sbe_crypt($config->id_pj, 'E');
            $output['data']['id_instansi']                  = $config->id_instansi;
            $output['data']['nama']                  = $config->nama;
            $output['data']['nip']                  = $config->nip;
            $output['data']['jabatan']                  = $config->jabatan;
            $output['data']['mulai_pj']                  = $config->mulai_pj;
            $output['data']['akhir_pj']                  = $config->akhir_pj;
          
            

            echo json_encode($output);
        }
    }
    public function hapus_pj_pelaporan_kab_kota()
    {
        if (!$this->input->is_ajax_request()) {
            show_404();
        } else {
             $output = [
                'status'    => false,
                'data'      => []
            ];
            $id_pj = sbe_crypt($this->input->post('id_pj'), 'D');
            $config = $this->db->delete('pj_pelaporan_kab_kota' , ['id_pj'=>$id_pj]);


            

            echo json_encode($output);
        }
    }

     public function list_config_skpd_provinsi()
    {
        if (!$this->input->is_ajax_request()) {
            show_404();
        } else {
             $output = [
                'status'    => false,
                'data'      => []
            ];
            $id_config = $this->input->post('id_config');
            $tahap = [2=>'APBD AWAL','APBD PERGESERAN','APBD PERUBAHAN'];
            $config = $this->db->get_where('master_instansi' , ['id_config'=>$id_config,'is_active'=>1,'kategori'=>'OPD'])->result_array();
            $instansi = [];
            foreach ($config as $k => $v) {
                $data = [
                    'nama_instansi'=>$v['nama_instansi'],
                    'nama_tahap'=>$tahap[$v['kode_tahap']],
                ];
                array_push($instansi, $data);
            }
            $output['data']      =$instansi;
            

            echo json_encode($output);
        }
    }
     public function list_config_skpd_kab_kota()
    {
        if (!$this->input->is_ajax_request()) {
            show_404();
        } else {
             $output = [
                'status'    => false,
                'data'      => []
            ];
            $id_config = $this->input->post('id_config');
            $tahap = [2=>'APBD AWAL','APBD PERGESERAN','APBD PERUBAHAN'];
            $config = $this->db->query("SELECT k.nama_kota, c.tahapan_apbd  
                from config_kab_kota c
                left join kota k on c.id_kota = k.id_kota
                where c.id_config='$id_config'
                ")->result_array();
            $instansi = [];
            foreach ($config as $k => $v) {
                $data = [
                    'nama_kota'=>$v['nama_kota'],
                    'nama_tahap'=>$tahap[$v['tahapan_apbd']],
                ];
                array_push($instansi, $data);
            }
            $output['data']      =$instansi;
            

            echo json_encode($output);
        }
    }



}
