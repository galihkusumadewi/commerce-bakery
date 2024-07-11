<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

// load base
require_once( APPPATH . 'controllers/base/PrivateBase.php' );

// --
class Menus extends ApplicationBase {

    // constructor
    public function __construct() {
        // parent constructor
        parent::__construct();
    }

    // index
    public function index() {
        // set template content
        $this->tsmarty->assign("template_content", "settings/menus/index.html");
        // output
        parent::display();
    }

}