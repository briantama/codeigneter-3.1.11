<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Car extends CI_Controller {

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
	function viewCar(){
    $uri   = $this->uri->segment(3);
    $uri1  = $this->uri->segment(4);
    $uri2  = $this->uri->segment(5);
    $jdeco = json_decode(file_get_contents('php://input'));
	 
    //get date time
    $datetm= date('Y-m-d H:i:s');
    $usernm= $this->session->userdata('nama');

    if(trim($uri) == "view"){
      $qry = $this->db->query("SELECT * FROM M_MasterCar WHERE CarID = '$uri1'");
      if ($qry->num_rows() > 0) {
        $res = $qry->row();
        $this->jcode($res);
      }
      else{
        $str["CarID"]             = "";
        $str["CarName"]           = "";
        $str["CarCat"]            = "";
        $str["CarNumber"]         = "";
        $str["CarSeat"]           = "";
        $str["CarBuyYear"]        = "";
        $str["MerkID"]            = "";
        $str["DailyRentalFee"]    = "";
        $str["DailyRentalFines"]  = "";
        $str["IsActive"]          = "";
        $this->jcode($str);
      }
      exit();
    }
    else if(trim($uri) == "searchmerk"){
        $varbl = $_GET["query"];
        $query = $this->db->query(" SELECT  MerkID, MerkName, IsActive, EntryDate, EntryBy, LastUpdateDate, LastUpdateBy
                                    FROM    M_MasterMerk
                                    WHERE   IsActive  = 'Y'
                                            AND MerkName LIKE '%".$varbl."%'
                              ");
         if ($query->num_rows() > 0) {
          $arr = $query->result();
          foreach($arr as $key){
            $data["suggestions"][] = ["value" => $key->MerkID." - ".$key->MerkName, "key" => $key->MerkID, "keynm" => $key->MerkName];
          }
         }
         else{
          $data["suggestions"][] = ["value" => '', "key" => '', "keynm" => ''];
         }

         $this->jcode($data);
         exit;
    }
    else if (trim($uri) == "save") {
      $status = "";
      $msg    = "";
      $file_element_name = 'userfile';

      //code post 
      $carname    = ucwords(strtolower($_POST['carname']));
      $carcat     = $_POST['carcat'];
      $carnumber  = $_POST['carnumber'];
      $carseat    = $_POST['carseat'];
      $carbuy     = $_POST['carbuy'];
      $merkid     = $_POST['merkid'];
      $dailyfee   = $_POST['dailyfee'];
      $dailyfines = $_POST['dailyfines'];

      if ($status != "error") {
        $config['upload_path']   = './upload/car/';
        $config['allowed_types'] = 'gif|jpg|png';
        $config['max_size']      = 1024;
        $config['encrypt_name']  = FALSE;

        $this->load->library('upload', $config);
        if (!$this->upload->do_upload($file_element_name)) {
          $status = 'ok';
          $msg = $this->upload->display_errors('', '');

          if ($_POST['id'] != "") {
            $this->db->query("UPDATE  M_MasterCar
                                      SET     CarName             = '".$carname."',
                                              CarCat              = '".$carcat."',
                                              CarNumber           = '".$carnumber."',
                                              CarSeat             = '".$carseat."',
                                              CarBuyYear          = '".$carbuy."',
                                              MerkID              = '".$merkid."',
                                              DailyRentalFee      = '".$dailyfee."',
                                              DailyRentalFines    = '".$dailyfines."',
                                              IsActive            = 'Y',
                                              LastUpdateDate      = '".$datetm."',
                                              LastUpdateBy        = '".$usernm."'
                                      WHERE   CarID               = '".$_POST['id']."'");
          } 
          else {

            //notif save error uload image null
            $jeson['status']   = "bad";
            $jeson['msg']      = "Car Image, ".$msg;
            $jeson['focus']    = "userfile";
            header('Content-Type: text/html');
            echo json_encode($jeson);
            exit;

            $this->db->query("INSERT INTO M_MasterCar
                                    (CarName, CarCat, CarNumber, CarSeat, CarBuyYear, MerkID, 
                                     DailyRentalFee, DailyRentalFines, IsActive, EntryDate, EntryBy, LastUpdateDate, LastUpdateBy) 
                              VALUES 
                                    ('".$carname."', '".$carcat."', '".$carnumber."', '".$carseat."','".$carbuy."','".$merkid."', 
                                     '".$dailyfee."', '".$dailyfines."', 'Y', '".$datetm."', '".$usernm."', '".$datetm."', '".$usernm."')
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
          $ambil_gambar = $this->db->query("SELECT CarImage FROM M_MasterCar WHERE CarID = '".$_POST['id']."'")->row();
          if ($_POST['id'] != "") {

            if($ambil_gambar->CarImage != ""){
              if(file_exists("./upload/car/".$ambil_gambar->CarImage)){
                  unlink("./upload/car/".$ambil_gambar->CarImage);
              }
            }

            $this->db->query("UPDATE  M_MasterCar
                                      SET     CarImage            = '".$data['file_name']."', 
                                              CarName             = '".$carname."',
                                              CarCat              = '".$carcat."',
                                              CarNumber           = '".$carnumber."',
                                              CarSeat             = '".$carseat."',
                                              CarBuyYear          = '".$carbuy."',
                                              MerkID              = '".$merkid."',
                                              DailyRentalFee      = '".$dailyfee."',
                                              DailyRentalFines    = '".$dailyfines."',
                                              IsActive            = 'Y',
                                              LastUpdateDate      = '".$datetm."',
                                              LastUpdateBy        = '".$usernm."'
                                      WHERE   CarID               = '".$_POST['id']."'
                            ");
          } else {
            $this->db->query("INSERT INTO M_MasterCar
                                    ( CarName, CarCat, CarNumber, CarSeat, CarBuyYear, CarImage, MerkID, 
                                      DailyRentalFee, DailyRentalFines, IsActive, EntryDate, EntryBy, LastUpdateDate, LastUpdateBy ) 
                              VALUES 
                                    ('".$carname."', '".$carcat."', '".$carnumber."', '".$carseat."','".$carbuy."', '".$data['file_name']."', '".$merkid."', 
                                     '".$dailyfee."', '".$dailyfines."', 'Y', '".$datetm."', '".$usernm."', '".$datetm."', '".$usernm."') 
                            ");
          }
          // /@unlink("./upload/car/".$ambil_gambar->OrderImage);
        }
      }
      $jeson['status']   = $status;
      $jeson['id']       = $_POST['id'];
      $jeson['msg']      = "Car Successfulys Save ".$msg;
      $jeson['notif']    = "Successfuly Saved !!!";
      header('Content-Type: text/html');
      echo json_encode($jeson);
      exit;
    }

    else if (trim($uri) == "delete") {
        $this->db->query("UPDATE  M_MasterCar 
                          SET     IsActive        = 'N',
                                  LastUpdateDate  = '".$datetm."',
                                  LastUpdateBy    = '".$usernm."' 
                          WHERE   CarID           = '".$uri1."'
                        ");

        $ret_arr['status']  = "ok";
        $ret_arr['caption'] = "Delete Success !!!";
        $this->jcode($ret_arr);
        exit();
    }
    else if(trim($uri) == "print"){
      $this->load->model('car_model');
      $data['title']        = 'Report Car';
      $data['isi']          = 'car/car_print';
      $data['cardata']      = $this->car_model->ViewGetCar()->result();
      $this->load->view('car/car_print',$data);
    }
    else if(trim($uri) == "export"){
      $this->load->model('car_model');
      $data['title']        = 'Export Data Car';
      $data['isi']          = 'car/car_export';
      $data['cardata']      = $this->car_model->ViewGetCar()->result();
      $data['filenm']       = "Master-Car";
      $this->load->view('car/car_export',$data);
    }
    else{
      $this->load->model('car_model');
      $data['title']        = 'Master Car';
      $data['isi']          = 'car/car_view';
      $data['cardata']      = $this->car_model->ViewGetCar()->result();
      //$this->load->view('admin/layout/wrapper',$data);
      //view code call ajax
      //$this->load->view('merk/merk_view',$data);
      $this->load->view('car/car_view',$data);
    }
	}

  public function jcode($data) {
    header('Content-Type: application/json');
    echo json_encode($data);
  }
  

}