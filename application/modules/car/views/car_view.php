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
    <section class="content animated fadeInDown">
      <div class="row">
        <div class="col-12">
          
          <div class="card">
            <div class="card-header">
              <a href="#" onclick="return getCar(0);" class="btn btn-primary"><i class="fas fa-plus"></i> Add</a>
              <a href="<?php echo base_url('car/viewCar/print'); ?>" target="_BLANK" class="btn btn-default"><i class="fas fa-print"></i> Print</a>
              <a href="<?php echo base_url('car/viewCar/export'); ?>" target="_BLANK" class="btn btn-success"><i class="fas fa-file-excel"></i> Print</a>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <div class="table-responsive">
              <table id="datatablex" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>Action</th>
                  <th>CarID</th>
                  <th>CarName</th>
                  <th>CarCat</th>
                  <th>CarSeat</th>
                  <th>CarBuyYear</th>
                  <th>CarImage</th>
                  <th>MerkID</th>
                  <th>DailyRentalFee</th>
                  <th>DailyRentalFines</th>
                  <th>IsActive</th>
                  <th>EntryDate</th>
                  <th>EntryBy</th>
                  <th>LastUpdateDate</th>
                  <th>LastUpdateBy</th>
                </tr>
                </thead>
                <tbody>


                <?php               
                  foreach($cardata as $value){ 
                ?>

                <tr>
                  <td nowrap> 
                    <a href="#" class="btn btn-warning" onclick="return getCar('<?php echo $value->CarID?>');" title="Edit"><i class="fas fa-edit"></i> </a> 
                    <a href="#" class="btn btn-danger" onclick="return CarDelete('<?php echo $value->CarID?>');" title="Delete"><i class="fas fa-trash"></td>
                  <td><?php echo $value->CarID;?></td>
                  <td><?php echo $value->CarName;?></td>
                  <td><?php echo $value->CarCat;?></td>
                  <td><?php echo $value->CarSeat;?></td>
                  <td><?php echo $value->CarBuyYear;?></td>
                  <td><?php echo $value->CarImage;?></td>
                  <td><?php echo $value->MerkID;?></td>
                  <td style="text-align:right;"><?php echo $value->DailyRentalFee;?></td>
                  <td style="text-align:right;"><?php echo $value->DailyRentalFines;?></td>
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
                  <th>CarID</th>
                  <th>CarName</th>
                  <th>CarCat</th>
                  <th>CarSeat</th>
                  <th>CarBuyYear</th>
                  <th>CarImage</th>
                  <th>MerkID</th>
                  <th>DailyRentalFee</th>
                  <th>DailyRentalFines</th>
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



   <!--popup-->
  <div class="modal animated bounceIn" id="addcar" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog modal-xl" role="document">
          <div class="modal-content" id="blokform">
            <div class="modal-header bg-primary">
              <h4 class="modal-title">Form Car</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <form method="post" action="" name="f_car" id="f_car" enctype="multipart/form-data">
              <div id="notif-car"></div>
              <input type="hidden" name="id" id="id" value="0">
              <div class="table-responsive">
              <table class="table table-form" style="overflow:auto;">
                <tr>
                  <td style="width: 15%">Car Name * <br><div id="viewinfo"></td>
                  <td style="width: 35%"><input class="form-control" id="carname" name="carname" maxlength="20" type="text"  required /></td>
                  <td style="width: 15%">Car Cat *</td>
                  <td style="width: 35%"><input class="form-control" id="carcat" name="carcat" maxlength="20" type="text"  required /></td>
                </tr>
                 <tr>
                  <td style="width: 15%">Car Number *</td>
                  <td style="width: 35%"><input class="form-control" id="carnumber" name="carnumber" maxlength="20" type="text"  required /></td>
                  <td style="width: 15%">Car Seat </td>
                  <td style="width: 35%"><input class="form-control" id="carseat" name="carseat" maxlength="20" type="text"  required /></td>
                </tr>
                <tr>
                  <td style="width: 15%">Car Buy Year *</td>
                  <td style="width: 35%"><input class="form-control" id="carbuy" name="carbuy" maxlength="20" type="text"  required /></td>
                  <td style="width: 15%">MerkID *</td>
                  <td style="width: 35%"><input class="form-control" id="merkid" name="merkid" maxlength="20" type="text"  required /></td>
                </tr>
                <tr>
                  <td style="width: 15%">Daily Rental Fee *</td>
                  <td style="width: 35%"><input class="form-control" id="dailyfee" name="dailyfee" maxlength="20" type="text"  required /></td>
                  <td style="width: 15%">Daily Rental Fines </td>
                  <td style="width: 35%"><input class="form-control" id="dailyfines" name="dailyfines" maxlength="20" type="text"  required /></td>
                </tr>
                <tr>
                  <td style="width: 15%">Car Image </td>
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
              <button type="button" class="btn btn-primary" onclick="return CarSave();">Save changes</button>
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

  var base_url = window.location.origin;
  $( "#merkid" ).autocomplete({
      serviceUrl: base_url+"/codeigneter-3.1.11/car/viewCar/searchmerk",   // Kode php untuk prosesing data.
      dataType: "JSON",           // Tipe data JSON.
      onSelect: function (suggestion) {
      $( "#merkid" ).val("" + suggestion.key);
      }
    });

 });
</script>
