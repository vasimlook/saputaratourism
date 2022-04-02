<?php
if($_SERVER['HTTP_HOST']=='localhost'){
    define('USERNAME','root');
    define('PASSWORD','');
    define('DATABASE','saputara');
}
else{
     define('USERNAME','knebxnii_aaradhy');
    define('PASSWORD','aradhya@4773');
    define('DATABASE','knebxnii_aaradhya');
}
// SQL server connection information
$sql_details = array(
    'user' => USERNAME,
    'pass' => PASSWORD,
    'db' => DATABASE,
    'host' => 'localhost'
);

