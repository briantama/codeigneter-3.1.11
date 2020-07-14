<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Returncar extends CI_Controller {

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
	function viewReturn(){
    $uri   = $this->uri->segment(3);
    $uri1  = $this->uri->segment(4);
    $uri2  = $this->uri->segment(5);
    $jdeco = json_decode(file_get_contents('php://input'));
	 
    //get date time
    $datetm= date('Y-m-d H:i:s');
    $usernm= $this->session->userdata('nama');

    if(trim($uri) == "view"){
      $qry = $this->db->query("
                                SELECT  A.ReturnID, A.RentalID, A.ReturnDate, A.LateCharge,
                                        C.CustomerName, B.CarID, D.CarName,
                                        B.StartDate, B.EndDate, B.RentalCosts, B.PaymentID, B.DriverID, E.DriverName,
                                        B.DriverRentalFee, B.TotalRentalFee, B.Status, A.IsActive, D.DailyRentalFines, 
                                        E.DailyDrivingCosts, D.CarNumber
                                FROM    T_Return A
                                INNER   JOIN T_Rental B ON A.RentalID = B.RentalID
                                INNER   JOIN T_CustomerOrder C ON B.OrderID=C.OrderID
                                INNER   JOIN M_MasterCar D ON B.CarID = D.CarID
                                LEFT    JOIN M_MasterDriver E ON B.DriverID = E.DriverID
                                WHERE   A.ReturnID = '".$uri1."'

                              ");
      if ($qry->num_rows() > 0) {
        $res = $qry->row();
        $this->jcode($res);
      }
      else{
        $str["ReturnID"]          = "";
        $str["RentalID"]          = "";
        $str["ReturnDate"]        = "";
        $str["LateCharge"]        = "";
        $str["IsActive"]          = "";

        $str["CustomerName"]      = "";
        $str["CarID"]             = "";
        $str["CarName"]           = "";
        $str["StartDate"]         = "";
        $str["EndDate"]           = "";
        $str["DriverID"]          = "";
        $str["DailyRentalFines"]  = "";
        $str["DailyDrivingCosts"] = "";
        $str["CarNumber"]         = "";

        $this->jcode($str);

         // SELECT ReturnID, RentalID, ReturnDate, LateCharge, 
         //          IsActive, EntryBy, EntryDate, LastUpdateBy, LastUpdateDate FROM T_Return WHERE 1
      }

      exit();
    }
    else if(trim($uri) == "search"){
        $varbl = $_GET["query"];
        $query = $this->db->query("  SELECT  A.RentalID, A.OrderID, B.CustomerName, A.CarID, C.CarName,
                                             A.StartDate, A.EndDate, A.RentalCosts, A.PaymentID, A.DriverID, D.DriverName,
                                             A.DriverRentalFee, A.TotalRentalFee, A.Status, A.IsActive
                                     FROM    T_Rental A 
                                     INNER   JOIN T_CustomerOrder B ON A.OrderID=B.OrderID
                                     INNER   JOIN M_MasterCar C ON A.CarID = C.CarID
                                     LEFT    JOIN M_MasterDriver D ON A.DriverID = D.DriverID
                                     WHERE   A.IsActive = 'Y'
                                             AND A.Status = '5'
                                             AND A.RentalID  NOT IN (SELECT RentalID FROM T_Return WHERE Status <> '7' AND IsActive ='Y')
                                             AND (RentalID LIKE '%".$varbl."%' OR CustomerName LIKE '%".$varbl."%')
                              ");
         if ($query->num_rows() > 0) {
          $arr = $query->result();
          foreach($arr as $key){
            $data["suggestions"][] = ["value" => $key->RentalID."-".$key->CustomerName, "key" => $key->RentalID, "keynm" => $key->CustomerName];
          }
         }
         else{
          $data["suggestions"][] = ["value" => '', "key" => '', "keynm" => ''];
         }

         $this->jcode($data);
         exit;
    }
    else if (trim($uri) == "save") {

      //post file
      $returnid   = $_POST['returnid'];
      $rentalid   = $_POST['rentalid'];
      $returndate = $_POST['returndate'];
      $latecharge = (trim($_POST['latecharge']) == "") ? 0 : $_POST['latecharge'];

      $res = $this->db->query("SELECT RentalID FROM T_Return WHERE ReturnID = '".$_POST['id']."'");
          if ($res->num_rows() == 0) {
            
            $this->db->query("INSERT INTO T_Return
                                    ( ReturnID, RentalID, ReturnDate, LateCharge, Status,
                                      IsActive, EntryBy, EntryDate, LastUpdateBy, LastUpdateDate  ) 
                              VALUES 
                                    ('".$returnid."', '".$rentalid."', '".$returndate."', ".$latecharge.", '5',
                                     'Y', '".$usernm."', '".$datetm."', '".$usernm."', '".$datetm."')  
                            ");
            $msg = "Save";
          }
          else {

            $res = $this->db->query("SELECT Status FROM T_Return WHERE ReturnID = '".$_POST['id']."'")->row();
              if(trim($res->Status) == "7"){
                  $ret_arr['status']  = "post";
                  $ret_arr['msg']     = "Failed To Change, Record Already Posted !!!";
                  header('Content-Type: text/html');
                  echo json_encode($ret_arr);
                  exit();
              }

            $this->db->query("UPDATE  T_Return
                                      SET     RentalID        = '".$rentalid."',
                                              ReturnDate      = '".$returndate."',
                                              LateCharge      = ".$latecharge.",
                                              IsActive        = 'Y',
                                              Status          = '5',
                                              LastUpdateDate  = '".$datetm."',
                                              LastUpdateBy    = '".$usernm."'
                                      WHERE   ReturnID        = '".$_POST['id']."'
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
    else if (trim($uri) == "post") {
        $res = $this->db->query("SELECT Status, RentalID FROM T_Return WHERE ReturnID = '".$uri1."'")->row();
        if(trim($res->Status) == "7"){
            $ret_arr['status']  = "post";
            $ret_arr['caption'] = "Already Posted !!!";
            $this->jcode($ret_arr);
            exit();
        }
        else{
          $this->db->query("UPDATE  T_Return 
                            SET     Status          = '7',
                                    LastUpdateDate  = '".$datetm."',
                                    LastUpdateBy    = '".$usernm."' 
                            WHERE   ReturnID        = '".$uri1."'
                          ");

          //update status finish
          $this->db->query("UPDATE  T_Rental 
                            SET     Status          = '7',
                                    LastUpdateDate  = '".$datetm."',
                                    LastUpdateBy    = '".$usernm."' 
                            WHERE   RentalID        = '".$res->RentalID."'
                          ");

          $ret_arr['status']  = "ok";
          $ret_arr['caption'] = "Posted Success !!!";
          $this->jcode($ret_arr);
          exit();
        }
    }

    else if (trim($uri) == "delete") {
         $res = $this->db->query("SELECT Status FROM T_Return WHERE ReturnID = '".$uri1."'")->row();
        if(trim($res->Status) == "7"){
            $ret_arr['status']  = "post";
            $ret_arr['caption'] = "Failed To Delete, Record Already Posted !!!";
            $this->jcode($ret_arr);
            exit();
        }
        else{

          $this->db->query("UPDATE  T_Return 
                            SET     IsActive        = 'N',
                                    LastUpdateDate  = '".$datetm."',
                                    LastUpdateBy    = '".$usernm."' 
                            WHERE   ReturnID        = '".$uri1."'
                          ");

          $ret_arr['status']  = "ok";
          $ret_arr['caption'] = "Delete Success !!!";
          $this->jcode($ret_arr);
          exit();
        }
    }
    elseif(trim($uri) == "export"){
      $this->load->model('return_model');
      $data['title']        = 'Export Return Car';
      $data['isi']          = 'returncar/return_export';
      $data['retrundata']   = $this->return_model->ViewGetReturn()->result();
      $data['filenm']       = "Data-Return-Car";
      $this->load->view('returncar/return_export',$data);
    }
    elseif(trim($uri) == "print"){
      $this->load->model('return_model');
      $data['title']        = 'Print Return Car';
      $data['isi']          = 'returncar/return_print';
      $data['retrundata']   = $this->return_model->ViewGetReturn()->result();
      $this->load->view('returncar/return_print',$data);
    }
    else{
      $this->load->model('return_model');
      $data['title']        = 'Return Car';
      $data['isi']          = 'returncar/return_view';
      $data['retrundata']   = $this->return_model->ViewGetReturn()->result();
      $this->load->view('returncar/return_view',$data);
    }
	}

  public function jcode($data) {
    header('Content-Type: application/json');
    echo json_encode($data);
  }
  

}