<?php
namespace Home;
use Native\RESPONSE;
use Native\EMAIL;
/**
 * 
 */
class CAPITAUX extends TABLE
{
	public static $tableName = __CLASS__;
	public static $namespace = __NAMESPACE__;

	public $name;
	public $montant;
	public $comment;

	public $comptebanque_id;

	public function enregistre(){
		$data = new RESPONSE;
		if ($this->name != "") {
			if ($this->montant > 0) {
				$datas = COMPTEBANQUE::findBy(["id ="=>$this->comptebanque_id]);
				if (count($datas) == 1) {
					$data = $this->save();
					if ($data->status) {
						$mouvement = new MOUVEMENT();
						$mouvement->comptebanque_id = $this->comptebanque_id;
						$mouvement->montant = $this->montant;
						$mouvement->comment = "Nouveau capital : ".$this->name;
						$mouvement->typemouvement_id = TYPEMOUVEMENT::DEPOT;
						$data = $mouvement->enregistre();
					}
				}else{
					$data->status = false;
					$data->message = "Une erreur est survenue lors de l'opération, veuillez reessayer !";
				}
			}else{
				$data->status = false;
				$data->message = "Veuillez à bien renseigner le montant du nouveau capital!";
			}
		}else{
			$data->status = false;
			$data->message = "Veuillez renseigner le libéllé du nouveau capital !";
		}
		return $data;
	}


	public static function total(){
		return comptage(static::getAll(), "montant", "somme");
	}


	public function annuler(){
		return $this->supprime();
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