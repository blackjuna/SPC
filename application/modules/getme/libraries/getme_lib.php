<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Getme_Lib
{
	
    protected $_ci       	= NULL;    //codeigniter instance
    protected $app_title	= NULL;    
    protected $app_title_short = NULL;    
	
    public function __construct()
	{
		$this->_ci = &get_instance();
		
		$this->app_title 		= 'HD SYSTEMS';
		$this->app_title_short 	= 'HDSys';
		
	}
	
	public function go( $mdl_grp=null, $mdl=null, $data=array() ) 
	{
		if ( !$this->_ci->ion_auth->logged_in() ) 
			redirect('auth/login', 'refresh');
			
		$module = $this->_ci->systems_model->getModules_ByCode($mdl_grp, $mdl);
		if (!$module)
			// $this->session->set_flashdata('message', 'Sorry, module you have requested was not exists...!');
			// crud_error('Sorry, module you have requested was not exists...!');
			return show_error('Sorry, module you have requested was not exists...!');
		
		$page_link = strtolower($module->page_link);

		// APP INFO
		$data1['app_title'] 		= $this->app_title;
		$data1['app_title_short'] 	= $this->app_title_short;
		$data1['title'] 	   		= strtoupper($module->module_group_name).' :: '.anchor($page_link, strtoupper($module->module_name));
		$data1['title_module'] 	   	= strtoupper($module->module_name);
		$data1['menus'] 	   		= $this->_ci->systems_model->getGroups_Auth_ByGroupId( explode(",", sesUser()->u_groups) );
		// DATA USER
		$user = sesUser();
		$data1['username']  		= strtoupper($user->username);
		$data1['first_name']		= strtoupper($user->first_name);
		$data1['last_name']			= strtoupper($user->last_name);
		$data1['email']  			= $user->email;
		$data1['image']  			= empty($user->image) ? "no_photo.jpg" : $user->image;
		$date = new DateTime("@$user->last_login");
		$data1['last_login'] 		= $date->format('D, d M Y h:i A');
		
		$data2['title'] 			= strtoupper($module->module_group_name).' :: '.strtoupper($module->module_name);
		$data2 						= is_array($data) ? array_merge($data2, $data) : $data2;		
			
		$this->_ci->load->view('getme/header', $data1);
		$this->_ci->load->view('getme/left', $data1);
		$this->_ci->load->view($page_link, $data2);
		// $this->_ci->load->view('getme/footer', $data1);
	}

}