<?php

/**
 * Author     : Alfikri, M.Kom
 * Created By : Alfikri, M.Kom
 * E-Mail     : alfikri.name@gmail.com
 * No HP      : 081277337405
 * Class      : Validasi.php
 */
defined('BASEPATH') or exit('No direct script access allowed');

class Pantau extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model([
            'validasi/validasi_fisik_model' => 'validasi_fisik_model',
            'datatables_model'              => 'datatables_model'
        ]);
    }

    public function index()
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
        $page                          = 'pantau/fisik/index';
        $id_group = $this->session->userdata('id_group');
            $id_user = id_user();
        if ($id_group==5) {
            $id_instansi = id_instansi();
        }
        elseif ($id_group==4) {
            $q = $this->db->query("SELECT hi.id_instansi from helpdesk_instansi hi 
                left join master_instansi mi on hi.id_instansi = mi.id_instansi
                where hi.id_user = '$id_user' order by id_helpdesk_instansi asc limit 1")->row_array();
            $id_instansi = $q['id_instansi'];
        }else{
            $q = $this->db->query("SELECT id_instansi from master_instansi where is_active = '1' and kategori='OPD' order by nama_instansi asc limit 1")->row_array();
            $id_instansi = $q['id_instansi'];

        }
        $data['link']                  = $this->router->fetch_method();
        $data['id_instansi']                  = sbe_crypt($id_instansi, 'E');
        $data['total_paket']           = $validasi_fisik->total_paket_pekerjaan();
        $data['total_paket_rutin']     = $validasi_fisik->total_paket_rutin();
        $data['total_paket_swakelola'] = $validasi_fisik->total_paket_swakelola();
        $data['total_paket_penyedia']  = $validasi_fisik->total_paket_penyedia();
        $data['menu']                  = $this->load->view('layout/menu', $data, true);
        $data['extra_css']             = $this->load->view('pantau/fisik/css', $data, true);
        $data['extra_js']              = $this->load->view('pantau/fisik/js', $data, true);
        $data['modal']                 = $this->load->view('pantau/fisik/modal', $data, true);
        $this->template->load('backend_template', $page, $data);
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
        $id_group = $this->session->userdata('id_group');
            $id_user = id_user();
        if ($id_group==5) {
            $id_instansi = id_instansi();
        }
        elseif ($id_group==4) {
            $q = $this->db->query("SELECT hi.id_instansi from helpdesk_instansi hi 
                left join master_instansi mi on hi.id_instansi = mi.id_instansi
                where hi.id_user = '$id_user' order by id_helpdesk_instansi asc limit 1")->row_array();
            $id_instansi = $q['id_instansi'];
        }else{
            $q = $this->db->query("SELECT id_instansi from master_instansi where is_active = '1' and kategori='OPD' order by nama_instansi asc limit 1")->row_array();
            $id_instansi = $q['id_instansi'];

        }
        $data['link']                  = $this->router->fetch_method();
        $data['id_instansi']                  = sbe_crypt($id_instansi, 'E');
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


   
    public function dt_list_skpd()
    {
        if (!$this->input->is_ajax_request()) {
            show_404();
        } else {
            $id_group = $this->session->userdata('id_group');
            $id_user = id_user();
            if ($id_group==2) {
                $where          = ['kategori'=>'OPD', 'is_active'=>1];
                $column_order   = ['', 'nama_instansi'];
                $column_search  = ['nama_instansi', 'is_active'=>1];
                $order          = ['nama_instansi' => 'ASC'];
                $tabel = 'v_instansi';
            }  else{
                $where          = ['id_user'=>$id_user];
                $column_order   = ['', 'nama_instansi'];
                $column_search  = ['nama_instansi'];
                $order          = ['nama_instansi' => 'ASC'];
                $tabel = 'v_helpdesk_instansi';
            }          
            $list           = $this->datatables_model->get_datatables($tabel, $column_order, $column_search, $order, $where);
            $data           = [];
            $no             = $_POST['start'];
            $status = ['Tidak Aktif','Aktif'];
            foreach ($list as $lists) {
                $no++;
               
                $row    = [];
                $row[]     = $no;
                $row[]  = $lists->nama_instansi;
                $row[]  = $lists->evidence_belum_validasi;
                $row[]  = $lists->evidence_ditolak ;
      
                $tombol_hapus = '<button class="btn btn-outline-info btn-xs"  title="Pilih SKPD'.$lists->nama_instansi.'"  onclick="tetapkan_skpd('."'".sbe_crypt($lists->id_instansi, 'E')."'".')"><i class="fas fa-check"></i></button>';
                $row[]  = $tombol_hapus;


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
            } elseif ($this->sbe_group_name() == 'ADMIN') {
                $instansi = $this->validasi_fisik_model->get_all_instansi();
            }

            $output['banyak_skpd'] = $instansi->num_rows();
            if ($instansi->num_rows() > 0) {
                foreach ($instansi->result() as $key => $value) {
                    $output['data'][$key]['id_instansi']        = sbe_crypt($value->id_instansi, 'E');
                    $output['data'][$key]['nama_instansi']      = $value->nama_instansi;
                    $output['data'][$key]['is_active']      = $value->is_active;
                    // $output['data'][$key]['jml_paket']          = 'Total evidence belum di periksa';
                    // $output['data'][$key]['approve']          = 'Total evidence di approve';
                    // $output['data'][$key]['reject']          = 'Total evidence di reject';
                    // $output['data'][$key]['total_evidence_diupload']          = 'Total evidence di upload';
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
            $column_search  = array('nama_paket','nilai','belum_validasi');
            $order = array('nama_paket' => 'ASC');
            $list = $this->datatables_model->get_datatables('v_paket_swakelola', $column_order, $column_search, $order, $where);
            $data = array();
            $no = $_POST['start'];
            foreach ($list as $lists) {
                $no++;
                $id_paket =  $lists->id_paket_pekerjaan;
                $nilai_paket = $this->validasi_fisik_model->nilai_paket($id_paket)->totalnilai > 0 ? $this->validasi_fisik_model->nilai_paket($id_paket)->totalnilai : 0;
                $diperiksa = $this->db->query("SELECT id_realisasi_fisik from realisasi_fisik where id_paket_pekerjaan='$id_paket' and status in ('Sudah Validasi', 'Ditolak')")->num_rows();
                $banyak_evidence = $this->db->query("SELECT id_realisasi_fisik from realisasi_fisik where id_paket_pekerjaan='$id_paket'")->num_rows();

                $row   = array();
                $row[] = $no;

                $warna_tombol = $banyak_evidence == 0 ? 'btn-outline-info' :$this->validasi_fisik_model->get_status_validasi_paket($lists->id_instansi, $lists->id_paket_pekerjaan, $lists->dok);


                $tombol_action = '<button class="btn ' . $warna_tombol . ' btn-sm view_evidence_'.$id_paket.'" id="detail-realisasi-fisik" status="collapse" id-instansi="' . $lists->id_instansi . '" id-paket-pekerjaan="' . $lists->id_paket_pekerjaan . '" nama-kpa="' . $this->validasi_fisik_model->get_kpa($lists->id_sub_instansi)['full_name'] . '" nama-pptk="' . $lists->full_name . '" nama-program="' . $this->validasi_fisik_model->get_program_kegiatan($lists->kode_rekening_sub_kegiatan)['nama_program'] . '" nama-kegiatan="' . $this->validasi_fisik_model->get_program_kegiatan($lists->kode_rekening_sub_kegiatan)['nama_kegiatan'] . '" vol="' . $this->vol($lists->id_paket_pekerjaan) . '" banyak_evidence="'.$banyak_evidence.'" nama_paket="'.$lists->nama_paket.'"><i class="fa fa-plus"></i></button>';

                $tombol_open = '<button class="btn ' . $warna_tombol . ' btn-sm" onclick="identitas_paket('.$id_paket.')"><i class="fa fa-folder-open"></i></button>';

                $kode_sub_kegiatan = $lists->kode_rekening_sub_kegiatan;
                $pecah = explode('.', $kode_sub_kegiatan);
                $krsk = $pecah[0].'.'.$pecah[1].'.'.$pecah[2].'.'.$pecah[3].'.'.$pecah[4].'.'.$pecah[5];
                
                $q_ski = $this->db->query("SELECT * from sub_kegiatan_instansi where kode_sub_kegiatan='$kode_sub_kegiatan' and id_instansi='$id_instansi'")->row_array();

                $uptd  = $q_ski['kategori']=='Sub Kegiatan SKPD' ? '' : '<br>'.$q_ski['jenis_sub_kegiatan'].' - '.$q_ski['keterangan'];
                
               
                $row[] = $lists->full_name;
                $row[] = $lists->nama_sub_kegiatan.$uptd;
                $row[] = $lists->nama_paket;
                $row[] = $lists->belum_validasi;
                $row[] = $lists->nilai==''? 0 : round($lists->nilai,2);
                $row[] = $tombol_open;

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

    public function dt_paket_belum_validasi()
    {
        if (!$this->input->is_ajax_request()) {
            show_404();
        } else {
            $id_instansi    = sbe_crypt($this->input->post('id_instansi'), 'D');
            $where          = array('id_instansi' => $id_instansi, 'belum_validasi > '=>0);
            $column_order   = array('', 'nama_paket');
            $column_search  = array('nama_paket','nilai','belum_validasi');
            $order = array('nama_paket' => 'ASC');
            $list = $this->datatables_model->get_datatables('v_paket', $column_order, $column_search, $order, $where);
            $data = array();
            $no = $_POST['start'];
            foreach ($list as $lists) {
                $no++;
                $id_paket =  $lists->id_paket_pekerjaan;
                $nilai_paket = $this->validasi_fisik_model->nilai_paket($id_paket)->totalnilai > 0 ? $this->validasi_fisik_model->nilai_paket($id_paket)->totalnilai : 0;
                $diperiksa = $this->db->query("SELECT id_realisasi_fisik from realisasi_fisik where id_paket_pekerjaan='$id_paket' and status in ('Sudah Validasi', 'Ditolak')")->num_rows();
                $banyak_evidence = $this->db->query("SELECT id_realisasi_fisik from realisasi_fisik where id_paket_pekerjaan='$id_paket'")->num_rows();

                $row   = array();
                $row[] = $no;

              


            

                $tombol_open = '<button class="btn btn-outline-warning btn-sm" onclick="identitas_paket('.$id_paket.')"><i class="fa fa-folder-open"></i></button>';

                $kode_sub_kegiatan = $lists->kode_rekening_sub_kegiatan;
                $pecah = explode('.', $kode_sub_kegiatan);
                $krsk = $pecah[0].'.'.$pecah[1].'.'.$pecah[2].'.'.$pecah[3].'.'.$pecah[4].'.'.$pecah[5];
                
                $q_ski = $this->db->query("SELECT * from sub_kegiatan_instansi where kode_sub_kegiatan='$kode_sub_kegiatan' and id_instansi='$id_instansi'")->row_array();

                $uptd  = $q_ski['kategori']=='Sub Kegiatan SKPD' ? '' : '<br>'.$q_ski['jenis_sub_kegiatan'].' - '.$q_ski['keterangan'];
                
               
                $row[] = $lists->nama_pptk;
                $row[] = $lists->nama_sub_kegiatan.$uptd;
                $row[] = $lists->nama_paket;
                $row[] = $lists->jenis_paket;
                $row[] = $lists->belum_validasi;
                $row[] = $lists->nilai==''? 0 : round($lists->nilai,2);
                $row[] = $tombol_open;

                $data[] = $row;
            }

            $output = array(
                "draw" => $_POST['draw'],
                "recordsTotal" => $this->datatables_model->count_all('v_paket', $where),
                "recordsFiltered" => $this->datatables_model->count_filtered('v_paket', $column_order, $column_search, $order, $where),
                "data" => $data,
            );

            echo json_encode($output);
        }
    }

    public function dt_paket_evidence_ditolak()
    {
        if (!$this->input->is_ajax_request()) {
            show_404();
        } else {
            $id_instansi    = sbe_crypt($this->input->post('id_instansi'), 'D');
            $where          = array('id_instansi' => $id_instansi, 'ditolak > '=>0);
            $column_order   = array('', 'nama_paket');
            $column_search  = array('nama_paket','nilai','ditolak');
            $order = array('nama_paket' => 'ASC');
            $list = $this->datatables_model->get_datatables('v_paket', $column_order, $column_search, $order, $where);
            $data = array();
            $no = $_POST['start'];
            foreach ($list as $lists) {
                $no++;
                $id_paket =  $lists->id_paket_pekerjaan;
                $nilai_paket = $this->validasi_fisik_model->nilai_paket($id_paket)->totalnilai > 0 ? $this->validasi_fisik_model->nilai_paket($id_paket)->totalnilai : 0;
                $diperiksa = $this->db->query("SELECT id_realisasi_fisik from realisasi_fisik where id_paket_pekerjaan='$id_paket' and status in ('Sudah Validasi', 'Ditolak')")->num_rows();
                $banyak_evidence = $this->db->query("SELECT id_realisasi_fisik from realisasi_fisik where id_paket_pekerjaan='$id_paket'")->num_rows();

                $row   = array();
                $row[] = $no;

              


            

                $tombol_open = '<button class="btn btn-outline-warning btn-sm" onclick="identitas_paket('.$id_paket.')"><i class="fa fa-folder-open"></i></button>';

                $kode_sub_kegiatan = $lists->kode_rekening_sub_kegiatan;
                $pecah = explode('.', $kode_sub_kegiatan);
                $krsk = $pecah[0].'.'.$pecah[1].'.'.$pecah[2].'.'.$pecah[3].'.'.$pecah[4].'.'.$pecah[5];
                
                $q_ski = $this->db->query("SELECT * from sub_kegiatan_instansi where kode_sub_kegiatan='$kode_sub_kegiatan' and id_instansi='$id_instansi'")->row_array();

                $uptd  = $q_ski['kategori']=='Sub Kegiatan SKPD' ? '' : '<br>'.$q_ski['jenis_sub_kegiatan'].' - '.$q_ski['keterangan'];
                
               
                $row[] = $lists->nama_pptk;
                $row[] = $lists->nama_sub_kegiatan.$uptd;
                $row[] = $lists->nama_paket;
                $row[] = $lists->jenis_paket;
                $row[] = $lists->ditolak;
                $row[] = $lists->nilai==''? 0 : round($lists->nilai,2);
                $row[] = $tombol_open;

                $data[] = $row;
            }

            $output = array(
                "draw" => $_POST['draw'],
                "recordsTotal" => $this->datatables_model->count_all('v_paket', $where),
                "recordsFiltered" => $this->datatables_model->count_filtered('v_paket', $column_order, $column_search, $order, $where),
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
            $column_search  = array('nama_paket','nilai','belum_validasi');
            $order = array('nama_paket' => 'ASC');
            $list = $this->datatables_model->get_datatables('v_paket_penyedia', $column_order, $column_search, $order, $where);
            $data = array();
            $no = $_POST['start'];
            foreach ($list as $lists) {
                $no++;
                $id_paket =  $lists->id_paket_pekerjaan;
                $nilai_paket = $this->validasi_fisik_model->nilai_paket($id_paket)->totalnilai > 0 ? $this->validasi_fisik_model->nilai_paket($id_paket)->totalnilai : 0;
                $diperiksa = $this->db->query("SELECT id_realisasi_fisik from realisasi_fisik where id_paket_pekerjaan='$id_paket' and status in ('Sudah Validasi', 'Ditolak')")->num_rows();
                $banyak_evidence = $this->db->query("SELECT id_realisasi_fisik from realisasi_fisik where id_paket_pekerjaan='$id_paket'")->num_rows();

                $row   = array();
                $row[] = $no;

                $warna_tombol = $banyak_evidence == 0 ? 'btn-outline-info' :$this->validasi_fisik_model->get_status_validasi_paket($lists->id_instansi, $lists->id_paket_pekerjaan, $lists->dok);


                $tombol_action = '<button class="btn ' . $warna_tombol . ' btn-sm view_evidence_'.$id_paket.'" id="detail-realisasi-fisik" status="collapse" id-instansi="' . $lists->id_instansi . '" id-paket-pekerjaan="' . $lists->id_paket_pekerjaan . '" nama-kpa="' . $this->validasi_fisik_model->get_kpa($lists->id_sub_instansi)['full_name'] . '" nama-pptk="' . $lists->full_name . '" nama-program="' . $this->validasi_fisik_model->get_program_kegiatan($lists->kode_rekening_sub_kegiatan)['nama_program'] . '" nama-kegiatan="' . $this->validasi_fisik_model->get_program_kegiatan($lists->kode_rekening_sub_kegiatan)['nama_kegiatan'] . '" vol="' . $this->vol($lists->id_paket_pekerjaan) . '" banyak_evidence="'.$banyak_evidence.'" nama_paket="'.$lists->nama_paket.'"><i class="fa fa-plus"></i></button>';

                $tombol_open = '<button class="btn ' . $warna_tombol . ' btn-sm" onclick="identitas_paket('.$id_paket.')"><i class="fa fa-folder-open"></i></button>';

                $kode_sub_kegiatan = $lists->kode_rekening_sub_kegiatan;
                $pecah = explode('.', $kode_sub_kegiatan);
                $krsk = $pecah[0].'.'.$pecah[1].'.'.$pecah[2].'.'.$pecah[3].'.'.$pecah[4].'.'.$pecah[5];
                
                $q_ski = $this->db->query("SELECT * from sub_kegiatan_instansi where kode_sub_kegiatan='$kode_sub_kegiatan' and id_instansi='$id_instansi'")->row_array();

                $uptd  = $q_ski['kategori']=='Sub Kegiatan SKPD' ? '' : '<br>'.$q_ski['jenis_sub_kegiatan'].' - '.$q_ski['keterangan'];
                
               
                $row[] = $lists->full_name;
                $row[] = $lists->nama_sub_kegiatan.$uptd;
                $row[] = $lists->nama_paket;
                $row[] = $lists->belum_validasi;
                $row[] = $lists->nilai==''? 0 : round($lists->nilai,2);
                $row[] = $tombol_open;

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


    public function statistika()
    {
        if (!$this->input->is_ajax_request()) {
            show_404();
        } else {
            $output = [
                'status'    => false,
                'data'      => [],
                'message'   => ''
            ];

            $id_instansi        = sbe_crypt($this->input->post('id_instansi'), 'D') ;
            $value      = $this->validasi_fisik_model->statistika($id_instansi)->row();
            $output['data']['id_instansi'] = $value->id_instansi;
            $output['data']['nama_tahap'] = nama_tahapan();
            $output['data']['nama_instansi'] = $value->nama_instansi;
            $output['data']['helpdesk'] = $value->helpdesk == '' ? 'Belum Ditentukan' : $value->helpdesk;
            $output['data']['nohp'] = $value->nohp == '' ? '' : $value->nohp;;
            $output['data']['total_paket'] = $value->total_paket;
            $output['data']['total_paket_swakelola'] = $value->total_paket_swakelola;
            $output['data']['total_paket_penyedia'] = $value->total_paket_penyedia;
            $output['data']['total_paket_rutin'] = $value->total_paket_rutin;
            $output['data']['total_program'] = $value->total_program;
            $output['data']['total_kegiatan'] = $value->total_kegiatan;
            $output['data']['total_sub_kegiatan'] = $value->total_sub_kegiatan;
            $output['data']['total_evidence_diupload'] = $value->total_evidence_diupload;
            $output['data']['total_evidence_belum_validasi'] = $value->total_evidence_belum_validasi;
            $output['data']['total_evidence_belum_validasi_swakelola'] = $value->total_evidence_belum_validasi_swakelola;
            $output['data']['total_evidence_belum_validasi_penyedia'] = $value->total_evidence_belum_validasi_penyedia;
            $output['data']['total_evidence_approve'] = $value->total_evidence_approve;
            $output['data']['total_evidence_reject'] = $value->total_evidence_reject;


            echo json_encode($output);
        }
    }
    public function identitas_paket()
    {
        if (!$this->input->is_ajax_request()) {
            show_404();
        } else {
            $output = [
                'status'    => false,
                'data'      => [],
                'evidence'      => [],
                'message'   => ''
            ];

            $id_paket        = $this->input->post('id_paket');
            $q = $this->db->query("
                SELECT pp.*, total_nilai_evidence(pp.id_paket_pekerjaan) as nilai_paket,
                mp.kode_program, mp.nama_program,
                mk.kode_kegiatan, mk.nama_kegiatan,
                msk.kode_sub_kegiatan, msk.nama_sub_kegiatan,
                ski.jenis_sub_kegiatan, ski.keterangan, ski.kategori,
                mu.full_name as nama_pptk,
                (SELECT count(id_paket_pekerjaan) from vol_pelaksanaan_pekerjaan vpp where vpp.id_paket_pekerjaan=pp.id_paket_pekerjaan) as volume_paket,
                (SELECT count(id_paket_pekerjaan) from realisasi_fisik rf where rf.id_paket_pekerjaan=pp.id_paket_pekerjaan) as evidence_diupload,
                (SELECT count(id_paket_pekerjaan) from realisasi_fisik rf where rf.id_paket_pekerjaan=pp.id_paket_pekerjaan and status='Belum Validasi') as belum_diperiksa
                 from paket_pekerjaan pp 
                left join sub_kegiatan_instansi ski on pp.kode_rekening_sub_kegiatan = ski.kode_sub_kegiatan
                left join master_sub_kegiatan msk on(trim(substr(pp.kode_rekening_sub_kegiatan,1,15)) = trim(msk.kode_sub_kegiatan))
                left join master_kegiatan mk on pp.kode_rekening_kegiatan= mk.kode_kegiatan
                left join master_program mp on pp.kode_rekening_program= mp.kode_program
                left join users_sub_kegiatan usk on pp.kode_rekening_sub_kegiatan = usk.kode_rekening_sub_kegiatan
                left join master_users mu on usk.id_user = mu.id_user
                where pp.id_paket_pekerjaan = '$id_paket'
                ")->row_array();

            $nama_sub_kegiatan = $q['kategori'] =='Sub Kegiatan SKPD' ? $q['nama_sub_kegiatan'] : $q['nama_sub_kegiatan'].'<br>'.$q['jenis_sub_kegiatan'].' - '.$q['keterangan'];
            $output['data']['nama_program'] = $q['nama_program'];
            $output['data']['nama_kegiatan'] = $q['nama_kegiatan'];
            $output['data']['kode_sub_kegiatan'] = $q['kode_rekening_sub_kegiatan'];
            $output['data']['nama_sub_kegiatan'] = $nama_sub_kegiatan;
            $output['data']['nama_pptk'] = $q['nama_pptk'];
            $output['data']['volume_paket'] = $q['volume_paket'];
            $output['data']['evidence_diupload'] = $q['evidence_diupload'];
            $output['data']['belum_diperiksa'] = $q['belum_diperiksa'];
            $output['data']['nama_paket'] = $q['nama_paket'];
            $output['data']['nilai_paket'] = $q['nilai_paket'];
            $output['data']['id_group'] = $this->session->userdata('id_group');

            $dok_realisasi      = $this->validasi_fisik_model->get_dok_realisasi($id_paket);
            $primary_folder     = 'sbe_files_data/';
            $directory          = [
                $this->sbe_tahun_anggaran(),
                $q['id_instansi'],
                'REALISASI-FISIK',
                $id_paket,
            ];
            $list_directory     = $this->sbe_directory($primary_folder, $directory);
            foreach ($dok_realisasi->result_array() as $key => $value) {
                    $output['evidence'][$key]['id_realisasi_fisik'] = $value['id_realisasi_fisik'];
                    $output['evidence'][$key]['id_realisasi_fisik_enc'] = sbe_crypt($value['id_realisasi_fisik'], 'E');
                    $output['evidence'][$key]['dokumen']            = $this->split($value['dokumen']);
                    $output['evidence'][$key]['jenis_paket']            = $this->split($value['jenis_paket']);
                    $output['evidence'][$key]['id_metode']            = $this->split($value['id_metode']);
                    $output['evidence'][$key]['jenis_paket']            = $this->split($value['jenis_paket']);
                    $output['evidence'][$key]['file_dokumen']       = $list_directory . $value['file_dokumen'];
                    $output['evidence'][$key]['nilai']              = $value['nilai'];
                    $output['evidence'][$key]['status']              = $value['status'];
                    $output['evidence'][$key]['pelaksanaan']              = $value['id_vol_pelaksanaan_pekerjaan'] =='' ? '' : $value['pelaksanaan_ke'] .' | '.$value['nama_pelaksanaan'];
                      $output['data'][$key]['jenis_paket']        = $value['jenis_paket'];
                    $output['data'][$key]['id_metode']          = $value['id_metode'];
                    $jumlah_pelaksanaan = $this->validasi_fisik_model->total_volume($id_paket)->total_volume;
                    if ($value['jenis_paket']=="SWAKELOLA") {
                       $nilai_pelaksanaan = round( 75 / $jumlah_pelaksanaan, 2);
                    }else{
                       $nilai_pelaksanaan = round( 70 / $jumlah_pelaksanaan, 2);
                    }
                    $output['evidence'][$key]['nilai_pelaksanaan']              = $value['id_vol_pelaksanaan_pekerjaan'] =='' ? '' : $nilai_pelaksanaan;
                    
                    
                }

            $output['data']['id_paket_pekerjaan'] = $id_paket;


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
                    $output['data'][$key]['pelaksanaan']              = $value->id_vol_pelaksanaan_pekerjaan =='' ? '' : $value->pelaksanaan_ke .' | '.$value->nama_pelaksanaan.'';
                    
                    $jumlah_pelaksanaan = $this->validasi_fisik_model->total_volume($id_paket_pekerjaan)->total_volume;
                    if ($value->jenis_paket=="SWAKELOLA") {
                       $nilai_pelaksanaan = round( 75 / $jumlah_pelaksanaan, 2);
                    }else{
                       $nilai_pelaksanaan = round( 70 / $jumlah_pelaksanaan, 2);
                    }
                    $output['data'][$key]['nilai_pelaksanaan']              = $value->id_vol_pelaksanaan_pekerjaan =='' ? '' : $nilai_pelaksanaan;
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
            $id_paket_pekerjaan = $this->input->post('id_paket_pekerjaan');
            $jenis_paket = $this->input->post('jenis_paket');
            $dokumen = $this->input->post('dokumen');

            // $nilai = $this->db->query("SELECT total_nilai_evidence($id_paket_pekerjaan) as nilai; ")->row_array();
            // $nilai_sementara = $nilai['nilai'];
            // if ($jenis_paket=='SWAKELOLA') {
            //     if ($dokumen=='LAPORAN') {
            //         if ($nilai_sementara>95) {
            //              $output['status']   = false;
            //             $output['message']     = "Validasi gagal. Nilai lebih setelah di validasi akan menjadi lebih dari 100. Harap periksa kembali nilai / perbaharui nilai pada bagian evidence pelaksanan ";
            //         }
            //         elseif ($nilai_sementara<95) {
            //              $output['status']   = false;
            //             $output['message']     = "Validasi gagal. Nilai lebih setelah di validasi akan menjadi kurang dari 100. Harap periksa kembali nilai / perbaharui nilai pada bagian evidence pelaksanan";
            //         }else{
            //             $update = $this->validasi_fisik_model->update_nilai();
            //              $output['status']   = true;
            //             $output['data']     = $this->validasi_fisik_model->get_id_instansi($id_realisasi_fisik);
            //         }
            //     }else{
            //         $update = $this->validasi_fisik_model->update_nilai();
            //          $output['status']   = true;
            //         $output['data']     = $this->validasi_fisik_model->get_id_instansi($id_realisasi_fisik);
            //     }
            // }else{
            //      if ($dokumen=='FHO') {
            //         if ($nilai_sementara>100) {
            //              $output['status']   = false;
            //             $output['message']     = "Validasi gagal. Nilai lebih setelah di validasi akan menjadi lebih dari 100. Harap periksa kembali nilai / perbaharui nilai pada bagian evidence pelaksanan ";
            //         }
            //         elseif ($nilai_sementara<100) {
            //              $output['status']   = false;
            //             $output['message']     = "Validasi gagal. Nilai lebih setelah di validasi akan menjadi kurang dari 100. Harap periksa kembali nilai / perbaharui nilai pada bagian evidence pelaksanan";
            //         }else{
            //             $update = $this->validasi_fisik_model->update_nilai();
            //              $output['status']   = true;
            //             $output['data']     = $this->validasi_fisik_model->get_id_instansi($id_realisasi_fisik);
            //         }
            //     }else{
            //         $update = $this->validasi_fisik_model->update_nilai();
            //         $output['status']   = true;
            //         $output['data']     = $this->validasi_fisik_model->get_id_instansi($id_realisasi_fisik);
            //     }

            // }
            $update = $this->validasi_fisik_model->update_nilai();
                    $output['status']   = true;
                    $output['data']     = $this->validasi_fisik_model->get_id_instansi($id_realisasi_fisik);
          

            echo json_encode($output);
        }
    }



    public function pdf_rekap_statistika()
    {
        $mpdf = new \Mpdf\Mpdf([
            'mode' => 'utf-8',
            'format' => 'Legal',
            'orientation' => 'P',
            'tempDir' => '/tmp'
        ]);


        // $mpdf->setFooter('Page {PAGENO}');
        

            if ($this->sbe_group_name() == 'OPERATOR') { 
                $instansi = $this->validasi_fisik_model->get_instansi_by_id(); 
            } elseif ($this->sbe_group_name() == 'HELPDESK') { 
                $instansi = $this->validasi_fisik_model->get_instansi(); 
            } elseif ($this->sbe_group_name() == 'ADMIN') { 
                $instansi =$this->db->query("SELECT id_instansi, nama_instansi, is_active from
            master_instansi where kategori='OPD' and is_active='1' order by nama_instansi asc"); 
            }
      
               $skpd = [];
                foreach ($instansi->result() as $key => $value) {
                    // if ($value->is_active=='1') {
                    $statistika = $this->validasi_fisik_model->statistika($value->id_instansi)->row();
                    $data_skpd = [
                        'is_active'=>$value->is_active,
                        'nama_instansi'=>$statistika->nama_instansi,
                        'helpdesk'=>$statistika->helpdesk,
                        'total_program'=>$statistika->total_program,
                        'total_kegiatan'=>$statistika->total_kegiatan,
                        'total_sub_kegiatan'=>$statistika->total_sub_kegiatan,
                        'total_paket'=>$statistika->total_paket,
                        'total_evidence_diupload'=>$statistika->total_evidence_diupload,
                        'total_evidence_belum_validasi'=>$statistika->total_evidence_belum_validasi,
                        'total_evidence_belum_validasi_swakelola'=>$statistika->total_evidence_belum_validasi_swakelola,
                        'total_evidence_belum_validasi_penyedia'=>$statistika->total_evidence_belum_validasi_penyedia,
                        'total_evidence_approve'=>$statistika->total_evidence_approve,
                        'total_evidence_reject'=>$statistika->total_evidence_reject,
                        ];
                    array_push($skpd, $data_skpd);
                        # code...
                    // }
                }

               


        $data['skpd'] = $skpd ; 
        $judul_laporan = "Statistika evidence" ;
        $data['judul_laporan'] = $judul_laporan; 


        $html =  $this->load->view('validasi/pdf/rekap_statistika/content', $data, true);

        $header =  $this->load->view('validasi/pdf/rekap_statistika/header', $data, true);
        $footer =  $this->load->view('validasi/pdf/rekap_statistika/footer', $data, true);

        $mpdf->SetMargins(0, 0, 20);

        $mpdf->SetHTMLHeader($header);
        // $mpdf->SetHTMLFooter($footer);
        $mpdf->WriteHTML($html);
        $mpdf->Output($judul_laporan.'.pdf', 'I');
    }


}
