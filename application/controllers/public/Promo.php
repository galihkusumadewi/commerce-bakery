<?php

if (!defined('BASEPATH'))
exit('No direct script access allowed');

// load base
require_once( APPPATH . 'controllers/base/PublicBase.php' );
 
class Promo extends ApplicationBase {
	
	function __construct(){
		parent::__construct();
		$this->load->model('M_promotions', 'm_promotions');
		
	}
 
	public function index(){
		$this->tsmarty->assign("template_content", "public/promo.html");
		$data['promotions'] = $this->m_promotions->get_list_data_promotion();
        $this->tsmarty->assign("promotions", $data['promotions']);
        parent::display();
	}

}