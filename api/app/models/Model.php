<?php
class Model extends DB\SQL\Mapper{
	protected $db;
	protected $isCreateId = false;
	public $error;

	function __construct($table){
		$this->initializeDatabase();
		parent::__construct($this->db,$table);
	}

	function initializeDatabase(){
		$f3=Base::instance();
		$db = new DB\SQL(
			$f3->get("DBS"),
			$f3->get("dbuser"),
			$f3->get("dbpass")
			);
		$this->db=$db;
	}

	function all(){
		$this->load();
		return $this->toArray();
	}

	function getByID($id){
		$this->load(array('id=?',$id));

		if($this->count(array('id=?',$id))>0){
		    $arData=$this->cast();
    		return $arData;
		}else
		{
		$this->error = array(
				'code' => '404',
				'message' => 'not_found'
				);

		}
	}

    function create(){
		$this->copyfrom('INPUT');
		if ($this->isCreateId == true)
		{
		    $this->id = uniqid();
		};
		
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

	function edit($id){
		$this->load(array('id=?',$id));

		if($this->count(array('id=?',$id))>0){

		$this->copyfrom('INPUT');
		$this->verify();

		if(!$this->error)
		{
			 $this->update();
			 return $this->cast();
		}else
		{
		return null;
		}
		}else
		{
		$this->error = array(
				'code' => '404',
				'message' => 'not_found'
				);

		}
	}

	function remove($id){
		$this->load(array('id=?',$id));

		if($this->count(array('id=?',$id))>0){
			$this->erase();

			return array(
				'code' => '200',
				'message' => 'Successfully_Deleted');
		}else
		{
		$this->error = array(
				'code' => '404',
				'message' => 'not_found'
				);

		}
	}

	function verify(){
	}

	function toArray()
	{
	}
	
}