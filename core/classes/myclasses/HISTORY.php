<?php 
namespace Home;
use Native\RESPONSE;
/**
 * 
 */
class HISTORY extends TABLE
{

	public static $tableName = __CLASS__;
	public static $namespace = __NAMESPACE__;

	public $sentense; // phrase de l'historique
	public $employe_id;
	public $typeSave; //-1 delete, 0 create, 1 update
	public $record; //nom de la table
	public $recordId; //id de l'enregistrement


	public static function createHistory(TABLE $element, String $type_save){
		$sentense = $element->sentense;
		$element->actualise();
		$element->sentense = $sentense;

		extract($element::tableName());
		$story = new HISTORY;
		$story->record = $table;
		$story->recordId = $element->id;
		$story->typeSave = $type_save;
		$story->sentense =  $element->sentense;

		$story->employe_id = getSession("employe_connecte_id");

		if ($story->typeSave == "insert") {
			$story->sentense = $element->sentenseCreate();
		}else if ($story->typeSave == "delete") {
			$story->sentense = $element->sentenseDelete();
		}else if ($story->typeSave == "update") {
			$story->sentense = $element->sentenseUpdate();
		}

		if ($story->sentense != "") {
			$story->enregistre();
		}
	}
	
	
	public function enregistre(){
		$data = $this->save();
	}




	public function typeSave(){
		if ($this->typeSave == -1) {
			return "Insertion";

		}elseif ($this->typeSave == 0) {
			return "Mise à jour";

		}elseif ($this->typeSave == 1) {
			return "Suppression";

		}
	}




	public function sentenseCreate(){}
	public function sentenseUpdate(){}
	public function sentenseDelete(){}

}
?>