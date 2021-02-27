<?php
class Db{
	private $connect;
	public $query;
	public $error;
	public function __construct(){
		$this->connect=mysqli_connect(HOST,USER,PASSWORD,DB);
	}
	public function query($q){
		$this->query=mysqli_query($this->connect,$q);
		return $this;
	}

	public function result(){
		$isi=[];
		if($this->query){
		while($has=mysqli_fetch_assoc($this->query)){
			array_push($isi, $has);
		}
		return $isi;
		}
		else{
			$this->error=mysqli_error($this->query);
			return $this->error;
		}
	}

	public function num_rows(){
		if($this->query){
			return mysqli_num_rows($this->query);
		}
		else{
			$this->error=mysqli_error($this->query);
			return $this->error;
		}
	}

	public function __destruct(){
		mysqli_close($this->connect);
	}
}


?>