<?php
namespace Home;
use Native\RESPONSE;/**
 * 
 */
class TYPEAPPROVISIONNEMENT extends TABLE
{

	public static $tableName = __CLASS__;
	public static $namespace = __NAMESPACE__;

	const RESSOURCE      = 1;
	const EMBALLAGE = 2;
	const ETIQUETTE = 3;
	
	public $name;

	public function enregistre(){
		$data = new RESPONSE;
		if ($this->name != "") {
			$data = $this->save();
		}else{
			$data->status = false;
			$data->message = "Veuillez renseigner le nom du type de ressource !";
		}
		return $data;
	}


	public function sentenseCreate(){
		return $this->sentense = "Ajout d'un nouveau type d'approvisionnement : $this->name dans les paramétrages";
	}
	public function sentenseUpdate(){
		return $this->sentense = "Modification des informations du type d'approvisionnement $this->id : $this->name ";
	}
	public function sentenseDelete(){
		return $this->sentense = "Suppression definitive du type d'approvisionnement $this->id : $this->name";
	}
}
?>