<?php
/**
 * Author     : Alfikri, M.Kom
 * Created By : Alfikri, M.Kom
 * E-Mail     : alfikri.name@gmail.com
 * No HP      : 081277337405
 * Class      : Master_menu_model.php
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Master_menu_model extends CI_Model
{
	protected $table_master_category_menu = 'master_category_menu';
	protected $table_master_group 		  = 'master_group';
	protected $table_menu 				  = 'menu';
	protected $table_menu_groups 		  = 'menu_groups';
	protected $view_menu 				  = 'v_menu';

	public $id_category_menu;
	public $order_number;
	public $menu_name;
	public $icon;
	public $link;
	public $is_active;
	public $is_parent;

	public function rules_save()
	{
		return [
			[
				'field' => 'idCategoryMenu',
			 	'label' => 'Category Menu',
			 	'rules' => 'required'
			],
			[
				'field' => 'orderNumber',
			 	'label' => 'Order Number',
			 	'rules' => 'required|is_natural_no_zero'
			],
			[
				'field' => 'menuName',
				'label' => 'Menu Name',
				'rules' => 'required|is_unique[menu.menu_name]'
			],
			[
				'field' => 'icon',
				'label' => 'Icon',
				'rules' => 'required'	
			],
			[
				'field' => 'link',
				'label' => 'Link',
				'rules' => 'required'
			]
		];
	}

	public function rules_update()
	{
		return [
			[
				'field' => 'idCategoryMenu',
			 	'label' => 'Category Menu',
			 	'rules' => 'required'
			],
			[
				'field' => 'orderNumber',
			 	'label' => 'Order Number',
			 	'rules' => 'required|is_natural_no_zero'
			],
			[
				'field' => 'menuName',
				'label' => 'Menu Name',
				'rules' => 'required|trim'
			],
			[
				'field' => 'icon',
				'label' => 'Icon',
				'rules' => 'required'	
			],
			[
				'field' => 'link',
				'label' => 'Link',
				'rules' => 'required'
			]
		];
	}

	public function get_master_category_menu()
	{
		return $this->db->get_where($this->table_master_category_menu,['is_active'=>1]);
	}

	public function get_master_group()
	{
		$this->db->order_by('id_group','ASC');
		return $this->db->get($this->table_master_group);
	}

	public function get_order_number()
    {
    	$id_category_menu = $this->input->get('idCategoryMenu');
        $q    = $this->db->query("SELECT MAX(order_number) AS kode FROM {$this->view_menu} WHERE id_category_menu = {$id_category_menu}");
        $kode = "";
        if($q->num_rows()>0){
            foreach($q->result() as $k){
                $tmp    = ((int) $k->kode)+1;
                $kode   = $tmp;
            }
        }else{
            $kode = "1";
        }
        return $kode;
    }

    public function save_master_menu()
    {
        $post 						= $this->input->post();
        $this->id_category_menu 	= $post['idCategoryMenu'];
        $this->order_number 		= $post['orderNumber'];
        $this->menu_name 			= $post['menuName'];
        $this->icon 				= $post['icon'];
        $this->link 				= $post['link'];
        $this->is_active 			= $post['isActive'];
        $this->is_parent 			= $post['isParent'];
        $this->db->insert($this->table_menu,$this);

        return $this->db->insert_id();
    }

    public function update_master_menu()
    {
        $post 						= $this->input->post();
        $this->id_category_menu 	= $post['idCategoryMenu'];
        $this->order_number 		= $post['orderNumber'];
        $this->menu_name 			= $post['menuName'];
        $this->icon 				= $post['icon'];
        $this->link 				= $post['link'];
        $this->is_active 			= $post['isActive'];
        $this->is_parent 			= $post['isParent'];
        $this->db->update($this->table_menu,$this,['id_menu'=>$post['idMenu']]);

        return $post['idMenu'];
    }

    public function delete_master_menu()
    {
        $id_menu = $this->input->post('idMenu');
        if(!empty($id_menu)):
            $this->db->where(['id_menu'=>$id_menu]);
            $this->db->delete($this->table_menu);
            return $this->db->affected_rows();
        else:
            show404();
        endif;
    }

    public function delete_menu_groups($where)
    {
        $this->db->where($where);
        $this->db->delete($this->table_menu_groups);
        return $this->db->affected_rows();
    }

    public function save_menu_groups($data)
    {
        $this->db->insert_batch($this->table_menu_groups,$data);
    }

    public function get_by_id($table,$data)
    {
    	return $this->db->get_where($table,$data);
    }
}