<?php
namespace Home;
use Native\RESPONSE;/**
 * 
 */
class EXIGENCEPRODUCTION extends TABLE
{

	public static $tableName = __CLASS__;
	public static $namespace = __NAMESPACE__;

	public $typeproduit_parfum_id;
	public $quantite = 0;



	public function enregistre(){
		$data = new RESPONSE;
		$datas = TYPEPRODUIT_PARFUM::findBy(["id ="=>$this->typeproduit_parfum_id]);
		if (count($datas) == 1) {
			if ($this->quantite >= 0 ) {
				$data = $this->save();
				if ($data->status) {
					foreach (RESSOURCE::getAll() as $key => $ressource) {
						$ligne = new LIGNEEXIGENCEPRODUCTION();
						$ligne->exigenceproduction_id = $this->id;
						$ligne->ressource_id = $ressource->id;
						$ligne->quantite = 0;
						$ligne->enregistre();
					}
				}
			}else{
				$data->status = false;
				$data->message = "La quantité entrée n'est pas correcte !";
			}
		}else{
			$data->status = false;
			$data->message = "Une erreur s'est produite lors de l'ajout du produit !";
		}
		return $data;
	}



	public function sentenseCreate(){
		return $this->sentense = "Creation d'une nouvelle exigence de production";
	}
	public function sentenseUpdate(){
		return $this->sentense = "Modification des informations de la exigence de production N°$this->id ";
	}
	public function sentenseDelete(){
		return $this->sentense = "Suppression definitive de la exigence de production N°$this->id";
	}


}
?>