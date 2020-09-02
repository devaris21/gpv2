<?php
namespace Home;
use Native\FICHIER;
use Native\RESPONSE;

/**
 * 
 */
class EMBALLAGE extends TABLE
{
	
	public static $tableName = __CLASS__;
	public static $namespace = __NAMESPACE__;

	const PRIMAIRE = 1;

	public $name ;
	public $quantite ;
	public $emballage_id ;
	public $isActive = TABLE::OUI;
	public $initial = 0;
	public $price = 0;
	public $image ;


	public function enregistre(){
		$data = new RESPONSE;
		if ($this->initial >= 0) {
			if ($this->name != "") {
				$data = $this->save();
				if ($data->status) {
					$this->uploading($this->files);
					foreach (PRODUIT::getAll() as $key => $produit) {
						$item = new PRICE;
						$item->produit_id = $produit->id;
						$item->emballage_id = $this->id;
						$item->prix = 200;
						$item->prix_gros = 200;
						$item->enregistre();
					}
				}
			}else{
				$data->status = false;
				$data->message = "Veuillez à bien renseigner le nime de l'emballage !";
			}
		}else{
			$data->status = false;
			$data->message = "Veuillez à bien renseigner le stock initial !";
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
						$result = $image->upload("images", "emballages", $a);
						$name = $tab[$i];
						$this->$name = $result->filename;
						$this->save();
					}
				}	
				$i++;			
			}			
		}
	}


	public function isPrimaire(){
		return ($this->emballage_id == null);
	} 


	public function nombre(){
		if ($this->emballage_id == null) {
			return $this->quantite;
		}
		$this->actualise();
		return $this->quantite * $this->emballage->nombre();
	}



	public function totalEmballagePrice(){
		$this->actualise();
		if ($this->emballage_id == null) {
			return $this->quantite * $this->price();
		}
		return $this->quantite * $this->emballage->totalEmballagePrice();
	}



	public function isDisponible(int $a = 1){
		$tab = [];
		if (getSession("emballages-disponibles") != null) {
			$tab = getSession("emballages-disponibles");
		}
		$this->actualise();
		if ($this->emballage_id == null) {
			$test = ($this->stock(PARAMS::DATE_DEFAULT, dateAjoute(1), getSession("entrepot_connecte_id")) >=  $a);
			$tab[$this->id] = (isset($tab[$this->id]))? intval($tab[$this->id]) + intval($a) : intval($a);
			session("emballages-disponibles", $tab);
			return $test;
		}
		$test = (($this->stock(PARAMS::DATE_DEFAULT, dateAjoute(1), getSession("entrepot_connecte_id")) >=  $a) && $this->emballage->isDisponible($this->emballage->quantite * $a));
		$tab[$this->id] = (isset($tab[$this->id]))? intval($tab[$this->id]) + intval($a) : intval($a);
		session("emballages-disponibles", $tab);
		return $test;
	}



	public function stock(String $date1, String $date2, int $entrepot_id = null){
		return $this->achat($date1, $date2, $entrepot_id) - $this->consommee($date1, $date2, $entrepot_id) - $this->perte($date1, $date2, $entrepot_id) + intval($this->initial);
	}


	public function achat(string $date1, string $date2, int $entrepot_id = null){
		$paras = "";
		if ($entrepot_id != null) {
			$paras.= "AND entrepot_id = $entrepot_id ";
		}
		$requette = "SELECT SUM(quantite_recu) as quantite  FROM ligneapproemballage, approemballage WHERE ligneapproemballage.emballage_id = ? AND ligneapproemballage.approemballage_id = approemballage.id AND approemballage.etat_id = ? AND DATE(approemballage.created) >= ? AND DATE(approemballage.created) <= ? $paras ";
		$item = LIGNEAPPROEMBALLAGE::execute($requette, [$this->id, ETAT::VALIDEE, $date1, $date2]);
		if (count($item) < 1) {$item = [new LIGNEAPPROEMBALLAGE()]; }
		return $item[0]->quantite;
	}



	public function consommee(string $date1, string $date2, int $entrepot_id = null){
		$paras = "";
		if ($entrepot_id != null) {
			$paras.= "AND entrepot_id = $entrepot_id ";
		}
		$requette = "SELECT SUM(ligneconditionnement.quantite) as quantite  FROM ligneconditionnement, conditionnement WHERE ligneconditionnement.emballage_id =  ? AND ligneconditionnement.conditionnement_id = conditionnement.id AND conditionnement.etat_id != ? AND DATE(conditionnement.created) >= ? AND DATE(conditionnement.created) <= ? $paras ";
		$item = LIGNECONDITIONNEMENT::execute($requette, [$this->id, ETAT::ANNULEE, $date1, $date2]);
		if (count($item) < 1) {$item = [new LIGNECONDITIONNEMENT()]; }
		return $item[0]->quantite;
	}



	public function perte(string $date1, string $date2, int $entrepot_id = null){
		$paras = "";
		if ($entrepot_id != null) {
			$paras.= "AND entrepot_id = $entrepot_id ";
		}
		$requette = "SELECT SUM(quantite) as quantite  FROM perteentrepot WHERE perteentrepot.emballage_id = ? AND perteentrepot.produit_id IS NULL AND perteentrepot.etat_id = ? AND DATE(perteentrepot.created) >= ? AND DATE(perteentrepot.created) <= ? $paras ";
		$item = PERTEENTREPOT::execute($requette, [$this->id, ETAT::VALIDEE, $date1, $date2]);
		if (count($item) < 1) {$item = [new PERTEENTREPOT()]; }
		return $item[0]->quantite;
	}




	public function price(){
			$requette = "SELECT SUM(quantite_recu) as quantite, SUM(transport) as transport, SUM(ligneapproemballage.price) as price FROM ligneapproemballage, approemballage WHERE ligneapproemballage.emballage_id = ? AND ligneapproemballage.approemballage_id = approemballage.id AND approemballage.etat_id = ? ";
			$datas = LIGNEAPPROVISIONNEMENT::execute($requette, [$this->id, ETAT::VALIDEE]);
			if (count($datas) < 1) {$datas = [new LIGNEAPPROVISIONNEMENT()]; }
			$item = $datas[0];

			$requette = "SELECT SUM(quantite_recu) as quantite FROM ligneapproemballage, approemballage WHERE ligneapproemballage.approemballage_id = approemballage.id AND approemballage.id IN (SELECT approemballage_id FROM ligneapproemballage WHERE ligneapproemballage.emballage_id = ? ) AND approemballage.etat_id = ? ";
			$datas = LIGNEAPPROVISIONNEMENT::execute($requette, [$this->id, ETAT::VALIDEE]);
			if (count($datas) < 1) {$datas = [new LIGNEAPPROVISIONNEMENT()]; }
			$ligne = $datas[0];

			if ($item->quantite == 0) {
				return 0;
			}
		if (intval($this->price) <= 0) {
			$total = ($item->price / $item->quantite) + ($item->transport / $ligne->quantite);
			return $total;
		}
		return $this->price + ($item->transport / $ligne->quantite);
	}



	public static function ruptureEntrepot(int $entrepot_id = null){
		$params = PARAMS::findLastId();
		$datas = static::findBy(["isActive ="=>TABLE::OUI]);
		foreach ($datas as $key => $item) {
			if ($item->stock(PARAMS::DATE_DEFAULT, dateAjoute(1), $entrepot_id) > $params->ruptureStock) {
				unset($datas[$key]);
			}
		}
		return $datas;
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