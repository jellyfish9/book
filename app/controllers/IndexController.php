<?php 

/**
 * Index Page Controller
 * @category  Controller
 */
class IndexController extends BaseController{
	/**
     * Index Action 
     * @return View
     */
	function index(){
		$this->view->render(null ,null,"main_layout.php");
	}
	
	private function login_user($username , $password_text, $rememberme = false){
		$db = $this->GetModel();
		
		$db->where("user_name", $username)->orWhere("email", $username);
		$user = $db->getOne('user');
		if(!empty($user)){
			
			//Verify User Password Text With DB Password Hash Value.
			//Uses PHP password_verify() function with default options
			$password_hash = $user['password'];
			if(password_verify($password_text,$password_hash)){

				
				unset($user['password']); //Remove user password as it's not needed.
				set_session('user_data',$user); // Set Active User Data in A Sessions
				//if Remeber Me, Set Cookie
				if($rememberme==true){
					$sessionkey=time().random_str(20);// Generate a Session Key for the User
					//Update User Detail in Database with the session key
					$db->where('uid' , $user['uid']);
					$res = $db -> update(array("login_session_key"=>hash_value($sessionkey)));
					if(!empty($res)){
						set_cookie("login_session_key",$sessionkey);// save user login_session_key in a Cookie
					}
				}
				else{
					clear_cookie("login_session_key");// Clear any Previous Set Cookie
				}
				render_json('');
			}
			else{
				render_error("用户名或密码不正确" , 401);
			}
		}
		else{
			render_error("用户名或密码不正确" , 401);
		}
	}
	
	
	/**
     * Login Action
     * If Not $_POST Request, Display Login Form View
     * @return View
     */
	function login(){
		if(is_post_request()){
			
			$form_collection=$_POST;
			$username=trim($form_collection['username']);
			$password=$form_collection['password'];
			$rememberme=(!empty($form_collection['rememberme']) ? $form_collection['rememberme'] : false);
			
			$this->login_user($username , $password, $rememberme = false);
			
		}
		else{
			render_error("无效的请求");
		}
	}
	
	
	/**
     * Register User Action 
     * If Not $_POST Request, Display Register Form View
     * @return View
     */
	function register(){
		if(is_post_request()){
			
			

			$modeldata=transform_request_data($_POST);

			$rules_array = array(
				
				'user_name' => 'required',
				'password' => 'required',
				'email' => 'required|valid_email',
			);
			
			$is_valid = GUMP::is_valid($modeldata, $rules_array);
			if($is_valid != true) {
				render_error($is_valid);
			}
			
			
			$cpassword = $modeldata['confirm_password'];
			$password = $modeldata['password'];
			if($cpassword != $password){
				render_error('Your Password Does not Conform to be Unique');
			}
			unset($modeldata['confirm_password']);
			
			$password_text = $modeldata['password'];
			$modeldata['password'] = password_hash($password_text , PASSWORD_DEFAULT);
			
			
			
			
			$db = $this->GetModel();
			
			
			
			
			//Check if Duplicate Record Already Exit In The Database
			$db->where('user_name',$modeldata['user_name']);
			if($db->has('user')){
				render_error($modeldata['user_name']."已经存在！");
			}
			//Check if Duplicate Record Already Exit In The Database
			$db->where('email',$modeldata['email']);
			if($db->has('user')){
				render_error($modeldata['email']."已经存在！");
			}
			
			$rec_id = $db->insert('user',$modeldata);
			
			if(!empty($rec_id)){
				
				
			$user=$this->login_user($modeldata['email'] , $password_text);
			
				
				$user = $result['user'];
				set_session('user_data',$user);

				//page to redirect to after register
				render_json('');

			}
			else{
				if($db->getLastError()){
					render_error($db->getLastError());
				}
				else{
					render_error("注册用户时出错");
				}
			}
		}
		else{
			render_error("无效的请求");
		}
	}

	
	/**
     * Logout Action
     * Destroy All Sessions And Cookies
     * @return View
     */
	function logout($arg=null){
		
		session_destroy();
		clear_cookie("login_session_key");
		redirect_to_page("");
	}
	
	
	
}
