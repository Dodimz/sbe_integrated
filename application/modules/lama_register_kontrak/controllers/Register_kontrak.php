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

        $data['title']          = "Buat Kontrak";
        $data['icon']           = "metismenu-icon fas fa-file-signature";
        $data['description']    = "Buat register kontrak paket pekerjaan kontruksi";
        $data['breadcrumbs']    = $breadcrumbs->render();
        $page                   = 'register_kontrak/buat_kontrak/index';
        $data['link']           = $this->router->fetch_method();
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
        $data['link']           = $this->router->fetch_method();
        $data['id_kontrak']     = $id_kontrak;
        $data['menu']           = $this->load->view('layout/menu', $data, true);
        $data['extra_css']      = $this->load->view('register_kontrak/edit_kontrak/css', $data, true);
        $data['extra_js']       = $this->load->view('register_kontrak/edit_kontrak/js', $data, true);
        $data['modal']          = $this->load->view('register_kontrak/edit_kontrak/modal', $data, true);
        $this->template->load('backend_template', $page, $data);
    }


    public function tampilkan_koordinat_terpilih($lat, $long)
    {
        $data['latitude'] = trim($lat);
        $data['longitude'] = trim($long);

        $data['extra_css']      = $this->load->view('register_kontrak/buat_kontrak/titik_koordinat_terpilih', $data);
        // $data['extra_js']       = $this->load->view('register_kontrak/buat_kontrak/js_koordinat_terpilih', $data, true);
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
                    $id_instansi = id_instansi();
                    $tahap = tahapan_apbd();
                    $q_ask = $this->db->query("SELECT total_anggaran_sub_kegiatan('$kode_rekening_sub_kegiatan', '$tahap','$id_instansi','$kode_kegiatan','$kode_program') as anggaran_sub_kegiatan")->row();
                    
                    $pecah_nomor = explode('/', $value['no_kontrak']);


                    $output['data']['id_kontrak']        = sbe_crypt($id_kontrak, 'E');
                    $output['data']['nama_pptk']        = $value['nama_pptk'];
                    $output['data']['nama_kegiatan']    = $value['nama_sub_kegiatan'];
                    $output['data']['pagu_kegiatan']    = $q_ask->anggaran_sub_kegiatan ;
                    $output['data']['pagu_paket']       = $value['pagu_paket'];
                    $output['data']['tgl_awal_pelaksanaan']       = $value['tgl_awal_pelaksanaan'];
                    $output['data']['tgl_akhir_pelaksanaan']       = $value['tgl_akhir_pelaksanaan'];
                    $output['data']['nilai_kontrak']       = $value['nilai_kontrak'];
                    $output['data']['latitude_ok']       = $value['latitude'];
                    $output['data']['longitude_ok']       = $value['longitude'];
                    $output['data']['no_register_kontrak']       = $pecah_nomor[2];
                    $output['data']['pelaksana']       = $value['pelaksana'];



            
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
                'field' => 'id_paket_pekerjaan',
                'label' => 'Paket Pekerjaan',
                'rules' => 'required|trim'
            ],
            [
                'field' => 'no_register_kontrak',
                'label' => 'No Register Kontrak',
                'rules' => 'required|trim'
            ],
            [
                'field' => 'pelaksana',
                'label' => 'Nama Pelaksana',
                'rules' => 'required|trim'
            ],
            [
                'field' => 'tgl_awal_pelaksanaan',
                'label' => 'Tanggal Awal Pelaksanaan',
                'rules' => 'required|trim'
            ],
            [
                'field' => 'tgl_akhir_pelaksanaan',
                'label' => 'Tanggal Akhir Pelaksanaan',
                'rules' => 'required|trim'
            ],
            [
                'field' => 'nilai_kontrak',
                'label' => 'Nilai Kontrak',
                'rules' => 'required|numeric|trim|greater_than[0]|callback_valid_nilai_kontrak'
            ],
            [
                'field' => 'status_lokasi',
                'label' => 'Status Lokasi',
                'rules' => 'callback_valid_status_lokasi'
            ],
            [
                'field' => 'latitude_ok',
                'label' => 'Latitude',
                'rules' => 'required'
            ],
            [
                'field' => 'longitude_ok',
                'label' => 'Longitude',
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

        $data['title']          = "Lokasi Kontrak";
        $data['icon']           = "metismenu-icon fa fa-map";
        $data['description']    = "Lokasi Kontrak Pekerjaan Kontruksi";
        $data['breadcrumbs']    = $breadcrumbs->render();
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

        $data['title']               = "Daftar Kontrak";
        $data['icon']                = "metismenu-icon fas fa-file-signature";
        $data['description']         = "Daftar Kontrak Pekerjaan";
        $data['breadcrumbs']         = $breadcrumbs->render();
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
            $where          = ['id_instansi' => id_instansi()];
            $column_order   = ['', 'no_kontrak', 'pelaksana'];
            $column_search  = ['no_kontrak'];
            $order          = ['no_kontrak' => 'ASC'];
            $list           = $this->datatables_model->get_datatables('kontrak_pekerjaan', $column_order, $column_search, $order, $where);
            $data           = [];
            $no             = $_POST['start'];
            foreach ($list as $lists) {
                $no++;
                $row    = [];
                $row[]  = $no;
                $row[]  = $lists->no_kontrak;
                $row[]  = $lists->pelaksana;
                $row[]  = date('d-m-Y h:i:s', $lists->tgl_register_kontrak);
                $row[]  = $lists->tgl_awal_pelaksanaan;
                $row[]  = $lists->tgl_akhir_pelaksanaan;
                $row[]  = number_format($lists->nilai_kontrak);
                $row[]  = '<a href="' . base_url('register_kontrak/laporan_register_kontrak/' . $lists->id_kontrak_pekerjaan) . '" class="btn btn-primary btn-sm" target="_blank"><i class="fa fa-print" aria-hidden="true"></i>
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
}
