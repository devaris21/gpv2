<?php
namespace Home;
use Native\RESPONSE;/**
 * 
 */
class PALIER extends TABLE
{

	public static $tableName = __CLASS__;
	public static $namespace = __NAMESPACE__;
	
	public $name;
	public $min;
	public $max;
	public $reduction;
	public $typereduction_id;

	public function enregistre(){
		$data = new RESPONSE;
		if ($this->name != "") {
			if ($this->min < $this->max && $this->min >= 0) {
				$data = $this->save();
			}else{
				$data->status = false;
				$data->message = "Veuillez verifier les prix minimum et maximum des paliers !";
			}
		}else{
			$data->status = false;
			$data->message = "Veuillez renseigner le nom du type de bien !";
		}
		return $data;
	}


	public function name(){
		return $this->name;
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