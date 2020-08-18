<?php
namespace Home;
use Native\RESPONSE;
use Native\EMAIL;
use Native\FICHIER;
/**
 * 
 */
class PARFUM extends TABLE
{
	public static $tableName = __CLASS__;
	public static $namespace = __NAMESPACE__;

	public $name;
	public $isActive = TABLE::OUI;


	public function enregistre(){
		$data = new RESPONSE;
		if ($this->name != "") {
			$data = $this->save();
			if ($data->status) {
				foreach (TYPEPRODUIT::findBy(["isActive ="=>TABLE::OUI]) as $key => $type) {
					foreach (QUANTITE::findBy(["isActive ="=>TABLE::OUI]) as $key => $quantite) {
						$ligne = new PRODUIT();
						$ligne->parfum_id = $this->id;
						$ligne->typeproduit_id = $type->id;
						$ligne->quantite_id = $quantite->id;
						$ligne->prix = 200;
						$ligne->prix_gros = 200;
						$ligne->enregistre();
					}
				}

			}
		}else{
			$data->status = false;
			$data->message = "Veuillez renseigner le nom du produit !";
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
						$result = $image->upload("images", "produits", $a);
						$name = $tab[$i];
						$this->$name = $result->filename;
						$this->save();
					}
				}	
				$i++;			
			}			
		}
	}


	public function quantiteProduite(string $date1 = "2020-06-01", string $date2, int $entrepot_id = null){
		if ($entrepot_id == null) {
			$requette = "SELECT SUM(quantite.name * ligneproductionjour.production) as name  FROM productionjour, ligneproductionjour, prixdevente, quantite, produit WHERE ligneproductionjour.produit_id = prixdevente.id AND ligneproductionjour.productionjour_id = productionjour.id AND prixdevente.produit_id = produit.id AND prixdevente.quantite_id = quantite.id AND produit.id = ? AND productionjour.etat_id != ? AND DATE(ligneproductionjour.created) >= ? AND DATE(ligneproductionjour.created) <= ? GROUP BY prixdevente.id";
			$item = QUANTITE::execute($requette, [$this->id, ETAT::ANNULEE, $date1, $date2]);
			if (count($item) < 1) {$item = [new QUANTITE()]; }
		}else{
			$requette = "SELECT SUM(quantite.name * ligneproductionjour.production) as name  FROM productionjour, ligneproductionjour, prixdevente, quantite, produit WHERE ligneproductionjour.produit_id = prixdevente.id AND ligneproductionjour.productionjour_id = productionjour.id AND prixdevente.produit_id = produit.id AND prixdevente.quantite_id = quantite.id AND produit.id = ? AND productionjour.etat_id != ? AND productionjour.entrepot_id = ? AND DATE(ligneproductionjour.created) >= ? AND DATE(ligneproductionjour.created) <= ? GROUP BY prixdevente.id";
			$item = QUANTITE::execute($requette, [$this->id, ETAT::ANNULEE, $entrepot_id, $date1, $date2]);
			if (count($item) < 1) {$item = [new QUANTITE()]; }
		}

		return $item[0]->name;
	}



	public function vendu(string $date1 = "2020-06-01", string $date2, int $boutique_id = null){
		$total = 0;
		if ($boutique_id == null) {
			$requette = "SELECT SUM(quantite.name) as name FROM lignedevente, prixdevente, vente, quantite, produit WHERE lignedevente.produit_id = prixdevente.id AND lignedevente.vente_id = vente.id AND prixdevente.id = ? AND vente.etat_id != ? AND prixdevente.quantite_id = quantite.id AND prixdevente.produit_id = produit.id AND DATE(lignedevente.created) >= ? AND DATE(lignedevente.created) <= ? GROUP BY prixdevente.id";
			$item = QUANTITE::execute($requette, [$this->id, ETAT::ANNULEE, $date1, $date2]);
			if (count($item) < 1) {$item = [new QUANTITE()]; }
		}else{
			$requette = "SELECT SUM(quantite.name) as name FROM lignedevente, prixdevente, vente, quantite, produit WHERE lignedevente.produit_id = prixdevente.id AND lignedevente.vente_id = vente.id AND prixdevente.id = ? AND vente.etat_id != ? AND prixdevente.quantite_id = quantite.id AND prixdevente.produit_id = produit.id AND DATE(lignedevente.created) >= ? AND DATE(lignedevente.created) <= ? GROUP BY prixdevente.id";
			$item = QUANTITE::execute($requette, [$this->id, ETAT::ANNULEE, $date1, $date2]);
			if (count($item) < 1) {$item = [new QUANTITE()]; }
		}
		$total += $item[0]->name;

		return $total;
	}



	public function sentenseCreate(){
		return $this->sentense = "Ajout d'un nouveau produit : $this->name dans les paramétrages";
	}
	public function sentenseUpdate(){
		return $this->sentense = "Modification des informations du produit $this->id : $this->name ";
	}
	public function sentenseDelete(){
		return $this->sentense = "Suppression definitive du produit $this->id : $this->name";
	}

}



?>