<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class Menu_model extends CI_Model
{
	public function flatten($table,$where,$key,$value,$order,$order_by)
	{
		$this->db->where($where);
		$this->db->where_in($key, $value);
		$this->db->order_by($order, $order_by);
		return $this->db->get($table);
	}
}