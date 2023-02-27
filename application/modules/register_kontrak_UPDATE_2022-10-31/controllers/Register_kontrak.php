<?php

/**
 * Author     : Alfikri, M.Kom
 * Created By : Alfikri, M.Kom
 * E-Mail     : alfikri.name@gmail.com
 * No HP      : 081277337405
 * Class      : Register_kontrak.php
 */
defined('BASEPATH') or exit('No direct script access allowed');

class Register_kontrak extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model([
            'register_kontrak/buat_kontrak_model'     => 'buat_kontrak_model',
            'register_kontrak/daftar_kontrak_model' => 'daftar_kontrak_model',
            'register_kontrak/lokasi_kontrak_model' => 'lokasi_kontrak_model',
            'datatables_model'                      => 'datatables_model'
        ]);
    }

    public function buat_kontrak()
    {
        $breadcrumbs     = $this->breadcrumbs;
        $buat_kontrak     = $this->buat_kontrak_model;

        $breadcrumbs->add('Home', base_url());
        $breadcrumbs->add('Register Kontrak', base_url($this->router->fetch_class()));
        $breadcrumbs->add('Buat Kontrak', base_url());
        $breadcrumbs->render();
          $data['dropdown_option'] = [
            
            ['tipe'=>'link', 'caption'=>'Kembali', 'fa'=>'fa fa-arrow-left', 'onclick'=>'register_kontrak/daftar_kontrak', 'elemen_tambahan'=>'data-toggle="tooltip" title="Kembali"'],
              ];

        $data['title']          = "Buat Kontrak";
        $data['icon']           = "metismenu-icon fas fa-file-signature";
        $data['description']    = "Buat register kontrak paket pekerjaan kontruksi";
        $data['breadcrumbs']    = '';
        $page                   = 'register_kontrak/buat_kontrak/index';
        $data['link']           = $this->router->fetch_method();
        $data['jenis_kontrak']  = $this->db->get('jenis_kontrak')->result_array();
        $data['menu']           = $this->load->view('layout/menu', $data, true);
        $data['extra_css']      = $this->load->view('register_kontrak/buat_kontrak/css', $data, true);
        $data['extra_js']       = $this->load->view('register_kontrak/buat_kontrak/js', $data, true);
        $data['modal']          = $this->load->view('register_kontrak/buat_kontrak/modal', $data, true);
        $this->template->load('backend_template', $page, $data);
    }

    public function edit_kontrak($id_kontrak)
    {
      
        $breadcrumbs     = $this->breadcrumbs;
        $buat_kontrak     = $this->buat_kontrak_model;
        $daftar_kontrak = $this->daftar_kontrak_model;

        $breadcrumbs->add('Home', base_url());
        $breadcrumbs->add('Register Kontrak', base_url($this->router->fetch_class()));
        $breadcrumbs->add('Edit Kontrak', base_url());
        $breadcrumbs->render();

        $data['title']          = "Edit Kontrak";
        $data['icon']           = "metismenu-icon fas fa-file-signature";
        $data['description']    = "Edit register kontrak paket pekerjaan kontruksi";
        $data['breadcrumbs']    = $breadcrumbs->render();
        $page                   = 'register_kontrak/edit_kontrak/index';

        $data['jenis_kontrak']  = $this->db->get('jenis_kontrak')->result_array();
        $data['link']           = $this->router->fetch_method();
        $data['id_kontrak']     = $id_kontrak;
        $data['menu']           = $this->load->view('layout/menu', $data, true);
        $data['extra_css']      = $this->load->view('register_kontrak/edit_kontrak/css', $data, true);
        $data['extra_js']       = $this->load->view('register_kontrak/edit_kontrak/js', $data, true);
        $data['modal']          = $this->load->view('register_kontrak/edit_kontrak/modal', $data, true);
        $this->template->load('backend_template', $page, $data);
    }


    public function detail_kontrak($id_kontrak)
    {
      
        $breadcrumbs     = $this->breadcrumbs;
        $buat_kontrak     = $this->buat_kontrak_model;
        $daftar_kontrak = $this->daftar_kontrak_model;

        $breadcrumbs->add('Home', base_url());
        $breadcrumbs->add('Register Kontrak', base_url($this->router->fetch_class()));
        $breadcrumbs->add('Edit Kontrak', base_url());
        $breadcrumbs->render();
            $data['dropdown_option'] = [
            
            ['tipe'=>'link', 'caption'=>'Kembali', 'fa'=>'fa fa-arrow-left', 'onclick'=>'register_kontrak/daftar_kontrak', 'elemen_tambahan'=>'data-toggle="tooltip" title="Kembali"'],
              ];
        $data['title']          = "Detail Kontrak";
        $data['icon']           = "metismenu-icon fas fa-file-signature";
        $data['description']    = "Edit register kontrak paket pekerjaan kontruksi";
        $data['breadcrumbs']    = '';
        $page                   = 'register_kontrak/detail_kontrak/index';

        $data['jenis_kontrak']  = $this->db->get('jenis_kontrak')->result_array();

            $id_kontrak_db = sbe_crypt($id_kontrak, 'D');
            $q_paket     = $this->db->query("SELECT id_paket_pekerjaan from kontrak_pekerjaan where id_kontrak_pekerjaan='$id_kontrak_db'")->row_array();
        $data['id_paket_pekerjaan']           = $q_paket['id_paket_pekerjaan'];


        $data['link']           = $this->router->fetch_method();
        $data['id_kontrak']     = $id_kontrak;
        $data['menu']           = $this->load->view('layout/menu', $data, true);
        $data['extra_css']      = $this->load->view('register_kontrak/detail_kontrak/css', $data, true);
        $data['extra_js']       = $this->load->view('register_kontrak/detail_kontrak/js', $data, true);
        $data['modal']          = $this->load->view('register_kontrak/detail_kontrak/modal', $data, true);
        $this->template->load('backend_template', $page, $data);
    }


    public function tampilkan_koordinat_terpilih($lat, $long)
    {
        $data['latitude'] = trim($lat);
        $data['longitude'] = trim($long);

        $data['extra_css']      = $this->load->view('register_kontrak/buat_kontrak/titik_koordinat_terpilih', $data);
        // $data['extra_js']       = $this->load->view('register_kontrak/buat_kontrak/js_koordinat_terpilih', $data, true);
    }




    public function data_paket_pekerjaan()
    {
        if (!$this->input->is_ajax_request()) {
            show_404();
        } else {            
            $tahun = tahun_anggaran();
            $id_instansi =id_instansi();
            $kode_kegiatan  = $this->input->post('kode_kegiatan');
            $where          = ['id_instansi' =>$id_instansi ,'tahun'=>$tahun];
            $column_order   = ['', 'nama_paket'];
            $column_search  = ['nama_paket'];
            $order          = ['nama_paket' => 'ASC'];
            $list           = $this->datatables_model->get_datatables('v_paket_belum_berkontrak', $column_order, $column_search, $order, $where);
            $data           = [];
            $no             = $_POST['start'];
            foreach ($list as $lists) {
                $krsk = $lists->kode_rekening_sub_kegiatan;
                $q_ski = $this->db->query("SELECT * from v_sub_kegiatan_apbd where id_instansi='$id_instansi' and kode_rekening_sub_kegiatan='$krsk' and tahun='$tahun'")->row_array();
                $q_pptk = $this->db->query("SELECT mu.full_name, si.nama_sub_instansi from users_sub_kegiatan usk
                    left join master_users mu on usk.id_user= mu.id_user 
                    left join sub_instansi si on mu.id_sub_instansi = si.id_sub_instansi
                    where usk.id_instansi='$id_instansi' and usk.kode_rekening_sub_kegiatan='$krsk' and usk.tahun_anggaran='$tahun'")->row_array();
                $no++;

                $id_paket_pekerjaan = sbe_crypt($lists->id_paket_pekerjaan,'E');
                $row    = [];
                $row[]     = $no;
                $row[]     = $lists->nama_paket;
                $row[]     = $lists->jenis_paket;
                $row[]     = $q_ski['jenis_sub_kegiatan']== 'Unit Pelaksana' ? $q_ski['nama_sub_kegiatan'].'<br>'.$d_ski['jenis_sub_kegiatan'].' - '.$q_ski['keterangan'] : $q_ski['nama_sub_kegiatan'];
                $row[]     = $q_pptk['full_name'];//.'<br>'.$q_pptk['nama_sub_instansi'];
                $row[]     = '<button type="button" onclick="tampil_register_kontrak('. "'".$id_paket_pekerjaan."'".')" class="btn btn-outline-info btn-sm"><i class="fa fa-check"></i></button>';


               
                $data[] = $row;
            }

            $output = [
                "draw"              => $_POST['draw'],
                "recordsTotal"      => $this->datatables_model->count_all('v_paket_belum_berkontrak', $where),
                "recordsFiltered"   => $this->datatables_model->count_filtered('v_paket_belum_berkontrak', $column_order, $column_search, $order, $where),
                "data"              => $data,
            ];

            echo json_encode($output);
        }
    }





    public function get_paket_pekerjaan()
    {
        if (!$this->input->is_ajax_request()) {
            show_404();
        } else {
            $output = [
                'status'    => false,
                'data'      => []
            ];

            $buat_kontrak       = $this->buat_kontrak_model;
            $paket_pekerjaan    = $buat_kontrak->paket_pekerjaan();
            foreach ($paket_pekerjaan as $key => $value) {
                $output['data'][$key]['id_paket_pekerjaan'] = sbe_crypt($value->id_paket_pekerjaan, 'E');
                $output['data'][$key]['nama_paket']         = $value->nama_paket;
                $output['status'] = true;
            }

            echo json_encode($output);
        }
    }

    public function kab_kota()
    {
        if (!$this->input->is_ajax_request()) {
            show_404();
        } else {
            $output = [
                'status'    => false,
                'data'      => []
            ];

            $buat_kontrak       = $this->buat_kontrak_model;
            $id_provinsi = 13;
            $kab_kota    = $buat_kontrak->kab_kota($id_provinsi);
            foreach ($kab_kota as $key => $value) {
                $output['data'][$key]['id_kota'] = sbe_crypt($value->id_kota, 'E');
                $output['data'][$key]['nama_kota']         = $value->nama_kota;
            }

            $output['status'] = true;
            echo json_encode($output);
        }
    }

    public function kecamatan()
    {
        if (!$this->input->is_ajax_request()) {
            show_404();
        } else {
            $output = [
                'status'    => false,
                'data'      => []
            ];

            $buat_kontrak       = $this->buat_kontrak_model;
            $id_kota = sbe_crypt($this->input->post('id_kota'), 'D');
            $kecamatan    = $buat_kontrak->kecamatan($id_kota);
            foreach ($kecamatan as $key => $value) {
                $output['data'][$key]['id_kecamatan'] = sbe_crypt($value->id_kecamatan, 'E');
                $output['data'][$key]['nama_kecamatan']         = $value->nama_kecamatan;
            }

            $output['status'] = true;
            echo json_encode($output);
        }
    }

    public function get_detail_paket()
    {
        if (!$this->input->is_ajax_request()) {
            show_404();
        } else {
            $output = [
                'status'        => false,
                'data'          => [],
                'lokasi'        => [],
                'status_lok'    => 0
            ];

            $id_paket_pekerjaan = sbe_crypt($this->input->get('id_paket_pekerjaan'), 'D');
            $detail_paket       = $this->buat_kontrak_model->detail_paket($id_paket_pekerjaan);
            $lokasi_kontrak     = $this->buat_kontrak_model->lokasi_kontrak($id_paket_pekerjaan);
            $status_lokasi      = $this->buat_kontrak_model->status_lokasi($id_paket_pekerjaan);

            if ($detail_paket->num_rows() > 0) {
                foreach ($detail_paket->result() as $key => $value) {
                    $output['data']['id_pptk']          = sbe_crypt($value->id_pptk, 'E');
                    $output['data']['nama_pptk']        = $value->nama_pptk;
                    $output['data']['nama_paket']        = $value->nama_paket;
                    $output['data']['nama_kegiatan']    = $value->nama_kegiatan;
                    $output['data']['pagu_kegiatan']    = $value->pagu_kegiatan;
                    $output['data']['pagu_paket']       = $value->pagu_paket;
                }

                foreach ($lokasi_kontrak->result() as $key => $value) {
                    $output['lokasi'][$key]['id_lokasi']    = $value->id_lokasi;
                    $output['lokasi'][$key]['kab_kota']     = $value->kab_kota;
                    $output['lokasi'][$key]['latitude']     = $value->latitude;
                    $output['lokasi'][$key]['longitude']    = $value->longitude;
                }

                $output['status']       = true;
                $output['status_lok']   = $status_lokasi;
            } else {
                $output['status'] = false;
            }

            echo json_encode($output);
        }
    }
    public function get_detail_kontrak()
    {
        if (!$this->input->is_ajax_request()) {
            show_404();
        } else {
            $output = [
                'status'        => false,
                'data'          => [],
                'lokasi'        => [],
                'status_lok'    => 0
            ];

            $daftar_kontrak = $this->daftar_kontrak_model;
            $id_kontrak = sbe_crypt($this->input->get('id_kontrak'), 'D');
            $detail_kontrak     = $daftar_kontrak->get_kontrak($id_kontrak);
            $value = $detail_kontrak->row_array();
            if ($detail_kontrak->num_rows() > 0) {
                    $kode_rekening_sub_kegiatan = $value['kode_rekening_sub_kegiatan'];
                    $kode_kegiatan = $value['kode_rekening_kegiatan'];
                    $kode_program = $value['kode_rekening_program'];
                    $tahun = $value['tahun'];
                    $id_instansi = id_instansi();
                    $tahap = tahapan_apbd();
                    $q_ask = $this->db->query("SELECT total_anggaran_sub_kegiatan('$kode_rekening_sub_kegiatan', '$tahap','$id_instansi','$kode_kegiatan','$kode_program','$tahun') as anggaran_sub_kegiatan")->row();
                    $q_program = $this->db->query("SELECT nama_program from master_program where kode_program = '$kode_program'")->row_array();
                    $q_kegiatan = $this->db->query("SELECT nama_kegiatan from master_kegiatan where kode_kegiatan = '$kode_kegiatan'")->row_array();
                    
                    $pecah_nomor = explode('/', $value['no_kontrak']);

                    $nama_ski = $value['kategori'] =='Unit Pelaksana' ? $value['nama_sub_kegiatan'].''.$value['jenis_sub_kegiatan'].' - '.$value['keterangan'] : $value['nama_sub_kegiatan'] ;

                    $output['data']['id_paket_pekerjaan']        = $value['id_paket_pekerjaan'];
                    $output['data']['id_kontrak']        = sbe_crypt($id_kontrak, 'E');
                    $output['data']['nama_pptk']        = $value['nama_pptk'];
                    $output['data']['nama_kegiatan']    = $nama_ski;
                    $output['data']['nama_program']    = $q_program['nama_program'];
                    $output['data']['nama_kegiatan_master']    = $q_kegiatan['nama_kegiatan'];
                    $output['data']['nama_paket']    = $value['nama_paket'];
                    $output['data']['pagu_kegiatan']    = $q_ask->anggaran_sub_kegiatan ;
                    $output['data']['pagu_paket']       = $value['pagu_paket'];
                    $output['data']['jenis_paket']       = $value['jenis_paket'];
                    $output['data']['tgl_awal_pelaksanaan']       = $value['tgl_awal_pelaksanaan'];
                    $output['data']['tgl_akhir_pelaksanaan']       = $value['tgl_akhir_pelaksanaan'];
                    $output['data']['nilai_kontrak']       = $value['nilai_kontrak'];
                    $output['data']['latitude_ok']       = $value['latitude'];
                    $output['data']['jenis_kontrak']       = $value['jenis_kontrak'];
                    $output['data']['longitude_ok']       = $value['longitude'];
                    $output['data']['id_kota']       = sbe_crypt($value['id_kota'], 'E');
                    $output['data']['id_kecamatan']       = sbe_crypt($value['id_kecamatan'], 'E');
                    $output['data']['no_register_kontrak']       = $pecah_nomor[2];
                    $output['data']['pelaksana']       = $value['pelaksana'];
                    $output['data']['metode']       = $value['metode'];

                    $output['data']['domisili']       = $value['nama_provinsi'].'<br>'.$value['nama_kota'].'<br>KECAMATAN '.$value['nama_kecamatan'];


            
                $output['status']       = true;
            } else {
                $output['status'] = false;
            }

            echo json_encode($output);
        }
    }

    public function update_koordinat()
    {
        if (!$this->input->is_ajax_request()) {
            show_404();
        } else {
            $output = [
                'status'    => false
            ];

            $id_lokasi  = $this->input->post('id_lokasi');
            $lat        = $this->input->post('lat');
            $lng        = $this->input->post('lng');
            $update     = $this->db->update('lokasi_paket_pekerjaan', ['latitude' => $lat, 'longitude' => $lng], ['id_lokasi_paket_pekerjaan' => $id_lokasi]);
            if ($update) {
                $output['status'] = true;
            }

            echo json_encode($output);
        }
    }

    public function rules_save()
    {
        return [
            [
                'field' => 'id_paket',
                'label' => 'Paket Pekerjaan',
                'rules' => 'required|trim'
            ],
            [
                'field' => 'jenis_kontrak',
                'label' => 'Jenis Kontrak',
                'rules' => 'required'
            ],
            // [
            //     'field' => 'no_register_kontrak',
            //     'label' => 'No Register Kontrak',
            //     'rules' => 'required|trim'
            // ],
            // [
            //     'field' => 'pelaksana',
            //     'label' => 'Nama Pelaksana',
            //     'rules' => 'required|trim'
            // ],
            // [
            //     'field' => 'tgl_awal_pelaksanaan',
            //     'label' => 'Tanggal Awal Pelaksanaan',
            //     'rules' => 'required|trim'
            // ],
            // [
            //     'field' => 'tgl_akhir_pelaksanaan',
            //     'label' => 'Tanggal Akhir Pelaksanaan',
            //     'rules' => 'required|trim'
            // ],
            // [
            //     'field' => 'nilai_kontrak',
            //     'label' => 'Nilai Kontrak',
            //     'rules' => 'required|numeric|trim|greater_than[0]|callback_valid_nilai_kontrak'
            // ],
            // [
            //     'field' => 'status_lokasi',
            //     'label' => 'Status Lokasi',
            //     'rules' => 'callback_valid_status_lokasi'
            // ],
            [
                'field' => 'kab_kota',
                'label' => 'Kabupaten  Kota',
                'rules' => 'required'
            ],
            // [
            //     'field' => 'latitude_ok',
            //     'label' => 'Latitude',
            //     'rules' => 'required'
            // ],
            // [
            //     'field' => 'longitude_ok',
            //     'label' => 'Longitude',
            //     'rules' => 'required'
            // ]

        ];
    }

    public function rules_save_progress()
    {
        return [
            [
                'field' => 'tgl',
                'label' => 'Tanggal Pengambilan',
                'rules' => 'required'
            ],
            [
                'field' => 'persen',
                'label' => 'Persentasi',
                'rules' => 'required'
            ],
            // [
            //     'field' => 'upload-file',
            //     'label' => 'Foto',
            //     'rules' => 'required'
            // ],
            [
                'field' => 'keterangan',
                'label' => 'Keterangan',
                'rules' => 'required'
            ]
        ];
    }

    public function valid_nilai_kontrak($nilai_kontrak)
    {
        $id_paket_pekerjaan = sbe_crypt($this->input->post('id_paket_pekerjaan'), 'D');
        $pagu_paket         = $this->db->get_where('paket_pekerjaan', ['id_paket_pekerjaan' => $id_paket_pekerjaan])->row()->pagu;

        if ($nilai_kontrak > $pagu_paket) {
            $this->form_validation->set_message('valid_nilai_kontrak', "Nilai kontrak tidak boleh melebihi pagu paket !");
            return false;
        } else {
            return true;
        }
    }

    public function valid_status_lokasi($status_lokasi)
    {
        if ($status_lokasi == 0) {
            return true;
        } else {
            $this->form_validation->set_message('valid_status_lokasi', "Koordinat Lokasi Harus Diisi !");
            return false;
        }
    }

    public function save_register_kontrak()
    {
        if (!$this->input->is_ajax_request()) {
            show_404();
        } else {
            $output    = [
                'status'    => false,
                'messages'  => []
            ];
            $data_group     = [];
            $buat_kontrak   = $this->buat_kontrak_model;
            $validation     = $this->form_validation;
            $validation->set_rules($this->rules_save());
            $validation->set_error_delimiters('<div class="invalid-feedback w-100">', '</div>');

            if ($validation->run($this)) {
                $buat_kontrak->save_register_kontrak();

                $output['status']       = true;
                $output['messages'][]   = "Kontrak berhasil diregister";
            } else {
                $output['status']       = false;
                foreach ($_POST as $key => $value) {
                    $output['messages'][$key] = form_error($key);
                }
            }

                    $output['cek'] = $this->input->post();
            echo json_encode($output);
        }
    }


    public function saveedit_register_kontrak()
    {
        if (!$this->input->is_ajax_request()) {
            show_404();
        } else {
            $output    = [
                'status'    => false,
                'messages'  => []
            ];
            $data_group     = [];
            $buat_kontrak   = $this->buat_kontrak_model;
            $daftar_kontrak = $this->daftar_kontrak_model;
            $validation     = $this->form_validation;
            $validation->set_rules($this->rules_save());
            $validation->set_error_delimiters('<div class="invalid-feedback w-100">', '</div>');

            // if ($validation->run($this)) {
                $daftar_kontrak->saveedit_register_kontrak();

                $output['status']       = true;
                $output['messages'][]   = "Kontrak berhasil diregister";
            // } else {
            //     $output['status']       = false;
            //     foreach ($_POST as $key => $value) {
            //         $output['messages'][$key] = form_error($key);
            //     }
            // }

            echo json_encode($output);
        }
    }

    // Lokasi Kontrak
    public function lokasi_kontrak()
    {
        $breadcrumbs    = $this->breadcrumbs;
        $lokasi_kontrak = $this->lokasi_kontrak_model;

        $breadcrumbs->add('Home', base_url());
        $breadcrumbs->add('Register Kontrak', base_url($this->router->fetch_class()));
        $breadcrumbs->add('Lokasi Kontrak', base_url());
        $breadcrumbs->render();
          $data['dropdown_option'] = [
            
            ['tipe'=>'link', 'caption'=>'Kembali', 'fa'=>'fa fa-arrow-left', 'onclick'=>'register_kontrak/daftar_kontrak', 'elemen_tambahan'=>'data-toggle="tooltip" title="Kembali"'],
              ];
        $data['title']          = "Lokasi Kontrak";
        $data['icon']           = "metismenu-icon fa fa-map";
        $data['description']    = "Lokasi Kontrak Pekerjaan Kontruksi";
        $data['breadcrumbs']    = '';
        $page                   = 'register_kontrak/lokasi_kontrak/index';
        $data['link']           = $this->router->fetch_method();
        $data['menu']           = $this->load->view('layout/menu', $data, true);

        $data['peta']           = $lokasi_kontrak->koordinat_lokasi_kontrak()->result_array();

        $data['extra_css']      = $this->load->view('register_kontrak/lokasi_kontrak/css', $data, true);
        $data['extra_js']       = $this->load->view('register_kontrak/lokasi_kontrak/js', $data, true);
        $data['modal']          = $this->load->view('register_kontrak/lokasi_kontrak/modal', $data, true);
        $this->template->load('backend_template', $page, $data);
    }

    public function get_latlng_pekerjaan()
    {
        if (!$this->input->is_ajax_request()) {
            show_404();
        } else {
            $lokasi_kontrak = $this->lokasi_kontrak_model;
            $output = $lokasi_kontrak->koordinat_lokasi_kontrak()->result();
            echo json_encode($output);
        }
    }

    public function daftar_kontrak()
    {
        $breadcrumbs    = $this->breadcrumbs;
        $daftar_kontrak = $this->daftar_kontrak_model;

        $breadcrumbs->add('Home', base_url());
        $breadcrumbs->add('Register Kontrak', base_url($this->router->fetch_class()));
        $breadcrumbs->add('Daftar Kontrak', base_url());
        $breadcrumbs->render();

        $tahun = tahun_anggaran();
        $tahap = tahapan_apbd();
        $id_instansi = sbe_crypt(id_instansi(),'E');
          $data['dropdown_option']                      = [
            ['tipe'=>'link', 'caption'=>'Buat Kontrak', 'fa'=>'fa fa-plus', 'onclick'=>'register_kontrak/buat_kontrak', 'elemen_tambahan'=>'data-toggle="tooltip" title="Buat kontrak baru"'],
            ['tipe'=>'link', 'caption'=>'Print Daftar Kontrak', 'fa'=>'fa fa-print', 'onclick'=>'laporan/pdf_laporan_register_kontrak?id_opd='.$id_instansi.'&tahun='.$tahun.'&tahap='.$tahap, 'elemen_tambahan'=>'data-toggle="tooltip" title="Print Daftar Kontrak" target="_blank"'],
            ['tipe'=>'link', 'caption'=>'GIS Kontrak', 'fa'=>'fa fa-map', 'onclick'=>'register_kontrak/lokasi_kontrak', 'elemen_tambahan'=>'data-toggle="tooltip" title="Buat kontrak baru"'],
              ];

        $data['title']               = "Daftar Kontrak";
        $data['icon']                = "metismenu-icon fas fa-file-signature";
        $data['description']         = "Daftar Kontrak Pekerjaan";
        $data['breadcrumbs']         = '';
        $data['total_kontrak']       = $daftar_kontrak->total_kontrak();
        $data['total_nilai_kontrak'] = $daftar_kontrak->total_nilai_kontrak();
        $data['total_pagu_paket']    = !empty($daftar_kontrak->total_pagu_paket()) ? $daftar_kontrak->total_pagu_paket()['total_pagu_paket'] : 0;
        $page                        = 'register_kontrak/daftar_kontrak/index';
        $data['link']                = $this->router->fetch_method();
        $data['menu']                = $this->load->view('layout/menu', $data, true);
        $data['extra_css']           = $this->load->view('register_kontrak/daftar_kontrak/css', $data, true);
        $data['extra_js']            = $this->load->view('register_kontrak/daftar_kontrak/js', $data, true);
        $data['modal']               = $this->load->view('register_kontrak/daftar_kontrak/modal', $data, true);
        $this->template->load('backend_template', $page, $data);
    }

    public function dt_daftar_kontrak()
    {
        if (!$this->input->is_ajax_request()) {
            show_404();
        } else {
        	$tahun = tahun_anggaran();
            $where          = ['id_instansi' => id_instansi(), 'tahun'=>$tahun];
            $column_order   = ['', 'no_kontrak', 'pelaksana'];
            $column_search  = ['no_kontrak'];
            $order          = ['no_kontrak' => 'ASC'];
            $list           = $this->datatables_model->get_datatables('v_kontrak_pekerjaan', $column_order, $column_search, $order, $where);
            $data           = [];
            $no             = $_POST['start'];
            foreach ($list as $lists) {
                $no++;
                $row    = [];
                $row[]  = $no;
                $row[]  = $lists->nama_paket;
                $row[]  = $lists->no_kontrak;
                $row[]  = $lists->pelaksana;
                $row[]  =  $lists->nama_provinsi.'<br>'. $lists->nama_kota.'<br>KECAMATAN '. $lists->nama_kecamatan;
                // $row[]  = date('d-m-Y h:i:s', $lists->tgl_register_kontrak);
                $row[]  = $lists->tgl_awal_pelaksanaan;
                $row[]  = $lists->tgl_akhir_pelaksanaan;
                $row[]  = number_format($lists->nilai_kontrak);
                $row[]  = '<a href="' . base_url('register_kontrak/detail_kontrak/' . sbe_crypt($lists->id_kontrak_pekerjaan,'E')) . '" class="btn btn-primary btn-sm" ><i class="fa fa-folder-open" aria-hidden="true"></i>
                </a> ' . 
                '<a href="' . base_url('register_kontrak/edit_kontrak/' . sbe_crypt($lists->id_kontrak_pekerjaan,'E')) . '" class="btn btn-primary btn-sm"  title="Edit kontrak pekerjaan  " ><i class="fa fa-edit" aria-hidden="true"></i>
                </a> ' . 
                '<button class="btn btn-danger btn-sm"  title="Hapus kontrak pekerjaan  "  onclick="hapus_kontrak(' ."'" . $lists->id_kontrak_pekerjaan . "','" . $lists->pelaksana . "'". ')"><i class="fas fa-trash"></i></button>';

                $data[] = $row;
            }

            $output = [
                "draw"              => $_POST['draw'],
                "recordsTotal"      => $this->datatables_model->count_all('kontrak_pekerjaan', $where),
                "recordsFiltered"   => $this->datatables_model->count_filtered('kontrak_pekerjaan', $column_order, $column_search, $order, $where),
                "data"              => $data,
            ];

            echo json_encode($output);
        }
    }
    public function dt_progress_pekerjaan()
    {
        if (!$this->input->is_ajax_request()) {
            show_404();
        } else {
            $id_paket_pekerjaan = $this->input->post('id_paket_pekerjaan');
            $where          = ['id_paket_pekerjaan'=>$id_paket_pekerjaan];
            $column_order   = ['', 'progress_spekerjaan'];
            $column_search  = ['progress_spekerjaan' => 'ASC'];
            $order          = ['progress_pekerjaan' => 'ASC'];
            $list           = $this->datatables_model->get_datatables('v_progress_pekerjaan', $column_order, $column_search, $order, $where);
            $data           = [];
            $no             = $_POST['start'];
            $primary_folder     = 'sbe_files_data/';
            foreach ($list as $lists) {
                $no++;
                $row    = [];
               

                $directory          = [
                    $this->sbe_tahun_anggaran(),
                    id_instansi(),
                    'PROGRESS-PEKERJAAN',
                    $id_paket_pekerjaan,
                ];
                $list_directory     = $this->sbe_directory($primary_folder, $directory);
                $gambar = base_url().$list_directory.$lists->foto;


                $row[]  = $no;
                $row[] = $lists->persentasi.' %';
                $row[] = $lists->keterangan;
                $row[] = $lists->tgl_pengambilan;
                $row[] = '<img src="'.$gambar.'" width="400px">';
                $row[] = '<button type="button" class="btn btn-danger btn-xs" onclick="hapus_progress(\''.$lists->id_progress_pekerjaan.'\',\''.$lists->foto.'\',\''.$lists->id_paket_pekerjaan.'\')"><i class="fa fa-trash"></i></button>';
                // $row[]  = $lists->no_kontrak;
                // $row[]  = $lists->pelaksana;
                // $row[]  =  $lists->nama_provinsi.'<br>'. $lists->nama_kota.'<br>KECAMATAN '. $lists->nama_kecamatan;
                // // $row[]  = date('d-m-Y h:i:s', $lists->tgl_register_kontrak);
                // $row[]  = $lists->tgl_awal_pelaksanaan;
                // $row[]  = $lists->tgl_akhir_pelaksanaan;
                // $row[]  = number_format($lists->nilai_kontrak);
                // $row[]  = '<a href="' . base_url('register_kontrak/detail_kontrak/' . sbe_crypt($lists->id_kontrak_pekerjaan,'E')) . '" class="btn btn-primary btn-sm" ><i class="fa fa-folder-open" aria-hidden="true"></i>
                // </a> ' . 
                // '<a href="' . base_url('register_kontrak/edit_kontrak/' . sbe_crypt($lists->id_kontrak_pekerjaan,'E')) . '" class="btn btn-primary btn-sm"  title="Edit kontrak pekerjaan  " ><i class="fa fa-edit" aria-hidden="true"></i>
                // </a> ' . 
                // '<button class="btn btn-danger btn-sm"  title="Hapus kontrak pekerjaan  "  onclick="hapus_kontrak(' ."'" . $lists->id_kontrak_pekerjaan . "','" . $lists->pelaksana . "'". ')"><i class="fas fa-trash"></i></button>';

                $data[] = $row;
            }

            $output = [
                "draw"              => $_POST['draw'],
                "recordsTotal"      => $this->datatables_model->count_all('v_progress_pekerjaan', $where),
                "recordsFiltered"   => $this->datatables_model->count_filtered('v_progress_pekerjaan', $column_order, $column_search, $order, $where),
                "data"              => $data,
            ];

            echo json_encode($output);
        }
    }







    public function hapus_kontrak()
    {
        if (!$this->input->is_ajax_request()) {
            show_404();
        } else {

            $id_kontrak = $this->input->post('id_kontrak');
            $where = ['id_kontrak_pekerjaan'=>$id_kontrak];
            $this->db->delete('kontrak_pekerjaan',$where);       
           $output['status']   = true;
            

            echo json_encode($output);
        }
    }



    public function hapus_progress()
    {
        if (!$this->input->is_ajax_request()) {
            show_404();
        } else {
            $output = [
                'status'    => false,
                'id_pptk'   => '',
                'rekening'  => ''
            ];

            $id_progress  = $this->input->post('id_progress');
            $id_paket_pekerjaan  = $this->input->post('id_paket_pekerjaan');
            $foto         = $this->input->post('foto');
         
                $this->db->delete('progress_pekerjaan', ['id_progress_pekerjaan' => $id_progress]);


                $primary_folder     = './sbe_files_data/';
                $directory          = [
                    $this->sbe_tahun_anggaran(),
                    id_instansi(),
                    'PROGRESS-PEKERJAAN',
                    $id_paket_pekerjaan,
                ];
                $list_directory = $this->sbe_directory($primary_folder, $directory);
                $cekfilelama = $list_directory.$foto;
                     if (file_exists($cekfilelama)) {
                       unlink($cekfilelama);
                        }
                $output['status']   = true;
                $output['cek']   = true;



            echo json_encode($output);
        }
    }





    public function laporan_register_kontrak($id_kontrak_pekerjaan)
    {
        $this->load->library('format_register_kontrak');

        $kontrak = $this->daftar_kontrak_model->get_kontrak($id_kontrak_pekerjaan)->row_array();

        $pdf = new Format_register_kontrak('P', 'mm', 'a4');
        $pdf->SetTopMargin(4);
        $pdf->SetLeftMargin(4);
        $pdf->AddPage();
        $pdf->SetTitle('Registrasi Kontrak');
        $pdf->SetAuthor(nama_user());
        $pdf->SetCompression(true);

        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Cell(3);
        $pdf->Cell(100, 5, 'No Registrasi : ' . $kontrak['no_kontrak'], 0, 1, 'L');
        $pdf->Cell(3);
        $pdf->Cell(100, 5, 'SKPD : ' . $kontrak['nama_instansi'], 0, 1, 'L');
        $pdf->Cell(3);
        $pdf->Cell(100, 5, 'Sub Kegiatan : ' . $kontrak['nama_sub_kegiatan'], 0, 1, 'L');

        $pdf->Output('Register Kontrak.pdf', 'I');
    }




    public function simpan_progress_pekerjaan()
    {
        if (!$this->input->is_ajax_request()) {
            show_404();
        } else {
            $output = [
                'status' => false,
                'data'   => []
            ];




            $validation     = $this->form_validation;
            $validation->set_rules($this->rules_save_progress());
            $validation->set_error_delimiters('<div class="invalid-feedback w-100">', '</div>');

            if ($validation->run($this)) {
                










                 $id                 = $this->input->post('id');
            $id_paket_pekerjaan = $this->input->post('id_paket_pekerjaan');
            $persen            = $this->input->post('persen');
            $keterangan            = $this->input->post('keterangan');
            $tgl            = $this->input->post('tgl');
            $inputnamadokumen = $persen . '-'.date('Ymdhis');
            $primary_folder     = './sbe_files_data/';
            $directory          = [
                tahun_anggaran(),
                id_instansi(),
                'PROGRESS-PEKERJAAN',
                $id_paket_pekerjaan,
            ];
            $list_directory = $this->sbe_directory($primary_folder, $directory);

            if (!file_exists($list_directory)) {
                mkdir($list_directory, 0777, TRUE);
            }
            // untuk menghapus file sebelumnya
        
            // untuk menghapus file sebelumnya

            $namafiledisimpan = str_replace(" ", "_", $inputnamadokumen);
            $config['upload_path']   = $list_directory;
            $config['overwrite']     = true;
            $config['allowed_types'] = 'jpg|jpeg|png|JPG|JPEG|PNG';
            $config['encrypt_name']  = false;
            $config['file_name']     = $namafiledisimpan;
            $config['max_size']      = '10000';

            $this->load->library('upload', $config);

            if (!$this->upload->do_upload($id)) {
                $output['status']   = false;
                $output['error']  = 1;
                $output['message']  = $this->upload->display_errors();
            } else {
                    
                $upload = ['upload_data' => $this->upload->data()];
                   $file_ext = pathinfo($_FILES["file"]["name"], PATHINFO_EXTENSION);
                   $data_insert = [
                'id_paket_pekerjaan' => $id_paket_pekerjaan,
                'keterangan' => nl2br($keterangan),
                'tgl_pengambilan' => $tgl,
                'foto' => $namafiledisimpan.'.'.$file_ext,
                'persentasi' => $persen,
                'created_on' => timestamp(),
                'created_by' => id_user(),
                   ];
                $this->db->insert('progress_pekerjaan', $data_insert);
                $output['error']  = 0;
                $output['status']   = true;
            }








            } else {
                $output['status']       = false;
                foreach ($_POST as $key => $value) {
                    $output['messages'][$key] = form_error($key);
                }
            }

            echo json_encode($output);




           
        }
    }




    public function data_progress_pekerjaan()
    {
        if (!$this->input->is_ajax_request()) {
            show_404();
        } else {
            $output = [
                'status'    => false,
                'data'      => [],
                'message'   => ''
            ];

            
            $id_paket_pekerjaan = $this->input->post('id_paket_pekerjaan');
            $data_progress = $this->db->query("SELECT * from progress_pekerjaan where id_paket_pekerjaan = '$id_paket_pekerjaan'");
            $paket = $this->db->query("SELECT nama_paket from paket_pekerjaan where id_paket_pekerjaan = '$id_paket_pekerjaan'")->row();


            $primary_folder     = 'sbe_files_data/';
            $directory          = [
                $this->sbe_tahun_anggaran(),
                id_instansi(),
                'PROGRESS-PEKERJAAN',
                $id_paket_pekerjaan,
            ];
            $list_directory     = $this->sbe_directory($primary_folder, $directory);
            if ($data_progress->num_rows() > 0) {
                foreach ($data_progress->result() as $key => $value) {
                    $output['data'][$key]['id_paket_pekerjaan'] = $value->id_paket_pekerjaan;
                    $output['data'][$key]['keterangan'] = $value->keterangan;
                    $output['data'][$key]['progress'] = $value->persentasi;
                    $output['data'][$key]['gambar'] = base_url().$list_directory.$value->foto;
                    $output['data'][$key]['tanggal'] = $value->tgl_pengambilan;
                    $output['data'][$key]['action'] = '<button type="button" class="btn btn-danger btn-xs" onclick="hapus_progress(\''.$value->id_progress_pekerjaan.'\',\''.$value->foto.'\',\''.$value->id_paket_pekerjaan.'\')"><i class="fa fa-trash"></i></button>';
                    
                }

                $output['paket'] = $paket->nama_paket;
                $output['status'] = true;
            }

            echo json_encode($output);
        }
    }

    public function persen_max_progress_pekerjaan()
    {
        if (!$this->input->is_ajax_request()) {
            show_404();
        } else {

            
            $id_paket_pekerjaan = $this->input->post('id_paket_pekerjaan');
            $persentasi = $this->db->query("SELECT max(persentasi) as progress from progress_pekerjaan where id_paket_pekerjaan = '$id_paket_pekerjaan'");
           
            $paket = $this->db->query("SELECT nama_paket from paket_pekerjaan where id_paket_pekerjaan = '$id_paket_pekerjaan'")->row();
           

                $output['persentasi'] = $persentasi->row()->progress =='' ? 0 : $persentasi->row()->progress;
                $output['paket'] = $paket->nama_paket;
                $output['cek'] = $id_paket_pekerjaan;
            

            echo json_encode($output);
        }
    }
}
