<?php
namespace Home;
use Native\RESPONSE;
use Native\EMAIL;
/**
 * 
 */
class REGLEMENTCLIENT extends TABLE
{
	public static $tableName = __CLASS__;
	public static $namespace = __NAMESPACE__;

	public $reference;
	public $mouvement_id;
	public $client_id = CLIENT::ANONYME;
	public $commercial_id;
	public $comment;
	public $etat_id = ETAT::VALIDEE;
	public $modepayement_id;
	public $structure;
	public $numero;
	public $boutique_id;
	public $date_approbation;
	public $isModified = 0;
	public $employe_id;
	public $commande_id ;

	public $acompteClient = 0;
	public $detteClient = 0;

	public $image;
	public $montant;
	public $recouvrement;


	public function enregistre(){
		$data = new RESPONSE;
		if (isset($this->recouvrement) && $this->recouvrement == TABLE::OUI) {
			$data = $this->recouvrement();
		}else{
			$this->employe_id = getSession("employe_connecte_id");
			$this->boutique_id = getSession("boutique_connecte_id");

			$datas = EMPLOYE::findBy(["id ="=>$this->employe_id]);
			if (count($datas) == 1) {
				$this->reference = "RGC/".date('dmY')."-".strtoupper(substr(uniqid(), 5, 6));
				if (!in_array($this->modepayement_id, [MODEPAYEMENT::ESPECE, MODEPAYEMENT::PRELEVEMENT_ACOMPTE])) {
					$this->etat_id = ETAT::ENCOURS;
				}else{
					$this->etat_id = ETAT::VALIDEE;
				}
				if ($this->modepayement_id != MODEPAYEMENT::PRELEVEMENT_ACOMPTE) {
					if (intval($this->montant) > 0) {
						$datas = BOUTIQUE::findBy(["id ="=>getSession("boutique_connecte_id")]);
						if (count($datas) == 1) {
							$boutique = $datas[0];
							$boutique->actualise();

							$mouvement = new MOUVEMENT();
							$mouvement->name = "reglement de client";
							$mouvement->montant = $this->montant;
							$mouvement->comment = $this->comment;
							$mouvement->modepayement_id = $this->modepayement_id;
							$mouvement->typemouvement_id = TYPEMOUVEMENT::DEPOT;
							$mouvement->comptebanque_id  = $boutique->comptebanque_id;
							$data = $mouvement->enregistre();
							if ($data->status) {
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
							$data->message = "Une erreur s'est produite lors de l'opération, veuillez recommencer !!";
						}
					}else{
						$data->status = false;
						$data->message = "Le montant pour cette opération est incorrecte, verifiez-le !";
					}
				}else{
					$data->status = false;
					$data->message = "Vous ne pouvez pas utiliser ce mode de payement, verifiez-le !";
				}
			}else{
				$data->status = false;
				$data->message = "++Une erreur s'est produite lors de l'opération, veuillez recommencer !!";
			}
		}
		return $data;
	}




	public function recouvrement(){
		$data = new RESPONSE;
		$datas = COMMANDE::findBy(["id = "=>$this->commande_id]);
		if (count($datas) > 0) {
			$commande = $datas[0];
			if ($commande->reste() >= $this->montant) {

				$this->employe_id = getSession("employe_connecte_id");
				$this->boutique_id = getSession("boutique_connecte_id");
				$this->reference = "RGC/".date('dmY')."-".strtoupper(substr(uniqid(), 5, 6));

				if (!in_array($this->modepayement_id, [MODEPAYEMENT::ESPECE, MODEPAYEMENT::PRELEVEMENT_ACOMPTE])) {
					$this->etat_id = ETAT::ENCOURS;
				}

				if ($this->modepayement_id != MODEPAYEMENT::PRELEVEMENT_ACOMPTE) {
					if (intval($this->montant) > 0) {
						$datas = BOUTIQUE::findBy(["id ="=>getSession("boutique_connecte_id")]);
						if (count($datas) == 1) {
							$boutique = $datas[0];
							$boutique->actualise();

							$mouvement = new MOUVEMENT();
							$mouvement->name = "reglement de client";
							$mouvement->montant = $this->montant;
							$mouvement->comment = $this->comment;
							$mouvement->modepayement_id = $this->modepayement_id;
							$mouvement->typemouvement_id = TYPEMOUVEMENT::DEPOT;
							$mouvement->comptebanque_id  = $boutique->comptebanque_id;
							$data = $mouvement->enregistre();
							if ($data->status) {
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
							$data->message = "Une erreur s'est produite lors de l'opération, veuillez recommencer !!";
						}
					}else{
						$data->status = false;
						$data->message = "Le montant pour cette opération est incorrecte, verifiez-le !";
					}
				}else{
					$datas = CLIENT::findBy(["id = "=>$this->client_id]);
					if (count($datas) > 0) {
						$client = $datas[0];
						$data = $client->debiter($this->montant);
						if ($data->status) {
							$data = $this->save();
						}
					}else{
						$data->status = false;
						$data->message = "Une erreur s'est produite lors de l'opération, veuillez recommencer !!";
					}
				}
			}else{
				$data->status = false;
				$data->message = "Le montant saisi est supérieur au reste à recouvrir !";
			}
		}else{
			$data->status = false;
			$data->message = "Une erreur s'est produite lors de l'opération, veuillez recommencer !!";
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



	public static function total(string $date1 = "2020-04-01", string $date2, int $boutique_id = null){
		$paras = "";
		if ($boutique_id != null) {
			$paras.= "AND boutique_id = $boutique_id ";
		}
		$requette = "SELECT SUM(reglementclient.montant) as montant  FROM reglementclient, mouvement WHERE reglementclient.mouvement_id = mouvement.id AND mouvement.typemouvement_id = ? AND reglementclient.valide = 1 AND DATE(reglementclient.created) >= ? AND DATE(reglementclient.created) <= ? $paras";
		$item = MOUVEMENT::execute($requette, [TYPEMOUVEMENT::DEPOT, $date1, $date2]);
		if (count($item) < 1) {$item = [new MOUVEMENT()]; }
		return $item[0]->montant;
	}




	public static function versements(string $date1 = "2020-04-01", string $date2, int $boutique_id = null){
		$paras = "";
		if ($boutique_id != null) {
			$paras.= "AND boutique_id = $boutique_id ";
		}
		$requette = "SELECT SUM(montant) as montant  FROM operation WHERE operation.categorieoperation_id = ? AND operation.valide = 1 AND operation.client_id = ? AND DATE(operation.created) >= ? AND DATE(operation.created) <= ? AND operation.valide = 1 $paras";
		$item = OPERATION::execute($requette, [CATEGORIEOPERATION::VENTE, CLIENT::ANONYME, $date1, $date2]);
		if (count($item) < 1) {$item = [new OPERATION()]; }
		return $item[0]->montant;
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


	public function sentenseCreate(){
		$this->sentense = "Nouveau reglement de client N°$this->reference pour ".$this->client->name()." d'un montant de $this->montant";
	}
	public function sentenseUpdate(){
		$this->sentense = "Modification des informations du reglement de client N°$this->reference ";
	}
	public function sentenseDelete(){
		$this->sentense = "Nouveau reglement de client N°$this->reference pour ".$this->client->name()." d'un montant de $this->montant";
	}

}



?>