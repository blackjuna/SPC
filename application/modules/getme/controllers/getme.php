<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Getme extends CI_Controller {

	function __construct() {
		parent::__construct();
		date_default_timezone_set('Asia/Jakarta'); 
	}

	function index() {
		//Jika belum Login
		if ( !$this->ion_auth->logged_in() ) 
			redirect('auth/login', 'refresh');
		//Jika sudah login
		$this->getme_lib->go('main', 'home');
	}

}