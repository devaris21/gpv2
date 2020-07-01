<?php
namespace Home;
use Native\RESPONSE;/**
 * 
 */
class TYPEBIEN extends TABLE
{

	public static $tableName = __CLASS__;
	public static $namespace = __NAMESPACE__;
	
	public $name;
	public $min;
	public $max;

	public function enregistre(){
		$data = new RESPONSE;
		if ($this->name != "") {
			$data = $this->save();
		}else{
			$data->status = false;
			$data->message = "Veuillez renseigner le nom du type de bien !";
		}
		return $data;
	}


	public function name(){
		return $this->name." ($this->min ans - $this->max ans) ";
	}

	public function sentenseCreate(){
		return $this->sentense = "Ajout d'un nouveau type de bien : $this->name dans les paramétrages";
	}
	public function sentenseUpdate(){
		return $this->sentense = "Modification des informations du type de bien $this->id : $this->name ";
	}
	public function sentenseDelete(){
		return $this->sentense = "Suppression definitive du type de bien $this->id : $this->name";
	}
}
?>