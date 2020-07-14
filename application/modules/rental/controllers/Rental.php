<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Rental extends CI_Controller {

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
	function viewRental(){
    $uri   = $this->uri->segment(3);
    $uri1  = $this->uri->segment(4);
    $uri2  = $this->uri->segment(5);
    $jdeco = json_decode(file_get_contents('php://input'));
	 
    //get date time
    $datetm= date('Y-m-d H:i:s');
    $usernm= $this->session->userdata('nama');

    if(trim($uri) == "view"){
      $qry = $this->db->query("SELECT  A.RentalID, A.OrderID, B.CustomerName, A.CarID, C.CarName,
                                       A.StartDate, A.EndDate, A.RentalCosts, A.PaymentID, A.DriverID, D.DriverName,
                                       A.DriverRentalFee, A.TotalRentalFee, A.Status, A.IsActive, C.DailyRentalFines, 
                                        D.DailyDrivingCosts, C.CarNumber
                               FROM    T_Rental A 
                               INNER   JOIN T_CustomerOrder B ON A.OrderID=B.OrderID
                               INNER   JOIN M_MasterCar C ON A.CarID = C.CarID
                               LEFT    JOIN M_MasterDriver D ON A.DriverID = D.DriverID
                               WHERE   A.RentalID = '$uri1'");
      if ($qry->num_rows() > 0) {
        $res = $qry->row();
        $this->jcode($res);
      }
      else{
        $str["RentalID"]       = "";
        $str["OrderID"]        = "";
        $str["CustomerName"]   = "";
        $str["CarID"]          = "";
        $str["CarName"]        = "";
        $str["StartDate"]      = "";
        $str["EndDate"]        = "";
        $str["RentalCosts"]    = "";
        $str["PaymentID"]      = "";
        $str["DriverID"]       = "";
        $str["DriverName"]     = "";
        $str["DriverRentalFee"]= "";
        $str["Status"]         = "";
        $str["IsActive"]       = "";
        $str["DailyRentalFines"]  = "";
        $str["DailyDrivingCosts"] = "";
        $str["CarNumber"]         = "";
        $this->jcode($str);
      }

      exit();
    }
     else if(trim($uri) == "search"){
        $varbl = $_GET["query"];
        $query = $this->db->query(" SELECT  OrderID, CustomerName, MobilePhone, HomePhone, Address, 
                                            IdentityID, Email, Gender
                                    FROM    T_CustomerOrder
                                    WHERE   IsActive  = 'Y'
                                            AND (CustomerName LIKE '%".$varbl."%' OR OrderID LIKE '%".$varbl."%')
                              ");
         if ($query->num_rows() > 0) {
          $arr = $query->result();
          foreach($arr as $key){
            $data["suggestions"][] = ["value" => $key->OrderID."-".$key->CustomerName, "key" => $key->OrderID, "keynm" => $key->CustomerName];
          }
         }
         else{
          $data["suggestions"][] = ["value" => '', "key" => '', "keynm" => ''];
         }

         $this->jcode($data);
         exit;
    }
    else if(trim($uri) == "searchcar"){
        $varbl = $_GET["query"];
        $query = $this->db->query(" SELECT  CarID, CarName, CarCat, CarNumber, CarSeat, CarBuyYear, MerkID, 
                                            DailyRentalFee, DailyRentalFines, IsActive
                                    FROM    M_MasterCar
                                    WHERE   IsActive  = 'Y'
                                            AND (CarName LIKE '%".$varbl."%' OR CarNumber LIKE '%".$varbl."%')
                              ");
         if ($query->num_rows() > 0) {
          $arr = $query->result();
          foreach($arr as $key){
            $data["suggestions"][] = ["value" => $key->CarNumber."-".$key->CarName, "key" => $key->CarID, "keynm" => $key->CarName, "keyfee" => $key->DailyRentalFee];
          }
         }
         else{
          $data["suggestions"][] = ["value" => '', "key" => '', "keynm" => '',  "keyfee" => ''];
         }

         $this->jcode($data);
         exit;
    }
    else if(trim($uri) == "searchdriver"){
        $varbl = $_GET["query"];
        $query = $this->db->query(" SELECT  DriverID, DriverName, IdentityID, MobilePhone, HomePhone, Email, Address, 
                                            DailyDrivingCosts, IsActive
                                    FROM    M_MasterDriver
                                    WHERE   IsActive  = 'Y'
                                            AND (DriverID LIKE '%".$varbl."%' OR DriverName LIKE '%".$varbl."%')
                              ");
         if ($query->num_rows() > 0) {
          $arr = $query->result();
          foreach($arr as $key){
            $data["suggestions"][] = ["value" => $key->DriverID."-".$key->DriverName, "key" => $key->DriverID, "keynm" => $key->DriverName, "keyfee" => $key->DailyDrivingCosts];
          }
         }
         else{
          $data["suggestions"][] = ["value" => '', "key" => '', "keynm" => '',  "keyfee" => ''];
         }

         $this->jcode($data);
         exit;
    }
    else if (trim($uri) == "save") {

  
      $datetime1 = date_create($_POST['startdate']);
      $datetime2 = date_create($_POST['enddate']);
      $interval  = date_diff($datetime1, $datetime2);
    
      //post file
      $rentid   = $_POST['rentalid'];
      $custid   = $_POST['custid'];
      $carid    = $_POST['carid'];
      $sdate    = $_POST['startdate'];
      $edate    = $_POST['enddate'];
      $rencost  = $_POST['rentalcost'];
      $payid    = $_POST['paymentid'];
      $driverid = $_POST['driverid'];
      $drivercs = 0;//$_POST['drivercost'];
      $total    = $rencost * $interval->format("%a");


      $res = $this->db->query("SELECT RentalID FROM T_Rental WHERE RentalID = '".$_POST['id']."'");
          if ($res->num_rows() == 0) {
            
            $this->db->query("INSERT INTO T_Rental
                                    ( RentalID, OrderID, CarID, StartDate, EndDate, RentalCosts, PaymentID, DriverID, DriverRentalFee,
                                      TotalRentalFee, Status, IsActive, EntryDate, EntryBy, LastUpdateDate, LastUpdateBy  ) 
                              VALUES 
                                    ('".$rentid."', '".$custid."', ".$carid.", '".$sdate."', '".$edate."', ".$rencost.",  ".$payid.", '".$driverid."', ". $drivercs .", 
                                     ".$total.", 1, 'Y', '".$datetm."', '".$usernm."', '".$datetm."', '".$usernm."')  
                            ");
            $msg = "Save";
          }
          else {

            $res = $this->db->query("SELECT Status FROM T_Rental WHERE RentalID = '".$_POST['id']."'")->row();
              if(trim($res->Status) == "5" || trim($res->Status) == "7"){
                  $ret_arr['status']  = "post";
                  $ret_arr['msg']     = "Failed To Change, Data Already Posted !!!";
                  header('Content-Type: text/html');
                  echo json_encode($ret_arr);
                  exit();
              }


            $this->db->query("UPDATE  T_Rental
                                      SET     OrderID         = '".$custid."',
                                              CarID           = '".$carid."',
                                              EndDate         = '".$edate."',
                                              StartDate       = '".$sdate."',
                                              RentalCosts     = '".$rencost."',
                                              PaymentID       = '".$payid."',
                                              DriverID        = '".$driverid."',
                                              DriverRentalFee = '".$drivercs."',
                                              TotalRentalFee  = '".$total."',
                                              IsActive        = 'Y',
                                              LastUpdateDate  = '".$datetm."',
                                              LastUpdateBy    = '".$usernm."'
                                      WHERE   RentalID        = '".$_POST['id']."'
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

    // SELECT RentalID, OrderID, CarID, StartDate, EndDate, RentalCosts,
    // PaymentID, Status, IsActive, EntryDate, EntryBy, LastUpdateDate, LastUpdateBy FROM T_Rental WHERE 1

    else if (trim($uri) == "delete") {
       $res = $this->db->query("SELECT Status FROM T_Rental WHERE RentalID = '".$uri1."'")->row();
        if(trim($res->Status) == "5" || trim($res->Status) == "7"){
            $ret_arr['status']  = "post";
            $ret_arr['caption'] = "Failed To Delete, Data Already Posted !!!";
            $this->jcode($ret_arr);
            exit();
        }
        else
        {
          $this->db->query("UPDATE  T_Rental 
                            SET     IsActive        = 'N',
                                    LastUpdateDate  = '".$datetm."',
                                    LastUpdateBy    = '".$usernm."' 
                            WHERE   RentalID        = '".$uri1."'
                          ");

          $ret_arr['status']  = "ok";
          $ret_arr['caption'] = "Delete Success !!!";
          $this->jcode($ret_arr);
          exit();
        }
    }
     else if (trim($uri) == "post") {
        $res = $this->db->query("SELECT Status FROM T_Rental WHERE RentalID = '".$uri1."'")->row();
        if(trim($res->Status) == "5" || trim($res->Status) == "7"){
            $ret_arr['status']  = "post";
            $ret_arr['caption'] = "Already Posted !!!";
            $this->jcode($ret_arr);
            exit();
        }
        else{
          $this->db->query("UPDATE  T_Rental 
                            SET     Status          = '5',
                                    LastUpdateDate  = '".$datetm."',
                                    LastUpdateBy    = '".$usernm."' 
                            WHERE   RentalID        = '".$uri1."'
                          ");

          $ret_arr['status']  = "ok";
          $ret_arr['caption'] = "Posted Success !!!";
          $this->jcode($ret_arr);
          exit();
        }
    }
    else if(trim($uri) == "export"){
      $this->load->model('rental_model');
      $data['title']        = 'Export Rental Car';
      $data['isi']          = 'rental/rental_export';
      $data['rentaldata']   = $this->rental_model->ViewGetRental()->result();
      $data['filenm']       = "Data-Rental-Car";
      $this->load->view('rental/rental_export',$data);
    }
    else if(trim($uri) == "printinvoice"){

      $qry = $this->db->query("SELECT  A.RentalID, A.OrderID, B.CustomerName, A.CarID, C.CarName,
                                       A.StartDate, A.EndDate, A.RentalCosts, A.PaymentID, A.DriverID, D.DriverName,
                                       A.DriverRentalFee, A.TotalRentalFee, A.Status, A.IsActive, C.DailyRentalFines, 
                                       D.DailyDrivingCosts, C.CarNumber
                               FROM    T_Rental A 
                               INNER   JOIN T_CustomerOrder B ON A.OrderID=B.OrderID
                               INNER   JOIN M_MasterCar C ON A.CarID = C.CarID
                               LEFT    JOIN M_MasterDriver D ON A.DriverID = D.DriverID
                               WHERE   A.RentalID = '$uri1'");
      if ($qry->num_rows() > 0) {
        $res = $qry->result();
      }
      else
      {
        $res = "";
      }


      $this->load->model('rental_model');
      $data['title']        = 'Print Invoice Rental Car';
      $data['isi']          = 'rental/rental_printinvoice';
      $data['rentaldata']   = $res;
      $this->load->view('rental/rental_printinvoice',$data);
    }
    else if(trim($uri) == "print"){
      $this->load->model('rental_model');
      $data['title']        = 'Print Rental Car';
      $data['isi']          = 'rental/rental_print';
      $data['rentaldata']   = $this->rental_model->ViewGetRental()->result();
      $this->load->view('rental/rental_print',$data);
    }
    else{
      $this->load->model('rental_model');
      $data['title']        = 'Rental Car';
      $data['isi']          = 'rental/rental_view';
      $data['rentaldata']   = $this->rental_model->ViewGetRental()->result();
      //$this->load->view('admin/layout/wrapper',$data);
      //view code call ajax
      //$this->load->view('merk/merk_view',$data);
      $this->load->view('rental/rental_view',$data);
    }
	}

  public function jcode($data) {
    header('Content-Type: application/json');
    echo json_encode($data);
  }
  

}