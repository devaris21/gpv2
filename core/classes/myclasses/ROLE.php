<?php
namespace Home;
use Native\RESPONSE;/**
 * 
 */
class ROLE extends TABLE
{

	public static $tableName = __CLASS__;
	public static $namespace = __NAMESPACE__;

	const MODULEEXCEPT = ["fiches", "main"];
	const MASTER     = 1;
	const PRODUCTION = 2;
	const CAISSE     = 3;
	const PARAMETRES = 4;
	const PAYE       = 5;
	const UPDATE     = 6;

	public $name;

	public function enregistre(){
		$data = new RESPONSE;
		if ($this->name != "") {
			$data = $this->save();
		}else{
			$data->status = false;
			$data->message = "Veuillez renseigner le nom du type d'operation !";
		}
		return $data;
	}


	public function sentenseCreate(){
		return $this->sentense = "Ajout d'un nouveau role/accès : $this->name dans les paramétrages";
	}
	public function sentenseUpdate(){
		return $this->sentense = "Modification des informations du role/accès $this->id : $this->name ";
	}
	public function sentenseDelete(){
		return $this->sentense = "Suppression definitive du role/accès $this->id : $this->name";
	}


}
?>