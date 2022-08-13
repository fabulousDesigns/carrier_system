<?php
session_start();
ini_set('display_errors', 1);
Class Action {
	private $db;

	public function __construct() {
		ob_start();
   	include './config/config.php';
    
    $this->db = $conn;
	}
	function __destruct() {
	    $this->db->close();
	    ob_end_flush();
	}


     function get_parcel_heistory(){
		extract($_POST);
		$data = array();
		$parcel = $this->db->query("SELECT * FROM parcels where reference_number = '$ref_no'");
		if($parcel->num_rows <=0){
			return 2;
		}else{
			$parcel = $parcel->fetch_array();
			$data[] = array('status'=>'Item accepted by Courier','date_created'=>date("M d, Y h:i A",strtotime($parcel['date_created'])));
			$history = $this->db->query("SELECT * FROM parcel_tracks where parcel_id = {$parcel['id']}");
			$status_arr = array("Item Accepted by Courier","Collected","Shipped","In-Transit","Arrived At Destination","Out for Delivery","Ready to Pickup","Delivered","Picked-up","Unsuccessfull Delivery Attempt");
			while($row = $history->fetch_assoc()){
				$row['date_created'] = date("M d, Y h:i A",strtotime($row['date_created']));
				$row['status'] = $status_arr[$row['status']];
				$data[] = $row;
			}
			return json_encode($data);
		}
	} 


    }