<?php
namespace Home;
use Native\RESPONSE;
use Native\EMAIL;
/**
 * 
 */
class LIGNEPAYEJOUR extends TABLE
{
	public static $tableName = __CLASS__;
	public static $namespace = __NAMESPACE__;

	public $production_id;
	public $manoeuvre_id;
	public $montant = 0;



	public function enregistre(){
		$data = new RESPONSE;
		$datas = PRODUCTION::findBy(["id ="=>$this->production_id]);
		if (count($datas) == 1) {
			$datas = MANOEUVRE::findBy(["id ="=>$this->manoeuvre_id]);
			if (count($datas) == 1) {
				if ($this->montant >= 0) {
					$data = $this->save();
				}else{
					$data->status = false;
					$data->message = "Le montant entrée n'est pas correcte !";
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