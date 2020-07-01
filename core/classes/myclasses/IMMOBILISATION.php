<?php
namespace Home;
use Native\RESPONSE;
use Native\EMAIL;
/**
 * 
 */
class IMMOBILISATION extends TABLE
{
	public static $tableName = __CLASS__;
	public static $namespace = __NAMESPACE__;

	public $name;
	public $typeimmobilisation_id;
	public $montant;
	public $started;
	public $comment;

	public $duree;
	public $typeamortissement_id;
	public $comptebanque_id;



	public function enregistre(){
		$data = new RESPONSE;
		$params = PARAMS::findLastId();
		if ($this->name != "") {
			if ($this->started <= dateAjoute()) {
				if ($this->montant > 0) {
					if ($this->montant >= $params->minImmobilisation) {
						$datas = COMPTEBANQUE::findBy(["id ="=>$this->comptebanque_id]);
						if (count($datas) == 1) {
							$compte = $datas[0];
							if ($compte->solde() >= $this->montant) {
								$compte->retrait($this->montant, "Retrait de ".money($this->montant)." pour nouvelle immobilisation de ".$this->name());

								$data = $this->save();
								if ($data->status && dateDiffe($this->started, dateAjoute()) < (365*$this->duree)) {
									if ($this->typeimmobilisation_id != TYPEIMMOBILISATION::FINANCIERE) {
										$amortissement = new AMORTISSEMENT();
										$amortissement->cloner($this);
										$amortissement->setId(null);
										$amortissement->immobilisation_id = $this->getId();
										$amortissement->typeamortissement_id = $this->typeamortissement_id;
										$data = $amortissement->enregistre();
									}
								}
							}else{
								$data->status = false;
								$data->message = "Le compte selectionné n'a pas un solde suffisant !";
							}
						}else{
							$data->status = false;
							$data->message = "Une erreur s'est produite lors de l'operation, veuillez recommencer !";
						}
					}else{
						$data->status = false;
						$data->message = "La valeur du bien n'est pas suffisante pour prétendre à une immobilisation ! Veuillez la déclarer comme <b>une charge</b>";
					}
				}else{
					$data->status = false;
					$data->message = "Veuillez à bien renseigner le montant de la nouvelle immobilisation !";
				}
			}else{
				$data->status = false;
				$data->message = "Veuillez à bien renseigner la date de début d'utilisation !";
			}
		}else{
			$data->status = false;
			$data->message = "Veuillez renseigner le libéllé de la nouvelle immobilisation  !";
		}
		return $data;
	}


	public static function total(){
		return comptage(static::getAll(), "montant", "somme");
	}


	public function amortis(){
		$requette = "SELECT SUM(ligneamortissement.montant) as montant  FROM amortissement, ligneamortissement, immobilisation WHERE amortissement.immobilisation_id = immobilisation.id AND ligneamortissement.amortissement_id = amortissement.id AND immobilisation.id = ? AND amortissement.valide = 1 ";
		$item = LIGNEAMORTISSEMENT::execute($requette, [$this->getId()]);
		if (count($item) < 1) {$item = [new LIGNEAMORTISSEMENT()]; }
		return $item[0]->montant;
	}


	public function resteAmortissement(){
		return $this->montant - $this->amortis();
	}





	public static function enAttente(){
		return static::findBy(["etat_id ="=> ETAT::ENCOURS]);
	}



	public static function statistiques(){
		$tableau_mois = ["", "Janvier", "Février", "Mars", "Avril", "Mai", "Juin", "Juillet", "Août", "Septembre", "Octobre", "Novembre", "Décembre"];
		$tableau_mois_abbr = ["", "Jan", "Fév", "Mar", "Avr", "Mai", "Jui", "Juil", "Août", "Sept", "Oct", "Nov", "Déc"];
		$mois1 = date("m", strtotime("-1 year")); $year1 = date("Y", strtotime("-1 year"));
		$mois2 = date("m"); $year2 = date("Y");
		$tableaux = [];
		while ( $year2 >= $year1) {
			$debut = $year1."-".$mois1."-01";
			$fin = $year1."-".$mois1."-".cal_days_in_month(CAL_GREGORIAN, ($mois1), $year1);
			$data = new RESPONSE;
			$data->name = $tableau_mois_abbr[intval($mois1)]." ".$year1;
			//$data->name = $year1."-".start0($mois1)."-".cal_days_in_month(CAL_GREGORIAN, ($mois1), $year1);;
			////////////

			$data->entree = OPERATION::entree($debut, $fin);
			$data->sortie = OPERATION::sortie($debut, $fin);
			$data->resultat = OPERATION::resultat($debut, $fin);

			$tableaux[] = $data;
			///////////////////////
			if ($mois2 == $mois1 && $year2 == $year1) {
				break;
			}else{
				if ($mois1 == 12) {
					$mois1 = 01;
					$year1++;
				}else{
					$mois1++;
				}
			}
		}
		return $tableaux;
	}



	public static function stats(string $date1 = "2020-04-01", string $date2){
		$tableaux = [];
		$nb = ceil(dateDiffe($date1, $date2) / 12);
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

			$data->sortie = OPERATION::sortie($debut, $fin);
			$data->entree = OPERATION::entree($debut, $fin);
			$data->resultat = OPERATION::resultat($debut, $fin);

			$tableaux[] = $data;
			///////////////////////

			$index = $fin;
		}
		return $tableaux;
	}


	public function sentenseCreate(){}
	public function sentenseUpdate(){}
	public function sentenseDelete(){}

}



?>