 <!-- Content Wrapper. Contains page content -->

<?php

  if($stpdata){
  foreach($stpdata as $value){
    $title   = $value->SetupTitle;
    $name    = $value->SetupName;
    $desc    = $value->SetupDescription;
    $idx     = $value->SetupprofileID;
    $img     = (trim($value->SetupImage) != "") ? $value->SetupImage : "default.jpeg";
  }

  $image = "./upload/profile/".$img;

    if(file_exists($image)){
      $image = base_url()."upload/profile/".$img;
    }
    else{
      $image = base_url()."upload/profile/default.jpeg";
    }
}
else
{
    $title   = "";
    $name    = "";
    $desc    = "";
    $idx     = 0;
    $image = base_url()."upload/profile/default.jpeg";
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
              <li class="breadcrumb-item active">Setup Profile</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content animated zoomInRight">
      <div class="container-fluid" id="blockstp">
        <form method="post" action="" name="f_setup" id="f_setup" enctype="multipart/form-data">
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

                <p class="text-muted text-center"> *max. upload 1MB forrmat .jpg or .png</p>

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
                <input class="form-control btn-primary" id="userfile" type="file" name="userfile" />
                <!-- <p style="text-align: center;"><font color="red"><i style="font-size: 10px;">*max. upload 1MB forrmat .jpg or .png </i></font></p> -->
                <hr>
                 <strong> Setup Title</strong>
                <p class="text-muted">
                  <input class="form-control" style="display: none;" id="stpidx" type="text" name="stpidx" value="<?php echo $idx ;?>" />
                  <input class="form-control" id="stptitle" type="text" name="stptitle" value="<?php echo $title ;?>" />
                </p>

                <hr>

                <strong> Setup Name</strong>

                <input class="form-control" id="stpname" type="text" name="stpname" value="<?php echo $name ;?>" />

                <hr>

                <strong> Setup Description</strong>

                <p class="text-muted">
                  <input class="form-control" id="stpdesc" type="text" name="stpdesc" value="<?php echo $desc ;?>" />
                </p>

                <hr>
                <button type="button" class="btn btn-primary" onclick="return StpProfileSave();"><i class="fa fa-save"></i> Save changes</button>

              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->

           
          </div>
          <!-- /.col -->
         

        
        </div>
      </form>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>


