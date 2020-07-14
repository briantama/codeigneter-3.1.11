<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Merk extends CI_Controller {

	function __construct(){
		parent::__construct();
	
		if($this->session->userdata('status') != "login"){
			redirect(base_url("login"));
		}
	}

	public function index() {
		$data=array('title'=>'Bryn Rentcar - Halaman Administrator',
					 'isi' =>'dasbor/dasbor_view'
						);
		$this->load->view('layout/wrapper',$data);	
	}


	//galeri widget
	function viewMerk(){
    $uri   = $this->uri->segment(3);
    $uri1  = $this->uri->segment(4);
    $uri2  = $this->uri->segment(5);
    $jdeco = json_decode(file_get_contents('php://input'));
	 
    //get date time
    $datetm= date('Y-m-d H:i:s');
    $usernm= $this->session->userdata('nama');

    if(trim($uri) == "view"){
      $qry = $this->db->query("SELECT * FROM M_MasterMerk WHERE MerkID = '$uri1'");
      if ($qry->num_rows() > 0) {
        $res = $qry->row();
        $this->jcode($res);
      }
      else{
        $str["MerkID"]   = 0;
        $str["MerkName"] = "";
        $this->jcode($str);
      }
      exit();
    }
    else if (trim($uri) == "save") {

      //post file
      $merknm   = ucwords(strtolower($_POST['merk']));

      $res = $this->db->query("SELECT MerkID FROM M_MasterMerk WHERE MerkID = '".$_POST['id']."'");
          if ($res->num_rows() == 0) {
						
            $this->db->query("INSERT INTO M_MasterMerk
																		( MerkName, IsActive, EntryDate, EntryBy, LastUpdateDate, LastUpdateBy  ) 
															VALUES 
																		('".$merknm."', 'Y', '".$datetm."', '".$usernm."', '".$datetm."', '".$usernm."')	
														");
						$msg = "Save";
          }
					else {
						$this->db->query("UPDATE 	M_MasterMerk
																			SET			MerkName    		    	  = '".$merknm."',
																							IsActive 								= 'Y',
																							LastUpdateDate      		= '".$datetm."',
																							LastUpdateBy        		= '".$usernm."'
																			WHERE 	MerkID  			    			= '".$_POST['id']."'
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
        $this->db->query("UPDATE  M_MasterMerk 
                          SET     IsActive        = 'N',
                                  LastUpdateDate  = '".$datetm."',
                                  LastUpdateBy    = '".$usernm."' 
                          WHERE   MerkID          = '".$uri1."'
                        ");

        $ret_arr['status']  = "ok";
        $ret_arr['caption'] = "Delete Success !!!";
        $this->jcode($ret_arr);
        exit();
    }
    else if(trim($uri) == "export"){
      $this->load->model('Merk_model');
      $data['title']        = 'Export Merk';
      $data['isi']          = 'merk/merk_export';
      $data['merkdata']     = $this->Merk_model->ViewGetMerk()->result();
      $data['filenm']       = "Master-merk";
      $this->load->view('merk/merk_export',$data);
    }
    else if(trim($uri) == "print"){
      $this->load->model('Merk_model');
      $data['title']        = 'Data Merk';
      $data['isi']          = 'merk/merk_print';
      $data['merkdata']     = $this->Merk_model->ViewGetMerk()->result();
      $this->load->view('merk/merk_print',$data);
    }
    else{
      $this->load->model('Merk_model');
      $data['title']        = 'Data Merk';
      $data['isi']          = 'merk/merk_view';
      $data['merkdata']     = $this->Merk_model->ViewGetMerk()->result();
      //$this->load->view('admin/layout/wrapper',$data);
      //view code call ajax
      //$this->load->view('merk/merk_view',$data);
      $this->load->view('merk/merk_view',$data);
    }
	}

  public function jcode($data) {
    header('Content-Type: application/json');
    echo json_encode($data);
  }
  

}