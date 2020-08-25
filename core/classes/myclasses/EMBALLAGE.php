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
	public $image ;


	public function enregistre(){
		$data = new RESPONSE;
		if ($this->initial >= 0) {
			if ($this->name != "") {
				$data = $this->save();
				if ($data->status) {
					$this->uploading($this->files);
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
		$emballage = new EMBALLAGE();
		if ($this->emballage_id == null) {
			return $this->quantite * $this->price();
		}
		return $this->quantite * $this->emballage->totalEmballagePrice();
	}


	public function stock(String $date){
		return $this->achat("2020-06-01", $date) + intval($this->initial) - $this->consommee("2020-06-01", $date);
	}


	public function consommee(string $date1 = "2020-06-01", string $date2){
		$requette = "SELECT SUM(ligneproduction.quantite) as quantite  FROM production, ligneproduction, produit, quantite, emballage WHERE ligneproduction.produit_id = produit.id AND ligneproduction.production_id = production.id AND produit.quantite_id = quantite.id AND emballage.quantite_id = quantite.id AND  emballage.id = ? AND production.etat_id != ? AND DATE(ligneproduction.created) >= ? AND DATE(ligneproduction.created) <= ? GROUP BY emballage.id";
		$item = LIGNEPRODUCTION::execute($requette, [$this->id, ETAT::ANNULEE, $date1, $date2]);
		if (count($item) < 1) {$item = [new LIGNEPRODUCTION()]; }
		return $item[0]->quantite;
	}


	public function achat(string $date1 = "2020-04-01", string $date2){
		$total = 0;
		$requette = "SELECT SUM(quantite_recu) as quantite  FROM ligneapproemballage, emballage, approemballage WHERE ligneapproemballage.emballage_id = emballage.id AND emballage.id = ? AND ligneapproemballage.approemballage_id = approemballage.id AND approemballage.etat_id = ? AND DATE(approemballage.created) >= ? AND DATE(approemballage.created) <= ? GROUP BY emballage.id";
		$item = LIGNEAPPROEMBALLAGE::execute($requette, [$this->id, ETAT::VALIDEE, $date1, $date2]);
		if (count($item) < 1) {$item = [new LIGNEAPPROEMBALLAGE()]; }
		return $item[0]->quantite;
	}



	public function en_cours(){
		$total = 0;
		$requette = "SELECT SUM(quantite) as quantite  FROM ligneapproemballage, emballage, approemballage WHERE ligneapproemballage.emballage_id = emballage.id AND emballage.id = ? AND ligneapproemballage.approemballage_id = approemballage.id AND approemballage.etat_id = ? GROUP BY emballage.id";
		$item = LIGNEAPPROEMBALLAGE::execute($requette, [$this->id, ETAT::ENCOURS]);
		if (count($item) < 1) {$item = [new LIGNEAPPROEMBALLAGE()]; }
		return $item[0]->quantite;
	}



	public function exigence(int $quantite, int $produit_id){
		$datas = EXIGENCEPRODUCTION::findBy(["emballage_id ="=>$this->id, "produit_id ="=>$produit_id]);
		if (count($datas) == 1) {
			$item = $datas[0];
			if ($item->quantite_emballage == 0) {
				return 0;
			}
			return ($quantite * $item->quantite_produit) / $item->quantite_emballage;
		}
		return 0;
	}



	public function price(){
		$total = 0;
		$requette = "SELECT SUM(quantite_recu) as quantite, SUM(ligneapproemballage.price) as price FROM ligneapproemballage, emballage, approemballage WHERE ligneapproemballage.emballage_id = emballage.id AND emballage.id = ? AND ligneapproemballage.approemballage_id = approemballage.id AND approemballage.etat_id = ? GROUP BY emballage.id";
		$item = LIGNEAPPROEMBALLAGE::execute($requette, [$this->id, ETAT::VALIDEE]);
		if (count($item) < 1) {$item = [new LIGNEAPPROEMBALLAGE()]; }
		if ($item[0]->quantite > 0) {
			$total += $item[0]->price / $item[0]->quantite;
			return $total;
		}
		return 0;
	}



	public static function rupture(){
		$params = PARAMS::findLastId();
		$datas = static::findBy(["isActive ="=>TABLE::OUI]);
		foreach ($datas as $key => $item) {
			if ($item->enEntrepot(dateAjoute()) > $params->ruptureStock) {
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