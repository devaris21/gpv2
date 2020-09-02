<?php
namespace Home;
use Native\RESPONSE;
use Native\EMAIL;
/**
 * 
 */
class TRANSFERTSTOCKENTREPOT extends TABLE
{
	public static $tableName = __CLASS__;
	public static $namespace = __NAMESPACE__;

	/* cette classe n'est liée à aucune table; elle ne sert que d'interface pour les operations de tranfert de fonds */

	public $produit_id;
	public $quantite;
	public $emballage_id_source;
	public $quantite2;
	public $emballage_id_destination;
	public $comment;
	public $entrepot_id;
	public $employe_id;



	public function enregistre(){
		$data = new RESPONSE;
		$this->employe_id = getSession("employe_connecte_id");
		$this->entrepot_id = getSession("entrepot_connecte_id");
		$this->produit_id = getSession("produit_id");
		$datas = PRODUIT::findBy(["id ="=>$this->produit_id]);
		if (count($datas) == 1) {
			$produit = $datas[0];
			$datas = EMBALLAGE::findBy(["id ="=>$this->emballage_id_source]);
			if (count($datas) == 1) {
				$emb1 = $datas[0];
				$datas = EMBALLAGE::findBy(["id ="=>$this->emballage_id_destination]);
				if (count($datas) == 1) {
					$emb2 = $datas[0];
					if ($this->emballage_id_source != $this->emballage_id_destination){
						if ($this->quantite >= 1){
							if ($produit->enEntrepot(PARAMS::DATE_DEFAULT, dateAjoute(1), $this->emballage_id_source, getSession("entrepot_connecte_id")) >= $this->quantite) {
								$this->quantite2 = (int)($quantite * $emb1->nombre() / $emb2->nombre());
								if ($this->quantite2 >= 1){
									$data = $this->save();	
								}else{
									$data->status = false;
									$data->message = "la quantité à transferer est insuffisant !";
								}
							}
						}else{
							$data->status = false;
							$data->message = "Veuillez vérifier la quantité à transferer, veuillez recommencer !!";
						}
					}else{
						$data->status = false;
						$data->message = "Veuillez verifier l'emballage de destination !!";
					}
				}else{
					$data->status = false;
					$data->message = "Veuillez vérifier la quantité à transferer, veuillez recommencer !!";
				}
			}else{
				$data->status = false;
				$data->message = "Une erreur s'est produite lors de l'opération, veuillez recommencer !!";
			}
		}else{
			$data->status = false;
			$data->message = "Une erreur s'est produite lors de l'opération, veuillez recommencer !!";
		}
		return $data;
	}



	public function sentenseCreate(){}
	public function sentenseUpdate(){}
	public function sentenseDelete(){}

}



?>