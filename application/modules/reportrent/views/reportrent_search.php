<?php

 if(!empty($keys)){

    $str = "<div class='report list-report'>";
    $str.= "<div class='header-report'>";
    $str.= "<div class='wrap-cap'>";
    $str.= "<a href='".base_url()."reportrent/viewReportRent/print/".urlencode(serialize($keys))."?StartDate=".$StartDate."&EndDate=".$EndDate."' target='/_blank' class='btn btn-info' style='margin-left:10px;'><i class=\"fas fa-fw fa-print\"></i> print</a>";
    $str.= "<a href='".base_url()."reportrent/viewReportRent/export/".urlencode(serialize($keys))."?StartDate=".$StartDate."&EndDate=".$EndDate."' target='_blank' class='btn btn-success' style='margin-left:10px;'><i class=\"fas fa-fw fa-file-excel\"></i> Export</a>";
    if(trim($StartDate) == "" || trim($EndDate) == "")
    {
        $str.= "<div class='cap' style='text-align: center; font-weight: bold;'> Report Rent Car<br/ >Effective Date : ". date('d M Y');
    }
    else
    {
        $str.= "<div class='cap' style='text-align: center; font-weight: bold;'> Report Rent Car<br/ >Effective Date : ".date_format(date_create($StartDate),"d F Y")." - ".date_format(date_create($EndDate),"d F Y"); 
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
    $str.= "<th>RentalID</th>";
    $str.= "<th>CustomerName</th>";
    $str.= "<th>CarName</th>";
    $str.= "<th>CarNumber</th>";
    $str.= "<th>StartDate</th>";
    $str.= "<th>EndDate</th>";
    $str.= "<th>DailyRentalFee</th>";
    $str.= "<th>DriverID</th>";
    $str.= "<th>Driv. RentalFee</th>";
    $str.= "<th>Total</th>";
    $str.= "<th>Status</th>";
    $str.= "<th>ReturnDate</th>";
    $str.= "<th>LateCharge</th>";
    $str.= "</tr>";
    $str.= "</thead>";
    $str.= "<tbody>";

    if(!empty($keys)){
        foreach($keys as $value){ 

        if(trim($value->Status) == "1"){
            $list = "<span class='badge badge-danger'>Active</span>";
        }
        else if(trim($value->Status) == "5"){
            $list = "<span class='badge badge-warning'>onGoing</span>";
        }
        else{
            $list = "<span class='badge badge-success'>Finish</span>";
        }
                            
        $str.= "<tr>";
        $str.= "<td>".$value->RentalID."</td>";
        $str.= "<td>".$value->CustomerName."</td>";
        $str.= "<td>".$value->CarName."</td>";
        $str.= "<td>".$value->CarNumber."</td>";
        $str.= "<td>".$value->StartDate."</td>";
        $str.= "<td>".$value->EndDate."</td>";
        $str.= "<td>".number_format($value->DailyRentalFee)."</td>";
        $str.= "<td>".$value->DriverID."</td>";
        $str.= "<td>".number_format($value->DriverRentalFee)."</td>";
        $str.= "<td>".number_format($value->TotalRentalFee)."</td>";
        $str.= "<td>".$list."</td>";
        $str.= "<td>".$value->ReturnDate."</td>";
        $str.= "<td>".number_format($value->LateCharge)."</td>";
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