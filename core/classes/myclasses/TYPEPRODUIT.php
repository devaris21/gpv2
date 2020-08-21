<?php
namespace Home;
use Native\RESPONSE;/**
 * 
 */
class TYPEPRODUIT extends TABLE
{

	public static $tableName = __CLASS__;
	public static $namespace = __NAMESPACE__;
	
	public $name;
	public $unite;
	public $abbr;
	public $isActive = TABLE::OUI;

	public function enregistre(){
		$data = new RESPONSE;
		if ($this->name != "") {
			$data = $this->save();
			if ($data->status) {

				foreach (PARFUM::getAll() as $key => $parfum) {
					$ligne = new TYPEPRODUIT_PARFUM();
					$ligne->parfum_id = $parfum->id;
					$ligne->typeproduit_id = $this->id;
					$ligne->enregistre();
				}

			}
		}else{
			$data->status = false;
			$data->message = "Veuillez renseigner le nom du type de ressource !";
		}
		return $data;
	}


	public function sentenseCreate(){
		return $this->sentense = "Ajout d'un nouveau type de ressource : $this->name dans les paramétrages";
	}
	public function sentenseUpdate(){
		return $this->sentense = "Modification des informations du type de ressource $this->id : $this->name ";
	}
	public function sentenseDelete(){
		return $this->sentense = "Suppression definitive du type de ressource $this->id : $this->name";
	}
}
?>