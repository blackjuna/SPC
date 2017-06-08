<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Systems_Model extends CI_Model
{
	var $column_order_company = array('code','name','address',null); //set column field database for datatable orderable
    var $column_search_company = array('code','name','address'); //set column field database for datatable searchable just firstname , lastname , address are searchable
    var $column_order_department = array('code','name',null); //set column field database for datatable orderable
    var $column_search_department = array('code','name'); //set column field database for datatable searchable just firstname , lastname , address are searchable
    var $column_order_module_groups = array('code','name','sort_no','icon',null); //set column field database for datatable orderable
    var $column_search_module_groups = array('code','name','sort_no','icon'); //set column field database for datatable searchable just firstname , lastname , address are searchable
    var $column_order_groups = array('code','name','description',null); //set column field database for datatable orderable
    var $column_search_groups = array('code','name','description'); //set column field database for datatable searchable just firstname , lastname , address are searchable
    var $column_order_module = array('a1.code','a1.name','a2.name','a1.page_link','a1.sort_no','a1.show_in_menu'); //set column field database for datatable orderable
    var $column_search_module = array('a1.code','a1.name','a2.name'); //set column field database for datatable searchable just firstname , lastname , address are searchable
    var $column_order_group_auth = array('a2.name','a3.name','a1.c','a1.r','a1.u','a1.d','a1.a'); //set column field database for datatable orderable
    var $column_search_group_auth = array('a2.name','a3.name'); //set column field database for datatable searchable just firstname , lastname , address are searchable
    var $column_order_users = array('a0.username','a0.email','a0.first_name','a0.last_name','a0.phone'); //set column field database for datatable orderable
    var $column_search_users = array('a0.username','a0.email','a0.first_name','a0.last_name','a0.phone'); //set column field database for datatable searchable just firstname , lastname , address are searchable
		
	public function __construct()
	{
		parent::__construct();
		
		// FOR MEMCACHED
		// $this->load->driver('cache');
	}
	
	function init_first() 
	{
		$user_id = $this->session->userdata('user_id');
		
		$sess['company_id']    = $this->getDefault_Company();
		$sess['branch_id'] 	   = $this->getDefault_Branch();
		$sess['department_id'] = $this->getDefault_Department();
		$sess['groups_id'] 	   = $this->getUsers_ById($user_id)->u_groups;
		$sess['salesman_id']   = $this->getUsers_ById($user_id)->salesman_id;
		
		// $this->load->model('billm/billm_model');
		// $sess['period_id'] = $this->billm_model->getPeriodCurrentId();
			
		$this->session->set_userdata( $sess );
	}
	
	function getDefault_Company()
	{
		$this->db->select('company_id');
		$this->db->from('users_company');
		$this->db->where('user_id', $this->session->userdata('user_id'));
		$this->db->order_by('user_id, id');
		return $this->db->get()->row()->company_id;
	}
	
	function getDefault_Branch()
	{
		$this->db->select('branch_id');
		$this->db->from('users_branch');
		$this->db->where('user_id', $this->session->userdata('user_id'));
		$this->db->order_by('user_id, id');
		return $this->db->get()->row()->branch_id;
	}
	
	function getDefault_Department()
	{
		$this->db->select('department_id');
		$this->db->from('users_department');
		$this->db->where('user_id', $this->session->userdata('user_id'));
		$this->db->order_by('user_id, id');
		return $this->db->get()->row()->department_id;
	}
	
	function getCompany_ByUser($params)
	{
		$params['table'] = 'users_company';
		
		$this->db->select('COUNT(*) AS rec_count');
		$this->db->from($params['table'].' as a0');
		$this->db->join('users as u', 'a0.user_id = u.id', 'left');
		$this->db->join('company as c', 'a0.company_id = c.id', 'left');
		$num_row = $this->shared_model->get_rec_count($params);
		
		$this->db->select('a0.*, u.username, c.code as company_code, c.name as company_name');
		$this->db->from($params['table'].' as a0');
		$this->db->join('users as u', 'a0.user_id = u.id', 'left');
		$this->db->join('company as c', 'a0.company_id = c.id', 'left');
		$this->db->order_by('a0.user_id, c.code');
		$result = $this->shared_model->get_rec($params);
		
		$response = new stdClass();
		$response->total = $num_row;
		$response->rows  = $result;
		return $response;
	}
	
	function getBranch_ByUser($params)
	{
		$params['table'] = 'users_branch';
		
		$this->db->select('COUNT(*) AS rec_count');
		$this->db->from($params['table'].' as a0');
		$this->db->join('users as u', 'a0.user_id = u.id', 'left');
		$this->db->join('branch as b', 'a0.branch_id = b.id', 'left');
		$num_row = $this->shared_model->get_rec_count($params);
		
		$this->db->select('a0.*, u.username, b.code as branch_code, b.name as branch_name');
		$this->db->from($params['table'].' as a0');
		$this->db->join('users as u', 'a0.user_id = u.id', 'left');
		$this->db->join('branch as b', 'a0.branch_id = b.id', 'left');
		$this->db->order_by('a0.user_id, b.code');
		$result = $this->shared_model->get_rec($params);
		
		$response = new stdClass();
		$response->total = $num_row;
		$response->rows  = $result;
		return $response;
	}
	
	function getDepartment_ByUser($params)
	{
		
		$params['table'] = 'users_department';
		
		$this->db->select('COUNT(*) AS rec_count');
		$this->db->from($params['table'].' as a0');
		$this->db->join('users as u', 'a0.user_id = u.id', 'left');
		$this->db->join('department as d', 'a0.department_id = d.id', 'left');
		$num_row = $this->shared_model->get_rec_count($params);
		
		$this->db->select('a0.*, u.username, d.code as department_code, d.name as department_name');
		$this->db->from($params['table'].' as a0');
		$this->db->join('users as u', 'a0.user_id = u.id', 'left');
		$this->db->join('department as d', 'a0.department_id = d.id', 'left');
		$this->db->order_by('a0.user_id, d.code');
		$result = $this->shared_model->get_rec($params);
		
		$response = new stdClass();
		$response->total = $num_row;
		$response->rows  = $result;
		return $response;
	}
	
    function getTheme($params)
    {
        $qry = $this->db->get( 'theme' );
        return $qry->result();
    }

    function getTheme_ById($id)
    {
        $qry = $this->db->get_where( 'theme', array('id'=>$id) );
        return $qry->row();
    }

    function getTheme_ByUserId($user_id)
    {
        $qry = $this->db->get_where( 'users_settings', array('user_id'=>$user_id) );
        return $qry->row();
    }

    /**
     * 
     * 
     * @param <type> $params ['table', 'where', 'like', 'page', 'rows', 'sort', 'order', 'req_new' ] 
     * 
     * @return <type>
     */
	function getUsers($params) 
	{
		
		$params['table'] = 'users';
		
		$this->db->select('COUNT(DISTINCT u.id) AS rec_count');
		$this->db->from($params['table'].' as u');
		$this->db->join('users_settings as us', 'u.id = us.user_id', 'left');
		$this->db->join('users_company as uc', 'u.id = uc.user_id', 'left');
		$this->db->join('users_branch as ub', 'u.id = ub.user_id', 'left');
		if ( array_key_exists('where_not_in', $params) ) $this->db->where_not_in('u.id', $params['where_not_in']['u.id']);
		$this->db->where('u.deleted', 0);
		$num_row = $this->shared_model->get_rec_count($params);
		
		$this->db->select("u.id, u.ip_address, u.username, u.email, u.last_login, u.active, u.first_name, u.last_name, 
			u.phone, u.create_by, u.create_date, u.modify_by, u.modify_date, u.is_online, 
			themes_code, us.salesman_id, 
			phd_status_respond, phd_status_partial, phd_status_done, phd_status_revised, phd_status_cancel,
			phd_status_noquote, phd_status_reject, phd_status_notprocess, phd_status_pricelist, 
			STUFF((
				SELECT CAST(',' AS VARCHAR(MAX))+CAST(g.group_id AS VARCHAR(MAX)) 
				FROM users_groups AS g 
				WHERE g.user_id=u.id FOR xml path('')), 1, 1, '') AS u_groups,
			STUFF((
				SELECT CAST(',' AS VARCHAR(MAX))+CAST(gr.code AS VARCHAR(MAX)) 
				FROM users_groups AS g LEFT JOIN groups AS gr ON gr.id=g.group_id
				WHERE g.user_id=u.id FOR xml path('')), 1, 1, '') AS u_grp,
			STUFF((
				SELECT CAST(',' AS VARCHAR(MAX))+CAST(c.company_id AS VARCHAR(MAX)) 
				FROM users_company AS c 
				WHERE c.user_id=u.id FOR xml path('')), 1, 1, '') AS u_company,
			STUFF((
				SELECT CAST(',' AS VARCHAR(MAX))+CAST(comp.code AS VARCHAR(MAX)) 
				FROM users_company AS c LEFT JOIN company AS comp ON comp.id=c.company_id
				WHERE c.user_id=u.id FOR xml path('')), 1, 1, '') AS u_comp,
			STUFF((
				SELECT CAST(',' AS VARCHAR(MAX))+CAST(b.branch_id AS VARCHAR(MAX)) 
				FROM users_branch AS b 
				WHERE b.user_id=u.id FOR xml path('')), 1, 1, '') AS u_branch,
			STUFF((
				SELECT CAST(',' AS VARCHAR(MAX))+CAST(br.code AS VARCHAR(MAX)) 
				FROM users_branch AS b LEFT JOIN branch AS br ON br.id=b.branch_id
				WHERE b.user_id=u.id FOR xml path('')), 1, 1, '') AS u_br,
			STUFF((
				SELECT CAST(',' AS VARCHAR(MAX))+CAST(d.department_id AS VARCHAR(MAX)) 
				FROM users_department AS d 
				WHERE d.user_id=u.id FOR xml path('')), 1, 1, '') AS u_department,
			STUFF((
				SELECT CAST(',' AS VARCHAR(MAX))+CAST(dept.code AS VARCHAR(MAX)) 
				FROM users_department AS d LEFT JOIN department AS dept ON dept.id=d.department_id
				WHERE d.user_id=u.id FOR xml path('')), 1, 1, '') AS u_dept,
			STUFF((
				SELECT CAST(',' AS VARCHAR(MAX))+CAST(ic.item_cat_id AS VARCHAR(MAX)) 
				FROM users_items_cat AS ic 
				WHERE ic.user_id=u.id FOR xml path('')), 1, 1, '') AS u_items_cat,
			STUFF((
				SELECT CAST(',' AS VARCHAR(MAX))+CAST(icat.code AS VARCHAR(MAX)) 
				FROM users_items_cat AS ic LEFT JOIN items_cat AS icat ON icat.id=ic.item_cat_id
				WHERE ic.user_id=u.id FOR xml path('')), 1, 1, '') AS u_itemcat,
			STUFF((
				SELECT CAST(',' AS VARCHAR(MAX))+CAST(a00.customer_id AS VARCHAR(MAX)) 
				FROM users_customer AS a00 
				WHERE a00.user_id=u.id FOR xml path('')), 1, 1, '') AS customer_ids,
			STUFF((
				SELECT CAST(',' AS VARCHAR(MAX))+CAST(a01.name AS VARCHAR(MAX)) 
				FROM users_customer AS a00 LEFT JOIN customer AS a01 ON a00.customer_id=a01.id
				WHERE a00.user_id=u.id FOR xml path('')), 1, 1, '') AS customer_names
			");
		$this->db->from($params['table'].' as u');
		$this->db->join('users_settings as us', 'u.id = us.user_id', 'left');
		$this->db->join('users_company as uc', 'u.id = uc.user_id', 'left');
		$this->db->join('users_branch as ub', 'u.id = ub.user_id', 'left');
		if ( array_key_exists('where_not_in', $params) ) $this->db->where_not_in('u.id', $params['where_not_in']['u.id']);
		$this->db->where('u.deleted', 0);
		$this->db->group_by("u.id, u.ip_address, u.username, u.email, u.last_login, u.active, u.first_name, u.last_name, 
			u.phone, u.create_by, u.create_date, u.modify_by, u.modify_date, u.is_online,
			themes_code, us.salesman_id, 
			phd_status_respond, phd_status_partial, phd_status_done, phd_status_revised, phd_status_cancel,
			phd_status_noquote, phd_status_reject, phd_status_notprocess, phd_status_pricelist
			");
		$result = $this->shared_model->get_rec($params);
		
		$response = new stdClass();
		$response->total = $num_row;
		$response->rows  = $result;
		return $response;
	}
	
	function getUsers_ById($id)
	{
		$this->db->select("u.*,ug.group_id as u_groups,g.code as u_grp,uc.company_id as u_company,c.code as u_comp,ud.departments_id as u_department,d.code as u_dept");
		$this->db->from('c_users as u');
		$this->db->join('c_users_groups as ug', 'u.id=ug.user_id','left');
		$this->db->join('c_groups as g', 'ug.group_id=g.id','left');
		$this->db->join('c_users_company as uc', 'u.id=uc.user_id','left');
		$this->db->join('c_company as c', 'uc.company_id=c.id','left');
		$this->db->join('c_users_department as ud', 'u.id=ud.user_id','left');
		$this->db->join('c_department as d', 'ud.departments_id=d.id','left');
		$this->db->where('u.id', $id);
		$qry = $this->db->get();
		return ($qry->num_rows() > 0) ? $qry->row() : FALSE;
	}
	
	function addUsers_Settings($data=array())
	{
        $this->db->insert( 'users_settings', $data );
		return $this->db->insert_id();
	}
	
	function getGroups($params) 
	{
		
		$params['table'] = 'c_groups';
		
		$this->db->select('COUNT(*) AS rec_count');
		$this->db->from($params['table']);
		$this->db->where('deleted', 0);
		$num_row = $this->shared_model->get_rec_count($params);
		
		$this->db->select('*');
		$this->db->from($params['table']);
		$this->db->where('deleted', 0);
		$result = $this->shared_model->get_rec($params);
		
		$response = new stdClass();
		$response->total = $num_row;
		$response->rows  = $result;
		return $response;
	}
	
	function getGroups_Auth($params) 
	{
		
			
		$sql = "SELECT COUNT(*) AS rec_count 
			FROM (
				SELECT  
				g.id AS group_id, g.code AS group_code, g.name AS group_name, 
				mg.id AS module_group_id, mg.code AS module_group_code, mg.name AS module_group_name, mg.sort_no AS module_group_sort_no,  
				m.id AS module_id, m.code AS module_code, m.name AS module_name, m.sort_no as module_sort_no, m.page_link as module_page_link, 
				m.is_form as module_is_form, m.separator as module_separator
				FROM c_groups as g, c_modules as m 
				JOIN c_modules_groups as mg ON m.module_group_id = mg.id 
				WHERE mg.active = 1 and m.active = 1 
			) AS a1
			LEFT JOIN c_groups_auth as ga ON a1.group_id = ga.group_id and a1.module_id = ga.module_id 
			WHERE a1.group_id = ".$params['where']['g.id']."";
		$num_row =  $this->db->query($sql)->row()->rec_count;

		$sql = "SELECT a1.*, ga.id, ga.c, ga.r, ga.u, ga.d, ga.a 
			FROM (
				SELECT  
				g.id AS group_id, g.code AS group_code, g.name AS group_name, 
				mg.id AS module_group_id, mg.code AS module_group_code, mg.name AS module_group_name, mg.sort_no AS module_group_sort_no,  
				m.id AS module_id, m.code AS module_code, m.name AS module_name, m.sort_no as module_sort_no, m.page_link as module_page_link, 
				m.is_form as module_is_form, m.separator as module_separator
				FROM c_groups as g, c_modules as m 
				JOIN c_modules_groups as mg ON m.module_group_id = mg.id 
				WHERE mg.active = 1 and m.active = 1 
			) AS a1
			LEFT JOIN c_groups_auth as ga ON a1.group_id = ga.group_id and a1.module_id = ga.module_id 
			WHERE a1.group_id = ".$params['where']['g.id']." 
			ORDER BY module_group_sort_no, module_sort_no";
		$result =  $this->db->query($sql)->result();

		$response = new stdClass();
		$response->total = $num_row;
		$response->rows  = $result;
		return $response;
	}
	
	function getGroups_Auth_ByGroupId($ids) 
	{
		$sql = "SELECT a1.*, ga.id, ga.c, ga.r, ga.u, ga.d, ga.a 
			FROM (
				SELECT  
				g.id AS group_id, g.code AS group_code, g.name AS group_name, mg.icon as module_group_icon,
				mg.id AS module_group_id, mg.code AS module_group_code, mg.name AS module_group_name, mg.sort_no AS module_group_sort_no,  m.multilevel as multilevel,
				m.id AS module_id, m.code AS module_code, m.name AS module_name, m.sort_no as module_sort_no, 
				m.page_link as module_page_link
				FROM c_groups as g, c_modules as m 
				JOIN c_modules_group as mg ON m.modules_group_id = mg.id 
				WHERE mg.deleted = 0 and m.show_in_menu = 1 
			) AS a1
			LEFT JOIN c_groups_auth as ga ON a1.group_id = ga.groups_id and a1.module_id = ga.modules_id 
			WHERE ga.r = 1 AND a1.group_id IN ('".implode(',',$ids)."') 
			ORDER BY module_group_sort_no, module_sort_no";
		return $this->db->query($sql)->result();
	}

    function getBranch($params) 
	{
	
 		$params['table'] = 'branch';
		
		$this->db->select('COUNT(*) AS rec_count');
		$this->db->from($params['table']);
		$num_row = $this->shared_model->get_rec_count($params);
		
		$this->db->select('*');
		$this->db->from($params['table']);
		$result = $this->shared_model->get_rec($params);
		
		$response = new stdClass();
		$response->total = $num_row;
		$response->rows  = $result;
		return $response;
    }

    function getBranch_ById($id) 
	{
        $qry = $this->db->get_where( 'branch', array('id'=>$id) );
        return $qry->row();
    }

    function getModules_Groups($params) 
	{
 		$params['table'] = 'c_modules_groups';
		
		$this->db->select('COUNT(*) AS rec_count');
		$this->db->from($params['table']);
		$num_row = $this->shared_model->get_rec_count($params);
		
		$this->db->select('*, 
			(select min(sort_no) from modules_groups) as sort_no_min, 
			(select max(sort_no) from modules_groups) as sort_no_max
			');
		$this->db->from($params['table']);
		$result = $this->shared_model->get_rec($params);
		
		$response = new stdClass();
		$response->total = $num_row;
		$response->rows  = $result;
		return $response;
    }

    function getModules($params) 
	{
 		$params['table'] = 'c_modules';
		
		$this->db->select('COUNT(*) AS rec_count');
		$this->db->from($params['table']);
		$num_row = $this->shared_model->get_rec_count($params);
		
		$this->db->select('m.*, 
			(select min(sort_no) from modules where module_group_id = m.module_group_id) as sort_no_min, 
			(select max(sort_no) from modules where module_group_id = m.module_group_id) as sort_no_max
			');
		$this->db->from($params['table'].' as m');
		$result = $this->shared_model->get_rec($params);
		
		$response = new stdClass();
		$response->total = $num_row;
		$response->rows  = $result;
		return $response;
    }

    function getModules_ByCode($mg_code, $m_code) 
	{
	
 		$params['table'] = 'c_modules';
		
		$this->db->select('m.*, m.name as module_name, mg.code as module_group_code, mg.name as module_group_name,m.separat as module_separator, mg.icon as module_group_icon');
		$this->db->from($params['table'].' as m');
		$this->db->join('c_modules_group as mg', 'm.modules_group_id = mg.id', 'left');
		$this->db->where("mg.code = '$mg_code' and m.code = '$m_code'");
		return $this->db->get()->row();
    }

    function getSetup_Documents($params) 
	{
	
 		$params['table'] = 'setup_documents';
		
		$this->db->select('COUNT(*) AS rec_count');
		$this->db->from($params['table'].' as sd');
		$this->db->join('company as c', 'sd.company_id = c.id', 'left');
		$this->db->join('branch as b', 'sd.branch_id = b.id', 'left');
		$this->db->join('department as d', 'sd.department_id = d.id', 'left');
		$this->db->where('sd.deleted', 0);
		$num_row = $this->shared_model->get_rec_count($params);
		
		$this->db->select('sd.*, c.code as company_code, c.name as company_name, b.code as branch_code, b.name as branch_name, 
			d.code as department_code, d.name as department_name');
		$this->db->from($params['table'].' as sd');
		$this->db->join('company as c', 'sd.company_id = c.id', 'left');
		$this->db->join('branch as b', 'sd.branch_id = b.id', 'left');
		$this->db->join('department as d', 'sd.department_id = d.id', 'left');
		$this->db->where('sd.deleted', 0);
		$result = $this->shared_model->get_rec($params);
		
		$response = new stdClass();
		$response->total = $num_row;
		$response->rows  = $result;
		return $response;
    }

    function getSetup_Documents_ByCode($company_id=NULL, $branch_id=NULL, $department_id=NULL, $code) 
	{
		$this->db->select('sd.*');
		$this->db->from('setup_documents as sd');
		$this->db->where('company_id', empty($company_id) ? $this->session->userdata('company_id') : $company_id);
		$this->db->where('branch_id', empty($branch_id) ? $this->session->userdata('branch_id') : $branch_id);
		$this->db->where('department_id', empty($department_id) ? $this->session->userdata('department_id') : $department_id);
		$this->db->where('code', $code);
		return $this->db->get()->row();
    }

    function getcompany_query()
    {
        $params['table'] = 'c_company';
        $this->db->from($params);
        $this->db->where('deleted', 0);

        $i = 0;
    
        foreach ($this->column_search_company as $item) // loop column 
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

                if(count($this->column_search_company) - 1 == $i) //last loop
                    $this->db->group_end(); //close bracket
            }
            $i++;
        }

        if(isset($_POST['order'])) // here order processing
        {
            $this->db->order_by($this->column_order_company[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } 
        else if(isset($this->order))
        {
            $order = $this->order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }   

    function getCompany()
    {
        $this->getcompany_query();
        if($_POST['length'] != -1)
        $this->db->limit($_POST['length'], $_POST['start']);
        // $files['data'] = $this->db->get()->result();
        return $this->db->get()->result();
    }

    function countcompany_filtered()
    {
        $this->getcompany_query();
        return $this->db->get()->num_rows();
    }

    function countcompany($tbl1=null)
    {
        $params['table'] = 'c_company';

        $this->db->from($params['table']);
        $this->db->where('deleted', 0);
        $num_row = $this->db->count_all_results();

        return $num_row;
    }
 
    function getCompany_by_id($id)
    {
        $params['table'] = 'c_company';
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

    function getdepartment_query()
    {
        $params['table'] = 'c_department';
        $this->db->from($params);
        $this->db->where('deleted', 0);

        $i = 0;
    
        foreach ($this->column_search_department as $item) // loop column 
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

                if(count($this->column_search_department) - 1 == $i) //last loop
                    $this->db->group_end(); //close bracket
            }
            $i++;
        }

        if(isset($_POST['order'])) // here order processing
        {
            $this->db->order_by($this->column_order_department[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } 
        else if(isset($this->order))
        {
            $order = $this->order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }   

    function getdepartment()
    {
        $this->getdepartment_query();
        if($_POST['length'] != -1)
        $this->db->limit($_POST['length'], $_POST['start']);
        // $files['data'] = $this->db->get()->result();
        return $this->db->get()->result();
    }

    function countdepartment_filtered()
    {
        $this->getdepartment_query();
        return $this->db->get()->num_rows();
    }

    function countdepartment($tbl1=null)
    {
        $params['table'] = 'c_department';

        $this->db->from($params['table']);
        $this->db->where('deleted', 0);
        $num_row = $this->db->count_all_results();

        return $num_row;
    }
 
    function getdepartment_by_id($id)
    {
        $params['table'] = 'c_department';
        $this->db->from($params['table']);
        $this->db->where('id',$id);
        $query = $this->db->get();
 
        return $query->row();
    }

    function getmodule_group_query()
    {
        $params['table'] = 'c_modules_group';
        $this->db->from($params);
        $this->db->where('deleted', 0);

        $i = 0;
    
        foreach ($this->column_search_module_groups as $item) // loop column 
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

                if(count($this->column_search_module_groups) - 1 == $i) //last loop
                    $this->db->group_end(); //close bracket
            }
            $i++;
        }

        if(isset($_POST['order'])) // here order processing
        {
            $this->db->order_by($this->column_order_module_groups[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } 
        else if(isset($this->order))
        {
            $order = $this->order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }   

    function getmodule_group()
    {
        $this->getmodule_group_query();
        if($_POST['length'] != -1)
        $this->db->limit($_POST['length'], $_POST['start']);
        // $files['data'] = $this->db->get()->result();
        return $this->db->get()->result();
    }

    function countmodule_groups_filtered()
    {
        $this->getmodule_group_query();
        return $this->db->get()->num_rows();
    }

    function countmodule_groups($tbl1=null)
    {
        $params['table'] = 'c_modules_group';

        $this->db->from($params['table']);
        $this->db->where('deleted', 0);
        $num_row = $this->db->count_all_results();

        return $num_row;
    }
 
    function getmodule_groups_by_id($id)
    {
        $params['table'] = 'c_modules_group';
        $this->db->from($params['table']);
        $this->db->where('id',$id);
        $query = $this->db->get();
 
        return $query->row();
    }

    function get_groups_query()
    {
        $params['table'] = 'c_groups';
        $this->db->from($params);
        $this->db->where('deleted', 0);

        $i = 0;
    
        foreach ($this->column_search_groups as $item) // loop column 
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

                if(count($this->column_search_groups) - 1 == $i) //last loop
                    $this->db->group_end(); //close bracket
            }
            $i++;
        }

        if(isset($_POST['order'])) // here order processing
        {
            $this->db->order_by($this->column_order_groups[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } 
        else if(isset($this->order))
        {
            $order = $this->order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }   

    function get_groups()
    {
        $this->get_groups_query();
        if($_POST['length'] != -1)
        $this->db->limit($_POST['length'], $_POST['start']);
        // $files['data'] = $this->db->get()->result();
        return $this->db->get()->result();
    }

    function count_groups_filtered()
    {
        $this->get_groups_query();
        return $this->db->get()->num_rows();
    }

    function count_groups($tbl1=null)
    {
        $params['table'] = 'c_groups';

        $this->db->from($params['table']);
        $this->db->where('deleted', 0);
        $num_row = $this->db->count_all_results();

        return $num_row;
    }
 
    function get_groups_by_id($id)
    {
        $params['table'] = 'c_groups';
        $this->db->from($params['table']);
        $this->db->where('id',$id);
        $query = $this->db->get();
 
        return $query->row();
    }

    function get_module_query()
    {
        $params['table'] = 'c_modules';
        $this->db->select('a2.name as mdl_group_name,a1.code as mdl_code, a1.name as mdl_name, a1.page_link as page_link, a1.sort_no as sort_no, a1.show_in_menu as show_in_menu, a1.icon as icon, a1.multilevel as multilevel,a1.id');
		$this->db->from($params['table'].' as a1');
		$this->db->join('c_modules_group as a2', 'a1.modules_group_id = a2.id', 'left');
        $this->db->where('a1.deleted', 0);

        $i = 0;
    
        foreach ($this->column_search_module as $item) // loop column 
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

                if(count($this->column_search_module) - 1 == $i) //last loop
                    $this->db->group_end(); //close bracket
            }
            $i++;
        }

        if(isset($_POST['order'])) // here order processing
        {
            $this->db->order_by($this->column_order_module[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } 
        else if(isset($this->order))
        {
            $order = $this->order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }   

    function get_module()
    {
        $this->get_module_query();
        if($_POST['length'] != -1)
        $this->db->limit($_POST['length'], $_POST['start']);
        // $files['data'] = $this->db->get()->result();
        return $this->db->get()->result();
    }

    function count_module_filtered()
    {
        $this->get_module_query();
        return $this->db->get()->num_rows();
    }

    function count_module($tbl1=null)
    {
        $params['table'] = 'c_modules';

        $this->db->from($params['table']);
        $this->db->where('deleted', 0);
        $num_row = $this->db->count_all_results();

        return $num_row;
    }
 
    function get_module_by_id($id)
    {
        $params['table'] = 'c_modules';
        $this->db->from($params['table']);
        $this->db->where('id',$id);
        $query = $this->db->get();
 
        return $query->row();
    }
 

    function get_group_auth_query()
    {
        $params['table'] = 'c_groups_auth';
        $this->db->select('a2.name as mdl_name,a3.name as group_name,a1.c,a1.r,a1.u,a1.d,a1.id');
		$this->db->from($params['table'].' as a1');
		$this->db->join('c_modules as a2', 'a1.modules_id = a2.id', 'left');
		$this->db->join('c_groups as a3', 'a1.groups_id = a2.id', 'left');
        $this->db->where('a1.deleted', 0);

        $i = 0;
    
        foreach ($this->column_search_group_auth as $item) // loop column 
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

                if(count($this->column_search_group_auth) - 1 == $i) //last loop
                    $this->db->group_end(); //close bracket
            }
            $i++;
        }

        if(isset($_POST['order'])) // here order processing
        {
            $this->db->order_by($this->column_order_group_auth[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } 
        else if(isset($this->order))
        {
            $order = $this->order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }   

    function get_group_auth()
    {
        $this->get_group_auth_query();
        if($_POST['length'] != -1)
        $this->db->limit($_POST['length'], $_POST['start']);
        // $files['data'] = $this->db->get()->result();
        return $this->db->get()->result();
    }

    function count_group_auth_filtered()
    {
        $this->get_group_auth_query();
        return $this->db->get()->num_rows();
    }

    function count_group_auth($tbl1=null)
    {
        $params['table'] = 'c_groups_auth';

        $this->db->from($params['table']);
        $this->db->where('deleted', 0);
        $num_row = $this->db->count_all_results();

        return $num_row;
    }
 
    function get_group_auth_by_id($id)
    {
        $params['table'] = 'c_groups_auth';
        $this->db->from($params['table']);
        $this->db->where('id',$id);
        $query = $this->db->get();
 
        return $query->row();
    }
   

    function get_users_query()
    {
        $this->db->select('a0.*');
        $params['table'] = 'c_users';
		$this->db->from($params['table'].' as a0');
        $this->db->where('a0.active', 1);

        $i = 0;
    
        foreach ($this->column_search_users as $item) // loop column 
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

                if(count($this->column_search_users) - 1 == $i) //last loop
                    $this->db->group_end(); //close bracket
            }
            $i++;
        }

        if(isset($_POST['order'])) // here order processing
        {
            $this->db->order_by($this->column_order_users[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } 
        else if(isset($this->order))
        {
            $order = $this->order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }   

    function get_users()
    {
        $this->get_users_query();
        if($_POST['length'] != -1)
        $this->db->limit($_POST['length'], $_POST['start']);
        // $files['data'] = $this->db->get()->result();
        return $this->db->get()->result();
    }

    function count_users_filtered()
    {
        $this->get_users_query();
        return $this->db->get()->num_rows();
    }

    function count_users($tbl1=null)
    {
        $params['table'] = 'c_users';

        $this->db->from($params['table']);
        $this->db->where('active', 0);
        $num_row = $this->db->count_all_results();

        return $num_row;
    }
 
    function get_users_by_id($id)
    {
        $params['table'] = 'c_users';
        $this->db->from($params['table']);
        $this->db->where('id',$id);
        $query = $this->db->get();
 
        return $query->row();
    }
   



  
}