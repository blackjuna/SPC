<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Master_model extends CI_Model{
    var $column_order = array('code','name',null); //set column field database for datatable orderable
    var $column_order_chart = array('code','name',null); //set column field database for datatable orderable
    var $column_order_filler = array('code','name',null); //set column field database for datatable orderable
    var $column_order_flang = array('code','name',null); //set column field database for datatable orderable
    var $column_search_aclass = array('code','name'); //set column field database for datatable searchable just firstname , lastname , address are searchable
    var $column_search_achart = array('code','name'); //set column field database for datatable searchable just firstname , lastname , address are searchable
    var $column_search_afiller = array('code','name'); //set column field database for datatable searchable just firstname , lastname , address are searchable
    var $column_search_aflang = array('code','name'); //set column field database for datatable searchable just firstname , lastname , address are searchable

    public function __construct(){
        parent::__construct();
    }
 
    function getAclass_query()
    {
        $params['table'] = 'A_CLASS';
        $this->db->from($params);
        $this->db->where('deleted', 0);

        $i = 0;
    
        foreach ($this->column_search_aclass as $item) // loop column 
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

                if(count($this->column_search_aclass) - 1 == $i) //last loop
                    $this->db->group_end(); //close bracket
            }
            $i++;
        }

        if(isset($_POST['order'])) // here order processing
        {
            $this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } 
        else if(isset($this->order))
        {
            $order = $this->order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }   

    function getAclass()
    {
        $this->getAclass_query();
        if($_POST['length'] != -1)
        $this->db->limit($_POST['length'], $_POST['start']);
        // $files['data'] = $this->db->get()->result();
        return $this->db->get()->result();
    }

    function countAclass_filtered()
    {
        $this->getAclass_query();
        return $this->db->get()->num_rows();
    }

    function countAclass($tbl1=null)
    {
        $params['table'] = 'A_CLASS';

        $this->db->from($params['table']);
        $this->db->where('deleted', 0);
        $num_row = $this->db->count_all_results();

        return $num_row;
    }
 
    function getAclass_by_id($id)
    {
        $params['table'] = 'A_CLASS';
        $this->db->from($params['table']);
        $this->db->where('id',$id);
        $query = $this->db->get();
 
        return $query->row();
    }
 
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
 
    function getAchart_query()
    {
        $params['table'] = 'A_CHART';
        $this->db->from($params);
        $this->db->where('deleted', 0);

        $i = 0;
    
        foreach ($this->column_search_achart as $item) // loop column 
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

                if(count($this->column_search_achart) - 1 == $i) //last loop
                    $this->db->group_end(); //close bracket
            }
            $i++;
        }

        if(isset($_POST['order'])) // here order processing
        {
            $this->db->order_by($this->column_order_chart[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } 
        else if(isset($this->order))
        {
            $order = $this->order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }   

    function getAchart()
    {
        $this->getAchart_query();
        if($_POST['length'] != -1)
        $this->db->limit($_POST['length'], $_POST['start']);
        return $this->db->get()->result();
    }

    function countAchart_filtered()
    {
        $this->getAchart_query();
        return $this->db->get()->num_rows();
    }

    function countAchart()
    {
        $params['table'] = 'A_chart';
        $this->db->from($params['table']);
        $this->db->where('deleted', 0);
        $num_row = $this->db->count_all_results();
        return $num_row;
    }
 
    function getAchart_by_id($id)
    {
        $params['table'] = 'A_chart';
        $this->db->from($params['table']);
        $this->db->where('id',$id);
        $query = $this->db->get();
        return $query->row();
    }
 
    function getAfiller_query()
    {
        $params['table'] = 'A_filler';
        $this->db->from($params);
        $this->db->where('deleted', 0);

        $i = 0;
    
        foreach ($this->column_search_afiller as $item) // loop column 
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

                if(count($this->column_search_afiller) - 1 == $i) //last loop
                    $this->db->group_end(); //close bracket
            }
            $i++;
        }

        if(isset($_POST['order'])) // here order processing
        {
            $this->db->order_by($this->column_order_filler[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } 
        else if(isset($this->order))
        {
            $order = $this->order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }   

    function getAfiller()
    {
        $this->getAfiller_query();
        if($_POST['length'] != -1)
        $this->db->limit($_POST['length'], $_POST['start']);
        return $this->db->get()->result();
    }

    function countAfiller_filtered()
    {
        $this->getAfiller_query();
        return $this->db->get()->num_rows();
    }

    function countAfiller()
    {
        $params['table'] = 'A_filler';
        $this->db->from($params['table']);
        $this->db->where('deleted', 0);
        $num_row = $this->db->count_all_results();
        return $num_row;
    }
 
    function getAfiller_by_id($id)
    {
        $params['table'] = 'A_filler';
        $this->db->from($params['table']);
        $this->db->where('id',$id);
        $query = $this->db->get();
        return $query->row();
    }

 
    function getAflang_query()
    {
        $params['table'] = 'a_flang_size';
        $this->db->from($params);
        $this->db->where('deleted', 0);

        $i = 0;
    
        foreach ($this->column_search_aflang as $item) // loop column 
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

                if(count($this->column_search_aflang) - 1 == $i) //last loop
                    $this->db->group_end(); //close bracket
            }
            $i++;
        }

        if(isset($_POST['order'])) // here order processing
        {
            $this->db->order_by($this->column_order_flang[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } 
        else if(isset($this->order))
        {
            $order = $this->order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }   

    function getAflang()
    {
        $this->getAflang_query();
        if($_POST['length'] != -1)
        $this->db->limit($_POST['length'], $_POST['start']);
        return $this->db->get()->result();
    }

    function countAflang_filtered()
    {
        $this->getAflang_query();
        return $this->db->get()->num_rows();
    }

    function countAflang()
    {
        $params['table'] = 'a_flang_size';
        $this->db->from($params['table']);
        $this->db->where('deleted', 0);
        $num_row = $this->db->count_all_results();
        return $num_row;
    }
 
    function getAflang_by_id($id)
    {
        $params['table'] = 'a_flang_size';
        $this->db->from($params['table']);
        $this->db->where('id',$id);
        $query = $this->db->get();
        return $query->row();
    }
   
}