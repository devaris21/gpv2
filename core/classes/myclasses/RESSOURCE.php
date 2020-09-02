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
	public $initial = 0;
	public $unite;
	public $abbr;
	public $price = 0;
	public $isActive = TABLE::OUI;


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
		$requette = "SELECT SUM(quantite_recu) as quantite  FROM ligneapprovisionnement, approvisionnement WHERE ligneapprovisionnement.ressource_id = ? AND ligneapprovisionnement.approvisionnement_id = approvisionnement.id AND approvisionnement.etat_id = ? AND DATE(approvisionnement.created) >= ? AND DATE(approvisionnement.created) <= ? $paras ";
		$item = LIGNEAPPROVISIONNEMENT::execute($requette, [$this->id, ETAT::VALIDEE, $date1, $date2]);
		if (count($item) < 1) {$item = [new LIGNEAPPROVISIONNEMENT()]; }
		return $item[0]->quantite;
	}



	public function consommee(string $date1, string $date2, int $entrepot_id = null){
		$paras = "";
		if ($entrepot_id != null) {
			$paras.= "AND entrepot_id = $entrepot_id ";
		}
		$requette = "SELECT SUM(quantite) as quantite  FROM ligneconsommation, production WHERE ligneconsommation.ressource_id =  ? AND ligneconsommation.production_id = production.id AND production.etat_id = ? AND DATE(production.created) >= ? AND DATE(production.created) <= ? $paras ";
		$item = LIGNECONSOMMATION::execute($requette, [$this->id, ETAT::VALIDEE, $date1, $date2]);
		if (count($item) < 1) {$item = [new LIGNECONSOMMATION()]; }
		return $item[0]->quantite;
	}



	public function perte(string $date1, string $date2, int $entrepot_id = null){
		$paras = "";
		if ($entrepot_id != null) {
			$paras.= "AND entrepot_id = $entrepot_id ";
		}
		$requette = "SELECT SUM(quantite) as quantite  FROM perteentrepot WHERE perteentrepot.ressource_id = ? AND  perteentrepot.etat_id = ? AND DATE(perteentrepot.created) >= ? AND DATE(perteentrepot.created) <= ? $paras ";
		$item = PERTEENTREPOT::execute($requette, [$this->id, ETAT::VALIDEE, $date1, $date2]);
		if (count($item) < 1) {$item = [new PERTEENTREPOT()]; }
		return $item[0]->quantite;
	}




	public function neccessite(int $quantite, int $typeproduit_parfum_id){
		$datas = EXIGENCEPRODUCTION::findBy(["typeproduit_parfum_id ="=>$typeproduit_parfum_id]);
		foreach ($datas as $key => $exi) {
			foreach ($exi->fourni("ligneexigenceproduction", ["ressource_id ="=>$this->id]) as $key => $ligne) {
				if ($ligne->quantite > 0) {
					$total += ($quantite * $ligne->quantite) / $exi->quantite ;
				}
			}
		}
		return $total;
	}



	public function price(){
		$requette = "SELECT SUM(quantite_recu) as quantite, SUM(transport) as transport, SUM(ligneapprovisionnement.price) as price FROM ligneapprovisionnement, approvisionnement WHERE ligneapprovisionnement.ressource_id = ? AND ligneapprovisionnement.approvisionnement_id = approvisionnement.id AND approvisionnement.etat_id = ? ";
		$datas = LIGNEAPPROVISIONNEMENT::execute($requette, [$this->id, ETAT::VALIDEE]);
		if (count($datas) < 1) {$datas = [new LIGNEAPPROVISIONNEMENT()]; }
		$item = $datas[0];

		$requette = "SELECT SUM(quantite_recu) as quantite FROM ligneapprovisionnement, approvisionnement WHERE ligneapprovisionnement.approvisionnement_id = approvisionnement.id AND approvisionnement.id IN (SELECT approvisionnement_id FROM ligneapprovisionnement WHERE ligneapprovisionnement.ressource_id = ? ) AND approvisionnement.etat_id = ? ";
		$datas = LIGNEAPPROVISIONNEMENT::execute($requette, [$this->id, ETAT::VALIDEE]);
		if (count($datas) < 1) {$datas = [new LIGNEAPPROVISIONNEMENT()]; }
		$ligne = $datas[0];

		if ($item->quantite == 0) {
			return 0;
		}
		if (intval($this->price) <= 0) {
			$total = ($item->price / $item->quantite) + ($item->transport / $ligne->quantite);
			return $total;
		}
		return $this->price + ($item->transport / $ligne->quantite);
	}


	public static function ruptureEntrepot(int $entrepot_id = null){
		$params = PARAMS::findLastId();
		$datas = static::getAll();
		foreach ($datas as $key => $item) {
			if ($item->stock(PARAMS::DATE_DEFAULT, dateAjoute(1), $entrepot_id) > $params->ruptureStock) {
				unset($datas[$key]);
			}
		}
		return $datas;
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