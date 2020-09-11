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
		$this->boutique_id = getSession("boutique_connecte_id");
		return $data = $this->save();
	}


	public function resteAPayer(){
		$total = 0;
		foreach ($this->fourni("commande", ["etat_id !="=>ETAT::ANNULEE]) as $key => $commande) {
			$total += $commande->reste();
		}
		return $total;
	}


	public static function etat(){
		foreach (static::findBy(["etat_id ="=>ETAT::ENCOURS]) as $key => $groupe) {
			$test = false;
			foreach ($groupe->toutesLesLignes() as $key => $ligne) {
				if ($groupe->reste($ligne->produit_id, $ligne->emballage_id) > 0) {
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


	public function reste(int $produit_id, int $emballage_id){
		$total = 0;

		$requette = "SELECT SUM(quantite) as quantite FROM lignecommande, commande WHERE lignecommande.produit_id = ? AND lignecommande.emballage_id = ? AND lignecommande.commande_id = commande.id AND commande.groupecommande_id = ? AND commande.etat_id != ? GROUP BY produit_id, emballage_id";
		$item = LIGNECOMMANDE::execute($requette, [$produit_id, $emballage_id, $this->id, ETAT::ANNULEE, ]);
		if (count($item) < 1) {$item = [new LIGNECOMMANDE()]; }
		$total += $item[0]->quantite;

		$requette = "SELECT SUM(quantite_vendu) as quantite FROM ligneprospection, prospection WHERE prospection.groupecommande_id = ? AND ligneprospection.produit_id = ? AND ligneprospection.emballage_id = ? AND ligneprospection.prospection_id = prospection.id AND prospection.etat_id != ? GROUP BY produit_id, emballage_id";
		$item = LIGNEPROSPECTION::execute($requette, [$this->id, $produit_id, $emballage_id, ETAT::ANNULEE]);
		if (count($item) < 1) {$item = [new LIGNEPROSPECTION()]; }
		$total -= $item[0]->quantite;

		return $total;
	}


	public function toutesLesLignes(){
		$requette = "SELECT produit_id, emballage_id, SUM(quantite) as quantite FROM lignecommande, commande WHERE lignecommande.commande_id = commande.id AND commande.groupecommande_id =  ? AND commande.etat_id != ? GROUP BY produit_id, emballage_id";
		return LIGNECOMMANDE::execute($requette, [$this->id, ETAT::ANNULEE]);
	}



	public function sentenseCreate(){}
	public function sentenseUpdate(){}
	public function sentenseDelete(){}


}
?>