<?php
namespace Home;
use Native\RESPONSE;/**
 * 
 */
class GROUPECOMMANDE extends TABLE
{

	public static $tableName = __CLASS__;
	public static $namespace = __NAMESPACE__;

	public $client_id;
	public $boutique_id;
	public $etat_id = ETAT::ENCOURS;
	

	public function enregistre(){
		return $data = $this->save();
	}


	public function resteAPayer(){
		$datas = $this->fourni("commande", ["etat_id !="=>ETAT::ANNULEE]);
		return comptage($datas, "reste", "somme");
	}


	public static function etat(){
		foreach (static::findBy(["etat_id ="=>ETAT::ENCOURS]) as $key => $groupe) {
			$test = false;
			foreach (PRODUIT::getAll() as $key => $produit) {
				if ($groupe->reste($produit->id) > 0) {
					$test = true;
					break;
				}
			}
			if (!$test) {
				$groupe->etat_id = ETAT::VALIDEE;
				$groupe->save();
			}
		}
	} 


	public function reste(int $produit_id){
		$total = 0;

		$requette = "SELECT SUM(quantite) as quantite FROM lignecommande, produit, commande, groupecommande WHERE lignecommande.produit_id = produit.id AND lignecommande.commande_id = commande.id AND commande.groupecommande_id = groupecommande.id AND groupecommande.id = ? AND commande.etat_id != ? AND produit.id = ? GROUP BY produit.id";
		$item = LIGNECOMMANDE::execute($requette, [$this->id, ETAT::ANNULEE, $produit_id]);
		if (count($item) < 1) {$item = [new LIGNECOMMANDE()]; }
		$total += $item[0]->quantite;

		// $requette = "SELECT SUM(quantite) as quantite FROM lignedevente, produit, vente, groupecommande WHERE lignedevente.produit_id = produit.id AND lignedevente.vente_id = vente.id AND vente.groupecommande_id = groupecommande.id AND groupecommande.id = ? AND vente.etat_id != ? AND produit.id = ? GROUP BY produit.id";
		// $item = LIGNEDEVENTE::execute($requette, [$this->id, ETAT::ANNULEE, $produit_id]);
		// if (count($item) < 1) {$item = [new LIGNEDEVENTE()]; }
		// $total -= $item[0]->quantite;

		$requette = "SELECT SUM(quantite_vendu) as quantite FROM ligneprospection, produit, prospection, groupecommande WHERE groupecommande.id = ? AND prospection.groupecommande_id = groupecommande.id AND ligneprospection.produit_id = produit.id AND ligneprospection.prospection_id = prospection.id AND prospection.etat_id != ? AND produit.id = ? GROUP BY produit.id";
		$item = LIGNEPROSPECTION::execute($requette, [$this->id, ETAT::ANNULEE, $produit_id]);
		if (count($item) < 1) {$item = [new LIGNEPROSPECTION()]; }
		$total -= $item[0]->quantite;

		return $total;
	}


	public function lesRestes(){
		$requette = "SELECT produit.id, SUM(quantite) as quantite FROM lignecommande, produit, commande WHERE lignecommande.produit_id = produit.id AND lignecommande.commande_id = commande.id AND commande.groupecommande_id =  ? AND commande.etat_id != ? GROUP BY produit.id";
		return PRODUIT::execute($requette, [$this->id, ETAT::ANNULEE]);
	}



	public function sentenseCreate(){}
	public function sentenseUpdate(){}
	public function sentenseDelete(){}


}
?>