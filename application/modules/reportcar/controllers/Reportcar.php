<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Reportcar extends CI_Controller {

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
	function viewReportCar(){
    $uri   = $this->uri->segment(3);
    $uri1  = $this->uri->segment(4);
    $uri2  = $this->uri->segment(5);
    $jdeco = json_decode(file_get_contents('php://input'));
	 
    //get date time
    $datetm= date('Y-m-d H:i:s');
    $usernm= $this->session->userdata('nama');
    $this->load->helper('my_helper');

    if(trim($uri) == "view"){

      $carname   = (trim($_POST['keycarname']) != "") ? "AND CarID = '".$_POST["carname"]."'" : "";
      $effdate   = (trim($_POST['effdate']) != "") ? "".$_POST["effdate"]."" : date('Y-m-d');
      $merkid    = (trim($_POST['keymerkid']) != "") ? "AND MerkID = '".$_POST["keymerkid"]."'" : "";

      $qry = $this->db->query("
                    
                              SELECT CarID, CarName, CarBuyYear, MerkID, MerkName, EndDate, BackDate, Status, CarNumber, CarCat, DailyRentalFee
                              FROM (

                              SELECT  X.CarID, X.CarName, X.CarBuyYear, X.MerkID, Z.MerkName,V.EndDate, X.CarNumber, X.CarCat, X.DailyRentalFee,
                                  CASE  WHEN V.BackDate <> '' THEN V.BackDate 
                                      WHEN (V.BackDate IS NULL OR V.BackDate = '') THEN '".$effdate."'
                                      ELSE V.BackDate END AS BackDate,
                                      CASE  WHEN BackDate <> '' THEN 'Ongoing'
                                              ELSE 'Available' END AS Status
                              FROM    M_MasterCar X
                              INNER   JOIN M_MasterMerk Z ON X.MerkID=Z.MerkID
                              LEFT    JOIN (
                                              SELECT  A.CarID,  CASE 
                                                      WHEN  B.ReturnDate <> '' THEN B.ReturnDate
                                                              WHEN B.ReturnDate = ''  THEN A.EndDate
                                                              ELSE A.EndDate END AS BackDate, EndDate
                                              FROM    T_Rental A
                                              LEFT    JOIN T_Return B ON A.RentalID=B.RentalID
                                              WHERE   A.Status <> '7'
                                          ) V ON X.CarID = V.CarID
                              WHERE   X.IsActive = 'Y'

                                  ) SB
                                  
                              WHERE BackDate >= '".$effdate."'
                                    ".$carname."
                                    ".$merkid."

                              ");
      if ($qry->num_rows() > 0) {
        $str = $qry->result();
        //$this->jcode($res);
      }
      else{
        $str = "";
        //$this->jcode($str);
      }

      $this->load->view('reportcar/reportcar_search', array('keys'=>$str, 'effdate'=> $effdate ));

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
      $this->load->model('Reportcar_model');
      $data['title']        = 'Print Stock Car';
      $data['isi']          = 'reportcar/reportcar_print';
      $data['keys']         = unserialize(urldecode($uri1));
      $data["effdate"]      = $_GET['effdate'];
      $this->load->view('reportcar/reportcar_print',$data);
    }
    else if(trim($uri) == "export" ){
      $this->load->model('Reportcar_model');
      $data['title']        = 'Export Stock Car';
      $data['isi']          = 'reportcar/reportcar_export';
      $data['keys']         = unserialize(urldecode($uri1));
      $data["effdate"]      = $_GET['effdate'];
      $data["filenm"]       = "Report-Stock-Car";
      $this->load->view('reportcar/reportcar_export',$data);
    }
    else{
      $this->load->model('Reportcar_model');
      $data['title']        = 'Report Stock Car';
      $data['isi']          = 'reportcar/reportcar_view';
      $data['cardata']      = $this->Reportcar_model->ViewGetReportCar()->result();
      $data['str']          = "";
      //$this->load->view('admin/layout/wrapper',$data);
      //view code call ajax
      //$this->load->view('merk/merk_view',$data);
      $this->load->view('reportcar/reportcar_view',$data);
    }
	}

  public function jcode($data) {
    header('Content-Type: application/json');
    echo json_encode($data);
  }


}