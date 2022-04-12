<?php
if(!isset($_SERVER['HTTP_REFERER'])){
    // redirect them to your desired location
    header('location:index.html');
    exit;
}
/*
 * DataTables example server-side processing script.
 *
 * Please note that this script is intentionally extremely simple to show how
 * server-side processing can be implemented, and probably shouldn't be used as
 * the basis for a large complex system. It is suitable for simple use cases as
 * for learning.
 *
 * See http://datatables.net/usage/server-side for full details on the server-
 * side processing requirements of DataTables.
 *
 * @license MIT - http://datatables.net/license_mit
 */

/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
 * Easy set variables
 */
// DB table to use

$table = 'saputara_hotel_modules sp';
// Table's primary key
$primaryKey = 'sp.hotel_id';
// Array of database columns which should be read and sent back to DataTables.
// The `db` parameter represents the column name in the database, while the `dt`
// parameter represents the DataTables column identifier. In this case simple
// indexes
$columns = array(      
    array('db' => 'sp.hotel_id', 'dt' =>'hotel_id'),
    array('db' => 'sp.client_id', 'dt' =>'client_id'),
    array('db' => 'sp.hotel_main_image', 'dt' =>'hotel_main_image'),   
    array('db' => 'sp.hotel_title', 'dt' =>'hotel_title'),   
    array('db' => 'sp.hotel_descriptions', 'dt' =>'hotel_descriptions'),   
    array('db' => 'sp.top_package_id', 'dt' =>'top_package_id'),   
    array('db' => 'sp.ads_package_id', 'dt' =>'ads_package_id'),   
    array('db' => 'sp.top_package_payment_status', 'dt' =>'top_package_payment_status'),   
    array('db' => 'sp.top_payment_id', 'dt' =>'top_payment_id'),   
    array('db' => 'sp.ads_package_payment_status', 'dt' =>'ads_package_payment_status'),   
    array('db' => 'sp.ads_payment_id', 'dt' =>'ads_payment_id'),   
    array('db' => 'sp.is_active', 'dt' =>'is_active')
    
   
);
include 'conn.php';

$where="";

//if(!empty($_REQUEST['search']['value'])){
//    $value=$_REQUEST['search']['value'];
//    $where.=" (hc.category_title LIKE '%$value%' OR hc1.category_title LIKE '%$value%' OR huf.upload_file_title LIKE '%$value%' OR huf.upload_file_desc LIKE '%$value%' OR huf.upload_file_original_name LIKE '%$value%' OR huf.upload_file_status LIKE '%$value%') ";
//}

/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
 * If you just want to use the basic configuration for DataTables with PHP
 * server-side, there is no need to edit below this line.
 */
require('ssp.class.php');
echo json_encode(
       SSP::hotel_list($_REQUEST, $sql_details, $table, $primaryKey, $columns,$where)
);


