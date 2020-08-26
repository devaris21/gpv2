<?php
namespace Home;
use Native\RESPONSE;
use Native\EMAIL;
use Native\FICHIER;
/**
 * 
 */
class RESSOURCE extends TABLE
{
	public static $tableName = __CLASS__;
	public static $namespace = __NAMESPACE__;

	public $name;
	public $initial;
	public $unite;
	public $abbr;


	public function enregistre(){
		$data = new RESPONSE;
		if ($this->name != "") {
			$data = $this->save();
			if ($data->status) {
				foreach (EXIGENCEPRODUCTION::getAll() as $key => $exi) {
					$ligne = new LIGNEEXIGENCEPRODUCTION();
					$ligne->exigenceproduction_id = $exi->id;
					$ligne->ressource_id = $this->id;
					$ligne->quantite = 0;
					$ligne->enregistre();
				}
			}
		}else{
			$data->status = false;
			$data->message = "Veuillez renseigner le nom du produit !";
		}
		return $data;
	}



	public function stock(String $date1, String $date2, int $entrepot_id = null){
		return $this->achat($date1, $date2, $entrepot_id) - $this->consommee($date1, $date2, $entrepot_id) - $this->perte($date1, $date2, $entrepot_id) + intval($this->initial);
	}


	public function achat(string $date1, string $date2, int $entrepot_id = null){
		$paras = "";
		if ($entrepot_id != null) {
			$paras.= "AND entrepot_id = $entrepot_id ";
		}
		$requette = "SELECT SUM(quantite_recu) as quantite  FROM ligneapprovisionnement, ressource, approvisionnement WHERE ligneapprovisionnement.ressource_id = ressource.id AND ressource.id = ? AND ligneapprovisionnement.approvisionnement_id = approvisionnement.id AND approvisionnement.etat_id = ? AND DATE(approvisionnement.created) >= ? AND DATE(approvisionnement.created) <= ? $paras GROUP BY ressource.id";
		$item = LIGNEAPPROVISIONNEMENT::execute($requette, [$this->id, ETAT::VALIDEE, $date1, $date2]);
		if (count($item) < 1) {$item = [new LIGNEAPPROVISIONNEMENT()]; }
		return $item[0]->quantite;
	}



	public function consommee(string $date1, string $date2, int $entrepot_id = null){
		$paras = "";
		if ($entrepot_id != null) {
			$paras.= "AND entrepot_id = $entrepot_id ";
		}
		$requette = "SELECT SUM(quantite) as quantite  FROM ligneconsommation, ressource, production WHERE ligneconsommation.ressource_id = ressource.id AND ressource.id = ? AND ligneconsommation.production_id = production.id AND production.etat_id = ? AND DATE(production.created) >= ? AND DATE(production.created) <= ? $paras GROUP BY ressource.id";
		$item = LIGNECONSOMMATION::execute($requette, [$this->id, ETAT::VALIDEE, $date1, $date2]);
		if (count($item) < 1) {$item = [new LIGNECONSOMMATION()]; }
		return $item[0]->quantite;
	}



	public function perte(string $date1, string $date2, int $entrepot_id = null){
		$paras = "";
		if ($entrepot_id != null) {
			$paras.= "AND entrepot_id = $entrepot_id ";
		}
		$requette = "SELECT SUM(quantite) as quantite  FROM perteentrepot, ressource WHERE perteentrepot.ressource_id = ressource.id = ? AND  perteentrepot.etat_id = ? AND DATE(perteentrepot.created) >= ? AND DATE(perteentrepot.created) <= ? $paras ";
		$item = PERTEENTREPOT::execute($requette, [$this->id, ETAT::VALIDEE, $date1, $date2]);
		if (count($item) < 1) {$item = [new PERTEENTREPOT()]; }
		return $item[0]->quantite;
	}


	public function en_cours(){
		$total = 0;
		$requette = "SELECT SUM(quantite) as quantite  FROM ligneapprovisionnement, ressource, approvisionnement WHERE ligneapprovisionnement.ressource_id = ressource.id AND ressource.id = ? AND ligneapprovisionnement.approvisionnement_id = approvisionnement.id AND approvisionnement.etat_id = ? GROUP BY ressource.id";
		$item = LIGNEAPPROVISIONNEMENT::execute($requette, [$this->id, ETAT::ENCOURS]);
		if (count($item) < 1) {$item = [new LIGNEAPPROVISIONNEMENT()]; }
		return $item[0]->quantite;
	}



	public function exigence(int $quantite, int $produit_id){
		$datas = EXIGENCEPRODUCTION::findBy(["ressource_id ="=>$this->id, "produit_id ="=>$produit_id]);
		if (count($datas) == 1) {
			$item = $datas[0];
			if ($item->quantite_ressource == 0) {
				return 0;
			}
			return ($quantite * $item->quantite_produit) / $item->quantite_ressource;
		}
		return 0;
	}



	public function price(){
		$requette = "SELECT SUM(quantite_recu) as quantite, SUM(ligneapprovisionnement.price) as price FROM ligneapprovisionnement, ressource, approvisionnement WHERE ligneapprovisionnement.ressource_id = ressource.id AND ressource.id = ? AND ligneapprovisionnement.approvisionnement_id = approvisionnement.id AND approvisionnement.etat_id = ? GROUP BY ressource.id";
		$datas = LIGNEAPPROVISIONNEMENT::execute($requette, [$this->id, ETAT::VALIDEE]);
		if (count($datas) < 1) {$datas = [new LIGNEAPPROVISIONNEMENT()]; }
		$item = $datas[0];
		if ($item->quantite == 0) {
			return 0;
		}
		$total = $item->price / $item->quantite;

		return $total;
	}




	public function sentenseCreate(){
		return $this->sentense = "Ajout d'une nouvelle ressource : $this->name dans les paramétrages";
	}
	public function sentenseUpdate(){
		return $this->sentense = "Modification des informations de la ressource $this->id : $this->name ";
	}
	public function sentenseDelete(){
		return $this->sentense = "Suppression definitive de la ressource $this->id : $this->name";
	}


}



?>