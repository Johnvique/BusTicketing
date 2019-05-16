<?php 

/**
 * Home Page Controller
 * @category  Controller
 */
class HomeController extends SecureController{
	/**
     * Index Action
     * @return View
     */
	function index(){
		if(strtolower(USER_ROLE) == 'user'){
			$this->view->render("home/user.php" , null , "main_layout.php");
		}
		else{
			$this->view->render("home/index.php" , null , "main_layout.php");
		}
	}
}
