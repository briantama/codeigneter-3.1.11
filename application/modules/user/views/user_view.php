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
              <?php 
              if(trim($this->session->userdata('supuser')) == "Y" ){
              ?>
              <a href="#" onclick="return getUser(0);" class="btn btn-primary"><i class="fas fa-plus"></i> Add</a>
              <?php
              }
              ?>
              <a href="<?php echo base_url('user/viewUser/print'); ?>" target="_BLANK" class="btn btn-success"><i class="fas fa-print"></i> Print</a>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <div class="table-responsive">
              <table id="datatablex" class="table table-bordered table-striped">
                <thead>
                    <tr>
                      <th>Edit</th>
                      <th>AdminID</th>
                      <th>AdminName</th>
                      <th>DateOfBirth</th>
                      <th>email</th>
                      <th>SuperUser</th>
                      <th>IsActive</th>
                      <th>EntryDate</th>
                      <th>EntryBy</th>
                      <th>LastUpdateDate</th>
                      <th>LastUpdateBy</th>
                    </tr>
                  </thead>
                  <tfoot>
                    <tr>
                      <th>Edit</th>
                      <th>AdminID</th>
                      <th>AdminName</th>
                      <th>DateOfBirth</th>
                      <th>email</th>
                      <th>SuperUser</th>
                      <th>IsActive</th>
                      <th>EntryDate</th>
                      <th>EntryBy</th>
                      <th>LastUpdateDate</th>
                      <th>LastUpdateBy</th>
                    </tr>
                  </tfoot>
                  <tbody>
                    
                    <?php               
                    foreach($user as $value){ 
                    ?>
                    
                    <tr>
                      <td nowrap>
                          <a href="#" class="btn btn-warning" onclick="return getUser('<?php echo $value->AdminID?>');" title="Edit"><i class="fas fa-fw fa-edit"></i> </a>
                          <a href="#" class="btn btn-danger" onclick="return UserDelete('<?php echo $value->AdminID?>');" title="Delete"><i class="fas fa-fw fa-trash"></i> </a>
                      </td>
                      <td><?php echo $value->AdminID ?></td>
                      <td><?php echo $value->AdminName ?></td>
                      <td><?php echo $value->DateOfBirth ?></td>
                      <td><?php echo $value->email ?></td>
                      <td><?php echo $value->SuperUser ?></td>
                      <td><?php echo $value->IsActive ?></td>
                      <td><?php echo $value->EntryDate ?></td>
                      <td><?php echo $value->EntryBy ?></td>
                      <td><?php echo $value->LastUpdateDate ?></td>
                      <td><?php echo $value->LastUpdateBy ?></td>
                    </tr>
                    
                    <?php
                    }
                    ?>
                    
                  </tbody>  
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
  <div class="modal fade" id="addformuser" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog modal-xl" role="document">
          <div class="modal-content" id="blokformuser">
            <div class="modal-header bg-primary">
              <h4 class="modal-title">Form User</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <form method="post" action="" name="f_user" id="f_user" enctype="multipart/form-data">
              <div id="notif-user"></div>
              <input type="hidden" name="id" id="id" value="0">
              <div class="table-responsive">
              <table class="table table-form" style="overflow:auto;">
                <tr><td style="width: 25%">Name *</td><td style="width: 75%"><input class="form-control" id="nama" name="nama" maxlength="100" type="text" required /></td></tr>
                <tr><td style="width: 25%">DateOfBirth *</td><td style="width: 75%"><input class="form-control" id="birthday" name="birthday" type="text" required /></td></tr>
                <tr><td style="width: 25%">Email *</td><td style="width: 75%"><input class="form-control" id="email" name="email" maxlength="100" type="email" required /></td></tr>
                <tr><td style="width: 25%">UserName *</td><td style="width: 75%"><input class="form-control" id="username" name="username" maxlength="100" type="text" required /></td></tr>
                <tr><td style="width: 25%">Password *</td><td style="width: 75%"><input class="form-control" id="password" name="password" maxlength="20" type="password" required /></td></tr>
                <tr><td style="width: 25%">Re-Password *</td><td style="width: 75%"><input class="form-control" id="repassword" name="repassword" maxlength="20" type="password" required /></td></tr>
                <tr><td style="width: 25%">SuperUser *</td>
                    <td style="width: 75%">
                       <select name="supuser" id="supuser" class="form-control">
                            <option value="N">No</option>
                            <?php 
                            if(trim($this->session->userdata('supuser')) == "Y" ){
                            ?>
                            <option value="Y">Yes</option>
                            <?php
                            }
                            ?>
                        </select>
                    </td></tr>

              </table>
            </div>

            </div>
            <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
              <button type="button" class="btn btn-primary" onclick="return UserSave();">Save changes</button>
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

 $('#birthday').datepicker({
    format: "yyyy-mm-dd",
    todayHighlight: true,
    orientation: "bottom auto",
    autoclose:true
});

</script>


