<?php

class ApplicationBase extends CI_Controller
{

    // init base variable
    protected $portal_id;
    protected $portal_public;
    protected $app_portal;
    protected $app_settings;
    protected $app_page;
    protected $web_portal;
    protected $web_settings;
    protected $web_page;
    protected $current_page;
    protected $parent_menu;

    public function __construct()
    {
        // load basic controller
        parent::__construct();
        // load app data
        $this->base_load_app();
        // view app data
        $this->base_view_app();
    }

    /*
     * Method pengolah base load
     * diperbolehkan untuk dioverride pada class anaknya
     */

    protected function base_load_app()
    {
        // load themes (themes default : default)
        // $this->tsmarty->load_themes("default");
        // load javascript
        // $this->tsmarty->load_javascript("resource/themes/default/js/vendors/jquery-3.2.1.min.js");
        // $this->tsmarty->load_javascript("resource/themes/default/js/vendors/bootstrap.bundle.min.js");
    }

    /*
     * Method pengolah base view
     * diperbolehkan untuk dioverride pada class anaknya
     */

    protected function base_view_app()
    {
        // assign config
        $this->tsmarty->assign("config", $this->config);
        // default portal for all user
        $this->portal_id = $this->config->item('private');
        $this->portal_public = $this->config->item('public');
        // display site title
        self::_display_site_title();
        // get session
        self::_get_user_session();
    }

    /*
     * Method layouting base document
     * diperbolehkan untuk dioverride pada class anaknya
     */

    protected function display($tmpl_name = 'base/document.html')
    {
        // set template
        $this->tsmarty->display($tmpl_name);
    }

    //
    // base private method here
    // prefix ( _ )
    // site title
    private function _display_site_title()
    {
        // load model
        $this->load->model('apps/M_preferences', 'pref');
        // site data
        $this->app_portal = $this->site->get_site_data_by_id($this->portal_id);
        $this->app_settings = $this->pref->get_all_preference_by_group_label([$this->app_portal['site_title'], 'site_setting']);
        $this->web_portal = $this->site->get_site_data_by_id($this->portal_public);
        $this->web_settings = $this->pref->get_all_preference_by_group_label([$this->web_portal['site_title'], 'site_setting']);
        $this->tsmarty->assign("web", $this->web_portal);
        $this->tsmarty->assign("web_settings", $this->web_settings);
        if (!empty($this->app_portal)) {
            $this->tsmarty->assign("site", $this->app_portal);
            $this->tsmarty->assign("settings", $this->app_settings);
            // page detail
            $this->app_page = $this->site->get_current_page([$this->uri->uri_string(), $this->app_portal['site_id']]);
            if (!empty($this->app_page)) {
                $this->tsmarty->assign("page", $this->app_page);
            }
        }
    }

    // get session
    private function _get_user_session()
    {
        $this->load->library('session');
        $this->user_data = $this->session->userdata('user');
        if (!empty($this->user_data)) {
            // display site menu
            self::_display_site_menu($this->user_data);
            $this->tsmarty->assign("user_data", $this->user_data);

            // get permission 
            if (!in_array(uri_string(), array('administrator/dashboard', 'administrator/profile'))) {
                $menu_data = $this->site->get_user_authority_by_nav(array($this->user_data['user_id'], uri_string(), $this->portal_id));

                if (!empty($menu_data)) {
                    if ($menu_data['permission'] < 1000) {
                        $this->session->set_flashdata('message', array('msg' => 'Anda tidak dapat mengakses halaman tersebut.', 'status' => 'error'));
                        redirect(site_url('administrator/dashboard'));
                    }
                } else {
                    $urls = explode('/', uri_string());
                    $last_segment = count($urls) - 1;

                    if (in_array($urls[$last_segment], $this->config->item('action'))) {
                        $url = '';
                        foreach ($urls as $key => $u) {
                            if (($key) == $last_segment) break;
                            $url .= $u;
                            if (isset($urls[$key + 1]) && ($key + 1) != $last_segment) {
                                $url .= '/';
                            }
                        }
                        $action = $urls[$last_segment];
                    } else if (in_array($urls[$last_segment - 1], $this->config->item('action'))) {
                        $last_segment = $last_segment - 1;
                        $url = '';
                        foreach ($urls as $key => $u) {
                            if (($key) == $last_segment) break;
                            $url .= $u;
                            if (isset($urls[$key + 1]) && ($key + 1) != $last_segment) {
                                $url .= '/';
                            }
                        }
                        $action = $urls[$last_segment];
                    }

                    $menu_data = $this->site->get_user_authority_by_nav(array($this->user_data['user_id'], $url, $this->portal_id));
                    if (!$menu_data[$this->config->item('allowance')[$action]]) {
                        $this->session->set_flashdata('message', array('msg' => 'Anda tidak dapat mengakses halaman tersebut.', 'status' => 'error'));
                        redirect(site_url('administrator/dashboard'));
                    }

                    // current page
                    $this->current_page = $this->site->get_menu_by_url(array($url));
                    $this->tsmarty->assign('current_page', $this->current_page);
                    // parent menu
                    $this->parent_menu = $this->site->get_parent_menu_by_url(array($url));
                    $this->tsmarty->assign('parent_menu', $this->parent_menu);
                }
                $this->tsmarty->assign("allowed", $menu_data);
            }
        } else {
            $this->session->set_flashdata('message', array('msg' => 'Anda belum melakukan login.', 'status' => 'error'));
            redirect(site_url('administrator'));
        }
        $this->tsmarty->assign('notification', $this->session->flashdata('message'));
    }

    // site menu
    private function _display_site_menu($user_data = null)
    {
        // site menu
        $this->app_menu = $this->site->get_menu_by_user(array($this->portal_id, $user_data['user_id']));
        $this->tsmarty->assign("menus", $this->app_menu);
        // current page
        $this->current_page = $this->site->get_menu_by_url(array(uri_string()));
        $this->tsmarty->assign('current_page', $this->current_page);
        // parent menu
        $this->parent_menu = $this->site->get_parent_menu_by_url(array(uri_string()));
        $this->tsmarty->assign('parent_menu', $this->parent_menu);
    }
}
