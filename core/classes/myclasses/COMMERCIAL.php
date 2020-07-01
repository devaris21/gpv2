<?php
namespace Home;
use Native\RESPONSE;
use Native\FICHIER;
use \DateTime;
use \DateInterval;
/**
/**
 * 
 */
class COMMERCIAL extends PERSONNE
{
	public static $tableName = __CLASS__;
	public static $namespace = __NAMESPACE__;

	const MAGASIN = 1;

	public $name;
	public $nationalite;
	public $adresse;
	public $sexe_id = SEXE::HOMME;
	public $contact;
	public $salaire = 0;
	public $objectif = 0;
	public $image = "default.png";
	
	public $disponibilite_id = DISPONIBILITE::LIBRE;



	public function enregistre(){
		$data = new RESPONSE;
		if ($this->name ) {
			if ($this->salaire >= 0 ) {
				$data = $this->save();
				if ($data->status) {
					$this->uploading($this->files);
				}
			}else{
				$data->status = false;
				$data->message = "Le salaire du chauffeur est incorrect !";
			}
		}else{
			$data->status = false;
			$data->message = "Veuillez le login et le mot de passe du nouvel chauffeur !";
		}
		return $data;
	}


	public function uploading(Array $files){
		//les proprites d'images;
		$tab = ["image"];
		if (is_array($files) && count($files) > 0) {
			$i = 0;
			foreach ($files as $key => $file) {
				if ($file["tmp_name"] != "") {
					$image = new FICHIER();
					$image->hydrater($file);
					if ($image->is_image()) {
						$a = substr(uniqid(), 5);
						$result = $image->upload("images", "commercials", $a);
						$name = $tab[$i];
						$this->$name = $result->filename;
						$this->save();
					}
				}	
				$i++;			
			}			
		}
	}



	public function rapports($date1, $date2)
	{
		$tableau = [];
		for ($i=0; $i < $jours ; $i++) { 
			$date = dateAjoute(-$i);
			$datas = $this->fourni("prospection", ["DATE(created) ="=>$date]);
			$item = new \stdClass();
			if (date('w', strtotime($date)) == 0) {
				$item->date = "";
				$item->count = 0;
				$item->montant = 0;
				$item->vendu = 0;
			}else{
				$item->date = $date;
				$item->count = count($datas);
				$item->montant = comptage($datas, 'montant', "somme");
				$item->vendu = comptage($datas, 'vendu', "somme");
			}			
			$tableau[] = $item;
		}
		return $tableau;
	}



	public static function libres(){
		return static::findBy(["disponibilite_id =" => DISPONIBILITE::LIBRE]);
	}

	public static function mission(){
		return static::findBy(["disponibilite_id =" => DISPONIBILITE::MISSION, 'visibility ='=>1]);
	}


	public function salaireDuMois(){
		$datas = $this->fourni('paye', ["etat_id ="=>ETAT::ENCOURS], [], ["started"=>"DESC"]);
		if (count($datas) > 0) {
			$paye = $datas[0];
			$date = date("Y-m-d", strtotime(dateAjoute1($paye->created, 1)));
		}else{
			$date = date("Y-m")."-01";
		}
		$vendu = comptage($this->vendu($date, dateAjoute()), "vendu", "somme");
		$nombre = 0;
		$index = $date;
		while ($index <= dateAjoute()) {
			if (!isJourFerie($index)) {
				$nombre++;
			}
			$index = dateAjoute1($index, 1);
		}

		if ($nombre == 0) {
			return 0;
		}else{
			if ($vendu >= ($nombre * $this->objectif)) {
				return $this->salaire;
			}else{
				return round((($vendu * 0.1)), 2);
			}
		}
	}


	public function bonus(){
		$salaire = $this->salaireDuMois();
		if ($salaire > $this->salaire) {
			return ($salaire - $this->salaire) * 0.1;
		}
		return 0;
	}


	public function arrieres(){
		$total = 0;
		$requette = "SELECT SUM(montant) as montant, SUM(bonus) as bonus FROM paye WHERE paye.commercial_id = ? AND paye.valide = 1";
		$item = PAYE::execute($requette, [$this->getId()]);
		if (count($item) < 1) {$item = [new PAYE()]; }
		$total += $item[0]->montant + $item[0]->bonus;

		$requette = "SELECT SUM(mouvement.montant) as montant FROM lignepayement, mouvement WHERE lignepayement.mouvement_id = mouvement.id AND lignepayement.commercial_id = ? AND lignepayement.valide = 1 AND mouvement.valide = 1";
		$item = MOUVEMENT::execute($requette, [$this->getId()]);
		if (count($item) < 1) {$item = [new MOUVEMENT()]; }
		$total -= $item[0]->montant;
		if ($total < 0) {
			return 0;
		}
		return $total;
	}


	public function salaireNet(){
		return $this->arrieres() + $this->salaireDuMois() + $this->bonus();
	}


	public function vendu(string $date1 = "2020-06-01", string $date2){
		return PROSPECTION::findBy(["commercial_id ="=>$this->getId(), "etat_id !="=>ETAT::ANNULEE, "DATE(prospection.created) >="=>$date1, "DATE(prospection.created) <="=>$date2]);
	}



	public static function finDuMois(){
		foreach (static::getAll() as $key => $commercial) {
			$test = false;
			$datas = $commercial->fourni("paye", ["etat_id ="=>ETAT::ENCOURS]);
			foreach ($datas as $key => $paye) {
				if (date("Y-m", strtotime($paye->started)) < date("Y-m")) {
					$paye->finished = dateAjoute1((date("Y-m")."-01"), -1);
					$paye->montant = $commercial->salaireDuMois();
					$paye->bonus = $commercial->bonus();
					$paye->etat_id = ETAT::VALIDEE;
					$paye->save();
					$test = true;
				}
			}

			if ($test) {
				$paye = new PAYE();
				$paye->commercial_id = $commercial->getId();
				$paye->started = date("Y-m")."-01";
				$data = $paye->enregistre();
			}
		}
	}



	public function stats(string $date1 = "2020-04-01", string $date2){
		$tableaux = [];
		$nb = ceil(dateDiffe($date1, $date2) / 30);
		$index = $date1;
		while ( $index <= $date2 ) {
			$debut = $index;
			$fin = dateAjoute1($index, 1);

			$data = new \stdclass;
			$data->year = date("Y", strtotime($index));
			$data->month = date("m", strtotime($index));
			$data->day = date("d", strtotime($index));
			$data->nb = $nb;
			////////////

			$data->vendu = comptage($this->vendu($fin, $fin), "vendu", "somme");

			$tableaux[] = $data;
			///////////////////////
			
			$index = $fin;
		}
		return $tableaux;
	}



	public function sentenseCreate(){
		return $this->sentense = "Ajout d'un nouveau chauffeur dans votre gestion : $this->name $this->lastname";
	}


	public function sentenseUpdate(){
		return $this->sentense = "Modification des informations du chauffeur N°$this->id : $this->name $this->lastname.";
	}


	public function sentenseDelete(){
		return $this->sentense = "Suppression définitive du chauffeur N°$this->id : $this->name $this->lastname.";
	}



}

?>