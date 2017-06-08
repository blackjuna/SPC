<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

// session_start(); //we need to call PHP's session object to access it through CI

class Systems extends CI_Controller {

	private $mdl_grp	= 'systems';
		
	function __construct() {
		parent::__construct();
		date_default_timezone_set('Asia/Jakarta');
		
		$this->load->model('systems_model');
	}

	function index() {
		if (!$this->ion_auth->logged_in())
			redirect('main', 'refresh');
		
		redirect('propertymax', 'refresh');
	}

	function core_update_notif() {
		set_comet("sys_reload", 'INFO : Genesys System has been updated. After this message the browser will be refresh....!');
	}
	
	function logout() {
		redirect('auth/logout', 'refresh');
	}

	function get_login() {
		// $this->session->sess_expiration = 60*60*24*31;

		if (!$this->ion_auth->logged_in())
			echo json_encode(array('login'=>0));
		else
			echo json_encode(array('login'=>1));
	}

	function get_themes() {
		if (!$this->ion_auth->logged_in())
			redirect('main', 'refresh');
		
		$theme = $this->systems_model->getTheme_ByUserId(sesUser()->id);
		$themes = $this->systems_model->getTheme();
		foreach ($themes as $key => $row) {
			$options[$key] = $row;
			if ($row->id == $theme->theme_id) 
				$options[$key]->selected = TRUE;
		}
		
		echo json_encode($options);
	}

	function set_themes() {
		if (!$this->ion_auth->logged_in())
			redirect('main', 'refresh');
		
		$data = $this->input->post();
		if ( empty($data) ) return;
		
		$this->db->update('users_themes', $data, array('user_id'=>sesUser()->id));
	}

	function get_company() {
		if (!$this->ion_auth->logged_in())
			redirect('main', 'refresh');
		
		$page 	= $this->input->post('page');
		$rows 	= $this->input->post('rows');
		$sort 	= $this->input->post('sort');
		$order 	= $this->input->post('order');
		$q 		= $this->input->post('q'); 
		
		$table	 = 'company';
		$columns = NULL;
		$sort	 = !empty($sort)?$sort:'code';
		$order	 = !empty($order)?$order:'asc';
		$where	 = NULL;
		$like 	 = NULL;
		
		$result = $this->shared_model->get_easyui_data($table, $columns, $where, $page, $rows, $sort, $order, $like);
		
		echo json_encode($result);
	}

	function get_company_by_user() {
		if (!$this->ion_auth->logged_in())
			redirect('main', 'refresh');
		
		$params = $this->input->post();
		$params['where']['user_id'] = sesUser()->id;
		crud_result( $this->systems_model->getCompany_ByUser($params) );
		
	}

	function set_company_by_user() {
		if (!$this->ion_auth->logged_in())
			redirect('main', 'refresh');
		
		$data = $this->input->post();
		
		if ( empty($data) ) 
			return;
			
		$this->session->set_userdata($data);
	}

	function get_branch() {
		if (!$this->ion_auth->logged_in())
			redirect('main', 'refresh');
		
		$page 	= $this->input->post('page');
		$rows 	= $this->input->post('rows');
		$sort 	= $this->input->post('sort');
		$order 	= $this->input->post('order');
		$q 		= $this->input->post('q'); 
		
		$table	 = 'branch';
		$columns = NULL;
		$sort	 = !empty($sort)?$sort:'code';
		$order	 = !empty($order)?$order:'asc';
		$where	 = NULL;
		$like 	 = NULL;
		
		$result = $this->shared_model->get_easyui_data($table, $columns, $where, $page, $rows, $sort, $order, $like);
		
		echo json_encode($result);
	}

	function get_branch_by_user() {
		if (!$this->ion_auth->logged_in())
			redirect('main', 'refresh');
		
		$params = $this->input->post();
		$params['where']['user_id'] = sesUser()->id;

		crud_result( $this->systems_model->getBranch_ByUser($params) );
	}

	function set_branch_by_user() {
		if (!$this->ion_auth->logged_in())
			redirect('main', 'refresh');
		
		$data = $this->input->post();
		
		if ( empty($data) ) 
			return;
			
		$this->session->set_userdata($data);
	}

	function get_department() {
		if (!$this->ion_auth->logged_in())
			redirect('main', 'refresh');
		
		$page 	= $this->input->post('page');
		$rows 	= $this->input->post('rows');
		$sort 	= $this->input->post('sort');
		$order 	= $this->input->post('order');
		$q 		= $this->input->post('q'); 
		
		$table	 = 'department';
		$columns = NULL;
		$sort	 = !empty($sort)?$sort:'code';
		$order	 = !empty($order)?$order:'asc';
		$where	 = NULL;
		$like 	 = NULL;
		
		$result = $this->shared_model->get_easyui_data($table, $columns, $where, $page, $rows, $sort, $order, $like);
		
		echo json_encode($result);
	}

	function get_department_by_user() {
		if (!$this->ion_auth->logged_in())
			redirect('main', 'refresh');
		
		$params = $this->input->post();
		$params['where']['user_id'] = sesUser()->id;
		crud_result( $this->systems_model->getDepartment_ByUser($params) );
	}

	function set_department_by_user() {
		if (!$this->ion_auth->logged_in())
			redirect('main', 'refresh');
		
		$data = $this->input->post();
		
		if ( empty($data) ) 
			return;
			
		$this->session->set_userdata($data);
	}

	function get_currency() {
		if (!$this->ion_auth->logged_in())
			redirect('main', 'refresh');
		
		$page 	= $this->input->post('page');
		$rows 	= $this->input->post('rows');
		$sort 	= $this->input->post('sort');
		$order 	= $this->input->post('order');
		$q 		= $this->input->post('q'); 
		
		$table	 = 'currency';
		$columns = null;
		$sort	 = !empty($sort)?$sort:'code';
		$order	 = !empty($order)?$order:'asc';
		$where	 = null;
		$like 	 = NULL;
		$like['(id']  = $q;
		$like['code'] = $q;
		$like['name'] = $q;
		
		$result = $this->shared_model->get_easyui_data($table, $columns, $where, $page, $rows, $sort, $order, $like);
		
		echo json_encode($result);
	}

	function get_currency_id() {
		if (!$this->ion_auth->logged_in())
			redirect('main', 'refresh');
		
		$company_id = $this->session->userdata('company_id');
		
		return $this->db->get_where("company", array('id'=>$company_id), 1)->row()->currency_id;
	}

	function settings() 
	{
		$mdl = 'settings';
		$this->getme_lib->go( $this->mdl_grp, $mdl );
	}
	
	function test()
	{
		$data = (array) $this->systems_model->getUsers_ById(sesUser(FALSE));
		var_dump($data);
	}
	
	function profile( $action=NULL ) 
	{
		$mdl = 'profile';
		
		if ( $action == 'r' ) {
			$data = (array) $this->systems_model->getUsers_ById(sesUser(FALSE));
			
			$data['profile_pic'] = file_exists(base_url('assets/images/user/'.$data['id'].'.jpg')) ? $data['id'] : 'no_photo';
			$date = new DateTime("@".$data['last_login']);
			$data['last_login'] = $date->format('D, d M Y h:i A');
			$data['image']  	= empty($data['image']) ? "no_photo.jpg" : $data['image'];
			
			$this->getme_lib->go( $this->mdl_grp, $mdl, $data );
		}
		
		if ( $action == 'u' ) {
			$datas = $this->input->post();
			if ( empty($datas) ) 
				crud_error("Error: Empty Data !");
				
			parse_str($datas['formData'], $data);
			
			$this->db->trans_begin();
			try {
				
				$data1['first_name']  	= $data['first_name'];
				$data1['last_name']  	= $data['last_name'];
				$data1['phone']  		= $data['phone'];
				$data1['email']  		= $data['email'];
				$data1['modify_by']   	= sesUser(FALSE);
				$data1['modify_date'] 	= date('Y-m-d H:i:s');
				$this->db->update( 'users', $data1, array('id'=>$data['id']) );
				
			} catch (Exception $e) {  
				crud_error( $e->getMessage() );
			} 
			
			$this->db->trans_commit();
			crud_success();
		}
	
		if ( $action == 'update_picture' ) {
			$data = $this->input->post();

			// UPLOAD FILE IF EXISTS
			$this->load->library('Plupload');
			$oPlupload = new PluploadHandler();
			$oPlupload->no_cache_headers();
			$oPlupload->cors_headers();
			
			// CREATE FILE PATH & INIT OPTIONS FOR UPLOAD
			// $sub_path = $data['id'] . ( empty($data['ticket_activity_id']) ? '' : '/'.$data['ticket_activity_id'] );
			$filepath = './assets/images/user/';
			// $filepath = "./attachments/ticketing/$sub_path/";
			// if ( !is_dir($filepath) )
				// if ( !mkdir($filepath, 0777, true) ) 	// mkdir if not exists
					// crud_error("Error: Failed to create folders...! !");
			
			$config['target_dir'] 	 	= (empty($filepath) ? "./tmp/" : $filepath);
			$config['allow_extensions'] = 'jpg,jpeg,png';
			if ( !$result = $oPlupload->handle($config) )
				crud_error( array(
					'errCode' 	  => $oPlupload->get_error_code(),
					'errMessage' => $oPlupload->get_error_message()
					) 
				);
				
			if ( !empty($result['name']) ) {
				$data2['image']		= $result['name'];
				$this->db->update('users', $data2, array('id'=>$data['id']));
				// set_comet('data_reload', 'ticket_files');
				crud_success();
			}
		}
		
		if ( $action == 'remove_picture' ) {
			$data = $this->input->post();
			if ( empty($data) ) 
				crud_error("Error: Empty Data !");
				
			$this->db->trans_begin();
			try {
				
				$data1['image']  		= NULL;
				$data1['modify_by']   	= sesUser(FALSE);
				$data1['modify_date'] 	= date('Y-m-d H:i:s');
				$this->db->update( 'users', $data1, array('id'=>$data['id']) );
				
			} catch (Exception $e) {  
				crud_error( $e->getMessage() );
			} 
			
			$this->db->trans_commit();
			crud_success();
		}
	}
	
	// CRUD SYSTEMS
	function change_pwd( $action=NULL )
	{
		if (!$this->ion_auth->logged_in()) 
			redirect('main', 'refresh');

		$mdl 	= 'change_pwd';
        
		if ( $action == 'u' ) {
			$data = $this->input->post();
			if ( empty($data) ) return;
			
			$identity = $this->session->userdata($this->config->item('identity', 'ion_auth'));

			$change = $this->ion_auth->change_password( $identity, $data['old'], $data['new'] );
			
			if ( !$change )	
				crud_error( 'error_old_password' );
			
			crud_success();
		}
		
		if ( !is_allow('r', $this->mdl_grp, $mdl) )
			show_error(l('permission_failed_menu'));
		
		$this->getme_lib->go( $this->mdl_grp, $mdl );
	}
	
	function reset_pwd( $action=NULL )
	{
		if (!$this->ion_auth->logged_in()) 
			redirect('main', 'refresh');

		$data = $this->input->post();
		if ( empty($data) ) return;
		
		$identity = $this->systems_model->getUsers_ById($data['id'])->username;
		
		$change = $this->ion_auth->reset_password( $identity, $data['password_new'] );
		
		if ( !$change )	
			crud_error( 'error_old_password' );
		
		crud_success();
	}
	
	function users( $action=NULL ) {
		if (!$this->ion_auth->logged_in())
			redirect('main', 'refresh');
		
		$mdl = 'users';
		
		if ( $action == 'c' ) {
			$data = $this->input->post();
			if ( empty($data) ) 
				crud_error("Error: Empty Data !");
			
			$this->db->trans_begin();
			
			// {begin} => procedure check duplicate value [code]
			if ( $this->shared_model->is_duplicate_username($mdl, $data['username_new']) ) 
				crud_error("error_duplicate_code");
			
			$data1['username'] 	 = strtolower($data['username_new']);
			$data1['password'] 	 = $data['password_new'];
			$data1['active'] 	 = array_key_exists('active', $data) ? 1 : 0; // procedure pengecekan input type: checkbox
			$data1['first_name'] = strtoupper($data['first_name']);
			$data1['last_name']  = strtoupper($data['last_name']);
			$data1['phone'] 	 = $data['phone'];
			$data1['email'] 	 = $data['email'];
			$data1['groups'] 	 = empty($data['groups']) ? NULL : explode(",", $data['groups']);
			$data1['companies']  = empty($data['companies']) ? NULL : explode(",", $data['companies']);
			$data1['branch'] 	 = empty($data['branch']) ? NULL : explode(",", $data['branch']);
			$data1['department'] = empty($data['department']) ? NULL : explode(",", $data['department']);
			
			if ( ($id = $this->ion_auth_model->register($data1['username'], $data1['password'], $data['email'], $data1, $data1['groups'])) == FALSE ) {
				echo json_encode( array("errorMsg"=>$this->ion_auth_model->errors()) );
				return;
			}
				
			// $this->shared_model->update_relation_n_n( 'users_groups', 'user_id', $id, 'group_id', $data['groups'] );
			$this->shared_model->update_relation_n_n( 'users_company', 'user_id', $id, 'company_id', $data1['companies'] );
			$this->shared_model->update_relation_n_n( 'users_branch', 'user_id', $id, 'branch_id', $data1['branch'] );
			$this->shared_model->update_relation_n_n( 'users_department', 'user_id', $id, 'department_id', $data1['department'] );
			
			$data2['user_id'] 	  = $id;
			$data2['salesman_id'] = array_key_exists('salesman_id', $data) ? $data['salesman_id'] : NULL;
			$data2['phd_status_respond'] 	= array_key_exists('phd_status_respond', $data) ? 1 : 0;
			$data2['phd_status_partial'] 	= array_key_exists('phd_status_partial', $data) ? 1 : 0;
			$data2['phd_status_done'] 	 	= array_key_exists('phd_status_done', $data) ? 1 : 0;
			$data2['phd_status_revised'] 	= array_key_exists('phd_status_revised', $data) ? 1 : 0;
			$data2['phd_status_cancel'] 	= array_key_exists('phd_status_cancel', $data) ? 1 : 0;
			$data2['phd_status_noquote'] 	= array_key_exists('phd_status_noquote', $data) ? 1 : 0;
			$data2['phd_status_reject'] 	= array_key_exists('phd_status_reject', $data) ? 1 : 0;
			$data2['phd_status_notprocess'] = array_key_exists('phd_status_notprocess', $data) ? 1 : 0;
			$data2['phd_status_pricelist'] 	= array_key_exists('phd_status_pricelist', $data) ? 1 : 0;
			$this->db->insert( 'users_settings', $data2 );
			
			$this->db->trans_commit();
			crud_success();
		}

		if ( $action == 'r' ) {
			$params = $this->input->post();
			
			if (sesUser()->id != 1)
				$params['where']['u.id <>'] = 1;
			
			if ( !empty($params['q']) )
			{
				$params['like']['u.id'] = $params['q'];
				$params['like']['u.username'] = $params['q'];
				$params['like']['u.first_name'] = $params['q'];
				$params['like']['u.last_name'] = $params['q'];
			}	
			
			if ( !empty($params['findKey']) && !empty($params['findVal']) )
				if ( $params['findKey']=='ALL' ) 
				{
					$params['like']['u.username'] = $params['findVal'];
					$params['like']['u.first_name'] = $params['findVal'];
					$params['like']['u.last_name'] = $params['findVal'];
				} 
				else
					$params['like']['u.'.$params['findKey']] = $params['findVal'];

			crud_result( $this->systems_model->getUsers($params) );
		}

		if ( $action == 'u' ) {
			$data = $this->input->post();
			if ( empty($data) ) 
				crud_error("Error: Empty Data !");
			
			$this->db->trans_begin();
			
			// {begin} => check duplicate value [code]
			if ( $data['username'] != $data['username_new'] )
				if ( $this->shared_model->is_duplicate_username($mdl, $data['username_new']) ) 
					crud_error('error_duplicate_code');
			
			$id	= $data['id'];
			$data1['username'] 	 = $data['username_new'];
			$data1['password'] 	 = $data['password_new'];
			$data1['active'] 	 = array_key_exists('active', $data) ? 1 : 0; // procedure pengecekan input type: checkbox
			$data1['first_name'] = strtoupper($data['first_name']);
			$data1['last_name']  = strtoupper($data['last_name']);
			$data1['phone'] 	 = $data['phone'];
			$data1['email'] 	 = $data['email'];
			$data1['groups'] 	 = explode(",", $data['groups']);
			$data1['companies']  = explode(",", $data['companies']);
			$data1['branch'] 	 = explode(",", $data['branch']);
			$data1['department'] = explode(",", $data['department']);
			
			if ( !$this->ion_auth_model->update($id, $data1) ) {
				echo json_encode( array("errorMsg"=>$this->ion_auth_model->errors()) );
				return;
			}
			
			$this->shared_model->update_relation_n_n( 'users_groups', 'user_id', $id, 'group_id', $data1['groups'] );
			$this->shared_model->update_relation_n_n( 'users_company', 'user_id', $id, 'company_id', $data1['companies'] );
			$this->shared_model->update_relation_n_n( 'users_branch', 'user_id', $id, 'branch_id', $data1['branch'] );
			$this->shared_model->update_relation_n_n( 'users_department', 'user_id', $id, 'department_id', $data1['department'] );
			
			$data2['salesman_id'] = array_key_exists('salesman_id', $data) ? $data['salesman_id'] : NULL;
			$data2['phd_status_respond'] 	= array_key_exists('phd_status_respond', $data) ? 1 : 0;
			$data2['phd_status_partial'] 	= array_key_exists('phd_status_partial', $data) ? 1 : 0;
			$data2['phd_status_done'] 	 	= array_key_exists('phd_status_done', $data) ? 1 : 0;
			$data2['phd_status_revised'] 	= array_key_exists('phd_status_revised', $data) ? 1 : 0;
			$data2['phd_status_cancel'] 	= array_key_exists('phd_status_cancel', $data) ? 1 : 0;
			$data2['phd_status_noquote'] 	= array_key_exists('phd_status_noquote', $data) ? 1 : 0;
			$data2['phd_status_reject'] 	= array_key_exists('phd_status_reject', $data) ? 1 : 0;
			$data2['phd_status_notprocess'] = array_key_exists('phd_status_notprocess', $data) ? 1 : 0;
			$data2['phd_status_pricelist'] 	= array_key_exists('phd_status_pricelist', $data) ? 1 : 0;
			$this->db->update( 'users_settings', $data2, array('user_id'=>$id) );
			
			/* try {
				$this->db->update($mdl, $data, array('id'=>$id));
			} catch (Exception $e) {  
				crud_error( $e->getMessage() );
			}  */
			
			$this->db->trans_commit();
			crud_success();
		}

		if ( $action == 'd' ) {
			$data = $this->input->post();
			if ( empty($data) ) 
				crud_error("Error: Empty Data !");
			
			if ( $data['id']==1 )
				crud_error("Error: This is a Administrator Account !");
			
			$this->db->trans_begin();
			
			try {
			
				$data1['deleted']     = 1;
				$data1['modify_by']   = sesUser()->id;
				$data1['modify_date'] = date('Y-m-d H:i:s');
				$this->db->update( 'users', $data1, array('id'=>$data['id']) );
				// $this->db->delete( 'users', array('id'=>$data['id']) );
				
			} catch (Exception $e) {  
				crud_error($e->getMessage());
			} 
			$this->db->trans_commit();
			crud_success();
		}

		if ( $action == 'active' ) {
			$data = $this->input->post();
			
			// ============= VALIDITY SECTION
			if ( empty($data) ) 
				crud_error("Error: Empty Data !");
			
			// ============= CRUD SECTION
			$this->db->trans_begin();
			try {
			
				$active = $this->db->get_where( 'users', array('id'=>$data['id']) )->row()->active;
				$active = !$active;
				
				$this->db->update( 'users', array('active'=>$active), array('id'=>$data['id']) );
				
			} catch (Exception $e) {  
				crud_error( $e->getMessage() );
			} 
			
			$this->db->trans_commit();
			crud_success();
		}

		if ( $action == 'change_pwd' ) {
			$data = $this->input->post();
			if ( empty($data) ) return;
			
			$identity = $this->session->userdata($this->config->item('identity', 'ion_auth'));

			$change = $this->ion_auth->change_password( $identity, $data['old'], $data['new'] );
			
			if ( !$change )	
				crud_error( 'error_old_password' );
			
			crud_success();
		}

		if ( !is_allow('r', $this->mdl_grp, $mdl) )
			show_error(l('permission_failed_menu'));
		
		$this->getme_lib->go( $this->mdl_grp, $mdl );
	}
	
	function users_list( $action=NULL ) {
		if (!$this->ion_auth->logged_in())
			redirect('main', 'refresh');
		
		$mdl = 'users';
		
		if ( $action == 'r' ) {
			$params = $this->input->post();
			
			$params['order'] = 'asc';
			$params['sort']	 = 'first_name';
			$params['where']['active'] = 1;
			if (sesUser()->id != 1)
				$params['where']['u.id <>'] = 1;
			
			if ( !empty($params['q']) )
			{
				$params['like']['u.id'] = $params['q'];
				$params['like']['u.username'] = $params['q'];
				$params['like']['u.first_name'] = $params['q'];
				$params['like']['u.last_name'] = $params['q'];
				$params['like']['u.email'] = $params['q'];
			}	
			
			if ( !empty($params['findKey']) && !empty($params['findVal']) )
				if ( $params['findKey']=='ALL' ) 
				{
					$params['like']['u.username'] = $params['findVal'];
					$params['like']['u.first_name'] = $params['findVal'];
					$params['like']['u.last_name'] = $params['findVal'];
				} 
				else
					$params['like']['u.'.$params['findKey']] = $params['findVal'];

			crud_result( $this->systems_model->getUsers($params) );
		}

	}
	
	function groups( $action=NULL )	{
		if (!$this->ion_auth->logged_in())
			redirect('main', 'refresh');
		
		$mdl = 'groups';
		
		if ( $action == 'c' ) {
			$data = $this->input->post();
			if ( empty($data) ) 
				crud_error("Error: Empty Data !");
			
			$this->db->trans_begin();
			
			// {begin} => procedure check duplicate value [code]
			if ( $this->shared_model->is_duplicate_code($mdl, $data['code_new']) ) 
				crud_error("error_duplicate_code");
			
			try {
			
				$data1['code'] = strtoupper($data['code_new']);
				$data1['name'] = strtoupper($data['name']);
				$this->db->insert($mdl, $data1);
				
			} catch (Exception $e) {  
				crud_error($e->getMessage());
			} 
			
			$this->db->trans_commit();
			crud_success();
		}

		if ( $action == 'r' ) {
			$params = $this->input->post();
			
			if (sesUser()->id != 1)
				$params['where']['id <>'] = 1;
			
			if ( !empty($params['q']) )
			{
				$params['like']['code'] = $params['q'];
				$params['like']['name'] = $params['q'];
			}	
			
			if ( !empty($params['findKey']) && !empty($params['findVal']) )
				if ( $params['findKey']=='ALL' ) 
				{
					$params['like']['code'] = $params['findVal'];
					$params['like']['name'] = $params['findVal'];
				} 
				else
					$params['like'][$params['findKey']] = $params['findVal'];

			crud_result( $this->systems_model->getGroups($params) );
		}

		if ( $action == 'u' ) {
			$data = $this->input->post();
			if ( empty($data) ) 
				crud_error("Error: Empty Data !");
			
			$this->db->trans_begin();
			
			// {begin} => check duplicate value [code]
			if ( $data['code'] != $data['code_new'] )
				if ( $this->shared_model->is_duplicate_code($mdl, $data['code_new']) ) 
					crud_error('error_duplicate_code');
			
			try {
			
				$data1['code'] = strtoupper($data['code_new']);
				$data1['name'] = strtoupper($data['name']);
				$this->db->update($mdl, $data1, array('id'=>$data['id']));
				
			} catch (Exception $e) {  
				crud_error($e->getMessage());
			} 
			
			$this->db->trans_commit();
			crud_success();
		}

		if ( $action == 'd' ) {
			$data = $this->input->post();
			if ( empty($data) ) 
				crud_error("Error: Empty Data !");
			
			$this->db->trans_begin();
			
			// {begin} check if this data has already have transaction
			// if ( $this->shared_model->is_data_exists_on( 'users_groups', array('group_id'), $id) ) {
				// echo json_encode( array("errorMsg"=>l('error_data_transaction')) );
				// return;
			// } 
			// {end}
			
			try {
			
				$data1['deleted']     = 1;
				$data1['modify_by']   = sesUser()->id;
				$data1['modify_date'] = date('Y-m-d H:i:s');
				$this->db->update( 'groups', $data1, array('id'=>$data['id']) );
				
			} catch (Exception $e) {  
				crud_error( $e->getMessage() );
			} 
			
			$this->db->trans_commit();
			crud_success();
		}

		if ( !is_allow('r', $this->mdl_grp, $mdl) )
			show_error(l('permission_failed_menu'));
		
		$this->getme_lib->go( $this->mdl_grp, $mdl );
	}
	
	function groups_auth( $action=NULL )	{
		if (!$this->ion_auth->logged_in())
			redirect('main', 'refresh');
		
		$mdl = 'groups_auth';
		
		/* if ( $action == 'c' ) {
			$data = $this->input->post();
			if ( empty($data) ) return;
			
			// {begin} => procedure check duplicate value [code]
			if ( $this->shared_model->is_duplicate_code($mdl, $data['code_new']) ) {
				echo json_encode(array("errorMsg"=>l('error_duplicate_code')));
				return;
			}	// {end}
			
			$data['code'] = strtoupper($data['code_new']);
			$data['name'] = strtoupper($data['name']);
			unset($data['id']);
			unset($data['code_new']);
			
			try {
				$this->db->insert($mdl, $data);
			} catch (Exception $e) {  
				echo json_encode(array("errorMsg"=>$e->getMessage()));
				return;
			} 
			
			crud_success();
		} */

		if ( $action == 'r' ) {
			$params = $this->input->post();
			
			if ( !empty($params['group_id']) )
				$params['where']['g.id'] = $params['group_id'];
			
			if ( !empty($params['q']) )
			{
				$params['like']['code'] = $params['q'];
				$params['like']['name'] = $params['q'];
			}	
			
			if ( !empty($params['findKey']) && !empty($params['findVal']) )
				if ( $params['findKey']=='ALL' ) 
				{
					$params['like']['code'] = $params['findVal'];
					$params['like']['name'] = $params['findVal'];
				} 
				else
					$params['like'][$params['findKey']] = $params['findVal'];

			crud_result( $this->systems_model->getGroups_Auth($params) );
		}

		if ( $action == 'u' ) {
			$data = $this->input->post();
			if ( empty($data) ) return;
			
			try {
			
				$data1['group_id'] = $data['group_id'];
				$data1['module_id'] = $data['module_id'];
				$qry = $this->db->get_where( $mdl, $data1, 1 );
				
				$fl = $data['cellField'];
				$data1[$fl] = ($data['cellValue']) ? 0 : 1;
				
				if ( $qry->num_rows > 0 ) 
				{
					$this->db->update($mdl, $data1, array('id'=>$qry->row()->id));
				}
				else 
				{
					$this->db->insert($mdl, $data1);
				} 
				
			} catch (Exception $e) {  
				crud_error( $e->getMessage() );
			} 
			
			crud_success();
		}

		/* if ( $action == 'd' ) {
			$id = $this->input->post('id');
			if ( empty($id) ) return;
			
			// {begin} check if this data has already have transaction
			if ( $this->shared_model->is_data_exists_on( 'users_groups', array('group_id'), $id) ) {
				echo json_encode( array("errorMsg"=>l('error_data_transaction')) );
				return;
			} 
			// {end}
			
			try {
				$this->db->delete($mdl, array('id'=>$id));
			} catch (Exception $e) {  
				echo json_encode(array("errorMsg"=>$e->getMessage()));
				return;
			} 
			
			crud_success();
		} */

		if ( !is_allow('r', $this->mdl_grp, $mdl) )
			show_error(l('permission_failed_menu'));
		
		$this->getme_lib->go( $this->mdl_grp, $mdl );
	}
	
	function company( $action=NULL ) {
		if (!$this->ion_auth->logged_in())
			redirect('main', 'refresh');
			
		$mdl = 'company';
		
		if ( $action == 'c' ) {
			$data = $this->input->post();
			if ( empty($data) ) 
				crud_error("Error: Empty Data !");
			
			// {begin} => procedure check duplicate value [code]
			if ( $this->shared_model->is_duplicate_code($mdl, $data['code_new']) ) 
				crud_error("error_duplicate_code");
			
			$this->db->trans_begin();
			try {
			
				$data1['code'] 		  = strtoupper($data['code_new']);
				$data1['name'] 		  = strtoupper($data['name']);
				$data1['address1'] 	  = $data['address1'];
				$data1['currency_id'] = $data['currency_id'];
				$data1['email'] 	  = $data['email'];
				$data1['phone1'] 	  = $data['phone1'];
				$data1['fax'] 		  = $data['fax'];
				$data1['npwp'] 		  = $data['npwp'];
				$data1['website'] 	  = $data['website'];
				$this->db->insert($mdl, $data);
				
			} catch (Exception $e) {  
				crud_error($e->getMessage());
			} 
			
			$this->db->trans_commit();
			crud_success();
		}

		if ( $action == 'r' ) {
			$params = $this->input->post();
			
			if ( !empty($params['q']) )
			{
				$params['like']['code'] = $params['q'];
				$params['like']['name'] = $params['q'];
			}	
			
			if ( !empty($params['findKey']) && !empty($params['findVal']) )
				if ( $params['findKey']=='ALL' ) 
				{
					$params['like']['code'] = $params['findVal'];
					$params['like']['name'] = $params['findVal'];
				} 
				else
					$params['like'][$params['findKey']] = $params['findVal'];

			crud_result( $this->systems_model->getCompany($params) );
		}

		if ( $action == 'u' ) {
			$data = $this->input->post();
			if ( empty($data) ) 
				crud_error("Error: Empty Data !");
			
			// {begin} => check duplicate value [code]
			if ( $data['code'] != $data['code_new'] )
				if ( $this->shared_model->is_duplicate_code($mdl, $data['code_new']) ) 
					crud_error('error_duplicate_code');
			
			$this->db->trans_begin();
			try {
			
				$data1['code'] 		  = strtoupper($data['code_new']);
				$data1['name'] 		  = strtoupper($data['name']);
				$data1['address1'] 	  = $data['address1'];
				$data1['currency_id'] = $data['currency_id'];
				$data1['email'] 	  = $data['email'];
				$data1['phone1'] 	  = $data['phone1'];
				$data1['fax'] 		  = $data['fax'];
				$data1['npwp'] 		  = $data['npwp'];
				$data1['website'] 	  = $data['website'];
				$this->db->update($mdl, $data1, array('id'=>$data['id']));
				
			} catch (Exception $e) {  
				crud_error( $e->getMessage() );
			} 
			
			$this->db->trans_commit();
			crud_success();
		}

		if ( $action == 'd' ) {
			$data = $this->input->post();
			if ( empty($data) ) 
				crud_error("Error: Empty Data !");
			
			if ( $data['id']==1 )
				crud_error("Error: This is a Main Company !");
			
			$this->db->trans_begin();
			try {
			
				$data1['deleted']     = 1;
				$data1['modify_by']   = sesUser()->id;
				$data1['modify_date'] = date('Y-m-d H:i:s');
				$this->db->update( 'company', $data1, array('id'=>$data['id']) );
				
			} catch (Exception $e) {  
				crud_error( $e->getMessage() );
			} 
			
			$this->db->trans_commit();
			crud_success();
		}

		if ( !is_allow('r', $this->mdl_grp, $mdl) )
			show_error(l('permission_failed_menu'));
		
		$this->getme_lib->go( $this->mdl_grp, $mdl );	}

	function branch( $action=NULL ) {
		if (!$this->ion_auth->logged_in())
			redirect('main', 'refresh');
			
		$mdl = 'branch';
		
		if ( $action == 'c' ) {
			$data = $this->input->post();
			if ( empty($data) ) 
				crud_error("Error: Empty Data !");
			
			// {begin} => procedure check duplicate value [code]
			if ( $this->shared_model->is_duplicate_code($mdl, $data['code_new']) ) 
				crud_error("error_duplicate_code");
			
			$this->db->trans_begin();
			
			try {
			
				$data1['code'] = strtoupper($data['code_new']);
				$data1['name'] = strtoupper($data['name']);
				$this->db->insert($mdl, $data1);
				
			} catch (Exception $e) {  
				crud_error($e->getMessage());
			} 
			
			$this->db->trans_commit();
			crud_success();
		}

		if ( $action == 'r' ) {
			$params = $this->input->post();
			
			if ( !empty($params['q']) )
			{
				$params['like']['code'] = $params['q'];
				$params['like']['name'] = $params['q'];
			}	
			
			if ( !empty($params['findKey']) && !empty($params['findVal']) )
				if ( $params['findKey']=='ALL' ) 
				{
					$params['like']['code'] = $params['findVal'];
					$params['like']['name'] = $params['findVal'];
				} 
				else
					$params['like'][$params['findKey']] = $params['findVal'];

			crud_result( $this->systems_model->getBranch($params) );
		}

		if ( $action == 'u' ) {
			$data = $this->input->post();
			if ( empty($data) ) 
				crud_error("Error: Empty Data !");
			
			// {begin} => check duplicate value [code]
			if ( $data['code'] != $data['code_new'] )
				if ( $this->shared_model->is_duplicate_code($mdl, $data['code_new']) ) 
					crud_error('error_duplicate_code');
			
			$this->db->trans_begin();
			
			try {

				$data1['code'] = strtoupper($data['code_new']);
				$data1['name'] = strtoupper($data['name']);
				$this->db->update($mdl, $data1, array('id'=>$data['id']));

			} catch (Exception $e) {  
				crud_error($e->getMessage());
			} 
			
			$this->db->trans_commit();
			crud_success();
		}

		if ( $action == 'd' ) {
			$data = $this->input->post();
			if ( empty($data) ) 
				crud_error("Error: Empty Data !");
			
			if ( $data['id']==1 )
				crud_error("Error: This is a Main Branch !");
			
			$this->db->trans_begin();
			try {
			
				$this->db->delete($mdl, array('id'=>$data['id']));
				
			} catch (Exception $e) {  
				crud_error( $e->getMessage() );
			} 
			
			$this->db->trans_commit();
			crud_success();
		}

		if ( !is_allow('r', $this->mdl_grp, $mdl) )
			show_error(l('permission_failed_menu'));
		
		$this->getme_lib->go( $this->mdl_grp, $mdl );
	}

	function department( $action=NULL ) {
		if (!$this->ion_auth->logged_in())
			redirect('main', 'refresh');
			
		$mdl = 'department';
		
		if ( $action == 'c' ) {
			$data = $this->input->post();
			if ( empty($data) ) 
				crud_error("Error: Empty Data !");
			
			// {begin} => procedure check duplicate value [code]
			if ( $this->shared_model->is_duplicate_code($mdl, $data['code_new']) ) 
				crud_error("error_duplicate_code");
			
			$this->db->trans_begin();
			
			try {
			
				$data1['code'] = strtoupper($data['code_new']);
				$data1['name'] = strtoupper($data['name']);
				$this->db->insert($mdl, $data1);
				
			} catch (Exception $e) {  
				crud_error($e->getMessage());
			} 
			
			$this->db->trans_commit();
			crud_success();
		}

		if ( $action == 'r' ) {
			$params = $this->input->post();
			
			if ( !empty($params['q']) )
			{
				$params['like']['code'] = $params['q'];
				$params['like']['name'] = $params['q'];
			}	
			
			if ( !empty($params['findKey']) && !empty($params['findVal']) )
				if ( $params['findKey']=='ALL' ) 
				{
					$params['like']['code'] = $params['findVal'];
					$params['like']['name'] = $params['findVal'];
				} 
				else
					$params['like'][$params['findKey']] = $params['findVal'];

			crud_result( $this->systems_model->getDepartment($params) );
		}

		if ( $action == 'u' ) {
			$data = $this->input->post();
			if ( empty($data) ) 
				crud_error("Error: Empty Data !");
			
			// {begin} => check duplicate value [code]
			if ( $data['code'] != $data['code_new'] )
				if ( $this->shared_model->is_duplicate_code($mdl, $data['code_new']) ) 
					crud_error('error_duplicate_code');
			
			$this->db->trans_begin();
			
			try {

				$data1['code'] = strtoupper($data['code_new']);
				$data1['name'] = strtoupper($data['name']);
				$this->db->update($mdl, $data1, array('id'=>$data['id']));

			} catch (Exception $e) {  
				crud_error($e->getMessage());
			} 
			
			$this->db->trans_commit();
			crud_success();
		}

		if ( $action == 'd' ) {
			$data = $this->input->post();
			if ( empty($data) ) 
				crud_error("Error: Empty Data !");
			
			// {begin} check if this data has already have transaction
			// if ( $this->shared_model->is_data_exists_on( 'users_department', array('department_id'), $id) ) {
				// echo json_encode( array("errorMsg"=>l('error_data_transaction')) );
				// return;
			// } 
			// {end}
			
			$this->db->trans_begin();
			
			try {
			
				// $this->db->delete($mdl, array('id'=>$data['id']));
				
			} catch (Exception $e) {  
				crud_error( $e->getMessage() );
			} 
			
			$this->db->trans_commit();
			crud_success();
		}

		if ( !is_allow('r', $this->mdl_grp, $mdl) )
			show_error(l('permission_failed_menu'));
		
		$this->getme_lib->go( $this->mdl_grp, $mdl );
	}

	function currency( $action=NULL ) {
		if (!$this->ion_auth->logged_in())
			redirect('main', 'refresh');
		
		$mdl = 'currency';
		$user_id = $this->session->userdata('user_id');
		
		if ( $action == 'c' ) {
			$data = $this->input->post();
			if ( empty($data) ) 
				crud_error("Error: Empty Data !");
			
			// {begin} => procedure check duplicate value [code]
			if ( $this->shared_model->is_duplicate_code($mdl, $data['code_new']) ) 
				crud_error("error_duplicate_code");
			
			$this->db->trans_begin();
			
			try {
			
				$data1['code'] 			= strtoupper($data['code_new']);
				$data1['name'] 			= strtoupper($data['name']);
				$data1['symbol'] 		= array_key_exists( 'symbol', $data ) ? $data['symbol'] : NULL;
				$data1['create_by']   	= $user_id;
				$data1['create_date'] 	= date('Y-m-d H:i:s');
				$this->db->insert($mdl, $data1);
				
			} catch (Exception $e) {  
				crud_error($e->getMessage());
			} 
			
			$this->db->trans_commit();
			crud_success();
		}

		if ( $action == 'r' ) {
			$params = $this->input->post();
			
			if ( !empty($params['q']) )
			{
				$params['like']['code'] = $params['q'];
				$params['like']['name'] = $params['q'];
			}	
			
			if ( !empty($params['findKey']) && !empty($params['findVal']) )
				if ( $params['findKey']=='ALL' ) 
				{
					$params['like']['code'] = $params['findVal'];
					$params['like']['name'] = $params['findVal'];
				} 
				else
					$params['like'][$params['findKey']] = $params['findVal'];

			crud_result( $this->systems_model->getCurrency($params) );
		}

		if ( $action == 'u' ) {
			$data = $this->input->post();
			if ( empty($data) ) 
				crud_error("Error: Empty Data !");
			
			// {begin} => check duplicate value [code]
			if ( $data['code'] != $data['code_new'] )
				if ( $this->shared_model->is_duplicate_code($mdl, $data['code_new']) ) 
					crud_error('error_duplicate_code');
			
			$this->db->trans_begin();
			
			try {

				$data1['code'] 			= strtoupper($data['code_new']);
				$data1['name'] 			= strtoupper($data['name']);
				$data1['symbol'] 		= array_key_exists( 'symbol', $data ) ? $data['symbol'] : NULL;
				$data1['modify_by']   	= $user_id;
				$data1['modify_date'] 	= date('Y-m-d H:i:s');
				$this->db->update($mdl, $data1, array('id'=>$data['id']));

			} catch (Exception $e) {  
				crud_error($e->getMessage());
			} 
			
			$this->db->trans_commit();
			crud_success();
		}

		if ( $action == 'd' ) {
			$data = $this->input->post();
			if ( empty($data) ) 
				crud_error("Error: Empty Data !");
			
			// {begin} check if this data has already have transaction
			// if ( $this->shared_model->is_data_exists_on( 'company', array('currency_id'), $id) ) {
				// echo json_encode( array("errorMsg"=>l('error_data_transaction')) );
				// return;
			// } 
			// {end}
			
			$this->db->trans_begin();
			try {
			
				// $this->db->delete($mdl, array('id'=>$data['id']));
				
			} catch (Exception $e) {  
				crud_error( $e->getMessage() );
			} 
			
			$this->db->trans_commit();
			crud_success();
		}

		if ( !is_allow('r', $this->mdl_grp, $mdl) )
			show_error(l('permission_failed_menu'));
		
		$this->getme_lib->go( $this->mdl_grp, $mdl );
	}

	function modules_groups( $action=NULL )	{
		if (!$this->ion_auth->logged_in())
			redirect('main', 'refresh');
		
		$mdl = 'modules_groups';

		if ( $action == 'c' ) {
			$data = $this->input->post();
			
			// ============= VALIDITY SECTION
			if ( empty($data) ) 
				crud_error("Error: Empty Data !");
			
			// {begin} => procedure check duplicate value [code]
			if ( $this->shared_model->is_duplicate_code($mdl, $data['code_new']) ) 
				crud_error("error_duplicate_code");
			
			// ============= CRUD SECTION
			$this->db->trans_begin();
			try {
			
				$count = $this->db->from('modules_groups')->count_all_results();
				
				$data1['code'] 	  = strtoupper($data['code_new']);
				$data1['name'] 	  = strtoupper($data['name']);
				$data1['sort_no'] = $count + 1;
				$data1['active']  = array_key_exists('active', $data) ? 1 : 0;
				$this->db->insert($mdl, $data1);
				
			} catch (Exception $e) {  
				crud_error($e->getMessage());
			} 
			
			$this->db->trans_commit();
			crud_success();
		}

		if ( $action == 'r' ) {
			$params = $this->input->post();
			
			// $params['where']['show'] = 1;
			
			if ( !empty($params['q']) )
			{
				$params['like']['code'] = $params['q'];
				$params['like']['name'] = $params['q'];
			}	
			
			if ( !empty($params['findKey']) && !empty($params['findVal']) )
				if ( $params['findKey']=='ALL' ) 
				{
					$params['like']['code'] = $params['findVal'];
					$params['like']['name'] = $params['findVal'];
				} 
				else
					$params['like'][$params['findKey']] = $params['findVal'];

			crud_result( $this->systems_model->getModules_Groups($params) );
		}

		if ( $action == 'u' ) {
			$data = $this->input->post();
			
			// ============= VALIDITY SECTION
			if ( empty($data) ) 
				crud_error("Error: Empty Data !");
			
			// {begin} => check duplicate value [code]
			if ( $data['code'] != $data['code_new'] )
				if ( $this->shared_model->is_duplicate_code($mdl, $data['code_new']) ) 
					crud_error('error_duplicate_code');
			
			// ============= CRUD SECTION
			$this->db->trans_begin();
			try {

				$data1['code'] 	 = strtoupper($data['code_new']);
				$data1['name'] 	 = strtoupper($data['name']);
				$data1['active'] = array_key_exists('active', $data) ? 1 : 0;
				$this->db->update($mdl, $data1, array('id'=>$data['id']));

			} catch (Exception $e) {  
				crud_error($e->getMessage());
			} 
			
			$this->db->trans_commit();
			crud_success();
		}

		if ( $action == 'd' ) {
			$data = $this->input->post();
			
			// ============= VALIDITY SECTION
			if ( empty($data) ) 
				crud_error("Error: Empty Data !");
			
			if ( !$this->ion_auth->is_admin() )
				crud_error("Error: Administrator Only !");

			// ============= CRUD SECTION
			$this->db->trans_begin();
			try {
			
				$this->db->delete('modules', array('module_group_id'=>$data['id']));
				$this->db->delete('modules_groups', array('id'=>$data['id']));
				
				// RE-ORDER
				$qry = $this->db->order_by('sort_no')->get_where('modules_groups');
				$sort_no = 1;
				foreach ($qry->result() as $row)
				{
					$this->db->update('modules_groups', array('sort_no'=>$sort_no), array('id'=>$row->id));
					$sort_no++;
				}
				
			} catch (Exception $e) {  
				crud_error( $e->getMessage() );
			} 
			
			$this->db->trans_commit();
			crud_success();
		}

		if ( $action == 'up' ) {
			$data = $this->input->post();
			
			// ============= VALIDITY SECTION
			if ( empty($data) ) 
				crud_error("Error: Empty Data !");
			
			// ============= CRUD SECTION
			$this->db->trans_begin();
			try {
			
				$curr_row = $this->db->get_where( 'modules_groups', array('id'=>$data['id']) )->row();
				if ($curr_row->sort_no==1) 
					crud_success();
					
				// UP
				$sort_no_new = $curr_row->sort_no - 1;
				$this->db->update( 'modules_groups', array('sort_no'=>$sort_no_new), array('id'=>$data['id']) );
				$this->db->update( 'modules_groups', array('sort_no'=>$curr_row->sort_no), array('id <> '=>$data['id'], 'sort_no'=>$sort_no_new) );
				
			} catch (Exception $e) {  
				crud_error( $e->getMessage() );
			} 
			
			$this->db->trans_commit();
			crud_success();
		}

		if ( $action == 'down' ) {
			$data = $this->input->post();
			
			// ============= VALIDITY SECTION
			if ( empty($data) ) 
				crud_error("Error: Empty Data !");
			
			// ============= CRUD SECTION
			$this->db->trans_begin();
			try {
			
				$curr_row = $this->db->get_where( 'modules_groups', array('id'=>$data['id']) )->row();
				$count 	  = $this->db->from('modules_groups')->count_all_results();
				if ($curr_row->sort_no==$count) 
					crud_success();
					
				// DOWN
				$sort_no_new = $curr_row->sort_no + 1;
				$this->db->update( 'modules_groups', array('sort_no'=>$sort_no_new), array('id'=>$data['id']) );
				$this->db->update( 'modules_groups', array('sort_no'=>$curr_row->sort_no), array('id <> '=>$data['id'], 'sort_no'=>$sort_no_new) );
				
			} catch (Exception $e) {  
				crud_error( $e->getMessage() );
			} 
			
			$this->db->trans_commit();
			crud_success();
		}

		if ( $action == 'active' ) {
			$data = $this->input->post();
			
			// ============= VALIDITY SECTION
			if ( empty($data) ) 
				crud_error("Error: Empty Data !");
			
			// ============= CRUD SECTION
			$this->db->trans_begin();
			try {
			
				$active = $this->db->get_where( 'modules_groups', array('id'=>$data['id']) )->row()->active;
				$active = !$active;
				
				$this->db->update( 'modules_groups', array('active'=>$active), array('id'=>$data['id']) );
				
			} catch (Exception $e) {  
				crud_error( $e->getMessage() );
			} 
			
			$this->db->trans_commit();
			crud_success();
		}

		if ( $action == 'show' ) {
			$data = $this->input->post();
			
			// ============= VALIDITY SECTION
			if ( empty($data) ) 
				crud_error("Error: Empty Data !");
			
			// ============= CRUD SECTION
			$this->db->trans_begin();
			try {
			
				$show = $this->db->get_where( 'modules_groups', array('id'=>$data['id']) )->row()->show;
				$show = !$show;
				
				$this->db->update( 'modules_groups', array('show'=>$show), array('id'=>$data['id']) );
				
			} catch (Exception $e) {  
				crud_error( $e->getMessage() );
			} 
			
			$this->db->trans_commit();
			crud_success();
		}

		if ( $action == 'reorder' ) {
			$data = $this->input->post();
			
			// ============= VALIDITY SECTION
			if ( empty($data) ) 
				crud_error("Error: Empty Data !");
			
			// ============= CRUD SECTION
			$this->db->trans_begin();
			try {
				
				$qry = $this->db->order_by('sort_no')->get_where('modules_groups');
				$sort_no = 1;
				foreach ($qry->result() as $row)
				{
					$this->db->update('modules_groups', array('sort_no'=>$sort_no), array('id'=>$row->id));
					$sort_no++;
				}
				
			} catch (Exception $e) {  
				crud_error( $e->getMessage() );
			} 
			
			$this->db->trans_commit();
			crud_success();
		}

		if ( !is_allow('r', $this->mdl_grp, $mdl) )
			show_error(l('permission_failed_menu'));
		
		$this->getme_lib->go( $this->mdl_grp, $mdl );
	}
	
	function modules( $action=NULL )	{
		if (!$this->ion_auth->logged_in())
			redirect('main', 'refresh');
		
		// $mdl_parent	= 'modules_groups';
		$mdl = 'modules';

		if ( $action == 'c' ) {
			$data = $this->input->post();
			if ( empty($data) ) 
				crud_error("Error: Empty Data !");
			
			// {begin} => procedure check duplicate value [code]
			if ( $this->shared_model->is_duplicate_code($mdl, $data['code_new']) )
				crud_error("error_duplicate_code");
			
			$this->db->trans_begin();
			
			try {
			
				$data1['module_group_id'] = $data['module_group_id'];
				$count = $this->db->from('modules')->where($data1)->count_all_results();
				
				$data1['code'] 			  = strtoupper($data['code_new']);
				$data1['name'] 			  = strtoupper($data['name']);
				$data1['page_link'] 	  = $data['page_link'];
				$data1['sort_no'] 	  	  = $count + 1;
				$data1['active'] 		  = array_key_exists('active', $data) ? 1 : 0;
				$data1['is_form'] 	  	  = array_key_exists('is_form', $data) ? 1 : 0;
				$data1['show_in_menu'] 	  = array_key_exists('show_in_menu', $data) ? 1 : 0;
				$data1['separator'] 	  = array_key_exists('separator', $data) ? 1 : 0;
				$this->db->insert($mdl, $data1);
				
			} catch (Exception $e) {  
				crud_error($e->getMessage());
			} 
			
			$this->db->trans_commit();
			crud_success();
		}

		if ( $action == 'r' ) {
			$params = $this->input->post();
			
			if ( !empty($params['module_group_id']) )
				$params['where']['module_group_id'] = $params['module_group_id'];
			
			if ( !empty($params['q']) )
			{
				$params['like']['code'] = $params['q'];
				$params['like']['name'] = $params['q'];
			}	
			
			if ( !empty($params['findKey']) && !empty($params['findVal']) )
				if ( $params['findKey']=='ALL' ) 
				{
					$params['like']['code'] = $params['findVal'];
					$params['like']['name'] = $params['findVal'];
				} 
				else
					$params['like'][$params['findKey']] = $params['findVal'];

			crud_result( $this->systems_model->getModules($params) );
		}

		if ( $action == 'u' ) {
			$data = $this->input->post();
			if ( empty($data) ) 
				crud_error("Error: Empty Data !");
			
			// {begin} => check duplicate value [code]
			if ( $data['code'] != $data['code_new'] )
				if ( $this->shared_model->is_duplicate_code($mdl, $data['code_new']) ) 
					crud_error('error_duplicate_code');
			
			$this->db->trans_begin();
			try {
			
				$data1['module_group_id'] = $data['module_group_id'];
				$data1['code'] 			  = strtoupper($data['code_new']);
				$data1['name'] 			  = strtoupper($data['name']);
				$data1['page_link'] 	  = $data['page_link'];
				$data1['active'] 		  = ($data['active']=='true') ? 1 : 0;
				$data1['is_form'] 	  	  = array_key_exists('is_form', $data) ? 1 : 0;
				$data1['show_in_menu'] 	  = array_key_exists('show_in_menu', $data) ? 1 : 0;
				$data1['separator'] 	  = array_key_exists('separator', $data) ? 1 : 0;
				$this->db->update($mdl, $data1, array('id'=>$data['id']));
				
			} catch (Exception $e) {  
				crud_error($e->getMessage());
			} 
			
			$this->db->trans_commit();
			crud_success();
		}

		if ( $action == 'd' ) {
			$data = $this->input->post();
			if ( empty($data) ) 
				crud_error("Error: Empty Data !");
			
			// {begin} check if this data has already have transaction
			// if ( $this->shared_model->is_data_exists_on( 'groups_auth', array('module_id'), $id) ) {
				// echo json_encode( array("errorMsg"=>l('error_data_transaction')) );
				// return;
			// } 
			// {end}
			
			$this->db->trans_begin();
			
			try {
			
				// $this->db->delete($mdl, array('id'=>$data['id']));
				
			} catch (Exception $e) {  
				crud_error( $e->getMessage() );
			} 
			
			$this->db->trans_commit();
			crud_success();
		}

		if ( $action == 'up' ) {
			$data = $this->input->post();
			
			// ============= VALIDITY SECTION
			if ( empty($data) ) 
				crud_error("Error: Empty Data !");
			
			// ============= CRUD SECTION
			$this->db->trans_begin();
			try {
			
				$curr_row = $this->db->get_where( 'modules', array('id'=>$data['id']) )->row();
				if ($curr_row->sort_no==1) 
					crud_success();
					
				// UP 
				$sort_no_new = $curr_row->sort_no - 1;
				$this->db->update( 'modules', array('sort_no'=>$sort_no_new), array('id'=>$data['id']) );
				$this->db->update( 'modules', array('sort_no'=>$curr_row->sort_no), array('id <> '=>$data['id'], 'sort_no'=>$sort_no_new, 'module_group_id'=>$curr_row->module_group_id) );

			} catch (Exception $e) {  
				crud_error( $e->getMessage() );
			} 
			
			$this->db->trans_commit();
			crud_success();
		}

		if ( $action == 'down' ) {
			$data = $this->input->post();
			
			// ============= VALIDITY SECTION
			if ( empty($data) ) 
				crud_error("Error: Empty Data !");
			
			// ============= CRUD SECTION
			$this->db->trans_begin();
			try {
			
				$curr_row = $this->db->get_where( 'modules', array('id'=>$data['id']) )->row();
				$count 	  = $this->db->from('modules')->where('module_group_id', $curr_row->module_group_id)->count_all_results();
					
				// DOWN
				$sort_no_new = ($curr_row->sort_no >= $count) ? $count : $curr_row->sort_no + 1;
				$this->db->update( 'modules', array('sort_no'=>$sort_no_new), array('id'=>$data['id']) );
				$this->db->update( 'modules', array('sort_no'=>$curr_row->sort_no), array('id <> '=>$data['id'], 'sort_no'=>$sort_no_new, 'module_group_id'=>$curr_row->module_group_id) );

			} catch (Exception $e) {  
				crud_error( $e->getMessage() );
			} 
			
			$this->db->trans_commit();
			crud_success();
		}

		if ( $action == 'active' ) {
			$data = $this->input->post();
			
			// ============= VALIDITY SECTION
			if ( empty($data) ) 
				crud_error("Error: Empty Data !");
			
			// ============= CRUD SECTION
			$this->db->trans_begin();
			try {
			
				$active = $this->db->get_where( 'modules', array('id'=>$data['id']) )->row()->active;
				$active = !$active;
				
				$this->db->update( 'modules', array('active'=>$active), array('id'=>$data['id']) );
				
			} catch (Exception $e) {  
				crud_error( $e->getMessage() );
			} 
			
			$this->db->trans_commit();
			crud_success();
		}

		if ( $action == 'is_form' ) {
			$data = $this->input->post();
			
			// ============= VALIDITY SECTION
			if ( empty($data) ) 
				crud_error("Error: Empty Data !");
			
			// ============= CRUD SECTION
			$this->db->trans_begin();
			try {
			
				$is_form = $this->db->get_where( 'modules', array('id'=>$data['id']) )->row()->is_form;
				$is_form = !$is_form;
				
				$this->db->update( 'modules', array('is_form'=>$is_form), array('id'=>$data['id']) );
				
			} catch (Exception $e) {  
				crud_error( $e->getMessage() );
			} 
			
			$this->db->trans_commit();
			crud_success();
		}

		if ( $action == 'show_in_menu' ) {
			$data = $this->input->post();
			
			// ============= VALIDITY SECTION
			if ( empty($data) ) 
				crud_error("Error: Empty Data !");
			
			// ============= CRUD SECTION
			$this->db->trans_begin();
			try {
			
				$show_in_menu = $this->db->get_where( 'modules', array('id'=>$data['id']) )->row()->show_in_menu;
				$show_in_menu = !$show_in_menu;
				
				$this->db->update( 'modules', array('show_in_menu'=>$show_in_menu), array('id'=>$data['id']) );
				
			} catch (Exception $e) {  
				crud_error( $e->getMessage() );
			} 
			
			$this->db->trans_commit();
			crud_success();
		}

		if ( $action == 'separator' ) {
			$data = $this->input->post();
			
			// ============= VALIDITY SECTION
			if ( empty($data) ) 
				crud_error("Error: Empty Data !");
			
			// ============= CRUD SECTION
			$this->db->trans_begin();
			try {
			
				$separator = $this->db->get_where( 'modules', array('id'=>$data['id']) )->row()->separator;
				$separator = !$separator;
				
				$this->db->update( 'modules', array('separator'=>$separator), array('id'=>$data['id']) );
				
			} catch (Exception $e) {  
				crud_error( $e->getMessage() );
			} 
			
			$this->db->trans_commit();
			crud_success();
		}

		if ( $action == 'reorder' ) {
			$data = $this->input->post();
			
			// ============= VALIDITY SECTION
			if ( empty($data) ) 
				crud_error("Error: Empty Data !");
			
			// ============= CRUD SECTION
			$this->db->trans_begin();
			try {
				
				$qry = $this->db->order_by('sort_no')->get_where('modules', array('module_group_id'=>$data['id']));
				$sort_no = 1;
				foreach ($qry->result() as $row)
				{
					$this->db->update('modules', array('sort_no'=>$sort_no), array('id'=>$row->id));
					$sort_no++;
				}
				
			} catch (Exception $e) {  
				crud_error( $e->getMessage() );
			} 
			
			$this->db->trans_commit();
			crud_success();
		}

		if ( !is_allow('r', $this->mdl_grp, $mdl) )
			show_error(l('permission_failed_menu'));
		
		$this->getme_lib->go( $this->mdl_grp, $mdl );
	}
	
	function setup_documents( $action=NULL ) {
		if (!$this->ion_auth->logged_in())
			redirect('main', 'refresh');
			
		$mdl 	= 'setup_documents';
		$user_id 		= $this->session->userdata('user_id');
		
		if ( $action == 'c' ) {
			$data = $this->input->post();
			if ( empty($data) ) 
				crud_error("Error: Empty Data !");
			
			// {begin} => procedure check duplicate value [code]
			if ( $this->shared_model->is_duplicate_code($mdl, $data['code_new']) ) 
				crud_error("error_duplicate_code");
			
			$this->db->trans_begin();
			
			try {
			
				$data1['company_id'] 	= $data['company_id'];
				$data1['branch_id'] 	= $data['branch_id'];
				$data1['department_id'] = $data['department_id'];
				$data1['code'] 			= strtoupper($data['code_new']);
				$data1['name'] 			= strtoupper($data['name']);
				$data1['prefix_code1'] 	= $data['prefix_code1'];
				$data1['prefix_code2'] 	= $data['prefix_code2'];
				$data1['prefix_code3'] 	= $data['prefix_code3'];
				$data1['prefix_code4'] 	= $data['prefix_code4'];
				$data1['prefix_code5'] 	= $data['prefix_code5'];
				$data1['prefix_code6'] 	= $data['prefix_code6'];
				$data1['separator'] 	= $data['separator'];
				$data1['number_digit'] 	= $data['number_digit'];
				if ( array_key_exists('revision_code', $data) ) $data1['revision_code'] = strtoupper($data['revision_code']);
				if ( array_key_exists('sign1', $data) ) $data1['sign1'] = strtoupper($data['sign1']);
				if ( array_key_exists('sign2', $data) ) $data1['sign2'] = strtoupper($data['sign2']);
				if ( array_key_exists('sign3', $data) ) $data1['sign3'] = strtoupper($data['sign3']);
				$data1['sign1_title'] 	= empty($data['sign1_title']) ? NULL : $data['sign1_title'];
				$data1['sign2_title'] 	= empty($data['sign2_title']) ? NULL : $data['sign2_title'];
				$data1['sign3_title'] 	= empty($data['sign3_title']) ? NULL : $data['sign3_title'];
				if ( array_key_exists('last_year', $data) ) $data1['last_year'] = strtoupper($data['last_year']);
				if ( array_key_exists('last_number', $data) ) $data1['last_number'] = strtoupper($data['last_number']);
				$this->db->insert( 'setup_documents', $data1 );
				
			} catch (Exception $e) {  
				crud_error($e->getMessage());
			} 
			
			$this->db->trans_commit();
			crud_success();
		}

		if ( $action == 'r' ) {
			$params = $this->input->post();
			
			$params['where']['sd.company_id'] 	= sesCompany(FALSE);
			if (sesBranch(FALSE) != 1)
				$params['where']['sd.branch_id'] 	= sesBranch(FALSE);
			
			if ( !empty($params['q']) )
			{
				$params['like']['sd.code'] = $params['q'];
				$params['like']['sd.name'] = $params['q'];
			}	
			
			if ( !empty($params['findKey']) && !empty($params['findVal']) )
				if ( $params['findKey']=='ALL' ) 
				{
					$params['like']['sd.code'] = $params['findVal'];
					$params['like']['sd.name'] = $params['findVal'];
				} 
				else
					$params['like']['sd.'.$params['findKey']] = $params['findVal'];

			crud_result( $this->systems_model->getSetup_Documents($params) );
		}

		if ( $action == 'u' ) {
			$data = $this->input->post();
			if ( empty($data) ) 
				crud_error("Error: Empty Data !");
			
			// {begin} => check duplicate value [code]
			if ( $data['code'] != $data['code_new'] )
				if ( $this->shared_model->is_duplicate_code($mdl, $data['code_new']) ) 
					crud_error('error_duplicate_code');
			
			$this->db->trans_begin();
			
			try {
				
				$data1['company_id'] 	= $data['company_id'];
				$data1['branch_id'] 	= $data['branch_id'];
				$data1['department_id'] = $data['department_id'];
				$data1['code'] 			= strtoupper($data['code_new']);
				$data1['name'] 			= strtoupper($data['name']);
				$data1['prefix_code1'] 	= $data['prefix_code1'];
				$data1['prefix_code2'] 	= $data['prefix_code2'];
				$data1['prefix_code3'] 	= $data['prefix_code3'];
				$data1['prefix_code4'] 	= $data['prefix_code4'];
				$data1['prefix_code5'] 	= $data['prefix_code5'];
				$data1['prefix_code6'] 	= $data['prefix_code6'];
				$data1['separator'] 	= $data['separator'];
				$data1['number_digit'] 	= $data['number_digit'];
				if ( array_key_exists('revision_code', $data) ) $data1['revision_code'] = strtoupper($data['revision_code']);
				if ( array_key_exists('sign1', $data) ) $data1['sign1'] = strtoupper($data['sign1']);
				if ( array_key_exists('sign2', $data) ) $data1['sign2'] = strtoupper($data['sign2']);
				if ( array_key_exists('sign3', $data) ) $data1['sign3'] = strtoupper($data['sign3']);
				$data1['sign1_title'] 	= empty($data['sign1_title']) ? NULL : $data['sign1_title'];
				$data1['sign2_title'] 	= empty($data['sign2_title']) ? NULL : $data['sign2_title'];
				$data1['sign3_title'] 	= empty($data['sign3_title']) ? NULL : $data['sign3_title'];
				if ( array_key_exists('last_year', $data) ) $data1['last_year'] = strtoupper($data['last_year']);
				if ( array_key_exists('last_number', $data) ) $data1['last_number'] = strtoupper($data['last_number']);
				$this->db->update( 'setup_documents', $data1, array('id'=>$data['id']) );
				
			} catch (Exception $e) {  
				crud_error( $e->getMessage() );
			} 
			
			$this->db->trans_commit();
			crud_success();
		}

		if ( $action == 'd' ) {
			$data = $this->input->post();
			if ( empty($data) ) 
				crud_error("Error: Empty Data !");
			
			$this->db->trans_begin();
			try {
			
				$data1['deleted']     = 1;
				$data1['modify_by']   = sesUser()->id;
				$data1['modify_date'] = date('Y-m-d H:i:s');
				$this->db->update( 'setup_documents', $data1, array('id'=>$data['id']) );
				
			} catch (Exception $e) {  
				crud_error( $e->getMessage() );
			} 
			
			$this->db->trans_commit();
			crud_success();
		}

		if ( !is_allow('r', $this->mdl_grp, $mdl) )
			show_error(l('permission_failed_menu'));
		
		$this->getme_lib->go( $this->mdl_grp, $mdl );
	}

}