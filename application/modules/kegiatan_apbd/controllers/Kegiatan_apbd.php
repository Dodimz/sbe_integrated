<?php

/**
 * Author     : Alfikri, M.Kom
 * Created By : Alfikri, M.Kom
 * E-Mail     : alfikri.name@gmail.com
 * No HP      : 081277337405
 * Class      : Kegiatan_apbd.php
 */
defined('BASEPATH') or exit('No direct script access allowed');

class Kegiatan_apbd extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model([
            'kegiatan_apbd/kegiatan_apbd_model'   => 'kegiatan_apbd_model',
            'datatables_model'                    => 'datatables_model'
        ]);
    }

    public function index()
    {
        $breadcrumbs    = $this->breadcrumbs;
        $kegiatan_apbd   = $this->kegiatan_apbd_model;

        $breadcrumbs->add('Home', base_url());
        $breadcrumbs->add('Kegiatan APBD', base_url($this->router->fetch_class()));
        $breadcrumbs->render();

        $data['title']                        = "Kegiatan APBD";
        $data['icon']                       = "metismenu-icon fa fa-th";
        $data['description']                = "Menampilkan Kegiatan APBD";
        $data['breadcrumbs']                = $breadcrumbs->render();
        $data['kode_rekening_program']        = $this->db->get_where('v_program_apbd', ['id_instansi' => id_instansi(), 'kode_tahap' => tahapan_apbd()]);
        $page                                 = 'kegiatan_apbd/kegiatan_apbd/index';
        $data['link']                       = $this->router->fetch_method();
        $data['menu']                       = $this->load->view('layout/menu', $data, true);
        $data['extra_css']                    = $this->load->view('kegiatan_apbd/kegiatan_apbd/css', $data, true);
        $data['extra_js']                    = $this->load->view('kegiatan_apbd/kegiatan_apbd/js', $data, true);
        $data['modal']                      = $this->load->view('kegiatan_apbd/kegiatan_apbd/modal', $data, true);
        $this->template->load('backend_template', $page, $data);
    }

    public function dt_kegiatan_apbd()
    {
        if (!$this->input->is_ajax_request()) {
            show_404();
        } else {
            $kode_rekening_program = $this->input->post('kode_rekening_program');

            if (!$kode_rekening_program) {
                $where      = ['id_instansi' => id_instansi(), 'kode_tahap' => tahapan_apbd()];
            } else {
                $where      = ['id_instansi' => id_instansi(), 'kode_tahap' => tahapan_apbd(), 'kode_rekening_program' => $kode_rekening_program];
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
                $row[]  = number_format($lists->belanja_pegawai, 0, '', '.');
                $row[]  = number_format($lists->belanja_barang_jasa, 0, '', '.');
                $row[]  = number_format($lists->belanja_modal, 0, '', '.');
                $row[]  = number_format($lists->pagu, 0, '', '.');
                $row[]  = '<button class="btn btn-success btn-sm" id="target" kode-rekening-kegiatan="' . $lists->kode_rekening_kegiatan . '" kode-urusan="' . $lists->kode_urusan . '" pagu="' . $lists->pagu . '"><i class="fa fa-crosshairs"></i></button>';
                $row[]  = '<button class="btn btn-info btn-sm" id="sumber-dana" kode-rekening-kegiatan="' . $lists->kode_rekening_kegiatan . '" kode-urusan="' . $lists->kode_urusan . '" pagu="' . $lists->pagu . '"><i class="fas fa-money-bill"></i></button>';

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
}
