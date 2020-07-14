<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Reportrent extends CI_Controller {

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
	function viewReportRent(){
    $uri   = $this->uri->segment(3);
    $uri1  = $this->uri->segment(4);
    $uri2  = $this->uri->segment(5);
    $jdeco = json_decode(file_get_contents('php://input'));
	 
    //get date time
    $datetm= date('Y-m-d H:i:s');
    $usernm= $this->session->userdata('nama');

    if(trim($uri) == "view"){

      $keycust   = (trim($_POST['keycustname']) != "") ? "AND A.OrderID = '".$_POST["keycustname"]."'" : "";
      $sdate     = (trim($_POST['startdate']) != "") ? "".$_POST["startdate"]."" : date('Y-m-d');
      $edate     = (trim($_POST['enddate']) != "") ? "".$_POST["enddate"]."" : date('Y-m-d');
      $merkid    = (trim($_POST['keymerkid']) != "") ? "AND C.MerkID = '".$_POST["keymerkid"]."'" : "";
      $drivid    = (trim($_POST['keydriverid']) != "") ? "AND A.DriverID = '".$_POST["keydriverid"]."'" : "";
      $keycar    = (trim($_POST['keycarname']) != "") ? "AND A.CarID = '".$_POST["keycarname"]."'" : "";
      $rentalid  = (trim($_POST['rentalid']) != "") ? "AND MerkID = '".$_POST["rentalid"]."'" : "";
      $status    = (trim($_POST['status']) != "") ? "AND A.Status = '".$_POST["status"]."'" : "";

      $qry = $this->db->query("
                    
                              SELECT   A.RentalID, A.OrderID, B.CustomerName, A.CarID, C.CarName, A.Status, C.CarNumber,
                                       A.StartDate, A.EndDate, A.RentalCosts, A.PaymentID, A.DriverID, D.DriverName, C.DailyRentalFee,
                                       A.DriverRentalFee, A.TotalRentalFee, A.Status, A.IsActive, C.DailyRentalFines, 
                                       D.DailyDrivingCosts, C.CarNumber, E.ReturnDate, E.LateCharge, A.TotalRentalFee
                               FROM    T_Rental A 
                               INNER   JOIN T_CustomerOrder B ON A.OrderID=B.OrderID
                               INNER   JOIN M_MasterCar C ON A.CarID = C.CarID
                               LEFT    JOIN M_MasterDriver D ON A.DriverID = D.DriverID
                               LEFT    JOIN T_Return E ON A.RentalID=E.RentalID
                               INNER   JOIN M_MasterMerk F ON C.MerkID=F.MerkID
                               WHERE   A.IsActive = 'Y'
                                       AND A.StartDate BETWEEN '".$sdate."' AND '".$edate."'
                                       ".$keycust."
                                       ".$merkid."
                                       ".$drivid."
                                       ".$keycar."
                                       ".$rentalid."
                                       ".$status."


                              ");
      if ($qry->num_rows() > 0) {
        $str = $qry->result();
        $startdt = (trim($_POST['startdate']) != "") ? $_POST['startdate'] : "";
        $enddt   = (trim($_POST['enddate']) != "") ? $_POST['enddate'] : "";
        //$this->jcode($res);
      }
      else{
        $str     = "";
        $startdt = "";
        $enddt   = "";
        //$this->jcode($str);
      }

      $this->load->view('reportrent_search', array('keys'=>$str, 'StartDate' => $startdt, 'EndDate' => $enddt ));

    }
    else if(trim($uri) == "searchcustomer"){
        $varbl = $_GET["query"];
        $query = $this->db->query(" SELECT  OrderID, CustomerName, MobilePhone, HomePhone, Address, IdentityID, Email,
                                            Gender, IsActive, EntryBy, EntryDate, LastUpdateBy, LastUpdateDate
                                    FROM    T_CustomerOrder
                                    WHERE   IsActive  = 'Y'
                                            AND CustomerName LIKE '%".$varbl."%'
                              ");
         if ($query->num_rows() > 0) {
          $arr = $query->result();
          foreach($arr as $key){
            $data["suggestions"][] = ["value" => $key->OrderID." - ".$key->CustomerName, "key" => $key->OrderID, "keynm" => $key->CustomerName];
          }
         }
         else{
          $data["suggestions"][] = ["value" => '', "key" => '', "keynm" => ''];
         }

         $this->jcode($data);
         exit;
    }
     else if(trim($uri) == "searchdriver"){
        $varbl = $_GET["query"];
        $query = $this->db->query(" SELECT  DriverID, DriverName, IdentityID, MobilePhone, HomePhone, Email, Address, 
                                            DailyDrivingCosts, IsActive, EntryBy, EntryDate, LastUpdateBy, LastUpdateDate
                                    FROM    M_MasterDriver
                                    WHERE   IsActive  = 'Y'
                                            AND DriverName LIKE '%".$varbl."%'
                              ");
         if ($query->num_rows() > 0) {
          $arr = $query->result();
          foreach($arr as $key){
            $data["suggestions"][] = ["value" => $key->DriverID." - ".$key->DriverName, "key" => $key->DriverID, "keynm" => $key->DriverName];
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
                                            AND CarName LIKE '%".$varbl."%'
                              ");
         if ($query->num_rows() > 0) {
          $arr = $query->result();
          foreach($arr as $key){
            $data["suggestions"][] = ["value" => $key->CarNumber." - ".$key->CarName, "key" => $key->CarID, "keynm" => $key->CarName, "keyfee" => $key->DailyRentalFee];
          }
         }
         else{
          $data["suggestions"][] = ["value" => '', "key" => '', "keynm" => '',  "keyfee" => ''];
         }

         $this->jcode($data);
         exit;
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
    else if(trim($uri) == "print" ){
      $this->load->model('Reportrent_model');
      $data['title']        = 'Print Rental Car';
      $data['isi']          = 'reportrent/reportrent_print';
      $data['keys']         = unserialize(urldecode($uri1));
      $data["StartDate"]    = $_GET['StartDate'];
      $data["EndDate"]      = $_GET['EndDate'];
      $this->load->view('reportrent/reportrent_print',$data);
    }
    else if(trim($uri) == "export" ){
      $this->load->model('Reportrent_model');
      $data['title']        = 'Export Rental Car';
      $data['isi']          = 'reportrent/reportrent_export';
      $data['keys']         = unserialize(urldecode($uri1));
      $data["StartDate"]    = $_GET['StartDate'];
      $data["EndDate"]      = $_GET['EndDate'];
      $data["filenm"]       = "Report-Rental-Car";
      $this->load->view('reportrent/reportrent_export',$data);
    }
    else{
      $this->load->model('Reportrent_model');
      $data['title']        = 'Report Rent';
      $data['isi']          = 'reportrent/reportrent_view';
      $data['cardata']      = $this->Reportrent_model->ViewGetReportRent()->result();
      $data['str']          = "";
      //$this->load->view('admin/layout/wrapper',$data);
      //view code call ajax
      //$this->load->view('merk/merk_view',$data);
      $this->load->view('reportrent/reportrent_view',$data);
    }
	}

  public function jcode($data) {
    header('Content-Type: application/json');
    echo json_encode($data);
  }


}