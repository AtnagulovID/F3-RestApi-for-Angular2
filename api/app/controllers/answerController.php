<?php 
class answerController extends Controller{

    protected $ModelName = 'Answer';
    protected $transConst = array(
        'not_found' => 'not_found'
    );

	function lists($f3){
	    $this->parse_body();
	    eval('$'.'model = new '.$this->ModelName.'();');
		$result=$model->getByQuestion($f3->get('PARAMS.id'));

		if($model->error){
		    $this->httpResponse($model->error[code], $this->outErr($model->error));
		}
		else
		{
			$this->httpResponse("200", $result);
		}
	}

}