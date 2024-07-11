<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class M_site extends CI_Model {

    function __construct() {
        // Call the Model constructor
        parent::__construct();
    }

    // get site data
    function get_site_data_by_id($site_id) {
        $sql = "SELECT * FROM app_portal WHERE site_id = ?";
        $query = $this->db->query($sql, $site_id);
        if ($query->num_rows() > 0) {
            $result = $query->row_array();
            $query->free_result();
            return $result;
        } else {
            return false;
        }
    }

    // get current page
    function get_current_page($params) {
        $sql = "SELECT * FROM app_menu 
                WHERE nav_url = ? AND site_id = ?
                ORDER BY nav_no DESC 
                LIMIT 0, 1";
        $query = $this->db->query($sql, $params);
        if ($query->num_rows() > 0) {
            $result = $query->row_array();
            $query->free_result();
            return $result;
        } else {
            return false;
        }
    }

    // get current page by group portal
    function get_current_page_by_group_portal($params) {
        $sql = "SELECT * FROM app_menu 
                WHERE nav_url = ? AND site_id LIKE ?
                ORDER BY nav_no DESC 
                LIMIT 0, 1";
        $query = $this->db->query($sql, $params);
        // echo $this->db->last_query();
        if ($query->num_rows() > 0) {
            $result = $query->row_array();
            $query->free_result();
            return $result;
        } else {
            return array();
        }
    }

    // get menu by id
    function get_menu_by_id($params) {
        $sql = "SELECT * FROM app_menu WHERE nav_id = ?";
        $query = $this->db->query($sql, $params);
        if ($query->num_rows() > 0) {
            $result = $query->row_array();
            $query->free_result();
            return $result;
        } else {
            return false;
        }
    }

    // get menu by url
    function get_menu_by_url($params) {
        $sql = "SELECT * FROM app_menu WHERE nav_url = ?";
        $query = $this->db->query($sql, $params);
        if ($query->num_rows() > 0) {
            $result = $query->row_array();
            $query->free_result();
            return $result;
        } else {
            return false;
        }
    }

    // get parent menu by url
    function get_parent_menu_by_url($params) {
        $sql = "SELECT * FROM app_menu WHERE nav_url = ?";
        $query = $this->db->query($sql, $params);
        if ($query->num_rows() > 0) {
            $result = $query->row_array();
            if($result['parent_id'] != 0) {
                $result = $this->get_parent_menu_by_id(array($result['parent_id']));
            }
            $query->free_result();
            return $result;
        } else {
            return false;
        }
    }

    // get parent menu by id
    function get_parent_menu_by_id($params) {
        $sql = "SELECT * FROM app_menu WHERE nav_id = ?";
        $query = $this->db->query($sql, $params);
        if ($query->num_rows() > 0) {
            $result = $query->row_array();
            if($result['parent_id'] != 0) {
                $result = $this->get_parent_menu_by_id(array($result['parent_id']));
            }
            $query->free_result();
            return $result;
        } else {
            return false;
        }
    }

    // get list menu
    function get_menu_by_user($params) {
        $sql = "SELECT a.*, CONCAT(b.`read`, b.`create`, b.`edit`, b.`delete`) AS permission
                FROM app_menu a
                INNER JOIN app_role_menu b ON a.nav_id = b.nav_id
                INNER JOIN app_role_user c ON b.role_id = c.role_id
                WHERE a.site_id = ? AND c.user_id = ?
                AND nav_st = '0' AND nav_display = '0'
                AND CONCAT(b.`read`, b.`create`, b.`edit`, b.`delete`) >= '1000'
                AND nav_loc = 'left'
                GROUP BY a.nav_id
                ORDER BY nav_no ASC";
        $query = $this->db->query($sql, $params);
        if ($query->num_rows() > 0) {
            $results = $query->result_array();
            $menus = array();
            if(!empty($results)) {
                foreach($results as $result) {
                    $parent = $result['parent_id'];
                    if($parent == 0) {
                        $menus[$result['nav_id']] = $result;
                    } else {
                        $menus[$result['parent_id']]['child'][] = $result;
                    }
                }
            }
            $query->free_result();
            return $menus;
        } else {
            return false;
        }
    }

    // get user authority
    function get_user_authority($user_id, $id_group) {
        $sql = "SELECT a.user_id FROM app_user a
                INNER JOIN app_role_user b ON a.user_id = b.user_id
                INNER JOIN app_role c ON b.role_id = c.role_id
                WHERE a.user_id = ? AND c.site_id = ?";
        $query = $this->db->query($sql, array($user_id, $id_group));
        if ($query->num_rows() > 0) {
            $result = $query->row_array();
            $query->free_result();
            return $result['user_id'];
        } else {
            return false;
        }
    }

    // get user authority by navigation
    function get_user_authority_by_nav($params) {
        $sql = "SELECT DISTINCT b.*, CONCAT(b.`read`, b.`create`, b.`edit`, b.`delete`) AS permission FROM app_menu a
                INNER JOIN app_role_menu b ON a.nav_id = b.nav_id
                INNER JOIN app_role c ON b.role_id = c.role_id
                INNER JOIN app_role_user d ON c.role_id = d.role_id
                WHERE d.user_id = ? AND a.nav_url = ? AND a.site_id = ? AND nav_st = '0'";
        $query = $this->db->query($sql, $params);
        if ($query->num_rows() > 0) {
            $result = $query->row_array();
            $query->free_result();
            return $result;
        } else {
            return false;
        }
    }

    //function get reset password
    function get_reset_passwords($params) {
        $sql = "SELECT a.*
                FROM app_reset_pass a 
                ORDER BY a.request_date DESC
                LIMIT ?, ?";
        $query = $this->db->query($sql, $params);
        if ($query->num_rows() > 0) {
            $result = $query->result_array();
            $query->free_result();
            return $result;
        } else {
            return array();
        }
    }

    // get list authority 
    function get_list_user_roles($params) {
        $sql = "SELECT b.*, role_display
                FROM app_role_user a 
                INNER JOIN app_role b ON a.role_id = b.role_id
                INNER JOIN app_role_menu c ON b.role_id = c.role_id
                INNER JOIN app_menu d ON c.nav_id = d.nav_id
                WHERE d.site_id = ? AND a.user_id = ?
                GROUP BY b.role_id
                ORDER BY b.role_id ASC";
        $query = $this->db->query($sql, $params);
        if ($query->num_rows() > 0) {
            $result = $query->result_array();
            $query->free_result();
            return $result;
        } else {
            return array();
        }
    }

    // update
    function update_role_display($params, $where) {
        return $this->db->update('app_role_user', $params, $where);
    }

    function get_app_reference_by_pref_nm($params) {
        $sql = "SELECT pref_value FROM app_preferences WHERE pref_group = ? AND pref_nm = ?";
        $query = $this->db->query($sql, $params);
        if ($query->num_rows() > 0) {
            $result = $query->row_array();
            $query->free_result();
            return $result['pref_value'];
        } else {
            return '-';
        }
    }

    function get_app_reference_by_pref_nm_label($params) {
        $sql = "SELECT pref_value FROM app_preferences WHERE pref_group = ? AND pref_nm = ? AND pref_label = ?";
        $query = $this->db->query($sql, $params);
        if ($query->num_rows() > 0) {
            $result = $query->row_array();
            $query->free_result();
            return $result['pref_value'];
        } else {
            return '-';
        }
    }

    // update site detail
    function update_site_data($id, $params) {
        $this->db->where('site_id', $id);
        return $this->db->update('app_portal', $params);
    }
}
