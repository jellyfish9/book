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
		$db->where ("uid", USER_ID);
		$user = $db->getOne('user' , '*');
		render_json($user);
	}
	
	
	/**
     * Edit Record Action 
     * If Not $_POST Request, Display Edit Record Form View
     * @return View
     */
	function edit(){
		$db = $this->GetModel();
		if(is_post_request()){
			
			
			$modeldata=transform_request_data($_POST);
			 
			
			//Check if Duplicate Record Already Exit In The Database
			if(isset($modeldata['user_name'])){
				$db->where('user_name',$modeldata['user_name'])->where('uid',USER_ID,'!=');
				if($db->has('user')){
					render_error($modeldata['user_name']."已经存在！");
				}
			} 
			
			$db->where('uid' , USER_ID);
			$bool = $db->update('user',$modeldata);
			if($bool){
				$db->where ('uid', USER_ID);
				$user = $db->getOne('user' , '*');
				set_session('user_data',$user);

				
				
				render_json(USER_ID);
			}
			else{
				render_error($db->getLastError());
			}
			return null;
		}
		else{
			$fields=array('uid','user_name');
			$db->where('uid' , USER_ID);
			$data = $db->getOne('user',$fields);
			
			if(!empty($data)){
				render_json($data);
			}
			else{
				if($db->getLastError()){
					render_error($db->getLastError());
				}
				else{
					render_error("找不到记录",404);
				}
			}
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
			
			$db->where ("uid", USER_ID);
			$result = $db->update('user', array('email' => $email ));
			if($result){
				
				set_flash_msg("电邮地址已成功更改",'success');
				redirect_to_page("#/account");
			}
			else{
				$this->view->form_error="Email Not Changed ";
				$this->view->render("account/change_email.php" ,null,"default_layout.php");
			}
		}
		else{
			$this->view->render("account/change_email.php" ,null,"default_layout.php");
		}
	}
}
