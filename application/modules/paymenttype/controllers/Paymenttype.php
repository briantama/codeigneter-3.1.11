<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Paymenttype extends CI_Controller {

	function __construct(){
		parent::__construct();
	
		if($this->session->userdata('status') != "login"){
			redirect(base_url("login"));
		}
	}

	public function index() {
		$data=array('title'=> 'Bryn Rentcar - Halaman Administrator',
      					'isi'  => 'dasbor/dasbor_view'
      						);
		$this->load->view('layout/wrapper',$data);	
	}


	//galeri widget
	function viewPaymenttype(){
    $uri   = $this->uri->segment(3);
    $uri1  = $this->uri->segment(4);
    $uri2  = $this->uri->segment(5);
    $jdeco = json_decode(file_get_contents('php://input'));
	 
    //get date time
    $datetm= date('Y-m-d H:i:s');
    $usernm= $this->session->userdata('nama');

    if(trim($uri) == "view"){
      $qry = $this->db->query("SELECT * FROM T_PaymentType WHERE PaymentID = '$uri1'");
      if ($qry->num_rows() > 0) {
        $res = $qry->row();
        $this->jcode($res);
      }
      else{
        $str["PaymentID"]   = 0;
        $str["PaymentType"] = "";
        $this->jcode($str);
      }
      exit();
    }
    else if (trim($uri) == "save") {

      //post file
      $paytype   = ucwords(strtolower($_POST['paytype']));

      $res = $this->db->query("SELECT PaymentID FROM T_PaymentType WHERE PaymentID = '".$_POST['id']."'");
          if ($res->num_rows() == 0) {
						
            $this->db->query("INSERT INTO T_PaymentType
																		( PaymentType, IsActive, EntryDate, EntryBy, LastUpdateDate, LastUpdateBy ) 
															VALUES 
																		('".$paytype."', 'Y', '".$datetm."', '".$usernm."',  '".$datetm."', '".$usernm."')	
														");
						$msg = "Save";
          }
					else {
						$this->db->query("UPDATE 	T_PaymentType
																			SET			PaymentType  		    	  = '".$paytype."',
																							IsActive 								= 'Y',
																							LastUpdateDate      		= '".$datetm."',
																							LastUpdateBy        		= '".$usernm."'
																			WHERE 	PaymentID  			    		= '".$_POST['id']."'
														");
						$msg = "Update";
          }
        
      
      $jeson['status']   = "ok";
      $jeson['id']       = $_POST['id'];
      $jeson['msg']      = "Successfuly ".$msg;
      $jeson['notif']    = "Successfuly Saved !!!";
      header('Content-Type: text/html');
      echo json_encode($jeson);
      exit;
    }
    else if (trim($uri) == "delete") {
        $this->db->query("UPDATE  T_PaymentType 
                          SET     IsActive        = 'N',
                                  LastUpdateDate  = '".$datetm."',
                                  LastUpdateBy    = '".$usernm."' 
                          WHERE   PaymentID       = '".$uri1."'
                        ");

        $ret_arr['status']  = "ok";
        $ret_arr['caption'] = "Delete Success !!!";
        $this->jcode($ret_arr);
        exit();
    }
    else if(trim($uri) == "print"){
      $this->load->model('paymenttype_model');
      $data['title']        = 'Print Payment Type';
      $data['isi']          = 'paymenttype/paymenttype_print';
      $data['paydata']      = $this->paymenttype_model->ViewGetPaymentType()->result();
      $this->load->view('paymenttype/paymenttype_print',$data);
    }
    else if(trim($uri) == "export"){
      $this->load->model('paymenttype_model');
      $data['title']        = 'Export Payment Type';
      $data['isi']          = 'paymenttype/paymenttype_export';
      $data['paydata']      = $this->paymenttype_model->ViewGetPaymentType()->result();
      $data['filenm']       = "Data-Paymenttype";
      $this->load->view('paymenttype/paymenttype_export',$data);
    }
    else{
      $this->load->model('paymenttype_model');
      $data['title']        = 'Data Payment Type';
      $data['isi']          = 'paymenttype/paymenttype_view';
      $data['paydata']      = $this->paymenttype_model->ViewGetPaymentType()->result();
      //$this->load->view('admin/layout/wrapper',$data);
      //view code call ajax
      //$this->load->view('merk/merk_view',$data);
      $this->load->view('paymenttype/paymenttype_view',$data);
    }
	}

  public function jcode($data) {
    header('Content-Type: application/json');
    echo json_encode($data);
  }
  

}