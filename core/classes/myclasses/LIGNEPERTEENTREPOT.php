<?php
namespace Home;
use Native\RESPONSE;

/**
 * 
 */
class LIGNEPERTEENTREPOT extends TABLE
{
	
	
	public static $tableName = __CLASS__;
	public static $namespace = __NAMESPACE__;


	public $perteentrepot_id;
	public $prixdevente_id;
	public $perte;


	public function enregistre(){
		$data = new RESPONSE;
		$datas = PERTEENTREPOT::findBy(["id ="=>$this->perteentrepot_id]);
		if (count($datas) == 1) {
			$datas = PRIXDEVENTE::findBy(["id ="=>$this->prixdevente_id]);
			if (count($datas) == 1) {
				if ($this->perte > 0) {
					$data = $this->save();
				}				
			}else{
				$data->status = false;
				$data->message = "Une erreur s'est produite lors de la mise en boutique du produit !";
			}			
		}else{
			$data->status = false;
			$data->message = "Une erreur s'est produite lors de la mise en boutique du produit !";
		}
		return $data;
	}




	public function sentenseCreate(){}
	public function sentenseUpdate(){}
	public function sentenseDelete(){}
}

?>