<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class M_users extends CI_Model {
    private $_table = "app_user";
    function __construct() {
        // Call the Model constructor
        parent::__construct();
    }

    // get last inserted id
    function get_last_inserted_id() {
        return $this->db->insert_id();
    }

    // get last code
    function get_user_last_code($params) {
        $sql = "SELECT RIGHT(user_code, 4) 'last_number'
                FROM app_user
                WHERE LEFT(user_code, 3) = ?
                ORDER BY user_code DESC
                LIMIT 1";
        $query = $this->db->query($sql, $params);
        if ($query->num_rows() > 0) {
            $result = $query->row_array();
            $query->free_result();
            // create next number
            $number = intval($result['last_number']) + 1;
            if ($number >= 9999) {
                return false;
            }
            $zero = '';
            for ($i = strlen($number); $i < 4; $i++) {
                $zero .= '0';
            }
            return $number . $zero;
        } else {
            // create new number
            return '0001';
        }
    }

    // get all portal
    function get_all_portal() {
        $sql = "SELECT * FROM app_user ORDER BY user_code ASC";
        $query = $this->db->query($sql);
        if ($query->num_rows() > 0) {
            $result = $query->result_array();
            $query->free_result();
            return $result;
        } else {
            return array();
        }
    }

    // get total data
    function get_total_data_users() {
        $sql = "SELECT COUNT(*)'total' FROM app_user";
        $query = $this->db->query($sql);
        if ($query->num_rows() > 0) {
            $result = $query->row_array();
            $query->free_result();
            return $result['total'];
        } else {
            return 0;
        }
    }

    // get list data
    function get_list_data_users($params) {
        $sql = "SELECT 
                    app_user.user_id,
                    app_role.role_nm,
                    app_user.user_name,
                    app_user.user_alias,
                    app_user.user_email,
                    IF(app_user.user_st = '0', IF(app_user.user_lock = '0', 'Active', 'Locked'), 'Inactive') AS `status`
                FROM app_user 
                INNER JOIN app_role_user ON app_user.user_id = app_role_user.user_id
                INNER JOIN app_role ON app_role_user.role_id = app_role.role_id
                WHERE app_role.site_id = ?
        ";
        $query = $this->db->query($sql, $params);
        if ($query->num_rows() > 0) {
            $result = $query->result_array();
            $query->free_result();
            return $result;
        } else {
            return 0;
        }
    }

    // add user detail
    // function add_user_data($params) {
    //     return $this->db->insert('app_user', $params);
    // }

    // // update user detail
    // function update_user_data($id, $params) {
    //     $this->db->where('user_id', $id);
    //     return $this->db->update('app_user', $params);
    // }

    // // delete user detail
    // function delete_user_data($id) {
    //     $this->db->where('id', $id);
    //     return $this->db->delete('app_user');
        
    // }
   
    function saveUserMember($data) {
        $this->db->insert('app_user', $data);

    }
    function saveUser($dataa) {
        $this->db->insert('app_user', $dataa);
    }
    
    public function saveRoleUser($data_role) {
        $this->db->insert('app_role_user', $data_role);
        return $this->db->insert_id(); // Mengembalikan user_id yang baru saja digunakan
    }
    

    function get_detail_data_member($id) {
        $this->db->select('*'); 
        $this->db->from('app_user');
        $this->db->join('data_member', 'app_user.user_id = data_member.user_id');
        $this->db->where('app_user.user_id', $id); // Filter berdasarkan ID
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            return $query->row_array(); // Mengambil satu baris data
        } 
    }

   
    public function edit_data_member($id, $datamember, $data_app) {

        if($data_app) {
            $this->db->where('user_id', $id);
            $this->db->update('app_user', $data_app);
        } 
            $this->db->where('user_id', $id);
            $this->db->update('data_member', $datamember);
       
    }
    
    function saveAnotherUserMember($data_member) {
        $this->db->insert('data_member', $data_member);
    }

    public function check_login($email, $password) {

        $result = $this->get_user_account_by_username(array($email));
        if (!empty($result)) {
            $this->encryption->initialize(
                array(
                    'cipher' => 'aes-256',
                    'mode' => 'ctr',
                    'key' => $result['user_key'] 
                )
            );
            $password_decode = $this->encryption->decrypt($result['user_pass']);

            // get user
            if ($password_decode === md5($password)) {
                // cek authority then return id
                return $result;
            } else {
                return FALSE;
            }
        } else {
            return FALSE;
        }
    }

    function get_user_account_by_username($params)
    {       
        $sql = "SELECT *
            FROM app_user
            WHERE user_email = ? OR user_id IN (
                SELECT user_id
                FROM data_member
                WHERE phone = ?
            )";
        $query = $this->db->query($sql, array($params,$params));
        if ($query->num_rows() > 0) {
            $result = $query->row_array();
            $query->free_result();
            return $result;
        } else {
            return array();
        }
    }

    function get_list_history($purchase_member)
    {
        $query = $this->db->get_where('purchase_histories', array('purchase_member' => $purchase_member));
        return $query->result();
    }

    function get_detail_purchase_history($purchase_id)
    {

        $this->db->select('purchase_history_details.*, data_product.product_name, data_product.product_pict');
        $this->db->from('purchase_history_details');
        $this->db->join('data_product', 'purchase_history_details.product_id = data_product.product_id', 'left');
        $this->db->where('purchase_history_details.purchase_id', $purchase_id);

        $query = $this->db->get();
        return $query->result();
    }

    public function delete_purchase_history($purchase_id)
    {
       $where = "purchase_id= $purchase_id";
        // $this->db->delete('purchase_histories'); // Make sure table name matches your database
        // return $this->db->affected_rows() > 0; // Return true if any rows were affected, otherwise false

        // $where = "purchase_id =$purchase_id_cart";
		$tables = array('purchase_histories', 'purchase_history_details');
        $this->db->where($where);
        $this->db->delete($tables); 
    }

     public function get_all_roles() {
        $query = $this->db->get('app_role');
        
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return array();
        }
    }
    //  public function get_all_roles_id($id) {
    //     $this->db->select('*');
    //     $this->db->from('app_user a');
    //     $this->db->join('app_role_user', 'a.user_id = app_role_user.user_id');
    //     $this->db->join('app_role', 'app_role_user.role_id = app_role.role_id');
    //     $this->db->where('a.user_id', $id);
    //     $query = $this->db->get();

    //     return $query->result();
    // }

    //  public function get_all_roles_id($userid) {
    //     $query = $this->db->get_where('app_role', array('user_id' => $userid));
    //     return $query->row();
    // }

    function get_detail_data_user($id)
    {
        $this->db->select('*');
        $this->db->from('app_user a');
        $this->db->join('app_role_user', 'a.user_id = app_role_user.user_id');
        $this->db->join('app_role', 'app_role_user.role_id = app_role.role_id');
        $this->db->where('a.user_id', $id);
        $query = $this->db->get();

        return $query->row();

        //  return $query->result();
    }

    public function edit_data_user($id, $dataa)
    {
        $this->db->where('user_id', $id);
        $this->db->update('app_user', $dataa);
    }
    public function edit_data_role_user($id, $data_role)
    {
        $this->db->where('user_id', $id);
        $this->db->update('app_role_user', $data_role);
    }


    

    public function delete_user_by_id($id)
    {
        // Hapus data dari tabel 'app_user'
        $this->db->where('user_id', $id);
        $this->db->delete('app_user');

        // Hapus data dari tabel 'app_role_user'
        $this->db->where('user_id', $id);
        $this->db->delete('app_role_user');
    }

    public function get_user_by_email($email) {
        $this->db->where('user_email', $email);
        $query = $this->db->get('app_user');
    
        if ($query->num_rows() > 0) {
            return $query->row_array();
        } else {
            return null; // Atau sesuaikan dengan cara yang Anda inginkan jika tidak ditemukan
        }
    }
   
    
    
    
    
    
    


    // function get_list_user_app()
    // {
    //     $query = $this->db->get('user_app');
    //     if ($query->num_rows() > 0) {
    //         $result = $query->result_array();
    //         $query->free_result();
    //         return $result;
    //     } else {
    //         return array();
    //     }
    // }
        
    
    


    // function get_user_login_by_account($username, $password)
    // {

    //     $sql = "SELECT
    //     user_name,
    //     user_pass
    //     FROM app_user
    //     WHERE user_name = ? 
    //     LIMIT 1";
    //     // get hash key
    //     $query = $this->db->query($sql, array($username));
    //     if ($query->num_rows() > 0) {
    //         $result = $query->row_array();
    //         $query->free_result();
            
    //         $password_decode = md5($password);
    
    //         if ($result['user_pass'] === $password_decode) {
    //             return $result['user_name'];
    //         } else {
    //             return FALSE;
    //         }
    //     } else {
    //         return FALSE;
    //     }
    // }

   
}
    
