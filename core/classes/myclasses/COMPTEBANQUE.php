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
			$mouvement->name = "Depôt sur le compte";
			$mouvement->typemouvement_id = TYPEMOUVEMENT::DEPOT;
			$mouvement->comptebanque_id = $this->id;
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
				$mouvement->name = "Retrait sur le compte";
				$mouvement->typemouvement_id = TYPEMOUVEMENT::RETRAIT;
				$mouvement->comptebanque_id = $this->id;
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




	public function getIn(string $date1, string $date2){
		$requette = "SELECT SUM(montant) as montant FROM mouvement WHERE mouvement.typemouvement_id = ? AND mouvement.comptebanque_id = ? AND mouvement.valide = 1 AND DATE(mouvement.created) >= ? AND DATE(mouvement.created) <= ?";
		$item = MOUVEMENT::execute($requette, [TYPEMOUVEMENT::DEPOT, $this->id, $date1, $date2]);
		if (count($item) < 1) {$item = [new MOUVEMENT()]; }
		return $item[0]->montant;
	}


	public function getOut(string $date1, string $date2){
		$requette = "SELECT SUM(montant) as montant FROM mouvement WHERE mouvement.typemouvement_id = ? AND mouvement.comptebanque_id = ? AND mouvement.valide = 1 AND DATE(mouvement.created) >= ? AND DATE(mouvement.created) <= ?";
		$item = MOUVEMENT::execute($requette, [TYPEMOUVEMENT::RETRAIT, $this->id, $date1, $date2]);
		if (count($item) < 1) {$item = [new MOUVEMENT()]; }
		return $item[0]->montant;
	}


	public function solde(string $date1=null, string $date2=null){
		if ($date1  == null) {
			$date1 = PARAMS::DATE_DEFAULT;
		}
		if ($date2  == null) {
			$date2 = dateAjoute(+1);
		}
		$total = $this->getIn($date1, $date2) - $this->getOut($date1, $date2);
		return $total + $this->initial;
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



	// public function evolution(string $date1, string $date2){
	// 	$tableaux = [];
	// 	$nb = ceil(dateDiffe($date1, $date2));
	// 	$date = $date1;
	// 	for ($i=$nb; $i > 0 ; $i--) { 
	// 		$date = dateAjoute1($date, 1);
	// 		$data = new \stdclass;
	// 		$data->year = date("Y", strtotime($date));
	// 		$data->month = date("m", strtotime($date));
	// 		$data->day = date("d", strtotime($date));
	// 		$data->montant = $this->solde(null, $date);

	// 		$tableaux[] = $data;
	// 	}
	// 	return $tableaux;
	// }



	public function stats(string $date1 = "2020-04-01", string $date2){
		$tableaux = [];
		$nb = ceil(dateDiffe($date1, $date2) / 12);
		$index = $date1;
		while ( $index <= $date2 ) {
			$debut = $index;
			$fin = dateAjoute1($index, $nb);

			$data = new \stdclass;
			$data->year = date("Y", strtotime($index));
			$data->month = date("m", strtotime($index));
			$data->day = date("d", strtotime($index));
			$data->nb = $nb;
			////////////

			$data->sortie = $this->getOut($debut, $fin);
			$data->entree = $this->getIn($debut, $fin);
			$data->solde = static::solde($date1, $fin);

			$tableaux[] = $data;
			///////////////////////

			$index = $fin;
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