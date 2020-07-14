<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Return_model extends CI_Model{

	function ViewGetReturn(){
		return $this->db->query("

								SELECT 	A.ReturnID, A.RentalID, A.ReturnDate, REPLACE(FORMAT(A.LateCharge ,2),'.00','') AS LateCharge, 
										REPLACE(FORMAT(B.TotalRentalFee ,2),'.00','') AS TotalRentalFee, 
										A.Status, C.OrderID, C.CustomerName, D.CarName, D.CarNumber,
                                      	A.IsActive, A.EntryBy, A.EntryDate, A.LastUpdateBy, A.LastUpdateDate 
                                FROM  	T_Return A
                                INNER   JOIN T_Rental B ON A.RentalID=B.RentalID AND B.IsActive = 'Y'
                                INNER   JOIN T_CustomerOrder C ON B.OrderID=C.OrderID
                                INNER   JOIN M_MasterCar D ON B.CarID=D.CarID
                                WHERE   A.IsActive ='Y'

								");
	}	
}

?>