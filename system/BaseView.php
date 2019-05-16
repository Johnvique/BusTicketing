<?php 
	defined('ROOT') OR exit('No direct script access allowed');

	/**
	* Application Base View
	*/
	class BaseView{
		/**
	     * Data Passed From Controller to the View
	     * Can Be Access By All Other Sub View in The Page
	     * @var  object
	     */
		public $model=null;
		
		
		/**
	     * Render Page In Following Format [html | json | xml]
		 * Can Be Pass Via Query String
	     * @var  object
	     */
		public $format="html";

		/**
	     * Set Page Title From The Controller
	     * @var string
	     */
		public $page_title=null;
		
		/**
	     * View Title
	     * @var Booolean
	     */
		public $view_title = null;
		
		/**
	     * Model Data passed From Controller to The View
	     * @var string
	     */
		 
		public $redirect_to = null;
		
		/**
	     * Model Data passed From Controller to The View
	     * @var string
	     */
		public $view_data=null;
		
		/**
	     * Page Properties passed from other Views to The current page
	     * @var string
	     */
		public $page_props = null;
		
		/**
	     * Show Page Header Component
	     * @var string
	     */
		public $show_header = true;
		
		/**
	     * Show Page Footer Components
	     * @var string
	     */
		public $show_footer = true;
		
		/**
	     * Show Search Control
	     * @var Booolean
	     */
		public $show_search = true;
		
		/**
	     * Show Edit Record Button
	     * @var Booolean
	     */
		public $show_edit_btn = true;
		
		/**
	     * Show View Record Button
	     * @var Booolean
	     */
		public $show_view_btn = true;
		
		/**
	     * Show Delete Button Component
	     * @var Booolean
	     */
		public $show_delete_btn = true;
		
		/**
	     * Show Delete All Button 
	     * @var Booolean
	     */
		public $show_multi_delete_btn = true;
		
		/**
	     * Include Import Records Button
	     * @var Booolean
	     */
		public $show_import_btn = true;
		
		/**
	     * Include Export Button
	     * @var Booolean
	     */
		public $show_export_btn = true;
		
		/**
	     * Show Record Selection Checkbox
	     * @var Booolean
	     */
		public $show_checkbox = true;
		
		/**
	     * Show Record List Number
	     * @var Booolean
	     */
		public $show_list_sequence = true;
		
		
		/**
	     * Show Pagination Component
	     * @var Booolean
	     */
		public $show_pagination = true;
		
		/**
	     * Other Data passed From Controller to The View
	     * @var string
	     */
		public $view_name=null;


		/**
	     * Page Error Passed From Controller to The View
	     * @var string
	     */
		public $page_error = null;

		/**
	     * Form Validation Error Passed From Controller to The View
	     * @var string
	     */
		public $form_error = null;

		/**
	     * Whether to Render View as a Partial View Without The Layout
	     * @var boolean
	     */
		public $is_partial_view=false;

		/**
	     * The Relative Path of Partial View File
	     * @var string
	     */
		public $partial_view=null;
		
		/**
	     * The Relative Path of Partial View File
	     * @var string
	     */
		public $force_layout=null;
		
		
		function __construct($arg=null){
			// Pass All Query String Data to the View.
			$q=$_GET;
			if(!empty($q)){
				foreach($q as $obj=>$val){
					$this->$obj=$val;
				}
			}
		}

		/**
	     * Render Main Page From The Controller 
	     * @return null
	     */
		public function render($view_name=null,$view_data=null,$layout=null){
			$this->view_name=$view_name;
			
			//pass data from controller unto the view.
			$this->view_data=$view_data;
			
			
			
			
			if(is_ajax()){
				include (LAYOUTS_DIR . "ajax_layout.php");
			}
			elseif(!empty($layout) && $this->is_partial_view==false){
				
				//If force_layout is set then use the layout.
				if(!empty($this->force_layout)){
					$layout=$this->force_layout;
				}
				
				if(file_exists(LAYOUTS_DIR . $layout)){
					include (LAYOUTS_DIR . $layout);
				}
				else{
					echo "The Layout Does not Exit;";
				}
			}
			else{
				/* //Do not Include Layout if Render as a Partial View in another View
					use the partial_view if it's set
					Get View name from current page url if not passed from controller 
				*/
				
                if(!empty($this->partial_view)){		
                    $view_name=$this->partial_view;
                }
				else if(empty($view_name)){				
					 $view_name=Router :: $page_name . "/" . Router :: $page_action . ".php";
				}
                
                if(file_exists(PAGES_DIR . $view_name)){
                    include (PAGES_DIR . $view_name);
                }
                else{
                    print_r($view_name) ;
                }
			}
		}
		
		
		/**
	     * Render Main Page From The Controller onto the Layout
	     * @return null
	     */
		protected function render_body(){
			$view=PAGES_DIR . $this->view_name;
			if(file_exists($view)){
				include($view);
			}
			else{
				echo "$view File Not Found";
			}
		}

		/**
	     * Include View Onto A Page as A Partial View 
	     * @example $this->load_view("components/bar_chart.php");
	     * @return null
	     */
		protected function render_view($viewname , $args=null){
			$this->view_args=$args;
			$view=PAGES_DIR . $viewname;
			if(file_exists($view)){
				include($view);
			}
			else{
				echo "$view File  Not Found";
			}
		}
		
		
		/**
	     * Render Page as a Partial View Onto Another Page Using Url Parameters
	     * @example call inside any view or layout 
		 * $this->render_page("users/index/status/active/?limit_start=1&limit_count=5&orderby=user_id&ordertype=desc");
	     * @return null
	     */
		
		protected function render_page($url, $page_props = null , $view_path=null){
			
			$qs = parse_url($url,PHP_URL_QUERY);
			parse_str($qs,$get);
			$_GET=array();
			if(!empty($get)){ //build new $_GET array from query string
				foreach($get as $key=>$val){
					$_GET[$key]=$val;
				}
			}
			
			$path=parse_url($url,PHP_URL_PATH); // Get Path from URL
			
			//Dispatch as new page
			$r=new Router;
			
			$r->is_partial_view = true;
			$r->page_props = $page_props;
			$r->partial_view = $view_path;
			$r->run($path);
			
		}
		
		public function set_field_value($fieldname , $default_value=null,$index=null){
			if(!empty($this->page_props[$fieldname])){
				return $this->page_props[$fieldname];
			}
			elseif(!empty($_REQUEST[$fieldname])){
				if($index===null){
					return $_REQUEST[$fieldname];
				}
				else{
					return $_REQUEST["row$index"][$fieldname];
				}
			}
			else{
				return $default_value;
			}
		}
		
		/**
		 * Get Form Radio || Checkbox Value On POST BACK
		 * @example <input type="radio" <?php echo get_form_field_checked('gender','Male'); ?> />
		 * @return  string
		 */
		function set_field_checked($fieldname,$value,$index=0){
			$req_val = null;
			if(!empty($this->page_props[$fieldname])){
				$req_val = $this->page_props[$fieldname];
			}
			elseif(!empty($_REQUEST[$fieldname])){
				$req_val = $_REQUEST[$fieldname];
			}
			if(!empty($req_val)){
				if(is_array($req_val)){
					return (in_array($value, $req_val) ? 'checked' : null);
				}
				elseif($req_val == $value){
					return "checked";
				}
			}
			return null;
		}
		
		/**
		 * Get Form Radio || Checkbox Value On POST BACK
		 * @example <input type="radio" <?php echo get_form_field_checked('gender','Male'); ?> />
		 * @return  string
		 */
		function set_field_selected($fieldname,$value,$index=0){
			$req_val = null;
			if(!empty($this->page_props[$fieldname])){
				$req_val = $this->page_props[$fieldname];
			}
			elseif(!empty($_REQUEST[$fieldname])){
				$req_val = $_REQUEST[$fieldname];
			}
			if(!empty($this->page_props[$fieldname])){
				$req_val = $this->page_props[$fieldname];
			}
			
			if(!empty($req_val)){
				if(is_array($req_val)){
					return (in_array($value, $req_val) ? 'selected' : null);
				}
				elseif($req_val == $value){
					return "selected";
				}
			}
			return null;
		}
		
		/**
		 * Display Html Head Title
		 * Set Title From Url If Present
		 * @return Html
		 */
		function get_page_title($title = null){
			//title passed to the page view
			if(!empty($this->page_title)){
				$title = $this->page_title;
			}
			else{
				$title = Router :: $page_name . " " . Router :: $page_action;
			}
			return $title;
		}
		
		public function display_page_errors(){
			$page_errors = $this->page_error;
			if(!empty($page_errors)){
				if(!is_array($page_errors)){
					?>
						<div class="alert alert-danger animated shake">
							<?php echo $page_errors; ?>
						</div>
					<?php
				}
				else{
					foreach($page_errors as $error){
						?>
							<div class="alert alert-danger animated shake">
								<?php echo $error; ?>
							</div>
						<?php
					}
				}
			}
		}
	
		
	}