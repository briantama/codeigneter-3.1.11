<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Dasbor extends CI_Controller {

	function __construct(){
		parent::__construct();
	
		if($this->session->userdata('status') != "login"){
			redirect(base_url("login"));
		}
	}

	public function index() {
		$data=array('title'=>'Bryn Rentcar - Halaman Administrator',
					'menu' => 'Dashboard',
					'isi'  =>'dasbor/Dasbor_view'
						);
		$this->load->view('layout/wrapper',$data);	
	}

	public function dasbor_page() {
	    $data=array('title'=>'Bryn Rentcar - Halaman Administrator',
	    			'menu' => 'Dashboard',
	                'isi'  =>'dasbor/Dasbor_load'
	            );
	    //$this->load->view('admin/layout/wrapper',$data);  
	    $this->load->view('dasbor/Dasbor_load',$data);
	}

}