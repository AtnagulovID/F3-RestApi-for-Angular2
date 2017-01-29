<?php 
class UserBaseModel extends Model{

	function all(){
        list($userid) = func_get_args();
		$this->load(array('user = ?',$userid));
		return $this->toArray();
	}

    function create(){
        list($userid) = func_get_args();
		$this->copyfrom('INPUT');
		if ($this->isCreateId == true)
		{
		    $this->id = uniqid();
		};
		$this->user = $userid;
		$this->verify();
        
		if(!$this->error)
		{
    		$this->save();
    		return $this->cast();
		}else
		{
    		return null;
		}
	}

}