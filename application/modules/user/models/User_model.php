<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class User_model extends CI_Model{

	function ViewGetUser(){
		return $this->db->query("
								 SELECT AdminID, AdminName, DateOfBirth, email, UserName, Password, 
								 		SuperUser, AdminImage, IsActive, EntryBy, EntryDate, LastUpdateBy, LastUpdateDate 
								 FROM 	M_User 
								 WHERE  IsActive ='Y'

								");
	}	
}

?>