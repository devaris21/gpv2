<?php
namespace Home;
use Native\RESPONSE;

/**
 * 
 */
class PERTEENTREPOT extends TABLE
{
	
	
	public static $tableName = __CLASS__;
	public static $namespace = __NAMESPACE__;


	public $typeperte_id;
	public $typeproduit_parfum_id;
	public $produit_id;
	public $emballage_id;
	public $ressource_id;
	public $etiquette_id;
	public $quantite;
	public $comment;
	public $entrepot_id;
	public $employe_id;
	public $etat_id = ETAT::VALIDEE;


	public function enregistre(){
		$data = new RESPONSE;
		$datas = TYPEPERTE::findBy(["id ="=>$this->typeperte_id]);
		if (count($datas) == 1) {
			if ($this->quantite > 0) {

				if ($this->typeproduit_parfum_id != null) {
					$item = new TYPEPRODUIT_PARFUM;
					$item->id = $this->typeproduit_parfum_id;
					$item->actualise();
					$stock = $item->enStock(PARAMS::DATE_DEFAULT, dateAjoute(1), getSession("entrepot_connecte_id"));

				}elseif ($this->produit_id != null) {
					$item = new PRODUIT;
					$item->id = $this->produit_id;
					$item->actualise();
					$stock = $item->enEntrepot(PARAMS::DATE_DEFAULT, dateAjoute(1), getSession("entrepot_connecte_id"));

				}elseif ($this->ressource_id != null) {
					$item = new RESSOURCE;
					$item->id = $this->ressource_id;
					$item->actualise();
					$stock = $item->stock(PARAMS::DATE_DEFAULT, dateAjoute(1), getSession("entrepot_connecte_id"));

				}elseif ($this->emballage_id != null) {
					$item = new EMBALLAGE;
					$item->id = $this->emballage_id;
					$item->actualise();
					$stock = $item->stock(PARAMS::DATE_DEFAULT, dateAjoute(1), getSession("entrepot_connecte_id"));

				}

				if ($stock >= $this->quantite) {
					$this->employe_id = getSession("employe_connecte_id");
					$this->entrepot_id = getSession("entrepot_connecte_id");
					$data = $this->save();
				}else{
					$data->status = false;
					$data->message = "La quantité perdue est plus élévé que celle que vous avez effectivement !";
				}
			}else{
				$data->status = false;
				$data->message = "Erreur sur la quantité perdue !";
			}
		}else{
			$data->status = false;
			$data->message = "Une erreur s'est produite lors  de l'opération, veuillez recommencer !";
		}
		return $data;
	}


	public function name(){
		$this->actualise();
		if ($this->typeproduit_parfum_id != null) {
			return $this->typeproduit_parfum->name();

		}elseif ($this->produit_id != null) {
			return $this->produit->name();

		}elseif ($this->ressource_id != null) {
			return $this->ressource->name();

		}elseif ($this->emballage_id != null) {
			return $this->emballage->name();
		}
	}





	public function sentenseCreate(){
		return $this->sentense = "Nouvelle perte dans ".$this->entrepot->name();
	}
	public function sentenseUpdate(){
		return $this->sentense = "Modification des informations de la perte en entrepot $this->id ";
	}
	public function sentenseDelete(){
		return $this->sentense = "Suppression definitive de la perte en entrepot $this->id";
	}

}

?>