<?php
namespace Home;
use Native\RESPONSE;

/**
 * 
 */
class ACCES_ENTREPOT extends TABLE
{
	
	
	public static $tableName = __CLASS__;
	public static $namespace = __NAMESPACE__;


	public $entrepot_id;
	public $employe_id;


	public function enregistre(){
		$data = new RESPONSE;
		$datas = ENTREPOT::findBy(["id ="=>$this->entrepot_id]);
		if (count($datas) == 1) {
			$datas = EMPLOYE::findBy(["id ="=>$this->employe_id]);
			if (count($datas) == 1) {
				$datas = static::findBy(["employe_id ="=>$this->employe_id, "entrepot_id ="=>$this->entrepot_id,]);
			if (count($datas) == 0) {
				$data = $this->save();
			}else{
				$data->status = false;
				$data->message = "Vous avez déjà un accès à cette usine !";
			}
			}else{
				$data->status = false;
				$data->message = "Une erreur s'est produite lors de l'opération, veuillez recommencer !";
			}
		}else{
			$data->status = false;
			$data->message = "Une erreur s'est produite lors de l'opération, veuillez recommencer !";
		}
		return $data;
	}



	public function sentenseCreate(){
		return $this->sentense = "Attribution des accès de ".$this->entrepot->name()." à ".$this->employe->name();
	}
	public function sentenseUpdate(){
		return $this->sentense = "Modification des accès de ".$this->entrepot->name()." à ".$this->employe->name();
	}
	public function sentenseDelete(){
		return $this->sentense = "Suppression des accès de ".$this->entrepot->name()." à ".$this->employe->name();
	}
}

?>