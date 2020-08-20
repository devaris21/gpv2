<?php
namespace Home;
use Native\RESPONSE;
use Native\EMAIL;
/**
 * 
 */
class LIGNEPRODUCTION extends TABLE
{
	public static $tableName = __CLASS__;
	public static $namespace = __NAMESPACE__;

	public $production_id;
	public $parfum_id;
	public $typeproduit_id;
	public $quantite = 0;



	public function enregistre(){
		$data = new RESPONSE;
		$datas = PRODUCTION::findBy(["id ="=>$this->production_id]);
		if (count($datas) == 1) {
			$datas = PARFUM::findBy(["id ="=>$this->parfum_id]);
			if (count($datas) == 1) {
				$datas = TYPEPRODUIT::findBy(["id ="=>$this->typeproduit_id]);
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