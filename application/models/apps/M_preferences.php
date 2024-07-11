<?php

class M_preferences extends CI_Model {

    public function __construct() {
        // Call the Model constructor
        parent::__construct();
    }

    // get all preferences by range
    public function get_all_preference_by_group($params) {
        $sql = "SELECT * FROM app_preferences
                WHERE pref_group = ?
                ORDER BY pref_name ASC";
        $query = $this->db->query($sql, $params);
        if ($query->num_rows() > 0) {
            $result = $query->result_array();
            $query->free_result();
            return $result;
        } else {
            return array();
        }
    }

    // get all preferences by range
    public function get_all_preference_by_group_label($params) {
        $sql = "SELECT * FROM app_preferences
                WHERE pref_group = ? AND pref_label = ?
                ORDER BY pref_name ASC";
        $query = $this->db->query($sql, $params);
        if ($query->num_rows() > 0) {
            $result = $query->result_array();
            $array = [];
            if(!empty($result)){
                foreach($result as $res){
                    $array[$res['pref_name']] = $res['pref_value'];
                }
            }
            $query->free_result();
            return $array;
        } else {
            return array();
        }
    }

    // get all preferences by group name
    public function get_value_preference_by_group_name($params) {
        $sql = "SELECT * FROM app_preferences
                WHERE pref_group = ? AND pref_name = ?
                ORDER BY pref_name ASC";
        $query = $this->db->query($sql, $params);
        if ($query->num_rows() > 0) {
            $result = $query->row_array();
            $query->free_result();
            return $result['preference_value'];
        } else {
            return '';
        }
    }

    //get detail preferences
    public function get_preference_by_id($pref_id) {
        $sql = "SELECT * FROM app_preferences WHERE pref_id = ?";
        $query = $this->db->query($sql, $pref_id);
        if ($query->num_rows() > 0) {
            $result = $query->row_array();
            $query->free_result();
            return $result;
        } else {
            return array();
        }
    }

    // get detail preferences
    public function get_preference_by_group_id($params) {
        $sql = "SELECT * FROM app_preferences WHERE pref_group = ? AND pref_id = ?";
        $query = $this->db->query($sql, $params);
        if ($query->num_rows() > 0) {
            $result = $query->row_array();
            $query->free_result();
            return $result;
        } else {
            return array();
        }
    }

}
