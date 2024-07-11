<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

// load base
require_once( APPPATH . 'controllers/base/PublicBase.php' );

// --
class Home extends ApplicationBase {

    // constructor
    public function __construct() {
        // parent constructor
        parent::__construct();
        // load model
        $this->load->model('M_products', 'm_products');
        $this->load->model('M_categories', 'm_categories');
    }

    // dashboard
    public function index() {       
        $this->tsmarty->assign("template_content", "public/home.html");
        //untuk product yang berstatus pre launch
        $data = $this->m_products->get_product_prelaunch();
        $this->tsmarty->assign("prelaunch", $data);
        //untuk product yang berstatus pre launch
        $data = $this->m_products->get_product_arrival();
        $this->tsmarty->assign("arrival", $data);

        // output
        parent::display();
     }
    
   

    public function products() {
        $this->tsmarty->assign("template_content", "public/products.html"); 

        parent::display();
    }

}
