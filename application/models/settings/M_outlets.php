<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class M_outlets extends CI_Model {

    function __construct() {
        // Call the Model constructor
        parent::__construct();
    }

    function get_list_data_outlets() {
        $query = $this->db->get('data_outlet');
        if ($query->num_rows() > 0) {
            $result = $query->result_array();
            $query->free_result();
            return $result;
        } else {
            return array();
        }
    } 
    
    
    public function get_last_outlet_sequence()
    {
        $this->db->select_max('outlet_code');
        $query = $this->db->get('data_outlet');
        $row = $query->row();
        return $row->outlet_code;
    }

    function add_data_outlets($data) {
        return $this->db->insert('data_outlet', $data);
    }

    function delete_data_outlets($id) {
        $this->db->where('outlet_id', $id);
        $this->db->delete('data_outlet');
    }

    public function get_detail_outlets($id) {
        $query = $this->db->get_where('data_outlet', array('outlet_id' => $id));
        return $query->row_array(); // Mengembalikan satu baris hasil
    }

    public function edit_data_outlets($id, $data) {
        $this->db->where('outlet_id', $id);
        $this->db->update('data_outlet', $data); 
    }

    public function get_list_city() { 
        $where = "outlet_status='0'";
            $this->db->select('*');
            $this->db->from('data_outlet');
            $this->db->where($where);
            // $this->db->group_by('kota');
            $query = $this->db->get();
            $result =  $query->result_array();

        $categories_with_city = array();
        foreach ($result as $row) {
            $kota_outlet = $row['kota'];
            $name_outlet = $row['outlet_name'];
            $alamat = $row['outlet_address'];
            $phone = $row['outlet_phone'];
            $foto = $row['outlet_photo'];
            $id = $row['outlet_id'];

            if (!isset($categories_with_city[$kota_outlet])) {
                $categories_with_city[$kota_outlet] = array(
                    'outlets' => array()
                );
            }

            
            if ($name_outlet) {
                $categories_with_city[$kota_outlet]['outlets'][$id]['outlet_name'] = $name_outlet;
            }
            if ($alamat) {
                $categories_with_city[$kota_outlet]['outlets'][$id]['outlet_address'] = $alamat;
            }
            if ($foto) {
                $categories_with_city[$kota_outlet]['outlets'][$id]['outlet_photo'] = $foto;
            }
            if ($phone) {
                $categories_with_city[$kota_outlet]['outlets'][$id]['outlet_phone'] = $phone;
            }

        }

        return $categories_with_city;
    }

    function get_list_data_outlets_when_active() {
        $query = $this->db->get_where('data_outlet', array('outlet_status' => '0'));
        return $query->result_array();
    }

    // function get_list_data_outlets_by_city($city) {
    //     $query = $this->db->get
    //     $query = $this->db->get_where('data_outlet', array('outlet_status' => '0'));
    //     return $query->result();
    // }
}