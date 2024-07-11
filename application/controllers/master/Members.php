<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

// load base
require_once( APPPATH . 'controllers/base/PrivateBase.php' );

// --
class Members extends ApplicationBase {

    // constructor
    public function __construct() {
        // parent constructor
        parent::__construct();
        $this->load->model('members/M_members', 'm_members');
        $this->load->library('form_validation');
        $this->load->library('session');
    }

    // index
    public function index() {
        $this->tsmarty->assign("template_content", "master/members/index.html");
        $data = $this->m_members->get_list_data_members_with_app_user();
        $this->tsmarty->assign("members", $data);
        parent::display();
    }

    public function detail($id) {
        $this->tsmarty->assign("template_content", "master/members/show.html");
        // get data
        $data['members'] = $this->m_members->get_detail_data_member($id);
        $this->tsmarty->assign("member", $data['members']);
        parent::display();
    }

    public function delete($id) {
        $this->load->model('M_members');
        
        if ($this->m_members->delete_data_member($id)) {
            $this->session->set_flashdata('message', array('msg' => 'Data gagal dihapus.', 'status' => 'error'));
        } else {
            $this->session->set_flashdata('message', array('msg' => 'Data berhasil dihapus.', 'status' => 'success'));
        }
        
        redirect('master/members');
    }

    public function edit() {
       // $id = 109;
	   $id = $this->input->get('id');
      
        $data['members'] = $this->m_members->get_detail_data_member($id);
		$this->tsmarty->assign("template_content", "master/members/edit.html");
        $this->tsmarty->assign("member", $data['members']);

        if($this->input->post()) {
            // $this->form_validation->set_rules('user_name', 'Username', 'required');

          //$data[] = $this->input>post();
                $appuser = array(
                    'user_name' => $this->input->post('user_name'),
                    'user_alias' => $this->input->post('user_alias'),
                    'user_email' => $this->input->post('user_email'),
                    'user_st' => $this->input->post('user_st'),
                    'user_lock' => $this->input->post('user_lock'),
                    // 'user_photo' => $this->input->post('user_photo'),
                );
 
                $this->m_members->edit_app_user($id, $appuser);
			}
		if($this->input->post()) {
                $datamember = array(
                    'fullname' => $this->input->post('fullname'),
                    'date_of_birth' => $this->input->post('date_of_birth'),
                    'phone' => $this->input->post('phone'),
                    'address' => $this->input->post('address'),
                    'modified' => date('Y-m-d H:i:s'),
                    'modified_by' => $this->user_data['user_id'],
                );
                
                $this->m_members->edit_data_member($id, $datamember);
                
                $this->session->set_flashdata('message', array('msg' => 'Data berhasil disimpan.', 'status' => 'success'));
                redirect('master/members');

        
        }
        
        parent::display();
    }
    

    public function add() {
        $this->tsmarty->assign("template_content", "master/members/add.html");
        parent::display();
    }

}
