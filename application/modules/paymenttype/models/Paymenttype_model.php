<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Paymenttype_model extends CI_Model{

	function ViewGetPaymentType(){
		return $this->db->get('T_PaymentType');
	}	
}

?>