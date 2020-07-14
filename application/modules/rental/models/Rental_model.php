<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Rental_model extends CI_Model{

	function ViewGetRental(){
		//return $this->db->get('T_Rental');

		return $this->db->query("
							   SELECT  A.RentalID, A.OrderID, B.CustomerName, A.CarID, C.CarName, C.CarNumber,
                                       A.StartDate, A.EndDate, REPLACE(FORMAT(A.RentalCosts ,2),'.00','') as RentalCosts, 
                                       A.PaymentID, A.DriverID, D.DriverName,
                                       REPLACE(FORMAT(A.DriverRentalFee ,2),'.00','') AS DriverRentalFee, 
                                       REPLACE(FORMAT(A.TotalRentalFee ,2),'.00','') AS TotalRentalFee, 
                                       A.Status, A.IsActive, C.DailyRentalFines, 
                                       D.DailyDrivingCosts, C.CarNumber, A.EntryDate, A.EntryBy, A.LastUpdateDate, A.LastUpdateBy 
                               FROM    T_Rental A 
                               INNER   JOIN T_CustomerOrder B ON A.OrderID=B.OrderID
                               INNER   JOIN M_MasterCar C ON A.CarID = C.CarID
                               LEFT    JOIN M_MasterDriver D ON A.DriverID = D.DriverID
                               WHERE   A.IsActive ='Y'
						");
		//return $cari->result();
	}	
}

?>