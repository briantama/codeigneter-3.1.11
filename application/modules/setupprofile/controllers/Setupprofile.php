<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Setupprofile extends CI_Controller {

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


  public function viewSetupProfile() {

    $uri   = $this->uri->segment(3);
    $uri1  = $this->uri->segment(4);
    $uri2  = $this->uri->segment(5);
    $jdeco = json_decode(file_get_contents('php://input'));
   
    //get library
    $datetm     = date('Y-m-d H:i:s');
    $usernm     = $this->session->userdata('nama');

    if (trim($uri) == "save") {
      $status = "";
      $msg    = "";
      $file_element_name = 'userfile';

      //code post 
      $stpidx    = $_POST['stpidx'];
      $stpname   = $_POST['stpname'];
      $stptitle  = $_POST['stptitle'];
      $stpdesc   = $_POST['stpdesc'];

      if ($status != "error") {
        $config['upload_path']   = './upload/profile/';
        $config['allowed_types'] = 'gif|jpg|png';
        $config['max_size']      = 1024;
        $config['encrypt_name']  = FALSE;

        $this->load->library('upload', $config);
        if (!$this->upload->do_upload($file_element_name)) {
          $status = 'ok';
          $msg = $this->upload->display_errors('', '');

          $cek = $this->db->query("SELECT  SetupprofileID FROM M_Setupprofile WHERE SetupprofileID = ".$_POST['stpidx']."");
          if ($cek->num_rows() > 0) {

            $this->db->query("UPDATE  M_Setupprofile
                                      SET     SetupTitle          = '".$stptitle."',
                                              SetupName           = '".$stpname."',
                                              SetupDescription    = '".$stpdesc."',
                                              IsActive            = 'Y',
                                              LastUpdateDate      = '".$datetm."',
                                              LastUpdateBy        = '".$usernm."'
                                      WHERE   SetupprofileID      = ".$_POST['stpidx']."");
          } 
          else {

            //notif save error uload image null
            $jeson['status']   = "bad";
            $jeson['msg']      = "Profile Image, ".$msg;
            $jeson['focus']    = "userfile";
            header('Content-Type: text/html');
            echo json_encode($jeson);
            exit;

           
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
          $ambil_gambar = $this->db->query("SELECT SetupImage, SetupprofileID FROM M_Setupprofile WHERE SetupprofileID = ".$_POST['stpidx']."");
          if ($ambil_gambar->num_rows() > 0) {

            $rows = $ambil_gambar->row();
            if($rows->SetupImage != ""){
              if(file_exists("./upload/profile/".$rows->SetupImage)){
                unlink("./upload/profile/".$rows->SetupImage);
              }
            }

            $this->db->query("UPDATE  M_Setupprofile
                                      SET     SetupImage          = '".$data['file_name']."', 
                                              SetupTitle          = '".$stptitle."',
                                              SetupName           = '".$stpname."',
                                              SetupDescription    = '".$stpdesc."',
                                              IsActive            = 'Y',
                                              LastUpdateDate      = '".$datetm."',
                                              LastUpdateBy        = '".$usernm."'
                                      WHERE   SetupprofileID      = ".$_POST['stpidx']."
                            ");

          } 
          else {
            $this->db->query("INSERT INTO M_Setupprofile
                                    ( SetupTitle, SetupName, SetupDescription, SetupImage, 
                                     IsActive, EntryBy, EntryDate, LastUpdateBy, LastUpdateDate) 
                              VALUES 
                                    ('".$stptitle."', '".$stpname."', '".$stpdesc."','".$data['file_name']."', 
                                     'Y', '".$usernm."', '".$datetm."', '".$usernm."', '".$datetm."') 
                            ");
          }
          
        }
      }
      $jeson['status']   = $status;
      $jeson['id']       = $_POST['stpidx'];
      $jeson['msg']      = "Setup Profile Save ".$msg;
      $jeson['notif']    = "Successfuly Saved !!!";
      header('Content-Type: text/html');
      echo json_encode($jeson);
      exit;
    }
    else{
      $this->load->model('Setupprofile_model');
      $data['titlex']       = "Data Setupprofile";
      $data['isi']          = 'setupprofile/Setupprofile_view';
      $data['stpdata']      = $this->Setupprofile_model->ViewGetSetupprofile()->result();
      $this->load->view('setupprofile/Setupprofile_view',$data);
    }

  }

  public function jcode($data) {
    header('Content-Type: application/json');
    echo json_encode($data);
  }
  

}