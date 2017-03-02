<?php 
class Answer extends Model{

	function __construct(){
		parent::__construct("answer");
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
	
	function getByQuestion($id){
		$this->load(array('question=?',$id));
		return $this->toArray();
	}
	
}