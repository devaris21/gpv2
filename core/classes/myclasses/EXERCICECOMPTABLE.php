<?php
namespace Home;
use Native\RESPONSE;/**
 * 
 */
class EXERCICECOMPTABLE extends TABLE
{

	public static $tableName = __CLASS__;
	public static $namespace = __NAMESPACE__;


	public $datefin;
	public $etat_id = ETAT::ENCOURS;

	public function enregistre(){
		$data = new RESPONSE;
		$data = $this->save();
		return $data;
	}


	public static function encours(){
		$datas = EXERCICECOMPTABLE::findBy(["etat_id ="=>ETAT::ENCOURS]);
		if (count($datas) > 0) {
             return $datas[0];
		}else{
			$a = new EXERCICECOMPTABLE();
			$a->enregistre();
			return $a;
		}
	}


	public function name(){
		if ($this->etat_id == ETAT::ENCOURS) {
			return datecourt($this->created)." - aujourd'hui ";
		}else{
			return datecourt($this->created)." - ".datecourt($this->datefin);
		}
	}


	public function datefin(){
		if ($this->etat_id == ETAT::ENCOURS) {
			return dateAjoute();
		}else{
			return $this->datefin;
		}
	}



	public static function cloture(){
		$data = new RESPONSE;
		$datas = static::findBy(["etat_id !="=>ETAT::VALIDEE], [], ["id"=>"DESC"]);
		if(count($datas) == 1){
			$exercice = $datas[0];
			AMORTISSEMENT::cloture();

			$exercice->datefin = dateAjoute();
			$exercice->etat_id = ETAT::VALIDEE;
			$data = $exercice->save();

			EXERCICECOMPTABLE::encours();
		}else{
			$data->status = false;
			$data->message = "Une erreur s'est produite lors de l'operation, veuillez recommencer !";
		}
		return $data;
	}

	public function sentenseCreate(){
		return $this->sentense = "Nouvel exercice comptable :".$this->name();
	}
	public function sentenseUpdate(){
		return $this->sentense = "Modification des informations de l'exercice comptable $this->id : ".$this->name();
	}
	public function sentenseDelete(){
		return $this->sentense = "Suppression definitive de l'exercice comptable $this->id : ".$this->name();
	}
}
?>