<?php

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

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title><?= $title; ?></title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?= base_url(); ?>AdminLTE3/plugins/fontawesome-free/css/all.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="<?= base_url(); ?>AdminLTE3/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?= base_url(); ?>AdminLTE3/dist/css/adminlte.min.css">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
</head>
<body class="hold-transition login-page">
<div class="login-box">
  <div class="login-logo">
    <img src="<?php echo $urlimage; ?>" width="120" height="120">
    <br>
    <a href="#"><b><?php echo $stpnm; ?></a>
  </div>
  <!-- /.login-logo -->
  <div class="card">
    <div class="card-body login-card-body">
      <p class="login-box-msg">Sign in to start your session</p>

      <!-- notif login-->
      <div id="notif"></div>
      <div id="konfirmasi"></div>

       <form class="user" method="POST" action="" id="f_login">
        <div class="input-group mb-3">
          <input type="text" id="username" name="username" class="form-control" placeholder="Username : brian">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-envelope"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="password" id="password" name="password" class="form-control" placeholder="password : brian">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-8">
            <div class="icheck-primary">
              <input type="checkbox" id="remember">
              <label for="remember">
                Remember Me
              </label>
            </div>
          </div>
          <!-- /.col -->
          <div class="col-4">
            <button class="btn btn-primary btn-block btn-flat" type="submit">Log In</button>
          </div>
          <!-- /.col -->
        </div>
      </form>


      <p class="mb-1">
        <a href="#">I forgot my password</a>
      </p>
    </div>
    <!-- /.login-card-body -->
  </div>
  <p class="login-box-msg">Copyright &copy; Apps Bryn 2017 - <?php echo date('Y'); ?> Template By Admin LTE</p>
</div>
<!-- /.login-box -->

<!-- jQuery -->
<script src="<?= base_url(); ?>AdminLTE3/plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="<?= base_url(); ?>AdminLTE3/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="<?= base_url(); ?>AdminLTE3/dist/js/adminlte.min.js"></script>


<script type="text/javascript">
  // $(window).load(function() 
  //   { $("#loadlogin").fadeOut("slow");});

   $("#username").focus();

  

  $("#f_login").submit(function(event) {
    event.preventDefault();
    var data  = $('#f_login').serialize();
    var user  = $("#username").val();
    var pswd  = $("#password").val();
    if(user == ""){
            $("#notif").show();
            $("#notif").fadeIn(400).html('<div class="load alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>Please Insert Username..</div>');
            $("#notif" ).delay(3000).hide(2000);
            $("#username").focus();
    }
    else if(pswd == ""){
            $("#notif").show();
            $("#notif").fadeIn(400).html('<div class="load alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>Please Insert Password..</div>');
            $("#notif" ).delay(3000).hide(2000);
            $("#password").focus();
    }
    else{
      $("#konfirmasi").html("<div class='alert alert-info'><img src='<?= base_url(); ?>/AdminLTE3/images/load.gif' width='50' height='50'> Checking...</div>")
      $.ajax({
        type: "POST",
        data: data,
        url: "<?= base_URL(); ?>login/getlogin",
        success: function(r) {
          if (r.log.status == 0) {
            $("#konfirmasi").html("<div class='alert alert-danger'><i class='nav-icon fas fa-info'></i> "+r.log.keterangan+"</div>");
            $("#konfirmasi" ).delay(3000).hide(2000);
            $("#username").val("");
            $("#password").val("");
            $("#username").focus();
          } else {
            $("#konfirmasi").html("<div class='alert alert-success'><i class='nav-icon fas fa-check'></i> "+r.log.keterangan+"</div>");
            window.location.assign("<?= base_url(); ?>dasbor"); 
          }
        }
      });
    }
  });
</script>

</body>


</body>
</html>
