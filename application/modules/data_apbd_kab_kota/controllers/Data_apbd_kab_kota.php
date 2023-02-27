<?php

/**
 * Author     : Alfikri, M.Kom
 * Created By : Alfikri, M.Kom
 * E-Mail     : alfikri.name@gmail.com
 * No HP      : 081277337405
 * Class      : Paket_pekerjaan.php
 */
defined('BASEPATH') or exit('No direct script access allowed');

class Data_apbd_kab_kota extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->form_validation->CI = &$this;
        $this->load->model([
            'data_apbd_kab_kota/data_apbd_kab_kota_model'      => 'data_apbd_kab_kota_model',

            'instansi/instansi_model' => 'instansi_model',
            'datatables_model'                         => 'datatables_model'
        ]);
    }

    public function anggaran_instansi_kab_kota()
    {
        $breadcrumbs    = $this->breadcrumbs;
            $instansi       = $this->instansi_model;

            $breadcrumbs->add('Home', base_url());
            $breadcrumbs->add('Data APBD', base_url($this->router->fetch_class()));
            $breadcrumbs->render();
            $tahap = tahapan_apbd();
            $namatahap =pilihan_nama_tahapan($tahap);
            $data['tahap']          = $namatahap;
            $data['title']          = "Data APBD ";
            $data['icon']           = "metismenu-icon pe-7s-culture";
            $data['description']    = "Menampilkan Data APBD Lingkut Kabupaten / Kota";
            $data['breadcrumbs']    = $breadcrumbs->render();
            $page                   = 'data_apbd_kab_kota/anggaran_instansi_kab_kota/index';
            $data['link']           = $this->router->fetch_method();
            $data['menu']           = $this->load->view('layout/menu', $data, true);
            $data['extra_css']      = $this->load->view('data_apbd_kab_kota/anggaran_instansi_kab_kota/css', $data, true);
            $data['extra_js']       = $this->load->view('data_apbd_kab_kota/anggaran_instansi_kab_kota/js', $data, true);
            $data['modal']      = $this->load->view('data_apbd_kab_kota/anggaran_instansi_kab_kota/modal', $data, true);
            $this->template->load('backend_template', $page, $data);
    }



    public function data_anggaran_instansi_kab_kota()
    {
        if (!$this->input->is_ajax_request()) {
            show_404();
        } else {       

            $tahap = tahapan_apbd();
            $tahun_anggaran = tahun_anggaran();
                $id_kota = $this->session->userdata('id_kota') ;    
                $where          = ['kategori'=>'OPD', 'id_kota'=>$id_kota];
            
            $column_order   = ['', 'nama_instansi'];
            $column_search  = ['nama_instansi','kode_opd'];
            $order          = ['nama_instansi' => 'ASC'];
            $list           = $this->datatables_model->get_datatables('master_instansi_kab_kota', $column_order, $column_search, $order, $where);
            $data           = [];
            $no             = $_POST['start'];
            $status = ['Tidak Aktif','Aktif'];
            foreach ($list as $lists) {
                $no++;
                $id_instansi  = $lists->id_instansi;
                $q_pagu = $this->db->query("SELECT pagu_bo,pagu_bm,pagu_btt,pagu_bt from v_instansi_kab_kota where id_instansi='$id_instansi' and kode_tahap='$tahap' and tahun='$tahun_anggaran'");
                $d_pagu = $q_pagu->row();
                $j_pagu = $q_pagu->num_rows();
                $pagu_bo = $j_pagu == 0 ? 0 : $d_pagu->pagu_bo ;
                $pagu_bm = $j_pagu == 0 ? 0 : $d_pagu->pagu_bm ;
                $pagu_btt = $j_pagu == 0 ? 0 : $d_pagu->pagu_btt ;
                $pagu_bt = $j_pagu == 0 ? 0 : $d_pagu->pagu_bt ;
                $pagu_total = $pagu_bo + $pagu_bm + $pagu_btt + $pagu_bt;

                $row    = [];
                $row[]     = $no;
                $row[]  = $lists->nama_instansi;
               
                $row[]  = number_format($pagu_bo);
                $row[]  = number_format($pagu_bm);
                $row[]  = number_format($pagu_btt);
                $row[]  = number_format($pagu_bt);
                $row[]  = number_format($pagu_total);
               

               $onclick3 = "get_target_kab_kota('".$lists->nama_instansi."','".$lists->id_instansi."','".$lists->id_kota."','".tahapan_apbd()."','".tahun_anggaran()."','".$pagu_total."')";
            $tomboltarget = ' <button class="btn btn-outline-info btn-xs"  title="Input target realisasi  '.$lists->nama_instansi.'"  onclick="'.$onclick3.'"><i class="fas fa-crosshairs"></i></button> ';
            $tomboltarget_forbidden = ' <button class="btn btn-outline-danger btn-xs"  title="Input target realisasi  '.$lists->nama_instansi.'"  onclick="input_target_forbidden('."'".$lists->nama_instansi."'".')"><i class="fas fa-crosshairs"></i></button> ';



                $tombol_edit = '<button class="btn btn-outline-info btn-xs"  title="Input / Edit Pagu Instansi '.$lists->nama_instansi.'"  onclick="input_pagu_instansi('."'".sbe_crypt($lists->id_instansi, 'E')."'".','.$tahap.')"><i class="fas fa-money-bill"></i></button>';

                $tombol_copy = ' <button class="btn btn-outline-info btn-xs"  title="Copu Pagu  APBD AWAL Instansi '.$lists->nama_instansi.'"  onclick="copy_pagu_instansi('."'".sbe_crypt($lists->id_instansi, 'E')."'".','.$tahap.', '."'".$lists->nama_instansi."'".')"><i class="fas fa-copy"></i></button>';

                if ($pagu_total >0) {
                    $show_tombol_target = $tomboltarget;
                }else{
                    $show_tombol_target = $tomboltarget_forbidden;

                }
                
                if ($tahap==4 && $j_pagu==0) {
                    $row[]  = $tombol_edit.$tombol_copy;
                    # code...
                }else{
                    $row[]  = $tombol_edit.$show_tombol_target;

                }


                $data[] = $row;
            }

            $output = [
                "draw"              => $_POST['draw'],
                "recordsTotal"      => $this->datatables_model->count_all('master_instansi_kab_kota', $where),
                "recordsFiltered"   => $this->datatables_model->count_filtered('master_instansi_kab_kota', $column_order, $column_search, $order, $where),
                "data"              => $data,
            ];

            echo json_encode($output);
        }
    }




    public function get_anggaran_instansi_kab_kota()
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

           
            $id_instansi = sbe_crypt($this->input->post('id_instansi'),'D');
            $tahap = $this->input->post('tahap');
            $tahun = tahun_anggaran();
            $where = [ 'kode_tahap'=>$tahap,'tahun'=>$tahun,   'id_instansi' =>$id_instansi];

            $pagu    = $this->db->get_where('anggaran_instansi_kab_kota', $where);
            $identitas_instansi        = $this->db->query("SELECT * from v_instansi_kab_kota where id_instansi='$id_instansi'")->row();
                $output['data']['nama_instansi']                  =  $identitas_instansi->nama_instansi ;
    



            if ($pagu->num_rows() > 0) {
                foreach ($pagu->result() as $key => $value) {
                    $output['data']['bo_bp']                  = $value->bo_bp;
                    $output['data']['bo_bbj']                  = $value->bo_bbj;
                    $output['data']['bo_bs']                  = $value->bo_bs;
                    $output['data']['bo_bh']                  = $value->bo_bh;
                    $output['data']['bo_bbs']                  = $value->bo_bbs;
                    $output['data']['bm_bmt']                  = $value->bm_bmt;
                    $output['data']['bm_bmpm']                  = $value->bm_bmpm;
                    $output['data']['bm_bmgb']                  = $value->bm_bmgb;
                    $output['data']['bm_bmjji']                  = $value->bm_bmjji;
                    $output['data']['bm_bmatl']                  = $value->bm_bmatl;
                    $output['data']['bm_bmatb']                  = $value->bm_bmatb;
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


    public function get_anggaran_total_kab_kota()
    {
        if (!$this->input->is_ajax_request()) {
            show_404();
        } else {
            $output = [
                'status'    => true,
                'data'      => [],
              
            ];

           
            $id_kota = $this->session->userdata('id_kota');
            $data_apbd_kab_kota_model = $this->data_apbd_kab_kota_model;
            $tahap = tahapan_apbd();
            $tahun = tahun_anggaran();
            $where = [ 'kode_tahap'=>$tahap,'tahun'=>$tahun,   'id_kota' =>$id_kota];

            $pagu    = $data_apbd_kab_kota_model->anggaran_total_kab_kota($id_kota, $tahun, $tahap);
           

                    $output['data']['bo']                  = $pagu['bo'];
                    $output['data']['bm']                  = $pagu['bm'];
                    $output['data']['btt']                  = $pagu['btt'];
                    $output['data']['bt']                  = $pagu['bt'];
                    $output['data']['total']                  = $pagu['total'];
                    $output['data']['periode']                  = 'Total Pagu '.pilihan_nama_tahapan($tahap).' Tahun '.$tahun;
             

            echo json_encode($output);
        }
    }



 public function rule_pagu_instansi_kab_kota()
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


    public function save_anggaran_instansi_kab_kota()
    {
        if (!$this->input->is_ajax_request()) {
            show_404();
        } else {
            $output    = [
                'success' => false,
                'messages' => []
            ];
            $data_group     = [];
            $data_apbd_kab_kota_model     = $this->data_apbd_kab_kota_model;
            $validation     = $this->form_validation;
            $validation->set_rules($this->rule_pagu_instansi_kab_kota());
            $validation->set_error_delimiters('<p class="text-danger">', '</p>');


                $tahap = $this->input->post('tahap');
                $id_instansi = sbe_crypt($this->input->post('id_instansi'), 'D');
                $where = ['kode_tahap'=>$tahap,   'id_instansi' => $id_instansi];

            if ($validation->run($this)) {
                

                $pagu_instansi_kab_kota    = $this->db->get_where('anggaran_instansi_kab_kota', $where);
                if ($pagu_instansi_kab_kota->num_rows()>0) {
                    $id_paket_pekerjaan = $data_apbd_kab_kota_model->saveedit_anggaran_instansi_kab_kota($where);
                    
                }else{
                    $id_paket_pekerjaan = $data_apbd_kab_kota_model->save_anggaran_instansi_kab_kota();
                }


                    $output['success']     = true;
                    $output['messages'] = "Pagu berhasil di simpan";
                    $output['cek'] = $where;
                
            } else {
                $output['success'] = false;
                foreach ($_POST as $key => $value) {
                    $output['messages'][$key] = form_error($key);
                }
            }
            echo json_encode($output);
        }
    }




    
    public function update_target_fisik($id_instansi)
    {
        $id_target_apbd = sbe_crypt($this->input->post('pk'), 'D');
        $target_fisik   = $this->input->post('value');
        $target         = $this->db->get_where('target_apbd_kab_kota', ['id_target_apbd_kab_kota' => $id_target_apbd])->row_array();
        $target_lalu    = $this->db->get_where('target_apbd_kab_kota', ['id_instansi' => $id_instansi, 'bulan' => $target['bulan'] - 1, 'kode_tahap' => tahapan_apbd(),'tahun' => tahun_anggaran()])->row_array();

        if ($target['bulan'] == 1) {
            $nilai = $target_fisik;
        } elseif ($target['bulan'] > 1 && $target['bulan'] <= 12) {
            $nilai = $target_fisik + $target_lalu['target_fisik'];
        }

        if ($nilai >= 100) {
            for ($i = $target['bulan']; $i <= 12; $i++) {
                if ($i==$target['bulan']) {
                    $target_fisik_otomatis = 100 - $target_lalu['target_fisik'];
                    $this->db->update('target_apbd_kab_kota', ['target_fisik' => 100,'target_fisik_bulanan' => $target_fisik_otomatis], ['id_instansi' => $id_instansi, 'bulan' => $i,  'id_instansi'=>$id_instansi]);
                }else{
                    $this->db->update('target_apbd_kab_kota', ['target_fisik' => 100, 'target_fisik_bulanan' => 0], ['id_instansi' => $id_instansi, 'bulan' => $i,  'id_instansi'=>$id_instansi]);
                }
            }
        } else {
            $this->db->update('target_apbd_kab_kota', ['target_fisik' => $nilai,'target_fisik_bulanan' => $target_fisik], ['id_target_apbd_kab_kota' => $id_target_apbd]);
        }
    }


    
    public function update_target_keuangan($id_instansi, $pagu)
    {
        $id_target_apbd = sbe_crypt($this->input->post('pk'), 'D');
        $t_keu   = $this->input->post('value');
        $target_keu      =str_replace(".", "", $t_keu);
        $target         = $this->db->get_where('target_apbd_kab_kota', ['id_target_apbd_kab_kota' => $id_target_apbd])->row_array();
        $target_lalu    = $this->db->get_where('target_apbd_kab_kota', ['id_instansi' => $id_instansi, 'bulan' => $target['bulan'] - 1, 'kode_tahap' => tahapan_apbd() ,'tahun' => tahun_anggaran()])->row_array();
        // qski = query sub kegiatan instansi
        $tahap = tahapan_apbd();
        $tahun = tahun_anggaran();
        // $qski = $this->db->query("SELECT * from v_sub_kegiatan_apbd where kode_tahap='$tahap' and id_instansi='$id_instansi' and id_instansi='$id_instansi' and tahun='$tahun'")->row();
        //$pagu = 123456 ;//$qski->pagu =="" ? 0 : $qski->pagu;

        // qski error
        if ($target['bulan'] == 1) {
            $nilai = $target_keu;
        } elseif ($target['bulan'] > 1 && $target['bulan'] <= 12) {
            $nilai = $target_keu + $target_lalu['target_keuangan'];
        }

        if ($nilai >= $pagu) {
            for ($i = $target['bulan']; $i <= 12; $i++) {
                 if ($i==$target['bulan']) {
                    $target_keuangan_otomatis = $pagu - $target_lalu['target_keuangan'];
                    $update = $this->db->update('target_apbd_kab_kota', ['target_keuangan' => $pagu,'target_keuangan_bulanan' => $target_keuangan_otomatis], ['id_instansi' => $id_instansi, 'bulan' => $i]);
                }else{
                    $update = $this->db->update('target_apbd_kab_kota', ['target_keuangan' => $pagu, 'target_keuangan_bulanan' => 0], ['id_instansi' => $id_instansi, 'bulan' => $i]);
                }

            }
        } else {
            $update = $this->db->update('target_apbd_kab_kota', ['target_keuangan' => $nilai, 'target_keuangan_bulanan' => $target_keu], ['id_target_apbd_kab_kota' => $id_target_apbd]);
        }


        // echo json_encode($cek_pagu);
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
            $id_instansi = $this->input->post('id_instansi');
            $id_kota = $this->input->post('id_kota');
            $tahap = $this->input->post('tahap');
            $tahun = $this->input->post('tahun');
           
            $where = [
                'id_instansi' => $id_instansi, 
                'id_kota' => $id_kota, 
                'kode_tahap' => $tahap,
                'tahun' => $tahun,
                'id_instansi' => $id_instansi
            ];
            $target                 = $this->db->get_where('target_apbd_kab_kota', $where);
            // $subkeg                 = $this->db->query("SELECT nama_sub_kegiatan, kategori, jenis_sub_kegiatan, keterangan from v_sub_kegiatan_apbd where kode_rekening_sub_kegiatan='$kode_rekening_sub_kegiatan' and kode_tahap='$tahap' and id_instansi='$id_instansi' and tahun = '$tahun'")->row();
            // $nama_sub_kegiatan = $subkeg->kategori =='Sub Kegiatan SKPD' ? $subkeg->nama_sub_kegiatan : $subkeg->nama_sub_kegiatan.'<br>'.$subkeg->jenis_sub_kegiatan.' - '.$subkeg->keterangan;

            // $pecah = explode('.', $kode_rekening_sub_kegiatan);
            // $kode_sub_kegiatan = $pecah[0].'.'.$pecah[1].'.'.$pecah[2].'.'.$pecah[3].'.'.$pecah[4].'.'.$pecah[0];
            $output['totaldata']             = $target->num_rows();
            $output['kategori']              = '';//$subkeg->kategori;
            $output['nama_sub_kegiatan']     = '';//$nama_sub_kegiatan;
            $output['kode_sub_kegiatan']     = '';//$kode_sub_kegiatan;
            $output['nama_tahapan']  = nama_tahapan();
            if ($target->num_rows() > 0) {
                foreach ($target->result() as $key => $value) {
                    $output['data'][$key]['id']         = sbe_crypt($value->id_target_apbd_kab_kota, 'E');
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
                        'id_instansi' => $id_instansi, 
                        'id_kota' => $id_kota, 
                        'kode_tahap' => $tahap,
                        'tahun' => $tahun,
                        'bulan' => $bulan,
                        'id_instansi' => id_instansi()
                    ];
                    $cek = $this->db->get_where('target_apbd_kab_kota', $wherenull);
                    if ($cek->num_rows()==0) {
                        $insert = [
                            'id_instansi'=>$id_instansi,
                            'id_kota'=>$id_kota,
                            'kode_tahap'=>$tahap,
                            'bulan'=>$bulan,
                            'target_fisik'=>0,
                            'target_keuangan'=>0,
                            'target_keuangan_bulanan'=>0,
                            'tahun'=>$tahun,
                            'created_on'=> timestamp(), 
                            'created_by'=>id_user()
                        ];
                        $this->db->insert('target_apbd_kab_kota', $insert);
                    }
                }
            }

            echo json_encode($output);
        }
    }




}
