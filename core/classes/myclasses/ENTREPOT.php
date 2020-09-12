<?php
namespace Home;
use Native\RESPONSE;/**
 * 
 */
class ENTREPOT extends TABLE
{

	public static $tableName = __CLASS__;
	public static $namespace = __NAMESPACE__;

	const PRINCIPAL = 1;

	public $name;
	public $comptebanque_id;

	public function enregistre(){
		$data = new RESPONSE;
		if ($this->name != "") {
			$data = $this->save();
			if ($data->status) {
				$compte = new COMPTEBANQUE;
				$compte->name = "Compte de ".$this->name();
				$data = $compte->enregistre();
				if ($data->status) {
					$this->comptebanque_id = $data->lastid;
					$this->save();
				}

				foreach (EMBALLAGE::getAll() as $key => $exi) {
					$ligne = new INITIALEMBALLAGEENTREPOT();
					$ligne->entrepot_id = $this->id;
					$ligne->emballage_id = $exi->id;
					$ligne->quantite = 0;
					$ligne->enregistre();

					foreach (PRODUIT::getAll() as $key => $prod) {
						$ligne = new INITIALPRODUITENTREPOT();
						$ligne->entrepot_id = $this->id;
						$ligne->produit_id = $prod->id;
						$ligne->emballage_id = $exi->id;
						$ligne->quantite = 0;
						$ligne->enregistre();
					}
				}




				foreach (RESSOURCE::getAll() as $key => $exi) {
					$ligne = new INITIALRESSOURCEENTREPOT();
					$ligne->entrepot_id = $this->id;
					$ligne->ressource_id = $exi->id;
					$ligne->quantite = 0;
					$ligne->enregistre();
				}


				foreach (ETIQUETTE::getAll() as $key => $exi) {
					$ligne = new INITIALETIQUETTEENTREPOT();
					$ligne->entrepot_id = $this->id;
					$ligne->etiquette_id = $exi->id;
					$ligne->quantite = 0;
					$ligne->enregistre();
				}


				foreach (TYPEPRODUIT_PARFUM::getAll() as $key => $exi) {
					$ligne = new INITIALTYPEPRODUITENTREPOT();
					$ligne->entrepot_id = $this->id;
					$ligne->typeproduit_parfum_id = $exi->id;
					$ligne->quantite = 0;
					$ligne->enregistre();
				}

			}
		}else{
			$data->status = false;
			$data->message = "Veuillez renseigner le nom de l'entrepot !";
		}
		return $data;
	}


	public function sentenseCreate(){
		return $this->sentense = "Creation d'une nouvel entrepôt : $this->name";
	}
	public function sentenseUpdate(){
		return $this->sentense = "Modification des informations de l'entrepôt $this->id : $this->name ";
	}
	public function sentenseDelete(){
		return $this->sentense = "Suppression definitive de l'entrepôt $this->id : $this->name";
	}


}
?>