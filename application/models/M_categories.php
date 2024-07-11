<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class M_categories extends CI_Model
{

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }


    function get_list_data_categories()
    {
        $query = $this->db->get('data_categories');
        if ($query->num_rows() > 0) {
            $result = $query->result_array();
            $query->free_result();
            return $result;
        } else {
            return array();
        }
    }

    function add_categories_data($params)
    {
        $params['created'] = date('Y-m-d H:i:s');
        $params['modified'] = date('Y-m-d H:i:s');
        return $this->db->insert('data_categories', $params);
    }

    function delete_categories_data($id)
    {
        // Assuming 'categories' is the name of your database table
        $query = $this->db->get_where('data_categories', array('cat_id' => $id));
        if ($query->num_rows() > 0) {
            $this->db->where('cat_id', $id);
            $this->db->delete('data_categories');
            return true; // Jika berhasil menghapus
        } else {
            return false; // Jika data tidak ditemukan
        }
    }

    public function get_last_categories_sequence()
    {
        $this->db->select_max('cat_code');
        $query = $this->db->get('data_categories');
        $row = $query->row();
        return $row->cat_code;
    }

    public function get_detail_categories($id) {
        $query = $this->db->get_where('data_categories', array('cat_id' => $id));
        return $query->row_array(); // Mengembalikan satu baris hasil
    }

    public function edit_data_categories($id, $data)
    {
        $this->db->where('cat_id', $id);
        $data['modified'] = date('Y-m-d H:i:s');
        $this->db->update('data_categories', $data);
    }

    public function product_categories($data_categories)
    {
        
        $data_categories['created'] = date('Y-m-d H:i:s');
        return $this->db->insert('product_categories', $data_categories);
    }

    public function edit_product_categories($data_categories)
    {
        
        $data_categories['modified'] = date('Y-m-d H:i:s');
        return $this->db->update('product_categories', $data_categories);
    }
}
