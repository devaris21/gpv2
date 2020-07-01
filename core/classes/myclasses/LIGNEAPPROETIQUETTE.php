<?php
namespace Home;
use Native\RESPONSE;
use Native\EMAIL;
/**
 * 
 */
class LIGNEAPPROETIQUETTE extends TABLE
{
	public static $tableName = __CLASS__;
	public static $namespace = __NAMESPACE__;

	public $approetiquette_id;
	public $etiquette_id;
	public $quantite = 0;
	public $quantite_recu = 0;
	public $price = 0;



	public function enregistre(){
		$data = new RESPONSE;
		$datas = APPROETIQUETTE::findBy(["id ="=>$this->approetiquette_id]);
		if (count($datas) == 1) {
			$datas = ETIQUETTE::findBy(["id ="=>$this->etiquette_id]);
			if (count($datas) == 1) {
				if ($this->quantite > 0 ) {
					$this->quantite_recu = $this->quantite;
					if ($this->price >= 0 ) {
						$data = $this->save();
					}else{
						$data->status = false;
						$data->message = "La prix d'achat entrée n'est pas correcte !";
					}
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