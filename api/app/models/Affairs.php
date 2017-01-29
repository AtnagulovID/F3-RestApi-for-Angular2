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
	
}