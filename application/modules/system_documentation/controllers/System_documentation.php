<?php

/**
 * Author     : Alfikri, M.Kom
 * Created By : Alfikri, M.Kom
 * E-Mail     : alfikri.name@gmail.com
 * No HP      : 081277337405
 * Class      : Kegiatan_apbd.php
 */
defined('BASEPATH') or exit('No direct script access allowed');

class System_documentation extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model([
            'system_documentation/system_documentation_model'   => 'system_documentation_model',
            'datatables_model'                    => 'datatables_model'
        ]);
    }

    public function index()
    {
        $breadcrumbs    = $this->breadcrumbs;
      

        $breadcrumbs->add('Home', base_url());
        $breadcrumbs->add('Dokumentasi System', base_url($this->router->fetch_class()));
        $breadcrumbs->render();

        $data['title']                        = "System Documentation";
        $data['icon']                       = "metismenu-icon fa fa-th";
        $data['description']                = "Menampilkan Dokumentasi Cra kerja dan Development Aplikasi";
        $data['breadcrumbs']                = $breadcrumbs->render();
        $data['kode_rekening_program']        = $this->db->get_where('v_program_apbd', ['id_instansi' => id_instansi(), 'kode_tahap' => tahapan_apbd()]);
        $page                                 = 'system_documentation/system_documentation/index';
        $data['link']                       = $this->router->fetch_method();
        $data['menu']                       = $this->load->view('layout/menu', $data, true);
        $data['extra_css']                    = $this->load->view('system_documentation/system_documentation/css', $data, true);

            $data['js_menu']           = "dt_docs";
        $data['extra_js']                    = $this->load->view('system_documentation/system_documentation/js', $data, true);
        $data['modal']                      = $this->load->view('system_documentation/system_documentation/modal', $data, true);
        $this->template->load('backend_template', $page, $data);
    }

    public function dt_docs()
    {
        if (!$this->input->is_ajax_request()) {
            show_404();
        } else {
           
             $where      = ['is_active' => '1'];
                
            $column_order   = ['nama_menu'];
            $column_search  = ['nama_menu', 'kategori_menu', 'bagian_menu', 'link'];
            $order          = ['id_docs' => 'ASC'];
            $list           = $this->datatables_model->get_datatables('v_docs_system', $column_order, $column_search, $order, $where);
            $data           = [];
            $no             = $_POST['start'];

            foreach ($list as $lists) {
                $row    = [];
                $row[]  = $lists->kategori_menu;
                $row[]  = $lists->nama_menu;
                $row[]  = $lists->bagian_menu;
                $row[]  = $lists->desc_dokumentasi;
                 $row[]  = '<a href="'.base_url('system_documentation/detail_docs/'.sbe_crypt($lists->id_docs)).'" class="btn btn-info btn-xs"><i class="fa fa-folder-open"></i></a>';
                // $row[]  = '<button class="btn btn-info btn-sm" id="sumber-dana" kode-rekening-kegiatan="' . $lists->kode_rekening_kegiatan . '" kode-urusan="' . $lists->kode_urusan . '" pagu="' . $lists->pagu . '"><i class="fas fa-money-bill"></i></button>';

                $data[] = $row;
            }

            $output = [
                "draw"              => $_POST['draw'],
                "recordsTotal"      => $this->datatables_model->count_all('v_docs_system', $where),
                "recordsFiltered"   => $this->datatables_model->count_filtered('v_docs_system', $column_order, $column_search, $order, $where),
                "data"              => $data,
            ];

            echo json_encode($output);
        }
    }


    public function detail_docs($id_docs)
    {

            $breadcrumbs            = $this->breadcrumbs;
            $breadcrumbs->add('Home', base_url());
            $breadcrumbs->add('Dokumentasi  System', base_url($this->router->fetch_class()));
            $breadcrumbs->add('Update Dokumen Evidence', base_url());
            $breadcrumbs->render();

            $data['title']          = "Detail Dokumentasi";
            $data['icon']           = "metismenu-icon fa fa-check-circle";
            $data['description']    = "Update Dokumen Fisik yang ditolak";
            $data['breadcrumbs']    = $breadcrumbs->render();
          

              $data['docs']        = $this->system_documentation_model->detail_docs($id_docs)->row();
              $linkfile = base_url().'sbe_files_support/dokumentasi_simbangda/'.$this->sbe_tahun_anggaran().'/'.$data['docs']->id_docs.'/'.$data['docs']->gambar;
              $data['image_file'] = $data['docs']->gambar=="" ? base_url().'sbe_files_support/dokumentasi_simbangda/default.jpg' : $linkfile;
            $page                   = 'system_documentation/system_documentation/detail_docs';
            $data['link']           = $this->router->fetch_method();
            $data['menu']           = $this->load->view('layout/menu', $data, true);

            $data['js_menu']           = "detail_docs";
            $data['extra_css']      = $this->load->view('system_documentation/system_documentation/css', $data, true);
            $data['extra_js']       = $this->load->view('system_documentation/system_documentation/js', $data, true);
            $data['modal']          = $this->load->view('system_documentation/system_documentation/modal', $data, true);
            $this->template->load('backend_template', $page, $data);
    }

     public function dt_detail_docs()
    {
        if (!$this->input->is_ajax_request()) {
            show_404();
        } else {
            $id_docs = '1';
             $where      = ['id_docs' => $id_docs];
                
            $column_order   = ['kode'];
            $column_search  = ['kode', 'keterangan'];
            $order          = ['id_docs_detail' => 'ASC'];
            $list           = $this->datatables_model->get_datatables('docs_detail', $column_order, $column_search, $order, $where);
            $data           = [];
            $no             = $_POST['start'];

            foreach ($list as $lists) {
                $row    = [];
                $row[]  = $lists->kode;
                $row[]  = $lists->keterangan;
                $row[]  = $lists->file_pendukung;
                 $row[]  = '<a href="'.base_url('system_documentation/detail_docs/'.sbe_crypt($lists->id_docs_detail)).'" class="btn btn-info btn-xs"><i class="fa fa-pen"></i></a> <a href="'.base_url('system_documentation/detail_docs/'.sbe_crypt($lists->id_docs_detail)).'" class="btn btn-danger btn-xs"><i class="fa fa-trash"></i></a>';
                // $row[]  = '<button class="btn btn-info btn-sm" id="sumber-dana" kode-rekening-kegiatan="' . $lists->kode_rekening_kegiatan . '" kode-urusan="' . $lists->kode_urusan . '" pagu="' . $lists->pagu . '"><i class="fas fa-money-bill"></i></button>';

                $data[] = $row;
            }

            $output = [
                "draw"              => $_POST['draw'],
                "recordsTotal"      => $this->datatables_model->count_all('docs_detail', $where),
                "recordsFiltered"   => $this->datatables_model->count_filtered('docs_detail', $column_order, $column_search, $order, $where),
                "data"              => $data,
            ];

            echo json_encode($output);
        }
    }


/*
    public function get_target()
    {
        if (!$this->input->is_ajax_request()) {
            show_404();
        } else {
            $output = [
                'status'    => false,
                'data'      => []
            ];
            $kode_rekening_kegiatan = $this->input->post('kode_rekening_kegiatan');
            $kode_urusan            = $this->input->post('kode_urusan');
            $target                 = $this->db->get_where('target_apbd', ['kode_rekening' => $kode_rekening_kegiatan, 'kode_urusan' => $kode_urusan, 'kode_tahap' => tahapan_apbd()]);
            if ($target->num_rows() > 0) {
                foreach ($target->result() as $key => $value) {
                    $output['data'][$key]['id']         = sbe_crypt($value->id_target_apbd, 'E');
                    $output['data'][$key]['bulan']      = $value->bulan;
                    $output['data'][$key]['t_fisik']    = $value->target_fisik;
                    $output['data'][$key]['t_keuangan'] = $value->target_keuangan;
                }

                $output['status']  = true;
            } else {
                $output['status']  = false;
            }

            echo json_encode($output);
        }
    }

    public function update_target_fisik($kode_rekening_kegiatan)
    {
        $id_target_apbd = sbe_crypt($this->input->post('pk'), 'D');
        $target_fisik   = $this->input->post('value');

        $target         = $this->db->get_where('target_apbd', ['id_target_apbd' => $id_target_apbd])->row_array();
        $target_lalu    = $this->db->get_where('target_apbd', ['kode_rekening' => $kode_rekening_kegiatan, 'bulan' => $target['bulan'] - 1, 'kode_tahap' => tahapan_apbd()])->row_array();

        if ($target['bulan'] == 1) {
            $nilai = $target_fisik;
        } elseif ($target['bulan'] > 1 && $target['bulan'] <= 12) {
            $nilai = $target_fisik + $target_lalu['target_fisik'];
        }

        if ($nilai >= 100) {
            for ($i = $target['bulan']; $i <= 12; $i++) {
                $this->db->update('target_apbd', ['target_fisik' => 100], ['kode_rekening' => $kode_rekening_kegiatan, 'bulan' => $i]);
            }
        } else {
            $this->db->update('target_apbd', ['target_fisik' => $nilai], ['id_target_apbd' => $id_target_apbd]);
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

            $kode_rekening_kegiatan = $this->input->post('kode_rekening_kegiatan');
            $kode_urusan            = $this->input->post('kode_urusan');
            $sumber_dana = $this->db->get_where('sumber_dana', ['id_instansi' => id_instansi(), 'kode_rekening_kegiatan' => $kode_rekening_kegiatan, 'kode_urusan' => $kode_urusan]);

            if ($sumber_dana->num_rows() > 0) {
                foreach ($sumber_dana->result() as $key => $value) {
                    $output['data'] = $value;
                }

                $output['status'] = true;
            }

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
            $kode_rekening_kegiatan = $this->input->post('kode_rekening_kegiatan');
            $kode_urusan            = $this->input->post('kode_urusan');
            $dau                    = $this->input->post('dau');
            $dak                    = $this->input->post('dak');
            $dbh                    = $this->input->post('dbh');
            $lainnya                = $this->input->post('lainnya');

            $data = [
                'id_instansi'               => id_instansi(),
                'kode_rekening_kegiatan'    => $kode_rekening_kegiatan,
                'kode_urusan'               => $kode_urusan,
                'dau'                       => $dau,
                'dak'                       => $dak,
                'dbh'                       => $dbh,
                'lainnya'                   => $lainnya
            ];
            if ($status == 'insert') {
                $this->db->insert('sumber_dana', $data);
                $output['status'] = true;
            } else {
                $this->db->update('sumber_dana', $data, ['id_instansi' => id_instansi(), 'kode_rekening_kegiatan' => $kode_rekening_kegiatan]);
                $output['status'] = true;
            }


            echo json_encode($output);
        }
    }
    */
}
