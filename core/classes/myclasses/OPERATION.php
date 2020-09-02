<?php
namespace Home;
use Native\RESPONSE;
use Native\EMAIL;
/**
 * 
 */
class OPERATION extends TABLE
{
	public static $tableName = __CLASS__;
	public static $namespace = __NAMESPACE__;

	public $reference;
	public $montant;
	public $categorieoperation_id;
	public $mouvement_id;
	public $modepayement_id;
	public $employe_id;
	public $boutique_id ;
	public $entrepot_id ;
	public $etat_id = ETAT::VALIDEE;
	public $comment;
	public $date_approbation;
	public $image;


	public function enregistre(){
		$data = new RESPONSE;
		$this->employe_id = getSession("employe_connecte_id");
		$this->boutique_id = getSession("boutique_connecte_id");
		$this->entrepot_id = getSession("entrepot_connecte_id");
		
		$datas = EMPLOYE::findBy(["id ="=>$this->employe_id]);
		if (count($datas) == 1) {
			$datas = CATEGORIEOPERATION::findBy(["id ="=>$this->categorieoperation_id]);
			if (count($datas) == 1) {
				$cat = $datas[0];
				if ( $cat->typeoperationcaisse_id == TYPEOPERATIONCAISSE::ENTREE || ($cat->typeoperationcaisse_id == TYPEOPERATIONCAISSE::SORTIE && $this->modepayement_id != MODEPAYEMENT::PRELEVEMENT_ACOMPTE)) {

					if (($cat->typeoperationcaisse_id == TYPEOPERATIONCAISSE::ENTREE) && !in_array($this->modepayement_id, [MODEPAYEMENT::ESPECE, MODEPAYEMENT::PRELEVEMENT_ACOMPTE]) ) {
						$this->etat_id = ETAT::ENCOURS;
					}else{
						$this->etat_id = ETAT::VALIDEE;
					}
					
					if (intval($this->montant) > 0) {
						$mouvement = new MOUVEMENT();
						$mouvement->montant = $this->montant;
						$mouvement->comment = $this->comment;
						$mouvement->modepayement_id = $this->modepayement_id;
						$mouvement->name = $cat->name();
						$mouvement->typemouvement_id = TYPEMOUVEMENT::DEPOT;
						if ($cat->typeoperationcaisse_id == TYPEOPERATIONCAISSE::SORTIE) {
							$mouvement->typemouvement_id = TYPEMOUVEMENT::RETRAIT;
						}
						$mouvement->comptebanque_id = COMPTEBANQUE::COURANT;
						$data = $mouvement->enregistre();
						if ($data->status) {
							$this->reference = "BCA/".date('dmY')."-".strtoupper(substr(uniqid(), 5, 6));
							$this->mouvement_id = $mouvement->id;
							$data = $this->save();
							if ($data->status) {
								if (!(isset($this->files) && is_array($this->files))) {
									$this->files = [];
								}
								$this->uploading($this->files);
							}
						}
					}else{
						$data->status = false;
						$data->message = "Le montant pour cette opération est incorrecte, verifiez-le !";
					}
				}else{
					$data->status = false;
					$data->message = "Vous ne pouvez pas utiliser ce mode de payement pour effectuer cette opération !!";
				}				
			}else{
				$data->status = false;
				$data->message = "Une erreur s'est produite lors de l'opération, veuillez recommencer 1 !!";
			}
		}else{
			$data->status = false;
			$data->message = "Une erreur s'est produite lors de l'opération, veuillez recommencer 2 !!";
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
						$result = $image->upload("images", "operations", $a);
						$name = $tab[$i];
						$this->$name = $result->filename;
						$this->save();
					}
				}	
				$i++;			
			}			
		}
	}


	public function valider(){
		$data = new RESPONSE;
		$this->etat_id = ETAT::VALIDEE;
		$this->date_approbation = date("Y-m-d H:i:s");
		$this->historique("Approbation de l'opération de caisse N° $this->reference");
		return $this->save();
	}


	public function annuler(){
		return $this->supprime();
	}



	public static function entree(string $date1 = "2020-04-01", string $date2, int $boutique_id = null){
		if ($boutique_id == null) {
			$requette = "SELECT SUM(montant) as montant  FROM operation, categorieoperation WHERE operation.categorieoperation_id = categorieoperation.id AND categorieoperation.typeoperationcaisse_id = ? AND operation.valide = 1 AND DATE(operation.created) >= ? AND DATE(operation.created) <= ?";
			$item = OPERATION::execute($requette, [TYPEOPERATIONCAISSE::ENTREE, $date1, $date2]);
			if (count($item) < 1) {$item = [new OPERATION()]; }
			return $item[0]->montant;
		}else{
			$requette = "SELECT SUM(montant) as montant  FROM operation, categorieoperation WHERE operation.categorieoperation_id = categorieoperation.id AND categorieoperation.typeoperationcaisse_id = ? AND operation.valide = 1 AND DATE(operation.created) >= ? AND DATE(operation.created) <= ? AND operation.boutique_id = ?";
			$item = OPERATION::execute($requette, [TYPEOPERATIONCAISSE::ENTREE, $date1, $date2, $boutique_id]);
			if (count($item) < 1) {$item = [new OPERATION()]; }
			return $item[0]->montant;
		}
	}



	public static function sortie(string $date1 = "2020-04-01", string $date2, int $boutique_id = null){
		if ($boutique_id == null) {
			$requette = "SELECT SUM(montant) as montant  FROM operation, categorieoperation WHERE operation.categorieoperation_id = categorieoperation.id AND categorieoperation.typeoperationcaisse_id = ? AND operation.valide = 1 AND DATE(operation.created) >= ? AND DATE(operation.created) <= ?";
			$item = OPERATION::execute($requette, [TYPEOPERATIONCAISSE::SORTIE, $date1, $date2]);
			if (count($item) < 1) {$item = [new OPERATION()]; }
			return $item[0]->montant;
		}else{
			$requette = "SELECT SUM(montant) as montant  FROM operation, categorieoperation WHERE operation.categorieoperation_id = categorieoperation.id AND categorieoperation.typeoperationcaisse_id = ? AND operation.valide = 1 AND DATE(operation.created) >= ? AND DATE(operation.created) <= ? AND operation.boutique_id = ? ";
			$item = OPERATION::execute($requette, [TYPEOPERATIONCAISSE::SORTIE, $date1, $date2, $boutique_id]);
			if (count($item) < 1) {$item = [new OPERATION()]; }
			return $item[0]->montant;
		}
	}


	public static function resultat(string $date1 = "2020-04-01", string $date2, int $boutique_id = null){
		if ($boutique_id == null) {
			return static::entree($date1, $date2) - static::sortie($date1, $date2);
		}else{
			return static::entree($date1, $date2, $boutique_id) - static::sortie($date1, $date2, $boutique_id);
		}
	}





	public static function enAttente(int $boutique_id = null){
		if ($boutique_id == null) {
			return static::findBy(["etat_id ="=> ETAT::ENCOURS]);
		}else{
			return static::findBy(["etat_id ="=> ETAT::ENCOURS, "boutique_id ="=>$boutique_id]);

		}
	}



	public static function statistiques(int $boutique_id = null){
		$tableau_mois = ["", "Janvier", "Février", "Mars", "Avril", "Mai", "Juin", "Juillet", "Août", "Septembre", "Octobre", "Novembre", "Décembre"];
		$tableau_mois_abbr = ["", "Jan", "Fév", "Mar", "Avr", "Mai", "Jui", "Juil", "Août", "Sept", "Oct", "Nov", "Déc"];
		$mois1 = date("m", strtotime("-1 year")); $year1 = date("Y", strtotime("-1 year"));
		$mois2 = date("m"); $year2 = date("Y");
		$tableaux = [];

		if ($boutique_id == null) {
			while ( $year2 >= $year1) {
				$debut = $year1."-".$mois1."-01";
				$fin = $year1."-".$mois1."-".cal_days_in_month(CAL_GREGORIAN, ($mois1), $year1);
				$data = new RESPONSE;
				$data->name = $tableau_mois_abbr[intval($mois1)]." ".$year1;
			//$data->name = $year1."-".start0($mois1)."-".cal_days_in_month(CAL_GREGORIAN, ($mois1), $year1);;
			////////////

				$data->entree = OPERATION::entree($debut, $fin);
				$data->sortie = OPERATION::sortie($debut, $fin);
				$data->resultat = $data->entree - $data->sortie;

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
		}else{
			while ( $year2 >= $year1) {
				$debut = $year1."-".$mois1."-01";
				$fin = $year1."-".$mois1."-".cal_days_in_month(CAL_GREGORIAN, ($mois1), $year1);
				$data = new RESPONSE;
				$data->name = $tableau_mois_abbr[intval($mois1)]." ".$year1;
			//$data->name = $year1."-".start0($mois1)."-".cal_days_in_month(CAL_GREGORIAN, ($mois1), $year1);;
			////////////

				$data->entree = OPERATION::entree($debut, $fin, $boutique_id);
				$data->sortie = OPERATION::sortie($debut, $fin, $boutique_id);
				$data->resultat = $data->entree - $data->sortie;

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
		}
		return $tableaux;
	}



	public static function stats(string $date1 = "2020-04-01", string $date2){
		$tableaux = [];
		$nb = ceil(dateDiffe($date1, $date2) / 12);
		$index = $date1;
		while ( $index <= $date2 ) {
			$debut = $index;
			$fin = dateAjoute1($index, ceil($nb/2));

			$data = new \stdclass;
			$data->year = date("Y", strtotime($index));
			$data->month = date("m", strtotime($index));
			$data->day = date("d", strtotime($index));
			$data->nb = $nb;
			////////////

			$data->ca = OPERATION::entree($debut, $fin);
			$data->sortie = OPERATION::sortie($debut, $fin);
			$data->marge = 0 ;
			if ($data->ca != 0) {
				$data->marge = (OPERATION::resultat($debut, $fin) / $data->ca) *100;
			}

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