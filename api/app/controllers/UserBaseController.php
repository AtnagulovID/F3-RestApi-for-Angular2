<?php 
class UserBaseController extends Controller{

	function lists($f3){
	    $this->parse_body();
	    eval('$'.'model = new '.$this->ModelName.'();');
		$result=$model->all($f3->get('UserID'));

		if($model->error){
		    $this->httpResponse($model->error[code], $this->outErr($model->error));
		}
		else
		{
			$this->httpResponse("200", $result);
		}
	}

	function create($f3){

	    $this->parse_body();
	    eval('$'.'model = new '.$this->ModelName.'();');

        $result = $model->create($f3->get('UserID'));

		if($model->error){
			$this->httpResponse($model->error[code], $this->outErr($model->error));
		}
		else
		{
			$this->httpResponse("200",$result);
		}

    }


}