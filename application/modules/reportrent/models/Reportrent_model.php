<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Reportrent_model extends CI_Model{

	function ViewGetReportRent(){
		return $this->db->get('T_Rental');
	}	
}

?>