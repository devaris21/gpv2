<?php
namespace Home;
use Native\RESPONSE;

/**
 * 
 */
class ACCES_BOUTIQUE extends TABLE
{
	
	
	public static $tableName = __CLASS__;
	public static $namespace = __NAMESPACE__;


	public $employe_id;
	public $boutique_id;


	public function enregistre(){
		$data = new RESPONSE;
		$datas = EMPLOYE::findBy(["id ="=>$this->employe_id]);
		if (count($datas) == 1) {
			$datas = BOUTIQUE::findBy(["id ="=>$this->boutique_id]);
			if (count($datas) == 1) {
				$datas = static::findBy(["boutique_id ="=>$this->boutique_id, "employe_id ="=>$this->employe_id,]);
			if (count($datas) == 0) {
				$data = $this->save();
			}else{
				$data->status = false;
				$data->message = "Vous avez déjà un accès à cette boutique !";
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
		return $this->sentense = "Attribution des accès de ".$this->boutique->name()." à ".$this->employe->name();
	}
	public function sentenseUpdate(){
		return $this->sentense = "Modification des accès de ".$this->boutique->name()." à ".$this->employe->name();
	}
	public function sentenseDelete(){
		return $this->sentense = "Suppression des accès de ".$this->boutique->name()." à ".$this->employe->name();
	}
}

?>