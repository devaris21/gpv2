<?php
namespace Home;
use Native\RESPONSE;

/**
 * 
 */
class PERTEBOUTIQUE extends TABLE
{
	
	
	public static $tableName = __CLASS__;
	public static $namespace = __NAMESPACE__;


	public $typeperte_id;
	public $produit_id;
	public $emballage_id;
	public $quantite;
	public $comment;
	public $boutique_id;
	public $employe_id;
	public $etat_id = ETAT::VALIDEE;


	public function enregistre(){
		$data = new RESPONSE;
		$datas = TYPEPERTE::findBy(["id ="=>$this->typeperte_id]);
		if (count($datas) == 1) {
			if ($this->quantite > 0) {
				$datas = PRICE::findBy(["produit_id ="=>$this->produit_id, "emballage_id ="=>$this->emballage_id]);
				if (count($datas) > 0) {
					$item = $datas[0];
					$item->actualise();
					$stock = $item->produit->enBoutique(PARAMS::DATE_DEFAULT, dateAjoute(1), $this->emballage_id, getSession("boutique_connecte_id"));
					if ($stock >= $this->quantite) {
						$this->employe_id = getSession("employe_connecte_id");
						$this->boutique_id = getSession("boutique_connecte_id");
						$data = $this->save();
					}else{
						$data->status = false;
						$data->message = "La quantité perdue est plus élévé que celle que vous avez effectivement !";
					}
				}else{
					$data->status = false;
					$data->message = "Le produit dans ce format n'existe pas !";
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
		return $this->produit->name()."<br>".$this->emballage->name();
	}




	public function sentenseCreate(){}
	public function sentenseUpdate(){}
	public function sentenseDelete(){}
}

?>