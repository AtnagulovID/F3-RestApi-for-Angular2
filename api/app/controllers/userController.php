<?php 
class userController extends Controller{

    protected $ModelName = 'User';
    protected $transConst = array(
        'not_found' => 'user_not_found'
    );

    function authenticate($f3) {
	    $this->parse_body();

        $users = new User();
        $user = $users->auth();

		if($users->error){
		    $this->httpResponse($model->error[code], $this->outErr($users->error));
		}
		else
		{
            $jwttoken = $this->getJWTToken($f3, $users->id);
            $user['token'] = $jwttoken;
            $this->httpResponse("200", $user);
		};
    }
    
	function ident($f3){
	    $this->parse_body();
	    eval('$'.'model = new '.$this->ModelName.'();');
		$result = $model->getByID($this->f3->get('UserID'));
		//$result = $model->getByID('588af9cf4b0b3');
		if($model->error){
    		$this->httpResponse($model->error[code], $this->outErr($model->error));
		}
		else
		{
			$this->httpResponse("200",$result);
		}
	}
    

}