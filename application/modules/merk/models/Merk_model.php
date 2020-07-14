<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Merk_model extends CI_Model{

	function ViewGetMerk(){
		return $this->db->get('M_MasterMerk');
	}	
}

?>