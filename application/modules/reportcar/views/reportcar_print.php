<?php

 if(!empty($keys)){

    $str = "<div class='report list-report'>";
    $str.= "<div class='header-report'>";
    $str.= "<div class='wrap-cap'>";
    if(trim($effdate) == "")
    {
        $str.= "<div class='cap' style='text-align: center; font-weight: bold;'> Report Stock Car<br/ >Effective Date : ". date('d M Y');
    }
    else
    {
        $str.= "<div class='cap' style='text-align: center; font-weight: bold;'> Report Stock Car<br/ >Effective Date : ".date_format(date_create($effdate),"d F Y"); 
    }
    $str.= "</div>";
    $str.= "</div>";
    $str.= "</div>";

    $str.= "<div id='grid' class='gridvie'>";
    $str.= "<div class='gridview'>";
    $str.= "<div class='cap-table'>&nbsp;</div>";

    $str.= "<table border='1' class='table table-bordered' id='dataTable' width='100%' cellspacing='0'>";
    $str.= "<thead>";
    $str.= "<tr>";
    $str.= "<th>CarNumber</th>";
    $str.= "<th>CarName</th>";
    $str.= "<th>CarBuyYear</th>";
    $str.= "<th>CarCat</th>";
    $str.= "<th>MerkName</th>";
    $str.= "<th>DailyRentalFee</th>";
    $str.= "<th>Status</th>";
    $str.= "<th>BackDate</th>";
    $str.= "</tr>";
    $str.= "</thead>";
    $str.= "<tbody>";

    if(!empty($keys)){
        foreach($keys as $value){ 

        if(trim($value->Status) == "Ongoing"){
            $list = "<span class='badge badge-warning'>Ongoing</span>";
        }
        else if(trim($value->Status) == "Available"){
            $list = "<span class='badge badge-success'>Available</span>";
        }
        else{
            $list = "<span class='badge badge-danger'>Finish</span>";
        }
                            
        $str.= "<tr>";
        $str.= "<td>".$value->CarNumber."</td>";
        $str.= "<td>".$value->CarName."</td>";
        $str.= "<td>".$value->CarBuyYear."</td>";
        $str.= "<td>".$value->CarCat."</td>";
        $str.= "<td>".$value->MerkName."</td>";
        $str.= "<td style='text-align:right;'>Rp. ".number_format($value->DailyRentalFee)."</td>";
        $str.= "<td>".$list."</td>";
        $str.= "<td>".$value->EndDate."</td>";
        $str.= "</tr>";
                            
        
        }
    }
    else{
        $str.= "<tr>";
        $str.= "<td colspan='6'>No Record Data</td>";
        $str.= "</tr>";
    }
                        
                        
    $str.= "</tbody>";
    $str.= "</table>";
    $str.= "</div>";
    $str.= "</div>";
    $str.= "</div>";

    echo $str;


}

?>

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