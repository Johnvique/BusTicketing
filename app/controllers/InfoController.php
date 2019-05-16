<?php
/**
 * Info Contoller Class
 * @category  Controller
 */

class InfoController extends BaseController{

	/**
     * Display About us page
     * @return Html View
     */
	function about(){
		$this->view->render("info/about.php" ,null,"info_layout.php");
	}

	/**
     * Display Help Page
     * @return Html View
     */
	function help(){
		$this->view->render("info/help.php" ,null,"info_layout.php");
	}
	
	/**
     * Display Features Page
     * @return Html View
     */
	function features(){
		$this->view->render("info/features.php" ,null,"info_layout.php");
	}
	
	/**
     * Display Privacy Policy Page
     * @return Html View
     */
	function privacy_policy(){
		$this->view->render("info/privacy_policy.php" ,null,"info_layout.php");
	}

	/**
     * Display Terms And Conditions Page
     * @return Html View
     */
	function terms_and_conditions(){
		$this->view->render("info/terms_and_conditions.php" ,null,"info_layout.php");
	}

	/**
     * Display Contact us Page
     * @return Html View
     */
	function contact(){
		if(!empty($_POST)){
			$email=$_POST['email'];
			$name=$_POST['name'];
			$msg=$_POST['msg'];
			$title="New Contact us Message From $name";
			
			$mailer=new Mailer;
			
			$mailer->From=$email;
			$mailer->FromName=$name;
			
			$mailer->send_mail(DEFAULT_EMAIL, $title, $msg);
			
			redirect_to_action("contact_sent");
		}
		else{
			$this->view->render("info/contact.php" ,null,"info_layout.php");
		}
	}
	
	/**
     * Display Contact Success Page After Sending Form
     * @return Html View
     */
	function contact_sent(){
		$this->view->render("info/contact_sent.php" ,null,"info_layout.php");
	}
	
	/**
     * Display Change default language page
     * @return Html View
     */
	function change_language($lang = null){
		if(!empty($lang)){
			set_cookie('lang', $lang);
			redirect_to_page(DEFAULT_PAGE);
		}
		else{
			$this->view->render("info/change_language.php" ,null,"info_layout.php");
		}
	}
}
