<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Reportcar_model extends CI_Model{

	function ViewGetReportCar(){
		return $this->db->get('M_MasterCar');
	}	
}

?>