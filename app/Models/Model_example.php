<?php
class Model_user{
	private $table;
	public $db;
	public function __construct(){
		//initialize the class for database management
		//use new Db() if you load the Db library
		//use lawliet_query_builder if you load the lawliet_query_builder library
		$this->db2=new Db();
		//this is example of the table's name
		$this->table='table_sample';
	}
	//the example below will show how to conduct basic CRUD operation using lawliet_zero framework with Db library
	public function create(){
		return $this->query("INSERT INTO ".$this->table."(field1,field2,field3) VALUES ('value1','value2','value3')");
	}
	public function update(){
		return $this->query("UPDATE ".$this->table." SET field1='val1', field2='val2' field3='val3' where prim_field='prim_val'");
	}
	public function delete(){
		return $this->query("DELETE FROM ".$this->table." WHERE prim_field='prim_val'");
	}
	public function read_one(){
		return $this->query("SELECT * FROM FROM ".$this->table." WHERE prim_field='prim_val'")->result();	
	}
	public function read_all(){
		return $this->query("SELECT * FROM FROM ".$this->table)->result();	
	}
	public function check_row_one(){
		return $this->query("SELECT * FROM FROM ".$this->table." WHERE prim_field='prim_val'")->num_rows();	
	}
	public function check_num_all(){
		return $this->query("SELECT * FROM FROM ".$this->table)->num_rows();	
	}

}
?>