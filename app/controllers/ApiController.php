<?php
/**
 * Info Contoller Class
 * @category  Controller
 */

class ApiController extends BaseController{
	
	/**
     * Display About us page
     * @return Html View
     */
	
	function json($action,$arg1=null,$arg2=null){
		$model = new SharedController;
		$args = array($arg1 , $arg2);
		$data = call_user_func_array(array($model,$action),$args);
		render_json($data);
	}
}
