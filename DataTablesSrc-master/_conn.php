<?php
if($_SERVER['HTTP_HOST']=='localhost'){
    define('USERNAME','root');
    define('PASSWORD','');
    define('DATABASE','aaradhya');
}
else{
    define('USERNAME','knebxnii_aaradhy');
    define('PASSWORD','aaradhya@123');
    define('DATABASE','knebxnii_aaradhya');
}
// SQL server connection information
$sql_details = array(
    'user' => USERNAME,
    'pass' => PASSWORD,
    'db' => DATABASE,
    'host' => 'localhost'
);

