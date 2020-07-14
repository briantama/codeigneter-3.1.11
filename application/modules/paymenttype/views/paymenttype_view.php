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
    <section class="content animated fadeInLeft">
      <div class="row">
        <div class="col-12">
          
          <div class="card">
            <div class="card-header">
               <a href="#" onclick="return getPaymenttype(0);" class="btn btn-primary"><i class="fas fa-plus"></i> Add</a>
              <a href="<?php echo base_url('paymenttype/viewPaymenttype/print'); ?>" target="_BLANK" class="btn btn-default"><i class="fas fa-print"></i> Print</a>
              <a href="<?php echo base_url('paymenttype/viewPaymenttype/export'); ?>" target="_BLANK" class="btn btn-success"><i class="fas fa-file-excel"></i> Export</a>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <table id="datatablex" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>Action</th>
                  <th>PaymentID</th>
                  <th>PaymentType</th>
                  <th>IsActive</th>
                  <th>EntryDate</th>
                  <th>EntryBy</th>
                  <th>LastUpdateDate</th>
                  <th>LastUpdateBy</th>
                </tr>
                </thead>
                <tbody>

                <?php               
                  foreach($paydata as $value){ 
                ?>

                <tr>
                  <td nowrap> 
                    <a href="#" class="btn btn-warning" onclick="return getPaymenttype('<?php echo $value->PaymentID?>');" title="Edit"><i class="fas fa-edit"></i> </a> 
                    <a href="#" class="btn btn-danger" onclick="return PaymenttypeDelete('<?php echo $value->PaymentID?>');" title="Delete"><i class="fas fa-trash"></td>
                  <td><?php echo $value->PaymentID;?></td>
                  <td><?php echo $value->PaymentType;?></td>
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
                  <th>PaymentID</th>
                  <th>PaymentType</th>
                  <th>IsActive</th>
                  <th>EntryDate</th>
                  <th>EntryBy</th>
                  <th>LastUpdateDate</th>
                  <th>LastUpdateBy</th>
                </tr>
                </tfoot>
              </table>
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
  <div class="modal animated bounceIn" id="addpaytype" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
          <div class="modal-content" id="blokform">
            <div class="modal-header bg-primary">
              <h4 class="modal-title">Form Payment Type</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <form method="post" action="" name="f_paytype" id="f_paytype" >
              <div id="notif-paytype"></div>
              <input type="hidden" name="id" id="id" value="0">
              <div class="table-responsive">
              <table class="table table-form">
                <tr>
                  <td style="width: 35%">Payment Type *</td>
                  <td style="width: 65%"><input class="form-control" id="paytype" name="paytype" maxlength="20" type="text" required /></td>
                </tr>
              
              </table>
            </div>

            </div>
            <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
              <button type="button" class="btn btn-primary" onclick="return PaymenttypeSave();">Save changes</button>
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