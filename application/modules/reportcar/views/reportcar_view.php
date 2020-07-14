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
              
              <form method="post" action="" name="r_car" id="r_car" enctype="multipart/form-data">
              <div id="notif-rpt"></div>
              <div class="table-responsive">
              <table class="table table-sm table-form" style="overflow:auto;">

                <tr>
                  <td style="width: 15%">Car Name<br></td><input id="keycarname" name="keycarname" value="" type="hidden" />
                  <td style="width: 35%"><input class="form-control" id="carname" name="carname" maxlength="20" type="text"  required /></td>
                </tr>
                <tr>
                  <td style="width: 15%">Effective Date *</td>
                  <td style="width: 35%"><input class="form-control" id="effdate" name="effdate" maxlength="20" type="text" value="<?php echo date('Y-m-d'); ?>" required /></td>
                </tr>
                <tr>
                  <td style="width: 15%">Merk ID</td><input id="keymerkid" name="keymerkid" value="" type="hidden" />
                  <td style="width: 35%"><input class="form-control" id="merkid" name="merkid" maxlength="20" type="text"  required /></td>
                </tr>
                <tr>
                  <td colspan="2" align="left">
                     <button type="button" class="btn btn-warning" onclick="callpage('reportcar/viewReportCar', '', '')"><i class="fas fa-eraser"></i> Reset</button>
                     <button type="button" class="btn btn-primary" onclick="return ReportcarSearch();"><i class="fas fa-search"></i> Search</button>
                  </td>
                </tr>
              </table>
            </div>
          </form>
            
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <div class="table-responsive">

                <div id="content-rpt">
                  <?php $this->load->view('reportcar/reportcar_search', array('keys'=>$str)); ?>
                </div>

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


  <style>
      .gridvie {
        font-family: Times New Roman, Times, serif;
        height: 92%;
        overflow: auto; 
      }
      .gridview table { border: 1px solid #00557F; }
      .gridview table .total td {
        background:-webkit-gradient( linear, left top, left bottom, color-stop(0.05, #ff66b8), color-stop(1,#ff66b8));
        background:-moz-linear-gradient( center top, #ff66b8 5%, #ff66b8 100% );
        filter:progid:DXImageTransform.Microsoft.gradient(startColorstr='#ff66b8', endColorstr='#ff66b8');
        border: 1px solid #00557F;
        color: #000;
        
      }
      .gridview table .total td:first-child { text-align: center; border-right: 1px solid #FFF; }
      .gridview table .total td:last-child { text-align: right; }
      .cap-table, .gridview table { width: 98%; margin: 0 auto; }
      .cap-table { color: #000; padding: 5px 0 5px 0; }
  </style>


<script type="text/javascript">
$(" #carname ").focus();

$(document).ready(function(){
  var base_url = window.location.origin;
  $("#carname" ).autocomplete({
      serviceUrl: base_url+"/codeigneter-3.1.11/reportcar/viewReportCar/searchcar",   // Kode php untuk prosesing data.
      dataType: "JSON",           // Tipe data JSON.
      onSelect: function (suggestion) {
      $( "#keycarname" ).val("" + suggestion.key);
      $( "#carname" ).val("" + suggestion.keynm);
      }
  });


  $("#merkid" ).autocomplete({
      serviceUrl: base_url+"/codeigneter-3.1.11/reportcar/viewReportCar/searchmerk",   // Kode php untuk prosesing data.
      dataType: "JSON",           // Tipe data JSON.
      onSelect: function (suggestion) {
      $( "#keymerkid" ).val("" + suggestion.key);
      $( "#merkid" ).val("" + suggestion.keynm);
      }
  });

});

$('#effdate').datepicker({
  format: "yyyy-mm-dd",
  todayHighlight: true,
  orientation: "bottom auto",
  autoclose:true
});

</script>




