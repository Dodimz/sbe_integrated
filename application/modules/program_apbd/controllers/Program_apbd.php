<?php
/**
	* Author     : Alfikri, M.Kom
	* Created By : Alfikri, M.Kom
	* E-Mail     : alfikri.name@gmail.com
	* No HP      : 081277337405
	* Class      : Program_apbd.php
*/
defined('BASEPATH') OR exit('No direct script access allowed');

class Program_apbd extends MY_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model(['program_apbd/program_apbd_model'     => 'program_apbd_model',
    						'datatables_model'                    => 'datatables_model']);
	}

	public function index()
	{
        $breadcrumbs    = $this->breadcrumbs;
        $program_apbd   = $this->program_apbd_model;

		$breadcrumbs->add('Home', base_url());
		$breadcrumbs->add('Program APBD', base_url($this->router->fetch_class()));
		$breadcrumbs->render();

		$data['title']			            = "Program APBD";
        $data['icon']                       = "metismenu-icon pe-7s-cash";
		$data['description']	            = "Menampilkan Program APBD";
		$data['breadcrumbs']	            = $breadcrumbs->render();
        $data['anggaran_apbd']              = $program_apbd->anggaran_apbd();
        $data['total_program_apbd']         = $program_apbd->total_program_apbd();
        $data['belanja_pegawai_prog']       = $program_apbd->belanja_pegawai_prog();
        $data['belanja_barang_jasa_prog']   = $program_apbd->belanja_barang_jasa_prog();
        $data['belanja_modal_prog']         = $program_apbd->belanja_modal_prog();
        $data['persentase_bp_prog']         = $data['anggaran_apbd'] != 0 ? ROUND(($data['belanja_pegawai_prog'] / $data['anggaran_apbd']) * 100,2) : 0;
        $data['persentase_bbj_prog']        = $data['anggaran_apbd'] != 0 ? ROUND(($data['belanja_barang_jasa_prog'] / $data['anggaran_apbd']) * 100,2) : 0;
        $data['persentase_bm_prog']         = $data['anggaran_apbd'] != 0 ? ROUND(($data['belanja_modal_prog'] / $data['anggaran_apbd']) * 100,2) : 0;
		$page 					            = 'program_apbd/program_apbd/index';
        $data['link']                       = $this->router->fetch_method();
        $data['menu']                       = $this->load->view('layout/menu', $data, true);
		$data['extra_css']		            = $this->load->view('program_apbd/program_apbd/css',$data,true);
		$data['extra_js']		            = $this->load->view('program_apbd/program_apbd/js',$data,true);
        $data['modal']                      = $this->load->view('program_apbd/program_apbd/modal', $data, true);
		$this->template->load('backend_template',$page,$data);
	}

	public function dt_program_apbd()
	{
		if(!$this->input->is_ajax_request())
        {
            show_404();
        }else{
        	$where 			= ['id_instansi' => id_instansi(), 'kode_tahap' => tahapan_apbd()];
        	$column_order   = ['kode_rekening_program','nama_program','belanja_pegawai','belanja_barang_jasa','belanja_modal','pagu'];
            $column_search  = ['kode_rekening_program','nama_program'];
            $order          = ['kode_rekening_program' => 'ASC'];
            $list           = $this->datatables_model->get_datatables('v_program_apbd',$column_order,$column_search,$order,$where);
            $data           = [];
            $no             = $_POST['start'];
            foreach ($list as $lists)
            {
                $row    = [];
                $row[]  = $lists->kode_rekening_program;
                $row[]  = $lists->nama_program;
                $row[]  = '<span style="float:right">'.number_format($lists->belanja_pegawai,0,'','.').'</span>';
                $row[]  = '<span style="float:right">'.number_format($lists->belanja_barang_jasa,0,'','.').'</span>';
                $row[]  = '<span style="float:right">'.number_format($lists->belanja_modal,0,'','.').'</span>';
                $row[]  = '<span style="float:right">'.number_format($lists->pagu,0,'','.').'</span>';

                $data[] = $row;
            }

            $output = [
                        "draw"              => $_POST['draw'],
                        "recordsTotal"      => $this->datatables_model->count_all('v_program_apbd',$where),
                        "recordsFiltered"   => $this->datatables_model->count_filtered('v_program_apbd',$column_order,$column_search,$order,$where),
                        "data"              => $data,
                      ];

            echo json_encode($output);
        }
	}



    public function export_program()
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
                $mprogram             = $loadexcel->setActiveSheetIndex(1)->toArray(true, true, true ,true);
                $mkegiatan             = $loadexcel->setActiveSheetIndex(2)->toArray(true, true, true ,true);
                $msubkegiatan             = $loadexcel->setActiveSheetIndex(3)->toArray(true, true, true ,true);

                $data_program = array();
                $data_kegiatan = array();
                $data_sub_kegiatan = array();

                $no_program = 1;
                $no_kegiatan = 1;
                $no_sub_kegiatan = 1;
                foreach($sheet as $row){
                            if($numrow > 1){
                                array_push($data, array(
                                    // 'nama_dosen' => $row['A'],
                                    'judul'      => $row['B'],
                                    'keterangan'      => $row['C'],
                                ));
                                    }
                                $numrow++;
                            }
               
            $this->db->insert_batch('monitoring_skpd', $data);
            // $this->db->insert_batch('tes_cronjob', $data2);



                  
                $upload = ['upload_data' => $this->upload->data()];
                $file_ext = pathinfo($_FILES["upload_file"]["name"], PATHINFO_EXTENSION);
                $output['status']   = true;
            }
            // $output['cek'] = $list_directory;
            // echo json_encode($output);
            $this->session->set_flashdata('pesan', '<div class="alert alert-info">Program berhail di export</div>');
            // redirect('program_apbd');
        }
    }

    public function download_format_excel_program()
    {
        if (!$this->input->is_ajax_request()) {
            show_404();
        } else {
            $output = [
                'status' => false,
                'data'   => []
            ];
            $isi = null;
            $letak = '/sbe_files_support/export_excel_format/tes.xlsx';
            $download = force_download($letak, $isi);
            if ($download) {
               $output['status'] = true;
               $output['message'] = "Sukses";
            }else{
                $output['status'] = false;
                $output['message'] = "Gagal";
                $output['cek'] = $download;
            }
            echo json_encode($output);
        }
    }
}