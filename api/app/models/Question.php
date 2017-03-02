<?php 
class Question extends Model{

	function __construct(){
		parent::__construct("question");
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
	
	function getByInterview($id){
		$this->load(array('interview=?',$id));
		return $this->toArray();
	}
	
}