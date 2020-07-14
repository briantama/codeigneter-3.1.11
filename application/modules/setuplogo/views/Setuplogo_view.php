 <!-- Content Wrapper. Contains page content -->

<?php
 

if($stpdata){
  foreach($stpdata as $value){
    $title   = $value->SetupTitle;
    $name    = $value->SetupName;
    $desc    = $value->SetupDescription;
    $idx     = $value->SetupprofileID;
    $img     = (trim($value->SetupImageLogo) != "") ? $value->SetupImageLogo : "default.jpeg";
  }

  $image = "./upload/logo/".$img;

    if(file_exists($image)){
      $image = base_url()."upload/logo/".$img;
    }
    else{
      $image = base_url()."upload/logo/default.jpeg";
    }
}
else
{
    $title   = "";
    $name    = "";
    $desc    = "";
    $idx     = 0;
    $image = base_url()."upload/logo/default.jpeg";
}

?>

  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1><?php echo $titlex; ?></h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Setup Logo</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content animated zoomInRight">
      <div class="container-fluid" id="blockstpl">
        <div class="row">
          <div class="col-md-12">

            <!-- Profile Image -->
            <div class="card card-primary card-outline">
              <div class="card-body box-profile">
                <div class="text-center">
                  <img class="profile-user-img img-fluid img-circle"
                       src="<?php echo $image; ?>"
                       alt="User profile picture">
                </div>

                <h3 class="profile-username text-center"></h3>

                <p class="text-muted text-center"><font color="red"><i style="font-size: 10px;">*max. upload 1MB size 600px x 800px  forrmat .jpg or .png </i></font></p>

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
                <form method="post" action="" name="f_setupl" id="f_setupl" enctype="multipart/form-data">
                <input class="form-control" style="display: none;" id="stpidx" type="text" name="stpidx" value="<?php echo $idx ;?>" />
                <!-- <a href="#" class="btn btn-primary btn-block"><b>Follow</b></a> -->
                <input class="form-control btn-primary" id="userfile" type="file" onchange="StpLogoSave();" name="userfile" />
                 <div id="notif-stplogo"></div>
               </form>
                <!-- <p style="text-align: center;"><font color="red"><i style="font-size: 10px;">*max. upload 1MB forrmat .jpg or .png </i></font></p> -->
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->

           
          </div>
          <!-- /.col -->
         
         
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>



