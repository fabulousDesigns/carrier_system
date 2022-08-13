<?php
ob_start();
date_default_timezone_set("Africa/Nairobi");

$action = $_GET['action'];
include 'item-track.php';
$crud = new Action();

if($action == 'get_parcel_heistory'){
	$get = $crud->get_parcel_heistory();
	if($get)
		echo $get;
}

ob_end_flush();
?>