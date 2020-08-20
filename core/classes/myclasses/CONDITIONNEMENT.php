<?php
namespace Home;
use Native\RESPONSE;/**
 * 
 */
class CONDITIONNEMENT extends TABLE
{

	public static $tableName = __CLASS__;
	public static $namespace = __NAMESPACE__;

	public $reference ;
	public $entrepot_id = ENTREPOT::PRINCIPAL;
	public $parfum_id;
	public $typeproduit_id;
	public $quantite = 0;
	public $comment = "";
	public $employe_id = 0;
	public $etat_id = ETAT::VALIDEE;


	public function enregistre(){
		$data = new RESPONSE;
		$this->employe_id = getSession("employe_connecte_id");
		$this->boutique_id = getSession("entrepot_connecte_id");
		$datas = ENTREPOT::findBy(["id ="=>$this->entrepot_id]);
		if (count($datas) == 1) {
			$datas = PARFUM::findBy(["id ="=>$this->parfum_id]);
			if (count($datas) == 1) {
				$datas = TYPEPRODUIT::findBy(["id ="=>$this->typeproduit_id]);
				if (count($datas) == 1) {
					if ($this->quantite >= 0) {
						$this->reference = "COND/".date('dmY')."-".strtoupper(substr(uniqid(), 5, 6));
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



	public function sentenseCreate(){}
	public function sentenseUpdate(){}
	public function sentenseDelete(){}


}
?>