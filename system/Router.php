<?php
/**
 *  Router Class
 *	users/ OR users/index/
 *	users/id OR users/view/id
 *  users/index/field/value  OR users/field/value
 *  users/index/field/value/.../.../
 *  users/edit/id
 *  users/delete/id
 * @category  URL
 */
class Router{
	/**
     * Get The Current Page Name
     * @var string
     */
	public static $page_name=null;

	/**
     *	Get The Current Page Action
     * @var string
     */
	public static $page_action=null;

	/**
     * Get The Current Page Id If Available
     * @var string
     */
	public static $page_id=null;

	/**
     * Get The Current Page Field Name Or Category If Available
     * @var string
     */
	public static $field_name=null;

	/**
     * Get The Current Page Field Value If Available
     * @var string
     */
	public static $field_value=null;

	/**
     * Get The Current Page Full URL Relative Path
     * @var string
     */
	public static $page_url=null;

	/**
     * Get The Current Page Controller Name
     * @var string
     */
	public static $controller_name=null;
	
	/**
     * Get The Current Page Controller Name
     * @var string
     */
	public $is_partial_view=false;
	
	public $page_props = null;
	
	/**
     * The Layout file that will be use to render the page
	 * Overrides the default  page layout
     * @var string
     */
	public $force_layout=null;
	
	
	/**
     * Get The Current Page Controller Name
     * @var string
     */
	public $partial_view=null;
	

	
	/**
     * Start page Dispatch From Current URl
     * @var string
     */
	function init(){

		$basepath = implode('/', array_slice(explode('/', $_SERVER['SCRIPT_NAME']), 0, -1)) . '/';
		
		// for now, we are only interested with the path only.
		$page_url  = substr($_SERVER['REQUEST_URI'], strlen($basepath)); 
		$path = parse_url( $page_url, PHP_URL_PATH );
		
		if(!empty( $path )){
			$this->run( $path );
		}
		else{
			self::$page_name = DEFAULT_PAGE;
			self::$page_action = DEFAULT_PAGE_ACTION;
			
			$controller_name = ucfirst(DEFAULT_PAGE)."Controller";
			$controller = new IndexController;
			$controller->{DEFAULT_PAGE_ACTION}(); 
		}
	}
	
	
	
	/**
     * Dispatch Page Based on The Url
     * Can Be Use TO Dispatch Any Page
     * @var string
     */
	function run($url){
		
		self :: $page_url = $url;
		
		$url_segment = array_map('urldecode' , explode("/" , rtrim( $url , "/" ) ) );

		$part1=strtolower(!empty($url_segment[0]) ? $url_segment[0] : DEFAULT_PAGE);
		$part2=strtolower((!empty($url_segment[1]) ? $url_segment[1] : null));
		$part3=(!empty($url_segment[2]) ? $url_segment[2] : null);
		$part4=(!empty($url_segment[3]) ? $url_segment[3] : null);
		
		
		//if link action name is 'list' then change it to index [e.g (users/list) >>  (users/index)]
		if ($part2=="list"){
			$part2="index";
		}
		
		// all controller class name must start with capital letter
		$controller_name=ucfirst($part1)."Controller";
		
		if(class_exists($controller_name,true)){
			$controller = new $controller_name;
			
			// all action name should be in lower case
			
			$page=$part1;
			$action="index";
			$args=array();
			$field=null;
			$field_value=null;
			$args=array();
			
			
			if(!empty($part4)){				//when url like  page/action/field/value
				$action=$part2;
				$field=$part3;
				$field_value=$part4;
				$args=array_slice($url_segment,2);
				
				if(!method_exists($controller,$action)){
					$this->page_not_found("$action Action  Was  Not Found In $controller_name");
				}
			}
			
			elseif(!empty($part3)){
				$action=$part2;
				$page_id=$part3;
				if(!method_exists($controller,$action)){	
					// when url like page/view/3 and 'view' or 'edit' page does not exit
					if(($action=="view" || $action=="edit")){ 
						$this->page_not_found("$action Action  Was  Not Found In $controller_name");
					}
					else{									//when url like  page/field/value
						$field=$part2;
						$field_value=$part3;
						$args=array_slice($url_segment,1);
						$action="index";
						if(!method_exists($controller,$action)){
							$this->page_not_found("$action Action  Was  Not Found In $controller_name");
						}
					}
				}
				else{										//when url like  page/action/pageid
					$args=array_slice($url_segment,2);
					$action=$part2;
				}
			}
			elseif(!empty($part2)){			
				if(!method_exists($controller,$part2)){		//when url like  page/pageid
					$args=array_slice($url_segment,1);
					$action="view";
					if(!method_exists($controller,$action)){
						$this->page_not_found("$action Action  Was  Not Found In $controller_name");
					}
				}
				else{										//when url like  page/action
					$args=array();
					$action=$part2;
				}
			}
			
			$page_id=(!empty($args[0]) ? $args[0] : null );
			
			
			// Set Router Page Variables. They can be accessed by calling Router :: $page_variable_name
			self::$page_name = $page;
			
			self::$page_action = $action;
			self::$page_id = $page_id;
			
			self::$field_name=$field;
			self::$field_value=$field_value;
			
			self::$controller_name=$controller_name;

			if($this->is_partial_view == true){
				
				//if set as partial_view	will display the page without the layout
				$controller->view->is_partial_view = $this->is_partial_view;
				
				if(!empty($this->page_props) && is_array($this->page_props)){
					foreach($this->page_props as $key => $val){
						$controller->view->$key = $val;
					}
				}
				
				$controller->view->page_props = $this->page_props;
				$controller->view->partial_view = $this->partial_view;
			}
			
			
			// use the force layout when force layout is set
			$controller->view->force_layout = $this->force_layout;
			
			
			// Initialize Controller Class And Pass All Arguments to the Controller Action
			call_user_func_array(array($controller,$action),$args);
		}
		else{
			if($this->is_partial_view==true){
				echo "<div class='alert alert-danger'><b>$controller_name</b> Was  Not Found In Controller Directory. <b>Please Check </b>" . CONTROLLERS_DIR."</div>";
			}
			else{
				$this->page_not_found("<b>$controller_name</b> Was  Not Found In Controller Directory. <b>Please Check </b>" . CONTROLLERS_DIR);
			}
		}
	}
	
	
	
	/**
     * Return the current page name
     */
	public static function get_page_name(){
		return (!empty(self :: $page_name) ? self :: $page_name : 'index' );
	}
	
	/**
     * Return the current page action
     */
	public static function get_page_action(){
		
		return (!empty(self :: $page_action) ? self :: $page_action : 'index' );
	}
	
	/**
     * Return the current page action
     */
	public static function get_page_id(){
		return (!empty(self :: $page_id) ? self :: $page_id : null );
	}
	
	/**
     * Return the current 3rd url part as page field name
     */
	public static function get_page_field_name(){
		return (!empty(self :: $field_name) ? self :: $field_name : null );
	}
	
	/**
     * Return the current 4th url part as page field value
     */
	public static function get_page_field_value(){
		return (!empty(self :: $field_value) ? self :: $field_value : null );
	}
	
	
	/**
     * Display Error Page When Page Or Page Action Not Found
     * @var string
     */
	function page_not_found($msg="We are sorry, the page you've requested is not available"){
		$view =new BaseView();
		$view->render("errors/error_404.php",$msg,"info_layout.php");
		exit;
	}
}