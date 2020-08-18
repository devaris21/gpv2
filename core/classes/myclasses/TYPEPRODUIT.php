<?php
namespace Home;
use Native\RESPONSE;/**
 * 
 */
class TYPEPRODUIT extends TABLE
{

	public static $tableName = __CLASS__;
	public static $namespace = __NAMESPACE__;
	
	public $name;
	public $isActive = TABLE::OUI;

	public function enregistre(){
		$data = new RESPONSE;
		if ($this->name != "") {
			$data = $this->save();
			if ($data->status) {

				foreach (PARFUM::findBy(["isActive ="=>TABLE::OUI]) as $key => $parfum) {
					foreach (QUANTITE::findBy(["isActive ="=>TABLE::OUI]) as $key => $quantite) {
						$ligne = new PRODUIT();
						$ligne->typeproduit_id = $this->id;
						$ligne->parfum_id = $parfum->id;
						$ligne->quantite_id = $quantite->id;
						$ligne->prix = 200;
						$ligne->prix_gros = 200;
						$ligne->enregistre();
					}
				}

				foreach (RESSOURCE::getAll() as $key => $ressource) {
					$datas = EXIGENCEPRODUCTION::findBy(["produit_id ="=>$data->lastid, "ressource_id ="=>$ressource->id]);
					if (count($datas) == 0) {
						$ligne = new EXIGENCEPRODUCTION();
						$ligne->produit_id = $data->lastid;
						$ligne->quantite_produit = 0;
						$ligne->ressource_id = $ressource->id;
						$ligne->quantite_ressource = 0;
						$ligne->enregistre();
					}					
				}

			}
		}else{
			$data->status = false;
			$data->message = "Veuillez renseigner le nom du type de ressource !";
		}
		return $data;
	}


	public function sentenseCreate(){
		return $this->sentense = "Ajout d'un nouveau type de ressource : $this->name dans les paramétrages";
	}
	public function sentenseUpdate(){
		return $this->sentense = "Modification des informations du type de ressource $this->id : $this->name ";
	}
	public function sentenseDelete(){
		return $this->sentense = "Suppression definitive du type de ressource $this->id : $this->name";
	}
}
?>