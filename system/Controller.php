<?php
class Controller{
	public function view($dir,$data=[]){
		$cek_file="app/Views/".$dir.".php";
		if(file_exists($cek_file)){
			require_once "app/Views/".$dir.".php";
		}
		else{
			echo "File not found";
		}
	}
	public function model($dir){
		require_once "app/Models/".$dir.".php";
		$dir=explode("/", $dir);
		if(count($dir)>1){
			$class=new $dir[count($dir)-1]();
		}
		else{
			$class=new $dir[0]();	
		}
		return $class;
	}
}
?>