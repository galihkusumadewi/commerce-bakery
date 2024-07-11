<?php

if (!defined('BASEPATH'))
exit('No direct script access allowed');

// load base
require_once( APPPATH . 'controllers/base/PublicBase.php' );
 
class Kategori extends ApplicationBase {
	
	function __construct(){
		parent::__construct();
		
	}
 
	public function index(){
		$this->tsmarty->assign("template_content", "public/kategori.html");
        parent::display();
	}

}