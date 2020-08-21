<?php
namespace Home;
use Native\RESPONSE;

/**
 * 
 */
class TYPEPRODUIT_PARFUM extends TABLE
{
	
	
	public static $tableName = __CLASS__;
	public static $namespace = __NAMESPACE__;


	public $parfum_id;
	public $typeproduit_id;
	public $isActive = TABLE::NON;


	public function enregistre(){
		$data = new RESPONSE;
		$datas = PARFUM::findBy(["id ="=>$this->parfum_id]);
		if (count($datas) == 1) {
			$datas = TYPEPRODUIT::findBy(["id ="=>$this->typeproduit_id]);
			if (count($datas) == 1) {
				$data = $this->save();
				if ($data->status) {
					foreach (QUANTITE::getAll() as $key => $quantite) {
						$ligne = new PRODUIT();
						$ligne->typeproduit_parfum_id = $this->id;
						$ligne->quantite_id = $quantite->id;
						$ligne->prix = 200;
						$ligne->prix_gros = 200;
						$ligne->enregistre();
					}

					$ligne = new EXIGENCEPRODUCTION();
					$ligne->typeproduit_parfum_id = $this->id;
					$ligne->quantite = 0;
					$ligne->enregistre();
				}
			}else{
				$data->status = false;
				$data->message = "Une erreur s'est produite lors du prix !";
			}
		}else{
			$data->status = false;
			$data->message = "Une erreur s'est produite lors du prix !";
		}
		return $data;
	}



	public function name(){
		return $this->typeproduit->name()." de ".$this->parfum->name();
	}




	public function changerMode(){
		if ($this->isActive == TABLE::OUI) {
			$this->isActive = TABLE::NON;
		}else{
			$this->isActive = TABLE::OUI;
			$pro = PRODUCTION::today();
			$datas = LIGNEPRODUCTION::findBy(["production_id ="=>$pro->id, "produit_id ="=>$pdv->id]);
			if (count($datas) == 0) {
				$ligne = new LIGNEPRODUCTION();
				$ligne->production_id = $pro->id;
				$ligne->produit_id = $pdv->id;
				$ligne->enregistre();
			}			
		}
		return $this->save();
	}



	public function sentenseCreate(){}
	public function sentenseUpdate(){}
	public function sentenseDelete(){}
}

?>