<?php
/**
 * File Helper Controller
 *
 * @category  File Helper
 */

class FilehelperController extends BaseController{
	/**
     * Upload A file to the server
     * @return JSON String
     */
	function uploadfile(){
		$uploader=new Uploader;
		// Get Upload Config From POST Request
		$config = transform_request_data($_POST);
		$upload_data = $uploader->upload($_FILES['file'], $config);
		
		if($upload_data['hasErrors']){
			$errors = $upload_data['errors'];
			render_error( json_encode($errors));
		}

		if($upload_data['isComplete']){
			$files = $upload_data['data'];
			$path = $upload_data['data']['files'][0];
			if(!empty($config['returnfullpath'])){
				echo set_url($path);
			}
			else{
				echo $path;
			}
		}
	}
}
