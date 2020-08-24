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

	public $stock = 0;


	public function enregistre(){
		$data = new RESPONSE;
		if ($this->name != "") {
			$data = $this->save();
			if ($data->status) {
				foreach (TYPEPRODUIT_PARFUM::getAll() as $key => $type) {
					$ligne = new EXIGENCEPRODUCTION();
					$ligne->typeproduit_parfum_id = $type->id;
					$ligne->quantite_produit = 0;
					$ligne->ressource_id = $this->id;
					$ligne->quantite_ressource = 0;
					$ligne->enregistre();
				}
			}
		}else{
			$data->status = false;
			$data->message = "Veuillez renseigner le nom du produit !";
		}
		return $data;
	}



	public function stock(String $date){
		$total = 0;
		$requette = "SELECT SUM(quantite_recu) as quantite  FROM ligneapprovisionnement, ressource, approvisionnement WHERE ligneapprovisionnement.ressource_id = ressource.id AND ressource.id = ? AND ligneapprovisionnement.approvisionnement_id = approvisionnement.id AND DATE(approvisionnement.created) <= ? AND approvisionnement.etat_id = ? GROUP BY ressource.id";
		$item = LIGNEAPPROVISIONNEMENT::execute($requette, [$this->id, $date, ETAT::VALIDEE]);
		if (count($item) < 1) {$item = [new LIGNEAPPROVISIONNEMENT()]; }
		$total += $item[0]->quantite;


		$requette = "SELECT SUM(consommation) as consommation  FROM ligneconsommationjour, ressource, production WHERE ligneconsommationjour.ressource_id = ressource.id AND ressource.id = ? AND ligneconsommationjour.production_id = production.id AND DATE(production.ladate) <= ? GROUP BY ressource.id";
		$item = LIGNECONSOMMATIONJOUR::execute($requette, [$this->id, $date]);
		if (count($item) < 1) {$item = [new LIGNECONSOMMATIONJOUR()]; }
		$total -= $item[0]->consommation;

		return $total + intval($this->stock);
	}


	public function achat(string $date1 = "2020-04-01", string $date2){
		$total = 0;
		$requette = "SELECT SUM(quantite_recu) as quantite  FROM ligneapprovisionnement, ressource, approvisionnement WHERE ligneapprovisionnement.ressource_id = ressource.id AND ressource.id = ? AND ligneapprovisionnement.approvisionnement_id = approvisionnement.id AND approvisionnement.etat_id = ? AND DATE(approvisionnement.created) >= ? AND DATE(approvisionnement.created) <= ? GROUP BY ressource.id";
		$item = LIGNEAPPROVISIONNEMENT::execute($requette, [$this->id, ETAT::VALIDEE, $date1, $date2]);
		if (count($item) < 1) {$item = [new LIGNEAPPROVISIONNEMENT()]; }
		return $item[0]->quantite;
	}



	public function consommee(string $date1 = "2020-04-01", string $date2){
		$total = 0;
		$datas = $this->fourni("ligneconsommationjour", ["DATE(created) >= " => $date1, "DATE(created) <= " => $date2]);
		foreach ($datas as $key => $ligne) {
			$total += $ligne->consommation;			
		}
		return $total;
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