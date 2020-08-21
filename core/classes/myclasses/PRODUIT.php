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
	public $prix;
	public $prix_gros;
	public $initial = 0;
	public $isActive = TABLE::NON;


	public function enregistre(){
		$data = new RESPONSE;
			$datas = TYPEPRODUIT_PARFUM::findBy(["id ="=>$this->typeproduit_parfum_id]);
			if (count($datas) == 1) {
				$datas = QUANTITE::findBy(["id ="=>$this->quantite_id]);
				if (count($datas) == 1) {
					$data = $this->save();
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
		return $this->typeproduit->name()." de ".$this->parfum->name()." ".$this->quantite->name();
	}


	public static function totalVendu($date1, $date2, int $boutique_id=null, int $parfum_id=null, int $typeproduit_id=null, $quantite_id=null){
		$paras = "";
		$paras = "";
		if ($boutique_id != null) {
			$paras.= "AND boutique_id = $boutique_id ";
		}
		if ($parfum_id != null) {
			$paras.= "AND parfum_id = $parfum_id ";
		}
		if ($typeproduit_id != null) {
			$paras.= "AND typeproduit_id = $typeproduit_id ";
		}
		if ($quantite_id != null) {
			$paras.= "AND quantite_id = $quantite_id ";
		}
		$paras.= " AND vente.created BETWEEN '$date1' AND '$date2'";
		$requette = "SELECT lignedevente.* FROM lignedevente, vente, produit WHERE lignedevente.vente_id = vente.id AND lignedevente.produit_id = produit.id $paras";
		$datas = LIGNEDEVENTE::execute($requette, []);
		return comptage($datas, "price", "somme");
	}





	public function conditionnement(string $date1, string $date2, int $format_id, int $entrepot_id = null){
		$paras = "";
		if ($entrepot_id != null) {
			$paras.= "AND entrepot_id = $entrepot_id ";
		}
		$requette = "SELECT SUM(ligneconditionnement.quantite) as quantite  FROM conditionnement, ligneconditionnement WHERE ligneconditionnement.produit_id = ? AND ligneconditionnement.formatemballage_id = ? AND ligneconditionnement.conditionnement_id = conditionnement.id AND conditionnement.etat_id != ? AND conditionnement.created >= ? AND conditionnement.created <= ? $paras";
		$item = LIGNECONDITIONNEMENT::execute($requette, [$this->id, $format_id, ETAT::ANNULEE, $date1, $date2]);
		if (count($item) < 1) {$item = [new LIGNECONDITIONNEMENT()]; }
		return $item[0]->quantite;
	}


	public function totalSortieEntrepot(string $date1, string $date2, int $format_id, int $entrepot_id = null){
		$paras = "";
		if ($entrepot_id != null) {
			$paras.= "AND entrepot_id = $entrepot_id ";
		}
		$requette = "SELECT SUM(quantite) as quantite  FROM lignemiseenboutique, miseenboutique WHERE lignemiseenboutique.produit_id = ? AND lignemiseenboutique.formatemballage_id = ? AND lignemiseenboutique.miseenboutique_id = miseenboutique.id AND miseenboutique.etat_id != ?  AND lignemiseenboutique.created >= ? AND lignemiseenboutique.created <= ? $paras ";
		$item = LIGNEMISEENBOUTIQUE::execute($requette, [$this->id, $format_id, ETAT::ANNULEE, $date1, $date2]);
		if (count($item) < 1) {$item = [new LIGNEMISEENBOUTIQUE()]; }
		return $item[0]->quantite;
	}


	public function perteEntrepot(string $date1, string $date2, int $format_id, int $entrepot_id = null){
		$paras = "";
		if ($entrepot_id != null) {
			$paras.= "AND entrepot_id = $entrepot_id ";
		}
		$requette = "SELECT SUM(perte) as perte  FROM ligneperteentrepot, perteentrepot WHERE ligneperteentrepot.produit_id = ? AND ligneperteentrepot.formatemballage_id = ? AND ligneperteentrepot.perteentrepot_id = perteentrepot.id AND perteentrepot.etat_id != ? AND ligneperteentrepot.created >= ? AND ligneperteentrepot.created <= ? $paras";
		$item = LIGNEPERTEENTREPOT::execute($requette, [$this->id, $format_id, ETAT::ANNULEE, $date1, $date2]);
		if (count($item) < 1) {$item = [new LIGNEPERTEENTREPOT()]; }
		return $item[0]->perte;
	}


	public function enEntrepot(string $date1, string $date2, int $format_id, int $entrepot_id = null){
		$stock = 0;
		if ($entrepot_id == ENTREPOT::PRINCIPAL) {
			$stock = intval($this->initial);
		}
		$total = $this->conditionnement($date1, $date2, $format_id, $entrepot_id) - $this->totalSortieEntrepot($date1, $date2, $format_id, $entrepot_id) - $this->perteEntrepot($date1, $date2, $format_id, $entrepot_id);
		return $total;
	}


	//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////


	public function totalMiseEnBoutique(string $date1, string $date2, int $boutique_id = null){
		$paras = "";
		if ($boutique_id != null) {
			$paras.= "AND boutique_id = $boutique_id ";
		}
		$requette = "SELECT SUM(quantite) as quantite  FROM lignemiseenboutique, produit, miseenboutique WHERE lignemiseenboutique.produit_id = produit.id AND produit.id = ? AND lignemiseenboutique.miseenboutique_id = miseenboutique.id AND miseenboutique.etat_id = ? AND lignemiseenboutique.created >= ? AND lignemiseenboutique.created <= ? $paras ";
		$item = LIGNEMISEENBOUTIQUE::execute($requette, [$this->id, ETAT::VALIDEE, $date1, $date2]);
		if (count($item) < 1) {$item = [new LIGNEMISEENBOUTIQUE()]; }
		return $item[0]->quantite;
	}


	public function enBoutique(string $date, int $boutique_id = null){
		$paras = "";
		if ($boutique_id != null) {
			$paras.= "AND boutique_id = $boutique_id ";
		}
		$total = $this->totalMiseEnBoutique(PARAMS::DATE_DEFAULT, $date) - ($this->enProspection($date) + $this->livree(PARAMS::DATE_DEFAULT, $date) + $this->vendu(PARAMS::DATE_DEFAULT, $date) + $this->perteProspection(PARAMS::DATE_DEFAULT, $date));
		return $total;
	}



	////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////



	public function enProspection(string $date, int $boutique_id = null){
		$paras = "";
		if ($boutique_id != null) {
			$paras.= "AND boutique_id = $boutique_id ";
		}
		$requette = "SELECT SUM(quantite) as quantite  FROM ligneprospection, produit, prospection WHERE ligneprospection.produit_id = produit.id AND produit.id = ? AND ligneprospection.prospection_id = prospection.id AND prospection.typeprospection_id = ? AND prospection.etat_id IN (?, ?) AND ligneprospection.created <= ? $paras GROUP BY produit.id";
		$item = LIGNEPROSPECTION::execute($requette, [$this->id, TYPEPROSPECTION::PROSPECTION, ETAT::ENCOURS, ETAT::PARTIEL, $date]);
		if (count($item) < 1) {$item = [new LIGNEPROSPECTION()]; }
		return $item[0]->quantite;
	}



	public function livree(string $date1, string $date2, int $boutique_id = null){
		$paras = "";
		if ($boutique_id != null) {
			$paras.= "AND boutique_id = $boutique_id ";
		}
		$requette = "SELECT SUM(quantite) as quantite  FROM ligneprospection, produit, prospection WHERE ligneprospection.produit_id = produit.id AND produit.id = ? AND ligneprospection.prospection_id = prospection.id AND prospection.typeprospection_id = ? AND prospection.etat_id != ? AND ligneprospection.created >= ? AND ligneprospection.created <= ? $paras GROUP BY produit.id";
		$item = LIGNEPROSPECTION::execute($requette, [$this->id, TYPEPROSPECTION::LIVRAISON, ETAT::ANNULEE, $date1, $date2]);
		if (count($item) < 1) {$item = [new LIGNEPROSPECTION()]; }
		return $item[0]->quantite;
	}



	public function perteProspection(string $date1, string $date2, int $boutique_id = null){
		$paras = "";
		if ($boutique_id != null) {
			$paras.= "AND boutique_id = $boutique_id ";
		}
		$requette = "SELECT SUM(perte) as perte  FROM ligneprospection, produit, prospection WHERE ligneprospection.produit_id = produit.id AND produit.id = ? AND ligneprospection.prospection_id = prospection.id AND prospection.etat_id != ? AND ligneprospection.created >= ? AND ligneprospection.created <= ? $paras GROUP BY produit.id";
		$item = LIGNEPROSPECTION::execute($requette, [$this->id, ETAT::ANNULEE, $date1, $date2]);
		if (count($item) < 1) {$item = [new LIGNEPROSPECTION()]; }
		return $item[0]->perte;
	}


	public function vendu(string $date1, string $date2, int $boutique_id = null){
		$paras = "";
		if ($boutique_id != null) {
			$paras.= "AND boutique_id = $boutique_id ";
		}
		$requette = "SELECT SUM(quantite) as quantite  FROM lignedevente, produit, vente WHERE lignedevente.produit_id = produit.id AND lignedevente.vente_id = vente.id AND produit.id = ? AND vente.etat_id != ? AND lignedevente.created >= ? AND lignedevente.created <= ? $paras GROUP BY produit.id";
		$item = LIGNEDEVENTE::execute($requette, [$this->id, ETAT::ANNULEE, $date1, $date2]);
		if (count($item) < 1) {$item = [new LIGNEDEVENTE()]; }
		return $item[0]->quantite;
	}


	// public function vendeDirecte(string $date1, string $date2, int $boutique_id = null){
	// 	$paras = "";
	//if ($boutique_id != null) {
	// 		$paras.= "AND boutique_id = $boutique_id ";
	// 	}
	// 	$requette = "SELECT SUM(quantite) as quantite  FROM lignedevente, produit, vente WHERE lignedevente.produit_id = produit.id AND lignedevente.vente_id = vente.id AND produit.id = ? AND  vente.etat_id != ? AND vente.typevente_id = ? AND vente.boutique_id =? AND  DATE(lignedevente.created) >= ? AND DATE(lignedevente.created) <= ? GROUP BY produit.id";
	// 	$item = LIGNEDEVENTE::execute($requette, [$this->id, ETAT::ANNULEE, TYPEVENTE::DIRECT, $boutique_id, $date1, $date2]);
	// 	if (count($item) < 1) {$item = [new LIGNEDEVENTE()]; }
	// 	$total += $item[0]->quantite;
	// 	return $total;
	// }


	// public function vendeProspection(string $date1, string $date2, int $boutique_id = null){
	// 	$total = 0;
	// 	$paras = "";
	//	if ($boutique_id != null) {
	// 		$requette = "SELECT SUM(quantite) as quantite  FROM lignedevente, produit, vente WHERE lignedevente.produit_id = produit.id AND lignedevente.vente_id = vente.id AND produit.id = ? AND  vente.etat_id != ? AND vente.boutique_id =?  AND vente.typevente_id = ? AND DATE(lignedevente.created) >= ? AND DATE(lignedevente.created) <= ? GROUP BY produit.id";

	// 		$item = LIGNEDEVENTE::execute($requette, [$this->id, ETAT::ANNULEE, $boutique_id, TYPEVENTE::PROSPECTION, $date1, $date2]);
	// 		if (count($item) < 1) {$item = [new LIGNEDEVENTE()]; }
	// 		$total += $item[0]->quantite;
	// 	}else{
	// 		$requette = "SELECT SUM(quantite) as quantite  FROM lignedevente, produit, vente WHERE lignedevente.produit_id = produit.id AND lignedevente.vente_id = vente.id AND produit.id = ? AND  vente.etat_id != ? AND vente.typevente_id = ? AND DATE(lignedevente.created) >= ? AND DATE(lignedevente.created) <= ? GROUP BY produit.id";

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
			if ($item->enBoutique(dateAjoute(), $boutique_id) > $params->ruptureStock) {
				unset($datas[$key]);
			}
		}
		return $datas;
	}


	public static function ruptureEntrepot(int $entrepot_id = null){
		$params = PARAMS::findLastId();
		$datas = static::findBy(["isActive ="=>TABLE::OUI]);
		foreach ($datas as $key => $item) {
			if ($item->enEntrepot(dateAjoute(), $entrepot_id) > $params->ruptureStock) {
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