<?php
class lawliet_query_builder{
	var $connection,$query,$field_select,$table_name,$where,$inner_join,$limit,$offset,$variable,$value,$order_by;
	function __construct(){
		$this->connection=mysqli_connect(HOST,USER,PASSWORD,DB);
	}
	function __destruct(){
		mysqli_close($this->connection);
	}
	function inner_join($a){
		$this->inner_join=$a;
		return $this;
	}
	function limit_offset($a,$b=""){
		$this->limit=$a;
		$this->offset=$b;
		return $this;
	}

	function order_by($a){
		$this->order_by=$a;
		return $this;
	}
	function show_error(){
		return mysqli_error($this->connection);
	}
	function set_var($a){
		$this->variable=array_keys($a);
		$this->value=array_values($a);
		return $this;
	}
	function where($a){
		$this->where=$a;
		return $this;
	}
	function table_name($a){
		$this->table_name=$a;
		return $this;
	}
	function select($a){
		$this->field_select=$a;
		return $this;	
	}
	function update(){
		$var='';
		$var_length=count($this->variable);
		for($i=0;$i<$var_length;$i++){
			if($i==$var_length-1){
				$var=$var.$this->variable[$i]."='".$this->value[$i]."'";
			}
			else{
				$var=$var.$this->variable[$i]."='".$this->value[$i]."',";
			}
		}
		$this->query="update ".$this->table_name." set ".$var." where ".$this->where;
		$sql=mysqli_query($this->connection,$this->query);
		return $sql;
	}
	function delete(){
		$this->query="delete from ".$this->table_name." where ".$this->where;
		$sql=mysqli_query($this->connection,$this->query);
		return $sql;
	}
	function create(){
		$var='';
		$val='';
		$var_length=count($this->variable);
		$val_length=count($this->value);
		for($i=0;$i<$var_length;$i++){
			if($i==$var_length-1){
				$var=$var.$this->variable[$i];
			}
			else{
				$var=$var.$this->variable[$i].",";	
			}
		}
		for($j=0;$j<$val_length;$j++){
			if($j==$val_length-1){
				$val=$val."'".$this->value[$j]."'";
			}
			else{
				$val=$val."'".$this->value[$j]."',";
			}
		}
		$this->query="insert into ".$this->table_name."(".$var.") values (".$val.")";
		$sql=mysqli_query($this->connection,$this->query);
		return $sql;
	}
	function result(){
		if(isset($this->inner_join)){
			$inner="";
			for($i=0;$i<count($this->inner_join);$i++){
					$inner.=" inner join ".$this->inner_join[$i]."";
			}
		}

		if(isset($this->order_by)){
			$orby='';
			$orby_length=count($this->order_by);
			for($i=0;$i<$orby_length;$i++){
			if($i==$orby_length-1){
				$orby=$orby.$this->order_by[$i];
			}
			else{
				$orby=$orby.$this->order_by[$i].",";	
			}
		}

if((isset($this->limit))&&(isset($this->offset))){
			if(empty($this->where)){
				if(empty($this->inner_join)){
					$this->query="select ".$this->field_select." from ".$this->table_name." order by ".$orby." limit ".$this->limit." offset ".$this->offset;		
				}
				else{
					$this->query="select ".$this->field_select." from ".$this->table_name." ".$inner." order by ".$orby." limit ".$this->limit." offset ".$this->offset;
				}
			}
			else{
				if(empty($this->inner_join)){
					$this->query="select ".$this->field_select." from ".$this->table_name." where ".$this->where." order by ".$orby." limit ".$this->limit." offset ".$this->offset;				
				}
				else{
					$this->query="select ".$this->field_select." from ".$this->table_name." ".$inner." where ".$this->where." order by ".$orby." limit ".$this->limit." offset ".$this->offset;					
				}
			}
		}
		else{
			if(empty($this->where)){
				if(empty($this->inner_join)){
					$this->query="select ".$this->field_select." from ".$this->table_name." order by ".$orby;		
				}
				else{
					$this->query="select ".$this->field_select." from ".$this->table_name." ".$inner." order by ".$orby;
				}
			}
			else{
				if(empty($this->inner_join)){
					$this->query="select ".$this->field_select." from ".$this->table_name." where ".$this->where." order by ".$orby;		
				}
				else{
					$this->query="select ".$this->field_select." from ".$this->table_name." ".$inner." where ".$this->where." order by ".$orby;			
				}
			}	
		}
	}
	else{
		if((isset($this->limit))&&(isset($this->offset))){
			if(empty($this->where)){
				if(empty($this->inner_join)){
					$this->query="select ".$this->field_select." from ".$this->table_name." limit ".$this->limit." offset ".$this->offset;		
				}
				else{
					$this->query="select ".$this->field_select." from ".$this->table_name." ".$inner." limit ".$this->limit." offset ".$this->offset;
				}
			}
			else{
				if(empty($this->inner_join)){
					$this->query="select ".$this->field_select." from ".$this->table_name." where ".$this->where." limit ".$this->limit." offset ".$this->offset;				
				}
				else{
					$this->query="select ".$this->field_select." from ".$this->table_name." ".$inner." where ".$this->where." limit ".$this->limit." offset ".$this->offset;					
				}
			}
		}
		else{
			if(empty($this->where)){
				if(empty($this->inner_join)){
					$this->query="select ".$this->field_select." from ".$this->table_name;		
				}
				else{
					$this->query="select ".$this->field_select." from ".$this->table_name." ".$inner;
				}
			}
			else{
				if(empty($this->inner_join)){
					$this->query="select ".$this->field_select." from ".$this->table_name." where ".$this->where;		
				}
				else{
					$this->query="select ".$this->field_select." from ".$this->table_name." ".$inner." where ".$this->where;			
				}
			}	
		}
		}
		$sql=mysqli_query($this->connection,$this->query);
		$hasil=array();
		while($isi=mysqli_fetch_assoc($sql)){
			array_push($hasil, $isi);
		}
		return $hasil;
		
	}
	function num_rows(){
		if(isset($this->inner_join)){
			$inner="";
			for($i=0;$i<count($this->inner_join);$i++){
					$inner.=" inner join ".$this->inner_join[$i]."";
			}
		}

		if(isset($this->order_by)){
			$orby='';
			$orby_length=count($this->order_by);
			for($i=0;$i<$orby_length;$i++){
			if($i==$orby_length-1){
				$orby=$orby.$this->order_by[$i];
			}
			else{
				$orby=$orby.$this->order_by[$i].",";	
			}
		}

if((isset($this->limit))&&(isset($this->offset))){
			if(empty($this->where)){
				if(empty($this->inner_join)){
					$this->query="select ".$this->field_select." from ".$this->table_name." order by ".$orby." limit ".$this->limit." offset ".$this->offset;		
				}
				else{
					$this->query="select ".$this->field_select." from ".$this->table_name." ".$inner." order by ".$orby." limit ".$this->limit." offset ".$this->offset;
				}
			}
			else{
				if(empty($this->inner_join)){
					$this->query="select ".$this->field_select." from ".$this->table_name." where ".$this->where." order by ".$orby." limit ".$this->limit." offset ".$this->offset;				
				}
				else{
					$this->query="select ".$this->field_select." from ".$this->table_name." ".$inner." where ".$this->where." order by ".$orby." limit ".$this->limit." offset ".$this->offset;					
				}
			}
		}
		else{
			if(empty($this->where)){
				if(empty($this->inner_join)){
					$this->query="select ".$this->field_select." from ".$this->table_name." order by ".$orby;		
				}
				else{
					$this->query="select ".$this->field_select." from ".$this->table_name." ".$inner." order by ".$orby;
				}
			}
			else{
				if(empty($this->inner_join)){
					$this->query="select ".$this->field_select." from ".$this->table_name." where ".$this->where." order by ".$orby;		
				}
				else{
					$this->query="select ".$this->field_select." from ".$this->table_name." ".$inner." where ".$this->where." order by ".$orby;			
				}
			}	
		}
	}
	else{
		if((isset($this->limit))&&(isset($this->offset))){
			if(empty($this->where)){
				if(empty($this->inner_join)){
					$this->query="select ".$this->field_select." from ".$this->table_name." limit ".$this->limit." offset ".$this->offset;		
				}
				else{
					$this->query="select ".$this->field_select." from ".$this->table_name." ".$inner." limit ".$this->limit." offset ".$this->offset;
				}
			}
			else{
				if(empty($this->inner_join)){
					$this->query="select ".$this->field_select." from ".$this->table_name." where ".$this->where." limit ".$this->limit." offset ".$this->offset;				
				}
				else{
					$this->query="select ".$this->field_select." from ".$this->table_name." ".$inner." where ".$this->where." limit ".$this->limit." offset ".$this->offset;					
				}
			}
		}
		else{
			if(empty($this->where)){
				if(empty($this->inner_join)){
					$this->query="select ".$this->field_select." from ".$this->table_name;		
				}
				else{
					$this->query="select ".$this->field_select." from ".$this->table_name." ".$inner;
				}
			}
			else{
				if(empty($this->inner_join)){
					$this->query="select ".$this->field_select." from ".$this->table_name." where ".$this->where;		
				}
				else{
					$this->query="select ".$this->field_select." from ".$this->table_name." ".$inner." where ".$this->where;			
				}
			}	
		}
		}
		$sql=mysqli_query($this->connection,$this->query);
		return mysqli_num_rows($sql);
		
	}
}
?>