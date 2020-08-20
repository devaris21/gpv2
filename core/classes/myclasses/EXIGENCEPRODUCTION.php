<?php
namespace Home;
use Native\RESPONSE;/**
 * 
 */
class EXIGENCEPRODUCTION extends TABLE
{

	public static $tableName = __CLASS__;
	public static $namespace = __NAMESPACE__;

	public $produit_id;
	public $quantite_produit = 0;

	public $ressource_id;
	public $quantite_ressource = 0;
	



	public function enregistre(){
		$data = new RESPONSE;
		$datas = RESSOURCE::findBy(["id ="=>$this->ressource_id]);
		if (count($datas) == 1) {
			$datas = PRODUIT::findBy(["id ="=>$this->produit_id]);
			if (count($datas) == 1) {
				if ($this->quantite_produit >= 0 && $this->quantite_ressource >= 0) {
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
		return $data;
	}




	public static function today(){
		$datas = static::findBy(["ladate ="=>dateAjoute()]);
		if (count($datas) > 0) {
			return $datas[0];
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
			}
			return $ti;
		}
	}


	public function sentenseCreate(){}
	public function sentenseUpdate(){}
	public function sentenseDelete(){}


}
?>