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
    <section class="content animated zoomIn">
      <div class="row">
        <div class="col-12">
          
          <div class="card">
            <div class="card-header">
              <a href="#" onclick="return getCustomer(0);" class="btn btn-primary"><i class="fas fa-plus"></i> Add</a>
              <a href="<?php echo base_url('customer/viewCustomer/print'); ?>" target="_BLANK" class="btn btn-default"><i class="fas fa-print"></i> Print</a>
              <a href="<?php echo base_url('customer/viewCustomer/export'); ?>" target="_BLANK" class="btn btn-success"><i class="fas fa-file-excel"></i> Export</a>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <div class="table-responsive">
              <table id="datatablex" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>Action</th>
                  <th>OrderID</th>
                  <th>Cust. Name</th>
                  <th>Mob. Phone</th>
                  <th>HomePhone</th>
                  <th>Address</th>
                  <th>IdentityID</th>
                  <th>Gender</th>
                  <th>OrderImage</th>
                  <th>Email</th>
                  <th>IsActive</th>
                  <th>EntryDate</th>
                  <th>EntryBy</th>
                  <th>LastUpdateDate</th>
                  <th>LastUpdateBy</th>
                </tr>
                </thead>
                <tbody>

    
                <?php               
                  foreach($custdata as $value){ 
                ?>

                <tr>
                  <td nowrap> 
                      <a href="#" class="btn btn-warning" onclick="return getCustomer('<?php echo $value->OrderID?>');" title="Edit"><i class="fas fa-edit"></i> </a> 
                      <a href="#" class="btn btn-danger" onclick="return CustomerDelete('<?php echo $value->OrderID?>');" title="Delete"><i class="fas fa-trash">
                  </td>
                  <td><?php echo $value->OrderID;?></td>
                  <td><?php echo $value->CustomerName;?></td>
                  <td><?php echo $value->MobilePhone;?></td>
                  <td><?php echo $value->HomePhone;?></td>
                  <td><?php echo $value->Address;?></td>
                  <td><?php echo $value->IdentityID;?></td>
                  <td><?php echo $value->Email;?></td>
                  <td><?php echo $value->Gender;?></td>
                  <td><?php echo $value->OrderImage;?></td>
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
                  <th>OrderID</th>
                  <th>Cust. Name</th>
                  <th>Mob. Phone</th>
                  <th>HomePhone</th>
                  <th>Address</th>
                  <th>IdentityID</th>
                  <th>Gender</th>
                  <th>OrderImage</th>
                  <th>Email</th>
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
$query = $this->db->query("SELECT  CONCAT('CUS-',LPAD(COALESCE(MAX(RIGHT(OrderID, 6)), '000000')+1,6,0)) AS GetID
                           FROM    T_CustomerOrder
                          ");
 if ($query->num_rows() > 0) {
   $arr = $query->first_row();
   $doc = $arr->GetID;
   //echo $doc;
 }

?>



   <!--popup-->
  <div class="modal animated bounceIn" id="addcustomer" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog modal-xl" role="document">
          <div class="modal-content" id="blokform">
            <div class="modal-header bg-primary">
              <h4 class="modal-title">Form Customer</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <form method="post" action="" name="f_customer" id="f_customer" enctype="multipart/form-data">
              <div id="notif-customer"></div>
              <input type="hidden" name="id" id="id" value="0">
              <input type="hidden" name="numberingcust" id="numberingcust" value="<?php echo $doc; ?>">
              <div class="table-responsive">
              <table class="table table-form" style="overflow:auto;">
                <tr>
                  <td style="width: 15%">Cust ID * <br><div id="viewinfo"></td>
                  <td style="width: 35%"><input class="form-control" id="custid" name="custid" maxlength="20" type="text" readonly="readonly" required /></td>
                  <td style="width: 15%">Cust Name *</td>
                  <td style="width: 35%"><input class="form-control" id="custname" name="custname" type="text" required /></td>
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
                  <td style="width: 15%">Gender *</td>
                  <td style="width: 35%">
                          <select name="gender" id="gender" class="form-control">
                            <option value="M">Male</option>
                            <option value="F">Female</option>
                        </select></td>
                  <td style="width: 15%">Email </td>
                  <td style="width: 35%"><input class="form-control" id="email" name="email" type="email" required /></td>
                </tr>
                <tr>
                  <td style="width: 15%">Cust. Image</td>
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
              <button type="button" class="btn btn-primary" onclick="return CustomerSave();">Save changes</button>
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




