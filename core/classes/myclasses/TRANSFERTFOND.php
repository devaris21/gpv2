<?php
namespace Home;
use Native\RESPONSE;
use Native\EMAIL;
/**
 * 
 */
class TRANSFERTFOND extends TABLE
{
	public static $tableName = __CLASS__;
	public static $namespace = __NAMESPACE__;

	/* cette classe n'est liée à aucune table; elle ne sert que d'interface pour les operations de tranfert de fonds */

	public $montant;
	public $comptebanque_id_source;
	public $comptebanque_id_destination;
	public $comment;
	public $employe_id;



	public function enregistre(){
		$data = new RESPONSE;
		$datas = COMPTEBANQUE::findBy(["id ="=>$this->comptebanque_id_source]);
		if (count($datas) == 1) {
			$source = $datas[0];
			$datas = COMPTEBANQUE::findBy(["id ="=>$this->comptebanque_id_destination]);
			if (count($datas) == 1) {
				$destinataire = $datas[0];
				$data = $source->transaction($this->montant, $destinataire, $this->comment);
				if ($data->status) {
					$this->employe_id = getSession("employe_connecte_id");
					$data = $this->save() ;
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