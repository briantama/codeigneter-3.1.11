<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
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


	//user admin
	function viewUser(){

    $uri   = $this->uri->segment(3);
    $uri1  = $this->uri->segment(4);
    //uri url admin/a_artikel/tampil_artikel/(uri3)/value(uri4)
    $uri2  = $this->uri->segment(5);
    $jdeco = json_decode(file_get_contents('php://input'));
	  
	$datetm= date('Y-m-d H:i:s');
    $usernm= $this->session->userdata('nama');
    $ceksup= $this->session->userdata('supuser');

	    if(trim($uri) == "view"){
	      $qry = $this->db->query("SELECT * FROM M_User WHERE AdminID = '$uri1'");
	       if ($qry->num_rows() > 0) {
	        $res = $qry->row();
	        $this->jcode($res);
	      }
	      else{
	        $str["AdminID"]        = "";
	        $str["AdminName"]      = "";
	        $str["DateOfBirth"]    = "";
	        $str["Email"]    	   = "";
	        $str["UserName"]       = "";
	        $str["Password"]       = "";
	        $str["SuperUser"]      = "";
	        $str["IsActive"]       = "";
	        
	        $this->jcode($str);
	      }
	    }
	    else if (trim($uri) == "save") {
				
			if(trim($_POST['password']) != trim($_POST['repassword']) ){
					$jeson['status']   = "Fail";
					$jeson['id']       = $_POST['id'];
					$jeson['msg']      = "Password Not same...!!!";
					$jeson["focus"]    = "repassword";
					header('Content-Type: text/html');
					echo json_encode($jeson);
					exit;
			}
		    else
		    {
				$res = $this->db->query("SELECT AdminID FROM M_User WHERE AdminID = '".$_POST['id']."'");
					if ($res->num_rows() == 0) {

						//cek username
						$cek     = $this->db->query("SELECT Username FROM M_User WHERE UserName = '".trim($_POST['username'])."'");
						if ($cek->num_rows() > 0) {
							$jeson['status']   = "Fail";
							$jeson['id']       = $_POST['id'];
							$jeson['msg']      = "Username ".$_POST['username']." Already Used...!!!";
							$jeson["focus"]    = "username";
							header('Content-Type: text/html');
							echo json_encode($jeson);
							exit;
						}


						if(trim($_POST['password']) == "" || trim($_POST['repassword']) == ""){
							$jeson['status']   = "Fail";
							$jeson['id']       = $_POST['id'];
							$jeson['msg']      = "Please Insert Password Or Re Password...!!!";
							$jeson["focus"]    = "repassword";
							header('Content-Type: text/html');
							echo json_encode($jeson);
							exit;
						}



						$this->db->query("	
											INSERT INTO M_User
											( AdminName, DateOfBirth, Email, UserName, Password, 
											  SuperUser, IsActive, EntryBy, EntryDate, LastUpdateBy, LastUpdateDate ) 
											VALUES 
											( '".$_POST['nama']."', '".$_POST['birthday']."', '".$_POST['email']."', '".$_POST['username']."', '".md5($_POST['password'])."',    
											  '".$_POST['supuser']."', 'Y', '".$usernm."', '".$datetm."', '".$usernm."', '".$datetm."')	
										");
						$msg = "Save";
					} 
					else 
					{
						$cekpsw = (trim($_POST['password']) != "") ? "Password = '".md5($_POST['password'])."'," : "";

						$this->db->query("  UPDATE 	M_User
											SET		AdminName     				= '".$_POST['nama']."',
													DateOfBirth    		    	= '".$_POST['birthday']."',
													Email         		    	= '".$_POST['email']."',
													UserName       		    	= '".$_POST['username']."',
													".$cekpsw."
													SuperUser      		    	= '".$_POST['supuser']."',
													IsActive 					= 'Y',
													LastUpdateDate      		= '".$datetm."',
													LastUpdateBy        		= '".$usernm."'
											WHERE 	AdminID			  			= '".$_POST['id']."'
																	
										");
						$msg = "Update";
					}
							
						
						$jeson['status']   = "ok";
						$jeson['id']       = $_POST['id'];
						$jeson['msg']      = "User Successfuly ".$msg;
						$jeson['notif']    = "Successfuly Saved !!!";
						header('Content-Type: text/html');
						echo json_encode($jeson);
						exit;
			}
				
	    }
	    else if (trim($uri) == "delete") {
	        $this->db->query("UPDATE  M_User 
	                          SET     IsActive        ='N',
	                                  LastUpdateDate  = '".$datetm."',
	                                  LastUpdateBy    = '".$usernm."'
	                          WHERE   AdminID         = '".$uri1."'
	                        ");
	        
	        $ret_arr['status']  = "ok";
	        $ret_arr['caption'] = "Delete Success !!!";
	        $this->jcode($ret_arr);
	        exit();
	    }
	    else if(trim($uri) == "print"){
	      $this->load->model('User_model');
	      $data['title']        = 'Print User';
	      $data['isi']          = 'user/user_print';
	      $data['user']   		= $this->User_model->ViewGetUser()->result();
	      $this->load->view('user/user_print',$data);
	    }
	    else{
	      $this->load->model('User_model');
	      $data['title']        = 'Data User';
	      $data['isi']          = 'user/user_view';
	      if(trim($ceksup) == "Y"){
	      	$qry = $this->db->query("
	      							  SELECT * FROM M_User WHERE UserName = '$usernm'

	      							  UNION ALL 

	      							  SELECT * FROM M_User WHERE SuperUser ='N'

	      							  ");
	      	$param = $qry->result();
	      }
	      else{
	      	$qry = $this->db->query("SELECT * FROM M_User WHERE UserName = '$usernm'");
	      	$param = $qry->result();
	      }
	      $data['user']   		= $param;
	      $this->load->view('user/user_view',$data);
	    }
	     
	    
	}



	public function jcode($data) {
	    header('Content-Type: application/json');
	    echo json_encode($data);
	}
  


}
