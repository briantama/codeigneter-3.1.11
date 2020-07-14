 <?php

    $img = "";
    $query = $this->db->query(" SELECT  AdminImage 
                                FROM    M_User
                                WHERE   UserName ='".$this->session->userdata('nama')."'
                                      ");
    if ($query->num_rows() > 0) {
      $arr = $query->first_row();
      $img = $arr->AdminImage;
               //echo $doc;
    }

      $urlimg = (trim($img) == "") ? "default.jpeg" : $img;
      $locate = "./upload/user/".$urlimg;
      if(file_exists($locate)){
        $image = base_url()."upload/user/".$urlimg;
      }
      else{
        $image = base_url()."upload/user/default.jpeg";
      }



  $img   = "default.jpeg";
  $stpnm = "Rent Car";
  $query = $this->db->query(" SELECT SetupImage, SetupTitle
                              FROM   M_Setupprofile
                            ");
  if ($query->num_rows() > 0) {
      $arr   = $query->row();
      $img   = (trim($arr->SetupImage) != "") ? $arr->SetupImage : "default.jpeg";
      $stpnm = $arr->SetupTitle;
  }

  $uimage = "./upload/profile/".$img;

  if(file_exists($uimage)){
      $urlimage = base_url()."upload/profile/".$img;
    }
    else{
      $urlimage = base_url()."upload/profile/default.jpeg";
    }

?>

<!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="<?php echo base_url()."dasbor"; ?>" class="brand-link">
      <img src="<?php echo $urlimage; ?>"  class="brand-image img-circle elevation-3"
           style="opacity: .8">
      <span class="brand-text font-weight-light"><?php echo $stpnm; ?> </span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="<?php echo $image; ?>" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a style="cursor:pointer;" onclick="callpage('profile/viewProfile', '', '')" class="d-block"><?php echo $this->session->userdata('nama'); ?></a>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
         <a href="#"><li onclick="callpage('dasbor/dasbor_page','','');" id="dasbor" class="nav-header">Dashboard </li></a>

          <li class="nav-header">Master Data <span class="badge badge-info right">3</span></li>
          <li class="nav-item" onclick="callpage('merk/viewMerk', 'master-merk', '')">
            <a class="nav-link" id="master-merk" style="cursor:pointer;">
              <i class="nav-icon fas fa-tags"></i>
              <p>
                Master Merk
              </p>
            </a>
          </li>
          <li class="nav-item" onclick="callpage('car/viewCar', 'master-mobil', '')">
            <a class="nav-link" id="master-mobil" style="cursor:pointer;">
              <i class="nav-icon fas fa-car-side"></i>
              <p>
                Master Mobil
              </p>
            </a>
          </li>
          <li class="nav-item" onclick="callpage('driver/viewDriver', 'master-driver', '')">
            <a class="nav-link" id="master-driver" style="cursor:pointer;">
              <i class="nav-icon fas fa-car"></i>
              <p>
                Master Driver
              </p>
            </a>
          </li>
          
          <!-- <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
              <i class="nav-icon far fa-plus-square"></i>
              <p>
                Extras
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="pages/examples/blank.html" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Blank Page</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="starter.html" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Starter Page</p>
                </a>
              </li>
            </ul>
          </li> -->
          <li class="nav-header">Master Transaction <span class="badge badge-info right">2</span></li>
          <li class="nav-item" onclick="callpage('customer/viewCustomer', 'customer', '')">
            <a class="nav-link" id="customer" style="cursor:pointer;">
              <i class="nav-icon fas fa-file"></i>
              <p>Customer</p>
            </a>
          </li>
          <li class="nav-item" onclick="callpage('paymenttype/viewPaymenttype', 'paymenttype', '')">
            <a class="nav-link" id="paymenttype" style="cursor:pointer;">
              <i class="nav-icon fas fa-file"></i>
              <p>PaymentType</p>
            </a>
          </li>
          <li class="nav-header">Transaction <span class="badge badge-info right">2</span></li>
          <li class="nav-item" onclick="callpage('rental/viewRental', 'rentaldata', '')">
            <a class="nav-link" id="rentaldata" style="cursor:pointer;">
              <i class="fas fa-circle nav-icon"></i>
              <p>Rental Data</p>
            </a>
          </li>
          <li class="nav-item" onclick="callpage('returncar/viewReturn', 'returndata', '')">
            <a class="nav-link" id="returndata" style="cursor:pointer;">
              <i class="fas fa-circle nav-icon"></i>
              <p>Return Data</p>
            </a>
          </li>
          <li class="nav-header">Report <span class="badge badge-info right">3</span></li>
          <!-- <li class="nav-item" onclick="callpage('reportcar/viewReportCar', '', '')">
            <a class="nav-link" style="cursor:pointer;">
              <i class="nav-icon far fa-circle text-danger"></i>
              <p class="text">Customer</p>
            </a>
          </li> -->
          <li class="nav-item" onclick="callpage('reportrent/viewReportRent', 'reportrent', '')">
            <a class="nav-link" id="reportrent" style="cursor:pointer;">
              <i class="nav-icon far fa-circle text-warning"></i>
              <p>Rent Car</p>
            </a>
          </li>
          <li class="nav-item" onclick="callpage('reportcar/viewReportCar', 'reportcar', '')">
            <a class="nav-link" id="reportcar" style="cursor:pointer;">
              <i class="nav-icon far fa-circle text-info"></i>
              <p>Stock Car</p>
            </a>
          </li>
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>