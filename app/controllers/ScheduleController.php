<?php 
/**
 * Schedule Page Controller
 * @category  Controller
 */
class ScheduleController extends SecureController{
	/**
     * Load Record Action 
     * $arg1 Field Name
     * $arg2 Field Value 
     * $param $arg1 string
     * $param $arg1 string
     * @return View
     */
	function index($fieldname = null , $fieldvalue = null){
		$db = $this->GetModel();
		$fields = array('schedule.id', 	'schedule.From_To', 	'schedule.departure', 	'schedule.arrival', 	'schedule.mode', 	'buses.id AS buses_id', 	'buses.bus_no', 	'buses.seats_no', 	'buses.bus_type', 	'buses.driver');
		$limit = $this->get_page_limit(MAX_RECORD_COUNT); // return pagination from BaseModel Class e.g array(5,20)
		if(!empty($this->search)){
			$text = $this->search;
			$db->orWhere('schedule.id',"%$text%",'LIKE');
			$db->orWhere('schedule.From_To',"%$text%",'LIKE');
			$db->orWhere('schedule.departure',"%$text%",'LIKE');
			$db->orWhere('schedule.arrival',"%$text%",'LIKE');
			$db->orWhere('schedule.mode',"%$text%",'LIKE');
			$db->orWhere('buses.bus_no',"%$text%",'LIKE');
			$db->orWhere('buses.seats_no',"%$text%",'LIKE');
			$db->orWhere('buses.bus_type',"%$text%",'LIKE');
			$db->orWhere('buses.driver',"%$text%",'LIKE');
		}
		$db->join("buses","schedule.From_To = buses.bus_no","RIGHT");
		if(!empty($this->orderby)){ // when order by request fields (from $_GET param)
			$db->orderBy($this->orderby,$this->ordertype);
		}
		else{
			$db->orderBy('id', ORDER_TYPE);
		}
		if( !empty($fieldname) ){
			$db->where($fieldname , $fieldvalue);
		}
		//page filter command
		$tc = $db->withTotalCount();
		$records = $db->get('schedule', $limit, $fields);
		$data = new stdClass;
		$data->records = $records;
		$data->record_count = count($records);
		$data->total_records = intval($tc->totalCount);
		if($db->getLastError()){
			$this->view->page_error = $db->getLastError();
		}
		$this->view->page_title ="Schedule";
		$this->view->render('schedule/list.php' , $data ,'main_layout.php');
	}
	/**
     * Load csv|json data
     * @return data
     */
	function import_data(){
		if(!empty($_FILES['file'])){
			$finfo = pathinfo($_FILES['file']['name']);
			$ext = strtolower($finfo['extension']);
			if(!in_array($ext , array('csv','json'))){
				set_flash_msg("File format not supported",'danger');
			}
			else{
			$file_path = $_FILES['file']['tmp_name'];
				if(!empty($file_path)){
					$db = $this->GetModel();
					if($ext == 'csv'){
						$options = array('table' => 'schedule', 'fields' => '', 'delimiter' => ',', 'quote' => '"');
						$data = $db->loadCsvData( $file_path , $options , false );
					}
					else{
						$data = $db->loadJsonData( $file_path, 'schedule' , false );
					}
					if($db->getLastError()){
						set_flash_msg($db->getLastError(),'danger');
					}
					else{
						set_flash_msg("Data imported successfully",'success');
					}
				}
				else{
					set_flash_msg("Error uploading file",'success');
				}
			}
		}
		else{
			set_flash_msg("No file selected for upload",'warning');
		}
		$list_page = (!empty($_POST['redirect']) ? $_POST['redirect'] : 'schedule/list');
		redirect_to_page($list_page);
	}
	/**
     * View Record Action 
     * @return View
     */
	function view( $rec_id = null , $value = null){
		$db = $this->GetModel();
		$fields = array( 'schedule.id', 	'schedule.From_To', 	'schedule.departure', 	'schedule.arrival', 	'schedule.mode', 	'buses.id AS buses_id', 	'buses.bus_no', 	'buses.seats_no', 	'buses.bus_type', 	'buses.driver' );
		if( !empty($value) ){
			$db->where($rec_id, urldecode($value));
		}
		else{
			$db->where('schedule.id' , $rec_id);
		}
		$db->join("buses","schedule.From_To = buses.bus_no","RIGHT ");  
		$record = $db->getOne( 'schedule', $fields );
		if(!empty($record)){
			$this->view->page_title ="View  Schedule";
			$this->view->render('schedule/view.php' , $record ,'main_layout.php');
		}
		else{
			if($db->getLastError()){
				$this->view->page_error = $db->getLastError();
			}
			else{
				$this->view->page_error = "Record not found";
			}
			$this->view->render('schedule/view.php' , $record , 'main_layout.php');
		}
	}
	/**
     * Add New Record Action 
     * If Not $_POST Request, Display Add Record Form View
     * @return View
     */
	function add(){
		if(is_post_request()){
			$modeldata = transform_request_data($_POST);
			$rules_array = array(
				'From_To' => 'required',
				'departure' => 'required',
				'arrival' => 'required',
				'mode' => 'required',
			);
			$is_valid = GUMP::is_valid($modeldata, $rules_array);
			if( $is_valid !== true) {
				if(is_array($is_valid)){
					foreach($is_valid as  $error_msg){
						$this->view->page_error[] = $error_msg;
					}
				}
				else{
					$this->view->page_error[] = $is_valid;
				}
			}
			if( empty($this->view->page_error) ){
				$db = $this->GetModel();
				$rec_id = $db->insert( 'schedule' , $modeldata );
				if(!empty($rec_id)){
					set_flash_msg("Record added successfully",'success');
					redirect_to_page("schedule");
					return;
				}
				else{
					if($db->getLastError()){
						$this->view->page_error[] = $db->getLastError();
					}
					else{
						$this->view->page_error[] = "Error inserting record";
					}
				}
			}
		}
		$this->view->page_title ="Add New Schedule";
		$this->view->render('schedule/add.php' ,null,'main_layout.php');
	}
	/**
     * Edit Record Action 
     * If Not $_POST Request, Display Edit Record Form View
     * @return View
     */
	function edit($rec_id=null){
		$db = $this->GetModel();
		if(is_post_request()){
			$modeldata = transform_request_data($_POST);
			$rules_array = array(
				'From_To' => 'required',
				'departure' => 'required',
				'arrival' => 'required',
				'mode' => 'required',
			);
			$is_valid = GUMP::is_valid($modeldata, $rules_array);
			if( $is_valid !== true) {
				if(is_array($is_valid)){
					foreach($is_valid as  $error_msg){
						$this->view->page_error[] = $error_msg;
					}
				}
				else{
					$this->view->page_error[] = $is_valid;
				}
			}
			if(empty($this->view->page_error)){
				$db->where('id' , $rec_id);
				$bool = $db->update('schedule',$modeldata);
				if($bool){
					set_flash_msg("Record updated successfully",'success');
					redirect_to_page("schedule");
					return;
				}
				else{
					$this->view->page_error[] = $db->getLastError();
				}
			}
		}
		$fields = array('id','From_To','departure','arrival','mode');
		$db->where('id' , $rec_id);
		$data = $db->getOne('schedule',$fields);
		$this->view->page_title ="Edit  Schedule";
		if(!empty($data)){
			$this->view->render('schedule/edit.php' , $data, 'main_layout.php');
		}
		else{
			if($db->getLastError()){
				$this->view->page_error[] = $db->getLastError();
			}
			else{
				$this->view->page_error[] = "Record not found";
			}
			$this->view->render('schedule/edit.php' , $data , 'main_layout.php');
		}
	}
	/**
     * Delete Record Action 
     * @return View
     */
	function delete( $rec_ids = null ){
		$db = $this->GetModel();
		$arr_id = explode( ',', $rec_ids );
		foreach( $arr_id as $rec_id ){
			$db->where('id' , $rec_id,"=",'OR');
		}
		$bool = $db->delete( 'schedule' );
		if($bool){
			set_flash_msg("Record deleted successfully",'success');
		}
		else{
			if($db->getLastError()){
				set_flash_msg($db->getLastError(),'danger');
			}
			else{
				set_flash_msg("Error deleting the record. please make sure that the record exit",'danger');
			}
		}
		redirect_to_page("schedule");
	}
}
