<?php

/**
 * Author     : Alfikri, M.Kom
 * Created By : Alfikri, M.Kom
 * E-Mail     : alfikri.name@gmail.com
 * No HP      : 081277337405
 * Class      : Validasi.php
 */
defined('BASEPATH') or exit('No direct script access allowed');

class Validasi extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model([
            'validasi/validasi_fisik_model' => 'validasi_fisik_model',
            'datatables_model'              => 'datatables_model'
        ]);
    }

    public function fisik()
    {
        $breadcrumbs    = $this->breadcrumbs;
        $validasi_fisik = $this->validasi_fisik_model;

        $breadcrumbs->add('Home', base_url());
        $breadcrumbs->add('Validasi', base_url($this->router->fetch_class()));
        $breadcrumbs->add('Fisik', base_url());
        $breadcrumbs->render();

        $data['title']                 = "Validasi Fisik";
        $data['icon']                  = "metismenu-icon fa fa-check-square";
        $data['description']           = "Validasi Fisik";
        $data['breadcrumbs']           = $breadcrumbs->render();
        $page                          = 'validasi/fisik/index';
        $data['link']                  = $this->router->fetch_method();
        $data['total_paket']           = $validasi_fisik->total_paket_pekerjaan();
        $data['total_paket_rutin']     = $validasi_fisik->total_paket_rutin();
        $data['total_paket_swakelola'] = $validasi_fisik->total_paket_swakelola();
        $data['total_paket_penyedia']  = $validasi_fisik->total_paket_penyedia();
        $data['menu']                  = $this->load->view('layout/menu', $data, true);
        $data['extra_css']             = $this->load->view('validasi/fisik/css', $data, true);
        $data['extra_js']              = $this->load->view('validasi/fisik/js', $data, true);
        $data['modal']                 = $this->load->view('validasi/fisik/modal', $data, true);
        $this->template->load('backend_template', $page, $data);
    }

    public function get_instansi()
    {
        if (!$this->input->is_ajax_request()) {
            show_404();
        } else {
            $output = [
                'status'  => false,
                'data'    => [],
                'message' => ''
            ];

            if ($this->sbe_group_name() == 'OPERATOR') {
                $instansi = $this->validasi_fisik_model->get_instansi_by_id();
            } elseif ($this->sbe_group_name() == 'HELPDESK') {
                $instansi = $this->validasi_fisik_model->get_instansi();
            }
            if ($instansi->num_rows() > 0) {
                foreach ($instansi->result() as $key => $value) {
                    $output['data'][$key]['id_instansi']        = sbe_crypt($value->id_instansi, 'E');
                    $output['data'][$key]['nama_instansi']      = $value->nama_instansi;
                    $output['data'][$key]['jml_paket']          = $value->jml_paket;
                    $output['data'][$key]['belum_validasi']     = $value->belum_validasi;
                    $output['data'][$key]['belum_validasi_swa'] = $value->belum_validasi_swakelola;
                    $output['data'][$key]['belum_validasi_pen'] = $value->belum_validasi_penyedia;
                }

                $output['status'] = true;
            }

            echo json_encode($output);
        }
    }

    public function dt_paket_swakelola()
    {
        if (!$this->input->is_ajax_request()) {
            show_404();
        } else {
            $id_instansi    = sbe_crypt($this->input->post('id_instansi'), 'D');
            $where          = array('id_instansi' => $id_instansi);
            $column_order   = array('', 'nama_paket');
            $column_search  = array('nama_paket');
            $order = array('nama_paket' => 'ASC');
            $list = $this->datatables_model->get_datatables('v_paket_swakelola', $column_order, $column_search, $order, $where);
            $data = array();
            $no = $_POST['start'];
            foreach ($list as $lists) {
                $no++;
                $id_paket =  $lists->id_paket_pekerjaan;
                $nilai_paket = $this->validasi_fisik_model->nilai_paket($id_paket)->totalnilai > 0 ? $this->validasi_fisik_model->nilai_paket($id_paket)->totalnilai : 0;

                $row   = array();
                $row[] = $no;
                $row[] = $lists->nama_paket;
                $row[] = $lists->kode_rekening_sub_kegiatan;
                $row[] = $lists->nama_sub_kegiatan;
                $row[] = $lists->nama_program;
                $row[] = $lists->full_name;
                $row[] = $this->vol($lists->id_paket_pekerjaan);
                $row[] = $lists->dok;
                $row[] = $nilai_paket ;
                
                $row[] = '<button class="btn ' . $this->validasi_fisik_model->get_status_validasi_paket($lists->id_instansi, $lists->id_paket_pekerjaan, $lists->dok) . ' btn-sm" id="detail-realisasi-fisik" status="collapse" id-instansi="' . $lists->id_instansi . '" id-paket-pekerjaan="' . $lists->id_paket_pekerjaan . '" nama-kpa="' . $this->validasi_fisik_model->get_kpa($lists->id_sub_instansi)['full_name'] . '" nama-pptk="' . $lists->full_name . '" nama-program="' . $this->validasi_fisik_model->get_program_kegiatan($lists->kode_rekening_sub_kegiatan)['nama_program'] . '" nama-kegiatan="' . $this->validasi_fisik_model->get_program_kegiatan($lists->kode_rekening_sub_kegiatan)['nama_kegiatan'] . '" vol="' . $this->vol($lists->id_paket_pekerjaan) . '"><i class="fa fa-plus"></i></button>';

                $data[] = $row;
            }

            $output = array(
                "draw" => $_POST['draw'],
                "recordsTotal" => $this->datatables_model->count_all('v_paket_swakelola', $where),
                "recordsFiltered" => $this->datatables_model->count_filtered('v_paket_swakelola', $column_order, $column_search, $order, $where),
                "data" => $data,
            );

            echo json_encode($output);
        }
    }

    public function dt_paket_penyedia()
    {
        if (!$this->input->is_ajax_request()) {
            show_404();
        } else {
            $id_instansi    = sbe_crypt($this->input->post('id_instansi'), 'D');
            $where          = array('id_instansi' => $id_instansi);
            $column_order   = array('', 'nama_paket');
            $column_search  = array('nama_paket');
            $order = array('nama_paket' => 'ASC');
            $list = $this->datatables_model->get_datatables('v_paket_penyedia', $column_order, $column_search, $order, $where);
            $data = array();
            $no = $_POST['start'];
            foreach ($list as $lists) {
                $no++;
                $row   = array();
                $row[] = $no;
                $row[] = $lists->nama_paket;
                $row[] = $lists->kode_rekening_sub_kegiatan;
                $row[] = $lists->nama_sub_kegiatan;
                $row[] = $lists->nama_program;
                $row[] = $lists->full_name;
                $row[] = $this->vol($lists->id_paket_pekerjaan);
                $row[] = $lists->dok;

                $id_paket =  $lists->id_paket_pekerjaan;
                $nilai_paket = $this->validasi_fisik_model->nilai_paket($id_paket)->totalnilai > 0 ? $this->validasi_fisik_model->nilai_paket($id_paket)->totalnilai : 0;


                $row[] = $nilai_paket ;
                $row[] = '<button class="btn ' . $this->validasi_fisik_model->get_status_validasi_paket($lists->id_instansi, $lists->id_paket_pekerjaan, $lists->dok) . ' btn-sm" id="detail-realisasi-fisik" status="collapse" id-instansi="' . $lists->id_instansi . '" id-paket-pekerjaan="' . $lists->id_paket_pekerjaan . '" nama-kpa="' . $this->validasi_fisik_model->get_kpa($lists->id_sub_instansi)['full_name'] . '" nama-pptk="' . $lists->full_name . '" nama-program="' . $this->validasi_fisik_model->get_program_kegiatan($lists->kode_rekening_sub_kegiatan)['nama_program'] . '" nama-kegiatan="' . $this->validasi_fisik_model->get_program_kegiatan($lists->kode_rekening_sub_kegiatan)['nama_kegiatan'] . '" vol="' . $this->vol($lists->id_paket_pekerjaan) . '"><i class="fa fa-plus"></i></button>';

                $data[] = $row;
            }

            $output = array(
                "draw" => $_POST['draw'],
                "recordsTotal" => $this->datatables_model->count_all('v_paket_penyedia', $where),
                "recordsFiltered" => $this->datatables_model->count_filtered('v_paket_penyedia', $column_order, $column_search, $order, $where),
                "data" => $data,
            );

            echo json_encode($output);
        }
    }

    private function vol($id_paket_pekerjaan)
    {
        return $this->db->get_where('vol_pelaksanaan_pekerjaan', [
            'id_paket_pekerjaan' => $id_paket_pekerjaan
        ])->num_rows();
    }

    public function get_dok_realisasi()
    {
        if (!$this->input->is_ajax_request()) {
            show_404();
        } else {
            $output = [
                'status'    => false,
                'data'      => [],
                'message'   => ''
            ];

            $id_instansi        = $this->input->post('id_instansi');
            $id_paket_pekerjaan = $this->input->post('id_paket_pekerjaan');
            $dok_realisasi      = $this->validasi_fisik_model->get_dok_realisasi($id_paket_pekerjaan);
            $primary_folder     = 'sbe_files_data/';
            $directory          = [
                $this->sbe_tahun_anggaran(),
                $id_instansi,
                'REALISASI-FISIK',
                $id_paket_pekerjaan,
            ];
            $list_directory     = $this->sbe_directory($primary_folder, $directory);
            if ($dok_realisasi->num_rows() > 0) {
                foreach ($dok_realisasi->result() as $key => $value) {
                    $output['data'][$key]['id_realisasi_fisik'] = $value->id_realisasi_fisik;
                    $output['data'][$key]['jenis_paket']        = $value->jenis_paket;
                    $output['data'][$key]['id_metode']          = $value->id_metode;
                    $output['data'][$key]['dokumen']            = $this->split($value->dokumen);
                    $output['data'][$key]['file_dokumen']       = $list_directory . $value->file_dokumen;
                    $output['data'][$key]['nilai']              = $value->nilai;
                    $output['data'][$key]['status']             = $this->status_validasi($value->status);
                }

                $output['status'] = true;
            }

            echo json_encode($output);
        }
    }

    public function split($dokumen)
    {
        $split = explode('_', $dokumen);
        $split = explode('-', $dokumen);

        return $split[0];
    }

    public function status_validasi($status)
    {
        switch ($status) {
            case 'Belum Validasi':
                $stts = 'Not Valid';
                break;
            case 'Sudah Validasi':
                $stts = 'Approved';
                break;
            case 'Ditolak':
                $stts = 'Rejected';
                break;
        }

        return $stts;
    }

    public function update_nilai()
    {
        if (!$this->input->is_ajax_request()) {
            show_404();
        } else {
            $output = [
                'status'    => false,
                'data'      => '',
                'message'   => ''
            ];

            $id_realisasi_fisik = $this->input->post('id_realisasi_fisik');
            $update = $this->validasi_fisik_model->update_nilai();
            if ($update) {
                $output['status']   = true;
                $output['data']     = $this->validasi_fisik_model->get_id_instansi($id_realisasi_fisik);
            }

            echo json_encode($output);
        }
    }
}
