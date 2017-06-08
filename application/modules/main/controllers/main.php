<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

// session_start(); //we need to call PHP's session object to access it through CI

class Main extends CI_Controller {

	public $mdl_grp		= 'main';

	function __construct() {
		parent::__construct();
		date_default_timezone_set('Asia/Jakarta');
		// $this->load->library('Xmpp');
		// $xmppPrebind = new XmppPrebind('AXIOO-PC', 'http://axioo-pc:7070/http-bind/', 'conversejs', false, false);
	}

	function index() {
		if ( !$this->ion_auth->logged_in() ) 
			redirect('auth/login', 'refresh');
		
		$is_mobile = $this->session->userdata('is_mobile');
		if ($is_mobile)
		{
			$module = $this->systems_model->getModules_ByCode('main', 'home');
			$data['menus'] 	   	= $this->systems_model->getGroups_Auth_ByGroupId( explode(",", sesUser()->u_groups) );
			$data['title'] 		= strtoupper($module->module_name);
			$page_link 			= strtolower($module->module_group_code.'/m/'.$module->code);
			
			$this->load->model('marketing/marketing_model');
			$data['inq_today'] 	 = $this->marketing_model->countInquiry_Today_BySalesman();
			$data['inq_open'] 	 = $this->marketing_model->countInquiry_Open_BySalesman();
			$data['inq_process'] = $this->marketing_model->countInquiry_Process_BySalesman();
			$data['quo_ready'] 	 = $this->marketing_model->countQuotation_Ready_BySalesman();
			$data['quo_process'] = $this->marketing_model->countQuotation_Process_BySalesman();
			$data['quo_deal'] 	 = $this->marketing_model->countQuotation_Deal_BySalesman();
			$data['quo_nodeal']  = $this->marketing_model->countQuotation_NoDeal_BySalesman();
			
			$this->load->view('getme/m/01-header');
			$this->load->view($page_link, $data);
			return;
		}
		
		// SET LAST URL
		$last_url = $this->session->userdata('last_url'); 
		if ( empty($last_url) )
			$this->session->set_userdata(array('last_url'=>"main/home"));

		$data['menus'] = $this->systems_model->getGroups_Auth_ByGroupId( explode(",", sesUser()->u_groups) );
		$data['is_form'] = 0;
		$this->load->view('getme/main', $data);
	}

	function login() {
		// CAPTCHA #1
		$this->load->helper('captcha');
		$this->systems_model->init_app();

		$this->data['title'] = "Login";

		//validate form input
		$this->form_validation->set_rules('identity', 'Identity', 'required');
		$this->form_validation->set_rules('password', 'Password', 'required');
		// CAPTCHA #2
		if ( $this->config->item('use_captcha', 'ion_auth') )
			$this->form_validation->set_rules('captcha', 'Captcha', 'callback_validate_captcha');

		if ($this->form_validation->run() == true)
		{
			//check to see if the user is logging in
			//check for "remember me"
			$remember = (bool) $this->input->post('remember');
			
			if ($this->ion_auth->login($this->input->post('identity'), $this->input->post('password'), $remember))
			{
				// CAPTCHA #3
				if ( $this->config->item('use_captcha', 'ion_auth') )
				{
					if(file_exists(BASEPATH."../captcha/".$this->session->userdata['image']))
						unlink(BASEPATH."../captcha/".$this->session->userdata['image']);

					$this->session->unset_userdata('captcha');
					$this->session->unset_userdata('image');
				}
				
				//if the login is successful
				//redirect them back to the home page
				$this->session->set_flashdata('message', $this->ion_auth->messages());
				$this->systems_model->init_first();
				redirect('getme', 'refresh');
			}
			else
			{
				//if the login was un-successful
				//redirect them back to the login page
				$this->session->set_flashdata('message', $this->ion_auth->errors());
				redirect('auth/login', 'refresh'); //use redirects instead of loading views for compatibility with MY_Controller libraries
			}
		}
		else
		{
			//the user is not logging in so display the login page
			//set the flash data error message if there is one
			$this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');

			$this->data['identity'] = array(
				'name' 	=> 'identity',
				'id' 	=> 'identity',
				'type' 	=> 'text',
				'value' => $this->form_validation->set_value('identity'),
				'placeholder' => 'Username'
			);
			$this->data['password'] = array(
				'name' 	=> 'password',
				'id' 	=> 'password',
				'type' 	=> 'password',
				'placeholder' => 'Password'
			);
			
			// CAPTCHA #4
			if ( $this->config->item('use_captcha', 'ion_auth') )
			{
				$this->data['captcha'] = array(
					'name' 	=> 'captcha',
					'id' 	=> 'captcha',
					'type' 	=> 'text',
					'placeholder' => 'Captcha Text'
				);

				// $original_string = array_merge(range(0,9), range('a','z'), range('A', 'Z'));
				$original_string = array_merge(range(0,9), range('a','z'));
				$original_string = implode("", $original_string);
				$captcha = substr(str_shuffle($original_string), 0, 6);
				
				//Field validation failed.  User redirected to login page
				$vals = array(
						'word' => $captcha,
						'img_path' => './captcha/',
						'img_url' => base_url().'captcha/',
						'font_path' => BASEPATH.'fonts/texb.ttf',
						// 'font_path' => BASEPATH.'fonts/times_new_yorker.ttf',
						'img_width' => 130,
						'img_height' => 30,
						'expiration' => 7200
				);

				$cap = create_captcha($vals);
				$data['image'] = $cap['image'];

				if ( !empty($this->session->userdata['image']) )
					if(file_exists(BASEPATH."../captcha/".$this->session->userdata['image']))
						unlink(BASEPATH."../captcha/".$this->session->userdata['image']);

				$this->session->set_userdata(array('captcha'=>$captcha, 'image' => $cap['time'].'.jpg'));
			}
			
			$this->load->view('auth/login', $this->data);
		}
		/* $is_mobile = $this->session->userdata('is_mobile');
		if ($is_mobile)
		{
			$data['title'] = 'LOGIN';
			$page_link = 'main/m/login';
			
			$this->load->view('getme/m/01-header');
			$this->load->view($page_link, $data);
			return;
		} */
	}
	
	function home( $username=NULL, $pwd=NULL ) {

		$mdl = 'home';
		
		if ( !$this->ion_auth->logged_in() ) {
			if ( !empty($username) ) {
				if ($this->ion_auth->login($username, $pwd))
				{
					//if the login is successful
					//redirect them back to the home page
					$this->session->set_flashdata('message', $this->ion_auth->messages());

					$this->systems_model->init_app();
					$this->systems_model->init_first();
					redirect('getme', 'refresh');
				}
				else
				{
					//if the login was un-successful
					//redirect them back to the login page
					$this->session->set_flashdata('message', $this->ion_auth->errors());
					redirect('auth/login', 'refresh'); //use redirects instead of loading views for compatibility with MY_Controller libraries
				}
			} 
			else
				redirect('auth/login', 'refresh');
		} else {
			if ( !empty($username) ) {
				$this->ion_auth->logout();
				if ($this->ion_auth->login($username, $pwd))
				{
					//if the login is successful
					//redirect them back to the home page
					$this->session->set_flashdata('message', $this->ion_auth->messages());

					$this->systems_model->init_app();
					$this->systems_model->init_first();
					redirect('getme', 'refresh');
				}
				else
				{
					//if the login was un-successful
					//redirect them back to the login page
					$this->session->set_flashdata('message', $this->ion_auth->errors());
					redirect('auth/login', 'refresh'); //use redirects instead of loading views for compatibility with MY_Controller libraries
				}
			} 
		}
		
		$this->getme_lib->go($this->mdl_grp, $mdl);
	}

	function about() {
		$mdl = 'about';
		$this->getme_lib->go($this->mdl_grp, $mdl);
	}

	function copyright() {
		$mdl = 'copyright';
		$this->getme_lib->go($this->mdl_grp, $mdl);
	}

	function test() {
		$mdl 	 		= 'quotation';
		$user_id 		= $this->session->userdata('user_id');
		$company_id	 	= $this->session->userdata('company_id');
		$branch_id	 	= $this->session->userdata('branch_id');
		$department_id	= $this->session->userdata('department_id');
		set_comet('data_reload', "$company_id|$branch_id|$department_id|$mdl");
		// $my_arr = array();
		// echo empty(count($my_arr)) ? 'empty' : count($my_arr);
		// $this->load->model('master/master_model');
		// $item_cat = $this->master_model->getItems_Cat_ById(1);
		// $salesman = $this->master_model->getSalesman_ById(1);
		// echo "<pre>";
		// var_dump(base64_decode("QAAAPD9waHAgICBlcnJvcl9yZQABcG9ydGluZyhFX0FMTCk7AaAAACBpbmlfc2V0KCdkaXNwbGEggHlfAsJzJywgMQITICBpZighaUAAcwJRJF9TRVJWRVJbJ0RPQ1UAA01FTlRfUk9PVCddKSl7AnECbQABU0NSSVBUX0ZJTEVOQU1FAoMwQCAgBH8EdCA9IHN0CpJsYWNlKCASAydcXAiQJy8AUHN1YnN0cigDtwXOFEQsIDAAMC0CYGxlbgKYUEhQC3BMRsfgB+ENMX07IAAwCvENbw1vD9ANbVBBVEhfAC9UUkFOU0xBVEVEBYF7FLAJtxHcDW///w1tC0AZ4Q9SD0APYwBiBVcHbw7gADAPHw8fDxIKMAAyACByZXF1aXJlX29uFjBkaXJuYQgAbWUoXxpSX18pIC4nL2NvbmZWAy4joCcS8SADDwMOYWxsYmFjawxwA3+gBQZ/RQZ0c2VydmVyL2NsYSXQcwCADwBzX2RiBB8EHwQfBBdhdGFhcnJhefDwBI8EjwSPBIpncmlkBH8EfwR/BHZ1dGls+NAEPwQ/BD8ENhjQdHJvBG8cD0wEbGFkb2QQgGI1LwByLmluYwiXICBkZWZpbgEAZSgnR1JJRDHgU1NJT05fS0VHm1k2oCdfbyQgAZEgAgKlSlEBMTqQVwMgAqQgAGlkAjkiQ0hFQ0tCT1giLCAiAGBjaGVja2JveCIkQQREIlNFTEUgQUNUAfFzZWxlY3QB2k1VTFRJAicEAG11bHRpAnggPz4="));
		// echo "</pre>";
		// $encoded = "QAAAPD9waHAgICBlcnJvcl9yZQABcG9ydGluZyhFX0FMTCk7AaAAACBpbmlfc2V0KCdkaXNwbGEggHlfAsJzJywgMQITICBpZighaUAAcwJRJF9TRVJWRVJbJ0RPQ1UAA01FTlRfUk9PVCddKSl7AnECbQABU0NSSVBUX0ZJTEVOQU1FAoMwQCAgBH8EdCA9IHN0CpJsYWNlKCASAydcXAiQJy8AUHN1YnN0cigDtwXOFEQsIDAAMC0CYGxlbgKYUEhQC3BMRsfgB+ENMX07IAAwCvENbw1vD9ANbVBBVEhfAC9UUkFOU0xBVEVEBYF7FLAJtxHcDW///w1tC0AZ4Q9SD0APYwBiBVcHbw7gADAPHw8fDxIKMAAyACByZXF1aXJlX29uFjBkaXJuYQgAbWUoXxpSX18pIC4nL2NvbmZWAy4joCcS8SADDwMOYWxsYmFjawxwA3+gBQZ/RQZ0c2VydmVyL2NsYSXQcwCADwBzX2RiBB8EHwQfBBdhdGFhcnJhefDwBI8EjwSPBIpncmlkBH8EfwR/BHZ1dGls+NAEPwQ/BD8ENhjQdHJvBG8cD0wEbGFkb2QQgGI1LwByLmluYwiXICBkZWZpbgEAZSgnR1JJRDHgU1NJT05fS0VHm1k2oCdfbyQgAZEgAgKlSlEBMTqQVwMgAqQgAGlkAjkiQ0hFQ0tCT1giLCAiAGBjaGVja2JveCIkQQREIlNFTEUgQUNUAfFzZWxlY3QB2k1VTFRJAicEAG11bHRpAnggPz4=";
		// $encoded = base64_encode('It would seem from the comment preceding the code which was removed that the treatment of the space as if it');
		// echo $encoded."\n";
		// for($i=0, $len=strlen($encoded); $i<$len; $i+=4){
		// echo base64_decode( substr($encoded, $i, 4) );
		// }
	}

	function dashboard_pie_total_phd_all_monthly( $year=NULL, $month=NULL ) {
		if (!$this->ion_auth->logged_in())
			redirect('main', 'refresh');
		
		$table	 = 'vTotal_PHD_ALL_Monthly';
		$columns = NULL;
		$sort	 = !empty($sort) ? $sort : 'company_id';
		$order	 = !empty($order) ? $order : 'asc';
		$where	 = NULL;
		$where['year']  = !empty($year) ? $year : date("Y");
		$where['month'] = !empty($month) ? $month : date("m");
		$page 	= 1; 
		$rows 	= 10;
		$like 	 = NULL;
		// $like['code']	= $q;
		// $like['name']	= $q;
		
		$result = $this->shared_model->get_dashboard_data($table, $columns, $where, $page, $rows, $sort, $order, $like, TRUE);
		
		foreach ($result as $key=>$val) {
			if ( $val['total'] < 20 )
				$data[] = array( 'data'=>array(array(0, $val['total'])), 'label'=>$val['status_name'], 'pie'=>array('explode'=>20) );
			else
				$data[] = array( 'data'=>array(array(0, $val['total'])), 'label'=>$val['status_name'] );
		}
		
		echo json_encode($data);
	}
	
	function dashboard_pie_total_phd_all_yearly( $year=NULL ) {
		if (!$this->ion_auth->logged_in())
			redirect('main', 'refresh');
		
		$table	 = 'vTotal_PHD_ALL_Yearly';
		$columns = NULL;
		$sort	 = !empty($sort) ? $sort : 'company_id';
		$order	 = !empty($order) ? $order : 'asc';
		$where	 = NULL;
		$where['year']  = !empty($year) ? $year : date("Y");
		$page 	= 1; 
		$rows 	= 10;
		$like 	 = NULL;
		// $like['code']	= $q;
		// $like['name']	= $q;
		
		$result = $this->shared_model->get_dashboard_data($table, $columns, $where, $page, $rows, $sort, $order, $like, TRUE);
		
		foreach ($result as $key=>$val) {
			if ( $val['total'] < 20 )
				$data[] = array( 'data'=>array(array(0, $val['total'])), 'label'=>$val['status_name'], 'pie'=>array('explode'=>20) );
			else
				$data[] = array( 'data'=>array(array(0, $val['total'])), 'label'=>$val['status_name'] );
		}
		
		echo json_encode($data);
	}
	
	function dashboard_pie_total_phd_branch_monthly( $year=NULL, $month=NULL, $branch_id=NULL ) {
		if (!$this->ion_auth->logged_in())
			redirect('main', 'refresh');
		
		$table	 = 'vTotal_PHD_BRANCH_Monthly';
		$columns = NULL;
		$sort	 = !empty($sort) ? $sort : 'company_id';
		$order	 = !empty($order) ? $order : 'asc';
		$where	 = NULL;
		$where['year']  = !empty($year) ? $year : date("Y");
		$where['month'] = !empty($month) ? $month : date("m");
		$where['branch_id'] = !empty($branch_id) ? $branch_id : $this->session->userdata('branch_id');
		$page 	= 1; 
		$rows 	= 10;
		$like 	 = NULL;
		// $like['code']	= $q;
		// $like['name']	= $q;
		
		$result = $this->shared_model->get_dashboard_data($table, $columns, $where, $page, $rows, $sort, $order, $like);
		
		foreach ($result as $key=>$val) {
			if ( $val['total'] < 5 )
				$data[] = array( 'data'=>array(array(0, $val['total'])), 'label'=>$val['status_name'], 'pie'=>array('explode'=>20) );
			else
				$data[] = array( 'data'=>array(array(0, $val['total'])), 'label'=>$val['status_name'] );
		}
		
		echo json_encode($data);
	}
	
	function dashboard_pie_total_phd_branch_yearly( $year=NULL, $branch_id=NULL ) {
		if (!$this->ion_auth->logged_in())
			redirect('main', 'refresh');
		
		$table	 = 'vTotal_PHD_BRANCH_Yearly';
		$columns = NULL;
		$sort	 = !empty($sort) ? $sort : 'company_id';
		$order	 = !empty($order) ? $order : 'asc';
		$where	 = NULL;
		$where['year']  = !empty($year) ? $year : date("Y");
		$where['branch_id'] = !empty($branch_id) ? $branch_id : $this->session->userdata('branch_id');
		$page 	= 1; 
		$rows 	= 10;
		$like 	 = NULL;
		// $like['code']	= $q;
		// $like['name']	= $q;
		
		$result = $this->shared_model->get_dashboard_data($table, $columns, $where, $page, $rows, $sort, $order, $like);
		
		foreach ($result as $key=>$val) {
			if ( $val['total'] < 20 )
				$data[] = array( 'data'=>array(array(0, $val['total'])), 'label'=>$val['status_name'], 'pie'=>array('explode'=>20) );
			else
				$data[] = array( 'data'=>array(array(0, $val['total'])), 'label'=>$val['status_name'] );
		}
		
		echo json_encode($data);
	}
	
	function dashboard_pie_total_phd_routes_all_monthly( $year=NULL, $month=NULL ) {
		if (!$this->ion_auth->logged_in())
			redirect('main', 'refresh');
		
		$table	 = 'vTotal_PHD_ROUTES_ALL_Monthly';
		$columns = NULL;
		$sort	 = !empty($sort) ? $sort : 'company_id';
		$order	 = !empty($order) ? $order : 'asc';
		$where	 = NULL;
		$where['year']  = !empty($year) ? $year : date("Y");
		$where['month'] = !empty($month) ? $month : date("m");
		$page 	= 1; 
		$rows 	= 10;
		$like 	 = NULL;
		// $like['code']	= $q;
		// $like['name']	= $q;
		
		$result = $this->shared_model->get_dashboard_data($table, $columns, $where, $page, $rows, $sort, $order, $like, TRUE);
		
		foreach ($result as $key=>$val) {
			if ( $val['total'] < 20 )
				$data[] = array( 'data'=>array(array(0, $val['total'])), 'label'=>$val['status_name'], 'pie'=>array('explode'=>20) );
			else
				$data[] = array( 'data'=>array(array(0, $val['total'])), 'label'=>$val['status_name'] );
		}
		
		echo json_encode($data);
	}
	
	function dashboard_pie_total_phd_routes_all_yearly( $year=NULL ) {
		if (!$this->ion_auth->logged_in())
			redirect('main', 'refresh');
		
		$table	 = 'vTotal_PHD_ROUTES_ALL_Yearly';
		$columns = NULL;
		$sort	 = !empty($sort) ? $sort : 'company_id';
		$order	 = !empty($order) ? $order : 'asc';
		$where	 = NULL;
		$where['year']  = !empty($year) ? $year : date("Y");
		$page 	= 1; 
		$rows 	= 10;
		$like 	 = NULL;
		// $like['code']	= $q;
		// $like['name']	= $q;
		
		$result = $this->shared_model->get_dashboard_data($table, $columns, $where, $page, $rows, $sort, $order, $like, TRUE);
		
		foreach ($result as $key=>$val) {
			if ( $val['total'] < 20 )
				$data[] = array( 'data'=>array(array(0, $val['total'])), 'label'=>$val['status_name'], 'pie'=>array('explode'=>20) );
			else
				$data[] = array( 'data'=>array(array(0, $val['total'])), 'label'=>$val['status_name'] );
		}
		
		echo json_encode($data);
	}
	
	function dashboard_total_phd_routes_branch_monthly( $year=NULL, $month=NULL, $branch_id=NULL ) {
		if (!$this->ion_auth->logged_in())
			redirect('main', 'refresh');
		
		$table	 = 'vTotal_PHD_ROUTES_BRANCH_Monthly';
		$columns = NULL;
		$sort	 = !empty($sort) ? $sort : 'company_id';
		$order	 = !empty($order) ? $order : 'asc';
		$where	 = NULL;
		$where['year']  = !empty($year) ? $year : date("Y");
		$where['month'] = !empty($month) ? $month : date("m");
		$where['branch_id'] = !empty($branch_id) ? $branch_id : $this->session->userdata('branch_id');
		$page 	= 1; 
		$rows 	= 10;
		$like 	 = NULL;
		// $like['code']	= $q;
		// $like['name']	= $q;
		
		$result = $this->shared_model->get_dashboard_data($table, $columns, $where, $page, $rows, $sort, $order, $like);
		
		foreach ($result as $key=>$val) {
			if ( $val['total'] < 20 )
				$data[] = array( 'data'=>array(array(0, $val['total'])), 'label'=>$val['status_name'], 'pie'=>array('explode'=>20) );
			else
				$data[] = array( 'data'=>array(array(0, $val['total'])), 'label'=>$val['status_name'] );
		}
		
		echo json_encode($data);
	}
	
	function dashboard_total_phd_routes_branch_yearly( $year=NULL, $branch_id=NULL ) {
		if (!$this->ion_auth->logged_in())
			redirect('main', 'refresh');
		
		$table	 = 'vTotal_PHD_ROUTES_BRANCH_Yearly';
		$columns = NULL;
		$sort	 = !empty($sort) ? $sort : 'company_id';
		$order	 = !empty($order) ? $order : 'asc';
		$where	 = NULL;
		$where['year']  = !empty($year) ? $year : date("Y");
		$where['branch_id'] = !empty($branch_id) ? $branch_id : $this->session->userdata('branch_id');
		$page 	= 1; 
		$rows 	= 10;
		$like 	 = NULL;
		// $like['code']	= $q;
		// $like['name']	= $q;
		
		$result = $this->shared_model->get_dashboard_data($table, $columns, $where, $page, $rows, $sort, $order, $like);
		
		foreach ($result as $key=>$val) {
			if ( $val['total'] < 20 )
				$data[] = array( 'data'=>array(array(0, $val['total'])), 'label'=>$val['status_name'], 'pie'=>array('explode'=>20) );
			else
				$data[] = array( 'data'=>array(array(0, $val['total'])), 'label'=>$val['status_name'] );
		}
		
		echo json_encode($data);
	}
	
	function dashboard_table_today_phd_updates() {
		if (!$this->ion_auth->logged_in())
			redirect('main', 'refresh');
		
		$table	 = 'vnotification_email';
		$columns = array('phd_code', 'phd_status', 'phd_id');
		$sort	 = !empty($sort) ? $sort : 'company_id';
		$order	 = !empty($order) ? $order : 'asc';
		$where	 = NULL;
		$where['company_id']  	= $this->session->userdata('company_id');
		$where['branch_id'] 	= $this->session->userdata('branch_id');
		$where['department_id'] = $this->session->userdata('department_id');
		$where['create_date']  	= date('Y-m-d');
		$page 	= 1; 
		$rows 	= 100;
		$like 	 = NULL;
		// $like['code']	= $q;
		// $like['name']	= $q;
		
		$result = $this->shared_model->get_dashboard_data($table, $columns, $where, $page, $rows, $sort, $order, $like, true);
		
		foreach ($result as $key=>$val) {
			$data[] = array( $val['phd_code'], $val['phd_status'], $val['phd_id'] );
		}
		
		echo json_encode($data);
	}
	
//TODO: IMPORT FROM EXCELL TO MYSQL

//TODO: Rapikan DASHBOARD
}