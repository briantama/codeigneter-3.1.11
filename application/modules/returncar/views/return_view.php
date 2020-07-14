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
    <section class="content animated fadeInRight">
      <div class="row">
        <div class="col-12">
          
          <div class="card">
            <div class="card-header">
              <a href="#" onclick="return getReturn(0);" class="btn btn-primary"><i class="fas fa-plus"></i> Add</a>
              <a href="<?php echo base_url('returncar/viewReturn/print'); ?>" target="_BLANK" class="btn btn-default"><i class="fas fa-print"></i> Print</a>
              <a href="<?php echo base_url('returncar/viewReturn/export'); ?>" target="_BLANK" class="btn btn-success"><i class="fas fa-file-excel"></i> Export</a>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <div class="table-responsive">
              <table id="datareturn" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>Action</th>
                  <th>ReturnID</th>
                  <th>RentalID</th>
                  <th>Cust. Name</th>
                  <th>CarName</th>
                  <th>CarNumber</th>
                  <th>TotalRentalFee</th>
                  <th>ReturnDate</th>
                  <th>LateCharge</th>
                  <th>Status</th>
                  <th>IsActive</th>
                  <th>EntryDate</th>
                  <th>EntryBy</th>
                  <th>LastUpdateDate</th>
                  <th>LastUpdateBy</th>
                </tr>
                </thead>
                <tbody>
      
                <?php               
                  foreach($retrundata as $value){ 

                    if(trim($value->Status) == "1"){
                      $list = "<span class='badge badge-danger'>Active</span>";
                    }
                    else if(trim($value->Status) == "5"){
                      $list = "<span class='badge badge-warning'>OnGoing</span>";
                    }
                    else{
                      $list = "<span class='badge badge-success'>Finish</span>";
                    }
                ?>

                <tr>
                  <td nowrap> 
                      <a href="#" class="btn btn-warning" onclick="return getReturn('<?php echo $value->ReturnID?>');" title="Edit"><i class="fas fa-edit"></i> </a> 
                      <a href="#" class="btn btn-danger" onclick="return ReturnDelete('<?php echo $value->ReturnID?>');" title="Delete"><i class="fas fa-trash"></i> </a>
                      <?php if(trim($value->Status) != "7"){ ?>
                      <a href="#" class="btn btn-info" onclick="return ReturnPost('<?php echo $value->ReturnID?>');" title="Post"><i class="fas fa-share"></i> </a>
                      <?php } ?>
                  </td>
                  <td><?php echo $value->ReturnID;?></td>
                  <td><?php echo $value->RentalID;?></td>
                  <td><?php echo $value->CustomerName;?></td>
                  <td><?php echo $value->CarName;?></td>
                  <td><?php echo $value->CarNumber;?></td>
                  <td style="text-align:right;"><?php echo $value->TotalRentalFee;?></td>
                  <td><?php echo $value->ReturnDate;?></td>
                  <td style="text-align:right;"><?php echo $value->LateCharge;?></td>
                  <td><?php echo $list; ?></td>
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
                  <th>ReturnID</th>
                  <th>RentalID</th>
                  <th>Cust. ID</th>
                  <th>CarName</th>
                  <th>CarNumber</th>
                  <th>TotalRentalFee</th>
                  <th>ReturnDate</th>
                  <th>LateCharge</th>
                  <th>Status</th>
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
$query = $this->db->query("SELECT  CONCAT('RTN-',LPAD(COALESCE(MAX(RIGHT(ReturnID, 6)), '000000')+1,6,0)) AS GetID
                           FROM    T_Return 
                          ");
 if ($query->num_rows() > 0) {
   $arr = $query->first_row();
   $doc = $arr->GetID;
   //echo $doc;
 }

?>



   <!--popup-->
  <div class="modal animated bounceIn" id="addreturn" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog modal-xl" role="document">
          <div class="modal-content" id="blokform">
            <div class="modal-header bg-primary">
              <h4 class="modal-title">Form Retrun Car</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <form method="post" action="" name="f_retrun" id="f_retrun">
              <div id="notif-return"></div>
              <input type="hidden" name="id" id="id" value="0">
              <input type="hidden" name="numberingretr" id="numberingretr" value="<?php echo $doc; ?>">
              <div class="table-responsive">
              <table class="table table-sm table-form" style="overflow:auto;">
                <tr>
                  <td >Retrun ID * <br><div id="viewinfo"></td>
                  <td ><input class="form-control" id="returnid" name="returnid" maxlength="20" type="text" readonly="readonly" required /></td>
                  <td >RentalID *</td>
                  <td ><input class="form-control" id="rentalid" name="rentalid" maxlength="20" type="text" required /></td>
                </tr>
                 <tr>
                  <td >Cust. Name *</td>
                  <td ><input class="form-control" id="custname" name="custname" type="text" readonly="readonly" /></td>
                  <td >StartDate *</td>
                  <td ><input class="form-control" id="startdate" name="startdate" maxlength="20" type="text" readonly="readonly" /></td>
                </tr>
                <tr>
                  <td >EndDate</td>
                  <td ><input class="form-control" id="enddate" name="enddate" maxlength="20" type="text" readonly="readonly" /></td>
                  <td >Car ID</td>
                  <td ><input class="form-control" id="carid" name="carid" maxlength="20" type="text" readonly="readonly" /></td>
                </tr> 
                <tr>
                  <td >Car Name</td>
                  <td ><input class="form-control" id="carname" name="carname" maxlength="100" type="text" readonly="readonly" /></td>
                  <td >Daily Rental Fines </td>
                  <td ><input class="form-control" id="dailyrent" name="dailyrent" maxlength="20" type="text" readonly="readonly" /></td>
                </tr>
                <tr>
                  <td >Driver</td>
                  <td ><input class="form-control" id="driverid" name="driverid" maxlength="20" type="text" readonly="readonly" /></td>
                  <td >Daily Driv. Cost </td>
                  <td ><input class="form-control" id="dailycost" name="dailycost" maxlength="100" type="text" readonly="readonly"/></td>
                </tr>
                <tr>
                  <td >Return Date *</td>
                  <td ><input class="form-control" id="returndate" name="returndate" maxlength="100" type="text" value="<?php echo date('Y-m-d'); ?>" required /></td>
                  <td >Late Charge *</td>
                  <td ><input class="form-control" id="latecharge" name="latecharge" maxlength="100" type="text" value="0" readonly="readonly" /><div id="viewdays"></div></td>
                </tr>
                

              </table>
            </div>

            </div>
            <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
              <button type="button" class="btn btn-primary" onclick="return ReturnSave();">Save changes</button>
            </div>
          </form>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>
      <!-- /.modal -->]


<script type="text/javascript">
 $(document).ready(function(){
  $('#datareturn').DataTable();

    var base_url = window.location.origin;
    // Selector input yang akan menampilkan autocomplete.
    $( "#rentalid" ).autocomplete({
      serviceUrl: base_url+"/codeigneter-3.1.11/returncar/viewReturn/search",   // Kode php untuk prosesing data.
      dataType: "JSON",           // Tipe data JSON.
      onSelect: function (suggestion) {
      $( "#rentalid" ).val("" + suggestion.key);
      // $( "#custname" ).val("" + suggestion.keynm);
      // $(" #returndate ").focus();
      callblur(suggestion.key);
      }
    });

 });

$('#returndate').datepicker({
  format: "yyyy-mm-dd",
  todayHighlight: true,
  orientation: "bottom auto",
  autoclose:true
}).on('changeDate', function (selected) {
   // alert(selected.format(0,"yyyy-mm-dd"));
   //  console.log(selected);
   var datex    = selected.format(0,"yyyy-mm-dd");
   var enddate  = $("#enddate").val();
   var dyrent   = $("#dailyrent").val();
   //var x = daysDifference(enddate, datex);
   var diff = Math.floor(( Date.parse(datex) - Date.parse(enddate) ) / 86400000);
   var calc = dyrent * diff;
   if(calc > 0){
    $("#latecharge").val(dyrent * diff); 
   }
   else{
    $("#latecharge").val(0); 
   }
   $("#viewdays").html('<font color="red"><i style="font-size: 12px;">* '+diff+' Days Late Return Of The Car</i></font>');
   //alert(diff);
});


function daysDifference(d0, d1) {
  var diff = new Date(+d1).setHours(12) - new Date(+d0).setHours(12);
  return Math.round(diff/8.64e7);
}



</script>
