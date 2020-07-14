<div class='report list-report'>
<div class='header-report'>
<div class='wrap-cap'>
<div class='cap' style='text-align: center; font-weight: bold;'>Report Rental Car<br/ >Effective Date : <?php echo date('d M Y'); ?>
</div>
</div>
</div>

<div id='grid' class='gridvie'>
<div class='gridview'>
    <div class='cap-table'>&nbsp;</div>

        <table border='1' class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
         <thead>
                    <tr>
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
                    </tr>
                  </thead>
                  <tbody>
                    
                    <?php      
                    if($rentaldata){         
                      foreach($rentaldata as $value){ 

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
                    </tr>
                    
                    <?php
                      }
                    }
                    else{
                    ?>

                    <tr>
                      <td colspan="12" style="text-align: center;">No Data Rental Car</td>
                    </tr>

                    <?php
                    }
                    ?>
                    
                  </tbody>
        </table>
  </div>
</div>
</div>

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

<script>window.print();</script>