<?php

/**
 * Author     : Alfikri, M.Kom
 * Created By : Alfikri, M.Kom
 * E-Mail     : alfikri.name@gmail.com
 * No HP      : 081277337405
 * Class      : Realisasi.php
 */
defined('BASEPATH') or exit('No direct script access allowed');

class Realisasi extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model([
            'realisasi/realisasi_fisik_model'       => 'realisasi_fisik_model',
            'realisasi/realisasi_keuangan_model'    => 'realisasi_keuangan_model',
            'realisasi/dokumen_evidence_model'      => 'dokumen_evidence_model',
            'validasi/validasi_fisik_model' => 'validasi_fisik_model',
            'datatables_model'                      => 'datatables_model'
        ]);
    }

    public function fisik()
    {
        $breadcrumbs        = $this->breadcrumbs;
        $realisasi_fisik    = $this->realisasi_fisik_model;

        $breadcrumbs->add('Home', base_url());
        $breadcrumbs->add('Realisasi', base_url($this->router->fetch_class()));
        $breadcrumbs->add('Fisik', base_url());
        $breadcrumbs->render();

        $data['title']       = "Realisasi Fisik";
        $data['icon']        = "metismenu-icon fa fa-list-ul";
        $data['description'] = "Input Realisasi Fisik";
        $data['breadcrumbs'] = $breadcrumbs->render();
        $page                = 'realisasi/fisik/index';
        $data['link']        = $this->router->fetch_method();
        $data['menu']        = $this->load->view('layout/menu', $data, true);
        $data['extra_css']   = $this->load->view('realisasi/fisik/css', $data, true);
        $data['extra_js']    = $this->load->view('realisasi/fisik/js', $data, true);
        $data['modal']       = $this->load->view('realisasi/fisik/modal', $data, true);

        $config              = $this->db->get_where('config',['id_config'=>'SBE2018'])->row();
        $prs                = explode(' ', $config->realisasi_fisik_selesai);
        $jam_deadline       = $prs[1];
        $ptrs               = explode('-', $prs[0]);
        $tgl_deadline       = $ptrs[2].'-'.$ptrs[1].'-'.$ptrs[0];
        $data['deadline']        = $tgl_deadline.' | '.$jam_deadline;

        $cek_helpdesk = $realisasi_fisik->helpdesk();
        if ($cek_helpdesk->num_rows()==0) {
            $helpdesk = "Belum ditentukan";
        }else{
            $helpdesk = $cek_helpdesk->row()->helpdesk;
        }
        $data['helpdesk']        = $helpdesk;


        $validasi_fisik = $this->validasi_fisik_model;
        $data['total_paket']           = $validasi_fisik->total_paket_pekerjaan();
        $data['total_paket_rutin']     = $validasi_fisik->total_paket_rutin();
        $data['total_paket_swakelola'] = $validasi_fisik->total_paket_swakelola();
        $data['total_paket_penyedia']  = $validasi_fisik->total_paket_penyedia();
        $this->template->load('backend_template', $page, $data);
    }

    public function dt_kpa()
    {
        if (!$this->input->is_ajax_request()) {
            show_404();
        } else {
            if ($this->session->userdata('kedudukan') == 'PPTK') {
                $where = [
                    'id_instansi'       => id_instansi(),
                    'id_kedudukan'      => 2,
                    'id_sub_instansi'   => $this->sbe_id_sub_instansi()
                ];
            } else {
                $where = [
                    'id_instansi'   => id_instansi(),
                    'id_kedudukan'  => 2
                ];
            }
            $column_order   = ['', 'nama_sub_instansi', 'full_name'];
            $column_search  = ['nama_sub_instansi', 'full_name'];
            $order          = ['nama_sub_instansi' => 'ASC'];
            $list           = $this->datatables_model->get_datatables('v_kpa', $column_order, $column_search, $order, $where);
            $data           = [];
            $no             = $_POST['start'];
            foreach ($list as $lists) {
                $row    = [];
                $row[]  = '<button class="btn btn-info btn-sm" id="show-pptk" id-user="' . $lists->id_user . '"><i class="fa fa-plus"></i></button>';
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
                'status'    => false,
                'data'      => [],
                'message'   => ''
            ];

            $id_user_top_parent = $this->input->post('id_user_top_parent');
            $pptk               = $this->realisasi_fisik_model->pptk($id_user_top_parent);
            if ($pptk->num_rows() > 0) :
                $output['status']   = true;
                $output['message']  = 'Sukses';
                foreach ($pptk->result() as $key => $value) {
                    $output['data'][$key]['id_user']        = $value->id_user;
                    $output['data'][$key]['nama']           = $value->full_name;
                    $output['data'][$key]['sub_instansi']   = $value->nama_sub_instansi;
                    $output['data'][$key]['jml_keg']        = $this->jumlah_sub_kegiatan($value->id_user).' Sub ';
                    $output['data'][$key]['jml_paket']      = $this->jumlah_paket($value->id_user);
                }
            else :
                $output['status']   = false;
                $output['message']  = 'Gagal';
            endif;

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
                'status'    => false,
                'data'      => [],
                'message'   => '',
                'kedudukan' => ''
            ];
            $id_user    = $this->input->post('id_user');
            $where      = [
                'id_user'       => $id_user,
                'id_instansi'   => id_instansi(),
                'kode_tahap'    => tahapan_apbd()
            ];

            $kegiatan   = $this->realisasi_fisik_model->kegiatan_pptk($id_user, id_instansi(), tahapan_apbd());
            if ($kegiatan->num_rows() > 0) :
                $output['status']   = true;
                $output['message']  = 'Sukses';
                foreach ($kegiatan->result() as $key => $value) {
                    $output['data'][$key]['id_pptk']    = $value->id_user;
                    $output['data'][$key]['rekening']   = $value->kode_rekening_kegiatan;
                    $output['data'][$key]['kegiatan']   = $value->nama_kegiatan;
                    $output['data'][$key]['jml_paket']  = $value->jml_paket;
                }

                $output['kedudukan'] = $this->session->userdata('kedudukan');
            else :
                $output['status']   = false;
                $output['message']  = 'Gagal';
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
            $kegiatan     = $this->realisasi_fisik_model->sub_kegiatan_pptk($id_user, id_instansi(), tahapan_apbd());
            if ($kegiatan->num_rows() > 0) :
                $output['status']     = true;
                $output['message']     = 'Sukses';
                foreach ($kegiatan->result() as $key => $value) {
                	$pecah = explode('.', $value->kode_rekening_sub_kegiatan);
                    $kode_sub_kegiatan = $pecah[0].'.'.$pecah[1].'.'.$pecah[2].'.'.$pecah[3].'.'.$pecah[4].'.'.$pecah[5];
                    $output['data'][$key]['id_pptk']     = $value->id_user;
                    $output['data'][$key]['kode_sub_kegiatan']     = $value->kode_rekening_sub_kegiatan;
                    $output['data'][$key]['kode_rekening_sub_kegiatan']     = $value->kode_rekening_sub_kegiatan;
                    $output['data'][$key]['kode_bidang_urusan'] = $value->kode_bidang_urusan;
                    $output['data'][$key]['kode_kegiatan'] = $value->kode_rekening_kegiatan;
                    $output['data'][$key]['kode_program'] = $value->kode_rekening_program;

                    $nama_sub_kegiatan = $value->kategori =='Sub Kegiatan SKPD' ? $value->nama_sub_kegiatan : $value->nama_sub_kegiatan.'<br>'.$value->jenis_sub_kegiatan.' - '.$value->keterangan; 
                    $output['data'][$key]['sub_kegiatan']     = $nama_sub_kegiatan;

                    $output['data'][$key]['jml_paket']     = $value->jml_paket;
                    $krsk = $value->kode_rekening_sub_kegiatan;
                    $krk = $value->kode_rekening_kegiatan;
                    $krp = $value->kode_rekening_program;
                    $kbu = $value->kode_bidang_urusan;
                    $qpagu = $this->db->query("SELECT pagu from v_sub_kegiatan_apbd where id_instansi='$id_instansi' and kode_tahap='$tahap' and kode_rekening_sub_kegiatan='$krsk' and kode_rekening_kegiatan='$krk' and kode_rekening_program='$krp' and kode_bidang_urusan='$kbu'")->row()->pagu;
                    $output['data'][$key]['pagu']     = $qpagu==''? 0: number_format($qpagu);
                }

            else :
                $output['status']     = false;
                $output['message']     = 'Gagal';
            endif;

            echo json_encode($output);
        }
    }

    public function dt_paket()
    {
        if (!$this->input->is_ajax_request()) {
            show_404();
        } else {
            $id_pptk        = $this->input->post('id_pptk');
            $kode_rekening  = $this->input->post('kode_rekening');
            $where          = ['id_instansi' => id_instansi(), 'kode_rekening_sub_kegiatan' => $kode_rekening, 'jenis_paket !=' => 'RUTIN'];
            $column_order   = ['', 'nama_paket'];
            $column_search  = ['nama_paket'];
            $order          = ['nama_paket' => 'ASC'];
            $list           = $this->datatables_model->get_datatables('v_paket', $column_order, $column_search, $order, $where);
            $data           = [];
            $no             = $_POST['start'];
            foreach ($list as $lists) {
                $no++;
                $row    = [];
                $row[]  = $no;
                $row[]  = $lists->nama_paket;
                $row[]  = $lists->jenis_paket;
                $row[]  = $lists->metode;
                $row[]  = $this->lokasi_paket_pekerjaan($lists->id_paket_pekerjaan) == 0 ? 'Belum Ada' : 

        
                 '<button class="btn btn-outline-primary" onclick="lokasi(' . "'" . $lists->id_paket_pekerjaan . "','".$lists->nama_paket."'" . ')">' . $this->lokasi_paket_pekerjaan($lists->id_paket_pekerjaan).' Lokasi' . '</button>';

                $row[]  = $lists->volume;
                $row[]  = number_format($lists->pagu);

                if ($lists->id_metode=='') {
                     $row[]  = '<button class="btn btn-danger btn-sm" onclick="metode_null()"><i class="fas fa-minus-circle"></i></button>';
                }else{
                    if ($this->cek_realisasi_fisik($lists->id_paket_pekerjaan, $lists->jenis_paket, $lists->id_metode) == true) {
                        $row[]  = '<button class="btn btn-success btn-sm"><i class="fa fa-check"></i></button>';
                    } else {
                        if ($lists->volume > 0) {
                            if ( strtotime(timestamp()) > strtotime(deadline_upload()) ) {
                                 $row[]  = '<button class="btn btn-danger btn-sm" onclick="upload_berakhir()"><i class="fas fa-upload"></i></button>';
                            }else{

                            $row[]  = '<button class="btn btn-info btn-sm" onclick="upload_dokumen(' . "'" . $lists->id_instansi . "','" . $lists->id_kpa . "','" . $lists->id_pptk . "','" . $lists->id_paket_pekerjaan . "','" . $lists->kode_rekening_sub_kegiatan . "','" . $lists->nama_paket . "','" . $lists->jenis_paket . "','" . $lists->id_metode . "'" . ')"><i class="fas fa-upload"></i></button>';
                            }
                        } else {
                            $row[]  = '<button class="btn btn-danger btn-sm" onclick="volume_0()"><i class="fas fa-minus-circle"></i></button>';
                        }
                    }
                }

                $row[]  = '<button class="btn btn-info btn-sm" onclick="daftar_dokumen(' . "'" . sbe_crypt($lists->id_paket_pekerjaan, 'E') . "'" . ')"><i class="fa fa-list-ul"></i></button>';

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
    public function list_dokumen()
    {
        if (!$this->input->is_ajax_request()) {
            show_404();
        } else {
            $output = [
                'status'    => false,
                'data'      => [],
                'message'   => '',
                'cek'       => []
            ];

            $id_instansi            = $this->input->post('id_instansi');
            $id_pptk                = $this->input->post('id_pptk');
            $id_paket_pekerjaan     = $this->input->post('id_paket_pekerjaan');
            $kode_rekening_kegiatan = $this->input->post('kode_rekening_sub_kegiatan');
            $jenis_paket            = $this->input->post('jenis_paket');
            $id_metode              = $this->input->post('id_metode');


            $realisasi_fisik = $this->db->get_where('realisasi_fisik', [
                'id_instansi'               => $id_instansi,
                'id_pptk'                   => $id_pptk,
                'id_paket_pekerjaan'        => $id_paket_pekerjaan,
                'kode_rekening_sub_kegiatan'    => $kode_rekening_kegiatan
            ]);

            $where   = ['jenis_paket' => $jenis_paket, 'id_metode' => $id_metode];
            $dokumen = $this->db->get_where('master_bobot', $where);

            $rea        = [];
            $dok        = [];
            $judul_dok  = [];
            $list_pelaksanaan = [];
            if ($realisasi_fisik->num_rows() > 0) {
                foreach ($realisasi_fisik->result() as $key => $value) {
                    $rea[]  = $value->dokumen;
                }
            }

            if ($dokumen->num_rows() > 0) :
                $output['status']   = true;
                $output['message']  = 'Sukses';
                foreach ($dokumen->result() as $key => $value) {
                    $output['data'][$key]['nama_dokumen']   = $value->nama_dokumen;
                    $dok[]                                  = $value->nama_dokumen;
                }

                $result_pelaksanaan = $this->db->get_where('vol_pelaksanaan_pekerjaan', ['id_paket_pekerjaan' => $id_paket_pekerjaan]);

                foreach ($result_pelaksanaan->result() as $key => $value) {
                    $list_pelaksanaan[] = 'PELAKSANAAN-' . $value->pelaksanaan_ke . '_' . $value->nama_pelaksanaan. '___' . $value->id_vol_pelaksanaan_pekerjaan;
                }

                $this->sbe_array_insert($dok, $this->sbe_search_index("PELAKSANAAN", $dok), $list_pelaksanaan);
            else :
                $output['status']   = false;
                $output['message']  = 'Gagal';
            endif;

            $output['dok'] = $dok;
            $output['rea'] = $rea;
            $output['cek'] = array_values(array_diff_assoc($dok, $rea));

            echo json_encode($output);
        }
    }

    public function upload_file()
    {
        if (!$this->input->is_ajax_request()) {
            show_404();
        } else {
            $output = [
                'status'    => false,
                'data'      => [],
                'dokumen'   => [],
                'message'   => '',
                'cek'       => []
            ];

            $id_instansi            = $this->input->post('id_instansi');
            $id_kpa                 = $this->input->post('id_kpa');
            $id_pptk                = $this->input->post('id_pptk');
            $id_volume                = $this->input->post('id_volume');
            $fix_id_volume = str_replace("_", "", $id_volume);

            $kode_rekening_sub_kegiatan = $this->input->post('kode_rekening_sub_kegiatan');
            $pecah = explode('.', $kode_rekening_sub_kegiatan );
            $kode_sub_kegiatan = $pecah[0].'.'.$pecah[1].'.'.$pecah[2].'.'.$pecah[3].'.'.$pecah[4].'.'.$pecah[5];
            $kode_kegiatan = $pecah[0].'.'.$pecah[1].'.'.$pecah[2].'.'.$pecah[3].'.'.$pecah[4];
            $kode_program = $pecah[0].'.'.$pecah[1].'.'.$pecah[2];
            $kode_bu = $pecah[0].'.'.$pecah[1];


            $id_paket_pekerjaan     = $this->input->post('id_paket_pekerjaan');
            $jenis_paket            = $this->input->post('jenis_paket');
            $dokumen                = $this->input->post('dokumen');
            $dokumen_key            = $this->input->post('dokumen_key');
            $id                     = $this->input->post('id');
            $primary_folder         = './sbe_files_data/';
            $directory              = [
                $this->sbe_tahun_anggaran(),
                id_instansi(),
                'REALISASI-FISIK',
                $id_paket_pekerjaan,
            ];
            $list_directory         = $this->sbe_directory($primary_folder, $directory);

            if (!file_exists($list_directory)) {
                mkdir($list_directory, 0777, TRUE);
            }

            $config['upload_path']      = $list_directory;
            $config['overwrite']        = true;
            $config['allowed_types']    = 'pdf';
            $config['encrypt_name']     = false;
            $config['file_name']        = slug(str_replace('___'.$fix_id_volume, '', $dokumen)).'-'.date('Ymdhis');
            $config['max_size']         = '10000';

            $this->load->library('upload', $config);

            if (!$this->upload->do_upload($id)) {
                $output['status']   = false;
                $output['message']  = $this->upload->display_errors();
            } else {
                $upload = ['upload_data' => $this->upload->data()];

                $primary = [
                    'id_instansi'               => $id_instansi,
                    'id_pptk'                   => $id_pptk,
                    'id_paket_pekerjaan'        => $id_paket_pekerjaan,
                    'kode_rekening_sub_kegiatan'    => $kode_rekening_sub_kegiatan,
                    'dokumen'                   => $dokumen
                ];
                $simpan = [
                    'id_instansi'               => $id_instansi,
                    'id_pptk'                   => $id_pptk,
                    'id_paket_pekerjaan'        => $id_paket_pekerjaan,
                    'id_vol_pelaksanaan_pekerjaan'        => $fix_id_volume,
                    'kode_rekening_sub_kegiatan'    => $kode_rekening_sub_kegiatan,
                    'kode_rekening_kegiatan'    => $kode_kegiatan,
                    'kode_rekening_program'    => $kode_program,
                    'kode_bidang_urusan'    => $kode_bu,
                    'bulan'                     => bulan_aktif(),
                    'tahun'                     => $this->sbe_tahun_anggaran(),
                    'dokumen_key'               => $dokumen_key,
                    'dokumen'                   => $dokumen,
                    'file_dokumen'              => $upload['upload_data']['file_name'],
                    'nilai'                     => 0,
                    'created_on'                => timestamp(),
                  //  'updated_on'                => timestamp(),
                    'created_by'                => $this->sbe_id_user(),
                    'updated_by'                => $this->sbe_id_user()
                ];
                $update = [
                    'updated_on' => timestamp(),
                    'updated_by' => $this->sbe_id_user()
                ];

                $cek = $this->db->get_where('realisasi_fisik', $primary)->num_rows();
                if ($cek > 0) {
                    $this->db->update('realisasi_fisik', $update, $primary);
                } else {
                    $this->db->insert('realisasi_fisik', $simpan);
                }

                $output['status'] = true;
            }

            echo json_encode($output);
        }
    }

    public function dokumen_realisasi()
    {
        if (!$this->input->is_ajax_request()) {
            show_404();
        } else {
            $realisasi_fisik = $this->realisasi_fisik_model;

            $output = [
                'status' => false,
                'data'   => []
            ];

            $id_paket_pekerjaan = sbe_crypt($this->input->get('id_paket_pekerjaan'), 'D');
            $dokumen_realisasi  = $realisasi_fisik->dokumen_realisasi($id_paket_pekerjaan);
            $output['jumlah_evidence'] = $dokumen_realisasi->num_rows();
            $desc_paket  = $realisasi_fisik->total_nilai_realisasi($id_paket_pekerjaan);

            if ($dokumen_realisasi->num_rows()==0) {
                $output['caption'] = "<div class='alert alert-info'>Evidence belum di upload</div>";
            }else{
                foreach ($dokumen_realisasi->result() as $key => $value) {
                    $output['data'][$key]['dokumen'] = explode('_', $value->dokumen)[0];
                    $output['data'][$key]['file']    = $value->file;
                    $output['data'][$key]['nilai']   = $value->nilai > 0 ? '<button class="btn btn-success btn-sm">' . $value->nilai . '</button' : '<button class="btn btn-danger btn-sm" >' . $value->nilai . '</button> ' . 
                    '<a href="'.base_url('realisasi/evidence/'.sbe_crypt($value->id_realisasi_fisik)).'" class="btn btn-info btn-sm" data-toggle="tooltip" title="upload ulang evidence"><i class="metismenu-icon fas fa-file-signature"></i></a>'
                    ;
                    $output['status'] = true;
                }
                    $output['nilai'] = $desc_paket->total_nilai;
                    $output['id_paket_pekerjaan'] = $this->input->get('id_paket_pekerjaan');
            }

            $output['id_pptk'] = $desc_paket->id_pptk;
            $output['rekening'] = $desc_paket->kode_rekening_kegiatan;
            $output['nama_paket'] = $desc_paket->nama_paket;
            echo json_encode($output);
        }
    }



    public function hapus_evidence()
    {
        if (!$this->input->is_ajax_request()) {
            show_404();
        } else {
            $realisasi_fisik = $this->realisasi_fisik_model;

            $output = [
                'status' => false,
                'data'   => []
            ];

            $id_paket_pekerjaan = sbe_crypt($this->input->post('id_paket_pekerjaan'), 'D');




            $paket_pekerjaan    = $this->db->get_where('paket_pekerjaan', ['id_paket_pekerjaan' => $id_paket_pekerjaan]);
            $data               = $this->db->get_where('paket_pekerjaan', ['id_instansi' => id_instansi(), 'id_paket_pekerjaan' => $id_paket_pekerjaan])->row_array();
            if ($paket_pekerjaan->num_rows() > 0) {
                $primary_folder         = './sbe_files_data/';
                $directory              = [
                    $this->sbe_tahun_anggaran(),
                    id_instansi(),
                    'REALISASI-FISIK',
                    $id_paket_pekerjaan,
                ];
                $list_directory         = $this->sbe_directory($primary_folder, $directory);

                $this->sbe_delete_files($list_directory);
                $this->db->delete('realisasi_fisik', ['id_paket_pekerjaan' => $id_paket_pekerjaan]);
          

                $output['status']   = true;
                // $output['id_pptk']  = $data['id_pptk'];
                // $output['rekening'] = $data['kode_rekening_kegiatan'];
            }

 
            echo json_encode($output);
        }
    }
    public function evidence($id_realisasi_fisik)
    {
        if ($this->dokumen_evidence_model->cek_realisasi_fisik($id_realisasi_fisik)->num_rows() > 0) {

            $breadcrumbs            = $this->breadcrumbs;
            $breadcrumbs->add('Home', base_url());
            $breadcrumbs->add('Realisasi', base_url($this->router->fetch_class()));
            $breadcrumbs->add('Update Dokumen Evidence', base_url());
            $breadcrumbs->render();

            $data['title']          = "Update Dokumen Evidence";
            $data['icon']           = "metismenu-icon fa fa-check-circle";
            $data['r_fisik']        = $this->dokumen_evidence_model->cek_realisasi_fisik($id_realisasi_fisik)->row();
            if ($data['r_fisik']->status=='Ditolak') {
               $description = "Update Dokumen Fisik yang ditolak";
            }else{
               $description = "Update Dokumen Fisik belum di validasi";
            }
            $data['description']    = $description;
            $data['breadcrumbs']    = $breadcrumbs->render();
            $page                   = 'realisasi/update_dokumen_evidence/index';
            $data['link']           = $this->router->fetch_method();
            $data['menu']           = $this->load->view('layout/menu', $data, true);
            $data['extra_css']      = $this->load->view('realisasi/update_dokumen_evidence/css', $data, true);
            $data['extra_js']       = $this->load->view('realisasi/update_dokumen_evidence/js', $data, true);
            $data['modal']          = $this->load->view('realisasi/update_dokumen_evidence/modal', $data, true);
            $this->template->load('backend_template', $page, $data);
        } else {
            show_404();
        }
    }

    public function fix_evidence()
    {
        if (!$this->input->is_ajax_request()) {
            show_404();
        } else {
            $output = [
                'status' => false,
                'data'   => []
            ];

            $id                 = $this->input->post('id');
            $id_paket_pekerjaan = $this->input->post('id_paket_pekerjaan');
            $dokumen            = $this->input->post('dokumen');
            $filelama            = $this->input->post('filelama');
            $inputnamadokumen = $dokumen . '-'.date('Ymdhis');
            $primary_folder     = './sbe_files_data/';
            $directory          = [
                $this->sbe_tahun_anggaran(),
                id_instansi(),
                'REALISASI-FISIK',
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
            $config['allowed_types'] = 'pdf|zip';
            $config['encrypt_name']  = false;
            $config['file_name']     = $namafiledisimpan;
            $config['max_size']      = '10000';

            $this->load->library('upload', $config);

            if (!$this->upload->do_upload($id)) {
                $output['status']   = false;
                $output['message']  = $this->upload->display_errors();
            } else {
                    $cekfilelama = $list_directory.$filelama;
                     if (file_exists($cekfilelama)) {
                       unlink($cekfilelama);
                    }
                $upload = ['upload_data' => $this->upload->data()];
   $file_ext = pathinfo($_FILES["file"]["name"], PATHINFO_EXTENSION);
                $this->dokumen_evidence_model->update_realisasi_fisik($namafiledisimpan.'.'.$file_ext);

                $output['status']   = true;
            }

            echo json_encode($output);
        }
    }

    public function keuangan()
    {
        $breadcrumbs    = $this->breadcrumbs;
        $keuangan       = $this->realisasi_keuangan_model;

        $breadcrumbs->add('Home', base_url());
        $breadcrumbs->add('Realisasi', base_url($this->router->fetch_class()));
        $breadcrumbs->add('Keuangan', base_url());
        $breadcrumbs->render();

        $data['title']       = "Realisasi Keuangan";
        $data['icon']        = "metismenu-icon fas fa-money-bill";
        $data['description'] = "Menampilkan Realisasi Keuangan";
        $data['breadcrumbs'] = $breadcrumbs->render();
        $data['total']       = $this->data_realisasi(id_instansi())['total'];
        $data['persen_bo']   = $this->data_realisasi(id_instansi())['persen']['bo'];
        $data['persen_bm']  = $this->data_realisasi(id_instansi())['persen']['bm'];
        $data['persen_btt']   = $this->data_realisasi(id_instansi())['persen']['btt'];
        $data['persen_bt']   = $this->data_realisasi(id_instansi())['persen']['bt'];
        $data['persen_total']   = $this->data_realisasi(id_instansi())['persen']['total'];
        $data['keu_bo']      = $this->data_realisasi(id_instansi())['keu']['bo'];
        $data['keu_bm']     = $this->data_realisasi(id_instansi())['keu']['bm'];
        $data['keu_btt']      = $this->data_realisasi(id_instansi())['keu']['btt'];
        $data['keu_bt']      = $this->data_realisasi(id_instansi())['keu']['bt'];
        $data['keu_total']      = $this->data_realisasi(id_instansi())['keu']['total'];
        $data['total_anggaran']      = $this->data_realisasi(id_instansi())['anggaran'];
        $page                = 'realisasi/keuangan/index';
        $data['link']        = $this->router->fetch_method();
        $data['menu']        = $this->load->view('layout/menu', $data, true);
        $data['extra_css']   = $this->load->view('realisasi/keuangan/css', $data, true);
        $data['extra_js']    = $this->load->view('realisasi/keuangan/js', $data, true);
        $data['modal']       = $this->load->view('realisasi/keuangan/modal', $data, true);
        $this->template->load('backend_template', $page, $data);
    }

    protected function data_realisasi($id_instansi)
    {
        $keuangan   = $this->realisasi_keuangan_model;
        $output     = [
            'total'  => 0,
            'persen' => [],
            'keu'    => []
        ];

        $anggaran                = $keuangan->anggaran_apbd($id_instansi);
        $bo     = $keuangan->get_realisasi($id_instansi)->row()->realisasi_bo;
        $bm           = $keuangan->get_realisasi($id_instansi)->row()->realisasi_bm;
        $btt           = $keuangan->get_realisasi($id_instansi)->row()->realisasi_btt;
        $bt                   = $keuangan->get_realisasi($id_instansi)->row()->realisasi_btt;
        $total         = $keuangan->get_realisasi($id_instansi)->row()->total;

        $output['total']         = $total;
        $output['anggaran']         = $anggaran;
        @$output['persen']['bo']  = ROUND($bo =='' ? 0 : $bo / $anggaran * 100, 2);
        @$output['persen']['bm']  = ROUND($bm =='' ? 0 : $bm / $anggaran * 100, 2);
        @$output['persen']['btt'] = ROUND($btt =='' ? 0 : $btt / $anggaran * 100, 2);
        @$output['persen']['bt']  = ROUND($bt =='' ? 0 : $bt / $anggaran * 100, 2);
        @$output['persen']['total']  = ROUND($total =='' ? 0 : $total / $anggaran * 100, 2);

        $output['keu']['bo']     = $bo;
        $output['keu']['bm']    = $bm;
        $output['keu']['btt']    = $btt;
        $output['keu']['bt']     = $bt;
        $output['keu']['total']     = $total;

        return $output;
    }





    public function sub_kegiatan_apbd_instansi_gabungan()
    {
        if (!$this->input->is_ajax_request()) {
            show_404();
        } else {            
            $keuangan       = $this->realisasi_keuangan_model;
            $tahap = tahapan_apbd();
                $where          = ['kode_tahap'=>$tahap, 'id_instansi' => id_instansi()];
            $column_order   = ['', 'nama_sub_kegiatan'];
            $column_search  = ['nama_sub_kegiatan','kode_rekening_sub_kegiatan'];
            $order          = ['kode_rekening_sub_kegiatan' => 'ASC'];
            $list           = $this->datatables_model->get_datatables('v_sub_kegiatan_apbd', $column_order, $column_search, $order, $where);
            $data           = [];
            $no             = $_POST['start'];
            $id_instansi = id_instansi();
            foreach ($list as $lists) {
                $no++;
                $row    = [];
                $row[]     = $no;
                $kategori = $lists->kategori;
                $upel = $lists->kategori == 'Unit Pelaksana' ? '<br>'.$lists->jenis_sub_kegiatan .' - '.$lists->keterangan : '';
                $pecah = explode('.', $lists->kode_rekening_sub_kegiatan);
                $krsk = $pecah[0].'.'.$pecah[1].'.'.$pecah[2].'.'.$pecah[3].'.'.$pecah[4].'.'.$pecah[5];
                $row[]  = '<b>'.$krsk.'</b><br>'.$lists->nama_sub_kegiatan.$upel;

                $realisasi_dipilih = $keuangan->cek_realisasi_dipilih($lists->kode_rekening_sub_kegiatan, $tahap, $id_instansi)->row_array();






                $realisasi_bo = $keuangan->total_realisasi_perjenis($lists->kode_rekening_sub_kegiatan, $tahap, $id_instansi, 'realisasikan_bo')->row_array()['realisasi_bo'];
                $realisasi_bm = $keuangan->total_realisasi_perjenis($lists->kode_rekening_sub_kegiatan, $tahap, $id_instansi, 'realisasikan_bm')->row_array()['realisasi_bm'];
                $realisasi_btt = $keuangan->total_realisasi_perjenis($lists->kode_rekening_sub_kegiatan, $tahap, $id_instansi, 'realisasikan_btt')->row_array()['realisasi_btt'];
                $realisasi_bt = $keuangan->total_realisasi_perjenis($lists->kode_rekening_sub_kegiatan, $tahap, $id_instansi, 'realisasikan_bt')->row_array()['realisasi_bt'];


                

                $jumlah_realisasi_bo = $realisasi_bo =='' ? 0 : $realisasi_bo;
                $jumlah_realisasi_bm = $realisasi_bm =='' ? 0 : $realisasi_bm;
                $jumlah_realisasi_btt = $realisasi_btt =='' ? 0 : $realisasi_btt;
                $jumlah_realisasi_bt = $realisasi_bt =='' ? 0 : $realisasi_bt;





                $set_realisasi_bo = '<a href="#" title="Input Realisasi Belanja Operasi Sub  Kegiatan '.$lists->nama_sub_kegiatan.'"  onclick="input_realisasi('."'bo','".$lists->kode_rekening_sub_kegiatan."','".$lists->kode_rekening_kegiatan."','".$lists->kode_rekening_program."','".$lists->kode_bidang_urusan."','".$lists->pagu."','".$lists->kategori."'".')">'.number_format($jumlah_realisasi_bo).'</a> ';
                $set_realisasi_bm = '<a href="#" title="Input Realisasi Belanja Operasi Sub  Kegiatan '.$lists->nama_sub_kegiatan.'"  onclick="input_realisasi('."'bm','".$lists->kode_rekening_sub_kegiatan."','".$lists->kode_rekening_kegiatan."','".$lists->kode_rekening_program."','".$lists->kode_bidang_urusan."','".$lists->pagu."','".$lists->kategori."'".')">'.number_format($jumlah_realisasi_bm).'</a> ';
                $set_realisasi_btt = '<a href="#" title="Input Realisasi Belanja Operasi Sub  Kegiatan '.$lists->nama_sub_kegiatan.'"  onclick="input_realisasi('."'btt','".$lists->kode_rekening_sub_kegiatan."','".$lists->kode_rekening_kegiatan."','".$lists->kode_rekening_program."','".$lists->kode_bidang_urusan."','".$lists->pagu."','".$lists->kategori."'".')">'.number_format($jumlah_realisasi_btt).'</a> ';
                $set_realisasi_bt = '<a href="#" title="Input Realisasi Belanja Operasi Sub  Kegiatan '.$lists->nama_sub_kegiatan.'"  onclick="input_realisasi('."'bt','".$lists->kode_rekening_sub_kegiatan."','".$lists->kode_rekening_kegiatan."','".$lists->kode_rekening_program."','".$lists->kode_bidang_urusan."','".$lists->pagu."','".$lists->kategori."'".')">'.number_format($jumlah_realisasi_bt).'</a> ';

                $total_realisasi = $keuangan->total_realisasi($lists->kode_rekening_sub_kegiatan, $tahap, $id_instansi)->row_array()['total_realisasi'] ;
                @$persentasi = ( $total_realisasi =='' ? 0 : $total_realisasi / $lists->pagu) * 100;




                $row[]  =  $realisasi_dipilih['realisasikan_bo']==0 ? '-' : $set_realisasi_bo;
                $row[]  =  $realisasi_dipilih['realisasikan_bm']==0 ? '-' : $set_realisasi_bm;
                $row[]  =  $realisasi_dipilih['realisasikan_btt']==0 ? '-' : $set_realisasi_btt;
                $row[]  =  $realisasi_dipilih['realisasikan_bt']==0 ? '-' : $set_realisasi_bt;
               
                $row[]  = number_format($total_realisasi);
                $row[]  = $lists->pagu=='' ? 0 : number_format($lists->pagu);
                $row[]  = round($persentasi,2).' %';
              
      

               $onclick3 = "get_realisasi('".$lists->kode_rekening_sub_kegiatan."','".$lists->kode_rekening_kegiatan."', '".$lists->kode_rekening_program."','".tahapan_apbd()."','".$lists->kode_bidang_urusan."','".$lists->pagu."','".$lists->pagu."')";

               
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



 public function get_realisasi_keuangan()
    {
        if (!$this->input->is_ajax_request()) {
            show_404();
        } else {
            $output = [
                'status'    => false,
                'data'      => []
            ];
            $keuangan       = $this->realisasi_keuangan_model;

            // $kode_rekening_sub_kegiatan = '1.01.03.1.01.02';
            // $kode_kegiatan = '1.01.03.1.01';
            // $kode_program = '1.01.03';
            // $kode_bidang_urusan = '1.01';
            // $jenis_realisasi = 'bo';
            $kode_rekening_sub_kegiatan = $this->input->post('kode_rekening_sub_kegiatan');
            $kode_kegiatan = $this->input->post('kode_kegiatan');
            $kode_program = $this->input->post('kode_program');
            $kode_bidang_urusan = $this->input->post('kode_bidang_urusan');
            $jenis_realisasi = $this->input->post('jenis');
            $kategori = $this->input->post('kategori');
            $tahap = tahapan_apbd();
            $id_instansi = id_instansi();
            $bulan_aktif = bulan_aktif();

            $pecah = explode('.', $kode_rekening_sub_kegiatan);
            if ($kategori == "Unit Pelaksana") {
            	$krsk = $pecah[0].'.'.$pecah[1].'.'.$pecah[2].'.'.$pecah[3].'.'.$pecah[4].'.'.$pecah[5];
            }else{
            	$krsk = $kode_rekening_sub_kegiatan;
            }


            $whereask = [
                'kode_sub_kegiatan' => $kode_rekening_sub_kegiatan ,
                'kode_kegiatan' => $kode_kegiatan ,
                'kode_program' => $kode_program ,
                'kode_bidang_urusan' => $kode_bidang_urusan ,
                'id_instansi' => $id_instansi ,
                'kode_tahap' => $tahap
            ];
            $target                 = $this->db->query("SELECT id_target_apbd ,bulan from target_apbd
                where 
                kode_bidang_urusan ='$kode_bidang_urusan' and 
                kode_rekening_program ='$kode_program' and 
                kode_rekening_kegiatan ='$kode_kegiatan' and 
                kode_rekening_sub_kegiatan ='$kode_rekening_sub_kegiatan' and 
                kode_tahap ='$tahap' and 
                id_instansi ='$id_instansi' and 
                bulan<='$bulan_aktif' ");

            $subkeg                 = $this->db->query("SELECT nama_sub_kegiatan from master_sub_kegiatan where kode_sub_kegiatan='$krsk'")->row()->nama_sub_kegiatan;

            $upel = $this->db->query("SELECT * from sub_kegiatan_instansi where kode_sub_kegiatan='$kode_rekening_sub_kegiatan' and id_instansi='$id_instansi' and kategori='$kategori' and kode_tahap='$tahap'")->row();
            $output['totaldata']  = $target->num_rows();
            $output['nama_sub_kegiatan']  = $kategori == "Sub Kegiatan SKPD" ? $subkeg : $subkeg.'<br>'.$upel->jenis_sub_kegiatan .' - '. $upel->keterangan ;
            $output['nama_tahapan']  = nama_tahapan();
            if ($target->num_rows() > 0) {
                foreach ($target->result()  as $key => $value) {
                    $bulan = $value->bulan;
                    $where = "
                     kode_bidang_urusan='$kode_bidang_urusan'  and
                kode_program='$kode_program'  and
                kode_kegiatan='$kode_kegiatan'  and
                kode_sub_kegiatan='$kode_rekening_sub_kegiatan'  and
                kode_tahap='$tahap' and
                id_instansi='$id_instansi' and
                bulan = '$bulan'
                    ";
                    $realisasi = $keuangan->realisasi($where, $jenis_realisasi)->row_array();
                    $anggaran = $this->db->query("SELECT 
                         bo_bp, bo_bbj, bo_bs, bo_bh, bm_bmt, bm_bmpm, bm_bmgb, bm_bmjji, bm_bmatl, btt, bt_bbh, bt_bbk 
                     from anggaran_sub_kegiatan
                        where
                        kode_sub_kegiatan = '$kode_rekening_sub_kegiatan' and 
                        kode_kegiatan = '$kode_kegiatan' and 
                        kode_program = '$kode_program' and 
                        kode_bidang_urusan = '$kode_bidang_urusan' and 
                        id_instansi = '$id_instansi' and 
                        kode_tahap  = '$tahap' 
                        ");
                    $pagu = $anggaran->row_array();




                    $output['data'][$key]['id_target']         = sbe_crypt($value->id_target_apbd, 'E');
                    $output['data'][$key]['id_realisasi']         = sbe_crypt($realisasi['id_realisasi_keuangan']=='' ? '' : $realisasi['id_realisasi_keuangan'] , 'E');
                    $output['data'][$key]['bulan']      = $bulan;
                    if ($jenis_realisasi=='bo') {
                        $output['data'][$key]['bo_bp']      = $realisasi['bo_bp']=='' ? 0 : $realisasi['bo_bp'];
                        $output['data'][$key]['bo_bbj']      = $realisasi['bo_bbj']=='' ? 0 : $realisasi['bo_bbj'];
                        $output['data'][$key]['bo_bs']      = $realisasi['bo_bs']=='' ? 0 : $realisasi['bo_bs'];
                        $output['data'][$key]['bo_bh']      = $realisasi['bo_bh']=='' ? 0 : $realisasi['bo_bh'];

                        $output['data'][$key]['pagu_bo_bp']      = $pagu['bo_bp']=='' ? 0 : $pagu['bo_bp'];
                        $output['data'][$key]['pagu_bo_bbj']      = $pagu['bo_bbj']=='' ? 0 : $pagu['bo_bbj'];
                        $output['data'][$key]['pagu_bo_bs']      = $pagu['bo_bs']=='' ? 0 : $pagu['bo_bs'];
                        $output['data'][$key]['pagu_bo_bh']      = $pagu['bo_bh']=='' ? 0 : $pagu['bo_bh'];
                    }
                    else if ($jenis_realisasi=='bm') {
                        $output['data'][$key]['bm_bmt']      = $realisasi['bm_bmt']=='' ? 0 : $realisasi['bm_bmt'];
                        $output['data'][$key]['bm_bmpm']      = $realisasi['bm_bmpm']=='' ? 0 : $realisasi['bm_bmpm'];
                        $output['data'][$key]['bm_bmgb']      = $realisasi['bm_bmgb']=='' ? 0 : $realisasi['bm_bmgb'];
                        $output['data'][$key]['bm_bmjji']      = $realisasi['bm_bmjji']=='' ? 0 : $realisasi['bm_bmjji'];
                        $output['data'][$key]['bm_bmatl']      = $realisasi['bm_bmatl']=='' ? 0 : $realisasi['bm_bmatl'];

                        $output['data'][$key]['pagu_bm_bmt']      = $pagu['bm_bmt']=='' ? 0 : $pagu['bm_bmt'];
                        $output['data'][$key]['pagu_bm_bmpm']      = $pagu['bm_bmpm']=='' ? 0 : $pagu['bm_bmpm'];
                        $output['data'][$key]['pagu_bm_bmgb']      = $pagu['bm_bmgb']=='' ? 0 : $pagu['bm_bmgb'];
                        $output['data'][$key]['pagu_bm_bmjji']      = $pagu['bm_bmjji']=='' ? 0 : $pagu['bm_bmjji'];
                        $output['data'][$key]['pagu_bm_bmatl']      = $pagu['bm_bmatl']=='' ? 0 : $pagu['bm_bmatl'];
                    }
                    else if ($jenis_realisasi=='btt') {
                        $output['data'][$key]['btt']      = $realisasi['btt']=='' ? 0 : $realisasi['btt'];

                        $output['data'][$key]['pagu_btt']      = $pagu['btt']=='' ? 0 : $pagu['btt'];
                    }
                    else if ($jenis_realisasi=='bt') {
                        $output['data'][$key]['bt_bbh']      = $realisasi['bt_bbh']=='' ? 0 : $realisasi['bt_bbh'];
                        $output['data'][$key]['bt_bbk']      = $realisasi['bt_bbk']=='' ? 0 : $realisasi['bt_bbk'];

                        $output['data'][$key]['pagu_bt_bbh']      = $pagu['bt_bbh']=='' ? 0 : $pagu['bt_bbh'];
                        $output['data'][$key]['pagu_bt_bbk']      = $pagu['bt_bbk']=='' ? 0 : $pagu['bt_bbk'];
                    }
                }

                $output['status']  = true;
            } else {
                $output['status']  = false;
                
            }

            echo json_encode($output);
        }
    }


    public function dt_realisasi_keuangan()
    {
        if (!$this->input->is_ajax_request()) {
            show_404();
        } else {
            $kode_rekening_program = $this->input->post('kode_rekening_program');

            if (!$kode_rekening_program) {
                $where = [
                    'id_instansi'   => id_instansi(),
                    'kode_tahap'    => tahapan_apbd()
                ];
            } else {
                $where = [
                    'id_instansi'           => id_instansi(),
                    'kode_tahap'            => tahapan_apbd(),
                    'kode_rekening_program' => $kode_rekening_program
                ];
            }
            $column_order   = ['kode_rekening_kegiatan', 'nama_kegiatan', 'belanja_pegawai', 'belanja_barang_jasa', 'belanja_modal', 'pagu'];
            $column_search  = ['kode_rekening_kegiatan', 'nama_kegiatan'];
            $order          = ['kode_rekening_kegiatan' => 'ASC'];
            $list           = $this->datatables_model->get_datatables('v_kegiatan_apbd', $column_order, $column_search, $order, $where);
            $data           = [];
            $no             = $_POST['start'];
            foreach ($list as $lists) {
                $row    = [];
                $row[]  = $lists->kode_rekening_kegiatan;
                $row[]  = $lists->nama_kegiatan;
                $row[]  = number_format($this->get_data_realisasi(id_instansi(), $lists->kode_rekening_kegiatan)['bp'], 0, '', '.');
                $row[]  = number_format($this->get_data_realisasi(id_instansi(), $lists->kode_rekening_kegiatan)['bbj'], 0, '', '.');
                $row[]  = number_format($this->get_data_realisasi(id_instansi(), $lists->kode_rekening_kegiatan)['bm'], 0, '', '.');
                $row[]  = number_format($this->get_data_realisasi(id_instansi(), $lists->kode_rekening_kegiatan)['total'], 0, '', '.');
                $row[]  = '<button class="btn btn-success btn-sm" id="realisasi-keuangan" kode-rekening-kegiatan="' . $lists->kode_rekening_kegiatan . '" pagu="' . $lists->pagu . '"><i class="fas fa-money-bill"></i></button>';

                $data[] = $row;
            }

            $output = [
                "draw"              => $_POST['draw'],
                "recordsTotal"      => $this->datatables_model->count_all('v_kegiatan_apbd', $where),
                "recordsFiltered"   => $this->datatables_model->count_filtered('v_kegiatan_apbd', $column_order, $column_search, $order, $where),
                "data"              => $data,
            ];

            echo json_encode($output);
        }
    }

    protected function get_data_realisasi($id_instansi, $kode_rekening_kegiatan)
    {
        $keuangan   = $this->realisasi_keuangan_model;
        $output     = [
            'total' => 0,
            'bp'    => 0,
            'bbj'   => 0,
            'bm'    => 0
        ];

        $belanja_pegawai     = $keuangan->get_realisasi_kegiatan($id_instansi, $kode_rekening_kegiatan)->row_array();
        $belanja_barang_jasa = $keuangan->get_realisasi_kegiatan($id_instansi, $kode_rekening_kegiatan)->row_array();
        $belanja_modal       = $keuangan->get_realisasi_kegiatan($id_instansi, $kode_rekening_kegiatan)->row_array();
        $total               = $keuangan->get_realisasi_kegiatan($id_instansi, $kode_rekening_kegiatan)->row_array();

        $output['total']    = !empty($total['total']) ? $total['total'] : 0;
        $output['bp']       = !empty($belanja_pegawai['belanja_pegawai']) ? $belanja_pegawai['belanja_pegawai'] : 0;
        $output['bbj']      = !empty($belanja_barang_jasa['belanja_barang_jasa']) ? $belanja_barang_jasa['belanja_barang_jasa'] : 0;
        $output['bm']       = !empty($belanja_modal['belanja_modal']) ? $belanja_modal['belanja_modal'] : 0;

        return $output;
    }

    // public function get_realisasi_keuangan()
    // {
    //     if (!$this->input->is_ajax_request()) {
    //         show_404();
    //     } else {
    //         $output = [
    //             'status'    => false,
    //             'data'      => [],
    //             'opd'       => $this->db->get_where('master_instansi', ['id_instansi' => id_instansi()])->row()->sub_kategori,
    //             'message'   => ''
    //         ];


    //         $rekening           = $this->input->post('kode_rekening_kegiatan');
    //         $realisasi_keuangan = $this->db->order_by('bulan', 'ASC')->get_where('realisasi_keuangan', ['kode_rekening' => $rekening]);
    //         if ($realisasi_keuangan->num_rows() > 0) {
    //             $this->restruktur_keuangan($rekening);
    //             foreach ($realisasi_keuangan->result() as $key => $value) {
    //                 $output['data'][$key]['id']                     = $value->id_realisasi_keuangan;
    //                 $output['data'][$key]['bulan']                  = $value->bulan;
    //                 $output['data'][$key]['belanja_pegawai']        = $value->belanja_pegawai;
    //                 $output['data'][$key]['belanja_barang_jasa']    = $value->belanja_barang_jasa;
    //                 $output['data'][$key]['belanja_modal']          = $value->belanja_modal;
    //                 $output['data'][$key]['total']                  = $value->belanja_pegawai + $value->belanja_barang_jasa + $value->belanja_modal;
    //             }

    //             $output['status']   = true;
    //         } else {
    //             $this->restruktur_keuangan($rekening);
    //             $result = $this->db->order_by('bulan', 'ASC')->get_where('realisasi_keuangan', ['kode_rekening' => $rekening]);
    //             foreach ($result->result() as $key => $value) {
    //                 $output['data'][$key]['id']                     = $value->id_realisasi_keuangan;
    //                 $output['data'][$key]['bulan']                  = $value->bulan;
    //                 $output['data'][$key]['belanja_pegawai']        = $value->belanja_pegawai;
    //                 $output['data'][$key]['belanja_barang_jasa']    = $value->belanja_barang_jasa;
    //                 $output['data'][$key]['belanja_modal']          = $value->belanja_modal;
    //                 $output['data'][$key]['total']                  = $value->belanja_pegawai + $value->belanja_barang_jasa + $value->belanja_modal;
    //             }
    //             $output['status']   = true;
    //         }

    //         echo json_encode($output);
    //     }
    // }

    public function restruktur_keuangan($kode_rekening)
    {
        $data       = [];
        $kegiatan   = $this->db->get_where('kegiatan_apbd', ['kode_rekening' => $kode_rekening, 'kode_tahap' => tahapan_apbd()]);
        for ($i = 1; $i <= 12; $i++) {
            $realisasi = $this->db->get_where('realisasi_keuangan', ['kode_rekening' => $kode_rekening, 'bulan' => $i]);
            if (!$realisasi->num_rows() > 0) {
                $data[] = [
                    'kode_rekening'         => $kode_rekening,
                    'id_instansi'           => id_instansi(),
                    'kode_opd'              => $kegiatan->row()->kode_opd,
                    'kode_urusan'           => $kegiatan->row()->kode_urusan,
                    'kode_program'          => $kegiatan->row()->kode_program,
                    'kode_kegiatan'         => $kegiatan->row()->kode_kegiatan,
                    'nama_kegiatan'         => $kegiatan->row()->nama_kegiatan,
                    'bulan'                 => $i,
                    'tahun'                 => $kegiatan->row()->tahun,
                    'belanja_pegawai'       => 0,
                    'belanja_barang_jasa'   => 0,
                    'belanja_modal'         => 0,
                    'created_on'            => timestamp(),
                    'updated_on'            => timestamp(),
                    'created_by'            => id_user(),
                    'updated_by'            => id_user()
                ];
            }
        }
        if (!$realisasi->num_rows() > 0) {
            $this->db->insert_batch('realisasi_keuangan', $data);
        }
    }

    public function update_realisasi_keuangan($kode_rekening_sub_kegiatan, $bulan)
    {
        // $pk     = $this->input->post('pk');
        // $id_realisasi = 6;
        // $target = 'r-bo_bp';
        // $value  = 1234;
        $pk     = $this->input->post('pk');
        $id_realisasi = sbe_crypt($pk, 'D');
        $target = $this->input->post('name');
        $value  = $this->input->post('value');

        $kode = $kode_rekening_sub_kegiatan;
               
        $pecah = explode('.', $kode);
        // $kode_sub_kegiatan = $pecah[0].'.'.$pecah[1].'.'.$pecah[2].'.'.$pecah[3].'.'.$pecah[4].'.'.$pecah[5];
        $kode_sub_kegiatan = $kode_rekening_sub_kegiatan;
        $kode_kegiatan = $pecah[0].'.'.$pecah[1].'.'.$pecah[2].'.'.$pecah[3].'.'.$pecah[4];
        $kode_program = $pecah[0].'.'.$pecah[1].'.'.$pecah[2];

        $kd_sub_kegiatan = $pecah[5];
        $kd_kegiatan = $pecah[3].'.'.$pecah[4];
        $kd_program = $pecah[2];
        $kode_bu = $pecah[0].'.'.$pecah[1];

        switch ($target) {
            case 'r-bo_bp':
                $data_update = [
                    'bo_bp' => str_replace('.', '', $value),
                    'updated_on'=>timestamp(),
                    'updated_by'=>id_user(),
                ];
                $data_insert = [
                    'kode_sub_kegiatan'  =>$kode_sub_kegiatan ,
                    'kode_kegiatan'  =>$kode_kegiatan ,
                    'kode_program'  =>$kode_program ,
                    'kode_bidang_urusan'  =>$kode_bu ,
                    'id_instansi'  => id_instansi() ,
                    'kode_tahap'  => tahapan_apbd(),
                    'bulan'  => $bulan,
                    'bo_bp' => str_replace('.', '', $value),
                    'tahun'  => tahun_anggaran(),
                    'created_on'  => timestamp(),
                    'created_by'  => id_user(),
                    'input_by '  => 'Manual Input'
                ];
                break;
            case 'r-bo_bbj':
                $data_update = [
                    'bo_bbj' => str_replace('.', '', $value),
                    'updated_on'=>timestamp(),
                    'updated_by'=>id_user(),
                ];
                $data_insert = [
                    'kode_sub_kegiatan'  =>$kode_sub_kegiatan ,
                    'kode_kegiatan'  =>$kode_kegiatan ,
                    'kode_program'  =>$kode_program ,
                    'kode_bidang_urusan'  =>$kode_bu ,
                    'id_instansi'  => id_instansi() ,
                    'kode_tahap'  => tahapan_apbd(),
                    'bulan'  => $bulan,
                    'bo_bbj' => str_replace('.', '', $value),
                    'tahun'  => tahun_anggaran(),
                    'created_on'  => timestamp(),
                    'created_by'  => id_user(),
                    'input_by '  => 'Manual Input'
                ];
                break;
            case 'r-bo_bs':
                $data_update = [
                    'bo_bs' => str_replace('.', '', $value),
                    'updated_on'=>timestamp(),
                    'updated_by'=>id_user(),
                ];
                $data_insert = [
                    'kode_sub_kegiatan'  =>$kode_sub_kegiatan ,
                    'kode_kegiatan'  =>$kode_kegiatan ,
                    'kode_program'  =>$kode_program ,
                    'kode_bidang_urusan'  =>$kode_bu ,
                    'id_instansi'  => id_instansi() ,
                    'kode_tahap'  => tahapan_apbd(),
                    'bulan'  => $bulan,
                    'bo_bs' => str_replace('.', '', $value),
                    'tahun'  => tahun_anggaran(),
                    'created_on'  => timestamp(),
                    'created_by'  => id_user(),
                    'input_by '  => 'Manual Input'
                ];
                break;
            case 'r-bo_bh':
                $data_update = [
                    'bo_bh' => str_replace('.', '', $value),
                    'updated_on'=>timestamp(),
                    'updated_by'=>id_user(),
                ];
                $data_insert = [
                    'kode_sub_kegiatan'  =>$kode_sub_kegiatan ,
                    'kode_kegiatan'  =>$kode_kegiatan ,
                    'kode_program'  =>$kode_program ,
                    'kode_bidang_urusan'  =>$kode_bu ,
                    'id_instansi'  => id_instansi() ,
                    'kode_tahap'  => tahapan_apbd(),
                    'bulan'  => $bulan,
                    'bo_bh' => str_replace('.', '', $value),
                    'tahun'  => tahun_anggaran(),
                    'created_on'  => timestamp(),
                    'created_by'  => id_user(),
                    'input_by '  => 'Manual Input'
                ];
                break;
            case 'r-bm_bmt':
                $data_update = [
                    'bm_bmt' => str_replace('.', '', $value),
                    'updated_on'=>timestamp(),
                    'updated_by'=>id_user(),
                ];
                $data_insert = [
                    'kode_sub_kegiatan'  =>$kode_sub_kegiatan ,
                    'kode_kegiatan'  =>$kode_kegiatan ,
                    'kode_program'  =>$kode_program ,
                    'kode_bidang_urusan'  =>$kode_bu ,
                    'id_instansi'  => id_instansi() ,
                    'kode_tahap'  => tahapan_apbd(),
                    'bulan'  => $bulan,
                    'bm_bmt' => str_replace('.', '', $value),
                    'tahun'  => tahun_anggaran(),
                    'created_on'  => timestamp(),
                    'created_by'  => id_user(),
                    'input_by '  => 'Manual Input'
                ];
                break;
            case 'r-bm_bmpm':
                $data_update = [
                    'bm_bmpm' => str_replace('.', '', $value),
                    'updated_on'=>timestamp(),
                    'updated_by'=>id_user(),
                ];
                $data_insert = [
                    'kode_sub_kegiatan'  =>$kode_sub_kegiatan ,
                    'kode_kegiatan'  =>$kode_kegiatan ,
                    'kode_program'  =>$kode_program ,
                    'kode_bidang_urusan'  =>$kode_bu ,
                    'id_instansi'  => id_instansi() ,
                    'kode_tahap'  => tahapan_apbd(),
                    'bulan'  => $bulan,
                    'bm_bmpm' => str_replace('.', '', $value),
                    'tahun'  => tahun_anggaran(),
                    'created_on'  => timestamp(),
                    'created_by'  => id_user(),
                    'input_by '  => 'Manual Input'
                ];
                break;
            case 'r-bm_bmgb':
                $data_update = [
                    'bm_bmgb' => str_replace('.', '', $value),
                    'updated_on'=>timestamp(),
                    'updated_by'=>id_user(),
                ];
                $data_insert = [
                    'kode_sub_kegiatan'  =>$kode_sub_kegiatan ,
                    'kode_kegiatan'  =>$kode_kegiatan ,
                    'kode_program'  =>$kode_program ,
                    'kode_bidang_urusan'  =>$kode_bu ,
                    'id_instansi'  => id_instansi() ,
                    'kode_tahap'  => tahapan_apbd(),
                    'bulan'  => $bulan,
                    'bm_bmgb' => str_replace('.', '', $value),
                    'tahun'  => tahun_anggaran(),
                    'created_on'  => timestamp(),
                    'created_by'  => id_user(),
                    'input_by '  => 'Manual Input'
                ];
                break;
            case 'r-bm_bmjji':
                $data_update = [
                    'bm_bmjji' => str_replace('.', '', $value),
                    'updated_on'=>timestamp(),
                    'updated_by'=>id_user(),
                ];
                $data_insert = [
                    'kode_sub_kegiatan'  =>$kode_sub_kegiatan ,
                    'kode_kegiatan'  =>$kode_kegiatan ,
                    'kode_program'  =>$kode_program ,
                    'kode_bidang_urusan'  =>$kode_bu ,
                    'id_instansi'  => id_instansi() ,
                    'kode_tahap'  => tahapan_apbd(),
                    'bulan'  => $bulan,
                    'bm_bmjji' => str_replace('.', '', $value),
                    'tahun'  => tahun_anggaran(),
                    'created_on'  => timestamp(),
                    'created_by'  => id_user(),
                    'input_by '  => 'Manual Input'
                ];
                break;
            case 'r-bm_bmatl':
                $data_update = [
                    'bm_bmatl' => str_replace('.', '', $value),
                    'updated_on'=>timestamp(),
                    'updated_by'=>id_user(),
                ];
                $data_insert = [
                    'kode_sub_kegiatan'  =>$kode_sub_kegiatan ,
                    'kode_kegiatan'  =>$kode_kegiatan ,
                    'kode_program'  =>$kode_program ,
                    'kode_bidang_urusan'  =>$kode_bu ,
                    'id_instansi'  => id_instansi() ,
                    'kode_tahap'  => tahapan_apbd(),
                    'bulan'  => $bulan,
                    'bm_bmatl' => str_replace('.', '', $value),
                    'tahun'  => tahun_anggaran(),
                    'created_on'  => timestamp(),
                    'created_by'  => id_user(),
                    'input_by '  => 'Manual Input'
                ];
                break;
            case 'r-btt':
                $data_update = [
                    'btt' => str_replace('.', '', $value),
                    'updated_on'=>timestamp(),
                    'updated_by'=>id_user(),
                ];
                $data_insert = [
                    'kode_sub_kegiatan'  =>$kode_sub_kegiatan ,
                    'kode_kegiatan'  =>$kode_kegiatan ,
                    'kode_program'  =>$kode_program ,
                    'kode_bidang_urusan'  =>$kode_bu ,
                    'id_instansi'  => id_instansi() ,
                    'kode_tahap'  => tahapan_apbd(),
                    'bulan'  => $bulan,
                    'btt' => str_replace('.', '', $value),
                    'tahun'  => tahun_anggaran(),
                    'created_on'  => timestamp(),
                    'created_by'  => id_user(),
                    'input_by '  => 'Manual Input'
                ];
                break;
            case 'r-bt_bbh':
                $data_update = [
                    'bt_bbh' => str_replace('.', '', $value),
                    'updated_on'=>timestamp(),
                    'updated_by'=>id_user(),
                ];
                $data_insert = [
                    'kode_sub_kegiatan'  =>$kode_sub_kegiatan ,
                    'kode_kegiatan'  =>$kode_kegiatan ,
                    'kode_program'  =>$kode_program ,
                    'kode_bidang_urusan'  =>$kode_bu ,
                    'id_instansi'  => id_instansi() ,
                    'kode_tahap'  => tahapan_apbd(),
                    'bulan'  => $bulan,
                    'bt_bbh' => str_replace('.', '', $value),
                    'tahun'  => tahun_anggaran(),
                    'created_on'  => timestamp(),
                    'created_by'  => id_user(),
                    'input_by '  => 'Manual Input'
                ];
                break;
            case 'r-bt_bbk':
                $data_update = [
                    'bt_bbk' => str_replace('.', '', $value),
                    'updated_on'=>timestamp(),
                    'updated_by'=>id_user(),
                ];
                $data_insert = [
                    'kode_sub_kegiatan'  =>$kode_sub_kegiatan ,
                    'kode_kegiatan'  =>$kode_kegiatan ,
                    'kode_program'  =>$kode_program ,
                    'kode_bidang_urusan'  =>$kode_bu ,
                    'id_instansi'  => id_instansi() ,
                    'kode_tahap'  => tahapan_apbd(),
                    'bulan'  => $bulan,
                    'bt_bbk' => str_replace('.', '', $value),
                    'tahun'  => tahun_anggaran(),
                    'created_on'  => timestamp(),
                    'created_by'  => id_user(),
                    'input_by '  => 'Manual Input'
                ];
                break;
          
        }
        $cekdata = $this->db->query("SELECT id_realisasi_keuangan from realisasi_keuangan where id_realisasi_keuangan='$id_realisasi'")->num_rows();

        if ($cekdata==0) {
            $this->db->insert('realisasi_keuangan', $data_insert);
        }else{
            $this->db->update('realisasi_keuangan', $data_update, ['id_realisasi_keuangan' => $id_realisasi]);
        }
    }



    public function reject_fisik()
    {
        $breadcrumbs        = $this->breadcrumbs;
        $realisasi_fisik    = $this->realisasi_fisik_model;

        // $breadcrumbs->add('Home', base_url());
        // $breadcrumbs->add('Realisasi', base_url($this->router->fetch_class()));
        // $breadcrumbs->add('Fisik', base_url());
        // $breadcrumbs->render();

        $data['title']       = "Realisasi Fisik Reject";
        $data['icon']        = "metismenu-icon fa fa-list-ul";
        $data['description'] = "menampilkan list realisasi fisik yang ditolak";
        $data['breadcrumbs'] = $breadcrumbs->render();
        $page                = 'realisasi/reject_fisik/index';
        $data['link']        = $this->router->fetch_method();
        $data['menu']        = $this->load->view('layout/menu', $data, true);
        $data['extra_css']   = $this->load->view('realisasi/reject_fisik/css', $data, true);
        $data['extra_js']    = $this->load->view('realisasi/reject_fisik/js', $data, true);
        $data['modal']       = $this->load->view('realisasi/reject_fisik/modal', $data, true);
        $this->template->load('backend_template', $page, $data);
    }


    public function dt_reject_fisik()
    {
        if (!$this->input->is_ajax_request()) {
            show_404();
        } else {
            
                $where = [
                    'id_instansi'   => id_instansi()
                ];
            $column_order   = ['', 'nama_paket', 'nama_kegiatan'];
            $column_search  = ['nama_paket', 'nama_kegiatan'];
            $order          = ['id_realisasi_fisik' => 'ASC'];
            $list           = $this->datatables_model->get_datatables('v_reject_fisik', $column_order, $column_search, $order, $where);
            $data           = [];
            $no             = $_POST['start'];

            foreach ($list as $lists) {
                $row    = [];
                $row[]  = $lists->kode_rekening;
                $row[]  = $lists->full_name;
                $row[]  = $lists->nama_sub_kegiatan;
                $row[]  = $lists->nama_paket;
                $row[]  = $lists->dokumen_key;
                $row[]  = '<a href="'.base_url('realisasi/evidence/'.sbe_crypt($lists->id_realisasi_fisik)).'" class="btn btn-info btn-xs"><i class="fa fa-folder-open"></i></a>';
               

                $data[] = $row;
            }

            $output = [
                "draw"              => $_POST['draw'],
                "recordsTotal"      => $this->datatables_model->count_all('v_reject_fisik', $where),
                "recordsFiltered"   => $this->datatables_model->count_filtered('v_reject_fisik', $column_order, $column_search, $order, $where),
                "data"              => $data,
            ];

            echo json_encode($output);
        }
    }


   
}
