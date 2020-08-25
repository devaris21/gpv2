<?php
namespace Home;
use Native\RESPONSE;
use Native\EMAIL;
/**
 * 
 */
class LIGNECONDITIONNEMENT extends TABLE
{
	public static $tableName = __CLASS__;
	public static $namespace = __NAMESPACE__;

	public $conditionnement_id;
	public $produit_id;
	public $emballage_id;
	public $quantite = 0;



	public function enregistre(){
		$data = new RESPONSE;
		$datas = CONDITIONNEMENT::findBy(["id ="=>$this->conditionnement_id]);
		if (count($datas) == 1) {
			$datas = PRODUIT::findBy(["id ="=>$this->produit_id]);
			if (count($datas) == 1) {
				$datas = EMBALLAGE::findBy(["id ="=>$this->emballage_id]);
				if (count($datas) == 1) {
					if ($this->quantite >= 0) {
						$data = $this->save();
					}else{
						$data->status = false;
						$data->message = "La quantité entrée n'est pas correcte !";
					}
				}else{
					$data->status = false;
					$data->message = "Une erreur s'est produite lors de l'ajout du produit !";
				}
			}else{
				$data->status = false;
				$data->message = "Une erreur s'est produite lors de l'ajout du produit !";
			}
		}else{
			$data->status = false;
			$data->message = "Une erreur s'est produite lors de l'ajout du produit !";
		}
		return $data;
	}




	public function sentenseCreate(){
		
	}


	public function sentenseUpdate(){
	}


	public function sentenseDelete(){
	}

}



?>