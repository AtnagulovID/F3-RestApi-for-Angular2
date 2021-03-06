<?php 
class Affairs extends UserBaseModel{

	function __construct(array $user = null){
		parent::__construct("affairs");
	}
	

	function toArray()
	{
		$arResponse = array();
		foreach (($this->query?:array()) as $affairs) {
			$arData = array();
			$arData=$affairs->cast();
			array_push($arResponse, $arData);
		}
		return $arResponse;

	}

	function verify(){
		switch (true) {
			case ($this->date==null) : 
			$this->error = array(
				'code' => '400',
				'message' => 'date_is_required'
				);
			break;
            case ($this->name==null) : 
			$this->error = array(
				'code' => '400',
				'message' => 'text_is_required'
				);
			break;
        }
		
	}

	
}