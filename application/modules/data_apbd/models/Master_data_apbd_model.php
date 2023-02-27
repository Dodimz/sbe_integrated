<?php
/**
 * Author     : Alfikri, M.Kom
 * Created By : Alfikri, M.Kom
 * E-Mail     : alfikri.name@gmail.com
 * No HP      : 081277337405
 * Class      : Master_user_model.php
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Master_data_apbd_model extends CI_Model
{
	protected $table_master_instansi	 	= 'master_instansi';
	protected $table_master_user	 		= 'master_users';
	protected $table_master_group 	 		= 'master_group';
	protected $table_master_user_groups 	= 'users_groups';

	public function rules_save()
	{
		return [
			[
				'field' => 'kode',
			 	'label' => 'Kode ',
			 	'rules' => 'required'
			],
			[
				'field' => 'nama',
			 	'label' => 'Nama',
			 	'rules' => 'required'
			]
		];
	}

	

    public function save_master_program()
    {
		$post 						= $this->input->post();
		$kode = trim(str_replace(' ', '', $post['kode']));
		$pecah = explode('.', $kode);
		$kode_program = $pecah[0].'.'.$pecah[1].'.'.$pecah[2];
		$kode_bu = $pecah[0].'.'.$pecah[1];
		$kd_program = $pecah[2];
		$id_instansi = id_instansi();
		$id_group = $this->session->userdata('id_group');
		$data = [
				 'kode_bidang_urusan'			=> $kode_bu,
				 'kd_program'			=> $kd_program,
				 'kode_program'			=> $kode_program,
				 'nama_program'			=> $post['nama'],
				 'tahun'			=> tahun_anggaran(),
				 'id_group_pengusul' => $id_group,
				 'id_user_pengusul' => id_user(),
				 'id_instansi_pengusul' =>$id_instansi,
				 'created_on'			=> timestamp(),
				 'created_by'			=> id_user(),
				 'input_by'			=> "Manual Input",
				 'status' =>1
				
				];
        $this->db->insert("master_program",$data);

    }
    public function saveedit_master_program()
    {
		$post 						= $this->input->post();
		$kode = $post['kode'];
		$id = $post['id'];
		$pecah = explode('.', $kode);
		$kode_program = $pecah[0].'.'.$pecah[1].'.'.$pecah[2];
		$kode_bu = $pecah[0].'.'.$pecah[1];
		$kd_program = $pecah[2];
		$id_instansi = id_instansi();
		$id_group = $this->session->userdata('id_group');
		$data = [
				 'kode_bidang_urusan'			=> $kode_bu,
				 'kd_program'			=> $kd_program,
				 'kode_program'			=> $kode_program,
				 'nama_program'			=> $post['nama'],
				 'tahun'			=> tahun_anggaran(),
				 'id_group_pengusul' => $id_group,
				 'id_user_pengusul' => id_user(),
				 'id_instansi_pengusul' =>$id_instansi,
				 'created_on'			=> timestamp(),
				 'created_by'			=> id_user(),
				 'input_by'			=> "Manual Input",
				 'status' =>1
				
				];
		$where = ['id_program'=>$id];
        $this->db->update("master_program",$data, $where);

    }






    public function save_master_kegiatan()
    {
		$post 						= $this->input->post();
		$kode = $post['kode'];
		$pecah = explode('.', $kode);
		$kode_kegiatan = $pecah[0].'.'.$pecah[1].'.'.$pecah[2].'.'.$pecah[3].'.'.$pecah[4];
		$kode_bu = $pecah[0].'.'.$pecah[1];
		$kd_kegiatan = $pecah[3].'.'.$pecah[4];
		$kode_program = $pecah[0].'.'.$pecah[1].'.'.$pecah[2];
		$kd_program = $pecah[2];
		$id_instansi = id_instansi();
		$id_group = $this->session->userdata('id_group');
		$data = [
				 'kode_bidang_urusan'			=> $kode_bu,
				 'kd_kegiatan'			=> $kd_kegiatan,
				 'kode_kegiatan'			=> $kode_kegiatan,
				 'kd_program'			=> $kd_program,
				 'kode_program'			=> $kode_program ,
				 'nama_kegiatan'			=> $post['nama'],
				 'tahun'			=> tahun_anggaran(),

				 'id_group_pengusul' => $id_group,
				 'id_user_pengusul' => id_user(),
				 'id_instansi_pengusul' =>$id_instansi,
				 'created_on'			=> timestamp(),
				 'created_by'			=> id_user(),
				 'input_by'			=> "Manual Input",

				 'status' =>1
				
				];
        $this->db->insert("master_kegiatan",$data);

    }
    public function saveedit_master_kegiatan()
    {
		$post 						= $this->input->post();
		$kode = $post['kode'];
		$id = $post['id'];
		$pecah = explode('.', $kode);
		$kode_kegiatan = $pecah[0].'.'.$pecah[1].'.'.$pecah[2].'.'.$pecah[3].'.'.$pecah[4];
		$kode_bu = $pecah[0].'.'.$pecah[1];
		$kd_kegiatan = $pecah[3].'.'.$pecah[4];
		$kode_program = $pecah[0].'.'.$pecah[1].'.'.$pecah[2];
		$kd_program = $pecah[2];
		$id_instansi = id_instansi();
		$id_group = $this->session->userdata('id_group');
		$data = [
				 'kode_bidang_urusan'			=> $kode_bu,
				 'kd_kegiatan'			=> $kd_kegiatan,
				 'kode_kegiatan'			=> $kode_kegiatan,
				 'kd_program'			=> $kd_program,
				 'kode_program'			=> $kode_program ,
				 'nama_kegiatan'			=> $post['nama'],
				 'tahun'			=> tahun_anggaran(),

				 'id_group_pengusul' => $id_group,
				 'id_user_pengusul' => id_user(),
				 'id_instansi_pengusul' =>$id_instansi,
				 'created_on'			=> timestamp(),
				 'created_by'			=> id_user(),
				 'input_by'			=> "Manual Input",
				 
				 'status' =>1
				
				];
		$where = ['id_kegiatan'=>$id];
        $this->db->update("master_kegiatan",$data, $where);

    }



    public function save_master_sub_kegiatan()
    {
		$post 			= $this->input->post();
		$kode = $post['kode'];
		$pecah = explode('.', $kode);
		$kode_sub_kegiatan = $pecah[0].'.'.$pecah[1].'.'.$pecah[2].'.'.$pecah[3].'.'.$pecah[4].'.'.$pecah[5];
		$kode_kegiatan = $pecah[0].'.'.$pecah[1].'.'.$pecah[2].'.'.$pecah[3].'.'.$pecah[4];
		$kode_program = $pecah[0].'.'.$pecah[1].'.'.$pecah[2];

		$kd_sub_kegiatan = $pecah[5];
		$kd_kegiatan = $pecah[3].'.'.$pecah[4];
		$kd_program = $pecah[2];
		$kode_bu = $pecah[0].'.'.$pecah[1];

		$kd_program = $pecah[2];
		$id_instansi = id_instansi();
		$id_group = $this->session->userdata('id_group');
		

		$data = [
				 'kode_bidang_urusan'			=> $kode_bu,
				 'kd_sub_kegiatan'			=> $kd_sub_kegiatan,
				 'kode_sub_kegiatan'			=> $kode_sub_kegiatan,
				 'kd_program'			=> $kd_program,
				 'kode_program'			=> $kode_program ,
				 'kd_kegiatan'			=> $kd_kegiatan,
				 'kode_kegiatan'			=> $kode_kegiatan ,
				 'nama_sub_kegiatan'			=> $post['nama'],
				 'tahun'			=> tahun_anggaran(),
				 'id_group_pengusul' => $id_group,
				'id_user_pengusul' => id_user(),
				'id_instansi_pengusul' =>$id_instansi,
				 'created_on'			=> timestamp(),
				 'created_by'			=> id_user(),
				 'input_by'			=> "Manual Input",
				'status' =>1
				];
        $this->db->insert("master_sub_kegiatan",$data);


        $data_ski = [
			'kode_bidang_urusan'			=> $kode_bu,
			'kode_sub_kegiatan'			=> $kode_sub_kegiatan,
			'kode_program'			=> $kode_program ,
			'kode_kegiatan'			=> $kode_kegiatan ,
			'id_instansi' => id_instansi() , 
			'kode_tahap' => tahapan_apbd() , 
			'kategori' => 'Sub Kegiatan SKPD' , 
			'tahun' => tahun_anggaran() , 
			'created_on' => timestamp() ,
			'created_by' => id_user() , 
			'input_by' => 'Manual Input' , 
			'status' => '1' , 
		];
        $this->db->insert("sub_kegiatan_instansi",$data_ski);

    }
    public function saveedit_master_sub_kegiatan()
    {
		$post 						= $this->input->post();
		$kode = $post['kode'];
		$id = $post['id'];
		$pecah = explode('.', $kode);
		$kode_sub_kegiatan = $pecah[0].'.'.$pecah[1].'.'.$pecah[2].'.'.$pecah[3].'.'.$pecah[4].'.'.$pecah[5];
		$kode_kegiatan = $pecah[0].'.'.$pecah[1].'.'.$pecah[2].'.'.$pecah[3].'.'.$pecah[4];
		$kode_program = $pecah[0].'.'.$pecah[1].'.'.$pecah[2];

		$kd_sub_kegiatan = $pecah[5];
		$kd_kegiatan = $pecah[3].'.'.$pecah[4];
		$kd_program = $pecah[2];
		$kode_bu = $pecah[0].'.'.$pecah[1];
		$id_instansi = id_instansi();
		$id_group = $this->session->userdata('id_group');
		

		$data = [
				 'kode_bidang_urusan'			=> $kode_bu,
				 'kd_sub_kegiatan'			=> $kd_sub_kegiatan,
				 'kode_sub_kegiatan'			=> $kode_sub_kegiatan,
				 'kd_program'			=> $kd_program,
				 'kode_program'			=> $kode_program ,
				 'kd_kegiatan'			=> $kd_kegiatan,
				 'kode_kegiatan'			=> $kode_kegiatan ,
				 'nama_sub_kegiatan'			=> $post['nama'],
				 'tahun'			=> tahun_anggaran(),
				 'id_group_pengusul' => $id_group,
				'id_user_pengusul' => id_user(),
				'id_instansi_pengusul' =>$id_instansi,
				 'created_on'			=> timestamp(),
				 'created_by'			=> id_user(),
				 'input_by'			=> "Manual Input",
				'status' =>1
				];
		$where = ['id_sub_kegiatan'=>$id];
        $this->db->update("master_sub_kegiatan",$data, $where);

    }















    public function save_master_bidang_urusan()
    {
		$post 						= $this->input->post();
		$kode = $post['kode'];
		$pecah = explode('.', $kode);
		$kode_bu = $pecah[0].'.'.$pecah[1];
		
		

		$data = [
				 'kode_bidang_urusan'			=> $kode_bu,
				

				 'nama_bidang_urusan'			=> $post['nama'],
				 'tahun'			=> tahun_anggaran(),
				 'created_on'			=> timestamp(),
				 'created_by'			=> id_user(),
				 'input_by'			=> "Manual Input",
				
				];
        $this->db->insert("master_bidang_urusan",$data);

    }
    public function saveedit_master_bidang_urusan()
    {
		$post 						= $this->input->post();
		$kode = $post['kode'];
		$id = $post['id'];
			$pecah = explode('.', $kode);
		$kode_bu = $pecah[0].'.'.$pecah[1];
		
		

		$data = [
				 'kode_bidang_urusan'			=> $kode_bu,
				

				 'nama_bidang_urusan'			=> $post['nama'],
				 'tahun'			=> tahun_anggaran(),
				 'created_on'			=> timestamp(),
				 'created_by'			=> id_user(),
				 'input_by'			=> "Manual Input",
				
				];
		$where = ['id_bidang_urusan'=>$id];
        $this->db->update("master_bidang_urusan",$data, $where);

    }


}