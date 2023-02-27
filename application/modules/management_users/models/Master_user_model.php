<?php
/**
 * Author     : Alfikri, M.Kom
 * Created By : Alfikri, M.Kom
 * E-Mail     : alfikri.name@gmail.com
 * No HP      : 081277337405
 * Class      : Master_user_model.php
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Master_user_model extends CI_Model
{
	protected $table_master_instansi	 	= 'master_instansi';
	protected $table_master_user	 		= 'master_users';
	protected $table_master_group 	 		= 'master_group';
	protected $table_master_user_groups 	= 'users_groups';

	public function rules_save()
	{
		return [
			[
				'field' => 'idInstansi',
			 	'label' => 'ID Instansi',
			 	'rules' => 'required'
			],
			// [
			// 	'field' => 'idParent',
			//  	'label' => 'ID Parent',
			//  	'rules' => 'required'
			// ],
			[
				'field' => 'fullName',
			 	'label' => 'Full Name',
			 	'rules' => 'required'
			],
			[
				'field' => 'username',
			 	'label' => 'Username',
			 	'rules' => 'required|trim|is_unique[master_users.username]'
			],
			// [
			// 	'field' => 'email',
			//  	'label' => 'E-mail',
			//  	'rules' => 'required|trim|is_unique[master_users.email]|valid_email'
			// ],
			[
				'field' => 'password',
			 	'label' => 'Password',
			 	'rules' => 'required'
			],
			[
				'field' => 'passwordConfirm',
			 	'label' => 'Password Confirmation',
			 	'rules' => 'required|trim|matches[password]'
			],

			[
				'field' => 'group',
			 	'label' => 'Gruop',
			 	'rules' => 'required'
			],
			[
				'field' => 'isActive',
			 	'label' => 'Is Active',
			 	'rules' => 'required'
			],
		];
	}
	public function rules_save_user_kab_kota()
	{
		return [
			[
				'field' => 'id_kota',
			 	'label' => 'Kab / Kota',
			 	'rules' => 'required'
			],
			// [
			// 	'field' => 'idParent',
			//  	'label' => 'ID Parent',
			//  	'rules' => 'required'
			// ],
			[
				'field' => 'fullName',
			 	'label' => 'Full Name',
			 	'rules' => 'required'
			],
			[
				'field' => 'username',
			 	'label' => 'Username',
			 	'rules' => 'required|trim|is_unique[master_users.username]'
			],
			
			[
				'field' => 'password',
			 	'label' => 'Password',
			 	'rules' => 'required'
			],
			[
				'field' => 'passwordConfirm',
			 	'label' => 'Password Confirmation',
			 	'rules' => 'required|trim|matches[password]'
			],

			[
				'field' => 'group',
			 	'label' => 'Gruop',
			 	'rules' => 'required'
			],
			[
				'field' => 'isActive',
			 	'label' => 'Is Active',
			 	'rules' => 'required'
			],
		];
	}

	public function rules_saveedit()
	{
		return [
			[
				'field' => 'idInstansi',
			 	'label' => 'ID Instansi',
			 	'rules' => 'required'
			],
			// [
			// 	'field' => 'idParent',
			//  	'label' => 'ID Parent',
			//  	'rules' => 'required'
			// ],
			[
				'field' => 'fullName',
			 	'label' => 'Full Name',
			 	'rules' => 'required'
			],
			// [
			// 	'field' => 'username',
			//  	'label' => 'Username',
			//  	'rules' => 'required|trim|is_unique[master_users.username]'
			// ],
			// [
			// 	'field' => 'email',
			//  	'label' => 'E-mail',
			//  	'rules' => 'required|trim|is_unique[master_users.email]|valid_email'
			// ],
			// [
			// 	'field' => 'password',
			//  	'label' => 'Password',
			//  	'rules' => 'required'
			// ],
			// [
			// 	'field' => 'passwordConfirm',
			//  	'label' => 'Password Confirmation',
			//  	'rules' => 'required|trim|matches[password]'
			// ],

			[
				'field' => 'group',
			 	'label' => 'Gruop',
			 	'rules' => 'required'
			],
			[
				'field' => 'isActive',
			 	'label' => 'Is Active',
			 	'rules' => 'required'
			],
		];
	}

	public function rules_update()
	{
		return [
			[
				'field' => 'moduleName',
			 	'label' => 'Module Name',
			 	'rules' => 'required|trim'
			],
			[
				'field' => 'moduleDescription',
			 	'label' => 'Module Description',
			 	'rules' => 'required|trim'
			]
		];
	}

	public function get_master_instansi()
	{
		$this->db->order_by('nama_instansi','ASC');
		return $this->db->get_where($this->table_master_instansi, ['kategori'=>'OPD']);
	}

	public function get_master_group($where = '')
	{
		if($where)
		{
			$this->db->where($where);
			$this->db->order_by('id_group','ASC');
			$result = $this->db->get($this->table_master_group);
		}else{
			$this->db->order_by('id_group','ASC');
			$result = $this->db->get($this->table_master_group);
		}
		return $result;
	}

	public function get_user_group($select, $where)
	{
		$this->db->select($select);
		$result  = $this->db->get_where($this->table_master_user_groups)->row()->id_group;
		$results = $this->get_master_group(['id_group >'=>$result]);
		return $results;
	}

	public function get_master_user()
	{
		$this->db->select(['id_user','full_name']);
		$this->db->order_by('full_name','ASC');
		return $this->db->get($this->table_master_user);
	}

    public function save_master_user()
    {
		$post 						= $this->input->post();
		$data = [
			
				 'id_instansi'		=> decrypt($post['idInstansi']),
				 'full_name' 		=> $post['fullName'],
				 'nohp' 		=> $post['nohp'],
				 'username'			=> $post['username'],
				 'email'			=> $post['email'],
				 'password' 		=> password_hash($post['password'], PASSWORD_DEFAULT),
				 'is_active'		=> $post['isActive'],
				 'created_on'		=> timestamp(),
				
				 'created_by' 		=> id_user()
				];
        $this->db->insert($this->table_master_user,$data);

        return $this->db->insert_id();
    }
    public function save_master_user_kab_kota()
    {
		$post 						= $this->input->post();
		$data = [
			
				 'id_provinsi' 		=> 13,
				 'id_kota'		=> decrypt($post['id_kota']),
				 'full_name' 		=> $post['fullName'],
				 'nohp' 		=> $post['nohp'],
				 'username'			=> $post['username'],
				 'email'			=> $post['email'],
				 'password' 		=> password_hash($post['password'], PASSWORD_DEFAULT),
				 'is_active'		=> $post['isActive'],
				 'created_on'		=> timestamp(),
				
				 'created_by' 		=> id_user()
				];
        $this->db->insert($this->table_master_user,$data);

        return $this->db->insert_id();
    }
    public function saveedit_master_user()
    {
		$post 						= $this->input->post();
		$data = [
			
				 'id_instansi'		=> decrypt($post['idInstansi']),
				 'nohp' 		=> $post['nohp'],
				 'username'			=> $post['username'],
				 'email'			=> $post['email'],
				 'password' 		=> password_hash($post['password'], PASSWORD_DEFAULT),
				 'is_active'		=> $post['isActive'],
				
				 'updated_on'		=> timestamp(),
				 'updated_by' 		=> id_user()
				];

		$where = [
			'id_user'=>$post['idUser']
		];
        $this->db->update($this->table_master_user,$data, $where );

        return $this->db->insert_id();
    }
    public function saveedit_master_user_no_password()
    {
		$post 						= $this->input->post();
		$data = [
			
				 'id_instansi'		=> decrypt($post['idInstansi']),
				 'full_name' 		=> $post['fullName'],
				 'nohp' 		=> $post['nohp'],
				 'username'			=> $post['username'],
				 'email'			=> $post['email'],
				 'is_active'		=> $post['isActive'],
				
				 'updated_on'		=> timestamp(),
				 'updated_by' 		=> id_user()
				];

		$where = [
			'id_user'=>$post['idUser']
		];
        $this->db->update($this->table_master_user,$data, $where );

        // return $this->db->insert_id();
    }

    public function update_master_module()
    {
        $post 							= $this->input->post();
		$data = ['module_name' 			=> $post['moduleName'],
				 'module_description' 	=> $post['moduleDescription'],
				 'updated_on' 			=> time(),
				 'updated_by' 			=> id_user(),
				 'is_active' 			=> $post['isActive'],
				 'readonly' 			=> $post['readonly']
				];

        $this->db->update($this->table_master_module,$data,['id_module'=>decrypt($post['idModule'])]);

        return decrypt($post['idModule']);
    }

    public function delete_master_module()
    {
        $id_module = decrypt($this->input->post('idModule'));
		if(!empty($id_module)):
			$check_readonly = $this->db->get_where($this->table_master_module,['id_module' => $id_module])->row()->readonly;
			if($check_readonly == 1)
			{
				return false;
			}else{
				$module_name = $this->db->get_where($this->table_master_module,['id_module' => $id_module])->row()->module_name;
				delete_directory($module_name);
				$this->db->where(['id_module'=>$id_module]);
				$this->db->delete($this->table_master_module);
            	return true;
			}
        else:
            show_404();
        endif;
    }

    public function delete_master_user_groups($where)
    {
        $this->db->where($where);
        $this->db->delete($this->table_master_user_groups);
        return $this->db->affected_rows();
    }

    public function save_master_user_groups($data)
    {
        $this->db->insert($this->table_master_user_groups,$data);
    }

    public function get_by_id($table,$data,$select = [])
    {
		$this->db->select($select);
    	return $this->db->get_where($table,$data);
    }
}