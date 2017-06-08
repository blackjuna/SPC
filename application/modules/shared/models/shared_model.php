<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Shared_Model extends CI_Model
{

	public function __construct()
	{
		parent::__construct();
		
		// FOR MEMCACHED
		$this->load->driver('cache');
	}
	// NEW DESIGN FOR DATA REQUEST
	function get_rec( $params=NULL ) {
		if ( is_array($params) )
		{
			if ( array_key_exists('where', $params) ) $this->db->where($params['where']);
			if ( array_key_exists('like_and', $params) ) 
			{
				$this->db->bracket('open','like');
				$this->db->like($params['like_and']);
				$this->db->bracket('close','like');
			}
			if ( array_key_exists('like', $params) ) 
			{
				$this->db->bracket('open','like');
				$this->db->or_like($params['like']);
				$this->db->bracket('close','like');
			}
			if ( array_key_exists('sort', $params) ) $this->db->order_by($params['sort'], $params['order']);
			if ( array_key_exists('page', $params) && array_key_exists('rows', $params) )
			{
				$params['page'] = empty($params['page']) ? 1 : $params['page'];
				$offset = ($params['page']-1)*$params['rows'];
				$this->db->limit($params['rows'], $offset);
			}
		}
		return $this->db->get()->result();
	}
	
	function get_rec_count( $params=NULL ) {
		if ( is_array($params) )
		{
			if ( array_key_exists('where', $params) ) $this->db->where($params['where']);
			if ( array_key_exists('like_and', $params) ) 
			{
				$this->db->bracket('open','like');
				$this->db->like($params['like_and']);
				$this->db->bracket('close','like');
			}
			if ( array_key_exists('like', $params) ) 
			{
				$this->db->bracket('open','like');
				$this->db->or_like($params['like']);
				$this->db->bracket('close','like');
			}
		}
		$result = $this->db->get();
		return ($result->num_rows() > 0) ? $result->row()->rec_count : 0;
	}
	
	function get_rec_rep( $params ) {
		if ( is_array($params) )
		{
			if ( array_key_exists('where', $params) ) $this->db->where($params['where']);
			if ( array_key_exists('like', $params) ) 
			{
				$this->db->bracket('open','like');
				$this->db->or_like($params['like']);
				$this->db->bracket('close','like');
			}
			if ( array_key_exists('sort', $params) ) $this->db->order_by($params['sort'], $params['order']);
			if ( array_key_exists('page', $params) && array_key_exists('rows', $params) )
			{
				$offset = ($params['page']-1)*$params['rows'];
				$this->db->limit($params['rows'], $offset);
			}
		}
		return $this->db->get();
	}
	
	function get_rec_tree( $params=NULL ) { 
		if ( is_array($params) )
		{
			if ( empty($params['id']) ) {
				// REC RESULT
				$this->db->select('*, name as text');
				$this->db->from($params['table']);
				$this->db->where('parent_id', 0);
				$this->db->where('deleted', 0);
				$this->db->order_by('sort_no', 'asc');
				$result = (array)$this->get_rec($params);

				$results = array();
				foreach ( $result as $r ) {
					$r->state = ($this->has_child_tree( $params['table'], $r->id )) ? 'closed' : 'open';
					array_push($results, $r);
				}
			} else {
				// REC RESULT
				$this->db->select('*, name as text');
				$this->db->from($params['table']);
				$this->db->where('parent_id', $params['id']);
				$this->db->where('deleted', 0);
				$this->db->order_by('sort_no', 'asc');
				$result = $this->get_rec($params);

				$results = array();
				foreach ( $result as $r ) {
					$r->state = ($this->has_child_tree( $params['table'], $r->id )) ? 'closed' : 'open';
					array_push($results, $r);
				}
			}
		}
		
		return $results;
	}
	
	function get_rec_tree_grid( $params=NULL ) { 
		if ( is_array($params) )
		{
			if ( empty($params['id']) ) {
				// REC COUNT
				$this->db->select('COUNT(*) AS rec_count');
				$this->db->from($params['table']);
				$this->db->where('parent_id', 0);
				$num_row = $this->get_rec_count($params);

				// REC RESULT
				$this->db->select('*');
				$this->db->from($params['table']);
				$this->db->where('parent_id', 0);
				$result = $this->get_rec($params);

				$results = array();
				foreach ( $result as $r ) {
					$r->state = ($this->has_child_tree( $params['table'], $r->id )) ? 'closed' : 'open';
					array_push($results, $r);
				}
				
				$response = new stdClass();
				$response->total = $num_row;
				$response->rows  = $results;
				
			} else {
			
				// REC RESULT
				$this->db->select('*');
				$this->db->from($params['table']);
				$this->db->where('parent_id', $params['id']);
				$result = $this->get_rec($params);

				$results = array();
				foreach ( $result as $r ) {
					$r->state = ($this->has_child_tree( $params['table'], $r->id )) ? 'closed' : 'open';
					array_push($results, $r);
				}
				$response = $results;
			}
		}
		
		return $response;
	}
	
	function has_child_tree( $table, $id ) {
		$this->db->select('COUNT(*) AS rec_count');
		$this->db->from($table);
		$this->db->where('parent_id', $id);
		$this->db->where('deleted', 0);
		return ($this->db->get()->row()->rec_count > 0) ? TRUE : FALSE;
	}
	
	function re_sorting_tree($params=NULL){
		$rows = $this->db->order_by('sort_no', 'asc')->get_where( $params['table'], $params['where'] )->result();
		$i = 1;
		foreach ($rows as $row){
			$this->db->update( $params['table'], array('sort_no'=>$i), array('id'=>$row->id) );
			$i++;
		}
	}
	
	// OLD DESIGN FOR DATA REQUEST
    /**
     * fungsi loading data untuk easyui "datagrid, combogrid"
     * with memcache enabled
     *
     *
     *
     */
	function get_easyui_data( $table=NULL, $columns=NULL, $where=NULL, $page=1, $rows=10, $sidx='', $sord='desc', $like=NULL, $req_new=FALSE ) { 
		$page   = !empty($page) ? intval($page) : 1;  
		$rows   = !empty($rows) ? intval($rows) : 100;  //if pagination=false. They not send page & rows. Jadi harus ditampilkan semua !
		$offset = ($page-1)*$rows;
		
		// $schema = $this->db->database;
		if ( is_null($table) ) return;
		if ( is_null($columns) ) 
			$columns = '*';
		else
			$columns = implode(",", $columns);
			
		// CLEARING CACHE
		// $this->cache->memcached->clean();
		
		/* $check_memcache = @memcache_connect('127.0.0.1',11211);
		if( $check_memcache !== FALSE ){
		
			// USING CACHE
			$filter[0] = $table;
			$filter[1] = $page;
			$filter[2] = $rows;
			$filter[3] = $sord;
			if ( !empty($where) ) $filter[4] = implode(';', $where);
			if ( !empty($like) ) $filter[5] = implode(';', $like);
			$str_filter = implode(';',$filter);
		
			if ( $req_new ) $this->cache->memcached->delete( $str_filter );
			$result = $this->cache->memcached->get( $str_filter );
			if ( !$result ) {
				$this->db->select($columns)->from($table)->order_by($sidx, $sord)->limit($rows, $offset);
				if ( !empty($where) ) $this->db->where($where);
				if ( !empty($like) ) 
				{ 
					$this->db->or_like($like);
					$this->db->bracket('close','like');
				}
				$result = $this->db->get()->result_array();

				$this->cache->memcached->save($str_filter, $result, 60);
			}
			
			$filter[6] = 'rec_count';
			$str_filter = implode(';',$filter);
			
			if ( $req_new ) $this->cache->memcached->delete( $str_filter );
			$num_row = $this->cache->memcached->get($str_filter);
			if ( !$num_row ) {
				$this->db->flush_cache();
				$this->db->select('COUNT(*) AS rec_count', FALSE)->from($table);
				if ( !empty($where) ) $this->db->where($where);
				if ( !empty($like) ) { 
					$this->db->or_like($like);
					$this->db->bracket('close','like');
				}
				$num_row = $this->db->get()->row()->rec_count;

				$this->cache->memcached->save($str_filter, $num_row, 60);
			}
		} else {
		    // memcached is _probably_ not running
			
			$this->db->select($columns)->from($table)->order_by($sidx, $sord)->limit($rows, $offset);
			if ( !empty($where) ) $this->db->where($where);
			if ( !empty($like) ) 
			{ 
				// $this->db->where($like, NULL);
				$this->db->or_like($like);
				$this->db->bracket('close','like');
			}
			$result = $this->db->get()->result_array();
			
			$this->db->flush_cache();
			
			$this->db->select('COUNT(*) AS rec_count', FALSE)->from($table);
			if ( !empty($where) ) $this->db->where($where);
			if ( !empty($like) ) { 
				// $this->db->where($like, NULL);
				$this->db->or_like($like);
				$this->db->bracket('close','like');
			}
			$num_row = $this->db->get()->row()->rec_count;
		} */
		
		$this->db->select($columns)->from($table)->order_by($sidx, $sord)->limit($rows, $offset);
		if ( !empty($where) ) $this->db->where($where);
		if ( !empty($like) ) 
		{ 
			// $this->db->where($like, NULL);
			$this->db->or_like($like);
			$this->db->bracket('close','like');
		}
		$result = $this->db->get()->result_array();
		
		$this->db->flush_cache();
		
		$this->db->select('COUNT(*) AS rec_count', FALSE)->from($table);
		if ( !empty($where) ) $this->db->where($where);
		if ( !empty($like) ) { 
			// $this->db->where($like, NULL);
			$this->db->or_like($like);
			$this->db->bracket('close','like');
		}
		$num_row = $this->db->get()->row()->rec_count;
			
		$response = new stdClass();
		$response->total = $num_row;
		$response->rows  = $result;
		return $response;
	}
	
	function get_dashboard_data( $table=NULL, $columns=NULL, $where=NULL, $page=1, $rows=10, $sidx='', $sord='desc', $like=NULL, $req_new=FALSE ) { 
		$page   = !empty($page) ? intval($page) : 1;  
		$rows   = !empty($rows) ? intval($rows) : 100;  //if pagination=false. They not send page & rows. Jadi harus ditampilkan semua !
		$offset = ($page-1)*$rows;
		
		// $schema = $this->db->database;
		if ( is_null($table) ) return;
		if ( is_null($columns) ) 
			$columns = '*';
		else
			$columns = implode(",", $columns);
			
		// CLEARING CACHE
		// $this->cache->memcached->clean();
		
		$check_memcache = @memcache_connect('127.0.0.1',11211);
		if( $check_memcache !== FALSE ){
		
			// USING CACHE
			$filter[0] = $table;
			$filter[1] = $page;
			$filter[2] = $rows;
			$filter[3] = $sord;
			if ( !empty($where) ) 
				$filter[4] = implode(';', $where);
			if ( !empty($like) ) 
				$filter[5] = implode(';', $like);
			$str_filter = implode(';',$filter);
		
			if ( $req_new ) $this->cache->memcached->delete( $str_filter );
			$result = $this->cache->memcached->get( $str_filter );
			if ( !$result ) {
				$this->db->select($columns)->from($table)->order_by($sidx, $sord)->limit($rows, $offset);
				if ( !empty($where) ) $this->db->where($where);
				if ( !empty($like) ) { 
					$this->db->or_like($like);
					$this->db->bracket('close','like');
				}
				$result = $this->db->get()->result_array();

				$this->cache->memcached->save($str_filter, $result, 60);
			}
			
			$filter[6] = 'rec_count';
			$str_filter = implode(';',$filter);
			
			if ( $req_new ) $this->cache->memcached->delete( $str_filter );
			$num_row = $this->cache->memcached->get($str_filter);
			if ( !$num_row ) {
				$this->db->flush_cache();
				$this->db->select('COUNT(*) AS rec_count', FALSE)->from($table);
				if ( !empty($where) ) $this->db->where($where);
				if ( !empty($like) ) { 
					$this->db->or_like($like);
					$this->db->bracket('close','like');
				}
				$num_row = $this->db->get()->row()->rec_count;

				$this->cache->memcached->save($str_filter, $num_row, 60);
			}
		} else {
		    // memcached is _probably_ not running
			
			$this->db->select($columns)->from($table)->order_by($sidx, $sord)->limit($rows, $offset);
			if ( !empty($where) ) $this->db->where($where);
			if ( !empty($like) ) { 
				$this->db->or_like($like);
				$this->db->bracket('close','like');
			}
			$result = $this->db->get()->result_array();
			
			$this->db->flush_cache();
			
			$this->db->select('COUNT(*) AS rec_count', FALSE)->from($table);
			if ( !empty($where) ) $this->db->where($where);
			if ( !empty($like) ) { 
				$this->db->or_like($like);
				$this->db->bracket('close','like');
			}
			$num_row = $this->db->get()->row()->rec_count;
		}
		
		// $response = new stdClass();
		// $response->total = $num_row;
		// $response->rows  = $result;
		// return $response;
		
		return $result;
	}
	
	function get_easyui_data_tree( $table=NULL, $columns=NULL, $where=NULL, $page=1, $rows=10, $sidx=0, $sord='asc', $like=NULL, $id=NULL, $req_new=FALSE ) { 
		$page   = !empty($page) ? intval($page) : 1;  
		$rows   = !empty($rows) ? intval($rows) : 100;  //if pagination=false. They not send page & rows. Jadi harus ditampilkan semua !
		$offset = ($page-1)*$rows;

		if ( is_null($table) ) return;
		if ( is_null($columns) ) 
			$columns = '*';
		else
			$columns = implode(",", $columns);
		
		// CLEARING CACHE
		// $this->cache->memcached->clean();
		
		// $id = !empty($id) ? intval($id) : 0;
		if (empty($id)) $id = 0;

		// USING CACHE
		$filter[0] = $table;
		$filter[1] = $page;
		$filter[2] = $rows;
		$filter[3] = $sord;
		$filter[4] = $id;
		if ( !empty($where) ) 
			$filter[5] = implode(';', $where);
		if ( !empty($like) ) 
			$filter[6] = implode(';', $like);
		$str_filter = implode(';',$filter);
		
		$check_memcache = @memcache_connect('127.0.0.1',11211);
		if( $check_memcache !== FALSE ){
		
		    // memcached is _probably_ not running
			
			if ( $req_new ) $this->cache->memcached->delete( $str_filter );
			$result = $this->cache->memcached->get( $str_filter );
			if ( !$result ) {
				
				if ( $id==0 ) {
					$this->db->select($columns)->from($table)->order_by($sidx, $sord)->limit($rows, $offset);
					if ( !empty($where) ) $this->db->where($where);
					if ( !empty($like) ) { 
						$this->db->or_like($like);
						$this->db->bracket('close','like');
					}
					$this->db->where('parent_id', 0);
					$result = $this->db->get()->result_array();

					$items = array();
					foreach ( $result as $r ) {
						// $r['state'] = ($this->has_child( $table, $r['id'] )) ? 'closed' : 'open';
						$r['state'] = ($this->has_child( $table, $r['id'] )) ? 'open' : 'closed';
						array_push($items, $r);
					}
					$result = $items;
					
					$filter[7] = 'rec_count';
					$str_filter = implode(';',$filter);
					if ( $req_new ) $this->cache->memcached->delete( $str_filter );
					$num_row = $this->cache->memcached->get($str_filter);
					if ( !$num_row ) {
						$this->db->flush_cache();
						$this->db->select('COUNT(*) AS rec_count', FALSE)->from($table);
						if ( !empty($where) ) $this->db->where($where);
						if ( !empty($like) ) { 
							$this->db->or_like($like);
							$this->db->bracket('close','like');
						}
						$this->db->where('parent_id', 0);
						$num_row = $this->db->get()->row()->rec_count;

						$this->cache->memcached->save($str_filter, $num_row, 60);
					}
			
					$response = new stdClass();
					$response->total = $num_row;
					$response->rows  = $result; 
				} else {
				
					$this->db->select($columns)->from($table)->order_by($sidx, $sord);
					if ( !empty($where) ) $this->db->where($where);
					if ( !empty($like) ) { 
						$this->db->or_like($like);
						$this->db->bracket('close','like');
					}
					$this->db->where('parent_id', $id);
					$result = $this->db->get()->result_array();

					$items = array();
					foreach ( $result as $r ) {
						$r['state'] = ($this->has_child( $table, $r['id'] )) ? 'closed' : 'open';
						array_push($items, $r);
					}
					$result = $items;
					$response = $result;
				}
				
				$this->cache->memcached->save($str_filter, $result, 60);
			}
		} else {
		
			if ( $id==0 ) {
				$this->db->select($columns)->from($table)->order_by($sidx, $sord)->limit($rows, $offset);
				if ( !empty($where) ) $this->db->where($where);
				if ( !empty($like) ) { 
					$this->db->or_like($like);
					$this->db->bracket('close','like');
				}
				$this->db->where('parent_id', 0);
				$result = $this->db->get()->result_array();

				$items = array();
				foreach ( $result as $r ) {
					$r['state'] = ($this->has_child( $table, $r['id'] )) ? 'closed' : 'open';
					array_push($items, $r);
				}
				$result = $items;
				
				$this->db->flush_cache();
				$this->db->select('COUNT(*) AS rec_count', FALSE)->from($table);
				if ( !empty($where) ) $this->db->where($where);
				if ( !empty($like) ) { 
					$this->db->or_like($like);
					$this->db->bracket('close','like');
				}
				$this->db->where('parent_id', 0);
				$num_row = $this->db->get()->row()->rec_count;

				$response = new stdClass();
				$response->total = $num_row;
				$response->rows  = $result; 
			} else {
			
				$this->db->select($columns)->from($table)->order_by($sidx, $sord);
				if ( !empty($where) ) $this->db->where($where);
				if ( !empty($like) ) { 
					$this->db->or_like($like);
					$this->db->bracket('close','like');
				}
				$this->db->where('parent_id', $id);
				$result = $this->db->get()->result_array();

				$items = array();
				foreach ( $result as $r ) {
					$r['state'] = ($this->has_child( $table, $r['id'] )) ? 'closed' : 'open';
					array_push($items, $r);
				}
				$result = $items;
				$response = $result;
			}
		}
		
		return $response;
	}
	
	function has_child( $table, $id ) {
		// $qry = $this->db->get_where( $table, array('parent_id'=>$id) );
		// return ($qry->num_rows() > 0) ? TRUE : FALSE;
		
		$this->db->select('COUNT(*) AS rec_count', FALSE)->from($table)->where('parent_id', $id);
		$num_row = $this->db->get()->row()->rec_count;
		return ($num_row > 0) ? TRUE : FALSE;
	}

	function get_jqgrid_data( $table=NULL, $columns=NULL, $where=NULL, $page=1, $limit=10, $sidx=1, $sord='desc' ) { 
		$schema = $this->db->database;
		if ( is_null($table) ) return;
		if ( is_null($columns) ) 
			$columns = '*';
		else
			$columns = implode(",", $columns);

		// $count = $this->db->get_where($table, $where)->num_rows();
		$this->db->select('COUNT(*) AS rec_count', FALSE)->from($table);
		if ( !empty($where) ) $this->db->where($where);
		if ( !empty($like) ) { 
			$this->db->or_like($like);
			$this->db->bracket('close','like');
		}
		$count = $this->db->get()->row()->rec_count;
		if( $count > 0 ) 
			$total_pages = ceil($count/$limit);
		else 
			$total_pages = 0;

		if ($page > $total_pages) 
			$page = $total_pages;

		$start = $limit*$page - $limit;
		if ($start<0) $start=0;
		// ** end calculate page
		
		// METODE KEDUA
		$sidx = (int)$sidx;
		$this->db->select($columns)->from($table)->order_by($columns[$sidx], $sord)->limit($limit, $start);
		if ( ! is_null($where) ) $this->db->where($where);
		$rows = $this->db->get()->result_array();
		 
		// ** end build query

		$response = new stdClass();
		$response->page 	= $page;
		$response->total 	= $total_pages;
		$response->records 	= $count;

		$i=0; 
		foreach ($rows as $row) {
			$columnData = array();
			foreach( $columns as $column ){
				array_push( $columnData, $row[$column] );
			}
			$response->rows[$i]['id']	= $row['id'];
			$response->rows[$i]['cell']	= $columnData;
			$i++;
		}
		
		return $response;
	}
	
	function get_dhtmlx_data( $table=NULL, $id=NULL, $columns=NULL, $where=NULL ) {
		$cols = $columns;
		array_unshift($cols, $id);
		
		$sel_col = implode(",", $cols);
		$this->db->select($sel_col)->from($table);
		
		if ( ! is_null($where) ) 
			$this->db->where($where);
		
		// $this->db->order_by($columns[$sidx], $sord);
		
		$rows = $this->db->get()->result_array();
		
		if ( ! $rows) return array();

		$i=0; 
		foreach ($rows as $row) {
			$columnData = array();
			foreach( $columns as $column ){
				array_push( $columnData, $row[$column] );
			}
			$response->rows[$i]['id']	= $row[$id];
			$response->rows[$i]['data']	= $columnData;
			$i++;
		}
		return $response;
	}

	function get_module_name( $mdl_grp=NULL, $mdl=NULL ){
	
		$check_memcache = @memcache_connect('127.0.0.1',11211);
		if( $check_memcache !== FALSE ){
		
			// USING CACHE
			$filter[0] = $mdl_grp;
			$filter[1] = $mdl;
			$str_filter = implode(';',$filter);
		
			$result = $this->cache->memcached->get( $str_filter );
			if ( !$result ) {
				$result = new stdClass();
				$result->mdl_grp_name = $this->db->get_where( 'modules_groups', array('code'=>$mdl_grp) )->row()->name;
				$result->mdl_name 	  = $this->db->get_where( 'modules', array('code'=>$mdl) )->row()->name;

				$this->cache->memcached->save($str_filter, $result, 3600);
			}
		} else {
		    // memcached is _probably_ not running
			
				$result = new stdClass();
				$result->mdl_grp_name = $this->db->get_where( 'modules_groups', array('code'=>$mdl_grp) )->row()->name;
				$result->mdl_name 	  = $this->db->get_where( 'modules', array('code'=>$mdl) )->row()->name;
		}
		return $result;
	}
	
	function update_relation_n_n( $table=NULL, $primary_field=NULL, $primary_value=NULL, $foreign_field=NULL, $foreign_values=NULL ) {

		$this->db->delete( $table, array($primary_field=>$primary_value));
		if ( !empty($foreign_values) ) {
			foreach ($foreign_values as $value) {	
				$this->db->insert( $table, array($primary_field=>$primary_value, $foreign_field=>$value));
			}
			return TRUE;
		}
		return FALSE;
	}
	
	function push_notification_email() {
		$qry = $this->db->get_where( 'notification_email', array('status'=>'created') );
		if ( $qry->num_rows() < 1)
			return FALSE;
	
		foreach ($qry->result() as $row) {
			$result = send_mail($row->email, $row->subject, $row->message);
			if ( $result ) 
				$this->db->update( 'notification_email', array('status'=>'sent', 'sent'=>date('Y-m-d H:i:s')), array('id'=>$row->id) );
			else
				$this->db->update( 'notification_email', array('status'=>'failed', 'sent'=>date('Y-m-d H:i:s')), array('id'=>$row->id) );
		}
		return TRUE;
	}
	
	function get_notif_note() {
		
		$notif = $this->db->get( 'notif' );
		if ( $notif->num_rows() < 1 )
			return FALSE;
			
		return $notif->row()->note;
	}
	
	function get_document_sign( $company_id, $branch_id, $department_id, $doc_code ) {
		$filter['company_id'] 	 = $company_id;
		$filter['branch_id'] 	 = $branch_id;
		$filter['department_id'] = $department_id;
		$filter['code'] 	 	 = $doc_code;
		
		$qry = $this->db->get_where( 'setup_documents', $filter );
		if ($qry->num_rows() < 1) {
			$data['sign1'] = NULL;
			$data['sign2'] = NULL;
			$data['sign3'] = NULL;
		} else {
			$row = $qry->row();
			$data['sign1'] = $row->sign1;
			$data['sign2'] = $row->sign2;
			$data['sign3'] = $row->sign3;
		}
		
		return $data;
	}
	
	function is_duplicate_code( $table=NULL, $code=NULL ) {
		return empty($this->db->get_where($table, array('code'=>$code, 'deleted'=>0), 1)->row()->id) ? FALSE : TRUE;
	}
	
	function is_duplicate_username( $table=NULL, $username=NULL ) {
		return empty($this->db->get_where($table, array('username'=>$username), 1)->row()->id) ? FALSE : TRUE;
	}
	
	function is_customer_exists( $company_id=NULL, $customer_id=NULL ) {
		$qry = $this->db->get_where( 'customer', array('id'=>intval($customer_id), 'company_id'=>$company_id) );
		return ($qry->num_rows() < 1) ? FALSE : TRUE;
		if ( $qry->num_rows() < 1 ) 
			return FALSE;
		else
			return TRUE;
	}
	
	function is_data_exists_on( $table=NULL, $fields=NULL, $search_value=NULL ) {
		$f = array();
		foreach ( $fields as $field ) {
			$f[$field] = $search_value;
		}
		return empty($this->db->get_where($table, $f, 1)->row()->id) ? FALSE : TRUE;
	}
	
	function updateTotalAmount($table, $id)
	{
		$filter['id'] = $id;
		$qry = $this->db->get_where( $table, $filter );
		foreach ($qry->result() as $row) 
		{
			$this->db->select_sum('amount', 'total_amount');
			$this->db->where($table.'_id', $row->id);
			// $this->db->where('void', 0);
			$summary = $this->db->get($table.'_dt')->row();

			$data1['total_amount'] = $summary->total_amount;
			$this->db->update( $table, $data1, $filter );
		}
		return;
	}
	
	// ================================ FUNCTION FOR PHD =============================================
	
	function send_checker( $company_id, $branch_id, $department_id, $item_cat_id, $send_to ) {
		if ( empty($send_to) ) 
			return FALSE;
			
		// FBI & MKT << LOLOS SELEKSI, KARENA DATA DARI MKT CABANG HARUS DI POOLING DI PUR PUSAT
		if ( $company_id==1 && $department_id==1 )
			return TRUE;
		
		// TGS & MKT << LOLOS SELEKSI, KARENA DATA DARI MKT CABANG HARUS DI POOLING DI MKT PUSAT
		if ( $company_id==2 && $department_id==1 )
			return TRUE;
		
		//item_cat_id==EJF & item_cat_id==EJM & item_cat_id==EJR 
		if ( ($item_cat_id==10) || ($item_cat_id==11) || ($item_cat_id==12) ) {
			//send_to!=EJF-TGS
			if ( $send_to!=3 ) 
				return FALSE;
		}
		//item_cat_id==OTHERS
		elseif ( $item_cat_id==16 ) {
			//send_to harus empty
			if ( !empty($send_to) ) 
				return FALSE;
		}
		//item_cat_id yang lain
		else {
			
			$qry = $this->db->get_where('opt_phd_routes', array('id'=>$send_to));
			if ( $qry->num_rows() < 1 )
				return FALSE;
				
			$row = $qry->row();
			$items_cat = explode(",", $row->items_cat);
			if ( !in_array($item_cat_id, $items_cat) ) 
				return FALSE;
			
			
			/* $sendto = explode(",", $send_to);
			if ( count($sendto)!=2 )
				return FALSE;

			//used for sorting from low to high, (untuk ke-seragaman)
			//because, low sendto for checking routes to department ACC
			//and high sendto for routes to ENG
			asort($sendto);
			$i=1;
			foreach ($sendto as $key => $val) {
				if ( $i==1 ) {
					//$val(opt_phd_routes): 1(ACC-TGS), 2(ACC-JFI)
					if ( !in_array($val, array(1, 2)) ) 
						return FALSE;
				}
				if ( $i==2 ) {
					//$val(opt_phd_routes)==1(ACC-TGS) || 
					//$val(opt_phd_routes)==2(ACC-JFI) ||
					//$val(opt_phd_routes)==3(EJF-TGS) ||
					//$val(opt_phd_routes)==6(PUR-FBI) ||
					$qry = $this->db->get_where('opt_phd_routes', array('id'=>$val));
					if ( $qry->num_rows() > 0 ) {
						$row = $qry->row();
						$items_cat = explode(",", $row->items_cat);
						if ( !in_array($item_cat_id, $items_cat) ) 
							return FALSE;
					}
				}
				$i++;
			} */		
		}
		
		return TRUE;
		
	}

	// from phd => phd_routes
	function send_phd_1( $company_id, $branch_id, $department_id, $status_id=NULL, $phd_id=NULL, $origin_id=NULL ) {	
		if ( empty($phd_id) )
			return FALSE;
		
		$data['company_id']    = $company_id;
		$data['branch_id'] 	   = $branch_id;
		$data['department_id'] = $department_id;
		$data['phd_id'] 	   = $phd_id;
		
		$qry = $this->db->get_where( 'phd_routes', $data );
		if ( $qry->num_rows() > 0 ) 
			return $qry->row()->id;
			
		$qry = $this->db->get_where( 'phd', array('id'=>$phd_id) );
		if ( $qry->num_rows() < 1 ) 
			return FALSE;
		
		$row = $qry->row();
		$data['origin_id'] = $origin_id;
		$data['note'] 	   = $row->note;
		$data['status_id'] = $status_id;
		$this->db->insert('phd_routes', $data);
		return $this->db->insert_id();
	}

	function send_phd_2( $company_id, $branch_id, $department_id, $status_id=NULL, $phd_id=NULL, $origin_id=NULL ) {	
		if ( empty($phd_id) )
			return FALSE;
		
		$data['company_id']    = $company_id;
		$data['branch_id'] 	   = $branch_id;
		$data['department_id'] = $department_id;
		$data['phd_id'] 	   = $phd_id;
		$data['origin_id'] 	   = $origin_id;
		
		$qry = $this->db->get_where( 'phd_routes', $data );
		if ( $qry->num_rows() > 0 ) 
			return $qry->row()->id;
		
		$qry = $this->db->get_where( 'phd_routes', array('id'=>$origin_id) );
		if ( $qry->num_rows() < 1 ) 
			return FALSE;
		
		$row = $qry->row();
		$data['note'] 	   = $row->note;
		$data['status_id'] = $status_id;
		$this->db->insert('phd_routes', $data);
		$destiny_id = $this->db->insert_id();
		
		//UPDATE ORIGIN PHD
		$this->db->update( 'phd_routes', array('destiny_id'=>$destiny_id), array('id'=>$origin_id) );
	
		return $destiny_id;
	}

	function send_phd_detail_1( $origin_id, $destiny_id ) {

		$qry = $this->db->get_where( 'phd_dt', array('phd_id'=>$origin_id, 'deleted'=>0) );
		if ( $qry->num_rows() < 1 ) 
			return FALSE;
		
		$data1['deleted'] = 1;
		$data1['create_by'] = 1;
		$data1['create_date'] = 1;
		$data1['note'] = $row->note.(empty($row->note) ? '' : chr(13)).'============= DELETED BY SYSTEM =============';
		$this->db->update( 'phd_routes_dt', array('deleted'=>1, 'create_by'=>1), array('phd_routes_id'=>$destiny_id) );
		
		foreach ($qry->result() as $row) 
		{
			$data['phd_routes_id'] = $destiny_id; 	
			$data['phd_dt_id'] 	   = $row->id; 	
			$data['item_id'] 	   = $row->item_id; 	
			$data['item_name'] 	   = $row->item_name; 	
			$data['item_size'] 	   = $row->item_size; 
			$data['measure_id']    = $row->measure_id; 
			$data['item_qty']      = $row->item_qty; 
			$data['note']      	   = $row->note; 
			$this->db->insert( 'phd_routes_dt', $data );
		}
		return TRUE;
	}

	function send_phd_detail_2( $origin_id, $destiny_id, $phd_routes_dt_id=0 ) {
		if (!empty($phd_routes_dt_id))
			$sql = "SELECT * FROM phd_routes_dt WHERE phd_routes_id=$origin_id AND id IN ($phd_routes_dt_id)";
		else
			$sql = "SELECT * FROM phd_routes_dt WHERE phd_routes_id=$origin_id";
		$qry = $this->db->query( $sql );
		if ( $qry->num_rows() < 1 ) 
			return FALSE;
		
		$this->db->delete( 'phd_routes_dt', array('phd_routes_id'=>$destiny_id) );
		
		foreach ($qry->result() as $row) 
		{
			$data['phd_routes_id'] 	  = $destiny_id; 	
			$data['phd_routes_dt_id'] = $row->id; 	
			$data['phd_dt_id'] 	   	  = $row->phd_dt_id; 	
			$data['item_id'] 	   = $row->item_id; 	
			$data['item_name'] 	   = $row->item_name; 	
			$data['item_size'] 	   = $row->item_size; 
			$data['measure_id']    = $row->measure_id; 
			$data['item_qty']      = $row->item_qty; 
			$data['note']      	   = $row->note; 
			$this->db->insert( 'phd_routes_dt', $data );
			
			$sql = "UPDATE phd_routes_dt SET sent_to_destiny=1 WHERE id=$row->id";
			$this->db->query( $sql );
		}
		return TRUE;
	}

	function revision_phd_routes( $id, $origin_id=NULL, $destiny_id=NULL, $status_id=15, $code='' ) {
		$user_id = $this->session->userdata('user_id');

		$qry = $this->db->get_where( 'phd_routes', array('id'=>$id) );
		if ( $qry->num_rows() < 1 )
			return FALSE;
			
		$row = $qry->row();
		
		$origin_id = empty($origin_id) ? $row->origin_id : $origin_id; 
		$destiny_id = empty($destiny_id) ? $row->destiny_id : $destiny_id;
		
		$data['date'] 			= date('Y-m-d H:i:s');
		$data['phd_id'] 	 	= $row->phd_id;
		$data['origin_id'] 		= $origin_id; 
		$data['destiny_id'] 	= $destiny_id;
		$data['company_id'] 	= $row->company_id;
		$data['branch_id'] 		= $row->branch_id;
		$data['department_id'] 	= $row->department_id;
		$data['code'] 			= empty($code) ? $row->code : $code;
		$data['code_reff'] 		= $row->code;
		$data['reference'] 		= $row->reference;
		$data['rev_no'] 		= $row->rev_no + 1;
		$data['status_id']  	= $status_id;
		$data['note']  			= $row->note;
		$data['forward_date']  	= $row->forward_date;
		$data['a_shipment_amount'] = $row->a_shipment_amount;
		$data['a_packing_amount']  = $row->a_packing_amount;
		$data['a_other_amount']    = $row->a_other_amount;
		$data['create_by'] 	 	= $user_id;
		$data['create_date'] 	= date('Y-m-d H:i:s');
		$this->db->insert( 'phd_routes', $data ); 
		$id_new = $this->db->insert_id();
		
		$qry2 = $this->db->get_where( 'phd_routes_dt', array('deleted'=>0,'phd_routes_id'=>$id) );
		if ( $qry2->num_rows() < 1 )
			return FALSE;
			
		// CREATE NEW DETAIL
		foreach ( $qry2->result() as $row2 ) 
		{
			
			$data2['phd_routes_id'] = $id_new;
			$data2['phd_routes_dt_id'] = $row2->phd_routes_dt_id;
			$data2['phd_dt_id'] = $row2->phd_dt_id;
			$data2['supplier_id'] = $row2->supplier_id;
			$data2['item_id'] = $row2->item_id;
			$data2['item_name'] = $row2->item_name;
			$data2['item_size'] = $row2->item_size;
			$data2['measure_id'] = $row2->measure_id;
			$data2['item_qty'] = $row2->item_qty;
			$data2['dt_value'] = $row2->dt_value;
			$data2['dt_period_id'] = $row2->dt_period_id;
			$data2['condition_id'] = $row2->condition_id;
			$data2['validity'] = $row2->validity;
			$data2['currency_id'] = $row2->currency_id;
			$data2['currency_rate'] = $row2->currency_rate;
			$data2['item_price'] = $row2->item_price;
			$data2['item_price_sell'] = $row2->item_price_sell;
			$data2['note'] = $row2->note;
			$data2['ready_to_send'] = $row2->ready_to_send;
			$data2['answered'] = $row2->answered;
			$data2['optional'] = $row2->optional;
			$this->db->insert( 'phd_routes_dt', $data2 ); 
			$id_new2 = $this->db->insert_id();
			
			$data3['phd_routes_dt_id'] = $id_new2;
			$this->db->update( 'phd_routes_dt', $data3, array('phd_routes_dt_id'=>$row2->id) );
		}
		
		// UPDATE OLD DATA
		$data4['status_id']  = 8; 					// 8=REH
		$data4['modify_by'] 	 = $user_id;
		$data4['modify_date'] = date('Y-m-d H:i:s');
		$this->db->update( 'phd_routes', $data4, array('id'=>$id) );
		
		
		if ( !empty($row->origin_id) ) {
		
			// RELINK WITH ORIGIN
			$data5['destiny_id'] = $id_new;
			$this->db->update( 'phd_routes', $data5, array('id'=>$origin_id) );
		}

		return $id_new;
	}
	
	function update_phd_routes_status( $id ) {
		$company_id	= $this->session->userdata('company_id');
		
		$qry = $this->db->get_where( 'phd_routes_dt', array('phd_routes_id'=>$id, 'ready_to_send'=>1, 'sent'=>0, 'deleted'=>0) );
		if ( $qry->num_rows() > 0 ) 
		{
			$data2['status_id'] = 2;	// 2=NAP
			$data2['need_approval_date'] = date('Y-m-d H:i:s');
		}
		else
		{
			$data2['status_id'] = 4;	// 4=PRO
			
			$qry = $this->db->get_where( 'phd_routes_dt', array('phd_routes_id'=>$id, 'sent'=>1) );
			if ( $qry->num_rows() > 0 ) 
			{
				$data2['status_id'] = 5;	// 5=PAN
			}
			else
			{
				$qry = $this->db->get_where( 'phd_routes_dt', array('phd_routes_id'=>$id, 'sent_to_destiny'=>1) );
				if ( $qry->num_rows() < 1 ) 
				{
					$data2['status_id'] = 4;	// 4=PRO
					$data2['need_approval_date'] = NULL;
				}
				else
				{
					$q = "SELECT \n".
						"(SELECT COUNT(*) FROM phd_routes_dt WHERE phd_routes_id = $id AND sent_to_destiny = 1) - \n".
						"(SELECT COUNT(*) FROM phd_routes_dt WHERE phd_routes_id = $id AND sent_to_destiny = 1 AND answered = 1) \n".
						"AS aa ";
					$qry = $this->db->query( $q )->row();
					if ( $qry->aa > 0 ) 
					{
						if ( $company_id==1 )
							$data2['status_id'] = 13;	// 13=PAP
						else
							$data2['status_id'] = 16;	// 16=PAC
					}
					else
					{
						if ( $company_id==1 )
							$data2['status_id'] = 14;	// 14=ABP
						else
							$data2['status_id'] = 17;	// 17=ABC
					}
				}
			}
		}
		$this->db->update('phd_routes', $data2, array('id'=>$id));
	}

	// ================================ CONVERSION ID TO CODE =============================================
	
	function get_company_code( $id=NULL ) {
		$qry = $this->db->get_where( 'company', array('id'=>$id) );
		if ($qry->num_rows() < 1) 
			return FALSE;
		
		$row = $qry->row();
		// $data['code'] = $row->code;
		// $data['name'] = $row->name;
		$data = new stdClass();
		$data->code = $row->code;
		$data->name = $row->name;
		
		return $data;
	}
	
	function get_branch_code( $id=NULL ) {
		$qry = $this->db->get_where( 'branch', array('id'=>$id) );
		if ($qry->num_rows() < 1) 
			return FALSE;
		
		$row = $qry->row();
		$data = new stdClass();
		$data->code = $row->code;
		$data->name = $row->name;
		
		return $data;
	}
	
	function get_branch_name( $id=NULL ) {
		$qry = $this->db->get_where( 'branch', array('id'=>$id) );
		if ($qry->num_rows() < 1) 
			return FALSE;
		
		$row = $qry->row();
		// $data = new stdClass();
		// $data->code = $row->code;
		// $data->name = $row->name;
		
		return $row->name;
	}
	
	function get_department_code( $id=NULL ) {
		$qry = $this->db->get_where( 'department', array('id'=>$id) );
		if ($qry->num_rows() < 1) 
			return FALSE;
		
		$row = $qry->row();
		$data = new stdClass();
		$data->code = $row->code;
		$data->name = $row->name;
		
		return $data;
	}
	
	// ================================ FUNCTION FOR CLINIC =============================================
	
	function recalc_transaction_per_id( $type, $id ){
		$this->db->trans_begin();
		
		if ( $type=='so' ) {
			$q_dt = $this->db->get_where( 'so_dt', array('so_id'=>$id, 'recalc'=>0) );
			if ( $q_dt->num_rows() > 0 ) {
				foreach ( $q_dt->result() as $r_dt ) {
				
					$q_item = $this->db->get_where( 'item', array('id'=>$r_dt->item_id) );
					if ( $q_item->num_rows() > 0 ) {
					
						$r_item = $q_item->row();
						// SALES => MENGURANGI STOCK
						$data['stock_val'] = $r_item->stock_val - $r_dt->item_qty;
						$this->db->update( 'item', $data, array('id'=>$r_item->id) );
					}
					
					$this->db->update( 'so_dt', array('recalc'=>1), array('id'=>$r_dt->id) );
				}
			}
		} elseif ( $type=='po' ) {
			$q_dt = $this->db->get_where( 'po_dt', array('po_id'=>$id, 'recalc'=>0) );
			if ( $q_dt->num_rows() > 0 ) {
				foreach ( $q_dt->result() as $r_dt ) {
				
					$q_item = $this->db->get_where( 'item', array('id'=>$r_dt->item_id) );
					if ( $q_item->num_rows() > 0 ) {
					
						$r_item = $q_item->row();
						// PURCHASE => MENAMBAH STOCK
						$data['stock_val'] = $r_item->stock_val + $r_dt->item_qty;
						$this->db->update( 'item', $data, array('id'=>$r_item->id) );
					}
					
					$this->db->update( 'po_dt', array('recalc'=>1), array('id'=>$r_dt->id) );
				}
			}
		}
			
		$this->db->trans_commit();
		return TRUE;
	}
	
	function recalc_transaction_per_date( $type, $date ){
		$this->db->trans_begin();
		
		if ( $type=='so' ) {
			$q_hd = $this->db->get_where( 'so', array('date'=>$date, 'status_id'=>0) );
			if ( $q_hd->num_rows() > 0 ) {
				foreach ( $q_hd->result() as $r_hd ) {

					$q_dt = $this->db->get_where( 'so_dt', array('so_id'=>$r_hd->id, 'recalc'=>0) );
					if ( $q_dt->num_rows() > 0 ) {
						foreach ( $q_dt->result() as $r_dt ) {
						
							$q_item = $this->db->get_where( 'item', array('id'=>$r_dt->item_id) );
							if ( $q_item->num_rows() > 0 ) {
							
								$r_item = $q_item->row();
								// SALES => MENGURANGI STOCK
								$data['stock_val'] = $r_item->stock_val - $r_dt->item_qty;
								$this->db->update( 'item', $data, array('id'=>$r_item->id) );
							}
							
							$this->db->update( 'so_dt', array('recalc'=>1), array('id'=>$r_dt->id) );
						}
					}
				}
			}
		} elseif ( $type=='po' ) {
			$q_hd = $this->db->get_where( 'po', array('date'=>$date, 'status_id'=>0) );
			if ( $q_hd->num_rows() > 0 ) {
				foreach ( $q_hd->result() as $r_hd ) {

					$q_dt = $this->db->get_where( 'po_dt', array('po_id'=>$r_hd->id, 'recalc'=>0) );
					if ( $q_dt->num_rows() > 0 ) {
						foreach ( $q_dt->result() as $r_dt ) {
						
							$q_item = $this->db->get_where( 'item', array('id'=>$r_dt->item_id) );
							if ( $q_item->num_rows() > 0 ) {
							
								$r_item = $q_item->row();
								// PURCHASE => MENAMBAH STOCK
								$data['stock_val'] = $r_item->stock_val + $r_dt->item_qty;
								$this->db->update( 'item', $data, array('id'=>$r_item->id) );
							}
							
							$this->db->update( 'po_dt', array('recalc'=>1), array('id'=>$r_dt->id) );
						}
					}
				}
			}
		}
			
		$this->db->trans_commit();
		return TRUE;
	}
	
	// ================================ FUNCTION FOR ENGINEERING =============================================
	
	function format_this_date( $date=NULL ) {
		if ( empty($date) )
			return NULL;
		
		// yyyy-mm-dd
		$tmp = explode('/', $date);
		return $tmp[2].'-'.$tmp[1].'-'.$tmp[0];
	}
	
	function get_branch_ho_id() {
		return $this->db->get_where('branch', array('code'=>'HOF'), 1)->row()->id;
	}
	
	function get_department_pur_id() {
		return $this->db->get_where('department', array('code'=>'PUR'), 1)->row()->id;
	}
	
	function get_phd_status_id( $code=NULL ) {
		if ( empty($code) ) return FALSE;
		return $this->db->get_where('opt_phd_status', array('code'=>$code), 1)->row()->id;
	}
	
	function get_swg_details( $code=NULL ) {
		if (empty($code)) 
			return FALSE;
		
		if ( strlen($code) != 10 )
			return FALSE;
			
		$a1 = substr($code, 4, 1); 	//IR
		$a2 = substr($code, 5, 1); 	//OR
		$a3 = substr($code, 6, 2); 	//HOOP
		$a4 = substr($code, 8, 1);	//FILLER

		if ( ($a1 != "0") && ($a2 != "0") && ($a3 != "00") && ($a4 != "0") ) {
			// COMPLETE	1-2-3-4
			// 0123456789
			// AA01BB0110	FINISH GOOD
			// AA01BB011H	ASSY
			// AA010B000F	MARKING
			// AA01B0011G	WINDING
			$res[1] = $code;
			$res[2] = substr_replace($code, "H", 9, 1);
			$res[3] = substr_replace(substr_replace(substr_replace($code, "F", 9, 1), "0", 4, 1), "000", 6, 3);
			$res[4] = substr_replace(substr_replace($code, "G", 9, 1), "0", 5, 1);
		} else 
		if ( ($a1 != "0") && ($a3 != "00") && ($a4 != "0") ) {
			// IR+BASIC	1-3-4
			// AA01B00110	F
			// AA01B0011G	W
			$res[1] = $code;
			$res[2] = substr_replace($code, "G", 9, 1);
		} else
		if ( ($a2 != "0") && ($a3 != "00") && ($a4 != "0") ) {
			// OR+BASIC	2-3-4
			// AA010B0110	F
			// AA010B011H	A
			// AA010B000F	M
			// AA0100011G	W
			$res[1] = $code;
			$res[2] = substr_replace($code, "H", 9, 1);
			$res[3] = substr_replace(substr_replace($code, "F", 9, 1), "000", 6, 3);
			$res[4] = substr_replace(substr_replace($code, "G", 9, 1), "0", 5, 1);
		} else
		if ( ($a3 != "00") && ($a4 != "0") ) {
			// BASIC	3-4
			// AA01000110	F
			// AA0100011G	W
			$res[1] = $code;
			$res[2] = substr_replace($code, "G", 9, 1);
		} else
		if ( ($a1 != "0") ) {
			// IR	1
			// AA01B00000	F
			// AA01B0000H	A
			// AA01B0000F	M
			$res[1] = $code;
			$res[2] = substr_replace($code, "H", 9, 1);
			$res[3] = substr_replace($code, "F", 9, 1);
		} else
		if ( ($a2 != "0") ) {
			// OR	2
			// AA010B0000	F
			// AA010B000H	A
			// AA010B000F	M
			$res[1] = $code;
			$res[2] = substr_replace($code, "H", 9, 1);
			$res[3] = substr_replace($code, "F", 9, 1);
		} 
		
		return $res;
	}
	
	/* function get_swg_parts( $code=NULL, $id=NULL, $children=NULL ) {
		if (empty($code)) 
			return FALSE;
		
		if ( strlen($code) != 10 )
			return FALSE;
		
		// COMPLETE	1-2-3-4
		// 0123456789
		// AA01BB0110	F
		for ( $i=1; $i<=strlen($code); $i++ ) {
			if ( $i==3 || $i==4 ) {
				
				$res[3] = substr($code, 2, 2);
			} 
			elseif ($i==7 || $i==8 ) {
				
				$res[7] = substr($code, 6, 2);
			} 
			else {
			
				$res[$i] = substr($code, $i-1, 1);
			}
		}
		
		if ( !empty($id) ) 
			$qry['id'] = $id;
			
		$qry['code'] = $code;
			
		$db_swg = $this->load->database('sqlsvr12_swg', TRUE);
		foreach ( $res as $key => $val ) {
			if ( $key==1 ) {
				$qry['standard'] = $db_swg->get_where( '[01_standard]', array( 'code'=>$val ) )->row()->name;
			}
			if ( $key==2 ) {
				$qry['class'] = $db_swg->get_where( '[02_class]', array( 'code'=>$val, 'standard_code'=>$res[1] ) )->row()->value;
			}
			if ( $key==3 ) {
				$qry['size'] = $db_swg->get_where( '[03_size]', array( 'code'=>$val, 'standard_code'=>$res[1] ) )->row()->value_string;
			}
			if ( $key==5 ) {
				$qry['ir'] = $db_swg->get_where( '[05_ir]', array( 'code'=>$val ) )->row()->name;
			}
			if ( $key==6 ) {
				$qry['or'] = $db_swg->get_where( '[06_or]', array( 'code'=>$val ) )->row()->name;
			}
			if ( $key==7 ) {
				$qry['hoop'] = $db_swg->get_where( '[07_hoop]', array( 'code'=>$val ) )->row()->name;
			}
			if ( $key==9 ) {
				$qry['filler'] = $db_swg->get_where( '[09_filler]', array( 'code'=>$val ) )->row()->name;
			}
			if ( $key==10 ) {
				$qry['progress'] = $db_swg->get_where( '[10_progress]', array( 'code'=>$val ) )->row()->name;
			}
		}
		
		if ( !empty($children) ) 
			$qry['children'] = $this->get_swg_parts( $children );
			
		return $qry;
	} */
	
	function get_swg_parts( $code=NULL ) {
		if (empty($code)) 
			return FALSE;
		
		if ( strlen($code) != 10 )
			return FALSE;
		
		// COMPLETE	1-2-3-4
		// 0123456789
		// AA01BB0110	F
		for ( $i=1; $i<=strlen($code); $i++ ) {
			if ( $i==3 || $i==4 ) {
				
				$res[3] = substr($code, 2, 2);
			} 
			elseif ($i==7 || $i==8 ) {
				
				$res[7] = substr($code, 6, 2);
			} 
			else {
			
				$res[$i] = substr($code, $i-1, 1);
			}
		}
		
		foreach ( $res as $key => $val ) {
			if ( $key==1 ) {
				// $qry['standard_code'] = $this->db->get_where( '[01_standard]', array( 'code'=>$val ) )->row()->name;
				$qry['standard_code'] = $val;
			}
			if ( $key==2 ) {
				// $qry['class_code'] = $this->db->get_where( '[02_class]', array( 'code'=>$val, 'standard_code'=>$res[1] ) )->row()->value;
				$qry['class_code'] = $val;
			}
			if ( $key==3 ) {
				// $qry['size_code'] = $this->db->get_where( '[03_size]', array( 'code'=>$val, 'standard_code'=>$res[1] ) )->row()->value_string;
				$qry['size_code'] = $val;
			}
			if ( $key==5 ) {
				// $qry['ir_code'] = $this->db->get_where( '[05_ir]', array( 'code'=>$val ) )->row()->name;
				$qry['ir_code'] = $val;
			}
			if ( $key==6 ) {
				// $qry['or_code'] = $this->db->get_where( '[06_or]', array( 'code'=>$val ) )->row()->name;
				$qry['or_code'] = $val;
			}
			if ( $key==7 ) {
				// $qry['hoop_code'] = $this->db->get_where( '[07_hoop]', array( 'code'=>$val ) )->row()->name;
				$qry['hoop_code'] = $val;
			}
			if ( $key==9 ) {
				// $qry['filler_code'] = $this->db->get_where( '[09_filler]', array( 'code'=>$val ) )->row()->name;
				$qry['filler_code'] = $val;
			}
			if ( $key==10 ) {
				// $qry['progress_code'] = $this->db->get_where( '[10_progress]', array( 'code'=>$val ) )->row()->name;
				$qry['progress_code'] = $val;
			}
		}
		
		// SET TYPE 
		// =================
		// COMPLETE 1-2-3-4
		// IR+BASIC	1-3-4
		// OR+BASIC	2-3-4
		// BASIC	3-4
		// IR	1
		// OR	2
		// =================
		$a1 = substr($code, 4, 1); 	//IR
		$a2 = substr($code, 5, 1); 	//OR
		$a3 = substr($code, 6, 2); 	//HOOP
		$a4 = substr($code, 8, 1);	//FILLER

		if ( ($a1 != "0") && ($a2 != "0") && ($a3 != "00") && ($a4 != "0") ) {
			// COMPLETE	1-2-3-4
			$qry['type_code'] = 'CMP';
		} else 
		if ( ($a1 != "0") && ($a3 != "00") && ($a4 != "0") ) {
			// IR+BASIC	1-3-4
			$qry['type_code'] = 'IRB';
		} else
		if ( ($a2 != "0") && ($a3 != "00") && ($a4 != "0") ) {
			// OR+BASIC	2-3-4
			$qry['type_code'] = 'ORB';
		} else
		if ( ($a3 != "00") && ($a4 != "0") ) {
			// BASIC	3-4
			$qry['type_code'] = 'BSC';
		} else
		if ( ($a1 != "0") ) {
			// IR	1
			$qry['type_code'] = 'IR';
		} else
		if ( ($a2 != "0") ) {
			// OR	2
			$qry['type_code'] = 'OR';
		} 
		
		return $qry;
	}
	
	function get_swg_parts_test( $code=NULL, $id=NULL, $children=NULL ) {
		if (empty($code)) 
			return FALSE;
		
		if ( strlen($code) != 10 )
			return FALSE;
		
		// COMPLETE	1-2-3-4
		// 0123456789
		// AA01BB0110	F
		for ( $i=1; $i<=strlen($code); $i++ ) {
			if ( $i==3 || $i==4 ) {
				
				$res[3] = substr($code, 2, 2);
			} 
			elseif ($i==7 || $i==8 ) {
				
				$res[7] = substr($code, 6, 2);
			} 
			else {
			
				$res[$i] = substr($code, $i-1, 1);
			}
		}
		
		if ( !empty($id) ) 
			$qry['id'] = $id;
			
		$qry['code'] = $code;
			
		foreach ( $res as $key => $val ) {
			if ( $key==1 ) {
				$qry['standard'] = $this->db->get_where( '[01_standard]', array( 'code'=>$val ) )->row()->name;
			}
			if ( $key==2 ) {
				$qry['class'] = $this->db->get_where( '[02_class]', array( 'code'=>$val, 'standard_code'=>$res[1] ) )->row()->value;
			}
			if ( $key==3 ) {
				$qry['size'] = $this->db->get_where( '[03_size]', array( 'code'=>$val, 'standard_code'=>$res[1] ) )->row()->value_string;
			}
			if ( $key==5 ) {
				$qry['ir'] = $this->db->get_where( '[05_ir]', array( 'code'=>$val ) )->row()->name;
			}
			if ( $key==6 ) {
				$qry['or'] = $this->db->get_where( '[06_or]', array( 'code'=>$val ) )->row()->name;
			}
			if ( $key==7 ) {
				$qry['hoop'] = $this->db->get_where( '[07_hoop]', array( 'code'=>$val ) )->row()->name;
			}
			if ( $key==9 ) {
				$qry['filler'] = $this->db->get_where( '[09_filler]', array( 'code'=>$val ) )->row()->name;
			}
			if ( $key==10 ) {
				$qry['progress'] = $this->db->get_where( '[10_progress]', array( 'code'=>$val ) )->row()->name;
			}
		}
		
		if ( !empty($children) ) 
			$qry['children'] = $this->get_swg_parts( $children );
			
		return $qry;
	}
	
}