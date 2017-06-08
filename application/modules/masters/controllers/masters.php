<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

// session_start(); //we need to call PHP's session object to access it through CI

class Masters extends CI_Controller {

	public $mdl_grp		= 'masters';
	public $a_class		= 'a_class';


	function __construct() {
		parent::__construct();
		date_default_timezone_set('Asia/Jakarta');
		
		$this->load->model('master_model','person');
	}

	function index() {
		if (!$this->ion_auth->logged_in())
			redirect('main', 'refresh');
		
		redirect('main', 'refresh');
	}

	function charts( $action=NULL ) {
		if (!$this->ion_auth->logged_in()) 
			redirect('main', 'refresh');

		$mdl 	 	= 'CHART';
		$user_id	= $this->session->userdata('user_id');
		$company_id	 	= $this->session->userdata('company_id');
		$department_id	= $this->session->userdata('department_id');
		
		if ( $action == 'c' ){
			$this->_validatechart();

			$data = $this->input->post();
			if ( empty($data) ) 
				crud_error("Error: Empty Data !");

			$this->db->trans_begin();
			try {
				$data1['code'] 	   		= strtoupper($data['codeChart']);
				$data1['name'] 			= strtoupper($data['name']);
				$data1['created_id']   	= $user_id;
				$data1['modified_id']   = $user_id;
				$data1['created_date'] 	= date('Y-m-d H:i:s');
				$data1['modified_date'] = date('Y-m-d H:i:s');
				$data1['deleted'] 		= 0;
			
				$this->db->insert('a_chart', $data1);
				$id = $this->db->insert_id();
				
			} catch (Exception $e) {  
				crud_error($e->getMessage());
			} 
			
			$this->db->trans_commit();
			echo json_encode(array("status"=>TRUE));
			exit;
		}

		if ( $action == 'r' ) {
			$list = $this->person->getAchart();
			// var_dump($list);
			// exit;
			$data = array();
			$no = $_POST['start'];
			$nomor=0;
			foreach ($list as $class_part) {
				$no++;
				$row = array();
				$row[] = $class_part->code;
				$row[] = $class_part->name;

				//add html for action
				$row[] = '<a class="btn btn-sm btn-primary" href="javascript:void(0)" title="Edit" onclick="edit_achart('."'".$class_part->id."'".')"><i class="glyphicon glyphicon-pencil"></i> Edit</a>
					  <a class="btn btn-sm btn-danger" href="javascript:void(0)" title="Hapus" onclick="delete_achart('."'".$class_part->id."'".')"><i class="glyphicon glyphicon-trash"></i> Delete</a>';
			
				$data[] = $row;
			}

			$output1 = array(
							"draw" => $_POST['draw'],
							"recordsTotal" => $this->person->countAchart(),
							"recordsFiltered" => $this->person->countAchart_filtered(),
							"data" => $data,
					);
			//output to json format
			echo json_encode($output1);			

			exit;
		}

		if ( $action == 'u' ) {
			$this->_validatechart();
			
			$data = $this->input->post();
			if ( empty($data) ) 
				crud_error("Error: Empty Data !");			
			$this->db->trans_begin();
			
			try {
				$data1['code'] 				= strtoupper($data['codeChart']);
				$data1['name'] 				= strtoupper($data['name']);
				$data1['modified_id']   	= $user_id;
				$data1['modified_date'] 	= date('Y-m-d H:i:s');
				$this->db->update( 'a_chart', $data1, array('id'=>$data['id']) );
				
			} catch (Exception $e) {  
				crud_error( $e->getMessage() );
			} 
			
			$this->db->trans_commit();
			echo json_encode(array("status"=>true));
			return;
		}

		if ( $action == 'd' ) {
			$data = $this->input->post();
			$this->db->trans_begin();

			try {
				$data1['deleted']     = 1;
				$data1['modified_id']   	= $user_id;
				$data1['modified_date'] 	= date('Y-m-d H:i:s');
				$this->db->update( 'a_chart', $data1, array('id'=>$data['id']) );
				
			} catch (Exception $e) {  
				crud_error( $e->getMessage() );
			} 
			
			$this->db->trans_commit();
			echo json_encode(array("status"=>TRUE));
			return;
		}

		if ( !is_allow('r', $this->mdl_grp, $mdl) )
			show_error(l('permission_failed_menu'));
		
		$this->getme_lib->go( $this->mdl_grp, $mdl );
	}
	
	public function chart_edit($id)
	{
		$data = $this->person->getAchart_by_id($id);
		echo json_encode($data);
	}

	private function _validatechart()
	{
		$data = array();
		$data['error_string'] = array();
		$data['inputerror'] = array();
		$data['status'] = TRUE;

		if($this->input->post('codeChart') == '')
		{
			$data['inputerror'][] = 'codeChart';
			$data['error_string'][] = 'Code is required';
			$data['status'] = FALSE;
		}

		if($this->input->post('name') == '')
		{
			$data['inputerror'][] = 'name';
			$data['error_string'][] = 'Name is required';
			$data['status'] = FALSE;
		}

		if($data['status'] === FALSE)
		{
			echo json_encode($data);
			exit();
		}
	}

	function class_part( $action=NULL) {
		$table='a_class';

		if (!$this->ion_auth->logged_in()) 
			redirect('main', 'refresh');

		$mdl 	 	= 'CLASS_PART';
		$user_id	= $this->session->userdata('user_id');
		$company_id	 	= $this->session->userdata('company_id');
		$department_id	= $this->session->userdata('department_id');
		
		if ( $action == 'c' ){
			$this->_validateclass();

			$data = $this->input->post();
			if ( empty($data) ) 
				crud_error("Error: Empty Data !");

			$this->db->trans_begin();
			try {
				$data1['code'] 	   		= strtoupper($data['codeClass']);
				$data1['name'] 			= strtoupper($data['name']);
				$data1['created_id']   	= $user_id;
				$data1['modified_id']   = $user_id;
				$data1['created_date'] 	= date('Y-m-d H:i:s');
				$data1['modified_date'] = date('Y-m-d H:i:s');
				$data1['deleted'] 		= 0;
			
				$this->db->insert('a_class', $data1);
				$id = $this->db->insert_id();
				
			} catch (Exception $e) {  
				crud_error($e->getMessage());
			} 
			
			$this->db->trans_commit();
			echo json_encode(array("status"=>TRUE));
			exit;
		}
		if ( $action == 'r' ) {
			$list = $this->person->getAclass();
			// var_dump($list);
			// exit;
			$data = array();
			$no = $_POST['start'];
			$nomor=0;
			foreach ($list as $class_part) {
				$no++;
				$row = array();
				$row[] = $class_part->code;
				$row[] = $class_part->name;

				//add html for action
				$row[] = '<a class="btn btn-sm btn-primary" href="javascript:void(0)" title="Edit" onclick="edit_aclass('."'".$class_part->id."'".')"><i class="glyphicon glyphicon-pencil"></i> Edit</a>
					  <a class="btn btn-sm btn-danger" href="javascript:void(0)" title="Hapus" onclick="delete_aclass('."'".$class_part->id."'".')"><i class="glyphicon glyphicon-trash"></i> Delete</a>';
			
				$data[] = $row;
			}

			$output1 = array(
							"draw" => $_POST['draw'],
							"recordsTotal" => $this->person->countAclass(),
							"recordsFiltered" => $this->person->countAclass_filtered(),
							"data" => $data,
					);
			//output to json format
			echo json_encode($output1);			

			exit;
		}

		if ( $action == 'u' ) {
			$this->_validateclass();
			
			$data = $this->input->post();
			if ( empty($data) ) 
				crud_error("Error: Empty Data !");			
			$this->db->trans_begin();
			
			try {
				$data1['code'] 				= strtoupper($data['codeClass']);
				$data1['name'] 				= strtoupper($data['name']);
				$data1['modified_id']   	= $user_id;
				$data1['modified_date'] 	= date('Y-m-d H:i:s');
				$this->db->update( 'a_class', $data1, array('id'=>$data['id']) );
				
			} catch (Exception $e) {  
				crud_error( $e->getMessage() );
			} 
			
			$this->db->trans_commit();
			echo json_encode(array("status"=>true));
			return;
		}

		if ( $action == 'd' ) {
			$data = $this->input->post();
			$this->db->trans_begin();

			try {
				$data1['deleted']     = 1;
				$data1['modified_id']   	= $user_id;
				$data1['modified_date'] 	= date('Y-m-d H:i:s');
				$this->db->update( 'a_class', $data1, array('id'=>$data['id']) );
				
			} catch (Exception $e) {  
				crud_error( $e->getMessage() );
			} 
			
			$this->db->trans_commit();
			echo json_encode(array("status"=>TRUE));
			return;
		}

		if ( !is_allow('r', $this->mdl_grp, $mdl) )
			show_error(l('permission_failed_menu'));
		
		$this->getme_lib->go( $this->mdl_grp, $mdl );
	}

	public function class_edit($id)
	{
		$data = $this->person->getAclass_by_id($id);
		echo json_encode($data);
	}

	private function _validateclass()
	{
		$data = array();
		$data['error_string'] = array();
		$data['inputerror'] = array();
		$data['status'] = TRUE;

		if($this->input->post('codeClass') == '')
		{
			$data['inputerror'][] = 'codeClass';
			$data['error_string'][] = 'Code is required';
			$data['status'] = FALSE;
		}

		if($this->input->post('name') == '')
		{
			$data['inputerror'][] = 'name';
			$data['error_string'][] = 'Name is required';
			$data['status'] = FALSE;
		}

		if($data['status'] === FALSE)
		{
			echo json_encode($data);
			exit();
		}
	}

	function fillers( $action=NULL) {
		if (!$this->ion_auth->logged_in()) 
			redirect('main', 'refresh');

		$mdl 	 	= 'FILLER';
		$user_id	= $this->session->userdata('user_id');
		$company_id	 	= $this->session->userdata('company_id');
		$department_id	= $this->session->userdata('department_id');
		
		if ( $action == 'c' ){
			$this->_validatefillers();

			$data = $this->input->post();
			if ( empty($data) ) 
				crud_error("Error: Empty Data !");

			$this->db->trans_begin();
			try {
				$data1['code'] 	   		= strtoupper($data['codefiller']);
				$data1['name'] 			= strtoupper($data['name']);
				$data1['created_id']   	= $user_id;
				$data1['modified_id']   = $user_id;
				$data1['created_date'] 	= date('Y-m-d H:i:s');
				$data1['modified_date'] = date('Y-m-d H:i:s');
				$data1['deleted'] 		= 0;
			
				$this->db->insert('a_filler', $data1);
				$id = $this->db->insert_id();
				
			} catch (Exception $e) {  
				crud_error($e->getMessage());
			} 
			
			$this->db->trans_commit();
			echo json_encode(array("status"=>TRUE));
			exit;
		}
		if ( $action == 'r' ) {
			$list = $this->person->getAfiller();
			// var_dump($list);
			// exit;
			$data = array();
			$no = $_POST['start'];
			$nomor=0;
			foreach ($list as $filler) {
				$no++;
				$row = array();
				$row[] = $filler->code;
				$row[] = $filler->name;

				//add html for action
				$row[] = '<a class="btn btn-sm btn-primary" href="javascript:void(0)" title="Edit" onclick="edit_afiller('."'".$filler->id."'".')"><i class="glyphicon glyphicon-pencil"></i> Edit</a>
					  <a class="btn btn-sm btn-danger" href="javascript:void(0)" title="Hapus" onclick="delete_afiller('."'".$filler->id."'".')"><i class="glyphicon glyphicon-trash"></i> Delete</a>';
			
				$data[] = $row;
			}

			$output1 = array(
							"draw" => $_POST['draw'],
							"recordsTotal" => $this->person->countAfiller(),
							"recordsFiltered" => $this->person->countAfiller_filtered(),
							"data" => $data,
					);
			//output to json format
			echo json_encode($output1);			

			exit;
		}

		if ( $action == 'u' ) {
			$this->_validatefillers();
			
			$data = $this->input->post();
			if ( empty($data) ) 
				crud_error("Error: Empty Data !");			
			$this->db->trans_begin();
			
			try {
				$data1['code'] 				= strtoupper($data['codefiller']);
				$data1['name'] 				= strtoupper($data['name']);
				$data1['modified_id']   	= $user_id;
				$data1['modified_date'] 	= date('Y-m-d H:i:s');
				$this->db->update( 'a_filler', $data1, array('id'=>$data['id']) );
				
			} catch (Exception $e) {  
				crud_error( $e->getMessage() );
			} 
			
			$this->db->trans_commit();
			echo json_encode(array("status"=>true));
			return;
		}

		if ( $action == 'd' ) {
			$data = $this->input->post();
			$this->db->trans_begin();

			try {
				$data1['deleted']     = 1;
				$data1['modified_id']   	= $user_id;
				$data1['modified_date'] 	= date('Y-m-d H:i:s');
				$this->db->update( 'a_filler', $data1, array('id'=>$data['id']) );
				
			} catch (Exception $e) {  
				crud_error( $e->getMessage() );
			} 
			
			$this->db->trans_commit();
			echo json_encode(array("status"=>TRUE));
			return;
		}

		if ( !is_allow('r', $this->mdl_grp, $mdl) )
			show_error(l('permission_failed_menu'));
		
		$this->getme_lib->go( $this->mdl_grp, $mdl );
	}

	public function filler_edit($id)
	{
		$data = $this->person->getAfiller_by_id($id);
		echo json_encode($data);
	}

	private function _validatefillers()
	{
		$data = array();
		$data['error_string'] = array();
		$data['inputerror'] = array();
		$data['status'] = TRUE;

		if($this->input->post('codefiller') == '')
		{
			$data['inputerror'][] = 'codefiller';
			$data['error_string'][] = 'Code is required';
			$data['status'] = FALSE;
		}

		if($this->input->post('name') == '')
		{
			$data['inputerror'][] = 'name';
			$data['error_string'][] = 'Name is required';
			$data['status'] = FALSE;
		}

		if($data['status'] === FALSE)
		{
			echo json_encode($data);
			exit();
		}
	}

	function flangs( $action=NULL) {
		if (!$this->ion_auth->logged_in()) 
			redirect('main', 'refresh');

		$mdl 	 	= 'FLANG_SIZE';
		$user_id	= $this->session->userdata('user_id');
		$company_id	 	= $this->session->userdata('company_id');
		$department_id	= $this->session->userdata('department_id');
		
		if ( $action == 'c' ){
			$this->_validateflangs();

			$data = $this->input->post();
			if ( empty($data) ) 
				crud_error("Error: Empty Data !");

			$this->db->trans_begin();
			try {
				$data1['code'] 	   		= strtoupper($data['codeflang']);
				$data1['name'] 			= strtoupper($data['name']);
				$data1['created_id']   	= $user_id;
				$data1['modified_id']   = $user_id;
				$data1['created_date'] 	= date('Y-m-d H:i:s');
				$data1['modified_date'] = date('Y-m-d H:i:s');
				$data1['deleted'] 		= 0;
			
				$this->db->insert('a_flang_size', $data1);
				$id = $this->db->insert_id();
				
			} catch (Exception $e) {  
				crud_error($e->getMessage());
			} 
			
			$this->db->trans_commit();
			echo json_encode(array("status"=>TRUE));
			exit;
		}
		if ( $action == 'r' ) {
			$list = $this->person->getAflang();
			$data = array();
			$no = $_POST['start'];
			$nomor=0;
			foreach ($list as $flang) {
				$no++;
				$row = array();
				$row[] = $flang->code;
				$row[] = $flang->name;

				//add html for action
				$row[] = '<a class="btn btn-sm btn-primary" href="javascript:void(0)" title="Edit" onclick="edit_aflang('."'".$flang->id."'".')"><i class="glyphicon glyphicon-pencil"></i> Edit</a>
					  <a class="btn btn-sm btn-danger" href="javascript:void(0)" title="Hapus" onclick="delete_aflang('."'".$flang->id."'".')"><i class="glyphicon glyphicon-trash"></i> Delete</a>';
			
				$data[] = $row;
			}

			$output1 = array(
							"draw" => $_POST['draw'],
							"recordsTotal" => $this->person->countAflang(),
							"recordsFiltered" => $this->person->countAflang_filtered(),
							"data" => $data,
					);
			//output to json format
			echo json_encode($output1);			

			exit;
		}

		if ( $action == 'u' ) {
			$this->_validateflangs();
			
			$data = $this->input->post();
			if ( empty($data) ) 
				crud_error("Error: Empty Data !");			
			$this->db->trans_begin();
			
			try {
				$data1['code'] 				= strtoupper($data['codeflang']);
				$data1['name'] 				= strtoupper($data['name']);
				$data1['modified_id']   	= $user_id;
				$data1['modified_date'] 	= date('Y-m-d H:i:s');
				$this->db->update( 'a_flang_size', $data1, array('id'=>$data['id']) );
				
			} catch (Exception $e) {  
				crud_error( $e->getMessage() );
			} 
			
			$this->db->trans_commit();
			echo json_encode(array("status"=>true));
			return;
		}

		if ( $action == 'd' ) {
			$data = $this->input->post();
			$this->db->trans_begin();

			try {
				$data1['deleted']     = 1;
				$data1['modified_id']   	= $user_id;
				$data1['modified_date'] 	= date('Y-m-d H:i:s');
				$this->db->update( 'a_flang_size', $data1, array('id'=>$data['id']) );
				
			} catch (Exception $e) {  
				crud_error( $e->getMessage() );
			} 
			
			$this->db->trans_commit();
			echo json_encode(array("status"=>TRUE));
			return;
		}

		if ( !is_allow('r', $this->mdl_grp, $mdl) )
			show_error(l('permission_failed_menu'));
		
		$this->getme_lib->go( $this->mdl_grp, $mdl );
	}

	public function flang_edit($id)
	{
		$data = $this->person->getAflang_by_id($id);
		echo json_encode($data);
	}

	private function _validateflangs()
	{
		$code=$this->input->post('codeflang');
		// var_dump($code);
		// exit;
		$data = array();
		$data['error_string'] = array();
		$data['inputerror'] = array();
		$data['status'] = TRUE;

		if(!ctype_digit($code))
		{
			$data['inputerror'][] = 'codeflang';
			$data['error_string'][] = 'Number is required';
			$data['status'] = FALSE;
		}

		if($this->input->post('name') == '')
		{
			$data['inputerror'][] = 'name';
			$data['error_string'][] = 'Name is required';
			$data['status'] = FALSE;
		}

		if($data['status'] === FALSE)
		{
			echo json_encode($data);
			exit();
		}
	}


}