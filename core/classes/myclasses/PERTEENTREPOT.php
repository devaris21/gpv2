<?php
namespace Home;
use Native\RESPONSE;

/**
 * 
 */
class PERTEENTREPOT extends TABLE
{
	
	
	public static $tableName = __CLASS__;
	public static $namespace = __NAMESPACE__;


	public $etiquette_id;
	public $emballage_id;
	public $ressource_id;
	public $produit_id;
	public $quantite;
	public $etat_id = ETAT::VALIDEE;
	public $entrepot_id;
	public $employe_id;


	public function enregistre(){
		$data = new RESPONSE;
		if ($this->quantite > 0) {
			$this->employe_id = getSession("employe_connecte_id");
			$this->entrepot_id = getSession("entrepot_connecte_id");
			$data = $this->save();
		}else{
			$data->status = false;
			$data->message = "Erreur sur la quantité perdue !";
		}
		return $data;
	}




	public function sentenseCreate(){}
	public function sentenseUpdate(){}
	public function sentenseDelete(){}
}

?>