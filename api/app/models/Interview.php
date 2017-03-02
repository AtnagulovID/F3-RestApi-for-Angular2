<?php 
class Interview extends UserBaseModel{

	function __construct(){
		parent::__construct("interview");
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
            case ($this->name==null) : 
			$this->error = array(
				'code' => '400',
				'message' => 'text_is_required'
				);
			break;
        }
		
	}

	
}