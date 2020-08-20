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



	public static function enStock(string $date1, string $date2, int $typeproduit_id, int $parfum_id, int $entrepot_id = null){
		$paras = "";
		if ($entrepot_id != null) {
			$paras.= "AND entrepot_id = $entrepot_id ";
		}
		$requette = "SELECT SUM(quantite) as quantite  FROM ligneproduction, production WHERE  ligneproduction.typeproduit_id = ? AND ligneproduction.parfum_id = ? AND ligneproduction.production_id = production.id AND production.etat_id = ? AND ligneproduction.created >= ? AND ligneproduction.created <= ? $paras";
		$item = LIGNEPRODUCTION::execute($requette, [$typeproduit_id, $parfum_id, ETAT::VALIDEE, $date1, $date2]);
		if (count($item) < 1) {$item = [new LIGNEPRODUCTION()]; }
		$total = $item[0]->quantite;

		$requette = "SELECT SUM(quantite) as quantite  FROM conditionnement WHERE  conditionnement.typeproduit_id = ? AND conditionnement.parfum_id = ? AND conditionnement.etat_id = ? AND conditionnement.created >= ? AND conditionnement.created <= ? $paras";
		$item = CONDITIONNEMENT::execute($requette, [$typeproduit_id, $parfum_id, ETAT::VALIDEE, $date1, $date2]);
		if (count($item) < 1) {$item = [new CONDITIONNEMENT()]; }
		$total -= $item[0]->quantite;
		return $total;
	}


	public static function today(){
		$datas = static::findBy(["ladate ="=>dateAjoute()]);
		if (count($datas) > 0) {
			$pro = $datas[0];

			if (count($pro->fourni("ligneproduction")) == 0) {
				foreach (PRODUIT::getAll() as $key => $pdv) {
					$ligne = new LIGNEPRODUCTION();
					$ligne->production_id = $pro->id;
					$ligne->produit_id = $pdv->id;
					$ligne->enregistre();
				}
			}

			if (count($pro->fourni("ligneconsommationjour")) == 0) {
				foreach (RESSOURCE::getAll() as $key => $ressource) {
					$ligne = new LIGNECONSOMMATIONJOUR();
					$ligne->production_id = $pro->id;
					$ligne->ressource_id = $ressource->id;
					$ligne->enregistre();
				}
			}


			if (count($pro->fourni("ligneetiquettejour")) == 0) {
				foreach (ETIQUETTE::getAll() as $key => $ressource) {
					$ligne = new LIGNEETIQUETTEJOUR();
					$ligne->production_id = $pro->id;
					$ligne->etiquette_id = $ressource->id;
					$ligne->enregistre();
				}
			}

			return $pro;
		}else{
			$ti = new PRODUCTION();
			$data = $ti->enregistre();
			if ($data->status) {
				foreach (PRODUIT::getAll() as $key => $produit) {
					$ligne = new LIGNEPRODUCTION();
					$ligne->production_id = $data->lastid;
					$ligne->produit_id = $produit->id;
					$ligne->enregistre();
				}

				foreach (RESSOURCE::getAll() as $key => $ressource) {
					$ligne = new LIGNECONSOMMATIONJOUR();
					$ligne->production_id = $data->lastid;
					$ligne->ressource_id = $ressource->id;
					$ligne->enregistre();
				}
				

				foreach (ETIQUETTE::getAll() as $key => $ressource) {
					$ligne = new LIGNEETIQUETTEJOUR();
					$ligne->production_id = $data->lastid;
					$ligne->etiquette_id = $ressource->id;
					$ligne->enregistre();
				}
			}
			return $ti;
		}
	}



	public static function ranges(){
		return static::findBy(["etat_id ="=>ETAT::VALIDEE]);
	}

	public function sentenseCreate(){}
	public function sentenseUpdate(){}
	public function sentenseDelete(){}


}
?>