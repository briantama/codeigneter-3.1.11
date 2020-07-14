
<?php

 header("Content-type: application/vnd-ms-excel");
 header("Content-Disposition: attachment; filename=$filenm.xls");
 header("Pragma: no-cache");
 header("Expires: 0");

?>


<div class='report list-report'>
<div class='header-report'>
<div class='wrap-cap'>
<div class='cap' style='text-align: center; font-weight: bold;'>Report Customer<br/ >Effective Date : <?php echo date('d M Y'); ?>
</div>
</div>
</div>

<div id='grid' class='gridvie'>
<div class='gridview'>
    <div class='cap-table'>&nbsp;</div>

        <table border='1' class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
         <thead>
                    <tr>
                      <th>Cust. ID</th>
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
                    if($custdata){           
                      foreach($custdata as $value){ 
                    ?>
                    
                    <tr>
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
                    }
                    else{
                    ?>

                    <tr>
                      <td colspan="14" style="text-align: center;">No Data Customer</td>
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
