<?php
namespace Home;
use Native\RESPONSE;/**
 * 
 */
class TYPEBAREME extends TABLE
{

	public static $tableName = __CLASS__;
	public static $namespace = __NAMESPACE__;

	const NORMAL = 1;
	const GROS = 2;

	public $name;

	public function enregistre(){
		$data = new RESPONSE;
		if ($this->name != "") {
			$data = $this->save();
		}else{
			$data->status = false;
			$data->message = "Veuillez renseigner le nom de la dotation !";
		}
		return $data;
	}


	public function sentenseCreate(){
		return $this->sentense = "Ajout d'un nouveau type de sinistre : $this->name dans les paramétrages";
	}
	public function sentenseUpdate(){
		return $this->sentense = "Modification des informations du type de sinistre $this->id : $this->name ";
	}
	public function sentenseDelete(){
		return $this->sentense = "Suppression definitive du type de sinistre $this->id : $this->name";
	}
}
?>