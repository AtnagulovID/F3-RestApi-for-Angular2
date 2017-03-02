<?php
Class Controller {
    protected $f3;

    protected $transConst = array();
    protected $ModelName = '';

    public function __construct($f3)
    {
	    $this->f3 = Base::instance();
    } 

	function httpResponse($status, $body){
		header('HTTP/1.1 '.$status);
		header('Content-Type: application/json');
		echo json_encode($body);
	}

	function httpResponseTxt($status, $body){
		header('HTTP/1.1 '.$status);
		header('Content-Type: application/json');
		echo $body;
	}

    function errToModelErr($error) {
        if (array_key_exists($error[message], $this->transConst)) {
            $error[message] = $this->transConst[$error[message]];
        }
        return $error;
    } 

    function translateErr($error) {
        $error[message] = $this->f3->get($error[message]);
        return $error;
    } 
    
    function outErr($error) {
        $error = $this->errToModelErr($error);
        $error = $this->translateErr($error);
        return $error;
    }

    function getJWTToken($f3, $aud) {
        $token = array(
            "iss" => $f3->get('HOST'),
            "aud" => $aud,
            "iat" => time(),
            "nbf" => time() + 7*24*60*60
        );
        return JWT::encode($token, $f3->get('TOKENKEY'));
    }

	function parse_body(){
		$head=getallheaders();
		
        $this->f3->set('UserID', '');
		$token = $head['Authorization'];

		if ($token != '')
		{
            $token = JWT::decode($token, $this->f3->get('TOKENKEY'));
            $this->f3->set('UserID', $token->aud);
		};

		$lang = $head['Content-Language'];
		if ($lang == '')
		{
		    $lang = 'ru';
		};
        $this->f3->set('LANGUAGE', $lang);

		switch (true) {
			case (strpos($head['Content-Type'],'application/json')!==false):
				$input=json_decode($this->f3->get('BODY'));
				break;
			case (strpos($head['Content-Type'],'application/x-www-form-urlencoded;charset=utf-8')!==false):
				 parse_str($this->f3->get('BODY'),$input);
				break;
			default:
				 parse_str($this->f3->get('BODY'),$input);
				break;
		}

        $this->f3->set('INPUT',$input);
   }
   
   

	function lists($f3){
	    $this->parse_body();
	    eval('$'.'model = new '.$this->ModelName.'();');
		$result=$model->getAll($f3->get('PARAMS.id'));

		if($model->error){
		    $this->httpResponse($model->error[code], $this->outErr($model->error));
		}
		else
		{
			$this->httpResponse("200", $result);
		}
	}

	function findOne($f3){
	    $this->parse_body();
	    eval('$'.'model = new '.$this->ModelName.'();');
		$result = $model->getByID($f3->get('PARAMS.id'));
		if($model->error){
    		$this->httpResponse($model->error[code], $this->outErr($model->error));
		}
		else
		{
			$this->httpResponse("200",$result);
		}
	}

	function create($f3){
        $this->parse_body();
	    
	    eval('$'.'model = new '.$this->ModelName.'();');

        $result = $model->create();

		if($model->error){
			$this->httpResponse($model->error[code], $this->outErr($model->error));
		}
		else
		{
			$this->httpResponse("200",$result);
		}
    }

	function update($f3){
	    $this->parse_body();
	    eval('$'.'model = new '.$this->ModelName.'();');
		$result = $model->edit($f3->get('PARAMS.id'));
		if($model->error){
			$this->httpResponse($model->error[code], $this->outErr($model->error));
		}
		else
		{
			$this->httpResponse("200",$result);
		}
	}

	function delete($f3){
	    $this->parse_body();
	    eval('$'.'model = new '.$this->ModelName.'();');
		$result = $model->remove($f3->get('PARAMS.id'));
		if($users->error){
			$this->httpResponse($model->error[code], $this->outErr($model->error));
		}
		else
		{
			$this->httpResponse("200",$result);
		}
	}	
}