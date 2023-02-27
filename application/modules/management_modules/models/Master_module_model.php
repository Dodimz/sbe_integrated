<?php
/**
 * Author     : Alfikri, M.Kom
 * Created By : Alfikri, M.Kom
 * E-Mail     : alfikri.name@gmail.com
 * No HP      : 081277337405
 * Class      : Master_module_model.php
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Master_module_model extends CI_Model
{
	protected $table_master_module	 		= 'master_modules';
	protected $table_master_group 	 		= 'master_group';
	protected $table_master_module_groups 	= 'modules_groups';

	public $module_name;
	public $module_description;
	public $created_on;
	public $updated_on;
	public $created_by;
	public $is_active;
	public $readonly;

	public function rules_save()
	{
		return [
			[
				'field' => 'moduleName',
			 	'label' => 'Module Name',
			 	'rules' => 'required|trim|is_unique[master_modules.module_name]'
			],
			[
				'field' => 'moduleDescription',
			 	'label' => 'Module Description',
			 	'rules' => 'required|trim'
			]
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

	public function get_master_group()
	{
		$this->db->order_by('id_group','ASC');
		return $this->db->get($this->table_master_group);
	}

    public function save_master_module()
    {
		$post 						= $this->input->post();
        $this->module_name			= $post['moduleName'];
		$this->module_description 	= $post['moduleDescription'];
		$this->created_on 			= time();
		$this->updated_on 			= time();
		$this->created_by 			= id_user();
		$this->updated_by 			= id_user();
		$this->is_active 			= $post['isActive'];
		$this->readonly 			= 1;
        $this->db->insert($this->table_master_module,$this);

        return $this->db->insert_id();
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

    public function delete_master_modules_groups($where)
    {
        $this->db->where($where);
        $this->db->delete($this->table_master_module_groups);
        return $this->db->affected_rows();
    }

    public function save_master_modules_groups($data)
    {
        $this->db->insert_batch($this->table_master_module_groups,$data);
    }

    public function get_by_id($table,$data)
    {
    	return $this->db->get_where($table,$data);
    }
}