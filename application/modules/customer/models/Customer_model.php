<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class customer_model extends CI_Model{

	function ViewGetCustomer(){
		return $this->db->get('T_CustomerOrder');
	}	
}

?>