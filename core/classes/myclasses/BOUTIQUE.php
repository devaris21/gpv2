<?php
namespace Home;
use Native\RESPONSE;/**
 * 
 */
class BOUTIQUE extends TABLE
{

	public static $tableName = __CLASS__;
	public static $namespace = __NAMESPACE__;

	const PRINCIPAL = 1;

	public $name;
	public $lieu;
	public $comptebanque_id;

	public function enregistre(){
		$data = new RESPONSE;
		if ($this->name != "") {
			$data = $this->save();
			if ($data->status) {

				foreach (PRODUIT::getAll() as $key => $prod) {
					foreach (EMBALLAGE::getAll() as $key => $emb) {
						$ligne = new INITIALPRODUITBOUTIQUE();
						$ligne->produit_id = $prod->id;
						$ligne->emballage_id = $emb->id;
						$ligne->boutique_id = $this->id;
						$ligne->quantite = 0;
						$ligne->enregistre();
					}
				}


				$compte = new COMPTEBANQUE;
				$compte->name = "Compte de ".$this->name();
				$data = $compte->enregistre();
				if ($data->status) {
					$this->comptebanque_id = $data->lastid;
					$this->save();
				}
			}
		}else{
			$data->status = false;
			$data->message = "Veuillez renseigner le nom de la boutique !";
		}
		return $data;
	}


	public function sentenseCreate(){
		return $this->sentense = "Ajout d'un nouveau groupe de vehicule : $this->name dans les paramétrages";
	}
	public function sentenseUpdate(){
		return $this->sentense = "Modification des informations de la boutique $this->id : $this->name ";
	}
	public function sentenseDelete(){
		return $this->sentense = "Suppression definitive de la boutique $this->id : $this->name";
	}

}
?>