<?php
namespace Home;
use Native\RESPONSE;
use Native\FICHIER;
/**
 * 
 */
class FORMATEMBALLAGE extends TABLE
{

	public static $tableName = __CLASS__;
	public static $namespace = __NAMESPACE__;

	const PRIMAIRE = 1;
	
	public $name;
	public $formatemballage_id;
	public $quantite;
	public $initial;
	public $image;
	public $isActive = TABLE::OUI;

	public function enregistre(){
		$data = new RESPONSE;
		if ($this->name != "") {
			$data = $this->save();
			if ($data->status) {
				$this->uploading($this->files);

				$emballage = new EMBALLAGE;
				$emballage->name = "Emballlage de ".$this->name();
				$emballage->formatemballage_id = $this->id;
				$emballage->enregistre();
			}
		}else{
			$data->status = false;
			$data->message = "Veuillez renseigner le nom du type de ressource !";
		}
		return $data;
	}


	public function uploading(Array $files){
		//les proprites d'images;
		$tab = ["image"];
		if (is_array($files) && count($files) > 0) {
			$i = 0;
			foreach ($files as $key => $file) {
				if ($file["tmp_name"] != "") {
					$image = new FICHIER();
					$image->hydrater($file);
					if ($image->is_image()) {
						$a = substr(uniqid(), 5);
						$result = $image->upload("images", "formatemballages", $a);
						$name = $tab[$i];
						$this->$name = $result->filename;
						$this->save();
					}
				}	
				$i++;			
			}			
		}
	}



	public function nombre(){
		if ($this->formatemballage_id == null) {
			return $this->quantite;
		}
		$this->actualise();
		return $this->quantite * $this->formatemballage->nombre();
	}


	public function price(){
		$this->actualise();
		$emballage = new EMBALLAGE();
		$datas = $this->fourni("emballage");
		if (count($datas) > 0) {
			$emballage = $datas[0];
		}
		if ($this->formatemballage_id == null) {
			return $this->quantite * $emballage->price();
		}
		return $this->quantite * $this->formatemballage->price();
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