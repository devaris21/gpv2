<?php
namespace Home;
use Native\RESPONSE;
use Native\EMAIL;
/**
 * 
 */
class MOUVEMENT extends TABLE
{
	public static $tableName = __CLASS__;
	public static $namespace = __NAMESPACE__;

	public $name;
	public $reference;
	public $montant;
	public $typemouvement_id;
	public $comptebanque_id;
	public $etat_id = ETAT::VALIDEE;
	public $comment;
	public $modepayement_id ;
	public $structure;
	public $numero;
	public $employe_id;



	public function enregistre(){
		$data = new RESPONSE;
		$this->employe_id = getSession("employe_connecte_id");
		$datas = EMPLOYE::findBy(["id ="=>$this->employe_id]);
		if (count($datas) == 1) {
			$datas = TYPEMOUVEMENT::findBy(["id ="=>$this->typemouvement_id]);
			if (count($datas) == 1) {
				$type = $datas[0];

				$datas = ENTREPOT::findBy(["id ="=>getSession("entrepot_connecte_id")]);
				if (count($datas) > 0) {
					$item = $datas[0];
					$item->actualise();
					$banque = $item->comptebanque;
				}else{
					$datas = BOUTIQUE::findBy(["id ="=>getSession("boutique_connecte_id")]);
					if (count($datas) > 0) {
						$item = $datas[0];
						$item->actualise();
						$banque = $item->comptebanque;
					}
				}

				$datas = COMPTEBANQUE::findBy(["id ="=>$this->comptebanque_id]);
				if (count($datas) == 1) {
					$banque = $datas[0];
					if (intval($this->montant) > 0) {
						$this->reference = "MVT/".date('dmY')."-".strtoupper(substr(uniqid(), 5, 6));
						if ($this->typemouvement_id == TYPEMOUVEMENT::DEPOT || ($this->typemouvement_id == TYPEMOUVEMENT::RETRAIT && $this->montant <= $banque->solde())) {
							$data = $this->save();
						}else{
							$data->status = false;
							$data->message = "Le montant que vous essayez de retirer est plus élévé que le solde du compte !".$banque->solde();
						}
					}else{
						$data->status = false;
						$data->message = "Le montant pour cette opération est incorrecte, verifiez-le !";
					}
				}else{
					$data->status = false;
					$data->message = "Une erreur s'est produite lors de l'opération, veuillez recommencer 5!!";
				}
			}else{
				$data->status = false;
				$data->message = "Une erreur s'est produite lors de l'opération, veuillez recommencer 7!!";
			}
		}else{
			$data->status = false;
			$data->message = "Une erreur s'est produite lors de l'opération, veuillez recommencer 7!!";
		}
		return $data;
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
			$fin = dateAjoute1($index, $nb);

			$data = new \stdclass;
			$data->year = date("Y", strtotime($index));
			$data->month = date("m", strtotime($index));
			$data->day = date("d", strtotime($index));
			$data->nb = $nb;
			////////////

			$data->sortie = static::sortie($debut, $fin);
			$data->entree = static::entree($debut, $fin);
			$data->resultat = static::resultat($debut, $fin);

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