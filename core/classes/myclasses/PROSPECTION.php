<?php
namespace Home;
use Native\RESPONSE;/**
 * 
 */
class PROSPECTION extends TABLE
{

	public static $tableName = __CLASS__;
	public static $namespace = __NAMESPACE__;

	public $reference;
	public $groupecommande_id  = null;
	public $typeprospection_id = TYPEPROSPECTION::PROSPECTION;
	public $zonedevente_id;
	public $lieu;
	public $boutique_id        = BOUTIQUE::PRINCIPAL;
	public $commercial_id      = COMMERCIAL::MAGASIN;
	public $etat_id            = ETAT::ENCOURS;
	public $employe_id         = null;
	
	public $vente_id           = null;
	
	public $montant            = 0;
	public $vendu              = 0;
	public $monnaie            = 0;
	public $transport          = 0;
	public $comment;

	public $nom_receptionniste;
	public $contact_receptionniste;

	

	public function enregistre(){
		$data = new RESPONSE;
		$datas = ZONEDEVENTE::findBy(["id ="=>$this->zonedevente_id]);
		if (count($datas) == 1) {
			$datas = COMMERCIAL::findBy(["id ="=>$this->commercial_id]);
			if (count($datas) == 1) {
				$commercial = $datas[0];
				$this->employe_id = getSession("employe_connecte_id");
				$this->boutique_id = getSession("boutique_connecte_id");
				$this->reference = "BSO/".date('dmY')."-".strtoupper(substr(uniqid(), 5, 6));
				$data = $this->save();
				if ($data->status) {
					if ($this->commercial_id != COMMERCIAL::MAGASIN) {
						$commercial->disponibilite_id = DISPONIBILITE::MISSION;
						$commercial->save();
					}

					if ($this->transport > 0) {
						$this->actualise();
						$mouvement = new OPERATION();
						$mouvement->montant = $this->transport;
						$mouvement->categorieoperation_id = CATEGORIEOPERATION::FRAISTRANSPORT;
						$mouvement->modepayement_id = MODEPAYEMENT::ESPECE;
						$mouvement->comment = "Transport du commercial ".$this->commercial->name()." pour la prospection N° ".$this->reference;
						$data = $mouvement->enregistre();
					}
				}
			}else{
				$data->status = false;
				$data->message = "veuillez selectionner un commercial pour la vente!";
			}
		}else{
			$data->status = false;
			$data->message = "Une erreur s'est produite lors de l'enregistrement de la vente!";
		}
		return $data;
	}



	public static function perte(string $date1, string $date2){
		$total = 0;
		$datas = static::findBy(["etat_id ="=>ETAT::VALIDEE, "DATE(dateretour) >= " => $date1, "DATE(dateretour) <= " => $date2]);
		foreach ($datas as $key => $prospection) {
			$lots = $prospection->fourni("ligneprospection");
			$total += comptage($lots, "perte", "somme");
		}
		return $total;
	}



	//les livraions programmées du jour
	public static function programmee(String $date){
		$array = static::findBy(["DATE(dateretour) ="=>$date]);
		$array1 = static::findBy(["etat_id ="=>ETAT::ENCOURS]);
		return array_merge($array1, $array);
	}


	//les livraions effectuéez du jour
	public static function effectuee(String $date, int $boutique_id = null){
		if ($boutique_id == null) {
			return static::findBy(["DATE(dateretour) ="=>$date, "etat_id ="=>ETAT::VALIDEE]);
			# code...
		}else{
			return static::findBy(["DATE(dateretour) ="=>$date, "etat_id ="=>ETAT::VALIDEE, "boutique_id ="=>$boutique_id]);

		}
	}


	// Supprimer toutes les ventes programmée qui n'ont pu etre effectuée...
	public static function ResetProgramme(){
		$datas = VENTE::findBy(["etat_id ="=>ETAT::PARTIEL, "DATE(dateretour) <"=>dateAjoute()]);
		foreach ($datas as $key => $vente) {
			$vente->fourni("lignedevente");
			foreach ($vente->lignedeventes as $key => $value) {
				$value->delete();
			}
			$vente->delete();
		}
		
		// $requette = "DELETE FROM vente WHERE etat_id = ? AND DATE(dateretour) < ? ";
		// static::query($requette, [ETAT::PARTIEL, dateAjoute()]);
	}


	// public function chauffeur(){
	// 	if ($this->vehicule_id == VEHICULE::AUTO) {
	// 		return "...";
	// 	}else if ($this->vehicule_id == VEHICULE::TRICYCLE) {
	// 		return $this->nom_tricycle;
	// 	}else{
	// 		return $this->chauffeur->name();
	// 	}
	// }


	// public function vehicule(){
	// 	if ($this->vehicule_id == VEHICULE::AUTO) {
	// 		return "SON PROPRE VEHICULE";
	// 	}else if ($this->vehicule_id == VEHICULE::TRICYCLE) {
	// 		return "TRICYCLE";
	// 	}else{
	// 		return $this->vehicule->name();
	// 	}
	// }



	public function annuler(){
		$data = new RESPONSE;
		if ($this->etat_id != ETAT::ANNULEE) {

			if ($this->etat_id == ETAT::VALIDEE) {
				$this->actualise();
				$data = $this->vente->annuler();
			}
			
			$this->etat_id = ETAT::ANNULEE;
			$this->historique("La prospection en reference $this->reference vient d'être annulée !");
			$data = $this->save();
			if ($data->status) {
				$this->actualise();
				if ($this->typeprospection_id == TYPEPROSPECTION::LIVRAISON) {
					$this->groupecommande->etat_id = ETAT::ENCOURS;
					$this->groupecommande->save();

					if ($this->chauffeur_id > 0) {
						$this->chauffeur->etatchauffeur_id = ETATCHAUFFEUR::RAS;
						$this->chauffeur->save();
					}

					$this->vehicule->etat_id = ETATVEHICULE::RAS;
					$this->vehicule->save();
				}
				
			}
		}else{
			$data->status = false;
			$data->message = "Vous ne pouvez plus faire cette opération sur cette prospection !";
		}
		return $data;
	}



	public function terminer(Array $post){
		$data = new RESPONSE;
		if ($this->etat_id == ETAT::ENCOURS) {
			$this->etat_id = ETAT::VALIDEE;
			$this->dateretour = date("Y-m-d H:i:s");
			$this->historique("La prospection en reference $this->reference vient d'être terminé !");
			$data = $this->save();
			if ($data->status) {
				if ($this->typeprospection_id == TYPEPROSPECTION::PROSPECTION) {
					$vente = new VENTE();
					$vente->cloner($this);
					$vente->created = null;
					$vente->modified = null;
					$vente->typevente_id = TYPEVENTE::PROSPECTION;
					if ($this->typeprospection_id == TYPEPROSPECTION::VENTECAVE) {
						$vente->typevente_id = TYPEVENTE::VENTECAVE;
					}
					$vente->setId(null);
					$data = $vente->enregistre();
					if ($data->status) {
						$vente->actualise();
						$montant = 0;
						$datas = $this->fourni("ligneprospection");
						foreach ($datas as $key => $ligne) {
							$ligne->actualise();
							$lgn = new LIGNEDEVENTE();
							$lgn->vente_id = $vente->id;
							$lgn->prixdevente_id = $ligne->prixdevente_id;
							$lgn->quantite = $ligne->quantite_vendu;
							$lgn->save();
							$montant += $ligne->prixdevente->prix->price * $ligne->quantite_vendu;
						}

						$params = PARAMS::findLastId();
						$tva = ($montant * $params->tva) / 100;
						$total = $montant + $tva;

						$reglement = new REGLEMENTCLIENT();
						$reglement->hydrater($post);
						$reglement->montant = $total;
						$reglement->comment = "Réglement de la vente ".$vente->typevente->name()." N°".$vente->reference;
						$reglement->files = [];
						$reglement->setId(null);
						$data = $reglement->enregistre();
						if ($data->status) {
							$vente->reglementclient_id = $data->lastid;
							$data = $vente->save();
						}

						$this->vente_id = $vente->id;
					}
				}
				
				if ($this->commercial_id != null) {
					$this->commercial->disponibilite_id = DISPONIBILITE::LIBRE;
				}
				$this->commercial->save();
			}
		}else{
			$data->status = false;
			$data->message = "Vous ne pouvez plus faire cette opération sur cette prospection !";
		}
		return $data;
	}



	public function terminerLivraison(){
		$data = new RESPONSE;
		if ($this->etat_id == ETAT::ENCOURS) {
			$this->etat_id = ETAT::VALIDEE;
			$this->dateretour = date("Y-m-d H:i:s");
			$this->historique("La livraion en reference $this->reference vient d'être terminé !");
			$data = $this->save();
			if ($data->status) {			
				if ($this->commercial_id != null) {
					$this->commercial->disponibilite_id = DISPONIBILITE::LIBRE;
				}
				$this->commercial->save();
			}
		}else{
			$data->status = false;
			$data->message = "Vous ne pouvez plus faire cette opération sur cette prospection !";
		}
		return $data;
	}




	public function montant(){
		$total = 0;
		$datas = $this->fourni("lignedevente");
		foreach ($datas as $key => $ligne) {
			$ligne->actualise();
			$total += $ligne->prixdevente->prix->price * $ligne->quantite;
		}
		return $total;
	}



	public function payer(int $montant, Array $post){
		$data = new RESPONSE;
		$solde = $this->reste;
		if ($solde > 0) {
			if ($solde >= $montant) {
				$payement = new OPERATION();
				$payement->hydrater($post);
				if ($payement->modepayement_id != MODEPAYEMENT::PRELEVEMENT_ACOMPTE) {
					$payement->categorieoperation_id = CATEGORIEOPERATION::PAYE_TRICYLE;
					$payement->manoeuvre_id = $this->id;
					$payement->comment = "Réglement de la paye de tricycle ".$this->chauffeur()." pour la commande N°".$this->reference;
					$data = $payement->enregistre();
					if ($data->status) {
						$this->reste -= $montant;
						$this->isPayer = 1;
						$data = $this->save();
					}
				}else{
					$data->status = false;
					$data->message = "Vous ne pouvez pas utiliser ce mode de payement pour effectuer cette opération !";
				}
			}else{
				$data->status = false;
				$data->message = "Le montant à verser est plus élévé que sa paye !";
			}
		}else{
			$data->status = false;
			$data->message = "Vous etes déjà à jour pour la paye de ce tricycle !";
		}
		return $data;
	}


	public function sentenseCreate(){}
	public function sentenseUpdate(){}
	public function sentenseDelete(){}


}
?>