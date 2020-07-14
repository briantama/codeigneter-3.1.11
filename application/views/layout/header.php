<?php

  $img   = "default.jpeg";
  $stpnm = "Aplikasi Rental Car Bryn";
  $query = $this->db->query(" SELECT SetupImageLogo, SetupName
                              FROM   M_Setupprofile
                            ");
  if ($query->num_rows() > 0) {
      $arr   = $query->row();
      $img   = (trim($arr->SetupImageLogo) != "") ? $arr->SetupImageLogo : "default.jpeg";
      $stpnm = $arr->SetupName;
  }

  $image = "./upload/logo/".$img;

  if(file_exists($image)){
      $image = base_url()."upload/logo/".$img;
    }
    else{
      $image = base_url()."upload/logo/default.jpeg";
    }

?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv="x-ua-compatible" content="ie=edge">

  <title><?php echo $stpnm; ?></title>
  <link rel="shortcut icon" href="<?php echo $image; ?>">

  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>AdminLTE3/plugins/fontawesome-free/css/all.min.css">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>AdminLTE3/plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
   <!-- DataTables -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>AdminLTE3/plugins/datatables-bs4/css/dataTables.bootstrap4.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>AdminLTE3/dist/css/adminlte.min.css">
  <link rel="stylesheet" href="<?php echo base_url(); ?>AdminLTE3/css/style.css">
  <link rel="stylesheet" href="<?php echo base_url(); ?>AdminLTE3/css/animate.css">
  <!-- datepicker-->
  <link href="<?php echo base_url(); ?>AdminLTE3/js/bootstrap-datepicker.min.css" rel="stylesheet">

  <script src="<?php echo base_url(); ?>AdminLTE3/js/jquery-1.11.3.min.js"></script>
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">

  <style type="text/css">
    .shownotifmsg {
      position:fixed;
      bottom:70%;
      right:2px;
      float:right;
      z-index:103;
    }
  </style>

</head>
<body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">
<div class="wrapper">
  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a>
      </li>
      <!-- <li class="nav-item d-none d-sm-inline-block">
        <a href="index3.html" class="nav-link">Home</a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="#" class="nav-link">Contact</a>
      </li> -->
    </ul>

    <!-- SEARCH FORM -->
    <form class="form-inline ml-3">
      <div class="input-group input-group-sm">
        <input class="form-control form-control-navbar" type="search" placeholder="Search Menu" id="menuid" name="menuid" aria-label="Search">
        <div class="input-group-append">
          <button class="btn btn-navbar" type="submit">
            <i class="fas fa-search"></i>
          </button>
        </div>
      </div>
    </form>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      <!-- Messages Dropdown Menu -->
      

      <!-- Notifications Dropdown Menu -->
      <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#" title="Setting">
          <i class="fas fa-cogs"></i>
          <span class="badge badge-warning navbar-badge">4</span>
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
         <!--  <span class="dropdown-item dropdown-header">15 Notifications</span> -->
          <div class="dropdown-divider"></div>
          <a style="cursor:pointer;" onclick="callpage('profile/viewProfile', '', '')" class="dropdown-item">
            <i class="fas fa-user mr-2"></i> Profile
            <!-- <span class="float-right text-muted text-sm">3 mins</span> -->
          </a>
          <div class="dropdown-divider"></div>
          <a style="cursor:pointer;" onclick="callpage('user/viewUser', '', '')" class="dropdown-item">
            <i class="fas fa-users mr-2"></i> User
            <!-- <span class="float-right text-muted text-sm">3 mins</span> -->
          </a>
          <div class="dropdown-divider"></div>
           <a style="cursor:pointer;" onclick="callpage('setupprofile/viewSetupProfile', '', '')" class="dropdown-item">
            <i class="fas fa-cogs mr-2"></i> Setup Profile
            <!-- <span class="float-right text-muted text-sm">3 mins</span> -->
          </a>
          <div class="dropdown-divider"></div>
           <a style="cursor:pointer;" onclick="callpage('setuplogo/viewSetupLogo', '', '')" class="dropdown-item">
            <i class="fas fa-cogs mr-2"></i> Setup Logo
            <!-- <span class="float-right text-muted text-sm">3 mins</span> -->
          </a>
         <!--  <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <i class="fas fa-file mr-2"></i> 3 new reports
            <span class="float-right text-muted text-sm">2 days</span>
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item dropdown-footer">See All Notifications</a>
        </div> -->
      </li>

      <!--logout-->
       <li class="nav-item">
        <a href="<?php echo base_url('login/logout'); ?>" title="Logout" class="nav-link"><i
            class="fas fa-sign-out-alt"></i></a>
      </li>

      <li class="nav-item">
        <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#"><i
            class="fas fa-th-large"></i></a>
      </li>
    </ul>
  </nav>
  <!-- /.navbar -->


  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->


  <script type="text/javascript">
  $(document).ready ( function(){
   var menu = [
            { value: 'Master Merk', data: 'merk/viewMerk' ,clsp: '', nvitem: ''},
            { value: 'Master Car ', data: 'car/viewCar' ,clsp: '', nvitem: ''},
            { value: 'Master Driver', data: 'driver/viewDriver' ,clsp: '', nvitem: ''},
            { value: 'Customer', data: 'customer/viewCustomer' ,clsp: '', nvitem: ''},
            { value: 'Payment Type', data: 'paymenttype/viewPaymenttype' ,clsp: '', nvitem: ''},
            { value: 'Rental Data', data: 'rental/viewRental' ,clsp: '', nvitem: ''},
            { value: 'Return Data', data: 'returncar/viewReturn' ,clsp: '', nvitem: ''},
            { value: 'Rent Car', data: 'reportrent/viewReportRent' ,clsp: '', nvitem: ''},
            { value: 'Data Car', data: 'reportcar/viewReportCar' ,clsp: '', nvitem: ''},
            { value: 'Data User', data: 'user/viewUser' ,clsp: '', nvitem: ''},
            { value: 'Data Profile', data: 'profile/viewProfile' ,clsp: '', nvitem: ''},
        ];

    // Selector input yang akan menampilkan autocomplete.
    $( "#menuid" ).autocomplete({
      lookup: menu,
        onSelect: function (suggestion) {
      $('#menuid').val(suggestion.value);
      callpage(suggestion.data, suggestion.clsp, suggestion.nvitem);
      
    }
    });

  });
</script>