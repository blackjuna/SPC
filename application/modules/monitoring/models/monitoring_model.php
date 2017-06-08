<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Qc_model extends CI_Model{
	var $column_order_blanking = array('process_name','ctq','dimension_name','a4.code','a5.code',null); //set column field database for datatable orderable
    var $column_search_blanking = array('process_name','ctq','dimension_name','a4.code','a5.code',); //set column field database for datatable searchable just firstname , lastname , address are searchable
    var $column_order_blanking_dt = array('time',null); //set column field database for datatable orderable
    var $column_search_blanking_dt = array('time'); //set column field database for datatable searchable just firstname , lastname , address are searchable
    var $column_order_turning_dimensi = array('process_name','ctq','dimension_name','a4.code','a5.code',null); //set column field database for datatable orderable
    var $column_search_turning_dimensi = array('process_name','ctq','dimension_name','a4.code','a5.code',null); //set column field database for datatable searchable just firstname , lastname , address are searchable
    var $column_order_winding_dimensi = array('process_name','ctq','dimension_name','a4.code','a5.code',null); //set column field database for datatable orderable
    var $column_search_winding_dimensi = array('process_name','ctq','dimension_name','a4.code','a5.code',null); //set column field database for datatable searchable just firstname , lastname , address are searchable
    var $column_order_welding = array('process_name','ctq','dimension_name','a4.code','a5.code',null); //set column field database for datatable orderable
    var $column_search_welding = array('process_name','ctq','dimension_name','a4.code','a5.code',null); //set column field database for datatable searchable just firstname , lastname , address are searchable
    var $column_order_winding_pressure = array('process_name','ctq','dimension_name','a4.code','a5.code',null); //set column field database for datatable orderable
    var $column_search_winding_pressure = array('process_name','ctq','dimension_name','a4.code','a5.code',null); //set column field database for datatable searchable just firstname , lastname , address are searchable

	public function __construct()
	{
		parent::__construct();
	}

    /*Kebutuhan inputan*/
    function getasme()
    {
       $this->db->select('a0.id as id, a1.process_name as proc_name,a0.date_process as date_process,a0.a2 as a2,a0.d3 as d3,a0.d4 as d4,a0.lsl as lsl,a0.usl as usl, a1.ctq as ctq,a3.dimension_name as dim_name,a2.d1lsl as d1lsl,a2.d1usl as d1usl,a2.d2lsl as d2lsl,a2.d2usl as d2usl,a2.d3lsl as d3lsl,a2.d3usl as d3usl,a2.d4lsl as d4lsl,a2.d4usl as d4usl,a4.code as code_class, a5.code as code_size');
        $params['table'] = 'p_blanking';
        $this->db->from($params['table'].' as a0');
        $this->db->join('k_process as a1', 'a0.id_process = a1.id', 'left');
        $this->db->join('k_asme as a2', 'a0.id_process = a2.id', 'left');
        $this->db->join('k_dimension as a3', 'a2.id_dimension = a3.id', 'left');
        $this->db->join('a_class as a4', 'a2.id_class = a4.id', 'left');
        $this->db->join('a_flang_size as a5', 'a2.id_flange = a5.id', 'left');
        $this->db->where('a0.deleted', 0);

        
        $this->db->select('id,process_name,ctq');
        $params['table'] = 'k_process';
        $this->db->from($params['table']);
        $this->db->where('deleted', 0);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } 
    }

    function getsize()
    {  //funtion menampilkan semua provinsi
        $this->db->select('a0.id as id,a0.code as code_size, a0.name as name_size');
        $params['table'] = 'a_flang_size';
        $this->db->from($params['table'].' as a0');
        $this->db->where('a0.deleted', 0);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        }
    }

    function getclass()
    {  //funtion menampilkan semua provinsi
        $this->db->select('a0.id as id,a0.code as code_class, a0.name as name_class');
        $params['table'] = 'a_class';
        $this->db->from($params['table'].' as a0');
        $this->db->where('a0.deleted', 0);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        }
    }

    function getcontrolchart()
    {  //funtion menampilkan semua provinsi
        $this->db->select('a0.id as id,a0.sample as sample');
        $params['table'] = 'k_control_chart';
        $this->db->from($params['table'].' as a0');
        $this->db->where('a0.deleted', 0);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        }
    }

    function get_mdlasme($flang_size,$class_size,$dimension=array())
    {
        $params['table'] = 'k_asme';

        $this->db->select('id');
        $this->db->from($params['table'].' as a0');
        $this->db->where('a0.id_flange', $flang_size);
        $this->db->where('a0.id_class', $class_size);
        $this->db->where('a0.id_dimension', $dimension);
        $this->db->where('a0.deleted', 0);

        return $this->db->get()->row();
    }
    /*Kebutuhan inputan*/

    /*Function crud*/
    function save($data)
    {
        $this->db->insert($this->tabel, $data);
        return $this->db->insert_id();
    }
 
    function update($where, $data)
    {
        $this->db->update($this->tabel, $data, $where);
        return $this->db->affected_rows();
    }
 
    function delete_by_id($id)
    {
        $this->db->where('id', $id);
        $this->db->delete($this->tabel);
    }
    /*End function crud*/


    /*Untuk Mulai Blanking*/
    function getAllblankingchart_query($id)
    {
        $this->db->select('a0.id as id, a1.process_name as proc_name,a0.date_process as date_process,a6.a2 as a2,a6.d3 as d3,a6.d4 as d4,a1.ctq as ctq,a3.dimension_name as dim_name,a2.d1lsl as d1lsl,a2.d1usl as d1usl,a2.d2lsl as d2lsl,a2.d2usl as d2usl,a2.d3lsl as d3lsl,a2.d3usl as d3usl,a2.d4lsl as d4lsl,a2.d4usl as d4usl,a4.code as code_class, a5.code as code_size,a6.sample, a6.A3,a6.D3,a6.D4,a0.or_ir,a0.diameter,b0.time,c0.value');
        $params['table'] = 'p_blanking';
        $this->db->from($params['table'].' as a0');
        $this->db->join('p_blanking_time as b0', 'b0.id_blanking=a0.id', 'left');
        $this->db->join('p_blanking_dt as c0', 'c0.id_blanking_time=a0.id', 'left');
        $this->db->join('k_process as a1', 'a1.id=a0.id_process', 'left');
        $this->db->join('k_asme as a2', 'a2.id=a0.id_asme', 'left');
        $this->db->join('k_dimension as a3', 'a3.id=a2.id_dimension', 'left');
        $this->db->join('a_class as a4', 'a4.id=a2.id_class', 'left');
        $this->db->join('a_flang_size as a5', 'a5.id=a2.id_flange', 'left');
        $this->db->join('k_control_chart as a6', 'a6.id=a0.id_control_chart', 'left');
        $this->db->where('a0.id',$id);
        $this->db->where('a0.deleted', 0);
        $this->db->where('b0.deleted', 0);
        $this->db->where('c0.deleted', 0);

        return $this->db->get()->result();
    }

    function getblanking_query()
    {
        $this->db->select('a0.id as id, a1.process_name as proc_name,a0.date_process as date_process,a6.a2 as a2,a6.d3 as d3,a6.d4 as d4,a1.ctq as ctq,a3.dimension_name as dim_name,a2.d1lsl as d1lsl,a2.d1usl as d1usl,a2.d2lsl as d2lsl,a2.d2usl as d2usl,a2.d3lsl as d3lsl,a2.d3usl as d3usl,a2.d4lsl as d4lsl,a2.d4usl as d4usl,a4.code as code_class, a5.code as code_size,a6.sample, a6.A3,a6.D3,a6.D4,a0.or_ir,a0.diameter');
        $params['table'] = 'p_blanking';
        $this->db->from($params['table'].' as a0');
        $this->db->join('k_process as a1', 'a1.id=a0.id_process', 'left');
        $this->db->join('k_asme as a2', 'a2.id=a0.id_asme', 'left');
        $this->db->join('k_dimension as a3', 'a3.id=a2.id_dimension', 'left');
        $this->db->join('a_class as a4', 'a4.id=a2.id_class', 'left');
        $this->db->join('a_flang_size as a5', 'a5.id=a2.id_flange', 'left');
        $this->db->join('k_control_chart as a6', 'a6.id=a0.id_control_chart', 'left');
        $this->db->where('a0.deleted', 0);

        $i = 0;
    
        foreach ($this->column_search_blanking as $item) // loop column 
        {
            if(isset($_POST['search']['value'])) // if datatable send POST for search
            {
                
                if($i===0) // first loop
                {
                    $this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
                    $this->db->like($item, isset($_POST['search']['value']));
                }
                else
                {
                    $this->db->or_like($item, isset($_POST['search']['value']));
                }

                if(count($this->column_search_blanking) - 1 == $i) //last loop
                    $this->db->group_end(); //close bracket
            }
            $i++;
        }

        if(isset($_POST['order'])) // here order processing
        {
            $this->db->order_by($this->column_order_blanking[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } 
        else if(isset($this->order))
        {
            $order = $this->order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }   

    function getblanking()
    {
        $this->getblanking_query();
        if($_POST['length'] != -1)
        $this->db->limit($_POST['length'], $_POST['start']);
        // $files['data'] = $this->db->get()->result();
        return $this->db->get()->result();
    }

    function countblanking_filtered()
    {
        $this->getblanking_query();
        return $this->db->get()->num_rows();
    }

    function countblanking($tbl1=null)
    {
        $params['table'] = 'p_blanking';

        $this->db->from($params['table']);
        $this->db->where('deleted', 0);
        $num_row = $this->db->count_all_results();

        return $num_row;
    }

    function getAllblanking_query($id)
    {
        $this->db->select('a0.id as id, a1.process_name as proc_name,a0.date_process as date_process,a6.a2 as a2,a6.d3 as d3,a6.d4 as d4,a1.ctq as ctq,a3.dimension_name as dim_name,a2.d1lsl as d1lsl,a2.d1usl as d1usl,a2.d2lsl as d2lsl,a2.d2usl as d2usl,a2.d3lsl as d3lsl,a2.d3usl as d3usl,a2.d4lsl as d4lsl,a2.d4usl as d4usl,a4.code as code_class, a5.code as code_size,a6.sample, a6.A3,a6.D3,a6.D4,a0.or_ir,a0.diameter,b0.time,c0.value');
        $params['table'] = 'p_blanking';
        $this->db->from($params['table'].' as a0');
        $this->db->join('p_blanking_time as b0', 'b0.id_blanking=a0.id', 'left');
        $this->db->join('p_blanking_dt as c0', 'c0.id_blanking_time=a0.id', 'left');
        $this->db->join('k_process as a1', 'a1.id=a0.id_process', 'left');
        $this->db->join('k_asme as a2', 'a2.id=a0.id_asme', 'left');
        $this->db->join('k_dimension as a3', 'a3.id=a2.id_dimension', 'left');
        $this->db->join('a_class as a4', 'a4.id=a2.id_class', 'left');
        $this->db->join('a_flang_size as a5', 'a5.id=a2.id_flange', 'left');
        $this->db->join('k_control_chart as a6', 'a6.id=a0.id_control_chart', 'left');
        $this->db->where('a0.id',$id);
        $this->db->where('a0.deleted', 0);

        return $this->db->get()->result();
    }   

    function getAllblankingTime_query($id)
    {
        $this->db->select('a0.id as id, a1.process_name as proc_name,a0.date_process as date_process,a6.a2 as a2,a6.d3 ,a6.d4 as d4,a1.ctq as ctq,a3.dimension_name as dim_name,a2.d1lsl as d1lsl,a2.d1usl as d1usl,a2.d2lsl as d2lsl,a2.d2usl as d2usl,a2.d3lsl as d3lsl,a2.d3usl as d3usl,a2.d4lsl as d4lsl,a2.d4usl as d4usl,a4.code as code_class, a5.code as code_size,a6.sample, a6.A3,a6.D3_1,a6.D4,a0.or_ir,a0.diameter,b0.time,b0.id as id_time');
        $params['table'] = 'p_blanking';
        $this->db->from($params['table'].' as a0');
        $this->db->join('p_blanking_time as b0', 'b0.id_blanking=a0.id', 'left');
        $this->db->join('k_process as a1', 'a1.id=a0.id_process', 'left');
        $this->db->join('k_asme as a2', 'a2.id=a0.id_asme', 'left');
        $this->db->join('k_dimension as a3', 'a3.id=a2.id_dimension', 'left');
        $this->db->join('a_class as a4', 'a4.id=a2.id_class', 'left');
        $this->db->join('a_flang_size as a5', 'a5.id=a2.id_flange', 'left');
        $this->db->join('k_control_chart as a6', 'a6.id=a0.id_control_chart', 'left');
        $this->db->where('a0.id',$id);
        $this->db->where('a0.deleted', 0);
        $this->db->where('b0.deleted', 0);

        return $this->db->get()->result();
    }   

    function getAllblankingData_query($id)
    {
        $this->db->select('b0.id as id, b0.value as value');
        $params['table'] = 'p_blanking_dt';
        $this->db->from($params['table'].' as b0');
        $this->db->where('b0.id_blanking_time',$id);
        $this->db->where('b0.deleted', 0);

        return $this->db->get()->result();
    }   

    function getAllblankingDt_query($id)
    {
        $this->db->select('a0.id as id, a0.date_process as date_process, a0.or_ir, a0.diameter, c0.value');
        $params['table'] = 'p_blanking';
        $this->db->from($params['table'].' as a0');
        $this->db->join('p_blanking_dt as c0', 'c0.id_blanking_time=a0.id', 'left');
        $this->db->where('a0.id',$id);
        $this->db->where('a0.deleted', 0);

        return $this->db->get()->result();
    }   

    function getblankingall()
    {
        $this->getAllblanking_query();
        if($_POST['length'] != -1)
        $this->db->limit($_POST['length'], $_POST['start']);
        // $files['data'] = $this->db->get()->result();
        return $this->db->get()->result();
    }

    function countblankingall_filtered($id)
    {
        $this->db->select('a0.id as id, a1.process_name as proc_name,a0.date_process as date_process,a6.a2 as a2,a6.d3 as d3,a6.d4 as d4,a1.ctq as ctq,a3.dimension_name as dim_name,a2.d1lsl as d1lsl,a2.d1usl as d1usl,a2.d2lsl as d2lsl,a2.d2usl as d2usl,a2.d3lsl as d3lsl,a2.d3usl as d3usl,a2.d4lsl as d4lsl,a2.d4usl as d4usl,a4.code as code_class, a5.code as code_size,a6.sample, a6.A3,a6.D3,a6.D4,a0.or_ir,a0.diameter,b0.time,c0.value');
        $params['table'] = 'p_blanking';
        $this->db->from($params['table'].' as a0');
        $this->db->join('p_blanking_time as b0', 'b0.id_blanking=a0.id', 'left');
        $this->db->join('p_blanking_dt as c0', 'c0.id_blanking_time=a0.id', 'left');
        $this->db->join('k_process as a1', 'a1.id=a0.id_process', 'left');
        $this->db->join('k_asme as a2', 'a2.id=a0.id_asme', 'left');
        $this->db->join('k_dimension as a3', 'a3.id=a2.id_dimension', 'left');
        $this->db->join('a_class as a4', 'a4.id=a2.id_class', 'left');
        $this->db->join('a_flang_size as a5', 'a5.id=a2.id_flange', 'left');
        $this->db->join('k_control_chart as a6', 'a6.id=a0.id_control_chart', 'left');
        $this->db->where('a0.id',$id);
        $this->db->where('a0.deleted', 0);
        return $this->db->get()->num_rows();
    }

    function countblankingall($tbl1=null)
    {
        $params['table'] = 'p_blanking';

        $this->db->from($params['table'].' as a0');
        $this->db->join('p_blanking_time as b0', 'a0.id=b0.id_blanking', 'left');
        $this->db->join('p_blanking_dt as c0', 'a0.id=c0.id_blanking_time', 'left');
        $this->db->join('k_process as a1', 'a1.id=a0.id_process', 'left');
        $this->db->join('k_asme as a2', 'a2.id=a0.id_asme', 'left');
        $this->db->join('k_dimension as a3', 'a3.id=a2.id_dimension', 'left');
        $this->db->join('a_class as a4', 'a4.id=a2.id_class', 'left');
        $this->db->join('a_flang_size as a5', 'a5.id=a2.id_flange', 'left');
        $this->db->join('k_control_chart as a6', 'a6.id=a0.id_control_chart', 'left');
        $this->db->where('a0.deleted', 0);
        $num_row = $this->db->count_all_results();

        return $num_row;
    }

    function getAllblankingedit_query($id)
    {
        $this->db->select('a0.id as id, a1.process_name as proc_name,a0.date_process as date_process,a6.a2 as a2,a6.d3 as d3_kecil,a6.d4 as d4,a1.ctq as ctq,a3.dimension_name as dim_name,a2.id_dimension,a2.d1lsl as d1lsl,a2.d1usl as d1usl,a2.d2lsl as d2lsl,a2.d2usl as d2usl,a2.d3lsl as d3lsl,a2.d3usl as d3usl,a2.d4lsl as d4lsl,a2.d4usl as d4usl,a4.id as id_class, a5.code as code_size, a5.id as id_flang_size,a6.id as id_sample, a6.A3,a6.D3_1 as D3,a6.D4,a0.or_ir,a0.diameter,b0.time,c0.value');
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
        $this->db->where('a0.id',$id);
        $this->db->where('a0.deleted', 0);
        $this->db->where('b0.deleted', 0);
        $this->db->where('c0.deleted', 0);

        $query = $this->db->get();
        return $query->row();
    }

    function getAllblanking_time_edit_query($id)
    {
        $this->db->select('a0.id as id, a0.time as time');
        $params['table'] = 'p_blanking_time';
        $this->db->from($params['table'].' as a0');
        $this->db->where('a0.id_blanking',$id);
        $this->db->where('a0.deleted', 0);

        $query = $this->db->get();
        return $query->result();
    }

    function getAllblanking_dt_edit_query($id)
    {
        $this->db->select('a0.id as id, a0.value as value');
        $params['table'] = 'p_blanking_dt';
        $this->db->from($params['table'].' as a0');
        $this->db->where('a0.id_blanking_time',$id);
        $this->db->where('a0.deleted', 0);

        $query = $this->db->get();
        return $query->result();
    }
    function search_blanking_query()
    {
        $data = $this->input->post();   // get data from ajax

        if ( empty($data) ) 
            crud_error("Error: Empty Data !");
        
        if(isset($data['standar']) && !empty($data['standar'])){
            $standar_asme=$data['standar'];
        }else{
            $standar_asme=1;
        }

        $data3=$this->qc_m->get_mdlasme($data['size'], $data['class'], (int)$standar_asme);

        $this->db->select('a0.id as id, a1.process_name as proc_name,a0.date_process as date_process,a6.a2 as a2,a6.d3 as d3_kecil,a6.d4 as d4,a1.ctq as ctq,a3.dimension_name as dim_name,a2.d1lsl as d1lsl,a2.d1usl as d1usl,a2.d2lsl as d2lsl,a2.d2usl as d2usl,a2.d3lsl as d3lsl,a2.d3usl as d3usl,a2.d4lsl as d4lsl,a2.d4usl as d4usl,a4.code as code_class, a5.code as code_size,a6.sample, a6.A3,a6.D3_1 as D3,a6.D4,a0.or_ir,a0.diameter');
        $params['table'] = 'p_blanking';
        $this->db->from($params['table'].' as a0');
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

        return $this->db->get()->result();
    }
    
    /*Untuk End Blanking*/
 
    /*Untuk Mulai Turning Dimensi*/
    function get_turning_dimensi_query()
    {
        $this->db->select('a0.id as id, a1.process_name as proc_name,a0.date_process as date_process,a6.a2 as a2,a6.d3 as d3,a6.d4 as d4,a1.ctq as ctq,a3.dimension_name as dim_name,a2.d1lsl as d1lsl,a2.d1usl as d1usl,a2.d2lsl as d2lsl,a2.d2usl as d2usl,a2.d3lsl as d3lsl,a2.d3usl as d3usl,a2.d4lsl as d4lsl,a2.d4usl as d4usl,a4.code as code_class, a5.code as code_size,a6.sample, a6.A3,a6.D3,a6.D4,a0.or_ir,a0.diameter');
        $params['table'] = 'p_turning';
        $this->db->from($params['table'].' as a0');
        $this->db->join('k_process as a1', 'a1.id=a0.id_process', 'left');
        $this->db->join('k_asme as a2', 'a2.id=a0.id_asme', 'left');
        $this->db->join('k_dimension as a3', 'a3.id=a2.id_dimension', 'left');
        $this->db->join('a_class as a4', 'a4.id=a2.id_class', 'left');
        $this->db->join('a_flang_size as a5', 'a5.id=a2.id_flange', 'left');
        $this->db->join('k_control_chart as a6', 'a6.id=a0.id_control_chart', 'left');
        $this->db->where('a0.deleted', 0);

        $i = 0;
    
        foreach ($this->column_search_turning_dimensi as $item) // loop column 
        {
            if($_POST['search']['value']) // if datatable send POST for search
            {
                
                if($i===0) // first loop
                {
                    $this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
                    $this->db->like($item, $_POST['search']['value']);
                }
                else
                {
                    $this->db->or_like($item, $_POST['search']['value']);
                }

                if(count($this->column_search_turning_dimensi) - 1 == $i) //last loop
                    $this->db->group_end(); //close bracket
            }
            $i++;
        }

        if(isset($_POST['order'])) // here order processing
        {
            $this->db->order_by($this->column_order_turning_dimensi[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } 
        else if(isset($this->order))
        {
            $order = $this->order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }  

    function getAll_turning_dimensi_query($id)
    {
        $this->db->select('a0.id as id, a1.process_name as proc_name,a0.date_process as date_process,a6.a2 as a2,a6.d3 as d3,a6.d4 as d4,a1.ctq as ctq,a3.dimension_name as dim_name,a2.d1lsl as d1lsl,a2.d1usl as d1usl,a2.d2lsl as d2lsl,a2.d2usl as d2usl,a2.d3lsl as d3lsl,a2.d3usl as d3usl,a2.d4lsl as d4lsl,a2.d4usl as d4usl,a4.code as code_class, a5.code as code_size,a6.sample, a6.A3,a6.D3,a6.D4,a0.or_ir,a0.diameter,b0.time,c0.value');
        $params['table'] = 'p_turning';
        $this->db->from($params['table'].' as a0');
        $this->db->join('p_turning_time as b0', 'b0.id_turning=a0.id', 'left');
        $this->db->join('p_turning_dt as c0', 'c0.id_turning_time=a0.id', 'left');
        $this->db->join('k_process as a1', 'a1.id=a0.id_process', 'left');
        $this->db->join('k_asme as a2', 'a2.id=a0.id_asme', 'left');
        $this->db->join('k_dimension as a3', 'a3.id=a2.id_dimension', 'left');
        $this->db->join('a_class as a4', 'a4.id=a2.id_class', 'left');
        $this->db->join('a_flang_size as a5', 'a5.id=a2.id_flange', 'left');
        $this->db->join('k_control_chart as a6', 'a6.id=a0.id_control_chart', 'left');
        $this->db->where('a0.id',$id);
        $this->db->where('a0.deleted', 0);

        return $this->db->get()->result();
    }

    function getAll_turning_dimensi_time_query($id)
    {
        $this->db->select('a0.id as id, a1.process_name as proc_name,a0.date_process as date_process,a6.a2 as a2,a6.d3 as d3,a6.d4 as d4,a1.ctq as ctq,a3.dimension_name as dim_name,a2.d1lsl as d1lsl,a2.d1usl as d1usl,a2.d2lsl as d2lsl,a2.d2usl as d2usl,a2.d3lsl as d3lsl,a2.d3usl as d3usl,a2.d4lsl as d4lsl,a2.d4usl as d4usl,a4.code as code_class, a5.code as code_size,a6.sample, a6.A3,a6.D3,a6.D4,a0.or_ir,a0.diameter,b0.time,b0.id as id_time');
        $params['table'] = 'p_turning';
        $this->db->from($params['table'].' as a0');
        $this->db->join('p_turning_time as b0', 'b0.id_turning=a0.id', 'left');
        $this->db->join('k_process as a1', 'a1.id=a0.id_process', 'left');
        $this->db->join('k_asme as a2', 'a2.id=a0.id_asme', 'left');
        $this->db->join('k_dimension as a3', 'a3.id=a2.id_dimension', 'left');
        $this->db->join('a_class as a4', 'a4.id=a2.id_class', 'left');
        $this->db->join('a_flang_size as a5', 'a5.id=a2.id_flange', 'left');
        $this->db->join('k_control_chart as a6', 'a6.id=a0.id_control_chart', 'left');
        $this->db->where('a0.id',$id);
        $this->db->where('a0.deleted', 0);

        return $this->db->get()->result();
    }

    function getAll_turning_dimensi_Data_query($id)
    {
        $this->db->select('b0.id as id, b0.value as value');
        $params['table'] = 'p_turning_dt';
        $this->db->from($params['table'].' as b0');
        $this->db->where('b0.id_turning_time',$id);
        $this->db->where('b0.deleted', 0);

        return $this->db->get()->result();
    }   

    function getAll_turning_dimensi_Dt_query($id)
    {
        $this->db->select('a0.id as id, a0.date_process as date_process, a0.or_ir, a0.diameter, c0.value');
        $params['table'] = 'p_turning';
        $this->db->from($params['table'].' as a0');
        $this->db->join('p_turning_dt as c0', 'c0.id_turning_time=a0.id', 'left');
        $this->db->where('a0.id',$id);
        $this->db->where('a0.deleted', 0);

        return $this->db->get()->result();
    } 

    function get_turning_dimensi()
    {
        $this->get_turning_dimensi_query();
        if($_POST['length'] != -1)
        $this->db->limit($_POST['length'], $_POST['start']);
        // $files['data'] = $this->db->get()->result();
        return $this->db->get()->result();
    }

    function get_turning_dimensi_all()
    {
        $this->getAll_turning_dimensi_query();
        if($_POST['length'] != -1)
        $this->db->limit($_POST['length'], $_POST['start']);
        // $files['data'] = $this->db->get()->result();
        return $this->db->get()->result();
    }

    function count_turning_dimensi_filtered()
    {
        $this->get_turning_dimensi_query();
        return $this->db->get()->num_rows();
    }

    function count_turning_dimensi($tbl1=null)
    {
        $params['table'] = 'p_turning';

        $this->db->from($params['table']);
        $this->db->where('deleted', 0);
        $num_row = $this->db->count_all_results();

        return $num_row;
    }

    function count_turning_dimensi_all_filtered($id)
    {
        $this->db->select('a0.id as id, a1.process_name as proc_name,a0.date_process as date_process,a6.a2 as a2,a6.d3 as d3,a6.d4 as d4,a1.ctq as ctq,a3.dimension_name as dim_name,a2.d1lsl as d1lsl,a2.d1usl as d1usl,a2.d2lsl as d2lsl,a2.d2usl as d2usl,a2.d3lsl as d3lsl,a2.d3usl as d3usl,a2.d4lsl as d4lsl,a2.d4usl as d4usl,a4.code as code_class, a5.code as code_size,a6.sample, a6.A3,a6.D3,a6.D4,a0.or_ir,a0.diameter,b0.time,c0.value');
        $params['table'] = 'p_turning';
        $this->db->from($params['table'].' as a0');
        $this->db->join('p_turning_time as b0', 'b0.id_turning=a0.id', 'left');
        $this->db->join('p_turning_dt as c0', 'c0.id_turning_time=a0.id', 'left');
        $this->db->join('k_process as a1', 'a1.id=a0.id_process', 'left');
        $this->db->join('k_asme as a2', 'a2.id=a0.id_asme', 'left');
        $this->db->join('k_dimension as a3', 'a3.id=a2.id_dimension', 'left');
        $this->db->join('a_class as a4', 'a4.id=a2.id_class', 'left');
        $this->db->join('a_flang_size as a5', 'a5.id=a2.id_flange', 'left');
        $this->db->join('k_control_chart as a6', 'a6.id=a0.id_control_chart', 'left');
        $this->db->where('a0.id',$id);
        $this->db->where('a0.deleted', 0);
        return $this->db->get()->num_rows();
    }

    function count_turning_dimensi_all($tbl1=null)
    {
        $params['table'] = 'p_turning';

        $this->db->from($params['table'].' as a0');
        $this->db->join('p_turning_time as b0', 'a0.id=b0.id_turning', 'left');
        $this->db->join('p_turning_dt as c0', 'a0.id=c0.id_turning_time', 'left');
        $this->db->join('k_process as a1', 'a1.id=a0.id_process', 'left');
        $this->db->join('k_asme as a2', 'a2.id=a0.id_asme', 'left');
        $this->db->join('k_dimension as a3', 'a3.id=a2.id_dimension', 'left');
        $this->db->join('a_class as a4', 'a4.id=a2.id_class', 'left');
        $this->db->join('a_flang_size as a5', 'a5.id=a2.id_flange', 'left');
        $this->db->join('k_control_chart as a6', 'a6.id=a0.id_control_chart', 'left');
        $this->db->where('a0.deleted', 0);
        $num_row = $this->db->count_all_results();

        return $num_row;
    }

    /*Untuk End Turning Dimensi*/

    /*Untuk Mulai Winding Dimensi*/
    function get_winding_dimensi_query()
    {
        $this->db->select('a0.id as id, a1.process_name as proc_name,a0.date_process as date_process,a6.a2 as a2,a6.d3 as d3,a6.d4 as d4,a1.ctq as ctq,a3.dimension_name as dim_name,a2.d1lsl as d1lsl,a2.d1usl as d1usl,a2.d2lsl as d2lsl,a2.d2usl as d2usl,a2.d3lsl as d3lsl,a2.d3usl as d3usl,a2.d4lsl as d4lsl,a2.d4usl as d4usl,a4.code as code_class, a5.code as code_size,a6.sample, a6.A3,a6.D3,a6.D4,a0.or_ir,a0.diameter');
        $params['table'] = 'p_winding';
        $this->db->from($params['table'].' as a0');
        $this->db->join('k_process as a1', 'a1.id=a0.id_process', 'left');
        $this->db->join('k_asme as a2', 'a2.id=a0.id_asme', 'left');
        $this->db->join('k_dimension as a3', 'a3.id=a2.id_dimension', 'left');
        $this->db->join('a_class as a4', 'a4.id=a2.id_class', 'left');
        $this->db->join('a_flang_size as a5', 'a5.id=a2.id_flange', 'left');
        $this->db->join('k_control_chart as a6', 'a6.id=a0.id_control_chart', 'left');
        $this->db->where('a0.deleted', 0);

        $i = 0;
    
        foreach ($this->column_search_winding_dimensi as $item) // loop column 
        {
            if($_POST['search']['value']) // if datatable send POST for search
            {
                
                if($i===0) // first loop
                {
                    $this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
                    $this->db->like($item, $_POST['search']['value']);
                }
                else
                {
                    $this->db->or_like($item, $_POST['search']['value']);
                }

                if(count($this->column_search_winding_dimensi) - 1 == $i) //last loop
                    $this->db->group_end(); //close bracket
            }
            $i++;
        }

        if(isset($_POST['order'])) // here order processing
        {
            $this->db->order_by($this->column_order_winding_dimensi[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } 
        else if(isset($this->order))
        {
            $order = $this->order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }  

    function getAll_winding_dimensi_query($id)
    {
        $this->db->select('a0.id as id, a1.process_name as proc_name,a0.date_process as date_process,a6.a2 as a2,a6.d3 as d3,a6.d4 as d4,a1.ctq as ctq,a3.dimension_name as dim_name,a2.d1lsl as d1lsl,a2.d1usl as d1usl,a2.d2lsl as d2lsl,a2.d2usl as d2usl,a2.d3lsl as d3lsl,a2.d3usl as d3usl,a2.d4lsl as d4lsl,a2.d4usl as d4usl,a4.code as code_class, a5.code as code_size,a6.sample, a6.A3,a6.D3,a6.D4,a0.or_ir,a0.diameter,b0.time,c0.value');
        $params['table'] = 'p_winding';
        $this->db->from($params['table'].' as a0');
        $this->db->join('p_winding_time as b0', 'b0.id_winding=a0.id', 'left');
        $this->db->join('p_winding_dt as c0', 'c0.id_winding_time=a0.id', 'left');
        $this->db->join('k_process as a1', 'a1.id=a0.id_process', 'left');
        $this->db->join('k_asme as a2', 'a2.id=a0.id_asme', 'left');
        $this->db->join('k_dimension as a3', 'a3.id=a2.id_dimension', 'left');
        $this->db->join('a_class as a4', 'a4.id=a2.id_class', 'left');
        $this->db->join('a_flang_size as a5', 'a5.id=a2.id_flange', 'left');
        $this->db->join('k_control_chart as a6', 'a6.id=a0.id_control_chart', 'left');
        $this->db->where('a0.id',$id);
        $this->db->where('a0.deleted', 0);

        return $this->db->get()->result();
    }

    function getAll_winding_dimensi_time_query($id)
    {
        $this->db->select('a0.id as id, a1.process_name as proc_name,a0.date_process as date_process,a6.a2 as a2,a6.d3 as d3,a6.d4 as d4,a1.ctq as ctq,a3.dimension_name as dim_name,a2.d1lsl as d1lsl,a2.d1usl as d1usl,a2.d2lsl as d2lsl,a2.d2usl as d2usl,a2.d3lsl as d3lsl,a2.d3usl as d3usl,a2.d4lsl as d4lsl,a2.d4usl as d4usl,a4.code as code_class, a5.code as code_size,a6.sample, a6.A3,a6.D3,a6.D4,a0.or_ir,a0.diameter,b0.time,b0.id as id_time');
        $params['table'] = 'p_winding';
        $this->db->from($params['table'].' as a0');
        $this->db->join('p_winding_time as b0', 'b0.id_winding=a0.id', 'left');
        $this->db->join('k_process as a1', 'a1.id=a0.id_process', 'left');
        $this->db->join('k_asme as a2', 'a2.id=a0.id_asme', 'left');
        $this->db->join('k_dimension as a3', 'a3.id=a2.id_dimension', 'left');
        $this->db->join('a_class as a4', 'a4.id=a2.id_class', 'left');
        $this->db->join('a_flang_size as a5', 'a5.id=a2.id_flange', 'left');
        $this->db->join('k_control_chart as a6', 'a6.id=a0.id_control_chart', 'left');
        $this->db->where('a0.id',$id);
        $this->db->where('a0.deleted', 0);

        return $this->db->get()->result();
    }

    function getAll_winding_dimensi_Data_query($id)
    {
        $this->db->select('b0.id as id, b0.value as value');
        $params['table'] = 'p_winding_dt';
        $this->db->from($params['table'].' as b0');
        $this->db->where('b0.id_winding_time',$id);
        $this->db->where('b0.deleted', 0);

        return $this->db->get()->result();
    }   

    function getAll_winding_dimensi_Dt_query($id)
    {
        $this->db->select('a0.id as id, a0.date_process as date_process, a0.or_ir, a0.diameter, c0.value');
        $params['table'] = 'p_winding';
        $this->db->from($params['table'].' as a0');
        $this->db->join('p_winding_dt as c0', 'c0.id_winding_time=a0.id', 'left');
        $this->db->where('a0.id',$id);
        $this->db->where('a0.deleted', 0);

        return $this->db->get()->result();
    } 

    function get_winding_dimensi()
    {
        $this->get_winding_dimensi_query();
        if($_POST['length'] != -1)
        $this->db->limit($_POST['length'], $_POST['start']);
        // $files['data'] = $this->db->get()->result();
        return $this->db->get()->result();
    }

    function get_winding_dimensi_all()
    {
        $this->getAll_winding_dimensi_query();
        if($_POST['length'] != -1)
        $this->db->limit($_POST['length'], $_POST['start']);
        // $files['data'] = $this->db->get()->result();
        return $this->db->get()->result();
    }

    function count_winding_dimensi_filtered()
    {
        $this->get_winding_dimensi_query();
        return $this->db->get()->num_rows();
    }

    function count_winding_dimensi($tbl1=null)
    {
        $params['table'] = 'p_winding';

        $this->db->from($params['table']);
        $this->db->where('deleted', 0);
        $num_row = $this->db->count_all_results();

        return $num_row;
    }

    function count_winding_dimensi_all_filtered($id)
    {
        $this->db->select('a0.id as id, a1.process_name as proc_name,a0.date_process as date_process,a6.a2 as a2,a6.d3 as d3,a6.d4 as d4,a1.ctq as ctq,a3.dimension_name as dim_name,a2.d1lsl as d1lsl,a2.d1usl as d1usl,a2.d2lsl as d2lsl,a2.d2usl as d2usl,a2.d3lsl as d3lsl,a2.d3usl as d3usl,a2.d4lsl as d4lsl,a2.d4usl as d4usl,a4.code as code_class, a5.code as code_size,a6.sample, a6.A3,a6.D3,a6.D4,a0.or_ir,a0.diameter,b0.time,c0.value');
        $params['table'] = 'p_winding';
        $this->db->from($params['table'].' as a0');
        $this->db->join('p_winding_time as b0', 'b0.id_winding=a0.id', 'left');
        $this->db->join('p_winding_dt as c0', 'c0.id_winding_time=a0.id', 'left');
        $this->db->join('k_process as a1', 'a1.id=a0.id_process', 'left');
        $this->db->join('k_asme as a2', 'a2.id=a0.id_asme', 'left');
        $this->db->join('k_dimension as a3', 'a3.id=a2.id_dimension', 'left');
        $this->db->join('a_class as a4', 'a4.id=a2.id_class', 'left');
        $this->db->join('a_flang_size as a5', 'a5.id=a2.id_flange', 'left');
        $this->db->join('k_control_chart as a6', 'a6.id=a0.id_control_chart', 'left');
        $this->db->where('a0.id',$id);
        $this->db->where('a0.deleted', 0);
        return $this->db->get()->num_rows();
    }

    function count_winding_dimensi_all($tbl1=null)
    {
        $params['table'] = 'p_winding';

        $this->db->from($params['table'].' as a0');
        $this->db->join('p_winding_time as b0', 'a0.id=b0.id_winding', 'left');
        $this->db->join('p_winding_dt as c0', 'a0.id=c0.id_winding_time', 'left');
        $this->db->join('k_process as a1', 'a1.id=a0.id_process', 'left');
        $this->db->join('k_asme as a2', 'a2.id=a0.id_asme', 'left');
        $this->db->join('k_dimension as a3', 'a3.id=a2.id_dimension', 'left');
        $this->db->join('a_class as a4', 'a4.id=a2.id_class', 'left');
        $this->db->join('a_flang_size as a5', 'a5.id=a2.id_flange', 'left');
        $this->db->join('k_control_chart as a6', 'a6.id=a0.id_control_chart', 'left');
        $this->db->where('a0.deleted', 0);
        $num_row = $this->db->count_all_results();

        return $num_row;
    }
    /*Untuk End Winding Dimensi*/
    

    /*Untuk Mulai Welding*/
    function get_welding_query()
    {
        $this->db->select('a0.id as id, a1.process_name as proc_name,a0.date_process as date_process,a6.a2 as a2,a6.d3 as d3,a6.d4 as d4,a1.ctq as ctq,a3.dimension_name as dim_name,a2.d1lsl as d1lsl,a2.d1usl as d1usl,a2.d2lsl as d2lsl,a2.d2usl as d2usl,a2.d3lsl as d3lsl,a2.d3usl as d3usl,a2.d4lsl as d4lsl,a2.d4usl as d4usl,a4.code as code_class, a5.code as code_size,a6.sample, a6.A3,a6.D3,a6.D4,a0.or_ir,a0.diameter');
        $params['table'] = 'p_welding';
        $this->db->from($params['table'].' as a0');
        $this->db->join('k_process as a1', 'a1.id=a0.id_process', 'left');
        $this->db->join('k_asme as a2', 'a2.id=a0.id_asme', 'left');
        $this->db->join('k_dimension as a3', 'a3.id=a2.id_dimension', 'left');
        $this->db->join('a_class as a4', 'a4.id=a2.id_class', 'left');
        $this->db->join('a_flang_size as a5', 'a5.id=a2.id_flange', 'left');
        $this->db->join('k_control_chart as a6', 'a6.id=a0.id_control_chart', 'left');
        $this->db->where('a0.deleted', 0);

        $i = 0;
    
        foreach ($this->column_search_welding as $item) // loop column 
        {
            if($_POST['search']['value']) // if datatable send POST for search
            {
                
                if($i===0) // first loop
                {
                    $this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
                    $this->db->like($item, $_POST['search']['value']);
                }
                else
                {
                    $this->db->or_like($item, $_POST['search']['value']);
                }

                if(count($this->column_search_welding) - 1 == $i) //last loop
                    $this->db->group_end(); //close bracket
            }
            $i++;
        }

        if(isset($_POST['order'])) // here order processing
        {
            $this->db->order_by($this->column_order_welding[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } 
        else if(isset($this->order))
        {
            $order = $this->order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }  

    function getAll_welding_query($id)
    {
        $this->db->select('a0.id as id, a1.process_name as proc_name,a0.date_process as date_process,a6.a2 as a2,a6.d3 as d3,a6.d4 as d4,a1.ctq as ctq,a3.dimension_name as dim_name,a2.d1lsl as d1lsl,a2.d1usl as d1usl,a2.d2lsl as d2lsl,a2.d2usl as d2usl,a2.d3lsl as d3lsl,a2.d3usl as d3usl,a2.d4lsl as d4lsl,a2.d4usl as d4usl,a4.code as code_class, a5.code as code_size,a6.sample, a6.A3,a6.D3,a6.D4,a0.or_ir,a0.diameter,b0.time,c0.value');
        $params['table'] = 'p_welding';
        $this->db->from($params['table'].' as a0');
        $this->db->join('p_welding_time as b0', 'b0.id_welding=a0.id', 'left');
        $this->db->join('p_welding_dt as c0', 'c0.id_welding_time=a0.id', 'left');
        $this->db->join('k_process as a1', 'a1.id=a0.id_process', 'left');
        $this->db->join('k_asme as a2', 'a2.id=a0.id_asme', 'left');
        $this->db->join('k_dimension as a3', 'a3.id=a2.id_dimension', 'left');
        $this->db->join('a_class as a4', 'a4.id=a2.id_class', 'left');
        $this->db->join('a_flang_size as a5', 'a5.id=a2.id_flange', 'left');
        $this->db->join('k_control_chart as a6', 'a6.id=a0.id_control_chart', 'left');
        $this->db->where('a0.id',$id);
        $this->db->where('a0.deleted', 0);

        return $this->db->get()->result();
    }

    function getAll_welding_time_query($id)
    {
        $this->db->select('a0.id as id, a1.process_name as proc_name,a0.date_process as date_process,a6.a2 as a2,a6.d3 as d3,a6.d4 as d4,a1.ctq as ctq,a3.dimension_name as dim_name,a2.d1lsl as d1lsl,a2.d1usl as d1usl,a2.d2lsl as d2lsl,a2.d2usl as d2usl,a2.d3lsl as d3lsl,a2.d3usl as d3usl,a2.d4lsl as d4lsl,a2.d4usl as d4usl,a4.code as code_class, a5.code as code_size,a6.sample, a6.A3,a6.D3,a6.D4,a0.or_ir,a0.diameter,b0.time,b0.id as id_time');
        $params['table'] = 'p_welding';
        $this->db->from($params['table'].' as a0');
        $this->db->join('p_welding_time as b0', 'b0.id_welding=a0.id', 'left');
        $this->db->join('k_process as a1', 'a1.id=a0.id_process', 'left');
        $this->db->join('k_asme as a2', 'a2.id=a0.id_asme', 'left');
        $this->db->join('k_dimension as a3', 'a3.id=a2.id_dimension', 'left');
        $this->db->join('a_class as a4', 'a4.id=a2.id_class', 'left');
        $this->db->join('a_flang_size as a5', 'a5.id=a2.id_flange', 'left');
        $this->db->join('k_control_chart as a6', 'a6.id=a0.id_control_chart', 'left');
        $this->db->where('a0.id',$id);
        $this->db->where('a0.deleted', 0);

        return $this->db->get()->result();
    }

    function getAll_welding_Data_query($id)
    {
        $this->db->select('b0.id as id, b0.value as value');
        $params['table'] = 'p_welding_dt';
        $this->db->from($params['table'].' as b0');
        $this->db->where('b0.id_welding_time',$id);
        $this->db->where('b0.deleted', 0);

        return $this->db->get()->result();
    }   

    function getAll_welding_Dt_query($id)
    {
        $this->db->select('a0.id as id, a0.date_process as date_process, a0.or_ir, a0.diameter, c0.value');
        $params['table'] = 'p_welding';
        $this->db->from($params['table'].' as a0');
        $this->db->join('p_welding_dt as c0', 'c0.id_welding_time=a0.id', 'left');
        $this->db->where('a0.id',$id);
        $this->db->where('a0.deleted', 0);

        return $this->db->get()->result();
    } 

    function get_welding()
    {
        $this->get_welding_query();
        if($_POST['length'] != -1)
        $this->db->limit($_POST['length'], $_POST['start']);
        // $files['data'] = $this->db->get()->result();
        return $this->db->get()->result();
    }

    function get_welding_all()
    {
        $this->getAll_welding_query();
        if($_POST['length'] != -1)
        $this->db->limit($_POST['length'], $_POST['start']);
        // $files['data'] = $this->db->get()->result();
        return $this->db->get()->result();
    }

    function count_welding_filtered()
    {
        $this->get_welding_query();
        return $this->db->get()->num_rows();
    }

    function count_welding($tbl1=null)
    {
        $params['table'] = 'p_welding';

        $this->db->from($params['table']);
        $this->db->where('deleted', 0);
        $num_row = $this->db->count_all_results();

        return $num_row;
    }

    function count_welding_all_filtered($id)
    {
        $this->db->select('a0.id as id, a1.process_name as proc_name,a0.date_process as date_process,a6.a2 as a2,a6.d3 as d3,a6.d4 as d4,a1.ctq as ctq,a3.dimension_name as dim_name,a2.d1lsl as d1lsl,a2.d1usl as d1usl,a2.d2lsl as d2lsl,a2.d2usl as d2usl,a2.d3lsl as d3lsl,a2.d3usl as d3usl,a2.d4lsl as d4lsl,a2.d4usl as d4usl,a4.code as code_class, a5.code as code_size,a6.sample, a6.A3,a6.D3,a6.D4,a0.or_ir,a0.diameter,b0.time,c0.value');
        $params['table'] = 'p_welding';
        $this->db->from($params['table'].' as a0');
        $this->db->join('p_welding_time as b0', 'b0.id_welding=a0.id', 'left');
        $this->db->join('p_welding_dt as c0', 'c0.id_welding_time=a0.id', 'left');
        $this->db->join('k_process as a1', 'a1.id=a0.id_process', 'left');
        $this->db->join('k_asme as a2', 'a2.id=a0.id_asme', 'left');
        $this->db->join('k_dimension as a3', 'a3.id=a2.id_dimension', 'left');
        $this->db->join('a_class as a4', 'a4.id=a2.id_class', 'left');
        $this->db->join('a_flang_size as a5', 'a5.id=a2.id_flange', 'left');
        $this->db->join('k_control_chart as a6', 'a6.id=a0.id_control_chart', 'left');
        $this->db->where('a0.id',$id);
        $this->db->where('a0.deleted', 0);
        return $this->db->get()->num_rows();
    }

    function count_welding_all($tbl1=null)
    {
        $params['table'] = 'p_welding';

        $this->db->from($params['table'].' as a0');
        $this->db->join('p_welding_time as b0', 'a0.id=b0.id_welding', 'left');
        $this->db->join('p_welding_dt as c0', 'a0.id=c0.id_welding_time', 'left');
        $this->db->join('k_process as a1', 'a1.id=a0.id_process', 'left');
        $this->db->join('k_asme as a2', 'a2.id=a0.id_asme', 'left');
        $this->db->join('k_dimension as a3', 'a3.id=a2.id_dimension', 'left');
        $this->db->join('a_class as a4', 'a4.id=a2.id_class', 'left');
        $this->db->join('a_flang_size as a5', 'a5.id=a2.id_flange', 'left');
        $this->db->join('k_control_chart as a6', 'a6.id=a0.id_control_chart', 'left');
        $this->db->where('a0.deleted', 0);
        $num_row = $this->db->count_all_results();

        return $num_row;
    }
    /*Untuk End Welding*/
    
    /*Untuk Mulai winding_pressure*/
    function get_winding_pressure_query()
    {
        $this->db->select('a0.id as id, a1.process_name as proc_name,a0.date_process as date_process,a6.a2 as a2,a6.d3 as d3,a6.d4 as d4,a1.ctq as ctq,a3.dimension_name as dim_name,a2.d1lsl as d1lsl,a2.d1usl as d1usl,a2.d2lsl as d2lsl,a2.d2usl as d2usl,a2.d3lsl as d3lsl,a2.d3usl as d3usl,a2.d4lsl as d4lsl,a2.d4usl as d4usl,a4.code as code_class, a5.code as code_size,a6.sample, a6.A3,a6.D3,a6.D4,a0.or_ir,a0.diameter');
        $params['table'] = 'p_winding';
        $this->db->from($params['table'].' as a0');
        $this->db->join('k_process as a1', 'a1.id=a0.id_process', 'left');
        $this->db->join('k_asme as a2', 'a2.id=a0.id_asme', 'left');
        $this->db->join('k_dimension as a3', 'a3.id=a2.id_dimension', 'left');
        $this->db->join('a_class as a4', 'a4.id=a2.id_class', 'left');
        $this->db->join('a_flang_size as a5', 'a5.id=a2.id_flange', 'left');
        $this->db->join('k_control_chart as a6', 'a6.id=a0.id_control_chart', 'left');
        $this->db->where('a0.deleted', 0);

        $i = 0;
    
        foreach ($this->column_search_winding_pressure as $item) // loop column 
        {
            if($_POST['search']['value']) // if datatable send POST for search
            {
                
                if($i===0) // first loop
                {
                    $this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
                    $this->db->like($item, $_POST['search']['value']);
                }
                else
                {
                    $this->db->or_like($item, $_POST['search']['value']);
                }

                if(count($this->column_search_winding_pressure) - 1 == $i) //last loop
                    $this->db->group_end(); //close bracket
            }
            $i++;
        }

        if(isset($_POST['order'])) // here order processing
        {
            $this->db->order_by($this->column_order_winding_pressure[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } 
        else if(isset($this->order))
        {
            $order = $this->order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }  

    function getAll_winding_pressure_query($id)
    {
        $this->db->select('a0.id as id, a1.process_name as proc_name,a0.date_process as date_process,a6.a2 as a2,a6.d3 as d3,a6.d4 as d4,a1.ctq as ctq,a3.dimension_name as dim_name,a2.d1lsl as d1lsl,a2.d1usl as d1usl,a2.d2lsl as d2lsl,a2.d2usl as d2usl,a2.d3lsl as d3lsl,a2.d3usl as d3usl,a2.d4lsl as d4lsl,a2.d4usl as d4usl,a4.code as code_class, a5.code as code_size,a6.sample, a6.A3,a6.D3,a6.D4,a0.or_ir,a0.diameter,b0.time,c0.value');
        $params['table'] = 'p_winding';
        $this->db->from($params['table'].' as a0');
        $this->db->join('p_winding_time as b0', 'b0.id_winding=a0.id', 'left');
        $this->db->join('p_winding_dt as c0', 'c0.id_winding_time=a0.id', 'left');
        $this->db->join('k_process as a1', 'a1.id=a0.id_process', 'left');
        $this->db->join('k_asme as a2', 'a2.id=a0.id_asme', 'left');
        $this->db->join('k_dimension as a3', 'a3.id=a2.id_dimension', 'left');
        $this->db->join('a_class as a4', 'a4.id=a2.id_class', 'left');
        $this->db->join('a_flang_size as a5', 'a5.id=a2.id_flange', 'left');
        $this->db->join('k_control_chart as a6', 'a6.id=a0.id_control_chart', 'left');
        $this->db->where('a0.id',$id);
        $this->db->where('a0.deleted', 0);

        return $this->db->get()->result();
    }

    function getAll_winding_pressure_time_query($id)
    {
        $this->db->select('a0.id as id, a1.process_name as proc_name,a0.date_process as date_process,a6.a2 as a2,a6.d3 as d3,a6.d4 as d4,a1.ctq as ctq,a3.dimension_name as dim_name,a2.d1lsl as d1lsl,a2.d1usl as d1usl,a2.d2lsl as d2lsl,a2.d2usl as d2usl,a2.d3lsl as d3lsl,a2.d3usl as d3usl,a2.d4lsl as d4lsl,a2.d4usl as d4usl,a4.code as code_class, a5.code as code_size,a6.sample, a6.A3,a6.D3,a6.D4,a0.or_ir,a0.diameter,b0.time,b0.id as id_time');
        $params['table'] = 'p_winding';
        $this->db->from($params['table'].' as a0');
        $this->db->join('p_winding_time as b0', 'b0.id_winding=a0.id', 'left');
        $this->db->join('k_process as a1', 'a1.id=a0.id_process', 'left');
        $this->db->join('k_asme as a2', 'a2.id=a0.id_asme', 'left');
        $this->db->join('k_dimension as a3', 'a3.id=a2.id_dimension', 'left');
        $this->db->join('a_class as a4', 'a4.id=a2.id_class', 'left');
        $this->db->join('a_flang_size as a5', 'a5.id=a2.id_flange', 'left');
        $this->db->join('k_control_chart as a6', 'a6.id=a0.id_control_chart', 'left');
        $this->db->where('a0.id',$id);
        $this->db->where('a0.deleted', 0);

        return $this->db->get()->result();
    }

    function getAll_winding_pressure_Data_query($id)
    {
        $this->db->select('b0.id as id, b0.value as value');
        $params['table'] = 'p_winding_dt';
        $this->db->from($params['table'].' as b0');
        $this->db->where('b0.id_winding_time',$id);
        $this->db->where('b0.deleted', 0);

        return $this->db->get()->result();
    }   

    function getAll_winding_pressure_Dt_query($id)
    {
        $this->db->select('a0.id as id, a0.date_process as date_process, a0.or_ir, a0.diameter, c0.value');
        $params['table'] = 'p_winding';
        $this->db->from($params['table'].' as a0');
        $this->db->join('p_winding_dt as c0', 'c0.id_winding_time=a0.id', 'left');
        $this->db->where('a0.id',$id);
        $this->db->where('a0.deleted', 0);

        return $this->db->get()->result();
    } 

    function get_winding_pressure()
    {
        $this->get_winding_pressure_query();
        if($_POST['length'] != -1)
        $this->db->limit($_POST['length'], $_POST['start']);
        // $files['data'] = $this->db->get()->result();
        return $this->db->get()->result();
    }

    function get_winding_pressure_all()
    {
        $this->getAll_winding_pressure_query();
        if($_POST['length'] != -1)
        $this->db->limit($_POST['length'], $_POST['start']);
        // $files['data'] = $this->db->get()->result();
        return $this->db->get()->result();
    }

    function count_winding_pressure_filtered()
    {
        $this->get_winding_pressure_query();
        return $this->db->get()->num_rows();
    }

    function count_winding_pressure($tbl1=null)
    {
        $params['table'] = 'p_winding';

        $this->db->from($params['table']);
        $this->db->where('deleted', 0);
        $num_row = $this->db->count_all_results();

        return $num_row;
    }

    function count_winding_pressure_all_filtered($id)
    {
        $this->db->select('a0.id as id, a1.process_name as proc_name,a0.date_process as date_process,a6.a2 as a2,a6.d3 as d3,a6.d4 as d4,a1.ctq as ctq,a3.dimension_name as dim_name,a2.d1lsl as d1lsl,a2.d1usl as d1usl,a2.d2lsl as d2lsl,a2.d2usl as d2usl,a2.d3lsl as d3lsl,a2.d3usl as d3usl,a2.d4lsl as d4lsl,a2.d4usl as d4usl,a4.code as code_class, a5.code as code_size,a6.sample, a6.A3,a6.D3,a6.D4,a0.or_ir,a0.diameter,b0.time,c0.value');
        $params['table'] = 'p_winding';
        $this->db->from($params['table'].' as a0');
        $this->db->join('p_winding_time as b0', 'b0.id_winding=a0.id', 'left');
        $this->db->join('p_winding_dt as c0', 'c0.id_winding_time=a0.id', 'left');
        $this->db->join('k_process as a1', 'a1.id=a0.id_process', 'left');
        $this->db->join('k_asme as a2', 'a2.id=a0.id_asme', 'left');
        $this->db->join('k_dimension as a3', 'a3.id=a2.id_dimension', 'left');
        $this->db->join('a_class as a4', 'a4.id=a2.id_class', 'left');
        $this->db->join('a_flang_size as a5', 'a5.id=a2.id_flange', 'left');
        $this->db->join('k_control_chart as a6', 'a6.id=a0.id_control_chart', 'left');
        $this->db->where('a0.id',$id);
        $this->db->where('a0.deleted', 0);
        return $this->db->get()->num_rows();
    }

    function count_winding_pressure_all($tbl1=null)
    {
        $params['table'] = 'p_winding';

        $this->db->from($params['table'].' as a0');
        $this->db->join('p_winding_time as b0', 'a0.id=b0.id_winding', 'left');
        $this->db->join('p_winding_dt as c0', 'a0.id=c0.id_winding_time', 'left');
        $this->db->join('k_process as a1', 'a1.id=a0.id_process', 'left');
        $this->db->join('k_asme as a2', 'a2.id=a0.id_asme', 'left');
        $this->db->join('k_dimension as a3', 'a3.id=a2.id_dimension', 'left');
        $this->db->join('a_class as a4', 'a4.id=a2.id_class', 'left');
        $this->db->join('a_flang_size as a5', 'a5.id=a2.id_flange', 'left');
        $this->db->join('k_control_chart as a6', 'a6.id=a0.id_control_chart', 'left');
        $this->db->where('a0.deleted', 0);
        $num_row = $this->db->count_all_results();

        return $num_row;
    }
    /*Untuk End winding_pressure*/
}