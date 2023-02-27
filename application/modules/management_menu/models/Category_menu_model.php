<?php
/**
 * Author     : Alfikri, M.Kom
 * Created By : Alfikri, M.Kom
 * E-Mail     : alfikri.name@gmail.com
 * No HP      : 081277337405
 * Class      : Category_menu_model.php
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Category_menu_model extends CI_Model
{
    protected $table_category_menu        = "master_category_menu";
    protected $table_category_menu_groups = "category_menu_groups";

    public $order_number;
    public $category_name;
    public $category_description;
    public $is_active;

    public function rules_save()
    {
        return [
            ['field' => 'orderNumber',
             'label' => 'Order Number',
             'rules' => 'required|is_natural_no_zero|is_unique[master_category_menu.order_number]'
            ],
            ['field' => 'categoryName',
             'label' => 'Category Name',
             'rules' => 'required|trim|is_unique[master_category_menu.category_name]'
            ],
            ['field' => 'categoryDescription',
             'label' => 'Category Description',
             'rules' => 'required|trim|is_unique[master_category_menu.category_description]'
            ]
        ];
    }

    public function rules_update()
    {
        return [
            ['field' => 'orderNumber',
             'label' => 'Order Number',
             'rules' => 'required|is_natural_no_zero'
            ],
            ['field' => 'categoryName',
             'label' => 'Category Name',
             'rules' => 'required|trim'
            ],
            ['field' => 'categoryDescription',
             'label' => 'Category Description',
             'rules' => 'required|trim'
            ]
        ];
    }

    public function auto_order_number()
    {
        $q    = $this->db->query("SELECT MAX(order_number) AS kode FROM {$this->table_category_menu}");
        $kode = "";
        if($q->num_rows()>0){
            foreach($q->result() as $k){
                $tmp    = ((int)$k->kode)+1;
                $kode   = $tmp;
            }
        }else{
            $kode = "1";
        }
        return $kode;
    }

    public function save_category_menu()
    {
        $post = $this->input->post();
        $this->order_number         = $post['orderNumber'];
        $this->category_name        = $post['categoryName'];
        $this->category_description = $post['categoryDescription'];
        $this->is_active            = $post['isActive'];
        $this->db->insert($this->table_category_menu,$this);

        return $this->db->insert_id();
    }

    public function update_category_menu()
    {
        $post = $this->input->post();
        $this->order_number         = $post['orderNumber'];
        $this->category_name        = $post['categoryName'];
        $this->category_description = $post['categoryDescription'];
        $this->is_active            = $post['isActive'];
        $this->db->update($this->table_category_menu,$this,['id_category_menu'=>$post['idCategoryMenu']]);

        return $post['idCategoryMenu'];
    }

    public function delete_category_menu()
    {
        $id_category_menu = $this->input->post('idCategoryMenu');
        if(!empty($id_category_menu)):
            $this->db->where(['id_category_menu'=>$id_category_menu]);
            $this->db->delete($this->table_category_menu);
            return $this->db->affected_rows();
        else:
            show404();
        endif;
    }

    public function delete_category_menu_groups($where)
    {
        $this->db->where($where);
        $this->db->delete($this->table_category_menu_groups);
        return $this->db->affected_rows();
    }

    public function save_category_menu_groups($data)
    {
        $this->db->insert_batch($this->table_category_menu_groups,$data);
    }

    public function get_by_id($table,$data)
    {
    	return $this->db->get_where($table,$data);
    }

    public function update($table,$data,$where)
    {
        $this->db->update($table, $data, $where);
        return $this->db->affected_rows();
    }

    public function delete($table,$data)
    {
        $this->db->where($data);
        $this->db->delete($table);
        return $this->db->affected_rows();
    }

    public function get($table,$data)
    {
        $this->db->where($data);
        return $this->db->get($table);
    }

    public function query($query)
    {
        return $this->db->query($query);
    }

    public function get_all($table,$order,$orderby){
        $this->db->order_by($order,$orderby);
        return $this->db->get($table);
    }
}