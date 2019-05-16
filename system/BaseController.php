<?php 
defined('ROOT') OR exit('No direct script access allowed');

/**
* Application Base Controller 
* Controllers Which Do Not Need Authentication Inherit From This Class
*/
class BaseController{
	
	public $view=null;
	public $db=null;
	public $page_num=1;
	public $limit_start=1;
	public $limit_count=MAX_RECORD_COUNT;
	public $orderby=null;
	public $ordertype=ORDER_TYPE;
	public $search=null;
	
	function __construct(){
		$this->view=new BaseView;
		$q=$_GET;
		if(!empty($q)){
			foreach($q as $obj=>$val){
				$this->$obj=$val;
			}	
		}
		if(empty($this->limit_start)){
			$this->limit_start=1;
		}
		$this->page_num=$this->limit_start;
		$this->limit_start=($this->limit_start-1) * $this->limit_count;
	}
	
	function GetModel($arg=null){
		//Initialse New Database Connection
		return new PDODb(DB_TYPE, DB_HOST , DB_USERNAME, DB_PASSWORD, DB_NAME, DB_PORT , DB_CHARSET);
	}
	
	
	/**
	 * Set Current Page Start and Page Count
	 * $page_count Set Max Record to retrive per page
	 * $fieldvalue Table Field Value 
	 * @return array(limit_start,limit_count)
	 */
	function get_page_limit($page_count = MAX_RECORD_COUNT){
		
		if(!empty($_GET['limit_count'])){ //Get page limit from query string request if available
		
			 /*Set limit to high number to get all records. starting from the current position */
			 
			if($_GET['limit_count'] == -1){
				$this->limit_count=1000000000;
			}
			else{
				$this->limit_count=$_GET['limit_count'];
			}
		}
		else{
			$this->limit_count=$page_count;
			//$_GET['limit_count']=$page_count;
		}
		
		return array($this->limit_start,$this->limit_count);
	}
}

/**
* Controllers Which Needs Authentication And Access Control Can Extends To This Class
*/
class SecureController extends BaseController{
	function __construct(){
		parent::__construct();
		
		// Page actions which do not require authentication.
		$exclude_pages = array();
		
		$url = Router :: $page_url;
		$url = str_ireplace('/index','/list',$url);
		
		if(!empty($url)){
			$url_segment =$url_segment = explode("/" , rtrim($url , "/")) ;
			
			$controller = strtolower(!empty($url_segment[0]) ? $url_segment[0] : null);
			$action = strtolower((!empty($url_segment[1]) ? $url_segment[1] : 'list'));
			
			$page = "$controller/$action";
			
			if( !in_array($page , $exclude_pages )){
				authenticate_user(); // Authenticate user And Authorise User
			}
		}
		
	}
}