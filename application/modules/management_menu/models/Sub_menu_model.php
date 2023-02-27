<?php
/**
 * Author     : Alfikri, M.Kom
 * Created By : Alfikri, M.Kom
 * E-Mail     : alfikri.name@gmail.com
 * No HP      : 081277337405
 * Class      : Sub_menu_model.php
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Sub_menu_model extends CI_Model
{
	protected $table_menu 			 = 'menu';
	protected $table_master_group 	 = 'master_group';
	protected $table_sub_menu 		 = 'sub_menu';
	protected $table_sub_menu_groups = 'sub_menu_groups';
	protected $view_sub_menu		 = 'v_sub_menu';

	public $id_menu;
	public $order_number;
	public $sub_menu_name;
	public $link;
	public $title;
	public $is_active;

	public function rules_save()
	{
		return [
			[
				'field' => 'idMenu',
			 	'label' => 'Menu',
			 	'rules' => 'required'
			],
			[
				'field' => 'orderNumber',
			 	'label' => 'Order Number',
			 	'rules' => 'required|is_natural_no_zero'
			],
			[
				'field' => 'subMenuName',
				'label' => 'Sub Menu Name',
				'rules' => 'required|is_unique[sub_menu.sub_menu_name]'
			],
			[
				'field' => 'link',
				'label' => 'Link',
				'rules' => 'required|trim'
			],
			[
				'field' => 'title',
				'label' => 'Title',
				'rules' => 'required|trim'
			]
		];
	}

	public function rules_update()
	{
		return [
			[
				'field' => 'idMenu',
			 	'label' => 'Menu',
			 	'rules' => 'required'
			],
			[
				'field' => 'orderNumber',
			 	'label' => 'Order Number',
			 	'rules' => 'required|is_natural_no_zero'
			],
			[
				'field' => 'subMenuName',
				'label' => 'Sub Menu Name',
				'rules' => 'required|trim'
			],
			[
				'field' => 'link',
				'label' => 'Link',
				'rules' => 'required|trim'
			],
			[
				'field' => 'title',
				'label' => 'Title',
				'rules' => 'required|trim'
			]
		];
	}

	public function get_master_menu()
	{
		return $this->db->get_where($this->table_menu,['is_parent' => 1,'is_active' => 1]);
	}

	public function get_master_group()
	{
		$this->db->order_by('id_group','ASC');
		return $this->db->get($this->table_master_group);
	}

	public function get_order_number()
    {
    	$id_menu 	= $this->input->get('idMenu');
        $q    		= $this->db->query("SELECT MAX(order_number) AS kode FROM {$this->view_sub_menu} WHERE id_menu = {$id_menu}");
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

    public function save_sub_menu()
    {
        $post 					= $this->input->post();
        $this->id_menu 			= $post['idMenu'];
        $this->order_number 	= $post['orderNumber'];
        $this->sub_menu_name	= $post['subMenuName'];
        $this->link 			= $post['link'];
        $this->title 			= $post['title'];
        $this->is_active 			= $post['isActive'];
        $this->db->insert($this->table_sub_menu,$this);

        return $this->db->insert_id();
    }

    public function update_sub_menu()
    {
        $post 						= $this->input->post();
        $this->id_menu 			= $post['idMenu'];
        $this->order_number 	= $post['orderNumber'];
        $this->sub_menu_name	= $post['subMenuName'];
        $this->link 			= $post['link'];
        $this->title 			= $post['title'];
        $this->is_active 			= $post['isActive'];
        $this->db->update($this->table_sub_menu,$this,['id_sub_menu'=>$post['idSubMenu']]);

        return $post['idSubMenu'];
    }

    public function delete_sub_menu()
    {
        $id_sub_menu = $this->input->post('idSubMenu');
        if(!empty($id_sub_menu)):
            $this->db->where(['id_sub_menu'=>$id_sub_menu]);
            $this->db->delete($this->table_sub_menu);
            return $this->db->affected_rows();
        else:
            show_404();
        endif;
    }

    public function delete_sub_menu_groups($where)
    {
        $this->db->where($where);
        $this->db->delete($this->table_sub_menu_groups);
        return $this->db->affected_rows();
    }

    public function save_sub_menu_groups($data)
    {
        $this->db->insert_batch($this->table_sub_menu_groups,$data);
    }

    public function get_by_id($table,$data)
    {
    	return $this->db->get_where($table,$data);
    }
}