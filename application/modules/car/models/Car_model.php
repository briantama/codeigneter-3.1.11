<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Car_model extends CI_Model{

	function ViewGetCar(){
		return $this->db->query("
									SELECT A.CarID, A.CarName, A.CarCat, A.CarNumber, A.CarSeat, A.CarBuyYear, A.MerkID, B.MerkName,
                                     	   REPLACE(FORMAT(A.DailyRentalFee ,2),'.00','') AS DailyRentalFee, 
                                     	   REPLACE(FORMAT(A.DailyRentalFines ,2),'.00','') AS DailyRentalFines, 
                                     	   A.CarImage, A.IsActive, A.EntryDate, A.EntryBy, A.LastUpdateDate, A.LastUpdateBy
                                    FROM   M_MasterCar A
                                    INNER  JOIN M_MasterMerk B ON A.MerkID=B.MerkID
								");
	}	
}

?>