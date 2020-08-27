<?php
namespace Home;
use Native\RESPONSE;

/**
 * 
 */
class PRODUIT extends TABLE
{
	
	
	public static $tableName = __CLASS__;
	public static $namespace = __NAMESPACE__;


	public $typeproduit_parfum_id;
	public $quantite_id;
	public $initial = 0;
	public $isActive = TABLE::OUI;


	public function enregistre(){
		$data = new RESPONSE;
		$datas = TYPEPRODUIT_PARFUM::findBy(["id ="=>$this->typeproduit_parfum_id]);
		if (count($datas) == 1) {
			$datas = QUANTITE::findBy(["id ="=>$this->quantite_id]);
			if (count($datas) == 1) {
				$data = $this->save();
				if ($data->status) {
					foreach (EMBALLAGE::getAll() as $key => $emballage) {
						$item = new PRICE;
						$item->produit_id = $this->id;
						$item->emballage_id = $emballage->id;
						$item->prix = 0;
						$item->prix_gros = 0;
						$item->enregistre();
					}

					// $item = new ETIQUETTE;
					// $item->produit_id = $this->id;
					// $item->initial = 0;
					// $item->enregistre();
				}
			}else{
				$data->status = false;
				$data->message = "Une erreur s'est produite lors du prix !";
			}
		}else{
			$data->status = false;
			$data->message = "Une erreur s'est produite lors du prix !";
		}
		return $data;
	}



	public function name(){
		return $this->typeproduit_parfum->name()." : ".$this->quantite->name();
	}

	public function name2(){
		return $this->typeproduit_parfum->name()." <br> ".$this->quantite->name();
	}


	public function getListeEmballageProduit(){
		$requette = "SELECT emballage.* FROM caracteristiqueemballage, emballage WHERE caracteristiqueemballage.emballage_id = emballage.id AND typeproduit_id IN ('', ?) AND parfum_id IN ('', ?) AND quantite_id IN ('', ?)";
		return EMBALLAGE::execute($requette, [$this->typeproduit_parfum->typeproduit->id, $this->typeproduit_parfum->parfum->id, $this->quantite->id]);
	}

	///////////////////////////////////////////////////////////////////////////////////////////


	public static function totalVendu($date1, $date2, int $boutique_id=null, int $typeproduit_id=null, int $parfum_id=null, $quantite_id=null){
		$paras = "";
		$paras = "";
		if ($boutique_id != null) {
			$paras.= "AND boutique_id = $boutique_id ";
		}
		if ($typeproduit_id != null) {
			$paras.= "AND typeproduit_parfum.typeproduit_id = $typeproduit_id ";
		}
		if ($parfum_id != null) {
			$paras.= "AND typeproduit_parfum.parfum_id = $parfum_id ";
		}
		if ($quantite_id != null) {
			$paras.= "AND quantite_id = $quantite_id ";
		}
		$paras.= " AND vente.created BETWEEN '$date1' AND '$date2'";
		$requette = "SELECT lignedevente.* FROM lignedevente, vente, produit, typeproduit_parfum WHERE lignedevente.vente_id = vente.id AND lignedevente.produit_id = produit.id AND produit.typeproduit_parfum_id = typeproduit_parfum.id $paras";
		$datas = LIGNEDEVENTE::execute($requette, []);
		return comptage($datas, "price", "somme");
	}



	public static function totalProduit($date1, $date2, int $entrepot_id=null, int $typeproduit_id=null, int $parfum_id=null){
		$paras = "";
		$paras = "";
		if ($entrepot_id != null) {
			$paras.= "AND entrepot_id = $entrepot_id ";
		}
		if ($typeproduit_id != null) {
			$paras.= "AND typeproduit_parfum.typeproduit_id = $typeproduit_id ";
		}
		if ($parfum_id != null) {
			$paras.= "AND typeproduit_parfum.parfum_id = $parfum_id ";
		}
		$paras.= " AND production.created BETWEEN '$date1' AND '$date2'";
		$requette = "SELECT ligneproduction.* FROM ligneproduction, production, typeproduit_parfum WHERE ligneproduction.production_id = production.id AND ligneproduction.typeproduit_parfum_id = typeproduit_parfum.id $paras";
		$datas = LIGNEPRODUCTION::execute($requette, []);
		return comptage($datas, "quantite", "somme");
	}



	public static function totalConditionnement(string $date1, string $date2, int $entrepot_id = null, int $quantite_id = null, int $emballage_id=null){
		$paras = "";
		if ($entrepot_id != null) {
			$paras.= "AND entrepot_id = $entrepot_id ";
		}
		if ($quantite_id != null) {
			$paras.= "AND quantite_id = $quantite_id ";
		}
		if ($emballage_id != null) {
			$paras.= "AND emballage_id = $emballage_id ";
		}
		$requette = "SELECT SUM(ligneconditionnement.quantite) as quantite  FROM conditionnement, ligneconditionnement WHERE ligneconditionnement.produit_id = ? AND ligneconditionnement.conditionnement_id = conditionnement.id AND conditionnement.etat_id != ? AND conditionnement.created >= ? AND conditionnement.created <= ? $paras";
		$item = LIGNECONDITIONNEMENT::execute($requette, [$this->id, $emballage_id, ETAT::ANNULEE, $date1, $date2]);
		if (count($item) < 1) {$item = [new LIGNECONDITIONNEMENT()]; }
		return $item[0]->quantite;
	}


	public function conditionnement(string $date1, string $date2, int $emballage_id, int $entrepot_id = null){
		$paras = "";
		if ($entrepot_id != null) {
			$paras.= "AND entrepot_id = $entrepot_id ";
		}
		$requette = "SELECT SUM(ligneconditionnement.quantite) as quantite  FROM conditionnement, ligneconditionnement WHERE ligneconditionnement.produit_id = ? AND ligneconditionnement.emballage_id = ? AND ligneconditionnement.conditionnement_id = conditionnement.id AND conditionnement.etat_id != ? AND conditionnement.created >= ? AND conditionnement.created <= ? $paras";
		$item = LIGNECONDITIONNEMENT::execute($requette, [$this->id, $emballage_id, ETAT::ANNULEE, $date1, $date2]);
		if (count($item) < 1) {$item = [new LIGNECONDITIONNEMENT()]; }
		return $item[0]->quantite;
	}


	public function totalSortieEntrepot(string $date1, string $date2, int $emballage_id, int $entrepot_id = null){
		$paras = "";
		if ($entrepot_id != null) {
			$paras.= "AND entrepot_id = $entrepot_id ";
		}
		$requette = "SELECT SUM(quantite) as quantite  FROM lignemiseenboutique, miseenboutique WHERE lignemiseenboutique.produit_id = ? AND lignemiseenboutique.emballage_id = ? AND lignemiseenboutique.miseenboutique_id = miseenboutique.id AND miseenboutique.etat_id != ?  AND lignemiseenboutique.created >= ? AND lignemiseenboutique.created <= ? $paras ";
		$item = LIGNEMISEENBOUTIQUE::execute($requette, [$this->id, $emballage_id, ETAT::ANNULEE, $date1, $date2]);
		if (count($item) < 1) {$item = [new LIGNEMISEENBOUTIQUE()]; }
		return $item[0]->quantite;
	}



	public function perteEntrepot(string $date1, string $date2, int $entrepot_id = null){
		$paras = "";
		if ($entrepot_id != null) {
			$paras.= "AND entrepot_id = $entrepot_id ";
		}
		$requette = "SELECT SUM(quantite) as quantite  FROM perteentrepot WHERE perteentrepot.produit_id = ? AND  perteentrepot.etat_id = ? AND DATE(perteentrepot.created) >= ? AND DATE(perteentrepot.created) <= ? $paras ";
		$item = PERTEENTREPOT::execute($requette, [$this->id, ETAT::VALIDEE, $date1, $date2]);
		if (count($item) < 1) {$item = [new PERTEENTREPOT()]; }
		return $item[0]->quantite;
	}


	public function enEntrepot(string $date1, string $date2, int $emballage_id, int $entrepot_id = null){
		$stock = 0;
		if ($entrepot_id == ENTREPOT::PRINCIPAL) {
			$stock = intval($this->initial);
		}
		$total = $this->conditionnement($date1, $date2, $emballage_id, $entrepot_id) - $this->totalSortieEntrepot($date1, $date2, $emballage_id, $entrepot_id) - $this->perteEntrepot($date1, $date2, $emballage_id, $entrepot_id);
		return $total;
	}


	//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////


	public function totalMiseEnBoutique(string $date1, string $date2, int $emballage_id, int $boutique_id = null){
		$paras = "";
		if ($boutique_id != null) {
			$paras.= "AND boutique_id = $boutique_id ";
		}
		$requette = "SELECT SUM(quantite) as quantite  FROM lignemiseenboutique, miseenboutique WHERE lignemiseenboutique.produit_id = ? AND lignemiseenboutique.emballage_id = ? AND lignemiseenboutique.miseenboutique_id = miseenboutique.id AND miseenboutique.etat_id != ?  AND lignemiseenboutique.created >= ? AND lignemiseenboutique.created <= ? $paras ";
		$item = LIGNEMISEENBOUTIQUE::execute($requette, [$this->id, $emballage_id, ETAT::ANNULEE, $date1, $date2]);
		if (count($item) < 1) {$item = [new LIGNEMISEENBOUTIQUE()]; }
		return $item[0]->quantite;
	}


	public function enBoutique(string $date1, string $date2, int $emballage_id, int $boutique_id = null){
		$paras = "";
		if ($boutique_id != null) {
			$paras.= "AND boutique_id = $boutique_id ";
		}
		$total = $this->totalMiseEnBoutique($date1, $date2, $emballage_id, $boutique_id) - ($this->enProspection($emballage_id, $boutique_id) + $this->livree($date1, $date2, $emballage_id, $boutique_id) + $this->vendu($date1, $date2, $emballage_id, $boutique_id) + $this->perteProspection($date1, $date2, $emballage_id, $boutique_id));
		return $total;
	}



	////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////



	public function enProspection(int $emballage_id, int $boutique_id = null){
		$paras = "";
		if ($boutique_id != null) {
			$paras.= "AND boutique_id = $boutique_id ";
		}
		$requette = "SELECT SUM(quantite) as quantite  FROM ligneprospection, prospection WHERE ligneprospection.produit_id = ? AND ligneprospection.emballage_id = ? AND ligneprospection.prospection_id = prospection.id AND prospection.typeprospection_id = ? AND prospection.etat_id IN (?, ?)  $paras";
		$item = LIGNEPROSPECTION::execute($requette, [$this->id, $emballage_id, TYPEPROSPECTION::PROSPECTION, ETAT::ENCOURS, ETAT::PARTIEL]);
		if (count($item) < 1) {$item = [new LIGNEPROSPECTION()]; }
		return $item[0]->quantite;
	}



	public function livree(string $date1, string $date2, int $emballage_id, int $boutique_id = null){
		$paras = "";
		if ($boutique_id != null) {
			$paras.= "AND boutique_id = $boutique_id ";
		}
		$requette = "SELECT SUM(quantite) as quantite  FROM ligneprospection, prospection WHERE ligneprospection.produit_id =  ? AND ligneprospection.emballage_id = ? AND ligneprospection.prospection_id = prospection.id AND prospection.typeprospection_id = ? AND prospection.etat_id != ? AND ligneprospection.created >= ? AND ligneprospection.created <= ? $paras ";
		$item = LIGNEPROSPECTION::execute($requette, [$this->id, $emballage_id, TYPEPROSPECTION::LIVRAISON, ETAT::ANNULEE, $date1, $date2]);
		if (count($item) < 1) {$item = [new LIGNEPROSPECTION()]; }
		return $item[0]->quantite;
	}



	public function perteProspection(string $date1, string $date2, int $emballage_id, int $boutique_id = null){
		$paras = "";
		if ($boutique_id != null) {
			$paras.= "AND boutique_id = $boutique_id ";
		}
		$requette = "SELECT SUM(perte) as perte  FROM ligneprospection, prospection WHERE ligneprospection.produit_id = ? AND ligneprospection.emballage_id = ? AND ligneprospection.prospection_id = prospection.id AND prospection.etat_id != ? AND ligneprospection.created >= ? AND ligneprospection.created <= ? $paras ";
		$item = LIGNEPROSPECTION::execute($requette, [$this->id, $emballage_id, ETAT::ANNULEE, $date1, $date2]);
		if (count($item) < 1) {$item = [new LIGNEPROSPECTION()]; }
		return $item[0]->perte;
	}


	public function vendu(string $date1, string $date2, int $emballage_id, int $boutique_id = null){
		$paras = "";
		if ($boutique_id != null) {
			$paras.= "AND boutique_id = $boutique_id ";
		}
		$requette = "SELECT SUM(quantite) as quantite  FROM lignedevente, vente WHERE lignedevente.produit_id = ? AND lignedevente.emballage_id = ? AND lignedevente.vente_id = vente.id AND vente.etat_id != ? AND lignedevente.created >= ? AND lignedevente.created <= ? $paras ";
		$item = LIGNEDEVENTE::execute($requette, [$this->id, $emballage_id, ETAT::ANNULEE, $date1, $date2]);
		if (count($item) < 1) {$item = [new LIGNEDEVENTE()]; }
		return $item[0]->quantite;
	}


	// public function vendeDirecte(string $date1, string $date2, int $boutique_id = null){
	// 	$paras = "";
	//if ($boutique_id != null) {
	// 		$paras.= "AND boutique_id = $boutique_id ";
	// 	}
	// 	$requette = "SELECT SUM(quantite) as quantite  FROM lignedevente, produit, vente WHERE lignedevente.produit_id = produit.id AND lignedevente.vente_id = vente.id AND produit.id = ? AND  vente.etat_id != ? AND vente.typevente_id = ? AND vente.boutique_id =? AND  DATE(lignedevente.created) >= ? AND DATE(lignedevente.created) <= ? ";
	// 	$item = LIGNEDEVENTE::execute($requette, [$this->id, ETAT::ANNULEE, TYPEVENTE::DIRECT, $boutique_id, $date1, $date2]);
	// 	if (count($item) < 1) {$item = [new LIGNEDEVENTE()]; }
	// 	$total += $item[0]->quantite;
	// 	return $total;
	// }


	// public function vendeProspection(string $date1, string $date2, int $boutique_id = null){
	// 	$total = 0;
	// 	$paras = "";
	//	if ($boutique_id != null) {
	// 		$requette = "SELECT SUM(quantite) as quantite  FROM lignedevente, produit, vente WHERE lignedevente.produit_id = produit.id AND lignedevente.vente_id = vente.id AND produit.id = ? AND  vente.etat_id != ? AND vente.boutique_id =?  AND vente.typevente_id = ? AND DATE(lignedevente.created) >= ? AND DATE(lignedevente.created) <= ? ";

	// 		$item = LIGNEDEVENTE::execute($requette, [$this->id, ETAT::ANNULEE, $boutique_id, TYPEVENTE::PROSPECTION, $date1, $date2]);
	// 		if (count($item) < 1) {$item = [new LIGNEDEVENTE()]; }
	// 		$total += $item[0]->quantite;
	// 	}else{
	// 		$requette = "SELECT SUM(quantite) as quantite  FROM lignedevente, produit, vente WHERE lignedevente.produit_id = produit.id AND lignedevente.vente_id = vente.id AND produit.id = ? AND  vente.etat_id != ? AND vente.typevente_id = ? AND DATE(lignedevente.created) >= ? AND DATE(lignedevente.created) <= ? ";

	// 		$item = LIGNEDEVENTE::execute($requette, [$this->id, ETAT::ANNULEE, TYPEVENTE::PROSPECTION, $date1, $date2]);
	// 		if (count($item) < 1) {$item = [new LIGNEDEVENTE()]; }
	// 		$total += $item[0]->quantite;
	// 	}
	// 	return $total;
	// }



	public function commandee(int $boutique_id = null){
		$total = 0;
		$datas = GROUPECOMMANDE::encours();
		foreach ($datas as $key => $comm) {
			if ($comm->boutique_id == $boutique_id) {
				$total += $comm->reste($this->id);
			}
		}
		return $total;
	}


	///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

	public function stock(string $date){
		$total = 0;
		foreach (BOUTIQUE::getAll() as $key => $value) {
			$total += $this->enBoutique($date, $value->id);
		}
		foreach (ENTREPOT::getAll() as $key => $value) {
			$total += $this->enEntrepot($date, $value->id);
		}
		return $total;
	}


	public function montantStock(int $boutique_id = null){
		$this->actualise();
		if ($boutique_id == null) {
			return $this->enBoutique(dateAjoute()) * $this->prix->price;
		}else{
			return $this->enBoutique(dateAjoute(), $boutique_id) * $this->prix->price;
		}
	}


	public function montantVendu(string $date1, string $date2, int $boutique_id = null){
		$this->actualise();
		if ($boutique_id == null) {
			return ($this->vendu($date1, $date2) + $this->livree($date1, $date2) )* $this->prix->price ;
		}else{
			return ($this->vendu($date1, $date2, $boutique_id) + $this->livree($date1, $date2, $boutique_id) )* $this->prix->price ;
		}
	}



	public static function ruptureBoutique(int $boutique_id = null){
		$params = PARAMS::findLastId();
		$datas = static::findBy(["isActive ="=>TABLE::OUI]);
		foreach ($datas as $key => $item) {
			if ($item->enBoutique(PARAMS::DATE_DEFAULT, dateAjoute(1), $boutique_id) > $params->ruptureStock) {
				unset($datas[$key]);
			}
		}
		return $datas;
	}


	public static function ruptureEntrepot(int $entrepot_id = null){
		$params = PARAMS::findLastId();
		$datas = static::findBy(["isActive ="=>TABLE::OUI]);
		foreach ($datas as $key => $item) {
			if ($item->enEntrepot(PARAMS::DATE_DEFAULT, dateAjoute(1), EMBALLAGE::PRIMAIRE, $entrepot_id) > $params->ruptureStock) {
				unset($datas[$key]);
			}
		}
		return $datas;
	}



	public function exigence(int $quantite, int $ressource_id){
		$datas = EXIGENCEPRODUCTION::findBy(["produit_id ="=>$this->id, "ressource_id ="=>$ressource_id]);
		if (count($datas) == 1) {
			$item = $datas[0];
			if ($item->quantite_produit == 0) {
				return 0;
			}
			return ($quantite * $item->quantite_ressource) / $item->quantite_produit;
		}
		return 0;
	}



	public function coutProduction(String $type, int $quantite){
		if(isJourFerie(dateAjoute())){
			$datas = PAYEFERIE_PRODUIT::findBy(["produit_id ="=>$this->id]);
		}else{
			$datas = PAYE_PRODUIT::findBy(["produit_id ="=>$this->id]);
		}
		if (count($datas) > 0) {
			$ppr = $datas[0];
			switch ($type) {
				case 'production':
				$prix = $ppr->price;
				break;

				case 'rangement':
				$prix = $ppr->price_rangement;
				break;

				case 'vente':
				$prix = $ppr->price_vente;
				break;

				default:
				$prix = $ppr->price;
				break;
			}
			return $quantite * $prix;
		}
		return 0;
	}



	public function changerMode(){
		if ($this->isActive == TABLE::OUI) {
			$this->isActive = TABLE::NON;
		}else{
			$this->isActive = TABLE::OUI;
			$pro = PRODUCTION::today();
			$datas = LIGNEPRODUCTION::findBy(["production_id ="=>$pro->id, "produit_id ="=>$pdv->id]);
			if (count($datas) == 0) {
				$ligne = new LIGNEPRODUCTION();
				$ligne->production_id = $pro->id;
				$ligne->produit_id = $pdv->id;
				$ligne->enregistre();
			}			
		}
		return $this->save();
	}



	public function sentenseCreate(){}
	public function sentenseUpdate(){}
	public function sentenseDelete(){}
}

?>