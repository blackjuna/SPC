<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

// session_start(); //we need to call PHP's session object to access it through CI

class Qc extends CI_Controller {

	public $mdl_grp		= 'qc';

	function __construct() {
		parent::__construct();
		date_default_timezone_set('Asia/Jakarta');
		
		$this->load->model('qc_model','qc_m');
	}

	function index() {
		if (!$this->ion_auth->logged_in())
			redirect('main', 'refresh');
		
		redirect('main', 'refresh');
	}

	/*Setting Variabel Global*/
	public function set_size()
	{
		$data = $this->qc_m->getsize($id);
		echo json_encode($data);
	}

	public function get_asme($id=null)
	{
		$data = $this->qc_m->getasme($id);
		echo json_encode($data);
	}
	/*Setting Variabel Global*/

	/*Mulai Blanking*/
	public function blanking_chart_all($id)
	{
		$columns=array();
		$data = array();
		$listTime = $this->qc_m->getAllblankingTime_query($id);
		$l = 0; $c = 0; $avg=0; $rangeR=0;
		foreach ($listTime as $i) {
			$listDt = $this->qc_m->getAllblankingData_query($i->id_time);
			$l1=0; $sum=0; $max=0; $min=0; $numbers=array();
			foreach ($listDt as $j) {
				$sum += $j->value;
				$numbers[] = $j->value;

				$l1++;
			}
			$avg += $sum/$l1;
			$rangeR += max($numbers) - min($numbers);

			// $data[$l]['time']=date("h:i:sa",strtotime($i->time));
			$data[$l]['time']=$i->time;
			$data[$l]['avg']=round($sum/$l1,2);
			$data[$l]['range']=round($rangeR,2);
			$data[$l]['usl']=round($i->d1usl,2);	
			$data[$l]['lsl']=round($i->d1lsl,2);	

			$a2=round($i->a2,2);
			$d3_1=round($i->D3_1,2);
			$d4=round($i->d4,2);				

			$l++;
		}
		$xbar = $avg/count($listTime);
		$rbar = $rangeR/count($listTime);

		$l = 0; $c = 0; 
		foreach ($data as $rows) {
			$xlcl=0;$xcl=0;$xucl=0;
			$rlcl=0;$rcl=0;$rucl=0;

			/*Parameter Chart Xbar*/
			$xlcl =($xbar-($a2*$rbar));
			$xcl =$xbar;
			$xucl =($xbar+($a2*$rbar));
			/*Parameter Chart Xbar*/

			$data[$l]['xlcl']=round($xlcl,2);
			$data[$l]['xcl']=round($xcl,2);
			$data[$l]['xucl']=round($xucl,2);

			/*Parameter Chart Rbar*/
			$rlcl =$d3_1*$rbar;
			$rcl =$rbar;
			$rucl =$d4*$rbar;
			/*Parameter Chart Rbar*/

			$data[$l]['rlcl']=round($rlcl,2);
			$data[$l]['rcl']=round($rcl,2);
			$data[$l]['rucl']=round($rucl,2);

			$l++;
		}
		// var_dump($data);
		echo json_encode($data);
		// echo $rangeR;
		exit;
	}

	public function blankingall($id)
	{
		$columns=array();
		$data = array();
		$listTime = $this->qc_m->getAllblankingTime_query($id);
		$countTime = count($listTime);
		// echo $countTime;
		// 	exit;
		$l = 0; $c = 0; 
		foreach ($listTime as $i) {
			$columns[] = $i->time;
			$listDt = $this->qc_m->getAllblankingData_query($i->id_time);
			$countDt = count($listDt);
			
			$l1=0; $sum = 0; $sumArray[]=0;
			foreach ($listDt as $j) {
				$data[$l1][$l] = $j->value;				
				$l1++;
			}
			$l++;
		}
		
		$columns[] = "Average";
		$avgRow = 0;
		$l = 0; $c = 0; 
		foreach ($data as $rows) {
			foreach ($rows as $val) {
				$avgRow += $val;
				$c++;
			}
			$data[$l][$c] = $avgRow/$c;
			$avgRow = 0; $c = 0;
			$l++;
		}

		$output2 = array(
						// "draw" => $_POST['draw'],
						"draw" => 1,
						"recordsTotal" => $this->qc_m->countblankingall($id),
						"recordsFiltered" => $this->qc_m->countblankingall_filtered($id),
						"columns" => $columns,
						"data" => $data,
				);
		//output to json format
		echo json_encode($output2);			
		exit;
	}

	public function blankingall_dt($id)
	{
		$columns=array();
		$data = array();
		$listTime = $this->qc_m->getAllblankingTime_query($id);
		$l = 0; $c = 0;
		foreach ($listTime as $i) {
			$columns[] = $i->time;

			$listDt = $this->qc_m->getAllblankingData_query($i->id_time);
			$l1=0; $sum = 0; $sumArray[]=0; $max = 0; $min = 0; $numbers=array();
			foreach ($listDt as $j) {
				$sum += $j->value;
				$numbers[]=$j->value;
				$max = max($numbers);
				$min = min($numbers);
				// $sumArray[$l]+=$j->value;
				$l1++;
			}
			
			$data[0][$l] =$sum;
			$data[1][$l] =$sum/$l1;
			$data[2][$l] =$max-$min;

			// $data[3][$l] =$max-(($i->a2)*);
			
			$a2=$i->a2;
			$d3_1=$i->D3_1;
			$d4=$i->d4;		

			$l++;
		}

		$columns[] = "Average";
		$avgRow = 0;
		$l = 0; $c = 0; 
		foreach ($data as $rows) {
			foreach ($rows as $val) {
				$avgRow += $val;
				$c++;
			}
			$data[$l][$c] = $avgRow/$c;
			$avgRow = 0; $c = 0;
			$l++;
		}

		$xbar=0;$xlcl=0;$xcl=0;$xucl=0;$rbar=0;$rlcl=0;$rcl=0;$rucl=0;

		$xbar=$data[1][$c];
		$rbar=$data[2][$c];

		/*Parameter Chart Xbar*/
		$xlcl =($xbar-($a2*$rbar));
		$xcl =$xbar;
		$xucl =($xbar+($a2*$rbar));
		/*Parameter Chart Xbar*/

		/*Parameter Chart Rbar*/
		$rlcl =$d3_1*$rbar;
		$rcl =$rbar;
		$rucl =$d4*$rbar;
		/*Parameter Chart Rbar*/

		$output2 = array(
						// "draw" => $_POST['draw'],
						"draw" => 1,
						"recordsTotal" => $this->qc_m->countblankingall($id),
						"recordsFiltered" => $this->qc_m->countblankingall_filtered($id),
						"columns" => $columns,
						"data" => $data,
				);
		//output to json format
		echo json_encode($output2);			
		exit;
	}

	public function blanking( $action=NULL ) {
		if (!$this->ion_auth->logged_in()) 
			redirect('main', 'refresh');

		$mdl 	 		= 'BLANKING';
		$user_id		= $this->session->userdata('user_id');
		$company_id	 	= $this->session->userdata('company_id');
		$department_id	= $this->session->userdata('department_id');
		
		if ( $action == 'c' ){
			$this->_validateblanking();

			$data = $this->input->post();
			if ( empty($data) ) 
				crud_error("Error: Empty Data !");


			$this->db->trans_begin();
			try {
				$data1['date_process'] 	   	= date('Y-m-d');
				$data1['id_process	'] 	   	= 4;
				if(isset($data['standar']) && !empty($data['standar'])){
					$standar_asme=$data['standar'];
				}else{
					$standar_asme=1;
				}

				$data3=$this->qc_m->get_mdlasme($data['flange_size'], $data['class'], (int)$standar_asme);
				$data1['id_asme'] 			= (int)$data3->id;
				$data1['id_control_chart']	= $data['sample'];
				// $data1['id_dept']   		= $user_id;
				$data1['or_ir']				= $data['ir_or'];
				$data1['diameter']  		= $data['diameter'];
				// $data1['defective']  		= $user_id;
				// $data1['answer_defective']  = $user_id;
				$data1['created_id'] 		= $user_id;
				$data1['modified_id']  	 	= $user_id;
				$data1['created_date'] 		= date('Y-m-d H:i:s');
				$data1['modified_date'] 	= date('Y-m-d H:i:s');
				$data1['deleted'] 			= 0;
			
				$this->db->insert('p_blanking', $data1);
				$id_blanking = $this->db->insert_id();


				$data2['id_blanking'] 		= $id_blanking;
				$data2['time'] 				= date('Y-m-d H:i:s');
				$data2['created_id'] 		= $user_id;
				$data2['modified_id']  	 	= $user_id;
				$data2['created_date'] 		= date('Y-m-d H:i:s');
				$data2['modified_date'] 	= date('Y-m-d H:i:s');
				$data2['deleted'] 			= 0;
				$this->db->insert('p_blanking_time', $data2);
				$id_blanking_time = $this->db->insert_id();

			    foreach ($data['dataf'] as $i) { // need index to match other properties
			    	$data4['id_blanking_time'] 	= $id_blanking_time;
			        $data4['value'] 			= $i;
			        $data4['created_id'] 		= $user_id;
					$data4['modified_id']  	 	= $user_id;
					$data4['created_date'] 		= date('Y-m-d H:i:s');
					$data4['modified_date'] 	= date('Y-m-d H:i:s');
					$data4['deleted'] 			= 0;

			        $this->db->insert('p_blanking_dt', $data4);
			    }
				
			} catch (Exception $e) {  
				crud_error($e->getMessage());
			} 
			
			$this->db->trans_commit();
			echo json_encode(array("status"=>TRUE));
			exit;
		}

		if ( $action == 'r' ) {
			$list = $this->qc_m->getblanking();
			$data = array();
			foreach ($list as $blanking) {
				$blanking->DT_RowId = $blanking->id;
				$blanking->tes = '<a class="btn btn-sm btn-primary" href="javascript:void(0)" title="Edit" onclick="edit_blanking('."'".$blanking->id."'".')"><i class="glyphicon glyphicon-pencil"></i> Edit</a>
					  <a class="btn btn-sm btn-danger" href="javascript:void(0)" title="Hapus" onclick="delete_blanking('."'".$blanking->id."'".')"><i class="glyphicon glyphicon-trash"></i> Delete</a>';
				
				$data[] = $blanking;
			}

			$output1 = array(
							"draw" => $_POST['draw'],
							"recordsTotal" => $this->qc_m->countblanking(),
							"recordsFiltered" => $this->qc_m->countblanking_filtered(),
							"data" => $data,
							// "cbprocess" => $this->qc_m->get_process(),
					);
			// return $response;

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
				$data1['modified_id']   	= $user_id;
				$data1['modified_date'] 	= date('Y-m-d H:i:s');
				$this->db->update( 'p_blanking', $data1, array('id'=>$data['id']) );
				
			} catch (Exception $e) {  
				crud_error( $e->getMessage() );
			} 
			
			$this->db->trans_commit();
			echo json_encode(array("p_blanking"=>true));
			return;
		}

		if ( $action == 'd' ) {
			$data = $this->input->post();
			$this->db->trans_begin();

			try {
				$data1['deleted']     = 1;
				$data1['modified_id']   	= $user_id;
				$data1['modified_date'] 	= date('Y-m-d H:i:s');
				$this->db->update( 'p_blanking', $data1, array('id'=>$data['id']) );
				
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

	public function blanking_dt( $action=NULL ) {
		if (!$this->ion_auth->logged_in()) 
			redirect('main', 'refresh');

		$mdl 	 		= 'BLANKING';
		$user_id		= $this->session->userdata('user_id');
		$company_id	 	= $this->session->userdata('company_id');
		$department_id	= $this->session->userdata('department_id');
		
		if ( $action == 'c' ){
			$this->_validateblankingdt();

			$data = $this->input->post();
			if ( empty($data) ) 
				crud_error("Error: Empty Data !");


			$this->db->trans_begin();
			try {

				$data1['date_process'] 	   	= date('Y-m-d');
				$data1['id_process	'] 	   	= 4;
				if(isset($data['standar']) && !empty($data['standar'])){
					$standar_asme=$data['standar'];
				}else{
					$standar_asme=1;
				}

				$data2['id_blanking'] 		= $data['id_blanking'];
				$data2['time'] 				= date('Y-m-d H:i:s');
				$data2['created_id'] 		= $user_id;
				$data2['modified_id']  	 	= $user_id;
				$data2['created_date'] 		= date('Y-m-d H:i:s');
				$data2['modified_date'] 	= date('Y-m-d H:i:s');
				$data2['deleted'] 			= 0;
				$this->db->insert('p_blanking_time', $data2);
				$id_blanking_time = $this->db->insert_id();

			    foreach ($data['datafe'] as $i) { // need index to match other properties
			    	$data4['id_blanking_time'] 	= $id_blanking_time;
			        $data4['value'] 			= $i;
			        $data4['created_id'] 		= $user_id;
					$data4['modified_id']  	 	= $user_id;
					$data4['created_date'] 		= date('Y-m-d H:i:s');
					$data4['modified_date'] 	= date('Y-m-d H:i:s');
					$data4['deleted'] 			= 0;

			        $this->db->insert('p_blanking_dt', $data4);
			    }
				
			} catch (Exception $e) {  
				crud_error($e->getMessage());
			} 
			
			$this->db->trans_commit();
			echo json_encode(array("status"=>TRUE));
			exit;
		}

		if ( $action == 'd' ) {
			$data = $this->input->post();
			$this->db->trans_begin();

			try {
				$data1['deleted']     = 1;
				$data1['modified_id']   	= $user_id;
				$data1['modified_date'] 	= date('Y-m-d H:i:s');
				$this->db->update( 'p_blanking_time', $data1, array('id'=>$data['id']) );
				$this->db->update( 'p_blanking_dt', $data1, array('id_blanking_time'=>$data['id']) );
				
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

	public function _validateblanking()
	{
		$data = array();
		$data['error_string'] = array();
		$data['inputerror'] = array();
		$data['status'] = TRUE;

		if($this->input->post('date_process') == '')
		{
			$data['inputerror'][] = 'date_process';
			$data['error_string'][] = 'date is required';
			$data['status'] = FALSE;
		}

		if($this->input->post('flange_size') == '')
		{
			$data['inputerror'][] = 'Size';
			$data['error_string'][] = 'Size is required';
			$data['status'] = FALSE;
		}

		if($this->input->post('class') == '')
		{
			$data['inputerror'][] = 'Class';
			$data['error_string'][] = 'Class is required';
			$data['status'] = FALSE;
		}

		if($this->input->post('sample') == '')
		{
			$data['inputerror'][] = 'Data';
			$data['error_string'][] = 'Data is required';
			$data['status'] = FALSE;
		}

		if($this->input->post('ir_or') == '')
		{
			$data['inputerror'][] = 'IR/OR';
			$data['error_string'][] = 'IR/OR is required';
			$data['status'] = FALSE;
		}

		if($this->input->post('diameter') == '')
		{
			$data['inputerror'][] = 'Diameter';
			$data['error_string'][] = 'Diameter is required';
			$data['status'] = FALSE;
		}

		if($data['status'] === FALSE)
		{
			echo json_encode($data);
			exit();
		}
	}

	public function _validateblankingdt()
	{
		$data = array();
		$listdata=$this->input->post('datafe');
		$data['error_string'] = array();
		$data['inputerror'] = array();
		$data['status'] = TRUE;

		foreach ($listdata as $i) { // need index to match other properties
	    	if($i =='')
	    	{
	    		$data['inputerror'][] = 'datafe';
				$data['error_string'][] = 'data is requeired';
				$data['status'] = FALSE;	
	    	}
	    }

		if($data['status'] === FALSE)
		{
			echo json_encode($data);
			exit();
		}
	}

	public function export_blanking()
	{
		if (!$this->ion_auth->logged_in())
			redirect('main', 'refresh');

		$data = $this->input->post();	// get data from ajax

		if ( empty($data) ) 
			crud_error("Error: Empty Data !");


		$type = "SUMMARY BLANKING";

		$data = $this->input->post();   // get data from ajax

        if ( empty($data) ) 
            crud_error("Error: Empty Data !");
        
        if(isset($data['standar']) && !empty($data['standar'])){
            $standar_asme=$data['standar'];
        }else{
            $standar_asme=1;
        }

        $data3=$this->qc_m->get_mdlasme($data['size'], $data['class'], (int)$standar_asme);

        $this->db->select('a0.id as id, a1.process_name as proc_name,a0.date_process as date_process,a6.a2 as a2,a6.d3 as d3_kecil,a6.d4 as d4,a1.ctq as ctq,a3.dimension_name as dim_name,a2.d1lsl as d1lsl,a2.d1usl as d1usl,a2.d2lsl as d2lsl,a2.d2usl as d2usl,a2.d3lsl as d3lsl,a2.d3usl as d3usl,a2.d4lsl as d4lsl,a2.d4usl as d4usl,a4.code as code_class, a5.code as code_size,a6.sample, a6.A3,a6.D3_1 as D3,a6.D4,a0.or_ir,a0.diameter,b0.time,c0.value');
        $params['table'] = 'p_blanking';
        $this->db->from($params['table'].' as a0');
        $this->db->join('p_blanking_time as b0', 'b0.id_blanking=a0.id', 'left');
        $this->db->join('p_blanking_dt as c0', 'c0.id_blanking_time=b0.id', 'left');
        $this->db->join('k_process as a1', 'a1.id=a0.id_process', 'left');
        $this->db->join('k_asme as a2', 'a2.id=a0.id_asme', 'left');
        $this->db->join('k_dimension as a3', 'a3.id=a2.id_dimension', 'left');
        $this->db->join('a_class as a4', 'a4.id=a2.id_class', 'left');
        $this->db->join('a_flang_size as a5', 'a5.id=a2.id_flange', 'left');
        $this->db->join('k_control_chart as a6', 'a6.id=a0.id_control_chart', 'left');
        $this->db->where('a0.id_process ', 4);
        $this->db->where('a0.date_process >= ', date("Y/m/d", strtotime($data['datef'])));
        $this->db->where('a0.date_process <= ', date("Y/m/d", strtotime($data['datet'])));
        $this->db->where('a0.or_ir', $data['ir_or']);
        $this->db->where('a0.diameter', $data['diameter']);
        $this->db->where('a0.id_asme', (int)$data3->id);
        $this->db->where('a0.deleted', 0);
        $this->db->where('b0.deleted', 0);
        $this->db->where('c0.deleted', 0);


		$qry = $this->db->get();
		
		// ================================================================================================
		$this->load->library('Excel');

		$objPHPExcel = new PHPExcel();

		$objPHPExcel->getProperties()->setTitle("export")->setDescription("none");
 
		$objPHPExcel->setActiveSheetIndex(0);
		// ob_start();
		// Field names in the first row
		$fields = $qry->list_fields();
		$col = 0;
		foreach ($fields as $field) {
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, 1, $field);
			$col++;
		}
		
		// Fetching the table data
		$row = 2;
		foreach($qry->result() as $data) {
			$col = 0;
			foreach ($fields as $field) {
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $data->$field);
				$col++;
			}
			$row++;
		}
 
		// ================ AUTO SIZE ==================
		$columns = array('A');
		$current = 'A';
		while ($current != 'AZ') {
			$columns[] = ++$current;
		}
		foreach($columns as $column) {
			$objPHPExcel->getActiveSheet()->getColumnDimension($column)->setAutoSize(true);
		}
		// ================ AUTO SIZE ==================
		
		// Sending headers to force the user to download the file
		header('Set-Cookie: fileDownload=true; path=/');
		header("Content-Type: application/vnd.ms-excel");
		header("Content-Disposition: attachment; filename='Blanking.xls'");
		header("Cache-Control: max-age=0");
		// setcookie("fileDownload", "true", time() - 3600, "/");
		// setcookie("fileDownload", "true", time() - 3600);
		
		$objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
		ob_start();
		$objWriter->save('php://output');
		$xlsData = ob_get_contents();
		ob_end_clean();

		$response =  array(
		        'op' => 'ok',
		        'file' => "data:application/vnd.ms-excel;base64,".base64_encode($xlsData)
		    );

		die(json_encode($response));
	}
	
	public function search_blanking()
	{
		if (!$this->ion_auth->logged_in())
			redirect('main', 'refresh');

		$mdl 	 		= 'BLANKING';
		$user_id		= $this->session->userdata('user_id');
		$company_id	 	= $this->session->userdata('company_id');
		$department_id	= $this->session->userdata('department_id');

		$list = $this->qc_m->search_blanking_query();
		$data = array();
		// $draw=array();
		foreach ($list as $blanking_search) {
			$blanking_search->DT_RowId = $blanking_search->id;
			$blanking_search->action = '<a class="btn btn-sm btn-primary" href="javascript:void(0)" title="Edit" onclick="edit_blanking('."'".$blanking_search->id."'".')"><i class="glyphicon glyphicon-pencil"></i> Edit</a>
				  <a class="btn btn-sm btn-danger" href="javascript:void(0)" title="Hapus" onclick="delete_blanking('."'".$blanking_search->id."'".')"><i class="glyphicon glyphicon-trash"></i> Delete</a>';
			// edit_blanking('."'".$blanking_search->id."'".')
			$data[] = $blanking_search;
		}

		$output1 = array(
						// "draw" => 1,
						// "draw" => isset($_POST['draw']),
						"recordsTotal" => count($list),
						"recordsFiltered" => count($list),
						"data" => $data,

				);

		echo json_encode($output1);
		// echo $rangeR;
		exit;
	}
	
	public function blanking_edit($id)
	{
		$data = $this->qc_m->getAllblankingedit_query($id);
		echo json_encode($data);
	}
	public function blanking_time_edit($id)
	{
		$counttime=array();
		$data = array();			
		$data = $this->qc_m->getAllblanking_time_edit_query($id);
		$counttime = count($data);

		$output1 = array(
							"draw" => $_POST['draw'],
							"recordsTotal" => $counttime,
							"recordsFiltered" => $counttime,
							"data" => $data,
							// "cbprocess" => $this->qc_m->get_process(),
					);

		echo json_encode($output1);
	}
	public function blanking_dt_edit($id)
	{
		$data = $this->qc_m->getAllblanking_dt_edit_query($id);

		$counttime = count($data);

		$output1 = array(
							"draw" => $_POST['draw'],
							"recordsTotal" => $counttime,
							"recordsFiltered" => $counttime,
							"data" => $data,
							// "cbprocess" => $this->qc_m->get_process(),
					);

		echo json_encode($output1);
	}
	/*Selesai Blanking*/

	/*Mulai Turning Dimensi*/
	public function turning_dimensi_all($id)
	{
		$columns=array();
		$data = array();
		$listTime = $this->qc_m->getAll_turning_dimensi_Time_query($id);
		$l = 0; $c = 0; 
		foreach ($listTime as $i) {
			$columns[] = $i->time;
			$listDt = $this->qc_m->getAll_turning_dimensi_Data_query($i->id_time);
			$l1=0; $sum = 0; $sumArray[]=0;
			foreach ($listDt as $j) {
				$data[$l1][$l] = $j->value;
				
				$l1++;
			}
			$l++;
		}

		$output2 = array(
						// "draw" => $_POST['draw'],
						"draw" => 1,
						"recordsTotal" => $this->qc_m->count_turning_dimensi_all($id),
						"recordsFiltered" => $this->qc_m->count_turning_dimensi_all_filtered($id),
						"columns" => $columns,
						"data" => $data,
				);
		//output to json format
		echo json_encode($output2);			
		exit;
	}

	public function turning_dimensi_all_dt($id)
	{
		$columns=array();
		$data = array();
		$listTime = $this->qc_m->getAll_turning_dimensi_Time_query($id);
		$l = 0; $c = 0;
		foreach ($listTime as $i) {
			$columns[] = $i->time;

			$listDt = $this->qc_m->getAll_turning_dimensi_Data_query($i->id_time);
			$l1=0; $sum = 0; $sumArray[]=0; $max = 0; $min = 0; $numbers=array();
			foreach ($listDt as $j) {
				$sum += $j->value;
				$numbers[]=$j->value;
				$max = max($numbers);
				$min = min($numbers);
				$sumArray[$l]+=$j->value;
				$l1++;
			}
			
			$data[0][$l] =$sum;
			$data[1][$l] =$sum/$l1;
			$data[2][$l] =$max-$min;

			$l++;
		}

		$output2 = array(
						// "draw" => $_POST['draw'],
						"draw" => 1,
						"recordsTotal" => $this->qc_m->count_turning_dimensi_all($id),
						"recordsFiltered" => $this->qc_m->count_turning_dimensi_all_filtered($id),
						"columns" => $columns,
						"data" => $data,
				);
		//output to json format
		echo json_encode($output2);			
		exit;
	}

	public function turning_dimensi( $action=NULL ) {
		if (!$this->ion_auth->logged_in()) 
			redirect('main', 'refresh');

		$mdl 	 		= 'TURNING_DIMENSI';
		$user_id		= $this->session->userdata('user_id');
		$company_id	 	= $this->session->userdata('company_id');
		$department_id	= $this->session->userdata('department_id');
		
		if ( $action == 'c' ){
			$this->_validate_turning_dimensi_();

			$data = $this->input->post();
			if ( empty($data) ) 
				crud_error("Error: Empty Data !");


			$this->db->trans_begin();
			try {
				$data1['date_process'] 	   	= date('Y-m-d');
				$data1['id_process	'] 	   	= 6;
				if(isset($data['standar']) && !empty($data['standar'])){
					$standar_asme=$data['standar'];
				}else{
					$standar_asme=1;
				}

				$data3=$this->qc_m->get_mdlasme($data['flange_size'], $data['class'], (int)$standar_asme);
				$data1['id_asme'] 			= (int)$data3->id;
				$data1['id_control_chart']	= $data['sample'];
				// $data1['id_dept']   		= $user_id;
				$data1['or_ir']				= $data['ir_or'];
				$data1['diameter']  		= $data['diameter'];
				// $data1['defective']  		= $user_id;
				// $data1['answer_defective']  = $user_id;
				$data1['created_id'] 		= $user_id;
				$data1['modified_id']  	 	= $user_id;
				$data1['created_date'] 		= date('Y-m-d H:i:s');
				$data1['modified_date'] 	= date('Y-m-d H:i:s');
				$data1['deleted'] 			= 0;
			
				$this->db->insert('p_turning', $data1);
				$id_turning = $this->db->insert_id();


				$data2['id_turning'] 		= $id_turning;
				$data2['time'] 				= date('Y-m-d H:i:s');
				$data2['created_id'] 		= $user_id;
				$data2['modified_id']  	 	= $user_id;
				$data2['created_date'] 		= date('Y-m-d H:i:s');
				$data2['modified_date'] 	= date('Y-m-d H:i:s');
				$data2['deleted'] 			= 0;
				$this->db->insert('p_turning_time', $data2);
				$id_turning_time = $this->db->insert_id();

			    foreach ($data['dataf'] as $i) { // need index to match other properties
			    	// echo $i;
			    	// // exit;
			    	$data4['id_turning_time'] 	= $id_turning_time;
			        $data4['value'] 			= $i;
			        $data4['created_id'] 		= $user_id;
					$data4['modified_id']  	 	= $user_id;
					$data4['created_date'] 		= date('Y-m-d H:i:s');
					$data4['modified_date'] 	= date('Y-m-d H:i:s');
					$data4['deleted'] 			= 0;

			        $this->db->insert('p_turning_dt', $data4);
			    }
				
			} catch (Exception $e) {  
				crud_error($e->getMessage());
			} 
			
			$this->db->trans_commit();
			echo json_encode(array("status"=>TRUE));
			exit;
		}

		if ( $action == 'r' ) {
			$list = $this->qc_m->get_turning_dimensi();
			$data = array();
			foreach ($list as $turning) {
				$turning->DT_RowId = $turning->id;
				$turning->action = '<a class="btn btn-sm btn-primary" href="javascript:void(0)" title="Edit" onclick="edit_aclass('."'".$turning->id."'".')"><i class="glyphicon glyphicon-pencil"></i> Edit</a>
					  <a class="btn btn-sm btn-danger" href="javascript:void(0)" title="Hapus" onclick="delete_aclass('."'".$turning->id."'".')"><i class="glyphicon glyphicon-trash"></i> Delete</a>';
				
				$data[] = $turning;
			}

			$output1 = array(
							"draw" => $_POST['draw'],
							"recordsTotal" => $this->qc_m->count_turning_dimensi(),
							"recordsFiltered" => $this->qc_m->count_turning_dimensi_filtered(),
							"data" => $data,
							// "cbprocess" => $this->qc_m->get_process(),
					);
			// return $response;

			//output to json format
			echo json_encode($output1);			

			exit;
		}

		if ( $action == 'u' ) {
			$this->_validate_turning_dimensi_();
			
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

	private function _validate_turning_dimensi_()
	{
		$data = array();
		$data['error_string'] = array();
		$data['inputerror'] = array();
		$data['status'] = TRUE;

		if($this->input->post('date') == '')
		{
			$data['inputerror'][] = 'date';
			$data['error_string'][] = 'date is required';
			$data['status'] = FALSE;
		}

		if($this->input->post('flange_size') == '')
		{
			$data['inputerror'][] = 'Size';
			$data['error_string'][] = 'Size is required';
			$data['status'] = FALSE;
		}

		if($this->input->post('class') == '')
		{
			$data['inputerror'][] = 'Class';
			$data['error_string'][] = 'Class is required';
			$data['status'] = FALSE;
		}

		if($this->input->post('sample') == '')
		{
			$data['inputerror'][] = 'Data';
			$data['error_string'][] = 'Data is required';
			$data['status'] = FALSE;
		}

		if($this->input->post('ir_or') == '')
		{
			$data['inputerror'][] = 'IR/OR';
			$data['error_string'][] = 'IR/OR is required';
			$data['status'] = FALSE;
		}

		if($this->input->post('diameter') == '')
		{
			$data['inputerror'][] = 'Diameter';
			$data['error_string'][] = 'Diameter is required';
			$data['status'] = FALSE;
		}

		if($data['status'] === FALSE)
		{
			echo json_encode($data);
			exit();
		}
	}
	/*Selesai Turning Dimensi*/

	/*Mulai Winding Dimensi*/
	public function winding_dimensi_all($id)
	{
		$columns=array();
		$data = array();
		$listTime = $this->qc_m->getAll_winding_dimensi_Time_query($id);
		$l = 0; $c = 0; 
		foreach ($listTime as $i) {
			$columns[] = $i->time;
			$listDt = $this->qc_m->getAll_winding_dimensi_Data_query($i->id_time);
			$l1=0; $sum = 0; $sumArray[]=0;
			foreach ($listDt as $j) {
				$data[$l1][$l] = $j->value;

				
				$l1++;
			}

			$l++;
			// $c++;
		}

		$output2 = array(
						// "draw" => $_POST['draw'],
						"draw" => 1,
						"recordsTotal" => $this->qc_m->count_winding_dimensi_all($id),
						"recordsFiltered" => $this->qc_m->count_winding_dimensi_all_filtered($id),
						"columns" => $columns,
						"data" => $data,
				);
		//output to json format
		echo json_encode($output2);			
		exit;
	}

	public function winding_dimensi_all_dt($id)
	{
		$columns=array();
		$data = array();
		$listTime = $this->qc_m->getAll_winding_dimensi_Time_query($id);
		$l = 0; $c = 0;
		foreach ($listTime as $i) {
			$columns[] = $i->time;

			$listDt = $this->qc_m->getAll_winding_dimensi_Data_query($i->id_time);
			$l1=0; $sum = 0; $sumArray[]=0; $max = 0; $min = 0; $numbers=array();
			foreach ($listDt as $j) {
				$sum += $j->value;
				$numbers[]=$j->value;
				$max = max($numbers);
				$min = min($numbers);
				$sumArray[$l]+=$j->value;
				$l1++;
			}
			
			$data[0][$l] =$sum;
			$data[1][$l] =$sum/$l1;
			$data[2][$l] =$max-$min;

			$l++;
		}

		$output2 = array(
						// "draw" => $_POST['draw'],
						"draw" => 1,
						"recordsTotal" => $this->qc_m->count_winding_dimensi_all($id),
						"recordsFiltered" => $this->qc_m->count_winding_dimensi_all_filtered($id),
						"columns" => $columns,
						"data" => $data,
				);
		//output to json format
		echo json_encode($output2);			
		exit;
	}

	public function winding_dimensi( $action=NULL ) {
		if (!$this->ion_auth->logged_in()) 
			redirect('main', 'refresh');

		$mdl 	 		= 'WINDING_SEALING';
		$user_id		= $this->session->userdata('user_id');
		$company_id	 	= $this->session->userdata('company_id');
		$department_id	= $this->session->userdata('department_id');
		
		if ( $action == 'c' ){
			$this->_validate_winding_dimensi_();

			$data = $this->input->post();
			if ( empty($data) ) 
				crud_error("Error: Empty Data !");

			$this->db->trans_begin();
			try {
				$data1['date_process'] 	   	= date('Y-m-d');
				$data1['id_process	'] 	   	= 11;
				if(isset($data['standar']) && !empty($data['standar'])){
					$standar_asme=$data['standar'];
				}else{
					$standar_asme=1;
				}

				$data3=$this->qc_m->get_mdlasme($data['flange_size'], $data['class'], (int)$standar_asme);
				$data1['id_asme'] 			= (int)$data3->id;
				$data1['id_control_chart']	= $data['sample'];
				// $data1['id_dept']   		= $user_id;
				$data1['or_ir']				= $data['ir_or'];
				$data1['diameter']  		= $data['diameter'];
				// $data1['defective']  		= $user_id;
				// $data1['answer_defective']  = $user_id;
				$data1['created_id'] 		= $user_id;
				$data1['modified_id']  	 	= $user_id;
				$data1['created_date'] 		= date('Y-m-d H:i:s');
				$data1['modified_date'] 	= date('Y-m-d H:i:s');
				$data1['deleted'] 			= 0;
			
				$this->db->insert('p_winding', $data1);
				$id_winding = $this->db->insert_id();


				$data2['id_winding'] 		= $id_winding;
				$data2['time'] 				= date('Y-m-d H:i:s');
				$data2['created_id'] 		= $user_id;
				$data2['modified_id']  	 	= $user_id;
				$data2['created_date'] 		= date('Y-m-d H:i:s');
				$data2['modified_date'] 	= date('Y-m-d H:i:s');
				$data2['deleted'] 			= 0;
				$this->db->insert('p_winding_time', $data2);
				$id_winding_time = $this->db->insert_id();

			    foreach ($data['dataf'] as $i) { // need index to match other properties
			    	$data4['id_winding_time'] 	= $id_winding_time;
			        $data4['value'] 			= $i;
			        $data4['created_id'] 		= $user_id;
					$data4['modified_id']  	 	= $user_id;
					$data4['created_date'] 		= date('Y-m-d H:i:s');
					$data4['modified_date'] 	= date('Y-m-d H:i:s');
					$data4['deleted'] 			= 0;

			        $this->db->insert('p_winding_dt', $data4);
			    }
				
			} catch (Exception $e) {  
				crud_error($e->getMessage());
			} 
			
			$this->db->trans_commit();
			echo json_encode(array("status"=>TRUE));
			exit;
		}

		if ( $action == 'r' ) {
			$list = $this->qc_m->get_winding_dimensi();
			$data = array();
			foreach ($list as $winding) {
				//add html for action
				$winding->DT_RowId = $winding->id;
				$winding->action = '<a class="btn btn-sm btn-primary" href="javascript:void(0)" title="Edit" onclick="edit_aclass('."'".$winding->id."'".')"><i class="glyphicon glyphicon-pencil"></i> Edit</a>
					  <a class="btn btn-sm btn-danger" href="javascript:void(0)" title="Hapus" onclick="delete_aclass('."'".$winding->id."'".')"><i class="glyphicon glyphicon-trash"></i> Delete</a>';
				
				$data[] = $winding;
			}

			$output1 = array(
							"draw" => $_POST['draw'],
							"recordsTotal" => $this->qc_m->count_winding_dimensi(),
							"recordsFiltered" => $this->qc_m->count_winding_dimensi_filtered(),
							"data" => $data,
							// "cbprocess" => $this->qc_m->get_process(),
					);
			// return $response;

			//output to json format
			echo json_encode($output1);			

			exit;
		}

		if ( $action == 'u' ) {
			$this->_validate_winding_dimensi_();
			
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

	private function _validate_winding_dimensi_()
	{
		$data = array();
		$data['error_string'] = array();
		$data['inputerror'] = array();
		$data['status'] = TRUE;

		if($this->input->post('date') == '')
		{
			$data['inputerror'][] = 'date';
			$data['error_string'][] = 'date is required';
			$data['status'] = FALSE;
		}

		if($this->input->post('flange_size') == '')
		{
			$data['inputerror'][] = 'Size';
			$data['error_string'][] = 'Size is required';
			$data['status'] = FALSE;
		}

		if($this->input->post('class') == '')
		{
			$data['inputerror'][] = 'Class';
			$data['error_string'][] = 'Class is required';
			$data['status'] = FALSE;
		}

		if($this->input->post('sample') == '')
		{
			$data['inputerror'][] = 'Data';
			$data['error_string'][] = 'Data is required';
			$data['status'] = FALSE;
		}

		if($this->input->post('ir_or') == '')
		{
			$data['inputerror'][] = 'IR/OR';
			$data['error_string'][] = 'IR/OR is required';
			$data['status'] = FALSE;
		}

		if($this->input->post('diameter') == '')
		{
			$data['inputerror'][] = 'Diameter';
			$data['error_string'][] = 'Diameter is required';
			$data['status'] = FALSE;
		}

		if($data['status'] === FALSE)
		{
			echo json_encode($data);
			exit();
		}
	}
	/*Selesai Winding Dimensi*/

	/*Mulai Welding Dimensi*/
	public function welding_all($id)
	{
		$columns=array();
		$data = array();
		$listTime = $this->qc_m->getAll_welding_Time_query($id);
		$l = 0; $c = 0; 
		foreach ($listTime as $i) {
			$columns[] = $i->time;
			$listDt = $this->qc_m->getAll_welding_Data_query($i->id_time);
			$l1=0; $sum = 0; $sumArray[]=0;
			foreach ($listDt as $j) {
				$data[$l1][$l] = $j->value;				
				$l1++;
			}
			$l++;
			// $c++;
		}

		$output2 = array(
						// "draw" => $_POST['draw'],
						"draw" => 1,
						"recordsTotal" => $this->qc_m->count_welding_all($id),
						"recordsFiltered" => $this->qc_m->count_welding_all_filtered($id),
						"columns" => $columns,
						"data" => $data,
				);
		//output to json format
		echo json_encode($output2);			
		exit;
	}

	public function welding_all_dt($id)
	{
		$columns=array();
		$data = array();
		$listTime = $this->qc_m->getAll_welding_Time_query($id);
		$l = 0; $c = 0;
		foreach ($listTime as $i) {
			$columns[] = $i->time;

			$listDt = $this->qc_m->getAll_welding_Data_query($i->id_time);
			$l1=0; $sum = 0; $sumArray[]=0; $max = 0; $min = 0; $numbers=array();
			foreach ($listDt as $j) {
				$sum += $j->value;
				$numbers[]=$j->value;
				$max = max($numbers);
				$min = min($numbers);
				$sumArray[$l]+=$j->value;
				$l1++;
			}
			
			$data[0][$l] =$sum;
			$data[1][$l] =$sum/$l1;
			$data[2][$l] =$max-$min;
			$l++;
		}

		$output2 = array(
						// "draw" => $_POST['draw'],
						"draw" => 1,
						"recordsTotal" => $this->qc_m->count_welding_all($id),
						"recordsFiltered" => $this->qc_m->count_welding_all_filtered($id),
						"columns" => $columns,
						"data" => $data,
				);
		//output to json format
		echo json_encode($output2);			
		exit;
	}

	public function welding( $action=NULL ) {
		if (!$this->ion_auth->logged_in()) 
			redirect('main', 'refresh');

		$mdl 	 		= 'WELDING';
		$user_id		= $this->session->userdata('user_id');
		$company_id	 	= $this->session->userdata('company_id');
		$department_id	= $this->session->userdata('department_id');
		
		if ( $action == 'c' ){
			$this->_validate_welding_();

			$data = $this->input->post();
			if ( empty($data) ) 
				crud_error("Error: Empty Data !");

			$this->db->trans_begin();
			try {
				$data1['date_process'] 	   	= date('Y-m-d');
				$data1['id_process	'] 	   	= 5;
				if(isset($data['standar']) && !empty($data['standar'])){
					$standar_asme=$data['standar'];
				}else{
					$standar_asme=1;
				}

				$data3=$this->qc_m->get_mdlasme($data['flange_size'], $data['class'], (int)$standar_asme);
				$data1['id_asme'] 			= (int)$data3->id;
				$data1['id_control_chart']	= $data['sample'];
				// $data1['id_dept']   		= $user_id;
				$data1['or_ir']				= $data['ir_or'];
				$data1['diameter']  		= $data['diameter'];
				// $data1['defective']  		= $user_id;
				// $data1['answer_defective']  = $user_id;
				$data1['created_id'] 		= $user_id;
				$data1['modified_id']  	 	= $user_id;
				$data1['created_date'] 		= date('Y-m-d H:i:s');
				$data1['modified_date'] 	= date('Y-m-d H:i:s');
				$data1['deleted'] 			= 0;
			
				$this->db->insert('p_welding', $data1);
				$id_welding = $this->db->insert_id();


				$data2['id_welding'] 		= $id_welding;
				$data2['time'] 				= date('Y-m-d H:i:s');
				$data2['created_id'] 		= $user_id;
				$data2['modified_id']  	 	= $user_id;
				$data2['created_date'] 		= date('Y-m-d H:i:s');
				$data2['modified_date'] 	= date('Y-m-d H:i:s');
				$data2['deleted'] 			= 0;
				$this->db->insert('p_welding_time', $data2);
				$id_welding_time = $this->db->insert_id();

			    foreach ($data['dataf'] as $i) { // need index to match other properties
			    	// echo $i;
			    	// // exit;
			    	$data4['id_welding_time'] 	= $id_welding_time;
			        $data4['value'] 			= $i;
			        $data4['created_id'] 		= $user_id;
					$data4['modified_id']  	 	= $user_id;
					$data4['created_date'] 		= date('Y-m-d H:i:s');
					$data4['modified_date'] 	= date('Y-m-d H:i:s');
					$data4['deleted'] 			= 0;

			        $this->db->insert('p_welding_dt', $data4);
			    }
				
			} catch (Exception $e) {  
				crud_error($e->getMessage());
			} 
			
			$this->db->trans_commit();
			echo json_encode(array("status"=>TRUE));
			exit;
		}

		if ( $action == 'r' ) {
			$list = $this->qc_m->get_welding();
			$data = array();
			foreach ($list as $welding) {
				$welding->DT_RowId = $welding->id;
				$welding->action = '<a class="btn btn-sm btn-primary" href="javascript:void(0)" title="Edit" onclick="edit_aclass('."'".$welding->id."'".')"><i class="glyphicon glyphicon-pencil"></i> Edit</a>
					  <a class="btn btn-sm btn-danger" href="javascript:void(0)" title="Hapus" onclick="delete_aclass('."'".$welding->id."'".')"><i class="glyphicon glyphicon-trash"></i> Delete</a>';
				
				$data[] = $welding;
			}

			$output1 = array(
							"draw" => $_POST['draw'],
							"recordsTotal" => $this->qc_m->count_welding(),
							"recordsFiltered" => $this->qc_m->count_welding_filtered(),
							"data" => $data,
							// "cbprocess" => $this->qc_m->get_process(),
					);
			// return $response;

			//output to json format
			echo json_encode($output1);			

			exit;
		}

		if ( $action == 'u' ) {
			$this->_validate_welding_();
			
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

	private function _validate_welding_()
	{
		$data = array();
		$data['error_string'] = array();
		$data['inputerror'] = array();
		$data['status'] = TRUE;

		if($this->input->post('date') == '')
		{
			$data['inputerror'][] = 'date';
			$data['error_string'][] = 'date is required';
			$data['status'] = FALSE;
		}

		if($this->input->post('flange_size') == '')
		{
			$data['inputerror'][] = 'Size';
			$data['error_string'][] = 'Size is required';
			$data['status'] = FALSE;
		}

		if($this->input->post('class') == '')
		{
			$data['inputerror'][] = 'Class';
			$data['error_string'][] = 'Class is required';
			$data['status'] = FALSE;
		}

		if($this->input->post('sample') == '')
		{
			$data['inputerror'][] = 'Data';
			$data['error_string'][] = 'Data is required';
			$data['status'] = FALSE;
		}

		if($this->input->post('ir_or') == '')
		{
			$data['inputerror'][] = 'IR/OR';
			$data['error_string'][] = 'IR/OR is required';
			$data['status'] = FALSE;
		}

		if($this->input->post('diameter') == '')
		{
			$data['inputerror'][] = 'Diameter';
			$data['error_string'][] = 'Diameter is required';
			$data['status'] = FALSE;
		}

		if($data['status'] === FALSE)
		{
			echo json_encode($data);
			exit();
		}
	}
	/*Selesai Welding*/

	/*Mulai winding_pressure*/
	public function winding_pressure_all($id)
	{
		$columns=array();
		$data = array();
		$listTime = $this->qc_m->getAll_winding_pressure_Time_query($id);
		$l = 0; $c = 0; 
		foreach ($listTime as $i) {
			$columns[] = $i->time;
			$listDt = $this->qc_m->getAll_winding_pressure_Data_query($i->id_time);
			$l1=0; $sum = 0; $sumArray[]=0;
			foreach ($listDt as $j) {
				$data[$l1][$l] = $j->value;
				$l1++;
			}
			$l++;
		}	

		$output2 = array(
						// "draw" => $_POST['draw'],
						"draw" => 1,
						"recordsTotal" => $this->qc_m->count_winding_pressure_all($id),
						"recordsFiltered" => $this->qc_m->count_winding_pressure_all_filtered($id),
						"columns" => $columns,
						"data" => $data,
				);
		//output to json format
		echo json_encode($output2);			
		exit;
	}

	public function winding_pressure_all_dt($id)
	{
		$columns=array();
		$data = array();
		$listTime = $this->qc_m->getAll_winding_pressure_Time_query($id);
		$l = 0; $c = 0;
		foreach ($listTime as $i) {
			$columns[] = $i->time;

			$listDt = $this->qc_m->getAll_winding_pressure_Data_query($i->id_time);
			$l1=0; $sum = 0; $sumArray[]=0; $max = 0; $min = 0; $numbers=array();
			foreach ($listDt as $j) {
				$sum += $j->value;
				$numbers[]=$j->value;
				$max = max($numbers);
				$min = min($numbers);
				$sumArray[$l]+=$j->value;
				$l1++;
			}
			
			$data[0][$l] =$sum;
			$data[1][$l] =$sum/$l1;
			$data[2][$l] =$max-$min;
			$l++;
		}

		$output2 = array(
						// "draw" => $_POST['draw'],
						"draw" => 1,
						"recordsTotal" => $this->qc_m->count_winding_pressure_all($id),
						"recordsFiltered" => $this->qc_m->count_winding_pressure_all_filtered($id),
						"columns" => $columns,
						"data" => $data,
				);
		//output to json format
		echo json_encode($output2);			
		exit;
	}

	public function winding_pressure( $action=NULL ) {
		if (!$this->ion_auth->logged_in()) 
			redirect('main', 'refresh');

		$mdl 	 		= 'WINDING_PRESSURE';
		$user_id		= $this->session->userdata('user_id');
		$company_id	 	= $this->session->userdata('company_id');
		$department_id	= $this->session->userdata('department_id');
		
		if ( $action == 'c' ){
			$this->_validate_winding_pressure_();

			$data = $this->input->post();
			if ( empty($data) ) 
				crud_error("Error: Empty Data !");

			$this->db->trans_begin();
			try {
				$data1['date_process'] 	   	= date('Y-m-d');
				$data1['id_process	'] 	   	= 10;
				if(isset($data['standar']) && !empty($data['standar'])){
					$standar_asme=$data['standar'];
				}else{
					$standar_asme=1;
				}

				$data3=$this->qc_m->get_mdlasme($data['flange_size'], $data['class'], (int)$standar_asme);
				$data1['id_asme'] 			= (int)$data3->id;
				$data1['id_control_chart']	= $data['sample'];
				// $data1['id_dept']   		= $user_id;
				$data1['or_ir']				= $data['ir_or'];
				$data1['diameter']  		= $data['diameter'];
				// $data1['defective']  		= $user_id;
				// $data1['answer_defective']  = $user_id;
				$data1['created_id'] 		= $user_id;
				$data1['modified_id']  	 	= $user_id;
				$data1['created_date'] 		= date('Y-m-d H:i:s');
				$data1['modified_date'] 	= date('Y-m-d H:i:s');
				$data1['deleted'] 			= 0;
			
				$this->db->insert('p_winding', $data1);
				$id_winding_pressure = $this->db->insert_id();


				$data2['id_winding'] 		= $id_winding_pressure;
				$data2['time'] 				= date('Y-m-d H:i:s');
				$data2['created_id'] 		= $user_id;
				$data2['modified_id']  	 	= $user_id;
				$data2['created_date'] 		= date('Y-m-d H:i:s');
				$data2['modified_date'] 	= date('Y-m-d H:i:s');
				$data2['deleted'] 			= 0;
				$this->db->insert('p_winding_time', $data2);
				$id_winding_pressure_time = $this->db->insert_id();

			    foreach ($data['dataf'] as $i) { // need index to match other properties
			    	// echo $i;
			    	// // exit;
			    	$data4['id_winding_time'] 	= $id_winding_pressure_time;
			        $data4['value'] 			= $i;
			        $data4['created_id'] 		= $user_id;
					$data4['modified_id']  	 	= $user_id;
					$data4['created_date'] 		= date('Y-m-d H:i:s');
					$data4['modified_date'] 	= date('Y-m-d H:i:s');
					$data4['deleted'] 			= 0;

			        $this->db->insert('p_winding_dt', $data4);
			    }
				
			} catch (Exception $e) {  
				crud_error($e->getMessage());
			} 
			
			$this->db->trans_commit();
			echo json_encode(array("status"=>TRUE));
			exit;
		}

		if ( $action == 'r' ) {
			$list = $this->qc_m->get_winding_pressure();
			$data = array();
			foreach ($list as $winding_pressure) {
				//add html for action
				$winding_pressure->DT_RowId = $winding_pressure->id;
				$winding_pressure->action = '<a class="btn btn-sm btn-primary" href="javascript:void(0)" title="Edit" onclick="edit_aclass('."'".$winding_pressure->id."'".')"><i class="glyphicon glyphicon-pencil"></i> Edit</a>
					  <a class="btn btn-sm btn-danger" href="javascript:void(0)" title="Hapus" onclick="delete_aclass('."'".$winding_pressure->id."'".')"><i class="glyphicon glyphicon-trash"></i> Delete</a>';
				
				$data[] = $winding_pressure;
			}

			$output1 = array(
							"draw" => $_POST['draw'],
							"recordsTotal" => $this->qc_m->count_winding_pressure(),
							"recordsFiltered" => $this->qc_m->count_winding_pressure_filtered(),
							"data" => $data,
							// "cbprocess" => $this->qc_m->get_process(),
					);
			// return $response;

			//output to json format
			echo json_encode($output1);			

			exit;
		}

		if ( $action == 'u' ) {
			$this->_validate_winding_pressure_();
			
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

	private function _validate_winding_pressure_()
	{
		$data = array();
		$data['error_string'] = array();
		$data['inputerror'] = array();
		$data['status'] = TRUE;

		if($this->input->post('date') == '')
		{
			$data['inputerror'][] = 'date';
			$data['error_string'][] = 'date is required';
			$data['status'] = FALSE;
		}

		if($this->input->post('flange_size') == '')
		{
			$data['inputerror'][] = 'Size';
			$data['error_string'][] = 'Size is required';
			$data['status'] = FALSE;
		}

		if($this->input->post('class') == '')
		{
			$data['inputerror'][] = 'Class';
			$data['error_string'][] = 'Class is required';
			$data['status'] = FALSE;
		}

		if($this->input->post('sample') == '')
		{
			$data['inputerror'][] = 'Data';
			$data['error_string'][] = 'Data is required';
			$data['status'] = FALSE;
		}

		if($this->input->post('ir_or') == '')
		{
			$data['inputerror'][] = 'IR/OR';
			$data['error_string'][] = 'IR/OR is required';
			$data['status'] = FALSE;
		}

		if($this->input->post('diameter') == '')
		{
			$data['inputerror'][] = 'Diameter';
			$data['error_string'][] = 'Diameter is required';
			$data['status'] = FALSE;
		}

		if($data['status'] === FALSE)
		{
			echo json_encode($data);
			exit();
		}
	}
	/*Selesai winding_pressure*/
}