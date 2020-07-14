<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Driver_model extends CI_Model{

	function ViewGetDriver(){
		return $this->db->query("
								 SELECT 	DriverID, DriverName, IdentityID, MobilePhone, HomePhone, Email, Address, 
                                     		REPLACE(FORMAT(DailyDrivingCosts ,2),'.00','') AS DailyDrivingCosts, 
                                     		DriverImage, IsActive, EntryBy, EntryDate, LastUpdateBy, LastUpdateDate
								 FROM 		M_MasterDriver

								");
	}	
}

?>