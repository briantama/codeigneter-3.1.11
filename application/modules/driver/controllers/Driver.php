<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Driver extends CI_Controller {

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


	//
	function viewDriver(){
    $uri   = $this->uri->segment(3);
    $uri1  = $this->uri->segment(4);
    $uri2  = $this->uri->segment(5);
    $jdeco = json_decode(file_get_contents('php://input'));
	 
    //get date time
    $datetm= date('Y-m-d H:i:s');
    $usernm= $this->session->userdata('nama');

    if(trim($uri) == "view"){
      $qry = $this->db->query("SELECT * FROM M_MasterDriver WHERE DriverID = '$uri1'");
      if ($qry->num_rows() > 0) {
        $res = $qry->row();
        $this->jcode($res);
      }
      else{
        $str["DriverID"]           = "";
        $str["DriverName"]         = "";
        $str["MobilePhone"]        = "";
        $str["HomePhone"]          = "";
        $str["Address"]            = "";
        $str["IdentityID"]         = "";
        $str["Email"]              = "";
        $str["DailyDrivingCosts"]  = "";
        $str["DriverImage"]        = "";
        $str["IsActive"]           = "";
        $this->jcode($str);
      }

      exit();
    }
    else if (trim($uri) == "save") {
      $status = "";
      $msg    = "";
      $file_element_name = 'userfile';

      //code post 
      $driv       = strtoupper($_POST['driverid']);
      $drivnm     = ucwords(strtolower($_POST['drivername']));
      $mobphone   = $_POST['mobphone'];
      $homephone  = $_POST['homephone'];
      $identityid = $_POST['identityid'];
      $addres     = ucwords(strtolower($_POST['addres']));
      $email      = $_POST['email'];
      $dailyfee   = $_POST['dailyfee'];

      if ($status != "error") {
        $config['upload_path']   = './upload/driver/';
        $config['allowed_types'] = 'gif|jpg|png';
        $config['max_size']      = 1024;
        $config['encrypt_name']  = FALSE;

        $this->load->library('upload', $config);
        if (!$this->upload->do_upload($file_element_name)) {
          $status = 'ok';
          $msg = $this->upload->display_errors('', '');

          if ($_POST['id'] != "") {
            $this->db->query("UPDATE  M_MasterDriver
                                      SET     DriverName          = '".$drivnm."',
                                              MobilePhone         = '".$mobphone."',
                                              HomePhone           = '".$homephone."',
                                              Address             = '".$addres."',
                                              IdentityID          = '".$identityid."',
                                              Email               = '".$email."',
                                              DailyDrivingCosts   = '".$dailyfee."',
                                              IsActive            = 'Y',
                                              LastUpdateDate      = '".$datetm."',
                                              LastUpdateBy        = '".$usernm."'
                                      WHERE   DriverID             = '".$_POST['id']."'");
          } 
          else {

            //notif save error uload image null
            $jeson['status']   = "bad";
            $jeson['msg']      = "Customer Image, ".$msg;
            $jeson['focus']    = "userfile";
            header('Content-Type: text/html');
            echo json_encode($jeson);
            exit;

            $this->db->query("INSERT INTO M_MasterDriver
                                    (DriverID, DriverName, IdentityID, MobilePhone, HomePhone, Email, Address, 
                                     DailyDrivingCosts, IsActive, EntryBy, EntryDate, LastUpdateBy, LastUpdateDate) 
                              VALUES 
                                    ('".$driv."', '".$drivnm."', '".$identityid."','".$mobphone."','".$homephone."', '".$email."', '".$addres."',
                                     ".$dailyfee.", 'Y',  '".$usernm."',  '".$datetm."', '".$usernm."',  '".$datetm."')
                                    ");
          }
        } 
        else {
          $data = $this->upload->data();
          $image_path = $data['full_path'];
          if(file_exists($image_path)) {
            $status = "ok";
            $msg    = "Upload gambar berhasil";
          } else {
            $status = "ok";
            $msg    = "Terjadi kesalahan. Ulangi lagi.";
          }
          $ambil_gambar = $this->db->query("SELECT DriverImage FROM M_MasterDriver WHERE DriverID = '".$_POST['id']."'")->row();
          if ($_POST['id'] != "") {

            if($ambil_gambar->DriverImage != ""){
              if(file_exists("./upload/driver/".$ambil_gambar->DriverImage)){
                  unlink("./upload/driver/".$ambil_gambar->DriverImage);
              }
            }

            $this->db->query("UPDATE  M_MasterDriver
                                      SET     DriverImage         = '".$data['file_name']."', 
                                              DriverName          = '".$drivnm."',
                                              MobilePhone         = '".$mobphone."',
                                              HomePhone           = '".$homephone."',
                                              Address             = '".$addres."',
                                              IdentityID          = '".$identityid."',
                                              Email               = '".$email."',
                                              DailyDrivingCosts   = ".$dailyfee.",
                                              IsActive            = 'Y',
                                              LastUpdateDate      = '".$datetm."',
                                              LastUpdateBy        = '".$usernm."'
                                      WHERE   DriverID            = '".$_POST['id']."'
                            ");
          } else {
            $this->db->query("INSERT INTO M_MasterDriver
                                    (DriverID, DriverName, IdentityID, MobilePhone, HomePhone, Email, Address, 
                                     DailyDrivingCosts, DriverImage, IsActive, EntryBy, EntryDate, LastUpdateBy, LastUpdateDate ) 
                              VALUES 
                                    ('".$driv."', '".$drivnm."', '".$identityid."','".$mobphone."','".$homephone."', '".$email."', '".$addres."',
                                     ".$dailyfee.", '".$data['file_name']."',  'Y', '".$usernm."',  '".$datetm."', '".$usernm."',  '".$datetm."') 
                            ");
          }
         
        }
      }
      $jeson['status']   = $status;
      $jeson['id']       = $_POST['id'];
      $jeson['msg']      = "Driver Save ".$msg;
      $jeson['notif']    = "Successfuly Saved !!!";
      header('Content-Type: text/html');
      echo json_encode($jeson);
      exit;
    }

    else if (trim($uri) == "delete") {
        $this->db->query("UPDATE  M_MasterDriver 
                          SET     IsActive        = 'N',
                                  LastUpdateDate  = '".$datetm."',
                                  LastUpdateBy    = '".$usernm."' 
                          WHERE   DriverID        = '".$uri1."'
                        ");

        $ret_arr['status']  = "ok";
        $ret_arr['caption'] = "Delete Success !!!";
        $this->jcode($ret_arr);
        exit();
    }
    else if(trim($uri) == "print"){
      $this->load->model('driver_model');
      $data['title']        = 'Print Report Driver';
      $data['isi']          = 'driver/driver_print';
      $data['drivdata']     = $this->driver_model->ViewGetDriver()->result();
      $this->load->view('driver/driver_print',$data);
    }
    else if(trim($uri) == "export"){
      $this->load->model('driver_model');
      $data['title']        = 'Export Data Driver';
      $data['isi']          = 'driver/driver_export';
      $data['drivdata']     = $this->driver_model->ViewGetDriver()->result();
      $data['filenm']       = "Master-Driver";
      $this->load->view('driver/driver_export',$data);
    }
    else{
      $this->load->model('driver_model');
      $data['title']        = 'Data Driver';
      $data['isi']          = 'driver/driver_view';
      $data['drivdata']     = $this->driver_model->ViewGetDriver()->result();
      //$this->load->view('admin/layout/wrapper',$data);
      //view code call ajax
      //$this->load->view('merk/merk_view',$data);
      $this->load->view('driver/driver_view',$data);
    }
	}

  public function jcode($data) {
    header('Content-Type: application/json');
    echo json_encode($data);
  }
  

}