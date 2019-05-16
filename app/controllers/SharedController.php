<?php 

/**
 * SharedController Controller
 * @category  Controller / Model
 */
class SharedController extends BaseController{
	
	/**
     * reservations_bus_option_list Model Action
     * @return array
     */
	function reservations_bus_option_list(){
		$db = $this->GetModel();
		$sqltext = "SELECT  DISTINCT bus_no AS value,bus_no AS label FROM buses ORDER BY id ASC";
		$arr = $db->rawQuery($sqltext);
		return $arr;
	}

	/**
     * complains_booking_id_option_list Model Action
     * @return array
     */
	function complains_booking_id_option_list(){
		$db = $this->GetModel();
		$sqltext = "SELECT  DISTINCT boking_id AS value,boking_id AS label FROM payments ORDER BY boking_id ASC";
		$arr = $db->rawQuery($sqltext);
		return $arr;
	}

	/**
     * complains_driver_option_list Model Action
     * @return array
     */
	function complains_driver_option_list(){
		$db = $this->GetModel();
		$sqltext = "SELECT  DISTINCT driver AS value,driver AS label FROM buses ORDER BY id ASC";
		$arr = $db->rawQuery($sqltext);
		return $arr;
	}

	/**
     * complains_bus_no_option_list Model Action
     * @return array
     */
	function complains_bus_no_option_list(){
		$db = $this->GetModel();
		$sqltext = "SELECT  DISTINCT bus_no AS value,bus_no AS label FROM buses ORDER BY id ASC";
		$arr = $db->rawQuery($sqltext);
		return $arr;
	}

	/**
     * complainsbus_no_list Model Action
     * @return array
     */
	function complainsbus_no_list(){
		$db = $this->GetModel();
		$sqltext = "SELECT bus_no , bus_no ,   COUNT(*) AS num FROM complains GROUP BY bus_no ORDER BY id LIMIT 4";
		$arr = $db->rawQuery($sqltext);
		return $arr;
	}

	/**
     * reservationsyour_name_list Model Action
     * @return array
     */
	function reservationsyour_name_list(){
		$db = $this->GetModel();
		$sqltext = "SELECT your_name , your_name ,   COUNT(*) AS num FROM reservations GROUP BY your_name LIMIT 4";
		$arr = $db->rawQuery($sqltext);
		return $arr;
	}

	/**
     * getcount_buses Model Action
     * @return Value
     */
	function getcount_buses(){
		$db = $this->GetModel();
		$sqltext = "SELECT COUNT(*) AS num FROM buses";
		$arr = $db->rawQueryValue($sqltext);
		return $arr[0];
	}

	/**
     * getcount_routes Model Action
     * @return Value
     */
	function getcount_routes(){
		$db = $this->GetModel();
		$sqltext = "SELECT COUNT(*) AS num FROM routes";
		$arr = $db->rawQueryValue($sqltext);
		return $arr[0];
	}

	/**
     * getcount_schedule Model Action
     * @return Value
     */
	function getcount_schedule(){
		$db = $this->GetModel();
		$sqltext = "SELECT COUNT(*) AS num FROM schedule";
		$arr = $db->rawQueryValue($sqltext);
		return $arr[0];
	}

	/**
     * getcount_employees Model Action
     * @return Value
     */
	function getcount_employees(){
		$db = $this->GetModel();
		$sqltext = "SELECT COUNT(*) AS num FROM employees";
		$arr = $db->rawQueryValue($sqltext);
		return $arr[0];
	}

	/**
     * getcount_customers Model Action
     * @return Value
     */
	function getcount_customers(){
		$db = $this->GetModel();
		$sqltext = "SELECT COUNT(*) AS num FROM customers";
		$arr = $db->rawQueryValue($sqltext);
		return $arr[0];
	}

	/**
     * getcount_complains Model Action
     * @return Value
     */
	function getcount_complains(){
		$db = $this->GetModel();
		$sqltext = "SELECT COUNT(*) AS num FROM complains";
		$arr = $db->rawQueryValue($sqltext);
		return $arr[0];
	}

	/**
     * getcount_payments Model Action
     * @return Value
     */
	function getcount_payments(){
		$db = $this->GetModel();
		$sqltext = "SELECT COUNT(*) AS num FROM payments";
		$arr = $db->rawQueryValue($sqltext);
		return $arr[0];
	}

	/**
     * getcount_reservations Model Action
     * @return Value
     */
	function getcount_reservations(){
		$db = $this->GetModel();
		$sqltext = "SELECT COUNT(*) AS num FROM reservations";
		$arr = $db->rawQueryValue($sqltext);
		return $arr[0];
	}

	/**
	* doughnutchart_payments Model Action
	* @return array
	*/
	function doughnutchart_payments(){
		
		$db = $this->GetModel();
		$arr = array();
		
		$dataset1 = $db->rawQuery("SELECT  p.id, p.boking_id, p.date, p.transaction_no, p.status FROM payments AS p");
		$arr['labels']=array_map(function($var){ return $var['id']; }, $dataset1);
		
		$arr['datasets'][] = array_map(function($var){ return $var['boking_id']; }, $dataset1);
		return $arr;
	}

	/**
     * scheduleFrom_To_list Model Action
     * @return array
     */
	function scheduleFrom_To_list(){
		$db = $this->GetModel();
		$sqltext = "SELECT From_To , From_To ,   COUNT(*) AS num FROM schedule GROUP BY From_To LIMIT 4";
		$arr = $db->rawQuery($sqltext);
		return $arr;
	}

	/**
     * busesbus_no_list Model Action
     * @return array
     */
	function busesbus_no_list(){
		$db = $this->GetModel();
		$sqltext = "SELECT bus_no , bus_no ,   COUNT(*) AS num FROM buses GROUP BY bus_no LIMIT 4";
		$arr = $db->rawQuery($sqltext);
		return $arr;
	}

}
