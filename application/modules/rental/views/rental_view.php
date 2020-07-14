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
    <section class="content animated bounceInRight">
      <div class="row">
        <div class="col-12">
          
          <div class="card">
            <div class="card-header">
              <a href="#" onclick="return getRental(0);" class="btn btn-primary"><i class="fas fa-plus"></i> Add</a>
              <a href="<?php echo base_url('rental/viewRental/print'); ?>" target="_BLANK" class="btn btn-default"><i class="fas fa-print"></i> Print</a>
              <a href="<?php echo base_url('rental/viewRental/export'); ?>" target="_BLANK" class="btn btn-success"><i class="fas fa-file-excel"></i> Export</a>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <div class="table-responsive">
              <table id="datarental" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>Action</th>
                  <th>RentalID</th>
                  <th>Cust. ID</th>
                  <th>Cust. Name</th>
                  <th>CarName</th>
                  <th>CarNumber</th>
                  <th>StartDate</th>
                  <th>EndDate</th>
                  <th>RentalCosts</th>
                  <th>PaymentID</th>
                  <th>Status</th>
                  <th>DriverRentalFee</th>                      
                  <th>TotalRentalFee</th>
                  <th>IsActive</th>
                  <th>EntryDate</th>
                  <th>EntryBy</th>
                  <th>LastUpdateDate</th>
                  <th>LastUpdateBy</th>
                </tr>
                </thead>
                <tbody>

    
                <?php               
                  foreach($rentaldata as $value){ 

                    if(trim($value->Status) == "1"){
                      $list = "<span class='badge badge-danger'>Active</span>";
                      $btn  = "<a href='#' class='btn btn-info' onclick='return RentalPost(\"".$value->RentalID."\");' title='Post'><i class='fas fa-fw fa-share'></i> </a>";
                    }
                    else if(trim($value->Status) == "5"){
                      $list = "<span class='badge badge-warning'>OnGoing</span>";
                      $btn  = "<a href='".base_url('rental/viewRental/printinvoice/'.$value->RentalID.'')."' target='_BLANK' class='btn btn-success' title='Print Bill'><i class='fas fa-fw fa-file-invoice'></i> </a>";
                    }
                    else{
                      $list = "<span class='badge badge-success'>Finish</span>";
                      $btn  = "<a href='".base_url('rental/viewRental/printinvoice/'.$value->RentalID.'')."' target='_BLANK' class='btn btn-success' title='Print Bill'><i class='fas fa-fw fa-file-invoice'></i> </a>";
                    }

                ?>

                <tr>
                  <td nowrap> 
                      <a href="#" class="btn btn-warning" onclick="return getRental('<?php echo $value->RentalID?>');" title="Edit"><i class="fas fa-edit"></i> </a> 
                      <a href="#" class="btn btn-danger" onclick="return RentalDelete('<?php echo $value->RentalID?>');" title="Delete"><i class="fas fa-trash"></i> </a>
                      <?php echo $btn; ?>

                  </td>
                  <td><?php echo $value->RentalID;?></td>
                  <td><?php echo $value->OrderID;?></td>
                  <td><?php echo $value->CustomerName;?></td>
                  <td><?php echo $value->CarName;?></td>
                  <td><?php echo $value->CarNumber;?></td>
                  <td><?php echo $value->StartDate;?></td>
                  <td><?php echo $value->EndDate;?></td>
                  <td style="text-align:right;"><?php echo $value->RentalCosts;?></td>
                  <td><?php echo $value->PaymentID;?></td>
                  <td><?php echo $list;?></td>
                  <td style="text-align:right;"><?php echo $value->DriverRentalFee;?></td>
                  <td style="text-align:right;"><?php echo $value->TotalRentalFee;?></td>
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
                  <th>RentalID</th>
                  <th>Cust. ID</th>
                  <th>Cust. Name</th>
                  <th>CarName</th>
                  <th>CarNumber</th>
                  <th>StartDate</th>
                  <th>EndDate</th>
                  <th>RentalCosts</th>
                  <th>PaymentID</th>
                  <th>Status</th>
                  <th>DriverRentalFee</th>                      
                  <th>TotalRentalFee</th>
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
$query = $this->db->query("SELECT  CONCAT('RTL-',LPAD(COALESCE(MAX(RIGHT(RentalID, 6)), '000000')+1,6,0)) AS GetID
                           FROM    T_Rental
                          ");
 if ($query->num_rows() > 0) {
   $arr = $query->first_row();
   $doc = $arr->GetID;
   //echo $doc;
 }


$arr = "";
$query = $this->db->query("SELECT  PaymentID, PaymentType
                           FROM    T_PaymentType
                           WHERE   IsActive ='Y'
                          ");
 if ($query->num_rows() > 0) {
   $arr = $query->result();
   $str = "<option value=''>Choice</option>";
   foreach ($arr as $value) {
     $str .= "<option value='".$value->PaymentID."'>".$value->PaymentType."</option>";
   }
 }
 else{
    $str = "<option value=''>No Data</option>";
 }


?>



   <!--popup-->
  <div class="modal animated bounceIn" id="addrental" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog modal-xl" role="document">
          <div class="modal-content" id="blokform">
            <div class="modal-header bg-primary">
              <h4 class="modal-title">Form Rental Car</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <form method="post" action="" name="f_rental" id="f_rental">
              <div id="notif-rental"></div>
              <input type="hidden" name="id" id="id" value="0">
              <input type="hidden" name="numberingrent" id="numberingrent" value="<?php echo $doc; ?>">
              <div class="table-responsive">
              <table class="table table-sm table-form" style="overflow:auto;">
                <tr>
                  <td >Rental ID * <br><div id="viewinfo"></td>
                  <td colspan="3"><input class="form-control" id="rentalid" name="rentalid" maxlength="20" type="text" readonly="readonly" required /></td>
                </tr>
                <tr>
                  <td >Cust. ID *</td>
                  <td ><input class="form-control" id="custid" name="custid" maxlength="20" type="text" required /></td>
                  <td >Cust. Name *</td>
                  <td ><input class="form-control" id="custname" name="custname" type="text" readonly="readonly" /></td>
                </tr>
                 <tr>
                  <td >Car ID *</td>
                  <td ><input class="form-control" id="carid" name="carid" maxlength="20" type="text" required /></td>
                  <td >Car Name *</td>
                  <td ><input class="form-control" id="carname" name="carname" maxlength="20" type="text" readonly="readonly" required /></td>
                </tr>
                <tr>
                  <td >Rental Costs *</td>
                  <td ><input class="form-control" id="rentalcost" name="rentalcost" maxlength="20" type="text" readonly="readonly" required /></td>
                  <td >Start Date</td>
                  <td ><input class="form-control" id="startdate" name="startdate" maxlength="20" type="text" required /></td>
                </tr>
                <tr>
                  <td >End Date</td>
                  <td ><input class="form-control" id="enddate" name="enddate" maxlength="20" type="text" required /></td>
                  <td >PaymentID *</td>
                  <td >
                    <select name="paymentid" id="paymentid" class="form-control">
                       <?php echo $str; ?>
                    </select>
                  </td>

                </tr>
                <tr>
                  <td >Driver </td>
                  <td ><input class="form-control" id="driverid" name="driverid" maxlength="100" type="text"/></td>
                  <!-- <td >Driv. Name </td>
                  <td ><input class="form-control" id="drivername" name="drivername" maxlength="100" type="text" readonly="readonly" /></td> -->
                  <td >Driv. Cost </td>
                  <td ><input class="form-control" id="drivercost" name="drivercost" maxlength="100" type="text" readonly="readonly" /></td>
                </tr>
                

              </table>
            </div>

            </div>
            <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
              <button type="button" class="btn btn-primary" onclick="return RentalSave();">Save changes</button>
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
  $('#datarental').DataTable();

    var base_url = window.location.origin;
    // Selector input yang akan menampilkan autocomplete.
    $( "#custid" ).autocomplete({
      serviceUrl: base_url+"/codeigneter-3.1.11/rental/viewRental/search",   // Kode php untuk prosesing data.
      dataType: "JSON",           // Tipe data JSON.
      onSelect: function (suggestion) {
      $( "#custid" ).val("" + suggestion.key);
      $( "#custname" ).val("" + suggestion.keynm);
      $(" #carid ").focus();
      }
    });

     $( "#carid" ).autocomplete({
      serviceUrl: base_url+"/codeigneter-3.1.11/rental/viewRental/searchcar",   // Kode php untuk prosesing data.
      dataType: "JSON",           // Tipe data JSON.
      onSelect: function (suggestion) {
      $( "#carid" ).val("" + suggestion.key);
      $( "#carname" ).val("" + suggestion.keynm);
      $( "#rentalcost" ).val("" + suggestion.keyfee);
      $(" #startdate ").focus();
      }
    });

     $( "#driverid" ).autocomplete({
      serviceUrl: base_url+"/codeigneter-3.1.11/rental/viewRental/searchdriver",   // Kode php untuk prosesing data.
      dataType: "JSON",           // Tipe data JSON.
      onSelect: function (suggestion) {
      $( "#driverid" ).val("" + suggestion.key);
      //$( "#drivername" ).val("" + suggestion.keynm);
      $( "#drivercost" ).val("" + suggestion.keyfee);
      $(".btn-primary ").focus();
      }
    });

 });

$('#startdate').datepicker({
  format: "yyyy-mm-dd",
  todayHighlight: true,
  orientation: "bottom auto",
  autoclose:true
});


$('#enddate').datepicker({
  format: "yyyy-mm-dd",
  todayHighlight: true,
  orientation: "bottom auto",
  autoclose:true
});


</script>



