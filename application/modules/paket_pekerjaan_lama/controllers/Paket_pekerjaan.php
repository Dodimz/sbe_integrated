<?php

/**
 * Author     : Alfikri, M.Kom
 * Created By : Alfikri, M.Kom
 * E-Mail     : alfikri.name@gmail.com
 * No HP      : 081277337405
 * Class      : Paket_pekerjaan.php
 */
defined('BASEPATH') or exit('No direct script access allowed');

class Paket_pekerjaan extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->form_validation->CI = &$this;
        $this->load->model([
            'paket_pekerjaan/master_paket_model'      => 'master_paket_model',
            'datatables_model'                         => 'datatables_model'
        ]);
    }

    public function master_paket()
    {
        $breadcrumbs     = $this->breadcrumbs;
        $master_paket   = $this->master_paket_model;

        $breadcrumbs->add('Home', base_url());
        $breadcrumbs->add('Paket Pekerjaan', base_url($this->router->fetch_class()));
        $breadcrumbs->add('Master Paket', base_url());
        $breadcrumbs->render();

        $data['title']                      = "Master Paket";
        $data['icon']                       = "metismenu-icon fa fa-list-ul";
        $data['description']                = "Menampilkan Paket Pekerjaan";
        $data['breadcrumbs']                = $breadcrumbs->render();
        $data['tot_paket_pekerjaan']        = $master_paket->total_paket_pekerjaan();
        $data['tot_paket_pekerjaan_rutin']  = $master_paket->total_jenis_paket_pekerjaan('RUTIN');
        $data['tot_paket_pekerjaan_swa']    = $master_paket->total_jenis_paket_pekerjaan('SWAKELOLA');
        $data['tot_paket_pekerjaan_pen']    = $master_paket->total_jenis_paket_pekerjaan('PENYEDIA');
        $data['tot_paket_kontruksi']        = $master_paket->total_paket_kontruksi();
        $page                               = 'paket_pekerjaan/master_paket/index';
        $data['link']                       = $this->router->fetch_method();
        $data['menu']                       = $this->load->view('layout/menu', $data, true);
        $data['extra_css']                  = $this->load->view('paket_pekerjaan/master_paket/css', $data, true);
        $data['extra_js']                   = $this->load->view('paket_pekerjaan/master_paket/js', $data, true);
        $data['modal']                      = $this->load->view('paket_pekerjaan/master_paket/modal', $data, true);
        $this->template->load('backend_template', $page, $data);
    }


    public function kelola_export_paket()
    {
        $breadcrumbs     = $this->breadcrumbs;
        $master_paket   = $this->master_paket_model;

        $breadcrumbs->add('Home', base_url());
        $breadcrumbs->add('Paket Pekerjaan', base_url($this->router->fetch_class()));
        $breadcrumbs->add('Master Paket', base_url());
        $breadcrumbs->render();

        $data['title']                      = "Master Paket -  Input By Export Data";
        $data['icon']                       = "metismenu-icon fa fa-list-ul";
        $data['description']                = "Menampilkan Paket Pekerjaan Yang Sudah Di Export Melalui excel ";
        $data['breadcrumbs']                = $breadcrumbs->render();
        $data['tot_paket_pekerjaan']        = $master_paket->total_paket_pekerjaan();
        $data['tot_paket_pekerjaan_rutin']  = $master_paket->total_jenis_paket_pekerjaan('RUTIN');
        $data['tot_paket_pekerjaan_swa']    = $master_paket->total_jenis_paket_pekerjaan('SWAKELOLA');
        $data['tot_paket_pekerjaan_pen']    = $master_paket->total_jenis_paket_pekerjaan('PENYEDIA');
        $data['tot_paket_kontruksi']        = $master_paket->total_paket_kontruksi();
        $page                               = 'paket_pekerjaan/master_paket/kelola_export_paket';
        $data['link']                       = $this->router->fetch_method();
        $data['menu']                       = $this->load->view('layout/menu', $data, true);
        $data['extra_css']                  = $this->load->view('paket_pekerjaan/master_paket/css', $data, true);
        $data['extra_js']                   = $this->load->view('paket_pekerjaan/master_paket/js', $data, true);
        $data['modal']                      = $this->load->view('paket_pekerjaan/master_paket/modal', $data, true);
        $this->template->load('backend_template', $page, $data);
    }
    public function dt_kpa()
    {
        if (!$this->input->is_ajax_request()) {
            show_404();
        } else {
            if ($this->session->userdata('kedudukan') == 'PPTK') {
                $where = ['id_instansi' => id_instansi(), 'id_kedudukan' => 2, 'id_sub_instansi' => $this->sbe_id_sub_instansi()];
            } else {
                $where = ['id_instansi' => id_instansi(), 'id_kedudukan' => 2];
            }
            $column_order   = ['', 'nama_sub_instansi', 'full_name'];
            $column_search  = ['nama_sub_instansi', 'full_name'];
            $order          = ['nama_sub_instansi' => 'ASC'];
            $list           = $this->datatables_model->get_datatables('v_kpa', $column_order, $column_search, $order, $where);
            $data           = [];
            $no             = $_POST['start'];
            foreach ($list as $lists) {
                $row    = [];
                $row[]     = '<button class="btn btn-info btn-sm" id="show-pptk" id-user="' . $lists->id_user . '"><i class="fa fa-plus"></i></button>';
                $row[]  = '<strong>' . $lists->nama_sub_instansi . '</strong>';
                $row[]  = '<strong>' . $lists->full_name . '</strong>';
                $row[]  = $lists->jml_pptk;

                $data[] = $row;
            }

            $output = [
                "draw"              => $_POST['draw'],
                "recordsTotal"      => $this->datatables_model->count_all('v_kpa', $where),
                "recordsFiltered"   => $this->datatables_model->count_filtered('v_kpa', $column_order, $column_search, $order, $where),
                "data"              => $data,
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
                    $output['data'][$key]['jml_keg']         = $this->jumlah_sub_kegiatan($value->id_user).' Sub ';
                    $output['data'][$key]['jml_paket']         = $this->jumlah_paket($value->id_user);
                } else :
                $output['status']     = false;
                $output['message']     = 'Gagal';
            endif;

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

            $kode_sub_kegiatan = $this->input->post('kode_sub_kegiatan');
            $kode_kegiatan = $this->input->post('kode_kegiatan');
            $kode_program = $this->input->post('kode_program');
            $kode_bidang_urusan = $this->input->post('kode_bidang_urusan');
            $q = $this->master_paket_model->anggaran_kegiatan_terpakai($kode_sub_kegiatan,$kode_kegiatan,$kode_program,$kode_bidang_urusan);
            $cek_anggaran_terpakai = $q->anggaran_terpakai;
            $pagu_kegiatan = $q->pagu;
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

    protected function jumlah_sub_kegiatan($id_user)
    {
        return $this->db->query("SELECT COUNT(*) AS jml FROM users_sub_kegiatan WHERE id_user = " . $id_user)->row()->jml;
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


    public function list_sub_kegiatan()
    {
        if (!$this->input->is_ajax_request()) {
            show_404();
        } else {
            $output = [
                'status'     => false,
                'data'         => [],
                'message'     => '',
           
            ];
            $id_user     =$this->input->post('id_user');
            $where      = [
                'id_user' => $id_user,
                'id_instansi' => id_instansi(),
                'kode_tahap' => tahapan_apbd()
            ];
            $id_instansi = id_instansi();
            $tahap = tahapan_apbd();
            $kegiatan     = $this->master_paket_model->sub_kegiatan_pptk($id_user, id_instansi(), tahapan_apbd());
            if ($kegiatan->num_rows() > 0) :
                $output['status']     = true;
                $output['message']     = 'Sukses';
                foreach ($kegiatan->result() as $key => $value) {
                    $pecah = explode('.', $value->kode_rekening_sub_kegiatan);
                    $kode_sub_kegiatan = $pecah[0].'.'.$pecah[1].'.'.$pecah[2].'.'.$pecah[3].'.'.$pecah[4].'.'.$pecah[5];
                    $output['data'][$key]['id_pptk']     = $value->id_user;
                    $output['data'][$key]['kode_sub_kegiatan']     = $value->kode_rekening_sub_kegiatan;


                    $nama_sub_kegiatan = $value->kategori =='Sub Kegiatan SKPD' ? $value->nama_sub_kegiatan : $value->nama_sub_kegiatan.'<br>'.$value->jenis_sub_kegiatan.' - '.$value->keterangan; 
                    $output['data'][$key]['kode_bidang_urusan'] = $value->kode_bidang_urusan;
                    $output['data'][$key]['kode_kegiatan'] = $value->kode_rekening_kegiatan;
                    $output['data'][$key]['kode_program'] = $value->kode_rekening_program;
                    $output['data'][$key]['sub_kegiatan']     = $nama_sub_kegiatan;
                    $krsk = $value->kode_rekening_sub_kegiatan;
                    $krk = $value->kode_rekening_kegiatan;
                    $krp = $value->kode_rekening_program;
                    $kbu = $value->kode_bidang_urusan;
                    $qpagu = $this->db->query("SELECT pagu from v_sub_kegiatan_apbd where id_instansi='$id_instansi' and kode_tahap='$tahap' and kode_rekening_sub_kegiatan='$krsk' and kode_rekening_kegiatan='$krk' and kode_rekening_program='$krp' and kode_bidang_urusan='$kbu'")->row()->pagu;

                    $jumlah_paket = $this->db->query("SELECT id_paket_pekerjaan from paket_pekerjaan where 
                        id_instansi='$id_instansi' and kode_rekening_sub_kegiatan='$krsk'
                        ")->num_rows();
                    $output['data'][$key]['jml_paket']     = $jumlah_paket;
                    $output['data'][$key]['pagu']     = $qpagu==''? 0: number_format($qpagu);
                }

                //$output['kedudukan'] = $this->session->userdata('kedudukan');
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
                'rules' => 'required|trim'//|callback_valid_nama_paket'
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

    public function save_master_paket()
    {
        if (!$this->input->is_ajax_request()) {
            show_404();
        } else {
            $output    = [
                'success' => false,
                'messages' => []
            ];
            $data_group     = [];
            $master_paket     = $this->master_paket_model;
            $validation     = $this->form_validation;
            $validation->set_rules($this->rules_save($this->input->post('jenis_paket')));
            $validation->set_error_delimiters('<p class="text-danger">', '</p>');

            if ($validation->run($this)) {
                $post               = $this->input->post();
                if ($post['pagu'] > $post['anggaran_tersedia']) {
                    $output['success'] = true;
                    $output['messages'] = "Anggaran paket melebihi pagu kegiatan";
                    $output['anggaran_dibolehkan'] = number_format($post['anggaran_tersedia']);
                }else{
                    $id_paket_pekerjaan = $master_paket->save_master_paket();
                    $output['success']     = true;
                    $output['messages'] = "Paket berhasil di simpan";
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

    public function update_master_paket()
    {
        if (!$this->input->is_ajax_request()) {
            show_404();
        } else {
            $output = [
                'success' => false,
                'messages' => []
            ];
            $data_group     = [];
            $master_paket   = $this->master_paket_model;
            $validation     = $this->form_validation;
            $validation->set_rules($master_paket->rules_update());
            $validation->set_error_delimiters('<p class="text-danger">', '</p>');

            if ($validation->run()) {
                $post               = $this->input->post();
                $jenis_input = $post['input_type'];
                $id_paket_pekerjaan = $post['id_paket_pekerjaan'];
                $anggaran_dibolehkan = $post['anggaran_tersedia'] + $post['anggaran_sebelumnya'];
                if ($post['pagu'] > $anggaran_dibolehkan) {
                    $output['success'] = true;
                    $output['messages'] = "Anggaran paket melebihi pagu kegiatan";
                    $output['anggaran_dibolehkan'] = number_format($anggaran_dibolehkan);
                }else{
                    $master_paket->update_master_paket($id_paket_pekerjaan);
                    $output['success']  = true;
                    $output['messages'] = "Paket berhasil di update";
                    $output['input_type'] = $jenis_input;
                }
                // 
                // $master_paket->update_master_paket($id_paket_pekerjaan);
                // $output['success']  = true;
                // $output['messages'] = "Paket berhasil di update";
            } else {
                $output['success'] = false;
                foreach ($_POST as $key => $value) {
                    $output['messages'][$key] = form_error($key);
                }
            }

            echo json_encode($output);
        }
    }

    public function update_pelaksanaan($data_group)
    {
        foreach ($data_group as $key => $value) {
            $this->db->update('vol_pelaksanaan_pekerjaan', [
                'jenis_paket' => $value['jenis_paket'],
                'nama_pelaksanaan' => $value['nama_pelaksanaan']
            ]);
        }
    }

    public function dt_paket()
    {
        if (!$this->input->is_ajax_request()) {
            show_404();
        } else {
            $id_pptk         = $this->input->post('id_pptk');
            $kode_rekening  = $this->input->post('kode_rekening');
            $where          = ['id_instansi' => id_instansi(), 'kode_rekening_sub_kegiatan' => $kode_rekening];
            $column_order   = ['', 'nama_paket'];
            $column_search  = ['nama_paket'];
            $order          = ['nama_paket' => 'ASC'];
            $list           = $this->datatables_model->get_datatables('v_paket', $column_order, $column_search, $order, $where);
            $data           = [];
            $no             = $_POST['start'];
            foreach ($list as $lists) {
                $no++;
                $row    = [];
                $row[]     = $no;
                $row[]  = $lists->nama_paket;
                $row[]  = $lists->jenis_paket;
                $row[]  = $lists->jenis_paket == 'RUTIN' ? '' : $lists->metode;
                $row[]  = $lists->jenis_paket == 'RUTIN' ? '' : ($this->lokasi_paket_pekerjaan($lists->id_paket_pekerjaan) == 0 ? '<button class="btn btn-outline-primary" onclick="lokasi(' . "'" . $lists->id_paket_pekerjaan . "'" . ')">Belum Ada</button>' : '<button class="btn btn-outline-primary" onclick="lokasi(' . "'" . $lists->id_paket_pekerjaan . "','input'" . ')">' . $this->lokasi_paket_pekerjaan($lists->id_paket_pekerjaan) . ' Lokasi</button>');
                $row[]  = $lists->jenis_paket == 'RUTIN' ? '' : '<button class="btn btn-outline-primary" onclick="volume(' . "'" . $lists->id_paket_pekerjaan . "','input'" . ')">' . $lists->volume . '</button>';
                $row[]  = number_format($lists->pagu);
                $row[]  = '<button class="btn btn-info btn-sm" onclick="edit_paket(' . "'" . $lists->id_paket_pekerjaan . "','input'" . ')"><i class="fas fa-edit"></i></button> <button class="btn btn-danger btn-sm" onclick="delete_paket(' . "'" . $lists->id_paket_pekerjaan . "','input'" . ')"><i class="fa fa-times"></i></button>';

                $data[] = $row;
            }

            $output = [
                "draw"              => $_POST['draw'],
                "recordsTotal"      => $this->datatables_model->count_all('v_paket', $where),
                "recordsFiltered"   => $this->datatables_model->count_filtered('v_paket', $column_order, $column_search, $order, $where),
                "data"              => $data,
            ];

            echo json_encode($output);
        }
    }
    public function dt_paket_export()
    {
        if (!$this->input->is_ajax_request()) {
            show_404();
        } else {
            $id_pptk         = $this->input->post('id_pptk');
            $kode_rekening  = $this->input->post('kode_rekening');
            $where          = ['id_instansi' => id_instansi(), 'input_by' => "Export Excel"];
            $column_order   = ['', 'nama_paket'];
            $column_search  = ['nama_paket'];
            $order          = ['nama_paket' => 'ASC'];
            $list           = $this->datatables_model->get_datatables('v_paket', $column_order, $column_search, $order, $where);
            $data           = [];
            $no             = $_POST['start'];
            foreach ($list as $lists) {
                $no++;
                $row    = [];
                $row[]     = $no;
                $row[]  = $lists->nama_pptk;
                $row[]  = $lists->kode_rekening_kegiatan;
                $row[]  = $lists->nama_kegiatan;
                $row[]  = $lists->nama_paket;
                $row[]  = $lists->jenis_paket;
                $row[]  = $lists->jenis_paket == 'RUTIN' ? '' : $lists->metode;
                $row[]  = $lists->jenis_paket == 'RUTIN' ? '' : ($this->lokasi_paket_pekerjaan($lists->id_paket_pekerjaan) == false ? '<button class="btn btn-outline-primary" onclick="lokasi(' . "'" . $lists->id_paket_pekerjaan . "','export'" . ')">Belum Ada</button>' : '<button class="btn btn-outline-primary" onclick="lokasi(' . "'" . $lists->id_paket_pekerjaan . "','export'" . ')">' . $this->lokasi_paket_pekerjaan($lists->id_paket_pekerjaan).' Lokasi' . '</button>');
                $row[]  = $lists->jenis_paket == 'RUTIN' ? '' : '<button class="btn btn-outline-primary" onclick="volume(' . "'" . $lists->id_paket_pekerjaan . "','export'" . ')">' . $lists->volume . '</button>';
                $row[]  = number_format($lists->pagu);
                $row[]  = '<button class="btn btn-info btn-xs" onclick="edit_paket(' . "'" . $lists->id_paket_pekerjaan . "','export'" . ')"><i class="fas fa-edit"></i></button> <button class="btn btn-danger btn-xs" onclick="delete_paket(' . "'" . $lists->id_paket_pekerjaan . "', 'export'" . ')"><i class="fa fa-times"></i></button>';

                $data[] = $row;
            }

            $output = [
                "draw"              => $_POST['draw'],
                "recordsTotal"      => $this->datatables_model->count_all('v_paket', $where),
                "recordsFiltered"   => $this->datatables_model->count_filtered('v_paket', $column_order, $column_search, $order, $where),
                "data"              => $data,
            ];

            echo json_encode($output);
        }
    }

    protected function lokasi_paket_pekerjaan($id_paket_pekerjaan)
    {
        if ($id_paket_pekerjaan) {
            $list     = $this->db->get_where('v_lokasi_paket_pekerjaan', ['id_paket_pekerjaan' => $id_paket_pekerjaan])->num_rows();
            $hasil     = $list;
           
            return $hasil;
        }
    }

    public function get_project()
    {
        if (!$this->input->is_ajax_request()) {
            show_404();
        } else {
            $result = $this->db->get('projects')->result();
            echo json_encode($result);
        }
    }

    public function get_paket_pekerjaan()
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

            $id_paket_pekerjaan = $this->input->post('id_paket_pekerjaan');
            $paket_pekerjaan    = $this->db->get_where('paket_pekerjaan', ['id_paket_pekerjaan' => $id_paket_pekerjaan, 'id_instansi' => id_instansi()]);
            if ($paket_pekerjaan->num_rows() > 0) {
                foreach ($paket_pekerjaan->result() as $key => $value) {
                    $output['data']['id_pptk']                  = $value->id_pptk;
                    $output['data']['kode_bidang_urusan']   = $value->kode_bidang_urusan;
                    $output['data']['kode_rekening_program']   = $value->kode_rekening_program;
                    $output['data']['kode_rekening_kegiatan']   = $value->kode_rekening_kegiatan;
                    $output['data']['kode_rekening_sub_kegiatan']   = $value->kode_rekening_sub_kegiatan ;
                    $output['data']['nama_paket']               = $value->nama_paket;
                    $output['data']['jenis_paket']              = $value->jenis_paket;
                    $output['data']['kategori']                 = $value->kategori;
                    $output['data']['id_metode']                = $value->id_metode;
                    $output['data']['pagu']                     = $value->pagu;
                }

                $volume = $this->db->get_where('vol_pelaksanaan_pekerjaan', ['id_paket_pekerjaan' => $id_paket_pekerjaan, 'id_instansi' => id_instansi()]);

                foreach ($volume->result() as $key => $value) {
                    $output['volume'][$key]['id_volume'] = $value->id_vol_pelaksanaan_pekerjaan;
                    $output['volume'][$key]['pelaksanaan_ke'] = $value->pelaksanaan_ke;
                    $output['volume'][$key]['nama_pelaksanaan'] = $value->nama_pelaksanaan;
                }

                $lokasi = $this->db->get_where('lokasi_paket_pekerjaan', ['id_paket_pekerjaan' => $id_paket_pekerjaan, 'id_instansi' => id_instansi()]);
                foreach ($lokasi->result() as $key => $value) {
                    $output['lokasi'][] = $value->id_kab_kota;
                }

                $output['status'] = true;
            }

            echo json_encode($output);
        }
    }

    public function dt_vol()
    {
        if (!$this->input->is_ajax_request()) {
            show_404();
        } else {
            $id_paket_pekerjaan = $this->input->post('id_paket_pekerjaan');
            $tipe_input = $this->input->post('tipe_input');

            $where          = ['id_instansi' => id_instansi(), 'id_paket_pekerjaan' => $id_paket_pekerjaan];
            $column_order   = ['', 'nama'];
            $column_search  = ['nama'];
            $order          = ['nama' => 'ASC'];
            $list           = $this->datatables_model->get_datatables('vol_pelaksanaan_pekerjaan', $column_order, $column_search, $order, $where);
            $data           = [];
            $no             = $_POST['start'];
            $jumlah_volume  = $this->master_paket_model->total_volume($id_paket_pekerjaan);
            foreach ($list as $lists) {
                $row    = [];
                $row[]  = $lists->pelaksanaan_ke;
                $row[]  = $lists->nama_pelaksanaan;
                // $row[]  = '<a href="javascript:void(0)" onclick="edit_vol(this)" pk="'.$lists->id_vol_pelaksanaan_pekerjaan.'"  id_paket="'.$lists->id_paket_pekerjaan.'" class="edit" data-type="text" >'.$lists->nama_pelaksanaan.'</a>';

                    // if ($jumlah_volume==$lists->pelaksanaan_ke) {
                    $row[]  = '<button class="btn btn-sm btn-danger btn-xs" onclick="delete_vol(' . "'" . $lists->id_vol_pelaksanaan_pekerjaan . "','" . $lists->id_paket_pekerjaan . "','" . $lists->pelaksanaan_ke . "','".$tipe_input."'" . ')"><i class="fas fa-trash"></i></button>';
                    // }else{
                    //      $row[]  = "";
                    // }

                $data[] = $row;
            }

            $output = [
                "draw"              => $_POST['draw'],
                "recordsTotal"      => $this->datatables_model->count_all('vol_pelaksanaan_pekerjaan', $where),
                "recordsFiltered"   => $this->datatables_model->count_filtered('vol_pelaksanaan_pekerjaan', $column_order, $column_search, $order, $where),
                "data"              => $data,
            ];

            echo json_encode($output);
        }
    }

    public function save_vol()
    {
        if (!$this->input->is_ajax_request()) {
            show_404();
        } else {
            $output = [
                'status'    => false,
                'id_pptk'   => '',
                'rekening'  => ''
            ];

            $id_paket_pekerjaan = $this->input->post('id_paket');
            $tipe_input = $this->input->post('tipe_input');
            $nama_pelaksanaan   = $this->input->post('nama_pelaksanaan');
            $no                 = $this->db->get_where('vol_pelaksanaan_pekerjaan', ['id_instansi' => id_instansi(), 'id_paket_pekerjaan' => $id_paket_pekerjaan])->num_rows();
            $data            = $this->db->get_where('paket_pekerjaan', ['id_instansi' => id_instansi(), 'id_paket_pekerjaan' => $id_paket_pekerjaan])->row_array();



            $simpan = $this->db->insert('vol_pelaksanaan_pekerjaan', [
                'id_paket_pekerjaan' => $id_paket_pekerjaan,
                'id_instansi' => id_instansi(),
                'tahun' => tahun_anggaran(),
                'pelaksanaan_ke' => $no + 1,
                'nama_pelaksanaan' => $nama_pelaksanaan,
                'created_on'              => timestamp(),
                'updated_on'               => timestamp(),
                'created_by'               => id_user()
             //   'updated_by'               => id_user()
            ]);
            $data_evidence = $this->master_paket_model->get_file_evidence_laporan($id_paket_pekerjaan);
             $evidence = $data_evidence->row();
             if($data_evidence->num_rows()>0){

                $nama_file_evidence = $evidence->file_dokumen;
               
                $primary_folder         = './sbe_files_data/';
                $directory              = [
                    $this->sbe_tahun_anggaran(),
                    slug($this->sbe_nama_instansi(id_instansi())),
                    'REALISASI-FISIK',
                    $id_paket_pekerjaan,
                    
                ];
                $list_directory         = $this->sbe_directory($primary_folder, $directory);
                $this->sbe_delete_files($list_directory.'/'.$nama_file_evidence);


                // hapus data di database
                $id_rf = $evidence->id_realisasi_fisik;
                $this->db->delete('realisasi_fisik', ['id_realisasi_fisik' => $id_rf]);
             }



            if ($simpan) {
                $output['status']   = true;
                $output['id_pptk']  = $data['id_pptk'];
                $output['rekening'] = $data['kode_rekening_sub_kegiatan'];
                $output['input'] = $tipe_input;
            } else {
                $output['status'] = false;
            }

            echo json_encode($output);
        }
    }


    public function urutkan_pelaksanaan($id_paket_pekerjaan)
    {
        
            // $id_paket_pekerjaan = $this->input->post('id_paket');
            $volume = $this->master_paket_model->volume_paket($id_paket_pekerjaan);
                foreach ($volume->result() as $key => $value) {
                    $ke = $key+1;
                    $where = ['id_vol_pelaksanaan_pekerjaan'=>$value->id_vol_pelaksanaan_pekerjaan];
                    $data = ['pelaksanaan_ke'=>$ke];
                    $this->db->update('vol_pelaksanaan_pekerjaan', $data, $where);

                   // $where_fisik = [];
                    $dokumen_key = 'PELAKSANAAN-'.$ke.'_'.$value->nama_pelaksanaan.'___'.$value->id_vol_pelaksanaan_pekerjaan;
                    $data_fisik = ['dokumen'=> $dokumen_key];
                    $this->db->update('realisasi_fisik', $data_fisik, $where);
                }
          

         
        
    }

    public function dt_lokasi()
    {
        if (!$this->input->is_ajax_request()) {
            show_404();
        } else {
            $id_paket_pekerjaan = $this->input->post('id_paket_pekerjaan');
            $where          = ['id_instansi' => id_instansi(), 'id_paket_pekerjaan' => $id_paket_pekerjaan];
            $column_order   = ['', 'nama_kecamatan'];
            $column_search  = ['nama_kecamatan','nama_kota','nama_provinsi'];
            $order          = ['nama_kecamatan' => 'ASC'];
            $list           = $this->datatables_model->get_datatables('v_lokasi_paket_pekerjaan', $column_order, $column_search, $order, $where);
            $data           = [];
            $no             = $_POST['start'];
            foreach ($list as $lists) {
                $no++;
                $row    = [];
                $row[]  = $no;
                $row[]  = $lists->nama_provinsi. '<br> '.$lists->nama_kota;
                $row[]  = $lists->nama_kecamatan;
                
                $row[]  = '<button class="btn btn-sm btn-danger" onclick="delete_lokasi(' . "'" . $lists->id_lokasi_paket_pekerjaan . "','" . $lists->id_paket_pekerjaan . "'" . ')">x</button>';

                $data[] = $row;
            }

            $output = [
                "draw"              => $_POST['draw'],
                "recordsTotal"      => $this->datatables_model->count_all('v_lokasi_paket_pekerjaan', $where),
                "recordsFiltered"   => $this->datatables_model->count_filtered('v_lokasi_paket_pekerjaan', $column_order, $column_search, $order, $where),
                "data"              => $data,
            ];

            echo json_encode($output);
        }
    }

    // public function save_lokasi()
    // {
    //     if (!$this->input->is_ajax_request()) {
    //         show_404();
    //     } else {
    //         $output = [
    //             'status'    => false,
    //             'id_pptk'   => '',
    //             'rekening'  => ''
    //         ];

    //         $id_paket_pekerjaan = $this->input->post('id_paket');
    //         $id_kab_kota        = $this->input->post('id_kab_kota');
    //         $data               = $this->db->get_where('paket_pekerjaan', ['id_instansi' => id_instansi(), 'id_paket_pekerjaan' => $id_paket_pekerjaan])->row_array();
    //         $simpan = $this->db->insert('lokasi_paket_pekerjaan', [
    //             'id_paket_pekerjaan' => $id_paket_pekerjaan,
    //             'id_instansi' => id_instansi(),
    //             'id_kab_kota' => $id_kab_kota
    //         ]);
    //         if ($simpan) {
    //             $output['status']   = true;
    //             $output['id_pptk']  = $data['id_pptk'];
    //             $output['rekening'] = $data['kode_rekening_kegiatan'];
    //         } else {
    //             $output['status'] = false;
    //         }

    //         echo json_encode($output);
    //     }
    // }

    public function save_lokasi()
    {
        if (!$this->input->is_ajax_request()) {
            show_404();
        } else {
            $output    = [
                'success' => false,
                'messages' => []
            ];
            
            $post               = $this->input->post();
            $master_paket     = $this->master_paket_model;
            $validation     = $this->form_validation;
            $validation->set_rules($this->rules_lokasi());
            $validation->set_error_delimiters('<p class="text-danger">', '</p>');
            $id_paket_pekerjaan = $this->input->post('id_paket');
            $input_type = $this->input->post('input_type');
            if ($validation->run($this)) {
                $data               = $this->db->get_where('paket_pekerjaan', ['id_instansi' => id_instansi(), 'id_paket_pekerjaan' => $id_paket_pekerjaan])->row_array();
                
                $kec                =$post['id_kecamatan'];
                $kab_kota                =$post['id_kab_kota'];
                 $simpan = $this->db->insert('lokasi_paket_pekerjaan', [
                    'id_paket_pekerjaan' => $id_paket_pekerjaan,
                    'id_instansi' => id_instansi(),
                    'id_kab_kota' => $kab_kota,
                    'id_kecamatan' => $kec
                ]);
                if ($simpan) {
                    $output['status']   = true;
                    $output['id_pptk']  = $data['id_pptk'];
                    $output['rekening'] = $data['kode_rekening_sub_kegiatan'];
                    $output['input_by'] = $input_type  ;
                } else {
                    $output['status'] = false;
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

    public function delete_lokasi()
    {
        if (!$this->input->is_ajax_request()) {
            show_404();
        } else {
            $output = [
                'status'    => false,
                'id_pptk'   => '',
                'rekening'  => ''
            ];

            $id_lokasi_paket_pekerjaan  = $this->input->post('id_lokasi_paket_pekerjaan');
            $id_paket_pekerjaan         = $this->input->post('id_paket_pekerjaan');
            $lokasi                     = $this->db->get_where('lokasi_paket_pekerjaan', ['id_lokasi_paket_pekerjaan' => $id_lokasi_paket_pekerjaan]);
            $data                       = $this->db->get_where('paket_pekerjaan', ['id_instansi' => id_instansi(), 'id_paket_pekerjaan' => $id_paket_pekerjaan])->row_array();
            if ($lokasi->num_rows() > 0) {
                $this->db->delete('lokasi_paket_pekerjaan', ['id_lokasi_paket_pekerjaan' => $id_lokasi_paket_pekerjaan]);
                $output['status']   = true;
                $output['id_pptk']  = $data['id_pptk'];
                $output['rekening'] = $data['kode_rekening_sub_kegiatan'];
            }

            echo json_encode($output);
        }
    }

    public function delete_vol()
    {
        if (!$this->input->is_ajax_request()) {
            show_404();
        } else {
            $output = [
                'status'    => false,
                'id_pptk'   => '',
                'rekening'  => ''
            ];

            $id_vol_pelaksanaan_pekerjaan   = $this->input->post('id_vol_pelaksanaan_pekerjaan');
            $id_paket_pekerjaan             = $this->input->post('id_paket_pekerjaan');
            $vol                            = $this->db->get_where('vol_pelaksanaan_pekerjaan', ['id_vol_pelaksanaan_pekerjaan' => $id_vol_pelaksanaan_pekerjaan]);
            $data                           = $this->db->get_where('paket_pekerjaan', ['id_instansi' => id_instansi(), 'id_paket_pekerjaan' => $id_paket_pekerjaan])->row_array();
            if ($vol->num_rows() > 0) {
                $cek_realisasi_fisik = $this->master_paket_model->get_id_realisasi_fisik($id_paket_pekerjaan, $id_vol_pelaksanaan_pekerjaan)->num_rows();
                if ($cek_realisasi_fisik >0) {
                    $id_realisasi_fisik = $this->master_paket_model->get_id_realisasi_fisik($id_paket_pekerjaan, $id_vol_pelaksanaan_pekerjaan)->row()->id_realisasi_fisik;
                    $evidence = $this->master_paket_model->get_file_evidence($id_paket_pekerjaan, $id_realisasi_fisik);
                    # code...
                    $value = $evidence->row();
                    //foreach ($evidence->result() as $key => $value) {
                        // hapus file di server
                        $nama_file_evidence = $value->file_dokumen;
                        $primary_folder         = './sbe_files_data/';
                        $directory              = [
                            $this->sbe_tahun_anggaran(),
                            slug($this->sbe_nama_instansi(id_instansi())),
                            'REALISASI-FISIK',
                            $id_paket_pekerjaan,
                            
                        ];


                        $list_directory         = $this->sbe_directory($primary_folder, $directory);
                        $this->sbe_delete_files($list_directory.'/'.$nama_file_evidence);


                        // hapus data di database
                        $id_rf = $value->id_realisasi_fisik;
                        // $this->db->delete('realisasi_fisik', ['id_realisasi_fisik' => $id_rf]);
                    //}
                $this->db->delete('realisasi_fisik', ['id_realisasi_fisik' => $id_rf]);





                        // $file_laporan = $this->master_paket_model->get_file_evidence_laporan($id_paket_pekerjaan);
                        // if ($file_laporan->num_rows()>0) {
                        //     $file_laporan_disimpan = $file_laporan->row()->file_dokumen;
                        //     $this->db->delete('realisasi_fisik', ['id_paket_pekerjaan' => $id_paket_pekerjaan, ' dokumen_key'=>"LAPORAN"]);
                        //     $this->sbe_delete_files($list_directory.'/'.$file_laporan_disimpan);
                            
                        // }
                }


                $this->db->delete('vol_pelaksanaan_pekerjaan', ['id_vol_pelaksanaan_pekerjaan' => $id_vol_pelaksanaan_pekerjaan]);

                $this->urutkan_pelaksanaan($id_paket_pekerjaan);
               

                $output['status']   = true;
                $output['id_pptk']  = $data['id_pptk'];
                $output['rekening'] = $data['kode_rekening_sub_kegiatan'];
            }

            echo json_encode($output);
        }
    }

    public function delete_paket()
    {
        if (!$this->input->is_ajax_request()) {
            show_404();
        } else {
            $output = [
                'status'    => false,
                'id_pptk'   => '',
                'rekening'  => ''
            ];

            $id_paket_pekerjaan = $this->input->post('id_paket');
            $paket_pekerjaan    = $this->db->get_where('paket_pekerjaan', ['id_paket_pekerjaan' => $id_paket_pekerjaan]);
            $data               = $this->db->get_where('paket_pekerjaan', ['id_instansi' => id_instansi(), 'id_paket_pekerjaan' => $id_paket_pekerjaan])->row_array();
            if ($paket_pekerjaan->num_rows() > 0) {
                $primary_folder         = './sbe_files_data/';
                $directory              = [
                    $this->sbe_tahun_anggaran(),
                    slug($this->sbe_nama_instansi(id_instansi())),
                    'REALISASI-FISIK',
                    $id_paket_pekerjaan,
                ];
                $list_directory         = $this->sbe_directory($primary_folder, $directory);

                $this->sbe_delete_files($list_directory);
                $this->db->delete('realisasi_fisik', ['id_paket_pekerjaan' => $id_paket_pekerjaan]);
                $this->db->delete('realisasi_fisik', ['id_paket_pekerjaan' => $id_paket_pekerjaan]);
                $this->db->delete('paket_pekerjaan', ['id_paket_pekerjaan' => $id_paket_pekerjaan]);

                $output['status']   = true;
                $output['id_pptk']  = $data['id_pptk'];
                $output['rekening'] = $data['kode_rekening_sub_kegiatan'];
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



    public function export_paket()
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
                'export_program',
               id_instansi(),
            ];
            $list_directory = $this->sbe_directory($primary_folder, $directory);

            if (!file_exists($list_directory)) {
                mkdir($list_directory, 0777, TRUE);
            }
            // untuk menghapus file sebelumnya
        
            // untuk menghapus file sebelumnya

            $namafiledisimpan = "Program_".id_instansi()."_".date('Ymdhis');
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
                $paket             = $loadexcel->setActiveSheetIndex(1)->toArray(true, true, true ,true);
                
                $this->db->trans_start();

                $data_paket = array();
                $id_instansi = id_instansi();
                $kode_opd = $this->master_paket_model->kode_opd_instansi($id_instansi)->kode_opd;
                $numrow = 1;
                $error = 0;
                $pesan = "";
                foreach($paket as $row){
                            if($numrow > 1){


                                //cek beris kosong
                                if ($row['B']==NULL) {
                                    $error = $error +1;
                                    $pesan .="Kode Program Belum diisi pada baris ".$numrow.'<br>';
                                    $bariserror = $numrow;
                                }
                                if ($row['C']==NULL) {
                                    $error = $error +1;
                                    $pesan .="Kode Kegiatan Belum diisi pada baris ".$numrow.'<br>';
                                    $bariserror = $numrow;
                                }
                                if ($row['D']==NULL) {
                                    $error = $error +1;
                                    $pesan .="Ada nama paket Belum diisi pada baris ".$numrow.'<br>';
                                    $bariserror = $numrow;
                                }
                                if ($row['E']==NULL) {
                                    $error = $error +1;
                                    $pesan .="Jenis Paket ".$numrow.'<br>';
                                    $bariserror = $numrow;
                                }
                              
                                if ($row['G']==NULL) {
                                    $error = $error +1;
                                    $pesan .="Kode Program Belum diisi pada baris ".$numrow.'<br>';
                                    $bariserror = $numrow;
                                }
                                if (trim($row['H'])=='') {
                                    $error = $error +1;
                                    $pesan .="Pagu paket belum diisi pada baris ".$numrow.'<br>';
                                    $bariserror = $numrow;
                                }

                                $kode_rekening = $kode_opd.trim($row['B']).trim($row['C']);
                               @ $pptk = $this->master_paket_model->get_pptk($kode_rekening)->id_user == "" ? "Tidak" : $this->master_paket_model->get_pptk($kode_rekening)->id_user;
                         
                                if ($pptk==NULL) {
                                    $error = $error +1;
                                    $pesan .="PPTK tidak ditemukan pada baris. Harap cocokkan lagi pada baris ".$numrow.'<br>';
                                    $bariserror = $numrow;
                                }

                                if ($row['E']!="RUTIN") {
                                    # code...
                                   $cekmetode = $this->master_paket_model->cek_metode($row['E'], $row['G']);
                                    if ($cekmetode==0) {
                                       $error = $error +1;
                                        $pesan .="Kode metode yang anda buat tidak cocok. harap periksa kembali. kesalahan pada baris  ".$numrow.'<br>'; 
                                        $bariserror = $numrow;
                                    }
                                }

                                if ($row['E']=="PENYEDIA") {
                                   $kategori = $row['F'] == "KONTRUKSI" ? "KONTRUKSI" : "NON KONTRUKSI";
                                }


                             





                                array_push($data_paket, array(
                                  
                                    'id_instansi'      => $id_instansi,
                                   'id_pptk'      => $pptk,
                                   'kode_rekening_kegiatan'      => $kode_rekening,
                                    'kode_urusan'      => "",
                                    'tahun'      => tahun_anggaran(),
                                    'nama_paket'      => $row['D'],
                                    'jenis_paket'      => $row['E'],
                                    'kategori'      => $row['E']=="PENYEDIA" ? $kategori : "",
                                    'id_metode'      => $row['E'] == "RUTIN" ? "" : $row['G'],
                                    'pagu'      => $row['H'] == "" ? 0 : $row['H'],
                                    'created_on'      => timestamp(),
                                    'updated_on'      => "",
                                    'created_by'      => id_user(),
                                    'updated_by'      => "",
                                    'input_by '      => "Export Excel",
                                ));
                                    }
                                $numrow++;
                            }
               
            $this->db->insert_batch('paket_pekerjaan', $data_paket);
            // $this->db->insert_batch('tes_cronjob', $data2);

             

                  
                $upload = ['upload_data' => $this->upload->data()];
                $file_ext = pathinfo($_FILES["upload_file"]["name"], PATHINFO_EXTENSION);
                $output['status']   = true;


                if ($error>0) {
                    $this->db->trans_rollback();
                    $pesan_flashdata = '<div class="alert alert-info">'.$pesan.'</div>';
                    # code...
                }else{
                    $this->db->trans_commit();
                    $pesan_flashdata = '<div class="alert alert-info">Program berhail di export</div>';
                    // $pesan_flashdata = '<div class="alert alert-info">Program berhail di export</div>';

                }
            }
            // $output['cek'] = $list_directory;
            // echo json_encode($output);
            $this->session->set_flashdata('pesan', $pesan_flashdata);
            redirect('paket_pekerjaan/kelola_export_paket');
        }
    }

}
