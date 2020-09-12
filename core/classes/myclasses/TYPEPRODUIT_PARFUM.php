<?php
namespace Home;
use Native\RESPONSE;

/**
 * 
 */
class TYPEPRODUIT_PARFUM extends TABLE
{
	
	
	public static $tableName = __CLASS__;
	public static $namespace = __NAMESPACE__;


	public $parfum_id;
	public $typeproduit_id;
	public $isActive = TABLE::NON;
	public $ressource_id;


	public function enregistre(){
		$data = new RESPONSE;
		$datas = PARFUM::findBy(["id ="=>$this->parfum_id]);
		if (count($datas) == 1) {
			$datas = TYPEPRODUIT::findBy(["id ="=>$this->typeproduit_id]);
			if (count($datas) == 1) {
				$data = $this->save();
				if ($data->status) {

					foreach (QUANTITE::getAll() as $key => $quantite) {
						$prod = new PRODUIT();
						$prod->typeproduit_parfum_id = $this->id;
						$prod->quantite_id = $quantite->id;
						$data = $prod->enregistre();
					}


					foreach (ENTREPOT::getAll() as $key => $exi) {
						$ligne = new INITIALTYPEPRODUITENTREPOT();
						$ligne->entrepot_id = $exi->id;
						$ligne->typeproduit_parfum_id = $this->id;
						$ligne->quantite = 0;
						$ligne->enregistre();
					}

					$ligne = new EXIGENCEPRODUCTION();
					$ligne->typeproduit_parfum_id = $this->id;
					$ligne->quantite = 0;
					$ligne->enregistre();
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



	public function name(){
		$this->actualise();
		return $this->typeproduit->name()." de ".$this->parfum->name();
	}


	public function production(string $date1, string $date2, int $entrepot_id = null){
		$paras = "";
		if ($entrepot_id != null) {
			$paras.= "AND entrepot_id = $entrepot_id ";
		}
		$requette = "SELECT SUM(quantite) as quantite  FROM ligneproduction, production WHERE  ligneproduction.typeproduit_parfum_id = ?  AND ligneproduction.production_id = production.id AND production.etat_id = ? AND ligneproduction.created >= ? AND ligneproduction.created <= ? $paras";
		$item = LIGNEPRODUCTION::execute($requette, [$this->id, ETAT::VALIDEE, $date1, $date2]);
		if (count($item) < 1) {$item = [new LIGNEPRODUCTION()]; }
		return $item[0]->quantite;
	}


	public function conditionne(string $date1, string $date2, int $entrepot_id = null){
		$paras = "";
		if ($entrepot_id != null) {
			$paras.= "AND entrepot_id = $entrepot_id ";
		}
		$requette = "SELECT SUM(quantite) as quantite  FROM conditionnement WHERE  conditionnement.typeproduit_parfum_id = ? AND conditionnement.etat_id != ? AND conditionnement.created >= ? AND conditionnement.created <= ? $paras";
		$item = CONDITIONNEMENT::execute($requette, [$this->id, ETAT::ANNULEE, $date1, $date2]);
		if (count($item) < 1) {$item = [new CONDITIONNEMENT()]; }
		return $item[0]->quantite;
	}


	public function perte(string $date1, string $date2, int $entrepot_id = null){
		$paras = "";
		if ($entrepot_id != null) {
			$paras.= "AND entrepot_id = $entrepot_id ";
		}
		$requette = "SELECT SUM(quantite) as quantite  FROM perteentrepot WHERE perteentrepot.typeproduit_parfum_id = ? AND  perteentrepot.etat_id = ? AND DATE(perteentrepot.created) >= ? AND DATE(perteentrepot.created) <= ? $paras ";
		$item = PERTEENTREPOT::execute($requette, [$this->id, ETAT::VALIDEE, $date1, $date2]);
		if (count($item) < 1) {$item = [new PERTEENTREPOT()]; }
		return $item[0]->quantite;
	}


	public function enStock(string $date1, string $date2, int $entrepot_id){
		$item = $this->fourni("initialtypeproduitentrepot", ["entrepot_id ="=>$entrepot_id])[0];
		return $this->production($date1, $date2, $entrepot_id) - $this->conditionne($date1, $date2, $entrepot_id) - $this->perte($date1, $date2, $entrepot_id) + $item->quantite;
	}


	public function changerMode(){
		if ($this->isActive == TABLE::OUI) {
			$this->isActive = TABLE::NON;
		}else{
			$this->isActive = TABLE::OUI;
			$pro = PRODUCTION::today();
			$datas = LIGNEPRODUCTION::findBy(["production_id ="=>$pro->id, "produit_id ="=>$pdv->id]);
			if (count($datas) == 0) {
				$ligne = new LIGNEPRODUCTION();
				$ligne->production_id = $pro->id;
				$ligne->produit_id = $pdv->id;
				$ligne->enregistre();
			}			
		}
		return $this->save();
	}



	public function sentenseCreate(){
		return $this->sentense = "Ajout d'un nouveau type de production : $this->name dans les paramétrages";
	}
	public function sentenseUpdate(){
		return $this->sentense = "Modification des informations du type de production $this->id : $this->name ";
	}
	public function sentenseDelete(){
		return $this->sentense = "Suppression definitive du type de production $this->id : $this->name";
	}
}

?>