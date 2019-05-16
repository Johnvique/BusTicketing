<?php
	/**
	 * Public Functions Specific for this Framework
	 * @category  General
	 */


	/**
     * Get Logged In User Details From The Session
	 * @param $field Get particular field value of the active user  otherwise return array of active user fields 
     * @return string | array
     */
	function get_active_user($field=null){
		if(!empty($field)){
			$user_data=get_session('user_data');
			return $user_data[$field];
		}
		else{
			return get_session('user_data');
		}
	}
	
	function slugify($text){
	  // replace non letter or digits by -
	  $text = preg_replace('~[^\pL\d]+~u', '-', $text);

	  // transliterate
	  $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);

	  // remove unwanted characters
	  $text = preg_replace('~[^-\w]+~', '', $text);

	  // trim
	  $text = trim($text, '-');

	  // remove duplicate -
	  $text = preg_replace('~-+~', '-', $text);

	  // lowercase
	  $text = strtolower($text);
	  return $text;
	}
	
	
	/**
     * Get The Current Request Method
     * @example (post,get,put,delete,...)
     * @return string
     */
	function request_method(){
		return strtolower($_SERVER['REQUEST_METHOD']);
	}
	
	/**
     * Get The Current Request Method
     * @example (post,get,put,delete,...)
     * @return string
     */
	 
	function is_post_request(){
		return (request_method()=='post');
	}
	
	
	
	
	/**
     * Dispatch Content in JSON Formart
	 * @param $data Data to be Output
	 * @param $errors Errors If Any
	 * @param $status Html Request Status
     * @return JSON String
     */
	
	function render_json( $data, $status='ok' ){
		header('Content-type: application/json; charset=utf-8');
		echo json_encode($data);
		exit;
	}
	
	function render_error( $data = null ,$code = 501){
		header("HTTP/1.1 $code $data", true, $code);
		exit;
	}
	
	/**
     * Check if there is active User Logged In
     * @return boolean
     */
	function user_login_status(){
		$g=get_session('user_data');
		if(!empty($g)){
			return true;
		}
		return false;
	}
	/**
     * Authenticate And Check User Page Access Eligibility
     * @return  Redirect to Login Page Or Displays Error Message When user access control authorization Fails
     */
	function authenticate_user(){
		$view = new BaseView;
		if(user_login_status()==true){
			$page=strtolower(Router::$page_url);
			$access_condition=PageAccessManager::GetPageAccess($page);
			
			if($access_condition=='NOT_AUTHORIZED'){
				$view->render("errors/error_not_authorised.php",null,"info_layout.php");
				exit;
			}
			elseif($access_condition=='NO_ROLE_PERMISSION'){
				$view->render("errors/error_no_permission.php",null,"info_layout.php");
				exit;
			}
		}
		else{
			$session_key=get_cookie("login_session_key");
			if(!empty($session_key)){
				$model=new AccountModel;
				$user=$model->get_user(array("login_session_key"=>hash_value($session_key)));
				if(!empty($user)){
					set_session("user_data",$user);
					redirect_to_page("home");
					exit;
				}
			}
			$view->page_error="Not Logged In";
			$u=get_current_url();
			if(!empty($u)){
				set_session("login_redirect_url",$u);
			}
			$view->render("index/login.php" ,null,"main_layout.php");
			exit;
		}
	}
	
	/**
     * Convinient Function To Redirect to a url
     * @example redirect_to_page("https://phprad.com");  
     * @return  null
     */
	function redirect($url){
		header("location:$path");
	}
	
	/**
     * Convinient Function To Redirect to Another Page
     * @example redirect_to_page("users/view/".USER_ID);  
     * @return  null
     */
	function redirect_to_page($path=null){
		header("location:".SITE_ADDR. $path);
	}

	/**
     * Convinient Function To Redirect to Page Action
     * @example redirect_to_action("index");  
     * @return  null
     */
	function redirect_to_action($action_name){
		$page=Router::$page_name;
		header("location:". SITE_ADDR . $page."/" . $action_name);
	}
	/**
	 * Set Image Src 
     * Convinient Function To Resize Image Via Url of the Image Src if the src is from the same origin then image can be resize
     * @example <img src="<?php echo set_img_src('uploads/images/89njdh4533.jpg',50,50); ?>" />
     * @return  string
     */
	function set_img_src($imgsrc,$width=null,$height=null,$returnindex=0){
		if(!empty($imgsrc)){
			$arrsrc = explode(",",$imgsrc);
			$src = $arrsrc[$returnindex];
			$imgpath="helpers/timthumb.php?src=$src";
			$imgpath.=($height!=null ? "&h=$height" : null);
			$imgpath.=($width!=null ? "&w=$width" : null);
			return $imgpath;
		}
		return null;
	}
	
	/**
     * Set Application Session Variable 
     * @return  object
     */
	function set_session($session_name,$session_value){
		clear_session($session_name);
		$_SESSION[APP_ID.$session_name]=$session_value;
		return $_SESSION[APP_ID.$session_name];
	}

	/**
     * Update Session Value (if Session is an Array) 
     * @return  object
     */
	function update_session($session_name,$field,$value){
		$_SESSION[APP_ID.$session_name][$field]=$value;
		return $_SESSION[APP_ID.$session_name];
	}

	/**
     * Clear Session
     * @return  boolean
     */
	function clear_session($session_name){
		$_SESSION[APP_ID.$session_name]=null;
		unset($_SESSION[APP_ID.$session_name]);
		return true;
	}

	/**
     * Return Session Value
     * @return  object
     */
	function get_session($session_name){
		if(!empty($_SESSION[APP_ID.$session_name])){
			return $_SESSION[APP_ID.$session_name];
		}
		return null;
	}
	
	/**
     * Return Session Array key Value (if Session is an Array)
     * @return  object
     */
	function get_session_field($session_name,$field){
		if(isset($_SESSION[APP_ID.$session_name])){
			return $_SESSION[APP_ID.$session_name][$field];
		}
		return null;
	}
	
	/**
     * Force Download of The File
     * @return boolean
     */
	function download_file($file_path,$savename=null,$showsavedialog=false){
		if(!empty($file_path)){
			
			if($showsavedialog==false){
				header('Content-Type: application/octet-stream');
			}
			
			if(empty($savename)){
				$savename=basename($file_path);
			}
			
			header('Content-Transfer-Encoding: binary'); 
			header('Content-disposition: attachment; filename="'.$savename.'"'); 
			header('Content-Description: File Transfer');
			header('Expires: 0');
			header('Cache-Control: must-revalidate');
			header('Pragma: public');
			
			ob_clean();
            flush();
            readfile($file_path);
			
			return true;
		}
		return false;
	}
	
	/**
     * Retrieve Content of From external Url
	 * @example echo httpGet("http://phprad.com/system/phpcurget/");
     * @return string
     */
	function http_get($url){
		$ch = curl_init();  
		curl_setopt($ch,CURLOPT_URL,$url);
		curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
		//curl_setopt($ch,CURLOPT_HEADER, false); 
		$output=curl_exec($ch);
		curl_close($ch);
		return $output;
	}
	
	
	/**
     * Retrieve Content of From external Url Using POST Request
	 * @example echo http_post("http://phprad.com/system/phpcurlpost/");
     * @return string
     */
	function http_post($url,$params=array()){
		$postData = '';
		//create name value pairs seperated by &
		foreach($params as $k => $v){ 
			$postData .= $k . '='.$v.'&'; 
		}
		$postData = rtrim($postData, '&');
		$ch = curl_init();  
		curl_setopt($ch,CURLOPT_URL,$url);
		curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
		curl_setopt($ch,CURLOPT_HEADER, false); 
		curl_setopt($ch, CURLOPT_POST, count($postData));
		curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);    
		$output=curl_exec($ch);

		curl_close($ch);
		return $output;
	 
	}

	
	/**
     * will return current DateTime in Mysql Default Date Time Format
     * @return  string
     */
	function datetime_now(){
		return date("Y-m-d H:i:s");
	}
	
	/**
     * will return current Time in Mysql Default Date Time Format
     * @return  string
     */
	function time_now(){
		return date("H:i:s");
	}
	
	/**
     * will return current Date in Mysql Default Date Time Format
     * @return  string
     */
	function date_now(){
		return date("Y-m-d");
	}
	

	/**
     * Parse Date Or Timestamp Object into Relative Time (e.g. 2 days Ago, 2 days from now)
     * @return  string
     */
	function relative_date($date){
		if(empty($date)) {
			return "No date provided";
		}
		
		$periods         = array("sec", "min", "hour", "day", "week", "month", "year", "decade");
		$lengths         = array("60","60","24","7","4.35","12","10");
		
		$now             = time();
		
		//check if supplied Date is in unix date form
		if(is_numeric($date)){
			$unix_date        = $date;
		}
		else{
			$unix_date         = strtotime($date);
		}
		
		
		   // check validity of date
		if(empty($unix_date)) {    
			return "Bad date";
		}

		// is it future date or past date
		if($now > $unix_date) {    
			$difference     = $now - $unix_date;
			$tense         = "ago";
			
		} else {
			$difference     = $unix_date - $now;
			$tense         = "from now";
		}
		
		for($j = 0; $difference >= $lengths[$j] && $j < count($lengths)-1; $j++) {
			$difference /= $lengths[$j];
		}
		
		$difference = round($difference);
		
		if($difference != 1) {
			$periods[$j].= "s";
		}
		
		return "$difference $periods[$j] {$tense}";
	}
	

	/**
     * Parse Date Or Timestamp Object into Human Readable Date (e.g. 26th of March 2016)
     * @return  string
     */
	function human_date($date){
		if(empty($date)) {
			return "Null date";
		}
		if(is_numeric($date)){
			$unix_date        = $date;
		}
		else{
			$unix_date         = strtotime($date);
		}
		// check validity of date
		if(empty($unix_date)) {    
			return "Bad date";
		}
		return date("jS F, Y", $unix_date);
	}
	
	/**
     * Parse Date Or Timestamp Object into Human Readable Date (e.g. 26th of March 2016)
     * @return  string
     */
	function human_time($date){
		if(empty($date)) {
			return "Null date";
		}
		if(is_numeric($date)){
			$unix_date        = $date;
		}
		else{
			$unix_date         = strtotime($date);
		}
		// check validity of date
		if(empty($unix_date)) {    
			return "Bad date";
		}
		return date("h:i:s", $unix_date);
	}
	
	/**
     * Parse Date Or Timestamp Object into Human Readable Date (e.g. 26th of March 2016 02:30)
     * @return  string
     */
	function human_datetime($date){
		if(empty($date)) {
			return "Null date";
		}
		if(is_numeric($date)){
			$unix_date = $date;
		}
		else{
			$unix_date = strtotime($date);
		}
		// check validity of date
		if(empty($unix_date)) {    
			return "Bad date";
		}
		return date("jS F, Y h:i:s", $unix_date);
	}
	
	/**
     * Approximate to nearest decimal points
     * @return  string
     */
	function approximate($val, $decimal_points=2){
		return number_format($val,$decimal_points);
	}
	
	/**
     * Return String formatted in currency mode
     * @return  string
     */
	function to_currency($val, $lang = 'en-US'){
		$f = new NumberFormatter($lang, \NumberFormatter::CURRENCY); 
		return $f->format($val);
	}
	
	/**
     * return a numerical representation of the string in a readable format
     * @return  string
     */
	function to_number($val,$lang='en'){
		$f = new NumberFormatter($lang, NumberFormatter::SPELLOUT);
		return $f->format($val);
	}
	
	/**
     * Trucate string
     * @return  string
     */
	function str_truncate($string, $length=50, $ellipse= '...'){
		if (strlen($string) > $length) {
			$string = substr($string, 0, $length) . $ellipse;
		}
		return $string;
	}
	
	/**
     * Convert Number to words
     * @return  string
     */
	function number_to_words($val,$lang="en"){
		$f = new NumberFormatter($lang, NumberFormatter::SPELLOUT);
		return $f->format($val);
	}
	
	
	/**
     * Set Cookie Value With Number of Days Before Expiring
     * @return  string
     */
	function set_cookie($name,$value,$days=30){
		$expiretime = time() + (86400 * $days);
		setcookie(APP_ID.$name, $value, $expiretime,"/");
	}
	
	/**
     * Get Cookie Value
     * @return  object
     */
	function get_cookie($name){
		if(!empty($_COOKIE[APP_ID.$name])){
			return $_COOKIE[APP_ID.$name];
		}
		return null;
	}
	
	/**
     * Clear Cookie Value
     * @return  boolean
     */
	function clear_cookie($name){
		setcookie(APP_ID.$name, "", time() - 3600,"/");
		return true;
	}
	
	/**
     * Generate a Random String and characters From Set Of supplied data context
     * @return  string
     */
	function random_chars($limit=12,$context='ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890!@#$%^&*_+-='){
		$l=($limit<=strlen($context) ? $limit : strlen($context));
		return substr(str_shuffle($context),0,$l);
	}
	
	/**
     * Generate a Random String From Set Of supplied data context
     * @return  string
     */
	function random_str($limit=12,$context='abcdefghijklmnopqrstuvwxyz1234567890'){
		$l=($limit<=strlen($context) ? $limit : strlen($context));
		return substr(str_shuffle($context),0,$l);
	}
	
	/**
     * Generate a Random String From Set Of supplied data context
     * @return  string
     */
	function random_num($limit=10,$context='1234567890'){
		$l=($limit<=strlen($context) ? $limit : strlen($context));
		return substr(str_shuffle($context),0,$l);
	}
	
	
	
	/**
     * Generate a Random color String 
     * @return  string
     */
	function random_color($alpha=1){
		$red=rand(0,255);
		$green=rand(0,255);
		$blue=rand(0,255);
		return "rgba($red,$blue,$green,$alpha)";
	}
	
	/**
	* Generate a strong hash value String 
	* @return  string
	*/
	function hash_value($text){
		$saltText="AZXCV740884 xs27%^#56635234  ghhtt=-./;'23qAAQWNMM2333\=4--4005KKGM,,.@##@";
		return md5($text.$saltText);
	}
	
	
	/**
     * Will Return A clean Html entities free from xss attacks
     * @return  string
     */
	function html_xss_clean($text){
		return htmlspecialchars($text);
	}

	/**
     * Concat Array  Values With Comma if REQUEST Value is Array
     * Specific for this Framework Only
     * @arr $_POST || $_GET data
     * @return  Array
     */
	function transform_request_data($arr){
		foreach($arr as $key=>$val){
			if(is_array($val)){
				$arr[$key]=implode(',',$val);
			}
		}
		return $arr;
	}
	
	/**
     * Concat Array  Values With Comma if REQUEST Value is Array
     * Specific for this Framework Only
     * @arr $_POST || $_GET data
     * @return  String
     */
	function get_value($fieldname, $default=null){
		if(!empty($_REQUEST[$fieldname])){
			$get = $_REQUEST[$fieldname];
			if(is_array($get)){
				return implode(', ',$get);
			}
			else{
				return $get;
			}
		}
		return $default;
	}
	
	/**
     * Concat Array  Values With Comma
     * Specific for this Framework Only
     * @arr $_POST || $_GET data
     * @return  Array
     */
	function transform_multi_request_data($arr){
		$alldata = array();
		foreach($arr as $key=>$value){
			$combine_vals = implode("", array_values($value));
			if(!empty($combine_vals)){
				$alldata [] = transform_request_data($value);
			}
		}
		return $alldata;
	}
	

	/**
     * Get Form Control POST BACK Value
     * @example <input value="<?php echo get_form_field_value('user_name'); ?>" />
     * @return  string
     */
	function get_form_field_value($field,$default_value=null){
		if(!empty($_REQUEST[$field])){
			return $_REQUEST[$field];
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
	function get_form_field_checked($field,$value){
		if(!empty($_REQUEST[$field]) && $_REQUEST[$field]==$value){
			return "checked";
		}
		return null;
	}
	
	/**
     * Get Form Checkbox Check Status On POST BACK
     * @example <input type="checkbox" <?php echo get_form_field_checked('user_name'); ?> />
     * @return  string
     */
	function check_form_field_checked($srcdata,$value){
		if(!empty($srcdata)){
			$arr=explode(",",$srcdata);
			if(in_array($value,$arr)){
				return "checked";
			}
		}
		return null;
	}
	
	function is_active_link($field, $value){
		if(!empty($_REQUEST[$field]) && $_REQUEST[$field]==$value){
			return "active";
		}
		return null;
	}
	
	/**
     * Set Full Address of a Path
     * @return  string
     */
	function set_url($path=null){
		//check if is a valid url 
		if(filter_var($path, FILTER_VALIDATE_URL) !== FALSE){
			return  $path;
		}
		else{
			return SITE_ADDR.$path;
		}
	}
	
	/**
     * Get number of files in a directory
     * @return  int
     */
	function get_dir_file_count($dirpath){
		$filecount = 0;
		$files = glob($dirpath . "*");
		if($files){
			$filecount = count($files);
		}
		return $filecount;
	}
	
	
	/**
     * Print Out Full Address of a Link
     * @return null
     */
	function print_link($link){
		//check if is a valid Link
		if(filter_var($link, FILTER_VALIDATE_URL) !== FALSE){
			echo $link;
		}
		else{
			echo SITE_ADDR.$link;
		}
	}
	
	/**
     * Print out language translation of the default language
     * @return string
     */
	function print_lang($name){
		global $lang;
		$phrase = $lang->get_phrase($name);
		if(!empty($phrase)){
			echo $phrase;
		}
		else{
			echo $name ;
		}
	}
	
	/**
     * Return language translation of the default language
     * @return string
     */
	function get_lang($name){
		global $lang;
		$phrase = $lang->get_phrase($name);
		if(!empty($phrase)){
			return $phrase;
		}
		return $name ;
	}
	
	
	/**
     * Get The Current Url Address of The Application Server
     * @example http://mysitename.com
     * @return  string
     */
	function get_url(){
		$url  = isset( $_SERVER['HTTPS'] ) && 'on' === $_SERVER['HTTPS'] ? 'https' : 'http';
		$url .= '://' . $_SERVER['SERVER_NAME'];
		$url .= in_array( $_SERVER['SERVER_PORT'], array('80', '443') ) ? '' : ':' . $_SERVER['SERVER_PORT'];
		$url .= $_SERVER['REQUEST_URI'];
		return $url;
	}
	
	/**
     * Construct New Url With Current Url Or  New Query String || Path
     * @param $newqs Array of New Query String Key Values
     * @param $pagepath String
     * @return  string
     */
	function set_page_link($pagepath=null, $newqs=array()){
		$get=$_GET;
		unset($get['request_uri']);
		$allqet=array_merge($get,$newqs);
		if(empty($pagepath)){
			$qs=http_build_query($allqet);
			return Router::$page_url . (!empty($qs) ? "?$qs" : null);
		}
		$qs=http_build_query($allqet);
		return "$pagepath"  . (!empty($qs) ? "?$qs" : null);
	}
	
	/**
     * Construct New Url With Current Url Or  New Query String
     * @param $newqs Array of New Query String Key Values
     * @param $replace String
     * @return  string
     */
	function set_current_page_link($newqs=array(), $replace=false){
		$allqet = $newqs;
		if($replace == false){
			$get = $_GET;
			unset($get['request_uri']);
			$allqet = array_merge($get , $newqs);
		}
		$qs = http_build_query($allqet);
		return Router::$page_url . (!empty($qs) ? "?$qs" : null);
	}
	
	/**
     * Construct New Url With Current Url.Unset Query String if available
     * @param $arr_qs Array of New Query String Key Values
     * @return  string
     */
	function unset_page_querystring($arr_qs){
		$get = $_GET;
		unset($get['request_uri']);
		if(is_array($arr_qs)){
			foreach($arr_qs as $key){
				unset($get[$key]);
			}
		}
		else{
			unset($get[$arr_qs]);
		}
		$qs = http_build_query($get);
		return Router::$page_url . (!empty($qs) ? "?$qs" : null);
		
	}
	
	/**
     * Get Full Relative Path of The Current Page With Query String
     * @return  string
     */
	function get_current_url(){
		$get=$_GET;
		unset($get['request_uri']);
		$qs=http_build_query($get);
		return Router::$page_url . (!empty($qs) ? "?$qs" : null);
	}
	
	/**
     * Will Return a $_GET value or null if key Does not exit or is Empty
     * @return  object
     */
	function get_query_str_value($name){
		return (array_key_exists($name, $_GET) ? $_GET[$name] : null);
	}
	
	function get_val($name){
		return (array_key_exists($name, $_GET) ? $_GET[$name] : null);
	}
	
	

	/**
     * Will Return a $_GET Key Value or null if key Does not exit or is Empty
     * @return  object
     */
	function get_query_string($key){
		$val=null;
		if(!empty($_GET[$key])){
			$val=$_GET[$key];
		}
		return $val;
	}
	
	/**
     * Set Msg that Will be Display to User in a Session. 
     * Can Be Displayed on Any View.
     * @return  object
     */
	function set_flash_msg($msg,$type="success",$dismissable=true,$showduration=5000){
		if($msg!==''){
			$class=null;
			$closeBtn=null;
			if($type!='custom'){
				$class="alert alert-$type";
				if($dismissable==true){
					$class.=" alert-dismissable";
					$closeBtn='<button type="button" class="close" data-dismiss="alert">&times;</button>';
				}
			}
			
			$msg='<div data-show-duration="'.$showduration.'" id="flashmsgholder" class="'.$class.' animated bounce">
						'.$closeBtn.'
						'.$msg.'
				</div>';
				
			set_session("MsgFlash",$msg);	
		}
	}
	
	/**
     * Display The Message Set In MsgFlash Session On Any Page
     * Will Clear The Message Afterwards
     * @return  null
     */
	function show_flash_msg(){
		$f=get_session("MsgFlash");
		if(!empty($f)){
			echo $f;
			clear_session("MsgFlash");
		}
	}
	
	/**
     * Check if current browser platform is a mobile browser
     * Can Be Used to Switch Layouts and Views on A Mobile Platform
     * @return  object
     */
	function is_mobile() {
		return preg_match("/(android|avantgo|blackberry|bolt|boost|cricket|docomo|fone|hiptop|mini|mobi|palm|phone|pie|tablet|up\.browser|up\.link|webos|wos)/i", $_SERVER["HTTP_USER_AGENT"]);
	}
	
	function is_ajax() {
        return isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] === 'XMLHttpRequest';
	}
	