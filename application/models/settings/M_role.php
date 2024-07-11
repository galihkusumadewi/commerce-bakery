<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class M_role extends CI_Model {

    private $_table = "app_role";
    function __construct() {
        // Call the Model constructor
        parent::__construct();
    }

    function get_last_inserted_id() {
        return $this->db->insert_id();
    }

    public function get_list_roles() {
        $this->db->where('site_id', 20);
        $query = $this->db->get('app_role');

        if ($query->num_rows() > 0) {
            $result = $query->result_array();
            $query->free_result();
            return $result;
        } else {
            return array();
        }
    }

    public function detail_data_role($role_id) {
        $this->db->select('*, app_role.id, app_role.role_id');
        $this->db->from('app_role');
        $this->db->join('app_role_menu', 'app_role.role_id = app_role_menu.role_id', 'left');
        $this->db->where('app_role.role_id', $role_id);
        $query = $this->db->get();
    
        if ($query) {
            if ($query->num_rows() > 0) {
                return $query->row_array();
            } else {
                return array(); 
            }
        } else {
            log_message('error', 'Database Error: ' . $this->db->error()['message']);
            return false;
        }
    }
    
    public function get_nav_info($role_id) {
        $this->db->select('app_menu.nav_title, app_role_menu.id, app_role_menu.create, app_role_menu.id, app_role_menu.edit, app_role_menu.delete, app_role_menu.read, app_menu.nav_id');
        $this->db->from('app_menu');
        $this->db->join('app_role_menu', 'app_menu.nav_id = app_role_menu.nav_id', 'left');
        $this->db->join('app_role', 'app_role_menu.role_id = app_role.role_id', 'left');
        $this->db->where('app_role.role_id', $role_id);
        $query = $this->db->get();
    
        if ($query && $query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return array();
        }
    }

    public function get_last_categories_sequence() {
        $this->db->select_max('role_id');
        $query = $this->db->get('app_role');
        $row = $query->row();
        return $row->role_id;
    }

    public function add_data_role($data_role) {
       $this->db->insert('app_role', $data_role);
    }

    public function edit_data_role($id, $data) {
        $this->db->where('id', $id);
        $this->db->update('app_role', $data);
     }

     public function edit_data_role_menu($data_to_menu) {
        $this->db->insert('app_role_menu', $data_to_menu);
    }
    

    public function get_role_id ($id){
        $this->db->select('role_id');
        $query = $this->db->get_where('app_role', array('id' => $id));
        $row = $query->row();
        return $row->role_id;
    }
    public function add_data_role_menu($data_role_menu) {
        $this->db->order_by('id', 'DESC');
        $query = $this->db->get('app_role', 1);

        if ($query->num_rows() > 0) {
            $row = $query->row();
            $data_role_menu['role_id'] = $row->role_id;
            $this->db->insert('app_role_menu', $data_role_menu);
        } 
    }

    public function get_list_menu() {
        $query = $this->db->get_where('app_menu');

        if ($query->num_rows() > 0) {
            $result = $query->result_array();
            $query->free_result();
            return $result;
        } else {
            return array();
        }
    }

    public function delete_role($role_id) {
        $query = $this->db->get_where('app_role', array('role_id' => $role_id));
        if ($query->num_rows() > 0) {
            $this->db->where('role_id', $role_id);
            $this->db->delete('app_role');
    
            $this->db->where('role_id', $role_id);
            $this->db->delete('app_role_menu');
    
            return true;
        } else {
            return false;
        }
    }
    

    public function delete_only_menu($id_menu) {
        foreach ($id_menu as $id_menus) {
            $this->db->where('id', $id_menus);
            $this->db->delete('app_role_menu');
        }
    }

    public function delete_akses_menu($id_menu) {
            $this->db->where('id', $id_menu);
            $this->db->delete('app_role_menu');

            return true;
        }
    }