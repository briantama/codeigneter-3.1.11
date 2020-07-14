<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');



function cleans($data, $pil) {
	//return mysql_real_escape_string 
	//return mysql_real_escape_string($data->$pil);
}

function getRptCar($qry){
    
    $str = "<div class='report list-report'>";
    $str.= "<div class='header-report'>";
    $str.= "<div class='wrap-cap'>";
    $str.= "<div class='cap' style='text-align: center; font-weight: bold;'> Report Car<br/ >Effective Date : ". date('d M Y');
    $str.= "</div>";
    $str.= "</div>";
    $str.= "</div>";

    $str.= "<div id='grid' class='gridvie'>";
    $str.= "<div class='gridview'>";
    $str.= "<div class='cap-table'>&nbsp;</div>";

    $str.= "<table border='1' class='table table-bordered' id='dataTable' width='100%' cellspacing='0'>";
    $str.= "<thead>";
    $str.= "<tr>";
    $str.= "<th>CarID</th>";
    $str.= "<th>CarName</th>";
    $str.= "<th>CarBuyYear</th>";
    $str.= "<th>MerkID</th>";
    $str.= "<th>MerkName</th>";
    $str.= "<th>BackDate</th>";
    $str.= "<th>Status</th>";
    $str.= "</tr>";
    $str.= "</thead>";
    $str.= "<tbody>";

    foreach($qry as $value){ 
                        
    $str.= "<tr>";
    $str.= "<td>".$value->CarID."</td>";
    $str.= "<td>".$value->CarName."</td>";
    $str.= "<td>".$value->CarBuyYear."</td>";
    $str.= "<td>".$value->MerkID."</td>";
    $str.= "<td>".$value->MerkName."</td>";
    $str.= "<td>".$value->BackDate."</td>";
    $str.= "<td>".$value->Status."</td>";
    $str.= "</tr>";
                        
    
    }
                        
                        
    $str.= "</tbody>";
    $str.= "</table>";
    $str.= "</div>";
    $str.= "</div>";
    $str.= "</div>";

    return $str;

  }


