<?php
namespace Home;
use Native\RESPONSE;/**
 * 
 */
abstract class TRESORERIE extends TABLE
{

	public static $tableName = __CLASS__;
	public static $namespace = __NAMESPACE__;



	public static function chiffreAffaire(string $date1, string $date2, int $agence_id = null){
		if ($date1 == null) {
			$date1 = PARAMS::DATE_DEFAULT;
		}
		if ($date2 == null) {
			$date2 = dateAjoute(1);
		}
		return  REGLEMENTCLIENT::total($date1, $date2, getSession("agence_connecte_id")) + CLIENT::dettes();
	}


	public function montant(int $montant){
		if ($this->typeremise_id = TYPEREMISE::BRUT) {
			return $this->remise;
		}else{
			return round(($this->remise * $montant) / 100);
		}
	}


	public function sentenseCreate(){
		return $this->sentense = "Ajout d'une nouvel accessoire: $this->name dans les paramétrages";
	}
	public function sentenseUpdate(){
		return $this->sentense = "Modification des informations de l'accessoire $this->id : $this->name ";
	}
	public function sentenseDelete(){
		return $this->sentense = "Suppression definitive de l'accessoire $this->id : $this->name";
	}
}
?>