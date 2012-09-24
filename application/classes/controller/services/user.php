<?php defined('SYSPATH') or die('No direct script access.');
 
class User extends Controller
{
	
	public function __construct($request = NULL, $response = NULL)
	{
		//parent::__construct($request, $response);	
	}
	
	public function index()
	{
		return "CLASS User";
	}
	
	public function login(array $user = null)
	{
		$user["password"]	= "carnafacul2012";
		$_config 			= Kohana::config("auth");
		$password			= hash_hmac($_config['hash_method'], $user["password"], $_config['hash_key']);
		try{
			$loadUser		= ORM::factory('user')
													->where("facebook_id",	'=', $user["facebook_id"])
													->and_where("email", 	'=', $user["email"])
													->and_where("name", 	'=', $user["name"])
													->and_where("username", '=', $user["username"])
													->and_where("password", '=', $password)
													->find();
			if( empty($loadUser->id) )
			{
				$createUser		= $this->create($user);
				$loadUser		= ORM::factory('user', $createUser);
			}
										
			$user 				= new UserVO();
			$user->id			= $loadUser->id;
			$user->facebook_id	= $loadUser->facebook_id;
			$user->name			= $loadUser->name;
			$user->username		= $loadUser->username;
			$user->email		= $loadUser->email;
			$user->regulation	= $loadUser->regulation;
			return $user;
		}catch(Exception $e){
			 return $e->getTraceAsString();
		}
	}
	
	function create($user){
		#Load the view
		$post				= $this->validate($user);
        if ($post->check())
		{
			$createUser 	= ORM::factory('user');
			
            //Data has been validated, register the user
           	$userID	= $createUser->values($user)->save();
			
            $login_role = new Model_Role(array('name' =>'login'));
			$createUser->add('roles', $login_role);
			
			return $userID->id;
        }
		
        // Validation failed, collect the errors
        return $post->errors('createUser');
	}
	
	public function update(array $arrUser = NULL)
	{
		$createUser 	= ORM::factory('user', $arrUser["id"]);
        //Data has been validated, register the user
       	return $createUser->values($arrUser)->save();
		 
	}
	
	protected function validate(array $user){
		$validateObj = Validation::factory($user)
									->rule("facebook_id", "not_empty")
									->rule("facebook_id", "min_length", array(":value", 1))
									->rule("facebook_id", "max_length", array(":value", 254))
									
									->rule("name", "not_empty")
									->rule("name", "min_length", array(":value", 2))
									->rule("name", "max_length", array(":value", 32))
									
									->rule("username", "not_empty")
									->rule("username", "min_length", array(":value", 2))
									->rule("username", "max_length", array(":value", 32))
									
									->rule("email", "not_empty")
									->rule("email", "min_length", array(":value", 5))
									->rule("email", "max_length", array(":value", 254))
									
									->rule("password", "not_empty")
									->rule("password", "min_length", array(":value", 4))
									->rule("password", "max_length", array(":value", 64));
		return $validateObj;
	}
	
	
}

class UserVO{
	public $_explicitType = "application/classes/controller/services/UserVO";
	public $id;
	public $facebook_id;
	public $name;
	public $username;
	public $email;
	public $regulation;
}