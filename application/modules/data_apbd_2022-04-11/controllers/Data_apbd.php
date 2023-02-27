<?php

/**
 * Author     : Alfikri, M.Kom
 * Created By : Alfikri, M.Kom
 * E-Mail     : alfikri.name@gmail.com
 * No HP      : 081277337405
 * Class      : Paket_pekerjaan.php
 */
defined('BASEPATH') or exit('No direct script access allowed');

class Data_apbd extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->form_validation->CI = &$this;
        $this->load->model([
            'paket_pekerjaan/master_paket_model'      => 'master_paket_model',
            'data_apbd/data_apbd_model'      => 'data_apbd_model',
            'data_apbd/master_data_apbd_model' => 'master_data_apbd_model',
            'datatables_model'                         => 'datatables_model'
        ]);
    }

    public function index()
    {
        $breadcrumbs     = $this->breadcrumbs;
        $master_paket   = $this->master_paket_model;
        $data_apbd_model   = $this->data_apbd_model;

        $breadcrumbs->add('Home', base_url());
        $breadcrumbs->add('Data APBD', base_url($this->router->fetch_class()));
        
        $breadcrumbs->render();

        $tahap = tahapan_apbd();

        if ($tahap == 4) {
            $dropdown_pilih_data_apbd = ['tipe'=>'button', 'caption'=>'Pilih Data APBD', 'fa'=>'fa fa-cog fa-w-16 fa-spin', 'onclick'=>'pilih_dan_alihkan_data_apbd()', 'elemen_tambahan'=>'data-toggle="tooltip" title="Memilih data program kegiatan dan sub kegiatan SKPD"'];
        }else{
            $dropdown_pilih_data_apbd = ['tipe'=>'button', 'caption'=>'Pilih Data APBD', 'fa'=>'fa fa-cog fa-w-16 fa-spin', 'onclick'=>'setting_apbd()', 'elemen_tambahan'=>'data-toggle="tooltip" title="Memilih data program kegiatan dan sub kegiatan SKPD"'];

        }
        // tipe = link / button
        $data['dropdown_option']                      = [
            $dropdown_pilih_data_apbd, 
            ['tipe'=>'onclick', 'caption'=>'Sub Kegiatan APBD SKPD', 'fa'=>'metismenu-icon fas fa-list-ul', 'onclick'=>"sub_kegiatan_instansi_gabungan('all')", 'elemen_tambahan'=>'data-toggle="tooltip" title="Melihat semua data sub kegiatan yang ada pada SKPD"'],
            ['tipe'=>'button', 'caption'=>'Setting Sub Kegiatan Teknis', 'fa'=>'fas fa-bezier-curve', 'onclick'=>'setting_apbd_teknis()', 'elemen_tambahan'=>'data-toggle="tooltip" title="Menambah sub kegiatan unit pelaksana"'],
            ['tipe'=>'button', 'caption'=>'Permasalahan Sub Kegiatan', 'fa'=>'fas fa-exclamation', 'onclick'=>'permasalahan_sub_kegiatan()', 'elemen_tambahan'=>'data-toggle="tooltip" title="Permasalahan Sub Kegiatan"'],
            ['tipe'=>'link', 'caption'=>'Program Unggulan', 'fa'=>'fa fa-thumbs-up', 'onclick'=>'data_apbd/progul', 'elemen_tambahan'=>'data-toggle="tooltip" title="Data Program Unggulan berdasarkan sub kegiatan yang dimiliki SKPD"'],
        ];
        $data['title']                      = "Data APBD";
        $data['input_by']                      = "";

        $data['kode_tahap']                = tahapan_apbd();
        $data['tahun']                = tahun_anggaran();
        $data['icon']                       = "metismenu-icon fa fa-list-ul";
        $data['description']                = "Menampilkan Data APBD";
        $data['breadcrumbs']                = '';//$breadcrumbs->render();
        $data['tot_program']                = $data_apbd_model->total_data_per_instansi(id_instansi())['program'];
        $data['tot_kegiatan']               = $data_apbd_model->total_data_per_instansi(id_instansi())['kegiatan'];
        $data['tot_subkeg']                 = $data_apbd_model->total_data_per_instansi(id_instansi())['subkeg'];
      
        $page                               = 'data_apbd/data_apbd/index';
        $data['link']                       = $this->router->fetch_method();
        $data['fetch_method']                       = $this->router->fetch_method();
        $data['menu']                       = $this->load->view('layout/menu', $data, true);
        $data['extra_css']                  = $this->load->view('data_apbd/data_apbd/css', $data, true);
        $data['extra_js']                   = $this->load->view('data_apbd/data_apbd/js', $data, true);
        $data['modal']                      = $this->load->view('data_apbd/data_apbd/modal', $data, true);
        $this->template->load('backend_template', $page, $data);
    }
    public function setting()
    {
        $breadcrumbs     = $this->breadcrumbs;
        $master_paket   = $this->master_paket_model;
        $data_apbd_model   = $this->data_apbd_model;

        $breadcrumbs->add('Home', base_url());
        $breadcrumbs->add('Data APBD', base_url($this->router->fetch_class()));
        $breadcrumbs->render();
        
        $data['dropdown_option']                      = [
            
            ['tipe'=>'link', 'caption'=>'Usulkan Data APBD', 'fa'=>'fa fa-book', 'onclick'=>'data_apbd/usulkan_data_apbd', 'elemen_tambahan'=>'data-toggle="tooltip" title="Usulkan Data APBD"'],
             ['tipe'=>'link', 'caption'=>'Kembali', 'fa'=>'fa fa-arrow-left', 'onclick'=>'data_apbd/', 'elemen_tambahan'=>'data-toggle="tooltip" title="Kembali"'],
        ];

        $data['input_by']                      = "";
        $tahap =tahapan_apbd();
        $tahun =tahun_anggaran();
        $id_instansi =id_instansi();
        $data['kode_tahap']                = $tahap;
        $data['tahun']                = tahun_anggaran();
        $data['title']                      = "Pilih Data APBD";
        $data['icon']                       = "metismenu-icon fa fa-list-ul";
        $data['description']                = "Menampilkan Data APBD untuk dipilih oleh Operator";
        $data['breadcrumbs']                = '';
        $ski_aktif = $this->db->query("SELECT * from sub_kegiatan_instansi where id_instansi='$id_instansi' and kode_tahap='$tahap' and tahun='$tahun'");
        $data['total_data_apbd']                = $ski_aktif->num_rows();
        $data['tot_program']                = $data_apbd_model->total()['program'];
        $data['tot_kegiatan']               = $data_apbd_model->total()['kegiatan'];
        $data['tot_subkeg']                 = $data_apbd_model->total()['subkeg'];
        $data['tot_bu']                     = $data_apbd_model->total()['bu'];
        $data['config']                     = $this->db->get_where('config', ['id_config !='=>id_config()]);
        $page                               = 'data_apbd/data_apbd/setting';
        $data['link']                       = $this->router->fetch_method();
        $data['fetch_method']                       = $this->router->fetch_method();
        $data['menu']                       = $this->load->view('layout/menu', $data, true);
        $data['extra_css']                  = $this->load->view('data_apbd/data_apbd/css', $data, true);
        $data['extra_js']                   = $this->load->view('data_apbd/data_apbd/js', $data, true);
        $data['modal']                      = $this->load->view('data_apbd/data_apbd/modal', $data, true);
        $this->template->load('backend_template', $page, $data);
    }
    public function usulkan_data_apbd()
    {
        $breadcrumbs     = $this->breadcrumbs;
        $master_paket   = $this->master_paket_model;
        $data_apbd_model   = $this->data_apbd_model;

        $breadcrumbs->add('Home', base_url());
        $breadcrumbs->add('Data APBD', base_url($this->router->fetch_class()));
        
        $breadcrumbs->render();
        $data['input_by']                      = "";

        $data['kode_tahap']                = tahapan_apbd();
        $data['tahun']                = tahun_anggaran();

        $data['title']                      = "Data APBD";
        $data['icon']                       = "metismenu-icon fa fa-list-ul";
        $data['description']                = "Menampilkan Data APBD";
        $data['breadcrumbs']                = $breadcrumbs->render();
        $data['tot_program']                = $data_apbd_model->total()['program'];
        $data['tot_kegiatan']               = $data_apbd_model->total()['kegiatan'];
        $data['tot_subkeg']                 = $data_apbd_model->total()['subkeg'];
        $data['tot_bu']                     = $data_apbd_model->total()['bu'];
        $page                               = 'data_apbd/data_apbd/usulkan_data_apbd';
        $data['link']                       = $this->router->fetch_method();
        $data['fetch_method']                       = $this->router->fetch_method();
        $data['menu']                       = $this->load->view('layout/menu', $data, true);
        $data['extra_css']                  = $this->load->view('data_apbd/data_apbd/css', $data, true);
        $data['extra_js']                   = $this->load->view('data_apbd/data_apbd/js', $data, true);
        $data['modal']                      = $this->load->view('data_apbd/data_apbd/modal', $data, true);


       
        $this->template->load('backend_template', $page, $data);
    }


    public function sub_kegiatan($input_by)
    {
        $breadcrumbs     = $this->breadcrumbs;
        $master_paket   = $this->master_paket_model;
        $data_apbd_model   = $this->data_apbd_model;

        $breadcrumbs->add('Home', base_url());
        $breadcrumbs->add('Data APBD', base_url($this->router->fetch_class()));
        
        $breadcrumbs->render();
        $data['dropdown_option']                      = [
            ['tipe'=>'link', 'caption'=>'Kembali', 'fa'=>'fa fa-arrow-left', 'onclick'=>'data_apbd', 'elemen_tambahan'=>'data-toggle="tooltip" title="Data Program Unggulan berdasarkan sub kegiatan yang dimiliki SKPD"'],
        ];

        $data['input_by']                      = $input_by;

        $data['kode_tahap']                = tahapan_apbd();
        $data['tahun']                = tahun_anggaran();
        $data['title']                      = "Data APBD";
        $data['icon']                       = "metismenu-icon fa fa-list-ul";
        $data['description']                = "Menampilkan Data APBD";
        $data['breadcrumbs']                = '';
        $data['tot_program']                = $data_apbd_model->total_data_per_instansi(id_instansi())['program'];
        $data['tot_kegiatan']               = $data_apbd_model->total_data_per_instansi(id_instansi())['kegiatan'];
        $data['tot_subkeg']                 = $data_apbd_model->total_data_per_instansi(id_instansi())['subkeg'];
      
        $page                               = 'data_apbd/data_apbd/sub_kegiatan';
        $data['link']                       = $this->router->fetch_method();
        $data['fetch_method']                       = $this->router->fetch_method();
        $data['menu']                       = $this->load->view('layout/menu', $data, true);
        $data['extra_css']                  = $this->load->view('data_apbd/data_apbd/css', $data, true);
        $data['extra_js']                   = $this->load->view('data_apbd/data_apbd/js', $data, true);
        $data['modal']                      = $this->load->view('data_apbd/data_apbd/modal', $data, true);
        $this->template->load('backend_template', $page, $data);
    }
    public function pengalihan_tahapan_apbd_ski()
    {
        $breadcrumbs     = $this->breadcrumbs;
        $master_paket   = $this->master_paket_model;
        $data_apbd_model   = $this->data_apbd_model;

        $breadcrumbs->add('Home', base_url());
        $breadcrumbs->add('Data APBD', base_url($this->router->fetch_class()));
        
        $breadcrumbs->render();
        $data['dropdown_option']                      = [
            ['tipe'=>'link', 'caption'=>'Kembali', 'fa'=>'fa fa-arrow-left', 'onclick'=>'data_apbd', 'elemen_tambahan'=>'data-toggle="tooltip" title="Data Program Unggulan berdasarkan sub kegiatan yang dimiliki SKPD"'],
        ];

        $data['input_by']                      = "pengalihan_tahapan_apbd_ski";
        $data['fetch_method_pemilihan_data_apbd']                      = $this->router->fetch_method();

        $data['kode_tahap']                = tahapan_apbd();
        $data['tahun']                = tahun_anggaran();
        $data['title']                      = "Data APBD";
        $data['icon']                       = "metismenu-icon fa fa-list-ul";
        $data['description']                = "Menampilkan Data APBD";
        $data['breadcrumbs']                = '';
        $data['tot_program']                = $data_apbd_model->total_data_per_instansi(id_instansi())['program'];
        $data['tot_kegiatan']               = $data_apbd_model->total_data_per_instansi(id_instansi())['kegiatan'];
        $data['tot_subkeg']                 = $data_apbd_model->total_data_per_instansi(id_instansi())['subkeg'];
      
        $page                               = 'data_apbd/data_apbd/pengalihan_sub_kegiatan_apbd_awal_ke_perubahan';
        $data['link']                       = $this->router->fetch_method();
        $data['fetch_method']                       = $this->router->fetch_method();
        $data['menu']                       = $this->load->view('layout/menu', $data, true);
        $data['extra_css']                  = $this->load->view('data_apbd/data_apbd/css', $data, true);
        $data['extra_js']                   = $this->load->view('data_apbd/data_apbd/js', $data, true);
        $data['modal']                      = $this->load->view('data_apbd/data_apbd/modal', $data, true);
        $this->template->load('backend_template', $page, $data);
    }
    public function lihat_data_apbd($tahun,$tahap)
    {
        $breadcrumbs     = $this->breadcrumbs;
        $master_paket   = $this->master_paket_model;
        $data_apbd_model   = $this->data_apbd_model;

        $breadcrumbs->add('Home', base_url());
        $breadcrumbs->add('Data APBD', base_url($this->router->fetch_class()));
        $breadcrumbs->add(' <a class="btn btn-info btn-xs" href="'.base_url('data_apbd/setting').'" data-toggle="tooltip" title="Kembali"><i class="fa fa-arrow-left"></i> Kembali</a>', base_url('data_apbd/setting'));
        
        $breadcrumbs->render();
        $id_instansi = id_instansi();
        $data['input_by']                      = "all";

        $data['kode_tahap']                = tahapan_apbd();
        $data['tahun']                = tahun_anggaran();
        $data['title']                      = "Data APBD";
        $data['icon']                       = "metismenu-icon fa fa-list-ul";
        $data['description']                = "Menampilkan Data ".pilihan_nama_tahapan($tahap)." pada Tahun ".$tahun;
        $data['breadcrumbs']                = $breadcrumbs->render();
        $statistika                = $data_apbd_model->statistika($id_instansi, $tahun, $tahap);
        $data['nama_tahap']                = pilihan_nama_tahapan($tahap);
        $data['kode_tahap']                = $tahap;
        $data['tahun']                = $tahun;
        $data['tot_program']                = $statistika['program'];
        $data['tot_kegiatan']               = $statistika['kegiatan'];
        $data['tot_subkeg']                 = $statistika['subkeg'];
      
        $page                               = 'data_apbd/data_apbd/lihat_data_apbd_copy';
        $data['link']                       = $this->router->fetch_method();
        $data['fetch_method']                       = $this->router->fetch_method();
        $data['menu']                       = $this->load->view('layout/menu', $data, true);
        $data['extra_css']                  = $this->load->view('data_apbd/data_apbd/css', $data, true);
        $data['extra_js']                   = $this->load->view('data_apbd/data_apbd/js', $data, true);
        $data['modal']                      = $this->load->view('data_apbd/data_apbd/modal', $data, true);
        $this->template->load('backend_template', $page, $data);
    }
    public function permasalahan()
    {
        $breadcrumbs     = $this->breadcrumbs;
        $master_paket   = $this->master_paket_model;
        $data_apbd_model   = $this->data_apbd_model;

        $breadcrumbs->add('Home', base_url());
        $breadcrumbs->add('Data APBD', base_url($this->router->fetch_class()));
        
        $breadcrumbs->render();

        $data['input_by']                      = "all";
        $data['kode_tahap']                = tahapan_apbd();
        $data['tahun']                = tahun_anggaran();
        $data['title']                      = "Data APBD";
        $data['icon']                       = "metismenu-icon fa fa-list-ul";
        $data['description']                = "Menampilkan Data APBD";
        $data['breadcrumbs']                = $breadcrumbs->render();
    
        $page                               = 'data_apbd/data_apbd/permasalahan';
        $data['link']                       = $this->router->fetch_method();
        $data['fetch_method']                       = $this->router->fetch_method();
        $data['menu']                       = $this->load->view('layout/menu', $data, true);
        $data['extra_css']                  = $this->load->view('data_apbd/data_apbd/css', $data, true);
        $data['extra_js']                   = $this->load->view('data_apbd/data_apbd/js', $data, true);
        $data['modal']                      = $this->load->view('data_apbd/data_apbd/modal', $data, true);
        $this->template->load('backend_template', $page, $data);
    }


    public function setting_apbd_teknis()
    {
        $breadcrumbs     = $this->breadcrumbs;
        $master_paket   = $this->master_paket_model;
        $data_apbd_model   = $this->data_apbd_model;
        $id_instansi       = id_instansi();
        $breadcrumbs->add('Home', base_url());
        $breadcrumbs->add('Data APBD', base_url($this->router->fetch_class()));
        
        $breadcrumbs->render();

        
        $data['input_by']                      = "";

        $data['kode_tahap']                = tahapan_apbd();
        $data['tahun']                = tahun_anggaran();
        $data['title']                      = "Data APBD";
        $data['icon']                       = "metismenu-icon fa fa-list-ul";
        $data['description']                = "Menampilkan Data APBD";
        $data['breadcrumbs']                = $breadcrumbs->render();
        $data['tot_program']                = $data_apbd_model->total_data_per_instansi(id_instansi())['program'];
        $data['tot_kegiatan']               = $data_apbd_model->total_data_per_instansi(id_instansi())['kegiatan'];
        $data['tot_subkeg']                 = $this->db->query("SELECT * from sub_kegiatan_instansi where id_instansi='$id_instansi' and kategori='Sub Kegiatan SKPD'")->num_rows();
      
        $page                               = 'data_apbd/data_apbd/setting_apbd_teknis';
        $data['link']                       = $this->router->fetch_method();
        $data['fetch_method']                       = $this->router->fetch_method();
        $data['menu']                       = $this->load->view('layout/menu', $data, true);
        $data['extra_css']                  = $this->load->view('data_apbd/data_apbd/css', $data, true);
        $data['extra_js']                   = $this->load->view('data_apbd/data_apbd/js', $data, true);
        $data['modal']                      = $this->load->view('data_apbd/data_apbd/modal', $data, true);
        $this->template->load('backend_template', $page, $data);
    }


public function sync_eplanning()
    {
        if (!$this->input->is_ajax_request()) {
            show_404();
        } else {
            $result     = [
                'success'   => false,
                'messages'  => ''
            ];
               
            $linktoken = "http://eplanning.sumbarprov.go.id/sin/sinkron/generate_token/pembangunan/pembangunankoneksi";
            $token       = file_get_contents($linktoken);

            $link = "http://eplanning.sumbarprov.go.id/sin/sinkron/get_subkeg_instansi/".$token."/".id_instansi();

            $data       = file_get_contents($link);

            $konversi   = json_decode($data, true);

            foreach ($konversi as $key => $value) {
                
                    $table      = "sub_kegiatan_instansi";
                    $primary    = [
                        'kode_sub_kegiatan'   => trim($value['kode_sub'])
                    ];
                    $insert     = [
                        'kode_sub_kegiatan'   => trim($value['kode_sub']),
                        'kode_kegiatan'  => trim($value['kode_kegiatan']),
                        'kode_program'     => trim($value['kode_program']),
                        'kode_bidang_urusan'  => trim($value['kode_bidang']),
                        'id_instansi'  => trim($value['id_instansi']),
                        'kategori'  => 'Sub Kegiatan SKPD',
                        
                        'tahun'  => tahun_anggaran(),
                        'kode_tahap'  => tahapan_apbd(),
                        'input_by'         => "Web Service",
                       
                        'created_on'    => timestamp(),
                        
                        'created_by'    => id_user()
                    ];
                    $update     = [
                        'kode_kegiatan'  => trim($value['kode_bidang']),
                        'kode_program'     => trim($value['kode_program']),
                        'kode_bidang_urusan'  => trim($value['kode_bidang']),
                        'updated_on'    => timestamp(),
                        'updated_by'    => id_user()
                    ];
                
                     

                $cek = $this->db->get_where($table, $primary)->num_rows();

                if ($cek == 0) {
                    $this->db->insert($table, $insert);
                    $output['status']   = true;
                    $output['messages'] = '{$cek} Data berhasil Disimpan';
                } else {
                    // $this->db->update($table, $update, $primary);
                    // $output['status']   = true;
                    // $output['messages'] = '{$cek} Data berhasil update';
                    
                }
            }

            echo json_encode($cek);
        }
    }



    public function dt_program_apbd()
    {
        if(!$this->input->is_ajax_request())
        {
            show_404();
        }else{
            $tahun = tahun_anggaran();
            $tahap = tahapan_apbd();
            $id_instansi = id_instansi();

            if ($tahap==4) {
                $tabel = 'v_program_apbd_perubahan';
                $where          = ['id_instansi' => $id_instansi,'tahun'=>$tahun];
            }else{
                $tabel = 'v_program_apbd_awal';
                $where          = ['id_instansi' => $id_instansi,'tahun'=>$tahun, 'kode_tahap'=>$tahap];
            }
            $column_order   = ['kode_rekening_program','nama_program','belanja_pegawai','belanja_barang_jasa','belanja_modal','pagu'];
            $column_search  = ['kode_rekening_program','nama_program'];
            $order          = ['kode_rekening_program' => 'ASC'];
            $list           = $this->datatables_model->get_datatables($tabel,$column_order,$column_search,$order,$where);
            $data           = [];
            $no             = $_POST['start'];
            $nomor = 1;
            foreach ($list as $lists)
            {
                $kode_program =$lists->kode_rekening_program;
                $row    = [];
                $row[]  = $nomor++;
                $row[]  = $lists->nama_bidang_urusan;
                
                $row[]  = $lists->kode_rekening_program;
                $row[]  = $lists->nama_program ;
                if ($tahap==4) {
                    $q_pagu = $this->db->query("SELECT sum( bo_bp + bo_bbj + bo_bs + bo_bh + bm_bmt + bm_bmpm + bm_bmgb + bm_bmjji + bm_bmatl + btt + bt_bbh + bt_bbk ) as total_anggaran FROM anggaran_sub_kegiatan where tahun = '$tahun' and id_instansi='$id_instansi' and kode_program='$kode_program' and kode_sub_kegiatan in (SELECT kode_sub_kegiatan from sub_kegiatan_instansi where tahun='$tahun' and kode_program='$kode_program' and id_instansi='$id_instansi' and status=1)
                        and status =1")->row_array();
                    $pagu = $q_pagu['total_anggaran'] =='' ? 0 : $q_pagu['total_anggaran'];
                }else{
                    $pagu = $lists->pagu =='' ? 0 : $lists->pagu;
                }
                $row[]  = '<span style="float:right">'.number_format($pagu,0,'','.').'</span>';
                $row[]     = ' <button class="btn btn-info btn-xs" id="show-kegiatan" kode_program="'.$lists->kode_rekening_program.'" title="Lihat kegiatan dari program '.$lists->nama_program.'"><i class="fa fa-plus"></i></button>';
                // $row[]     = '<button class="btn btn-info btn-sm" id="show-pptk" id-user="' . $var . '" kode_program="'.$lists->kode_rekening_program.'"><i class="fa fa-plus"></i></button>';

                $data[] = $row;
            }

            $output = [
                        "draw"              => $_POST['draw'],
                        "recordsTotal"      => $this->datatables_model->count_all($tabel,$where),
                        "recordsFiltered"   => $this->datatables_model->count_filtered($tabel,$column_order,$column_search,$order,$where),
                        "data"              => $data,
                      ];

            echo json_encode($output);
        }
    }



    public function dt_program_all()
    {
        if(!$this->input->is_ajax_request())
        {
            show_404();
        }else{
            $where          = [];
            $column_order   = ['kode_program','nama_program'];
            $column_search  = ['kode_program','nama_program'];
            $order          = ['kode_program' => 'ASC'];
            $list           = $this->datatables_model->get_datatables('v_program_all',$column_order,$column_search,$order,$where);
            $data           = [];
            $no             = $_POST['start'];
            $nomor = 1;
          
            foreach ($list as $lists)
            {
                $row    = [];
                $row[]  = $nomor++;
               
                $row[]  = $lists->nama_bidang_urusan;
                $row[]  = $lists->kode_program;
                $row[]  = $lists->nama_program;
                $row[]     =  ' <button class="btn btn-info btn-xs" id="show-kegiatan-all" kode_program="'.$lists->kode_program.'" title="Lihat kegiatan dari program '.$lists->nama_program.'"><i class="fa fa-plus"></i></button>';

                $data[] = $row;
            }

            $output = [
                        "draw"              => $_POST['draw'],
                        "recordsTotal"      => $this->datatables_model->count_all('v_program_all',$where),
                        "recordsFiltered"   => $this->datatables_model->count_filtered('v_program_all',$column_order,$column_search,$order,$where),
                        "data"              => $data,
                      ];

            echo json_encode($output);
        }
    }



  
    public function kegiatan_apbd_instansi()
    {
        if (!$this->input->is_ajax_request()) {
            show_404();
        } else {            
            $tahun = tahun_anggaran();
            $tahap = tahapan_apbd();
            $id_instansi = id_instansi();
            $kode_program  = $this->input->post('kode_program');
            if ($tahap==4) {
                $where          = ['id_instansi' => $id_instansi, 'kode_rekening_program' => $kode_program,'tahun'=>$tahun];
                $tabel = 'v_kegiatan_apbd_perubahan';
            }else{
                $where          = ['id_instansi' => $id_instansi, 'kode_rekening_program' => $kode_program,'tahun'=>$tahun, 'kode_tahap'=>$tahap];
                $tabel = 'v_kegiatan_apbd_awal';
            }
            $column_order   = ['', 'nama_kegiatan'];
            $column_search  = ['nama_kegiatan'];
            $order          = ['nama_kegiatan' => 'ASC'];
            $list           = $this->datatables_model->get_datatables($tabel, $column_order, $column_search, $order, $where);
            $data           = [];
            $no             = $_POST['start'];
            foreach ($list as $lists) {
                $no++;
                $kode_kegiatan = $lists->kode_rekening_kegiatan;
                $row    = [];
                $row[]     = $no;
                $row[]  = $kode_kegiatan;
                $row[]  = $lists->nama_kegiatan;
                if ($tahap==4) {
                    $q_pagu = $this->db->query("SELECT sum( bo_bp + bo_bbj + bo_bs + bo_bh + bm_bmt + bm_bmpm + bm_bmgb + bm_bmjji + bm_bmatl + btt + bt_bbh + bt_bbk ) as total_anggaran FROM anggaran_sub_kegiatan where tahun='$tahun' and  id_instansi='$id_instansi' and kode_kegiatan='$kode_kegiatan' and kode_sub_kegiatan in (SELECT kode_sub_kegiatan from sub_kegiatan_instansi where tahun='$tahun' and kode_kegiatan='$kode_kegiatan' and id_instansi='$id_instansi' and status=1)
                        and status=1")->row_array();
                    $pagu = $q_pagu['total_anggaran'] =='' ? 0 : $q_pagu['total_anggaran'];
                }else{
                    $pagu = $lists->pagu =='' ? 0 : $lists->pagu;
                }

                $row[]  =  '<span style="float:right">'.number_format($pagu,0,'','.').'</span>';
                $row[]     = '<button class="btn btn-info btn-xs" id="show-sub-kegiatan" status="collapse" kode_program="'.$lists->kode_rekening_program.'" kode_kegiatan="'.$lists->kode_rekening_kegiatan.'"><i class="fa fa-plus"></i></button>';
               
                $data[] = $row;
            }

            $output = [
                "draw"              => $_POST['draw'],
                "recordsTotal"      => $this->datatables_model->count_all($tabel, $where),
                "recordsFiltered"   => $this->datatables_model->count_filtered($tabel, $column_order, $column_search, $order, $where),
                "data"              => $data,
            ];

            echo json_encode($output);
        }
    }



  
    public function kegiatan_apbd_all()
    {
        if (!$this->input->is_ajax_request()) {
            show_404();
        } else {            
            
            $kode_program  = $this->input->post('kode_program');
            $where          = ['kode_program' => $kode_program, 'status'=>1];
            $column_order   = ['', 'nama_kegiatan'];
            $column_search  = ['nama_kegiatan', 'kode_kegiatan'];
            $order          = ['nama_kegiatan' => 'ASC'];
            $list           = $this->datatables_model->get_datatables('master_kegiatan', $column_order, $column_search, $order, $where);
            $data           = [];
            $no             = $_POST['start'];
            foreach ($list as $lists) {
                $no++;
                $row    = [];
                $row[]     = $no;
                $row[]  = $lists->kode_kegiatan;
                $row[]  = $lists->nama_kegiatan;
                $row[]     =  '<button class="btn btn-info btn-xs" id="show-sub-kegiatan-all" status="collapse" kode_program="'.$lists->kode_program.'" kode_kegiatan="'.$lists->kode_kegiatan.'"><i class="fa fa-plus"></i></button>';
               
                $data[] = $row;
            }

            $output = [
                "draw"              => $_POST['draw'],
                "recordsTotal"      => $this->datatables_model->count_all('master_kegiatan', $where),
                "recordsFiltered"   => $this->datatables_model->count_filtered('master_kegiatan', $column_order, $column_search, $order, $where),
                "data"              => $data,
            ];

            echo json_encode($output);
        }
    }




    
    public function update_target_fisik($kode_rekening_sub_kegiatan)
    {
        $id_target_apbd = sbe_crypt($this->input->post('pk'), 'D');
        $target_fisik   = $this->input->post('value');
        $target         = $this->db->get_where('target_apbd', ['id_target_apbd' => $id_target_apbd])->row_array();
        $target_lalu    = $this->db->get_where('target_apbd', ['kode_rekening_sub_kegiatan' => $kode_rekening_sub_kegiatan, 'bulan' => $target['bulan'] - 1, 'kode_tahap' => tahapan_apbd(),'tahun' => tahun_anggaran(), 'id_instansi'=>id_instansi()])->row_array();

        if ($target['bulan'] == 1) {
            $nilai = $target_fisik;
        } elseif ($target['bulan'] > 1 && $target['bulan'] <= 12) {
            $nilai = $target_fisik + $target_lalu['target_fisik'];
        }

        if ($nilai >= 100) {
            for ($i = $target['bulan']; $i <= 12; $i++) {
                if ($i==$target['bulan']) {
                    $target_fisik_otomatis = 100 - $target_lalu['target_fisik'];
                    $this->db->update('target_apbd', ['target_fisik' => 100,'target_fisik_bulanan' => $target_fisik_otomatis], ['kode_rekening_sub_kegiatan' => $kode_rekening_sub_kegiatan, 'bulan' => $i,  'id_instansi'=>id_instansi()]);
                }else{
                    $this->db->update('target_apbd', ['target_fisik' => 100, 'target_fisik_bulanan' => 0], ['kode_rekening_sub_kegiatan' => $kode_rekening_sub_kegiatan, 'bulan' => $i,  'id_instansi'=>id_instansi()]);
                }
            }
        } else {
            $this->db->update('target_apbd', ['target_fisik' => $nilai,'target_fisik_bulanan' => $target_fisik], ['id_target_apbd' => $id_target_apbd]);
        }
    }


    
    public function update_target_keuangan($kode_rekening_sub_kegiatan)
    {
        $id_target_apbd = sbe_crypt($this->input->post('pk'), 'D');
        $t_keu   = $this->input->post('value');
        $target_keu      =str_replace(".", "", $t_keu);
        $target         = $this->db->get_where('target_apbd', ['id_target_apbd' => $id_target_apbd])->row_array();
        $target_lalu    = $this->db->get_where('target_apbd', ['kode_rekening_sub_kegiatan' => $kode_rekening_sub_kegiatan, 'bulan' => $target['bulan'] - 1, 'kode_tahap' => tahapan_apbd() ,'tahun' => tahun_anggaran(), 'id_instansi'=>id_instansi()])->row_array();
        // qski = query sub kegiatan instansi
        $tahap = tahapan_apbd();
        $tahun = tahun_anggaran();
        $id_instansi = id_instansi();
        $qski = $this->db->query("SELECT * from v_sub_kegiatan_apbd where kode_tahap='$tahap' and id_instansi='$id_instansi' and kode_rekening_sub_kegiatan='$kode_rekening_sub_kegiatan' and tahun='$tahun'")->row();
        $pagu = $qski->pagu =="" ? 0 : $qski->pagu;
        

        if ($target['bulan'] == 1) {
            $nilai = $target_keu;
        } elseif ($target['bulan'] > 1 && $target['bulan'] <= 12) {
            $nilai = $target_keu + $target_lalu['target_keuangan'];
        }

        
        if ($nilai >= $pagu) {
            for ($i = $target['bulan']; $i <= 12; $i++) {
                 if ($i==$target['bulan']) {
                    $target_keuangan_otomatis = $pagu - $target_lalu['target_keuangan'];
                    $persen_keuangan = ($target_keuangan_otomatis / $pagu ) * 100 ; 
                    $persen_keuangan_akumulasi = ($nilai / $pagu ) * 100 ; 
                    $this->db->update('target_apbd', ['target_keuangan' => $pagu,'target_keuangan_bulanan' => $target_keuangan_otomatis, 'persen_target_keuangan_bulanan' => $persen_keuangan, 'persen_target_keuangan' => 100], ['kode_rekening_sub_kegiatan' => $kode_rekening_sub_kegiatan, 'bulan' => $i,  'id_instansi'=>id_instansi()]);
                }else{
                    $persen_keuangan = ($target_keu / $pagu ) * 100 ; 
                    $persen_keuangan_akumulasi = ($nilai / $pagu ) * 100 ; 
                    $this->db->update('target_apbd', ['target_keuangan' => $pagu, 'target_keuangan_bulanan' => 0, 'persen_target_keuangan_bulanan' => 0, 'persen_target_keuangan' => 100], ['kode_rekening_sub_kegiatan' => $kode_rekening_sub_kegiatan, 'bulan' => $i,  'id_instansi'=>id_instansi()]);
                }

            }
        } else {
            $persen_keuangan = ($target_keu / $pagu ) * 100 ; 
            $persen_keuangan_akumulasi = ($nilai / $pagu ) * 100 ; 
            $this->db->update('target_apbd', ['target_keuangan' => $nilai,'persen_target_keuangan_bulanan' => $persen_keuangan,'persen_target_keuangan' => $persen_keuangan_akumulasi, 'target_keuangan_bulanan' => $target_keu], ['id_target_apbd' => $id_target_apbd ,'id_instansi'=>id_instansi()]);
        }
    }

    public function sub_kegiatan_apbd_instansi()
    {
        if (!$this->input->is_ajax_request()) {
            show_404();
        } else {            
            $tahun = tahun_anggaran();
            $tahap = tahapan_apbd();
            $kode_kegiatan  = $this->input->post('kode_kegiatan');
            if ($tahap==4) {
                $where          = ['id_instansi' => id_instansi(), 'kode_rekening_kegiatan' => $kode_kegiatan, 'status'=>1,'tahun'=>$tahun];
                # code...
            }else{
                $where          = ['id_instansi' => id_instansi(), 'kode_rekening_kegiatan' => $kode_kegiatan, 'kode_tahap'=>$tahap,'tahun'=>$tahun];

            }
            $column_order   = ['', 'nama_sub_kegiatan'];
            $column_search  = ['nama_sub_kegiatan'];
            $order          = ['nama_sub_kegiatan' => 'ASC'];
            $list           = $this->datatables_model->get_datatables('v_sub_kegiatan_apbd', $column_order, $column_search, $order, $where);
            $data           = [];
            $no             = $_POST['start'];
            foreach ($list as $lists) {
                $pecah = explode('.', $lists->kode_rekening_sub_kegiatan);
                $no++;
                $row    = [];
                $row[]     = $no;
                $row[]  = $pecah[0].'.'.$pecah[1].'.'.$pecah[2].'.'.$pecah[3].'.'.$pecah[4].'.'.$pecah[5];
                $row[]  = $lists->nama_sub_kegiatan;
                 $pagu   = $lists->pagu =='' ? 0 : $lists->pagu;
                $row[]  =  '<span style="float:right">'.number_format($pagu,0,'','.').'</span>';
                $row[]  = pilihan_nama_tahapan($lists->kode_tahap);
                $onclick = "hapus_sub_kegiatan_instansi('".$lists->kode_rekening_sub_kegiatan."','".$lists->kode_rekening_kegiatan."', '".$lists->kode_rekening_program."', '".$lists->kode_tahap."', '".$lists->tahun."','instansi')";
                $onclick2 = "input_anggaran('".$lists->kode_rekening_sub_kegiatan."','".$lists->kode_rekening_kegiatan."', '".$lists->kode_rekening_program."','".tahapan_apbd()."','".tahun_anggaran()."','".$lists->kode_bidang_urusan."','instansi')";

               $onclick3 = "get_target('".$lists->kode_rekening_sub_kegiatan."','".$lists->kode_rekening_kegiatan."', '".$lists->kode_rekening_program."','".tahapan_apbd()."','".tahun_anggaran()."','".$lists->kode_bidang_urusan."','".$lists->pagu."')";

             $onclick4 = "get_sumber_dana('".$lists->kode_rekening_sub_kegiatan."','".$lists->kode_rekening_kegiatan."', '".$lists->kode_rekening_program."','".tahapan_apbd()."','".tahun_anggaran()."','".$lists->kode_bidang_urusan."','".$lists->pagu."')";
             
               if ($pagu==0) {
                   $tomboltarget = '<button class="btn btn-outline-danger btn-xs"  title="Input target sub   kegiatan '.$lists->nama_sub_kegiatan.'"  onclick="target_forbidden()"><i class="fas fa-crosshairs"></i></button> ';
                   $tombolsumber_dana = '<button class="btn btn-outline-danger btn-xs"  title="Input target sub   kegiatan '.$lists->nama_sub_kegiatan.'"  onclick="sumber_dana_forbidden()"><i class="fas fa-money-bill"></i></button> ';
               }else{
                   $tomboltarget = '<button class="btn btn-outline-info btn-xs"  title="Input target sub   kegiatan '.$lists->nama_sub_kegiatan.'"  onclick="'.$onclick3.'"><i class="fas fa-crosshairs"></i></button> ';
                  $tombolsumber_dana = '<button class="btn btn-outline-info btn-xs"  title="Input Sumberdana sub   kegiatan '.$lists->nama_sub_kegiatan.'"  onclick="'.$onclick4.'"><i class="fas fa-money-bill"></i></button> ';

               }

                    if (jadwal_input_data_dasar()['aktif']==0) {
                        $alert_kunci_input = "Swal.fire('Terkunci','".jadwal_input_data_dasar()['pesan']."','error')";
                        $row[]     =  '<button class="btn btn-outline-danger btn-sm" onclick="'.$alert_kunci_input.'">'.jadwal_input_data_dasar()['pesan_action'].'</button> ' ;
                    }else{

                        $row[]     = $tombolsumber_dana.$tomboltarget .

                        '<button class="btn btn-info btn-xs"  title="Input anggaran belanja sub  kegiatan '.$lists->nama_sub_kegiatan.'"  onclick="'.$onclick2.'"><i class="fas fa-money-bill"></i></button> '.

                         // '<button class="btn btn-info btn-xs"  title="Input indikator sub kegiatan '.$lists->nama_sub_kegiatan.'"><i class="metismenu-icon fas fa-file-signature"></i></button> ' .
                         '<button class="btn btn-danger btn-xs" onclick="'.$onclick.'"><i class="fa fa-trash"></i></button>' . '';
                    }


           
               
                $data[] = $row;
            }

            $output = [
                "draw"              => $_POST['draw'],
                "recordsTotal"      => $this->datatables_model->count_all('v_sub_kegiatan_apbd', $where),
                "recordsFiltered"   => $this->datatables_model->count_filtered('v_sub_kegiatan_apbd', $column_order, $column_search, $order, $where),
                "data"              => $data,
            ];

            echo json_encode($output);
        }
    }


    public function sub_kegiatan_apbd_instansi_gabungan($input_by)
    {
        if (!$this->input->is_ajax_request()) {
            show_404();
        } else {            



            $tahap = $this->input->post('tahap');
            $tahun = $this->input->post('tahun');
            $fetch_method = $this->input->post('fetch_method');
            $id_instansi = id_instansi();
            $kode_kegiatan  = $this->input->post('kode_kegiatan');
            if ($tahap==4) {
                $where          = ['status'=>1, 'id_instansi' => id_instansi(), 'tahun'=>$tahun];
            }
            else{
                $where          = ['kode_tahap'=>$tahap, 'id_instansi' => id_instansi(), 'tahun'=>$tahun];
            }
            $column_order   = ['', 'nama_sub_kegiatan'];
            $column_search  = ['nama_sub_kegiatan','kode_rekening_sub_kegiatan'];
            $order          = ['nama_sub_kegiatan' => 'ASC'];
            $list           = $this->datatables_model->get_datatables('v_sub_kegiatan_apbd', $column_order, $column_search, $order, $where);
            $data           = [];
            $no             = $_POST['start'];
            foreach ($list as $lists) {
                $krsk = $lists->kode_rekening_sub_kegiatan;
                $pecah = explode('.', $lists->kode_rekening_sub_kegiatan);
                $kode_sub_kegiatan = $pecah[0].'.'.$pecah[1].'.'.$pecah[2].'.'.$pecah[3].'.'.$pecah[4].'.'.$pecah[5];
                $kategori = $lists->kategori;
                $sub_organisasi = '<br>'.$lists->jenis_sub_kegiatan.' - '.$lists->keterangan;
                $keterangan = $kategori =='Sub Kegiatan SKPD' ? '' : $sub_organisasi;
                // upel = unit pelaksana
                 $onclick_update_upel = "edit_ski_teknis('".$lists->kode_rekening_sub_kegiatan."','".$kode_sub_kegiatan."', '".$lists->nama_sub_kegiatan."', '".$lists->id_sub_kegiatan_instansi."', '".$lists->jenis_sub_kegiatan."', '".$lists->keterangan."')";
                 if ($fetch_method=='lihat_data_apbd') {
                    $tbl_update_upel ="";
                     # code...
                 }else{

                    $tbl_update_upel = $kategori =='Sub Kegiatan SKPD' ? '' : '<br><button class="btn btn-info btn-xs"  title="Edit Unit Pelaksana"  onclick="'.$onclick_update_upel.'"><i class="fas fa-edit"></i></button> ';
                 }
                $no++;
                $kode_rekening_program = $lists->kode_rekening_program;
                $kode_rekening_kegiatan = $lists->kode_rekening_kegiatan;
                $kegiatan  = $this->db->query("SELECT nama_kegiatan from master_kegiatan where kode_kegiatan = '$kode_rekening_kegiatan'")->row_array();
                $program  = $this->db->query("SELECT nama_program from master_program where kode_program = '$kode_rekening_program'")->row_array();

                 $nama_sub_kegiatan ='<b>'.$kode_sub_kegiatan .'</b><br>'.$lists->nama_sub_kegiatan. $keterangan. $tbl_update_upel ;
                $row    = [];
                $row[]     = $no;
                $row[]  = '<b>'.$lists->kode_rekening_program.'</b><br>'. $program['nama_program'];
                $row[]  = '<b>'.$lists->kode_rekening_kegiatan.'</b><br>'. $kegiatan['nama_kegiatan'];
                $row[]  = $nama_sub_kegiatan ; 
                $row[]  = '<b>'.$lists->kategori;
                 $pagu   = $lists->pagu =='' ? 0 : $lists->pagu;
                $row[]  =  '<span style="float:right">'.number_format($pagu,0,'','.').'</span>';
                $row[]  = $lists->input_by;
                $onclick = "hapus_sub_kegiatan_instansi('".$lists->kode_rekening_sub_kegiatan."','".$lists->kode_rekening_kegiatan."', '".$lists->kode_rekening_program."','".$lists->kode_tahap."', '".$lists->tahun."','gabungan')";
                $onclick2 = "input_anggaran('".$lists->kode_rekening_sub_kegiatan."','".$lists->kode_rekening_kegiatan."', '".$lists->kode_rekening_program."','".$lists->kode_tahap."','".tahun_anggaran()."','".$lists->kode_bidang_urusan."','gabungan')";

               $onclick3 = "get_target('".$lists->kode_rekening_sub_kegiatan."','".$lists->kode_rekening_kegiatan."', '".$lists->kode_rekening_program."','".$lists->kode_tahap."','".tahun_anggaran()."','".$lists->kode_bidang_urusan."','".$lists->pagu."')";
               $onclick4 = "get_sumber_dana('".$lists->kode_rekening_sub_kegiatan."','".$lists->kode_rekening_kegiatan."', '".$lists->kode_rekening_program."','".$lists->kode_tahap."','".tahun_anggaran()."','".$lists->kode_bidang_urusan."','".$lists->pagu."')";

               if($pagu==0){
                $tomboltarget = '<button class="btn btn-outline-danger btn-xs"  title="Input target sub   kegiatan '.$lists->nama_sub_kegiatan.'"  onclick="target_forbidden()"><i class="fas fa-crosshairs"></i></button> ';
                $tombolsumber_dana = '<button class="btn btn-outline-danger btn-xs"  title="Input target sub   kegiatan '.$lists->nama_sub_kegiatan.'"  onclick="sumber_dana_forbidden()"><i class="fas fa-money-bill"></i></button> ';
               }else{
                $tomboltarget = '<button class="btn btn-outline-info btn-xs"  title="Input target sub   kegiatan '.$lists->nama_sub_kegiatan.'"  onclick="'.$onclick3.'"><i class="fas fa-crosshairs"></i></button> ';
                $tombolsumber_dana = '<button class="btn btn-outline-info btn-xs"  title="Input Sumberdana sub   kegiatan '.$lists->nama_sub_kegiatan.'"  onclick="'.$onclick4.'"><i class="fas fa-money-bill"></i></button> ';
               }

               $nama_sub_kegiatan = $lists->nama_sub_kegiatan. str_replace('<br>', ' \n ', $keterangan) ;
               $onclick_copy = "copy_data_apbd_sub_kegiatan('".$lists->kode_rekening_sub_kegiatan."','".$lists->kode_rekening_kegiatan."', '".$lists->kode_rekening_program."','".tahapan_apbd()."','".$lists->kode_bidang_urusan."','".$nama_sub_kegiatan."')";


                $tombolcopy = '<button class="btn btn-outline-info btn-xs"  title="Input target sub   kegiatan '.$lists->nama_sub_kegiatan.'"  onclick="'.$onclick_copy.'"><i class="fas fa-copy"></i></button> ';

                $cek_count_data_pagu = $this->db->query("SELECT * from anggaran_sub_kegiatan where id_instansi='$id_instansi' and kode_tahap='$tahap' and kode_sub_kegiatan='$krsk'")->num_rows();
                if (tahapan_apbd()!=2 && $pagu==0 && $cek_count_data_pagu==0) {
                    $tombol = $tombolcopy.$tombolsumber_dana.$tomboltarget;
                }else{

                    $tombol = $tombolsumber_dana.$tomboltarget;
                }
                if ($fetch_method=='lihat_data_apbd') {
                $row[]     =  "";
                    # code...
                }else{
                    if (jadwal_input_data_dasar()['aktif']==0) {
                        $alert_kunci_input = "Swal.fire('Terkunci','".jadwal_input_data_dasar()['pesan']."','error')";
                        $row[]     =  '<button class="btn btn-outline-danger btn-sm" onclick="'.$alert_kunci_input.'">'.jadwal_input_data_dasar()['pesan_action'].'</button> ' ;
                    }else{

                        $row[]     =  $tombol.
                        '<button class="btn btn-info btn-xs"  title="Input anggaran belanja sub  kegiatan '.$lists->nama_sub_kegiatan.'"  onclick="'.$onclick2.'"><i class="fas fa-money-bill"></i></button> '.
                         // '<button class="btn btn-info btn-xs"  title="Input indikator sub kegiatan '.$lists->nama_sub_kegiatan.'"><i class="metismenu-icon fas fa-file-signature"></i></button> ' .
                         '<button class="btn btn-danger btn-xs" onclick="'.$onclick.'"><i class="fa fa-trash"></i></button>' . '';
                    }
                }


                


               
                $data[] = $row;
            }

            $output = [
                "draw"              => $_POST['draw'],
                "recordsTotal"      => $this->datatables_model->count_all('v_sub_kegiatan_apbd', $where),
                "recordsFiltered"   => $this->datatables_model->count_filtered('v_sub_kegiatan_apbd', $column_order, $column_search, $order, $where),
                "data"              => $data,
            ];

            echo json_encode($output);
        }
    }



    public function pengalihan_apbd_sub_kegiatan_apbd_instansi_gabungan()
    {
        if (!$this->input->is_ajax_request()) {
            show_404();
        } else {            



            $tahap = $this->input->post('tahap');
            $tahun = $this->input->post('tahun');
            $fetch_method = $this->input->post('fetch_method');
            $id_instansi = id_instansi();
            $kode_kegiatan  = $this->input->post('kode_kegiatan');
            $kode_tahap = [2=>'APBD AWAL',4=>'Pengalihan APBD Awal Ke APBD Perubahan'];
                $where          = ['id_instansi' => id_instansi(), 'tahun'=>$tahun, 'status'=>1];
           
            $column_order   = ['', 'nama_sub_kegiatan'];
            $column_search  = ['nama_sub_kegiatan','kode_rekening_sub_kegiatan'];
            $order          = ['nama_sub_kegiatan' => 'ASC'];
            $list           = $this->datatables_model->get_datatables('v_sub_kegiatan_apbd', $column_order, $column_search, $order, $where);
            $data           = [];
            $no             = $_POST['start'];
            foreach ($list as $lists) {
                $krsk = $lists->kode_rekening_sub_kegiatan;
                $pecah = explode('.', $lists->kode_rekening_sub_kegiatan);
                $kode_sub_kegiatan = $pecah[0].'.'.$pecah[1].'.'.$pecah[2].'.'.$pecah[3].'.'.$pecah[4].'.'.$pecah[5];
                $kategori = $lists->kategori;
                $sub_organisasi = '<br>'.$lists->jenis_sub_kegiatan.' - '.$lists->keterangan;
                $keterangan = $kategori =='Sub Kegiatan SKPD' ? '' : $sub_organisasi;
                // upel = unit pelaksana
           
                $no++;
                $kode_rekening_program = $lists->kode_rekening_program;
                $kode_rekening_kegiatan = $lists->kode_rekening_kegiatan;
                $kegiatan  = $this->db->query("SELECT nama_kegiatan from master_kegiatan where kode_kegiatan = '$kode_rekening_kegiatan'")->row();
                $program  = $this->db->query("SELECT nama_program from master_program where kode_program = '$kode_rekening_program'")->row();

                 $nama_sub_kegiatan =$lists->nama_sub_kegiatan. $keterangan;
                $row    = [];
                $row[]     = $no;
                $row[]  = '<b>'.$lists->kode_rekening_program.'</b><br>'. $program->nama_program;
                $row[]  = '<b>'.$lists->kode_rekening_kegiatan.'</b><br>'. $kegiatan->nama_kegiatan;
                $row[]  = '<b>'.$kode_sub_kegiatan .'</b><br>'.$nama_sub_kegiatan ; 
                $row[]  = '<b>'.$lists->kategori;
                 $pagu   = $lists->pagu =='' ? 0 : $lists->pagu;
                $row[]  = $kode_tahap[$lists->kode_tahap];
                $onclick = "alihkan_sub_kegiatan_instansi_apbd_awal_ke_perubahan('".$lists->id_sub_kegiatan_instansi."','".$nama_sub_kegiatan."')";
                $onclick_akhiri = "akhiri_sub_kegiatan_instansi_apbd_awal('".$lists->id_sub_kegiatan_instansi."','".$nama_sub_kegiatan."')";
               

                if (tahapan_apbd()!=$lists->kode_tahap) {
                    $row[]     = '<button class="btn btn-danger btn-xs" onclick="'.$onclick.'"><i class="fa fa-random"></i></button> <button class="btn btn-danger btn-xs" onclick="'.$onclick_akhiri.'"><i class="fa fa-times"></i></button>';
                        
                }else{
                    $row[]     = '' . '';

                }


               
                $data[] = $row;
            }

            $output = [
                "draw"              => $_POST['draw'],
                "recordsTotal"      => $this->datatables_model->count_all('v_sub_kegiatan_apbd', $where),
                "recordsFiltered"   => $this->datatables_model->count_filtered('v_sub_kegiatan_apbd', $column_order, $column_search, $order, $where),
                "data"              => $data,
            ];

            echo json_encode($output);
        }
    }





    public function permasalahan_sub_kegiatan_apbd_instansi($id_opd)
    {
        if (!$this->input->is_ajax_request()) {
            show_404();
        } else {            
            $tahap = $this->input->post('tahap');
            $tahun = $this->input->post('tahun');
            $id_instansi = sbe_crypt($id_opd, 'D');
       
                $where          = ['status'=>1, 'tahun'=>$tahun, 'id_instansi' => $id_instansi];
            $column_order   = ['', 'nama_sub_kegiatan'];
            $column_search  = ['nama_sub_kegiatan','kode_rekening_sub_kegiatan'];
            $order          = ['nama_sub_kegiatan' => 'ASC'];
            $list           = $this->datatables_model->get_datatables('v_sub_kegiatan_apbd', $column_order, $column_search, $order, $where);
            $data           = [];
            $no             = $_POST['start'];
            foreach ($list as $lists) {
                $krsk = $lists->kode_rekening_sub_kegiatan;
                $pecah = explode('.', $krsk);
                $kode_sub_kegiatan = $pecah[0].'.'.$pecah[1].'.'.$pecah[2].'.'.$pecah[3].'.'.$pecah[4].'.'.$pecah[5];
                $kategori = $lists->kategori;
                $sub_organisasi = '<br>'.$lists->jenis_sub_kegiatan.' - '.$lists->keterangan;
                $keterangan = $kategori =='Sub Kegiatan SKPD' ? '' : $sub_organisasi;
               
              
                $no++;
                $kode_rekening_program = $lists->kode_rekening_program;
                $kode_rekening_kegiatan = $lists->kode_rekening_kegiatan;
                $permasalahan  = $this->db->query("SELECT * from permasalahan_sub_kegiatan where kode_sub_kegiatan = '$krsk' and id_instansi='$id_instansi' and tahun='$tahun'");

                $solusi  = $this->db->query("SELECT id_solusi_permasalahan_sub_kegiatan, id_instansi, solusi, solusi_by from solusi_permasalahan_sub_kegiatan where kode_sub_kegiatan = '$krsk' and id_instansi='$id_instansi' and tahun ='$tahun'");
               
                $row    = [];
                $row[]     = $no;
          
                $row[]  = '<b>'.$kode_sub_kegiatan .'</b><br>'.$lists->nama_sub_kegiatan. $keterangan;
                
                $tabel_permasalahan = '
                <ol>
                ';
                foreach ($permasalahan->result() as $k_masalah => $v_masalah) {
                    $show_masalah = "edit_permasalahan('".$lists->kode_rekening_sub_kegiatan."','".$lists->kode_rekening_kegiatan."', '".$lists->kode_rekening_program."','".tahapan_apbd()."','".$tahun."','".$lists->kode_bidang_urusan."','".$v_masalah->id_permasalahan_sub_kegiatan."')";
                     if ($this->session->userdata('id_group')==5) {  
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
                    $show_solusi = "edit_solusi_permasalahan('".$lists->kode_rekening_sub_kegiatan."','".$lists->kode_rekening_kegiatan."', '".$lists->kode_rekening_program."','".tahapan_apbd()."','".$lists->kode_bidang_urusan."','".$v_solusi->id_solusi_permasalahan_sub_kegiatan."','".$v_solusi->id_instansi."')";
                  if ($this->session->userdata('group_name')==$v_solusi->solusi_by) {  
                $tabel_solusi .= '<li style="color: #5fb6ff "><a href="#" onclick="'.$show_solusi.'">'.$v_solusi->solusi.'</a></li>';
                    }else{
                $tabel_solusi .= '<li>'.$v_solusi->solusi.'</li>';

                    }
                }
                $tabel_solusi .= '
                </ol>
                ';
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
                
                 $onclick = "input_permasalahan('".$lists->kode_rekening_sub_kegiatan."','".$lists->kode_rekening_kegiatan."', '".$lists->kode_rekening_program."','".tahapan_apbd()."','".$tahun."','".$lists->kode_bidang_urusan."')";
                $tombol_tambah_masalah = '<button class="btn btn-outline-info btn-xs"  title="Input permasalahan pad sub  kegiatan '.$lists->nama_sub_kegiatan.'"  onclick="'.$onclick.'"><i class="fas fa-plus"></i></button>';


                 $onclick2 = "input_solusi_permasalahan('".$lists->kode_rekening_sub_kegiatan."','".$lists->kode_rekening_kegiatan."', '".$lists->kode_rekening_program."','".tahapan_apbd()."','".$tahun."','".$lists->kode_bidang_urusan."','".sbe_crypt($lists->id_instansi, 'E')."')";
                $tombol_tambah_solusi = ' <button class="btn btn-outline-info btn-xs"  title="Input Solusi pad sub  kegiatan '.$lists->nama_sub_kegiatan.'"  onclick="'.$onclick2.'"><i class="fas fa-check-circle"></i></button>';

                if ($this->session->userdata('id_group')==5) {
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
                // $row[]  = "";
                // $row[]  = "";
                // $row[]  = "";
                // $row[]  = "";

                
                
                $data[] = $row;
            }

            $output = [
                "draw"              => $_POST['draw'],
                "recordsTotal"      => $this->datatables_model->count_all('v_sub_kegiatan_apbd', $where),
                "recordsFiltered"   => $this->datatables_model->count_filtered('v_sub_kegiatan_apbd', $column_order, $column_search, $order, $where),
                "data"              => $data,
            ];

            echo json_encode($output);
        }
    }




    public function show_pilihan_sub_kegiatan_apbd()
    {
        if (!$this->input->is_ajax_request()) {
            show_404();
        } else {            
            $tahap = tahapan_apbd();
            $tahun = tahun_anggaran();
            $kode_kegiatan  = $this->input->post('kode_kegiatan');
            
            $where          = ['tahun'=>$tahun,'status'=>1, 'id_instansi' => id_instansi(), 'kategori'=>'Sub Kegiatan SKPD'];
            $column_order   = ['', 'nama_sub_kegiatan'];
            $column_search  = ['nama_sub_kegiatan','kode_rekening_sub_kegiatan'];
            $order          = ['nama_sub_kegiatan' => 'ASC'];
            $list           = $this->datatables_model->get_datatables('v_sub_kegiatan_apbd', $column_order, $column_search, $order, $where);
            $data           = [];
            $no             = $_POST['start'];
            foreach ($list as $lists) {
                $no++;
                $kode_rekening_program = $lists->kode_rekening_program;
                $kode_rekening_kegiatan = $lists->kode_rekening_kegiatan;
                $kegiatan  = $this->db->query("SELECT nama_kegiatan from master_kegiatan where kode_kegiatan = '$kode_rekening_kegiatan'")->row_array();
                $program  = $this->db->query("SELECT nama_program from master_program where kode_program = '$kode_rekening_program'")->row_array();
                $row    = [];
                $row[]     = $no;
                $row[]  = '<b>'.$lists->kode_rekening_program.'</b><br>'. $program['nama_program'];
                $row[]  = '<b>'.$lists->kode_rekening_kegiatan.'</b><br>'. $kegiatan['nama_kegiatan'];
                $row[]  = '<b>'.$lists->kode_rekening_sub_kegiatan.'</b><br>'.$lists->nama_sub_kegiatan;

                $where_uptd          = ['tahun'=>$tahun,'status'=>1, 'id_instansi' => id_instansi(), 'kode_sub_kegiatan like' => '%'.$lists->kode_rekening_sub_kegiatan.'%', 'kategori'=>'Unit Pelaksana'];
                $q_ski_uptd = $this->db->get_where('sub_kegiatan_instansi', $where_uptd);
                $row[]  = $q_ski_uptd->num_rows();
                
               
                $onclick2 = "input_ski_teknis('".$lists->kode_rekening_sub_kegiatan."','".$lists->kode_rekening_kegiatan."', '".$lists->kode_rekening_program."','".tahapan_apbd()."','".$lists->kode_bidang_urusan."','gabungan')";


                $row[]     =  
                 '<button class="btn btn-info btn-xs" onclick="'.$onclick2.'"><i class="fa fa-plus"></i></button>' . '';
               
                $data[] = $row;
            }

            $output = [
                "draw"              => $_POST['draw'],
                "recordsTotal"      => $this->datatables_model->count_all('v_sub_kegiatan_apbd', $where),
                "recordsFiltered"   => $this->datatables_model->count_filtered('v_sub_kegiatan_apbd', $column_order, $column_search, $order, $where),
                "data"              => $data,
            ];

            echo json_encode($output);
        }
    }


 public function get_target()
    {
        if (!$this->input->is_ajax_request()) {
            show_404();
        } else {
            $output = [
                'status'    => false,
                'data'      => []
            ];
            $kode_rekening_sub_kegiatan = $this->input->post('kode_rekening_sub_kegiatan');
            $kode_kegiatan = $this->input->post('kode_kegiatan');
            $kode_program = $this->input->post('kode_program');
            $kode_bidang_urusan = $this->input->post('kode_bidang_urusan');
            $tahap = $this->input->post('tahap');
            $tahun = $this->input->post('tahun');
            $id_instansi = id_instansi();
            $where = [
                'kode_bidang_urusan' => $kode_bidang_urusan, 
                'kode_rekening_program' => $kode_program, 
                'kode_rekening_kegiatan' => $kode_kegiatan, 
                'kode_rekening_sub_kegiatan' => $kode_rekening_sub_kegiatan, 
                'kode_tahap' => $tahap,
                'tahun' => $tahun,
                'id_instansi' => id_instansi()
            ];
            $target                 = $this->db->get_where('target_apbd', $where);
            $subkeg                 = $this->db->query("SELECT nama_sub_kegiatan, kategori, jenis_sub_kegiatan, keterangan from v_sub_kegiatan_apbd where kode_rekening_sub_kegiatan='$kode_rekening_sub_kegiatan' and kode_tahap='$tahap' and id_instansi='$id_instansi' and tahun = '$tahun'")->row();
            $nama_sub_kegiatan = $subkeg->kategori =='Sub Kegiatan SKPD' ? $subkeg->nama_sub_kegiatan : $subkeg->nama_sub_kegiatan.'<br>'.$subkeg->jenis_sub_kegiatan.' - '.$subkeg->keterangan;

            $pecah = explode('.', $kode_rekening_sub_kegiatan);
            $kode_sub_kegiatan = $pecah[0].'.'.$pecah[1].'.'.$pecah[2].'.'.$pecah[3].'.'.$pecah[4].'.'.$pecah[5];
            $output['totaldata']             = $target->num_rows();
            $output['kategori']              = $subkeg->kategori;
            $output['nama_sub_kegiatan']     = $nama_sub_kegiatan;
            $output['kode_sub_kegiatan']     = $kode_sub_kegiatan;
            $output['nama_tahapan']  = pilihan_nama_tahapan($tahap);
            if ($target->num_rows() > 0) {
                foreach ($target->result() as $key => $value) {
                    $output['data'][$key]['id']         = sbe_crypt($value->id_target_apbd, 'E');
                    $output['data'][$key]['bulan']      = $value->bulan;
                    $output['data'][$key]['t_fisik']    = $value->target_fisik;
                    $output['data'][$key]['t_fisik_bulanan']    = $value->target_fisik_bulanan;
                    $output['data'][$key]['t_keuangan'] = $value->target_keuangan;
                    $output['data'][$key]['t_keuangan_bulanan'] = $value->target_keuangan_bulanan;
                }

                $output['status']  = true;
            } else {
                for ($i=0; $i < 12; $i++) { 
                    $bulan = $i+1;
                    $wherenull = [
                        'kode_bidang_urusan' => $kode_bidang_urusan, 
                        'kode_rekening_program' => $kode_program, 
                        'kode_rekening_kegiatan' => $kode_kegiatan, 
                        'kode_rekening_sub_kegiatan' => $kode_rekening_sub_kegiatan, 
                        'kode_tahap' => $tahap,
                        'tahun' => $tahun,
                        'bulan' => $bulan,
                        'id_instansi' => id_instansi()
                    ];
                    $cek = $this->db->get_where('target_apbd', $wherenull);
                    if ($cek->num_rows()==0) {
                        $insert = [
                            'id_instansi'=>id_instansi(),
                            'kode_bidang_urusan'=>$kode_bidang_urusan,
                            'kode_rekening_program'=>$kode_program,
                            'kode_rekening_kegiatan'=>$kode_kegiatan,
                            'kode_rekening_sub_kegiatan'=>$kode_rekening_sub_kegiatan,
                            'kode_tahap'=>$tahap,
                            'bulan'=>$bulan,
                            'target_fisik'=>0,
                            'target_keuangan'=>0,
                            'target_keuangan_bulanan'=>0,
                            'tahun'=>$tahun,
                            'created_on'=> timestamp(), 
                            'created_by'=>id_user()
                        ];
                        $this->db->insert('target_apbd', $insert);
                    }
                }
            }

            echo json_encode($output);
        }
    }


 public function copy_data_apbd_sub_kegiatan()
    {
        if (!$this->input->is_ajax_request()) {
            show_404();
        } else {
            $output = [
                'status'    => false,
                'data'      => []
            ];
            $kode_rekening_sub_kegiatan = $this->input->post('kode_rekening_sub_kegiatan');
            $kode_kegiatan = $this->input->post('kode_kegiatan');
            $kode_program = $this->input->post('kode_program');
            $kode_bidang_urusan = $this->input->post('kode_bidang_urusan');
            $tahap = $this->input->post('tahap');
            $id_instansi = id_instansi();
            $where_awal = [
                'kode_bidang_urusan' => $kode_bidang_urusan, 
                'kode_rekening_program' => $kode_program, 
                'kode_rekening_kegiatan' => $kode_kegiatan, 
                'kode_rekening_sub_kegiatan' => $kode_rekening_sub_kegiatan, 
                'kode_tahap' => 2,
                'id_instansi' => id_instansi()
            ];
            $where_pagu_awal = [
                'kode_bidang_urusan' => $kode_bidang_urusan, 
                'kode_program' => $kode_program, 
                'kode_kegiatan' => $kode_kegiatan, 
                'kode_sub_kegiatan' => $kode_rekening_sub_kegiatan, 
                'kode_tahap' => 2,
                'id_instansi' => id_instansi()
            ];

            $where_perubahan = [
                'kode_bidang_urusan' => $kode_bidang_urusan, 
                'kode_rekening_program' => $kode_program, 
                'kode_rekening_kegiatan' => $kode_kegiatan, 
                'kode_rekening_sub_kegiatan' => $kode_rekening_sub_kegiatan, 
                'kode_tahap' => tahapan_apbd(),
                'id_instansi' => id_instansi()
            ];
            $where_pagu_perubahan = [
                'kode_bidang_urusan' => $kode_bidang_urusan, 
                'kode_program' => $kode_program, 
                'kode_kegiatan' => $kode_kegiatan, 
                'kode_sub_kegiatan' => $kode_rekening_sub_kegiatan, 
                'kode_tahap' => tahapan_apbd(),
                'id_instansi' => id_instansi()
            ];

            // data APBD awal

            $target                 = $this->db->order_by('bulan', 'ASC')->get_where('target_apbd', $where_awal);

            $sumber_dana                 = $this->db->get_where('sumber_dana', $where_awal);
            $anggaran_awal                 = $this->db->get_where('anggaran_sub_kegiatan', $where_pagu_awal);

            // cek apbd perubahan apakah sudah ada atau belum
            $anggaran_perubahan          = $this->db->get_where('anggaran_sub_kegiatan', $where_pagu_perubahan);

            // copy data awal
            $anggaran_apbd_awal = $anggaran_awal->row_array();
            $sumber_dana_awal = $sumber_dana->row_array();
            $target_apbd_awal = $target->row_array();


            $kumpul_target_baru = [];
            foreach ($target->result_array() as $k => $v) {
                 $data_target = [
                    'bulan'=>$v['bulan'],
                    'id_instansi'=>$v['id_instansi'],
                    'kode_bidang_urusan'=>$v['kode_bidang_urusan'],
                    'kode_rekening_program'=>$v['kode_rekening_program'],
                    'kode_rekening_kegiatan'=>$v['kode_rekening_kegiatan'],
                    'kode_rekening_sub_kegiatan'=>$v['kode_rekening_sub_kegiatan'],
                    'kode_tahap'=>tahapan_apbd(),
                    'target_fisik'=>$v['target_fisik'],
                    'target_keuangan'=>$v['target_keuangan'],
                    'target_keuangan_bulanan'=>$v['target_keuangan_bulanan'],
                    'tahun'=>$v['tahun'],
                    'created_on'=>$v['created_on'],
                    'created_by'=>$v['created_by'],
                 
                   ];
                   array_push($kumpul_target_baru, $data_target);
            }
            $output['data'] = $kumpul_target_baru;
            $output['sumber_dana'] = $sumber_dana_awal;
            $output['cek'] = $anggaran_awal->num_rows();
            if ($anggaran_perubahan->num_rows()==0) {
               $data_pagu = [
                'kode_sub_kegiatan'=>$anggaran_apbd_awal['kode_sub_kegiatan'],
                'kode_kegiatan'=>$anggaran_apbd_awal['kode_kegiatan'],
                'kode_program'=>$anggaran_apbd_awal['kode_program'],
                'kode_bidang_urusan'=>$anggaran_apbd_awal['kode_bidang_urusan'],
                'id_instansi'=>$anggaran_apbd_awal['id_instansi'],
                'kode_tahap'=>tahapan_apbd(),
                'bo_bp'=>$anggaran_apbd_awal['bo_bp'],
                'bo_bbj'=>$anggaran_apbd_awal['bo_bbj'],
                'bo_bs'=>$anggaran_apbd_awal['bo_bs'],
                'bo_bh'=>$anggaran_apbd_awal['bo_bh'],
                'bm_bmt'=>$anggaran_apbd_awal['bm_bmt'],
                'bm_bmpm'=>$anggaran_apbd_awal['bm_bmpm'],
                'bm_bmgb'=>$anggaran_apbd_awal['bm_bmgb'],
                'bm_bmjji'=>$anggaran_apbd_awal['bm_bmjji'],
                'bm_bmatl'=>$anggaran_apbd_awal['bm_bmatl'],
                'btt'=>$anggaran_apbd_awal['btt'],
                'bt_bbh'=>$anggaran_apbd_awal['bt_bbh'],
                'bt_bbk'=>$anggaran_apbd_awal['bt_bbk'],
                'realisasikan_bo'=>$anggaran_apbd_awal['realisasikan_bo'],
                'realisasikan_bm'=>$anggaran_apbd_awal['realisasikan_bm'],
                'realisasikan_btt'=>$anggaran_apbd_awal['realisasikan_btt'],
                'realisasikan_bt'=>$anggaran_apbd_awal['realisasikan_bt'],
                'tahun'=>$anggaran_apbd_awal['tahun'],
                'created_on'=>timestamp(),
                'created_by'=>$anggaran_apbd_awal['created_by'],
                'input_by '=>'Copy',
               ];
               $data_sumber_dana = [
                'id_instansi'=>$sumber_dana_awal['id_instansi'],
                'kode_rekening_sub_kegiatan'=>$sumber_dana_awal['kode_rekening_sub_kegiatan'],
                'kode_rekening_kegiatan'=>$sumber_dana_awal['kode_rekening_kegiatan'],
                'kode_rekening_program'=>$sumber_dana_awal['kode_rekening_program'],
                'kode_bidang_urusan'=>$sumber_dana_awal['kode_bidang_urusan'],
                'kode_tahap'=>tahapan_apbd(),
                'pad'=>$sumber_dana_awal['pad'],
                'dau'=>$sumber_dana_awal['dau'],
                'dak'=>$sumber_dana_awal['dak'],
                'dbh'=>$sumber_dana_awal['dbh'],
                'lainnya'=>$sumber_dana_awal['lainnya'],
                'created_on'=>$sumber_dana_awal['created_on'],
                'created_by'=>$sumber_dana_awal['created_by'],
                'updated_on'=>$sumber_dana_awal['updated_on'],
                'updated_by'=>$sumber_dana_awal['updated_by'],
                
                'input_by'=>'Copy',
               ];


              



               $this->db->insert('anggaran_sub_kegiatan', $data_pagu);
               $this->db->insert_batch('target_apbd', $kumpul_target_baru);
               $this->db->insert('sumber_dana', $data_sumber_dana);
            }
            
            echo json_encode($output);
        }
    }



    public function cek_sumber_dana()
    {
        if (!$this->input->is_ajax_request()) {
            show_404();
        } else {
            $output = [
                'status'    => false,
                'data'      => []
            ];

          $kode_rekening_sub_kegiatan = $this->input->post('kode_rekening_sub_kegiatan');
            $kode_kegiatan = $this->input->post('kode_kegiatan');
            $kode_program = $this->input->post('kode_program');
            $kode_bidang_urusan = $this->input->post('kode_bidang_urusan');
            $tahap = $this->input->post('tahap');
            $tahun = $this->input->post('tahun');
            $id_instansi = id_instansi();
            $where = [
                'kode_bidang_urusan' => $kode_bidang_urusan, 
                'kode_rekening_program' => $kode_program, 
                'kode_rekening_kegiatan' => $kode_kegiatan, 
                'kode_rekening_sub_kegiatan' => $kode_rekening_sub_kegiatan, 
                'kode_tahap' => $tahap,
                'tahun' => $tahun,
                'id_instansi' => id_instansi()
            ];
            $target                 = $this->db->get_where('target_apbd', $where);












              $subkeg                 = $this->db->query("SELECT nama_sub_kegiatan, kategori, jenis_sub_kegiatan, keterangan from v_sub_kegiatan_apbd where kode_rekening_sub_kegiatan='$kode_rekening_sub_kegiatan' and kode_tahap='$tahap' and id_instansi='$id_instansi' and tahun='$tahun'")->row();
            $nama_sub_kegiatan = $subkeg->kategori =='Sub Kegiatan SKPD' ? $subkeg->nama_sub_kegiatan : $subkeg->nama_sub_kegiatan.'<br>'.$subkeg->jenis_sub_kegiatan.' - '.$subkeg->keterangan;

            $pecah = explode('.', $kode_rekening_sub_kegiatan);
            $kode_sub_kegiatan = $pecah[0].'.'.$pecah[1].'.'.$pecah[2].'.'.$pecah[3].'.'.$pecah[4].'.'.$pecah[5];
            $output['totaldata']             = $target->num_rows();
            $output['kategori']              = $subkeg->kategori;
            $output['nama_sub_kegiatan']     = $nama_sub_kegiatan;
            $output['kode_sub_kegiatan']     = $kode_sub_kegiatan;
            $output['nama_tahapan']  = nama_tahapan();



            $kode_rekening_kegiatan = $this->input->post('kode_rekening_kegiatan');
            $kode_urusan            = $this->input->post('kode_urusan');


            $sumber_dana = $this->db->get_where('sumber_dana', $where);

            if ($sumber_dana->num_rows() > 0) {
                foreach ($sumber_dana->result() as $key => $value) {
                    $output['data'] = $value;
                }

                $output['status'] = true;
            }else{
                $output['status'] = false;

            }

            echo json_encode($output);
        }
    }




    public function cek_master_sub_kegiatan()
    {
        if (!$this->input->is_ajax_request()) {
            show_404();
        } else {
            $output = [
                'status'    => false,
                'data'      => []
            ];

          $kode_rekening_sub_kegiatan = $this->input->post('kode_rekening_sub_kegiatan');
            $subkeg                 = $this->db->query("SELECT kode_sub_kegiatan, nama_sub_kegiatan from master_sub_kegiatan where kode_sub_kegiatan='$kode_rekening_sub_kegiatan'")->row();
           
            $output['nama_sub_kegiatan']  = $subkeg->nama_sub_kegiatan;
            $output['kode_sub_kegiatan']  = $subkeg->kode_sub_kegiatan;
            $output['nama_tahapan']  = nama_tahapan();



            $kode_rekening_kegiatan = $this->input->post('kode_rekening_kegiatan');
            $kode_urusan            = $this->input->post('kode_urusan');


                $output['status'] = true;


            echo json_encode($output);
        }
    }





    public function save_sumber_dana()
    {
        if (!$this->input->is_ajax_request()) {
            show_404();
        } else {
            $output = [
                'status'    => false,
                'data'      => []
            ];

            $status                 = $this->input->post('status');
            $kode_sub_kegiatan = $this->input->post('kode_sub_kegiatan');
            $kode_kegiatan = $this->input->post('kode_kegiatan');
            $kode_program = $this->input->post('kode_program');
            $kode_bidang_urusan = $this->input->post('kode_bidang_urusan');
            $tahap = $this->input->post('tahap');
            $tahun = $this->input->post('tahun');
            $nama_sumber_dana_lainnya = $this->input->post('nama_sumber_dana_lainnya');


            $pad                    = $this->input->post('pad');
            $dau                    = $this->input->post('dau');
            $dak                    = $this->input->post('dak');
            $dbh                    = $this->input->post('dbh');
            $lainnya                = $this->input->post('lainnya');

            if ($status == 'insert') {
                $data = [
                    'id_instansi'               => id_instansi(),
                    'kode_rekening_sub_kegiatan'=> $kode_sub_kegiatan,
                    'kode_rekening_kegiatan'    => $kode_kegiatan,
                    'kode_rekening_program'     => $kode_program,
                    'kode_bidang_urusan'        => $kode_bidang_urusan,
                    'kode_tahap'                => $tahap,
                    'tahun'                => $tahun,
                    'pad'                       => $pad,
                    'dau'                       => $dau,
                    'dak'                       => $dak,
                    'dbh'                       => $dbh,
                    'lainnya'                   => $lainnya,
                    'nama_sumber_dana_lainnya'                   => $nama_sumber_dana_lainnya,
                    'created_on'                => timestamp(),
                    'created_by'                => id_user(),
                    'updated_on'                => timestamp(),
                    'updated_by'                => id_user(),
                    'input_by'                  => 'Manual Input'
                 
                ];
                $this->db->insert('sumber_dana', $data);
                $output['status'] = true;
            } else {
                 $data = [
                    'pad'                       => $pad,
                    'dau'                       => $dau,
                    'dak'                       => $dak,
                    'dbh'                       => $dbh,
                    'lainnya'                   => $lainnya,

                    'nama_sumber_dana_lainnya'                   => $nama_sumber_dana_lainnya,
                    'updated_on'                => timestamp(),
                    'updated_by'                => id_user(),
                 
                ];
                $where = [
                    'id_instansi'               => id_instansi(),
                    'kode_rekening_sub_kegiatan'=> $kode_sub_kegiatan,
                    'kode_rekening_kegiatan'    => $kode_kegiatan,
                    'kode_rekening_program'     => $kode_program,
                    'kode_bidang_urusan'        => $kode_bidang_urusan,
                    'kode_tahap'                => $tahap,
                    'tahun'                => $tahun
                ];
                $this->db->update('sumber_dana', $data, $where);
                $output['status'] = true;
            }


            echo json_encode($output);
        }
    }

/*
 public function copy_sub_kegiatan_apbd_awal()
    {
        if (!$this->input->is_ajax_request()) {
            show_404();
        } else {
            $output = [
                'status'    => false,
                'data'      => [],
                'messages'  =>""
            ];
           
            $tahap = 2;
            $whereawal = [
                'kode_tahap' => 2,
                'id_instansi' => id_instansi()
            ];
            $ski_apbd_awal = $this->db->get_where('sub_kegiatan_instansi', $whereawal);
            $j_ski_apbd_awal = $ski_apbd_awal->num_rows();
            if ($j_ski_apbd_awal==0) {
                $output['status']  = false;
                $output['messages']  = "Anda tidak memiliki data program, kgiatan, sub kegiatan pada APBD AWAL";
            }else{
                foreach ($ski_apbd_awal->result_array() as $k => $v) {
                   $where_ski_baru = [
                    'kode_sub_kegiatan'=>$v['kode_sub_kegiatan'],
                    'kode_kegiatan'=>$v['kode_kegiatan'],
                    'kode_program'=>$v['kode_program'],
                    'kode_bidang_urusan'=>$v['kode_bidang_urusan'],
                    'id_instansi'=>$v['id_instansi'],
                    'kode_tahap'=>tahapan_apbd(),
                    'kategori'=>$v['kategori'],
                    'jenis_sub_kegiatan'=>$v['jenis_sub_kegiatan'],
                    'keterangan'=>$v['keterangan'],
                    'tahun'=>$v['tahun'],
                    'input_by '=>'Copy',
                   ];

                   $cek_ski_baru_suda_ada = $this->db->get_where('sub_kegiatan_instansi', $where_ski_baru)->num_rows();
                   if ($cek_ski_baru_suda_ada==0) {

                       $data_ski_baru = [
                        'kode_sub_kegiatan'=>$v['kode_sub_kegiatan'],
                        'kode_kegiatan'=>$v['kode_kegiatan'],
                        'kode_program'=>$v['kode_program'],
                        'kode_bidang_urusan'=>$v['kode_bidang_urusan'],
                        'id_instansi'=>$v['id_instansi'],
                        'kode_tahap'=>tahapan_apbd(),
                        'kategori'=>$v['kategori'],
                        'tambahan_kode_sub_kegiatan'=>$v['tambahan_kode_sub_kegiatan'],
                        'input_by_tambahan_kode_sub_kegiatan'=>$v['input_by_tambahan_kode_sub_kegiatan'],
                        'jenis_sub_kegiatan'=>$v['jenis_sub_kegiatan'],
                        'keterangan'=>$v['keterangan'],
                        'tahun'=>$v['tahun'],
                        'created_on'=>timestamp(),
                        'created_by'=>id_user(),
                        'input_by '=>'Copy',
                       ];
                       $this->db->insert('sub_kegiatan_instansi', $data_ski_baru);
                   }else{
                       $data_ski_baru = [
                        'updated_on'=>timestamp(),
                        'updated_by'=>id_user(),
                        'input_by '=>'Re-Copy',
                       ];
                       $this->db->update('sub_kegiatan_instansi', $data_ski_baru, $where_ski_baru);

                   }
                }
                    $output['messages']  = "Data APBD AWAL Berhasil di copy";
                    $output['status']  = true;
                    $this->session->set_flashdata('pesan','<div class="alert alert-info>Data APBD AWAL Berhasil di copy</div>');
            }
            // $whereperubahan = [
            //     'kode_bidang_urusan' => $kode_bidang_urusan, 
            //     'kode_rekening_program' => $kode_program, 
            //     'kode_rekening_kegiatan' => $kode_kegiatan, 
            //     'kode_rekening_sub_kegiatan' => $kode_rekening_sub_kegiatan, 
            //     'kode_tahap' => tahapan_apbd(),
            //     'id_instansi' => id_instansi()
            // ];
            // $targetawal                 = $this->db->get_where('target_apbd', $whereawal);
            // $targetperubahan                 = $this->db->get_where('target_apbd', $whereperubahan);
            





            // if ($targetperubahan->num_rows() > 0) {
            //     foreach ($targetawal->result() as $key => $value) {
            //         $bulan      = $value->bulan;
            //         $t_fisik    = $value->target_fisik;
            //         $t_keuangan = $value->target_keuangan;
            //          $val_update = [
            //                 'target_fisik'=>$t_fisik,
            //                 'target_keuangan'=>$t_keuangan,
            //                 'target_keuangan_bulanan'=>0,
            //                 'tahun'=>tahun_anggaran(),
            //                 'created_on'=> timestamp(), 
            //                 'created_by'=>id_user()
            //             ];
            //         $where_update = [
            //              'id_instansi'=>id_instansi(),
            //                 'kode_bidang_urusan'=>$kode_bidang_urusan,
            //                 'kode_rekening_program'=>$kode_program,
            //                 'kode_rekening_kegiatan'=>$kode_kegiatan,
            //                 'kode_rekening_sub_kegiatan'=>$kode_rekening_sub_kegiatan,
            //                 'kode_tahap'=>tahapan_apbd(),
            //                 'bulan'=>$bulan,
            //             ];
            //             $this->db->update('target_apbd', $val_update, $where_update);
            //     }

            //     $output['status']  = true;
            // } else {
            //     $output['status']  = false;
                
            // }

            echo json_encode($output);
        }
    }
*/




 public function copy_sub_kegiatan_data_apbd()
    {
        if (!$this->input->is_ajax_request()) {
            show_404();
        } else {
            $output = [
                'status'    => false,
                'data'      => [],
                'messages'  =>""
            ];
           
            $tahap = $this->input->post('tahap');
            $tahun = $this->input->post('tahun');

            $whereawal = [
                'kode_tahap' => $tahap,
                'tahun' => $tahun,
                'id_instansi' => id_instansi()
            ];
            $ski_apbd_awal = $this->db->get_where('sub_kegiatan_instansi', $whereawal);
            $j_ski_apbd_awal = $ski_apbd_awal->num_rows();
            if ($j_ski_apbd_awal==0) {
                $output['status']  = false;
                $output['messages']  = "Anda tidak memiliki data program, kgiatan, sub kegiatan pada APBD AWAL";
            }else{
                foreach ($ski_apbd_awal->result_array() as $k => $v) {
                   $where_ski_baru = [
                    'kode_sub_kegiatan'=>$v['kode_sub_kegiatan'],
                    'kode_kegiatan'=>$v['kode_kegiatan'],
                    'kode_program'=>$v['kode_program'],
                    'kode_bidang_urusan'=>$v['kode_bidang_urusan'],
                    'id_instansi'=>$v['id_instansi'],
                    'kode_tahap'=>tahapan_apbd(),
                    'kategori'=>$v['kategori'],
                    'jenis_sub_kegiatan'=>$v['jenis_sub_kegiatan'],
                    'keterangan'=>$v['keterangan'],
                    'tahun'=>tahun_anggaran(),
                    'input_by '=>'Copy',
                   ];

                   $cek_ski_baru_suda_ada = $this->db->get_where('sub_kegiatan_instansi', $where_ski_baru)->num_rows();
                   if ($cek_ski_baru_suda_ada==0) {

                       $data_ski_baru = [
                        'kode_sub_kegiatan'=>$v['kode_sub_kegiatan'],
                        'kode_kegiatan'=>$v['kode_kegiatan'],
                        'kode_program'=>$v['kode_program'],
                        'kode_bidang_urusan'=>$v['kode_bidang_urusan'],
                        'id_instansi'=>$v['id_instansi'],
                        'kode_tahap'=>tahapan_apbd(),
                        'kategori'=>$v['kategori'],
                        'tambahan_kode_sub_kegiatan'=>$v['tambahan_kode_sub_kegiatan'],
                        'input_by_tambahan_kode_sub_kegiatan'=>$v['input_by_tambahan_kode_sub_kegiatan'],
                        'jenis_sub_kegiatan'=>$v['jenis_sub_kegiatan'],
                        'keterangan'=>$v['keterangan'],
                        'tahun'=>tahun_anggaran(),
                        'created_on'=>timestamp(),
                        'created_by'=>id_user(),
                        'input_by '=>'Copy',
                       ];
                       $this->db->insert('sub_kegiatan_instansi', $data_ski_baru);
                   }else{
                       $data_ski_baru = [
                        'updated_on'=>timestamp(),
                        'updated_by'=>id_user(),
                        'input_by '=>'Re-Copy',
                       ];
                       $this->db->update('sub_kegiatan_instansi', $data_ski_baru, $where_ski_baru);

                   }
                }
                    $output['messages']  = "Data APBD AWAL Berhasil di copy";
                    $output['status']  = true;
                    $this->session->set_flashdata('pesan','<div class="alert alert-info>Data APBD AWAL Berhasil di copy</div>');
            }
            // $whereperubahan = [
            //     'kode_bidang_urusan' => $kode_bidang_urusan, 
            //     'kode_rekening_program' => $kode_program, 
            //     'kode_rekening_kegiatan' => $kode_kegiatan, 
            //     'kode_rekening_sub_kegiatan' => $kode_rekening_sub_kegiatan, 
            //     'kode_tahap' => tahapan_apbd(),
            //     'id_instansi' => id_instansi()
            // ];
            // $targetawal                 = $this->db->get_where('target_apbd', $whereawal);
            // $targetperubahan                 = $this->db->get_where('target_apbd', $whereperubahan);
            





            // if ($targetperubahan->num_rows() > 0) {
            //     foreach ($targetawal->result() as $key => $value) {
            //         $bulan      = $value->bulan;
            //         $t_fisik    = $value->target_fisik;
            //         $t_keuangan = $value->target_keuangan;
            //          $val_update = [
            //                 'target_fisik'=>$t_fisik,
            //                 'target_keuangan'=>$t_keuangan,
            //                 'target_keuangan_bulanan'=>0,
            //                 'tahun'=>tahun_anggaran(),
            //                 'created_on'=> timestamp(), 
            //                 'created_by'=>id_user()
            //             ];
            //         $where_update = [
            //              'id_instansi'=>id_instansi(),
            //                 'kode_bidang_urusan'=>$kode_bidang_urusan,
            //                 'kode_rekening_program'=>$kode_program,
            //                 'kode_rekening_kegiatan'=>$kode_kegiatan,
            //                 'kode_rekening_sub_kegiatan'=>$kode_rekening_sub_kegiatan,
            //                 'kode_tahap'=>tahapan_apbd(),
            //                 'bulan'=>$bulan,
            //             ];
            //             $this->db->update('target_apbd', $val_update, $where_update);
            //     }

            //     $output['status']  = true;
            // } else {
            //     $output['status']  = false;
                
            // }

            echo json_encode($output);
        }
    }

    public function get_anggaran_sub_kegiatan()
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

            $kode_rekening_sub_kegiatan = $this->input->post('kode_rekening_sub_kegiatan');
            $kode_kegiatan = $this->input->post('kode_kegiatan');
            $kode_program = $this->input->post('kode_program');
            $tahap = $this->input->post('tahap');
            $tahun = $this->input->post('tahun');
            $id_instansi = id_instansi();
            $where = ['kode_sub_kegiatan' => $kode_rekening_sub_kegiatan, 'kode_kegiatan'=>$kode_kegiatan, 'kode_program'=>$kode_program, 'kode_tahap'=>$tahap,'tahun'=>$tahun,   'id_instansi' => id_instansi()];

            $pagu_sub_kegiatan    = $this->db->get_where('anggaran_sub_kegiatan', $where);
            $identitas_ski        = $this->db->query("SELECT * from v_sub_kegiatan_apbd where id_instansi='$id_instansi' and kode_rekening_sub_kegiatan='$kode_rekening_sub_kegiatan' and kode_tahap='$tahap' and tahun='$tahun'")->row();
                $output['data']['nama_sub_kegiatan']                  = $identitas_ski->kategori =='Sub Kegiatan SKPD' ? $identitas_ski->nama_sub_kegiatan : $identitas_ski->nama_sub_kegiatan.'<br>'.$identitas_ski ->jenis_sub_kegiatan.' - '.$identitas_ski->keterangan;
                $output['data']['kategori']                  = $identitas_ski->kategori;



            if ($pagu_sub_kegiatan->num_rows() > 0) {
                foreach ($pagu_sub_kegiatan->result() as $key => $value) {
                    $output['data']['bo_bp']                  = $value->bo_bp;
                    $output['data']['bo_bbj']                  = $value->bo_bbj;
                    $output['data']['bo_bs']                  = $value->bo_bs;
                    $output['data']['bo_bh']                  = $value->bo_bh;
                    $output['data']['bm_bmt']                  = $value->bm_bmt;
                    $output['data']['bm_bmpm']                  = $value->bm_bmpm;
                    $output['data']['bm_bmgb']                  = $value->bm_bmgb;
                    $output['data']['bm_bmjji']                  = $value->bm_bmjji;
                    $output['data']['bm_bmatl']                  = $value->bm_bmatl;
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




    public function get_permasalahan_sub_kegiatan()
    {
        if (!$this->input->is_ajax_request()) {
            show_404();
        } else {
            $output = [
                'status'    => false,
                'permasalahan'      => [],
                'sub_kegiatan'    => []
            ];

            $kode_rekening_sub_kegiatan = $this->input->post('kode_rekening_sub_kegiatan');
            $kode_kegiatan = $this->input->post('kode_kegiatan');
            $kode_program = $this->input->post('kode_program');
            $tahap = $this->input->post('tahap');
            $tahun = $this->input->post('tahun');
            $id_instansi = sbe_crypt($this->input->post('id_instansi'), 'D');
            $where = ['kode_sub_kegiatan' => $kode_rekening_sub_kegiatan, 'kode_kegiatan'=>$kode_kegiatan, 'kode_program'=>$kode_program, 'kode_tahap'=>$tahap,  'tahun'=>$tahun,   'id_instansi' => $id_instansi];

            $identitas_ski        = $this->db->query("SELECT * from v_sub_kegiatan_apbd where id_instansi='$id_instansi' and kode_rekening_sub_kegiatan='$kode_rekening_sub_kegiatan' and kode_tahap='$tahap' and tahun='$tahun'")->row();
                $output['sub_kegiatan']['nama_sub_kegiatan']                  = $identitas_ski->kategori =='Sub Kegiatan SKPD' ? $identitas_ski->nama_sub_kegiatan : $identitas_ski->nama_sub_kegiatan.'<br>'.$identitas_ski ->jenis_sub_kegiatan.' - '.$identitas_ski->keterangan;
                $output['sub_kegiatan']['kategori']                  = $identitas_ski->kategori;



            $permasalahan_sub_kegiatan    = $this->db->get_where('permasalahan_sub_kegiatan', $where);
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




    public function detail_solusi_sub_kegiatan()
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
            $q = $this->db->query("SELECT solusi from solusi_permasalahan_sub_kegiatan where id_solusi_permasalahan_sub_kegiatan='$id_solusi'")->row();
            $output['data']['solusi'] = str_replace('<br />', '', $q->solusi);


            $kode_rekening_sub_kegiatan = $this->input->post('kode_rekening_sub_kegiatan');
            $kode_kegiatan = $this->input->post('kode_kegiatan');
            $kode_program = $this->input->post('kode_program');
            $tahap = $this->input->post('tahap');
            $id_instansi = $this->input->post('id_instansi');
            $where = ['kode_sub_kegiatan' => $kode_rekening_sub_kegiatan, 'kode_kegiatan'=>$kode_kegiatan, 'kode_program'=>$kode_program, 'kode_tahap'=>$tahap,   'id_instansi' => $id_instansi];

            $identitas_ski        = $this->db->query("SELECT * from v_sub_kegiatan_apbd where id_instansi='$id_instansi' and kode_rekening_sub_kegiatan='$kode_rekening_sub_kegiatan' and kode_tahap='$tahap'")->row();
                $output['sub_kegiatan']['nama_sub_kegiatan']                  = $identitas_ski->kategori =='Sub Kegiatan SKPD' ? $identitas_ski->nama_sub_kegiatan : $identitas_ski->nama_sub_kegiatan.'<br>'.$identitas_ski ->jenis_sub_kegiatan.' - '.$identitas_ski->keterangan;
                $output['sub_kegiatan']['kategori']                  = $identitas_ski->kategori;



            $permasalahan_sub_kegiatan    = $this->db->get_where('permasalahan_sub_kegiatan', $where);
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



    public function detail_permasalahan_sub_kegiatan()
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
            $q = $this->db->query("SELECT permasalahan from permasalahan_sub_kegiatan where id_permasalahan_sub_kegiatan='$id_permasalahan'")->row();
            $output['data']['permasalahan'] = str_replace('<br />', '', $q->permasalahan);


            $kode_rekening_sub_kegiatan = $this->input->post('kode_rekening_sub_kegiatan');
            $kode_kegiatan = $this->input->post('kode_kegiatan');
            $kode_program = $this->input->post('kode_program');
            $tahap = $this->input->post('tahap');
            $id_instansi = id_instansi();
            $where = ['kode_sub_kegiatan' => $kode_rekening_sub_kegiatan, 'kode_kegiatan'=>$kode_kegiatan, 'kode_program'=>$kode_program, 'kode_tahap'=>$tahap,   'id_instansi' => id_instansi()];

            $identitas_ski        = $this->db->query("SELECT * from v_sub_kegiatan_apbd where id_instansi='$id_instansi' and kode_rekening_sub_kegiatan='$kode_rekening_sub_kegiatan' and kode_tahap='$tahap'")->row();
                $output['sub_kegiatan']['nama_sub_kegiatan']                  = $identitas_ski->kategori =='Sub Kegiatan SKPD' ? $identitas_ski->nama_sub_kegiatan : $identitas_ski->nama_sub_kegiatan.'<br>'.$identitas_ski ->jenis_sub_kegiatan.' - '.$identitas_ski->keterangan;
                $output['sub_kegiatan']['kategori']                  = $identitas_ski->kategori;



            $permasalahan_sub_kegiatan    = $this->db->get_where('permasalahan_sub_kegiatan', $where);
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



    public function simpan_pengalihan_sub_kegiatan_instansi_apbd_awal_ke_perubahan()
    {
        if (!$this->input->is_ajax_request()) {
            show_404();
        } else {
            $output = [
                'status'    => false,
                'data'      => [],
            ];

            $id_sub_kegiatan_instansi = $this->input->post('id_sub_kegiatan_instansi');
            $ski = $this->db->get_where('sub_kegiatan_instansi', ['id_sub_kegiatan_instansi'=>$id_sub_kegiatan_instansi])->row_array();

            $data_ski_baru = [
                'kode_sub_kegiatan'=>$ski['kode_sub_kegiatan'],
                'kode_kegiatan'=>$ski['kode_kegiatan'],
                'kode_program'=>$ski['kode_program'],
                'kode_bidang_urusan'=>$ski['kode_bidang_urusan'],
                'id_instansi'=>$ski['id_instansi'],
                'kode_tahap'=>4,
                'kategori'=>$ski['kategori'],
                'tambahan_kode_sub_kegiatan'=>$ski['tambahan_kode_sub_kegiatan'],
                'input_by_tambahan_kode_sub_kegiatan'=>$ski['input_by_tambahan_kode_sub_kegiatan'],
                'jenis_sub_kegiatan'=>$ski['jenis_sub_kegiatan'],
                'keterangan'=>$ski['keterangan'],
                'tahun'=>$ski['tahun'],
                'created_on'=>$ski['created_on'],
                'updated_on'=>$ski['updated_on'],
                'created_by'=>$ski['created_by'],
                'updated_by'=>$ski['updated_by'],
                'input_by'=>"Pengalihan APBD Awal Ke APBD Perubahan",
                'status'=>$ski['status'],
            ];


               $where_ask_off = [
                'kode_sub_kegiatan'=>$ski['kode_sub_kegiatan'],
                'kode_kegiatan'=>$ski['kode_kegiatan'],
                'kode_program'=>$ski['kode_program'],
                'kode_bidang_urusan'=>$ski['kode_bidang_urusan'],
                'id_instansi'=>$ski['id_instansi'],
                'tahun'=>$ski['tahun'],
            ];


            $this->db->insert('sub_kegiatan_instansi', $data_ski_baru);
            $this->db->update('sub_kegiatan_instansi', ['status'=>0], ['id_sub_kegiatan_instansi'=>$id_sub_kegiatan_instansi]);
            $this->db->update('anggaran_sub_kegiatan', ['status'=>0], $where_ask_off);


            $output['data'] = $data_ski_baru ;
            $output['status'] = true;


            echo json_encode($output);
        }
    }

    public function akhiri_sub_kegiatan_instansi_apbd_awal()
    {
        if (!$this->input->is_ajax_request()) {
            show_404();
        } else {
            $output = [
                'status'    => false,
                'data'      => [],
            ];

            $id_sub_kegiatan_instansi = $this->input->post('id_sub_kegiatan_instansi');

              $ski = $this->db->get_where('sub_kegiatan_instansi', ['id_sub_kegiatan_instansi'=>$id_sub_kegiatan_instansi])->row_array();

            $where_ask_off = [
                'kode_sub_kegiatan'=>$ski['kode_sub_kegiatan'],
                'kode_kegiatan'=>$ski['kode_kegiatan'],
                'kode_program'=>$ski['kode_program'],
                'kode_bidang_urusan'=>$ski['kode_bidang_urusan'],
                'id_instansi'=>$ski['id_instansi'],
                'tahun'=>$ski['tahun'],
            ];


            $this->db->update('sub_kegiatan_instansi', ['status'=>0], ['id_sub_kegiatan_instansi'=>$id_sub_kegiatan_instansi]);
            $this->db->update('anggaran_sub_kegiatan', ['status'=>0], $where_ask_off);


            $output['status'] = true;


            echo json_encode($output);
        }
    }

    public function hapus_solusi_permasalahan_sub_kegiatan()
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
            $q = $this->db->query("DELETE from solusi_permasalahan_sub_kegiatan where id_solusi_permasalahan_sub_kegiatan='$id_solusi'");

            $output['status'] = true;


            echo json_encode($output);
        }
    }



    public function hapus_permasalahan_sub_kegiatan()
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
            $q = $this->db->query("DELETE from permasalahan_sub_kegiatan where id_permasalahan_sub_kegiatan='$id_permasalahan'");

            $output['status'] = true;


            echo json_encode($output);
        }
    }


    
 public function rule_pagu_sub_kegiatan()
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



 public function rule_ski_teknis()
    {
        
        return [
            [
                'field' => 'kelompok',
                'label' => 'Kelompok',
                'rules' => 'required'
            ],
            [
                'field' => 'keterangan',
                'label' => 'Keterangan',
                'rules' => 'required'
            ]
            
        ];
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



    public function save_ski_teknis()
    {
        if (!$this->input->is_ajax_request()) {
            show_404();
        } else {
            $output    = [
                'success' => false,
                'messages' => []
            ];
            $data_group     = [];
            $data_apbd      = $this->data_apbd_model;
            $validation     = $this->form_validation;
            $validation->set_rules($this->rule_ski_teknis());
            $validation->set_error_delimiters('<p class="text-danger">', '</p>');

            if ($validation->run($this)) {
                $post               = $this->input->post();
                $kode               = $post['kode'];
                $kode_sub_kegiatan  = $post['kode_sub_kegiatan'];
                $kode_kegiatan      = $post['kode_kegiatan'];
                $kode_program       = $post['kode_program'];
                $kode_bidang_urusan = $post['kode_bidang_urusan'];
                $kelompok           = $post['kelompok'];
                $keterangan         = $post['keterangan'];
                $kode_ski_teknis    = $kode_sub_kegiatan.'.'.$kode;
                if ($kode !='') {
                    $cek_kode = $data_apbd->cek_kode_ski(id_instansi(), $kode_ski_teknis, tahapan_apbd());
                    $ditemukan = $cek_kode->num_rows();
                    if ($ditemukan > 0) {
                        $output['error'] = 1;
                        $output['messages'] = 'Gagal menyimpan Sub Kegiatan Teknis. Kode Sub Kegiatan '.$kode_ski_teknis.' Sudah Digunakan';
                    }else{
                        $output['error'] = 0;
                        $data = [
                            'kode_sub_kegiatan'=>$kode_ski_teknis,
                            'kode_kegiatan'=>$kode_kegiatan,
                            'kode_program'=>$kode_program,
                            'kode_bidang_urusan'=>$kode_bidang_urusan,
                            'tambahan_kode_sub_kegiatan'=>$kode,
                            'input_by_tambahan_kode_sub_kegiatan'=>'Manual Input',
                            'jenis_sub_kegiatan'=>$kelompok,
                            'kategori'=>'Unit Pelaksana',
                            'keterangan'=>$keterangan,
                            'id_instansi'=>id_instansi(),
                            'kode_tahap'=>tahapan_apbd(),
                            'tahun'=>tahun_anggaran(),
                            'created_on'=>timestamp(),
                            'created_by'=>id_user(),
                            'input_by '=>'Selected',
                            'status'=>1
                        ];
                        $this->db->insert('sub_kegiatan_instansi',$data); 
                        $output['messages'] = 'Sub Kegiatan Teknis Disimpan ';
                    }
                    $output['found'] = $ditemukan;
                    $output['kode'] = true;
                    # code...
                }else{
                    $cek_kode_ski = $data_apbd->cek_urutan_ski_teknis($kode_sub_kegiatan, id_instansi(), tahapan_apbd());
                    $max_kode = intval($cek_kode_ski->row()->max_kode);
                    $next_kode = $max_kode + 1; 
                    if ($next_kode>0 && $next_kode <10) {
                        $savekode = '00'.$next_kode ;
                    }
                    elseif ($next_kode>=10 && $next_kode <100) {
                        $savekode = '0'.$next_kode ;
                    }else{
                        $savekode = $next_kode ;
                    }

                    $kode_ski_teknis = $kode_sub_kegiatan.'.'.$savekode;
                     $data = [
                            'kode_sub_kegiatan'=>$kode_ski_teknis,
                            'kode_kegiatan'=>$kode_kegiatan,
                            'kode_program'=>$kode_program,
                            'kode_bidang_urusan'=>$kode_bidang_urusan,
                            'tambahan_kode_sub_kegiatan'=>$savekode ,
                            'input_by_tambahan_kode_sub_kegiatan'=>'Automatic Input',
                            'jenis_sub_kegiatan'=>$kelompok,
                            'keterangan'=>$keterangan,
                            'kategori'=>'Unit Pelaksana',
                            'id_instansi'=>id_instansi(),
                            'kode_tahap'=>tahapan_apbd(),
                            'tahun'=>tahun_anggaran(),
                            'created_on'=>timestamp(),
                            'created_by'=>id_user(),
                            'input_by '=>'Selected',
                            'status'=>1
                        ];
                        $this->db->insert('sub_kegiatan_instansi',$data); 
                        $output['messages'] = 'Sub Kegiatan Teknis Disimpan ';

                    $output['maxkode'] = $savekode  ;
                    $output['kode'] = false;

                }
                $output['success'] = true;
            } else {
                $output['success'] = false;
                foreach ($_POST as $key => $value) {
                    $output['messages'][$key] = form_error($key);
                }
            }

                
            echo json_encode($output);
        }
    }



    public function save_edit_ski_teknis()
    {
        if (!$this->input->is_ajax_request()) {
            show_404();
        } else {
            $output    = [
                'success' => false,
                'messages' => []
            ];
            $data_group     = [];
            $data_apbd      = $this->data_apbd_model;
            $validation     = $this->form_validation;
            $validation->set_rules($this->rule_ski_teknis());
            $validation->set_error_delimiters('<p class="text-danger">', '</p>');

            if ($validation->run($this)) {
                $post               = $this->input->post();
                $kode_sub_kegiatan  = $post['kode_sub_kegiatan'];
                $id_sub_kegiatan_instansi  = $post['id_sub_kegiatan_instansi'];
                $kelompok           = $post['kelompok'];
                $keterangan         = $post['keterangan'];
                $data = [
                            'jenis_sub_kegiatan'=>$kelompok,
                            'keterangan'=>$keterangan,
                            'updated_on'=>timestamp(),
                            'updated_by'=>id_user()
                        ];

                $where = [
                            'id_sub_kegiatan_instansi'=>$id_sub_kegiatan_instansi,
                            'kode_sub_kegiatan'=>$kode_sub_kegiatan,
                            'id_instansi'=>id_instansi(),
                            'kode_tahap'=>tahapan_apbd(),
                        ];
                $this->db->update('sub_kegiatan_instansi',$data, $where); 
                $output['tes'] = $post;
                $output['messages'] = 'Sub Kegiatan Teknis Disimpan ';
               
                $output['success'] = true;
            } else {
                $output['success'] = false;
                foreach ($_POST as $key => $value) {
                    $output['messages'][$key] = form_error($key);
                }
            }

                
            echo json_encode($output);
        }
    }


    public function save_anggaran_sub_kegiatan()
    {
        if (!$this->input->is_ajax_request()) {
            show_404();
        } else {
            $output    = [
                'success' => false,
                'messages' => []
            ];
            $data_group     = [];
            $data_apbd     = $this->data_apbd_model;
            $validation     = $this->form_validation;
            $validation->set_rules($this->rule_pagu_sub_kegiatan());
            $validation->set_error_delimiters('<p class="text-danger">', '</p>');



$kode_rekening_sub_kegiatan = $this->input->post('kode_sub_kegiatan');
                $kode_kegiatan = $this->input->post('kode_kegiatan');
                $kode_program = $this->input->post('kode_program');
                $tahap = $this->input->post('tahap');
                $tahun = $this->input->post('tahun');
                $where = ['kode_sub_kegiatan' => $kode_rekening_sub_kegiatan, 'kode_kegiatan'=>$kode_kegiatan, 'kode_program'=>$kode_program, 'kode_tahap'=>$tahap,  'tahun'=>$tahun,   'id_instansi' => id_instansi()];

                $pagu_sub_kegiatan    = $this->db->get_where('anggaran_sub_kegiatan', $where);
            if ($validation->run($this)) {
                $post               = $this->input->post();
                

                // $kode_rekening_sub_kegiatan = $this->input->post('kode_sub_kegiatan');
                // $kode_kegiatan = $this->input->post('kode_kegiatan');
                // $kode_program = $this->input->post('kode_program');
                // $tahap = $this->input->post('tahap');
                // $where = ['kode_sub_kegiatan' => $kode_rekening_sub_kegiatan, 'kode_kegiatan'=>$kode_kegiatan, 'kode_program'=>$kode_program, 'kode_tahap'=>$tahap,   'id_instansi' => id_instansi()];

                // $pagu_sub_kegiatan    = $this->db->get_where('anggaran_sub_kegiatan', $where);
                if ($pagu_sub_kegiatan->num_rows()>0) {
                    $id_paket_pekerjaan = $data_apbd->saveedit_anggaran_sub_kegiatan($where);
                    
                }else{
                    $id_paket_pekerjaan = $data_apbd->save_anggaran_sub_kegiatan();
                }


                    $output['success']     = true;
                    $output['messages'] = "Paket berhasil di simpan";
                    $output['kode_kegiatan'] = $kode_kegiatan;
                    $output['kode_program'] = $kode_program;
                    $output['pengelompokan'] = $this->input->post('pengelompokan');
                
            } else {
                $output['success'] = false;
                foreach ($_POST as $key => $value) {
                    $output['messages'][$key] = form_error($key);
                }
            }
            echo json_encode($output);
        }
    }


    public function save_permasalahan_sub_kegiatan()
    {
        if (!$this->input->is_ajax_request()) {
            show_404();
        } else {
            $output    = [
                'success' => false,
                'messages' => []
            ];
            $data_group     = [];
            $data_apbd     = $this->data_apbd_model;
            $validation     = $this->form_validation;
           
            $validation->set_rules($this->rule_input_permasalahan());
            $validation->set_error_delimiters('<p class="text-danger">', '</p>');
        

            $post               = $this->input->post();
            $kode_rekening_sub_kegiatan = $this->input->post('kode_sub_kegiatan');
            $kode_kegiatan = $this->input->post('kode_kegiatan');
            $kode_program = $this->input->post('kode_program');
            $tahap = $this->input->post('tahap');
            $tahun = $this->input->post('tahun');
            $permasalahan = $this->input->post('permasalahan');




            if ($validation->run($this)) {
                $simpan = $data_apbd->save_permasalahan_sub_kegiatan();
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


    public function saveedit_permasalahan_sub_kegiatan()
    {
        if (!$this->input->is_ajax_request()) {
            show_404();
        } else {
            $output    = [
                'success' => false,
                'messages' => []
            ];
            $data_group     = [];
            $data_apbd     = $this->data_apbd_model;
            $validation     = $this->form_validation;
           
            $validation->set_rules($this->rule_input_permasalahan());
            $validation->set_error_delimiters('<p class="text-danger">', '</p>');
        

            $post               = $this->input->post();
            $kode_rekening_sub_kegiatan = $this->input->post('kode_sub_kegiatan');
            $kode_kegiatan = $this->input->post('kode_kegiatan');
            $kode_program = $this->input->post('kode_program');
            $tahap = $this->input->post('tahap');
            $permasalahan = $this->input->post('permasalahan');




            if ($validation->run($this)) {
                $simpan = $data_apbd->saveedit_permasalahan_sub_kegiatan();
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




    public function save_solusi_permasalahan_sub_kegiatan()
    {
        if (!$this->input->is_ajax_request()) {
            show_404();
        } else {
            $output    = [
                'success' => false,
                'messages' => []
            ];
            $data_group     = [];
            $data_apbd     = $this->data_apbd_model;
            $validation     = $this->form_validation;
           
            $validation->set_rules($this->rule_input_solusi_permasalahan());
            $validation->set_error_delimiters('<p class="text-danger">', '</p>');
        

            $post               = $this->input->post();
            $kode_rekening_sub_kegiatan = $this->input->post('kode_sub_kegiatan');
            $kode_kegiatan = $this->input->post('kode_kegiatan');
            $kode_program = $this->input->post('kode_program');
            $tahap = $this->input->post('tahap');
            $permasalahan = $this->input->post('permasalahan');




            if ($validation->run($this)) {
                $simpan = $data_apbd->save_solusi_permasalahan_sub_kegiatan();
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




    public function saveedit_solusi_permasalahan_sub_kegiatan()
    {
        if (!$this->input->is_ajax_request()) {
            show_404();
        } else {
            $output    = [
                'success' => false,
                'messages' => []
            ];
            $data_group     = [];
            $data_apbd     = $this->data_apbd_model;
            $validation     = $this->form_validation;
           
            $validation->set_rules($this->rule_input_solusi_permasalahan());
            $validation->set_error_delimiters('<p class="text-danger">', '</p>');
        

            $post               = $this->input->post();
            $id_solusi = $this->input->post('id_solusi');
            $kode_rekening_sub_kegiatan = $this->input->post('kode_sub_kegiatan');
            $kode_kegiatan = $this->input->post('kode_kegiatan');
            $kode_program = $this->input->post('kode_program');
            $tahap = $this->input->post('tahap');
            $permasalahan = $this->input->post('permasalahan');




            if ($validation->run($this)) {
                $simpan = $data_apbd->saveedit_solusi_permasalahan_sub_kegiatan();
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

    public function sub_kegiatan_apbd_all()
    {
        if (!$this->input->is_ajax_request()) {
            show_404();
        } else {            
            $tahun = tahun_anggaran();
            $kode_kegiatan  = $this->input->post('kode_kegiatan');
            $where          = ['kode_kegiatan' => $kode_kegiatan,'status'=>1];
            $column_order   = ['', 'nama_sub_kegiatan'];
            $column_search  = ['nama_sub_kegiatan'];
            $order          = ['nama_sub_kegiatan' => 'ASC'];
            $list           = $this->datatables_model->get_datatables('master_sub_kegiatan', $column_order, $column_search, $order, $where);
            $data           = [];
            $no             = $_POST['start'];
            foreach ($list as $lists) {
                $no++;
                $row    = [];
                $row[]     = $no;
                $row[]  = $lists->kode_sub_kegiatan;
                $row[]  = $lists->nama_sub_kegiatan;
                $cek_sub_kegiatan_instansi = $this->data_apbd_model->cek_sub_kegiatan_instansi($lists->kode_sub_kegiatan, $lists->kode_kegiatan, $lists->kode_program, id_instansi());
                $sub_kegiatan_instansi = $cek_sub_kegiatan_instansi->num_rows();
                $data_sub_kegiatan_instansi = $cek_sub_kegiatan_instansi->row_array();
                if ($sub_kegiatan_instansi>0) {
                    $status_sub_kegiatan = "Sudah ditambahkan ke sub kegiatan SKPD anda pada ".pilihan_nama_tahapan($data_sub_kegiatan_instansi['kode_tahap']);
                    $onclick = "hapus_sub_kegiatan_instansi('".$lists->kode_sub_kegiatan."','".$lists->kode_kegiatan."', '".$lists->kode_program."','".tahapan_apbd()."', '".tahun_anggaran()."','all')";
                    $btn    = 'btn btn-danger btn-xs';
                    $fa     = 'fa fa-trash';
                }else{
                    $status_sub_kegiatan = "Belum ditambahkan";
                    $onclick = "tambah_sub_kegiatan_instansi('".$lists->kode_sub_kegiatan."','".$lists->kode_kegiatan."', '".$lists->kode_program."', '".$lists->kode_bidang_urusan."')";
                    $btn    = 'btn btn-info btn-xs';
                    $fa     = 'fa fa-save';

                }

                $row[]  = $status_sub_kegiatan;

                if (jadwal_input_data_dasar()['aktif']==0) {

                        $show_btn = 'btn btn-outline-danger btn-xs';
                        $alert_kunci_input = "Swal.fire('Terkunci','".jadwal_input_data_dasar()['pesan']."','error')";
                        $row[]     =  '<button class="btn btn-outline-danger btn-sm" onclick="'.$alert_kunci_input.'"><i class="'.$fa.'"></i></button> ' ;
                    }else{
                        $show_btn = $btn;
                        $row[]     =  '<button class="'.$show_btn.'" onclick="'.$onclick.'"><i class="'.$fa.'"></i></button>';

                    }

               
                $data[] = $row;
            }

            $output = [
                "draw"              => $_POST['draw'],
                "recordsTotal"      => $this->datatables_model->count_all('master_sub_kegiatan', $where),
                "recordsFiltered"   => $this->datatables_model->count_filtered('master_sub_kegiatan', $column_order, $column_search, $order, $where),
                "data"              => $data,
                'cek'               => $kode_kegiatan
            ];

            echo json_encode($output);
        }
    }
    public function list_pptk()
    {
        if (!$this->input->is_ajax_request()) {
            show_404();
        } else {
            $output = [
                'status'     => false,
                'data'         => [],
                'message'     => ''
            ];

            $id_user_top_parent = $this->input->post('id_user_top_parent');
            $pptk               = $this->master_paket_model->pptk($id_user_top_parent);
            if ($pptk->num_rows() > 0) :
                $output['status']     = true;
                $output['message']     = 'Sukses';
                foreach ($pptk->result() as $key => $value) {
                    $output['data'][$key]['id_user']         = $value->id_user;
                    $output['data'][$key]['nama']             = $value->full_name;
                    $output['data'][$key]['sub_instansi']     = $value->nama_sub_instansi;
                    $output['data'][$key]['jml_keg']         = $this->jumlah_kegiatan($value->id_user);
                    $output['data'][$key]['jml_paket']         = $this->jumlah_paket($value->id_user);
                } 
            else :
                $output['status']     = false;
                $output['message']     = 'Gagal';
            endif;

            echo json_encode($output);
        }
    }

 public function hapus_all_apbd_instansi()
    {
        if (!$this->input->is_ajax_request()) {
            show_404();
        } else {
            $output = [
                'status'    => false,
                'id_pptk'   => '',
                'rekening'  => ''
            ];

            $id_instansi = id_instansi();
            $tahap = tahapan_apbd();
            $jenis = $this->input->post('jenis');
            $where = ['id_instansi'=>$id_instansi, 'kode_tahap'=>$tahap, 'input_by'=>$jenis];
            $data_apbd    = $this->db->get_where('sub_kegiatan_instansi', $where);
            foreach ($data_apbd->result() as $key => $value) {
                $whereski = [
                    'kode_sub_kegiatan'=>$value->kode_sub_kegiatan, 
                    'kode_kegiatan'=>$value->kode_kegiatan, 
                    'kode_program'=>$value->kode_program, 
                    'kode_bidang_urusan'=>$value->kode_bidang_urusan,
                    'id_instansi'=>id_instansi(),
                    'kode_tahap'=>tahapan_apbd()
                ];


                $whereask = [
                    'kode_sub_kegiatan'=>$value->kode_sub_kegiatan, 
                    'kode_kegiatan'=>$value->kode_kegiatan, 
                    'kode_program'=>$value->kode_program, 
                    'kode_bidang_urusan'=>$value->kode_bidang_urusan,
                    'id_instansi'=>id_instansi(),
                    'kode_tahap'=>tahapan_apbd()
                ];

                $whereta = [
                    'kode_rekening_sub_kegiatan'=>$value->kode_sub_kegiatan, 
                    'kode_rekening_kegiatan'=>$value->kode_kegiatan, 
                    'kode_rekening_program'=>$value->kode_program, 
                    'kode_bidang_urusan'=>$value->kode_bidang_urusan,
                    'id_instansi'=>id_instansi(),
                    'kode_tahap'=>tahapan_apbd()
                ];

                $whererk = [
                    'kode_sub_kegiatan'=>$value->kode_sub_kegiatan, 
                    'kode_kegiatan'=>$value->kode_kegiatan, 
                    'kode_program'=>$value->kode_program, 
                    'kode_bidang_urusan'=>$value->kode_bidang_urusan,
                    'id_instansi'=>id_instansi(),
                    'kode_tahap'=>tahapan_apbd()
                ];

                $whereusk = [
                    'kode_rekening_sub_kegiatan'=>$value->kode_sub_kegiatan, 
                    'kode_rekening_kegiatan'=>$value->kode_kegiatan, 
                    'kode_rekening_program'=>$value->kode_program, 
                    'kode_bidang_urusan'=>$value->kode_bidang_urusan,
                    'id_instansi'=>id_instansi()
                ];

                $where_sd = $whereta;
                $userpptk = $this->db->get_where('users_sub_kegiatan', $whereusk);
                if ($userpptk->num_rows()>0) {
                    foreach ($userpptk->result() as $key => $value) {
                        $delete_pptk =   $this->db->delete('users_sub_kegiatan', $whereusk);
                    }
                }


                $wherepaket =  [
                    'kode_rekening_sub_kegiatan' =>$value->kode_sub_kegiatan, 
                    'id_instansi'=>id_instansi(),
                     'kode_rekening_kegiatan'=>$value->kode_kegiatan,
                      'kode_rekening_program'=>$value->kode_program,
                      'kode_bidang_urusan'=>$value->kode_bidang_urusan
                  ];
                $paket = $this->db->get_where('paket_pekerjaan', $wherepaket);
                // var_dump($paket);
                if ($paket->num_rows()>0) {
                    foreach ($paket->result() as $k => $v) {
                        $idpaket = $v->id_paket_pekerjaan;
                        $delete_vol =   $this->db->delete('vol_pelaksanaan_pekerjaan', ['id_paket_pekerjaan'=>$idpaket]);
                        $delete_lokasi =   $this->db->delete('lokasi_paket_pekerjaan', ['id_paket_pekerjaan'=>$idpaket]);
                        $delete_paket =   $this->db->delete('paket_pekerjaan', ['id_paket_pekerjaan'=>$idpaket]);
                        $delete_realisasi =   $this->db->delete('realisasi_fisik', ['id_paket_pekerjaan'=>$idpaket]);
                    }
                }
                
                $this->db->delete('anggaran_sub_kegiatan',$whereask);
                $this->db->delete('target_apbd',$whereta);
                $this->db->delete('realisasi_keuangan',$whererk);
                $this->db->delete('sumber_dana',$where_sd);
                $this->db->delete('sub_kegiatan_instansi',$whereski);

            }
            
           


                $output['status']   = true;
                $this->session->set_flashdata('pesan','<div class="alert alert-info>Data dihapus</div>');
             

            echo json_encode($output);
        }
    }



    public function anggaran_tersedia()
    {
        if (!$this->input->is_ajax_request()) {
            show_404();
        } else {
            $output = [
                'status'     => false,
                'data'         => [],
                'message'     => ''
            ];

            $kode_rekening = $this->input->post('kode_rekening');
            $cek_anggaran_terpakai = $this->master_paket_model->anggaran_kegiatan_terpakai($kode_rekening)->anggaran_terpakai;
            $pagu_kegiatan = $this->master_paket_model->anggaran_kegiatan_terpakai($kode_rekening)->pagu;
                $output['status']     = true;
                $output['data']['anggaran_tersedia']     = $pagu_kegiatan - $cek_anggaran_terpakai;
                $output['message']     = 'Sukses';
            echo json_encode($output);
        }
    }


    protected function jumlah_kegiatan($id_user)
    {
        return $this->db->query("SELECT COUNT(*) AS jml FROM users_kegiatan WHERE id_user = " . $id_user)->row()->jml;
    }

    protected function jumlah_paket($id_user)
    {
        return $this->db->query("SELECT COUNT(*) AS jml FROM paket_pekerjaan WHERE id_pptk = " . $id_user)->row()->jml;
    }

    public function list_kegiatan()
    {
        if (!$this->input->is_ajax_request()) {
            show_404();
        } else {
            $output = [
                'status'     => false,
                'data'         => [],
                'message'     => '',
                'kedudukan' => ''
            ];
            $id_user     = $this->input->post('id_user');
            $where      = [
                'id_user' => $id_user,
                'id_instansi' => id_instansi(),
                'kode_tahap' => tahapan_apbd()
            ];

            $kegiatan     = $this->master_paket_model->kegiatan_pptk($id_user, id_instansi(), tahapan_apbd());
            if ($kegiatan->num_rows() > 0) :
                $output['status']     = true;
                $output['message']     = 'Sukses';
                foreach ($kegiatan->result() as $key => $value) {
                    $output['data'][$key]['id_pptk']     = $value->id_user;
                    $output['data'][$key]['rekening']     = $value->kode_rekening_kegiatan;
                    $output['data'][$key]['kode_urusan'] = $value->kode_urusan;
                    $output['data'][$key]['kegiatan']     = $value->nama_kegiatan;
                    
                    $output['data'][$key]['pagu']     = number_format($value->pagu);
                    $output['data'][$key]['pagu_kegiatan']     = ($value->pagu);
                    $cek_anggaran_terpakai = $this->master_paket_model->anggaran_kegiatan_terpakai($value->kode_rekening_kegiatan)->anggaran_terpakai;
                    $output['data'][$key]['anggaran_terpakai']     = $cek_anggaran_terpakai;
                    $output['data'][$key]['anggaran_tersedia']     = $value->pagu - $cek_anggaran_terpakai;
                    $output['data'][$key]['jml_paket']     = $value->jml_paket;
                }

                $output['kedudukan'] = $this->session->userdata('kedudukan');
            else :
                $output['status']     = false;
                $output['message']     = 'Gagal';
            endif;

            echo json_encode($output);
        }
    }

    public function list_metode()
    {
        if (!$this->input->is_ajax_request()) {
            show_404();
        } else {
            $output = [
                'status'     => false,
                'data'         => [],
                'message'     => ''
            ];
            $jenis_paket     = $this->input->post('jenis_paket');
            $metode         = $this->db->get_where('metode', ['jenis_paket' => $jenis_paket]);
            if ($metode->num_rows() > 0) {
                $output['status']     = true;
                $output['message']     = 'Sukses';
                foreach ($metode->result() as $key => $value) {
                    $output['data'][$key]['id']         = $value->id_metode;
                    $output['data'][$key]['metode']     = $value->metode;
                }
            } else {
                $output['status']     = false;
                $output['message']     = 'Gagal';
            }

            echo json_encode($output);
        }
    }
    public function list_provinsi()
    {
        if (!$this->input->is_ajax_request()) {
            show_404();
        } else {
            $output = [
                'status'     => false,
                'data'         => [],
                'message'     => ''
            ];
            $jenis_paket     = $this->input->post('jenis_paket');
            $prov         = $this->db->get('provinsi');
            if ($prov->num_rows() > 0) {
                $output['status']     = true;
                $output['message']     = 'Sukses';
                foreach ($prov->result() as $key => $value) {
                    $output['data'][$key]['id_provinsi']         = $value->id_provinsi;
                    $output['data'][$key]['provinsi']     = $value->nama_provinsi;
                }
            } else {
                $output['status']     = false;
                $output['message']     = 'Gagal';
            }

            echo json_encode($output);
        }
    }

    public function list_kab_kota()
    {
        if (!$this->input->is_ajax_request()) {
            show_404();
        } else {
            $output = [
                'status'     => false,
                'data'         => [],
                'message'     => ''
            ];
            // $id_paket    = $this->input->post('id_paket');
            $id_provinsi    = $this->input->post('id_provinsi');
            // if ($id_paket) {
            //     $kab_kota = $this->db->query("SELECT * FROM v_kab_kota WHERE id_kab_kota NOT IN (SELECT id_kab_kota FROM lokasi_paket_pekerjaan WHERE id_paket_pekerjaan = {$id_paket})");
            // } else {
            //     $kab_kota = $this->db->query("SELECT * FROM v_kab_kota");
            // }
                $kab_kota = $this->db->query("SELECT id_kota, nama_kota FROM kota where id_provinsi = '$id_provinsi'");

            if ($kab_kota->num_rows() > 0) {
                $output['status']     = true;
                $output['message']     = 'Sukses';
                foreach ($kab_kota->result() as $key => $value) {
                    $output['data'][$key]['id']         = $value->id_kota;
                    $output['data'][$key]['kab_kota']     = $value->nama_kota;
                }
            } else {
                $output['status']     = false;
                $output['message']     = 'Gagal';
            }

            echo json_encode($output);
        }
    }
    public function list_kecamatan()
    {
        if (!$this->input->is_ajax_request()) {
            show_404();
        } else {
            $output = [
                'status'     => false,
                'data'         => [],
                'message'     => ''
            ];
            $id_paket    = $this->input->post('id_paket');
            $id_kab_kota    = $this->input->post('id_kab_kota');
            // if ($id_paket) {
            //     $kab_kota = $this->db->query("SELECT * FROM kecamatan WHERE kecamatan NOT IN (SELECT id_kab_kota FROM lokasi_paket_pekerjaan WHERE id_paket_pekerjaan = {$id_paket})");
            // } else {
            // }
                $kec = $this->db->query("SELECT * FROM kecamatan where id_kota = '$id_kab_kota'");

            if ($kec->num_rows() > 0) {
                $output['status']     = true;
                $output['message']     = 'Sukses';
                foreach ($kec->result() as $key => $value) {
                    $output['data'][$key]['id']         = $value->id_kecamatan;
                    $output['data'][$key]['kecamatan']     = $value->nama_kecamatan;
                }
            } else {
                $output['status']     = false;
                $output['message']     = 'Gagal';
            }

            echo json_encode($output);
        }
    }

    public function list_kec_kel()
    {
        if (!$this->input->is_ajax_request()) {
            show_404();
        } else {
            $output = [
                'status'     => false,
                'data'         => [],
                'message'     => ''
            ];
            $id_kab_kota     = $this->input->post('id_kab_kota');
            $kec_kel         = $this->db->get_where('v_kec_kel', ['id_kab_kota' => $id_kab_kota]);
            if ($kec_kel->num_rows() > 0) {
                $output['status']     = true;
                $output['message']     = 'Sukses';
                foreach ($kec_kel->result() as $key => $value) {
                    $output['data'][$key]['id']         = $value->id_kec_kel;
                    $output['data'][$key]['kec_kel']     = $value->nama;
                }
            } else {
                $output['status']     = false;
                $output['message']     = 'Gagal';
            }

            echo json_encode($output);
        }
    }

    public function rules_save($jenis_paket)
    {
        if ($jenis_paket=='RUTIN') {
            $rule_pagu = 'required|trim';
        }else{
            $rule_pagu = 'required|trim|greater_than[0]';
        }
        return [
            [
                'field' => 'nama_paket',
                'label' => 'Nama Paket',
                'rules' => 'required|trim|callback_valid_nama_paket'
            ],
            [
                'field' => 'jenis_paket',
                'label' => 'Jenis Paket',
                'rules' => 'required'
            ],
            [
                'field' => 'pagu',
                'label' => 'Pagu Paket',
                'rules' => $rule_pagu
            ]
        ];
    }

    public function rules_lokasi()
    {
        
        return [
            [
                'field' => 'id_provinsi',
                'label' => 'Provinsi',
                'rules' => 'required'
            ],
            [
                'field' => 'id_kab_kota',
                'label' => 'Kab Kota',
                'rules' => 'required'
            ],
            [
                'field' => 'id_kecamatan',
                'label' => 'Kecamatan',
                'rules' => 'required'
            ]
        ];
    }

    public function valid_nama_paket($nama_paket)
    {
        $cek = $this->db->query("SELECT * FROM paket_pekerjaan WHERE nama_paket = '{$nama_paket}' AND id_instansi = " . id_instansi())->num_rows();
        if ($cek > 0) {
            $this->form_validation->set_message('valid_nama_paket', "Nama Paket sudah ada sebelumnya !");
            return FALSE;
        } else {
            return TRUE;
        }
    }

  
    public function hapus_sub_kegiatan_instansi()
    {
        if (!$this->input->is_ajax_request()) {
            show_404();
        } else {
            $output = [
                'status'    => false,
                'id_pptk'   => '',
                'rekening'  => ''
            ];

            $kode_sub_kegiatan = $this->input->post('kode_sub_kegiatan');
            $kode_kegiatan = $this->input->post('kode_kegiatan');
            $kode_program = $this->input->post('kode_program');
            $tahap = $this->input->post('tahap');
            $tahun = $this->input->post('tahun');

            $where      = ['kode_sub_kegiatan' => $kode_sub_kegiatan, 'id_instansi'=>id_instansi(), 'kode_kegiatan'=>$kode_kegiatan, 'kode_program'=>$kode_program, 'kode_tahap'=>$tahap, 'tahun'=>$tahun];
            $wheretarget      = ['kode_rekening_sub_kegiatan' => $kode_sub_kegiatan, 'id_instansi'=>id_instansi(), 'kode_tahap'=>$tahap,  'kode_rekening_kegiatan'=>$kode_kegiatan, 'kode_rekening_program'=>$kode_program, 'tahun'=>$tahun];
            $sub_kegiatan    = $this->db->get_where('sub_kegiatan_instansi', $where);
           
            if ($sub_kegiatan->num_rows() > 0) {
              
                          


                $wherepaket =  ['kode_rekening_sub_kegiatan' => $kode_sub_kegiatan, 'id_instansi'=>id_instansi(), 'kode_rekening_kegiatan'=>$kode_kegiatan, 'kode_rekening_program'=>$kode_program, 'kode_tahap'=>$tahap, 'tahun'=>$tahun];
                $where_usk =  ['kode_rekening_sub_kegiatan' => $kode_sub_kegiatan, 'id_instansi'=>id_instansi(), 'kode_rekening_kegiatan'=>$kode_kegiatan, 'kode_rekening_program'=>$kode_program, 'kode_tahap'=>$tahap, 'tahun_anggaran'=>$tahun];
                $paket = $this->db->get_where('paket_pekerjaan', $wherepaket);
                $userpptk = $this->db->get_where('users_sub_kegiatan', $where_usk);
                if ($paket->num_rows()>0) {
                    foreach ($paket->result() as $key => $value) {
                        $idpaket = $value->id_paket_pekerjaan;
                        $delete_vol =   $this->db->delete('vol_pelaksanaan_pekerjaan', ['id_paket_pekerjaan'=>$idpaket]);
                        $delete_lokasi =   $this->db->delete('lokasi_paket_pekerjaan', ['id_paket_pekerjaan'=>$idpaket]);
                        $delete_paket =   $this->db->delete('paket_pekerjaan', ['id_paket_pekerjaan'=>$idpaket]);
                        $delete_realisasi =   $this->db->delete('realisasi_fisik', ['id_paket_pekerjaan'=>$idpaket]);
                    }
                }
                if ($userpptk->num_rows()>0) {
                    $where_usk =  ['kode_rekening_sub_kegiatan' => $kode_sub_kegiatan, 'id_instansi'=>id_instansi(), 'kode_rekening_kegiatan'=>$kode_kegiatan, 'kode_rekening_program'=>$kode_program, 'kode_tahap'=>$tahap, 'tahun_anggaran'=>$tahun];
                    foreach ($userpptk->result() as $key => $value) {
                        $delete_pptk =   $this->db->delete('users_sub_kegiatan', $where_usk);
                    }
                }

                $data_ski = $sub_kegiatan->row();

                 $whererk = [
                    'kode_sub_kegiatan'=>$data_ski->kode_sub_kegiatan, 
                    'kode_kegiatan'=>$data_ski->kode_kegiatan, 
                    'kode_program'=>$data_ski->kode_program, 
                    'kode_bidang_urusan'=>$data_ski->kode_bidang_urusan,
                    'id_instansi'=>id_instansi(),
                    'kode_tahap'=>$tahap,
                     'tahun'=>$tahun
                ];

                $where_sd = $wheretarget;

                $this->db->delete('realisasi_keuangan',$whererk);
                $this->db->delete('sumber_dana',$where_sd);
                $this->db->delete('anggaran_sub_kegiatan',$where);            
                $this->db->delete('target_apbd',$wheretarget);  
                $this->db->delete('sub_kegiatan_instansi',$where);            
                $output['status']   = true;
                $output['kode_kegiatan']  = $kode_kegiatan;
                $output['kode_program']  = $kode_program;
                
            }

            echo json_encode($output);
        }
    }




    public function tambah_sub_kegiatan_instansi()
    {
        if (!$this->input->is_ajax_request()) {
            show_404();
        } else {
            $output = [
                'status'    => false,
                'id_pptk'   => '',
                'rekening'  => ''
            ];

            $kode_sub_kegiatan = $this->input->post('kode_sub_kegiatan');
            $kode_kegiatan = $this->input->post('kode_kegiatan');
            $kode_program = $this->input->post('kode_program');
            $kode_bidang_urusan = $this->input->post('kode_bidang_urusan');
            $tahun = tahun_anggaran();
            $where      = ['kode_sub_kegiatan' => $kode_sub_kegiatan, 'id_instansi'=>id_instansi(), 'kode_kegiatan'=>$kode_kegiatan, 'kode_program'=>$kode_program, 'tahun'=>$tahun];
            $sub_kegiatan    = $this->db->get_where('sub_kegiatan_instansi', $where);
            $data_sub_kegiatan = $sub_kegiatan->row_array();
            if ($sub_kegiatan->num_rows() == 0) {
                $data = [
                    'kode_sub_kegiatan'=>$kode_sub_kegiatan,
                    'kode_kegiatan'=>$kode_kegiatan,
                    'kode_program'=>$kode_program,
                    'kode_bidang_urusan'=>$kode_bidang_urusan,
                    'kategori'=>'Sub Kegiatan SKPD',
                    'id_instansi'=>id_instansi(),
                    'kode_tahap'=>tahapan_apbd(),
                    'tahun'=>tahun_anggaran(),
                    'created_on'=>timestamp(),
                    'created_by'=>id_user(),
                    'input_by '=>'Selected',
                    'status'=>1
                ];
                $this->db->insert('sub_kegiatan_instansi',$data);            

                $output['status']   = true;
                $output['kode_kegiatan']  = $kode_kegiatan;
                $output['kode_program']  = $kode_program;
                
            }

            echo json_encode($output);
        }
    }



    public function hapus_export_paket()
    {
        if (!$this->input->is_ajax_request()) {
            show_404();
        } else {
            $output = [
                'status'    => false,
                'id_pptk'   => '',
                'rekening'  => ''
            ];

            $id_instansi = id_instansi();
            $where = ['input_by'=>"Export Excel", 'id_instansi'=>$id_instansi];
            $paket_pekerjaan    = $this->db->get_where('paket_pekerjaan', $where);
            
            if ($paket_pekerjaan->num_rows() > 0) {
                $primary_folder         = './sbe_files_data/';
                foreach ($paket_pekerjaan->result() as $key => $value) {
                    $id_paket_pekerjaan = $value->id_paket_pekerjaan;
                    $directory              = [
                        $this->sbe_tahun_anggaran(),
                        slug($this->sbe_nama_instansi(id_instansi())),
                        'REALISASI-FISIK',
                        $id_paket_pekerjaan,
                    ];
                    $list_directory         = $this->sbe_directory($primary_folder, $directory);

                $this->sbe_delete_files($list_directory);
                $this->db->delete('realisasi_fisik', ['id_paket_pekerjaan' => $id_paket_pekerjaan]);
                $this->db->delete('vol_pelaksanaan_pekerjaan', ['id_paket_pekerjaan' => $id_paket_pekerjaan]);
                $this->db->delete('paket_pekerjaan', ['id_paket_pekerjaan' => $id_paket_pekerjaan]);
                }

                $output['status']   = true;
                // $output['id_pptk']  = $data['id_pptk'];
                // $output['rekening'] = $data['kode_rekening_kegiatan'];
            }

            echo json_encode($output);
        }
    }





    public function export_apbd_instansi()
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
                'export_apbd',
               id_instansi(),
            ];
            $list_directory = $this->sbe_directory($primary_folder, $directory);

            if (!file_exists($list_directory)) {
                mkdir($list_directory, 0777, TRUE);
            }
            // untuk menghapus file sebelumnya
        
            // untuk menghapus file sebelumnya

            $namafiledisimpan = "DataApbd_".id_instansi()."_".date('Ymdhis');
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
                $apbd             = $loadexcel->setActiveSheetIndex(1)->toArray(true, true, true ,true);
                
                $this->db->trans_start();

                $data_apbd = array();
                $id_instansi = id_instansi();
                $tahap = tahapan_apbd();
                $numrow = 1;
                $error = 0;
                $pesan = "";
                foreach($apbd as $row){
                            if($numrow > 3){
                                $ksk = str_replace(' ', '', trim($row['A']));
                                $pecah = explode('.', $ksk);
                                @$bu = $pecah[0].'.'.$pecah[1];
                                @$program = $pecah[0].'.'.$pecah[1].'.'.$pecah[2];
                                @$kegiatan = $pecah[0].'.'.$pecah[1].'.'.$pecah[2].'.'.$pecah[3].'.'.$pecah[4];

                                // $ksk = str_replace(' ', '', $ksk);
                                // $program = str_replace(' ', '', $program);
                                // $kegiatan = str_replace(' ', '', $kegiatan);
                                $cek_msk = $this->db->query("SELECT kode_sub_kegiatan from master_sub_kegiatan where kode_sub_kegiatan='$ksk'")->num_rows();
                                if ($cek_msk==0) {
                                    $error = $error +1;
                                    $pesan .="Kode sub kegiatan dengan kode $ksk tidak ditemukan pada data master sub kegiatan. kesalahan pada baris ".$numrow.'<br>';
                                    $bariserror = $numrow;
                                }else{
                                    $cek_ski = $this->db->query("SELECT * from sub_kegiatan_instansi where id_instansi='$id_instansi' and kode_tahap='$tahap' and kode_sub_kegiatan='$ksk'")->num_rows();
                                    // data sub kegiatan instansi
                                    $i_ski = array(
                                        'kode_sub_kegiatan'      => $ksk,
                                        'kode_kegiatan'      => $kegiatan,
                                        'kode_program'      => $program,
                                        'kode_bidang_urusan'      => $bu,
                                        'id_instansi'      => $id_instansi,
                                        'kategori'      => 'Sub Kegiatan SKPD',
                                        'kode_tahap'      => tahapan_apbd(),
                                        'tahun'      => tahun_anggaran(),
                                        'created_on'      => timestamp(),
                                        'created_by'      => id_user(),
                                        'input_by'      => 'Export Excel'
                                    );

                                      $bo_bp      =str_replace(',', '',$row['B']);
                                        $bo_bbj     =str_replace(',', '',$row['C']);
                                        $bo_bs      =str_replace(',', '',$row['D']);
                                        $bo_bh      =str_replace(',', '',$row['E']);
                                        $bm_bmt     =str_replace(',', '',$row['F']);
                                        $bm_bmpm        =str_replace(',', '',$row['G']);
                                        $bm_bmgb        =str_replace(',', '',$row['H']);
                                        $bm_bmjji       =str_replace(',', '',$row['I']);
                                        $bm_bmatl       =str_replace(',', '',$row['J']);
                                        $btt        =str_replace(',', '',$row['K']);
                                        $bt_bbh     =str_replace(',', '',$row['L']);
                                        $bt_bbk      =str_replace(',', '',$row['M']);


                                        $r_bo = ($bo_bp + $bo_bbj + $bo_bs + $bo_bh);
                                        $r_bm = ($bm_bmt + $bm_bmpm + $bm_bmgb + $bm_bmjji + $bm_bmatl);
                                        $r_btt = $btt;
                                        $r_bt = ($bt_bbh + $bt_bbk);




                                        // data anggaran 
                                        $i_ask = array(
                                            'kode_sub_kegiatan'      => trim($ksk),
                                            'kode_kegiatan'      => trim($kegiatan),
                                            'kode_program'      => trim($program),
                                            'kode_bidang_urusan'      => trim($bu),
                                            'id_instansi'      => id_instansi(),
                                            'kode_tahap'      => $tahap,
                                            'bo_bp'      => $row['B'] ==1 ? 0 : $bo_bp,
                                            'bo_bbj'      => $row['C'] ==1 ? 0 : $bo_bbj,
                                            'bo_bs'      => $row['D'] ==1 ? 0 : $bo_bs,
                                            'bo_bh'      => $row['E'] ==1 ? 0 : $bo_bh,
                                            'bm_bmt'      => $row['F'] ==1 ? 0 : $bm_bmt,
                                            'bm_bmpm'      => $row['G'] ==1 ? 0 : $bm_bmpm,
                                            'bm_bmgb'      => $row['H'] ==1 ? 0 : $bm_bmgb,
                                            'bm_bmjji'      => $row['I'] ==1 ? 0 : $bm_bmjji,
                                            'bm_bmatl'      => $row['J'] ==1 ? 0 : $bm_bmatl,
                                            'btt'      => $row['K'] ==1 ? 0 : $btt,
                                            'bt_bbh'      => $row['L'] ==1 ? 0 : $bt_bbh,
                                            'bt_bbk'      => $row['M'] ==1 ? 0 : $bt_bbk,
                                            'realisasikan_bo'      => $r_bo ==4 ? 0 : 1,
                                            'realisasikan_bm'      => $r_bm ==5 ? 0 : 1,
                                            'realisasikan_btt'      => $r_btt ==1 ? 0 : 1,
                                            'realisasikan_bt'      => $r_bt ==2 ? 0 : 1,
                                            'tahun'      => tahun_anggaran(),
                                            'created_on'      => timestamp(),
                                            'created_by'      => id_user(),
                                           
                                            'input_by'      => 'Export Excel'
                                        );
                                        $u_ask = array(
                                            'bo_bp'      => $row['B'] ==1 ? 0 : $bo_bp,
                                            'bo_bbj'      => $row['C'] ==1 ? 0 : $bo_bbj,
                                            'bo_bs'      => $row['D'] ==1 ? 0 : $bo_bs,
                                            'bo_bh'      => $row['E'] ==1 ? 0 : $bo_bh,
                                            'bm_bmt'      => $row['F'] ==1 ? 0 : $bm_bmt,
                                            'bm_bmpm'      => $row['G'] ==1 ? 0 : $bm_bmpm,
                                            'bm_bmgb'      => $row['H'] ==1 ? 0 : $bm_bmgb,
                                            'bm_bmjji'      => $row['I'] ==1 ? 0 : $bm_bmjji,
                                            'bm_bmatl'      => $row['J'] ==1 ? 0 : $bm_bmatl,
                                            'btt'      => $row['K'] ==1 ? 0 : $btt,
                                            'bt_bbh'      => $row['L'] ==1 ? 0 : $bt_bbh,
                                            'bt_bbk'      => $row['M'] ==1 ? 0 : $bt_bbk,
                                            'realisasikan_bo'      => $r_bo ==4 ? 0 : 1,
                                            'realisasikan_bm'      => $r_bm ==5 ? 0 : 1,
                                            'realisasikan_btt'      => $r_btt ==1 ? 0 : 1,
                                            'realisasikan_bt'      => $r_bt ==2 ? 0 : 1,
                                            'tahun'      => tahun_anggaran(),
                                            'updated_on'      => timestamp(),
                                            'updated_by'      => id_user(),
                                           
                                            'input_by'      => 'Export Excel'
                                        );
                                        $where_ask = [
	                                        'kode_sub_kegiatan'      => trim($ksk),
                                            'kode_kegiatan'      => trim($kegiatan),
                                            'kode_program'      => trim($program),
                                            'kode_bidang_urusan'      => trim($bu),
                                            'id_instansi'      => id_instansi(),
                                            'kode_tahap'      => $tahap
                                        ];
                                        $cek_ask = $this->db->get_where('anggaran_sub_kegiatan', $where_ask)->num_rows();
                                    if ($cek_ski==0) {
                                        // // input ke sub kegiatan
                                        // $this->db->insert('sub_kegiatan_instansi', $i_ski);
                                        // input ke anggaran sub kegiatan
                                        if ($cek_ask>0) {
	                                        $this->db->update('anggaran_sub_kegiatan', $i_ask, $where);
                                        }else{
	                                        $this->db->insert('anggaran_sub_kegiatan', $i_ask);
                                        }
                                    }else{
                                        $error = $error +1;
                                        $pesan .="Kode sub kegiatan dengan kode : ".$ksk." tidak ditambahkan karena sudah tersimpan di dalam sistem. Kesalahan pada baris ".$numrow.' <br>';
                                        $bariserror = $numrow;
                                    }
                                }




                                    // array_push($data_apbd, array(
                                      
                                    //     'kode_sub_kegiatan'      => $ksk,
                                    //     'kode_kegiatan'      => $kegiatan,
                                    //     'kode_program'      => $program,
                                    //     'kode_bidang_urusan'      => $bu,
                                    //     'id_instansi'      => $id_instansi,
                                    //     'kode_tahap'      => tahapan_apbd(),
                                    //     'tahun'      => tahun_anggaran(),
                                    //     'created_on'      => timestamp(),
                                    //     'created_by'      => id_user(),
                                    //     'input_by'      => 'Export Excel'
                                    // ));
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
                    $pesan_flashdata = '<div class="alert alert-info">'.$pesan.'</div>';
                    $this->session->set_flashdata('pesan', $pesan_flashdata);
                    redirect('data_apbd/setting');
                    # code...
                }else{
                    $this->db->trans_commit();
                    $pesan_flashdata = '<div class="alert alert-info">Data APBD berhasil di export</div>';
                    $this->session->set_flashdata('pesan', $pesan_flashdata);
                    redirect('data_apbd');
                    // $pesan_flashdata = '<div class="alert alert-info">Program berhail di export</div>';

                }
            }
            // $output['cek'] = $list_directory;
            // echo json_encode($output);
        }
    }

// ================================================================================================================================
// Bagian pengusulan data APBD


    public function dt_usulan_program()
    {
        if (!$this->input->is_ajax_request()) {
            show_404();
        } else {
            $id_instansi = id_instansi();
            $where             = array('id_instansi_pengusul'=>$id_instansi);
            $column_order   = array('', 'nama_program', 'kode_program');
            $column_search  = array('nama_program', 'kode_program');
            $order = array('status' => 'ASC');
            $list = $this->datatables_model->get_datatables('master_program', $column_order, $column_search, $order, $where);
            $data = array();
            $no = $_POST['start'];
            foreach ($list as $lists) {

                $status         = ["Pengusulan","Disetujui Admin","Ditolak Admin"];
              
                $no++;
                $row            = array();
                $row[]          = $no;
                $row[]          = $lists->kode_program;
                $row[]          = $lists->nama_program;
                    if ($lists->status=='0') {
                        $row[]          = $status[$lists->status];
                        $row[]  = '<button class="btn btn-info btn-sm" onclick="edit_program(' . "'" . $lists->id_program . "'," . ')"><i class="fas fa-edit"></i></button> <button class="btn btn-danger btn-sm" onclick="delete_program(' . "'" . $lists->id_program . "','" .$lists->nama_program. "')\"" .'><i class="fa fa-times"></i></button>';
                    }
                    if ($lists->status=='2') {
                        $row[]          = $status[$lists->status].'<br>Alasan : '.$lists->keterangan;
                        $row[]  = '<button class="btn btn-info btn-sm" onclick="edit_program(' . "'" . $lists->id_program . "'," . ')"><i class="fas fa-edit"></i></button> <button class="btn btn-danger btn-sm" onclick="delete_program(' . "'" . $lists->id_program . "','" .$lists->nama_program. "')\"" .'><i class="fa fa-times"></i></button>';
                    }else{
                        $row[]          = $status[$lists->status];
                        $row[]          ="";

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

                $status         = ["Pengusulan","Disetujui Admin","Ditolak Admin"];
            $where             = array('id_instansi_pengusul'=>$id_instansi);
            $column_order   = array('', 'nama_kegiatan', 'kode_kegiatan');
            $column_search  = array('nama_kegiatan', 'kode_kegiatan');
            $order = array('kode_kegiatan' => 'ASC');
            $list = $this->datatables_model->get_datatables('master_kegiatan', $column_order, $column_search, $order, $where);
            $data = array();
            $no = $_POST['start'];
            foreach ($list as $lists) {

              
                $no++;
                $row            = array();
                $row[]          = $no;
                $row[]          = $lists->kode_kegiatan;
                $row[]          = $lists->nama_kegiatan;
                if ($lists->status=='0') {
                        $row[]          = $status[$lists->status];
                        $row[]  = '<button class="btn btn-info btn-sm" onclick="edit_kegiatan(' . "'" . $lists->id_kegiatan . "'," . ')"><i class="fas fa-edit"></i></button> <button class="btn btn-danger btn-sm" onclick="delete_kegiatan(' . "'" . $lists->id_kegiatan . "','" .$lists->nama_kegiatan. "')\"" .'><i class="fa fa-times"></i></button>';
                    }
                    if ($lists->status=='2') {
                        $row[]          = $status[$lists->status].'<br>Alasan : '.$lists->keterangan;
                        $row[]  = '<button class="btn btn-info btn-sm" onclick="edit_kegiatan(' . "'" . $lists->id_kegiatan . "'," . ')"><i class="fas fa-edit"></i></button> <button class="btn btn-danger btn-sm" onclick="delete_kegiatan(' . "'" . $lists->id_kegiatan . "','" .$lists->nama_kegiatan. "')\"" .'><i class="fa fa-times"></i></button>';
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
            $where             = array('id_instansi_pengusul'=>$id_instansi);
            $column_order   = array('', 'nama_sub_kegiatan', 'kode_sub_kegiatan');
            $column_search  = array('nama_sub_kegiatan', 'kode_sub_kegiatan');
            $order = array('kode_sub_kegiatan' => 'ASC');
            $list = $this->datatables_model->get_datatables('master_sub_kegiatan', $column_order, $column_search, $order, $where);
            $data = array();
            $no = $_POST['start'];
             $status         = ["Pengusulan","Disetujui Admin","Ditolak Admin"];
            foreach ($list as $lists) {

              
                $no++;
                $row            = array();
                $row[]          = $no;
                $row[]          = $lists->kode_sub_kegiatan;
                $row[]          = $lists->nama_sub_kegiatan;
                if ($lists->status=='0') {
                        $row[]          = $status[$lists->status];
                        $row[]  = '<button class="btn btn-info btn-sm" onclick="edit_sub_kegiatan(' . "'" . $lists->id_sub_kegiatan . "'," . ')"><i class="fas fa-edit"></i></button> <button class="btn btn-danger btn-sm" onclick="delete_sub_kegiatan(' . "'" . $lists->id_sub_kegiatan . "','" .$lists->nama_sub_kegiatan. "')\"" .'><i class="fa fa-times"></i></button>';
                    }
                    if ($lists->status=='2') {
                        $row[]          = $status[$lists->status].'<br>Alasan : '.$lists->keterangan;
                        $row[]  = '<button class="btn btn-info btn-sm" onclick="edit_sub_kegiatan(' . "'" . $lists->id_sub_kegiatan . "'," . ')"><i class="fas fa-edit"></i></button> <button class="btn btn-danger btn-sm" onclick="delete_sub_kegiatan(' . "'" . $lists->id_sub_kegiatan . "','" .$lists->nama_sub_kegiatan. "')\"" .'><i class="fa fa-times"></i></button>';
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
                $post                       = $this->input->post();
                $kode = trim(str_replace(' ', '', $post['kode']));
                $id_program = $post['id'];
                $pecah = explode('.', $kode);
                $j_pecah = count($pecah);
                if ($j_pecah==3) {
                    $query_cek_program=$this->db->query("SELECT * from master_program where kode_program='$kode' and status !=1 and id_program !='$id_program'");
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
                        $id_user    = $model->saveedit_master_program();
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
                $output['messages']['kode'] = '<p class="text-danger">Penulisan kode kegiatan salah.<br>Silahkan lihat cara penginputan bagian usulkan kegiatan </p>';
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
                $post                       = $this->input->post();
                $kode = trim(str_replace(' ', '', $post['kode']));
                $id_kegiatan = $post['id'];
                $pecah = explode('.', $kode);
                $j_pecah = count($pecah);
                if ($j_pecah==5) {
                    $query_cek_kegiatan=$this->db->query("SELECT * from master_kegiatan where kode_kegiatan='$kode' and status !=1 and id_kegiatan !='$id_kegiatan'");
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
                        $id_user    = $model->saveedit_master_kegiatan();
                        $output['success']     = true;

                    }
                 
                }else{
                $output['success']     = false;
                $output['messages']['kode'] = '<p class="text-danger">Penulisan kode kegiatan salah.<br>Silahkan lihat cara penginputan bagian usulkan kegiatan </p>';
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

                    }
                 
                }else{
                $output['success']     = false;
                $output['messages']['kode'] = '<p class="text-danger">Penulisan kode sub_kegiatan salah.<br>Silahkan lihat cara penginputan bagian usulkan sub_kegiatan </p>';
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
                $post                       = $this->input->post();
                $kode = trim(str_replace(' ', '', $post['kode']));
                $id_sub_kegiatan = $post['id'];
                $pecah = explode('.', $kode);
                $j_pecah = count($pecah);
                if ($j_pecah==6) {
                    $query_cek_sub_kegiatan=$this->db->query("SELECT * from master_sub_kegiatan where kode_sub_kegiatan='$kode' and status !=1 and id_sub_kegiatan !='$id_sub_kegiatan'");
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
                        $id_user    = $model->saveedit_master_sub_kegiatan();
                        $output['success']     = true;

                    }
                 
                }else{
                $output['success']     = false;
                $output['messages']['kode'] = '<p class="text-danger">Penulisan kode sub_kegiatan salah.<br>Silahkan lihat cara penginputan bagian usulkan sub_kegiatan </p>';
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



}
