<?php
namespace Home;
use Native\RESPONSE;
use Native\EMAIL;
use Native\FICHIER;
/**
 * 
 */
class COMPTEBANQUE extends TABLE
{
	public static $tableName = __CLASS__;
	public static $namespace = __NAMESPACE__;

	const COURANT = 1;
	const FONDCOMMERCE = 2;

	public $name;
	public $initial = 0;
	public $etablissement;
	public $numero;


	public function enregistre(){
		$data = new RESPONSE;
		if ($this->name != "") {
			if ($this->initial >= 0) {
				$data = $this->save();
			}else{
				$data->status = false;
				$data->message = "Veuillez à bien renseigner le solde initial du compte!";
			}
		}else{
			$data->status = false;
			$data->message = "Veuillez renseigner le nom du produit !";
		}
		return $data;
	}


	public function depot(int $montant, string $comment){
		$params = PARAMS::findLastId();
		$montant = intval($montant);
		if ($montant > 0) {
			$mouvement = new MOUVEMENT();
			$mouvement->typemouvement_id = TYPEMOUVEMENT::DEPOT;
			$mouvement->comptebanque_id = $this->getId();
			$mouvement->montant = $montant;
			$mouvement->comment = $comment;
			$data = $mouvement->enregistre();
		}else{
			$data->status = false;
			$data->message = "Le montant de la transaction n'est pas valide, Veuillez reessayer !";
		}
		return $data;
	}


	public function retrait(int $montant, string $comment){
		$params = PARAMS::findLastId();
		$montant = intval($montant);
		if ($montant > 0) {
			if ($this->solde(PARAMS::DATE_DEFAULT, dateAjoute()) >= $montant) {
				$mouvement = new MOUVEMENT();
				$mouvement->typemouvement_id = TYPEMOUVEMENT::RETRAIT;
				$mouvement->comptebanque_id = $this->getId();
				$mouvement->montant = $montant;
				$mouvement->comment = $comment;
				$data = $mouvement->enregistre();
			}else{
				$data->status = false;
				$data->message = "Le montant que vous essayez de retirer est plus élévé que le solde du compte !";
			}
		}else{
			$data->status = false;
			$data->message = "Le montant de la transaction n'est pas valide, Veuillez reessayer !";
		}
		return $data;
	}




	public function depots(string $date1, string $date2){
		$requette = "SELECT SUM(montant) as montant FROM mouvement WHERE mouvement.typemouvement_id = ? AND mouvement.comptebanque_id = ? AND mouvement.valide = 1 AND DATE(mouvement.created) >= ? AND DATE(mouvement.created) <= ?";
		$item = MOUVEMENT::execute($requette, [TYPEMOUVEMENT::DEPOT, $this->getId(), $date1, $date2]);
		if (count($item) < 1) {$item = [new MOUVEMENT()]; }
		return $item[0]->montant;
	}


	public function retraits(string $date1, string $date2){
		$requette = "SELECT SUM(montant) as montant FROM mouvement WHERE mouvement.typemouvement_id = ? AND mouvement.comptebanque_id = ? AND mouvement.valide = 1 AND DATE(mouvement.created) >= ? AND DATE(mouvement.created) <= ?";
		$item = MOUVEMENT::execute($requette, [TYPEMOUVEMENT::RETRAIT, $this->getId(), $date1, $date2]);
		if (count($item) < 1) {$item = [new MOUVEMENT()]; }
		return $item[0]->montant;
	}


	public function solde(string $date1=null, string $date2=null){
		if ($date1  == null) {
			$date1 = PARAMS::DATE_DEFAULT;
		}
		if ($date2  == null) {
			$date2 = dateAjoute();
		}
		$total = $this->depots($date1, $date2) - $this->retraits($date1, $date2);
		if ($this->created <= dateAjoute1($date2, 1)) {
			return $total + $this->initial;
		}
		return $total;
	}



	public static function tresorerie(){
		$total = 0;
		foreach (static::getAll() as $key => $value) {
			$total += $value->solde();
		}
		return $total;
	}




	public function transaction(int $montant, COMPTEBANQUE $compte, string $comment){
		$params = PARAMS::findLastId();
		$montant = intval($montant);
		$data = $this->retrait($montant, "Retrait de ".money($montant)." ".$params->devise. " du compte pour approvisionner ".$compte->name()." - $comment");
		if ($data->status) {
			$data = $compte->depot($montant, "Approvionnement du compte de ".money($montant)." ".$params->devise. " à partir de ".$this->name()." - $comment");
		}
		return $data;
	}



	public function evolution(string $date1, string $date2){
		$tableaux = [];
		$nb = ceil(dateDiffe($date1, $date2));
		$date = $date1;
		for ($i=$nb; $i > 0 ; $i--) { 
			$date = dateAjoute1($date, 1);
			$data = new \stdclass;
			$data->time = strtotime($date);
			$data->montant = $this->solde($date1, $date);

			$tableaux[] = $data;
		}
		return $tableaux;
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