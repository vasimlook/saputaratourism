<?php
/*
 * Helper functions for building a DataTables server-side processing SQL query
 *
 * The static functions in this class are just helper functions to help build
 * the SQL used in the DataTables demo server-side processing scripts. These
 * functions obviously do not represent all that can be done with server-side
 * processing, they are intentionally simple to show how it works. More complex
 * server-side processing operations will likely require a custom script.
 *
 * See http://datatables.net/usage/server-side for full details on the server-
 * side processing requirements of DataTables.
 *
 * @license MIT - http://datatables.net/license_mit
 */
//$protocol = (!empty($_SERVER['HTTPS']) && strtolower($_SERVER['HTTPS'])!== 'off') ? 'https' : 'http';
//$base_url = $protocol.'://'.$_SERVER['HTTP_HOST'];

include '../common_url.php';
//define('BASE_URL', $url);
// REMOVE THIS BLOCK - used for DataTables test environment only!
$file = $_SERVER['DOCUMENT_ROOT'].'/datatables/pdo.php';
if ( is_file( $file ) ) {
	include( $file );
}
class SSP {
	/**
	 * Create the data output array for the DataTables rows
	 *
	 *  @param  array $columns Column information array
	 *  @param  array $data    Data from the SQL get
	 *  @return array          Formatted data in a row based format
	 */
    
        static function data_output($columns, $data) {
//      print_r($columns);die;
        $out = array();
        for ($i = 0, $ien = count($data); $i < $ien; $i++) {
            $row = array();
            for ($j = 0, $jen = count($columns); $j < $jen; $j++) {
                $column = $columns[$j];
                // Is there a formatter?
                if (isset($column['formatter'])) {
                    $row[$column['dt']] = $column['formatter']($data[$i][$column['db']], $data[$i]);
                } else {                  
                    $row[$column['dt']] = $data[$i][$columns[$j]['dt']];
                }
            }
            $out[] = $row;
        }
        return $out;
    }
    
    
//	static function data_output ( $columns, $data )
//	{
//		$out = array();
//		for ( $i=0, $ien=count($data) ; $i<$ien ; $i++ ) {
//			$row = array();
//			for ( $j=0, $jen=count($columns) ; $j<$jen ; $j++ ) {
//				$column = $columns[$j];
//				// Is there a formatter?
//				if ( isset( $column['formatter'] ) ) {
//					$row[ $column['dt'] ] = $column['formatter']( $data[$i][ $column['db'] ], $data[$i] );
//				}
//				else {
//					$row[ $column['dt'] ] = $data[$i][ $columns[$j]['db'] ];
//				}
//			}
//			$out[] = $row;
//		}
//		return $out;
//	}
	/**
	 * Database connection
	 *
	 * Obtain an PHP PDO connection from a connection details array
	 *
	 *  @param  array $conn SQL connection details. The array should have
	 *    the following properties
	 *     * host - host name
	 *     * db   - database name
	 *     * user - user name
	 *     * pass - user password
	 *  @return resource PDO connection
	 */
	static function db ( $conn )
	{
		if ( is_array( $conn ) ) {
			return self::sql_connect( $conn );
		}
		return $conn;
	}
	/**
	 * Paging
	 *
	 * Construct the LIMIT clause for server-side processing SQL query
	 *
	 *  @param  array $request Data sent to server by DataTables
	 *  @param  array $columns Column information array
	 *  @return string SQL limit clause
	 */
	static function limit ( $request, $columns )
	{
		$limit = '';
		if ( isset($request['start']) && $request['length'] != -1 ) {
			$limit = "LIMIT ".intval($request['start']).", ".intval($request['length']);
		}
		return $limit;
	}
	/**
	 * Ordering
	 *
	 * Construct the ORDER BY clause for server-side processing SQL query
	 *
	 *  @param  array $request Data sent to server by DataTables
	 *  @param  array $columns Column information array
	 *  @return string SQL order by clause
	 */
	static function order ( $request, $columns )
	{
		$order = '';
		if ( isset($request['order']) && count($request['order']) ) {
			$orderBy = array();
			$dtColumns = self::pluck( $columns, 'dt' );
			for ( $i=0, $ien=count($request['order']) ; $i<$ien ; $i++ ) {
				// Convert the column index into the column data property
				$columnIdx = intval($request['order'][$i]['column']);
				$requestColumn = $request['columns'][$columnIdx];
				$columnIdx = array_search( $requestColumn['data'], $dtColumns );
				$column = $columns[ $columnIdx ];
				if ( $requestColumn['orderable'] == 'true' ) {
					$dir = $request['order'][$i]['dir'] === 'asc' ?
						'ASC' :
						'DESC';
					$orderBy[] = ''.$column['db'].' '.$dir;
				}
			}
			if ( count( $orderBy ) ) {
				$order = 'ORDER BY '.implode(', ', $orderBy);
			}
		}
		return $order;
	}
	/**
	 * Searching / Filtering
	 *
	 * Construct the WHERE clause for server-side processing SQL query.
	 *
	 * NOTE this does not match the built-in DataTables filtering which does it
	 * word by word on any field. It's possible to do here performance on large
	 * databases would be very poor
	 *
	 *  @param  array $request Data sent to server by DataTables
	 *  @param  array $columns Column information array
	 *  @param  array $bindings Array of values for PDO bindings, used in the
	 *    sql_exec() function
	 *  @return string SQL where clause
	 */
	static function filter ( $request, $columns, &$bindings )
	{
		$globalSearch = array();
		$columnSearch = array();
		$dtColumns = self::pluck( $columns, 'dt' );
		if ( isset($request['search']) && $request['search']['value'] != '' ) {                    
			$str = $request['search']['value'];
			for ( $i=0, $ien=count($request['columns']) ; $i<$ien ; $i++ ) {
				$requestColumn = $request['columns'][$i];
				$columnIdx = array_search( $requestColumn['data'], $dtColumns );
				$column = $columns[ $columnIdx ];
				if ( $requestColumn['searchable'] == 'true' ) {
					$binding = self::bind( $bindings, '%'.$str.'%', PDO::PARAM_STR );                                        
					$globalSearch[] = "".$column['db']." LIKE ".$binding;
				}
			}
		}
		// Individual column filtering
		if ( isset( $request['columns'] ) ) {
			for ( $i=0, $ien=count($request['columns']) ; $i<$ien ; $i++ ) {
				$requestColumn = $request['columns'][$i];
				$columnIdx = array_search( $requestColumn['data'], $dtColumns );
				$column = $columns[ $columnIdx ];
				$str = $requestColumn['search']['value'];
				if ( $requestColumn['searchable'] == 'true' &&
				 $str != '' ) {
					$binding = self::bind( $bindings, '%'.$str.'%', PDO::PARAM_STR );
					$columnSearch[] = "".$column['db']." LIKE ".$binding;
				}
			}
		}
		// Combine the filters into a single string
		$where = '';
		if ( count( $globalSearch ) ) {
			$where = '('.implode(' OR ', $globalSearch).')';
		}
		if ( count( $columnSearch ) ) {
			$where = $where === '' ?
				implode(' AND ', $columnSearch) :
				$where .' AND '. implode(' AND ', $columnSearch);
		}
		if ( $where !== '' ) {
			$where = 'WHERE '.$where;
		}
		return $where;
	}
	/**
	 * Perform the SQL queries needed for an server-side processing requested,
	 * utilising the helper functions of this class, limit(), order() and
	 * filter() among others. The returned array is ready to be encoded as JSON
	 * in response to an SSP request, or can be modified if needed before
	 * sending back to the client.
	 *
	 *  @param  array $request Data sent to server by DataTables
	 *  @param  array|PDO $conn PDO connection resource or connection parameters array
	 *  @param  string $table SQL table to query
	 *  @param  string $primaryKey Primary key of the table
	 *  @param  array $columns Column information array
	 *  @return array          Server-side processing response array
	 */
	
      
   
        static function withdrawal_req_list ($request, $conn, $table, $primaryKey, $columns,$where_custom = '')
         {                         
		$bindings = array();
		$db = self::db( $conn );
                
                $columns_order=$columns;
		// Build the SQL query string from the request
                if (($request['order'][0]['column'])>0) {
                    $columnsArray = array();                   
                    foreach ($columns as $crow) {                       
                        if (substr_count($crow['db'], " as ")) {
                            $crow['db'] = explode(" as ", $crow['db'])[0];
                        }
                        array_push($columnsArray, $crow);
                    }
                    $columns_order = $columnsArray;
                }                
                
		$limit = self::limit( $request, $columns );                                               
		$order = self::order( $request, $columns_order );                               
                
		$where = self::filter( $request, $columns, $bindings );
//                $where="";
                if ($where_custom) {
                    if ($where) {
                        $where .= ' AND ' . $where_custom;
                    } else {
                        $where .= 'WHERE ' . $where_custom;
                    }
                } 
                
                $data = self::sql_exec( $db, $bindings,
			"SELECT ".implode(", ", self::pluck($columns, 'db'))."
			FROM $table
                        INNER JOIN hpshrc_customer hc
                        ON hc.customer_id=wr.refCustomer_id
			$where
			$order 
			$limit"
		); 		
		// Data set length after filtering
		$resFilterLength = self::sql_exec( $db, $bindings,
			"SELECT COUNT({$primaryKey})
			FROM $table  
                        INNER JOIN hpshrc_customer hc
                        ON hc.customer_id=wr.refCustomer_id    
			$where "
		);
		$recordsFiltered = $resFilterLength[0][0];
		// Total data set length
		$resTotalLength = self::sql_exec( $db,
			"SELECT COUNT({$primaryKey})
			FROM $table
                        INNER JOIN hpshrc_customer hc
                        ON hc.customer_id=wr.refCustomer_id    
                        "
		);
		$recordsTotal = $resTotalLength[0][0];                
                $result=self::data_output($columns,$data);
                $resData=array();
                if(!empty($result)){                    
                    foreach ($result as $row){                                                                         
                        $customer_id = $row['customer_id'];
                        $withdrawl_req_id = $row['withdrawl_req_id'];
                        $accept_str='';
                        $title = 'Click to accept request';
                        $class = 'btn_accept_request btn btn-xs btn-warning';
                        $text = "Accept <em class='icon ni ni-lock-fill'></em>";
                        $isactive = 0; 
                        $table='withdrawl_req';
                        $table_update_field='status';
                        $table_where_field='withdrawl_req_id';                                                                          
                        $accept_str="<button type='button' data-id='".$withdrawl_req_id."' data-status = '".$isactive."' title='".$title."' class='".$class."' data-table = '".$table."' data-updatefield = '".$table_update_field."' data-wherefield = '".$table_where_field."'>".$text."</button>";                            //                                                
                       $row['index']='';                                               
                        $row['customer_id']='AD'.$customer_id;
                        $row['action']="$accept_str";
                        array_push($resData, $row);
                    }  
                }
		/*
		 * Output
		 */
		return array(
			"draw" => isset ( $request['draw'] ) ? intval( $request['draw'] ) : 0,
			"recordsTotal" => intval( $recordsTotal ),
			"recordsFiltered" => intval( $recordsFiltered ),
			"data" => $resData
		);
	}
	static function category_list($request, $conn, $table, $primaryKey, $columns, $where_custom = '')
	{
		$bindings = array();
		$db = self::db($conn);

		$columns_order = $columns;
		// Build the SQL query string from the request
		if (($request['order'][0]['column']) > 0) {
			$columnsArray = array();
			foreach ($columns as $crow) {
				if (substr_count($crow['db'], " as ")) {
					$crow['db'] = explode(" as ", $crow['db'])[0];
				}
				array_push($columnsArray, $crow);
			}
			$columns_order = $columnsArray;
		}

		$limit = self::limit($request, $columns);
		$order = self::order($request, $columns_order);

		$where = self::filter($request, $columns, $bindings);
		//                $where="";
		if ($where_custom) {
			if ($where) {
				$where .= ' AND ' . $where_custom;
			} else {
				$where .= 'WHERE ' . $where_custom;
			}
		}

		$data = self::sql_exec(
			$db,
			$bindings,
			"SELECT " . implode(", ", self::pluck($columns, 'db')) . "
			FROM $table                       
			$where
			$order 
			$limit"
		);
		// Data set length after filtering
		$resFilterLength = self::sql_exec(
			$db,
			$bindings,
			"SELECT COUNT({$primaryKey})
			FROM $table                       
			$where "
		);
		$recordsFiltered = $resFilterLength[0][0];
		// Total data set length
		$resTotalLength = self::sql_exec(
			$db,
			"SELECT COUNT({$primaryKey})
			FROM $table                       
                        "
		);
		$recordsTotal = $resTotalLength[0][0];
		$result = self::data_output($columns, $data);
		$resData = array();
		if (!empty($result)) {
			foreach ($result as $row) {
				$id = $row['category_id'];
				$checked = '';
				if ($row['is_active'] == 1)
					$checked = 'checked';

				$statusCheckbox = "<input type='checkbox' " . $checked . " class='category_status' data-id =" . $id . ">";

				$row['is_active'] = $statusCheckbox;
				$row['index'] = '';
				$row['action'] = "<a href='" . BASE_URL_DATATABLES . "edit-category/" . $id . "' class='btn btn-xs btn-warning'>Edit  <em class='icon ni ni-edit-fill'></em></a> &nbsp;";
				array_push($resData, $row);
			}
		}
		/*
		 * Output
		 */
		return array(
			"draw" => isset($request['draw']) ? intval($request['draw']) : 0,
			"recordsTotal" => intval($recordsTotal),
			"recordsFiltered" => intval($recordsFiltered),
			"data" => $resData
		);
	}

	static function package_list($request, $conn, $table, $primaryKey, $columns, $where_custom = '')
	{
		$bindings = array();
		$db = self::db($conn);

		$columns_order = $columns;
		// Build the SQL query string from the request
		if (($request['order'][0]['column']) > 0) {
			$columnsArray = array();
			foreach ($columns as $crow) {
				if (substr_count($crow['db'], " as ")) {
					$crow['db'] = explode(" as ", $crow['db'])[0];
				}
				array_push($columnsArray, $crow);
			}
			$columns_order = $columnsArray;
		}

		$limit = self::limit($request, $columns);
		$order = self::order($request, $columns_order);

		$where = self::filter($request, $columns, $bindings);
		//                $where="";
		if ($where_custom) {
			if ($where) {
				$where .= ' AND ' . $where_custom;
			} else {
				$where .= 'WHERE ' . $where_custom;
			}
		}

		$data = self::sql_exec(
			$db,
			$bindings,
			"SELECT " . implode(", ", self::pluck($columns, 'db')) . "
			FROM $table                       
			$where
			$order 
			$limit"
		);
		// Data set length after filtering
		$resFilterLength = self::sql_exec(
			$db,
			$bindings,
			"SELECT COUNT({$primaryKey})
			FROM $table                       
			$where "
		);
		$recordsFiltered = $resFilterLength[0][0];
		// Total data set length
		$resTotalLength = self::sql_exec(
			$db,
			"SELECT COUNT({$primaryKey})
			FROM $table                       
                        "
		);
		$recordsTotal = $resTotalLength[0][0];
		$result = self::data_output($columns, $data);
		$resData = array();
		if (!empty($result)) {
			foreach ($result as $row) {
				$id = $row['package_id'];
				$checked = '';
				if ($row['is_active'] == 1)
					$checked = 'checked';

				$statusCheckbox = "<input type='checkbox' " . $checked . " class='package_status' data-id =" . $id . ">";

				$row['is_active'] = $statusCheckbox;
				$row['index'] = '';
				$row['action'] = "<a href='" . BASE_URL_DATATABLES . "edit-package/" . $id . "' class='btn btn-xs btn-warning'>Edit  <em class='icon ni ni-edit-fill'></em></a> &nbsp;";
				array_push($resData, $row);
			}
		}
		/*
		 * Output
		 */
		return array(
			"draw" => isset($request['draw']) ? intval($request['draw']) : 0,
			"recordsTotal" => intval($recordsTotal),
			"recordsFiltered" => intval($recordsFiltered),
			"data" => $resData
		);
	}

	static function ads_package_list($request, $conn, $table, $primaryKey, $columns, $where_custom = '')
	{
		$bindings = array();
		$db = self::db($conn);

		$columns_order = $columns;
		// Build the SQL query string from the request
		if (($request['order'][0]['column']) > 0) {
			$columnsArray = array();
			foreach ($columns as $crow) {
				if (substr_count($crow['db'], " as ")) {
					$crow['db'] = explode(" as ", $crow['db'])[0];
				}
				array_push($columnsArray, $crow);
			}
			$columns_order = $columnsArray;
		}

		$limit = self::limit($request, $columns);
		$order = self::order($request, $columns_order);

		$where = self::filter($request, $columns, $bindings);
		//                $where="";
		if ($where_custom) {
			if ($where) {
				$where .= ' AND ' . $where_custom;
			} else {
				$where .= 'WHERE ' . $where_custom;
			}
		}

		$data = self::sql_exec(
			$db,
			$bindings,
			"SELECT " . implode(", ", self::pluck($columns, 'db')) . "
			FROM $table                       
			$where
			$order 
			$limit"
		);
		// Data set length after filtering
		$resFilterLength = self::sql_exec(
			$db,
			$bindings,
			"SELECT COUNT({$primaryKey})
			FROM $table                       
			$where "
		);
		$recordsFiltered = $resFilterLength[0][0];
		// Total data set length
		$resTotalLength = self::sql_exec(
			$db,
			"SELECT COUNT({$primaryKey})
			FROM $table                       
                        "
		);
		$recordsTotal = $resTotalLength[0][0];
		$result = self::data_output($columns, $data);
		$resData = array();
		if (!empty($result)) {
			foreach ($result as $row) {
				$id = $row['package_id'];
				$checked = '';
				if ($row['is_active'] == 1)
					$checked = 'checked';

				$statusCheckbox = "<input type='checkbox' " . $checked . " class='package_status' data-id =" . $id . ">";

				$row['is_active'] = $statusCheckbox;
				$row['index'] = '';
				$row['action'] = "<a href='" . BASE_URL_DATATABLES . "edit-ads-package/" . $id . "' class='btn btn-xs btn-warning'>Edit  <em class='icon ni ni-edit-fill'></em></a> &nbsp;";
				array_push($resData, $row);
			}
		}
		/*
		 * Output
		 */
		return array(
			"draw" => isset($request['draw']) ? intval($request['draw']) : 0,
			"recordsTotal" => intval($recordsTotal),
			"recordsFiltered" => intval($recordsFiltered),
			"data" => $resData
		);
	}

	static function hotel_facility_list($request, $conn, $table, $primaryKey, $columns, $where_custom = '')
	{
		$bindings = array();
		$db = self::db($conn);

		$columns_order = $columns;
		// Build the SQL query string from the request
		if (($request['order'][0]['column']) > 0) {
			$columnsArray = array();
			foreach ($columns as $crow) {
				if (substr_count($crow['db'], " as ")) {
					$crow['db'] = explode(" as ", $crow['db'])[0];
				}
				array_push($columnsArray, $crow);
			}
			$columns_order = $columnsArray;
		}

		$limit = self::limit($request, $columns);
		$order = self::order($request, $columns_order);

		$where = self::filter($request, $columns, $bindings);
		//                $where="";
		if ($where_custom) {
			if ($where) {
				$where .= ' AND ' . $where_custom;
			} else {
				$where .= 'WHERE ' . $where_custom;
			}
		}

		$data = self::sql_exec(
			$db,
			$bindings,
			"SELECT " . implode(", ", self::pluck($columns, 'db')) . "
			FROM $table                       
			$where
			$order 
			$limit"
		);
		// Data set length after filtering
		$resFilterLength = self::sql_exec(
			$db,
			$bindings,
			"SELECT COUNT({$primaryKey})
			FROM $table                       
			$where "
		);
		$recordsFiltered = $resFilterLength[0][0];
		// Total data set length
		$resTotalLength = self::sql_exec(
			$db,
			"SELECT COUNT({$primaryKey})
			FROM $table                       
                        "
		);
		$recordsTotal = $resTotalLength[0][0];
		$result = self::data_output($columns, $data);
		$resData = array();
		if (!empty($result)) {
			foreach ($result as $row) {
				$id = $row['facility_id'];
				$checked = '';
				if ($row['is_active'] == 1)
					$checked = 'checked';

				$statusCheckbox = "<input type='checkbox' " . $checked . " class='hotel_facility_status' data-id =" . $id . ">";

				$row['is_active'] = $statusCheckbox;
				$row['index'] = '';
				$row['action'] = "<a href='" . BASE_URL_DATATABLES . "edit-hotel-facility/" . $id . "' class='btn btn-xs btn-warning'>Edit  <em class='icon ni ni-edit-fill'></em></a> &nbsp;";
				array_push($resData, $row);
			}
		}
		/*
		 * Output
		 */
		return array(
			"draw" => isset($request['draw']) ? intval($request['draw']) : 0,
			"recordsTotal" => intval($recordsTotal),
			"recordsFiltered" => intval($recordsFiltered),
			"data" => $resData
		);
	}

	static function slider_list($request, $conn, $table, $primaryKey, $columns, $where_custom = '')
	{
		$bindings = array();
		$db = self::db($conn);

		$columns_order = $columns;
		// Build the SQL query string from the request
		if (($request['order'][0]['column']) > 0) {
			$columnsArray = array();
			foreach ($columns as $crow) {
				if (substr_count($crow['db'], " as ")) {
					$crow['db'] = explode(" as ", $crow['db'])[0];
				}
				array_push($columnsArray, $crow);
			}
			$columns_order = $columnsArray;
		}

		$limit = self::limit($request, $columns);
		$order = self::order($request, $columns_order);

		$where = self::filter($request, $columns, $bindings);
		//                $where="";
		if ($where_custom) {
			if ($where) {
				$where .= ' AND ' . $where_custom;
			} else {
				$where .= 'WHERE ' . $where_custom;
			}
		}

		$data = self::sql_exec(
			$db,
			$bindings,
			"SELECT " . implode(", ", self::pluck($columns, 'db')) . "
			FROM $table                       
			$where
			$order 
			$limit"
		);
		// Data set length after filtering
		$resFilterLength = self::sql_exec(
			$db,
			$bindings,
			"SELECT COUNT({$primaryKey})
			FROM $table                       
			$where "
		);
		$recordsFiltered = $resFilterLength[0][0];
		// Total data set length
		$resTotalLength = self::sql_exec(
			$db,
			"SELECT COUNT({$primaryKey})
			FROM $table                       
                        "
		);
		$recordsTotal = $resTotalLength[0][0];
		$result = self::data_output($columns, $data);
		$resData = array();
		if (!empty($result)) {
			foreach ($result as $row) {
				$id = $row['slider_id'];
				$checked = '';

				$slider_image = UPLOAD_FOLDER.'original/'.$row['slider_image'];
				$row['slider_image'] = "<img style='width:40%' src='".$slider_image."'>";

				if ($row['is_active'] == 1)
					$checked = 'checked';

				$statusCheckbox = "<input type='checkbox' " . $checked . " class='slider_status' data-id =" . $id . ">";

				$row['is_active'] = $statusCheckbox;
				$row['index'] = '';
				$row['action'] = "<a href='" . BASE_URL_DATATABLES . "edit-slider/" . $id . "' class='btn btn-xs btn-warning'>Edit  <em class='icon ni ni-edit-fill'></em></a> &nbsp;";
				array_push($resData, $row);
			}
		}
		/*
		 * Output
		 */
		return array(
			"draw" => isset($request['draw']) ? intval($request['draw']) : 0,
			"recordsTotal" => intval($recordsTotal),
			"recordsFiltered" => intval($recordsFiltered),
			"data" => $resData
		);
	}

	static function hotel_list($request, $conn, $table, $primaryKey, $columns, $where_custom = '')
	{
		$bindings = array();
		$db = self::db($conn);

		$columns_order = $columns;
		// Build the SQL query string from the request
		if (($request['order'][0]['column']) > 0) {
			$columnsArray = array();
			foreach ($columns as $crow) {
				if (substr_count($crow['db'], " as ")) {
					$crow['db'] = explode(" as ", $crow['db'])[0];
				}
				array_push($columnsArray, $crow);
			}
			$columns_order = $columnsArray;
		}

		$limit = self::limit($request, $columns);
		$order = self::order($request, $columns_order);

		$where = self::filter($request, $columns, $bindings);
		//                $where="";
		if ($where_custom) {
			if ($where) {
				$where .= ' AND ' . $where_custom;
			} else {
				$where .= 'WHERE ' . $where_custom;
			}
		}

		$data = self::sql_exec(
			$db,
			$bindings,
			"SELECT " . implode(", ", self::pluck($columns, 'db')) . "
			FROM $table                       
			$where
			$order 
			$limit"
		);
		// Data set length after filtering
		$resFilterLength = self::sql_exec(
			$db,
			$bindings,
			"SELECT COUNT({$primaryKey})
			FROM $table                       
			$where "
		);
		$recordsFiltered = $resFilterLength[0][0];
		// Total data set length
		$resTotalLength = self::sql_exec(
			$db,
			"SELECT COUNT({$primaryKey})
			FROM $table                       
                        "
		);
		$recordsTotal = $resTotalLength[0][0];
		$result = self::data_output($columns, $data);
		$resData = array();
		if (!empty($result)) {
			foreach ($result as $row) {
				$id = $row['hotel_id'];

				$hotel_main_image = UPLOAD_FOLDER.'original/'.$row['hotel_main_image'];
				$row['hotel_main_image'] = "<img style='width:40%' src='".$hotel_main_image."'>";

				$client_id = (int)$row['client_id'];

				$client_details = self::sql_exec($db, "SELECT * FROM client WHERE client_user_id = {$client_id}");				
				$client_name = "";

				if(!empty($client_details)){
					$client_details = current($client_details);
					$client_name = $client_details['user_firstname'].' '.$client_details['user_lastname'];
				}			

				$row['client_id'] = $client_name;

				$top_package_id = (int)$row['top_package_id'];

				$top_package_details = self::sql_exec($db, "SELECT * FROM saputara_facility_packages WHERE package_id = {$top_package_id}");				
				$top_package_name = "";

				if(!empty($top_package_details)){
					$top_package_details = current($top_package_details);
					$top_package_name = $top_package_details['package_title'];
				}			

				$ToppaymentAction = '';

				if($top_package_id !== 0){
					$expired_top_package = (int)$row['top_package_expired'];
					$top_pacakge_status = (int)$row['top_package_payment_status'];
					$top_payment_id = (int)$row['top_payment_id'];

					$ToppaymentAction = "<a href='#' data-payment-id=".$top_payment_id." class='btn btn-xs btn-primary make-top-package-payments'>Make Payments <em class='icon ni ni-edit-fill'></em></a> &nbsp;";

				
					if($top_pacakge_status == 1){
						$ToppaymentAction = "<a href='#' class='btn btn-xs btn-success'>Completed</a> &nbsp;";
					}

					if($expired_top_package){
						$ToppaymentAction = "<a href='#' data-hotel-id=".$id." data-package-id=".$top_package_id." class='btn btn-xs btn-danger renew-hotel-top-package'>Renew <em class='icon ni ni-edit-fill'></em></a> &nbsp;";
					}
				}				

				$row['top_package_id'] = $top_package_name.' '.$ToppaymentAction;

				$ads_package_id = (int)$row['ads_package_id'];

				$ads_package_details = self::sql_exec($db, "SELECT * FROM saputara_ads_packages WHERE package_id = {$ads_package_id}");				
				$ads_package_name = "";

				if(!empty($ads_package_details)){
					$ads_package_details = current($ads_package_details);
					$ads_package_name = $ads_package_details['package_title'];
				}	

				
				$AdspaymentAction = '';

				if($ads_package_id !== 0){
					$ads_package_expired = (int)$row['ads_package_expired'];
					$ads_pacakge_status = (int)$row['ads_package_payment_status'];
					$ads_payment_id = (int)$row['ads_payment_id'];

					$AdspaymentAction = "<a href='#' data-payment-id=".$ads_payment_id." class='btn btn-xs btn-primary make-ads-package'>Make Payments <em class='icon ni ni-edit-fill'></em></a> &nbsp;";

				
					if($ads_pacakge_status == 1){
						$AdspaymentAction = "<a href='#' class='btn btn-xs btn-success'>Completed</a> &nbsp;";
					}

					if($ads_package_expired){
						$AdspaymentAction = "<a href='#' data-hotel-id=".$id." class='btn btn-xs btn-danger renew-hotel-ads-package-payments'>Renew<em class='icon ni ni-edit-fill'></em></a> &nbsp;";
					}
				}

				$row['ads_package_id'] = $ads_package_name.' '.$AdspaymentAction;


				

				$checked = '';
				if ($row['is_active'] == 1)
					$checked = 'checked';

				$statusCheckbox = "<input type='checkbox' " . $checked . " class='hotel_status' data-id =" . $id . ">";

				$row['is_active'] = $statusCheckbox;
				$row['index'] = '';
				$row['action'] = "<a href='" . BASE_URL_DATATABLES . "edit-hotel/" . $id . "' class='btn btn-xs btn-warning'>Edit  <em class='icon ni ni-edit-fill'></em></a> &nbsp;";
				array_push($resData, $row);
			}
		}
		/*
		 * Output
		 */
		return array(
			"draw" => isset($request['draw']) ? intval($request['draw']) : 0,
			"recordsTotal" => intval($recordsTotal),
			"recordsFiltered" => intval($recordsFiltered),
			"data" => $resData
		);
	}

	static function hotel_room_list($request, $conn, $table, $primaryKey, $columns, $where_custom = '')
	{
		$bindings = array();
		$db = self::db($conn);

		$columns_order = $columns;
		// Build the SQL query string from the request
		if (($request['order'][0]['column']) > 0) {
			$columnsArray = array();
			foreach ($columns as $crow) {
				if (substr_count($crow['db'], " as ")) {
					$crow['db'] = explode(" as ", $crow['db'])[0];
				}
				array_push($columnsArray, $crow);
			}
			$columns_order = $columnsArray;
		}

		$limit = self::limit($request, $columns);
		$order = self::order($request, $columns_order);

		$where = self::filter($request, $columns, $bindings);
		//                $where="";
		if ($where_custom) {
			if ($where) {
				$where .= ' AND ' . $where_custom;
			} else {
				$where .= 'WHERE ' . $where_custom;
			}
		}

		$data = self::sql_exec(
			$db,
			$bindings,
			"SELECT " . implode(", ", self::pluck($columns, 'db')) . "
			FROM $table                       
			$where
			$order 
			$limit"
		);
		// Data set length after filtering
		$resFilterLength = self::sql_exec(
			$db,
			$bindings,
			"SELECT COUNT({$primaryKey})
			FROM $table                       
			$where "
		);
		$recordsFiltered = $resFilterLength[0][0];
		// Total data set length
		$resTotalLength = self::sql_exec(
			$db,
			"SELECT COUNT({$primaryKey})
			FROM $table                       
                        "
		);
		$recordsTotal = $resTotalLength[0][0];
		$result = self::data_output($columns, $data);
		$resData = array();
		if (!empty($result)) {
			foreach ($result as $row) {
				$id = $row['room_id'];

				
				$hotel_id = (int)$row['hotel_id'];

				$hotel_details = self::sql_exec($db, "SELECT * FROM saputara_hotel_modules WHERE hotel_id = {$hotel_id}");				
				$hotel_name = "";

				if(!empty($hotel_details)){
					$hotel_details = current($hotel_details);
					$hotel_name = $hotel_details['hotel_title'];
				}	
				
				$row['hotel_id'] = $hotel_name;

				$checked = '';
				if ($row['is_active'] == 1)
					$checked = 'checked';

				$statusCheckbox = "<input type='checkbox' " . $checked . " class='hotel_room_status' data-id =" . $id . ">";

				$row['is_active'] = $statusCheckbox;
				$row['index'] = '';
				$row['action'] = "<a href='" . BASE_URL_DATATABLES . "edit-hotel-room/" . $id . "' class='btn btn-xs btn-warning'>Edit  <em class='icon ni ni-edit-fill'></em></a> &nbsp;";
				array_push($resData, $row);
			}
		}
		/*
		 * Output
		 */
		return array(
			"draw" => isset($request['draw']) ? intval($request['draw']) : 0,
			"recordsTotal" => intval($recordsTotal),
			"recordsFiltered" => intval($recordsFiltered),
			"data" => $resData
		);
	}

	static function hotel_top_pacakge_payment_list($request, $conn, $table, $primaryKey, $columns, $where_custom = '')
	{
		$bindings = array();
		$db = self::db($conn);

		$columns_order = $columns;
		// Build the SQL query string from the request
		if (($request['order'][0]['column']) > 0) {
			$columnsArray = array();
			foreach ($columns as $crow) {
				if (substr_count($crow['db'], " as ")) {
					$crow['db'] = explode(" as ", $crow['db'])[0];
				}
				array_push($columnsArray, $crow);
			}
			$columns_order = $columnsArray;
		}

		$limit = self::limit($request, $columns);
		$order = self::order($request, $columns_order);

		$where = self::filter($request, $columns, $bindings);
		//                $where="";
		if ($where_custom) {
			if ($where) {
				$where .= ' AND ' . $where_custom;
			} else {
				$where .= 'WHERE ' . $where_custom;
			}
		}

		$data = self::sql_exec(
			$db,
			$bindings,
			"SELECT " . implode(", ", self::pluck($columns, 'db')) . "
			FROM $table                       
			$where
			$order 
			$limit"
		);
		// Data set length after filtering
		$resFilterLength = self::sql_exec(
			$db,
			$bindings,
			"SELECT COUNT({$primaryKey})
			FROM $table                       
			$where "
		);
		$recordsFiltered = $resFilterLength[0][0];
		// Total data set length
		$resTotalLength = self::sql_exec(
			$db,
			"SELECT COUNT({$primaryKey})
			FROM $table                       
                        "
		);
		$recordsTotal = $resTotalLength[0][0];
		$result = self::data_output($columns, $data);
		$resData = array();
		if (!empty($result)) {
			foreach ($result as $row) {
				$id = $row['payment_id'];

				
				$top_package_id= (int)$row['package_id'];

				$hotel_id = (int)$row['module_id'];

				$hotel_details = self::sql_exec($db, "SELECT * FROM saputara_hotel_modules WHERE hotel_id = {$hotel_id}");				
				$hotel_name = "";

				if(!empty($hotel_details)){
					$hotel_details = current($hotel_details);
					$hotel_name = $hotel_details['hotel_title'];
				}	
				
				$row['module_id'] = $hotel_name;
				
				$package_details = self::sql_exec($db, "SELECT * FROM saputara_facility_packages WHERE package_id = {$top_package_id}");				
				$package_name = "";

				if(!empty($package_details)){
					$package_details = current($package_details);
					$package_name = $package_details['package_title'];
				}	
				
				$row['module_id'] = $hotel_name;
				$row['package_id'] = $package_name;				
				
				$row['index'] = '';

				$paymentAction = "<a href='#' data-payment-id=".$id." class='btn btn-xs btn-primary make-top-package-payments'>Make Payments <em class='icon ni ni-edit-fill'></em></a> &nbsp;";

				if($row['payment_status'] == 1){
					$paymentAction = "<a href='#' class='btn btn-xs btn-success'>Completed</a> &nbsp;";
				}
					

				$row['action'] = $paymentAction;
				array_push($resData, $row);
			}
		}
		/*
		 * Output
		 */
		return array(
			"draw" => isset($request['draw']) ? intval($request['draw']) : 0,
			"recordsTotal" => intval($recordsTotal),
			"recordsFiltered" => intval($recordsFiltered),
			"data" => $resData
		);
	}

	static function hotel_ads_pacakge_payment_list($request, $conn, $table, $primaryKey, $columns, $where_custom = '')
	{
		$bindings = array();
		$db = self::db($conn);

		$columns_order = $columns;
		// Build the SQL query string from the request
		if (($request['order'][0]['column']) > 0) {
			$columnsArray = array();
			foreach ($columns as $crow) {
				if (substr_count($crow['db'], " as ")) {
					$crow['db'] = explode(" as ", $crow['db'])[0];
				}
				array_push($columnsArray, $crow);
			}
			$columns_order = $columnsArray;
		}

		$limit = self::limit($request, $columns);
		$order = self::order($request, $columns_order);

		$where = self::filter($request, $columns, $bindings);
		//                $where="";
		if ($where_custom) {
			if ($where) {
				$where .= ' AND ' . $where_custom;
			} else {
				$where .= 'WHERE ' . $where_custom;
			}
		}

		$data = self::sql_exec(
			$db,
			$bindings,
			"SELECT " . implode(", ", self::pluck($columns, 'db')) . "
			FROM $table                       
			$where
			$order 
			$limit"
		);
		// Data set length after filtering
		$resFilterLength = self::sql_exec(
			$db,
			$bindings,
			"SELECT COUNT({$primaryKey})
			FROM $table                       
			$where "
		);
		$recordsFiltered = $resFilterLength[0][0];
		// Total data set length
		$resTotalLength = self::sql_exec(
			$db,
			"SELECT COUNT({$primaryKey})
			FROM $table                       
                        "
		);
		$recordsTotal = $resTotalLength[0][0];
		$result = self::data_output($columns, $data);
		$resData = array();
		if (!empty($result)) {
			foreach ($result as $row) {
				$id = $row['payment_id'];

				
				$top_package_id= (int)$row['package_id'];

				$hotel_id = (int)$row['module_id'];

				$hotel_details = self::sql_exec($db, "SELECT * FROM saputara_hotel_modules WHERE hotel_id = {$hotel_id}");				
				$hotel_name = "";

				if(!empty($hotel_details)){
					$hotel_details = current($hotel_details);
					$hotel_name = $hotel_details['hotel_title'];
				}	
				
				$row['module_id'] = $hotel_name;
				
				$package_details = self::sql_exec($db, "SELECT * FROM saputara_facility_packages WHERE package_id = {$top_package_id}");				
				$package_name = "";

				if(!empty($package_details)){
					$package_details = current($package_details);
					$package_name = $package_details['package_title'];
				}	
				
				$row['module_id'] = $hotel_name;
				$row['package_id'] = $package_name;				
				
				$row['index'] = '';

				$paymentAction = "<a href='#' data-payment-id=".$id." class='btn btn-xs btn-primary make-ads-package-payments'>Make Payments <em class='icon ni ni-edit-fill'></em></a> &nbsp;";

				if($row['payment_status'] == 1){
					$paymentAction = "<a href='#' class='btn btn-xs btn-success'>Completed</a> &nbsp;";
				}
					

				$row['action'] = $paymentAction;
				array_push($resData, $row);
			}
		}
		/*
		 * Output
		 */
		return array(
			"draw" => isset($request['draw']) ? intval($request['draw']) : 0,
			"recordsTotal" => intval($recordsTotal),
			"recordsFiltered" => intval($recordsFiltered),
			"data" => $resData
		);
	}
         static function customers_view ($request, $conn, $table, $primaryKey, $columns,$where_custom = '')
         {                         
		$bindings = array();
		$db = self::db( $conn );
                
                $columns_order=$columns;
		// Build the SQL query string from the request
                if (($request['order'][0]['column'])>0) {
                    $columnsArray = array();                   
                    foreach ($columns as $crow) {                       
                        if (substr_count($crow['db'], " as ")) {
                            $crow['db'] = explode(" as ", $crow['db'])[0];
                        }
                        array_push($columnsArray, $crow);
                    }
                    $columns_order = $columnsArray;
                }                
                
		$limit = self::limit( $request, $columns );                                               
		$order = self::order( $request, $columns_order );                               
                
		$where = self::filter( $request, $columns, $bindings );
//                $where="";
                if ($where_custom) {
                    if ($where) {
                        $where .= ' AND ' . $where_custom;
                    } else {
                        $where .= 'WHERE ' . $where_custom;
                    }
                } 
                
                $data = self::sql_exec( $db, $bindings,
			"SELECT ".implode(", ", self::pluck($columns, 'db'))."
			FROM $table                       
			$where
			$order 
			$limit"
		); 		
		// Data set length after filtering
		$resFilterLength = self::sql_exec( $db, $bindings,
			"SELECT COUNT({$primaryKey})
			FROM $table                       
			$where "
		);
		$recordsFiltered = $resFilterLength[0][0];
		// Total data set length
		$resTotalLength = self::sql_exec( $db,
			"SELECT COUNT({$primaryKey})
			FROM $table                       
                        "
		);
		$recordsTotal = $resTotalLength[0][0];                
                $result=self::data_output($columns,$data);
                $resData=array();
                if(!empty($result)){                    
                    foreach ($result as $row){                                                                         
                        $customer_id = $row['customer_id'];                                               
                        $locked_unlocked_str='';
                        $title = 'Click to locke customer';
                        $class = 'btn_lock_unlock_customer btn btn-xs btn-success';
                        $text = "Customer Unlocked <em class='icon ni ni-unlock-fill'></em>";
                        $isactive = 1; 
                        $table='hpshrc_customer';
                        $table_update_field='customer_locked_status';
                        $table_where_field='customer_id';
                        if($row['customer_locked_status'] == 1){
                            $title = 'Click to unlocke customer';
                            $class = 'btn_lock_unlock_customer btn btn-xs btn-danger';
                            $text  = "Customer Locked <em class='icon ni ni-lock-fill'></em>";
                            $isactive = 0;                            
                        }                                                    
                        $locked_unlocked_str="<button type='button' data-id='".$customer_id."' data-status = '".$isactive."' title='".$title."' class='".$class."' data-table = '".$table."' data-updatefield = '".$table_update_field."' data-wherefield = '".$table_where_field."'>".$text."</button>";                            //                                                                        
                        $active_inactive_str='';
                        $title = 'Click to inactive customer';
                        $class = 'btn_active_inactive_customer btn btn-xs btn-success';
                        $text = "Customer Activated <em class='icon ni ni-user-check-fill'></em>";
                        $isactive = "REMOVED"; 
                        $table='hpshrc_customer';
                        $table_update_field='customer_status';
                        $table_where_field='customer_id';
                        if($row['customer_status'] == "REMOVED"){
                            $title = 'Click to active customer';
                            $class = 'btn_active_inactive_customer btn btn-xs btn-danger';
                            $text  = "Customer Inactivated <em class='icon ni ni-user-cross-fill'></em>";
                            $isactive = "ACTIVE";                            
                        }                                                    
                        $active_inactive_str="<button type='button' data-id='".$customer_id."' data-status = '".$isactive."' title='".$title."' class='".$class."' data-table = '".$table."' data-updatefield = '".$table_update_field."' data-wherefield = '".$table_where_field."'>".$text."</button>";                            //                                                                                                
                        $row['index']='';                                               
                        $row['customer_id']='AD'.$customer_id;
                        $row['action']="<a href='".BASE_URL_DATATABLES."employee-edit-customer/$customer_id' class='btn btn-xs btn-warning'>Edit  <em class='icon ni ni-edit-fill'></em></a>                            
                            <a href='".BASE_URL_DATATABLES."employee-customers-view/$customer_id' class='btn btn-xs btn-primary'>View  <em class='icon ni ni-eye-fill'></em></a>    
                                $locked_unlocked_str $active_inactive_str";
                        array_push($resData, $row);
                    }  
                }
		/*
		 * Output
		 */
		return array(
			"draw" => isset ( $request['draw'] ) ? intval( $request['draw'] ) : 0,
			"recordsTotal" => intval( $recordsTotal ),
			"recordsFiltered" => intval( $recordsFiltered ),
			"data" => $resData
		);
	}
        
           static function withdrawal_list ($request, $conn, $table, $primaryKey, $columns,$where_custom = '')
         {                         
		$bindings = array();
		$db = self::db( $conn );
                
                $columns_order=$columns;
		// Build the SQL query string from the request
                if (($request['order'][0]['column'])>0) {
                    $columnsArray = array();                   
                    foreach ($columns as $crow) {                       
                        if (substr_count($crow['db'], " as ")) {
                            $crow['db'] = explode(" as ", $crow['db'])[0];
                        }
                        array_push($columnsArray, $crow);
                    }
                    $columns_order = $columnsArray;
                }                
                
		$limit = self::limit( $request, $columns );                                               
		$order = self::order( $request, $columns_order );                               
                
		$where = self::filter( $request, $columns, $bindings );
//                $where="";
                if ($where_custom) {
                    if ($where) {
                        $where .= ' AND ' . $where_custom;
                    } else {
                        $where .= 'WHERE ' . $where_custom;
                    }
                } 
                
                $data = self::sql_exec( $db, $bindings,
			"SELECT ".implode(", ", self::pluck($columns, 'db'))."
			FROM $table                       
			$where
			$order 
			$limit"
		); 		
		// Data set length after filtering
		$resFilterLength = self::sql_exec( $db, $bindings,
			"SELECT COUNT({$primaryKey})
			FROM $table                       
			$where "
		);
		$recordsFiltered = $resFilterLength[0][0];
		// Total data set length
		$resTotalLength = self::sql_exec( $db,
			"SELECT COUNT({$primaryKey})
			FROM $table                       
                        "
		);
		$recordsTotal = $resTotalLength[0][0];                
                $result=self::data_output($columns,$data);
                $resData=array();
                if(!empty($result)){                    
                    foreach ($result as $row){                                                                                                 
                        $row['index']='';
                        array_push($resData, $row);
                    }  
                }
		/*
		 * Output
		 */
		return array(
			"draw" => isset ( $request['draw'] ) ? intval( $request['draw'] ) : 0,
			"recordsTotal" => intval( $recordsTotal ),
			"recordsFiltered" => intval( $recordsFiltered ),
			"data" => $resData
		);
	}
	/**
	 * The difference between this method and the simple one, is that you can
	 * apply additional where conditions to the SQL queries. These can be in
	 * one of two forms:
	 *
	 * * 'Result condition' - This is applied to the result set, but not the
	 *   overall paging information query - i.e. it will not effect the number
	 *   of records that a user sees they can have access to. This should be
	 *   used when you want apply a filtering condition that the user has sent.
	 * * 'All condition' - This is applied to all queries that are made and
	 *   reduces the number of records that the user can access. This should be
	 *   used in conditions where you don't want the user to ever have access to
	 *   particular records (for example, restricting by a login id).
	 *
	 *  @param  array $request Data sent to server by DataTables
	 *  @param  array|PDO $conn PDO connection resource or connection parameters array
	 *  @param  string $table SQL table to query
	 *  @param  string $primaryKey Primary key of the table
	 *  @param  array $columns Column information array
	 *  @param  string $whereResult WHERE condition to apply to the result set
	 *  @param  string $whereAll WHERE condition to apply to all queries
	 *  @return array          Server-side processing response array
	 */
	static function complex ( $request, $conn, $table, $primaryKey, $columns, $whereResult=null, $whereAll=null )
	{
		$bindings = array();
		$db = self::db( $conn );
		$localWhereResult = array();
		$localWhereAll = array();
		$whereAllSql = '';
		// Build the SQL query string from the request
		$limit = self::limit( $request, $columns );
		$order = self::order( $request, $columns );
		$where = self::filter( $request, $columns, $bindings );
		$whereResult = self::_flatten( $whereResult );
		$whereAll = self::_flatten( $whereAll );
		if ( $whereResult ) {
			$where = $where ?
				$where .' AND '.$whereResult :
				'WHERE '.$whereResult;
		}
		if ( $whereAll ) {
			$where = $where ?
				$where .' AND '.$whereAll :
				'WHERE '.$whereAll;
			$whereAllSql = 'WHERE '.$whereAll;
		}
		// Main query to actually get the data
		$data = self::sql_exec( $db, $bindings,
			"SELECT ".implode(", ", self::pluck($columns, 'db'))."
			 FROM $table
			 $where
			 $order
			 $limit"
		);
		// Data set length after filtering
		$resFilterLength = self::sql_exec( $db, $bindings,
			"SELECT COUNT({$primaryKey})
			 FROM   $table
			 $where"
		);
		$recordsFiltered = $resFilterLength[0][0];
		// Total data set length
		$resTotalLength = self::sql_exec( $db, $bindings,
			"SELECT COUNT({$primaryKey})
			 FROM   $table ".
			$whereAllSql
		);
		$recordsTotal = $resTotalLength[0][0];
		/*
		 * Output
		 */
		return array(
			"draw"            => isset ( $request['draw'] ) ?
				intval( $request['draw'] ) :
				0,
			"recordsTotal"    => intval( $recordsTotal ),
			"recordsFiltered" => intval( $recordsFiltered ),
			"data"            => self::data_output( $columns, $data )
		);
	}
	/**
	 * Connect to the database
	 *
	 * @param  array $sql_details SQL server connection details array, with the
	 *   properties:
	 *     * host - host name
	 *     * db   - database name
	 *     * user - user name
	 *     * pass - user password
	 * @return resource Database connection handle
	 */
	static function sql_connect ( $sql_details )
	{
		try {
			$db = @new PDO(
				"mysql:host={$sql_details['host']};dbname={$sql_details['db']}",
				$sql_details['user'],
				$sql_details['pass'],
				array( PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION )
			);
		}
		catch (PDOException $e) {
			self::fatal(
				"An error occurred while connecting to the database. ".
				"The error reported by the server was: ".$e->getMessage()
			);
		}
		return $db;
	}
	/**
	 * Execute an SQL query on the database
	 *
	 * @param  resource $db  Database handler
	 * @param  array    $bindings Array of PDO binding values from bind() to be
	 *   used for safely escaping strings. Note that this can be given as the
	 *   SQL query string if no bindings are required.
	 * @param  string   $sql SQL query to execute.
	 * @return array         Result from the query (all rows)
	 */
	static function sql_exec ( $db, $bindings, $sql=null )
	{
		// Argument shifting
		if ( $sql === null ) {
			$sql = $bindings;
		}
		$stmt = $db->prepare( $sql );
		//echo $sql;
		// Bind parameters
		if ( is_array( $bindings ) ) {
			for ( $i=0, $ien=count($bindings) ; $i<$ien ; $i++ ) {
				$binding = $bindings[$i];
				$stmt->bindValue( $binding['key'], $binding['val'], $binding['type'] );
			}
		}
		// Execute
		try {
			$stmt->execute();
		}
		catch (PDOException $e) {
			self::fatal( "An SQL error occurred: ".$e->getMessage() );
		}
		// Return all
		return $stmt->fetchAll( PDO::FETCH_BOTH );
	}
	/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
	 * Internal methods
	 */
	/**
	 * Throw a fatal error.
	 *
	 * This writes out an error message in a JSON string which DataTables will
	 * see and show to the user in the browser.
	 *
	 * @param  string $msg Message to send to the client
	 */
	static function fatal ( $msg )
	{
		echo json_encode( array( 
			"error" => $msg
		) );
		exit(0);
	}
	/**
	 * Create a PDO binding key which can be used for escaping variables safely
	 * when executing a query with sql_exec()
	 *
	 * @param  array &$a    Array of bindings
	 * @param  *      $val  Value to bind
	 * @param  int    $type PDO field type
	 * @return string       Bound key to be used in the SQL where this parameter
	 *   would be used.
	 */
	static function bind ( &$a, $val, $type )
	{
		$key = ':binding_'.count( $a );
		$a[] = array(
			'key' => $key,
			'val' => $val,
			'type' => $type
		);               
		return $key;
	}
	/**
	 * Pull a particular property from each assoc. array in a numeric array, 
	 * returning and array of the property values from each item.
	 *
	 *  @param  array  $a    Array to get data from
	 *  @param  string $prop Property to read
	 *  @return array        Array of property values
	 */
	static function pluck ( $a, $prop )
	{
		$out = array();
		for ( $i=0, $len=count($a) ; $i<$len ; $i++ ) {
			$out[] = $a[$i][$prop];
		}
		return $out;
	}
	/**
	 * Return a string from an array or a string
	 *
	 * @param  array|string $a Array to join
	 * @param  string $join Glue for the concatenation
	 * @return string Joined string
	 */
	static function _flatten ( $a, $join = ' AND ' )
	{
		if ( ! $a ) {
			return '';
		}
		else if ( $a && is_array($a) ) {
			return implode( $join, $a );
		}
		return $a;
	}
}