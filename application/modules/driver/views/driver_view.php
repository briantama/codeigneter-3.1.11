  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1><?php echo $title; ?></h1>
          </div>
          <!-- <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">DataTables</li>
            </ol>
          </div> -->
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content animated bounceIn">
      <div class="row">
        <div class="col-12">
          
          <div class="card">
            <div class="card-header">
              <a href="#" onclick="return getDriver(0);" class="btn btn-primary"><i class="fas fa-plus"></i> Add</a>
              <a href="<?php echo base_url('driver/viewDriver/print'); ?>" target="_BLANK" class="btn btn-default"><i class="fas fa-print"></i> Print</a>
              <a href="<?php echo base_url('driver/viewDriver/export'); ?>" target="_BLANK" class="btn btn-success"><i class="fas fa-file-excel"></i> Print</a>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <div class="table-responsive">
              <table id="datatablex" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>Action</th>
                  <th>DriverID</th>
                  <th>DriverName</th>
                  <th>IdentityID</th>
                  <th>MobilePhone</th>
                  <th>HomePhone</th>
                  <th>Email</th>
                  <th>Address</th>
                  <th>DailyDrivingCosts</th>
                  <th>DriverImage</th>
                  <th>IsActive</th>
                  <th>EntryDate</th>
                  <th>EntryBy</th>
                  <th>LastUpdateDate</th>
                  <th>LastUpdateBy</th>
                </tr>
                </thead>
                <tbody>
    
                <?php               
                  foreach($drivdata as $value){ 
                ?>

                <tr>
                  <td nowrap> 
                      <a href="#" class="btn btn-warning" onclick="return getDriver('<?php echo $value->DriverID?>');" Title="Edit"><i class="fas fa-edit"></i> </a> 
                      <a href="#" class="btn btn-danger" onclick="return driverDelete('<?php echo $value->DriverID?>');" Title="Delete"><i class="fas fa-trash">
                  </td>
                  <td><?php echo $value->DriverID;?></td>
                  <td><?php echo $value->DriverName;?></td>
                  <td><?php echo $value->IdentityID;?></td>
                  <td><?php echo $value->MobilePhone;?></td>
                  <td><?php echo $value->HomePhone;?></td>
                  <td><?php echo $value->Email;?></td>
                  <td><?php echo $value->Address;?></td>
                  <td style="text-align:right;"><?php echo $value->DailyDrivingCosts;?></td>
                  <td><?php echo $value->DriverImage;?></td>
                  <td><?php echo $value->IsActive;?></td>
                  <td><?php echo $value->EntryDate;?></td>
                  <td><?php echo $value->EntryBy;?></td>
                  <td><?php echo $value->LastUpdateDate;?></td>
                  <td><?php echo $value->LastUpdateBy;?></td>
                </tr>

                <?php
                  }
                ?>
                
                </tbody>
                <tfoot>
                <tr>
                  <th>Action</th>
                  <th>DriverID</th>
                  <th>DriverName</th>
                  <th>IdentityID</th>
                  <th>MobilePhone</th>
                  <th>HomePhone</th>
                  <th>Email</th>
                  <th>Address</th>
                  <th>DailyDrivingCosts</th>
                  <th>DriverImage</th>
                  <th>IsActive</th>
                  <th>EntryDate</th>
                  <th>EntryBy</th>
                  <th>LastUpdateDate</th>
                  <th>LastUpdateBy</th>
                </tr>
                </tfoot>
              </table>
              </div><!-- table responsive -->
            </div>
            <!-- /.card-body -->
          </div>
          <!-- /.card -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->



<?php

$doc = "";
$query = $this->db->query("SELECT  CONCAT('DRV-',LPAD(COALESCE(MAX(RIGHT(DriverID, 6)), '000000')+1,6,0)) AS GetID
                           FROM    M_MasterDriver
                          ");
 if ($query->num_rows() > 0) {
   $arr = $query->first_row();
   $doc = $arr->GetID;
   //echo $doc;
 }

?>



   <!--popup-->
  <div class="modal animated bounceIn" id="adddriver" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog modal-xl" role="document">
          <div class="modal-content" id="blokform">
            <div class="modal-header bg-primary">
              <h4 class="modal-title">Form Customer</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <form method="post" action="" name="f_driver" id="f_driver" enctype="multipart/form-data">
              <div id="notif-driver"></div>
              <input type="hidden" name="id" id="id" value="0">
              <input type="hidden" name="numberingdriv" id="numberingdriv" value="<?php echo $doc; ?>">
              <div class="table-responsive">
              <table class="table table-form" style="overflow:auto;">
                <tr>
                  <td style="width: 15%">Driver ID * <br><div id="viewinfo"></td>
                  <td style="width: 35%"><input class="form-control" id="driverid" name="driverid" maxlength="20" type="text" readonly="readonly" required /></td>
                  <td style="width: 15%">Driver Name *</td>
                  <td style="width: 35%"><input class="form-control" id="drivername" name="drivername" maxlength="20" type="text" required /></td>
                </tr>
                 <tr>
                  <td style="width: 15%">Mobile Phone *</td>
                  <td style="width: 35%"><input class="form-control" id="mobphone" name="mobphone" maxlength="20" type="text" required /></td>
                  <td style="width: 15%">Home Phone </td>
                  <td style="width: 35%"><input class="form-control" id="homephone" name="homephone" maxlength="20" type="text" required /></td>
                </tr>
                <tr>
                  <td style="width: 15%">IdentityID *</td>
                  <td style="width: 35%"><input class="form-control" id="identityid" name="identityid" maxlength="20" type="text" required /></td>
                  <td style="width: 15%">Address *</td>
                  <td style="width: 35%"><textarea class="form-control " id="addres" name="addres" required></textarea></td>
                </tr>
                <tr>
                  <td style="width: 15%">Daily Driv. Costs *</td>
                  <td style="width: 35%"><input class="form-control" id="dailyfee" name="dailyfee" maxlength="20" type="text" required /></td>
                  <td style="width: 15%">Email </td>
                  <td style="width: 35%"><input class="form-control" id="email" name="email" maxlength="20" type="email" required /></td>
                </tr>
                <tr>
                  <td style="width: 15%">Driver Image</td>
                  <td style="width: 35%"><input class="form-control " id="userfile" type="file" name="userfile" /><br><div id="viewgambar"></div></td>
                  <td colspan="2" style="width: 50%">
                    <font color="red"><i style="font-size: 10px;">*upload forrmat .jpg or .png </i> <br>
                    <font color="red"><i style="font-size: 10px;">*max. upload 1MB </i>
                  </td>
                </tr>

              </table>
            </div>

            </div>
            <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
              <button type="button" class="btn btn-primary" onclick="return DriverSave();">Save changes</button>
            </div>
          </form>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>
      <!-- /.modal -->


<script type="text/javascript">
 $(document).ready(function(){
  $('#datatablex').DataTable();
 });
</script>


