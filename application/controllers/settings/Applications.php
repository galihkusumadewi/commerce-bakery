<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

// load base
require_once( APPPATH . 'controllers/base/PrivateBase.php' );

// --
class Applications extends ApplicationBase {

    // constructor
    public function __construct() {
        // parent constructor
        parent::__construct();
    }

    // index
    public function index() {
        // set template content
        $this->tsmarty->assign("template_content", "settings/applications/index.html");
        // save data
        if($this->input->post()){
            $this->load->library('form_validation');
            $this->form_validation->set_rules('site_title', 'Website Title', 'trim|required');
            $this->form_validation->set_rules('site_desc', 'Website Description', 'trim');
            $this->form_validation->set_rules('site_icon', 'Website Logo', 'trim');
            if ($this->form_validation->run() !== FALSE) {
                if($_FILES['site_icon']['tmp_name'] !== '') {
                    // upload image
                    $config['upload_path']          = './resource/assets/default/images/';
                    $config['allowed_types']        = 'gif|jpg|png';
                    $config['file_name']            = 'logo.png';
                    $config['overwrite']            = TRUE;

                    $this->load->library('upload', $config);
                    if (!$this->upload->do_upload('site_icon')){
                        $error = array('error' => $this->upload->display_errors());
                        $this->session->set_flashdata('message', array('msg' => $error['error'], 'status' => 'error'));
                    }
                    else {
                        $data_upload = $this->upload->data();
                        $data = [
                            'site_title' => $this->input->post('site_title'),
                            'site_desc' => $this->input->post('site_desc'),
                            'site_icon' => $data_upload['file_name'],
                        ];
                        if($this->site->update_site_data($this->input->post('site_id'), $data)) {
                            $this->site->update_site_data($this->app_portal['site_id'], $data);
                            $this->session->set_flashdata('message', array('msg' => 'Data berhasil disimpan', 'status' => 'success'));
                            redirect(site_url('settings/applications'));
                        } else {
                            $this->session->set_flashdata('message', array('msg' => 'Data gagal disimpan.', 'status' => 'error'));
                        }
                    }
                } else {
                    $data = [
                        'site_title' => $this->input->post('site_title'),
                        'site_desc' => $this->input->post('site_desc'),
                    ];
                    if($this->site->update_site_data($this->input->post('site_id'), $data)) {
                        $this->site->update_site_data($this->app_portal['site_id'], $data);
                        $this->session->set_flashdata('message', array('msg' => 'Data berhasil disimpan', 'status' => 'success'));
                        redirect(site_url('settings/applications'));
                    } else {
                        $this->session->set_flashdata('message', array('msg' => 'Data gagal disimpan.', 'status' => 'error'));
                    }
                }
            } else {
                $this->session->set_flashdata('message', array('msg' => 'Data gagal disimpan.', 'status' => 'error'));
            }
        }
        // output
        parent::display();
    }

    // role
    public function preferences() {
        // set template content
        $this->tsmarty->assign("template_content", "settings/preferences/index.html");
        // output
        parent::display();
    }
}