 <!-- Content Wrapper. Contains page content -->

<?php

  foreach($dataAdmin as $value){
    $name    = $value->AdminName;
    $usernm  = $value->UserName;
    $email   = $value->email;
    $hbd     = $value->DateOfBirth;
    $spur    = $value->SuperUser;
    $img     = $value->AdminImage;
  }

   $urlimg = (trim($img) == "") ? "default.jpeg" : $img;
   $locate = "./upload/user/".$urlimg;


    if(file_exists($locate)){
      $image = base_url()."upload/user/".$urlimg;
    }
    else{
      $image = base_url()."upload/user/default.jpeg";
    }


?>

  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1><?php echo $title; ?></h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">User Profile</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content animated zoomInRight">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-3">

            <!-- Profile Image -->
            <div class="card card-primary card-outline">
              <div class="card-body box-profile">
                <div class="text-center">
                  <img class="profile-user-img img-fluid img-circle"
                       src="<?php echo $image; ?>"
                       alt="User profile picture">
                </div>

                <h3 class="profile-username text-center"><?php echo $usernm; ?></h3>

                <p class="text-muted text-center">Staff Admin</p>

                <!-- <ul class="list-group list-group-unbordered mb-3">
                  <li class="list-group-item">
                    <b>Followers</b> <a class="float-right">1,322</a>
                  </li>
                  <li class="list-group-item">
                    <b>Following</b> <a class="float-right">543</a>
                  </li>
                  <li class="list-group-item">
                    <b>Friends</b> <a class="float-right">13,287</a>
                  </li>
                </ul> -->

                <!-- <a href="#" class="btn btn-primary btn-block"><b>Follow</b></a> -->
                <input class="btn btn-primary btn-block" id="userfile" type="file" name="userfile" onchange="UploadImage();" />
                 <div id="notif-admin"></div>
                <!-- <p style="text-align: center;"><font color="red"><i style="font-size: 10px;">*max. upload 1MB forrmat .jpg or .png </i></font></p> -->
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->

           
          </div>
          <!-- /.col -->
         
           <!-- About Me Box -->
          <div class="col-md-9">
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">About Me</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <strong><i class="fas fa-book mr-1"></i> Name</strong>

                <p class="text-muted">
                  <?php echo $name; ?>
                </p>

                <hr>

                <strong><i class="fas fa-map-marker-alt mr-1"></i> Email</strong>

                <p class="text-muted"><?php echo $email; ?></p>

                <hr>

                <strong><i class="fas fa-pencil-alt mr-1"></i> Date Of Birth</strong>

                <p class="text-muted">
                  <span class="tag tag-danger"><?php echo $hbd; ?></span>
                  <!-- <span class="tag tag-success">Coding</span>
                  <span class="tag tag-info">Javascript</span>
                  <span class="tag tag-warning">PHP</span>
                  <span class="tag tag-primary">Node.js</span> -->
                </p>

                <hr>

               <!--  <strong><i class="far fa-file-alt mr-1"></i> Notes</strong>

                <p class="text-muted">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam fermentum enim neque.</p> -->
              </div>
              <!-- /.card-body -->
            </div>
          </div>

        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>