<?php

/**
 * Author     : Alfikri, M.Kom
 * Created By : Alfikri, M.Kom
 * E-Mail     : alfikri.name@gmail.com
 * No HP      : 081277337405
 * Class      : Validasi.php
 */
defined('BASEPATH') or exit('No direct script access allowed');

class Informasi extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model([
            'validasi/validasi_fisik_model' => 'validasi_fisik_model',
             'kegiatan_apbd/kegiatan_apbd_model'   => 'kegiatan_apbd_model',
             'informasi/bantuan_model'   => 'bantuan_model',
             'informasi/pengumuman_model'   => 'pengumuman_model',
            'datatables_model'              => 'datatables_model'
        ]);
    }

     public function bantuan()
    {
        $breadcrumbs    = $this->breadcrumbs;
        $kegiatan_apbd   = $this->kegiatan_apbd_model;
        $bantuan   = $this->bantuan_model;

        $breadcrumbs->add('Home', base_url());
        $breadcrumbs->add('Informasi', base_url());
        $breadcrumbs->add('Bantuan', base_url($this->router->fetch_class()));
        $breadcrumbs->render();

        $data['title']                        = "Bantuan";
        $data['icon']                       = "metismenu-icon fa fa-th";
        $data['description']                = "Menampilkan Bantuan Terkait aplikasi Simbangda V4";
        $data['breadcrumbs']                = $breadcrumbs->render();
        $id_group                           = $this->session->userdata('id_group');
        $data['menu_bantuan']                       = $bantuan->tampilkan_menu_group($id_group);
        $page                                 = 'informasi/bantuan/index';
        $data['link']                       = $this->router->fetch_method();
        $data['menu']                       = $this->load->view('layout/menu', $data, true);
        $data['extra_css']                    = $this->load->view('informasi/bantuan/css', $data, true);
        $data['extra_js']                    = $this->load->view('informasi/bantuan/js', $data, true);
        $data['modal']                      = $this->load->view('informasi/bantuan/modal', $data, true);
        $this->template->load('backend_template', $page, $data);
    }
   

     public function pengumuman()
    {
        $breadcrumbs    = $this->breadcrumbs;
        $kegiatan_apbd   = $this->kegiatan_apbd_model;
        $pengumuman   = $this->pengumuman_model;

        $breadcrumbs->add('Home', base_url());
        $breadcrumbs->add('Informasi', base_url());
        $breadcrumbs->add('Pengumuman', base_url($this->router->fetch_class()));
        $breadcrumbs->render();

        $data['title']                        = "pengumuman";
        $data['icon']                       = "metismenu-icon fa fa-th";
        $data['description']                = "Menampilkan pengumuman Terkait aplikasi Simbangda V4";
        $data['breadcrumbs']                = $breadcrumbs->render();
        $id_group                           = $this->session->userdata('id_group');
        $page                                 = 'informasi/pengumuman/index';
        $data['link']                       = $this->router->fetch_method();
        $data['menu']                       = $this->load->view('layout/menu', $data, true);
        $data['extra_css']                    = $this->load->view('informasi/pengumuman/css', $data, true);
        $data['extra_js']                    = $this->load->view('informasi/pengumuman/js', $data, true);
        $data['modal']                      = $this->load->view('informasi/pengumuman/modal', $data, true);
        $this->template->load('backend_template', $page, $data);
    }
   

    public function rules_save()
    {
        return [
            [
                'field' => 'wa',
                'label' => 'No Wa Pelapor',
                'rules' => 'required|min_length[10]'
            ],
            [
                'field' => 'menu',
                'label' => 'Menu',
                'rules' => 'required'
            ],
            [
                'field' => 'masalah',
                'label' => 'Masalah',
                'rules' => 'required'
            ],
            [
                'field' => 'keterangan',
                'label' => 'Keterangan',
                'rules' => 'required'
            ]
        ];
    }


    public function simpan_pengumuman()
    {
        
            set_time_limit(0);
            $output = [
                'status' => false,
                'data'   => []
            ];

            $primary_folder     = './sbe_files_support/';
            $directory          = [
                'pengumuman'
            ];
            $list_directory = $this->sbe_directory($primary_folder, $directory);

            if (!file_exists($list_directory)) {
                mkdir($list_directory, 0777, TRUE);
            }
            // untuk menghapus file sebelumnya
        
            // untuk menghapus file sebelumnya

            $namafiledisimpan = "Pengumuman_".date('Ymdhis');
            $config['upload_path']   = $list_directory;
            $config['overwrite']     = true;
            $config['allowed_types'] = 'pdf';
            $config['encrypt_name']  = false;
            $config['file_name']     = $namafiledisimpan;
            $config['max_size']      = '10000';

            $this->load->library('upload', $config);

            if (empty($_FILES['upload_file']['name'])) {
                $data = [
                        'judul' =>$this->input->post('judul'),
                        'keterangan' =>nl2br($this->input->post('keterangan')),
                        'tgl_pelaksanaan' =>$this->input->post('tgl'),
                        'jam_pelaksanaan' =>$this->input->post('jam'),
                        'created_on' =>timestamp(),
                        'created_by' =>id_user()
                    ];
                    $this->db->insert('pengumuman', $data);
                    $pesan_flashdata  = '<div class="alert alert-info">Pengumuman tanpa lampiran disimpan</div>';
            }else{
                if (!$this->upload->do_upload('upload_file')) {
                    $output['status']   = false;
                    $pesan_flashdata  = '<div class="alert alert-info">'.$this->upload->display_errors().'</div>';
                } else {
                    $data = [
                        'judul' =>$this->input->post('judul'),
                        'keterangan' =>nl2br($this->input->post('keterangan')),
                        'tgl_pelaksanaan' =>$this->input->post('tgl'),
                        'jam_pelaksanaan' =>$this->input->post('jam'),
                        'created_on' =>timestamp(),
                        'created_by' =>id_user(),
                        'file' =>$namafiledisimpan.'.pdf', 
                    ];
                    $this->db->insert('pengumuman', $data);
                    $pesan_flashdata  = '<div class="alert alert-info">Pengumuman dengan lampiran disimpan</div>';
                   
                }
            }

            $this->session->set_flashdata('pesan', $pesan_flashdata);
            redirect('informasi/pengumuman');
        
    }



    public function simpanedit_pengumuman()
    {
        
            set_time_limit(0);
            $output = [
                'status' => false,
                'data'   => []
            ];

            $primary_folder     = './sbe_files_support/';
            $directory          = [
                'pengumuman'
            ];
            $list_directory = $this->sbe_directory($primary_folder, $directory);

            if (!file_exists($list_directory)) {
                mkdir($list_directory, 0777, TRUE);
            }
            // untuk menghapus file sebelumnya
        
            // untuk menghapus file sebelumnya

            $namafiledisimpan = "Pengumuman_".date('Ymdhis');
            $config['upload_path']   = $list_directory;
            $config['overwrite']     = true;
            $config['allowed_types'] = 'pdf';
            $config['encrypt_name']  = false;
            $config['file_name']     = $namafiledisimpan;
            $config['max_size']      = '10000';

            $this->load->library('upload', $config);
            $where = ['id_pengumuman'=>sbe_crypt($this->input->post('id_pengumuman'),'D')];
            if (empty($_FILES['upload_file']['name'])) {
                $data = [
                        'judul' =>$this->input->post('judul'),
                        'keterangan' =>nl2br($this->input->post('keterangan')),
                        'tgl_pelaksanaan' =>$this->input->post('tgl'),
                        'jam_pelaksanaan' =>$this->input->post('jam'),
                        'created_on' =>timestamp(),
                        'created_by' =>id_user()
                    ];
                    $this->db->update('pengumuman', $data, $where);
                    $pesan_flashdata  = '<div class="alert alert-info">Pengumuman tanpa lampiran disimpan</div>';
            }else{
                if (!$this->upload->do_upload('upload_file')) {
                    $output['status']   = false;
                    $pesan_flashdata  = '<div class="alert alert-info">'.$this->upload->display_errors().'</div>';
                } else {
                    $data = [
                        'judul' =>$this->input->post('judul'),
                        'keterangan' =>nl2br($this->input->post('keterangan')),
                        'tgl_pelaksanaan' =>$this->input->post('tgl'),
                        'jam_pelaksanaan' =>$this->input->post('jam'),
                        'created_on' =>timestamp(),
                        'created_by' =>id_user(),
                        'file' =>$namafiledisimpan.'.pdf', 
                    ];
                    $this->db->update('pengumuman', $data, $where);
                    $file_lama = $this->input->post('filelama');
                    if ($file_lama!='') {
                    $primary_folder     = 'sbe_files_support/';
                    $directory          = [
                        'pengumuman'
                    ];
                    $list_directory = $this->sbe_directory($primary_folder, $directory);
                    unlink($list_directory.$file_lama);
                        
                    }
                    $pesan_flashdata  = '<div class="alert alert-info">Pengumuman dengan lampiran disimpan</div>';
                   
                }
            }

            $this->session->set_flashdata('pesan', $pesan_flashdata);
            redirect('informasi/pengumuman');
        
    }


    public function simpan_bantuan()
    {
        if (!$this->input->is_ajax_request()) {
            show_404();
        } else {
            $output    = [
                'success' => false,
                'messages' => []
            ];
            $data_group     = [];
            $bantuan     = $this->bantuan_model;
            $validation     = $this->form_validation;
            $validation->set_rules($this->rules_save());
            $validation->set_error_delimiters('<p class="text-danger">', '</p>');

            if ($validation->run($this)) {
                $post               = $this->input->post();
                if ($this->session->userdata('id_group')==5) {
                    $simpan = $bantuan->save_bantuan();
                }else{
                    $simpan = $bantuan->save_bantuan_kab_kota();

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

    
    public function hapus_pengumuman()
    {
        if (!$this->input->is_ajax_request()) {
            show_404();
        } else {
            $output    = [
                'success' => false,
                'messages' => []
            ];
            $id_pengumuman =  sbe_crypt($this->input->post('id_pengumuman'),'D');
            $file = $this->input->post('file');
            $this->db->delete('pengumuman',['id_pengumuman'=>$id_pengumuman]);
            if ($file!='') {
                

            $primary_folder     = 'sbe_files_support/';
            $directory          = [
                'pengumuman'
            ];
            $list_directory = $this->sbe_directory($primary_folder, $directory);
            $output['success'] = true;
            $output['dd'] = $list_directory.$file;
            unlink($list_directory.$file);
                
            }
            echo json_encode($output);
        }
    }


    public function detail_pengumuman()
    {
        if (!$this->input->is_ajax_request()) {
            show_404();
        } else {
            $output    = [
                'success' => false,
                'data' => []
            ];
            $id_pengumuman =  sbe_crypt($this->input->post('id_pengumuman'),'D');
            $file = $this->input->post('file');
            $pengumuman = $this->db->get_where('pengumuman',['id_pengumuman'=>$id_pengumuman])->row();
            $output['data']['id_pengumuman'] = sbe_crypt($pengumuman->id_pengumuman,'E');
            $output['data']['judul'] = $pengumuman->judul;
            $output['data']['keterangan'] = $pengumuman->keterangan;
            $output['data']['edit_keterangan'] = str_replace('<br />', '', $pengumuman->keterangan);
            $output['data']['tgl_pelaksanaan'] = $pengumuman->tgl_pelaksanaan;
            $output['data']['jam_pelaksanaan'] = $pengumuman->jam_pelaksanaan;
            $output['data']['filelama'] = $pengumuman->file;
            $file = $pengumuman->file;



                $primary_folder     = 'sbe_files_support/';
                $directory          = [
                    'pengumuman'
                ];
                $list_directory = $this->sbe_directory($primary_folder, $directory);
                $output['success'] = true;
                $output['data']['lokasi_file'] = $list_directory.$file;
               
                
            echo json_encode($output);
        }
    }

    

    public function dt_bantuan()
    {
        if (!$this->input->is_ajax_request()) {
            show_404();
        } else {
            $id_instansi    = id_instansi();
            if ($this->session->userdata('id_group')=='0') {
                $where          = array();
            }else{
                $where          = array('id_instansi' => $id_instansi, 'id_user'=>id_user());
            }
            $status_bantuan = [1=>'Waiting Response','Process','Selesai'];
            $column_order   = array('', 'masalah');
            $column_search  = array('masalah','kode_ticket','pelapor','nama_instansi','menu_name','waktu_report ',);
            $order = array('waktu_report' => 'DESC');
            $list = $this->datatables_model->get_datatables('v_bantuan', $column_order, $column_search, $order, $where);
            $data = array();
            $no = $_POST['start'];
            foreach ($list as $lists) {
                $no++;
                $row   = array();
                $row[] = $no;
                $row[] = $lists->kode_ticket;
                $row[] = $lists->pelapor;
                $row[] = $lists->nama_instansi;
                $row[] = $lists->category_name .' - '.$lists->menu_name;
                $row[] = $lists->masalah;
                $row[] = $lists->waktu_report;
                $row[] = $status_bantuan[$lists->status];

                 $tombol_detail = '<button class="btn btn-outline-info btn-xs"  onclick="detail_bantuan('."'" .sbe_crypt($lists->id_bantuan,'E'). "','".$lists->id_group."'".')"><i class="fas fa-crosshairs"></i></button> ';


                $row[] = $tombol_detail;
              
              
              
              
                $data[] = $row;
            }

            $output = array(
                "draw" => $_POST['draw'],
                "recordsTotal" => $this->datatables_model->count_all('v_bantuan', $where),
                "recordsFiltered" => $this->datatables_model->count_filtered('v_bantuan', $column_order, $column_search, $order, $where),
                "data" => $data,
            );

            echo json_encode($output);
        }
    }

    public function dt_bantuan_kab_kota()
    {
        if (!$this->input->is_ajax_request()) {
            show_404();
        } else {
            $id_kota    = $this->session->userdata('id_kota');
            if ($this->session->userdata('id_group')=='0') {
                $where          = array();
            }else{
                $where          = array('id_kota' => $id_kota, 'id_user'=>id_user());
            }
            $status_bantuan = [1=>'Waiting Response','Process','Selesai'];
            $column_order   = array('', 'masalah');
            $column_search  = array('masalah','kode_ticket','pelapor','nama_kota','menu_name','waktu_report ',);
            $order = array('waktu_report' => 'DESC');
            $list = $this->datatables_model->get_datatables('v_bantuan_kab_kota', $column_order, $column_search, $order, $where);
            $data = array();
            $no = $_POST['start'];
            foreach ($list as $lists) {
                $no++;
                $row   = array();
                $row[] = $no;
                $row[] = $lists->kode_ticket;
                $row[] = $lists->pelapor;
                $row[] = $lists->nama_kota;
                $row[] = $lists->category_name .' - '.$lists->menu_name;
                $row[] = $lists->masalah;
                $row[] = $lists->waktu_report;
                $row[] = $status_bantuan[$lists->status];
                   $tombol_detail = '<button class="btn btn-outline-info btn-xs"  onclick="detail_bantuan_kab_kota('."'" .sbe_crypt($lists->id_bantuan_kab_kota,'E'). "','".$lists->id_group."'".')"><i class="fas fa-crosshairs"></i></button> ';

                 


                $row[] = $tombol_detail;
              
              
              
              
                $data[] = $row;
            }

            $output = array(
                "draw" => $_POST['draw'],
                "recordsTotal" => $this->datatables_model->count_all('v_bantuan_kab_kota', $where),
                "recordsFiltered" => $this->datatables_model->count_filtered('v_bantuan_kab_kota', $column_order, $column_search, $order, $where),
                "data" => $data,
            );

            echo json_encode($output);
        }
    }

    

    public function dt_pengumuman()
    {
        if (!$this->input->is_ajax_request()) {
            show_404();
        } else {
           
                $where          = array();
            $status_bantuan = [1=>'Waiting Response','Process','Selesai'];
            $column_order   = array('');
            $column_search  = array('judul','tgl_pelaksanaan','jam_pelaksanaan');
            $order = array('id_pengumuman' => 'DESC');
            $list = $this->datatables_model->get_datatables('pengumuman', $column_order, $column_search, $order, $where);
            $data = array();
            $no = $_POST['start'];
            foreach ($list as $lists) {
                $no++;
                $row   = array();
                $row[] = $no;
                $row[] = $lists->judul;
                $row[] = $lists->keterangan;
                $row[] = $lists->tgl_pelaksanaan.'<br>'.$lists->jam_pelaksanaan;


                 $tombol_detail = '<button class="btn btn-info btn-xs"  onclick="detail_pengumuman('."'" .sbe_crypt($lists->id_pengumuman,'E'). "'".')" data-toggle="tooltip" title="Lihat Lampiran"><i class="fas fa-folder-open"></i></button> ';
                 $tombol_edit = ' <button class="btn btn-warning btn-xs"  onclick="edit_pengumuman('."'" .sbe_crypt($lists->id_pengumuman,'E'). "'".')" data-toggle="tooltip" title="Edit Pengumuman"><i class="fas fa-edit"></i></button> ';
                 $tombol_hapus = ' <button class="btn btn-danger btn-xs"  onclick="hapus_pengumuman('."'" .sbe_crypt($lists->id_pengumuman,'E'). "','".$lists->judul."','".$lists->file."'".')" data-toggle="tooltip" title="Hapus Pengumuman"><i class="fas fa-trash"></i></button> ';


                $row[] = $tombol_detail.$tombol_edit.$tombol_hapus;
              



             
              
              
              
              
                $data[] = $row;
            }

            $output = array(
                "draw" => $_POST['draw'],
                "recordsTotal" => $this->datatables_model->count_all('pengumuman', $where),
                "recordsFiltered" => $this->datatables_model->count_filtered('pengumuman', $column_order, $column_search, $order, $where),
                "data" => $data,
            );

            echo json_encode($output);
        }
    }

    public function dt_tracking_bantuan()
    {
        if (!$this->input->is_ajax_request()) {
            show_404();
        } else {
            $id_bantuan    = sbe_crypt($this->input->post('id_bantuan'), 'D');
            if ($this->session->userdata('id_group')=='5') {
                $where          = array('id_bantuan' => $id_bantuan, 'tampilkan_ke_pelapor'=>'1');
            }else{
                $where          = array('id_bantuan' => $id_bantuan);
            }
           
            $column_order   = array('', 'waktu_input');
            $column_search  = array('keterangan');
            $order = array('waktu_input' => 'DESC');
            $status_track = ['Developer Only','Developer Dan Pelapor'];
            $list = $this->datatables_model->get_datatables('tracking_bantuan', $column_order, $column_search, $order, $where);
            $data = array();
            $no = $_POST['start'];
            foreach ($list as $lists) {
                $no++;
                $row   = array();
                $row[] = $no;
                $row[] = $lists->waktu_input.'<br>'.$lists->keterangan;
                if ($lists->tampilkan_ke_pelapor=='1') {
                    $row[] = '<i class="fas fa-eye"></i>';
                }else{
                    $row[] = '<i class="fas fa-eye-slash"></i>';

                }
              

                 $tombol_detail = '<button class="btn btn-outline-info btn-xs"  onclick="detail_bantuan('."'" .sbe_crypt($lists->id_bantuan,'E'). "'".')"><i class="fas fa-crosshairs"></i></button> ';


                $row[] = $tombol_detail;
              
              
              
              
                $data[] = $row;
            }

            $output = array(
                "draw" => $_POST['draw'],
                "recordsTotal" => $this->datatables_model->count_all('tracking_bantuan', $where),
                "recordsFiltered" => $this->datatables_model->count_filtered('tracking_bantuan', $column_order, $column_search, $order, $where),
                "data" => $data,
            );

            echo json_encode($output);
        }
    }

    public function detail_bantuan()
    {
        if (!$this->input->is_ajax_request()) {
            show_404();
        } else {
             $output = [
                'status'    => false,
                'data'      => []
            ];
            $status_bantuan = [1=>'Waiting Response','Process','Selesai'];
            $lihat_penyelesaian  = ['Ya','Tidak'];
            $id_bantuan    = sbe_crypt($this->input->post('id_bantuan'), 'D');
            $get_bantuan = $this->bantuan_model->get_bantuan($id_bantuan);
            $output['data']['menu']     = $get_bantuan->category_name.' - '.$get_bantuan->menu_name;
            $output['data']['pelapor']     = $get_bantuan->pelapor;
            $output['data']['skpd']     = $get_bantuan->nama_instansi;
            $output['data']['no_wa']     = $get_bantuan->no_wa;
            $output['data']['kode_ticket']     = $get_bantuan->kode_ticket;
            $output['data']['masalah']     = $get_bantuan->masalah;
            $output['data']['deskripsi_masalah']     = $get_bantuan->deskripsi_masalah;
            $output['data']['penyebab']     = $get_bantuan->penyebab =='' ? 'Tidak Ditemukan' : $get_bantuan->penyebab;
            $output['data']['jenis_penyelesaian']     = $get_bantuan->jenis_penyelesaian =='' ? 'Tidak Ditemukan' : $get_bantuan->jenis_penyelesaian;
            $output['data']['solusi']     = $get_bantuan->solusi =='' ? 'Tidak Ditemukan' : $get_bantuan->solusi;
            $output['data']['kode_status']     = $get_bantuan->status;
            $output['data']['status']     = $status_bantuan[$get_bantuan->status];
            $publish = $get_bantuan->publikasikan =='' ? 0 : $get_bantuan->publikasikan;
            $output['data']['publikasikan']     = $publish;
            $output['data']['lihat_penyelesaian_operator']     = $lihat_penyelesaian[$publish];
            

            echo json_encode($output);
        }
    }
    public function detail_bantuan_kab_kota()
    {
        if (!$this->input->is_ajax_request()) {
            show_404();
        } else {
             $output = [
                'status'    => false,
                'data'      => []
            ];
            $status_bantuan = [1=>'Waiting Response','Process','Selesai'];
            $lihat_penyelesaian  = ['Ya','Tidak'];
            $id_bantuan    = sbe_crypt($this->input->post('id_bantuan'), 'D');
            $get_bantuan = $this->bantuan_model->get_bantuan_kab_kota($id_bantuan);
            $output['data']['menu']     = $get_bantuan->category_name.' - '.$get_bantuan->menu_name;
            $output['data']['pelapor']     = $get_bantuan->pelapor;
            $output['data']['skpd']     = $get_bantuan->nama_kota;
            $output['data']['no_wa']     = $get_bantuan->no_wa;
            $output['data']['kode_ticket']     = $get_bantuan->kode_ticket;
            $output['data']['masalah']     = $get_bantuan->masalah;
            $output['data']['deskripsi_masalah']     = $get_bantuan->deskripsi_masalah;
            $output['data']['penyebab']     = $get_bantuan->penyebab =='' ? 'Tidak Ditemukan' : $get_bantuan->penyebab;
            $output['data']['jenis_penyelesaian']     = $get_bantuan->jenis_penyelesaian =='' ? 'Tidak Ditemukan' : $get_bantuan->jenis_penyelesaian;
            $output['data']['solusi']     = $get_bantuan->solusi =='' ? 'Tidak Ditemukan' : $get_bantuan->solusi;
            $output['data']['kode_status']     = $get_bantuan->status;
            $output['data']['status']     = $status_bantuan[$get_bantuan->status];
            $publish = $get_bantuan->publikasikan =='' ? 0 : $get_bantuan->publikasikan;
            $output['data']['publikasikan']     = $publish;
            $output['data']['lihat_penyelesaian_operator']     = $lihat_penyelesaian[$publish];
            

            echo json_encode($output);
        }
    }
    public function proses_bantuan()
    {
        if (!$this->input->is_ajax_request()) {
            show_404();
        } else {
             $output = [
                'status'    => false,
                'data'      => []
            ];
            $id_bantuan    = sbe_crypt($this->input->post('id_bantuan'), 'D');
            $data = [
                'waktu_diproses'=>timestamp(),
                'status'=>'2'
            ];
            $update = $this->db->update('bantuan', $data, ['id_bantuan'=>$id_bantuan]);
            $output['success'] = true;
            

            echo json_encode($output);
        }
    }
    public function proses_bantuan_kab_kota()
    {
        if (!$this->input->is_ajax_request()) {
            show_404();
        } else {
             $output = [
                'status'    => false,
                'data'      => []
            ];
            $id_bantuan    = sbe_crypt($this->input->post('id_bantuan'), 'D');
            $data = [
                'waktu_diproses'=>timestamp(),
                'status'=>'2'
            ];
            $update = $this->db->update('bantuan_kab_kota', $data, ['id_bantuan_kab_kota'=>$id_bantuan]);
            $output['success'] = true;
            

            echo json_encode($output);
        }
    }
    public function akhiri_bantuan()
    {
        if (!$this->input->is_ajax_request()) {
            show_404();
        } else {
             $output = [
                'status'    => false,
                'data'      => []
            ];
            $id_bantuan    = sbe_crypt($this->input->post('id_bantuan'), 'D');
            $penyebab    = $this->input->post('penyebab');
            $solusi    = $this->input->post('solusi');
            $penyelesaian    = $this->input->post('penyelesaian');
            $show    = $this->input->post('show');
            $id_group_pelapor    = $this->input->post('id_group_pelapor');
            $data = [
                'waktu_selesai'=>timestamp(),
                'penyebab'=>nl2br($penyebab),
                'solusi'=>nl2br($solusi),
                'jenis_penyelesaian'=>$penyelesaian,
                'publikasikan'=>$show,
                'status'=>'3'
            ];
            if ($id_group_pelapor==5) {
                $update = $this->db->update('bantuan', $data, ['id_bantuan'=>$id_bantuan]);
            }else{
                $update = $this->db->update('bantuan_kab_kota', $data, ['id_bantuan_kab_kota'=>$id_bantuan]);
            }
            $output['success'] = true;
            

            echo json_encode($output);
        }
    }
    public function simpan_tracking()
    {
        if (!$this->input->is_ajax_request()) {
            show_404();
        } else {
             $output = [
                'status'    => false,
                'data'      => []
            ];
            $id_bantuan    = sbe_crypt($this->input->post('id_bantuan'), 'D');
            $input_tracking    = $this->input->post('input_tracking');
            $show_operator    = $this->input->post('show_operator');
            $id_group_pelapor    = $this->input->post('id_group_pelapor');
            
            $data = [
                'id_bantuan'=>$id_bantuan,
                'keterangan'=>nl2br($input_tracking),
                'waktu_input'=>timestamp(),
                'tampilkan_ke_pelapor'=>$show_operator,
                'id_group_pelapor'=>$id_group_pelapor
            ];
            $update = $this->db->insert('tracking_bantuan', $data);
            $output['success'] = true;
            

            echo json_encode($output);
        }
    }

   
}
