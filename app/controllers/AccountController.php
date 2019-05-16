<?php 
/**
 * Account Page Controller
 * @category  Controller
 */
class AccountController extends SecureController{
	/**
     * Index Action
     * @return View
     */
	function index(){
		$db = $this->GetModel();
		$db->where ("id", USER_ID);
		$user = $db->getOne('customers' , '*');
		$this->view->render("account/view.php" ,$user,"main_layout.php");
	}
	/**
     * Edit Record Action 
     * If Not $_POST Request, Display Edit Record Form View
     * @return View
     */
	function edit(){
		$db = $this->GetModel();
		if(is_post_request()){
			$modeldata = transform_request_data($_POST);
			$rules_array = array(
				'name' => 'required',
				'phone' => 'required',
				'role' => 'required',
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
			//Check if Duplicate Record Already Exit In The Database
			if(isset($modeldata['name'])){
				$db->where('name',$modeldata['name'])->where('id',USER_ID,'!=');
				if($db->has('customers')){
					$this->view->page_error[] = $modeldata['name']."Already exist!";
				}
			} 
			if(empty($this->view->page_error)){
				$db->where('id' , USER_ID);
				$bool = $db->update('customers',$modeldata);
				if($bool){
				$db->where ('id', USER_ID);
				$user = $db->getOne('customers' , '*');
				set_session('user_data',$user);
					set_flash_msg("Record updated successfully",'success');
					redirect_to_page("account");
					return;
				}
				else{
					$this->view->page_error[] = $db->getLastError();
				}
			}
		}
		$fields = array('id','name','phone','role');
		$db->where('id' , USER_ID);
		$data = $db->getOne('customers',$fields);
		$this->view->page_title ="My Account";
		if(!empty($data)){
			$this->view->render('account/edit.php' , $data, 'main_layout.php');
		}
		else{
			if($db->getLastError()){
				$this->view->page_error[] = $db->getLastError();
			}
			else{
				$this->view->page_error[] = "Record not found";
			}
			$this->view->render('account/edit.php' , $data , 'main_layout.php');
		}
	}
	/**
     * Change Email Action
     * @return View
     */
	function change_email(){
		if(is_post_request()){
			$form_collection = $_POST;
			$email=trim($form_collection['email']);
			$db = $this->GetModel();
			$db->where ("id", USER_ID);
			$result = $db->update('customers', array('email' => $email ));
			if($result){
				set_flash_msg("Email address changed successfully",'success');
				redirect_to_page("account");
			}
			else{
				$this->view->page_error = "Email not changed";
				$this->view->render("account/change_email.php" , null , "main_layout.php");
			}
		}
		else{
			$this->view->render("account/change_email.php" ,null,"main_layout.php");
		}
	}
}
