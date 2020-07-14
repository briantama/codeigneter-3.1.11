<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Customer extends CI_Controller {

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
	function viewCustomer(){
    $uri   = $this->uri->segment(3);
    $uri1  = $this->uri->segment(4);
    $uri2  = $this->uri->segment(5);
    $jdeco = json_decode(file_get_contents('php://input'));
	 
    //get date time
    $datetm= date('Y-m-d H:i:s');
    $usernm= $this->session->userdata('nama');

    if(trim($uri) == "view"){
      $qry = $this->db->query("SELECT * FROM T_CustomerOrder WHERE OrderID = '$uri1'");
      if ($qry->num_rows() > 0) {
        $res = $qry->row();
        $this->jcode($res);
      }
      else{
        $str["OrderID"]       = "";
        $str["CustomerName"] = "";
        $str["MobilePhone"]   = "";
        $str["HomePhone"]     = "";
        $str["Address"]       = "";
        $str["IdentityID"]    = "";
        $str["Email"]         = "";
        $str["Gender"]        = "";
        $str["OrderImage"]    = "";
        $str["IsActive"]      = "";
        $this->jcode($str);
      }

      exit();
    }
    else if (trim($uri) == "save") {
      $status = "";
      $msg    = "";
      $file_element_name = 'userfile';

      //code post 
      $custid     = strtoupper($_POST['custid']);
      $custname   = ucwords(strtolower($_POST['custname']));
      $mobphone   = $_POST['mobphone'];
      $homephone  = $_POST['homephone'];
      $identityid = $_POST['identityid'];
      $addres     = ucwords(strtolower($_POST['addres']));
      $email      = $_POST['email'];
      $gender     = $_POST['gender'];

      if ($status != "error") {
        $config['upload_path']   = './upload/customer/';
        $config['allowed_types'] = 'gif|jpg|png';
        $config['max_size']      = 1024;
        $config['encrypt_name']  = FALSE;

        $this->load->library('upload', $config);
        if (!$this->upload->do_upload($file_element_name)) {
          $status = 'ok';
          $msg = $this->upload->display_errors('', '');

          if ($_POST['id'] != "") {
            $this->db->query("UPDATE  T_CustomerOrder
                                      SET     CustomerName       = '".$custname."',
                                              MobilePhone         = '".$mobphone."',
                                              HomePhone           = '".$homephone."',
                                              Address             = '".$addres."',
                                              IdentityID          = '".$identityid."',
                                              Email               = '".$email."',
                                              Gender              = '".$gender."',
                                              IsActive            = 'Y',
                                              LastUpdateDate      = '".$datetm."',
                                              LastUpdateBy        = '".$usernm."'
                                      WHERE   OrderID             = '".$_POST['id']."'");
          } 
          else {

            //notif save error uload image null
            $jeson['status']   = "bad";
            $jeson['msg']      = "Customer Image, ".$msg;
            $jeson['focus']    = "userfile";
            header('Content-Type: text/html');
            echo json_encode($jeson);
            exit;

            $this->db->query("INSERT INTO T_CustomerOrder
                                    (OrderID, CustomerName, MobilePhone, HomePhone, Address, IdentityID, Email,
                                      Gender, IsActive, EntryBy, EntryDate, LastUpdateBy, LastUpdateDate) 
                              VALUES 
                                    ('".$custid."', '".$custname."', '".$mobphone."','".$homephone."','".$addres."', '".$identityid."', '".$email."',
                                     '".$gender."', 'Y', '".$datetm."', '".$usernm."', '".$datetm."', '".$usernm."')
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
          $ambil_gambar = $this->db->query("SELECT OrderImage FROM T_CustomerOrder WHERE OrderID = '".$_POST['id']."'")->row();
          if ($_POST['id'] != "") {

             if($ambil_gambar->OrderImage != ""){
              if(file_exists("./upload/customer/".$ambil_gambar->OrderImage)){
                  unlink("./upload/customer/".$ambil_gambar->OrderImage);
              }
            }

            $this->db->query("UPDATE  T_CustomerOrder
                                      SET     OrderImage          = '".$data['file_name']."', 
                                              CustomerName        = '".$custname."',
                                              MobilePhone         = '".$mobphone."',
                                              HomePhone           = '".$homephone."',
                                              Address             = '".$addres."',
                                              IdentityID          = '".$identityid."',
                                              Email               = '".$email."',
                                              Gender              = '".$gender."',
                                              IsActive            = 'Y',
                                              LastUpdateDate      = '".$datetm."',
                                              LastUpdateBy        = '".$usernm."'
                                      WHERE   OrderID             = '".$_POST['id']."'
                            ");
          } else {
            $this->db->query("INSERT INTO T_CustomerOrder
                                    (OrderID, CustomerName, MobilePhone, HomePhone, Address, IdentityID, Email,
                                      Gender, OrderImage, IsActive, EntryBy, EntryDate, LastUpdateBy, LastUpdateDate ) 
                              VALUES 
                                    ('".$custid."', '".$custname."', '".$mobphone."','".$homephone."','".$addres."', '".$identityid."', '".$email."',
                                     '".$gender."', '".$data['file_name']."', 'Y', '".$usernm."', '".$datetm."', '".$usernm."', '".$datetm."') 
                            ");
          }
          //@unlink("./upload/customer/".$ambil_gambar->OrderImage);
        }
      }
      $jeson['status']   = $status;
      $jeson['id']       = $_POST['id'];
      $jeson['msg']      = "Customer Save ".$msg;
      $jeson['notif']    = "Successfuly Saved !!!";
      header('Content-Type: text/html');
      echo json_encode($jeson);
      exit;
    }

    else if (trim($uri) == "delete") {
        $this->db->query("UPDATE  T_CustomerOrder 
                          SET     IsActive        = 'N',
                                  LastUpdateDate  = '".$datetm."',
                                  LastUpdateBy    = '".$usernm."' 
                          WHERE   OrderID         = '".$uri1."'
                        ");

        $ret_arr['status']  = "ok";
        $ret_arr['caption'] = "Delete Success !!!";
        $this->jcode($ret_arr);
        exit();
    }
    else if(trim($uri) == "print"){
      $this->load->model('customer_model');
      $data['title']        = 'Print Customer';
      $data['isi']          = 'customer/customer_print';
      $data['custdata']     = $this->customer_model->ViewGetCustomer()->result();
      $this->load->view('customer/customer_print',$data);
    }
    else if(trim($uri) == "export"){
      $this->load->model('customer_model');
      $data['title']        = 'Export Customer';
      $data['isi']          = 'customer/customer_export';
      $data['custdata']     = $this->customer_model->ViewGetCustomer()->result();
      $data['filenm']       = "Data-Customer";
      $this->load->view('customer/customer_export',$data);
    }
    else{
      $this->load->model('customer_model');
      $data['title']        = 'Data Customer';
      $data['isi']          = 'customer/customer_view';
      $data['custdata']     = $this->customer_model->ViewGetCustomer()->result();
      //$this->load->view('admin/layout/wrapper',$data);
      //view code call ajax
      //$this->load->view('merk/merk_view',$data);
      $this->load->view('customer/customer_view',$data);
    }
	}

  public function jcode($data) {
    header('Content-Type: application/json');
    echo json_encode($data);
  }
  

}