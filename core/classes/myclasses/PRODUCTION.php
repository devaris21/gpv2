<?php
namespace Home;
use Native\RESPONSE;/**
 * 
 */
class PRODUCTION extends TABLE
{

	public static $tableName = __CLASS__;
	public static $namespace = __NAMESPACE__;

	public $reference;
	public $comment = "";
	public $groupemanoeuvre_id = 0;
	public $entrepot_id = ENTREPOT::PRINCIPAL;
	public $employe_id = 0;
	public $etat_id = ETAT::ENCOURS;


	public function enregistre(){
		$data = new RESPONSE;
		$this->employe_id = getSession("employe_connecte_id");
		$this->entrepot_id = getSession("entrepot_connecte_id");
		$datas = ENTREPOT::findBy(["id ="=>$this->entrepot_id]);
		if (count($datas) == 1) {
			$this->reference = "PROD/".date('dmY')."-".strtoupper(substr(uniqid(), 5, 6));
			$data = $this->save();
		}else{
			$data->status = false;
			$data->message = "Une erreur s'est produite lors de l'ajout du produit !";
		}
		return $data;
	}



	public static function enStock(string $date1, string $date2, int $typeproduit_parfum_id, int $entrepot_id = null){
		$paras = "";
		if ($entrepot_id != null) {
			$paras.= "AND entrepot_id = $entrepot_id ";
		}
		$requette = "SELECT SUM(quantite) as quantite  FROM ligneproduction, production WHERE  ligneproduction.typeproduit_parfum_id = ?  AND ligneproduction.production_id = production.id AND production.etat_id = ? AND ligneproduction.created >= ? AND ligneproduction.created <= ? $paras";
		$item = LIGNEPRODUCTION::execute($requette, [$typeproduit_parfum_id, ETAT::VALIDEE, $date1, $date2]);
		if (count($item) < 1) {$item = [new LIGNEPRODUCTION()]; }
		$total = $item[0]->quantite;

		$requette = "SELECT SUM(quantite) as quantite  FROM conditionnement WHERE  conditionnement.typeproduit_parfum_id = ? AND conditionnement.etat_id = ? AND conditionnement.created >= ? AND conditionnement.created <= ? $paras";
		$item = CONDITIONNEMENT::execute($requette, [$typeproduit_parfum_id, ETAT::VALIDEE, $date1, $date2]);
		if (count($item) < 1) {$item = [new CONDITIONNEMENT()]; }
		$total -= $item[0]->quantite;
		return $total;
	}


	public function sentenseCreate(){}
	public function sentenseUpdate(){}
	public function sentenseDelete(){}


}
?>