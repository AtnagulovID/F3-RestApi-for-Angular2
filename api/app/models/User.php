<?php 
class User extends Model{
	protected $isCreateId = true;

	function __construct(array $user = null){
		parent::__construct("users");
	}

    function auth(){
		$this->copyfrom('INPUT');
		$password = $this->password;
        $this->load(array('username=?', $this->username));
		if($this->count(array('password=?', $password))>0){
    		$arData=$this->cast();
    		return $arData;
		}else
		{
		$this->error = array(
				'code' => '404',
				'message' => 'User_not_found'
				);

		}
    }


	function verify(){
		switch (true) {
			case ($this->username==null) : 
			$this->error = array(
				'code' => '400',
				'message' => 'username_is_required'
				);
			break;
			case (!filter_var($this->username, FILTER_VALIDATE_EMAIL)) : 
			$this->error = array(
				'code' => '400',
				'message' => 'email_incorrect'
				);
			break;
            case ($this->password==null) : 
			$this->error = array(
				'code' => '400',
				'message' => 'password_is_required'
				);
			break;
            case (strlen($this->password)<6) : 
			$this->error = array(
				'code' => '400',
				'message' => 'password_length_6'
				);
			break;
        }
		
	}

	function toArray()
	{
		$arResponse = array();
		foreach (($this->query?:array()) as $user) {
			$arData = array();
			$arData=$user->cast();
			array_push($arResponse, $arData);
		}
		return $arResponse;

	}
}