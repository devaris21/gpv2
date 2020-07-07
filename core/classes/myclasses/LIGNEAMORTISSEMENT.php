<?php
namespace Home;
use Native\RESPONSE;
use Native\EMAIL;
/**
 * 
 */
class LIGNEAMORTISSEMENT extends TABLE
{
	public static $tableName = __CLASS__;
	public static $namespace = __NAMESPACE__;

	public $amortissement_id;
	public $exercicecomptable_id;
	public $montant;
	public $restait = 0;



	public function enregistre(){
		$data = new RESPONSE;
		$exercicecomptable = EXERCICECOMPTABLE::findLastId();
		$datas = AMORTISSEMENT::findBy(["id ="=>$this->amortissement_id]);
		if (count($datas) == 1) {
			$this->exercicecomptable_id = $exercicecomptable->id;
			$data = $this->save();
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