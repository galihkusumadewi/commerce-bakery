<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

// load base
require_once( APPPATH . 'controllers/base/PrivateBase.php' );

// --
class Roles extends ApplicationBase {

    // constructor
    public function __construct() {
        // parent constructor
        parent::__construct();
        $this->load->model('settings/M_role', 'm_role');
        $this->load->library('form_validation');
        $this->load->library('session');
    }

    // index
    public function index() {
        // set template content
        $this->tsmarty->assign("template_content", "settings/roles/index.html");

        $data ['roles'] = $this->m_role->get_list_roles();
        $this->tsmarty->assign("roles", $data['roles']);
        // output
        parent::display();
    }

    private function generate_kode()
{
    // Get the maximum code from your function
    $max_code = $this->m_role->get_last_categories_sequence();

    // Calculate the new sequence
    if ($max_code) {
        $next_number = intval(substr($max_code, -2)) + 1;
    } else {
        $next_number = 1;
    }

    $prefix = '20';
    $kode = $prefix . str_pad($next_number, 1, '0', STR_PAD_LEFT);
    return $kode;
}

    public function add(){
        $role_id = $this->generate_kode();
        $this->tsmarty->assign('role_id', $role_id);

        $list_menu = $this->m_role->get_list_menu();
        $this->tsmarty->assign('list_menu', $list_menu);

        $list_all_menu = $this->m_role->get_list_menu();
        $this->tsmarty->assign('list_all_menu', $list_all_menu);

        // print_r($list_all_menu);exit();

        $this->tsmarty->assign("template_content", "settings/roles/add.html");
    
        if($this->input->post()){
            $this->form_validation->set_rules('role_nm', 'Role Name', 'required');
            $this->form_validation->set_rules('role_st', 'Role Status', 'required');
            $this->form_validation->set_rules('akses_menu[]', 'Akses Menu', 'required');
            // $this->form_validation->set_rules('read', 'Read', 'required');
            // $this->form_validation->set_rules('create', 'Create', 'required');
            // $this->form_validation->set_rules('delete', 'Delete', 'required');
            // $this->form_validation->set_rules('edit', 'Edit', 'required');
     
                if($this->form_validation->run() == FALSE){
                    $this->session->set_flashdata('message', array('msg' => 'Data gagal disimpan.', 'status' => 'error'));
                    redirect('settings/roles/add');
                }  else {
                    $data_role = array(
                        'role_nm' =>$this->input->post('role_nm'),
                        'role_id' =>$this->input->post('id'),
                        'role_st' => $this->input->post('role_st'),
                        'default_page' => $this->input->post('default_page'),
                        'site_id' => $this->input->post('site_id'),
                    );

                        $this->m_role->add_data_role($data_role);

                        $role_ids = $this->input->post('role_id');
                        $nav_ids = $this->input->post('akses_menu');
                        $reads = $this->input->post('read');
                        $creates = $this->input->post('create');
                        $edits = $this->input->post('edit');
                        $deletes = $this->input->post('delete');
            
                        for ($i = 0; $i < count($role_ids); $i++) {
                            $role_id = $role_ids[$i];
                            $nav_id = $nav_ids[$i];
                            $read = isset($reads[$i]) ? $reads[$i] : 0;
                            $create = isset($creates[$i]) == 1 ? $creates[$i]: 0;
                            $edit = isset($edits[$i]) == 1 ? $edits[$i] : 0;
                            $delete = isset($deletes[$i]) == 1 ? $deletes[$i] : 0;
                        
                            // Prepare the data for insertion
                            $data_to_menu = array(
                                'role_id' => $role_id,
                                'nav_id' => $nav_id,
                                'read' => $read,
                                'create' => $create,
                                'edit' => $edit,
                                'delete' => $delete,
                            );
            
                            // print_r($data_to_menu);exit(); 
                            $this->m_role->edit_data_role_menu($data_to_menu);      
                    
                        }

                    $this->session->set_flashdata('message', array('msg' => 'Data berhasil disimpan.', 'status' => 'success'));
                    redirect('settings/roles');
                } 
            }
    
        parent::display();
    }

    public function detail($role_id) {
        $this->tsmarty->assign("template_content", "settings/roles/detail.html");
    
        // Get role details
        $role = $this->m_role->detail_data_role($role_id);
        $this->tsmarty->assign('roles', $role);
    
        // Get navigation title and permissions
        $nav_info = $this->m_role->get_nav_info($role_id);
        $this->tsmarty->assign('nav_info', $nav_info);
    
        parent::display();
    }

    public function delete($id) {
        if ($this->m_role->delete_role($id)) {
            $this->session->set_flashdata('message', array('msg' => 'Data berhasil dihapus.', 'status' => 'success'));
        } else {
            $this->session->set_flashdata('message', array('msg' => 'Data gagal dihapus.', 'status' => 'error'));
        }
        
        redirect('settings/roles/');
    }
       
    public function edit_app_role()
{
    $role_id = $this->input->get('id');

    $roles = $this->m_role->detail_data_role($role_id);
    $this->tsmarty->assign("role", $roles);

    $list_all_menu = $this->m_role->get_list_menu();
    $this->tsmarty->assign('list_all_menu', $list_all_menu);

    $list_menu = $this->m_role->get_nav_info($role_id);
    $this->tsmarty->assign('list_menu', $list_menu);

    $this->tsmarty->assign("template_content", "settings/roles/edit.html");

    if ($this->input->post()) {
        $id = $this->input->post('id'); //
    
        $data = array(
           
            'role_nm' => $this->input->post('role_nm'),
            'role_st' => $this->input->post('role_st'),
        );

        $this->m_role->edit_data_role($id, $data);

        $id_menu = $this->input->post('id_menu');
        $this->m_role->delete_only_menu($id_menu);

        if ($this->db->affected_rows() > 0) {

            $role_ids = $this->input->post('role_id');
            $nav_ids = $this->input->post('akses_menu');
            $reads = $this->input->post('read');
            $creates = $this->input->post('create');
            $edits = $this->input->post('edit');
            $deletes = $this->input->post('delete');

            for ($i = 0; $i < count($role_ids); $i++) {
                $role_id = $role_ids[$i];
                $nav_id = $nav_ids[$i];
                $read = isset($reads[$i]) ? $reads[$i] : 0;
                $create = isset($creates[$i]) == 1 ? $creates[$i]: 0;
                $edit = isset($edits[$i]) == 1 ? $edits[$i] : 0;
                $delete = isset($deletes[$i]) == 1 ? $deletes[$i] : 0;

                // Prepare the data for insertion
                $data_to_menu = array(
                    'role_id' => $role_id,
                    'nav_id' => $nav_id,
                    'read' => $read,
                    'create' => $create,
                    'edit' => $edit,
                    'delete' => $delete,
                );

                // print_r($data_to_menu);exit();

           $this->m_role->edit_data_role_menu($data_to_menu);
            }
        }
       
       
            $this->session->set_flashdata('message', array('msg' => 'Data berhasil disimpan.', 'status' => 'success'));
            redirect('settings/roles');
       
    }

    parent::display();
}


    public function list_menu_all(){
        // json_decode(file_get_contents('php://input'), true);

    
        $all_menu = $this->m_role->get_list_menu();
        if($all_menu){
            $response = [
                "message" => "found",
                "list_menu" => $all_menu
            ];

            echo json_encode($response);
        }
    }

    public function delete_menu(){

        $data = json_decode(file_get_contents('php://input'), true);


        $id_role_menu = $data['id'];
        
        if ($this->m_role->delete_akses_menu($id_role_menu)) {
          $response = [
            "message" => "Data Terhapus"
          ];

          echo json_encode($response);
        } 
        
    }
    

}