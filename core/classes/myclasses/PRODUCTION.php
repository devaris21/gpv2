<?php
namespace Home;
use Native\RESPONSE;/**
 * 
 */
class PRODUCTION extends TABLE
{

	public static $tableName = __CLASS__;
	public static $namespace = __NAMESPACE__;

	public $reference;
	public $comment = "";
	public $maindoeuvre = 0;
	public $entrepot_id = ENTREPOT::PRINCIPAL;
	public $employe_id = 0;
	public $etat_id = ETAT::VALIDEE;


	public function enregistre(){
		$data = new RESPONSE;
		$this->employe_id = getSession("employe_connecte_id");
		$this->entrepot_id = getSession("entrepot_connecte_id");
		$datas = ENTREPOT::findBy(["id ="=>$this->entrepot_id]);
		if (count($datas) == 1) {
			$this->reference = "PROD/".date('dmY')."-".strtoupper(substr(uniqid(), 5, 6));
			$data = $this->save();
			if ($data->status && $this->transport > 0) {
				$this->actualise();
				$mouvement = new OPERATION();
				$mouvement->montant = $this->maindoeuvre;
				$mouvement->categorieoperation_id = CATEGORIEOPERATION::MAINDOEUVRE;
				$mouvement->modepayement_id = MODEPAYEMENT::ESPECE;
				$mouvement->comment = "Frais de main d'oeuvre pour la production N°".$this->reference;
				$data = $mouvement->enregistre();
			}
		}else{
			$data->status = false;
			$data->message = "Une erreur s'est produite lors de l'operation, veuillez recommencer !";
		}
		return $data;
	}





	public static function stats(string $date1 = "2020-04-01", string $date2, int $entrepot_id = null){
		$tableaux = [];
		$nb = ceil(dateDiffe($date1, $date2) / 12);
		$index = $date1;
		if ($entrepot_id == null) {
			while ( $index <= $date2 ) {
				
				$data = new \stdclass;
				$data->year = date("Y", strtotime($index));
				$data->month = date("m", strtotime($index));
				$data->day = date("d", strtotime($index));
				$data->nb = $nb;
			////////////

				$data->total = PRODUIT::totalProduit($date1, $index);
				// $data->marge = 0 ;

				$tableaux[] = $data;
			///////////////////////

				$index = dateAjoute1($index, ceil($nb));
			}
		}else{
			while ( $index <= $date2 ) {

				$data = new \stdclass;
				$data->year = date("Y", strtotime($index));
				$data->month = date("m", strtotime($index));
				$data->day = date("d", strtotime($index));
				$data->nb = $nb;
			////////////

				$data->total = PRODUIT::totalProduit($date1, $index, $entrepot_id);
				// $data->marge = 0 ;

				$tableaux[] = $data;
			///////////////////////

				$index = dateAjoute1($index, ceil($nb));
			}
		}
		return $tableaux;
	}



	public function sentenseCreate(){}
	public function sentenseUpdate(){}
	public function sentenseDelete(){}


}
?>